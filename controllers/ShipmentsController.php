<?php

namespace app\controllers;

use app\models\LineAssignments;
use app\models\OrderDetails;
use app\models\Orders;
use app\models\OrdersSearch;
use app\models\Payments;
use Yii;
use app\models\Shipments;
use app\models\ShipmentsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShipmentsController implements the CRUD actions for Shipments model.
 */
class ShipmentsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Shipments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShipmentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Shipments model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Shipments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($order_id = null)
    {
        $model = new Shipments();

        $order = null;

        if($order_id){
            $order = Orders::findOne($order_id);
            $model->order_id = $order_id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Envío creado con éxito');

            // Set scenario to not check for dates
            $order->scenario = Orders::SCENARIO_UPDATE_STATUS;

            // Set order status as SENT
            $order->status = Orders::SENT;
            $order->save();

            Yii::$app->session->addFlash('success', "La orden {$model->order->order_number} ha sido marcada como enviada.");

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'order' => $order,
        ]);
    }


    /**
     * @return string
     */
    public function actionSelectOrder(){
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('select-order', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Shipments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->delivered_date = date("Y-m-d H:m:s");

        if ($model->save()) {
            Yii::$app->session->addFlash('success', 'Envío marcado como entregado.');
            // Set order status as 'waiting for payment' if it is still incomplete
            if($model->order->getTotalPayment() >= $model->order->getTotal()){
                $order = $model->order;
                // Set scenario to not check for dates
                $order->scenario = Orders::SCENARIO_UPDATE_STATUS;

                $order->status = Orders::COMPLETED;
                $order->save();
                Yii::$app->session->addFlash('success', "La orden {$model->order->order_number} ha sido marcada como completada.");
            }
        } else {
            Yii::$app->session->addFlash('error', 'Algo salió mal, por favor inténtalo de nuevo.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Shipments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if(!$model->delivered_date){
            $model->delete();

            $order = $model->order;
            // Set scenario to not check for dates
            $order->scenario = Orders::SCENARIO_UPDATE_STATUS;

            // Return to previous status
            $order->status = Orders::WAITING_FOR_PICKUP;
            $model->order->save();
            Yii::$app->session->addFlash('success', 'Envío eliminado con éxito');
        } else {
            Yii::$app->session->addFlash('error', 'No puedes eliminar un envío que ha sido entregado');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Shipments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shipments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shipments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
