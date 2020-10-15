<?php

namespace app\controllers;

use app\models\Clothes;
use app\models\ClothesWarehouses;
use app\models\LineAssignments;
use app\models\Orders;
use app\models\ProductionLines;
use app\models\SemiClothes;
use app\models\SemiClothesWarehouses;
use Yii;
use app\models\LineHistory;
use app\models\LineHistorySearch;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LineHistoryController implements the CRUD actions for LineHistory model.
 */
class LineHistoryController extends Controller
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
     * Lists all LineHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LineHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new LineHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($assignment_id)
    {
        $assignment = LineAssignments::findOne($assignment_id);
        $detail = $assignment->orderDetail;

        $record = new LineHistory();
        $record->assignment_id = $assignment_id;

        if($record->save()){
            $assignment->status = $status = LineAssignments::IN_PROGRESS;
            $assignment->save();

            // Set the order status as In Progress or In Finishes
            $order = $detail->order;

            // Set scenario to not check for dates
            $order->scenario = Orders::SCENARIO_UPDATE_STATUS;

            // Set status according to the type of assignment
            switch ($assignment->type){
                case LineAssignments::CUT: $order->status = Orders::ON_CUT; break;
                case LineAssignments::PRODUCTION: $order->status = Orders::ON_PRODUCTION; break;
                case LineAssignments::FINISHES: $order->status = Orders::ON_FINISHES; break;
                default: $order->status = Orders::ON_PRODUCTION; break;

            }
            $order->save();
            // Set the production line status as In use
            $assignment->productionLine->status = ProductionLines::IN_USE;
            $assignment->productionLine->save();

            Yii::$app->session->addFlash('success', 'De acuerdo, estás trabajando en "'.$detail->description.'"');
        }

        return $this->redirect(['line-assignments/assigned', 'status' => $status]);
    }

    /**
     * @param $assignment_id
     * @return string|\yii\web\Response
     */
    public function actionStopWorking($assignment_id)
    {
        $model = LineHistory::findOne(['assignment_id' => $assignment_id, 'produced_timestamp' => null]);
        if(!$model){
            $model = new LineHistory();
        }

        if($model->load(Yii::$app->request->post())){
            $model->produced_timestamp = new Expression('NOW()');
            // Save the history record, it also saves the pieces fabricated.
            $model->save();
            $assignment = LineAssignments::findOne($assignment_id);
            $order_detail = $assignment->orderDetail;
            $pieces = LineHistory::getCreatedPieces($order_detail->id);
            // Verify if user has reached the quantity specified in the order
            if($pieces >= $order_detail->quantity) {

                $assignment->status = LineAssignments::FINISHED;
                // Reduce raw material / semi clothes stock once the cloth or semi cloth is created
                $order = $assignment->orderDetail->order;
                foreach ($assignment->details as $detail){
                    if($detail->semi_cloth_id){
                        foreach ($detail->semiCloth->semiClothesStock as $item){
                            if($item->warehouse_id === $order->warehouse_id){
                                $item->stock -= $detail->quantity;
                                $item->save();
                            }
                        }
                    }
                    else if($detail->raw_material_id){
                        foreach ($detail->rawMaterial->materialStock as $item){
                            if($item->warehouse_id === $order->warehouse_id){
                                $item->stock -= $detail->quantity;
                                $item->save();
                            }
                        }
                    }
                }

                if($order_detail->cloth_id){
                    // If a cloth was imported in the order detail, the stock will go direct to it
                    $stock = ClothesWarehouses::findOne(['cloth_id' => $order_detail->cloth_id, 'warehouse_id' => $order_detail->order->warehouse_id]);
                    $stock->stock += $pieces;
                    $stock->save();

                } else {// Otherwise, create a semi cloth or a cloth

                    // If the assignment type is cut or production, create a semi cloth
                    if($assignment->type === LineAssignments::CUT || $assignment->type === LineAssignments::PRODUCTION){
                        $semi = new SemiClothes();
                        $semi->name = $order_detail->description;
                        $semi->description = $order_detail->additional_notes;
                        $semi->size = $order_detail->size;
                        $semi->assignment_id = $model->assignment_id;
                        $semi->color = $order_detail->color;
                        $semi->cost = $semi->average_cost = $assignment->getProductionCost();
                        $semi->save();

                        // Save the stock
                        $semi_stock = new SemiClothesWarehouses();
                        $semi_stock->semi_cloth_id = $semi->id;
                        // Get the warehouse
                        $production_line = ProductionLines::findOne($assignment->production_line_id);
                        $production_line->status = ProductionLines::WAITING;
                        $production_line->save();
                        $semi_stock->warehouse_id = $production_line->warehouse_id;
                        $semi_stock->stock = $pieces;
                        $semi_stock->save();
                    }
                    // If the assignment type is 'finishes', create a cloth
                    else if($assignment->type === LineAssignments::FINISHES){
                        $cloth = new Clothes();
                        $cloth->name = $order_detail->description;
                        $cloth->description = $order_detail->additional_notes;
                        $cloth->size = $order_detail->size;
                        $cloth->assignment_id = $model->assignment_id;
                        $cloth->color = $order_detail->color;
                        $cloth->cost = $cloth->average_cost = $assignment->getProductionCost();
                        $cloth->save();

                        // Save the stock
                        $stock = new ClothesWarehouses();
                        $stock->cloth_id = $cloth->id;
                        // Get the warehouse
                        $production_line = ProductionLines::findOne($assignment->production_line_id);
                        $production_line->status = ProductionLines::WAITING;
                        $production_line->save();
                        $stock->warehouse_id = $production_line->warehouse_id;
                        $stock->stock = $pieces;
                        $stock->save();

                        // Change order status if the stock is enough
                        if($order->hasEnoughStock()){
                            $order->scenario = Orders::SCENARIO_UPDATE_STATUS;
                            $order->status = Orders::WAITING_FOR_PICKUP;
                            $order->save();
                        }
                    }
                }

            } else {
                $assignment->status = LineAssignments::ON_PAUSE;
            }
            $assignment->save();

            Yii::$app->session->addFlash('success', 'Asignación actualizada con éxito.');

            return $this->redirect(['line-assignments/assigned', 'status' => LineAssignments::ON_PAUSE]);
        }

        return $this->render('stop-working', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LineHistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->quantity === 0 && $model->produced_timestamp){
            $model->delete();
            Yii::$app->session->addFlash('success', 'Registro eliminado correctamente.');
        } else if($model->quantity != 0){
            Yii::$app->session->addFlash('error', 'No se puede eliminar un registro que contiene piezas fabricadas.');
        } else {
            Yii::$app->session->addFlash('error', 'No se puede eliminar un registro se encuentra en progreso.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the LineHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LineHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LineHistory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
