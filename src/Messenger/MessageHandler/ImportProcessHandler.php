<?php

namespace App\Messenger\MessageHandler;

use App\Entity\ImportProcess;
use App\Messenger\Message\ImportProcess as ImportProcessMessage;
use App\Messenger\Message\TableContentImporter;
use App\Service\Validator\ContentValidator\ValidatorInterface;
use App\Service\Validator\TableStructureValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class ImportProcessHandler
{
    private TableStructureValidator $tableStructureValidator;
    private EntityManagerInterface $entityManager;
    private MessageBusInterface $messageBus;

    public function __construct(
        TableStructureValidator $tableStructureValidator,
        EntityManagerInterface $entityManager,
        MessageBusInterface $messageBus
    ) {
        $this->tableStructureValidator = $tableStructureValidator;
        $this->entityManager = $entityManager;
        $this->messageBus = $messageBus;
    }

    public function __invoke(ImportProcessMessage $message): void
    {
        $id = $message->getId();

        /** @var ImportProcess $importProcess */
        $importProcess = $this->entityManager->getRepository(ImportProcess::class)->find($id);

        $structureCheckPassed = $this->checkTableStructure($importProcess);

        if (!$structureCheckPassed) {
            return;
        }

        foreach ($importProcess->getTemporaryDataStorage()->getData() as $key => $row) {
            if (0 === $key) {
                continue;
            }

            $newMessage = new TableContentImporter($importProcess->getId(), $key, $row);
            $this->messageBus->dispatch($newMessage);
        }
    }

    protected function checkTableStructure(ImportProcess $importProcess): bool
    {
        $errors = $this->tableStructureValidator->validate($importProcess->getTemporaryDataStorage()->getData());

        if (0 === count($errors)) {
            return true;
        }

        $importProcess->setStatus(ImportProcess::STATUS_ERROR);
        $importProcess->setErrors($errors);
        $tempData = $importProcess->getTemporaryDataStorage();
        $importProcess->setTemporaryDataStorage(null);
        $this->entityManager->remove($tempData);

        $this->entityManager->persist($importProcess);
        $this->entityManager->flush();

        return false;
    }
}
