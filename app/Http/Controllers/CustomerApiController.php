<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
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
use App\HashCreditTransaction;


class CustomerApiController extends Controller
{
    //
    public function __construct(){
        $this->middleware('cors');

    }

	public function sample(){

		  // request
		 $sampletigoresponse= "<?xml version='1.0'?>
		  <COMMAND>	
		 <TYPE>RESMFICI</TYPE>	 	
		  <REFERENCEID>REFERENCEID</REFERENCEID>	  	
		  <TXNID>42326232</TXNID>	
		  <TXNSTATUS>200</TXNSTATUS>	 	
		  <MESSAGE>Success</MESSAGE>	
		  </COMMAND>";

		$xml=$this->tigoXmlParse($sampletigoresponse);
		$type=$this->tigoXmlGen("referenceid","senderno","receiverno","pin","amount","language","REQMFICI");
		$type=$this->postXml($type,'/sample/testxml');
		return view("sample",compact("type"));

	}
	public function tigoXmlGen($referenceid,$senderno,$receiverno,$pin,$amount,$language,$type="REQMFICI"){
		$newsXML = new \SimpleXMLElement("<COMMAND></COMMAND>");
		$newsIntro = $newsXML->addChild('TYPE',$type);
		$newsIntro = $newsXML->addChild('REFERENCEID',$referenceid);
		$newsIntro = $newsXML->addChild('MSISDN',$senderno);
		$newsIntro = $newsXML->addChild('PIN',$pin);
		$newsIntro = $newsXML->addChild('MSISDN1',$receiverno);
		$newsIntro = $newsXML->addChild('AMOUNT',$amount);
		$newsIntro = $newsXML->addChild('LANGUAGE1',$language);
		Header('Content-type: text/xml');
		return $newsXML->asXML();
	}

	public function tigoXmlParse($samplerequest){
	  if(is_string($samplerequest)){
	  	$xml=simplexml_load_string($samplerequest) or die("Error: Cannot create object");
	  }else{
		$xml=simplexml_load_file($samplerequest) or die("Error: Cannot create object");
	  }
	return $xml;

	}
	public function isCustomer($firstname,$secondname,$lastname,$accountnumber,$accounttype,$clientid){
		error_log("check customer");
		
		$customer=Customer::where("firstname",strtolower($firstname))->where("secondname",strtolower($secondname))->where("lastname",strtolower($lastname))->where("accountnumber",$accountnumber)->where("accounttype",strtolower($accounttype))->where("clientid",$clientid)->get();
		return empty($customer);
		
	}
	public function registerCustomer($firstname,$secondname,$lastname,$accountnumber,$companyname,$clientid){
		
		if(!$this->isCustomer($firstname,$secondname,$lastname,$accountnumber,$companyname,$clientid)){
			error_log("registering customer");
			$customer = new Customer;
			$customer->firstname = strtolower($firstname);
			$customer->secondname = strtolower($secondname);
			$customer->lastname = strtolower($lastname);
			// account number has to be unique
			$customer->accountnumber = $accountnumber;

			$customer->accounttype = strtolower($companyname);
			// account type here implie compnay name eg mpesa,crdb
			$customer->clientid = $clientid;

			$clientrow = DB::table('oauth_clients')->where('id',$clientid)->first();

			$customer->userid =$clientrow->user_id;

			$customer->save();

			error_log("customer registered id:="+$customer->id);
			return $customer;
		}else{
			error_log("customer present");
			 $customer=Customer::where("firstname",strtolower($firstname))->where("secondname",strtolower($secondname))->where("lastname",strtolower($lastname))->where("accountnumber",$accountnumber)->where("accounttype",strtolower($companyname))->where("clientid",$clientid)->first();
			 return $customer;
		}
		 

	}
	public function getAcountToReceivePayment($accounttype,$clientid,$companyname){
		error_log("find account receiver");
		$clientrow = DB::table('oauth_clients')->where('id',$clientid)->first();
		$user= User::where("id",$clientrow->user_id)->first();
		$account = array();
		if($user->accountpriorityusage=="custom"){
			if($accounttype=="mobile"){
		$maxval=UserMobileAccount::where("userid",$clientrow->user_id)->max("custom");
		$account=UserMobileAccount::where("userid",$clientrow->user_id)->where("custom",$maxval)->first();
			}else if($accounttype=="bank"){
		$maxval=UserBankAccount::where("userid",$clientrow->user_id)->max("custom");
		$account=UserBankAccount::where("userid",$clientrow->user_id)->where("custom",$maxval)->first();
			}
		}else if($user->accountpriorityusage=="client"){
			if($accounttype=="mobile"){
		$account=UserMobileAccount::where("userid",$clientrow->user_id)->where("client",$clientrow->name)->first();
			}else if($accounttype=="bank"){
		$account=UserBankAccount::where("userid",$clientrow->user_id)->where("client",$clientrow->name)->first();
			}

		}else if($user->accountpriorityusage=="type"){
			if($accounttype=="mobile"){
		$account=UserMobileAccount::where("userid",$clientrow->user_id)->where("companyname",$companyname)->first();
			}else if($accounttype=="bank"){
		$account=UserBankAccount::where("userid",$clientrow->user_id)->where("bankname",$companyname)->first();	
			}

		}
		error_log("account reeiver found:id="+$maxval);
		return $account;
	}
	public function payHash(){
		// if hash payment via api is successfull
		return true;
	}
	public function payUser(){
		// if user payment via api is successfull
		return true;
	}
	public function logUserCreditTransaction($receiveraccount,$amount,$description,$customer,$accounttype){
		error_log("log transactions3");

		$hashamount=(2*$amount)/100;
		$useramount=$amount-$hashamount;

		$usercredittransaction= new UserCreditTransaction;
		error_log($receiveraccount->id);
		$usercredittransaction->customerid=$customer->id;
		$usercredittransaction->receiveaccountid=$receiveraccount->id;
		$usercredittransaction->amount=$useramount;
		$usercredittransaction->description=$description;
		$usercredittransaction->userid=$customer->userid;
		$usercredittransaction->accountreceivetype=$accounttype;

		$usercredittransaction->save();

		$hashcredittransaction= new HashCreditTransaction;

		// $hash=Hash::orderBy('id', 'desc')->first();
		
		// should be hash->id 
		$hashcredittransaction->hashid=1;
		$hashcredittransaction->transactionidfrom=$usercredittransaction->id;
		$hashcredittransaction->transactiontablefrom="usercredittransactions";
		$hashcredittransaction->amount=$hashamount;
		$hashcredittransaction->accountreceivetype=$accounttype;
		$hashcredittransaction->save();

	}
	public function logUserDebitTransaction(){

	}

	public function customerPay(Request $request){
		error_log("new server hit");
		$customer=$this->registerCustomer($request->get("firstname"),$request->get("secondname"),$request->get("lastname"),$request->get("accountnumber"),$request->get("companyname"),$request->get("clientid"));
		error_log("customer created");
		$account=$this->getAcountToReceivePayment($request->get("accounttype"),$request->get("clientid"),$request->get("companyname"));
		error_log("account acquired");
		// pay user and hash

		// the log the transaction
		$this->logUserCreditTransaction($account,(float)$request->get("amount"),$request->get("description"),$customer,$request->get("accounttype"));
		error_log("transaction loged");
		return Response::json("success");

	}

    public function oldcustomerPay(Request $request){
    	 $respotext="error";
    	 error_log("server hit");
    	if($this->phoneParse($request->get("phonenumber"))!="invalid"){
    	$transaction= new Transaction;
        $transaction->amount=$request->get("amount");
        $transaction->payerphonenumber=$request->get("phonenumber");
        // need to solve how to get userid from client access token authentification
     // begin modification
        $urlclient=$request->url();
        error_log($urlclient);

        $clientid=$request->get('clientid');
        error_log($clientid);
  //       $accesstoken=$request->header('Authorization');

  //       $accesstoken=str_replace("Bearer", "",$accesstoken);

  //       // $accesstoken=preg_replace('/\s+/', '', $accesstoken);
  //       error_log($accesstoken);

  //       $clientids = DB::table('oauth_access_tokens')->select('client_id','id')->get();

  //       foreach ($clientids as $tempclientid) {
  //       	if(strpos($accesstoken, $tempclientid->id)){
  //       		$clientid=$tempclientid->client_id;
  //       		break;
  //       	}
        	    
  //       // error_log($tempclientid->id);
  //      		}
        
		// error_log($clientid);        
        $userid = DB::table('oauth_clients')->where('id',$clientid)->first();
        error_log($userid->user_id);

// end modification

        $transaction->userid=$userid->user_id;
        $transaction->payeeaccounttype="Mobile";
        $mobile=Mobileaccount::orderBy("id","desc")->first();
        $transaction->payeeaccountid=$mobile->id;
        $transaction->save();
        $respotext="saved";
        error_log("reached saved");
    	}
    	
        return Response::json($respotext);

    }
    public function OTPResponseControl(){

    }
    public function customerPayment(){

    	//find appropriate account to credit the user 
    	// also find appropriate account to credit hash
    	// do the neccessary math and then update the respective accounts

    	// send back a response for confirmation of the transaction
    }
    public function customerRollbackPayment(){

    	
    }

    public function customerSubscribe(){

    }
    public function customerEndSubscription(){

    }

    public function customerTransferCash(){

    }

	public function customerRollbackTransfer(){


	}    

    public function phoneParse($phone){
    	if(strpos($phone, "+255")){
    		$phone=str_replace("+255", "0",$phone);
    	}
    	
    	if(strlen($phone)==10 ){
    		return $phone;
    	}else{
    		return "invalid";
    	}
    }
    public function postXml($xmldata,$uri){
    	// $xml2=simplexml_load_string($xml) or die("Error: Cannot create object");
		
		$client = new Client(['base_uri'=>'http://192.168.43.80:1334']);
		//dfhnk
		$response=$client->post($uri,['form_params'=>['xml'=>$xmldata]]);
		// $response = $client->send($request);
		//$code = $response->getStatusCode(); // 200
		//$reason = $response->getReasonPhrase(); // OK
		 return $response->getBody();
    }
    public function xmlTestReceive(Request $request){
    	$xmlreceived=$this->tigoXmlParse($request->get("xml"));
    	if($xmlreceived){
    		// $type=$xmlreceived->MESSAGE;
    		Response::json($respotext);

    		return response('Hello World', 200)
                  ->header('Content-Type', 'text/plain');
    	}else {
    		return response('Error', 200)
                  ->header('Content-Type', 'text/plain');
    	}
    }
}
     