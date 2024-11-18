<template> 
    <form id="msform" @submit.prevent="editmode ? updateNewPostingJobshousing() : createNewPostingJobshousing()" @keydown="form.onKeydown($event)">  
        <fieldset>
            <div class="form-card">
                <h1 class="page-head">New Posting-Housing Rental</h1> 
                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> Posting General Info:</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch"> 
                            <div class="col-md-12 col-sm-6 col-xs-12"> 
                                <div class="form-box-outer">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-6 col-xs-12"> 
                                            <div class="row">
                                                <div class="col-md-12 col-sm-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <h4>Posting No</h4>
                                                            <input type="text" id="posting_no" name="posting_no"  v-model="form.posting_no" placeholder="Posting No" disabled/> 
                                                        </div> 
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <h4>Posting Title</h4> 
                                                            <input type="text" id="genaral_posting_title" name="genaral_posting_title"  v-model="form.genaral_posting_title"placeholder="Type Posting Title"/>  
                                                        </div>  
                                                    </div>  
                                                </div> 
                                                <div class="col-md-12 col-sm-6 col-xs-12">
                                                    <h4>Posting Zoon:</h4> 
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-6 col-xs-12">   
                                                            <div class="form-holder">
                                                                <div class="form-check-inline">
                                                                    <input type="checkbox" id="landlord" name="landlord" v-model="form.landlord">
                                                                    <label for="landlord">Landlord</label><br>
                                                                    <input type="checkbox" id="leaseholder" name="leaseholder" v-model="form.leaseholder">
                                                                    <label for="leaseholder">Leaseholder</label><br>
                                                                    <input type="checkbox" id="tenant" name="tenant" v-model="form.tenant">
                                                                    <label for="tenant">Tenant</label><br>    
                                                                </div> 
                                                            </div>     
                                                        </div> 
                                                        <div class="col-md-4 col-sm-6 col-xs-12">   
                                                            <div class="form-holder">
                                                                <div class="form-check-inline"> 
                                                                    <input type="checkbox" id="shareholder" name="shareholder" v-model="form.shareholder">
                                                                    <label for="shareholder">Shareholder</label><br> 
                                                                    <input type="checkbox" id="employee" name="employee" v-model="form.employee">
                                                                    <label for="employee">Employee</label><br> 
                                                                    <input type="checkbox" id="servive_provider" name="servive_provider" v-model="form.servive_provider">
                                                                    <label for="servive_provider">Servive Provider</label><br>  
                                                                </div> 
                                                            </div>     
                                                        </div> 
                                                        <div class="col-md-4 col-sm-6 col-xs-12">     
                                                            <div class="form-holder">
                                                                <div class="form-check-inline">  
                                                                    <input type="checkbox" id="seller" name="seller" v-model="form.seller">
                                                                    <label for="seller">Seller</label><br> 
                                                                    <input type="checkbox" id="guest" name="guest" v-model="form.guest">
                                                                    <label for="guest">Guest</label><br>
                                                                    <input type="checkbox" id="visitor" name="visitor" v-model="form.visitor">
                                                                    <label for="visitor">Visitor</label><br>   
                                                                </div> 
                                                            </div>     
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-3 col-sm-6 col-xs-12"> 
                                                            <h4>Post By</h4>
                                                            <label class="fieldlabels">ID No:</label> 
                                                            <input type="text"  id="post_user_id" name="post_user_id" v-model="form.post_user_id"  placeholder="Type User ID No"/>
                                                        </div>
                                                        <div class="col-md-3 col-sm-6 col-xs-12"> 
                                                            <h4>&nbsp;</h4>
                                                            <label class="fieldlabels">Name:</label> 
                                                            <input type="text" id="post_name" name="post_name" v-model="form.post_name"  placeholder="Type  Name"/> 
                                                        </div> 
                                                <div class="col-md-3 col-sm-6 col-xs-12"> 
                                                    <h4>&nbsp;</h4>
                                                    <label class="fieldlabels">Rank:</label> 
                                                    <input type="text" id="post_rank" name="post_rank" v-model="form.post_rank"  placeholder="Type  Rank"/> 
                                                </div> 
                                                <div class="col-md-3 col-sm-6 col-xs-12">  
                                                    <h4>&nbsp;</h4>
                                                    <label class="fieldlabels">Poster's Account Type:</label> 
                                                    <div class="position-relative form-group">
                                                        <select type="select" id="posting_user_type" name="posting_user_type" v-model="form.posting_user_type" class="custom-select">
                                                            <option value="">Select</option>
                                                            <option value="1">Landlord</option>
                                                            <option value="2">Leaseholder</option>
                                                            <option value="3">Tenant</option>
                                                            <option value="4">Shareholder</option> 
                                                            <option value="5">Employee</option> 
                                                            <option value="6">Servive Provider</option> 
                                                            <option value="7">Seller</option> 
                                                            <option value="8">Guest</option> 
                                                            <option value="9">Visitor</option>  
                                                        </select>
                                                    </div> 
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-xs-12">  
                                                    <label class="fieldlabels">Posting Class :</label> 
                                                    <div class="position-relative form-group">
                                                        <select type="select" id="posting_class" name="posting_class"  v-model="form.posting_class" class="custom-select">
                                                            <option value="">Select</option>
                                                            <option value="1">Job</option>
                                                            <option value="2">Housing- Renatl</option>
                                                            <option value="3">Housing - Sales</option>
                                                            <option value="4">Housing- Lease </option> 
                                                            <option value="5">Serviecs </option>  
                                                        </select>
                                                    </div>
                                                </div> 
                                                <div class="col-md-3 col-sm-6 col-xs-12">  
                                                    <label class="fieldlabels">Payment Status :</label> 
                                                    <div class="position-relative form-group">
                                                        <select type="select" id="payment_status" name="payment_status"  v-model="form.payment_status" class="custom-select">
                                                            <option value="">Select</option>
                                                            <option value="1">Paid</option>
                                                            <option value="2">Unpaid </option> 
                                                        </select>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6 col-sm-6 col-xs-12">  
                                                    <label class="fieldlabels">Posting Status :</label> 
                                                    <div class="position-relative form-group">
                                                        <select type="select" id="posting_status" name="posting_status"  v-model="form.posting_status" class="custom-select">
                                                            <option value="">Select</option>
                                                            <option value="1">Posted</option>
                                                            <option value="2">Published</option>
                                                            <option value="3">Removed</option>
                                                            <option value="4">Expired</option> 
                                                            <option value="5">Re- Posted </option> 
                                                            <option value="6">Reported</option>
                                                            <option value="7">Deactivated</option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div> 
                                            <h4>About Employer</h4>
                                            <div class="row">
                                                <div class="col-md-3 col-sm-12 col-xs-12">
                                                    <label class="fieldlabels">Employer ID No:</label> 
                                                    <input type="text" id="employer_number" name="employer_number" v-model="form.employer_number" placeholder="Type Employer No"/> 
                                                    <label class="fieldlabels">Address :</label> 
                                                    <input type="text" id="company_address" name="company_address" v-model="form.company_address" placeholder="Type Address"/>  
                                                </div>
                                                <div class="col-md-3 col-sm-12 col-xs-12"> 
                                                    <label class="fieldlabels">Company Name :</label> 
                                                    <input type="text" id="employer_companay_name" name="employer_companay_name" v-model="form.employer_companay_name" placeholder="Type Company Name"/> 
                                                    <label class="fieldlabels">Website :</label> 
                                                    <input type="text" id="company_website" name="company_website" v-model="form.company_website" placeholder="Type Website"/>  
                                                </div>
                                                <div class="col-md-3 col-sm-12 col-xs-12">  
                                                    <label class="fieldlabels">Full Legal Name :</label> 
                                                    <input type="text" id="full_legal_name" name="full_legal_name" v-model="form.full_legal_name" placeholder="Type Full Legal Name"/> 
                                                    <label class="fieldlabels">About us  :</label> 
                                                    <input type="text" id="company_about_us" name="company_about_us" v-model="form.company_about_us" placeholder="Type About us"/> 
                                                </div> 
                                                <div class="col-md-3 col-sm-12 col-xs-12">  
                                                    <label class="fieldlabels">Contacts :</label> 
                                                    <input type="text" id="company_contacts" name="company_contacts" v-model="form.company_contacts" placeholder="Type Contacts"/>   
                                                </div>
                                            </div>
                                            <h4>Transaaction Types Date</h4>
                                            <div class="row">
                                                <div class="col-md-3 col-sm-12 col-xs-12">
                                                    <label class="fieldlabels">New Posting Date:</label> 
                                                    <date-picker id="new_posting_date" name="new_posting_date" v-model="form.new_posting_date" placeholder="Enter New Posting Date" lang="en" format="DD-MM-YYYY"></date-picker> 
                                                    <label class="fieldlabels">Renew Date :</label> 
                                                <date-picker id="renew_posting_date" name="renew_posting_date" v-model="form.renew_posting_date" placeholder="Enter Renew Date" lang="en" format="DD-MM-YYYY"></date-picker> 
                                                    <label class="fieldlabels">Reported Date :</label> 
                                                <date-picker id="reported_posting_date" name="reported_posting_date" v-model="form.reported_posting_date" placeholder="Enter Reported Date" lang="en" format="DD-MM-YYYY"></date-picker> 
                                                </div>
                                                <div class="col-md-3 col-sm-12 col-xs-12"> 
                                                    <label class="fieldlabels">Paid Date:</label> 
                                                    <date-picker id="Paid_posting_date" name="Paid_posting_date" v-model="form.Paid_posting_date" placeholder="Enter Date" lang="en" format="DD-MM-YYYY"></date-picker> 
                                                    <label class="fieldlabels">Edited  Date :</label> 
                                                    <date-picker id="edited_posting_date" name="edited_posting_date" v-model="form.edited_posting_date" placeholder="Enter Edited Date" lang="en" format="DD-MM-YYYY"></date-picker> 
                                                    <label class="fieldlabels">Validation Period Date :</label> 
                                                <date-picker id="validation_period_posting_date" name="validation_period_posting_date" v-model="form.validation_period_posting_date" placeholder="Enter Validation Period Date" lang="en" format="DD-MM-YYYY"></date-picker>
                                                </div>
                                                <div class="col-md-3 col-sm-12 col-xs-12">  
                                                    <label class="fieldlabels">Posted Date :</label> 
                                                    <date-picker id="posted_posting_date" name="posted_posting_date" v-model="form.posted_posting_date" placeholder="Enter Posted Date" lang="en" format="DD-MM-YYYY"></date-picker>
                                                    <label class="fieldlabels">Expired Date:</label> 
                                                    <date-picker id="expired_posting_date" name="expired_posting_date" v-model="form.expired_posting_date" placeholder="Enter Expired Date" lang="en" format="DD-MM-YYYY"></date-picker>
                                                    <label class="fieldlabels">Re- Posting Date  :</label> 
                                                    <date-picker id="re_posting_date" name="re_posting_date" v-model="form.re_posting_date" placeholder="Enter Re- Posting Date" lang="en" format="DD-MM-YYYY"></date-picker>
                                                </div> 
                                                <div class="col-md-3 col-sm-12 col-xs-12">  
                                                    <label class="fieldlabels">Publised Date :</label> 
                                                    <date-picker id="publised_posting_date" name="publised_posting_date" v-model="form.publised_posting_date" placeholder="Enter Publised Date" lang="en" format="DD-MM-YYYY"></date-picker> 
                                                    <label class="fieldlabels">Removing  Date :</label> 
                                                    <date-picker id="removing_posting_date" name="removing_posting_date" v-model="form.removing_posting_date" placeholder="Enter Removing  Date" lang="en" format="DD-MM-YYYY"></date-picker>  
                                                </div>
                                            </div>
                                            <h4>Landloard / Leaseholder Info</h4>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12 col-xs-12">
                                                    <label class="fieldlabels">ID No:</label> 
                                                    <input type="text" id="leaseholder_id_number" name="leaseholder_id_number" v-model="form.leaseholder_id_number" placeholder="Type ID No"/>  
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12"> 
                                                    <label class="fieldlabels">Name  :</label> 
                                                    <input type="text" id="leaseholder_name" name="leaseholder_name" v-model="form.leaseholder_name" placeholder="Type Name"/>  
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12"> 
                                                    <label class="fieldlabels">BMS- Contact Info :</label> 
                                                    <input type="text" id="bms_contact_info" name="bms_contact_info" v-model="form.bms_contact_info" placeholder="Type BMS- Contact Info"/>  
                                                </div>   
                                            </div>
                                            <h4>Property General Info </h4>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 col-xs-12">
                                                    <label class="fieldlabels">Building Name :</label> 
                                                    <input type="text" id="building_name" name="building_name" v-model="form.building_name" placeholder="Type Building Name"/>  
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-xs-12"> 
                                                    <label class="fieldlabels">Building Address  :</label> 
                                                    <input type="text" id="building_address" name="building_address" v-model="form.building_address" placeholder="Type Building Address"/>  
                                                </div>   
                                            </div>
                                            <div class="col-md-12 col-sm-6 col-xs-12">
                                                <h4>Property Type :</h4> 
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-6 col-xs-12">   
                                                        <div class="form-holder">
                                                            <div class="form-check-inline">
                                                                <input type="checkbox" id="studio" name="studio" v-model="form.studio">
                                                                <label for="studio">Studio</label><br>
                                                                <input type="checkbox" id="one_bed" name="one_bed" v-model="form.one_bed">
                                                                <label for="one_bed">1 Bed</label><br>
                                                                <input type="checkbox" id="two_bed" name="two_bed" v-model="form.two_bed">
                                                                <label for="two_bed">2 Bed</label><br>    
                                                            </div> 
                                                        </div>     
                                                    </div> 
                                                        <div class="col-md-4 col-sm-6 col-xs-12">   
                                                        <div class="form-holder">
                                                            <div class="form-check-inline"> 
                                                                <input type="checkbox" id="three_bed" name="three_bed" v-model="form.three_bed">
                                                                <label for="three_bed">3 Bed</label><br> 
                                                                <input type="checkbox" id="penthouse" name="penthouse" v-model="form.penthouse">
                                                                <label for="penthouse">Penthouse</label><br> 
                                                                <input type="checkbox" id="parking_stall" name="parking_stall" v-model="form.parking_stall">
                                                                <label for="parking_stall">Parking  Stall</label><br>  
                                                            </div> 
                                                        </div>     
                                                    </div> 
                                                    <div class="col-md-4 col-sm-6 col-xs-12">     
                                                        <div class="form-holder">
                                                            <div class="form-check-inline">  
                                                                <input type="checkbox" id="storage_lockers" name="storage_lockers" v-model="form.storage_lockers">
                                                                <label for="storage_lockers">Storage lockers</label><br> 
                                                                <input type="checkbox" id="commercial_unit" name="commercial_unit" v-model="form.commercial_unit">
                                                                <label for="commercial_unit">Commercial Unit </label><br>    
                                                            </div> 
                                                        </div>     
                                                    </div> 
                                                </div> 
                                                <h4>Property On Map:</h4> 
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12"> 
                                                        <label class="fieldlabels">Map Link:</label> 
                                                        <input type="text" id="map_link" name="map_link" v-model="form.map_link" placeholder="Type Map Link"/>  
                                                    </div>
                                                </div>  
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
                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i>Property Manage</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch"> 
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="form-box-outer">
                                    <table class="table"> 
                                        <thead>
                                            <tr>
                                                <th scope="col">Property Manage by</th>
                                                <th scope="col">Yes/No </th> 
                                                <th scope="col">ID No </th>
                                                <th scope="col">Contact</th>  
                                            </tr>
                                        </thead>
                                        <tbody style="border:none">   
                                              <tr v-for="(property_manage,index) in form.property_manage_data">
                                                <th width="35%" scope="row"><h6>{{property_manage.reference_value}}</h6> 
                                                    <input 
                                                        type="hidden"
                                                        v-bind:id="'property_manage_name_'+index"
                                                        placeholder="Type Name"
                                                        name="property_manage_name[]" 
                                                        v-model="property_manage.reference_id"/></th>
                                                 
                                                <td width="15%">
                                                    <div class="form-check-inline"> 
                                                        <input 
                                                            type="checkbox"
                                                            v-bind:id="'property_manage_status_'+index"
                                                            placeholder="Type check"
                                                            name="property_manage_status[]" 
                                                            v-model="property_manage.yes_no"/>
                                                    </div>
                                                </td> 
                                                <td width="25%">
                                                    <div class="form-check-inline">
                                                        <input 
                                                            type="text"
                                                            v-bind:id="'property_manage_id_'+index"
                                                            placeholder="Type Id NO"
                                                            name="property_manage_id[]" 
                                                            v-model="property_manage.id_no"/>
                                                    </div>
                                                </td>
                                                <td width="25%">
                                                    <div class="form-check-inline">
                                                        <input 
                                                            type="text"
                                                            v-bind:id="'property_manage_contact_'+index"
                                                            placeholder="Type Contact"
                                                            name="property_manage_contact[]" 
                                                            v-model="property_manage.property_manage_contact"/> 
                                                    </div>
                                                </td> 
                                            </tr> 
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
            <div class="form-card"> 
                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> Property Details :</h3> 
                    <div class="form-holder">
                        <div class="row align-self-stretch"> 
                            <div class="col-md-12 col-sm-6 col-xs-12"> 
                                <div class="form-box-outer">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-6 col-xs-12"> 
                                                <div class="row">
                                                <div class="col-md-3 col-sm-6 col-xs-12"> 
                                                    <h4>Number of</h4>
                                                    <label class="fieldlabels">Room:</label> 
                                                    <input type="text" id="number_of_room" name="number_of_room" v-model="form.number_of_room"  placeholder="Type  Room"/> 
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-xs-12"> 
                                                    <h4>&nbsp;</h4>
                                                    <label class="fieldlabels">Den :</label> 
                                                    <input type="text" id="number_of_den" name="number_of_den" v-model="form.number_of_den"  placeholder="Type  Den"/> 
                                                </div> 
                                                <div class="col-md-3 col-sm-6 col-xs-12"> 
                                                    <h4>&nbsp;</h4>  
                                                    <label class="fieldlabels">Solarium:</label> 
                                                    <input type="text" id="number_of_solarium" name="number_of_solarium"  v-model="form.number_of_solarium" placeholder="Type  Solarium"/> 
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-xs-12"> 
                                                    <h4>&nbsp;</h4>   
                                                    <label class="fieldlabels">Kitchen :</label> 
                                                    <input type="text" id="number_of_kitchen" name="number_of_kitchen" v-model="form.number_of_kitchen"  placeholder="Type  Kitchen"/> 
                                                </div>
                                            </div>
                                                
                                            <div class="row">
                                                <div class="col-md-3 col-sm-6 col-xs-12">  
                                                    <label class="fieldlabels">Bathroom :</label> 
                                                    <input type="text" id="number_of_bathroom" name="number_of_bathroom" v-model="form.number_of_bathroom"  placeholder="Type  Bathroom"/>  
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-xs-12"> 
                                                    <label class="fieldlabels">Washroom:</label> 
                                                    <input type="text" id="number_of_washroom" name="number_of_washroom" v-model="form.number_of_washroom" placeholder="Type  Washroom"/>  
                                                </div>  
                                                <div class="col-md-3 col-sm-6 col-xs-12"> 
                                                    <label class="fieldlabels">Size :</label> 
                                                    <div class="position-relative form-group">
                                                        <select type="select" id="contract_requited" name="contract_requited" v-model="form.contract_requited" class="custom-select">
                                                            <option value="">Select</option>
                                                            <option value="1">Sqft</option>
                                                            <option value="2">CM</option> 
                                                        </select>
                                                    </div>  
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-xs-12">  
                                                    <label class="fieldlabels"></label> 
                                                    <div class="position-relative form-group">
                                                        <input type="text" id="number_of_sqft" name="number_of_sqft" v-model="form.number_of_sqft"  placeholder="Type  Size"/>
                                                    </div>  
                                                </div> 
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12"> 
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Neighborhood </th>
                                                                <th>Name  </th>
                                                                <th>Address</th>
                                                                <th>Distance</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody >
                                                            <tr>
                                                                <td>
                                                                    <div class="position-relative form-group">
                                                                        <select type="select" id="neighborhood_type" name="neighborhood_type" v-model="form.neighborhood_type" class="custom-select">
                                                                            <option value="">Select</option>
                                                                            <option value="1">Bus Station</option>
                                                                            <option value="2">City Train Station</option>
                                                                            <option value="3">Collage</option>
                                                                            <option value="4">Fire Department</option> 
                                                                            <option value="5">Food Store</option> 
                                                                            <option value="6">Hospital</option> 
                                                                            <option value="7">Pharmacy</option>
                                                                            <option value="8">Playground</option>
                                                                            <option value="9">Police Station</option>
                                                                            <option value="10">Public Library</option>
                                                                            <option value="11">Public Parking</option>
                                                                            <option value="12">Public School</option>
                                                                            <option value="13">Shopping Center</option>
                                                                            <option value="14">University</option>
                                                                            <option value="15">Walking Clinic</option> 
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td><input type="text" id="neighborhood_id_no" name="neighborhood_id_no" v-model="form.neighborhood_id_no" placeholder="Type Name"/></td>
                                                                <td><input type="text" id="neighborhood_address" name="neighborhood_address" v-model="form.neighborhood_address"  placeholder="Type Address"/></td>
                                                                <td><input type="text" id="neighborhood_distance" name="neighborhood_distance" v-model="form.neighborhood_distance" placeholder="Type  Distance"/></td>
                                                            </tr>
                                                        </tbody>
                                                    </table> 
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12"> 
                                                    <label class="fieldlabels">Property On Map Link  :</label> 
                                                    <input type="text" id="neighborhood_map_link" name="neighborhood_map_link" v-model="form.neighborhood_map_link" placeholder="Type Map Link"/>    
                                                </div>  
                                            </div>
                                                
                                        </div> 
                                    </div> 
                                </div>
                            </div> 
                            
                            <div class="col-md-12 col-sm-6 col-xs-12"> 
                                <div class="form-box-outer">  
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12"> 
                                            <table class="table table-bordered detail" id="detail_table">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Yes/ No  </th>
                                                        <th>Size "Sqft"</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                </thead>
                                                <tbody > 
                                                    <tr class="parent" id="row123" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td colspan="4" class="text-primary">Adds On</td>    
                                                    </tr>
                                                    <tr class="child-row123" style="display:none;">
                                                        <td>Barbeques Allowed</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                        </td>
                                                        <td>
                                                            <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                        </td>
                                                    </tr>
                                                    <tr class="child-row123" style="display:none;">
                                                        <td>Balcony</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>
                                                    </tr>
                                                    <tr class="child-row123" style="display:none;">
                                                        <td>Storage Locker </td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>
                                                    </tr>
                                                    <tr class="child-row123" style="display:none;">
                                                        <td>Parking  </td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>
                                                    </tr>
                                                    <tr class="child-row123" style="display:none;">
                                                        <td>Furnished</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>
                                                    </tr>
                                                    <tr class="parent" id="row124" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td colspan="4" class="text-primary">Appliances Included </td>    
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Freezer</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>
                                                    </tr> 
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Refrigerator </td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Ceiling Fan  </td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Dining table</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Dishwasher</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Washing Machine</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Dryer</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Air Conditioner</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Heater</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td> 
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Oven</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>  
                                                    </tr> 
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Microwave</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>  
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Toaster Oven</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Coffee Maker</td>  
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td> 
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Garbage Disposal</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Water Purifier</td> 
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>  
                                                    </tr>
                                                    <tr class="child-row124" style="display:none;">
                                                        <td>Security Camers</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="parent" id="row125" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td>Smoke Allowed</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="parent" id="row126" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td>Pet Allowed </td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>
                                                    <tr class="parent" id="row127" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td>Air Conditioning </td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="parent" id="row128" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td colspan="4" class="text-primary">Utilities Included </td>    
                                                    </tr>
                                                    <tr class="child-row128" style="display:none;"> 
                                                        <td>Hydro/ Electricity</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="child-row128" style="display:none;"> 
                                                        <td>Heat </td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>
                                                        <tr class="child-row128" style="display:none;"> 
                                                        <td>Water  </td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>
                                                    <tr class="child-row128" style="display:none;"> 
                                                        <td>Phone</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>
                                                    <tr class="child-row128" style="display:none;"> 
                                                        <td>Internet</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>




                                                    <tr class="parent" id="row128" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td>Elevator</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="parent" id="row128" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td>Garbage Chute</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="parent" id="row128" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td>Concierge Services</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="parent" id="row128" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td>Garden / Patio </td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    

                                                    <tr class="parent" id="row129" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td colspan="4" class="text-primary">Amenities</td>    
                                                    </tr>

                                                    <tr class="child-row129" style="display:none;"> 
                                                        <td>Gym</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>


                                                    <tr class="child-row129" style="display:none;"> 
                                                        <td>Swimming Pool </td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="child-row129" style="display:none;"> 
                                                        <td>Sauna</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="child-row129" style="display:none;"> 
                                                        <td>Library room</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="child-row129" style="display:none;"> 
                                                        <td>Business room</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="child-row129" style="display:none;"> 
                                                        <td>Handicap' Accessible</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="child-row129" style="display:none;"> 
                                                        <td>Parcells & Package Services</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="parent" id="row130" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td colspan="4" class="text-primary">In Side- Safety and Security </td>    
                                                    </tr>

                                                    <tr class="child-row130" style="display:none;"> 
                                                        <td>Security Camers </td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>


                                                    <tr class="child-row130" style="display:none;"> 
                                                        <td>Fire Extinguisher </td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="child-row130" style="display:none;"> 
                                                        <td>Smoke Detector</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="child-row130" style="display:none;"> 
                                                        <td>Sprinkler </td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>


                                                    <tr class="parent" id="row131" title="Click to expand/collapse" style="cursor: pointer;"> 
                                                        <td colspan="4" class="text-primary">Building Safety and Security </td>    
                                                    </tr>

                                                    <tr class="child-row131" style="display:none;"> 
                                                        <td>Security Camers </td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>  
                                                    <tr class="child-row131" style="display:none;"> 
                                                        <td>Fire Extinguisher </td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="child-row131" style="display:none;"> 
                                                        <td>Smoke Detector</td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="child-row131" style="display:none;"> 
                                                        <td>Sprinkler </td>
                                                        <td> 
                                                            <div class="position-relative form-group">
                                                                <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                    <option value="">Select</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                                </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                    </td>   
                                                    </tr>

                                                    <tr class="child-row131" style="display:none;"> 
                                                        <td>Security staff </td>
                                                            <td> 
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="1">Yes</option>
                                                                        <option value="2">No</option>
                                                                    </select>
                                                                    </div>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Size/Sqft"/>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Comment "/>
                                                            </td>   
                                                    </tr>
                                                </tbody>
                                            </table> 
                                        </div> 
                                    </div>
                                    
                                     <div class="row"> 
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Allowed</h4>
                                                <div class="form-holder">
                                                    <div class="form-check-inline">
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <input type="checkbox" id="allowed_bbq" name="allowed_bbq" v-model="form.allowed_bbq">
                                                                <label for="allowed_bbq">BBQ </label></br>
                                                                 <input type="checkbox" id="allowed_smoke" name="allowed_smoke" v-model="form.allowed_smoke">
                                                                <label for="allowed_smoke">Smoke</label></br>  
                                                                <input type="checkbox" id="allowed_pet" name="allowed_pet" v-model="form.allowed_pet">
                                                                <label for="allowed_pet">Pet </label></br>
                                                                 <input type="checkbox" id="allowed_max_guest" name="allowed_max_guest" v-model="form.allowed_max_guest">
                                                                <label for="allowed_max_guest">Max Guest </label>    
                                                            </div>  
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div> 
                                        </div>  
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Restrictions </h4>
                                                <div class="form-holder">
                                                    <div class="form-check-inline">
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <input type="checkbox" id="restrictions_air_bnb" name="restrictions_air_bnb" v-model="form.restrictions_air_bnb">
                                                                <label for="restrictions_air_bnb">Air Bnb </label></br>
                                                                <input type="checkbox" id="restrictions_sublease" name="restrictions_sublease" v-model="form.restrictions_sublease">
                                                                <label for="restrictions_sublease">Sublease </label></br>  
                                                                <input type="checkbox" id="restrictions_max_tenant" name="restrictions_max_tenant" v-model="form.restrictions_max_tenant">
                                                                <label for="restrictions_max_tenant">Max Tenant  </label></br>
                                                                <input type="checkbox" id="restrictions_shared_room" name="restrictions_shared_room" v-model="form.restrictions_shared_room">
                                                                <label for="restrictions_shared_room">Shared room</label>    
                                                            </div>  
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div> 
                                        </div> 
                                         <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>After Hours </h4>
                                                <div class="form-holder">
                                                    <div class="form-check-inline">
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                 <input type="checkbox" id="no_music" name="no_music" v-model="form.no_music">
                                                                <label for="no_music">No Music  </label></br>
                                                                  <input type="checkbox" id="no_landry_and_washing_machine" name="no_landry_and_washing_machine" v-model="form.no_landry_and_washing_machine">
                                                                <label for="no_landry_and_washing_machine">NO Landry and Washing Machine</label>  
                                                            </div>  
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div> 
                                        </div>  
                                    </div> 

                                    <div class="row"> 
                                        <div class="col-md-12 col-sm-12 col-xs-12"> 
                                            <table class="table table-bordered detail" id="detail_table">
                                            <thead class="thead-light">
                                            <tr>
                                            <th>Financial Info  </th>
                                            <th>Currency </th>
                                            <th>Amount </th>
                                            <th>Calender Date </th>
                                            <th>Comment  </th>
                                            </tr>
                                            </thead>
                                            <tbody > 
                                            <tr class="parent" id="row223" title="Click to expand/collapse" style="cursor: pointer;">  
                                            <td>Monthly Rent<input type="hidden" id="monthly_rent" name="monthly_rent" v-model="form.monthly_rent" value="1" placeholder="Type ID No"/></td>
                                            <td>
                                            <div class="position-relative form-group">
                                            <select type="select" id="property_manage_by_status" name="monthly_rent_status" class="custom-select">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                            </select>
                                            </div>
                                            </td>
                                            <td>
                                            <input type="text" id="property_manage_id_no" name="property_manage_id_no" placeholder="Type ID No"/></td>

                                            <td><input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Contact No"/></td>

                                            <td><input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Contact No"/></td>
                                            </tr>
                                            <tr class="parent" id="row223" title="Click to expand/collapse" style="cursor: pointer;">  
                                            <td>Registration fee </td>
                                            <td>
                                            <div class="position-relative form-group">
                                            <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                            </select>
                                            </div>
                                            </td>
                                            <td><input type="text" id="property_manage_id_no" name="property_manage_id_no" placeholder="Type ID No"/></td>
                                            <td><input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Contact No"/></td>
                                            <td><input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Contact No"/></td>
                                            </tr>
                                            <tr class="parent" id="row223" title="Click to expand/collapse" style="cursor: pointer;">  
                                            <td>Down Payment</td>
                                            <td>
                                            <div class="position-relative form-group">
                                            <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                            </select>
                                            </div>
                                            </td>
                                            <td><input type="text" id="property_manage_id_no" name="property_manage_id_no" placeholder="Type ID No"/></td>
                                            <td><input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Contact No"/></td>
                                            <td><input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Contact No"/></td>
                                            </tr>
                                            <tr class="parent" id="row223" title="Click to expand/collapse" style="cursor: pointer;">  
                                            <td>Damage Deposit</td>
                                            <td>
                                            <div class="position-relative form-group">
                                            <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                            </select>
                                            </div>
                                            </td>
                                            <td><input type="text" id="property_manage_id_no" name="property_manage_id_no" placeholder="Type ID No"/></td>
                                            <td><input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Contact No"/></td>
                                            <td><input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Contact No"/></td>
                                            </tr>
                                            <tr class="parent" id="row223" title="Click to expand/collapse" style="cursor: pointer;">  
                                            <td>Pet Damage Deposit </td>
                                            <td>
                                            <div class="position-relative form-group">
                                            <select type="select" id="property_manage_by_status" name="property_manage_by_status" class="custom-select">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                            </select>
                                            </div>
                                            </td>
                                            <td><input type="text" id="property_manage_id_no" name="property_manage_id_no" placeholder="Type ID No"/></td>
                                            <td><input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Contact No"/></td>
                                            <td><input type="text" id="property_manage_contact" name="property_manage_contact" placeholder="Type Contact No"/></td>
                                            </tr> 
                                            </tbody>
                                            </table> 
                                        </div>   
                                    </div> 

                                    <div class="row"> 
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-box-outer">
                                                <h4>Payment Methods:</h4>
                                                <div class="form-holder">
                                                    <div class="form-check-inline">
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                 <input type="checkbox" id="pre_authorized_payment" name="pre_authorized_payment" v-model="form.pre_authorized_payment">
                                                                <label for="pre_authorized_payment">Pre- Authorized Payment "PAP"</label><br>
                                                                 <input type="checkbox" id="email_transfer" name="email_transfer" v-model="form.email_transfer">
                                                                <label for="email_transfer">Email Transfer </label><br>   
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 col-xs-12"> 
                                                                <input type="checkbox" id="cash" name="cash" v-model="form.cash">
                                                                <label for="cash">Cash </label>  
                                                                <input type="checkbox" id="check" name="check" v-model="form.check">
                                                                <label for="check">Check </label><br>
                                                                 <input type="checkbox" id="credit_card" name="credit_card" v-model="form.credit_card">
                                                                <label for="credit_card">Credit Card </label><br> 
                                                            </div>  
                                                        </div>
                                                    </div> 
                                                </div>
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
                <div class="form-folder"> 
                    <div class="form-holder">
                        <div class="row align-self-stretch"> 
                            <div class="col-md-12 col-sm-4 col-xs-12"> 
                                <div class="form-box-outer">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-6 col-xs-12">  
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 col-xs-12"> 
                                                    <label class="fieldlabels"><h4>Move in- Out Requirements :</h4></label> 
                                                    <input type="text" id="move_in_out_requirements" name="move_in_out_requirements" placeholder="Type Move in- Out Requirements" v-model="form.move_in_out_requirements"/>   
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12"> 
                                                    <h4>Availability</h4> 
                                                         <date-picker id="availability_date" name="availability_date" v-model="form.availability_date" placeholder="Enter Removing  Date" lang="en" format="DD-MM-YYYY"></date-picker>    
                                                </div>  
                                            </div> 
                                            <div class="row"> 
                                                <div class="col-md-12 col-sm-6 col-xs-12"> 
                                                    <h4>Open house Schedules(Date and Time)</h4>  
                                                </div> 
                                            </div>
                                            <div class="row">   
                                                <div class="col-md-6 col-sm-6 col-xs-12">  
                                                        <label class="fieldlabels">Saturday:</label>
                                                        <date-picker id="saturday_schedules_date" name="saturday_schedules_date" v-model="form.saturday_schedules_date" placeholder="Enter Removing  Date" lang="en" format="DD-MM-YYYY"></date-picker><br>      
                                                        <label class="fieldlabels">Sunday:&nbsp;&nbsp;&nbsp;</label>   
                                                        <date-picker id="sunday_schedules_date" name="sunday_schedules_date" v-model="form.sunday_schedules_date" placeholder="Enter Removing  Date" lang="en" format="DD-MM-YYYY"></date-picker><br>  
                                                        <label class="fieldlabels">Monday :&nbsp;</label> 
                                                         <date-picker id="monday_schedules_date" name="monday_schedules_date" v-model="form.monday_schedules_date" placeholder="Enter Removing  Date" lang="en" format="DD-MM-YYYY"></date-picker>     
                                                </div> 
                                                <div class="col-md-6 col-sm-6 col-xs-12"> 
                                                    <label class="fieldlabels">Tuesday:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> 
                                                         <date-picker id="tuesday_schedules_date" name="tuesday_schedules_date" v-model="form.tuesday_schedules_date" placeholder="Enter Removing  Date" lang="en" format="DD-MM-YYYY"></date-picker><br>   
                                                        <label class="fieldlabels">Wednesday:</label> 
                                                        <date-picker id="wednesday_schedules_date" name="wednesday_schedules_date" v-model="form.wednesday_schedules_date" placeholder="Enter Removing  Date" lang="en" format="DD-MM-YYYY"></date-picker><br>    
                                                        <label class="fieldlabels">Thursday:&nbsp;&nbsp;&nbsp;&nbsp;</label>   
                                                         <date-picker id="thursday_schedules_date" name="thursday_schedules_date" v-model="form.thursday_schedules_date" placeholder="Enter Removing  Date" lang="en" format="DD-MM-YYYY"></date-picker>     
                                                </div> 
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
                    <div class="row align-self-stretch">  
                        <div class="col-md-12 col-sm-6 col-xs-12">  
                            <div class="row"> 
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-box-outer">
                                        <h4>Tenant Screening requirement:</h4>
                                        <div class="form-holder">
                                            <div class="form-check-inline">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="checkbox" id="medical_test" name="medical_test" v-model="form.medical_test">
                                                        <label for="medical_test">Medical Test</label><br>
                                                        <input type="checkbox" id="drug_test" name="drug_test" v-model="form.drug_test">
                                                        <label for="drug_test">Drug Test</label><br>  
                                                         <input type="checkbox" id="criminal_check" name="criminal_check" v-model="form.criminal_check">
                                                        <label for="criminal_check">Criminal Check </label><br>
                                                         <input type="checkbox" id="work_place" name="work_place" v-model="form.work_place">
                                                        <label for="work_place">Work Place</label><br> 
                                                         <input type="checkbox" id="neighbourhood" name="neighbourhood" v-model="form.neighbourhood">
                                                        <label for="neighbourhood">Neighbourhood</label><br>
                                                        <input type="checkbox" id="credit_check" name="credit_check" v-model="form.credit_check">
                                                        <label for="credit_check">Credit Check</label>  
                                                    </div> 
                                                </div>
                                            </div> 
                                        </div>
                                    </div> 
                                </div>    
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-box-outer">
                                        <h4>References :</h4>
                                        <div class="form-holder">
                                            <div class="form-check-inline">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                         <input type="checkbox" id="references_personal" name="references_personal" v-model="form.references_personal">
                                                        <label for="references_personal">Personal</label><br>
                                                        <input type="checkbox" id="references_work" name="references_work" v-model="form.references_work">
                                                        <label for="references_work">Work</label><br> 
                                                         <input type="checkbox" id="references_school" name="references_school" v-model="form.references_school">
                                                        <label for="references_school">School </label><br>   
                                                         <input type="checkbox" id="references_living_area" name="references_living_area" v-model="form.references_living_area">
                                                        <label for="references_living_area">Living area </label> 
                                                    </div>  
                                                </div>
                                            </div> 
                                        </div>
                                    </div> 
                                </div>    
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-box-outer">
                                        <h4>Interview Method:</h4>
                                        <div class="form-holder">
                                            <div class="form-check-inline">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="checkbox" id="method_online" name="method_online" v-model="form.method_online">
                                                        <label for="method_online">Online</label><br>
                                                       <input type="checkbox" id="method_phone" name="method_phone" v-model="form.method_phone">
                                                        <label for="method_phone">Phone </label><br>   
                                                        <input type="checkbox" id="method_in_person" name="method_in_person" v-model="form.method_in_person">
                                                        <label for="method_in_person">In Person </label>   
                                                    </div> 
                                                </div>
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
                <div class="form-folder"> 
                    <div class="form-holder">
                        <div class="row align-self-stretch"> 
                            <div class="col-md-12 col-sm-4 col-xs-12"> 
                                <div class="form-box-outer"> 
                                    <div class="row"> 
                                        <div class="col-md-12 col-sm-6 col-xs-12"> 
                                            <h4>Tenant Responsibilities  </h4>  
                                            <input type="text" id="tenant_responsibilities" name="tenant_responsibilities" placeholder="Type BTenant Responsibilities"  v-model="form.tenant_responsibilities"/> 
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
                            <div class="col-md-12 col-sm-4 col-xs-12"> 
                                <div class="form-box-outer">  
                                        <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-box-outer">
                                                        <h4>Terms of agreement</h4>
                                                        <p>The Terms of Service Agreement is mainly used for legal purposes by companies which provide software or services, such as web browsers, e-commerce, web search engines, social media, and transport services.<br><br>
        
                                                        A legitimate terms-of-service agreement is legally binding and may be subject to change.[2] Companies can enforce the terms by refusing service. Customers can enforce by filing a lawsuit or arbitration case if they can show they were actually harmed by a breach of the terms. There is a heightened risk of data going astray during corporate changes, including mergers, divestitures, buyouts, downsizing, etc., when data can be transferred improperly.[3] <br><br>
        
        
                                                        The Terms of Service Agreement is mainly used for legal purposes by companies which provide software or services, such as web browsers, e-commerce, web search engines, social media, and transport services.<br><br>
        
                                                        A legitimate terms-of-service agreement is legally binding and may be subject to change.[2] Companies can enforce the terms by refusing service. Customers can enforce by filing a lawsuit or arbitration case if they can show they were actually harmed by a breach of the terms. There is a heightened risk of data going astray during corporate changes, including mergers, divestitures, buyouts, downsizing, etc., when data can be transferred improperly.[3] </p>
            
                                                            
                                                    <h4>Accept</h4>
                                                    <div class="form-holder">
                                                        <div class="form-check-inline">
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-12 col-xs-12">
                                                                    <input type="checkbox" id="trems_accept" name="trems_accept" v-model="form.trems_accept">        
                                                                </div>   
                                                            </div>
                                                        </div> 
                                                    </div>            
                                                </div>  
                                            </div> 
                                        </div> 
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div> 
             <button :disabled="form.busy"  type="submit" v-show="!editmode" class="action-button">Save</button>
			<button :disabled="form.busy"   type="submit" v-show="editmode" class="action-button">Update</button>
            
        </fieldset> 
    </form> 
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
                   posting_class:1,
                   post_name: '',
                   post_user_id: '',
                   posting_user_type:0, 
                   posting_status:0,
                   creating_date: '',
                   approved_date: '',
                   validation_period_date: '',
                   expiration_date: '', 
                   employer_number: '',
                   employer_companay_name: '',
                   full_legal_name: '',
                   company_address: '',
                   company_website: '',
                   company_contacts: '',
                   company_about_us: '',
                   posting_title: '',
                   job_title: '', 
                   Employment_self_employed:0,
                   full_part_time:0,
                   hourly_rate: '',
                   monthly_salary: '',
                   posting_benefits: '',
                   job_description: '',
                   posting_responsibilities: '',
                   education_lavel: '',
                   posting_skills: '', 
                   job_experience:0,
                   permit_license:0,
                   work_location: '',
                   days_hours:0,
                   overtime_allowed:0,
                   probation_period:0, 
                   posting_bondable:0,
                   contract_requited:0, 
                   medical_test:false,
                   drug:false,
                   criminal_check:false,
                   personal:false,
                   work:false,
                   school:false,
                   living_area:false,
                   online:false,
                   phone:false,
                   in_person:false,
                   posting_note: '', 
                   posting_accept:0, 
                   property_manage_data:[],
            	}), 
                countries:'',
                property_manage_arr:[],
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchNewPostingJobsHousing();
           
        },
		
	    methods: {

	    	check_management_type(e,type)
            {
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

	    	check_operation_type(e,type)
            {
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
            
	        fetchNewPostingJobsHousing()
            {
                let uri = '/PostingHousingRental';
                window.axios.get(uri).then((response) => 
                { 
                  
                	this.countries 								=response.data.country_arr;
                    this.property_manage_arr 					=response.data.property_manage_arr;

                     for(let i=0; i<this.property_manage_arr.length; i++){

                        this.form.property_manage_data.push({
 
                            'id':'',
                            'reference_id':this.property_manage_arr[i].id,
                            'reference_value':this.property_manage_arr[i].property_manage_name,
                            'id_no':'',
                            'cantact':'',
                            'yes_no':false,
                             
                            
                        
                        });
                    }


                  /* this.account_no=response.data.account_no;
                   this.posting_class=response.data.posting_class;
                   this.post_name=response.data.post_name;
                   this.post_user_id=response.data.post_user_id;
                   this.posting_user_type=response.data.posting_user_type; 
                   this.posting_status=response.data.posting_status;
                   this.creating_date=response.data.creating_date;
                   this.approved_date=response.data.approved_date;
                   this.validation_period_date=response.data.validation_period_date;
                   this.expiration_date=response.data.expiration_date;
                   this.employer_number=response.data.employer_number;
                   this.employer_companay_name=response.data.employer_companay_name;
                   this.full_legal_name=response.data.full_legal_name;
                   this.company_address=response.data.company_address;
                   this.company_website=response.data.company_website;
                   this.company_contacts=response.data.company_contacts;
                   this.company_about_us=response.data.company_about_us;
                   this.posting_title=response.data.posting_title;
                   this.job_title=response.data.job_title;
                   this.Employment_self_employed=response.data.Employment_self_employed;
                   this.full_part_time=response.data.full_part_time;
                   this.hourly_rate=response.data.hourly_rate;
                   this.monthly_salary=response.data.monthly_salary;
                   this.posting_benefits=response.data.posting_benefits;
                   this.job_description=response.data.job_description;
                   this.posting_responsibilities=response.data.posting_responsibilities;
                   this.education_lavel=response.data.education_lavel;
                   this.posting_skills=response.data.posting_skills;
                   this.job_experience=response.data.job_experience;
                   this.permit_license=response.data.permit_license;
                   this.work_location=response.data.work_location;
                   this.days_hours=response.data.days_hours;
                   this.overtime_allowed=response.data.overtime_allowed;
                   this.probation_period=response.data.probation_period; 
                   this.posting_bondable=response.data.posting_bondable;
                   this.contract_requited=response.data.contract_requited;
                   this.medical_test=response.data.medical_test;
                   this.drug=response.data.drug;
                   this.criminal_check=response.data.criminal_check;
                   this.personal=response.data.personal;
                   this.work=response.data.work;
                   this.school=response.data.school;
                   this.living_area=response.data.living_area;
                   this.online=response.data.online;
                   this.phone=response.data.phone;
                   this.in_person=response.data.in_person;
                   this.posting_note=response.data.posting_note;
                   this.posting_accept=response.data.posting_accept;*/
                	
                });   
            },

          
         
       

            updateNewPostingJobs()
            {
            
			 
		        this.form.put('/PostingJobs/'+this.form.id)
				    .then(()=>{
					       //success
					     
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchNewPostingJobs();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createNewPostingJobshousing()
            {
 
        	    this.form.post('/PostingHousingRental') .then(({ data }) => 
                {  
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
	 $(document).ready(function () 
     {  
            $('tr.parent')  
                .css("cursor", "pointer")  
                .attr("title", "Click to expand/collapse")  
                .click(function () {  
                    $(this).siblings('.child-' + this.id).toggle();  
                });  
            $('tr[@class^=child-]').hide().children('td');  
    });  
</script>
 