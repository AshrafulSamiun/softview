<template>

	<div class="row">
      <div class="col-md-12 col-sm-12" >
        <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">
            
			<div class="card-heading">
				<div>
					<div align="left" style="float:left">
						<h2>Country</h2>
					</div>

					<div align="right" style="float:right">
						<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewCountry" @click.prevent="addCountry()">Create New Country</button>
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
		                    <td>{{ row.country_name }}</td>
		                    <td>{{ row.short_name }}</td>
		                    <td>{{ row.country_code }}</td>
		                    <td>{{ StatusArr[row.status] }}</td>
		                    <td>
		                    	<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewCountry" @click.prevent="editCountry(row)">Edit</button>
		                    	<button v-show="delete_permission" class="btn btn-danger btn-sm" @click.prevent="deleteCountry(row.id)">Delete</button>
		                    </td>
		                </tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
			</div>  
        </div>

        <!--  MOdel  -->
		 	<div class="modal fade" id="addNewCountry" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  >
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
                    
				      <div class="modal-header">
                        <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmode" id="">Add New Country</h5>
						<h5 class="modal-title" v-show="editmode" id="">Update Country</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
                      
				      <div class="modal-body">
				         <form @submit.prevent="editmode ? updateCountry() : createCountry()" @keydown="form.onKeydown($event)">
					          <div class="form-group">
							      <label>Country Name :</label>
							     <input v-model="form.country_name" type="text" name="country_name"
							        class="form-control" :class="{ 'is-invalid': form.errors.has('country_name') }">
							      <has-error :form="form" field="country_name"></has-error> 
								  <input v-model="form.id" type="hidden" name="id">
							    </div>
                                
                              <div class="form-group">
							      <label>Short Name :</label>
							      <input v-model="form.short_name" type="text" name="short_name"
							        class="form-control" :class="{ 'is-invalid': form.errors.has('short_name') }">
							      <has-error :form="form" field="short_name"></has-error> 
							    </div>
							    <div class="form-group">
							      <label>Country Code: </label>
							      <input v-model="form.country_code" type="text" name="country_code"
							        class="form-control" :class="{ 'is-invalid': form.errors.has('country_code') }">
							      <has-error :form="form" field="country_code"></has-error>
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
            		country_code:'',
            		short_name:'',
            		country_name:'',
                  	status_active:'',
                  	id:''

            	}),
				columns: [
		            
		            { label: 'SL', field: 'id', align: 'center' },
		            { label: 'Country Name', field: 'country_name' },
		            { label: 'Module Name', field: 'short_name' },
		            { label: 'Country Route', field: 'country_code' },
		            { label: 'Status', field: 'status_active' },
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
        	
            this.user_manu_name = this.$route.name;
            this.fetchCountrys();
           
        },
		
	    methods: {

	    	/*fetchPermisitions()
            {

                let uri = '/UserPermission/'+this.user_manu_name;
                window.axios.get(uri).then((response) => {
                  this.save_permission= response.data.user_permission[0].save_priv;
                  this.update_permission= response.data.user_permission[0].update_priv;
                  this.delete_permission= response.data.user_permission[0].delete_priv;

                  if(this.save_permission==1)     this.save_permission=true;    else this.save_permission=false;
                  if(this.update_permission==1)   this.update_permission=true;  else this.update_permission=false;
                  if(this.delete_permission==1)   this.delete_permission=true;  else this.delete_permission=false;
                });  
            },*/
            
	        fetchCountrys()
            {
                let uri = '/Countries';
                window.axios.get(uri).then((response) => {
                	this.rows = response.data;
                });   
            },

          

            editCountry(row){
                this.form.reset();
				this.editmode=true;
               // $("#addNewCountry").modal('show');
			//	$('.modal.fade').addClass('modal fade in show');
              //  $('modal-backdrop').addClass('modal-backdrop fade in show') ;
                this.form.fill(row);
            },
            addCountry(){

                this.form.reset();
				this.editmode=false;				
            },

            updateCountry()
            {
				
		        this.form.put('/Countries/'+this.form.id)
				    .then(()=>{
					       //success
					      $('.modal.in').modal('hide');
					      $('.modal-backdrop').remove() ;
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchCountrys();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createCountry()
            {
        	    this.form.post('/Countries') .then(({ data }) => { 
               
					$('.modal.in').modal('hide');
					$('.modal-backdrop').remove() ;
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchCountrys();
        	    })
            },
            deleteCountry(id)
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

	                  this.form.delete('/Countries/'+id).then(()=>{
	                    
	                      if(result.value) {
	                           Swal(
	                            'Deleted!',
	                            'Your file has been deleted.',
	                            'success'
	                          );
	                          this.fetchCountrys();
	                      }            

	                  }).catch(()=>{
	                    Swal("failed!","there was some wrong","warning");
	              });
               
              })
            }
	    }
    
    }  
	
</script>