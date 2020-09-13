<?php

use app\models\ProductionLines;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductionLinesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Maquilas';
$this->params['breadcrumbs'][] = ['label' => 'Producción'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m4 l4">
            <?= Html::a('<i class="material-icons left">add</i> Agregar una maquila', ['create'], ['class' => 'btn']) ?>
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
                    [
                        'attribute' => 'id',
                        'label' => 'Número',
                        'value' => 'id'
                    ],

                    [
                        'attribute' => 'status',
                        'value' => function($data){
                            /* @var $data ProductionLines */
                            return ProductionLines::STATUSES[$data->status];
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'status', ProductionLines::STATUSES, ['prompt' => 'Selecciona un estatus']),
                    ],
                    [
                        'attribute' => 'type',
                        'value' => function($data){
                            /* @var $data ProductionLines */
                            return ProductionLines::TYPES[$data->type];
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'type', ProductionLines::TYPES, ['prompt' => 'Selecciona un tipo']),
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{update}{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("privileges", "update")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">edit</i>', $url, [
                                    'title' => Yii::t('app', 'Editar'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar maquila',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("privileges", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'title' => 'Eliminar',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No se puede recuperar una maquila eliminada ¿Continuar?',
                                        'pjax' => '0',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar maquila',
                                        'params' => [
                                            'id' => $model->id
                                        ],
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'delete') {
                                $url = Url::to(['production-lines/delete', 'id' => $model->id]);
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
