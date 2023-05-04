<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
class m201214_193339_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'status' => 'TINYINT(1)',
            'name' => 'TINYTEXT NOT NULL',
            'task' => 'LONGTEXT NOT NULL',
            'cash' => $this->integer(11)->notNull() ,
            'deadline' => 'TINYTEXT NOT NULL',
            'max_user' => $this->integer(11)->notNull(),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task}}');
    }
}
