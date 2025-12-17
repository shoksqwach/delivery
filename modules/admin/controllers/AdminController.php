<?php

namespace app\modules\admin\controllers;

use app\models\Order;
use app\models\OrderItem;
use app\models\Status;
use app\modules\admin\models\OrderSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminController implements the CRUD actions for Order model.
 */
class AdminController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param int $id № заказа
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProviderItems = new ActiveDataProvider([
            'query' => OrderItem::find()
                ->where(["order_id" => $id]),
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProviderItems' => $dataProviderItems,
        ]);
    }

    public function actionChangeStatus($order_id, $alias)
    {
        $model = $this->findModel($order_id);
        $model->status_id = Status::getStatusId($alias);
        if ($model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->redirect('/admin');
    }

    public function actionAppointmentCourier($order_id)
    {
        $model = $this->findModel($order_id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Вы успешно назначили курьера!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('appointment', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id № заказа
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
