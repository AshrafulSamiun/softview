<template>

	<div class="row">
      <div class="col-md-12 col-sm-12" >
        <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">
            
			<div class="card-heading">
				<div>
					<div align="left" style="float:left">
						<h2>Floor</h2>
					</div>

					<div align="right" style="float:right">
						<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewFloor" @click.prevent="addMenu()">Create New Floor</button>
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
		                    <td>{{ row.floor_name }}</td>
		                    <td>{{ row.total_rooms }}</td>
		                    <td>{{ row.total_suits }}</td>

		                    <td>{{ row.amenities_floor_string }}</td>
		                    <td>{{ row.meeting_string }}</td> 
		                    <td>{{ row.swiming_poll_string }}</td>
		                    <td>{{ row.sunna_string }}</td>

		                    <td>{{ row.status }}</td>
		                    <td>
		                    	<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewFloor" @click.prevent="editMenu(row)">Edit</button>
		                    	<button v-show="delete_permission" class="btn btn-danger btn-sm" @click.prevent="deletemenu(row.id)">Delete</button>
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


      	<div class="modal fade" id="addNewFloor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  >
				  <div class="modal-dialog" role="document">
				    <div class="modal-content" style="width:850px;">
                    
				      <div class="modal-header">
                        <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmode" id="">Add New Floor</h5>
						<h5 class="modal-title" v-show="editmode" id="">Update Floor</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
                      
				      <div class="modal-body">
				         <form @submit.prevent="editmode ? updateMenu() : createMenu()" @keydown="form.onKeydown($event)">

				         	<table width="100%" class="">
								
									<tbody>
									
								    	<tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                   Floor Name:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.floor_name" type="text" name="floor_name" class="form-control" :class="{ 'is-invalid': form.errors.has('floor_name') }">
												    <has-error :form="form" field="floor_name"></has-error>
								                </div>
								    		</td>

								    		<td>
								            	<div class="form-lebel" align="right">
								                    Total Rooms:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.total_rooms" type="text" name="total_rooms" class="form-control" :class="{ 'is-invalid': form.errors.has('total_rooms') }">
												    <has-error :form="form" field="total_rooms"></has-error>
								                </div>
								    		</td>
								    	</tr>

								        <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    One Bed Rooms:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<input v-model="form.one_room" type="number" name="one_room" class="form-control" :class="{ 'is-invalid': form.errors.has('one_room') }" >
												    <has-error :form="form" field="one_room"></has-error>
								                </div>
								    		</td>
								    		
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Two Bed Rooms:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<input v-model="form.two_room" type="number" name="two_room" class="form-control" :class="{ 'is-invalid': form.errors.has('two_room') }">
												    <has-error :form="form" field="two_room"></has-error>
								                </div>
								    		</td>
								    	</tr>

								        <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Three Bed Rooms:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.three_room" type="number" name="three_room" class="form-control" :class="{ 'is-invalid': form.errors.has('three_room') }">
												    <has-error :form="form" field="three_room"></has-error>
								                </div>
								    		</td>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Total Suits:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.total_suits" type="text" name="total_suits" class="form-control" :class="{ 'is-invalid': form.errors.has('total_suits') }">
												    <has-error :form="form" field="total_suits"></has-error>
								                </div>
								    		</td>
								    	</tr>

								        <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Amenities floor:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<select v-model="form.amenities_floor" type="amenities_floor" name="amenities_floor"
												        class="form-control" :class="{ 'is-invalid': form.errors.has('amenities_floor') }">
														<option disabled value="">Please select</option>
														<option value="1">Yes</option>
														<option value="2">No</option>
													</select>
												    <has-error :form="form" field="amenities_floor"></has-error>
								                </div>
								    		</td>
								    	
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Meeting:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													
													<select v-model="form.meeting" type="meeting" name="meeting"
												        class="form-control" :class="{ 'is-invalid': form.errors.has('meeting') }">
														<option disabled value="">Please select</option>
														<option value="1">Yes</option>
														<option value="2">No</option>
													</select>
												    <has-error :form="form" field="meeting"></has-error>
								                </div>
								    		</td>
								  		</tr>

								        <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                   Swimming Pool:
								                </div>
								            </td>
								    		<td >
												<div class="form-group">
													
													<select v-model="form.swiming_poll" type="swiming_poll" name="swiming_poll"
												        class="form-control" :class="{ 'is-invalid': form.errors.has('swiming_poll') }">
														<option disabled value="">Please select</option>
														<option value="1">Yes</option>
														<option value="2">No</option>
													</select>
												    <has-error :form="form" field="swiming_poll"></has-error>
								                </div>
								            </td>
								    
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Sauna:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													
													<select v-model="form.sunna" type="sunna" name="sunna"
												        class="form-control" :class="{ 'is-invalid': form.errors.has('sunna') }">
														<option disabled value="">Please select</option>
														<option value="1">Yes</option>
														<option value="2">No</option>
													</select>
												    <has-error :form="form" field="sunna"></has-error>
								                </div>
								    		</td>
								  		</tr>

								        <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                   Gym:
								                </div>
								            </td>
								    		<td >
												<div class="form-group">
													
													<select v-model="form.gym" type="gym" name="gym"
												        class="form-control" :class="{ 'is-invalid': form.errors.has('gym') }">
														<option disabled value="">Please select</option>
														<option value="1">Yes</option>
														<option value="2">No</option>
													</select>
												    <has-error :form="form" field="gym"></has-error>
								                </div>	
											</td>
								    	

								    		<td>
								            	<div class="form-lebel" align="right">
								                   Status:
								                </div>
								            </td>
								    		<td >
												<div class="form-group">
													
													<select v-model="form.status_active" type="status_active" name="status_active"
												        class="form-control" :class="{ 'is-invalid': form.errors.has('status_active') }">
														<option disabled value="">Please select</option>
														<option value="1">Active</option>
														  <option value="2">Inactive</option>
														  <option value="3">Cancel</option>
													</select>
												    <has-error :form="form" field="status_active"></has-error>
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
            		floor_name:'',
            		total_rooms:0,
            		one_room:0,
            		two_room:0,
                  	three_room:0,

                  	total_suits:0,
            		amenities_floor:2,
            		meeting:2,
            		swiming_poll:2,
                  	sunna:2,
                  	gym:2,
            		status_active:1,
                  	id:''

            	}),
				columns: [
		            
		            { label: 'SL', field: 'id', align: 'center' },
		            { label: 'Floor Name', field: 'floor_name' },
		            { label: 'Total Room', field: 'total_rooms' },
		            { label: 'Total Suits', field: 'total_suits' },
		            { label: 'Amenities floor', field: 'amenities_floor_string' },
		            { label: 'Meeting', field: 'meeting_string' },
		            { label: 'Swimming Pool', field: 'swiming_poll_string' },
		            { label: 'Gym', field: 'gym_string' },
		            { label: 'Status', field: 'status' },
		            { label: '', field: '', sortable: false },
		        ],
		       	rows: [],
		      	row:{
		       },
		  
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
            this.fetchFloors();
            this.fetchPermisitions();
           
        },
		
	    methods: {

	    	// fetchPermisitions()
      //       {

      //           let uri = '/UserPermission/'+this.user_menu_name;
      //           window.axios.get(uri).then((response) => {
      //             this.save_permission= response.data.user_permission[0].save_priv;
      //             this.update_permission= response.data.user_permission[0].update_priv;
      //             this.delete_permission= response.data.user_permission[0].delete_priv;

      //             if(this.save_permission==1)     this.save_permission=true;    else this.save_permission=false;
      //             if(this.update_permission==1)   this.update_permission=true;  else this.update_permission=false;
      //             if(this.delete_permission==1)   this.delete_permission=true;  else this.delete_permission=false;
      //           });  
      //       },
            
	        fetchFloors()
            {
                let uri = '/Floors';
                window.axios.get(uri).then((response) => {
                	this.rows = response.data.floor_data;
                });   
            },

        

            editMenu(row){
                this.form.reset();
				this.editmode=true;
               // $("#addNewFloor").modal('show');
			//	$('.modal.fade').addClass('modal fade in show');
              //  $('modal-backdrop').addClass('modal-backdrop fade in show') ;
                this.form.fill(row);
            },
            addMenu(){

                this.form.reset();
				this.editmode=false;				
             
               
            },

            updateMenu()
            {
				
		        this.form.put('/Floors/'+this.form.id)
				    .then(()=>{
					       //success
					      $('.modal.in').modal('hide');
					      $('.modal-backdrop').remove() ;
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchFloors();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createMenu()
            {
        	    this.form.post('/Floors') .then(({ data }) => { 
               
					$('.modal.in').modal('hide');
					$('.modal-backdrop').remove() ;
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchFloors();
        	    })
            },
            deletemenu(id)
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

	                  this.form.delete('/Floors/'+id).then(()=>{
	                    
	                      if(result.value) {
	                           Swal(
	                            'Deleted!',
	                            'Your file has been deleted.',
	                            'success'
	                          );
	                          this.fetchFloors();
	                      }            

	                  }).catch(()=>{
	                    Swal("failed!","there was some wrong","warning");
	              });
               
              })
            }
	    }
    
    }  
	
</script>