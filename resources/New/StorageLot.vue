<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateStoragelot() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Storage Lot</h1>
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
                                <td>{{ row.system_no }}</td>
                                <td>{{ row.property_name }}</td>
                                <td>{{ row.lot_number }}</td>
                                <td>{{ row.storage_lot_size_qty }}</td>
                                <td width="120">
                                    <button class="btn btn-primary btn-sm"  @click.prevent="editStorageLot(row.id)">Edit</button>
                                    <button  class="btn btn-danger btn-sm" @click.prevent="StorageLotDelete(row.id)">Delete</button>
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
                                    
                                        <label class="fieldlabels">Property ID:</label> 
                                        <input v-model="form.system_no" 
                                            type="text" 
                                            name="system_no" 
                                            placeholder="Auto Generated" 
                                            :class="{ 'is-invalid': form.errors.has('system_no') }"/>
                                        <has-error :form="form" field="unit_no"></has-error> 
                                    
                                        <label class="fieldlabels">Property Name:</label> 
                                        <input v-model="form.property_name" 
                                            type="text" 
                                            name="property_name" 
                                            placeholder="Type Property Name" 
                                            :class="{ 'is-invalid': form.errors.has('property_name') }"/>
                                        <has-error :form="form" field="property_name"></has-error>
                                        <label class="fieldlabels">Lot Number - Name:</label> 
                                        <input v-model="form.lot_number" 
                                            type="text" 
                                            name="lot_number" 
                                            placeholder="Type Lot Number - Name" 
                                            :class="{ 'is-invalid': form.errors.has('lot_number') }"/>
                                        <has-error :form="form" field="lot_number"></has-error>                                             
                                    </div>
                                   
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                        <label class="fieldlabels">UOM:</label> 
                                            <select v-model="form.lot_uom"
                                                name="lot_uom"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('lot_uom') }" >
                                                <option  value="">--Select-- </option>
                                                <option value="1">Square Feet</option>
                                                <option value="2">Square Meter</option>
                                                <option value="3">Square Yard</option>
                                            </select>
                                            <has-error :form="form" field="lot_uom"></has-error>
                                            

                                            <label class="fieldlabels">Lot Size:</label> 
                                            <input v-model="form.storage_lot_size_qty" 
                                                type="number" 
                                                name="storage_lot_size_qty" 
                                                placeholder="Type Lot Size" 
                                                :class="{ 'is-invalid': form.errors.has('storage_lot_size_qty') }"/>
                                            <has-error :form="form" field="storage_lot_size_qty"></has-error>
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

                                        
                                    </div>
                                   
                                </div>
                                <div class="col-md-5 col-sm-6 col-xs-12">
                                    
                                    <div class="form-box-outer">
                                        
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
                                        <h4>Summery:</h4>
                                        <div class="form-holder">
                                            <div class="form-check-inline">
                                               
                                                <input type="radio" 
                                                    id="storage_level" 
                                                    name="storage_level" disabled checked>
                                                <label for="storage_level">Total Storage Level:{{form.storage_level}}</label><br>

                                                <input type="radio" 
                                                    id="storage_locker" 
                                                    name="storage_locker" disabled checked>
                                                <label for="storage_locker">Total Storage Locker:{{form.storage_locker}}</label><br>

                                                <input type="radio" 
                                                    id="storage_lot_size_qty" 
                                                    name="storage_lot_size_qty"  disabled checked>
                                                <label for="storage_lot_size_qty">Storage Lot Size:{{form.storage_lot_size_qty}}  {{uom_arr[form.lot_uom]}}</label><br>
                                                <input type="radio" 
                                                    id="storage_level_qty" 
                                                    name="storage_level_qty" disabled checked>
                                                <label for="storage_level_qty">Total Storage Level Size: {{form.total_storage_level_size}} {{uom_arr[form.lot_uom]}}</label><br>
                                                <input type="radio" 
                                                    id="storage_locker_qty" 
                                                    name="storage_locker_qty" disabled checked>
                                                <label for="storage_locker_qty">Total Storage `Locker Size: {{form.total_storage_locker_size}} {{uom_arr[form.lot_uom]}}</label><br>
                                            </div>
                                        </div>
                                            
                                    </div>
                                </div>
                               
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Storage Lot Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property()" v-show="!property_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property()" v-show="property_show">Hide</button></h3>
                        <div class="form-holder" v-show="property_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="13%" rowspan="2">Storage Level/ Locker</th>
                                                    <th scope="col" width="13%" rowspan="2">Property ID</th>
                                                    <th scope="col" width="11%" rowspan="2">Property Name</th>
                                                    <th scope="col" width="9%" rowspan="2">UOM</th>
                                                    <th scope="col" width="10%" rowspan="2">Size</th> 
                                                    <th scope="col" :colspan="storage_type_arr_length+1" align="center" width="">Locker Size
                                                    </th>
                                                    <th width="60" rowspan="2">Details</th>
                                                </tr>
                                                <tr style="font-size:11px !important;writing-mode: vertical-lr;">
                                                    <th v-for="(locker_type,index) in storage_type_arr" >
                                                        {{locker_type}}
                                                    </th>
                                                    <th>Total</th>
                                                                                                  
                                                </tr>
                                            </thead>
                                            <tbody >
                                                <template v-if="form.total_storage_lot>0">
                                                    <template v-for="(single_level,level) in form.subrooms_list_arr" >

                                                        <tr style="background-color: #6090bc;color: #fff;">
                                                            <td width="10%" scope="row" style=""><strong>Storage Level {{level.toString().padStart(2,"0")}}</strong></td>
                                                            <td width="150">
                                                                <input v-model="single_level.system_no" 
                                                                    type="text"
                                                                    name="lavel_system_no[]" 
                                                                    placeholder="Auto Generated" disabled/>
                                                            </td>
                                                            <td width="150">

                                                                <input v-model="single_level.property_name" 
                                                                    type="text"
                                                                    name="lavel_property_name[]" 
                                                                    placeholder="Type Property Name" />
                                                            </td>
                                                            <td width="">
                                                                 {{uom_arr[form.lot_uom]}}
                                                            </td>
                                                            <td width="120">
                                                                 <input v-model="single_level.item_size" 
                                                                        type="number"
                                                                        name="lavel_size_qty[]"
                                                                         @keyup="change_level_size()" 
                                                                        placeholder="Type Size Qty" /> 
                                                            </td>
                                                            <td v-for="(locker_type,index) in storage_type_arr">
                                                                <strong>{{form.storage_type_total_arr[level][index]}}</strong>
                                                            </td>
                                                            <td >
                                                                <strong>{{form.storage_type_total_arr[level]['total']}}</strong>
                                                            </td>
                                                            <td></td> 
                                                        </tr>
                                                        <template v-for="(single_locker,lkr) in form.subrooms_list_arr[level]">
                                                            <tr v-if="lkr>=0">
                                                                <td width="10%" scope="row" style="padding-left:1% !important"><strong>{{single_locker.item_name}}</strong></td>
                                                                <td width="">

                                                                    <input v-model="single_locker.system_no" 
                                                                        type="text"
                                                                        name="locker_system_no[]" 
                                                                        placeholder="Auto Generated"  disabled/>
                                                                </td>
                                                                <td width="">

                                                                    <input v-model="single_locker.property_name" 
                                                                        type="text"
                                                                        name="locker_property_name[]" 
                                                                        placeholder="Type Property Name" />
                                                                </td>
                                                                <td width="">
                                                                     {{uom_arr[form.lot_uom]}}
                                                                </td>
                                                                <td width="">
                                                                    <input v-model="single_locker.item_size" 
                                                                        type="number"
                                                                        class="text-center"
                                                                        @keyup="change_locker_size()" 
                                                                        name="locker_size_qty[]" 
                                                                        placeholder="Type Size Qty" /> 
                                                                </td>
                                                                <td  class="form-check-inline" title="Size 1">
                                                                
                                                                    <input type="checkbox" 
                                                                        v-bind:id="'storage_type_'+level+'_'+lkr+'_1'" 
                                                                        name="storage_type_1"
                                                                        @click="check_storage_type_total($event,'storage_type_1',1,lkr,level)"
                                                                        v-model="single_locker.storage_type_1" >
                                                                </td>
                                                                <td  class="form-check-inline" title="Size 2">
                                                                
                                                                    <input type="checkbox" 
                                                                        v-bind:id="'storage_type_'+level+'_'+lkr+'_2'" 
                                                                        name="storage_type_2"
                                                                        @click="check_storage_type_total($event,'storage_type_2',2,lkr,level)"
                                                                        v-model="single_locker.storage_type_2" >
                                                                </td>
                                                                <td  class="form-check-inline" title="Size 3">
                                                                
                                                                    <input type="checkbox" 
                                                                        v-bind:id="'storage_type_'+level+'_'+lkr+'_3'" 
                                                                        name="storage_type_3"
                                                                        @click="check_storage_type_total($event,'storage_type_3',3,lkr,level)"
                                                                        v-model="single_locker.storage_type_3" >
                                                                </td>
                                                                <td  class="form-check-inline" title="Size 4">
                                                                
                                                                    <input type="checkbox" 
                                                                        v-bind:id="'storage_type_'+level+'_'+lkr+'_4'" 
                                                                        name="storage_type_4"
                                                                        @click="check_storage_type_total($event,'storage_type_4',4,lkr,level)"
                                                                        v-model="single_locker.storage_type_4" >
                                                                </td>
                                                                <td  class="form-check-inline" title="Size 5">
                                                                
                                                                    <input type="checkbox" 
                                                                        v-bind:id="'storage_type_'+level+'_'+lkr+'_5'" 
                                                                        name="storage_type_5"
                                                                        @click="check_storage_type_total($event,'storage_type_5',5,lkr,level)"
                                                                        v-model="single_locker.storage_type_5" >
                                                                </td>
                                                                <td  class="form-check-inline" title="Size 6">
                                                                
                                                                    <input type="checkbox" 
                                                                        v-bind:id="'storage_type_'+level+'_'+lkr+'_6'" 
                                                                        name="storage_type_6"
                                                                        @click="check_storage_type_total($event,'storage_type_6',6,lkr,level)"
                                                                        v-model="single_locker.storage_type_6" >
                                                                </td>
                                                                <td  class="form-check-inline" title="Size 7">
                                                                
                                                                    <input type="checkbox" 
                                                                        v-bind:id="'storage_type_'+level+'_'+lkr+'_7'" 
                                                                        name="storage_type_7"
                                                                        @click="check_storage_type_total($event,'storage_type_7',7,lkr,level)"
                                                                        v-model="single_locker.storage_type_7" >
                                                                </td>
                                                                <td  class="form-check-inline" title="Size 8">
                                                                
                                                                    <input type="checkbox" 
                                                                        v-bind:id="'storage_type_'+level+'_'+lkr+'_8'" 
                                                                        name="storage_type_8"
                                                                        @click="check_storage_type_total($event,'storage_type_8',8,lkr,level)"
                                                                        v-model="single_locker.storage_type_8" >
                                                                </td>
                                                                <td>

                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-primary btn-sm" style="line-height:.7 !important" @click="add_locker_details(single_locker.details,level,lkr)">Details</button>

                                                                </td>
                                                            </tr>
                                                        </template>

                                                         <tr style="background-color:rgb(176, 204, 215);color: #000;">
                                                            <td width="10%" scope="row" style=""></td>
                                                            <td width="150">
                                                                
                                                            </td>
                                                            <td width="150">

                                                               
                                                            </td>
                                                            <td width="" align="right">
                                                                 Total
                                                            </td>
                                                            <td width="120" class="text-center">
                                                                 {{form.storage_type_total_arr[level]['total_size']}}
                                                            </td>
                                                            <td v-for="(locker_type,index) in storage_type_arr">
                                                                <strong>{{form.storage_type_total_arr[level][index]}}</strong>
                                                            </td>
                                                            <td >
                                                                <strong>{{form.storage_type_total_arr[level]['total']}}</strong>
                                                            </td>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </template>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td class="text-center">{{form.total_storage_locker_size}}</td>
                                                    <td v-for="(locker_type,index) in storage_type_arr">
                                                        <strong>{{form.storage_lot_total_arr[index]}}</strong>
                                                    </td>
                                                    <td >
                                                        <strong>{{form.storage_lot_total_arr['total']}}</strong>
                                                    </td> 

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
                        <h3><i class="fa fa-hand-point-right"></i> Property Management Type <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property_type()" v-show="!property_type_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property_type()" v-show="property_type_show">Hide</button></h3>
                        <div class="form-holder" v-show="property_type_show">
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
                        <h3><i class="fa fa-hand-point-right"></i> License and Permits <button type="button" class="btn btn-primary btn-sm" @click="show_hide_licency_permit()" v-show="!licence_permit_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_licency_permit()" v-show="licence_permit_show">Hide</button></h3>
                        <div class="form-holder" v-show="licence_permit_show">
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

                    <div class="text-center" v-if="!list_showable">
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Edit</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deleteStorageLot()">Delete</button>
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


            <!--  MOdel  -->
                <div class="modal fade model-middle" id="StorageLockerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content" style="width:800px;overflow-y: initial !important">
                      <div class="modal-header">
                            <h4 ><strong>Is there any following items above or close to this stall ?</strong></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>  
                      </div>
                      <div class="modal-body" style="height: 50vh; overflow-y: auto;">
                        <div class="form-holder">
                            <div class="row align-self-stretch">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-box-outer">
                                       
                                        <table class="table table_narrow">

                                            <thead>
                                                <tr>
                                                    <th scope="col" width="35%" rowspan="2">Particular</th>
                                                    <th scope="col" width="" rowspan="2">Select</th>
                                                    <th scope="col" width="50%" rowspan="2">Comment</th>
                                                    
                                                </tr>
                                                
                                            </thead>
                                            <tbody  style="">
                                                
                                                <template v-for="(locker_details,index) in locker_details_arr" >
                                                    <tr >
                                                        <td width="35%" scope="row" align="left"><strong>{{locker_details.value}}</strong></td>

                                                        <td  class="form-check-inline" >
                                                            <input type="checkbox" 
                                                                name="locker_details_status[]"
                                                                v-model="locker_details.status" >
                                                        </td>
                                                        <td width="50%" v-if="locker_details.status">
                                                            <input v-model="locker_details.comments" 
                                                                type="text"
                                                                class="text-center"
                                                                name="locker_details_comments[]" 
                                                                placeholder="Type Comments" /> 
                                                        </td>
                                                        <td width="50%" v-else>
                                                            <input v-model="locker_details.comments" 
                                                                type="text"
                                                                class="text-center"
                                                                name="locker_details_comments[]" 
                                                                placeholder="Type Comments" disabled /> 
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
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        
                        
                        
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
                    system_no:'',
                    system_prefix:'',
                    lot_number:'',
                    storage_lot_size_qty:0,
                    storage_level:'',
                    storage_locker:'',
                    total_level_size:'',
                    property_name:'',
                    roof_top:false,
            		upper_floor:false,
            		under_ground:false,
            		ground_floor:false,
                    dependent_building:false,
                    independent_building:false,
                    residential:false,
                    commercial:false,
                    residential_commercial:false,
                  
            		lot_uom:1,          		
                    page_id:8,
                  	id:'',


                    floor_name_string:'',
                    floor_type:'',
                    total_storage_lot:'',
                    total_storage_locker_size:0,
                    total_storage_level_size:0,
                    property_management_type_arr:[],
                    license_and_permit_list_arr:[],
                    subrooms_list_arr:[],
                    storage_type_total_arr:[],
                    storage_lot_total_arr:[],
                    
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
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'Lot Number', field: 'lot_number' },
                    { label: 'Lot Size', field: 'storage_lot_size_qty' },
                    { label: 'Action', field: '', sortable: false },
                ],
                rows: [],
                test_collupsable:false,
                general_info_show:true,
                property_show:false,
                property_type_show:false,
                licence_permit_show:false,
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
                storage_type_arr:[],
                locker_details_arr:[],
                details_level:"",
                details_locker:"",
                suite_expression:[],
                storage_type_arr_length:0,
                uom_arr:['','Square Feet','Square Meter','Square Yard'],
                page: 1,
                per_page:15,
                expanded: null
			}
        },
		
		created: function()
        {
            this.user_menu_name = this.$route.name;
            this.fetchStorageLotProfile();
            //this.editStorageLot(4);
           
        },
		
        computed:{


            
        },
	    methods: {
            LockerDetails()
            {
                
               // this.form.subrooms_list_arr[this.details_level][this.details_locker]['details']=this.locker_details_arr;
                $("#StorageLockerModal").modal("hide");
                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove() ;


            },
            add_locker_details(locker_details,level,locker)
            {
                this.locker_details_arr=locker_details;
                this.details_level=level,
                this.details_locker=locker,
                $("#StorageLockerModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show');

            },

            editStorageLot(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/StorageLots/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    

                    this.editmode=true;
                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.building_arr                           =response.data.building_arr;
                    this.form.license_and_permit_list_arr       =response.data.license_and_permit_list_arr;
                    this.form.property_management_type_arr      =response.data.property_management_arr;
                    this.form.safety_item_list_arr              =response.data.safety_item_list_arr;
                    this.form.subrooms_list_arr                 =response.data.subrooms_list_arr;
                    this.external_service_provider_list_arr     =response.data.external_service_provider_list_arr;
                    this.building_contact_list_arr              =response.data.building_contact_list_arr;
                    let safety_device_equipment_arr             =response.data.safety_device_equipment_arr;

                    this.form.id                                =response.data.storage_lot_arr.id;
                    this.form.company_name                      =response.data.storage_lot_arr.company_name;
                    this.form.customer_name                     =response.data.storage_lot_arr.customer_name;
                    this.form.building_name                     =response.data.storage_lot_arr.building_name;
                    
                    this.form.floor_no                          =response.data.storage_lot_arr.floor_no;
                    this.form.system_no                         =response.data.storage_lot_arr.system_no;
                    this.form.system_prefix                     =response.data.storage_lot_arr.system_prefix;
                    this.form.property_name                     =response.data.storage_lot_arr.property_name;
                    this.form.lot_number                        =response.data.storage_lot_arr.lot_number;
                    this.form.lot_uom                           =response.data.storage_lot_arr.lot_uom;
                    this.form.storage_lot_size_qty              =response.data.storage_lot_arr.storage_lot_size_qty;
                    this.form.total_storage_level_size          =response.data.storage_lot_arr.total_storage_level_size;
                    this.form.total_storage_locker_size          =response.data.storage_lot_arr.total_storage_locker_size;

                    this.storage_type_arr                         =response.data.storage_type_arr;
                    this.storage_type_arr_length                  =response.data.storage_type_arr_length;
                    this.form.storage_type_total_arr              =response.data.storage_type_total_arr;
                    this.form.storage_lot_total_arr             =response.data.storage_lot_total_arr;
                    this.form.storage_level                     =response.data.storage_level;
                    this.form.storage_locker                     =response.data.storage_locker;


                    this.floor_arr                              =response.data.floor_arr;
                    this.form.dependent_building                =response.data.building_info[0].dependent_building;
                    this.form.independent_building              =response.data.building_info[0].independent_building;
                    this.form.residential                       =response.data.building_info[0].residential;
                    this.form.commercial                        =response.data.building_info[0].commercial;
                    this.form.residential_commercial            =response.data.building_info[0].residential_commercial;
                  
                    

                    let floor_type=response.data.floor_type;
                    this.form.floor_type=floor_type;

                    this.form.total_storage_lot                 =response.data.total_storage_lot;
                    this.form.floor_name_string                 =response.data.floor_no_string;          

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
                    
                    

                    this.change_locker_size();

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

            change_level_size()
            {
                let total_level_size=0;

                Object.entries(this.form.subrooms_list_arr).forEach(entry => {
                    const [key, level] = entry;
                    
                        var level_size=(level.item_size)*1;
                        total_level_size+=level_size;
                });

                this.form.total_storage_level_size=total_level_size;

            },

            change_locker_size()
            {
                let total_subroom_size=0;

                Object.entries(this.form.subrooms_list_arr).forEach(entry => {
                    const [key, level] = entry;

                    this.form.storage_type_total_arr[key]['total_size']=0;
                    Object.entries(level).forEach(entry => {
                        const [key1, locker] = entry;
                        if(key1>=0)
                        {
                            var locker_size=(locker.item_size)*1;
                            total_subroom_size+=locker_size;
                            this.form.storage_type_total_arr[key]['total_size']+=locker_size;
                        }
                        
                    });

                });

                this.form.total_storage_locker_size=total_subroom_size;
            },

            add_license_permit()
            {
                this.form.license_and_permit_list_arr.push({
                    'id':'',
                    'reference_id':'',
                    'item_name':'',
                    'issued_by':'',
                    'expiry_date':'',
                    'website':'',
                    'mobile':'',
                    'phone':'',
                    'email':'',
                    'comment':'',
                    
                });
            },



            reset_form()
            {

                this.form.reset();
                this.editmode=false;
                this.list_showable=false;
                this.fetchStorageLotProfile();
            },

            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/StorageLotsList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.storage_lot_list;
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
                
                let uri = '/StorageFloorDataByBuilding/'+this.form.building_name;
                window.axios.get(uri).then((response) => {
                    
                    this.floor_arr                              =response.data.floor_arr;
                    this.form.dependent_building                =response.data.building_info[0].dependent_building;
                    this.form.independent_building              =response.data.building_info[0].independent_building;
                    this.form.residential                       =response.data.building_info[0].residential;
                    this.form.commercial                        =response.data.building_info[0].commercial;
                    this.form.residential_commercial            =response.data.building_info[0].residential_commercial;
                });
            },


            check_storage_type_total(e,m_name,index,locker,lavel){
                if(e.target.checked)
                {
                    
                    this.form.subrooms_list_arr[lavel][locker][m_name]=true;
                    this.form.storage_type_total_arr[lavel][index]++;
                    this.form.storage_type_total_arr[lavel]['total']++;

                    this.form.storage_lot_total_arr[index]++;
                    this.form.storage_lot_total_arr['total']++;

                    
                   // alert(this.form.storage_type_total_arr[lavel][index])
                }
                else{
                    this.form.subrooms_list_arr[lavel][locker][m_name]=false;
                    this.form.storage_type_total_arr[lavel][index]--;
                    this.form.storage_type_total_arr[lavel]['total']--;

                    this.form.storage_lot_total_arr[index]--;
                    this.form.storage_lot_total_arr['total']--;
                }

                for(var i=1;i<=this.storage_type_arr_length; i++) 
                {
                    if(index!=i)
                    {

                        var r_name="storage_type_"+i;
                        if(this.form.subrooms_list_arr[lavel][locker][r_name]==true)
                        {
                            $("#storage_type_"+lavel+"_"+locker+"_"+i).prop('checked', false);
                            this.form.subrooms_list_arr[lavel][locker][r_name]=false;
                            this.form.storage_type_total_arr[lavel][i]--;
                            this.form.storage_type_total_arr[lavel]['total']--; 
                            this.form.storage_lot_total_arr[i]--;
                            this.form.storage_lot_total_arr['total']--;
                        }
                    }
                }             
            },

            

            change_floor()
            {
                let floor_type=this.floor_arr[this.form.floor_no].floor_type;
                this.form.floor_type=floor_type;

                this.form.total_storage_lot         =this.floor_arr[this.form.floor_no].total_storage_lot;
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


                this.form.total_storage_locker_size=0;
                let uri = '/loadStorageLotByFloor/'+this.form.floor_no;
                window.axios.get(uri).then((response) => {

                    if(response.data.success==100)
                    {
                        toast({
                        type: 'warning',
                        title: 'This Floor has been Saved Already.Please Select Another One'
                    });
                    return;
                    }
                    this.form.subrooms_list_arr                 =response.data.subrooms_list_arr;
                    this.storage_type_arr                       =response.data.storage_type_arr;
                    this.storage_type_arr_length                =response.data.storage_type_arr_length;
                    this.form.storage_type_total_arr            =response.data.storage_type_total_arr;
                    this.form.storage_lot_total_arr             =response.data.storage_lot_total_arr;
                    this.form.storage_level                     =response.data.storage_level;
                    this.form.storage_locker                    =response.data.storage_locker;


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

            show_hide_property(){
                if(this.property_show)
                {
                    this.property_show=false;
                }
                else{
                    this.property_show=true;
                }
            },
            show_hide_property_type(){
                if(this.property_type_show)
                {
                    this.property_type_show=false;
                }
                else{
                    this.property_type_show=true;
                }
            },


            show_hide_licency_permit(){

                if(this.licence_permit_show)
                {
                    this.licence_permit_show=false;
                }
                else{
                    this.licence_permit_show=true;
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
          


            fetchStorageLotProfile()
            {
                let uri = '/StorageLots';
                window.axios.get(uri).then((response) => {
                    
                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.building_arr                           =response.data.building_arr;
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


            StorageLotDelete(id)
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
                    this.form.delete('/StorageLots/'+id).then(()=>{
                        
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
	
            deleteStorageLot()
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
                    this.form.delete('/StorageLots/'+this.form.id).then(()=>{
                        
                        if(result.value) {
                            Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.fetchStorageLotProfile();
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
            },
      

            updateStoragelot()
            { 
                

		        this.form.put('/StorageLots/'+this.form.id).then(({ data })=>{
					var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        
                        this.editStorageLot(response_data[1]);
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


                

                this.form.post('/StorageLots') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });

                        if(type==1)
                        {
                            this.editStorageLot(response_data[1]);
                            this.editmode=true;
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                            
                        }
                        else if(type==3)
                        {
                            this.form.reset();
                            this.fetchStorageLotProfile();
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