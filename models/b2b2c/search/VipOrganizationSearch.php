<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipOrganization;

/**
 * VipOrganizationSearch represents the model behind the search form about `app\models\b2b2c\VipOrganization`.
 */
class VipOrganizationSearch extends VipOrganization
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'vip_id', 'country_id', 'province_id', 'city_id'], 'integer'],
            [['name', 'logo_img_url', 'logo_thumb_url', 'logo_ilmg_original', 'cover_img_url', 'cover_thumb_url', 'cover_img_original', 'description'], 'safe'],
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
        $query = VipOrganization::find();

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
            'status' => $this->status,
            'vip_id' => $this->vip_id,
            'country_id' => $this->country_id,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'logo_img_url', $this->logo_img_url])
            ->andFilterWhere(['like', 'logo_thumb_url', $this->logo_thumb_url])
            ->andFilterWhere(['like', 'logo_ilmg_original', $this->logo_ilmg_original])
            ->andFilterWhere(['like', 'cover_img_url', $this->cover_img_url])
            ->andFilterWhere(['like', 'cover_thumb_url', $this->cover_thumb_url])
            ->andFilterWhere(['like', 'cover_img_original', $this->cover_img_original])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
