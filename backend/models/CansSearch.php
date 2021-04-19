<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cans;

/**
 * CansSearch represents the model behind the search form of `backend\models\Cans`.
 */
class CansSearch extends Cans
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['canId', 'productId', 'amount'], 'integer'],
            [['type', 'canImage'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Cans::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'canId' => $this->canId,
            'productId' => $this->productId,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'canImage', $this->canImage]);

        return $dataProvider;
    }
}
