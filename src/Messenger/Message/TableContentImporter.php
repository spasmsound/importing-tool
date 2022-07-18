<?php

namespace App\Messenger\Message;

class TableContentImporter
{
    private array $data;
    private int $importProcessId;
    private int $rowId;

    public function __construct(int $importProcessId, int $rowId, array $data)
    {
        $this->data = $data;
        $this->importProcessId = $importProcessId;
        $this->rowId = $rowId;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getImportProcessId(): int
    {
        return $this->importProcessId;
    }

    public function getRowId(): int
    {
        return $this->rowId;
    }
}
