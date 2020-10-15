<?php

namespace app\controllers;

use app\models\ClothEntries;
use app\models\Clothes;
use app\models\ClothesSearch;
use app\models\Orders;
use app\models\PartEntries;
use app\models\Parts;
use app\models\PartsSearch;
use app\models\PurchaseOrderDetailsSearch;
use app\models\RawMaterial;
use app\models\RawMaterialEntries;
use app\models\RawMaterialSearch;
use Yii;
use app\models\PurchaseOrders;
use app\models\PurchaseOrdersSearch;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PurchaseOrdersController implements the CRUD actions for PurchaseOrders model.
 */
class PurchaseOrdersController extends Controller
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
     * Lists all PurchaseOrders models.
     * @return mixed
     */
    public function actionIndex($filter_order_number = null)
    {
        $searchModel = new PurchaseOrdersSearch();
        $searchModel->order_number = $filter_order_number;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PurchaseOrders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new PurchaseOrderDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new PurchaseOrders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PurchaseOrders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PurchaseOrders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionConfirm($id){
        $model = $this->findModel($id);
        if($model->status == PurchaseOrders::TO_BE_CONFIRMED) {
            $model->status = PurchaseOrders::IN_PROGRESS;
            $model->save();
            Yii::$app->session->addFlash('success', 'Orden de compra confirmada correctamente.');
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionReception($id){
        $model = $this->findModel($id);
        if($model->status == PurchaseOrders::IN_PROGRESS) {
            $model->status = PurchaseOrders::WAITING_ENTRY;
            $model->arrival_date = new Expression('NOW()');
            $model->save();
            Yii::$app->session->addFlash('success', 'Orden de compra confirmada como recibida.');
        }
        return $this->redirect(['view', 'id' => $id]);
    }


    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionCreateEntry($id){
        $model = $this->findModel($id);
        if($model->status == PurchaseOrders::WAITING_ENTRY){
            if($post = Yii::$app->request->post()){
                //Map the arrays into one
                $items = [];
                foreach ($post['Types'] as $_id => $type){
                    $items[$_id] = [
                        'id' => (int)$post[ucfirst($type)][$_id],
                        'type' => $type,
                        'quantity' => (float)$post['Quantities'][$_id],
                        'warehouse' => (int)$post['Warehouses'][$_id],
                        'cost' => (float)$post['Costs'][$_id]
                    ];
                }

                $entries_created = 0;
                foreach ($items as $_id => $item){

                    switch ($item['type']){

                        case 'material': $entryModel = new RawMaterialEntries(); $attribute = 'raw_material_id'; break;
                        case 'part': $entryModel = new PartEntries(); $attribute = 'part_id'; break;
                        case 'cloth': $entryModel = new ClothEntries(); $attribute = 'cloth_id'; break;

                    }


                    $entryModel->$attribute = $item['id'];
                    $entryModel->warehouse_id = $item['warehouse'];
                    $entryModel->user_id = Yii::$app->user->id;
                    $entryModel->supplier_id = $model->supplier_id;
                    $entryModel->quantity = $item['quantity'];
                    $entryModel->cost = $item['cost'];

                    if($item['type'] == 'cloth'){
                        foreach ($model->order->details as $detail){
                            if($detail->record_card_id == $entryModel->cloth->record_card_id && $detail->purchase_quantity > 0){
                                $entryModel->size_id = $detail->size_id;
                            }
                        }
                    }
                    if($entryModel->save()){
                        $entries_created++;
                    }
                }
                $failed = count($items) - $entries_created;
                if($entries_created > 0){
                    $s = $entries_created != 1 ? 's' : '';
                    $n = $entries_created != 1 ? 'n' : '';
                    Yii::$app->session->addFlash('success', "$entries_created entrada$s ha$n sido creada$s");
                }
                if($failed > 0){
                    $s = $failed != 1 ? 's' : '';
                    Yii::$app->session->addFlash('error', "Ha ocurrido un error con $failed entrada$s");
                }
                $model->status = PurchaseOrders::COMPLETED;
                $model->save();
                $model->order->status = Orders::READY_TO_START;
                $model->order->save();
                return $this->redirect(['order-details/index', 'order_id' => $model->order_id]);
            }

            return $this->render('create-entry', [
                'purchase_order' => PurchaseOrders::findOne($id)
            ]);
        }
    }


    public function actionSelectCloth(){
        $searchModel = new ClothesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderPartial('select-cloth', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSelectMaterial(){
        $searchModel = new RawMaterialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderPartial('select-material', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSelectPart(){
        $searchModel = new PartsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderPartial('select-part', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetElementDetails($id, $type){

        switch ($type){
            case 'material': $model = RawMaterial::findOne($id); break;
            case 'cloth': $model = Clothes::findOne($id); break;
            case 'part': $model = Parts::findOne($id); break;
        }
        $description = $model->name;
        if(isset($model->description)){
            $description .= " ".$model->description;
        }

        return $this->asJson(['description' => $description]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCancel($id){
        $model = $this->findModel($id);
        $model->status = PurchaseOrders::CANCELED;
        $model->save();
        Yii::$app->session->addFlash('success', 'Orden de compra cancelada correctamente.');
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Deletes an existing PurchaseOrders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->addFlash('success', 'Orden de compra eliminada correctamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the PurchaseOrders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseOrders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseOrders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
