<?php

namespace App\Service\Validator\ContentValidator;

class NoValidator extends VoteIdValidator
{
    public function getListPosition(): int
    {
        return 32;
    }
}
