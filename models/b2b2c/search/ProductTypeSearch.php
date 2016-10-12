<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\ProductType;

/**
 * ProductTypeSearch represents the model behind the search form about `app\models\b2b2c\ProductType`.
 */
class ProductTypeSearch extends ProductType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'seq_id'], 'integer'],
            [['name', 'description'], 'safe'],
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
        $query = ProductType::find()->alias('p')->joinWith("parent pp");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'parent.name' => [
        						'asc'  => ['pp.name' => SORT_ASC],
        						'desc' => ['pp.name' => SORT_DESC],
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
            'p.id' => $this->id,
            'p.parent_id' => $this->parent_id,
            'p.seq_id' => $this->seq_id,
        ]);

        $query->andFilterWhere(['like', 'p.name', $this->name])
            ->andFilterWhere(['like', 'p.description', $this->description]);

        return $dataProvider;
    }
}
