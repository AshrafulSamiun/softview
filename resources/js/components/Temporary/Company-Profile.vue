<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                            <h1 class="page-head">General Information</h1>
                            <div class="form-folder">
                                <h3><i class="fa fa-hand-point-right"></i> Account:</h3>
                                <div class="form-holder">
                                    <div class="row align-self-stretch">
                                        <div class="col-md-4 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer d-flex align-items-center">
                                                <div class="ac-box">
                                                    <h4 class="text-center">Your Account Number</h4>
                                                    <h2 class="text-center">{{account_no}}</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Management Type:</h4>
                                                <div class="form-holder">
                                                    <div class="form-check-inline">
								                        <input type="checkbox" value="0" 
																			name="strata_management" 
																			id="strata_management"
																			v-model="form.strata_management" @change="check_management_type($event,1)">
								                        <label for="strata_management">Strata Management</label><br>
								                        <input type="checkbox" value="0" 
																			name="coop_property" 
																			id="coop_property"
																			v-model="form.coop_property" @change="check_management_type($event,2)">
								                        <label for="management_type2">Co-op Property</label><br>
								                        <input type="checkbox" value="0" 
																			name="free_hold_management" 
																			id="free_hold_management"
																			v-model="form.free_hold_management" @change="check_management_type($event,3)">
								                        <label for="management_type3">Property</label><br>
								                        <input type="checkbox" value="0" 
																			name="leasehold_management" 
																			id="leasehold_management"
																			v-model="form.leasehold_management" @change="check_management_type($event,4)">
								                        <label for="management_type4">Leasehold</label><br>
								                        <input type="checkbox" value="0" 
																			name="property_management" 
																			id="property_management"
																			v-model="form.property_management" @change="check_management_type($event,5)">
								                        <label for="property_management">Property Management Service Provider</label>
								                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Type of Operation:</h4>
                                                <div class="form-holder">
                                                    <div class="form-check-inline">
                                                       
								                        <input type="checkbox" 
								                        	id="rantal_suite_unit" 
								                        	name="rantal_suite_unit" 
								                        	v-model="form.rantal_suite_unit"
								                        	@change="check_operation_type($event,1)">
								                        <label for="rantal_suite_unit">Rental Suites and Units</label><br>
								                        <input type="checkbox" 
								                        	id="buy_and_sell_suite_unit" 
								                        	name="buy_and_sell_suite_unit" 
								                        	v-model="form.buy_and_sell_suite_unit" 
								                        	@change="check_operation_type($event,2)">
								                        <label for="buy_and_sell_suite_unit">Buy and Sale Suits and Units</label><br>
								                        <input type="checkbox" 
								                        	id="rental_parking" 
								                        	name="rental_parking" 
								                        	v-model="form.rental_parking"
								                        	@change="check_operation_type($event,3)">
								                        <label for="rental_parking">Rental Parkrental_parkinging</label><br>
								                        <input type="checkbox" 
								                        	id="rental_storage" 
								                        	name="rental_storage" 
								                        	v-model="form.rental_storage" 
								                        	@change="check_operation_type($event,4)">
								                        <label for="rental_storage">Rental Storage</label><br>
								                        <input type="checkbox" 
								                        	id="landholders_residency" 
								                        	name="landholders_residency" 
								                        	v-model="form.landholders_residency"
								                        	@change="check_operation_type($event,5)">
								                        <label for="landholders_residency">Landlord / Landholders Residency</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="form-folder">
                                <h3><i class="fa fa-hand-point-right"></i> Company Profile:</h3>
                                <div class="form-holder">
                                    <div class="row align-self-stretch">
                                        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> 
                                            <div class="image-holder">
                                                <div class="circle">
                                                   <img class="profile-pic" src="https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg">
                                                </div>
                                                <div class="p-image">
                                                   <i class="fa fa-camera upload-button"></i>
                                                   <input class="file-upload" type="file" accept="image/*"/>
                                                </div>
                                                <h2>Company Logo</h2>
                                            </div>
                                        </div> -->
                                        <div class="col-md-3 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer">
                                                <h4>Company Legal Name</h4>
                                                <input v-model="form.legal_name" 
													type="text" 
													placeholder="Type Company Name"
													name="legal_name" 
													:class="{ 'is-invalid': form.errors.has('legal_name') }"/>
												      <has-error :form="form" field="legal_name"></has-error>
													  <input v-model="form.id" type="hidden" name="id">
                                                <h4>Company logo</h4>
                                                <input type="file" name="pic" accept="image/*">
                                                <h4>Head Office Address</h4>

                                                <div class="row">
                                                    <div class="col-md-7 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Street Number</label> 
                                                        <input v-model="form.headoffice_street_number" 
															type="text" 
															name="headoffice_street_number" 
															placeholder="Type Street Number" 
															:class="{ 'is-invalid': form.errors.has('headoffice_street_number') }"/>
														     <has-error :form="form" field="headoffice_street_number"></has-error> 
                                                    </div>
                                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">City:</label> 
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
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer">
                                                
                                                <h4>Contact</h4>

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Email</label> 
                                                        <input v-model="form.contact_person_email" 
															type="email" 
															name="contact_person_email" 
															:class="{ 'is-invalid': form.errors.has('contact_person_email') }"/>
														     <has-error :form="form" field="contact_person_email"></has-error>
                                                    </div>
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Fax:</label> 
                                                        <input v-model="form.contact_person_fax_no" 
															type="text" 
															name="contact_person_fax_no" 
															:class="{ 'is-invalid': form.errors.has('contact_person_fax_no') }"/>
														     <has-error :form="form" field="contact_person_fax_no"></has-error> 
                                                    </div>
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Phone:</label> 
                                                        <input v-model="form.contact_person_cell_phone" 
															type="text" 
															name="contact_person_cell_phone" 
															:class="{ 'is-invalid': form.errors.has('contact_person_cell_phone') }"/>
														     <has-error :form="form" field="contact_person_cell_phone"></has-error>
                                                    </div>
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">Website:</label> 
                                                        <input v-model="form.contact_person_website" 
															type="url" 
															name="contact_person_website" 
															:class="{ 'is-invalid': form.errors.has('contact_person_website') }"/>
														     <has-error :form="form" field="contact_person_website"></has-error>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Business Registration</h4>
                                                <label class="fieldlabels">Number:</label> 

                                                <input v-model="form.business_registration_number" 
													type="text" 
													name="business_registration_number" 
													placeholder="Type Number" 
													:class="{ 'is-invalid': form.errors.has('business_registration_number') }"/>
												     <has-error :form="form" field="business_registration_number"></has-error>
												     
                                                <label class="fieldlabels">Date:</label> 
                                               	
                                               	<date-picker 
							                     	v-model="form.registration_date"
							                     	name="registration_date"
							                     	lang="en"
							                     	type="registration_date"
							                     	format="DD-MM-YYYY"
							                     	:class="{ 'is-invalid': form.errors.has('registration_date') }"></date-picker>
											      <has-error :form="form" field="registration_date"></has-error>
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
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label class="fieldlabels">State:</label> 
                                                        <input v-model="form.business_registration_state" 
															type="text" 
															name="business_registration_state" 
															placeholder="Type State" 
															:class="{ 'is-invalid': form.errors.has('business_registration_state') }"/>
														     <has-error :form="form" field="business_registration_state"></has-error>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
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
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Miunicipal Business License</h4>
                                                <label class="fieldlabels">Number:</label> 
                                                <input v-model="form.business_license_no" 
													type="text" 
													name="business_license_no" 
													placeholder="Type Number" 
													:class="{ 'is-invalid': form.errors.has('business_license_no') }"/>
												     <has-error :form="form" field="business_license_no"></has-error>
                                                <label class="fieldlabels">Issued By:</label> 
                                                
                                                <input v-model="form.issued_by" 
													type="text" 
													name="issued_by" 
													placeholder="Type Issued By"
													:class="{ 'is-invalid': form.errors.has('issued_by') }"/>
												     <has-error :form="form" field="issued_by"></has-error> 
                                                <div class="row">
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
							                     	name="expirey_date"
							                     	lang="en"
							                     	placeholder="Enter Date"
							                     	format="DD-MM-YYYY"
							                     	:class="{ 'is-invalid': form.errors.has('expirey_date') }"></date-picker>
											      <has-error :form="form" field="expirey_date"></has-error> 
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="form-folder">
                                <h3><i class="fa fa-hand-point-right"></i> Property Type(S):</h3>
                                <div class="form-holder">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4 class="text-center">Dependent Property</h4>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                    	<div class="form-check-inline">
                                                    	<h6 class="text-center">Residential Buildings</h6>
                                                    		<input type="checkbox" 
									                        	id="dependent_residential_suite" 
									                        	name="dependent_residential_suite" 
									                        	v-model="form.dependent_residential_suite">

	                                                        <label >Residential Suite</label> <br>
	                                                        <input type="checkbox" value="0" 
																name="dependent_residental_parking_lot" 
																id="dependent_residental_parking_lot"
																v-model="form.dependent_residental_parking_lot" >
	                                                        <label >Parking Lot</label> <br>
	                                                        <input type="checkbox" value="0" 
																name="dependent_residental_storage_lot" 
																id="dependent_residental_storage_lot"
																v-model="form.dependent_residental_storage_lot" > 
	                                                        <label >Storage Lot:</label> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
	                                                    <div class="form-check-inline">
	                                                    	<h6 class="text-center"> Commercial Buildings</h6>
	                                                    	<input type="checkbox" value="0" 
																name="dependent_commercial_unit" 
																id="dependent_commercial_unit"
																v-model="form.dependent_commercial_unit" >
	                                                        <label >Commercial Units</label> <br>
	                                                        <input type="checkbox" value="0" 
																name="dependent_commercial_parking_lot" 
																id="dependent_commercial_parking_lot"
																v-model="form.dependent_commercial_parking_lot" >
	                                                         
	                                                        <label >Parking Lots</label> <br>


	                                                        <input type="checkbox" value="0" 
																name="dependent_commercial_storage_lot" 
																id="dependent_commercial_storage_lot"
																v-model="form.dependent_commercial_storage_lot" >
	                                                        <label >Storage Lots</label> 
	                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4 class="text-center">Independent Properties</h4>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                    	<div class="form-check-inline">
                                                    	<h6 class="text-center">Residential Buildings</h6>
                                                    		<input type="checkbox" 
									                        	id="independent_residential_suite" 
									                        	name="independent_residential_suite" 
									                        	v-model="form.independent_residential_suite">

	                                                        <label >Residential Suite</label> <br>
	                                                        <input type="checkbox" value="0" 
																name="independent_residental_parking_lot" 
																id="independent_residental_parking_lot"
																v-model="form.independent_residental_parking_lot" >
	                                                        <label >Parking Lot</label> <br>
	                                                        <input type="checkbox" value="0" 
																name="independent_residental_storage_lot" 
																id="independent_residental_storage_lot"
																v-model="form.independent_residental_storage_lot" > 
	                                                        <label >Storage Lot:</label> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
	                                                    <div class="form-check-inline">
	                                                    	<h6 class="text-center"> Commercial Buildings</h6>
	                                                    	<input type="checkbox" value="0" 
																name="independent_commercial_unit" 
																id="independent_commercial_unit"
																v-model="form.independent_commercial_unit" >
	                                                        <label >Commercial Units</label> <br>
	                                                        <input type="checkbox" value="0" 
																name="independent_commercial_parking_lot" 
																id="independent_commercial_parking_lot"
																v-model="form.independent_commercial_parking_lot" >
	                                                         
	                                                        <label >Parking Lots</label> <br>


	                                                        <input type="checkbox" value="0" 
																name="independent_commercial_storage_lot" 
																id="independent_commercial_storage_lot"
																v-model="form.independent_commercial_storage_lot" >
	                                                        <label >Storage Lots</label> 
	                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="form-folder">
                                <h3><i class="fa fa-hand-point-right"></i> Tax Office Accounts:</h3>
                                <div class="form-holder">
                                    <div class="form-box-outer">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <label class="fieldlabels">Business Number:</label> 
                                                <input v-model="form.business_number" 
													type="text" 
													name="business_number" 
													placeholder="Type usiness Number" 
													:class="{ 'is-invalid': form.errors.has('business_number') }"/>
												     <has-error :form="form" field="business_number"></has-error>
                                                <label class="fieldlabels">Employer Identification Number (EIN):</label> 
                                                <input v-model="form.emp_identification_number" 
													type="text" 
													name="emp_identification_number" 
													placeholder="Enter Identification Number (EIN)" 
													:class="{ 'is-invalid': form.errors.has('emp_identification_number') }"/>
												     <has-error :form="form" field="emp_identification_number"></has-error>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <label class="fieldlabels">Payroll:</label>
                                                <input v-model="form.payroll" 
													type="text" 
													name="payroll" 
													placeholder="Enter Sales Tax" 
													:class="{ 'is-invalid': form.errors.has('payroll') }"/>
												     <has-error :form="form" field="payroll"></has-error> 
                                                <label class="fieldlabels">Sales Tax:</label> 
                                                <input v-model="form.sales_tax" 
													type="text" 
													name="sales_tax" 
													placeholder="Enter Sales Tax" 
													:class="{ 'is-invalid': form.errors.has('sales_tax') }"/>
												     <has-error :form="form" field="sales_tax"></has-error>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <label class="fieldlabels">Income Tax:</label> 
                                                <input v-model="form.income_tax" 
													type="text" 
													name="income_tax" 
													placeholder="Type Income Tax" 
													:class="{ 'is-invalid': form.errors.has('income_tax') }"/>
												     <has-error :form="form" field="income_tax"></has-error> 
                                                <label class="fieldlabels">Import and Export :</label>
                                                <input v-model="form.import_and_export" 
													type="text" 
													name="import_and_export" 
													placeholder="Enter Import and Export " 
													:class="{ 'is-invalid': form.errors.has('import_and_export') }"/>
												     <has-error :form="form" field="import_and_export"></has-error> 
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
	        <button :disabled="form.busy"  type="submit" class="next action-button">Next <i class="fa fa-angle-right"></i></button>
	    </form>
    </fieldset>

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
            		management_type:0,
            		strata_management:false,
            		coop_property:false,
            		free_hold_management:false,
            		leasehold_management:false,
            		property_management:false,
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
                  	headoffice_street_number:'',
                  	headoffice_city:'',
                  	headoffice_state:'',
                  	headoffice_country:'',
                  	/*head_office_email:'',
                  	head_office_fax_no:'',
                  	head_office_cell_phone:'',
                  	head_office_website:'',*/


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

                  	dependent_residential_suite:false,
                  	dependent_residental_parking_lot:false,
                  	dependent_residental_storage_lot:false,
                  	dependent_commercial_unit:false,
                  	dependent_commercial_parking_lot:false,

                  	dependent_commercial_storage_lot:false,
                  	independent_residential_suite:false,
                  	independent_residental_parking_lot:false,
                  	independent_residental_storage_lot:false,
                  	independent_commercial_unit:false,
                  	independent_commercial_parking_lot:false,
                  	independent_commercial_storage_lot:false,

                  	rantal_suite_unit:false,
                  	buy_and_sell_suite_unit:false,
                  	rental_parking:false,
                  	rental_storage:false,
                  	landholders_residency:false,


            	}),
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

	    	check_management_type(e,type){
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.coop_property=false;
		    			this.form.free_hold_management=false;
		    			this.form.leasehold_management=false;
		    			this.form.property_management=false;
		    			this.form.management_type=1;
		    		}
		    		else if(type==2)
		    		{
		    			this.form.strata_management=false;
		    			this.form.free_hold_management=false;
		    			this.form.leasehold_management=false;
		    			this.form.property_management=false;
		    			this.form.management_type=2;
		    		}
		    		else if(type==3)
		    		{
		    			this.form.strata_management=false;
		    			this.form.coop_property=false;
		    			this.form.leasehold_management=false;
		    			this.form.property_management=false;
		    			this.form.management_type=3;
		    		}
		    		else if(type==4)
		    		{
		    			this.form.strata_management=false;
		    			this.form.coop_property=false;
		    			this.form.free_hold_management=false;
		    			this.form.property_management=false;
		    			this.form.management_type=4;
		    		}
		    		else if(type==5)
		    		{
		    			this.form.strata_management=false;
		    			this.form.coop_property=false;
		    			this.form.free_hold_management=false;
		    			this.form.leasehold_management=false;
		    			this.form.management_type=5;
		    		}
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
            
	        fetchCompanyProfile()
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
                	
                	if(this.form.id){
                		this.editmode=true;
                	}

                	this.countries 								=response.data.country_arr;
                	
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
               
					let route = this.$router.resolve({ path: "/Temp-ContactsPersons" });
	      			window.open(route.href,'_self');
	      			return;
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchCompanyProfile();
        	    })
            }
	    }
    
    }  
	
</script>