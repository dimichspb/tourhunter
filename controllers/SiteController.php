<?php

namespace app\controllers;

use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Application;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\forms\LoginForm;

class SiteController extends Controller
{
    protected $request;

    public function __construct($id, Module $module, Request $request, array $config = [])
    {
        $this->request = $request;

        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'title' => \Yii::$app->name
        ]);
    }
}
