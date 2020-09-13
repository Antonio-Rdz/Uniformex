<?php

use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RawMaterialEntries */
/* @var $material \app\models\RawMaterial */

$this->title = 'Crear entrada de material';
$this->params['breadcrumbs'][] = ['label' => 'Inventario'];
$this->params['breadcrumbs'][] = ['label' => 'Materiales'];
$this->params['breadcrumbs'][] = ['label' => 'Entradas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$warehouses = ArrayHelper::map(app\models\Warehouses::find()->all(), 'id', 'name');
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
                    <div class="raw-material-entries-form">

                        <?php $form = ActiveForm::begin();
                        if(!$material){
                            echo Html::a('<i class="material-icons left">add</i> Seleccionar material', ['select-raw-material'], ['class' => 'btn']);
                        } else { ?>
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="card">
                                        <div class="card-content">
                                            <span class="card-title"><?= $material->name ?></span>
                                            <p>
                                                <?= $material->description ?> Color <?= $material->color ?>
                                            </p>
                                        </div>
                                        <div class="card-action">
                                            <?= Html::a('Más Detalles', ['/raw-material/view', 'id' => $material->id])  ?>
                                            <?= Html::a('Cancelar', ['create'])  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        echo $form->field($model, 'raw_material_id')->numberInput(['class' => 'hidden', 'autocomplete' => 'off'])->label(false) ?>
                        <div class="field-order-detail-id">
                            <?= Html::error($model, 'raw_material_id', [
                                'class' => 'help-block helper-text',
                                'tag' => 'span'
                            ]); ?>
                        </div>

                        <?= $form->field($model, 'warehouse_id')->dropDownList($warehouses, ['prompt' => 'Selecciona una sucursal']) ?>

                        <?= $form->field($model, 'cost')->numberInput(['step' => 'any', 'autocomplete' => 'off']) ?>

                        <?= $material ? "(Unidad: ".$material->unit->name.")" : ""; ?>

                        <?= $form->field($model, 'quantity')->numberInput(['step' => 'any', 'autocomplete' => 'off']) ?>

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
