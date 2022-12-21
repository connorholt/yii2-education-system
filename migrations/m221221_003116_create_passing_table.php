<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m221221_003116_create_passing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('passing', [
            'id' => $this->primaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'lesson_id' => $this->bigInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-passing-user_id-lesson_id', 'passing', ['user_id', 'lesson_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('passing');
    }
}
