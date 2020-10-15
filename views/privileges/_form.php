<?php

use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Privileges */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
?>

<div class="privileges-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autocomplete' => 'off'])->label('Nombre') ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'controller')->textInput(['maxlength' => true, 'class' => 'autocomplete', 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'action')->textInput(['maxlength' => true, 'class' => 'autocomplete', 'autocomplete' => 'off']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>