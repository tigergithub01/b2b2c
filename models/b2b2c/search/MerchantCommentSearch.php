<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\ProductComment;

/**
 * MerchantCommentSearch represents the model behind the search form about `app\models\b2b2c\ProductComment`.
 */
class MerchantCommentSearch extends ProductComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'organization_id', 'vip_id', 'cmt_rank_id', 'status', 'parent_id'], 'integer'],
            [['content', 'comment_date', 'ip_addr'], 'safe'],
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
        $query = ProductComment::find();

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
            'product_id' => $this->product_id,
            'organization_id' => $this->organization_id,
            'vip_id' => $this->vip_id,
            'cmt_rank_id' => $this->cmt_rank_id,
            'comment_date' => $this->comment_date,
            'status' => $this->status,
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'ip_addr', $this->ip_addr]);

        return $dataProvider;
    }
}
