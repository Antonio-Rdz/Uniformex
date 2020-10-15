<?php

use app\models\LineAssignments;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $semi_cloth \app\models\SemiClothes */
/* @var $raw_material \app\models\RawMaterial */
/* @var $model app\models\LineAssignmentDetails */
/* @var $assignment app\models\LineAssignments*/

$this->title = 'Crear detalle de asignación';
$this->params['breadcrumbs'][] = ['label' => 'Producción'];
$this->params['breadcrumbs'][] = ['label' => 'Maquilas', 'url' => ['/production-lines/index']];
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' => ['line-assignments/index']];
$this->params['breadcrumbs'][] = ['label' => 'No. '.$model->assignment_id, 'url' => ['line-assignments/progress', 'id' => $model->assignment_id]];
$this->params['breadcrumbs'][] = ['label' => 'Detalles', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Crear';
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
                    <div class="cloth-entries-form">

                        <?php $form = ActiveForm::begin();
                        if(!$semi_cloth && !$raw_material){ ?>
                        <div class="row">
                            <?php if(Yii::$app->user->getIdentity()->hasAccess("line-assignment-details", "select-semi-cloth") && $assignment->type !== LineAssignments::CUT){ ?>
                                <div class="col s12 m4 l4">
                                    <?= Html::a('<i class="material-icons left">add</i> Importar semiprenda', ['select-semi-cloth', 'assignment_id' => $assignment->id], ['class' => 'btn']); ?>
                                </div>
                            <?php } ?>
                            <?php if(Yii::$app->user->getIdentity()->hasAccess("line-assignment-details", "select-raw-material")){ ?>
                                <div class="col s12 m4 l4">
                                    <?= Html::a('<i class="material-icons left">add</i> Importar material', ['select-raw-material', 'assignment_id' => $assignment->id], ['class' => 'btn']); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php } else {
                            // Determine whether the user choose a semi cloth or a material
                            if($semi_cloth){
                                $import = $semi_cloth;
                                $detail_url = ['/semi-clothes/view', 'id' => $semi_cloth->id];
                                $attr = 'semi_cloth_id';
                            } else {
                                $import = $raw_material;
                                $detail_url = ['/raw-material/view', 'id' => $raw_material->id];
                                $attr = 'raw_material_id';
                            }
                            $unit_name = isset($import->unit) ? $import->unit->name : 'pieza';
                            ?>
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="card">
                                        <div class="card-content">
                                            <span class="card-title"><?= $import->name ?></span>
                                            <p>
                                                <?= $import->description ?>
                                            </p>
                                            <?php $stock = $import->getStock(); $s = $stock != 1 ?  "s" : ""; ?>
                                            <p>
                                                Existencias: <?= $stock ." ".$unit_name.$s ?>
                                            </p>
                                        </div>
                                        <div class="card-action">
                                            <?= Html::a('Más Detalles', $detail_url)  ?>
                                            <?= Html::a('Cancelar', ['create', 'assignment_id' => $assignment->id])  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        echo $form->field($model, $attr)->numberInput(['class' => 'hidden', 'autocomplete' => 'off'])->label(false) ?>
                        <div class="field-order-detail-id">
                            <?= Html::error($model, $attr, [
                                'class' => 'help-block helper-text',
                                'tag' => 'span'
                            ]); ?>
                        </div>
                        <?php } ?>

                        <?= $form->field($model, 'quantity')->numberInput(['autocomplete' => 'off', 'step' => '.01']) ?>

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
