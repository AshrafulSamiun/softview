<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateTermOfAggrement() : createTermOfAggrement()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Terms of agreement </h1>
               
                <div class="row">
                    <div class="col-md-10 offset-md-1 col-sm-12 col-xs-12"> 
                        <div class="form-box-outer">
                            <p><strong>Here's a simple demo User Agreement in point form for your website, Prop Market:
                            User Agreement for Prop Market.</strong></p>

                            <p><strong>1. Acceptance of Terms</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	- By accessing or using Prop Market, you agree to comply with and be bound by these terms and conditions.
                            </p>

                            <p><strong>2. Eligibility</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	   - Users must be at least 18 years old and capable of entering into legally binding agreements to use the site.
                            </p>

                            <p><strong>3. Account Registration</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	   - Users must provide accurate and complete information during registration.<br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									   - Users are responsible for maintaining the confidentiality of their account information.
                            </p>

                            <p><strong>4. Use of the Site</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	- Users agree to use the site only for lawful purposes and in accordance with these terms.<br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

									- Posting of false or misleading job listings or property information is prohibited.
                            </p>

                            <p><strong>5. Content Ownership</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	   - All content posted by users remains their property, but by posting on Prop Market, users grant us a non-exclusive, royalty-free license to use, display, and distribute the content.
                            </p>

                            <p><strong>6. Prohibited Conduct</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									- Users shall not engage in any activity that is harmful, fraudulent, or otherwise objectionable.
									<br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								- Users are prohibited from scraping, hacking, or engaging in any activity that disrupts the site's functionality.

                            </p>

                            <p><strong>7. Privacy</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	 - Users' personal information will be handled in accordance with our Privacy Policy.
                            	 <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									- We will not share users' personal information with third parties without consent.
                            </p>

                            <p><strong>8. Termination</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	   - We reserve the right to suspend or terminate users' access to the site for any violation of these terms.
                            </p>
                           
                            <p><strong>9. Disclaimers</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	   - Prop Market is provided "as is" without warranties of any kind.
                            	   <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								   - We do not guarantee the accuracy or reliability of any content posted by users.
                            </p>

                            <p><strong>10. Limitation of Liability</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	- By accessing or using Prop Market, you agree to comply with and be bound by these terms and conditions.
                            </p>

                            <p><strong>11. Indemnification</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	 - Users agree to indemnify and hold Prop Market harmless from any claims arising from their use of the site.
                            </p>

                            <p><strong>12. Governing Law</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	    - These terms shall be governed by and construed in accordance with the laws of the jurisdiction in which Prop Market operates.
                            </p>

                            <p><strong>13. Modifications to Terms</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	    - We reserve the right to modify these terms at any time, and users agree to be bound by such modifications.
                            </p>

                            <p><strong>14. Contact Information</strong> <br/>
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	    - For any questions regarding these terms, users can contact us at [contact email].
                            </p>
                            

                          

                        </div>
                    </div>
                    
                </div>
                   
            </div>
                        
            <button type="button" @click="previous_step" class="btn btn-primary"><i class="fa fa-angle-left"></i> Previous</button>           
            <button :disabled="form.busy" v-show="!editmode" type="submit" class="btn btn-primary">Agree</button>
            <button :disabled="form.busy"  @click="updateTermOfAggrement" type="button" class="btn btn-outline-dark">Decline</button>
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
                	                	
                	if(response.data.project_status==98){
                		this.editmode=true;
                	}                	
                });   
            },

          
            updateTermOfAggrement()
            {
            
		        this.form.put('/TermsOfAggrements/'+100)
				    .then(()=>{
					       //success
					     
							showToast('Data Update Successfully', 'success');
					
					     this.fetchTermOfAggrement();
				    })
				    .catch(()=>{
					   showToast("there was some wrong","warning");
				
				    });
            },
            
            createTermOfAggrement()
            {
            	
            	//Swal("failed!","Please Aggree with Terms of Aggreement.","warning");

            	
        	    this.form.post('/TermsOfAggrements') .then(({ data }) => { 
               
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.fetchTermOfAggrement();
        	    });
            }
	    }
    
    }

	
</script>
