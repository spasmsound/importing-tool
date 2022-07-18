<?php

namespace App\Service\Validator\ContentValidator;

class OClockValidator implements ValidatorInterface
{
    public function getListPosition(): int
    {
        return 4;
    }

    public function validate(array $data): ?string
    {
        return is_null($data[$this->getListPosition()]) ? null : $this->getErrorMessage();
    }

    public function getErrorMessage(): string
    {
        return 'This value should be empty';
    }
}
