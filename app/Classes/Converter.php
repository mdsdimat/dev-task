<?php

namespace App\Classes;


class Converter {

    public $currency;
    public $sum;
    public $type;

    public function doConvert(): string {
        $infoStorage = new InfoStorage();
        $currencyList = $infoStorage->getRatesInfo();

        $currency = $this->currency;
        $currencyVal = $currencyList->rates->$currency;

        $result = '';
        if ($this->type == 'buy') {
            $result = bcmul($currencyVal, $this->sum, 6);
        } elseif ($this->type == 'sell') {
            $result = bcdiv($this->sum, $currencyVal, 6);
        }

        return $result;
    }


}