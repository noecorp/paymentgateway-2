<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hash extends Model
{
    //
    public function mobiles(){
        return $this->hasMany('App\HashMobileAccount','hashid');

    }
    public function banks(){
        return $this->hasMany('App\HashBankAccount','hashid');

    }

    public function creditHashDebitUserTransactions()
    {
        return $this->belongsToMany('App\UserDebitTransaction','hash_credit_transactions','hashid','transactionidfrom')->withPivot('transactiontablefrom','amount')->withTimestamps();
    }
     public function creditHashCreditUserTransactions()
    {
        return $this->belongsToMany('App\UserCreditTransaction','hash_credit_transactions','hashid','transactionidfrom')->withPivot('transactiontablefrom','amount')->withTimestamps();
    }

}
