<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\Quotation;

/**
 * QuotationSearch represents the model behind the search form about `app\models\b2b2c\Quotation`.
 */
class QuotationSearch extends Quotation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vip_id', 'status', 'merchant_id'], 'integer'],
            [['code', 'create_date', 'update_date', 'memo', 'consignee', 'mobile', 'service_date', 'related_service', 'service_style'], 'safe'],
            [['order_amt', 'deposit_amount', 'budget_amount'], 'number'],
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
        $query = Quotation::find()->alias("quot")
    	->joinWith("vip vip")
    	->joinWith("merchant merchant")
    	->joinWith("status0 status0")
    	->joinWith("serviceStyle serviceStyle")
    	->joinWith("order order");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'merchant.vip_name' => [
        						'asc'  => ['merchant.vip_nam' => SORT_ASC],
        						'desc' => ['merchant.vip_nam' => SORT_DESC],
        				],
        				'vip.vip_name' => [
        						'asc'  => ['vip.vip_name' => SORT_ASC],
        						'desc' => ['vip.vip_name' => SORT_DESC],
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
            'quot.id' => $this->id,
            'quot.vip_id' => $this->vip_id,
            'quot.order_amt' => $this->order_amt,
            'quot.deposit_amount' => $this->deposit_amount,
            'quot.create_date' => $this->create_date,
            'quot.update_date' => $this->update_date,
            'quot.status' => $this->status,
            'quot.service_date' => $this->service_date,
            'quot.budget_amount' => $this->budget_amount,
            'quot.merchant_id' => $this->merchant_id,
        ]);

        $query->andFilterWhere(['like', 'quot.code', $this->code])
            ->andFilterWhere(['like', 'quot.memo', $this->memo])
            ->andFilterWhere(['like', 'quot.consignee', $this->consignee])
            ->andFilterWhere(['like', 'quot.mobile', $this->mobile])
            ->andFilterWhere(['like', 'quot.related_service', $this->related_service])
            ->andFilterWhere(['like', 'quot.service_style', $this->service_style])
            ->andFilterWhere(['like', 'vip.vip_name', $this->vip_name]);

        return $dataProvider;
    }
}
