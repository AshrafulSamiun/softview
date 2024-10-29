<template>
	<form @submit.prevent="editmode ? updateCustomer() : createCustomer()" @keydown="form.onKeydown($event)">
		<div class="row">
	      	<div class="col-md-12 col-sm-12" >
		        <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">

					<div class="card-heading">
					</div>
					<div class="card-body">
						<fieldset >
						 	<legend style="width:200px;">User Information</legend>
							<table width="100%" class="">
							
								<tbody>
									<tr >
							    		<td colspan="3">
							            	<div class="form-lebel" align="right">
							                    ID:
							                </div>
							            </td>
							            <td >
							                <div class="form-group">
							                    <input v-model="form.id" type="text" name="id" class="form-control" :class="{ 'is-invalid': form.errors.has('id') }" disabled>
							                </div>
							    		</td>
							    		<td></td>
							    		<td></td>
							       	</tr>
							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    First Name:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.first_name" type="text" name="first_name" class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }">
											    <has-error :form="form" field="first_name"></has-error>
							                </div>
							    		</td>

							    		<td>
							            	<div class="form-lebel" align="right">
							                    Middle Name:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.middle_name" type="text" name="middle_name" class="form-control" :class="{ 'is-invalid': form.errors.has('middle_name') }">
											    <has-error :form="form" field="middle_name"></has-error>
							                </div>
							    		</td>
							    	
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Last Name:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.last_name" type="text" name="last_name" class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }">
											    <has-error :form="form" field="last_name"></has-error>
							                </div>
							    		</td>

							    	</tr>
							        <tr>	
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Nick Name:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.nick_name" type="text" name="nick_name" class="form-control" :class="{ 'is-invalid': form.errors.has('nick_name') }">
											    <has-error :form="form" field="nick_name"></has-error>
							                </div>
							    		</td>
							      
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Website:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.website" type="url" name="website" class="form-control" :class="{ 'is-invalid': form.errors.has('website') }" placeholder="https://www.example.com">
											    <has-error :form="form" field="website"></has-error>
							                </div>
							    		</td>

							    		<td>
							            	<div class="form-lebel" align="right">
							                    Office Phone:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.office_phone" type="text" name="office_phone" class="form-control" :class="{ 'is-invalid': form.errors.has('office_phone') }">
											    <has-error :form="form" field="office_phone"></has-error>
							                </div>
							    		</td>
							    	</tr>

							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Cell Phone:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.cell_phone" type="text" name="cell_phone" class="form-control" :class="{ 'is-invalid': form.errors.has('cell_phone') }">
											    <has-error :form="form" field="cell_phone"></has-error>
							                </div>
							    		</td>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Home Phone:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.home_phone" type="text" name="home_phone" class="form-control" :class="{ 'is-invalid': form.errors.has('home_phone') }">
											    <has-error :form="form" field="home_phone"></has-error>
							                </div>
							    		</td>
							        
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Official Email:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.official_email" type="text" name="official_email" class="form-control" :class="{ 'is-invalid': form.errors.has('official_email') }">
											    <has-error :form="form" field="official_email"></has-error>
							                </div>
							    		</td>
							    	</tr>

							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Recovery Email:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.recovery_email" type="text" name="recovery_email" class="form-control" :class="{ 'is-invalid': form.errors.has('recovery_email') }">
											    <has-error :form="form" field="recovery_email"></has-error>
							                </div>
							    		</td>

							    		<td>
							            	<div class="form-lebel" align="right">
							                    User Type:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">

												<select v-model="form.user_type"
							                      	name="user_type" 
							                      	id="user_type"
							                      	class="form-control" :class="{ 'is-invalid': form.errors.has('user_type') }">
											        	<option  value="">--Select User Type-- </option>
													  	<option v-for="(user_type,index) in user_type_arr" :value="index">{{user_type}}</option>
											  	</select>
											 </div>
							    		</td>

							    		<td>
							            	<div class="form-lebel" align="right">
							                    Photo:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_user_photo()" 
													class="btn btn-primary btn-block">Upload Photo</button>
							                </div>
							    		</td>
							    	</tr>
							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Local Driving License:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_user_driving_license()" 
													class="btn btn-primary btn-block">Upload License</button>
							                </div>
							    		</td>
							    	
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Govt. ID:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_govt_id()" 
													class="btn btn-primary btn-block">Upload ID</button>
							                </div>
							    		</td>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Passport:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_user_driving_license()" 
													class="btn btn-primary btn-block">Upload Passport</button>
							                </div>
							    		</td>
							    	</tr>

							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Logo:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_user_logo()" 
													class="btn btn-primary btn-block">Upload Logo</button>
							                </div>
							    		</td>
							    	</tr>
		
								</tbody>
						    </table>
						    <fieldset >
							 	<legend style="width:400px;">Address</legend>
								<table width="100%"  class="table table-hover table-striped" align="center">
									<thead>
										<tr>
											<th rowspan="2"  style="vertical-align:middle; text-align:center">Particular</th>
											<th  style=" text-align:center">Home</th>
											<th  style="vertical-align:middle; text-align:center">Mailing</th>
											<th  style="vertical-align:middle; text-align:center">Billing</th>
										</tr>
										
									</thead>
									<tbody>
										<tr>
									   		<td  >
									   			<div class="form-lebel"  >
									   				Country
									   			</div>
									   		</td>
									   	
									   		<td>
								                <div class="form-group">
													<select v-model="form.country_id"
								                      	name="country_id" 
								                      	id="country_id"
								                      	class="form-control" :class="{ 'is-invalid': form.errors.has('country_id') }">
												        	<option  value="">--Select Country-- </option>
														  	<option v-for="(country,index) in country_arr" :value="index">{{country}}</option>
												  	</select>

								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<select v-model="form.mailing_country_id"
								                      	name="mailing_country_id" 
								                      	id="mailing_country_id"
								                      	class="form-control" :class="{ 'is-invalid': form.errors.has('mailing_country_id') }">
												        	<option  value="">--Select Country-- </option>
														  	<option v-for="(country,index) in country_arr" :value="index">{{country}}</option>
												  	</select>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<select v-model="form.billing_country_id"
								                      	name="billing_country_id" 
								                      	id="billing_country_id"
								                      	class="form-control" :class="{ 'is-invalid': form.errors.has('billing_country_id') }">
												        	<option  value="">--Select Country-- </option>
														  	<option v-for="(country,index) in country_arr" :value="index">{{country}}</option>
												  	</select>
								                </div>
								    		</td>
								    	
									   	</tr>
									   	<tr>
									   		<td  >
									   			<div class="form-lebel"  >
									   				State
									   			</div>
									   		</td>
									   	
									   		<td>
								                <div class="form-group">
													<input
														v-model="form.state" 
														type="text" 
														name="state" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('state') }">

											    	<has-error :form="form" field="state"></has-error>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.mailing_state" 
														type="text" 
														name="mailing_state" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('mailing_state') }">

											    	<has-error :form="form" field="mailing_state"></has-error>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.billing_state" 
														type="text" 
														name="billing_state" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('billing_state') }">

											    	<has-error :form="form" field="billing_state"></has-error>
								                </div>
								    		</td>
								    		
									   	</tr>
									   	<tr>
									   		<td>
									   			<div class="form-lebel"  >
									   				City
									   			</div>
									   		</td>
									   	
									   		<td>
								                <div class="form-group">
													<input
														v-model="form.city" 
														type="text" 
														name="city" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('city') }">

											    	<has-error :form="form" field="city"></has-error>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.mailing_city" 
														type="text" 
														name="mailing_city" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('mailing_city') }">

											    	<has-error :form="form" field="mailing_city"></has-error>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.billing_city" 
														type="text" 
														name="billing_city" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('billing_city') }">

											    	<has-error :form="form" field="billing_city"></has-error>
								                </div>
								    		</td>
								    		
									   	</tr>
									   	<tr>
									   		<td  >
									   			<div class="form-lebel"  >
									   				Street No
									   			</div>
									   		</td>
									   	
									   		<td>
								                <div class="form-group">
													<input
														v-model="form.street" 
														type="text" 
														name="street" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('street') }">

											    	<has-error :form="form" field="street"></has-error>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.mailing_street" 
														type="text" 
														name="mailing_street" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('mailing_street') }">

											    	<has-error :form="form" field="mailing_street"></has-error>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.billing_street" 
														type="text" 
														name="billing_street" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('billing_street') }">

											    	<has-error :form="form" field="billing_street"></has-error>
								                </div>
								    		</td>
									   	</tr>
									   	<tr>
									   		<td  >
									   			<div class="form-lebel"  >
									   				Postal Code 
									   			</div>
									   		</td>
									   	
									   		<td>
								                <div class="form-group">
													<input
														v-model="form.postal_code" 
														type="text" 
														name="postal_code" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('postal_code') }">

											    	<has-error :form="form" field="postal_code"></has-error>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.mailing_postal_code" 
														type="text" 
														name="mailing_postal_code" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('mailing_postal_code') }">

											    	<has-error :form="form" field="mailing_postal_code"></has-error>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.billing_postal_code" 
														type="text" 
														name="billing_postal_code" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('billing_postal_code') }">

											    	<has-error :form="form" field="billing_postal_code"></has-error>
								                </div>
								    		</td>
									   	</tr>
									   
									</tbody>
									
							   </table>
							</fieldset>
						</fieldset>

						<br>
						<fieldset >
						 	<legend style="width:200px;">Company Information</legend>
							<table width="100%" class="">
							
								<tbody>
								
							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Legal Name:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
											    <has-error :form="form" field="legal_name"></has-error>
							                </div>
							    		</td>

							    		<td>
							            	<div class="form-lebel" align="right">
							                    Operational Name:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
											    <has-error :form="form" field="operational_name"></has-error>
							                </div>
							    		</td>
							    	
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Buisness Type:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<select v-model="form.buisness_type"
													name="buisness_type" 
													id="buisness_type"
													class="form-control" :class="{ 'is-invalid': form.errors.has('buisness_type') }">
													<option disabled value="">--Select Business Type-- </option>
													<option value="1">Sole</option>
													<option value="2">Paatnership</option>
													<option value="3">Corporation</option>
										  		</select>
							                </div>
							    		</td>
							    	</tr>
							        <tr>	
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Service Type:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<select v-model="form.buisness_type"
													name="buisness_type" 
													id="buisness_type"
													class="form-control" :class="{ 'is-invalid': form.errors.has('buisness_type') }">
													<option disabled value="">--Select Service Type-- </option>
													<option value="1">Manufacturing</option>
													<option value="2">Trading</option>
													<option value="3">Service</option>
													<option value="2">Educational</option>
													<option value="3">Social Welfare</option>
										  		</select>
							                </div>
							    		</td>
							      
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Address:
							                </div>
							            </td>
							    		<td colspan="3">
							                <div class="form-group">
												<input v-model="form.company_address" type="text" name="company_address" class="form-control" :class="{ 'is-invalid': form.errors.has('company_address') }" >
											    <has-error :form="form" field="company_address"></has-error>
							                </div>
							    		</td>
									</tr>

							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Landlord Name:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.landlord_name" type="text" name="landlord_name" class="form-control" :class="{ 'is-invalid': form.errors.has('landlord_name') }">
											    <has-error :form="form" field="landlord_name"></has-error>
							                </div>
							    		</td>
							    	

							    		<td>
							            	<div class="form-lebel" align="right">
							                    Office Phone:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.company_office_phone" type="text" name="company_office_phone" class="form-control" :class="{ 'is-invalid': form.errors.has('company_office_phone') }">
											    <has-error :form="form" field="company_office_phone"></has-error>
							                </div>
							    		</td>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Cell Phone:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.company_cell_phone" type="text" name="company_cell_phone" class="form-control" :class="{ 'is-invalid': form.errors.has('company_cell_phone') }">
											    <has-error :form="form" field="company_cell_phone"></has-error>
							                </div>
							    		</td>
							    	
							    	</tr>

							    	<tr>
							        
							    		<td>
							            	<div class="form-lebel" align="right">
							                     Email:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.company_email" type="text" name="company_email" class="form-control" :class="{ 'is-invalid': form.errors.has('company_email') }">
											    <has-error :form="form" field="company_email"></has-error>
							                </div>
							    		</td>
							    	
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Website:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.website" type="url" name="website" class="form-control" :class="{ 'is-invalid': form.errors.has('website') }" placeholder="https://www.example.com">
											    <has-error :form="form" field="website"></has-error>
							                </div>
							    		</td>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Govt. Buisness Registration:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.buisness_registration_on" type="text" name="buisness_registration_on" class="form-control" :class="{ 'is-invalid': form.errors.has('buisness_registration_on') }">
											    <has-error :form="form" field="buisness_registration_on"></has-error>
							                </div>
							    		</td>
							    	</tr>

							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Related Association:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.related_association" type="text" name="related_association" class="form-control" :class="{ 'is-invalid': form.errors.has('related_association') }" >
											    <has-error :form="form" field="related_association"></has-error>
							                </div>
							    		</td>
							        
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Status:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<select v-model="form.status_active"
													name="status_active" 
													id="status_active"
													class="form-control" :class="{ 'is-invalid': form.errors.has('status_active') }">
													<option disabled value="">--Select-- </option>
													<option value="1">Active</option>
													<option value="2">In-Active</option>
													<option value="3">Cencell</option>
										  		</select>
							                </div>
							    		</td>
							    	</tr>
							    	
		
								</tbody>
						   </table>
						</fieldset>
						<br/>
						<fieldset >
						 	<legend style="width:400px;">Landlord family members like Wife, brother, sister</legend>
							<table width="100%" class="">
							
								<tbody>
								
							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Legal Name:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.fm_legal_name" type="text" name="fm_legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('fm_legal_name') }">
											    <has-error :form="form" field="fm_legal_name"></has-error>
							                </div>
							    		</td>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Address:
							                </div>
							            </td>
							    		<td colspan="3">
							                <div class="form-group">
												<input v-model="form.company_address" type="text" name="company_address" class="form-control" :class="{ 'is-invalid': form.errors.has('company_address') }" >
											    <has-error :form="form" field="company_address"></has-error>
							                </div>
							    		</td>
							    	</tr>

							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Relation With Landlord:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.relation_with_landlord" type="text" name="relation_with_landlord" class="form-control" :class="{ 'is-invalid': form.errors.has('relation_with_landlord') }">
											    <has-error :form="form" field="relation_with_landlord"></has-error>
							                </div>
							    		</td>
							    	
							    		

							    		<td>
							            	<div class="form-lebel" align="right">
							                    Work Phone:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.fm_office_phone" type="text" name="fm_office_phone" class="form-control" :class="{ 'is-invalid': form.errors.has('fm_office_phone') }">
											    <has-error :form="form" field="company_office_phone"></has-error>
							                </div>
							    		</td>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Cell Phone:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.fm_cell_phone" type="text" name="fm_cell_phone" class="form-control" :class="{ 'is-invalid': form.errors.has('fm_cell_phone') }">
											    <has-error :form="form" field="fm_cell_phone"></has-error>
							                </div>
							    		</td>
							    	
							    	</tr>

							    	<tr>
							        
							    		<td>
							            	<div class="form-lebel" align="right">
							                     Email:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.fm_email" type="text" name="fm_email" class="form-control" :class="{ 'is-invalid': form.errors.has('fm_email') }">
											    <has-error :form="form" field="fm_email"></has-error>
							                </div>
							    		</td>
							    	
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Photo:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_fm_photo()" 
													class="btn btn-primary btn-block">Upload Photo</button>
							                </div>
							    		</td>
							    	
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Govt. ID Front Part:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_fm_govt_id_front_part()" 
													class="btn btn-primary btn-block">Upload ID</button>
							                </div>
							    		</td>
							    	</tr>
							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Govt. ID Back Part:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_fm_govt_id_back_part()" 
													class="btn btn-primary btn-block">Upload ID</button>
							                </div>
							    		</td>
							    
							    	</tr>

							    	<tr>
							    		<td colspan="6"  style="width:100% ;border-bottom:2px solid black; margin-bottom:10px; 0 "></td>
							    	</tr>


							    	<tr>
							    		
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Company Name:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.fm_company_name" type="text" name="fm_company_name" class="form-control" :class="{ 'is-invalid': form.errors.has('fm_company_name') }" >
											    <has-error :form="form" field="fm_company_name"></has-error>
							                </div>
							    		</td>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Company Phone:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.fm_company_phone" type="text" name="fm_company_phone" class="form-control" :class="{ 'is-invalid': form.errors.has('fm_company_phone') }">
											    <has-error :form="form" field="fm_company_phone"></has-error>
							                </div>
							    		</td>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Business Address:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.business_address" type="text" name="business_address" class="form-control" :class="{ 'is-invalid': form.errors.has('business_address') }">
											    <has-error :form="form" field="business_address"></has-error>
							                </div>
							    		</td>
							    	</tr>
							    	<tr>
							    		
							    		
							    		<td>
							            	<div class="form-lebel" align="right">
							                    BN No:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.fm_bn_no" type="text" name="fm_bn_no" class="form-control" :class="{ 'is-invalid': form.errors.has('fm_bn_no') }">
											    <has-error :form="form" field="fm_bn_no"></has-error>
							                </div>
							    		</td>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Website:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.fm_website" type="url" name="fm_website" class="form-control" :class="{ 'is-invalid': form.errors.has('fm_website') }" placeholder="https://www.example.com">
											    <has-error :form="form" field="fm_website"></has-error>
							                </div>
							    		</td>
							    	</tr>
		
								</tbody>
						   </table>
						</fieldset>
						<br/>
						<fieldset >
						 	<legend style="width:200px;">Vehicle information</legend>
							<table width="100%" class="">
							
								<tbody>
								
							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Make & Model:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<input v-model="form.make_n_model" type="text" name="make_n_model" class="form-control" :class="{ 'is-invalid': form.errors.has('make_n_model') }">
											    <has-error :form="form" field="make_n_model"></has-error>
							                </div>
							    		</td>

							    		<td>
							            	<div class="form-lebel" align="right">
							                    VIN No:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.vin_no" type="text" name="vin_no" class="form-control" :class="{ 'is-invalid': form.errors.has('vin_no') }">
											    <has-error :form="form" field="vin_no"></has-error>
							                </div>
							    		</td>
							    	
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Model Year:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
												<select v-model="form.model_year"
													name="model_year" 
													id="model_year"
													class="form-control" :class="{ 'is-invalid': form.errors.has('model_year') }">
													<option disabled value="">--Select Model Year-- </option>
													<option v-for="(year,index) in year_arr" :value="index">{{year}}</option>
										  		</select>
							                </div>
							    		</td>
							    	</tr>

							        <tr>	
							    		
							      
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Color:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.vihicle_color" type="text" name="vihicle_color" class="form-control" :class="{ 'is-invalid': form.errors.has('vihicle_color') }" >
											    <has-error :form="form" field="vihicle_color"></has-error>
							                </div>
							    		</td>

							    		<td>
							            	<div class="form-lebel" align="right">
							                    Plate No:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.vihicle_plate_no" type="text" name="vihicle_plate_no" class="form-control" :class="{ 'is-invalid': form.errors.has('vihicle_plate_no') }">
											    <has-error :form="form" field="vihicle_plate_no"></has-error>
							                </div>
							    		</td>
							    	

							    		
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Insurance Exp. Date:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">
											    <date-picker 
							                     	v-model="form.vihicle_ins_exp_date"
							                     	name="vihicle_ins_exp_date"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="From Date" 
							                     	format="YYYY-MM-DD"></date-picker>
							                </div>
							    		</td>
							    	</tr>

							    	

							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Insurence Copy:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
							                	<input v-model="form.vihicle_ins_copy_id" type="hidden" name="vihicle_ins_copy_id" >

												<button 
													type="button"
													@click.prevent="upload_vihicle_insurance_copy()" 
													class="btn btn-primary btn-block">Upload Insurance Cpoy</button>
							                </div>
							    		</td>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Driving License #:
							                </div>
							            </td>
							            <td>
							                <div class="form-group">

							                	<input v-model="form.vihicle_driving_license_id" type="hidden" name="vihicle_driving_license_id" >

												<button 
													type="button"
													@click.prevent="upload_vihicle_driving_license()" 
													class="btn btn-primary btn-block">Upload License</button>
							                </div>
							    		</td>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Front Part Photos:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												<input v-model="form.vihicle_front_part_id" type="hidden" name="vihicle_front_part_id" >
												<button 
													type="button"
													@click.prevent="upload_vihicle_fontpart_id()" 
													class="btn btn-primary btn-block">Upload Font Part</button>
							                </div>
							    		</td>
							    		
							    		
							        
							    		
							    	</tr>

							    	

							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Back Part Photos:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												
											    <input v-model="form.vihicle_back_part_id" type="hidden" name="vihicle_back_part_id" >
												<button 
													type="button"
													@click.prevent="upload_vihicle_backpart_id()" 
													class="btn btn-primary btn-block">Upload Back Part</button>
							                </div>
							    		</td>
							    	
							    	
							        
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Left Part Photos:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
											    <input v-model="form.vihicle_left_part_id" type="hidden" name="vihicle_left_part_id" >
												<button 
													type="button"
													@click.prevent="upload_vihicle_leftpart_id()" 
													class="btn btn-primary btn-block">Upload Left Part</button>
							                </div>
							    		</td>
							    		
							    		<td>
							            	<div class="form-lebel" align="right">
							                    Right Part Photos:
							                </div>
							            </td>
							    		<td>
							                <div class="form-group">
												
											    <input v-model="form.vihicle_right_part_id" type="hidden" name="vihicle_right_part_id" >
												<button 
													type="button"
													@click.prevent="upload_vihicle_rightpart_id()" 
													class="btn btn-primary btn-block">Upload Right Part</button>
							                </div>
							    		</td>
							    	</tr>
							    	<tr>
							    		<td>
							            	<div class="form-lebel" align="right">
							                   
							                </div>
							            </td>
							    		<td >
											<button 
												class="btn btn-info fullpwidth" 
												@click.prevent="addVihicle()">Add Vihicle</button>	
										</td>
							    	</tr>
		
								</tbody>
						   </table>

						   <fieldset >
			              		<legend>Vehicle  List</legend>
			               		<table width="100%" class=" ">	               			
			               			<tbody class="text-left">
						              
						               	<tr>
							             
							        		<td>
							                    <div class="pull-right">
													<label for="filter" class="sr-only">Filter</label>
													<input type="text" class="form-control" v-model="filter_vihicle" placeholder="Filter" style="width:400px;">
												</div>
							        		</td>
							        	</tr>							
									</tbody>
			               		</table>

			               		<datatable :columns="vihicle_columns" :data="form.vihicle_info_arr" :filter-by="filter_vihicle">
									<template slot-scope="{row}">
										<tr>
						                    <td>{{ row.sl}}</td>
						                    <td>{{ row.make_n_modle }}</td>
						                    <td>{{ row.vin_no }}</td>
						                    <td>{{ row.model_year }}</td>
						                    <td>{{ row.color }}</td>
						                    <td>{{ row.plate_no }}</td>
						                    <td>
						        
						                    	<button class="btn btn-primary btn-sm" @click.prevent="edit_vihicle_info(row.id)">Edit</button>
						                    	<button class="btn btn-danger btn-sm" @click.prevent="delete_vihicle_info(row.id)">Delete</button>
						                    </td>
						                </tr>
									</template>
								</datatable>
								<datatable-pager v-model="page1" type="abbreviated" :per-page="per_page1"></datatable-pager>	
							</fieldset > 


						</fieldset>
						<br/>
						<fieldset >
						 	<legend style="width:400px;">Permits, License, Insurance</legend>
							<table width="100%"  class="table table-hover table-striped" align="center">
								<thead>
									<tr>
										<th rowspan="2"  style="vertical-align:middle; text-align:center">Particular</th>
										<th colspan="2" style=" text-align:center">Validation Period</th>
										<th rowspan="2" style="vertical-align:middle; text-align:center">Expiry Date</th>
										<th rowspan="2" style="vertical-align:middle; text-align:center">Upload Copy</th>
									</tr>
									<tr>
										<th style=" text-align:center">From</th>
										<th style=" text-align:center">To</th>
									</tr>
								</thead>
								<tbody>
									<tr>
								   		<td  >
								   			<div class="form-lebel"  >
								   				Permit
								   			</div>
								   		</td>
								   	
								   		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.permit_start"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="From Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.permit_end"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="To Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.permit_expire_date"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="Expite Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_permit_photo()" 
													class="btn btn-primary btn-block">Upload Permit</button>
							                </div>
							    		</td>
								   	</tr>
								   	<tr>
								   		<td  >
								   			<div class="form-lebel"  >
								   				License
								   			</div>
								   		</td>
								   	
								   		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.license_start"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="From Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.license_end"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="To Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.license_expire_date"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="Expite Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_license_photo()" 
													class="btn btn-primary btn-block">Upload License</button>
							                </div>
							    		</td>
								   	</tr>
								   	<tr>
								   		<td>
								   			<div class="form-lebel"  >
								   				Liability Insurance
								   			</div>
								   		</td>
								   	
								   		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.liability_start"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="From Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.liability_end"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="To Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.liability_expire_date"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="Expite Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_liability_photo()" 
													class="btn btn-primary btn-block">Upload Liability</br> Insurance</button>
							                </div>
							    		</td>
								   	</tr>
								   	<tr>
								   		<td  >
								   			<div class="form-lebel"  >
								   				Home Insurance 
								   			</div>
								   		</td>
								   	
								   		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.home_insurence_start"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="From Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.home_insurence_end"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="To Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.home_insurence_expire_date"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="Expite Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_home_insurence_photo()" 
													class="btn btn-primary btn-block">Upload Home </br>Insurance</button>
							                </div>
							    		</td>
								   	</tr>
								   	<tr>
								   		<td  >
								   			<div class="form-lebel"  >
								   				Car Insurance
								   			</div>
								   		</td>
								   	
								   		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.car_insurence_start"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="From Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.car_insurence_end"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="To Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.car_insurence_expire_date"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="Expite Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_car_insurence_photo()" 
													class="btn btn-primary btn-block">Upload Car </br>Insurance</button>
							                </div>
							    		</td>
								   	</tr>
								   	<tr>
								   		<td  >
								   			<div class="form-lebel"  >
								   				Criminal background </br>check
								   			</div>
								   		</td>
								   	
								   		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.criminal_back_ground_start"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="From Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.criminal_back_ground_end"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="To Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<date-picker 
							                     	v-model="form.criminal_back_ground_date"
							                     	lang="en"
							                     	type="date"
							                     	style="width:100%;"
							                     	placeholder="Expite Date" 
							                     	format="DD-MM-YYYY"></date-picker>
							                </div>
							    		</td>
							    		<td>
							                <div class="form-group">
												<button 
													type="button"
													@click.prevent="upload_criminal_back_ground_photo()" 
													class="btn btn-primary btn-block">Upload Criminal </br>background check</button>
							                </div>
							    		</td>
								   	</tr>
								</tbody>
								
						   </table>
						</fieldset>
						<br/>
					</div>  
			    </div>

	        	     
	      	</div><!-- /.col-md-12 -->
	    </div>
	</form>
</template>
<style>
	

</style>

<script>
	import Vue from 'vue';
	import DatePicker from 'vue2-datepicker';
	import DatatableFactory from 'vuejs-datatable';	
	Vue.use(DatatableFactory);

	export default {
		components:{
			DatePicker
		},
		data(){
            return{
                filter: '',
                filter_vihicle:'',
                editmode:false,

                form:new Form(
                {
                    customer_name:'',
                    address:'',
                    email:'',
                    phone:'',
                    cell_phone:'',
                    website:'',
                    linkedin_id:'',
                    facebook_id:'',
                    payment_method_id:'',
                    credit_limit_day:'',
                    credit_limit_amount:'',
                    payment_turm_id:'',
                    status_active:'',
                    status:'',


                    vihicle_id:'',
					make_n_modle:'',
					vin_no:'',
					model_year:'',
					vihicle_color:'',
					vihicle_plate_no:'',
					vihicle_left_part_id:'',
					vihicle_right_part_id:'',
					vihicle_front_part_id:'',
					vihicle_back_part_id:'',
					vihicle_ins_exp_date:'',
					vihicle_ins_copy_id:'',
					vihicle_driving_license_id:'',



					id:'',
					vip_note:'',
					add_to_calander:'',
					due_date:'',

					contact_info:[
						{
							id:'',
							contact_name:'',
							contact_id:'',
							full_name:'',
							email:'',
							phone:'',
							fax:'',
							cell_phone:'',
						}
					],
                  
                  	vihicle_info_arr:[
                    	/*{
                          id:'',
                          make_n_modle:'',
                          vin_no:'',
                          model_year:'',
                          color:'',
                          plate_no:'',
                          left_photo_id:'',
                          right_photo_id:'',
                          font_photo_id:'',
                          back_photo_id:'',
                          insurence_expire_date:'',
                          insurence_copy_id:'',
                          driving_license_id:'',
                    	}*/
                  ],
                  service_matching_arr:[
                    	{
							id:'',
							customer_product_code:'',
							customer_product_name:'',
							company_product_code:'',
							company_product_name:'',
							tax1:'',
							tax2:'',
							tax3:'',
                    	}
                  ],
                  ship_to_arr:[
                    	{
							id:'',
							code:'',
							full_name:'',
							address:'',
							phone:'',
							fax:'',
							email:'',
                    	}
                  	],

              	}),
              	columns: [
                    
                    { label: 'SL', field: 'id', align: 'center' },
                    { label: 'Customer Name', field: 'customer_name' },
                    { label: 'Address', field: 'address' },
                    { label: 'Email', field: 'email' },
                    { label: 'Phone', field: 'phone' },
                    { label: 'Website', field: 'website' },
                    { label: '', field: '', sortable: false },
                ],

                vihicle_columns: [
                    
                    { label: 'SL', field: 'id', align: 'center' },
                    { label: 'Make & Model', field: 'make_n_modle' },
                    { label: 'VIN #', field: 'vin_no' },
                    { label: 'Model Year', field: 'model_year' },
                    { label: 'Color', field: 'color' },
                    { label: 'Plate #', field: 'plate_no' },
                    { label: '', field: '', sortable: false },
                ],
                rows: [],
                    row:{
                          customer_name:'',
                    address:'',
                    email:'',
                    phone:'',
                    cell_phone:'',
                    website:'',
                    linkedin_id:'',
                    facebook_id:'',
                    payment_method_id:'',
                    credit_limit_day:'',
                    credit_limit_amount:'',
                    payment_turm_id:'',
                    status_active:'',
                    status:'',
					id:'',
					vip_note:'',
					add_to_calander:'',
					due_date:'',
                 },
                  
                year_arr:[], 
                contact_info_arr:[],
                payment_method_arr:[],
                user_type_arr:[],
                StatusArr:[],
                page: 1,
                per_page:10,
                page1: 1,
                per_page1:10,
          	}
        },// data finish


        created: function()
        {
            this.fetchUsers();

        },
        methods: {
            fetchUsers()
            {
                let uri = '/Users';
                window.axios.get(uri).then((response) => {
                  /*this.rows                         = response.data.buyer_data;
                  this.StatusArr                = response.data.row_status;
                  this.contact_info_arr   = response.data.customer_contact_info;
                  this.payment_method_arr = response.data.pament_method;*/
                  this.user_type_arr                  = response.data.user_type_arr;
                });   
            },

              /* ==============federal Account addition function============================*/
			addVihicle(){

        	 	if(this.make_n_modle=="")
        	 	{
        	 		toast({
						type: 'warning',
						title: 'Please write Make & Model.'
					});
					return;
        	 	}

                this.form.vihicle_info_arr.push({

					//id:this.form.vihicle_id,
					make_n_modle:this.form.make_n_modle,
					vin_no:this.form.vin_no,
					model_year:this.form.model_year,
					color:this.form.vihicle_color,
					plate_no:this.form.vihicle_plate_no,
					left_photo_id:this.form.vihicle_left_part_id,
					right_photo_id:this.form.vihicle_right_part_id,
					font_photo_id:this.form.vihicle_front_part_id,
					back_photo_id:this.form.vihicle_back_part_id,
					insurence_expire_date:this.form.vihicle_ins_exp_date,
					insurence_copy_id:this.form.vihicle_ins_copy_id,
					driving_license_id:this.form.vihicle_driving_license_id,
            	

        		});
               alert(333);
            },

          
        }
	}


</script>

	

