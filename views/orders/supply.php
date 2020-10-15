<?php

/* @var $this yii\web\View */
/* @var $details array */
/* @var $order \app\models\Orders */

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Surtir materiales y avíos de la orden ' . $order->order_number;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => ['/orders/index', 'order_id' => $order->id]];
$this->params['breadcrumbs'][] = ['label' => $order->order_number, 'url' => ['order-details/index', 'order_id' => $order->id]];
$this->params['breadcrumbs'][] = "Confirmar";
$this->params['breadcrumbs'][] = "Surtir";

$f = Yii::$app->formatter;

$can_submit = true;
$suppliers = ArrayHelper::map(\app\models\Suppliers::find()->all(), 'id', 'name');
?>

<div class="container">

    <div class="row">
        <div class="col s12">
            <h4><?=$this->title?></h4>
            <h5>Cliente <?=$order->customer->name?></h5>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <p class="grey-text">Consejo: puedes dejar los campos en blanco para solicitar los materiales en automático, o puedes escribir una cantidad personalizada.</p>
        </div>
    </div>

    <?php ActiveForm::begin(['id' => 'manufacture-form']) ?>

    <?php foreach ($details as $record_card_id => $detail){
        $s = $detail['quantity'] != 1 ? 's' : ''?>

        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h5><?=$detail['description'].' '.$detail['model']. ' ('. $detail['quantity'] . " pieza$s)"?></h5>
                        <?php if (isset($detail['materials'])){ ?>
                            <h6>Materiales</h6>
                            <table class="highlight centered responsive-table">
                                <thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Requeridos</th>
                                    <th>Existencia</th>
                                    <th>Solicitar</th>
                                    <th>Proveedor</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($detail['materials'] as $id => $material){ ?>
                                    <tr>
                                        <td><?=$material['name'].' '.$material['description']?></td>
                                        <td><?=$required = $material['quantity']*$detail['quantity']?> <?=$material['unit']?><?=$required!=1?'s':'';?></td>
                                        <td><?=$material['stock']?> <?=$material['unit']?><?=$material['stock']!=1?'s':'';?></td>
                                        <?php $suggested = max($required - $material['stock'], 0); ?>
                                        <?php $attr_required = $suggested > 0 ? 'required' : '' ?>
                                        <td><?= Html::input('number',"Materials[$id][purchase]", null,
                                                ['placeholder' => $suggested, 'autocomplete' => 'off', 'step' => 'any', 'style' => 'width:auto;text-align:center;',]) ?></td>
                                        <td><?= Html::dropDownList("Materials[$id][supplier]", null, $suppliers, ['prompt' => 'Selecciona...', $attr_required]) ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>

                            </table>
                        <?php } else { $can_submit = false; ?>
                            <h6 class="red-text"> Esta ficha no tiene materiales registrados. <?=Html::a('Registrar un material.', ['record-cards/view', 'id' => $record_card_id]);?> </h6>
                        <?php } ?>

                        <?php if (isset($detail['parts'])){ ?>
                            <h6>Avíos</h6>
                            <table class="highlight centered responsive-table">
                                <thead>
                                <tr>
                                    <th>Avío</th>
                                    <th>Requeridos</th>
                                    <th>Existencia</th>
                                    <th>Solicitar</th>
                                    <th>Proveedor</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($detail['parts'] as $id => $part){ ?>
                                    <tr>
                                        <td><?=$part['name']?></td>
                                        <td><?=$required = $part['quantity']*$detail['quantity']?> <?=$part['unit']?><?=$required!=1?'s':'';?></td>
                                        <td><?=$part['stock']?> <?=$part['unit']?><?=$part['stock']!=1?'s':'';?></td>
                                        <?php $suggested = max($required - $part['stock'], 0); ?>
                                        <?php $attr_required = $suggested > 0 ? 'required' : '' ?>
                                        <td><?= Html::input('number',"Parts[$id][purchase]", null,
                                                ['placeholder' => $suggested, 'autocomplete' => 'off', 'step' => 'any', 'style' => 'width:auto;text-align:center;', $attr_required]) ?></td>
                                        <td><?= Html::dropDownList("Parts[$id][supplier]", null, $suppliers, ['prompt' => 'Selecciona...', ]) ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>

                            </table>
                        <?php } else { $can_submit = false; ?>
                            <h6 class="red-text"> Esta ficha no tiene avíos registrados. <?=Html::a('Registrar un avío.', ['record-cards/view', 'id' => $record_card_id]);?> </h6>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if($can_submit){ ?>
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <?= Html::submitButton('Confirmar', ['class' => 'btn green darken-1']) ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col s12 m6 offset-m3 tooltipped" data-tooltip="Todas las fichas deben tener al menos un material y un avío registrado" data-position="top">
                <?= Html::submitButton('Confirmar', ['class' => 'btn green darken-1', 'disabled' => true]) ?>
            </div>
        </div>
    <?php } ?>

    <?php ActiveForm::end() ?>


</div>

