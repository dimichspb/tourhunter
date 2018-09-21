<?php
namespace app\bootstrap;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\db\Connection;
use yii\web\User;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->set(Connection::class, \Yii::$app->db);
        $container->set(User::class, \Yii::$app->user);
    }

}