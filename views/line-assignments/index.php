<?php

use app\models\LineAssignments;
use app\models\ProductionLines;
use yii\helpers\ArrayHelper;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LineAssignmentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asignaciones de maquilas';
$this->params['breadcrumbs'][] = ['label' => 'Producción'];
$this->params['breadcrumbs'][] = ['label' => 'Maquilas', 'url' => '/production-lines/index'];
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones'];

$production_lines = ArrayHelper::map(ProductionLines::find()->all(), 'id', function ($model){return 'Maquila No. '.$model->id;});
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <?php if(Yii::$app->user->getIdentity()->hasAccess("line-assignments", "create")){ ?>
        <div class="row">
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear asignación', ['create'], ['class' => 'btn']) ?>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col s12 m12 l12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'responsive-table'],
                'columns' => [
                    [
                        'attribute' => 'id',
                        'value' => function($model){
                            return 'Asignación No. ' . $model->id;
                        }
                    ],
                    [
                        'attribute' => 'productionLine',
                        'label' => 'Maquila',
                        'value' => function($model){
                            return 'Maquila No. ' . $model->production_line_id;
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'production_line_id', $production_lines, ['prompt' => 'Selecciona...']),

                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Estatus',
                        'value' => function($model){
                            return LineAssignments::STATUS[$model->status];
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'status', LineAssignments::STATUS, ['prompt' => 'Selecciona...']),
                    ],
                    [
                        'attribute' => 'orderDetail',
                        'label' => 'Usuario',
                        'value' => 'productionLine.user.user'
                    ],
                    [
                        'attribute' => 'orderDetail',
                        'label' => 'Concepto',
                        'value' => 'orderDetail.description'
                    ],
                    [
                        'attribute' => 'order',
                        'label' => 'Número de orden',
                        'format' => 'raw',
                        //'value' => 'orderDetail.order.order_number'
                        'value' => function($data){
                            return Html::a($data->orderDetail->order->order_number, ['order-details/index', 'order_id' => $data->orderDetail->order_id], ['class'=>'no-pjax']);
                        },
                    ],
                    'assigned_timestamp:datetime',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{details}{progress}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'details' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("line-assignment-details", "index")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">list_alt</i>', $url, [
                                    'title' => Yii::t('app', 'Detalles'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Ver detalles',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'progress' => function($url){
                                if(!Yii::$app->user->getIdentity()->hasAccess("line-assignments", "progress")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">timeline</i>', $url, [
                                    'title' => Yii::t('app', 'Ver progreso'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Ver progreso',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'details') {
                                $url = Url::to(['line-assignment-details/index', 'assignment_id' => $model->id]);
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

