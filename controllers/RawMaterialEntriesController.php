<?php

namespace app\controllers;

use app\models\MaterialWarehouses;
use app\models\RawMaterial;
use app\models\RawMaterialSearch;
use Yii;
use app\models\RawMaterialEntries;
use app\models\RawMaterialEntriesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;

/**
 * RawMaterialEntriesController implements the CRUD actions for RawMaterialEntries model.
 */
class RawMaterialEntriesController extends Controller
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
     * Lists all RawMaterialEntries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RawMaterialEntriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new RawMaterialEntries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($material_id = null)
    {
        $model = new RawMaterialEntries();

        $model->user_id = Yii::$app->user->id;

        $material = null;
        if($material_id){
            $material = RawMaterial::findOne($material_id);
            $model->raw_material_id = $material->id;
        }
        // Stock increasing and average cost calculation will be done in RawMaterialEntries' model afterSave();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'material' => $material,
        ]);
    }

    /**
     * Lists all RawMaterial models.
     * @return mixed
     */
    public function actionSelectRawMaterial()
    {
        $searchModel = new RawMaterialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('select-raw-material', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing RawMaterialEntries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws UnauthorizedHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $stock = MaterialWarehouses::findOne(['material_id' => $model->raw_material_id, 'warehouse_id' => $model->warehouse_id]);
        if($stock){
            $stock->stock = $stock->stock - $model->quantity;
            if($stock->stock < 0){
                Yii::$app->session->addFlash("error", "No se puede revertir ésta entrada, las cantidad ya no se encuentran en el almacén");
                return $this->redirect(['index']);
            }
            $model->delete();
            // Update average cost
            $stock->material->average_cost = RawMaterial::getAverageCost($stock->material->id);
            $stock->material->save();
            if($stock->save()){
                Yii::$app->session->addFlash("success", "Entrada revertida correctamente. Inventario actualizado");
                return $this->redirect(['index']);
            }
        }
        throw new UnauthorizedHttpException('No es posible revertir la entrada debido a que han pasado más de 8 horas.');
    }

    /**
     * Finds the RawMaterialEntries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RawMaterialEntries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RawMaterialEntries::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
