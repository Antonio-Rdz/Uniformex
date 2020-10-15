<?php

namespace app\controllers;

use app\models\RecordCards;
use app\models\UploadForm;
use Yii;
use app\models\RecordCardDesigns;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * RecordCardsDesignsController implements the CRUD actions for RecordCardsDesigns model.
 */
class RecordCardDesignsController extends Controller
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
     * Creates a new RecordCardsDesigns model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($record_card_id = null, $new = null)
    {
        $model = new RecordCardDesigns();

        if(!$new){
            $model->record_card_id = $record_card_id;
        }
        $uploadModel = new UploadForm();

        if ($model->load(Yii::$app->request->post())) {

            if($new){
                $newCard = new RecordCards();
                $newCard->setAttributes(RecordCards::findOne($record_card_id)->attributes);
                $newCard->save();
            }
            // Upload file
            $uploadModel->design = UploadedFile::getInstance($uploadModel, 'design');

            if ($names = $uploadModel->upload()) {
                $model->image = $names['design'];
                $model->save();
                Yii::$app->session->addFlash('success', 'Logotipo agregado con éxito');
            } else {
                Yii::$app->session->setFlash('error', 'Ocurrió un error inesperado al intentar guardar el logotipo.');
            }

            return $this->redirect(['record-cards/view', 'id' => $record_card_id]);

        } else {
            if(!$new){
                return $this->render('create', [
                    'model' => $model,
                    'recordCard' => RecordCards::findOne($record_card_id),
                    'uploadModel' => $uploadModel,
                ]);
            } else {
                return $this->renderPartial('create', [
                    'model' => $model,
                    'uploadModel' => $uploadModel,
                ]);
            }

        }
    }

    /**
     * Updates an existing RecordCardsDesigns model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $record_card_id)
    {
        $model = $this->findModel($id);

        $uploadModel = new UploadForm();


        if ($model->load(Yii::$app->request->post())) {

            $uploadModel->design = UploadedFile::getInstance($uploadModel, 'design');

            if($names = $uploadModel->upload()){
                $model->image = $names['design'];
                $model->save();
                Yii::$app->session->addFlash('success', 'Logotipo editado con éxito');
            } else {
                Yii::$app->session->setFlash('error', 'Ocurrió un error inesperado al intentar guardar el logotipo.');
            }

            return $this->redirect(['record-cards/view', 'id' => $record_card_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'recordCard' => RecordCards::findOne($record_card_id),
                'uploadModel' => $uploadModel,
            ]);
        }
    }

    /**
     * Deletes an existing RecordCardsDesigns model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $record_card_id = $model->record_card_id;
        $model->delete();
        Yii::$app->session->addFlash('success', 'Logotipo eliminado con éxito');
        return $this->redirect(['record-card/view', 'id' => $record_card_id]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionColorSequenceList($id){
        $_colors = [];
        $model = $this->findModel($id);
        $colors = explode(',', $model->color_sequence);
        foreach ($colors as $color) {
            $_colors[] = ['tag' => $color];
        }
        return $this->asJson($_colors);
    }

    /**
     * Creates a new logo without a record card and returns the ID
     * @return int|\yii\web\Response
     */
    public function actionCreateLogo(){

        $uploadModel = new UploadForm();
        $model = new RecordCardDesigns();

        if ($model->load(Yii::$app->request->post())) {
            $uploadModel->design = UploadedFile::getInstance($uploadModel, 'design');

            if($names = $uploadModel->upload()){
                $model->image = $names['design'];
                if($model->save()){
                    return $this->renderPartial('list-item', [
                        'model' => $model,
                    ]);
                } else {
                    return '';
                }
            }

        }
        return '';
    }
    /**
     * Finds the RecordCardsDesigns model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RecordCardDesigns the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecordCardDesigns::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }
}
