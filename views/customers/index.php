<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <?php if(Yii::$app->user->getIdentity()->hasAccess("customers", "create")){ ?>
        <div class="row">
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear Cliente', ['create'], ['class' => 'btn']) ?>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col s12 m12 l12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'responsive-table'],
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'alias',
                    'name',
                    'rfc',
                    [
                        'attribute' => 'register_time',
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Registro',
                        'value' => function($model){
                            return Yii::$app->formatter->asDateTime($model->register_time);
                        },
                    ],
                    [
                        'attribute' => 'last_updated',
                        'class' => 'yii\grid\DataColumn',
                        'value' => function($model){
                            return Yii::$app->formatter->asDateTime($model->last_updated);
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{update}{view}{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("customers", "edit")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">edit</i>', $url, [
                                    'title' => Yii::t('app', 'Editar'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar cliente',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'view' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("customers-addresses", "index")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">edit_location</i>', $url, [
                                    'title' => Yii::t('app', 'Direcciones'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar direcciones',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("customers", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [ 
                                    'title' => 'Eliminar',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No puedes recuperar un cliente eliminado',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar cliente',
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
                                $url = Url::to(['customers/delete', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'view') {
                                $url = Url::to(['customer-addresses/index', 'customer_id' => $model->id]);
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
