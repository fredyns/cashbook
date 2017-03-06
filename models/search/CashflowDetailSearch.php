<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use fredyns\suite\helpers\StringHelper;
use app\models\CashflowDetail;
use app\models\BudgetItem;
use app\models\Cashflow;
use app\models\MonthlyBudgetItem;

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
            /* filter */
            [
                ['notes'],
                'filter',
                'filter' => function($value) {
                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* safe */
            [['monthlyBudgetItem_id'], 'safe'],
            /* field type */
            [['id'], 'integer'],
            [['flow', 'notes', 'recordStatus'], 'string'],
            [['nominal'], 'number'],
            /* value limitation */
            ['flow', 'in', 'range' => [
                    self::FLOW_DEBIT,
                    self::FLOW_CREDIT,
                ]
            ],
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
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

        $this->recordStatus = static::RECORDSTATUS_ACTIVE;

        return $this->search();
    }

    /**
     * search deleted models
     *
     * @param array   $params
     *
     * @return ActiveDataProvider
     */
    public function searchDeleted($params)
    {
        $this->load($params);

        $this->recordStatus = static::RECORDSTATUS_DELETED;

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
                static::tableName().'.id' => $this->id,
                static::tableName().'.nominal' => $this->nominal,
                static::tableName().'.monthlyBudgetItem_id' => $this->monthlyBudgetItem_id,
                static::tableName().'.flow' => $this->flow,
                static::tableName().'.recordStatus' => $this->recordStatus,
        ]);

        $query
            ->andFilterWhere(['like', static::tableName().'.notes', $this->notes]);

        if (is_numeric($this->cashflow_id)) {
            $query->andFilterWhere([
                static::tableName().'.cashflow_id' => $this->cashflow_id,
            ]);
        } elseif ($this->cashflow_id) {
            $query->andFilterWhere(['like', Cashflow::tableName().'.number', $this->cashflow_id]);
        }

        if (is_numeric($this->budgetItem_id)) {
            $query->andFilterWhere([
                static::tableName().'.budgetItem_id' => $this->budgetItem_id,
            ]);
        } elseif ($this->budgetItem_id) {
            $query->andFilterWhere(['like', BudgetItem::tableName().'.name', $this->budgetItem_id]);
        }

        if (is_numeric($this->monthlyBudgetItem_id)) {
            $query->andFilterWhere([
                static::tableName().'.monthlyBudgetItem_id' => $this->monthlyBudgetItem_id,
            ]);
        } elseif ($this->monthlyBudgetItem_id) {
            $budgetMonth = new \DateTime($this->monthlyBudgetItem_id);

            if ($budgetMonth) {
                $query->andFilterWhere([
                    MonthlyBudgetItem::tableName().'.year' => $budgetMonth->format('Y'),
                    MonthlyBudgetItem::tableName().'.month' => $budgetMonth->format('m'),
                ]);
            }
        }

        return $dataProvider;
    }
}