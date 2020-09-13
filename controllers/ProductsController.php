<?php

namespace app\controllers;

use app\models\UploadForm;
use Yii;
use app\models\Products;
use app\models\ProductsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();

        $uploadModel = new UploadForm();

        if ($model->load(Yii::$app->request->post())) {
            // Upload files
            $uploadModel->front = UploadedFile::getInstance($uploadModel, 'front');
            $uploadModel->back = UploadedFile::getInstance($uploadModel, 'back');

            if ($names = $uploadModel->upload()) {
                $model->back_image = $names['back'];
                $model->front_image = $names['front'];
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Ficha guardada correctamente');
                } else {
                    Yii::$app->session->setFlash('error', 'Ocurrió un error inesperado al guardar el producto.');
                    $model->back_image = $model->front_image = '';

                    return $this->render('create', [
                        'model' => $model,
                        'uploadModel' => $uploadModel,
                    ]);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Ocurrió un error inesperado al intentar subir las imágenes.');
            }
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'uploadModel' => $uploadModel,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $uploadModel = new UploadForm();

        $old_images = ['front' => $model->front_image, 'back' => $model->back_image];

        if ($model->load(Yii::$app->request->post())) {
            // Check if is required to upload files
            $upload = false;
            if($model->front_image !== $old_images['front']){
                $uploadModel->front = UploadedFile::getInstance($uploadModel, 'front');
                $upload = true;
            }
            if($model->back_image !== $old_images['back']){
                $uploadModel->back = UploadedFile::getInstance($uploadModel, 'back');
                $upload = true;
            }
            if($upload){
                $names = $uploadModel->upload();
                $model->back_image = $names['back'];
                $model->front_image = $names['front'];
            }
            // Save the model
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Ficha guardada correctamente');
            } else {
                Yii::$app->session->setFlash('error', 'Ocurrió un error inesperado al intentar guardar la ficha.');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'uploadModel' => $uploadModel,
            ]);
        }
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
