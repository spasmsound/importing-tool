<?php

namespace App\Service\Validator\ContentValidator;

class OrderOfVoteValidator extends CodeValidator
{
    public function getListPosition(): int
    {
        return 2;
    }
}
