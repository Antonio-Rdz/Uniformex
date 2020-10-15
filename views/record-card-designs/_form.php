<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecordCardDesigns */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
/* @var $uploadModel app\models\UploadForm */

?>

<div class="record-card-designs-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'record_card_logos_form']]); ?>

    <div class="row">
        <div class="col s12">
            <div class="file-field input-field">
                <div class="btn">
                    <span>Diseño</span>
                    <?= Html::activeFileInput($uploadModel, 'design', ['template' => '{input}', 'accept' => 'image/*']); ?>
                </div>
                <div class="file-path-wrapper">
                    <?= Html::activeTextInput($model, 'image', ['class' => 'file-path validate', 'placeholder' => 'Selecciona una imagen', 'maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col s12">
            <?= $form->field($model, 'location')->textarea(['maxlength' => true, 'class' => 'character-count', 'data-length' => 140]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m6">
            <div class="chips-autocomplete">
                <?= Html::textInput('add-chip', null, ['maxlength' => true, 'autocomplete' => 'off', 'placeholder' => 'Secuencia de colores']) ?>
            </div>
            <?= $form->field($model, 'color_sequence')->hiddenInput(['id' => 'color_sequence'])->label('') ?>
        </div>
        <div class="col s12 m6">
            <?= $form->field($model, 'color_code')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'id' => 'color_code']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m4">
            <?= $form->field($model, 'type')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'class' => 'autocomplete-techniques']) ?>
        </div>
        <div class="col s12 m4">
            <?= $form->field($model, 'stitches')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
        <div class="col s12 m4">
            <?= $form->field($model, 'dimensions')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
    </div>


    <div class="row">
        <div class="form-group col s12 m4 offset-m4">
            <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>

<?php Yii::$app->customAssets->add('record-card-designs/autocomplete.js'); ?>