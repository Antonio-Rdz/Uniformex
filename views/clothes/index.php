<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClothesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prendas';
$this->params['breadcrumbs'][] = ['label' => 'Inventario'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m4 l4">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("clothes", "create")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear prenda', ['create'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
         <?php if(Yii::$app->user->getIdentity()->hasAccess("cloth-entries", "index")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">list_alt</i> Revisar entradas', ['/cloth-entries/index'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
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
                    [
                        'attribute' => 'stock',
                        'label' => 'Stock',
                        'value' => function($model){
                            /* @var $model \app\models\Clothes*/
                            return $model->getStock();
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{view}{update}{delete}{entry}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("record-cards", "view")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">remove_red_eye</i>', $url, [
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Ver ficha',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("clothes", "update")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">edit</i>', $url, [
                                    'title' => Yii::t('app', 'Editar'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar prenda',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("clothes", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'title' => Yii::t('app', 'Eliminar'),
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No puedes recuperar una prenda eliminada',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar prenda',
                                        'pjax' => '0',
                                        'params' => [
                                            'id' => $model->id
                                        ],
                                    ],
                                    'class' => 'tooltipped'
                                ]);
                            },
                            'entry' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("cloth-entries", "create")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">library_add</i>', $url, [
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Crear entrada',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'delete') {
                                $url = Url::to(['clothes/delete', 'id' => $model->id]);
                                return $url;
                            }
                            if($action == 'view'){
                                return Url::to(['record-cards/view', 'id' => $model->record_card_id]);
                            }
                            if($action == 'entry'){
                                return Url::to(['cloth-entries/create', 'cloth_id' => $model->id]);
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
