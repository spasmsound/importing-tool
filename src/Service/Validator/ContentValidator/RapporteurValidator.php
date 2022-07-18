<?php

namespace App\Service\Validator\ContentValidator;

class RapporteurValidator implements ValidatorInterface
{
    public function getListPosition(): int
    {
        return 14;
    }

    public function validate(array $data): ?string
    {
        $value = $data[$this->getListPosition()];

        return 0 == $value ? null : $this->getErrorMessage();
    }

    public function getErrorMessage(): string
    {
        return 'This value should be empty or 0';
    }
}
