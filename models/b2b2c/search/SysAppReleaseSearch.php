<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\SysAppRelease;

/**
 * SysAppReleaseSearch represents the model behind the search form about `app\models\b2b2c\SysAppRelease`.
 */
class SysAppReleaseSearch extends SysAppRelease
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ver_no', 'force_upgrade', 'issue_user_id', 'app_info_id'], 'integer'],
            [['name', 'upgrade_desc', 'issue_date', 'app_path'], 'safe'],
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
        $query = SysAppRelease::find();

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
            'ver_no' => $this->ver_no,
            'force_upgrade' => $this->force_upgrade,
            'issue_date' => $this->issue_date,
            'issue_user_id' => $this->issue_user_id,
            'app_info_id' => $this->app_info_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'upgrade_desc', $this->upgrade_desc])
            ->andFilterWhere(['like', 'app_path', $this->app_path]);

        return $dataProvider;
    }
}
