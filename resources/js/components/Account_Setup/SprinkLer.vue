<template>

	<div class="row">
      <div class="col-md-12 col-sm-12" >
        <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">
            
			<div class="card-heading">
				<div>
					<div align="left" style="float:left">
						<h2>Sprinkler</h2>
					</div>

					<div align="right" style="float:right">
						<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewFloor" @click.prevent="addTowerCheckList()">Create New Sprinkler</button>
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
		                    <td>{{ row.property_code }}</td>
		                    <td>{{ row.machine_model }}</td>
		                    <td>{{ row.location }}</td>

		                    <td>{{ row.contractor_name }}</td>
		                    <td>{{ row.contractor_phone }}</td>
		                    <td>{{ row.contractor_email }}</td> 
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
				        <h5 class="modal-title" v-show="!editmode" id="">Add New Sprinkler</h5>
						<h5 class="modal-title" v-show="editmode" id="">Update Sprinkler</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
                      
				      <div class="modal-body">
				         <form @submit.prevent="editmode ? updateTowerCheckList() : createTowerCheckList()" @keydown="form.onKeydown($event)">

				         	<table width="100%" class="" align="left">
								
									<tbody>
									
								    	<tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                   Property Code:
								                </div>
								            </td>
								            <td >
								                <div class="form-group">
													<input v-model="form.property_code" type="text" name="property_code" class="form-control" :class="{ 'is-invalid': form.errors.has('property_code') }">
												    <has-error :form="form" field="property_code"></has-error>
								                </div>
								    		</td>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Machine Model:
								                </div>
								            </td>
								    		<td colspan="2">
								                <div class="form-group">
													<input v-model="form.machine_model" type="text" name="machine_model" class="form-control" :class="{ 'is-invalid': form.errors.has('machine_model') }" >
												    <has-error :form="form" field="machine_model"></has-error>
								                </div>
								    		</td>
								    	</tr>

								        <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                   Location:
								                </div>
								            </td>
								            <td >
								                <div class="form-group">
													
													<input v-model="form.location" type="text" name="location" class="form-control" :class="{ 'is-invalid': form.errors.has('location') }" >
												    <has-error :form="form" field="location"></has-error>
								                </div>
								    		</td>
	
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Photo:
								                </div>
								            </td>
								    		<td >
								                <div class="form-group">
								                	<button 
						                      		class="btn-primary"  
						                      		style="padding:0 30px; border-radius:10px;font-size:20px;"
						                      		@click.prevent="addPhoto()"> Upload Photo</button>

													<input v-model="form.photo_id" type="hidden" name="photo_id" class="form-control" :class="{ 'is-invalid': form.errors.has('photo_id') }">
												   
								                </div>
								    		</td>
								    	</tr>

								        <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Contractor Name:
								                </div>
								            </td>
								            <td >
								                <div class="form-group">
													<input v-model="form.contractor_name" type="text" name="contractor_name" class="form-control" :class="{ 'is-invalid': form.errors.has('contractor_name') }">
												    <has-error :form="form" field="contractor_name"></has-error>
								                </div>
								    		</td>

								    		<td>
								            	<div class="form-lebel" align="right">
								                    Contractor Phone:
								                </div>
								            </td>
								            <td >
								                <div class="form-group">
													<input v-model="form.contractor_phone" type="text" name="contractor_phone" class="form-control" :class="{ 'is-invalid': form.errors.has('contractor_phone') }">
												    <has-error :form="form" field="contractor_phone"></has-error>
								                </div>
								    		</td>
								    	
								    	</tr>
								    	<tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Contractor Email:
								                </div>
								            </td>
								            <td >
								                <div class="form-group">
													<input v-model="form.contractor_email" type="email" name="contractor_email" class="form-control" :class="{ 'is-invalid': form.errors.has('contractor_email') }">
												    <has-error :form="form" field="contractor_email"></has-error>
								                </div>
								    		</td>
								    	
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Instruction:
								                </div>
								            </td>
								            <td >
								                <div class="form-group">
													<input v-model="form.instruction" type="text" name="instruction" class="form-control" :class="{ 'is-invalid': form.errors.has('instruction') }">
												    <has-error :form="form" field="instruction"></has-error>
								                </div>
								    		</td>
								    	
								    	</tr>
								    	<tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Instruction Date:
								                </div>
								            </td>
								            <td >
								                <div class="form-group">
													

													<date-picker 
								                     	v-model="form.instruction_date"
								                     	lang="en"
								                     	type="date"
								                     	style="width:100%;"
								                     	placeholder="Inspection Date" 
								                     	format="DD-MM-YYYY"></date-picker>
												    <has-error :form="form" field="instruction_date"></has-error>
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




			<div class="modal fade" id="addNewPhoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"   >
			  <div class="modal-dialog" role="document">
			    <div class="modal-content" style="width:600px">
	            
			      	<div class="modal-header">
		                <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmodephpto" id="">Add New Photo</h5>
						<h5 class="modal-title" v-show="editmodephpto" id="">Update Photo</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
		  			<div class="modal-body">
				         <form @submit.prevent="editmodephpto ? updateImage() : createImage()" @keydown="form.onKeydown($event)">
				         	<table width="550">
    
						    	<tbody>
						           	
						        	<tr>
						        		<td>
						        			<div class="form-group" v-if="user_photo">
					                           	<img :src="user_photo" class="img-responsive" height="150" width="200">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        			<div class="form-group">
					                              <input type="file" v-on:change="onImageChange" class="form-control" style="max-width:500px;">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        		

					                       	<div class="form-group">
						                        <button :disabled="form.busy" v-show="!editmodephpto" type="submit" class="btn btn-primary">Save Photo</button>
										      	<button :disabled="form.busy" v-show="editmodephpto" type="submit" class="btn btn-primary">Update Photo</button>
										      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						                    </div>

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
	import {ref} from "vue";
	import DatatableFactory from 'vuejs-datatable';	
	Vue.use(DatatableFactory);
	//var eventBus = new Vue();

	


    export default {
        name:'list-product-categories',
       
        data(){
            return{
            	editmode:false,
            	editmodephoto:false,
				save_permission:true,
				update_permission:true,
				delete_permission:true,
				goods_photo:'',
				filter: '',
				editmode:false,
            	form:new Form({
            		property_code:'',
            		location:'',
            		machine_model:'',
            		photo_id:'',
                  	contractor_name:'',
                  	contractor_email:'',
            		instruction:'',
            		instruction_date:'',
            		status_active:1,
                  	id:''

            	}),
				columns: [
		            
		            { label: 'SL', field: 'id', align: 'center' },
		            { label: 'Property Code', field: 'property_code' },
		            { label: 'Machine Model', field: 'machine_model' },
		            { label: 'Location', field: 'location' },
		            { label: 'Contractor Name', field: 'contractor_name' },
		            { label: 'Contractor Phone', field: 'contractor_phone' },
		            { label: 'Contractor Email', field: 'contractor_phone' },
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
            this.fetchSprinkler();
           // this.fetchPermisitions();
           
        },
		
	    methods: {
	    	addPhoto(){

            

                $("#addNewPhoto").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
               
            },
	    	 onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createrowimage(files[0]);
            },
            createrowimage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.user_photo = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            createImage(){
            	
        		axios.post('/image/store',{image: this.user_photo,image_file_name: 'user_photo',image_folder_name: 'user_photo'}).then(({ data }) => {
                   	
                   	var response_arr=data.split('**');
                   	this.form.user_photo_id=response_arr[1];
                   	this.editmodephpto=true;
                   	toast({
					  type: 'success',
					  title: 'Data Save Successfully'
					});
                });
                
            },

            updateImage(){

        		axios.post('/image/update',{image: this.user_photo,img_id: this.form.user_photo_id,image_file_name: 'user_photo',image_folder_name: 'user_photo'}).then(({ data }) => {

                   var response_arr=data.split('**');
                   this.form.user_photo_id=response_arr[1];
                   this.editmodephpto=true;
                   toast({
					  type: 'success',
					  title: 'Data Update Successfully'
					});
                });
            },

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
            
	        fetchSprinkler()
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
					
							showToast('Data Update Successfully', 'success');
					
					     this.form.reset ();
					     this.fetchSprinkler();
				    })
				    .catch(()=>{
					   showAlert("failed!","there was some wrong","warning");
				
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
					this.fetchSprinkler();
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
	                           showAlert(
	                            'Deleted!',
	                            'Your file has been deleted.',
	                            'success'
	                          );
	                          this.fetchSprinkler();
	                      }            

	                  }).catch(()=>{
	                    showAlert("failed!","there was some wrong","warning");
	              });
               
              })
            }
	    }
    
    }  
	
</script>