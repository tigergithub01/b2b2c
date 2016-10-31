<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipConcern;

/**
 * VipConcernSearch represents the model behind the search form about `app\models\b2b2c\VipConcern`.
 */
class VipConcernSearch extends VipConcern
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vip_id', 'ref_vip_id'], 'integer'],
            [['concern_date'], 'safe'],
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
        $query = VipConcern::find()->alias('vipConcern')
    	->joinWith('vip vip')
    	->joinWith('refVip refVip');

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
        				'refVip.vip_id' => [
        						'asc'  => ['refVip.vip_id' => SORT_ASC],
        						'desc' => ['refVip.vip_id' => SORT_DESC],
        				],
        				'refVip.vip_name' => [
        						'asc'  => ['refVip.vip_name' => SORT_ASC],
        						'desc' => ['refVip.vip_name' => SORT_DESC],
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
            'vipConcern.id' => $this->id,
            'vipConcern.vip_id' => $this->vip_id,
            'vipConcern.ref_vip_id' => $this->ref_vip_id,
            'vipConcern.concern_date' => $this->concern_date,
        ]);
        
        $query->andFilterWhere(['like', 'vip.vip_id', $this->vip_no])
        ->andFilterWhere(['like', 'refVip.vip_id', $this->ref_vip_no]);

        return $dataProvider;
    }
}
