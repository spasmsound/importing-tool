<?php

namespace App\Entity;

use App\Event\ImportProcessListener;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'app_import_process')]
#[ORM\EntityListeners([ImportProcessListener::class])]
class ImportProcess
{
    public const STATUS_NEW = 0;
    public const STATUS_QUEUED = 1;
    public const STATUS_PROCESSING = 2;
    public const STATUS_SUCCESS = 3;
    public const STATUS_WARNING = 4;
    public const STATUS_ERROR = 5;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $status;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private DateTime $updatedAt;

    #[ORM\Column(type: 'string')]
    private string $filename;

    #[ORM\OneToMany(mappedBy: 'importProcess', targetEntity: TableData::class, cascade: ['persist', 'remove'])]
    private Collection $tableData;

    #[ORM\OneToOne(targetEntity: TemporaryDataStorage::class)]
    #[ORM\JoinColumn(name: 'temp_data_id', referencedColumnName: 'id', nullable: true)]
    private ?TemporaryDataStorage $temporaryDataStorage;

    #[ORM\Column(type: 'array', nullable: true)]
    private array $errors;

    public function __construct()
    {
        $this->status = self::STATUS_NEW;
        $this->createdAt = new DateTime();
        $this->tableData = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    public function getTableData(): Collection
    {
        return $this->tableData;
    }

    public function addTableData(TableData $tableData): void
    {
        $this->tableData->add($tableData);
    }

    public function removeTableData(TableData $tableData): void
    {
        $this->tableData->removeElement($tableData);
    }

    public function hasTableData(TableData $tableData): bool
    {
        return $this->tableData->contains($tableData);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getTemporaryDataStorage(): ?TemporaryDataStorage
    {
        return $this->temporaryDataStorage;
    }

    public function setTemporaryDataStorage(?TemporaryDataStorage $temporaryDataStorage): void
    {
        $this->temporaryDataStorage = $temporaryDataStorage;
    }
}
