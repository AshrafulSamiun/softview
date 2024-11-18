<template>

	<div class="row">
      <div class="col-md-12 col-sm-12" >
        <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">
            
			<div class="card-heading">
				<div>
					<div align="left" style="float:left">
						<h2>Tower Inspection Check List</h2>
					</div>

					<div align="right" style="float:right">
						<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewFloor" @click.prevent="addTowerCheckList()">Create New Tower Inspection Check List</button>
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
		                    <td>{{ row.room_name }}</td>
		                    <td>{{ row.frequench_check }}</td>
		                    <td>{{ row.inspection_task }}</td>

		                    <td>{{ row.inspection_by }}</td>
		                    <td>{{ row.send_report_to }}</td> 
		                    <td>{{ row.status }}</td>
		                    <td>
		                    	<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewFloor" @click.prevent="editTowerCheckList(row)">Edit</button>
		                    	<button v-show="delete_permission" class="btn btn-danger btn-sm" @click.prevent="deleteTowerCheckList(row.id)">Delete</button>
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
				        <h5 class="modal-title" v-show="!editmode" id="">Add New Tower Inspection Check List</h5>
						<h5 class="modal-title" v-show="editmode" id="">Update Tower Inspection Check List</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
                      
				      <div class="modal-body">
				         <form @submit.prevent="editmode ? updateTowerCheckList() : createTowerCheckList()" @keydown="form.onKeydown($event)">

				         	<table width="700" class="" align="left">
								
									<tbody>
									
								    	<tr>
								    		<td width="30%">
								            	<div class="form-lebel" align="right">
								                   Room Name:
								                </div>
								            </td>
								            <td >
								                <div class="form-group">
													<input v-model="form.room_name" type="text" name="room_name" class="form-control" :class="{ 'is-invalid': form.errors.has('room_name') }">
												    <has-error :form="form" field="room_name"></has-error>
								                </div>
								    		</td>
								    	</tr>
								    	 <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Frequency Check in a month:
								                </div>
								            </td>
								    		<td colspan="2">
								                <div class="form-group">
													<input v-model="form.frequench_check" type="number" name="frequench_check" class="form-control" :class="{ 'is-invalid': form.errors.has('frequench_check') }" >
												    <has-error :form="form" field="frequench_check"></has-error>
								                </div>
								    		</td>
								    	</tr>

								        <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Inspection task in details:
								                </div>
								            </td>
								            <td >
								                <div class="form-group">
													
													<textarea class="form-control"
								                  		name="inspection_task" 
								                  		rows="5" 
								                  		v-model="form.inspection_task"
								                  		:class="{ 'is-invalid': form.errors.has('inspection_task') }">
							                  		</textarea>
												    <has-error :form="form" field="inspection_task"></has-error>
								                </div>
								    		</td>
								    	
								    	</tr>

								        <tr>	
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Inspection By:
								                </div>
								            </td>
								    		<td >
								                <div class="form-group">
													<input v-model="form.inspection_by" type="text" name="inspection_by" class="form-control" :class="{ 'is-invalid': form.errors.has('inspection_by') }">
												    <has-error :form="form" field="inspection_by"></has-error>
								                </div>
								    		</td>
								    	</tr>

								        <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Send Report to:
								                </div>
								            </td>
								            <td >
								                <div class="form-group">
													<input v-model="form.send_report_to" type="text" name="send_report_to" class="form-control" :class="{ 'is-invalid': form.errors.has('send_report_to') }">
												    <has-error :form="form" field="send_report_to"></has-error>
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
            		room_name:'',
            		inspection_task:'',
            		frequench_check:0,
            		inspection_by:'',
                  	send_report_to:'',
            		status_active:1,
                  	id:''

            	}),
				columns: [
		            
		            { label: 'SL', field: 'id', align: 'center' },
		            { label: 'Room Name', field: 'room_name' },
		            { label: 'Frequency Check in a Month', field: 'frequench_check' },
		            { label: 'Inspection task in details', field: 'inspection_task' },
		            { label: 'Inspection By', field: 'inspection_by' },
		            { label: 'Send Report to', field: 'send_report_to' },
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
            this.fetchTowerCheckList();
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
            
	        fetchTowerCheckList()
            {
                let uri = '/TowserInspectionChecklists';
                window.axios.get(uri).then((response) => {
                	this.rows = response.data.tower_inspection_data;
                });   
            },

        

            editTowerCheckList(row){
                this.form.reset();
				this.editmode=true;
               // $("#addNewFloor").modal('show');
			//	$('.modal.fade').addClass('modal fade in show');
              //  $('modal-backdrop').addClass('modal-backdrop fade in show') ;
                this.form.fill(row);
            },
            addTowerCheckList(){

                this.form.reset();
				this.editmode=false;				
             
               
            },

            updateTowerCheckList()
            {
				
		        this.form.put('/TowserInspectionChecklists/'+this.form.id)
				    .then(()=>{
					       //success
					      $('.modal.in').modal('hide');
					      $('.modal-backdrop').remove() ;
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchTowerCheckList();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createTowerCheckList()
            {
        	    this.form.post('/TowserInspectionChecklists') .then(({ data }) => { 
               
					$('.modal.in').modal('hide');
					$('.modal-backdrop').remove() ;
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset();
					this.fetchTowerCheckList();
        	    })
            },
            deleteTowerCheckList(id)
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

	                  this.form.delete('/TowserInspectionChecklists/'+id).then(()=>{
	                    
	                      if(result.value) {
	                           Swal(
	                            'Deleted!',
	                            'Your file has been deleted.',
	                            'success'
	                          );
	                          this.fetchTowerCheckList();
	                      }            

	                  }).catch(()=>{
	                    Swal("failed!","there was some wrong","warning");
	              });
               
              })
            }
	    }
    
    }  
	
</script>