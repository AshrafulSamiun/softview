<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateTermOfAggrement() : createTermOfAggrement()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                            <h1 class="page-head">Terms of agreement </h1>
                            <div class="form-folder">
                                <div class="form-holder">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer">
                                                <h4>Terms of agreement</h4>
                                                <p>The Terms of Service Agreement is mainly used for legal purposes by companies which provide software or services, such as web browsers, e-commerce, web search engines, social media, and transport services.<br><br>

                                                A legitimate terms-of-service agreement is legally binding and may be subject to change.[2] Companies can enforce the terms by refusing service. Customers can enforce by filing a lawsuit or arbitration case if they can show they were actually harmed by a breach of the terms. There is a heightened risk of data going astray during corporate changes, including mergers, divestitures, buyouts, downsizing, etc., when data can be transferred improperly.[3] <br><br>


                                                The Terms of Service Agreement is mainly used for legal purposes by companies which provide software or services, such as web browsers, e-commerce, web search engines, social media, and transport services.<br><br>

                                                A legitimate terms-of-service agreement is legally binding and may be subject to change.[2] Companies can enforce the terms by refusing service. Customers can enforce by filing a lawsuit or arbitration case if they can show they were actually harmed by a breach of the terms. There is a heightened risk of data going astray during corporate changes, including mergers, divestitures, buyouts, downsizing, etc., when data can be transferred improperly.[3] </p>

                                                <h4>Declaration</h4>
                                                <label class="form-check-inline termds">

                                                <input type="checkbox" value="0" 
                                               		class="form-check-input" 
                                               			style="height:auto; display:static;"
														name="diclaration" 
														id="diclaration"
														v-model="form.diclaration">
                                                     I as an authorized person  certify that provided information on this account is correct ,completed and prepared by an authorized person from business owner or company director.
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Authorized Person</h4>
                                                <label class="fieldlabels">Full Name:</label> 
                                                
                                                <input v-model="form.full_name" 
													type="text" 
													placeholder="Type Full Name"
													name="full_name" 
													:class="{ 'is-invalid': form.errors.has('full_name') }"/>
												      <has-error :form="form" field="full_name"></has-error> 

                                                <label class="fieldlabels">Position:</label> 
                                                <input v-model="form.position" 
													type="text" 
													placeholder="Type Position"
													name="position" 
													:class="{ 'is-invalid': form.errors.has('position') }"/>
												      <has-error :form="form" field="position"></has-error>
                                                
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

                                               
                                                <label class="fieldlabels">Email:</label> 
                                                <input v-model="form.email" 
			                                        type="email" 
			                                        name="email" 
			                                        placeholder="Type Email Address"
			                                        :class="{ 'is-invalid': form.errors.has('email') }"/>
			                                         <has-error :form="form" field="email"></has-error> 
                                                <label class="fieldlabels">Location:</label> 
                                                
                                                <input v-model="form.location" 
			                                        type="text" 
			                                        name="location" 
			                                        placeholder="Type Location"
			                                        :class="{ 'is-invalid': form.errors.has('location') }"/>
			                                         <has-error :form="form" field="location"></has-error>
                                               
                                            </div>
                                        </div>
                                        <hr>
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
            this.fetchTermOfAggrement();
            this.setProgressBar();
           
        },
		
	    methods: {

	    	setProgressBar(){
                var percent = parseFloat(100 / 7) * 6;
                percent = percent.toFixed();
                $(".progress-bar")
                .css("width",percent+"%")
        },


		  	previous_step()
            {
                let route = this.$router.resolve({ path: "/Temp-ServiceContract" });

                window.open(route.href,'_self');
                return;
            },
            next_setp()
            {

                let route = this.$router.resolve({ path: "/Temp-DocumentsSubmission" });
                window.open(route.href,'_self');
                return;
            },



            
	        fetchTermOfAggrement()
            {

            	
                let uri = '/TermsOfAggrements';
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

          
         
       

            updateTermOfAggrement()
            {
            
		        this.form.put('/TermsOfAggrements/'+this.form.id)
				    .then(()=>{
					       //success
					     
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchTermOfAggrement();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createTermOfAggrement()
            {
            	if(!this.form.diclaration)
            	{
            		Swal("failed!","Please Aggree with Terms of Aggreement.","warning");

            	}
        	    this.form.post('/TermsOfAggrements') .then(({ data }) => { 
               
					
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset();
					this.fetchTermOfAggrement();
        	    });
            }
	    }
    
    }

	
</script>
