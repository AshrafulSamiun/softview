<template>
    <fieldset>
        <h4 class="breadcumb"> Purchase</h4>
            <p class="breadcumb-p">Transaction/Purchase/Purchse Offer</p>
        <div class="form-card" style="padding:0">
           
            <div class="form-folder">
                
                <div class="form-holder pt-0 mt-0" >
                    <div class="card" id="msform">
        
                        <!-- progressbar -->
                        <ul id="progressbar">
                           
                            <li  class="active">
                                <strong>1/10
                                    <span class="first_span">                                    
                                        <a href="javascript:void(0)" @click="change_page(1)" class="router-link ">
                                            <p>Offer({{total_purchase_offer_qty}})</p>
                                        </a>
                                    </span>
                                    <span class="first_span_shadow"></span>
 
                                </strong>
                            </li>
                            <li :class="{ active: purchase_page>=2 }">
                                <strong>2/10<br>
                                    <span class="middle_span">                                    
                                        <a href="javascript:void(0)" @click="change_page(2)" class="router-link ">
                                            <p> Acceptance({{total_purchase_offer_acceptance_qty}})</p>
                                            
                                        </a>
                                    </span> 
                                    <span class="middle_span_shadow"></span>
                               </strong>
                            </li>
                           <!--- router-link-active -->
                            <li :class="{ active: purchase_page>=3 }"> 
                                <strong>3/10<br>
                                    <span class="middle_span">                                    
                                        <a href="javascript:void(0)" @click="change_page(3)" class="router-link ">
                                            <p>PO({{total_purchase_order_qty}})</p>
                                        </a>
                                    </span> 
                                    <span class="middle_span_shadow"></span>
                                </strong>
                            </li>
                            <li :class="{ active: purchase_page>=4 }"> 
                                <strong>4/10<br>
                                    <span class="middle_span">                                    
                                        <a href="javascript:void(0)" @click="change_page(4)" class="router-link ">
                                            <p>Packaing Slip({{total_purchase_packaing_slip_qty}})</p>
                                        </a>
                                    </span> 
                                    <span class="middle_span_shadow"></span>
                                </strong>
                            </li>
                           
                            
                            <li :class="{ active: purchase_page>=5 }"> 
                                <strong>5/10<br>
                                    <span class="middle_span">                                    
                                        <a href="javascript:void(0)" @click="change_page(5)" class="router-link ">
                                            <p>(Return)({{total_purchase_return_qty}})</p>
                                        </a>
                                    </span> 
                                    <span class="middle_span_shadow"></span>
                                </strong>
                            </li>
                             <li :class="{ active: purchase_page>=6 }"> 
                                <strong>6/10<br>
                                    <span class="middle_span">                                    
                                        <a href="javascript:void(0)" @click="change_page(6)" class="router-link ">
                                            <p>(Debit Note)({{total_debit_note_qty}})</p>
                                        </a>
                                    </span> 
                                    <span class="middle_span_shadow"></span>
                                </strong>
                            </li>
                             <li :class="{ active: purchase_page>=7 }"> 
                                <strong>7/10<br>
                                    <span class="middle_span">                                    
                                        <a href="javascript:void(0)" @click="change_page(7)" class="router-link ">
                                            <p>Credit Note({{total_credit_note_qty}})</p>
                                        </a>
                                    </span> 
                                    <span class="middle_span_shadow"></span>
                                </strong>
                            </li>
                            <li :class="{ active: purchase_page>=8 }"> 
                                <strong>8/10<br>
                                    <span class="middle_span">                                    
                                        <a href="javascript:void(0)" @click="change_page(8)" class="router-link ">
                                            <p>Purchase Invice({{total_purchase_invoice_qty}})</p>
                                        </a>
                                    </span> 
                                    <span class="middle_span_shadow"></span>
                                </strong>
                            </li>
                            <li :class="{ active: purchase_page>=9 }"> 
                                <strong>9/10<br>
                                    <span class="middle_span">                                    
                                        <a href="javascript:void(0)" @click="change_page(9)" class="router-link ">
                                            <p>Direct Payment({{total_direct_payment_qty}})</p>
                                        </a>
                                    </span> 
                                    <span class="middle_span_shadow"></span>
                                </strong>
                            </li>
                            <li :class="{ active: purchase_page>=10 }"> 
                                <strong>10/10<br>
                                    <span class="middle_span">                                    
                                        <a href="javascript:void(0)" @click="change_page(10)" class="router-link ">
                                            <p>A/C Statement</p>
                                        </a>
                                    </span> 
                                    <span class="middle_span_shadow"></span>
                                </strong>
                            </li>
                           
                        </ul>
                        


                    </div>
                </div>
            </div>
        </div>

        <div >
            <form id="msform" @submit.prevent="editmode ? updatePurchase(1) : createPurchase()" @keydown="form.onKeydown($event)">
             
                <div class="form-card" style="padding:0"> 
                    <div class="text-center">

                        <button   button :disabled="form.busy"  type="button" class="btn  btn-primary" 
                            style="min-width:110px" 
                            @click="reset_form()">Refresh {{ form.posting_status}} || {{form.posting_status}} ) && {{form.next_step}} && {{purchase_page}}</button>

                        <button :disabled="form.busy || form.unique_no || purchase_page!=8"  type="button" class="btn  btn-primary" v-show=" purchase_page==8" style="min-width:110px" @click="purchase_summery(form.unique_no)">Purchase Summery</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step==0 && purchase_page==1" @click="convert_to_purchase_offer(form.id)">Convert To Offer Acceptance</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step==0 && purchase_page==2" @click="convert_from_offer_acceptance(form.id)">Convert To Order</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step==0 && purchase_page==3" @click="convert_from_order(form.id)">Convert To Packing Slip</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step_return==0 && purchase_page==4" @click="convert_to_return(form.id)">Convert To Return</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step_debit==0 && purchase_page==4" @click="convert_to_debit_note(form.id)">Convert To Debit Note</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step_credit==0 && purchase_page==4" @click="convert_to_credit_note(form.id)">Convert To Credit Note</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step==0 && purchase_page==4" @click="convert_to_invoice(form.id)">Convert To Purchase Invoice</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step!=1 && purchase_page==8" @click="convert_to_direct_payment(form.id)">Convert To Direct Receipt</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step!=1 && purchase_page==9" @click="account_statement(form.id)">Account Statement</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_list()" v-if="purchase_page==1">List</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_offer_acceptance_list()"  v-else-if="purchase_page==2">List</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_order_list()" v-else-if="purchase_page==3">List</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_packaing_list()" v-else-if="purchase_page==4">List</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_return_list()"   v-else-if="purchase_page==5">List</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_debit_list()" v-else-if="purchase_page==6">List</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_credit_list()" v-else-if="purchase_page==7">List</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_invoice_list()" v-else-if="purchase_page==8">List</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_payment_list()" v-else-if="purchase_page==9">List</button>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="postable">Print</button>

                    </div>


                    <div v-if="list_showable" class="card-body">
                        <div class="mb-2">
                            <input type="text" v-model="filter" class="form-control table-filter" placeholder="Search..." style="width:400px;"/>
                        </div>
                        
                        <vue3-datatable :rows="rows" :columns="columns" :search="filter" :sortable="true" rowClass="cursor-pointer" class="whitespace-nowrap">
            
                            <template #sl="data">
                                <strong class="text-info">{{ data.value.sl }}</strong>
                            </template>
                            <template #system_no="data">
                                <span class="font-semibold">{{ data.value.system_no }}</span>
                            </template>
                            <template #transaction_no="data">
                                <span class="font-semibold">{{ data.value.transaction_no }}</span>
                            </template>
                            <template #purchase_type_string="data">
                                <span class="font-semibold">{{ data.value.purchase_type_string }}</span>
                            </template>
                            <template #seller_name="data">
                                <span class="font-semibold">{{ data.value.seller_name }}</span>
                            </template>
                            <template #service_provider_name="data">
                                <span class="font-semibold">{{ data.value.service_provider_name }}</span>
                            </template>
                            <template #customer_name="data">
                                <span class="font-semibold">{{ data.value.customer_name }}</span>
                            </template>
                            <template #approval_status="data">
                                <span class="font-semibold">{{ data.value.approval_status }}</span>
                            </template>
                            <template #schedule_delivery_date="data">
                                <span class="font-semibold">{{ data.value.schedule_delivery_date }}</span>
                            </template>
                            <template #shipping_company="data">
                                <span class="font-semibold">{{ data.value.shipping_company }}</span>
                            </template>
                            <template #driver_name="data">
                                <span class="font-semibold">{{ data.value.driver_name }}</span>
                            </template>
                            
                            <template #buttons="data">
                                <button 
                                    class="btn " 
                                    style="padding:.17rem .25rem" 
                                    @click.prevent="editMeeting(data.value.id)">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </button>
                                <button  
                                    class="btn "
                                    style="padding:.17rem .25rem"
                                    @click.prevent="deleteMeeting(data.value.id)">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                                <button  
                                    class="btn "
                                    style="padding:.17rem .15rem"
                                    @click.prevent="deleteMeeting(data.value.id)">
                                    <span class="glyphicon glyphicon-print"></span>
                                </button> 
                            </template>
                        </vue3-datatable>
                    </div>

                    <div class="form-folder">

                        <h3 class="d-flex justify-content-between align-items-center">
                            
                            <span class="text-uppercase text-white">Purchase Offer:</span>
                                
                            <button 
                                type="button" 
                                class="btn btn-primary btn-sm text-white ms-auto" 
                                @click="show_hide_general_info()" 
                                v-show="!general_info_show">Show</button> 
                            
                            <button 
                                type="button" 
                                class="btn btn-primary btn-sm text-white ms-auto" 
                                @click="show_hide_general_info()" 
                                v-show="general_info_show">Hide</button>
                        </h3>
                        <div class="form-holder" v-show="general_info_show">
                           
                            <div class="row align-self-stretch">
                                <!-- Left Column -->
                                <div class="col-md-6 ">
                                    <div class="form-box-outer ">
                                        <h3>Customer:</h3>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <label class="fieldlabels">Name:</label> 
                                            </div> 
                                            <div class="col-md-9 col-sm-12 col-xs-12">
                                                <input v-model="form.customer_name" 
                                                type="text" 
                                                @click="browse_account_holder_info(4)"
                                                name="customer_name" 
                                                placeholder="Browse" 
                                                :class="{ 'is-invalid': form.errors.has('customer_name') }" readonly/>
                                            </div>
                                        </div> 

                                        <div class="row">
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <label class="fieldlabels">Company Name:</label> 
                                            </div> 
                                            <div class="col-md-6 col-sm-12 col-xs-12">

                                                <input v-model="form.customer_name" 
                                                    type="text" 
                                                    :class="{ 'is-invalid': form.errors.has('customer_name') }" readonly/>
                                            </div>
                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                <img style="border-radius:50% ;" :src="form.customer_photo_path" alt="Photo" width="40" height="40" />
                                            
                                            </div>
                                        </div> 

                                        <div class="row">
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <label class="fieldlabels">Address:</label> 
                                            </div> 
                                            <div class="col-md-9 col-sm-12 col-xs-12 border secondary-subtle rounded">
                                                <div class="row">

                                                    <div class="col-md-2 col-sm-6 col-xs-6">
                                                        <label class="fieldlabels">Number:</label> 
                                                    </div>
                                                    <div class="col-md-4 col-sm-6 col-xs-6">
                                                       {{ }} 
                                                    </div>
                                                    <div class="col-md-2 col-sm-6 col-xs-6">
                                                        <label class="fieldlabels">City:</label> 
                                                    </div>
                                                    <div class="col-md-4 col-sm-6 col-xs-6">
                                                       {{ }} 
                                                    </div>

                                                </div>

                                                
                                            </div>
                                            
                                        </div> 
                                        
                                       
                                       
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Account No</td>
                                                    <td>{{form.customer_account_no}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Contact</td>
                                                    <td>{{form.customer_contact_no}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td>{{form.customer_address}}</td>
                                                </tr>
                                                <tr>
                                                    <td> Photo/ Logo</td>
                                                    <td>{{form.customer_photo}}</td>
                                                </tr>
                                            </tbody>
                                        </table>  
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6 col-md-offset-1">

                                    <div class="form-group">
                                        <label class="form-label">No</label>
                                        <input v-model="form.unique_no" 
                                            type="text" 
                                            name="unique_no" 
                                            placeholder="Auto Generated"
                                            :class="{ 'is-invalid': form.errors.has('unique_no') }" disabled/>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Date</label>
                                        <Vue3datepicker 
                                            style="width:100%"
                                            class="form-control"
                                            v-model="form.transaction_date" 
                                            inputFormat="EE dd, MMM  yyyy"
                                            :class="{ 'is-invalid': form.errors.has('next_meeting_date') }"/>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Expiry Date</label>
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Priority Level</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Invoice Terms</label>
                                        <select v-model="form.early_payment_discount"
                                            name="early_payment_discount"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('early_payment_discount') }">
                                            <option disabled value="">--Select-- </option>
                                            <option value="1">1/10 Net 30</option>
                                            <option value="2">2/10 Net 30</option>
                                            <option value="3">2/15 Net 30</option>
                                            <option value="4">2/30 Net 60</option>
                                            <option value="5">3/10 Net 45</option>
                                            <option value="6">5/10 Net 60</option>
                                            
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Purchase Type</label>
                                        <select v-model="form.purchase_type"
                                                name="purchase_type"
                                                class="custom-select"
                                                @change="change_purchase_type" 
                                                :class="{ 'is-invalid': form.errors.has('purchase_type') }">
                                                <option  value="">--Select Purchase Type-- </option>
                                                <option  value="1">Goods </option>
                                                <option  value="2">Service </option>
                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Payment Method</label>
                                        <select v-model="form.payment_method"
                                            name="payment_method"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('payment_method') }">
                                            <option disabled value="">--Select-- </option>
                                            <option value="1">Credit Cards</option>
                                            <option value="2">Debit Cards</option>
                                            <option value="3">Bank Transfers</option>
                                            <option value="4">Online Banking</option>
                                            <option value="5">Email transfer</option>
                                            <option value="6">Certified Check</option>
                                            <option value="7">Personal Check </option>
                                            <option value="8">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Accepted</label>
                                        <select class="custom-select" >
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Scheduled Delivery Date</label>
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Scheduled Delivery Time</label>
                                        <input type="number" class="form-control" value="500">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Balance</label>
                                        <input type="number" class="form-control" value="500">
                                    </div>
                                </div>
                            </div>
                           



                            <div class="row align-self-stretch m-3">
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    
                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                                    
                                        <h4>Seller:</h4>
                                        <label class="fieldlabels">Name:</label>
                                        <input v-model="form.seller_name" 
                                            type="text" 
                                            @click="browse_account_holder_info(3)"
                                            name="seller_name" 
                                            placeholder="Browse" 
                                            :class="{ 'is-invalid': form.errors.has('seller_name') }" readonly/>

                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td width="35%">
                                                        Account No
                                                    </td>
                                                    <td width="65%">
                                                        {{form.seller_account_no}}
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        Contact
                                                    </td>
                                                    <td>
                                                        {{form.seller_contact_no}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Address
                                                    </td>
                                                    <td>
                                                        {{form.seller_address}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Photo/ Logo
                                                    </td>
                                                    <td>
                                                        {{form.seller_photo}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                                    
                                        <h4>Service Provider:</h4>
                                        <label class="fieldlabels">Name:</label> 
                                        <input v-model="form.service_provider_name" 
                                            type="text" 
                                            @click="browse_account_holder_info(2)"
                                            name="service_provider_name" 
                                            placeholder="Browse" 
                                            :class="{ 'is-invalid': form.errors.has('service_provider_name') }" readonly/>
                                        
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td width="35%">
                                                        Account No
                                                    </td>
                                                    <td width="65%">
                                                        {{form.service_provider_account_no}}
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        Contact
                                                    </td>
                                                    <td>
                                                        {{form.service_provider_contact_no}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Address
                                                    </td>
                                                    <td>
                                                        {{form.service_provider_address}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Photo/ Logo
                                                    </td>
                                                    <td>
                                                        {{form.service_provider_photo}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                                                                    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-holder" v-show="general_info_show">
                            <div class="row align-self-stretch">
                                

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                        <div class="form-holder">
                                            <label class="fieldlabels">Purchase Offer Acceptance Notified by:</label>
                                            <div class="form-check-inline">
                                               
                                               <select v-model="form.notification_by"
                                                   name="cicle[]"
                                                   class="custom-select" 
                                                   :class="{ 'is-invalid': form.errors.has('notification_by') }">
                                                   <option disabled value="">--Select-- </option>
                                                   <option value="1">Phone</option>
                                                   <option value="2">Video Conferencing</option>
                                                   <option value="3">Face-to-Face</option>
                                                   <option value="4">Social Media</option>
                                                   <option value="5">Chat Applications</option>
                                                   <option value="6">Letters</option>
                                                   <option value="7">SMS</option>
                                                   <option value="8">Voice mail</option>
                                                   <option value="9">Others</option>
                                               </select>
                                           </div>
                                           <label class="fieldlabels">Back Order Allowed:</label>
                                            <div class="form-check-inline">
                                               
                                                <select v-model="form.backorder_allowed"
                                                    name="cicle[]"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('backorder_allowed') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                </select>
                                            </div>

                                            <h4>Approval Information:</h4>
                                            <label class="fieldlabels">Approval Status:</label>
                                            <div class="form-check-inline">
                                               
                                                <select v-model="form.approval_status"
                                                    name="cicle[]"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('approval_status') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option value="1">Approved</option>
                                                    <option value="2">Un-approved</option>
                                                </select>
                                            </div>

                                            <label class="fieldlabels">Approve By:</label>
                                             <input v-model="form.approve_by" 
                                                type="text" 
                                                name="approve_by" 
                                                placeholder="Type Approve By" 
                                                :class="{ 'is-invalid': form.errors.has('approve_by') }" />
                                            
                                            <label class="fieldlabels">Approval Date:</label>
                                            <Vue3datepicker 
                                                v-model="form.approval_date" 
                                                inputFormat="EE dd, MMM  yyyy"
                                                :class="{ 'is-invalid': form.errors.has('meeting_date') }"
                                                :enable-time-picker     = "false">
                                            </Vue3datepicker>

                                            <label class="fieldlabels">Approval Time:</label>
                                            <input type="time" v-model="form.approval_time" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                                    
                                        <h4>Documents Tracker:</h4>
                                        <div class="row">
                                            <table class="table  table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td>Purchase Offer No
                                                        </td>
                                                        <td>
                                                            {{form.purchase_offer_no}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Purchase Offer Date
                                                        </td>
                                                        <td>
                                                            {{form.purchase_offer_date}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Purchase Offer Acceptance No
                                                        </td>
                                                        <td>
                                                            {{form.purchase_offer_acceptance_no}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Purchase Offer Acceptance Date
                                                        </td>
                                                        <td>
                                                            {{form.purchase_offer_acceptance_date}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Purchase Order No
                                                        </td>
                                                        <td>
                                                            {{form.purchase_order_no}}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            Purchase Order Date
                                                        </td>
                                                        <td>
                                                            {{form.purchase_order_date}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Packing Slip No
                                                        </td>
                                                        <td>
                                                            {{form.packing_slip_no}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Packing Slip Date
                                                        </td>
                                                        <td>
                                                            {{form.packing_slip_date}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Purchase Invoice No
                                                        </td>
                                                        <td>
                                                            {{form.purchase_invoice_no}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Purchase Invoice Date
                                                        </td>
                                                        <td>
                                                            {{form.purchase_invoice_date}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Purchase Return No
                                                        </td>
                                                        <td>
                                                            {{form.purchase_return_no}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Purchase Return Date
                                                        </td>
                                                        <td>
                                                            {{form.purchase_return_date}}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            Purchase Debit Note No
                                                        </td>
                                                        <td>
                                                            {{form.purchase_debit_note_no}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Purchase Debit Note Date
                                                        </td>
                                                        <td>
                                                            {{form.purchase_debit_note_date}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Purchase Credit Note No
                                                        </td>
                                                        <td>
                                                            {{form.purchase_credit_note_no}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Purchase Credit Note Date
                                                        </td>
                                                        <td>
                                                            {{form.purchase_credit_note_date}}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-holder" v-show="general_info_show">
                            <div class="row align-self-stretch">
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                                    
                                        <h4>Delivery Details:</h4>

                                        <label class="fieldlabels">Scheduled Delivery Date:</label> 
                                        <Vue3datepicker 
                                            v-model                 ="form.schedule_delivery_date" 
                                            inputFormat="EE dd, MMM  yyyy"
                                            :class="{ 'is-invalid': form.errors.has('schedule_delivery_date') }"
                                            :enable-time-picker     = "false">
                                        </Vue3datepicker>  
                                        <label class="fieldlabels">Scheduled Delivery Time:</label> 
                                        <input type="time" v-model="form.schdule_delivery_time" />
                                           
                                        <label class="fieldlabels">Location:</label> 
                                        <input v-model="form.delivery_location" 
                                            type="text" 
                                            name="delivery_location" 
                                            :class="{ 'is-invalid': form.errors.has('delivery_location') }" />
                                                
                                        <label class="fieldlabels">Delivery Instruction:</label> 
                                        <textarea 
                                            v-model="form.delivery_instruction"
                                                style="height:120px;"
                                                id="delivery_instruction" 
                                                name="delivery_instruction" 
                                                rows="6" 
                                                cols="80"
                                                placeholder="Type Delivery Instruction" 
                                                :class="{ 'is-invalid': form.errors.has('delivery_instruction') }">
                                        </textarea>
                                        
                                            
                                        <label class="fieldlabels">Contact Person Name:</label> 
                                        <input v-model="form.delivery_contact_person_name" 
                                            type="text" 
                                            name="delivery_contact_person_name"
                                            :class="{ 'is-invalid': form.errors.has('delivery_contact_person_name') }" />
                                        
                                        
                                        <label class="fieldlabels">Contact Person Email:</label> 
                                                <input v-model="form.delivery_contact_person_email" 
                                                    type="email" 
                                                    name="delivery_contact_person_email"
                                                    :class="{ 'is-invalid': form.errors.has('delivery_contact_person_email') }" />
                                        
                                        
                                        <label class="fieldlabels">Contact Person Phone:</label> 
                                        <input v-model="form.delivery_contact_person_phone" 
                                            type="text" 
                                            name="delivery_contact_person_phone"
                                            :class="{ 'is-invalid': form.errors.has('delivery_contact_person_phone') }" />
                                                                                    
                                        <label class="fieldlabels">Receive By:</label> 
                                        <input v-model="form.delivery_receive_by" 
                                            type="text" 
                                            name="delivery_receive_by"
                                            :class="{ 'is-invalid': form.errors.has('delivery_receive_by') }" />
                                        

                                    </div>
                                </div>
                               
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                                    
                                        <div class="form-holder">
                                            <h4>Payment Details:</h4>
                                            <label class="fieldlabels">Due Date:</label>
                                            <Vue3datepicker 
                                                v-model="form.payment_due_date" 
                                                inputFormat="EE dd, MMM  yyyy"
                                                :class="{ 'is-invalid': form.errors.has('payment_due_date') }"
                                                :enable-time-picker     = "false">
                                            </Vue3datepicker>

                                            <label class="fieldlabels">Days Left to Pay:</label>
                                             <input v-model="form.days_left_to_pay" 
                                                type="number" 
                                                name="days_left_to_pay" 
                                                placeholder="Days Left to Pay" 
                                                :class="{ 'is-invalid': form.errors.has('days_left_to_pay') }" />
                                            

                                            <label class="fieldlabels">Early Payment Discount:</label>
                                            <div class="form-check-inline">
                                               
                                                <select v-model="form.early_payment_discount"
                                                    name="early_payment_discount"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('early_payment_discount') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option value="1">1/10 Net 30</option>
                                                    <option value="2">2/10 Net 30</option>
                                                    <option value="3">2/15 Net 30</option>
                                                    <option value="4">2/30 Net 60</option>
                                                    <option value="5">3/10 Net 45</option>
                                                    <option value="6">5/10 Net 60</option>
                                                   
                                                </select>
                                            </div>

                                            <label class="fieldlabels">Payment Method(s):</label>
                                            <div class="form-check-inline">
                                               
                                                <select v-model="form.payment_method"
                                                    name="cicle[]"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('payment_method') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option value="1">Credit Cards</option>
                                                    <option value="2">Debit Cards</option>
                                                    <option value="3">Bank Transfers</option>
                                                    <option value="4">Online Banking</option>
                                                    <option value="5">Email transfer</option>
                                                    <option value="6">Certified Check</option>
                                                    <option value="7">Personal Check </option>
                                                    <option value="8">Other</option>
                                                </select>
                                            </div>

                                            <label class="fieldlabels">Posted Checks Acceptable:</label>
                                            <div class="form-check-inline">
                                               
                                                <select v-model="form.posted_check_available"
                                                    name="posted_check_available"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('posted_check_available') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                </select>
                                            </div>

                                            <label class="fieldlabels">Late Payment Penalty:</label>
                                             <input v-model="form.late_payment_pelanty" 
                                                type="number" 
                                                name="late_payment_pelanty" 
                                                placeholder="Type Late Payment Penalty" 
                                                :class="{ 'is-invalid': form.errors.has('late_payment_pelanty') }" />

                                            <label class="fieldlabels">Hidden Cost:</label>
                                            <input v-model="form.hidden_cost" 
                                                type="number" 
                                                name="hidden_cost" 
                                                placeholder="Type Hidden Cost" 
                                                :class="{ 'is-invalid': form.errors.has('hidden_cost') }" />

                                            <label class="fieldlabels">Shipping Cost Pay by:</label>
                                            <div class="form-check-inline">
                                               
                                                <select v-model="form.shipping_cost_pay_by"
                                                    name="cicle[]"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('shipping_cost_pay_by') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option value="1">None</option>
                                                    <option value="2">Customer</option>
                                                    <option value="3">Sell</option>
                                                    <option value="4">Service Provider</option>
                                                    <option value="5">Other</option>
                                                </select>
                                            </div>

                                            <label class="fieldlabels">Payment Status:</label>
                                            <div class="form-check-inline">
                                               
                                                <select v-model="form.payment_status"
                                                    name="cicle[]"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('payment_status') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option value="1">Paid</option>
                                                    <option value="2">Partially Paid</option>
                                                    <option value="3">Unpaid/Panding</option>
                                                    <option value="4">Payment in Process</option>
                                                    <option value="5">Payment on Way</option>
                                                    <option value="6">Overdue</option>
                                                    <option value="7">Void</option>
                                                    <option value="8">Refunded</option>
                                                    <option value="9">Hold</option>
                                                    <option value="10">Disputed</option>
                                                    <option value="11">Payment Got NSF</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                        <h4>Shipping Company:</h4>
                                        <label class="fieldlabels">Shipping Company Name:</label>
                                        <input v-model="form.shipping_company_name" 
                                            type="text" 
                                            @click="browse_account_holder_info(102)"
                                            name="shipping_company_name" 
                                            placeholder="Browse" 
                                            :class="{ 'is-invalid': form.errors.has('shipping_company_name') }" readonly/>
                                        
                                        <label class="fieldlabels">Shipping Company Logo:</label>
                                        <input v-model="form.shipping_company_logo" 
                                            type="text" 
                                            @click="browse_shipping_company_logo"
                                            name="shipping_company_logo" 
                                            :class="{ 'is-invalid': form.errors.has('shipping_company_logo') }" disabled/>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        Shipping Company Contact
                                                    </td>
                                                    <td>
                                                        {{form.shipping_company_contact}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Shipping Company Address
                                                    </td>
                                                    <td>
                                                        {{form.shipping_company_address}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Shipping Company Account No
                                                    </td>
                                                    <td>
                                                        {{form.shipping_company_account_no}}
                                                    </td>
                                                </tr>
                                            </tbody>   
                                        </table>
                                        <h4>Shipped by Vehicle:</h4>
                                        <label class="fieldlabels"> Vehicle Identification Number:</label>
                                        <input v-model="form.vehicle_identification_number" 
                                            type="text" 
                                            name="vehicle_identification_number" 
                                            placeholder="Type Vehicle Identification Number" 
                                            :class="{ 'is-invalid': form.errors.has('vehicle_identification_number') }" />

                                        <label class="fieldlabels"> Make:</label>
                                        <input v-model="form.vehicle_make" 
                                            type="text" 
                                            name="vehicle_make" 
                                             placeholder="Type Make"
                                            :class="{ 'is-invalid': form.errors.has('vehicle_make') }" /> 

                                        <label class="fieldlabels"> Model:</label>
                                        <input v-model="form.vehicle_model" 
                                            type="text" 
                                            name="vehicle_model" 
                                             placeholder="Type Model"
                                            :class="{ 'is-invalid': form.errors.has('vehicle_model') }" /> 

                                        <label class="fieldlabels"> Year:</label>
                                        <input v-model="form.vehicle_year" 
                                            type="text" 
                                            name="vehicle_year" 
                                             placeholder="Type Year"
                                            :class="{ 'is-invalid': form.errors.has('vehicle_year') }" />

                                        <label class="fieldlabels"> Type:</label>
                                        <input v-model="form.vehicle_type" 
                                            type="text" 
                                            name="vehicle_type" 
                                             placeholder="Type"
                                            :class="{ 'is-invalid': form.errors.has('vehicle_type') }" />

                                        <label class="fieldlabels"> License Plate:</label>
                                        <input v-model="form.vehicle_license_plate" 
                                            type="text" 
                                            name="vehicle_license_plate" 
                                             placeholder="Type License Plate"
                                            :class="{ 'is-invalid': form.errors.has('vehicle_license_plate') }" />

                                        <label class="fieldlabels"> Vehicle Images:</label>
                                        <input v-model="form.vehicle_image" 
                                            type="text" 
                                            name="vehicle_image" 
                                             placeholder=""
                                            :class="{ 'is-invalid': form.errors.has('vehicle_image') }" />


                                        <label class="fieldlabels"> Insurance Information:</label>
                                        <input v-model="form.vehicle_insurance_information" 
                                            type="text" 
                                            name="vehicle_insurance_information" 
                                             placeholder="Type Insurance Information"
                                            :class="{ 'is-invalid': form.errors.has('vehicle_insurance_information') }" />
                                                                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-holder" v-show="general_info_show">
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                            <h4>Driver Profile:</h4>
                                            <label class="fieldlabels">Driver Name:</label>
                                        <input v-model="form.driver_name" 
                                            type="text" 
                                            @click="browse_account_holder_info(103)"
                                            name="driver_name" 
                                            placeholder="Browse" 
                                            :class="{ 'is-invalid': form.errors.has('driver_name') }" readonly/>
                                        
                                        <label class="fieldlabels">Driver Photo:</label>
                                        <input v-model="form.driver_photo" 
                                            type="text" 
                                            name="driver_photo" 
                                            :class="{ 'is-invalid': form.errors.has('driver_photo') }" disabled/>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            Driving Licence No
                                                        </td>
                                                        <td>
                                                            {{form.driver_license_no}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        Driver Contact
                                                        </td>
                                                        <td>
                                                            {{form.driver_contact_no}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Driver Address
                                                        </td>
                                                        <td>
                                                            {{form.driver_address}}
                                                        </td>
                                                    </tr>
                                                </tbody>    
                                            </table>
                                                                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder">
                        <h3>
                            <i class="fa fa-hand-point-right"></i> Product Details:
                            <button type="button" class="btn btn-primary btn-sm" @click="show_hide_product_info()" v-show="!product_info_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_product_info()" v-show="product_info_show">Hide</button>

                        </h3>
                    
                        <div class="form-holder" v-show="product_info_show" v-if="purchase_page<=3">
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="3%" >SL</th>
                                                    <template v-if="form.purchase_type==1">
                                                        <th scope="col" width="5%">Product Code</th>
                                                        <th scope="col" width="8%">Property Name</th>
                                                        <th scope="col" width="14%">Product Description</th>
                                                        <th scope="col" width="7%">UOM</th>
                                                    </template>
                                                    <template v-else>
                                                        <th scope="col" width="5%">Service Code</th>
                                                        <th scope="col" width="8%">Service Title</th>
                                                        <th scope="col" width="14%">Service Description</th>
                                                        <th scope="col" width="7%">Service Type</th>
                                                    </template> 
                                                    <th scope="col" align="center" width="7%">Qty</th>
                                                    <th scope="col" width="7%">Rate</th>
                                                    <th scope="col" width="7%">Addition</th>
                                                    <th scope="col" width="7%">Deduction</th>
                                                    <th scope="col" width="8%">Sub Total</th>
                                                    <th scope="col" width="7%">Tax Rate</th>
                                                    <th scope="col" width="7%">Tax</th>
                                                    <th scope="col" width="10%">Total</th>
                                                    <th scope="col" width="5%" >Action</th>
                                                </tr>
                                                
                                            </thead>
                                            <tbody >
                                                <template v-for="(single_product,index) in form.product_details_arr" >

                                                    <tr v-if="form.purchase_type==1">
                                                        <td>{{index+1}}</td>
                                                        <td width="" scope="row" style=""><strong>{{single_product.product_code}}</strong></td>
                                                        <td width="" scope="row" style="" >
                                                            <input v-model="single_product.item_name" 
                                                                type="text"
                                                                name="item_name[]" 
                                                                @dblclick="browse_product_name(index)"
                                                                placeholder="Browse" readonly/>

                                                        </td>
                                                        
                                                        <td width="" scope="row" style=""><strong>{{single_product.item_description}}</strong></td>
                                                        <td width="" scope="row" style=""><strong>{{single_product.uom_string}}</strong></td>
                                                        <td width="">
                                                            <input v-model="single_product.qty" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_qty[]" 
                                                                @keyup="change_product_amount(single_product,0)"
                                                                placeholder="Qty" />
                                                        </td>
                                                        <td >

                                                            <input v-model="single_product.rate" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_rate[]"
                                                                @keyup="change_product_amount(single_product,0)" 
                                                                placeholder="Rate" />
                                                        </td>
                                                        
                                                        
                                                        <td width="">
                                                            <input v-model="single_product.addition" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_addition[]"
                                                                @keyup="change_product_amount(single_product,0)" 
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.deduction" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_deduction[]"
                                                                @keyup="change_product_amount(single_product,0)" 
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.sub_total" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_sub_total[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.tax_rate" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_tax_rate[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.tax" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_tax[]"
                                                                @keyup="change_product_amount(single_product,0)" 
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.total" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_total[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        
                                                        <td>
                                                            <button   type="button" class="btn  btn-primary" style="min-width:30px" @click="add_new_product()">Add</button>

                                                        </td>
                                                        
                                                    </tr>
                                                    <tr v-else>
                                                        <td>{{index+1}}</td>
                                                        <td width="" scope="row" style=""><strong>{{single_product.product_code}}</strong></td>
                                                        
                                                        <td width="" scope="row">
                                                            <input v-model="single_product.item_name" 
                                                                type="text"
                                                                name="item_name[]" 
                                                                @dblclick="browse_service_name(index)"
                                                                placeholder="Browse" readonly/>

                                                        </td>
                                                        <td width="" scope="row" style=""><strong>{{single_product.item_description}}</strong></td>
                                                        <td width="" scope="row" style=""><strong>{{single_product.uom_string}}</strong></td>
                                                        <td width="">
                                                            <input v-model="single_product.qty" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_qty[]" 
                                                                @keyup="change_product_amount(single_product,0)"
                                                                placeholder="Qty" />
                                                        </td>
                                                        
                                                        <td>
                                                            <input v-model="single_product.rate" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_rate[]"
                                                                @keyup="change_product_amount(single_product,0)" 
                                                                placeholder="Rate" disabled/>
                                                        </td>
                                                        
                                                        <td width="">
                                                            <input v-model="single_product.addition" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_addition[]"
                                                                @keyup="change_product_amount(single_product,0)" 
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.deduction" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_deduction[]"
                                                                @keyup="change_product_amount(single_product,0)" 
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.sub_total" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_sub_total[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                            <td width="">
                                                            <input v-model="single_product.tax_rate" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_tax_rate[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.tax" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_tax[]"
                                                                @keyup="change_product_amount(single_product,0)" 
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.total" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_total[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        
                                                        <td>
                                                            <button   type="button" class="btn  btn-primary" style="min-width:30px" @click="add_new_product()">Add</button>

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
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-right">{{form.total_addition}}</td>
                                                    <td class="text-right">{{form.total_deduction}}</td>
                                                    <td class="text-right">{{form.subtotal}}</td>
                                                    <td class="text-right"></td>
                                                    <td class="text-right">{{form.total_tax}}</td>
                                                    <td class="text-right">
                                                        {{form.total}}
                                                    </td>
                                                    <td></td> 
                                                </tr>
                                                </tfoot>
                                        </table> 
                                    </div>
                                </div> 

                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        <h4>Extra Charges Allocation</h4>
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="50px" rowspan="2" >SL</th>
                                                    <th scope="col" width="120px" rowspan="2">Charge Title</th>
                                                    <th scope="col" width="120px" rowspan="2">Amount</th>
                                                    <template v-for="(single_product,index) in form.product_details_arr" >

                                                        <th scope="col" width="120px"><strong>{{single_product.item_description}}</strong></th>

                                                    </template>
                                                </tr>
                                                <tr>
                                                    <template v-for="(single_product,index) in form.product_details_arr" >
                                                        <th scope="col" width="120px">

                                                            <input v-model="single_product.addition_percent" 
                                                                type="text"
                                                                class="text-right"
                                                                name="addition_percent[]"
                                                                @keyup="change_distribution_amount()" 
                                                                placeholder="Type Percentage" /> 
                                                        </th>
                                                    </template>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template v-for="(single_charge,index) in form.additional_charge_arr" >

                                                    <tr>
                                                        <td>{{index+1}}</td>
                                                        <td width="" scope="row" style=""><strong>{{single_charge.reference_name}}</strong></td>
                                                        
                                                        <td width="">
                                                            <input v-model="single_charge.amount" 
                                                                type="text"
                                                                class="text-right"
                                                                name="charge_amount[]" 
                                                                @keyup="change_distribution_amount()"
                                                                placeholder="Qty" />
                                                        </td>

                                                        <template v-for="(single_product,index) in form.product_details_arr" >
                                                            <template v-for="(distrubution,dis_id) in single_product.addition_distribution" >
                                                                <template  v-if="single_charge.reference_id==distrubution.reference_id">
                                                                    <td scope="col" width="120px">

                                                                        <input v-model="distrubution.reference_value" 
                                                                            type="text"
                                                                            class="text-right"
                                                                            name="distribution_value[]"
                                                                            placeholder="Calculative" disabled/> 
                                                                    </td>
                                                                </template>
                                                            </template>
                                                        </template>
                                                    </tr>
                                                                                                        
                                                </template>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td align="right">{{form.total_addition}}</td>
                                                    <template v-for="(single_product,index) in form.product_details_arr" >
                                                            
                                                        <td scope="col" width="120px" align="right">
                                                            {{single_product.addition}}
                                                        </td>
                                                        
                                                    </template>
                                                </tr>
                                                </tfoot>
                                        </table> 
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        <h4>Charge Deduction </h4>
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="50px" rowspan="2" >SL</th>
                                                    <th scope="col" width="120px" rowspan="2">Charge Title</th>
                                                    <th scope="col" width="120px" rowspan="2">Amount</th>
                                                    <template v-for="(single_product,index) in form.product_details_arr" >
                                                        <th scope="col" width="120px"><strong>{{single_product.item_description}}</strong></th>
                                                    </template>
                                                    
                                                </tr>
                                                <tr>
                                                    <template v-for="(single_product,index) in form.product_details_arr" >
                                                        <th scope="col" width="120px">

                                                            <input v-model="single_product.deduction_percent" 
                                                                type="text"
                                                                class="text-right"
                                                                name="deduction_percent[]"
                                                                @keyup="change_deduction_amount()" 
                                                                placeholder="Type Percentage" /> 
                                                        </th>
                                                    </template>
                                                </tr>
                                                
                                            </thead>
                                            <tbody >
                                                <template v-for="(single_charge,index) in form.deduction_charge_arr" >

                                                    <tr>
                                                        <td>{{index+1}}</td>
                                                        <td width="" scope="row" style=""><strong>{{single_charge.reference_name}}</strong></td>
                                                        
                                                        <td width="">
                                                            <input v-model="single_charge.amount" 
                                                                type="text"
                                                                class="text-right"
                                                                name="charge_amount[]" 
                                                                @keyup="change_deduction_amount()"
                                                                placeholder="Qty" />
                                                        </td>
                                                        <template v-for="(single_product,index) in form.product_details_arr" >
                                                            <template v-for="(distrubution,dis_id) in single_product.deduction_distribution" >
                                                                <td scope="col" width="120px" v-if="single_charge.reference_id==distrubution.reference_id">

                                                                    <input v-model="distrubution.reference_value" 
                                                                        type="text"
                                                                        class="text-right"
                                                                        name="distribution_value[]"
                                                                        placeholder="Calculative" disabled/> 
                                                                </td>
                                                            </template>
                                                        </template>
                                                                                                                
                                                        
                                                    </tr>
                                                                                                        
                                                </template>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td align="right">{{form.total_deduction}}</td>
                                                    <template v-for="(single_product,index) in form.product_details_arr" >
                                                            
                                                        <td scope="col" width="120px" align="right">
                                                            {{single_product.deduction}}
                                                        </td>
                                                        
                                                    </template>
                                                </tr>
                                                </tfoot>
                                        </table> 
                                    </div>
                                </div>                        
                            </div>
                        </div>
                        <div class="form-holder" v-show="product_info_show" v-else>
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="3%" >SL</th>
                                                    <template v-if="form.purchase_type==1">
                                                        <th scope="col" width="5%">Product Code</th>
                                                        <th scope="col" width="8%">Property Name</th>
                                                        <th scope="col" width="14%">Product Description</th>
                                                        <th scope="col" width="7%">UOM</th>
                                                    </template>
                                                    <template v-else>
                                                        <th scope="col" width="5%">Service Code</th>
                                                        <th scope="col" width="8%">Service Title</th>
                                                        <th scope="col" width="14%">Service Description</th>
                                                        <th scope="col" width="7%">Service Type</th>
                                                    </template> 
                                                    <th scope="col" align="center" width="7%">Qty</th>
                                                    <th scope="col" width="7%">Rate</th>
                                                    <th scope="col" width="7%">Addition</th>
                                                    <th scope="col" width="7%">Deduction</th>
                                                    <th scope="col" width="8%">Sub Total</th>
                                                    <th scope="col" width="7%">Tax Rate</th>
                                                    <th scope="col" width="7%">Tax</th>
                                                    <th scope="col" width="10%">Total</th>
                                                    
                                                </tr>
                                                
                                            </thead>
                                            <tbody >
                                                <template v-for="(single_product,index) in form.product_details_arr" >

                                                    <tr v-if="form.purchase_type==1">
                                                        <td>{{index+1}}</td>
                                                        <td width="" scope="row" style=""><strong>{{single_product.product_code}}</strong></td>
                                                        <td width="" scope="row" style="" >
                                                            <input v-model="single_product.item_name" 
                                                                type="text"
                                                                name="item_name[]" 
                                                                @dblclick="browse_product_name(index)"
                                                                placeholder="Browse" disabled/>

                                                        </td>
                                                        
                                                        <td width="" scope="row" style=""><strong>{{single_product.item_description}}</strong></td>
                                                        <td width="" scope="row" style=""><strong>{{single_product.uom_string}}</strong></td>
                                                        <td width="">
                                                            <input v-model="single_product.qty" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_qty[]" 
                                                                @keyup="change_product_amount(single_product,0)"
                                                                placeholder="Qty" />
                                                        </td>
                                                        <td >

                                                            <input v-model="single_product.rate" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_rate[]"
                                                                placeholder="Rate" />
                                                        </td>
                                                        
                                                        
                                                        <td width="">
                                                            <input v-model="single_product.addition" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_addition[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.deduction" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_deduction[]"
                                                                
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.sub_total" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_sub_total[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.tax_rate" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_tax_rate[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.tax" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_tax[]"
                                                                
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.total" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_total[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr v-else>
                                                        <td>{{index+1}}</td>
                                                        <td width="" scope="row" style=""><strong>{{single_product.product_code}}</strong></td>
                                                        
                                                        <td width="" scope="row">
                                                            <input v-model="single_product.item_name" 
                                                                type="text"
                                                                name="item_name[]" 
                                                                @dblclick="browse_service_name(index)"
                                                                placeholder="Browse" disabled/>

                                                        </td>
                                                        <td width="" scope="row" style=""><strong>{{single_product.item_description}}</strong></td>
                                                        <td width="" scope="row" style=""><strong>{{single_product.uom_string}}</strong></td>
                                                        <td width="">
                                                            <input v-model="single_product.qty" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_qty[]" 
                                                                @keyup="change_product_amount(single_product,0)"
                                                                placeholder="Qty" />
                                                        </td>
                                                        
                                                        <td>
                                                            <input v-model="single_product.rate" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_rate[]"
                                                                placeholder="Rate" disabled/>
                                                        </td>
                                                        
                                                        <td width="">
                                                            <input v-model="single_product.addition" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_addition[]"
                                                                
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.deduction" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_deduction[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.sub_total" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_sub_total[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                            <td width="">
                                                            <input v-model="single_product.tax_rate" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_tax_rate[]"
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.tax" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_tax[]"
                                                                    
                                                                placeholder="Calculative" disabled/> 
                                                        </td>
                                                        <td width="">
                                                            <input v-model="single_product.total" 
                                                                type="text"
                                                                class="text-right"
                                                                name="product_total[]"
                                                                placeholder="Calculative" disabled/> 
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
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-right">{{form.total_addition}}</td>
                                                    <td class="text-right">{{form.total_deduction}}</td>
                                                    <td class="text-right">{{form.subtotal}}</td>
                                                    <td class="text-right"></td>
                                                    <td class="text-right">{{form.total_tax}}</td>
                                                    <td class="text-right">
                                                        {{form.total}}
                                                    </td>
                                                    
                                                </tr>
                                                </tfoot>
                                        </table> 
                                    </div>
                                </div> 

                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        <h4>Extra Charges Allocation</h4>
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="50px" rowspan="2" >SL</th>
                                                    <th scope="col" width="120px" rowspan="2">Charge Title</th>
                                                    <th scope="col" width="120px" rowspan="2">Amount</th>
                                                    <template v-for="(single_product,index) in form.product_details_arr" >

                                                        <th scope="col" width="120px"><strong>{{single_product.item_description}}</strong></th>

                                                    </template>
                                                </tr>
                                                <tr>
                                                    <template v-for="(single_product,index) in form.product_details_arr" >
                                                        <th scope="col" width="120px">

                                                            <input v-model="single_product.addition_percent" 
                                                                type="text"
                                                                class="text-right"
                                                                name="addition_percent[]"
                                                                @keyup="change_distribution_amount()" 
                                                                placeholder="Type Percentage" disabled/> 
                                                        </th>
                                                    </template>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template v-for="(single_charge,index) in form.additional_charge_arr" >

                                                    <tr>
                                                        <td>{{index+1}}</td>
                                                        <td width="" scope="row" style=""><strong>{{single_charge.reference_name}}</strong></td>
                                                        
                                                        <td width="">
                                                            <input v-model="single_charge.amount" 
                                                                type="text"
                                                                class="text-right"
                                                                name="charge_amount[]" 
                                                                @keyup="change_distribution_amount()"
                                                                placeholder="Qty" disabled/>
                                                        </td>

                                                        <template v-for="(single_product,index) in form.product_details_arr" >
                                                            <template v-for="(distrubution,dis_id) in single_product.addition_distribution" v-if="single_charge.reference_id==distrubution.reference_id">
                                                                <td scope="col" width="120px">

                                                                    <input v-model="distrubution.reference_value" 
                                                                        type="text"
                                                                        class="text-right"
                                                                        name="distribution_value[]"
                                                                        placeholder="Calculative" disabled/> 
                                                                </td>
                                                            </template>
                                                        </template>
                                                    </tr>
                                                                                                        
                                                </template>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td align="right">{{form.total_addition}}</td>
                                                    <template v-for="(single_product,index) in form.product_details_arr" >
                                                            
                                                        <td scope="col" width="120px" align="right">
                                                            {{single_product.addition}}
                                                        </td>
                                                        
                                                    </template>
                                                </tr>
                                                </tfoot>
                                        </table> 
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        <h4>Charge Deduction </h4>
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="50px" rowspan="2" >SL</th>
                                                    <th scope="col" width="120px" rowspan="2">Charge Title</th>
                                                    <th scope="col" width="120px" rowspan="2">Amount</th>
                                                    <template v-for="(single_product,index) in form.product_details_arr" >
                                                        <th scope="col" width="120px"><strong>{{single_product.item_description}}</strong></th>
                                                    </template>
                                                    
                                                </tr>
                                                <tr>
                                                    <template v-for="(single_product,index) in form.product_details_arr" >
                                                        <th scope="col" width="120px">

                                                            <input v-model="single_product.deduction_percent" 
                                                                type="text"
                                                                class="text-right"
                                                                name="deduction_percent[]"
                                                                @keyup="change_deduction_amount()" 
                                                                placeholder="Type Percentage" disabled/> 
                                                        </th>
                                                    </template>
                                                </tr>
                                                
                                            </thead>
                                            <tbody >
                                                <template v-for="(single_charge,index) in form.deduction_charge_arr" >

                                                    <tr>
                                                        <td>{{index+1}}</td>
                                                        <td width="" scope="row" style=""><strong>{{single_charge.reference_name}}</strong></td>
                                                        
                                                        <td width="">
                                                            <input v-model="single_charge.amount" 
                                                                type="text"
                                                                class="text-right"
                                                                name="charge_amount[]" 
                                                                @keyup="change_deduction_amount()"
                                                                placeholder="Qty" disabled/>
                                                        </td>
                                                        <template v-for="(single_product,index) in form.product_details_arr" >
                                                            <template v-for="(distrubution,dis_id) in single_product.deduction_distribution" v-if="single_charge.reference_id==distrubution.reference_id">
                                                                <td scope="col" width="120px">

                                                                    <input v-model="distrubution.reference_value" 
                                                                        type="text"
                                                                        class="text-right"
                                                                        name="distribution_value[]"
                                                                        placeholder="Calculative" disabled/> 
                                                                </td>
                                                            </template>
                                                        </template>
                                                                                                                
                                                        
                                                    </tr>
                                                                                                        
                                                </template>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td align="right">{{form.total_deduction}}</td>
                                                    <template v-for="(single_product,index) in form.product_details_arr" >
                                                            
                                                        <td scope="col" width="120px" align="right">
                                                            {{single_product.deduction}}
                                                        </td>
                                                        
                                                    </template>
                                                </tr>
                                                </tfoot>
                                        </table> 
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
                                                    

                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step==0 && purchase_page==1" @click="convert_to_purchase_offer(form.id)">Convert To Offer Acceptance</button>

                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step==0 && purchase_page==2" @click="convert_from_offer_acceptance(form.id)">Convert To Order</button>

                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step==0 && purchase_page==3" @click="convert_from_order(form.id)">Convert To Packing Slip</button>

                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step_return==0 && purchase_page==4" @click="convert_to_return(form.id)">Convert To Return</button>

                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step_debit==0 && purchase_page==4" @click="convert_to_debit_note(form.id)">Convert To Debit Note</button>

                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step_credit==0 && purchase_page==4" @click="convert_to_credit_note(form.id)">Convert To Credit Note</button>

                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step==0 && purchase_page==4" @click="convert_to_invoice(form.id)">Convert To Purchase Invoice</button>

                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step!=1 && purchase_page==8" @click="convert_to_direct_payment(form.id)">Convert To Direct Receipt</button>

                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="(form.posting_status==2 || form.posting_status==4) && form.next_step!=1 && purchase_page==9" @click="account_statement(form.id)">Account Statement</button>

                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="postable">Print</button>
                        </div>

                        
                    </div>

                </div>
            </form>
        </div>
       <!--  Model  -->
       <div class="modal fade model-middle" id="ServiceProvider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content" style="width:800px;overflow-y: initial !important">
                  <div class="modal-header">
                        <h4 ><strong>Service Provider List</strong></h4>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>  
                  </div>
                  <div class="modal-body" style="height: 50vh; overflow-y: auto;">
                    <div class="form-holder">
                        

                        <table class="table">
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Phone</td>
                                        <td>Email</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="service_provider in service_provider_arr" style="cursor:pointer" @click="close_service_provider(service_provider)">
                                        <td>{{service_provider.first_name}} {{service_provider.middle_name}} {{service_provider.last_name}}</td>
                                        <td>{{service_provider.cell_phone}}</td>
                                        <td>{{service_provider.email}}</td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
        
                  </div>
                </div>
              </div>
            </div>
        <!-- Model end -->

    </fieldset>
</template>


<style>

    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .form-group .form-label {
        width: 40%;
        background-color: #007bff;
        color: white;
        padding: 10px;
        text-align: left;
        border-radius: 5px;
        font-weight: bold;
    }
    .form-group .form-control {
        width: 60%;
        border-radius: 5px;
    }


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
       
        font-size:12px !important;
    }

    #progressbar li::before {
        /* margin-top:10px;
        width:40px;
        height:40px;
        line-height:30px; */
    }

</style>


<script>
   
    import { ref } from "vue";
    import Vue3Datatable from "@bhplugin/vue3-datatable";
    import "@bhplugin/vue3-datatable/dist/style.css";
    import VueTimepicker from 'vue3-timepicker';
    import 'vue3-timepicker/dist/VueTimepicker.css';
    import Vue3datepicker from "vue3-datepicker";

    export default {
        name:'list-product-categories',
        components:{
            Vue3datepicker,
            VueTimepicker,
            Vue3Datatable
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
                purchase_page:1,
                form:new Form({
                   
                    unique_no:'',
                    transaction_no:'',
                    purchase_type:'',
                    posting_status:0,
                    next_step:0,
                    next_step_return:0,
                    next_step_debit:0,
                    next_step_credit:0,
                    seller_name:'',
                    seller_id:'',
                    seller_account_no:'',
                    seller_photo:'',
                    seller_photo_id:'',
                    seller_contact_no:'',
                    seller_address:'',
                    service_provider_account_no:'',
                    service_provider_id:'',
                    service_provider_photo_id:'',
                    service_provider_photo:'',
                    service_provider_contact_no:'',
                    service_provider_address:'',

                    customer_name:'',
                    customer_id:'',
                    customer_photo:'',
                    customer_account_no:'',
                    customer_contact_no:'',
                    customer_address:'',

                    schedule_delivery_date:null,
                    schdule_delivery_time:null,
                    delivery_location:'',
                    delivery_instruction:'',
                    delivery_contact_person_name:'',
                    delivery_contact_person_email:'',
                    delivery_contact_person_phone:'',
                    delivery_receive_by:'',
                    payment_due_date:'',
                    days_left_to_pay:'',
                    early_payment_discount:'',
                    payment_method:'',
                    posted_check_available:'',
                    late_payment_pelanty:'',
                    hidden_cost:'',
                    shipping_cost_pay_by:'',
                    payment_status:'',
                    shipping_company_name:'',
                    shipping_company_id:'',
                    shipping_company_contact:'',
                    shipping_company_address:'',
                    shipping_company_account_no:'',
                    shipping_company_logo:'',

                    notification_by:'',
                    backorder_allowed:'',
                    approval_status:'',
                    approval_date:'',
                    approval_time:'',
                    approve_by:'',
                    
                    vehicle_identification_number:'',
                    vehicle_make:'',
                    vehicle_model:'',
                    vehicle_year:'',
                    vehicle_type:'',
                    vehicle_license_plate:'',
                    vehicle_image:'',
                    vehicle_image_id:'',
                    vehicle_insurance_information:'',
                    driver_address:'',
                    driver_name:'',
                    driver_id:'',
                    driver_photo:'',
                    driver_license_no:'',
                    driver_contact_no:'',
                    product_details_arr:[
                        {
                            id:'',
                            product_id:'',
                            product_code:'',
                            item_name:'',
                            item_description:'',
                            uom_string:'',
                            service_type:'',
                            qty:'',
                            rate:'',
                            addition_percent:'',
                            deduction_percent:'',
                            addition:0,
                            deduction:0,
                            sub_total:'',
                            tax:'',
                            total:'',
                            addition_distribution:[],
                            deduction_distribution:[],
                        }
                    ],
                    additional_charge_arr:[],
                    deduction_charge_arr:[],
        
                    total_addition:0,
                    total_deduction:0,
                    total_deduction_charge:0,
                    total_addition_charge:0,
                    subtotal:0,
                    total_tax:0,
                    total:0,
                   
                    page_id:9,
                    id:'',
                    purchase_offer_no:'',
                    purchase_offer_date:'',
                    purchase_offer_acceptance_no:'',
                    purchase_offer_acceptance_date:'',
                    purchase_order_no:'',
                    purchase_order_date:'',
                    packing_slip_no:'',
                    packing_slip_date:'',
                    purchase_invoice_no:'',
                    purchase_invoice_date:'',
                    purchase_return_no:'',
                    purchase_return_date:'',
                    purchase_debit_note_no:'',
                    purchase_debit_note_date:'',
                    purchase_credit_note_no:'',
                    purchase_credit_note_date:'',
                    schdule_delivery_time:'',
                    
                }),

                total_purchase_offer_qty:0,
                total_purchase_offer_acceptance_qty:0,
                total_purchase_order_qty:0,
                total_purchase_packaing_slip_qty:0,
                total_debit_note_qty:0,
                total_credit_note_qty:0,
                total_purchase_invoice_qty:0,
                total_purchase_return_qty:0,
                total_direct_payment_qty:0,
                purchase_summery_details:[],
                po_balance_list:[],
                

                columns: ref([
                    { title: 'SL', field: 'sl', align: 'center' },
                    { title: 'Unique No', field: 'system_no' },
                    { title: 'Transaction No', field: 'system_no' },
                    { title: 'Purchase Type', field: 'purchase_type_string' },
                    { title: 'Seller', field: 'seller_name' },
                    { title: 'Service Provider', field: 'service_provider_name' },
                    { title: 'Customer', field: 'customer_name' },
                    { title: 'Approval Status', field: 'approval_status' },
                    { title: 'Delivery Date', field: 'schedule_delivery_date' },
                    { title: 'Shipping Company', field: 'shipping_company' },
                    { title: 'Driver Name', field: 'driver_name' },
                    { title: 'Action', field: '', sortable: false },
                ]),
                inventory_columns:ref( [
                    { title: 'SL', field: 'sl', align: 'center' },
                    { title: 'Code', field: 'system_no' },
                    { title: 'Item Category', field: 'item_category_string' },
                    { title: 'Item Name', field: 'item_name' },
                    { title: 'Item Description', field: 'item_description' },
                    { title: 'UOM', field: 'uom_string' },
                    { title: 'Model', field: 'model' },
                    { title: 'Chart of Account', field: 'chart_of_account' },
                ]),
                service_columns: ref([
                    { title: 'SL', field: 'sl', align: 'center' },
                    { title: 'Service Code', field: 'system_no' },
                    { title: 'Service Category', field: 'service_category_string' },
                    { title: 'Service Title', field: 'service_title' },
                    { title: 'Description', field: 'service_description' },
                    { title: 'Service Type', field: 'service_type' },
                    { title: 'Service Cost', field: 'service_cost' },
                    { title: 'Purchase Tax', field: 'purchase_tax' },
                    { title: 'Tax Rate', field: 'tax' },
                ]),
                additional_charge_item:[],
                deduction_charge_item:[],
                account_holder_type:'',
                rows: [],
                test_collupsable:false,
                general_info_show:true,
                purchase_summery_show:false,
                product_info_show:false,
                property_show:false,
                percent:11,
                inventory_item_arr:[],
                service_item_arr:[],
                temp_product:'',
                service_provider_arr:[],
                country_arr:[],
                company_arr:[],
                customer_arr:[],
                building_arr:[],
                floor_arr:[],
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
            this.setProgressBar(1,9);

        },
        
        computed:{

            
            
        },
        methods: {

            purchase_summery(unique_no)
            {
                this.summery_showable=true;
                this.purchase_summery_show=true;
                let uri = '/PurchaseSummery/'+unique_no;
                
                window.axios.get(uri).then((response) => {
                    
                    this.purchase_summery_details   = response.data.charge_details_arr;
                    this.po_balance_list            = response.data.po_balance_list;
    
                });

            },

            convert_from_order(offer_id)
            {
                this.setProgressBar(4,10);
                this.purchase_page=4;
                this.fetchPurchasePackaingSlip(offer_id);
            },
            remove_product(row_id)
            {

                this.form.product_details_arr.splice(row_id,1);
            },
            convert_from_packing_slip(offer_id)
            {

                this.setProgressBar(5,10);
                this.purchase_page=5;
                this.fetchPurchaseInvoice(offer_id);
            },

            fetchPurchasePackaingSlip(offer_id)
            {

                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchaseOrders/'+offer_id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.editmode=false;
                    
                    this.form.unique_no                         =response.data.purchase_offer_list.unique_no;
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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

            fetchPurchaseReturn(offer_id){
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchasePackingSlips/'+offer_id+'/edit';
                window.axios.get(uri).then((response) => {
                    this.editmode=false;
                    
                    //this.form.id                              =response.data.purchase_offer_list.id;
                    this.form.unique_no                         =response.data.purchase_offer_list.unique_no;
                    //this.form.transaction_no                  =response.data.purchase_offer_list.transaction_no;
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
                   // this.form.next_step                         =response.data.purchase_offer_list.next_step;
                    this.form.seller_name                       =response.data.purchase_offer_list.seller_name;
                    this.form.seller_id                         =response.data.purchase_offer_list.seller_id;
                    this.form.seller_account_no                 =response.data.purchase_offer_list.seller_account_no;
                    this.form.seller_photo                      =response.data.purchase_offer_list.seller_photo;
                    this.form.seller_photo_id                   =response.data.purchase_offer_list.seller_photo_id;
                    this.form.next_step_return                  =0;
                    this.form.next_step_debit                   =0;
                    this.form.next_step_credit                  =0;
                    this.form.posting_status                    =0;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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

            convert_from_offer_acceptance(offer_id)
            {
                
                this.setProgressBar(3,10);
                this.purchase_page=3;
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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
                this.purchase_page=2;
                //this.form.reset ();
                this.fetchPurchaseOfferAcceptance(offer_id);
            },
            convert_to_return(offer_id)
            {
                
                this.setProgressBar(5,10);
                this.purchase_page=5;
                this.fetchPurchaseReturn(offer_id);
            },
            convert_to_debit_note(offer_id)
            {
                
                this.setProgressBar(6,10);
                this.purchase_page=6;
                this.fetchPurchaseReturn(offer_id);
            },
            convert_to_credit_note(offer_id)
            {
                
                this.setProgressBar(7,10);
                this.purchase_page=7;
                this.fetchPurchaseReturn(offer_id);
            },
            
            convert_to_invoice(offer_id)
            {
                
                this.setProgressBar(8,10);
                this.purchase_page=8;
                this.fetchPurchaseInvoice(offer_id);
            },
            convert_to_direct_payment(offer_id)
            {
                this.setProgressBar(9,10);
                this.purchase_page=9;
                this.fetchPurchasePayment(offer_id);
            },
            fetchPurchasePayment(offer_id){

                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchaseInvoices/'+offer_id+'/edit';
                window.axios.get(uri).then((response) => {
                    this.editmode=false;
                    
                    //this.form.id                              =response.data.purchase_offer_list.id;
                    this.form.unique_no                         =response.data.purchase_offer_list.unique_no;
                    this.form.posting_status                    =response.data.purchase_offer_list.posting_status;

                    this.form.purchase_offer_no                 =response.data.purchase_offer_list.purchase_offer_no;
                    this.form.purchase_offer_date               =response.data.purchase_offer_list.purchase_offer_date;
                    this.form.purchase_offer_acceptance_no      =response.data.purchase_offer_list.purchase_offer_acceptance_no;
                    this.form.purchase_offer_acceptance_date    =response.data.purchase_offer_list.purchase_offer_acceptance_date;
                    this.form.purchase_order_no                 =response.data.purchase_offer_list.purchase_order_no;
                    this.form.purchase_order_date               =response.data.purchase_offer_list.purchase_order_date;
                    this.form.packing_slip_no                   =response.data.purchase_offer_list.packing_slip_no;
                    this.form.packing_slip_date                 =response.data.purchase_offer_list.packing_slip_date;
                    
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


                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
                    this.form.next_step                         =response.data.purchase_offer_list.next_step;
                    this.form.seller_name                       =response.data.purchase_offer_list.seller_name;
                    this.form.seller_id                         =response.data.purchase_offer_list.seller_id;
                    this.form.seller_account_no                 =response.data.purchase_offer_list.seller_account_no;
                    this.form.seller_photo                      =response.data.purchase_offer_list.seller_photo;
                    this.form.seller_photo_id                   =response.data.purchase_offer_list.seller_photo_id;
                    this.form.next_step                         =0;
                    this.form.posting_status                    =0;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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

            fetchPurchaseInvoice(offer_id){

                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchasePackingSlips/'+offer_id+'/edit';
                window.axios.get(uri).then((response) => {
                    this.editmode=false;
                    
                    //this.form.id                              =response.data.purchase_offer_list.id;
                    this.form.unique_no                         =response.data.purchase_offer_list.unique_no;
                    //this.form.transaction_no                  =response.data.purchase_offer_list.transaction_no;
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
                    this.form.next_step                         =response.data.purchase_offer_list.next_step;
                    this.form.seller_name                       =response.data.purchase_offer_list.seller_name;
                    this.form.seller_id                         =response.data.purchase_offer_list.seller_id;
                    this.form.seller_account_no                 =response.data.purchase_offer_list.seller_account_no;
                    this.form.seller_photo                      =response.data.purchase_offer_list.seller_photo;
                    this.form.seller_photo_id                   =response.data.purchase_offer_list.seller_photo_id;
                    this.form.next_step                         =0;
                    this.form.posting_status                    =0;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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


            fetchPurchaseOfferAcceptance(offer_id)
            {

                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchaseOffers/'+offer_id+'/edit';
                window.axios.get(uri).then((response) => {
                    

                    this.editmode=false;
                    
                    this.form.id                                =response.data.purchase_offer_list.id;
                    this.form.unique_no                         =response.data.purchase_offer_list.unique_no;
                   
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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
                    this.form.posting_status                  =0;

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

            fetchPurchaseOffersProfile()
            {

                let uri = '/PurchaseOffers';
                window.axios.get(uri).then((response) => {

                    this.service_provider_arr                   =response.data.service_provider;
                    this.country_arr                            =response.data.country_arr; 
                    this.additional_charge_item                 =response.data.additional_charge_arr;
                    this.deduction_charge_item                  =response.data.deduction_charge_arr;
                    
                    for(let i=0; i<response.data.additional_charge_arr.length; i++){
               
                        this.form.additional_charge_arr.push({
                            'id':'',
                            'reference_id':response.data.additional_charge_arr[i].id,
                            'reference_name':response.data.additional_charge_arr[i].value,
                            'amount':'',
                        });                         
                    }

                    for(let i=0; i<response.data.deduction_charge_arr.length; i++){
               
                        this.form.deduction_charge_arr.push({
                            'id':'',
                            'reference_id':response.data.deduction_charge_arr[i].id,
                            'reference_name':response.data.deduction_charge_arr[i].value,
                            'amount':'',
                        });                         
                    }  
 
                }); 
              

            },

            change_page(page_id)
            {
                this.setProgressBar(page_id,10);
                this.purchase_page=page_id;
                this.form.reset ();
                this.rows="";
                this.list_showable=false;

                if(page_id==1)
                {
                    this.fetchPurchaseOffers();
                }

            },

            change_product_amount(product,type)
            {
            
                var qty=product.qty*1;
                var rate=product.rate*1;
                if(this.purchase_page<=3)
                {
                    var addition=product.addition*1;
                    var deduction=product.deduction*1;
                }
                else
                {
                    var addition_rate=product.addition_rate*1;
                    var addition=qty*addition_rate;
                    var deduction_rate=product.deduction_rate*1;
                    var deduction=qty*deduction_rate;
                    product.addition=addition;
                    product.deduction=deduction;

                }
                
                
                var sub_total=(qty*rate)+addition-deduction;
                if(sub_total>0) var tax=(sub_total*product.tax_rate)/100;
                else var tax=0;
                product.sub_total=sub_total;
                product.tax=tax;
                var total=sub_total+tax;
                product.total=total;
               
                if(type==0)
                {
                     //this.calculate_total_amount();

                    let sub_total=0;
                    let total=0;
                    let total_tax=0;
                    let total_addition=0;
                    let total_deduction=0;
                    this.form.product_details_arr.forEach(function(item,index){

                        if(item.qty)
                        {
                            total_addition+=(item.addition)*1;
                            total_deduction+=(item.deduction)*1;
                            total_tax+=(item.tax)*1;
                            sub_total+=(item.sub_total)*1;
                            total+=(item.total)*1;
                        }
                    });

                    this.form.total_addition=total_addition;
                    this.form.total_deduction=total_deduction;
                    this.form.subtotal=sub_total;
                    this.form.total_tax=total_tax;
                    this.form.total=total;

                }
                   
            },
            calculate_total_amount()
            {
                alert("this is test page");
                let sub_total=0;
                let total=0;
                let total_tax=0;
                let total_addition=0;
                let total_deduction=0;
                this.form.product_details_arr.forEach(function(item,index){

                    if(item.qty)
                    {
                        total_addition+=(item.addition)*1;
                        total_deduction+=(item.deduction)*1;
                        total_tax+=(item.tax)*1;
                        sub_total+=(item.sub_total)*1;
                        total+=(item.total)*1;
                    }
                });

                this.form.total_addition=total_addition;
                this.form.total_deduction=total_deduction;
                this.form.subtotal=sub_total;
                this.form.total_tax=total_tax;
                this.form.total=total;

            },
            change_purchase_type()
            {
                this.form.product_details_arr=[
                    {
                        id:'',
                        product_id:'',
                        product_code:'',
                        item_name:'',
                        item_description:'',
                        uom_string:'',
                        service_type:'',
                        qty:'',
                        rate:'',
                        addition_percent:'',
                        deduction_percent:'',
                        addition:0,
                        deduction:0,
                        sub_total:'',
                        tax:'',
                        total:'',
                        addition_distribution:[],
                        deduction_distribution:[],
                    }
                ];

            },
            change_distribution_amount()
            {

                let thistemp=this;
                var item_total=0;
                this.form.additional_charge_arr.forEach(function(item,index){
                    if(item.amount*1>0)
                        item_total+=item.amount*1;

                    thistemp.form.product_details_arr.forEach(function(single_product,index1){

                        single_product.addition_distribution.forEach(function(distribution,index2){
                            if(item.reference_id===distribution.reference_id)
                            {
                                var dis_percentage=0;
                                var charge_per=single_product.addition_percent*1;
                                var charge_amount=item.amount*1;
                                if((charge_per*charge_amount)>0)
                                    dis_percentage=(charge_per*charge_amount)/100;
                                else dis_percentage=0;
                                distribution.reference_value=dis_percentage.toFixed(2);

                            }
                        
                        }); 
                            
                    });
                });

                this.form.total_addition=item_total;

                this.form.product_details_arr.forEach(function(single_product,index1){

                        var total_addition=0;
                        single_product.addition_distribution.forEach(function(distribution,index2){

                            if(distribution.reference_value>0)
                                total_addition+=distribution.reference_value*1;
                              //  this.change_product_amount(single_product,1);
                    });

                    single_product.addition=total_addition;
                    thistemp.change_product_amount(single_product,1);        
                });

                this.calculate_total_amount();
            },

            calculate_total_amount()
            {
                var total_percentage=0;
                this.form.product_details_arr.forEach(function(single_product,index1){

                      total_percentage+=single_product.addition_percent*1;
                });

            },

            
            change_deduction_amount()
            {
                let thistemp=this;
                var item_total=0;
                this.form.deduction_charge_arr.forEach(function(item,index){
                    if(item.amount*1>0)
                        item_total+=item.amount*1;

                    thistemp.form.product_details_arr.forEach(function(single_product,index1){

                        single_product.deduction_distribution.forEach(function(distribution,index2){
                            if(item.reference_id===distribution.reference_id)
                            {
                                var dis_percentage=0;
                                var charge_per=single_product.deduction_percent*1;
                                var charge_amount=item.amount*1;
                                if((charge_per*charge_amount)>0)
                                    dis_percentage=(charge_per*charge_amount)/100;
                                else dis_percentage=0;

                                distribution.reference_value=dis_percentage.toFixed(2);

                            }
                        }); 
                            
                    });


                });

                this.form.total_deduction=item_total;

                this.form.product_details_arr.forEach(function(single_product,index1){

                        var total_deduction=0;
                        single_product.deduction_distribution.forEach(function(distribution,index2){

                            if(distribution.reference_value>0)
                                total_deduction+=distribution.reference_value*1;

                    });

                    single_product.deduction=total_deduction;
                    thistemp.change_product_amount(single_product,1);        
                });

                this.calculate_total_amount();

            },

            add_new_product()
            {

                this.form.product_details_arr.push({
                    id:'',
                    product_code:'',
                    product_id:'',
                    item_name:'',
                    item_description:'',
                    uom_string:'',
                    service_type:'',
                    qty:'',
                    rate:'',
                    addition_percent:'',
                    deduction_percent:'',
                    addition:0,
                    deduction:0,
                    sub_total:'',
                    tax_rate:'',
                    tax:'',
                    total:'',
                    addition_distribution:[],
                    deduction_distribution:[],
                });

            },

            browse_shipping_company_logo()
            {

            },

            browse_product_name(index)
            {
                let uri = '/inventoryItemData';
                window.axios.get(uri).then((response) => {

                    this.inventory_item_arr                                       = response.data.inventory_item_list;
                });
                this.temp_product=index;
                $("#InventoryItem").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show');
            },

            browse_service_name(index)
            {
                let uri = '/serviceItemData';
                window.axios.get(uri).then((response) => {

                    this.service_item_arr                                       = response.data.service_item_list;

                });

                this.temp_product=index;
                $("#ServiceItem").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show');
            },

            close_service_items(product)
            {

                $("#ServiceItem").modal("hide");
                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove() ;
                
                this.form.product_details_arr[this.temp_product].product_code       =product.system_no;
                this.form.product_details_arr[this.temp_product].product_id         =product.id;
                this.form.product_details_arr[this.temp_product].item_name          =product.service_title;
                this.form.product_details_arr[this.temp_product].item_description   =product.service_description;
                this.form.product_details_arr[this.temp_product].service_type       =product.service_type;
                this.form.product_details_arr[this.temp_product].tax_rate           =product.purchase_tax;
                this.form.product_details_arr[this.temp_product].tax                ="";
                this.form.product_details_arr[this.temp_product].qty                ="";
                this.form.product_details_arr[this.temp_product].rate               =product.service_cost;
                this.form.product_details_arr[this.temp_product].addition           ="";
                this.form.product_details_arr[this.temp_product].qty                ="";
                this.form.product_details_arr[this.temp_product].deduction          ="";
                this.form.product_details_arr[this.temp_product].sub_total          ="";
                this.form.product_details_arr[this.temp_product].tax_rate           =product.tax;
                this.form.product_details_arr[this.temp_product].total              ="";

                let thistemp=this;

                if(thistemp.form.product_details_arr[thistemp.temp_product].addition_distribution.length<1)
                {
                    this.additional_charge_item.forEach(function(item,index){

                        thistemp.form.product_details_arr[thistemp.temp_product].addition_distribution.push({
                            'reference_id':item.id,
                            'reference_name':item.value,
                            'reference_value':0,
                        }); 
                    });
                }

                if(thistemp.form.product_details_arr[thistemp.temp_product].deduction_distribution.length<1)
                {
                    this.deduction_charge_item.forEach(function(item,index){

                        thistemp.form.product_details_arr[thistemp.temp_product].deduction_distribution.push({
                            'reference_id':item.id,
                            'reference_name':item.value,
                            'reference_value':0,
                        }); 
                    });
                }

                
            },
            
            close_inventory_items(product)
            {

                $("#InventoryItem").modal("hide");
                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove() ;
                
                this.form.product_details_arr[this.temp_product].product_code     =product.system_no;
                this.form.product_details_arr[this.temp_product].product_id       =product.id;
                this.form.product_details_arr[this.temp_product].item_name        =product.item_name;
                this.form.product_details_arr[this.temp_product].item_description =product.item_description;
                this.form.product_details_arr[this.temp_product].uom_string       =product.uom_string;
                this.form.product_details_arr[this.temp_product].qty              ="";
                this.form.product_details_arr[this.temp_product].rate             ="";
                this.form.product_details_arr[this.temp_product].addition         ="";
                this.form.product_details_arr[this.temp_product].qty              ="";
                this.form.product_details_arr[this.temp_product].deduction        ="";
                this.form.product_details_arr[this.temp_product].sub_total        ="";
                this.form.product_details_arr[this.temp_product].tax              ="";
                this.form.product_details_arr[this.temp_product].tax_rate         =product.tax;
                this.form.product_details_arr[this.temp_product].total            ="";

                let thistemp=this;

                if(thistemp.form.product_details_arr[thistemp.temp_product].addition_distribution.length<1)
                {
                    this.additional_charge_item.forEach(function(item,index){

                        thistemp.form.product_details_arr[thistemp.temp_product].addition_distribution.push({
                            'reference_id':item.id,
                            'reference_name':item.value,
                            'reference_value':0,
                        }); 
                    });
                }

                if(thistemp.form.product_details_arr[thistemp.temp_product].deduction_distribution.length<1)
                {
                    this.deduction_charge_item.forEach(function(item,index){

                        thistemp.form.product_details_arr[thistemp.temp_product].deduction_distribution.push({
                            'reference_id':item.id,
                            'reference_name':item.value,
                            'reference_value':0,
                        }); 
                    });
                }

                
            },
           
            fetchPurchaseOffers()
            {
               
                let uri = '/PurchaseOffers';
                window.axios.get(uri).then((response) => {
                    alert()
                    this.service_provider_arr                   =response.data.service_provider;
                    this.country_arr                            =response.data.country_arr; 
                    this.additional_charge_item                 =response.data.additional_charge_arr;
                    this.deduction_charge_item                  =response.data.deduction_charge_arr;

                    this.total_purchase_offer_qty               =response.data.total_purchase_offer_qty;
                    this.total_purchase_offer_acceptance_qty    =response.data.total_purchase_offer_acceptance_qty;
                    this.total_purchase_order_qty               =response.data.total_purchase_order_qty;
                    this.total_purchase_packaing_slip_qty       =response.data.total_purchase_packaing_slip_qty;
                    this.total_purchase_return_qty              =response.data.total_purchase_return_qty;
                    this.total_debit_note_qty                   =response.data.total_debit_note_qty;
                    this.total_credit_note_qty                  =response.data.total_credit_note_qty;
                    this.total_purchase_invoice_qty             =response.data.total_purchase_invoice_qty;
                    this.total_direct_payment_qty               =response.data.total_direct_payment_qty;
                    for(let i=0; i<response.data.additional_charge_arr.length; i++){
               
                        this.form.additional_charge_arr.push({
                            'id':'',
                            'reference_id':response.data.additional_charge_arr[i].id,
                            'reference_name':response.data.additional_charge_arr[i].value,
                            'amount':'',
                        });                         
                    }

                    for(let i=0; i<response.data.deduction_charge_arr.length; i++){
               
                        this.form.deduction_charge_arr.push({
                            'id':'',
                            'reference_id':response.data.deduction_charge_arr[i].id,
                            'reference_name':response.data.deduction_charge_arr[i].value,
                            'amount':'',
                        });                         
                    }  
 
                }); 
              


            },

            setProgressBar(curStep,steps){
                var percent = parseFloat(100 / steps) * curStep;
                this.percent = percent.toFixed();
            },


            browse_account_holder_info(type)
            {

                this.account_holder_type=type;
                if(type==102 || type==103) type=2;
                let uri = '/account_holder_by_type/'+type;
                window.axios.get(uri).then((response) => {

                    this.service_provider_arr                   =response.data.service_provider;

                });  
                $("#ServiceProvider").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show');
                
            },

            close_service_provider(service_provider)
            {
                $("#ServiceProvider").modal("hide");
                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove() ;
                if(this.account_holder_type==3)
                {
                    this.form.seller_name           =service_provider.register_corp_first_name+" "+service_provider.register_corp_middle_name+" "+service_provider.register_corp_last_name;
                    this.form.seller_account_no     =service_provider.system_no;
                    this.form.seller_id             =service_provider.id;
                    this.form.seller_contact_no     =service_provider.cell_phone;
                    this.form.seller_address        ="H-"+service_provider.house_number+", R-"+service_provider.street_number+", City-"+service_provider.city+", State-"+service_provider.state+", Zip-Code-"+service_provider.zip_code+", Country-"+this.country_arr[service_provider.country];
                   
                }
                else if(this.account_holder_type==2)
                {
                    this.form.service_provider_name           =service_provider.register_corp_first_name+" "+service_provider.register_corp_middle_name+" "+service_provider.register_corp_last_name;
                    this.form.service_provider_account_no     =service_provider.system_no;
                    this.form.service_provider_id             =service_provider.id;
                    this.form.service_provider_contact_no     =service_provider.cell_phone;
                    this.form.service_provider_address        ="H - "+service_provider.house_number+", R - "+service_provider.street_number+", City - "+service_provider.city+", State - "+service_provider.state+", Zip-Code - "+service_provider.zip_code+", Country - "+this.country_arr[service_provider.country];
                   
                }
                else if(this.account_holder_type==4)
                {
                    this.form.customer_name           =service_provider.register_corp_first_name+" "+service_provider.register_corp_middle_name+" "+service_provider.register_corp_last_name;
                    this.form.customer_account_no     =service_provider.system_no;
                    this.form.customer_id             =service_provider.id;
                    this.form.customer_contact_no     =service_provider.cell_phone;
                    this.form.customer_address        ="H - "+service_provider.house_number+", R - "+service_provider.street_number+", City - "+service_provider.city+", State - "+service_provider.state+", Zip-Code - "+service_provider.zip_code+", Country - "+this.country_arr[service_provider.country];
                   
                }
                else if(this.account_holder_type==102)
                {
                    this.form.shipping_company_name             =service_provider.register_corp_first_name+" "+service_provider.register_corp_middle_name+" "+service_provider.register_corp_last_name;
                    this.form.shipping_company_account_no       =service_provider.system_no;
                    this.form.shipping_company_id               =service_provider.id;
                    this.form.shipping_company_contact          =service_provider.cell_phone;
                    this.form.shipping_company_address          ="H - "+service_provider.house_number+", R - "+service_provider.street_number+", City - "+service_provider.city+", State - "+service_provider.state+", Zip-Code - "+service_provider.zip_code+", Country - "+this.country_arr[service_provider.country];
                   
                }

                else if(this.account_holder_type==103)
                {
                    this.form.driver_name             =service_provider.register_corp_first_name+" "+service_provider.register_corp_middle_name+" "+service_provider.register_corp_last_name;
                    this.form.driver_license_no       =service_provider.system_no;
                    this.form.driver_id               =service_provider.id;
                    this.form.driver_contact_no          =service_provider.cell_phone;
                    this.form.driver_address          ="H - "+service_provider.house_number+", R - "+service_provider.street_number+", City - "+service_provider.city+", State - "+service_provider.state+", Zip-Code - "+service_provider.zip_code+", Country - "+this.country_arr[service_provider.country];
                   
                }

                this.account_holder_type="";
                
            },

            AllEditPurchase(id)
            {
                if(this.purchase_page==1)
                {
                    this.editPurchaseOffers(id);
                }
                else if(this.purchase_page==2)
                {
                    this.editPurchaseOfferAcceptances(id);
                }
                else if(this.purchase_page==3)
                {
                    this.editPurchaseOrders(id);
                }
                else if(this.purchase_page==4)
                {
                    this.editPurchasePackingSlips(id);
                }
                else if(this.purchase_page==5)
                {
                    this.editPurchaseReturns(id);
                }
                else if(this.purchase_page==6)
                {
                    this.editPurchaseDebitNotes(id);
                }
                else if(this.purchase_page==7)
                {
                    this.editPurchaseCreditNotes(id);
                }
                else if(this.purchase_page==8)
                {
                    this.editPurchaseInvoices(id);
                }
                else if(this.purchase_page==9)
                {
                    this.editDirectPayments(id);
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
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
                    this.form.approval_date                    =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                    =response.data.purchase_offer_list.approval_time;
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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
            editPurchaseOrders(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchaseOrders/'+id+'/edit';
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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
            editPurchasePackingSlips(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchasePackingSlips/'+id+'/edit';
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
                    this.form.next_step                         =response.data.purchase_offer_list.next_step;
                    this.form.next_step_return                  =response.data.purchase_offer_list.next_step_return;
                    this.form.next_step_debit                   =response.data.purchase_offer_list.next_step_debit;
                    this.form.next_step_credit                  =response.data.purchase_offer_list.next_step_credit;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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
                    this.form.total_addition_charge           =response.data.total_addition_charge;
                    this.form.total_deduction_charge          =response.data.total_deduction_charge;
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

            editPurchaseReturns(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchaseReturns/'+id+'/edit';
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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

            editPurchaseDebitNotes(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchaseDebitNotes/'+id+'/edit';
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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

            editPurchaseCreditNotes(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchaseCreditNotes/'+id+'/edit';
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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

            editPurchaseInvoices(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PurchaseInvoices/'+id+'/edit';
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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
            editDirectPayments(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/DirectPayments/'+id+'/edit';
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

                    this.form.purchase_type                     =response.data.purchase_offer_list.purchase_type;
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
                    this.form.approval_date                     =response.data.purchase_offer_list.approval_date;
                    this.form.approval_time                     =response.data.purchase_offer_list.approval_time;
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
            reset_packaing_list()
            {

                this.form.reset();
                this.editmode=false;
                let uri = '/PurchasePackingSlipList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.purchase_offer_list;
                });
                this.list_showable=true;
            },

            reset_return_list()
            {

                this.form.reset();
                this.editmode=false;
                let uri = '/PurchaseReturnList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.purchase_offer_list;
                });
                this.list_showable=true;
            },
            reset_invoice_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/PurchaseInvoiceList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.purchase_offer_list;
                });
                this.list_showable=true;
            },
            reset_payment_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/DirectPaymentList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.purchase_offer_list;
                });
                this.list_showable=true;
            },

            reset_debit_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/PurchaseDebitList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.purchase_offer_list;
                });
                this.list_showable=true;
            },
            reset_credit_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/PurchaseCreditList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.purchase_offer_list;
                });
                this.list_showable=true;
            },

            show_hide_general_info(){
                if(this.general_info_show)
                {
                    this.general_info_show=false;
                }
                else{
                    this.general_info_show=true;
                }
                
            },

            show_hide_purchase_summery(){
                if(this.purchase_summery_show)
                {
                    this.purchase_summery_show=false;
                }
                else{
                    this.purchase_summery_show=true;
                }
                
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

                            if(this.purchase_page==1)
                            {
                                this.editPurchaseOffers(response_data[1]);
                            }
                            else if(this.purchase_page==2)
                            {
                                this.editPurchaseOfferAcceptances(response_data[1]);
                            }
                            else if(this.purchase_page==3)
                            {
                                this.editPurchaseOrders(response_data[1]);
                            }
                            else if(this.purchase_page==4)
                            {
                                this.editPurchasePackingSlips(response_data[1]);
                            }
                            else if(this.purchase_page==5)
                            {
                                this.editPurchaseReturns(response_data[1]);
                            }
                            else if(this.purchase_page==8)
                            {
                                this.editPurchaseInvoices(response_data[1]);
                            }
                            else if(this.purchase_page==9)
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
                            if(this.purchase_page==1)
                            {
                                this.editPurchaseOffers(response_data[1]);
                            }
                            else if(this.purchase_page==2)
                            {
                                this.editPurchaseOfferAcceptances(response_data[1]);
                            }
                            else if(this.purchase_page==3)
                            {
                                this.editPurchaseOrders(response_data[1]);
                            }
                            else if(this.purchase_page==4)
                            {
                                this.editPurchasePackingSlips(response_data[1]);
                            }
                            else if(this.purchase_page==5)
                            {
                                this.editPurchaseReturns(response_data[1]);
                            }
                            else if(this.purchase_page==6)
                            {
                                this.editPurchaseDebitNotes(response_data[1]);
                            }
                            else if(this.purchase_page==7)
                            {
                                this.editPurchaseCreditNotes(response_data[1]);
                            }
                            else if(this.purchase_page==8)
                            {
                                this.editPurchaseInvoices(response_data[1]);
                            }
                            else if(this.purchase_page==9)
                            {
                                this.editDirectPayments(response_data[1]);
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

                if(this.purchase_page==1)
                {
                    this.updatePurchaseOffers();
                }
                else if(this.purchase_page==2)
                {
                    this.updatePurchaseOfferAcceptances();
                }
                else if(this.purchase_page==3)
                {
                    this.updatePurchaseOrders();
                }
                else if(this.purchase_page==4)
                {
                    this.updatePurchasPackingSlips();
                }
                else if(this.purchase_page==5)
                {
                    this.updatePurchasReturns();
                }
                else if(this.purchase_page==6)
                {
                    this.updatePurchasDebitNotes();
                }
                else if(this.purchase_page==7)
                {
                    this.updatePurchasCreditNotes();
                }
                else if(this.purchase_page==8)
                {
                    this.updatePurchaseInvoices();
                }
                else if(this.purchase_page==9)
                {
                    this.updateDirectPayments();
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
            updatePurchasPackingSlips()
            { 
                
                 this.form.put('/PurchasePackingSlips/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        this.editPurchasePackingSlips(response_data[1]);
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

            updatePurchasReturns()
            { 
                
                 this.form.put('/PurchaseReturns/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        this.editPurchaseReturns(response_data[1]);
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

            updatePurchasDebitNotes()
            { 
                
                 this.form.put('/PurchaseDebitNotes/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        this.editPurchaseReturns(response_data[1]);
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
            updatePurchasCreditNotes()
            { 
                
                 this.form.put('/PurchaseCreditNotes/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        this.editPurchaseReturns(response_data[1]);
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

            updatePurchaseInvoices()
            { 
                
                this.form.put('/PurchaseInvoices/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                        toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        this.editPurchaseInvoices(response_data[1]);
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

            updateDirectPayments()
            { 
                
                this.form.put('/DirectPayments/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                        toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        this.editDirectPayments(response_data[1]);
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
                        
                        if(this.purchase_page==1)
                        {
                            this.editPurchaseOffers(response_data[1]);
                        }
                        else if(this.purchase_page==2)
                        {
                            this.editPurchaseOfferAcceptances(response_data[1]);
                        }
                        else if(this.purchase_page==3)
                        {
                            this.editPurchaseOrders(response_data[1]);
                        }
                        else if(this.purchase_page==4)
                        {
                            this.editPurchasePackingSlips(response_data[1]);
                        }
                        else if(this.purchase_page==5)
                        {
                            this.editPurchaseReturns(response_data[1]);
                        }
                        else if(this.purchase_page==6)
                        {
                            this.editPurchaseDebitNotes(response_data[1]);
                        }
                        else if(this.purchase_page==7)
                        {
                            this.editPurchaseCreditNotes(response_data[1]);
                        }
                        else if(this.purchase_page==8)
                        {
                            this.editPurchaseInvoices(response_data[1]);
                        }
                        else if(this.purchase_page==9)
                        {
                            this.editDirectPayments(response_data[1]);
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
                
                if(this.purchase_page==1)
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
                else if(this.purchase_page==2)
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
                else if(this.purchase_page==3)
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
                else if(this.purchase_page==4)
                {
                    let uri="/PurchasePackingSlips";
                    this.form.post(uri) .then(({ data }) => { 
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Save Successfully'
                            });

                            
                            this.editPurchasePackingSlips(response_data[1]);
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
                else if(this.purchase_page==5)
                {
                    let uri="/PurchaseReturns";
                    this.form.post(uri) .then(({ data }) => { 
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Save Successfully'
                            });

                            
                            this.editPurchaseReturns(response_data[1]);
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
                else if(this.purchase_page==6)
                {
                    let uri="/PurchaseDebitNotes";
                    this.form.post(uri) .then(({ data }) => { 
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Save Successfully'
                            });

                            
                            this.editPurchaseDebitNotes(response_data[1]);
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
                else if(this.purchase_page==7)
                {
                    let uri="/PurchaseCreditNotes";
                    this.form.post(uri) .then(({ data }) => { 
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Save Successfully'
                            });

                            
                            this.editPurchaseCreditNotes(response_data[1]);
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
                else if(this.purchase_page==8)
                {
                    let uri="/PurchaseInvoices";
                    this.form.post(uri) .then(({ data }) => { 
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Save Successfully'
                            });

                            
                            this.editPurchaseInvoices(response_data[1]);
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
                else if(this.purchase_page==9)
                {
                    let uri="/DirectPayments";
                    this.form.post(uri) .then(({ data }) => { 
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Save Successfully'
                            });

                            
                            this.editDirectPayments(response_data[1]);
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