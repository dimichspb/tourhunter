<?php

namespace app\controllers;

use app\forms\user\TransferForm;
use app\models\user\SearchModel;
use app\services\UserService;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Request;
use yii\web\Session;

class UserController extends \yii\web\Controller
{
    protected $request;
    protected $session;
    protected $user;
    protected $service;

    public function __construct($id, Module $module, Request $request, Session $session, UserService $service, array $config = [])
    {
        $this->request = $request;
        $this->session = $session;
        $this->user = \Yii::$app->user;
        $this->service = $service;

        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['transfer'],
                'rules' => [
                    [
                        'actions' => ['transfer'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new SearchModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionTransfer()
    {
        $transferForm = new TransferForm();

        if ($transferForm->load($this->request->post()) && $transferForm->validate() &&
            $this->service->transfer($this->user->getIdentity(), $transferForm)
        ){
            $this->goBack();
        }

        return $this->render('transfer', [
            'model' => $transferForm,
        ]);
    }
}
