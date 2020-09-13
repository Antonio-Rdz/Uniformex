<?php

use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RawMaterialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $assignment_id int */

$this->title = 'Selecciona un material';
$this->params['breadcrumbs'][] = ['label' => 'Producción', 'url' => '/orders/'];
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' => '/line-assignments/'];
$this->params['breadcrumbs'][] = ['label' => '#'.$assignment_id, 'url' => 'index', 'assignment_id' => $assignment_id];
$this->params['breadcrumbs'][] = ['label' => 'Detalles', 'url' => 'index', 'assignment_id' => $assignment_id];
$this->params['breadcrumbs'][] = ['label' => 'Crear', 'url' => 'create'];
$this->params['breadcrumbs'][] = ['label' => 'Elegir material'];
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
                'tableOptions' => ['class' => 'responsive-table'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'description',
                    'average_cost:currency',
                    [
                        'attribute' => 'unit',
                        'label' => 'Unidad',
                        'value' => 'unit.name'
                    ],
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
                    'color',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{select}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'select' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("raw-material", "view")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">check_circle</i>', $url, [
                                    'title' => Yii::t('app', 'Seleccionar'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Seleccionar éste material',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },

                        ],
                        'urlCreator' => function ($action, $model) use ($assignment_id) {
                            if ($action === 'select') {
                                $url = Url::to(['line-assignment-details/create',
                                    'raw_material_id' => $model->id,
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
