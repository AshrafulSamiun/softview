<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                            <h1 class="page-head">General Information</h1>
                            <div class="form-folder">
                                <h3><i class="fa fa-hand-point-right"></i> Account:</h3>
                                <div class="form-holder">
                                    <div class="row align-self-stretch">
                                        <div class="col-md-4 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer d-flex align-items-center">
                                                <div class="ac-box">
                                                    <h4 class="text-center">Your Account Number</h4>
                                                    <h2 class="text-center">{{account_no}}</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Welcome Message:</h4>
                                                <div class="form-holder">
                                                     this is message df dflkdf dsfk dkf dskf sdkf dsklf kdf sdf dskf kdsf kdsf jkds jfksdf
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Create Account's Instruction:</h4>
                                                <div class="form-holder">
                                                   The is Create Account's Instruction here
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="form-folder">
                                <h3><i class="fa fa-hand-point-right"></i> Company Profile:</h3>
                                <div class="form-holder">
                                    <div class="row align-self-stretch">
                                        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> 
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
                                        </div> -->
                                        <div class="col-md-4 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer">
                                                <h4>Company Legal Name</h4>
                                                <input v-model="form.legal_name" 
													type="text" 
													placeholder="Type Company Name"
													name="legal_name" 
													:class="{ 'is-invalid': form.errors.has('legal_name') }"/>
												      <has-error :form="form" field="legal_name"></has-error>
													  <input v-model="form.id" type="hidden" name="id">
                                                <h4>Company logo</h4>
                                                <input type="file" name="pic" accept="image/*">

                                                <label class="fieldlabels">Business Registration Number:</label> 

                                                <input v-model="form.business_registration_number" 
													type="text" 
													name="business_registration_number" 
													placeholder="Type Number" 
													:class="{ 'is-invalid': form.errors.has('business_registration_number') }"/>
												<has-error :form="form" field="business_registration_number"></has-error>

                                            </div>

                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Address</h4>
                                                
                                                <label class="fieldlabels">House Number</label> 
                                                <input v-model="form.headoffice_house_number" 
													type="text" 
													name="headoffice_house_number" 
													placeholder="Type Street Number" 
													:class="{ 'is-invalid': form.errors.has('headoffice_house_number') }"/>
												     <has-error :form="form" field="headoffice_house_number"></has-error>
                                                <label class="fieldlabels">Street Number</label> 
                                                <input v-model="form.headoffice_street_number" 
													type="text" 
													name="headoffice_street_number" 
													placeholder="Type Street Number" 
													:class="{ 'is-invalid': form.errors.has('headoffice_street_number') }"/>
												     <has-error :form="form" field="headoffice_street_number"></has-error> 
                                                   
                                                <label class="fieldlabels">City:</label> 
                                                <input v-model="form.headoffice_city" 
													type="text" 
													name="headoffice_city" 
													placeholder="Type City" 
													:class="{ 'is-invalid': form.errors.has('headoffice_city') }"/>
												     <has-error :form="form" field="headoffice_city"></has-error> 
                                                
                                                <label class="fieldlabels">State:</label> 
                                                <input v-model="form.headoffice_state" 
													type="text" 
													name="headoffice_state" 
													placeholder="Type State" 
													:class="{ 'is-invalid': form.errors.has('headoffice_state') }"/>
												     <has-error :form="form" field="headoffice_state"></has-error>
                                                
                                                <label class="fieldlabels">Country:</label> 
                                                <div class="position-relative form-group">
                                                    <select v-model="form.headoffice_country"
                                                    	name="headoffice_country"
                                                    	class="custom-select" 
                                                    	:class="{ 'is-invalid': form.errors.has('headoffice_country') }">
											        	<option disabled value="">--Select-- </option>
													  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
											  		</select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer">
                                                
                                                <h4>Contact</h4>

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Email</label> 
                                                        <input v-model="form.contact_person_email" 
															type="email" 
															name="contact_person_email" 
															:class="{ 'is-invalid': form.errors.has('contact_person_email') }"/>
														     <has-error :form="form" field="contact_person_email"></has-error>
                                                    </div>
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Fax:</label> 
                                                        <input v-model="form.contact_person_fax_no" 
															type="text" 
															name="contact_person_fax_no" 
															:class="{ 'is-invalid': form.errors.has('contact_person_fax_no') }"/>
														     <has-error :form="form" field="contact_person_fax_no"></has-error> 
                                                    </div>
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Phone:</label> 
                                                        <input v-model="form.contact_person_cell_phone" 
															type="text" 
															name="contact_person_cell_phone" 
															:class="{ 'is-invalid': form.errors.has('contact_person_cell_phone') }"/>
														     <has-error :form="form" field="contact_person_cell_phone"></has-error>
                                                    </div>
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Website:</label> 
                                                        <input v-model="form.contact_person_website" 
															type="url" 
															name="contact_person_website" 
															:class="{ 'is-invalid': form.errors.has('contact_person_website') }"/>
														     <has-error :form="form" field="contact_person_website"></has-error>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            
                        </div> 
	        			<button :disabled="form.busy"  type="submit" class="next action-button">Next <i class="fa fa-angle-right"></i></button>
	    </form>
    </fieldset>

</template>

<script>
	import {ref} from "vue";
	

	


    export default {
        name:'list-product-categories',
       
        data(){
            return{
            	editmode:false,
				filter: '',
            	form:new Form({
            		
                  	id:'',
                  	legal_name:'',
                  	company_logo_id:'',
                  	business_registration_number:'',
                  	headoffice_house_number:'',
                  	headoffice_street_number:'',
                  	headoffice_city:'',
                  	headoffice_state:'',
                  	headoffice_country:'',
                  	contact_person_email:'',
                  	contact_person_fax_no:'',
                  	contact_person_cell_phone:'',
                  	contact_person_website:'',
            	}),
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

	    

	    	
            
	        fetchCompanyProfile()
            {
                let uri = '/AccountSetups';
                window.axios.get(uri).then((response) => {
                	this.account_no								=response.data.account_no;
                	this.form.id 								= response.data.company_data.id;

                	this.form.legal_name 						= response.data.company_data.legal_name;
                	this.form.business_registration_number 		= response.data.company_data.business_registration_number;

                	this.form.headoffice_house_number 			= response.data.company_data.headoffice_house_number;
                	this.form.headoffice_street_number 			= response.data.company_data.headoffice_street_number;
                	this.form.headoffice_city 					= response.data.company_data.headoffice_city;
                	this.form.headoffice_state 					= response.data.company_data.headoffice_state;
                	this.form.headoffice_state 					= response.data.company_data.headoffice_state;
                	this.form.headoffice_country 				= response.data.company_data.headoffice_country;


                	this.form.contact_person_email 				= response.data.company_data.contact_person_email;
                	this.form.contact_person_fax_no 			= response.data.company_data.contact_person_fax_no;
                	this.form.contact_person_cell_phone 		= response.data.company_data.contact_person_cell_phone;
                	this.form.contact_person_website 			= response.data.company_data.contact_person_website;

                	
                	
                	if(this.form.id){
                		this.editmode=true;
                	}

                	this.countries 								=response.data.country_arr;
                	
                });   
            },

          
         
       

            updateCompanyProfile()
            {
            
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
            	
        	    this.form.post('/AccountSetups') .then(({ data }) => { 
               
					let route = this.$router.resolve({ path: "/Temp-ContactsPersons" });
	      			window.open(route.href,'_self');
	      			return;
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