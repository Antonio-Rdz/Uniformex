<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerAddresses */

$this->title = 'Editar dirección "' . $model->alias.'"';
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['/customers/index']];
$this->params['breadcrumbs'][] = ['label' => 'Direcciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->alias];
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

<?= Yii::$app->customAssets->add('customer-address/autocomplete.js'); ?>
