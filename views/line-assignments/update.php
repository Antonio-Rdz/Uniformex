<?php

use app\models\LineAssignments;
use app\models\ProductionLines;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;
use \macgyer\yii2materializecss\lib\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LineAssignments */

$this->title = 'Editar asignación No. ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Producción'];
$this->params['breadcrumbs'][] = ['label' => 'Maquilas', 'url' => ['/production-lines/index']];
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'No. '.$model->id];
$this->params['breadcrumbs'][] = 'Editar';

$lines = ArrayHelper::map(ProductionLines::find()->all(), "id", function($model){return "Maquila No. ".$model->id;});
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card white">
                <div class="card-content">
                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'production_line_id')->dropDownList($lines, ['prompt' => 'Selecciona una maquila']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
