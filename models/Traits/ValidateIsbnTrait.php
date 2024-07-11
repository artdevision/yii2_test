<?php
declare(strict_types=1);

namespace app\models\Traits;

use Biblys\Isbn\Isbn;
use Biblys\Isbn\IsbnValidationException;

trait ValidateIsbnTrait
{
    public function validateIsbn($attribute, $params): void
    {
        if (property_exists($this, $attribute)) {
            if (Isbn::isParsable($this->$attribute)) {
                try {
                    $value = Isbn::convertToIsbn13($this->$attribute);
                    Isbn::validateAsIsbn13($value);
                } catch (IsbnValidationException $exception) {
                    $this->addError($attribute, $exception->getMessage());
                }
            } else {
                $this->addError($attribute, 'Incorrect ISBN value.');
            }
        }
    }
}
