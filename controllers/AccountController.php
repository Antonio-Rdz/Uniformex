<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\web\NotFoundHttpException;

class AccountController extends \yii\web\Controller
{
    public function actionSettings()
    {
        return $this->render('settings');
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionChangePassword(){

        $model = $this->getUser();
        $model->password = '';
        $model->scenario = User::SCENARIO_CHANGE_PASSWORD;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Contraseña cambiada correctamente');
            return $this->redirect(['settings']);
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }


    /**
     * Finds the Shipments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function getUser()
    {
        if (($model = User::findOne(Yii::$app->user->id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
