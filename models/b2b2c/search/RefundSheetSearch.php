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
        $query = RefundSheet::find()->alias("refundSheet")
    	->joinWith("merchant merchant")
    	->joinWith("order order")
    	->joinWith("return return")
    	->joinWith("refundApply refundApply")
    	->joinWith("user user")
    	->joinWith("status0 stat")
    	->joinWith("vip vip");

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
        				'merchant.vip_id' => [
        						'asc'  => ['merchant.vip_id' => SORT_ASC],
        						'desc' => ['merchant.vip_id' => SORT_DESC],
        				],
        				'order.code' => [
        						'asc'  => ['order.code' => SORT_ASC],
        						'desc' => ['order.code' => SORT_DESC],
        				],
        				'return.code' => [
        						'asc'  => ['return.code' => SORT_ASC],
        						'desc' => ['return.code' => SORT_DESC],
        				],
        				'refundApply.code' => [
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
            'refundSheet.id' => $this->id,
            'refundSheet.sheet_type_id' => $this->sheet_type_id,
            'refundSheet.refund_apply_id' => $this->refund_apply_id,
            'refundSheet.order_id' => $this->order_id,
            'refundSheet.return_id' => $this->return_id,
            'refundSheet.user_id' => $this->user_id,
            'refundSheet.sheet_date' => $this->sheet_date,
            'refundSheet.need_return_amt' => $this->need_return_amt,
            'refundSheet.return_amt' => $this->return_amt,
            'refundSheet.status' => $this->status,
            'refundSheet.vip_id' => $this->vip_id,
            'refundSheet.merchant_id' => $this->merchant_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'memo', $this->memo]);

        return $dataProvider;
    }
}
