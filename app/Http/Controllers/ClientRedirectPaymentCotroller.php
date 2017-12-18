<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth,Response,DB,Redirect,Exception;
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

class ClientRedirectPaymentCotroller extends Controller
{
    //
    public function __construct(){
        $this->middleware('cors');

    }

    public function redirectLoading(){

    	    return view('loading');

    }

    public function redirectCheckoutform(Request $request){
    	error_log('sid:: '.$request->firstname);
    	 $data = ['windowUrl' => "http://192.168.43.80:1334/api/checkout/".$request->sid,
              'title' => 'checkout'
              ];

     return Response::json($data);

    }

    public function redirectCheckoutformUserDetails(Request $request){
    	 error_log('message here.'.$request->phonenumber);
    	 error_log('message sid.'.$request->sid);
 
		    $verification = Nexmo::verify()->start([
		    'number' => '+255684905873',
		    'brand'  => 'ZATANA co'
		]);

		    // $request->session()->put('request_id', $verification->getRequestId());
		  // session(['request_id'=> $verification->getRequestId()]);
		session(['request_id'=>'test10122']);
		error_log('store session key =>'.$verification->getRequestId());

		DB::table('request_verify')->insert(
    ['clientid' => $request->sid, 'otprequestid' => $verification->getRequestId(),'phonenumber' => $request->phonenumber]
		);
		  $data = ['url' => "http://192.168.43.80:1334/api/checkout_verifyOTP/".$request->phonenumber.'/'.$request->sid.'/new',
		              ];
     return Response::json($data);
    }


    public function redirectCheckoutformVerifyOTP(Request $request){
		 error_log('message OTP.'.$request->otp);
		 error_log('message Phone.'.$request->phonenumber);
		 error_log('message cid.'.$request->cid);

	    $data = ['url' => "http://192.168.43.80:1334/api/checkout_password/".$request->otp,
	              ];

	    $results = DB::table('request_verify')->select('id', 'otprequestid')->where('clientid',$request->cid)->where('phonenumber',$request->phonenumber)->first();
	    
	    if(!empty($results)){
	    	error_log('get session key =>'.$results->otprequestid);
	    try {
	        Nexmo::verify()->check(
	            $results->otprequestid,
	            $request->otp
	        );
	        $data = ['url' => "http://192.168.43.80:1334/api/checkout_password/".$request->otp,
	              ];

	     DB::table('request_verify')->where('id', $results->id)->delete();
	     error_log('verified and deleted');

	     return Response::json($data);
	    } catch (Exception $e) {
	    	 error_log('inside exception.'.$request->phonenumber);

	    	 error_log('number .'.$request->phonenumber);

	    	error_log('not verified not deleted GOBACK');
	    	$data = ['url' => "http://192.168.43.80:1334/api/checkout_verifyOTP/".$request->phonenumber.'/'.$request->cid.'/old',
		              ];
     		return Response::json($data);
	    	// return redirect()->route('view.checkout_verifyOTP',['id' => $results->phonenumber]);
	        // return redirect()->back()->withErrors([
	        //     'code' => $e->getMessage()
	        // ]);
	 
	    }

	    }else error_log('not verified and deleted');

	  

    }

    public function redirectCheckoutformPassword(Request $request){

    	    return redirect('/')->with('id','something');

    }

    public function viewCheckout($param){
    		$sid=$param;
    		error_log("view checkout sid".$sid);
    	    return view('checkout',compact('sid'));


    }
    public function viewCheckoutVerifyOTP($param1,$param2,$param3){
    		$cid=$param2;
    		$phone=$param1;
    		$error=$param3;
    	    return view('checkout_verifyOTP',compact('cid','phone','error'));


    }
    public function viewCheckoutPassword(){

    	    return view('checkout_password');

    }
}
