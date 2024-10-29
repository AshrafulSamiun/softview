<template>

   
            <div class="card">

                <form id="msform" @submit.prevent="editmode ? updateAccountHolder() : createAccountHolder()" @keydown="form.onKeydown($event)">  
                    <fieldset>
                        <div id="content">
                            <div class="form-card">
                                <h1 class="page-head">Employee Profile</h1> 
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
                                            <td>{{ row.entity_type }}</td>
                                            <td>{{ row.full_name }}</td>
                                            <td>{{ row.email }}</td>
                                            <td>{{ row.cell_phone }}</td>
                                            <td>{{ row.country_name }}</td>
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
                                    <h3><i class="fa fa-hand-point-right"></i>Personal Information :</h3> 
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
                                                    <label class="fieldlabels">Account Type:</label> 
                                                    <div class="position-relative form-group">
                                                         <select v-model="form.account_type"
                                                            name="account_type" 
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('account_type') }">
                                                            <option disabled value="">--Select-- </option>
                                                            <option v-for="(account_holder, index) in account_holder_arr" :value="index">{{account_holder}}</option>
                                                            
                                                        </select>
                                                    </div> 
                                                    <label class="fieldlabels" >Full Name:</label>  
                                                    <input v-model="form.full_name" 
                                                        type="text" 
                                                        placeholder="Type Full Name"
                                                        name="full_name" 
                                                        :class="{ 'is-invalid': form.errors.has('full_name') }"/>
                                                      <has-error :form="form" field="full_name"></has-error>

                                                      <label class="fieldlabels" >Date of Birth:</label>  
                                                    <input v-model="form.date_of_birth" 
                                                        type="text" 
                                                        placeholder="Type Date of Birth"
                                                        name="date_of_birth" 
                                                        :class="{ 'is-invalid': form.errors.has('date_of_birth') }"/>
                                                      <has-error :form="form" field="date_of_birth"></has-error>

                                                    <label class="fieldlabels">Gender:</label> 
                                                    <div class="position-relative form-group">
                                                        <select v-model="form.gender"
                                                            name="gender"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('gender') }">
                                                            <option disabled value="">--Select-- </option>
                                                            <option value="1">Male</option>
                                                            <option value="2">Female</option> 
                                                        </select>
                                                        <has-error :form="form" field="gender"></has-error> 
                                                    </div>

                                                        <h4>Contact</h4>  
                                                        
                                                            <label class="fieldlabels">Office Phone:</label> 
                                                           <input v-model="form.office_phone" 
                                                                type="text" 
                                                                name="office_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('office_phone') }"/>
                                                                 <has-error :form="form" field="office_phone"></has-error>
                                                         
                                                            <label class="fieldlabels">Moblile Number:</label> 
                                                             <input v-model="form.cell_phone" 
                                                                type="text" 
                                                                name="cell_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('cell_phone') }"/>
                                                                 <has-error :form="form" field="cell_phone"></has-error>
                                                         
                                                            <label class="fieldlabels">Email:</label> 
                                                            <input v-model="form.email" 
                                                                type="email" 
                                                                name="email" 
                                                                :class="{ 'is-invalid': form.errors.has('email') }"/>
                                                                 <has-error :form="form" field="email"></has-error>
                                                         
                                                            <label class="fieldlabels">Fax:</label> 
                                                            <input v-model="form.fax_no" 
                                                                type="text" 
                                                                name="fax_no" 
                                                                :class="{ 'is-invalid': form.errors.has('fax_no') }"/>
                                                                 <has-error :form="form" field="fax_no"></has-error> 
                                                         
                                                            <label class="fieldlabels">Website :</label> 
                                                            <input v-model="form.website" 
                                                                type="url" 
                                                                name="website" 
                                                                :class="{ 'is-invalid': form.errors.has('website') }"/>
                                                                 <has-error :form="form" field="website"></has-error>
                                                        <h4>Address</h4>
                                                        
                                                            <label class="fieldlabels">Number:</label> 
                                                            <input v-model="form.house_number" 
                                                                type="phone" 
                                                                name="house_number" 
                                                                placeholder="Type House/Office Number" 
                                                                :class="{ 'is-invalid': form.errors.has('house_number') }"/>
                                                                 <has-error :form="form" field="house_number"></has-error> 
                                                        
                                                            <label class="fieldlabels">Street Number:</label> 
                                                            <input v-model="form.street_number" 
                                                                type="text" 
                                                                name="street_number" 
                                                                placeholder="Type Street Number" 
                                                                :class="{ 'is-invalid': form.errors.has('street_number') }"/>
                                                                 <has-error :form="form" field="street_number"></has-error> 
                                                       
                                                            <label class="fieldlabels">City:</label> 
                                                            <input v-model="form.city" 
                                                                type="text" 
                                                                name="city" 
                                                                placeholder="Type City" 
                                                                :class="{ 'is-invalid': form.errors.has('city') }"/>
                                                                 <has-error :form="form" field="city"></has-error> 
                                                        
                                                            <label class="fieldlabels">State:</label> 
                                                            <input v-model="form.state" 
                                                                type="text" 
                                                                name="state" 
                                                                placeholder="Type State" 
                                                                :class="{ 'is-invalid': form.errors.has('state') }"/>
                                                                 <has-error :form="form" field="state"></has-error>
                                                         
                                                            <label class="fieldlabels">Country:</label> 
                                                            <div class="position-relative form-group">
                                                                 <select v-model="form.country"
                                                                    name="country"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('country') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                                </select>
                                                            </div>
                                                         
                                                            <label class="fieldlabels">Zip Code/ Postal Code:</label> 
                                                            <input v-model="form.zip_code" 
                                                                type="phone" 
                                                                name="zip_code" 
                                                                placeholder="Type Zip Code/ Postal Code" 
                                                                :class="{ 'is-invalid': form.errors.has('zip_code') }"/>
                                                             <has-error :form="form" field="zip_code"></has-error> 


                                                             <label class="fieldlabels">Education Level:</label> 
                                                            <input v-model="form.education_lavel" 
                                                                type="phone" 
                                                                name="education_lavel" 
                                                                placeholder="Type Education Level" 
                                                                :class="{ 'is-invalid': form.errors.has('education_lavel') }"/>
                                                             <has-error :form="form" field="education_lavel"></has-error> 

                                                             <label class="fieldlabels">Independent Information:</label> 
                                                            <input v-model="form.independent_information" 
                                                                type="phone" 
                                                                name="independent_information" 
                                                                placeholder="Type Independent Information" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information') }"/>
                                                             <has-error :form="form" field="independent_information"></has-error> 
                                                          
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="form-box-outer">
                                                    <h4>Employment Information</h4> 
                                                    <label class="fieldlabels">Job Title:</label>
                                                    <input 
                                                        v-model="form.Job_title" 
                                                        type="text" 
                                                        name="Job_title" 
                                                        placeholder="Type Job Title" 
                                                        :class="{ 'is-invalid': form.errors.has('Job_title') }"/>
                                                    <has-error :form="form" field="Job_title"></has-error> 

                                                    
                                                    <label class="fieldlabels" >Department/Division:</label>  
                                                    <input v-model="form.department_division" 
                                                        type="text" 
                                                        placeholder="Type Department/Division"
                                                        name="department_division" 
                                                        :class="{ 'is-invalid': form.errors.has('department_division') }"/>
                                                      <has-error :form="form" field="department_division"></has-error>

                                                    <label class="fieldlabels" >Supervisor/Manager:</label>  
                                                    <input v-model="form.superviser_manager" 
                                                        type="text" 
                                                        placeholder="Type Supervisor/Manager"
                                                        name="superviser_manager" 
                                                        :class="{ 'is-invalid': form.errors.has('superviser_manager') }"/>
                                                      <has-error :form="form" field="superviser_manager"></has-error>

                                                    <label class="fieldlabels" >Employment Start Date:</label>  
                                                    <date-picker 
                                                                style="width:100%"
                                                                v-model="form.employment_start_date"
                                                                name="employment_start_date"
                                                                lang="en"
                                                                type="employment_start_date"
                                                                format="DD MMM, YYYY"
                                                                :class="{ 'is-invalid': form.errors.has('employment_start_date') }">
                                                            </date-picker>
                                                            <has-error :form="form" field="employment_start_date"></has-error>

                                                    <label class="fieldlabels">Work Schedule:</label>
                                                    <div class="position-relative form-group">
                                                        <select v-model="form.work_schedule"
                                                            name="work_schedule"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('work_schedule') }">
                                                            <option disabled value="">--Select-- </option>
                                                            <option value="1">Full-time</option> 
                                                            <option value="2">Part-time</option> 
                                                        </select>
                                                        <has-error :form="form" field="work_schedule"></has-error> 
                                                    </div>   

                                                    <label class="fieldlabels">Employment Status:</label> 
                                                    <select v-model="form.employment_status"
                                                            name="employment_status"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('employment_status') }">
                                                            <option disabled value="">--Select-- </option>
                                                            <option value="1">Permanent</option> 
                                                            <option value="2">Contract</option> 
                                                            <option value="3">Temporary</option>
                                                        </select>
                                                        <has-error :form="form" field="employment_status"></has-error> 

                                                        <label class="fieldlabels">Education Level:</label> 
                                                            <input v-model="form.employment_education_lavel" 
                                                                type="phone" 
                                                                name="employment_education_lavel" 
                                                                placeholder="Type Education Level" 
                                                                :class="{ 'is-invalid': form.errors.has('employment_education_lavel') }"/>
                                                             <has-error :form="form" field="employment_education_lavel"></has-error> 

                                                             <label class="fieldlabels">Independent Information:</label> 
                                                              <input v-model="form.employment_independent_information" 
                                                                type="phone" 
                                                                name="employment_independent_information" 
                                                                placeholder="Type Independent Information" 
                                                                :class="{ 'is-invalid': form.errors.has('employment_independent_information') }"/>
                                                             <has-error :form="form" field="employment_independent_information"></has-error> 

                                                             <h4>Educational level </h4>

                                                             <label class="fieldlabels">Independent Information:</label> 
                                                              <input v-model="form.employment_independent_information" 
                                                                type="phone" 
                                                                name="employment_independent_information" 
                                                                placeholder="Type Independent Information" 
                                                                :class="{ 'is-invalid': form.errors.has('employment_independent_information') }"/>
                                                             <has-error :form="form" field="employment_independent_information"></has-error> 

                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="form-box-outer">

                                                    <h4>Work Experience</h4> 
                                                    <label class="fieldlabels" >Company Name:</label>  
                                                    <input v-model="form.company_name" 
                                                        type="text" 
                                                        placeholder="Type Company Name"
                                                        name="company_name" 
                                                        :class="{ 'is-invalid': form.errors.has('company_name') }"/>
                                                    <has-error :form="form" field="company_name"></has-error>  

                                                    <label class="fieldlabels" >Department :</label>  
                                                    <input v-model="form.company_department" 
                                                        type="text" 
                                                        placeholder="Type Department "
                                                        name="company_department" 
                                                        :class="{ 'is-invalid': form.errors.has('company_department') }"/>
                                                    <has-error :form="form" field="company_department"></has-error>  


                                                    <label class="fieldlabels" >Position :</label>  
                                                    <input v-model="form.company_position" 
                                                        type="text" 
                                                        placeholder="Type Position"
                                                        name="company_position" 
                                                        :class="{ 'is-invalid': form.errors.has('company_position') }"/>
                                                    <has-error :form="form" field="company_position"></has-error>  

                                                    <label class="fieldlabels" >Manager Name :</label>  
                                                    <input v-model="form.company_manager_name" 
                                                        type="text" 
                                                        placeholder="Type Manager Name"
                                                        name="company_manager_name" 
                                                        :class="{ 'is-invalid': form.errors.has('company_manager_name') }"/>
                                                    <has-error :form="form" field="company_manager_name"></has-error> 
                                                    <label class="fieldlabels" >Supervisor Name Name :</label>  
                                                    <input v-model="form.company_superviser_name" 
                                                        type="text" 
                                                        placeholder="Type Supervisor Name Name"
                                                        name="company_superviser_name" 
                                                        :class="{ 'is-invalid': form.errors.has('company_superviser_name') }"/>
                                                    <has-error :form="form" field="company_superviser_name"></has-error>  

                                                     
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


                                                    <h4>Skills and Expertise</h4> 
                                                    <label class="fieldlabels" >Technical Skills:</label>  
                                                    <input v-model="form.technicale_skils" 
                                                        type="text" 
                                                        placeholder="Type Technical Skills"
                                                        name="technicale_skils" 
                                                        :class="{ 'is-invalid': form.errors.has('technicale_skils') }"/>
                                                    <has-error :form="form" field="technicale_skils"></has-error>  

                                                    <label class="fieldlabels" >Soft Skills :</label>  
                                                    <input v-model="form.soft_skils" 
                                                        type="text" 
                                                        placeholder="Type Soft Skills "
                                                        name="soft_skils" 
                                                        :class="{ 'is-invalid': form.errors.has('soft_skils') }"/>
                                                    <has-error :form="form" field="soft_skils"></has-error>  


                                                    <label class="fieldlabels" >Languages Spoken :</label>  
                                                    <input v-model="form.language_english" 
                                                        type="text" 
                                                        placeholder="Type Languages Spoken"
                                                        name="language_english" 
                                                        :class="{ 'is-invalid': form.errors.has('language_english') }"/>
                                                    <has-error :form="form" field="language_english"></has-error>   

                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="form-folder">
                                    <h3><i class="fa fa-hand-point-right"></i>Independent Information:
                                        <button type="button" class="btn btn-primary btn-sm" @click="show_hide_business_license()" v-show="!business_license_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_business_license()" v-show="business_license_show">Hide</button>
                                    </h3> 
                                    <div class="form-holder" v-show="business_license_show">
                                        <div class="row align-self-stretch">
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-box-outer">
                                                    
                                                    <div class="row">

                                                    
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels" >Full Name:</label>  
                                                            <input v-model="form.independent_information_full_name" 
                                                                type="text" 
                                                                placeholder="Type Full Name"
                                                                name="independent_information_full_name" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_full_name') }"/>
                                                            <has-error :form="form" field="independent_information_full_name"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels" >Gender:</label>  
                                                            <div class="position-relative form-group">
                                                            <select v-model="form.independent_information_gender"
                                                                name="independent_information_gender"
                                                                class="custom-select" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_gender') }">
                                                                <option disabled value="">--Select-- </option>
                                                                <option value="1">Male</option>
                                                                <option value="2">Female</option> 
                                                            </select>
                                                            <has-error :form="form" field="independent_information_gender"></has-error> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels" >Relation :</label>  
                                                            <input v-model="form.independent_information_relation" 
                                                                type="text" 
                                                                placeholder="Type Relation"
                                                                name="independent_information_relation" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_relation') }"/>
                                                            <has-error :form="form" field="independent_information_relation"></has-error>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels" >Date of Birth:</label>  
                                                            <input v-model="form.independent_information_date_of_birth" 
                                                                type="text" 
                                                                placeholder="Type Date of Birth"
                                                                name="independent_information_date_of_birth" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_date_of_birth') }"/>
                                                            <has-error :form="form" field="independent_information_date_of_birth"></has-error>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels" >Education Level:</label>  
                                                            <div class="position-relative form-group">
                                                            <select v-model="form.independent_information_education_level"
                                                                name="independent_information_education_level"
                                                                class="custom-select" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_education_level') }">
                                                                <option disabled value="">--Select-- </option>
                                                                <option value="1">Male</option>
                                                                <option value="2">Female</option> 
                                                            </select>
                                                            <has-error :form="form" field="independent_information_education_level"></has-error> 
                                                            </div>
                                                        </div>
                                                        
                                                          
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-box-outer">
                                                    <h4>Address</h4>
                                                    <div class="row"> 
                                                         <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Number:</label> 
                                                            <input v-model="form.independent_information_house_number" 
                                                                type="phone" 
                                                                name="independent_information_house_number" 
                                                                placeholder="Type House/Office Number" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_house_number') }"/>
                                                                 <has-error :form="form" field="independent_information_house_number"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels">Street Number:</label> 
                                                            <input v-model="form.independent_information_street_number" 
                                                                type="text" 
                                                                name="independent_information_street_number" 
                                                                placeholder="Type Street Number" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_street_number') }"/>
                                                                 <has-error :form="form" field="independent_information_street_number"></has-error> 
                                                        </div>
                                                        
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels">City:</label> 
                                                            <input v-model="form.independent_information_city" 
                                                                type="text" 
                                                                name="independent_information_city" 
                                                                placeholder="Type City" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_city') }"/>
                                                                 <has-error :form="form" field="independent_information_city"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">State:</label> 
                                                            <input v-model="form.independent_information_state" 
                                                                type="text" 
                                                                name="independent_information_state" 
                                                                placeholder="Type State" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_state') }"/>
                                                                 <has-error :form="form" field="independent_information_state"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Country:</label> 
                                                            <div class="position-relative form-group">
                                                                 <select v-model="form.independent_information_country"
                                                                    name="independent_information_country"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('independent_information_country') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Zip Code/ Postal Code:</label> 
                                                            <input v-model="form.independent_information_zip_code" 
                                                                type="phone" 
                                                                name="independent_information_zip_code" 
                                                                placeholder="Type Zip Code/ Postal Code" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_zip_code') }"/>
                                                                 <has-error :form="form" field="independent_information_zip_code"></has-error> 
                                                        </div> 

                                                    </div>
                                                                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-box-outer">
                                                    <h4>Contact</h4>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Email:</label> 
                                                            <input v-model="form.independent_information_email" 
                                                                type="email" 
                                                                name="independent_information_email" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_email') }"/>
                                                                 <has-error :form="form" field="independent_information_email"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Fax:</label> 
                                                            <input v-model="form.independent_information_fax_no" 
                                                                type="text" 
                                                                name="independent_information_fax_no" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_fax_no') }"/>
                                                                 <has-error :form="form" field="independent_information_fax_no"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Moblile Number:</label> 
                                                           <input v-model="form.independent_information_cell_phone" 
                                                                type="text" 
                                                                name="independent_information_cell_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_cell_phone') }"/>
                                                                 <has-error :form="form" field="independent_information_cell_phone"></has-error>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">Office Phone:</label> 
                                                           <input v-model="form.independent_information_office_phone" 
                                                                type="text" 
                                                                name="independent_information_office_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_office_phone') }"/>
                                                                 <has-error :form="form" field="independent_information_office_phone"></has-error>
                                                        </div> 

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Website :</label> 
                                                            <input v-model="form.independent_information_website" 
                                                                type="url" 
                                                                name="independent_information_website" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_website') }"/>
                                                                 <has-error :form="form" field="independent_information_website"></has-error>
                                                        </div>

                                                    </div>
                                                                                                   
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="form-folder">
                                    <h3><i class="fa fa-hand-point-right"></i>Emergency Contact Information:
                                        <button type="button" class="btn btn-primary btn-sm" @click="show_hide_professional_license()" v-show="!professional_license_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_professional_license()" v-show="professional_license_show">Hide</button>
                                    </h3> 
                                    <div class="form-holder" v-show="professional_license_show">
                                        <div class="row align-self-stretch">
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-box-outer">
                                                    
                                                    <div class="row">

                                                    
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels" >Full Name:</label>  
                                                            <input v-model="form.independent_information_full_name" 
                                                                type="text" 
                                                                placeholder="Type Full Name"
                                                                name="independent_information_full_name" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_full_name') }"/>
                                                            <has-error :form="form" field="independent_information_full_name"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels" >Gender:</label>  
                                                            <div class="position-relative form-group">
                                                            <select v-model="form.independent_information_gender"
                                                                name="independent_information_gender"
                                                                class="custom-select" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_gender') }">
                                                                <option disabled value="">--Select-- </option>
                                                                <option value="1">Male</option>
                                                                <option value="2">Female</option> 
                                                            </select>
                                                            <has-error :form="form" field="independent_information_gender"></has-error> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels" >Relation :</label>  
                                                            <input v-model="form.independent_information_relation" 
                                                                type="text" 
                                                                placeholder="Type Relation"
                                                                name="independent_information_relation" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_relation') }"/>
                                                            <has-error :form="form" field="independent_information_relation"></has-error>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels" >Date of Birth:</label>  
                                                            <input v-model="form.independent_information_date_of_birth" 
                                                                type="text" 
                                                                placeholder="Type Date of Birth"
                                                                name="independent_information_date_of_birth" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_date_of_birth') }"/>
                                                            <has-error :form="form" field="independent_information_date_of_birth"></has-error>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels" >Education Level:</label>  
                                                            <div class="position-relative form-group">
                                                            <select v-model="form.independent_information_education_level"
                                                                name="independent_information_education_level"
                                                                class="custom-select" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_education_level') }">
                                                                <option disabled value="">--Select-- </option>
                                                                <option value="1">Male</option>
                                                                <option value="2">Female</option> 
                                                            </select>
                                                            <has-error :form="form" field="independent_information_education_level"></has-error> 
                                                            </div>
                                                        </div>
                                                        
                                                          
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-box-outer">
                                                    <h4>Address</h4>
                                                    <div class="row"> 
                                                         <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Number:</label> 
                                                            <input v-model="form.independent_information_house_number" 
                                                                type="phone" 
                                                                name="independent_information_house_number" 
                                                                placeholder="Type House/Office Number" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_house_number') }"/>
                                                                 <has-error :form="form" field="independent_information_house_number"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels">Street Number:</label> 
                                                            <input v-model="form.independent_information_street_number" 
                                                                type="text" 
                                                                name="independent_information_street_number" 
                                                                placeholder="Type Street Number" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_street_number') }"/>
                                                                 <has-error :form="form" field="independent_information_street_number"></has-error> 
                                                        </div>
                                                        
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels">City:</label> 
                                                            <input v-model="form.independent_information_city" 
                                                                type="text" 
                                                                name="independent_information_city" 
                                                                placeholder="Type City" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_city') }"/>
                                                                 <has-error :form="form" field="independent_information_city"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">State:</label> 
                                                            <input v-model="form.independent_information_state" 
                                                                type="text" 
                                                                name="independent_information_state" 
                                                                placeholder="Type State" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_state') }"/>
                                                                 <has-error :form="form" field="independent_information_state"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Country:</label> 
                                                            <div class="position-relative form-group">
                                                                 <select v-model="form.independent_information_country"
                                                                    name="independent_information_country"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('independent_information_country') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Zip Code/ Postal Code:</label> 
                                                            <input v-model="form.independent_information_zip_code" 
                                                                type="phone" 
                                                                name="independent_information_zip_code" 
                                                                placeholder="Type Zip Code/ Postal Code" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_zip_code') }"/>
                                                                 <has-error :form="form" field="independent_information_zip_code"></has-error> 
                                                        </div> 

                                                    </div>
                                                                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-box-outer">
                                                    <h4>Contact</h4>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Email:</label> 
                                                            <input v-model="form.independent_information_email" 
                                                                type="email" 
                                                                name="independent_information_email" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_email') }"/>
                                                                 <has-error :form="form" field="independent_information_email"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Fax:</label> 
                                                            <input v-model="form.independent_information_fax_no" 
                                                                type="text" 
                                                                name="independent_information_fax_no" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_fax_no') }"/>
                                                                 <has-error :form="form" field="independent_information_fax_no"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Moblile Number:</label> 
                                                           <input v-model="form.independent_information_cell_phone" 
                                                                type="text" 
                                                                name="independent_information_cell_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_cell_phone') }"/>
                                                                 <has-error :form="form" field="independent_information_cell_phone"></has-error>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">Office Phone:</label> 
                                                           <input v-model="form.independent_information_office_phone" 
                                                                type="text" 
                                                                name="independent_information_office_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_office_phone') }"/>
                                                                 <has-error :form="form" field="independent_information_office_phone"></has-error>
                                                        </div> 

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Website :</label> 
                                                            <input v-model="form.independent_information_website" 
                                                                type="url" 
                                                                name="independent_information_website" 
                                                                :class="{ 'is-invalid': form.errors.has('independent_information_website') }"/>
                                                                 <has-error :form="form" field="independent_information_website"></has-error>
                                                        </div>

                                                    </div>
                                                                                                   
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="form-folder">
                                    <h3><i class="fa fa-hand-point-right"></i>Liability Insurance:

                                        <button type="button" class="btn btn-primary btn-sm" @click="show_hide_liability_insurence()" v-show="!liability_insurence_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_liability_insurence()" v-show="liability_insurence_show">Hide</button>
                                    </h3> 
                                    <div class="form-holder" v-show="liability_insurence_show">
                                        <div class="row align-self-stretch">
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-box-outer">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Issue name:</label> 
                                                            <input v-model="form.liabilities_insurence_issued_by" 
                                                               type="text" 
                                                               name="liabilities_insurence_issued_by" 
                                                               placeholder="Type Issue Name"
                                                               :class="{ 'is-invalid': form.errors.has('liabilities_insurence_issued_by') }"/>
                                                            <has-error :form="form" field="liabilities_insurence_issued_by"></has-error> 
                                                        </div>
                                                        <h4>Address</h4>
                                                         <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Number:</label> 
                                                            <input v-model="form.liabilities_insurence_house_number" 
                                                                type="phone" 
                                                                name="liabilities_insurence_house_number" 
                                                                placeholder="Type House/Office Number" 
                                                                :class="{ 'is-invalid': form.errors.has('liabilities_insurence_house_number') }"/>
                                                                 <has-error :form="form" field="liabilities_insurence_house_number"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels">Street Number:</label> 
                                                            <input v-model="form.liabilities_insurence_street_number" 
                                                                type="text" 
                                                                name="liabilities_insurence_street_number" 
                                                                placeholder="Type Street Number" 
                                                                :class="{ 'is-invalid': form.errors.has('liabilities_insurence_street_number') }"/>
                                                                 <has-error :form="form" field="liabilities_insurence_street_number"></has-error> 
                                                        </div>
                                                        
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels">City:</label> 
                                                            <input v-model="form.liabilities_insurence_city" 
                                                                type="text" 
                                                                name="liabilities_insurence_city" 
                                                                placeholder="Type City" 
                                                                :class="{ 'is-invalid': form.errors.has('liabilities_insurence_city') }"/>
                                                                 <has-error :form="form" field="liabilities_insurence_city"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">State:</label> 
                                                            <input v-model="form.liabilities_insurence_state" 
                                                                type="text" 
                                                                name="liabilities_insurence_state" 
                                                                placeholder="Type State" 
                                                                :class="{ 'is-invalid': form.errors.has('liabilities_insurence_state') }"/>
                                                                 <has-error :form="form" field="liabilities_insurence_state"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Country:</label> 
                                                            <div class="position-relative form-group">
                                                                 <select v-model="form.liabilities_insurence_country"
                                                                    name="liabilities_insurence_country"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('liabilities_insurence_country') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Zip Code/ Postal Code:</label> 
                                                            <input v-model="form.liabilities_insurence_zip_code" 
                                                                type="phone" 
                                                                name="liabilities_insurence_zip_code" 
                                                                placeholder="Type Zip Code/ Postal Code" 
                                                                :class="{ 'is-invalid': form.errors.has('liabilities_insurence_zip_code') }"/>
                                                                 <has-error :form="form" field="liabilities_insurence_zip_code"></has-error> 
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
                                                            <input v-model="form.liabilities_insurence_email" 
                                                                type="email" 
                                                                name="liabilities_insurence_email" 
                                                                :class="{ 'is-invalid': form.errors.has('liabilities_insurence_email') }"/>
                                                                 <has-error :form="form" field="liabilities_insurence_email"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Fax:</label> 
                                                            <input v-model="form.liabilities_insurence_fax_no" 
                                                                type="text" 
                                                                name="liabilities_insurence_fax_no" 
                                                                :class="{ 'is-invalid': form.errors.has('liabilities_insurence_fax_no') }"/>
                                                                 <has-error :form="form" field="liabilities_insurence_fax_no"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Phone:</label> 
                                                           <input v-model="form.liabilities_insurence_cell_phone" 
                                                                type="text" 
                                                                name="liabilities_insurence_cell_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('liabilities_insurence_cell_phone') }"/>
                                                                 <has-error :form="form" field="liabilities_insurence_cell_phone"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Website :</label> 
                                                            <input v-model="form.liabilities_insurence_website" 
                                                                type="url" 
                                                                name="liabilities_insurence_website" 
                                                                :class="{ 'is-invalid': form.errors.has('liabilities_insurence_website') }"/>
                                                                 <has-error :form="form" field="liabilities_insurence_website"></has-error>
                                                        </div>

                                                    </div>
                                                                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-box-outer">

                                                    <h4>Business Type</h4>
                                                    <div class="form-holder">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Licence No. :</label> 
                                                            <input v-model="form.liabilities_insurence_no" 
                                                                type="url" 
                                                                name="liabilities_insurence_no" 
                                                                :class="{ 'is-invalid': form.errors.has('liabilities_insurence_no') }"/>
                                                                <has-error :form="form" field="liabilities_insurence_no"></has-error>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Issue Date:</label> 
                                                            <date-picker 
                                                                style="width:100%"
                                                                v-model="form.liabilities_insurence_issue_date"
                                                                name="liabilities_insurence_issue_date"
                                                                lang="en"
                                                                type="liabilities_insurence_issue_date"
                                                                format="DD MMM, YYYY"
                                                                :class="{ 'is-invalid': form.errors.has('liabilities_insurence_issue_date') }">
                                                            </date-picker>
                                                            <has-error :form="form" field="liabilities_insurence_issue_date"></has-error> 

                                                            
                                                        </div>
                                                    
                                                      
                                                        <div class="col-md-12 col-sm-12 col-xs-12" >
                                                            <label class="fieldlabels">Expiry Date:</label> 
                                                            <div class="row"> 
                                                                <div class="col-md-7 col-sm-12 col-xs-12" style="padding:0">
                                                                    <date-picker 
                                                                        style="width:100%"
                                                                        v-model="form.liabilities_insurence_expire_date"
                                                                        name="liabilities_insurence_expire_date"
                                                                        lang="en"
                                                                        type="liabilities_insurence_expire_date"
                                                                        format="DD MMM, YYYY"
                                                                        :class="{ 'is-invalid': form.errors.has('liabilities_insurence_expire_date') }">
                                                                    </date-picker>
                                                                    <has-error :form="form" field="liabilities_insurence_expire_date"></has-error> 
                                                                </div>
                                                                <div class="col-md-5 col-sm-12 col-xs-12" style="padding:0">
                                                                    <div class="form-check-inline">

                                                                         <button 
                                                                            style="padding: .375rem"
                                                                            type="button" 
                                                                            class="btn  btn-warning"
                                                                            @click="liabilities_insurence_add_calender(2,index)" 
                                                                            v-if="form.liabilities_insurence_is_callender">Remove From Calender</button>

                                                                        <button 
                                                                            style="padding: .375rem"
                                                                            type="button" 
                                                                            class="btn  btn-primary" 
                                                                            @click="liabilities_insurence_add_calender(1,index)" 
                                                                            v-else>Add To Calender</button>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div> 

                                                            <label class="fieldlabels" >Validation Status:</label>       
                                                            <div class="position-relative form-group">
                                                                <select v-model="form.liabilities_insurence_validation_status"
                                                                    name="liabilities_insurence_validation_status"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('liabilities_insurence_validation_status') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option  value="1">Valid</option>
                                                                    <option  value="2">Expired</option>
                                                                </select>

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
            		system_no:'',
                    account_type:'',
                    entity_type:'',
                    first_name:'',
                    middle_name:'',
                    last_name:'',
                    industry_sector:'',
                    industry_sector_text:'',
                    reg_cor_dir_info:'',
                    register_corp_first_name:'',
                    register_corp_middle_name:'',
                    register_corp_last_name:'',
                    register_corp_phone_no:'',
                    register_corp_email:'',
                    register_emergency_contact:'',

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


                    business_license_issued_by:'',
                    business_license_house_number:'',
                    business_license_street_number:'',
                    business_license_city:'',
                    business_license_state:'',
                    business_license_country:'',
                    business_license_zip_code:'',
                    business_license_email:'',
                    business_license_fax_no:'',
                    business_license_cell_phone:'',
                    business_license_website:'',
                    business_license_no:'',
                    business_license_issue_date:'',
                    business_license_expire_date:'',
                    business_license_is_callender:false,
                    business_license_validation_status:'',

                    professional_license_associate_name:'',
                    professional_license_house_number:'',
                    professional_license_street_number:'',
                    professional_license_city:'',
                    professional_license_state:'',
                    professional_license_country:'',
                    professional_license_zip_code:'',
                    professional_license_email:'',
                    professional_license_fax_no:'',
                    professional_license_cell_phone:'',
                    professional_license_website:'',
                    professional_license_no:'',
                    professional_license_issue_date:'',
                    professional_license_expire_date:'',
                    professional_license_is_callender:false,
                    professional_license_validation_status:'',

                    liabilities_insurence_issued_by:'',
                    liabilities_insurence_house_number:'',
                    liabilities_insurence_street_number:'',
                    liabilities_insurence_city:'',
                    liabilities_insurence_state:'',
                    liabilities_insurence_country:'',
                    liabilities_insurence_zip_code:'',
                    liabilities_insurence_email:'',
                    liabilities_insurence_fax_no:'',
                    liabilities_insurence_cell_phone:'',
                    liabilities_insurence_website:'',
                    liabilities_insurence_no:'',
                    liabilities_insurence_issue_date:'',
                    liabilities_insurence_expire_date:'',
                    liabilities_insurence_is_callender:false,
                    liabilities_insurence_validation_status:'',

                    id:'',
                    

                                 	
                  	
            	}),
                main_company_arr:[],
                industry_sector_arr:[],
                industry_sector_display:false,
            	account_holder_arr:[],
            	countries:'',
                business_license_show:false,
                professional_license_show:false,
                liability_insurence_show:false,

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'System No', field: 'system_no' },
                    { label: 'Account Type', field: 'account_type_string' },
                    { label: 'Entity Type', field: 'entity_type' },
                    { label: 'Full Name', field: 'full_name' },
                    { label: 'Email', field: 'email' },
                    { label: 'Mobile No', field: 'cell_phone' },
                    { label: 'Country', field: 'country_name' },
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
            
            show_hide_business_license(){
                if(this.business_license_show)
                {
                    this.business_license_show=false;
                }
                else{
                    this.business_license_show=true;
                }
            },

            show_hide_professional_license(){
                if(this.professional_license_show)
                {
                    this.professional_license_show=false;
                }
                else{
                    this.professional_license_show=true;
                }
            },
            show_hide_liability_insurence(){
                if(this.liability_insurence_show)
                {
                    this.liability_insurence_show=false;
                }
                else{
                    this.liability_insurence_show=true;
                }
            },

            change_industry_sector()
            {

                if(this.form.industry_sector=="add")
                {
                    this.industry_sector_display=true;
                }
                else
                {
                    this.industry_sector_display=false;
                    this.form.industry_sector_text="";

                }
            },


            business_license_add_calender(type,index)
            {

                if(type==1)
                {
                    this.form.business_license_is_callender=true;
                }
                else{

                     this.form.business_license_is_callender=false;
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
                let uri = '/AccountHolderLists';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.account_holder_list;
                });
                this.list_showable=true;
            },

            check_comment_in_calender(e,type){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        this.form.comment_in_calender_yes=true;
                        this.form.comment_in_calender_no=false;
                        this.form.comment_in_calender=true;
                    }
                    else if(type==2)
                    {
                        this.form.comment_in_calender_yes=false;
                        this.form.comment_in_calender_no=true;
                        this.form.comment_in_calender=false;
                    }
                }
                else{
                    this.form.comment_in_calender_yes=false;
                    this.form.comment_in_calender_no=false;
                    this.form.comment_in_calender=false;
                }               
            },
            check_fiscal_year_in_calender(e,type){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        this.form.fiscal_year_in_calender_yes=true;
                        this.form.fiscal_year_in_calender_no=false;
                        this.form.fiscal_year_in_calender=true;
                    }
                    else if(type==2)
                    {
                        this.form.fiscal_year_in_calender_yes=false;
                        this.form.fiscal_year_in_calender_no=true;
                        this.form.fiscal_year_in_calender=false;
                    }
                }
                else{
                    this.form.fiscal_year_in_calender_yes=false;
                    this.form.fiscal_year_in_calender_no=false;
                    this.form.fiscal_year_in_calender=false;
                }               
            },
            add_govt_account()
            {

                this.form.government_account_lavel_data.push({
                    'id':'',
                    'reference_id':'',
                    'reference_value':'',
                    'account_number':'',
                    'filling_date':'',
                    'filling_cycle':'',
                    'is_callender':0,
                });
                return;

                $("#exampleModal").modal('show');
                $('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },


            fetchAccountHolder()
            {
                let uri = '/AccountHolders';
                window.axios.get(uri).then((response) => {
                    
                    this.industry_sector_arr                      =response.data.industry_sector_arr;
                    this.countries                                =response.data.country_arr;
                    this.account_holder_arr                       =response.data.account_holder_arr;
                    //this.payment_term_arr                       =response.data.payment_term_arr;
                   // this.currency_arr                           =response.data.currency_arr;
                   // this.key_position_lavel                     =response.data.key_position_lavel_arr;
                   // this.government_account_lavel               =response.data.government_account_lavel_arr;

                    this.editmode=false;
                    

                    
                }); 

                
            },
         
       

            updateAccountHolder()
            {
            
				
		        this.form.put('/AccountHolders/'+this.form.id).then(({ data })=>{
                        var response_data=data.split("**");
                        alert(response_data[0])
						if(response_data[0]*1==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Update Successfully'
                            });

                            this.editAccountHolder(response_data[1]);
                            this.editmode=true;

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

        	    this.form.post('/AccountHolders') .then(({ data }) => { 
               
					
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchAccountHolder();
        	    })
            },


            save_stay(type){

              

                this.form.post('/AccountHolders') .then(({ data }) => { 
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

                      this.form.delete('/AccountHolders/'+this.form.id).then(()=>{
                        
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
                let uri = '/AccountHolders/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.form.id=response.data.account_holder.id;
                    this.form.system_no=response.data.account_holder.system_no;
                    this.form.account_type=response.data.account_holder.account_type;
                    this.form.entity_type=response.data.account_holder.entity_type;
                    this.form.first_name=response.data.account_holder.first_name;
                    this.form.middle_name=response.data.account_holder.middle_name;
                    this.form.last_name=response.data.account_holder.last_name;
                    this.form.industry_sector=response.data.account_holder.industry_sector;
                    this.form.reg_cor_dir_info=response.data.account_holder.reg_cor_dir_info;
                    this.form.register_corp_first_name=response.data.account_holder.register_corp_first_name;
                    this.form.register_corp_middle_name=response.data.account_holder.register_corp_middle_name;
                    this.form.register_corp_last_name=response.data.account_holder.register_corp_last_name;
                    this.form.register_corp_phone_no=response.data.account_holder.register_corp_phone_no;
                    this.form.register_corp_email=response.data.account_holder.register_corp_email;
                    this.form.register_emergency_contact=response.data.account_holder.register_emergency_contact;
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
                    this.form.business_license_issued_by=response.data.account_holder.business_license_issued_by;
                    this.form.business_license_house_number=response.data.account_holder.business_license_house_number;
                    this.form.business_license_street_number=response.data.account_holder.business_license_street_number;
                    this.form.business_license_city=response.data.account_holder.business_license_city;
                    this.form.business_license_state=response.data.account_holder.business_license_state;
                    this.form.business_license_country=response.data.account_holder.business_license_country;
                    this.form.business_license_zip_code=response.data.account_holder.business_license_zip_code;
                    this.form.business_license_email=response.data.account_holder.business_license_email;
                    this.form.business_license_fax_no=response.data.account_holder.business_license_fax_no;
                    this.form.business_license_cell_phone=response.data.account_holder.business_license_cell_phone;
                    this.form.business_license_website=response.data.account_holder.business_license_website;
                    this.form.business_license_no=response.data.account_holder.business_license_no;
                    this.form.business_license_issue_date=response.data.account_holder.business_license_issue_date;
                    this.form.business_license_expire_date=response.data.account_holder.business_license_expire_date;
                    this.form.business_license_is_callender=response.data.account_holder.business_license_is_callender;
                    this.form.business_license_validation_status=response.data.account_holder.business_license_validation_status;

                    this.form.professional_license_associate_name=response.data.account_holder.professional_license_associate_name;
                    this.form.professional_license_house_number=response.data.account_holder.professional_license_house_number;
                    this.form.professional_license_street_number=response.data.account_holder.professional_license_street_number;
                    this.form.professional_license_city=response.data.account_holder.professional_license_city;
                    this.form.professional_license_state=response.data.account_holder.professional_license_state;
                    this.form.professional_license_country=response.data.account_holder.professional_license_country;
                    this.form.professional_license_zip_code=response.data.account_holder.professional_license_zip_code;
                    this.form.professional_license_email=response.data.account_holder.professional_license_email;
                    this.form.professional_license_fax_no=response.data.account_holder.professional_license_fax_no;
                    this.form.professional_license_cell_phone=response.data.account_holder.professional_license_cell_phone;
                    this.form.professional_license_website=response.data.account_holder.professional_license_website;
                    this.form.professional_license_no=response.data.account_holder.professional_license_no;
                    this.form.professional_license_issue_date=response.data.account_holder.professional_license_issue_date;
                    this.form.professional_license_expire_date=response.data.account_holder.professional_license_expire_date;
                    this.form.professional_license_is_callender=response.data.account_holder.professional_license_is_callender;
                    this.form.professional_license_validation_status=response.data.account_holder.professional_license_validation_status;


                    this.form.liabilities_insurence_issued_by=response.data.account_holder.liabilities_insurence_issued_by;
                    this.form.liabilities_insurence_house_number=response.data.account_holder.liabilities_insurence_house_number;
                    this.form.liabilities_insurence_street_number=response.data.account_holder.liabilities_insurence_street_number;
                    this.form.liabilities_insurence_city=response.data.account_holder.liabilities_insurence_city;
                    this.form.liabilities_insurence_state=response.data.account_holder.liabilities_insurence_state;
                    this.form.liabilities_insurence_country=response.data.account_holder.liabilities_insurence_country;
                    this.form.liabilities_insurence_zip_code=response.data.account_holder.liabilities_insurence_zip_code;
                    this.form.liabilities_insurence_email=response.data.account_holder.liabilities_insurence_email;
                    this.form.liabilities_insurence_fax_no=response.data.account_holder.liabilities_insurence_fax_no;
                    this.form.liabilities_insurence_cell_phone=response.data.account_holder.liabilities_insurence_cell_phone;
                    this.form.liabilities_insurence_website=response.data.account_holder.liabilities_insurence_website;
                    this.form.liabilities_insurence_no=response.data.account_holder.liabilities_insurence_no;
                    this.form.liabilities_insurence_issue_date=response.data.account_holder.liabilities_insurence_issue_date;
                    this.form.liabilities_insurence_expire_date=response.data.account_holder.liabilities_insurence_expire_date;
                    this.form.liabilities_insurence_is_callender=response.data.account_holder.liabilities_insurence_is_callender;
                    this.form.liabilities_insurence_validation_status=response.data.account_holder.liabilities_insurence_validation_status;

                    this.industry_sector_arr                      =response.data.industry_sector_arr;
                    this.countries                                =response.data.country_arr;
                    this.account_holder_arr                       =response.data.account_holder_arr;

                    this.editmode=true;
                    


                    
                }); 

                
            },


	    }
    
    }  
	
</script>



