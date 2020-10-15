<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "ufmx_ord_orders".
 *
 * @property int $id
 * @property string $order_number
 * @property int $status
 * @property int $customer_id
 * @property int $warehouse_id
 * @property int $user_id
 * @property string $creation_timestamp
 * @property string $completion_timestamp
 * @property string $due_date
 * @property string $payment_due_date
 * @property string $calendar_color
 *
 * @property OrderDetails[] $details
 * @property OrderHistory[] $orderHistory
 * @property Customers $customer
 * @property Warehouses $warehouse
 * @property User $user
 * @property Payments[] $payment
 * @property PurchaseOrders[] purchaseOrders
 * @property Shipments[] $shipment
 */
class Orders extends \yii\db\ActiveRecord
{

    const STATUSES = [
        1 => 'Sin iniciar',
        2 => 'A la espera de material',
        3 => 'Listo para iniciar',
        4 => 'En corte',
        5 => 'En producción',
        6 => 'En acabados',
        7 => 'En espera de recolección',
        8 => 'Enviado',
        9 => 'A la espera de pago',
        10 => 'Completado',
    ];

    const NOT_STARTED = 1;
    const WAITING_FOR_MATERIAL = 2;
    const READY_TO_START = 3;
    const ON_CUT = 4;
    const ON_PRODUCTION = 5;
    const ON_FINISHES = 6;
    const WAITING_FOR_PICKUP = 7;
    const SENT = 8;
    const WAITING_FOR_PAYMENT = 9;
    const COMPLETED = 10;

    const SCENARIO_UPDATE_STATUS = 'update-status';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_ord_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'customer_id', 'warehouse_id', 'user_id'], 'integer'],
            [['customer_id', 'warehouse_id', 'user_id', 'due_date'], 'required'],
            [['creation_timestamp', 'completion_timestamp', 'due_date', 'payment_due_date'], 'safe'],
            [['order_number'], 'string', 'max' => 20],
            [['calendar_color'], 'string', 'max' => 10],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::class, 'targetAttribute' => ['customer_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouses::class, 'targetAttribute' => ['warehouse_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['payment_due_date', 'due_date'], 'minDateToday', 'on' => self::SCENARIO_DEFAULT],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE_STATUS] = ['order_number', 'status', 'customer_id', 'warehouse_id', 'user_id'];
        return $scenarios;
    }

    public function minDateToday($attribute)
    {
        $date = strtotime($this->$attribute);

        $today = strtotime(date('Y-m-d'));

        if ($date < $today) {
            $this->addError($attribute, 'La fecha no puede ser anterior a hoy');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_number' => 'Identificador de orden',
            'status' => 'Estatus',
            'customer_id' => 'Cliente',
            'warehouse_id' => 'Almacén',
            'due_date' => 'Fecha de entrega',
            'payment_due_date' => 'Fecha límite de pago',
            'creation_timestamp' => 'Fecha de creación',
            'completion_timestamp' => 'Fecha de terminación',
            'calendar_color' => 'Color del calendario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetails()
    {
        return $this->hasMany(OrderDetails::class, ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistories()
    {
        return $this->hasMany(OrderHistory::class, ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customers::class, ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouses::class, ['id' => 'warehouse_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payments::class, ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrders()
    {
        return $this->hasMany(PurchaseOrders::class, ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShipments()
    {
        return $this->hasMany(Shipments::class, ['order_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if(!$insert && isset($changedAttributes['status'])){
            $this->registerStatusChange($changedAttributes['status']);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Creates a history record for tracking purposes
     * @param $previous_status int
     */
    public function registerStatusChange($previous_status){
        $record = new OrderHistory();
        $record->order_id = $this->id;
        $record->changed_from = $previous_status;
        $record->changed_to = $this->status;
        $record->user_id = Yii::$app->user->id;
        $record->save();
    }

    /**
     * @return string
     */
    public function getNextID(){
        $last = $this->find()->orderBy('id DESC')->one();
        return str_pad($last->id+1, 3, '0', STR_PAD_LEFT)."-".date('y');
    }

    /**
     * @return float|int
     */
    public function getTotalPayment(){
        $total_payment = 0;
        foreach ($this->getPayments() as $payment) {
            /* @var $payment Payments */
            $total_payment += $payment->amount;
        }
        return $total_payment;
    }


    public function getTotal(){
        $total = 0;
        foreach ($this->getDetails() as $detail) {
            /* @var $detail OrderDetails */
            $total += $detail->price;
        }
        return $total;
    }

    /**
     * @return bool
     */
    public function hasEnoughStock(){
        $stock_ready = true;
        foreach($this->getDetails()->all() as $detail){ /* @var $detail \app\models\OrderDetails */
            if($detail->cloth_id) {
                if($detail->cloth->getStock() < $detail->quantity) {
                    $stock_ready = false;
                }
            } else {
                return false;
            }
        }
        return $stock_ready;
    }

    /**
     * @param bool $started Whether the assignment should be initiated or not
     * @return array|\yii\db\ActiveRecord|LineAssignments
     */
    public function findAssignment($started = false){

        foreach ($this->getDetails()->all() as $detail){
            /* @var $detail \app\models\OrderDetails */
            $assignment = LineAssignments::find()->where(['order_detail_id' => $detail->id]);
            if($started === true){
                $assignment->andWhere(['>', 'status', LineAssignments::NOT_STARTED]);
            }

            return $assignment->one();
        }
        return null;
    }

    public function getStatusInfo($status = null){
        $_status = $status ? $status : $this->status;
        $info = [
            'li_class' => '',
            'author' => 'Desconocido',
            'date' => 'No disponible',
            'label' => 'Orden completa',
        ];

        if($_status === self::NOT_STARTED){
            // If an assignment does not exists, then this is the current status
            $info['date'] = $this->fStamp($this->creation_timestamp);
            $info['author'] = $this->user->user;
            $info['li_class'] = 'complete';
            $info['label'] = 'Orden creada';
        }

        if($_status === self::WAITING_FOR_MATERIAL) {
            // If an assignment exists, then this status is completed
            $assignment = $this->findAssignment();
            $_url = ['line-assignments/create', 'order_id' => $this->id];
            // If assignment is created but not ready, send to assignment details
            if($assignment && !$assignment->ready_timestamp){
                $_url = ['line-assignment-details/index', 'assignment_id' => $assignment->id];
            }

            $info['label'] = $this->status === $_status-1 ? Html::a('Esperando asignación', $_url) : 'Esperando asignación';
            if(isset($assignment->ready_timestamp) || $this->status > self::WAITING_FOR_MATERIAL){
                $info['date'] = $this->fStamp($assignment ? $assignment->assigned_timestamp : $this->creation_timestamp);
                $info['author'] = $assignment ? $assignment->user->user : $this->user->user;
                $info['li_class'] = 'complete';
                $info['label'] = 'Asignación lista';
            }
        }

        if($_status === self::READY_TO_START){
            $assignment = $this->findAssignment();
            // If an assignment detail exists, then this status is completed
            $info['label'] = $this->status === $_status-1 ? Html::a('Esperando material', ['line-assignments-details/index', 'assignment_id' => $assignment->id]) : 'Esperando material';
            if($this->status > self::WAITING_FOR_MATERIAL){
                $info['date'] = $this->fStamp($assignment ? $assignment->ready_timestamp : $this->creation_timestamp);
                $info['author'] = $assignment ? $assignment->user->user : $this->user->user;
                $info['li_class'] = 'complete';
                $info['label'] = 'Material listo';
            }
        }

        if($_status === self::ON_PRODUCTION){
            // If an assignment with a CUT, PRODUCTION or ON_FINISHES type exists and it is in progress, then this is the current status
            $info['label'] = 'Esperando operario';
            if($assignment = $this->findAssignment(true)){
                $info['date'] = $this->fStamp($assignment->lineHistories[0]->started_timestamp);
                $info['author'] = $assignment->user->user;
                if($assignment->lineHistories[0]->started_timestamp){
                    $info['label'] =  Html::a('En producción', '#!', ['data' => ['position' => 'bottom', 'tooltip' => 'Consulta abajo para más información'], 'class' => 'tooltipped']);
                }
            }
            if($this->status > self::ON_FINISHES){
                $info['li_class'] = 'complete';
                $info['label'] = 'Producción terminada';
                $info['date'] = $this->fStamp($this->creation_timestamp);
                $info['author'] = $this->user->user;

                if($record = OrderHistory::findOne(['order_id' => $this->id, 'changed_from' => self::ON_PRODUCTION])){
                    $info['date'] = $this->fStamp($record->timestamp);
                    $info['author'] = $record->user->user;
                }
            }
        }

        if($_status === self::WAITING_FOR_PICKUP){
            // If all assignments have been competed but there is no shipment registered, this is the current status
            $info['label'] = 'Esperando envío';
            if(!empty($this->getShipments()->all())){
                $info['li_class'] = 'complete';
                $info['label'] = 'Orden enviada';
            }else if($_status === $this->status){
                $info['label'] = Html::a('Esperando envío', ['shipments/create', 'order_id' => $this->id]);
            }
            if($record = OrderHistory::findOne(['order_id' => $this->id, 'changed_from' => self::WAITING_FOR_PICKUP])){
                $info['date'] = $this->fStamp($record->timestamp);
                $info['author'] = $record->user->user;
            }
        }

        if($_status === self::SENT){
            // If all assignments have been completed and there is a shipment for the order, this is the current status
            $info['label'] = 'Esperando entrega';

            $shipment = Shipments::findOne(['order_id' => $this->id]);
            if($shipment && $shipment->delivered_date){
                $info['li_class'] = 'completed';
                $info['label'] = 'Orden Entregada';
            }
        }

        if($this->status === self::COMPLETED){
            $info['label'] = 'Orden completada';
            $info['li_class'] = 'completed';
            $info['date'] = $this->completion_timestamp;
            $info['author'] = $this->user->user;
        }

        return $info;
    }

    /**
     * @param $tstamp
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function fStamp($tstamp){
        $formatter = Yii::$app->formatter;
        return $formatter->asDate($tstamp, 'dd/MMM/Y')
            ."<br>".
            str_replace(['. ', '.'], '', $formatter->asDate($tstamp, 'hh:mm a'));
    }

    /**
     * @return array
     */
    public function getProgress(){
        $q2 = (new Query())->select([
            'required' => 'SUM(od.quantity)',
        ])->from(['od' => OrderDetails::tableName()])
            ->where(['od.order_id' => $this->id])->one();

        if($q2['required']){
            $q1 = (new Query())->select([
                'fabricated' => 'SUM(lh.quantity)',
            ])
                ->from(['lh' => LineHistory::tableName()])
                ->innerJoin(['la' => LineAssignments::tableName()], 'la.id = lh.assignment_id')
                ->innerJoin(['od' => OrderDetails::tableName()], 'od.id = la.order_detail_id')
                ->where(['od.order_id' => $this->id])->one();
        }



        $progress = [
            'fabricated' => intval($q1['fabricated']),
            'required' => intval($q2['required']),
            'percentage' => $q2['required'] ? round(($q1['fabricated'] / $q2['required']) * 100) : null,
        ];

        return $progress;
    }

    /**
     * @return array
     */
    public function getGridData(){
        $data = $batches = $_items = [];
        $sizes = ArrayHelper::map(Sizes::find()->all(), 'id', 'name');

        $entries = (new Query())->select(['*'])
            ->from(OrderDetails::tableName())
            ->where(['order_id' => $this->id])->groupBy('record_card_id')
            ->all();

        foreach ($entries as $entry){
            $recordCard = RecordCards::findOne($entry['record_card_id']);
            $product = Products::findOne($entry['product_id']);
            $model = $product->model.'-'.$recordCard->model;

            $data[$entry['record_card_id']] = [
                'order_id' => $entry['order_id'],
                'product_id' => $entry['product_id'],
                'model' => $model,
                'description' => $entry['description'],
                'additional_notes' => $entry['additional_notes'],
            ];
        }

        foreach ($data as $record_card_id => $entry) {
            $batches[] = (new Query())->select(['*'])
                ->from(OrderDetails::tableName())
                ->where(['order_id' => $this->id, 'record_card_id' => $record_card_id])
                ->all();
        }

        foreach ($batches as $idx => $batch) {
            foreach ($batch as $item){
                $data[$item['record_card_id']]['sizes'][$sizes[$item['size_id']]] = [
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ];
            }
        }

        return $data;
    }
}
