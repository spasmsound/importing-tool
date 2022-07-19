<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'app_table_data')]
class TableData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "integer")]
    private int $rowId;

    #[ORM\Column(type: "integer")]
    private int $colId;

    #[ORM\Column(type: "boolean")]
    private bool $valid;

    #[ORM\Column(type: 'text', nullable: true)]
    private string $error;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $value;

    #[ORM\ManyToOne(targetEntity: ImportProcess::class, inversedBy: 'data')]
    private ImportProcess $importProcess;

    public function getId(): int
    {
        return $this->id;
    }

    public function getImportProcess(): ImportProcess
    {
        return $this->importProcess;
    }

    public function setImportProcess(ImportProcess $importProcess): void
    {
        $this->importProcess = $importProcess;
    }

    public function getRowId(): int
    {
        return $this->rowId;
    }

    public function setRowId(int $rowId): void
    {
        $this->rowId = $rowId;
    }

    public function getColId(): int
    {
        return $this->colId;
    }

    public function setColId(int $colId): void
    {
        $this->colId = $colId;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): void
    {
        $this->valid = $valid;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function setError(string $error): void
    {
        $this->error = $error;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): void
    {
        $this->value = $value;
    }
}
