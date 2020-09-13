<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RawMaterial */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Inventario'];
$this->params['breadcrumbs'][] = ['label' => 'Materiales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("raw-material-entries", "create")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear entrada', ['raw-material-entries/create', 'material_id' => $model->id], ['class' => 'btn blue darken-1']) ?>
            </div>
        <?php } ?>
        <?php if(Yii::$app->user->getIdentity()->hasAccess("raw-material", "edit")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">edit</i> Editar', ['update', 'id' => $model->id], ['class' => 'btn green darken-1']) ?>
            </div>
        <?php } ?>
        <?php if(Yii::$app->user->getIdentity()->hasAccess("raw-material", "delete")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">delete</i> Eliminar', ['delete', 'id' => $model->id], [
                    'class' => 'btn red darken-1',
                    'data' => [
                        'confirm' => '¿Seguro que deseas eliminar este elemento?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        <?php } ?>
    </div>


    <div class="row">
        <div class="col s12 m12 l12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'description',
                    'cost:currency',
                    [
                        'attribute' => 'unit_id',
                        'value' => function($model){
                            return \app\models\Units::findOne([$model->unit_id])->name;
                        },
                    ],
                    [
                        'label' => 'Existencia',
                        'value' => function($model){
                            /* @var $model \app\models\Clothes*/
                            return $model->getStock();
                        }
                    ],
                    'color',
                ],
            ]) ?>
        </div>
    </div>
</div>
