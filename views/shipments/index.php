<?php

use app\models\DeliveryOffices;
use yii\helpers\ArrayHelper;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShipmentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Envíos';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => '/orders'];
$this->params['breadcrumbs'][] = $this->title;
$filter_delivery = ArrayHelper::map(DeliveryOffices::find()->all(), 'id', 'name');

?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>


    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("shipments", "create")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear envío', ['create'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
        <?php if(Yii::$app->user->getIdentity()->hasAccess("delivery-offices", "index")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">local_shipping</i> Gestionar paqueterías', ['/delivery-offices/'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
    </div>


    <div class="row">
        <div class="col s12 m12 l12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'order_id',
                        'value' => 'order.order_number'
                    ],
                    [
                        'attribute' => 'delivery_office_id',
                        'value' => 'deliveryOffice.name',
                        'filter' => Html::activeDropDownList($searchModel, 'delivery_office_id', $filter_delivery, ['prompt' => 'Selecciona...']),
                    ],
                    'cost',
                    [
                        'attribute' => 'delivered_date',
                        'format' => 'raw',
                        'value' => function($data){
                            /* @var $data \app\models\Shipments */
                            if(!$data->delivered_date){
                                return '<span class="not-set">(sin entregar)</span>';
                            }
                            return Yii::$app->formatter->asDate($data->delivered_date);
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{update}{stock}{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("shipment", "update") || $model->delivered_date){
                                    return '';
                                }
                                return \macgyer\yii2materializecss\lib\Html::a('<i class="material-icons">check_circle_outline</i>', $url, [
                                    'title' => Yii::t('app', 'Marcar como entregado'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Marcar como entregado',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("shipment", "delete") || $model->delivered_date){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'title' => Yii::t('app', 'Eliminar envío'),
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No puedes recuperar un envío eliminado',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar envío',
                                        'pjax' => '0',
                                        'params' => [
                                            'id' => $model->id
                                        ],
                                    ],
                                    'class' => 'tooltipped'
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'delete') {
                                $url = Url::to(['clothes/delete', 'id' => $model->id]);
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


