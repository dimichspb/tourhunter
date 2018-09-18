<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $title string */

$this->title = $title;
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Welcome!</h1>

        <p class="lead">You are at TourHunter test exercise web-site.</p>

        <p><?= Html::a('Users list', ['user/index'], ['class' => 'btn btn-default']); ?></p>
    </div>
</div>
