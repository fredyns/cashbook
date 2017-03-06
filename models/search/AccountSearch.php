<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use fredyns\suite\helpers\StringHelper;
use app\models\Account;

/**
 * AccountSearch represents the model behind the search form about `app\models\Account`.
 */
class AccountSearch extends Account
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /* filter */
            [
                ['cif', 'number', 'name', 'currency'],
                'filter',
                'filter' => function($value) {
                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* field type */
            [['id'], 'integer'],
            [['accountStatus', 'recordStatus'], 'string'],
            /* value limitation */
            ['accountStatus', 'in', 'range' => [
                    self::ACCOUNTSTATUS_ACTIVE,
                    self::ACCOUNTSTATUS_SUSPENDED,
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
        $query = Account::find();

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
                'accountStatus' => $this->accountStatus,
                'recordStatus' => $this->recordStatus,
        ]);

        $query
            ->andFilterWhere(['like', 'cif', $this->cif])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'currency', $this->currency]);

        return $dataProvider;
    }
}