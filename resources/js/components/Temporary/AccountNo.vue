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
							                    <h2>Account No:</h2>
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<h2>{{form.account_no}}</h2>
												
							                </div>
							    		</td>
							    	
							    	</tr>
							    	
							    	<tr>
							    		<td colspan="2" align="center">
							                										    
										    <button type="button" 
										    	@click="next_setp" 
										    	class="btn btn-primary">Next 
										    	<i class="fa fa-angle-right"></i></button>	
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
	import {ref} from "vue";
    export default {
        name:'list-product-categories',
       
        data(){
            return{
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
                let uri = 'AccountCrospondents';
                window.axios.get(uri).then((response) => {
                	this.form.account_no = response.data.master_company_id;
                });   
            },

            next_setp()
            {
            	this.form.post('/AccountCrospondents') .then(({ data }) => { 
               		
					let route = this.$router.resolve({ path: "/Temp-CompanyProfile" });
	                window.open(route.href,'_self');
	                return;
        	    })
                
            },
	    }
    
    }  
	
</script>