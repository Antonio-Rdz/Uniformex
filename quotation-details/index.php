<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $quotation_id int */
/* @var $searchModel app\models\QuotationDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detalles de cotización';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => '/orders'];
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => '/quotations'];
$this->params['breadcrumbs'][] = "#$quotation_id";
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <?php if(Yii::$app->user->getIdentity()->hasAccess("quotation-details", "create")){ ?>
        <div class="row">
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Agregar concepto', ['create', 'quotation_id' => $quotation_id], ['class' => 'btn']) ?>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col s12 m12 l12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'description',
                    'color',
                    'size',
                    'price',
                    'quantity',
                    [
                        'attribute' => 'customization',
                        'format' => 'boolean',
                        'filter' => [1 => 'Sí', 0 => 'No']
                    ],
                    'additional_notes',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
