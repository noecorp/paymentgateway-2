<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth,Response,DB;
use App\User;
use App\Mobileaccount;
use App\Transaction;
use App\Bankaccount;
use App\Customer;
use App\Hash;
use App\HashBankAccount;
use App\HashMobileAccount;
use App\Item;
use App\Subscription;
use App\UserBankAccount;
use App\UserCreditTransaction;
use App\UserDebitTransaction;
use App\UserMobileAccount;
use Nexmo\Laravel\Facade\Nexmo;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function getPhones(){
        $userid=Auth::user()->id;
        $mobile=UserMobileAccount::where("userid",$userid)->where("status","enable")->orderBy("id")->get();
        
        return Response::json($mobile);

    }
    public function storePhone(Request $request){
        $mobile= new UserMobileAccount;
        $mobile->companyname=$request->get("company");
        $mobile->phonenumber=$request->get("phonenumber");
        $mobile->status="enable";
        $mobile->userid=Auth::user()->id;
        $mobile->save();
        return Response::json("saved");
        
    }

    public function updatePhone(Request $request){
        $mobile=UserMobileAccount::where('userid',Auth::user()->id)->where("id",$request->get("id"))->first();
        
        $mobile->phonenumber=$request->get("phonenumber");
        $mobile->save();
        return Response::json("saved");

    }
    public function deletePhone(Request $request){
        $responsetext="not deleted";
        $mobile=UserMobileAccount::where("id",$request->get("id"))->first();
        if($mobile){
            $mobile->delete();
            $responsetext="deleted";
        }
        
        return Response::json($responsetext);
    }
    public function getTransactions(){
        $userid=Auth::user()->id;
        $transactions=Transaction::where("userid",$userid)->get();
        
        return Response::json($transactions);


    }

    public function changeAccountUsage(Request $request){
         $userid=Auth::user()->id;
         $user=User::where("id",$userid)->first();
         $user->accountpriorityusage=$request->get("accountusage");
         $user->save();

          return Response::json("saved");

    }
    public function getAccountUsage(){
        $userid=Auth::user()->id;
        $user=User::where("id",$userid)->first();
        
        return Response::json($user->accountpriorityusage);
    }
    public function updateCustomAccountPriority(Request $request){
        $userid=Auth::user()->id;
         
         $userbankaccount=UserMobileAccount::where("id",$request->get("mobileaccountid"))->first();
        
         $userbankaccount->custom=$request->get("custom");
        
        $userbankaccount->save();

    }
    public function getCustomAccountPriority(){
        $userid=Auth::user()->id;
         $user=User::where("id",$userid)->get();
         $userbankaccount=UserBankAccount::where("userid",$userid)->first();
        
       return Response::json($userbankaccount->custom);

      
    }
    public function updateClientAccountPriority(Request $request){

         $usermobileaccount=UserMobileAccount::where('id',$request->get('mobileaccountid'))->first();
          if($usermobileaccount->client==$request->get("client"))
            $usermobileaccount->client="";
          else 
          $usermobileaccount->client=$request->get("client");


        
         $usermobileaccount->save();
    }
    public function getClientAccountPriority(){
        $userid=Auth::user()->id;
         $user=User::where("id",$userid)->get();
         $usermobileaccount=UserBankAccount::where("userid",$userid)->get();
        
       return Response::json($usermobileaccount);


    }
   
    
    public function getAcccountBalances(){
        // pull from APNs' from mobile wallets to banks

    }
    public function getUserClients(){
        $userid=Auth::user()->id;
        $userclients = DB::table('oauth_clients')->where('user_id',$userid)->where("revoked",'f')->orderBy("id")->get();
        return Response::json($userclients);

    }
    
    public function getUserCreditTransactions(){
       
        $d=strtotime("-7 Days");
        $lastsevendays= date("Y-m-d h:i:sa", $d); 
       $user=User::find(Auth::user()->id);
       $vartransactionshowspan=$user->transactionshowspan;
       if($vartransactionshowspan==24*60*60){
        $usercredittrans = UserCreditTransaction::where("userid",$user->id)->whereDay("created_at",date('d'))->get();
       }else if($vartransactionshowspan==4*7*24*60*60){
        $usercredittrans = UserCreditTransaction::where("userid",$user->id)->whereBetween("created_at",date('d'),$lastsevendays)->get();
       }
       else if($vartransactionshowspan==4*7*24*60*60){
        $usercredittrans = UserCreditTransaction::where("userid",$user->id)->whereMonth("created_at",date('m'))->get();
       }else if($vartransactionshowspan==12*4*7*24*60*60){
        $usercredittrans = UserCreditTransaction::where("userid",$user->id)->whereYear("created_at",date('Y'))->get();

       }
        
       return Response::json($usercredittrans);

    }
    public function userCreditTransactionById(Request $request){

        $transaction = UserCreditTransaction::find($request->get("id"));
        return Response::json($transaction);
    }
    public function getUserDebitTransactions(){

        $userid=Auth::user()->id;

         $userdebittrans=UserDebitTransaction::where("userid",$userid)->get();
        
       return Response::json($userdebittrans);
    }
    public function getTransactionsShowSpan(){
        $user=User::find(Auth::user()->id);
        return Response::json($user->transactionshowspan);
    }
    public function updateTransactionShowSpan(Request $request){

        $user=User::find(Auth::user()->id);
        $user->transactionshowspan=$request->get("transactionshowspan");
        $user->save();
        return Response::json($user->transactionshowspan);
    }
    public function getUserMobileAccounts(){

        $userid=Auth::user()->id;

         $usermobileaccounts=UserMobileAccount::where("userid",$userid)->get();
        
       return Response::json($usermobileaccounts);
    }
    public function getUserBankAccounts(){

        $userid=Auth::user()->id;

         $userbankaccounts=UserBankAccount::where("userid",$userid)->get();
        
       return Response::json($userbankaccounts);

    }
    public function getUserCustomers(){

        $userid=Auth::user()->id;

         $usercustomers=Customer::where("userid",$userid)->get();
        
       return Response::json($usercustomers);
    }

    public function sendSMS(){

        // Nexmo::message()->send([
        //     'to'   => '+255684905873',
        //     'from' => 'ZATANA',
        //     'text' => 'ZATANA Co. enter temporary key 1274'
        //         ]);
        $okay="okay";
              
             return Response::json($okay);

    }
}
