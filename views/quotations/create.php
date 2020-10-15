<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Quotations */
/* @var $customer \app\models\Customers */
/* @var $cloth \app\models\Clothes */

$this->title = 'Crear cotización';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => ['/orders']];
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                        'customer' => $customer,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
