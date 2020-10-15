<?php

use app\models\LineAssignments;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LineAssignmentDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $assignment_id int*/

$this->title = 'Detalles de asignación #'.$assignment_id;
$this->params['breadcrumbs'][] = ['label' => 'Producción'];
$this->params['breadcrumbs'][] = ['label' => 'Maquilas', 'url' => ['/production-lines/index']];
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' => ['line-assignments/index']];
$this->params['breadcrumbs'][] = ['label' => 'No. '.$assignment_id, 'url' => ['line-assignments/progress', 'id' => $assignment_id]];
$this->params['breadcrumbs'][] = ['label' => 'Detalles', 'url' => ['index']];

$assignment = LineAssignments::findOne($assignment_id);
$progress = $assignment->getProgress();

?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <h6>
                <?= $assignment->orderDetail->description . " - " . Html::a($assignment->orderDetail->order->order_number, ['order-details/index', 'order_id' => $assignment->orderDetail->order->id])  ?>
            </h6>
        </div>
    </div>
    <div class="row">
        <?php if($assignment->status == LineAssignments::CANCELED){ ?>
            <div class="col s12 m12">
                <div class="materialert error">
                    <i class="material-icons">info</i>
                    Ésta asignación ha sido cancelada
                </div>
            </div>
        <?php } else { ?>
            <?php if(Yii::$app->user->getIdentity()->hasAccess("line-assignment-details", "create")){ ?>
                <div class="col s12 m4 l4">
                    <?= Html::a('<i class="material-icons left">add</i> Agregar detalle', ['create', 'assignment_id' => $assignment_id], ['class' => 'btn']) ?>
                </div>
            <?php } ?>

            <?php if(!empty($assignment->details) && Yii::$app->user->getIdentity()->hasAccess("line-assignments", "set-ready") && !$assignment->ready_timestamp){ ?>
                <div class="col s12 m4 l4">
                    <?= Html::a('<i class="material-icons left">check_circle</i> Marcar como lista', ['line-assignments/set-ready', 'assignment_id' => $assignment_id], ['class' => 'btn green darken-1']) ?>
                </div>
            <?php } ?>

            <?php if($progress['fabricated'] === 0){ ?>
                <div class="col s12 m4 l4">
                    <?= Html::a('<i class="material-icons left">cancel</i> Cancelar asignación', ['cancel', 'id' => $assignment->id], [
                        'class' => 'btn red darken-1',
                        'data' => [
                            'confirm' => '¿Seguro que deseas cancelar ésta asignación?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'responsive-table'],
        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],

            'assignment_id',
            [
                'attribute' => 'rawMaterial',
                'label' => 'Material',
                'value' => function($data){
                    return $data->raw_material_id ? Html::a($data->rawMaterial->name, ['raw-materials/view', 'id' => $data->raw_material_id])
                        :
                        "<span class='not-set'>(no aplica)</span>";
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'semiCloth',
                'label' => 'Semiprenda',
                'value' => function($data){
                    return $data->semi_cloth_id ? Html::a($data->semiCloth->name, ['semi-clothes/view', 'id' => $data->semi_cloth_id])
                        :
                        "<span class='not-set'>(no aplica)</span>";
                },
                'format' => 'raw'
            ],
            'quantity',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}',
                'header' => 'Opciones',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        /* @var $model \app\models\LineAssignmentDetails */
                        if(!Yii::$app->user->getIdentity()->hasAccess("line-assignment-details", "delete") || $model->assignment->ready_timestamp){
                            return '';
                        }
                        return Html::a('<i class="material-icons">delete</i>', $url, [
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Puedes volver a agregar el detalle si te arrepientes',
                                'position' => 'top',
                                'tooltip' => 'Eliminar detalle',
                                'pjax' => '0',
                                'params' => [
                                    'id' => $model->id
                                ],
                            ],
                            'class' => 'tooltipped',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model) {
                    /* @var $model \app\models\LineAssignmentDetails */
                    if ($action === 'delete') {
                        $url = Url::to(['line-assignment-details/delete', 'id' => $model->id, 'assignment_id' => $model->assignment->id]);
                        return $url;
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
