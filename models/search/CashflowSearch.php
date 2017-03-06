<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use fredyns\suite\helpers\StringHelper;
use app\models\Cashflow;
use app\models\Account;
use app\models\CashflowType;

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
            /* filter */
            [
                ['number', 'notes'],
                'filter',
                'filter' => function($value) {
                    return StringHelper::plaintextFilter($value);
                },
            ],
            [
                ['cashflowType_id', 'account_id'],
                'filter',
                'filter' => function($value) {
                    return StringHelper::plaintextFilter($value);
                },
                'when' => function ($model, $attribute) {
                    return !is_numeric($model->$attribute);
                },
            ],
            /* field type */
            [['approval', 'notes', 'recordStatus'], 'string'],
            [['number'], 'string', 'max' => 32],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            /* value limitation */
            ['approval', 'in', 'range' => [
                    self::APPROVAL_PENDING,
                    self::APPROVAL_APPROVED,
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
                static::tableName().'.id' => $this->id,
                static::tableName().'.date' => $this->date,
                static::tableName().'.approval' => $this->approval,
                static::tableName().'.recordStatus' => $this->recordStatus,
        ]);

        $query
            ->andFilterWhere(['like', static::tableName().'.number', $this->number])
            ->andFilterWhere(['like', static::tableName().'.notes', $this->notes]);

        if (is_numeric($this->cashflowType_id)) {
            $query->andFilterWhere([
                static::tableName().'.cashflowType_id' => $this->cashflowType_id,
            ]);
        } elseif ($this->cashflowType_id) {
            $query->andFilterWhere(['like', CashflowType::tableName().'.name', $this->cashflowType_id]);
        }

        if (is_numeric($this->account_id)) {
            $query->andFilterWhere([
                static::tableName().'.account_id' => $this->account_id,
            ]);
        } elseif ($this->account_id) {
            $query->andFilterWhere(['like', Account::tableName().'.name', $this->account_id]);
        }

        return $dataProvider;
    }
}