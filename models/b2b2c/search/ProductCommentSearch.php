<?php

namespace app\models\b2b2c\search;

use app\models\b2b2c\ProductComment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductCommentSearch represents the model behind the search form about `app\models\b2b2c\ProductComment`.
 */
class ProductCommentSearch extends ProductComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'vip_id', 'cmt_rank_id', 'status', 'parent_id', 'order_id', 'package_id'], 'integer'],
            [['content', 'comment_date', 'ip_addr'], 'safe'],
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
        $query = ProductComment::find()->alias('pcmt')
    	->joinWith('status0 stat')
    	->joinWith('cmtRank cmtRank')
    	->joinWith('parent parent')
    	->joinWith('vip vip')
    	->joinWith('product prod')
    	->joinWith('order order')
    	->joinWith('package package');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'product.name' => [
        						'asc'  => ['prod.name' => SORT_ASC],
        						'desc' => ['prod.name' => SORT_DESC],
        				],
        				'order.code' => [
        						'asc'  => ['order.code' => SORT_ASC],
        						'desc' => ['order.code' => SORT_DESC],
        				],
        				'package.name' => [
        						'asc'  => ['package.name' => SORT_ASC],
        						'desc' => ['package.name' => SORT_DESC],
        				],
        				'vip.vip_id' => [
        						'asc'  => ['vip.vip_id' => SORT_ASC],
        						'desc' => ['vip.vip_id' => SORT_DESC],
        				],
        				'vip.vip_name' => [
        						'asc'  => ['vip.vip_name' => SORT_ASC],
        						'desc' => ['vip.vip_name' => SORT_DESC],
        				],
        				'cmtRank.param_val' => [
        						'asc'  => ['cmtRank.param_val' => SORT_ASC],
        						'desc' => ['cmtRank.param_val' => SORT_DESC],
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
            'pcmt.id' => $this->id,
            'pcmt.product_id' => $this->product_id,
            'pcmt.vip_id' => $this->vip_id,
            'pcmt.cmt_rank_id' => $this->cmt_rank_id,
            'pcmt.comment_date' => $this->comment_date,
            'pcmt.status' => $this->status,
            'pcmt.parent_id' => $this->parent_id,
        	'pcmt.order_id' => $this->order_id,
        	'pcmt.package_id' => $this->package_id,
        ]);

        $query->andFilterWhere(['like', 'pcmt.content', $this->content])
            ->andFilterWhere(['like', 'pcmt.ip_addr', $this->ip_addr])
        	->andFilterWhere(['like', 'prod.name', $this->product_name])
        	->andFilterWhere(['like', 'vip.vip_id', $this->vip_no]);
       	
//        if($this->merchant_id){
       		//TODO:根据团体服务与产品的商户编号进行查询
       		$query->andFilterWhere(['OR', ['prod.vip_id'=>$this->merchant_id] , ['package.vip_id' =>$this->merchant_id]  ]);
//        }
        	

        return $dataProvider;
    }
}
