<?php

use app\lib\i18n;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use macgyer\yii2materializecss\widgets\form\DatePicker;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */

$this->title = 'Editar orden ' . $model->order_number;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
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
                    <?php $form = ActiveForm::begin(); ?>

                        <div class="hidden">
                            <?= $form->field($model, 'payment_due_date')->textInput(['id' => 'payment-due-date'])->label(false) ?>
                            <?= $form->field($model, 'due_date')->textInput(['id' => 'due-date'])->label(false) ?>
                        </div>

                        <div class="input-field field-payment-due-date">
                            <?php
                            echo Html::activeLabel($model,'payment_due_date');
                            echo DatePicker::widget([
                                'name' => 'payment-due-date',
                                'options' => ['autocomplete' => 'off'],
                                'value' => $model->payment_due_date,
                                'clientOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'i18n' => i18n::$spanish
                                ],
                            ]);
                            echo Html::error($model,'payment_due_date', [
                                'class' => 'help-block helper-text',
                                'tag' => 'span'
                            ]);
                            ?>
                        </div>

                        <div class="input-field field-due-date">
                            <?php
                            echo Html::activeLabel($model,'due_date');
                            echo DatePicker::widget([
                                'name' => 'due-date',
                                'options' => ['autocomplete' => 'off'],
                                'value' => $model->due_date,
                                'clientOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'i18n' => i18n::$spanish
                                ],
                            ]);
                            echo Html::error($model,'due_date', [
                                'class' => 'help-block helper-text',
                                'tag' => 'span'
                            ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
