<?php

namespace app\controllers;

use app\models\Parts;
use app\models\RecordCards;
use app\models\Units;
use Yii;
use app\models\RecordCardParts;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecordCardPartsController implements the CRUD actions for RecordCardParts model.
 */
class RecordCardPartsController extends Controller
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
     * Creates a new RecordCardParts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($record_card_id)
    {
        $model = new RecordCardParts();

        $model->record_card_id = $record_card_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Avío agregado correctamente.');
            return $this->redirect(['record-cards/view', 'id' => $record_card_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionGetUnit($part_id){
        return $this->asJson(['unit' => Parts::findOne($part_id)->unit->name]);
    }

    /**
     * Deletes an existing RecordCardParts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $record_card_id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->addFlash('success', 'Avío eliminado correctamente.');
        return $this->redirect(['record-cards/view', 'id' => $record_card_id]);
    }

    /**
     * Finds the RecordCardParts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RecordCardParts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecordCardParts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
