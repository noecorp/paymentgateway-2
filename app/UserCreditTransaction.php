<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCreditTransaction extends Model
{
    //
    protected $table='user_credit_transactions';


     public function userCreditItems()
    {
        return $this->belongsToMany('App\Item','credit_transaction_items','credittransactionid','itemid')->withPivot('quantity','total')->withTimestamps();
    }

}
