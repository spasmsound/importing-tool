<?php

namespace App\Messenger\MessageHandler;

use App\Entity\ImportProcess;
use App\Entity\TableData;
use App\Messenger\Message\TableContentImporter;
use App\Service\Validator\ContentValidator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TableContentImporterHandler
{
    private EntityManagerInterface $entityManager;
    private iterable $contentValidators;

    public function __construct(EntityManagerInterface $entityManager, iterable $contentValidators)
    {
        $this->entityManager = $entityManager;
        $this->contentValidators = $contentValidators;
    }

    public function __invoke(TableContentImporter $message)
    {
        $importProcessId = $message->getImportProcessId();

        /** @var ImportProcess $importProcess */
        $importProcess = $this->entityManager->getRepository(ImportProcess::class)->find($importProcessId);

        /** @var ValidatorInterface $validator */
        foreach ($this->contentValidators as $validator) {
            $error = $validator->validate($message->getData());

            $tableData = new TableData();
            $tableData->setImportProcess($importProcess);
            $tableData->setRowId($message->getRowId());
            $tableData->setColId($validator->getListPosition());
            $tableData->setValue($message->getData()[$validator->getListPosition()]);

            if (is_null($error)) {
                $tableData->setValid(true);
            } else {
                $tableData->setValid(false);
                $tableData->setComment($error);
            }

            $this->entityManager->persist($tableData);
        }

        $this->entityManager->flush();
    }
}
