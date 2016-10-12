<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipCollect;

/**
 * VipCollectSearch represents the model behind the search form about `app\models\b2b2c\VipCollect`.
 */
class VipCollectSearch extends VipCollect
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vip_id', 'product_id', 'package_id', 'case_id', 'blog_id'], 'integer'],
            [['collect_date'], 'safe'],
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
        $query = VipCollect::find();

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
            'vip_id' => $this->vip_id,
            'product_id' => $this->product_id,
            'package_id' => $this->package_id,
            'case_id' => $this->case_id,
            'blog_id' => $this->blog_id,
            'collect_date' => $this->collect_date,
        ]);

        return $dataProvider;
    }
}
