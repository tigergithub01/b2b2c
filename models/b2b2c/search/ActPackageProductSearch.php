<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\ActPackageProduct;

/**
 * ActPackageProductSearch represents the model behind the search form about `app\models\b2b2c\ActPackageProduct`.
 */
class ActPackageProductSearch extends ActPackageProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'act_id', 'product_id', 'quantity'], 'integer'],
            [['sale_price', 'package_price'], 'number'],
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
        $query = ActPackageProduct::find()->alias('actProd')
    	->joinWith('act act')
    	->joinWith('product product');

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
            'actProd.id' => $this->id,
            'actProd.act_id' => $this->act_id,
            'actProd.product_id' => $this->product_id,
            'actProd.sale_price' => $this->sale_price,
            'actProd.package_price' => $this->package_price,
            'actProd.quantity' => $this->quantity,
        ]);

        return $dataProvider;
    }
}
