<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property string $login
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property int $role_id
 * @property string $auth_key
 *
 * @property Cart[] $carts
 * @property Comment[] $comments
 * @property Favourite[] $favourites
 * @property Order[] $orders
 * @property Order[] $orders0
 * @property Role $role
 * @property UserActionProduct[] $userActionProducts
 */
class User extends ActiveRecord implements IdentityInterface
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['patronymic'], 'default', 'value' => null],
            [['name', 'surname', 'login', 'email', 'password', 'phone', 'role_id', 'auth_key'], 'required'],
            [['role_id'], 'integer'],
            [['name', 'surname', 'patronymic', 'login', 'email', 'password', 'phone', 'auth_key'], 'string', 'max' => 255],
            [['login'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'patronymic' => 'Patronymic',
            'login' => 'Login',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone',
            'role_id' => 'Role ID',
            'auth_key' => 'Auth Key',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Favourites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Favourite::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Orders0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders0()
    {
        return $this->hasMany(Order::class, ['courier_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * Gets query for [[UserActionProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserActionProducts()
    {
        return $this->hasMany(UserActionProduct::class, ['user_id' => 'id']);
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findByUsername($login): User | null
    {
        return self::findOne(['login' => $login]);
    }

    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }


    public function getIsAdmin()
    {
        // Проверка через связанную модель Role (title = 'admin')
        return $this->role->title === 'admin';
    }

    public function getIsClient()
    {
        // Проверка через связанную модель Role (title = 'client')
        return $this->role->title === 'client';
    }
}
