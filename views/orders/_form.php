<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use \macgyer\yii2materializecss\widgets\form\DatePicker;
use app\lib\i18n;


/* @var $this yii\web\View */
/* @var $model app\models\Orders */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
/* @var $customer \app\models\Customers */
$date_error = $input_class = '';
if(isset($model->errors['payment_due_date'][0])){
    $date_error = $model->errors['payment_due_date'][0];
    $input_class = 'invalid';
}

$due_date_error = $due_input_class = '';
if(isset($model->errors['due_date'][0])){
    $due_date_error = $model->errors['due_date'][0];
    $due_input_class = 'invalid';
}

$customers = ArrayHelper::map(\app\models\Customers::find()->all(), 'id', 'name');
$warehouses = ArrayHelper::map(\app\models\Warehouses::find()->all(), 'id', 'name');
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_number')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'disabled' => 'disabled']) ?>
    <?= $form->field($model,'calendar_color')->colorInput()->label(null, ['style' => 'position: relative;left: 15px;']); ?>
    <?php
    if(!$customer){
        echo Html::a('<i class="material-icons left">add</i> Seleccionar cliente', 'select-customer', ['class' => 'btn']);
    } else {
        $model->customer_id = $customer->id; ?>
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title"><?= $customer->name ?></span>
                        <p>
                            Email: <?= $customer->alias ?>
                        </p>
                    </div>
                    <div class="card-action">
                        <?= Html::a('Cambiar', ['/quotations/select-customer'])  ?>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    echo $form->field($model, 'customer_id')->textInput(['class' => 'hidden'])->label(false) ?>
    <div class="field-order-detail-id">
        <?= Html::error($model, 'customer_id', [
            'class' => 'help-block helper-text',
            'tag' => 'span'
        ]); ?>
    </div>

    <?= $form->field($model,'warehouse_id')->dropDownList($warehouses, ['prompt' => 'Selecciona una sucursal']); ?>

    <div class="hidden">
        <?= $form->field($model, 'payment_due_date')->textInput(['id' => 'payment-due-date'])->label(false) ?>
        <?= $form->field($model, 'due_date')->textInput(['id' => 'due-date'])->label(false) ?>
    </div>

    <div class="input-field field-payment-due-date<?= $input_class ?>">
        <?php
        echo Html::activeLabel($model,'payment_due_date');
        echo DatePicker::widget([
            'name' => 'payment-due-date',
            'options' => ['class' => $input_class, 'autocomplete' => 'off'],
            'value' => $model->payment_due_date,
            'clientOptions' => [
                'format' => 'yyyy-mm-dd',
                'i18n' => i18n::$spanish
            ],
        ]);
        echo Html::error($model,'payment_due_date', [
            'class' => 'help-block helper-text',
            'data-error' => $date_error,
            'tag' => 'span'
        ]);
        ?>
    </div>

    <div class="input-field field-due-date<?= $input_class ?>">
        <?php
        echo Html::activeLabel($model,'due_date');
        echo DatePicker::widget([
            'name' => 'due-date',
            'options' => ['class' => $due_input_class, 'autocomplete' => 'off'],
            'value' => $model->due_date,
            'clientOptions' => [
                'format' => 'yyyy-mm-dd',
                'i18n' => i18n::$spanish
            ],
        ]);
        echo Html::error($model,'due_date', [
            'class' => 'help-block helper-text',
            'data-error' => $due_date_error,
            'tag' => 'span'
        ]);
        ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
