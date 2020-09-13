<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Selecciona un avío';
$this->params['breadcrumbs'][] = ['label' => 'Inventario', 'url' => '/orders/'];
$this->params['breadcrumbs'][] = ['label' => 'Avíos', 'url' => '/parts/'];
$this->params['breadcrumbs'][] = ['label' => 'Entradas', 'url' => 'index'];
$this->params['breadcrumbs'][] = ['label' => 'Crear', 'url' => 'create'];
$this->params['breadcrumbs'][] = ['label' => 'Elegir Avío'];
?>
<?php Pjax::begin(); ?>
    <div class="container">

        <div class="row">
            <div class="col s12 m12 l12">
                <h4><?= Html::encode("Selecciona un avío para dar entrada") ?></h4>
            </div>
        </div>


        <div class="row">
            <div class="col s12 m12 l12">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'responsive-table'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'name',
                        [
                            'attribute' => 'stock',
                            'label' => 'Stock',
                            'value' => function($model){
                                /* @var $model \app\models\Parts*/
                                return $model->getStock();
                            }
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template'=>'{select}',
                            'header' => 'Opciones',
                            'buttons' => [
                                'select' => function ($url, $model) {
                                    return Html::a('<i class="material-icons">check_circle</i>', $url, [
                                        'title' => Yii::t('app', 'Seleccionar'),
                                        'data' => [
                                            'position' => 'top',
                                            'tooltip' => 'Seleccionar éste avío',
                                            'pjax' => '0',
                                        ],
                                        'class' => 'tooltipped',
                                    ]);
                                },

                            ],
                            'urlCreator' => function ($action, $model) {
                                if ($action === 'select') {
                                    $url = Url::to(['part-entries/create', 'part_id' => $model->id]);
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
