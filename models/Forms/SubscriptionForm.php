<?php
declare(strict_types=1);

namespace app\models\Forms;

use app\models\Author;

final class SubscriptionForm extends BaseInputForm
{
    public ?string $phone = null;
    public ?int $author_id = null;
    public bool $is_active = true;

    public function rules(): array
    {
        return [
            [['phone', 'author_id'], 'required', 'on' => 'subscribe'],
            ['phone', 'trim'],
            ['phone', 'match', 'pattern' => '/^\s?(\+\s?7|8)([- ()]*\d){10}$/'],
            ['is_active', 'default', 'value' => true],
            ['author_id', 'exist', 'targetClass' => Author::class, 'targetAttribute' => 'id'],
        ];
    }

    public function afterValidate(): void
    {
        parent::afterValidate();
        $this->phone = str_replace(['-', '+', '(', ')', ' '], '', $this->phone);
    }
}
