<?php
namespace app\modules\api\tests\functional;

use app\modules\api\models\User;

class UserControllerCest
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
        $this->model->username = 'user1';
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
     * Test user index
     * @param \FunctionalTester $I
     */
    public function getUserIndex(\FunctionalTester $I)
    {
        $I->amOnRoute('/api/user/index');
        $I->canSeeResponseCodeIsSuccessful();
        $I->seeInSource('[{"id":' . $this->model->id . ',"username":"' . $this->model->username . '"}]');
        $I->dontSeeInSource('access_token');
        $I->dontSeeInSource('auth_key');
    }
}