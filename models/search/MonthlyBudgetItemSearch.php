<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use fredyns\suite\helpers\StringHelper;
use app\models\MonthlyBudgetItem;
use app\models\BudgetItem;

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
            /* filter */
            [
                ['budgetItem_id'],
                'filter',
                'filter' => function($value) {
                    return StringHelper::plaintextFilter($value);
                },
                'when' => function ($model, $attribute) {
                    return !is_numeric($model->$attribute);
                },
            ],
            /* field type */
            [['month'], 'integer', 'min' => 1, 'max' => 12],
            [['openBalance', 'debit', 'credit', 'closingBalance'], 'number'],
            [['recordStatus'], 'string'],
            [['year'], 'date', 'format' => 'php:Y'],
            /* value limitation */
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
                static::tableName().'.id' => $this->id,
                static::tableName().'.year' => $this->year,
                static::tableName().'.month' => $this->month,
                static::tableName().'.openBalance' => $this->openBalance,
                static::tableName().'.debit' => $this->debit,
                static::tableName().'.credit' => $this->credit,
                static::tableName().'.closingBalance' => $this->closingBalance,
                static::tableName().'.recordStatus' => $this->recordStatus,
        ]);

        if (is_numeric($this->budgetItem_id)) {
            $query->andFilterWhere([
                static::tableName().'.budgetItem_id' => $this->budgetItem_id,
            ]);
        } elseif ($this->budgetItem_id) {
            $query->andFilterWhere(['like', BudgetItem::tableName().'.code', $this->budgetItem_id]);
        }

        return $dataProvider;
    }
}