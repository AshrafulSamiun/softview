<template>
     <fieldset>
            <h4 class="breadcumb"> Banks</h4>
            <p class="breadcumb-p">Profile/Standard/Account-Holder/Banks</p>
            <div class="text-right"> 
                <button 
                    :disabled="form.busy"  
                    type="button" 
                    class="btn  
                    btn-primary" 
                    style="min-width:110px" 
                    @click="reset_form()">Create New</button>

                <button 
                    :disabled="form.busy"  
                    type="button" 
                    class="btn  btn-primary" 
                    style="min-width:110px" 
                    @click="reset_list()">List</button>

            </div>

            <div class="text-center" v-if="!list_showable" style=" margin-top:20px">
                <button 
                    type="button" 
                    class=" btn-action-bar" 
                    :class="{ 'btn-action-bar-dissable': !data_entry, 'btn-action-bar': data_entry}"
                    @click="data_enty_show()">Data Entry </button>
              
                <button 
                    type="button" 
                    class=" btn-action-bar" 
                    :class="{ 'btn-action-bar-dissable': !save_btn, 'btn-action-bar': save_btn}"
                    @click="save_show()">Save
                </button>
                <button 
                    type="button" class=" btn-action-bar" 
                    :class="{ 'btn-action-bar-dissable': !approval_btn, 'btn-action-bar': approval_btn}"
                    @click="approval_show()" >Approval
                </button>
                <button 
                    type="button" 
                    :class="{ 'btn-action-bar-dissable': !print_btn, 'btn-action-bar': print_btn}" 
                    @click.prevent="btn_print()">Print
                </button>
               
                <button 
                    type="button" 
                    :class="{ 'btn-action-bar-dissable': !tool_btn, 'btn-action-bar': tool_btn}" 
                    @click="tools_show()" >Tools 
                </button>

                <button 
                    :class="{ 'btn-action-bar-dissable': !calendar_btn, 'btn-action-bar': calendar_btn}" 
                    type="button" 
                    @click="calendar_show()" >Calendar 
                </button>
                <button 
                    :class="{ 'btn-action-bar-dissable': !feature_btn, 'btn-action-bar': feature_btn}" 
                    type="button"  
                    @click="feature_show()">More Feature
                </button>

                <button 
                    :class="{ 'btn-action-bar-dissable': !posting_status_btn, 'btn-action-bar': posting_status_btn}"  
                    type="button" 
                    style="min-width:110px"  
                    @click="posting_status_show()" >Posting Status
                </button>

                <button 
                    :class="{ 'btn-action-bar-dissable': !favorite_btn, 'btn-action-bar': favorite_btn}"   
                    type="button"  
                    @click="favorite_show()">Favourits
                </button>

                <button    
                    :class="{ 'btn-action-bar-dissable': !contact_btn, 'btn-action-bar': contact_btn}"   
                    type="button" 
                    @click="contact_show()">Contact
                </button>
                <button 
                    :class="{ 'btn-action-bar-dissable': !trans_btn, 'btn-action-bar': trans_btn}"   
                    type="button" 
                    @click="tran_history_show()">Trans. History
                </button>
            </div>


            <div class="text-center" v-if="!list_showable" style=" margin-top:10px">

                <!-- ==============================Save Show =================== -->
                
                <button 
                    v-if="save_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="voided()">Auto Save
                </button>
                <button 
                    v-if="save_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="save_stay(3)">Save & New
                </button>

                <button 
                    v-if="save_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="save_stay(2)" >Save & Out 
                </button>

                <button 
                    v-if="save_btn" 
                    class=" btn-action-bar"   
                    type="button"  
                    @click="save_as_pdf()">Save as PDF
                </button>
            <!-- ==============================Print Show =================== -->

                <button
                    v-if="print_btn" 
                    type="button" 
                    class=" btn-action-bar" 
                    @click="print_priview()">Preview </button>
              
                <button 
                    v-if="print_btn"
                    type="button" 
                    class="btn-action-bar" 
                    @click="print_pdf()">Print
                </button>

                <!-- ==============================Tools Show =================== -->
                <button 
                    v-if="tool_btn"
                    type="button" 
                    class=" btn-action-bar" 
                    @click="approval_show()" >Copy
                </button>
                <button
                    v-if="tool_btn" 
                    class=" btn-action-bar"
                    type="button" 
                    @click.prevent="deleteAccountHolder()">Recurring
                </button>
               
                <button 
                    v-if="tool_btn" 
                    class=" btn-action-bar"
                    type="button" 
                    @click="transmit()" >Add to Batch 
                </button>

                <button 
                    v-if="tool_btn" 
                    class=" btn-action-bar"
                    type="button"  
                    @click="rejected()" >Memorized 
                </button>
                <button 
                    v-if="tool_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="voided()">Undo
                </button>

                <button 
                    v-if="tool_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="post()" >Redo
                </button>

                <button 
                    v-if="calendar_btn" 
                    class=" btn-action-bar"   
                    type="button"  
                    @click="adjust()">Auto Entry Date
                </button>

                <button    
                    v-if="calendar_btn" 
                    class=" btn-action-bar"   
                    type="button" 
                    @click="repost()">Sharing
                </button>
                <button 
                    v-if="calendar_btn" 
                    class=" btn-action-bar"   
                    type="button" 
                    @click="show_pdf()">Forwarding
                </button>


                <!-- Feature Button Here -->
                <button 
                    v-if="feature_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="voided()">Saved Trans. Expiry
                </button>

                <button 
                    v-if="feature_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="post()" >Redo
                </button>

                <button 
                    v-if="feature_btn" 
                    class=" btn-action-bar"   
                    type="button"  
                    @click="adjust()">Export
                </button>

                <button    
                    v-if="feature_btn" 
                    class=" btn-action-bar"   
                    type="button" 
                    @click="repost()">Reminder
                </button>
                <button 
                    v-if="feature_btn" 
                    class=" btn-action-bar"   
                    type="button" 
                    @click="show_pdf()">Approval Request
                </button>

                <!-- ==============================Posting Status =================== -->
                
                <button 
                    v-if="posting_status_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="voided()">Saved
                </button>
                <button 
                    v-if="posting_status_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="voided()">Transmited out
                </button>

                <button 
                    v-if="posting_status_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="post()" >Rejected
                </button>

                <button 
                    v-if="posting_status_btn" 
                    class=" btn-action-bar"   
                    type="button"  
                    @click="adjust()">Voided
                </button>

                <button    
                    v-if="posting_status_btn" 
                    class=" btn-action-bar"   
                    type="button" 
                    @click="repost()">Posted
                </button>
                <button 
                    v-if="posting_status_btn" 
                    class=" btn-action-bar"   
                    type="button" 
                    @click="show_pdf()">Adjusted
                </button>
                <button 
                    v-if="posting_status_btn" 
                    class=" btn-action-bar"   
                    type="button" 
                    @click="show_pdf()">Reposted
                </button>

                <!-- ==============================Posting Status =================== -->
                
                <button 
                    v-if="contact_btn" 
                    class="btn btn-action-bar"
                    type="button"   
                    @click="voided()">Email
                </button>
                <button 
                    v-if="contact_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="voided()">Discussion Board
                </button>

                <button 
                    v-if="contact_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="post()" >Call
                </button>

                <button 
                    v-if="contact_btn" 
                    class=" btn-action-bar"   
                    type="button"  
                    @click="adjust()">Video Call
                </button>

                <!-- ==============================Transaction History =================== -->
                
                <button 
                    v-if="trans_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="voided()">By User
                </button>
                <button 
                    v-if="trans_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="voided()">By Date
                </button>

                <button 
                    v-if="trans_btn" 
                    class=" btn-action-bar"
                    type="button"   
                    @click="post()" >By Posting Status 
                </button>

                <button 
                    v-if="trans_btn" 
                    class=" btn-action-bar"   
                    type="button"  
                    @click="adjust()">All
                </button>
            </div>

            <div v-if="list_showable" class="form-card">
                <div class="pull-left" style="margin:10px 0;">
                    <label for="filter" class="sr-only">Filter</label>
                    <input 
                        type="text" 
                        class="form-control table-filter" 
                        v-model="filter" 
                        placeholder="Filter">
                </div>
                <div class="pull-right" style="margin:10px 0;">
                    <button 
                        :disabled="form.busy"  
                        type="button" 
                        class="btn btn-light btn-print" 
                        style="min-width:90px" >
                        <span class="glyphicon glyphicon-export"></span>
                        Export
                    </button> 
                    <button 
                        :disabled="form.busy"  
                        type="button" 
                        class="btn btn-light btn-print" 
                        style="min-width:90px" >
                        <span class="glyphicon glyphicon-print"></span>
                        Print
                    </button> 
                </div>

                
                <vue3-datatable :rows="rows" :columns="columns" :columnFilter="false" :sortable="true" rowClass="cursor-pointer" class="advanced-table whitespace-nowrap">
                    <template #sl="data">
                        <strong class="text-info">{{ data.value.sl }}</strong>
                    </template>
                    <template #system_no="data">
                        <span class="font-semibold">{{ data.value.system_no }}</span>
                    </template>
                    <template #account_type_string="data">
                        <span class="font-semibold">{{ data.value.account_type_string }}</span>
                    </template>
                    <template #bank_acount_no="data">
                        <span class="font-semibold">{{ data.value.bank_acount_no }}</span>
                    </template>
                    <template #bank_account_name="data">
                        <span class="font-semibold">{{ data.value.bank_account_name }}</span>
                    </template>
                    <template #branch_name="data">
                        <span class="font-semibold">{{ data.value.branch_name }}</span>
                    </template>
                    <template #email="data">
                        <span class="font-semibold">{{ data.value.email }}</span>
                    </template>
                    <template #cell_phone="data">
                        <span class="font-semibold">{{ data.value.cell_phone }}</span>
                    </template>
                    <template #country_name="data">
                        <span class="font-semibold">{{ data.value.country_name }}</span>
                    </template>
                    <template #buttons="data">
                        <button 
                            class="btn " 
                            style="padding:.17rem .25rem" 
                            @click.prevent="editAccountHolder(data.value.id)">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <button  
                            class="btn "
                            style="padding:.17rem .25rem"
                            @click.prevent="deleteAccountHolder(data.value.id)">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                        <button  
                            class="btn "
                            style="padding:.17rem .15rem"
                            @click.prevent="deleteAccountHolder(data.value.id)">
                            <span class="glyphicon glyphicon-print"></span>
                        </button>
                    </template>
                </vue3-datatable>
            </div>
            <div class="card"> 
                <form 
                    id="msform" 
                    @submit.prevent="editmode ? updateAccountHolder() : createAccountHolder()" 
                    @keydown="form.onKeydown($event)">  
                   
                    <div id="content">

                        <div class="form-card" v-if="!list_showable">
                            <div class="form-folder" id="main_content">
                                <h3>Bank  Information:</h3>
                                <div class="form-holder" style="width:90%; padding-left:10%" >
                                    <div class="form-box-outer">
                                        <div class="row align-self-stretch">
                                            <div class="col-md-6  col-sm-6 col-xs-12"> 
                                                 
                                                <label class="fieldlabels ">ID No:</label> 
                                                <input type="text" 
                                                    id="system_no" 
                                                    name="system_no" 
                                                    v-model="form.system_no"  
                                                    placeholder="ID No" disabled/> 
                                                <label class="fieldlabels ">Bank Account No<span class="mandatory-field"> *</span>:</label>  
                                                    <input 
                                                    v-model="form.bank_acount_no" 
                                                    type="text" 
                                                    name="bank_acount_no" 
                                                    placeholder="Type Bank Account No" 
                                                    :class="{ 'is-invalid': form.errors.has('bank_acount_no') }"/>
                                                <has-error :form="form" field="bank_acount_no"></has-error> 

                                                <label class="fieldlabels ">Bank Name<span class="mandatory-field"> *</span>:</label>
                                                <input 
                                                    v-model="form.bank_account_name" 
                                                    type="text" 
                                                    name="bank_account_name" 
                                                    placeholder="Type Bank Name" 
                                                    :class="{ 'is-invalid': form.errors.has('bank_account_name') }"/>
                                                <has-error :form="form" field="bank_account_name"></has-error> 

                                                <label class="fieldlabels " >Branch Name<span class="mandatory-field"> *</span>:</label>  
                                                <input v-model="form.branch_name" 
                                                    type="text" 
                                                    placeholder="Type Branch Name"
                                                    name="branch_name" 
                                                    :class="{ 'is-invalid': form.errors.has('branch_name') }"/>
                                                  <has-error :form="form" field="branch_name"></has-error> 
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12"> 
                                                 
                                                <label class="fieldlabels ">Chart of Accounts<span class="mandatory-field"> *</span>:</label> 
                                                <input v-model="form.chart_of_acocounts" 
                                                    type="text" 
                                                    name="chart_of_acocounts" 
                                                    placeholder="Type Chart of Accounts" 
                                                    :class="{ 'is-invalid': form.errors.has('chart_of_acocounts') }"/>
                                                <has-error :form="form" field="chart_of_acocounts"></has-error> 
                                            
                                                
                                                <label class="fieldlabels ">Account Type
                                                    <span class="mandatory-field"> *</span>:
                                                </label> 
                                                <div class="position-relative form-group">
                                                    <select v-model="form.account_type"
                                                        name="account_type" 
                                                        class="custom-select" 
                                                        :class="{ 'is-invalid': form.errors.has('account_type') }">
                                                        <option disabled value="">--Select-- </option>
                                                        <option value="1">Checking</option>
                                                        <option value="2">Saving</option>  
                                                    </select>
                                                </div> 
                                                             
                                                <label class="fieldlabels ">Account Status
                                                    <span class="mandatory-field"> *</span>:
                                                </label> 
                                                <div class="position-relative form-group">
                                                    <select v-model="form.acount_status"
                                                        name="acount_status"
                                                        class="custom-select" 
                                                        :class="{ 'is-invalid': form.errors.has('acount_status') }">
                                                        <option disabled value="">--Select-- </option>
                                                        <option value="1">Active</option> 
                                                        <option value="2">Inactive</option> 
                                                    </select>
                                                    <has-error :form="form" field="acount_status"></has-error> 
                                                </div>   
                                                
                                            </div>
                                        </div>
                                        <div class="row align-self-stretch"> 
                                        
                                            <div class="col-md-6  col-sm-6 col-xs-12">
                                                <div class="form-box-outer" style="padding:0">  

                                                    <h3 style="margin-top:0 !important">Address</h3>

                                                    <div class="row" style="padding: 20px 20px 10px;">

                                                        <div class="col-md-12 col-sm-12 col-xs-12">

                                                            <label class="fieldlabels ">Number<span class="mandatory-field"> *</span>:</label> 
                                                            <input v-model="form.house_number" 
                                                                type="phone" 
                                                                name="house_number" 
                                                                placeholder="Type House/Office Number" 
                                                                :class="{ 'is-invalid': form.errors.has('house_number') }"/>
                                                            <has-error :form="form" field="house_number"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Street Number<span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input v-model="form.street_number" 
                                                                type="text" 
                                                                name="street_number" 
                                                                placeholder="Type Street Number" 
                                                                :class="{ 'is-invalid': form.errors.has('street_number') }"/>
                                                            <has-error :form="form" field="street_number"></has-error> 
                                                        </div>
                                                        
                                                        <div class="col-md-12 col-sm-6 col-xs-12">

                                                            <label class="fieldlabels ">
                                                                City<span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input v-model="form.city" 
                                                                type="text" 
                                                                name="city" 
                                                                placeholder="Type City" 
                                                                :class="{ 'is-invalid': form.errors.has('city') }"/>
                                                            <has-error :form="form" field="city"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">

                                                            <label class="fieldlabels ">
                                                                State<span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input v-model="form.state" 
                                                                type="text" 
                                                                name="state" 
                                                                placeholder="Type State" 
                                                                :class="{ 'is-invalid': form.errors.has('state') }"/>
                                                            <has-error :form="form" field="state"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Country<span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <div class="position-relative form-group">
                                                                 <select v-model="form.country"
                                                                    name="country"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('country') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Zip Code/ Postal Code<span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input v-model="form.zip_code" 
                                                                type="phone" 
                                                                name="zip_code" 
                                                                placeholder="Type Zip Code/ Postal Code" 
                                                                :class="{ 'is-invalid': form.errors.has('zip_code') }"/>
                                                            <has-error :form="form" field="zip_code"></has-error> 
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-box-outer" style="padding:0"> 
                                                    <h3 style="margin-top:0 !important">Contact</h3>  
                                                    <div class="row" style="padding: 20px 20px 10px;"> 
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Office Phone<span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input 
                                                                v-model="form.office_phone" 
                                                                type="text" 
                                                                name="office_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('office_phone') }"/>
                                                            <has-error :form="form" field="office_phone"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Moblile Number
                                                                <span class="mandatory-field"> *</span>:
                                                            </label> 
                                                           <input 
                                                                v-model="form.cell_phone" 
                                                                type="text" 
                                                                name="cell_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('cell_phone') }"/>
                                                            <has-error :form="form" field="cell_phone"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Email<span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input v-model="form.email" 
                                                                type="email" 
                                                                name="email" 
                                                                :class="{ 'is-invalid': form.errors.has('email') }"/>
                                                            <has-error :form="form" field="email"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Fax
                                                                <span class="mandatory-field"> *</span>:

                                                            </label> 
                                                            <input 
                                                                v-model="form.fax_no" 
                                                                type="text" 
                                                                name="fax_no" 
                                                                :class="{ 'is-invalid': form.errors.has('fax_no') }"/>
                                                            <has-error :form="form" field="fax_no"></has-error> 
                                                        </div>
                                                        
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Website 
                                                                <span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input v-model="form.website" 
                                                                type="url" 
                                                                name="website" 
                                                                :class="{ 'is-invalid': form.errors.has('website') }"/>
                                                            <has-error :form="form" field="website"></has-error>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-self-stretch">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="fieldlabels ">Comment :</label> 
                                                <input 
                                                    v-model="form.comments" 
                                                    type="text" 
                                                    name="comments"
                                                    style="min-height:100px" 
                                                    placeholder="Type Comment" 
                                                    :class="{ 'is-invalid': form.errors.has('comments') }"/>
                                                <has-error :form="form" field="comments"></has-error> 
                                            </div>
                                            
                                        </div>
                                    </div>
                               
                                    
                                </div>
                            </div> 
                           

                            <div class="text-right" v-if="!list_showable" style=" margin-top:40px">
                                <button 
                                    v-if="data_entry"
                                    :disabled="form.busy || editmode==false"  type="button" class="btn btn-sm btn-primary" 
                                    style="min-width:70px" 
                                    @click="reset_form()">New </button>
                              
                                <button 
                                    v-if="data_entry"
                                    :disabled="form.busy || editmode==true || form.posting_status!=0 "  
                                    type="button" 
                                    class="btn btn-sm  btn-primary" 
                                    style="min-width:70px"  
                                    @click="save_stay(1)">Save</button>

                                <button 
                                    v-if="data_entry"
                                    :disabled="form.busy || editmode==false || form.posting_status!=0"  
                                    type="submit" 
                                    class="btn btn-sm  btn-primary" 
                                    style="min-width:70px" >Update</button>

                                <button 
                                    v-if="data_entry"
                                    :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" 
                                    class="btn btn-sm  btn-primary" 
                                    style="min-width:70px"  @click.prevent="deleteAccountHolder()">Delete</button>
                               
                                <button 
                                    v-if="data_entry"
                                    :disabled="form.busy || editmode==false || form.posting_status!=0" 
                                    type="button" 
                                    class="btn btn-sm  btn-primary" 
                                    style="min-width:70px"  
                                    @click="transmit()" >Transmit </button>

                                <button 
                                    v-if="approval_btn"
                                    :disabled="form.busy || editmode==false  || user_type!=9 || form.posting_status!=1"  
                                    type="button" 
                                    class="btn btn-sm  btn-primary" 
                                    style="min-width:70px"  
                                    @click="rejected()" >Reject </button>
                                <button 
                                    v-if="approval_btn"
                                    :disabled="form.busy || editmode==false  || user_type!=9 || form.posting_status!=1"  
                                    type="button" 
                                    class="btn btn-sm  btn-primary" 
                                    style="min-width:70px"  
                                    @click="voided()">Void</button>

                                <button 
                                    v-if="approval_btn"
                                    :disabled="form.busy || editmode==false || user_type!=9 || form.posting_status!=1"  
                                    type="button" 
                                    class="btn btn-sm btn-primary" 
                                    style="min-width:110px"  
                                    @click="post()" >Post </button>

                                <button
                                    v-if="approval_btn" 
                                    :disabled="form.busy || form.posting_status<2 || user_type!=9"  type="button" 
                                    class="btn btn-sm  btn-primary" 
                                    style="min-width:70px"  
                                    @click="adjust()">Adjust</button>

                                <button 
                                    v-if="approval_btn"
                                    :disabled="form.busy || form.posting_status!=3 || user_type!=9"  type="button" 
                                    class="btn btn-sm  btn-primary" 
                                    style="min-width:70px" 
                                    @click="repost()">Repost</button>
                             
                            </div> 
                        </div> 
                    </div> 
                     
                </form>
            </div> 
    </fieldset> 
</template>
<style>



</style>

<script>
    import { ref } from "vue";
    import Vue3Datatable from "@bhplugin/vue3-datatable";
    import "@bhplugin/vue3-datatable/dist/style.css";
    import Vue3datepicker from "vue3-datepicker";
    import html2pdf from "html2pdf.js";
    
    //import jsPDF  from "jspdf";

    export default {
        name:'list-product-categories',
        components:{
            Vue3datepicker,
            Vue3Datatable
        },
        data(){
            return{
                editmode       :false,
                filter         : '',
                data_entry     :true,
                approval_btn   :false,
                save_btn       :false,
                print_btn      :false,
                tool_btn       :false,
                calendar_btn   :false,
                feature_btn    :false,
                posting_status_btn       :false,
                favorite_btn   :false,
                contact_btn    :false,
                trans_btn      :false,
                list_showable  :false,
                form:new Form({ 
                    system_no:'',
                    account_type:'', 
                    bank_acount_no:'',
                    bank_account_name:'',
                    branch_name:'',
                    chart_of_acocounts:'',
                    account_creation_date:'',
                    acount_status:'',
                    comments:'', 
                    house_number:'',
                    street_number:'',
                    city:'',
                    state:'',
                    country:'',
                    zip_code:'',
                    email:'',
                    fax_no:'',
                    cell_phone:'',
                    website:'',
                    id:'', 
                    posting_status:'', 
                }),
                countries:'',
                user_type:'',
                columns: ref([
                    { title: 'SL', field: 'sl', align: 'center' },
                    { title: 'System No', field: 'system_no' },
                    { title: 'Account Type', field: 'account_type_string' },
                    { title: 'Bank Acccount No', field: 'bank_acount_no' },
                    { title: 'Bank Acccount Name', field: 'bank_account_name' },
                    { title: 'Branch Name', field: 'branch_name' },  
                    { title: 'Email', field: 'email' },
                    { title: 'Mobile No', field: 'cell_phone' },
                    { title: 'Country', field: 'country_name' }, 
                    { title: 'Action', field: 'buttons', sortable: false },
                ]),
                rows: [],
                page: 1,
                per_page:15,
                expanded: null
      
            }
        },
        
        created: function()
        {
            
            this.user_menu_name = this.$route.name;
            this.fetchAccountHolder();
          // this.fetchAccountHolderUpdate(23);

           
        },
        
        methods: {
            save_as_pdf(){
                const element = document.getElementById("main_content");
                const options = {
                    margin: 1,
                    filename: "output.pdf",
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
                };
                html2pdf().set(options).from(element).save();
            },
            print_priview()
            {
                let uri = '/AccountHoldersBank/'+this.form.id;
                window.axios.get(uri).then((response) => {
                    //this.previous_receive_arr  =response.data;
        
                    var w = window.open("Surprise", "#");
                    var d = w.document.open();
                    d.write(response.data);                 
                    d.close();
                });

            },
            print_pdf()
            {
                fetch("AccountHoldersBank/"+this.form.id)
                    .then((response) => response.blob())
                    .then((blob) => {
                      const url = window.URL.createObjectURL(blob);
                      const a = document.createElement("a");
                      a.href = url;
                      a.download = "generated.pdf";
                      a.click();
                    });
            },

            
            approval_show()
            {
                if(this.approval_btn) this.approval_btn=false;
                else 
                {
                    this.data_entry         =false;
                    this.approval_btn       =true;
                    this.save_btn           =false;
                    this.print_btn          =false;
                    this.tool_btn           =false;
                    this.calendar_btn       =false;
                    this.feature_btn        =false;
                    this.posting_status_btn =false;
                    this.favorite_btn       =false;
                    this.contact_btn        =false;
                    this.trans_btn          =false;
                }
            },
            btn_print()
            {
                if(this.print_btn) this.print_btn=false;
                else 
                {
                    this.save_btn       =false;
                    this.print_btn      =true;
                    this.tool_btn       =false;
                    this.calendar_btn   =false;
                    this.feature_btn    =false;
                    this.post_btn       =false;
                    this.favorite_btn   =false;
                    this.contact_btn    =false;
                    this.trans_btn      =false;
                }
            },

            data_enty_show()
            {
                if(this.data_entry) this.data_entry=false;
                else 
                {
                    this.data_entry         =true;
                    this.approval_btn       =false;
                    this.save_btn           =false;
                    this.print_btn          =false;
                    this.tool_btn           =false;
                    this.calendar_btn       =false;
                    this.feature_btn        =false;
                    this.posting_status_btn =false;
                    this.favorite_btn       =false;
                    this.contact_btn        =false;
                    this.trans_btn          =false;
                }
                
            },


            save_show()
            {
                if(this.save_btn) this.save_btn=false;
                else 
                {
                    this.save_btn           =true;
                    this.print_btn          =false;
                    this.tool_btn           =false;
                    this.calendar_btn       =false;
                    this.feature_btn        =false;
                    this.posting_status_btn =false;
                    this.favorite_btn       =false;
                    this.contact_btn        =false;
                    this.trans_btn          =false;
                }
            },
            tools_show()
            {
                if(this.tool_btn) this.tool_btn=false;
                else 
                {
                    this.save_btn           =false;
                    this.print_btn          =false;
                    this.tool_btn           =true;
                    this.calendar_btn       =false;
                    this.feature_btn        =false;
                    this.posting_status_btn =false;
                    this.favorite_btn       =false;
                    this.contact_btn        =false;
                    this.trans_btn          =false;
                }
            },

            calendar_show()
            {
                if(this.calendar_btn) this.calendar_btn=false;
                else 
                {
                    this.save_btn           =false;
                    this.print_btn          =false;
                    this.tool_btn           =false;
                    this.calendar_btn       =true;
                    this.feature_btn        =false;
                    this.posting_status_btn =false;
                    this.favorite_btn       =false;
                    this.contact_btn        =false;
                    this.trans_btn          =false;
                }
            },
            favorite_show()
            {
                if(this.favorite_btn) this.favorite_btn=false;
                else 
                {
                    this.save_btn           =false;
                    this.print_btn          =false;
                    this.tool_btn           =false;
                    this.calendar_btn       =false;
                    this.feature_btn        =false;
                    this.posting_status_btn =false;
                    this.favorite_btn       =true;
                    this.contact_btn        =false;
                    this.trans_btn          =false;
                }
            },
            posting_status_show()
            {
                if(this.posting_status_btn) this.posting_status_btn=false;
                else 
                {
                    this.save_btn           =false;
                    this.print_btn          =false;
                    this.tool_btn           =false;
                    this.calendar_btn       =false;
                    this.feature_btn        =false;
                    this.posting_status_btn =true;
                    this.favorite_btn       =false;
                    this.contact_btn        =false;
                    this.trans_btn          =false;
                }
            },
            feature_show()
            {
                if(this.feature_btn) this.feature_btn=false;
                else 
                {
                    this.save_btn           =false;
                    this.print_btn          =false;
                    this.tool_btn           =false;
                    this.calendar_btn       =false;
                    this.feature_btn        =true;
                    this.posting_status_btn =false;
                    this.favorite_btn       =false;
                    this.contact_btn        =false;
                    this.trans_btn          =false;
                }
            },
            contact_show()
            {
                if(this.contact_btn) this.contact_btn=false;
                else 
                {
                    this.save_btn           =false;
                    this.print_btn          =false;
                    this.tool_btn           =false;
                    this.calendar_btn       =false;
                    this.feature_btn        =false;
                    this.posting_status_btn =false;
                    this.favorite_btn       =false;
                    this.contact_btn        =true;
                    this.trans_btn          =false;
                }
            },

            tran_history_show()
            {
                if(this.trans_btn) this.trans_btn=false;
                else 
                {
                    this.save_btn           =false;
                    this.print_btn          =false;
                    this.tool_btn           =false;
                    this.calendar_btn       =false;
                    this.feature_btn        =false;
                    this.posting_status_btn =false;
                    this.favorite_btn       =false;
                    this.contact_btn        =false;
                    this.trans_btn          =true;
                }
            },
            
            
            reset_form()
            {

                this.form.reset ();
                this.editmode=false;
                this.list_showable=false;
                this.fetchAccountHolder();
                
            },
            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/AccountHolderBankLists';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.account_holder_list;
                });
                this.list_showable=true;
            }, 

            fetchAccountHolder()
            {
                let uri = '/AccountHoldersBank';
                window.axios.get(uri).then((response) => {
                    
                    this.countries                                =response.data.country_arr;
                    this.user_type                                =response.data.user_type;
                    this.editmode=false;  
                }); 

                
            },
         
       

            updateAccountHolder()
            {
                
                this.form.put('/AccountHoldersBank/'+this.form.id).then(({ data })=>{
                        var response_data=data.split("**");
                       // alert(response_data[0])
                        if(response_data[0]*1==1)
                        {
                           
                            showToast('Data Update Successfully', 'success');
                            this.editAccountHolder(response_data[1]);
                            this.editmode=true;

                        }
                        else{

                            showToast('Invalid Operation', 'error');
                        }
                    })
                    .catch(()=>{
                       showToast("there was some wrong","warning");
                
                    });
            },


            
            createAccountHolder()
            {

                this.form.post('/AccountHoldersBank') .then(({ data }) => { 
                                 
                    showToast('Data Save Successfully', 'success');
                    this.form.reset ();
                    this.fetchAccountHolder();
                })
            },


            save_stay(type){

                this.form.post('/AccountHoldersBank') .then(({ data }) => { 
                    var response_data=data.split("**");

                   
                        if (response_data[0] * 1 == 1) {
                            showToast('Data Save Successfully', 'success');

                            if (type == 1) {
                                this.fetchAccountHolder(response_data[1]);
                                this.editmode = true;
                            } else if (type == 2) {
                                window.location.href = '/Dashboard';

                            } else if (type == 3) {
                                this.form.reset();
                                this.fetchAccountHolder();
                            }
                            } else if (response_data[0] * 1 == 10) {
                                showToast("Please open the 'Open File' ", 'error');
                        } else {

                            showToast('Invalid Operation', 'error');
                        }
                    
                   
                    
                })
            },
            deleteAccountHolder()
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

                      this.form.delete('/AccountHoldersBank/'+this.form.id).then(()=>{
                        
                          if(result.value) {
                               showAlert(
                                'Deleted!',
                                'Your Bank has been deleted.',
                                'success'
                              );
                             this.form.reset();
                             this.fetchAccountHolder();
                          }            

                      }).catch(()=>{

                        showAlert("failed!","there was some wrong","warning");
                  });
               
              })
            },
            

            transmit()
            { 
                this.form.posting_status=1;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Transmit it!'
                }).then((result) => {

                    this.form.post('/AccountHoldersBankPost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            showAlert(
                                'Transmited!',
                                'Your Data has been Transmited.',
                                'success'
                            );

                            this.editAccountHolder(response_data[1]);
                    
                        }            

                    }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                    });
                    
                })
                
            },
            rejected()
            { 
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Reject it!'
                }).then((result) => {

                    this.form.post('/AccountHoldersBankReject/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            showAlert(
                                'Rejected!',
                                'Your Data has been Rejected.',
                                'success'
                            );
                            this.editUserPrivilege(response_data[1]);
                        }            

                    }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                    });
                    
                })
                
            },

            voided()
            {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Void it!'
                }).then((result) => {

                    this.form.post('/AccountHoldersBankVoid/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            showAlert(
                                'Void!',
                                'Your Data has been Voided.',
                                'success'
                            );

                            this.editAccountHolder(response_data[1]);
                    
                        }            

                    }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                    });
                    
                })
            },
            post()
            { 
                this.form.posting_status=2;
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Post it!'
                }).then((result) => {

                    this.form.post('/AccountHoldersBankPost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            showAlert(
                                'Posted!',
                                'Your Data has been Posted.',
                                'success'
                            );

                            this.editAccountHolder(response_data[1]);
                    
                        }            

                    }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
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


                    this.form.post('/AccountHoldersBankRepost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            showAlert(
                                'Posted!',
                                'Your Data has been Reposted.',
                                'success'
                            );
                            
                            this.editAccountHolder(response_data[1]);
                        }            

                    }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                    });
                    
                })
                
            },

            adjust()
            { 
                
                this.form.post('/adjustAccountHoldersBank/'+this.form.id).then((response)=>{
                    var response_data=response.data.split("**");
                    if(response_data[0]==1)
                    {
                        showToast('Data Update Successfully', 'success');
                        
                        this.editAccountHolder(response_data[1]);
                        
                        this.editmode=true;
                    }
                    else{

                        showToast('Invalid Operation', 'error');
                    }
                }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                    });             
                
            },
            editAccountHolder(id)
            {


                this.form.reset();
                this.list_showable=false;
                let uri = '/AccountHoldersBank/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.user_type=response.data.user_type;
                    this.form.id=response.data.account_holder.id;
                    this.form.posting_status=response.data.account_holder.posting_status;
                    this.form.system_no=response.data.account_holder.system_no;
                    this.form.account_type=response.data.account_holder.account_type;

                    this.form.house_number=response.data.account_holder.house_number;
                    this.form.street_number=response.data.account_holder.street_number;
                    this.form.city=response.data.account_holder.city;
                    this.form.state=response.data.account_holder.state;
                    this.form.country=response.data.account_holder.country;
                    this.form.zip_code=response.data.account_holder.zip_code;
                    this.form.email=response.data.account_holder.email;
                    this.form.fax_no=response.data.account_holder.fax_no;
                    this.form.cell_phone=response.data.account_holder.cell_phone;
                    this.form.website=response.data.account_holder.website;
                    this.form.office_phone=response.data.account_holder.office_phone;


                    this.form.bank_acount_no=response.data.account_holder.bank_acount_no;
                    this.form.bank_account_name=response.data.account_holder.bank_account_name;
                    this.form.branch_name=response.data.account_holder.branch_name;
                    this.form.chart_of_acocounts=response.data.account_holder.chart_of_acocounts;
                    this.form.acount_status=response.data.account_holder.acount_status; 
                    this.form.comments=response.data.account_holder.comments;                    
                    this.countries                                =response.data.country_arr;
                    this.editmode=true;
                    
                }); 

                
            },


        }
    
    }  
    
</script>



