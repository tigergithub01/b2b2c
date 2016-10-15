<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\Activity;

/**
 * ActivitySearch represents the model behind the search form about `app\models\b2b2c\Activity`.
 */
class ActivitySearch extends Activity
{
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activity_type', 'activity_scope', 'buy_limit_num', 'vip_id', 'audit_status', 'audit_user_id'], 'integer'],
            [['name', 'start_time', 'end_date', 'description', 'img_url', 'thumb_url', 'img_original', 'audit_date'], 'safe'],
            [['package_price', 'deposit_amount'], 'number'],
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
        $query = Activity::find()->alias('act')
    	->joinWith('activityType activityType')
    	->joinWith('vip vip')
    	->joinWith('auditStatus auditStatus')
    	->joinWith('auditUser auditUser')
    	->joinWith('actScopes actScopes');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'activityType.name' => [
        						'asc'  => ['activityType.name' => SORT_ASC],
        						'desc' => ['activityType.name' => SORT_DESC],
        				],
        				'vip.vip_id' => [
        						'asc'  => ['vip.vip_id' => SORT_ASC],
        						'desc' => ['vip.vip_id' => SORT_DESC],
        				],
        				'auditStatus.param_val' => [
        						'asc'  => ['auditStatus.param_val' => SORT_ASC],
        						'desc' => ['auditStatus.param_val' => SORT_DESC],
        				],
        				'actScopes.param_val' => [
        						'asc'  => ['actScopes.param_val' => SORT_ASC],
        						'desc' => ['actScopes.param_val' => SORT_DESC],
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
            'act.id' => $this->id,
            'act.activity_type' => $this->activity_type,
            'act.activity_scope' => $this->activity_scope,
            'act.start_time' => $this->start_time,
            'act.end_date' => $this->end_date,
            'act.package_price' => $this->package_price,
            'act.deposit_amount' => $this->deposit_amount,
            'act.buy_limit_num' => $this->buy_limit_num,
            'act.vip_id' => $this->vip_id,
            'act.audit_status' => $this->audit_status,
            'act.audit_user_id' => $this->audit_user_id,
            'act.audit_date' => $this->audit_date,
        ]);

        $query->andFilterWhere(['like', 'act.name', $this->name])
            ->andFilterWhere(['like', 'act.description', $this->description])
            ->andFilterWhere(['like', 'act.img_url', $this->img_url])
            ->andFilterWhere(['like', 'act.thumb_url', $this->thumb_url])
            ->andFilterWhere(['like', 'act.img_original', $this->img_original])
        	->andFilterWhere(['like', 'vip.vip_id', $this->vip_no]);

        return $dataProvider;
    }
}
