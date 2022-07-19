<?php

namespace App\Command;

use App\Entity\ImportProcess;
use App\Entity\TemporaryDataStorage;
use App\Messenger\Message\ImportProcess as ImportProcessMessage;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadFileCommand extends Command
{
    private SluggerInterface $slugger;
    private string $uploadsDir;
    private MessageBusInterface $messageBus;
    private EntityManagerInterface $entityManager;

    public function __construct(
        SluggerInterface        $slugger,
        MessageBusInterface     $messageBus,
        EntityManagerInterface $entityManager,
        string                  $uploadsDir,
        string                  $name = null
    ) {
        parent::__construct($name);
        $this->slugger = $slugger;
        $this->uploadsDir = $uploadsDir;
        $this->messageBus = $messageBus;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setName('app:import');
        $this->addArgument('file', InputArgument::REQUIRED, 'Excel file');
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = $input->getArgument('file');

        $extension = explode('.', $filename);
        $extension = end($extension);

        $reader = match ($extension) {
            'csv' => new Csv(),
            'xls' => new Xls(),
            'xlsx' => new Xlsx(),
            default => null,
        };

        if (is_null($reader)) {
            $output->writeln('Unsupported file type');

            return self::INVALID;
        }

        $fileData = file_get_contents(__DIR__ . '/' . $filename);

        $safeFilename = $this->slugger->slug(strtolower($filename));
        $newFilename = $safeFilename . '-' . uniqid() . '-' . (new \DateTime())->getTimestamp() . '.' . $extension;
        $filePath = $this->uploadsDir . '/' . $newFilename;
        file_put_contents($filePath, $fileData);

        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filePath);

        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());

        $importProcess = new ImportProcess();
        $importProcess->setFilename($newFilename);
        $importProcess->setStatus(ImportProcess::STATUS_QUEUED);
        $tempData = new TemporaryDataStorage();
        $tempData->setData($sheet->toArray());
        $tempData->setCountOfCells($this->countCells($sheet->toArray()));
        $importProcess->setTemporaryDataStorage($tempData);

        $this->entityManager->persist($importProcess);
        $this->entityManager->persist($tempData);

        $this->entityManager->flush();

        $importProcessMessage = new ImportProcessMessage($importProcess->getId());
        $this->messageBus->dispatch($importProcessMessage);

        return self::SUCCESS;
    }

    protected function countCells(array $data): int
    {
        $count = 0;
        foreach ($data as $key => $values) {
            if (0 === $key) {
                continue;
            }

            $count += count($values);
        }

        return $count;
    }
}
