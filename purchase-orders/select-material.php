<?php

use app\models\RawMaterialSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RawMaterialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?php Pjax::begin(); ?>

    <?php if(Yii::$app->user->getIdentity()->hasAccess("raw-material", "create")){ ?>
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <?= Html::a('<i class="material-icons left">add</i> Crear un nuevo material', ['raw-material/create'], ['class' => 'btn modal-close', 'target' => '_blank']) ?>
            </div>
        </div>

        <div class="row">
            <div class="divider">
                <span>Ó</span>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode("Selecciona un material para dar entrada") ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'responsive-table'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'name',
                    'description',
                    'cost',
                    [
                        'attribute' => 'unit',
                        'label' => 'Unidad',
                        'value' => 'unit.name'
                    ],
                    [
                        'attribute' => 'stock',
                        'label' => 'Stock',
                        'value' => function($model){
                            /* @var $model \app\models\Clothes*/
                            return $model->getStock();
                        }
                    ],

                    'color',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{select}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'select' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("raw-material-entries", "create")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">check_circle</i>', '#!', [
                                    'title' => Yii::t('app', 'Seleccionar'),
                                    'data' => [
                                        'id' => $model->id,
                                        'type' => 'material',
                                        'position' => 'top',
                                        'tooltip' => 'Seleccionar éste material',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped modal-close select-element-button',
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
<?php Pjax::end(); ?>
