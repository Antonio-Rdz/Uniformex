<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecordCardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $order \app\models\Orders */
/* @var $product_id int */


$this->title = 'Seleccionar ficha';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => ['/orders/index', 'order_id' => $order->id]];
$this->params['breadcrumbs'][] = ['label' => $order->order_number, 'url' => ['order-details/index', 'order_id' => $order->id]];
$this->params['breadcrumbs'][] = ['label' => "Agregar concepto", 'url' => ['order-details/create', 'order_id' => $order->id, 'product_id' => $product_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <?php Pjax::begin(); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'responsive-table highlight'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'model',
                    'description',
                    [
                        'attribute' => 'customer',
                        'label' => 'Cliente',
                        'value' => function($data){
                            /* @var $data \app\models\RecordCards */
                            return isset($data->orderDetails[0]) ? $data->orderDetails[0]->order->customer->name : 'Desconocido';
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{select}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'select' => function ($url, $model) {
                                return Html::a('<i class="material-icons">check_circle</i>', $url, [
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Seleccionar ésta ficha',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },

                        ],
                        'urlCreator' => function ($action, $model) use ($product_id) {
                            if ($action === 'select') {
                                $url = Url::to(['order-details/create', 'order_id' => $_GET['order_id'], 'record_card_id' => $model->id, 'product_id' => $product_id]);
                                return $url;
                            }
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>
            <?php Pjax::end();?>
        </div>
    </div>

</div>
