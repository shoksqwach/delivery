<?php

namespace app\models;

use Yii;
use app\models\CartItem;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int $user_id
 * @property int $amount
 * @property float $sum
 *
 * @property CartItem[] $cartItems
 * @property User $user
 */
class Cart extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'default', 'value' => 0],
            [['sum'], 'default', 'value' => 0.00],
            [['user_id'], 'required'],
            [['user_id', 'amount'], 'integer'],
            [['sum'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'sum' => 'Sum',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id']);
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

    public static function create()
    {
        $model = new static();
        $model->user_id = Yii::$app->user->id;
        $model->save();

        return $model;
    }


    public function addItem($product_id)
    {
        $item = CartItem::findOne(['cart_id' => $this->id, 'product_id' => $product_id]);
        if (!$item) {
            $item = new CartItem();
            $item->cart_id = $this->id;
            $item->product_id = $product_id;
            $item->cost = $item->product->cost;
        }

        // VarDumper::dump($item->attributes, 10, true);
        $item->amount++;
        // VarDumper::dump($item->attributes, 10, true);
        $item->sum += $item->cost;
        $item->save();
        $this->amount++;
        $this->sum += $item->product->cost;
        $this->save();
        // VarDumper::dump($item->attributes, 10, true);
        // die;
    }


    public function addDec($item_id)
    {
        $item = CartItem::findOne(['id' => $item_id]);
        $item->amount--;
        $item->sum -= $item->cost;
        $item->save();

        $this->amount--;
        $this->sum -= $item->cost;
        $this->save();

        if ($item->amount === 0) {
            $item->delete();
        }
    }


    public static function getCount()
    {
        if (Yii::$app->user->isGuest) {
            return 0;
        }
        
        $cart = static::findOne(['user_id' => Yii::$app->user->id]);
        if (!$cart) {
            return 0;
        }
        
        return (int) CartItem::find()
            ->where(['cart_id' => $cart->id])
            ->sum('amount') ?? 0;
    }
}
