<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\ReturnSheetDetail;

/**
 * ReturnSheetDetailSearch represents the model behind the search form about `app\models\b2b2c\ReturnSheetDetail`.
 */
class ReturnSheetDetailSearch extends ReturnSheetDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'return_id', 'product_id', 'out_quantity', 'return_quantity'], 'integer'],
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
        $query = ReturnSheetDetail::find();

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
            'return_id' => $this->return_id,
            'product_id' => $this->product_id,
            'out_quantity' => $this->out_quantity,
            'return_quantity' => $this->return_quantity,
        ]);

        return $dataProvider;
    }
}
