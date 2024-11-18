<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
	            <h1 class="page-head">General Information</h1>
	            <div class="form-folder">
	                <h3>Account No:<span>328456092</span></h3>
	            </div>
	            <div class="form-folder">
	                <h3>Management Type:</h3>
	                <div class="form-holder">
	                    <div class="form-check-inline">
	                        <input type="checkbox" value="0" 
												name="strata_management" 
												id="strata_management"
												v-model="form.strata_management" @change="check_management_type($event,1)">
	                        <label for="strata_management">Strata Management</label><br>
	                        <input type="checkbox" value="0" 
												name="coop_property" 
												id="coop_property"
												v-model="form.coop_property" @change="check_management_type($event,2)">
	                        <label for="management_type2">Co-op Property</label><br>
	                        <input type="checkbox" value="0" 
												name="free_hold_management" 
												id="free_hold_management"
												v-model="form.free_hold_management" @change="check_management_type($event,3)">
	                        <label for="management_type3">Property</label>
	                        <input type="checkbox" value="0" 
												name="leasehold_management" 
												id="leasehold_management"
												v-model="form.leasehold_management" @change="check_management_type($event,4)">
	                        <label for="management_type4">Leasehold</label>
	                        <input type="checkbox" value="0" 
												name="property_management" 
												id="property_management"
												v-model="form.property_management" @change="check_management_type($event,5)">
	                        <label for="property_management">Property Management Service Provider</label>
	                    </div>
	                </div>
	            </div>
	            <div class="form-folder">
	                <h3>Type of Operation:</h3>
	                <div class="form-holder">
	                    <div class="form-check-inline">
	                        <input type="radio" id="type_of_operation1" name="type_of_operation" v-model="form.type_of_operation">
	                        <label for="type_of_operation1">Rental Suites and Units</label><br>
	                        <input type="radio" id="type_of_operation2" name="type_of_operation" v-model="form.type_of_operation">
	                        <label for="type_of_operation2">Buy and Sale Suits and Units</label><br>
	                        <input type="radio" id="type_of_operation3" name="type_of_operation" v-model="form.type_of_operation">
	                        <label for="type_of_operation3">Rental Parking</label>
	                        <input type="radio" id="type_of_operation4" name="type_of_operation" v-model="form.type_of_operation">
	                        <label for="type_of_operation4">Rental Storage</label>
	                        <input type="radio" id="type_of_operation5" name="type_of_operation" v-model="form.type_of_operation">
	                        <label for="type_of_operation5">Landlord / Landholders Residency</label>
	                    </div>
	                </div>
	            </div>
	            <div class="form-folder">
	                <h3>Company Profile:</h3>
	                <div class="form-holder">
	                    <div class="row">
	                        <div class="col-md-12 col-sm-12 col-xs-12"> 
	                            <div class="image-holder">
	                                <div class="circle">
	                                   <img class="profile-pic" src="https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg">
	                                </div>
	                                <div class="p-image">
	                                   <i class="fa fa-camera upload-button"></i>
	                                   <input class="file-upload" type="file" accept="image/*"/>
	                                </div>
	                                <h2>Company Logo</h2>
	                            </div>
	                        </div> 
	                        <div class="col-md-4 col-sm-6 col-xs-12"> 
	                            <h4>Company Legal Name</h4>
	                            <input v-model="form.legal_name" 
												type="text" 
												placeholder="Type Company Name"
												name="legal_name" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('legal_name') }"/>
											      <has-error :form="form" field="legal_name"></has-error>
												  <input v-model="form.id" type="hidden" name="id">
	                            <h4>Company logo</h4>
	                            <input type="file" name="pic" accept="image/*">
	                            <h4>Head Office Address</h4>
	                            <div class="row">
	                                <div class="col-md-7 col-sm-6 col-xs-12">
	                                    <label class="fieldlabels">Street Number/Country:</label> 
	                                    <input type="password" placeholder="Type Street Number/Country"/> 
	                                </div>
	                                <div class="col-md-5 col-sm-6 col-xs-12">
	                                    <label class="fieldlabels">City:</label> 
	                                    <input type="password" placeholder="Type City"/> 
	                                </div>
	                                <div class="col-md-6 col-sm-6 col-xs-12">
	                                    <label class="fieldlabels">State:</label> 
	                                    <input type="password" placeholder="Type State"/> 
	                                </div>
	                                <div class="col-md-6 col-sm-6 col-xs-12">
	                                    <label class="fieldlabels">Country:</label> 
	                                    <div class="position-relative form-group">
	                                        <select type="select" id="exampleCustomSelect" name="customSelect" class="custom-select">
	                                            <option value="">Select</option>
	                                            <option>Canada</option>
	                                            <option>USA</option>
	                                            <option>Germany</option>
	                                            <option>Franch</option>
	                                            <option>Italy</option>
	                                        </select>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-md-4 col-sm-6 col-xs-12">
	                            <h4>Business Registration</h4>
	                            <label class="fieldlabels">Number:</label> 
	                            <input v-model="form.business_registration_number" 
												type="text" 
												name="business_registration_number" 
												:class="{ 'is-invalid': form.errors.has('business_registration_number') }"/>
											     <has-error :form="form" field="business_registration_number"></has-error>

	                            
	                            <div class="row">
	                            	<div class="col-md-12 col-sm-12 col-xs-12">
	                            		<label class="fieldlabels">Date:</label> 
			                            <date-picker 
					                     	v-model="form.registration_date"
					                     	name="registration_date"
					                     	lang="en"
					                     	type="registration_date"
					                     	format="DD-MM-YYYY"
					                     	:class="{ 'is-invalid': form.errors.has('registration_date') }"></date-picker>
									      <has-error :form="form" field="registration_date"></has-error>
	                            	</div>
	                                <div class="col-md-12 col-sm-12 col-xs-12">
	                                   
	                                    <label class="fieldlabels">City:</label> 
	                                    <input v-model="form.business_registration_city" 
												type="text" 
												name="business_registration_city" 
												:class="{ 'is-invalid': form.errors.has('business_registration_city') }"/>
											     <has-error :form="form" field="business_registration_city"></has-error>
	                                </div>

	                                <div class="col-md-12 col-sm-12 col-xs-12">
	                                    <label class="fieldlabels">State:</label> 
	                                    <input v-model="form.business_registration_state" 
												type="text" 
												name="business_registration_state" 
												:class="{ 'is-invalid': form.errors.has('business_registration_state') }"/>
											    <has-error :form="form" field="business_registration_state"></has-error> 
	                                </div>
	                                <div class="col-md-12 col-sm-12 col-xs-12">
	                                    <label class="fieldlabels">Country:</label> 
	                                    <div class="position-relative form-group">
	                                        <select v-model="form.registration_country"  name="registration_country"class="custom-select" :class="{ 'is-invalid': form.errors.has('registration_country') }">
										        	<option disabled value="">--Select-- </option>
												  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
										  	</select>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-md-4 col-sm-6 col-xs-12">
	                            <h4>Miunicipal Business License</h4>
	                            <label class="fieldlabels">Number:</label> 
	                            <input v-model="form.business_license_no" 
									type="text" 
									name="business_license_no" 
									class="form-control" 
									:class="{ 'is-invalid': form.errors.has('business_license_no') }"/>
								     <has-error :form="form" field="business_license_no"></has-error>
								<label class="fieldlabels">Issued By:</label> 
								     <input v-model="form.issued_by" 
												type="text" 
												name="issued_by" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('issued_by') }"/>
											     <has-error :form="form" field="issued_by"></has-error>
	                            
	                            <div class="row">
	                                <div class="col-md-12 col-sm-12 col-xs-12">
	                                    <label class="fieldlabels">State:</label> 
	                                    <input type="text" placeholder="Type State"/> 
	                                </div>
	                                <div class="col-md-12 col-sm-12 col-xs-12">
	                                    <label class="fieldlabels">Country:</label> 
	                                    <div class="position-relative form-group">

	                                        <select v-model="form.license_country"  name="license_country" class="custom-select"
	                                        	:class="{ 'is-invalid': form.errors.has('license_country') }">
										        	<option disabled value="">--Select-- </option>
												  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
										  	</select>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="col-md-12 col-sm-12 col-xs-12">
		                            <label class="fieldlabels">Expiry Date:</label> 
		                            <date-picker 
				                     	v-model="form.expirey_date"
				                     	name="expirey_date"
				                     	lang="en"
				                     	type="expirey_date"
				                     	format="DD-MM-YYYY"
				                     	:class="{ 'is-invalid': form.errors.has('expirey_date') }"></date-picker>
								      <has-error :form="form" field="expirey_date"></has-error> 
								</div>
	                        </div>
	                        <hr>
	                    </div>
	                </div>
	            </div>
	            <div class="form-folder">
	                <h3>Property Type(S):</h3>
	                <div class="form-holder">
	                    <div class="row">
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                            <h4>Dependent Property</h4>
	                            <div class="row">
	                                <div class="col-md-6 col-sm-6 col-xs-12">
	                                    <label class="fieldlabels">Residential Suite:</label> 
	                                    <input type="text" placeholder="Residential Suite"/> 
	                                    <label class="fieldlabels">Parking Lot:</label> 
	                                    <input type="text" placeholder="Parking Lot"/> 
	                                    <label class="fieldlabels">Storage Lot:</label> 
	                                    <input type="text" placeholder="Storage Lot"/> 
	                                </div>
	                                <div class="col-md-6 col-sm-6 col-xs-12">
	                                    <label class="fieldlabels">Commercial Units:</label> 
	                                    <input type="text" placeholder="Commercial Units"/> 
	                                    <label class="fieldlabels">Parking Lots:</label> 
	                                    <input type="text" placeholder="Parking Lots"/> 
	                                    <label class="fieldlabels">Storage Lots:</label> 
	                                    <input type="text" placeholder="Storage Lots"/> 
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-md-6 col-sm-6 col-xs-12">
	                            <h4>Independent Properties</h4>
	                            <div class="row">
	                                <div class="col-md-6 col-sm-6 col-xs-12">
	                                    <label class="fieldlabels">Residential Suite:</label> 
	                                    <input type="text" placeholder="Residential Suite"/> 
	                                    <label class="fieldlabels">Parking Lot:</label> 
	                                    <input type="text" placeholder="Parking Lot"/> 
	                                    <label class="fieldlabels">Storage Lot:</label> 
	                                    <input type="text" placeholder="Storage Lot"/> 
	                                </div>
	                                <div class="col-md-6 col-sm-6 col-xs-12">
	                                    <label class="fieldlabels">Commercial Unit:</label> 
	                                    <input type="text" placeholder="Commercial Units"/> 
	                                    <label class="fieldlabels">Parking Lot:</label> 
	                                    <input type="text" placeholder="Parking Lots"/> 
	                                    <label class="fieldlabels">Storage Lot:</label> 
	                                    <input type="text" placeholder="Storage Lots"/> 
	                                </div>
	                            </div>
	                        </div>
	                        <hr>
	                    </div>
	                </div>
	            </div>
	            <div class="form-folder">
	                <h3>Tax Office Accounts:
	                    <button class="btn btn-primary float-right" type="submit"><i class="fa fa-plus"></i> Add More Row</button>
	                </h3>
	                <div class="form-holder">
	                    <div class="row">
	                        <div class="col-md-4 col-sm-6 col-xs-12">
	                            <label class="fieldlabels">Business Number:</label> 
	                            <input type="email" placeholder="Type usiness Number"/> 
	                            <label class="fieldlabels">Employer Identification Number (EIN):</label> 
	                            <input type="text" placeholder="Enter Identification Number (EIN)"/> 
	                        </div>
	                        <div class="col-md-4 col-sm-6 col-xs-12">
	                            <label class="fieldlabels">Payroll:</label> 
	                            <input type="email" placeholder="Type Payroll"/> 
	                            <label class="fieldlabels">Sales Tax:</label> 
	                            <input type="text" placeholder="Enter Sales Tax"/> 
	                        </div>
	                        <div class="col-md-4 col-sm-6 col-xs-12">
	                            <label class="fieldlabels">Income Tax:</label> 
	                            <input type="email" placeholder="Type Income Tax"/> 
	                            <label class="fieldlabels">Import and Export :</label> 
	                            <input type="text" placeholder="Enter Import and Export "/> 
	                        </div>
	                        <hr>
	                    </div>
	                </div>
	            </div>
	        </div> 
	        <button type="submit" class="next action-button">Next <i class="fa fa-angle-right"></i></button>
	    </form>
    </fieldset>

</template>

<script>
	import Vue from 'vue';
	

	


    export default {
        name:'list-product-categories',
       
        data(){
            return{
            	editmode:false,
				filter: '',
            	form:new Form({
            		strata_management:false,
            		/*type_of_operation:false,*/
            		free_hold_management:false,
            		leasehold_management:false,
            		property_management:false,
                  	id:'',
                  	legal_name:'',
                  	business_registration_number:'',
                  	registration_date:'',
                  	business_registration_city:'',
                  	business_registration_state:'',
                  	registration_country:'',
                  	business_license_no:'',
                  	issued_by:'',
                  	license_country:'',
                  	expirey_date:'',
                  	head_office_email:'',
                  	head_office_fax_no:'',
                  	head_office_cell_phone:'',
                  	head_office_website:'',


                  	contact_person_email:'',
                  	contact_person_fax_no:'',
                  	contact_person_cell_phone:'',
                  	contact_person_website:'',
                  	business_number:'',
                  	emp_identification_number:'',
                  	payroll:'',
                  	sales_tax:'',
                  	income_tax:'',
                  	import_and_export:'',

                  	dependent_residential_suite:'',
                  	dependent_residental_parking_lot:'',
                  	dependent_residental_storage_lot:'',
                  	dependent_commercial_unit:'',
                  	dependent_commercial_parking_lot:'',

                  	dependent_commercial_storage_lot:'',
                  	independent_residential_suite:'',
                  	independent_residental_parking_lot:'',
                  	independent_residental_storage_lot:'',
                  	independent_commercial_unit:'',
                  	independent_commercial_parking_lot:'',
                  	independent_commercial_storage_lot:'',


                  	rantal_suite_unit:'',
                  	buy_and_sell_suite_unit:'',
                  	rental_parking:'',
                  	rental_storage:'',
                  	landholders_residency:'',


            	}),

            	countries:'',
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchCompanyProfile();
           
        },
		
	    methods: {

	    	check_management_type(e,type){
	    		alert(e.target.checked);
	    	},
            
	        fetchCompanyProfile()
            {
                let uri = '/AccountSetups';
                window.axios.get(uri).then((response) => {
                	this.form.strata_management 				= response.data.company_data.strata_management;
                	this.form.leasehold_management 				= response.data.company_data.leasehold_management;
                	this.form.free_hold_management 				= response.data.company_data.free_hold_management;
                	this.form.strata_management 				= response.data.company_data.strata_management;
                	this.form.coop_property 					= response.data.company_data.coop_property;
                	this.form.property_management 				= response.data.company_data.property_management;
                	this.form.id 								= response.data.company_data.id;

                	this.form.legal_name 						= response.data.company_data.legal_name;
                	this.form.business_registration_number 		= response.data.company_data.business_registration_number;
                	this.form.registration_date 				= response.data.company_data.registration_date;
                	this.form.business_registration_city 		= response.data.company_data.business_registration_city;
                	this.form.business_registration_state 		= response.data.company_data.business_registration_state;
                	this.form.registration_country 				= response.data.company_data.registration_country;
                	this.form.business_license_no 				= response.data.company_data.business_license_no;

                	this.form.issued_by 						= response.data.company_data.issued_by;
                	this.form.license_country 					= response.data.company_data.license_country;
                	this.form.expirey_date 						= response.data.company_data.expirey_date;
                	this.form.head_office_email 				= response.data.company_data.head_office_email;
                	this.form.head_office_fax_no 				= response.data.company_data.head_office_fax_no;
                	this.form.head_office_cell_phone 			= response.data.company_data.head_office_cell_phone;
                	this.form.head_office_website 				= response.data.company_data.head_office_website;


                	this.form.contact_person_email 				= response.data.company_data.contact_person_email;
                	this.form.contact_person_fax_no 			= response.data.company_data.contact_person_fax_no;
                	this.form.contact_person_cell_phone 		= response.data.company_data.contact_person_cell_phone;
                	this.form.contact_person_website 			= response.data.company_data.contact_person_website;

                	this.form.business_number 					= response.data.company_data.business_number;
                	this.form.emp_identification_number 		= response.data.company_data.emp_identification_number;
                	this.form.payroll 							= response.data.company_data.payroll;
                	this.form.sales_tax 						= response.data.company_data.sales_tax;
                	this.form.income_tax 						= response.data.company_data.income_tax;
                	this.form.import_and_export 				= response.data.company_data.import_and_export;
                	
                	if(this.form.id){
                		this.editmode=true;
                	}

                	this.countries 								=response.data.country_arr;
                	
                });   
            },

          
         
       

            updateCompanyProfile()
            {
            alert(this.form.type_of_operation);;return;
				let route = this.$router.resolve({ path: "/Temp-ContactsPersons" });
      			window.open(route.href,'_self');
      			return;
		        this.form.put('/AccountSetups/'+this.form.id)
				    .then(()=>{
					       //success
					     
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchCompanyProfile();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createCompanyProfile()
            {

            	alert(this.form.type_of_operation);;return;
            	let route = this.$router.resolve({ path: "/Temp-ContactsPersons" });
      			window.open(route.href,'_self');
      			return;
        	    this.form.post('/AccountSetups') .then(({ data }) => { 
               
					
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchCompanyProfile();
        	    })
            }
	    }
    
    }  
	
</script>