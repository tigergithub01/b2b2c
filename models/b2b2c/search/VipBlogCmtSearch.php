<?php

namespace app\models\b2b2c\search;

use app\models\b2b2c\VipBlogCmt;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VipBlogCmtSearch represents the model behind the search form about `app\models\b2b2c\VipBlogCmt`.
 */
class VipBlogCmtSearch extends VipBlogCmt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'blog_id', 'vip_id', 'status', 'parent_id'], 'integer'],
            [['content', 'reply_date'], 'safe'],
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
        $query = VipBlogCmt::find()->alias('vipBlogCmt')
    	->joinWith('blog blog')
    	->joinWith('vip vip')
    	->joinWith('status0 stat')
    	->joinWith('parent parent');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'blog.name' => [
        						'asc'  => ['blog.name' => SORT_ASC],
        						'desc' => ['blog.name' => SORT_DESC],
        				],
        				'vip.vip_name' => [
        						'asc'  => ['vip.vip_name' => SORT_ASC],
        						'desc' => ['vip.vip_name' => SORT_DESC],
        				],
        				'status0.param_val' => [
        						'asc'  => ['status0.param_val' => SORT_ASC],
        						'desc' => ['status0.param_val' => SORT_DESC],
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
            'vipBlogCmt.id' => $this->id,
            'vipBlogCmt.blog_id' => $this->blog_id,
            'vipBlogCmt.reply_date' => $this->reply_date,
            'vipBlogCmt.vip_id' => $this->vip_id,
            'vipBlogCmt.status' => $this->status,
            'vipBlogCmt.parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'vipBlogCmt.content', $this->content])
        		->andFilterWhere(['like', 'blog.name', $this->blog_name])
        		->andFilterWhere(['like', 'vip.vip_name', $this->vip_name]);
        
        if($this->blog_reply_flag){
//         	$query->andWhere(['IS', 'vipBlogCmt.parent_id', NULL]);
        	$query->andWhere(['vipBlogCmt.parent_id'=>NULL]);
        }

        return $dataProvider;
    }
}
