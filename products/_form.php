<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $uploadModel app\models\UploadForm */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'description')->textInput([
        'maxlength' => true,
        'autocomplete' => 'off',
        'data-length' => 75,
        'class' => 'character-count'
    ]) ?>

    <div class="row">
        <div class="col s12 m6 l6">
            <div class="file-field input-field">
                <div class="btn">
                    <span>Frente</span>
                    <?= Html::activeFileInput($uploadModel, 'front', ['accept' => 'image/*', 'template' => '{input}']); ?>
                </div>
                <div class="file-path-wrapper">
                    <?= Html::activeTextInput($model, 'front_image', ['class' => 'file-path validate', 'placeholder' => 'Selecciona una imagen', 'maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="file-field input-field">
                <div class="btn">
                    <span>Espalda</span>
                    <?= Html::activeFileInput($uploadModel, 'back', ['accept' => 'image/*', 'template' => '{input}']); ?>
                </div>
                <div class="file-path-wrapper">
                    <?= Html::activeTextInput($model, 'back_image', ['class' => 'file-path validate', 'placeholder' => 'Selecciona una imagen', 'maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m4 l4 offset-m4 offset-l4">
            <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
