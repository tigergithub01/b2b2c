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
        $query = SysOperationLog::find();

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
            'user_id' => $this->user_id,
            'module_id' => $this->module_id,
            'op_date' => $this->op_date,
        ]);

        $query->andFilterWhere(['like', 'op_ip_addr', $this->op_ip_addr])
            ->andFilterWhere(['like', 'op_browser_type', $this->op_browser_type])
            ->andFilterWhere(['like', 'op_url', $this->op_url])
            ->andFilterWhere(['like', 'op_desc', $this->op_desc])
            ->andFilterWhere(['like', 'op_method', $this->op_method])
            ->andFilterWhere(['like', 'op_referrer', $this->op_referrer])
            ->andFilterWhere(['like', 'op_module', $this->op_module])
            ->andFilterWhere(['like', 'op_controller', $this->op_controller])
            ->andFilterWhere(['like', 'op_action', $this->op_action]);

        return $dataProvider;
    }
}
