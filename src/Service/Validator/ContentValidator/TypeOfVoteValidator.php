<?php

namespace App\Service\Validator\ContentValidator;

class TypeOfVoteValidator implements ValidatorInterface
{
    public function getListPosition(): int
    {
        return 12;
    }

    public function validate(array $data): ?string
    {
        $definedValues = [
            'Appointment of commissioners',
            'Appointment of the Juncker Commission',
            'Draft legislative resolution',
            'Draft recomandation',
            'European Parliament recommendation',
            'Explanatory statement - summary of facts and findings',
            'Joint motion for resolution',
            'Joint Motions for a resolution',
            'Legislative resolution',
            'Motion for resolution',
            'Proposal for a decision',
        ];

        return in_array($data[$this->getListPosition()], $definedValues) ? null : $this->getErrorMessage();
    }

    public function getErrorMessage(): string
    {
        return 'This value is not allowed';
    }
}
