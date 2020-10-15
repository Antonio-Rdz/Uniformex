<?php

use app\models\OrderDetails;
use app\models\ProductionLines;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use macgyer\yii2materializecss\lib\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\LineAssignments */
/* @var $order \app\models\Orders */
/* @var $this yii\web\View */
/* @var $model app\models\LineAssignments */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
/* @var $order \app\models\Orders */

$this->title = 'Crear asignación de maquila';
$this->params['breadcrumbs'][] = ['label' => 'Producción'];
$this->params['breadcrumbs'][] = ['label' => 'Maquilas', 'url' => ['/production-lines/index']];
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Crear";
$lines = ArrayHelper::map(ProductionLines::find()->where(['<>', 'status', ProductionLines::INACTIVE])->all(), "id",
    function($model){
        return "Maquila No. ".$model->id;
    }
);

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
                    <div class="line-assignments-form">
                        <?php $form = ActiveForm::begin(); ?>

                        <?php if($order){
                            $details = OrderDetails::_findUnassigned($order->id);
                            ?>
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="card white">
                                        <div class="card-content">
                                            <span class="card-title">
                                                Orden <?=$order->order_number?>
                                                <a href="#" class="btn btn-flat select-all" data-selector="assign">Asignar todo</a>
                                            </span>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>Prenda</th>
                                                    <th>Piezas a asignar</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?php foreach ($details as $idx => $detail) { ?>
                                                    <tr>
                                                        <td>
                                                            <?= Html::a($detail['description'], ['record-cards/view', 'id' => $detail['record_card_id']], ['target' => '_blank']) . " Talla ".$detail['size'] ?>
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col s6">
                                                                    <?= Html::activeTextInput($model, 'quantity', ['type' => 'number']); ?>
                                                                </div>
                                                                <div class="col s6">
                                                                    / <?=$detail['quantity']?>
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php if(empty($details)){ ?>
                                                <div class="materialert info">
                                                    <i class="material-icons">info</i>
                                                    Ésta orden ya tiene asignaciones pendientes en todos sus conceptos.&nbsp;
                                                    Puedes&nbsp;<b><?= Html::a('elegir otra orden.', 'choose-item', ['class' => 'white-text']) ?></b>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <?= Html::a('<i class="material-icons left">add</i> Elegir orden', ['choose-item'], ['class' => 'btn'])?>
                        <?php } ?>
                        <div class="field-order-detail-id">
                            <?= Html::error($model,'order_detail_id', [
                                'class' => 'help-block helper-text',
                                'tag' => 'span'
                            ]); ?>
                        </div>

                        <?= $form->field($model, 'order_detail_id')->numberInput(['class' => 'hidden'])->label(false)?>

                        <?= $form->field($model, 'production_line_id')->dropDownList($lines, ['prompt' => 'Selecciona una maquila']) ?>

                        <?= $form->field($model, 'type')->dropDownList(\app\models\LineAssignments::TYPES, ['prompt' => 'Selecciona un tipo']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php Yii::$app->customAssets->add('line-assignments/select-item.js'); ?>


