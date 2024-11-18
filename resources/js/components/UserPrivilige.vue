<template>

	<div class="row">
      <div class="col-md-12 col-sm-12" >
        <div class="card form-card " style=" animation-delay: 0.18s; min-height:500px" >
            <form id="msform" @submit.prevent="createPrivileges()" @keydown="form.onKeydown($event)">
				<div class="card-heading form-folder">
					<h3><i class="fa fa-hand-point-right"></i>User Priviliges</h3>
					<div class="pull-left">
						
						
						<table width="">

							<tbody>
						       	
						    	<tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    User Name:
						                </div>
						            </td>
						            <td>
						                <div class="form-group">

											<select v-model="form.user_id"
						                      	name="user_id" 
						                      	id="user_id"
						                      	class="form-control" :class="{ 'is-invalid': form.errors.has('user_id') }">
										        	<option  value="">--Select User Name-- </option>
												  	<option v-for="(user,index) in user_arr" :value="user.id">{{user.name}}</option>
										  	</select>
										
						                </div>
						    		</td>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    Module Name:
						                </div>
						            </td>
						            <td>
						                <div class="form-group">

											<select v-model="form.module_id"
						                      	name="module_id" 
						                      	id="module_id"
						                      	@change="load_module_corresponding_data()"
						                      	class="form-control" :class="{ 'is-invalid': form.errors.has('module_id') }">
										        	<option  value="">--Select Module-- </option>
												  	<option v-for="module in module_arr" :value="module.id">{{module.menuName}}</option>
										  	</select>
										
						                </div>
						    		</td>
						    	</tr>
						    </tbody>
						</table>	
						
					</div>

				

				</div>



				<div class="card-body">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Sl</th>
								<th scope="col" style="min-width:200px">Menu Name</th>
								<th scope="col">Show Priv</th>
								<th scope="col">Save Priv</th>
								<th scope="col">Update Priv</th>
								<th scope="col">Delete Priv</th>
								<th scope="col">Approve Priv</th>
								<th scope="col">Post Priv</th>
								<th scope="col">Adjust Priv</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(detail,index) in form.details" v-if="detail.rootMenu==0"  style="background: rgb(0,112,192);color: #fff;">
								<td scope="row" style="background: #aaa8a8;">
									<div class="custom-control custom-checkbox">

									    <input type="checkbox" 
									    	class="custom-control-input"
									    	v-model="detail.status_active" 
									    	v-bind:id="'select_td_'+index" checked>
									    <label class="custom-control-label" v-bind:for="'select_td_'+index">{{index+1}}</label>
									</div>
								</td>
								<td align="left">
									{{detail.main_menu_name}}
								</td>
								<td>
									<select v-model="detail.show_priv"
							            class="form-control">
								       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
								  	</select>
								</td>
								<td>
									<select v-model="detail.save_priv"
							            class="form-control">
								       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
								  	</select>

								</td>
								<td>
									<select v-model="detail.update_priv"
							            class="form-control">
								       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
								  	</select>
								</td>
								<td>
									<select v-model="detail.delete_priv"
							            class="form-control">
								       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
								  	</select>
								</td>
								<td>
									<select v-model="detail.approve_priv"
							            class="form-control">
								       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
								  	</select>
								</td>
								<td>
									<select v-model="detail.post_priv"
							            class="form-control">
								       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
								  	</select>
								</td>
								<td>
									<select v-model="detail.adjust_priv"
							            class="form-control">
								       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
								  	</select>
								</td>
							</tr>

							<template v-for="(detail,index) in form.details" v-if="detail.position==2">
								<tr    style=" background: rgb(96, 130, 193);color: #fff;">
									<td scope="row" style="background: #aaa8a8;">
										<div class="custom-control custom-checkbox">

										    <input type="checkbox" 
										    	class="custom-control-input"
										    	v-model="detail.status_active" 
										    	v-bind:id="'select_td_'+index" checked>
										    <label class="custom-control-label" v-bind:for="'select_td_'+index">{{index+1}}</label>
										</div>
									</td>
									<td align="left" style="padding-left:40px;">
										{{detail.main_menu_name}}
									</td>
									<td>
										<select v-model="detail.show_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>
									</td>
									<td>
										<select v-model="detail.save_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>

									</td>
									<td>
										<select v-model="detail.update_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>
									</td>
									<td>
										<select v-model="detail.delete_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>
									</td>
									<td>
										<select v-model="detail.approve_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>
									</td>
									<td>
										<select v-model="detail.post_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>
									</td>
									<td>
										<select v-model="detail.adjust_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>
									</td>
								</tr>

								<tr   v-for="(detail2,index1) in form.details" v-if="detail.main_menu_id==detail2.rootMenu && detail2.position==3" >
									<td scope="row" >
										<div class="custom-control custom-checkbox">

										    <input type="checkbox" 
										    	class="custom-control-input"
										    	v-model="detail2.status_active" 
										    	v-bind:id="'select_td_'+index" checked>
										    <label class="custom-control-label" v-bind:for="'select_td_'+index">{{detail2.slno}}</label>
										</div>
									</td>
									<td align="left" style="padding-left:70px;">
										{{detail2.main_menu_name}}
									</td>
									<td>
										<select v-model="detail2.show_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>
									</td>
									<td>
										<select v-model="detail2.save_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>

									</td>
									<td>
										<select v-model="detail2.update_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>
									</td>
									<td>
										<select v-model="detail2.delete_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>
									</td>
									<td>
										<select v-model="detail2.approve_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>
									</td>
									<td>
										<select v-model="detail2.post_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>
									</td>
									<td>
										<select v-model="detail2.adjust_priv"
								            class="form-control">
									       	<option v-for="(value,index) in PermitionArr" :value="index" >{{value}}</option>
									  	</select>
									</td>
								</tr>
								
				        	</template>

				        	<tr>
				                <td>
				                    <div class="form-group pull-right">
				                        <button :disabled="form.busy" type="submit" class="btn btn-primary">Save</button>
				                    </div>
				        		</td>
				        		<!-- v-show="save_permission" -->
				        		
				        	</tr>
						</tbody>
					</table>
				</div> 
			</form> 
        </div>

    
        
      </div><!-- /.col-md-12 -->
    </div>	

</template>

<script>
	import Vue from 'vue';
	import DatatableFactory from 'vuejs-datatable';	
	Vue.use(DatatableFactory);

	


    export default {
        name:'User-Privilize',
        data(){
            return{
				filter: '',
				user_menu_name:'',
				save_permission:false,
				editmode:false,
            	form:new Form({
            		user_id:'',
            		module_id:'',
            		password:'',
            		status_active:'',
            		user_type:'',
                  	id:'',
                  	details:[
                  		
                  	],

            	}),
		
		       
		       user_arr:'',
				module_arr:'',
				menu_arr:'',
				user_permission:[],
          		StatusArr:['Select','Active','Inactive','Cancell'],
          		PermitionArr:['Select','Permitted','Not Permitted'],
				
				page: 1,
				per_page:10,
			}
        },
		
		created: function()
        {
        	this.user_menu_name = this.$route.name;
            this.fetchUsers();
            this.fetchModules();
            this.fetchPermisitions();
        

        },
         mounted () {
		    this.init()
		  },
		
	    methods: {

	    	 init () {
		      console.log(this.$route);  //should return object
		      console.log(this.$route.params); //should return object 
		      console.log(this.$route.params.user_menu_id); //should return id of URL param 
		    },

		    fetchPermisitions()
            {

                let uri = '/UserPermission/'+this.user_menu_name;
                window.axios.get(uri).then((response) => {
                	this.save_permission= response.data.user_permission[0].save_priv;
                	if(this.save_permission==1) this.save_permission=true; else this.save_permission=false;
                });  
                    
            },
	        fetchUsers()
            {
                let uri = '/ProjectUser';
                window.axios.get(uri).then((response) => {
                	this.user_arr = response.data.user_data;
                });  
                    
            },
            fetchModules()
            {
                let uri = '/api/ModuleApi';
                window.axios.get(uri).then((response) => {
                this.module_arr = response.data;
                });   
            },
           
            load_module_corresponding_data()
        	{

        		if(this.form.user_id=="" || this.form.user_id==0)
        		{
        			toast({
					  type: 'warning',
					  title: 'Please Select User Name'
					});
					this.form.module_id="";
					return;
        		}
        		this.form.details.splice(0);
        		let uri = '/loadMenuByModule/'+this.form.module_id;
                window.axios.get(uri).then((response) => {
                	this.menu_arr = response.data.menuArr;

                	for(var i=0;i<this.menu_arr.length;i++)
                	{

                		this.form.details.push({
							id:'',
                  			main_menu_id:this.menu_arr[i]['id'],
                  			main_menu_name:this.menu_arr[i]['menuName'],
                  			module_id:this.form.module_id,
                  			user_id:this.form.user_id,
                  			rootMenu:this.menu_arr[i]['rootMenu'],
                  			position:this.menu_arr[i]['position'],
                  			slno:this.menu_arr[i]['slno'],
                  			show_priv:1,
                  			save_priv:1,
                  			update_priv:1,
                  			delete_priv:1,
                  			approve_priv:1,
                  			post_priv:1,
                  			adjust_priv:1,
                  			status_active:1,
                  			is_deleted:0,
                		});
                		//alert(this.menu_arr[i]['rootMenu'])
                	}
                });
        	
        	},
          
            editUser(row){
                this.form.reset();
				this.editmode=true;
                $("#addNewUser").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
                this.form.fill(row);
            },
            addUser(){

                this.form.reset();
				this.editmode=false;				
                $("#addNewUser").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
               
            },

            updateUser()
            {
				
		        this.form.put('/Users/'+this.form.id)
				    .then(()=>{
					       //success
					      $('.modal.in').modal('hide');
					      $('.modal-backdrop').remove() ;
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchUsers();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
           
            
            createPrivileges()
            {
        	    this.form.post('/UserPrivileges') .then(({ data }) => { 
               
					var response=data.split("**");
        	    	if(response[0]==100)
        	    	{
        	    		toast({
							type: 'warning',
							title: 'No Data Found.'
						});
						return;
        	    	}
					else if(response[0]==0)
					{
						toast({
							type: 'success',
							title: 'Data Save Successfully'
						});
						this.form.reset ();
					}

        	    })
            },
            deleteUser(id)
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

                      this.form.delete('/Users/'+id).then(()=>{
                        
                          if(result.value) {
                               Swal(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                              );
                              this.fetchUsers();
                          }            

                      }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                  });
               
              })
            }
	    }
    
    }  
	
</script>