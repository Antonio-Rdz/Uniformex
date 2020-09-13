<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RawMaterial */

$this->title = 'Crear Material';
$this->params['breadcrumbs'][] = ['label' => 'Inventario'];
$this->params['breadcrumbs'][] = ['label' => 'Materiales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Crear'];
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
