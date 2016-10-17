<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\SysNotify;

/**
 * SysNotifySearch represents the model behind the search form about `app\models\b2b2c\SysNotify`.
 */
class SysNotifySearch extends SysNotify
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'notify_type', 'vip_id', 'issue_user_id', 'send_extend', 'status', 'is_sent'], 'integer'],
            [['title', 'issue_date', 'content', 'sent_time'], 'safe'],
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
        $query = SysNotify::find()->alias("sysNotify")
    	->joinWith("isSent isSent")
    	->joinWith("sendExtend sendExtend")
    	->joinWith("issueUser issueUser")
    	->joinWith("status0 stat")
    	->joinWith("notifyType notifyType")
    	->joinWith("vip vip");

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
            'sysNotify.id' => $this->id,
            'sysNotify.notify_type' => $this->notify_type,
            'sysNotify.issue_date' => $this->issue_date,
            'sysNotify.vip_id' => $this->vip_id,
            'sysNotify.issue_user_id' => $this->issue_user_id,
            'sysNotify.send_extend' => $this->send_extend,
            'sysNotify.status' => $this->status,
            'sysNotify.is_sent' => $this->is_sent,
            'sysNotify.sent_time' => $this->sent_time,
        ]);

        $query->andFilterWhere(['like', 'sysNotify.title', $this->title])
            ->andFilterWhere(['like', 'sysNotify.content', $this->content]);

        return $dataProvider;
    }
}
