<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productos';
$this->params['breadcrumbs'][] = "Inventario";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12">
            <h4><?= Html::encode($this->title) ?></h4>

        </div>
    </div>

    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("products", "create")){ ?>
            <div class="col s12 m2">
                <?= Html::a('<i class="material-icons left">add</i> Crear', ['create'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>

        <?php if(Yii::$app->user->getIdentity()->hasAccess("parts", "index")){ ?>
            <div class="col s12 m2">
                <?= Html::a('<i class="material-icons left">extension</i> Avíos', ['parts/index'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>

        <?php if(Yii::$app->user->getIdentity()->hasAccess("record-cards", "index")){ ?>
            <div class="col s12 m2">
                <?= Html::a('<i class="material-icons left">description</i> Fichas', ['record-cards/index'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>

        <?php if(Yii::$app->user->getIdentity()->hasAccess("pieces", "index")){ ?>
            <div class="col s12 m2">
                <?= Html::a('<i class="material-icons left">view_quilt</i> Piezas', ['pieces/index'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>

        <?php if(Yii::$app->user->getIdentity()->hasAccess("cloth-types", "index")){ ?>
            <div class="col s12 m2">
                <?= Html::a('<i class="material-icons left">style</i> Telas', ['cloth-types/index'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>

        <?php if(Yii::$app->user->getIdentity()->hasAccess("sizes", "index")){ ?>
            <div class="col s12 m2">
                <?= Html::a('<i class="material-icons left">label</i> Tallas', ['sizes/index'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>

    </div>


    <div class="row">
        <div class="col s12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'responsive-table highlight'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'model',
                    'description',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{update}{view}{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("products", "edit")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">edit</i>', $url, [
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Editar producto',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'view' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("products", "index")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">visibility</i>', $url, [
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Ver producto',
                                        'pjax' => '0'
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("products", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No puedes recuperar un producto eliminado.',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar producto',
                                        'pjax' => '0',
                                        'params' => [
                                            'id' => $model->id
                                        ],
                                    ],
                                    'class' => 'tooltipped'
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'delete') {
                                $url = Url::to(['products/delete', 'id' => $model->id]);
                                return $url;
                            }
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
