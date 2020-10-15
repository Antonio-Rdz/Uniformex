<?php

namespace app\controllers;

use Yii;
use app\models\PurchaseOrderDetails;
use app\models\PurchaseOrderDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PurchaseOrderDetailsController implements the CRUD actions for PurchaseOrderDetails model.
 */
class PurchaseOrderDetailsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Creates a new PurchaseOrderDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($purchase_order_id)
    {
        $model = new PurchaseOrderDetails();
        $model->purchase_order_id = $purchase_order_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Concepto agregados correctamente');
            return $this->redirect(['purchase-orders/view', 'id' => $model->purchase_order_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PurchaseOrderDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Concepto modificado correctamente');
            return $this->redirect(['purchase-orders/view', 'id' => $model->purchase_order_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PurchaseOrderDetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $purchase_order_id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->addFlash('success', 'Concepto eliminado correctamente');
        return $this->redirect(['purchase-orders/view', 'id' => $purchase_order_id]);
    }

    /**
     * Finds the PurchaseOrderDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseOrderDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseOrderDetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
