<?php

namespace app\models\b2b2c\search;

use app\models\b2b2c\VipBlog;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VipBlogSearch represents the model behind the search form about `app\models\b2b2c\VipBlog`.
 */
class VipBlogSearch extends VipBlog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'blog_type', 'blog_flag', 'vip_id', 'audit_user_id', 'audit_status', 'status'], 'integer'],
            [['content', 'create_date', 'update_date', 'audit_date', 'audit_memo', 'name'], 'safe'],
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
        $query = VipBlog::find()->alias('vipBlog')
        ->joinWith('vip vip')
        ->joinWith('status0 stat')
        ->joinWith('blogFlag blogFlag')
        ->joinWith('auditStatus auditStatus')
        ->joinWith('auditUser auditUser')
        ->joinWith('blogType blogType');
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'vip.vip_id' => [
        						'asc'  => ['vip.vip_id' => SORT_ASC],
        						'desc' => ['vip.vip_id' => SORT_DESC],
        				],
        				'vip.vip_name' => [
        						'asc'  => ['vip.vip_name' => SORT_ASC],
        						'desc' => ['vip.vip_name' => SORT_DESC],
        				],
        				'blogFlag.param_val' => [
        						'asc'  => ['blogFlag.param_val' => SORT_ASC],
        						'desc' => ['blogFlag.param_val' => SORT_DESC],
        				],
        				'blogType.name' => [
        						'asc'  => ['blogType.name' => SORT_ASC],
        						'desc' => ['blogType.name' => SORT_DESC],
        				],
        				'auditStatus.param_val' => [
        						'asc'  => ['auditStatus.param_val' => SORT_ASC],
        						'desc' => ['auditStatus.param_val' => SORT_DESC],
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
            'vipBlog.id' => $this->id,
            'vipBlog.blog_type' => $this->blog_type,
            'vipBlog.blog_flag' => $this->blog_flag,
            'vipBlog.vip_id' => $this->vip_id,
            'vipBlog.create_date' => $this->create_date,
            'vipBlog.update_date' => $this->update_date,
            'vipBlog.audit_user_id' => $this->audit_user_id,
            'vipBlog.audit_status' => $this->audit_status,
            'vipBlog.audit_date' => $this->audit_date,
            'vipBlog.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'vipBlog.content', $this->content])
            ->andFilterWhere(['like', 'vipBlog.audit_memo', $this->audit_memo])
        	->andFilterWhere(['like', 'vipBlog.name', $this->name])
        	->andFilterWhere(['like', 'vip.vip_id', $this->vip_no])
        	->andFilterWhere(['like', 'vip.vip_name', $this->vip_name]);
        
        if($this->start_date){
        	$query->andFilterWhere(['>=', 'vipBlog.create_date', date('Y-m-d 00:00:00',strtotime($this->start_date))]);
        }
        
        if($this->end_date){
        	$query->andFilterWhere(['<=', 'vipBlog.create_date', date('Y-m-d 23:59:59',strtotime($this->end_date))]);
        }

        return $dataProvider;
    }
}
