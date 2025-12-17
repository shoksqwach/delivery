<?php

namespace app\modules\courier;

use Yii;
use yii\filters\AccessControl;

/**
 * courier module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\courier\controllers';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => fn() => Yii::$app->user->identity?->isCourier ?? false,
                    ],
                ],
                'denyCallback' => fn() => Yii::$app->response->redirect('/'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
