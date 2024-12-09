<template>

	<fieldset>
        <form @submit.prevent="editmode ? updateServicePlan() : createServicePlan()" @keydown="form.onKeydown($event)">

            <div class="form-card">
               
                <button type="button" class="btn btn-primary btn-lg btn-block"><strong>Service Plan</strong></button>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12" align="center">

                        <button :disabled="form.busy" :class=" {'btn-primary': form.currency_id!=index, 'btn-success': form.currency_id==index }"  type="button" class="btn " v-for="(currency,index) in currency_arr" @click="currency_select(index)" style="margin:20px; padding-left:30px; padding-right:30px">{{currency}}</button>

                        <br/>
                        <button :disabled="form.busy" :class=" {'btn-primary': form.is_monthly!=1, 'btn-success': form.is_monthly==1}" @click="change_peroid(1) " type="button" class="btn "  style="margin:0 20px 20px 20px; padding-left:30px; padding-right:30px">Monthly</button>

                        <button :disabled="form.busy" :class=" {'btn-primary': form.is_monthly!=2, 'btn-success': form.is_monthly==2}" @click="change_peroid(2) " type="button" class="btn "  style="margin:0 20px 20px 20px; padding-left:30px; padding-right:30px">Annual</button>
                       
                    </div>

                </div>
                <div class="form-folder">
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-8 offset-md-2 col-sm-12 col-xs-12">
                                <div class="form-box-outer">
                                    <div class="table-responsive">
                                        <table class="table table-bordered ">
                                            <thead>
                                                <tr >
                                                    <th  class="text-center table-ash-td" width="25%">Service</th>
                                                    <th  class="text-center" :class="{'table-ash-td' : form.management_type==1,'disabled' : form.management_type!=1}"> Security Guard</th>
                                                    <th  class="text-center" :class="{'table-ash-td' : form.management_type==2,'disabled' : form.management_type!=2}">Concierge</th>
                                                    <th  class="text-center" :class="{'table-ash-td' : form.management_type==3,'disabled' : form.management_type!=3}">Concierge & Security</th>
                                                    <th  class="text-center" :class="{'table-ash-td' : form.management_type==4,'disabled' : form.management_type!=4}">Artemis</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template v-for="(master_plan_data,index) in form.master_plan_arr">
                                                    <tr style="cursor:pointer" v-if="index>1">
                                                        <td class="table-ash-td" >{{master_plan_data}}</td>
                                                        <td></td>
                                                        <td class="text-center">
                                                        </td>
                                                        <td class="text-right">
                                                               
                                                        </td>
                                                        <td class="text-right"></td>
                                                    </tr>
                                                    <template v-for="(service_plan_data, index1) in form.service_plan_arr[index]" >
                                                        <template v-for="(management_type_data, management_type) in service_plan_data"  >
                                                            <tr style="cursor:pointer" v-if="management_type==form.management_type">
                                                                <td style="" > 
                                                                    <div class="form-check-inline">
                                                                        <input type="checkbox" value="0" 
                                                                            v-model="management_type_data.checked" @change="check_service_enable($event,management_type_data)">
                                                                            {{index1}}
                                                                    </div>
                                                                </td>
                                                                
                                                                <td class="text-center" v-for="(management_type_arr,manage_type) in service_plan_data" :class="{'disabled-td': manage_type!=form.management_type}"> {{ management_type_arr.rate}}</td>
                                                               
                                                            </tr>
                                                        </template>
                                                    </template>
                                                </template>
                                               
                                                

                                               
                                                
                                                <tr>
                                                    <td  class="text-right"><b>Monthly Total Payable</b></td>
                                                    <td class="text-right" v-if="form.management_type==1"><b>{{form.total_monthly_amount}}</b></td>
                                                    <td v-else></td>
                                                    <td class="text-right" v-if="form.management_type==2"> <b>{{form.total_monthly_amount}}</b></td>
                                                    <td v-else></td>
                                                    <td class="text-right" v-if="form.management_type==3"><b>{{form.total_monthly_amount}}</b></td>
                                                    <td v-else></td>
                                                    <td class="text-right" v-if="form.management_type==4"><b>{{form.total_monthly_amount}}</b></td>
                                                    <td v-else></td>
                                                </tr>
                                                <tr v-show="form.is_monthly==2">
                                                    <td  class="text-right"><b>Yearly Total Payable</b></td>
                                                    <td class="text-right" v-if="form.management_type==1"><b>{{form.total_yearly_net_amount}}</b></td>
                                                    <td v-else></td>
                                                    <td class="text-right" v-if="form.management_type==2"><b>{{form.total_yearly_net_amount}}</b></td>
                                                    <td v-else></td>
                                                    <td class="text-right" v-if="form.management_type==3"><b>{{form.total_yearly_net_amount}}</b></td>
                                                    <td v-else></td>
                                                    <td class="text-right" v-if="form.management_type==4"><b>{{form.total_yearly_net_amount}}</b></td>
                                                    <td v-else></td>
                                                </tr>
                                                <tr v-show="form.is_monthly==2"  >
                                                    <td  class="text-right"><b>Discount Amount</b></td>
                                                    <td class="text-right" v-if="form.management_type==1"><b>{{form.total_discount_amount}}</b></td>
                                                    <td v-else></td>
                                                    <td class="text-right" v-if="form.management_type==2"><b>{{form.total_discount_amount}}</b></td>
                                                    <td v-else></td>
                                                    <td class="text-right" v-if="form.management_type==3"><b>{{form.total_discount_amount}}</b></td>
                                                    <td v-else></td>
                                                    <td class="text-right" v-if="form.management_type==4"><b>{{form.total_discount_amount}}</b></td>
                                                </tr>
                                                <tr v-show="form.is_monthly==2">
                                                    <td  class="text-right"><b>Yearly Total Payable (After Discount) </b></td>
                                                    <td class="text-right" v-if="form.management_type==1"><b>{{form.total_yearly_amount}}</b></td>
                                                    <td v-else></td>
                                                    <td class="text-right" v-if="form.management_type==2"><b>{{form.total_yearly_amount}}</b></td>
                                                    <td v-else></td>
                                                    <td class="text-right" v-if="form.management_type==3"><b>{{form.total_yearly_amount}}</b></td>
                                                    <td v-else></td>
                                                    <td class="text-right" v-if="form.management_type==4"><b>{{form.total_yearly_amount}}</b></td>
                                                    <td v-else></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

 .table-ash th{
    color:#fff !important;
    font-family: Roboto !important; 
    weight:600 !important;
    font-size:16px !important;
    background: rgba(45, 123, 252, 1) !important; 
 }

 .table-ash-td {
    color:#fff !important;
    font-family: Roboto !important; 
    weight:600 !important;
    font-size:16px !important;
    background: rgba(45, 123, 252, 1) !important; 
 }

  .disabled{
    background: rgba(186, 197, 215, 1) !important; 
    color:#fff !important;

 }

 .disabled-td{
    background: rgba(249, 249, 249, 1) !important; 
    color:rgba(0, 0, 0, .5) !important;
    cursor: not-allowed !important;

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
            	form:new Form({

                    is_monthly:1,
                  	id:'',
                    currency_id:'',
                    
                    total_monthly_amount:0,
                    total_yearly_net_amount:0,
                    total_discount_amount:0,
                    total_yearly_amount:0,
                    master_id:'',
                    management_type:0,
                    service_plan_arr:[],
                    master_plan_arr:[],

            	}),

                currency_arr:[],              
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchServicePlan();
           
        },
		
	    methods: {
            currency_select(index){

                this.form.currency_id=index;
            },

	    	previous_step()
            {
                let route = this.$router.resolve({ path: "/Temp-BusinessType" });
                window.open(route.href,'_self');
                return;
            },
            next_setp()
            {

                let route = this.$router.resolve({ path: "/Temp-ServiceContract" });
                window.open(route.href,'_self');
                return;
            },
            
            fetchServicePlan()
            { 
                $("#monthly").prop( "checked", true );
                let uri = '/UserServicePlans';
                window.axios.get(uri).then((response) => {

                	this.form.service_plan_arr 			    = response.data.service_plan_arr;
                    this.form.master_plan_arr               = response.data.master_plan_arr;
                    this.form.management_type               =response.data.management_type;
                    this.currency_arr                       = response.data.currency_arr;

                    var sl=0;
                    
                    if(response.data.update_master_data_arr.id > 0)
                    {
                        
                        this.form.master_id=response.data.update_master_data_arr.id;
                        this.form.currency_id=response.data.update_master_data_arr.currency_id;
                        this.form.is_montyly=response.data.update_master_data_arr.is_montyly;
                        this.form.total_monthly_amount=response.data.update_master_data_arr.total_monthly_amount;
                        this.form.total_yearly_net_amount=response.data.update_master_data_arr.total_yearly_net_amount;
                        this.form.total_discount_amount=response.data.update_master_data_arr.total_discount_amount;
                        this.form.total_yearly_amount=response.data.update_master_data_arr.total_yearly_amount;
                        this.editmode=true;

                    }                   
                	
                });

                
            },

            change_peroid(type)
            {
                if(type==1)
                    this.form.is_monthly=1;
                else if(type==2) this.form.is_monthly=2;
            },

            change_quantity(index)
            {
            
                 var quantity=this.form.quantity[index];
                 var rate=this.form.rate[index];
                 var amount=quantity*rate;
                
                 
                 //this.form.amount[1]=this.form.rate[index]*this.form.quantity[index];
                 this.form.amount[index]=amount;
                 this.calculate_total_amount();
                 return;
                 
            },

            check_service_enable(e,data){

                if(e.target.checked)
                {

                    data.checked=true;
                    this.calculate_total_amount();
                }
                else
                {
                    data.checked=false;
                    this.calculate_total_amount();
                }

            },

            calculate_total_amount()
            {
            
                let total_amount=0;
                let temthis=this;

                 Object.entries(this.form.service_plan_arr).forEach(entry => {
                    const [key, level] = entry;

                    Object.entries(temthis.form.service_plan_arr[key]).forEach(entry1 => {
                        const [key1, level1] = entry1;
                           
                        Object.entries(temthis.form.service_plan_arr[key][key1]).forEach(entry2 => {
                            const [key2, level2] = entry2;
                            if(level2.checked)
                                total_amount+=level2.rate*1;
                        
                        });
                        
                    });
                    return;
                    
                });
               
                
                this.form.total_monthly_amount=total_amount;
                this.form.total_yearly_net_amount=total_amount*12;
                this.form.total_discount_amount=this.form.total_yearly_net_amount*.05;
                this.form.total_yearly_amount=this.form.total_yearly_net_amount*.95;
          },
   

            updateServicePlan()
            {
				
		        this.form.put('/UserServicePlans/'+this.form.master_id)
				    .then(()=>{
					       //success
					     
						showToast('Data Update Successfully', 'success');
					
					     this.form.reset ();
					     this.fetchServicePlan();
				    })
				    .catch(()=>{
					   showToast("there was some wrong","warning");
				
				    });
            },
            
            createServicePlan()
            {
                if(this.form.total_monthly_amount>0)
                {
                    this.form.post('/UserServicePlans') .then(({ data }) => { 
               
                    
                        showToast('Data Update Successfully', 'success');

                        this.form.reset ();
                        this.fetchServicePlan();
                    });
                }
                else
                {
                     Swal("failed!","Please Complete You Plan First.You Have Not Select Any Plan","warning");
                }
        	    
            }
	    }
    
    }  
	
</script>