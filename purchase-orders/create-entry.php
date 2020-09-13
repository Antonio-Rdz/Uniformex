<?php

use app\models\PurchaseOrders;
use app\models\Warehouses;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $purchase_order PurchaseOrders */
/* @var $model app\models\PurchaseOrders */
/* @var $searchModel app\models\PurchaseOrderDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Crear entrada(s) para orden de compra #'.$purchase_order->id;
$this->params['breadcrumbs'][] = ['label' => 'Órdenes de compra', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Orden #'.$purchase_order->id, 'url' => ['purchase-orders/view', 'id' => $purchase_order->id]];
$this->params['breadcrumbs'][] = 'Crear entrada(s)';

$warehouses = ArrayHelper::map(Warehouses::find()->all(), 'id', 'name') ;

?>

<div class="container">

    <div class="row">
        <div class="col s12">
            <h4><?=Html::encode($this->title)?></h4>
        </div>
    </div>
    <?php ActiveForm::begin(['method' => 'post']) ?>
    <div class="row">
        <div class="col s12">
            <table class="highlight centered responsive-table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Tipo</th>
                        <th style="min-width: 250px">Material / Prenda / Avío</th>
                        <th>Almacén</th>
                        <th>Cantidad</th>
                        <th>Costo unitario</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach ($purchase_order->details as $detail){ ?>
                    <tr>
                        <td><?=$detail->description?></td>
                        <td style="max-width: 200px;"><?=Html::dropDownList("Types[{$detail->id}]", null,
                                [
                                    'cloth' => 'Prenda',
                                    'material' => 'Material',
                                    'part' => 'Avío'
                                ],
                                [
                                    'prompt' => 'Selecciona un tipo',
                                    'required' => 'required',
                                    'class' => 'entry-type',
                                    'data' => ['detailid' => $detail->id]
                                ]
                            )?>
                        </td>
                        <td id="entry_type_col_<?=$detail->id?>"><span class="grey-text">Seleccionando...</span></td>
                        <td><?=Html::dropDownList("Warehouses[{$detail->id}]", null, $warehouses, ['prompt' => 'Selecciona un almacén', 'required' => 'required'])?></td>
                        <td><?=Html::input('number', "Quantities[{$detail->id}]", $detail->quantity, ['style' => 'width:80px;text-align:center;', 'required' => 'required', 'step' => 'any']) ?></td>
                        <td><?=Html::input('number', "Costs[{$detail->id}]", $detail->estimated_cost > 0 ? $detail->estimated_cost : null, ['style' => 'width:80px;text-align:center;', 'required' => 'required', 'step' => 'any']) ?></td>
                    </tr>

                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m4 offset-m4">
            <?= Html::submitButton('<i class="material-icons left">send</i> Crear entradas', ['class' => 'btn green darken-1']); ?>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="entry_element_selection_modal" class="modal center">
        <div class="modal-content valign-wrapper" style="min-height: 300px" id="entry_element_selection"></div>
    </div>

    <?php ActiveForm::end() ?>

    <?php Yii::$app->customAssets->add('purchase-orders/entry.js'); ?>

</div>