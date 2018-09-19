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
    protected $request;

    public function __construct($id, Module $module, Request $request, array $config = [])
    {
        $this->request = $request;

        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $searchModel = new SearchModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $dataProvider;
    }
}
