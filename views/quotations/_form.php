<?php

use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Quotations */
/* @var $customer \app\models\Customers */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
?>

<div class="quotations-form">

    <?php $form = ActiveForm::begin();
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

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
