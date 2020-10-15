<?php

use app\models\Units;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RawMaterial */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */

$units = ArrayHelper::map(Units::find()->all(), 'id', 'name')
?>

<div class="raw-material-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'cost')->numberInput(['step' => '.01', 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'unit_id')->dropDownList($units, ['prompt' => 'Selecciona una unidad']) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true, 'class' => 'autocomplete-colors', 'autocomplete' => 'off']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php Yii::$app->customAssets->add('order-details/autocomplete.js'); ?>