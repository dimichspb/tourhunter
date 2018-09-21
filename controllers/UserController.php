<?php

namespace app\controllers;

use app\forms\user\TransferForm;
use app\models\user\SearchModel;
use app\models\user\User;
use app\services\UserService;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Request;
use yii\web\Session;

class UserController extends \yii\web\Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var UserService
     */
    protected $service;

    public function __construct($id, Module $module, Request $request, Session $session, UserService $service, \yii\web\User $user, array $config = [])
    {
        $this->request = $request;
        $this->session = $session;
        $this->user = $user;
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

    /**
     * User index
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Transfer money
     * @return string
     * @throws \Throwable
     */
    public function actionTransfer()
    {
        $transferForm = new TransferForm();

        $transferForm->sender_id = $this->user->getId();

        if ($transferForm->load($this->request->post()) && $transferForm->validate()) {
            try {
                $this->service->transfer($transferForm);
                $this->session->addFlash('success', \Yii::t('app', 'Transfer completed'));
            } catch (\Exception $exception) {
                $this->session->addFlash('danger', \Yii::t('app', 'Transfer uncompleted!' . PHP_EOL . $exception->getMessage()));
            }
            $transferForm->clear();
        }

        $user = User::findOne($this->user->getId());

        return $this->render('transfer', [
            'user' => $user,
            'model' => $transferForm,
        ]);
    }
}
