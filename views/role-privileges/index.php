<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolePrivilegesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $role_id int */

if($role_id){
    $role = \app\models\Roles::findOne($role_id);
    $this->title = 'Permisos de '.$role->common_name;
    $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['/user/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['roles/index']];
    $this->params['breadcrumbs'][] = ['label' => $role->name, 'url' => ['roles/update?id='.$role->id]];
    $this->params['breadcrumbs'][] = ['label' => 'Permisos'];
}
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <?php if(Yii::$app->user->getIdentity()->hasAccess("role-privileges", "create")){ ?>
        <div class="row">
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Otorgar Permiso', ['create', 'role_id' => $role->id], ['class' => 'btn']) ?>
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
                        'attribute' => 'privilege',
                        'value' => 'privilege.description',
                        'label' => 'Permiso'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Opciones',
                        'buttons' => [
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("role-privileges", "delete")){

                                }
                                return Html::a('<i class="material-icons">remove_circle_outline</i>', $url, [
                                    'title' => 'Revocar',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'Revocarás este permiso del rol.',
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
                                $url = Url::to(['role-privileges/delete', 'id' => $model->id]);
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
