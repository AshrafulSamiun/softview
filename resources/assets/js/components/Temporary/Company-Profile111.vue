<template>

	<div class="row" style="">
		<div class="col-md-6 col-sm-6 offset-md-3" >
			<div class="card card-default widget wow fadeInDown animated " style="margin-top:50px; animation-delay: 0.18s;">
				<div class="card-heading">
					<div>
						<div align="left" style="float:left">
							<h2>Company Profile</h2>
						</div>

				
					</div>

				</div>




				<div class="card-body">
					<form @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">

						<table class="table-borderless" width="500" align="left">
							
							<tbody>
						       	<tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Strata Management</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="strata_management" 
												id="strata_management"
												v-model="form.strata_management" >
											<label for="strata_management"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Co-op Property</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="coop_property" 
												id="coop_property"
												v-model="form.coop_property" >
											<label for="coop_property"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Freehold Management</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="free_hold_management" 
												id="free_hold_management"
												v-model="form.free_hold_management" >
											<label for="free_hold_management"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                   <strong> Leasehold Management</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="leasehold_management" 
												id="leasehold_management"
												v-model="form.leasehold_management" >
											<label for="leasehold_management"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                   <strong> Property Management Service Provider</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="property_management" 
												id="property_management"
												v-model="form.property_management" >
											<label for="property_management"></label>
										</div>
                                  	</td>
                                </tr>
						    	<tr>
						    		<td>
						            	<div class="form-lebel" align="left">
						                    <strong>Legal Name</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.legal_name" 
												type="text" 
												name="legal_name" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('legal_name') }"/>
											      <has-error :form="form" field="legal_name"></has-error>
												  <input v-model="form.id" type="hidden" name="id">
										</div>
                                  	</td>
                                </tr>
                                <tr>
							   		<td >
							   			<div class="form-lebel" >
							   				Company Logo
							   			</div>
							   		</td>
							   		<td>
						              
							   			<div class="form-group">
											<button 
											class="btn btn-info fullpwidth" 
											@click.prevent="addCompanylogo()">Browse</button>
						                </div>
						    		</td>
							   	</tr>
                                <tr bgcolor="#0070C0" >
	                              <td colspan="3" style="color:#fff; font-size: 24px;" align="center"><strong>Business Registration</strong></td>
	                            </tr>
            			    	<tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Number</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.business_registration_number" 
												type="text" 
												name="business_registration_number" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('business_registration_number') }"/>
											     <has-error :form="form" field="business_registration_number"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left">
						                    <strong>Date</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
						              
						                     <date-picker 
						                     	v-model="form.registration_date"
						                     	name="registration_date"
						                     	lang="en"
						                     	type="registration_date"
						                     	format="DD-MM-YYYY"
						                     	:class="{ 'is-invalid': form.errors.has('registration_date') }"></date-picker>
										      <has-error :form="form" field="registration_date"></has-error>
						                </div>
                                  	</td>
                                </tr>
                                <tr bgcolor="#F1F1F1" >
	                              <td colspan="2" style="color:#fff; font-size: 24px;" align="center"><strong>Location</strong></td>
	                            </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>City</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.business_registration_city" 
												type="text" 
												name="business_registration_city" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('business_registration_city') }"/>
											     <has-error :form="form" field="business_registration_city"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>State</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.business_registration_state" 
												type="text" 
												name="business_registration_state" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('business_registration_state') }"/>
											     <has-error :form="form" field="business_registration_state"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Country</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">

					                        <select v-model="form.registration_country"  name="registration_country"class="form-control" :class="{ 'is-invalid': form.errors.has('registration_country') }">
										        	<option disabled value="">--Select-- </option>
												  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
										  	</select>
					                    </div>
                                  	</td>
                                </tr>
                                <tr bgcolor="#0070C0" >
	                              <td colspan="3" style="color:#fff; font-size: 24px;" align="center"><strong>Municipal Business License</strong></td>
	                            </tr>
	                            <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>No</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.business_license_no" 
												type="text" 
												name="business_license_no" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('business_license_no') }"/>
											     <has-error :form="form" field="business_license_no"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Issued by</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.issued_by" 
												type="text" 
												name="issued_by" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('issued_by') }"/>
											     <has-error :form="form" field="issued_by"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Country</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">

					                        <select v-model="form.license_country"  name="license_country" class="form-control" :class="{ 'is-invalid': form.errors.has('license_country') }">
										        	<option disabled value="">--Select-- </option>
												  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
										  	</select>
					                    </div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left">
						                    <strong>Expiry Date</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
						              
						                     <date-picker 
						                     	v-model="form.expirey_date"
						                     	name="expirey_date"
						                     	lang="en"
						                     	type="expirey_date"
						                     	format="DD-MM-YYYY"
						                     	:class="{ 'is-invalid': form.errors.has('expirey_date') }"></date-picker>
										      <has-error :form="form" field="expirey_date"></has-error>
						                </div>
                                  	</td>
                                </tr>
                                <tr bgcolor="#0070C0" >
	                              <td colspan="3" style="color:#fff; font-size: 24px;" align="center"><strong>Head Office Address</strong></td>
	                            </tr>
	                             <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Email</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.head_office_email" 
												type="email" 
												name="head_office_email" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('head_office_email') }"/>
											     <has-error :form="form" field="head_office_email"></has-error>
										</div>
                                  	</td>
                                </tr>
                                 <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Fax</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.head_office_fax_no" 
												type="text" 
												name="head_office_fax_no" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('head_office_fax_no') }"/>
											     <has-error :form="form" field="head_office_fax_no"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Phone</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.head_office_cell_phone" 
												type="text" 
												name="head_office_cell_phone" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('head_office_cell_phone') }"/>
											     <has-error :form="form" field="head_office_cell_phone"></has-error>
										</div>
                                  	</td>
                                </tr>
                                 <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Website</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.head_office_website" 
												type="url" 
												name="head_office_website" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('head_office_website') }"/>
											     <has-error :form="form" field="head_office_website"></has-error>
										</div>
                                  	</td>
                                </tr>
	                            <tr bgcolor="#0070C0" >
	                              <td colspan="3" style="color:#fff; font-size: 24px;" align="center"><strong>Contact</strong></td>
	                            </tr>
	                            <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Email</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.contact_person_email" 
												type="email" 
												name="contact_person_email" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('contact_person_email') }"/>
											     <has-error :form="form" field="contact_person_email"></has-error>
										</div>
                                  	</td>
                                </tr>
                                 <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Fax</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.contact_person_fax_no" 
												type="text" 
												name="contact_person_fax_no" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('contact_person_fax_no') }"/>
											     <has-error :form="form" field="contact_person_fax_no"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Phone</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.contact_person_cell_phone" 
												type="text" 
												name="contact_person_cell_phone" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('contact_person_cell_phone') }"/>
											     <has-error :form="form" field="contact_person_cell_phone"></has-error>
										</div>
                                  	</td>
                                </tr>
                                 <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Website</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.contact_person_website" 
												type="url" 
												name="contact_person_website" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('contact_person_website') }"/>
											     <has-error :form="form" field="contact_person_website"></has-error>
										</div>
                                  	</td>
                                </tr>
	                            <tr bgcolor="#0070C0" >
	                              <td colspan="3" style="color:#fff; font-size: 24px;" align="center"><strong>Tax Office Accounts</strong></td>
	                            </tr>
	                            <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>business Number</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.business_number" 
												type="text" 
												name="business_number" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('business_number') }"/>
											     <has-error :form="form" field="business_number"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Employer Identification Number (EIN)</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.emp_identification_number" 
												type="text" 
												name="emp_identification_number" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('emp_identification_number') }"/>
											     <has-error :form="form" field="emp_identification_number"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Payroll</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.payroll" 
												type="text" 
												name="payroll" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('payroll') }"/>
											     <has-error :form="form" field="payroll"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Payroll</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.payroll" 
												type="text" 
												name="payroll" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('payroll') }"/>
											     <has-error :form="form" field="payroll"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Sales Tax</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.sales_tax" 
												type="text" 
												name="sales_tax" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('sales_tax') }"/>
											     <has-error :form="form" field="sales_tax"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Income Tax</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.income_tax" 
												type="text" 
												name="income_tax" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('income_tax') }"/>
											     <has-error :form="form" field="income_tax"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Import and Export </strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.import_and_export" 
												type="text" 
												name="import_and_export" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('import_and_export') }"/>
											     <has-error :form="form" field="import_and_export"></has-error>
										</div>
                                  	</td>
                                </tr>



                                <tr bgcolor="#0070C0" >
	                              <td colspan="3" style="color:#fff; font-size: 24px;" align="center"><strong>Tax Office Accounts</strong></td>
	                            </tr>
	                            <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>business Number</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.business_number" 
												type="text" 
												name="business_number" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('business_number') }"/>
											     <has-error :form="form" field="business_number"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Employer Identification Number (EIN)</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.emp_identification_number" 
												type="text" 
												name="emp_identification_number" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('emp_identification_number') }"/>
											     <has-error :form="form" field="emp_identification_number"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Payroll</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.payroll" 
												type="text" 
												name="payroll" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('payroll') }"/>
											     <has-error :form="form" field="payroll"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Payroll</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.payroll" 
												type="text" 
												name="payroll" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('payroll') }"/>
											     <has-error :form="form" field="payroll"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Sales Tax</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.sales_tax" 
												type="text" 
												name="sales_tax" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('sales_tax') }"/>
											     <has-error :form="form" field="sales_tax"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Income Tax</strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.income_tax" 
												type="text" 
												name="income_tax" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('income_tax') }"/>
											     <has-error :form="form" field="income_tax"></has-error>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="left" style="padding-left:">
						                    <strong>Import and Export </strong>
						                </div>
						            </td>
						            <td>
										<div class="form-group">
											
											<input v-model="form.import_and_export" 
												type="text" 
												name="import_and_export" 
												class="form-control" 
												:class="{ 'is-invalid': form.errors.has('import_and_export') }"/>
											     <has-error :form="form" field="import_and_export"></has-error>
										</div>
                                  	</td>
                                </tr>


                                <--! Type of property !-->
                                <tr bgcolor="#0070C0" >
	                              <td colspan="3" style="color:#fff; font-size: 24px;" align="center"><strong>Property Type(S)</strong></td>
	                            </tr>
	                            <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong> Residential Suite</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="dependent_residential_suite" 
												id="dependent_residential_suite"
												v-model="form.dependent_residential_suite" >
											<label for="dependent_residential_suite"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Parking Lot</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="dependent_residental_parking_lot" 
												id="dependent_residental_parking_lot"
												v-model="form.dependent_residental_parking_lot" >
											<label for="dependent_residental_parking_lot"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Storage Lot</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="dependent_residental_storage_lot" 
												id="dependent_residental_storage_lot"
												v-model="form.dependent_residental_storage_lot" >
											<label for="dependent_residental_storage_lot"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong> Commercial Unit</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="dependent_commercial_unit" 
												id="dependent_commercial_unit"
												v-model="form.dependent_commercial_unit" >
											<label for="dependent_commercial_unit"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Parking Lot</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="dependent_commercial_parking_lot" 
												id="dependent_commercial_parking_lot"
												v-model="form.dependent_commercial_parking_lot" >
											<label for="dependent_commercial_parking_lot"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Storage Lot</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="dependent_commercial_storage_lot" 
												id="dependent_commercial_storage_lot"
												v-model="form.dependent_commercial_storage_lot" >
											<label for="dependent_commercial_storage_lot"></label>
										</div>
                                  	</td>
                                </tr>


                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong> Residential Suite</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="independent_residential_suite" 
												id="independent_residential_suite"
												v-model="form.independent_residential_suite" >
											<label for="independent_residential_suite"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Parking Lot</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="independent_residental_parking_lot" 
												id="independent_residental_parking_lot"
												v-model="form.independent_residental_parking_lot" >
											<label for="independent_residental_parking_lot"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Storage Lot</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="independent_residental_storage_lot" 
												id="independent_residental_storage_lot"
												v-model="form.independent_residental_storage_lot" >
											<label for="independent_residental_storage_lot"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong> Commercial Unit</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="independent_commercial_unit" 
												id="independent_commercial_unit"
												v-model="form.independent_commercial_unit" >
											<label for="independent_commercial_unit"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Parking Lot</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="independent_commercial_parking_lot" 
												id="independent_commercial_parking_lot"
												v-model="form.independent_commercial_parking_lot" >
											<label for="independent_commercial_parking_lot"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Storage Lot</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="independent_commercial_storage_lot" 
												id="independent_commercial_storage_lot"
												v-model="form.independent_commercial_storage_lot" >
											<label for="independent_commercial_storage_lot"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr bgcolor="#0070C0" >
	                              <td colspan="3" style="color:#fff; font-size: 24px;" align="center"><strong>Type of Operation</strong></td>
	                            </tr>
	                            <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong> Rental Suites and Units</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="rantal_suite_unit" 
												id="rantal_suite_unit"
												v-model="form.rantal_suite_unit" >
											<label for="rantal_suite_unit"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Buy and Sale Suits and Units</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="buy_and_sell_suite_unit" 
												id="buy_and_sell_suite_unit"
												v-model="form.buy_and_sell_suite_unit" >
											<label for="buy_and_sell_suite_unit"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Rental Parking</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="rental_parking" 
												id="rental_parking"
												v-model="form.rental_parking" >
											<label for="rental_parking"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong> Rental Storage</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="rental_storage" 
												id="rental_storage"
												v-model="form.rental_storage" >
											<label for="rental_storage"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
						    		<td>
						            	<div class="form-lebel" align="right">
						                    <strong>Landlord / Landholders Residency</strong>
						                </div>
						            </td>
						            <td>
										<div  class="icheck-primary d-inline ml-2">
											<input type="checkbox" value="0" 
												name="landholders_residency" 
												id="landholders_residency"
												v-model="form.landholders_residency" >
											<label for="landholders_residency"></label>
										</div>
                                  	</td>
                                </tr>
                                <tr>
					        		<td>
					        		

				                       	<div class="form-group">
					                        <button :disabled="form.busy" v-show="!editmode" type="submit" class="btn btn-primary">Save</button>
									      	<button :disabled="form.busy" v-show="editmode" type="submit" class="btn btn-primary">Update</button>
									      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					                    </div>

					        		</td>
					        	</tr>

							</tbody>
					   	</table>

					  
					</form>
				</div>  
			</div>
		</div>
    </div>	

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
                  	license_country:'',
                  	expirey_date:'',
                  	head_office_email:'',
                  	head_office_fax_no:'',
                  	head_office_cell_phone:'',
                  	head_office_website:'',


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

                  	dependent_residential_suite:'',
                  	dependent_residental_parking_lot:'',
                  	dependent_residental_storage_lot:'',
                  	dependent_commercial_unit:'',
                  	dependent_commercial_parking_lot:'',

                  	dependent_commercial_storage_lot:'',
                  	independent_residential_suite:'',
                  	independent_residental_parking_lot:'',
                  	independent_residental_storage_lot:'',
                  	independent_commercial_unit:'',
                  	independent_commercial_parking_lot:'',
                  	independent_commercial_storage_lot:'',


                  	rantal_suite_unit:'',
                  	buy_and_sell_suite_unit:'',
                  	rental_parking:'',
                  	rental_storage:'',
                  	landholders_residency:'',


            	}),

            	countries:'',
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchCompanyProfile();
           
        },
		
	    methods: {

	    	
            
	        fetchCompanyProfile()
            {
                let uri = '/AccountSetups';
                window.axios.get(uri).then((response) => {
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
					this.fetchCompanyProfile();
        	    })
            }
	    }
    
    }  
	
</script>