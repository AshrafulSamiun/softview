<template>

	<div class="row" style="">
		<div class="col-md-6 col-sm-6 offset-md-3" >
			<div class="card card-default widget wow fadeInDown animated " style="margin-top:50px; animation-delay: 0.18s;">
				<div class="card-heading">
									
					<form @submit.prevent="updateManagementType()" @keydown="form.onKeydown($event)">

						<table class="table-borderless" width="750" align="left">

							<tbody>
						       	
						    	<tr>
						    		<td width="30%">
						            	<div class="form-lebel" align="left">
						                    <h4>Industry Type:</h4>
						                </div>
						            </td>
						            <td>
										<select v-model="form.industry_type"
		                                    name="industry_type"
		                                    class="custom-select" 
		                                    :class="{ 'is-invalid': form.errors.has('industry_type') }">
		                                    <option disabled value="">--Select-- </option>
		                                    <option v-for="(industry_type,index) in industry_type_arr" :value="index">{{industry_type}}</option>
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
            		industry_type:false,
                  	id:''

            	}),
            	industry_type_arr:[]
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
                let uri = '/IndustryType';
                window.axios.get(uri).then((response) => {

                	this.industry_type_arr  =response.data.industry_type_arr;
                	this.form.industry_type = response.data.ManagementType.industry_type;
                	this.form.id 			= response.data.ManagementType.id;
                	if(this.form.industry_type)
                		this.editmode=true;

                });   
            },

            updateManagementType()
            {
				
		        this.form.put('/IndustryType/'+this.form.id)
				    .then(()=>{
					    let route = this.$router.resolve({ path: "/Temp-ContactsPersons" });
		                window.open(route.href,'_self');
		                return;
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createManagementType()
            {
        	    this.form.post('/IndustryType') .then(({ data }) => { 
					
					let route = this.$router.resolve({ path: "/Temp-ContactsPersons" });
		            window.open(route.href,'_self');
		            return;
        	    })
            }
	    }
    
    }  
	
</script>