<?php

namespace app\controllers;

use app\models\LineAssignments;
use app\models\Orders;
use app\models\RawMaterial;
use app\models\RawMaterialSearch;
use app\models\SemiClothes;
use app\models\SemiClothesSearch;
use Yii;
use app\models\LineAssignmentDetails;
use app\models\LineAssignmentDetailsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LineAssignmentDetailsController implements the CRUD actions for LineAssignmentDetails model.
 */
class LineAssignmentDetailsController extends Controller
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
     * Lists all LineAssignmentDetails models.
     * @return mixed
     */
    public function actionIndex($assignment_id)
    {
        $searchModel = new LineAssignmentDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $assignment_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'assignment_id' => $assignment_id,
        ]);
    }

    /**
     * Creates a new LineAssignmentDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($assignment_id, $semi_cloth_id = null, $raw_material_id = null)
    {
        $model = new LineAssignmentDetails();
        $model->assignment_id = $assignment_id;

        $semi_cloth = $raw_material = null;

        if($model->semi_cloth_id = $semi_cloth_id){
            $semi_cloth = SemiClothes::findOne($semi_cloth_id);
            $stock = $semi_cloth->getUnassignedStock();
            if($stock['stock'] == 0){
                $semi_cloth = null;
                Yii::$app->session->addFlash('error', 'No se puede seleccionar una semiprenda sin existencias, por favor intenta con otra.');
            } else if($stock['available'] <= 0) {
                $semi_cloth = null;
                Yii::$app->session->addFlash('error', 'Ésta semiprenda tiene todas sus existencias asignadas. Por favor, elige otra.');
            }
        }

        if($model->raw_material_id = $raw_material_id){
            $raw_material = RawMaterial::findOne($raw_material_id);
            $stock = $raw_material->getUnassignedStock();
            if($stock['stock'] == 0){
                $raw_material = null;
                Yii::$app->session->addFlash('error', 'No se puede seleccionar un material sin existencias, por favor intenta con otro.');
            } else if($stock['available'] <= 0){
                $raw_material = null;
                Yii::$app->session->addFlash('error', 'Éste material tiene todas sus existencias asignadas. Por favor, elige otro.');
            }
        }

        $assignment = LineAssignments::findOne($assignment_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Detalle agregado con éxito.');
            return $this->redirect(['index', 'assignment_id' => $assignment_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'assignment' => $assignment,
            'semi_cloth' => $semi_cloth,
            'raw_material' => $raw_material,
        ]);
    }

    /**
     * @param $assignment_id
     * @return string
     */
    public function actionSelectRawMaterial($assignment_id){

        $searchModel = new RawMaterialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('select-raw-material', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'assignment_id' => $assignment_id,
        ]);
    }

    /**
     * @param $assignment_id
     * @return string
     */
    public function actionSelectSemiCloth($assignment_id){

        $assignment = LineAssignments::findOne($assignment_id);
        if($assignment->type === LineAssignments::CUT){
            Yii::$app->session->addFlash('error', 'No se puede seleccionar una semiprenda para una asignación de CORTE.');
            return $this->redirect(['create', 'assignment_id' => $assignment_id]);
        }

        $searchModel = new SemiClothesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('select-semi-cloth', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'assignment_id' => $assignment_id,
        ]);
    }

    /**
     * Deletes an existing LineAssignmentDetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $assignment_id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->addFlash('success', 'Detalle eliminado con éxito.');

        return $this->redirect(['index', 'assignment_id' => $assignment_id]);
    }

    /**
     * Finds the LineAssignmentDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LineAssignmentDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LineAssignmentDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
