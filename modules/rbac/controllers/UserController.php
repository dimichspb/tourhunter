<?php

namespace app\modules\rbac\controllers;

use app\modules\rbac\forms\LoginForm;
use app\modules\rbac\forms\RegisterForm;
use app\modules\rbac\Module;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\web\User;

/**
 * Default controller for the `rbac` module
 */
class UserController extends Controller
{
    protected $request;
    protected $user;

    public function __construct($id, Module $module, Request $request, array $config = [])
    {
        $this->request = $request;
        $this->user = Yii::$app->user;

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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Register action.
     *
     * @return string
     */
    public function actionRegister()
    {
        if (!$this->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load($this->request->post()) && $model->register()) {
            return $this->goBack();
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!$this->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load($this->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $this->user->logout();

        return $this->goHome();
    }
}
