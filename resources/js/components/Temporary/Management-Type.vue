<template>

	<div class="row" style="">
		<div class="col-md-6 col-sm-6 offset-md-3" >
			<div class="card card-default widget wow fadeInDown animated " style="margin-top:50px; animation-delay: 0.18s;">
				<div class="card-heading">
					<div>
						<div align="left" style="float:left">
							<h2>Management Type</h2>
						</div>

				
					</div>

				</div>




				<div class="card-body">
					<form @submit.prevent="editmode ? updateManagementType() : createManagementType()" @keydown="form.onKeydown($event)">

						<table class="table-borderless" width="350" align="left">

							<tbody>
						       	
						    	<tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Strata Management</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="strata_management" 
												id="strata_management"
												v-model="form.strata_management" >
											<label for="strata_management"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Co-op Property</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="coop_property" 
												id="coop_property"
												v-model="form.coop_property" >
											<label for="coop_property"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Freehold Management</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="free_hold_management" 
												id="free_hold_management"
												v-model="form.free_hold_management" >
											<label for="free_hold_management"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                   <strong> Leasehold Management</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="leasehold_management" 
												id="leasehold_management"
												v-model="form.leasehold_management" >
											<label for="leasehold_management"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                   <strong> Property Management Service Provider</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="property_management" 
												id="property_management"
												v-model="form.property_management" >
											<label for="property_management"></label>
										</div>
                                  	</td>
                                </tr>
                               
						    		
                                  			    	
						    	<tr>
						    		
						    		<td align="right">
						                
									    
									    <button 
											:disabled="form.busy" 
											v-show="!editmode" 
											type="submit" 
											class="btn btn-success">Save</button>
										<button 
											:disabled="form.busy" 
											v-show="editmode" 
											type="submit" 
											class="btn btn-success ">Update</button>

										
						                
						    		</td>
						    		<td align="right">
						            	<div class="form-lebel" align="right">
						                    <input v-model="form.id" type="hidden" name="id">
						                </div>
						            </td>

						    	</tr>
							</tbody>
					   	</table>

					  
					</form>
				</div>  
			</div>
		</div>
    </div>	

</template>

<script>


	


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
            this.fetchpropertyManagementType();
           
        },
		
	    methods: {

	    	
            
	        fetchpropertyManagementType()
            {
                let uri = '/PropertyManagementTypes';
                window.axios.get(uri).then((response) => {
                	this.form.strata_management 				= response.data.ManagementType.strata_management;
                	this.form.leasehold_management 				= response.data.ManagementType.leasehold_management;

                	this.form.free_hold_management 				= response.data.ManagementType.free_hold_management;

                	this.form.strata_management 				= response.data.ManagementType.strata_management;

                	this.form.coop_property 					= response.data.ManagementType.coop_property;

                	this.form.property_management 				= response.data.ManagementType.property_management;

                	this.form.id 								= response.data.ManagementType.id;
                	if(this.form.id){
                		this.editmode=true;
                	}
                	
                	

                	
                });   
            },

          
         
       

            updateManagementType()
            {
				
		        this.form.put('/PropertyManagementTypes/'+this.form.id)
				    .then(()=>{
					       //success
					     
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchpropertyManagementType();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createManagementType()
            {
            	//alert(this.form.strata_management);return;
        	    this.form.post('/PropertyManagementTypes') .then(({ data }) => { 
               
					
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchpropertyManagementType();
        	    })
            }
	    }
    
    }  
	
</script>