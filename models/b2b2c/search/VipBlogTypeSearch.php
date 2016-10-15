<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipBlogType;

/**
 * VipBlogTypeSearch represents the model behind the search form about `app\models\b2b2c\VipBlogType`.
 */
class VipBlogTypeSearch extends VipBlogType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id'], 'integer'],
            [['name'], 'safe'],
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
        $query = VipBlogType::find()->alias('bType')
        ->joinWith('parent parent');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'parent.name' => [
        						'asc'  => ['parent.name' => SORT_ASC],
        						'desc' => ['parent.name' => SORT_DESC],
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
            'bType.id' => $this->id,
            'bType.parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'bType.name', $this->name]);

        return $dataProvider;
    }
}
