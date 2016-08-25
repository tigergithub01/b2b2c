<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\SheetType;

/**
 * SheetTypeSearch represents the model behind the search form about `app\models\b2b2c\SheetType`.
 */
class SheetTypeSearch extends SheetType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'seq_length', 'cur_seq'], 'integer'],
            [['code', 'name', 'prefix', 'date_format', 'sep'], 'safe'],
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
        $query = SheetType::find();

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
            'seq_length' => $this->seq_length,
            'cur_seq' => $this->cur_seq,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'prefix', $this->prefix])
            ->andFilterWhere(['like', 'date_format', $this->date_format])
            ->andFilterWhere(['like', 'sep', $this->sep]);

        return $dataProvider;
    }
}
