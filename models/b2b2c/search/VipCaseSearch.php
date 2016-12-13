<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipCase;

/**
 * VipCaseSearch represents the model behind the search form about `app\models\b2b2c\VipCase`.
 */
class VipCaseSearch extends VipCase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'vip_id', 'status', 'audit_status', 'audit_user_id', 'is_hot', 'case_flag'], 'integer'],
            [['name', 'content', 'create_date', 'update_date', 'audit_date', 'audit_memo', 'cover_img_url', 'cover_thumb_url', 'cover_img_original'], 'safe'],
            [['market_price', 'sale_price'], 'number'],
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
        $query = VipCase::find()->alias('case')
    	->joinWith('auditUser auditUser')
        ->joinWith('auditStatus auditStatus')
        ->joinWith('type type')
        ->joinWith('caseFlag caseFlag')
        ->joinWith('status0 stat')
        ->joinWith('isHot isHot')
        ->joinWith('vip vip');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'type.name' => [
        						'asc'  => ['type.name' => SORT_ASC],
        						'desc' => ['type.name' => SORT_DESC],
        				],
        				'caseFlag.param_val' => [
        						'asc'  => ['caseFlag.param_val' => SORT_ASC],
        						'desc' => ['caseFlag.param_val' => SORT_DESC],
        				],
        				'vip.vip_id' => [
        						'asc'  => ['vip.vip_id' => SORT_ASC],
        						'desc' => ['vip.vip_id' => SORT_DESC],
        				],
        				'vip.vip_name' => [
        						'asc'  => ['vip.vip_name' => SORT_ASC],
        						'desc' => ['vip.vip_name' => SORT_DESC],
        				],
        				'auditStatus.param_val' => [
        						'asc'  => ['auditStatus.param_val' => SORT_ASC],
        						'desc' => ['auditStatus.param_val' => SORT_DESC],
        				],
        				'isHot.param_val' => [
        						'asc'  => ['isHot.param_val' => SORT_ASC],
        						'desc' => ['isHot.param_val' => SORT_DESC],
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
            'case.id' => $this->id,
            'case.type_id' => $this->type_id,
            'case.vip_id' => $this->vip_id,
            'case.create_date' => $this->create_date,
            'case.update_date' => $this->update_date,
            'case.status' => $this->status,
            'case.audit_status' => $this->audit_status,
            'case.audit_user_id' => $this->audit_user_id,
            'case.audit_date' => $this->audit_date,
            'case.is_hot' => $this->is_hot,
            'case.case_flag' => $this->case_flag,
            'case.market_price' => $this->market_price,
            'case.sale_price' => $this->sale_price,
        ]);

        $query->andFilterWhere(['like', 'case.name', $this->name])
            ->andFilterWhere(['like', 'case.content', $this->content])
            ->andFilterWhere(['like', 'case.audit_memo', $this->audit_memo])
            ->andFilterWhere(['like', 'case.cover_img_url', $this->cover_img_url])
            ->andFilterWhere(['like', 'case.cover_thumb_url', $this->cover_thumb_url])
            ->andFilterWhere(['like', 'case.cover_img_original', $this->cover_img_original])
            ->andFilterWhere(['like', 'vip.vip_name', $this->vip_name]);

        return $dataProvider;
    }
}
