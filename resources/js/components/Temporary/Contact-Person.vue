<template>
	<fieldset>
        <form @submit.prevent="editmode ? updateContactPerson() : createContactPerson()" @keydown="form.onKeydown($event)">
            <div class="form-card">
                <h1 class="page-head">Contacts Persons</h1>
                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> Contact Person Details: 
                        
                    </h3>
                    <div class="form-holder">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12"> 
                                <div class="form-box-outer">
                                    <div class="form-check-inline" align="left" v-for="(contact_person,index) in contact_person_arr" v-if="index>0">
                                        <button type="button" class="btn btn-secondary"
                                        :class="{ 'action-button': contact_person_data[index] }"

                                         @click.prevent="addContactPerson(index)" >{{contact_person}}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12"> 
                                <div class="form-box-outer">
                                    <h4>Full Name</h4>

                                    <input v-model="form.full_name" 
                                        type="text" 
                                        name="full_name" 
                                        placeholder="Type Full Name" 
                                        :class="{ 'is-invalid': form.errors.has('full_name') }"/>
                                          <has-error :form="form" field="full_name"></has-error>

                                          
                                          <input v-model="form.id" type="hidden" name="id">
                                    <h4>Job Title</h4>
                                    <input v-model="form.job_title" 
                                        type="text" 
                                        name="job_title" 
                                         placeholder="Type Job Title" 
                                        :class="{ 'is-invalid': form.errors.has('job_title') }"/>
                                          <has-error :form="form" field="job_title"></has-error> 
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    <h4>Address</h4>
                                    <label class="fieldlabels">Street Number / Name :</label> 
                                    <input v-model="form.street_number" 
                                        type="text" 
                                        name="street_number" 
                                        placeholder="Type Street Number / Name"
                                        :class="{ 'is-invalid': form.errors.has('street_number') }"/>
                                         <has-error :form="form" field="street_number"></has-error>
                                    <label class="fieldlabels">City:</label> 
                                    <input v-model="form.city" 
                                            type="text" 
                                            name="city" 
                                            placeholder="Type City"
                                            :class="{ 'is-invalid': form.errors.has('city') }"/>
                                             <has-error :form="form" field="city"></has-error> 
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">State/ Province:</label> 
                                             
                                            <input v-model="form.state" 
                                                type="text" 
                                                name="state" 
                                                placeholder="Type State/ Province" 
                                                :class="{ 'is-invalid': form.errors.has('state') }"/>
                                                 <has-error :form="form" field="state"></has-error>
                                           
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Country:</label> 
                                            <select v-model="form.country"  name="country" class="custom-select" :class="{ 'is-invalid': form.errors.has('country') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                            </select>
                                           
                                        </div>
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Postal Code:</label> 
                                            <input v-model="form.post_code" 
                                                type="text" 
                                                name="post_code" 
                                                placeholder="Type Postal Code" 
                                                :class="{ 'is-invalid': form.errors.has('post_code') }"/>
                                                 <has-error :form="form" field="post_code"></has-error> 
                                        </div>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">P.O Box:</label> 
                                            <input v-model="form.po_box" 
                                                type="text" 
                                                name="po_box" 
                                                placeholder="Type P.O Box" 
                                                :class="{ 'is-invalid': form.errors.has('po_box') }"/>
                                                 <has-error :form="form" field="po_box"></has-error> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    <h4>Contacts</h4>
                                    <label class="fieldlabels">Ph. Office:</label> 
                                    <input v-model="form.office_phone" 
                                        type="text" 
                                        name="office_phone" 
                                        placeholder="Type Ph. Office" 
                                        :class="{ 'is-invalid': form.errors.has('office_phone') }"/>
                                         <has-error :form="form" field="office_phone"></has-error> 
                                    <label class="fieldlabels">Ph. Mobile:</label> 
                                    <input v-model="form.mobile" 
                                        type="text" 
                                        name="mobile" 
                                        placeholder="Type Ph. Mobile" 
                                        :class="{ 'is-invalid': form.errors.has('mobile') }"/>
                                         <has-error :form="form" field="mobile"></has-error>
                                    <label class="fieldlabels">Fax:</label> 
                                    <input v-model="form.fax_no" 
                                        type="text" 
                                        name="fax_no" 
                                        placeholder="Fax" 
                                        :class="{ 'is-invalid': form.errors.has('fax_no') }"/>
                                         <has-error :form="form" field="fax_no"></has-error> 

                                    <label class="fieldlabels">Email Address:</label> 
                                    <input v-model="form.email" 
                                        type="email" 
                                        name="email" 
                                        placeholder="Type Email Address"
                                        :class="{ 'is-invalid': form.errors.has('email') }"/>
                                         <has-error :form="form" field="email"></has-error>

                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="form-folder">
                        <h3><i class="fa fa-hand-point-right"></i> Contact Person Details: 
                           
                            <button :disabled="form.busy" v-show="!editmode" type="submit" class="btn btn-primary float-right">Save</button>
                            <button :disabled="form.busy" v-show="editmode" type="submit" class="action-button float-right">Update</button>
                        </h3>
                    </div>
                </div>
            </div>
            <button type="button" @click="next_setp" class="next action-button">Next <i class="fa fa-angle-right"></i></button>
            <button type="button" @click="previous_step" class="previous action-button-previous"><i class="fa fa-angle-left"></i> Previous</button>
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
				display_form:false,
            	form:new Form({
            		
                  	id:'',
                  	full_name:'',
                  	job_title:'',
                  	street_number:'',
                  	city:'',
                  	state:'',
                  	country:'',
                  	post_code:'',
                  	po_box:'',
                  	office_phone:'',
                  	mobile:'',
                  	email:'',
                  	fax_no:'',
                  	contact_person_id:'',
                  	
            	}),
            	contact_person_data:[],
            	countries:'',
            	contact_person_arr:['Select Contact Person','Business Director','General Manager','Property Manager','System Admin','Accounting Manager','Accounts Payable','Emergency Contact'],
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchContactPerson();
           
        },
		
	    methods: {

	    	previous_step()
            {
                let route = this.$router.resolve({ path: "/Temp-CompanyProfile" });
                //alert(route.href);
                window.open(route.href,'_self');
                return;
            },
            next_setp()
            {

                let route = this.$router.resolve({ path: "/Temp-ServicePlan" });
                window.open(route.href,'_self');
                return;
            },

            addContactPerson(type)
            {
            	this.form.reset();
            	if(this.contact_person_data[type])
            	{
            		this.editmode=true;
            		this.form.full_name			=this.contact_person_data[type].full_name;
            		this.form.job_title			=this.contact_person_data[type].job_title;
            		this.form.street_number		=this.contact_person_data[type].street_number;
            		this.form.city 				=this.contact_person_data[type].city;
            		this.form.state 			=this.contact_person_data[type].state;
            		this.form.country 			=this.contact_person_data[type].country;
            		this.form.post_code 		=this.contact_person_data[type].post_code;
            		this.form.po_box 			=this.contact_person_data[type].po_box;
            		this.form.office_phone 		=this.contact_person_data[type].office_phone;
            		this.form.mobile 			=this.contact_person_data[type].mobile;
            		this.form.email 			=this.contact_person_data[type].email;
            		this.form.fax_no 			=this.contact_person_data[type].fax_no;
            		this.form.id 				=this.contact_person_data[type].id;



            	}
            	else 
            	{
            		this.editmode=false;

            	}
				this.form.contact_person_id=type;
				this.display_form=true;
            },


	        fetchContactPerson()
            {
                let uri = '/AccountContactPersons';
                window.axios.get(uri).then((response) => {
                	this.contact_person_data					=response.data.contact_person_data;
                	/*this.form.strata_management 				= response.data.company_data.strata_management;
                	this.form.leasehold_management 				= response.data.company_data.leasehold_management;
                	this.form.free_hold_management 				= response.data.company_data.free_hold_management;
                	this.form.strata_management 				= response.data.company_data.strata_management;
                	this.form.coop_property 					= response.data.company_data.coop_property;
                	this.form.property_management 				= response.data.company_data.property_management;
                	this.form.id 								= response.data.company_data.id;

                	this.form.full_name 						= response.data.company_data.full_name;
                	this.form.business_registration_number 		= response.data.company_data.business_registration_number;
                	this.form.registration_date 				= response.data.company_data.registration_date;
                	this.form.business_registration_city 		= response.data.company_data.business_registration_city;
                	this.form.business_registration_state 		= response.data.company_data.business_registration_state;
                	this.form.country 				= response.data.company_data.country;
                	this.form.business_license_no 				= response.data.company_data.business_license_no;

                	this.form.issued_by 						= response.data.company_data.issued_by;
                	this.form.license_country 					= response.data.company_data.license_country;
                	this.form.expirey_date 						= response.data.company_data.expirey_date;
                	this.form.head_office_email 				= response.data.company_data.head_office_email;
                	this.form.head_office_fax_no 				= response.data.company_data.head_office_fax_no;
                	this.form.head_office_cell_phone 			= response.data.company_data.headphone;
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
                	this.form.import_and_export 				= response.data.company_data.import_and_export;*/
                	
                	if(this.form.id){
                		this.editmode=true;
                	}

                	this.countries 								=response.data.country_arr;
                	
                });   
            },

          
         
       

            updateContactPerson()
            {
				//alert(this.form.id);
		        this.form.put('/AccountContactPersons/'+this.form.id)
				    .then(()=>{
					       //success
					     
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     	this.form.reset ();
							this.display_form=false;
							this.fetchContactPerson();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createContactPerson()
            {

        	    this.form.post('/AccountContactPersons') .then(({ data }) => { 
               
					
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.display_form=false;
					this.fetchContactPerson();
        	    })
            }
	    }
    
    }  
	
</script>