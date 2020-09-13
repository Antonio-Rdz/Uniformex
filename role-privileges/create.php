<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\RolePrivileges */
/* @var $role_id int */

$role = \app\models\Roles::findOne($role_id);
$this->title = 'Otorgar permiso a '.$role->common_name;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['/user/index']];
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['/roles/index']];
$this->params['breadcrumbs'][] = ['label' => $role->name, 'url' => ['user/update', 'id' => $role_id]];
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['role-privileges/index', 'role_id' => $role_id]];
$this->params['breadcrumbs'][] = ['label' => 'Otorgar'];
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m4 l4">
            <?= Html::a('<i class="material-icons left">add</i> Nuevo permiso',  Url::to(['privileges/create']), ['class' => 'btn']); ?>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12">
            <div class="card white">
                <div class="card-content">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'role_id' => $role_id
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
