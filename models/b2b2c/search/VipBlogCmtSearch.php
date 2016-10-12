<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipBlogCmt;

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
        $query = VipBlogCmt::find();

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
            'blog_id' => $this->blog_id,
            'reply_date' => $this->reply_date,
            'vip_id' => $this->vip_id,
            'status' => $this->status,
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
