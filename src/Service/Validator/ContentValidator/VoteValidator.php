<?php

namespace App\Service\Validator\ContentValidator;

class VoteValidator implements ValidatorInterface
{
    public function getListPosition(): int
    {
        return 30;
    }

    public function validate(array $data): ?string
    {
        $value = $data[$this->getListPosition()];
        $isValid = '-' === $value || '+' === $value;

        return $isValid ? null : $this->getErrorMessage();
    }

    public function getErrorMessage(): string
    {
        return 'This value should be "+" or "-"';
    }
}
