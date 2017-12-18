<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //
   	
    public function items()
    {
        return $this->belongsToMany('App\Item','subscription_items','subscriptionid','itemid')->withPivot('frequency','status','nextpayment','previoustime','chargeattempts')->withTimestamps();
    }
}
