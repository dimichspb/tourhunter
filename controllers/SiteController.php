<?php

namespace app\controllers;

use yii\base\Module;
use yii\web\Controller;
use yii\web\Request;


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
