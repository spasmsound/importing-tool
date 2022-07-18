<?php

namespace App\Service\Validator\ContentValidator;

class TitleValidator implements ValidatorInterface
{
    public function getListPosition(): int
    {
        return 5;
    }

    public function validate(array $data): ?string
    {
        $value = $data[$this->getListPosition()];
        $hasAlphanumericContent = !is_null($value) && '' !== trim($value);

        return $hasAlphanumericContent ? null : $this->getErrorMessage();
    }

    public function getErrorMessage(): string
    {
        return 'This value is not alphanumeric';
    }
}
