<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RawMaterialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Materiales';
$this->params['breadcrumbs'][] = ['label' => 'Inventario'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("raw-material", "create")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear material', ['create'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
        <?php if(Yii::$app->user->getIdentity()->hasAccess("units", "index")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">line_style</i> Gestionar unidades', ['units/index'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
        <?php if(Yii::$app->user->getIdentity()->hasAccess("raw-material-entries", "index")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">list_alt</i> Revisar entradas', ['raw-material-entries/index'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'responsive-table highlight'],
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
                            /* @var $model \app\models\Clothes*/
                            return $model->getStock();
                        }
                    ],
                    'color',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{view}{update}{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("raw-material", "view")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">remove_red_eye</i>', $url, [
                                    'title' => Yii::t('app', 'Información'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Más información',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("raw-material", "update")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">edit</i>', $url, [
                                    'title' => Yii::t('app', 'Editar'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar material',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("raw-material", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'title' => Yii::t('app', 'Eliminar'),
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No puedes recuperar un material eliminado',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar material',
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
                                $url = Url::to(['raw-material/delete', 'id' => $model->id]);
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
