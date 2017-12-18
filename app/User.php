<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    // deprecated relation
    public function oldmobiles(){
        return $this->hasMany('App\Mobileaccount','userid');

    }
    // deprecated relation
    public function oldbanks(){
        return $this->hasMany('App\Bankaccount','userid');

    }
    public function mobiles(){
        return $this->hasMany('App\UserMobileAccount','userid');

    }
    public function banks(){
        return $this->hasMany('App\UserBankAccount','userid');

    }
    // deprecated relation
    public function transactions(){
        return $this->hasMany('App\Transaction','userid');

    }

    public function creditTransactions()
    {
        return $this->belongsToMany('App\Customer','user_credit_transactions','userid','customerid')->withPivot('receiveaccountid','description','amount')->withTimestamps();
    }

    public function debitTransactions()
    {
        return $this->belongsToMany('App\Customer','user_debit_transactions','userid','customerid')->withPivot('payeraccountid','description','amount')->withTimestamps();
    }

     public function subscribers()
    {
        return $this->belongsToMany('App\Customer','subscriptions','userid','customerid')->withPivot('frequency','status','nextpayment','previoustime','chargeattempts')->withTimestamps();
    }
}
