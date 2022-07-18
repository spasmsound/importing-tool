<?php

namespace App\Service\Validator\ContentValidator;

class PartValidator implements ValidatorInterface
{
    public function getListPosition(): int
    {
        return 20;
    }

    public function validate(array $data): ?string
    {
        $isValid = preg_match("/^\\d+$/", $data[$this->getListPosition()]) && 0 !== $data[$this->getListPosition()];

        return $isValid ? null: $this->getErrorMessage();
    }

    public function getErrorMessage(): string
    {
        return 'This value should be a number (except 0)';
    }
}
