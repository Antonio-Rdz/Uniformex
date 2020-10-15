<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SizesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tallas';
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['products/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>


    <?php if(Yii::$app->user->getIdentity()->hasAccess("sizes", "create")){ ?>
    <div class="row">
        <div class="col s12 m4 l4">
            <?= Html::a('<i class="material-icons left">add</i> Crear talla', ['create'], ['class' => 'btn']) ?>
        </div>
    </div>
    <?php } ?>

    <div class="row">
        <div class="col s12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'name',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{delete}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'delete' => function ($url, $model) {
                                if(!Yii::$app->user->getIdentity()->hasAccess("sizes", "delete")){
                                    return '';
                                }
                                return Html::a('<i class="material-icons">delete</i>', $url, [
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'No puedes recuperar una talla eliminada.',
                                        'position' => 'top',
                                        'tooltip' => 'Eliminar pieza',
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
                                $url = Url::to(['sizes/delete', 'id' => $model->id]);
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
