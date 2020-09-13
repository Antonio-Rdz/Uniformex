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

$this->title = 'Selecciona un material';
$this->params['breadcrumbs'][] = ['label' => 'Inventario', 'url' => '/orders/'];
$this->params['breadcrumbs'][] = ['label' => 'Materiales', 'url' => '/raw-material/'];
$this->params['breadcrumbs'][] = ['label' => 'Entradas', 'url' => 'index'];
$this->params['breadcrumbs'][] = ['label' => 'Crear', 'url' => 'create'];
$this->params['breadcrumbs'][] = ['label' => 'Elegir material'];
?>
<?php Pjax::begin(); ?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
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
                                return Html::a('<i class="material-icons">check_circle</i>', $url, [
                                    'title' => Yii::t('app', 'Seleccionar'),
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Seleccionar éste material',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'select') {
                                $url = Url::to(['raw-material-entries/create', 'material_id' => $model->id]);
                                return $url;
                            }
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
