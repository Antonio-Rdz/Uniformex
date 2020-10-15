<?php

namespace app\controllers;

use Yii;
use app\models\RolePrivileges;
use app\models\RolePrivilegesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RolePrivilegeController implements the CRUD actions for RolePrivileges model.
 */
class RolePrivilegesController extends Controller
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all RolePrivileges models.
     * @return mixed
     */
    public function actionIndex($role_id = null)
    {
        $searchModel = new RolePrivilegesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $role_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'role_id' => $role_id,
        ]);
    }
    /**
     * Creates a new RolePrivileges model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($role_id)
    {
        $model = new RolePrivileges();
        $model->role_id = $role_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Permiso otorgado con éxito');
            return $this->redirect(['index', 'role_id' => $role_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'role_id' => $role_id,
        ]);
    }

    /**
     * Updates an existing RolePrivileges model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RolePrivileges model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $privilege = $this->findModel($id);
        $role_id = $privilege->role_id;
        $privilege->delete();
        Yii::$app->session->addFlash('success', 'Permiso revocado con éxito');
        return $this->redirect(['index', 'role_id' => $role_id]);
    }

    /**
     * Finds the RolePrivileges model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RolePrivileges the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RolePrivileges::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
