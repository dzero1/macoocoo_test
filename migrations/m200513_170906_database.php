<?php

use yii\db\Migration;

/**
 * Class m200513_170906_database
 */
class m200513_170906_database extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tournament', [
            'id' => $this->primaryKey(),
            'display_name' => $this->string(),
            'logo' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        
        $this->createTable('teams', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer()->notNull(),
            'display_name' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createTable('schedule', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer()->notNull(),
            'team1' => $this->integer()->notNull(),
            'team2' => $this->integer()->notNull(),
            'status' => $this->string(),
            'start_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('tournament');
       $this->dropTable('teams');
       $this->dropTable('schedule');
       return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200513_170906_database cannot be reverted.\n";

        return false;
    }
    */
}
