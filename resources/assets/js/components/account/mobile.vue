
<template lang="html">
	<div id="mobilediv">
		<input type="text" v-model="phonenumber" placeholder="Enter phone to add">
		{{progresstext}}<br>
		<div id="phones">
			<div class="list-group" v-bind:id="rotate">
		    <span id="spanlistphones" class="list-group-item" v-for="phone in currentMobile"  v-on:mouseover="showTrash" v-on:mouseleave="hideTrash">
		    
		      <h4 class="list-group-item-heading">{{phone.companyname}}</h4> 
		      <i id="trashphone" class="fa fa-trash pull-right w3-xlarge w3-teal"  v-if="showtrash" v-on:click="deletePhone(phone)"></i>
		      <p class="list-group-item-text" v-if="!editaccount" v-on:click="editPhone(phone.phonenumber,phone.id)">{{phone.phonenumber}}</p>
		      <input type="text" name="" v-model="phonetoedit" v-else-if="editphoneid==phone.id" v-on:dblclick="updatePhone(phonetoedit,phone.id)">
		      <span class="stars "  v-if="accountusageselection==custom">
          <i v-for="numberofstars in numberofstars" class="glyphicon glyphicon-star" style="color:blue;" v-if="numberofstars<=phone.custom" v-on:click="updateCustomPriority(numberofstars,phone.id)"></i>
          <i v-for="numberofstars in numberofstars" class="glyphicon glyphicon-star" style="color:gold;" v-if="numberofstars>phone.custom" v-on:click="updateCustomPriority(numberofstars,phone.id)"></i>
            </span>
            <span v-if="accountusageselection==client">
            <button v-for="client in getUserClients" class="btn btn-default btn-sm" v-on:click="updateClientPriority(client.name,phone.id)" v-if="limitClient(client.name,phone.id)">{{client.id}}</button>
            </span>
            <p class="pull-right" style="box-shadow: 0px 2px 5px #888888; width:80px;" v-if="accountusageselection==client">{{phone.client}}</p>
		    </span>
		   
		  </div>
		  
		</div>
		<div  style="box-shadow: 10px 10px 5px #888888; width:80px;" v-bind:class="selectpriority" v-on:click="updateAccountUsage(accountusagekeycustom)">
		priority	 
		</div>
		<div  style="box-shadow: 10px 10px 5px #888888; width:80px;" v-bind:class="selectclient" v-on:click="updateAccountUsage(accountusagekeyclient)">
		client	 
		</div>
		<div  style="box-shadow: 10px 10px 5px #888888; width:80px;" v-bind:class="selecttype" v-on:click="updateAccountUsage(accountusagekeytype)">
		type	 
		</div>
		<div class="btn btn-default btn-lg pull-right" style="box-shadow: 10px 10px 5px #888888; width:50px;" v-on:click="hashPay()">
		pay	 
		</div>
		<br>
		<!-- <button class="btn btn-primary" v-on:click="storeData">test</button>
		<br>{{databserespo}} -->

	</div>
</template>
<script>
	export default{
		data(){
			return{
				mpesacodes:["0754","0755","0767"],
				airtelmoneycodes:["0684","0787","0789"],
				tigopesacodes:["0655","0654"],
				currentmobile:[],
				errors:[],
				databserespo:"no respo",
				showtrash:false,
				editphoneinput:'',
				phonenumber:"",
				mobilecompany:"",
				progresstext:'',
				numberofstars:5,
				clickstar:1,
				rotate:"",
				accountusage:"",
				custompriority:1,
				clientpriority:"",
				crdeittransaction:[],
				debittransactions:[],
				accountbalance:0,
				selectpriority:"btn btn-default btn-lg",
				selectclient:"btn btn-default btn-lg",
				selecttype:"btn btn-default btn-lg",
				accountusagekeycustom:{"accountusage":"custom"},
				accountusagekeytype:{"accountusage":"type"},
				accountusagekeyclient:{"accountusage":"client"},
				accountusageselection:"",
				custom:"custom",
				client:"client",
				userclients:[],
				editaccount:false,
				phonetoedit:"",
				editphoneid:0


			}
		},
		methods:{
			showProgress:_.debounce(function(){
				this.progresstext="Adding Account";
				this.getMobileCompany();

			},1000),
			getMobileCompany:_.debounce(function(){
				this.progresstext="";
				this.mobilecompany=this.getCompanyCode(this.phonenumber);
				if(this.mobilecompany){
					if(this.phonenumber.length==10){
				this.storeInputData({"company":this.mobilecompany,"phonenumber":this.phonenumber})

				}
				
			}
				

			},1000),
			selectStar:function(starpos){
				this.clickstar=starpos;
			},
			editPhone:function(){
				if(this.editbool){
				this.editphoneinput='<input type="text" v-model="phonenumber" placeholder="">';
				this.editbool=false;
				}else{
					this.editphoneinput="edited";
					this.editbool=true;
				}
			},
			editPhone:function(phone,id){
				this.editaccount=true;
				this.phonetoedit=phone;
				this.editphoneid=id;
			},
			updatePhone:function(phone,phoneid){
				this.editaccount=false;
				this.phonetoedit=phone;
				axios.post('/update/phonenumber',{
			      "phonenumber":phone,"id":phoneid}
			    )
			    .then(response => {

			    	this.databserespo=response.data
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })
			},
			hashPay:function(){
				this.rotate="";
				this.rotate="rotate";

				 axios.get('/sendsms')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.custompriority = response.data
			      
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			},
			
			limitClient:function(clientname,accountid){
				var state=true;
				$.each(this.currentMobile, function(key, value) {
				     if(value.client==clientname&&value.id!=accountid){
				     	state=false;
				     }
				   });
				
				return state;

			},
			
			getAccountUsage: function(){
				 axios.get('/get/accountusage')
			    .then(response => {
			      
			      this.databserespo=response.data;
			       this.accountusageselection=response.data;
			      if(this.databserespo=="type"){
			      this.selecttype="btn btn-primary btn-lg";      
			      this.selectclient="btn btn-default btn-lg"; 
			      this.selectpriority="btn btn-default btn-lg"; 
			      }
				  if(this.databserespo=="custom"){
			      this.selectpriority="btn btn-primary btn-lg";
			      this.selecttype="btn btn-default btn-lg"; 
			      this.selectclient="btn btn-default btn-lg"; 
			      }
				  if(this.databserespo=="client"){
			      this.selectclient="btn btn-primary btn-lg";
			      this.selectpriority="btn btn-default btn-lg"; 
			      this.selecttype="btn btn-default btn-lg"; 
			      }

			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			    // return this.currentmobile;

			},
			getCustomPriority: function(){
				 axios.get('/get/phones')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.custompriority = response.data
			      
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			    // return this.currentmobile;

			},
			getClientPriority: function(){
				 axios.get('/get/phones')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.clientpriority = response.data
			      
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			    // return this.currentmobile;

			},
			
			getCreditTransactions: function(){
				 axios.get('/get/phones')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.crdeittransaction = response.data
			      
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			    // return this.currentmobile;

			},
			getDebitTransactions: function(){
				 axios.get('/get/phones')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.debittransactions = response.data
			      
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			    // return this.currentmobile;

			},
			getAccountBalances: function(){
				 axios.get('/get/phones')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.accountbalance = response.data
			      
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			    // return this.currentmobile;

			},
			updateClientPriority:function(clientpriority,accountid){
				 axios.post('/update/clientpriority',{
			      "client":clientpriority,"mobileaccountid":accountid}
			    )
			    .then(response => {

			    	this.databserespo=response.data
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })
						
			},
			updateCustomPriority:function(custompriority,accountid){
				 axios.post('/update/custompriority',{
			      "custom":custompriority,"mobileaccountid":accountid}
			   )
			    .then(response => {

			    	this.databserespo=response.data
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })
						
			},
			updateAccountUsage:function(accountusage){
				 axios.post('/update/accountusage',accountusage)
			    .then(response => {

			    	this.databserespo=response.data;
			    	this.getAccountUsage();
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })
						
			},
			storeData:function(){
				 axios.post('/store/phone', {
			      "company":"voda","phonenumber":"0754619721"
			    })
			    .then(response => {

			    	this.databserespo=response.data
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })
						
			},
			storeInputData:function(inputdata){
				 axios.post('/store/phone', inputdata)
			    .then(response => {

			    	this.databserespo=response.data
			    	this.phonenumber="";
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })
						
			},
			deletePhone:function(phone){
				// var tobesent={"id":phone.id}
				axios.delete('/delete/phone', {data:phone})
			    .then(response => {

			    	this.databserespo=response.data
			    	// alert(this.databserespo);
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			},
			showTrash:function(){
				this.showtrash=true;
			},
			hideTrash:function(){
				this.showtrash=false;
			},getCompanyCode: function(phone){

				var ccode="";
				if(phone.startsWith("+255")){
					phone=phone.replace("+255","0");
				}else if(phone.startsWith("255")){
					phone=phone.replace("255","0");
				}
				
				for(var codes in this.mpesacodes){
					if(phone.startsWith(this.mpesacodes[codes]))
					ccode="Voda Mpesa";
				}

				for(var codes in this.airtelmoneycodes){
					if(phone.startsWith(this.airtelmoneycodes[codes]))
					ccode="Airtel Money";
				}

				for(var codes in this.tigopesacodes){
					if(phone.startsWith(this.tigopesacodes[codes]))
					ccode="Tigo Pesa";
				}
				return ccode;
			}

		},
		created(){
			// alert("welcome");
      		this.getAccountUsage();
			
		}
 		,
		filters:{


		},
		watch:{
			phonenumber:function(){
				this.mobilecompany="";
				this.progresstext="";
				if(this.phonenumber.length==10){
				this.showProgress();
			}
			}
			
		},
		computed:{
			currentMobile: function(){
				 axios.get('/get/phones')
			    .then(response => {
			      // JSON responses are automatically parsed.
			      this.currentmobile = response.data
			      
			    })
			    .catch(e => {
			      this.errors.push(e)
			    })

			    return this.currentmobile;

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
			}

		}

	}
</script>
<style lang="css">

#spanlistphones:hover{
background-color: #05aae6;
}	

#rotate {
    /*-webkit-transform: rotateY(180deg);  Safari 
    transform: rotateY(180deg);*/
   /*  width: 100px;
    height: 100px;
    position: relative;
    background-color: red;
    animation-name: example;
    animation-duration: 4s;
    animation-delay: 2s;*/
}

</style>