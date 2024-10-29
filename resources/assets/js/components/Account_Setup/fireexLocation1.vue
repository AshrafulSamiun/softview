<template>

	<div class="row">
      <div class="col-md-12 col-sm-12" >
        <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">
            
			<div class="card-heading">
				<div>
					<div align="left" style="float:left">
						<h2>FireExtinguisherLocations</h2>
					</div>

					<div align="right" style="float:right">
						<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewFireExtinguisherLocations" @click.prevent="addFireExtinguisherLocations()">Create New Fire Extinguisher Location</button>
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
		                    <td>{{ row.fire_extingusher }}</td>
		                    <td>{{ row.floor_name_string }}</td>
		                    <td>{{ row.Location }}</td>

		                    <td>{{ row.expiration_date }}</td>
		                    <td>{{ row.service_provider }}</td>

		                    <td>{{ row.status }}</td>
		                    <td>
		                    	<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewFireExtinguisherLocations" @click.prevent="editFireExtinguisherLocations(row)">Edit</button>
		                    	<button v-show="delete_permission" class="btn btn-danger btn-sm" @click.prevent="deleteFireExtinguisherLocations(row.id)">Delete</button>
		                    </td>
		                </tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
			</div>  
        </div>

        <!--  MOdel  -->
		 

		<!-- model end -->
        
      </div><!-- /.col-md-12 -->


      	<div class="modal fade" id="addNewFireExtinguisherLocations" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  >
				  <div class="modal-dialog" role="document">
				    <div class="modal-content" style="width:850px;">
                    
				      <div class="modal-header">
                        <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmode" id="">Add New Fire Extinguisher Location</h5>
						<h5 class="modal-title" v-show="editmode" id="">Update Fire Extinguisher Location</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
                      
				      <div class="modal-body">
				         <form @submit.prevent="editmode ? updateFireExtinguisherLocations() : createFireExtinguisherLocations()" @keydown="form.onKeydown($event)">

				         	<table width="100%" class="">
								
									<tbody>
									
								    	<tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                   Fire Extinguisher :
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.fire_extingusher" type="text" name="fire_extingusher" class="form-control" :class="{ 'is-invalid': form.errors.has('fire_extingusher') }">
												    <has-error :form="form" field="fire_extingusher"></has-error>
								                </div>
								    		</td>
								    		<td>
								            	<div class="form-lebel" align="right">
								                   Floor Name:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
												
												    <select v-model="form.floor_name" type="floor_name" name="floor_name"
												        class="form-control" :class="{ 'is-invalid': form.errors.has('floor_name') }">
														<option disabled value="">Please select Floor</option>
														<option v-for="(Floor,index) in FloorArr" :value="index">{{Floor}}</option>
													</select>
												    <has-error :form="form" field="floor_name"></has-error>
								                </div>
								    		</td>
								    	</tr>

								        <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Location:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.Location" type="text" name="Location" class="form-control" :class="{ 'is-invalid': form.errors.has('Location') }">
												    <has-error :form="form" field="Location"></has-error>
								                </div>
								    		</td>
								    
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Expiration date :
								                </div>
								            </td>

								    		<td>
								                <div class="form-group">
												
													<date-picker 
								                     	v-model="fiscal_year.expiration_date"
								                   
								                     	lang="en"
								                     	type="date"
								                     	style="width:100%;"
								                     	placeholder="From Date" 
								                     	format="YYYY-MM-DD"></date-picker>
												    <has-error :form="form" field="expiration_date"></has-error>
								                </div>
								    		</td>
										</tr>

								        <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Renew of Recharge Date:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<date-picker 
								                     	v-model="fiscal_year.recharge_date"
								                   
								                     	lang="en"
								                     	type="date"
								                     	style="width:100%;"
								                     	placeholder="Renew of Recharge Date" 
								                     	format="YYYY-MM-DD"></date-picker>
												    <has-error :form="form" field="recharge_date"></has-error>
								                </div>
								    		</td>
								   
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Service Provider Name:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.service_provider" type="text" name="service_provider" class="form-control" :class="{ 'is-invalid': form.errors.has('service_provider') }">
												    <has-error :form="form" field="service_provider"></has-error>
								                </div>
								    		</td>
								    	</tr>
								    	 <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Phone:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.phone" type="text" name="phone" class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
												    <has-error :form="form" field="phone"></has-error>
								                </div>
								    		</td>
								   
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Email:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.email" type="text" name="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
												    <has-error :form="form" field="email"></has-error>
								                </div>
								    		</td>
								    	</tr>
								    	<tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Reminder 1:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.reminder_one" type="text" name="reminder_one" class="form-control" :class="{ 'is-invalid': form.errors.has('reminder_one') }">
												    <has-error :form="form" field="reminder_one"></has-error>
								                </div>
								    		</td>
								   
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Reminder 2:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.reminder_two" type="text" name="reminder_two" class="form-control" :class="{ 'is-invalid': form.errors.has('reminder_two') }">
												    <has-error :form="form" field="reminder_two"></has-error>
								                </div>
								    		</td>
								    	</tr>
								        <tr>
								    		
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Reminder 3:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.reminder_three" type="text" name="reminder_three" class="form-control" :class="{ 'is-invalid': form.errors.has('reminder_three') }">
												    <has-error :form="form" field="reminder_three"></has-error>
								                </div>
								    		</td>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Status:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<select v-model="form.status_active" type="status_active" name="status_active"
												        class="form-control" :class="{ 'is-invalid': form.errors.has('status_active') }">
														<option disabled value="">Please select</option>
														<option value="1">Yes</option>
														<option value="2">No</option>
													</select>
												    <has-error :form="form" field="status_active"></has-error>
								                </div>
								    		</td>
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

								        <tr>
								    		
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
            		fire_extingusher:'',
            		floor_name:'',
            		Location:'',
            		reminder_three:'',
            		reminder_two:'',
            		reminder_one:'',
            		expiration_date:'',
            		recharge_date:'',
                  	service_provider:'',
            		phone:'',
            		email:'',
            		status_active:1,
                  	id:''

            	}),
				columns: [
		            
		            { label: 'SL', field: 'id', align: 'center' },
		            { label: 'Fire Extinusher Name', field: 'fire_extingusher' },
		            { label: 'Floor Name', field: 'floor_name_string' },
		            { label: 'Location', field: 'Location' },
		            { label: 'Expiration Date', field: 'expiration_date' },
		            { label: 'Service Provider', field: 'service_provider' },
		            { label: 'Status', field: 'status' },
		            { label: '', field: '', sortable: false },
		        ],
		       	rows: [],
		      	row:{
		       },
		  		FloorArr:[],
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
            this.fetchFireExtinguisher();
           // this.fetchPermisitions();
           
        },
		
	    methods: {

	    	// fetchPermisitions()
      //       {

      //           let uri = '/UserPermission/'+this.user_fire_extingusher;
      //           window.axios.get(uri).then((response) => {
      //             this.save_permission= response.data.user_permission[0].save_priv;
      //             this.update_permission= response.data.user_permission[0].update_priv;
      //             this.delete_permission= response.data.user_permission[0].delete_priv;

      //             if(this.save_permission==1)     this.save_permission=true;    else this.save_permission=false;
      //             if(this.update_permission==1)   this.update_permission=true;  else this.update_permission=false;
      //             if(this.delete_permission==1)   this.delete_permission=true;  else this.delete_permission=false;
      //           });  
      //       },
            
	        fetchFireExtinguisher()
            {
                let uri = '/FireExtinguisherLocations';
                window.axios.get(uri).then((response) => {
                	this.rows = response.data.FireExtinguisherLocations_data;
                	this.FloorArr = response.data.floor_data;
                });   
            },

        

            editFireExtinguisherLocations(row){
                this.form.reset();
				this.editmode=true;
               // $("#addNewFireExtinguisherLocations").modal('show');
			//	$('.modal.fade').addClass('modal fade in show');
              //  $('modal-backdrop').addClass('modal-backdrop fade in show') ;
                this.form.fill(row);
            },
            addFireExtinguisherLocations(){

                this.form.reset();
				this.editmode=false;				
             
               
            },

            updateFireExtinguisherLocations()
            {
				
		        this.form.put('/FireExtinguisherLocations/'+this.form.id)
				    .then(()=>{
					       //success
					      $('.modal.in').modal('hide');
					      $('.modal-backdrop').remove() ;
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchFireExtinguisher();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createFireExtinguisherLocations()
            {
        	    this.form.post('/FireExtinguisherLocations') .then(({ data }) => { 
               
					$('.modal.in').modal('hide');
					$('.modal-backdrop').remove() ;
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchFireExtinguisher();
        	    })
            },
            deleteFireExtinguisherLocations(id)
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

	                  this.form.delete('/FireExtinguisherLocations/'+id).then(()=>{
	                    
	                      if(result.value) {
	                           Swal(
	                            'Deleted!',
	                            'Your file has been deleted.',
	                            'success'
	                          );
	                          this.fetchFireExtinguisher();
	                      }            

	                  }).catch(()=>{
	                    Swal("failed!","there was some wrong","warning");
	              });
               
              })
            }
	    }
    
    }  
	
</script>