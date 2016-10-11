<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\SysRegion;

/**
 * SysRegionSearch represents the model behind the search form about `app\models\b2b2c\SysRegion`.
 */
class SysRegionSearch extends SysRegion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'region_type'], 'integer'],
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
        $query = SysRegion::find()->alias('reg')->joinWith('parent p')->joinWith('regionType t');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        //add sort
        $dataProvider->setSort([
        		'attributes' => array_merge($dataProvider->getSort()->attributes,[
        				'parent.name' => [
        						'asc'  => ['p.user_id' => SORT_ASC],
        						'desc' => ['p.user_id' => SORT_DESC],
        				],
        				'regionType.param_val' => [
        						'asc'  => ['t.param_val' => SORT_ASC],
        						'desc' => ['t.param_val' => SORT_DESC],
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
            'reg.id' => $this->id,
            'reg.parent_id' => $this->parent_id,
            'reg.region_type' => $this->region_type,
        ]);

        $query->andFilterWhere(['like', 'reg.name', $this->name]);

        return $dataProvider;
    }
}
