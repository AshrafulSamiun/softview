<template>
    <fieldset>
        <div class="form-card" style="padding:0">
            <h1 class="page-head">Petty Cash</h1>
            <div class="form-folder">
                
                <div class="form-holder" >
                    <div class="card" id="msform">
        
                        <!-- progressbar -->
                        <ul id="progressbar">
                           
                            <li  :class="{ active: petty_cash_page>=1 }"> <strong>1/3<br><span>                                    
                                <a href="javascript:void(0)" @click="change_page(1)" class="router-link ">
                                    <p>Initial Payment({{total_purchase_offer_qty}})</p>
                                </a>
                               </span> </strong>
                            </li>
                            <li :class="{ active: petty_cash_page>=2 }">
                                <strong>2/10<br>
                                    <span>                                    
                                    <a href="javascript:void(0)" @click="change_page(2)" class="router-link ">
                                        <p> New Petty Cash Report({{total_purchase_offer_acceptance_qty}})</p>
                                        
                                    </a>
                                   </span> 
                               </strong>
                            </li>
                           <!--- router-link-active -->
                            <li :class="{ active: petty_cash_page>=3 }"> <strong>3/10<br><span>                                    
                                <a href="javascript:void(0)" @click="change_page(3)" class="router-link ">
                                    <p>Reimbursement Payment ({{total_purchase_order_qty}})</p>
                                </a>
                               </span> </strong>
                            </li>

                            
                           
                        </ul>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated"  role="progressbar" aria-valuemin="0" :style="{  width: percent + '%' }"  aria-valuemax="100"></div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div >
            <form id="msform" @submit.prevent="editmode ? updatePurchase(1) : createPurchase()" @keydown="form.onKeydown($event)">
                <div class="form-card" style="padding:0"> 
                    <div class="text-center">



                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_list()" v-if="petty_cash_page==1">List</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_offer_acceptance_list()"  v-else-if="petty_cash_page==2">List</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_order_list()" v-else-if="petty_cash_page==3">List</button>

                        
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
                                    <td>{{ row.system_no }}</td>
                                    <td>{{ row.transaction_no }}</td>
                                    <td>{{ row.transaction_type_string }}</td>
                                    <td>{{ row.seller_name }}</td>
                                    <td>{{ row.service_provider_name }}</td>
                                    <td>{{ row.customer_name }}</td>
                                    <td>{{ row.approval_status }}</td>
                                    <td>{{ row.schedule_delivery_date }}</td>
                                    <td>{{ row.shipping_company }}</td>
                                    <td>{{ row.driver_name }}</td>
                                    <td width="120">
                                        <button class="btn btn-primary btn-sm"  @click.prevent="AllEditPurchase(row.id)">Edit</button>
                                        <button  class="btn btn-danger btn-sm" @click.prevent="PurchaseOffersDelete(row.id)">Delete</button>
                                    </td>
                                </tr>
                            </template>
                        </datatable>
                        <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
                    </div>
                    
                    <div class="form-folder">
                        <h3>
                            <i class="fa fa-hand-point-right"></i>&nbsp;
                                <span v-if="petty_cash_page==1">Initial Payment:</span>
                                <span v-else-if="petty_cash_page==2">New Petty Cash Report:</span>
                                <span v-else-if="petty_cash_page==3">Reimbursement Payment:</span>
                               
                            
                            <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="!general_info_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="general_info_show">Hide</button>
                        </h3>
                        <div class="form-holder" v-show="general_info_show">
                            <div class="row align-self-stretch">
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                        
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="fieldlabels">Unique No:</label>  
                                                <input v-model="form.unique_no" 
                                                    type="text" 
                                                    name="unique_no" 
                                                    placeholder="Auto Generated""
                                                    :class="{ 'is-invalid': form.errors.has('unique_no') }" disabled/>
                                                <has-error :form="form" field="unique_no"></has-error>
                                                
                                            </div>
                                        </div>                                    
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="fieldlabels">Trsnaction No:</label>  
                                                
                                                <input v-model="form.transaction_no" 
                                                    type="text" 
                                                    name="transaction_no" 
                                                    placeholder="Auto Generated""
                                                    :class="{ 'is-invalid': form.errors.has('transaction_no') }" disabled/>
                                                <has-error :form="form" field="transaction_no"></has-error>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="fieldlabels">Transaction Type :</label> 
                                                <select v-model="form.transaction_type"
                                                    name="transaction_type"
                                                    class="custom-select"
                                                   
                                                    :class="{ 'is-invalid': form.errors.has('transaction_type') }" disabled>
                                                    <option  value="">--Select Transaction Type-- </option>
                                                    <option  value="1">Purchase </option>
                                                    <option  value="2">Sales </option>
                                                    <option  value="3">Petty Cash </option>
                                                </select>
                                                <has-error :form="form" field="transaction_type"></has-error>


                                                <label class="fieldlabels">Transaction Date:</label>
                                                <date-picker 
                                                    style="width:100%"
                                                    v-model="form.transaction_date"
                                                    name="transaction_date"
                                                    lang="en"
                                                    type="transaction_date"
                                                    format="ddd, MMM D, YYYY"
                                                    :class="{ 'is-invalid': form.errors.has('transaction_date') }"></date-picker>
                                                <has-error :form="form" field="transaction_date"></has-error>
                                               
                                                                                            
                                                <table class="table table_narrow">
                                                    <thead>
                                                        <tr>
                                                            <th> Particular</th>
                                                            <th> ID-Name</th>
                                                            <th> Date-Time </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Prepared By</td>
                                                            <td> </td>
                                                            <td> </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Approve By</td>
                                                            <td></td>
                                                            <td> </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Posted By</td>
                                                            <td> </td>
                                                            <td> </td>
                                                        </tr>
                                                        
                                                    </tbody>

                                                </table> 
                                            </div>
                                        </div>
                                         
                                    </div>
                                   
                                </div>
                               
                               
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                                    
                                        <div class="form-holder">
                                            <label class="fieldlabels">Cost Centre:</label>
                                            <div class="form-check-inline">
                                               
                                                <select v-model="form.cost_center"
                                                    name="cicle[]"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('cost_center') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                </select>
                                                <has-error :form="form" field="cost_center"></has-error> 
                                            </div>
                                            
                                            <label class="fieldlabels">Posting Status:</label>
                                            <div class="form-check-inline">
                                               
                                                <select v-model="form.payment_posting_status"
                                                    name="cicle[]"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('payment_posting_status') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option value="1">Saved</option>
                                                    <option value="2">Posted</option>
                                                    <option value="3">Reposted</option>
                                                </select>
                                                <has-error :form="form" field="payment_posting_status"></has-error> 
                                            </div>

                                            <label class="fieldlabels">Petty Cash Holder Name:</label>
                                            <input v-model="form.petty_cash_holder_name" 
                                                type="text" 
                                                name="petty_cash_holder_name" 
                                                placeholder="Type Cash Holder Name" 
                                                :class="{ 'is-invalid': form.errors.has('petty_cash_holder_name') }" />
                                            <has-error :form="form" field="petty_cash_holder_name"></has-error> 

                                            <label class="fieldlabels">Payment Method:</label>
                                            <div class="form-check-inline">
                                               
                                                <select v-model="form.payment_method"
                                                    name="cicle[]"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('payment_method') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option value="1">Online Banking</option>
                                                    <option value="2">Email Transfer</option>
                                                    <option value="3">Cash</option>
                                                    <option value="4">Check</option>
                                                    <option value="5">Money Order</option>
                                                </select>
                                                <has-error :form="form" field="payment_method"></has-error> 
                                            </div> 

                                            <label class="fieldlabels">Check No:</label>
                                            <input v-model="form.check_no" 
                                                type="text" 
                                                name="check_no" 
                                                placeholder="Type Check No" 
                                                :class="{ 'is-invalid': form.errors.has('check_no') }" /> 

                                            <label class="fieldlabels">Check Date</label>
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form.check_date"
                                                name="check_date"
                                                lang="en"
                                                type="check_date"
                                                format="ddd, MMM D, YYYY"
                                                :class="{ 'is-invalid': form.errors.has('check_date') }"></date-picker>
                                            <has-error :form="form" field="check_date"></has-error>

                                            <label class="fieldlabels">Check Amount:</label>
                                            <input v-model="form.chack_amount" 
                                                type="text" 
                                                name="chack_amount" 
                                                placeholder="Type Check Amount" 
                                                :class="{ 'is-invalid': form.errors.has('chack_amount') }" />
                                            <has-error :form="form" field="chack_amount"></has-error>

                                            <label class="fieldlabels">Payee Name:</label>
                                            <input v-model="form.payee_name" 
                                                type="text" 
                                                name="payee_name" 
                                                placeholder="Type Payee Name" 
                                                :class="{ 'is-invalid': form.errors.has('payee_name') }" />
                                            <has-error :form="form" field="payee_name"></has-error>
                                       
                                        </div>
                                    </div>
                                </div>
                          

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                        <h4>Chart Of Account</h4>
                                        <table class="table table_narrow">
                                            <thead>
                                                <tr>
                                                    <th> Account Type</th>
                                                    <th> Account code-Name </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(accountType,index) in form.account_type_arr">
                                                    <td> {{accountType.name}}</td>
                                                    <td> 
                                                        <input v-model="accountType.details" 
                                                            type="text" 
                                                            name="details[]"
                                                            @dblclick="chart_of_account_popup(index)" 
                                                            placeholder="Browse Chart Of Account" 
                                                            :class="{ 'is-invalid': form.errors.has('details[]') }" readonly/>
                                                        <has-error :form="form" field="details[]"></has-error>
                                                    </td>
                                                </tr>
                                                
                                            </tbody>

                                        </table>  
                                    

                                        <label class="fieldlabels">Comments:</label> 
                                        <textarea 
                                            v-model="form.comments"
                                                style="height:170px;"
                                                id="comments" 
                                                name="comments" 
                                                rows="6" 
                                                cols="100"
                                                placeholder="Type Comments" 
                                            :class="{ 'is-invalid': form.errors.has('comments') }">
                                        </textarea>


                                    </div>
                                </div>
                               
                                
                            </div>
                        </div>
                       
                       
                    </div>

                 
                    <div class="text-center" v-if="!list_showable">
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">Refresh </button>

                        <button :disabled="form.busy || editmode==true || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px" >New</button>

                        <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px" >Edit</button>

                        <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click.prevent="deletePurchaseOffers()">Delete</button>

                        <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="updatePurchase(2)">Save</button>
                                    

                        <button :disabled="form.busy || editmode==false || form.posting_status!=1"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()">Post</button>

                        <button :disabled="form.busy || form.posting_status<2"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="adjust()">Adjust</button>

                        <button :disabled="form.busy || form.posting_status!=3"  type="button" class="btn  btn-primary" style="min-width:110px" @click="repost()">RePost</button>
                                                

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step==0 && petty_cash_page==1" @click="convert_to_purchase_offer(form.id)">Convert To Offer Acceptance</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step==0 && petty_cash_page==2" @click="convert_from_offer_acceptance(form.id)">Convert To Order</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step==0 && petty_cash_page==3" @click="convert_from_order(form.id)">Convert To Packing Slip</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step_return==0 && petty_cash_page==4" @click="convert_to_return(form.id)">Convert To Return</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step_debit==0 && petty_cash_page==4" @click="convert_to_debit_note(form.id)">Convert To Debit Note</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step_credit==0 && petty_cash_page==4" @click="convert_to_credit_note(form.id)">Convert To Credit Note</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step==0 && petty_cash_page==4" @click="convert_to_invoice(form.id)">Convert To Purchase Invoice</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step!=1 && petty_cash_page==8" @click="convert_to_direct_payment(form.id)">Convert To Direct Receipt</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step!=1 && petty_cash_page==9" @click="account_statement(form.id)">Account Statement</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="postable">Print</button>
                    </div>
                </div>
            </form>
        </div>
        <!--  Model  -->
                <div class="modal fade model-middle" id="chartOfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
                  <div class="modal-dialog" role="document" >
                    <div class="modal-content" style="width:900px">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Custom field</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" >
                        <div class="form-holder">
                            <table id="tbl_journal_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Main-Group</th>
                                    <th>Sub-Group</th>
                                    <th>Account No</th>
                                    <th>Description</th>
                                    <th>Govt Tax Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="cursor:pointer" v-for="(coa_data,index) in coa_arr"  @click.prevent="account_popup_close(coa_data)"
                                    >
                                    <td>{{ index+1}}</td>
                                    <td>{{ coa_data.sub_group_name }}</td>
                                    <td>{{ coa_data.account_title }}</td>
                                    <td>{{ coa_data.account_no }}</td>
                                    <td>{{ coa_data.description }}</td>
                                    <td>{{ coa_data.govt_tax_code }}</td>
                                
                                </tr>
                            </tbody>
                           
                        </table>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="modelClose()">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

            <!-- Model end -->

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
        width:20% !important;
    }
    #progressbar li span{
        margin-top:60px;
        font-size:14px !important;
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
                show_company:true,
                list_showable:false,
                summery_showable:false,
                filter: '',
                petty_cash_page:1,
                temp_account_type:'',
                form:new Form({

                    account_type_arr:[
                        {
                            name:'Bank',
                            account_type:1,
                            details:'',
                            chart_of_account:'',
                            chart_of_account_id:'',
                        },
                        {
                            account_type:2,
                            name:'Petty Cash Holder',
                            chart_of_account:'',
                            details:'',
                            chart_of_account_id:'',
                        }
                    ],
                    unique_no:'',
                    transaction_no:'',
                    transaction_type:3,
                    transaction_date:'',
                    transaction_time:'',
                    calender_code:'',
                    payment_posting_status:'',
                    next_step:0,
                    next_step_return:0,
                    next_step_debit:0,
                    next_step_credit:0,

                    cost_center:'',
                    posting_status:'',
                    petty_cash_holder_name:'',
                    payment_method:'',
                    check_no:'',
                    check_date:'',
                    chack_amount:'',
                    payee_name:'',
                    comments:'',
                    page_id:1,
                    id:'',
             
                    
                }),
                coa_arr:[],
           
                

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Unique No', field: 'system_no' },
                    { label: 'Transaction No', field: 'system_no' },
                    { label: 'Purchase Type', field: 'transaction_type_string' },
                    { label: 'Seller', field: 'seller_name' },
                    { label: 'Service Provider', field: 'service_provider_name' },
                    { label: 'Customer', field: 'customer_name' },
                    { label: 'Approval Status', field: 'approval_status' },
                    { label: 'Delivery Date', field: 'schedule_delivery_date' },
                    { label: 'Shipping Company', field: 'shipping_company' },
                    { label: 'Driver Name', field: 'driver_name' },
                    { label: 'Action', field: '', sortable: false },
                ],
              
            
                rows: [],
                test_collupsable:false,
                general_info_show:true,
                purchase_summery_show:false,
                product_info_show:false,
                property_show:false,
                percent:11,
               
                uom_arr:['','Square Feet','Square Meter','Square Yard'],
                page: 1,
                per_page:15,
                expanded: null
            }
        },
        
        created: function()
        {
            this.user_menu_name = this.$route.name;
            this.fetchPurchaseOffers();
            this.setProgressBar(1,3);

        },
        
        computed:{

            
            
        },
        methods: {

            chart_of_account_popup(accountTypeId)
            {
                this.temp_account_type=accountTypeId;
                $("#chartOfModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
            },
            account_popup_close(coa)
            {
                this.form.account_type_arr[this.temp_account_type].chart_of_account=coa.account_no;
                this.form.account_type_arr[this.temp_account_type].chart_of_account_id=coa.id;
                this.form.account_type_arr[this.temp_account_type].details=coa.account_no+"-"+coa.description;
                
                
                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove() ;
                this.temp_account_type="";

            },
        
            convert_from_offer_acceptance(offer_id)
            {
                
                this.setProgressBar(3,10);
                this.petty_cash_page=3;
                this.fetchPurchaseOrder(offer_id);
            },
            fetchPurchaseOrder(offer_id)
            {

                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchaseOfferAcceptances/'+offer_id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.editmode=false;
                    
                    //this.form.id                              =response.data.purchase_offer_list.id;
                    this.form.unique_no                         =response.data.purchase_offer_list.unique_no;
                   // this.form.transaction_no                  =response.data.purchase_offer_list.transaction_no;
                    this.form.posting_status                    =0;
                    
                    this.form.purchase_offer_no                 =response.data.purchase_offer_list.purchase_offer_no;
                    this.form.purchase_offer_date               =response.data.purchase_offer_list.purchase_offer_date;
                    this.form.purchase_offer_acceptance_no      =response.data.purchase_offer_list.purchase_offer_acceptance_no;
                    this.form.purchase_offer_acceptance_date    =response.data.purchase_offer_list.purchase_offer_acceptance_date;
                    this.form.purchase_order_no                 =response.data.purchase_offer_list.purchase_order_no;
                    this.form.purchase_order_date               =response.data.purchase_offer_list.purchase_order_date;
                    this.form.packing_slip_date                 =response.data.purchase_offer_list.packing_slip_date;
                    this.form.packing_slip_no                   =response.data.purchase_offer_list.packing_slip_no;
                    this.form.purchase_return_no                =response.data.purchase_offer_list.purchase_return_no;
                    this.form.purchase_return_date              =response.data.purchase_offer_list.purchase_return_date;
                    this.form.purchase_credit_note_date         =response.data.purchase_offer_list.purchase_credit_note_date;
                    this.form.purchase_credit_note_no           =response.data.purchase_offer_list.purchase_credit_note_no;
                    this.form.purchase_debit_note_date          =response.data.purchase_offer_list.purchase_debit_note_date;
                    this.form.purchase_debit_note_no            =response.data.purchase_offer_list.purchase_debit_note_no;
                    this.form.purchase_invoice_date             =response.data.purchase_offer_list.purchase_invoice_date;
                    this.form.purchase_invoice_no               =response.data.purchase_offer_list.purchase_invoice_no;

                    this.form.transaction_type                     =response.data.purchase_offer_list.transaction_type;
                    this.form.next_step                         =0;
                    this.form.seller_name                       =response.data.purchase_offer_list.seller_name;
                    this.form.seller_id                         =response.data.purchase_offer_list.seller_id;
                    this.form.seller_account_no                 =response.data.purchase_offer_list.seller_account_no;
                    this.form.seller_photo                      =response.data.purchase_offer_list.seller_photo;
                    this.form.seller_photo_id                   =response.data.purchase_offer_list.seller_photo_id;

                    this.form.seller_address                    =response.data.purchase_offer_list.seller_address;
                    this.form.service_provider_name             =response.data.purchase_offer_list.service_provider_name;
                    this.form.service_provider_id               =response.data.purchase_offer_list.service_provider_id;
                    this.form.service_provider_photo_id         =response.data.purchase_offer_list.service_provider_photo_id;
                    this.form.service_provider_photo            =response.data.purchase_offer_list.service_provider_photo;
                    this.form.service_provider_account_no       =response.data.purchase_offer_list.service_provider_account_no;
                    this.form.service_provider_contact_no       =response.data.purchase_offer_list.service_provider_contact_no;
                    this.form.service_provider_address          =response.data.purchase_offer_list.service_provider_address;
                    this.form.customer_name                     =response.data.purchase_offer_list.customer_name;
                    this.form.customer_id                       =response.data.purchase_offer_list.customer_id;
                    this.form.customer_photo                    =response.data.purchase_offer_list.customer_photo;

                    this.form.customer_account_no               =response.data.purchase_offer_list.customer_account_no;
                    this.form.customer_contact_no               =response.data.purchase_offer_list.customer_contact_no;
                    this.form.customer_address                  =response.data.purchase_offer_list.customer_address;
                    this.form.schedule_delivery_date            =response.data.purchase_offer_list.schedule_delivery_date;
                    this.form.schdule_delivery_time             =response.data.purchase_offer_list.schdule_delivery_time;

                    this.form.delivery_location                 =response.data.purchase_offer_list.delivery_location;
                    this.form.delivery_instruction              =response.data.purchase_offer_list.delivery_instruction;
                    this.form.delivery_contact_person_name      =response.data.purchase_offer_list.delivery_contact_person_name;
                    this.form.delivery_contact_person_email     =response.data.purchase_offer_list.delivery_contact_person_email;
                    this.form.delivery_contact_person_phone     =response.data.purchase_offer_list.delivery_contact_person_phone;

                    this.form.delivery_receive_by               =response.data.purchase_offer_list.delivery_receive_by;
                    this.form.payment_due_date                  =response.data.purchase_offer_list.payment_due_date;
                    this.form.days_left_to_pay                  =response.data.purchase_offer_list.days_left_to_pay;
                    this.form.early_payment_discount            =response.data.purchase_offer_list.early_payment_discount;
                    this.form.payment_method                    =response.data.purchase_offer_list.payment_method;

                   
                    this.form.posted_check_available           =response.data.purchase_offer_list.posted_check_available;
                    this.form.late_payment_pelanty             =response.data.purchase_offer_list.late_payment_pelanty;
                    this.form.hidden_cost                      =response.data.purchase_offer_list.hidden_cost;
                    this.form.shipping_cost_pay_by             =response.data.purchase_offer_list.shipping_cost_pay_by;
                    this.form.payment_status                   =response.data.purchase_offer_list.payment_status;

                    this.form.shipping_company_name            =response.data.purchase_offer_list.shipping_company_name;
                    this.form.shipping_company_id              =response.data.purchase_offer_list.shipping_company_id;
                    this.form.shipping_company_contact         =response.data.purchase_offer_list.shipping_company_contact;
                    this.form.shipping_company_address         =response.data.purchase_offer_list.shipping_company_address;
                    this.form.shipping_company_account_no      =response.data.purchase_offer_list.shipping_company_account_no;

                    this.form.shipping_company_logo            =response.data.purchase_offer_list.shipping_company_logo;
                    this.form.notification_by                  =response.data.purchase_offer_list.notification_by;
                    this.form.backorder_allowed                =response.data.purchase_offer_list.backorder_allowed;
                    this.form.approval_status                  =response.data.purchase_offer_list.approval_status;
                    this.form.transaction_date                     =response.data.purchase_offer_list.transaction_date;
                    this.form.transaction_time                     =response.data.purchase_offer_list.transaction_time;
                    this.form.approve_by                        =response.data.purchase_offer_list.approve_by;
                    this.form.vehicle_identification_number    =response.data.purchase_offer_list.vehicle_identification_number;

                    this.form.vehicle_make                     =response.data.purchase_offer_list.vehicle_make;
                    this.form.vehicle_model                    =response.data.purchase_offer_list.vehicle_model;
                    this.form.vehicle_year                     =response.data.purchase_offer_list.vehicle_year;
                    this.form.vehicle_type                     =response.data.purchase_offer_list.vehicle_type;
                    this.form.vehicle_license_plate            =response.data.purchase_offer_list.vehicle_license_plate;

                    this.form.vehicle_image                    =response.data.purchase_offer_list.vehicle_image;
                    this.form.vehicle_image_id                 =response.data.purchase_offer_list.vehicle_image_id;
                    this.form.vehicle_insurance_information    =response.data.purchase_offer_list.vehicle_insurance_information;
                    this.form.driver_address                   =response.data.purchase_offer_list.driver_address;
                    this.form.driver_name                      =response.data.purchase_offer_list.driver_name;

                    this.form.driver_id                       =response.data.purchase_offer_list.driver_id;
                    this.form.driver_photo                    =response.data.purchase_offer_list.driver_photo;
                    this.form.driver_license_no               =response.data.purchase_offer_list.driver_license_no;
                    this.form.driver_contact_no               =response.data.purchase_offer_list.driver_contact_no;
                    this.form.product_details_arr             =response.data.charge_details_arr;
                    this.form.total_addition                  =response.data.total_addition;
                    this.form.total_deduction                 =response.data.total_deduction;
                    this.form.subtotal                        =response.data.sub_total;
                    this.form.total_tax                       =response.data.total_tax;
                    this.form.total                           =response.data.grand_total;

                    for(let i=0; i<response.data.purchase_charge_details_arr.length; i++){
                        if(response.data.purchase_charge_details_arr[i].charge_type==1)
                        {
                            this.form.additional_charge_arr.push({
                                'id':response.data.purchase_charge_details_arr[i].id,
                                'reference_id':response.data.purchase_charge_details_arr[i].charge_id,
                                'reference_name':response.data.purchase_charge_details_arr[i].charge_name,
                                'amount':response.data.purchase_charge_details_arr[i].amount,
                            });

                        }
                        else
                        {

                            this.form.deduction_charge_arr.push({
                                'id':response.data.purchase_charge_details_arr[i].id,
                                'reference_id':response.data.purchase_charge_details_arr[i].charge_id,
                                'reference_name':response.data.purchase_charge_details_arr[i].charge_name,
                                'amount':response.data.purchase_charge_details_arr[i].amount,
                            });

                        }
                                                 
                    }

    
                }); 

                this.tempeditmode=false;
            },
            convert_to_purchase_offer(offer_id)
            {
                
                this.setProgressBar(2,10);
                this.petty_cash_page=2;
                //this.form.reset ();
                this.fetchPurchaseOfferAcceptance(offer_id);
            },
         
        
         
           
         

            change_page(page_id)
            {
                this.setProgressBar(page_id,3);
                this.petty_cash_page=page_id;
                this.form.reset ();
                this.rows="";
                this.list_showable=false;

                if(page_id==1)
                {
                    this.fetchPurchaseOffers();
                }

            },

          
            

           
           
            fetchPurchaseOffers()
            {

                let uri = '/pattyCashs';
                window.axios.get(uri).then((response) => {

                    this.coa_arr                                =response.data.coa_arr; 
 
                }); 
              


            },

            setProgressBar(curStep,steps){
                var percent = parseFloat(60 / steps) * curStep;
                this.percent = percent.toFixed();
            },


           

            

            AllEditPurchase(id)
            {
                if(this.petty_cash_page==1)
                {
                    this.editPurchaseOffers(id);
                }
                else if(this.petty_cash_page==2)
                {
                    this.editPurchaseOfferAcceptances(id);
                }
                else if(this.petty_cash_page==3)
                {
                    this.editPurchaseOrders(id);
                }
                
            },
            
            editPurchaseOffers(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchaseOffers/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.editmode=true;
                    
                    this.form.id                                =response.data.purchase_offer_list.id;
                    this.form.unique_no                         =response.data.purchase_offer_list.unique_no;
                    this.form.transaction_no                    =response.data.purchase_offer_list.transaction_no;
                    this.form.posting_status                    =response.data.purchase_offer_list.posting_status;
                    
                    this.form.purchase_offer_no                 =response.data.purchase_offer_list.purchase_offer_no;
                    this.form.purchase_offer_date               =response.data.purchase_offer_list.purchase_offer_date;
                    this.form.purchase_offer_acceptance_no      =response.data.purchase_offer_list.purchase_offer_acceptance_no;
                    this.form.purchase_offer_acceptance_date    =response.data.purchase_offer_list.purchase_offer_acceptance_date;
                    this.form.purchase_order_no                 =response.data.purchase_offer_list.purchase_order_no;
                    this.form.purchase_order_date               =response.data.purchase_offer_list.purchase_order_date;
                    this.form.packing_slip_date                 =response.data.purchase_offer_list.packing_slip_date;
                    this.form.packing_slip_no                   =response.data.purchase_offer_list.packing_slip_no;
                    this.form.purchase_return_no                =response.data.purchase_offer_list.purchase_return_no;
                    this.form.purchase_return_date              =response.data.purchase_offer_list.purchase_return_date;
                    this.form.purchase_credit_note_date         =response.data.purchase_offer_list.purchase_credit_note_date;
                    this.form.purchase_credit_note_no           =response.data.purchase_offer_list.purchase_credit_note_no;
                    this.form.purchase_debit_note_date          =response.data.purchase_offer_list.purchase_debit_note_date;
                    this.form.purchase_debit_note_no            =response.data.purchase_offer_list.purchase_debit_note_no;
                    this.form.purchase_invoice_date             =response.data.purchase_offer_list.purchase_invoice_date;
                    this.form.purchase_invoice_no               =response.data.purchase_offer_list.purchase_invoice_no;

                    this.form.transaction_type                     =response.data.purchase_offer_list.transaction_type;
                    this.form.next_step                         =response.data.purchase_offer_list.next_step;
                    this.form.seller_name                       =response.data.purchase_offer_list.seller_name;
                    this.form.seller_id                         =response.data.purchase_offer_list.seller_id;
                    this.form.seller_account_no                 =response.data.purchase_offer_list.seller_account_no;
                    this.form.seller_photo                      =response.data.purchase_offer_list.seller_photo;
                    this.form.seller_photo_id                   =response.data.purchase_offer_list.seller_photo_id;

                    this.form.seller_address                    =response.data.purchase_offer_list.seller_address;
                    this.form.service_provider_name             =response.data.purchase_offer_list.service_provider_name;
                    this.form.service_provider_id               =response.data.purchase_offer_list.service_provider_id;
                    this.form.service_provider_photo_id         =response.data.purchase_offer_list.service_provider_photo_id;
                    this.form.service_provider_photo            =response.data.purchase_offer_list.service_provider_photo;
                    this.form.service_provider_account_no       =response.data.purchase_offer_list.service_provider_account_no;
                    this.form.service_provider_contact_no       =response.data.purchase_offer_list.service_provider_contact_no;
                    this.form.service_provider_address          =response.data.purchase_offer_list.service_provider_address;
                    this.form.customer_name                     =response.data.purchase_offer_list.customer_name;
                    this.form.customer_id                       =response.data.purchase_offer_list.customer_id;
                    this.form.customer_photo                    =response.data.purchase_offer_list.customer_photo;

                    this.form.customer_account_no               =response.data.purchase_offer_list.customer_account_no;
                    this.form.customer_contact_no               =response.data.purchase_offer_list.customer_contact_no;
                    this.form.customer_address                  =response.data.purchase_offer_list.customer_address;
                    this.form.schedule_delivery_date            =response.data.purchase_offer_list.schedule_delivery_date;
                    this.form.schdule_delivery_time             =response.data.purchase_offer_list.schdule_delivery_time;

                    this.form.delivery_location                 =response.data.purchase_offer_list.delivery_location;
                    this.form.delivery_instruction              =response.data.purchase_offer_list.delivery_instruction;
                    this.form.delivery_contact_person_name      =response.data.purchase_offer_list.delivery_contact_person_name;
                    this.form.delivery_contact_person_email     =response.data.purchase_offer_list.delivery_contact_person_email;
                    this.form.delivery_contact_person_phone     =response.data.purchase_offer_list.delivery_contact_person_phone;

                    this.form.delivery_receive_by               =response.data.purchase_offer_list.delivery_receive_by;
                    this.form.payment_due_date                  =response.data.purchase_offer_list.payment_due_date;
                    this.form.days_left_to_pay                  =response.data.purchase_offer_list.days_left_to_pay;
                    this.form.early_payment_discount            =response.data.purchase_offer_list.early_payment_discount;
                    this.form.payment_method                    =response.data.purchase_offer_list.payment_method;

                   
                    this.form.posted_check_available           =response.data.purchase_offer_list.posted_check_available;
                    this.form.late_payment_pelanty             =response.data.purchase_offer_list.late_payment_pelanty;
                    this.form.hidden_cost                      =response.data.purchase_offer_list.hidden_cost;
                    this.form.shipping_cost_pay_by             =response.data.purchase_offer_list.shipping_cost_pay_by;
                    this.form.payment_status                   =response.data.purchase_offer_list.payment_status;

                    this.form.shipping_company_name            =response.data.purchase_offer_list.shipping_company_name;
                    this.form.shipping_company_id              =response.data.purchase_offer_list.shipping_company_id;
                    this.form.shipping_company_contact         =response.data.purchase_offer_list.shipping_company_contact;
                    this.form.shipping_company_address         =response.data.purchase_offer_list.shipping_company_address;
                    this.form.shipping_company_account_no      =response.data.purchase_offer_list.shipping_company_account_no;

                    this.form.shipping_company_logo            =response.data.purchase_offer_list.shipping_company_logo;
                    this.form.notification_by                  =response.data.purchase_offer_list.notification_by;
                    this.form.backorder_allowed                =response.data.purchase_offer_list.backorder_allowed;
                    this.form.approval_status                  =response.data.purchase_offer_list.approval_status;
                    this.form.transaction_date                    =response.data.purchase_offer_list.transaction_date;
                    this.form.transaction_time                    =response.data.purchase_offer_list.transaction_time;
                    this.form.approve_by                       =response.data.purchase_offer_list.approve_by;
                    this.form.vehicle_identification_number    =response.data.purchase_offer_list.vehicle_identification_number;

                    this.form.vehicle_make                     =response.data.purchase_offer_list.vehicle_make;
                    this.form.vehicle_model                    =response.data.purchase_offer_list.vehicle_model;
                    this.form.vehicle_year                     =response.data.purchase_offer_list.vehicle_year;
                    this.form.vehicle_type                     =response.data.purchase_offer_list.vehicle_type;
                    this.form.vehicle_license_plate            =response.data.purchase_offer_list.vehicle_license_plate;

                    this.form.vehicle_image                    =response.data.purchase_offer_list.vehicle_image;
                    this.form.vehicle_image_id                 =response.data.purchase_offer_list.vehicle_image_id;
                    this.form.vehicle_insurance_information    =response.data.purchase_offer_list.vehicle_insurance_information;
                    this.form.driver_address                   =response.data.purchase_offer_list.driver_address;
                    this.form.driver_name                      =response.data.purchase_offer_list.driver_name;

                    this.form.driver_id                       =response.data.purchase_offer_list.driver_id;
                    this.form.driver_photo                    =response.data.purchase_offer_list.driver_photo;
                    this.form.driver_license_no               =response.data.purchase_offer_list.driver_license_no;
                    this.form.driver_contact_no               =response.data.purchase_offer_list.driver_contact_no;
                    this.form.product_details_arr             =response.data.charge_details_arr;
                    this.form.total_addition                  =response.data.total_addition;
                    this.form.total_deduction                 =response.data.total_deduction;
                    this.form.subtotal                        =response.data.sub_total;
                    this.form.total_tax                       =response.data.total_tax;
                    this.form.total                           =response.data.grand_total;

                    for(let i=0; i<response.data.purchase_charge_details_arr.length; i++){
                        if(response.data.purchase_charge_details_arr[i].charge_type==1)
                        {
                            this.form.additional_charge_arr.push({
                                'id':response.data.purchase_charge_details_arr[i].id,
                                'reference_id':response.data.purchase_charge_details_arr[i].charge_id,
                                'reference_name':response.data.purchase_charge_details_arr[i].charge_name,
                                'amount':response.data.purchase_charge_details_arr[i].amount,
                            });

                        }
                        else
                        {

                            this.form.deduction_charge_arr.push({
                                'id':response.data.purchase_charge_details_arr[i].id,
                                'reference_id':response.data.purchase_charge_details_arr[i].charge_id,
                                'reference_name':response.data.purchase_charge_details_arr[i].charge_name,
                                'amount':response.data.purchase_charge_details_arr[i].amount,
                            });

                        }
                                                 
                    }

    
                }); 

                this.tempeditmode=false;
                //alert(this.form.next_step)
                
            },
            editPurchaseOfferAcceptances(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchaseOfferAcceptances/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.editmode=true;
                    
                    this.form.id                                =response.data.purchase_offer_list.id;
                    this.form.unique_no                         =response.data.purchase_offer_list.unique_no;
                    this.form.transaction_no                    =response.data.purchase_offer_list.transaction_no;
                    this.form.posting_status                    =response.data.purchase_offer_list.posting_status;

                    this.form.purchase_offer_no                 =response.data.purchase_offer_list.purchase_offer_no;
                    this.form.purchase_offer_date               =response.data.purchase_offer_list.purchase_offer_date;
                    this.form.purchase_offer_acceptance_no      =response.data.purchase_offer_list.purchase_offer_acceptance_no;
                    this.form.purchase_offer_acceptance_date    =response.data.purchase_offer_list.purchase_offer_acceptance_date;
                    this.form.purchase_order_no                 =response.data.purchase_offer_list.purchase_order_no;
                    this.form.purchase_order_date               =response.data.purchase_offer_list.purchase_order_date;
                    this.form.packing_slip_date                 =response.data.purchase_offer_list.packing_slip_date;
                    this.form.packing_slip_no                   =response.data.purchase_offer_list.packing_slip_no;
                    this.form.purchase_return_no                =response.data.purchase_offer_list.purchase_return_no;
                    this.form.purchase_return_date              =response.data.purchase_offer_list.purchase_return_date;
                    this.form.purchase_credit_note_date         =response.data.purchase_offer_list.purchase_credit_note_date;
                    this.form.purchase_credit_note_no           =response.data.purchase_offer_list.purchase_credit_note_no;
                    this.form.purchase_debit_note_date          =response.data.purchase_offer_list.purchase_debit_note_date;
                    this.form.purchase_debit_note_no            =response.data.purchase_offer_list.purchase_debit_note_no;
                    this.form.purchase_invoice_date             =response.data.purchase_offer_list.purchase_invoice_date;
                    this.form.purchase_invoice_no               =response.data.purchase_offer_list.purchase_invoice_no;

                    this.form.transaction_type                     =response.data.purchase_offer_list.transaction_type;
                    this.form.next_step                         =response.data.purchase_offer_list.next_step;
                    this.form.seller_name                       =response.data.purchase_offer_list.seller_name;
                    this.form.seller_id                         =response.data.purchase_offer_list.seller_id;
                    this.form.seller_account_no                 =response.data.purchase_offer_list.seller_account_no;
                    this.form.seller_photo                      =response.data.purchase_offer_list.seller_photo;
                    this.form.seller_photo_id                   =response.data.purchase_offer_list.seller_photo_id;

                    this.form.seller_address                    =response.data.purchase_offer_list.seller_address;
                    this.form.service_provider_name             =response.data.purchase_offer_list.service_provider_name;
                    this.form.service_provider_id               =response.data.purchase_offer_list.service_provider_id;
                    this.form.service_provider_photo_id         =response.data.purchase_offer_list.service_provider_photo_id;
                    this.form.service_provider_photo            =response.data.purchase_offer_list.service_provider_photo;
                    this.form.service_provider_account_no       =response.data.purchase_offer_list.service_provider_account_no;
                    this.form.service_provider_contact_no       =response.data.purchase_offer_list.service_provider_contact_no;
                    this.form.service_provider_address          =response.data.purchase_offer_list.service_provider_address;
                    this.form.customer_name                     =response.data.purchase_offer_list.customer_name;
                    this.form.customer_id                       =response.data.purchase_offer_list.customer_id;
                    this.form.customer_photo                    =response.data.purchase_offer_list.customer_photo;

                    this.form.customer_account_no               =response.data.purchase_offer_list.customer_account_no;
                    this.form.customer_contact_no               =response.data.purchase_offer_list.customer_contact_no;
                    this.form.customer_address                  =response.data.purchase_offer_list.customer_address;
                    this.form.schedule_delivery_date            =response.data.purchase_offer_list.schedule_delivery_date;
                    this.form.schdule_delivery_time             =response.data.purchase_offer_list.schdule_delivery_time;

                    this.form.delivery_location                 =response.data.purchase_offer_list.delivery_location;
                    this.form.delivery_instruction              =response.data.purchase_offer_list.delivery_instruction;
                    this.form.delivery_contact_person_name      =response.data.purchase_offer_list.delivery_contact_person_name;
                    this.form.delivery_contact_person_email     =response.data.purchase_offer_list.delivery_contact_person_email;
                    this.form.delivery_contact_person_phone     =response.data.purchase_offer_list.delivery_contact_person_phone;

                    this.form.delivery_receive_by               =response.data.purchase_offer_list.delivery_receive_by;
                    this.form.payment_due_date                  =response.data.purchase_offer_list.payment_due_date;
                    this.form.days_left_to_pay                  =response.data.purchase_offer_list.days_left_to_pay;
                    this.form.early_payment_discount            =response.data.purchase_offer_list.early_payment_discount;
                    this.form.payment_method                    =response.data.purchase_offer_list.payment_method;

                   
                    this.form.posted_check_available           =response.data.purchase_offer_list.posted_check_available;
                    this.form.late_payment_pelanty             =response.data.purchase_offer_list.late_payment_pelanty;
                    this.form.hidden_cost                      =response.data.purchase_offer_list.hidden_cost;
                    this.form.shipping_cost_pay_by             =response.data.purchase_offer_list.shipping_cost_pay_by;
                    this.form.payment_status                   =response.data.purchase_offer_list.payment_status;

                    this.form.shipping_company_name            =response.data.purchase_offer_list.shipping_company_name;
                    this.form.shipping_company_id              =response.data.purchase_offer_list.shipping_company_id;
                    this.form.shipping_company_contact         =response.data.purchase_offer_list.shipping_company_contact;
                    this.form.shipping_company_address         =response.data.purchase_offer_list.shipping_company_address;
                    this.form.shipping_company_account_no      =response.data.purchase_offer_list.shipping_company_account_no;

                    this.form.shipping_company_logo            =response.data.purchase_offer_list.shipping_company_logo;
                    this.form.notification_by                  =response.data.purchase_offer_list.notification_by;
                    this.form.backorder_allowed                =response.data.purchase_offer_list.backorder_allowed;
                    this.form.approval_status                  =response.data.purchase_offer_list.approval_status;
                    this.form.transaction_date                     =response.data.purchase_offer_list.transaction_date;
                    this.form.transaction_time                     =response.data.purchase_offer_list.transaction_time;
                    this.form.approve_by                        =response.data.purchase_offer_list.approve_by;
                    this.form.vehicle_identification_number    =response.data.purchase_offer_list.vehicle_identification_number;

                    this.form.vehicle_make                     =response.data.purchase_offer_list.vehicle_make;
                    this.form.vehicle_model                    =response.data.purchase_offer_list.vehicle_model;
                    this.form.vehicle_year                     =response.data.purchase_offer_list.vehicle_year;
                    this.form.vehicle_type                     =response.data.purchase_offer_list.vehicle_type;
                    this.form.vehicle_license_plate            =response.data.purchase_offer_list.vehicle_license_plate;

                    this.form.vehicle_image                    =response.data.purchase_offer_list.vehicle_image;
                    this.form.vehicle_image_id                 =response.data.purchase_offer_list.vehicle_image_id;
                    this.form.vehicle_insurance_information    =response.data.purchase_offer_list.vehicle_insurance_information;
                    this.form.driver_address                   =response.data.purchase_offer_list.driver_address;
                    this.form.driver_name                      =response.data.purchase_offer_list.driver_name;

                    this.form.driver_id                       =response.data.purchase_offer_list.driver_id;
                    this.form.driver_photo                    =response.data.purchase_offer_list.driver_photo;
                    this.form.driver_license_no               =response.data.purchase_offer_list.driver_license_no;
                    this.form.driver_contact_no               =response.data.purchase_offer_list.driver_contact_no;
                    this.form.product_details_arr             =response.data.charge_details_arr;
                    this.form.total_addition                  =response.data.total_addition;
                    this.form.total_deduction                 =response.data.total_deduction;
                    this.form.subtotal                        =response.data.sub_total;
                    this.form.total_tax                       =response.data.total_tax;
                    this.form.total                           =response.data.grand_total;

                    for(let i=0; i<response.data.purchase_charge_details_arr.length; i++){
                        if(response.data.purchase_charge_details_arr[i].charge_type==1)
                        {
                            this.form.additional_charge_arr.push({
                                'id':response.data.purchase_charge_details_arr[i].id,
                                'reference_id':response.data.purchase_charge_details_arr[i].charge_id,
                                'reference_name':response.data.purchase_charge_details_arr[i].charge_name,
                                'amount':response.data.purchase_charge_details_arr[i].amount,
                            });

                        }
                        else
                        {

                            this.form.deduction_charge_arr.push({
                                'id':response.data.purchase_charge_details_arr[i].id,
                                'reference_id':response.data.purchase_charge_details_arr[i].charge_id,
                                'reference_name':response.data.purchase_charge_details_arr[i].charge_name,
                                'amount':response.data.purchase_charge_details_arr[i].amount,
                            });

                        }
                                                 
                    }

    
                }); 

                this.tempeditmode=false;
                //alert(this.form.next_step)
                
            },
           

       

            
            reset_form()
            {

                this.form.reset();
                this.editmode=false;
                this.list_showable=false;
                this.fetchPurchaseOffers();
                this.setProgressBar(1,10);
            },

            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/PurchaseOfferList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.purchase_offer_list;
                });
                this.list_showable=true;
            },
            reset_offer_acceptance_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/PurchaseOfferAcceptanceList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.purchase_offer_list;
                });
                this.list_showable=true;
            },
            reset_order_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/PurchaseOrderList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.purchase_offer_list;
                });
                this.list_showable=true;
            },
          

            
            PurchaseOffersDelete(id)
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
                    this.form.delete('/PurchaseOffers/'+id).then(()=>{
                        
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
                    this.form.post('/PurchaseOfferPost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            Swal(
                                'Posted!',
                                'Your Data has been Posted.',
                                'success'
                            );

                            if(this.petty_cash_page==1)
                            {
                                this.editPurchaseOffers(response_data[1]);
                            }
                            else if(this.petty_cash_page==2)
                            {
                                this.editPurchaseOfferAcceptances(response_data[1]);
                            }
                            else if(this.petty_cash_page==3)
                            {
                                this.editPurchaseOrders(response_data[1]);
                            }
                            else if(this.petty_cash_page==4)
                            {
                                this.editPurchasePackingSlips(response_data[1]);
                            }
                            else if(this.petty_cash_page==5)
                            {
                                this.editPurchaseReturns(response_data[1]);
                            }
                            else if(this.petty_cash_page==8)
                            {
                                this.editPurchaseInvoices(response_data[1]);
                            }
                            else if(this.petty_cash_page==9)
                            {
                                this.editDirectPayments(response_data[1]);
                            }
                            
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
                    this.form.post('/PurchaseOfferRepost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            Swal(
                                'Posted!',
                                'Your Data has been Reposted.',
                                'success'
                            );
                            if(this.petty_cash_page==1)
                            {
                                this.editPurchaseOffers(response_data[1]);
                            }
                            else if(this.petty_cash_page==2)
                            {
                                this.editPurchaseOfferAcceptances(response_data[1]);
                            }
                            else if(this.petty_cash_page==3)
                            {
                                this.editPurchaseOrders(response_data[1]);
                            }
                          
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
                
            },
    
            deletePurchaseOffers()
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
                    this.form.delete('/PurchaseOffers/'+this.form.id).then(()=>{
                        
                        if(result.value) {
                            Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.fetchPurchaseOffersProfile();
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
            },
      
            updatePurchase(type)
            { 
                if(type==2) this.form.posting_status=1;
                else        this.form.posting_status=0;

                if(this.petty_cash_page==1)
                {
                    this.updatePurchaseOffers();
                }
                else if(this.petty_cash_page==2)
                {
                    this.updatePurchaseOfferAcceptances();
                }
                else if(this.petty_cash_page==3)
                {
                    this.updatePurchaseOrders();
                }
              
            },
            updatePurchaseOffers()
            { 
                

                 this.form.put('/PurchaseOffers/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        
                        this.editPurchaseOffers(response_data[1]);
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
            updatePurchaseOfferAcceptances()
            { 
                
                 this.form.put('/PurchaseOfferAcceptances/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        
                        this.editPurchaseOfferAcceptances(response_data[1]);
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
            updatePurchaseOrders()
            { 
                
                 this.form.put('/PurchaseOrders/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        this.editPurchaseOrders(response_data[1]);
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
                
                 this.form.post('/adjustPurchaseOffer/'+this.form.id).then((response)=>{
                    var response_data=response.data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });
                        
                        if(this.petty_cash_page==1)
                        {
                            this.editPurchaseOffers(response_data[1]);
                        }
                        else if(this.petty_cash_page==2)
                        {
                            this.editPurchaseOfferAcceptances(response_data[1]);
                        }
                        else if(this.petty_cash_page==3)
                        {
                            this.editPurchaseOrders(response_data[1]);
                        }
                       
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
            
            createPurchase(){
                
                if(this.petty_cash_page==1)
                {
                    let uri="/PurchaseOffers";
                    this.form.post(uri) .then(({ data }) => { 
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Save Successfully'
                            });

                           
                            this.editPurchaseOffers(response_data[1]);
                            this.editmode=true;
                            
                        }
                        else{

                            toast({
                                type: 'danger',
                                title: 'Invalid Operation'
                            });
                        }                    
                    })
                }
                else if(this.petty_cash_page==2)
                {
                    let uri="/PurchaseOfferAcceptances";
                    this.form.post(uri) .then(({ data }) => { 
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Save Successfully'
                            });

                            
                            this.editPurchaseOfferAcceptances(response_data[1]);
                            this.editmode=true;
                            
                        }
                        else{

                            toast({
                                type: 'danger',
                                title: 'Invalid Operation'
                            });
                        }                    
                    })
                }
                else if(this.petty_cash_page==3)
                {
                    let uri="/PurchaseOrders";
                    this.form.post(uri) .then(({ data }) => { 
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Save Successfully'
                            });

                            
                            this.editPurchaseOrders(response_data[1]);
                            this.editmode=true;
                            
                        }
                        else{

                            toast({
                                type: 'danger',
                                title: 'Invalid Operation'
                            });
                        }                    
                    })
                }
               
            },            
        }
    
    }  
    
</script>