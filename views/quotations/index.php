<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuotationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cotizaciones';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => '/orders'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>

        </div>
    </div>

    <?php if(Yii::$app->user->getIdentity()->hasAccess("quotations", "create")){ ?>
        <div class="row">
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear cotización', ['create'], ['class' => 'btn']) ?>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col s12 m12 l12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'attribute' => 'customer_id',
                        'value' => 'customer.name',
                    ],
                    [
                        'attribute' => 'user_id',
                        'value' => 'user.user',
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{generate}{details}{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'generate' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("orders", "view")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">library_add</i>', $url, [
                                    'title' => Yii::t('app', 'Crear orden'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Crear orden',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'details'  => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("quotation-details", "index")){
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
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("delivery-offices", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'title' => Yii::t('app', 'Eliminar'),
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No puedes recuperar una cotización eliminada',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar',
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
                            if ($action === 'generate') {
                                $url = Url::to(['/orders/create', 'quotation_id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'details') {
                                $url = Url::to(['quotation-details/index', 'quotation_id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'delete') {
                                $url = Url::to(['quotation-details/delete', 'id' => $model->id]);
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
