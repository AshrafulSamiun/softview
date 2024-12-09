<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Company Profile</h1>
                
                <div class="form-folder">
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-12 col-sm-12 col-xs-12">                                  

                                <div class="row">
                                    <div class="col-md-2 offset-md-1 col-sm-3 col-xs-12">
                                        <label class="fieldlabels">1. Company Name <span class="mandatory-field">*</span> :</label> 
                                        
                                    </div>
                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                        <input v-model="form.legal_name" 
											type="text" 
											placeholder="Type Company Name"
											name="legal_name" 
											:class="{ 'is-invalid': form.errors.has('legal_name') }"/>
											  <input v-model="form.id" type="hidden" name="id">
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-2 offset-md-1 col-sm-3 col-xs-12">
                                        <label class="fieldlabels">2. Company Address <span class="mandatory-field">*</span>: </label> 
                                        
                                    </div>
                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                        
                                    </div>

                                </div>
                                <div class="row">
                                	<div class="col-md-2 offset-md-1 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> Country:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" >
                                        <select v-model="form.country"
                                        	name="country"
                                        	class="custom-select" 
                                        	:class="{ 'is-invalid': form.errors.has('country') }">
								        	<option disabled value="">--Select-- </option>
										  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
								  		</select>
										
                                    </div>

                                    <div class="col-md-2 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> Province/State:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" >
                                        <input v-model="form.state" 
											type="text" 
											name="state" 
											placeholder="Type Province/State" 
											:class="{ 'is-invalid': form.errors.has('state') }"/>
										
                                    </div>                                   

                                </div>
                                 <div class="row">
                                	
                                    <div class="col-md-2 offset-md-1 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> City:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" >
                                        <input v-model="form.city" 
											type="text" 
											name="city" 
											placeholder="Type City" 
											:class="{ 'is-invalid': form.errors.has('city') }"/>
										
                                    </div>

                                    <div class="col-md-2 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> Zip Code:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" >
                                        <input v-model="form.zip_code" 
											type="text" 
											name="zip_code" 
											placeholder="Type Zip Code" 
											:class="{ 'is-invalid': form.errors.has('zip_code') }"/>
										 
                                    </div>

                                </div>
                                   
                                <div class="row">
                                    <div class="col-md-2 offset-md-1 col-sm-3 col-xs-12" align="right">
                                        <label class="">Website :</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-9 col-xs-12">
                                        <input v-model="form.website" 
											type="text" 
											placeholder="Type Website"
											name="website" 
											:class="{ 'is-invalid': form.errors.has('website') }"/>
										
											  
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-2 offset-md-1 col-sm-3 col-xs-12">
                                        <label class="fieldlabels">3. Contact Information <span class="mandatory-field">*</span>: </label> 
                                        
                                    </div>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        
                                    </div>

                                </div> 

                                <div class="row">
                                	<div class="col-md-2 offset-md-1 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> Contract Person Name:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-9 col-xs-12">
                                        <input v-model="form.contact_person_name" 
											type="text" 
											placeholder="Type Contract Person Name"
											name="contact_person_name" 
											:class="{ 'is-invalid': form.errors.has('contact_person_name') }"/>
										
                                    </div>

                                	<div class="col-md-2  col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> Position in Company:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-9 col-xs-12">
                                        <input v-model="form.position_in_company" 
											type="text" 
											placeholder="Type Position in Company"
											name="position_in_company" 
											:class="{ 'is-invalid': form.errors.has('position_in_company') }"/>
										
                                    </div>

                                </div> 
                                
                                <div class="row">
                                	<div class="col-md-2 offset-md-1 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> Phone Number:</label> 
                                    </div>
                                    <div class="col-md-3 col-sm-9 col-xs-12">
                                        <input v-model="form.contact_person_cell_phone" 
											type="text" 
											placeholder="Type Phone Number"
											name="contact_person_cell_phone" 
											:class="{ 'is-invalid': form.errors.has('contact_person_cell_phone') }"/>
										
                                    </div>

                                	<div class="col-md-2 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right">Email Address:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-9 col-xs-12">
                                        <input v-model="form.contact_person_email" 
											type="contact_person_email" 
											placeholder="Type Email Address"
											name="contact_person_email" 
											:class="{ 'is-invalid': form.errors.has('contact_person_email') }"/>
										
                                    </div>

                                </div> 

                                <div class="row">
                                    <div class="col-md-2 offset-md-1 col-sm-3 col-xs-12">
                                        <label class="fieldlabels">4. Security Business License<span class="mandatory-field">*</span> :</label> 
                                        
                                    </div>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        
											  
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-2 offset-md-1 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> License No:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-9 col-xs-12">
                                        <input v-model="form.license_no" 
											type="text" 
											placeholder="Type License No"
											name="license_no" 
											:class="{ 'is-invalid': form.errors.has('license_no') }"/>
										
                                    </div>

                                	<div class="col-md-2  col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> License Issuer:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-9 col-xs-12">
                                        <input v-model="form.license_issuer" 
											type="text" 
											placeholder="Type License Issuer"
											name="license_issuer" 
											:class="{ 'is-invalid': form.errors.has('license_issuer') }"/>
										
                                    </div>

                                </div> 
                                
                                <div class="row">
                                	<div class="col-md-2 offset-md-1 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> License Date:</label> 
                                    </div>
                                    <div class="col-md-3 col-sm-9 col-xs-12">
                                        
									    <Vue3datepicker 
                                            v-model="form.license_date" 
                                            :day-format="'dd'"         
                                            :weekday-format="'EE'"    
                                            :format="customFormat"
                                            :class="{ 'is-invalid': form.errors.has('license_date') }"/>
                                    </div>

                                	<div class="col-md-2 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right">Expire Date:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-9 col-xs-12">
                                        
									    <Vue3datepicker 
                                            v-model="form.license_expirey_date" 
                                            :day-format="'dd'"
                                            :weekday-format="'EE'"
                                            :format="customFormat"
                                            :class="{ 'is-invalid': form.errors.has('license_expirey_date') }"/>
                                    </div>

                                </div>
                                <div class="row">
                                	<div class="col-md-2 offset-md-1 col-sm-3 col-xs-12">
                                        <label class="fieldlabels">5. Registration Number <span class="mandatory-field">*</span>: </label> 
                                        
                                    </div>
                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                        <input v-model="form.business_registration_number" 
											type="text" 
											name="business_registration_number" 
											placeholder="Type Registration Number" 
											:class="{ 'is-invalid': form.errors.has('business_registration_number') }"/>
										
                                    </div>

                                </div>
                                <div class="row">
                                	<div class="col-md-2 offset-md-1 col-sm-3 col-xs-12">
                                        <label class="fieldlabels">6. Registration Location <span class="mandatory-field">*</span>: </label> 
                                        
                                    </div>
                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                        
                                    </div>

                                </div>
                                <div class="row">
                                	<div class="col-md-2 offset-md-1 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> Country:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" >
                                        <select v-model="form.business_registration_country"
                                        	name="business_registration_country"
                                        	class="custom-select" 
                                        	:class="{ 'is-invalid': form.errors.has('business_registration_country') }">
								        	<option disabled value="">--Select-- </option>
										  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
								  		</select>
										
                                    </div>

                                    <div class="col-md-2 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> Province/State:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" >
                                        <input v-model="form.business_registration_state" 
											type="text" 
											name="business_registration_state" 
											placeholder="Type Province/State" 
											:class="{ 'is-invalid': form.errors.has('business_registration_state') }"/>
										
                                    </div>                                   

                                </div>
                                 <div class="row">
                                	
                                    <div class="col-md-2 offset-md-1 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> City:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" >
                                        <input v-model="form.business_registration_city" 
											type="text" 
											name="business_registration_city" 
											placeholder="Type City" 
											:class="{ 'is-invalid': form.errors.has('business_registration_city') }"/>
										
                                    </div>

                                    <div class="col-md-2 col-sm-6 col-xs-12" align="right">
                                        <label class="text-right"> Zip Code:</label> 
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" >
                                        <input v-model="form.business_registration_zip_code" 
											type="text" 
											name="business_registration_zip_code" 
											placeholder="Type Zip Code" 
											:class="{ 'is-invalid': form.errors.has('business_registration_zip_code') }"/>
										
                                    </div>
                                </div>

                                <div class="row">
                                	<div class="col-md-2 offset-md-1 col-sm-3 col-xs-12">
                                        <label class="fieldlabels">7. Key Management Team <span class="mandatory-field">*</span>: </label> 
                                        
                                    </div>
                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                        
                                    </div>

                                </div>

                                <div class="row">
                                	<div class="col-md-2  col-sm-3 col-xs-12">
                                        
                                    </div>
                                    <div class="col-md-10 col-sm-9 col-xs-12">
                                         <table class="table table_narrow">
                                            
                                           
                                            <thead>
                                                <tr class="header" >
                                                    <td scope="col"  >Name</td>
                                                    <td scope="col" >Position</td>
                                                    <td scope="col"  >Email</td>
                                                    <td scope="col"  >Phone Number</td>
                                                </tr>
                                                
                                            </thead>
                                            <tbody style="border:none">
                                                <template v-for="(key_management,index) in form.key_management_list_arr" >
                                                    <tr style="background-color: #e7e8e7">
                                                        <td >
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Name"
                                                                v-bind:id="'key_management_name_'+index"
                                                                name="key_management_name[]" 
                                                                v-model="key_management.key_position_name"/>
                                                        </td>
                                                        <td scope="row" >{{key_management.reference_value}}</td>
                                                        
                                                        
                                                        <td >
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Email"
                                                                v-bind:id="'key_position_email_'+index"
                                                                name="key_position_email[]" 
                                                                v-model="key_management.email"/>
                                                        </td>

                                                      
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Phone Number"
                                                                v-bind:id="'key_position_office_phone_'+index"
                                                                name="key_position_office_phone[]" 
                                                                v-model="key_management.office_phone"/>
                                                        </td>                                                        
                                                       
                                                        
                                                       
                                                    </tr>
                                                                                                              
                                                </template>
                                               
                                            </tbody>
                                        </table> 
                                    </div>

                                </div>
                               
                            </div>
                           
                            <hr>
                        </div>
                    </div>
                </div>
                
            </div> 
			<button :disabled="form.busy"  type="submit" class="btn btn-primary">Next <i class="fa fa-angle-right"></i></button>
	    </form>
    </fieldset>

</template>
<style>

    .table_narrow td{
        padding: .1rem .5rem !important;
    }

    .table_narrow th,.table_narrow .header td{
        font-size:13px !important;
        vertical-align:middle !important;
        color: rgb(255, 255, 255) !important;
        text-align:center !important;
        border:1px solid #fff !important;
    }

    .table_narrow tbody td{
        font-size:13px !important;
    }
    .table_narrow thead tr,.table_narrow .header 
    {
        background-color: rgb(0, 112, 192) !important;
    }

    .table_narrow input{

        font-size: 12px !important;
        height: 30px !important;
        margin:5px 0  !important;
    }

   

</style>
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
                dateformat: "DD-MM-YYYY", // Ensure valid format
            	form:new Form({
            		key_management_list_arr:[],
            		
                  	id:'',
                  	legal_name:'',
                  	business_registration_number:'',
                  	business_registration_city:'',
                  	business_registration_state:'',
                  	business_registration_country:'',
                  	business_registration_zip_code:'',
                  	
                  	city:'',
                  	state:'',
                  	country:'',
                  	zip_code:'',
                  	website:'',
                  
                  	contact_person_name:'',
                  	contact_person_email:'',
                  	position_in_company:'',
                  	contact_person_cell_phone:'',
                  	license_no:'',
                  	license_issuer:'',
                  	license_date:null,
                  	license_expirey_date:null,

            	}),
            	key_position_lavel_arr:[],
            	account_no:'',
            	countries:'',
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchCompanyProfile();
           
        },
		
	    methods: {

            customFormat(date) {
              return date ? format(date, "eee dd MMM, yyyy") : ""; // Format as "Tue 03 Dec, 2024"
              alert()
            },
	    	generate_row_update(row)
	    	{
	    		row.editable=true;
	    	},

	    	add_key_management_team()
            {
                this.form.key_management_list_arr.push({
                    'id':'',
                    'reference_id':'',
                    'reference_value':'',
                    'email':'',
                    'office_phone':'',
                    'editable':true,
                    'key_position_name':'',
                });
            },
            
	        fetchCompanyProfile()
            {
                let uri = '/AccountSetups';
                window.axios.get(uri).then((response) => {
                	
                	
                	this.countries 								=response.data.country_arr;


                	for(let i=0; i<response.data.key_position_lavel_arr.length; i++){

                	
                		this.form.key_management_list_arr.push({
		                    'id'				:response.data.key_position_lavel_arr[i].id,
		                    'reference_id'		:response.data.key_position_lavel_arr[i].reference_id,
		                    'reference_value'	:response.data.key_position_lavel_arr[i].reference_value,
		                    'email'				:response.data.key_position_lavel_arr[i].email,
		                    'office_phone'		:response.data.key_position_lavel_arr[i].office_phone,
		                    'editable'			:response.data.key_position_lavel_arr[i].editable,
		                    'key_position_name' :response.data.key_position_lavel_arr[i].key_position_name,
		                }); 

                	}
                	
                	if(response.data.company_data.id){
                		this.form.id 								= response.data.company_data.id;
	                	this.form.legal_name 						= response.data.company_data.legal_name;
	                	this.form.business_registration_number 		= response.data.company_data.business_registration_number;
	                	this.form.business_registration_city 		= response.data.company_data.business_registration_city;
	                	this.form.business_registration_state 		= response.data.company_data.business_registration_state;
	                	this.form.business_registration_country 	= response.data.company_data.business_registration_country;
	                	this.form.business_registration_zip_code 	= response.data.company_data.business_registration_zip_code;

	                	this.form.license_no 						= response.data.company_data.license_no;
	                	this.form.license_issuer 					= response.data.company_data.license_issuer;
	                	this.form.license_date 						= response.data.company_data.license_date? new Date(response.data.company_data.license_date): null;
	                	this.form.license_expirey_date 				= response.data.company_data.license_expirey_date? new Date(response.data.company_data.license_expirey_date): null;


	                	this.form.zip_code 							= response.data.company_data.zip_code;
	                	this.form.country 							= response.data.company_data.country;
	                	this.form.state 							= response.data.company_data.state;
	                	this.form.city 								= response.data.company_data.city;
	                	this.form.website 							= response.data.company_data.website;

	                	this.form.contact_person_email 				= response.data.company_data.contact_person_email;
	                	this.form.position_in_company 				= response.data.company_data.position_in_company;
	                	this.form.contact_person_cell_phone 		= response.data.company_data.contact_person_cell_phone;
	                	this.form.contact_person_name 				= response.data.company_data.contact_person_name;
                		this.editmode=true;
                	}

                	

                	
                }); 

                 
                
            },      

            updateCompanyProfile()
            {
            
				
		        this.form.put('/AccountSetups/'+this.form.id)
				    .then(()=>{
					       //success				     
					
							showToast('Data Update Successfully', 'success');

							let route = this.$router.resolve({ path: "/Temp-BusinessType" });
			      			window.open(route.href,'_self');
			      			return;
					
					     this.form.reset ();
					     this.fetchCompanyProfile();
				    })
				    .catch(()=>{
					   showToast("there was some wrong","warning");
				
				    });
            },
            
            createCompanyProfile()
            {

            	
            	
        	    this.form.post('/AccountSetups') .then(({ data }) => { 
               
					let route = this.$router.resolve({ path: "/Temp-ContactsPersons" });
	      			window.open(route.href,'_self');
	      			return;
					showToast('Data Save Successfully', 'success');

					this.form.reset ();
					this.fetchCompanyProfile();
        	    })
            }
	    }
    
    }  
	
</script>