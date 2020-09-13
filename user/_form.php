<?php

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */

use app\lib\i18n;
use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <div class="hidden">
        <?= $form->field($model, 'birthday')->textInput(['class' => 'birthday', 'id' => 'user-birthday'])->label(false) ?>
    </div>

    <?= \macgyer\yii2materializecss\widgets\form\DatePicker::widget([
        'name' => 'user-birthday',
        'options' => ['placeholder' => 'Cumpleaños'],
        'value' => $model->birthday,
        'clientOptions' => [
            'format' => 'yyyy-mm-dd',
            'i18n' => i18n::$spanish,
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn blue darken-1']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
