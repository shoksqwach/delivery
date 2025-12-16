<?php

namespace app\modules\admin;

use Yii;
use yii\filters\AccessControl;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    // разрешаем аутентифицированным пользователям
                    [
                        'allow' => true,
                        'controllers' => ['admin/login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        // любая аутентификация
                        'roles' => ['@'],
                        // дополнительная проверка через модель Role
                        'matchCallback' => fn() => Yii::$app->user->identity?->isAdmin ?? false,
                    ],


                    // всё остальное по умолчанию запрещено
                ],

                'denyCallback' => function () {

                    if (Yii::$app->user?->identity) {
                        return Yii::$app->response->redirect('/');
                    }

                    return Yii::$app->response->redirect('/admin/login');
                }
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
