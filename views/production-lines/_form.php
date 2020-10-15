<?php

use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use app\models\ProductionLines;

/* @var $this yii\web\View */
/* @var $model app\models\ProductionLines */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */

$statuses = ProductionLines::STATUSES;

$data = [];

if($model->status === ProductionLines::IN_USE){
    $data = ['confirm' => 'La linea de producción está en uso ¿Seguro que quieres editarla?', 'method' => 'post'];
} else {
    unset($statuses[ProductionLines::IN_USE]);
}
?>

<div class="production-lines-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->dropDownList($statuses) ?>

    <?= $form->field($model, 'type')->dropDownList(ProductionLines::TYPES) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn', 'data' => $data]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>