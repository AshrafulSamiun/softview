<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateServiceContact() : createServiceContact()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
	        	<button type="button" class="btn btn-primary btn-lg btn-block"><strong>Service Contact</strong></button>
                <div class="form-folder">
                    <div class="form-holder">
                        <div class="row">
                            <div class="offset-md-1 col-md-5 col-sm-6 col-xs-6">
                                <div class="form-box-outer">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                
                                                <tr>
                                                    <th>Contact No</th>
                                                    <td>
                                                    	<input v-model="form.contact_phone" 
															type="text" 
															name="contact_phone" 
															:class="{ 'is-invalid': form.errors.has('contact_phone') }"/>
														     <has-error :form="form" field="contact_phone"></has-error>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Contract Date</th>
                                                    <td>
                                                    	
													    <Vue3datepicker 
				                                            v-model="form.service_contact_date" 
				                                            :day-format="'dd'"         
				                                            :weekday-format="'EE'"    
				                                            :format="customFormat"
				                                            :class="{ 'is-invalid': form.errors.has('service_contact_date') }"/>
                                                    </td>
                                                 </tr>
                                                <tr>
                                                    <th>Service  Start Date </th>
                                                    <td>
                                                    	
													    <Vue3datepicker 
				                                            v-model="form.service_start_date" 
				                                            :day-format="'dd'"         
				                                            :weekday-format="'EE'"    
				                                            :format="customFormat"
				                                            :class="{ 'is-invalid': form.errors.has('service_start_date') }"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Duration (Minimum One Year)</th>
                                                    <td>

									                    <select v-model="form.duration"
                                                        	name="duration"
                                                        	class="custom-select"
                                                        	@change="change_ending_year(form.duration)" 
                                                        	:class="{ 'is-invalid': form.errors.has('duration') }">
												        	<option disabled value="">--Select Duration-- </option>
												        	<option  :value="index" v-for="(year,index) in duration_arr">{{year}} </option>														  	
												  		</select>
													    <has-error :form="form" field="duration"></has-error>
													</td>
                                                </tr>
                                                <tr>
                                                    <th>Service End Date </th>
                                                    <td>
                                                    	
													     <Vue3datepicker 
				                                            v-model="form.service_end_date" 
				                                            :day-format="'dd'"         
				                                            :weekday-format="'EE'" 
				                                            @change="charging_date()"   
				                                            :format="customFormat"
				                                            :class="{ 'is-invalid': form.errors.has('service_end_date') }"/>
                                                    </td>
                                                </tr>
                                               
                                                <tr>
                                                    <th>Charging Period</th>
                                                    <td>

                                                    	<select v-model="form.charging_peroid"
                                                        	name="charging_peroid"
                                                        	class="custom-select" 
                                                        	:class="{ 'is-invalid': form.errors.has('charging_peroid') }" disabled>
												        	<option disabled value="">--Select Charging Peroid-- </option>
												        	<option  value="1">Monthly </option>
												        	<option  value="2">Annual</option>
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
                                                        	:class="{ 'is-invalid': form.errors.has('currency') }" disabled>
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
                            <div class=" col-md-5 col-sm-6 col-xs-6">
                                <div class="form-box-outer">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Payment Method***</th>
                                                    <td>  
                                                    	<select v-model="form.payment_method"
                                                        	name="payment_method"
                                                        	class="custom-select" 
                                                        	:class="{ 'is-invalid': form.errors.has('payment_method') }">
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
                                                    
													    <Vue3datepicker 
				                                            v-model="form.charging_date" 
				                                            :day-format="'dd'"         
				                                            :weekday-format="'EE'"    
				                                            :format="customFormat"
				                                            :class="{ 'is-invalid': form.errors.has('charging_date') }"/>
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
                                                    <th>Cancellation Fee</th>
                                                    <td>${{form.cancellation_fee}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Re-Connection Services Fee</th>
                                                    <td>${{form.reconnection_service_fee}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Re-Connection Services Period</th>
                                                    <td> (Between {{form.reconnection_period}} business days)</td>
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
            <button type="button" @click="previous_step" class="btn btn-primary"><i class="fa fa-angle-left"></i> Previous</button>
            <button :disabled="form.busy" v-show="!editmode" type="submit" class="btn btn-primary">Save{{editmode}}</button>
            <button :disabled="form.busy" v-show="editmode" type="submit" class="btn btn-primary">Update</button>
	        <button type="button" @click="next_setp" class="btn btn-primary">Next <i class="fa fa-angle-right"></i></button>
           
	    </form>
    </fieldset>

</template>

<script>
	import {ref} from "vue";
    import { format } from "date-fns"; // Import format from date-fns
    import Vue3datepicker from "vue3-datepicker";


	


    export default {
        name:'list-product-categories',
       	components:{
			Vue3datepicker
		},
        data(){
            return{
            	editmode:false,
				filter: '',
            	form:new Form({
            		
            		
                  	id:'',
                  	contact_phone:'',
                  	service_contact_date:new Date(),
                  	service_start_date:new Date().setDate(new Date().getDate() + 10),
                  	duration:'',
                  	service_end_date:null,
                  	charging_peroid:'',
                  	amount_before_tax:'',
                  	currency:'',
                  	business_term:10,
                  	charging_date:new Date(),
                  	late_payment:2,
                  	reconnection_service_fee:150.00,
                  	cancellation_fee:250.00,
                  	reconnection_date:null,
                  	nsf_fee:45.00,
                  	payment_method:'',
                  	reconnection_period:3,
            	}),

            	countries:'',
            	currency_arr:'',
            	duration_arr: {
						  1: "One Year",
						  2: 'Two Years',
						  3: 'Three Years',
						  4: "Four Year",
						  5: 'Five Years',
						  6: 'Six Years',
						  7: "Seven Year",
						  8: 'Eight Years',
						  9: 'Nine Years',
						  10: "Ten Year",
						  11: "Eleven Year",
						  12: 'Twelve Years',
						  13: 'ThirteenYears',
						  14: "Fourteen Year",
						  15: 'Fifteen Years',
						  16: 'Sixteen Years',
						  17: "Seventeen Year",
						  18: 'Eighteen Years',
						  19: 'Nineteen Years',
						  20: 'Twenty Years',
						}
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchServiceContact();
           
        },
		
	    methods: {

	    	customFormat(date) {
              return date ? format(date, "eee dd MMM, yyyy") : ""; // Format as "Tue 03 Dec, 2024"
            },

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
            	
                let route = this.$router.resolve({ path: "/Temp-ContactsPersons" });
                window.open(route.href,'_self');
                return;
            },


			service_duration()
			{

				const _MS_PER_DAY = 1000 * 60 * 60 * 24;
				
				let date1=this.form.service_start_date;
				let date2=this.form.duration;
				if(!date1) {
					
					showToast('Please Select Service Request Start Date.', 'warning');
			   		this.form.duration="";
				}


			    // Discard the time and time-zone information.
			    const utc1 = Date.UTC(date1.getFullYear(), date1.getMonth(), date1.getDate());
			    const utc2 = Date.UTC(date2.getFullYear(), date2.getMonth(), date2.getDate());

			   	let duration=Math.floor((utc2 - utc1) / _MS_PER_DAY);
			   	if(duration<365)
			   	{
			   		
			   		showToast('Duration Must be Minimum One Year', 'warning');
			   		this.form.duration="";
			   		return;
			   	}

			   	var dt = new Date(this.form.duration);
					dt.setDate(dt.getDate() - 7);
				this.form.reconnection_date=new Date(dt);
			   
			},

			charging_date()
			{
				var dt = new Date(this.form.service_start_date);
					dt.setDate(dt.getDate() - 10);
				this.form.charging_date=new Date(dt);
				
			},
			change_ending_year(duration)
			{
				var stDate = new Date(this.form.service_start_date);

				//var year = dt.getFullYear();
			   // var month = dt.getMonth();
			   // var day = dt.getDate();
			    //var ndt = new Date(year + 1, month, day);

			   // stDate.setFullYear(stDate.getFullYear() + duration);
			    stDate.setFullYear(stDate.getFullYear() + duration*1);

				this.form.service_end_date=stDate;
				

			},
            
	        fetchServiceContact()
            {

            	
                let uri = '/userServiceContacts';
                window.axios.get(uri).then((response) => {
                	this.currency_arr							=response.data.currency;
                	this.form.currency							=response.data.currency_id;
                	this.form.charging_peroid					=response.data.charging_peroid;
                	this.form.amount_before_tax					=response.data.amount_before_tax;

                   		if(response.data.service_contact_data.id > 0)
                   		{

	                    	this.form.contact_phone 				= response.data.service_contact_data.contact_phone;
	                    	this.form.service_contact_date 			= response.data.service_contact_data.service_contact_date? new Date(response.data.service_contact_data.service_contact_date): null;
	                    	this.form.service_start_date 			= response.data.service_contact_data.service_start_date? new Date(response.data.service_contact_data.service_start_date): null;
	                    	this.form.service_end_date 				= response.data.service_contact_data.service_end_date? new Date(response.data.service_contact_data.service_end_date): null;
	                    	this.form.reconnection_period 			= response.data.service_contact_data.reconnection_period;
	                    	this.form.duration 						= response.data.service_contact_data.duration;
	                    	this.form.payment_method 				= response.data.service_contact_data.payment_method;
	                    	//this.form.amount_before_tax 			= response.data.service_contact_data.amount_before_tax;
	                    	this.form.id 							= response.data.service_contact_data.id;
	                    	

	                    	//this.form.currency 					= response.data.service_contact_data.currency;
	                    	this.form.business_term 				= response.data.service_contact_data.business_term;
	                    	this.form.charging_date 				= response.data.service_contact_data.charging_date;
	                    	this.form.late_payment 					= response.data.service_contact_data.late_payment;
	                    	this.form.reconnection_service_fee 		= response.data.service_contact_data.reconnection_service_fee;
	                    	this.form.reconnection_date 			= response.data.service_contact_data.reconnection_date? new Date(response.data.service_contact_data.reconnection_date): null;
	                    	this.form.nsf_fee 						= response.data.service_contact_data.nsf_fee;
	                   
                			this.editmode=true;
                		}

                	this.countries 								=response.data.country_arr;
                	
                }); 
                
            },

          
         
       

            updateServiceContact()
            {
            				
		        this.form.put('/userServiceContacts/'+this.form.id)
				    .then(()=>{
					    			
						showToast('Data Update Successfully', 'success');
					
					     this.form.reset ();
					     this.fetchServiceContact();
				    })
				    .catch(()=>{
					   showToast("there was some wrong","warning");
				
				    });
            },
            
            createServiceContact()
            {

        	    this.form.post('/userServiceContacts') .then(({ data }) => { 
               
					let route = this.$router.resolve({ path: "/Temp-TermsOfAgreement" });
	      			window.open(route.href,'_self');
	      			return;
					showToast('Data Save Successfully', 'success');
					this.form.reset();
					this.fetchServiceContact();
        	    })
            }
	    }
    
    }  
	
</script>