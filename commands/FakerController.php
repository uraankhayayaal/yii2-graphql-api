<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class FakerController extends Controller
{
    public function actionIndex($message = 'hello world')
    {
        $faker = \Faker\Factory::create();
        echo $faker->name . "\n";

        return ExitCode::OK;
    }
}
