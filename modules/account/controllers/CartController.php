<?php

namespace app\modules\account\controllers;

use app\models\Cart;
use app\models\CartItem;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{

    /**
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $cart = Cart::findOne(['user_id' => Yii::$app->user->id]);


        $dataProviderItems = new ActiveDataProvider([
            'query' => CartItem::find()
                ->where('cart_item.cart_id = cart.id')


                ->innerJoin('cart', 'cart.user_id = ' . Yii::$app->user->id),
        ]);

        return $this->render('index', [
            'cart' => $cart,
            'dataProviderItems' => $dataProviderItems,
        ]);
    }


    public function actionAdd($product_id)
    {
        $model = Cart::findOne(['user_id' => Yii::$app->user->id]) ?? Cart::create();
        $model->addItem($product_id);
        return $this->asJson(true);
    }


    public function actionDec($item_id)
    {
        $model = Cart::findOne(['user_id' => Yii::$app->user->id]);
        $model->addDec($item_id);
        return $this->asJson(true);
    }


    public function actionDelete($item_id)
    {
        $item = CartItem::findOne(['id' => $item_id]);
        if ($item) {
            $cart = Cart::findOne(['id' => $item->cart_id]);
            if ($cart) {
                $cart->amount -= $item->amount;
                $cart->sum -= $item->sum;
                $cart->save();
            }
            $item->delete();
        }
        return $this->asJson(true);
    }

    public function actionClear($id)
    {
        $model = Cart::findOne($id);
        if ($model) {
            $model->delete();
        }
        return true;
    }


    public function actionGetCount()
    {
        return $this->asJson(Cart::getCount());
    }
}
