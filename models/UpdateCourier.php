<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * ContactForm is the model behind the contact form.
 */
class UpdateCourier extends Model
{
    public $name;
    public $surname;
    public $patronymic;
    public $email;
    public $login;
    public $phone;
    public $password;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'phone'], 'required'],
            [['name', 'surname', 'patronymic', 'login', 'email', 'password', 'phone'], 'string', 'max' => 255],
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^\+7\([\d]{3}\)-[\d]{3}-[\d]{2}-[\d]{2}$/', 'message' => 'телефон (формат: +7(XXX)-XXX-XX-XX)'],
            [['name', 'surname', 'patronymic'], 'match', 'pattern' => '/^[а-яё\s-]+$/iu', 'message' => 'Это поле должно содержать только кириллицу, тире и пробелы'],
            ['login', 'match', 'pattern' => '/^[a-z\d-]+$/iu', 'message' => 'Поле логин должно содержать только латиницу, тире и цифры'],
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
            'phone' => 'Телефон',
        ];
    }
}
