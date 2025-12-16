<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "complaint".
 *
 * @property int $order_id
 * @property string $text
 * @property string $created_at
 *
 * @property Order $order
 */
class Complaint extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'complaint';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'text'], 'required'],
            [['order_id'], 'integer'],
            [['created_at'], 'safe'],
            [['text'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'text' => 'Text',
            'created_at' => 'Created At',
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

}
