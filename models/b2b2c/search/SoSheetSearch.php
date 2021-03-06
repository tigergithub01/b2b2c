<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\SoSheet;
use app\models\b2b2c\SoSheetVip;

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
            [['id', 'vip_id', 'order_quantity', 'delivery_type', 'pay_type_id', 'pick_point_id', 'integral', 'order_status', 'delivery_status', 'pay_status', 'country_id', 'province_id', 'city_id', 'district_id', 'invoice_type', 'quotation_id'], 'integer'],
            [['code', 'order_date', 'delivery_date', 'pay_date', 'delivery_no', 'return_date', 'memo', 'consignee', 'mobile', 'detail_address', 'invoice_header', 'service_date'], 'safe'],
            [['order_amt', 'goods_amt', 'deliver_fee', 'paid_amt', 'integral_money', 'coupon', 'discount', 'return_amt'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return parent::scenarios();
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
        $query = SoSheet::find()->alias("so")
        ->joinWith("vip vip")
    	->joinWith("city city")
    	->joinWith("country country")
    	->joinWith("deliveryStatus deliveryStatus")
    	->joinWith("district district")
    	->joinWith("invoiceType invoiceType")
    	->joinWith("orderStatus orderStatus")
    	->joinWith("payStatus payStatus")
    	->joinWith("province province")
    	->joinWith("deliveryType deliveryType")
    	->joinWith("payType payType")
    	->joinWith("pickPoint pickPoint")
    	->joinWith("quotation quotation");
        
        
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'vip.vip_id' => [
        						'asc'  => ['vip.vip_id' => SORT_ASC],
        						'desc' => ['vip.vip_id' => SORT_DESC],
        				],
        				'vip.vip_name' => [
        						'asc'  => ['vip.vip_name' => SORT_ASC],
        						'desc' => ['vip.vip_name' => SORT_DESC],
        				],
        				'orderStatus.param_val' => [
        						'asc'  => ['orderStatus.param_val' => SORT_ASC],
        						'desc' => ['orderStatus.param_val' => SORT_DESC],
        				],
        				'payStatus.param_val' => [
        						'asc'  => ['payStatus.param_val' => SORT_ASC],
        						'desc' => ['payStatus.param_val' => SORT_DESC],
        				],
        		])
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'so.id' => $this->id,
            'so.vip_id' => $this->vip_id,
            'so.order_amt' => $this->order_amt,
            'so.order_quantity' => $this->order_quantity,
            'so.goods_amt' => $this->goods_amt,
            'so.deliver_fee' => $this->deliver_fee,
            'so.order_date' => $this->order_date,
            'so.delivery_date' => $this->delivery_date,
            'so.delivery_type' => $this->delivery_type,
            'so.pay_type_id' => $this->pay_type_id,
            'so.pay_date' => $this->pay_date,
            'so.pick_point_id' => $this->pick_point_id,
            'so.paid_amt' => $this->paid_amt,
            'so.integral' => $this->integral,
            'so.integral_money' => $this->integral_money,
            'so.coupon' => $this->coupon,
            'so.discount' => $this->discount,
            'so.return_amt' => $this->return_amt,
            'so.return_date' => $this->return_date,
            'so.order_status' => $this->order_status,
            'so.delivery_status' => $this->delivery_status,
            'so.pay_status' => $this->pay_status,
            'so.country_id' => $this->country_id,
            'so.province_id' => $this->province_id,
            'so.city_id' => $this->city_id,
            'so.district_id' => $this->district_id,
            'so.invoice_type' => $this->invoice_type,
            'so.service_date' => $this->service_date,
        	'so.cancel_date' => $this->cancel_date,
        	'so.quotation_id' => $this->quotation_id,
        ]);

        $query->andFilterWhere(['like', 'so.code', $this->code])
            ->andFilterWhere(['like', 'so.delivery_no', $this->delivery_no])
            ->andFilterWhere(['like', 'so.memo', $this->memo])
            ->andFilterWhere(['like', 'so.consignee', $this->consignee])
            ->andFilterWhere(['like', 'so.mobile', $this->mobile])
            ->andFilterWhere(['like', 'so.detail_address', $this->detail_address])
            ->andFilterWhere(['like', 'so.invoice_header', $this->invoice_header])
            ->andFilterWhere(['like', 'so.cancel_reason', $this->cancel_reason])
        	->andFilterWhere(['like', 'vip.vip_id', $this->vip_no])
        	->andFilterWhere(['like', 'vip.vip_name', $this->vip_name]);
        
        if($this->start_date){
        	$query->andFilterWhere(['>=', 'so.order_date', date('Y-m-d 00:00:00',strtotime($this->start_date))]);
        }
        
        if($this->end_date){
        	$query->andFilterWhere(['<=', 'so.order_date', date('Y-m-d 23:59:59',strtotime($this->end_date))]);
        }
        
        
        //根据商户编号进行过滤
        if($this->merchant_id){
        	$subquery = SoSheetVip::find()->select(['order_id'])->where(['vip_id'=>$this->merchant_id])->column();
        	$query->andWhere(['so.id' => $subquery]);
        }
        

        return $dataProvider;
    }
}
