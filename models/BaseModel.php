<?php
declare(strict_types=1);

namespace app\models;

use app\behaviours\AppTimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property string $created_at
 * @property string $updated_at
 */
class BaseModel extends ActiveRecord
{
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => AppTimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ]
        ];
    }
}
