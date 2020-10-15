<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PartsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Avíos';
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Fichas', 'url' => ['/record-cards/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">

        <?php if(Yii::$app->user->getIdentity()->hasAccess("parts", "create")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear avío', ['create'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>

        <?php if(Yii::$app->user->getIdentity()->hasAccess("part-entries", "index")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">list_alt</i> Revisar entradas', ['/part-entries/index'], ['class' => 'btn']) ?>
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

                    'name',
                    [
                        'attribute' => 'stock',
                        'label' => 'Stock',
                        'value' => function($model){
                            /* @var $model \app\models\Parts */
                            return $model->getStock(null, true);
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{create-entry}{update}{delete}',
                        'header' => 'Opciones',

                        'buttons' => [
                            'create-entry' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("part-entries", "create")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">library_add</i>', $url, [
                                    'data' => [
                                        'pjax' => '0',
                                        'position' => 'top',
                                        'tooltip' => 'Crear entrada',
                                        'params' => [
                                            'id' => $model->id
                                        ],
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("parts", "update")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">edit</i>', $url, [
                                    'data' => [
                                        'pjax' => '0',
                                        'position' => 'top',
                                        'tooltip' => 'Editar avío',
                                        'params' => [
                                            'id' => $model->id
                                        ],
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("parts", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No se puede recuperar una parte eliminada.',
                                        'pjax' => '0',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar avío',
                                        'params' => [
                                            'id' => $model->id
                                        ],
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model) {

                            if($action == 'create-entry'){
                                return Url::to(['part-entries/create', 'part_id' => $model->id]);
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
