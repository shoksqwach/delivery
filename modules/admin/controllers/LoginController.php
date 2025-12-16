<?php

namespace app\modules\admin\controllers;

use app\models\LoginForm;
use Yii;

class LoginController extends \yii\web\Controller
{
    public $layout = "admin-login";

    public function actionIndex()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->isAdmin) {
                Yii::$app->session->setFlash('success', 'Вы успешно авторизовались администратором!');
                return $this->redirect('/admin');
            } else {
                Yii::$app->user->logout();
                return $this->redirect('/');
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
}
