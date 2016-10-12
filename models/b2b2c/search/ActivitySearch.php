<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\Activity;

/**
 * ActivitySearch represents the model behind the search form about `app\models\b2b2c\Activity`.
 */
class ActivitySearch extends Activity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activity_type', 'activity_scope', 'buy_limit_num', 'organization_id'], 'integer'],
            [['name', 'start_time', 'end_date', 'description'], 'safe'],
            [['package_price', 'deposit_amount'], 'number'],
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
        $query = Activity::find();

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
            'activity_type' => $this->activity_type,
            'activity_scope' => $this->activity_scope,
            'start_time' => $this->start_time,
            'end_date' => $this->end_date,
            'package_price' => $this->package_price,
            'deposit_amount' => $this->deposit_amount,
            'buy_limit_num' => $this->buy_limit_num,
            'organization_id' => $this->organization_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
