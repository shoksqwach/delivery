<?php

namespace app\modules\account\controllers;

use app\models\Comment;
use app\models\Feedback;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FeedbackController implements the CRUD actions for Feedback model.
 */
class CommentController extends Controller
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
     * Lists all Feedback models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Feedback model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()
                ->with(['product'])
                ->where(['user_id' => Yii::$app->user->id]),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('view', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Feedback model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionWrite($product_id)
    {
        if (!$model = Comment::findOne(['product_id' => $product_id, 'user_id' => Yii::$app->user->id])) {
            $model = new Comment();
            $model->product_id = $product_id;
        }


        if ($this->request->isPost) {

            if ($model->load($this->request->post())) {
                $model->user_id = Yii::$app->user->id;
                if ($model->save()) {
                    return true;
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionEdit($id)
    {
        if ($model = $this->findModel($id)) {
            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                    $model->updated_at = date("Y-m-d H:i:s");
                    if ($model->save()) {
                        return $this->redirect("view");
                    }
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        return $this->redirect(['view']);
    }

    /**
     * Deletes an existing Feedback model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['view']);
    }

    /**
     * Finds the Feedback model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Feedback the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
