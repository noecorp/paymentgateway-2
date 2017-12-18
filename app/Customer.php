<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //

    public function debitTransactions()
    {
        return $this->belongsToMany('App\User','user_credit_transactions','customerid','userid')->withPivot('receiveaccountid','description','amount')->withTimestamps();
    }

    public function creditTransactions()
    {
        return $this->belongsToMany('App\User','user_debit_transactions','customerid','userid')->withPivot('payeraccountid','description','amount')->withTimestamps();
    }

     public function subscriberTo() 
    {
        return $this->belongsToMany('App\User','subscriptions','customerid','userid')->withPivot('frequency','status','nextpayment','previoustime','chargeattempts')->withTimestamps();
    }
}
