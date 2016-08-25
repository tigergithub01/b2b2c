<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\Vip;

/**
 * VipSearch represents the model behind the search form about `app\models\b2b2c\Vip`.
 */
class VipSearch extends Vip
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'mobile_verify_flag', 'email_verify_flag', 'status', 'rank_id'], 'integer'],
            [['vip_id', 'vip_name', 'last_login_date', 'password', 'mobile', 'email', 'register_date'], 'safe'],
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
        $query = Vip::find();

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
            'last_login_date' => $this->last_login_date,
            'parent_id' => $this->parent_id,
            'mobile_verify_flag' => $this->mobile_verify_flag,
            'email_verify_flag' => $this->email_verify_flag,
            'status' => $this->status,
            'register_date' => $this->register_date,
            'rank_id' => $this->rank_id,
        ]);

        $query->andFilterWhere(['like', 'vip_id', $this->vip_id])
            ->andFilterWhere(['like', 'vip_name', $this->vip_name])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
