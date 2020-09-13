<?php

namespace app\controllers;

use app\models\ClothesWarehouses;
use app\models\RecordCards;
use app\models\RecordCardsSearch;
use Yii;
use app\models\Clothes;
use app\models\ClothesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClothesController implements the CRUD actions for Clothes model.
 */
class ClothesController extends Controller
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
     * Lists all Clothes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClothesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Clothes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($record_card_id = null)
    {
        $model = new Clothes();
        $record_card = null;

        if($record_card_id){
            $record_card = RecordCards::findOne($record_card_id);
            $model->record_card_id = $record_card->id;
            $model->name = $record_card->description;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Prenda creada correctamente.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'recordCard' => $record_card,
        ]);
    }

    public function actionImportRecordCard(){
        $searchModel = new RecordCardsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('import-record-card', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Clothes model.
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

    /**
     * Deletes an existing Clothes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->getStock() === 0){
            $model->delete();
            ClothesWarehouses::deleteAll(['cloth_id' => $id]);
            Yii::$app->session->addFlash("success", "Prenda eliminada correctamente.");
        } else {
            Yii::$app->session->addFlash("error", "No se puede eliminar la prenda porque aún quedan existencias.");
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Clothes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clothes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clothes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
