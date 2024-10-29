<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                            <h1 class="page-head">New Application</h1>
                            <div class="form-folder">
                                <div class="form-holder">
                                    <div class="row align-self-stretch">
                                        <div class="col-md-4 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer d-flex align-items-center">
                                                <div class="ac-box">
													<label for="management_type2">File No</label>
													<input type="text" value="" 
																			name="file_no" 
																			id="file_no"
																			v-model="form.file_no">
																			<br>

													<label for="management_type2">Market Posing ID No</label>
													<input type="text" value="" 
																			name="market_posting_id" 
																			id="market_posting_id"
																			v-model="form.market_posting_id">
																			<br>
													<label for="management_type2">Application Date </label>
													<input type="text" value="" 
																			name="application_date" 
																			id="application_date"
																			v-model="form.application_date">
																			<br>
													<label for="management_type2">Account Number</label>
													<input type="text" value="" 
																			name="account_no" 
																			id="account_no"
																			v-model="form.account_no">
																			<br>						
                                                    
                                                </div>
                                            </div>
                                        </div>

										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th scope="col">Application</th>
														<th scope="col"></th>
														<th scope="col">Date</th>
														<th scope="col">Comment</th>
													</tr>
												</thead>
												<tbody>
												<tr>
													<th scope="row">In Process</th>
													<td><input type="checkbox" 
									                        	id="in_process" 
									                        	name="in_process" 
									                        	v-model="form.in_process"></td>
													<td><input type="date" value="" 
																			name="in_process_date" 
																			id="in_process_date"
																			v-model="form.in_process_date"></td>
													<td><input type="text" value="" 
																			name="in_process_comment" 
																			id="in_process_comment"
																			v-model="form.in_process_comment"></td>
													
												</tr>
												<tr>
													<th scope="row">On Hold</th>
													<td><input type="checkbox" 
									                        	id="on_hold" 
									                        	name="on_hold" 
									                        	v-model="form.on_hold"></td>
													<td><input type="date" value="" 
																			name="on_hold_date" 
																			id="on_hold_date"
																			v-model="form.on_hold_date"></td>
													<td><input type="text" value="" 
																			name="on_hold_comment" 
																			id="on_hold_comment"
																			v-model="form.on_hold_comment"></td>
													
												</tr>
												<tr>
													<th scope="row">Approved</th>
													<td><input type="checkbox" 
									                        	id="approved" 
									                        	name="approved" 
									                        	v-model="form.approved"></td>
													<td><input type="date" value="" 
																			name="approved_date" 
																			id="approved_date"
																			v-model="form.approved_date"></td>
													<td><input type="text" value="" 
																			name="approved_comment" 
																			id="approved_comment"
																			v-model="form.approved_comment"></td>
													
												</tr>
												<tr>
													<th scope="row">Rejected</th>
													<td><input type="checkbox" 
									                        	id="rejected" 
									                        	name="rejected" 
									                        	v-model="form.rejected"></td>
													<td><input type="date" value="" 
																			name="rejected_date" 
																			id="rejected_date"
																			v-model="form.rejected_date"></td>
													<td><input type="text" value="" 
																			name="rejected_comment" 
																			id="rejected_comment"
																			v-model="form.rejected_comment"></td>
													
												</tr>
												<tr>
													<th scope="row">Re-Open</th>
													<td><input type="checkbox" 
									                        	id="re_open" 
									                        	name="re_open" 
									                        	v-model="form.re_open"></td>
													<td><input type="date" value="" 
																			name="re_open_date" 
																			id="re_open_date"
																			v-model="form.re_open_date"></td>
													<td><input type="text" value="" 
																			name="re_open_comment" 
																			id="re_open_comment"
																			v-model="form.re_open_comment"></td>
													
												</tr>
												</tbody>
											</table>
										</div>
										<h3><i class="fa fa-hand-point-right"></i> Rental Property Information  :</h3>
										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th scope="col">Property</th>
														<th scope="col">Code- Name </th>
														<th scope="col">Address</th>
														<th scope="col">No</th>
														<th scope="col"></th>
													</tr>
												</thead>
												<tbody>
												<tr>
													<th scope="row">Building </th>
													<td><input type="text" value="" 
																			name="building_code_name" 
																			id="building_code_name"
																			v-model="form.building_code_name"></td>
													<td><input type="text" value="" 
																			name="building_address" 
																			id="building_address"
																			v-model="form.building_address"></td>
													<td><input type="text" value="" 
																			name="building_no" 
																			id="building_no"
																			v-model="form.building_no"></td>
													<td><input type="text" value="" 
																			name="building_blank" 
																			id="building_blank"
																			v-model="form.building_blank"></td>
												</tr>
												<tr>
													<th scope="row">Residential Suite</th>
													<td><input type="text" value="" 
																			name="residential_suite_code_name" 
																			id="residential_suite_code_name"
																			v-model="form.residential_suite_code_name"></td>
													<td><input type="text" value="" 
																			name="residential_suite_address" 
																			id="residential_suite_address"
																			v-model="form.residential_suite_address"></td>
													<td><input type="text" value="" 
																			name="residential_suite_no" 
																			id="residential_suite_no"
																			v-model="form.residential_suite_no"></td>
													<td><input type="text" value="" 
																			name="residential_suite_blank" 
																			id="residential_suite_blank"
																			v-model="form.residential_suite_blank"></td>
												</tr>
												<tr>
													<th scope="row">Studio</th>
													<td><input type="text" value="" 
																			name="studio_code_name" 
																			id="studio_code_name"
																			v-model="form.studio_code_name"></td>
													<td><input type="text" value="" 
																			name="studio_address" 
																			id="studio_address"
																			v-model="form.studio_address"></td>
													<td><input type="text" value="" 
																			name="studio_no" 
																			id="studio_no"
																			v-model="form.studio_no"></td>
													<td><input type="text" value="" 
																			name="studio_blank" 
																			id="studio_blank"
																			v-model="form.studio_blank"></td>
												</tr>
												<tr>
													<th scope="row">1 Bed</th>
													<td><input type="text" value="" 
																			name="one_bed_code_name" 
																			id="one_bed_code_name"
																			v-model="form.one_bed_code_name"></td>
													<td><input type="text" value="" 
																			name="one_bed_address" 
																			id="one_bed_address"
																			v-model="form.one_bed_address"></td>
													<td><input type="text" value="" 
																			name="one_bed_no" 
																			id="one_bed_no"
																			v-model="form.one_bed_no"></td>
													<td><input type="text" value="" 
																			name="one_bed_blank" 
																			id="one_bed_blank"
																			v-model="form.one_bed_blank"></td>
												</tr>
												<tr>
													<th scope="row">2 Bed</th>
													<td><input type="text" value="" 
																			name="two_bed_code_name" 
																			id="two_bed_code_name"
																			v-model="form.two_bed_code_name"></td>
													<td><input type="text" value="" 
																			name="two_bed_address" 
																			id="two_bed_address"
																			v-model="form.two_bed_address"></td>
													<td><input type="text" value="" 
																			name="two_bed_no" 
																			id="two_bed_no"
																			v-model="form.two_bed_no"></td>
													<td><input type="text" value="" 
																			name="two_bed_blank" 
																			id="two_bed_blank"
																			v-model="form.two_bed_blank"></td>
												</tr>
												<tr>
													<th scope="row">3 Bed</th>
													<td><input type="text" value="" 
																			name="three_bed_code_name" 
																			id="three_bed_code_name"
																			v-model="form.three_bed_code_name"></td>
													<td><input type="text" value="" 
																			name="three_bed_address" 
																			id="three_bed_address"
																			v-model="form.three_bed_address"></td>
													<td><input type="text" value="" 
																			name="three_bed_no" 
																			id="three_bed_no"
																			v-model="form.three_bed_no"></td>
													<td><input type="text" value="" 
																			name="three_bed_blank" 
																			id="three_bed_blank"
																			v-model="form.three_bed_blank"></td>
												</tr>
												<tr>
													<th scope="row">4 Bed</th>
													<td><input type="text" value="" 
																			name="four_bed_code_name" 
																			id="four_bed_code_name"
																			v-model="form.four_bed_code_name"></td>
													<td><input type="text" value="" 
																			name="four_bed_address" 
																			id="four_bed_address"
																			v-model="form.four_bed_address"></td>
													<td><input type="text" value="" 
																			name="four_bed_no" 
																			id="four_bed_no"
																			v-model="form.four_bed_no"></td>
													<td><input type="text" value="" 
																			name="four_bed_blank" 
																			id="four_bed_blank"
																			v-model="form.four_bed_blank"></td>
												</tr>
												<tr>
													<th scope="row">5 Bed</th>
													<td><input type="text" value="" 
																			name="five_bed_code_name" 
																			id="five_bed_code_name"
																			v-model="form.five_bed_code_name"></td>
													<td><input type="text" value="" 
																			name="five_bed_address" 
																			id="five_bed_address"
																			v-model="form.five_bed_address"></td>
													<td><input type="text" value="" 
																			name="five_bed_no" 
																			id="five_bed_no"
																			v-model="form.five_bed_no"></td>
													<td><input type="text" value="" 
																			name="five_bed_blank" 
																			id="five_bed_blank"
																			v-model="form.five_bed_blank"></td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<th scope="row">Commercial Unit</th>
													<td><input type="text" value="" 
																			name="commercial_unit_code_name" 
																			id="commercial_unit_code_name"
																			v-model="form.commercial_unit_code_name"></td>
													<td><input type="text" value="" 
																			name="commercial_unit_address" 
																			id="commercial_unit_address"
																			v-model="form.commercial_unit_address"></td>
													<td><input type="text" value="" 
																			name="commercial_unit_no" 
																			id="commercial_unit_no"
																			v-model="form.commercial_unit_no"></td>
													<td><input type="text" value="" 
																			name="commercial_unit_blank" 
																			id="commercial_unit_blank"
																			v-model="form.commercial_unit_blank"></td>
												</tr>
												<tr>
													<th scope="row">Parking </th>
													<td><input type="text" value="" 
																			name="parking_code_name" 
																			id="parking_code_name"
																			v-model="form.parking_code_name"></td>
													<td><input type="text" value="" 
																			name="parking_address" 
																			id="parking_address"
																			v-model="form.parking_address"></td>
													<td><input type="text" value="" 
																			name="parking_no" 
																			id="parking_no"
																			v-model="form.parking_no"></td>
													<td><input type="text" value="" 
																			name="parking_blank" 
																			id="parking_blank"
																			v-model="form.parking_blank"></td>
												</tr>
												<tr>
													<th scope="row">Lot </th>
													<td><input type="text" value="" 
																			name="parking_lot_code_name" 
																			id="parking_lot_code_name"
																			v-model="form.parking_lot_code_name"></td>
													<td><input type="text" value="" 
																			name="parking_lot_address" 
																			id="parking_lot_address"
																			v-model="form.parking_lot_address"></td>
													<td><input type="text" value="" 
																			name="parking_lot_no" 
																			id="parking_lot_no"
																			v-model="form.parking_lot_no"></td>
													<td><input type="text" value="" 
																			name="parking_lot_blank" 
																			id="parking_lot_blank"
																			v-model="form.parking_lot_blank"></td>
												</tr>
												<tr>
													<th scope="row">Storage Locker </th>
													<td><input type="text" value="" 
																			name="storage_locker_code_name" 
																			id="storage_locker_code_name"
																			v-model="form.storage_locker_code_name"></td>
													<td><input type="text" value="" 
																			name="storage_locker_address" 
																			id="storage_locker_address"
																			v-model="form.storage_locker_address"></td>
													<td><input type="text" value="" 
																			name="storage_locker_no" 
																			id="storage_locker_no"
																			v-model="form.storage_locker_no"></td>
													<td><input type="text" value="" 
																			name="storage_locker_blank" 
																			id="storage_locker_blank"
																			v-model="form.storage_locker_blank"></td>
												</tr>
												<tr>
													<th scope="row">Lot No </th>
													<td><input type="text" value="" 
																			name="storage_lot_no_code_name" 
																			id="storage_lot_no_code_name"
																			v-model="form.storage_lot_code_name"></td>
													<td><input type="text" value="" 
																			name="storage_lot_no_address" 
																			id="storage_lot_no_address"
																			v-model="form.storage_lot_address"></td>
													<td><input type="text" value="" 
																			name="storage_lot_no_no" 
																			id="storage_lot_no_no"
																			v-model="form.storage_lot_no"></td>
													<td><input type="text" value="" 
																			name="storage_lot_no_blank" 
																			id="storage_lot_no_blank"
																			v-model="form.storage_lot_blank"></td>
												</tr>
												<tr>
													<th scope="row">Locker's No</th>
													<td><input type="text" value="" 
																			name="lockers_no_code_name" 
																			id="lockers_no_code_name"
																			v-model="form.lockers_no_code_name"></td>
													<td><input type="text" value="" 
																			name="lockers_no_address" 
																			id="lockers_no_address"
																			v-model="form.lockers_no_address"></td>
													<td><input type="text" value="" 
																			name="lockers_no_no" 
																			id="lockers_no_no"
																			v-model="form.lockers_no_no"></td>
													<td><input type="text" value="" 
																			name="lockers_no_blank" 
																			id="lockers_no_blank"
																			v-model="form.lockers_no_blank"></td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>
												

												</tbody>
											</table>
										</div>
										<h3><i class="fa fa-hand-point-right"></i> Property Availability  :</h3>
										<div class="table-responsive">
											<table class="table">
												<tbody>
													<tr>
														<th scope="row">Date</th>
														<td><input type="date" value="" 
																				name="property_availability_date" 
																				id="property_availability_date"
																				v-model="form.property_availability_date"></td>
													</tr>
													<tr>
														<th scope="row">Time</th>
														<td><input type="time" value="" 
																				name="property_availability_time" 
																				id="property_availability_time"
																				v-model="form.property_availability_time"></td>
													</tr>
												</tbody>
											</table>
										</div>
										<h3><i class="fa fa-hand-point-right"></i> Applicant/s Profile  :</h3>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i> Applicant/s and Dependent's Info  :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col"></th>
															<th scope="col">Applicant </th>
															<th scope="col">Dependent 1</th>
															<th scope="col">Dependent 2</th>
															<th scope="col">Dependent 3</th>
															<th scope="col">Dependent 4</th>
														</tr>
													</thead>
													<tbody>
														<caption>Name</caption>
														<tr>
															<th scope="row">First</th>
															<td><input type="text" value="" 
																					name="applicant_first_name" 
																					id="applicant_first_name"
																					v-model="form.applicant_first_name"></td>
															<td><input type="text" value="" 
																					name="dependent_one_first_name" 
																					id="dependent_one_first_name"
																					v-model="form.dependent_one_first_name"></td>
															<td><input type="text" value="" 
																					name="dependent_two_first_name" 
																					id="dependent_two_first_name"
																					v-model="form.dependent_two_first_name"></td>
															<td><input type="text" value="" 
																					name="dependent_three_first_name" 
																					id="dependent_three_first_name"
																					v-model="form.dependent_three_first_name"></td>
															<td><input type="text" value="" 
																					name="dependent_four_first_name" 
																					id="dependent_four_first_name"
																					v-model="form.dependent_four_first_name"></td>
														</tr>
														<tr>
															<th scope="row">Middle</th>
															<td><input type="text" value="" 
																					name="applicant_middle_name" 
																					id="applicant_middle_name"
																					v-model="form.applicant_middle_name"></td>
															<td><input type="text" value="" 
																					name="dependent_one_middle_name" 
																					id="dependent_one_middle_name"
																					v-model="form.dependent_one_middle_name"></td>
															<td><input type="text" value="" 
																					name="dependent_two_middle_name" 
																					id="dependent_two_middle_name"
																					v-model="form.dependent_two_middle_name"></td>
															<td><input type="text" value="" 
																					name="dependent_three_middle_name" 
																					id="dependent_three_middle_name"
																					v-model="form.dependent_three_middle_name"></td>
															<td><input type="text" value="" 
																					name="dependent_four_middle_name" 
																					id="dependent_four_middle_name"
																					v-model="form.dependent_four_middle_name"></td>
														</tr>
														<tr>
															<th scope="row">Last</th>
															<td><input type="text" value="" 
																					name="applicant_last_name" 
																					id="applicant_last_name"
																					v-model="form.applicant_last_name"></td>
															<td><input type="text" value="" 
																					name="dependent_one_last_name" 
																					id="dependent_one_last_name"
																					v-model="form.dependent_one_last_name"></td>
															<td><input type="text" value="" 
																					name="dependent_two_last_name" 
																					id="dependent_two_last_name"
																					v-model="form.dependent_two_last_name"></td>
															<td><input type="text" value="" 
																					name="dependent_three_last_name" 
																					id="dependent_three_last_name"
																					v-model="form.dependent_three_last_name"></td>
															<td><input type="text" value="" 
																					name="dependent_four_last_name" 
																					id="dependent_four_last_name"
																					v-model="form.dependent_four_last_name"></td>
														</tr>
														<tr>
															<th scope="row">Relations</th>
															<td><input type="text" value="" 
																					name="applicant_relations_name" 
																					id="applicant_relations_name"
																					v-model="form.applicant_relations_name"></td>
															<td><input type="text" value="" 
																					name="dependent_one_relations_name" 
																					id="dependent_one_relations_name"
																					v-model="form.dependent_one_relations_name"></td>
															<td><input type="text" value="" 
																					name="dependent_two_relations_name" 
																					id="dependent_two_relations_name"
																					v-model="form.dependent_two_relations_name"></td>
															<td><input type="text" value="" 
																					name="dependent_three_relations_name" 
																					id="dependent_three_relations_name"
																					v-model="form.dependent_three_relations_name"></td>
															<td><input type="text" value="" 
																					name="dependent_four_relations_name" 
																					id="dependent_four_relations_name"
																					v-model="form.dependent_four_relations_name"></td>
														</tr>
														<caption>Current Address</caption>
														<tr>
															<th scope="row">No</th>
															<td><input type="text" value="" 
																					name="applicant_current_address_no" 
																					id="applicant_current_address_no"
																					v-model="form.applicant_current_address_no"></td>
															<td><input type="text" value="" 
																					name="dependent_one_current_address_no" 
																					id="dependent_one_current_address_no"
																					v-model="form.dependent_one_current_address_no"></td>
															<td><input type="text" value="" 
																					name="dependent_two_current_address_no" 
																					id="dependent_two_current_address_no"
																					v-model="form.dependent_two_current_address_no"></td>
															<td><input type="text" value="" 
																					name="dependent_three_current_address_no" 
																					id="dependent_three_current_address_no"
																					v-model="form.dependent_three_current_address_no"></td>
															<td><input type="text" value="" 
																					name="dependent_four_current_address_no" 
																					id="dependent_four_current_address_no"
																					v-model="form.dependent_four_current_address_no"></td>
														</tr>
														<tr>
															<th scope="row">Street</th>
															<td><input type="text" value="" 
																					name="applicant_current_street" 
																					id="applicant_current_street"
																					v-model="form.applicant_current_street"></td>
															<td><input type="text" value="" 
																					name="dependent_one_current_street" 
																					id="dependent_one_current_street"
																					v-model="form.dependent_one_current_street"></td>
															<td><input type="text" value="" 
																					name="dependent_two_current_street" 
																					id="dependent_two_current_street"
																					v-model="form.dependent_two_current_street"></td>
															<td><input type="text" value="" 
																					name="dependent_three_current_street" 
																					id="dependent_three_current_street"
																					v-model="form.dependent_three_current_street"></td>
															<td><input type="text" value="" 
																					name="dependent_four_current_street" 
																					id="dependent_four_current_street"
																					v-model="form.dependent_four_current_street"></td>
														</tr>
														<tr>
															<th scope="row">City</th>
															<td><input type="text" value="" 
																					name="applicant_current_city" 
																					id="applicant_current_city"
																					v-model="form.applicant_current_city"></td>
															<td><input type="text" value="" 
																					name="dependent_one_current_city" 
																					id="dependent_one_current_city"
																					v-model="form.dependent_one_current_city"></td>
															<td><input type="text" value="" 
																					name="dependent_two_current_city" 
																					id="dependent_two_current_city"
																					v-model="form.dependent_two_current_city"></td>
															<td><input type="text" value="" 
																					name="dependent_three_current_city" 
																					id="dependent_three_current_city"
																					v-model="form.dependent_three_current_city"></td>
															<td><input type="text" value="" 
																					name="dependent_four_current_city" 
																					id="dependent_four_current_city"
																					v-model="form.dependent_four_current_city"></td>
														</tr>
														<tr>
															<th scope="row">State/ Province</th>
															<td><input type="text" value="" 
																					name="applicant_current_state" 
																					id="applicant_current_state"
																					v-model="form.applicant_current_state"></td>
															<td><input type="text" value="" 
																					name="dependent_one_current_state" 
																					id="dependent_one_current_state"
																					v-model="form.dependent_one_current_state"></td>
															<td><input type="text" value="" 
																					name="dependent_two_current_state" 
																					id="dependent_two_current_state"
																					v-model="form.dependent_two_current_state"></td>
															<td><input type="text" value="" 
																					name="dependent_three_current_state" 
																					id="dependent_three_current_state"
																					v-model="form.dependent_three_current_state"></td>
															<td><input type="text" value="" 
																					name="dependent_four_current_state" 
																					id="dependent_four_current_state"
																					v-model="form.dependent_four_current_state"></td>
														</tr>
														<tr>
															<th scope="row">Country</th>
															<td><input type="text" value="" 
																					name="applicant_current_country" 
																					id="applicant_current_country"
																					v-model="form.applicant_current_country"></td>
															<td><input type="text" value="" 
																					name="dependent_one_current_country" 
																					id="dependent_one_current_country"
																					v-model="form.dependent_one_current_country"></td>
															<td><input type="text" value="" 
																					name="dependent_two_current_country" 
																					id="dependent_two_current_country"
																					v-model="form.dependent_two_current_country"></td>
															<td><input type="text" value="" 
																					name="dependent_three_current_country" 
																					id="dependent_three_current_country"
																					v-model="form.dependent_three_current_country"></td>
															<td><input type="text" value="" 
																					name="dependent_four_current_country" 
																					id="dependent_four_current_country"
																					v-model="form.dependent_four_current_country"></td>
														</tr>
														<tr>
															<th scope="row">Zip/Postal Code</th>
															<td><input type="text" value="" 
																					name="applicant_current_zip" 
																					id="applicant_current_zip"
																					v-model="form.applicant_current_zip"></td>
															<td><input type="text" value="" 
																					name="dependent_one_current_zip" 
																					id="dependent_one_current_zip"
																					v-model="form.dependent_one_current_zip"></td>
															<td><input type="text" value="" 
																					name="dependent_two_current_zip" 
																					id="dependent_two_current_zip"
																					v-model="form.dependent_two_current_zip"></td>
															<td><input type="text" value="" 
																					name="dependent_three_current_zip" 
																					id="dependent_three_current_zip"
																					v-model="form.dependent_three_current_zip"></td>
															<td><input type="text" value="" 
																					name="dependent_four_current_zip" 
																					id="dependent_four_current_zip"
																					v-model="form.dependent_four_current_zip"></td>
														</tr>
														<caption>Previous Address 2</caption>
														<tr>
															<th scope="row">No</th>
															<td><input type="text" value="" 
																					name="applicant_previous_two_address_no" 
																					id="applicant_previous_two_address_no"
																					v-model="form.applicant_previous_two_address_no"></td>
															<td><input type="text" value="" 
																					name="dependent_one_previous_two_address_no" 
																					id="dependent_one_previous_two_address_no"
																					v-model="form.dependent_one_previous_two_address_no"></td>
															<td><input type="text" value="" 
																					name="dependent_two_previous_two_address_no" 
																					id="dependent_two_previous_two_address_no"
																					v-model="form.dependent_two_previous_two_address_no"></td>
															<td><input type="text" value="" 
																					name="dependent_three_previous_two_address_no" 
																					id="dependent_three_previous_two_address_no"
																					v-model="form.dependent_three_previous_two_address_no"></td>
															<td><input type="text" value="" 
																					name="dependent_four_previous_two_address_no" 
																					id="dependent_four_previous_two_address_no"
																					v-model="form.dependent_four_previous_two_address_no"></td>
														</tr>
														<tr>
															<th scope="row">Street</th>
															<td><input type="text" value="" 
																					name="applicant_previous_two_street" 
																					id="applicant_previous_two_street"
																					v-model="form.applicant_previous_two_street"></td>
															<td><input type="text" value="" 
																					name="dependent_one_previous_two_street" 
																					id="dependent_one_previous_two_street"
																					v-model="form.dependent_one_previous_two_street"></td>
															<td><input type="text" value="" 
																					name="dependent_two_previous_two_street" 
																					id="dependent_two_previous_two_street"
																					v-model="form.dependent_two_previous_two_street"></td>
															<td><input type="text" value="" 
																					name="dependent_three_previous_two_street" 
																					id="dependent_three_previous_two_street"
																					v-model="form.dependent_three_previous_two_street"></td>
															<td><input type="text" value="" 
																					name="dependent_four_previous_two_street" 
																					id="dependent_four_previous_two_street"
																					v-model="form.dependent_four_previous_two_street"></td>
														</tr>
														<tr>
															<th scope="row">City</th>
															<td><input type="text" value="" 
																					name="applicant_previous_two_city" 
																					id="applicant_previous_two_city"
																					v-model="form.applicant_previous_two_city"></td>
															<td><input type="text" value="" 
																					name="dependent_one_previous_two_city" 
																					id="dependent_one_previous_two_city"
																					v-model="form.dependent_one_previous_two_city"></td>
															<td><input type="text" value="" 
																					name="dependent_two_previous_two_city" 
																					id="dependent_two_previous_two_city"
																					v-model="form.dependent_two_previous_two_city"></td>
															<td><input type="text" value="" 
																					name="dependent_three_previous_two_city" 
																					id="dependent_three_previous_two_city"
																					v-model="form.dependent_three_previous_two_city"></td>
															<td><input type="text" value="" 
																					name="dependent_four_previous_two_city" 
																					id="dependent_four_previous_two_city"
																					v-model="form.dependent_four_previous_two_city"></td>
														</tr>
														<tr>
															<th scope="row">State/ Province</th>
															<td><input type="text" value="" 
																					name="applicant_previous_two_state" 
																					id="applicant_previous_two_state"
																					v-model="form.applicant_previous_two_state"></td>
															<td><input type="text" value="" 
																					name="dependent_one_previous_two_state" 
																					id="dependent_one_previous_two_state"
																					v-model="form.dependent_one_previous_two_state"></td>
															<td><input type="text" value="" 
																					name="dependent_two_previous_two_state" 
																					id="dependent_two_previous_two_state"
																					v-model="form.dependent_two_previous_two_state"></td>
															<td><input type="text" value="" 
																					name="dependent_three_previous_two_state" 
																					id="dependent_three_previous_two_state"
																					v-model="form.dependent_three_previous_two_state"></td>
															<td><input type="text" value="" 
																					name="dependent_four_previous_two_state" 
																					id="dependent_four_previous_two_state"
																					v-model="form.dependent_four_previous_two_state"></td>
														</tr>
														<tr>
															<th scope="row">Country</th>
															<td><input type="text" value="" 
																					name="applicant_previous_two_country" 
																					id="applicant_previous_two_country"
																					v-model="form.applicant_previous_two_country"></td>
															<td><input type="text" value="" 
																					name="dependent_one_previous_two_country" 
																					id="dependent_one_previous_two_country"
																					v-model="form.dependent_one_previous_two_country"></td>
															<td><input type="text" value="" 
																					name="dependent_two_previous_two_country" 
																					id="dependent_two_previous_two_country"
																					v-model="form.dependent_two_previous_two_country"></td>
															<td><input type="text" value="" 
																					name="dependent_three_previous_two_country" 
																					id="dependent_three_previous_two_country"
																					v-model="form.dependent_three_previous_two_country"></td>
															<td><input type="text" value="" 
																					name="dependent_four_previous_two_country" 
																					id="dependent_four_previous_two_country"
																					v-model="form.dependent_four_previous_two_country"></td>
														</tr>
														<tr>
															<th scope="row">Zip/Postal Code</th>
															<td><input type="text" value="" 
																					name="applicant_previous_two_zip" 
																					id="applicant_previous_two_zip"
																					v-model="form.applicant_previous_two_zip"></td>
															<td><input type="text" value="" 
																					name="dependent_one_previous_two_zip" 
																					id="dependent_one_previous_two_zip"
																					v-model="form.dependent_one_previous_two_zip"></td>
															<td><input type="text" value="" 
																					name="dependent_two_previous_two_zip" 
																					id="dependent_two_previous_two_zip"
																					v-model="form.dependent_two_previous_two_zip"></td>
															<td><input type="text" value="" 
																					name="dependent_three_previous_two_zip" 
																					id="dependent_three_previous_two_zip"
																					v-model="form.dependent_three_previous_two_zip"></td>
															<td><input type="text" value="" 
																					name="dependent_four_previous_two_zip" 
																					id="dependent_four_previous_two_zip"
																					v-model="form.dependent_four_previous_two_zip"></td>
														</tr>
														<caption>Previous Address 1</caption>
														<tr>
															<th scope="row">No</th>
															<td><input type="text" value="" 
																					name="applicant_previous_one_address_no" 
																					id="applicant_previous_one_address_no"
																					v-model="form.applicant_previous_one_address_no"></td>
															<td><input type="text" value="" 
																					name="dependent_one_previous_one_address_no" 
																					id="dependent_one_previous_one_address_no"
																					v-model="form.dependent_one_previous_one_address_no"></td>
															<td><input type="text" value="" 
																					name="dependent_two_previous_one_address_no" 
																					id="dependent_two_previous_one_address_no"
																					v-model="form.dependent_two_previous_one_address_no"></td>
															<td><input type="text" value="" 
																					name="dependent_three_previous_one_address_no" 
																					id="dependent_three_previous_one_address_no"
																					v-model="form.dependent_three_previous_one_address_no"></td>
															<td><input type="text" value="" 
																					name="dependent_four_previous_one_address_no" 
																					id="dependent_four_previous_one_address_no"
																					v-model="form.dependent_four_previous_one_address_no"></td>
														</tr>
														<tr>
															<th scope="row">Street</th>
															<td><input type="text" value="" 
																					name="applicant_previous_one_street" 
																					id="applicant_previous_one_street"
																					v-model="form.applicant_previous_one_street"></td>
															<td><input type="text" value="" 
																					name="dependent_one_previous_one_street" 
																					id="dependent_one_previous_one_street"
																					v-model="form.dependent_one_previous_one_street"></td>
															<td><input type="text" value="" 
																					name="dependent_two_previous_one_street" 
																					id="dependent_two_previous_one_street"
																					v-model="form.dependent_two_previous_one_street"></td>
															<td><input type="text" value="" 
																					name="dependent_three_previous_one_street" 
																					id="dependent_three_previous_one_street"
																					v-model="form.dependent_three_previous_one_street"></td>
															<td><input type="text" value="" 
																					name="dependent_four_previous_one_street" 
																					id="dependent_four_previous_one_street"
																					v-model="form.dependent_four_previous_one_street"></td>
														</tr>
														<tr>
															<th scope="row">City</th>
															<td><input type="text" value="" 
																					name="applicant_previous_one_city" 
																					id="applicant_previous_one_city"
																					v-model="form.applicant_previous_one_city"></td>
															<td><input type="text" value="" 
																					name="dependent_one_previous_one_city" 
																					id="dependent_one_previous_one_city"
																					v-model="form.dependent_one_previous_one_city"></td>
															<td><input type="text" value="" 
																					name="dependent_two_previous_one_city" 
																					id="dependent_two_previous_one_city"
																					v-model="form.dependent_two_previous_one_city"></td>
															<td><input type="text" value="" 
																					name="dependent_three_previous_one_city" 
																					id="dependent_three_previous_one_city"
																					v-model="form.dependent_three_previous_one_city"></td>
															<td><input type="text" value="" 
																					name="dependent_four_previous_one_city" 
																					id="dependent_four_previous_one_city"
																					v-model="form.dependent_four_previous_one_city"></td>
														</tr>
														<tr>
															<th scope="row">State/ Province</th>
															<td><input type="text" value="" 
																					name="applicant_previous_one_state" 
																					id="applicant_previous_one_state"
																					v-model="form.applicant_previous_one_state"></td>
															<td><input type="text" value="" 
																					name="dependent_one_previous_one_state" 
																					id="dependent_one_previous_one_state"
																					v-model="form.dependent_one_previous_one_state"></td>
															<td><input type="text" value="" 
																					name="dependent_two_previous_one_state" 
																					id="dependent_two_previous_one_state"
																					v-model="form.dependent_two_previous_one_state"></td>
															<td><input type="text" value="" 
																					name="dependent_three_previous_one_state" 
																					id="dependent_three_previous_one_state"
																					v-model="form.dependent_three_previous_one_state"></td>
															<td><input type="text" value="" 
																					name="dependent_four_previous_one_state" 
																					id="dependent_four_previous_one_state"
																					v-model="form.dependent_four_previous_one_state"></td>
														</tr>
														<tr>
															<th scope="row">Country</th>
															<td><input type="text" value="" 
																					name="applicant_previous_one_country" 
																					id="applicant_previous_one_country"
																					v-model="form.applicant_previous_one_country"></td>
															<td><input type="text" value="" 
																					name="dependent_one_previous_one_country" 
																					id="dependent_one_previous_one_country"
																					v-model="form.dependent_one_previous_one_country"></td>
															<td><input type="text" value="" 
																					name="dependent_two_previous_one_country" 
																					id="dependent_two_previous_one_country"
																					v-model="form.dependent_two_previous_one_country"></td>
															<td><input type="text" value="" 
																					name="dependent_three_previous_one_country" 
																					id="dependent_three_previous_one_country"
																					v-model="form.dependent_three_previous_one_country"></td>
															<td><input type="text" value="" 
																					name="dependent_four_previous_one_country" 
																					id="dependent_four_previous_one_country"
																					v-model="form.dependent_four_previous_one_country"></td>
														</tr>
														<tr>
															<th scope="row">Zip/Postal Code</th>
															<td><input type="text" value="" 
																					name="applicant_previous_one_zip" 
																					id="applicant_previous_one_zip"
																					v-model="form.applicant_previous_one_zip"></td>
															<td><input type="text" value="" 
																					name="dependent_one_previous_one_zip" 
																					id="dependent_one_previous_one_zip"
																					v-model="form.dependent_one_previous_one_zip"></td>
															<td><input type="text" value="" 
																					name="dependent_two_previous_one_zip" 
																					id="dependent_two_previous_one_zip"
																					v-model="form.dependent_two_previous_one_zip"></td>
															<td><input type="text" value="" 
																					name="dependent_three_previous_one_zip" 
																					id="dependent_three_previous_one_zip"
																					v-model="form.dependent_three_previous_one_zip"></td>
															<td><input type="text" value="" 
																					name="dependent_four_previous_one_zip" 
																					id="dependent_four_previous_one_zip"
																					v-model="form.dependent_four_previous_one_zip"></td>
														</tr>
														<caption>Contact</caption>
														<tr>
															<th scope="row">Ph. Home</th>
															<td><input type="text" value="" 
																					name="applicant_ph_home" 
																					id="applicant_ph_home"
																					v-model="form.applicant_ph_home"></td>
															<td><input type="text" value="" 
																					name="dependent_one_ph_home" 
																					id="dependent_one_ph_home"
																					v-model="form.dependent_one_ph_home"></td>
															<td><input type="text" value="" 
																					name="dependent_two_ph_home" 
																					id="dependent_two_ph_home"
																					v-model="form.dependent_two_ph_home"></td>
															<td><input type="text" value="" 
																					name="dependent_three_ph_home" 
																					id="dependent_three_ph_home"
																					v-model="form.dependent_three_ph_home"></td>
															<td><input type="text" value="" 
																					name="dependent_four_ph_home" 
																					id="dependent_four_ph_home"
																					v-model="form.dependent_four_ph_home"></td>
														</tr>
														<tr>
															<th scope="row">Ph. Work</th>
															<td><input type="text" value="" 
																					name="applicant_ph_work" 
																					id="applicant_ph_work"
																					v-model="form.applicant_ph_work"></td>
															<td><input type="text" value="" 
																					name="dependent_one_ph_work" 
																					id="dependent_one_ph_work"
																					v-model="form.dependent_one_ph_work"></td>
															<td><input type="text" value="" 
																					name="dependent_two_ph_work" 
																					id="dependent_two_ph_work"
																					v-model="form.dependent_two_ph_work"></td>
															<td><input type="text" value="" 
																					name="dependent_three_ph_work" 
																					id="dependent_three_ph_work"
																					v-model="form.dependent_three_ph_work"></td>
															<td><input type="text" value="" 
																					name="dependent_four_ph_work" 
																					id="dependent_four_ph_work"
																					v-model="form.dependent_four_ph_work"></td>
														</tr>
														<tr>
															<th scope="row">Ph. Mobile</th>
															<td><input type="text" value="" 
																					name="applicant_ph_mobile" 
																					id="applicant_ph_mobile"
																					v-model="form.applicant_ph_mobile"></td>
															<td><input type="text" value="" 
																					name="dependent_one_ph_mobile" 
																					id="dependent_one_ph_mobile"
																					v-model="form.dependent_one_ph_mobile"></td>
															<td><input type="text" value="" 
																					name="dependent_two_ph_mobile" 
																					id="dependent_two_ph_mobile"
																					v-model="form.dependent_two_ph_mobile"></td>
															<td><input type="text" value="" 
																					name="dependent_three_ph_mobile" 
																					id="dependent_three_ph_mobile"
																					v-model="form.dependent_three_ph_mobile"></td>
															<td><input type="text" value="" 
																					name="dependent_four_ph_mobile" 
																					id="dependent_four_ph_mobile"
																					v-model="form.dependent_four_ph_mobile"></td>
														</tr>
														<tr>
															<th scope="row">Email 1</th>
															<td><input type="text" value="" 
																					name="applicant_email_one" 
																					id="applicant_email_one"
																					v-model="form.applicant_email_one"></td>
															<td><input type="text" value="" 
																					name="dependent_one_email_one" 
																					id="dependent_one_email_one"
																					v-model="form.dependent_one_email_one"></td>
															<td><input type="text" value="" 
																					name="dependent_two_email_one" 
																					id="dependent_two_email_one"
																					v-model="form.dependent_two_email_one"></td>
															<td><input type="text" value="" 
																					name="dependent_three_email_one" 
																					id="dependent_three_email_one"
																					v-model="form.dependent_three_email_one"></td>
															<td><input type="text" value="" 
																					name="dependent_four_email_one" 
																					id="dependent_four_email_one"
																					v-model="form.dependent_four_email_one"></td>
														</tr>
														<tr>
															<th scope="row">Email 2</th>
															<td><input type="text" value="" 
																					name="applicant_email_two" 
																					id="applicant_email_two"
																					v-model="form.applicant_email_two"></td>
															<td><input type="text" value="" 
																					name="dependent_one_email_two" 
																					id="dependent_one_email_two"
																					v-model="form.dependent_one_email_two"></td>
															<td><input type="text" value="" 
																					name="dependent_two_email_two" 
																					id="dependent_two_email_two"
																					v-model="form.dependent_two_email_two"></td>
															<td><input type="text" value="" 
																					name="dependent_three_email_two" 
																					id="dependent_three_email_two"
																					v-model="form.dependent_three_email_two"></td>
															<td><input type="text" value="" 
																					name="dependent_four_email_two" 
																					id="dependent_four_email_two"
																					v-model="form.dependent_four_email_two"></td>
														</tr>
														<tr>
															<th scope="row">Fax</th>
															<td><input type="text" value="" 
																					name="applicant_fax" 
																					id="applicant_fax"
																					v-model="form.applicant_fax"></td>
															<td><input type="text" value="" 
																					name="dependent_one_fax" 
																					id="dependent_one_fax"
																					v-model="form.dependent_one_fax"></td>
															<td><input type="text" value="" 
																					name="dependent_two_fax" 
																					id="dependent_two_fax"
																					v-model="form.dependent_two_fax"></td>
															<td><input type="text" value="" 
																					name="dependent_three_fax" 
																					id="dependent_three_fax"
																					v-model="form.dependent_three_fax"></td>
															<td><input type="text" value="" 
																					name="dependent_four_fax" 
																					id="dependent_four_fax"
																					v-model="form.dependent_four_fax"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i> Employment   :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col">Current Employer </th>
															<th scope="col">Applicant </th>
															<th scope="col">Co Applicant</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Employer's Name </th>
															<td><input type="text" value="" 
																					name="current_employer_applicant" 
																					id="current_employer_applicant"
																					v-model="form.current_employer_applicant"></td>
															<td><input type="text" value="" 
																					name="current_employer_coapplicant" 
																					id="current_employer_coapplicant"
																					v-model="form.current_employer_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">Manager/ Supervisor's Name </th>
															<td><input type="text" value="" 
																					name="current_manager_applicant" 
																					id="current_manager_applicant"
																					v-model="form.current_manager_applicant"></td>
															<td><input type="text" value="" 
																					name="current_manager_coapplicant" 
																					id="current_manager_coapplicant"
																					v-model="form.current_manager_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">Job Title </th>
															<td><input type="text" value="" 
																					name="current_job_title_applicant" 
																					id="current_job_title_applicant"
																					v-model="form.current_job_title_applicant"></td>
															<td><input type="text" value="" 
																					name="current_job_title_coapplicant" 
																					id="current_job_title_coapplicant"
																					v-model="form.current_job_title_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">Status</th>
															<td><select v-model="form.current_status_applicant"
	                                                        	name="current_status_applicant"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('current_status_applicant') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															<td><select v-model="form.current_status_coapplicant"
	                                                        	name="current_status_coapplicant"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('current_status_coapplicant') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr>
														<caption>Current Address</caption>
														<tr>
															<th scope="row">No</th>
															<td><input type="text" value="" 
																					name="employer_applicant_current_address_no" 
																					id="employer_applicant_current_address_no"
																					v-model="form.employer_applicant_current_address_no"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_current_address_no" 
																					id="employer_coapplicant_current_address_no"
																					v-model="form.employer_coapplicant_current_address_no"></td>
														</tr>
														<tr>
															<th scope="row">Street</th>
															<td><input type="text" value="" 
																					name="employer_applicant_current_street" 
																					id="employer_applicant_current_street"
																					v-model="form.applicant_current_street"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_current_street" 
																					id="employer_coapplicant_current_street"
																					v-model="form.employer_coapplicant_current_street"></td>
														</tr>
														<tr>
															<th scope="row">City</th>
															<td><input type="text" value="" 
																					name="employer_applicant_current_city" 
																					id="employer_applicant_current_city"
																					v-model="form.applicant_current_city"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_current_city" 
																					id="employer_coapplicant_current_city"
																					v-model="form.employer_coapplicant_current_city"></td>
														</tr>
														<tr>
															<th scope="row">State/ Province</th>
															<td><input type="text" value="" 
																					name="employer_applicant_current_state" 
																					id="employer_applicant_current_state"
																					v-model="form.applicant_current_state"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_current_state" 
																					id="employer_coapplicant_current_state"
																					v-model="form.employer_coapplicant_current_state"></td>
														</tr>
														<tr>
															<th scope="row">Country</th>
															<td><input type="text" value="" 
																					name="employer_applicant_current_country" 
																					id="employer_applicant_current_country"
																					v-model="form.applicant_current_country"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_current_country" 
																					id="employer_coapplicant_current_country"
																					v-model="form.employer_coapplicant_current_country"></td>
														</tr>
														<tr>
															<th scope="row">Zip/Postal Code</th>
															<td><input type="text" value="" 
																					name="employer_applicant_current_zip" 
																					id="employer_applicant_current_zip"
																					v-model="form.applicant_current_zip"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_current_zip" 
																					id="employer_coapplicant_current_zip"
																					v-model="form.employer_coapplicant_current_zip"></td>
														</tr>
														<caption>Contact</caption>
														<tr>
															<th scope="row">Ph. Home</th>
															<td><input type="text" value="" 
																					name="employer_current_applicant_ph_home" 
																					id="employer_current_applicant_ph_home"
																					v-model="form.applicant_ph_home"></td>
															<td><input type="text" value="" 
																					name="employer_current_applicant_ph_home" 
																					id="employer_current_applicant_ph_home"
																					v-model="form.employer_current_applicant_ph_home"></td>
														</tr>
														<tr>
															<th scope="row">Ph. Work</th>
															<td><input type="text" value="" 
																					name="employer_current_applicant_ph_work" 
																					id="employer_current_applicant_ph_work"
																					v-model="form.applicant_ph_work"></td>
															<td><input type="text" value="" 
																					name="employer_current_coapplicant_ph_work" 
																					id="employer_current_coapplicant_ph_work"
																					v-model="form.employer_current_coapplicant_ph_work"></td>
														</tr>
														<tr>
															<th scope="row">Ph. Mobile</th>
															<td><input type="text" value="" 
																					name="employer_current_applicant_ph_mobile" 
																					id="employer_current_applicant_ph_mobile"
																					v-model="form.applicant_ph_mobile"></td>
															<td><input type="text" value="" 
																					name="employer_current_coapplicant_ph_mobile" 
																					id="employer_current_coapplicant_ph_mobile"
																					v-model="form.employer_current_coapplicant_ph_mobile"></td>
														</tr>
														<tr>
															<th scope="row">Email 1</th>
															<td><input type="text" value="" 
																					name="employer_current_applicant_email_one" 
																					id="employer_current_applicant_email_one"
																					v-model="form.applicant_email_one"></td>
															<td><input type="text" value="" 
																					name="employer_current_coapplicant_email_one" 
																					id="employer_current_coapplicant_email_one"
																					v-model="form.employer_current_coapplicant_email_one"></td>
														</tr>
														<tr>
															<th scope="row">Email 2</th>
															<td><input type="text" value="" 
																					name="employer_current_applicant_email_two" 
																					id="employer_current_applicant_email_two"
																					v-model="form.applicant_email_two"></td>
															<td><input type="text" value="" 
																					name="employer_current_coapplicant_email_two" 
																					id="employer_current_coapplicant_email_two"
																					v-model="form.employer_current_coapplicant_email_two"></td>
														</tr>
														<tr>
															<th scope="row">Fax</th>
															<td><input type="text" value="" 
																					name="employer_current_applicant_fax" 
																					id="employer_current_applicant_fax"
																					v-model="form.applicant_fax"></td>
															<td><input type="text" value="" 
																					name="employer_current_coapplicant_fax" 
																					id="employer_current_coapplicant_fax"
																					v-model="form.employer_current_coapplicant_fax"></td>
														</tr>
														<tr>
															<th scope="row">Website</th>
															<td><input type="text" value="" 
																					name="employer_current_applicant_website" 
																					id="employer_current_applicant_website"
																					v-model="form.applicant_website"></td>
															<td><input type="text" value="" 
																					name="employer_current_coapplicant_website" 
																					id="employer_current_coapplicant_website"
																					v-model="form.employer_current_coapplicant_website"></td>
														</tr>
														<tr>
															<th scope="row">Employment Period</th>
															<td><input type="date" value="" 
																					name="employer_current_applicant_emp_period" 
																					id="employer_current_applicant_emp_period"
																					v-model="form.applicant_emp_period"></td>
															<td><input type="date" value="" 
																					name="employer_current_coapplicant_emp_period" 
																					id="employer_current_coapplicant_emp_period"
																					v-model="form.employer_current_coapplicant_emp_period"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i>Previous Employer 3   :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col"></th>
															<th scope="col">Applicant </th>
															<th scope="col">Co Applicant</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Company </th>
															<td><input type="text" value="" 
																					name="prev_three_company_applicant" 
																					id="prev_three_company_applicant"
																					v-model="form.prev_three_company_applicant"></td>
															<td><input type="text" value="" 
																					name="prev_three_company_coapplicant" 
																					id="prev_three_company_coapplicant"
																					v-model="form.prev_three_company_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">Manager's Name </th>
															<td><input type="text" value="" 
																					name="prev_three_manager_applicant" 
																					id="prev_three_manager_applicant"
																					v-model="form.prev_three_manager_applicant"></td>
															<td><input type="text" value="" 
																					name="prev_three_manager_coapplicant" 
																					id="prev_three_manager_coapplicant"
																					v-model="form.prev_three_manager_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">Supervisor's Name </th>
															<td><input type="text" value="" 
																					name="prev_three_supervisor_applicant" 
																					id="prev_three_supervisor_applicant"
																					v-model="form.prev_three_supervisor_applicant"></td>
															<td><input type="text" value="" 
																					name="prev_three_supervisor_coapplicant" 
																					id="prev_three_supervisor_coapplicant"
																					v-model="form.prev_three_supervisor_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">Job Title </th>
															<td><input type="text" value="" 
																					name="prev_three_job_title_applicant" 
																					id="prev_three_job_title_applicant"
																					v-model="form.prev_three_job_title_applicant"></td>
															<td><input type="text" value="" 
																					name="prev_three_job_title_coapplicant" 
																					id="prev_three_job_title_coapplicant"
																					v-model="form.prev_three_job_title_coapplicant"></td>
														</tr>
														<caption>Address</caption>
														<tr>
															<th scope="row">No</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_three_address_no" 
																					id="employer_applicant_prev_three_address_no"
																					v-model="form.employer_applicant_prev_three_address_no"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_three_address_no" 
																					id="employer_coapplicant_prev_three_address_no"
																					v-model="form.employer_coapplicant_prev_three_address_no"></td>
														</tr>
														<tr>
															<th scope="row">Street</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_three_street" 
																					id="employer_applicant_prev_three_street"
																					v-model="form.applicant_prev_three_street"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_three_street" 
																					id="employer_coapplicant_prev_three_street"
																					v-model="form.employer_coapplicant_prev_three_street"></td>
														</tr>
														<tr>
															<th scope="row">City</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_three_city" 
																					id="employer_applicant_prev_three_city"
																					v-model="form.applicant_prev_three_city"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_three_city" 
																					id="employer_coapplicant_prev_three_city"
																					v-model="form.employer_coapplicant_prev_three_city"></td>
														</tr>
														<tr>
															<th scope="row">State/ Province</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_three_state" 
																					id="employer_applicant_prev_three_state"
																					v-model="form.applicant_prev_three_state"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_three_state" 
																					id="employer_coapplicant_prev_three_state"
																					v-model="form.employer_coapplicant_prev_three_state"></td>
														</tr>
														<tr>
															<th scope="row">Country</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_three_country" 
																					id="employer_applicant_prev_three_country"
																					v-model="form.applicant_prev_three_country"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_three_country" 
																					id="employer_coapplicant_prev_three_country"
																					v-model="form.employer_coapplicant_prev_three_country"></td>
														</tr>
														<tr>
															<th scope="row">Zip/Postal Code</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_three_zip" 
																					id="employer_applicant_prev_three_zip"
																					v-model="form.applicant_prev_three_zip"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_three_zip" 
																					id="employer_coapplicant_prev_three_zip"
																					v-model="form.employer_coapplicant_prev_three_zip"></td>
														</tr>
														<caption>Contact</caption>
														<tr>
															<th scope="row">Ph. Home</th>
															<td><input type="text" value="" 
																					name="employer_prev_three_applicant_ph_home" 
																					id="employer_prev_three_applicant_ph_home"
																					v-model="form.applicant_ph_home"></td>
															<td><input type="text" value="" 
																					name="employer_prev_three_applicant_ph_home" 
																					id="employer_prev_three_applicant_ph_home"
																					v-model="form.employer_prev_three_applicant_ph_home"></td>
														</tr>
														<tr>
															<th scope="row">Ph. Work</th>
															<td><input type="text" value="" 
																					name="employer_prev_three_applicant_ph_work" 
																					id="employer_prev_three_applicant_ph_work"
																					v-model="form.applicant_ph_work"></td>
															<td><input type="text" value="" 
																					name="employer_prev_three_coapplicant_ph_work" 
																					id="employer_prev_three_coapplicant_ph_work"
																					v-model="form.employer_prev_three_coapplicant_ph_work"></td>
														</tr>
														<tr>
															<th scope="row">Ph. Mobile</th>
															<td><input type="text" value="" 
																					name="employer_prev_three_applicant_ph_mobile" 
																					id="employer_prev_three_applicant_ph_mobile"
																					v-model="form.applicant_ph_mobile"></td>
															<td><input type="text" value="" 
																					name="employer_prev_three_coapplicant_ph_mobile" 
																					id="employer_prev_three_coapplicant_ph_mobile"
																					v-model="form.employer_prev_three_coapplicant_ph_mobile"></td>
														</tr>
														<tr>
															<th scope="row">Email 1</th>
															<td><input type="text" value="" 
																					name="employer_prev_three_applicant_email_one" 
																					id="employer_prev_three_applicant_email_one"
																					v-model="form.applicant_email_one"></td>
															<td><input type="text" value="" 
																					name="employer_prev_three_coapplicant_email_one" 
																					id="employer_prev_three_coapplicant_email_one"
																					v-model="form.employer_prev_three_coapplicant_email_one"></td>
														</tr>
														<tr>
															<th scope="row">Email 2</th>
															<td><input type="text" value="" 
																					name="employer_prev_three_applicant_email_two" 
																					id="employer_prev_three_applicant_email_two"
																					v-model="form.applicant_email_two"></td>
															<td><input type="text" value="" 
																					name="employer_prev_three_coapplicant_email_two" 
																					id="employer_prev_three_coapplicant_email_two"
																					v-model="form.employer_prev_three_coapplicant_email_two"></td>
														</tr>
														<tr>
															<th scope="row">Fax</th>
															<td><input type="text" value="" 
																					name="employer_prev_three_applicant_fax" 
																					id="employer_prev_three_applicant_fax"
																					v-model="form.applicant_fax"></td>
															<td><input type="text" value="" 
																					name="employer_prev_three_coapplicant_fax" 
																					id="employer_prev_three_coapplicant_fax"
																					v-model="form.employer_prev_three_coapplicant_fax"></td>
														</tr>
														<tr>
															<th scope="row">Website</th>
															<td><input type="text" value="" 
																					name="employer_prev_three_applicant_website" 
																					id="employer_prev_three_applicant_website"
																					v-model="form.applicant_website"></td>
															<td><input type="text" value="" 
																					name="employer_prev_three_coapplicant_website" 
																					id="employer_prev_three_coapplicant_website"
																					v-model="form.employer_prev_three_coapplicant_website"></td>
														</tr>
														<tr>
															<th scope="row">Employment Period</th>
															<td><input type="date" value="" 
																					name="employer_prev_three_applicant_emp_period" 
																					id="employer_prev_three_applicant_emp_period"
																					v-model="form.applicant_emp_period"></td>
															<td><input type="date" value="" 
																					name="employer_prev_three_coapplicant_emp_period" 
																					id="employer_prev_three_coapplicant_emp_period"
																					v-model="form.employer_prev_three_coapplicant_emp_period"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i>Previous Employer 2   :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col"></th>
															<th scope="col">Applicant </th>
															<th scope="col">Co Applicant</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Company</th>
															<td><input type="text" value="" 
																					name="prev_two_company_applicant" 
																					id="prev_two_company_applicant"
																					v-model="form.prev_two_company_applicant"></td>
															<td><input type="text" value="" 
																					name="prev_two_company_coapplicant" 
																					id="prev_two_company_coapplicant"
																					v-model="form.prev_two_company_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">Manager's Name </th>
															<td><input type="text" value="" 
																					name="prev_two_manager_applicant" 
																					id="prev_two_manager_applicant"
																					v-model="form.prev_two_manager_applicant"></td>
															<td><input type="text" value="" 
																					name="prev_two_manager_coapplicant" 
																					id="prev_two_manager_coapplicant"
																					v-model="form.prev_two_manager_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">/ Supervisor's Name </th>
															<td><input type="text" value="" 
																					name="prev_two_supervisor_applicant" 
																					id="prev_two_supervisor_applicant"
																					v-model="form.prev_two_supervisor_applicant"></td>
															<td><input type="text" value="" 
																					name="prev_two_supervisor_coapplicant" 
																					id="prev_two_supervisor_coapplicant"
																					v-model="form.prev_two_supervisor_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">Job Title </th>
															<td><input type="text" value="" 
																					name="prev_two_job_title_applicant" 
																					id="prev_two_job_title_applicant"
																					v-model="form.prev_two_job_title_applicant"></td>
															<td><input type="text" value="" 
																					name="prev_two_job_title_coapplicant" 
																					id="prev_two_job_title_coapplicant"
																					v-model="form.prev_two_job_title_coapplicant"></td>
														</tr>
														<caption>Address</caption>
														<tr>
															<th scope="row">No</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_two_address_no" 
																					id="employer_applicant_prev_two_address_no"
																					v-model="form.employer_applicant_prev_two_address_no"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_two_address_no" 
																					id="employer_coapplicant_prev_two_address_no"
																					v-model="form.employer_coapplicant_prev_two_address_no"></td>
														</tr>
														<tr>
															<th scope="row">Street</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_two_street" 
																					id="employer_applicant_prev_two_street"
																					v-model="form.applicant_prev_two_street"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_two_street" 
																					id="employer_coapplicant_prev_two_street"
																					v-model="form.employer_coapplicant_prev_two_street"></td>
														</tr>
														<tr>
															<th scope="row">City</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_two_city" 
																					id="employer_applicant_prev_two_city"
																					v-model="form.applicant_prev_two_city"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_two_city" 
																					id="employer_coapplicant_prev_two_city"
																					v-model="form.employer_coapplicant_prev_two_city"></td>
														</tr>
														<tr>
															<th scope="row">State/ Province</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_two_state" 
																					id="employer_applicant_prev_two_state"
																					v-model="form.applicant_prev_two_state"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_two_state" 
																					id="employer_coapplicant_prev_two_state"
																					v-model="form.employer_coapplicant_prev_two_state"></td>
														</tr>
														<tr>
															<th scope="row">Country</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_two_country" 
																					id="employer_applicant_prev_two_country"
																					v-model="form.applicant_prev_two_country"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_two_country" 
																					id="employer_coapplicant_prev_two_country"
																					v-model="form.employer_coapplicant_prev_two_country"></td>
														</tr>
														<tr>
															<th scope="row">Zip/Postal Code</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_two_zip" 
																					id="employer_applicant_prev_two_zip"
																					v-model="form.applicant_prev_two_zip"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_two_zip" 
																					id="employer_coapplicant_prev_two_zip"
																					v-model="form.employer_coapplicant_prev_two_zip"></td>
														</tr>
														<caption>Contact</caption>
														<tr>
															<th scope="row">Ph. Home</th>
															<td><input type="text" value="" 
																					name="employer_prev_two_applicant_ph_home" 
																					id="employer_prev_two_applicant_ph_home"
																					v-model="form.applicant_ph_home"></td>
															<td><input type="text" value="" 
																					name="employer_prev_two_applicant_ph_home" 
																					id="employer_prev_two_applicant_ph_home"
																					v-model="form.employer_prev_two_applicant_ph_home"></td>
														</tr>
														<tr>
															<th scope="row">Ph. Work</th>
															<td><input type="text" value="" 
																					name="employer_prev_two_applicant_ph_work" 
																					id="employer_prev_two_applicant_ph_work"
																					v-model="form.applicant_ph_work"></td>
															<td><input type="text" value="" 
																					name="employer_prev_two_coapplicant_ph_work" 
																					id="employer_prev_two_coapplicant_ph_work"
																					v-model="form.employer_prev_two_coapplicant_ph_work"></td>
														</tr>
														<tr>
															<th scope="row">Ph. Mobile</th>
															<td><input type="text" value="" 
																					name="employer_prev_two_applicant_ph_mobile" 
																					id="employer_prev_two_applicant_ph_mobile"
																					v-model="form.applicant_ph_mobile"></td>
															<td><input type="text" value="" 
																					name="employer_prev_two_coapplicant_ph_mobile" 
																					id="employer_prev_two_coapplicant_ph_mobile"
																					v-model="form.employer_prev_two_coapplicant_ph_mobile"></td>
														</tr>
														<tr>
															<th scope="row">Email 1</th>
															<td><input type="text" value="" 
																					name="employer_prev_two_applicant_email_one" 
																					id="employer_prev_two_applicant_email_one"
																					v-model="form.applicant_email_one"></td>
															<td><input type="text" value="" 
																					name="employer_prev_two_coapplicant_email_one" 
																					id="employer_prev_two_coapplicant_email_one"
																					v-model="form.employer_prev_two_coapplicant_email_one"></td>
														</tr>
														<tr>
															<th scope="row">Email 2</th>
															<td><input type="text" value="" 
																					name="employer_prev_two_applicant_email_two" 
																					id="employer_prev_two_applicant_email_two"
																					v-model="form.applicant_email_two"></td>
															<td><input type="text" value="" 
																					name="employer_prev_two_coapplicant_email_two" 
																					id="employer_prev_two_coapplicant_email_two"
																					v-model="form.employer_prev_two_coapplicant_email_two"></td>
														</tr>
														<tr>
															<th scope="row">Fax</th>
															<td><input type="text" value="" 
																					name="employer_prev_two_applicant_fax" 
																					id="employer_prev_two_applicant_fax"
																					v-model="form.applicant_fax"></td>
															<td><input type="text" value="" 
																					name="employer_prev_two_coapplicant_fax" 
																					id="employer_prev_two_coapplicant_fax"
																					v-model="form.employer_prev_two_coapplicant_fax"></td>
														</tr>
														<tr>
															<th scope="row">Website</th>
															<td><input type="text" value="" 
																					name="employer_prev_two_applicant_website" 
																					id="employer_prev_two_applicant_website"
																					v-model="form.applicant_website"></td>
															<td><input type="text" value="" 
																					name="employer_prev_two_coapplicant_website" 
																					id="employer_prev_two_coapplicant_website"
																					v-model="form.employer_prev_two_coapplicant_website"></td>
														</tr>
														<tr>
															<th scope="row">Employment Period</th>
															<td><input type="date" value="" 
																					name="employer_prev_two_applicant_emp_period" 
																					id="employer_prev_two_applicant_emp_period"
																					v-model="form.applicant_emp_period"></td>
															<td><input type="date" value="" 
																					name="employer_prev_two_coapplicant_emp_period" 
																					id="employer_prev_two_coapplicant_emp_period"
																					v-model="form.employer_prev_two_coapplicant_emp_period"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i>Previous Employer 1  :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col"></th>
															<th scope="col">Applicant </th>
															<th scope="col">Co Applicant</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Company</th>
															<td><input type="text" value="" 
																					name="prev_one_company_applicant" 
																					id="prev_one_company_applicant"
																					v-model="form.prev_one_company_applicant"></td>
															<td><input type="text" value="" 
																					name="prev_one_company_coapplicant" 
																					id="prev_one_company_coapplicant"
																					v-model="form.prev_one_company_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">Manager's Name </th>
															<td><input type="text" value="" 
																					name="prev_one_manager_applicant" 
																					id="prev_one_manager_applicant"
																					v-model="form.prev_one_manager_applicant"></td>
															<td><input type="text" value="" 
																					name="prev_one_manager_coapplicant" 
																					id="prev_one_manager_coapplicant"
																					v-model="form.prev_one_manager_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">Supervisor's Name </th>
															<td><input type="text" value="" 
																					name="prev_one_supervisor_applicant" 
																					id="prev_one_supervisor_applicant"
																					v-model="form.prev_one_supervisor_applicant"></td>
															<td><input type="text" value="" 
																					name="prev_one_supervisor_coapplicant" 
																					id="prev_one_supervisor_coapplicant"
																					v-model="form.prev_one_supervisor_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">Job Title </th>
															<td><input type="text" value="" 
																					name="prev_one_job_title_applicant" 
																					id="prev_one_job_title_applicant"
																					v-model="form.prev_one_job_title_applicant"></td>
															<td><input type="text" value="" 
																					name="prev_one_job_title_coapplicant" 
																					id="prev_one_job_title_coapplicant"
																					v-model="form.prev_one_job_title_coapplicant"></td>
														</tr>
														<caption>Address</caption>
														<tr>
															<th scope="row">No</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_one_address_no" 
																					id="employer_applicant_prev_one_address_no"
																					v-model="form.employer_applicant_prev_one_address_no"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_one_address_no" 
																					id="employer_coapplicant_prev_one_address_no"
																					v-model="form.employer_coapplicant_prev_one_address_no"></td>
														</tr>
														<tr>
															<th scope="row">Street</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_one_street" 
																					id="employer_applicant_prev_one_street"
																					v-model="form.applicant_prev_one_street"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_one_street" 
																					id="employer_coapplicant_prev_one_street"
																					v-model="form.employer_coapplicant_prev_one_street"></td>
														</tr>
														<tr>
															<th scope="row">City</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_one_city" 
																					id="employer_applicant_prev_one_city"
																					v-model="form.applicant_prev_one_city"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_one_city" 
																					id="employer_coapplicant_prev_one_city"
																					v-model="form.employer_coapplicant_prev_one_city"></td>
														</tr>
														<tr>
															<th scope="row">State/ Province</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_one_state" 
																					id="employer_applicant_prev_one_state"
																					v-model="form.applicant_prev_one_state"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_one_state" 
																					id="employer_coapplicant_prev_one_state"
																					v-model="form.employer_coapplicant_prev_one_state"></td>
														</tr>
														<tr>
															<th scope="row">Country</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_one_country" 
																					id="employer_applicant_prev_one_country"
																					v-model="form.applicant_prev_one_country"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_one_country" 
																					id="employer_coapplicant_prev_one_country"
																					v-model="form.employer_coapplicant_prev_one_country"></td>
														</tr>
														<tr>
															<th scope="row">Zip/Postal Code</th>
															<td><input type="text" value="" 
																					name="employer_applicant_prev_one_zip" 
																					id="employer_applicant_prev_one_zip"
																					v-model="form.applicant_prev_one_zip"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_prev_one_zip" 
																					id="employer_coapplicant_prev_one_zip"
																					v-model="form.employer_coapplicant_prev_one_zip"></td>
														</tr>
														<caption>Contact</caption>
														<tr>
															<th scope="row">Ph. Home</th>
															<td><input type="text" value="" 
																					name="employer_prev_one_applicant_ph_home" 
																					id="employer_prev_one_applicant_ph_home"
																					v-model="form.applicant_ph_home"></td>
															<td><input type="text" value="" 
																					name="employer_prev_one_applicant_ph_home" 
																					id="employer_prev_one_applicant_ph_home"
																					v-model="form.employer_prev_one_applicant_ph_home"></td>
														</tr>
														<tr>
															<th scope="row">Ph. Work</th>
															<td><input type="text" value="" 
																					name="employer_prev_one_applicant_ph_work" 
																					id="employer_prev_one_applicant_ph_work"
																					v-model="form.applicant_ph_work"></td>
															<td><input type="text" value="" 
																					name="employer_prev_one_coapplicant_ph_work" 
																					id="employer_prev_one_coapplicant_ph_work"
																					v-model="form.employer_prev_one_coapplicant_ph_work"></td>
														</tr>
														<tr>
															<th scope="row">Ph. Mobile</th>
															<td><input type="text" value="" 
																					name="employer_prev_one_applicant_ph_mobile" 
																					id="employer_prev_one_applicant_ph_mobile"
																					v-model="form.applicant_ph_mobile"></td>
															<td><input type="text" value="" 
																					name="employer_prev_one_coapplicant_ph_mobile" 
																					id="employer_prev_one_coapplicant_ph_mobile"
																					v-model="form.employer_prev_one_coapplicant_ph_mobile"></td>
														</tr>
														<tr>
															<th scope="row">Email 1</th>
															<td><input type="text" value="" 
																					name="employer_prev_one_applicant_email_one" 
																					id="employer_prev_one_applicant_email_one"
																					v-model="form.applicant_email_one"></td>
															<td><input type="text" value="" 
																					name="employer_prev_one_coapplicant_email_one" 
																					id="employer_prev_one_coapplicant_email_one"
																					v-model="form.employer_prev_one_coapplicant_email_one"></td>
														</tr>
														<tr>
															<th scope="row">Email 2</th>
															<td><input type="text" value="" 
																					name="employer_prev_one_applicant_email_two" 
																					id="employer_prev_one_applicant_email_two"
																					v-model="form.applicant_email_two"></td>
															<td><input type="text" value="" 
																					name="employer_prev_one_coapplicant_email_two" 
																					id="employer_prev_one_coapplicant_email_two"
																					v-model="form.employer_prev_one_coapplicant_email_two"></td>
														</tr>
														<tr>
															<th scope="row">Fax</th>
															<td><input type="text" value="" 
																					name="employer_prev_one_applicant_fax" 
																					id="employer_prev_one_applicant_fax"
																					v-model="form.applicant_fax"></td>
															<td><input type="text" value="" 
																					name="employer_prev_one_coapplicant_fax" 
																					id="employer_prev_one_coapplicant_fax"
																					v-model="form.employer_prev_one_coapplicant_fax"></td>
														</tr>
														<tr>
															<th scope="row">Website</th>
															<td><input type="text" value="" 
																					name="employer_prev_one_applicant_website" 
																					id="employer_prev_one_applicant_website"
																					v-model="form.applicant_website"></td>
															<td><input type="text" value="" 
																					name="employer_prev_one_coapplicant_website" 
																					id="employer_prev_one_coapplicant_website"
																					v-model="form.employer_prev_one_coapplicant_website"></td>
														</tr>
														<tr>
															<th scope="row">Employment Period</th>
															<td><input type="date" value="" 
																					name="employer_prev_one_applicant_emp_period" 
																					id="employer_prev_one_applicant_emp_period"
																					v-model="form.applicant_emp_period"></td>
															<td><input type="date" value="" 
																					name="employer_prev_one_coapplicant_emp_period" 
																					id="employer_prev_one_coapplicant_emp_period"
																					v-model="form.employer_prev_one_coapplicant_emp_period"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i>Income Sources   :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col">Income Sources </th> 
															<th scope="col">Applicant </th>
															<th scope="col">Co Applicant</th>
															<th scope="col">Total Income</th>
															<th scope="col">Comment</th>
														</tr>
													</thead>
													<tbody>
														<caption>Income From Employment</caption>
														<tr>
															<th scope="row">Employer 1</th>
															<td><input type="text" value="" 
																					name="employer_one_applicant_income" 
																					id="employer_one_applicant_income"
																					v-model="form.employer_one_applicant_income"></td>
															<td><input type="text" value="" 
																					name="employer_one_coapplicant_income" 
																					id="employer_one_coapplicant_income"
																					v-model="form.employer_one_coapplicant_income"></td>
															<td><input type="number" value="" 
																					name="employer_one_coapplicant_total_income" 
																					id="employer_one_coapplicant_total_income"
																					v-model="form.employer_one_coapplicant_total_income"></td>
															<td><input type="text" value="" 
																					name="employer_one_coapplicant_comment" 
																					id="employer_one_coapplicant_comment"
																					v-model="form.employer_one_coapplicant_comment"></td>
														</tr>
														<tr>
															<th scope="row">Employer 2</th>
															<td><input type="text" value="" 
																					name="employer_two_applicant_income" 
																					id="employer_two_applicant_income"
																					v-model="form.employer_two_applicant_income"></td>
															<td><input type="text" value="" 
																					name="employer_two_coapplicant_income" 
																					id="employer_two_coapplicant_income"
																					v-model="form.employer_two_coapplicant_income"></td>
															<td><input type="number" value="" 
																					name="employer_two_coapplicant_total_income" 
																					id="employer_two_coapplicant_total_income"
																					v-model="form.employer_two_coapplicant_total_income"></td>
															<td><input type="text" value="" 
																					name="employer_two_comment" 
																					id="employer_two_comment"
																					v-model="form.employer_two_comment"></td>
														</tr>
														<tr>
															<th scope="row">Employer 3</th>
															<td><input type="text" value="" 
																					name="employer_three_applicant_income" 
																					id="employer_three_applicant_income"
																					v-model="form.employer_three_applicant_income"></td>
															<td><input type="text" value="" 
																					name="employer_three_coapplicant_income" 
																					id="employer_three_coapplicant_income"
																					v-model="form.employer_three_coapplicant_income"></td>
															<td><input type="number" value="" 
																					name="employer_three_total_income" 
																					id="employer_three_coapplicant_total_income"
																					v-model="form.employer_three_total_income"></td>
															<td><input type="text" value="" 
																					name="employer_three_comment" 
																					id="employer_three_coapplicant_comment"
																					v-model="form.employer_three_comment"></td>
														</tr>
														<tr>
															<th scope="row">Total</th>
															<td><input type="text" value="" 
																					name="employer_applicant_sub_income" 
																					id="employer_applicant_sub_income"
																					v-model="form.employer_applicant_sub_income"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_sub_income" 
																					id="employer_coapplicant_sub_income"
																					v-model="form.employer_coapplicant_sub_income"></td>
															<td><input type="number" value="" 
																					name="employer_coapplicant_total_sub_income" 
																					id="employer_coapplicant_total_sub_income"
																					v-model="form.employer_coapplicant_total_sub_income"></td>
															<td><input type="text" value="" 
																					name="employer_coapplicant_sub_comment" 
																					id="employer_coapplicant_sub_comment"
																					v-model="form.employer_coapplicant_sub_comment"></td>
														</tr>
														<caption>Income from Self- Employed </caption>
														<tr>
															<th scope="row">Source 1</th>
															<td><input type="text" value="" 
																					name="source_one_applicant_income" 
																					id="source_one_applicant_income"
																					v-model="form.source_one_applicant_income"></td>
															<td><input type="text" value="" 
																					name="source_one_coapplicant_income" 
																					id="source_one_coapplicant_income"
																					v-model="form.source_one_coapplicant_income"></td>
															<td><input type="number" value="" 
																					name="source_one_coapplicant_total_income" 
																					id="source_one_coapplicant_total_income"
																					v-model="form.source_one_coapplicant_total_income"></td>
															<td><input type="text" value="" 
																					name="source_one_coapplicant_comment" 
																					id="source_one_coapplicant_comment"
																					v-model="form.source_one_coapplicant_comment"></td>
														</tr>
														<tr>
															<th scope="row">Source 2</th>
															<td><input type="text" value="" 
																					name="source_two_applicant_income" 
																					id="source_two_applicant_income"
																					v-model="form.source_two_applicant_income"></td>
															<td><input type="text" value="" 
																					name="source_two_coapplicant_income" 
																					id="source_two_coapplicant_income"
																					v-model="form.source_two_coapplicant_income"></td>
															<td><input type="number" value="" 
																					name="source_two_coapplicant_total_income" 
																					id="source_two_coapplicant_total_income"
																					v-model="form.source_two_coapplicant_total_income"></td>
															<td><input type="text" value="" 
																					name="source_two_coapplicant_comment" 
																					id="source_two_coapplicant_comment"
																					v-model="form.source_two_coapplicant_comment"></td>
														</tr>
														<tr>
															<th scope="row">Source 3</th>
															<td><input type="text" value="" 
																					name="source_three_applicant_income" 
																					id="source_three_applicant_income"
																					v-model="form.source_three_applicant_income"></td>
															<td><input type="text" value="" 
																					name="source_three_coapplicant_income" 
																					id="source_three_coapplicant_income"
																					v-model="form.source_three_coapplicant_income"></td>
															<td><input type="number" value="" 
																					name="source_three_coapplicant_total_income" 
																					id="source_three_coapplicant_total_income"
																					v-model="form.source_three_coapplicant_total_income"></td>
															<td><input type="text" value="" 
																					name="source_three_coapplicant_comment" 
																					id="source_three_coapplicant_comment"
																					v-model="form.source_three_coapplicant_comment"></td>
														</tr>
														<tr>
															<th scope="row">Source 4</th>
															<td><input type="text" value="" 
																					name="source_four_applicant_income" 
																					id="source_four_applicant_income"
																					v-model="form.source_four_applicant_income"></td>
															<td><input type="text" value="" 
																					name="source_four_coapplicant_income" 
																					id="source_four_coapplicant_income"
																					v-model="form.source_four_coapplicant_income"></td>
															<td><input type="number" value="" 
																					name="source_four_coapplicant_total_income" 
																					id="source_four_coapplicant_total_income"
																					v-model="form.source_four_coapplicant_total_income"></td>
															<td><input type="text" value="" 
																					name="source_four_coapplicant_comment" 
																					id="source_four_coapplicant_comment"
																					v-model="form.source_four_coapplicant_comment"></td>
														</tr>
														<tr>
															<th scope="row">Total</th>
															<td><input type="text" value="" 
																					name="source_applicant_sub_income" 
																					id="source_applicant_sub_income"
																					v-model="form.source_applicant_sub_income"></td>
															<td><input type="text" value="" 
																					name="source_coapplicant_sub_income" 
																					id="source_coapplicant_sub_income"
																					v-model="form.source_coapplicant_sub_income"></td>
															<td><input type="number" value="" 
																					name="source_coapplicant_total_sub_income" 
																					id="source_coapplicant_total_sub_income"
																					v-model="form.source_coapplicant_total_sub_income"></td>
															<td><input type="text" value="" 
																					name="source_coapplicant_sub_comment" 
																					id="source_coapplicant_sub_comment"
																					v-model="form.source_coapplicant_sub_comment"></td>
														</tr>
														<caption>Other Income Sources  </caption>
														<tr>
															<th scope="row">Source 1</th>
															<td><input type="text" value="" 
																					name="other_source_one_applicant_income" 
																					id="other_source_one_applicant_income"
																					v-model="form.other_source_one_applicant_income"></td>
															<td><input type="text" value="" 
																					name="other_source_one_coapplicant_income" 
																					id="other_source_one_coapplicant_income"
																					v-model="form.other_source_one_coapplicant_income"></td>
															<td><input type="number" value="" 
																					name="other_source_one_coapplicant_total_income" 
																					id="other_source_one_coapplicant_total_income"
																					v-model="form.other_source_one_coapplicant_total_income"></td>
															<td><input type="text" value="" 
																					name="other_source_one_coapplicant_comment" 
																					id="other_source_one_coapplicant_comment"
																					v-model="form.other_source_one_coapplicant_comment"></td>
														</tr>
														<tr>
															<th scope="row">Source 2</th>
															<td><input type="text" value="" 
																					name="other_source_two_applicant_income" 
																					id="other_source_two_applicant_income"
																					v-model="form.other_source_two_applicant_income"></td>
															<td><input type="text" value="" 
																					name="other_source_two_coapplicant_income" 
																					id="other_source_two_coapplicant_income"
																					v-model="form.other_source_two_coapplicant_income"></td>
															<td><input type="number" value="" 
																					name="other_source_two_coapplicant_total_income" 
																					id="other_source_two_coapplicant_total_income"
																					v-model="form.other_source_two_coapplicant_total_income"></td>
															<td><input type="text" value="" 
																					name="other_source_two_coapplicant_comment" 
																					id="other_source_two_coapplicant_comment"
																					v-model="form.other_source_two_coapplicant_comment"></td>
														</tr>
														<tr>
															<th scope="row">Source 3</th>
															<td><input type="text" value="" 
																					name="other_source_three_applicant_income" 
																					id="other_source_three_applicant_income"
																					v-model="form.other_source_three_applicant_income"></td>
															<td><input type="text" value="" 
																					name="other_source_three_coapplicant_income" 
																					id="other_source_three_coapplicant_income"
																					v-model="form.other_source_three_coapplicant_income"></td>
															<td><input type="number" value="" 
																					name="other_source_three_coapplicant_total_income" 
																					id="other_source_three_coapplicant_total_income"
																					v-model="form.other_source_three_coapplicant_total_income"></td>
															<td><input type="text" value="" 
																					name="other_source_three_coapplicant_comment" 
																					id="other_source_three_coapplicant_comment"
																					v-model="form.other_source_three_coapplicant_comment"></td>
														</tr>
														<tr>
															<th scope="row">Total</th>
															<td><input type="text" value="" 
																					name="other_source_applicant_sub_income" 
																					id="other_source_applicant_sub_income"
																					v-model="form.other_source_applicant_sub_income"></td>
															<td><input type="text" value="" 
																					name="other_source_coapplicant_sub_income" 
																					id="other_source_coapplicant_sub_income"
																					v-model="form.other_source_coapplicant_sub_income"></td>
															<td><input type="number" value="" 
																					name="other_source_coapplicant_total_sub_income" 
																					id="other_source_coapplicant_total_sub_income"
																					v-model="form.other_source_coapplicant_total_sub_income"></td>
															<td><input type="text" value="" 
																					name="other_source_coapplicant_sub_comment" 
																					id="other_source_coapplicant_sub_comment"
																					v-model="form.other_source_coapplicant_sub_comment"></td>
														</tr>
														<br>
														<tr>
															<th scope="row">Total</th>
															<td><input type="text" value="" 
																					name="applicant_grand_income" 
																					id="applicant_grand_income"
																					v-model="form.applicant_grand_income"></td>
															<td><input type="text" value="" 
																					name="coapplicant_grand_income" 
																					id="coapplicant_grand_income"
																					v-model="form.coapplicant_grand_income"></td>
															<td><input type="number" value="" 
																					name="coapplicant_total_grand_income" 
																					id="coapplicant_total_grand_income"
																					v-model="form.coapplicant_total_grand_income"></td>
															<td><input type="text" value="" 
																					name="coapplicant_grand_comment" 
																					id="coapplicant_grand_comment"
																					v-model="form.coapplicant_grand_comment"></td>
														</tr>
														
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i>Education    :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col">Education Level  </th> 
															<th scope="col">Applicant </th>
															<th scope="col">Co Applicant</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Under Diploma</th>
															<td><input type="checkbox" 
									                        	id="edu_applicant_under_diploma" 
									                        	name="edu_applicant_under_diploma" 
									                        	v-model="form.edu_applicant_under_diploma"></td>
															<td><input type="checkbox" 
									                        	id="edu_coapplicant_under_diploma" 
									                        	name="edu_coapplicant_under_diploma" 
									                        	v-model="form.edu_coapplicant_under_diploma"></td>
														</tr>
														<tr>
															<th scope="row">Certificate </th>
															<td><input type="checkbox" 
									                        	id="edu_applicant_certificate" 
									                        	name="edu_applicant_certificate" 
									                        	v-model="form.edu_applicant_certificate"></td>
															<td><input type="checkbox" 
									                        	id="edu_coapplicant_certificate" 
									                        	name="edu_coapplicant_certificate" 
									                        	v-model="form.edu_coapplicant_certificate"></td>
														</tr>
														<tr>
															<th scope="row">Collage/University Diploma</th>
															<td><input type="checkbox" 
									                        	id="edu_applicant_collage" 
									                        	name="edu_applicant_collage" 
									                        	v-model="form.edu_applicant_collage"></td>
															<td><input type="checkbox" 
									                        	id="edu_coapplicant_collage" 
									                        	name="edu_coapplicant_collage" 
									                        	v-model="form.edu_coapplicant_collage"></td>
														</tr>
														<tr>
															<th scope="row">Bachelor Degree</th>
															<td><input type="checkbox" 
									                        	id="edu_applicant_bachelor_degree" 
									                        	name="edu_applicant_bachelor_degree" 
									                        	v-model="form.edu_applicant_bachelor_degree"></td>
															<td><input type="checkbox" 
									                        	id="edu_coapplicant_bachelor_degree" 
									                        	name="edu_coapplicant_bachelor_degree" 
									                        	v-model="form.edu_coapplicant_bachelor_degree"></td>
														</tr>
														<tr>
															<th scope="row">Master Degree</th>
															<td><input type="checkbox" 
									                        	id="edu_applicant_master_degree" 
									                        	name="edu_applicant_master_degree" 
									                        	v-model="form.edu_applicant_master_degree"></td>
															<td><input type="checkbox" 
									                        	id="edu_coapplicant_master_degree" 
									                        	name="edu_coapplicant_master_degree" 
									                        	v-model="form.edu_coapplicant_master_degree"></td>
														</tr>
														<tr>
															<th scope="row">PhD.</th>
															<td><input type="checkbox" 
									                        	id="edu_applicant_phd" 
									                        	name="edu_applicant_phd" 
									                        	v-model="form.edu_applicant_phd"></td>
															<td><input type="checkbox" 
									                        	id="edu_coapplicant_phd" 
									                        	name="edu_coapplicant_phd" 
									                        	v-model="form.edu_coapplicant_phd"></td>
														</tr>
														<caption>School Profile </caption>
														<tr>
															<th scope="row">Name</th>
															<td><input type="text" value="" 
																					name="school_name_applicant" 
																					id="school_name_applicant"
																					v-model="form.school_name_applicant"></td>
															<td><input type="text" value="" 
																					name="school_name_coapplicant" 
																					id="school_name_coapplicant"
																					v-model="form.school_name_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">Address</th>
															<td><input type="text" value="" 
																					name="school_address_applicant" 
																					id="school_address_applicant"
																					v-model="form.school_address_applicant"></td>
															<td><input type="text" value="" 
																					name="school_address_coapplicant" 
																					id="school_address_coapplicant"
																					v-model="form.school_address_coapplicant"></td>
														</tr>
														<tr>
															<th scope="row">No</th>
															<td><input type="text" value="" 
																					name="school_address_applicant_no" 
																					id="school_address_applicant_no"
																					v-model="form.school_address_applicant_no"></td>
															<td><input type="text" value="" 
																					name="school_address_coapplicant_no" 
																					id="school_address_coapplicant_no"
																					v-model="form.school_address_coapplicant_no"></td>
														</tr>
														<tr>
															<th scope="row">Street</th>
															<td><input type="text" value="" 
																					name="school_address_applicant_street" 
																					id="school_address_applicant_street"
																					v-model="form.school_address_applicant_street"></td>
															<td><input type="text" value="" 
																					name="school_address_coapplicant_street" 
																					id="school_address_coapplicant_street"
																					v-model="form.school_address_coapplicant_street"></td>
														</tr>
														<tr>
															<th scope="row">City</th>
															<td><input type="text" value="" 
																					name="school_address_applicant_city" 
																					id="school_address_applicant_city"
																					v-model="form.school_address_applicant_city"></td>
															<td><input type="text" value="" 
																					name="school_address_coapplicant_city" 
																					id="school_address_coapplicant_city"
																					v-model="form.school_address_coapplicant_city"></td>
														</tr>
														<tr>
															<th scope="row">State/ Province</th>
															<td><input type="text" value="" 
																					name="school_address_applicant_state" 
																					id="school_address_applicant_state"
																					v-model="form.school_address_applicant_state"></td>
															<td><input type="text" value="" 
																					name="school_address_coapplicant_state" 
																					id="school_address_coapplicant_state"
																					v-model="form.school_address_coapplicant_state"></td>
														</tr>
														<tr>
															<th scope="row">Country</th>
															<td><input type="text" value="" 
																					name="school_address_applicant_country" 
																					id="school_address_applicant_country"
																					v-model="form.school_address_applicant_country"></td>
															<td><input type="text" value="" 
																					name="school_address_coapplicant_country" 
																					id="school_address_coapplicant_country"
																					v-model="form.school_address_coapplicant_country"></td>
														</tr>
														<tr>
															<th scope="row">Zip/Postal Code</th>
															<td><input type="text" value="" 
																					name="school_address_applicant_zip" 
																					id="school_address_applicant_zip"
																					v-model="form.school_address_applicant_zip"></td>
															<td><input type="text" value="" 
																					name="school_address_coapplicant_zip" 
																					id="school_address_coapplicant_zip"
																					v-model="form.school_address_coapplicant_zip"></td>
														</tr>
														<caption>Contact</caption>
														<tr>
															<th scope="row">Ph. Home</th>
															<td><input type="text" value="" 
																					name="school_applicant_ph_home" 
																					id="school_applicant_ph_home"
																					v-model="form.applicant_ph_home"></td>
															<td><input type="text" value="" 
																					name="school_applicant_ph_home" 
																					id="school_applicant_ph_home"
																					v-model="form.school_applicant_ph_home"></td>
														</tr>
														<tr>
															<th scope="row">Ph. Work</th>
															<td><input type="text" value="" 
																					name="school_applicant_ph_work" 
																					id="school_applicant_ph_work"
																					v-model="form.applicant_ph_work"></td>
															<td><input type="text" value="" 
																					name="school_coapplicant_ph_work" 
																					id="school_coapplicant_ph_work"
																					v-model="form.school_coapplicant_ph_work"></td>
														</tr>
														<tr>
															<th scope="row">Ph. Mobile</th>
															<td><input type="text" value="" 
																					name="school_applicant_ph_mobile" 
																					id="school_applicant_ph_mobile"
																					v-model="form.applicant_ph_mobile"></td>
															<td><input type="text" value="" 
																					name="school_coapplicant_ph_mobile" 
																					id="school_coapplicant_ph_mobile"
																					v-model="form.school_coapplicant_ph_mobile"></td>
														</tr>
														<tr>
															<th scope="row">Email 1</th>
															<td><input type="text" value="" 
																					name="school_applicant_email_one" 
																					id="school_applicant_email_one"
																					v-model="form.applicant_email_one"></td>
															<td><input type="text" value="" 
																					name="school_coapplicant_email_one" 
																					id="school_coapplicant_email_one"
																					v-model="form.school_coapplicant_email_one"></td>
														</tr>
														<tr>
															<th scope="row">Email 2</th>
															<td><input type="text" value="" 
																					name="school_applicant_email_two" 
																					id="school_applicant_email_two"
																					v-model="form.applicant_email_two"></td>
															<td><input type="text" value="" 
																					name="school_coapplicant_email_two" 
																					id="school_coapplicant_email_two"
																					v-model="form.school_coapplicant_email_two"></td>
														</tr>
														<tr>
															<th scope="row">Fax</th>
															<td><input type="text" value="" 
																					name="school_applicant_fax" 
																					id="school_applicant_fax"
																					v-model="form.applicant_fax"></td>
															<td><input type="text" value="" 
																					name="school_coapplicant_fax" 
																					id="school_coapplicant_fax"
																					v-model="form.school_coapplicant_fax"></td>
														</tr>
														<tr>
															<th scope="row">Website</th>
															<td><input type="text" value="" 
																					name="school_applicant_website" 
																					id="school_applicant_website"
																					v-model="form.applicant_website"></td>
															<td><input type="text" value="" 
																					name="school_coapplicant_website" 
																					id="school_coapplicant_website"
																					v-model="form.school_coapplicant_website"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col">Screening </th>
															<th scope="col">Applicant </th>
															<th scope="col">Co-Applicant </th>
															<th scope="col">Dependent 1</th>
															<th scope="col">Dependent 2</th>
															<th scope="col">Dependent 3</th>
															<th scope="col">Dependent 4</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Credit checks</th>
															<td><input type="text" value="" 
																					name="applicant_credit_checks" 
																					id="applicant_credit_checks"
																					v-model="form.applicant_credit_checks"></td>
															<td><input type="text" value="" 
																					name="coapplicant_credit_checks" 
																					id="coapplicant_credit_checks"
																					v-model="form.coapplicant_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_one_credit_checks" 
																					id="dependent_one_credit_checks"
																					v-model="form.dependent_one_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_two_credit_checks" 
																					id="dependent_two_credit_checks"
																					v-model="form.dependent_two_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_three_credit_checks" 
																					id="dependent_three_credit_checks"
																					v-model="form.dependent_three_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_four_credit_checks" 
																					id="dependent_four_credit_checks"
																					v-model="form.dependent_four_credit_checks"></td>
														</tr>
														<tr>
															<th scope="row">Background Check</th>
															<td><input type="text" value="" 
																					name="applicant_background_credit_checks" 
																					id="applicant_background_credit_checks"
																					v-model="form.applicant_background_credit_checks"></td>
															<td><input type="text" value="" 
																					name="coapplicant_background_credit_checks" 
																					id="coapplicant_background_credit_checks"
																					v-model="form.coapplicant_background_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_one_background_credit_checks" 
																					id="dependent_one_background_credit_checks"
																					v-model="form.dependent_one_background_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_two_background_credit_checks" 
																					id="dependent_two_background_credit_checks"
																					v-model="form.dependent_two_background_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_three_background_credit_checks" 
																					id="dependent_three_background_credit_checks"
																					v-model="form.dependent_three_background_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_four_background_credit_checks" 
																					id="dependent_four_background_credit_checks"
																					v-model="form.dependent_four_background_credit_checks"></td>
														</tr>
														<tr>
															<th scope="row">References</th>
															<td><input type="text" value="" 
																					name="applicant_references" 
																					id="applicant_references"
																					v-model="form.applicant_references"></td>
															<td><input type="text" value="" 
																					name="coapplicant_references" 
																					id="coapplicant_references"
																					v-model="form.coapplicant_references"></td>
															<td><input type="text" value="" 
																					name="dependent_one_references" 
																					id="dependent_one_references"
																					v-model="form.dependent_one_references"></td>
															<td><input type="text" value="" 
																					name="dependent_two_references" 
																					id="dependent_two_references"
																					v-model="form.dependent_two_references"></td>
															<td><input type="text" value="" 
																					name="dependent_three_references" 
																					id="dependent_three_references"
																					v-model="form.dependent_three_references"></td>
															<td><input type="text" value="" 
																					name="dependent_four_references" 
																					id="dependent_four_references"
																					v-model="form.dependent_four_references"></td>
														</tr>
														<tr>
															<th scope="row">Employment References</th>
															<td><input type="text" value="" 
																					name="applicant_employment_references" 
																					id="applicant_employment_references"
																					v-model="form.applicant_employment_references"></td>
															<td><input type="text" value="" 
																					name="coapplicant_employment_references" 
																					id="coapplicant_employment_references"
																					v-model="form.coapplicant_employment_references"></td>
															<td><input type="text" value="" 
																					name="dependent_one_employment_references" 
																					id="dependent_one_employment_references"
																					v-model="form.dependent_one_employment_references"></td>
															<td><input type="text" value="" 
																					name="dependent_two_employment_references" 
																					id="dependent_two_employment_references"
																					v-model="form.dependent_two_employment_references"></td>
															<td><input type="text" value="" 
																					name="dependent_three_employment_references" 
																					id="dependent_three_employment_references"
																					v-model="form.dependent_three_employment_references"></td>
															<td><input type="text" value="" 
																					name="dependent_four_employment_references" 
																					id="dependent_four_employment_references"
																					v-model="form.dependent_four_employment_references"></td>
														</tr>
														<tr>
															<th scope="row">Rental History</th>
															<td><input type="text" value="" 
																					name="applicant_rental_history" 
																					id="applicant_rental_history"
																					v-model="form.applicant_rental_history"></td>
															<td><input type="text" value="" 
																					name="coapplicant_rental_history" 
																					id="coapplicant_rental_history"
																					v-model="form.coapplicant_rental_history"></td>
															<td><input type="text" value="" 
																					name="dependent_one_rental_history" 
																					id="dependent_one_rental_history"
																					v-model="form.dependent_one_rental_history"></td>
															<td><input type="text" value="" 
																					name="dependent_two_rental_history" 
																					id="dependent_two_rental_history"
																					v-model="form.dependent_two_rental_history"></td>
															<td><input type="text" value="" 
																					name="dependent_three_rental_history" 
																					id="dependent_three_rental_history"
																					v-model="form.dependent_three_rental_history"></td>
															<td><input type="text" value="" 
																					name="dependent_four_rental_history" 
																					id="dependent_four_rental_history"
																					v-model="form.dependent_four_rental_history"></td>
														</tr>
														<tr>
															<th scope="row">Evictions</th>
															<td><input type="text" value="" 
																					name="applicant_evictions" 
																					id="applicant_evictions"
																					v-model="form.applicant_evictions"></td>
															<td><input type="text" value="" 
																					name="coapplicant_evictions" 
																					id="coapplicant_evictions"
																					v-model="form.coapplicant_evictions"></td>
															<td><input type="text" value="" 
																					name="dependent_one_evictions" 
																					id="dependent_one_evictions"
																					v-model="form.dependent_one_evictions"></td>
															<td><input type="text" value="" 
																					name="dependent_two_evictions" 
																					id="dependent_two_evictions"
																					v-model="form.dependent_two_evictions"></td>
															<td><input type="text" value="" 
																					name="dependent_three_evictions" 
																					id="dependent_three_evictions"
																					v-model="form.dependent_three_evictions"></td>
															<td><input type="text" value="" 
																					name="dependent_four_evictions" 
																					id="dependent_four_evictions"
																					v-model="form.dependent_four_evictions"></td>
														</tr>
														<tr>
															<th scope="row">School</th>
															<td><input type="text" value="" 
																					name="applicant_school" 
																					id="applicant_school"
																					v-model="form.applicant_school"></td>
															<td><input type="text" value="" 
																					name="coapplicant_school" 
																					id="coapplicant_school"
																					v-model="form.coapplicant_school"></td>
															<td><input type="text" value="" 
																					name="dependent_one_school" 
																					id="dependent_one_school"
																					v-model="form.dependent_one_school"></td>
															<td><input type="text" value="" 
																					name="dependent_two_school" 
																					id="dependent_two_school"
																					v-model="form.dependent_two_school"></td>
															<td><input type="text" value="" 
																					name="dependent_three_school" 
																					id="dependent_three_school"
																					v-model="form.dependent_three_school"></td>
															<td><input type="text" value="" 
																					name="dependent_four_school" 
																					id="dependent_four_school"
																					v-model="form.dependent_four_school"></td>
														</tr>
														<tr>
															<th scope="row">Personal Tax " Notice Of Assessment "</th>
															<td><input type="text" value="" 
																					name="applicant_personal_tax" 
																					id="applicant_personal_tax"
																					v-model="form.applicant_personal_tax"></td>
															<td><input type="text" value="" 
																					name="coapplicant_personal_tax" 
																					id="coapplicant_personal_tax"
																					v-model="form.coapplicant_personal_tax"></td>
															<td><input type="text" value="" 
																					name="dependent_one_personal_tax" 
																					id="dependent_one_personal_tax"
																					v-model="form.dependent_one_personal_tax"></td>
															<td><input type="text" value="" 
																					name="dependent_two_personal_tax" 
																					id="dependent_two_personal_tax"
																					v-model="form.dependent_two_personal_tax"></td>
															<td><input type="text" value="" 
																					name="dependent_three_personal_tax" 
																					id="dependent_three_personal_tax"
																					v-model="form.dependent_three_personal_tax"></td>
															<td><input type="text" value="" 
																					name="dependent_four_personal_tax" 
																					id="dependent_four_personal_tax"
																					v-model="form.dependent_four_personal_tax"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i>Vehicle Information  :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col">Vehicle 1</th>
															<th scope="col">Applicant </th>
															<th scope="col">Co-Applicant </th>
															<th scope="col">Dependent 1</th>
															<th scope="col">Dependent 2</th>
															<th scope="col">Dependent 3</th>
															<th scope="col">Dependent 4</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Made</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_made" 
																					id="applicant_vehicle_made"
																					v-model="form.applicant_vehicle_made"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_made" 
																					id="coapplicant_vehicle_made"
																					v-model="form.coapplicant_vehicle_made"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_made" 
																					id="dependent_one_vehicle_made"
																					v-model="form.dependent_one_vehicle_made"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_made" 
																					id="dependent_two_vehicle_made"
																					v-model="form.dependent_two_vehicle_made"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_made" 
																					id="dependent_three_vehicle_made"
																					v-model="form.dependent_three_vehicle_made"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_made" 
																					id="dependent_four_vehicle_made"
																					v-model="form.dependent_four_vehicle_made"></td>
														</tr>
														<tr>
															<th scope="row">Model</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_model" 
																					id="applicant_vehicle_model"
																					v-model="form.applicant_vehicle_model"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_model" 
																					id="coapplicant_vehicle_model"
																					v-model="form.coapplicant_vehicle_model"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_model" 
																					id="dependent_one_vehicle_model"
																					v-model="form.dependent_one_vehicle_model"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_model" 
																					id="dependent_two_vehicle_model"
																					v-model="form.dependent_two_vehicle_model"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_model" 
																					id="dependent_three_vehicle_model"
																					v-model="form.dependent_three_vehicle_model"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_model" 
																					id="dependent_four_vehicle_model"
																					v-model="form.dependent_four_vehicle_model"></td>
														</tr>
														<tr>
															<th scope="row">Year</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_year" 
																					id="applicant_vehicle_year"
																					v-model="form.applicant_vehicle_year"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_year" 
																					id="coapplicant_vehicle_year"
																					v-model="form.coapplicant_vehicle_year"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_year" 
																					id="dependent_one_vehicle_year"
																					v-model="form.dependent_one_vehicle_year"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_year" 
																					id="dependent_two_vehicle_year"
																					v-model="form.dependent_two_vehicle_year"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_year" 
																					id="dependent_three_vehicle_year"
																					v-model="form.dependent_three_vehicle_year"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_year" 
																					id="dependent_four_vehicle_year"
																					v-model="form.dependent_four_vehicle_year"></td>
														</tr>
														<tr>
															<th scope="row">Paint Color</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_color" 
																					id="applicant_vehicle_color"
																					v-model="form.applicant_vehicle_color"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_color" 
																					id="coapplicant_vehicle_color"
																					v-model="form.coapplicant_vehicle_color"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_color" 
																					id="dependent_one_vehicle_color"
																					v-model="form.dependent_one_vehicle_color"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_color" 
																					id="dependent_two_vehicle_color"
																					v-model="form.dependent_two_vehicle_color"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_color" 
																					id="dependent_three_vehicle_color"
																					v-model="form.dependent_three_vehicle_color"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_color" 
																					id="dependent_four_vehicle_color"
																					v-model="form.dependent_four_vehicle_color"></td>
														</tr>
														<tr>
															<th scope="row">Body Style</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_body_style" 
																					id="applicant_vehicle_body_style"
																					v-model="form.applicant_vehicle_body_style"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_body_style" 
																					id="coapplicant_vehicle_body_style"
																					v-model="form.coapplicant_vehicle_body_style"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_body_style" 
																					id="dependent_one_vehicle_body_style"
																					v-model="form.dependent_one_vehicle_body_style"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_body_style" 
																					id="dependent_two_vehicle_body_style"
																					v-model="form.dependent_two_vehicle_body_style"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_body_style" 
																					id="dependent_three_vehicle_body_style"
																					v-model="form.dependent_three_vehicle_body_style"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_body_style" 
																					id="dependent_four_vehicle_body_style"
																					v-model="form.dependent_four_vehicle_body_style"></td>
														</tr>
														<tr>
															<th scope="row">Number of Doors</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_no_of_door" 
																					id="applicant_vehicle_no_of_door"
																					v-model="form.applicant_vehicle_no_of_door"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_no_of_door" 
																					id="coapplicant_vehicle_no_of_door"
																					v-model="form.coapplicant_vehicle_no_of_door"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_no_of_door" 
																					id="dependent_one_vehicle_no_of_door"
																					v-model="form.dependent_one_vehicle_no_of_door"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_no_of_door" 
																					id="dependent_two_vehicle_no_of_door"
																					v-model="form.dependent_two_vehicle_no_of_door"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_no_of_door" 
																					id="dependent_three_vehicle_no_of_door"
																					v-model="form.dependent_three_vehicle_no_of_door"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_no_of_door" 
																					id="dependent_four_vehicle_no_of_door"
																					v-model="form.dependent_four_vehicle_no_of_door"></td>
														</tr>
														<caption>Insurance</caption>
														<tr>
															<th scope="row">Insurer company name</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_insurer_company_name" 
																					id="applicant_vehicle_insurer_company_name"
																					v-model="form.applicant_vehicle_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_insurer_company_name" 
																					id="coapplicant_vehicle_insurer_company_name"
																					v-model="form.coapplicant_vehicle_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_insurer_company_name" 
																					id="dependent_one_vehicle_insurer_company_name"
																					v-model="form.dependent_one_vehicle_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_insurer_company_name" 
																					id="dependent_two_vehicle_insurer_company_name"
																					v-model="form.dependent_two_vehicle_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_insurer_company_name" 
																					id="dependent_three_vehicle_insurer_company_name"
																					v-model="form.dependent_three_vehicle_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_insurer_company_name" 
																					id="dependent_four_vehicle_insurer_company_name"
																					v-model="form.dependent_four_vehicle_insurer_company_name"></td>
														</tr>
														<tr>
															<th scope="row">Policy No</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_policy_no" 
																					id="applicant_vehicle_policy_no"
																					v-model="form.applicant_vehicle_policy_no"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_policy_no" 
																					id="coapplicant_vehicle_policy_no"
																					v-model="form.coapplicant_vehicle_policy_no"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_policy_no" 
																					id="dependent_one_vehicle_policy_no"
																					v-model="form.dependent_one_vehicle_policy_no"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_policy_no" 
																					id="dependent_two_vehicle_policy_no"
																					v-model="form.dependent_two_vehicle_policy_no"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_policy_no" 
																					id="dependent_three_vehicle_policy_no"
																					v-model="form.dependent_three_vehicle_policy_no"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_policy_no" 
																					id="dependent_four_vehicle_policy_no"
																					v-model="form.dependent_four_vehicle_policy_no"></td>
														</tr>
														<tr>
															<th scope="row">Expiry Date</th>
															<td><input type="date" value="" 
																					name="applicant_vehicle_expiry_date" 
																					id="applicant_vehicle_expiry_date"
																					v-model="form.applicant_vehicle_expiry_date"></td>
															<td><input type="date" value="" 
																					name="coapplicant_vehicle_expiry_date" 
																					id="coapplicant_vehicle_expiry_date"
																					v-model="form.coapplicant_vehicle_expiry_date"></td>
															<td><input type="date" value="" 
																					name="dependent_one_vehicle_expiry_date" 
																					id="dependent_one_vehicle_expiry_date"
																					v-model="form.dependent_one_vehicle_expiry_date"></td>
															<td><input type="date" value="" 
																					name="dependent_two_vehicle_expiry_date" 
																					id="dependent_two_vehicle_expiry_date"
																					v-model="form.dependent_two_vehicle_expiry_date"></td>
															<td><input type="date" value="" 
																					name="dependent_three_vehicle_expiry_date" 
																					id="dependent_three_vehicle_expiry_date"
																					v-model="form.dependent_three_vehicle_expiry_date"></td>
															<td><input type="date" value="" 
																					name="dependent_four_vehicle_expiry_date" 
																					id="dependent_four_vehicle_expiry_date"
																					v-model="form.dependent_four_vehicle_expiry_date"></td>
														</tr>
														<tr>
															<th scope="row">Plate Number</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_plate_no" 
																					id="applicant_vehicle_plate_no"
																					v-model="form.applicant_vehicle_plate_no"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_plate_no" 
																					id="coapplicant_vehicle_plate_no"
																					v-model="form.coapplicant_vehicle_plate_no"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_plate_no" 
																					id="dependent_one_vehicle_plate_no"
																					v-model="form.dependent_one_vehicle_plate_no"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_plate_no" 
																					id="dependent_two_vehicle_plate_no"
																					v-model="form.dependent_two_vehicle_plate_no"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_plate_no" 
																					id="dependent_three_vehicle_plate_no"
																					v-model="form.dependent_three_vehicle_plate_no"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_plate_no" 
																					id="dependent_four_vehicle_plate_no"
																					v-model="form.dependent_four_vehicle_plate_no"></td>
														</tr>
														<tr>
															<th scope="row">Driver Name</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_driver_name" 
																					id="applicant_vehicle_driver_name"
																					v-model="form.applicant_vehicle_driver_name"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_driver_name" 
																					id="coapplicant_vehicle_driver_name"
																					v-model="form.coapplicant_vehicle_driver_name"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_driver_name" 
																					id="dependent_one_vehicle_driver_name"
																					v-model="form.dependent_one_vehicle_driver_name"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_driver_name" 
																					id="dependent_two_vehicle_driver_name"
																					v-model="form.dependent_two_vehicle_driver_name"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_driver_name" 
																					id="dependent_three_vehicle_driver_name"
																					v-model="form.dependent_three_vehicle_driver_name"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_driver_name" 
																					id="dependent_four_vehicle_driver_name"
																					v-model="form.dependent_four_vehicle_driver_name"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col">Vehicle 2</th>
															<th scope="col">Applicant </th>
															<th scope="col">Co-Applicant </th>
															<th scope="col">Dependent 1</th>
															<th scope="col">Dependent 2</th>
															<th scope="col">Dependent 3</th>
															<th scope="col">Dependent 4</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Made</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_two_made" 
																					id="applicant_vehicle_two_made"
																					v-model="form.applicant_vehicle_two_made"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_two_made" 
																					id="coapplicant_vehicle_two_made"
																					v-model="form.coapplicant_vehicle_two_made"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_two_made" 
																					id="dependent_one_vehicle_two_made"
																					v-model="form.dependent_one_vehicle_two_made"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_two_made" 
																					id="dependent_two_vehicle_two_made"
																					v-model="form.dependent_two_vehicle_two_made"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_two_made" 
																					id="dependent_three_vehicle_two_made"
																					v-model="form.dependent_three_vehicle_two_made"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_two_made" 
																					id="dependent_four_vehicle_two_made"
																					v-model="form.dependent_four_vehicle_two_made"></td>
														</tr>
														<tr>
															<th scope="row">Model</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_two_model" 
																					id="applicant_vehicle_two_model"
																					v-model="form.applicant_vehicle_two_model"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_two_model" 
																					id="coapplicant_vehicle_two_model"
																					v-model="form.coapplicant_vehicle_two_model"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_two_model" 
																					id="dependent_one_vehicle_two_model"
																					v-model="form.dependent_one_vehicle_two_model"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_two_model" 
																					id="dependent_two_vehicle_two_model"
																					v-model="form.dependent_two_vehicle_two_model"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_two_model" 
																					id="dependent_three_vehicle_two_model"
																					v-model="form.dependent_three_vehicle_two_model"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_two_model" 
																					id="dependent_four_vehicle_two_model"
																					v-model="form.dependent_four_vehicle_two_model"></td>
														</tr>
														<tr>
															<th scope="row">Year</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_two_year" 
																					id="applicant_vehicle_two_year"
																					v-model="form.applicant_vehicle_two_year"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_two_year" 
																					id="coapplicant_vehicle_two_year"
																					v-model="form.coapplicant_vehicle_two_year"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_two_year" 
																					id="dependent_one_vehicle_two_year"
																					v-model="form.dependent_one_vehicle_two_year"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_two_year" 
																					id="dependent_two_vehicle_two_year"
																					v-model="form.dependent_two_vehicle_two_year"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_two_year" 
																					id="dependent_three_vehicle_two_year"
																					v-model="form.dependent_three_vehicle_two_year"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_two_year" 
																					id="dependent_four_vehicle_two_year"
																					v-model="form.dependent_four_vehicle_two_year"></td>
														</tr>
														<tr>
															<th scope="row">Paint Color</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_two_color" 
																					id="applicant_vehicle_two_color"
																					v-model="form.applicant_vehicle_two_color"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_two_color" 
																					id="coapplicant_vehicle_two_color"
																					v-model="form.coapplicant_vehicle_two_color"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_two_color" 
																					id="dependent_one_vehicle_two_color"
																					v-model="form.dependent_one_vehicle_two_color"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_two_color" 
																					id="dependent_two_vehicle_two_color"
																					v-model="form.dependent_two_vehicle_two_color"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_two_color" 
																					id="dependent_three_vehicle_two_color"
																					v-model="form.dependent_three_vehicle_two_color"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_two_color" 
																					id="dependent_four_vehicle_two_color"
																					v-model="form.dependent_four_vehicle_two_color"></td>
														</tr>
														<tr>
															<th scope="row">Body Style</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_two_body_style" 
																					id="applicant_vehicle_two_body_style"
																					v-model="form.applicant_vehicle_two_body_style"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_two_body_style" 
																					id="coapplicant_vehicle_two_body_style"
																					v-model="form.coapplicant_vehicle_two_body_style"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_two_body_style" 
																					id="dependent_one_vehicle_two_body_style"
																					v-model="form.dependent_one_vehicle_two_body_style"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_two_body_style" 
																					id="dependent_two_vehicle_two_body_style"
																					v-model="form.dependent_two_vehicle_two_body_style"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_two_body_style" 
																					id="dependent_three_vehicle_two_body_style"
																					v-model="form.dependent_three_vehicle_two_body_style"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_two_body_style" 
																					id="dependent_four_vehicle_two_body_style"
																					v-model="form.dependent_four_vehicle_two_body_style"></td>
														</tr>
														<tr>
															<th scope="row">Number of Doors</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_two_no_of_door" 
																					id="applicant_vehicle_two_no_of_door"
																					v-model="form.applicant_vehicle_two_no_of_door"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_two_no_of_door" 
																					id="coapplicant_vehicle_two_no_of_door"
																					v-model="form.coapplicant_vehicle_two_no_of_door"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_two_no_of_door" 
																					id="dependent_one_vehicle_two_no_of_door"
																					v-model="form.dependent_one_vehicle_two_no_of_door"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_two_no_of_door" 
																					id="dependent_two_vehicle_no_of_door"
																					v-model="form.dependent_two_vehicle_no_of_door"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_no_of_door" 
																					id="dependent_three_vehicle_no_of_door"
																					v-model="form.dependent_three_vehicle_no_of_door"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_no_of_door" 
																					id="dependent_four_vehicle_no_of_door"
																					v-model="form.dependent_four_vehicle_no_of_door"></td>
														</tr>
														<caption>Insurance</caption>
														<tr>
															<th scope="row">Insurer company name</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_two_insurer_company_name" 
																					id="applicant_vehicle_two_insurer_company_name"
																					v-model="form.applicant_vehicle_two_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_two_insurer_company_name" 
																					id="coapplicant_vehicle_two_insurer_company_name"
																					v-model="form.coapplicant_vehicle_two_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_two_insurer_company_name" 
																					id="dependent_one_vehicle_two_insurer_company_name"
																					v-model="form.dependent_one_vehicle_two_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_two_insurer_company_name" 
																					id="dependent_two_vehicle_two_insurer_company_name"
																					v-model="form.dependent_two_vehicle_two_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_two_insurer_company_name" 
																					id="dependent_three_vehicle_two_insurer_company_name"
																					v-model="form.dependent_three_vehicle_two_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_two_insurer_company_name" 
																					id="dependent_four_vehicle_two_insurer_company_name"
																					v-model="form.dependent_four_vehicle_two_insurer_company_name"></td>
														</tr>
														<tr>
															<th scope="row">Policy No</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_two_policy_no" 
																					id="applicant_vehicle_two_policy_no"
																					v-model="form.applicant_vehicle_two_policy_no"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_two_policy_no" 
																					id="coapplicant_vehicle_two_policy_no"
																					v-model="form.coapplicant_vehicle_two_policy_no"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_two_policy_no" 
																					id="dependent_one_vehicle_two_policy_no"
																					v-model="form.dependent_one_vehicle_two_policy_no"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_two_policy_no" 
																					id="dependent_two_vehicle_two_policy_no"
																					v-model="form.dependent_two_vehicle_two_policy_no"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_two_policy_no" 
																					id="dependent_three_vehicle_two_policy_no"
																					v-model="form.dependent_three_vehicle_two_policy_no"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_two_policy_no" 
																					id="dependent_four_vehicle_two_policy_no"
																					v-model="form.dependent_four_vehicle_two_policy_no"></td>
														</tr>
														<tr>
															<th scope="row">Expiry Date</th>
															<td><input type="date" value="" 
																					name="applicant_vehicle_two_expiry_date" 
																					id="applicant_vehicle_two_expiry_date"
																					v-model="form.applicant_vehicle_two_expiry_date"></td>
															<td><input type="date" value="" 
																					name="coapplicant_vehicle_two_expiry_date" 
																					id="coapplicant_vehicle_two_expiry_date"
																					v-model="form.coapplicant_vehicle_two_expiry_date"></td>
															<td><input type="date" value="" 
																					name="dependent_one_vehicle_two_expiry_date" 
																					id="dependent_one_vehicle_two_expiry_date"
																					v-model="form.dependent_one_vehicle_two_expiry_date"></td>
															<td><input type="date" value="" 
																					name="dependent_two_vehicle_two_expiry_date" 
																					id="dependent_two_vehicle_two_expiry_date"
																					v-model="form.dependent_two_vehicle_two_expiry_date"></td>
															<td><input type="date" value="" 
																					name="dependent_three_vehicle_two_expiry_date" 
																					id="dependent_three_vehicle_two_expiry_date"
																					v-model="form.dependent_three_vehicle_two_expiry_date"></td>
															<td><input type="date" value="" 
																					name="dependent_four_vehicle_two_expiry_date" 
																					id="dependent_four_vehicle_two_expiry_date"
																					v-model="form.dependent_four_vehicle_two_expiry_date"></td>
														</tr>
														<tr>
															<th scope="row">Plate Number</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_two_plate_no" 
																					id="applicant_vehicle_two_plate_no"
																					v-model="form.applicant_vehicle_two_plate_no"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_two_plate_no" 
																					id="coapplicant_vehicle_two_plate_no"
																					v-model="form.coapplicant_vehicle_two_plate_no"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_two_plate_no" 
																					id="dependent_one_vehicle_two_plate_no"
																					v-model="form.dependent_one_vehicle_two_plate_no"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_two_plate_no" 
																					id="dependent_two_vehicle_two_plate_no"
																					v-model="form.dependent_two_vehicle_two_plate_no"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_two_plate_no" 
																					id="dependent_three_vehicle_two_plate_no"
																					v-model="form.dependent_three_vehicle_two_plate_no"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_two_plate_no" 
																					id="dependent_four_vehicle_two_plate_no"
																					v-model="form.dependent_four_vehicle_two_plate_no"></td>
														</tr>
														<tr>
															<th scope="row">Driver Name</th>
															<td><input type="text" value="" 
																					name="applicant_vehicle_two_driver_name" 
																					id="applicant_vehicle_two_driver_name"
																					v-model="form.applicant_vehicle_two_driver_name"></td>
															<td><input type="text" value="" 
																					name="coapplicant_vehicle_two_driver_name" 
																					id="coapplicant_vehicle_two_driver_name"
																					v-model="form.coapplicant_vehicle_two_driver_name"></td>
															<td><input type="text" value="" 
																					name="dependent_one_vehicle_two_driver_name" 
																					id="dependent_one_vehicle_two_driver_name"
																					v-model="form.dependent_one_vehicle_two_driver_name"></td>
															<td><input type="text" value="" 
																					name="dependent_two_vehicle_two_driver_name" 
																					id="dependent_two_vehicle_two_driver_name"
																					v-model="form.dependent_two_vehicle_two_driver_name"></td>
															<td><input type="text" value="" 
																					name="dependent_three_vehicle_two_driver_name" 
																					id="dependent_three_vehicle_two_driver_name"
																					v-model="form.dependent_three_vehicle_two_driver_name"></td>
															<td><input type="text" value="" 
																					name="dependent_four_vehicle_two_driver_name" 
																					id="dependent_four_vehicle_two_driver_name"
																					v-model="form.dependent_four_vehicle_two_driver_name"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col">Motorcycle 1</th>
															<th scope="col">Applicant </th>
															<th scope="col">Co-Applicant </th>
															<th scope="col">Dependent 1</th>
															<th scope="col">Dependent 2</th>
															<th scope="col">Dependent 3</th>
															<th scope="col">Dependent 4</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Made</th>
															<td><input type="text" value="" 
																					name="applicant_motorcycle_one_made" 
																					id="applicant_motorcycle_one_made"
																					v-model="form.applicant_motorcycle_one_made"></td>
															<td><input type="text" value="" 
																					name="coapplicant_motorcycle_one_made" 
																					id="coapplicant_motorcycle_one_made"
																					v-model="form.coapplicant_motorcycle_one_made"></td>
															<td><input type="text" value="" 
																					name="dependent_one_motorcycle_one_made" 
																					id="dependent_one_motorcycle_one_made"
																					v-model="form.dependent_one_motorcycle_one_made"></td>
															<td><input type="text" value="" 
																					name="dependent_two_motorcycle_one_made" 
																					id="dependent_two_motorcycle_one_made"
																					v-model="form.dependent_two_motorcycle_one_made"></td>
															<td><input type="text" value="" 
																					name="dependent_three_motorcycle_one_made" 
																					id="dependent_three_motorcycle_one_made"
																					v-model="form.dependent_three_motorcycle_one_made"></td>
															<td><input type="text" value="" 
																					name="dependent_four_motorcycle_one_made" 
																					id="dependent_four_motorcycle_one_made"
																					v-model="form.dependent_four_motorcycle_one_made"></td>
														</tr>
														<tr>
															<th scope="row">Model</th>
															<td><input type="text" value="" 
																					name="applicant_motorcycle_one_model" 
																					id="applicant_motorcycle_one_model"
																					v-model="form.applicant_motorcycle_one_model"></td>
															<td><input type="text" value="" 
																					name="coapplicant_motorcycle_one_model" 
																					id="coapplicant_motorcycle_one_model"
																					v-model="form.coapplicant_motorcycle_one_model"></td>
															<td><input type="text" value="" 
																					name="dependent_one_motorcycle_one_model" 
																					id="dependent_one_motorcycle_one_model"
																					v-model="form.dependent_one_motorcycle_one_model"></td>
															<td><input type="text" value="" 
																					name="dependent_two_motorcycle_one_model" 
																					id="dependent_two_motorcycle_one_model"
																					v-model="form.dependent_two_motorcycle_one_model"></td>
															<td><input type="text" value="" 
																					name="dependent_three_motorcycle_one_model" 
																					id="dependent_three_motorcycle_one_model"
																					v-model="form.dependent_three_motorcycle_one_model"></td>
															<td><input type="text" value="" 
																					name="dependent_four_motorcycle_one_model" 
																					id="dependent_four_motorcycle_one_model"
																					v-model="form.dependent_four_motorcycle_one_model"></td>
														</tr>
														<tr>
															<th scope="row">Year</th>
															<td><input type="text" value="" 
																					name="applicant_motorcycle_one_year" 
																					id="applicant_motorcycle_one_year"
																					v-model="form.applicant_motorcycle_one_year"></td>
															<td><input type="text" value="" 
																					name="coapplicant_motorcycle_one_year" 
																					id="coapplicant_motorcycle_one_year"
																					v-model="form.coapplicant_motorcycle_one_year"></td>
															<td><input type="text" value="" 
																					name="dependent_one_motorcycle_one_year" 
																					id="dependent_one_motorcycle_one_year"
																					v-model="form.dependent_one_motorcycle_one_year"></td>
															<td><input type="text" value="" 
																					name="dependent_two_motorcycle_one_year" 
																					id="dependent_two_motorcycle_one_year"
																					v-model="form.dependent_two_motorcycle_one_year"></td>
															<td><input type="text" value="" 
																					name="dependent_three_motorcycle_one_year" 
																					id="dependent_three_motorcycle_one_year"
																					v-model="form.dependent_three_motorcycle_one_year"></td>
															<td><input type="text" value="" 
																					name="dependent_four_motorcycle_one_year" 
																					id="dependent_four_motorcycle_one_year"
																					v-model="form.dependent_four_motorcycle_one_year"></td>
														</tr>
														<tr>
															<th scope="row">Paint Color</th>
															<td><input type="text" value="" 
																					name="applicant_motorcycle_one_color" 
																					id="applicant_motorcycle_one_color"
																					v-model="form.applicant_motorcycle_one_color"></td>
															<td><input type="text" value="" 
																					name="coapplicant_motorcycle_one_color" 
																					id="coapplicant_motorcycle_one_color"
																					v-model="form.coapplicant_motorcycle_one_color"></td>
															<td><input type="text" value="" 
																					name="dependent_one_motorcycle_one_color" 
																					id="dependent_one_motorcycle_one_color"
																					v-model="form.dependent_one_motorcycle_one_color"></td>
															<td><input type="text" value="" 
																					name="dependent_two_motorcycle_one_color" 
																					id="dependent_two_motorcycle_one_color"
																					v-model="form.dependent_two_motorcycle_one_color"></td>
															<td><input type="text" value="" 
																					name="dependent_three_motorcycle_one_color" 
																					id="dependent_three_motorcycle_one_color"
																					v-model="form.dependent_three_motorcycle_one_color"></td>
															<td><input type="text" value="" 
																					name="dependent_four_motorcycle_one_color" 
																					id="dependent_four_motorcycle_one_color"
																					v-model="form.dependent_four_motorcycle_one_color"></td>
														</tr>
														<caption>Insurance</caption>
														<tr>
															<th scope="row">Insurer company name</th>
															<td><input type="text" value="" 
																					name="applicant_motorcycle_one_insurer_company_name" 
																					id="applicant_motorcycle_one_insurer_company_name"
																					v-model="form.applicant_motorcycle_one_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="coapplicant_motorcycle_one_insurer_company_name" 
																					id="coapplicant_motorcycle_one_insurer_company_name"
																					v-model="form.coapplicant_motorcycle_one_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="dependent_one_motorcycle_one_insurer_company_name" 
																					id="dependent_one_motorcycle_one_insurer_company_name"
																					v-model="form.dependent_one_motorcycle_one_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="dependent_two_motorcycle_one_insurer_company_name" 
																					id="dependent_two_motorcycle_one_insurer_company_name"
																					v-model="form.dependent_two_motorcycle_one_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="dependent_three_motorcycle_one_insurer_company_name" 
																					id="dependent_three_motorcycle_one_insurer_company_name"
																					v-model="form.dependent_three_motorcycle_one_insurer_company_name"></td>
															<td><input type="text" value="" 
																					name="dependent_four_motorcycle_one_insurer_company_name" 
																					id="dependent_four_motorcycle_one_insurer_company_name"
																					v-model="form.dependent_four_motorcycle_one_insurer_company_name"></td>
														</tr>
														<tr>
															<th scope="row">Policy No</th>
															<td><input type="text" value="" 
																					name="applicant_motorcycle_one_policy_no" 
																					id="applicant_motorcycle_one_policy_no"
																					v-model="form.applicant_motorcycle_one_policy_no"></td>
															<td><input type="text" value="" 
																					name="coapplicant_motorcycle_one_policy_no" 
																					id="coapplicant_motorcycle_one_policy_no"
																					v-model="form.coapplicant_motorcycle_one_policy_no"></td>
															<td><input type="text" value="" 
																					name="dependent_one_motorcycle_one_policy_no" 
																					id="dependent_one_motorcycle_one_policy_no"
																					v-model="form.dependent_one_motorcycle_one_policy_no"></td>
															<td><input type="text" value="" 
																					name="dependent_two_motorcycle_one_policy_no" 
																					id="dependent_two_motorcycle_one_policy_no"
																					v-model="form.dependent_two_motorcycle_one_policy_no"></td>
															<td><input type="text" value="" 
																					name="dependent_three_motorcycle_one_policy_no" 
																					id="dependent_three_motorcycle_one_policy_no"
																					v-model="form.dependent_three_motorcycle_one_policy_no"></td>
															<td><input type="text" value="" 
																					name="dependent_four_motorcycle_one_policy_no" 
																					id="dependent_four_motorcycle_one_policy_no"
																					v-model="form.dependent_four_motorcycle_one_policy_no"></td>
														</tr>
														<tr>
															<th scope="row">Expiry Date</th>
															<td><input type="date" value="" 
																					name="applicant_motorcycle_one_expiry_date" 
																					id="applicant_motorcycle_one_expiry_date"
																					v-model="form.applicant_motorcycle_one_expiry_date"></td>
															<td><input type="date" value="" 
																					name="coapplicant_motorcycle_one_expiry_date" 
																					id="coapplicant_motorcycle_one_expiry_date"
																					v-model="form.coapplicant_motorcycle_one_expiry_date"></td>
															<td><input type="date" value="" 
																					name="dependent_one_motorcycle_one_expiry_date" 
																					id="dependent_one_motorcycle_one_expiry_date"
																					v-model="form.dependent_one_motorcycle_one_expiry_date"></td>
															<td><input type="date" value="" 
																					name="dependent_two_motorcycle_one_expiry_date" 
																					id="dependent_two_motorcycle_one_expiry_date"
																					v-model="form.dependent_two_motorcycle_one_expiry_date"></td>
															<td><input type="date" value="" 
																					name="dependent_three_motorcycle_one_expiry_date" 
																					id="dependent_three_motorcycle_one_expiry_date"
																					v-model="form.dependent_three_motorcycle_one_expiry_date"></td>
															<td><input type="date" value="" 
																					name="dependent_four_motorcycle_one_expiry_date" 
																					id="dependent_four_motorcycle_one_expiry_date"
																					v-model="form.dependent_four_motorcycle_one_expiry_date"></td>
														</tr>
														<tr>
															<th scope="row">Plate Number</th>
															<td><input type="text" value="" 
																					name="applicant_motorcycle_one_plate_no" 
																					id="applicant_motorcycle_one_plate_no"
																					v-model="form.applicant_motorcycle_one_plate_no"></td>
															<td><input type="text" value="" 
																					name="coapplicant_motorcycle_one_plate_no" 
																					id="coapplicant_motorcycle_one_plate_no"
																					v-model="form.coapplicant_motorcycle_one_plate_no"></td>
															<td><input type="text" value="" 
																					name="dependent_one_motorcycle_one_plate_no" 
																					id="dependent_one_motorcycle_one_plate_no"
																					v-model="form.dependent_one_motorcycle_one_plate_no"></td>
															<td><input type="text" value="" 
																					name="dependent_two_motorcycle_one_plate_no" 
																					id="dependent_two_motorcycle_one_plate_no"
																					v-model="form.dependent_two_motorcycle_one_plate_no"></td>
															<td><input type="text" value="" 
																					name="dependent_three_motorcycle_one_plate_no" 
																					id="dependent_three_motorcycle_one_plate_no"
																					v-model="form.dependent_three_motorcycle_one_plate_no"></td>
															<td><input type="text" value="" 
																					name="dependent_four_motorcycle_one_plate_no" 
																					id="dependent_four_motorcycle_one_plate_no"
																					v-model="form.dependent_four_motorcycle_one_plate_no"></td>
														</tr>
														<tr>
															<th scope="row">Driver Name</th>
															<td><input type="text" value="" 
																					name="applicant_motorcycle_one_driver_name" 
																					id="applicant_motorcycle_one_driver_name"
																					v-model="form.applicant_motorcycle_one_driver_name"></td>
															<td><input type="text" value="" 
																					name="coapplicant_motorcycle_one_driver_name" 
																					id="coapplicant_motorcycle_one_driver_name"
																					v-model="form.coapplicant_motorcycle_one_driver_name"></td>
															<td><input type="text" value="" 
																					name="dependent_one_motorcycle_one_driver_name" 
																					id="dependent_one_motorcycle_one_driver_name"
																					v-model="form.dependent_one_motorcycle_one_driver_name"></td>
															<td><input type="text" value="" 
																					name="dependent_two_motorcycle_one_driver_name" 
																					id="dependent_two_motorcycle_one_driver_name"
																					v-model="form.dependent_two_motorcycle_one_driver_name"></td>
															<td><input type="text" value="" 
																					name="dependent_three_motorcycle_one_driver_name" 
																					id="dependent_three_motorcycle_one_driver_name"
																					v-model="form.dependent_three_motorcycle_one_driver_name"></td>
															<td><input type="text" value="" 
																					name="dependent_four_motorcycle_one_driver_name" 
																					id="dependent_four_motorcycle_one_driver_name"
																					v-model="form.dependent_four_motorcycle_one_driver_name"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i>Required Documents Submission  :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col">Documents </th>
															<th scope="col">Applicant </th>
															<th scope="col">Co-Applicant </th>
															<th scope="col">Dependent 1</th>
															<th scope="col">Dependent 2</th>
															<th scope="col">Dependent 3</th>
															<th scope="col">Dependent 4</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Auto Insurance</th>
															<td><select v-model="form.doc_applicant_auto_insurence"
	                                                        	name="doc_applicant_auto_insurence"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_auto_insurence') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_auto_insurence"
	                                                        	name="doc_coapplicant_auto_insurence"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_auto_insurence') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_auto_insurence"
	                                                        	name="doc_dependent_one_auto_insurence"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_auto_insurence') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_auto_insurence"
	                                                        	name="doc_dependent_two_auto_insurence"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_auto_insurence') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_auto_insurence"
	                                                        	name="doc_dependent_three_auto_insurence"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_auto_insurence') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_auto_insurence"
	                                                        	name="doc_dependent_four_auto_insurence"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_auto_insurence') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr>
														<tr>
															<th scope="row">Citizenship Card</th>
															<td><select v-model="form.doc_applicant_citizenship_card"
	                                                        	name="doc_applicant_citizenship_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_citizenship_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_citizenship_card"
	                                                        	name="doc_coapplicant_citizenship_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_citizenship_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_citizenship_card"
	                                                        	name="doc_dependent_one_citizenship_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_citizenship_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_citizenship_card"
	                                                        	name="doc_dependent_two_citizenship_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_citizenship_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_citizenship_card"
	                                                        	name="doc_dependent_three_citizenship_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_citizenship_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_citizenship_card"
	                                                        	name="doc_dependent_four_citizenship_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_citizenship_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr>
														<tr>
															<th scope="row">Driving Licence</th>
															<td><select v-model="form.doc_applicant_driving_licence"
	                                                        	name="doc_applicant_driving_licence"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_driving_licence') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_driving_licence"
	                                                        	name="doc_coapplicant_driving_licence"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_driving_licence') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_driving_licence"
	                                                        	name="doc_dependent_one_driving_licence"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_driving_licence') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_driving_licence"
	                                                        	name="doc_dependent_two_driving_licence"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_driving_licence') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_driving_licence"
	                                                        	name="doc_dependent_three_driving_licence"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_driving_licence') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_driving_licence"
	                                                        	name="doc_dependent_four_driving_licence"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_driving_licence') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr><tr>
															<th scope="row">Employment Proof</th>
															<td><select v-model="form.doc_applicant_employment_proof"
	                                                        	name="doc_applicant_employment_proof"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_employment_proof') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_employment_proof"
	                                                        	name="doc_coapplicant_employment_proof"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_employment_proof') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_employment_proof"
	                                                        	name="doc_dependent_one_employment_proof"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_employment_proof') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_employment_proof"
	                                                        	name="doc_dependent_two_employment_proof"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_employment_proof') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_employment_proof"
	                                                        	name="doc_dependent_three_employment_proof"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_employment_proof') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_employment_proof"
	                                                        	name="doc_dependent_four_employment_proof"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_employment_proof') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr><tr>
															<th scope="row">Healthcare Card</th>
															<td><select v-model="form.doc_applicant_healthcare_card"
	                                                        	name="doc_applicant_healthcare_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_healthcare_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_healthcare_card"
	                                                        	name="doc_coapplicant_healthcare_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_healthcare_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_healthcare_card"
	                                                        	name="doc_dependent_one_healthcare_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_healthcare_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_healthcare_card"
	                                                        	name="doc_dependent_two_healthcare_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_healthcare_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_healthcare_card"
	                                                        	name="doc_dependent_three_healthcare_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_healthcare_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_healthcare_card"
	                                                        	name="doc_dependent_four_healthcare_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_healthcare_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr><tr>
															<th scope="row">Personal Tax "Notice of Assessment "</th>
															<td><select v-model="form.doc_applicant_personal_tax"
	                                                        	name="doc_applicant_personal_tax"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_personal_tax') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_personal_tax"
	                                                        	name="doc_coapplicant_personal_tax"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_personal_tax') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_personal_tax"
	                                                        	name="doc_dependent_one_personal_tax"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_personal_tax') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_personal_tax"
	                                                        	name="doc_dependent_two_personal_tax"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_personal_tax') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_personal_tax"
	                                                        	name="doc_dependent_three_personal_tax"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_personal_tax') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_personal_tax"
	                                                        	name="doc_dependent_four_personal_tax"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_personal_tax') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr><tr>
															<th scope="row">Passport </th>
															<td><select v-model="form.doc_applicant_passport"
	                                                        	name="doc_applicant_passport"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_passport') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_passport"
	                                                        	name="doc_coapplicant_passport"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_passport') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_passport"
	                                                        	name="doc_dependent_one_passport"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_passport') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_passport"
	                                                        	name="doc_dependent_two_passport"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_passport') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_passport"
	                                                        	name="doc_dependent_three_passport"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_passport') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_passport"
	                                                        	name="doc_dependent_four_passport"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_passport') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr><tr>
															<th scope="row">Social Security card</th>
															<td><select v-model="form.doc_applicant_social_security_card"
	                                                        	name="doc_applicant_social_security_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_social_security_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_social_security_card"
	                                                        	name="doc_coapplicant_social_security_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_social_security_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_social_security_card"
	                                                        	name="doc_dependent_one_social_security_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_social_security_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_social_security_card"
	                                                        	name="doc_dependent_two_social_security_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_social_security_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_social_security_card"
	                                                        	name="doc_dependent_three_social_security_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_social_security_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_social_security_card"
	                                                        	name="doc_dependent_four_social_security_card"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_social_security_card') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr><tr>
															<th scope="row">Utility Bili</th>
															<td><select v-model="form.doc_applicant_utility_bili"
	                                                        	name="doc_applicant_utility_bili"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_utility_bili') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_utility_bili"
	                                                        	name="doc_coapplicant_utility_bili"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_utility_bili') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_utility_bili"
	                                                        	name="doc_dependent_one_utility_bili"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_utility_bili') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_utility_bili"
	                                                        	name="doc_dependent_two_utility_bili"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_utility_bili') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_utility_bili"
	                                                        	name="doc_dependent_three_utility_bili"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_utility_bili') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_utility_bili"
	                                                        	name="doc_dependent_four_utility_bili"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_utility_bili') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr><tr>
															<th scope="row">Credit Report</th>
															<td><select v-model="form.doc_applicant_credit_report"
	                                                        	name="doc_applicant_credit_report"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_credit_report') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_credit_report"
	                                                        	name="doc_coapplicant_credit_report"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_credit_report') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_credit_report"
	                                                        	name="doc_dependent_one_credit_report"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_credit_report') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_credit_report"
	                                                        	name="doc_dependent_two_credit_report"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_credit_report') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_credit_report"
	                                                        	name="doc_dependent_three_credit_report"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_credit_report') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_credit_report"
	                                                        	name="doc_dependent_four_credit_report"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_credit_report') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr><tr>
															<th scope="row">Bank Statement</th>
															<td><select v-model="form.doc_applicant_bank_statement"
	                                                        	name="doc_applicant_bank_statement"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_bank_statement') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_bank_statement"
	                                                        	name="doc_coapplicant_bank_statement"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_bank_statement') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_bank_statement"
	                                                        	name="doc_dependent_one_bank_statement"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_bank_statement') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_bank_statement"
	                                                        	name="doc_dependent_two_bank_statement"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_bank_statement') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_bank_statement"
	                                                        	name="doc_dependent_three_bank_statement"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_bank_statement') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_bank_statement"
	                                                        	name="doc_dependent_four_bank_statement"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_bank_statement') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr><tr>
															<th scope="row">Referral Letter</th>
															<td><select v-model="form.doc_applicant_referral_letter"
	                                                        	name="doc_applicant_referral_letter"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_referral_letter') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_referral_letter"
	                                                        	name="doc_coapplicant_referral_letter"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_referral_letter') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_referral_letter"
	                                                        	name="doc_dependent_one_referral_letter"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_referral_letter') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_referral_letter"
	                                                        	name="doc_dependent_two_referral_letter"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_referral_letter') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_referral_letter"
	                                                        	name="doc_dependent_three_referral_letter"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_referral_letter') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_referral_letter"
	                                                        	name="doc_dependent_four_referral_letter"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_referral_letter') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr><tr>
															<th scope="row">Paystub</th>
															<td><select v-model="form.doc_applicant_paystub"
	                                                        	name="doc_applicant_paystub"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_applicant_paystub') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_coapplicant_paystub"
	                                                        	name="doc_coapplicant_paystub"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_coapplicant_paystub') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_one_paystub"
	                                                        	name="doc_dependent_one_paystub"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_one_paystub') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_two_paystub"
	                                                        	name="doc_dependent_two_paystub"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_two_paystub') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_three_paystub"
	                                                        	name="doc_dependent_three_paystub"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_three_paystub') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
															  <td><select v-model="form.doc_dependent_four_paystub"
	                                                        	name="doc_dependent_four_paystub"
	                                                        	class="custom-select" 
	                                                        	:class="{ 'is-invalid': form.errors.has('doc_dependent_four_paystub') }">
													        	<option disabled value="">--Select-- </option>
															  	<option v-for="(country,index) in countries" :value="index">{{country}}</option>
													  		</select></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i>Pet and Service Dog   :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col">Pet's Type </th>
															<th scope="col">Applicant </th>
															<th scope="col">Co-Applicant </th>
															<th scope="col">Dependent 1</th>
															<th scope="col">Dependent 2</th>
															<th scope="col">Dependent 3</th>
															<th scope="col">Dependent 4</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Dog</th>
															<td><input type="text" value="" 
																					name="applicant_pet_dog" 
																					id="applicant_pet_dog"
																					v-model="form.applicant_pet_dog"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_dog" 
																					id="coapplicant_pet_dog"
																					v-model="form.coapplicant_pet_dog"></td>
															<td><input type="text" value="" 
																					name="dependent_one_pet_dog" 
																					id="dependent_one_pet_dog"
																					v-model="form.dependent_one_pet_dog"></td>
															<td><input type="text" value="" 
																					name="dependent_two_pet_dog" 
																					id="dependent_two_pet_dog"
																					v-model="form.dependent_two_pet_dog"></td>
															<td><input type="text" value="" 
																					name="dependent_three_pet_dog" 
																					id="dependent_three_pet_dog"
																					v-model="form.dependent_three_pet_dog"></td>
															<td><input type="text" value="" 
																					name="dependent_four_pet_dog" 
																					id="dependent_four_pet_dog"
																					v-model="form.dependent_four_pet_dog"></td>
														</tr>
														<tr>
															<th scope="row">K9</th>
															<td><input type="text" value="" 
																					name="applicant_pet_k_nine" 
																					id="applicant_pet_k_nine"
																					v-model="form.applicant_pet_k_nine"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_k_nine" 
																					id="coapplicant_pet_k_nine"
																					v-model="form.coapplicant_pet_k_nine"></td>
															<td><input type="text" value="" 
																					name="dependent_one_pet_k_nine" 
																					id="dependent_one_pet_k_nine"
																					v-model="form.dependent_one_pet_k_nine"></td>
															<td><input type="text" value="" 
																					name="dependent_two_pet_k_nine" 
																					id="dependent_two_pet_k_nine"
																					v-model="form.dependent_two_pet_k_nine"></td>
															<td><input type="text" value="" 
																					name="dependent_three_pet_k_nine" 
																					id="dependent_three_pet_k_nine"
																					v-model="form.dependent_three_pet_k_nine"></td>
															<td><input type="text" value="" 
																					name="dependent_four_pet_k_nine" 
																					id="dependent_four_pet_k_nine"
																					v-model="form.dependent_four_pet_k_nine"></td>
														</tr>
														<tr>
															<th scope="row">Cat</th>
															<td><input type="text" value="" 
																					name="applicant_pet_cat" 
																					id="applicant_pet_cat"
																					v-model="form.applicant_pet_cat"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_cat" 
																					id="coapplicant_pet_cat"
																					v-model="form.coapplicant_pet_cat"></td>
															<td><input type="text" value="" 
																					name="dependent_one_pet_cat" 
																					id="dependent_one_pet_cat"
																					v-model="form.dependent_one_pet_cat"></td>
															<td><input type="text" value="" 
																					name="dependent_two_pet_cat" 
																					id="dependent_two_pet_cat"
																					v-model="form.dependent_two_pet_cat"></td>
															<td><input type="text" value="" 
																					name="dependent_three_pet_cat" 
																					id="dependent_three_pet_cat"
																					v-model="form.dependent_three_pet_cat"></td>
															<td><input type="text" value="" 
																					name="dependent_four_pet_cat" 
																					id="dependent_four_pet_cat"
																					v-model="form.dependent_four_pet_cat"></td>
														</tr>
														<tr>
															<th scope="row">Rabbit</th>
															<td><input type="text" value="" 
																					name="applicant_pet_rabbit" 
																					id="applicant_pet_rabbit"
																					v-model="form.applicant_pet_rabbit"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_rabbit" 
																					id="coapplicant_pet_rabbit"
																					v-model="form.coapplicant_pet_rabbit"></td>
															<td><input type="text" value="" 
																					name="dependent_one_pet_rabbit" 
																					id="dependent_one_pet_rabbit"
																					v-model="form.dependent_one_pet_rabbit"></td>
															<td><input type="text" value="" 
																					name="dependent_two_pet_rabbit" 
																					id="dependent_two_pet_rabbit"
																					v-model="form.dependent_two_pet_rabbit"></td>
															<td><input type="text" value="" 
																					name="dependent_three_pet_rabbit" 
																					id="dependent_three_pet_rabbit"
																					v-model="form.dependent_three_pet_rabbit"></td>
															<td><input type="text" value="" 
																					name="dependent_four_pet_rabbit" 
																					id="dependent_four_pet_rabbit"
																					v-model="form.dependent_four_pet_rabbit"></td>
														</tr>
														<tr>
															<th scope="row">Bird</th>
															<td><input type="text" value="" 
																					name="applicant_pet_bird" 
																					id="applicant_pet_bird"
																					v-model="form.applicant_pet_bird"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_bird" 
																					id="coapplicant_pet_bird"
																					v-model="form.coapplicant_pet_bird"></td>
															<td><input type="text" value="" 
																					name="dependent_one_pet_bird" 
																					id="dependent_one_pet_bird"
																					v-model="form.dependent_one_pet_bird"></td>
															<td><input type="text" value="" 
																					name="dependent_two_pet_bird" 
																					id="dependent_two_pet_bird"
																					v-model="form.dependent_two_pet_bird"></td>
															<td><input type="text" value="" 
																					name="dependent_three_pet_bird" 
																					id="dependent_three_pet_bird"
																					v-model="form.dependent_three_pet_bird"></td>
															<td><input type="text" value="" 
																					name="dependent_four_pet_bird" 
																					id="dependent_four_pet_bird"
																					v-model="form.dependent_four_pet_bird"></td>
														</tr>
														<tr>
															<th scope="row">Hamster</th>
															<td><input type="text" value="" 
																					name="applicant_pet_hamster" 
																					id="applicant_pet_hamster"
																					v-model="form.applicant_pet_hamster"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_hamster" 
																					id="coapplicant_pet_hamster"
																					v-model="form.coapplicant_pet_hamster"></td>
															<td><input type="text" value="" 
																					name="dependent_one_pet_hamster" 
																					id="dependent_one_pet_hamster"
																					v-model="form.dependent_one_pet_hamster"></td>
															<td><input type="text" value="" 
																					name="dependent_two_pet_hamster" 
																					id="dependent_two_pet_hamster"
																					v-model="form.dependent_two_pet_hamster"></td>
															<td><input type="text" value="" 
																					name="dependent_three_pet_hamster" 
																					id="dependent_three_pet_hamster"
																					v-model="form.dependent_three_pet_hamster"></td>
															<td><input type="text" value="" 
																					name="dependent_four_pet_hamster" 
																					id="dependent_four_pet_hamster"
																					v-model="form.dependent_four_pet_hamster"></td>
														</tr>
														<tr>
															<th scope="row">Other </th>
															<td><input type="text" value="" 
																					name="applicant__pet_other" 
																					id="applicant__pet_other"
																					v-model="form.applicant__pet_other"></td>
															<td><input type="text" value="" 
																					name="coapplicant__pet_other" 
																					id="coapplicant__pet_other"
																					v-model="form.coapplicant__pet_other"></td>
															<td><input type="text" value="" 
																					name="dependent_one__pet_other" 
																					id="dependent_one__pet_other"
																					v-model="form.dependent_one__pet_other"></td>
															<td><input type="text" value="" 
																					name="dependent_two__pet_other" 
																					id="dependent_two__pet_other"
																					v-model="form.dependent_two__pet_other"></td>
															<td><input type="text" value="" 
																					name="dependent_three__pet_other" 
																					id="dependent_three__pet_other"
																					v-model="form.dependent_three__pet_other"></td>
															<td><input type="text" value="" 
																					name="dependent_four__pet_other" 
																					id="dependent_four__pet_other"
																					v-model="form.dependent_four__pet_other"></td>
														</tr>
														<caption>Pet General Information </caption>
														<tr>
															<th scope="row">Name</th>
															<td><input type="text" value="" 
																					name="applicant_pet_info_name" 
																					id="applicant_pet_info_name"
																					v-model="form.applicant_pet_info_name"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_info_name" 
																					id="coapplicant_pet_info_name"
																					v-model="form.coapplicant_pet_info_name"></td>
														</tr>
														<tr>
															<th scope="row">Birth Date</th>
															<td><input type="date" value="" 
																					name="applicant_pet_info_dob" 
																					id="applicant_pet_info_dob"
																					v-model="form.applicant_pet_info_dob"></td>
															<td><input type="date" value="" 
																					name="coapplicant_pet_info_dob" 
																					id="coapplicant_pet_info_dob"
																					v-model="form.coapplicant_pet_info_dob"></td>
														</tr>
														<tr>
															<th scope="row">Age</th>
															<td><input type="text" value="" 
																					name="applicant_pet_info_age" 
																					id="applicant_pet_info_age"
																					v-model="form.applicant_pet_info_age"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_info_age" 
																					id="coapplicant_pet_info_age"
																					v-model="form.coapplicant_pet_info_age"></td>
														</tr>
														<tr>
															<th scope="row">Color</th>
															<td><input type="text" value="" 
																					name="applicant_pet_info_color" 
																					id="applicant_pet_info_color"
																					v-model="form.applicant_pet_info_color"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_info_color" 
																					id="coapplicant_pet_info_color"
																					v-model="form.coapplicant_pet_info_color"></td>
														</tr>
														<tr>
															<th scope="row">Weight</th>
															<td><input type="text" value="" 
																					name="applicant_pet_info_weight" 
																					id="applicant_pet_info_weight"
																					v-model="form.applicant_pet_info_weight"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_info_weight" 
																					id="coapplicant_pet_info_weight"
																					v-model="form.coapplicant_pet_info_weight"></td>
														</tr>
														<tr>
															<th scope="row">Race</th>
															<td><input type="text" value="" 
																					name="applicant_pet_info_race" 
																					id="applicant_pet_info_race"
																					v-model="form.applicant_pet_info_race"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_info_race" 
																					id="coapplicant_pet_info_race"
																					v-model="form.coapplicant_pet_info_race"></td>
														</tr>
														<tr>
															<th scope="row">Photo</th>
															<td><input type="file" name="pic" accept="image/*"></td>
															<td><input type="file" name="pic" accept="image/*"></td>
														</tr>
														<caption>Requirements </caption>
														<tr>
															<th scope="row">Leash</th>
															<td><input type="text" value="" 
																					name="applicant_pet_req_leash" 
																					id="applicant_pet_req_leash"
																					v-model="form.applicant_pet_req_leash"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_req_leash" 
																					id="coapplicant_pet_req_leash"
																					v-model="form.coapplicant_pet_req_leash"></td>
														</tr>
														<tr>
															<th scope="row">Service Dog Vest</th>
															<td><input type="text" value="" 
																					name="applicant_pet_req_service_dog_vest" 
																					id="applicant_pet_req_service_dog_vest"
																					v-model="form.applicant_pet_req_service_dog_vest"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_req_service_dog_vest" 
																					id="coapplicant_pet_req_service_dog_vest"
																					v-model="form.coapplicant_pet_req_service_dog_vest"></td>
														</tr>
														<tr>
															<th scope="row">Muzzle Basket</th>
															<td><input type="text" value="" 
																					name="applicant_pet_req_muzzle_basket" 
																					id="applicant_pet_req_muzzle_basket"
																					v-model="form.applicant_pet_req_muzzle_basket"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_req_muzzle_basket" 
																					id="coapplicant_pet_req_muzzle_basket"
																					v-model="form.coapplicant_pet_req_muzzle_basket"></td>
														</tr>
														<tr>
															<th scope="row">Hanger ID</th>
															<td><input type="text" value="" 
																					name="applicant_pet_req_hanger_id" 
																					id="applicant_pet_req_hanger_id"
																					v-model="form.applicant_pet_req_hanger_id"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_req_hanger_id" 
																					id="coapplicant_pet_req_hanger_id"
																					v-model="form.coapplicant_pet_req_hanger_id"></td>
														</tr>
														<tr>
															<th scope="row">Other</th>
															<td><input type="text" value="" 
																					name="applicant_pet_req_other" 
																					id="applicant_pet_req_other"
																					v-model="form.applicant_pet_req_other"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_req_other" 
																					id="coapplicant_pet_req_other"
																					v-model="form.coapplicant_pet_req_other"></td>
														</tr>
														<caption>License </caption>
														<tr>
															<th scope="row">No</th>
															<td><input type="text" value="" 
																					name="applicant_pet_license_no" 
																					id="applicant_pet_license_no"
																					v-model="form.applicant_pet_license_no"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_license_no" 
																					id="coapplicant_pet_license_no"
																					v-model="form.coapplicant_pet_license_no"></td>
														</tr>
														<tr>
															<th scope="row">Issued by</th>
															<td><input type="text" value="" 
																					name="applicant_pet_license_issued_by" 
																					id="applicant_pet_license_issued_by"
																					v-model="form.applicant_pet_license_issued_by"></td>
															<td><input type="text" value="" 
																					name="coapplicant_pet_license_issued_by" 
																					id="coapplicant_pet_license_issued_by"
																					v-model="form.coapplicant_pet_license_issued_by"></td>
														</tr>
														<tr>
															<th scope="row">Issue Date</th>
															<td><input type="date" value="" 
																					name="applicant_pet_license_issue_date" 
																					id="applicant_pet_license_issue_date"
																					v-model="form.applicant_pet_license_issue_date"></td>
															<td><input type="date" value="" 
																					name="coapplicant_pet_license_issue_date" 
																					id="coapplicant_pet_license_issue_date"
																					v-model="form.coapplicant_pet_license_issue_date"></td>
														</tr>
														<tr>
															<th scope="row">Expiry Date</th>
															<td><input type="date" value="" 
																					name="applicant_pet_license_expiry_date" 
																					id="applicant_pet_license_expiry_date"
																					v-model="form.applicant_pet_license_expiry_date"></td>
															<td><input type="date" value="" 
																					name="coapplicant_pet_license_expiry_date" 
																					id="coapplicant_pet_license_expiry_date"
																					v-model="form.coapplicant_pet_license_expiry_date"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i>Optional questions :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col"></th>
															<th scope="col">Applicant </th>
															<th scope="col">Co-Applicant </th>
															<th scope="col">Dependent 1</th>
															<th scope="col">Dependent 2</th>
															<th scope="col">Dependent 3</th>
															<th scope="col">Dependent 4</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Nationality</th>
															<td><input type="text" value="" 
																					name="applicant_optional_nationality" 
																					id="applicant_optional_nationality"
																					v-model="form.applicant_optional_nationality"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_nationality" 
																					id="coapplicant_optional_nationality"
																					v-model="form.coapplicant_optional_nationality"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_nationality" 
																					id="dependent_one_optional_nationality"
																					v-model="form.dependent_one_optional_nationality"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_nationality" 
																					id="dependent_two_optional_nationality"
																					v-model="form.dependent_two_optional_nationality"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_nationality" 
																					id="dependent_three_optional_nationality"
																					v-model="form.dependent_three_optional_nationality"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_nationality" 
																					id="dependent_four_optional_nationality"
																					v-model="form.dependent_four_optional_nationality"></td>
														</tr>
														<caption>Language </caption>
														<tr>
															<th scope="row">Primary </th>
															<td><input type="text" value="" 
																					name="applicant_optional_language_primary" 
																					id="applicant_optional_language_primary"
																					v-model="form.applicant_optional_language_primary"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_language_primary" 
																					id="coapplicant_optional_language_primary"
																					v-model="form.coapplicant_optional_language_primary"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_language_primary" 
																					id="dependent_one_optional_language_primary"
																					v-model="form.dependent_one_optional_language_primary"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_language_primary" 
																					id="dependent_two_optional_language_primary"
																					v-model="form.dependent_two_optional_language_primary"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_language_primary" 
																					id="dependent_three_optional_language_primary"
																					v-model="form.dependent_three_optional_language_primary"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_language_primary" 
																					id="dependent_four_optional_language_primary"
																					v-model="form.dependent_four_optional_language_primary"></td>
														</tr>
														<tr>
															<th scope="row">Second</th>
															<td><input type="text" value="" 
																					name="applicant_optional_language_second" 
																					id="applicant_optional_language_second"
																					v-model="form.applicant_optional_language_second"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_language_second" 
																					id="coapplicant_optional_language_second"
																					v-model="form.coapplicant_optional_language_second"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_language_second" 
																					id="dependent_one_optional_language_second"
																					v-model="form.dependent_one_optional_language_second"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_language_second" 
																					id="dependent_two_optional_language_second"
																					v-model="form.dependent_two_optional_language_second"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_language_second" 
																					id="dependent_three_optional_language_second"
																					v-model="form.dependent_three_optional_language_second"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_language_second" 
																					id="dependent_four_optional_language_second"
																					v-model="form.dependent_four_optional_language_second"></td>
														</tr>
														<caption>Residency Status</caption>
														<tr>
															<th scope="row">Citizen</th>
															<td><input type="text" value="" 
																					name="applicant_optional_residency_citizen" 
																					id="applicant_optional_residency_citizen"
																					v-model="form.applicant_optional_residency_citizen"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_residency_citizen" 
																					id="coapplicant_optional_residency_citizen"
																					v-model="form.coapplicant_optional_residency_citizen"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_residency_citizen" 
																					id="dependent_one_optional_residency_citizen"
																					v-model="form.dependent_one_optional_residency_citizen"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_residency_citizen" 
																					id="dependent_two_optional_residency_citizen"
																					v-model="form.dependent_two_optional_residency_citizen"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_residency_citizen" 
																					id="dependent_three_optional_residency_citizen"
																					v-model="form.dependent_three_optional_residency_citizen"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_residency_citizen" 
																					id="dependent_four_optional_residency_citizen"
																					v-model="form.dependent_four_optional_residency_citizen"></td>
														</tr>
														<tr>
															<th scope="row">Permanent Resident</th>
															<td><input type="text" value="" 
																					name="applicant_optional_residency_permanent" 
																					id="applicant_optional_residency_permanent"
																					v-model="form.applicant_optional_residency_permanent"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_residency_permanent" 
																					id="coapplicant_optional_residency_permanent"
																					v-model="form.coapplicant_optional_residency_permanent"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_residency_permanent" 
																					id="dependent_one_optional_residency_permanent"
																					v-model="form.dependent_one_optional_residency_permanent"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_residency_permanent" 
																					id="dependent_two_optional_residency_permanent"
																					v-model="form.dependent_two_optional_residency_permanent"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_residency_permanent" 
																					id="dependent_three_optional_residency_permanent"
																					v-model="form.dependent_three_optional_residency_permanent"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_residency_permanent" 
																					id="dependent_four_optional_residency_permanent"
																					v-model="form.dependent_four_optional_residency_permanent"></td>
														</tr>
														<tr>
															<th scope="row">Work Permit</th>
															<td><input type="text" value="" 
																					name="applicant_optional_residency_work_permit" 
																					id="applicant_optional_residency_work_permit"
																					v-model="form.applicant_optional_residency_work_permit"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_residency_work_permit" 
																					id="coapplicant_optional_residency_work_permit"
																					v-model="form.coapplicant_optional_residency_work_permit"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_residency_work_permit" 
																					id="dependent_one_optional_residency_work_permit"
																					v-model="form.dependent_one_optional_residency_work_permit"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_residency_work_permit" 
																					id="dependent_two_optional_residency_work_permit"
																					v-model="form.dependent_two_optional_residency_work_permit"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_residency_work_permit" 
																					id="dependent_three_optional_residency_work_permit"
																					v-model="form.dependent_three_optional_residency_work_permit"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_residency_work_permit" 
																					id="dependent_four_optional_residency_work_permit"
																					v-model="form.dependent_four_optional_residency_work_permit"></td>
														</tr>
														<tr>
															<th scope="row">Refugee</th>
															<td><input type="text" value="" 
																					name="applicant_optional_residency_refugee" 
																					id="applicant_optional_residency_refugee"
																					v-model="form.applicant_optional_residency_refugee"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_residency_refugee" 
																					id="coapplicant_optional_residency_refugee"
																					v-model="form.coapplicant_optional_residency_refugee"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_residency_refugee" 
																					id="dependent_one_optional_residency_refugee"
																					v-model="form.dependent_one_optional_residency_refugee"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_residency_refugee" 
																					id="dependent_two_optional_residency_refugee"
																					v-model="form.dependent_two_optional_residency_refugee"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_residency_refugee" 
																					id="dependent_three_optional_residency_refugee"
																					v-model="form.dependent_three_optional_residency_refugee"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_residency_refugee" 
																					id="dependent_four_optional_residency_refugee"
																					v-model="form.dependent_four_optional_residency_refugee"></td>
														</tr>
														<tr>
															<th scope="row">International Student</th>
															<td><input type="text" value="" 
																					name="applicant_optional_residency_student" 
																					id="applicant_optional_residency_student"
																					v-model="form.applicant_optional_residency_student"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_residency_student" 
																					id="coapplicant_optional_residency_student"
																					v-model="form.coapplicant_optional_residency_student"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_residency_student" 
																					id="dependent_one_optional_residency_student"
																					v-model="form.dependent_one_optional_residency_student"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_residency_student" 
																					id="dependent_two_optional_residency_student"
																					v-model="form.dependent_two_optional_residency_student"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_residency_student" 
																					id="dependent_three_optional_residency_student"
																					v-model="form.dependent_three_optional_residency_student"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_residency_student" 
																					id="dependent_four_optional_residency_student"
																					v-model="form.dependent_four_optional_residency_student"></td>
														</tr>
														<tr>
															<th scope="row">Other</th>
															<td><input type="text" value="" 
																					name="applicant_optional_residency_other" 
																					id="applicant_optional_residency_other"
																					v-model="form.applicant_optional_residency_other"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_residency_other" 
																					id="coapplicant_optional_residency_other"
																					v-model="form.coapplicant_optional_residency_other"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_residency_other" 
																					id="dependent_one_optional_residency_other"
																					v-model="form.dependent_one_optional_residency_other"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_residency_other" 
																					id="dependent_two_optional_residency_other"
																					v-model="form.dependent_two_optional_residency_other"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_residency_other" 
																					id="dependent_three_optional_residency_other"
																					v-model="form.dependent_three_optional_residency_other"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_residency_other" 
																					id="dependent_four_optional_residency_other"
																					v-model="form.dependent_four_optional_residency_other"></td>
														</tr>
														<caption>Current Status </caption>
														<tr>
															<th scope="row">Student</th>
															<td><input type="text" value="" 
																					name="applicant_optional_current_student" 
																					id="applicant_optional_current_student"
																					v-model="form.applicant_optional_current_student"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_current_student" 
																					id="coapplicant_optional_current_student"
																					v-model="form.coapplicant_optional_current_student"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_current_student" 
																					id="dependent_one_optional_current_student"
																					v-model="form.dependent_one_optional_current_student"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_current_student" 
																					id="dependent_two_optional_current_student"
																					v-model="form.dependent_two_optional_current_student"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_current_student" 
																					id="dependent_three_optional_current_student"
																					v-model="form.dependent_three_optional_current_student"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_current_student" 
																					id="dependent_four_optional_current_student"
																					v-model="form.dependent_four_optional_current_student"></td>
														</tr>
														<tr>
															<th scope="row">Married</th>
															<td><input type="text" value="" 
																					name="applicant_optional_current_married" 
																					id="applicant_optional_current_married"
																					v-model="form.applicant_optional_current_married"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_current_married" 
																					id="coapplicant_optional_current_married"
																					v-model="form.coapplicant_optional_current_married"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_current_married" 
																					id="dependent_one_optional_current_married"
																					v-model="form.dependent_one_optional_current_married"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_current_married" 
																					id="dependent_two_optional_current_married"
																					v-model="form.dependent_two_optional_current_married"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_current_married" 
																					id="dependent_three_optional_current_married"
																					v-model="form.dependent_three_optional_current_married"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_current_married" 
																					id="dependent_four_optional_current_married"
																					v-model="form.dependent_four_optional_current_married"></td>
														</tr>
														<tr>
															<th scope="row">Retired</th>
															<td><input type="text" value="" 
																					name="applicant_optional_current_retired" 
																					id="applicant_optional_current_retired"
																					v-model="form.applicant_optional_current_retired"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_current_retired" 
																					id="coapplicant_optional_current_retired"
																					v-model="form.coapplicant_optional_current_retired"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_current_retired" 
																					id="dependent_one_optional_current_retired"
																					v-model="form.dependent_one_optional_current_retired"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_current_retired" 
																					id="dependent_two_optional_current_retired"
																					v-model="form.dependent_two_optional_current_retired"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_current_retired" 
																					id="dependent_three_optional_current_retired"
																					v-model="form.dependent_three_optional_current_retired"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_current_retired" 
																					id="dependent_four_optional_current_retired"
																					v-model="form.dependent_four_optional_current_retired"></td>
														</tr>
														<caption>Is there any :</caption>
														<tr>
															<th scope="row">Special needs</th>
															<td><input type="text" value="" 
																					name="applicant_optional_any_special_needs" 
																					id="applicant_optional_any_special_needs"
																					v-model="form.applicant_optional_any_special_needs"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_any_special_needs" 
																					id="coapplicant_optional_any_special_needs"
																					v-model="form.coapplicant_optional_any_special_needs"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_any_special_needs" 
																					id="dependent_one_optional_any_special_needs"
																					v-model="form.dependent_one_optional_any_special_needs"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_any_special_needs" 
																					id="dependent_two_optional_any_special_needs"
																					v-model="form.dependent_two_optional_any_special_needs"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_any_special_needs" 
																					id="dependent_three_optional_any_special_needs"
																					v-model="form.dependent_three_optional_any_special_needs"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_any_special_needs" 
																					id="dependent_four_optional_any_special_needs"
																					v-model="form.dependent_four_optional_any_special_needs"></td>
														</tr>
														<tr>
															<th scope="row">Handicap</th>
															<td><input type="text" value="" 
																					name="applicant_optional_any_handicap" 
																					id="applicant_optional_any_handicap"
																					v-model="form.applicant_optional_any_handicap"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_any_handicap" 
																					id="coapplicant_optional_any_handicap"
																					v-model="form.coapplicant_optional_any_handicap"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_any_handicap" 
																					id="dependent_one_optional_any_handicap"
																					v-model="form.dependent_one_optional_any_handicap"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_any_handicap" 
																					id="dependent_two_optional_any_handicap"
																					v-model="form.dependent_two_optional_any_handicap"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_any_handicap" 
																					id="dependent_three_optional_any_handicap"
																					v-model="form.dependent_three_optional_any_handicap"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_any_handicap" 
																					id="dependent_four_optional_any_handicap"
																					v-model="form.dependent_four_optional_any_handicap"></td>
														</tr>
														<tr>
															<th scope="row">Rental Collection records</th>
															<td><input type="text" value="" 
																					name="applicant_optional_any_rental_collection_records" 
																					id="applicant_optional_any_rental_collection_records"
																					v-model="form.applicant_optional_any_rental_collection_records"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_any_rental_collection_records" 
																					id="coapplicant_optional_any_rental_collection_records"
																					v-model="form.coapplicant_optional_any_rental_collection_records"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_any_rental_collection_records" 
																					id="dependent_one_optional_any_rental_collection_records"
																					v-model="form.dependent_one_optional_any_rental_collection_records"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_any_rental_collection_records" 
																					id="dependent_two_optional_any_rental_collection_records"
																					v-model="form.dependent_two_optional_any_rental_collection_records"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_any_rental_collection_records" 
																					id="dependent_three_optional_any_rental_collection_records"
																					v-model="form.dependent_three_optional_any_rental_collection_records"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_any_rental_collection_records" 
																					id="dependent_four_optional_any_rental_collection_records"
																					v-model="form.dependent_four_optional_current_rental_collection_records"></td>
														</tr>
														<tr>
															<th scope="row">Evacuation Order</th>
															<td><input type="text" value="" 
																					name="applicant_optional_any_evacuation_order" 
																					id="applicant_optional_any_evacuation_order"
																					v-model="form.applicant_optional_any_evacuation_order"></td>
															<td><input type="text" value="" 
																					name="coapplicant_optional_any_evacuation_order" 
																					id="coapplicant_optional_any_evacuation_order"
																					v-model="form.coapplicant_optional_any_evacuation_order"></td>
															<td><input type="text" value="" 
																					name="dependent_one_optional_any_evacuation_order" 
																					id="dependent_one_optional_any_evacuation_order"
																					v-model="form.dependent_one_optional_any_evacuation_order"></td>
															<td><input type="text" value="" 
																					name="dependent_two_optional_any_evacuation_order" 
																					id="dependent_two_optional_any_evacuation_order"
																					v-model="form.dependent_two_optional_any_evacuation_order"></td>
															<td><input type="text" value="" 
																					name="dependent_three_optional_any_evacuation_order" 
																					id="dependent_three_optional_any_evacuation_order"
																					v-model="form.dependent_three_optional_any_evacuation_order"></td>
															<td><input type="text" value="" 
																					name="dependent_four_optional_any_evacuation_order" 
																					id="dependent_four_optional_any_evacuation_order"
																					v-model="form.dependent_four_optional_current_evacuation_order"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i>Consent Confirmation  :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>				
															<th scope="col"></th>
															<th scope="col">Applicant </th>
															<th scope="col">Co-Applicant </th>
															<th scope="col">Dependent 1</th>
															<th scope="col">Dependent 2</th>
															<th scope="col">Dependent 3</th>
															<th scope="col">Dependent 4</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th scope="row">Credit checks</th>
															<td><input type="text" value="" 
																					name="applicant_consent_credit_checks" 
																					id="applicant_consent_credit_checks"
																					v-model="form.applicant_consent_credit_checks"></td>
															<td><input type="text" value="" 
																					name="coapplicant_consent_credit_checks" 
																					id="coapplicant_consent_credit_checks"
																					v-model="form.coapplicant_consent_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_one_consent_credit_checks" 
																					id="dependent_one_consent_credit_checks"
																					v-model="form.dependent_one_consent_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_two_consent_credit_checks" 
																					id="dependent_two_consent_credit_checks"
																					v-model="form.dependent_two_consent_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_three_consent_credit_checks" 
																					id="dependent_three_consent_credit_checks"
																					v-model="form.dependent_three_consent_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_four_consent_credit_checks" 
																					id="dependent_four_consent_credit_checks"
																					v-model="form.dependent_four_consent_credit_checks"></td>
														</tr>
														<tr>
															<th scope="row">Background Check</th>
															<td><input type="text" value="" 
																					name="applicant_consent_background_credit_checks" 
																					id="applicant_consent_background_credit_checks"
																					v-model="form.applicant_consent_background_credit_checks"></td>
															<td><input type="text" value="" 
																					name="coapplicant_consent_background_credit_checks" 
																					id="coapplicant_consent_background_credit_checks"
																					v-model="form.coapplicant_consent_background_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_one_consent_background_credit_checks" 
																					id="dependent_one_consent_background_credit_checks"
																					v-model="form.dependent_one_consent_background_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_two_consent_background_credit_checks" 
																					id="dependent_two_consent_background_credit_checks"
																					v-model="form.dependent_two_consent_background_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_three_consent_background_credit_checks" 
																					id="dependent_three_consent_background_credit_checks"
																					v-model="form.dependent_three_consent_background_credit_checks"></td>
															<td><input type="text" value="" 
																					name="dependent_four_consent_background_credit_checks" 
																					id="dependent_four_consent_background_credit_checks"
																					v-model="form.dependent_four_consent_background_credit_checks"></td>
														</tr>
														<tr>
															<th scope="row">References</th>
															<td><input type="text" value="" 
																					name="applicant_consent_references" 
																					id="applicant_consent_references"
																					v-model="form.applicant_consent_references"></td>
															<td><input type="text" value="" 
																					name="coapplicant_consent_references" 
																					id="coapplicant_consent_references"
																					v-model="form.coapplicant_consent_references"></td>
															<td><input type="text" value="" 
																					name="dependent_one_consent_references" 
																					id="dependent_one_consent_references"
																					v-model="form.dependent_one_consent_references"></td>
															<td><input type="text" value="" 
																					name="dependent_two_consent_references" 
																					id="dependent_two_consent_references"
																					v-model="form.dependent_two_consent_references"></td>
															<td><input type="text" value="" 
																					name="dependent_three_consent_references" 
																					id="dependent_three_consent_references"
																					v-model="form.dependent_three_consent_references"></td>
															<td><input type="text" value="" 
																					name="dependent_four_consent_references" 
																					id="dependent_four_consent_references"
																					v-model="form.dependent_four_consent_references"></td>
														</tr>
														<tr>
															<th scope="row">Employment References</th>
															<td><input type="text" value="" 
																					name="applicant_consent_employment_references" 
																					id="applicant_consent_employment_references"
																					v-model="form.applicant_consent_employment_references"></td>
															<td><input type="text" value="" 
																					name="coapplicant_consent_employment_references" 
																					id="coapplicant_consent_employment_references"
																					v-model="form.coapplicant_consent_employment_references"></td>
															<td><input type="text" value="" 
																					name="dependent_one_consent_employment_references" 
																					id="dependent_one_consent_employment_references"
																					v-model="form.dependent_one_consent_employment_references"></td>
															<td><input type="text" value="" 
																					name="dependent_two_consent_employment_references" 
																					id="dependent_two_consent_employment_references"
																					v-model="form.dependent_two_consent_employment_references"></td>
															<td><input type="text" value="" 
																					name="dependent_three_consent_employment_references" 
																					id="dependent_three_consent_employment_references"
																					v-model="form.dependent_three_consent_employment_references"></td>
															<td><input type="text" value="" 
																					name="dependent_four_consent_employment_references" 
																					id="dependent_four_consent_employment_references"
																					v-model="form.dependent_four_consent_employment_references"></td>
														</tr>
														<tr>
															<th scope="row">Rental History</th>
															<td><input type="text" value="" 
																					name="applicant_consent_rental_history" 
																					id="applicant_consent_rental_history"
																					v-model="form.applicant_consent_rental_history"></td>
															<td><input type="text" value="" 
																					name="coapplicant_consent_rental_history" 
																					id="coapplicant_consent_rental_history"
																					v-model="form.coapplicant_consent_rental_history"></td>
															<td><input type="text" value="" 
																					name="dependent_one_consent_rental_history" 
																					id="dependent_one_consent_rental_history"
																					v-model="form.dependent_one_consent_rental_history"></td>
															<td><input type="text" value="" 
																					name="dependent_two_consent_rental_history" 
																					id="dependent_two_consent_rental_history"
																					v-model="form.dependent_two_consent_rental_history"></td>
															<td><input type="text" value="" 
																					name="dependent_three_consent_rental_history" 
																					id="dependent_three_consent_rental_history"
																					v-model="form.dependent_three_consent_rental_history"></td>
															<td><input type="text" value="" 
																					name="dependent_four_consent_rental_history" 
																					id="dependent_four_consent_rental_history"
																					v-model="form.dependent_four_consent_rental_history"></td>
														</tr>
														<tr>
															<th scope="row">Evictions</th>
															<td><input type="text" value="" 
																					name="applicant_consent_evictions" 
																					id="applicant_consent_evictions"
																					v-model="form.applicant_consent_evictions"></td>
															<td><input type="text" value="" 
																					name="coapplicant_consent_evictions" 
																					id="coapplicant_consent_evictions"
																					v-model="form.coapplicant_consent_evictions"></td>
															<td><input type="text" value="" 
																					name="dependent_one_consent_evictions" 
																					id="dependent_one_consent_evictions"
																					v-model="form.dependent_one_consent_evictions"></td>
															<td><input type="text" value="" 
																					name="dependent_two_consent_evictions" 
																					id="dependent_two_consent_evictions"
																					v-model="form.dependent_two_consent_evictions"></td>
															<td><input type="text" value="" 
																					name="dependent_three_consent_evictions" 
																					id="dependent_three_consent_evictions"
																					v-model="form.dependent_three_consent_evictions"></td>
															<td><input type="text" value="" 
																					name="dependent_four_consent_evictions" 
																					id="dependent_four_consent_evictions"
																					v-model="form.dependent_four_consent_evictions"></td>
														</tr>
														<tr>
															<th scope="row">School</th>
															<td><input type="text" value="" 
																					name="applicant_consent_school" 
																					id="applicant_consent_school"
																					v-model="form.applicant_consent_school"></td>
															<td><input type="text" value="" 
																					name="coapplicant_consent_school" 
																					id="coapplicant_consent_school"
																					v-model="form.coapplicant_consent_school"></td>
															<td><input type="text" value="" 
																					name="dependent_one_consent_school" 
																					id="dependent_one_consent_school"
																					v-model="form.dependent_one_consent_school"></td>
															<td><input type="text" value="" 
																					name="dependent_two_consent_school" 
																					id="dependent_two_consent_school"
																					v-model="form.dependent_two_consent_school"></td>
															<td><input type="text" value="" 
																					name="dependent_three_consent_school" 
																					id="dependent_three_consent_school"
																					v-model="form.dependent_three_consent_school"></td>
															<td><input type="text" value="" 
																					name="dependent_four_consent_school" 
																					id="dependent_four_consent_school"
																					v-model="form.dependent_four_consent_school"></td>
														</tr>
														<tr>
															<th scope="row">Personal Tax " Notice Of Assessment "</th>
															<td><input type="text" value="" 
																					name="applicant_consent_personal_tax" 
																					id="applicant_consent_personal_tax"
																					v-model="form.applicant_consent_personal_tax"></td>
															<td><input type="text" value="" 
																					name="coapplicant_consent_personal_tax" 
																					id="coapplicant_consent_personal_tax"
																					v-model="form.coapplicant_consent_personal_tax"></td>
															<td><input type="text" value="" 
																					name="dependent_one_consent_personal_tax" 
																					id="dependent_one_consent_personal_tax"
																					v-model="form.dependent_one_consent_personal_tax"></td>
															<td><input type="text" value="" 
																					name="dependent_two_consent_personal_tax" 
																					id="dependent_two_consent_personal_tax"
																					v-model="form.dependent_two_consent_personal_tax"></td>
															<td><input type="text" value="" 
																					name="dependent_three_consent_personal_tax" 
																					id="dependent_three_consent_personal_tax"
																					v-model="form.dependent_three_consent_personal_tax"></td>
															<td><input type="text" value="" 
																					name="dependent_four_consent_personal_tax" 
																					id="dependent_four_consent_personal_tax"
																					v-model="form.dependent_four_consent_personal_tax"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
										<div class="form-folder">
											<h3><i class="fa fa-hand-point-right"></i>Application Assessment Result :</h3>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>		 	 		 
															<th scope="col">Date</th>
															<th scope="col">Result </th>
															<th scope="col">Reason </th>
															<th scope="col">Comment</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><input type="date" value="" 
																					name="Assessment_date" 
																					id="Assessment_date"
																					v-model="form.Assessment_date"></td>
															<td>Approved</td>
															<td><input type="text" value="" 
																					name="Assessment_reason" 
																					id="Assessment_reason"
																					v-model="form.Assessment_reason"></td>
															<td><input type="text" value="" 
																					name="Assessment_comment" 
																					id="Assessment_comment"
																					v-model="form.Assessment_comment"></td>
														</tr>
														<tr>
															<td><input type="date" value="" 
																					name="Assessment_date" 
																					id="Assessment_date"
																					v-model="form.Assessment_date"></td>
															<td>Rejected</td>
															<td><input type="text" value="" 
																					name="Assessment_reason" 
																					id="Assessment_reason"
																					v-model="form.Assessment_reason"></td>
															<td><input type="text" value="" 
																					name="Assessment_comment" 
																					id="Assessment_comment"
																					v-model="form.Assessment_comment"></td>
														</tr>
													</tbody>	
												</table>
											</div>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div> 
	        <button :disabled="form.busy"  type="submit" v-show="!editmode" class="next action-button">Save <i class="fa fa-angle-right"></i></button>
			<button :disabled="form.busy"  type="submit" v-show="editmode" class="next action-button">Update <i class="fa fa-angle-right"></i></button>
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
                let uri = '/NewApplication';
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
		        this.form.put('/NewApplication/'+this.form.id)
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

            	
            	
        	    this.form.post('/NewApplication') .then(({ data }) => { 
               
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