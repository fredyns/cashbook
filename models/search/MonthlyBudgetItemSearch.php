<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MonthlyBudgetItem;

/**
 * MonthlyBudgetItemSearch represents the model behind the search form about `app\models\MonthlyBudgetItem`.
 */
class MonthlyBudgetItemSearch extends MonthlyBudgetItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'month', 'budgetItem_id'], 'integer'],
            [['year'], 'safe'],
            [['openBalance', 'debit', 'credit', 'closingBalance'], 'number'],
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
        $query = MonthlyBudgetItem::find();

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
            'year' => $this->year,
            'month' => $this->month,
            'budgetItem_id' => $this->budgetItem_id,
            'openBalance' => $this->openBalance,
            'debit' => $this->debit,
            'credit' => $this->credit,
            'closingBalance' => $this->closingBalance,
        ]);

        return $dataProvider;
    }
}
