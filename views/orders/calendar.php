<?php

use app\models\Orders;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calendario';
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("https://use.fontawesome.com/releases/v5.0.6/css/all.css");
$this->registerCssFile("/js/calendar/packages/core/main.css");
$this->registerCssFile("/js/calendar/packages/bootstrap/main.css");
$this->registerCssFile("/js/calendar/packages/timegrid/main.css");
$this->registerCssFile("/js/calendar/packages/daygrid/main.css");
$this->registerCssFile("/js/calendar/packages/list/main.css");

Yii::$app->customAssets->add('calendar/packages/core/main.js');
Yii::$app->customAssets->add('calendar/packages/interaction/main.js');
Yii::$app->customAssets->add('calendar/packages/bootstrap/main.js');
Yii::$app->customAssets->add('calendar/packages/daygrid/main.js');
Yii::$app->customAssets->add('calendar/packages/timegrid/main.js');
Yii::$app->customAssets->add('calendar/packages/list/main.js');

Yii::$app->customAssets->add('calendar/init.js');
?>
<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <div id='calendar'></div>
        </div>
    </div>
</div>