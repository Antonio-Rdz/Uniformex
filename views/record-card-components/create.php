<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\RecordCardComponents */
/* @var $recordCard app\models\RecordCards */
/* @var $material app\models\RawMaterial */

$this->title = 'Agregar material a '. $recordCard->description. ' ' .$recordCard->model;
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Fichas', 'url' => ['/record-cards/index']];
$this->params['breadcrumbs'][] = ['label' => $recordCard->model, 'url' => ['/record-cards/view', 'id' => $recordCard->id]];
$this->params['breadcrumbs'][] = 'Agregar material';

$materials = ArrayHelper::map(\app\models\RawMaterial::find()->all(), 'id', function($model){return $model['name'].' '.$model['color'];})
?>
<div class="container">

    <div class="row">
        <div class="col m12 s12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col s12 m12">
            <div class="card white">
                <div class="card-content">

                    <?= $form->field($model, 'material_id')->dropDownList($materials, ['prompt' => 'Selecciona un material']) ?>

                    <?= $form->field($model, 'quantity')->numberInput(['step' => 'any', 'autocomplete' => 'off'])->label(null, ['id' => 'l_quantity']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php Yii::$app->customAssets->add('record-card-components/script.js'); ?>
