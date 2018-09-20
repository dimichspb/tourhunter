<?php

use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $user \app\models\user\User */
/* @var $model \app\forms\user\TransferForm */

$this->title = Yii::t('app', 'Transfer');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-xs-12 col-md-8">
        <h4><?= \Yii::t('app', 'User details');?></h4>
        <?= DetailView::widget([
            'model' => $user,
            'attributes' => [
                'username',
                'balance',
            ],
        ]); ?>
    </div>
    <div class="col-xs-12 col-md-4">
        <h4><?= \Yii::t('app', 'Transfer form');?></h4>
        <?= $this->render('_transfer-form', [
            'model' => $model,
        ]); ?>
    </div>
</div>


