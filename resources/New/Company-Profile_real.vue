<template>

	<section class="app-main__inner">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card">
                <form id="msform" @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">  
                    <fieldset>
                        <div class="form-card">
                            <h1 class="page-head">General Information</h1> 
                            <div class="form-folder">
                                <h3><i class="fa fa-hand-point-right"></i> Company Profile:</h3> 
                                <div class="form-holder">
                                    <div class="row align-self-stretch"> 
                                          <div class="col-md-4 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer">
                                                <h4>Account No</h4>
                                                <input type="text" id="account_no" name="account_no" v-model="form.account_no" placeholder="Account No" disabled/> 
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <h4>Main Company 
                                                        </h4> 
                                                        
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <div class="form-check-inline">
                                                        <input type="checkbox" value="1" 
                                                            name="main_company" 
                                                            id="main_company"
                                                            v-model="form.main_company">
                                                        </div>
                                                             
                                                    </div>
                                                </div>
                                                <h4 v-show="!form.main_company"> Main Company Name</h4>
                                                <select
                                                    v-show="!form.main_company"
                                                    v-model="form.main_company_name"
                                                    name="main_company_name"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('main_company_name') }">
                                                    <option disabled value="">--Select Main Company-- </option>
                                                    <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                </select>  
                                                <h4 v-show="form.main_company">Main Company Legal Name</h4>
                                                <h4 v-show="!form.main_company">Subsidiary Company Legal Name</h4>
                                                <input v-model="form.legal_name" 
													type="text" 
													placeholder="Type Company Legal Name"
													name="legal_name" 
													:class="{ 'is-invalid': form.errors.has('legal_name') }"/>
												      <has-error :form="form" field="legal_name"></has-error>
													  <input v-model="form.id" type="hidden" name="id">
                                                <h4>Company logo</h4>
                                                <input type="file" id="logo_pic"  name="logo_pic"  accept="image/*">
                                                <h4>Customer Type</h4>
                                                <div class="form-holder">
                                                    <div class="form-check-inline">
                                                        <input type="checkbox" value="0" 
                                                            name="customer_property_management" 
                                                            id="customer_property_management"
                                                            v-model="form.customer_property_management" >
                                                        <label for="customer_property_management">Property Management</label><br>

                                                        <input type="checkbox" value="0" 
                                                            name="customer_seller" 
                                                            id="customer_seller"
                                                            v-model="form.customer_seller">
                                                        <label for="customer_seller">Seller</label><br>

                                                        <input type="checkbox" value="0" 
                                                            name="customer_service_provider" 
                                                            id="customer_service_provider"
                                                            v-model="form.customer_service_provider" >
                                                        <label for="customer_service_provider">Service Providers</label><br>
                                                        
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Business Registration</h4>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Number:</label> 
                                                         <input v-model="form.business_registration_number" 
                                                    type="text" 
                                                    name="business_registration_number" 
                                                    placeholder="Type Number" 
                                                    :class="{ 'is-invalid': form.errors.has('business_registration_number') }"/>
                                                     <has-error :form="form" field="business_registration_number"></has-error> 
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Date:</label> 
                                                    <date-picker 
                                                    v-model="form.registration_date"
                                                    name="registration_date"
                                                    lang="en"
                                                    type="registration_date"
                                                    format="DD MMM, YYYY"
                                                    :class="{ 'is-invalid': form.errors.has('registration_date') }"></date-picker>
                                                  <has-error :form="form" field="registration_date"></has-error> 
                                                    </div>
                                                </div>

                                                <h4>Location</h4>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">City:</label> 
                                                        <input v-model="form.business_registration_city" 
                                                            type="text" 
                                                            name="business_registration_city" 
                                                            placeholder="Type City" 
                                                            :class="{ 'is-invalid': form.errors.has('business_registration_city') }"/>
                                                             <has-error :form="form" field="business_registration_city"></has-error>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">State:</label> 
                                                       <input v-model="form.business_registration_state" 
                                                            type="text" 
                                                            name="business_registration_state" 
                                                            placeholder="Type State" 
                                                            :class="{ 'is-invalid': form.errors.has('business_registration_state') }"/>
                                                             <has-error :form="form" field="business_registration_state"></has-error>
                                                    </div>
                                                </div>
                                                <label class="fieldlabels">Country:</label> 
                                                <div class="position-relative form-group">
                                                    <select v-model="form.registration_country"
                                                        name="registration_country"
                                                        class="custom-select" 
                                                        :class="{ 'is-invalid': form.errors.has('registration_country') }">
                                                        <option disabled value="">--Select-- </option>
                                                        <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                    </select>
                                                </div>
                                                <h4>Miunicipal Business License</h4>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Number:</label> 
                                                       <input v-model="form.business_license_no" 
													type="text" 
													name="business_license_no" 
													placeholder="Type Number" 
													:class="{ 'is-invalid': form.errors.has('business_license_no') }"/>
												     <has-error :form="form" field="business_license_no"></has-error>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Issued By:</label> 
                                                       <input v-model="form.issued_by" 
													type="text" 
													name="issued_by" 
													placeholder="Type Issued By"
													:class="{ 'is-invalid': form.errors.has('issued_by') }"/>
												     <has-error :form="form" field="issued_by"></has-error> 
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">State:</label> 
                                                        <input v-model="form.license_state" 
															type="text" 
															name="license_state"
															placeholder="Type State" 
															:class="{ 'is-invalid': form.errors.has('license_state') }"/>
														     <has-error :form="form" field="license_state"></has-error> 
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Country:</label> 
                                                        <div class="position-relative form-group">
                                                             <select v-model="form.license_country"
                                                            	name="license_country" 
                                                            	class="custom-select" 
                                                            	:class="{ 'is-invalid': form.errors.has('license_country') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  	</select>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <label class="fieldlabels">Expiry Date:</label> 
                                                   <date-picker 
    							                     	v-model="form.expirey_date"
    							                     	name="expirey_date"                                                         	lang="en" 
                                                        placeholder="Enter Date" 
                                                        format="DD MMM, YYYY"
    							                     	:class="{ 'is-invalid': form.errors.has('expirey_date') }">
                                                    </date-picker>
											      <has-error :form="form" field="expirey_date"></has-error> 
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Head Office Address</h4>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Number:</label> 
                                                        <input v-model="form.headoffice_house_number" 
                                                            type="phone" 
                                                            name="headoffice_house_number" 
                                                            placeholder="Type House/Office Number" 
                                                            :class="{ 'is-invalid': form.errors.has('headoffice_house_number') }"/>
                                                             <has-error :form="form" field="headoffice_house_number"></has-error> 
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Street Number:</label> 
                                                       <input v-model="form.headoffice_street_number" 
                                                            type="text" 
                                                            name="headoffice_street_number" 
                                                            placeholder="Type Street Number" 
                                                            :class="{ 'is-invalid': form.errors.has('headoffice_street_number') }"/>
                                                             <has-error :form="form" field="headoffice_street_number"></has-error> 
                                                    </div>
                                                    
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input v-model="form.headoffice_city" 
                                                            type="text" 
                                                            name="headoffice_city" 
                                                            placeholder="Type City" 
                                                            :class="{ 'is-invalid': form.errors.has('headoffice_city') }"/>
                                                             <has-error :form="form" field="headoffice_city"></has-error> 
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">State:</label> 
                                                        <input v-model="form.headoffice_state" 
                                                            type="text" 
                                                            name="headoffice_state" 
                                                            placeholder="Type State" 
                                                            :class="{ 'is-invalid': form.errors.has('headoffice_state') }"/>
                                                             <has-error :form="form" field="headoffice_state"></has-error>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Country:</label> 
                                                        <div class="position-relative form-group">
                                                             <select v-model="form.headoffice_country"
                                                                name="headoffice_country"
                                                                class="custom-select" 
                                                                :class="{ 'is-invalid': form.errors.has('headoffice_country') }">
                                                                <option disabled value="">--Select-- </option>
                                                                <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Zip Code/ Postal Code:</label> 
                                                        <input v-model="form.headoffice_zip_code" 
                                                            type="phone" 
                                                            name="headoffice_zip_code" 
                                                            placeholder="Type Zip Code/ Postal Code" 
                                                            :class="{ 'is-invalid': form.errors.has('headoffice_zip_code') }"/>
                                                             <has-error :form="form" field="headoffice_zip_code"></has-error> 
                                                    </div>
                                                </div>
                                                <h4>Contact</h4>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Email:</label> 
                                                        <input v-model="form.contact_person_email" 
															type="email" 
															name="contact_person_email" 
															:class="{ 'is-invalid': form.errors.has('contact_person_email') }"/>
														     <has-error :form="form" field="contact_person_email"></has-error>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Fax:</label> 
                                                        <input v-model="form.contact_person_fax_no" 
															type="text" 
															name="contact_person_fax_no" 
															:class="{ 'is-invalid': form.errors.has('contact_person_fax_no') }"/>
														     <has-error :form="form" field="contact_person_fax_no"></has-error> 
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Phone:</label> 
                                                       <input v-model="form.contact_person_cell_phone" 
															type="text" 
															name="contact_person_cell_phone" 
															:class="{ 'is-invalid': form.errors.has('contact_person_cell_phone') }"/>
														     <has-error :form="form" field="contact_person_cell_phone"></has-error>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Website :</label> 
                                                       <input v-model="form.contact_person_website" 
															type="url" 
															name="contact_person_website" 
															:class="{ 'is-invalid': form.errors.has('contact_person_website') }"/>
														     <has-error :form="form" field="contact_person_website"></has-error>
                                                    </div> 
                                                </div>


                                                
                                                
                                                   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="form-card">  
                            
                            <div class="form-holder">
                                <h3><i class="fa fa-hand-point-right"></i> Company Class : </h3>
                                <div class="row align-self-stretch"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-box-outer">
                                            <h4>Business Type</h4>
                                            <div class="form-holder">
                                                <div class="form-check-inline"> 
                                                    <input 
                                                        type="checkbox" value="0" 
														name="property_management" 
														id="property_management"
														v-model="form.property_management" >
                                                    <label for="property_management">Property Management</label><br>
                                                      <input 
                                                            type="checkbox" 
															name="strata_management" 
															id="strata_management"
															v-model="form.strata_management" >
                                                    <label for="strata_management">Starta  Management</label><br>

                                                   <input type="checkbox" value="0" 
														name="leasehold_management" 
														id="leasehold_management"
														v-model="form.leasehold_management">
                                                    <label for="management_type3">Leasehold  Management</label><br>
                                                    <input 
                                                        type="checkbox" value="0" 
														name="parking_management_industry" 
														id="parking_management_industry"
														v-model="form.parking_management_industry"> 
                                                    <label for="parking_management_industry">Parking Industry</label><br>
                                                    <input 
                                                        type="checkbox" 
                                                        value="0" 
														name="storage_management_company" 
														id="storage_management_company"
														v-model="form.storage_management_company" > 
                                                    <label for="storage_management_company">Storage Management Company</label><br>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-box-outer">
                                            <h4>Dedicated Calendar</h4>
                                            <div class="form-holder">
                                                <div class="form-check-inline"> 
                                                    <input type="checkbox" 
									                        	id="calender_director" 
									                        	name="calender_director" 
									                        	v-model="form.calender_director">
                                                    <label for="calender_director">Director</label><br>

                                                    <input type="checkbox" 
									                        	id="calender_accounting_manager" 
									                        	name="calender_accounting_manager" 
									                        	v-model="form.calender_accounting_manager">
                                                    <label for="op2">Accounting Manager</label><br> 

                                                    <input type="checkbox" 
									                        	id="calender_accounts_payable" 
									                        	name="calender_accounts_payable" 
									                        	v-model="form.calender_accounts_payable">
                                                    <label for="op3">Accounts Payable</label><br>

                                                    <input type="checkbox" value="0" 
																name="calender_building_manager" 
																id="calender_building_manager"
																v-model="form.calender_building_manager" >
                                                    <label for="calender_building_manager">Building Manager</label><br>

                                                    <input type="checkbox" value="0" 
																name="calender_general_manager" 
																id="calender_general_manager"
																v-model="form.calender_general_manager" >
                                                    <label for="calender_general_manager">General Manager</label><br>

                                                    <input type="checkbox" value="0" 
																name="calender_network_administrator" 
																id="calender_network_administrator"
																v-model="form.calender_network_administrator" >
                                                    <label for="calender_network_administrator">Network Administrator</label><br>

                                                    <input type="checkbox" value="0" 
                                                                name="calender_property_manager" 
                                                                id="calender_property_manager"
                                                                v-model="form.calender_property_manager" >
                                                    <label for="calender_property_manager">Property Manager</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>

                        <div class="form-card"> 
                            
                            <div class="form-folder">
                                <h3><i class="fa fa-hand-point-right"></i>Key Position</h3>
                                <div class="form-holder">
                                    <div class="row align-self-stretch">
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12"> 
                                            <div class="form-box-outer">
                                                <table class="table">
                                                    
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Key Positions </th>
                                                            <th scope="col">Name</th>
                                                            
                                                            <th scope="col">Ph. Office</th>
                                                            <th scope="col">Ph. Mobile</th>
                                                            <th scope="col">Email</th>
                                                            <th scope="col">Fax</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody style="border:none">
                                                        
                                                       
                                                        <tr v-for="(key_position,index) in form.key_position_lavel_data">
                                                            <th width="20%" scope="row"><h6>{{key_position.reference_value}}</h6></th>
                                                            <td width="15%">
                                                                <input 
                                                                    type="text"
                                                                    v-bind:id="'key_position_name_'+index"
                                                                    placeholder="Type Name"
                                                                    name="key_position_name[]" 
                                                                    v-model="key_position.key_position_name"/>
                                                            </td>
                                                            <td width="10%">
                                                                <div class="form-check-inline">
                                                                    

                                                                    <input 
                                                                        type="text"
                                                                        v-bind:id="'office_phone_'+index"
                                                                        placeholder="Type Office Phone"
                                                                        name="office_phone[]" 
                                                                        v-model="key_position.office_phone"/>
                                                                </div>
                                                            </td>
                                                            
                                                            <td width="10%">
                                                                <div class="form-check-inline">
                                                                    <input 
                                                                        type="text"
                                                                        v-bind:id="'office_mobile_'+index"
                                                                        placeholder="Type Mobile Phone"
                                                                        name="office_mobile[]" 
                                                                        v-model="key_position.office_mobile"/>
                                                                </div>
                                                            </td>
                                                            <td width="15%">
                                                                <div class="form-check-inline">
                                                                    <input 
                                                                        type="text"
                                                                        v-bind:id="'email_'+index"
                                                                        placeholder="Type Email"
                                                                        name="email[]" 
                                                                        v-model="key_position.email"/>
                                                                </div>
                                                            </td>
                                                            <td width="15%">

                                                                <input 
                                                                        type="text"
                                                                        v-bind:id="'fax_'+index"
                                                                        placeholder="Type Fax Number"
                                                                        name="fax[]" 
                                                                        v-model="key_position.fax"/>
                                                                
                                                            </td>
                                                            
                                                        </tr>
                                                        

                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                       
                                        
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <div class="form-folder">
                                <h3><i class="fa fa-hand-point-right"></i>Governments Accounts</h3>
                                <div class="form-holder">
                                    <div class="row align-self-stretch">
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12"> 
                                            <div class="form-box-outer">
                                                <table class="table table-bordered">
                                                    
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Particular</th>
                                                            <th scope="col">Number</th>
                                                            <th scope="col">Filling Due Date</th>
                                                            <th scope="col">Filling Cycle</th>
                                                            <th scope="col">Add to Calender</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="border:none">
                                                        
                                                       
                                                        <tr v-for="(government_account,index) in form.government_account_lavel_data">
                                                            <th width="20%" scope="row"><h6>{{government_account.reference_value}}</h6></th>
                                                            <td width="20%">
                                                                <input 
                                                                    type="text"
                                                                    v-bind:id="'account_number_'+index"
                                                                    placeholder="Type Account Number"
                                                                    name="account_number[]" 
                                                                    v-model="government_account.account_number"/>
                                                            </td>
                                                            <td width="20%" >
                                                                
                                                                    
                                                                     <date-picker 
                                                                        style="width:100%"
                                                                        v-bind:id="'filling_date_'+index"
                                                                        placeholder="Type Filling Date"
                                                                        name="filling_date[]"
                                                                        lang="en"
                                                                        v-model="government_account.filling_date"
                                                                        format="DD MMM, YYYY"
                                                                        :class="{ 'is-invalid': form.errors.has('filling_date') }"></date-picker>
                                                                      <has-error :form="form" field="filling_date"></has-error>
                                                                    
                                                                
                                                            </td>
                                                            
                                                            <td width="20%">
                                                                <div class="form-check-inline">
                                                                   
                                                                    <select
                                                                        
                                                                        v-model="government_account.filling_cycle"
                                                                        v-bind:id="'filling_cycle_'+index"
                                                                        name="filling_cycle[]" 
                                                                        class="custom-select" 
                                                                        :class="{ 'is-invalid': form.errors.has('main_company_name') }">
                                                                        <option disabled value="">--Select Filling Cycle-- </option>
                                                                        <option value="1">Quarterly</option>
                                                                        <option value="2">Half Yearly</option>
                                                                        <option value="3"> Yearly</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td width="15%" align="center">
                                                                <div class="form-check-inline">

                                                                     <button 
                                                                        type="button" 
                                                                        class="btn  btn-warning"
                                                                        @click="govt_account_add_calender(2,index)" 
                                                                        v-if="government_account.is_callender">Remove From Calender</button>

                                                                    <button 
                                                                        type="button" 
                                                                        class="btn  btn-primary" 
                                                                        @click="govt_account_add_calender(1,index)" 
                                                                        v-else>Add To Calender</button>
                                                                </div>
                                                            </td>
                                                            
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">
                                                                <button 
                                                                        type="button" 
                                                                        class="btn  btn-primary" 
                                                                        @click="add_govt_account()">Add New Accounts</button>
                                                            </td>
                                                        
                                                        </tr>
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                       
                                        
                                        <hr>
                                    </div>
                                </div>
                            </div>

                           
                        </div> 
                    </fieldset> 
					<button :disabled="form.busy"  type="submit" class="next action-button">Next <i class="fa fa-angle-right"></i></button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

                </form>
            </div>
        </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</section>

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
            		

            		type_of_operation:0,
            		strata_management:false,
            		parking_management_industry:false,
            		storage_management_company:false,
            		leasehold_management:false,
            		property_management:false,

                    customer_property_management:false,
                    customer_seller:false,
                    customer_service_provider:false,

                  	id:'',
                  	legal_name:'',
                    main_company_name:'',
                  	business_registration_number:'',
                  	registration_date:'',
                  	business_registration_city:'',
                  	business_registration_state:'',
                  	registration_country:'',
                  	business_license_no:'',
                  	issued_by:'',
                  	license_state:'',
                  	license_country:'',
                  	expirey_date:'',
                    headoffice_house_number:'',
                  	headoffice_street_number:'',
                  	headoffice_city:'',
                  	headoffice_state:'',
                  	headoffice_country:'',
                    headoffice_zip_code:'',

                    calender_property_manager:false,
                    calender_general_manager:false,
                    calender_building_manager:false,
                    calender_accounts_payable:false,
                    calender_accounting_manager:false,
                    calender_director:false,
                    calender_network_administrator:false,



                  	contact_person_email:'',
                  	contact_person_fax_no:'',
                  	contact_person_cell_phone:'',
                  	contact_person_website:'',
                  	business_number:'',
                  	emp_identification_number:'',
                  	payroll:'',
                  	sales_tax:'',
                  	income_tax:'',
                  	import_and_export:'',

                  	

                  	rantal_suite_unit:false,
                  	buy_and_sell_suite_unit:false,
                  	rental_parking:false,
                  	rental_storage:false,
                  	landholders_residency:false,
                    key_position_lavel_data:[],
                    government_account_lavel_data:[],
					  // new filed list database not difine filed 
	            /*
                    company_director_name:'',
                    company_phone_office:'',
                    company_phone_mobile:'',
                    company_emaill_address:'',
                    contact_full_name:'',
                    contact_job_title:'',
                    street_Number_name:'',
                    contact_state_province:'',
                    contact_country:'',
                    contact_city:'',
                    contact_postal_code:'',
                    contact_post_box:'',
                    contact_phone_office:'',
                    contact_phone_mobile:'',
                    contact_phone_fax:'',
                    contact_email_address:'',
                    owner_operator_management:0,
                    parking_management_company:0,
                    storage_management_company:0,
                    sellers_management:0,
                    dependent_residential_building:false,
                    dependent_commercial_building:false,
                    business_licence_no:'',
                    business_licence_expiration_date:'',
                    business_licence_renew_date:''  
                */

            	}),
                main_company_arr:[],
            	account_no:'',
            	countries:'',
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchCompanyProfile();
           
        },
		
	    methods: {

            govt_account_add_calender(type,index)
            {

                if(type==1)
                {
                    this.form.government_account_lavel_data[index].is_callender=true;
                }
                else{

                     this.form.government_account_lavel_data[index].is_callender=false;
                }

            },

            

          
	    	

	    	check_operation_type(e,type){
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.buy_and_sell_suite_unit=false;
		    			this.form.rental_parking=false;
		    			this.form.rental_storage=false;
		    			this.form.landholders_residency=false;
		    			this.form.type_of_operation=1;
		    		}
		    		else if(type==2)
		    		{
		    			this.form.rantal_suite_unit=false;
		    			this.form.rental_parking=false;
		    			this.form.rental_storage=false;
		    			this.form.landholders_residency=false;
		    			this.form.type_of_operation=2;
		    		}
		    		else if(type==3)
		    		{
		    			this.form.rantal_suite_unit=false;
		    			this.form.buy_and_sell_suite_unit=false;
		    			this.form.rental_storage=false;
		    			this.form.landholders_residency=false;
		    			this.form.type_of_operation=3;
		    		}
		    		else if(type==4)
		    		{
		    			this.form.rantal_suite_unit=false;
		    			this.form.buy_and_sell_suite_unit=false;
		    			this.form.rental_parking=false;
		    			this.form.landholders_residency=false;
		    			this.form.type_of_operation=4;
		    		}
		    		else if(type==5)
		    		{
		    			this.form.rantal_suite_unit=false;
		    			this.form.buy_and_sell_suite_unit=false;
		    			this.form.rental_parking=false;
		    			this.form.rental_storage=false;
		    			this.form.type_of_operation=5;
		    		}
	    		}	    		
	    	},
            



	        fetchCompanyProfile_old()
            {
                let uri = '/AccountSetups';
                window.axios.get(uri).then((response) => {
                	this.account_no								=response.data.account_no;
                	this.form.strata_management 				= response.data.company_data.strata_management;
                	this.form.leasehold_management 				= response.data.company_data.leasehold_management;
                	this.form.free_hold_management 				= response.data.company_data.free_hold_management;
                	this.form.strata_management 				= response.data.company_data.strata_management;
                	this.form.coop_property 					= response.data.company_data.coop_property;
                	this.form.property_management 				= response.data.company_data.property_management;
                	this.form.id 								= response.data.company_data.id;

                	this.form.legal_name 						= response.data.company_data.legal_name;
                	this.form.business_registration_number 		= response.data.company_data.business_registration_number;
                	this.form.registration_date 				= response.data.company_data.registration_date;
                	this.form.business_registration_city 		= response.data.company_data.business_registration_city;
                	this.form.business_registration_state 		= response.data.company_data.business_registration_state;
                	this.form.registration_country 				= response.data.company_data.registration_country;
                	this.form.business_license_no 				= response.data.company_data.business_license_no;

                	this.form.issued_by 						= response.data.company_data.issued_by;
                	this.form.license_country 					= response.data.company_data.license_country;
                	this.form.expirey_date 						= response.data.company_data.expirey_date;
                	this.form.head_office_email 				= response.data.company_data.head_office_email;
                	this.form.head_office_fax_no 				= response.data.company_data.head_office_fax_no;
                	this.form.head_office_cell_phone 			= response.data.company_data.head_office_cell_phone;
                	this.form.head_office_website 				= response.data.company_data.head_office_website;


                	this.form.contact_person_email 				= response.data.company_data.contact_person_email;
                	this.form.contact_person_fax_no 			= response.data.company_data.contact_person_fax_no;
                	this.form.contact_person_cell_phone 		= response.data.company_data.contact_person_cell_phone;
                	this.form.contact_person_website 			= response.data.company_data.contact_person_website;

                	this.form.business_number 					= response.data.company_data.business_number;
                	this.form.emp_identification_number 		= response.data.company_data.emp_identification_number;
                	this.form.payroll 							= response.data.company_data.payroll;
                	this.form.sales_tax 						= response.data.company_data.sales_tax;
                	this.form.income_tax 						= response.data.company_data.income_tax;
                	this.form.import_and_export 				= response.data.company_data.import_and_export;

                    /// new fild  list database not filed difine 
                    /*

                    this.form.company_director_name 			= response.data.company_data.company_director_name;
                    this.form.company_phone_office 				= response.data.company_data.company_phone_office;
                    this.form.company_phone_mobile 				= response.data.company_data.company_phone_mobile;
                    this.form.company_emaill_address 			= response.data.company_data.company_emaill_address;
                    this.form.contact_full_name 				= response.data.company_data.contact_full_name;
                    this.form.contact_job_title 				= response.data.company_data.contact_job_title;
                    this.form.street_Number_name 				= response.data.company_data.street_Number_name;
                    this.form.contact_state_province 			= response.data.company_data.contact_state_province;
                    this.form.contact_country 				    = response.data.company_data.contact_country;
                    this.form.contact_city 				        = response.data.company_data.contact_city;
                    this.form.contact_postal_code 				= response.data.company_data.contact_postal_code;
                    this.form.contact_post_box 				    = response.data.company_data.contact_post_box;
                    this.form.contact_phone_office 				= response.data.company_data.contact_phone_office;
                    this.form.contact_phone_mobile 				= response.data.company_data.contact_phone_mobile;
                    this.form.contact_phone_fax 				= response.data.company_data.contact_phone_fax;
                    this.form.contact_email_address 			= response.data.company_data.contact_email_address;
                    this.form.service_providers_management 		= response.data.company_data.service_providers_management;
                    this.form.owner_operator_management 		= response.data.company_data.owner_operator_management;
                    this.form.parking_management_company 		= response.data.company_data.parking_management_company;
                    this.form.storage_management_company 		= response.data.company_data.storage_management_company;
                    this.form.sellers_management 				= response.data.company_data.sellers_management;
                    this.form.dependent_residential_building 	= response.data.company_data.dependent_residential_building;
                    this.form.dependent_commercial_building 	= response.data.company_data.dependent_commercial_building;
                    this.form.business_licence_no 				= response.data.company_data.business_licence_no;
                    this.form.business_licence_expiration_date 	= response.data.company_data.business_licence_expiration_date;
                    this.form.business_licence_renew_date 		= response.data.company_data.business_licence_renew_date;
                             
                        
                */
                	
                	if(this.form.id){
                		this.editmode=true;
                	}

                	this.countries 								=response.data.country_arr;
                	
                });   
            },

            fetchCompanyProfile()
            {
                let uri = '/CompanyProfiles';
                window.axios.get(uri).then((response) => {
                    
                    this.main_company_arr                       =response.data.main_company_arr;
                    this.countries                              =response.data.country_arr;
                    this.account_status_arr                     =response.data.account_status_arr;
                    this.payment_term_arr                       =response.data.payment_term_arr;
                    this.currency_arr                           =response.data.currency_arr;
                    this.key_position_lavel                     =response.data.key_position_lavel_arr;
                    this.government_account_lavel               =response.data.government_account_lavel_arr;


                    for(let i=0; i<this.government_account_lavel.length; i++){

                        this.form.government_account_lavel_data.push({
                            'id':'',
                            'reference_id':this.government_account_lavel[i].id,
                            'reference_value':this.government_account_lavel[i].field_name,
                            'account_number':'',
                            'filling_date':'',
                            'filling_cycle':'',
                            'is_callender':'',
                        
                        });
                    }

                    for(let i=0; i<this.key_position_lavel.length; i++){

                        this.form.key_position_lavel_data.push({
                            'id':'',
                            'reference_id':this.key_position_lavel[i].id,
                            'reference_value':this.key_position_lavel[i].field_name,
                            'office_phone':'',
                            'office_mobile':'',
                            'fax':'',
                            'key_position_name':'',
                            'email':'',
                        
                        });
                    }

                    
                }); 

                
            },
         
       

            updateCompanyProfile()
            {
            
				let route = this.$router.resolve({ path: "/Temp-ContactsPersons" });
      			window.open(route.href,'_self');
      			return;
		        this.form.put('/AccountSetups/'+this.form.id)
				    .then(()=>{
					       //success
					     
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchCompanyProfile();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createCompanyProfile()
            {

            	
            	
        	    this.form.post('/AccountSetups') .then(({ data }) => { 
               
					
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					//this.fetchCompanyProfile();
        	    })
            }
	    }
    
    }  
	
</script>