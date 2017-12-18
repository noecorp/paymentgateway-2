<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    public function subscribers()
    {
        return $this->belongsToMany('App\Subscription','subscription_items','itemid','subscriptionid')->withPivot('frequency','status','nextpayment','previoustime','chargeattempts')->withTimestamps();
    }

    public function itemDebitUsers()
    {
        return $this->belongsToMany('App\UserDebitTransaction','debit_transaction_items','itemid','debittransactionid')->withPivot('quantity','total')->withTimestamps();
    }
     public function itemCreditUsers()
    {
        return $this->belongsToMany('App\UserCreditTransaction','credit_transaction_items','itemid','credittransactionid')->withPivot('quantity','total')->withTimestamps();
    }

}
