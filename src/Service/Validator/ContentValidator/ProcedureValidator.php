<?php

namespace App\Service\Validator\ContentValidator;

class ProcedureValidator implements ValidatorInterface
{
    public function getListPosition(): int
    {
        return 10;
    }

    public function validate(array $data): ?string
    {
        return match ($data[$this->getListPosition()]) {
            '*', '***', '***I', '***II' => null,
            default => $this->getErrorMessage(),
        };
    }

    public function getErrorMessage(): string
    {
        return 'This value should be "*" or "***" or "***I" or "***II"';
    }
}
