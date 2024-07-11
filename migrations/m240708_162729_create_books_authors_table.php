<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books_authors}}`.
 */
class m240708_162729_create_books_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books_authors}}', [
            'book_id' => $this->integer()->unsigned()->notNull(),
            'author_id' => $this->integer()->unsigned()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey(
            'PK_' . $this->db->tablePrefix . 'book_id_author_id',
            '{{%books_authors}}',
            [
                'book_id',
                'author_id',
            ]
        );

        $this->addForeignKey(
            'FK_books_authors_books_id',
            'books_authors',
            'book_id',
            'books',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'FK_books_authors_authors_id',
            'books_authors',
            'author_id',
            'authors',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books_authors}}');
    }
}
