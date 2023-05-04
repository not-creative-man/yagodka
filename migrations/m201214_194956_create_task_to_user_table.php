<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_to_user}}`.
 */
class m201214_194956_create_task_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task_to_user', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'task_id' => $this->integer(11)->notNull(),
            'cash' => 'TINYTEXT NOT NULL',
        ]);

        $this->createIndex(
            '{{%idx-task_to_user-user_id}}',
            'task_to_user',
            'user_id'
        );
        $this->addForeignKey(
            '{{%fk-task_to_user-user_id}}',
            'task_to_user',
            'user_id',
            'user',
            'id'
        );
        $this->createIndex(
            '{{%idx-task_to_user-task_id}}',
            'task_to_user',
            'task_id'
        );
        $this->addForeignKey(
            '{{%fk-task_to_user-task_id}}',
            'task_to_user',
            'task_id',
            'task',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task_to_user}}');
    }
}
