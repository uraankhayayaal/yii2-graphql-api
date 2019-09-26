<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use phpDocumentor\Reflection\Types\Boolean;
use yii\console\Controller;
use yii\console\ExitCode;

class FakerController extends Controller
{
    public const postsCount = 100;
    public const commentsCount = 12;
    public $faker = null;

    public function actionIndex($message = 'hello world')
    {
        $this->faker = \Faker\Factory::create();

        $this->generatePosts();

        return ExitCode::OK;
    }

    protected function generatePosts(){
        for ($i=0; $i < self::postsCount; $i++) { 
            $model = new \app\models\Post();
            $model->title = $this->faker->sentences($nb = 1, $asText = true);
            $model->body = $this->faker->realText($maxNbChars = rand(400,700), $indexSize = rand(2,5));
            $model->is_public = 1;
            $model->created_at = time();
            if($model->save()){
                echo "New Post: ".$model->id."\n";
                $this->generateComments($model->id);
            }else{
                echo "Error: ".var_dump($model->errors);
            };
        }
    }

    protected function generateComments($post_id = 0){
        for ($i=0; $i < self::commentsCount; $i++) { 
            $model = new \app\models\Comment();
            $model->text = $this->faker->text($maxNbChars = rand(100,255));
            $model->post_id = $post_id;
            $model->created_at = time();
            if($model->save()){
                echo "New Comment: ".$model->id."\n";
            }else{
                echo "Error: ".var_dump($model->errors);
            };
        }
    }
}