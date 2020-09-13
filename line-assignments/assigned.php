<?php

use app\models\LineHistory;
use app\models\OrderDetails;
use app\models\Orders;
use yii\helpers\Html;
use app\models\LineAssignments;

/* @var $assignments array */
/* @var $_status int */
/* @var $this yii\web\View */

$this->title = 'Mis asignaciones';
$this->params['breadcrumbs'][] = ['label' => 'Producción'];
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="btn-group" role="group">
                <?php foreach (LineAssignments::STATUS as $value => $STATUS) {
                    $btn_class = "";
                    if($value != $_status){
                        $btn_class = "btn-inactive";
                    }
                    echo Html::a($STATUS, ["line-assignments/assigned", "status" => $value], ['class' => "btn $btn_class"]);
                } ?>
            </div>
        </div>
    </div>
    <?php
    foreach ($assignments as $order_number => $_assignment){ ?>
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card">
                <div class="card-content">
                    <span class="card-title">Orden <?= $order_number ?></span>
                    <div class="row">
            <?php foreach ($_assignment as $idx => $assignment) {
                /* @var $assignment \app\models\LineAssignments */
                $order_detail = $assignment->orderDetail;
                $order = $order_detail->order;
                $progress = $order_detail->order->getProgress();
                $created_pieces = LineHistory::getCreatedPieces($assignment->order_detail_id); ?>
                <div class="col s12 m4 l4">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">
                                <?= Html::a($order_detail->description, ['view-materials'], [
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Ver materiales',
                                    ],
                                    'class' => 'tooltipped',
                                ]) ?>
                            </span>
                            <!-- Dropdown Trigger -->
                            <p>
                                Talla <?= $order_detail->size ?> | Maquila No.<?= $assignment->production_line_id ?>
                            </p>
                            <p>
                                <b>Progreso: <?= $created_pieces . "/" . $order_detail->quantity ?> piezas
                                    (<?= (round($created_pieces / $order_detail->quantity * 100)) ?>%)</b>
                            </p>
                            <p>
                                Asignado el <?= Yii::$app->formatter->asDate($assignment->assigned_timestamp) ?>
                            </p>
                            <p>
                                <b>Status: <?= $assignment->getStatus() ?></b>
                            </p>
                        </div>
                        <div class="card-action">
                            <?php if ($assignment->ready_timestamp) {
                                if ($assignment->status == LineAssignments::NOT_STARTED || $assignment->status == LineAssignments::ON_PAUSE) {
                                    echo Html::a("<i class='material-icons left'>play_arrow</i> Trabajar en esto", ["line-history/create", "assignment_id" => $assignment->id]);
                                } else if ($assignment->status == 1) {
                                    echo Html::a("<i class='material-icons left'>pause_circle_filled</i> Dejar de trabajar en esto", ["line-history/stop-working", "assignment_id" => $assignment->id]);
                                } else if($assignment->status == 3){
                                    echo Html::a("<i class='material-icons left'>check_circle</i> Terminado", null, ['class' => 'green-text darken-1', 'style' => 'cursor:default;']);
                                }
                            } else if($assignment->status != LineAssignments::CANCELED) {
                                echo Html::a("<i class='material-icons left'>access_time</i> Esperando material...", null, ['class' => 'grey-text']);
                            } else {
                                echo Html::a("<i class='material-icons left'>cancel</i> Asignación cancelada", null, ['class' => 'grey-text']);

                            } ?>
                        </div>
                    </div>
                </div>
                    <?php } ?>
                    </div>
                    <?php if($_status != LineAssignments::CANCELED) { ?>
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h6 class="center">Progreso total: <?=$progress['fabricated']?>/<?=$progress['required']?> (<?=$progress['percentage']?>%) </h6>
                            <progress class="progress" max="100" value="<?=$progress['percentage']?>"></progress>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php
    if(empty($assignments)){?>
        <div class="row">
            <div class="col s12 l12 m12">
                <div id="w2-success-0" class="materialert default">
                    <i class="material-icons">info</i> No tienes asignaciones con éste estatus
                </div>
            </div>
        </div>
    <?php } ?>
</div>
