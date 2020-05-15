<?php

use yii\db\Migration;

/**
 * Class m200513_185444_matches
 */
class m200513_185444_matches extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('match', [
            'id' => $this->primaryKey(),
            'schedule_id' => $this->integer()->notNull(),
            'team1_trys' => $this->integer()->notNull()->defaultValue('0'),
            'team2_trys' => $this->integer()->notNull()->defaultValue('0'),
            'team1_conversions' => $this->integer()->notNull()->defaultValue('0'),
            'team2_conversions' => $this->integer()->notNull()->defaultValue('0'),
            'team1_bonus' => $this->integer()->notNull()->defaultValue('0'),
            'team2_bonus' => $this->integer()->notNull()->defaultValue('0'),
            'team1_total' => $this->integer()->notNull()->defaultValue('0'),
            'team2_total' => $this->integer()->notNull()->defaultValue('0'),
            'winner' => $this->integer(),
            'status' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return $this->dropTable('match');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200513_185444_matches cannot be reverted.\n";

        return false;
    }
    */
}
