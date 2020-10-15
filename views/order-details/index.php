<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $order \app\models\Orders */
/* @var $view int|null */

use app\models\Orders;
use macgyer\yii2materializecss\lib\Html;

$this->title = 'Orden '.$order->order_number;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => '/orders/index'];
$this->params['breadcrumbs'][] = $order->order_number;
?>

<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h5>Cliente: <?= $order->customer->name ?></h5>
        </div>
    </div>

    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("order-details", "create") && $order->status === Orders::NOT_STARTED){ ?>
            <div class="col s12 m4">
                <?= Html::a('<i class="material-icons left">add</i> Agregar concepto', ['create', 'order_id' => $order->id], ['class' => 'btn']) ?>
            </div>
        <?php } ?>

        <?php if(Yii::$app->user->getIdentity()->hasAccess("order-details", "confirm") && $order->status === Orders::NOT_STARTED){ ?>
            <div class="col s12 m4">
                <?= Html::a('<i class="material-icons left">check_circle</i> Confirmar orden', ['orders/confirm', 'id' => $order->id], ['class' => 'btn green darken-1']) ?>
            </div>
        <?php } ?>

        <?php if(Yii::$app->user->getIdentity()->hasAccess("orders", "supply") && $order->status === Orders::WAITING_FOR_MATERIAL && count($order->purchaseOrders) == 0){ ?>
            <div class="col s12 m4">
                <?= Html::a('<i class="material-icons left">playlist_add_check</i> Revisar materiales/avíos', ['orders/supply', 'id' => $order->id], ['class' => 'btn']) ?>
            </div>
        <?php } ?>

        <?php if($order->status === Orders::WAITING_FOR_MATERIAL && count($order->purchaseOrders)){ ?>
            <div class="row">
                <div class="col s12">
                    <h5 class="grey-text">Existen ordenes de compra en espera para esta orden. <?=Html::a('Ver', ['purchase-orders/index', 'filter_order_number' => $order->order_number])?></h5>
                </div>
            </div>
        <?php } ?>
    </div>

</div>


<?php if($view == 'detailed'){
    echo $this->render('_detail', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'order' => $order,
    ]);
} else {
    echo $this->render('_grid', [
        'order' => $order,
    ]);
}
?>

<?php Yii::$app->customAssets->add('order-details/ajax-modal.js'); ?>
