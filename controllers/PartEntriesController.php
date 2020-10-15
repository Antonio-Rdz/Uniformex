<?php

namespace app\controllers;

use app\models\ClothesSearch;
use app\models\Parts;
use app\models\PartsSearch;
use app\models\PartWarehouses;
use Yii;
use app\models\PartEntries;
use app\models\PartEntriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;

/**
 * PartEntriesController implements the CRUD actions for PartEntries model.
 */
class PartEntriesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PartEntries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PartEntriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PartEntries model.
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
     * Creates a new PartEntries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($part_id = null)
    {
        $model = new PartEntries();
        $part = null;
        $model->user_id = Yii::$app->user->id;
        // when the user select a part, load its details
        if($part_id){
            $part = Parts::findOne($part_id);
            $model->part_id = $part->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'part' => $part,
            ]);
        }
    }

    /**
     * @return string
     */
    public function actionImportPart(){
        $searchModel = new PartsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('import-part', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing ClothEntries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws UnauthorizedHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $stock = PartWarehouses::findOne(['cloth_id' => $model->part_id, 'warehouse_id' => $model->warehouse_id]);
        if($stock){
            $stock->stock = $stock->stock - $model->quantity;
            if($stock->stock < 0){
                Yii::$app->session->addFlash("error", "No se puede revertir ésta entrada, las cantidades ya no se encuentran en el almacén");
                return $this->redirect(['index']);
            }
            if($model->delete() && $stock->save()){
                Yii::$app->session->addFlash("success", "Entrada revertida correctamente. Inventario actualizado");
                return $this->redirect(['index']);
            }
        }
        throw new UnauthorizedHttpException('No es posible eliminar la entrada debido a que han pasado más de 8 horas.');
    }

    /**
     * Finds the PartEntries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PartEntries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PartEntries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
