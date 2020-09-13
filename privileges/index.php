<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PrivilegesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Permisos';

$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['user/index']];
$this->params['breadcrumbs'][] = ['label' => 'Permisos'];
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <?php if(Yii::$app->user->getIdentity()->hasAccess("privileges", "create")){ ?>
        <div class="row">
            <div class="col m12 s12 l12">
                <p>
                    <?= Html::a('<i class="material-icons left">add</i> Nuevo permiso', ['create'], ['class' => 'btn']) ?>
                </p>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col m12 s12 l12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'responsive-table'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'description',
                    'controller',
                    'action',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{update}{view}{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("user-privileges", "index")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">lock_open</i>', $url, [
                                    'title' => Yii::t('app', 'Permisos'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Ver usuarios autorizados',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("privileges", "update")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">edit</i>', $url, [
                                    'title' => Yii::t('app', 'Permisos'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar permiso',
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
                                        'confirm' => 'Éste permiso se elminará para siempre y la acción vinculada quedará desprotegida.',
                                        'pjax' => '0',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar permiso',
                                        'params' => [
                                            'id' => $model->id
                                        ],
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'view') {
                                $url = Url::to(['user-privileges/index', 'privilege_id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'delete') {
                                $url = Url::to(['privileges/delete', 'id' => $model->id]);
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
