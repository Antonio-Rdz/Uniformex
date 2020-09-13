<?php

namespace app\controllers;

use app\models\Clothes;
use app\models\ClothesSearch;
use app\models\ClothesWarehouses;
use Yii;
use app\models\ClothEntries;
use app\models\ClothEntriesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;

/**
 * ClothEntriesController implements the CRUD actions for ClothEntries model.
 */
class ClothEntriesController extends Controller
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
     * Lists all ClothEntries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClothEntriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ClothEntries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cloth_id = null)
    {
        $model = new ClothEntries();

        $model->user_id = Yii::$app->user->id;
        $cloth = null;

        // when the user select a cloth, load its details
        if($cloth_id){
            $cloth = Clothes::findOne($cloth_id);
            $model->cloth_id = $cloth->id;
        }

        if ($post = Yii::$app->request->post()) {
            foreach ($post['Sizes'] as $size_id => $size){
                $model = new ClothEntries();
                if( isset($size['qty']) && $size['qty'] != ''){
                    if($size['price']){
                        $model->load($post);

                        $model->size_id = $size_id;
                        $model->quantity = $size['qty'];
                        $model->cost = $size['price'];
                        $model->user_id = Yii::$app->user->id;
                        if(!$model->save()){
                            Yii::$app->session->addFlash("error", "Ocurrió un error al registrar la entrada. El inventario no se vió afectado.");
                            return $this->render('create', [
                                'model' => $model,
                                'cloth' => $cloth,
                                'post' => $post,
                            ]);
                        }
                    } else {
                        Yii::$app->session->addFlash("error", "No se puede registrar la entrada, los precios de algunas tallas no existen.");
                        return $this->render('create', [
                            'model' => $model,
                            'cloth' => $cloth,
                            'post' => $post,
                        ]);
                    }
                }
            }
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
            'cloth' => $cloth,
        ]);
    }

    /**
     * @return string
     */
    public function actionImportCloth(){
        $searchModel = new ClothesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('import-cloth', [
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

        $stock = ClothesWarehouses::findOne(['cloth_id' => $model->cloth_id, 'warehouse_id' => $model->warehouse_id]);
        if($stock){
            $stock->stock = $stock->stock - $model->quantity;
            if($stock->stock < 0){
                Yii::$app->session->addFlash("error", "No se puede revertir ésta entrada, las cantidades ya no se encuentran en el almacén");
                return $this->redirect(['index']);
            }
            $model->delete();
            // Update average cost
            $stock->cloth->average_cost = Clothes::getAverageCost($stock->cloth->id);
            $stock->cloth->save();
            if($stock->save()){
                Yii::$app->session->addFlash("success", "Entrada revertida correctamente. Inventario actualizado");
                return $this->redirect(['index']);
            }
        }
        throw new UnauthorizedHttpException('No es posible eliminar la entrada debido a que han pasado más de 8 horas.');
    }

    /**
     * Finds the ClothEntries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClothEntries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClothEntries::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
