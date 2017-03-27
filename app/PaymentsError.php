<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentsError extends Model
{
    protected $table = 'payments_error';

    protected $fillable = [
        'payment',
        'errors',
        'type',
        'check',
    ];


    public function createError($payment, $message)
    {

        $this->type = 'error';
        $this->errors = $message;
        $this->payment = $payment;

        $this->save();

    }
}
