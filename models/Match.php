<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "match".
 *
 * @property int $id
 * @property int $schedule_id
 * @property int $team1_trys
 * @property int $team2_trys
 * @property int $team1_conversions
 * @property int $team2_conversions
 * @property int $team1_bonus
 * @property int $team2_bonus
 * @property int $team1_total
 * @property int $team2_total
 * @property int|null $winner
 * @property string|null $status
 * @property string $created_at
 */
class Match extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'match';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['schedule_id'], 'required'],
            [['schedule_id', 'team1_trys', 'team2_trys', 'team1_conversions', 'team2_conversions', 'team1_bonus', 'team2_bonus', 'team1_total', 'team2_total', 'winner'], 'integer'],
            [['created_at'], 'safe'],
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
            'schedule_id' => 'Schedule ID',
            'team1_trys' => 'Team1 Trys',
            'team2_trys' => 'Team2 Trys',
            'team1_conversions' => 'Team1 Conversions',
            'team2_conversions' => 'Team2 Conversions',
            'team1_bonus' => 'Team1 Bonus',
            'team2_bonus' => 'Team2 Bonus',
            'team1_total' => 'Team1 Total',
            'team2_total' => 'Team2 Total',
            'winner' => 'Winner',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
