<?php
declare(strict_types=1);

namespace app\models;

use yii\db\ActiveQuery;

/**
 * @property int $phone
 * @property int $author_id
 * @property bool $is_active
 * @property Author $author
 */
final class Subscription extends BaseModel
{
    public static function tableName(): string
    {
        return '{{%subscriptions}}';
    }

    public function rules(): array
    {
        return [
            [['phone', 'author_id'], 'required'],
            ['phone', 'integer'],
            ['author_id', 'exist', 'targetClass' => Author::class, 'targetAttribute' => 'id'],
            ['is_active', 'boolean'],
        ];
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}
