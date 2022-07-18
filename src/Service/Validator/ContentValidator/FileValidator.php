<?php

namespace App\Service\Validator\ContentValidator;

class FileValidator extends VoteIdValidator
{
    public function getListPosition(): int
    {
        return 1;
    }
}
