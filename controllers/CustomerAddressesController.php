<?php

namespace app\controllers;

use app\models\Cities;
use Yii;
use app\models\CustomerAddresses;
use app\models\CustomerAddressesSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerAddressesController implements the CRUD actions for CustomerAddresses model.
 */
class CustomerAddressesController extends Controller
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CustomerAddresses models.
     * @return mixed
     */
    public function actionIndex($customer_id)
    {
        $searchModel = new CustomerAddressesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $customer_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'customer_id' => $customer_id
        ]);
    }

    /**
     * Displays a single CustomerAddresses model.
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
     * Creates a new CustomerAddresses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($customer_id)
    {
        $model = new CustomerAddresses();

        $model->customer_id = $customer_id;
        /* TODO: Review if country should be an integer ID */
        $model->country = "México";

        if($post = Yii::$app->request->post()){
            if ($city = Cities::findOne(['name' => $post['CustomerAddresses']['city_id']])){
                $model->load($post);
                $model->city_id = $city->id;
                if ($model->save()) {
                    Yii::$app->session->addFlash('success', 'Dirección guardada con éxito');
                    return $this->redirect(['index', 'customer_id' => $model->customer_id]);
                }
            }else{
                $model->addError('city_id', 'La ciudad ingresada no existe');
            }
        }

        return $this->render('create', [
            'model' => $model,
            'customer_id' => $customer_id
        ]);
    }

    /**
     * Gets the cities from a state for autocomplete inputs
     * @param $state int The state id
     * @return \yii\web\Response A json array format response with the cities
     */
    public function actionGetCities($state){

        $cities = Cities::findAll(['state_id' => $state]);

        $list = ArrayHelper::map($cities, 'name', 'id');

        foreach ($list as $index => $item){
            $list[$index] = null;
        }
        return $this->asJson($list);
    }

    /**
     * Updates an existing CustomerAddresses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->city_id = Cities::findOne($model->city_id)->name;

        if($post = Yii::$app->request->post()){
            if ($city = Cities::findOne(['name' => $post['CustomerAddresses']['city_id']])){
                $model->load($post);
                $model->city_id = $city->id;
                if ($model->save()) {
                    Yii::$app->session->addFlash('success', 'Dirección guardada con éxito');
                    return $this->redirect(['index', 'customer_id' => $model->customer_id]);
                }
            }else{
                $model->addError('city_id', 'La ciudad ingresada no existe');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CustomerAddresses model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $address = $this->findModel($id);
        $customer_id = $address->customer_id;
        $address->delete();
        Yii::$app->session->addFlash('success', 'Dirección eliminada con éxito');
        return $this->redirect(['index', 'user_id' => $customer_id]);
    }

    /**
     * Finds the CustomerAddresses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomerAddresses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerAddresses::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
