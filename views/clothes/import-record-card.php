<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecordCardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Importar ficha';
$this->params['breadcrumbs'][] = ['label' => 'Inventario'];
$this->params['breadcrumbs'][] = ['label' => 'Prendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Crear prenda', 'url' => ['create']];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode('Selecciona una ficha para importar') ?></h4>
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
                        'template'=>'{select}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'select' => function ($url, $model) {
                                return Html::a('<i class="material-icons">check_circle</i>', $url, [
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Seleccionar ésta ficha',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },

                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'select') {
                                $url = Url::to(['clothes/create', 'record_card_id' => $model->id]);
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
