<?php

use app\models\Units;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Parts */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */

$units = ArrayHelper::map(Units::find()->all(), 'id', 'name')
?>

<div class="parts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'unit_id')->dropDownList($units, ['prompt' => 'Selecciona una unidad']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
