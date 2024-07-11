<?php

use yii\db\Migration;
use yii\db\Expression;

/**
 * Handles the creation of table `{{%subscriptions}}`.
 */
class m240709_031101_create_subscriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriptions}}', [
            'id' => $this->primaryKey()->unsigned(),
            'phone' => $this->bigInteger()->unsigned(),
            'author_id' => $this->integer()->unsigned(),
            'is_active' => $this->boolean()->defaultValue(true),
            'created_at' => $this->timestamp()->defaultValue(new Expression('now()')),
            'updated_at' => $this->timestamp()->defaultValue(new Expression('now()')),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey(
            'FK_subscriptions_authors_id',
            'subscriptions',
            'author_id',
            'authors',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'IX_subscriptions_phone',
            '{{%subscriptions}}',
            'phone'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscriptions}}');
    }
}
