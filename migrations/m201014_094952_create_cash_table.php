<?php

use yii\db\Migration;

/**
 * Handles the creation of table {{%cash}}.
 */
class m201014_094952_create_cash_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cash', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'count' => $this->integer(11)->notNull(),
            'comment' => 'TINYTEXT NOT NULL' ,
            'service' => $this->integer(11)->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-cash-user_id}}',
            'cash',
            'user_id'
        );
        $this->addForeignKey(
            '{{%fk-cash-user_id}}',
            'cash',
            'user_id',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cash');
    }
}
