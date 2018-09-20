<?php

namespace tests\models;

use app\models\user\User;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var User
     */
    protected $model;

    public function _before()
    {
        $this->model = new User();
        $this->model->username = 'user';
        $this->model->generateAccessToken();
        $this->model->generateAuthKey();
        $this->model->save();
    }

    public function _after()
    {
        User::deleteAll();
    }

    public function testFindUserByIdSuccess()
    {
        expect_that($user = User::findIdentity($this->model->id));
        expect($user->username)->equals($this->model->username);
    }

    public function testFindUserByIdFailed()
    {
        expect_not(User::findIdentity(999));
    }

    public function testFindUserByAccessTokenSuccess()
    {
        expect_that($user = User::findIdentityByAccessToken($this->model->access_token));
        expect($user->username)->equals($this->model->username);
    }

    public function testFindUserByAccessTokenFailed()
    {
        expect_not(User::findIdentityByAccessToken('non-existing'));
    }

    public function testFindUserByUsernameSuccess()
    {
        expect_that($user = User::findByUsername($this->model->username));
        expect($user->username)->equals($this->model->username);
    }

    public function testFindUserByUsernameFailed()
    {
        expect_not(User::findByUsername('not-existing'));
    }

    /**
     * @depends testFindUserByUsernameSuccess
     */
    public function testValidateUserSuccess()
    {
        $user = User::findByUsername($this->model->username);
        expect_that($user->validateAuthKey($this->model->auth_key));
    }

    public function testValidateUserFailed()
    {
        $user = User::findByUsername($this->model->username);
        expect_not($user->validateAuthKey('not-existing'));
    }
}
