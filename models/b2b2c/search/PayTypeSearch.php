<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\PayType;

/**
 * PayTypeSearch represents the model behind the search form about `app\models\b2b2c\PayType`.
 */
class PayTypeSearch extends PayType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tpl_id', 'status', 'organization_id'], 'integer'],
            [['name', 'description', 'configure'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PayType::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tpl_id' => $this->tpl_id,
            'status' => $this->status,
            'organization_id' => $this->organization_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'configure', $this->configure]);

        return $dataProvider;
    }
}
