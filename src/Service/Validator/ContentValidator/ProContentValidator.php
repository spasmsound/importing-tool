<?php

namespace App\Service\Validator\ContentValidator;

class ProContentValidator implements ValidatorInterface
{
    public function getListPosition(): int
    {
        return 34;
    }

    public function validate(array $data): ?string
    {
       $value = $data[$this->getListPosition()];
       $isValid = null === $value || 'yes' === $value;

       return $isValid ? null : $this->getErrorMessage();
    }

    public function getErrorMessage(): string
    {
        return 'This value should be yes (or empty)';
    }
}
