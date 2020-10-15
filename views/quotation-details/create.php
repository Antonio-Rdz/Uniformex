<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $quotation_id int */
/* @var $model app\models\QuotationDetails */

$this->title = 'Agregar concepto a cotización';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => ['/orders']];
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['/quotations']];
$this->params['breadcrumbs'][] = ['label' => "#$quotation_id", 'url' => ['/quotation-details/index', 'quotation_id' => $quotation_id]];
$this->params['breadcrumbs'][] = 'Agregar concepto';
?>
<div class="container">

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
                        'quotation_id' => $quotation_id
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>