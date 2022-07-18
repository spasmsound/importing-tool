<?php

namespace App\Service\Validator\ContentValidator;

class LegValidator implements ValidatorInterface
{
    public function getListPosition(): int
    {
        return 11;
    }

    public function validate(array $data): ?string
    {
        return match ($data[$this->getListPosition()]) {
            'Bud', 'Leg', 'Non' => null,
            default => $this->getErrorMessage(),
        };
    }

    public function getErrorMessage(): string
    {
        return 'This value should be "Bud" or "Leg" or "Non"';
    }
}
