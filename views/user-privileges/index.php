<?php

use app\models\Privileges;
use app\models\User;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserPrivilegesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user_id int */
/* @var $privilege_id int */

if($user_id){
    $user = User::findOne($user_id);
    $this->title = 'Permisos de '.$user->user;
    $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['user/index']];
    $this->params['breadcrumbs'][] = ['label' => $user->user, 'url' => ['user/update?id='.$user->id]];
    $this->params['breadcrumbs'][] = ['label' => 'Permisos'];
}

else if($privilege_id){
    $privilege = Privileges::findOne($privilege_id);
    $this->title = 'Usuarios de '.$privilege->description;
    $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['user/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['/privileges/index']];
    $this->params['breadcrumbs'][] = ['label' => $privilege->description];
    $this->params['breadcrumbs'][] = ['label' => 'Editar'];
}


?>
<div class="container">

    <div class="row">
        <div class="col m12 l12 s12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <?php if(isset($user)){ ?>
            <?php if(Yii::$app->user->getIdentity()->hasAccess("user-privileges", "create")){ ?>
                <div class="col s12 m4 l4">
                    <?= Html::a('<i class="material-icons left">lock_open</i>Otorgar permiso',  Url::to(['user-privileges/create', 'user_id' => $user->id]), ['class' => 'btn']); ?>
                </div>
            <?php } ?>
            <?php if(Yii::$app->user->getIdentity()->hasAccess("user-roles", "create")){ ?>
                <div class="col s12 m4 l4">
                    <?= Html::a('<i class="material-icons left">group</i>Roles de usuario',  Url::to(['user-roles/create', 'user_id' => $user->id]), ['class' => 'btn']); ?>
                </div>
            <?php } ?>
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

                    [
                        'attribute' => 'user',
                        'value' => 'user.user'
                    ],
                    [
                        'attribute' => 'privilege',
                        'value' => 'privilege.description'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Opciones',
                        'buttons' => [
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("user-privileges", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">remove_circle_outline</i>', $url, [
                                    'title' => 'Revocar',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'Revocarás este permiso del usuario.',
                                        'pjax' => '0',
                                        'position' => 'top',
                                        'tooltip' => 'Revocar permiso',
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
                                $url = Url::to(['user-privileges/delete', 'id' => $model->id]);
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
