<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property int $id
 * @property int $tournament_id
 * @property int $team1
 * @property int $team2
 * @property string|null $status
 * @property string $start_at
 * @property string $created_at
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tournament_id', 'team1', 'team2'], 'required'],
            [['tournament_id', 'team1', 'team2'], 'integer'],
            [['start_at', 'created_at'], 'safe'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tournament_id' => 'Tournament ID',
            'team1' => 'Team1',
            'team2' => 'Team2',
            'status' => 'Status',
            'start_at' => 'Start At',
            'created_at' => 'Created At',
        ];
    }
}
