<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use fredyns\suite\helpers\StringHelper;
use app\models\CashflowType;

/**
 * CashflowTypeSearch represents the model behind the search form about `app\models\CashflowType`.
 */
class CashflowTypeSearch extends CashflowType
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /* filter */
            [
                ['name'],
                'filter',
                'filter' => function($value) {
                    return StringHelper::plaintextFilter($value);
                },
            ],
            [['recordStatus'], 'string'],
            [['id'], 'integer'],
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
        $query = CashflowType::find();

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
                'recordStatus' => $this->recordStatus,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}