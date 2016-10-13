<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipOperationLog;

/**
 * VipOperationLogSearch represents the model behind the search form about `app\models\b2b2c\VipOperationLog`.
 */
class VipOperationLogSearch extends VipOperationLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vip_id', 'module_id', 'op_app_type_id'], 'integer'],
            [['op_date', 'op_ip_addr', 'op_browser_type', 'op_phone_model', 'op_url', 'op_desc', 'op_os_type', 'op_method', 'op_app_ver', 'op_module', 'op_controller', 'op_action', 'op_referrer'], 'safe'],
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
        $query = VipOperationLog::find()->alias('log')
    	->joinWith('module mod')
    	->joinWith('vip vip')
        ->where(['log.op_module' => 'vip']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'module.name' => [
        						'asc'  => ['mod.name' => SORT_ASC],
        						'desc' => ['mod.name' => SORT_DESC],
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
            'log.id' => $this->id,
            'log.vip_id' => $this->vip_id,
            'log.module_id' => $this->module_id,
            'log.op_date' => $this->op_date,
            'log.op_app_type_id' => $this->op_app_type_id,
        ]);

        $query->andFilterWhere(['like', 'log.op_ip_addr', $this->op_ip_addr])
            ->andFilterWhere(['like', 'log.op_browser_type', $this->op_browser_type])
            ->andFilterWhere(['like', 'log.op_phone_model', $this->op_phone_model])
            ->andFilterWhere(['like', 'log.op_url', $this->op_url])
            ->andFilterWhere(['like', 'log.op_desc', $this->op_desc])
            ->andFilterWhere(['like', 'log.op_os_type', $this->op_os_type])
            ->andFilterWhere(['like', 'log.op_method', $this->op_method])
            ->andFilterWhere(['like', 'log.op_app_ver', $this->op_app_ver])
            ->andFilterWhere(['like', 'log.op_module', $this->op_module])
            ->andFilterWhere(['like', 'log.op_controller', $this->op_controller])
            ->andFilterWhere(['like', 'log.op_action', $this->op_action])
            ->andFilterWhere(['like', 'log.op_referrer', $this->op_referrer])
        	->andFilterWhere(['like', 'mod.name', $this->module_name])
        	->andFilterWhere(['like', 'vip.vip_id', $this->vip_name]);

        return $dataProvider;
    }
}
