<?php

namespace app\controllers;

use app\models\LineHistory;
use app\models\Orders;
use app\models\OrdersSearch;
use app\models\ProductionLines;
use Yii;
use app\models\LineAssignments;
use app\models\LineAssignmentsSearch;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LineAssignmentsController implements the CRUD actions for LineAssignments model.
 */
class LineAssignmentsController extends Controller
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
                    'cancel' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all LineAssignments models.
     * @return mixed
     */
    public function actionIndex($order_id = null)
    {
        $searchModel = new LineAssignmentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $order_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $status
     * @return string
     */
    public function actionAssigned($status = 0){

        $lines = ProductionLines::find()->where(['user_id' => Yii::$app->user->id])->all();
        $_assignments = $assignments = [];
        foreach ($lines as $line){
            $_assignments[] = LineAssignments::find()->where(['production_line_id' => $line->id, 'status' => $status])->all();
        }

        // format assignments array
        foreach ($_assignments as $assignment) {
            foreach ($assignment as $item) {
                /* @var $item LineAssignments */
                $assignments[ $item->orderDetail->order->order_number][] = $item;
            }
        }
        return $this->render('assigned', [
            'assignments' => $assignments,
            '_status' => $status
        ]);
    }

    /**
     * Displays a single LineAssignments model and its progress.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionProgress($id)
    {
        $assignment =  $this->findModel($id);
        $entries = LineHistory::find()->where(['assignment_id' => $assignment->id])->orderBy(['started_timestamp' => SORT_DESC])->all();

        return $this->render('progress', [
            'assignment' => $assignment,
            'entries' => $entries,
        ]);
    }

    /**
     * Creates a new LineAssignments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $order_id int|null
     * @return mixed
     */
    public function actionCreate($order_id = null)
    {
        $model = new LineAssignments();
        $model->created_by = Yii::$app->user->id;

        $items = 0;

        if ($post = Yii::$app->request->post()) {
            foreach ($post as $key => $data){
                if(strpos($key, 'assign') !== false){
                    $model = new LineAssignments();
                    $model->created_by = Yii::$app->user->id;

                    $form = $post['LineAssignments'];
                    $model->order_detail_id = $data;
                    // Set the data
                    $model->setAttributes($form);
                    // Get the user currently assigned to the selected line
                    $model->user_id = $model->productionLine->user_id;
                    $model->save();
                    $items++;
                }
            }
            // Get the order
            $order = $model->orderDetail->order;
            // Set scenario to not check for dates
            $order->scenario = Orders::SCENARIO_UPDATE_STATUS;
            // Set the order status as 'waiting for raw material'
            $order->status = Orders::WAITING_FOR_MATERIAL;

            if($order->save()) {
                if ($items > 1) {
                    Yii::$app->session->addFlash('success', 'Asignaciones creadas con éxito. Por favor añade los materiales a utilizar.');
                    return $this->redirect(['line-assignments/index', 'order_id' => $order->id]);
                }
                Yii::$app->session->addFlash('success', 'Asignación creada con éxito. Por favor añade los materiales a utilizar.');
                return $this->redirect(['line-assignment-details/create', 'assignment_id' => $model->id]);
            }
            Yii::$app->session->addFlash('error', 'No se puede(n) crear la(s) asignación(es), parece que ya existen asignación(es) en progreso.');
            return $this->redirect(['line-assignments/create', 'order_id' => $order_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'order' => Orders::findOne($order_id)
        ]);
    }


    /**
     * @return string
     */
    public function actionChooseItem(){
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('choose-item', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $assignment_id int
     * @return \yii\web\Response
     */
    public function actionSetReady($assignment_id){
        $model = LineAssignments::findOne($assignment_id);
        // Set scenario to not verify dates
        $model->orderDetail->order->scenario = Orders::SCENARIO_UPDATE_STATUS;

        $model->orderDetail->order->status = Orders::READY_TO_START;
        $model->ready_timestamp = new Expression('NOW()');
        if($model->orderDetail->order->save() && $model->save()){
            Yii::$app->session->addFlash('success', 'Asignación marcada como lista, ya se puede iniciar la producción');
        }

        return $this->redirect(['index']);
    }

    /**
     * Updates an existing LineAssignments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->status == ProductionLines::WAITING){

            }
            // Get the user currently assigned to the selected line
            $line = ProductionLines::findOne($model->production_line_id);
            $model->user_id = $line->user_id;
            $model->save();
            Yii::$app->session->addFlash('success', 'Asignación editada con éxito.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionCancel($id){
        $model = $this->findModel($id);
        $model->status = LineAssignments::CANCELED;
        // Only allow to cancel and assignment if it hasn't started yet
        if($model->getProgress()['fabricated'] === 0 && $model->save()){
            Yii::$app->session->addFlash('success', 'Asignación cancelada correctamente');
        }
    }

    /**
     * Finds the LineAssignments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LineAssignments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LineAssignments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
