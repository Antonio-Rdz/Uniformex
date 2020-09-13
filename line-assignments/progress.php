<?php

use app\lib\Utilities;
use app\models\LineAssignments;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $assignment app\models\LineAssignments */
/* @var $entries app\models\LineHistory[] */

$this->title = 'Avance de asignación #'.$assignment->id;
$this->params['breadcrumbs'][] = ['label' => 'Producción'];
$this->params['breadcrumbs'][] = ['label' => 'Maquilas', 'url' => '/production-lines/index'];
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' => '/line-assignments/index'];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$detail = \app\models\OrderDetails::findOne($assignment->order_detail_id);
$order = \app\models\Orders::findOne($detail->order_id);
$user = \app\models\User::findOne($assignment->user_id);
$formatter = Yii::$app->formatter;

$progress = $assignment->getProgress();
$total_avg_time = 0;
?>

<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4>
                <?= Html::encode($this->title) ?>
                <?= $progress['percentage'] == 100 ?
                    ' <span class="green-text text-darken-1"><i class="material-icons">check_circle</i> Completado</span>' :
                    '  <span class="grey-text text-darken-1"><i class="material-icons">access_time</i> ('.$progress['percentage'].'%) </span>' ?>
            </h4>
        </div>
    </div>

    <?php if(Yii::$app->user->getIdentity()->hasAccess("line-assignments", "cancel")){ ?>
        <div class="row">
            <div class="col s12 m4 l4">
                <?= $progress['fabricated'] === 0 && $assignment->status != LineAssignments::CANCELED ?
                    Html::a('<i class="material-icons left">cancel</i> Cancelar asignación', ['cancel', 'id' => $assignment->id], [
                    'class' => 'btn red darken-1',
                    'data' => [
                        'confirm' => 'Ésta acción es irreversible',
                        'method' => 'post',
                    ],
                ]) : '' ?>
            </div>
        </div>
    <?php } ?>

    <?php if($assignment->status == LineAssignments::CANCELED){ ?>
        <div class="row">
            <div class="col s12 m12">
                <div class="materialert error">
                    <i class="material-icons">info</i>
                    Ésta asignación ha sido cancelada
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col s12 m12 l12">
            <?= DetailView::widget([
                'model' => $assignment,
                'attributes' => [
                    [
                        'attribute' => 'order_detail_id',
                        'value' => $detail->description,
                    ],
                    [
                        'label' => 'Orden',
                        'value' => Html::a($order->order_number, ['order-details/index', 'order_id' => $order->id]),
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Tipo de asignación',
                        'value' => function($data){
                            return LineAssignments::TYPES[$data->type];
                        },
                    ],
                    [
                        'attribute' => 'production_line_id',
                        'value' => function($data){
                            return "Maquila No. ".$data->production_line_id;
                        }
                    ],
                    [
                        'label' => 'Usuario',
                        'value' => $user->user,
                    ],
                    'assigned_timestamp:datetime',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <div class="timeline">
                <?php foreach ($entries as $entry) {
                    $s =  $entry->quantity != 1 ? "s" : "";
                    $start = new DateTime($entry->started_timestamp);

                    if(!$entry->produced_timestamp){
                        $end = new DateTime();
                    } else {
                        $end = new DateTime($entry->produced_timestamp);
                    }

                    $interval = $end->diff($start);
                    $avg_time = "No disponible";
                    if($entry->quantity){
                        $avg_time = round(((($interval->d * 24)*60) + ($interval->h*60) + $interval->i) / $entry->quantity, 2);
                        $total_avg_time += $avg_time;
                        $avg_time .= " min.";
                    }

                    $time = sprintf('%d hr %02d min', ($interval->d * 24) + $interval->h, $interval->i);
                    ?>
                    <div class="timeline-event">
                        <div class="card timeline-content">
                            <div class="card-image waves-effect waves-block waves-light center">
                                <i class="activator material-icons x5 blue-text center" style="margin-top: 24px">
                                    open_in_browser
                                </i>
                            </div>
                            <div class="card-content">
                                <span class="card-title activator grey-text text-darken-4 center">
                                    <?php if(!$entry->quantity) {?>
                                        En progreso (<?=$interval->d > 0 ? $interval->d . " días" : $time?>)
                                    <?php } else {
                                        echo $entry->quantity." pieza$s fabricada$s";
                                    } ?>
                                </span>
                                <p class="center">
                                    <?= $formatter->asDatetime($entry->started_timestamp); ?> - <?= $entry->produced_timestamp ? $formatter->asDatetime($entry->produced_timestamp) : 'En proceso'; ?>
                                </p>
                            </div>
                            <div class="card-reveal">
                                <span class="card-title grey-text text-darken-4">
                                    <?=$time?>
                                    <i class="material-icons right">close</i>
                                </span>
                                <p>
                                    <?= $entry->quantity ? $entry->quantity." pieza$s fabricada$s" : "Piezas fabricadas no disponibles"; ?>
                                </p>
                                <p>
                                    Tiempo de fabricación promedio: <?= $avg_time ?>
                                </p>
                            </div>
                        </div>
                        <div class="timeline-badge green white-text"><i class="material-icons">access_time</i></div>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
    <?php if(empty($entries)){ ?>
        <div class="row">
            <div class="col s12 m12">
                <div class="materialert info">
                    <i class="material-icons">info</i>
                    Aún no hay actividad para mostrar
                </div>
            </div>
        </div>
    <?php } else {
        // Calculate estimated completion time
        $total_avg_time = $total_avg_time / count($entries);
        $missing = $progress['required'] - $progress['fabricated'];
        $estimated_time = round($total_avg_time * $missing, 15);

        $hold_time = $assignment->getHoldTime();
        $formatted_estimated_time = null;
        if($progress['fabricated'] > 0) {
            $avg_hold_time = round($hold_time / $progress['fabricated'], 2);
            $missing_hold_time = $avg_hold_time * $missing;
            $estimated_time += $missing_hold_time;
            $formatted_estimated_time = Utilities::convertToHoursMins(intval($estimated_time), '%02d hrs %02d min');
        }

        // Check if there is a delay in production
        $today = new DateTime();
        $delay = $today->diff($start);
        $t_delay = sprintf('%d días %d hr %02d min', $delay->d, $delay->h, $delay->i);
        if($formatted_estimated_time){ ?>
            <div class="row center">
                <div class="col s12 m12 l12">
                    <h5>
                        Tiempo estimado de
                        finalización: <?= Utilities::convertToHoursMins(intval($estimated_time), '%02d hrs %02d min') ?>
                    </h5>
                    <?php if($delay->h > 0){ ?>
                        <h5 class="red-text text-darken-1"><?=$t_delay?> de atraso </h5>
                    <?php } ?>
                </div>
            </div>
       <?php } ?>
   <?php } ?>

</div>

