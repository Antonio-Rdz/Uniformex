<?php

namespace app\controllers;

use app\models\Products;
use Yii;
use app\models\ProductPieces;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductPiecesController implements the CRUD actions for ProductPieces model.
 */
class ProductPiecesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Creates a new ProductPieces model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($product_id, $r = null)
    {
        $model = new ProductPieces();

        $model->product_id = $product_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Pieza agregada con éxito');
            if($r){
                return $this->goBack();
            }
            return $this->redirect(['products/view', 'id' => $product_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'product' => Products::findOne($product_id),
            ]);
        }
    }

    /**
     * Deletes an existing ProductPieces model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $product_id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->addFlash('success', 'Pieza removida con éxito');
        return $this->redirect(['products/view', 'id' => $product_id]);
    }

    /**
     * Finds the ProductPieces model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductPieces the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductPieces::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }
}
