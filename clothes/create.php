<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clothes */
/* @var $recordCard app\models\RecordCards */

$this->title = 'Crear Prenda';
$this->params['breadcrumbs'][] = ['label' => 'Inventario'];
$this->params['breadcrumbs'][] = ['label' => 'Prendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                        'recordCard' => $recordCard,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>