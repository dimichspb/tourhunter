<?php

namespace app\modules\rbac\tests\unit;

use app\modules\rbac\forms\LoginForm;
use app\modules\rbac\models\User;

class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;

    protected function _after()
    {
        \Yii::$app->user->logout();
        User::deleteAll();
    }


}
