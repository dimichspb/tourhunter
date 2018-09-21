<?php

namespace app\modules\api\controllers;

use app\modules\api\models\SearchModel;
use yii\base\Module;
use yii\web\Controller;
use yii\web\Request;

/**
 * Default controller for the `api` module
 */
class UserController extends \yii\rest\Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * UserController constructor.
     * @param $id
     * @param Module $module
     * @param Request $request
     * @param array $config
     */
    public function __construct($id, Module $module, Request $request, array $config = [])
    {
        $this->request = $request;

        parent::__construct($id, $module, $config);
    }

    /**
     * User index
     * @return \yii\data\ActiveDataProvider
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $dataProvider;
    }
}
