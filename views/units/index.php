<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UnitsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unidades';
$this->params['breadcrumbs'][] = ['label' => 'Inventario'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m4 l4">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <?php if(Yii::$app->user->getIdentity()->hasAccess("units", "create")){ ?>
        <div class="row">
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear Unidad', ['create'], ['class' => 'btn']) ?>
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
                    ['class' => 'yii\grid\SerialColumn'],

                    'name',
                    'short_name',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{update}{stock}{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("units", "edit")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">edit</i>', $url, [
                                    'title' => Yii::t('app', 'Editar'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar unidad',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("units", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'title' => Yii::t('app', 'Eliminar'),
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No puedes recuperar una unidad eliminada',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar unidad',
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
                                $url = Url::to(['units/delete', 'id' => $model->id]);
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
