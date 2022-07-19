<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'app_temp')]
class TemporaryDataStorage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: 'array')]
    private array $data;

    #[ORM\Column(type: "integer")]
    private int $countOfCells;

    public function getId(): int
    {
        return $this->id;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getCountOfCells(): int
    {
        return $this->countOfCells;
    }

    public function setCountOfCells(int $countOfCells): void
    {
        $this->countOfCells = $countOfCells;
    }
}
