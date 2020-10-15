<?php

use app\models\Sizes;
use app\models\Suppliers;
use app\models\Warehouses;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\PartEntries */
/* @var $part \app\models\Parts */
/* @var $post array */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */


$this->title = 'Crear entrada de avío';
$this->params['breadcrumbs'][] = ['label' => 'Inventario',];
$this->params['breadcrumbs'][] = ['label' => 'Avíos', 'url' => ['/parts/index']];
$this->params['breadcrumbs'][] = ['label' => 'Entradas', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Crear";
$warehouses = ArrayHelper::map(Warehouses::find()->all(), 'id', 'name');
$suppliers = ArrayHelper::map(Suppliers::find()->all(), 'id', function($m){
    $n = $m->name;
    $n .= $m->contact_name ? ' ('.$m->contact_name.')' : '';
    return $n;
});
$sizes = Sizes::getDefaultSizes();
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
                    <div class="cloth-entries-form">

                        <?php $form = ActiveForm::begin();
                        if(!$part){
                            echo Html::a('<i class="material-icons left">add</i> Seleccionar avío', ['import-part'], ['class' => 'btn']);
                        } else { ?>

                            <h5 class="card-title"><?= $part->name ?></h5>
                            <?= Html::a('Cancelar', ['create']) ?>

                        <?php }
                        echo $form->field($model, 'part_id')->hiddenInput()->label(false) ?>

                        <?= $form->field($model, 'warehouse_id')->dropDownList($warehouses, ['prompt' => 'Selecciona una sucursal']) ?>

                        <?= $form->field($model, 'supplier_id')->dropDownList($suppliers, ['prompt' => 'Selecciona un proveedor']) ?>

                        <?= $form->field($model, 'quantity')->numberInput()->label($part ? 'Cantidad ('.$part->unit->name.'s)' : 'Cantidad') ?>

                        <?= $form->field($model, 'cost')->numberInput(['autocomplete' => 'off', 'step' => 'any'])->label('Costo unitario') ?>

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
<?php Yii::$app->customAssets->add('order-details/size.js'); ?>
