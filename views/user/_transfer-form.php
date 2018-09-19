<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/** @var $model \app\forms\user\TransferForm */

?>
<?php $form = ActiveForm::begin([
    'id' => 'transfer-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'horizontalCssClasses' => [
          'label' => 'col-sm-4',
          'wrapper' => 'col-sm-8',
        ],
    ],
]) ?>
<div class="row">
    <div class="col-xs-12">
        <?= $form->field($model, 'reciepient_id')->widget(Select2::class, [
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 1,
                'ajax' => [
                    'url' => Url::to(['/api/user/index']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {username:params.term}; }'),
                    'processResults' => new JsExpression('function (data) { return {results: data};}'),
                ],
                'templateResult' => new JsExpression('function(user) { return user.username; }'),
                'templateSelection' => new JsExpression('function (user) { return user.username; }'),
            ],
        ]); ?>
    </div>
    <div class="col-xs-12">
        <?= $form->field($model, 'amount') ?>
    </div>
    <div class="col-xs-12 text-right">
        <?= Html::submitButton('Transfer', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
