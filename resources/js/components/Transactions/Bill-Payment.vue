<template>
    <fieldset>
        <div class="form-card" style="padding:0">
            <h1 class="page-head">Bill Payment</h1>
            
        </div>

        <div v-if="petty_cash_page==1">
            <form id="msform" @submit.prevent="editmode ? updatePettyCash(1) : createPettyCash()" @keydown="form.onKeydown($event)">
                <div class="form-card" style="padding:0"> 
                    <div class="text-center">



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
                                    <td>{{ row.unique_no }}</td>
                                    <td>{{ row.transaction_no }}</td>
                                    <td>{{ row.transaction_date }}</td>
                                    <td>{{ row.petty_cash_holder_name }}</td>
                                    <td>{{ row.amount }}</td>
                                    <td>{{ row.payment_method_string }}</td>
                                    <td>{{ row.cheque_no }}</td>
                                    <td>{{ row.cheque_date }}</td>
                                    <td>{{ row.cheque_amount }}</td>
                                    <td width="120">
                                        <button class="btn btn-primary btn-sm"  @click.prevent="AllEditPettyCash(row.id)">Edit</button>
                                        <button  class="btn btn-danger btn-sm" @click.prevent="PettyCashDelete(row.id)">Delete</button>
                                    </td>
                                </tr>
                            </template>
                        </datatable>
                        <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
                    </div>
                    
                    <div class="form-folder">
                        <h3>
                            <i class="fa fa-hand-point-right"></i>&nbsp;
                                <span >Bill Payment:</span>
                            
                            <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="!general_info_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="general_info_show">Hide</button>
                        </h3>
                        <div class="form-holder" v-show="general_info_show">
                            <div class="row align-self-stretch">
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                        <div class="form-holder">
                                            
                                            <label class="fieldlabels">Trsnaction No:</label>  
                                            
                                            <input v-model="form.transaction_no" 
                                                type="text" 
                                                name="transaction_no" 
                                                placeholder="Auto Generated""
                                                :class="{ 'is-invalid': form.errors.has('transaction_no') }" disabled/>
                                            <has-error :form="form" field="transaction_no"></has-error>
                                    
                                            <label class="fieldlabels">Transaction Type :</label> 
                                            <select v-model="form.transaction_type"
                                                name="transaction_type"
                                                class="custom-select"
                                               
                                                :class="{ 'is-invalid': form.errors.has('transaction_type') }" disabled>
                                                <option  value="">--Select Transaction Type-- </option>
                                                <option  value="1">Purchase </option>
                                                <option  value="2">Sales </option>
                                                <option  value="3">Petty Cash </option>
                                                <option  value="6">Bill Payment</option>
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
                                                :class="{ 'is-invalid': form.errors.has('transaction_date') }"  disabled v-if="form.posting_status>1"></date-picker>
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form.transaction_date"
                                                name="transaction_date"
                                                lang="en"
                                                type="transaction_date"
                                                format="ddd, MMM D, YYYY"
                                                :class="{ 'is-invalid': form.errors.has('transaction_date') }" v-else></date-picker>
                                            <has-error :form="form" field="transaction_date"></has-error>

                                            <label class="fieldlabels">Priority Level :</label> 
                                            <select v-model="form.priority_level"
                                                name="priority_level"
                                                class="custom-select"
                                               
                                                :class="{ 'is-invalid': form.errors.has('priority_level') }" disabled>
                                                <option  value="">--Select Priority Level-- </option>
                                                <option  value="1">Normal </option>
                                                <option  value="2">Mid </option>
                                                <option  value="3">High </option>
                                            </select>
                                            <has-error :form="form" field="priority_level"></has-error>
                                            
                                            
                                            <label class="fieldlabels"> Amount to Pay:</label>
                                            <input v-model="form.amount" 
                                                type="text" 
                                                name="amount" 
                                                @keyup.prevent="distribute_payable_amount()"
                                                placeholder="Type Amount" 
                                                :class="{ 'is-invalid': form.errors.has('amount') }" />
                                            <has-error :form="form" field="amount"></has-error>                           
                                                  
                                        </div> 
                                         
                                    </div>
                                   
                                </div>
                               
                               
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                                    
                                        <div class="form-holder">
                                            <h4>Chart Of Account</h4>
                                            <table class="table table_narrow">
                                                <thead>
                                                    <tr>
                                                        <th> Account Type</th>
                                                        <th> Account Code-Name </th>
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

                                            <label class="fieldlabels">Payment Method:</label>
                                            <div class="form-check-inline">
                                               
                                                <select v-model="form.payment_method"
                                                    name="payment_method[]"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('payment_method') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option v-for="(method,index) in payment_method_arr" :value="index">{{method}}</option>
                                                   
                                                </select>
                                                <has-error :form="form" field="payment_method"></has-error> 
                                            </div> 

                                            


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
                          

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                         <h4>Additional Information</h4>
                                        
                                       <label class="fieldlabels">Project:</label>
                                        <div class="form-check-inline">
                                       
                                            <select v-model="form.project"
                                                name="cicle[]"
                                                @change="distribute_project()"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('project') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                            <has-error :form="form" field="project"></has-error> 
                                        </div>
                                        
                                        <label class="fieldlabels">Posted By:</label>
                                        <input v-model="form.posted_by" 
                                            type="text" 
                                            name="posted_by" 
                                            @dblclick="account_holder_popup()" 
                                            placeholder="Browse" 
                                            :class="{ 'is-invalid': form.errors.has('posted_by') }" />
                                        <has-error :form="form" field="posted_by"></has-error>

                                        <label class="fieldlabels">Posted Date:</label>
                                        <date-picker 
                                            style="width:100%"
                                            v-model="form.posted_date"
                                            name="posted_date"
                                            lang="en"
                                            type="posted_date"
                                            format="ddd, MMM D, YYYY"
                                            :class="{ 'is-invalid': form.errors.has('posted_date') }"></date-picker>
                                        <has-error :form="form" field="posted_date"></has-error>

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

                                        <label class="fieldlabels">Tracker:</label>
                                        <input v-model="form.tracker" 
                                            type="text" 
                                            name="tracker" 
                                            placeholder="Type Tracker" 
                                            :class="{ 'is-invalid': form.errors.has('tracker') }" />
                                        <has-error :form="form" field="tracker"></has-error>

                                        <label class="fieldlabels">Flag:</label>
                                        <div class="form-check-inline">
                                           
                                            <select v-model="form.flag"
                                                name="cicle[]"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('flag') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                            <has-error :form="form" field="flag"></has-error> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                       
                       
                    </div>

                    <div class="form-folder">
                        <h3><i class="fa fa-hand-point-right"></i> Unpaid Bill Details:
                            <button type="button" class="btn btn-primary btn-sm" @click="show_hide_product_info()" v-show="!product_info_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_product_info()" v-show="product_info_show">Hide</button>

                        </h3>

                        <div class="form-holder" v-show="product_info_show" >
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                    <h4>Select Payable Group</h4>
                                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                                            <button   
                                                type="button" 
                                                class="btn  btn-primary" 
                                                style="cursor:pointer;width:200px;border-radius:10px !important;"  
                                                :class="{enable_payable_group : form.payable_group==1}"
                                                @click.prevent="payable_group_change(1)">
                                                Accounts Payable <br/> {{total_account_payable}} <br/> {{total_account_payable}}
                                            </button>
                                            <button   
                                                type="button" 
                                                class="btn  btn-primary" 
                                                style="cursor:pointer;width:200px;border-radius:10px !important;" 
                                                :class="{enable_payable_group : form.payable_group==2}"
                                                @click.prevent="payable_group_change(2)">
                                                Government <br/> {{total_government}} <br/> {{total_government_amount}}
                                            </button>
                                            <button   
                                                type="button" 
                                                class="btn  btn-primary" 
                                                style="cursor:pointer;width:200px;border-radius:10px !important;" 
                                                :class="{enable_payable_group : form.payable_group==3}" 
                                                @click.prevent="payable_group_change(3)">
                                                Petty Cash Report  <br/> {{total_petty_cash}} <br/> {{total_petty_cash_amount}}
                                            </button>
                                            <button   type="button" 
                                                class="btn  btn-primary" 
                                                style="cursor:pointer;width:200px;border-radius:10px !important;" 
                                                :class="{enable_payable_group : form.payable_group==4}" 
                                                @click.prevent="payable_group_change(4)">
                                                Other Payment <br/> {{total_other_amount}} <br/> {{total_other_amount_amount}}
                                            </button>

                                            <button type="button" class="btn btn-primary" style="width:200px;border-radius:10px !important;" >All Payment</button>
                                            
                                        </div>
                                         <h4>Select to pay </h4>

                                         <datatable :columns="bill_columns" :data="bill_rows" :filter-by="filter">
                                            <template slot-scope="{row}">
                                                <tr>
                                                    <td>{{ row.sl }}</td>
                                                    <td>{{ row.document_no }}</td>
                                                    <td>{{ row.document_type }}</td>
                                                    <td>{{ row.payee }}</td>
                                                    <td>{{ row.document_date }}</td>
                                                    <td>{{ row.project_name }}</td>
                                                    <td align="right">{{ row.bill_amount.toFixed(2) }}</td>
                                                    <td align="right">
                                                        <input v-model="row.amount_to_pay" 
                                                            type="text" 
                                                            @keyup.prevent="change_bill_amount(row)" 
                                                            name="report_amount" 
                                                            :disabled="!row.selected"
                                                            placeholder="Type Amount to Pay" 
                                                           />
                                                    </td>
                                                    <td align="right">{{ row.balance.toFixed(2) }}</td>
                                                    <td class="form-check-inline">
                                                        <input type="checkbox" 
                                                            v-bind:id="'selected_row_'+row.sl" 
                                                            name="selected_row[]"

                                                            @click="check_selected_row($event,row)"
                                                            v-model="row.selected" >
                                                    </td>
                                                </tr>
                                            </template>
                                            <template slot="footer" slot-scope="{ bill_rows }">
                                                <tr>
                                                    <td colspan="6">Total</td>
                                                    <td align="right"><strong>{{total_bill_amount.toFixed(2)}}</strong></td>
                                                    <td align="right"><strong>{{total_bill_to_pay_amount.toFixed(2)}}</strong></td>
                                                    <td align="right"><strong>{{total_bill_balance_amount.toFixed(2)}}</strong></td>
                                                    <td></td>
                                                </tr>
                                            </template>
                                        </datatable>
                                      
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

                        <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="updatePettyCash(2)">Save</button>
                                    

                        <button :disabled="form.busy || editmode==false || form.posting_status!=1"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()">Post</button>

                        <button :disabled="form.busy || form.posting_status<2"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="adjust()">Adjust</button>

                        <button :disabled="form.busy || form.posting_status!=3"  type="button" class="btn  btn-primary" style="min-width:110px" @click="repost()">RePost</button>
                                                


                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="postable">Print</button>
                    </div>
                </div>
            </form>
        </div>
        <!--  Model  -->
            <div class="modal fade model-middle" id="accountHolderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
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
                                <th>System No</th>
                                <th>Account Holder Name</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="cursor:pointer" v-for="(emp_data,index) in petty_cash_holder_arr"  @click.prevent="account_holder_popup_close(emp_data)"
                                >
                                <td>{{ index+1}}</td>
                                <td>{{ emp_data.system_no }}</td>
                                <td>{{ emp_data.account_holder_name }}</td>
                            
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

    .enable_payable_group{
        font-size:15px !important;
        font-weight:bold !important;
        background-color:rgb(74,75,146) !important;
        padding:5px !important;
        border:5px solid #b5c2e1;
        border-radius:10px !important;
    }
    .enable_payable_group a {
        color:#fff;
        font-size:15px;
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
                row_data:[],
                form:new Form({
                
                    account_type_arr:[
                        {
                            name:'Bank',
                            account_type:1,
                            details:'',
                            coa_description:'',
                            chart_of_account:'',
                            chart_of_account_id:'',
                        },
                        {
                            account_type:2,
                            name:'Account Payable',
                            chart_of_account:'',
                            coa_description:'',
                            details:'',
                            chart_of_account_id:'',
                        },
                        {
                            account_type:3,
                            name:'Other Account Payable',
                            chart_of_account:'',
                            coa_description:'',
                            details:'',
                            chart_of_account_id:'',
                        }
                    ],
                    payable_group:2,
                    purchase_details_arr:[],
                    transaction_no:'',
                    transaction_type:6,
                    transaction_date:'',
                    priority_level:'',
                    project:'',
                    amount:'',
                    payment_posting_status:'',
                    payment_approval:'',
                    posted_date:'',
                    next_step:0,
                    posted_by:'',
                    posted_by_id:'',
                    posting_status:'',
                    petty_cash_holder_name:'',
                    account_holder_id:'',
                    payment_method:'',
                    cheque_no:'',
                    cheque_date:'',
                    cheque_amount:'',
                    pay_to:'',
                    flag:'',
                    comments:'',
                    page_id:301,
                    id:'',
                    
                }),


                total_account_payable:0,
                total_account_payable_amount:0,
                total_government:0,
                total_government_amount:0,
                total_petty_cash:0,
                total_petty_cash_amount:0,
                total_other_amount:0,
                total_other_amount_amount:0,


                coa_arr:[],
                report_no_arr:[],
                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Unique No', field: 'unique_no' },
                    { label: 'Transaction No', field: 'transaction_no' },
                    { label: 'Transaction date', field: 'transaction_date' },
                    { label: 'Petty Cash Holder Name', field: 'petty_cash_holder_name' },
                    { label: 'Amount', field: 'amount' },
                    { label: 'Payment Method', field: 'payment_method_string' },
                    { label: 'Cheque No', field: 'cheque_no' },
                    { label: 'Cheque Date', field: 'cheque_date' },
                    { label: 'Cheque Amount', field: 'cheque_amount' },
                    { label: 'Action', field: '', sortable: false },
                ],
                bill_columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Doc. No', field: 'document_no' },
                    { label: 'Doc. Type', field: 'document_type' },
                    { label: 'Payee', field: 'payee' },
                    { label: 'Due No', field: 'document_date' },
                    { label: 'Project', field: 'project_name' },
                    { label: 'Amount', field: 'bill_amount' },
                    { label: 'Amount to Pay', field: 'amount_to_pay' },
                    { label: 'Balance', field: 'balance' },
                    { label: 'Select', field: 'selected'},
                ],
              
                bill_rows:[],
                total_bill_amount:0.00,
                total_bill_to_pay_amount:0.00,
                total_bill_balance_amount:0.00,
              
                product_info_show:false,
                rows: [],
                general_info_show:true,
                purchase_summery_show:false,
                property_show:false,
                percent:30,
                payment_method_arr:[],
                petty_cash_holder_arr:[],
                page: 1,
                per_page:15,
                expanded: null
            }
        },
        
        created: function()
        {
            this.user_menu_name = this.$route.name;
            this.fetchBillEntrys();
        },
        
        computed:{

            
            
        },
        methods: {



             
            check_selected_row(e,row){
                if(e.target.checked)
                {
                    
                   
                    row.selected=true;
                    
                    
                }
                else{

                    row.selected=false;
                    row.selected=false;
               }
            },

            change_bill_amount(row){
                row.balance=row.bill_amount*1-row.amount_to_pay*1;
                //this.calculate_bill_change();
                alert("row cange")
            },
            calculate_bill_change()
            {

                let temp_total_payable=0;
                var temp_total_balance=0;
                this.bill_rows.forEach(function(item,index){

                    temp_total_payable+=item.amount_to_pay*1;
                    temp_total_balance+=item.balance*1;
                });

                this.total_bill_to_pay_amount=temp_total_payable;
                this.total_bill_balance_amount=temp_total_balance;
            },


            payable_group_change(type)
            {
                this.form.payable_group=type;
                if(type==3)
                {
                    
                    let uri = '/get_bill_pay_data/'+type;
                        window.axios.get(uri).then((response) => {

                            this.total_bill_amount              =response.data.total_bill_amount; 
                            this.total_bill_balance_amount      =response.data.total_bill_amount; 
                            this.bill_rows                      =response.data.petty_cash_expense_list; 
                        }); 
                }
            },
                        


            distribute_payable_amount()
            {
                var balance=this.form.amount*1;
                if(balance<=0) return;
                
                this.bill_rows.forEach(function(item,index){
                        if(balance>item.bill_amount)
                        {
                            item.balance=0;
                            item.amount_to_pay=item.bill_amount*1;
                            item.selected=true;
                            balance-=item.bill_amount*1;
                            alert(1)
                        }
                        else if(balance==item.bill_amount)
                        {
                            item.balance=0
                            item.amount_to_pay=item.bill_amount*1;
                            item.selected=true;
                            balance-=item.bill_amount*1;
                            alert(2)

                        }
                        else if(balance<item.bill_amount && balance>0)
                        {
                            item.balance=item.bill_amount*1-balance*1;
                            item.amount_to_pay=balance*1;
                            item.selected=true;
                            balance-=item.amount_to_pay*1;
                          alert(3)
                        }
                        else
                        {
                            item.balance=item.bill_amount*1;
                            item.amount_to_pay="";
                            item.selected=false;
                            alert(4)

                        }
                        alert(5)
                        
                    });

                    this.calculate_bill_change();
            },

            add_purchase_row(){

                this.form.purchase_details_arr.push({
                    id:'',
                    purchase_date:'',
                    purchase_no:'',
                    seller_name:'',
                    item_description:'',
                    amount:'',
                    amount_account:'',
                    amount_account_id:'',
                    coa_description:'',
                    tax_rate:'',
                    tax_amount:'',
                    tax_account:'',
                    tax_account_id:'',
                    tax_coa_description:'',
                    paid_amount:'',
                    paid_account:'',
                    paid_account_id:'',
                    paid_coa_description:'',
                    cost_center:this.form.cost_center,
                    project:this.form.project,
                });

            },

            
            

            



            system_no_popup()
            {

                let uri = '/PettyCashList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.petty_cash_list;
                });

                $("#Initial_payment_system_model").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
            },

            show_hide_product_info()
            {
                if(this.product_info_show)
                {
                    this.product_info_show=false;
                }
                else{

                    this.product_info_show=true;
                }
            },
            
            
            /*===================Petty Cash Report End==============================================================*/

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
                    this.form.account_type_arr[this.temp_account_type].coa_description=coa.description;
                    
                    this.form.account_type_arr[this.temp_account_type].details=coa.account_no+"-"+coa.description;
                
                
                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove() ;
                this.temp_account_type="";

            },


           
        

           
            fetchBillEntrys()
            {

                let uri = '/BillEntrys';
                window.axios.get(uri).then((response) => {

                    this.total_petty_cash                    =response.data.total_pettycash; 
                    this.total_petty_cash_amount             =response.data.total_pettycash_amount; 
                }); 

            },

        
            
            editPettyCashInitials(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PettyCashPayments/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.editmode=true;
                    
                    this.form.id                                =response.data.petty_cash_list.id;
                    this.form.unique_no                         =response.data.petty_cash_list.unique_no;
                    this.form.transaction_no                    =response.data.petty_cash_list.transaction_no;
                    this.form.posting_status                    =response.data.petty_cash_list.posting_status;
                    
                    this.form.transaction_date                  =response.data.petty_cash_list.transaction_date;
                    this.form.payment_posting_status            =response.data.petty_cash_list.payment_posting_status;
                    this.form.posting_status                    =response.data.petty_cash_list.posting_status;
                    this.form.cost_center                       =response.data.petty_cash_list.cost_center;
                    this.form.posted_date                       =response.data.petty_cash_list.posted_date;
                    this.form.payment_method                    =response.data.petty_cash_list.payment_method;
                    this.form.payment_approval                  =response.data.petty_cash_list.payment_approval;
                    this.form.amount                            =response.data.petty_cash_list.amount;
                    this.form.tracker                           =response.data.petty_cash_list.tracker;
                    this.form.payment_status                    =response.data.petty_cash_list.payment_status;
                    this.form.posted_by                         =response.data.petty_cash_list.posted_by;
                    this.form.petty_cash_holder_name            =response.data.petty_cash_list.petty_cash_holder_name; 
                    this.form.account_holder_id                 =response.data.account_holder_id;
                    this.form.cheque_no                         =response.data.petty_cash_list.cheque_no;
                    this.form.cheque_date                       =response.data.petty_cash_list.cheque_date;
                    this.form.pay_to                            =response.data.petty_cash_list.pay_to;
                    this.form.cheque_amount                     =response.data.petty_cash_list.cheque_amount;
                    this.form.comments                          =response.data.petty_cash_list.comments;
                    this.form.next_step                         =response.data.petty_cash_list.next_step;
                    this.form.flag                              =response.data.petty_cash_list.flag;
                    
                    this.form.account_type_arr.forEach(function(single_account,index1){

                        if(single_account.account_type==1)
                        {
                            
                          single_account.chart_of_account_id=response.data.petty_cash_list.credit_coa_id;
                          single_account.chart_of_account=response.data.petty_cash_list.credit_coa;
                          single_account.coa_description=response.data.petty_cash_list.credit_coa_description;
                          single_account.details=response.data.petty_cash_list.credit_coa+"-"+response.data.petty_cash_list.credit_coa_description;
                        }
                        else if(single_account.account_type==2)
                        {
                          single_account.chart_of_account_id=response.data.petty_cash_list.debit_coa_id;
                          single_account.chart_of_account=response.data.petty_cash_list.debit_coa;
                          single_account.coa_description=response.data.petty_cash_list.debit_coa_description;
                          single_account.details=response.data.petty_cash_list.debit_coa+"-"+response.data.petty_cash_list.debit_coa_description;
                        }
                        
                    });
                    

                }); 
               

                this.tempeditmode=false;
               
                
            },


           

            
            reset_form()
            {
                this.form.reset();
                this.editmode=false;
                this.list_showable=false;
                this.fetchBillEntrys();

            },

            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/PettyCashList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.petty_cash_list;
                });
                this.list_showable=true;
            },
          
          

            
            PettyCashDelete(id)
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
                    this.form.delete('/PettyCashPayments/'+id).then(()=>{
                        
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

            
    
           
            updatePettyCash(type)
            { 
                if(type==2) this.form.posting_status=1;
                else        this.form.posting_status=0;

                this.form.put('/PettyCashPayments/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                        toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        
                        this.editPettyCashInitials(response_data[1]);
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

                    
                    this.form.post('/PettyCashInitialPost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            Swal(
                                'Posted!',
                                'Your Data has been Posted.',
                                'success'
                            );

                            this.editPettyCashInitials(response_data[1]);
                    
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

                    this.form.post('/PettyCashInitialRepost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            Swal(
                                'Posted!',
                                'Your Data has been Reposted.',
                                'success'
                            );
                            
                            this.editPettyCashInitials(response_data[1]);
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
                
            },

            adjust()
            { 
                
                this.form.post('/adjustPettyCashInitial/'+this.form.id).then((response)=>{
                    var response_data=response.data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });
                        
                        this.editPettyCashInitials(response_data[1]);
                        
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
            
            createPettyCash(){
                
                
                let uri="/PettyCashPayments";
                this.form.post(uri) .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                        toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });

                       
                        this.editPettyCashInitials(response_data[1]);
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
        }
    
    }  
    
</script>