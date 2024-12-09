<template>

	<div class="row" style="">
		<div class="col-md-6 col-sm-6 offset-md-3" >
			<div class="card card-default widget wow fadeInDown animated " style="margin-top:50px; animation-delay: 0.18s;" align="center">
				<div class="card-heading">
					<div>
						<div >
							<h3><strong>Registration Instructions</strong></h3>
						</div>

				
					</div>

				</div>


				<div class="card-body">
					<form @submit.prevent="editmode ? updateManagementType() : createManagementType()" @keydown="form.onKeydown($event)">

						<p style="text-align:justify">To create an account, please ensure that all <label class="mendatordy-field">*</label>required fields are completed with accurate and legally valid information. You must be an authorized representative of the company you are registering. You will bear legal responsibility for any inaccuracies or false information provided.</p>

						<button type="button" @click="next_setp" class="btn btn-primary">Next <i class="fa fa-angle-right"></i></button>

					  
					</form>
				</div> 
				
			</div>
		</div>
    </div>	

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
            		strata_management:false,
            		coop_property:false,
            		free_hold_management:false,
            		leasehold_management:false,
            		property_management:false,
                  	id:''

            	}),
      
			}
        },
		
		created: function()
        {
            this.user_menu_name = this.$route.name;
        },
		
	    methods: {

	    	next_setp()
            {

        	    this.form.post('/RegistrationInstruction') .then(({ data }) => { 
                    var response_data=data.split("**");
	                    if(response_data[0]==1)
	                    {
	                        toast({
		                        type: 'success',
		                        title: 'Data Save successfully'
		                    });
		                    let route = this.$router.resolve({ path: "/Temp-CompanyProfile" });
               				window.open(route.href,'_self');
		                }

                 });

                
            },
           
            
            
	    }
    }  
	
</script>