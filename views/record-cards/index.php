<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecordCardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fichas';
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <?php if(Yii::$app->user->getIdentity()->hasAccess("record-cards", "create")){ ?>
    <div class="row">
        <div class="col s12 m4 l4">
            <?= Html::a('<i class="material-icons left">add</i> Crear Ficha', ['create'], ['class' => 'btn']) ?>
        </div>
    </div>
    <?php } ?>

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
                            return isset($data->orderDetails[0]) ? $data->orderDetails[0]->order->customer->name : 'No disponible';
                        }
                    ],
                    'additional_notes',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{view}{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("record-cards", "view")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">visibility</i>', $url, [
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Ver ficha',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("record-cards", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No puedes recuperar una ficha eliminada',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar ficha',
                                        'pjax' => '0',
                                        'params' => [
                                            'id' => $model->id
                                        ],
                                    ],
                                    'class' => 'tooltipped'
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
