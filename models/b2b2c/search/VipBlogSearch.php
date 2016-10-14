<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipBlog;

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
            [['content', 'create_date', 'update_date', 'audit_date', 'audit_memo'], 'safe'],
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
        $query = VipBlog::find();

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
            'blog_type' => $this->blog_type,
            'blog_flag' => $this->blog_flag,
            'vip_id' => $this->vip_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'audit_user_id' => $this->audit_user_id,
            'audit_status' => $this->audit_status,
            'audit_date' => $this->audit_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'audit_memo', $this->audit_memo]);

        return $dataProvider;
    }
}
