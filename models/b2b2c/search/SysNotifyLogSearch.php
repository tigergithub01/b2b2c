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
        $query = SysNotifyLog::find();

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
            'notify_id' => $this->notify_id,
            'vip_id' => $this->vip_id,
            'create_date' => $this->create_date,
            'read_date' => $this->read_date,
            'expiration_time' => $this->expiration_time,
        ]);

        return $dataProvider;
    }
}
