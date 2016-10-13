<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\ReturnSheet;

/**
 * ReturnSheetSearch represents the model behind the search form about `app\models\b2b2c\ReturnSheet`.
 */
class ReturnSheetSearch extends ReturnSheet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sheet_type_id', 'return_apply_id', 'order_id', 'out_id', 'user_id', 'status', 'organization_id'], 'integer'],
            [['code', 'sheet_date', 'memo'], 'safe'],
            [['return_amt'], 'number'],
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
        $query = ReturnSheet::find();

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
            'sheet_type_id' => $this->sheet_type_id,
            'return_apply_id' => $this->return_apply_id,
            'order_id' => $this->order_id,
            'out_id' => $this->out_id,
            'user_id' => $this->user_id,
            'sheet_date' => $this->sheet_date,
            'return_amt' => $this->return_amt,
            'status' => $this->status,
            'organization_id' => $this->organization_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'memo', $this->memo]);

        return $dataProvider;
    }
}
