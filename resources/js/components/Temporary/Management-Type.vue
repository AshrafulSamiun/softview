<template>

	<div class="row" style="">
		<div class="col-md-6 col-sm-6 offset-md-3" >
			<div class="card card-default widget wow fadeInDown animated " style="margin-top:50px; animation-delay: 0.18s;">
				<div class="card-heading">
					
				
					<form @submit.prevent="editmode ? updateManagementType() : createManagementType()" @keydown="form.onKeydown($event)">

						<table class="table-borderless" width="750" align="left">

							<tbody>
						       	
						    	<tr>
						    		<td width="30%">
						            	<div class="form-lebel" align="left">
						                    <h4>Business Type:</h4>
						                </div>
						            </td>
						            <td>
										<select v-model="form.business_type"
		                                    name="business_type"
		                                    class="custom-select" 
		                                    :class="{ 'is-invalid': form.errors.has('business_type') }">
		                                    <option disabled value="">--Select-- </option>
		                                    <option v-for="(business_type,index) in business_type_arr" :value="index">{{business_type}}</option>
		                                </select>
                                  	</td>
                                </tr>
                                <tr>
                                	<td></td>
						    		<td  align="left">
						                										    
									    &nbsp;	
						    		</td>

						    	</tr>
                                <tr>
                                	<td></td>
						    		<td  align="left">
						                										    
									    <button type="submit" 
									    	class="btn btn-primary">Next 
									    	<i class="fa fa-angle-right"></i></button>	
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
	import {ref} from "vue";
	
    export default {
        name:'list-product-categories',
       
        data(){
            return{
            	editmode:false,
				filter: '',
            	form:new Form({
            		business_type:false,
                  	id:''

            	}),
            	business_type_arr:[]
      
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

                	this.business_type_arr  =response.data.business_type_arr;
                	this.form.business_type = response.data.ManagementType.business_type;
                	this.form.id 			= response.data.ManagementType.id;

                	if(this.form.id){
                		this.editmode 		=true;
                	}
                });   
            },

            updateManagementType()
            {
				
		        this.form.put('/PropertyManagementTypes/'+this.form.id)
				    .then(()=>{
					    let route = this.$router.resolve({ path: "/Temp-IndustryType" });
		                window.open(route.href,'_self');
		                return;
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createManagementType()
            {
            	//alert(this.form.business_type);return;
        	    this.form.post('/PropertyManagementTypes') .then(({ data }) => { 
					
					let route = this.$router.resolve({ path: "/Temp-IndustryType" });
		            window.open(route.href,'_self');
		            return;
        	    })
            }
	    }
    
    }  
	
</script>