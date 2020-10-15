<?php

use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\States;
 
/* @var $this yii\web\View */
/* @var $model app\models\CustomerAddresses */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */

$states = ArrayHelper::map(States::find()->all(), 'id', 'name');
?>

<div class="customer-addresses-form"> 

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'int_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ext_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'section')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state_id')->dropDownList($states, ['prompt' => 'Selecciona un estado']) ?>

    <?= $form->field($model,'city_id')->textInput(['class' => 'autocomplete', 'autocomplete' => 'off']) ?>


    <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
