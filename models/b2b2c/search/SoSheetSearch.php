<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\SoSheet;

/**
 * SoSheetSearch represents the model behind the search form about `app\models\b2b2c\SoSheet`.
 */
class SoSheetSearch extends SoSheet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sheet_type_id', 'vip_id', 'order_quantity', 'delivery_type', 'pay_type_id', 'pick_point_id', 'integral', 'order_status', 'delivery_status', 'pay_status', 'country_id', 'province_id', 'city_id', 'district_id', 'invoice_type', 'related_case_id'], 'integer'],
            [['code', 'order_date', 'delivery_date', 'pay_date', 'delivery_no', 'return_date', 'memo', 'message', 'consignee', 'mobile', 'detail_address', 'invoice_header', 'service_date', 'related_service', 'service_style'], 'safe'],
            [['order_amt', 'goods_amt', 'deliver_fee', 'paid_amt', 'integral_money', 'coupon', 'discount', 'return_amt', 'budget_amount'], 'number'],
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
        $query = SoSheet::find();

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
            'vip_id' => $this->vip_id,
            'order_amt' => $this->order_amt,
            'order_quantity' => $this->order_quantity,
            'goods_amt' => $this->goods_amt,
            'deliver_fee' => $this->deliver_fee,
            'order_date' => $this->order_date,
            'delivery_date' => $this->delivery_date,
            'delivery_type' => $this->delivery_type,
            'pay_type_id' => $this->pay_type_id,
            'pay_date' => $this->pay_date,
            'pick_point_id' => $this->pick_point_id,
            'paid_amt' => $this->paid_amt,
            'integral' => $this->integral,
            'integral_money' => $this->integral_money,
            'coupon' => $this->coupon,
            'discount' => $this->discount,
            'return_amt' => $this->return_amt,
            'return_date' => $this->return_date,
            'order_status' => $this->order_status,
            'delivery_status' => $this->delivery_status,
            'pay_status' => $this->pay_status,
            'country_id' => $this->country_id,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'invoice_type' => $this->invoice_type,
            'service_date' => $this->service_date,
            'budget_amount' => $this->budget_amount,
            'related_case_id' => $this->related_case_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'delivery_no', $this->delivery_no])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'consignee', $this->consignee])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'detail_address', $this->detail_address])
            ->andFilterWhere(['like', 'invoice_header', $this->invoice_header])
            ->andFilterWhere(['like', 'related_service', $this->related_service])
            ->andFilterWhere(['like', 'service_style', $this->service_style]);

        return $dataProvider;
    }
}
