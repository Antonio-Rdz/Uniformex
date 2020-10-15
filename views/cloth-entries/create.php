<?php

use app\models\Sizes;
use app\models\Suppliers;
use app\models\Warehouses;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ClothEntries */
/* @var $cloth \app\models\Clothes */
/* @var $post array */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */


$this->title = 'Crear entrada de prenda';
$this->params['breadcrumbs'][] = ['label' => 'Inventario',];
$this->params['breadcrumbs'][] = ['label' => 'Prendas', 'url' => ['/clothes/index']];
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
                        if(!$cloth){
                            echo Html::a('<i class="material-icons left">add</i> Importar prenda', ['import-cloth'], ['class' => 'btn']);
                        } else { ?>
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="card">
                                        <div class="card-content">
                                            <span class="card-title"><?= $cloth->name ?> <?= $cloth->recordCard->product->model.'-'.$cloth->recordCard->model ?></span>
                                            <p>
                                                <?= $cloth->recordCard->description ?>
                                            </p>
                                        </div>
                                        <div class="card-action">
                                            <?= Html::a('Más Detalles', ['/clothes/view', 'id' => $cloth->id])  ?>
                                            <?= Html::a('Cancelar', ['create'])  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        echo $form->field($model, 'cloth_id')->hiddenInput()->label(false) ?>

                        <?= $form->field($model, 'warehouse_id')->dropDownList($warehouses, ['prompt' => 'Selecciona una sucursal']) ?>

                        <?= $form->field($model, 'supplier_id')->dropDownList($suppliers, ['prompt' => 'Selecciona un proveedor']) ?>

                        <div class="row">
                            <div class="col s12 m12">
                                <div class="card white">
                                    <div class="card-content">
                                        <span class="card-title">Piezas</span>
                                        <table class="centered responsive-table">
                                            <thead>
                                            <tr id="head_row">
                                                <th>Tallas</th>
                                                <?php foreach ($sizes as $size){ ?>
                                                    <th><?=$size?></th>
                                                <?php } ?>
                                                <th id="head_text">Otra</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr id="sizes_row">
                                                <td>Cantidad</td>
                                                <?php foreach ($sizes as $id => $size){ ?>
                                                    <td><?= Html::input('number', 'Sizes['.$id.'][qty]', isset($post) ? $post['Sizes'][$id]['qty'] : null, ['autocomplete' => 'off', 'class' => 'center size-input', 'data' => ['id' => $id]]) ?></td>
                                                <?php } ?>
                                                <td id="add_btn_row">
                                                    <a href="#!" class="btn" id="add_size">
                                                        <i class="material-icons">add</i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr id="prices_row">
                                                <td>Costo</td>
                                                <?php foreach ($sizes as $id => $size){ ?>
                                                    <td><?= Html::input('number', 'Sizes['.$id.'][price]', isset($post) ? $post['Sizes'][$id]['price'] : null, ['autocomplete' => 'off', 'class' => 'center price-input', 'id' => 'price_'.$id, 'step' => '.01']) ?></td>
                                                <?php } ?>
                                            </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
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

</div>
<?php Yii::$app->customAssets->add('order-details/size.js'); ?>
