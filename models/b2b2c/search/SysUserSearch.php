<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\SysUser;

/**
 * SysUserSearch represents the model behind the search form about `app\models\b2b2c\SysUser`.
 */
class SysUserSearch extends SysUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_admin', 'status'], 'integer'],
            [['user_id', 'user_name', 'password', 'last_login_date'], 'safe'],
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
        $query = SysUser::find()->joinWith("status0 stat");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pagesize' => '15',],
            
        ]);
        
        
        $dataProvider->setSort([
        	'attributes' => array_merge($dataProvider->getSort()->attributes,[
	            'status0.param_val' => [
	                'asc'  => ['stat.param_val' => SORT_ASC],
	                'desc' => ['stat.param_val' => SORT_DESC],
	            	'label' => '是否有效',
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
            'id' => $this->id,
            'is_admin' => $this->is_admin,
            'status' => $this->status,
            'last_login_date' => $this->last_login_date,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }
}
