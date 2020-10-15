<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $order \app\models\Orders */

use app\models\Orders;
use app\models\Sizes;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

//map
$sizes = ArrayHelper::map(Sizes::find()->all(), 'id', 'name');
?>
<?php Pjax::begin(); ?>
<div class="container">

    <div class="row">
        <div class="col s12 m2 offset-m11">
            <div class="btn-group" role="group">
                <?= Html::a('<i class="material-icons">view_module</i>', ['index', 'order_id' => $order->id], ['class' => "btn tooltipped", 'data' => ['tooltip' => 'Vista general', 'position' => 'top',]]) ?>
                <?= Html::button('<i class="material-icons">view_list</i>', ['class' => "btn btn-inactive tooltipped", 'data' => ['tooltip' => 'Vista detallada (actual)', 'position' => 'top',]]) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'responsive-table highlight'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'description',
                    'price',
                    [
                        'attribute' => 'size',
                        'value' => 'size.name',
                        'filter' => Html::activeDropDownList($searchModel, 'size_id', $sizes, ['prompt' => 'Talla']),
                    ],
                    'quantity',

                    'additional_notes',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{assign}{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'assign' => function ($url, $model) {
                                /* @var $model \app\models\OrderDetails */
                                if(!Yii::$app->user->getIdentity()->hasAccess("line-assignments", "create")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">work</i>', $url, [
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Asignar',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'delete' => function ($url, $model)  use ($order) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("order-details", "delete") || $order->status != Orders::NOT_STARTED){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No se puede recuperar un concepto eliminado ¿Continuar?',
                                        'pjax' => '0',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar concepto',
                                        'params' => [
                                            'id' => $model->id
                                        ],
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },

                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'assign') {
                                $url = Url::to(['line-assignments/create', 'order_id' => $model->order_id]);
                                return $url;
                            }
                            if ($action === 'delete') {
                                $url = Url::to(['order-details/delete', 'id' => $model->id, 'order_id' => $model->order_id]);
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
<?php Pjax::end(); ?>

