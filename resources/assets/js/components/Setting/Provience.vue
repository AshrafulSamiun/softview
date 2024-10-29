<template>

	<div class="row">
      <div class="col-md-12 col-sm-12" >
        <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">
            
			<div class="card-heading">
				<div>
					<div align="left" style="float:left">
						<h2>Provience</h2>
					</div>

					<div align="right" style="float:right">
						<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewProvience" @click.prevent="addProvience()">Create New Provience</button>
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
		                    
		                    <td>{{ row.sl}}</td>
		                    <td>{{ row.provience_name }}</td>
		                    <td>{{ row.country_name }}</td>
		                    <td>{{ row.status }}</td>
		                    <td>
		                    	<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewProvience" @click.prevent="editProvience(row)">Edit</button>
		                    	<button v-show="delete_permission" class="btn btn-danger btn-sm" @click.prevent="deleteProvience(row.id)">Delete</button>
		                    </td>
		                </tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
			</div>  
        </div>

        <!--  MOdel  -->
		 	<div class="modal fade" id="addNewProvience" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  >
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
                    
				      <div class="modal-header">
                        <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmode" id="">Add New Provience</h5>
						<h5 class="modal-title" v-show="editmode" id="">Update Provience</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
                      
				      <div class="modal-body">
				         <form @submit.prevent="editmode ? updateProvience() : createProvience()" @keydown="form.onKeydown($event)">
					          <div class="form-group">
							      <label>Provience Name :</label>
							      <input v-model="form.provience_name" type="text" name="provience_name"
							        class="form-control" :class="{ 'is-invalid': form.errors.has('provience_name') }">
							      <has-error :form="form" field="provience_name"></has-error>
								  <input v-model="form.id" type="hidden" name="id">
							    </div>
                                
                              <div class="form-group">
							      <label>Country Name :</label>
							      <select v-model="form.country_id" type="country_id" name="country_id"
							        class="form-control" :class="{ 'is-invalid': form.errors.has('country_id') }">
							        	<option disabled value="">Please select Country</option>
									  	<option v-for="(country,index) in country_arr" :value="index">{{country}}</option>

									  
									</select>
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
            		country_id:'',
            		provience_name:'',
                  	status_active:'',
                  	id:''

            	}),
				columns: [
		            
		            { label: 'SL', field: 'sl', align: 'center' },
		            { label: 'Provience Name', field: 'provience_name' },
		            { label: 'Country Name', field: 'moduleName' },
		            { label: 'Status', field: 'status' },
		            { label: '', field: '', sortable: false },
		        ],
		       	rows: [],
		      	row:{
		       		country_id:'',
            		provience_name:'',
                  	status_active:'',
                  	id:''
		       },
		       modules: [],
		       module:{

                    id:'',
                    moduleName:'',
                    modSlNo:'',
                    status:''

                },
             	//serialNo:0,
          		StatusArr:['Select','Active','Inactive','Cancell'],
				country_arr:[],
				page: 1,
				per_page:10,
				expanded: null
			}
        },
		
		created: function()
        {
        	
            this.user_Provience_name = this.$route.name;
            this.fetchProviences();
            this.fetchModules();
           // this.fetchPermisitions();
           
        },
		
	    methods: {

            
	        fetchProviences()
            {
                let uri = '/proviences';
                window.axios.get(uri).then((response) => {
                	this.rows = response.data.provience;
                	this.country_arr = response.data.country_arr;
                });   
            },

            

            editProvience(row){
                this.form.reset();
				this.editmode=true;
              
                this.form.fill(row);
            },
            addProvience(){

                this.form.reset();
				this.editmode=false;				
            },

            updateProvience()
            {
				
		        this.form.put('/proviences/'+this.form.id)
				    .then(()=>{
					       //success
					      $('.modal.in').modal('hide');
					      $('.modal-backdrop').remove() ;
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchProviences();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createProvience()
            {
        	    this.form.post('/proviences') .then(({ data }) => { 
               
					$('.modal.in').modal('hide');
					$('.modal-backdrop').remove() ;
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchProviences();
        	    })
            },
            deleteProvience(id)
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

	                  this.form.delete('/proviences/'+id).then(()=>{
	                    
	                      if(result.value) {
	                           Swal(
	                            'Deleted!',
	                            'Your file has been deleted.',
	                            'success'
	                          );
	                          this.fetchProviences();
	                      }            

	                  }).catch(()=>{
	                    Swal("failed!","there was some wrong","warning");
	              });
               
              })
            }
	    }
    
    }  
	
</script>