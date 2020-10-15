<?php
use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

/* @var $model app\models\LineAssignments */
/* @var $this yii\web\View */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */

$this->title = 'Pausar actividad';
$this->params['breadcrumbs'][] = ['label' => 'Producción'];
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones'];
$this->params['breadcrumbs'][] = ['label' => 'Mis Asignaciones', 'url' => '/line-assignments/assigned'];
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
            <div class="card white">
                <div class="card-content">
                    <?php $form = ActiveForm::begin(); ?>
                        <label for="linehistory-quantity">Por favor indica cuántas piezas has producido</label>

                        <?= $form->field($model, 'quantity')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

