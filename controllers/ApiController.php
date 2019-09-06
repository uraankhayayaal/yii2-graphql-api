<?php

namespace app\controllers;

use Yii;

use app\models\schema\Types;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use yii\base\InvalidParamException;
use yii\helpers\Json;

use GraphQL\Error\Debug;
use GraphQL\Validator\Rules;

class ApiController extends \yii\rest\ActiveController // Наследуемся от RESTController
{
    // REST ActiveController требует, чтобы был указан $modelClass
    public $modelClass = '';

    // Разрешаем только POST и OPTIONS
    // OPTIONS нужен для запросов проверки CROS
    protected function verbs()
    {
        return [
            'index' => ['POST', 'OPTIONS'],
        ];
    }

    // Переписываем дефолтные экшены
    public function actions()
    {
        return [];
    }

    // Настраиваем CROS
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['http://smart.loc'], // 'http://smart.loc'
                    'Access-Control-Allow-Methods' => ['POST'],
                    'Access-Control-Allow-Headers' => ['Content-Type, Authorization'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        // сразу заложим возможность принимать параметры
        // как через MULTIPART, так и через POST/GET

        $query = \Yii::$app->request->get('query', \Yii::$app->request->post('query'));
        $variables = \Yii::$app->request->get('variables', \Yii::$app->request->post('variables'));
        $operation = \Yii::$app->request->get('operation', \Yii::$app->request->post('operation', null));

        if (empty($query)) {
            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variables = isset($input['variables']) ? $input['variables'] : [];
            $operation = isset($input['operation']) ? $input['operation'] : null;
        }

        // библиотека принимает в variables либо null, либо ассоциативный массив
        // на строку будет ругаться

        if (!empty($variables) && !is_array($variables)) {
            try {
                $variables = Json::decode($variables);
            } catch (InvalidParamException $e) {
                $variables = null;
            }
        }

        // создаем схему и подключаем к ней наши корневые типы

        $schema = new Schema([
            'query' => Types::query(),
            'mutation' => Types::mutation(),
        ]);

        $result = GraphQL::executeQuery(
            $schema,
            $query,
            null,
            null,
            empty($variables) ? null : $variables,
            empty($operation) ? null : $operation
        )->toArray(Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE);

        return $result;
    }
}
