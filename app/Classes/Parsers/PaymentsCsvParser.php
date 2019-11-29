<?php

namespace App\Classes\Parsers;


use App\Http\Requests\ImportRequest;
use App\Interfaces\CsvParserInterface;
use App\Payment;

class PaymentsCsvParser extends CsvParser implements CsvParserInterface {

    public $request, $parseData;

    /**
     * PaymentsCsvParser constructor.
     * @param $request
     */
    public function __construct(ImportRequest $request) {
        $this->request = $request;
    }

    public function saveToDatabase(): void {
        $arrayToaSave = array();
        foreach ($this->parseData as $entity) {
            $payment = array();

            if ($entity['currency'] !== 'USD') {
               $entity = $this->convertEntityToUSD($entity);
            }

            $payment['payment_number'] = $entity['payment_number'];
            $payment['amount'] = $entity['amount'];
            $payment['currency'] = $entity['currency'];
            $payment['payment_info'] = $entity['payment_info'];
            //create directory for status
            $payment['status'] = 'not_assigned';

            array_push($arrayToaSave, $payment);
        }

        Payment::insert($arrayToaSave);
    }
}