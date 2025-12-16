<?php

namespace app\models;

use Exception;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $created_at
 * @property int $user_id
 * @property int $amount
 * @property float $sum
 * @property int $status_id
 * @property int|null $courier_id
 *
 * @property Complaint[] $complaints
 * @property User $courier
 * @property OrderItem[] $orderItems
 * @property Rating[] $ratings
 * @property Status $status
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['courier_id'], 'default', 'value' => null],
            [['amount'], 'default', 'value' => 0],
            [['sum'], 'default', 'value' => 0.00],
            [['created_at'], 'safe'],
            [['user_id', 'status_id'], 'required'],
            [['user_id', 'amount', 'status_id', 'courier_id'], 'integer'],
            [['sum'], 'number'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['courier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['courier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер заказа',
            'created_at' => 'Дата и время создания заказа',
            'user_id' => 'Клиент',
            'amount' => 'Количество товаров',
            'sum' => 'Сумма заказа',
            'status_id' => 'Статус заказа',
            'courier_id' => 'Курьер',
        ];
    }

    /**
     * Gets query for [[Complaints]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComplaints()
    {
        return $this->hasMany(Complaint::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Courier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourier()
    {
        return $this->hasOne(User::class, ['id' => 'courier_id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Ratings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function createOrder(int $cart_id): bool | int
    {
        $cart = Cart::findOne($cart_id);
        try {
            $order = new static();
            $order->user_id = Yii::$app->user->id;
            $order->amount = $cart->amount;
            $order->sum = $cart->sum;
            $order->status_id = Status::getStatusId('new');
            if ($order->save()) {
                if ($cartItems = CartItem::find()->where(['cart_id' => $cart_id])->all()) {

                    foreach ($cartItems as $item) {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $order->id;
                        $orderItem->load($item->attributes, '');
                        $orderItem->save();
                    }
                    $cart->delete();
                    return $order->id;
                }
            }
        } catch (Exception $e) {
            if (isset($order) && $order->id) {
                $order->delete();
            }
            Yii::debug($e->getMessage());
        }
        return false;
    }
}
