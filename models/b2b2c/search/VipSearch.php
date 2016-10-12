<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\Vip;
use app\models\b2b2c\SysParameter;

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
            [['id', 'merchant_flag', 'parent_id', 'mobile_verify_flag', 'email_verify_flag', 'status', 'rank_id', 'audit_status', 'audit_user_id', 'vip_type_id', 'sex'], 'integer'],
            [['vip_id', 'vip_name', 'last_login_date', 'password', 'mobile', 'email', 'register_date', 'audit_date', 'audit_memo', 'nick_name', 'wedding_date', 'birthday', 'img_url', 'thumb_url', 'img_original'], 'safe'],
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
        $query = Vip::find()->where(['merchant_flag' => SysParameter::no]);

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
            'merchant_flag' => $this->merchant_flag,
            'last_login_date' => $this->last_login_date,
            'parent_id' => $this->parent_id,
            'mobile_verify_flag' => $this->mobile_verify_flag,
            'email_verify_flag' => $this->email_verify_flag,
            'status' => $this->status,
            'register_date' => $this->register_date,
            'rank_id' => $this->rank_id,
            'audit_status' => $this->audit_status,
            'audit_user_id' => $this->audit_user_id,
            'audit_date' => $this->audit_date,
            'vip_type_id' => $this->vip_type_id,
            'sex' => $this->sex,
            'wedding_date' => $this->wedding_date,
            'birthday' => $this->birthday,
        ]);

        $query->andFilterWhere(['like', 'vip_id', $this->vip_id])
            ->andFilterWhere(['like', 'vip_name', $this->vip_name])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'audit_memo', $this->audit_memo])
            ->andFilterWhere(['like', 'nick_name', $this->nick_name])
            ->andFilterWhere(['like', 'img_url', $this->img_url])
            ->andFilterWhere(['like', 'thumb_url', $this->thumb_url])
            ->andFilterWhere(['like', 'img_original', $this->img_original]);

        return $dataProvider;
    }
}
