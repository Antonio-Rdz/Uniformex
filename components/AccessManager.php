<?php

namespace app\components;

use Yii;
use app\models\User;
use yii\web\HttpException;

/**
 * This is the component class for managing the access to all actions on the application.
 *
 * @property User $user
 */

class AccessManager extends \yii\base\Component
{
    private $user;

    public function init() {

        parent::init();

        $this->user = Yii::$app->user->getIdentity();
        $url = explode("/", Yii::$app->urlManager->parseRequest(Yii::$app->request)[0]);
        $controller = isset($url[0]) ? $url[0] : 'site';
        $action = isset($url[1]) ? $url[1] : 'index';

        if(!Yii::$app->user->isGuest && !$this->user->hasAccess($controller, $action) && $controller !== 'gii'){
            throw new HttpException(403, 'No tienes permisos suficientes para acceder a ésta página.');
        }

        return true;
    }
}