<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateDeclarationStatement() : createDeclarationStatement()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Declaration Statement </h1>
               
                <div class="row">
                    <div class="col-md-10 offset-md-1 col-sm-12 col-xs-12"> 
                        <div class="form-box-outer">
                            <p><strong>Please be aware of the following important conditions:</strong></p>

                            <p><strong>1. Usage Restrictions :</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	The account creator and any users of our system are prohibited from using any information or ideas from our web application outside of its intended use. All information and ideas are protected under private property and copyright laws. This application is considered private property, and unauthorized use is strictly prohibited
                            </p>

                            <p><strong>2. Developer Restrictions :</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	    If you are a developer or involved in the development of similar applications, you are not permitted to create an account on our system
                            </p>

                            <p><strong>3. Monitoring and Verification :</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	   We monitor user activity by IP addresses and reserve the right to investigate and verify all information provided. By creating an account, you authorize us to conduct such investigations.
                            </p>

                            <p><strong>4. Account Registration Instructions :</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	   - To proceed with registration, fill out all required information to advance to the next step.<br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								 - Please note that we will not retain any information if you do not complete all steps.<br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	      - You have 30 minutes to complete the registration process. If you do not finish within this timeframe, you will need to start the process again.<br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								    - You are allowed a maximum of two attempts to complete the registration.

                            </p>

                            <p><strong>5. Legal Responsibilities and Claims :</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									- Users shall not engage in any activity that is harmful, fraudulent, or otherwise objectionable.
									<br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								   - Any discrepancies or fraudulent activities will be treated as serious offenses. We retain the legal right to pursue claims in court for damages exceeding $1 million USD.<br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								   - Any discrepancies or fraudulent activities will be treated as serious offenses. We retain the legal right to pursue claims in court for damages exceeding $1 million USD.

                            </p>

                            <p><strong>6. Data Privacy :</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Your information will be handled with strict confidentiality and in accordance with applicable data protection laws. Please review our privacy policy for details on how your data will be managed.
                            </p>

                            <p><strong>7. Contact Information :</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	 For any questions or assistance with the registration process, please contact us at [contact information
                            </p>

                            <p><strong>8. Acceptance of Terms :</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	   By proceeding with the registration, you acknowledge that you have read, understood, and agreed to all the terms and conditions stated herein.
                            </p>
                           
                            <p><strong>9. Updates to Terms :</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	   These terms and conditions may be updated periodically. It is your responsibility to review them regularly to stay informed of any changes.
                            </p>

                            <p><strong>10. Jurisdiction :</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	Any disputes arising from these terms and conditions will be resolved in the jurisdiction of [specified location
                            </p>

                            <p><strong>11. Social Media Restrictions :</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	ou, your company employees and staff, and any third parties are prohibited from disclosing any information about our application on social media or any other public platforms. This restriction applies to sharing, posting, or discussing any details or ideas derived from our system. Violations of this restriction will be treated as a serious offense and may result in legal action.
                            </p>

                            <p>Please read this notice carefully and more than once to ensure full understanding and compliance. By proceeding, you acknowledge and accept these terms and conditions.

                            </p>

                            <p><strong>Feel free to let me know if there are any additional adjustments or details needed!</strong> 
                            </p>
                         

                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-10 offset-md-1 col-sm-12 col-xs-12"> 
                    
                        <p><strong>Declaration Statement by following Authorized Person</strong> </p>
                        <div class="row">
                            <div class="col-md-1 offset-md-1 col-sm-3 col-xs-12">
                        		<label class="fieldlabels">Full Name:</label> 
                        	</div>
                        	<div class="col-md-8 col-sm-9 col-xs-12">
		                        <input v-model="form.full_name" 
									type="text" 
									placeholder="Type Full Name"
									name="full_name" 
									:class="{ 'is-invalid': form.errors.has('full_name') }"/>
								<has-error :form="form" field="full_name"></has-error> 
							</div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 offset-md-1 col-sm-3 col-xs-12">
                        		<label class="fieldlabels">Position:</label>
                        	</div>
                        	<div class="col-md-8 col-sm-9 col-xs-12"> 
		                        <input v-model="form.position" 
									type="text" 
									placeholder="Type Position"
									name="position" 
									:class="{ 'is-invalid': form.errors.has('position') }"/>
								<has-error :form="form" field="position"></has-error>
                    		</div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 offset-md-1 col-sm-3 col-xs-12">
                        		<label class="fieldlabels">Ph. Office:</label> 
                        	</div>
                        	<div class="col-md-8 col-sm-9 col-xs-12">
		                        <input v-model="form.office_phone" 
		                            type="text" 
		                            name="office_phone" 
		                            placeholder="Type Ph. Office" 
		                            :class="{ 'is-invalid': form.errors.has('office_phone') }"/>
		                        <has-error :form="form" field="office_phone"></has-error> 

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 offset-md-1 col-sm-3 col-xs-12">
                        		<label class="fieldlabels">Ph. Mobile:</label>
		                    </div>
                        
                            <div class="col-md-8 col-sm-9 col-xs-12">   
		                        <input v-model="form.mobile" 
		                            type="text" 
		                            name="mobile" 
		                            placeholder="Type Ph. Mobile" 
		                            :class="{ 'is-invalid': form.errors.has('mobile') }"/>
		                             <has-error :form="form" field="mobile"></has-error>
                             </div>
                        </div>
                    	<div class="row">
                        	<div class="col-md-1 offset-md-1 col-sm-3 col-xs-12">
                        		<label class="fieldlabels">Email:</label>
                        	</div>
                        
                            <div class="col-md-8 col-sm-9 col-xs-12">
		                        <input v-model="form.email" 
		                            type="email" 
		                            name="email" 
		                            placeholder="Type Email Address"
		                            :class="{ 'is-invalid': form.errors.has('email') }"/>
		                             <has-error :form="form" field="email"></has-error> 
                        	</div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 offset-md-1 col-sm-3 col-xs-12">
                        		<label class="fieldlabels">Location:</label> 
                        	</div>
                       
                            <div class="col-md-8 col-sm-9 col-xs-12">
		                        <input v-model="form.location" 
		                            type="text" 
		                            name="location" 
		                            placeholder="Type Location"
		                            :class="{ 'is-invalid': form.errors.has('location') }"/>
		                             <has-error :form="form" field="location"></has-error>
                       		</div>
                       	</div>
                   

                    </div>
                </div>
            </div>
                        
            <button type="button" @click="previous_step" class="btn btn-primary"><i class="fa fa-angle-left"></i> Previous</button>           
            <button :disabled="form.busy" v-show="!editmode" type="submit" class="btn btn-primary">Save</button>
            <button :disabled="form.busy"  v-show="editmode" type="submit" class="btn btn-primary">Update</button>
	        <button type="button" v-show="editmode" @click="next_setp" class="btn btn-primary">Next <i class="fa fa-angle-right"></i></button>
           
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
                  	diclaration:false,
                  	full_name:'',
                  	position:'',
                  	office_phone:'',
                  	mobile:'',
                  	email:'',
                  	location:'',
            	}),     
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchDeclarationStatement();
        },
		
	    methods: {

		  	previous_step()
            {
                let route = this.$router.resolve({ path: "/Temp-TermsOfAgreement" });

                window.open(route.href,'_self');
                return;
            },

            next_setp()
            {

                let route = this.$router.resolve({ path: "/Temp-ShoppingCard" });
                window.open(route.href,'_self');
                return;
            },
            
	        fetchDeclarationStatement()
            {

                let uri = '/DocumentSubmitions';
                window.axios.get(uri).then((response) => {
                	                	
                	this.form.diclaration 				= response.data.terms_of_aggrement_data.diclaration;
                	this.form.full_name 				= response.data.terms_of_aggrement_data.full_name;
                	this.form.position 					= response.data.terms_of_aggrement_data.position;
                	this.form.office_phone 				= response.data.terms_of_aggrement_data.office_phone;
                	this.form.mobile 					= response.data.terms_of_aggrement_data.mobile;
                	this.form.email 					= response.data.terms_of_aggrement_data.email;
                	this.form.id 						= response.data.terms_of_aggrement_data.id;
                	this.form.location 					= response.data.terms_of_aggrement_data.location;
                	                	
                	if(this.form.id){
                		this.editmode=true;
                	}                 	
                });   
            },

          
            updateDeclarationStatement()
            {
            
		        this.form.put('/DocumentSubmitions/'+this.form.id)
				    .then(()=>{
					       //success
					     
							showToast('Data Update Successfully', 'success');
					
					     this.fetchDeclarationStatement();
				    })
				    .catch(()=>{
					   showToast("there was some wrong","warning");
				
				    });
            },
            
            createDeclarationStatement()
            {
            	            	
        	    this.form.post('/DocumentSubmitions') .then(({ data }) => { 
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.fetchDeclarationStatement();
        	    });
            }
	    }
    
    }

	
</script>
