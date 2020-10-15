<?php

use macgyer\yii2materializecss\lib\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrderDetails */

$this->title = 'Agregar concepto a orden de compra';
$this->params['breadcrumbs'][] = ['label' => 'Órdenes de compra', 'url' => ['purchase-orders/index']];
$this->params['breadcrumbs'][] = ['label' => 'Orden #'.$model->order->id, 'url' => ['purchase-orders/view', 'id' => $model->purchase_order_id]];
$this->params['breadcrumbs'][] = 'Agregar concepto';
?>
<div class="container">
    <div class="row">
        <div class="col m12 s12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12">
            <div class="card white">
                <div class="card-content">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>