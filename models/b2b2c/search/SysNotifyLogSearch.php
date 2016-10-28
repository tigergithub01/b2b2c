<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\SysNotifyLog;

/**
 * SysNotifyLogSearch represents the model behind the search form about `app\models\b2b2c\SysNotifyLog`.
 */
class SysNotifyLogSearch extends SysNotifyLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'notify_id', 'vip_id'], 'integer'],
            [['create_date', 'read_date', 'expiration_time'], 'safe'],
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
        $query = SysNotifyLog::find()->alias('notifyLog')
    	->joinWith('vip vip')
    	->joinWith('notify notify');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'vip.vip_name' => [
        						'asc'  => ['vip.vip_name' => SORT_ASC],
        						'desc' => ['vip.vip_name' => SORT_DESC],
        				],
        				'notify.title' => [
        						'asc'  => ['notify.title' => SORT_ASC],
        						'desc' => ['notify.title' => SORT_DESC],
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
            'notifyLog.id' => $this->id,
            'notifyLog.notify_id' => $this->notify_id,
            'notifyLog.vip_id' => $this->vip_id,
            'notifyLog.create_date' => $this->create_date,
            'notifyLog.read_date' => $this->read_date,
            'notifyLog.expiration_time' => $this->expiration_time,
        ]);

        return $dataProvider;
    }
}
