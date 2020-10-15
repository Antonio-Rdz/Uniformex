<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LineHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historial de producción';
$this->params['breadcrumbs'][] = ['label' => 'Producción'];
$this->params['breadcrumbs'][] = 'Historial';
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

                    'started_timestamp:datetime',
                    [
                        'attribute' => 'produced_timestamp',
                        'value' => function($data){
                            return $data->produced_timestamp ? Yii::$app->formatter->asDatetime($data->produced_timestamp) : "<span class='not-set'>(En progreso)</span>";
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'quantity',
                        'value' => function($data){
                            return $data->quantity ? $data->quantity : "<span class='not-set'>(En progreso)</span>";
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'assignment_id',
                        'value' => function($data){
                            return Html::a("Asignación No. ".$data->assignment_id, ['line-assignments/progress', 'id' => $data->assignment_id]) ;
                        },
                        'format' => 'raw',
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("line-history", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'title' => 'Eliminar',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No se puede recuperar un registro eliminado ¿Continuar?',
                                        'pjax' => '0',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar registro',
                                        'params' => [
                                            'id' => $model->id
                                        ],
                                    ],
                                    'class' => 'tooltipped',
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
