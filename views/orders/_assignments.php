<?php

use app\models\LineAssignments;
use app\models\ProductionLines;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LineAssignmentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$production_lines = ArrayHelper::map(ProductionLines::find()->all(), 'id', function ($model){return 'Maquila No. '.$model->id;});
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => ['class' => 'responsive-table'],
    'columns' => [
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
                return Url::toRoute(['line-assignments/'.$action, 'id' => $model->id]);
            }
        ],
    ],
]); ?>

