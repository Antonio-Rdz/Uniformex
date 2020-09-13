<?php
use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = 'Ajustes de la cuenta';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <h4>Ajustes de la cuenta</h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <div class="collection">
                <?= Html::a('Cambiar contraseña', ['account/change-password'], ['class' => 'collection-item'])?>
            </div>
        </div>
    </div>
</div>

