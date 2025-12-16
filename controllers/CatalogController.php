<?php

namespace app\controllers;

use app\models\Product;
use app\models\CatalogSerach;
use app\models\Comment;
use app\models\Feedback;
use app\models\UserActionProduct;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CatalogController implements the CRUD actions for Product model.
 */
class CatalogController extends Controller
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CatalogSerach();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()
                ->with(['user', 'product'])
                ->where(['product_id' => $id]),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $model = new Comment();
        $model->product_id = $id;


        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'model_comment' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUserAction($product_id, $action)
    {
        if ($this->request->isAjax && $this->request->isPost) {
            $model = UserActionProduct::findOne([
                'product_id' => $product_id,
                'user_id' => Yii::$app->user->id
            ]);

            if ($model === null) {
                $model = new UserActionProduct();
                $model->product_id = $product_id;
                $model->user_id = Yii::$app->user->id;
            }

            if ($model->action === null) {
                $model->action = $action;
            } elseif ($model->action == $action) {
                $model->action = null;
            } else {
                return $this->asJson(false);
            }

            return $this->asJson($model->save());
        }

        return $this->asJson(false);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
