<?php

namespace app\controllers;

class UserController extends \yii\web\Controller
{
    public function actionTransfer()
    {
        return $this->render('transfer');
    }
}
