<?php

use app\models\Customers;
use app\models\Orders;
use yii\helpers\Html;
use yii\widgets\DetailView;

$formatter = Yii::$app->formatter;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
/* @var $searchModel app\models\LineAssignmentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Seguimiento - ".$model->order_number;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$order_statuses = Orders::STATUSES;
unset($order_statuses[Orders::ON_CUT]);
unset($order_statuses[Orders::ON_FINISHES]);
unset($order_statuses[Orders::WAITING_FOR_PAYMENT]);
$progress = $model->getProgress();
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($model->order_number) ?></h4>
        </div>
    </div>

    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("orders", "update")){ ?>
        <div class="col s12 m6 l6">
            <?= Html::a('<i class="material-icons left">edit</i> Editar fechas', ['update', 'id' => $model->id], ['class' => 'btn green darken-1']) ?>
        </div>
        <?php } if(Yii::$app->user->getIdentity()->hasAccess("orders", "delete")){ ?>
        <div class="col s12 m6 l6">
            <?= Html::a('<i class="material-icons left">cancel</i> Cancelar orden', ['delete', 'id' => $model->id], [
                'class' => 'btn red darken-1',
                'data' => [
                    'confirm' => '¿Seguro que quieres cancelar ésta orden?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <?php } ?>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'order_number',
                            'creation_timestamp:datetime',
                            [
                                'attribute' => 'status',
                                'value' => function($model){
                                    return Orders::STATUSES[$model->status];
                                },
                            ],
                            [
                                'attribute' => 'customer_id',
                                'value' => function($model){
                                    return Customers::findOne([$model->customer_id])->name;
                                },
                            ],
                            'due_date:date',
                            'payment_due_date:date'
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <?php if($model->hasEnoughStock() && $model->status != Orders::SENT){ ?>
        <div class="row center">
            <div class="col s12 m12 l12">
                <h5>Las prendas necesarias para ésta orden se encuentran disponibles.</h5>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6 offset-l3 offset-m3">
                <?= Html::a('<i class="material-icons left">local_shipping</i> Proceder a envío <i class="material-icons right">arrow_right_alt</i>', ['shipments/create', 'order_id' => $model->id], ['class' => 'btn blue darken-1']) ?>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col s12 m12 l12">
            <ul class="h-timeline" id="timeline">
                <?php foreach ($order_statuses as $idx => $status){
                    $info = $model->getStatusInfo($idx); ?>
                    <li class="li <?= $info['li_class'] ?>">
                        <div class="timestamp">
                            <span class="author"><b><?= $info['author'] ?></b></span>
                            <span class="date"><?= $info['date'] ?><span>
                        </div>
                        <div class="status">
                            <h6> <?= $info['label'] ?> </h6>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <h5>Asignaciones de ésta orden</h5>
        </div>
    </div>

    <?php if(Yii::$app->user->getIdentity()->hasAccess("line-assignments", "create")){ ?>
        <div class="row">
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear asignación', ['line-assignments/create', 'order_id' => $model->id], ['class' => 'btn']) ?>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <?= $this->render('_assignments', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]); ?>
                    <div class="row center">
                        <div class="col s12 m12 l12">
                            <h6>Progreso: <?=$progress['fabricated']?>/<?=$progress['required']?> piezas</h6>
                            <progress class="progress" max="100" value="<?=$progress['percentage']?>"></progress>
                            <h6>(<?=$progress['percentage']?>%)</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
