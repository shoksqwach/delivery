<?php

namespace app\modules\account\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Favourite;
use Yii;
use yii\helpers\VarDumper;

/**
 * FavouriteSearch represents the model behind the search form of `app\models\Favourite`.
 */
class FavouriteSearch extends Favourite
{

    public string $search_text = "";
    public string $category_title = "";
    public string $product_title = "";

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'product_id'], 'integer'],
            [["search_text", "product_title", "category_title"], "safe"],
        ];
    }

    public function attributeLabels()
    {
        return [
            'search_text' => 'Название товара'
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
        $query = Favourite::find()
            ->joinWith(['product' => fn($q) => $q->joinWith(['category'])]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            "sort" => [
                'attributes' => [
                    // 'age',
                    'product_title' => [
                        'asc' => ['product.title' => SORT_ASC],
                        'desc' => ['product.title' => SORT_DESC],
                        'default' => SORT_ASC,
                        'label' => 'Наименование товара',
                    ],
                    'category_title' => [
                        'asc' => ['category.title' => SORT_ASC],
                        'desc' => ['category.title' => SORT_DESC],
                        'default' => SORT_ASC,
                        'label' => 'Категория товара',
                    ],

                ],
            ]
        ]);

        $this->load($params, $formName);

        // var_dump($this->category_name);
        // die;

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => Yii::$app->user->id,
            'product_id' => $this->product_id,
        ]);


        if ($this->search_text) {
            $query->andWhere([
                'or',
                ["like", "product.title", $this->search_text],
                ["like", "category.title", $this->search_text],
            ]);
        }

        // VarDumper::dump($dataProvider->query->createCommand()->rawSql, 10, true);
        // die;
        return $dataProvider;
    }
}
