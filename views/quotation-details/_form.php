<?php

use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\QuotationDetails */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
?>

<div class="quotation-details-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textInput([
        'maxlength' => true,
        'autocomplete' => 'off',
        'data-length' => 75,
        'class' => 'character-count'
    ]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'class' => 'autocomplete-colors']) ?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'class' => 'autocomplete-sizes']) ?>

    <?= $form->field($model, 'price')->numberInput(['autocomplete' => 'off', 'decimals' => '0.01']) ?>

    <?= $form->field($model, 'quantity')->numberInput() ?>

    <?= $form->field($model, 'customization')->checkbox() ?>

    <?= $form->field($model, 'additional_notes')->textarea([
        'maxlength' => true,
        'autocomplete' => 'off',
        'data-length' => 140,
        'class' => 'character-count'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php Yii::$app->customAssets->add('order-details/autocomplete.js'); ?>
