<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateServiceContact() : createServiceContact()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                            <h1 class="page-head">Service Contact</h1>
                            <div class="form-folder">
                                <div class="form-holder">
                                    <div class="row">
                                        <div class="offset-md-1 col-md-5 col-sm-6 col-xs-6">
                                            <div class="form-box-outer">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <th>Customer Code</th>
                                                                <td><h4 class="text-center">328456092</h4></td>
                                                             </tr>
                                                            <tr>
                                                                <th>Contract No</th>
                                                                <td>
                                                                	<input v-model="form.contact_phone" 
																		type="text" 
																		name="contact_phone" 
																		:class="{ 'is-invalid': form.errors.has('contact_phone') }"/>
																	     <has-error :form="form" field="contact_phone"></has-error>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Date</th>
                                                                <td>
                                                                	<date-picker 
												                     	v-model="form.service_contact_date"
												                     	name="service_contact_date"
												                     	lang="en"
												                     	
												                     	format="DD-MM-YYYY"
												                     	:class="{ 'is-invalid': form.errors.has('service_contact_date') }"></date-picker>
																      <has-error :form="form" field="service_contact_date"></has-error>
                                                                </td>
                                                             </tr>
                                                            <tr>
                                                                <th>Service Request Start Date </th>
                                                                <td>
                                                                	<date-picker 
												                     	v-model="form.service_request_start_date"
												                     	name="service_request_start_date"
												                     	lang="en"
												                     	type="date"
												                     	@change="charging_date()"
												                     	format="DD-MM-YYYY"
												                     	:class="{ 'is-invalid': form.errors.has('service_request_start_date') }"></date-picker>
																      <has-error :form="form" field="service_request_start_date"></has-error>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Duration (Minimum One Year)</th>
                                                                <td><date-picker 
												                     	v-model="form.duration"
												                     	name="duration"
												                     	lang="en"
												                     	type="date"
												                     	@change="service_duration()"
												                     	format="DD-MM-YYYY"
												                     	:class="{ 'is-invalid': form.errors.has('duration') }"></date-picker>
																      <has-error :form="form" field="duration"></has-error></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Charging Period</th>
                                                                <td>

                                                                	<select v-model="form.charging_peroid"
			                                                        	name="charging_peroid"
			                                                        	class="custom-select" 
			                                                        	:class="{ 'is-invalid': form.errors.has('charging_peroid') }">
															        	<option disabled value="">--Select Charging Peroid-- </option>
															        	<option  value="1">Annual </option>
															        	<option  value="2">Monthly</option>
																	  	
															  		</select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Amount (Before Taxes)</th>
                                                                <td>{{form.amount_before_tax}}</td>
                                                             </tr>
                                                            <tr>
                                                                <th>Currency</th>
                                                                <td>
                                                                	<select v-model="form.currency"
			                                                        	name="currency"
			                                                        	class="custom-select" 
			                                                        	:class="{ 'is-invalid': form.errors.has('currency') }">
															        	<option disabled value="">--Select-- </option>
																	  	<option v-for="(currency,index) in currency_arr" :value="index">{{currency}}</option>
															  		</select>									
                                                                </td>
                                                            </tr>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="offset-md-1 col-md-5 col-sm-6 col-xs-6">
                                            <div class="form-box-outer">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <th>Payment Method***</th>
                                                                <td>  

                                                                	<select v-model="form.charging_peroid"
			                                                        	name="charging_peroid"
			                                                        	class="custom-select" 
			                                                        	:class="{ 'is-invalid': form.errors.has('charging_peroid') }">
															        	<option disabled value="">--Select Payment Method-- </option>
															        	<option  value="1">Credit Card </option>
															        	<option  value="2">Online Banking</option>
																	  	
															  		</select>

                                                                </td>
                                                             </tr>
                                                            <tr>
                                                                <th>Business Term</th>
                                                                <td>{{form.business_term}} days in Advance</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Charging Date ({{form.business_term}} days before Request date)</th>
                                                                <td>
                                                                	<date-picker 
												                     	v-model="form.charging_date"
												                     	name="charging_date"
												                     	lang="en"
												                     	type="charging_date"
												                     	format="DD-MM-YYYY"
												                     	:class="{ 'is-invalid': form.errors.has('charging_date') }" disabled></date-picker>
																      <has-error :form="form" field="charging_date"></has-error>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Late Payment</th>
                                                                <td>{{form.late_payment}}% Monthly</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Cancellation Notice </th>
                                                                <td>One Month in Advance</td>
                                                             </tr>
                                                            <tr>
                                                                <th>Re-Connection Services Fee</th>
                                                                <td>${{form.reconnection_service_fee}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Re-Connection Services Date</th>
                                                                <td>{{form.reconnection_date}} (Between 5-7 business days)</td>
                                                             </tr>
                                                            <tr>
                                                                <th>NSF Fees</th>
                                                                <td>${{form.nsf_fee}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button class="btn btn-primary" type="button" @click.prevent="downloadItem()"> Please download form 100 and fax it  (604) 888- 8888</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
            <button :disabled="form.busy" v-show="!editmode" type="submit" class="action-button">Save</button>
            <button :disabled="form.busy" v-show="editmode" type="submit" class="action-button float-right">Update</button>
	        <button type="button" @click="next_setp" class="next action-button">Next <i class="fa fa-angle-right"></i></button>
            <button type="button" @click="previous_step" class="previous action-button-previous"><i class="fa fa-angle-left"></i> Previous</button>
	    </form>
    </fieldset>

</template>

<script>
	import Vue from 'vue';
	import DatePicker from 'vue2-datepicker';


	


    export default {
        name:'list-product-categories',
       	components:{
			DatePicker
		},
        data(){
            return{
            	editmode:false,
				filter: '',
            	form:new Form({
            		
            		
                  	id:'',
                  	contact_phone:'',
                  	service_contact_date:new Date(),
                  	service_request_start_date:'',
                  	duration:'',
                  	charging_peroid:1,
                  	amount_before_tax:250.00,
                  	currency:2,
                  	business_term:7,
                  	charging_date:'',
                  	late_payment:2,
                  	reconnection_service_fee:150.00,
                  	reconnection_date:'',
                  	nsf_fee:45.00,


            	}),

            	countries:'',
            	currency_arr:'',
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchServiceContact();
           
        },
		
	    methods: {

	    	downloadItem ()
	    	{


	    		window.open(
					  'http://localhost:8000/download/form-100.pdf?type=individual',
					  '_blank' // <- This is what makes it open in a new window.
					);return;
	    		             
			},


		  	previous_step()
            {
                let route = this.$router.resolve({ path: "/Temp-ServicePlan" });

                window.open(route.href,'_self');
                return;
            },
            next_setp()
            {

                let route = this.$router.resolve({ path: "/Temp-TermsOfAgreement" });
                window.open(route.href,'_self');
                return;
            },


			service_duration()
			{

				

				const _MS_PER_DAY = 1000 * 60 * 60 * 24;
				
				let date1=this.form.service_request_start_date;
				let date2=this.form.duration;
				if(!date1) {
					Swal("failed!","Please Select Service Request Start Date.","warning");
			   		this.form.duration="";
				}


			    // Discard the time and time-zone information.
			    const utc1 = Date.UTC(date1.getFullYear(), date1.getMonth(), date1.getDate());
			    const utc2 = Date.UTC(date2.getFullYear(), date2.getMonth(), date2.getDate());

			   	let duration=Math.floor((utc2 - utc1) / _MS_PER_DAY);
			   	if(duration<365)
			   	{
			   		Swal("failed!","Duration Must be Minimum One Year","warning");
			   		this.form.duration="";
			   		return;
			   	}

			   	var dt = new Date(this.form.duration);
					dt.setDate(dt.getDate() - 7);
				this.form.reconnection_date=new Date(dt);
			   
			},

			charging_date()
			{
				var dt = new Date(this.form.service_request_start_date);
					dt.setDate(dt.getDate() - 7);
				this.form.charging_date=new Date(dt);
				
			},





















            
	        fetchServiceContact()
            {

            	
                let uri = '/userServiceContacts';
                window.axios.get(uri).then((response) => {
                	this.currency_arr						=response.data.currency;
                    if(response.data.service_contact_data[0])
                    {
                    	this.form.contact_phone 				= response.data.service_contact_data.contact_phone;
                    	this.form.service_contact_date 			= response.data.service_contact_data.service_contact_date;
                    	this.form.service_request_start_date 	= response.data.service_contact_data.service_request_start_date;
                    	this.form.duration 						= response.data.service_contact_data.duration;
                    	this.form.charging_peroid 				= response.data.service_contact_data.charging_peroid;
                    	this.form.amount_before_tax 			= response.data.service_contact_data.amount_before_tax;
                    	this.form.id 							= response.data.service_contact_data.id;

                    	this.form.currency 						= response.data.service_contact_data.currency;
                    	this.form.business_term 				= response.data.service_contact_data.business_term;
                    	this.form.charging_date 				= response.data.service_contact_data.charging_date;
                    	this.form.late_payment 					= response.data.service_contact_data.late_payment;
                    	this.form.reconnection_service_fee 		= response.data.service_contact_data.reconnection_service_fee;
                    	this.form.reconnection_date 			= response.data.service_contact_data.reconnection_date;
                    	this.form.nsf_fee 						= response.data.service_contact_data.nsf_fee;
                    }

                	
                	if(this.form.id){
                		this.editmode=true;
                	}

                	this.countries 								=response.data.country_arr;
                	
                }); 
                alert(this.form.nsf_fee);  
            },

          
         
       

            updateServiceContact()
            {
            
				
		        this.form.put('/userServiceContacts/'+this.form.id)
				    .then(()=>{
					       //success
					     
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchServiceContact();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createServiceContact()
            {

        	    this.form.post('/userServiceContacts') .then(({ data }) => { 
               
					let route = this.$router.resolve({ path: "/Temp-TermsOfAgreement" });
	      			window.open(route.href,'_self');
	      			return;
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset();
					this.fetchServiceContact();
        	    })
            }
	    }
    
    }  
	
</script>