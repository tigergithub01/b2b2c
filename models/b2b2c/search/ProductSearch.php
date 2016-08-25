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
            [['id', 'type_id', 'brand_id', 'is_on_sale', 'is_hot', 'audit_status', 'audit_user_id', 'can_return_flag', 'return_days', 'organization_id', 'is_free_shipping', 'give_integral', 'rank_integral', 'integral', 'relative_module', 'bonus', 'product_weight_unit', 'product_group_id'], 'integer'],
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
        $query = Product::find();

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
            'type_id' => $this->type_id,
            'brand_id' => $this->brand_id,
            'market_price' => $this->market_price,
            'sale_price' => $this->sale_price,
            'deposit_amount' => $this->deposit_amount,
            'is_on_sale' => $this->is_on_sale,
            'is_hot' => $this->is_hot,
            'audit_status' => $this->audit_status,
            'audit_user_id' => $this->audit_user_id,
            'audit_date' => $this->audit_date,
            'stock_quantity' => $this->stock_quantity,
            'safety_quantity' => $this->safety_quantity,
            'can_return_flag' => $this->can_return_flag,
            'return_days' => $this->return_days,
            'cost_price' => $this->cost_price,
            'organization_id' => $this->organization_id,
            'is_free_shipping' => $this->is_free_shipping,
            'give_integral' => $this->give_integral,
            'rank_integral' => $this->rank_integral,
            'integral' => $this->integral,
            'relative_module' => $this->relative_module,
            'bonus' => $this->bonus,
            'product_weight' => $this->product_weight,
            'product_weight_unit' => $this->product_weight_unit,
            'product_group_id' => $this->product_group_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'return_desc', $this->return_desc])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'img_url', $this->img_url])
            ->andFilterWhere(['like', 'thumb_url', $this->thumb_url])
            ->andFilterWhere(['like', 'img_original', $this->img_original]);

        return $dataProvider;
    }
}
