<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => '/user/index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <?php if(Yii::$app->user->getIdentity()->hasAccess("roles", "create")){ ?>
    <div class="row">
        <div class="col s12 m4 l4">
            <?= Html::a('<i class="material-icons left">group_add</i> Crear nuevo rol', ['create'], ['class' => 'btn']) ?>
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
                    'common_name',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{update}{view}{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("roles", "update")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">edit</i>', $url, [
                                    'title' => Yii::t('app', 'Editar'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar rol',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'view' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("role-privileges", "index")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">lock_open</i>', $url, [
                                    'title' => Yii::t('app', 'Permisos'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar permisos',
                                        'pjax' => '0'
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("roles", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'title' => 'Eliminar',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No puedes recuperar un rol eliminado.',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar rol',
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
                                $url = Url::to(['roles/delete', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'view') {
                                $url = Url::to(['role-privileges/index', 'role_id' => $model->id]);
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
