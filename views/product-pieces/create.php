<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\ProductPieces */
/* @var $product app\models\Products */

$this->title = 'Agregar piezas a producto';
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['products/index']];
$this->params['breadcrumbs'][] = ['label' => $product->model, 'url' => ['products/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = ['label' => 'Piezas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Agregar a producto';

$pieces = ArrayHelper::map(\app\models\Pieces::find()->all(), 'id', 'name') ;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <?php if(Yii::$app->user->getIdentity()->hasAccess("pieces", "create")){ ?>
        <div class="row">
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear pieza', ['pieces/create', 'r' => 'pieces/create'], ['class' => 'btn']) ?>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col s12 m12">
            <div class="card white">
                <div class="card-content">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'piece_id')->dropDownList($pieces) ?>

                    <?= $form->field($model, 'quantity')->numberInput(['autocomplete' => 'off']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
