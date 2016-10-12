<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipOperationLog;

/**
 * MerchantOperationLogSearch represents the model behind the search form about `app\models\b2b2c\VipOperationLog`.
 */
class MerchantOperationLogSearch extends VipOperationLog
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
        $query = VipOperationLog::find()->where(['op_module' => 'merchant']);

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
            'vip_id' => $this->vip_id,
            'module_id' => $this->module_id,
            'op_date' => $this->op_date,
            'op_app_type_id' => $this->op_app_type_id,
        ]);

        $query->andFilterWhere(['like', 'op_ip_addr', $this->op_ip_addr])
            ->andFilterWhere(['like', 'op_browser_type', $this->op_browser_type])
            ->andFilterWhere(['like', 'op_phone_model', $this->op_phone_model])
            ->andFilterWhere(['like', 'op_url', $this->op_url])
            ->andFilterWhere(['like', 'op_desc', $this->op_desc])
            ->andFilterWhere(['like', 'op_os_type', $this->op_os_type])
            ->andFilterWhere(['like', 'op_method', $this->op_method])
            ->andFilterWhere(['like', 'op_app_ver', $this->op_app_ver])
            ->andFilterWhere(['like', 'op_module', $this->op_module])
            ->andFilterWhere(['like', 'op_controller', $this->op_controller])
            ->andFilterWhere(['like', 'op_action', $this->op_action])
            ->andFilterWhere(['like', 'op_referrer', $this->op_referrer]);

        return $dataProvider;
    }
}
