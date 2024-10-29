<template>

	<div class="row">
      <div class="col-md-12 col-sm-12" >
          <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">
            
              <div class="card-heading">

               

                <div class="pull-right">
    				      <button class="btn btn-primary btn-sm" @click.prevent="addLocker()">Create New Locaker</button>
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
                        <td>{{ row.locker_name }}</td>
                        <td>{{ row.suite_name_string }}</td>
                        <td>{{ row.locker_holder_name }}</td>
                        <td>{{ row.status }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" @click.prevent="editLocker(row)">Edit</button>
                            <button v-show="delete_permission" class="btn btn-danger btn-sm" @click.prevent="deleteLocker(row.id)">Delete</button>
                        </td>
                    </tr>
                  </template>
              </datatable>
              <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>

        
          </div>  
        </div>


         <!--  MOdel  -->
		 	   <div class="modal fade" id="addNewLocker" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  >
				  <div class="modal-dialog" role="document">
  				    <div class="modal-content">
  				        <div class="modal-header">
                      <h2 id="messagebox_main"></h2>
  				            <h5 class="modal-title" v-show="!editmode" id="">Add New Locker</h5>
  						        <h5 class="modal-title" v-show="editmode" id="">Update Locker</h5>
  				            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  				                <span aria-hidden="true">&times;</span>
  				            </button>
  				        </div>
  				      <div class="modal-body">
  				          <form @submit.prevent="editmode ? updateLocker() : createLocker()" @keydown="form.onKeydown($event)">
  					            <div class="form-group">
						            <label>Locker Name :</label>
						            <input v-model="form.locker_name" 
                       				 type="text" 
                        			name="locker_name"
						                class="form-control" 
                        			:class="{ 'is-invalid': form.errors.has('locker_name') }">
						           <has-error :form="form" field="locker_name"></has-error>
	                
						        </div>

							      
							    <div class="form-group">
									<label>Locker holder Suite: </label>
								    <select v-model="form.suite_name" type="suite_name" name="suite_name"
								        class="form-control" :class="{ 'is-invalid': form.errors.has('suite_name') }">
										<option disabled value="">Please select Suite</option>
										<option v-for="(suite,index) in SuiteArr" :value="index">{{suite}}</option>
									</select>
								    <has-error :form="form" field="suite_name"></has-error>
				                </div>

		                      	<div class="form-group">
						            <label>Locker Holder  Name :</label>
						            <input v-model="form.locker_holder_name" 
                       				 type="text" 
                        			name="locker_holder_name"
						                class="form-control" 
                        			:class="{ 'is-invalid': form.errors.has('locker_holder_name') }">
						           <has-error :form="form" field="locker_holder_name"></has-error>
	                
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
            		    locker_name:'',
                  	suite_name:'',
                  	locker_holder_name:'',
                  	status_active:'',
                  	id:''

            	}),

              columns: [
                
                { label: 'SL', field: 'sl', align: 'center' },
                { label: 'Locker Name', field: 'locker_name' },
                { label: 'Suite Name', field: 'suite_name_string' },
                { label: 'Locker Holder Name', field: 'locker_holder_name' },
                { label: 'Status', field: 'status' },
                { label: '', field: '', sortable: false },
              ],
              rows: [],

                row:{

                },
              page: 1,
              per_page:10,
          	StatusArr:['Select','Active','Inactive','Cancell'],
          	SuiteArr:[],
               
            }
        },

        created: function()
        {
            this.fetchLockers();
            this.user_menu_name = this.$route.name;
          //  this.fetchPermisitions();
        
        },

        methods: {

            

            editLocker(Locker){
                this.form.reset();
				        this.editmode=true;
				
                $("#addNewLocker").modal('show');
				        //$('.modal.in').modal('show');
				        $('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
                this.form.fill(Locker);
            },

			     addLocker(){
                this.form.reset();
				        this.editmode=false;				
                $("#addNewLocker").modal('show');
				        //$('.modal.in').modal('show');
				        $('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
               
            },

            fetchLockers()
            {
                let uri = '/Lockers';
                window.axios.get(uri).then((response) => {
                    this.rows           = response.data.locker_data;
                    this.SuiteArr 		  = response.data.Suit_data;
                });   
            },

			     updateLocker()
          {
				
  		        this.form.put('/Lockers/'+this.form.id)
  				    .then(()=>{
  					       //success
  					      $('.modal.in').modal('hide');
  					      $('.modal-backdrop').remove() ;
  					
  							toast({
  							  type: 'success',
  							  title: 'Data Update Successfully'
  							});
  					
  					     this.form.reset ();
  					     this.fetchLockers();
  				    })
						   
            },

            createLocker()
            {

        	      this.form.post('/Lockers') .then(({ data }) => { 
               
                       $('.modal.in').modal('hide');
                       $('.modal-backdrop').remove() ;

                       toast({
                          type: 'success',
                          title: 'Data Save successfully'
                        });
						
        	     	    this.form.reset ();
                        this.fetchLockers();
        	       })
            },

            deleteLocker(id)
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

                      this.form.delete('/Lockers/'+id).then(()=>{
                        
                          if(result.value) {
                               Swal(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                              );
                              this.fetchLockers();
                          }            

                      }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                  });
               
              })
            }     
        }
    }
</script>