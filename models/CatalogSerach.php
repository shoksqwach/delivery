<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;
use Yii;
use yii\helpers\VarDumper;

/**
 * CatalogSerach represents the model behind the search form of `app\models\Product`.
 */
class CatalogSerach extends Product
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'amount', 'category_id'], 'integer'],
            [['description', 'title'], 'safe'],
            [['cost'], 'number'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Категория',
            'title' => 'Наименование',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Product::find()
            ->select("product.*, like.like_count, dislike.dislike_count")
            ->where(['>', 'amount', 0])
            ->with([
                'productImage',
                'category',
                // `favourites`,
            ])
            ->leftJoin(
                ["like" => "(SELECT COUNT(*) AS like_count, product_id
                                        FROM `user_action_product`
                                        WHERE `action` = 1
                                        GROUP BY product_id)"],
                "like.product_id = product.id"
            )
            ->leftJoin(
                ["dislike" => "(SELECT COUNT(*) AS dislike_count, product_id
                                        FROM `user_action_product`
                                        WHERE `action` = 0
                                        GROUP BY product_id)"],
                "dislike.product_id = product.id"
            );

        if (Yii::$app->user?->identity?->isClient) {

            $query
                ->with([
                    'favourites' => function ($query) {
                        $query->andWhere(['user_id' => Yii::$app->user?->id]);
                    },
                ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cost' => $this->cost,
            'amount' => $this->amount,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
