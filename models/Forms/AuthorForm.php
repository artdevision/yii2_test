<?php
declare(strict_types=1);

namespace app\models\Forms;

final class AuthorForm extends BaseInputForm
{
    public ?string $firstname = null;
    public ?string $lastname = null;
    public ?string $middlename = null;

    public function rules(): array
    {
        return [
            [['firstname', 'lastname'], 'required', 'on' => 'create'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 128],
        ];
    }
}
