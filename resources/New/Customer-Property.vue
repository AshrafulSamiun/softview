<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateCustomerProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Customer Information</h1>
                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> General Information:</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                            	<div class="form-box-outer">
                            		<div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                    		<label class="fieldlabels">ID No:</label> 
                                            <input v-model="form.system_no" 
												type="text" 
												name="system_no" 
												:class="{ 'is-invalid': form.errors.has('system_no') }" disabled/>
											<has-error :form="form" field="system_no"></has-error>
												 
										</div>
									</div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Account No:</label> 
                                            <input v-model="form.account_no" 
                                                type="text" 
                                                name="account_no" 
                                                :class="{ 'is-invalid': form.errors.has('account_no') }"/>
                                            <has-error :form="form" field="account_no"></has-error>
                                                 
                                        </div>
                                    </div>
									<div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                    		<label class="fieldlabels">Customer Type:</label>  
                                    		
                                            <select v-model="form.customer_type"
                                                name="customer_type"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('customer_type') }"
                                                disabled>
                                                <option disabled value="">--Select Customer Type-- </option>
                                                <option  value="1">Property Management</option>
                                            </select>
                                            <has-error :form="form" field="customer_type"></has-error>
										</div>
									</div>                                    


                                    
                                    <h4>Account Status:</h4>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Current Status:</label> 
                                            <select v-model="form.account_status"
                                                    name="account_status"
                                                    class="custom-select"
                                                    @change="change_account_status" 
                                                    :class="{ 'is-invalid': form.errors.has('account_status') }">
                                                    <option disabled value="">--Select-- </option>
                                                    <option v-for="(status,index) in account_status_arr" :value="index">{{status}}</option>
                                                </select> 
                                        </div>
                                    </div>
                                    <div class="row">

                                        <h4 v-show="account_disable">Inactive Description:</h4>
                                        <div class="col-md-12 col-sm-12 col-xs-12" v-show="account_disable">
                                            <label class="fieldlabels">Date:</label> 
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form.status_date"
                                                name="status_date"
                                                lang="en"
                                                type="status_date"
                                                format="dddd, MMMM D, YYYY"
                                                :class="{ 'is-invalid': form.errors.has('status_date') }"></date-picker>
                                              <has-error :form="form" field="status_date"></has-error> 
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" v-show="account_disable">
                                            <label class="fieldlabels">Reason:</label> 

                                            <textarea 
                                                v-model="form.acount_reason"
                                                    style="height:70px;"
                                                    id="acount_reason" 
                                                    name="acount_reason" 
                                                    rows="4" 
                                                    cols="50"
                                                    placeholder="Type Reason" 
                                                :class="{ 'is-invalid': form.errors.has('acount_reason') }">
                                            </textarea>
                                            <has-error :form="form" field="acount_reason"></has-error>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" v-show="account_disable">
                                            <label class="fieldlabels">Comment:</label> 
                                            <textarea 
                                                v-model="form.account_comments"
                                                style="height:100px;"
                                                id="account_comments" 
                                                name="account_comments" 
                                                rows="4" 
                                                cols="50"></textarea>
                                            <has-error :form="form" field="account_comments"></has-error>
                                        </div>
                                    </div>

                                </div>
                               
                            </div>
                           
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                                
                                    <h4>Company Name:</h4>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Legal Name:</label> 
                                            <input v-model="form.legal_name" 
												type="text" 
												name="legal_name" 
												placeholder="Type Company Legal Name" 
												:class="{ 'is-invalid': form.errors.has('legal_name') }"/>
											     <has-error :form="form" field="legal_name"></has-error> 
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Operational Name:</label> 
                                            <input v-model="form.operational_name" 
												type="text" 
												name="operational_name" 
												placeholder="Type Company Operational Name" 
												:class="{ 'is-invalid': form.errors.has('operational_name') }"/>
											     <has-error :form="form" field="operational_name"></has-error> 
                                        </div>
                                    </div>
                                    <h4>Operation Scope:</h4> 
                                    <div class="row">
                                    	   
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="position-relative form-group">
                                                <select v-model="form.scope_of_operation"
                                                	name="scope_of_operation"
                                                	class="custom-select" 
                                                	:class="{ 'is-invalid': form.errors.has('scope_of_operation') }">
										        	<option disabled value="">--Select-- </option>
										        	<option  value="1">Domestic</option>
										        	<option  value="2">International</option>
										        	<option  value="3">Both</option>
												  	
										  		</select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    
                                    <h4>Head Office Address</h4>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels"> Number</label> 
                                            <input v-model="form.headoffice_house_number" 
                                                type="phone" 
                                                name="headoffice_house_number" 
                                                placeholder="Type House/Office Number" 
                                                :class="{ 'is-invalid': form.errors.has('headoffice_house_number') }"/>
                                                 <has-error :form="form" field="headoffice_house_number"></has-error> 
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Street Number</label> 
                                            <input v-model="form.headoffice_street_number" 
                                                type="text" 
                                                name="headoffice_street_number" 
                                                placeholder="Type Street Number" 
                                                :class="{ 'is-invalid': form.errors.has('headoffice_street_number') }"/>
                                                 <has-error :form="form" field="headoffice_street_number"></has-error> 
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
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
                                                <has-error :form="form" field="headoffice_country"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Zip/Postal Code:</label> 
                                            <input v-model="form.headoffice_zip_code" 
                                                type="text" 
                                                name="headoffice_zip_code" 
                                                placeholder="Type Zip/Postal Code" 
                                                :class="{ 'is-invalid': form.errors.has('headoffice_zip_code') }"/>
                                                 <has-error :form="form" field="headoffice_zip_code"></has-error>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>

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
                    <h3><i class="fa fa-hand-point-right"></i> Dedicated Property</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="form-box-outer">
                                    <table class="table">
                                        
                                        <thead>
                                            <tr>
                                                <th scope="col">Property</th>
                                                <th scope="col">Code</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Country</th>
                                                <th scope="col">State/Prov</th>
                                                
                                                <th scope="col">City</th>
                                            </tr>
                                        </thead>
                                        <tbody style="border:none">
                                            <tr v-for="(dadicated_property,index) in form.dadicated_property_data">
                                                <th scope="row"><h4>{{dadicated_property.reference_value}}</h4></th>
                                                <td>
                                                    <input 
                                                        type="number" 
                                                        placeholder="Type Property Code"
                                                        v-bind:id="'dedicated_property_code_'+index"
                                                        name="dedicated_property_code[]" 
                                                        v-model="dadicated_property.property_code"/>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <input type="text" 
                                                            v-bind:id="'property_name_'+index"
                                                            placeholder="Type Propery Name"
                                                            name="property_name[]" 
                                                            v-model="dadicated_property.property_name"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <select v-model="dadicated_property.country"
                                                            v-bind:id="'property_country_'+index"
                                                            name="property_country[]"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('put_customer_on_hold') }">
                                                            <option disabled value="">--Select-- </option>
                                                            <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                        </select>
                                                         
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check-inline">
                                                        <input type="text" 
                                                            v-bind:id="'state_'+index"
                                                            placeholder="Type State/Provience"
                                                            name="state[]" 
                                                            v-model="dadicated_property.state">
                                                    </div>
                                                </td>
                                                
                                                <td>
                                                    <input 
                                                        type="text" 
                                                        placeholder="Type City"
                                                        v-bind:id="'city_'+index"
                                                        name="city[]" 
                                                        v-model="dadicated_property.city"/>
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
                    
                </div>


                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> Financial:</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    <h4>Currency:</h4>
                                    <div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Domestic</label> 
                                        </div>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <select v-model="form.currency_domestic"
                                                name="currency_domestic"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('currency_domestic') }">
                                                <option disabled value="">--Select-- </option>
                                                <option v-for="(currency,index) in currency_arr" :value="index">{{currency}}</option>
                                            </select>
                                            <has-error :form="form" field="currency_domestic"></has-error>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Foreign 1</label> 
                                        </div>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                             <select v-model="form.foreign_corrency_1"
                                                name="foreign_corrency_1"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('foreign_corrency_1') }">
                                                <option disabled value="">--Select-- </option>
                                                <option v-for="(currency,index) in currency_arr" :value="index">{{currency}}</option>
                                            </select>
                                            <has-error :form="form" field="foreign_corrency_1"></has-error>
                                                 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Foreign 2</label> 
                                        </div>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                             <select v-model="form.foreign_corrency_2"
                                                name="foreign_corrency_2"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('foreign_corrency_2') }">
                                                <option disabled value="">--Select-- </option>
                                                <option v-for="(currency,index) in currency_arr" :value="index">{{currency}}</option>
                                            </select>
                                            <has-error :form="form" field="foreign_corrency_2"></has-error>
                                                 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Foreign 2</label> 
                                        </div>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                             <select v-model="form.foreign_corrency_3"
                                                name="foreign_corrency_3"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('foreign_corrency_3') }">
                                                <option disabled value="">--Select-- </option>
                                                <option v-for="(currency,index) in currency_arr" :value="index">{{currency}}</option>
                                            </select>
                                            <has-error :form="form" field="foreign_corrency_3"></has-error>
                                                 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Foreign 4</label> 
                                        </div>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                             <select v-model="form.foreign_corrency_4"
                                                name="foreign_corrency_4"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('foreign_corrency_4') }">
                                                <option disabled value="">--Select-- </option>
                                                <option v-for="(currency,index) in currency_arr" :value="index">{{currency}}</option>
                                            </select>
                                            <has-error :form="form" field="foreign_corrency_4"></has-error>
                                                 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Foreign 5</label> 
                                        </div>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                             <select v-model="form.foreign_corrency_5"
                                                name="foreign_corrency_5"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('foreign_corrency_5') }">
                                                <option disabled value="">--Select-- </option>
                                                <option v-for="(currency,index) in currency_arr" :value="index">{{currency}}</option>
                                            </select>
                                            <has-error :form="form" field="foreign_corrency_5"></has-error>
                                                 
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12"> 

                                <div class="form-box-outer">
                                    

                                    <div class="row">
                                        
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Invoice Term:</label> 
                                            

                                            <select v-model="form.invoice_term"
                                                name="invoice_term"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('invoice_term') }">
                                                <option disabled value="">--Select-- </option>
                                                <option v-for="(payment_term,index) in payment_term_arr" :value="index">{{payment_term}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Sales Tax:</label> 
                                            <select v-model="form.sales_tax"
                                                name="sales_tax"
                                                class="custom-select"
                                                :class="{ 'is-invalid': form.errors.has('sales_tax') }">
                                                <option disabled value="">--Select-- </option>
                                                <option  value="1">Tax-1</option>
                                                <option  value="2">Tax-2</option>
                                                <option  value="3">Tax-3</option>
                                                <option  value="4">Tax-4</option>
                                                <option  value="5">Tax-5</option>
                                                
                                            </select> 
                                        </div>
                                    </div>


                                    <h4>Credit Limit:</h4>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Daily:</label> 
                                             <input v-model="form.credit_limit_daily" 
                                                type="text" 
                                                name="credit_limit_daily" 
                                                :class="{ 'is-invalid': form.errors.has('credit_limit_daily') }"/>
                                                 <has-error :form="form" field="credit_limit_daily"></has-error>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Weekly:</label> 
                                             <input v-model="form.credit_limit_weekly" 
                                                type="text" 
                                                name="credit_limit_weekly" 
                                                :class="{ 'is-invalid': form.errors.has('credit_limit_weekly') }"/>
                                                 <has-error :form="form" field="credit_limit_weekly"></has-error>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Monthly:</label> 
                                             <input v-model="form.credit_limit_monthly" 
                                                type="text" 
                                                name="credit_limit_monthly" 
                                                :class="{ 'is-invalid': form.errors.has('credit_limit_monthly') }"/>
                                                 <has-error :form="form" field="credit_limit_monthly"></has-error>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Semi-Monthly:</label> 
                                             <input v-model="form.credit_limit_semi_monthly" 
                                                type="text" 
                                                name="credit_limit_semi_monthly" 
                                                :class="{ 'is-invalid': form.errors.has('credit_limit_semi_monthly') }"/>
                                                 <has-error :form="form" field="credit_limit_semi_monthly"></has-error>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Yearly:</label> 
                                             <input v-model="form.credit_limit_yearly" 
                                                type="text" 
                                                name="credit_limit_yearly" 
                                                :class="{ 'is-invalid': form.errors.has('credit_limit_yearly') }"/>
                                                 <has-error :form="form" field="credit_limit_yearly"></has-error>
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
                                                format="dddd, MMMM D, YYYY"
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
                                                format="dddd, MMMM D, YYYY"
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
                            <hr>
                        </div>
                    </div>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">

                                	<h4>Permitetd Tranasactions </h4>
                                    <div class="form-holder">
                                        <label class="fieldlabels">Sales on Credit:</label>
                                        <div class="form-check-inline">
					                        <input type="checkbox" value="0" 
												name="sales_on_credit_yes" 
												id="sales_on_credit_yes"
												v-model="form.sales_on_credit_yes" @change="sales_on_credit($event,1)">
					                        <label for="sales_on_credit_yes">Yes</label>
					                        <input type="checkbox" value="0" 
												name="sales_on_credit_no" 
												id="sales_on_credit_no"
												v-model="form.sales_on_credit_no" @change="sales_on_credit($event,2)">
					                        <label for="sales_on_credit_no">No</label><br>
					                        
					                    </div>
                                    </div>

                                    <label class="fieldlabels">Sales Return:</label>
                                    <div class="form-holder">
                                        <div class="form-check-inline">
					                        <input type="checkbox" value="0" 
																name="sales_return_yes" 
																id="sales_return_yes"
																v-model="form.sales_return_yes" @change="check_sales_return($event,1)">
					                        <label for="sales_return_yes">Yes</label>
					                        <input type="checkbox" value="0" 
																name="sales_return_no" 
																id="sales_return_no"
																v-model="form.sales_return_no" @change="check_sales_return($event,2)">
					                        <label for="sales_return_no">No</label><br>
					                        
					                    </div>
                                    </div>

                                    <h4>Invoice Pay Off Order:</h4>
                                    <div class="form-holder">
                                        <div class="form-check-inline">
					                        <input type="checkbox" value="0" 
																name="invoice_pay_off_order_oldest" 
																id="invoice_pay_off_order_oldest"
																v-model="form.invoice_pay_off_order_oldest" @change="check_invoice_pay_off_order($event,1)">
					                        <label for="invoice_pay_off_order_oldest">From oldest</label><br>

					                        <input type="checkbox" value="0" 
																name="invoice_pay_off_order_newest" 
																id="invoice_pay_off_order_newest"
																v-model="form.invoice_pay_off_order_newest" @change="check_invoice_pay_off_order($event,2)">
					                        <label for="invoice_pay_off_order_newest">From Newest</label><br>


					                        <input type="checkbox" value="0" 
																name="invoice_pay_off_order_optional" 
																id="invoice_pay_off_order_optional"
																v-model="form.invoice_pay_off_order_optional" >
					                        <label for="invoice_pay_off_order_optional">Optional</label><br>
					                        
					                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    <h4>Accepted Payment Method :</h4>
                                    <div class="form-holder">
                                        <div class="form-check-inline">
                                           
                                           	<input type="checkbox" 
					                        	id="accepted_payment_method_cash" 
					                        	name="accepted_payment_method_cash" 
					                        	v-model="form.accepted_payment_method_cash">
					                        <label for="accepted_payment_method_cash">Cash</label><br>

					                        <input type="checkbox" 
					                        	id="accepted_payment_method_check" 
					                        	name="accepted_payment_method_check" 
					                        	v-model="form.accepted_payment_method_check">
					                        <label for="accepted_payment_method_check">Check</label><br>


					                        <input type="checkbox" 
					                        	id="accepted_payment_method_credit_card" 
					                        	name="accepted_payment_method_credit_card" 
					                        	v-model="form.accepted_payment_method_credit_card">
					                        <label for="accepted_payment_method_credit_card">Credit Card</label><br>

					                        <input type="checkbox" 
					                        	id="accepted_payment_method_dd" 
					                        	name="accepted_payment_method_dd" 
					                        	v-model="form.accepted_payment_method_dd" >
					                        <label for="accepted_payment_method_dd">Direct Deposit</label><br>

					                        <input type="checkbox" 
					                        	id="accepted_payment_method_email" 
					                        	name="accepted_payment_method_email" 
					                        	v-model="form.accepted_payment_method_email">
					                        <label for="accepted_payment_method_email">Email Transfer</label><br>


					                        <input type="checkbox" 
					                        	id="accepted_payment_method_pap" 
					                        	name="accepted_payment_method_pap" 
					                        	v-model="form.accepted_payment_method_pap">
					                        <label for="accepted_payment_method_pap">Pre- Authorized Paymnet</label><br>

					                        
					                       
                                        </div>
                                    </div>


                                    <h4>Invoice Delivery Method:</h4>
                                    <div class="form-holder">
                                        <div class="form-check-inline">
                                           
					                        <input type="checkbox" 
					                        	id="invoice_delivery_method_hard_copy" 
					                        	name="invoice_delivery_method_hard_copy" 
					                        	v-model="form.invoice_delivery_method_hard_copy">
					                        <label for="invoice_delivery_method_hard_copy">Mail hard Copy</label><br>

					                        <input type="checkbox" 
					                        	id="invoice_delivery_method_email" 
					                        	name="invoice_delivery_method_email" 
					                        	v-model="form.invoice_delivery_method_email" >
					                        <label for="invoice_delivery_method_email">Email</label><br>
					                        <input type="checkbox" 
					                        	id="invoice_delivery_method_both" 
					                        	name="invoice_delivery_method_both" 
					                        	v-model="form.invoice_delivery_method_both">
					                        <label for="invoice_delivery_method_both">Both</label><br>
					                        
					                       
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    <h4>Dedicated Calendar:</h4>
                                    <div class="form-holder">
                                        <div class="form-check-inline">
                                           
                                            <input type="checkbox" 
                                                id="calendr_director" 
                                                name="calendr_director" 
                                                v-model="form.calendr_director">
                                            <label for="calendr_director">Director</label><br>

                                            <input type="checkbox" 
                                                id="calender_accounting_manager" 
                                                name="calender_accounting_manager" 
                                                v-model="form.calender_accounting_manager">
                                            <label for="calender_accounting_manager">Accounting Manager</label><br>


                                            <input type="checkbox" 
                                                id="calender_account_payable" 
                                                name="calender_account_payable" 
                                                v-model="form.calender_account_payable">
                                            <label for="calender_account_payable">Accounts Payable</label><br>

                                            <input type="checkbox" 
                                                id="calender_building_manager" 
                                                name="calender_building_manager" 
                                                v-model="form.calender_building_manager" >
                                            <label for="calender_building_manager">Building Manager</label><br>

                                            <input type="checkbox" 
                                                id="calender_general_manager" 
                                                name="calender_general_manager" 
                                                v-model="form.calender_general_manager">
                                            <label for="calender_general_manager">General Manager</label><br>


                                            <input type="checkbox" 
                                                id="calender_netwrok_administrator" 
                                                name="calender_netwrok_administrator" 
                                                v-model="form.calender_netwrok_administrator">
                                            <label for="calender_netwrok_administrator">Network Administrator</label><br>

                                            <input type="checkbox" 
                                                id="calender_property_manager" 
                                                name="calender_property_manager" 
                                                v-model="form.calender_property_manager">
                                            <label for="calender_property_manager">Property Manager</label><br>
                                           
                                        </div>
                                    </div>



                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>



                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i>Comments & Optional Field:</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            
                            
                            <div class="col-md-6 col-sm-12 col-xs-12"> 
                                <div class="form-box-outer">
                                    
                                    <h4>Custom Field</h4>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12" v-for="(single_field,index) in form.custom_field">
                                            <label class="fieldlabels">{{single_field.field_name}}:</label> 
                                            <div v-if="single_field.field_type==1">
                                                
												<date-picker 
							                     	v-model="single_field.field_model" 
													v-bind:name="single_field.field_id" 
													v-bind:id="single_field.field_id"
                                                    v-bind:placeholder="'Select '+single_field.field_name"
							                     	lang="en"
							                     	format="dddd, MMMM D, YYYY"
							                     	:class="{ 'is-invalid': form.errors.has('single_field.field_id') }">
							                    </date-picker>
											    <has-error :form="form" field="single_field.field_id"></has-error>
											</div>
                                            <div v-if="single_field.field_type==2">
                                                
                                                <vue-timepicker 
                                                    v-model="single_field.field_model" 
                                                    v-bind:name="single_field.field_id" 
                                                    v-bind:id="single_field.field_id"
                                                    v-bind:placeholder="'Select '+single_field.field_name"
                                                    lang="en"
                                                    format="HH:mm"
                                                    :class="{ 'is-invalid': form.errors.has('single_field.field_id') }">
                                                </vue-timepicker>
                                                <has-error :form="form" field="single_field.field_id"></has-error>
                                            </div> 
                                            <div v-else-if="single_field.field_type==3">
                                                <input 
                                                	v-model="single_field.field_model" 
													type="text" 
													v-bind:name="single_field.field_id" 
													v-bind:id="single_field.field_id"
                                                    :placeholder="'Type '+single_field.field_name"

													 
													:class="{ 'is-invalid': form.errors.has('single_field.field_id') }"/>
												     <has-error :form="form" field="single_field.field_id"></has-error>
											</div>

											<div v-else-if="single_field.field_type==4">
                                                <input 
                                                	v-model="single_field.field_model" 
													type="number" 
													v-bind:name="single_field.field_id" 
													v-bind:id="single_field.field_id"
													v-bind:placeholder="'Type '+single_field.field_name"
													:class="{ 'is-invalid': form.errors.has('single_field.field_id') }"/>
												     <has-error :form="form" field="single_field.field_id"></has-error>
											</div>

											<div v-else-if="single_field.field_type==5">
                                                <input 
                                                	v-model="single_field.field_model" 
													type="phone" 
													v-bind:name="single_field.field_id" 
													v-bind:id="single_field.field_id"
													v-bind:placeholder="'Type '+single_field.field_name"
													:class="{ 'is-invalid': form.errors.has('single_field.field_id') }"/>
												     <has-error :form="form" field="single_field.field_id"></has-error>
											</div>

											<div v-else-if="single_field.field_type==6">
                                                <input 
                                                	v-model="single_field.field_model" 
													type="number" 
                                                    min="0"
                                                    max="100"
                                                    @keyup="custom_number_field_validate(index)"
													v-bind:name="single_field.field_id" 
													v-bind:id="single_field.field_id"
													v-bind:placeholder="'Type '+single_field.field_name" 
													:class="{ 'is-invalid': form.errors.has('single_field.field_id') }"/>
												     <has-error :form="form" field="single_field.field_id"></has-error>
											</div>

											<div v-else-if="single_field.field_type==7">
                                                

                                                <select
                                                    v-model="single_field.field_model" 
                                                    v-bind:name="single_field.field_id" 
                                                    v-bind:id="single_field.field_id"
                                                    class="custom-select">
                                                    <option disabled value="">--Select-- </option>
                                                    <option v-for="(currency,index) in currency_arr" :value="index">{{currency}}</option>
                                                </select>
											</div>
											<div v-else-if="single_field.field_type==8">
                                                <input 
                                                    v-model="single_field.field_model" 
                                                    type="url"
                                                    v-bind:name="single_field.field_id" 
                                                    v-bind:id="single_field.field_id"
                                                    v-bind:placeholder="'Type '+single_field.field_name" 
                                                    :class="{ 'is-invalid': form.errors.has('single_field.field_id') }"/>
                                                     <has-error :form="form" field="single_field.field_id"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12" >
                                            <button type="button" class="btn btn-primary" @click.prevent="addCustomField()">Add New Custom Field</button>
                                        </div>
                                        

                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-box-outer">
                                    <h4>Comments:</h4>
                                    <div class="row">
                                        
                                        <div class="col-md-6 col-sm-12 col-xs-12" >
                                            <label class="fieldlabels">Date:</label> 
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form.comment_date"
                                                name="comment_date"
                                                lang="en"
                                                type="comment_date"
                                                format="dddd, MMMM D, YYYY"
                                                :class="{ 'is-invalid': form.errors.has('comment_date') }"></date-picker>
                                              <has-error :form="form" field="comment_date"></has-error> 
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12" >
                                            <label class="fieldlabels">Date:</label> <br/>
                                            <vue-timepicker 
                                                v-model="form.comment_time" 
                                                name="comment_time" 
                                                id="comment_time"
                                                placeholder="Select Time"
                                                lang="en"
                                                format="HH:mm"
                                                :class="{ 'is-invalid': form.errors.has('comment_time') }">
                                            </vue-timepicker>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" >
                                            <label class="fieldlabels">Comment:</label> 
                                            <textarea 
                                                v-model="form.comments"
                                                style="height:100px;"
                                                id="comments" 
                                                name="comments" 
                                                rows="4" 
                                                cols="50"></textarea>
                                            <has-error :form="form" field="comments"></has-error>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Add to Calendar:</label>
                                            <div class="form-check-inline">
                                                <input type="checkbox" 
                                                    name="comment_calendar_yes" 
                                                    id="comment_calendar_yes"
                                                    v-model="form.comment_calendar_yes" @change="comment_calendar($event,1)">
                                                <label for="comment_calendar_yes">Yes</label>
                                                <input type="checkbox"
                                                    name="comment_calendar_no" 
                                                    id="comment_calendar_no"
                                                    v-model="form.comment_calendar_no" @change="comment_calendar($event,2)">
                                                <label for="comment_calendar_no">No</label><br>
                                                
                                            </div>

                                        </div>
                                    </div>

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
                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deleteCustomer()">Delete</button>
                    <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode">Void</button>
                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(1)">Save-Stay</button>
                    <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(2)">Save-Out</button>
                    <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(3)">Save-New</button>
                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
                </div>
	        
	         <!--  Model  -->
		        <div class="modal fade model-middle" id="customModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Add Custom field</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				        <div class="form-holder">
                            <div class="row align-self-stretch">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                	<div class="form-box-outer">
                                		<div class="row">
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                        		<label class="fieldlabels">Field Name</label> 
                                        	</div>
                                        	<div class="col-md-7 col-sm-6 col-xs-12">
                                                <input v-model="form.custom_field_name" 
													type="text" 
													name="custom_field_name" 
													:class="{ 'is-invalid': form.errors.has('custom_field_name') }"/>
												      <has-error :form="form" field="custom_field_name"></has-error>
													 
											</div>
										</div>
										<div class="row">
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                        		<label class="fieldlabels">Field Type</label> 
                                        	</div>
                                        	<div class="col-md-7 col-sm-6 col-xs-12">
                                                <select v-model="form.custom_field_type"
                                                	name="custom_field_type"
                                                	class="custom-select" 
                                                	:class="{ 'is-invalid': form.errors.has('custom_field_type') }">
										        	<option value="">--Select-- </option>
										        	<option value="1">Date</option>
										        	<option value="2">Time</option>
										        	<option value="3">Text</option>
										        	<option value="4">Number</option>
										        	<option value="5">Phone Number</option>
										        	<option value="6">Percentage</option>
										        	<option value="7">Financial</option>
										        	<option value="8">Web Line</option>
												  	
										  		</select>
												<has-error :form="form" field="custom_field_type"></has-error>
													 
											</div>
										</div>                                       

                                    </div> 
                                   
                                </div>
                               
                                <hr>
                            </div>
                        </div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="modelClose()">Close</button>
                        <button type="button" class="btn btn-primary" @click.prevent="addNewCustomField()">Add New Custom Field</button>
				      </div>
				    </div>
				  </div>
				</div>

			<!-- Model end -->
	    </form>
	   

    </fieldset>

</template>

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
            	show_company:true,
				filter: '',
            	form:new Form({
                    system_no:'',
            		account_status:1,
                    customer_type:1,
                    account_no:'',
            		status_date:'',
            		acount_reason:'',
                    account_comments:'',
            		legal_name:'',
            		operational_name:'',
            		scope_of_operation:'',
            		company_id:'',
            		

            		headoffice_house_number:'',
            		headoffice_street_number:'',
            		headoffice_city:'',
            		headoffice_state:'',
            		headoffice_country:'',
            		headoffice_zip_code:'',

                    currency_domestic:'',
                    foreign_corrency_1:'',
                    foreign_corrency_2:'',
                    foreign_corrency_3:'',
                    foreign_corrency_4:'',
                    foreign_corrency_5:'',

            		
            		invoice_term:'',
                    sales_tax:'',

            		credit_limit_daily:'',
            		credit_limit_weekly:'',
            		credit_limit_monthly:'',
            		credit_limit_semi_monthly:'',
            		credit_limit_yearly:'',

                    fiscal_year_start_date:'',
                    fiscal_year_end_date:'',
                    fiscal_year_in_calender:false,
                    fiscal_year_in_calender_yes:false,
                    fiscal_year_in_calender_no:false,
                    recuring_cycle:'',

            		sales_on_credit_yes:false,
            		sales_on_credit_no:false,
            		sales_on_credit:false,


            		sales_return_yes:false,
            		sales_return_no:false,
            		sales_return:false,

            		invoice_pay_off_order_oldest:false,
            		invoice_pay_off_order_newest:false,
            		invoice_pay_off_order_optional:false,
                    accepted_payment_method_cash:false,
            		accepted_payment_method_check:false,
            		accepted_payment_method_credit_card:false,
            		accepted_payment_method_pap:false,
            		accepted_payment_method_dd:false,
            		accepted_payment_method_email:false,

            		invoice_delivery_method_hard_copy:false,
            		invoice_delivery_method_email:false,
            		invoice_delivery_method_both:false,

            		calendr_director:false,
                    calender_accounting_manager:false,
                    calender_building_manager:false,
                    calender_general_manager:false,
                    calender_netwrok_administrator:false,
                    calender_property_manager:false,
                    calender_account_payable:false,
                   
            		comment_date:'',
                    comment_time:'',
            		comments:'',
                    comment_calendar_yes:false,
                    comment_calendar_no:false,
                    comment_calendar:false,

            		custom_field:[],
            		custom_field_name:'',
            		custom_field_type:'',
                    page_id:4,
                  	id:'',
                  	

                  	dadicated_property_data:[
                        {
                            'id':'',
                            'reference_id':1,
                            'reference_value':'Building',
                            'property_name':'',
                            'country':'',
                            'state':'',
                            'property_code':'',
                            'city':'',
                        },
				        {
				            'id':'',
				            'reference_id':2,
				            'reference_value':'Residential Suite',
				            'property_name':'',
				            'country':'',
				            'state':'',
				            'property_code':'',
				            'city':'',
				        },
				        
				        {
				            'id':'',
				            'reference_id':3,
				            'reference_value':'Commercial Unit',
				            'property_name':'',
				            'country':'',
				            'state':'',
				            'property_code':'',
				            'city':'',
				        },
				        {
				            'id':'',
				            'reference_id':4,
				            'reference_value':'Parking Lot',
				            'property_name':'',
				            'country':'',
				            'state':'',
				            'property_code':'',
				            'city':'',
				        },
				        {
				            'id':'',
				            'reference_id':5,
				            'reference_value':'Storage Lot',
				            'property_name':'',
				            'country':'',
				            'state':'',
				            'property_code':'',
				            'city':'',
				        },
				        

                  	],
                    key_position_lavel_data:[],


            	}),
            	account_disable:true,
            	account_no:'',
            	countries:'',
            	payment_term_arr:[],
                key_position_lavel:[],
                account_status_arr:[],
            	currency_arr:[],
            	contact_person_arr:['Landlord','Property Manager','Building Manager','Accounting Manager','Accounts Payable','General Manager','Customer Service','Shipping and Receiving'],
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchCustomerProfile();
           // this.fetchCustomerProfileUpdate(14);
            //this.change_account_status();
           
        },
		
	    methods: {

            reset_form()
            {

                this.form.reset ();
                this.editmode=false;
               

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
                        'master_id':'',
                    
                    });
                   
                }
            },
            custom_number_field_validate(index)
            {
           
                if(this.form.custom_field[index].field_model<0 || this.form.custom_field[index].field_model>100)
                {
                    this.form.custom_field[index].field_model="";return;
                }
                
            },

	    	change_account_status(){
	    		if(this.form.account_status==1) this.account_disable=false;
	    		else this.account_disable=true;
	    	},
	    	check_company_type(e){

	    		if(e.target.checked)
	    		{
	    			this.show_company=true;
		 
	    		}
	    		else{
	    			this.show_company=false;
	    		}
	    		
	    	},

            check_fiscal_year_in_calender(e,type)
            {
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

            comment_calendar(e,type){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        this.form.comment_calendar_yes=true;
                        this.form.comment_calendar_no=false;
                        this.form.comment_calendar=true;
                        
                    }
                    else if(type==2)
                    {
                        this.form.comment_calendar_yes=false;
                        this.form.comment_calendar_no=true;
                        this.form.comment_calendar=false;
                    }
                }
                else{
                    this.form.comment_calendar_yes=false;
                    this.form.comment_calendar_no=false;
                    this.form.comment_calendar=false;
                }               
            },

	    	sales_on_credit(e,type){
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.sales_on_credit_yes=true;
		    			this.form.sales_on_credit_no=false;
		    			this.form.sales_on_credit=true;
		    			
		    		}
		    		else if(type==2)
		    		{
		    			this.form.sales_on_credit_yes=false;
		    			this.form.sales_on_credit_no=true;
		    			this.form.sales_on_credit=false;
		    		}
	    		}
	    		else{
	    			this.form.sales_on_credit_yes=false;
	    			this.form.sales_on_credit_no=false;
	    			this.form.sales_on_credit=false;
	    		}	    		
	    	},


	    	check_sales_return(e,type){
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.sales_return_yes=true;
		    			this.form.sales_return_no=false;
		    			this.form.sales_return=true;
		    			
		    		}
		    		else if(type==2)
		    		{
		    			this.form.sales_return_yes=false;
		    			this.form.sales_return_no=true;
		    			this.form.sales_return=false;
		    		}
	    		}
	    		else{
	    			this.form.sales_return_yes=false;
	    			this.form.sales_return_no=false;
	    			this.form.sales_return=false;
	    		}	    		
	    	},

	    	

	    	check_discount_type(e,type){
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.discount_yes=true;
		    			this.form.discount_no=false;
		    			this.form.is_discount=true;
		    			
		    		}
		    		else if(type==2)
		    		{
		    			this.form.discount_yes=false;
		    			this.form.discount_no=true;
		    			this.form.is_discount=false;
		    		}
	    		}
	    		else{
	    			this.form.discount_yes=false;
	    			this.form.discount_no=false;
	    			this.form.is_discount=false;
	    		}	    		
	    	},

	    	check_discount_base(e,type){
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.discount_base_before_tax=true;
		    			this.form.discount_base_after_tax=false;
		    			this.form.discount_base=true;
		    			
		    		}
		    		else if(type==2)
		    		{
		    			this.form.discount_base_before_tax=false;
		    			this.form.discount_base_after_tax=true;
		    			this.form.discount_base=false;
		    		}
	    		}
	    		else{
	    			this.form.discount_base_before_tax=false;
	    			this.form.discount_base_after_tax=false;
	    			this.form.discount_base=false;
	    		}	    		
	    	},

	    	check_invoice_pay_off_order(e,type){
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.invoice_pay_off_order_yes=true;
		    			this.form.invoice_pay_off_order_no=false;
		    			this.form.invoice_pay_off_order=true;
		    			
		    		}
		    		else if(type==2)
		    		{
		    			this.form.invoice_pay_off_order_yes=false;
		    			this.form.invoice_pay_off_order_no=true;
		    			this.form.invoice_pay_off_order=false;
		    		}
	    		}
	    		else{
	    			this.form.invoice_pay_off_order_yes=false;
	    			this.form.invoice_pay_off_order_no=false;
	    			this.form.invoice_pay_off_order=false;
	    		}	    		
	    	},

	    	
	    	check_accepted_payment_method(e,type){
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.accepted_payment_method_cash=true;
		    			this.form.accepted_payment_method_check=false;
		    			this.form.accepted_payment_method_credit_card=false;
		    			this.form.accepted_payment_method_dd=false;
		    			this.form.accepted_payment_method_email=false;
		    			this.form.accepted_payment_method_pap=false;
		    			this.form.accepted_payment_method=1;
		    			
		    		}
		    		else if(type==2)
		    		{
		    			this.form.accepted_payment_method_cash=false;

		    			this.form.accepted_payment_method_check=true;
		    			this.form.accepted_payment_method_credit_card=false;
		    			this.form.accepted_payment_method_dd=false;
		    			this.form.accepted_payment_method_email=false;
		    			this.form.accepted_payment_method_pap=false;
		    			this.form.accepted_payment_method=2;
		    		}
		    		if(type==3)
		    		{
		    			this.form.accepted_payment_method_cash=false;
		    			this.form.accepted_payment_method_check=false;
		    			this.form.accepted_payment_method_credit_card=true;
		    			this.form.accepted_payment_method_dd=false;
		    			this.form.accepted_payment_method_email=false;
		    			this.form.accepted_payment_method_pap=false;
		    			this.form.accepted_payment_method=3;
		    			
		    		}
		    		else if(type==4)
		    		{
		    			this.form.accepted_payment_method_cash=false;
		    			this.form.accepted_payment_method_check=false;
		    			this.form.accepted_payment_method_credit_card=false;
		    			this.form.accepted_payment_method_dd=true;
		    			this.form.accepted_payment_method_email=false;
		    			this.form.accepted_payment_method_pap=false;
		    			this.form.accepted_payment_method=4;
		    		}
		    		else if(type==5)
		    		{
		    			this.form.accepted_payment_method_cash=true;
		    			this.form.accepted_payment_method_check=false;
		    			this.form.accepted_payment_method_credit_card=false;
		    			this.form.accepted_payment_method_pap=false;
		    			this.form.accepted_payment_method_dd=true;
		    			this.form.accepted_payment_method=4;
		    		}
		    		else if(type==6)
		    		{
		    			this.form.accepted_payment_method_cash=true;
		    			this.form.accepted_payment_method_check=false;
		    			this.form.accepted_payment_method_credit_card=false;
		    			this.form.accepted_payment_method_pap=false;
		    			this.form.accepted_payment_method_dd=true;
		    			this.form.accepted_payment_method=4;
		    		}
	    		}
	    		else{
	    			this.form.accepted_payment_method=0;
	    		}	    		
	    	},


	    	
	    	check_property_type(e,type,index){
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.dadicated_property_data[index].is_residential=true;
		    			this.form.dadicated_property_data[index].is_comercial=false;
		    			this.form.dadicated_property_data[index].is_both=false;
		    			
		    		}
		    		else if(type==2)
		    		{
		    			this.form.dadicated_property_data[index].is_residential=false;
		    			this.form.dadicated_property_data[index].is_comercial=true;
		    			this.form.dadicated_property_data[index].is_both=false;
		    		}
		    		else if(type==3)
		    		{
		    			this.form.dadicated_property_data[index].is_residential=false;
		    			this.form.dadicated_property_data[index].is_comercial=false;
		    			this.form.dadicated_property_data[index].is_both=true;
		    		}
		    		
	    		}	    		
	    	},


	    	addCustomField(){

                $("#customModal").modal('show');
				$('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
               
            },

            addNewCustomField()
            {   alert(this.form.page_id)
            	if(!this.form.custom_field_name)
            	{
                    toast({
                        type: 'warning',
                        title: 'Please select Custom Field Name'
                    });
            		return;
            	}

            	if(!this.form.custom_field_type)
            	{
                    toast({
                        type: 'warning',
                        title: 'Please select Custom Field Type'
                    });
            		return;
            	}
                this.form.post('/CustomFields') .then(({ data }) => { 
               
                  var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Custom Field Successfully'
                        });

                        
                        var custom_field_id="custom_field_"+response_data[0];
                        this.form.custom_field.push({

                            id:'',
                            field_name:this.form.custom_field_name,
                            field_id:custom_field_id,
                            reference_id:response_data[0],
                            field_type:this.form.custom_field_type,
                            field_model:'',
                        });
                        this.form.custom_field_name='';
                        this.form.custom_field_type='';

                        $("#exampleModal").modal("hide");
                        $('.modal.in').modal('hide');
                        $('.modal-backdrop').remove() ;
                       
                    }
                    else{

                        toast({
                            type: 'danger',
                            title: 'Invalid Operation'
                        });
                        return;
                    }
                });            	

            },

            modelClose(){
            	
            },


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
            deleteCustomer()
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

                      this.form.delete('/CustomerPropertys/'+this.form.id).then(()=>{
                        
                          if(result.value) {
                               Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                              );
                            this.form.reset();
                            this.fetchCustomerProfile();
                          }            

                      }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                  });
               
              })
            },

	        fetchCustomerProfileooo()
            {
                let uri = '/CustomerPropertys';
                window.axios.get(uri).then((response) => {
                	

                	this.countries 								=response.data.country_arr;
                	this.account_status_arr						=response.data.account_status_arr;
                	this.payment_term_arr						=response.data.payment_term_arr;
                	this.currency_arr							=response.data.currency_arr;
                    this.key_position_lavel                     =response.data.key_position_lavel_arr;

                    for(let i=0; i<response.data.custom_fiend_level.length; i++){

                        

                        this.form.custom_field.push({

                            id:'',
                            field_name:response.data.custom_fiend_level[i].field_name,
                            field_id:response.data.custom_fiend_level[i].field_id,
                            reference_id:response.data.custom_fiend_level[i].reference_id,
                            field_type:response.data.custom_fiend_level[i].field_type,
                            field_model:'',
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
                            'master_id':'',
                        
                        });
                       
                    }



                	
                }); 

                
            },

          
         
       

            updateCustomerProfile()
            {
            
				
		        this.form.put('/CustomerPropertys/'+this.form.id).then(({ data })=>{
					var response_data=data.split("**");
                    alert(response_data[0]);
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        
                        this.fetchCustomerProfileUpdate(response_data[1]);
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
            
            save_stay(type){

                this.form.post('/CustomerPropertys') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });

                        if(type==1)
                        {
                            this.fetchCustomerProfileUpdate(response_data[1]);
                            this.editmode=true;
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                            
                        }
                        else if(type==3)
                        {
                            this.form.reset();
                            this.fetchCustomerProfile();
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

            fetchCustomerProfileUpdate(id)
            {
                this.form.reset ();

                let uri = '/CustomerPropertys/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.main_company_arr                       =response.data.main_company_arr;
                    this.countries                              =response.data.country_arr;
                    this.account_status_arr                     =response.data.account_status_arr;
                    this.payment_term_arr                       =response.data.payment_term_arr;
                    this.currency_arr                           =response.data.currency_arr;

                    this.form.id                                =response.data.customer_data[0].id;
                    this.form.account_no                        =response.data.customer_data[0].account_no;
                    this.form.scope_of_operation                =response.data.customer_data[0].scope_of_operation;
                    this.form.legal_name                        =response.data.customer_data[0].legal_name;
                    this.form.system_no                         =response.data.customer_data[0].system_no;
                    this.form.account_status                    =response.data.customer_data[0].account_status;
                    this.form.customer_type                     =response.data.customer_data[0].customer_type;
                    this.form.status_date                       =response.data.customer_data[0].status_date;
                    this.form.acount_reason                     =response.data.customer_data[0].acount_reason;
                    this.form.account_comments                  =response.data.customer_data[0].account_comments;
                    this.form.legal_name                        =response.data.customer_data[0].legal_name;
                    this.form.operational_name                  =response.data.customer_data[0].operational_name;
                    this.form.company_id                        =response.data.customer_data[0].company_id;

                    this.form.headoffice_house_number           =response.data.customer_data[0].headoffice_house_number;
                    this.form.headoffice_street_number          =response.data.customer_data[0].headoffice_street_number;
                    this.form.headoffice_city                   =response.data.customer_data[0].headoffice_city;
                    this.form.headoffice_state                  =response.data.customer_data[0].headoffice_state;
                    this.form.headoffice_country                =response.data.customer_data[0].headoffice_country;
                    this.form.headoffice_zip_code               =response.data.customer_data[0].headoffice_zip_code;
                    this.form.currency_domestic                 =response.data.customer_data[0].currency_domestic;
                    this.form.foreign_corrency_1                =response.data.customer_data[0].foreign_corrency_1;
                    this.form.foreign_corrency_2                =response.data.customer_data[0].foreign_corrency_2;
                    this.form.foreign_corrency_3                =response.data.customer_data[0].foreign_corrency_3;
                    this.form.foreign_corrency_4                =response.data.customer_data[0].foreign_corrency_4;
                    this.form.foreign_corrency_5                =response.data.customer_data[0].foreign_corrency_5;
                    this.form.invoice_term                      =response.data.customer_data[0].invoice_term;

                    this.form.sales_tax                         =response.data.customer_data[0].sales_tax;

                    this.form.credit_limit_daily                =response.data.customer_data[0].credit_limit_daily;
                    this.form.credit_limit_weekly               =response.data.customer_data[0].credit_limit_weekly;
                    this.form.credit_limit_monthly              =response.data.customer_data[0].credit_limit_monthly;
                    this.form.credit_limit_semi_monthly         =response.data.customer_data[0].credit_limit_semi_monthly;
                    this.form.credit_limit_yearly               =response.data.customer_data[0].credit_limit_yearly;
                    
                    this.form.fiscal_year_start_date            =response.data.customer_data[0].fiscal_year_start_date;
                    this.form.fiscal_year_end_date              =response.data.customer_data[0].fiscal_year_end_date;



                    this.form.fiscal_year_in_calender           =response.data.customer_data[0].fiscal_year_in_calender;
                    this.form.recuring_cycle                    =response.data.customer_data[0].recuring_cycle;
                    this.form.sales_on_credit                   =response.data.customer_data[0].sales_on_credit;
                    this.form.sales_return                      =response.data.customer_data[0].sales_return;

                    if(response.data.customer_data[0].fiscal_year_in_calender==1){
                        this.form.fiscal_year_in_calender_yes=true;
                        this.form.fiscal_year_in_calender_no=false;
                    }
                    else if(response.data.customer_data[0].fiscal_year_in_calender==2){
                        this.form.fiscal_year_in_calender_yes=false;
                        this.form.fiscal_year_in_calender_no=true;
                    }
                    else{
                        this.form.fiscal_year_in_calender_yes=false;
                        this.form.fiscal_year_in_calender_no=false;
                    }


                    if(response.data.customer_data[0].sales_on_credit==1){
                        this.form.sales_on_credit_yes=true;
                        this.form.sales_on_credit_no=false;
                    }
                    else if(response.data.customer_data[0].sales_on_credit==2){
                        this.form.sales_on_credit_yes=false;
                        this.form.sales_on_credit_no=true;
                    }
                    else{
                        this.form.sales_on_credit_yes=false;
                        this.form.sales_on_credit_no=false;
                    }

                    if(response.data.customer_data[0].sales_return==1){
                        this.form.sales_return_yes=true;
                        this.form.sales_return_no=false;
                    }
                    else if(response.data.customer_data[0].sales_return==2){
                        this.form.sales_return_yes=false;
                        this.form.sales_return_no=true;
                    }
                    else{
                        this.form.sales_return_yes=false;
                        this.form.sales_return_no=false;
                    }


                    if(response.data.customer_data[0].comment_calendar==1){
                        this.form.comment_calendar_yes=true;
                        this.form.comment_calendar_no=false;
                    }
                    else if(response.data.customer_data[0].comment_calendar==2){
                        this.form.comment_calendar_yes=false;
                        this.form.comment_calendar_no=true;
                    }
                    else{
                        this.form.comment_calendar_yes=false;
                        this.form.comment_calendar_no=false;
                    }

                    this.form.invoice_pay_off_order_oldest      =response.data.customer_data[0].invoice_pay_off_order_oldest;
                    this.form.invoice_pay_off_order_newest      =response.data.customer_data[0].invoice_pay_off_order_newest;
                    this.form.invoice_pay_off_order_optional    =response.data.customer_data[0].invoice_pay_off_order_optional;
                    this.form.accepted_payment_method_cash    =response.data.accepted_payment_method_cash;
                    this.form.accepted_payment_method_check     =response.data.customer_data[0].accepted_payment_method_check;
                    this.form.accepted_payment_method_credit_card=response.data.customer_data[0].accepted_payment_method_credit_card;

                    this.form.accepted_payment_method_pap       =response.data.customer_data[0].accepted_payment_method_pap;
                    this.form.accepted_payment_method_dd        =response.data.customer_data[0].accepted_payment_method_dd;


                    this.form.accepted_payment_method_email     =response.data.customer_data[0].accepted_payment_method_email;
                    this.form.invoice_delivery_method_hard_copy =response.data.customer_data[0].invoice_delivery_method_hard_copy;
                    this.form.invoice_delivery_method_email     =response.data.customer_data[0].invoice_delivery_method_email;

                    this.form.invoice_delivery_method_both      =response.data.customer_data[0].invoice_delivery_method_both;
                    this.form.calendr_director                  =response.data.customer_data[0].calendr_director;


                    this.form.calender_accounting_manager       =response.data.customer_data[0].calender_accounting_manager;
                    this.form.calender_building_manager         =response.data.customer_data[0].calender_building_manager;
                    this.form.calender_general_manager          =response.data.customer_data[0].calender_general_manager;

                    this.form.calender_netwrok_administrator    =response.data.customer_data[0].calender_netwrok_administrator;
                    this.form.calender_property_manager         =response.data.customer_data[0].calender_property_manager;
                    this.form.calender_account_payable          =response.data.customer_data[0].calender_account_payable;


                    this.form.comment_calendar                  =response.data.customer_data[0].comment_calendar;
                    this.form.comments                          =response.data.customer_data[0].comments;
                    this.form.comment_date                      =response.data.customer_data[0].comment_date;

                   
                    this.editmode=true;
                   

                    for(let i=0; i<response.data.key_position_data_arr.length; i++){

                        this.form.key_position_lavel_data.push({
                            'id':response.data.key_position_data_arr[i].id,
                            'reference_id':response.data.key_position_data_arr[i].reference_id,
                            'reference_value':response.data.key_position_data_arr[i].reference_value,
                            'office_phone':response.data.key_position_data_arr[i].office_phone,
                            'office_mobile':response.data.key_position_data_arr[i].office_mobile,
                            'fax':response.data.key_position_data_arr[i].fax,
                            'email':response.data.key_position_data_arr[i].email,
                            'key_position_name':response.data.key_position_data_arr[i].key_position_name,
                            'master_id':response.data.key_position_data_arr[i].master_id,
                        
                        });
                    }
                    this.form.dadicated_property_data=[];
                    for(let i=0; i<response.data.dedicated_property_data_arr.length; i++){

                        this.form.dadicated_property_data.push({
                            'id':response.data.dedicated_property_data_arr[i].id,
                            'reference_id':response.data.dedicated_property_data_arr[i].reference_id,
                            'reference_value':response.data.dedicated_property_data_arr[i].reference_value,
                            'property_name':response.data.dedicated_property_data_arr[i].property_name,
                            'country':response.data.dedicated_property_data_arr[i].country,
                            'state':response.data.dedicated_property_data_arr[i].state,
                            'property_code':response.data.dedicated_property_data_arr[i].property_code,
                            'city':response.data.dedicated_property_data_arr[i].city,
                            'master_id':response.data.dedicated_property_data_arr[i].master_id,
                        
                        });
                    }


                    for(let i=0; i<response.data.custom_fiend_level.length; i++){

                        this.form.custom_field.push({

                            id:response.data.custom_fiend_level[i].id,
                            field_name:response.data.custom_fiend_level[i].field_name,
                            field_id:response.data.custom_fiend_level[i].field_id,
                            reference_id:response.data.custom_fiend_level[i].reference_id,
                            field_type:response.data.custom_fiend_level[i].field_type,
                            field_model:response.data.custom_fiend_level[i].field_model,
                        });
                       
                    }

                    
                }); 

                
            },
	    }
    
    }  
	
</script>