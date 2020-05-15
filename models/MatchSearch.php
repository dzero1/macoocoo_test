<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Match;

/**
 * MatchSearch represents the model behind the search form of `app\models\Match`.
 */
class MatchSearch extends Match
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'schedule_id', 'team1_trys', 'team2_trys', 'team1_conversions', 'team2_conversions', 'team1_bonus', 'team2_bonus', 'team1_total', 'team2_total', 'winner'], 'integer'],
            [['status', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Match::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'schedule_id' => $this->schedule_id,
            'team1_trys' => $this->team1_trys,
            'team2_trys' => $this->team2_trys,
            'team1_conversions' => $this->team1_conversions,
            'team2_conversions' => $this->team2_conversions,
            'team1_bonus' => $this->team1_bonus,
            'team2_bonus' => $this->team2_bonus,
            'team1_total' => $this->team1_total,
            'team2_total' => $this->team2_total,
            'winner' => $this->winner,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
