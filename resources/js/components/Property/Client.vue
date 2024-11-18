<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Customer Information</h1>
                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> General Information:</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                            	<div class="form-box-outer">
                            		<div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                    		<label class="fieldlabels">Account No</label> 
                                    	</div>
                                    	<div class="col-md-7 col-sm-6 col-xs-12">
                                            <input v-model="form.account_no" 
												type="text" 
												name="account_no" 
												:class="{ 'is-invalid': form.errors.has('account_no') }" disabled/>
											<has-error :form="form" field="account_no"></has-error>
												 
										</div>
									</div>
									
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
												v-model="form.main_company" @change="check_company_type($event)">
											</div>
												 
										</div>
									</div>

									<div class="row" v-show="show_company">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                    		<label class="fieldlabels">Main Company Name</label>  
                                    		<input v-model="form.main_company_name" 
												type="text" 
												placeholder="Main Company Name"
												name="main_company_name" 
												:class="{ 'is-invalid': form.errors.has('main_company_name') }" disabled/>
												 
										</div>
									</div>
									
									<div class="row" v-show="!show_company">

										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Subsidiary Company Name</label> 
                                             <div class="position-relative form-group">
                                                <select v-model="form.subsidary_company_id"
                                                	name="subsidary_company_id"
                                                	class="custom-select" 
                                                	:class="{ 'is-invalid': form.errors.has('subsidary_company_id') }">
										        	<option disabled value="">--Select Subsidary Company-- </option>
												  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
										  		</select>
                                            </div>
                                        </div>

									</div>
                                    

                                </div> 
                               
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    
                                    <h4>Account Status</h4>

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
                                        <div class="col-md-12 col-sm-12 col-xs-12" v-show="account_disable">
                                            <label class="fieldlabels">Date:</label> 
                                            <date-picker 
						                     	v-model="form.status_date"
						                     	name="status_date"
						                     	lang="en"
						                     	type="status_date"
						                     	format="DD MMM, YYYY"
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
                                            <label class="fieldlabels">Message to Customer:</label> 

											<textarea 
                                            	v-model="form.message_to_customer"
                                                	style="height:70px;"
                                                	id="message_to_customer" 
                                                	name="message_to_customer" 
                                                	rows="4" 
                                                	cols="50"
                                                	placeholder="Type Reason" 
												:class="{ 'is-invalid': form.errors.has('message_to_customer') }">
											</textarea>
											<has-error :form="form" field="message_to_customer"></has-error>
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
                                                <select v-model="form.opeartion_scope"
                                                	name="opeartion_scope"
                                                	class="custom-select" 
                                                	:class="{ 'is-invalid': form.errors.has('opeartion_scope') }">
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
                            <hr>
                        </div>
                    </div>
                </div>


                <div class="form-folder">
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    
                                    <h4>Head Office Address</h4>

                                    <div class="row">
                                    	<div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels"> Number</label> 
                                            <input v-model="form.head_office_phone" 
												type="phone" 
												name="head_office_phone" 
												placeholder="Type Phone Number" 
												:class="{ 'is-invalid': form.errors.has('head_office_phone') }"/>
											     <has-error :form="form" field="head_office_phone"></has-error> 
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Street Number</label> 
                                            <input v-model="form.head_office_street_number" 
												type="text" 
												name="head_office_street_number" 
												placeholder="Type Street Number" 
												:class="{ 'is-invalid': form.errors.has('head_office_street_number') }"/>
											     <has-error :form="form" field="head_office_street_number"></has-error> 
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">City:</label> 
                                            <input v-model="form.head_office_city" 
												type="text" 
												name="head_office_city" 
												placeholder="Type City" 
												:class="{ 'is-invalid': form.errors.has('head_office_city') }"/>
											     <has-error :form="form" field="head_office_city"></has-error> 
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">State:</label> 
                                            <input v-model="form.head_office_state" 
												type="text" 
												name="head_office_state" 
												placeholder="Type State" 
												:class="{ 'is-invalid': form.errors.has('head_office_state') }"/>
											     <has-error :form="form" field="head_office_state"></has-error>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Country:</label> 
                                            <div class="position-relative form-group">
                                                <select v-model="form.head_office_country"
                                                	name="head_office_country"
                                                	class="custom-select" 
                                                	:class="{ 'is-invalid': form.errors.has('head_office_country') }">
										        	<option disabled value="">--Select-- </option>
												  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
										  		</select>
										  		<has-error :form="form" field="head_office_country"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Zip/Postal Code:</label> 
                                            <input v-model="form.head_office_postal_code" 
												type="text" 
												name="head_office_postal_code" 
												placeholder="Type Zip/Postal Code" 
												:class="{ 'is-invalid': form.errors.has('head_office_postal_code') }"/>
											     <has-error :form="form" field="head_office_state"></has-error>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    <h4>Chart of Accounts:</h4>
                                    <div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                    		<label class="fieldlabels">Amount Before tax</label> 
                                    	</div>
                                    	<div class="col-md-7 col-sm-6 col-xs-12">
                                             <select v-model="form.amount_before_tax_account"
                                            	name="amount_before_tax_account"
                                            	class="custom-select" 
                                            	:class="{ 'is-invalid': form.errors.has('amount_before_tax_account') }">
									        	<option disabled value="">--Select-- </option>
											  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
									  		</select>
										    <has-error :form="form" field="amount_before_tax_account"></has-error>
												 
										</div>
									</div>

									<div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                    		<label class="fieldlabels">Discount</label> 
                                    	</div>
                                    	<div class="col-md-7 col-sm-6 col-xs-12">
                                             <select v-model="form.discount_account"
                                            	name="discount_account"
                                            	class="custom-select" 
                                            	:class="{ 'is-invalid': form.errors.has('discount_account') }">
									        	<option disabled value="">--Select-- </option>
											  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
									  		</select>
										    <has-error :form="form" field="discount_account"></has-error>
												 
										</div>
									</div>

									<div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                    		
                                    		<label class="fieldlabels">Tax-1</label> 
                                    	</div>
                                    	<div class="col-md-7 col-sm-6 col-xs-12">
                                             <select v-model="form.tax_1_account"
                                            	name="tax_1_account"
                                            	class="custom-select" 
                                            	:class="{ 'is-invalid': form.errors.has('tax_1_account') }">
									        	<option disabled value="">--Select-- </option>
											  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
									  		</select>
										    <has-error :form="form" field="tax_1_account"></has-error>
												 
										</div>
									</div>

									<div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                    		<h4></h4>
                                    		<label class="fieldlabels">tax-2</label> 
                                    	</div>
                                    	<div class="col-md-7 col-sm-6 col-xs-12">
                                             <select v-model="form.tax_2_account"
                                            	name="tax_2_account"
                                            	class="custom-select" 
                                            	:class="{ 'is-invalid': form.errors.has('tax_2_account') }">
									        	<option disabled value="">--Select-- </option>
											  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
									  		</select>
										    <has-error :form="form" field="tax_2_account"></has-error>
												 
										</div>
									</div>

									<div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                    		<label class="fieldlabels">Tax-3</label> 
                                    	</div>
                                    	<div class="col-md-7 col-sm-6 col-xs-12">
                                             <select v-model="form.tax_3_account"
                                            	name="tax_3_account"
                                            	class="custom-select" 
                                            	:class="{ 'is-invalid': form.errors.has('tax_3_account') }">
									        	<option disabled value="">--Select-- </option>
											  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
									  		</select>
										    <has-error :form="form" field="customer_name"></has-error>
												 
										</div>
									</div>

									<div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                    		<h4></h4>
                                    		<label class="fieldlabels">Amount After tax</label> 
                                    	</div>
                                    	<div class="col-md-7 col-sm-6 col-xs-12">
                                             <select v-model="form.amount_after_tax"
                                            	name="amount_after_tax"
                                            	class="custom-select" 
                                            	:class="{ 'is-invalid': form.errors.has('amount_after_tax') }">
									        	<option disabled value="">--Select-- </option>
											  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
									  		</select>
										    <has-error :form="form" field="amount_after_tax"></has-error>
												 
										</div>
									</div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>


                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> Financial:</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            <div class="col-md-4 col-sm-6 col-xs-12"> 

                            	<div class="form-box-outer">
                                    

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Opening Balance</label> 
                                            <input v-model="form.opening_balance" 
												type="email" 
												name="opening_balance" 
												:class="{ 'is-invalid': form.errors.has('opening_balance') }"/>
											     <has-error :form="form" field="opening_balance"></has-error>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Currency:</label> 
                                            <select v-model="form.currency"
                                            	name="currency"
                                            	class="custom-select" 
                                            	:class="{ 'is-invalid': form.errors.has('currency') }">
									        	<option disabled value="">--Select-- </option>
											  	<option v-for="(currency,index) in currency_arr" :value="index">{{currency}}</option>
									  		</select> 
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Invoice Term:</label> 
                                            

											<select v-model="form.invoice_term"
                                            	name="invoice_term"
                                            	class="custom-select" 
                                            	:class="{ 'is-invalid': form.errors.has('invoice_term') }">
									        	<option disabled value="">--Select-- </option>
											  	<option v-for="(payment_term,index) in payment_term_arr" :value="index">{{payment_term}}</option>
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
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    <h4>Down Payment required:</h4>
                                    <div class="form-holder">
                                        <div class="form-check-inline">
					                        <input type="checkbox" value="0" 
																name="down_payment_yes" 
																id="down_payment_yes"
																v-model="form.down_payment_yes" @change="check_down_payment($event,1)">
					                        <label for="down_payment_yes">Yes</label><br>
					                        <input type="checkbox" value="0" 
																name="down_payment_no" 
																id="down_payment_no"
																v-model="form.down_payment_no" @change="check_down_payment($event,2)">
					                        <label for="down_payment_no">No</label><br>
					                        
					                    </div>
                                    </div>

                                    <h4>Invoice Pay Off order:</h4>
                                    <div class="form-holder">
                                        <div class="form-check-inline">
					                        <input type="checkbox" value="0" 
																name="invoice_pay_off_order_yes" 
																id="invoice_pay_off_order_yes"
																v-model="form.invoice_pay_off_order_yes" @change="check_invoice_pay_off_order($event,1)">
					                        <label for="invoice_pay_off_order_yes">From oldest</label><br>
					                        <input type="checkbox" value="0" 
																name="invoice_pay_off_order_no" 
																id="invoice_pay_off_order_no"
																v-model="form.invoice_pay_off_order_no" @change="check_invoice_pay_off_order($event,2)">
					                        <label for="invoice_pay_off_order_no">From the newest</label><br>
					                        
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
					                        	id="accepted_payment_method_check" 
					                        	name="accepted_payment_method_check" 
					                        	v-model="form.accepted_payment_method_check"
					                        	@change="check_accepted_payment_method($event,1)">
					                        <label for="accepted_payment_method_check">Check</label><br>


					                        <input type="checkbox" 
					                        	id="accepted_payment_method_credit_card" 
					                        	name="accepted_payment_method_credit_card" 
					                        	v-model="form.accepted_payment_method_credit_card" 
					                        	@change="check_accepted_payment_method($event,2)">
					                        <label for="accepted_payment_method_credit_card">Credit Card</label><br>


					                        <input type="checkbox" 
					                        	id="accepted_payment_method_pap" 
					                        	name="accepted_payment_method_pap" 
					                        	v-model="form.accepted_payment_method_pap"
					                        	@change="check_accepted_payment_method($event,3)">
					                        <label for="accepted_payment_method_pap">Pre- Authorized Paymnet</label><br>

					                        <input type="checkbox" 
					                        	id="accepted_payment_method_dd" 
					                        	name="accepted_payment_method_dd" 
					                        	v-model="form.accepted_payment_method_dd" 
					                        	@change="check_accepted_payment_method($event,4)">
					                        <label for="accepted_payment_method_dd">Direct Deposit</label><br>
					                       
                                        </div>
                                    </div>


                                    <h4>Invoice Delivery Method:</h4>
                                    <div class="form-holder">
                                        <div class="form-check-inline">
                                           
					                        <input type="checkbox" 
					                        	id="invoice_delivery_method_hard_copy" 
					                        	name="invoice_delivery_method_hard_copy" 
					                        	v-model="form.invoice_delivery_method_hard_copy"
					                        	@change="check_invoice_delivery_method($event,1)">
					                        <label for="invoice_delivery_method_hard_copy">Mail hard Copy</label><br>

					                        <input type="checkbox" 
					                        	id="invoice_delivery_method_email" 
					                        	name="invoice_delivery_method_email" 
					                        	v-model="form.invoice_delivery_method_email" 
					                        	@change="check_invoice_delivery_method($event,2)">
					                        <label for="invoice_delivery_method_email">Email</label><br>
					                        <input type="checkbox" 
					                        	id="invoice_delivery_method_both" 
					                        	name="invoice_delivery_method_both" 
					                        	v-model="form.invoice_delivery_method_both"
					                        	@change="check_invoice_delivery_method($event,3)">
					                        <label for="invoice_delivery_method_both">Both</label><br>
					                        
					                       
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
                    <h3><i class="fa fa-hand-point-right"></i>  Sales Tax && Discount:</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-7 col-sm-6 col-xs-12"> 
                                <div class="form-box-outer">
                                    <table class="table">
										
										<thead>
										    <tr>
												<th scope="col">#</th>
												<th scope="col">Tax Name</th>
												<th scope="col">Rate %</th>
										    </tr>
										</thead>
										<tbody style="border:none">
										    <tr>
												<th scope="row">Tax 1</th>
												<td>
													

													<input 
														v-model="form.sales_tax_one_name" 
														type="text" 
														name="sales_tax_one_name" 
														placeholder="Type Tax Name"
														:class="{ 'is-invalid': form.errors.has('sales_tax_one_name') }"/>
													     <has-error :form="form" field="sales_tax_one_name"></has-error>
												</td>
												<td>
													<input 
														v-model="form.sales_tax_one_rate" 
														type="number" 
														name="sales_tax_one_rate" 
														placeholder="Type Rate %"
														:class="{ 'is-invalid': form.errors.has('sales_tax_one_rate') }"/>
													     <has-error :form="form" field="sales_tax_one_rate"></has-error>
												</td>
										     
										    </tr>
										    <tr>
										        <th scope="row">Tax 2</th>
										        <td>
													<input 
														v-model="form.sales_tax_two_name" 
														type="text" 
														name="sales_tax_two_name" 
														placeholder="Type Tax Name"
														:class="{ 'is-invalid': form.errors.has('sales_tax_two_name') }"/>
													     <has-error :form="form" field="sales_tax_two_name"></has-error>
										        </td>
										        <td>
										      		<input 
														v-model="form.sales_tax_two_rate" 
														type="number" 
														name="sales_tax_two_rate" 
														placeholder="Type Rate %"
														:class="{ 'is-invalid': form.errors.has('sales_tax_two_rate') }"/>
													     <has-error :form="form" field="sales_tax_two_rate"></has-error>
										        </td>
										     
										    </tr>
										    <tr>
										        <th scope="row">Tax 3</th>
										        <td>
										      		<input 
														v-model="form.sales_tax_three_name" 
														type="text" 
														name="sales_tax_three_name" 
														placeholder="Type Tax Name"
														:class="{ 'is-invalid': form.errors.has('sales_tax_three_name') }"/>
													     <has-error :form="form" field="sales_tax_three_name"></has-error>
										        </td>
										        <td>
										      		<input 
														v-model="form.sales_tax_three_rate" 
														type="number" 
														name="sales_tax_three_rate" 
														placeholder="Type Rate %"
														:class="{ 'is-invalid': form.errors.has('sales_tax_three_rate') }"/>
													     <has-error :form="form" field="sales_tax_three_rate"></has-error>
										        </td>
										    
										    </tr>
										    <tr>
										        <th scope="row">Tax 4</th>
										        <td>
										      		<input 
														v-model="form.sales_tax_three_name" 
														type="text" 
														name="sales_tax_three_name" 
														placeholder="Type Tax Name"
														:class="{ 'is-invalid': form.errors.has('sales_tax_three_name') }"/>
													     <has-error :form="form" field="sales_tax_three_name"></has-error>
														
										        </td>
										      	<td>
										      		<input 
														v-model="form.sales_tax_four_rate" 
														type="number" 
														name="sales_tax_four_rate" 
														placeholder="Type Rate %"
														:class="{ 'is-invalid': form.errors.has('sales_tax_four_rate') }"/>
													     <has-error :form="form" field="sales_tax_four_rate"></has-error>
										      	</td>
										     
										    </tr>
										</tbody>
									</table> 
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6 col-xs-12"> 
                                <div class="form-box-outer">
                                    <h4>Discount:</h4>
                                    <div class="form-holder">
                                        <div class="form-check-inline">&nbsp; &nbsp;&nbsp; &nbsp;
					                        <input type="checkbox" value="0" 
												name="discount_yes" 
												id="discount_yes"
												v-model="form.discount_yes" @change="check_discount_type($event,1)">
					                        <label for="discount_yes">On</label>

					                        <input type="checkbox" value="0" 
												name="discount_no" 
												id="discount_no"
												v-model="form.discount_no" @change="check_discount_type($event,2)">
					                        <label for="discount_no">Off</label><br>
					                        
					                    </div>
                                    </div>
                                    <h4>Discount Amount</h4>
                                    <input v-model="form.discount_amount" 
										type="text" 
										placeholder="Type Amount"
										name="discount_amount" 
										:class="{ 'is-invalid': form.errors.has('discount_amount') }"/>
									      <has-error :form="form" field="discount_amount"></has-error>
									<h4>Discount Percentage</h4>
                                    <input v-model="form.discount_percentage" 
										type="text" 
										placeholder="Type Percentage"
										name="discount_percentage" 
										:class="{ 'is-invalid': form.errors.has('discount_percentage') }"/>
									      <has-error :form="form" field="discount_percentage"></has-error>

                                    <h4>Discount Base:</h4>
                                    <div class="form-holder">
                                        <div class="form-check-inline">&nbsp; &nbsp;&nbsp; &nbsp;
					                        <input type="checkbox" 
					                        	value="0" 
												name="discount_base_before_tax" 
												id="discount_base_before_tax"
												v-model="form.discount_base_before_tax" @change="check_discount_base($event,1)">
					                        <label for="discount_base_before_tax">Before tax</label>
					                        <input type="checkbox" 
					                        	value="0" 
												name="discount_base_after_tax" 
												id="discount_base_after_tax"
												v-model="form.discount_base_after_tax" 
												@change="check_discount_base($event,2)">
					                        <label for="discount_base_after_tax">After Tax </label><br>
					                        
					                    </div>
                                    </div>
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
												<th scope="col">#</th>
												<th scope="col">Res.</th>
												<th scope="col">Com.</th>
												<th scope="col">Res./Com.</th>
												<th scope="col">Property Code</th>
												<th scope="col">Qualtity</th>
										    </tr>
										</thead>
										<tbody style="border:none">
										    <tr v-for="(dadicated_property,index) in form.dadicated_property_data">
												<th scope="row"><h4>{{dadicated_property.reference_value}}</h4></th>
												<td>
													<div class="form-check-inline">
														<input type="checkbox" 
								                        	v-bind:id="'is_residential_'+index"
															placeholder="Type Office Phone"
									                        name="is_residential[]" 
									                        v-model="dadicated_property.is_residential"
								                        	@change="check_property_type($event,1,index)">


								                        
							                        </div>
												</td>
												<td>
													<div class="form-check-inline">
														<input type="checkbox" 
								                        	v-bind:id="'is_comercial_'+index"
															placeholder="Type Office Phone"
									                        name="is_comercial[]" 
									                        v-model="dadicated_property.is_comercial"
								                        	@change="check_property_type($event,2,index)">
							                        </div>
												</td>
												<td>
													<div class="form-check-inline">
														<input type="checkbox" 
								                        	v-bind:id="'is_both_'+index"
															placeholder="Type Office Phone"
									                        name="is_both[]" 
									                        v-model="dadicated_property.is_both"
								                        	@change="check_property_type($event,3,index)">
							                        </div>
												</td>
												<td>
													<input 
														type="number" 
														placeholder="Type Property Code"
														v-bind:id="'dedicated_property_code_'+index"
								                        name="dedicated_property_code[]" 
								                        v-model="dadicated_property.property_code"/>
												</td>
												<td>
													<input 
														type="number" 
														placeholder="Type Quantity"
														v-bind:id="'quantity_'+index"
								                        name="quantity[]" 
								                        v-model="dadicated_property.quantity"/>
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
                    <h3><i class="fa fa-hand-point-right"></i>Contact</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="form-box-outer">
                                    <table class="table">
										
										<thead>
										    <tr>
												<th scope="col">#</th>
												<th scope="col">Ph. Office</th>
												<th scope="col">Ph. Mobile</th>
												<th scope="col">Email</th>
												<th scope="col">Fax</th>
												<th scope="col">Property Code</th>
										    </tr>
										</thead>
										<tbody style="border:none">
										    
										   
										    <tr v-for="(contact_person,index) in form.contact_person_data">
										        <th width="20%" scope="row"><h6>{{contact_person.reference_value}}</h6></th>
										        
										        <td width="10%">
													<div class="form-check-inline">
														

								                        <input 
															type="text"
															v-bind:id="'office_phone_'+index"
															placeholder="Type Office Phone"
									                        name="office_phone[]" 
									                        v-model="contact_person.office_phone"/>
							                        </div>
												</td>
												
												<td width="10%">
													<div class="form-check-inline">
														<input 
															type="text"
															v-bind:id="'office_mobile_'+index"
															placeholder="Type Mobile Phone"
									                        name="office_mobile[]" 
									                        v-model="contact_person.office_mobile"/>
							                        </div>
												</td>
												<td width="15%">
													<div class="form-check-inline">
														<input 
															type="text"
															v-bind:id="'email_'+index"
															placeholder="Type Email"
									                        name="email[]" 
									                        v-model="contact_person.email"/>
							                        </div>
												</td>
												<td width="15%">

													<input 
															type="text"
															v-bind:id="'fax_'+index"
															placeholder="Type Fax Number"
									                        name="fax[]" 
									                        v-model="contact_person.fax"/>
													
												</td>
												<td width="15%">
													<input 
														type="text"
														v-bind:id="'property_code_'+index"
														placeholder="Type Property Code"
								                        name="property_code[]" 
								                        v-model="contact_person.property_code"/>
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
                    <h3><i class="fa fa-hand-point-right"></i> Emergency Action & Optional Field:</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            
                            <div class="col-md-7 col-sm-6 col-xs-12"> 
                                <div class="form-box-outer">
                                    
                                    <h4>Emergency Action</h4>

                                    <div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Put this Customer On Hold </label> 
                                       
                                            <select v-model="form.put_customer_on_hold"
                                                	name="put_customer_on_hold"
                                                	class="custom-select" 
                                                	:class="{ 'is-invalid': form.errors.has('put_customer_on_hold') }">
										        	<option disabled value="">--Select-- </option>
										        	<option  value="1">Yes </option>
										        	<option  value="2">No </option>
										  		</select>
											     <has-error :form="form" field="contact_person_email"></has-error>
                                        </div>
                                    
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Reason:</label> 
                                            <textarea 
                                            	v-model="form.reason"
                                                	style="height:70px;"
                                                	id="reason" 
                                                	name="reason" 
                                                	rows="4" 
                                                	cols="50"></textarea> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">User Name:</label> 
                                            <input v-model="form.user_name" 
												type="text" 
												name="user_name" 
												:class="{ 'is-invalid': form.errors.has('user_name') }"/>
											     <has-error :form="form" field="user_name"></has-error>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Date and Time:</label> 
                                            <br/>

											<date-picker 
						                     	v-model="form.reject_date"
						                     	name="reject_date"
						                     	lang="en"
						                     	type="reject_date"
						                     	format="DD MMM, YYYY"
						                     	:class="{ 'is-invalid': form.errors.has('reject_date') }"></date-picker>
										      <has-error :form="form" field="reject_date"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Message to Customer:</label> 
                                            <textarea 
                                            	v-model="form.message_to_customer"
                                                	style="height:100px;"
                                                	id="message_to_customer" 
                                                	name="message_to_customer" 
                                                	rows="4" 
                                                	cols="50"></textarea>
												<has-error :form="form" field="message_to_customer"></has-error>
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12">
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
                                    </div> 

                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6 col-xs-12"> 
                                <div class="form-box-outer">
                                    
                                    <h4>Custom Field</h4>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12" v-for="(single_field,index) in form.custom_field">
                                            <label class="fieldlabels">{{single_field.field_name}}</label> 
                                            <div v-if="single_field.field_type==1">
                                                
												<date-picker 
							                     	v-model="single_field.field_model" 
													v-bind:name="single_field.field_id" 
													v-bind:id="single_field.field_id"
							                     	lang="en"
							                     	format="DD MMM, YYYY"
							                     	:class="{ 'is-invalid': form.errors.has('single_field.field_id') }">
							                    </date-picker>
											    <has-error :form="form" field="single_field.field_id"></has-error>
											</div> 
                                            <div v-else-if="single_field.field_type==3">
                                                <input 
                                                	v-model="single_field.field_model" 
													type="text" 
													v-bind:name="single_field.field_id" 
													v-bind:id="single_field.field_id"
													 
													:class="{ 'is-invalid': form.errors.has('single_field.field_id') }"/>
												     <has-error :form="form" field="single_field.field_id"></has-error>
											</div>

											<div v-else-if="single_field.field_type==4">
                                                <input 
                                                	v-model="single_field.field_model" 
													type="number" 
													v-bind:name="single_field.field_id" 
													v-bind:id="single_field.field_id"
													 
													:class="{ 'is-invalid': form.errors.has('single_field.field_id') }"/>
												     <has-error :form="form" field="single_field.field_id"></has-error>
											</div>

											<div v-else-if="single_field.field_type==5">
                                                <input 
                                                	v-model="single_field.field_model" 
													type="phone" 
													v-bind:name="single_field.field_id" 
													v-bind:id="single_field.field_id"
													 
													:class="{ 'is-invalid': form.errors.has('single_field.field_id') }"/>
												     <has-error :form="form" field="single_field.field_id"></has-error>
											</div>

											<div v-else-if="single_field.field_type==3">
                                                <input 
                                                	v-model="single_field.field_model" 
													type="text" 
													v-bind:name="single_field.field_id" 
													v-bind:id="single_field.field_id"
													 
													:class="{ 'is-invalid': form.errors.has('single_field.field_id') }"/>
												     <has-error :form="form" field="single_field.field_id"></has-error>
											</div>

											<div v-else-if="single_field.field_type==3">
                                                <input 
                                                	v-model="single_field.field_model" 
													type="text" 
													v-bind:name="single_field.field_id" 
													v-bind:id="single_field.field_id"
													 
													:class="{ 'is-invalid': form.errors.has('single_field.field_id') }"/>
												     <has-error :form="form" field="single_field.field_id"></has-error>
											</div>
											
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <button type="button" class="btn btn-primary" @click.prevent="addCustomField()">Add New Custom Field</button>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                                            <label class="fieldlabels">Custom Field Name</label> 
                                            <input v-model="form.custom_field_name" 
												type="text" 
												name="custom_field_name" 
												placeholder="Type Custom Field Name" 
												:class="{ 'is-invalid': form.errors.has('custom_field_name') }"/>
											     <has-error :form="form" field="custom_field_name"></has-error>  


                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                                            <label class="fieldlabels">Custom Field Type:</label> 
                                           <select v-model="form.custom_field_type"
                                            	name="custom_field_type"
                                            	class="custom-select" 
                                            	:class="{ 'is-invalid': form.errors.has('custom_field_type') }">
									        	<option disabled value="">--Select-- </option>
									        	<option value="1">Date</option>
									        	<option value="2">Time</option>
									        	<option value="3">Text</option>
									        	<option value="4">Number</option>
									        	<option value="5">Phone Number</option>
									        	<option value="6">Percentage</option>
									        	<option value="7">Financial</option>
									        	<option value="8">Web Line</option>
											  	
									  		</select>
                                            
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <button type="button" class="btn btn-primary" @click.prevent="addNewCustomField()">Add New Custom Field</button>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            
                            <hr>
                        </div>
                    </div>
                </div>
                
            </div> 
	        <button :disabled="form.busy"  type="submit" class="next action-button">Save</button>
	        
	         <!--  MOdel  -->
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
				        <button type="button" class="btn btn-primary">Save changes</button>
				      </div>
				    </div>
				  </div>
				</div>



			<!-- model end -->
	    </form>
	   

    </fieldset>

</template>

<script>
	import Vue from 'vue';
	import DatePicker from 'vue2-datepicker';


	


    export default {
        name:'list-product-categories',
       	components:{
			DatePicker
		},
        data(){
            return{
            	editmode:false,
            	show_company:true,
				filter: '',
            	form:new Form({
            		account_status:'',
            		status_date:'',
            		acount_reason:'',
            		message_to_customer:'',
            		account_no:'',
            		legal_name:'',
            		operational_name:'',
            		opeartion_scope:'',
            		main_company_name:'',
            		main_company_id:'',
            		subsidary_company_id:'',
            		main_company:true,

            		head_office_phone:'',
            		head_office_street_number:'',
            		head_office_city:'',
            		head_office_state:'',
            		head_office_country:'',
            		head_office_postal_code:'',

            		amount_before_tax_account:'',
            		discount_account:'',
            		tax_1_account:'',
            		tax_2_account:'',
            		tax_3_account:'',
            		amount_after_tax:'',
            		opening_balance:'',
            		currency:'',
            		invoice_term:'',
            		credit_limit_daily:'',
            		credit_limit_weekly:'',

            		credit_limit_monthly:'',
            		credit_limit_semi_monthly:'',
            		credit_limit_yearly:'',


            		down_payment_no:false,
            		down_payment_yes:false,
            		down_payment_required:false,

            		invoice_pay_off_order_yes:false,
            		invoice_pay_off_order_no:false,
            		invoice_pay_off_order:false,

            		accepted_payment_method_check:false,
            		accepted_payment_method_credit_card:false,
            		accepted_payment_method_pap:false,
            		accepted_payment_method_dd:false,
            		accepted_payment_method:0,

            		invoice_delivery_method:0,
            		invoice_delivery_method_hard_copy:false,
            		invoice_delivery_method_email:false,
            		invoice_delivery_method_both:false,

            		sales_tax_one_name:'',
            		sales_tax_two_name:'',
            		sales_tax_three_name:'',
            		sales_tax_four_name:'',

            		sales_tax_one_rate:'',
            		sales_tax_two_rate:'',
            		sales_tax_three_rate:'',
            		sales_tax_four_rate:'',

            		discount_yes:false,
            		discount_no:false,
            		is_discount:false,

            		discount_base_before_tax:false,
            		discount_base_after_tax:false,
            		discount_base:false,

            		reject_date:'',
            		message_to_customer:'',
            		comments:'',

            		custom_field:[],
            		custom_field_name:'',
            		custom_field_type:'',
            		custom_field_index:0,
                  	id:'',
                  	contact_person_data:[
                  		{
				            'id':'',
				            'reference_id':1,
				            'reference_value':'Landlord',
				            'office_phone':'',
				            'office_mobile':'',
				            'fax':'',
				            'property_code':'',
				            'email':'',
				        },
				        {
				            'id':'',
				            'reference_id':2,
				            'reference_value':'Property Manager',
				            'office_phone':'',
				            'office_mobile':'',
				            'fax':'',
				            'property_code':'',
				            'email':'',
				        },
				        {
				            'id':'',
				            'reference_id':3,
				            'reference_value':'Building Manager',
				            'office_phone':'',
				            'office_mobile':'',
				            'fax':'',
				            'property_code':'',
				            'email':'',
				        },
				        {
				            'id':'',
				            'reference_id':4,
				            'reference_value':'Accounting Manager',
				            'office_phone':'',
				            'office_mobile':'',
				            'fax':'',
				            'property_code':'',
				            'email':'',
				        },
				        {
				            'id':'',
				            'reference_id':5,
				            'reference_value':'Accounts Payable',
				            'office_phone':'',
				            'office_mobile':'',
				            'fax':'',
				            'property_code':'',
				            'email':'',
				        },
				        {
				            'id':'',
				            'reference_id':6,
				            'reference_value':'General Manager',
				            'office_phone':'',
				            'office_mobile':'',
				            'fax':'',
				            'property_code':'',
				            'email':'',
				        },
				        {
				            'id':'',
				            'reference_id':7,
				            'reference_value':'Customer Service',
				            'office_phone':'',
				            'office_mobile':'',
				            'fax':'',
				            'property_code':'',
				            'email':'',
				        },
				        {
				            'id':'',
				            'reference_id':8,
				            'reference_value':'Shipping and Receiving',
				            'office_phone':'',
				            'office_mobile':'',
				            'fax':'',
				            'property_code':'',
				            'email':'',
				        },

                  	],

                  	dadicated_property_data:[
				        {
				            'id':'',
				            'reference_id':2,
				            'reference_value':'Residential Suite',
				            'is_residential':false,
				            'is_comercial':false,
				            'is_both':false,
				            'property_code':'',
				            'quantity':'',
				        },
				        {
				            'id':'',
				            'reference_id':3,
				            'reference_value':'Building Manager',
				            'is_residential':false,
				            'is_comercial':false,
				            'is_both':false,
				            'property_code':'',
				            'quantity':'',
				        },
				        {
				            'id':'',
				            'reference_id':4,
				            'reference_value':'Commercial Unit',
				            'is_residential':false,
				            'is_comercial':false,
				            'is_both':false,
				            'property_code':'',
				            'quantity':'',
				        },
				        {
				            'id':'',
				            'reference_id':5,
				            'reference_value':'Parking Lot',
				            'is_residential':false,
				            'is_comercial':false,
				            'is_both':false,
				            'property_code':'',
				            'quantity':'',
				        },
				        {
				            'id':'',
				            'reference_id':6,
				            'reference_value':'Storage Lot',
				            'is_residential':false,
				            'is_comercial':false,
				            'is_both':false,
				            'property_code':'',
				            'quantity':'',
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
           
        },
		
	    methods: {

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


	    	check_down_payment(e,type){
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.down_payment_yes=true;
		    			this.form.down_payment_no=false;
		    			this.form.down_payment_required=true;
		    			
		    		}
		    		else if(type==2)
		    		{
		    			this.form.down_payment_yes=false;
		    			this.form.down_payment_no=true;
		    			this.form.down_payment_required=false;
		    		}
	    		}
	    		else{
	    			this.form.down_payment_yes=false;
	    			this.form.down_payment_no=false;
	    			this.form.down_payment_required=false;
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
		    			this.form.accepted_payment_method_check=true;
		    			this.form.accepted_payment_method_credit_card=false;
		    			this.form.accepted_payment_method_pap=false;
		    			this.form.accepted_payment_method_dd=false;
		    			this.form.accepted_payment_method=1;
		    			
		    		}
		    		else if(type==2)
		    		{
		    			this.form.accepted_payment_method_check=false;
		    			this.form.accepted_payment_method_credit_card=true;
		    			this.form.accepted_payment_method_pap=false;
		    			this.form.accepted_payment_method_dd=false;
		    			this.form.accepted_payment_method=2;
		    		}
		    		if(type==3)
		    		{
		    			this.form.accepted_payment_method_check=false;
		    			this.form.accepted_payment_method_credit_card=false;
		    			this.form.accepted_payment_method_pap=true;
		    			this.form.accepted_payment_method_dd=false;
		    			this.form.accepted_payment_method=3;
		    			
		    		}
		    		else if(type==4)
		    		{
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


	    	check_invoice_delivery_method(e,type){
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.invoice_delivery_method_hard_copy=true;
		    			this.form.invoice_delivery_method_email=false;
		    			this.form.invoice_delivery_method_both=false;
		    			this.form.invoice_delivery_method=1;
		    			
		    		}
		    		else if(type==2)
		    		{
		    			this.form.invoice_delivery_method_hard_copy=false;
		    			this.form.invoice_delivery_method_email=true;
		    			this.form.invoice_delivery_method_both=false;
		    			this.form.invoice_delivery_method=2;
		    		}
		    		if(type==3)
		    		{
		    			this.form.invoice_delivery_method_hard_copy=false;
		    			this.form.invoice_delivery_method_email=false;
		    			this.form.invoice_delivery_method_both=true;
		    			this.form.invoice_delivery_method=3;
		    			
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
            {
            	if(!this.form.custom_field_name)
            	{
            		Swal("failed!","Please select Custom Field Name","warning");
            		return;
            	}

            	if(!this.form.custom_field_type)
            	{
            		Swal("failed!","Please select Custom Field Type","warning");
            		return;
            	}
            	var custom_field_id="custom_field_"+this.form.custom_field_index;
            	this.form.custom_field.push({

            		id:'',
            		field_name:this.form.custom_field_name,
            		field_id:custom_field_id,
            		field_type:this.form.custom_field_type,
            		field_model:'',
            	});

            	this.form.custom_field_name='';
            	this.form.custom_field_type='';
            	this.form.custom_field_index+=1;



            },

            modelClose(){
            	$("#exampleModal").modal("hide"); 
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
            
	        fetchCustomerProfile()
            {
                let uri = '/CustomerPropertys';
                window.axios.get(uri).then((response) => {
                	

                	this.countries 								=response.data.country_arr;
                	this.account_status_arr						=response.data.account_status_arr;
                	this.payment_term_arr						=response.data.payment_term_arr;
                	this.currency_arr							=response.data.currency_arr;
                    this.key_position_lavel                     =response.data.key_position_lavel_arr;

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
            
				alert(this.form.contact_person_data[1].office_phone);return;
		        this.form.put('/AccountSetups/'+this.form.id)
				    .then(()=>{
					       //success
					     
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchCustomerProfile();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createCompanyProfile()
            {

            	//alert(this.form.contact_person_data[1].office_phone);return;
            	
        	    this.form.post('/AccountSetups') .then(({ data }) => { 
               
					
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchCustomerProfile();
        	    })
            }
	    }
    
    }  
	
</script>