<?php

use app\models\Parts;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\RecordCardParts */

$this->title = 'Agregar avío a ficha';
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Fichas', 'url' => ['record-cards/index']];
$this->params['breadcrumbs'][] = ['label' => 'Avíos', 'url' => ['parts/index']];
$this->params['breadcrumbs'][] = $this->title;

$parts = ArrayHelper::map(Parts::find()->all(), 'id', 'name')
?>
<div class="container">

    <div class="row">
        <div class="col s12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="card white">
                <div class="card-content">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'part_id')->dropDownList($parts, ['prompt' => 'Selecciona un avío']) ?>

                    <?= $form->field($model, 'quantity')->numberInput(['step' => 'any'])->label(null, ['id' => 'l_quantity']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php Yii::$app->customAssets->add('record-card-parts/script.js'); ?>
