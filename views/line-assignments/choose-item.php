<?php

use app\models\Orders;
use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Selecciona una orden para la asignación';
$this->params['breadcrumbs'][] = ['label' => 'Producción'];
$this->params['breadcrumbs'][] = ['label' => 'Maquilas', 'url' => '/production-lines/index'];
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' => 'index'];
$this->params['breadcrumbs'][] = ['label' => 'Crear', 'url' => 'create'];
$this->params['breadcrumbs'][] = "Seleccionar orden";
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
                            'attribute' => 'status',
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
                                    $url = Url::to(['line-assignments/create', 'order_id' => $model->id]);
                                    return $url;
                                }
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],

                    ],
                ]); ?>
            </div>
        </div>

    </div>
