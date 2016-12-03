<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipCart;

/**
 * VipCartSearch represents the model behind the search form about `app\models\b2b2c\VipCart`.
 */
class VipCartSearch extends VipCart
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vip_id', 'product_id', 'package_id', 'quantity', 'checked'], 'integer'],
            [['price'], 'number'],
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
        $query = VipCart::find();

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
            'quantity' => $this->quantity,
            'price' => $this->price,
            'checked' => $this->checked,
        ]);

        return $dataProvider;
    }
}
