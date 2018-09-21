<?php
namespace app\tests\unit\models;

use app\modules\api\models\SearchModel;
use app\modules\api\models\User;
use Codeception\Test\Unit;

class SearchModelTest extends Unit
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
     * Test validate id success
     */
    public function testValidateIdSuccess()
    {
        $searchModel = new SearchModel();
        $searchModel->id = 1;

        expect($searchModel->validate())->true();
        expect($searchModel->hasErrors('id'))->false();
    }

    /**
     * Test validate id failed
     */
    public function testValidateIdFailed()
    {
        $searchModel = new SearchModel();
        $searchModel->id = 'not_valid_id_value';

        expect($searchModel->validate())->false();
        expect($searchModel->hasErrors('id'))->true();
    }

    /**
     * Tests validate username success
     */
    public function testValidateUsernameSuccess()
    {
        $searchModel = new SearchModel();
        $searchModel->username = 'valid_username_value';

        expect($searchModel->validate())->true();
        expect($searchModel->hasErrors('username'))->false();
    }

    /**
     * Tests search username success
     */
    public function testSearchUsernameSuccess()
    {
        $searchModel = new SearchModel();
        $dataProvider = $searchModel->search(['username' => $this->model->username]);

        expect($dataProvider->getCount())->equals(1);
        expect($dataProvider->getModels())->containsOnlyInstancesOf(User::class);
        foreach ($dataProvider->getModels() as $model) {
            expect($model->id)->equals($this->model->id);
            expect($model->username)->equals($this->model->username);
            expect($model->auth_key)->equals($this->model->auth_key);
            expect($model->access_token)->equals($this->model->access_token);
        }
    }

    /**
     * Test search id success
     */
    public function testSearchIdSuccess()
    {
        $searchModel = new SearchModel();
        $dataProvider = $searchModel->search(['id' => $this->model->id]);

        expect($dataProvider->getCount())->equals(1);
        expect($dataProvider->getModels())->containsOnlyInstancesOf(User::class);
        foreach ($dataProvider->getModels() as $model) {
            expect($model->id)->equals($this->model->id);
            expect($model->username)->equals($this->model->username);
            expect($model->auth_key)->equals($this->model->auth_key);
            expect($model->access_token)->equals($this->model->access_token);
        }
    }

    /**
     * Test search access_token failed
     */
    public function testSearchAccessTokenFailed()
    {
        $user2 = new User();
        $user2->username = 'user2';
        $user2->generateAccessToken();
        $user2->generateAuthKey();
        $user2->save();
        
        $searchModel = new SearchModel();
        $dataProvider = $searchModel->search(['access_token' => $this->model->access_token]);

        expect($dataProvider->getCount())->equals(2);
    }

    /**
     * Test search auth_key failed
     */
    public function testSearchAuthKeyFailed()
    {
        $user2 = new User();
        $user2->username = 'user2';
        $user2->generateAccessToken();
        $user2->generateAuthKey();
        $user2->save();
        
        $searchModel = new SearchModel();
        $dataProvider = $searchModel->search(['auth_key' => $this->model->auth_key]);

        expect($dataProvider->getCount())->equals(2);
    }
}