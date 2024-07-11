<?php
declare(strict_types=1);

namespace app\models;

use Yii;
use app\models\Query\AuthorQuery;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property string $fullname
 */
final class Author extends BaseModel
{
    public static function tableName(): string
    {
        return '{{%authors}}';
    }

    /**
     * @throws InvalidConfigException
     */
    public static function find(): AuthorQuery
    {
        return Yii::createObject(AuthorQuery::class, [__CLASS__]);
    }

    public function rules(): array
    {
        return [
            [['firstname', 'lastname'], 'required'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 128],
        ];
    }

    /**
     * @throws InvalidConfigException
     */
    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('{{%books_authors}}', ['author_id' => 'id']);
    }

    public function getFullname(): string
    {
        return implode(' ', array_filter(
            [$this->lastname, $this->firstname, $this->middlename],
            static function($v, $k) {
                return $v !== null;
            },
            ARRAY_FILTER_USE_BOTH
        ));
    }
}
