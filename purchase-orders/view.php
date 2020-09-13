<?php

use app\models\PurchaseOrders;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrders */
/* @var $searchModel app\models\PurchaseOrderDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orden de compra #'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Órdenes de compra', 'url' => ['index']];
$this->params['breadcrumbs'][] =  'Orden #'.$model->id;
$statuses = PurchaseOrders::STATUSES;
unset($statuses[5]);
?>
<div class="purchase-orders-view">

    <div class="container">

        <div class="row">
            <div class="col s12">
                <h4><?= Html::encode($this->title) ?></h4>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <h6><?=$model->supplier->name?></h6>
            </div>
        </div>

        <div class="row">
            <div class="col s12 m12 l12">
                <ul class="h-timeline" id="timeline">
                   <?php foreach ($statuses as $key => $status){
                       $class = '';
                       if($model->status >= $key){
                           $class = 'complete';
                       }
                       ?>
                        <li class="li <?=$class?>">
                            <div class="status">
                                <h6> <?=$status?> </h6>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

            <?php if($model->status == PurchaseOrders::TO_BE_CONFIRMED && count($model->details) > 0){ ?>
            <div class="row">
                <div class="col s12 m6">
                    <?= Html::a('<i class="material-icons left">check</i> Confirmar', ['confirm', 'id' => $model->id], ['class' => 'btn btn-block green darken-1']) ?>
                </div>
                <div class="col s12 m6">
                    <?= Html::a('<i class="material-icons left">cancel</i> Cancelar', ['cancel', 'id' => $model->id],
                        ['class' => 'btn btn-block red darken-1',
                            'data' => [
                                'confirm' => 'No se puede recuperar una orden de compra cancelada.',
                                'pjax' => '0',
                            ],]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m4 offset-m4">
                    <?= Html::a('<i class="material-icons left">add</i> Agregar concepto', ['purchase-order-details/create', 'purchase_order_id' => $model->id], ['class' => 'btn btn-block']) ?>
                </div>
            </div>
            <?php } ?>


            <?php if($model->status == PurchaseOrders::IN_PROGRESS){ ?>

                <div class="row">
                    <div class="col s6">
                        <?= Html::a('<i class="material-icons left">check_circle</i> Confirmar recepción', ['reception', 'id' => $model->id], ['class' => 'btn btn-block green darken-1']) ?>
                    </div>
                </div>

            <?php } ?>

        <?php if($model->status == PurchaseOrders::WAITING_ENTRY){ ?>

            <div class="row">
                <div class="col s6">
                    <?= Html::a('<i class="material-icons left">note_add</i> Crear entrada', ['create-entry', 'id' => $model->id], ['class' => 'btn btn-block green darken-1']) ?>
                </div>
            </div>

        <?php } ?>


            <?php if(count($model->details) == 0){ ?>
                <div class="row">
                    <div class="col s12">
                        <h6 class="grey-text">
                            Esta orden de compra está vacía y se eliminará automáticamente, puedes
                            <?= Html::a('Eliminarla manualmente', ['delete', 'id' => $model->id], ['data' => ['method' => 'post','confirm' => 'No se puede recuperar una orden eliminada.'],]) ?>
                            o <?= Html::a('Agregar conceptos', ['purchase-order-details/create', 'purchase_order_id' => $model->id]) ?>
                        </h6>
                    </div>
                </div>
            <?php } ?>

        <div class="row">
            <div class="col s12">
                <?php Pjax::begin() ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'responsive-table'],
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'description',
                        'estimated_cost:currency',
                        'real_cost:currency',
                        [
                            'attribute' => 'unit',
                            'value' => 'unit.name',
                            'label' => 'Unidad',
                        ],
                        'quantity',

                        [
                            'class' => 'macgyer\yii2materializecss\widgets\grid\ActionColumn',
                            'template'=>'{update}{delete}',
                            'header' => 'Opciones',

                            'buttons' => [
                                'update' => function ($url, $model) {
                                    if(!Yii::$app->user->getIdentity()->hasAccess("purchase-order-details", "update") || $model->order->status != 1){
                                        return '';
                                    }
                                    return Html::a('<i class="material-icons">edit</i>', $url, [
                                        'data' => [
                                            'pjax' => '0',
                                            'position' => 'top',
                                            'tooltip' => 'Editar',
                                            'params' => [
                                                'id' => $model->id
                                            ],
                                        ],
                                        'class' => 'tooltipped',
                                    ]);
                                },
                                'delete' => function ($url, $model) {
                                    if(!Yii::$app->user->getIdentity()->hasAccess("purchase-order-details", "delete") || $model->order->status != 1){
                                        return '';
                                    }
                                    return Html::a('<i class="material-icons">delete</i>', $url, [
                                        'data' => [
                                            'method' => 'post',
                                            'confirm' => 'No se puede recuperar una partida eliminada.',
                                            'pjax' => '0',
                                            'position' => 'top',
                                            'tooltip' => 'Eliminar',
                                            'params' => [
                                                'id' => $model->id
                                            ],
                                        ],
                                        'class' => 'tooltipped',
                                    ]);
                                },
                            ],
                            'urlCreator' => function ($action, $model) {
                                return Url::toRoute(['purchase-order-details/'.$action, 'id' => $model->id, 'purchase_order_id' => $model->purchase_order_id]);
                            }
                        ],
                    ],
                ]); ?>
                <?php Pjax::end()?>

            </div>
        </div>

    </div>




</div>
