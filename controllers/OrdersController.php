<?php

namespace app\controllers;

use app\models\Clothes;
use app\models\ClothesWarehouses;
use app\models\Customers;
use app\models\CustomersSearch;
use app\models\LineAssignments;
use app\models\LineAssignmentsSearch;
use app\models\OrderDetails;
use app\models\PurchaseOrderDetails;
use app\models\PurchaseOrders;
use app\models\Quotations;
use app\models\RecordCards;
use app\models\Sizes;
use app\models\ClothTransfers;
use yii\db\Exception;
use yii\helpers\Url;
use Yii;
use app\models\Orders;
use app\models\OrdersSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $searchModel = new LineAssignmentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($quotation_id = null, $customer_id = null)
    {
        $model = new Orders();

        $model->order_number = $model->getNextID();

        $customer = $customer_id ? Customers::findOne($customer_id) : null;

        // Order status starts always at 1
        $model->status = 1;
        $model->user_id = Yii::$app->user->id;
        $model->order_number;
        // Generate a random color
        $model->calendar_color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

        if($quotation_id){
            $quotation = Quotations::findOne($quotation_id);
            $model->customer_id = $quotation->customer_id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->hasEnoughStock()){
                $model->status = Orders::WAITING_FOR_PICKUP;
            }
            Yii::$app->session->addFlash('success', 'Orden creada correctamente, por favor agrega al menos un concepto.');
            return $this->redirect(['order-details/create', 'order_id' => $model->id, 'quotation_id' => $quotation_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'customer' => $customer
        ]);
    }

    public function actionConfirm($id){
        $order = $this->findModel($id);
        $order->scenario = Orders::SCENARIO_UPDATE_STATUS;

        $details = $order->getGridData();

        $total_stock = 0;
        foreach ($details as $record_card_id => $detail){
            $record_card = RecordCards::findOne($record_card_id);
            $stock = 0;
            foreach ($record_card->clothes as $cloth){
                foreach ($cloth->inventory as $item){
                    $stock += $item->stock;
                }
            }
            $total_stock += $stock;
        }
        if($total_stock > 0 && $post =  Yii::$app->request->post()){
            var_dump($post);exit();
            foreach ($details as $record_card_id => $item){
                foreach ($item['sizes'] as $size => $info){
                    $_size = Sizes::findOne(['name' => $size]);

                    $detail = OrderDetails::findOne(['order_id' => $id, 'record_card_id' => $record_card_id, 'size_id' => $_size->id]);

                    $quantity = (int)$info['quantity'];
                    $cloth = Clothes::findOne(['record_card_id' => $record_card_id]);
                    if($cloth){
                        $_stock = $cloth->getStock($_size->id);
                        $stock = ClothesWarehouses::findOne(['cloth_id' => $cloth->id, 'warehouse_id' => $order->warehouse_id, 'size_id' => $_size->id]);
                    }

                    // Stablish a needed base quantity
                    $_needed = $quantity - $_stock;
                    // Check if user modified the quantity
                    if(empty($post['Manufacture'][$record_card_id][$size])){
                        // If user didn't change anything, pre generated values will be used
                        $needed = $_needed;
                        $on_hold = $quantity - $needed;

                        if($on_hold > 0) {
                            $transfer = new ClothTransfers();
                            if ($stock) {
                                $stock->stock -= $on_hold;
                                $transfer->on_hold = $transfer->original_quantity = $on_hold;
                                $transfer->stock_id = $stock->id;
                                $transfer->type = 1;
                                $transfer->order_id = $order->id;
                                $transfer->save();
                                $stock->save();
                            }
                        }

                        $order->status = Orders::WAITING_FOR_MATERIAL;
                        $order->save();

                        $detail->manufacture_quantity = $needed;
                        $detail->save();

                    } else {
                        // If user changed something, let's use those values
                        $needed = (int)$post['Manufacture'][$record_card_id][$size];
                        $on_hold = $quantity - $needed;
                        if($on_hold > 0) {
                            $transfer = new ClothTransfers();
                            if($stock){
                                $stock->stock -= $on_hold;
                                $transfer->on_hold = $transfer->original_quantity = $on_hold;
                                $transfer->stock_id = $stock->id;
                                $transfer->type = 1;
                                $transfer->order_id = $order->id;
                                $transfer->save();
                                $stock->save();
                            }
                        }

                        $order->status = Orders::WAITING_FOR_MATERIAL;
                        $order->save();

                        $detail->manufacture_quantity = $needed;
                        $detail->save();
                    }

                }
            }

            Yii::$app->session->addFlash('success', 'Orden confirmada correctamente.');
            return $this->redirect(['supply', 'id' => $order->id]);

        } else if($post = Yii::$app->request->post()) {
            foreach ($post['Manufacture'] as $record_card_id => $pieces){
                foreach ($pieces as $size => $quantity){
                    $_size = Sizes::findOne(['name' => $size]);
                    $detail = OrderDetails::findOne(['order_id' => $id, 'record_card_id' => $record_card_id, 'size_id' => $_size->id]);
                    $detail->manufacture_quantity = $quantity;
                    $detail->save();
                }
            }

            foreach ($post['Purchase'] as $record_card_id => $pieces){
                foreach ($pieces as $size => $quantity){
                    $_size = Sizes::findOne(['name' => $size]);
                    $detail = OrderDetails::findOne(['order_id' => $id, 'record_card_id' => $record_card_id, 'size_id' => $_size->id]);
                    $detail->purchase_quantity = $quantity;
                    $detail->save();
                }
            }
            $order->status = Orders::WAITING_FOR_MATERIAL;
            $order->save();
            Yii::$app->session->addFlash('success', 'Orden confirmada correctamente.');
            return $this->redirect(['order-details/index', 'order_id' => $order->id]);

        }

        return $this->render('confirm', [
            'details' => $details,
            'order' => $order,
        ]);
    }


    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSupply($id){

        $order = $this->findModel($id);

        $details = [];
        foreach ($order->details as $detail){
            $details[$detail->record_card_id]['description'] = $detail->description;
            $details[$detail->record_card_id]['model'] = $detail->recordCard->model;
            if(isset($details[$detail->record_card_id]['quantity'])){
                $details[$detail->record_card_id]['quantity'] += $detail->manufacture_quantity;
            } else {
                $details[$detail->record_card_id]['quantity'] = $detail->manufacture_quantity;
            }
            $record_card = RecordCards::findOne($detail->record_card_id);
            foreach ($record_card->components as $component){
                $details[$detail->record_card_id]['materials'][$component->material->id] = $component->material->attributes;
                $details[$detail->record_card_id]['materials'][$component->material->id]['unit'] = $component->material->unit->name;
                $details[$detail->record_card_id]['materials'][$component->material->id]['quantity'] = $component->quantity;
                $details[$detail->record_card_id]['materials'][$component->material->id]['stock'] = $component->material->getStock();
            }

            foreach ($record_card->parts as $part){
                $details[$detail->record_card_id]['parts'][$part->id] = $part->part->attributes;
                $details[$detail->record_card_id]['parts'][$part->id]['quantity'] = $part->quantity;
                $details[$detail->record_card_id]['parts'][$part->id]['unit'] = $part->part->unit->name;
                $details[$detail->record_card_id]['parts'][$part->id]['stock'] = $part->part->getStock();
            }
        }

        if($post = Yii::$app->request->post()){

            $purchases = array();
            unset($post['_csrf']);
            foreach ($post as $key => $items) {
                foreach ($items as $_id => $info){
                    $purchases[$info['supplier']][$key][$_id] = $info['purchase'] ;
                }
            }

            unset($purchases['']);
            ksort($purchases, SORT_NUMERIC);
            $Materials = $Parts = [];
            // Assign values if not modified by user
            foreach ($details as $record_card_id => $detail) {
                foreach ($detail['materials'] as $_id => $material){
                    $Materials[$_id] = $material;
                    $Materials[$_id]['required'] = round($material['quantity']*$detail['quantity'], 2);
                }
                foreach ($detail['parts'] as $_id => $part){
                    $Parts[$_id] = $part;
                    $Parts[$_id]['required'] = round($part['quantity']*$detail['quantity'], 2);
                }
            }

            $transaction = Yii::$app->db->beginTransaction();

            foreach ($purchases as $supplier_id => $types){

                $purchase_order = new PurchaseOrders();
                $purchase_order->order_id = $order->id;
                $purchase_order->requested_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + 2 days'));
                $purchase_order->user_id = Yii::$app->user->id;
                $purchase_order->supplier_id = $supplier_id;
                $purchase_order->save();

                foreach ($types as $type => $items){

                    $purchase_order_detail = new PurchaseOrderDetails();
                    $purchase_order_detail->purchase_order_id = $purchase_order->id;

                    foreach ($items as $_id => $value){
                        if(!$value) {
                            $to_purchase = max(${$type}[$_id]['required'] - ${$type}[$_id]['stock'], 0);
                        } else {
                            $to_purchase = floatval($purchases[$supplier_id][$type][$_id]);
                        }

                        if($to_purchase > 0){
                            $purchase_order_detail->description = ${$type}[$_id]['name']." ".${$type}[$_id]['description'];
                            $purchase_order_detail->estimated_cost = ${$type}[$_id]['cost'];
                            $purchase_order_detail->unit_id = ${$type}[$_id]['unit_id'];
                            $purchase_order_detail->quantity = $to_purchase;
                            if(!$purchase_order_detail->save()){
                                $transaction->rollBack();
                            }
                        }
                    }
                }
            }

            // Add cloth pieces marked as "for purchase" if any
            if($purchase_order){
                foreach ($details as $record_card_id => $detail){
                    $_details = OrderDetails::find()->where(['record_card_id' => $record_card_id, 'order_id' => $order->id])->all();
                    foreach ($_details as $_detail){
                        /* @var $_detail OrderDetails */
                        if($_detail->purchase_quantity){
                            $purchase_order_detail = new PurchaseOrderDetails();
                            $purchase_order_detail->purchase_order_id = $purchase_order->id;
                            $purchase_order_detail->description = $_detail->product->description;
                            $purchase_order_detail->unit_id = 1;
                            $purchase_order_detail->quantity = $_detail->purchase_quantity;
                            if(!$purchase_order_detail->save()){
                                $transaction->rollBack();
                            }
                        }
                    }
                }
            }

            try{
                $transaction->commit();
                Yii::$app->session->addFlash('success', 'Orden de compra generada correctamente');
                return $this->redirect(['purchase-orders/view', 'id' => $purchase_order->id]);
            } catch (yii\db\Exception $exception){
                $transaction->rollBack();
                Yii::$app->session->addFlash('error', 'Algo salió mal: '.$exception->getMessage());
                // Let render view as usual
            }
        }

        return $this->render('supply', [
            'order' => $order,
            'details' => $details,
        ]);

    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCalendar(){
        if(Yii::$app->request->post()){
            $orders = Orders::find()->where(['<>', 'status', Orders::COMPLETED])->all();
            $response = [];
            foreach ($orders as $order) {
                /* @var $order Orders */
                $created_at = new \DateTime($order->creation_timestamp);
                $due_for = new \DateTime($order->due_date);
                $response[] = [
                    'title' => "Orden " . $order->order_number,
                    'start' => $created_at->format('Y-m-d\Th:m:s'),
                    'end' => $due_for->format('Y-m-d\Th:m:s'),
                    'url' => Url::to(['view', 'id' => $order->id]),
                    'color' => $order->calendar_color
                ];
                //Register order payment date
                $payment_due = new \DateTime($order->payment_due_date);
                $response[] = [
                    'title' => "Pago de orden",
                    'start' => $payment_due->format('Y-m-d\Th:m:s'),
                    'url' => Url::to(['view', 'id' => $order->id]),
                    'color' => '#2e7d32'
                ];
            }
            return $this->asJson($response);
        }

        return $this->render('calendar');
    }

    /**
     * Lists all Customers models.
     * @return mixed
     */
    public function actionSelectCustomer()
    {
        $searchModel = new CustomersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('select-customer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionSetReady($assignment_id){
        $assignment = LineAssignments::findOne($assignment_id);
        $order = $assignment->orderDetail->order;

        // Set scenario to not check for dates
        $order->scenario = Orders::SCENARIO_UPDATE_STATUS;

        $order->status = Orders::READY_TO_START;
        $order->save();
        return $this->redirect(['line-assignment-details/index', 'assignment_id' => $assignment->id]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
