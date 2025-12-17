<?php

namespace app\modules\courier\controllers;

use app\models\Order;
use app\models\OrderItem;
use app\models\Status;
use app\modules\courier\models\OrderSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CourierController implements the CRUD actions for Order model.
 */
class CourierController extends Controller
{

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
     * @param int $id Номер заказа
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

        return $this->redirect('/courier');
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Номер заказа
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
