<template>

	<div class="row">
      <div class="col-md-12 col-sm-12" >
        <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">
            
			<div class="card-heading">
				<div>
					<div align="left" style="float:left">
						<h2>Service Plan</h2>
					</div>

					<div align="right" style="float:right">
						<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewServicePlan" @click.prevent="addServicePlan()">Create New Service Plan</button>
					</div>
				</div>

			</div>
			<div class="card-body">
				<div class="pull-left">
					<label for="filter" class="sr-only">Filter</label>
					<input type="text" class="form-control" v-model="filter" placeholder="Filter" style="width:400px;">
				</div>
				<datatable :columns="columns" :data="rows" :filter-by="filter">
					<template slot-scope="{row}">
						<tr>
		                    
		                    <td>{{ row.id}}</td>
		                    <td>{{ row.plan_name }}</td>
		                    <td>{{ row.master_plan_name }}</td>
		                    <td>{{ row.amount_applicable_st }}</td>
		                    
		                    <td>{{ row.plan_a }}</td>
		                    <td>{{ row.plan_b }}</td>
		                    <td>{{ row.plan_c }}</td>
		                    <td>{{ row.plan_d }}</td>
		                    <td>{{ row.position }}</td>
		                    <td>{{ row.slno }}</td>
		                    <td>{{ row.status_st }}</td>
		                    <td>
		                    	<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewServicePlan" @click.prevent="editServicePlan(row)">Edit</button>
		                    	<button v-show="delete_permission" class="btn btn-danger btn-sm" @click.prevent="deleteServicePlan(row.id)">Delete</button>
		                    </td>
		                </tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
			</div>  
        </div>

        <!--  MOdel  -->
		 	<div class="modal fade" id="addNewServicePlan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  >
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
                    
				      <div class="modal-header">
                        <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmode" id="">Add New Service Plan</h5>
						<h5 class="modal-title" v-show="editmode" id="">Update Service Plan</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
                      
				      <div class="modal-body">
				        <form @submit.prevent="editmode ? updateServicePlan() : createServicePlan()" @keydown="form.onKeydown($event)">

				         	<table width="100%" class="">
								
								<tbody>
								
							    	<tr>
							    		<td width="150">
							            	<div class="form-lebel" align="right">
							                   Plan Name:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.plan_name" type="text" name="plan_name" class="form-control" :class="{ 'is-invalid': form.errors.has('plan_name') }">
										      	<has-error :form="form" field="plan_name"></has-error>
											  	<input v-model="form.id" type="hidden" name="id">
							                </div>
							    		</td>

							    		
							    	</tr>

							        <tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Master Plan:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<select v-model="form.master_plan_id" type="master_plan_id" name="master_plan_id" class="form-control" :class="{ 'is-invalid': form.errors.has('master_plan_id') }">
							        				<option disabled value="">Please select Plan</option>
									  				<option v-for="(master_plan,index) in master_plan_arr" :value="index">{{master_plan}}</option>									  
												</select>
							                </div>
							    		</td>
							    		
							    		
							    	</tr>

							        <tr>
							    		
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Amount Applicable :
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<select v-model="form.amount_applicable" type="amount_applicable" name="amount_applicable"
											        class="form-control" :class="{ 'is-invalid': form.errors.has('amount_applicable') }">
													  <option disabled value="">Please Select </option>
													  <option value="1">Yes</option>
													  <option value="2">No</option>
												</select>
							                </div>
							    		</td>
							    	</tr>

							        <tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Plan A:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.plan_a" type="text" name="plan_a" class="form-control" :class="{ 'is-invalid': form.errors.has('plan_a') }">
										      	<has-error :form="form" field="plan_a"></has-error>
							                </div>
							    		</td>
							    	
							    		
							  		</tr>
							  		<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Plan B:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.plan_b" type="text" name="plan_b" class="form-control" :class="{ 'is-invalid': form.errors.has('plan_b') }">
										      	<has-error :form="form" field="plan_b"></has-error>
							                </div>
							    		</td>
							    	
							    		
							  		</tr>
							  		<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Plan C:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.plan_c" type="text" name="plan_c" class="form-control" :class="{ 'is-invalid': form.errors.has('plan_c') }">
										      	<has-error :form="form" field="plan_c"></has-error>
							                </div>
							    		</td>
							    	
							    		
							  		</tr>
							  		<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Plan D:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.plan_d" type="text" name="plan_d" class="form-control" :class="{ 'is-invalid': form.errors.has('plan_d') }">
										      	<has-error :form="form" field="plan_d"></has-error>
							                </div>
							    		</td>
							    	
							    		
							  		</tr>

							        <tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                   Position:
							                </div>
							            </td>
							    		<td >
											<div class="form-group">
												
												<input v-model="form.position" type="text" name="position" class="form-control" :class="{ 'is-invalid': form.errors.has('position') }">
											    <has-error :form="form" field="position"></has-error>
							                </div>
							            </td>
							    	</tr>

							        <tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Serial No:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												
												<input v-model="form.slno" type="text" name="slno" class="form-control" :class="{ 'is-invalid': form.errors.has('slno') }">
										      	<has-error :form="form" field="slno"></has-error>
							                </div>
							    		</td>
							  		</tr>

							        <tr>
							    		
							    	

							    		<td>
							            	<div class="form-lebel" align="right">
							                   Status:
							                </div>
							            </td>
							    		<td >
											 

							                <div class="form-group">
										      	
												<select v-model="form.status" type="status" name="status"
										        class="form-control" :class="{ 'is-invalid': form.errors.has('status') }">
												  	<option disabled value="">Please select Status</option>
												  	<option value="1">Active</option>
												  	<option value="2">Inactive</option>
												  	<option value="3">Cancel</option>
												</select>
										    </div>	
										</td>
									</tr>

							        <tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                   
							                </div>
							            </td>
							    		<td >
											<button :disabled="form.busy" v-show="!editmode && save_permission" type="submit" class="btn btn-primary btn-sm">Create</button>
										    <button :disabled="form.busy" v-show="editmode && update_permission" type="submit" class="btn btn-primary btn-sm">Update</button>
										    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
										</td>
							    	</tr>
		
								</tbody>
							</table>

							    
					    </form>
				      </div>
				      <div class="modal-footer">
				      </div>
				    </div>
				  </div>
			</div>

		<!-- model end -->
        
      </div><!-- /.col-md-12 -->
    </div>	

</template>

<script>
	import Vue from 'vue';
	import DatatableFactory from 'vuejs-datatable';	
	Vue.use(DatatableFactory);
	//var eventBus = new Vue();

	


    export default {
        name:'list-product-categories',
       
        data(){
            return{
            	editmode:false,
				save_permission:true,
				update_permission:true,
				delete_permission:true,
				filter: '',
				editmode:false,
            	form:new Form({
            		master_plan_id:'',
            		amount_applicable:'',
            		plan_a:'',
            		plan_b:'',
            		plan_c:'',
            		plan_d:'',
            		plan_name:'',
            		slno:'',
                  	status:'',
                  	position:'',
                  	id:''

            	}),
				columns: [
		            
		            { label: 'SL', field: 'id', align: 'center' },
		            { label: 'Service Plan Name', field: 'plan_name' },
		            { label: 'Master Plan', field: 'master_plan_name' },
		            { label: 'Amount Applicable', field: 'amount_applicable_st' },
		            { label: 'Plan A', field: 'plan_a' },
		            { label: 'Plan B', field: 'plan_b' },
		            { label: 'Plan C', field: 'plan_c' },
		            { label: 'Plan D', field: 'plan_d' },
		            { label: 'Position', field: 'position' },
		            { label: 'Serial No', field: 'slno' },
		            { label: 'Status', field: 'status_st' },
		            { label: '', field: '', sortable: false },
		        ],
		       	rows: [],
		      	row:{
		       		
		       },
		       master_plan_arr: [],
		      
             	//serialNo:0,
          		StatusArr:['Select','Active','Inactive','Cancell'],
				
				page: 1,
				per_page:10,
				expanded: null
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchServicePlans();
           
        },
		
	    methods: {

	    	
            
	        fetchServicePlans()
            {
                let uri = '/ServicePlans';
                window.axios.get(uri).then((response) => {
                	this.rows = response.data.service_plan_arr;
                	this.master_plan_arr=response.data.master_plan_arr;
                });   
            },

           

            editServicePlan(row){
                this.form.reset();
				this.editmode=true;
              
                this.form.fill(row);
            },
            addServicePlan(){

                this.form.reset();
				this.editmode=false;				
             
               
            },

            updateServicePlan()
            {
				
		        this.form.put('/ServicePlans/'+this.form.id)
				    .then(()=>{
					       //success
					      $('.modal.in').modal('hide');
					      $('.modal-backdrop').remove() ;
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchServicePlans();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createServicePlan()
            {
        	    this.form.post('/ServicePlans') .then(({ data }) => { 
               
					$('.modal.in').modal('hide');
					$('.modal-backdrop').remove() ;
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchServicePlans();
        	    })
            },
            deleteServicePlan(id)
            {            

	              Swal.fire({
	                title: 'Are you sure?',
	                text: "You won't be able to revert this!",
	                type: 'warning',
	                showCancelButton: true,
	                confirmButtonColor: '#3085d6',
	                cancelButtonColor: '#d33',
	                confirmButtonText: 'Yes, delete it!'
	              }).then((result) => {

	                  this.form.delete('/ServicePlans/'+id).then(()=>{
	                    
	                      if(result.value) {
	                           Swal(
	                            'Deleted!',
	                            'Your file has been deleted.',
	                            'success'
	                          );
	                          this.fetchServicePlans();
	                      }            

	                  }).catch(()=>{
	                    Swal("failed!","there was some wrong","warning");
	              });
               
              })
            }
	    }
    
    }  
	
</script>