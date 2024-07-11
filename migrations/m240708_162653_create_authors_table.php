<?php

use yii\db\Migration;
use yii\db\Expression;

/**
 * Handles the creation of table `{{%authors}}`.
 */
class m240708_162653_create_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey()->unsigned(),
            'firstname' => $this->string()->null(),
            'lastname' => $this->string()->null(),
            'middlename' => $this->string()->null(),
            'created_at' => $this->timestamp()->defaultValue(new Expression('now()')),
            'updated_at' => $this->timestamp()->defaultValue(new Expression('now()')),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%authors}}');
    }
}
