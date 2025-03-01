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
                                    <p>Initial Payment</p>
                                </a>
                               </span> </strong>
                            </li>
                            <li :class="{ active: petty_cash_page>=2 }">
                                <strong>2/10<br>
                                    <span>                                    
                                    <a href="javascript:void(0)" @click="change_page(2)" class="router-link ">
                                        <p> New Petty Cash Report</p>
                                        
                                    </a>
                                   </span> 
                               </strong>
                            </li>
                           <!--- router-link-active -->
                            <li :class="{ active: petty_cash_page>=3 }"> <strong>3/10<br><span>                                    
                                <a href="javascript:void(0)" @click="change_page(3)" class="router-link ">
                                    <p>Reimbursement Payment </p>
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
                                <span >Initial Payment:</span>
                            
                            <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="!general_info_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="general_info_show">Hide</button>
                        </h3>
                        <div class="form-holder" v-show="general_info_show">
                            <div class="row align-self-stretch">
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                            <div class="form-holder">
                                            
                                            <label class="fieldlabels">Unique No:</label>  
                                            <input v-model="form.unique_no" 
                                                type="text" 
                                                name="unique_no" 
                                                placeholder="Auto Generated""
                                                :class="{ 'is-invalid': form.errors.has('unique_no') }" disabled/>
                                            <has-error :form="form" field="unique_no"></has-error>
                                            
                                       
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
                                            <label class="fieldlabels">Petty Cash Holder Name:</label>
                                            <input v-model="form.petty_cash_holder_name" 
                                                type="text" 
                                                name="petty_cash_holder_name" 
                                                @dblclick="account_holder_popup()" 
                                                placeholder="Browse Employee" 
                                                :class="{ 'is-invalid': form.errors.has('petty_cash_holder_name') }" />
                                            <has-error :form="form" field="petty_cash_holder_name"></has-error>
                                            
                                            <label class="fieldlabels"> Amount:</label>
                                            <input v-model="form.amount" 
                                                type="text" 
                                                name="amount" 
                                                placeholder="Type Amount" 
                                                :class="{ 'is-invalid': form.errors.has('amount') }" />
                                            <has-error :form="form" field="amount"></has-error>                                                   
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
                                        </div> 
                                         
                                    </div>
                                   
                                </div>
                               
                               
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                                    
                                        <div class="form-holder">
                                            
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

                                            <label class="fieldlabels">Check No:</label>
                                            <input v-model="form.cheque_no" 
                                                type="text" 
                                                name="cheque_no" 
                                                placeholder="Type Cheque No" 
                                                :class="{ 'is-invalid': form.errors.has('cheque_no') }" /> 

                                            <label class="fieldlabels">Cheque Date:</label>
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form.cheque_date"
                                                name="cheque_date"
                                                lang="en"
                                                type="cheque_date"
                                                format="ddd, MMM D, YYYY"
                                                :class="{ 'is-invalid': form.errors.has('cheque_date') }"></date-picker>
                                            <has-error :form="form" field="cheque_date"></has-error>

                                            <label class="fieldlabels">Cheque Amount:</label>
                                            <input v-model="form.cheque_amount" 
                                                type="text" 
                                                name="cheque_amount" 
                                                placeholder="Type Cheque Amount" 
                                                :class="{ 'is-invalid': form.errors.has('cheque_amount') }" />
                                            <has-error :form="form" field="cheque_amount"></has-error>

                                            <label class="fieldlabels">Pay To:</label>
                                            <input v-model="form.pay_to" 
                                                type="text" 
                                                name="pay_to" 
                                                placeholder="Type Pay To" 
                                                :class="{ 'is-invalid': form.errors.has('pay_to') }" />
                                            <has-error :form="form" field="pay_to"></has-error>


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
                                        <label class="fieldlabels">Payment Approval:</label>
                                        <div class="form-check-inline">
                                            <select v-model="form.payment_approval"
                                                name="cicle[]"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('payment_approval') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                            <has-error :form="form" field="payment_approval"></has-error> 
                                        </div>
                                        
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
                                        
                                        <label class="fieldlabels">Posted By:</label>
                                        <input v-model="form.posted_by" 
                                            type="text" 
                                            name="posted_by" 
                                            placeholder="Type Payee Name" 
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
        <div v-else-if="petty_cash_page==2">
            <form id="msform" @submit.prevent="editmode ? updatePettyCashReport(1) : createPettyCash()" @keydown="form1.onKeydown($event)">
                <div class="form-card" style="padding:0"> 
                    <div class="text-center">

                        <button :disabled="form1.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_petty_cash_report_list()"  >List</button>

                        <button :disabled="form1.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="postable">Print</button>

                    </div>
                    <div v-if="list_showable" class="card-body">
                        <div class="pull-left" style="margin-top:50px;">
                            <label for="filter" class="sr-only">Filter</label>
                            <input type="text" class="form-control" v-model="filter" placeholder="Filter" style="width:400px;">
                        </div>
                        <datatable :columns="report_columns" :data="report_rows" :filter-by="filter">
                            <template slot-scope="{row}">
                                <tr>
                                    <td>{{ row.sl }}</td>
                                    <td>{{ row.unique_no }}</td>
                                    <td>{{ row.transaction_no }}</td>
                                    <td>{{ row.transaction_date }}</td>
                                    <td>{{ row.petty_cash_holder_name }}</td>
                                    <td>{{ row.report_amount }}</td>
                                    <td>{{ row.report_no }}</td>
                                    <td>{{ row.reference_no }}</td>
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
                               
                                <span >Petty Cash Report:</span>
                             
                            <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="!general_info_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="general_info_show">Hide</button>
                        </h3>
                        <div class="form-holder" v-show="general_info_show">
                            <div class="row align-self-stretch">
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                            <div class="form-holder">
                                            
                                            <label class="fieldlabels">Unique No:</label>  
                                            <input v-model="form1.unique_no" 
                                                type="text" 
                                                name="unique_no" 
                                                placeholder="Browse"
                                                @dblclick="system_no_popup()" 
                                                :class="{ 'is-invalid': form.errors.has('unique_no') }" />
                                            <has-error :form="form1" field="unique_no"></has-error>
                                            
                                       
                                            <label class="fieldlabels">Trsnaction No:</label>  
                                            
                                            <input v-model="form.transaction_no" 
                                                type="text" 
                                                name="transaction_no" 
                                                placeholder="Auto Generated""
                                                :class="{ 'is-invalid': form.errors.has('transaction_no') }" disabled/>
                                            <has-error :form="form1" field="transaction_no"></has-error>

                                            <label class="fieldlabels">Transaction Date:</label>
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form1.transaction_date"
                                                name="transaction_date"
                                                lang="en"
                                                type="transaction_date"
                                                format="ddd, MMM D, YYYY"
                                                :class="{ 'is-invalid': form1.errors.has('transaction_date') }"  disabled ></date-picker>
                                            
                                            <has-error :form="form" field="transaction_date"></has-error>

                                            <label class="fieldlabels">Transaction Type :</label> 
                                            <select v-model="form1.transaction_type"
                                                name="transaction_type"
                                                class="custom-select"
                                               
                                                :class="{ 'is-invalid': form.errors.has('transaction_type') }" disabled>
                                                <option  value="">--Select Transaction Type-- </option>
                                                <option  value="1">Purchase </option>
                                                <option  value="2">Sales </option>
                                                <option  value="3">Petty Cash </option>
                                                <option  value="4">Petty Cash Expanses Report</option>
                                            </select>
                                            <has-error :form="form1" field="transaction_type"></has-error>

                                            <label class="fieldlabels">Report No:</label>
                                            <input v-model="form1.report_no" 
                                                type="text" 
                                                name="report_no" 
                                                placeholder="Auto Generated" 
                                                 
                                                :class="{ 'is-invalid': form1.errors.has('report_no') }" />
                                            <has-error :form="form1" field="report_no"></has-error>

                                            <label class="fieldlabels">Report Date:</label>
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form1.report_date"
                                                name="report_date"
                                                lang="en"
                                                type="report_date"
                                                format="ddd, MMM D, YYYY"
                                                :class="{ 'is-invalid': form1.errors.has('report_date') }" ></date-picker>

                                            
                                            <label class="fieldlabels">Report Amount:</label>
                                            <input v-model="form1.report_amount" 
                                                type="text" 
                                                name="report_amount" 
                                                placeholder="Type Report Amount" 
                                                :class="{ 'is-invalid': form1.errors.has('report_amount') }" />
                                            <has-error :form="form" field="report_amount"></has-error> 
                                            
                                            <label class="fieldlabels">Petty Cash Holder Name:</label>
                                            <input v-model="form1.petty_cash_holder_name" 
                                                type="text" 
                                                name="petty_cash_holder_name" 
                                                @dblclick="account_holder_popup()" 
                                                placeholder="Browse Employee" 
                                                :class="{ 'is-invalid': form1.errors.has('petty_cash_holder_name') }" />
                                            <has-error :form="form1" field="petty_cash_holder_name"></has-error>
                                                   
                                        </div> 
                                         
                                    </div>
                                   
                                </div>
                               
                               
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                                    
                                        <div class="form-holder">
                                            <h4>Reimbursement Cheque</h4>
                                           
                                            <label class="fieldlabels">Ref No:</label>
                                            <input v-model="form1.ref_no" 
                                                type="text" 
                                                name="ref_no" 
                                                placeholder="Type Cheque No" 
                                                :class="{ 'is-invalid': form1.errors.has('ref_no') }" /> 

                                            <label class="fieldlabels">Check No:</label>
                                            <input v-model="form1.cheque_no" 
                                                type="text" 
                                                name="cheque_no" 
                                                placeholder="Type Cheque No" 
                                                :class="{ 'is-invalid': form1.errors.has('cheque_no') }" /> 

                                            <label class="fieldlabels">Cheque Date:</label>
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form.cheque_date"
                                                name="cheque_date"
                                                lang="en"
                                                type="cheque_date"
                                                format="ddd, MMM D, YYYY"
                                                :class="{ 'is-invalid': form1.errors.has('cheque_date') }"></date-picker>
                                            <has-error :form="form1" field="cheque_date"></has-error>

                                            <label class="fieldlabels">Cheque Amount:</label>
                                            <input v-model="form1.cheque_amount" 
                                                type="text" 
                                                name="cheque_amount" 
                                                placeholder="Type Cheque Amount" 
                                                :class="{ 'is-invalid': form.errors.has('cheque_amount') }" />
                                            <has-error :form="form1" field="cheque_amount"></has-error>

                                            <label class="fieldlabels">Pay To:</label>
                                            <input v-model="form.pay_to" 
                                                type="text" 
                                                name="pay_to" 
                                                placeholder="Type Pay To" 
                                                :class="{ 'is-invalid': form1.errors.has('pay_to') }" />
                                            <has-error :form="form1" field="pay_to"></has-error>


                                            <label class="fieldlabels">Comments:</label> 
                                            <textarea 
                                                v-model="form1.comments"
                                                    style="height:170px;"
                                                    id="comments" 
                                                    name="comments" 
                                                    rows="6" 
                                                    cols="100"
                                                    placeholder="Type Comments" 
                                                :class="{ 'is-invalid': form1.errors.has('comments') }">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                          

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                         <h4>Additional Information</h4>
                                        <label class="fieldlabels">Payment Approval:</label>
                                        <div class="form-check-inline">
                                            <select v-model="form1.payment_approval"
                                                name="cicle[]"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('payment_approval') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                            <has-error :form="form1" field="payment_approval"></has-error> 
                                        </div>
                                        
                                        <label class="fieldlabels">Multiple Cost Centre:</label>
                                        <div class="form-check-inline">
                                       
                                            <select v-model="form1.multiple_cost_center"
                                                name="cicle[]"
                                                class="custom-select" 
                                                @change="multiple_cost_center()"
                                                :class="{ 'is-invalid': form1.errors.has('multiple_cost_center') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                            <has-error :form="form1" field="multiple_cost_center"></has-error> 
                                        </div>

                                        
                                        <label class="fieldlabels">Cost Centre:</label>
                                        <div class="form-check-inline">
                                       
                                            <select v-model="form1.cost_center"
                                                name="cicle[]"
                                                class="custom-select" 
                                                @change="distribute_cost_center()"
                                                :class="{ 'is-invalid': form1.errors.has('cost_center') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Cost Center A</option>
                                                <option value="2">Cost Center B</option>
                                            </select>
                                            <has-error :form="form1" field="cost_center"></has-error> 
                                        </div>

                                        <label class="fieldlabels">Multiple Project:</label>
                                        <div class="form-check-inline">
                                       
                                            <select v-model="form1.multiple_project"
                                                name="cicle[]"
                                                class="custom-select" 
                                                @change="multiple_project()"
                                                :class="{ 'is-invalid': form1.errors.has('multiple_project') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                            <has-error :form="form1" field="multiple_project"></has-error> 
                                        </div>
                                        <label class="fieldlabels">Project:</label>
                                        <div class="form-check-inline">
                                       
                                            <select v-model="form1.project"
                                                name="cicle[]"
                                                @change="distribute_project()"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form1.errors.has('project') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Project A</option>
                                                <option value="2">Project B</option>
                                            </select>
                                            <has-error :form="form1" field="project"></has-error> 
                                        </div>
                                        
                                        <label class="fieldlabels">Posted By:</label>
                                        <input v-model="form1.posted_by" 
                                            type="text" 
                                            name="posted_by" 
                                            placeholder="Type Payee Name" 
                                            :class="{ 'is-invalid': form1.errors.has('posted_by') }" />
                                        <has-error :form="form1" field="posted_by"></has-error>

                                        <label class="fieldlabels">Posted Date:</label>
                                        <date-picker 
                                            style="width:100%"
                                            v-model="form1.posted_date"
                                            name="posted_date"
                                            lang="en"
                                            type="posted_date"
                                            format="ddd, MMM D, YYYY"
                                            :class="{ 'is-invalid': form1.errors.has('posted_date') }"></date-picker>
                                        <has-error :form="form1" field="posted_date"></has-error>


                                        <label class="fieldlabels">Posting Status:</label>
                                        <div class="form-check-inline">
                                           
                                            <select v-model="form1.payment_posting_status"
                                                name="cicle[]"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form1.errors.has('payment_posting_status') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Saved</option>
                                                <option value="2">Posted</option>
                                                <option value="3">Reposted</option>
                                            </select>
                                            <has-error :form="form1" field="payment_posting_status"></has-error> 
                                        </div>

                                        <label class="fieldlabels">Tracker:</label>
                                        <input v-model="form1.tracker" 
                                            type="text" 
                                            name="tracker" 
                                            placeholder="Type Tracker" 
                                            :class="{ 'is-invalid': form1.errors.has('tracker') }" />
                                        <has-error :form="form1" field="tracker"></has-error>

                                        <label class="fieldlabels">Flag:</label>
                                        <div class="form-check-inline">
                                           
                                            <select v-model="form1.flag"
                                                name="cicle[]"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('flag') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                            <has-error :form="form1" field="flag"></has-error> 
                                        </div>
                                    </div>
                                </div>
                               
                                
                            </div>
                        </div>



                        <div class="form-folder">
                            <h3><i class="fa fa-hand-point-right"></i> Report Details:
                                <button type="button" class="btn btn-primary btn-sm" @click="show_hide_product_info()" v-show="!product_info_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_product_info()" v-show="product_info_show">Hide</button>

                            </h3>

                            <div class="form-holder" v-show="product_info_show" >
                                <div class="row align-self-stretch">
                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                        <div class="form-box-outer" style=" width:100%">
                                            
                                            <table class="table table_narrow">
                                                
                                                <thead>
                                                    <tr>
                                                        <th scope="col" rowspan="2" width="3%" >SL</th>
                                                        
                                                        <th scope="col" colspan="4" width="35%">Purchase Invoice</th>
                                                        <th scope="col"  rowspan="2" width="7%">Amount</th>
                                                        <th scope="col"  rowspan="2" width="7%">Account</th>
                                                        <th scope="col"  rowspan="2" width="7%">Cost Center</th>
                                                        <th scope="col"  rowspan="2" width="7%">Project</th>
                                                        <th scope="col" rowspan="2" width="5%">Tax Rate</th>
                                                        <th scope="col" rowspan="2" width="6%">Taxes</th>
                                                        <th scope="col" rowspan="2" width="6%">Account</th>
                                                        <th scope="col" rowspan="2" width="7%">Paid</th>
                                                        <th scope="col" rowspan="2" width="6%">Account</th>
                                                        <th scope="col" rowspan="2" width="5%">Action</th>
                                                     
                                                    </tr>
                                                    <tr>
                                                        <th scope="col" width="9%">Date</th>
                                                        <th scope="col" width="7%">No</th>
                                                        <th scope="col" width="10%">Seller</th>
                                                        <th scope="col" width="10%">Description</th>
                                                    </tr>
                                                    
                                                </thead>
                                                <tbody >
                                                    <template v-for="(single_purchase,index) in form1.purchase_details_arr">

                                                        <tr >
                                                            <td>{{index+1}}</td>
                                                            <td width="" scope="row" style="">

                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="single_purchase.purchase_date"
                                                                    name="purchase_date[]"
                                                                    lang="en"
                                                                    type="purchase_date"
                                                                    format="ddd, MMM D, YYYY"
                                                                    >
                                                                </date-picker>
                                                            </td>
                                                            <td width="" scope="row" >
                                                                <input v-model="single_purchase.purchase_no" 
                                                                    type="text"
                                                                    name="purchase_no[]" 
                                                                    placeholder="Purchase No" />
                                                            </td>
                                                            <td width="" scope="row" >
                                                                <input v-model="single_purchase.seller_name" 
                                                                    type="text"
                                                                    name="seller_name[]" 
                                                                    placeholder="Seller Name" />
                                                            </td>

                                                            <td width="" scope="row" >
                                                                <input v-model="single_purchase.item_description" 
                                                                    type="text"
                                                                    name="item_description[]" 
                                                                    placeholder="Description" />
                                                            </td>

                                                            <td width="" scope="row" >
                                                                <input v-model="single_purchase.amount" 
                                                                    type="text"
                                                                    class="text-right"
                                                                    @keyup="calculate_amount(single_purchase)"
                                                                    name="item_description[]" 
                                                                    placeholder="Amount" />
                                                            </td>
                                                            <td width="" scope="row" >
                                                                <input v-model="single_purchase.amount_account" 
                                                                    type="text"
                                                                    
                                                                    name="amount_account[]" 
                                                                    @dblclick="chart_of_account_show(single_purchase,1)"
                                                                    placeholder="Browse" readonly/>
                                                            </td>
                                                            <td width="" scope="row" >

                                                                <select v-model="single_purchase.cost_center"
                                                                    name="cicle[]"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form1.errors.has('single_purchase.cost_center') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option value="1">Cost Center A</option>
                                                                     <option value="2">Cost Center B</option>
                                                                </select>
                                                               
                                                            </td>
                                                            <td width="" scope="row" >

                                                                <select v-model="single_purchase.project"
                                                                    name="cicle[]"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form1.errors.has('single_purchase.project') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option value="1">Project A</option>
                                                                    <option value="2">Project B</option>
                                                                </select>
                                                            </td>
                                                            <td width="" scope="row" >
                                                                <input 
                                                                    v-model="single_purchase.tax_rate" 
                                                                    type="text"
                                                                    @keyup="calculate_amount(single_purchase)"
                                                                    name="tax_rate[]" 
                                                                    placeholder="Type Tax Rate" />
                                                            </td>
                                                            <td width="" scope="row">
                                                                <input v-model="single_purchase.tax_amount" 
                                                                    type="text"
                                                                    class="text-right"
                                                                    name="tax_amount[]" 
                                                                    placeholder="Calclutive" readonly/>
                                                            </td>

                                                            <td width="" scope="row" >
                                                                <input v-model="single_purchase.tax_account" 
                                                                    type="text"
                                                                    name="tax_account[]" 
                                                                    @dblclick="chart_of_account_show(single_purchase,2)"
                                                                    placeholder="Browse" readonly/>
                                                            </td>
                                                            
                                                            <td width="" scope="row" >
                                                                <input v-model="single_purchase.paid_amount" 
                                                                    type="text"
                                                                    class="text-right"
                                                                    name="paid_amount[]" 
                                                                    placeholder="Calclutive" readonly/>
                                                            </td>

                                                            <td width="" scope="row" >
                                                                <input v-model="single_purchase.paid_account" 
                                                                    type="text"
                                                                    name="paid_account[]" 
                                                                    @dblclick="chart_of_account_show(single_purchase,3)"
                                                                    placeholder="Browse" readonly/>
                                                            </td>
                                                            <td width="" scope="row" >
                                                                <button type="button" class="btn  btn-primary"  @dblclick="add_purchase_row()">+</button>
                                                                <button  :disabled="index==0" type="button" class="btn  btn-primary"  @dblclick="remove_purchase_row(index)">-</button>
                                                            </td>

                                                        </tr>
                                                                                                           
                                                    </template>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{form1.total_amount}}</td>
                                                        <td></td>
                                                        <td ></td>
                                                        <td class="text-right"></td>
                                                        <td class="text-right"></td>
                                                        <td class="text-right">{{form1.total_tax}}</td>
                                                        <td class="text-right"></td>
                                                        <td class="text-right">
                                                            {{form1.total_paid}}
                                                        </td>
                                                        <td></td> 
                                                        <td></td> 
                                                    </tr>
                                                  </tfoot>
                                            </table> 
                                        </div>
                                    </div> 
                           
                                </div>
                            </div>

                        </div>


                        
                     </div>
                       
                       
                 

                 
                    <div class="text-center" v-if="!list_showable">
                        <button :disabled="form1.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">Refresh </button>

                        <button :disabled="form1.busy || editmode==true || form1.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px" >New</button>

                        <button :disabled="form1.busy || editmode==false || form1.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px" >Edit</button>

                        <button :disabled="form1.busy || editmode==false || form1.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click.prevent="deletePettyCashReport()">Delete</button>

                        <button :disabled="form1.busy || editmode==false || form1.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="updatePettyCashReport(2)">Save</button>
                                    
                        
                        <button :disabled="form1.busy || editmode==false || form1.posting_status!=1"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()">Post</button>

                        <button :disabled="form1.busy || form1.posting_status<2"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="adjust()">Adjust</button>

                        <button :disabled="form1.busy || form1.posting_status!=3"  type="button" class="btn  btn-primary" style="min-width:110px" @click="repost()">RePost</button>
                                                
                     
                        <button :disabled="form1.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                        <button :disabled="form1.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="postable">Print</button>
                    </div>
                </div>
            </form>
        </div>
        <div v-else-if="petty_cash_page==3">
            <form id="msform" @submit.prevent="editmode ? updatePettyCash(1) : createPettyCash()" @keydown="form2.onKeydown($event)">
                <div class="form-card" style="padding:0"> 
                    <div class="text-center">

                        <button :disabled="form2.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_petty_cash_reimbersement_list()" >List</button>                  
                        <button :disabled="form2.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="postable">Print</button>

                    </div>
                    <div v-if="list_showable" class="card-body">
                        <div class="pull-left" style="margin-top:50px;">
                            <label for="filter" class="sr-only">Filter</label>
                            <input type="text" class="form-control" v-model="filter" placeholder="Filter" style="width:400px;">
                        </div>
                        <datatable :columns="reimbersement_columns" :data="rows" :filter-by="filter">
                            <template slot-scope="{row}">
                                <tr>
                                    <td>{{ row.sl }}</td>
                                    <td>{{ row.unique_no }}</td>
                                    <td>{{ row.transaction_no }}</td>
                                    <td>{{ row.transaction_date }}</td>
                                    <td>{{ row.petty_cash_holder_name }}</td>
                                    <td>{{ row.amount }}</td>
                                    <td>{{ row.report_no }}</td>
                                    <td>{{ row.report_date }}</td>
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
                                <span >Reimbursement Payment:</span>
                            
                            <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="!general_info_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="general_info_show">Hide</button>
                        </h3>
                        <div class="form-holder" v-show="general_info_show">
                            <div class="row align-self-stretch">
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                            <div class="form-holder">
                                            
                                            <label class="fieldlabels">Unique No:</label>  
                                            <input v-model="form2.unique_no" 
                                                type="text" 
                                                name="unique_no" 
                                                placeholder="Browse"
                                                @dblclick="system_no_popup()" 
                                                :class="{ 'is-invalid': form2.errors.has('unique_no') }" />
                                            <has-error :form="form2" field="unique_no"></has-error>
                                       
                                            <label class="fieldlabels">Trsnaction No:</label>  
                                            
                                            <input v-model="form2.transaction_no" 
                                                type="text" 
                                                name="transaction_no" 
                                                placeholder="Auto Generated""
                                                :class="{ 'is-invalid': form.errors.has('transaction_no') }" disabled/>
                                            <has-error :form="form2" field="transaction_no"></has-error>
                                    
                                            <label class="fieldlabels">Transaction Type :</label> 
                                            <select v-model="form2.transaction_type"
                                                name="transaction_type"
                                                class="custom-select"
                                               
                                                :class="{ 'is-invalid': form2.errors.has('transaction_type') }" disabled>
                                                <option  value="">--Select Transaction Type-- </option>
                                                <option  value="1">Purchase </option>
                                                <option  value="2">Sales </option>
                                                <option  value="3">Petty Cash </option>
                                                <option  value="4">Petty Cash Expanses Report</option>
                                                <option  value="5">Reimbursement Payment</option>
                                            </select>
                                            <has-error :form="form2" field="transaction_type"></has-error>


                                            <label class="fieldlabels">Transaction Date:</label>
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form2.transaction_date"
                                                name="transaction_date"
                                                lang="en"
                                                type="transaction_date"
                                                format="ddd, MMM D, YYYY"
                                                :class="{ 'is-invalid': form2.errors.has('transaction_date') }"  disabled v-if="form.posting_status>1"></date-picker>
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form2.transaction_date"
                                                name="transaction_date"
                                                lang="en"
                                                type="transaction_date"
                                                format="ddd, MMM D, YYYY"
                                                :class="{ 'is-invalid': form2.errors.has('transaction_date') }" v-else></date-picker>
                                            <has-error :form="form2" field="transaction_date"></has-error>
                                            <label class="fieldlabels">Petty Cash Holder Name:</label>
                                            <input v-model="form2.petty_cash_holder_name" 
                                                type="text" 
                                                name="petty_cash_holder_name" 
                                                @dblclick="account_holder_popup()" 
                                                placeholder="Browse Employee" 
                                                :class="{ 'is-invalid': form2.errors.has('petty_cash_holder_name') }" />
                                            <has-error :form="form2" field="petty_cash_holder_name"></has-error>
                                            
                                           
                                           <label class="fieldlabels">Report No:</label>
                                            <input v-model="form2.report_no" 
                                                type="text" 
                                                name="report_no" 
                                                placeholder="Browse"
                                                @dblclick="report_no_popup()" 
                                                :class="{ 'is-invalid': form2.errors.has('report_no') }" />

                                            <has-error :form="form2" field="report_no"></has-error>
                                            <label class="fieldlabels">Report Date:</label>
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form2.report_date"
                                                name="report_date"
                                                lang="en"
                                                type="report_date"
                                                format="ddd, MMM D, YYYY"
                                                :class="{ 'is-invalid': form2.errors.has('report_date') }" ></date-picker>

                                            
                                            <label class="fieldlabels">Report Amount:</label>
                                            <input v-model="form2.report_amount" 
                                                type="text" 
                                                name="report_amount" 
                                                placeholder="Type Report Amount" 
                                                :class="{ 'is-invalid': form2.errors.has('report_amount') }" />
                                            <has-error :form="form2" field="report_amount"></has-error>                                                   
                                            <h4>Chart Of Account</h4>
                                            <table class="table table_narrow">
                                                <thead>
                                                    <tr>
                                                        <th> Account Type</th>
                                                        <th> Account Code-Name </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(accountType,index) in form2.account_type_arr">
                                                        <td> {{accountType.name}}</td>
                                                        <td> 
                                                            <input v-model="accountType.details" 
                                                                type="text" 
                                                                name="details[]"
                                                                @dblclick="chart_of_account_popup(index)" 
                                                                placeholder="Browse Chart Of Account" 
                                                                :class="{ 'is-invalid': form2.errors.has('details[]') }" readonly/>
                                                            <has-error :form="form2" field="details[]"></has-error>
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>

                                            </table>        
                                        </div> 
                                         
                                    </div>
                                   
                                </div>
                               
                               
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                                    
                                        <div class="form-holder">

                                            <label class="fieldlabels">Check No:</label>
                                            <input v-model="form2.cheque_no" 
                                                type="text" 
                                                name="cheque_no" 
                                                placeholder="Type Cheque No" 
                                                :class="{ 'is-invalid': form2.errors.has('cheque_no') }" /> 

                                            <label class="fieldlabels">Cheque Date:</label>
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form2.cheque_date"
                                                name="cheque_date"
                                                lang="en"
                                                type="cheque_date"
                                                format="ddd, MMM D, YYYY"
                                                :class="{ 'is-invalid': form2.errors.has('cheque_date') }"></date-picker>
                                            <has-error :form="form2" field="cheque_date"></has-error>

                                            <label class="fieldlabels">Cheque Amount:</label>
                                            <input v-model="form2.cheque_amount" 
                                                type="text" 
                                                name="cheque_amount" 
                                                placeholder="Type Cheque Amount" 
                                                :class="{ 'is-invalid': form2.errors.has('cheque_amount') }" />
                                            <has-error :form="form2" field="cheque_amount"></has-error>

                                            <label class="fieldlabels">Pay To:</label>
                                            <input v-model="form2.pay_to" 
                                                type="text" 
                                                name="pay_to" 
                                                placeholder="Type Pay To" 
                                                :class="{ 'is-invalid': form2.errors.has('pay_to') }" />
                                            <has-error :form="form2" field="pay_to"></has-error>


                                            <label class="fieldlabels">Comments:</label> 
                                            <textarea 
                                                v-model="form2.comments"
                                                    style="height:170px;"
                                                    id="comments" 
                                                    name="comments" 
                                                    rows="6" 
                                                    cols="100"
                                                    placeholder="Type Comments" 
                                                :class="{ 'is-invalid': form2.errors.has('comments') }">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                          

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                         <h4>Additional Information</h4>
                                        <label class="fieldlabels">Payment Approval:</label>
                                        <div class="form-check-inline">
                                            <select v-model="form2.payment_approval"
                                                name="cicle[]"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form2.errors.has('payment_approval') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                            <has-error :form="form2" field="payment_approval"></has-error> 
                                        </div>
                                        
                                        <label class="fieldlabels">Cost Centre:</label>
                                        <div class="form-check-inline">
                                       
                                            <select v-model="form2.cost_center"
                                                name="cicle[]"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form2.errors.has('cost_center') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                            <has-error :form="form2" field="cost_center"></has-error> 
                                        </div>
                                        
                                        <label class="fieldlabels">Posted By:</label>
                                        <input v-model="form2.posted_by" 
                                            type="text" 
                                            name="posted_by" 
                                            placeholder="Type Payee Name" 
                                            :class="{ 'is-invalid': form2.errors.has('posted_by') }" />
                                        <has-error :form="form2" field="posted_by"></has-error>

                                        <label class="fieldlabels">Posted Date:</label>
                                        <date-picker 
                                            style="width:100%"
                                            v-model="form2.posted_date"
                                            name="posted_date"
                                            lang="en"
                                            type="posted_date"
                                            format="ddd, MMM D, YYYY"
                                            :class="{ 'is-invalid': form2.errors.has('posted_date') }"></date-picker>
                                        <has-error :form="form2" field="posted_date"></has-error>


                                        <label class="fieldlabels">Posting Status:</label>
                                        <div class="form-check-inline">
                                           
                                            <select v-model="form2.payment_posting_status"
                                                name="cicle[]"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form2.errors.has('payment_posting_status') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Saved</option>
                                                <option value="2">Posted</option>
                                                <option value="3">Reposted</option>
                                            </select>
                                            <has-error :form="form2" field="payment_posting_status"></has-error> 
                                        </div>

                                        <label class="fieldlabels">Tracker:</label>
                                        <input v-model="form2.tracker" 
                                            type="text" 
                                            name="tracker" 
                                            placeholder="Type Tracker" 
                                            :class="{ 'is-invalid': form.errors.has('tracker') }" />
                                        <has-error :form="form2" field="tracker"></has-error>

                                        <label class="fieldlabels">Flag:</label>
                                        <div class="form-check-inline">
                                           
                                            <select v-model="form2.flag"
                                                name="cicle[]"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form2.errors.has('flag') }">
                                                <option disabled value="">--Select-- </option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                            <has-error :form="form2" field="flag"></has-error> 
                                        </div>
                                    </div>
                                </div>
                               
                                
                            </div>
                        </div>
                       
                       
                    </div>

                 
                    <div class="text-center" v-if="!list_showable">
                        <button :disabled="form2.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">Refresh </button>

                        <button :disabled="form2.busy || editmode==true || form2.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px" >New</button>

                        <button :disabled="form2.busy || editmode==false || form2.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px" >Edit</button>

                        <button :disabled="form2.busy || editmode==false || form2.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click.prevent="deletePurchaseOffers()">Delete</button>

                        <button :disabled="form2.busy || editmode==false || form2.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="updatePettyCash(2)">Save</button>
                                    

                        <button :disabled="form2.busy || editmode==false || form2.posting_status!=1"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()">Post</button>

                        <button :disabled="form2.busy || form2.posting_status<2"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="adjust()">Adjust</button>

                        <button :disabled="form2.busy || form2.posting_status!=3"  type="button" class="btn  btn-primary" style="min-width:110px" @click="repost()">RePost</button>
                                                
                        <button :disabled="form2.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                        <button :disabled="form2.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="postable">Print</button>
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

        <!--  Model Initial Payment  -->
            <div class="modal fade model-middle" id="Initial_payment_system_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
              <div class="modal-dialog" role="document" >
                <div class="modal-content" style="width:700px">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Initial Payment System No</h5>
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
                                <th>Unique No</th>
                                <th>Transaction date</th>
                                <th>Petty Cash Holder Name</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="cursor:pointer" v-for="(system_data,index) in rows"  @click.prevent="system_popup_close(system_data)"
                                >
                                <td>{{ index+1}}</td>
                                <td>{{ system_data.unique_no }}</td>
                                <td>{{ system_data.transaction_date }}</td>
                                <td>{{ system_data.petty_cash_holder_name }}</td>
                                <td>{{ system_data.amount }}</td>
                            
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

        <!--  Model Reprot No Popup  -->
            <div class="modal fade model-middle" id="Report_No_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
              <div class="modal-dialog" role="document" >
                <div class="modal-content" style="width:700px">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Initial Payment System No</h5>
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
                                <th>Unique No</th>
                                <th>Transaction No</th>
                                <th>Report No</th>
                                <th>Report Date</th>
                                <th>Report Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="cursor:pointer" v-for="(system_data,index) in report_no_arr"  @click.prevent="report_no_popup_close(system_data)"
                                >
                                <td>{{ index+1}}</td>
                                <td>{{ system_data.unique_no }}</td>
                                <td>{{ system_data.transaction_date }}</td>
                                <td>{{ system_data.report_no }}</td>
                                <td>{{ system_data.report_date }}</td>
                                <td>{{ system_data.report_amount }}</td>
                            
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
                            name:'Petty Cash Holder',
                            chart_of_account:'',
                            coa_description:'',
                            details:'',
                            chart_of_account_id:'',
                        }
                    ],
                    unique_no:'',
                    transaction_no:'',
                    transaction_type:3,
                    transaction_date:'',
                    transaction_time:'',
                    amount:'',
                    payment_posting_status:'',
                    payment_approval:'',
                    posted_date:'',
                    next_step:0,
                    posted_by:'',
                    cost_center:'',
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


                form1:new Form({
                
                    purchase_details_arr:[
                        {
                            id:'',
                            purchase_date:'',
                            purchase_no:'',
                            seller_name:'',
                            item_description:'',
                            amount:'',
                            amount_account:'',
                            amount_account_id:'',
                            coa_description:'',
                            cost_center:'',
                            project:'',
                            tax_rate:'',
                            tax_amount:'',
                            tax_account:'',
                            tax_account_id:'',
                            tax_coa_description:'',
                            paid_amount:'',
                            paid_account:'',
                            paid_account_id:'',
                            paid_coa_description:'',
                        }                       
                    ],
                    unique_no:'',
                    transaction_no:'',
                    transaction_type:4,
                    transaction_date:new Date(),
                    report_no:'',
                    report_date:'',
                    report_amount:'',
                    payment_posting_status:'',
                    payment_approval:'',
                    posted_date:'',
                    next_step:0,
                    posted_by:'',
                    multiple_project:'',
                    multiple_cost_center:'',
                    cost_center:'',
                    project:'',
                    posting_status:'',
                    petty_cash_holder_name:'',
                    account_holder_id:'',
                    payment_method:'',
                    reference_no:'',
                    reference_id:'',
                    cheque_no:'',
                    cheque_date:'',
                    cheque_amount:'',
                    pay_to:'',
                    flag:'',
                    comments:'',
                    page_id:301,
                    id:'',
                    total_amount:0,
                    total_tax:0,
                    total_paid:0,
                }),

                form2:new Form({
                
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
                            name:'Petty Cash Holder',
                            chart_of_account:'',
                            coa_description:'',
                            details:'',
                            chart_of_account_id:'',
                        }
                    ],
                    unique_no:'',
                    transaction_no:'',
                    transaction_type:5,
                    transaction_date:'',
                    transaction_time:'',
                    amount:'',
                    payment_posting_status:'',
                    payment_approval:'',
                    posted_date:'',
                    next_step:0,
                    posted_by:'',
                    cost_center:'',
                    posting_status:'',
                    petty_cash_holder_name:'',
                    account_holder_id:'',
                    cheque_no:'',
                    cheque_date:'',
                    cheque_amount:'',
                    report_no:'',
                    report_date:'',
                    report_amount:'',
                    pay_to:'',
                    flag:'',
                    comments:'',
                    page_id:303,
                    id:'',
                    
                }),


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
                report_columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Unique No', field: 'unique_no' },
                    { label: 'Transaction No', field: 'transaction_no' },
                    { label: 'Transaction date', field: 'transaction_date' },
                    { label: 'Petty Cash Holder Name', field: 'petty_cash_holder_name' },
                    { label: 'Report Amount', field: 'report_amount' },
                    { label: 'Report No', field: 'report_no' },
                    { label: 'Reference No', field: 'reference_no' },
                    { label: 'Cheque No', field: 'cheque_no' },
                    { label: 'Cheque Date', field: 'cheque_date' },
                    { label: 'Cheque Amount', field: 'cheque_amount' },
                    { label: 'Action', field: '', sortable: false },
                ],
                reimbersement_columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Unique No', field: 'unique_no' },
                    { label: 'Transaction No', field: 'transaction_no' },
                    { label: 'Transaction date', field: 'transaction_date' },
                    { label: 'Petty Cash Holder Name', field: 'petty_cash_holder_name' },
                    { label: 'Report Amount', field: 'amount' },
                    { label: 'Report No', field: 'report_no' },
                    { label: 'Reprot Date', field: 'report_date' },
                    { label: 'Cheque No', field: 'cheque_no' },
                    { label: 'Cheque Date', field: 'cheque_date' },
                    { label: 'Cheque Amount', field: 'cheque_amount' },
                    { label: 'Action', field: '', sortable: false },
                ],
              
                product_info_show:false,
                rows: [],
                report_rows:[],
                test_collupsable:false,
                general_info_show:true,
                purchase_summery_show:false,
                product_info_show:false,
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
            this.fetchPettyCashs();
            this.setProgressBar(1,3);

        },
        
        computed:{

            
            
        },
        methods: {
            /*===================Petty Cash Report===========================================*/

            multiple_cost_center()
            {
                if(this.form1.multiple_cost_center==2) this.form1.cost_center="";
                this.distribute_cost_center();
            },

            distribute_cost_center()
            {
                
                let thistemp=this;
                this.form1.purchase_details_arr.forEach(function(item,index){

                        item.cost_center=thistemp.form1.cost_center;
                    });
            },

            multiple_project()
            {
                if(this.form1.multiple_project==2) this.form1.project="";
                this.distribute_project();

            },

            distribute_project()
            {
                let thistemp=this;
                this.form1.purchase_details_arr.forEach(function(item,index){
                        
                        item.project=thistemp.form1.project;
                    });
            },

            add_purchase_row(){

                this.form1.purchase_details_arr.push({
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
                    cost_center:this.form1.cost_center,
                    project:this.form1.project,
                });

            },

            remove_purchase_row(row_id)
            {

                this.form1.purchase_details_arr.splice(row_id,1);
            },
            calculate_amount(row_data)
            {

                var tax_amount=0;
                var amount=row_data.amount? row_data.amount: 0;

                if(row_data.tax_rate>0 && amount>0 )
                {

                    tax_amount=((row_data.tax_rate*amount)/100).toFixed(2);
                    row_data.tax_amount=tax_amount;
                }
                else
                {
                    row_data.tax_amount=0;
                }

                var total_amount=tax_amount*1+amount*1;
                row_data.paid_amount=total_amount;

                this.calculate_total_amount();

            },

            calculate_total_amount()
            {

                let thistemp=this;
                var total_amount=0;
                var total_tax_amount=0;
                var total_paid_amount=0;
                this.form1.purchase_details_arr.forEach(function(item,index){
                        
                        total_amount        += item.amount*1;
                        total_tax_amount    += item.tax_amount*1;
                        total_paid_amount   += item.paid_amount*1;
                        console.log(item.amount);
                    });

                this.form1.total_amount     =total_amount;
                this.form1.total_tax        =total_tax_amount;
                this.form1.total_paid       =total_paid_amount;

                //alert(this.form1.total_paid);return;
            },

            report_no_popup()
            {
                let uri = '/UniqueNoWiseReportList/'+this.form2.unique_no;
                window.axios.get(uri).then((response) => {
                    this.report_no_arr = response.data.petty_cash_list;
                });

                $("#Report_No_model").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
            },
            report_no_popup_close(system_data)
            {
            alert(system_data.report_no);
                this.form2.report_no=system_data.report_no;
                this.form2.report_date=system_data.report_date;
                this.form2.report_amount=system_data.report_amount;
               
                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove();
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
            system_popup_close(system_data)
            {

                if(this.petty_cash_page==2) {
                    this.form1.unique_no=system_data.unique_no;
                    this.form1.account_holder_id=system_data.account_holder_id;
                    this.form1.petty_cash_holder_name=system_data.petty_cash_holder_name;

                }
                else if(this.petty_cash_page==3){ 
                    
                    this.form2.unique_no=system_data.unique_no;
                    this.form2.account_holder_id=system_data.account_holder_id;
                    this.form2.petty_cash_holder_name=system_data.petty_cash_holder_name;

                } 
               
               

                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove();

            },
            chart_of_account_show(row_data,accountTypeId)
            {
                this.temp_account_type=accountTypeId;
                this.row_data=row_data;
                $("#chartOfModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;

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
                if(this.petty_cash_page==1)
                {
                    this.form.account_type_arr[this.temp_account_type].chart_of_account=coa.account_no;
                    this.form.account_type_arr[this.temp_account_type].chart_of_account_id=coa.id;
                    this.form.account_type_arr[this.temp_account_type].coa_description=coa.description;
                    
                    this.form.account_type_arr[this.temp_account_type].details=coa.account_no+"-"+coa.description;
                }
                else if(this.petty_cash_page==2)
                {
                    if(this.temp_account_type==1)
                    {
                        this.row_data.amount_account=coa.account_no;
                        this.row_data.amount_account_id=coa.id;
                        this.row_data.coa_description=coa.description;

                        alert(this.row_data.coa_description+"=="+coa.description)
                    }
                    else if(this.temp_account_type==2)
                    {
                        this.row_data.tax_account=coa.account_no;
                        this.row_data.tax_account_id=coa.id;
                        this.row_data.tax_coa_description=coa.description;
                    }
                    else if(this.temp_account_type==3)
                    {
                        this.row_data.paid_account=coa.account_no;
                        this.row_data.paid_account_id=coa.id;
                        this.row_data.paid_coa_description=coa.description;
                    }

                }
                else if(this.petty_cash_page==3)
                {
                    this.form2.account_type_arr[this.temp_account_type].chart_of_account=coa.account_no;
                    this.form2.account_type_arr[this.temp_account_type].chart_of_account_id=coa.id;
                    this.form2.account_type_arr[this.temp_account_type].coa_description=coa.description;
                    
                    this.form2.account_type_arr[this.temp_account_type].details=coa.account_no+"-"+coa.description;
                }
                
                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove() ;
                this.temp_account_type="";

            },


            account_holder_popup()
            {
                $("#accountHolderModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
            },

            account_holder_popup_close(account_holder)
            {
                this.form.petty_cash_holder_name=account_holder.account_holder_name;
                this.form.account_holder_id=account_holder.id;
              
                
                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove();
                

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
                    this.fetchPettyCashs();
                }

            },


           
            fetchPettyCashs()
            {

                let uri = '/PettyCashPayments';
                window.axios.get(uri).then((response) => {

                    this.coa_arr                                =response.data.coa_arr; 
                    this.payment_method_arr                     =response.data.payment_method_arr; 
                    this.petty_cash_holder_arr                  =response.data.petty_cash_holder_arr; 
                }); 

            },

            setProgressBar(curStep,steps){
                var percent = parseFloat(60 / steps) * curStep;
                this.percent = percent.toFixed();
            },


            AllEditPettyCash(id)
            {
            
                if(this.petty_cash_page==1)
                {
                    this.editPettyCashInitials(id);
                }
                else if(this.petty_cash_page==2)
                {
                    this.editPettyCashReport(id);
                }
                else if(this.petty_cash_page==3)
                {
                    this.editReimbersementPayments(id);
                }
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


            editReimbersementPayments(id)
            {
                this.form2.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/ReimbursementPayments/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.editmode=true;
                   
                    this.form2.id                                =response.data.petty_cash_list.id;
                    this.form2.unique_no                         =response.data.petty_cash_list.unique_no;
                    this.form2.transaction_no                    =response.data.petty_cash_list.transaction_no;
                    this.form2.posting_status                    =response.data.petty_cash_list.posting_status;
                    
                    this.form2.transaction_date                  =response.data.petty_cash_list.transaction_date;
                    this.form2.payment_posting_status            =response.data.petty_cash_list.payment_posting_status;
                    this.form2.posting_status                    =response.data.petty_cash_list.posting_status;
                    this.form2.cost_center                       =response.data.petty_cash_list.cost_center;
                    this.form2.posted_date                       =response.data.petty_cash_list.posted_date;
                    this.form2.payment_approval                  =response.data.petty_cash_list.payment_approval;
                    this.form2.report_amount                     =response.data.petty_cash_list.amount;
                    this.form2.report_no                         =response.data.petty_cash_list.report_no;
                    this.form2.report_date                       =response.data.petty_cash_list.report_date;
                    this.form2.tracker                           =response.data.petty_cash_list.tracker;
                    this.form2.payment_status                    =response.data.petty_cash_list.payment_status;
                    this.form2.posted_by                         =response.data.petty_cash_list.posted_by;
                    this.form2.petty_cash_holder_name            =response.data.petty_cash_list.petty_cash_holder_name; 
                    this.form2.account_holder_id                 =response.data.account_holder_id;
                    this.form2.cheque_no                         =response.data.petty_cash_list.cheque_no;
                    this.form2.cheque_date                       =response.data.petty_cash_list.cheque_date;
                    this.form2.pay_to                            =response.data.petty_cash_list.pay_to;
                    this.form2.cheque_amount                     =response.data.petty_cash_list.cheque_amount;
                    this.form2.comments                          =response.data.petty_cash_list.comments;
                    this.form2.next_step                         =response.data.petty_cash_list.next_step;
                    this.form2.flag                              =response.data.petty_cash_list.flag;
                    
                    this.form2.account_type_arr.forEach(function(single_account,index1){

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
            

            editPettyCashReport(id)
            {
                this.form1.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PettyCashReports/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.editmode=true;
                    
                    this.form1.id                                =response.data.petty_cash_list.id;
                    this.form1.unique_no                         =response.data.petty_cash_list.unique_no;
                    this.form1.transaction_no                    =response.data.petty_cash_list.transaction_no;
                    this.form1.posting_status                    =response.data.petty_cash_list.posting_status;
                    
                    this.form1.transaction_date                  =response.data.petty_cash_list.transaction_date;
                    this.form1.report_no                         =response.data.petty_cash_list.report_no;
                    this.form1.report_date                       =response.data.petty_cash_list.report_date;
                    this.form1.payment_posting_status            =response.data.petty_cash_list.payment_posting_status;
                    this.form1.posting_status                    =response.data.petty_cash_list.posting_status;
                    this.form1.cost_center                       =response.data.petty_cash_list.cost_center;
                    this.form1.posted_date                       =response.data.petty_cash_list.posted_date;
                    this.form1.payment_method                    =response.data.petty_cash_list.payment_method;
                    this.form1.payment_approval                  =response.data.petty_cash_list.payment_approval;
                    this.form1.report_amount                     =response.data.petty_cash_list.report_amount;
                    this.form1.tracker                           =response.data.petty_cash_list.tracker;
                    this.form1.payment_status                    =response.data.petty_cash_list.payment_status;
                    this.form1.posted_by                         =response.data.petty_cash_list.posted_by;
                    this.form1.petty_cash_holder_name            =response.data.petty_cash_list.petty_cash_holder_name; 
                    this.form1.account_holder_id                 =response.data.account_holder_id;
                    this.form1.reference_no                      =response.data.petty_cash_list.reference_no;
                    this.form1.reference_id                      =response.data.petty_cash_list.reference_id;
                    this.form1.cheque_no                         =response.data.petty_cash_list.cheque_no;
                    this.form1.cheque_date                       =response.data.petty_cash_list.cheque_date;
                    this.form1.pay_to                            =response.data.petty_cash_list.pay_to;
                    this.form1.cheque_amount                     =response.data.petty_cash_list.cheque_amount;
                    this.form1.comments                          =response.data.petty_cash_list.comments;
                    this.form1.next_step                         =response.data.petty_cash_list.next_step;
                    this.form1.flag                              =response.data.petty_cash_list.flag;
                   // this.form1.purchase_details_arr            =response.data.petty_cash_expense_list;

                    this.form1.total_amount                     =response.data.total_amount;
                    this.form1.total_tax                        =response.data.total_tax;
                    this.form1.total_paid                       =response.data.total_paid;

                    this.form1.purchase_details_arr.splice(0);
                    for(let i=0; i<response.data.petty_cash_expense_list.length; i++){
                        
                            this.form1.purchase_details_arr.push({
                                'id':response.data.petty_cash_expense_list[i].id,
                                'mst_id':response.data.petty_cash_expense_list[i].mst_id,
                                'purchase_date':response.data.petty_cash_expense_list[i].purchase_date,
                                'purchase_no':response.data.petty_cash_expense_list[i].purchase_no,

                                'seller_name':response.data.petty_cash_expense_list[i].seller_name,
                                'item_description':response.data.petty_cash_expense_list[i].item_description,
                                'amount':response.data.petty_cash_expense_list[i].amount,
                                'amount_account':response.data.petty_cash_expense_list[i].amount_account,
                                'amount_account_id':response.data.petty_cash_expense_list[i].amount_account_id,
                                'coa_description':response.data.petty_cash_expense_list[i].coa_description,

                                'tax_rate':response.data.petty_cash_expense_list[i].tax_rate,
                                'tax_amount':response.data.petty_cash_expense_list[i].tax_amount,
                                'tax_account':response.data.petty_cash_expense_list[i].tax_account,
                                'tax_account_id':response.data.petty_cash_expense_list[i].tax_account_id,
                                'tax_coa_description':response.data.petty_cash_expense_list[i].tax_coa_description,

                                'paid_amount':response.data.petty_cash_expense_list[i].paid_amount,
                                'paid_account':response.data.petty_cash_expense_list[i].paid_account,
                                'paid_account_id':response.data.petty_cash_expense_list[i].paid_account_id,
                                'paid_coa_description':response.data.petty_cash_expense_list[i].paid_coa_description,

                                'cost_center':response.data.petty_cash_expense_list[i].cost_center,

                                'project':response.data.petty_cash_expense_list[i].project,
                                
                            });
                                                                         
                    }

                }); 
               
                this.tempeditmode=false;

              //  setTimeout(this.calculate_total_amount(),30000);
               
                
            },

            
            reset_form()
            {
                this.form.reset();
                this.editmode=false;
                this.list_showable=false;
                this.fetchPettyCashs();
                this.setProgressBar(1,10);
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
            reset_petty_cash_report_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/PettyCashReportList';
                window.axios.get(uri).then((response) => {
                    this.report_rows = response.data.petty_cash_list;
                });
                this.list_showable=true;
            },
            reset_petty_cash_reimbersement_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/ReimbursementPaymentList';
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
                            this.fetchPettyCashsProfile();
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

                if(this.petty_cash_page==1)
                {
                    this.updatePettyCashInitials();
                }
                else if(this.petty_cash_page==2)
                {
                    this.updatePurchaseOfferAcceptances();
                }
                else if(this.petty_cash_page==3)
                {
                    this.updateReimbersementPayments(type);
                }
              
            },

            updatePettyCashReport(type)
            { 
                if(type==2) this.form1.posting_status=1;
                else        this.form1.posting_status=0;

                this.form1.put('/PettyCashReports/'+this.form1.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                        toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        this.editPettyCashReport(response_data[1]);
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

            updatePettyCashInitials()
            { 
                

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

        

            updateReimbersementPayments(type)
            { 
                if(type==2) this.form2.posting_status=1;
                else        this.form2.posting_status=0;

                this.form2.put('/ReimbursementPayments/'+this.form2.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        this.editReimbersementPayments(response_data[1]);
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

                    if(this.petty_cash_page==1)
                    {
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
                    }
                    else if(this.petty_cash_page==2)
                    {
                        
                        this.form1.post('/PettyCashreportPost/'+this.form1.id).then((response)=>{
                            
                            var response_data=response.data.split("**");
                            if(response_data[0]==1)
                            { 
                                Swal(
                                    'Posted!',
                                    'Your Data has been Posted.',
                                    'success'
                                );

                                this.editPettyCashReport(response_data[1]);
                        
                            }            

                        }).catch(()=>{
                            Swal("failed!","there was some wrong","warning");
                        });

                    }
                    else if(this.petty_cash_page==3)
                    {
                        this.form2.post('/ReimbursementPaymentPost/'+this.form2.id).then((response)=>{
                            
                            var response_data=response.data.split("**");
                            if(response_data[0]==1)
                            { 
                                Swal(
                                    'Posted!',
                                    'Your Data has been Posted.',
                                    'success'
                                );

                                this.editReimbersementPayments(response_data[1]);
                        
                            }            

                        }).catch(()=>{
                            Swal("failed!","there was some wrong","warning");
                        });

                    }
               
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

                    if(this.petty_cash_page==1)
                    {

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
                    }
                    else if(this.petty_cash_page==2)
                    {
                         this.form1.post('/PettyCashReportRepost/'+this.form1.id).then((response)=>{
                            
                            var response_data=response.data.split("**");
                            if(response_data[0]==1)
                            { 
                                Swal(
                                    'Posted!',
                                    'Your Data has been Reposted.',
                                    'success'
                                );
                                
                                this.editPettyCashReport(response_data[1]);
                                
                            }            

                        }).catch(()=>{
                            Swal("failed!","there was some wrong","warning");
                        });
                    }
                    else if(this.petty_cash_page==3)
                    {
                        this.form2.post('/ReimbursementPaymentRepost/'+this.form2.id).then((response)=>{
                            
                            var response_data=response.data.split("**");
                            if(response_data[0]==1)
                            { 
                                Swal(
                                    'Posted!',
                                    'Your Data has been Reposted.',
                                    'success'
                                );
                                
                                this.editReimbersementPayments(response_data[1]);
                            }            

                        }).catch(()=>{
                            Swal("failed!","there was some wrong","warning");
                        });
                    }
               
                })
                
            },
            adjust()
            { 
                if(this.petty_cash_page==1)
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
                }
                else if(this.petty_cash_page==2)
                {
                    this.form1.post('/adjustPettyCashReport/'+this.form1.id).then((response)=>{
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        {
                             toast({
                                type: 'success',
                                title: 'Data Update Successfully'
                            });
                            
                            this.editPettyCashReport(response_data[1]);
                           
                            this.editmode=true;
                        }
                        else{

                            toast({
                                type: 'danger',
                                title: 'Invalid Operation'
                            });
                        }
                    });                
                }
                else if(this.petty_cash_page==3)
                {
                    
                    this.form2.post('/adjustReimbursementPayment/'+this.form2.id).then((response)=>{
                            
                            var response_data=response.data.split("**");
                            if(response_data[0]==1)
                            { 
                                toast({
                                    type: 'success',
                                    title: 'Data Update Successfully'
                                });
                                
                                this.editReimbersementPayments(response_data[1]);
                            }            

                        }).catch(()=>{
                            Swal("failed!","there was some wrong","warning");
                        });                
                }
            },
            
            createPettyCash(){
                
                if(this.petty_cash_page==1)
                {
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
                    })
                }
                else if(this.petty_cash_page==2)
                {
                    let uri="/PettyCashReports";
                    this.form1.post(uri) .then(({ data }) => { 
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Save Successfully'
                            });

                            
                            this.editPettyCashReport(response_data[1]);
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
                    let uri="/ReimbursementPayments";
                    this.form2.post(uri) .then(({ data }) => { 
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Save Successfully'
                            });

                            
                            this.editReimbeersementPayments(response_data[1]);
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