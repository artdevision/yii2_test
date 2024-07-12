<?php
declare(strict_types=1);

namespace app\models;

use app\behaviours\CreatedBookBehavior;
use app\models\Traits\ValidateIsbnTrait;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * @property int $id
 * @property string $title
 * @property string $isbn
 * @property string $description
 * @property int $year
 * @property string $title_img
 * @property Author[] $authors
 */
final class Book extends BaseModel
{
    use ValidateIsbnTrait;

    public const EVENT_BOOK_CREATED = 'bookCreated';

    public static function tableName(): string
    {
        return '{{%books}}';
    }

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'bookCreated' => [
                'class' => CreatedBookBehavior::class
            ],
        ]);
    }

    public function rules(): array
    {
        return [
            [['title', 'isbn', 'year'], 'required'],
            [['title'], 'string', 'max' => 256],
            ['isbn', 'validateIsbn'],
            ['description', 'safe'],
            ['year', 'integer', 'min' => 999, 'max' => 9999],
            ['title_img', 'string']
        ];
    }

    /**
     * @throws InvalidConfigException
     */
    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('{{%books_authors}}', ['book_id' => 'id']);
    }
}
