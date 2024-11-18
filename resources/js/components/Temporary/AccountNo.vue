<template>

	<div class="row" style="">
		<div class="col-md-6 col-sm-6 offset-md-3" >
			<div class="card card-default widget wow fadeInDown animated " style="margin-top:100px; animation-delay: 0.18s;">
					<div class="card-body">
						<form @submit.prevent="editmode ? updateAccountNo() : createAccountNo()" @keydown="form.onKeydown($event)">

							<table class="table-borderless" width="100%">

								<tbody>
							       	
							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Account No:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
		
												<input 
													v-model="form.account_no" 
													type="text" name="account_no"
													
													v-on:dblclick="account_no_popup"
													class="form-control" 
													:class="{ 'is-invalid': form.errors.has('account_no') }">
											    <has-error :form="form" field="account_no"></has-error>
							                </div>
							    		</td>
							    	
							    	</tr>

							    	

							    	
							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    <input v-model="form.id" type="hidden" name="id">
							                </div>
							            </td>
							    		<td >
							                
										    
										    <button 
												:disabled="form.busy" 
												v-show="!editmode && save_permission" 
												type="submit" 
												class="btn btn-primary btn-sm">Save</button>
											<button 
												:disabled="form.busy" 
												v-show="editmode && update_permission" 
												type="submit" 
												class="btn btn-primary btn-sm">Update</button>

											
							                
							    		</td>

							    	</tr>
								</tbody>
						   	</table>

						  
						</form>
					</div>  
			</div>
		</div>
    </div>	

</template>

<script>
	import Vue from 'vue';
	

	


    export default {
        name:'list-product-categories',
       
        data(){
            return{
            	editmode:false,
				filter: '',
				editmode:false,
            	form:new Form({
            		account_no:'',
                  	id:''

            	}),
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchAccount_no();
           
        },
		
	    methods: {

	    	
            
	        fetchAccount_no()
            {
                let uri = '/api/MenuApi';
                window.axios.get(uri).then((response) => {
                	this.rows = response.data;
                });   
            },

          
         
       

            updateAccountNo()
            {
				
		        this.form.put('/Menus/'+this.form.id)
				    .then(()=>{
					       //success
					      $('.modal.in').modal('hide');
					      $('.modal-backdrop').remove() ;
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchAccount_no();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createAccountNo()
            {
        	    this.form.post('/Menus') .then(({ data }) => { 
               
					$('.modal.in').modal('hide');
					$('.modal-backdrop').remove() ;
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchAccount_no();
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

	                  this.form.delete('/Menus/'+id).then(()=>{
	                    
	                      if(result.value) {
	                           Swal(
	                            'Deleted!',
	                            'Your file has been deleted.',
	                            'success'
	                          );
	                          this.fetchAccount_no();
	                      }            

	                  }).catch(()=>{
	                    Swal("failed!","there was some wrong","warning");
	              });
               
              })
            }
	    }
    
    }  
	
</script>