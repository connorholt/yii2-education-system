<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m221221_193215_create_lesson_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('lessons', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'video_url' => $this->string(250)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx-lesson-title', 'lessons', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('lessons');
    }
}
