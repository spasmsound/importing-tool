<?php

namespace App\Service\Validator\ContentValidator;

class CodeValidator implements ValidatorInterface
{

    public function getListPosition(): int
    {
        return 15;
    }

    public function validate(array $data): ?string
    {
        $value = $data[$this->getListPosition()];

        return 0 == $value || '' === $value ? $this->getErrorMessage() : null;
    }

    public function getErrorMessage(): string
    {
        return 'This value should not be empty';
    }
}
