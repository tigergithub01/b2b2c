<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\RefundSheet;

/**
 * RefundSheetSearch represents the model behind the search form about `app\models\b2b2c\RefundSheet`.
 */
class RefundSheetSearch extends RefundSheet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sheet_type_id', 'refund_apply_id', 'order_id', 'return_id', 'user_id', 'status', 'vip_id', 'merchant_id'], 'integer'],
            [['code', 'sheet_date', 'memo'], 'safe'],
            [['need_return_amt', 'return_amt'], 'number'],
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
        $query = RefundSheet::find();

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
            'refund_apply_id' => $this->refund_apply_id,
            'order_id' => $this->order_id,
            'return_id' => $this->return_id,
            'user_id' => $this->user_id,
            'sheet_date' => $this->sheet_date,
            'need_return_amt' => $this->need_return_amt,
            'return_amt' => $this->return_amt,
            'status' => $this->status,
            'vip_id' => $this->vip_id,
            'merchant_id' => $this->merchant_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'memo', $this->memo]);

        return $dataProvider;
    }
}
