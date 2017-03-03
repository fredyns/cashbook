<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
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
            [['id', 'owner_uid'], 'integer'],
            [['number', 'name', 'currency', 'accountStatus'], 'safe'],
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
            'owner_uid' => $this->owner_uid,
        ]);

        $query
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'accountStatus', $this->accountStatus]);

        return $dataProvider;
    }
}
