<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\UserPrivileges */
/* @var $user_id int */

$user = \app\models\User::findOne($user_id);
$this->title = 'Otorgar permiso a '.$user->user;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['user/index']];
$this->params['breadcrumbs'][] = ['label' => $user->user, 'url' => ['user/update', 'id' => $user_id]];
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['user-privileges/index', 'user_id' => $user_id]];
$this->params['breadcrumbs'][] = ['label' => 'Otorgar'];
?>

<div class="container">

    <div class="row">
        <div class="col m12 s12 l12">
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
                        'user_id' => $user_id
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
