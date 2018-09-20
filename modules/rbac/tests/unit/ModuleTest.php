<?php
namespace app\modules\rbac\tests\unit;

use app\modules\rbac\forms\LoginForm;
use app\modules\rbac\models\User;
use app\modules\rbac\Module;
use Codeception\Test\Unit;

class ModuleTest extends Unit
{
    /**
     * @var Module
     */
    protected $module;

    public function _before()
    {
        $this->module = \Yii::$app->getModule('rbac');
    }


    public function _after()
    {
        User::deleteAll();
    }

    public function testCreateUserSuccess()
    {
        $user = $this->module->createUser('user');

        expect($user)->isInstanceOf(User::class);
        expect($user->hasErrors())->false();
        expect($user->id)->notNull();
    }

    /**
     * @depends testCreateUserSuccess
     */
    public function testGetUserSuccess()
    {
        $user = $this->module->createUser('user');

        $found = $this->module->getUser($user->username);

        expect($found)->isInstanceOf(User::class);
        expect($found->id)->equals($user->id);
        expect($found->username)->equals($user->username);
        expect($found->access_token)->equals($user->access_token);
        expect($found->auth_key)->equals($user->auth_key);
    }

    public function testGetUserFailed()
    {
        $user = $this->module->createUser('user');

        $found = $this->module->getUser('admin');

        expect($found)->null();
    }

    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'username' => 'not_existing_username',
        ]);

        expect_not($this->module->login($model));
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginCorrect()
    {
        $user = $this->module->createUser('user');

        $model = new LoginForm([
            'username' => $user->username,
        ]);

        expect_that($this->module->login($model));
        expect_not(\Yii::$app->user->isGuest);
        expect($model->hasErrors())->false();
    }

}