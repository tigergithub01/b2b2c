<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipOrgCase;

/**
 * VipOrgCaseSearch represents the model behind the search form about `app\models\b2b2c\VipOrgCase`.
 */
class VipOrgCaseSearch extends VipOrgCase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'organization_id', 'status', 'audit_status', 'audit_user_id', 'is_hot', 'case_flag'], 'integer'],
            [['name', 'content', 'create_date', 'update_date', 'audit_date', 'cover_img_url', 'cover_thumb_url', 'cover_img_original'], 'safe'],
            [['market_price', 'sale_price'], 'number'],
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
        $query = VipOrgCase::find();

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
            'type_id' => $this->type_id,
            'organization_id' => $this->organization_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'status' => $this->status,
            'audit_status' => $this->audit_status,
            'audit_user_id' => $this->audit_user_id,
            'audit_date' => $this->audit_date,
            'is_hot' => $this->is_hot,
            'case_flag' => $this->case_flag,
            'market_price' => $this->market_price,
            'sale_price' => $this->sale_price,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'cover_img_url', $this->cover_img_url])
            ->andFilterWhere(['like', 'cover_thumb_url', $this->cover_thumb_url])
            ->andFilterWhere(['like', 'cover_img_original', $this->cover_img_original]);

        return $dataProvider;
    }
}
