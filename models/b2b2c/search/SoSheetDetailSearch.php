<?php

namespace app\models\b2b2c\search;

use app\models\b2b2c\SoSheetDetail;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SoSheetDetailSearch represents the model behind the search form about `app\models\b2b2c\SoSheetDetail`.
 */
class SoSheetDetailSearch extends SoSheetDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'product_id', 'quantity', 'package_id'], 'integer'],
            [['price', 'amount'], 'number'],
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
        $query = SoSheetDetail::find()->alias('soDetail') 
    	->joinWith('order order')
    	->joinWith('package package')
    	->joinWith('product product')
    	->joinWith('order.vip vip')
    	->joinWith('product.vip prod_merchant')
    	->joinWith('package.vip pkg_merchant');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'order.order_date' => [
        						'asc'  => ['order.order_date' => SORT_ASC],
        						'desc' => ['order.order_date' => SORT_DESC],
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
            'soDetail.id' => $this->id,
            'soDetail.order_id' => $this->order_id,
            'soDetail.product_id' => $this->product_id,
            'soDetail.quantity' => $this->quantity,
            'soDetail.price' => $this->price,
            'soDetail.amount' => $this->amount,
            'soDetail.package_id' => $this->package_id,
        ]);
        
        
        //根据会员编号进行过滤
        $query->andFilterWhere(['vip.id'=>$this->vip_id]);
        
        //根据订单起止日期进行过滤
        if($this->start_date){
        	$query->andFilterWhere(['>=', 'order.order_date', date('Y-m-d 00:00:00',strtotime($this->start_date))]);
        }
        
        if($this->end_date){
        	$query->andFilterWhere(['<=', 'order.order_date', date('Y-m-d 23:59:59',strtotime($this->end_date))]);
        }
        
        $query->andFilterWhere(['like', 'order.code', $this->code]);

        return $dataProvider;
    }
}
