<?php

/* @var $this \yii\web\View */
/* @var $content string */

use macgyer\yii2materializecss\widgets\navigation\Breadcrumbs;
use macgyer\yii2materializecss\widgets\navigation\Dropdown;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\lib\Materialert;
use yii\widgets\Pjax;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="full-body">
<?php $this->beginBody() ?>
<?php
//init drop downs on the site
Dropdown::widget();
// Create logout form
echo Html::beginForm(['/site/logout'], 'post', ['id' => 'logout-form']).Html::endForm();
?>
<div class="wrap">
    <nav>
        <div class="nav-wrapper blue darken-1">
            <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <a href="<?=Url::to(['/'])?>" class="brand-logo">Uniformex</a>
            <?php if(Yii::$app->mobileDetect->isMobile() && !Yii::$app->user->isGuest){
                /* --------------------------------------- MOBILE MENU --------------------------------------- */?>
                <ul id="slide-out" class="sidenav">
                    <li>
                        <div class="user-view">
                            <div class="background">
                                <img src="/images/office.jpg">
                            </div>
                            <a href="#user"><img class="circle" src="/images/profile.jpg"></a>
                            <a href="#name"><span class="white-text name">¡Hola, <?=Yii::$app->user->identity->first_name?>!</span></a>
                            <a href="#email"><span class="white-text email"><?=Yii::$app->user->identity->email?></span></a>
                        </div>
                    </li>
                    <?php if(Yii::$app->user->isGuest){ ?>
                        <li><a href="<?=Url::to(['/site/login'])?>">Entrar</a></li>
                    <?php } else { ?>
                        <li>
                            <?= Html::a('<i class="material-icons left">home</i> Inicio', ['site/index']) ?>
                        </li>
                        <li>
                            <a class="dropdown-trigger" href="#!" data-target="stock-menu">
                                <i class="material-icons left">assignment</i>
                                Inventario
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-trigger" href="#!" data-target="orders-menu">
                                <i class="material-icons left">vertical_split</i>
                                Ordenes
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-trigger" href="#!" data-target="production-menu">
                                <i class="material-icons left">developer_board</i>
                                Producción
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>
                        <?php if(Yii::$app->user->getIdentity()->hasAccess("customers", "index")){ ?>
                            <li>
                                <?= Html::a('<i class="material-icons left">face</i> Clientes', ['customers/index']) ?>
                            </li>
                        <?php } ?>
                        <li>
                            <a class="dropdown-trigger" href="#!" data-target="users-menu">
                                <i class="material-icons left">group</i>
                                Usuarios
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="dropdown-trigger" href="#!" data-target="user-menu">
                                <i class="material-icons left">account_circle</i>
                                Mi cuenta
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else {
                /* --------------------------------------- DESKTOP MENU --------------------------------------- */?>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <?php if(Yii::$app->user->isGuest){ ?>
                        <li><a href="<?=Url::to(['/site/login'])?>">Entrar</a></li>
                    <?php } else { ?>
                        <li>
                            <a class="dropdown-trigger" href="#!" data-target="stock-menu">
                                <i class="material-icons left">assignment</i>
                                Inventario
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>
                        <?php /* <li>
                            <a class="dropdown-trigger" href="#!" data-target="orders-menu">
                                <i class="material-icons left">vertical_split</i>
                                Ordenes
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-trigger" href="#!" data-target="production-menu">
                                <i class="material-icons left">developer_board</i>
                                Producción
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>  */ ?>
                        <?php if(Yii::$app->user->getIdentity()->hasAccess("customers", "index")){ ?>
                            <li>
                                <?= Html::a('<i class="material-icons left">face</i> Clientes', ['customers/index']) ?>
                            </li>
                        <?php } ?>
                        <li>
                            <a class="dropdown-trigger" href="#!" data-target="users-menu">
                                <i class="material-icons left">group</i>
                                Usuarios
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-trigger" href="#!" data-target="user-menu">
                                <i class="material-icons left">account_circle</i>
                                Mi cuenta
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
        <?php if(!Yii::$app->user->isGuest){ ?>
            <ul id="user-menu" class="dropdown-content">
                <li>
                    <a href="#!" class="center gray-text"> ¡Hola, <?=Yii::$app->user->identity->first_name?>!</a>
                </li>
                <li class="divider" tabindex="-1"></li>
                <li>
                    <?= Html::a('<i class="material-icons left">settings</i> Ajustes', ['account/settings']) ?>
                </li>
                <li>
                    <a href="#!" id="btn-logout">
                        <i class="material-icons">power_settings_new left</i>Salir
                    </a>
                </li>
            </ul>
            <ul id="stock-menu" class="dropdown-content">
                <?php /* if(Yii::$app->user->getIdentity()->hasAccess("products", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">vertical_split</i> Productos', ['products/']) ?>
                    </li>
                <?php }
                if(Yii::$app->user->getIdentity()->hasAccess("clothes", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">local_offer</i> Prendas', ['clothes/']) ?>
                    </li>
                <?php }
                if (Yii::$app->user->getIdentity()->hasAccess("raw-material", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">scatter_plot</i> Materiales', ['raw-material/']) ?>
                    </li>
                <?php }
                if (Yii::$app->user->getIdentity()->hasAccess("parts", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">extension</i> Avíos', ['parts/']) ?>
                    </li>
                <?php }*/
                if (Yii::$app->user->getIdentity()->hasAccess("suppliers", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">store_mall_directory</i> Proveedores', ['suppliers/']) ?>
                    </li>
                <?php } ?>
            </ul>
            <ul id="users-menu" class="dropdown-content">
                <?php if(Yii::$app->user->getIdentity()->hasAccess("clothes", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">contacts</i> Usuarios', ['user/']) ?>
                    </li>
                <?php }
                if (Yii::$app->user->getIdentity()->hasAccess("raw-material", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">lock_open</i> Permisos', ['privileges/']) ?>
                    </li>
                <?php }
                if (Yii::$app->user->getIdentity()->hasAccess("roles", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">supervised_user_circle</i> Roles', ['roles/']) ?>
                    </li>
                <?php } ?>
            </ul>
            <ul id="orders-menu" class="dropdown-content">
                <?php if(Yii::$app->user->getIdentity()->hasAccess("orders", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">vertical_split</i> Ordenes', ['orders/']) ?>
                    </li>
                <?php }
                if (Yii::$app->user->getIdentity()->hasAccess("payments", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">payment</i> Pagos', ['payments/']) ?>
                    </li>
                <?php }
                if (Yii::$app->user->getIdentity()->hasAccess("shipments", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">local_shipping</i> Envíos', ['shipments/']) ?>
                    </li>
                <?php }
                if (Yii::$app->user->getIdentity()->hasAccess("quotations", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">monetization_on</i> Cotizar', ['quotations/']) ?>
                    </li>
                <?php } ?>
            </ul>
            <ul id="production-menu" class="dropdown-content">
                <?php if(Yii::$app->user->getIdentity()->hasAccess("production-lines", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">blur_linear</i> Maquilas', ['production-lines/']) ?>
                    </li>
                <?php }
                if (Yii::$app->user->getIdentity()->hasAccess("line-assignments", "index")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">assignment_turned_in</i> Asignaciones', ['line-assignments/']) ?>
                    </li>
                <?php }
                if (Yii::$app->user->getIdentity()->hasAccess("line-assignments", "assigned")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">assignment_ind</i> Pendientes', ['line-assignments/assigned']) ?>
                    </li>
                <?php } if (Yii::$app->user->getIdentity()->hasAccess("line-history", "assigned")){ ?>
                    <li>
                        <?= Html::a('<i class="material-icons left">history</i> Historial', ['line-history/']) ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </nav>

    <!-- Do not include $content into container here so you can get full width elements when needed -->
    <div class="content">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <div class="row">
                <div class="col s12 m12 l12">
                    <?= Materialert::widget() ?>
                </div>
            </div>
        </div>
    </div>

    <?= $content ?>
</div>

<footer class="page-footer blue darken-1">
    <div class="footer-copyright">
        <div class="container">
            © <?= date('Y')?> CEOS New Media Agency
            <?php if(Yii::$app->user->isGuest){ ?>
                <a class="grey-text text-lighten-4 right" href="https://ceosnewmedia.com/">Olvidé mi acceso</a>
            <?php } ?>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
<?= Yii::$app->customAssets->get(); ?>
</body>
</html>
<?php $this->endPage() ?>
