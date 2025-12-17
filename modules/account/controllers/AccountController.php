<?php

namespace app\modules\account\controllers;

use app\models\Assist;
use app\models\Cart;
use app\models\CartItem;
use app\models\Order;
use app\models\OrderItem;
use app\models\Status;
use app\modules\account\models\OrderSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AccountController implements the CRUD actions for Order model.
 */
class AccountController extends Controller
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
            'statuses' => Assist::getColsItems(Status::tableName(), ['title', 'alias']),
            'status_order' => Status::getStatusesAlias(),
        ]);
    }

    /**
     * Displays a single Order model.
     * @param int $id ID
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

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($cart_id)
    {
        $cart = Cart::findOne($cart_id);

        $dataProviderItems = new ActiveDataProvider([
            'query' => CartItem::find()
                ->where("cart_item.cart_id = $cart_id"),
        ]);

        if ($this->request->isPost) {
            if ($orderId = Order::createOrder($cart_id)) {
                return $this->redirect(['view', 'id' => $orderId]);
            }
        }

        return $this->render('create', [
            'cart' => $cart,
            'dataProviderItems' => $dataProviderItems,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionChangeStatus($id, $alias)
    {
        $model = $this->findModel($id);
        $model->status_id = Status::getStatusId($alias);
        if ($model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->redirect('/account');
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
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
