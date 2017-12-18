
<template lang="html">
	<div id="mobilediv">

		<br>
		 <ul class="nav nav-tabs">

    <li class="active"><a data-toggle="tab" href="#home">Credit</a></li>
    <li><a data-toggle="tab" href="#menu1">Debit</a></li>
    <li><a data-toggle="tab" href="#menu2">Balance</a></li>
    <li class="pull-right"> <input type="text" v-model="searchtext" placeholder="search"></li>	
  </ul>
<button v-bind:class="selectdaily" v-on:click="updateTransactionShowSpan(spanday)">daily</button>
<button v-bind:class="selectweekly" v-on:click="updateTransactionShowSpan(spanweek)">weekly</button>
<button v-bind:class="selectmonthly" v-on:click="updateTransactionShowSpan(spanmonth)">monthly</button>
<button v-bind:class="selectyearly" v-on:click="updateTransactionShowSpan(spanyear)">yearly</button>
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>Credit</h3>
      <div class="container">   
  <table class="table table-hover">
    <thead>
      <tr >
      <!-- use name on from column -->
        <th>From</th>
        <th>Amount</th>
        <th>To</th>
        <th>Date</th>
        
      </tr>
    </thead>
    <tbody>
      <tr v-for="transaction in getUserCreditTrans" v-on:click="describeCreditTransaction(transaction)">

        <td v-for="customer in getUserCustomers" v-if="customer.id==transaction.customerid">{{customer.firstname}} {{customer.lastname}}</td>
        <td>{{transaction.amount}}</td>
        <td >
        <span v-for="mobile in getUserMobileAcc" v-if="mobile.id==transaction.receiveaccountid && transaction.accountreceivetype==typemobile"> {{mobile.phonenumber}}</span>
       	<span v-for="bank in getUserBankAcc" v-if="bank.id==transaction.receiveaccountid && transaction.accountreceivetype==typebank">{{bank.accountnumber}}</span>
        </td>
        <td>{{transaction.created_at}}</td>
       
     
      </tr>

    </tbody>
  </table>

      <div class="container list-group">
		    <span  class="list-group-item">
		    <h3 class="list-group-item-heading">Total Amount</h3>
		   <h4 class="list-group-item-heading ">{{totalmobile}}</h4>
		
		    </span>
		 
		</div>
</div>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>Debit</h3>
      <div class="container">   
  <table class="table table-hover">
    <thead>
      <tr >
        <th>From</th>
        <th>Amount</th>
        <th>To</th>
        <th>Date</th>
       
        
      </tr>
    </thead>
    <tbody>
      <tr v-for="transaction in getUserDebitTrans" v-on:click="describeCreditTransaction(transaction)" >
         <td v-for="customer in getUserCustomers" v-if="customer.id==transaction.customerid">{{customer.firstname}}{{customer.lastname}}</td>
        <td>{{transaction.amount}}</td>
        <td >
         <span v-for="mobile in getUserMobileAcc" v-if="mobile.id==transaction.receiveaccountid && transaction.accountreceivetype==typemobile"> {{mobile.phonenumber}}</span>
       	<span v-for="bank in getUserBankAcc" v-if="bank.id==transaction.receiveaccountid && transaction.accountreceivetype==typebank">{{bank.accountnumber}}</span>
        </td>
        <td>{{transaction.created_at}}</td>
       
      
      </tr>
     
    </tbody>
  </table>
  <div class="container list-group">
		    <span  class="list-group-item">
		    <h3 class="list-group-item-heading">Total Amount</h3>
		   <h4 class="list-group-item-heading ">{{totalbank}}</h4>
		
		    </span>
		 
		</div>
</div>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Balance</h3>
      <div class="container">   
  <span>Account Balances</span>
  <div class="container list-group">
		    <span  class="list-group-item">
		    <h3 class="list-group-item-heading">Total Amount</h3>
		   <h4 class="list-group-item-heading ">{{totalall}}</h4>
		
		    </span>
		 
		</div>
</div>
    </div>
    
  </div>
  <div id="id01" class="w3-modal" v-bind:style="{display:vardisplay}" >
  <div class="w3-modal-content" style="box-shadow: 30px 30px 15px #888888; ">
    <div class="w3-container">
      <span v-on:click="closeModal" 
      class="w3-button w3-display-topright">&times;</span>
      <div class="w3-container">
  <h2>Transaction Details</h2>
  <div class="list-group">
  <span v-for="customer in getUserCustomers" v-if="customer.id==modalcontent.customerid" class="list-group-item disabled"><h4><font style="bold">Customer Name: </font></h4>{{customer.firstname}} {{customer.secondname}} {{customer.lastname}}</span>
  <span ><h4><font style="bold">Amount Paid: </font></h4>{{modalcontent.amount}}</span>
  <span class="list-group-item"><h4><font style="bold">Recipient Account Number : </font></h4>
  	<span v-for="mobile in getUserMobileAcc" v-if="mobile.id==modalcontent.receiveaccountid && modalcontent.accountreceivetype==typemobile"> {{mobile.phonenumber}}</span>
  <span v-for="bank in getUserBankAcc" v-if="bank.id==modalcontent.receiveaccountid && modalcontent.accountreceivetype==typebank">{{bank.accountnumber}}</span>
  </span>
  <span ><h4><font style="bold">Transaction Date: </font></h4>{{modalcontent.created_at}}</span>
  <span class="list-group-item"><h4><font style="bold">Recipient Account Type: </font></h4>{{modalcontent.accountreceivetype}}</span>
  <span ><h4><font style="bold">Client Name: </font></h4>
  	<span v-for="customer in getUserCustomers" v-if="modalcontent.customerid==customer.id">
        <span v-for="client in getUserClients" v-if="client.id==customer.clientid">{{client.name}}
        </span>
        </span>
  </span>
  <span class="list-group-item"><h4><font style="bold">Customer Financier: </font></h4>
  	<span v-for="mobile in getUserMobileAcc" v-if="mobile.id==modalcontent.receiveaccountid && modalcontent.accountreceivetype==typemobile"> {{mobile.companyname}}</span>
        <span v-for="bank in getUserBankAcc" v-if="bank.id==modalcontent.receiveaccountid && modalcontent.accountreceivetype==typebank">{{bank.bankname}}</span>
  </span>
  <span ><h4><font style="bold">Transaction Description: </font></h4>{{modalcontent.description}}</span>
    
  </div>
  <div class="list-group list-group-horizontal">
    <button  class="btn btn-default btn-lg" v-bind:class="previousactive" v-on:click="previousCreditTransaction()">Previous</button> 
    <button class="btn btn-default btn-lg"v-bind:class="nextactive" v-on:click="nextCreditTransaction()">Next</button>
    
      </div>
</div>
      
    </div>
  </div>
</div>
</div>
	</div>

</template>
<script>

	export default{
		data(){
			return{
				totalmobile:0,
				totalbank:0,
				totalall:0,
				searchtext:"",
				Bankaccount:"Bank",
				Mobileaccount:"Mobile",
				currenttransaction:[],
				errors:[],
				databserespo:"no respo",
				usercustomers:[],
				userclients:[],
				usercredittransactions:[],
				userdebittransactions:[],
				usermobileaccounts:[],
				userbankaccounts:[],
				typemobile:"mobile",
				typebank:"bank",
				vardisplay:"",
				modalcontent:"",
				previousactive:"",
				nextactive:"",
				selectdaily:"btn btn-default btn-sm",
				selectweekly:"btn btn-default btn-sm",
				selectmonthly:"btn btn-default btn-sm",
				selectyearly:"btn btn-default btn-sm",
				spanday:24*60*60,
				spanweek:7*24*60*60,
				spanmonth:4*7*24*60*60,
				spanyear:12*4*7*24*60*60,
				spanvalue:0

				
				

			}
		},
		methods:{

			searchingTransations(keyword,transactionobject){
				
				var trans=[];
				$.each(transactionobject, function(key, value) {
				     if(value.payerphonenumber.indexOf(keyword)>=0||value.amount.indexOf(keyword)>=0||value.payeeaccounttype.toLowerCase().indexOf(keyword.toLowerCase())>=0){
					trans.push(value);
					}
				   });
				
				return trans;
			},
			getTransactionShowSpan:function(){
				
				 axios.get('/get/gettransactionsshowspan')
			    .then(response => {
			      
			      this.spanvalue=response.data;
			      if(this.spanvalue==this.spanday){
			      this.selectdaily="btn btn-primary btn-sm";      
			      this.selectweekly="btn btn-default btn-sm"; 
			      this.selectmonthly="btn btn-default btn-sm"; 
			      this.selectyearly="btn btn-default btn-sm"; 
			      }
				  if(this.spanvalue==this.spanweek){
			      this.selectdaily="btn btn-default btn-sm";      
			      this.selectweekly="btn btn-primary btn-sm"; 
			      this.selectmonthly="btn btn-default btn-sm"; 
			      this.selectyearly="btn btn-default btn-sm";  
			      }
				  if(this.spanvalue==this.spanmonth){
			      this.selectdaily="btn btn-default btn-sm";      
			      this.selectweekly="btn btn-default btn-sm"; 
			      this.selectmonthly="btn btn-primary btn-sm"; 
			      this.selectyearly="btn btn-default btn-sm"; 
			      }
			      if(this.spanvalue==this.spanyear){
			      this.selectdaily="btn btn-default btn-sm";      
			      this.selectweekly="btn btn-default btn-sm"; 
			      this.selectmonthly="btn btn-default btn-sm"; 
			      this.selectyearly="btn btn-primary btn-sm";
			      }


			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			},
			updateTransactionShowSpan:function(transhowspan){
				 axios.post('/update/transactionshowspan',{"transactionshowspan":transhowspan})
			    .then(response => {

			    	this.databserespo=response.data;
			    	 this.getTransactionShowSpan();
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })
						
			},
			previousCreditTransaction:function(){
				this.nextactive="";
			     this.previousactive="btn-primary active";
				axios.post('/get/usercredittransaction',{
			      "id":this.modalcontent.id-1}

			    )
			    .then(response => {

			    	this.modalcontent=response.data
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })
			},
			nextCreditTransaction:function(){
				this.nextactive="btn-primary active";
			      this.previousactive="";
				axios.post('/get/usercredittransaction',{
			      "id":this.modalcontent.id+1}

			    )
			    .then(response => {

			    	this.modalcontent=response.data
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })
			},
			describeCreditTransaction:function(transaction){
				console.log(transaction.id);
				this.vardisplay="block";
				this.modalcontent=transaction;
			},
			closeModal:function(){
				this.vardisplay="none";
			},
			getTotal:function(keyword,transactionobject){
				var total=0;
				$.each(transactionobject, function(key, value) {
				     if(value.payeeaccounttype.toLowerCase().indexOf(keyword.toLowerCase())>=0){
					total+=parseInt(value.amount);
					}
				   });
				
				return total;

			},
			totalAmount:function(transactionobject){
				var total=0;
				$.each(transactionobject, function(key, value) {
				    
					total+=parseInt(value.amount);
					
				   });
				
				return total;
			}

		},
		created(){
      		this.getTransactionShowSpan();
			
		},
		filters:{


		},
		watch:{
			searchtext:function(){
			// this.currenttransaction=this.currenttransaction.filter(function(tran){
   //      	if(this.searchtext=="mobile"){
   //      		false;
   //      	}
   //      	});

			}
			
		},
		computed:{
			currentTransaction: function(){
				 axios.get('/get/transactions')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.currenttransaction = response.data
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })
       			if(this.searchtext.length>=1){
       				this.currenttransaction=this.searchingTransations(this.searchtext,this.currenttransaction)
   				
   				}
   				this.totalmobile=this.getTotal("mobile",this.currenttransaction);
   				this.totalbank=this.getTotal("bank",this.currenttransaction);
   				this.totalall=this.totalbank+this.totalmobile;
			    return this.currenttransaction;

			},
			getUserClients:function(){
				 axios.get('/get/userclients')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.userclients = response.data
			      
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			     return this.userclients;
			},
			getUserCustomers:function(){
				 axios.get('/get/usercustomers')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.usercustomers = response.data
			      
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			     return this.usercustomers;
			},
			getUserCreditTrans:function(){
				 axios.get('/get/credittransactions')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.usercredittransactions = response.data
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })
			    this.totalmobile=this.totalAmount(this.usercredittransactions);
			     return this.usercredittransactions;
			},
			getUserDebitTrans:function(){
				 axios.get('/get/debittransactions')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.userdebittransactions = response.data
			      
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			     return this.userdebittransactions;
			},
			getUserMobileAcc:function(){
				 axios.get('/get/usermobileaccounts')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.usermobileaccounts = response.data
			      
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			     return this.usermobileaccounts;
			},
			getUserBankAcc:function(){
				 axios.get('/get/userbankaccounts')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.userbankaccounts = response.data
			      
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			     return this.userbankaccounts;
			}

		}

	}
</script>
<style lang="css">

#spanlistphones:hover{
background-color: #05aae6;
}	
.tab-pane.fade{
	max-height: 300px;
	overflow-y: auto;
	overflow-x: auto;


}
.list-group-horizontal .list-group-item {
    display: inline-block;
}
.list-group-horizontal .list-group-item {
	margin-bottom: 0;
	margin-left:-4px;
	margin-right: 0;
}
.list-group-horizontal .list-group-item:first-child {
	border-top-right-radius:0;
	border-bottom-left-radius:4px;
}
.list-group-horizontal .list-group-item:last-child {
	border-top-right-radius:4px;
	border-bottom-left-radius:0;
}


</style>