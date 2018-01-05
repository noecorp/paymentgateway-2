<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDebitTransaction extends Model
{
    //
    protected $table='user_debit_transactions';

	public function userDebitItems()
    {
        return $this->belongsToMany('App\Item','debit_transaction_items','debittransactionid','itemid')->withPivot('quantity','total')->withTimestamps();
    }

}
