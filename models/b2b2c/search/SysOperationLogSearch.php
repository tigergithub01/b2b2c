<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\SysOperationLog;

/**
 * SysOperationLogSearch represents the model behind the search form about `app\models\b2b2c\SysOperationLog`.
 */
class SysOperationLogSearch extends SysOperationLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'module_id'], 'integer'],
            [['op_date', 'op_ip_addr', 'op_browser_type', 'op_url', 'op_desc', 'op_method', 'op_referrer', 'op_module', 'op_controller', 'op_action'], 'safe'],
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
//         $query = SysOperationLog::find();
    	$query = SysOperationLog::find()->alias('log')
    	->joinWith("user user")
    	->joinWith("module module");
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sort
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'user.user_id' => [
        						'asc'  => ['user.user_id' => SORT_ASC],
        						'desc' => ['user.user_id' => SORT_DESC],
        				],
        				'module.name' => [
        						'asc'  => ['module.name' => SORT_ASC],
        						'desc' => ['module.name' => SORT_DESC],
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
            'log.user_id' => $this->user_id,
            'log.module_id' => $this->module_id,
            'log.op_date' => $this->op_date,
        ]);

        $query->andFilterWhere(['like', 'log.op_ip_addr', $this->op_ip_addr])
            ->andFilterWhere(['like', 'log.op_browser_type', $this->op_browser_type])
            ->andFilterWhere(['like', 'log.op_url', $this->op_url])
            ->andFilterWhere(['like', 'log.op_desc', $this->op_desc])
            ->andFilterWhere(['like', 'log.op_method', $this->op_method])
            ->andFilterWhere(['like', 'log.op_referrer', $this->op_referrer])
            ->andFilterWhere(['like', 'log.op_module', $this->op_module])
            ->andFilterWhere(['like', 'log.op_controller', $this->op_controller])
            ->andFilterWhere(['like', 'log.op_action', $this->op_action])
            ->andFilterWhere(['like', 'module.name', $this->module_name])
            ->andFilterWhere(['like', 'user.user_id', $this->user_no])
            ->andFilterWhere(['like', 'user.user_name', $this->user_name]);
        
            
            if($this->start_date){
            	$query->andFilterWhere(['>=', 'log.op_date', date('Y-m-d 00:00:00',strtotime($this->start_date))]);
            }
            
            if($this->end_date){
            	$query->andFilterWhere(['<=', 'log.op_date', date('Y-m-d 23:59:59',strtotime($this->end_date))]);
            }

        return $dataProvider;
    }
}
