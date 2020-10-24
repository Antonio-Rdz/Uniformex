<?php

use app\models\DeliveryOffices;
use app\models\OrderDetails;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Shipments */
/* @var $order app\models\Orders */
$this->title = 'Crear envío';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => ['/orders/']];
$this->params['breadcrumbs'][] = ['label' => 'Envíos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if($order){
    $model->order_id = $order->id;
    $details = OrderDetails::findAll(['order_id' => $order->id]);
}
$delivery_offices = ArrayHelper::map(DeliveryOffices::find()->all(), "id", "name");
$amount = 0;
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
                    <div class="shipments-form">

                        <?php $form = ActiveForm::begin(); ?>

                        <?php
                        if(!$order){ ?>
                            <?= Html::a('<i class="material-icons left">add</i> Seleccionar una orden', 'select-order', ['class' => 'btn']); ?>
                        <?php } else { ?>
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="card">
                                        <div class="card-content">
                                            <span class="card-title">Orden <?= $order->order_number ?></span>
                                            <?php foreach ($details as $detail) {
                                                echo "<p>".$detail['description']." talla ".$detail['size_id']." ".$detail['quantity']." piezas"."</p>";
                                            }
                                            $amount += ($detail['quantity'] * $detail['price']);
                                            ?>
                                            <p>
                                                <b>Total: <?=Yii::$app->formatter->asCurrency($amount)?> MXN</b>
                                            </p>
                                        </div>
                                        <div class="card-action">
                                            <?= Html::a('Más Detalles', ['/order-details/index', 'order_id' => $order->id])  ?>
                                            <?= Html::a('Cancelar', ['create'])  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        $form->field($model, 'order_id')->textInput(['class' => 'hidden'])->label(false) ?>
                        <div class="field-order-id">
                            <?= Html::error($model, 'order_id', [
                                'class' => 'help-block helper-text',
                                'tag' => 'span'
                            ]); ?>
                        </div>

                        <?= $form->field($model, 'delivery_office_id')->dropDownList($delivery_offices) ?>

                        <?= $form->field($model, 'cost')->numberInput(['decimals' => '0.01']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
