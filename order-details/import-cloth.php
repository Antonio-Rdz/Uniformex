<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $order_id int */

$order = \app\models\Orders::findOne($order_id);
$this->title = 'Selecciona una prenda';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => '/orders/'];
$this->params['breadcrumbs'][] = ['label' => $order->order_number, 'url' => ['index', 'order_id' => $order_id]];
$this->params['breadcrumbs'][] = ['label' => 'Agregar concepto', 'url' => ['create', 'order_id' => $order_id]];
$this->params['breadcrumbs'][] = ['label' => 'Elegir prenda'];
?>
    <div class="container">

        <div class="row">
            <div class="col s12 m12 l12">
                <h4><?= Html::encode("Selecciona una prenda para agregar a la orden") ?></h4>
            </div>
        </div>


        <div class="row">
            <div class="col s12 m12 l12">
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'responsive-table'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'name',
                        'description',
                        'cost:currency',
                        [
                            'attribute' => 'stock',
                            'label' => 'Stock',
                            'value' => function($model){
                                /* @var $model \app\models\Clothes*/
                                return $model->getStock();
                            }
                        ],
                        'size',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template'=>'{select}',
                            'header' => 'Opciones',
                            'buttons' => [
                                'select' => function ($url, $model) {
                                    if(!Yii::$app->user->getIdentity()->hasAccess("cloth", "view")){
                                        return '';
                                    }
                                    return Html::a('<i class="material-icons">check_circle</i>', $url, [
                                        'title' => Yii::t('app', 'Seleccionar'),
                                        'data' => [
                                            'position' => 'top',
                                            'tooltip' => 'Seleccionar ésta prenda',
                                            'pjax' => '0',
                                        ],
                                        'class' => 'tooltipped',
                                    ]);
                                },

                            ],
                            'urlCreator' => function ($action, $model) {
                                if ($action === 'select') {
                                    $url = Url::to(['order-details/create', 'order_id' => $_GET['order_id'], 'cloth_id' => $model->id]);
                                    return $url;
                                }
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>

    </div>
