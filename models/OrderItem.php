<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $amount
 * @property float $cost
 * @property float $sum
 *
 * @property Order $order
 * @property Product $product
 */
class OrderItem extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'default', 'value' => 0],
            [['sum'], 'default', 'value' => 0.00],
            [['order_id', 'product_id'], 'required'],
            [['order_id', 'product_id', 'amount'], 'integer'],
            [['cost', 'sum'], 'number'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'amount' => 'Amount',
            'cost' => 'Cost',
            'sum' => 'Sum',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

}
