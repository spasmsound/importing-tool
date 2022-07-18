<?php

namespace App\Service\Validator\ContentValidator;

class RcvValidator implements ValidatorInterface
{
    public function getListPosition(): int
    {
        return 29;
    }

    public function validate(array $data): ?string
    {
        return 'RCV' === $data[$this->getListPosition()] ? null : $this->getErrorMessage();
    }

    public function getErrorMessage(): string
    {
        return 'This value should be RCV';
    }
}
