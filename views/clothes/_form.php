<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clothes */
/* @var $recordCard app\models\RecordCards */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */

?>

<div class="clothes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(!$recordCard){ ?>
        <div class="row">
            <div class="col s12 m6 l6 offset-m3 offset-l3">
                <?= Html::a('<i class="material-icons left">open_in_browser</i> Cargar ficha', ['import-record-card'], ['class' => 'btn']);?>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title" style="display: inline"><?=$recordCard->description?> modelo <?= $recordCard->model ?></span>
                    </div>
                    <div class="card-action">
                        <?= Html::a('Más Detalles', ['/products/view', 'id' => $recordCard->id])  ?>
                        <?= Html::a('Cancelar', ['create'])  ?>
                    </div>
                </div>
            </div>
        </div>
        <?= $form->field($model, 'record_card_id')->numberInput(['class' => 'hidden', 'autocomplete' => 'off'])->label(false) ?>
        <div class="field-record-card-id">
            <?= Html::error($model, 'record_card_id', [
                'class' => 'help-block helper-text',
                'tag' => 'span'
            ]); ?>
        </div>
    <?php } ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?php if(Yii::$app->user->getIdentity()->hasAccess("profit_margin", "edit")){ ?>
        <?= $form->field($model, 'profit_margin')->numberInput(['step' => '.01']) ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php Yii::$app->customAssets->add('order-details/autocomplete.js'); ?>