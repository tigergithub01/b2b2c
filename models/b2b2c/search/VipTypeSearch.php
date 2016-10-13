<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipType;

/**
 * VipTypeSearch represents the model behind the search form about `app\models\b2b2c\VipType`.
 */
class VipTypeSearch extends VipType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'seq_id', 'merchant_flag'], 'integer'],
            [['code', 'name', 'description'], 'safe'],
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
        $query = VipType::find()->alias('vt')
    	->joinWith('merchantFlag merc');

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
            'vt.id' => $this->id,
            'vt.seq_id' => $this->seq_id,
            'vt.merchant_flag' => $this->merchant_flag,
        ]);

        $query->andFilterWhere(['like', 'vt.code', $this->code])
            ->andFilterWhere(['like', 'vt.name', $this->name])
            ->andFilterWhere(['like', 'vt.description', $this->description]);

        return $dataProvider;
    }
}
