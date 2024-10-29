<template>

    <fieldset>
        
        <div class="form-card" style="padding:0">
            <h1 class="page-head">Forms</h1>
        </div>

        <div >
            <form id="msform" @submit.prevent="editmode ? updateForms(1) : createForms()" @keydown="form.onKeydown($event)">
                <div class="form-card" style="padding:0"> 
                    <div class="text-center">

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">Refresh</button>
                
                        

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_list()" >List</button>
         
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="postable">Print</button>

                    </div>
                    <div v-if="list_showable" class="card-body">
                        <div class="pull-left" style="margin-top:50px;">
                            <label for="filter" class="sr-only">Filter</label>
                            <input type="text" class="form-control" v-model="filter" placeholder="Filter" style="width:400px;">
                        </div>
                        <datatable :columns="columns" :data="rows" :filter-by="filter">
                            <template slot-scope="{row}">
                                <tr>
                                    <td>{{ row.sl }}</td>
                                    <td>{{ row.form_no }}</td>
                                    <td>{{ row.form_date }}</td>
                                    <td>{{ row.form_type_string }}</td>
                                    <td>{{ row.priority_level_string }}</td>
                                    <td>{{ row.from_department }}</td>
                                    <td>{{ row.from_id_name }}</td>
                                    <td>{{ row.to_department }}</td>
                                    <td>{{ row.to_id_name }}</td>
                                    <td width="400">{{ row.subject }}</td>
                                    <td width="120">
                                        <button class="btn btn-primary btn-sm"  @click.prevent="editFormEntrys(row.id)">Edit</button>
                                        <button  class="btn btn-danger btn-sm" @click.prevent="FormEntrysDelete(row.id)">Delete</button>
                                    </td>
                                </tr>
                            </template>
                        </datatable>
                        <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
                    </div>

                    <div class="form-folder">
                        <h3><i class="fa fa-hand-point-right"></i>&nbsp;<span >Forms:</span>
                        
                        <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="!general_info_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="general_info_show">Hide</button>
                        </h3>
                        <div class="form-holder" v-show="general_info_show">
                            <div class="row align-self-stretch">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                        
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="fieldlabels">Form No:</label>  
                                                <input v-model="form.form_no" 
                                                    type="text" 
                                                    name="form_no" 
                                                    placeholder="Auto Generated""
                                                    :class="{ 'is-invalid': form.errors.has('form_no') }" disabled/>
                                                <has-error :form="form" field="form_no"></has-error>
                                                
                                            </div>
                                        </div>                                    
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="fieldlabels">Form Date:</label>  
                                                
                                                <date-picker 
                                                    style="width:100%"
                                                    v-model="form.form_date"
                                                    name="form_date"
                                                    lang="en"
                                                    type="approval_date"
                                                    format="ddd, MMM D, YYYY"
                                                    :class="{ 'is-invalid': form.errors.has('form_date') }"></date-picker>
                                                <has-error :form="form" field="form_date"></has-error>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="fieldlabels">Form Type :</label> 
                                                <select v-model="form.form_type"
                                                    name="form_type"
                                                    class="custom-select"
                                                    
                                                    :class="{ 'is-invalid': form.errors.has('form_type') }">
                                                    <option  value="">--Select Form Type-- </option>
                                                    <option  v-for="(single_form,index) in form_type_arr" :value="index">{{single_form}} </option>
                                                    
                                                </select>
                                                <has-error :form="form" field="form_type"></has-error>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="fieldlabels">Priority Level :</label> 
                                                <select v-model="form.priority_level"
                                                    name="priority_level"
                                                    class="custom-select"
                                                    
                                                    :class="{ 'is-invalid': form.errors.has('priority_level') }">
                                                    <option  value="">--Select Priority Level-- </option>
                                                    <option  v-for="(single_priority_level,index) in form_priority_level_arr" :value="index">{{single_priority_level}} </option>
                                                    
                                                </select>
                                                <has-error :form="form" field="priority_level"></has-error>
                                            </div>
                                        </div>
                                         
                                    </div>
                                   
                                </div>
                               
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                                    
                                        <h4>From:</h4>
                                        <label class="fieldlabels">Department:</label>
                                        <input v-model="form.from_department" 
                                            type="text" 
                                            name="from_department" 
                                            placeholder="Type Department" 
                                            :class="{ 'is-invalid': form.errors.has('from_department') }" />

                                        <label class="fieldlabels">ID No- Name:</label>
                                        <input v-model="form.from_id_name" 
                                            type="text" 
                                            name="from_id_name" 
                                            placeholder="Type ID- Name" 
                                            :class="{ 'is-invalid': form.errors.has('from_id_name') }" />

                                        <h4>To:</h4>
                                        <label class="fieldlabels">Department:</label>
                                        <input v-model="form.to_department" 
                                            type="text" 
                                            name="to_department" 
                                            placeholder="Type Department" 
                                            :class="{ 'is-invalid': form.errors.has('to_department') }" />

                                        <label class="fieldlabels">ID No- Name:</label>
                                        <input v-model="form.to_id_name" 
                                            type="text" 
                                            name="to_id_name" 
                                            placeholder="Type ID- Name" 
                                            :class="{ 'is-invalid': form.errors.has('to_id_name') }" />
                                        
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                                    
                                        <h4>Subject:</h4>

                                            <textarea 
                                                v-model="form.subject"
                                                    style="height:300px;"
                                                    id="subject" 
                                                    name="subject" 
                                                    rows="14" 
                                                    cols="500"
                                                    placeholder="Type Reason" 
                                                :class="{ 'is-invalid': form.errors.has('subject') }">
                                            </textarea>
                                            <has-error :form="form" field="subject"></has-error>
                                        
                                       
                                                                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>

                    
                    <div class="text-center" v-if="!list_showable">
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">Refresh</button>
                        

                        <button :disabled="form.busy || editmode"  type="submit" class="btn  btn-primary" style="min-width:110px" >New</button>
                        
                        <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px" >Edit</button>
                        <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click.prevent="deleteFormEntrys()">Delete</button>
                        <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px" @click="updateForms(2)">Save</button>
                        
                        <button :disabled="form.busy || editmode==false || form.posting_status!=1"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()">Post</button>

                        <button :disabled="form.busy || form.posting_status!=1 || form.posting_status<3"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="adjust()">Adjust</button>

                        <button :disabled="form.busy || form.posting_status!=3"  type="button" class="btn  btn-primary" style="min-width:110px" @click="repost()">RePost</button>

        
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="postable">Print</button>
                    </div>
                </div>
            </form>
        </div>
       
             
       


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
        background-color: rgb(0, 112, 192) !important;
    }

    .table_narrow input{

        font-size: 12px !important;
        height: 30px !important;
        margin:5px 0  !important;
    }

    #progressbar li{
        width:10% !important;
    }
    #progressbar li span{
        margin-top:60px;
        font-size:12px !important;
    }

    #progressbar li::before {
        margin-top:10px;
        width:40px;
        height:40px;
        line-height:30px;
    }

</style>

<script>
    import Vue from 'vue';
    import DatePicker from 'vue2-datepicker';
    import VueTimepicker from 'vue2-timepicker';
    import 'vue2-timepicker/dist/VueTimepicker.css'

    export default {
        name:'list-product-categories',
        components:{
            DatePicker,
            VueTimepicker
        },
        data(){
            return{
                editmode:false,
                postable:false,
                tempeditmode:false,
                list_showable:false,
                filter: '',
                form:new Form({
                   
                    form_no:'',
                    form_date:'',
                    form_type:'',
                    priority_level:'',

                    posting_status:0,
                    next_step:0,
                 
                    from_department:'',
                    from_id_name:'',
                    to_department:'',
                    to_id_name:'',
                    subject:'',
                    
                }),

                general_info_show:true,
                form_type_arr:[],
                form_priority_level_arr:[],

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Form No', field: 'form_no' },
                    { label: 'Form Date', field: 'form_date' },
                    { label: 'Form Type', field: 'form_type_string' },
                    { label: 'Priority Level', field: 'priority_level_string' },
                    { label: 'From Department', field: 'from_department' },
                    { label: 'From ID-Name', field: 'from_id_name' },
                    { label: 'To Department', field: 'to_department' },
                    { label: 'To ID-Name', field: 'to_id_name' },
                    { label: 'Subject', field: 'subject' },
                    { label: 'Action', field: '', sortable: false },
                ],
                
                account_holder_type:'',
                rows: [],
         
                uom_arr:['','Square Feet','Square Meter','Square Yard'],
                page: 1,
                per_page:15,
                expanded: null
            }
        },
        
        created: function()
        {
            this.user_menu_name = this.$route.name;
            this.fetchForms();

        },
        
        computed:{

            
            
        },
        methods: {
            

            show_hide_general_info(){
                if(this.general_info_show)
                {
                    this.general_info_show=false;
                }
                else{
                    this.general_info_show=true;
                }
                
            },


            fetchFormEntrysProfile()
            {

                let uri = '/FormEntrys';
                window.axios.get(uri).then((response) => {

                    this.service_provider_arr                   =response.data.service_provider;
                    this.country_arr                            =response.data.country_arr; 
                    this.additional_charge_item                 =response.data.additional_charge_arr;
                    this.deduction_charge_item                  =response.data.deduction_charge_arr;
                     
 
                }); 
              

            },

          

          
           
            fetchForms()
            {

                let uri = '/FormEntrys';
                window.axios.get(uri).then((response) => {

                    this.form_type_arr                   =response.data.form_type_arr;
                    this.form_priority_level_arr         =response.data.form_priority_level_arr;
                 
                   
                }); 
            },

           


            
            editFormEntrys(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/FormEntrys/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.editmode=true;
                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.building_arr                           =response.data.building_arr;
                    this.form.subrooms_list_arr                 =response.data.subrooms_list_arr;
                    this.form.id                                =response.data.sales_offer_list.id;
                    this.form.form_no                         =response.data.sales_offer_list.form_no;
                    this.form.form_date                    =response.data.sales_offer_list.form_date;
                    this.form.posting_status                    =response.data.sales_offer_list.posting_status;
                    
                    this.form.sales_offer_no                 =response.data.sales_offer_list.sales_offer_no;
                    this.form.sales_offer_date               =response.data.sales_offer_list.sales_offer_date;
                    this.form.sales_offer_acceptance_no      =response.data.sales_offer_list.sales_offer_acceptance_no;
                    this.form.sales_offer_acceptance_date    =response.data.sales_offer_list.sales_offer_acceptance_date;
                    this.form.sales_order_no                 =response.data.sales_offer_list.sales_order_no;
                    this.form.sales_order_date               =response.data.sales_offer_list.sales_order_date;
                    this.form.packing_slip_date                 =response.data.sales_offer_list.packing_slip_date;
                    this.form.packing_slip_no                   =response.data.sales_offer_list.packing_slip_no;
                    this.form.sales_return_no                =response.data.sales_offer_list.sales_return_no;
                    this.form.sales_return_date              =response.data.sales_offer_list.sales_return_date;
                    this.form.sales_credit_note_date         =response.data.sales_offer_list.sales_credit_note_date;
                    this.form.sales_credit_note_no           =response.data.sales_offer_list.sales_credit_note_no;
                    this.form.sales_debit_note_date          =response.data.sales_offer_list.sales_debit_note_date;
                    this.form.sales_debit_note_no            =response.data.sales_offer_list.sales_debit_note_no;
                    this.form.sales_invoice_date             =response.data.sales_offer_list.sales_invoice_date;
                    this.form.sales_invoice_no               =response.data.sales_offer_list.sales_invoice_no;

                    this.form.form_type                     =response.data.sales_offer_list.form_type;
                    this.form.next_step                         =response.data.sales_offer_list.next_step;
                    this.form.seller_name                       =response.data.sales_offer_list.seller_name;
                    this.form.seller_id                         =response.data.sales_offer_list.seller_id;
                    this.form.seller_account_no                 =response.data.sales_offer_list.seller_account_no;
                    this.form.seller_photo                      =response.data.sales_offer_list.seller_photo;
                    this.form.seller_photo_id                   =response.data.sales_offer_list.seller_photo_id;

                    this.form.seller_address                    =response.data.sales_offer_list.seller_address;
                    this.form.service_provider_name             =response.data.sales_offer_list.service_provider_name;
                    this.form.service_provider_id               =response.data.sales_offer_list.service_provider_id;
                    this.form.service_provider_photo_id         =response.data.sales_offer_list.service_provider_photo_id;
                    this.form.service_provider_photo            =response.data.sales_offer_list.service_provider_photo;
                    this.form.service_provider_account_no       =response.data.sales_offer_list.service_provider_account_no;
                    this.form.service_provider_contact_no       =response.data.sales_offer_list.service_provider_contact_no;
                    this.form.service_provider_address          =response.data.sales_offer_list.service_provider_address;
                    this.form.customer_name                     =response.data.sales_offer_list.customer_name;
                    this.form.customer_id                       =response.data.sales_offer_list.customer_id;
                    this.form.customer_photo                    =response.data.sales_offer_list.customer_photo;

                    this.form.customer_account_no               =response.data.sales_offer_list.customer_account_no;
                    this.form.customer_contact_no               =response.data.sales_offer_list.customer_contact_no;
                    this.form.customer_address                  =response.data.sales_offer_list.customer_address;
                    this.form.schedule_delivery_date            =response.data.sales_offer_list.schedule_delivery_date;
                    this.form.schdule_delivery_time             =response.data.sales_offer_list.schdule_delivery_time;

                    this.form.delivery_location                 =response.data.sales_offer_list.delivery_location;
                    this.form.delivery_instruction              =response.data.sales_offer_list.delivery_instruction;
                    this.form.delivery_contact_person_name      =response.data.sales_offer_list.delivery_contact_person_name;
                    this.form.delivery_contact_person_email     =response.data.sales_offer_list.delivery_contact_person_email;
                    this.form.delivery_contact_person_phone     =response.data.sales_offer_list.delivery_contact_person_phone;

                    this.form.delivery_receive_by               =response.data.sales_offer_list.delivery_receive_by;
                    this.form.payment_due_date                  =response.data.sales_offer_list.payment_due_date;
                    this.form.days_left_to_pay                  =response.data.sales_offer_list.days_left_to_pay;
                    this.form.early_payment_discount            =response.data.sales_offer_list.early_payment_discount;
                    this.form.payment_method                    =response.data.sales_offer_list.payment_method;

                   
                    this.form.posted_check_available           =response.data.sales_offer_list.posted_check_available;
                    this.form.late_payment_pelanty             =response.data.sales_offer_list.late_payment_pelanty;
                    this.form.hidden_cost                      =response.data.sales_offer_list.hidden_cost;
                    this.form.shipping_cost_pay_by             =response.data.sales_offer_list.shipping_cost_pay_by;
                    this.form.payment_status                   =response.data.sales_offer_list.payment_status;

                    this.form.shipping_company_name            =response.data.sales_offer_list.shipping_company_name;
                    this.form.shipping_company_id              =response.data.sales_offer_list.shipping_company_id;
                    this.form.shipping_company_contact         =response.data.sales_offer_list.shipping_company_contact;
                    this.form.shipping_company_address         =response.data.sales_offer_list.shipping_company_address;
                    this.form.shipping_company_account_no      =response.data.sales_offer_list.shipping_company_account_no;

                    this.form.shipping_company_logo            =response.data.sales_offer_list.shipping_company_logo;
                    this.form.notification_by                  =response.data.sales_offer_list.notification_by;
                    this.form.backorder_allowed                =response.data.sales_offer_list.backorder_allowed;
                    this.form.approval_status                  =response.data.sales_offer_list.approval_status;
                    this.form.vehicle_identification_number    =response.data.sales_offer_list.vehicle_identification_number;

                    this.form.vehicle_make                     =response.data.sales_offer_list.vehicle_make;
                    this.form.vehicle_model                    =response.data.sales_offer_list.vehicle_model;
                    this.form.vehicle_year                     =response.data.sales_offer_list.vehicle_year;
                    this.form.vehicle_type                     =response.data.sales_offer_list.vehicle_type;
                    this.form.vehicle_license_plate            =response.data.sales_offer_list.vehicle_license_plate;

                    this.form.vehicle_image                    =response.data.sales_offer_list.vehicle_image;
                    this.form.vehicle_image_id                 =response.data.sales_offer_list.vehicle_image_id;
                    this.form.vehicle_insurance_information    =response.data.sales_offer_list.vehicle_insurance_information;
                    this.form.driver_address                   =response.data.sales_offer_list.driver_address;
                    this.form.driver_name                      =response.data.sales_offer_list.driver_name;

                    this.form.driver_id                       =response.data.sales_offer_list.driver_id;
                    this.form.driver_photo                    =response.data.sales_offer_list.driver_photo;
                    this.form.driver_license_no               =response.data.sales_offer_list.driver_license_no;
                    this.form.driver_contact_no               =response.data.sales_offer_list.driver_contact_no;
                    this.form.product_details_arr             =response.data.charge_details_arr;
                    this.form.total_addition                  =response.data.total_addition;
                    this.form.total_deduction                 =response.data.total_deduction;
                    this.form.subtotal                        =response.data.sub_total;
                    this.form.total_tax                       =response.data.total_tax;
                    this.form.total                           =response.data.grand_total;

                    

    
                }); 

                this.tempeditmode=false;
                //alert(this.form.next_step)
                
            },
          

            reset_form()
            {
                this.form.reset();
                this.editmode=false;
                this.list_showable=false;
                this.fetchForms();
            },

            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/FormEntryList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.form_entry_list;
                });
                this.list_showable=true;
            },
          
            FormEntrysDelete(id)
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
                    this.form.delete('/FormEntrys/'+id).then(()=>{
                        
                        if(result.value) {
                            Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.reset_list();
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })

            },

            post()
            {  
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Post it!'
                }).then((result) => {
                    this.form.post('/FormEntryPost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            Swal(
                                'Posted!',
                                'Your Data has been Posted.',
                                'success'
                            );
                           
                                this.editFormEntrys(response_data[1]);
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
                
            },

            repost()
            {            
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Repost it!'
                }).then((result) => {
                    this.form.post('/FormEntryRepost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            Swal(
                                'Posted!',
                                'Your Data has been Reposted.',
                                'success'
                            );
                            
                            this.editFormEntrys(response_data[1]);
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
                
            },
    
            deleteFormEntrys()
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
                    this.form.delete('/FormEntrys/'+this.form.id).then(()=>{
                        
                        if(result.value) {
                            Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.fetchFormEntrysProfile();
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
            },
      

            updateFormEntrys()
            { 
                let uri="/FormEntrys/"+this.form.id;
            
                this.form.put(uri).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                        toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        this.editFormEntrys(response_data[1]);
                        this.editmode=true;
                    }
                    else{

                        toast({
                            type: 'danger',
                            title: 'Invalid Operation'
                        });
                    }
                });                
            },
          
          


            adjust()
            { 
                
                 this.form.post('/adjustFormEntry/'+this.form.id).then((response)=>{
                    var response_data=response.data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });
                       
                        this.editFormEntrys(response_data[1]);
                      
                        this.editmode=true;
                    }
                    else{

                        toast({
                            type: 'danger',
                            title: 'Invalid Operation'
                        });
                    }
                });                
                
            },
            
            createForms(){
                
                
                let uri="/FormEntrys";
                this.form.post(uri) .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                        toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });
                       
                            this.editFormEntrys(response_data[1]);
                            this.editmode=true;
                    }
                    else{

                        toast({
                            type: 'danger',
                            title: 'Invalid Operation'
                        });
                    }                    
                })
            },            
        }
    
    }  
    
</script>