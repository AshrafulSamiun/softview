<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateCustomerProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Building Information</h1>
                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> General Information:</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                            	<div class="form-box-outer">
                            		
                                    
									<div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                    		<label class="fieldlabels">Sub- Company:</label>  
                                    		
                                            <select v-model="form.company_name"
                                                name="company_name"
                                                class="custom-select" 
                                                @change="change_customer"
                                                :class="{ 'is-invalid': form.errors.has('company_name') }">
                                                <option disabled value="">--Select Sub- Company-- </option>
                                                <option v-for="(company,index) in company_arr" :value="index" >{{company}}</option>
                                            </select>
                                            <has-error :form="form" field="company_name"></has-error>
										</div>
									</div>                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Property Customer:</label>  
                                            
                                            <select v-model="form.customer_name"
                                                name="customer_name"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('customer_name') }">
                                                <option disabled value="">--Select Property Customer-- </option>
                                                 <option v-for="(customer,index) in customer_arr" :value="index">{{customer}}</option>
                                            </select>
                                            <has-error :form="form" field="customer_name"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Building No:</label> 
                                            <input v-model="form.building_no" 
                                                type="text" 
                                                name="building_no" 
                                                placeholder="Auto Generated""
                                                :class="{ 'is-invalid': form.errors.has('building_no') }" disabled/>
                                            <has-error :form="form" field="building_no"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Building Name:</label> 
                                            <input v-model="form.building_name" 
                                                type="text" 
                                                name="building_name" 
                                                placeholder="Type Building Name" 
                                                :class="{ 'is-invalid': form.errors.has('building_name') }"/>
                                                 <has-error :form="form" field="building_name"></has-error> 
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                           
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                                
                                    <h4>Floor Details:</h4>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Number of Floors:</label> 
                                            <input v-model="form.number_of_floor" 
												type="number" 
												name="number_of_floor" 
												placeholder="Type Floors Number" 
												:class="{ 'is-invalid': form.errors.has('number_of_floor') }"/>
											     <has-error :form="form" field="number_of_floor"></has-error> 
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Upper:</label> 
                                            <input v-model="form.number_of_upper_floor" 
												type="number" 
												name="number_of_upper_floor" 
                                                @change="generate_floor(1)"
												placeholder="Type Upper" 
												:class="{ 'is-invalid': form.errors.has('number_of_upper_floor') }"/>
											     <has-error :form="form" field="number_of_upper_floor"></has-error> 
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Ground:</label> 
                                            <input v-model="form.number_of_ground_floor" 
                                                type="number" 
                                                name="number_of_ground_floor"
                                                @change="generate_floor(2)" 
                                                placeholder="Type Ground" 
                                                :class="{ 'is-invalid': form.errors.has('number_of_ground_floor') }"/>
                                                 <has-error :form="form" field="number_of_ground_floor"></has-error> 
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Under Ground:</label> 
                                            <input v-model="form.number_of_under_ground" 
                                                type="number" 
                                                name="number_of_under_ground"
                                                @change="generate_floor(3)" 
                                                placeholder="Type Under Ground" 
                                                :class="{ 'is-invalid': form.errors.has('number_of_under_ground') }"/>
                                                 <has-error :form="form" field="number_of_under_ground"></has-error> 
                                        </div>
                                    </div>
                                    

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    <h4>Dependency Class:</h4>
                                    <div class="form-holder">
                                        <div class="form-check-inline">
                                           
                                            <input type="checkbox" 
                                                id="dependent_building" 
                                                name="dependent_building"
                                                @click="check_building_dependency($event,1)" 
                                                v-model="form.dependent_building">
                                            <label for="dependent_building">Dependent</label><br>

                                            <input type="checkbox" 
                                                id="independent_building" 
                                                name="independent_building" 
                                                @click="check_building_dependency($event,2)"
                                                v-model="form.independent_building">
                                            <label for="independent_building">Independent</label><br>
                                           
                                        </div>
                                    </div>


                                    <h4>Property Type:</h4>
                                    <div class="form-holder">
                                        <div class="form-check-inline">
                                           
                                            <input type="checkbox" 
                                                id="residential" 
                                                name="residential" 
                                                 @click="check_property_type($event,1)"
                                                v-model="form.residential">
                                            <label for="residential">Residential</label><br>

                                            <input type="checkbox" 
                                                id="commercial" 
                                                name="commercial"
                                                 @click="check_property_type($event,2)" 
                                                v-model="form.commercial" >
                                            <label for="commercial">Commercial</label><br>
                                            <input type="checkbox" 
                                                id="residential_commercial" 
                                                name="residential_commercial"
                                                 @click="check_property_type($event,3)" 
                                                v-model="form.residential_commercial">
                                            <label for="residential_commercial">Residential-Commercial</label><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>

                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i>Property Details</h3>
                    <div class="form-holder">
                        <h4>Upper Floors</h4>
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-4 col-sm-6 col-xs-12" v-for="(upper_floor,index) in form.upper_building_arr" style="margin-bottom:20px"> 
                                <div class="form-box-outer">
                                    
                                    <table class="table table_narrow"  >
                                        
                                        <thead>
                                            <tr>
                                                <th scope="col" width="60%">Upper Floor No {{upper_floor.floor_no}} </th>
                                                <th scope="col">Qty</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody style="border:none">
                                            
                                           
                                            <tr>
                                                <td width="" scope="row">Suites</td>
                                                <td width="">
                                                    <input 
                                                        style=" margin:0"
                                                        type="number"
                                                        v-bind:id="'upper_floor_name_'+index"
                                                        placeholder="Type Qty"
                                                        name="upper_floor_name[]" 
                                                        v-model="upper_floor.suites"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="" scope="row">Units</td>
                                                <td width="">
                                                    <input 
                                                        type="number"
                                                        v-bind:id="'upper_floor_name_'+index"
                                                        placeholder="Type Qty"
                                                        name="upper_floor_name[]" 
                                                        v-model="upper_floor.units"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="" scope="row">Mechanical Rooms</td>
                                                <td width="">
                                                    <input 
                                                        type="number"
                                                        v-bind:id="'upper_floor_name_'+index"
                                                        placeholder="Type Qty"
                                                        name="upper_floor_name[]" 
                                                        v-model="upper_floor.mechanical_rooms"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="" scope="row">Administrative Room</td>
                                                <td width="">
                                                    <input 
                                                        type="number"
                                                        v-bind:id="'upper_floor_name_'+index"
                                                        placeholder="Type Qty"
                                                        name="upper_floor_name[]" 
                                                        v-model="upper_floor.administrative_rooms"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="" scope="row">Amenity Rooms</td>
                                                <td width="">
                                                    <input 
                                                        type="number"
                                                        v-bind:id="'upper_floor_name_'+index"
                                                        placeholder="Type Qty"
                                                        name="upper_floor_name[]" 
                                                        v-model="upper_floor.amenity_rooms"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="" scope="row">Service Rooms</td>
                                                <td width="">
                                                    <input 
                                                        type="number"
                                                        v-bind:id="'upper_floor_name_'+index"
                                                        placeholder="Type Qty"
                                                        name="upper_floor_name[]" 
                                                        v-model="upper_floor.service_rooms"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="" scope="row">Parking Level</td>
                                                <td width="">
                                                    <input 
                                                        type="number"
                                                        v-bind:id="'upper_floor_name_'+index"
                                                        placeholder="Type Qty"
                                                        name="upper_floor_name[]" 
                                                        v-model="upper_floor.parking_lot"/>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="" scope="row">Bike Lot</td>
                                                <td width="">
                                                    <input 
                                                        type="number"
                                                        v-bind:id="'upper_floor_name_'+index"
                                                        placeholder="Type Qty"
                                                        name="upper_floor_name[]" 
                                                        v-model="upper_floor.bike_lot"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="" scope="row">Storage Lot</td>
                                                <td width="">
                                                    <input 
                                                        type="number"
                                                        v-bind:id="'upper_floor_name_'+index"
                                                        placeholder="Type Qty"
                                                        name="upper_floor_name[]" 
                                                        v-model="upper_floor.storage_lot"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="" scope="row">MailBox</td>
                                                <td width="">
                                                    <input 
                                                        type="number"
                                                        v-bind:id="'upper_floor_name_'+index"
                                                        placeholder="Type Qty"
                                                        name="upper_floor_name[]" 
                                                        v-model="upper_floor.mailbox"/>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="" scope="row">Common Area</td>
                                                <td width="">
                                                    <input 
                                                        type="number"
                                                        v-bind:id="'upper_floor_name_'+index"
                                                        placeholder="Type Qty"
                                                        name="upper_floor_name[]" 
                                                        v-model="upper_floor.common_area"/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                           
                            
                            <hr>
                        </div>
                    </div>

                    
                    <h4>Ground Floors</h4>
                    <div class="row align-self-stretch">
                        
                        <div class="col-md-4 col-sm-6 col-xs-12" v-for="(ground_floor,index) in form.ground_building_arr" style="margin-bottom:20px"> 
                            <div class="form-box-outer">
                                
                                <table class="table table_narrow"  >
                                    
                                    <thead>
                                        <tr>
                                            <th scope="col" width="60%">Ground Floor No {{ground_floor.floor_no}} </th>
                                            <th scope="col">Qty</th>                                                
                                        </tr>
                                    </thead>
                                    <tbody style="border:none">
                                        
                                       
                                        <tr>
                                            <td width="" scope="row">Suites</td>
                                            <td width="">
                                                <input 
                                                    style=" margin:0"
                                                    type="number"
                                                    v-bind:id="'ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="ground_floor_name[]" 
                                                    v-model="ground_floor.suites"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Units</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="ground_floor_name[]" 
                                                    v-model="ground_floor.units"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Mechanical Rooms</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="ground_floor_name[]" 
                                                    v-model="ground_floor.mechanical_rooms"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Administrative Room</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="ground_floor_name[]" 
                                                    v-model="ground_floor.administrative_rooms"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Amenity Rooms</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="ground_floor_name[]" 
                                                    v-model="ground_floor.amenity_rooms"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Service Rooms</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="ground_floor_name[]" 
                                                    v-model="ground_floor.service_rooms"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Parking Lot</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="ground_floor_name[]" 
                                                    v-model="ground_floor.parking_lot"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Suites</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="ground_floor_name[]" 
                                                    v-model="ground_floor.suites"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Bike Lot</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="ground_floor_name[]" 
                                                    v-model="ground_floor.bike_lot"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Storage Lot</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="ground_floor_name[]" 
                                                    v-model="ground_floor.storage_lot"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">MailBox</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="ground_floor_name[]" 
                                                    v-model="ground_floor.mailbox"/>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="" scope="row">Common Area</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="ground_floor_name[]" 
                                                    v-model="ground_floor.common_area"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                       
                        
                        <hr>
                    </div>

                    <h4>Under Ground</h4>
                    <div class="row align-self-stretch">
                        
                        <div class="col-md-4 col-sm-6 col-xs-12" v-for="(under_ground_floor,index) in form.under_ground_building_arr" style="margin-bottom:20px"> 
                            <div class="form-box-outer">
                                
                                <table class="table table_narrow"  >
                                    
                                    <thead>
                                        <tr>
                                            <th scope="col" width="60%">Under Ground {{under_ground_floor.floor_no}} </th>
                                            <th scope="col">Qty</th>                                                
                                        </tr>
                                    </thead>
                                    <tbody style="border:none">
                                        
                                       
                                        <tr>
                                            <td width="" scope="row">Suites</td>
                                            <td width="">
                                                <input 
                                                    style=" margin:0"
                                                    type="number"
                                                    v-bind:id="'under_ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="under_ground_floor_name[]" 
                                                    v-model="under_ground_floor.suites"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Units</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'under_ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="under_ground_floor_name[]" 
                                                    v-model="under_ground_floor.units"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Mechanical Rooms</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'under_ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="under_ground_floor_name[]" 
                                                    v-model="under_ground_floor.mechanical_rooms"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Administrative Room</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'under_ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="under_ground_floor_name[]" 
                                                    v-model="under_ground_floor.administrative_rooms"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Amenity Rooms</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'under_ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="under_ground_floor_name[]" 
                                                    v-model="under_ground_floor.amenity_rooms"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Service Rooms</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'under_ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="under_ground_floor_name[]" 
                                                    v-model="under_ground_floor.service_rooms"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Parking Lot</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'under_ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="under_ground_floor_name[]" 
                                                    v-model="under_ground_floor.parking_lot"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Suites</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'under_ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="under_ground_floor_name[]" 
                                                    v-model="under_ground_floor.suites"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Bike Lot</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'under_ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="under_ground_floor_name[]" 
                                                    v-model="under_ground_floor.bike_lot"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">Storage Lot</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'under_ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="under_ground_floor_name[]" 
                                                    v-model="under_ground_floor.storage_lot"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="" scope="row">MailBox</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'under_ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="under_ground_floor_name[]" 
                                                    v-model="under_ground_floor.mailbox"/>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="" scope="row">Common Area</td>
                                            <td width="">
                                                <input 
                                                    type="number"
                                                    v-bind:id="'under_ground_floor_name_'+index"
                                                    placeholder="Type Qty"
                                                    name="under_ground_floor_name[]" 
                                                    v-model="under_ground_floor.common_area"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                       
                        
                        <hr>
                    </div>
                   
                </div>
                


                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> Property Management Type</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="form-box-outer">
                                    <table class="table table_narrow">
                                        
                                       
                                        <thead>
                                            <tr class="header" >
                                                <td scope="col" >Property Management Type</td>
                                                <td scope="col">ID NO</td>
                                                <td scope="col" >Name</td>
                                                <td scope="col" >Website</td>
                                                <td scope="col" >Ph. Mobile</td>
                                                <td scope="col" >Ph. Office</td>
                                                <td scope="col" >Email</td>
                                            </tr>
                                        </thead>
                                        <tbody style="border:none">
                                            <template v-for="(property_management_type,index) in form.property_management_type_arr" >
                                                <tr style="background-color: #e7e8e7">
                                                    <td scope="row" width="25%">{{property_management_type.item_name}}</td>
                                                   
                                                    <td >
                                                        <input 
                                                            type="text" 
                                                            placeholder="Type ID-No"
                                                            v-bind:id="'management_id_no_'+index"
                                                            name="management_id_no[]" 
                                                            v-model="property_management_type.id_no"/>
                                                    </td>
                                                    <td >
                                                        <input 
                                                            type="text" 
                                                            placeholder="Type Name"
                                                            v-bind:id="'management_name_'+index"
                                                            name="management_name[]" 
                                                            v-model="property_management_type.name"/>
                                                    </td>
                                                    <td >
                                                        <input 
                                                            type="url" 
                                                            placeholder="Type Website"
                                                            v-bind:id="'management_website_'+index"
                                                            name="management_website[]" 
                                                            v-model="property_management_type.website"/>
                                                    </td>
                                                    <td >
                                                        <input 
                                                            type="text" 
                                                            placeholder="Type Mobile"
                                                            v-bind:id="'management_mobile_'+index"
                                                            name="management_mobile[]" 
                                                            v-model="property_management_type.mobile"/>
                                                    </td>
                                                    <td >
                                                        <input 
                                                            type="text" 
                                                            placeholder="Type Phone"
                                                            v-bind:id="'management_phone_'+index"
                                                            name="management_phone[]" 
                                                            v-model="property_management_type.phone"/>
                                                    </td>
                                                    
                                                    <td >
                                                        <input 
                                                            type="email" 
                                                            placeholder="Type Email"
                                                            v-bind:id="'management_email_'+index"
                                                            name="management_email[]" 
                                                            v-model="property_management_type.email"/>
                                                    </td>
                                                    
                                                    
                                                    
                                                </tr>
                                                                                                          
                                            </template>

                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                           
                            
                            <hr>
                        </div>
                    </div>
                </div>


                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> License and Permits</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="form-box-outer">
                                    <table class="table table_narrow">
                                        
                                       
                                        <thead>
                                            <tr class="header" >
                                                <td scope="col" >Perticular</td>
                                                <td scope="col">Issued By</td>
                                                <td scope="col" >Expired Date</td>
                                                <td scope="col" >Website</td>
                                                <td scope="col" >Ph. Mobile</td>
                                                <td scope="col" >Ph. Office</td>
                                                <td scope="col" >Email</td>
                                                <td scope="col" >Comments</td>
                                            </tr>
                                        </thead>
                                        <tbody style="border:none">
                                            <template v-for="(license_and_permit,index) in form.license_and_permit_list_arr" >
                                                <tr style="background-color: #e7e8e7">
                                                    <td scope="row" width="18%" v-if="license_and_permit.reference_id">{{license_and_permit.item_name}}</td>
                                                    <td v-else>
                                                        <input 
                                                            type="text" 
                                                            placeholder="Type Item Name"
                                                            v-bind:id="'license_and_permit_item_name_'+index"
                                                            name="item_name[]" 
                                                            v-model="license_and_permit.item_name"/>
                                                    </td>
                                                    <td >
                                                        <input 
                                                            type="text" 
                                                            placeholder="Type Issued By"
                                                            v-bind:id="'license_and_permit_issued_by_'+index"
                                                            name="license_and_permit_issued_by[]" 
                                                            v-model="license_and_permit.issued_by"/>
                                                    </td>
                                                    <td >
                                                        <date-picker 
                                                            style="width:100%"
                                                            v-model="license_and_permit.expiry_date"
                                                            name="expiry_date"
                                                            lang="en"
                                                            type="expiry_date"
                                                            format="ddd, MMM D, YYYY"
                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                    </td>
                                                    <td >
                                                        <input 
                                                            type="url" 
                                                            placeholder="Type Website"
                                                            v-bind:id="'license_website_'+index"
                                                            name="license_website[]" 
                                                            v-model="license_and_permit.website"/>
                                                    </td>
                                                    <td >
                                                        <input 
                                                            type="text" 
                                                            placeholder="Type Mobile"
                                                            v-bind:id="'license_mobile_'+index"
                                                            name="license_mobile[]" 
                                                            v-model="license_and_permit.mobile"/>
                                                    </td>
                                                    <td >
                                                        <input 
                                                            type="text" 
                                                            placeholder="Type Phone"
                                                            v-bind:id="'license_phone_'+index"
                                                            name="license_phone[]" 
                                                            v-model="license_and_permit.phone"/>
                                                    </td>
                                                    
                                                    <td >
                                                        <input 
                                                            type="email" 
                                                            placeholder="Type Email"
                                                            v-bind:id="'license_email_'+index"
                                                            name="license_email[]" 
                                                            v-model="license_and_permit.email"/>
                                                    </td>
                                                    <td >
                                                        <input 
                                                            type="text" 
                                                            placeholder="Type Comments"
                                                            v-bind:id="'license_comments_'+index"
                                                            name="license_comments[]" 
                                                            v-model="license_and_permit.comment"/>
                                                    </td>
                                                </tr>
                                                                                                          
                                            </template>
                                            <tr>
                                                <td ><button type="button" class="btn btn-primary btn-sm" @click="add_license_permit()">Add</button></td>
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
                    <h3><i class="fa fa-hand-point-right"></i>Safety Devices and Equipment's</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="form-box-outer">
                                    <table class="table table_narrow">
                                        
                                        <thead>
                                            <tr >
                                                <th scope="col" rowspan="2">Safety Item</th>
                                                <th scope="col" rowspan="2">Qty</th>
                                                <th scope="col" rowspan="2">Serial No</th>
                                                <th scope="col" rowspan="2">Floor No</th>
                                                <th scope="col" rowspan="2">Expiry Date</th>
                                                
                                                <th scope="col" rowspan="2">Renew Date</th>
                                                <th scope="col" colspan="2">Inspection</th>
                                            </tr>
                                            <tr >
                                                <th scope="col">Cycle</th>
                                                <th scope="col">Due On</th>
                                            </tr>
                                        </thead>
                                        <tbody style="border:none">
                                            <template v-for="(safety_item_list,index) in form.safety_item_list_arr">
                                                <tr style="background-color: #e7e8e7">
                                                    <td scope="row" width="13%">{{safety_item_list.item_name}}</td>
                                                    <td width="10%">
                                                        <input 
                                                            type="number" 
                                                            placeholder="Type Qty"
                                                            v-bind:id="'item_qty_'+index"
                                                            name="item_qty[]" 
                                                            v-model="safety_item_list.item_qty"/>
                                                    </td>
                                                    <td ><button type="button" class="btn btn-primary btn-sm" @click="change_fire_extinguisher(safety_item_list)">Add</button></td>
                                                    <td ></td>
                                                    <td ></td>
                                                    <td ></td>
                                                    <td ></td>
                                                    <td ></td>
                                                 
                                                </tr>
                                                    <template v-if="safety_item_list.refernece_id==1">
                                                        <template v-for="(safety_item,index) in form.fire_extinguisher_details_arr" >
                                                            
                                                                <tr >
                                                                    <td scope="row" width="23%" colspan="2">{{safety_item.reference_name}}</td>
                                                                    
                                                                    <td >
                                                                        <input 
                                                                            type="number" 
                                                                            placeholder="Type Serial No"
                                                                            v-bind:id="'serial_no_'+index"
                                                                            name="item_qty[]" 
                                                                            v-model="safety_item.serial_no"/>
                                                                    </td>
                                                                    <td >
                                                                        <input 
                                                                            type="number" 
                                                                            placeholder="Type Floor No"
                                                                            v-bind:id="'floor_no_'+index"
                                                                            name="item_qty[]" 
                                                                            v-model="safety_item.floor_no"/>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.expiry_date"
                                                                            name="comment_date"
                                                                            lang="en"
                                                                            type="comment_date"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.renew_date"
                                                                            name="renew_date[]"
                                                                            lang="en"
                                                                            type="renew_date"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                                    </td>
                                                                    <td >
                                                                        <select v-model="safety_item.cicle"
                                                                            name="cicle[]"
                                                                            class="custom-select" 
                                                                            :class="{ 'is-invalid': form.errors.has('cicle') }">
                                                                            <option disabled value="">--Select-- </option>
                                                                            <option value="1">Daily</option>
                                                                            <option value="2">Weekly</option>
                                                                            <option value="3">Semi Monthly</option>
                                                                            <option value="4">Monthly</option>
                                                                            <option value="5">Quarterly</option>
                                                                            <option value="6">Yearly</option>
                                                                        </select>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.due_on"
                                                                            name="due_on[]"
                                                                            lang="en"
                                                                            type="due_on"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                                                                          <has-error :form="form" field="due_on"></has-error>
                                                                    </td>
                                                                 
                                                                </tr>
                                                            
                                                        </template>
                                                    </template>
                                                    
                                                    <template v-if="safety_item_list.refernece_id==2">
                                                        <template v-for="(safety_item,index) in form.smoke_detecter_details_arr" >
                                                            
                                                            <tr >
                                                                    <td scope="row" width="10%">{{safety_item.reference_name}}</td>
                                                                    <td width="7%">
                                                                        
                                                                    </td>
                                                                    <td >
                                                                        <input 
                                                                            type="number" 
                                                                            placeholder="Type Serial No"
                                                                            v-bind:id="'serial_no_'+index"
                                                                            name="item_qty[]" 
                                                                            v-model="safety_item.serial_no"/>
                                                                    </td>
                                                                    <td >
                                                                        <input 
                                                                            type="number" 
                                                                            placeholder="Type Floor No"
                                                                            v-bind:id="'floor_no_'+index"
                                                                            name="item_qty[]" 
                                                                            v-model="safety_item.floor_no"/>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.expiry_date"
                                                                            name="comment_date"
                                                                            lang="en"
                                                                            type="comment_date"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.renew_date"
                                                                            name="renew_date[]"
                                                                            lang="en"
                                                                            type="renew_date"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                                    </td>
                                                                    <td >
                                                                        <select v-model="safety_item.cicle"
                                                                            name="cicle[]"
                                                                            class="custom-select" 
                                                                            :class="{ 'is-invalid': form.errors.has('cicle') }">
                                                                            <option disabled value="">--Select-- </option>
                                                                            <option value="1">Daily</option>
                                                                            <option value="2">Weekly</option>
                                                                            <option value="3">Semi Monthly</option>
                                                                            <option value="4">Monthly</option>
                                                                            <option value="5">Quarterly</option>
                                                                            <option value="6">Yearly</option>
                                                                        </select>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.due_on"
                                                                            name="due_on[]"
                                                                            lang="en"
                                                                            type="due_on"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                                                                          <has-error :form="form" field="due_on"></has-error>
                                                                    </td>
                                                                 
                                                                </tr>
                                                            
                                                        </template>
                                                    </template>
                                                    <template v-if="safety_item_list.refernece_id==3">
                                                        <template v-for="(safety_item,index) in form.sprinkler_details_arr" >
                                                            
                                                            <tr >
                                                                    <td scope="row"  width="23%" colspan="2">{{safety_item.reference_name}}</td>
                                                                    
                                                                    <td >
                                                                        <input 
                                                                            type="number" 
                                                                            placeholder="Type Serial No"
                                                                            v-bind:id="'serial_no_'+index"
                                                                            name="item_qty[]" 
                                                                            v-model="safety_item.serial_no"/>
                                                                    </td>
                                                                    <td >
                                                                        <input 
                                                                            type="number" 
                                                                            placeholder="Type Floor No"
                                                                            v-bind:id="'floor_no_'+index"
                                                                            name="item_qty[]" 
                                                                            v-model="safety_item.floor_no"/>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.expiry_date"
                                                                            name="comment_date"
                                                                            lang="en"
                                                                            type="comment_date"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.renew_date"
                                                                            name="renew_date[]"
                                                                            lang="en"
                                                                            type="renew_date"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                                    </td>
                                                                    <td >
                                                                        <select v-model="safety_item.cicle"
                                                                            name="cicle[]"
                                                                            class="custom-select" 
                                                                            :class="{ 'is-invalid': form.errors.has('cicle') }">
                                                                            <option disabled value="">--Select-- </option>
                                                                            <option value="1">Daily</option>
                                                                            <option value="2">Weekly</option>
                                                                            <option value="3">Semi Monthly</option>
                                                                            <option value="4">Monthly</option>
                                                                            <option value="5">Quarterly</option>
                                                                            <option value="6">Yearly</option>
                                                                        </select>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.due_on"
                                                                            name="due_on[]"
                                                                            lang="en"
                                                                            type="due_on"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                                                                          <has-error :form="form" field="due_on"></has-error>
                                                                    </td>
                                                                 
                                                                </tr>
                                                            
                                                        </template>
                                                    </template>
                                                    <template v-if="safety_item_list.refernece_id==4">
                                                        <template v-for="(safety_item,index) in form.water_valve_details_arr" >
                                                            
                                                            <tr >
                                                                    <td scope="row"  width="23%" colspan="2">{{safety_item.reference_name}}</td>
                                                                    <td >
                                                                        <input 
                                                                            type="number" 
                                                                            placeholder="Type Serial No"
                                                                            v-bind:id="'serial_no_'+index"
                                                                            name="item_qty[]" 
                                                                            v-model="safety_item.serial_no"/>
                                                                    </td>
                                                                    <td >
                                                                        <input 
                                                                            type="number" 
                                                                            placeholder="Type Floor No"
                                                                            v-bind:id="'floor_no_'+index"
                                                                            name="item_qty[]" 
                                                                            v-model="safety_item.floor_no"/>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.expiry_date"
                                                                            name="comment_date"
                                                                            lang="en"
                                                                            type="comment_date"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.renew_date"
                                                                            name="renew_date[]"
                                                                            lang="en"
                                                                            type="renew_date"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                                    </td>
                                                                    <td >
                                                                        <select v-model="safety_item.cicle"
                                                                            name="cicle[]"
                                                                            class="custom-select" 
                                                                            :class="{ 'is-invalid': form.errors.has('cicle') }">
                                                                            <option disabled value="">--Select-- </option>
                                                                            <option value="1">Daily</option>
                                                                            <option value="2">Weekly</option>
                                                                            <option value="3">Semi Monthly</option>
                                                                            <option value="4">Monthly</option>
                                                                            <option value="5">Quarterly</option>
                                                                            <option value="6">Yearly</option>
                                                                        </select>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.due_on"
                                                                            name="due_on[]"
                                                                            lang="en"
                                                                            type="due_on"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                                                                          <has-error :form="form" field="due_on"></has-error>
                                                                    </td>
                                                                 
                                                                </tr>
                                                            
                                                        </template>
                                                    </template>
                                                    <template v-if="safety_item_list.refernece_id==5">
                                                        <template v-for="(safety_item,index) in form.gfci_breaker_details_arr" >
                                                            
                                                            <tr >
                                                                   <td scope="row"  width="23%" colspan="2">{{safety_item.reference_name}}</td>
                                                                    <td >
                                                                        <input 
                                                                            type="number" 
                                                                            placeholder="Type Serial No"
                                                                            v-bind:id="'serial_no_'+index"
                                                                            name="item_qty[]" 
                                                                            v-model="safety_item.serial_no"/>
                                                                    </td>
                                                                    <td >
                                                                        <input 
                                                                            type="number" 
                                                                            placeholder="Type Floor No"
                                                                            v-bind:id="'floor_no_'+index"
                                                                            name="item_qty[]" 
                                                                            v-model="safety_item.floor_no"/>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.expiry_date"
                                                                            name="comment_date"
                                                                            lang="en"
                                                                            type="comment_date"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.renew_date"
                                                                            name="renew_date[]"
                                                                            lang="en"
                                                                            type="renew_date"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                                    </td>
                                                                    <td >
                                                                        <select v-model="safety_item.cicle"
                                                                            name="cicle[]"
                                                                            class="custom-select" 
                                                                            :class="{ 'is-invalid': form.errors.has('cicle') }">
                                                                            <option disabled value="">--Select-- </option>
                                                                            <option value="1">Daily</option>
                                                                            <option value="2">Weekly</option>
                                                                            <option value="3">Semi Monthly</option>
                                                                            <option value="4">Monthly</option>
                                                                            <option value="5">Quarterly</option>
                                                                            <option value="6">Yearly</option>
                                                                        </select>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.due_on"
                                                                            name="due_on[]"
                                                                            lang="en"
                                                                            type="due_on"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                                                                          <has-error :form="form" field="due_on"></has-error>
                                                                    </td>
                                                                 
                                                                </tr>
                                                            
                                                        </template>
                                                    </template>

                                                    <template v-if="safety_item_list.refernece_id==6">
                                                        <template v-for="(safety_item,index) in form.sump_pump_details_arr" >
                                                            
                                                            <tr >
                                                                <td scope="row"  width="23%" colspan="2">{{safety_item.reference_name}}</td>
                                                                <td >
                                                                    <input 
                                                                        type="number" 
                                                                        placeholder="Type Serial No"
                                                                        v-bind:id="'serial_no_'+index"
                                                                        name="item_qty[]" 
                                                                        v-model="safety_item.serial_no"/>
                                                                </td>
                                                                <td >
                                                                    <input 
                                                                        type="number" 
                                                                        placeholder="Type Floor No"
                                                                        v-bind:id="'floor_no_'+index"
                                                                        name="item_qty[]" 
                                                                        v-model="safety_item.floor_no"/>
                                                                </td>
                                                                <td >
                                                                    <date-picker 
                                                                        style="width:100%"
                                                                        v-model="safety_item.expiry_date"
                                                                        name="comment_date"
                                                                        lang="en"
                                                                        type="comment_date"
                                                                        format="ddd, MMM D, YYYY"
                                                                        :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                      <has-error :form="form" field="expiry_date"></has-error>
                                                                </td>
                                                                <td >
                                                                    <date-picker 
                                                                        style="width:100%"
                                                                        v-model="safety_item.renew_date"
                                                                        name="renew_date[]"
                                                                        lang="en"
                                                                        type="renew_date"
                                                                        format="ddd, MMM D, YYYY"
                                                                        :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                      <has-error :form="form" field="expiry_date"></has-error>
                                                                </td>
                                                                <td >
                                                                    <select v-model="safety_item.cicle"
                                                                        name="cicle[]"
                                                                        class="custom-select" 
                                                                        :class="{ 'is-invalid': form.errors.has('cicle') }">
                                                                        <option disabled value="">--Select-- </option>
                                                                        <option value="1">Daily</option>
                                                                        <option value="2">Weekly</option>
                                                                        <option value="3">Semi Monthly</option>
                                                                        <option value="4">Monthly</option>
                                                                        <option value="5">Quarterly</option>
                                                                        <option value="6">Yearly</option>
                                                                    </select>
                                                                </td>
                                                                <td >
                                                                    <date-picker 
                                                                        style="width:100%"
                                                                        v-model="safety_item.due_on"
                                                                        name="due_on[]"
                                                                        lang="en"
                                                                        type="due_on"
                                                                        format="ddd, MMM D, YYYY"
                                                                        :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                                                                      <has-error :form="form" field="due_on"></has-error>
                                                                </td>
                                                             
                                                            </tr>
                                                            
                                                        </template>
                                                    </template>
                                                    <template v-if="safety_item_list.refernece_id==7">
                                                        <template v-for="(safety_item,index) in form.emergency_bell_details_arr" >
                                                            
                                                            <tr >
                                                                    <td scope="row"  width="23%" colspan="2">{{safety_item.reference_name}}</td>
                                                                    <td >
                                                                        <input 
                                                                            type="number" 
                                                                            placeholder="Type Serial No"
                                                                            v-bind:id="'serial_no_'+index"
                                                                            name="item_qty[]" 
                                                                            v-model="safety_item.serial_no"/>
                                                                    </td>
                                                                    <td >
                                                                        <input 
                                                                            type="number" 
                                                                            placeholder="Type Floor No"
                                                                            v-bind:id="'floor_no_'+index"
                                                                            name="item_qty[]" 
                                                                            v-model="safety_item.floor_no"/>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.expiry_date"
                                                                            name="comment_date"
                                                                            lang="en"
                                                                            type="comment_date"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.renew_date"
                                                                            name="renew_date[]"
                                                                            lang="en"
                                                                            type="renew_date"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                                          <has-error :form="form" field="expiry_date"></has-error>
                                                                    </td>
                                                                    <td >
                                                                        <select v-model="safety_item.cicle"
                                                                            name="cicle[]"
                                                                            class="custom-select" 
                                                                            :class="{ 'is-invalid': form.errors.has('cicle') }">
                                                                            <option disabled value="">--Select-- </option>
                                                                            <option value="1">Daily</option>
                                                                            <option value="2">Weekly</option>
                                                                            <option value="3">Semi Monthly</option>
                                                                            <option value="4">Monthly</option>
                                                                            <option value="5">Quarterly</option>
                                                                            <option value="6">Yearly</option>
                                                                        </select>
                                                                    </td>
                                                                    <td >
                                                                        <date-picker 
                                                                            style="width:100%"
                                                                            v-model="safety_item.due_on"
                                                                            name="due_on[]"
                                                                            lang="en"
                                                                            type="due_on"
                                                                            format="ddd, MMM D, YYYY"
                                                                            :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                                                                          <has-error :form="form" field="due_on"></has-error>
                                                                    </td>
                                                                 
                                                                </tr>
                                                            
                                                        </template>
                                                    </template>
                                            </template>

                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                           
                            
                            <hr>
                        </div>
                    </div>
                </div> 

                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i>External Services Providers Accounts Details</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="form-box-outer">
                                    <table class="table table_narrow">
                                        
                                        <thead>
                                            <tr style="vertical-align:middle; text-align:center">
                                                <th scope="col" >Service Item</th>
                                                <th scope="col" >ID No - Name</th>
                                                <th scope="col" >Account No</th>
                                                <th scope="col" >Website</th>
                                                <th scope="col" >Service Schedule Date</th>
                                                <th scope="col" >Billig Cycle</th>
                                                <th scope="col" >Expected Due Date</th>
                                                <th scope="col" >Bill Delivery Method</th>
                                                <th scope="col" >Payment Method</th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody style="border:none">
                                             <template v-for="(external_service_provider,index) in form.external_service_provider_details_arr" >
                                                <tr style="background-color: #e7e8e7">
                                                    <td scope="row" width="13%">{{external_service_provider.item_name}}</td>
                                                   
                                                    <td >
                                                        <input 
                                                            type="text" 
                                                            placeholder="Type ID No"
                                                            v-bind:id="'id_no_'+index"
                                                            name="id_no[]" 
                                                            v-model="external_service_provider.id_no"/>
                                                    </td>
                                                    <td >
                                                        <input 
                                                            type="text" 
                                                            placeholder="Type Account No"
                                                            v-bind:id="'account_no_'+index"
                                                            name="account_no[]" 
                                                            v-model="external_service_provider.account_no"/>
                                                    </td>
                                                    <td >
                                                        <input 
                                                            type="text" 
                                                            placeholder="Type Website"
                                                            v-bind:id="'website_'+index"
                                                            name="website[]" 
                                                            v-model="external_service_provider.website"/>
                                                    </td>
                                                    <td >
                                                        <date-picker 
                                                            style="width:100%"
                                                            v-model="external_service_provider.schedule_date"
                                                            name="schedule_date[]"
                                                            lang="en"
                                                            type="schedule_date"
                                                            format="ddd, MMM D, YYYY"
                                                            :class="{ 'is-invalid': form.errors.has('schedule_date') }"></date-picker>
                                                          <has-error :form="form" field="schedule_date"></has-error>
                                                    </td>
                                                    <td >
                                                        <select v-model="external_service_provider.billing_cycle"
                                                            name="billing_cycle[]"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('billing_cycle') }">
                                                            <option disabled value="">--Select-- </option>
                                                            <option value="1">Daily</option>
                                                            <option value="2">Weekly</option>
                                                            <option value="3">Semi Monthly</option>
                                                            <option value="4">Monthly</option>
                                                            <option value="5">Quarterly</option>
                                                            <option value="6">Yearly</option>
                                                        </select>
                                                    </td>
                                                    <td >
                                                        <date-picker 
                                                            style="width:100%"
                                                            v-model="external_service_provider.expected_due_date"
                                                            name="expected_due_date[]"
                                                            lang="en"
                                                            type="expected_due_date"
                                                            format="ddd, MMM D, YYYY"
                                                            :class="{ 'is-invalid': form.errors.has('expected_due_date') }"></date-picker>
                                                          <has-error :form="form" field="expected_due_date"></has-error>
                                                    </td>
                                                    <td >
                                                        <select v-model="external_service_provider.bill_delivery_method"
                                                            name="bill_delivery_method[]"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('bill_delivery_method') }">
                                                            <option disabled value="">--Select-- </option>
                                                            <option value="1">Mail</option>
                                                            <option value="2">Email</option>
                                                            <option value="3">Online</option>
                                                            
                                                        </select>
                                                    </td>
                                                    <td >
                                                        <select v-model="external_service_provider.payment_method"
                                                            name="payment_method[]"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('payment_method') }">
                                                            <option disabled value="">--Select-- </option>
                                                            <option value="1">Credit Card</option>
                                                            <option value="2">Online Banking</option>
                                                            <option value="3">Check</option>
                                                            
                                                        </select>
                                                    </td>
                                                 
                                                </tr>
                                                                                                                
                                            </template>

                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                           
                            
                            <hr>
                        </div>
                    </div>
                </div>
                

                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> Contacts Details</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="form-box-outer">
                                    <table class="table table_narrow">
                                        
                                       
                                        <tbody style="border:none">
                                             <template v-for="(category_contact_details,index) in form.building_contact_details_arr" v-if="index>0">

                                                <tr class="header" >
                                                    <td scope="col" v-if="index==1">Staff and Departments</td>
                                                    <td scope="col" v-else-if="index==2">Repair and Maintenance</td>
                                                    <td scope="col" v-else-if="index==3">Safety </td>
                                                    <td scope="col" v-else-if="index==4">Dedicated Service Providers</td>
                                                    <td scope="col" v-else>Other</td>
                                                    <td scope="col" >Contact Person   </td>
                                                    <td scope="col" >Ph. Office</td>
                                                    <td scope="col" >Ph. Mobile</td>
                                                    <td scope="col" >Email</td>
                                                    <td scope="col" >Website</td>
                                                    <td scope="col" >Hours of Operations</td>
                                                    <td scope="col" >Comments</td>
                                                </tr>
                                                <template v-for="(contact_details,contact_sl) in category_contact_details" >
                                                    <tr style="background-color: #e7e8e7">
                                                        <td scope="row" width="13%">{{contact_details.item_name}}</td>
                                                       
                                                        <td >
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type ID-Name"
                                                                v-bind:id="'contact_no_'+index"
                                                                name="contact_no[]" 
                                                                v-model="contact_details.contact_no"/>
                                                        </td>
                                                        <td >
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Phone"
                                                                v-bind:id="'phone_'+index"
                                                                name="phone[]" 
                                                                v-model="contact_details.phone"/>
                                                        </td>
                                                        <td >
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Mobile"
                                                                v-bind:id="'mobile_'+index"
                                                                name="mobile[]" 
                                                                v-model="contact_details.mobile"/>
                                                        </td>
                                                        <td >
                                                            <input 
                                                                type="email" 
                                                                placeholder="Type Email"
                                                                v-bind:id="'email_'+index"
                                                                name="email[]" 
                                                                v-model="contact_details.email"/>
                                                        </td>
                                                        <td >
                                                            <input 
                                                                type="url" 
                                                                placeholder="Type Website"
                                                                v-bind:id="'website_'+index"
                                                                name="website[]" 
                                                                v-model="contact_details.website"/>
                                                        </td>
                                                        <td >
                                                                <input 
                                                                type="text" 
                                                                placeholder="Type Hours of Operation"
                                                                v-bind:id="'hours_of_operation_'+index"
                                                                name="hours_of_operation[]" 
                                                                v-model="contact_details.hours_of_operation"/>
                                                        </td>

                                                        <td >
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Comments"
                                                                v-bind:id="'comments_'+index"
                                                                name="comments[]" 
                                                                v-model="contact_details.comments"/>
                                                        </td>
                                                        
                                                    </tr>
                                                </template> 
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm" @click="add_contact_details(index)">Add</button>
                                                    </td>

                                                </tr>                                                               
                                            </template>

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
                <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deleteCustomer()">Delete</button>
                <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode">Void</button>
                <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(1)">Save-Stay</button>
                <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(2)">Save-Out</button>
                <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(3)">Save-New</button>
                <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
            </div>
	        
	        <!--  MOdel  -->
                <div class="modal fade model-middle" id="customContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" v-if="form.custom_contact_type==1">Add Staff and Departments</h5>

                        <h5 class="modal-title" id="exampleModalLabel" v-if="form.custom_contact_type==2">Add Repair and Maintenance</h5>

                        <h5 class="modal-title" id="exampleModalLabel" v-else-if="form.custom_contact_type==3">Add Safety Equipment</h5>

                        <h5 class="modal-title" id="exampleModalLabel" v-else-if="form.custom_contact_type==4">Add Dedicated Service Providers</h5>


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
                                                                               

                                    </div> 
                                   
                                </div>
                               
                                <hr>
                            </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="modelClose()">Close</button>
                        <button type="button" class="btn btn-primary" @click.prevent="addNewCustomField()" v-if="form.custom_contact_type==1">Add Staff and Departments</button>
                        <button type="button" class="btn btn-primary" @click.prevent="addNewCustomField()" v-if="form.custom_contact_type==2">Add Repair and Maintenance</button>
                        <button type="button" class="btn btn-primary" @click.prevent="addNewCustomField()" v-if="form.custom_contact_type==3">Add Safety Equipment</button>
                        <button type="button" class="btn btn-primary" @click.prevent="addNewCustomField()" v-if="form.custom_contact_type==4">Add Dedicated Service Providers</button>
                        
                      </div>
                    </div>
                  </div>
                </div>

            <!-- model end -->
	    </form>
	   

    </fieldset>

</template>

<style>

    .table_narrow td{
        padding: .1rem .5rem !important;
    }

    .table_narrow th,.table_narrow .header td{
        font-size:13px !important;
        vertical-align:middle !important;
        color: rgb(255, 255, 255) !important;
        text-align:center !important;
        border:1px solid #fff !important;
    }

    .table_narrow tbody td{
        font-size:13px !important;
    }
    .table_narrow thead tr,.table_narrow .header 
    {
           
           
        background-color: rgb(0, 112, 192) !important;

    }

    .table_narrow input{

        font-size: 12px !important;
        height: 30px !important;
        margin:5px 0  !important;
    }

</style>

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
                    company_name:'',
                    customer_name:'',
                    building_no:'',
            		building_name:'',
            		number_of_floor:'',
                    number_of_upper_floor:'',
            		number_of_ground_floor:'',
            		number_of_under_ground:'',
            		dependent_building:false,
            		independent_building:false,
            		

            		residential:false,
            		commercial:false,
            		residential_commercial:false,
            		
            		
                    page_id:1,
                  	id:'',
                  	

                  	upper_building_arr:[],
                    ground_building_arr:[],
                    under_ground_building_arr:[],


                    safety_item_list_arr:[],
                    external_service_provider_details_arr:[],
                    fire_extinguisher_details_arr:[],
                    smoke_detecter_details_arr:[],
                    sprinkler_details_arr:[],
                    water_valve_details_arr:[],
                    gfci_breaker_details_arr:[],
                    sump_pump_details_arr:[],
                    emergency_bell_details_arr:[],
                    building_contact_details_arr:[],
                    property_management_type_arr:[],
                    license_and_permit_list_arr:[],
                    custom_contact_type:'',
                    custom_field_name:'',

            	}),
                external_service_provider_list_arr:[],
                building_contact_list_arr:[],
            	account_disable:true,
            	account_no:'',
                
            	company_arr:[],
                customer_arr:[],
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchBuildingProfile();
           // this.fetchCustomerProfileUpdate(14);
           
        },
		
        computed:{


            
        },
	    methods: {

            reset_form()
            {

                this.form.reset();
                this.editmode=false;
            },
            change_customer()
            {
                let uri = '/loadCustomerByCompany/'+this.form.company_name;
                window.axios.get(uri).then((response) => {
                    
                    this.customer_arr                           =response.data.customer_arr;
                });
                
            },

            add_license_permit()
            {
                this.form.license_and_permit_list_arr.push({
                    'id':'',
                    'reference_id':'',
                    'item_name':'',
                    'issued_by':'',
                    'expiry_date':'',
                    'webiste':'',
                    'mobile':'',
                    'phone':'',
                    'email':'',
                    'comment':'',
                    
                });
            },


            change_fire_extinguisher_back(item)
            {
                if(item.id in this.form.safety_item_details_arr == false)
                this.form.safety_item_details_arr[item.id] = {};
 
                for(var i=1; i<=item.item_qty;i++)
                {

                    this.form.safety_item_details_arr[item.id][i]={
                        'id':'',
                        'reference_id':item.id,
                        'reference_name':item.item_name+' '+i,
                        'name':'',
                        'floor_no':'',
                        'serial_no':'',
                        'expiry_date':'',
                        'renew_date':'',
                        'cicle':'',
                        'due_on':'',
                    }
                    
                }
               // alert(this.form.safety_item_details_arr[item.id][1].reference_name)
               return this.form.safety_item_details_arr;  
               
            },

            change_fire_extinguisher(item)
            {

                if(item.refernece_id==1)
                {

                    let array_length=this.form.fire_extinguisher_details_arr.length;

                    if(array_length>item.item_qty)
                    {

                        this.form.fire_extinguisher_details_arr.splice(item.item_qty);
                        return;
                    }


                    for(var i=1; i<=item.item_qty;i++)
                    {
                        if(array_length<i)
                        {
                            this.form.fire_extinguisher_details_arr.push({
                                'id':'',
                                'reference_id':item.id,
                                'item_id':item.refernece_id,
                                'reference_name':item.item_name+' '+i,
                                'name':'',
                                'floor_no':'',
                                'serial_no':'',
                                'expiry_date':'',
                                'renew_date':'',
                                'cicle':'',
                                'due_on':'',
                                
                            });

                        }
                    }
                }
                else if(item.refernece_id==2)
                {

                    let array_length=this.form.smoke_detecter_details_arr.length;

                    if(array_length>item.item_qty)
                    {

                        this.form.smoke_detecter_details_arr.splice(item.item_qty);

                        return;
                    }

                    for(var i=1; i<=item.item_qty;i++)
                    {
                        if(array_length<i)
                        {
                            this.form.smoke_detecter_details_arr.push({
                                'id':'',
                                'reference_id':item.id,
                                'item_id':item.refernece_id,
                                'reference_name':item.item_name+' '+i,
                                'name':'',
                                'floor_no':'',
                                'serial_no':'',
                                'expiry_date':'',
                                'renew_date':'',
                                'cicle':'',
                                'due_on':'',
                                
                            });
                        }
                    }
                }
                else if(item.refernece_id==3)
                {

                    let array_length=this.form.sprinkler_details_arr.length;


                    if(array_length>item.item_qty)
                    {

                        this.form.sprinkler_details_arr.splice(item.item_qty);
                        return;
                    }


                    for(var i=1; i<=item.item_qty;i++)
                    {
                         if(array_length<i)
                        {
                            this.form.sprinkler_details_arr.push({
                                'id':'',
                                'reference_id':item.id,
                                'item_id':item.refernece_id,
                                'reference_name':item.item_name+' '+i,
                                'name':'',
                                'floor_no':'',
                                'serial_no':'',
                                'expiry_date':'',
                                'renew_date':'',
                                'cicle':'',
                                'due_on':'',
                                
                            });
                        }
                    }
                }
                else if(item.refernece_id==4)
                {

                    let array_length=this.form.water_valve_details_arr.length;

                    if(array_length>item.item_qty)
                    {

                        this.form.water_valve_details_arr.splice(item.item_qty);
                        return;
                    }


                    for(var i=1; i<=item.item_qty;i++)
                    {
                         if(array_length<i)
                        {
                           this.form.water_valve_details_arr.push({
                                'id':'',
                                'reference_id':item.id,
                                'item_id':item.refernece_id,
                                'reference_name':item.item_name+' '+i,
                                'name':'',
                                'floor_no':'',
                                'serial_no':'',
                                'expiry_date':'',
                                'renew_date':'',
                                'cicle':'',
                                'due_on':'',
                                
                            });
                        }
                    }
                }
                else if(item.refernece_id==5)
                {

                    let array_length=this.form.sump_pump_details_arr.length;

                    if(array_length>item.item_qty)
                    {

                        this.form.sump_pump_details_arr.splice(item.item_qty);
                        return;
                    }


                    for(var i=1; i<=item.item_qty;i++)
                    {
                         if(array_length<i)
                        {
                            this.form.gfci_breaker_details_arr.push({
                                'id':'',
                                'reference_id':item.id,
                                'item_id':item.refernece_id,
                                'reference_name':item.item_name+' '+i,
                                'name':'',
                                'floor_no':'',
                                'serial_no':'',
                                'expiry_date':'',
                                'renew_date':'',
                                'cicle':'',
                                'due_on':'',
                                
                            });
                        }
                    }
                }
                else if(item.refernece_id==6)
                {

                    let array_length=this.form.sump_pump_details_arr.length;

                    if(array_length>item.item_qty)
                    {

                        this.form.sump_pump_details_arr.splice(item.item_qty);
                        return;
                    }


                    for(var i=1; i<=item.item_qty;i++)
                    {

                         if(array_length<i)
                        {
                            this.form.sump_pump_details_arr.push({
                                'id':'',
                                'reference_id':item.id,
                                'item_id':item.refernece_id,
                                'reference_name':item.item_name+' '+i,
                                'name':'',
                                'floor_no':'',
                                'serial_no':'',
                                'expiry_date':'',
                                'renew_date':'',
                                'cicle':'',
                                'due_on':'',
                                
                            });
                        }
                    }
                }
                else if(item.refernece_id==7)
                {

                    let array_length=this.form.emergency_bell_details_arr.length;

                    if(array_length>item.item_qty)
                    {

                        this.form.emergency_bell_details_arr.splice(item.item_qty);
                        return;
                    }

                    for(var i=1; i<=item.item_qty;i++)
                    {
                         if(array_length<i)
                        {
                            this.form.emergency_bell_details_arr.push({
                                'id':'',
                                'reference_id':item.id,
                                'item_id':item.refernece_id,
                                'reference_name':item.item_name+' '+i,
                                'name':'',
                                'floor_no':'',
                                'serial_no':'',
                                'expiry_date':'',
                                'renew_date':'',
                                'cicle':'',
                                'due_on':'',
                                
                            }); 
                        }                            
                    }
                }
               
            },


            generate_floor(type)
            {

                if(!this.form.number_of_floor)
                {
                    toast({
                        type: 'warning',
                        title: 'Please Select Number of Floors First'
                    });
                    this.form.number_of_upper_floor="";
                    return;
                }
               

               // let sum=this.form.number_of_upper_floor+this.form.number_of_ground_floor+this.form.number_of_under_ground;
                if(type==1)
                {
                    this.form.upper_building_arr=[];
                    for(let i=this.form.number_of_upper_floor; i>0; i--){
                        this.form.upper_building_arr.push({
                            'id':'',
                            'floor_no':i,
                            'suites':'',
                            'units':'',
                            'mechanical_rooms':'',
                            'administrative_rooms':'',
                            'amenity_rooms':'',
                            'service_rooms':'',
                            'parking_lot':'',
                            'bike_lot':'',
                            'storage_lot':'',
                            'mailbox':'',
                            'common_area':'',
                        
                        });
                    }

                }

                if(type==2)
                {
                    this.form.ground_building_arr=[];
                    for(let i=this.form.number_of_ground_floor; i>0; i--){
                        this.form.ground_building_arr.push({
                            'id':'',
                            'floor_no':i,
                            'suites':'',
                            'units':'',
                            'mechanical_rooms':'',
                            'administrative_rooms':'',
                            'amenity_rooms':'',
                            'service_rooms':'',
                            'parking_lot':'',
                            'bike_lot':'',
                            'storage_lot':'',
                            'mailbox':'',
                            'common_area':'',
                        
                        });
                    }

                }
                if(type==3)
                {
                    this.form.under_ground_building_arr=[];
                    for(let i=this.form.number_of_under_ground; i>0; i--){
                        this.form.under_ground_building_arr.push({
                            'id':'',
                            'floor_no':i,
                            'suites':'',
                            'units':'',
                            'mechanical_rooms':'',
                            'administrative_rooms':'',
                            'amenity_rooms':'',
                            'service_rooms':'',
                            'parking_lot':'',
                            'bike_lot':'',
                            'storage_lot':'',
                            'mailbox':'',
                            'common_area':'',
                        
                        });
                    }

                }
            },


            check_building_dependency(e,type){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        this.form.dependent_building=true;
                        this.form.independent_building=false;
                        
                    }
                    else if(type==2)
                    {
                        this.form.dependent_building=false;
                        this.form.independent_building=true;
                    }
                }
                else{
                    this.form.dependent_building=false;
                    this.form.independent_building=false;
                }               
            },
            check_property_type(e,type){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        this.form.residential=true;
                        this.form.commercial=false;
                        this.form.residential_commercial=false;
                        
                    }
                    else if(type==2)
                    {
                        this.form.residential=false;
                        this.form.commercial=true;
                        this.form.residential_commercial=false;
                    }
                    else if(type==3)
                    {
                        this.form.residential=false;
                        this.form.commercial=false;
                        this.form.residential_commercial=true;
                    }
                }
                else{
                    this.form.residential=false;
                    this.form.commercial=false;
                    this.form.residential_commercial=false;
                }               
            },


            fetchBuildingProfile()
            {
                let uri = '/BuildingInfos';
                window.axios.get(uri).then((response) => {
                    

                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.form.safety_item_list_arr              =response.data.safety_item_list_arr;
                    this.external_service_provider_list_arr     =response.data.external_service_provider_list_arr;
                    this.building_contact_list_arr              =response.data.building_contact_list_arr;
                    this.form.license_and_permit_list_arr       =response.data.license_and_permit_list_arr;
                    
                    for(let i=0; i<this.external_service_provider_list_arr.length; i++){

                        this.form.external_service_provider_details_arr.push({
                            'id':'',
                            'reference_id':this.external_service_provider_list_arr[i].id,
                            'item_name':this.external_service_provider_list_arr[i].item_name,
                            'id_no':'',
                            'account_no':'',
                            'website':'',
                            'schedule_date':'',
                            'expected_due_date':'',
                            'billing_cycle':'',
                            'bill_delivery_method':'',
                            'payment_method':'',
                            'master_id':'',
                        
                        });
                    }


                    for(let i=0; i<this.building_contact_list_arr.length; i++){

                        if(this.building_contact_list_arr[i].item_type in this.form.building_contact_details_arr == false)
                        this.form.building_contact_details_arr[this.building_contact_list_arr[i].item_type] = {};

                        this.form.building_contact_details_arr[this.building_contact_list_arr[i].item_type][this.building_contact_list_arr[i].id]={
                            'id':'',
                            'reference_id':this.building_contact_list_arr[i].id,
                            'item_name':this.building_contact_list_arr[i].item_name,
                            'contact_no':'',
                            'phone':'',
                            'website':'',
                            'mobile':'',
                            'email':'',
                            'hours_of_operation':'',
                            'comments':'',
                            'master_id':'',
                        
                        }
                    }
                   
                   this.form.property_management_type_arr.push(
                       {
                            'id':'',
                            'reference_id':1,
                            'item_name':'External Property Management Services',
                            'id_no':'',
                            'name':'',
                            'phone':'',
                            'website':'',
                            'mobile':'',
                            'email':'',
                            'master_id':'',
                        },
                        {
                            'id':'',
                            'reference_id':2,
                            'item_name':'Board of Directors- Landlords',
                            'id_no':'',
                            'name':'',
                            'phone':'',
                            'website':'',
                            'mobile':'',
                            'email':'',
                            'master_id':'',
                        },
                        {
                            'id':'',
                            'reference_id':3,
                            'item_name':'Board of Directors-Leaseholders',
                            'id_no':'',
                            'name':'',
                            'phone':'',
                            'website':'',
                            'mobile':'',
                            'email':'',
                            'master_id':'',
                        },
                        {
                            'id':'',
                            'reference_id':4,
                            'item_name':'Owner Operator',
                            'id_no':'',
                            'name':'',
                            'phone':'',
                            'website':'',
                            'mobile':'',
                            'email':'',
                            'master_id':'',
                        }

                   )
                    



                    
                }); 

                
            },

            add_contact_details(index){
                this.form.custom_contact_type=index;
                $("#customContactModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
               
            },

            add_contact_details_back(index)
            {

                if(index in this.form.building_contact_details_arr == false)
                        this.form.building_contact_details_arr[index] = {};

                        this.form.building_contact_details_arr[index][this.building_contact_list_arr[i].id]={
                            'id':'',
                            'reference_id':this.building_contact_list_arr[i].id,
                            'item_name':this.building_contact_list_arr[i].item_name,
                            'contact_no':'',
                            'phone':'',
                            'website':'',
                            'mobile':'',
                            'email':'',
                            'hours_of_operation':'',
                            'comments':'',
                            'master_id':'',
                        
                        }
            },


            addNewCustomField()
            {   
                if(!this.form.custom_field_name)
                {
                    toast({
                        type: 'warning',
                        title: 'Please select Custom Field Name'
                    });
                    return;
                }

                
                this.form.post('/AddCustomContacts') .then(({ data }) => { 
               
                  var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Custom Field Added Successfully'
                        });

                        
                        var custom_field_id=response_data[1];
                        if(this.form.custom_contact_type in this.form.building_contact_details_arr == false)
                        this.form.building_contact_details_arr[this.form.custom_contact_type] = {};

                        this.form.building_contact_details_arr[this.form.custom_contact_type][custom_field_id]={
                            'id':'',
                            'reference_id':custom_field_id,
                            'item_name':this.form.custom_field_name,
                            'contact_no':'',
                            'phone':'',
                            'website':'',
                            'mobile':'',
                            'email':'',
                            'hours_of_operation':'',
                            'comments':'',
                            'master_id':'',
                        
                        }
                        this.form.custom_field_name='';
                        this.form.custom_contact_type='';

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

                      this.form.delete('/BuildingInfos/'+this.form.id).then(()=>{
                        
                          if(result.value) {
                               Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                              );
                            this.form.reset();
                            this.fetchBuildingProfile();
                          }            

                      }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                  });
               
              })
            },
      

            updateCustomerProfile()
            { 
                

		        this.form.put('/BuildingInfos/'+this.form.id).then(({ data })=>{
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


                if(this.form.dependent_building==false && this.form.independent_building==false)
                {

                    Swal("Warning!","Please Select Dependency Class","warning");
                    return;

                }
                if(this.form.residential==false && this.form.commercial==false && this.form.residential_commercial==false)
                {

                    Swal("Warning!","Please Select Property Type","warning");
                    return;

                }
                return;
                this.form.post('/BuildingInfos') .then(({ data }) => { 
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
                            this.fetchBuildingProfile();
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

                let uri = '/BuildingInfos/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.main_company_arr                       =response.data.main_company_arr;
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