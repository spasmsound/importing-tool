<?php

namespace App\Service\Validator\ContentValidator;

class AuthorValidator implements ValidatorInterface
{
    public function getListPosition(): int
    {
        return 28;
    }

    public function validate(array $data): ?string
    {
        $value = $data[$this->getListPosition()];
        $isValid = 0 !== $value;

        return $isValid ? null : $this->getErrorMessage();
    }

    public function getErrorMessage(): string
    {
        return 'This value should not be 0 (or empty)';
    }
}
