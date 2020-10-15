<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Privileges */
/* @var $controllers_and_actions array */
$this->title = 'Crear permiso';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

foreach ($controllers_and_actions as $controller => $item) {
    $controllers[$controller] = "";
}
?>
<div class="container">
    <textarea id="controllers_and_actions_serialized" cols="30" rows="30" class="hidden"><?=json_encode($controllers_and_actions)?></textarea>
    <textarea id="controllers_serialized" cols="30" rows="30" class="hidden"><?=json_encode($controllers)?></textarea>
    <div class="row">
        <div class="col m12 s12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
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
