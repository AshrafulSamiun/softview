<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateTermOfAggrement() : createDocumentSubmition()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                            <h1 class="page-head">Documents' Submission</h1>
                            <div class="form-holder">
                                <div class="form-box-outer">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Upload Document:</label> 
                                            <input type="file" name="doc" accept="image/*">
                                            <p style="color:red;font-size:13px">Please fax it to (604)888-8888 and indicate your customer No</p>
                                            <label class="fieldlabels">Upload Document:</label> 
                                            <input type="file" name="doc" accept="image/*">
                                            <p style="color:red;font-size:13px">Please fax it to (604)888-8888 and indicate your customer No</p>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Upload Document:</label> 
                                            <input type="file" name="doc" accept="image/*">
                                            <p style="color:red;font-size:13px">Please fax it to (604)888-8888 and indicate your customer No</p>
                                            <label class="fieldlabels">Upload Document:</label> 
                                            <input type="file" name="doc" accept="image/*">
                                            <p style="color:red;font-size:13px">Please fax it to (604)888-8888 and indicate your customer No</p>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Upload Document:</label> 
                                            <input type="file" name="doc" accept="image/*">
                                            <p style="color:red;font-size:13px">Please fax it to (604)888-8888 and indicate your customer No</p>
                                            <label class="fieldlabels">Upload Document:</label> 
                                            <input type="file" name="doc" accept="image/*">
                                            <p style="color:red;font-size:13px">Please fax it to (604)888-8888 and indicate your customer No</p>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Upload Document:</label> 
                                            <input type="file" name="doc" accept="image/*">
                                            <p style="color:red;font-size:13px">Please fax it to (604)888-8888 and indicate your customer No</p>
                                            <label class="fieldlabels">Upload Document:</label> 
                                            <input type="file" name="doc" accept="image/*">
                                            <p style="color:red;font-size:13px">Please fax it to (604)888-8888 and indicate your customer No</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
           
	        <button type="submit"  class="next action-button">Next <i class="fa fa-angle-right"></i></button>
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
            this.fetchDocumentSubmition();
           
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

                let route = this.$router.resolve({ path: "/Temp-ActivationStatus" });
                window.open(route.href,'_self');
                return;
            },



            
	        fetchDocumentSubmition()
            {

            	
               /* let uri = '/DocumentSubmitions';
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
                });  */ 
            },

          
         
       

           
            
            createDocumentSubmition()
            {
            	
        	    this.form.post('/DocumentSubmitions') .then(({ data }) => { 
               
					let route = this.$router.resolve({ path: "/Temp-ActivationStatus" });
                    window.open(route.href,'_self');
                    return;
					

					
        	    })
            }
	    }
    
    }  
	
</script>