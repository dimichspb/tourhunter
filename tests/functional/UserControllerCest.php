<?php
namespace app\tests\functional;

use app\models\user\User;

class UserControllerCest
{
    /**
     * @var User
     */
    protected $model;

    /**
     * Before tests
     * @param \FunctionalTester $I
     */
    public function _before(\FunctionalTester $I)
    {
        \Yii::$app->user->logout();
        $this->model = new User();
        $this->model->username = 'user1';
        $this->model->generateAuthKey();
        $this->model->generateAccessToken();
        $this->model->save();
    }

    /**
     * After tests
     * @param \FunctionalTester $I
     */
    public function _after(\FunctionalTester $I)
    {
        \Yii::$app->user->logout();
        User::deleteAll();
    }

    /**
     * Test index page
     * @param \FunctionalTester $I
     */
    public function openIndexPage(\FunctionalTester $I)
    {
        $I->amOnRoute('user/index');
        $I->see('Users', 'h1');

        $I->canSeeElement('.grid-view');
        $I->canSee($this->model->username, 'td');
    }

    /**
     * Test transfer page success
     * @param \FunctionalTester $I
     */
    public function openTransferPageSuccess(\FunctionalTester $I)
    {
        $I->amLoggedInAs($this->model);
        $I->amOnRoute('user/transfer');
        $I->see('Transfer', 'h1');
        $I->see('User details', 'h4');
        $I->see('Transfer form', 'h4');
        $I->see($this->model->username, '.detail-view td');
        $I->canSee('0', '.detail-view td');
        $I->see('Transfer', 'button');
    }

    /**
     * Test transfer page failed
     * @param \FunctionalTester $I
     */
    public function openTransferPageFailed(\FunctionalTester $I)
    {
        $I->amOnRoute('user/transfer');
        $I->dontSee('Transfer', 'h1');
    }
}