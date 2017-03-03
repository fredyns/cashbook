<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cashflow;

/**
 * CashflowSearch represents the model behind the search form about `app\models\Cashflow`.
 */
class CashflowSearch extends Cashflow
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cashflowType_id', 'account_id', 'approved_at', 'approved_by'], 'integer'],
            [['number', 'date', 'approval', 'notes'], 'safe'],
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
        $query = Cashflow::find();

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
            'cashflowType_id' => $this->cashflowType_id,
            'date' => $this->date,
            'account_id' => $this->account_id,
            'approved_at' => $this->approved_at,
            'approved_by' => $this->approved_by,
        ]);

        $query
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'approval', $this->approval])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
