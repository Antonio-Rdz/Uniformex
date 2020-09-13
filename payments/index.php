<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pagos';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => '/orders/index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12m 12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <?php if(Yii::$app->user->getIdentity()->hasAccess("payments", "create")){ ?>
    <div class="row">
        <div class="col s12 m4 l4">
            <?= Html::a('<i class="material-icons left">add</i> Registrar Pago', ['create'], ['class' => 'btn']) ?>
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

                    'amount',
                    'paid_date:date',
                    [
                        'attribute' => 'status_id',
                        'value' => function($data){
                            return \app\models\Payments::STATUS[$data->status_id];
                        }
                    ],
                    [
                        'attribute' => 'order',
                        'label' => 'Orden',
                        'format' => 'raw',
                        'value' => function($data){
                            return Html::a($data->order->order_number, ['order-details/index', 'order_id' => $data->order->id], ['class'=>'no-pjax']);
                        },
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
