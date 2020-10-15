<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClothTypes */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
?>

<div class="cloth-types-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'required']) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'class' => 'autocomplete-colors', 'required']) ?>

    <?php ActiveForm::end(); ?>

</div>
<?php Yii::$app->customAssets->add('order-details/autocomplete.js'); ?>