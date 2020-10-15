<?php

namespace app\controllers;

use app\models\RecordCards;
use Yii;
use app\models\RecordCardPieces;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecordCardPiecesController implements the CRUD actions for RecordCardPieces model.
 */
class RecordCardPiecesController extends Controller
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
     * Creates a new RecordCardPieces model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($record_card_id)
    {
        $model = new RecordCardPieces();
        $model->record_card_id = $record_card_id;

        $recordCard = RecordCards::findOne($record_card_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Pieza agregado correctamente');
            return $this->redirect(['/record-cards/view', 'id' => $record_card_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'recordCard' => $recordCard,
            ]);
        }
    }

    /**
     * Deletes an existing RecordCardPieces model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $record_card_id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Pieza eliminada correctamente');
        return $this->redirect(['/record-cards/view', 'id' => $record_card_id]);
    }

    /**
     * Finds the RecordCardPieces model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RecordCardPieces the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecordCardPieces::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }
}
