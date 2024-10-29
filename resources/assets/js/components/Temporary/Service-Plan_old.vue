<template>

	<div class="row" style="">
		<div class="col-md-8 col-sm-6 offset-md-1" >
			<div class="card card-default widget wow fadeInDown animated " style="margin-top:50px; animation-delay: 0.18s;">
				<div class="card-heading">
					<div>
						<div align="left" style="float:left">
							<h2>Service Plans</h2>
						</div>

				
					</div>

				</div>




				<div class="card-body">
					<form @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">

						<table class="table-borderless" width="100%" align="left">
							<thead style="line-height:30px;">

                            
                           	  <tr >
                                <th bgcolor="#aaa" style="color:#fff;text-align:center">Numbers of</th>
                               
                                <th bgcolor="#aaa" style="color:#fff;text-align:center">Qty</th>
                                <th bgcolor="#aaa" style="color:#fff;text-align:center">Rate</th>
                                <th bgcolor="#aaa" style="color:#fff;text-align:center">Amount</th>
                            </tr>
                            </thead>
							<tbody>
						       	<tr style="cursor:pointer" v-for="(master_plan_data,index) in master_plan_arr" id="tr_" 
						        	>

						        	<td align="left" bgcolor="#fff" style="color:#000;vertical-align:middle;">
						        	 <strong>{{master_plan_data.plan_name}}</strong>
	                                  <input type="hidden" v-bind:id="'plan_id_'+index" v-bind:name="'plan_id_'+index" v-bind:value="index">
	                                  <input type="hidden" v-bind:id="'amount_applicable_'+index" v-bind:name="'amount_applicable_'+index" >
	                                  <input type="hidden" v-bind:id="'rate_applicable_'+index" v-bind:name="'rate_applicable_'+index" >
	                                 
	                                  
	                                    <i  class=" right fas fa-angle-down" v-if="master_plan_data.amount_applicable==0"></i>
	                                    
	                                  
	                                  
	                                </td>
						    		
                      </tr>
                      
                      <tr>
					        		   <td>
					        		

				                       	<div class="form-group">
					                        <button :disabled="form.busy" v-show="!editmode" type="submit" class="btn btn-primary">Save</button>
									      	<button :disabled="form.busy" v-show="editmode" type="submit" class="btn btn-primary">Update</button>
									      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
	import Vue from 'vue';
	

	


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
                  	id:'',
                  	legal_name:'',
                  	business_registration_number:'',
                  	registration_date:'',
                  	business_registration_city:'',
                  	business_registration_state:'',
                  	registration_country:'',
                  	business_license_no:'',
                  	issued_by:'',
                  	license_country:'',
                  	expirey_date:'',
                  	head_office_email:'',
                  	head_office_fax_no:'',
                  	head_office_cell_phone:'',
                  	head_office_website:'',


                  	contact_person_email:'',
                  	contact_person_fax_no:'',
                  	contact_person_cell_phone:'',
                  	contact_person_website:'',
                  	business_number:'',
                  	emp_identification_number:'',
                  	payroll:'',
                  	sales_tax:'',
                  	income_tax:'',
                  	import_and_export:'',

                  	dependent_residential_suite:'',
                  	dependent_residental_parking_lot:'',
                  	dependent_residental_storage_lot:'',
                  	dependent_commercial_unit:'',
                  	dependent_commercial_parking_lot:'',

                  	dependent_commercial_storage_lot:'',
                  	independent_residential_suite:'',
                  	independent_residental_parking_lot:'',
                  	independent_residental_storage_lot:'',
                  	independent_commercial_unit:'',
                  	independent_commercial_parking_lot:'',
                  	independent_commercial_storage_lot:'',


                  	rantal_suite_unit:'',
                  	buy_and_sell_suite_unit:'',
                  	rental_parking:'',
                  	rental_storage:'',
                  	landholders_residency:'',


            	}),

            	master_plan_arr:'',
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchCompanyProfile();
           
        },
		
	    methods: {

	    	
            
	        fetchCompanyProfile()
            {
                let uri = '/UserServicePlans';
                window.axios.get(uri).then((response) => {
                	this.master_plan_arr 				= response.data.master_plan_arr;
                	
                	/*if(this.form.id){
                		this.editmode=true;
                	}*/

                	//this.countries 								=response.data.country_arr;
                	
                });   
            },

          
         
       

            updateCompanyProfile()
            {
				
		        this.form.put('/AccountSetups/'+this.form.id)
				    .then(()=>{
					       //success
					     
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchCompanyProfile();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createCompanyProfile()
            {

        	    this.form.post('/AccountSetups') .then(({ data }) => { 
               
					
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchCompanyProfile();
        	    })
            }
	    }
    
    }  
	
</script>