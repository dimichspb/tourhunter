<?php
namespace app\bootstrap;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\db\Connection;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->set(Connection::class, \Yii::$app->db);
    }

}