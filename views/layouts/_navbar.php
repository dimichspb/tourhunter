<?php

use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
$items = [];
$items[] = ['label' => 'Home', 'url' => ['/site/index']];
if (\Yii::$app->user->isGuest) {
    $items[] = ['label' => 'Register', 'url' => ['/rbac/user/register']];
    $items[] = ['label' => 'Login', 'url' => ['/rbac/user/login']];
} else {
    $items[] = ['label' => 'Transfer', 'url' => ['/rbac/user/transfer']];
    $items[] = (
        '<li>'
        . Html::beginForm(['/rbac/user/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>'
    );
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items,
]);
NavBar::end();