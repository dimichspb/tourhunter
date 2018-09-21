<?php

namespace app\modules\rbac\tests\functional;

use app\modules\rbac\models\User;

class UserControllerCest
{
    /**
     * @var User
     */
    protected $model;

    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('rbac/user/login');
        $this->model = new User();
        $this->model->username = 'user';
        $this->model->generateAuthKey();
        $this->model->generateAccessToken();
        $this->model->save();
    }


    public function _after()
    {
        User::deleteAll();
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Login', 'h1');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedInAs($this->model->id);
        $I->amOnPage('/');
        $I->see('Logout (' . $this->model->username . ')');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(\FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByUsername($this->model->username));
        $I->amOnPage('/');
        $I->see('Logout (' . $this->model->username . ')');
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'not_existing_username',
        ]);
        $I->expectTo('see validations errors');
        $I->see('User not found');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => $this->model->username,
        ]);
        $I->see('Logout (' . $this->model->username . ')');
        $I->dontSeeElement('form#login-form');              
    }
}