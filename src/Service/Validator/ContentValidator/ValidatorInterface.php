<?php

namespace App\Service\Validator\ContentValidator;

interface ValidatorInterface
{
    public function getListPosition(): int;
    public function validate(array $data): ?string;
    public function getErrorMessage(): string;
}
