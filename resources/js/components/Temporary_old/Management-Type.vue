<template>

	<div class="row" style="">
		<div class="col-md-6 col-sm-6 offset-md-3" >
			<div class="card card-default widget wow fadeInDown animated " style="margin-top:50px; animation-delay: 0.18s;">
				<div class="card-heading">
					<div>
						<div >
							<h3>Management Type</h3>
						</div>

				
					</div>

				</div>

				<div class="card-body">
					<form @submit.prevent="editmode ? updateManagementType() : createManagementType()" @keydown="form.onKeydown($event)">

						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
                            	<div class="form-check-inline" align="left">
	                            
	                                <input type="checkbox" 
	                                    id="security_guard" 
	                                    name="security_guard"
	                                    @click="check_management_type($event,1)" 
	                                    v-model="form.security_guard">
	                                <label for="security_guard">Security Guard</label><br>

	                                <input type="checkbox" 
	                                    id="concierge" 
	                                    name="concierge" 
	                                    @click="check_management_type($event,2)"
	                                    v-model="form.concierge">
	                                <label for="concierge">Concierge</label><br>
	                               
                               </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                            	<div class="form-check-inline" align="left">
	                            
	            					<input type="checkbox" 
	                                    id="concierge_security" 
	                                    name="concierge_security"
	                                    @click="check_management_type($event,3)" 
	                                    v-model="form.concierge_security">
	                                <label for="concierge_security">Concierge &  Security</label><br>

	                                <input type="checkbox" 
	                                    id="artimis" 
	                                    name="artimis" 
	                                    @click="check_management_type($event,4)"
	                                    v-model="form.artimis">
	                                <label for="artimis">Artemis</label><br>

	             <!-----------------<input type="checkbox" 
	                                    id="property_management" 
	                                    name="property_management" 
	                                    @click="check_management_type($event,5)"
	                                    v-model="form.property_management">
	                                <label for="property_management">Property Management</label><br>----->
                               </div>
                            </div>

                        </div>

                       <button type="submit"  class="btn btn-primary">Next <i class="fa fa-angle-right"></i></button>

					  
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

            		security_guard:false,
            		concierge:false,
            		concierge_security:false,
            		artimis:false,
            		property_management:false,
                  	id:''

            	}),
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchpropertyManagementType();
           
        },
		
	    methods: {

	    	
            check_management_type(e,type){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        this.form.security_guard=true;
                        this.form.concierge=false;
                        this.form.concierge_security=false;
                        this.form.artimis=false;
                        this.form.property_management=false;
                        
                    }
                    else if(type==2)
                    {
                        this.form.security_guard=false;
                        this.form.concierge=true;
                        this.form.concierge_security=false;
                        this.form.artimis=false;
                        this.form.property_management=false;
                    }
                    else  if(type==3)
                    {
                        this.form.security_guard=false;
                        this.form.concierge=false;
                        this.form.concierge_security=true;
                        this.form.artimis=false;
                        this.form.property_management=false;
                        
                    }
                    else if(type==4)
                    {
                        this.form.security_guard=false;
                        this.form.concierge=false;
                        this.form.concierge_security=false;
                        this.form.artimis=true;
                        this.form.property_management=false;
                    }
                    else if(type==5)
                    {
                        this.form.security_guard=false;
                        this.form.concierge=false;
                        this.form.concierge_security=false;
                        this.form.artimis=false;
                        this.form.property_management=true;
                    }
                }
                else{

                    this.form.security_guard=false;
                    this.form.concierge=false;
                    this.form.concierge_security=false;
                    this.form.artimis=false;
                    this.form.property_management=false;
                }               
            },

	        fetchpropertyManagementType()
            {
                let uri = '/PropertyManagementTypes';
                window.axios.get(uri).then((response) => {

                	this.form.security_guard 				= response.data.ManagementType.security_guard==1? true:false;
                	this.form.concierge 					= response.data.ManagementType.concierge==1? true : false;
                	this.form.concierge_security 			= response.data.ManagementType.concierge_security==1? true: false;
                	this.form.artimis 						= response.data.ManagementType.artimis==1? ture: false;
                	this.form.property_management 			= response.data.ManagementType.property_management==1? true:false;

                	this.form.id 							= response.data.ManagementType.id;
                	if(this.form.id){
                		this.editmode=true;
                	}
                	
                	
                });   
            },

            createManagementType()
            {
        	    this.form.post('/PropertyManagementTypes') .then(({ data }) => { 
               
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					let route = this.$router.resolve({ path: "/Temp-ServicePlan" });
			      	window.open(route.href,'_self');
			      	return;
        	    })
            },

                

            updateManagementType()
            {
				
		        this.form.put('/PropertyManagementTypes/'+this.form.id)
				    .then(()=>{
					       //success					     
					
						showToast('Data Update Successfully', 'success');
					
					    let route = this.$router.resolve({ path: "/Temp-ServicePlan" });
			      		window.open(route.href,'_self');
				    })
				    .catch(()=>{
					   showToast("There was some wrong","warning");				
				    });
            },
            
           
	    }
    
    }  
	
</script>