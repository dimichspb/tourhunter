<?php
namespace app\modules\api\tests\unit;

use app\modules\api\models\SearchModel;
use app\modules\api\models\User;
use Codeception\Test\Unit;

class SearchModelTest extends Unit
{
    /**
     * @var User
     */
    protected $model;

    public function _before()
    {
        $this->model = new User();
        $this->model->username = 'user1';
        $this->model->generateAccessToken();
        $this->model->generateAuthKey();
        $this->model->save();
    }

    public function _after()
    {
        User::deleteAll();
    }

    public function testValidateIdSuccess()
    {
        $searchModel = new SearchModel();
        $searchModel->id = 1;

        expect($searchModel->validate())->true();
        expect($searchModel->hasErrors('id'))->false();
    }

    public function testValidateIdFailed()
    {
        $searchModel = new SearchModel();
        $searchModel->id = 'not_valid_id_value';

        expect($searchModel->validate())->false();
        expect($searchModel->hasErrors('id'))->true();
    }

    public function testValidateUsernameSuccess()
    {
        $searchModel = new SearchModel();
        $searchModel->username = 'valid_username_value';

        expect($searchModel->validate())->true();
        expect($searchModel->hasErrors('username'))->false();
    }

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