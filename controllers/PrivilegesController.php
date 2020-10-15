<?php

namespace app\controllers;

use Yii;
use app\models\Privileges;
use app\models\PrivilegesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PrivilegesController implements the CRUD actions for Privileges model.
 */
class PrivilegesController extends Controller
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
     * Lists all Privileges models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrivilegesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Privileges model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Privileges();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash("success", "Permiso creado con éxito.");
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
            'controllers_and_actions' => $this->getControllersAndActions()
        ]);
    }

    /**
     * Updates an existing Privileges model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash("success", "Permiso modificado con éxito.");
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Privileges model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->addFlash("success", "Permiso eliminado con éxito.");
        return $this->redirect(['index']);
    }

    /**
     * Finds the Privileges model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Privileges the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Privileges::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

    /**
     * Gets a list of controllers' and action's names in order
     * to give suggestions when creating privileges.
     *
     * @return array
     */
    protected function getControllersAndActions()
    {
        $controller_list = [];
        if ($handle = opendir('../controllers')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                    $controller_list[] = $file;
                }
            }
            closedir($handle);
        }
        asort($controller_list);
        $full_list = [];
        foreach ($controller_list as $controller) {
            $handle = fopen('../controllers/' . $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $full_list[strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', substr($controller, 0, -14)))][] = strtolower($display[1]);
                        endif;
                    endif;
                }
            }
            fclose($handle);
        }
        return $full_list;
    }
}
