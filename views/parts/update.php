<?php

use macgyer\yii2materializecss\lib\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Parts */

$this->title = 'Editar Avío:' . ' ' . $model->name;
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Fichas', 'url' => ['record-cards/index']];
$this->params['breadcrumbs'][] = ['label' => 'Avíos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
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