<?php

namespace App\Service\Validator;

class TableStructureValidator
{
    public const DEFINED_COLUMNS = [
        'Vote ID',
        'File',
        'Order of vote',
        'Date',
        'O\'clock',
        'Title',
        'Title_Ro',
        'Title_Fr',
        'Title_German',
        'Title_Polski',
        'Procedure',
        'Leg/Non-Leg/Bud',
        'Type of Vote',
        'Voting Rule',
        'Rapporteur',
        'Code',
        'interinstitutional file number',
        'Link',
        'Committee responsabile',
        'Policy area',
        'Part',
        'Subject',
        'Subject_ro',
        'Subject_fr',
        'Subject_ger',
        'Subject_pl',
        "Final \nvote?",
        'Am No.',
        'Author',
        'RCV',
        'Vote',
        'Yeas',
        'No',
        'Abs',
        'Pro content',
    ];

    public function validate(array $columns): array
    {
        $columns = $columns[0];

        $errorMessages = [];

        $diff = array_diff($columns, self::DEFINED_COLUMNS);

        if (0 !== count($diff)) {
            $errorMessages[] = 'Columns "'. implode(', ', $diff) . '" found but not expected';
        }

        $diff2 = array_diff(self::DEFINED_COLUMNS, $columns);

        if (0 !== count($diff2)) {
            $errorMessages[] = 'Columns "'. implode(', ', $diff2) . '" expected but not found';
        }

        return $errorMessages;
    }
}
