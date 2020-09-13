<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\models\UserRolesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user_id int */

$user = \app\models\User::findOne($user_id);
$this->title = 'Roles de '.$user->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => '/user/idex'];
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => '/roles/index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>

        </div>
    </div>

    <?php if(Yii::$app->user->getIdentity()->hasAccess("user-roles", "create")){ ?>
        <div class="row">
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">group_add</i> Asignar Rol', ['create', 'user_id' => $user_id], ['class' => 'btn']) ?>
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

                    [
                        'attribute' => 'role_name',
                        'value' => 'role.name',
                        'label' => 'Identificador de Rol'
                    ],
                    [
                        'attribute' => 'role_common_name',
                        'value' => 'role.common_name',
                        'label' => 'Nombre de Rol'
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Opciones',
                        'buttons' => [
                            'delete' => function ($url, $model) {
                                if(Yii::$app->user->getIdentity()->hasAccess("user-roles", "delete")){
                                    return '';
                                }
                                if($model->user_id === Yii::$app->user->id){return '';}
                                return Html::a('<i class="material-icons">remove_circle_outline</i>', $url, [
                                    'title' => 'Retirar rol',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'Retirarás este rol del usuario.',
                                        'pjax' => '0',
                                        'position' => 'top',
                                        'tooltip' => 'Retirar rol',
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
                                $url = Url::to(['user-roles/delete', 'id' => $model->id]);
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
