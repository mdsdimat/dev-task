<?php

namespace App\Classes\Parsers;


use App\Http\Requests\ImportRequest;
use App\Interfaces\CsvParserInterface;
use App\Loan;

class LoansCsvParser extends CsvParser implements CsvParserInterface {

    public $request, $parseData;

    /**
     * LoansCsvParser constructor.
     * @param $request
     */
    public function __construct(ImportRequest $request) {
        $this->request = $request;
    }

    public function saveToDatabase(): void {
        $arrayToaSave = array();
        foreach ($this->parseData as $entity) {
            $loan = array();

            if ($entity['currency'] !== 'USD') {
                $entity = $this->convertEntityToUSD($entity);
            }

            $loan['loan_number'] = $entity['loan_number'];
            $loan['amount'] = $entity['amount'];
            $loan['currency'] = $entity['currency'];
            //create directory for status
            $loan['status'] = 'active';
            array_push($arrayToaSave, $loan);

        }
        Loan::insert($arrayToaSave);

    }
}