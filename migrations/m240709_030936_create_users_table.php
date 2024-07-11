<?php

use yii\db\Migration;
use yii\db\Expression;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m240709_030936_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey()->unsigned(),
            'username' => $this->string()->unique()->notNull(),
            'password' => $this->string()->notNull(),
            'email' => $this->string()->unique(),
            'auth_key' => $this->string(),
            'access_token' => $this->string(),
            'created_at' => $this->timestamp()->defaultValue(new Expression('now()')),
            'updated_at' => $this->timestamp()->defaultValue(new Expression('now()')),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
