<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>



    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("user", "create")){ ?>
            <div class="col m4 l4 s12">
                <?= Html::a('<i class="material-icons left">add</i> Crear Usuario', ['create'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
        <?php if(Yii::$app->user->getIdentity()->hasAccess("privileges", "index")){ ?>
            <div class="col m4 l4 s12">
                <?= Html::a('<i class="material-icons left">lock_open</i> Gestionar Permisos', ['privileges/index'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
        <?php if(Yii::$app->user->getIdentity()->hasAccess("roles", "index")){ ?>
            <div class="col m4 l4 s12">
                <?= Html::a('<i class="material-icons left">supervised_user_circle</i> Gestionar Roles', ['roles/index'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
    </div>

    <div class="row">
        <div class="col m12 l12 s12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'responsive-table'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'user',
                    'email:email',
                    'first_name',
                    'last_name',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{update}{privileges}{roles}{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("user", "update")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">edit</i>', $url, [
                                    'title' => Yii::t('app', 'Editar'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar usuario',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'privileges' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("user-privileges", "index")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">lock_open</i>', $url, [
                                    'title' => Yii::t('app', 'Permisos'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar permisos',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'roles' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("units", "create")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">supervised_user_circle</i>', $url, [
                                    'title' => Yii::t('app', 'Editar'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Roles de usuario',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if($model->id === Yii::$app->user->id || !Yii::$app->user->getIdentity()->hasAccess("user-roles", "index")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'title' => 'Eliminar',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No puedes recuperar un usuario eliminado',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar usuario',
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
                                $url = Url::to(['user/delete', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'privileges') {
                                $url = Url::to(['user-privileges/index', 'user_id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'roles') {
                                $url = Url::to(['user-roles/index', 'user_id' => $model->id]);
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