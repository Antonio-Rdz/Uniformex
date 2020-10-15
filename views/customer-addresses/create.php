<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerAddresses */
/* @var $customer_id int */

$customer = \app\models\Customers::findOne($customer_id);
$this->title = 'Agregar dirección a '.$customer->name;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Direcciones', 'url' => ['/customer-addresses/index', 'customer_id' => $customer_id]];
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
                        'customer_id' => $customer_id
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
