<?php

namespace app\controllers;

use Yii;
use app\models\UserPrivileges;
use app\models\UserPrivilegesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserPrivilegesController implements the CRUD actions for UserPrivileges model.
 */
class UserPrivilegesController extends Controller
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
     * Lists all UserPrivileges models.
     * @return mixed
     */
    public function actionIndex($user_id = null, $privilege_id = null)
    {
        $searchModel = new UserPrivilegesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $user_id, $privilege_id);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_id' => $user_id,
            'privilege_id' => $privilege_id,
        ]);
    }

    /**
     * Creates a new UserPrivileges model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($user_id)
    {
        $model = new UserPrivileges();
        $model->user_id = $user_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Permiso otorgado con éxito');
            return $this->redirect(['index', 'user_id' => $user_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'user_id' => $user_id
        ]);
    }

    /**
     * Updates an existing UserPrivileges model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Permiso modificado con éxito');
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserPrivileges model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $privilege = $this->findModel($id);
        $user_id = $privilege->user_id;
        $privilege->delete();
        Yii::$app->session->addFlash('success', 'Permiso revocado con éxito');
        return $this->redirect(['index', 'user_id' => $user_id]);
    }

    /**
     * Finds the UserPrivileges model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserPrivileges the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserPrivileges::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
