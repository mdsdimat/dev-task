<?php

namespace App\Http\Controllers;

use App\Classes\Converter;
use App\Classes\InfoStorage;
use App\Loan;
use App\Payment;
use Illuminate\Http\Request;

class ConverterController extends Controller {
    public function index() {
        $infoStorage = new InfoStorage();
        $currencyList = $infoStorage->getRatesInfo();

        if (isset($currencyList->status) && $currencyList->status == 'error') {
            return view('welcome', [
                'error' => $currencyList->message
            ]);
        }

        //only for show tables
        $payments = Payment::all();
        $loans = Loan::all();

        return view('welcome', [
            'currencyList' => $currencyList,
            'payments' => $payments,
            'loans' => $loans
        ]);
    }

    public function convert(Request $request) {
        $converter = new Converter();
        $converter->currency = $request->get('currency');
        $converter->sum = $sum = $request->get('sum');
        $converter->type = $request->get('type');

        $result = $converter->doConvert();

        return json_encode(array(
            'status' => 'ok',
            'value' => $result,
        ));
    }
}
