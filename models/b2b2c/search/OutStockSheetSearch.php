<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\OutStockSheet;

/**
 * OutStockSheetSearch represents the model behind the search form about `app\models\b2b2c\OutStockSheet`.
 */
class OutStockSheetSearch extends OutStockSheet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sheet_type_id', 'order_id', 'user_id', 'vip_id', 'status', 'delivery_type', 'merchant_id'], 'integer'],
            [['code', 'sheet_date', 'delivery_no'], 'safe'],
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
        $query = OutStockSheet::find();

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
            'sheet_type_id' => $this->sheet_type_id,
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'vip_id' => $this->vip_id,
            'sheet_date' => $this->sheet_date,
            'status' => $this->status,
            'delivery_type' => $this->delivery_type,
            'merchant_id' => $this->merchant_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'delivery_no', $this->delivery_no]);

        return $dataProvider;
    }
}
