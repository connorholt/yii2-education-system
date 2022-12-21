<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m221221_093312_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('users', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'username' => $this->string()->notNull(),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'role' => $this->integer()->notNull()->defaultValue(1),
        ]);

        $this->createIndex('idx-user-username', 'users', 'username', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
