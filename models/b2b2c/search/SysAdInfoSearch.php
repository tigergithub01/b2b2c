<?php

namespace app\models\b2b2c\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\b2b2c\SysAdInfo;

/**
 * SysAdInfoSearch represents the model behind the search form about `app\models\b2b2c\SysAdInfo`.
 */
class SysAdInfoSearch extends SysAdInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sequence_id', 'width', 'height'], 'integer'],
            [['img_url', 'thumb_url', 'img_original', 'redirect_url', 'description'], 'safe'],
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
        $query = SysAdInfo::find();

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
            'sequence_id' => $this->sequence_id,
            'width' => $this->width,
            'height' => $this->height,
        ]);

        $query->andFilterWhere(['like', 'img_url', $this->img_url])
            ->andFilterWhere(['like', 'thumb_url', $this->thumb_url])
            ->andFilterWhere(['like', 'img_original', $this->img_original])
            ->andFilterWhere(['like', 'redirect_url', $this->redirect_url])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
