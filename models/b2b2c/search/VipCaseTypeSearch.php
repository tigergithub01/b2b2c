<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\VipCaseType;

/**
 * VipCaseTypeSearch represents the model behind the search form about `app\models\b2b2c\VipCaseType`.
 */
class VipCaseTypeSearch extends VipCaseType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vip_type_id'], 'integer'],
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
        $query = VipCaseType::find()->alias('caseType')
    	->joinWith('vipType vipType');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sorts
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'vipType.name' => [
        						'asc'  => ['vipType.name' => SORT_ASC],
        						'desc' => ['vipType.name' => SORT_DESC],
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
            'caseType.id' => $this->id,
            'caseType.vip_type_id' => $this->vip_type_id,
        ]);

        $query->andFilterWhere(['like', 'caseType.name', $this->name]);

        return $dataProvider;
    }
}
