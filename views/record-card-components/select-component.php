<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RawMaterialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $recordCard \app\models\RecordCards */

$this->title = 'Seleccionar un material';
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Fichas', 'url' => ['/record-cards/index']];
$this->params['breadcrumbs'][] = ['label' => $recordCard->model, 'url' => ['/record-cards/view', 'id' => $recordCard->id]];
$this->params['breadcrumbs'][] = ['label' => 'Agregar avío', 'url' => ['/record-card-components/create', 'record_card_id' => $recordCard->id]];
$this->params['breadcrumbs'][] = $this->title;
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
                        'urlCreator' => function ($action, $model) use ($recordCard) {
                            if ($action === 'select') {
                                $url = Url::to(['record-card-components/create',
                                    'record_card_id' => $recordCard->id,
                                    'material_id' => $model->id,
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
