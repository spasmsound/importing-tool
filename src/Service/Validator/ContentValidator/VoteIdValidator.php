<?php

namespace App\Service\Validator\ContentValidator;

class VoteIdValidator implements ValidatorInterface
{
    public function validate(array $data): ?string
    {
        return 1 === preg_match("/^\\d+$/", $data[$this->getListPosition()]) ? null
            : $this->getErrorMessage();
    }

    public function getListPosition(): int
    {
        return 0;
    }

    public function getErrorMessage(): string
    {
        return 'The value is not numerical';
    }
}
