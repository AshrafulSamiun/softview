<template>

	<section class="app-main__inner">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card">
                <form id="msform" @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">  
                    <fieldset>
                        <div class="form-card">
                            <h1 class="page-head"> Company Profile</h1> 
                            <div class="form-folder">
                                <h3><i class="fa fa-hand-point-right"></i>General Information:</h3> 
                                <div class="form-holder">
                                    <div class="row align-self-stretch"> 
                                        <div class="col-md-3 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer">
                                                <h4>Account Details</h4>
                                                <label class="fieldlabels">Account No:</label> 
                                                <input type="text" id="account_no" name="account_no" v-model="form.account_no" placeholder="Account No" disabled/> 
                                                
                                                
                                                <label class="fieldlabels" >Legal Name:</label>  
                                               
                                                <input v-model="form.legal_name" 
													type="text" 
													placeholder="Type Legal Name"
													name="legal_name" 
													:class="{ 'is-invalid': form.errors.has('legal_name') }"/>
												      <has-error :form="form" field="legal_name"></has-error>
													  <input v-model="form.id" type="hidden" name="id">
                                               
                                                <label class="fieldlabels">Scope of Operation:</label> 
                                                
                                                <div class="position-relative form-group">
                                                    <select v-model="form.scope_of_operation"
                                                        name="scope_of_operation"
                                                        class="custom-select" 
                                                        :class="{ 'is-invalid': form.errors.has('scope_of_operation') }">
                                                        <option disabled value="">--Select-- </option>
                                                        <option value="1">Domestic</option>
                                                        <option value="2">International</option>
                                                        <option value="3">Both</option>
                                                    </select>
                                                    <has-error :form="form" field="scope_of_operation"></has-error> 
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Business Registration</h4>
                                                
                                                        <label class="fieldlabels">Number:</label> 
                                                         <input 
                                                            v-model="form.business_registration_number" 
                                                            type="text" 
                                                            name="business_registration_number" 
                                                            placeholder="Type Number" 
                                                            :class="{ 'is-invalid': form.errors.has('business_registration_number') }"/>
                                                        <has-error :form="form" field="business_registration_number"></has-error> 
                                                  
                                                       
                                                        <label class="fieldlabels">Registration Date:</label> 
                                                        <date-picker 
                                                            style="100%"
                                                            v-model="form.registration_date"
                                                            name="registration_date"                                                         lang="en" 
                                                            placeholder="Enter Date" 
                                                            format="DD MMM, YYYY"
                                                            :class="{ 'is-invalid': form.errors.has('registration_date') }">
                                                        </date-picker>
                                                      <has-error :form="form" field="registration_date"></has-error>   

                                                <h4>Location</h4>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">City:</label> 
                                                        <input v-model="form.business_registration_city" 
                                                            type="text" 
                                                            name="business_registration_city" 
                                                            placeholder="Type City" 
                                                            :class="{ 'is-invalid': form.errors.has('business_registration_city') }"/>
                                                        <has-error :form="form" field="business_registration_city"></has-error>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
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
                                                
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Miunicipal Business License</h4>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">Number:</label> 
                                                        <input v-model="form.business_license_no" 
                                                           type="text" 
                                                           name="business_license_no" 
                                                           placeholder="Type Number" 
                                                           :class="{ 'is-invalid': form.errors.has('business_license_no') }"/>
                                                        <has-error :form="form" field="business_license_no"></has-error>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">Issued By:</label> 
                                                        <input v-model="form.issued_by" 
                                                           type="text" 
                                                           name="issued_by" 
                                                           placeholder="Type Issued By"
                                                           :class="{ 'is-invalid': form.errors.has('issued_by') }"/>
                                                        <has-error :form="form" field="issued_by"></has-error> 
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">State:</label> 
                                                        <input v-model="form.license_state" 
                                                            type="text" 
                                                            name="license_state"
                                                            placeholder="Type State" 
                                                            :class="{ 'is-invalid': form.errors.has('license_state') }"/>
                                                             <has-error :form="form" field="license_state"></has-error> 
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
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
                                                        name="expirey_date"                                                             lang="en" 
                                                        placeholder="Enter Date" 
                                                        format="DD MMM, YYYY"
                                                        :class="{ 'is-invalid': form.errors.has('expirey_date') }">
                                                    </date-picker>
                                                  <has-error :form="form" field="expirey_date"></has-error>    
                                              
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Head Office Address</h4>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">Number:</label> 
                                                        <input v-model="form.headoffice_house_number" 
                                                            type="phone" 
                                                            name="headoffice_house_number" 
                                                            placeholder="Type House/Office Number" 
                                                            :class="{ 'is-invalid': form.errors.has('headoffice_house_number') }"/>
                                                             <has-error :form="form" field="headoffice_house_number"></has-error> 
                                                    </div>
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Street Number:</label> 
                                                        <input v-model="form.headoffice_street_number" 
                                                            type="text" 
                                                            name="headoffice_street_number" 
                                                            placeholder="Type Street Number" 
                                                            :class="{ 'is-invalid': form.errors.has('headoffice_street_number') }"/>
                                                             <has-error :form="form" field="headoffice_street_number"></has-error> 
                                                    </div>
                                                    
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">City:</label> 
                                                        <input v-model="form.headoffice_city" 
                                                            type="text" 
                                                            name="headoffice_city" 
                                                            placeholder="Type City" 
                                                            :class="{ 'is-invalid': form.errors.has('headoffice_city') }"/>
                                                             <has-error :form="form" field="headoffice_city"></has-error> 
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">State:</label> 
                                                        <input v-model="form.headoffice_state" 
                                                            type="text" 
                                                            name="headoffice_state" 
                                                            placeholder="Type State" 
                                                            :class="{ 'is-invalid': form.errors.has('headoffice_state') }"/>
                                                             <has-error :form="form" field="headoffice_state"></has-error>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
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

                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">Zip Code/ Postal Code:</label> 
                                                        <input v-model="form.headoffice_zip_code" 
                                                            type="phone" 
                                                            name="headoffice_zip_code" 
                                                            placeholder="Type Zip Code/ Postal Code" 
                                                            :class="{ 'is-invalid': form.errors.has('headoffice_zip_code') }"/>
                                                             <has-error :form="form" field="headoffice_zip_code"></has-error> 
                                                    </div>
                                                </div>
                                                  
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="form-card">
                            
                            <div class="form-folder">
                                <div class="form-holder">
                                    <div class="row align-self-stretch">
                                         <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-box-outer">
                                                 <h4>Contact</h4>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">Email:</label> 
                                                        <input v-model="form.contact_person_email" 
                                                            type="email" 
                                                            name="contact_person_email" 
                                                            :class="{ 'is-invalid': form.errors.has('contact_person_email') }"/>
                                                             <has-error :form="form" field="contact_person_email"></has-error>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">Fax:</label> 
                                                        <input v-model="form.contact_person_fax_no" 
                                                            type="text" 
                                                            name="contact_person_fax_no" 
                                                            :class="{ 'is-invalid': form.errors.has('contact_person_fax_no') }"/>
                                                             <has-error :form="form" field="contact_person_fax_no"></has-error> 
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">Phone:</label> 
                                                       <input v-model="form.contact_person_cell_phone" 
                                                            type="text" 
                                                            name="contact_person_cell_phone" 
                                                            :class="{ 'is-invalid': form.errors.has('contact_person_cell_phone') }"/>
                                                             <has-error :form="form" field="contact_person_cell_phone"></has-error>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
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
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Fiscal Year</h4>

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">From:</label> 
                                                        <date-picker 
                                                            style="width:100%"
                                                            v-model="form.fiscal_year_start_date"
                                                            name="fiscal_year_start_date"
                                                            lang="en"
                                                            type="fiscal_year_start_date"
                                                            format="DD MMM, YYYY"
                                                            :class="{ 'is-invalid': form.errors.has('fiscal_year_start_date') }">
                                                        </date-picker>
                                                        <has-error :form="form" field="fiscal_year_start_date"></has-error> 
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">To:</label> 
                                                        <date-picker 
                                                            style="width:100%"
                                                            v-model="form.fiscal_year_end_date"
                                                            name="fiscal_year_end_date"
                                                            lang="en"
                                                            type="date"
                                                            format="DD MMM, YYYY"
                                                            :class="{ 'is-invalid': form.errors.has('fiscal_year_end_date') }">
                                                        </date-picker>
                                                        <has-error :form="form" field="fiscal_year_end_date"></has-error> 
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">Property Calender:</label> 
                                                        <div class="form-check-inline">
                                                            <input 
                                                                type="checkbox" 
                                                                @change="check_fiscal_year_in_calender($event,1)" 
                                                                name="fiscal_year_in_calender_yes" 
                                                                id="fiscal_year_in_calender_yes"
                                                                v-model="form.fiscal_year_in_calender_yes" >
                                                            <label for="fiscal_year_in_calender_yes">Yes</label>

                                                            <input type="checkbox"
                                                                @change="check_fiscal_year_in_calender($event,2)"  
                                                                name="fiscal_year_in_calender_no" 
                                                                id="fiscal_year_in_calender_no"
                                                                v-model="form.fiscal_year_in_calender_no">
                                                            <label for="fiscal_year_in_calender_no">No</label><br>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                    
                                                <label class="fieldlabels">Recurring Cycle:</label> 
                                                <div class="position-relative form-group">
                                                    <select v-model="form.recuring_cycle"
                                                        name="recuring_cycle"
                                                        class="custom-select" 
                                                        :class="{ 'is-invalid': form.errors.has('recuring_cycle') }">
                                                        <option disabled value="">--Select-- </option>
                                                        <option value="1">1 Year</option>
                                                        <option v-for="year in 25" :value="year" v-if="year>1">{{year}} Years</option>
                                                    </select>
                                                </div>
                                                                                               
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Comments</h4>
                                                 
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">Comments:</label> 
                                                        <textarea 
                                                            v-model="form.comments"
                                                                style="height:120px;"
                                                                id="comments" 
                                                                name="comments" 
                                                                rows="6" 
                                                                cols="80"
                                                                placeholder="Type Comments" 
                                                                :class="{ 'is-invalid': form.errors.has('comments') }">
                                                        </textarea>
                                                        <has-error :form="form" field="comments"></has-error> 
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Date:</label> 
                                                        <date-picker 
                                                            style="width:100%"
                                                            v-model="form.comment_date"
                                                            name="comment_date"
                                                            lang="en"
                                                            type="date"
                                                            format="DD MMM, YYYY"
                                                            :class="{ 'is-invalid': form.errors.has('comment_date') }">
                                                        </date-picker>
                                                        <has-error :form="form" field="comment_date"></has-error>  
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Time:</label> 
                                                       <vue-timepicker
                                                            format="HH:mm"
                                                            v-model="form.comment_time"
                                                            name="comment_time"
                                                            ></vue-timepicker>
                                                    </div>
                                                    
                                                </div>                                               
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="fieldlabels">Property Calender:</label> 
                                                        
                                                        <div class="form-check-inline">
                                                            <input type="checkbox" 
                                                                @change="check_comment_in_calender($event,1)" 
                                                                name="comment_in_calender_yes" 
                                                                id="comment_in_calender_yes"
                                                                v-model="form.comment_in_calender_yes" >
                                                            <label for="comment_in_calender_yes">Yes</label>

                                                            <input type="checkbox"
                                                                @change="check_comment_in_calender($event,2)" 
                                                                name="comment_in_calender_no" 
                                                                id="comment_in_calender_no"
                                                                v-model="form.comment_in_calender_no">
                                                            <label for="comment_in_calender_no">No</label><br>
                                                        </div>
                                                        
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

                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-box-outer">
                                            <h4>Business Type</h4>
                                            <div class="form-holder">
                                                <div class="form-check-inline"> 
                                                    <input 
                                                        type="checkbox" 
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
                                    <div class="col-md-4 col-sm-4 col-xs-12">
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
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-box-outer">
                                            <h4>Customer Type</h4>
                                                <div class="form-holder">
                                                    <div class="form-check-inline">
                                                        <input type="checkbox" 
                                                            name="customer_property_management" 
                                                            id="customer_property_management"
                                                            v-model="form.customer_property_management" >
                                                        <label for="customer_property_management">Property Management</label><br>

                                                        <input type="checkbox" 
                                                            name="customer_seller" 
                                                            id="customer_seller"
                                                            v-model="form.customer_seller">
                                                        <label for="customer_seller">Seller</label><br>

                                                        <input type="checkbox"  
                                                            name="customer_service_provider" 
                                                            id="customer_service_provider"
                                                            v-model="form.customer_service_provider" >
                                                        <label for="customer_service_provider">Service Providers</label><br>
                                                        
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
                                <h3><i class="fa fa-hand-point-right"></i>Key Positions</h3>
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
                                                            <th scope="col">Accounts Name</th>
                                                            <th scope="col">Account Number</th>
                                                            <th scope="col">Filling Due Date</th>
                                                            <th scope="col">Filling Cycle</th>
                                                            <th scope="col">Add to Calender</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="border:none">
                                                        
                                                       
                                                        <tr v-for="(government_account,index) in form.government_account_lavel_data">
                                                            <th width="20%" scope="row"  v-if="government_account.reference_id"><h6>{{government_account.reference_value}}</h6></th>
                                                            <td width="20%" v-else>
                                                                <input 
                                                                    type="text"
                                                                    v-bind:id="'reference_value_'+index"
                                                                    placeholder="Type Account Name"
                                                                    name="reference_value[]" 
                                                                    v-model="government_account.reference_value"/>
                                                            </td>
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
                                                                    :class="{ 'is-invalid': form.errors.has('filling_date') }">
                                                                </date-picker>
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
                                                                        <option value="1">Monthly</option>
                                                                        <option value="2">Quarterly</option>
                                                                        <option value="3">Half Yearly</option>
                                                                        <option value="4"> Yearly</option>
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
                        <div class="text-center">
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Edit</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Delete</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode">Void</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(1)">Save-Stay</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(2)">Save-Out</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(3)">Save-New</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Preview</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
                        </div>
                    </fieldset> 
					
                   

                </form>
            </div>
        </div>

     
    </div>

   


</section>


</template>

<script>
	import Vue from 'vue';
	import VueTimepicker from 'vue2-timepicker';
    import 'vue2-timepicker/dist/VueTimepicker.css'
	


    export default {
        name:'list-product-categories',
        components:{
            VueTimepicker 
        },
        data(){
            return{
            	editmode:false,
				filter: '',
            	form:new Form({
            		
                    account_no:'',
                    scope_of_operation:'',
                    id:'',
                    legal_name:'',
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

                    contact_person_email:'',
                    contact_person_fax_no:'',
                    contact_person_cell_phone:'',
                    contact_person_website:'',

            		strata_management:false,
            		parking_management_industry:false,
            		storage_management_company:false,
            		leasehold_management:false,
            		property_management:false,

                    calender_property_manager:false,
                    calender_general_manager:false,
                    calender_building_manager:false,
                    calender_accounts_payable:false,
                    calender_accounting_manager:false,
                    calender_director:false,
                    calender_network_administrator:false,

                    customer_property_management:false,
                    customer_seller:false,
                    customer_service_provider:false,

                    key_position_lavel_data:[],
                    government_account_lavel_data:[],

                    fiscal_year_start_date:'',
                    fiscal_year_end_date:'',

                    fiscal_year_in_calender_yes:false,
                    fiscal_year_in_calender_no:false,
                    fiscal_year_in_calender:false,
                    recuring_cycle:'',

                    comment_in_calender_yes:false,
                    comment_in_calender_no:false,
                    comment_in_calender:false,
                    comments:'',
                    comment_date:'',
                    comment_time:'',              	
                  	
            	}),
                main_company_arr:[],
            	
            	countries:'',
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
           // this.fetchCompanyProfile();
           this.fetchCompanyProfileUpdate(14);

           
        },
		
	    methods: {

            reset_form()
            {

                this.form.reset ();
                this.editmode=false;
                for(let i=0; i<this.government_account_lavel.length; i++){

                        this.form.government_account_lavel_data.push({
                            'id':'',
                            'reference_id':this.government_account_lavel[i].id,
                            'reference_value':this.government_account_lavel[i].field_name,
                            'account_number':'',
                            'filling_date':'',
                            'filling_cycle':'',
                            'is_callender':0,
                        
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
                            'is_callender':0,
                        
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
            
				
		        this.form.put('/AccountSetups/'+this.form.id)
				    .then(()=>{
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
            },


            save_stay(type){

              

                this.form.post('/CompanyProfiles') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save successfully'
                        });

                        if(type==1)
                        {
                             this.fetchCompanyProfileUpdate(response_data[1]);
                           // this.form.id=response_data[1];
                            this.editmode=true;
                            //this.form.account_no=response_data[2];
                            //alert(response_data[2])
                        }
                        else if(type==2)
                        {
                             this.form.reset();
                        }
                        else if(type==3)
                        {
                            let route = this.$router.resolve({ path: "/Customer-Property" });
                            window.open(route.href,'_self');
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
            fetchCompanyProfileUpdate(id)
            {
                let uri = '/CompanyProfiles/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.main_company_arr                       =response.data.main_company_arr;
                    this.countries                              =response.data.country_arr;
                    this.account_status_arr                     =response.data.account_status_arr;
                    this.payment_term_arr                       =response.data.payment_term_arr;
                    this.currency_arr                           =response.data.currency_arr;
                    this.key_position_lavel                     =response.data.key_position_lavel_arr;
                    this.government_account_lavel               =response.data.government_account_lavel_arr;

                    this.form.id                                =response.data.company_data[0].id;
                    this.form.account_no                        =response.data.company_data[0].account_no;
                    this.form.scope_of_operation                =response.data.company_data[0].scope_of_operation;
                    this.form.legal_name                        =response.data.company_data[0].legal_name;
                    this.form.business_registration_number      =response.data.company_data[0].business_registration_number;
                    this.form.registration_date                 =response.data.company_data[0].registration_date;
                    this.form.business_registration_city        =response.data.company_data[0].business_registration_city;
                    this.form.business_registration_state       =response.data.company_data[0].business_registration_state;
                    this.form.registration_country              =response.data.company_data[0].registration_country;
                    this.form.business_license_no               =response.data.company_data[0].business_license_no;
                    this.form.issued_by                         =response.data.company_data[0].issued_by;
                    this.form.license_state                     =response.data.company_data[0].license_state;
                    this.form.license_country                   =response.data.company_data[0].license_country;
                    this.form.expirey_date                      =response.data.company_data[0].expirey_date;
                    this.form.headoffice_house_number           =response.data.company_data[0].headoffice_house_number;
                    this.form.headoffice_street_number          =response.data.company_data[0].headoffice_street_number;
                    this.form.headoffice_city                   =response.data.company_data[0].headoffice_city;
                    this.form.headoffice_state                  =response.data.company_data[0].headoffice_state;
                    this.form.headoffice_country                =response.data.company_data[0].headoffice_country;
                    this.form.headoffice_zip_code               =response.data.company_data[0].headoffice_zip_code;
                    this.form.contact_person_email              =response.data.company_data[0].contact_person_email;
                    this.form.contact_person_fax_no             =response.data.company_data[0].contact_person_fax_no;
                    this.form.contact_person_cell_phone         =response.data.company_data[0].contact_person_cell_phone;
                    this.form.contact_person_website            =response.data.company_data[0].contact_person_website;
                    this.form.strata_management                 =response.data.company_data[0].strata_management;
                    this.form.parking_management_industry       =response.data.company_data[0].parking_management_industry;
                    this.form.storage_management_company        =response.data.company_data[0].storage_management_company;
                    this.form.leasehold_management              =response.data.company_data[0].leasehold_management;
                    this.form.property_management               =response.data.company_data[0].property_management;
                    this.form.calender_property_manager         =response.data.company_data[0].calender_property_manager;
                    this.form.calender_general_manager          =response.data.company_data[0].calender_general_manager;
                    this.form.calender_building_manager         =response.data.company_data[0].calender_building_manager;



                    this.form.calender_accounts_payable         =response.data.company_data[0].calender_accounts_payable;
                    this.form.calender_accounting_manager       =response.data.company_data[0].calender_accounting_manager;
                    this.form.calender_director                 =response.data.company_data[0].calender_director;
                    this.form.calender_network_administrator    =response.data.company_data[0].calender_network_administrator;
                    this.form.customer_property_management      =response.data.company_data[0].customer_property_management;
                    this.form.customer_seller                   =response.data.company_data[0].customer_seller;
                    this.form.customer_service_provider         =response.data.company_data[0].customer_service_provider;
                   // this.form.key_position_lavel_data         =response.data.company_data[0].key_position_lavel_data;
                    this.form.fiscal_year_start_date            =response.data.company_data[0].fiscal_year_start_date;
                    this.form.fiscal_year_end_date              =response.data.company_data[0].fiscal_year_end_date;


                    this.form.fiscal_year_in_calender           =response.data.company_data[0].fiscal_year_in_calender;
                    this.form.recuring_cycle                    =response.data.company_data[0].recuring_cycle;


                    this.form.comment_in_calender               =response.data.company_data[0].comment_in_calender;
                    this.form.comments                          =response.data.company_data[0].comments;
                    this.form.comment_date                      =response.data.company_data[0].comment_date;
                    

                    for(let i=0; i<this.government_account_lavel.length; i++){

                        this.form.government_account_lavel_data.push({
                            'id':'',
                            'reference_id':this.government_account_lavel[i].id,
                            'reference_value':this.government_account_lavel[i].field_name,
                            'account_number':'',
                            'filling_date':'',
                            'filling_cycle':'',
                            'is_callender':0,
                        
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


	    }
    
    }  
	
</script>



