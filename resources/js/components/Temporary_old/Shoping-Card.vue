<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Shoping Card</h1>
                
                <div class="form-folder">
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-6 offset-md-3 col-sm-12 col-xs-12">                                  

                                <div class="row">
                                    <div class="col-md-6  col-sm-3 col-xs-12">
                                        <label class="fieldlabels"> First Name <span class="mandatory-field">*</span> :</label> 
                                        <input v-model="form.first_name" 
                                            type="text" 
                                            placeholder="Type First Name"
                                            name="first_name" 
                                            :class="{ 'is-invalid': form.errors.has('first_name') }"/>
                                        
                                    </div>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <label class="fieldlabels"> Last Name <span class="mandatory-field">*</span> :</label>
                                        <input v-model="form.last_name" 
											type="text" 
											placeholder="Type Last Name"
											name="last_name" 
											:class="{ 'is-invalid': form.errors.has('last_name') }"/>
											
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="fieldlabels"> Card Number <span class="mandatory-field">*</span>: </label>
                                        <input v-model="form.card_number" 
                                            type="text" 
                                            placeholder="Type Card Number"
                                            name="card_number" 
                                            :class="{ 'is-invalid': form.errors.has('card_number') }"/> 
                                        
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6  col-sm-3 col-xs-12">
                                        <label class="fieldlabels"> Expire Date <span class="mandatory-field">*</span> :</label> 
                                        <input v-model="form.expire_date" 
                                            type="text" 
                                            placeholder="Type First Name"
                                            name="expire_date" 
                                            :class="{ 'is-invalid': form.errors.has('expire_date') }"/>
                                        
                                    </div>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <label class="fieldlabels"> Security  Code<span class="mandatory-field">*</span> :</label>
                                        <input v-model="form.security_code" 
                                            type="text" 
                                            placeholder="Type Security Code"
                                            name="security_code" 
                                            :class="{ 'is-invalid': form.errors.has('security_code') }"/>
                                            
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="fieldlabels"> Address <span class="mandatory-field">*</span>: </label>
                                        <input v-model="form.address" 
                                            type="text" 
                                            placeholder="Type Address"
                                            name="address" 
                                            :class="{ 'is-invalid': form.errors.has('address') }"/> 
                                        
                                    </div>

                                </div>

                                <div class="row">
                                
                                    <div class="col-md-6 col-sm-6 col-xs-12" >
                                        <label class="text-right"> Zip Code:</label> 
                                        
                                        <input v-model="form.zip_code" 
                                            type="text" 
                                            name="zip_code" 
                                            placeholder="Type Zip Code" 
                                            :class="{ 'is-invalid': form.errors.has('zip_code') }"/>
                                         
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" >
                                        <label class="text-right"> City:</label> 
                                        
                                        <input v-model="form.city" 
                                            type="text" 
                                            name="city" 
                                            placeholder="Type City" 
                                            :class="{ 'is-invalid': form.errors.has('city') }"/>
                                        
                                    </div>

                                </div>
                                <div class="row">
                                	<div class="col-md-6 col-sm-6 col-xs-12">
                                       <label class="text-right"> Province/State:</label> 
                                       <input v-model="form.state" 
                                            type="text" 
                                            name="state" 
                                            placeholder="Type Province/State" 
                                            :class="{ 'is-invalid': form.errors.has('state') }"/>
                                        
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" >
                                        <label class="text-right"> Country:</label> 
                                        <select v-model="form.country"
                                        	name="country"
                                        	class="custom-select" 
                                        	:class="{ 'is-invalid': form.errors.has('country') }">
								        	<option disabled value="">--Select-- </option>
										  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
								  		</select>
										
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-11 col-xs-12">
                                       <button :disabled="form.busy" 
                                             
                                            type="submit" 
                                            class="btn btn-primary btn-block">Pay</button>
                                                                                
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-11 col-xs-12">
                                        <button type="button" 
                                            @click="previous_step" 
                                            class="btn btn-primary">
                                            <i class="fa fa-angle-left"></i> Previous</button>
                                        <button type="button" 
                                            @click="next_setp" 
                                            class="btn btn-primary">Next 
                                            <i class="fa fa-angle-right"></i></button>
                                                                                
                                    </div>

                                </div>
                               
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                
            </div>

			
            
            
           
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
                  	first_name:'',
                  	last_name:'',
                  	card_number:'',
                  	expire_date:'',
                  	security_code:'',
                  	address:'',
                  	city:'',
                  	state:'',
                  	country:'',
                  	zip_code:'',

            	}),
            	key_position_lavel_arr:[],
            	account_no:'',
            	countries:'',
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchShopingCart();
           
        },
		
	    methods: {

            previous_step()
            {
                let route = this.$router.resolve({ path: "/Temp-Declaration" });
                //alert(route.href);
                window.open(route.href,'_self');
                return;
            },
            next_setp()
            {

                let route = this.$router.resolve({ path: "/Temp-ActivationStatus" });
                window.open(route.href,'_self');
                return;
            },

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
            
	        fetchShopingCart()
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
	                	this.form.first_name 						= response.data.company_data.first_name;
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
					     this.fetchShopingCart();
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
					this.fetchShopingCart();
        	    })
            }
	    }
    
    }  
	
</script>