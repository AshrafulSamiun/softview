<template>
	
		<div class="row">
	      	<div class="col-md-12 col-sm-12" >
		      	<form @submit.prevent="editmode ? updateUserProfile() : createUserProfile()" @keydown="form.onKeydown($event)">
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
								                    <input v-model="form.user_operational_id"
								                    v-on:dblclick="user_id_popup"
								                     type="text" name="user_operational_id" class="form-control" :class="{ 'is-invaluser_operational_id': form.errors.has('user_operational_id') }" readonly>
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
												  	<has-error :form="form" field="user_type"></has-error>
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
								    		<td colspan="6"  style="width:100% ;border-bottom:2px solid #b8b6b4;"></td>
								    	</tr>
			
									</tbody>
							    </table>
							    <fieldset style="margin-top:30px;">
								 	<legend style="width:200px;">Address</legend>
									<table width="100%"  class="table" align="center">
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
													  	<has-error :form="form" field="country_id"></has-error>
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
										   		<td>
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
													<select v-model="form.service_type"
														name="service_type" 
														id="service_type"
														class="form-control" :class="{ 'is-invalid': form.errors.has('service_type') }">
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
								                    Owner Name:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<input v-model="form.woner_name" type="text" name="woner_name" class="form-control" :class="{ 'is-invalid': form.errors.has('woner_name') }">
												    <has-error :form="form" field="woner_name"></has-error>
								                </div>
								    		</td>
								    	

								    		<td>
								            	<div class="form-lebel" align="right">
								                    Work Phone:
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
													<input v-model="form.company_website" type="url" name="company_website" class="form-control" :class="{ 'is-invalid': form.errors.has('company_website') }" placeholder="https://www.example.com">
												    <has-error :form="form" field="company_website"></has-error>
								                </div>
								    		</td>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    B.N #:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.bn_no" type="text" name="bn_no" class="form-control" :class="{ 'is-invalid': form.errors.has('bn_no') }">
												    <has-error :form="form" field="bn_no"></has-error>
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
							 	<legend style="width:400px;">Authorized Persons from Owner</legend>
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
													<input v-model="form.fm_address" type="text" name="fm_address" class="form-control" :class="{ 'is-invalid': form.errors.has('fm_address') }" >
												    <has-error :form="form" field="fm_address"></has-error>
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
													<input v-model="form.fm_business_address" type="text" name="fm_business_address" class="form-control" :class="{ 'is-invalid': form.errors.has('fm_business_address') }">
												    <has-error :form="form" field="fm_business_address"></has-error>
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
													<input v-model="form.fm_company_bn_no" type="text" name="fm_company_bn_no" class="form-control" :class="{ 'is-invalid': form.errors.has('fm_company_bn_no') }">
												    <has-error :form="form" field="fm_company_bn_no"></has-error>
								                </div>
								    		</td>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Website:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<input v-model="form.fm_company_website" type="url" name="fm_company_website" class="form-control" :class="{ 'is-invalid': form.errors.has('fm_company_website') }" placeholder="https://www.example.com">
												    <has-error :form="form" field="fm_company_website"></has-error>
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
								                    Model:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.vihicle_model_no" type="text" name="vihicle_model_no" class="form-control" :class="{ 'is-invalid': form.errors.has('vihicle_model_no') }">
												    <has-error :form="form" field="vihicle_model_no"></has-error>
								                </div>
								    		</td>

								    		
								    	
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Model Year:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<select v-model="form.vihicle_model_year"
														name="vihicle_model_year" 
														id="vihicle_model_year"
														class="form-control" :class="{ 'is-invalid': form.errors.has('vihicle_model_year') }">
														<option disabled value="">--Select Model Year-- </option>
														<option v-for="(year,index) in year_arr" :value="index">{{year}}</option>
											  		</select>
								                </div>
								    		</td>
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
								    	</tr>

								        <tr>	
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Plate #:
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
								                     	format="DD-MM-YYYY"></date-picker>
								                </div>
								    		</td>
								  
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
							                    <td>{{ row.vihicle_model_no }}</td>
							                    <td>{{ row.vihicle_model_year }}</td>
							                    <td>{{ row.vihicle_color }}</td>
							                    <td>{{ row.vihicle_plate_no }}</td>
							                    <td>
							                    	<button class="btn btn-primary btn-sm" @click.prevent="edit_vihicle_info(row)">Edit</button>
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
									   		<td>
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
														class="btn btn-primary btn-block">Upload</button>
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
														class="btn btn-primary btn-block">Upload</button>
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
														class="btn btn-primary btn-block">Upload</button>
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
														class="btn btn-primary btn-block">Upload </br></button>
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
														class="btn btn-primary btn-block">Upload</button>
								                </div>
								    		</td>
									   	</tr>

									</tbody>
									
							    </table>
							    <table width="100%"  class="table " align="center">
							    	<tbody>
							    		<tr>
									   		<td  colspan="2">
									   			<div class="form-group">
									   				<button :disabled="form.busy" v-show="!editmode" type="submit" class="btn btn-primary ">Create</button>
													<button :disabled="form.busy" v-show="editmode" type="submit" class="btn btn-primary">Update</button>
									   			</div>
									   		</td>
									
								    		<td></td>
								    		<td></td>
								    		<td></td>
									   	</tr>
								
									</tbody>
								</table>
							</fieldset>
							<br/>
						</div>  
				    </div>

		        </form>	     
	      	</div><!-- /.col-md-12 -->
	    


	      	<!--  MOdel User Photo -->
        	<div class="modal fade" id="addNewPhoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"   >
			  <div class="modal-dialog" role="document">
			    <div class="modal-content" style="width:600px">
	            
			      	<div class="modal-header">
		                <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmodephpto" id="">Add New Photo</h5>
						<h5 class="modal-title" v-show="editmodephpto" id="">Update Photo</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
		  			<div class="modal-body">
				         <form @submit.prevent="editmodephpto ? updateImage() : createImage()" @keydown="form.onKeydown($event)">
				         	<table width="550">
    
						    	<tbody>
						           	
						        	<tr>
						        		<td>
						        			<div class="form-group" v-if="user_photo">
					                           	<img :src="user_photo" class="img-responsive" height="150" width="200">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        			<div class="form-group">
					                              <input type="file" v-on:change="onImageChange" class="form-control" style="max-width:500px;">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        		

					                       	<div class="form-group">
						                        <button :disabled="form.busy" v-show="!editmodephpto" type="submit" class="btn btn-primary">Save Photo</button>
										      	<button :disabled="form.busy" v-show="editmodephpto" type="submit" class="btn btn-primary">Update Photo</button>
										      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						                    </div>

						        		</td>
						        	</tr>
						        </tbody>
						    </table>
				         	
					  	</form>
				      </div>
				      <div class="modal-footer">
				      </div>
				    </div>
				  </div>
			</div>

			<!-- model end -->


			<!--  Model Authorized Persons Photo -->
        	<div class="modal fade" id="addNewAuthorizePhoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"   >
			  <div class="modal-dialog" role="document">
			    <div class="modal-content" style="width:600px">
	            
			      	<div class="modal-header">
		                <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmodeAuthorizephpto" id="">Add New Photo</h5>
						<h5 class="modal-title" v-show="editmodeAuthorizephpto" id="">Update Photo</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
		  			<div class="modal-body">
				         <form @submit.prevent="editmodeAuthorizephpto ? updateAuthorizeImage() : createAuthorizeImage()" @keydown="form.onKeydown($event)">
				         	<table width="550">
    
						    	<tbody>
						           	
						        	<tr>
						        		<td>
						        			<div class="form-group" v-if="authorize_photo">
					                           	<img :src="authorize_photo" class="img-responsive" height="150" width="200">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        			<div class="form-group">
					                              <input type="file" v-on:change="onAuthorizeImageChange" class="form-control" style="max-width:500px;">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        		

					                       	<div class="form-group">
						                        <button :disabled="form.busy" v-show="!editmodeAuthorizephpto" type="submit" class="btn btn-primary">Save Photo</button>
										      	<button :disabled="form.busy" v-show="editmodeAuthorizephpto" type="submit" class="btn btn-primary">Update Photo</button>
										      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						                    </div>

						        		</td>
						        	</tr>
						        </tbody>
						    </table>
				         	
					  	</form>
				      </div>
				      <div class="modal-footer">
				      </div>
				    </div>
				  </div>
			</div>

			<!-- model end -->



			<!--  Model Authorized Persons Gove id  Back Photo -->
        	<div class="modal fade" id="addNewGovtIdBack" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"   >
			  <div class="modal-dialog" role="document">
			    <div class="modal-content" style="width:600px">
	            
			      	<div class="modal-header">
		                <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmodegovtIdBack" id="">Add New Photo</h5>
						<h5 class="modal-title" v-show="editmodegovtIdBack" id="">Update Photo</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
		  			<div class="modal-body">
				         <form @submit.prevent="editmodegovtIdBack ? updateGovtIdBack() : createGovtIdBack()" @keydown="form.onKeydown($event)">
				         	<table width="550">
    
						    	<tbody>
						           	
						        	<tr>
						        		<td>
						        			<div class="form-group" v-if="govt_id_back">
					                           	<img :src="govt_id_back" class="img-responsive" height="150" width="200">
					                        </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        			<div class="form-group">
					                              <input type="file" v-on:change="onGovtIdBackChange" class="form-control" style="max-width:500px;">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
					                       	<div class="form-group">
						                        <button :disabled="form.busy" v-show="!editmodegovtIdBack" type="submit" class="btn btn-primary">Save Photo</button>
										      	<button :disabled="form.busy" v-show="editmodegovtIdBack" type="submit" class="btn btn-primary">Update Photo</button>
										      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						                    </div>

						        		</td>
						        	</tr>
						        </tbody>
						    </table>
				         	
					  	</form>
				      </div>
				      <div class="modal-footer">
				      </div>
				    </div>
				  </div>
			</div>

			<!-- model end -->


			<!--  Model Authorized Persons Gove id  Front Photo -->
        	<div class="modal fade" id="addNewGovtIdFront" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"   >
			  <div class="modal-dialog" role="document">
			    <div class="modal-content" style="width:600px">
	            
			      	<div class="modal-header">
		                <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmodegovtIdFront" id="">Add New Photo</h5>
						<h5 class="modal-title" v-show="editmodegovtIdFront" id="">Update Photo</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
		  			<div class="modal-body">
				         <form @submit.prevent="editmodegovtIdFront ? updateGovtIdFront() : createGovtIdFront()" @keydown="form.onKeydown($event)">
				         	<table width="550">
    
						    	<tbody>
						           	
						        	<tr>
						        		<td>
						        			<div class="form-group" v-if="govt_id_front">
					                           	<img :src="govt_id_front" class="img-responsive" height="150" width="200">
					                        </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        			<div class="form-group">
					                              <input type="file" v-on:change="onGovtIdFrontChange" class="form-control" style="max-width:500px;">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
					                       	<div class="form-group">
						                        <button :disabled="form.busy" v-show="!editmodegovtIdFront" type="submit" class="btn btn-primary">Save Photo</button>
										      	<button :disabled="form.busy" v-show="editmodegovtIdFront" type="submit" class="btn btn-primary">Update Photo</button>
										      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						                    </div>

						        		</td>
						        	</tr>
						        </tbody>
						    </table>
				         	
					  	</form>
				      </div>
				      <div class="modal-footer">
				      </div>
				    </div>
				  </div>
			</div>

			<!-- model end -->

			<!--  MOdel Upload Permit -->
        	<div class="modal fade" id="addNewPermit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"   >
			  <div class="modal-dialog" role="document">
			    <div class="modal-content" style="width:600px">
	            
			      	<div class="modal-header">
		                <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmodepermit" id="">Add New Permit Copy</h5>
						<h5 class="modal-title" v-show="editmodepermit" id="">Update Permit Copy</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
		  			<div class="modal-body">
				         <form @submit.prevent="editmodepermit ? updatePermit() : createPermit()" @keydown="form.onKeydown($event)">
				         	<table width="550">
    
						    	<tbody>
						           	
						        	<tr>
						        		<td>
						        			<div class="form-group" v-if="permit">
					                           	<img :src="permit" class="img-responsive" height="150" width="200">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        			<div class="form-group">
					                              <input type="file" v-on:change="onPermitChange" class="form-control" style="max-width:500px;">
					                         </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        		
					                       	<div class="form-group">
						                        <button :disabled="form.busy" v-show="!editmodepermit" type="submit" class="btn btn-primary">Save Permit Copy</button>
										      	<button :disabled="form.busy" v-show="editmodepermit" type="submit" class="btn btn-primary">Update Permit Copy</button>
										      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						                    </div>

						        		</td>
						        	</tr>
						        </tbody>
						    </table>
				         	
					  	</form>
				      </div>
				      <div class="modal-footer">
				      </div>
				    </div>
				  </div>
			</div>

			<!-- model end -->
			<!--  MOdel Upload License -->
        	<div class="modal fade" id="addNewLicense" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"   >
			  <div class="modal-dialog" role="document">
			    <div class="modal-content" style="width:600px">
	            
			      	<div class="modal-header">
		                <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmodeLicense" id="">Add New License Copy</h5>
						<h5 class="modal-title" v-show="editmodeLicense" id="">Update License Copy</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
		  			<div class="modal-body">
				         <form @submit.prevent="editmodeLicense ? updateLicense() : createLicense()" @keydown="form.onKeydown($event)">
				         	<table width="550">
    
						    	<tbody>
						           	
						        	<tr>
						        		<td>
						        			<div class="form-group" v-if="license">
					                           	<img :src="license" class="img-responsive" height="150" width="200">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        			<div class="form-group">
					                              <input type="file" v-on:change="onLicenseChange" class="form-control" style="max-width:500px;">
					                         </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        		
					                       	<div class="form-group">
						                        <button :disabled="form.busy" v-show="!editmodeLicense" type="submit" class="btn btn-primary">Save License Copy</button>
										      	<button :disabled="form.busy" v-show="editmodeLicense" type="submit" class="btn btn-primary">Update License Copy</button>
										      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						                    </div>

						        		</td>
						        	</tr>
						        </tbody>
						    </table>
				         	
					  	</form>
				      </div>
				      <div class="modal-footer">
				      </div>
				    </div>
				  </div>
			</div>

			<!-- model end -->


			<!--  MOdel Upload Liability Insurance  -->
        	<div class="modal fade" id="addNewLiabilityInsurance" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"   >
			  <div class="modal-dialog" role="document">
			    <div class="modal-content" style="width:600px">
	            
			      	<div class="modal-header">
		                <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmodeLiability" id="">Add New Liability Insurance Copy</h5>
						<h5 class="modal-title" v-show="editmodeLiability" id="">Update Liability Insurance Copy</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
		  			<div class="modal-body">
				         <form @submit.prevent="editmodeLiability ? updateLiability() : createLiability()" @keydown="form.onKeydown($event)">
				         	<table width="550">
    
						    	<tbody>
						           	
						        	<tr>
						        		<td>
						        			<div class="form-group" v-if="liability_insurence">
					                           	<img :src="liability_insurence" class="img-responsive" height="150" width="200">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        			<div class="form-group">
					                              <input type="file" v-on:change="onLiabilityChange" class="form-control" style="max-width:500px;">
					                         </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        		
					                       	<div class="form-group">
						                        <button :disabled="form.busy" v-show="!editmodeLiability" type="submit" class="btn btn-primary">Save Liability Insurance Copy</button>
										      	<button :disabled="form.busy" v-show="editmodeLiability" type="submit" class="btn btn-primary">Update Liability Insurance Copy</button>
										      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						                    </div>

						        		</td>
						        	</tr>
						        </tbody>
						    </table>
				         	
					  	</form>
				      </div>
				      <div class="modal-footer">
				      </div>
				    </div>
				  </div>
			</div>

			<!-- model end -->

			<!--  MOdel Upload Home Insurance  -->
        	<div class="modal fade" id="addNewHomeInsurance" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"   >
			  <div class="modal-dialog" role="document">
			    <div class="modal-content" style="width:600px">
	            
			      	<div class="modal-header">
		                <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmodeHomeInsurence" id="">Add New Home Insurance Copy</h5>
						<h5 class="modal-title" v-show="editmodeHomeInsurence" id="">Update Home Insurance Copy</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
		  			<div class="modal-body">
				         <form @submit.prevent="editmodeHomeInsurence ? updateHomeInsurence() : createHomeInsurence()" @keydown="form.onKeydown($event)">
				         	<table width="550">
    
						    	<tbody>
						           	
						        	<tr>
						        		<td>
						        			<div class="form-group" v-if="home_insurence">
					                           	<img :src="home_insurence" class="img-responsive" height="150" width="200">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        			<div class="form-group">
					                              <input type="file" v-on:change="onHomeChange" class="form-control" style="max-width:500px;">
					                         </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        		
					                       	<div class="form-group">
						                        <button :disabled="form.busy" v-show="!editmodeHomeInsurence" type="submit" class="btn btn-primary">Save Home Insurance Copy</button>
										      	<button :disabled="form.busy" v-show="editmodeHomeInsurence" type="submit" class="btn btn-primary">Update Home Insurance Copy</button>
										      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						                    </div>

						        		</td>
						        	</tr>
						        </tbody>
						    </table>
				         	
					  	</form>
				      </div>
				      <div class="modal-footer">
				      </div>
				    </div>
				  </div>
			</div>

			<!-- model end -->

			<!--  MOdel Upload Car Insurance  -->
        	<div class="modal fade" id="addNewCarInsurance" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"   >
			  <div class="modal-dialog" role="document">
			    <div class="modal-content" style="width:600px">
	            
			      	<div class="modal-header">
		                <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmodeCarInsurence" id="">Add New Car Insurance Copy</h5>
						<h5 class="modal-title" v-show="editmodeCarInsurence" id="">Update Car Insurance Copy</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
		  			<div class="modal-body">
				         <form @submit.prevent="editmodeCarInsurence ? updateCarInsurence() : createCarInsurence()" @keydown="form.onKeydown($event)">
				         	<table width="550">
    
						    	<tbody>
						           	
						        	<tr>
						        		<td>
						        			<div class="form-group" v-if="car_insurence">
					                           	<img :src="car_insurence" class="img-responsive" height="150" width="200">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        			<div class="form-group">
					                              <input type="file" v-on:change="onCarChange" class="form-control" style="max-width:500px;">
					                         </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        		
					                       	<div class="form-group">
						                        <button :disabled="form.busy" v-show="!editmodeCarInsurence" type="submit" class="btn btn-primary">Save Car Insurance Copy</button>
										      	<button :disabled="form.busy" v-show="editmodeCarInsurence" type="submit" class="btn btn-primary">Update Car Insurance Copy</button>
										      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						                    </div>

						        		</td>
						        	</tr>
						        </tbody>
						    </table>
				         	
					  	</form>
				      </div>
				      <div class="modal-footer">
				      </div>
				    </div>
				  </div>
			</div>

			<!-- model end -->

	    </div>
	
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
                editmodephpto:false,
                editmodeAuthorizephpto:false,
                editmodegovtIdFront:false,
                editmodegovtIdBack:false,
                editmodepermit:false,
                editmodeLicense:false,
                editmodeLiability:false,
                editmodeHomeInsurence:false,
                editmodeCarInsurence:false,
                user_photo: '',
                authorize_photo:'',
                govt_id_front:'',
                govt_id_back:'',
                permit:'',
                license:'',
                liability_insurence:'',
                home_insurence:'',
                car_insurence:'',
                form:new Form(
                {
                    user_operational_id:'',
                    first_name:'',
                    middle_name:'',
                    last_name:'',
                    nick_name:'',
                    website:'',
                    office_phone:'',
                    cell_phone:'',
                    home_phone:'',
                    official_email:'',
                    recovery_email:'',
                    user_type:'',
                    user_photo_id:'',
                   
                    country_id:'',
                    mailing_country_id:'',
                    billing_country_id:'',

					state:'',
					mailing_state:'',
					billing_state:'',

					city:'',
					mailing_city:'',
					billing_city:'',

					street:'',
					mailing_street:'',
					billing_street:'',

					postal_code:'',
					mailing_postal_code:'',
					billing_postal_code:'',

					legal_name:'',
					operational_name:'',
					buisness_type:'',
					service_type:'',
					company_address:'',
					woner_name:'',
					company_office_phone:'',
					company_cell_phone:'',
					company_email:'',
					company_website:'',
					bn_no:'',
					related_association:'',
					status_active:'',

					fm_legal_name:'',
					fm_photo_id:'',
					fm_gove_id_fontpart:'',
					fm_gove_id_backpart:'',

					fm_address:'',
					relation_with_landlord:'',
					fm_office_phone:'',
					fm_cell_phone:'',
					fm_email:'',
					fm_company_name:'',
					fm_company_phone:'',
					fm_business_address:'',
					fm_company_bn_no:'',
					fm_company_website:'',

					vihicle_model_no:'',
					vihicle_model_year:'',
					vihicle_color:'',
					vihicle_plate_no:'',
					vihicle_ins_exp_date:'',

					permit_start:'',
					permit_end:'',
					permit_expire_date:'',
					permit_image_id:'',

					license_start:'',
					license_end:'',
					license_expire_date:'',
					license_image_id:'',

					liability_start:'',
					liability_end:'',
					liability_expire_date:'',
					liability_image_id:'',

					home_insurence_start:'',
					home_insurence_end:'',
					home_insurence_expire_date:'',
					home_insurence_image_id:'',

					car_insurence_start:'',
					car_insurence_end:'',
					car_insurence_expire_date:'',
					car_insurence_image_id:'',

					id:'',
					user_company_id:'',
					othorize_person_id:'',
					permit_licence_id:'',
			
                  	vihicle_info_arr:[
                    	
                  	],
                 

              	}),
          

                vihicle_columns: [
                    
                    { label: 'SL', field: 'id', align: 'center' },
                    { label: 'Model', field: 'vihicle_model_no' },
                    { label: 'Model Year', field: 'vihicle_model_year' },
                    { label: 'Color', field: 'color' },
                    { label: 'Plate #', field: 'plate_no' },
                    { label: '', field: '', sortable: false },
                ],
             
                vihicle_info_arr:[],
                country_arr:[], 
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

        	user_id_popup(){
        		
    
        		$("#addInsertedUser").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
        	},

        	/*=======================upload photo=======================================*/
        	upload_user_photo(){

                $("#addNewPhoto").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },

            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createrowimage(files[0]);
            },
            createrowimage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.user_photo = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            createImage(){
            	
        		axios.post('/image/store',{image: this.user_photo,image_file_name: 'user_photo',image_folder_name: 'user_photo'}).then(({ data }) => {
                   	
                   	var response_arr=data.split('**');
                   	this.form.user_photo_id=response_arr[1];
                   	this.editmodephpto=true;
                   	toast({
					  type: 'success',
					  title: 'Data Save Successfully'
					});
                });
                
            },

            updateImage(){

        		axios.post('/image/update',{image: this.user_photo,img_id: this.form.user_photo_id,image_file_name: 'user_photo',image_folder_name: 'user_photo'}).then(({ data }) => {

                   var response_arr=data.split('**');
                   this.form.user_photo_id=response_arr[1];
                   this.editmodephpto=true;
                   toast({
					  type: 'success',
					  title: 'Data Update Successfully'
					});
                });
            },

            /*=======================upload authorize person photo======================================*/

			upload_fm_photo(){

                $("#addNewAuthorizePhoto").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },

            onAuthorizeImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createAuthorizerowimage(files[0]);
            },
            createAuthorizerowimage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.authorize_photo = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            createAuthorizeImage(){
            	
        		axios.post('/image/store',{image: this.authorize_photo,image_file_name: 'authorize_user_photo',image_folder_name: 'authorize_user_photo'}).then(({ data }) => {
                   	
                   	var response_arr=data.split('**');
                   	this.form.fm_photo_id=response_arr[1];
                   	this.editmodeAuthorizephpto=true;
                   	toast({
					  type: 'success',
					  title: 'Data Save Successfully'
					});
                });
                
            },

            updateAuthorizeImage(){

        		axios.post('/image/update',{image: this.authorize_photo,img_id: this.form.fm_photo_id,image_file_name: 'authorize_user_photo',image_folder_name: 'authorize_user_photo'}).then(({ data }) => {

                   var response_arr=data.split('**');
                   this.form.fm_photo_id=response_arr[1];
                   this.editmodeAuthorizephpto=true;
                   toast({
					  type: 'success',
					  title: 'Data Update Successfully'
					});
                });
            },


             /*=======================upload govt id front======================================*/

			upload_fm_govt_id_front_part(){

                $("#addNewGovtIdFront").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },

            onGovtIdFrontChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createGovtIdrowimage(files[0]);
            },
            createGovtIdrowimage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.govt_id_front = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            createGovtIdFront(){
            	
        		axios.post('/image/store',{image: this.govt_id_front,image_file_name: 'authorize_user_gove_id_frontpart',image_folder_name: 'authorize_user_gove_id'}).then(({ data }) => {
                   	
                   	var response_arr=data.split('**');
                   	this.form.fm_gove_id_fontpart=response_arr[1];
                   	this.editmodegovtIdFront=true;
                   	toast({
					  type: 'success',
					  title: 'Data Save Successfully'
					});
                });
                
            },

            updateGovtIdFront(){

        		axios.post('/image/update',{image: this.govt_id_front,img_id: this.form.fm_gove_id_fontpart,image_file_name: 'authorize_user_gove_id_frontpart',image_folder_name: 'authorize_user_gove_id'}).then(({ data }) => {

                   var response_arr=data.split('**');
                   this.form.fm_gove_id_fontpart=response_arr[1];
                   this.editmodegovtIdFront=true;
                   toast({
					  type: 'success',
					  title: 'Data Update Successfully'
					});
                });
            },
             /*=======================upload govt id back part======================================*/

			upload_fm_govt_id_back_part(){

                $("#addNewGovtIdBack").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },

            onGovtIdBackChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createGovtIdBackrowimage(files[0]);
            },
            createGovtIdBackrowimage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.govt_id_back = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            createGovtIdBack(){
            	
        		axios.post('/image/store',{image: this.govt_id_back,image_file_name: 'authorize_user_gove_id_back',image_folder_name: 'authorize_user_gove_id'}).then(({ data }) => {
                   	
                   	var response_arr=data.split('**');
                   	this.form.fm_gove_id_backpart=response_arr[1];
                   	this.editmodegovtIdBack=true;
                   	toast({
					  type: 'success',
					  title: 'Data Save Successfully'
					});
                });
                
            },

            updateGovtIdBack(){

        		axios.post('/image/update',{image: this.govt_id_back,img_id: this.form.fm_gove_id_backpart,image_file_name: 'authorize_user_gove_id_back',image_folder_name: 'authorize_user_gove_id'}).then(({ data }) => {

                   var response_arr=data.split('**');
                   this.form.fm_gove_id_backpart=response_arr[1];
                   this.editmodegovtIdBack=true;
                   toast({
					  type: 'success',
					  title: 'Data Update Successfully'
					});
                });
            },



            /*=======================upload permit=======================================*/
        	upload_permit_photo(){

                $("#addNewPermit").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },

            onPermitChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createrowPermit(files[0]);
            },
            createrowPermit(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.permit = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            createPermit(){
            	
        		axios.post('/image/store',{image: this.permit,image_file_name: 'permit',image_folder_name: 'permit_licence_insurence'}).then(({ data }) => {
                   	
                   	var response_arr=data.split('**');
                   	this.form.permit_image_id=response_arr[1];
                   	this.editmodepermit=true;
                   	toast({
					  type: 'success',
					  title: 'Data Save Successfully'
					});
                });
                
            },

            updatePermit(){

        		axios.post('/image/update',{image: this.permit,img_id: this.form.permit_image_id,image_file_name: 'permit',image_folder_name: 'permit_licence_insurence'}).then(({ data }) => {

                   var response_arr=data.split('**');
                   this.form.permit_image_id=response_arr[1];
                   this.editmodepermit=true;
                   toast({
					  type: 'success',
					  title: 'Data Update Successfully'
					});
                });
            },


            /*=======================upload License=======================================*/
        	upload_license_photo(){

                $("#addNewLicense").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },

            onLicenseChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createrowLicense(files[0]);
            },
            createrowLicense(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.license = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            createLicense(){
            	
        		axios.post('/image/store',{image: this.license,image_file_name: 'license',image_folder_name: 'permit_licence_insurence'}).then(({ data }) => {
                   	
                   	var response_arr=data.split('**');
                   	this.form.license_image_id=response_arr[1];
                   	this.editmodeLicense=true;
                   	toast({
					  type: 'success',
					  title: 'Data Save Successfully'
					});
                });
                
            },

            updateLicense(){

        		axios.post('/image/update',{image: this.license,img_id: this.form.license_image_id,image_file_name: 'license',image_folder_name: 'permit_licence_insurence'}).then(({ data }) => {

                   var response_arr=data.split('**');
                   this.form.license_image_id=response_arr[1];
                   this.editmodeLicense=true;
                   toast({
					  type: 'success',
					  title: 'Data Update Successfully'
					});
                });
            },


            /*=======================upload Liability Insurance ==========================*/
        	upload_liability_photo(){
                $("#addNewLiabilityInsurance").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },

            onLiabilityChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createrowLiability(files[0]);
            },
            createrowLiability(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.liability_insurence = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            createLiability(){
            	
        		axios.post('/image/store',{image: this.liability_insurence,image_file_name: 'liability',image_folder_name: 'permit_licence_insurence'}).then(({ data }) => {
        		
                   	
                   	var response_arr=data.split('**');
                   	this.form.liability_image_id=response_arr[1];
                   	this.editmodeLiability=true;
                   	toast({
					  type: 'success',
					  title: 'Data Save Successfully'
					});
                });
                
            },

            updateLiability(){

        		axios.post('/image/update',{image: this.liability_insurence,img_id: this.form.liability_image_id,image_file_name: 'liability',image_folder_name: 'permit_licence_insurence'}).then(({ data }) => {

                   var response_arr=data.split('**');
                   this.form.liability_image_id=response_arr[1];
                   this.editmodeLiability=true;
                   toast({
					  type: 'success',
					  title: 'Data Update Successfully'
					});
                });
            },


            /*=======================upload Home Insurance =======================================*/
        	upload_home_insurence_photo(){
                $("#addNewHomeInsurance").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },

            onHomeChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createrowHome(files[0]);
            },
            createrowHome(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.home_insurence = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            createHomeInsurence(){
            	
        		axios.post('/image/store',{image: this.home_insurence,image_file_name: 'home_insurence',image_folder_name: 'permit_licence_insurence'}).then(({ data }) => {
                   	
                   	var response_arr=data.split('**');
                   	this.form.home_insurence_image_id=response_arr[1];
                   	this.editmodeHomeInsurence=true;
                   	toast({
					  type: 'success',
					  title: 'Data Save Successfully'
					});
                });
                
            },

            updateHomeInsurence(){

        		axios.post('/image/update',{image: this.home_insurence,img_id: this.form.home_insurence_image_id,image_file_name: 'home_insurence',image_folder_name: 'permit_licence_insurence'}).then(({ data }) => {

                   var response_arr=data.split('**');
                   this.form.home_insurence_image_id=response_arr[1];
                   this.editmodeHomeInsurence=true;
                   toast({
					  type: 'success',
					  title: 'Data Update Successfully'
					});
                });
            },


            /*=======================upload Car Insurance =======================================*/
        	upload_car_insurence_photo(){
                $("#addNewCarInsurance").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },

            onCarChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createrowCar(files[0]);
            },
            createrowCar(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.car_insurence = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            createCarInsurence(){
            	
        		axios.post('/image/store',{image: this.car_insurence,image_file_name: 'car_insurence',image_folder_name: 'permit_licence_insurence'}).then(({ data }) => {
                   	
                   	var response_arr=data.split('**');
                   	this.form.car_insurence_image_id=response_arr[1];
                   	this.editmodeCarInsurence=true;
                   	toast({
					  type: 'success',
					  title: 'Data Save Successfully'
					});
                });
                
            },

            updateCarInsurence(){

        		axios.post('/image/update',{image: this.car_insurence,img_id: this.form.car_insurence_image_id,image_file_name: 'car_insurence',image_folder_name: 'permit_licence_insurence'}).then(({ data }) => {

                   var response_arr=data.split('**');
                   this.form.car_insurence_image_id=response_arr[1];
                   this.editmodeCarInsurence=true;
                   toast({
					  type: 'success',
					  title: 'Data Update Successfully'
					});
                });
            },

            fetchUsers()
            {
                let uri = '/UserProfiles';
                window.axios.get(uri).then((response) => {
                
                  this.form.fill(response.data.user_data);
                  this.country_arr      	= response.data.country_arr;
                  this.user_type_arr      	= response.data.user_type_arr;
                  this.StatusArr      		= response.data.row_status;
                  this.year_arr      		= response.data.year_arr;
                  this.vihicle_info_arr     = response.data.vihicle_info_arr;

                  /* ==============Filing Date addition============================*/
               		this.form.filing_dates.splice(0);
                	for( var i = 0; i < this.vihicle_info_arr.length; i++ ) 
					{
					
						this.form.vihicle_info_arr.push({

							id:'',
	                		vihicle_model_no:this.vihicle_info_arr[i].vihicle_model_no,
	                		vihicle_model_year:this.vihicle_info_arr[i].vihicle_model_year,
	                		reporting_period:'',
		            		upcomming:'',
		            		pass_due:'',

		            		vihicle_model_no:this.form.vihicle_model_no,
							vihicle_model_year:this.form.vihicle_model_year,
							vihicle_color:this.form.vihicle_color,
							vihicle_plate_no:this.form.vihicle_plate_no,
							vihicle_ins_exp_date:this.form.vihicle_ins_exp_date,
	            		});
					}
                });   
            },




            /* ==============vihicle addition function============================*/
			addVihicle(){

        	 	if(this.vihicle_model_no=="")
        	 	{
        	 		toast({
						type: 'warning',
						title: 'Please write Model.'
					});
					return;
        	 	}

                this.form.vihicle_info_arr.push({

					vihicle_model_no:this.form.vihicle_model_no,
					vihicle_model_year:this.form.vihicle_model_year,
					vihicle_color:this.form.vihicle_color,
					vihicle_plate_no:this.form.vihicle_plate_no,
					vihicle_ins_exp_date:this.form.vihicle_ins_exp_date,

        		});

               this.form.vihicle_model_no='';
               this.form.vihicle_model_year='';
               this.form.vihicle_color='';
               this.form.vihicle_ins_exp_date='';
               this.form.vihicle_plate_no='';
               this.form.vihicle_model_no='';

            },

            edit_vihicle_info(row){

        	 

                this.form.vihicle_info_arr.push({

					vihicle_model_no:this.form.vihicle_model_no,
					vihicle_model_year:this.form.vihicle_model_year,
					vihicle_color:this.form.vihicle_color,
					vihicle_plate_no:this.form.vihicle_plate_no,
			
					vihicle_ins_exp_date:this.form.vihicle_ins_exp_date,
					//insurence_copy_id:this.form.vihicle_ins_copy_id,
					//driving_license_id:this.form.vihicle_driving_license_id,
            	

        		});

               this.form.vihicle_model_no='';
               this.form.vihicle_model_year='';
               this.form.vihicle_color='';
               this.form.vihicle_ins_exp_date='';
               this.form.vihicle_plate_no='';
               this.form.vihicle_model_no='';

            },


            createUserProfile()
            {

        	     this.form.post('/UserProfiles') .then(({ data }) => { 

        	    	if(data==1)
					{
						
						toast({
							type: 'success',
							title: 'Data Save successfully'
						});

						this.form.reset ();
					    this.fetchCompanies();
					}
					else if(data==10)
					{

						toast({
							type: 'question',
							title: 'Invalid Operation.'
						});
					}
					else
					{
						Swal("failed!","there was some wrong","warning");
					}
					
        	    })
            },

            updateUserProfile()
            {
            	
		        this.form.put('/UserProfiles/'+this.form.id)
				    .then(({data})=>{
					   
						if(data==1)
						{
							
							toast({
								type: 'success',
								title: 'Data Update successfully'
							});

							this.form.reset ();
						    this.fetchCompanies();
						    this.editmode=false;
						}
						else if(data==10)
						{

							toast({
								type: 'question',
								title: 'Invalid Operation.'
							});
						}
						else
						{
							alert(data)
							Swal("failed!","there was some wrong","warning");
						}
				    })
				 
            },

          
        }
	}


</script>

	

