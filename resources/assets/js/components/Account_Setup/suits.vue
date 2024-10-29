<template>

	<div class="row">
      <div class="col-md-12 col-sm-12" >
        <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">
            
			<div class="card-heading">
				<div>
					<div align="left" style="float:left">
						<h2>Suit</h2>
					</div>

					<div align="right" style="float:right">
						<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewSuits" @click.prevent="addSuit()">Create New Suit</button>
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
		                    <td>{{ row.suit_name }}</td>
		                    <td>{{ row.floor_name_string }}</td>
		                    <td>{{ row.total_rooms }}</td>

		                    <td>{{ row.town_house_string }}</td>
		                    <td>{{ row.sunna_string }}</td>

		                    <td>{{ row.status }}</td>
		                    <td>
		                    	<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewSuits" @click.prevent="editSuit(row)">Edit</button>
		                    	<button v-show="delete_permission" class="btn btn-danger btn-sm" @click.prevent="deleteSuit(row.id)">Delete</button>
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


      	<div class="modal fade" id="addNewSuits" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  >
				  <div class="modal-dialog" role="document">
				    <div class="modal-content" style="width:850px;">
                    
				      <div class="modal-header">
                        <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmode" id="">Add New Suit</h5>
						<h5 class="modal-title" v-show="editmode" id="">Update Suit</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
                      
				      <div class="modal-body">
				         <form @submit.prevent="editmode ? updateSuit() : createSuit()" @keydown="form.onKeydown($event)">

				         	<table width="100%" class="">
								
									<tbody>
									
								    	<tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                   Suit Name:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.suit_name" type="text" name="suit_name" class="form-control" :class="{ 'is-invalid': form.errors.has('suit_name') }">
												    <has-error :form="form" field="suit_name"></has-error>
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
								                    Total Rooms:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.total_rooms" type="text" name="total_rooms" class="form-control" :class="{ 'is-invalid': form.errors.has('total_rooms') }">
												    <has-error :form="form" field="total_rooms"></has-error>
								                </div>
								    		</td>
								    
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
										</tr>

								        <tr>
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
								    	</tr>

								        <tr>
								    		
								    
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Town House:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<select v-model="form.town_house" type="town_house" name="town_house"
												        class="form-control" :class="{ 'is-invalid': form.errors.has('town_house') }">
														<option disabled value="">Please select</option>
														<option value="1">Yes</option>
														<option value="2">No</option>
													</select>
												    <has-error :form="form" field="town_house"></has-error>
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
            		suit_name:'',
            		floor_name:'',
            		total_rooms:0,
            		one_room:0,
            		two_room:0,
                  	three_room:0,
            		town_house:2,
            		status_active:1,
                  	id:''

            	}),
				columns: [
		            
		            { label: 'SL', field: 'id', align: 'center' },
		            { label: 'Suite Name', field: 'suit_name' },
		            { label: 'Floor Name', field: 'floor_name_string' },
		            { label: 'Total Room', field: 'total_rooms' },
		            { label: 'Town House', field: 'town_house_string' },
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
            this.fetchSuits();
            this.fetchPermisitions();
           
        },
		
	    methods: {

	    	// fetchPermisitions()
      //       {

      //           let uri = '/UserPermission/'+this.user_Suit_name;
      //           window.axios.get(uri).then((response) => {
      //             this.save_permission= response.data.user_permission[0].save_priv;
      //             this.update_permission= response.data.user_permission[0].update_priv;
      //             this.delete_permission= response.data.user_permission[0].delete_priv;

      //             if(this.save_permission==1)     this.save_permission=true;    else this.save_permission=false;
      //             if(this.update_permission==1)   this.update_permission=true;  else this.update_permission=false;
      //             if(this.delete_permission==1)   this.delete_permission=true;  else this.delete_permission=false;
      //           });  
      //       },
            
	        fetchSuits()
            {
                let uri = '/Suits';
                window.axios.get(uri).then((response) => {
                	this.rows = response.data.Suit_data;
                	this.FloorArr = response.data.floor_data;
                });   
            },

        

            editSuit(row){
                this.form.reset();
				this.editmode=true;
               // $("#addNewSuits").modal('show');
			//	$('.modal.fade').addClass('modal fade in show');
              //  $('modal-backdrop').addClass('modal-backdrop fade in show') ;
                this.form.fill(row);
            },
            addSuit(){

                this.form.reset();
				this.editmode=false;				
             
               
            },

            updateSuit()
            {
				
		        this.form.put('/Suits/'+this.form.id)
				    .then(()=>{
					       //success
					      $('.modal.in').modal('hide');
					      $('.modal-backdrop').remove() ;
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchSuits();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createSuit()
            {
        	    this.form.post('/Suits') .then(({ data }) => { 
               
					$('.modal.in').modal('hide');
					$('.modal-backdrop').remove() ;
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchSuits();
        	    })
            },
            deleteSuit(id)
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

	                  this.form.delete('/Suits/'+id).then(()=>{
	                    
	                      if(result.value) {
	                           Swal(
	                            'Deleted!',
	                            'Your file has been deleted.',
	                            'success'
	                          );
	                          this.fetchSuits();
	                      }            

	                  }).catch(()=>{
	                    Swal("failed!","there was some wrong","warning");
	              });
               
              })
            }
	    }
    
    }  
	
</script>