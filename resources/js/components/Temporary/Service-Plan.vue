<template>

	<fieldset>
        <form @submit.prevent="editmode ? updateServicePlan() : createServicePlan()" @keydown="form.onKeydown($event)">

            <div class="form-card">
                <h1 class="page-head"> Service Plan</h1>
                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> Charging Period:</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <div class="form-box-outer">
                                    <div class="form-check-inline">
                                       
                                        <input type="radio" id="monthly" name="is_monthly" value="1" v-model="form.is_monthly" :checked="form.is_monthly==1"   v-on:change="change_peroid(true)">
                                        <label for="monthly">Monthly</label><br>
                                        <input type="radio" id="yearly" name="is_monthly" value="2" v-model="form.is_monthly"   v-on:change="change_peroid(false)" :checked="form.is_monthly==0">
                                        <label for="yearly" >Yearly</label><br>


                                          
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 col-sm-12 col-xs-12">
                                <div class="form-box-outer">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Number Of</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Rate</th>
                                                    <th class="text-center">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr style="cursor:pointer" v-for="(master_plan_data,index) in service_plan_arr[1]" id="tr_">
                                                  

                                                    <td ></td>
                                                    <td><b>{{master_plan_data.plan_name}}</b></td>
                                                    <td class="text-center">
                                                        <input 
                                                          type="text" 
                                                          v-bind:name="'quantity['+index+']'" 
                                                          v-bind:id="'quantity_'+index"
                                                          v-model="form.quantity[index]" 
                                                          v-on:keyup="change_quantity(index)"
                                                          placeholder="Type Qunality" />
                                                          
                                                            

                                                        <input 
                                                            type="hidden" 
                                                            v-bind:id="'plan_id_'+index" 
                                                            v-bind:name="'plan_id['+index+']'"
                                                            v-model="form.plan_id[index]" >

                                                        <input 
                                                            type="hidden" 
                                                            v-bind:id="'id_'+index" 
                                                            v-bind:name="'id['+index+']'"
                                                            v-model="form.id[index]" >
                                                        <input 
                                                            type="hidden" 
                                                            v-bind:id="'rate_'+index" 
                                                            v-bind:name="'rate['+index+']'"
                                                            v-model="form.rate[index]"
                                                             >
                                                        <input 
                                                            type="hidden" 
                                                            v-bind:id="'amount_'+index" 
                                                            v-bind:name="'amount['+index+']'"
                                                            v-model="form.amount[index]">
                                                    </td>
                                                    <td class="text-right">
                                                            {{form.rate[index]}}
                                                    </td>
                                                    <td class="text-right">{{form.amount[index]}}</td>
                                                </tr>
                                                <tr style="cursor:pointer" v-for="(master_plan_data,index) in service_plan_arr[2]" id="tr_">
                                                    <td rowspan="3"  v-if="index==3"><b>Dependent Property</b> <br>(Residential)</td>
                                                    <td><b>{{master_plan_data.plan_name}}</b></td>
                                                    <td class="text-center">
                                                        <input 
                                                          type="text" 
                                                          v-bind:name="'quantity['+index+']'" 
                                                          v-bind:id="'quantity_'+index"
                                                          v-model="form.quantity[index]" 
                                                          @keyup="change_quantity(index)"
                                                          placeholder="Type Qunality" />

                                                          <input 
                                                            type="hidden" 
                                                            v-bind:id="'plan_id_'+index" 
                                                            v-bind:name="'plan_id['+index+']'"
                                                            v-model="form.plan_id[index]" >

                                                        <input 
                                                            type="hidden" 
                                                            v-bind:id="'id_'+index" 
                                                            v-bind:name="'id['+index+']'"
                                                            v-model="form.id[index]" >
                                                        <input 
                                                            type="hidden" 
                                                            v-bind:id="'rate_'+index" 
                                                            v-bind:name="'rate['+index+']'"
                                                            v-model="form.rate[index]"
                                                             >
                                                        <input 
                                                            type="hidden" 
                                                            v-bind:id="'amount_'+index" 
                                                            v-bind:name="'amount['+index+']'"
                                                            v-model="form.amount[index]" >
                                                    </td>
                                                    <td class="text-right">
                                                            {{form.rate[index]}}
                                                    </td>
                                                    <td class="text-right">{{form.amount[index]}}</td>
                                                </tr>

                                                <tr style="cursor:pointer" v-for="(master_plan_data,index) in service_plan_arr[3]" id="tr_">
                                                    <td rowspan="3"  v-if="index==6"><b>Dependent Property</b> <br>(Commercial)</td>
                                                    <td><b>{{master_plan_data.plan_name}}</b></td>
                                                    <td class="text-center">
                                                        <input 
                                                          type="text" 
                                                          v-bind:name="'quantity['+index+']'" 
                                                          v-bind:id="'quantity_'+index"
                                                          v-model="form.quantity[index]" 
                                                          @keyup="change_quantity(index)"
                                                          placeholder="Type Qunality" />
                                                    </td>
                                                    <td class="text-right">
                                                            {{form.rate[index]}}
                                                    </td>
                                                    <td class="text-right">{{form.amount[index]}}</td>
                                                </tr>
                                                <tr style="cursor:pointer" v-for="(master_plan_data,index) in service_plan_arr[4]" id="tr_">
                                                    <td rowspan="3"  v-if="index==9"><b>Independent Property</b> <br>(Residential)</td>
                                                    <td><b>{{master_plan_data.plan_name}}</b></td>
                                                    <td class="text-center">
                                                        <input 
                                                          type="text" 
                                                          v-bind:name="'quantity['+index+']'" 
                                                          v-bind:id="'quantity_'+index"
                                                          v-model="form.quantity[index]" 
                                                          @keyup="change_quantity(index)"
                                                          placeholder="Type Qunality" />
                                                    </td>
                                                    <td class="text-right">
                                                            {{form.rate[index]}}
                                                    </td>
                                                    <td class="text-right">{{form.amount[index]}}</td>
                                                </tr>
                                                <tr style="cursor:pointer" v-for="(master_plan_data,index) in service_plan_arr[5]" id="tr_">
                                                    <td rowspan="3"  v-if="index==12"><b>Independent Property</b> <br>(Commercial)</td>
                                                    <td><b>{{master_plan_data.plan_name}}</b></td>
                                                    <td class="text-center">
                                                        <input 
                                                          type="text" 
                                                          v-bind:name="'quantity['+index+']'" 
                                                          v-bind:id="'quantity_'+index"
                                                          v-model="form.quantity[index]" 
                                                          @keyup="change_quantity(index)"
                                                          placeholder="Type Qunality" />
                                                    </td>
                                                    <td class="text-right">
                                                            {{form.rate[index]}}
                                                    </td>
                                                    <td class="text-right">{{form.amount[index]}}</td>
                                                </tr>
                                                <tr style="cursor:pointer" v-for="(master_plan_data,index) in service_plan_arr[10]" id="tr_">
                                                    <td rowspan="100"  v-if="index==15"><b>Operating Service</b> </td>
                                                    <td><b>{{master_plan_data.plan_name}}</b></td>
                                                    <td class="text-center">
                                                        <div class="form-holder">
                                                            <div class="form-check-inline">
                                                                <input type="checkbox" value="0" 
                                                                    v-bind:name="'service_enable['+index+']'" 
                                                                    v-bind:id="'service_enable_'+index"
                                                                    v-model="form.service_enable[index]" @change="check_service_enable($event,index)">
                                                            </div>
                                                        </div>
                                                        
                                                    </td>
                                                    <td class="text-right">
                                                            {{form.rate[index]}}
                                                    </td>
                                                    <td class="text-right">{{form.amount[index]}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td colspan="4" class="text-right"><b>Monthly Total Payable</b></td>
                                                    <td class="text-right"><b>{{form.total_monthly_amount}}</b></td>
                                                </tr>
                                                <tr v-show="!form.is_monthly">
                                                    <td colspan="4" class="text-right"><b>Yearly Total Payable</b></td>
                                                    <td class="text-right"><b>{{form.total_yearly_net_amount}}</b></td>
                                                </tr>
                                                <tr v-show="!form.is_monthly"  >
                                                    <td colspan="4" class="text-right"><b>Discount Amount</b></td>
                                                    <td class="text-right"><b>{{form.total_discount_amount}}</b></td>
                                                </tr>
                                                <tr v-show="!form.is_monthly">
                                                    <td colspan="4" class="text-right"><b>Yearly Total Payable (After Discount) </b></td>
                                                    <td class="text-right"><b>{{form.total_yearly_amount}}</b></td>
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
            <button :disabled="form.busy" v-show="!editmode" type="submit" class="action-button">Save</button>
            <button :disabled="form.busy" v-show="editmode" type="submit" class="action-button float-right">Update</button>
            <button type="button" @click="next_setp" class="next action-button">Next <i class="fa fa-angle-right"></i></button>
            <button type="button" @click="previous_step" class="previous action-button-previous"><i class="fa fa-angle-left"></i> Previous</button>
        </form>
    </fieldset>
</template>

<script>
	import Vue from 'vue';
	

	


    export default {
        name:'list-product-categories',
       
        data(){
            return{
            	editmode:false,
				filter: '',
            	form:new Form({

                    is_monthly:1,
                  	id:[],
                    quantity:[],
                  	plan_id:[],
                    plan_name:[],
                  	rate:[],
                  	amount:[],
                    rate_applicable:[],
                    service_enable:[],
                    total_monthly_amount:0,
                    total_yearly_net_amount:0,
                    total_discount_amount:0,
                    total_yearly_amount:0,
                    master_id:'',

            	}),

            	service_plan_arr:[],
               
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchServicePlan();
           
        },
		
	    methods: {

	    	previous_step()
            {
                let route = this.$router.resolve({ path: "/Temp-ContactsPersons" });

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
                	this.service_plan_arr 				= response.data.service_plan_arr;

                    if(response.data.master_plan_arr[0])
                    {
                        this.form.master_id=response.data.master_plan_arr[0].id;
                        this.form.total_monthly_amount=response.data.master_plan_arr[0].total_monthly_amount;
                        this.form.total_yearly_net_amount=response.data.master_plan_arr[0].total_yearly_net_amount;
                        this.form.total_discount_amount=response.data.master_plan_arr[0].total_discount_amount;
                        this.form.total_yearly_amount=response.data.master_plan_arr[0].total_yearly_amount;
                        this.editmode=true;

                    }

                    for (var prop1 in this.service_plan_arr) {
                        for (var prop2 in this.service_plan_arr[prop1]) {
                            if(this.service_plan_arr[prop1][prop2]['plan_id'])
                            {
                                this.form.rate[prop2]                   =this.service_plan_arr[prop1][prop2]['rate'];
                                this.form.rate_applicable[prop2]        =this.service_plan_arr[prop1][prop2]['rate_applicable'];
                                this.form.plan_name[prop2]              =this.service_plan_arr[prop1][prop2]['plan_name'];
                                this.form.amount[prop2]                 =this.service_plan_arr[prop1][prop2]['amount'];
                                this.form.plan_id[prop2]                =this.service_plan_arr[prop1][prop2]['plan_id'];
                                this.form.quantity[prop2]               =this.service_plan_arr[prop1][prop2]['quantity'];
                                this.form.service_enable[prop2]         =this.service_plan_arr[prop1][prop2]['service_enable'];
                                this.form.id[prop2]                     =this.service_plan_arr[prop1][prop2]['id'];
                            }
                            
                        }
                    }
                	
                	
                });

                
          },

          change_peroid(type)
          {

            this.form.is_monthly=type;
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

          check_service_enable(e,index){
                if(e.target.checked)
                {

                    this.form.service_enable[index]=1;
                    this.form.amount[index]=this.form.rate[index];
                    this.calculate_total_amount();
                }
                else
                {
                    this.form.service_enable[index]=0;
                    this.form.amount[index]=0;
                    this.calculate_total_amount();
                }

            },

          calculate_total_amount()
          {
            
                let total_amount=0;
                this.form.amount.forEach((value,index ) => {
                    
                    total_amount+=value;
                  });
                
                this.form.total_monthly_amount=total_amount;
                this.form.total_yearly_net_amount=total_amount*12;
                this.form.total_discount_amount=this.form.total_yearly_net_amount*.2;
                this.form.total_yearly_amount=this.form.total_yearly_net_amount*.8;
          },



            
          
         
       

            updateServicePlan()
            {
				
		        this.form.put('/UserServicePlans/'+this.form.master_id)
				    .then(()=>{
					       //success
					     
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchServicePlan();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createServicePlan()
            {
                if(this.form.total_monthly_amount>0)
                {
                    this.form.post('/UserServicePlans') .then(({ data }) => { 
               
                    
                        toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });

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