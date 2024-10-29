<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateCommercialUnit() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Commercial Unit</h1>
                <div class="text-center">


                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_list()">List</button>
                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>


                </div>
                <div v-if="list_showable" class="card-body">
                    <div class="pull-left" style="margin-top:50px;">
                        <label for="filter" class="sr-only">Filter</label>
                        <input type="text" class="form-control" v-model="filter" placeholder="Filter" style="width:400px;">
                    </div>
                    <datatable :columns="columns" :data="rows" :filter-by="filter">
                        <template slot-scope="{row}">
                            <tr>
                                <td>{{ row.sl }}</td>
                                <td>{{ row.company_name }}</td>
                                <td>{{ row.customer_name }}</td>
                                <td>{{ row.building_name }}</td>
                                <td>{{ row.floor_no }}</td>
                                <td>{{ row.unit_no }}</td>
                                <td>{{ row.system_no }}</td>
                                <td>{{ row.property_name }}</td>
                                <td>{{ row.unit_type }}</td>
                                <td>{{ row.total_unit_size }}</td>
                                <td width="120">
                                    <button class="btn btn-primary btn-sm"  @click.prevent="editCommercialUnit(row.id)">Edit</button>
                                    <button  class="btn btn-danger btn-sm" @click.prevent="CommercialUnitDelete(row.id)">Delete</button>
                                </td>
                            </tr>
                        </template>
                    </datatable>
                    <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
                </div>
                <div v-if="!list_showable">
                    <div class="form-folder">
                        <h3><i class="fa fa-hand-point-right"></i> General Information:
                            <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="!general_info_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="general_info_show">Hide</button>

                        </h3>
                        <div class="form-holder" v-show="general_info_show">
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
                                                    <option  value="null" v-if="form.company_name===null">--Select Sub- Company-- </option>
                                                    <option  value="" v-else>--Select Sub- Company-- </option>
                                                   
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
                                                    <option  value="null" v-if="form.customer_name===null">--Select Property Customer-- </option>
                                                    <option  value="" v-else>--Select Property Customer-- </option>
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
                                                <label class="fieldlabels">Unit No:</label> 
                                                <select v-model="form.unit_no"
                                                    name="unit_no"
                                                    class="custom-select" 
                                                    @change="change_unit_no"
                                                    :class="{ 'is-invalid': form.errors.has('unit_no') }">
                                                    <option disabled value="">--Select Unit-- </option>
                                                     <option v-for="unit in form.total_unit" :value="unit">Unit No {{form.floor_name_string}}-{{unit.toString().padStart(2,"0")}}</option>
                                                </select>
                                                <has-error :form="form" field="unit_no"></has-error> 
                                            </div>
                                            <label class="fieldlabels">Property ID:</label> 
                                                <input v-model="form.system_no" 
                                                    type="text" 
                                                    name="system_no" 
                                                    placeholder="Auto Generated" 
                                                    :class="{ 'is-invalid': form.errors.has('system_no') }" disabled/>
                                                <has-error :form="form" field="system_no"></has-error>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="fieldlabels">Property Name:</label> 
                                                <input v-model="form.property_name" 
                                                    type="text" 
                                                    name="property_name" 
                                                    placeholder="Type Unit Name" 
                                                    :class="{ 'is-invalid': form.errors.has('property_name') }"/>
                                                <has-error :form="form" field="property_name"></has-error> 
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                               
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                        <label class="fieldlabels">UOM:</label>
                                         <select v-model="form.unit_uom"
                                            name="unit_uom"
                                            class="custom-select" 
                                            
                                            :class="{ 'is-invalid': form.errors.has('unit_uom') }" >
                                            <option  value="">--Select UOM-- </option>
                                            <option value="1">Square Feet</option>
                                            <option value="2">Square Meter</option>
                                            <option value="3">Square Yard</option>
                                        </select>
                                        <has-error :form="form" field="unit_uom"></has-error>

                                        <label class="fieldlabels">Unit Size:</label> 
                                        <input v-model="form.total_unit_size" 
                                            type="number" 
                                            name="total_unit_size" 
                                            placeholder="Type Unit Size" 
                                            :class="{ 'is-invalid': form.errors.has('total_unit_size') }"/>
                                        <has-error :form="form" field="total_unit_size"></has-error>
                                        <h4>Dependency Class:</h4>
                                        <div class="form-holder">
                                            <div class="form-check-inline">
                                                <input type="checkbox" 
                                                    id="dependent_building" 
                                                    name="dependent_building"
                                                    v-model="form.dependent_building" disabled>
                                                <label for="dependent_building">Dependent</label><br>

                                                <input type="checkbox" 
                                                    id="independent_building" 
                                                    name="independent_building" 
                                                    v-model="form.independent_building" disabled>
                                                <label for="independent_building" disabled>Independent</label><br>
                                               
                                            </div>
                                        </div>


                                        <h4>Property Type:</h4>
                                        <div class="form-holder">
                                            <div class="form-check-inline">
                                               
                                                <input type="checkbox" 
                                                    id="residential" 
                                                    name="residential" 
                                                    v-model="form.residential" disabled>
                                                <label for="residential">Residential</label><br>

                                                <input type="checkbox" 
                                                    id="commercial" 
                                                    name="commercial"
                                                    v-model="form.commercial" disabled>
                                                <label for="commercial" >Commercial</label><br>
                                                <input type="checkbox" 
                                                    id="residential_commercial" 
                                                    name="residential_commercial"
                                                    v-model="form.residential_commercial" disabled>
                                                <label for="residential_commercial">Residential-Commercial</label><br>
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
                                                    v-model="form.roof_top" disabled >
                                                <label for="roof_top">Roof Top</label><br>

                                                <input type="checkbox" 
                                                    id="upper_floor" 
                                                    name="upper_floor"
                                                    v-model="form.upper_floor" disabled>
                                                <label for="upper_floor">Upper Floor</label><br>


                                                <input type="checkbox" 
                                                    id="ground_floor" 
                                                    name="ground_floor"
                                                    v-model="form.ground_floor" disabled>
                                                <label for="ground_floor">Ground Floor</label><br>

                                                <input type="checkbox" 
                                                    id="under_ground" 
                                                    name="under_ground"
                                                    v-model="form.under_ground" disabled>
                                                <label for="under_ground">Under Ground</label><br>
                                            </div>
                                        </div>

                                        <h4>Unit Type:</h4>
                                        <div class="form-holder">
                                            <div class="form-check-inline">
                                               
                                                <input type="checkbox" 
                                                    id="unit_store" 
                                                    name="unit_store" 
                                                     @click="check_unit_type($event,1)"
                                                    v-model="form.unit_store"  >
                                                <label for="unit_store">Store</label><br>

                                                <input type="checkbox" 
                                                    id="unit_office" 
                                                    name="unit_office"
                                                     @click="check_unit_type($event,2)" 
                                                    v-model="form.unit_office" >
                                                <label for="unit_office">Office</label><br>
                                            </div>
                                        </div>

                                        <h4>Summery:</h4>
                                        <div class="form-holder">
                                            <div class="form-check-inline">
                                               
                                                <input type="radio" 
                                                    id="residential" 
                                                    name="residential"  disabled>
                                                <label for="residential">Total Sub Rooms: {{ form.total_subrooms}} </label><br>

                                                <input type="radio" 
                                                    id="commercial" 
                                                    name="commercial" disabled>
                                                <label for="commercial" >Sub Rooms Total Size: {{ form.total_subroom_size}} {{uom_arr[form.unit_uom]}}</label><br>

                                                <input type="radio" 
                                                    id="residential_commercial" 
                                                    name="residential_commercial" disabled>
                                                <label for="residential_commercial">Total Unit Size: {{form.total_unit_size}} {{uom_arr[form.unit_uom]}}</label><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder">
                        <h3><i class="fa fa-hand-point-right"></i>Commercial Unit Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property()" v-show="!property_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property()" v-show="property_show">Hide</button></h3>
                        <div class="form-holder" v-show="property_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer">
                                        
                                        <table class="table table_narrow" >
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="20%">Sub Room Type</th>
                                                    <th scope="col" width="15%">Property ID</th>
                                                    <th scope="col" width="15%">Property Name</th>
                                                    <th scope="col" width="15%">Size ({{uom_arr[form.unit_uom]}})</th>
                                                    <th scope="col" width="35%">Comments </th>                                               
                                                </tr>
                                            </thead>
                                            <tbody >
                                                
                                                
                                                <template v-if="form.total_unit>0">
                                                    
                                                    <template v-for="(single_subroom,index) in form.subrooms_list_arr" >
                                                                                                          
                                                        <tr v-if="single_subroom.disable" style="background-color:rgb(228, 233, 230)">
                                                            <td width="20%" scope="row" style="padding-left:5% !important"><strong>{{single_subroom.item_name}}</strong></td>
                                                            <td width="15%">

                                                                <input v-model="single_subroom.system_no" 
                                                                    type="text"
                                                                    name="suite_system_no[]" 
                                                                    placeholder="Auto Generated" disabled/>
                                                            </td>
                                                            <td width="15%">

                                                                <input v-model="single_subroom.property_name" 
                                                                    type="text"
                                                                    name="subrooms_property_name[]" 
                                                                    placeholder="Type Property Name" disabled/>
                                                            </td>
                                                            <td width="15%">

                                                                <input v-model="single_subroom.item_size" 
                                                                    type="number"
                                                                    @keyup="change_room_size()" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty" disabled/>
                                                            </td>

                                                            <td width="35%">

                                                                <input v-model="single_subroom.comments" 
                                                                    type="text"
                                                                    name="suite_comments[]" 
                                                                    placeholder="Type Comments" disabled/>
                                                            </td>
                                                        </tr>
                                                         <tr v-else>
                                                            <td width="20%" scope="row" style="padding-left:5% !important"><strong>{{single_subroom.item_name}}</strong></td>
                                                            <td width="15%">

                                                                <input v-model="single_subroom.system_no" 
                                                                    type="text"
                                                                    name="suite_system_no[]" 
                                                                    placeholder="Auto Generated" disabled/>
                                                            </td>
                                                            <td width="15%">

                                                                <input v-model="single_subroom.property_name" 
                                                                    type="text"
                                                                    name="subrooms_property_name[]" 
                                                                    placeholder="Type Property Name" />
                                                            </td>
                                                            <td width="15%">

                                                                <input v-model="single_subroom.item_size" 
                                                                    type="number" 
                                                                    name="suite_qty[]" 
                                                                    @keyup="change_room_size()"
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="35%">

                                                                <input v-model="single_subroom.comments" 
                                                                    type="text"
                                                                    name="suite_comments[]" 
                                                                    placeholder="Type Comments" />
                                                            </td>
                                                        </tr>

                                                    </template>                                                   
                                                   
                                                </template>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td class="text-center">{{form.total_subroom_size}}</td>
                                                </tr>
                                              </tfoot>
                                        </table> 
                                    </div>
                                </div>                         
                                
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder">
                        <h3><i class="fa fa-hand-point-right"></i>Safety Devices and Equipment's
                            <button type="button" class="btn btn-primary btn-sm" @click="show_hide_safety_equipment()" v-show="!safety_equipment_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_safety_equipment()" v-show="safety_equipment_show">Hide</button>
                        </h3>
                        <div class="form-holder" v-show="safety_equipment_show">
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"> 
                                    <div class="form-box-outer">
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr >
                                                    <th scope="col" rowspan="2">Safety Item</th>
                                                    <th scope="col" rowspan="2">Qty</th>
                                                    <th scope="col" rowspan="2">Serial No</th>
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
                                                                        <td>
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

                                                                        <td>
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
                        <h3><i class="fa fa-hand-point-right"></i>External Services Providers Accounts Details
                            <button type="button" class="btn btn-primary btn-sm" @click="show_hide_service_provider()" v-show="!external_service_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_service_provider()" v-show="external_service_show">Hide</button>
                        </h3>
                        <div class="form-holder" v-show="external_service_show">
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
                        <h3><i class="fa fa-hand-point-right"></i> Contacts Details

                            <button type="button" class="btn btn-primary btn-sm" @click="show_hide_contact_details()" v-show="!contact_details_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_contact_details()" v-show="contact_details_show">Hide</button>
                        </h3>
                        <div class="form-holder" v-show="contact_details_show">
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
                                                                    placeholder="Type Comment"
                                                                    v-bind:id="'comment_'+index"
                                                                    name="comment[]" 
                                                                    v-model="contact_details.comment"/>
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

                    <div class="text-center" v-if="!list_showable">
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Update</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deleteCommercialUnit()">Delete</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode">Void</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(1)">Save-Stay</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(2)">Save-Out</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(3)">Save-New</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
                    </div>
                </div>
                
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
                tempeditmode:false,
            	show_company:true,
                list_showable:false,
				filter: '',
            	form:new Form({
                    company_name:'',
                    customer_name:'',
                    building_name:'',
            		floor_no:'',
                    floor_name:'',
                    unit_no:'',
                    property_name:'',
                    system_no:'',
                    roof_top:false,
            		upper_floor:false,
            		under_ground:false,
            		ground_floor:false,
                    dependent_building:false,
                    independent_building:false,
                    residential:false,
                    commercial:false,
                    residential_commercial:false,
                    unit_store:false,
                    unit_office:false,
            		unit_uom:1,          		
                    page_id:2,
                  	id:'',


                    floor_name_string:'',
                    floor_type:'',
                    total_unit:'',
                    total_unit_size:0,
                    total_subroom_size:'',
                   
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
                    building_contact_details_arr:[],
                    custom_contact_type:'',
                    custom_field_name:'',
            	}),

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Sub- Company', field: 'company_name' },
                    { label: 'Property Customer', field: 'customer_name' },
                    { label: 'Building Name', field: 'building_name' },
                    { label: 'Floor No', field: 'floor_no' },
                    { label: 'Unit No', field: 'unit_no' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'Unit Type', field: 'unit_type' },
                    { label: 'Total Unit Size', field: 'total_unit_size' },
                    { label: 'Action', field: '', sortable: false },
                ],
                rows: [],
                test_collupsable:false,
                general_info_show:true,
                property_show:false,
                safety_equipment_show:false,
                external_service_show:false,
                contact_details_show:false,
                external_service_provider_list_arr:[],
                building_contact_list_arr:[],
            	account_disable:true,
            	account_no:'',
                
            	company_arr:[],
                customer_arr:[],
                building_arr:[],
                floor_arr:[],
                suite_expression:[],
                uom_arr:['','Square Feet','Square Meter','Square Yard'],
                page: 1,
                per_page:15,
                expanded: null
			}
        },
		
		created: function()
        {
            this.user_menu_name = this.$route.name;
            this.fetchUnitProfile();
            //this.editCommercialUnit(4);
           
        },
		
        computed:{


            
        },
	    methods: {


            editCommercialUnit(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/CommercialUnits/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    

                    this.editmode=true;
                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.building_arr                           =response.data.building_arr;
                    this.form.safety_item_list_arr              =response.data.safety_item_list_arr;
                    this.form.subrooms_list_arr                 =response.data.subrooms_list_arr;
                    this.external_service_provider_list_arr     =response.data.external_service_provider_list_arr;
                    this.building_contact_list_arr              =response.data.building_contact_list_arr;
                    let safety_device_equipment_arr             =response.data.safety_device_equipment_arr;

                    this.form.id                                =response.data.commercial_unit_arr.id;
                    this.form.company_name                      =response.data.commercial_unit_arr.company_name;
                    this.form.customer_name                     =response.data.commercial_unit_arr.customer_name;
                    this.form.building_name                     =response.data.commercial_unit_arr.building_name;
                    
                    this.form.floor_no                          =response.data.commercial_unit_arr.floor_no;
                    this.form.unit_no                           =response.data.commercial_unit_arr.unit_no;
                    this.form.system_no                         =response.data.commercial_unit_arr.system_no;
                    this.form.property_name                     =response.data.commercial_unit_arr.property_name;
                    this.form.total_unit_size                   =response.data.commercial_unit_arr.total_unit_size;
                    this.form.unit_uom                          =response.data.commercial_unit_arr.unit_uom;

                    this.floor_arr                              =response.data.floor_arr;
                    this.form.dependent_building                =response.data.building_info[0].dependent_building;
                    this.form.independent_building              =response.data.building_info[0].independent_building;
                    this.form.residential                       =response.data.building_info[0].residential;
                    this.form.commercial                        =response.data.building_info[0].commercial;
                    this.form.residential_commercial            =response.data.building_info[0].residential_commercial;
                  
                    if(response.data.commercial_unit_arr.unit_type==1)
                        this.form.unit_store                      =true;
                    else
                        this.form.unit_office                     =true;

                    let floor_type=response.data.floor_type;
                    this.form.floor_type=floor_type;

                    this.form.total_unit                =response.data.total_unit;
                    this.form.floor_name_string         =response.data.floor_no_string;          

                    this.form.roof_top=false;
                    this.form.upper_floor=false;
                    this.form.ground_floor=false;
                    this.form.under_ground=false;


                    if(floor_type==1)
                    {
                        this.form.roof_top=true;
                    }
                    else if(floor_type==2)
                    {
                        this.form.upper_floor=true;

                    }
                    else if(floor_type==3)
                    {
                        this.form.ground_floor=true;
                    }
                    else if(floor_type==4)
                    {
                        this.form.under_ground=true;
                    }     
                    
                    
                    this.change_room_size();

                    for(let i=0; i<safety_device_equipment_arr.length; i++){

                        if(safety_device_equipment_arr[i].item_id==1)
                        {

                            this.form.fire_extinguisher_details_arr.push({
                                'id':safety_device_equipment_arr[i].id,
                                'reference_id':safety_device_equipment_arr[i].reference_id,
                                'item_id':safety_device_equipment_arr[i].item_id,
                                'reference_name':safety_device_equipment_arr[i].reference_name,
                                'name':safety_device_equipment_arr[i].name,
                                'comments':safety_device_equipment_arr[i].comments,
                                'floor_no':safety_device_equipment_arr[i].floor_no,
                                'serial_no':safety_device_equipment_arr[i].serial_no,
                                'expiry_date':safety_device_equipment_arr[i].expiry_date,
                                'renew_date':safety_device_equipment_arr[i].renew_date,
                                'cicle':safety_device_equipment_arr[i].cicle,
                                'due_on':safety_device_equipment_arr[i].due_on,
                            });

                        }
                        else if(safety_device_equipment_arr[i].item_id==2)
                        {

                            this.form.smoke_detecter_details_arr.push({
                                'id':safety_device_equipment_arr[i].id,
                                'reference_id':safety_device_equipment_arr[i].reference_id,
                                'item_id':safety_device_equipment_arr[i].item_id,
                                'reference_name':safety_device_equipment_arr[i].reference_name,
                                'name':safety_device_equipment_arr[i].name,
                                'comments':safety_device_equipment_arr[i].comments,
                                'floor_no':safety_device_equipment_arr[i].floor_no,
                                'serial_no':safety_device_equipment_arr[i].serial_no,
                                'expiry_date':safety_device_equipment_arr[i].expiry_date,
                                'renew_date':safety_device_equipment_arr[i].renew_date,
                                'cicle':safety_device_equipment_arr[i].cicle,
                                'due_on':safety_device_equipment_arr[i].due_on,
                            });

                        }
                        else if(safety_device_equipment_arr[i].item_id==3)
                        {

                            this.form.sprinkler_details_arr.push({
                                'id':safety_device_equipment_arr[i].id,
                                'reference_id':safety_device_equipment_arr[i].reference_id,
                                'item_id':safety_device_equipment_arr[i].item_id,
                                'reference_name':safety_device_equipment_arr[i].reference_name,
                                'name':safety_device_equipment_arr[i].name,
                                'comments':safety_device_equipment_arr[i].comments,
                                'floor_no':safety_device_equipment_arr[i].floor_no,
                                'serial_no':safety_device_equipment_arr[i].serial_no,
                                'expiry_date':safety_device_equipment_arr[i].expiry_date,
                                'renew_date':safety_device_equipment_arr[i].renew_date,
                                'cicle':safety_device_equipment_arr[i].cicle,
                                'due_on':safety_device_equipment_arr[i].due_on,
                            });

                        }
                        else if(safety_device_equipment_arr[i].item_id==4)
                        {

                            this.form.water_valve_details_arr.push({
                                'id':safety_device_equipment_arr[i].id,
                                'reference_id':safety_device_equipment_arr[i].reference_id,
                                'item_id':safety_device_equipment_arr[i].item_id,
                                'reference_name':safety_device_equipment_arr[i].reference_name,
                                'name':safety_device_equipment_arr[i].name,
                                'comments':safety_device_equipment_arr[i].comments,
                                'floor_no':safety_device_equipment_arr[i].floor_no,
                                'serial_no':safety_device_equipment_arr[i].serial_no,
                                'expiry_date':safety_device_equipment_arr[i].expiry_date,
                                'renew_date':safety_device_equipment_arr[i].renew_date,
                                'cicle':safety_device_equipment_arr[i].cicle,
                                'due_on':safety_device_equipment_arr[i].due_on,
                            });

                        }
                        else if(safety_device_equipment_arr[i].item_id==5)
                        {

                            this.form.gfci_breaker_details_arr.push({
                                'id':safety_device_equipment_arr[i].id,
                                'reference_id':safety_device_equipment_arr[i].reference_id,
                                'item_id':safety_device_equipment_arr[i].item_id,
                                'reference_name':safety_device_equipment_arr[i].reference_name,
                                'name':safety_device_equipment_arr[i].name,
                                'comments':safety_device_equipment_arr[i].comments,
                                'floor_no':safety_device_equipment_arr[i].floor_no,
                                'serial_no':safety_device_equipment_arr[i].serial_no,
                                'expiry_date':safety_device_equipment_arr[i].expiry_date,
                                'renew_date':safety_device_equipment_arr[i].renew_date,
                                'cicle':safety_device_equipment_arr[i].cicle,
                                'due_on':safety_device_equipment_arr[i].due_on,
                            });

                        }
                        else if(safety_device_equipment_arr[i].item_id==6)
                        {

                            this.form.sump_pump_details_arr.push({
                                'id':safety_device_equipment_arr[i].id,
                                'reference_id':safety_device_equipment_arr[i].reference_id,
                                'item_id':safety_device_equipment_arr[i].item_id,
                                'reference_name':safety_device_equipment_arr[i].reference_name,
                                'name':safety_device_equipment_arr[i].name,
                                'comments':safety_device_equipment_arr[i].comments,
                                'floor_no':safety_device_equipment_arr[i].floor_no,
                                'serial_no':safety_device_equipment_arr[i].serial_no,
                                'expiry_date':safety_device_equipment_arr[i].expiry_date,
                                'renew_date':safety_device_equipment_arr[i].renew_date,
                                'cicle':safety_device_equipment_arr[i].cicle,
                                'due_on':safety_device_equipment_arr[i].due_on,
                            });

                        }
                        else if(safety_device_equipment_arr[i].item_id==7)
                        {

                            this.form.emergency_bell_details_arr.push({
                                'id':safety_device_equipment_arr[i].id,
                                'reference_id':safety_device_equipment_arr[i].reference_id,
                                'item_id':safety_device_equipment_arr[i].item_id,
                                'reference_name':safety_device_equipment_arr[i].reference_name,
                                'name':safety_device_equipment_arr[i].name,
                                'comments':safety_device_equipment_arr[i].comments,
                                'floor_no':safety_device_equipment_arr[i].floor_no,
                                'serial_no':safety_device_equipment_arr[i].serial_no,
                                'expiry_date':safety_device_equipment_arr[i].expiry_date,
                                'renew_date':safety_device_equipment_arr[i].renew_date,
                                'cicle':safety_device_equipment_arr[i].cicle,
                                'due_on':safety_device_equipment_arr[i].due_on,
                            });

                        }
                        else if(safety_device_equipment_arr[i].item_id==8)
                        {

                            this.form.emergency_light_arr.push({
                                'id':safety_device_equipment_arr[i].id,
                                'reference_id':safety_device_equipment_arr[i].reference_id,
                                'item_id':safety_device_equipment_arr[i].item_id,
                                'reference_name':safety_device_equipment_arr[i].reference_name,
                                'name':safety_device_equipment_arr[i].name,
                                'comments':safety_device_equipment_arr[i].comments,
                                'floor_no':safety_device_equipment_arr[i].floor_no,
                                'serial_no':safety_device_equipment_arr[i].serial_no,
                                'expiry_date':safety_device_equipment_arr[i].expiry_date,
                                'renew_date':safety_device_equipment_arr[i].renew_date,
                                'cicle':safety_device_equipment_arr[i].cicle,
                                'due_on':safety_device_equipment_arr[i].due_on,
                            });

                        }
                        else if(safety_device_equipment_arr[i].item_id==9)
                        {

                            this.form.first_aid_station_arr.push({
                                'id':safety_device_equipment_arr[i].id,
                                'reference_id':safety_device_equipment_arr[i].reference_id,
                                'item_id':safety_device_equipment_arr[i].item_id,
                                'reference_name':safety_device_equipment_arr[i].reference_name,
                                'name':safety_device_equipment_arr[i].name,
                                'comments':safety_device_equipment_arr[i].comments,
                                'floor_no':safety_device_equipment_arr[i].floor_no,
                                'serial_no':safety_device_equipment_arr[i].serial_no,
                                'expiry_date':safety_device_equipment_arr[i].expiry_date,
                                'renew_date':safety_device_equipment_arr[i].renew_date,
                                'cicle':safety_device_equipment_arr[i].cicle,
                                'due_on':safety_device_equipment_arr[i].due_on,
                            });

                        }
                        else if(safety_device_equipment_arr[i].item_id==10)
                        {

                            this.form.first_aid_box_arr.push({
                                'id':safety_device_equipment_arr[i].id,
                                'reference_id':safety_device_equipment_arr[i].reference_id,
                                'item_id':safety_device_equipment_arr[i].item_id,
                                'reference_name':safety_device_equipment_arr[i].reference_name,
                                'name':safety_device_equipment_arr[i].name,
                                'comments':safety_device_equipment_arr[i].comments,
                                'floor_no':safety_device_equipment_arr[i].floor_no,
                                'serial_no':safety_device_equipment_arr[i].serial_no,
                                'expiry_date':safety_device_equipment_arr[i].expiry_date,
                                'renew_date':safety_device_equipment_arr[i].renew_date,
                                'cicle':safety_device_equipment_arr[i].cicle,
                                'due_on':safety_device_equipment_arr[i].due_on,
                            });

                        }
                        else if(safety_device_equipment_arr[i].item_id==11)
                        {

                            this.form.aed_arr.push({
                                'id':safety_device_equipment_arr[i].id,
                                'reference_id':safety_device_equipment_arr[i].reference_id,
                                'item_id':safety_device_equipment_arr[i].item_id,
                                'reference_name':safety_device_equipment_arr[i].reference_name,
                                'name':safety_device_equipment_arr[i].name,
                                'comments':safety_device_equipment_arr[i].comments,
                                'floor_no':safety_device_equipment_arr[i].floor_no,
                                'serial_no':safety_device_equipment_arr[i].serial_no,
                                'expiry_date':safety_device_equipment_arr[i].expiry_date,
                                'renew_date':safety_device_equipment_arr[i].renew_date,
                                'cicle':safety_device_equipment_arr[i].cicle,
                                'due_on':safety_device_equipment_arr[i].due_on,
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
                            'website':this.external_service_provider_list_arr[i].website,
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

                }); 

                this.tempeditmode=false;
                
            },
            change_room_size()
            {
                let total_subroom_size=0;
                this.form.subrooms_list_arr.forEach(function(item,index){

                    if(!item.disable)
                    {
                        total_subroom_size+=(item.item_size)*1;
                    }
                });

                this.form.total_subroom_size=total_subroom_size;
                                                                        
            },



            reset_form()
            {

                this.form.reset();
                this.editmode=false;
                this.list_showable=false;
                this.fetchUnitProfile();
            },

            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/CommercialUnitLits';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.commercial_unit_list;
                });
                this.list_showable=true;
            },

            change_company()
            {
            
                if(this.tempeditmode) 
                {
                    return;

                }
               
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
                
                if(this.tempeditmode==true) return;
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
                
                let uri = '/UnitFloorDataByBuilding/'+this.form.building_name;
                window.axios.get(uri).then((response) => {
                    
                    this.floor_arr                              =response.data.floor_arr;
                    this.form.dependent_building                =response.data.building_info[0].dependent_building;
                    this.form.independent_building              =response.data.building_info[0].independent_building;
                    this.form.residential                       =response.data.building_info[0].residential;
                    this.form.commercial                        =response.data.building_info[0].commercial;
                    this.form.residential_commercial            =response.data.building_info[0].residential_commercial;
                });
            },


            check_unit_type(e,type){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        this.form.unit_store=true;
                        this.form.unit_office=false;
                        
                    }
                    else if(type==2)
                    {
                        this.form.unit_store=false;
                        this.form.unit_office=true;
                    }
                    
                   
                }
                else{
                    this.form.unit_store=false;
                    this.form.unit_office=false;
                }               
            },

            

            change_floor()
            {
                let floor_type=this.floor_arr[this.form.floor_no].floor_type;
                this.form.floor_type=floor_type;

                this.form.total_unit                =this.floor_arr[this.form.floor_no].total_unit;
                this.form.floor_name_string         =this.floor_arr[this.form.floor_no].floor_no;          
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

            change_unit_no(){

                this.form.total_unit_size=0;
                let uri = '/loadUnitByFloor/'+this.form.floor_no+'/'+this.form.unit_no;
                window.axios.get(uri).then((response) => {
                    
                    this.form.subrooms_list_arr                 =response.data.subrooms_list_arr;

                });
            },
   

            add_contact_details(index){
                this.form.custom_contact_type=index;
                $("#customContactModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
               
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
                            'comment':'',
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

            show_hide_property(){
                if(this.property_show)
                {
                    this.property_show=false;
                }
                else{
                    this.property_show=true;
                }
                
            },

            show_hide_general_info(){
                if(this.general_info_show)
                {
                    this.general_info_show=false;
                }
                else{
                    this.general_info_show=true;
                }
                
            },

            show_hide_safety_equipment(){
                if(this.safety_equipment_show)
                {
                    this.safety_equipment_show=false;
                }
                else{
                    this.safety_equipment_show=true;
                }
                
            },

            show_hide_service_provider(){
                if(this.external_service_show)
                {
                    this.external_service_show=false;
                }
                else{
                    this.external_service_show=true;
                }
                
            },

            show_hide_contact_details(){
                if(this.contact_details_show)
                {
                    this.contact_details_show=false;
                }
                else{
                    this.contact_details_show=true;
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
          


            fetchUnitProfile()
            {
                let uri = '/CommercialUnits';
                window.axios.get(uri).then((response) => {
                    

                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.building_arr                           =response.data.building_arr;
                    this.form.safety_item_list_arr              =response.data.safety_item_list_arr;
                    this.external_service_provider_list_arr     =response.data.external_service_provider_list_arr;
                    this.building_contact_list_arr              =response.data.building_contact_list_arr;
                    
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
                    
                }); 

                
            },
            CommercialUnitDelete(id)
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
                    this.form.delete('/CommercialUnits/'+id).then(()=>{
                        
                        if(result.value) {
                            Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.reset_list();
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
                

            },
	
            deleteCommercialUnit()
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
                    this.form.delete('/CommercialUnits/'+this.form.id).then(()=>{
                        
                        if(result.value) {
                            Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.fetchUnitProfile();
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
            },
      

            updateCommercialUnit()
            { 
                

		        this.form.put('/CommercialUnits/'+this.form.id).then(({ data })=>{
					var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        
                        this.editCommercialUnit(response_data[1]);
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


                

                this.form.post('/CommercialUnits') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });

                        if(type==1)
                        {
                            this.editCommercialUnit(response_data[1]);
                            this.editmode=true;
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                            
                        }
                        else if(type==3)
                        {
                            this.form.reset();
                            this.fetchUnitProfile();
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
	    }
    
    }  
	
</script>