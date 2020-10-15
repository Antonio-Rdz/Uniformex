<?php

use app\models\Units;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrderDetails */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */

$units = ArrayHelper::map(Units::find()->all(), 'id', 'name');
?>

<div class="purchase-order-details-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estimated_cost')->textInput() ?>

    <?= $form->field($model, 'unit_id')->dropDownList($units) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
