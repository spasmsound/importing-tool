<?php

namespace App\Event;

use App\Entity\ImportProcess;
use DateTime;

class ImportProcessListener
{
    public function preUpdate(ImportProcess $importProcess): void
    {
        $importProcess->setUpdatedAt(new DateTime());
    }
}
