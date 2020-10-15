<?php

use app\models\PurchaseOrders;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Órdenes de compra';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-orders-index">

    <div class="container">
        <div class="row">
            <div class="col s12">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
        </div>

        <div class="row">
            <div class="col s12 m4">
                <?= Html::a('<i class="material-icons left">add</i>Crear orden de compra', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'responsive-table'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'order_number',
                            'value' => 'order.order_number',
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function($data){
                                return PurchaseOrders::STATUSES[$data->status];
                            }
                        ],
                        'requested_date:date',
                        'arrival_date:date',
                        'user.user',
                        'supplier.name',

                        [
                            'class' => 'macgyer\yii2materializecss\widgets\grid\ActionColumn',
                            'template'=>'{view}{update}',
                            'header' => 'Opciones',
                            'buttons' => [
                                'view'  => function ($url, $model) {
                                    if(!Yii::$app->user->getIdentity()->hasAccess("purchase-orders-details", "index")){
                                        return '';
                                    }
                                    return Html::a('<i class="material-icons">list_alt</i>', $url, [
                                        'data' => [
                                            'position' => 'top',
                                            'tooltip' => 'Detalles',
                                            'pjax' => '0',
                                        ],
                                        'class' => 'tooltipped',
                                    ]);
                                },
                                'update' => function ($url, $model) {
                                    if(!Yii::$app->user->getIdentity()->hasAccess("orders", "update")){
                                        return '';
                                    }
                                    return Html::a('<i class="material-icons">edit</i>', $url, [
                                        'data' => [
                                            'position' => 'top',
                                            'tooltip' => 'Editar orden',
                                            'pjax' => '0',
                                        ],
                                        'class' => 'tooltipped',
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>

</div>
