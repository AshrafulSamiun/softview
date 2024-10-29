<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateFloorInfo() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Floor Information</h1>
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
                                                @change="change_company"
                                                :class="{ 'is-invalid': form.errors.has('company_name') }">
                                                <option  value="">--Select Sub- Company-- </option>
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
                                                @change="change_customer"
                                                :class="{ 'is-invalid': form.errors.has('customer_name') }">
                                                <option  value="">--Select Property Customer-- </option>
                                                 <option v-for="(customer,index) in customer_arr" :value="index">{{customer}}</option>
                                            </select>
                                            <has-error :form="form" field="customer_name"></has-error>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Building Name:</label> 
                                            <select v-model="form.building_name"
                                                name="building_name"
                                                class="custom-select" 
                                                @change="change_building"
                                                :class="{ 'is-invalid': form.errors.has('building_name') }">
                                                <option disabled value="">--Select Building Name-- </option>
                                                 <option v-for="(building,index) in building_arr" :value="index">{{building}}</option>
                                            </select>
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
                                            <label class="fieldlabels">Floor No:</label> 
                                            <select v-model="form.floor_no"
                                                name="floor_no"
                                                class="custom-select" 
                                                @change="change_floor"
                                                :class="{ 'is-invalid': form.errors.has('floor_no') }">
                                                <option disabled value="">--Select Floor-- </option>
                                                 <option v-for="(floor,index) in floor_arr" :value="index">Floor-{{floor.floor_no}}</option>
                                            </select>
                                                 <has-error :form="form" field="floor_no"></has-error> 
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Floor Name:</label> 
                                            <input v-model="form.floor_name" 
                                                type="text" 
                                                name="floor_name" 
                                                placeholder="Type Floor Name" 
                                                :class="{ 'is-invalid': form.errors.has('floor_name') }"/>
                                                 <has-error :form="form" field="floor_name"></has-error> 
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    
                                    <h4>Floor Type:</h4>
                                    <div class="form-holder">
                                        <div class="form-check-inline">
                                           
                                            <input type="checkbox" 
                                                id="roof_top" 
                                                name="roof_top" 
                                                 @click="check_property_type($event,1)"
                                                v-model="form.roof_top" disabled >
                                            <label for="roof_top">Roof Top</label><br>

                                            <input type="checkbox" 
                                                id="upper_floor" 
                                                name="upper_floor"
                                                 @click="check_property_type($event,2)" 
                                                v-model="form.upper_floor" disabled>
                                            <label for="upper_floor">Upper Floor</label><br>


                                            <input type="checkbox" 
                                                id="ground_floor" 
                                                name="ground_floor"
                                                 @click="check_property_type($event,3)" 
                                                v-model="form.ground_floor" disabled>
                                            <label for="ground_floor">Ground Floor</label><br>

                                            <input type="checkbox" 
                                                id="under_ground" 
                                                name="under_ground"
                                                 @click="check_property_type($event,3)" 
                                                v-model="form.under_ground" disabled>
                                            <label for="under_ground">Under Ground</label><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>

                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i>Property Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property()" v-show="!property_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property()" v-show="property_show">Hide</button></h3>
                    <div class="form-holder" v-show="property_show">
                        
                        <div class="row align-self-stretch">
                            
                            <div class="col-md-8 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                <div class="form-box-outer">
                                    
                                    <table class="table table_narrow"  >
                                        
                                        <thead>
                                            <tr>
                                                <th scope="col" width="60%"> Floor No-{{form.floor_name_string}} </th>
                                                <th scope="col" width="20%">Component Qty</th>
                                                <th scope="col" width="20%">Qty</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody >
                                            
                                            
                                            <template v-if="form.total_suite>0">
                                                <tr style="background-color: rgba(41,85,200,0.15);">
                                                    <td width="" scope="row"><h4><strong>Residential Suites</strong></h4></td>
                                                    <td width="">  
                                                    </td>
                                                    <td width="" align="right">{{form.total_suite}}</td>
                                                </tr>
                                                <template v-for="(single_suite,index) in form.subrooms_list_details_arr[1]" >
                                                    <tr >
                                                        <td width="" scope="row" style="padding-left:10% !important;"><h5><strong>Residential Suite No {{form.floor_name_string}}-{{index.padStart(2,"0")}}</strong></h5></td>
                                                        <td width=""></td>
                                                        <td width="">
                                                            <button type="button" class="btn btn-primary btn-sm" @click="collupsable_property(loop_sl)" >Show</button>

                                                            <button type="button" class="btn btn-primary btn-sm" @click="collupsable_property(loop_sl)" >Hide</button>
                                                        </td>
                                                    </tr>
                                                    <tr v-show="loop_cllupsoble">
                                                        <td width="" scope="row" style="padding-left:20% !important;"><h6><strong>Subrooms</strong></h6></td>
                                                        <td width=""></td>
                                                        <td width=""></td>
                                                    </tr>
                                                    
                                                    <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[1][index]" >
                                                        <tr >
                                                            <td width="60%" scope="row" style="padding-left:30% !important"><strong>{{subroom.item_name}}</strong></td>
                                                            <td width="20%">
                                                                <input v-model="subroom.item_qty" 
                                                                    type="number" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty"/>
                                                                     
                                                            </td>
                                                            <td width="20%"></td>
                                                        </tr>
                                                    </template>

                                                    
                                                </template>
                                            </template>


                                           <!---  ==============Units=============================================  -->

                                            <template v-if="form.total_unit>0">
                                                <tr style="background-color: rgba(41,85,200,0.15);">
                                                    <td  scope="row"><h4><strong>Commercial Units</strong></h4></td>
                                                    <td width="">  
                                                    </td>
                                                    <td width="">{{form.total_unit}}</td>
                                                </tr>
                                                <template v-for="(single_suite,index) in form.subrooms_list_details_arr[2]">
                                                    <tr >
                                                        <td width="" scope="row" style="padding-left:10% !important;"><h5><strong>Commercial Unit No {{form.floor_name_string}}-{{index}}</strong></h5></td>
                                                        <td width=""></td>
                                                        <td width=""></td>
                                                    </tr>
                                                    <tr >
                                                        <td width="" scope="row" style="padding-left:20% !important;"><h6><strong>Subrooms</strong></h6></td>
                                                        <td width=""></td>
                                                        <td width=""></td>
                                                    </tr>
                                                    
                                                    <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[2][index]" >
                                                        <tr >
                                                            <td width="60%" scope="row" style="padding-left:30% !important"><strong>{{subroom.item_name}}</strong></td>
                                                            <td width="20%">
                                                                <input v-model="subroom.item_qty" 
                                                                    type="number" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty"/>
                                                                     
                                                            </td>
                                                            <td width="20%"></td>
                                                        </tr>
                                                    </template>

                                                    
                                                </template>
                                            </template>


                                            <!---  ==============Mechanical  Room=============================================  -->

                                            <template v-if="form.total_mechanical_room>0">
                                                <tr style="background-color: rgba(41,85,200,0.15);">
                                                    <td  scope="row"><h4><strong>Mechanical  Room</strong></h4></td>
                                                    <td width="">  
                                                    </td>
                                                    <td width="">{{form.total_mechanical_room}}</td>
                                                </tr>
                                                
                                                    <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[7]" >
                                                        <tr >
                                                            <td width="60%" scope="row" style="padding-left:10% !important"><strong>{{subroom.item_name}}</strong></td>
                                                            <td width="20%">
                                                                <input v-model="subroom.item_qty" 
                                                                    type="number" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="20%"></td>
                                                        </tr>
                                                    </template>                                                    
                                               
                                            </template>

                                            <!---  ==============Administrative Room=============================================  -->

                                            <template v-if="form.total_administrative_room>0">
                                                <tr style="background-color: rgba(41,85,200,0.15);">
                                                    <td  scope="row"><h4><strong>Administrative Room</strong></h4></td>
                                                    <td width="">  
                                                    </td>
                                                    <td width="">{{form.total_administrative_room}}</td>
                                                </tr>
                                                
                                                    <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[8]" >
                                                        <tr >
                                                            <td width="60%" scope="row" style="padding-left:10% !important"><strong>{{subroom.item_name}}</strong></td>
                                                            <td width="20%">
                                                                <input v-model="subroom.item_qty" 
                                                                    type="number" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="20%"></td>
                                                        </tr>
                                                    </template>                                                    
                                               
                                            </template>

                                            <!---  ==============Amenity  Room=============================================  -->

                                            <template v-if="form.total_amenity_room>0">
                                                <tr style="background-color: rgba(41,85,200,0.15);">
                                                    <td  scope="row"><h4><strong>Amenity  Room</strong></h4></td>
                                                    <td width="">  
                                                    </td>
                                                    <td width="">{{form.total_amenity_room}}</td>
                                                </tr>
                                                
                                                    <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[9]">
                                                        <tr >
                                                            <td width="60%" scope="row" style="padding-left:10% !important"><strong>{{subroom.item_name}}</strong></td>
                                                            <td width="20%">
                                                                <input v-model="subroom.item_qty" 
                                                                    type="number" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="20%"></td>
                                                        </tr>
                                                    </template>                                                    
                                               
                                            </template>

                                            <!---  ==============Service  Room=============================================  -->

                                            <template v-if="form.total_service_room>0">
                                                <tr style="background-color: rgba(41,85,200,0.15);">
                                                    <td  scope="row"><h4><strong>Service  Room</strong></h4></td>
                                                    <td width="">  
                                                    </td>
                                                    <td width="">{{form.total_service_room}}</td>
                                                </tr>
                                                
                                                    <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[10]" >
                                                        <tr >
                                                            <td width="60%" scope="row" style="padding-left:10% !important"><strong>{{subroom.item_name}}</strong></td>
                                                            <td width="20%">
                                                                <input v-model="subroom.item_qty" 
                                                                    type="number" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="20%"></td>
                                                        </tr>
                                                    </template>                                                    
                                               
                                            </template>                                          

                                            <!---  ==============Parking Lot=============================================  -->

                                            <template v-if="form.total_parking_lot>0">
                                                <tr style="background-color: rgba(41,85,200,0.15);">
                                                    <td  scope="row"><h4><strong>Parking Lot</strong></h4></td>
                                                    <td width="">  
                                                    </td>
                                                    <td width="">{{form.total_parking_lot}}</td>
                                                </tr>
                                                <template v-for="(single_parking_lot,parking_index) in form.subrooms_list_details_arr[3]">

                                                    <tr>
                                                        <td width="" scope="row" style="padding-left:10% !important;"><h5><strong>Parking Level {{form.floor_name_string}}-{{parking_index.padStart(2,"0")}}</strong></h5></td>
                                                        <td width=""></td>
                                                        <td width=""></td>
                                                    </tr>
                                                    
                                                    
                                                    <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[3][parking_index]">
                                                        <tr >
                                                            <td width="60%" scope="row" style="padding-left:20% !important"><strong>{{subroom.item_name}}</strong></td>
                                                            <td width="20%">
                                                                <input v-model="subroom.item_qty" 
                                                                    type="number" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="20%"></td>
                                                        </tr>
                                                    </template>

                                                    
                                                </template>
                                            </template>

                                            <!---  ==============Bike Lot=============================================  -->

                                            <template v-if="form.total_parking_lot>0">

                                                <tr style="background-color: rgba(41,85,200,0.15);">
                                                    <td  scope="row"><h4><strong>Bike Lot</strong></h4></td>
                                                    <td width="">  
                                                    </td>
                                                    <td width="">{{form.total_bike_lot}}</td>
                                                </tr>
                                                <template v-for="(single_bike_lot,bike_index) in form.subrooms_list_details_arr[4]">

                                                    <tr>
                                                        <td width="" scope="row" style="padding-left:10% !important;"><h5><strong>Bike Level {{form.floor_name_string}}-{{bike_index.padStart(2,"0")}}</strong></h5></td>
                                                        <td width=""></td>
                                                        <td width=""></td>
                                                    </tr>
                                                    
                                                    <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[4][bike_index]" >
                                                        <tr>
                                                            <td width="60%" scope="row" style="padding-left:20% !important"><strong>{{subroom.item_name}}</strong></td>
                                                            <td width="20%">
                                                                <input v-model="subroom.item_qty" 
                                                                    type="number" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="20%"></td>
                                                        </tr>
                                                    </template>

                                                </template>
                                            </template>

                                            <!---  ==============Storage Lot=============================================  -->

                                            <template v-if="form.total_storage_lot>0">

                                                <tr style="background-color: rgba(41,85,200,0.15);">
                                                    <td  scope="row"><h4><strong>Storage Lot</strong></h4></td>
                                                    <td width="">  
                                                    </td>
                                                    <td width="">{{form.total_storage_lot}}</td>
                                                </tr>
                                                <template v-for="(single_storage_lot,storage_index) in form.subrooms_list_details_arr[5]">

                                                    <tr>
                                                        <td width="" scope="row" style="padding-left:10% !important;"><h5><strong>Storage Lot {{form.floor_name_string}}-{{storage_index.padStart(2,"0")}}</strong></h5></td>
                                                        <td width=""></td>
                                                        <td width=""></td>
                                                    </tr>
                                                    
                                                    <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[5][storage_index]" >
                                                        <tr>
                                                            <td width="60%" scope="row" style="padding-left:20% !important"><strong>{{subroom.item_name}}</strong></td>
                                                            <td width="20%">
                                                                <input v-model="subroom.item_qty" 
                                                                    type="number" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="20%"></td>
                                                        </tr>
                                                    </template>

                                                </template>
                                            </template>

                                            <!---  ==============Mail Room=============================================  -->

                                            <template v-if="form.total_mailroom>0">

                                                <tr style="background-color: rgba(41,85,200,0.15);">
                                                    <td  scope="row"><h4><strong>Mail Room</strong></h4></td>
                                                    <td width=""></td>
                                                    <td width="">{{form.total_mailroom}}</td>
                                                </tr>
                                                <template v-for="(single_mailroom,mailroom_index) in form.subrooms_list_details_arr[6]">

                                                    <tr>
                                                        <td width="" scope="row" style="padding-left:10% !important;"><h5><strong>Mail Room {{form.floor_name_string}}-{{mailroom_index.padStart(2,"0")}}</strong></h5></td>
                                                        <td width=""></td>
                                                        <td width=""></td>
                                                    </tr>
                                                    
                                                    <template v-for="(subroom,subroom_id) in single_mailroom" >
                                                        <tr>
                                                            <td width="60%" scope="row" style="padding-left:20% !important"><strong>{{subroom.item_name}} </strong></td>
                                                            <td width="20%">
                                                                <input v-model="subroom.item_qty" 
                                                                    type="number" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="20%"></td>
                                                        </tr>
                                                    </template>

                                                </template>
                                            </template>

                                            <!---  ==============Common Area=============================================  -->

                                            <template v-if="form.total_common_area>0">
                                                <tr style="background-color: rgba(41,85,200,0.15);">
                                                    <td  scope="row"><h4><strong>Common Area</strong></h4></td>
                                                    <td width="">  
                                                    </td>
                                                    <td width="">{{form.total_common_area}}</td>
                                                </tr>
                                                
                                                <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[11]" >
                                                    <tr >
                                                        <td width="60%" scope="row" style="padding-left:20% !important"><strong>{{subroom.item_name}}</strong></td>
                                                        <td width="20%">
                                                            <input v-model="subroom.item_qty" 
                                                                type="number" 
                                                                name="suite_qty[]" 
                                                                placeholder="Type Qty"/>
                                                        </td>
                                                        <td width="20%"></td>
                                                    </tr>
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
                                                                    <td scope="row" width="13%">{{safety_item.reference_name}}</td>
                                                                    <td >
                                                                        <input 
                                                                            type="text" 
                                                                            placeholder="Type Remarks"
                                                                            v-bind:id="'comment_'+index"
                                                                            name="comments[]" 
                                                                            v-model="safety_item.comments"/>
                                                                    </td>
                                                                    <td>
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
                                                                    <td scope="row" width="13%">{{safety_item.reference_name}}</td>
                                                                    <td >
                                                                        <input 
                                                                            type="text" 
                                                                            placeholder="Type Remarks"
                                                                            v-bind:id="'comment_'+index"
                                                                            name="comments[]" 
                                                                            v-model="safety_item.comments"/>
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
                                                                    <td scope="row"  width="13%" >{{safety_item.reference_name}}</td>
                                                                    <td >
                                                                        <input 
                                                                            type="text" 
                                                                            placeholder="Type Remarks"
                                                                            v-bind:id="'comment_'+index"
                                                                            name="comments[]" 
                                                                            v-model="safety_item.comments"/>
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
                                                    <template v-if="safety_item_list.refernece_id==4">
                                                        <template v-for="(safety_item,index) in form.water_valve_details_arr" >
                                                            
                                                            <tr >
                                                                    <td scope="row"  width="13%">{{safety_item.reference_name}}</td>
                                                                    <td >
                                                                        <input 
                                                                            type="text" 
                                                                            placeholder="Type Remarks"
                                                                            v-bind:id="'comment_'+index"
                                                                            name="comments[]" 
                                                                            v-model="safety_item.comments"/>
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
                                                    <template v-if="safety_item_list.refernece_id==5">
                                                        <template v-for="(safety_item,index) in form.gfci_breaker_details_arr" >
                                                            
                                                            <tr >
                                                                   <td scope="row"  width="13%" >{{safety_item.reference_name}}</td>
                                                                   <td >
                                                                        <input 
                                                                            type="text" 
                                                                            placeholder="Type Remarks"
                                                                            v-bind:id="'comment_'+index"
                                                                            name="comments[]" 
                                                                            v-model="safety_item.comments"/>
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

                                                    <template v-if="safety_item_list.refernece_id==6">
                                                        <template v-for="(safety_item,index) in form.sump_pump_details_arr" >
                                                            
                                                            <tr >
                                                                <td scope="row"  width="13%" >{{safety_item.reference_name}}</td>
                                                                <td >
                                                                    <input 
                                                                        type="text" 
                                                                        placeholder="Type Remarks"
                                                                        v-bind:id="'comment_'+index"
                                                                        name="comments[]" 
                                                                        v-model="safety_item.comments"/>
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
                                                    <template v-if="safety_item_list.refernece_id==7">
                                                        <template v-for="(safety_item,index) in form.emergency_bell_details_arr" >
                                                            
                                                            <tr >
                                                                    <td scope="row"  width="13%">{{safety_item.reference_name}}</td>
                                                                    <td >
                                                                        <input 
                                                                            type="text" 
                                                                            placeholder="Type Remarks"
                                                                            v-bind:id="'comment_'+index"
                                                                            name="comments[]" 
                                                                            v-model="safety_item.comments"/>
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
                                                    <template v-if="safety_item_list.refernece_id==8">
                                                        <template v-for="(safety_item,index) in form.emergency_light_arr" >
                                                            
                                                            <tr>
                                                                    <td scope="row"  width="13%" >{{safety_item.reference_name}}</td>
                                                                    <td >
                                                                        <input 
                                                                            type="text" 
                                                                            placeholder="Type Remarks"
                                                                            v-bind:id="'comment_'+index"
                                                                            name="comments[]" 
                                                                            v-model="safety_item.comments"/>
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
                                                    <template v-if="safety_item_list.refernece_id==9">
                                                        <template v-for="(safety_item,index) in form.first_aid_station_arr" >
                                                            
                                                            <tr >
                                                                    <td scope="row"  width="13%" >{{safety_item.reference_name}}</td>
                                                                    <td >
                                                                        <input 
                                                                            type="text" 
                                                                            placeholder="Type Remarks"
                                                                            v-bind:id="'comment_'+index"
                                                                            name="comments[]" 
                                                                            v-model="safety_item.comments"/>
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
                                                    <template v-if="safety_item_list.refernece_id==10">
                                                        <template v-for="(safety_item,index) in form.first_aid_box_arr" >
                                                            
                                                            <tr >
                                                                    <td scope="row"  width="13%" >{{safety_item.reference_name}}</td>
                                                                    <td >
                                                                        <input 
                                                                            type="text" 
                                                                            placeholder="Type Remarks"
                                                                            v-bind:id="'comment_'+index"
                                                                            name="comments[]" 
                                                                            v-model="safety_item.comments"/>
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
                                                    <template v-if="safety_item_list.refernece_id==11">
                                                        <template v-for="(safety_item,index) in form.aed_arr" >
                                                            
                                                            <tr >
                                                                    <td scope="row"  width="13%" >{{safety_item.reference_name}}</td>
                                                                    <td >
                                                                        <input 
                                                                            type="text" 
                                                                            placeholder="Type Remarks"
                                                                            v-bind:id="'comment_'+index"
                                                                            name="comments[]" 
                                                                            v-model="safety_item.comments"/>
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
                    building_name:'',
            		floor_no:'',
                    floor_name:'',
                    roof_top:false,
            		upper_floor:false,
            		under_ground:false,
            		ground_floor:false,
            		           		
                    page_id:2,
                  	id:'',


                    floor_name_string:'',
                    floor_type:'',
                    total_suite:'',
                    total_unit:'',
                    total_mechanical_room:'',
                    total_administrative_room:'',
                    total_amenity_room:'',
                    total_service_room:'',
                    total_parking_lot:'',
                    total_bike_lot:'',
                    total_storage_lot:'',
                    total_mailroom:'',
                    total_common_area:'',
                    subrooms_list_arr:[],
                    subrooms_list_details_arr:[],
                  	
                    safety_item_list_arr:[],
                    external_service_provider_details_arr:[],
                    fire_extinguisher_details_arr:[],
                    smoke_detecter_details_arr:[],
                    sprinkler_details_arr:[],
                    water_valve_details_arr:[],
                    gfci_breaker_details_arr:[],
                    sump_pump_details_arr:[],
                    emergency_bell_details_arr:[],
                    emergency_light_arr:[],
                    first_aid_station_arr:[],
                    first_aid_box_arr:[],
                    aed_arr:[],

            	}),
                test_collupsable:false,
                property_show:true,
                external_service_provider_list_arr:[],
                building_contact_list_arr:[],
            	account_disable:true,
            	account_no:'',
                
            	company_arr:[],
                customer_arr:[],
                building_arr:[],
                floor_arr:[],

      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchFloorProfile();
            //this.fetchBuildingUpdate(11);
           
        },
		
        computed:{


            
        },
	    methods: {

            reset_form()
            {

                this.form.reset();
                this.editmode=false;
            },
            change_company()
            {
                this.customer_arr=[];
                this.building_arr=[];
                this.form.customer_name='';
                this.form.customer_name='';
                let company=0;
                if(this.form.company_name>0) company=this.form.company_name;
                let uri = '/loadCustomerByCompany/'+company;
                window.axios.get(uri).then((response) => {
                    
                    this.customer_arr                           =response.data.customer_arr;
                });

                this.change_customer();
                
            },

            change_customer()
            {
                this.building_arr=[];
                this.form.building_name='';

                let company=0;
                if(this.form.company_name>0) company=this.form.company_name;
                let customer=0;
                if(this.form.customer_name>0) customer=this.form.customer_name;
                let uri = '/loadBuildingByCustomer/'+company+'/'+customer;
                window.axios.get(uri).then((response) => {
                    
                    this.building_arr                           =response.data.building_arr;
                });
                
            },

            change_building()
            {
                this.floor_arr=[];
                
                let uri = '/loadFloorByBuilding/'+this.form.building_name;
                window.axios.get(uri).then((response) => {
                    
                    this.floor_arr                           =response.data.floor_arr;
                });
                
            },
            change_floor()
            {

                let floor_type=this.floor_arr[this.form.floor_no].floor_type;
                this.form.floor_type=floor_type;

                this.form.total_suite               =this.floor_arr[this.form.floor_no].total_suite;
                this.form.total_unit                =this.floor_arr[this.form.floor_no].total_unit;
                this.form.total_mechanical_room     =this.floor_arr[this.form.floor_no].total_mechanical_room;
                this.form.total_administrative_room =this.floor_arr[this.form.floor_no].total_administrative_room;
                this.form.total_amenity_room        =this.floor_arr[this.form.floor_no].total_amenity_room;
                this.form.total_service_room        =this.floor_arr[this.form.floor_no].total_service_room;
                this.form.total_parking_lot         =this.floor_arr[this.form.floor_no].total_parking_lot;
                this.form.total_bike_lot            =this.floor_arr[this.form.floor_no].total_bike_lot;
                this.form.total_storage_lot         =this.floor_arr[this.form.floor_no].total_storage_lot;
                this.form.total_mailroom            =this.floor_arr[this.form.floor_no].total_mailroom;
                this.form.total_common_area         =this.floor_arr[this.form.floor_no].total_common_area;
                this.form.floor_name_string         =this.floor_arr[this.form.floor_no].floor_no;

                if(this.form.total_suite>0)
                {

                    if(1 in this.form.subrooms_list_details_arr == false)
                        this.form.subrooms_list_details_arr[1] = {};

                    for(let i=1;i<=this.form.total_suite;i++){

                        if(i in this.form.subrooms_list_details_arr[1] == false)
                            this.form.subrooms_list_details_arr[1][i] = {
                            };

                        for(let j=0;j<this.form.subrooms_list_arr.length;j++)
                        {

                            if(this.form.subrooms_list_arr[j].item_type==1)
                            {
                                if(j in this.form.subrooms_list_details_arr[1][i] == false)
                                    this.form.subrooms_list_details_arr[1][i][j] = {};

                                this.form.subrooms_list_details_arr[1][i][j]={
                                    'id':this.form.subrooms_list_arr[j].id,
                                    'item_name':this.form.subrooms_list_arr[j].item_name,
                                    'item_type':this.form.subrooms_list_arr[j].item_type,
                                    'item_id':this.form.subrooms_list_arr[j].id,
                                    'item_qty':"", 
                                    'collupseble':false,                                  
                                };

                            }
                        }


                        
                        
                    }
                }

                if(this.form.total_unit>0)
                {

                    if(2 in this.form.subrooms_list_details_arr == false)
                        this.form.subrooms_list_details_arr[2] = {};

                    for(let i=1;i<=this.form.total_unit;i++){

                        if(i in this.form.subrooms_list_details_arr[2] == false)
                            this.form.subrooms_list_details_arr[2][i] = {};

                        for(let j=0;j<this.form.subrooms_list_arr.length;j++)
                        {

                            if(this.form.subrooms_list_arr[j].item_type==2)
                            {
                                if(j in this.form.subrooms_list_details_arr[2][i] == false)
                                    this.form.subrooms_list_details_arr[2][i][j] = {};

                                this.form.subrooms_list_details_arr[2][i][j]={
                                    'id':this.form.subrooms_list_arr[j].id,
                                    'item_name':this.form.subrooms_list_arr[j].item_name,
                                    'item_type':this.form.subrooms_list_arr[j].item_type,
                                    'item_id':this.form.subrooms_list_arr[j].id,
                                    'item_qty':"",                                   
                                };

                            }
                        }
                        
                        
                    }
                }

                if(this.form.total_parking_lot>0)
                {
                    if(3 in this.form.subrooms_list_details_arr == false)
                        this.form.subrooms_list_details_arr[3] = {};

                    for(let i=1;i<=this.form.total_parking_lot;i++){

                        if(i in this.form.subrooms_list_details_arr[3] == false)
                            this.form.subrooms_list_details_arr[3][i] = {};

                        for(let j=0;j<this.form.subrooms_list_arr.length;j++)
                        {
                            if(this.form.subrooms_list_arr[j].item_type==3)
                            {
                                if(j in this.form.subrooms_list_details_arr[3][i] == false)
                                    this.form.subrooms_list_details_arr[3][i][j] = {};

                                this.form.subrooms_list_details_arr[3][i][j]={

                                    'id':this.form.subrooms_list_arr[j].id,
                                    'item_name':this.form.subrooms_list_arr[j].item_name,
                                    'item_type':this.form.subrooms_list_arr[j].item_type,
                                    'item_id':this.form.subrooms_list_arr[j].id,
                                    'item_qty':"",                                   
                                };
                            }
                        }
                    }
                }

                if(this.form.total_bike_lot>0)
                {
                    if(4 in this.form.subrooms_list_details_arr == false)
                        this.form.subrooms_list_details_arr[4] = {};

                    for(let i=1;i<=this.form.total_bike_lot;i++){

                        if(i in this.form.subrooms_list_details_arr[4] == false)
                            this.form.subrooms_list_details_arr[4][i] = {};   

                        for(let j=0;j<this.form.subrooms_list_arr.length;j++)
                        {
                            if(this.form.subrooms_list_arr[j].item_type==4)
                            {
                                if(j in this.form.subrooms_list_details_arr[4][i] == false)
                                    this.form.subrooms_list_details_arr[4][i][j] = {};

                                this.form.subrooms_list_details_arr[4][i][j]={
                                    'id':this.form.subrooms_list_arr[j].id,
                                    'item_name':this.form.subrooms_list_arr[j].item_name,
                                    'item_type':this.form.subrooms_list_arr[j].item_type,
                                    'item_id':this.form.subrooms_list_arr[j].id,
                                    'item_qty':"",                                   
                                };
                            }
                        }

                    }
                }

                if(this.form.total_storage_lot>0)
                {
                    if(5 in this.form.subrooms_list_details_arr == false)
                        this.form.subrooms_list_details_arr[5] = {};
                    for(let i=1;i<=this.form.total_storage_lot;i++){

                        if(i in this.form.subrooms_list_details_arr[5] == false)
                            this.form.subrooms_list_details_arr[5][i] = {};

                        for(let j=0;j<this.form.subrooms_list_arr.length;j++)
                        {
                            if(this.form.subrooms_list_arr[j].item_type==5)
                            {
                                if(j in this.form.subrooms_list_details_arr[5][i] == false)
                                    this.form.subrooms_list_details_arr[5][i][j] = {};

                                this.form.subrooms_list_details_arr[5][i][j]={
                                    'id':this.form.subrooms_list_arr[j].id,
                                    'item_name':this.form.subrooms_list_arr[j].item_name,
                                    'item_type':this.form.subrooms_list_arr[j].item_type,
                                    'item_id':this.form.subrooms_list_arr[j].id,
                                    'item_qty':"",                                   
                                };
                            }
                        }
                    }
                }

                if(this.form.total_mailroom>0)
                {
                    if(6 in this.form.subrooms_list_details_arr == false)
                        this.form.subrooms_list_details_arr[6] = {};

                    for(let i=1;i<=this.form.total_mailroom;i++){

                        if(i in this.form.subrooms_list_details_arr[6] == false)
                            this.form.subrooms_list_details_arr[6][i] = {};

                        for(let j=0;j<this.form.subrooms_list_arr.length;j++)
                        {
                            if(this.form.subrooms_list_arr[j].item_type==6)
                            {
                                if(j in this.form.subrooms_list_details_arr[6][i]== false)
                                    this.form.subrooms_list_details_arr[6][i][j] = {};

                                this.form.subrooms_list_details_arr[6][i][j]={
                                    'id':this.form.subrooms_list_arr[j].id,
                                    'item_name':this.form.subrooms_list_arr[j].item_name,
                                    'item_type':this.form.subrooms_list_arr[j].item_type,
                                    'item_id':this.form.subrooms_list_arr[j].id,
                                    'item_qty':"",                                   
                                };
                            }
                        }
                    }
                }
                if(this.form.total_mechanical_room>0)
                {
                    if(7 in this.form.subrooms_list_details_arr == false)
                        this.form.subrooms_list_details_arr[7] = {};

                    for(let j=0;j<this.form.subrooms_list_arr.length;j++)
                    {
                        if(this.form.subrooms_list_arr[j].item_type==7)
                        {
                            if(j in this.form.subrooms_list_details_arr[7] == false)
                                this.form.subrooms_list_details_arr[7][j] = {};

                            this.form.subrooms_list_details_arr[7][j]={
                                'id':this.form.subrooms_list_arr[j].id,
                                'item_name':this.form.subrooms_list_arr[j].item_name,
                                'item_type':this.form.subrooms_list_arr[j].item_type,
                                'item_id':this.form.subrooms_list_arr[j].id,
                                'item_qty':"",                                   
                            };
                        }
                    }
                }

                if(this.form.total_administrative_room>0)
                {
                    if(8 in this.form.subrooms_list_details_arr == false)
                        this.form.subrooms_list_details_arr[8] = {};
                        
                    for(let j=0;j<this.form.subrooms_list_arr.length;j++)
                    {
                        if(this.form.subrooms_list_arr[j].item_type==8)
                        {
                            if(j in this.form.subrooms_list_details_arr[8] == false)
                                this.form.subrooms_list_details_arr[8][j] = {};

                            this.form.subrooms_list_details_arr[8][j]={
                                'id':this.form.subrooms_list_arr[j].id,
                                'item_name':this.form.subrooms_list_arr[j].item_name,
                                'item_type':this.form.subrooms_list_arr[j].item_type,
                                'item_id':this.form.subrooms_list_arr[j].id,
                                'item_qty':"",                                   
                            };
                        }
                    }
                }

                if(this.form.total_amenity_room>0)
                {
                    if(9 in this.form.subrooms_list_details_arr == false)
                        this.form.subrooms_list_details_arr[9] = {};
                        
                    for(let j=0;j<this.form.subrooms_list_arr.length;j++)
                    {
                        if(this.form.subrooms_list_arr[j].item_type==9)
                        {
                            if(j in this.form.subrooms_list_details_arr[9] == false)
                                this.form.subrooms_list_details_arr[9][j] = {};

                            this.form.subrooms_list_details_arr[9][j]={
                                'id':this.form.subrooms_list_arr[j].id,
                                'item_name':this.form.subrooms_list_arr[j].item_name,
                                'item_type':this.form.subrooms_list_arr[j].item_type,
                                'item_id':this.form.subrooms_list_arr[j].id,
                                'item_qty':"",                                   
                            };
                        }
                    }
                }

                if(this.form.total_service_room>0)
                {
                    if(10 in this.form.subrooms_list_details_arr == false)
                        this.form.subrooms_list_details_arr[10] = {};
                        
                    for(let j=0;j<this.form.subrooms_list_arr.length;j++)
                    {
                        if(this.form.subrooms_list_arr[j].item_type==10)
                        {
                            if(j in this.form.subrooms_list_details_arr[10] == false)
                                this.form.subrooms_list_details_arr[10][j] = {};

                            this.form.subrooms_list_details_arr[10][j]={
                                'id':this.form.subrooms_list_arr[j].id,
                                'item_name':this.form.subrooms_list_arr[j].item_name,
                                'item_type':this.form.subrooms_list_arr[j].item_type,
                                'item_id':this.form.subrooms_list_arr[j].id,
                                'item_qty':"",                                   
                            };
                        }
                    }
                }

                if(this.form.total_common_area>0)
                {
                    if(11 in this.form.subrooms_list_details_arr == false)
                        this.form.subrooms_list_details_arr[11] = {};
                        
                    for(let j=0;j<this.form.subrooms_list_arr.length;j++)
                    {
                        if(this.form.subrooms_list_arr[j].item_type==11)
                        {
                            if(j in this.form.subrooms_list_details_arr[11] == false)
                                this.form.subrooms_list_details_arr[11][j] = {};

                            this.form.subrooms_list_details_arr[11][j]={
                                'id':this.form.subrooms_list_arr[j].id,
                                'item_name':this.form.subrooms_list_arr[j].item_name,
                                'item_type':this.form.subrooms_list_arr[j].item_type,
                                'item_id':this.form.subrooms_list_arr[j].id,
                                'item_qty':"",                                   
                            };
                        }
                    }
                }
                
                if(floor_type==1)
                {

                    this.form.roof_top=true;
                    this.form.upper_floor=false;
                    this.form.ground_floor=false;
                    this.form.under_ground=false;
                }
                else if(floor_type==2)
                {

                    this.form.roof_top=false;
                    this.form.upper_floor=true;
                    this.form.ground_floor=false;
                    this.form.under_ground=false;
                }
                else if(floor_type==3)
                {
                    this.form.roof_top=false;
                    this.form.upper_floor=false;
                    this.form.ground_floor=true;
                    this.form.under_ground=false;
                }
                else if(floor_type==4)
                {
                    this.form.roof_top=false;
                    this.form.upper_floor=false;
                    this.form.ground_floor=false;
                    this.form.under_ground=true;
                }

            },

            

            show_hide_property(){
                if(this.property_show)
                {
                    this.property_show=false;
                }
                else{
                    this.property_show=true;
                }
                
            },

            collupsable_property(type,id)
            {


               /* if(this.test_collupsable==true)
                {
                    this.test_collupsable=false;
                     alert(this.test_collupsable+"**");
                     return;
                }


                if(this.test_collupsable==false)
                {
                    this.test_collupsable=true;
                     alert(this.test_collupsable+"##");
                      return;
                }*/

                if(this.form.subrooms_list_details_arr[type][id].collupseble==true)
                {
                    this.form.subrooms_list_details_arr[type][id].collupseble=false;
                     alert(this.form.subrooms_list_details_arr[type][id].collupseble+"**");
                    return;
                }
                if(this.form.subrooms_list_details_arr[type][id].collupseble==false){
                    this.form.subrooms_list_details_arr[type][id].collupseble=true;
                    alert(this.form.subrooms_list_details_arr[type][id].collupseble+"##");
                    return;
                }
                
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
                                'comments':'',
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
                                'comments':'',
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
                                'comments':'',
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
                                'comments':'',
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

                    let array_length=this.form.gfci_breaker_details_arr.length;

                    if(array_length>item.item_qty)
                    {

                        this.form.gfci_breaker_details_arr.splice(item.item_qty);
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
                                'comments':'',
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
                                'comments':'',
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
                                'comments':'',
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
                else if(item.refernece_id==8)
                {
 
                    let array_length=this.form.emergency_light_arr.length;

                    if(array_length>item.item_qty)
                    {

                        this.form.emergency_light_arr.splice(item.item_qty);
                        return;
                    }

                    for(var i=1; i<=item.item_qty;i++)
                    {
                         if(array_length<i)
                        {
                            this.form.emergency_light_arr.push({
                                'id':'',
                                'reference_id':item.id,
                                'item_id':item.refernece_id,
                                'reference_name':item.item_name+' '+i,
                                'name':'',
                                'comments':'',
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
                else if(item.refernece_id==9)
                {

                    let array_length=this.form.first_aid_station_arr.length;

                    if(array_length>item.item_qty)
                    {

                        this.form.first_aid_station_arr.splice(item.item_qty);
                        return;
                    }

                    for(var i=1; i<=item.item_qty;i++)
                    {
                         if(array_length<i)
                        {
                            this.form.first_aid_station_arr.push({
                                'id':'',
                                'reference_id':item.id,
                                'item_id':item.refernece_id,
                                'reference_name':item.item_name+' '+i,
                                'name':'',
                                'comments':'',
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
                else if(item.refernece_id==10)
                {

                    let array_length=this.form.first_aid_box_arr.length;

                    if(array_length>item.item_qty)
                    {

                        this.form.first_aid_box_arr.splice(item.item_qty);
                        return;
                    }

                    for(var i=1; i<=item.item_qty;i++)
                    {
                         if(array_length<i)
                        {
                            this.form.first_aid_box_arr.push({
                                'id':'',
                                'reference_id':item.id,
                                'item_id':item.refernece_id,
                                'reference_name':item.item_name+' '+i,
                                'name':'',
                                'comments':'',
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
                else if(item.refernece_id==11)
                {

                    let array_length=this.form.aed_arr.length;

                    if(array_length>item.item_qty)
                    {

                        this.form.aed_arr.splice(item.item_qty);
                        return;
                    }

                    for(var i=1; i<=item.item_qty;i++)
                    {
                         if(array_length<i)
                        {
                            this.form.aed_arr.push({
                                'id':'',
                                'reference_id':item.id,
                                'item_id':item.refernece_id,
                                'reference_name':item.item_name+' '+i,
                                'name':'',
                                'comments':'',
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


           


            
           


            fetchFloorProfile()
            {
                let uri = '/Floors';
                window.axios.get(uri).then((response) => {
                    

                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.building_arr                           =response.data.building_arr;
                    this.form.subrooms_list_arr                 =response.data.subrooms_list_arr;
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
                            'comment':'',
                            'master_id':'',
                        
                        }
                    }
                   
                   //alert(response.data.property_management_arr.length);

                    for(let i=0; i<response.data.property_management_arr.length; i++)
                    {
                        this.form.property_management_type_arr.push({
                            'id':'',
                            'reference_id':response.data.property_management_arr[i].id,
                            'item_name':response.data.property_management_arr[i].val,
                            'id_no':'',
                            'name':'',
                            'phone':'',
                            'website':'',
                            'mobile':'',
                            'email':'',
                            'master_id':'',
                        });

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
                            this.fetchFloorProfile();
                          }            

                      }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                  });
               
              })
            },
      

            updateFloorInfo()
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

                        
                        this.fetchBuildingUpdate(response_data[1]);
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


                

                this.form.post('/Floors') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });

                        if(type==1)
                        {
                            this.fetchBuildingUpdate(response_data[1]);
                            this.editmode=true;
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                            
                        }
                        else if(type==3)
                        {
                            this.form.reset();
                            this.fetchFloorProfile();
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

            fetchBuildingUpdate(id)
            {
                this.form.reset ();

                let uri = '/BuildingInfos/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.form.safety_item_list_arr              =response.data.safety_item_list_arr;
                    this.external_service_provider_list_arr     =response.data.external_service_provider_list_arr;
                    this.building_contact_list_arr              =response.data.building_contact_list_arr;
                    this.form.license_and_permit_list_arr       =response.data.license_and_permit_list_arr;

                    this.form.id                                =response.data.building_data[0].id;
                    this.form.company_name                      =response.data.building_data[0].company_name;
                    this.form.customer_name                     =response.data.building_data[0].customer_name;
                    this.form.building_no                       =response.data.building_data[0].building_no;
                    this.form.building_name                     =response.data.building_data[0].building_name;
                    this.form.number_of_floor                   =response.data.building_data[0].number_of_floor;
                    this.form.number_of_upper_floor             =response.data.building_data[0].number_of_upper_floor;
                    this.form.number_of_roof_top                =response.data.building_data[0].number_of_roof_top;
                    this.form.number_of_ground_floor            =response.data.building_data[0].number_of_ground_floor;
                    this.form.number_of_under_ground            =response.data.building_data[0].number_of_under_ground;
                    this.form.residential                       =response.data.building_data[0].residential;
                    this.form.commercial                        =response.data.building_data[0].commercial;
                    this.form.residential_commercial            =response.data.building_data[0].residential_commercial;
                    
                    this.form.roof_top_arr=[];
                    for(let i=0; i<response.data.building_property_details_arr.length; i++){
                        if(response.data.building_property_details_arr[i].floor_type==1)
                        {
                            
                                this.form.roof_top_arr.push({
                                    'id':response.data.building_property_details_arr[i].id,
                                    'floor_no':response.data.building_property_details_arr[i].floor_type,
                                    'suites':response.data.building_property_details_arr[i].total_suite,
                                    'units':response.data.building_property_details_arr[i].total_unit,
                                    'mechanical_rooms':response.data.building_property_details_arr[i].total_mechanical_room,
                                    'administrative_rooms':response.data.building_property_details_arr[i].total_administrative_room,
                                    'amenity_rooms':response.data.building_property_details_arr[i].total_amenity_room,
                                    'service_rooms':response.data.building_property_details_arr[i].total_service_room,
                                    'parking_lot':response.data.building_property_details_arr[i].total_parking_lot,
                                    'bike_lot':response.data.building_property_details_arr[i].total_bike_lot,
                                    'storage_lot':response.data.building_property_details_arr[i].total_storage_lot,
                                    'mailbox':response.data.building_property_details_arr[i].total_mailroom,
                                    'common_area':response.data.building_property_details_arr[i].total_common_area,
                                
                                });
                            
                        }
                        else if(response.data.building_property_details_arr[i].floor_type==2)
                        {
                            
                                this.form.upper_building_arr.push({
                                    'id':response.data.building_property_details_arr[i].id,
                                    'floor_no':response.data.building_property_details_arr[i].floor_type,
                                    'suites':response.data.building_property_details_arr[i].total_suite,
                                    'units':response.data.building_property_details_arr[i].total_unit,
                                    'mechanical_rooms':response.data.building_property_details_arr[i].total_mechanical_room,
                                    'administrative_rooms':response.data.building_property_details_arr[i].total_administrative_room,
                                    'amenity_rooms':response.data.building_property_details_arr[i].total_amenity_room,
                                    'service_rooms':response.data.building_property_details_arr[i].total_service_room,
                                    'parking_lot':response.data.building_property_details_arr[i].total_parking_lot,
                                    'bike_lot':response.data.building_property_details_arr[i].total_bike_lot,
                                    'storage_lot':response.data.building_property_details_arr[i].total_storage_lot,
                                    'mailbox':response.data.building_property_details_arr[i].total_mailroom,
                                    'common_area':response.data.building_property_details_arr[i].total_common_area,
                                
                                });
                            
                        }
                        else if(response.data.building_property_details_arr[i].floor_type==3)
                        {
                            
                                this.form.ground_building_arr.push({
                                    'id':response.data.building_property_details_arr[i].id,
                                    'floor_no':response.data.building_property_details_arr[i].floor_type,
                                    'suites':response.data.building_property_details_arr[i].total_suite,
                                    'units':response.data.building_property_details_arr[i].total_unit,
                                    'mechanical_rooms':response.data.building_property_details_arr[i].total_mechanical_room,
                                    'administrative_rooms':response.data.building_property_details_arr[i].total_administrative_room,
                                    'amenity_rooms':response.data.building_property_details_arr[i].total_amenity_room,
                                    'service_rooms':response.data.building_property_details_arr[i].total_service_room,
                                    'parking_lot':response.data.building_property_details_arr[i].total_parking_lot,
                                    'bike_lot':response.data.building_property_details_arr[i].total_bike_lot,
                                    'storage_lot':response.data.building_property_details_arr[i].total_storage_lot,
                                    'mailbox':response.data.building_property_details_arr[i].total_mailroom,
                                    'common_area':response.data.building_property_details_arr[i].total_common_area,
                                
                                });
                            
                        }
                        else if(response.data.building_property_details_arr[i].floor_type==4)
                        {
                            
                                this.form.under_ground_building_arr.push({
                                    'id':response.data.building_property_details_arr[i].id,
                                    'floor_no':response.data.building_property_details_arr[i].floor_type,
                                    'suites':response.data.building_property_details_arr[i].total_suite,
                                    'units':response.data.building_property_details_arr[i].total_unit,
                                    'mechanical_rooms':response.data.building_property_details_arr[i].total_mechanical_room,
                                    'administrative_rooms':response.data.building_property_details_arr[i].total_administrative_room,
                                    'amenity_rooms':response.data.building_property_details_arr[i].total_amenity_room,
                                    'service_rooms':response.data.building_property_details_arr[i].total_service_room,
                                    'parking_lot':response.data.building_property_details_arr[i].total_parking_lot,
                                    'bike_lot':response.data.building_property_details_arr[i].total_bike_lot,
                                    'storage_lot':response.data.building_property_details_arr[i].total_storage_lot,
                                    'mailbox':response.data.building_property_details_arr[i].total_mailroom,
                                    'common_area':response.data.building_property_details_arr[i].total_common_area,
                                
                                });
                            
                        }
                        
                    }


                    for(let i=0; i<response.data.property_management_arr.length; i++)
                    {
                        

                         this.form.property_management_type_arr.push({
                            'id':response.data.property_management_arr[i].id,
                            'reference_id':response.data.property_management_arr[i].reference_id,
                            'item_name':response.data.property_management_arr[i].item_name,
                            'id_no':response.data.property_management_arr[i].id_no,
                            'name':response.data.property_management_arr[i].name,
                            'phone':response.data.property_management_arr[i].phone,
                            'website':response.data.property_management_arr[i].website,
                            'mobile':response.data.property_management_arr[i].mobile,
                            'email':response.data.property_management_arr[i].email,
                           // 'master_id':response.data.property_management_arr[i].master_id,
                        });

                    }


                    for(let i=0; i<response.data.safety_device_equipment_arr.length; i++){


                        if(response.data.safety_device_equipment_arr[i].item_id==1)
                        {
                            this.form.fire_extinguisher_details_arr.push({
                                'id':response.data.safety_device_equipment_arr[i].id,
                                'reference_id':response.data.safety_device_equipment_arr[i].reference_id,
                                'item_id':response.data.safety_device_equipment_arr[i].item_id,
                                'reference_name':response.data.safety_device_equipment_arr[i].reference_name,
                                'name':response.data.safety_device_equipment_arr[i].name,
                                'comments':response.data.safety_device_equipment_arr[i].comments,
                                'floor_no':response.data.safety_device_equipment_arr[i].floor_no,
                                'serial_no':response.data.safety_device_equipment_arr[i].serial_no,
                                'expiry_date':response.data.safety_device_equipment_arr[i].expiry_date,
                                'renew_date':response.data.safety_device_equipment_arr[i].renew_date,
                                'cicle':response.data.safety_device_equipment_arr[i].cicle,
                                'due_on':response.data.safety_device_equipment_arr[i].due_on,
                                
                            });
                        }
                        else if(response.data.safety_device_equipment_arr[i].item_id==2)
                        {
                            this.form.smoke_detecter_details_arr.push({
                                'id':response.data.safety_device_equipment_arr[i].id,
                                'reference_id':response.data.safety_device_equipment_arr[i].reference_id,
                                'item_id':response.data.safety_device_equipment_arr[i].item_id,
                                'reference_name':response.data.safety_device_equipment_arr[i].reference_name,
                                'name':response.data.safety_device_equipment_arr[i].name,
                                'comments':response.data.safety_device_equipment_arr[i].comments,
                                'floor_no':response.data.safety_device_equipment_arr[i].floor_no,
                                'serial_no':response.data.safety_device_equipment_arr[i].serial_no,
                                'expiry_date':response.data.safety_device_equipment_arr[i].expiry_date,
                                'renew_date':response.data.safety_device_equipment_arr[i].renew_date,
                                'cicle':response.data.safety_device_equipment_arr[i].cicle,
                                'due_on':response.data.safety_device_equipment_arr[i].due_on,
                                
                            });
                        }
                        else if(response.data.safety_device_equipment_arr[i].item_id==3)
                        {
                            this.form.sprinkler_details_arr.push({
                                'id':response.data.safety_device_equipment_arr[i].id,
                                'reference_id':response.data.safety_device_equipment_arr[i].reference_id,
                                'item_id':response.data.safety_device_equipment_arr[i].item_id,
                                'reference_name':response.data.safety_device_equipment_arr[i].reference_name,
                                'name':response.data.safety_device_equipment_arr[i].name,
                                'comments':response.data.safety_device_equipment_arr[i].comments,
                                'floor_no':response.data.safety_device_equipment_arr[i].floor_no,
                                'serial_no':response.data.safety_device_equipment_arr[i].serial_no,
                                'expiry_date':response.data.safety_device_equipment_arr[i].expiry_date,
                                'renew_date':response.data.safety_device_equipment_arr[i].renew_date,
                                'cicle':response.data.safety_device_equipment_arr[i].cicle,
                                'due_on':response.data.safety_device_equipment_arr[i].due_on,
                                
                            });
                        }
                        else if(response.data.safety_device_equipment_arr[i].item_id==4)
                        {
                            this.form.water_valve_details_arr.push({
                                'id':response.data.safety_device_equipment_arr[i].id,
                                'reference_id':response.data.safety_device_equipment_arr[i].reference_id,
                                'item_id':response.data.safety_device_equipment_arr[i].item_id,
                                'reference_name':response.data.safety_device_equipment_arr[i].reference_name,
                                'name':response.data.safety_device_equipment_arr[i].name,
                                'comments':response.data.safety_device_equipment_arr[i].comments,
                                'floor_no':response.data.safety_device_equipment_arr[i].floor_no,
                                'serial_no':response.data.safety_device_equipment_arr[i].serial_no,
                                'expiry_date':response.data.safety_device_equipment_arr[i].expiry_date,
                                'renew_date':response.data.safety_device_equipment_arr[i].renew_date,
                                'cicle':response.data.safety_device_equipment_arr[i].cicle,
                                'due_on':response.data.safety_device_equipment_arr[i].due_on,
                                
                            });
                        }
                        else if(response.data.safety_device_equipment_arr[i].item_id==5)
                        {
                            this.form.gfci_breaker_details_arr.push({
                                'id':response.data.safety_device_equipment_arr[i].id,
                                'reference_id':response.data.safety_device_equipment_arr[i].reference_id,
                                'item_id':response.data.safety_device_equipment_arr[i].item_id,
                                'reference_name':response.data.safety_device_equipment_arr[i].reference_name,
                                'name':response.data.safety_device_equipment_arr[i].name,
                                'comments':response.data.safety_device_equipment_arr[i].comments,
                                'floor_no':response.data.safety_device_equipment_arr[i].floor_no,
                                'serial_no':response.data.safety_device_equipment_arr[i].serial_no,
                                'expiry_date':response.data.safety_device_equipment_arr[i].expiry_date,
                                'renew_date':response.data.safety_device_equipment_arr[i].renew_date,
                                'cicle':response.data.safety_device_equipment_arr[i].cicle,
                                'due_on':response.data.safety_device_equipment_arr[i].due_on,
                                
                            });
                        }
                        else if(response.data.safety_device_equipment_arr[i].item_id==6)
                        {
                            this.form.sump_pump_details_arr.push({
                                'id':response.data.safety_device_equipment_arr[i].id,
                                'reference_id':response.data.safety_device_equipment_arr[i].reference_id,
                                'item_id':response.data.safety_device_equipment_arr[i].item_id,
                                'reference_name':response.data.safety_device_equipment_arr[i].reference_name,
                                'name':response.data.safety_device_equipment_arr[i].name,
                                'comments':response.data.safety_device_equipment_arr[i].comments,
                                'floor_no':response.data.safety_device_equipment_arr[i].floor_no,
                                'serial_no':response.data.safety_device_equipment_arr[i].serial_no,
                                'expiry_date':response.data.safety_device_equipment_arr[i].expiry_date,
                                'renew_date':response.data.safety_device_equipment_arr[i].renew_date,
                                'cicle':response.data.safety_device_equipment_arr[i].cicle,
                                'due_on':response.data.safety_device_equipment_arr[i].due_on,
                                
                            });
                        }
                        else if(response.data.safety_device_equipment_arr[i].item_id==7)
                        {
                            this.form.emergency_bell_details_arr.push({
                                'id':response.data.safety_device_equipment_arr[i].id,
                                'reference_id':response.data.safety_device_equipment_arr[i].reference_id,
                                'item_id':response.data.safety_device_equipment_arr[i].item_id,
                                'reference_name':response.data.safety_device_equipment_arr[i].reference_name,
                                'name':response.data.safety_device_equipment_arr[i].name,
                                'comments':response.data.safety_device_equipment_arr[i].comments,
                                'floor_no':response.data.safety_device_equipment_arr[i].floor_no,
                                'serial_no':response.data.safety_device_equipment_arr[i].serial_no,
                                'expiry_date':response.data.safety_device_equipment_arr[i].expiry_date,
                                'renew_date':response.data.safety_device_equipment_arr[i].renew_date,
                                'cicle':response.data.safety_device_equipment_arr[i].cicle,
                                'due_on':response.data.safety_device_equipment_arr[i].due_on,
                                
                            });
                        }
                        else if(response.data.safety_device_equipment_arr[i].item_id==8)
                        {
                            this.form.emergency_light_arr.push({
                                'id':response.data.safety_device_equipment_arr[i].id,
                                'reference_id':response.data.safety_device_equipment_arr[i].reference_id,
                                'item_id':response.data.safety_device_equipment_arr[i].item_id,
                                'reference_name':response.data.safety_device_equipment_arr[i].reference_name,
                                'name':response.data.safety_device_equipment_arr[i].name,
                                'comments':response.data.safety_device_equipment_arr[i].comments,
                                'floor_no':response.data.safety_device_equipment_arr[i].floor_no,
                                'serial_no':response.data.safety_device_equipment_arr[i].serial_no,
                                'expiry_date':response.data.safety_device_equipment_arr[i].expiry_date,
                                'renew_date':response.data.safety_device_equipment_arr[i].renew_date,
                                'cicle':response.data.safety_device_equipment_arr[i].cicle,
                                'due_on':response.data.safety_device_equipment_arr[i].due_on,
                                
                            });
                        }
                        else if(response.data.safety_device_equipment_arr[i].item_id==9)
                        {
                            this.form.first_aid_station_arr.push({
                                'id':response.data.safety_device_equipment_arr[i].id,
                                'reference_id':response.data.safety_device_equipment_arr[i].reference_id,
                                'item_id':response.data.safety_device_equipment_arr[i].item_id,
                                'reference_name':response.data.safety_device_equipment_arr[i].reference_name,
                                'name':response.data.safety_device_equipment_arr[i].name,
                                'comments':response.data.safety_device_equipment_arr[i].comments,
                                'floor_no':response.data.safety_device_equipment_arr[i].floor_no,
                                'serial_no':response.data.safety_device_equipment_arr[i].serial_no,
                                'expiry_date':response.data.safety_device_equipment_arr[i].expiry_date,
                                'renew_date':response.data.safety_device_equipment_arr[i].renew_date,
                                'cicle':response.data.safety_device_equipment_arr[i].cicle,
                                'due_on':response.data.safety_device_equipment_arr[i].due_on,
                                
                            });
                        }
                        else if(response.data.safety_device_equipment_arr[i].item_id==10)
                        {
                            this.form.first_aid_box_arr.push({
                                'id':response.data.safety_device_equipment_arr[i].id,
                                'reference_id':response.data.safety_device_equipment_arr[i].reference_id,
                                'item_id':response.data.safety_device_equipment_arr[i].item_id,
                                'reference_name':response.data.safety_device_equipment_arr[i].reference_name,
                                'name':response.data.safety_device_equipment_arr[i].name,
                                'comments':response.data.safety_device_equipment_arr[i].comments,
                                'floor_no':response.data.safety_device_equipment_arr[i].floor_no,
                                'serial_no':response.data.safety_device_equipment_arr[i].serial_no,
                                'expiry_date':response.data.safety_device_equipment_arr[i].expiry_date,
                                'renew_date':response.data.safety_device_equipment_arr[i].renew_date,
                                'cicle':response.data.safety_device_equipment_arr[i].cicle,
                                'due_on':response.data.safety_device_equipment_arr[i].due_on,
                                
                            });
                        }
                        else if(response.data.safety_device_equipment_arr[i].item_id==11)
                        {
                            this.form.aed_arr.push({
                                'id':response.data.safety_device_equipment_arr[i].id,
                                'reference_id':response.data.safety_device_equipment_arr[i].reference_id,
                                'item_id':response.data.safety_device_equipment_arr[i].item_id,
                                'reference_name':response.data.safety_device_equipment_arr[i].reference_name,
                                'name':response.data.safety_device_equipment_arr[i].name,
                                'comments':response.data.safety_device_equipment_arr[i].comments,
                                'floor_no':response.data.safety_device_equipment_arr[i].floor_no,
                                'serial_no':response.data.safety_device_equipment_arr[i].serial_no,
                                'expiry_date':response.data.safety_device_equipment_arr[i].expiry_date,
                                'renew_date':response.data.safety_device_equipment_arr[i].renew_date,
                                'cicle':response.data.safety_device_equipment_arr[i].cicle,
                                'due_on':response.data.safety_device_equipment_arr[i].due_on,
                                
                            });
                        }
                        
                    }
                    
                   
                    for(let i=0; i<this.external_service_provider_list_arr.length; i++){

                        this.form.external_service_provider_details_arr.push({
                            'id':this.external_service_provider_list_arr[i].id,
                            'reference_id':this.external_service_provider_list_arr[i].reference_id,
                            'item_name':this.external_service_provider_list_arr[i].item_name,
                            'id_no':this.external_service_provider_list_arr[i].id_no,
                            'account_no':this.external_service_provider_list_arr[i].account_no,
                            'website':this.external_service_provider_list_arr[i].id,
                            'schedule_date':this.external_service_provider_list_arr[i].schedule_date,
                            'expected_due_date':this.external_service_provider_list_arr[i].expected_due_date,
                            'billing_cycle':this.external_service_provider_list_arr[i].billing_cycle,
                            'bill_delivery_method':this.external_service_provider_list_arr[i].bill_delivery_method,
                            'payment_method':this.external_service_provider_list_arr[i].payment_method,
                            'master_id':this.external_service_provider_list_arr[i].master_id,
                        
                        });
                    }


                    for(let i=0; i<this.building_contact_list_arr.length; i++){
                        if(this.building_contact_list_arr[i].item_type in this.form.building_contact_details_arr == false)
                        this.form.building_contact_details_arr[this.building_contact_list_arr[i].item_type] = {};

                        this.form.building_contact_details_arr[this.building_contact_list_arr[i].item_type][this.building_contact_list_arr[i].reference_id]={
                            'id':this.building_contact_list_arr[i].id,
                            'reference_id':this.building_contact_list_arr[i].reference_id,
                            'item_name':this.building_contact_list_arr[i].item_name,
                            'contact_no':this.building_contact_list_arr[i].contact_no,
                            'phone':this.building_contact_list_arr[i].phone,
                            'website':this.building_contact_list_arr[i].website,
                            'mobile':this.building_contact_list_arr[i].mobile,
                            'email':this.building_contact_list_arr[i].email,
                            'hours_of_operation':this.building_contact_list_arr[i].hours_of_operation,
                            'comment':this.building_contact_list_arr[i].comment,
                            'master_id':this.building_contact_list_arr[i].master_id,
                        
                        }
                    }
                   
                   
                   
                    this.editmode=true;
                   

                    

                    
                }); 

                
            },
	    }
    
    }  
	
</script>