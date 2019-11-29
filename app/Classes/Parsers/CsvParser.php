<?php

namespace App\Classes\Parsers;


use App\Classes\Converter;

abstract class CsvParser {

    public $request, $parseData;

    public function parse(): void {
        //add validation
        $path = $this->request->file('file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $names = array_shift($data);
        foreach ($data as $key=>$value) {
            $rawValue = array_map('trim', $value);
            $data[$key] = array_combine($names, $rawValue);
        }
        $this->parseData = $data;
    }

    protected function convertEntityToUSD(array $entity): array {
        //check courses
        $converter = new Converter();
        $converter->currency = $entity['currency'];
        $converter->sum = $entity['amount'];
        $converter->type = 'sell';

        $entity['amount'] = $converter->doConvert();
        $entity['currency'] = 'USD';

        return $entity;
    }
}