<?php

namespace App\Service\Validator\ContentValidator;

class FinalVoteValidator implements ValidatorInterface
{
    public function getListPosition(): int
    {
        return 26;
    }

    public function validate(array $data): ?string
    {
        $value = $data[$this->getListPosition()];
        $isValid = 0 == $value || 1 == $value;

        return $isValid ? null : $this->getErrorMessage();
    }

    public function getErrorMessage(): string
    {
        return 'This value should be 0 or 1';
    }
}
