<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Editar usuario: ' . $model->user;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Editar'];
?>
<div class="container">

    <div class="row">
        <div class="col m12 s12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col m12">
            <a href="<?=Url::to(['user-privileges/index', 'user_id' => $model->id])?>" class="btn">
                <i class="material-icons left">
                    lock_open
                </i>
                Editar permisos
            </a>
            <a href="<?=Url::to(['user-roles/index', 'user_id' => $model->id])?>" class="btn">
                <i class="material-icons left">
                    group_add
                </i>
                Asignar rol
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12">
            <div class="card white">
                <div class="card-content">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
