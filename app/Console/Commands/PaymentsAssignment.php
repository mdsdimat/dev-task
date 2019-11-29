<?php

namespace App\Console\Commands;

use App\Loan;
use App\Payment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PaymentsAssignment extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment-assignment:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Payment assignment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $payments = Payment::where('status', 'not_assigned')->orWhere('status', 'partially_assigned')->get();
        foreach ($payments as $payment) {
            $loans = Loan::where('loan_number', $payment->payment_info)->where('status', 'active')->get();
            foreach ($loans as $loan) {
                $diff = bccomp($loan->amount, $payment->amount);
                if ($diff == 0) {
                    $payment->status = 'assigned';
                    $payment->amount = bcsub($loan->amount, $payment->amount, 6);
                    $loan->status = 'paid';
                }
                if ($diff == -1) {
                    $payment->status = 'partially_assigned';
                    $payment->amount = bcsub($payment->amount, $loan->amount, 6);
                    $loan->status = 'paid';
                }
                if ($diff == 1) {
                    $payment->status = 'assigned';
                    $payment->amount = bcsub($loan->amount, $payment->amount, 6);
                }
                DB::transaction(function () use ($payment, $loan) {
                    $payment->save();
                    $loan->save();
                }, 3);
            }
        }
    }
}
