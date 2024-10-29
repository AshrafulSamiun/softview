<template>

	<fieldset>
		<form @submit.prevent="createTermOfAggrement()" @keydown="form.onKeydown($event)">
	         <div class="form-card">
                            <h1 class="page-head">Activation Status</h1>
                            <div class="form-folder">
                                <div class="form-holder">
                                    <div class="row">
                                        <div class="offset-md-1 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-box-outer">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <th>On Hold</th>
                                                                <td class="text-center" style="color:green" v-if="activation_status==2"><i class="fa fa-check"></i></td>
                                                                <td class="text-center" style="color:red" v-else><i class="fa fa-times"></i></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Active</th>
                                                                <td class="text-center" style="color:green" v-if="activation_status==1"><i class="fa fa-check"></i></td>
                                                                <td class="text-center" style="color:red" v-else><i class="fa fa-times"></i></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Suspend</th>
                                                                <td class="text-center" style="color:green" v-if="activation_status==3"><i class="fa fa-check"></i></td>
                                                                <td class="text-center" style="color:red" v-else><i class="fa fa-times"></i></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Canceled </th>
                                                                <td class="text-center" style="color:green" v-if="activation_status==4"><i class="fa fa-check"></i></td>
                                                                <td class="text-center" style="color:red" v-else><i class="fa fa-times"></i></td>
                                                            </tr>
                                                            <tr v-if="activation_status!=1">
                                                            	<td colspan="2">
                                                            		 <button class="btn btn-primary" type="button">Please call 1- 800-888-8988 to get your activation code after 2 business days</button>

                                                            	</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                         <div class=" col-md-4 col-sm-12 col-xs-12" >
                                            <div class="form-box-outer" v-if="activation_status==1">
                                                <h4 class="text-center">Activation Message</h4>
                                                <i class="fa fa-check check-act"></i>
                                                <p class="text-center" style="color:green">Your account is active  now. Please Go Next Step</p>
                                            </div>
                                            <div class="form-box-outer" v-else-if="activation_status==2">
                                                <h4 class="text-center">Activation Message</h4>
                                                <p align="center"><i class="fa fa-times-circle" style="font-size:60px; color:red;text-center" align="center"></i>
                                                </p>
                                                <p class="text-center" style="color:red">Your account is no hold.</p>
                                                <p class="text-center" style="color:red">Please call 1- 800-888-8988 to get your activation code after 2 business days</p>
                                            </div>
                                            <div class="form-box-outer" v-else-if="activation_status==3">
                                                <h4 class="text-center">Activation Message</h4>
                                                 <p align="center"><i class="fa fa-times-circle" style="font-size:60px; color:red;text-center" align="center"></i>
                                                </p>
                                                <p class="text-center" style="color:red">Your account is Suspend.</p>
                                                <p class="text-center" style="color:red">Please call 1- 800-888-8988 to get your activation code after 2 business days</p>
                                            </div>
                                            <div class="form-box-outer" v-else>
                                                <h4 class="text-center">Activation Message</h4>
                                                 <p align="center"><i class="fa fa-times-circle" style="font-size:60px; color:red;text-center" align="center"></i>
                                                </p>
                                                <p class="text-center" style="color:red">Your account is Canceled.</p>
                                                <p class="text-center" style="color:red">Please call 1- 800-888-8988 to get your activation code after 2 business days</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        
           
	        <button type="submit"  class="next action-button" v-show="activation_status==1">Go Next <i class="fa fa-angle-right"></i></button>
            <button type="button" @click="previous_step" class="previous action-button-previous"><i class="fa fa-angle-left"></i> Previous</button>
	    </form>
    </fieldset>

</template>

<script>
	import Vue from 'vue';
	import DatePicker from 'vue2-datepicker';


	


    export default {
        name:'list-product-categories',
       	components:{
			DatePicker
		},
        data(){
            return{
            	editmode:false,
				filter: '',
            	activation_status:'',

            	form:new Form({

                    

                }),
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchActivationStatus();
           
        },
		
	    methods: {

	    	


		  	previous_step()
            {
                let route = this.$router.resolve({ path: "/Temp-DocumentsSubmission" });
                window.open(route.href,'_self');
                return;
            },
            next_setp()
            {

                let route = this.$router.resolve({ path: "/Temp-ServiceContract" });
                window.open(route.href,'_self');
                return;
            },



            
	        fetchActivationStatus()
            {

            	
                let uri = '/AccountActivations';
                window.axios.get(uri).then((response) => {
                	this.activation_status=response.data.project_activation[0].activation_status;
                	

                	                	
                });   
            },

          
         
       

            updateTermOfAggrement()
            {
            
		        this.form.put('/TermsOfAggrements/'+this.form.id)
				    .then(()=>{
					       //success
					     
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchActivationStatus();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createTermOfAggrement()
            {
            	
        	    this.form.post('/AccountActivations') .then(({ data }) => { 
               
					
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset();
					this.fetchActivationStatus();
        	    })
            }
	    }
    
    }  
	
</script>