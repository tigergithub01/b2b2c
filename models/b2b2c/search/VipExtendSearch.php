<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipExtend;

/**
 * VipExtendSearch represents the model behind the search form about `app\models\b2b2c\VipExtend`.
 */
class VipExtendSearch extends VipExtend
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vip_id', 'audit_status', 'audit_user_id'], 'integer'],
            [['real_name', 'id_card_no', 'id_card_img_url', 'id_card_thumb_url', 'id_card_img_original', 'id_back_img_url', 'id_back_thumb_url', 'id_back_img_original', 'bl_img_url', 'bl_thumb_url', 'bl_img_original', 'bank_account', 'bank_name', 'bank_number', 'bank_addr', 'audit_date', 'audit_memo', 'create_date', 'update_date'], 'safe'],
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
        $query = VipExtend::find();

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
            'vip_id' => $this->vip_id,
            'audit_status' => $this->audit_status,
            'audit_user_id' => $this->audit_user_id,
            'audit_date' => $this->audit_date,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['like', 'real_name', $this->real_name])
            ->andFilterWhere(['like', 'id_card_no', $this->id_card_no])
            ->andFilterWhere(['like', 'id_card_img_url', $this->id_card_img_url])
            ->andFilterWhere(['like', 'id_card_thumb_url', $this->id_card_thumb_url])
            ->andFilterWhere(['like', 'id_card_img_original', $this->id_card_img_original])
            ->andFilterWhere(['like', 'id_back_img_url', $this->id_back_img_url])
            ->andFilterWhere(['like', 'id_back_thumb_url', $this->id_back_thumb_url])
            ->andFilterWhere(['like', 'id_back_img_original', $this->id_back_img_original])
            ->andFilterWhere(['like', 'bl_img_url', $this->bl_img_url])
            ->andFilterWhere(['like', 'bl_thumb_url', $this->bl_thumb_url])
            ->andFilterWhere(['like', 'bl_img_original', $this->bl_img_original])
            ->andFilterWhere(['like', 'bank_account', $this->bank_account])
            ->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'bank_number', $this->bank_number])
            ->andFilterWhere(['like', 'bank_addr', $this->bank_addr])
            ->andFilterWhere(['like', 'audit_memo', $this->audit_memo]);

        return $dataProvider;
    }
}
