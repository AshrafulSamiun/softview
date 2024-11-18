<template>

   
    <div class="card"> 
        <form id="msform" @submit.prevent="editmode ? updateAccountHolder() : createAccountHolder()" @keydown="form.onKeydown($event)">  
            <fieldset>
                <div id="content">
                    <div class="form-card">
                        <h1 class="page-head">Parker  Profile</h1> 
                        <div class="text-center">


                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_list()">List</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>


                        </div>
                        
                        
                    </div>
                    <div v-if="list_showable" class="form-card">
                        <div class="pull-left" style="margin-top:50px;">
                            <label for="filter" class="sr-only">Filter</label>
                            <input type="text" class="form-control" v-model="filter" placeholder="Filter" style="width:400px;">
                        </div>
                        <datatable :columns="columns" :data="rows" :filter-by="filter">
                            <template slot-scope="{row}">
                                <tr>  
                                    <td>{{ row.sl }}</td>
                                    <td>{{ row.system_no }}</td>
                                    <td>{{ row.account_type_string }}</td>
                                    <td>{{ row.parker_name }}</td>
                                    <td>{{ row.company_name }}</td>
                                    <td>{{ row.parker_email }}</td>
                                    <td>{{ row.parker_cell_phone }}</td>
                                    <td>{{ row.parker_country }}</td>
                                    <td>{{ row.industry_sector }}</td>
                                    <td width="120">
                                        <button class="btn btn-primary btn-sm"  @click.prevent="editAccountHolder(row.id)">Edit</button>
                                        <button  class="btn btn-danger btn-sm" @click.prevent="deleteAccountHolder(row.id)">Delete</button>
                                    </td>
                                </tr>
                            </template>
                        </datatable>
                        <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
                    </div>
                    <div class="form-card" v-if="!list_showable">
                        <div class="form-folder">
                            <h3><i class="fa fa-hand-point-right"></i>Parker  Information:</h3> 
                            <div class="form-holder">
                                <div class="row align-self-stretch"> 
                                    <div class="col-md-4 col-sm-6 col-xs-12"> 
                                        <div class="form-box-outer"> 
                                            <label class="fieldlabels">ID No:</label> 
                                            <input type="text" 
                                                id="system_no" 
                                                name="system_no" 
                                                v-model="form.system_no"  
                                                placeholder="ID No" disabled/> 
                                            <label class="fieldlabels">Parker Type:</label> 
                                            <div class="position-relative form-group">
                                                        <select v-model="form.parker_type"
                                                            name="parker_type"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('parker_type') }">
                                                            <option disabled value="">--Select-- </option>
                                                            <option value="1">Resident</option> 
                                                            <option value="2">Non Resident</option> 
                                                        </select>
                                                        <has-error :form="form" field="parker_type"></has-error> 
                                                    </div>  
                                            <label class="fieldlabels">Account Type:</label> 
                                            <div class="position-relative form-group">
                                                 <select v-model="form.account_type"
                                                    name="account_type" 
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('account_type') }" disabled>
                                                    <option disabled value="">--Select-- </option>
                                                    <option v-for="(account_holder, index) in account_holder_arr" :value="index">{{account_holder}}</option> 
                                                </select>
                                            </div> 
                                            <h4>Personal Information</h4> 
                                            <label class="fieldlabels">Parker  Title:</label>
                                            <input 
                                                v-model="form.account_holder_title_name" 
                                                type="text" 
                                                name="account_holder_title_name" 
                                                placeholder="Type parker Name" 
                                                :class="{ 'is-invalid': form.errors.has('account_holder_title_name') }"/>
                                            <has-error :form="form" field="account_holder_title_name"></has-error>  
                                            <label class="fieldlabels">Parker  Name:</label>
                                            <input 
                                                v-model="form.parker_name" 
                                                type="text" 
                                                name="parker_name" 
                                                placeholder="Type parker Name" 
                                                :class="{ 'is-invalid': form.errors.has('parker_name') }"/>
                                            <has-error :form="form" field="parker_name"></has-error> 
                                            <label class="fieldlabels">Parker   Photo:</label> 
                                            <input 
                                                v-model="form.parker_photo" 
                                                type="text" 
                                                name="parker_photo" 
                                                placeholder="Type Photo" 
                                                :class="{ 'is-invalid': form.errors.has('parker_photo') }"/>
                                            <has-error :form="form" field="parker_photo"></has-error> 
                                           
                                                        <h4>Parker  Contact</h4> 
                                                            <label class="fieldlabels">Office Phone:</label> 
                                                           <input v-model="form.parker_office_phone" 
                                                                type="text" 
                                                                name="parker_office_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('parker_office_phone') }"/>
                                                                 <has-error :form="form" field="parker_office_phone"></has-error>
                                                        
                                                         
                                                            <label class="fieldlabels">Moblile Number:</label> 
                                                           <input v-model="form.parker_cell_phone" 
                                                                type="text" 
                                                                name="parker_cell_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('parker_cell_phone') }"/>
                                                                 <has-error :form="form" field="parker_cell_phone"></has-error>
                                                         
                                                            <label class="fieldlabels">Email:</label> 
                                                            <input v-model="form.parker_email" 
                                                                type="parker_email" 
                                                                name="parker_email" 
                                                                :class="{ 'is-invalid': form.errors.has('parker_email') }"/>
                                                                 <has-error :form="form" field="parker_email"></has-error>
                                                        
                                                            <label class="fieldlabels">Fax:</label> 
                                                            <input v-model="form.parker_fax_no" 
                                                                type="text" 
                                                                name="parker_fax_no" 
                                                                :class="{ 'is-invalid': form.errors.has('parker_fax_no') }"/>
                                                                 <has-error :form="form" field="parker_fax_no"></has-error> 
                                                        
                                                            <label class="fieldlabels">Website :</label> 
                                                            <input v-model="form.parker_website" 
                                                                type="url" 
                                                                name="parker_website" 
                                                                :class="{ 'is-invalid': form.errors.has('parker_website') }"/>
                                                                 <has-error :form="form" field="parker_website"></has-error>
                                             


                                                        <h4>Parker  Address</h4> 
                                                            <label class="fieldlabels"> House Number:</label> 
                                                            <input v-model="form.parker_house_number" 
                                                                type="phone" 
                                                                name="parker_house_number" 
                                                                placeholder="Type  House/Office Number" 
                                                                :class="{ 'is-invalid': form.errors.has('parker_house_number') }"/>
                                                                 <has-error :form="form" field="parker_house_number"></has-error> 
                                                        
                                                         
                                                            <label class="fieldlabels"> Street Number:</label> 
                                                            <input v-model="form.parker_street_number" 
                                                                type="text" 
                                                                name="parker_street_number" 
                                                                placeholder="Type  Street Number" 
                                                                :class="{ 'is-invalid': form.errors.has('parker_street_number') }"/>
                                                                 <has-error :form="form" field="parker_street_number"></has-error> 
                                                       
                                                        
                                                        
                                                            <label class="fieldlabels"> City:</label> 
                                                            <input v-model="form.parker_city" 
                                                                type="text" 
                                                                name="parker_city" 
                                                                placeholder="Type  City" 
                                                                :class="{ 'is-invalid': form.errors.has('parker_city') }"/>
                                                                 <has-error :form="form" field="parker_city"></has-error> 
                                                        
                                                        
                                                            <label class="fieldlabels"> State:</label> 
                                                            <input v-model="form.parker_state" 
                                                                type="text" 
                                                                name="parker_state" 
                                                                placeholder="Type  State" 
                                                                :class="{ 'is-invalid': form.errors.has('parker_state') }"/>
                                                                 <has-error :form="form" field="parker_state"></has-error>
                                                        
                                                        
                                                            <label class="fieldlabels">Country:</label> 
                                                            <div class="position-relative form-group">
                                                                 <select v-model="form.parker_country"
                                                                    name="parker_country"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('parker_country') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                                </select>
                                                            </div>
                                                            <label class="fieldlabels"> Zip Code/ Postal Code:</label> 
                                                            <input v-model="form.parker_zip_code" 
                                                                type="phone" 
                                                                name="zip_code" 
                                                                placeholder="Type Zip Code/ Postal Code" 
                                                                :class="{ 'is-invalid': form.errors.has('parker_zip_code') }"/>
                                                                 <has-error :form="form" field="parker_zip_code"></has-error> 
                                                       

   
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-box-outer"> 
                                            <h4>Company Information</h4> 
                                            <label class="fieldlabels" >Company Name:</label>  
                                            <input v-model="form.company_name" 
                                                type="text" 
                                                placeholder="Type Company Name"
                                                name="company_name" 
                                                :class="{ 'is-invalid': form.errors.has('company_name') }"/>
                                              <has-error :form="form" field="company_name"></has-error>  

                                            <label class="fieldlabels">Company Logo:</label> 
                                            <input 
                                                v-model="form.company_logo" 
                                                type="text" 
                                                name="company_logo" 
                                                placeholder="Type Company Logo" 
                                                :class="{ 'is-invalid': form.errors.has('company_logo') }"/>
                                            <has-error :form="form" field="company_logo"></has-error>  
                                                <label class="fieldlabels" >Industry Sector:</label>       
                                                    <div class="position-relative form-group">
                                                        <select v-model="form.industry_sector"
                                                            name="industry_sector"
                                                            class="custom-select"  
                                                            :class="{ 'is-invalid': form.errors.has('industry_sector') }">
                                                            <option disabled value="">--Select-- </option>
                                                            <option v-for="(industry_sector,index) in industry_sector_arr" :value="index" >{{industry_sector}}</option>
                                                            <option  value="add">Other ( Please specify )</option>
                                                        </select>

                                                    </div>


                                                         <h4>Company Address</h4> 
                                                            <label class="fieldlabels"> House Number:</label> 
                                                            <input v-model="form.company_house_number" 
                                                                type="phone" 
                                                                name="company_house_number" 
                                                                placeholder="Type  House/Office Number" 
                                                                :class="{ 'is-invalid': form.errors.has('company_house_number') }"/>
                                                                 <has-error :form="form" field="company_house_number"></has-error> 
                                                        
                                                         
                                                            <label class="fieldlabels"> Street Number:</label> 
                                                            <input v-model="form.company_street_number" 
                                                                type="text" 
                                                                name="company_street_number" 
                                                                placeholder="Type  Street Number" 
                                                                :class="{ 'is-invalid': form.errors.has('company_street_number') }"/>
                                                                 <has-error :form="form" field="company_street_number"></has-error> 
                                                       
                                                        
                                                        
                                                            <label class="fieldlabels"> City:</label> 
                                                            <input v-model="form.company_city" 
                                                                type="text" 
                                                                name="company_city" 
                                                                placeholder="Type  City" 
                                                                :class="{ 'is-invalid': form.errors.has('company_city') }"/>
                                                                 <has-error :form="form" field="company_city"></has-error> 
                                                        
                                                        
                                                            <label class="fieldlabels"> State:</label> 
                                                            <input v-model="form.company_state" 
                                                                type="text" 
                                                                name="company_state" 
                                                                placeholder="Type  State" 
                                                                :class="{ 'is-invalid': form.errors.has('company_state') }"/>
                                                                 <has-error :form="form" field="company_state"></has-error>
                                                        
                                                        
                                                            <label class="fieldlabels"> Country:</label> 
                                                            <div class="position-relative form-group">
                                                                 <select v-model="form.company_country"
                                                                    name="company_country"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('company_country') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                                </select>
                                                            </div>  
                                                            <label class="fieldlabels"> Zip Code/ Postal Code:</label> 
                                                            <input v-model="form.company_zip_code" 
                                                                type="phone" 
                                                                name="zip_code" 
                                                                placeholder="Type Zip Code/ Postal Code" 
                                                                :class="{ 'is-invalid': form.errors.has('company_zip_code') }"/>
                                                                 <has-error :form="form" field="company_zip_code"></has-error> 

                                             


                                                         <h4>Company Contact</h4>  
                                              
                                                       
                                                            <label class="fieldlabels">Office Phone:</label> 
                                                           <input v-model="form.company_office_phone" 
                                                                type="text" 
                                                                name="company_office_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('company_office_phone') }"/>
                                                                 <has-error :form="form" field="company_office_phone"></has-error>
                                                        
                                                         
                                                            <label class="fieldlabels">Moblile Number:</label> 
                                                           <input v-model="form.company_cell_phone" 
                                                                type="text" 
                                                                name="company_cell_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('company_cell_phone') }"/>
                                                                 <has-error :form="form" field="company_cell_phone"></has-error>
                                                         
                                                            <label class="fieldlabels">Email:</label> 
                                                            <input v-model="form.company_email" 
                                                                type="company_email" 
                                                                name="company_email" 
                                                                :class="{ 'is-invalid': form.errors.has('company_email') }"/>
                                                                 <has-error :form="form" field="company_email"></has-error>
                                                        
                                                            <label class="fieldlabels">Fax:</label> 
                                                            <input v-model="form.company_fax_no" 
                                                                type="text" 
                                                                name="company_fax_no" 
                                                                :class="{ 'is-invalid': form.errors.has('company_fax_no') }"/>
                                                                 <has-error :form="form" field="company_fax_no"></has-error> 
                                                        
                                                            <label class="fieldlabels">Website :</label> 
                                                            <input v-model="form.company_website" 
                                                                type="url" 
                                                                name="company_website" 
                                                                :class="{ 'is-invalid': form.errors.has('company_website') }"/>
                                                                 <has-error :form="form" field="company_website"></has-error>
                                                         
                                                        
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-box-outer">  
                                            <h4>Parking Pass</h4> 
                                            <div class="row"> 
                                                <div class="col-md-12 col-sm-6 col-xs-12">
                                                    <label class="fieldlabels">Parking Pass No:</label> 
                                                    <input v-model="form.parking_pass_no" 
                                                        type="text" 
                                                        name="parking_pass_no" 
                                                        placeholder="Type Invoice Term" 
                                                        :class="{ 'is-invalid': form.errors.has('parking_pass_no') }"/>
                                                         <has-error :form="form" field="parking_pass_no"></has-error> 
                                                </div> 
                                                <div class="col-md-12 col-sm-6 col-xs-12"> 
                                                    <label class="fieldlabels">Parking Pass Type:</label> 
                                                    <div class="position-relative form-group">
                                                        <select v-model="form.parking_pass_type"
                                                            name="parking_pass_type"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('parking_pass_type') }">
                                                            <option disabled value="">--Select-- </option>
                                                            <option value="1">Business</option> 
                                                            <option value="2">Carpool</option> 
                                                            <option value="3">Commercial</option> 
                                                            <option value="4">Employee</option> 
                                                            <option value="5">Event</option> 
                                                            <option value="6">Government</option> 
                                                            <option value="7">Handicap</option> 
                                                            <option value="8">Hotel</option> 
                                                            <option value="9">Monthly/Annual</option> 
                                                            <option value="10">Reserved</option> 
                                                            <option value="11">Residential</option> 
                                                            <option value="12">Special Purpose</option> 
                                                            <option value="13">Student</option> 
                                                            <option value="14">Temporary Construction</option> 
                                                            <option value="15">Valet</option> 
                                                            <option value="16">Visitor</option> 
                                                        </select>
                                                        <has-error :form="form" field="parking_pass_type"></has-error> 
                                                    </div> 
                                                </div>  
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="fieldlabels">Pass Expiry Date & Time :</label>  
                                                    <date-picker 
                                                        style="width:100%"
                                                        v-model="form.pass_expire_date_and_time"
                                                        name="pass_expire_date_and_time"
                                                        lang="en"
                                                        type="pass_expire_date_and_time"
                                                        format="DD MMM, YYYY"
                                                        :class="{ 'is-invalid': form.errors.has('pass_expire_date_and_time') }">
                                                    </date-picker>
                                                    <has-error :form="form" field="pass_expire_date_and_time"></has-error> 
                                                </div>
                                                <div class="col-md-12 col-sm-6 col-xs-12"> 
                                                    <h4>Parking Period</h4> 
                                                    <label class="fieldlabels" >From Date :</label> 
                                                    <date-picker 
                                                        style="width:100%"
                                                        v-model="form.parking_period_from"
                                                        name="parking_period_from"
                                                        lang="en"
                                                        type="parking_period_from"
                                                        format="DD MMM, YYYY"
                                                        :class="{ 'is-invalid': form.errors.has('parking_period_from') }">
                                                    </date-picker>
                                                    <has-error :form="form" field="parking_period_from"></has-error> 
                                                    <label class="fieldlabels" >To Date:</label> 
                                                    <date-picker 
                                                        style="width:100%"
                                                        v-model="form.parking_period_to"
                                                        name="parking_period_to"
                                                        lang="en"
                                                        type="parking_period_to"
                                                        format="DD MMM, YYYY"
                                                        :class="{ 'is-invalid': form.errors.has('parking_period_to') }">
                                                    </date-picker>
                                                    <has-error :form="form" field="parking_period_to"></has-error> 
                                                </div>

                                                <div class="col-md-12 col-sm-6 col-xs-12">
                                                    <label class="fieldlabels">Car Insurance Policy No:</label> 
                                                    <input v-model="form.car_insurance_policy_no" 
                                                        type="text" 
                                                        name="car_insurance_policy_no" 
                                                        placeholder="Type Car Insurance Policy No" 
                                                        :class="{ 'is-invalid': form.errors.has('car_insurance_policy_no') }"/>
                                                         <has-error :form="form" field="car_insurance_policy_no"></has-error> 
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="fieldlabels">Car Insurance Expiry Date :</label>  
                                                    <date-picker 
                                                        style="width:100%"
                                                        v-model="form.car_insurance_expire_date"
                                                        name="car_insurance_expire_date"
                                                        lang="en"
                                                        type="car_insurance_expire_date"
                                                        format="DD MMM, YYYY"
                                                        :class="{ 'is-invalid': form.errors.has('car_insurance_expire_date') }">
                                                    </date-picker>
                                                    <has-error :form="form" field="car_insurance_expire_date"></has-error> 
                                                </div>
                                                <div class="col-md-12 col-sm-6 col-xs-12">
                                                    <label class="fieldlabels">Parking Lot:</label> 
                                                    <input v-model="form.parking_lot" 
                                                        type="text" 
                                                        name="parking_lot" 
                                                        placeholder="Type Parking Lot" 
                                                        :class="{ 'is-invalid': form.errors.has('parking_lot') }"/>
                                                         <has-error :form="form" field="parking_lot"></has-error> 
                                                </div>
                                                <div class="col-md-12 col-sm-6 col-xs-12">
                                                    <label class="fieldlabels">Parking Stall No:</label> 
                                                    <input v-model="form.parking_stall_no" 
                                                        type="text" 
                                                        name="parking_stall_no" 
                                                        placeholder="Type Chart of Accounts" 
                                                        :class="{ 'is-invalid': form.errors.has('parking_stall_no') }"/>
                                                         <has-error :form="form" field="parking_stall_no"></has-error> 
                                                </div>
                                                <div class="col-md-12 col-sm-6 col-xs-12">
                                                    <label class="fieldlabels">Parking Stall Type:</label> 
                                                    <input v-model="form.parking_stall_type" 
                                                        type="text" 
                                                        name="parking_stall_type" 
                                                        placeholder="Type Parking Stall Type" 
                                                        :class="{ 'is-invalid': form.errors.has('parking_stall_type') }"/>
                                                         <has-error :form="form" field="parking_stall_type"></has-error> 
                                                </div>

                                                <div class="col-md-12 col-sm-6 col-xs-12">
                                                    <label class="fieldlabels">Chart of Accounts:</label> 
                                                    <input v-model="form.chart_of_acocounts" 
                                                        type="text" 
                                                        name="chart_of_acocounts" 
                                                        placeholder="Type Chart of Accounts" 
                                                        :class="{ 'is-invalid': form.errors.has('chart_of_acocounts') }"/>
                                                         <has-error :form="form" field="chart_of_acocounts"></has-error> 
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="fieldlabels">Is this Account Holder has a portal ?:</label> 
                                                    <div class="position-relative form-group">
                                                        <select v-model="form.account_holder_portal"
                                                                name="account_holder_portal"
                                                                class="custom-select" 
                                                                :class="{ 'is-invalid': form.errors.has('account_holder_portal') }">
                                                                <option disabled value="">--Select-- </option>
                                                                <option value="1">Yes</option> 
                                                                <option value="2">No</option> 
                                                            </select>
                                                            <has-error :form="form" field="account_holder_portal"></has-error> 
                                                    </div> 
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="fieldlabels">Is this Account Holder has a dedicated File ?:</label> 
                                                    <div class="position-relative form-group">
                                                        <select v-model="form.account_holder_dedicated_file"
                                                                name="account_holder_dedicated_file"
                                                                class="custom-select" 
                                                                :class="{ 'is-invalid': form.errors.has('account_holder_dedicated_file') }">
                                                                <option disabled value="">--Select-- </option>
                                                                <option value="1">Yes</option> 
                                                                <option value="2">No</option> 
                                                            </select>
                                                            <has-error :form="form" field="account_holder_dedicated_file"></has-error> 
                                                    </div> 
                                                </div>


                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="fieldlabels">Account Status:</label> 
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
                                                <div class="col-md-12 col-sm-6 col-xs-12"> 
                                                    <label class="fieldlabels">Payment Method:</label> 
                                                    <div class="position-relative form-group">
                                                    <select v-model="form.payment_method"
                                                        name="payment_method" 
                                                        class="custom-select" 
                                                        :class="{ 'is-invalid': form.errors.has('payment_method') }">
                                                        <option disabled value="">--Select-- </option>
                                                        <option v-for="(payment_method, index) in payment_class" :value="index">{{payment_method}}</option> 
                                                    </select>
                                                    </div> 
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="fieldlabels">Account Creation Date:</label>  
                                                    <date-picker 
                                                        style="width:100%"
                                                        v-model="form.account_creation_date"
                                                        name="account_creation_date"
                                                        lang="en"
                                                        type="account_creation_date"
                                                        format="DD MMM, YYYY"
                                                        :class="{ 'is-invalid': form.errors.has('account_creation_date') }">
                                                    </date-picker>
                                                    <has-error :form="form" field="account_creation_date"></has-error> 
                                                </div>
                                                <div class="col-md-12 col-sm-6 col-xs-12">
                                                    <label class="fieldlabels">Invoice Term:</label> 
                                                    <input v-model="form.invoice_term" 
                                                        type="text" 
                                                        name="invoice_term" 
                                                        placeholder="Type Invoice Term" 
                                                        :class="{ 'is-invalid': form.errors.has('invoice_term') }"/>
                                                         <has-error :form="form" field="invoice_term"></has-error> 
                                                </div> 
                                                <div class="col-md-12 col-sm-6 col-xs-12">
                                                    <label class="fieldlabels" >Credit Limit :</label>  
                                                    <input v-model="form.credit_limit" 
                                                        type="number" 
                                                        placeholder="Type Credit Limit"
                                                        name="credit_limit" 
                                                        :class="{ 'is-invalid': form.errors.has('credit_limit') }"/>
                                                    <has-error :form="form" field="credit_limit"></has-error> 
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="fieldlabels">Comment :</label> 
                                                    <input v-model="form.comments" 
                                                        type="text" 
                                                        name="comments" 
                                                        placeholder="Type Comment" 
                                                        :class="{ 'is-invalid': form.errors.has('comments') }"/>
                                                         <has-error :form="form" field="comments"></has-error> 
                                                </div> 
                                            </div> 
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="form-folder">
                                    <h3><i class="fa fa-hand-point-right"></i>Emergency Info:
                                        <button type="button" class="btn btn-primary btn-sm" @click="show_hide_emergency_contact_license()" v-show="!emergency_contact_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_emergency_contact_license()" v-show="emergency_contact_show">Hide</button>
                                    </h3> 
                                    <div class="form-holder" v-show="emergency_contact_show">
                                        <div class="row align-self-stretch">  
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-box-outer">  
                                                    <div class="form-holder">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Emergency name:</label> 
                                                            <input v-model="form.emergency_contact_company_name" 
                                                               type="text" 
                                                               name="emergency_contact_company_name" 
                                                               placeholder="Type Company Name"
                                                               :class="{ 'is-invalid': form.errors.has('emergency_contact_company_name') }"/>
                                                            <has-error :form="form" field="emergency_contact_company_name"></has-error> 
                                                        </div> 
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Gender:</label> 
                                                            <select v-model="form.emergency_gender"
                                                                name="emergency_gender"
                                                                class="custom-select" 
                                                                :class="{ 'is-invalid': form.errors.has('emergency_gender') }">
                                                                <option disabled value="">--Select-- </option>
                                                                <option value="1">Male</option> 
                                                                <option value="2">Female</option> 
                                                            </select>
                                                            <has-error :form="form" field="emergency_gender"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Relationship:</label> 
                                                            <input v-model="form.emergency_relationship" 
                                                               type="text" 
                                                               name="emergency_relationship" 
                                                               placeholder="Type Relationship Name"
                                                               :class="{ 'is-invalid': form.errors.has('emergency_relationship') }"/>
                                                            <has-error :form="form" field="emergency_relationship"></has-error> 
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-box-outer"> 
                                                    <div class="row"> 
                                                        <h4>Address</h4>
                                                         <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Number:</label> 
                                                            <input v-model="form.emergency_contact_house_number" 
                                                                type="phone" 
                                                                name="emergency_contact_house_number" 
                                                                placeholder="Type House/Office Number" 
                                                                :class="{ 'is-invalid': form.errors.has('emergency_contact_house_number') }"/>
                                                                 <has-error :form="form" field="emergency_contact_house_number"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels">Street Number:</label> 
                                                            <input v-model="form.emergency_contact_street_number" 
                                                                type="text" 
                                                                name="emergency_contact_street_number" 
                                                                placeholder="Type Street Number" 
                                                                :class="{ 'is-invalid': form.errors.has('emergency_contact_street_number') }"/>
                                                                 <has-error :form="form" field="emergency_contact_street_number"></has-error> 
                                                        </div>
                                                        
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels">City:</label> 
                                                            <input v-model="form.emergency_contact_city" 
                                                                type="text" 
                                                                name="emergency_contact_city" 
                                                                placeholder="Type City" 
                                                                :class="{ 'is-invalid': form.errors.has('emergency_contact_city') }"/>
                                                                 <has-error :form="form" field="emergency_contact_city"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">State:</label> 
                                                            <input v-model="form.emergency_contact_state" 
                                                                type="text" 
                                                                name="emergency_contact_state" 
                                                                placeholder="Type State" 
                                                                :class="{ 'is-invalid': form.errors.has('emergency_contact_state') }"/>
                                                                 <has-error :form="form" field="emergency_contact_state"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Country:</label> 
                                                            <div class="position-relative form-group">
                                                                 <select v-model="form.emergency_contact_country"
                                                                    name="emergency_contact_country"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('emergency_contact_country') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Zip Code/ Postal Code:</label> 
                                                            <input v-model="form.emergency_contact_zip_code" 
                                                                type="phone" 
                                                                name="emergency_contact_zip_code" 
                                                                placeholder="Type Zip Code/ Postal Code" 
                                                                :class="{ 'is-invalid': form.errors.has('emergency_contact_zip_code') }"/>
                                                                 <has-error :form="form" field="emergency_contact_zip_code"></has-error> 
                                                        </div>  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-box-outer">
                                                    <h4>Contact</h4>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Email:</label> 
                                                            <input v-model="form.emergency_contact_email" 
                                                                type="email" 
                                                                name="emergency_contact_email" 
                                                                :class="{ 'is-invalid': form.errors.has('emergency_contact_email') }"/>
                                                                 <has-error :form="form" field="emergency_contact_email"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Fax:</label> 
                                                            <input v-model="form.emergency_contact_fax_no" 
                                                                type="text" 
                                                                name="emergency_contact_fax_no" 
                                                                :class="{ 'is-invalid': form.errors.has('emergency_contact_fax_no') }"/>
                                                                 <has-error :form="form" field="emergency_contact_fax_no"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Moblile Number:</label> 
                                                           <input v-model="form.emergency_contact_cell_phone" 
                                                                type="text" 
                                                                name="emergency_contact_cell_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('emergency_contact_cell_phone') }"/>
                                                                 <has-error :form="form" field="emergency_contact_cell_phone"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Office Phone:</label> 
                                                           <input v-model="form.emergency_contact_office_phone" 
                                                                type="text" 
                                                                name="emergency_contact_office_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('emergency_contact_office_phone') }"/>
                                                                 <has-error :form="form" field="emergency_contact_office_phone"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Website :</label> 
                                                            <input v-model="form.emergency_contact_website" 
                                                                type="url" 
                                                                name="emergency_contact_website" 
                                                                :class="{ 'is-invalid': form.errors.has('emergency_contact_website') }"/>
                                                                 <has-error :form="form" field="emergency_contact_website"></has-error>
                                                        </div>

                                                    </div>
                                                                                                   
                                                </div>
                                            </div>
                                            
                                           
                                        </div>
                                    </div>
                                </div>
                        </div> 
                        <div class="text-center">
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Edit</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deleteAccountHolder()">Delete</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode">Void</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(1)">Save-Stay</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(2)">Save-Out</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(3)">Save-New</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
                        </div>
                    </div>   
                </div> 
            </fieldset> 
        </form>
    </div>








</template>

<script>
import Vue from 'vue';
import VueTimepicker from 'vue2-timepicker';
import 'vue2-timepicker/dist/VueTimepicker.css';
//import { jsPDF } from "jspdf";

import jsPDF  from "jspdf";

export default {
name:'list-product-categories',
components:{
    VueTimepicker 
},
data(){
    return{
        editmode:false,
        filter: '',
        list_showable:false,
        form:new Form({
            account_type:24, 
            parker_name:'',
            parker_photo:'', 
            parker_office_phone:'',
            parker_cell_phone:'',
            parker_email:'',
            parker_fax_no:'',
            parker_website:'', 
            parker_house_number:'',
            parker_street_number:'',
            parker_city:'',
            parker_state:'',
            parker_country:'',
            parker_zip_code:'',
            company_name:'',
            company_logo:'',
            industry_sector:'',
            company_house_number:'',
            company_street_number:'',
            company_city:'',
            company_state:'',
            company_country:'',
            company_zip_code:'',
            company_office_phone:'',
            company_cell_phone:'',
            company_email:'',
            company_fax_no:'',
            company_website:'',  
            payment_method:'',
            parking_pass_no:'',
            credit_limit:'',
            chart_of_acocounts:'',
            account_creation_date:'',
            acount_status:'',
            invoice_term:'',
            comments:'', 
                    id:'',  
                    parker_type:'',
            emergency_contact_company_name:'', 
            emergency_contact_house_number:'',
            emergency_contact_street_number:'',
            emergency_contact_city:'',
            emergency_contact_state:'',
            emergency_contact_country:'',
            emergency_contact_zip_code:'',
            emergency_contact_email:'',
            emergency_contact_fax_no:'',
            emergency_contact_cell_phone:'', 
            emergency_contact_office_phone:'',
            emergency_contact_website:'',  
            parking_pass_no:'',
            parking_pass_type:'',
            pass_expire_date_and_time:'',
            parking_period_from:'',
            parking_period_to:'',
            car_insurance_policy_no:'',
            car_insurance_expire_date:'',
            parking_stall_no:'',
            parking_lot:'',
            parking_stall_type:'',
            account_holder_portal:'',
            account_holder_dedicated_file:'',
            account_holder_title_name:'',  
            emergency_relationship:'',
            emergency_gender:'',
                             
              
        }),
        main_company_arr:[],
        industry_sector_arr:[],
        industry_sector_display:false,
        account_holder_arr:[],
        payment_name:[],
        payment_class:[],
        countries:'',
        business_show:false,
        emergency_contact_show:false,
        liability_insurence_show:false,
  
        columns: [
            { label: 'SL', field: 'sl', align: 'center' },
            { label: 'System No', field: 'system_no' },
            { label: 'Account Type', field: 'account_type_string' },
            { label: 'parker Name', field: 'parker_name' },
            { label: 'Company Name', field: 'company_name' },
            { label: 'Email', field: 'parker_email' },
            { label: 'Mobile No', field: 'parker_cell_phone' },
            { label: 'Country', field: 'parker_country' },
            { label: 'Industrial Sector', field: 'industry_sector' },                    
            { label: 'Action', field: '', sortable: false },
        ],
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
    

    submitForm() 
    {
        axios.put('/AccountHolderparker/' + this.recordId, this.form)
        .then(response => {
        console.log('Update successful');
        })
        .catch(error => {
        if (error.response && error.response.status === 422) {
        this.form.errors.record(error.response.data.errors);
        }
        });
    }, 
     
    show_hide_emergency_contact_license(){
        if(this.emergency_contact_show)
        {
            this.emergency_contact_show=false;
        }
        else{
            this.emergency_contact_show=true;
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
        let uri = '/AccountHolderparkerLists';
        window.axios.get(uri).then((response) => {
            this.rows = response.data.account_holder_list;
        });
        this.list_showable=true;
    },

    

    fetchAccountHolder()
    {
        let uri = '/AccountHolderparker';
        window.axios.get(uri).then((response) => {
            
            this.industry_sector_arr                      =response.data.industry_sector_arr;
            this.countries                                =response.data.country_arr;
            this.account_holder_arr                       =response.data.account_holder_arr;
            this.payment_name                             =response.data.payment_name;
            this.payment_class                             =response.data.payment_class; 
            this.editmode=false;
            

            
        }); 

        
    },
 


    updateAccountHolder()
    {
    
        
        this.form.put('/AccountHolderparker/'+this.form.id).then(({ data })=>{
                var response_data=data.split("**");
                //alert(response_data[0])
                if(response_data[0]*1==1)
                {
                    toast({
                        type: 'success',
                        title: 'Data Update Successfully'
                    });

                    this.editAccountHolder(response_data[1]);
                    this.editmode=true;

                }
                else if(response_data[0]*1==10)
                {
                    toast({
                            type: 'error',
                            title: "Please open the 'Open File' page and select a company before proceeding to create an account holder User."
                    }); 
                }
                else{

                    toast({
                        type: 'danger',
                        title: 'Invalid Operation'
                    });
                }
            })
            .catch(()=>{
               Swal("failed!","there was some wrong","warning");
        
            });
    },


    
    createAccountHolder()
    {

        this.form.post('/AccountHolderparker') .then(({ data }) => { 
       
            
            toast({
                type: 'success',
                title: 'Data Save successfully'
            });

            this.form.reset ();
            this.fetchAccountHolder();
        })
    },


    save_stay(type){

      

        this.form.post('/AccountHolderparker') .then(({ data }) => { 
            var response_data=data.split("**");
            if(response_data[0]==1)
            {
                 toast({
                    type: 'success',
                    title: 'Data Save successfully'
                });

                if(type==1)
                {
                    this.fetchAccountHolderUpdate(response_data[1]);
                    this.editmode=true;
                }
                else if(type==2)
                {
                     window.location.href = '/Dashboard';
                    
                }
                else if(type==3)
                {
                     this.form.reset();
                     this.fetchAccountHolder();
                }
            }
            else if(response_data[0]*1==10)
                {
                    toast({
                            type: 'error',
                            title: "Please open the 'Open File' page and select a company before proceeding to create an account holder User."
                    }); 
                }
            else{

                toast({
                    type: 'danger',
                    title: 'Invalid Operation'
                });
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

              this.form.delete('/AccountHolderparker/'+this.form.id).then(()=>{
                
                  if(result.value) {
                       Swal(
                        'Deleted!',
                        'Your Company has been deleted.',
                        'success'
                      );
                     this.form.reset();
                     this.fetchAccountHolder();
                  }            

              }).catch(()=>{
                Swal("failed!","there was some wrong","warning");
          });
       
      })
    },
    editAccountHolder(id)
    {
        this.form.reset();
        this.list_showable=false;
        let uri = '/AccountHolderparker/'+id+'/edit';
        window.axios.get(uri).then((response) => {
            


           
            
                    this.form.id=response.data.account_holder.id;
                    this.form.system_no=response.data.account_holder.system_no;
                    this.form.account_type=response.data.account_holder.account_type;  
                    this.form.parker_name=response.data.account_holder.parker_name;
                    this.form.parker_photo=response.data.account_holder.parker_photo;


                    this.form.parker_office_phone=response.data.account_holder.parker_office_phone;
                    this.form.parker_cell_phone=response.data.account_holder.parker_cell_phone;
                    this.form.parker_state=response.data.account_holder.parker_state;
                    this.form.parker_email=response.data.account_holder.parker_email;
                    this.form.parker_fax_no=response.data.account_holder.parker_fax_no;
                    this.form.parker_website=response.data.account_holder.parker_website;

                   

                    this.form.parker_house_number=response.data.account_holder.parker_house_number;
                    this.form.parker_street_number=response.data.account_holder.parker_street_number;
                    this.form.parker_city=response.data.account_holder.parker_city;
                    this.form.parker_state=response.data.account_holder.parker_state;
                    this.form.parker_country=response.data.account_holder.parker_country;
                    this.form.parker_zip_code=response.data.account_holder.parker_zip_code;



                    this.form.company_office_phone=response.data.account_holder.company_office_phone;
                    this.form.company_cell_phone=response.data.account_holder.company_cell_phone;
                    this.form.company_state=response.data.account_holder.company_state;
                    this.form.company_email=response.data.account_holder.company_email;
                    this.form.company_fax_no=response.data.account_holder.company_fax_no;
                    this.form.company_website=response.data.account_holder.company_website;

                    this.form.company_house_number=response.data.account_holder.company_house_number;
                    this.form.company_street_number=response.data.account_holder.company_street_number;
                    
                    this.form.company_city=response.data.account_holder.company_city;
                    this.form.company_state=response.data.account_holder.company_state;
                    this.form.company_country=response.data.account_holder.company_country;
                    this.form.company_zip_code=response.data.account_holder.company_zip_code;   
                    this.form.company_name=response.data.account_holder.company_name;
                    this.form.company_logo=response.data.account_holder.company_logo;
                    this.form.industry_sector=response.data.account_holder.industry_sector;  
                    this.form.payment_method=response.data.account_holder.payment_method;
                    this.form.parking_pass_no=response.data.account_holder.parking_pass_no;
                    this.form.credit_limit=response.data.account_holder.credit_limit;
                    this.form.chart_of_acocounts=response.data.account_holder.chart_of_acocounts;
                    this.form.account_creation_date=response.data.account_holder.account_creation_date;
                    this.form.acount_status=response.data.account_holder.acount_status; 
                    this.form.comments=response.data.account_holder.comments; 
                    this.form.invoice_term=response.data.account_holder.invoice_term;  


                    this.form.emergency_contact_company_name=response.data.account_holder.emergency_contact_company_name; 
                    this.form.emergency_contact_house_number=response.data.account_holder.emergency_contact_house_number;
                    this.form.emergency_contact_street_number=response.data.account_holder.emergency_contact_street_number;
                    this.form.emergency_contact_city=response.data.account_holder.emergency_contact_city;
                    this.form.emergency_contact_state=response.data.account_holder.emergency_contact_state;
                    this.form.emergency_contact_country=response.data.account_holder.emergency_contact_country;
                    this.form.emergency_contact_zip_code=response.data.account_holder.emergency_contact_zip_code; 
                    this.form.emergency_contact_email=response.data.account_holder.emergency_contact_email;
                    this.form.emergency_contact_fax_no=response.data.account_holder.emergency_contact_fax_no;
                    this.form.emergency_contact_cell_phone=response.data.account_holder.emergency_contact_cell_phone;
                    this.form.emergency_contact_office_phone=response.data.account_holder.emergency_contact_office_phone;
                    this.form.emergency_contact_website=response.data.account_holder.emergency_contact_website;
                    this.form.account_holder_portal=response.data.account_holder.account_holder_portal;  
                    this.form.account_holder_dedicated_file=response.data.account_holder.account_holder_dedicated_file;  
                    this.form.account_holder_title_name=response.data.account_holder.account_holder_title_name; 

                    this.form.emergency_relationship=response.data.account_holder.emergency_relationship;
                    this.form.emergency_gender=response.data.account_holder.emergency_gender;
 
                    this.form.parker_type=response.data.account_holder.parker_type;
                    this.form.parking_pass_no=response.data.account_holder.parking_pass_no;
                    this.form.parking_pass_type=response.data.account_holder.parking_pass_type;

                    this.form.pass_expire_date_and_time=response.data.account_holder.pass_expire_date_and_time;
                    this.form.parking_period_from=response.data.account_holder.parking_period_from;
                    this.form.parking_period_to=response.data.account_holder.parking_period_to;
                    this.form.car_insurance_policy_no=response.data.account_holder.car_insurance_policy_no;
                    this.form.car_insurance_expire_date=response.data.account_holder.car_insurance_expire_date;
                    this.form.parking_stall_no=response.data.account_holder.parking_stall_no;
                    this.form.parking_lot=response.data.account_holder.parking_lot;
                    this.form.parking_stall_type=response.data.account_holder.parking_stall_type; 



                    this.industry_sector_arr                      =response.data.industry_sector_arr;
                    this.countries                                =response.data.country_arr;
                    this.account_holder_arr                       =response.data.account_holder_arr; 
                    this.editmode=true;
            


            
        }); 

        
    },


}

}  

</script>



