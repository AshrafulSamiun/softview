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
                            
                            <div class="col-md-10 offset-md-1 col-sm-12 col-xs-12">
                                <div class="form-box-outer">
                                    <div class="table-responsive">
                                        <table class="table table-bordered ">
                                            <thead>
                                                <tr >
                                                    <th  class="text-center table-ash-td" width="20%">Service Group</th>
                                                    <th  class="text-center table-ash-td" width="24%">Sub-Group</th>
                                                    <th  class="text-center" 
                                                        width="14%"
                                                        :class="{'table-ash-td' : form.service_type==1,'disabled' : form.service_type!=1}"
                                                        @click="choose_plan(1)"> Basic</th>
                                                    <th  class="text-center" 
                                                        width="14%"
                                                        @click="choose_plan(2)"
                                                        :class="{'table-ash-td' : form.service_type==2,'disabled' : form.service_type!=2}">Standard</th>
                                                    <th  class="text-center" 
                                                        width="14%"
                                                        @click="choose_plan(3)"
                                                        :class="{'table-ash-td' : form.service_type==3,'disabled' : form.service_type!=3}">Premium</th>
                                                    <th  class="text-center" 
                                                        width="14%"
                                                        @click="choose_plan(4)"
                                                        :class="{'table-ash-td' : form.service_type==4,'disabled' : form.service_type!=4}">Enterprise</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <template v-for="(service_group,group_id) in service_group_arr">
                                                    <tr style="cursor:pointer" >
                                                        <td class="table-ash-td" >{{service_group.name}}</td>
                                                        <template v-if="service_group.subgroup_available">
                                                            <td></td>
                                                            <td class="text-center"></td>
                                                            <td class="text-right"> </td>
                                                            <td class="text-right"></td>
                                                        </template>
                                                        <template v-else>
                                                            <template v-for="(service_subgroup,subgroup_id) in form.service_subgroup_arr[group_id]">
                                                                <td></td>
                                                                <template v-for="(plan_data,plan_type) in form.master_plan_arr[subgroup_id]">
                                                                    <td class="text-center" 
                                                                        :class="{'table-ash-td' : form.service_type==plan_type}"
                                                                        v-if="plan_data.rate_applicable">
                                                                            
                                                                            <div class="form-check-inline" v-if="service_subgroup.checked">
                                                                                <input type="checkbox" value="1" 
                                                                                    checked="checked" disabled>
                                                                                     {{plan_data.amount}}
                                                                            </div>
                                                                            <div class="form-check-inline" v-else>
                                                                                <input type="checkbox" value="0" disabled>
                                                                                    {{plan_data.rate}}
                                                                            </div>
                                                                       
                                                                    </td>
                                                                    <td v-else></td>
                                                                </template>
                                                            </template>
                                                        </template>

                                                    </tr>
                                                    <template v-for="(service_subgroup,subgroup_id) in form.service_subgroup_arr[group_id]">
                                                        <template v-if="service_group.subgroup_available">
                                                            <tr style="cursor:pointer" >
                                                                <td  >
                                                                    <div class="form-check-inline" v-if="subgroup_id==1 || subgroup_id==2">
                                                                        <input type="checkbox" value="1" 
                                                                            checked="checked" disabled>
                                                                            {{service_subgroup.name}}
                                                                    </div>

                                                                </td>
                                                                <td  v-if="subgroup_id==1 || subgroup_id==2">

                                                                </td>
                                                                <td v-if="subgroup_id != 1 && subgroup_id != 2">
                                                                    <div style="display: flex; align-items: center;" v-if="service_subgroup.quantity_applicable == 1">
                                                                        <div class="form-check-inline" v-if="subgroup_id == 61">
                                                                            <input type="checkbox" value="service_subgroup.checked" 
                                                                                @click="check_service_amount_enabled($event,service_subgroup,subgroup_id,group_id)"
                                                                                v-model="service_subgroup.checked">
                                                                                {{ service_subgroup.name }}
                                                                        </div>
                                                                        <div class="form-check-inline" v-else>
                                                                            <input type="checkbox" value="service_subgroup.checked" 
                                                                                @click="check_service_amount_enabled($event,service_subgroup,subgroup_id,group_id)"
                                                                                v-model="service_subgroup.checked">
                                                                                {{ service_subgroup.name }}
                                                                        </div>
                                                                       
                                                                        <div  style="margin-left: auto;">
                                                                            <input 
                                                                                style="width: 80px;"
                                                                                type="number"
                                                                                :disabled="!service_subgroup.checked"
                                                                                placeholder="User Quantity" 
                                                                                @input="change_service_amount(service_subgroup.default_quantity,subgroup_id,group_id)"
                                                                                v-model="service_subgroup.default_quantity" 
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                    <div style="display: flex; align-items: center;" v-else>
                                                                        {{ service_subgroup.name }}
                                                                        
                                                                    </div>
                                                                     
                                                                </td>

                                                                <template v-for="(plan_data,plan_type) in form.master_plan_arr[subgroup_id]">
                                                                    <td class="text-center" 
                                                                        :class="{'table-ash-td' : form.service_type==plan_type}"
                                                                        v-if="plan_data.rate_applicable">

                                                                            <div class="form-check-inline" v-if="service_subgroup.checked">
                                                                                <input type="checkbox" value="1" 
                                                                                    checked="checked" disabled>
                                                                                     {{plan_data.amount}}
                                                                            </div>
                                                                            <div class="form-check-inline" v-else>
                                                                                <input type="checkbox" value="0" disabled>
                                                                                    {{plan_data.rate}}
                                                                            </div>
                                                                       
                                                                    </td>
                                                                    <td v-else></td>
                                                                </template>
                                                            </tr>
                                                        </template>
                                                    </template>
                                                </template>

                                                
                                                <tr >
                                                    <td></td>
                                                    <td  class="text-left" >
                                                        <b>Monthly Total Net Payable</b>
                                                    </td>
                                                    <template v-for="(total,key) in total_monthly_net_amount">
                                                        <td 
                                                            class="text-center"  
                                                            :class="{'table-ash-td' : form.service_type==key,'disabled' : form.service_type!=key}"
                                                            v-if="key>0">
                                                            <b>{{total_monthly_net_amount[key]}}</b>
                                                        </td>
                                                    </template>
                                                    
                                                </tr>
                                                <tr v-if="form.is_monthly==1">
                                                    <td></td>
                                                    <td  class="text-left" >
                                                        <b>Sales Tax</b>
                                                    </td>
                                                    <template v-for="(total,key) in total_sales_tax_monthly">
                                                        <td 
                                                            class="text-center"  
                                                            :class="{'table-ash-td' : form.service_type==key,'disabled' : form.service_type!=key}"
                                                            v-if="key>0">
                                                            <b>{{total_sales_tax_monthly[key]}}</b>
                                                        </td>
                                                    </template>
                                                </tr>
                                                <tr v-if="form.is_monthly==1">
                                                    <td></td>
                                                    <td  class="text-left" >
                                                        <b>Monthly Total Payable</b>
                                                    </td>
                                                    <template v-for="(total,key) in total_monthly_amount">
                                                        <td 
                                                            class="text-center"  
                                                            :class="{'table-ash-td' : form.service_type==key,'disabled' : form.service_type!=key}"
                                                            v-if="key>0">
                                                            <b>{{total_monthly_amount[key]}}</b>
                                                        </td>
                                                    </template>
                                                    
                                                </tr>
                                                <tr v-if="form.is_monthly==2">
                                                    <td></td>
                                                    <td  class="text-left" >
                                                        <b>Yearly Net Payable</b>
                                                    </td>
                                                    <template v-for="(total,key) in total_yearly_net_amount">
                                                        <td 
                                                            class="text-center"  
                                                            :class="{'table-ash-td' : form.service_type==key,'disabled' : form.service_type!=key}"
                                                            v-if="key>0">
                                                            <b>{{total_yearly_net_amount[key]}}</b>
                                                        </td>
                                                    </template>
                                                </tr>

                                                <tr v-if="form.is_monthly==2">
                                                    <td></td>
                                                    <td  class="text-left" >
                                                        <b>Discount Amount</b>
                                                    </td>
                                                    <template v-for="(total,key) in total_discount_amount">
                                                        <td 
                                                            class="text-center"  
                                                            :class="{'table-ash-td' : form.service_type==key,'disabled' : form.service_type!=key}"
                                                            v-if="key>0">
                                                            <b>{{total_discount_amount[key]}}</b>
                                                        </td>
                                                    </template>
                                                </tr>

                                                <tr v-if="form.is_monthly==2">
                                                    <td></td>
                                                    <td  class="text-left" >
                                                        <b>Sales Tax</b>
                                                    </td>
                                                    <template v-for="(total,key) in total_sales_tax_yearly">
                                                        <td 
                                                            class="text-center"  
                                                            :class="{'table-ash-td' : form.service_type==key,'disabled' : form.service_type!=key}"
                                                            v-if="key>0">
                                                            <b>{{total_sales_tax_yearly[key]}}</b>
                                                        </td>
                                                    </template>
                                                </tr>

                                                <tr v-if="form.is_monthly==2">
                                                    <td></td>
                                                    <td  class="text-left" >
                                                        <b>Yearly Total Payable</b>
                                                    </td>
                                                    <template v-for="(total,key) in total_yearly_amount">
                                                        <td 
                                                            class="text-center"  
                                                            :class="{'table-ash-td' : form.service_type==key,'disabled' : form.service_type!=key}"
                                                            v-if="key>0">
                                                            <b>{{total_yearly_amount[key]}}</b>
                                                        </td>
                                                    </template>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row align-self-stretch">
                            <div class="col-md-5 offset-md-1 col-sm-12 col-xs-12">
                                <label class="fieldlabels">Comments:</label> 
                                <textarea 
                                    v-model="form.comments"
                                    style="height:100px;"
                                    id="comments" 
                                    name="comments" 
                                    rows="4" 
                                    cols="50"></textarea>
                            </div>
                             <div class="col-md-4 offset-md-1 col-sm-12 col-xs-12">
                                <h6><strong>Note:The fee is charged per registered user, is non-refundable, non-transferable, and excludes sales tax(s).</strong></h6> 
                                
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
    .table thead th:nth-child(n+3):nth-child(-n+6) {
        /* Add your styles here */
        cursor:pointer;
    }
    
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
                    currency_id:2,
                    sales_tax_rate:'',
                    total_monthly_net_amount:0,
                    total_monthly_amount:0,
                    total_yearly_net_amount:0,
                    total_discount_amount:0,
                    total_sales_tax_monthly:0,
                    total_sales_tax_yearly:0,
                    total_yearly_amount:0,
                    master_id:'',
                    comments:'',
                    service_type:3,
                    service_plan_arr:[],
                    master_plan_arr:[], 
                    service_subgroup_arr:[],               

                }),
                service_group_arr:[],
                
                currency_arr:[], 
                conversion_rate_arr:[],
                total_monthly_amount:[],
                total_monthly_net_amount:[],
                total_yearly_net_amount:[],
                total_discount_amount:[],
                total_sales_tax_monthly:[],
                total_sales_tax_yearly:[],
                total_yearly_amount:[],             
      
            }
        },
        
        created: function()
        {
            
            this.user_menu_name = this.$route.name;
            this.fetchServicePlan();
        },
        
        methods: {


            choose_plan(type)
            {
                this.form.service_type=type;                
            },

            currency_select(index){
               
                var previous_currency=this.form.currency_id;
                this.form.currency_id=index;

                var conversion_rate=this.conversion_rate_arr[previous_currency]/this.conversion_rate_arr[index];


                let    temthis=this;

                Object.entries(this.form.master_plan_arr).forEach(entry => {
                    const [key, level] = entry;

                    Object.entries(temthis.form.master_plan_arr[key]).forEach(entry1 => {
                        const [key1, level1] = entry1;
                        
                        level1.rate=parseInt(level1.rate*conversion_rate);
                        level1.amount=parseInt(level1.amount*conversion_rate);
                       // alert(level1.rate)
                        
                    });                    
                    
                });

                this.calculate_total_amount(); 
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

                    this.form.service_plan_arr         = response.data.service_plan_arr;
                    this.form.master_plan_arr          = response.data.master_plan_arr;
                    this.service_group_arr             = response.data.service_group_arr;
                    this.form.service_subgroup_arr     = response.data.service_subgroup_arr;
                    this.currency_arr                  = response.data.currency_arr;
                    this.conversion_rate_arr           =response.data.conversion_rate_arr;
                    this.form.sales_tax_rate           =response.data.sales_tax_rate;
                    var sl=0;
                    
                    if(response.data.update_master_data_arr.id > 0)
                    {
                        
                        this.form.master_id                 =response.data.update_master_data_arr.id;
                        this.form.currency_id               =response.data.update_master_data_arr.currency_id;
                        this.form.is_montyly                =response.data.update_master_data_arr.is_montyly;
                        this.form.service_type              =response.data.update_master_data_arr.service_type;
                        this.form.comments                  =response.data.update_master_data_arr.comments;
                        this.form.sales_tax_rate            =response.data.sales_tax_rate;
                        
                        this.form.total_monthly_net_amount  =response.data.update_master_data_arr.total_monthly_net_amount;
                        this.form.total_sales_tax_monthly    =response.data.update_master_data_arr.total_sales_tax_monthly;
                        this.form.total_monthly_amount      =response.data.update_master_data_arr.total_monthly_amount;
                        this.form.total_yearly_net_amount   =response.data.update_master_data_arr.total_yearly_net_amount;
                        this.form.total_discount_amount     =response.data.update_master_data_arr.total_discount_amount;
                        this.form.total_sales_tax_yearly    =response.data.update_master_data_arr.total_sales_tax_yearly;
                        this.form.total_yearly_amount       =response.data.update_master_data_arr.total_yearly_amount;
                        
                        this.editmode=true;

                    }  

                    this.calculate_total_amount();                 
                    
                });
                
            },

            change_peroid(type)
            {
                if(type==1)
                    this.form.is_monthly=1;
                else if(type==2) this.form.is_monthly=2;
            },

            change_service_amount(quantity,subgroup_id,group_id)
            {
                if(quantity>0) quantity=quantity;
                else 
                {
                    quantity=0;
                    this.form.service_subgroup_arr[group_id][subgroup_id]['default_quantity']=quantity;
                }
                Object.entries(this.form.master_plan_arr[subgroup_id]).forEach(entry => {
                    const [key, level] = entry;
                    level.amount=level.rate*quantity;
                    level.quantity=quantity;
                    //console.log(level.amount)
                });  

                this.calculate_total_amount();              
                 
            },
            check_service_amount_enabled(e,subgroup,subgroup_id,group_id)
            {

                if(e.target.checked)
                {
                    subgroup.checked=true;

                    if(subgroup.default_quantity>0) var quantity=quantity;
                    else 
                    {
                        var quantity=1;
                        this.form.service_subgroup_arr[group_id][subgroup_id]['default_quantity']=quantity;
                        Object.entries(this.form.master_plan_arr[subgroup_id]).forEach(entry => {
                            const [key, level] = entry;
                            level.amount=level.rate*quantity;
                            level.quantity=quantity;
                           // console.log(level.amount)
                        }); 

                    }

                }
                else
                {
                    
                    var quantity=0;
                    this.form.service_subgroup_arr[group_id][subgroup_id]['default_quantity']=quantity;
                    
                    Object.entries(this.form.master_plan_arr[subgroup_id]).forEach(entry => {
                        const [key, level] = entry;
                        level.amount=0;
                        level.quantity=quantity;
                        //console.log(level.amount)
                    });  
                } 

                this.calculate_total_amount();
                 
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
                let total_amount=[];
               
                let    temthis=this;

                Object.entries(this.form.master_plan_arr).forEach(entry => {
                    const [key, level] = entry;

                    Object.entries(temthis.form.master_plan_arr[key]).forEach(entry1 => {
                        const [key1, level1] = entry1;
                        if(level1.rate_applicable) 
                        {
                            if(key1 in total_amount==false) total_amount[key1]=level1.amount*1;
                            else total_amount[key1]+=level1.amount*1;
                        }                       
                        
                    });                    
                    
                });


                Object.entries(total_amount).forEach(entry => {

                    const [key, level] = entry;
                    this.total_monthly_net_amount[key]      =level;
                    this.total_sales_tax_monthly[key]       =parseInt(level*this.form.sales_tax_rate)
                    this.total_monthly_amount[key]          =level+this.total_sales_tax_monthly[key];
                    this.total_yearly_net_amount[key]       =level*12;
                    this.total_discount_amount[key]         =parseInt(temthis.total_yearly_net_amount[key]*.05);
                    this.total_sales_tax_yearly[key]        =parseInt(temthis.total_yearly_net_amount[key]*this.form.sales_tax_rate);
                    this.total_yearly_amount[key]           =this.total_yearly_net_amount[key]-this.total_discount_amount[key]+this.total_sales_tax_yearly[key];

                    if(key==temthis.form.service_type)
                    {

                        temthis.form.total_monthly_net_amount   =level;
                        temthis.form.total_sales_tax_monthly    =parseInt(level*this.form.sales_tax_rate);
                        temthis.form.total_monthly_amount       = this.total_monthly_amount[key];
                        temthis.form.total_yearly_net_amount    =this.total_yearly_net_amount[key];
                        temthis.form.total_discount_amount      =this.total_discount_amount[key];
                        temthis.form.total_sales_tax_yearly     =this.total_sales_tax_yearly[key];
                        temthis.form.total_yearly_net_amount    =this.total_yearly_amount[key];
                    }
                    
                                 
                }); 

                
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
                if(this.form.total_monthly_net_amount>0)
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