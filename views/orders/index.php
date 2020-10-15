<?php

use app\models\Orders;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ordenes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("orders", "create")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear orden', ['create'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>

        <?php if(Yii::$app->user->getIdentity()->hasAccess("orders", "calendar")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">calendar_today</i> Ver calendario', ['calendar'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
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
                        'template'=>'{manage}{details}{update}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'manage' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("orders", "view")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">assignment_turned_in</i>', $url, [
                                    'title' => Yii::t('app', 'Seguimiento'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Seguimiento',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'details'  => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("order-details", "index")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">list_alt</i>', $url, [
                                    'title' => Yii::t('app', 'Detalles'),
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
                                    'title' => Yii::t('app', 'Editar'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar orden',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'manage') {
                                $url = Url::to(['orders/view', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'details') {
                                $url = Url::to(['order-details/index', 'order_id' => $model->id]);
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

<?php Yii::$app->customAssets->add('line-assignments/select-item.js'); ?>
