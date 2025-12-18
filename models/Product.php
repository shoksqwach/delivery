<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $description
 * @property string $title
 * @property float $cost
 * @property int $amount
 * @property int $category_id
 *
 * @property CartItem[] $cartItems
 * @property Category $category
 * @property Comment[] $comments
 * @property Favourite[] $favourites
 * @property OrderItem[] $orderItems
 * @property ProductImage[] $productImages
 * @property UserActionProduct[] $userActionProducts
 */
class Product extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $fileName;
    public $like_count;
    public $dislike_count;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['cost'], 'default', 'value' => 0.00],
            [['amount'], 'default', 'value' => 0],
            [['description'], 'string'],
            [['title', 'category_id'], 'required'],
            [['cost'], 'number'],
            [['amount', 'category_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'description' => 'Текст товара',
            'title' => 'Название товара',
            'cost' => 'Цена',
            'amount' => 'Количество',
            'category_id' => 'Категория',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Favourites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Favourite::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImage()
    {
        return $this->hasOne(ProductImage::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[UserActionProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserActionProducts()
    {
        return $this->hasMany(UserActionProduct::class, ['product_id' => 'id']);
    }

    public function upload()
    {
        if ($this->validate()) {
            $fileName = Yii::$app->security->generateRandomString()
                . '_'
                . time()
                . $this->imageFile->extension;
            $this->fileName = $fileName;
            $this->imageFile->saveAs('img/' . $fileName);
            return true;
        } else {
            return false;
        }
    }
}
