<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\RecordCardPieces */
/* @var $recordCard app\models\RecordCards */


$this->title = 'Agregar una pieza a '.$recordCard->model;
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Fichas', 'url' => ['/record-cards/index']];
$this->params['breadcrumbs'][] = ['label' => $recordCard->model, 'url' => ['/record-cards/view', 'id' => $recordCard->id]];
$this->params['breadcrumbs'][] = 'Agregar pieza';
?>
<div class="container">

    <div class="row">
        <div class="col m12 s12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12">
            <div class="card white">
                <div class="card-content">
                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

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
