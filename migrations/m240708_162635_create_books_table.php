<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m240708_162635_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey()->unsigned(),
            'isbn' => $this->string()->unique()->notNull(),
            'title' => $this->string()->null(),
            'description' => $this->text()->null(),
            'year' => $this->integer(4),
            'title_img' => $this->string()->null(),
            'created_at' => $this->timestamp()->defaultValue(new Expression('now()')),
            'updated_at' => $this->timestamp()->defaultValue(new Expression('now()')),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}
