<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CashflowDetail;

/**
 * CashflowDetailSearch represents the model behind the search form about `app\models\CashflowDetail`.
 */
class CashflowDetailSearch extends CashflowDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cashflow_id', 'budgetItem_id', 'monthlyBudgetItem_id'], 'integer'],
            [['flow', 'notes'], 'safe'],
            [['nominal'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * search models
     *
     * @param array   $params
     *
     * @return ActiveDataProvider
     */
    public function searchIndex($params)
    {
        $this->load($params);


        return $this->search();
    }

    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = CashflowDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere([
            'id' => $this->id,
            'cashflow_id' => $this->cashflow_id,
            'nominal' => $this->nominal,
            'budgetItem_id' => $this->budgetItem_id,
            'monthlyBudgetItem_id' => $this->monthlyBudgetItem_id,
        ]);

        $query
            ->andFilterWhere(['like', 'flow', $this->flow])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
