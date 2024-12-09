<template>
	<fieldset>
        <form @submit.prevent="editmode ? updateContactPerson() : createContactPerson()" @keydown="form.onKeydown($event)">
            <div class="form-card">
                <h1 class="page-head">Contacts Persons</h1>
                <div class="form-folder">
                   
                    <div class="form-holder">
                        <div class="row">
                            <div class="col-md-1  col-sm-3 col-xs-12">
                                
                            </div>
                            <div class="col-md-10 col-sm-9 col-xs-12">
                                <table class="table table_narrow">
                                            
                                    <thead>
                                        <tr class="header" >
                                            <td scope="col"  >Name</td>
                                            <td scope="col" >Position</td>
                                            <td scope="col"  >Email</td>
                                            <td scope="col"  >Phone Number</td>
                                        </tr>
                                        
                                    </thead>
                                    <tbody style="border:none">
                                        <template v-for="(key_management,index) in form.key_management_list_arr" >
                                            <tr style="background-color: #e7e8e7">

                                                <td >
                                                    <input 
                                                        type="text" 
                                                        placeholder="Type Name"
                                                        v-bind:id="'key_management_name_'+index"
                                                        name="key_management_name[]" 
                                                        v-model="key_management.key_position_name"/>
                                                </td>
                                                <td scope="row" >{{key_management.reference_value}}</td>
                                                
                                                
                                                <td >
                                                    <input 
                                                        type="text" 
                                                        placeholder="Type Email"
                                                        v-bind:id="'key_position_email_'+index"
                                                        name="key_position_email[]" 
                                                        v-model="key_management.email"/>
                                                </td>

                                              
                                                <td>
                                                    <input 
                                                        type="text" 
                                                        placeholder="Type Phone Number"
                                                        v-bind:id="'key_position_office_phone_'+index"
                                                        name="key_position_office_phone[]" 
                                                        v-model="key_management.office_phone"/>
                                                </td>                                                        
                                                                                               
                                            </tr>
                                                                                                      
                                        </template>
                                       
                                    </tbody>
                                </table> 
                            </div>                               
                        </div>
                    </div>


                    
                </div>
            </div>
            <button type="button" @click="previous_step" class="btn btn-primary"><i class="fa fa-angle-left"></i> Previous</button>
            <button :disabled="form.busy" v-show="!editmode" type="submit" class="btn btn-primary">Save</button>
            <button :disabled="form.busy" v-show="editmode" type="submit" class="btn btn-primary">Update</button>
             <button type="button" @click="next_setp" class="btn btn-primary">Next <i class="fa fa-angle-right"></i></button>
            
        </form>
    </fieldset>
</template>
<style>

    .table_narrow td{
        padding: .1rem .5rem !important;
    }

    .table_narrow th,.table_narrow .header td{
        font-size:13px !important;
        vertical-align:middle !important;
        color: rgb(255, 255, 255) !important;
        text-align:center !important;
        border:1px solid #fff !important;
    }

    .table_narrow tbody td{
        font-size:13px !important;
    }
    .table_narrow thead tr,.table_narrow .header 
    {
        background: rgba(45, 123, 252, 1) !important;
    }

    .table_narrow input{

        font-size: 12px !important;
        height: 30px !important;
        margin:5px 0  !important;
    }  

</style>
<script>
	import {ref} from "vue";
	
    export default {
        name:'list-product-categories',
       
        data(){
            return{
            	editmode:false,
				filter: '',
				display_form:false,
            	form:new Form({                  	
                    key_management_list_arr:[],
                  	
            	}),
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchContactPerson();
           
        },
		
	    methods: {

	    	previous_step()
            {
                let route = this.$router.resolve({ path: "/Temp-ServiceContract" });
                //alert(route.href);
                window.open(route.href,'_self');
                return;
            },
            next_setp()
            {

                let route = this.$router.resolve({ path: "/Temp-TermsOfAgreement" });
                window.open(route.href,'_self');
                return;
            },

           


	        fetchContactPerson()
            {
                let uri = '/AccountContactPersons';
                window.axios.get(uri).then((response) => {
                    
                    for(let i=0; i<response.data.key_position_lavel_arr.length; i++){

                        this.form.key_management_list_arr.push({
                            'id'                :response.data.key_position_lavel_arr[i].id,
                            'reference_id'      :response.data.key_position_lavel_arr[i].reference_id,
                            'reference_value'   :response.data.key_position_lavel_arr[i].reference_value,
                            'email'             :response.data.key_position_lavel_arr[i].email,
                            'office_phone'      :response.data.key_position_lavel_arr[i].office_phone,
                            'editable'          :response.data.key_position_lavel_arr[i].editable,
                            'key_position_name' :response.data.key_position_lavel_arr[i].key_position_name,
                        }); 
                    }
                	
                	this.editmode=response.data.editmode;                	
                });   
            },      

            updateContactPerson()
            {
				//alert(this.form.id);
		        this.form.put('/AccountContactPersons/'+this.form.id)
				    .then(()=>{
					       //success
					
							showToast('Data Update Successfully', 'success');
					
					     	this.form.reset ();
							this.display_form=false;
							this.fetchContactPerson();
				    })
				    .catch(()=>{
					   showToast("there was some wrong","warning");
				
				    });
            },
            
            createContactPerson()
            {

        	    this.form.post('/AccountContactPersons') .then(({ data }) => { 
					showToast('Data Save Successfully', 'success');

					this.form.reset ();
					this.display_form=false;
					this.fetchContactPerson();
        	    })
            }
	    }
    
    }  
	
</script>