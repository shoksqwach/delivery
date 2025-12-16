<?php

namespace app\modules\admin\controllers;

use app\models\User;
use Yii;

class RbacController extends \yii\web\Controller
{
    public function actionIndex()
    {
        // RBAC через таблицы auth_* отключён.
        // Экшен оставлен заглушкой, чтобы не вызывать логику, зависящую от миграционных таблиц.
        return $this->renderContent('RBAC отключён в текущем проекте.');
    }
}
