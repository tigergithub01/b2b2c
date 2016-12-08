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
        $query = Vip::find()->alias('vip')
        ->joinWith('status0 stat')
        ->joinWith('auditStatus auditStat')
        ->joinWith('auditUser auditStatUsr')
        ->joinWith('emailVerifyFlag emailVerify')
        ->joinWith('parent parent')
        ->joinWith('merchantFlag mercFlag')
        ->joinWith('vipType vipType')
        ->joinWith('mobileVerifyFlag mobileVerify')    
        ->joinWith('rank rank')    
        ->joinWith('sex0 sex0');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'vipType.name' => [
        						'asc'  => ['vipType.name' => SORT_ASC],
        						'desc' => ['vipType.name' => SORT_DESC],
        				],
        				'sex0.param_val' => [
        						'asc'  => ['sex0.param_val' => SORT_ASC],
        						'desc' => ['sex0.param_val' => SORT_DESC],
        				],
        				'auditStatus.param_val' => [
        						'asc'  => ['auditStat.param_val' => SORT_ASC],
        						'desc' => ['auditStat.param_val' => SORT_DESC],
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
            'vip.id' => $this->id,
            'vip.merchant_flag' => $this->merchant_flag,
            'vip.last_login_date' => $this->last_login_date,
            'vip.parent_id' => $this->parent_id,
            'vip.mobile_verify_flag' => $this->mobile_verify_flag,
            'vip.email_verify_flag' => $this->email_verify_flag,
            'vip.status' => $this->status,
            'vip.register_date' => $this->register_date,
            'vip.vip.rank_id' => $this->rank_id,
            'vip.audit_status' => $this->audit_status,
            'vip.audit_user_id' => $this->audit_user_id,
            'vip.audit_date' => $this->audit_date,
            'vip.vip_type_id' => $this->vip_type_id,
            'vip.sex' => $this->sex,
            'vip.wedding_date' => $this->wedding_date,
            'vip.birthday' => $this->birthday,
        ]);

        $query->andFilterWhere(['like', 'vip.vip_id', $this->vip_id])
            ->andFilterWhere(['like', 'vip.vip_name', $this->vip_name])
            ->andFilterWhere(['like', 'vip.password', $this->password])
            ->andFilterWhere(['like', 'vip.mobile', $this->mobile])
            ->andFilterWhere(['like', 'vip.email', $this->email])
            ->andFilterWhere(['like', 'vip.audit_memo', $this->audit_memo])
            ->andFilterWhere(['like', 'vip.nick_name', $this->nick_name])
            ->andFilterWhere(['like', 'vip.img_url', $this->img_url])
            ->andFilterWhere(['like', 'vip.thumb_url', $this->thumb_url])
            ->andFilterWhere(['like', 'vip.img_original', $this->img_original]);

        return $dataProvider;
    }
}
