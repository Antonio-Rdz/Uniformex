<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SemiClothesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $assignment_id int */

$this->title = 'Selecciona una semiprenda';
$this->params['breadcrumbs'][] = ['label' => 'Producción', 'url' => '/orders/'];
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' => '/line-assignments/'];
$this->params['breadcrumbs'][] = ['label' => '#'.$assignment_id, 'url' => 'index', 'assignment_id' => $assignment_id];
$this->params['breadcrumbs'][] = ['label' => 'Detalles', 'url' => 'index', 'assignment_id' => $assignment_id];
$this->params['breadcrumbs'][] = ['label' => 'Crear', 'url' => 'create'];
$this->params['breadcrumbs'][] = ['label' => 'Elegir semiprenda'];
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'name',
                    'size',
                    'color',
                    'average_cost:currency',

                    [
                        'attribute' => 'stock',
                        'label' => 'Stock',
                        'value' => function($model){
                            /* @var $model \app\models\SemiClothes */
                            $stock = $model->getUnassignedStock();
                            if($stock['available'] > 0){
                                return "<span class='green-text text-darken-1'>".$stock['available']."/".$stock['stock']."</span>";
                            }
                            return "<span class='red-text text-darken-1'>".$stock['available']."/".$stock['stock']."</span>";;
                        },
                        'format' => 'raw',
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{select}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'select' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("cloth", "view")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">check_circle</i>', $url, [
                                    'title' => Yii::t('app', 'Seleccionar'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Seleccionar ésta prenda',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },

                        ],
                        'urlCreator' => function ($action, $model) use ($assignment_id) {
                            if ($action === 'select') {
                                $url = Url::to(['line-assignment-details/create',
                                    'semi_cloth_id' => $model->id,
                                    'assignment_id' => $assignment_id
                                ]);
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
