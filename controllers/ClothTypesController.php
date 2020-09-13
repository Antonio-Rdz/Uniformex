<?php

namespace app\controllers;

use Yii;
use app\models\ClothTypes;
use app\models\ClothTypesSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClothTypesController implements the CRUD actions for ClothTypes model.
 */
class ClothTypesController extends Controller
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
                    'list' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        // ? any user
                        // @ logged users
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all ClothTypes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClothTypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ClothTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ClothTypes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Tela guardada correctamente');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ClothTypes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Tela guardada correctamente');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ClothTypes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Tela eliminada correctamente');
        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionList(){
        return $this->asJson(ArrayHelper::map(ClothTypes::find()->orderBy('name')->all(), 'id', function($model) {
            return $model['name'].' '.$model['color'];
        }));
    }


    /**
     * @return string|\yii\web\Response
     */
    public function actionForm(){

        $model = new ClothTypes();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return "<tr><td>".
                    $model->name.
                    "<input type='hidden' name='ClothTypes[{$model->id}][name]' class='cloth-input' value='{$model->name}'> </td>
                    <td>".$model->color
                    ."<input type='hidden' name='ClothTypes[{$model->id}][color]' class='cloth-input' value='{$model->color}'> </td>".
                    "<td> <a href='#!' class='remove-cloth-type'><i class='material-icons'>delete</i></a> </td>".
                    "</tr>";
        } else if(!empty($model->errors)){
            $errors = [];
            foreach ($model->errors as $error) {
                $errors[] = $error;
            }
            return $this->asJson($errors);
        } else {
            return $this->renderPartial('_ajax_form', [
                'model' => $model,
            ]);
        }

    }


    /**
     * Finds the ClothTypes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClothTypes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClothTypes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
