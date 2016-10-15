<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipCollect;

/**
 * VipCollectSearch represents the model behind the search form about `app\models\b2b2c\VipCollect`.
 */
class VipCollectSearch extends VipCollect
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vip_id', 'product_id', 'package_id', 'case_id', 'blog_id'], 'integer'],
            [['collect_date'], 'safe'],
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
        $query = VipCollect::find()->alias('vipCollect')
    	->joinWith('vip vip')
    	->joinWith('package package')
    	->joinWith('case case')
    	->joinWith('product product');

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
        				'product.name' => [
        						'asc'  => ['product.name' => SORT_ASC],
        						'desc' => ['product.name' => SORT_DESC],
        				],
        				'package.name' => [
        						'asc'  => ['package.name' => SORT_ASC],
        						'desc' => ['package.name' => SORT_DESC],
        				],
        				'case.name' => [
        						'asc'  => ['case.name' => SORT_ASC],
        						'desc' => ['case.name' => SORT_DESC],
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
            'vipCollect.id' => $this->id,
            'vipCollect.vip_id' => $this->vip_id,
            'vipCollect.product_id' => $this->product_id,
            'vipCollect.package_id' => $this->package_id,
            'vipCollect.case_id' => $this->case_id,
            'vipCollect.blog_id' => $this->blog_id,
            'vipCollect.collect_date' => $this->collect_date,
        ]);
        
        $query->andFilterWhere(['like', 'product.name', $this->product_name])
        ->andFilterWhere(['like', 'vip.vip_id', $this->vip_no])
        ->andFilterWhere(['like', 'package.name', $this->package_name])
        ->andFilterWhere(['like', 'case.name', $this->case_name]);

        return $dataProvider;
    }
}
