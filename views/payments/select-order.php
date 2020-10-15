<?php

use app\models\Orders;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Selecciona una orden para el pago';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => '/orders/'];
$this->params['breadcrumbs'][] = ['label' => 'Pagos', 'url' => 'index'];
$this->params['breadcrumbs'][] = ['label' => 'Crear', 'url' => 'create'];
$this->params['breadcrumbs'][] = ['label' => 'Elegir orden'];

?>
    <div class="container">

        <div class="row">
            <div class="col s12 m12 l12">
                <h4><?= Html::encode($this->title) ?></h4>
            </div>
        </div>


        <div class="row">
            <div class="col s12 m12 l12">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'responsive-table'],
                    'columns' => [

                        'order_number',
                        [
                            'attribute' => 'status_id',
                            'value' => function($data){
                                return Orders::STATUSES[$data->status];
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'status', Orders::STATUSES, ['prompt' => 'Selecciona un estatus']),
                        ],
                        [
                            'attribute' => 'customer',
                            'value' => 'customer.name',
                            'label' => 'Cliente',

                        ],
                        'due_date:date',
                        'creation_timestamp:date',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template'=>'{select}',
                            'header' => 'Opciones',
                            'buttons' => [
                                'select' => function ($url, $model) {
                                    if(!Yii::$app->user->getIdentity()->hasAccess("orders", "view")){
                                        return '';
                                    }
                                    return Html::a('<i class="material-icons">check_circle</i>', $url, [
                                        'title' => Yii::t('app', 'Seleccionar'),
                                        'data' => [
                                            'position' => 'top',
                                            'tooltip' => 'Seleccionar ésta orden',
                                        ],
                                        'class' => 'tooltipped',
                                    ]);
                                },

                            ],
                            'urlCreator' => function ($action, $model) {
                                if ($action === 'select') {
                                    $url = Url::to(['payments/create', 'order_id' => $model->id]);
                                    return $url;
                                }
                            }
                        ],

                    ],
                ]); ?>
            </div>
        </div>

    </div>
