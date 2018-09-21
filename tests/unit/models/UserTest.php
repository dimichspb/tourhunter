<?php

namespace app\tests\unit\models;

use app\models\user\User;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var User
     */
    protected $model;

    /**
     * Before tests
     */
    public function _before()
    {
        $this->model = new User();
        $this->model->username = 'user';
        $this->model->generateAccessToken();
        $this->model->generateAuthKey();
        $this->model->save();
    }

    /**
     * After tests
     */
    public function _after()
    {
        User::deleteAll();
    }

    /**
     * Test find user by id success
     */
    public function testFindUserByIdSuccess()
    {
        expect_that($user = User::findIdentity($this->model->id));
        expect($user->username)->equals($this->model->username);
    }

    /**
     * Test find user by id failed
     */
    public function testFindUserByIdFailed()
    {
        expect_not(User::findIdentity(999));
    }

    /**
     * Test find user by access_token success
     */
    public function testFindUserByAccessTokenSuccess()
    {
        expect_that($user = User::findIdentityByAccessToken($this->model->access_token));
        expect($user->username)->equals($this->model->username);
    }

    /**
     * Test find sr by access_token failed
     */
    public function testFindUserByAccessTokenFailed()
    {
        expect_not(User::findIdentityByAccessToken('non-existing'));
    }

    /**
     * Test find user by username success
     */
    public function testFindUserByUsernameSuccess()
    {
        expect_that($user = User::findByUsername($this->model->username));
        expect($user->username)->equals($this->model->username);
    }

    /**
     * Test find user by username failed
     */
    public function testFindUserByUsernameFailed()
    {
        expect_not(User::findByUsername('not-existing'));
    }

    /**
     * Test validate user auth_key success
     * @depends testFindUserByUsernameSuccess
     */
    public function testValidateUserSuccess()
    {
        $user = User::findByUsername($this->model->username);
        expect_that($user->validateAuthKey($this->model->auth_key));
    }

    /**
     * Test validate user auth_key failed
     */
    public function testValidateUserFailed()
    {
        $user = User::findByUsername($this->model->username);
        expect_not($user->validateAuthKey('not-existing'));
    }

    /**
     * Test decrease balance success
     * @depends testFindUserByIdSuccess
     */
    public function testDecreaseSuccess()
    {
        $before = $this->model->balance;
        $this->model->decreaseBalance(100);
        expect($this->model->save())->true();
        expect($this->model->hasErrors())->false();

        $user = User::findOne(['id' => $this->model->id]);
        expect($user)->notNull();
        expect($user)->isInstanceOf(User::class);

        $after = $user->balance;
        expect($before - $after)->equals(100);
    }

    /**
     * Test increase balance success
     */
    public function testIncreaseSuccess()
    {
        $before = $this->model->balance;
        $this->model->increaseBalance(100);
        expect($this->model->save())->true();
        expect($this->model->hasErrors())->false();

        $user = User::findIdentity($this->model->id);
        expect($user)->notNull();
        expect($user)->isInstanceOf(User::class);

        $after = $user->balance;
        expect($after - $before)->equals(100);
    }
}
