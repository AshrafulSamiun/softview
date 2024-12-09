<template>

	<div class="row">
      <div class="col-md-12 col-sm-12" >
        <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">
            
          <div class="card-heading">
           
            <div class="pull-left">
                <h3 class="card-title">Module List</h3>
            </div>

            <div class="pull-right">
				      <button class="btn btn-primary btn-sm" @click.prevent="addModule()">Create New Module</button>
          </div>

          </div>
          <div class="card-body">
            <vue-progress-bar></vue-progress-bar>
           <table id="tbl_main_module" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Module Name</th>
                        <th>Sequence</th>
                        <th>Status</th>
                        <th width="280px">Action</th>
                    </tr>
               </thead>
                <tbody>
                 <tr v-for="(module,index) in modules"  height="15">
                    <td>{{ ++index }}</td>
                    <td>{{ module.moduleName }}</td>
                    <td>{{ module.modSlNo }}</td>
                    <td>{{ StatusArr[module.status] }}</td>
                                     
                    <td>
                    	<button class="btn btn-primary btn-sm" @click.prevent="editModule(module)">Edit</button>
                    	<button v-show="delete_permission" class="btn btn-danger btn-sm" @click.prevent="deletemodule(module.id)">Delete</button>
                    </td>
                </tr>    
             </tbody>
            </table>
          </div>  
        </div>


         <!--  MOdel  -->
		 	   <div class="modal fade" id="addNewModule" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  >
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
                        <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmode" id="">Add New Module</h5>
						<h5 class="modal-title" v-show="editmode" id="">Update Module</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				         <form @submit.prevent="editmode ? updateModule() : createModule()" @keydown="form.onKeydown($event)">
					          <div class="form-group">
							      <label>Module Name :</label>
							      <input v-model="form.moduleName" type="text" name="moduleName"
							        class="form-control" :class="{ 'is-invalid': form.errors.has('moduleName') }">
							      <has-error :form="form" field="moduleName"></has-error>
								  <input v-model="form.id" type="hidden" name="id">
							    </div>

							    <div class="form-group">
							      <label>Sequence No: </label>
							      <input v-model="form.modSlNo" type="number" name="modSlNo"
							        class="form-control" :class="{ 'is-invalid': form.errors.has('modSlNo') }">
							      <has-error :form="form" field="modSlNo"></has-error>
							    </div>
							    
							     <div class="form-group">
							      <label> Status :</label>
									<select v-model="form.status" type="status" name="status"
							        class="form-control" :class="{ 'is-invalid': form.errors.has('status') }">
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
import VueProgressBar from 'vue-progressbar';
 export default {
        name:'list-product-categories',
      
        data(){
            return{
				      editmode:false,
              save_permission:false,
              update_permission:false,
              delete_permission:false,
              user_menu_name:'',
            	form:new Form({
            		  moduleName:'',
            		  modSlNo:'',
                  status:'',
                  id:''

            	}),
                message:'',
                modules: [],
                module:{

                    id:'',
                    moduleName:'',
                    modSlNo:'',
                    status:''

                },
          		StatusArr:['Select','Active','Inactive','Cancell'],
          	
               
            }
        },
        mounted () {
          this.$Progress.finish();
        },
        created: function()
        {
            this.$Progress.start();
            this.user_menu_name = this.$route.name;
            this.fetchModules();
            this.fetchPermisitions();
            this.$Progress.finish()
        },

        methods: {


            fetchPermisitions()
            {

                let uri = '/UserPermission/'+this.user_menu_name;
                window.axios.get(uri).then((response) => {
                  this.save_permission= response.data.user_permission[0].save_priv;
                  this.update_permission= response.data.user_permission[0].update_priv;
                  this.delete_permission= response.data.user_permission[0].delete_priv;

                  if(this.save_permission==1)   this.save_permission=true;    else this.save_permission=false;
                  if(this.update_permission==1)   this.update_permission=true;  else this.update_permission=false;
                  if(this.delete_permission==1)   this.delete_permission=true;  else this.delete_permission=false;
                });  
                    
            },

            editModule(module){
                this.form.reset();
				        this.editmode=true;
				
                $("#addNewModule").modal('show');
				        //$('.modal.in').modal('show');
				        $('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
                this.form.fill(module);
            },
			     addModule(){
                this.form.reset();
				        this.editmode=false;				
                $("#addNewModule").modal('show');
				        //$('.modal.in').modal('show');
				        $('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
               
            },

            fetchModules()
            {
                this.$Progress.start()
                let uri = '/Modules';
                window.axios.get(uri).then((response) => {
                this.modules = response.data;
                }); 
                this.$Progress.finish();  
            },
			      updateModule()
            {
				
				        this.form.put('/Modules/'+this.form.id)
						    .then(()=>{
							       //success
							      $('.modal.in').modal('hide');
							      $('.modal-backdrop').remove() ;
							
      							toast({
      							  type: 'success',
      							  title: 'Data Update Successfully'
      							});
							
							     this.form.reset ();
							     this.fetchModules();
						    })
						    .catch(()=>{
							   showAlert("failed!","there was some wrong","warning");
						
						    });
            },
            createModule()
            {
        	      this.form.post('/Modules') .then(({ data }) => { 
               
                       $('.modal.in').modal('hide');
                       $('.modal-backdrop').remove() ;

                       toast({
                          type: 'success',
                          title: 'Data Save successfully'
                        });
						
        	     	       this.form.reset ();
                       this.fetchModules();
        	       })
            },

            deletemodule(id)
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

                      this.form.delete('/Modules/'+id).then(()=>{
                        
                          if(result.value) {
                               showAlert(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                              );
                              this.fetchModules();
                          }            

                      }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                  });
               
              })
            }     
        }
    }
</script>