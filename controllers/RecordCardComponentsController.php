<?php

namespace app\controllers;

use app\models\RawMaterial;
use app\models\RawMaterialSearch;
use app\models\RecordCards;
use Yii;
use app\models\RecordCardComponents;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecordCardComponentsController implements the CRUD actions for RecordCardComponents model.
 */
class RecordCardComponentsController extends Controller
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
     * Creates a new RecordCardComponents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($record_card_id, $material_id = null)
    {
        $model = new RecordCardComponents();

        $model->record_card_id = $record_card_id;

        $recordCard = RecordCards::findOne($record_card_id);
        $material = RawMaterial::findOne($material_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Avío agregado correctamente');
            return $this->redirect(['/record-cards/view', 'id' => $record_card_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'recordCard' => $recordCard,
                'material' => $material,
            ]);
        }
    }

    /**
     * @param $assignment_id
     * @return string
     */
    public function actionSelectComponent($record_card_id){

        $searchModel = new RawMaterialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $recordCard = RecordCards::findOne($record_card_id);

        return $this->render('select-component', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'recordCard' => $recordCard,
        ]);
    }

    public function actionGetUnit($material_id){
        return $this->asJson(['unit' => RawMaterial::findOne($material_id)->unit->name]);
    }

    /**
     * Deletes an existing RecordCardComponents model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $record_card_id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Avío eliminado correctamente');
        return $this->redirect(['/record-cards/view', 'id' => $record_card_id]);
    }

    /**
     * Finds the RecordCardComponents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RecordCardComponents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecordCardComponents::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }
}
