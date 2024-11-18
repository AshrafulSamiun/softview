<template>

	<div class="row">
      <div class="col-md-12 col-sm-12" >
          <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">
            
              <div class="card-heading">

               

                <div class="pull-right">
    				      <button class="btn btn-primary btn-sm" @click.prevent="addMaintainanceRoom()">Create New Maintainance Room</button>
                </div>
                <div class="pull-left">
                    <label for="filter" class="sr-only">Filter</label>
                    <input type="text" class="form-control" v-model="filter" placeholder="Filter" style="width:400px;">
                </div>
          </div>
          <div class="card-body">


              <datatable :columns="columns" :data="rows" :filter-by="filter">
                  <template slot-scope="{row}">
                    <tr>
                        <td>{{ row.sl}}</td>
                        <td>{{ row.maintainance_room }}</td>
                        <td>{{ row.locaton }}</td>
                        <td>{{ row.comment }}</td>
                        <td>{{ row.status }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" @click.prevent="editMaintainanceRoom(row)">Edit</button>
                            <button v-show="delete_permission" class="btn btn-danger btn-sm" @click.prevent="deleteMaintainanceRoom(row.id)">Delete</button>
                        </td>
                    </tr>
                  </template>
              </datatable>
              <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>

        
          </div>  
        </div>


         <!--  MOdel  -->
		 	   <div class="modal fade" id="addNewMaintainanceRoom" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  >
				  <div class="modal-dialog" role="document">
  				    <div class="modal-content">
  				        <div class="modal-header">
                      <h2 id="messagebox_main"></h2>
  				            <h5 class="modal-title" v-show="!editmode" id="">Add New MaintainanceRoom</h5>
  						        <h5 class="modal-title" v-show="editmode" id="">Update MaintainanceRoom</h5>
  				            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  				                <span aria-hidden="true">&times;</span>
  				            </button>
  				        </div>
  				      <div class="modal-body">
  				          <form @submit.prevent="editmode ? updateMaintainanceRoom() : createMaintainanceRoom()" @keydown="form.onKeydown($event)">
  					            <div class="form-group">
  							            <label>Maintainance Room Name :</label>
  							            <input v-model="form.maintainance_room" 
                               				 type="text" 
                                			name="maintainance_room"
  							                class="form-control" 
                                			:class="{ 'is-invalid': form.errors.has('maintainance_room') }">
  							           <has-error :form="form" field="maintainance_room"></has-error>
			                
  							        </div>

  							        <div class="form-group">
  							            <label>Location: </label>
  							            <input v-model="form.locaton" 
                               				 type="text" 
                                			name="locaton"
  							                class="form-control" 
                                			:class="{ 'is-invalid': form.errors.has('locaton') }">
  							           <has-error :form="form" field="locaton"></has-error>
  							        </div>

			                        <div class="form-group">
			                            <label>Comment: </label>
			                            <textarea class="form-control"
					                  		name="comment" 
					                  		rows="5" 
					                  		v-model="form.comment"
					                  		:class="{ 'is-invalid': form.errors.has('comment') }">
				                  		</textarea>
			                           
			                      </div>
  							    
    							     <div class="form-group">
      							      <label> Status :</label>
        									<select v-model="form.status_active" type="status_active" name="status_active"
        							        class="form-control" :class="{ 'is-invalid': form.errors.has('status_active') }">
          									  <option disabled value="">Please select Status</option>
          									  <option value="1">Active</option>
          									  <option value="2">Inactive</option>
          									  <option value="3">Cancel</option>
        									</select>
    							     </div>

    							    	  <button :disabled="form.busy" v-show="!editmode && save_permission" type="submit" class="btn btn-primary btn-sm">Create</button>
    							      	<button :disabled="form.busy" v-show="editmode && update_permission" type="submit" class="btn btn-primary btn-sm">Update</button>
    							       	<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
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
 import DatePicker from 'vue2-datepicker';
 import DatatableFactory from 'vuejs-datatable';  
  Vue.use(DatatableFactory);
 export default {
        name:'list-product-categories',
        components:{
          DatePicker
        },
        data(){
            return{
              editmode:false,
              save_permission:true,
              update_permission:true,
              delete_permission:true,
              filter: '',
            	form:new Form({
            		maintainance_room:'',
                  	locaton:'',
                  	comment:'',
                  	status_active:'',
                  	id:''

            	}),

              columns: [
                
                { label: 'SL', field: 'sl', align: 'center' },
                { label: 'Maintainance Room Name', field: 'maintainance_room' },
                { label: 'Location', field: 'locaton' },
                { label: 'Comment', field: 'comment' },
                { label: 'Status', field: 'status' },
                { label: '', field: '', sortable: false },
              ],
              rows: [],

                row:{

                },
              page: 1,
              per_page:10,
          		StatusArr:['Select','Active','Inactive','Cancell'],
          	
               
            }
        },

        created: function()
        {
            this.fetchMaintainanceRooms();
            this.user_menu_name = this.$route.name;
          //  this.fetchPermisitions();
        
        },

        methods: {

            

            editMaintainanceRoom(MaintainanceRoom){
                this.form.reset();
				        this.editmode=true;
				
                $("#addNewMaintainanceRoom").modal('show');
				        //$('.modal.in').modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
                this.form.fill(MaintainanceRoom);
            },
			addMaintainanceRoom(){
                this.form.reset();
				this.editmode=false;				
                $("#addNewMaintainanceRoom").modal('show');
				        //$('.modal.in').modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
               
            },

            fetchMaintainanceRooms()
            {
                let uri = '/MaintenanceRooms';
                window.axios.get(uri).then((response) => {
                    this.rows              = response.data.maintainRoom;
                   // this.currency_name_arr = response.data.currency_name_arr;
                });   
            },

			      updateMaintainanceRoom()
            {
				
				        this.form.put('/MaintenanceRooms/'+this.form.id)
						    .then(()=>{
							       //success
							      $('.modal.in').modal('hide');
							      $('.modal-backdrop').remove() ;
							
      							toast({
      							  type: 'success',
      							  title: 'Data Update Successfully'
      							});
							
							     this.form.reset ();
							     this.fetchMaintainanceRooms();
						    })
						   
            },

            createMaintainanceRoom()
            {
              alert();
        	      this.form.post('/MaintenanceRooms') .then(({ data }) => { 
               
                       $('.modal.in').modal('hide');
                       $('.modal-backdrop').remove() ;

                       toast({
                          type: 'success',
                          title: 'Data Save successfully'
                        });
						
        	     	       this.form.reset ();
                       this.fetchMaintainanceRooms();
        	       })
            },

            deleteMaintainanceRoom(id)
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

                      this.form.delete('/MaintenanceRooms/'+id).then(()=>{
                        
                          if(result.value) {
                               Swal(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                              );
                              this.fetchMaintainanceRooms();
                          }            

                      }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                  });
               
              })
            }     
        }
    }
</script>