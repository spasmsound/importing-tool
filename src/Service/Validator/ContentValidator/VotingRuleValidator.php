<?php

namespace App\Service\Validator\ContentValidator;

class VotingRuleValidator implements ValidatorInterface
{

    public function getListPosition(): int
    {
        return 13;
    }

    public function validate(array $data): ?string
    {
        $value = $data[$this->getListPosition()];

        return $value === 's' || $value === 'q' ? null : $this->getErrorMessage();
    }

    public function getErrorMessage(): string
    {
        return 'This values should be "s" or "q"';
    }
}
