<?php

use app\lib\i18n;
use app\models\Payments;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use macgyer\yii2materializecss\widgets\form\DatePicker;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $cloth \app\models\Clothes */
/* @var $model app\models\Payments */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
/* @var $order \app\models\Orders */


$this->title = 'Registrar Pago';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => ['/orders/index']];
$this->params['breadcrumbs'][] = ['label' => 'Pagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if($order){
    $model->order_id = $order->id;
    $details = \app\models\OrderDetails::findAll(['order_id' => $order->id]);
}
$amount = 0;

// Remove canceled status
$status = Payments::STATUS;
unset($status[4]);
?>
<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12">
            <div class="card white">
                <div class="card-content">
                    <div class="payments-form">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'amount')->numberInput(['decimals' => '0.01']) ?>

                        <?= $form->field($model, 'paid_date')->textInput(['class' => 'hidden'])->label(false) ?>

                        <div class="input-field field-paid-date">
                            <?php
                            echo Html::activeLabel($model,'paid_date');
                            echo DatePicker::widget([
                                'name' => 'paid-date',
                                'value' => $model->paid_date,
                                'clientOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'i18n' => i18n::$spanish
                                ],
                            ]);
                            echo Html::error($model,'paid_date', [
                                'class' => 'help-block helper-text',
                                'tag' => 'span'
                            ]);
                            ?>
                        </div>

                        <?= $form->field($model, 'status_id')->dropDownList($status) ?>

                        <?php
                        if(!$order){
                            echo Html::a('<i class="material-icons left">add</i> Seleccionar una orden', 'select-order', ['class' => 'btn']);
                        } else { ?>
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="card">
                                        <div class="card-content">
                                            <span class="card-title">Orden <?= $order->order_number ?></span>
                                            <?php foreach ($details as $detail) {
                                                echo "<p>".$detail['description']." talla ".$detail['size']." ".$detail['quantity']." piezas"."</p>";
                                            }
                                            $amount += ($detail['quantity'] * $detail['price']);
                                            ?>
                                            <p>
                                                <b>Total: <?=Yii::$app->formatter->asCurrency($amount)?> MXN</b>
                                            </p>
                                        </div>
                                        <div class="card-action">
                                            <?= Html::a('Más Detalles', ['/order-details/index', 'order_id' => $order->id])  ?>
                                            <?= Html::a('Cancelar', ['/payments/create'])  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        echo $form->field($model, 'order_id')->textInput(['class' => 'hidden'])->label(false); ?>
                        <div class="field-order-detail-id">
                            <?= Html::error($model, 'order_id', [
                                'class' => 'help-block helper-text',
                                'tag' => 'span'
                            ]); ?>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>