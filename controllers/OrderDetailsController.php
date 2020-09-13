<?php

namespace app\controllers;

use app\models\Clothes;
use app\models\ClothesSearch;
use app\models\ClothTypes;
use app\models\ClothTypesRecordCards;
use app\models\Orders;
use app\models\Products;
use app\models\ProductsSearch;
use app\models\QuotationDetails;
use app\models\RecordCardDesigns;
use app\models\RecordCards;
use app\models\RecordCardsSearch;
use app\models\Sizes;
use app\models\UploadForm;
use function foo\func;
use Yii;
use app\models\OrderDetails;
use app\models\OrderDetailsSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * OrderDetailsController implements the CRUD actions for OrderDetails model.
 */
class OrderDetailsController extends Controller
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
     * Lists all OrderDetails models.
     * @return mixed
     */
    public function actionIndex($order_id, $view = null)
    {
        $searchModel = new OrderDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $order_id);

        $order = Orders::findOne($order_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order' => $order,
            'view' => $view,
        ]);
    }

    /**
     * Displays a single OrderDetails model.
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
     * Creates a new OrderDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($order_id, $cloth_id = null, $product_id = null, $record_card_id = null, $quotation_id = null)
    {
        $model = new OrderDetails();
        $order = Orders::findOne($order_id);

        $model->order_id = $order_id;
        $cloth = null;

        // When it comes from a quotation, create the details and redirect
        if($quotation_id){
            $quotation_details = QuotationDetails::findAll(['quotation_id' => $quotation_id]);

            foreach ($quotation_details as $detail){
                $model = new OrderDetails();
                $model->order_id = $order_id;
                $model->description = $detail->description;
                $model->size = $detail->size;
                $model->price = $detail->price;
                $model->quantity = $detail->quantity;
                $model->additional_notes = $detail->additional_notes;
                $model->save();
            }
            Yii::$app->session->addFlash('success', 'Orden creada correctamente a partir de la cotización #'.$quotation_id);
            return $this->redirect(['index', 'order_id' => $order_id]);
        }

        // when the user selects a product preset, load its data
        $record_card = $product = $uploadModel = null;
        if($product_id){
            $product = Products::findOne($product_id);
            $model->product_id = $product->id;
            $model->description = $product->description;

            $record_card = new RecordCards();
            $record_card->description = $product->description;
            $model->price = $record_card->getEstimatedPrice();

            $uploadModel = new UploadForm();

            if($record_card_id){
                $record_card = RecordCards::findOne($record_card_id);
                $record_card->product_id = $product->id;
            }

        }

        // when the user select a cloth, load its details
        if($cloth_id){
            $cloth = Clothes::findOne($cloth_id);
            $model->cloth_id = $cloth->id;
            $model->description = $cloth->name;
            $model->price = round($cloth->average_cost * (1+($cloth->profit_margin/100)), 2);
        }

        // Save the data
        if($post = Yii::$app->request->post()) {
            //Create a record card
            if(!$record_card_id){
                $record_card = new RecordCards();
                $record_card->load($post);
                $record_card->additional_notes = $model->additional_notes;
                $record_card->description = $model->description;
                $record_card->product_id = $product->id;
                if(!$record_card->save()){
                    var_dump( $record_card->errors[0]);exit();
                    Yii::$app->session->addFlash('error', $record_card->errors[0]);
                    return $this->redirect(['create', 'order_id' => $order_id, 'product_id' => $product_id]);
                }
                // Add the designs to the new record card
                if(isset($post['RecordCardDesigns'])){
                    foreach($post['RecordCardDesigns'] as $design_id){
                        $design = RecordCardDesigns::findOne($design_id);
                        $design->record_card_id = $record_card->id;
                        $design->save();
                    }
                }
            } else {
                // If any attribute is different, create a new record card
                $record_card = RecordCards::findOne($record_card_id);
                $_record_card = new RecordCards();
                $_record_card->load($post);
                $_record_card->additional_notes = $model->additional_notes;
                $_record_card->description = $model->description;
                $_record_card->product_id = $product_id;

                $r1 = $record_card->attributes; $r2 = $_record_card->attributes;
                // Remove irrelevant attributes
                unset($r1['id']);unset($r2['id']);
                unset($r1['width']);unset($r2['width']);
                unset($r1['height']);unset($r2['height']);
                unset($r1['weight']);unset($r2['weight']);

                // Even if we have different cloth types
                $ct1 = ArrayHelper::map($record_card->clothTypesRecordCards, 'id', function($model){
                    /* @var $model ClothTypesRecordCards */
                    return ['name' => $model->clothType->name, 'color' => $model->clothType->color];
                });
                $ct2 = $post['ClothTypes'];

                // Or different designs
                $d1 = $post['RecordCardDesigns']; $d2 = [];
                foreach ($record_card->designs as $design) {
                    $d2[] = strval($design->id);
                }

                if( ($r1 != $r2) || ($ct1 != $ct2 && !empty($ct1)) || ($d1 != $d2) ){
                    $record_card = new RecordCards();
                    $record_card->load($post);
                    $record_card->additional_notes = $model->additional_notes;
                    $record_card->description = $model->description;
                    $record_card->save();
                    // Assign the new record card
                    $model->record_card_id = $record_card->id;
                    $clone_logos = array_values(array_intersect($d1, $d2));
                    $new_logos = array_values(array_diff($d1,$d2));
                    // Assign record card id to new logos
                    foreach ($new_logos as $logo_id) {
                        $new_design = RecordCardDesigns::findOne((int)$logo_id);
                        $new_design->record_card_id = $record_card->id;
                        $new_design->save();
                    }
                    // Clone other logos into the new record card
                    foreach ($clone_logos as $logo_id) {
                        $old_design = RecordCardDesigns::findOne((int)$logo_id);
                        $new_design = new RecordCardDesigns();
                        $new_design->setAttributes($old_design->attributes);
                        $new_design->record_card_id = $record_card->id;
                        $new_design->save();
                    }
                }
            }

            // Add cloth types to record card
            foreach ($post['ClothTypes'] as $cloth_type_id => $clothType){
                $clotTypeModel = new ClothTypesRecordCards();
                $clotTypeModel->record_card_id = $record_card->id;
                $clotTypeModel->cloth_type_id = $cloth_type_id;
                $clotTypeModel->save();
            }
            $size_valid = false;
            $details_created = 0;

            foreach ($post['Sizes'] as $id => $size){
                $_quantity = intval($size['qty']);
                $_price = floatval($size['price']);

                if($_quantity > 0){
                    $model = new OrderDetails();
                    $size_valid = true;

                    $model->load($post);

                    $model->record_card_id = $record_card->id;
                    $model->product_id = $product_id;
                    $model->order_id = $order_id;
                    $model->size_id = $id;
                    $model->quantity = $_quantity;
                    $model->price = $_price;

                    if($model->save()){
                        $details_created++;
                    }
                }
            }

            if($size_valid === false){
                Yii::$app->session->addFlash('error', 'Debes ingresar al menos una pieza de alguna talla.');
                return $this->redirect(['create', 'order_id' => $order_id, 'product_id' => $product_id, 'record_card_id' => $record_card->id]);
            }

            if($details_created > 0){
                $s = $details_created != 1 ? 's' : '';
                Yii::$app->session->addFlash('success', "$details_created concepto$s agregado$s a la orden correctamente.");
            } else {
                Yii::$app->session->addFlash('error', 'No se pudo agregar el concepto a la orden. ');
            }

            return $this->redirect(['index', 'order_id' => $order_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'order' => $order,
            'cloth' => $cloth,
            'product' => $product,
            'recordCard' => $record_card,
            'uploadModel' => $uploadModel,
            'order_id' => $order_id,
        ]);
    }

    /**
     * @param $order_id int
     * @return string
     */
    public function actionImportCloth($order_id){
        $searchModel = new ClothesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('import-cloth', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order_id' => $order_id,
        ]);
    }

    /**
     * @param $order_id int
     * @return string
     */
    public function actionImportProduct($order_id){
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('import-product', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order' => Orders::findOne($order_id),
        ]);
    }

    /**
     * Lists all RecordCards models.
     * @return mixed
     */
    public function actionImportRecordCard($order_id, $product_id)
    {
        $searchModel = new RecordCardsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $product_id);

        return $this->render('import-record-card', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order' => Orders::findOne($order_id),
            'product_id' => $product_id,
        ]);
    }

    /**
     * Deletes an existing OrderDetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $order_id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->addFlash('success', 'Concepto eliminado de la orden correctamente.');
        return $this->redirect(['index', 'order_id' => $order_id]);
    }

    /**
     * Deletes an existing details batch.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteBatch($order_id, $record_card_id, $product_id, $view = null)
    {
        $batch = OrderDetails::find()->where(['order_id' => $order_id, 'record_card_id' => $record_card_id, 'product_id' => $product_id])->all();
        foreach ($batch as $item) {
            $this->findModel($item->id)->delete();
        }
        Yii::$app->session->addFlash('success', 'Concepto eliminado de la orden correctamente.');
        return $this->redirect(['index', 'order_id' => $order_id, 'view' => $view]);
    }

    /**
     * Finds the OrderDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
