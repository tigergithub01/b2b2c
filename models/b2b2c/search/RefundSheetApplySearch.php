<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\RefundSheetApply;
use app\models\b2b2c\SoSheetVip;

/**
 * RefundSheetApplySearch represents the model behind the search form about `app\models\b2b2c\RefundSheetApply`.
 */
class RefundSheetApplySearch extends RefundSheetApply
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sheet_type_id', 'vip_id', 'order_id', 'status'], 'integer'],
            [['reason', 'apply_date', 'code'], 'safe'],
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
        $query = RefundSheetApply::find()->alias("refundApply")
    	->joinWith("vip vip")
    	->joinWith("order order")
    	->joinWith("status0 stat");
        

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
        				'order.code' => [
        						'asc'  => ['order.code' => SORT_ASC],
        						'desc' => ['order.code' => SORT_DESC],
        				],
        				'status0.param_val' => [
        						'asc'  => ['status0.param_val' => SORT_ASC],
        						'desc' => ['status0.param_val' => SORT_DESC],
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
            'refundApply.id' => $this->id,
            'refundApply.sheet_type_id' => $this->sheet_type_id,
            'refundApply.vip_id' => $this->vip_id,
            'refundApply.order_id' => $this->order_id,
            'refundApply.status' => $this->status,
            'refundApply.apply_date' => $this->apply_date,
        ]);

        $query->andFilterWhere(['like', 'refundApply.reason', $this->reason])
        	->andFilterWhere(['like', 'refundApply.code', $this->code])
        	->andFilterWhere(['like', 'vip.vip_id', $this->vip_no])
        	->andFilterWhere(['like', 'vip.vip_name', $this->vip_name]);
        
        if($this->start_date){
        	$query->andFilterWhere(['>=', 'refundApply.apply_date', date('Y-m-d 00:00:00',strtotime($this->start_date))]);
        }
        
        if($this->end_date){
        	$query->andFilterWhere(['<=', 'refundApply.apply_date', date('Y-m-d 23:59:59',strtotime($this->end_date))]);
        }
        
        //根据商户编号进行过滤
        if($this->merchant_id){
        	$subquery = SoSheetVip::find()->select(['order_id'])->where(['vip_id'=>$this->merchant_id])->column();
        	$query->andFilterWhere(['refundApply.order_id' => $subquery]);
        }

        return $dataProvider;
    }
}
