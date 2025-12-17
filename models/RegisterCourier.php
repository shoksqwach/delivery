<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * ContactForm is the model behind the contact form.
 */
class RegisterCourier extends Model
{
    public $name;
    public $surname;
    public $patronymic;
    public $email;
    public $login;
    public $password;
    public $phone;
    public $password_repeat;
    public $rules;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'password', 'phone', 'password_repeat'], 'required'],
            [['name', 'surname', 'patronymic', 'login', 'email', 'password', 'phone'], 'string', 'max' => 255],
            [['login'], 'unique', 'targetClass' => User::class],
            ['rules', 'boolean'],
            ['rules', 'required', 'requiredValue' => 1, 'message' => 'Заполните согласие с правилами регистрации'],
            ['email', 'email'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['phone', 'match', 'pattern' => '/^\+7\([\d]{3}\)-[\d]{3}-[\d]{2}-[\d]{2}$/', 'message' => 'телефон (формат: +7(XXX)-XXX-XX-XX)'],
            [['name', 'surname', 'patronymic'], 'match', 'pattern' => '/^[а-яё\s-]+$/iu', 'message' => 'Это поле должно содержать только кириллицу, тире и пробелы'],
            ['login', 'match', 'pattern' => '/^[a-z\d-]+$/iu', 'message' => 'Поле логин должно содержать только латиницу, тире и цифры'],
            ['password', 'match', 'pattern' => '/^[a-z\d]+$/iu', 'message' => 'Поле пароль должно содержать только латиницу и цифры'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'login' => 'Логин',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'phone' => 'Телефон',
            'rules' => 'Согласие с правилами регистрации',
            'password_repeat' => 'Повтор пароля',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function update(): User | bool
    {
        if ($this->validate()) {
            $user = new User();
            $user->load($this->attributes, '');
            $user->password = Yii::$app->security->generatePasswordHash($user->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->role_id = Role::getRoleId('courier');
            if (!$user->save()) {
                VarDumper::dump($user->errors);
                VarDumper::dump($user->attributes);
            }

            return $user;
        }
        return false;
    }
}
