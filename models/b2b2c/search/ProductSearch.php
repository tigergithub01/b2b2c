<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\Product;

/**
 * ProductSearch represents the model behind the search form about `app\models\b2b2c\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'brand_id', 'is_on_sale', 'is_hot', 'audit_status', 'audit_user_id', 'can_return_flag', 'return_days', 'vip_id', 'is_free_shipping', 'give_integral', 'rank_integral', 'integral', 'relative_module', 'bonus', 'product_weight_unit', 'product_group_id'], 'integer'],
            [['code', 'name', 'description', 'audit_date', 'return_desc', 'keywords', 'img_url', 'thumb_url', 'img_original'], 'safe'],
            [['market_price', 'sale_price', 'deposit_amount', 'stock_quantity', 'safety_quantity', 'cost_price', 'product_weight'], 'number'],
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
        $query = Product::find()->alias('p')
    	->joinWith('type tp')
    	->joinWith('brand bd')
    	->joinWith('vip vip')
    	->joinWith('isOnSale onSale')
    	->joinWith('isHot hot')
    	->joinWith('auditStatus audit')
    	->joinWith('canReturnFlag rt')
        ->joinWith('isFreeShipping free');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'brand.name' => [
        						'asc'  => ['bd.name' => SORT_ASC],
        						'desc' => ['bd.name' => SORT_DESC],
        				],
        				'type.name' => [
        						'asc'  => ['tp.name' => SORT_ASC],
        						'desc' => ['tp.name' => SORT_DESC],
        				],
        				'vip.vip_id' => [
        						'asc'  => ['vip.vip_id' => SORT_ASC],
        						'desc' => ['vip.vip_id' => SORT_DESC],
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
            'p.id' => $this->id,
            'p.type_id' => $this->type_id,
            'p.brand_id' => $this->brand_id,
            'p.market_price' => $this->market_price,
            'p.sale_price' => $this->sale_price,
            'p.deposit_amount' => $this->deposit_amount,
            'p.is_on_sale' => $this->is_on_sale,
            'p.is_hot' => $this->is_hot,
            'p.audit_status' => $this->audit_status,
            'p.audit_user_id' => $this->audit_user_id,
            'p.audit_date' => $this->audit_date,
            'p.stock_quantity' => $this->stock_quantity,
            'p.safety_quantity' => $this->safety_quantity,
            'p.can_return_flag' => $this->can_return_flag,
            'p.return_days' => $this->return_days,
            'p.cost_price' => $this->cost_price,
            'p.vip_id' => $this->vip_id,
            'p.is_free_shipping' => $this->is_free_shipping,
            'p.give_integral' => $this->give_integral,
            'p.rank_integral' => $this->rank_integral,
            'p.integral' => $this->integral,
            'p.relative_module' => $this->relative_module,
            'p.bonus' => $this->bonus,
            'p.product_weight' => $this->product_weight,
            'p.product_weight_unit' => $this->product_weight_unit,
            'p.product_group_id' => $this->product_group_id,
        ]);

        $query->andFilterWhere(['like', 'p.code', $this->code])
            ->andFilterWhere(['like', 'p.name', $this->name])
            ->andFilterWhere(['like', 'p.description', $this->description])
            ->andFilterWhere(['like', 'p.return_desc', $this->return_desc])
            ->andFilterWhere(['like', 'p.keywords', $this->keywords])
            ->andFilterWhere(['like', 'p.img_url', $this->img_url])
            ->andFilterWhere(['like', 'p.thumb_url', $this->thumb_url])
            ->andFilterWhere(['like', 'p.img_original', $this->img_original]);

        return $dataProvider;
    }
}
