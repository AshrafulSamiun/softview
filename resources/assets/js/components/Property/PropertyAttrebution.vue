<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateParkingLot() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Property Attribution</h1>
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
                                <td>{{ row.main_company_name }}</td>
                                <td>{{ row.sub_company_name }}</td>
                                <td>{{ row.customer_name }}</td>
                                <td>{{ row.building_name }}</td>
                                <td>{{ row.system_no }}</td>
                                <td>{{ row.property_type}}</td>
                                <td>{{ row.property_name }}</td>
                                <td>{{ row.total_property_size_qty }}</td>
                                <td width="120">
                                    <button class="btn btn-primary btn-sm"  @click.prevent="editPropertyAttribution(row.id)">Edit</button>
                                    
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
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<div class="form-box-outer">
    									 <label class="fieldlabels">Master Property ID:</label> 
                                        <input v-model="form.system_no" 
                                            type="text" 
                                            name="system_no" 
                                            placeholder="Auto Generated" 
                                            :class="{ 'is-invalid': form.errors.has('system_no') }" readonly/>
                                        <has-error :form="form" field="unit_no"></has-error>
                                        <label class="fieldlabels">Main- Company:</label>  
                                        <select v-model="form.main_company"
                                            name="main_company"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('main_company') }" readonly>
                                            <option  value="null" v-if="form.main_company===null">--Select Main - Company-- </option>
                                            <option  value="" v-else>--Select Main - Company-- </option>
                                            <option v-for="(main_company,index) in main_company_arr" :value="index" >{{main_company}}</option>
                                        </select>
                                        <has-error :form="form" field="company_name"></has-error>
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
                                            :class="{ 'is-invalid': form.errors.has('customer_name') }">
                                            <option  value="null" v-if="form.customer_name===null">--Select Property Customer-- </option>
                                            <option  value="" v-else>--Select Property Customer-- </option>
                                             <option v-for="(customer,index) in customer_arr" :value="index">{{customer}}</option>
                                        </select>
                                        <has-error :form="form" field="customer_name"></has-error>
                                                                                    
                                    </div>
                                   
                                </div>
                               
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    
                                    <div class="form-box-outer">
                                        
                                        
                                        <h4>Master Property Summery:</h4>
                                        <table class="table table_narrow">
                                            <thead>
                                                <tr>
                                                    <th> Property Name</th>
                                                    <th> Property Size ({{uom_arr[form.global_uom]}})</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td> Residential Suite</td>
                                                    <td align="center">{{form.suite_size_qty.toFixed(2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td> Commercial Unit</td>
                                                    <td align="center">{{form.unit_size_qty.toFixed(2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Supporting & Service Room</td>
                                                    <td align="center">{{form.total_supporting_area.toFixed(2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td> Parking Stall(s)</td>
                                                    <td align="center">{{form.total_parking_stall_size.toFixed(2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Bike Stall(s) </td>
                                                    <td align="center">{{form.total_bike_stall_size.toFixed(2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td> Storage Locker(s)</td>
                                                    <td align="center">{{form.total_storage_locker_size.toFixed(2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mailbox</td>
                                                    <td align="center">{{form.mailbox_size_qty.toFixed(2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Common Area(s)</td>
                                                    <td align="center">{{form.total_common_area.toFixed(2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td> Total</td>
                                                    <td align="center">{{form.total_property_size_qty.toFixed(2)}}</td>
                                                </tr>

                                            </tbody>

                                        </table>
                                        
                                            
                                    </div>
                                </div>
                               
                                <hr>
                            </div>
                        </div>
                    </div>


                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Building Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_building()" v-show="!building_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_building()" v-show="building_show">Hide</button></h3>
                        <div class="form-holder" v-show="building_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="20%" >Building Type</th>
                                                    <th scope="col" width="15%" >Property ID</th>
                                                    <th scope="col" width="15%" >Property Name</th>
                                                    
                                                    <th scope="col" width="15%" >Number Of Floor</th> 
                                                    <th scope="col"  align="center" width="15%">Size Scale
                                                    </th>
                                                    <th scope="col" width="20%" >Size Quantity</th>
                                                </tr>
                                                
                                            </thead>
                                            <tbody >
                                                
                                                <tr align="center">
                                                    <td width="" scope="row" >
                                                        <select v-model="form.building_type"
                                                            name="building_type"
                                                            class="custom-select" 
                                                            @change="change_building_type"
                                                            :class="{ 'is-invalid': form.errors.has('building_type') }">
                                                            
                                                            <option  value="" >--Select Building Type-- </option>
                                                             <option value="1">Residential</option>
                                                             <option value="2">Commercial</option>
                                                             <option value="3">Residential-Commercial</option>
                                                        </select>
                                                    </td>
                                                    <td >
                                                        <select v-model="form.building_id"
                                                            name="building_id"
                                                            class="custom-select" 
                                                            @change="change_building"
                                                            :class="{ 'is-invalid': form.errors.has('building_id') }">
                                                            <option  value="null" v-if="form.building_id===null">--Select Property ID-- </option>
                                                            <option  value="" v-else>--Select Property ID-- </option>
                                                            <option v-for="(building,index) in building_arr" :value="index">{{building.building_no}}</option>
                                                        </select>

                                                    </td>
                                                    <td>{{form.building_name}}</td>
                                                    <td>{{form.number_of_floor}}</td>
                                                    <td>{{uom_arr[form.building_uom]}}</td>
                                                    <td>{{form.building_size_qty.toFixed(2)}}</td>
                                                    
                                                </tr>
                                            </tbody>
                                            
                                        </table> 
                                    </div>
                                </div>                         
                                
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Residential Suite Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_suite()" v-show="!suite_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_suite()" v-show="suite_show">Hide</button></h3>
                        <div class="form-holder" v-show="suite_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="20%" >Residential Suite Type</th>
                                                    <th scope="col" width="15%" >Property ID</th>
                                                    <th scope="col" width="15%" >Property Name</th>
                                                    
                                                    <th scope="col" width="10%" >Floor No</th> 
                                                    <th scope="col" width="10%" >Suite No</th>
                                                    <th scope="col"  align="center" width="15%">Size Scale
                                                    </th>
                                                    <th scope="col" width="15%" >Size Quantity</th>
                                                </tr>
                                                
                                            </thead>
                                            <tbody >

                                                <tr align="center">
                                                    <td width="" scope="row" >
                                                        <select v-model="form.suite_type"
                                                            name="suite_type"
                                                            class="custom-select" 
                                                            @change="change_suite_type"
                                                            :class="{ 'is-invalid': form.errors.has('suite_type') }">
                                                            
                                                            <option  value="" >--Select Suite Type-- </option>
                                                            <option value="1" >Studio</option>
                                                            <option value="" style="background-color:rgb(0,112,196);color:#fff"  disabled>Standard Suites</option>
                                                            <option value="2">&nbsp;&nbsp;&nbsp;One Bedroom</option>
                                                            <option value="3">&nbsp;&nbsp;&nbsp;Two Bedroom</option>
                                                            <option value="4">&nbsp;&nbsp;&nbsp;Three Bedroom</option>
                                                            <option value="5">&nbsp;&nbsp;&nbsp;Four Bedroom</option>
                                                            <option value="6">&nbsp;&nbsp;&nbsp;Five Bedroom</option>
                                                            <option value="7">&nbsp;&nbsp;&nbsp;Six Bedroom</option>
                                                            <option value="8" >Penthouse</option>
                                                        </select>
                                                    </td>
                                                    <td >
                                                        <select v-model="form.suite_id"
                                                            name="suite_id"
                                                            class="custom-select" 
                                                            @change="change_suite"
                                                            :class="{ 'is-invalid': form.errors.has('suite_id') }">
                                                            <option  value="null" v-if="form.suite_id===null">--Select Property ID-- </option>
                                                            <option  value="" v-else>--Select Property ID-- </option>
                                                            <option v-for="(suite,index) in suite_arr" :value="index">{{suite.system_no}}</option>
                                                        </select>

                                                    </td>
                                                    <td>{{form.suite_property_name}}</td>
                                                    <td>{{form.suite_floor_name}}</td>
                                                    <td>{{form.suite_floor_no.toString().padStart(2,"0")}} - {{form.suite_no.toString().padStart(2,"0")}}</td>
                                                    <td>{{uom_arr[form.suite_uom]}}</td>
                                                    <td>{{form.suite_size_qty.toFixed(2)}}</td>
                                                    
                                                    
                                                </tr>
                                                    
                                               
                                                
                                            </tbody>
                                            
                                        </table> 
                                    </div>
                                </div>                         
                                
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Commercial Unit Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_unit()" v-show="!unit_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_unit()" v-show="unit_show">Hide</button></h3>
                        <div class="form-holder" v-show="unit_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="20%" >Commercial Unit Type</th>
                                                    <th scope="col" width="15%" >Property ID</th>
                                                    <th scope="col" width="15%" >Property Name</th>
                                                    
                                                    <th scope="col" width="10%" >Floor No</th> 
                                                    <th scope="col" width="10%" >Unit No</th>
                                                    <th scope="col"  align="center" width="15%">Size Scale
                                                    </th>
                                                    <th scope="col" width="15%" >Size Quantity</th>
                                                </tr>
                                                
                                            </thead>
                                            <tbody >
                                                
                                               

                                                <tr align="center">
                                                    <td width="" scope="row" >
                                                        <select v-model="form.unit_type"
                                                            name="unit_type"
                                                            class="custom-select" 
                                                            @change="change_unit_type"
                                                            :class="{ 'is-invalid': form.errors.has('unit_type') }">
                                                            <option  value="" >--Select Unit Type-- </option>
                                                            <option value="1" >Store</option>
                                                            <option value="2">Office</option>
                                                            
                                                        </select>
                                                    </td>
                                                    <td >
                                                        <select v-model="form.unit_id"
                                                            name="unit_id"
                                                            class="custom-select" 
                                                            @change="change_unit"                                                            
                                                            :class="{ 'is-invalid': form.errors.has('unit_id') }">
                                                            <option  value="null" v-if="form.unit_id===null">--Select Property ID-- </option>
                                                            <option  value="" v-else>--Select Property ID-- </option>
                                                            <option v-for="(unit,index) in unit_arr" :value="index">{{unit.system_no}}</option>
                                                        </select>

                                                    </td>
                                                    <td>{{form.unit_property_name}}</td>
                                                    <td>{{form.unit_floor_name}}</td>
                                                    <td>{{form.unit_floor_no.toString().padStart(2,"0")}} - {{form.unit_no.toString().padStart(2,"0")}}</td>
                                                    <td>{{uom_arr[form.unit_uom]}}</td>
                                                    <td>{{form.unit_size_qty.toFixed(2)}}</td>
                                                    
                                                    
                                                </tr>
                                                    
                                               
                                                
                                            </tbody>
                                            
                                        </table> 
                                    </div>
                                </div>                         
                                
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Supporting & Service Room Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_supporting_room()" v-show="!supporting_room_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_supporting_room()" v-show="supporting_room_show">Hide</button></h3>
                        <div class="form-holder" v-show="supporting_room_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow" >
                                            
                                            <tbody>
                                                
                                                <template v-if="form.total_machanical_room>0">
                                                    <tr style="background-color:rgb(0, 112, 192) !important;color:#fff">
                                                        <td width="5%">Action</td>
                                                        <td scope="col" width="15%">Mechanical Room</td>
                                                        <td scope="col" width="10%">Property ID</td>
                                                        <td scope="col" width="10%">Property Name</td>
                                                        <td scope="col" width="10%">Floor</td>
                                                        <td scope="col" width="10%">Size Scale</td>
                                                        <td scope="col" width="10%">Size Qty </td> 
                                                        <td scope="col" width="10%">Total Allocated Size</td>
                                                        <td scope="col" width="10%">Available Size</td>
                                                        <td scope="col" width="10%">Allocated Size </td>                                        
                                                    </tr>
                                                    <template v-for="(single_subroom,index) in form.service_room_arr" v-if="single_subroom.item_type==7">
                                                                                                          
                                                        <tr>
                                                            <td class="form-check-inline">
                                                                <input type="checkbox" 
                                                                    id="allocated" 
                                                                    name="allocated[]" 
                                                                    @click="check_supporting_room($event,single_subroom)"
                                                                    v-model="single_subroom.allocated" >
                                                                
                                                            </td>
                                                            <td width="15%" scope="row" style="padding-left:2% !important"><strong>{{single_subroom.item_name}}</strong></td>
                                                            <td width="10%">
                                                                {{single_subroom.system_no}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.property_name}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.floor_no}}
                                                            </td>                                                                                <td width="12%">
                                                                {{uom_arr[single_subroom.uom]}}
                                                            </td>            
                                                            <td width="10%">
                                                                {{single_subroom.item_size.toFixed(2)}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.previous_allocated.toFixed(2)}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.available.toFixed(2)}}
                                                            </td>
                                                            <td width="10%" v-if="single_subroom.allocated">
                                                                <input v-model="single_subroom.allocated_size" 
                                                                    type="text" 
                                                                    name="suite_qty[]" 
                                                                    @keyup="change_room_size()"
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="10%" v-else>
                                                                <input v-model="single_subroom.allocated_size" 
                                                                    type="text" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty" disabled/>
                                                            </td>
                                                        </tr>

                                                    </template>                                                   
                                                   
                                                </template>
                                                <template v-if="form.total_administrition_room>0">
                                                    <tr style="background-color:rgb(0, 112, 192) !important;color:#fff">
                                                        <td width="5%">Action</td>
                                                        <td scope="col" width="15%">Administrative Room</td>
                                                        <td scope="col" width="10%">Property ID</td>
                                                        <td scope="col" width="10%">Property Name</td>
                                                        <td scope="col" width="10%">Floor</td>
                                                        <td scope="col" width="10%">Size Scale</td>
                                                        <td scope="col" width="10%">Size Qty </td> 
                                                        <td scope="col" width="10%">Total Allocated Size</td>
                                                        <td scope="col" width="10%">Available Size</td>
                                                        <td scope="col" width="10%">Allocated Size </td>                                        
                                                    </tr>
                                                    <template v-for="(single_subroom,index) in form.service_room_arr" v-if="single_subroom.item_type==8">
                                                        <tr>
                                                            <td class="form-check-inline">
                                                                <input type="checkbox" 
                                                                    id="allocated" 
                                                                    name="allocated[]" 
                                                                    @click="check_supporting_room($event,single_subroom)"
                                                                    v-model="single_subroom.allocated" >
                                                            </td>
                                                            <td width="15%" scope="row" style="padding-left:2% !important"><strong>{{single_subroom.item_name}}</strong></td>
                                                            <td width="10%">
                                                                {{single_subroom.system_no}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.property_name}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.floor_no}}
                                                            </td>                                                                   <td width="10%">
                                                                {{uom_arr[single_subroom.uom]}}
                                                            </td>            
                                                            <td width="10%">
                                                                {{single_subroom.item_size.toFixed(2)}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.previous_allocated.toFixed(2)}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.available.toFixed(2)}}
                                                            </td>
                                                            <td width="10%" v-if="single_subroom.allocated">
                                                                <input v-model="single_subroom.allocated_size" 
                                                                    type="text" 
                                                                    name="suite_qty[]" 
                                                                    @keyup="change_room_size()"
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="10%" v-else>
                                                                <input v-model="single_subroom.allocated_size" 
                                                                    type="text" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty" disabled/>
                                                            </td>
                                                        </tr>

                                                    </template>                                                   
                                                   
                                                </template>

                                                <template v-if="form.total_aminity_room>0">
                                                    <tr style="background-color:rgb(0, 112, 192) !important;color:#fff">
                                                        <td width="5%">Action</td>
                                                        <td scope="col" width="15%">Aminity Room</td>
                                                        <td scope="col" width="10%">Property ID</td>
                                                        <td scope="col" width="10%">Property Name</td>
                                                        <td scope="col" width="10%">Floor</td>
                                                        <td scope="col" width="10%">Size Scale</td>
                                                        <td scope="col" width="10%">Size Qty </td> 
                                                        <td scope="col" width="10%">Total Allocated Size</td>
                                                        <td scope="col" width="10%">Available Size</td>
                                                        <td scope="col" width="10%">Allocated Size </td>                                        
                                                    </tr>
                                                    <template v-for="(single_subroom,index) in form.service_room_arr" v-if="single_subroom.item_type==9">
                                                        
                                                        <tr>
                                                            <td class="form-check-inline">
                                                                <input type="checkbox" 
                                                                    id="allocated" 
                                                                    name="allocated[]" 
                                                                    @click="check_supporting_room($event,single_subroom)"
                                                                    v-model="single_subroom.allocated" >
                                                                
                                                            </td>
                                                            <td width="15%" scope="row" style="padding-left:2% !important"><strong>{{single_subroom.item_name}}</strong></td>
                                                            <td width="10%">
                                                                {{single_subroom.system_no}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.property_name}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.floor_no}}
                                                            </td>
                                                            <td width="10%">
                                                                {{uom_arr[single_subroom.uom]}}
                                                            </td>            
                                                            <td width="10%">
                                                                {{single_subroom.item_size.toFixed(2)}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.previous_allocated.toFixed(2)}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.available.toFixed(2)}}
                                                            </td>
                                                            <td width="10%" v-if="single_subroom.allocated">
                                                                <input v-model="single_subroom.allocated_size" 
                                                                    type="text" 
                                                                    name="suite_qty[]" 
                                                                    @keyup="change_room_size()"
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="10%" v-else>
                                                                <input v-model="single_subroom.allocated_size" 
                                                                    type="text" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty" disabled/>
                                                            </td>
                                                        </tr>

                                                    </template>                                                   
                                                   
                                                </template>

                                                <template v-if="form.total_service_room>0">
                                                    <tr style="background-color:rgb(0, 112, 192) !important;color:#fff">
                                                        <td width="5%">Action</td>
                                                        <td scope="col" width="15%">Service Room</td>
                                                        <td scope="col" width="10%">Property ID</td>
                                                        <td scope="col" width="10%">Property Name</td>
                                                        <td scope="col" width="10%">Floor</td>
                                                        <td scope="col" width="10%">Size Scale</td>
                                                        <td scope="col" width="10%">Size Qty </td> 
                                                        <td scope="col" width="10%">Total Allocated Size</td>
                                                        <td scope="col" width="10%">Available Size</td>
                                                        <td scope="col" width="10%">Allocated Size </td>                                        
                                                    </tr>
                                                    <template v-for="(single_subroom,index) in form.service_room_arr" v-if="single_subroom.item_type==10">
                                                        
                                                        <tr>
                                                            <td class="form-check-inline">
                                                                <input type="checkbox" 
                                                                    id="allocated" 
                                                                    name="allocated[]" 
                                                                    @click="check_supporting_room($event,single_subroom)"
                                                                    v-model="single_subroom.allocated" >
                                                                
                                                            </td>
                                                            <td width="15%" scope="row" style="padding-left:2% !important"><strong>{{single_subroom.item_name}}</strong></td>
                                                            <td width="10%">
                                                                {{single_subroom.system_no}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.property_name}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.floor_no}}
                                                            </td>                                                                   <td width="10%">
                                                                {{uom_arr[single_subroom.uom]}}
                                                            </td>            
                                                            <td width="10%">
                                                                {{single_subroom.item_size.toFixed(2)}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.previous_allocated.toFixed(2)}}
                                                            </td>
                                                            <td width="10%">
                                                                {{single_subroom.available.toFixed(2)}}
                                                            </td>
                                                            <td width="10%" v-if="single_subroom.allocated">
                                                                <input v-model="single_subroom.allocated_size" 
                                                                    type="text" 
                                                                    name="suite_qty[]" 
                                                                    @keyup="change_room_size()"
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                            <td width="10%" v-else>
                                                                <input v-model="single_subroom.allocated_size" 
                                                                    type="text" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty" disabled/>
                                                            </td>
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
                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Parking Lot Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_parking()" v-show="!parking_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_parking()" v-show="parking_show">Hide</button></h3>
                        <div class="form-holder" v-show="parking_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <div class="pull-left" style="margin-top:10px;">
                                            <label for="filter" class="sr-only">Filter</label>
                                            <input type="text" class="form-control" v-model="filter_parking" placeholder="Filter" style="width:400px;">
                                        </div>
                                        <div class="pull-right" style="margin-top:10px;">
                                            <table class="table table-narrow">
                                                <thead>
                                                    <tr>
                                                        <th>Parking Lot</th>
                                                        <th>Allocated Size</th>
                                                        <th>Un Allocated Size</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr v-for="parking_lot in form.parking_lot_arr">
                                                        <td>{{parking_lot.property_name}}</td>
                                                        <td>{{parking_lot.allocated}}</td>
                                                        <td>{{parking_lot.unallocated}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <datatable :columns="parking_columns" :data="form.parking_stall_arr" :filter-by="filter_parking" class="table_narrow">
                                            <template slot-scope="{row}">
                                                <tr>
                                                    <td class="form-check-inline" v-if="row.previous_allocated && row.current_allocated==0">
                                                        <input type="checkbox" 
                                                            id="allocated"
                                                            name="allocated[]" 
                                                            v-model="row.allocated" disabled>
                                                        <label for="allocated"></label><br>

                                                    </td>
                                                    <td class="form-check-inline" v-else>
                                                        <input type="checkbox" 
                                                            id="allocated"
                                                            @click="check_parking_stall($event,row)" 
                                                            name="allocated[]" 
                                                            v-model="row.allocated" >
                                                        <label for="allocated"></label><br>

                                                    </td>
                                                    <td>{{ row.mst_property_name }}</td>
                                                    <td>{{ row.item_name }}</td>
                                                    <td>{{ row.system_no }}</td>
                                                    <td>{{ row.property_name }}</td>
                                                    <td>{{ row.parking_level }}</td>
                                                    <td>{{ row.floor_no }}</td>
                                                    <td>{{row.allocated_string}}</td>
                                                    <td>{{ uom_arr[row.lot_uom] }}</td>
                                                    <td>{{ row.item_size.toFixed(2) }}</td>
                                                    
                                                </tr>
                                            </template>
                                        </datatable>
                                        <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>                
                                    </div>
                                </div>                         
                                
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Bike Lot Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_bike()" v-show="!bike_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_bike()" v-show="bike_show">Hide</button></h3>
                        <div class="form-holder" v-show="bike_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <div class="pull-left" style="margin-top:10px;">
                                            <label for="filter" class="sr-only">Filter</label>
                                            <input type="text" class="form-control" v-model="filter_bike" placeholder="Filter" style="width:400px;">
                                        </div>
                                        <div class="pull-right" style="margin-top:10px;">
                                            <table class="table table-narrow">
                                                <thead>
                                                    <tr>
                                                        <th>Bike Lot</th>
                                                        <th>Allocated Size</th>
                                                        <th>Un Allocated Size</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr v-for="bike_lot in form.bike_lot_arr">
                                                        <td>{{bike_lot.property_name}}</td>
                                                        <td>{{bike_lot.allocated}}</td>
                                                        <td>{{bike_lot.unallocated}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <datatable :columns="bike_columns" :data="form.bike_stall_arr" :filter-by="filter_bike" class="table_narrow">
                                            <template slot-scope="{row}">
                                                <tr>
                                                    <td class="form-check-inline" v-if="row.previous_allocated && row.current_allocated==0">
                                                        <input type="checkbox" 
                                                            id="allocated" 
                                                            name="allocated[]" 
                                                            @click="check_bike_stall($event,row)"
                                                            v-model="row.allocated" disabled>
                                                        <label for="allocated"></label><br>
                                                    </td>
                                                    <td class="form-check-inline" v-else>
                                                        <input type="checkbox" 
                                                            id="allocated" 
                                                            name="allocated[]" 
                                                            @click="check_bike_stall($event,row)"
                                                            v-model="row.allocated" >
                                                        <label for="allocated"></label><br>
                                                    </td>
                                                    <td>{{ row.mst_property_name }}</td>
                                                    <td>{{ row.item_name }}</td>
                                                    <td>{{ row.system_no }}</td>
                                                    <td>{{ row.property_name }}</td>
                                                    <td>{{ row.bike_level }}</td>
                                                    <td>{{ row.floor_no }}</td>
                                                    <td>{{ uom_arr[row.lot_uom] }}</td>
                                                    <td>{{ row.item_size.toFixed(2) }}</td>
                                                    
                                                    
                                                </tr>
                                            </template>
                                        </datatable>
                                        <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>                
                                    </div>
                                </div>                         
                                
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Storage Lot Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_storage()" v-show="!storage_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_storage()" v-show="storage_show">Hide</button></h3>
                        <div class="form-holder" v-show="storage_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <div class="pull-left" style="margin-top:30px;">
                                            <label for="filter" class="sr-only">Filter</label>
                                            <input type="text" class="form-control" v-model="filter_storage" placeholder="Filter" style="width:400px;">
                                        </div>
                                        <div class="pull-right" style="margin-top:5px;">
                                            <table class="table table-narrow">
                                                <thead>
                                                    <tr>
                                                        <th>Bike Lot</th>
                                                        <th>Allocated Size</th>
                                                        <th>Un Allocated Size</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr v-for="storage_lot in form.storage_lot_arr">
                                                        <td>{{storage_lot.property_name}}</td>
                                                        <td>{{storage_lot.allocated}}</td>
                                                        <td>{{storage_lot.unallocated}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <datatable :columns="storage_columns" :data="form.storage_locker_arr" :filter-by="filter_storage" class="table_narrow">
                                            <template slot-scope="{row}">
                                                <tr>
                                                    <td class="form-check-inline" v-if="row.previous_allocated && row.current_allocated==0">
                                                        <input type="checkbox" 
                                                            id="allocated"
                                                            @click="check_storage_locker($event,row)" 
                                                            name="allocated[]" 
                                                            v-model="row.allocated" disabled>
                                                        <label for="allocated"></label><br>

                                                    </td>
                                                    <td class="form-check-inline" v-else>
                                                        <input type="checkbox" 
                                                            id="allocated"
                                                            @click="check_storage_locker($event,row)" 
                                                            name="allocated[]" 
                                                            v-model="row.allocated" >
                                                        <label for="allocated"></label><br>

                                                    </td>
                                                    <td>{{ row.mst_property_name }}</td>
                                                    <td>{{ row.item_name }}</td>
                                                    <td>{{ row.system_no }}</td>
                                                    <td>{{ row.property_name }}</td>
                                                    <td>{{ row.storage_level }}</td>
                                                    <td>{{ row.floor_no }}</td>
                                                    <td>{{ uom_arr[row.lot_uom] }}</td>
                                                    <td>{{ row.item_size.toFixed(2) }}</td>
                                                </tr>
                                            </template>
                                        </datatable>
                                        <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>                
                                    </div>
                                </div>                         
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Mailbox Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_mailroom()" v-show="!mailroom_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_mailroom()" v-show="mailroom_show">Hide</button></h3>
                        <div class="form-holder" v-show="mailroom_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <div class="pull-left" style="margin-top:30px;">
                                            <label for="filter" class="sr-only">Filter</label>
                                            <input type="text" class="form-control" v-model="filter_mailbox" placeholder="Filter" style="width:400px;">
                                        </div>
                                        <div class="pull-right" style="margin-top:5px;">
                                            <table class="table table-narrow">
                                                <thead>
                                                    <tr>
                                                        <th>Mail Room</th>
                                                        <th>Allocated Size</th>
                                                        <th>Un Allocated Size</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr v-for="mail_room in form.mail_room_arr">
                                                        <td>{{mail_room.property_name}}</td>
                                                        <td>{{mail_room.allocated}}</td>
                                                        <td>{{mail_room.unallocated}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <datatable :columns="mail_columns" :data="form.mail_box_arr" :filter-by="filter_mailbox" class="table_narrow">
                                            <template slot-scope="{row}">
                                                <tr>
                                                    <td class="form-check-inline" v-if="row.previous_allocated && row.current_allocated==0">
                                                        <input type="checkbox" 
                                                            id="allocated" 
                                                            @click="check_mail_box($event,row)"
                                                            name="allocated[]" 
                                                            v-model="row.allocated" disabled>
                                                        <label for="allocated"></label><br>

                                                    </td>
                                                    <td class="form-check-inline" v-else>
                                                        <input type="checkbox" 
                                                            id="allocated" 
                                                            @click="check_mail_box($event,row)"
                                                            name="allocated[]" 
                                                            v-model="row.allocated" >
                                                        <label for="allocated"></label><br>

                                                    </td>
                                                    <td>{{ row.mst_property_name }}</td>
                                                    <td>{{ row.item_name }}</td>
                                                    <td>{{ row.system_no }}</td>
                                                    <td>{{ row.property_name }}</td>
                                                    <td>{{ row.floor_no }}</td>
                                                    <td>{{ uom_arr[row.room_uom] }}</td>
                                                    <td>{{ row.item_size.toFixed(2) }}</td>
                                                </tr>
                                            </template>
                                        </datatable>
                                        <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>                
                                    </div>
                                </div>                         
                                
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Common Area Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_common_area()" v-show="!common_area_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_common_area()" v-show="common_area_show">Hide</button></h3>
                        <div class="form-holder" v-show="common_area_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <div class="pull-left" style="margin-top:10px;">
                                            <label for="filter" class="sr-only">Filter</label>
                                            <input type="text" class="form-control" v-model="filter_common_area" placeholder="Filter" style="width:400px;">
                                        </div>
                                        <datatable :columns="common_area_columns" :data="form.common_area_arr" :filter-by="filter_common_area" class="table_narrow">
                                            <template slot-scope="{row}">
                                                <tr>
                                                    <td class="form-check-inline">
                                                        <input type="checkbox" 
                                                            id="allocated" 
                                                            @click="check_common_area($event,row)" 
                                                            name="allocated[]" 
                                                            v-model="row.allocated" >
                                                        <label for="allocated"></label><br>


                                                    </td>
                                                    <td>{{ row.item_name }}</td>
                                                    <td>{{ row.system_no }}</td>
                                                    <td>{{ row.property_name }}</td>
                                                    <td>{{ row.floor_no }}</td>
                                                    <td>{{ uom_arr[row.uom] }}</td>
                                                    <td>{{ row.item_size.toFixed(2) }}</td>
                                                    <td>{{ row.previous_allocated.toFixed(2) }}</td>
                                                    <td>{{ row.available.toFixed(2) }}</td>
                                                    <td width="13%" v-if="row.allocated">
                                                        <input type="text"
                                                            style="width:100%" 
                                                            @keyup="calculate_common_area(row)"
                                                            id="allocated_size" 
                                                            name="allocated_size[]" 
                                                            v-model="row.allocated_size" >
                                                    </td>
                                                    <td width="13%" v-else>
                                                        <input type="text"
                                                            style="width:100%" 
                                                            id="allocated_size" 
                                                            name="allocated_size[]" 
                                                            v-model="row.allocated_size" disabled>
                                                    </td>
                                                </tr>
                                            </template>
                                        </datatable>
                                        <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager> 
                                                      
                                    </div>
                                </div>                         
                                
                                <hr>
                            </div>
                        </div>
                    </div>
                   


                    

                   

                    <div class="text-center" v-if="!list_showable">
                        <table class="table table_narrow" >
                            <tbody>
                                <tr>
                                    <td colspan="5"><strong> Total Size:</strong></td>
                                    <td><strong> {{form.total_property_size_qty.toFixed(2)}}</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Edit</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deletePropertyAttribution()">Delete</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode">Void</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(1)">Save-Stay</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(2)">Save-Out</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(3)">Save-New</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
                    </div>
                </div>
                
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

    .data-table tbody tr {

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
                filter_parking: '',
                filter_bike:'',
                filter_storage:'',
                filter_mailbox:'',
                filter_common_area:'',
            	form:new Form({
                    main_company:'',
                    company_name:'',
                    customer_name:'',
                    building_id:'',
                    building_type:'',
                    building_name:'',
                    building_size_qty:0,
                    number_of_floor:0,
                    building_uom:1,
                    global_uom:'',


                    suite_type:'',
                    suite_id:'',
                    suite_name:'',
                    suite_floor_id:'',
                    suite_floor_no:'',
                    suite_floor_name:'',
                    suite_no:'',
                    suite_uom:1,
                    suite_size_qty:0,

                    unit_type:'',
                    unit_id:'',
                    unit_name:'',
                    unit_floor_id:'',
                    unit_floor_no:'',
                    unit_floor_name:'',
                    unit_no:'',
                    unit_uom:1,
                    unit_size_qty:0,


                    parking_stall_arr:[],
                    parking_lot_arr:[],
                    bike_lot_arr:[],
                    storage_lot_arr:[],

                    bike_stall_arr:[],
                    storage_locker_arr:[],
                    mail_box_arr:[],
                    mail_room_arr:[],
                    common_area_arr:[],
                    service_room_arr:[],

            		floor_no:'',
                    system_no:'',
                    system_prefix:'',
                    lot_number:'',
                    parking_lot_size_qty:0,
                    parking_level:'',
                    parking_stall:'',
                    total_level_size:'',
                    property_name:'',
                   
                  
            		lot_uom:1,          		
                    page_id:6,
                  	id:'',
                    total_machanical_room:0,
                    total_administrition_room:0,
                    total_aminity_room:0,
                    total_service_room:0,
                    total_property_size_qty:0,
                    total_common_area:0,
                    total_supporting_area:0,
                    total_storage_locker_size:0,
                    total_parking_stall_size:0,
                    total_bike_stall_size:0,
                    mailbox_size_qty:0,

                   

            	}),

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Main - Company', field: 'main_company_name' },
                    { label: 'Sub - Company', field: 'sub_company_name' },
                    { label: 'Property Customer', field: 'customer_name' },
                    { label: 'Building Name', field: 'building_name' },
                    { label: 'Master Property ID', field: 'system_no' },
                    { label: 'Property Type', field: 'property_type' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'Property Size', field: 'total_property_size_qty' },
                    { label: 'Action', field: '', sortable: false },
                ],
                rows: [],


                parking_columns: [
                    { label: 'Action', field: '', sortable: false },
                    { label: 'Parking Lot No', field: 'mst_property_name' },
                    { label: 'Stall No', field: 'item_name' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'Level No', field: 'parking_level' },
                    { label: 'Floor No', field: 'floor_no' },
                    { label: 'Status', field: 'allocated_string' },
                    { label: 'Size Scale', field: 'lot_uom' },
                    { label: 'Size Qty', field: 'item_size' },
                ],

                bike_columns: [
                    { label: 'Action', field: '', sortable: false },
                    { label: 'Bike Lot No', field: 'mst_property_name' },
                    { label: 'Stall No', field: 'item_name' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'Level No', field: 'bike_level' },
                    { label: 'Floor No', field: 'floor_no' },
                    { label: 'Size Scale', field: 'lot_uom' },
                    { label: 'Size Qty', field: 'item_size' },
                ],

                storage_columns: [
                    { label: 'Action', field: '', sortable: false },
                    { label: 'Storage Lot No', field: 'mst_property_name' },
                    { label: 'Stall No', field: 'item_name' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'Level No', field: 'storage_level' },
                    { label: 'Floor No', field: 'floor_no' },
                    { label: 'Size Scale', field: 'lot_uom' },
                    { label: 'Size Qty', field: 'item_size' },
                ],

                mail_columns: [
                    { label: 'Action', field: '', sortable: false },
                    { label: 'Mailroom No', field: 'mst_property_name' },
                    { label: 'Mailbox No', field: 'item_name' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'Floor No', field: 'floor_no' },
                    { label: 'Size Scale', field: 'room_uom' },
                    { label: 'Size Qty', field: 'item_size' },
                ],
                common_area_columns: [
                    { label: 'Action', field: '', sortable: false },
                    { label: 'Common Area', field: 'item_name' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'Floor No', field: 'floor_no' },
                    { label: 'Size Scale', field: 'room_uom' },
                    { label: 'Size Qty', field: 'item_size' },
                    { label: 'Total Allocated Size', field: 'previous_allocated' },
                    { label: 'Available Size', field: 'available' },
                    { label: 'Allocated Size', field: 'allocated_size' },
                ],

                supporting_columns: [
                    { label: 'Action', field: '', sortable: false },
                    { label: 'Common Area', field: 'item_name' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'Floor No', field: 'floor_no' },
                    { label: 'Size Scale', field: 'room_uom' },
                    { label: 'Size Qty', field: 'item_size' },
                    { label: 'Total Allocated Size', field: 'previous_allocated' },
                    { label: 'Available Size', field: 'available' },
                    { label: 'Allocated Size', field: 'allocated_size' },
                ],

                test_collupsable:false,
                general_info_show:true,
                building_show:false,
                suite_show:false,
                unit_show:false,
                parking_show:false,
                bike_show:false,
                storage_show:false,
                mailroom_show:false,
                common_area_show:false,
                property_type_show:false,
                supporting_room_show:false,
                
                
            	

                stall_details_arr:[],
                details_level:"",
                details_stall:"",
                main_company_arr:[],
            	company_arr:[],
                customer_arr:[],
                building_arr:[],
                suite_arr:[],
                unit_arr:[],
                floor_arr:[],
                stall_type_arr:[],
                
                suite_expression:[],
                stall_type_arr_length:0,
                uom_arr:['','Square Feet','Square Meter','Square Yard'],
                page: 1,
                per_page:20,
                expanded: null
			}
        },
		
		created: function()
        {
            this.user_menu_name = this.$route.name;
            this.fetchPropertyAttribution();
            //this.editPropertyAttribution(4);
           
        },
		
        computed:{


            
        },
	    methods: {
            fetchPropertyAttribution()
            {
                let uri = '/PropertyAttributions';
                window.axios.get(uri).then((response) => {
                    
                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.main_company_arr                       =response.data.main_company_arr;
                    this.form.main_company                      =response.data.main_company_id;
                    this.form.global_uom                        =response.data.uom_setting;
                    
                }); 
            },



            add_stall_details(stall_details,level,stall)
            {
                this.stall_details_arr=stall_details;
                this.details_level=level,
                this.details_stall=(parseInt(stall)+1).toString();
                $("#ParkingStallModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show');

            },
            editPropertyAttribution(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PropertyAttributions/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    

                    this.editmode=true;
                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.uom_setting                            =response.data.uom_setting;
                    this.floor_arr                              =response.data.floor_arr;
                    this.building_arr                           =response.data.building_arr;

                    this.form.id                                =response.data.master_property_arr.id;
                    this.form.main_company                      =response.data.main_company_id;
                    alert(this.form.main_company)
                    this.main_company_arr                       =response.data.main_company_arr;
                    this.form.company_name                      =response.data.master_property_arr.company_name;
                    this.form.customer_name                     =response.data.master_property_arr.customer_name;
                    //this.form.building_name                     =response.data.master_property_arr.building_id;
                    this.form.building_id                       =response.data.building_details.id;
                    this.form.building_name                     =response.data.building_details.building_name;
                    this.form.number_of_floor                   =response.data.building_details.number_of_floor;
                    this.form.building_uom                      =response.data.building_details.building_uom;
                    this.form.building_size_qty                 =response.data.building_details.total_building_size;
                    this.form.building_type                     =response.data.building_type;






                    this.form.suite_id                          =response.data.master_property_arr.suite_id;
                    this.form.system_no                         =response.data.master_property_arr.system_no;
                    this.form.system_prefix                     =response.data.master_property_arr.system_prefix;
                    this.form.unit_id                           =response.data.master_property_arr.unit_id;
                    this.form.suite_size_qty                    =response.data.master_property_arr.suite_size_qty;
                    this.form.unit_size_qty                     =response.data.master_property_arr.unit_size_qty;
                    this.form.total_supporting_area             =response.data.master_property_arr.total_supporting_area;
                    this.form.total_parking_stall_size          =response.data.master_property_arr.total_parking_stall_size;
                    this.form.total_bike_stall_size             =response.data.master_property_arr.total_bike_stall_size;

                    this.form.total_storage_locker_size         =response.data.master_property_arr.total_storage_locker_size;
                    this.form.mailbox_size_qty                  =response.data.master_property_arr.mailbox_size_qty;
                    this.form.total_common_area                 =response.data.master_property_arr.total_common_area;
                    this.form.total_property_size_qty           =response.data.master_property_arr.total_property_size_qty;

                    this.suite_arr                              =response.data.suite_arr;
                    this.unit_arr                               =response.data.unit_arr;
                    if(this.form.suite_id>0)
                    {
                    
                        this.form.suite_type=response.data.suite_type;
                        this.form.suite_property_name=this.suite_arr[this.form.suite_id].property_name;
                        this.form.suite_no=this.suite_arr[this.form.suite_id].suite_no;
                        this.form.suite_uom=this.suite_arr[this.form.suite_id].suite_uom;
                        this.form.suite_floor_id=this.suite_arr[this.form.suite_id].suite_floor_id;
                        this.form.suite_size_qty=this.suite_arr[this.form.suite_id].total_suite_size;
                        this.form.suite_floor_no=this.suite_arr[this.form.suite_id].suite_floor_no;
                        this.form.suite_floor_name=this.suite_arr[this.form.suite_id].suite_floor_name;
                        this.form.total_property_size_qty+=this.form.suite_size_qty;
                        this.unit_arr=[];
                        this.form.unit_floor_id='';
                        this.form.unit_property_name='';
                        this.form.unit_no='';
                        this.form.unit_uom=1;
                        this.form.unit_size_qty=0;
                        this.form.unit_floor_no='';
                        this.form.unit_floor_name="";
                        this.form.unit_floor_id='';
                   
                    }

                    if(this.form.unit_id>0)
                    {
                        this.form.unit_type=response.data.unit_type;
                        alert(this.form.unit_type)
                        this.form.unit_property_name=this.unit_arr[this.form.unit_id].property_name;
                        this.form.unit_no=this.unit_arr[this.form.unit_id].unit_no;
                        this.form.unit_uom=this.unit_arr[this.form.unit_id].unit_uom;
                        this.form.unit_floor_id=this.unit_arr[this.form.unit_id].unit_floor_id;
                        this.form.unit_size_qty=this.unit_arr[this.form.unit_id].unit_size_qty;
                        this.form.unit_floor_no=this.unit_arr[this.form.unit_id].unit_floor_no;
                        this.form.unit_floor_name=this.unit_arr[this.form.unit_id].unit_floor_name;
                        this.form.total_property_size_qty+=this.form.unit_size_qty;
                        this.suite_arr=[];
                        this.form.suite_floor_id='';
                        this.form.suite_property_name='';
                        this.form.suite_no='';
                        this.form.suite_uom=1;
                        this.form.suite_size_qty=0;
                        this.form.suite_floor_no='';
                        this.form.suite_floor_name="";
                        this.form.suite_floor_id='';
                    }
                    
                    

                    this.form.parking_stall_arr                 =response.data.parking_stall_arr;
                    this.form.bike_stall_arr                    =response.data.bike_stall_arr;
                    this.form.storage_locker_arr                =response.data.storage_locker_arr;
                    this.form.mail_box_arr                      =response.data.mail_box_arr;
                    this.form.common_area_arr                   =response.data.common_area_arr;
                    this.form.service_room_arr                  =response.data.service_room_arr;

                    this.form.total_machanical_room             =response.data.total_machanical_room;
                    this.form.total_administrition_room         =response.data.total_administrition_room;
                    this.form.total_aminity_room                =response.data.total_aminity_room;
                    this.form.total_service_room                =response.data.total_service_room;
                    this.form.parking_lot_arr                   =response.data.parking_lot_arr;
                    this.form.bike_lot_arr                      =response.data.bike_lot_arr;

                    this.form.storage_lot_arr                   =response.data.storage_lot_arr;
                    this.form.mail_room_arr                     =response.data.mail_room_arr;
            
                    
                    

                   // this.change_stall_size();

                  

                }); 

                this.tempeditmode=false;
                
            },

            

            



            reset_form()
            {

                this.form.reset();
                this.editmode=false;
                this.list_showable=false;
                this.fetchPropertyAttribution();
            },

            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/PropertyAttributionsList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.property_attribution_list;
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
                let company=0;
                if(this.form.company_name>0) company=this.form.company_name;
                let uri = '/loadCustomerByCompany/'+company;
                window.axios.get(uri).then((response) => {
                    
                    this.customer_arr                           =response.data.customer_arr;
                   // this.building_arr                           =response.data.building_arr;
                });

                
            },
            

            change_building_type()
            {     
               
                let company=0;
                if(this.form.company_name>0) company=this.form.company_name;
                let customer=0;
                if(this.form.customer_name>0) customer=this.form.customer_name;
                let uri = '/PropertyAttBuilding/'+company+'/'+customer+'/'+this.form.building_type;
                window.axios.get(uri).then((response) => {
                    
                    this.building_arr                               =response.data.building_arr;
                    this.form.building_id='';
                    this.form.building_name='';
                    this.form.building_uom=1;
                    this.form.building_size_qty=0;
                    this.form.number_of_floor=0;
                   
                });
            },

            change_building()
            {
                this.form.building_name=this.building_arr[this.form.building_id].building_name;
                this.form.building_uom=this.building_arr[this.form.building_id].building_uom;
                this.form.building_size_qty=this.building_arr[this.form.building_id].total_building_size;
                this.form.number_of_floor=this.building_arr[this.form.building_id].number_of_floor;

                let uri = '/PropertyByBuilding/'+this.form.building_id;
                window.axios.get(uri).then((response) => {
                    
                    this.form.bike_stall_arr                           =response.data.bike_stall_arr;
                    this.form.storage_locker_arr                       =response.data.storage_locker_arr;
                    this.form.parking_stall_arr                        =response.data.parking_stall_arr;
                    this.form.parking_lot_arr                          =response.data.parking_lot_arr;
                    this.form.bike_lot_arr                             =response.data.bike_lot_arr;
                    this.form.storage_lot_arr                          =response.data.storage_lot_arr;
                    this.form.mail_box_arr                             =response.data.mail_box_arr;
                    this.form.mail_room_arr                            =response.data.mail_room_arr;
                    this.form.common_area_arr                          =response.data.common_area_arr;
                    this.form.service_room_arr                         =response.data.service_room_arr;
                    this.form.total_machanical_room                    =response.data.total_machanical_room;
                    this.form.total_administrition_room                =response.data.total_administrition_room;
                    this.form.total_aminity_room                       =response.data.total_aminity_room;
                    this.form.total_service_room                       =response.data.total_service_room;
                });


            },

            change_suite_type()
            {

                let uri = '/SuiteByBuilding/'+this.form.building_id+'/'+this.form.suite_type;
                window.axios.get(uri).then((response) => {
                    
                    this.suite_arr                              =response.data.suite_arr;

                    this.form.suite_floor_id='';
                    this.form.suite_property_name='';
                    this.form.suite_no='';
                    this.form.suite_uom=1;
                    this.form.suite_size_qty=0;
                    this.form.suite_floor_no='';
                    this.form.suite_floor_name="";
                    this.form.suite_floor_id='';
                   
                });

            },

            change_suite()
            {
                this.form.total_property_size_qty-=this.form.suite_size_qty;
                this.form.suite_property_name=this.suite_arr[this.form.suite_id].property_name;
                this.form.suite_no=this.suite_arr[this.form.suite_id].suite_no;
                this.form.suite_uom=this.suite_arr[this.form.suite_id].suite_uom;
                this.form.suite_floor_id=this.suite_arr[this.form.suite_id].suite_floor_id;
                this.form.suite_size_qty=this.suite_arr[this.form.suite_id].total_suite_size;
                this.form.suite_floor_no=this.suite_arr[this.form.suite_id].suite_floor_no;
                this.form.suite_floor_name=this.suite_arr[this.form.suite_id].suite_floor_name;
                this.form.total_property_size_qty+=this.form.suite_size_qty;
                this.unit_arr=[];
                this.form.total_property_size_qty-=this.form.unit_size_qty;
                this.form.unit_floor_id='';
                this.form.unit_property_name='';
                this.form.unit_no='';
                this.form.unit_uom=1;
                this.form.unit_size_qty=0;
                this.form.unit_floor_no='';
                this.form.unit_floor_name="";
                this.form.unit_floor_id='';

            },


            change_unit_type()
            {

                let uri = '/UnitByBuilding/'+this.form.building_id+'/'+this.form.unit_type;
                window.axios.get(uri).then((response) => {
                    
                    this.unit_arr                              =response.data.unit_arr;

                    this.form.unit_floor_id='';
                    this.form.unit_property_name='';
                    this.form.unit_no='';
                    this.form.unit_uom=1;
                    this.form.unit_size_qty=0;
                    this.form.unit_floor_no='';
                    this.form.unit_floor_name="";
                    this.form.unit_floor_id='';
                   
                });

            },

            change_unit()
            {
                this.form.total_property_size_qty-=this.form.unit_size_qty;
                this.form.unit_property_name=this.unit_arr[this.form.unit_id].property_name;
                this.form.unit_no=this.unit_arr[this.form.unit_id].unit_no;
                this.form.unit_uom=this.unit_arr[this.form.unit_id].unit_uom;
                this.form.unit_floor_id=this.unit_arr[this.form.unit_id].unit_floor_id;
                this.form.unit_size_qty=this.unit_arr[this.form.unit_id].unit_size_qty;
                this.form.unit_floor_no=this.unit_arr[this.form.unit_id].unit_floor_no;
                this.form.unit_floor_name=this.unit_arr[this.form.unit_id].unit_floor_name;
                this.form.total_property_size_qty+=this.form.unit_size_qty;
                this.suite_arr=[];
                this.form.total_property_size_qty-=this.form.suite_size_qty;
                this.form.suite_floor_id='';
                this.form.suite_property_name='';
                this.form.suite_no='';
                this.form.suite_uom=1;
                this.form.suite_size_qty=0;
                this.form.suite_floor_no='';
                this.form.suite_floor_name="";
                this.form.suite_floor_id='';

            },

            check_bike_stall(e,row)
            {
            
                if(e.target.checked)
                {
                    row.allocated=true;
                    this.form.total_property_size_qty+=row.item_size;
                    this.form.total_bike_stall_size+=row.item_size;
                    this.form.bike_lot_arr[row.mst_id]['allocated']+=row.item_size;
                    this.form.bike_lot_arr[row.mst_id]['unallocated']-=row.item_size;
                }
                else
                {
                    row.allocated=false;
                    this.form.total_property_size_qty-=row.item_size;
                    this.form.total_bike_stall_size-=row.item_size;
                    this.form.bike_lot_arr[row.mst_id]['unallocated']+=row.item_size;
                    this.form.bike_lot_arr[row.mst_id]['allocated']-=row.item_size;
                }
            },

            check_parking_stall(e,row)
            {
            
                if(e.target.checked)
                {
                    row.allocated=true;
                    this.form.total_property_size_qty+=row.item_size;
                    this.form.total_parking_stall_size+=row.item_size;
                    this.form.parking_lot_arr[row.mst_id]['allocated']+=row.item_size;
                    this.form.parking_lot_arr[row.mst_id]['unallocated']-=row.item_size;
                }
                else
                {
                    row.allocated=false;
                    this.form.total_property_size_qty-=row.item_size;
                    this.form.total_parking_stall_size-=row.item_size;
                    this.form.parking_lot_arr[row.mst_id]['unallocated']+=row.item_size;
                    this.form.parking_lot_arr[row.mst_id]['allocated']-=row.item_size;
                }

            },

            check_storage_locker(e,row)
            {
            
                if(e.target.checked)
                {
                    row.allocated=true;
                    this.form.total_property_size_qty+=row.item_size;
                    this.form.total_storage_locker_size+=row.item_size;
                    this.form.storage_lot_arr[row.mst_id]['allocated']+=row.item_size;
                    this.form.storage_lot_arr[row.mst_id]['unallocated']-=row.item_size;
                }
                else
                {
                    row.allocated=false;
                    this.form.total_property_size_qty-=row.item_size;
                    this.form.total_storage_locker_size-=row.item_size;
                    this.form.storage_lot_arr[row.mst_id]['unallocated']+=row.item_size;
                    this.form.storage_lot_arr[row.mst_id]['allocated']-=row.item_size;
                }

            },

            check_common_area(e,row)
            {
            
                if(e.target.checked)
                {
                    row.allocated=true;
                    //this.form.total_property_size_qty+=row.item_size;
                }
                else
                {
                    row.allocated=false;
                    alert(row.allocated_size)
                    if(row.allocated_size)
                    {
                        this.form.total_property_size_qty-=row.allocated_size*1;
                        this.form.total_common_area-=row.allocated_size*1;
                        row.previous_allocated=row.actual_allocated*1;
                        row.available=row.available_actual*1;
                        row.allocated_size='';
                    }
                }

            },
            calculate_common_area(row)
            {

                const self = this;
                var total_common_area=0;

                
                this.form.total_property_size_qty-=this.form.total_common_area;
                this.form.common_area_arr.forEach(function(item,index){
                    
                    if(item.allocated==true)
                    {
                        if(item.allocated_size*1<=item.available_actual){
                            total_common_area+=item.allocated_size*1;
                            item.previous_allocated=item.actual_allocated+item.allocated_size*1;
                            item.available=item.available_actual-item.allocated_size*1;
                        }
                        else
                        {

                            Swal("failed!","Allocated Size Must be Less than or Equal to Available Size.","warning");
                            self.form.total_common_area=self.form.total_common_area-item.previous_allocated*1+item.actual_allocated*1;
                            item.previous_allocated=item.actual_allocated*1;
                            item.available=item.available_actual*1;
                            item.allocated_size='';
                        }
                    }
                    
                });
            
                
                this.form.total_property_size_qty+=total_common_area;
                this.form.total_common_area=total_common_area;
                
            },

            check_supporting_room(e,row)
            {
            
                if(e.target.checked)
                {
                    row.allocated=true;
                }
                else
                {
                    row.allocated=false;
                    if(row.allocated_size)
                    {
                        this.form.total_property_size_qty-=row.allocated_size*1;
                        this.form.total_supporting_area-=row.allocated_size*1;
                        row.previous_allocated=row.actual_allocated*1;
                        row.available=row.available_actual*1;
                        row.allocated_size='';
                    }
                }

            },
            change_room_size()
            {

                const self = this;
                var total_supporting_area=0;
                
                this.form.total_property_size_qty-=this.form.total_supporting_area;
                this.form.service_room_arr.forEach(function(item,index){
                    
                    if(item.allocated==true)
                    {
                        if(item.allocated_size*1<=item.available_actual){
                            total_supporting_area+=item.allocated_size*1;
                            item.previous_allocated=item.actual_allocated+item.allocated_size*1;
                            item.available=item.available_actual-item.allocated_size*1;
                        }
                        else
                        {
                            Swal("failed!","Allocated Size Must be Less than or Equal to Available Size.","warning");
                            self.form.total_supporting_area=self.form.total_supporting_area-item.previous_allocated*1+item.actual_allocated*1;
                            item.previous_allocated=item.actual_allocated*1;
                            item.available=item.available_actual*1;
                            item.allocated_size='';
                        }

                       // total_supporting_area+=item.allocated_size*1;
                    }
                });
            
                
                this.form.total_property_size_qty+=total_supporting_area;
                this.form.total_supporting_area=total_supporting_area;
                
            },


            check_mail_box(e,row)
            {
            
                if(e.target.checked)
                {
                    row.allocated=true;
                    this.form.total_property_size_qty+=row.item_size;
                    this.form.mailbox_size_qty=row.item_size;
                    this.form.mail_room_arr[row.mst_id]['allocated']+=row.item_size;
                    this.form.mail_room_arr[row.mst_id]['unallocated']-=row.item_size;
                }
                else
                {
                    row.allocated=false;
                    this.form.total_property_size_qty-=row.item_size;
                    this.form.mailbox_size_qty=0;
                    this.form.mail_room_arr[row.mst_id]['allocated']-=row.item_size;
                    this.form.mail_room_arr[row.mst_id]['unallocated']+=row.item_size;
                }
                const self = this;
                this.form.mail_box_arr.forEach(function(item,index){

                    if(item.id!=row.id)
                    {
                        if(item.allocated==true && item.previous_allocated==0)
                        {
                            item.allocated=false;
                            self.form.total_property_size_qty-=item.item_size;
                            self.form.mail_room_arr[item.mst_id]['allocated']-=item.item_size;
                            self.form.mail_room_arr[item.mst_id]['unallocated']+=item.item_size;
                        }
                        else if(item.allocated==true && item.previous_allocated==true && item.current_allocated==true)
                        {
                            item.allocated=false;
                            self.form.total_property_size_qty-=item.item_size;
                            self.form.mail_room_arr[item.mst_id]['allocated']-=item.item_size;
                            self.form.mail_room_arr[item.mst_id]['unallocated']+=item.item_size;
                        } 
                    }

                });

            },


                        

            
            show_hide_building(){
                if(this.building_show)
                {
                    this.building_show=false;
                }
                else{
                    this.building_show=true;
                }

            },

            show_hide_suite(){
                if(this.suite_show)
                {
                    this.suite_show=false;
                }
                else{
                    this.suite_show=true;
                }
                
            },

            show_hide_unit(){
                if(this.unit_show)
                {
                    this.unit_show=false;
                }
                else{
                    this.unit_show=true;
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

            show_hide_parking(){
                if(this.parking_show)
                {
                    this.parking_show=false;
                }
                else{
                    this.parking_show=true;
                }
                
            },

            show_hide_bike(){
                if(this.bike_show)
                {
                    this.bike_show=false;
                }
                else{
                    this.bike_show=true;
                }
                
            },

            show_hide_storage(){
                if(this.storage_show)
                {
                    this.storage_show=false;
                }
                else{
                    this.storage_show=true;
                }
                
            },

            show_hide_mailroom(){
                if(this.mailroom_show)
                {
                    this.mailroom_show=false;
                }
                else{
                    this.mailroom_show=true;
                }
                
            },

            show_hide_common_area(){
                if(this.common_area_show)
                {
                    this.common_area_show=false;
                }
                else{
                    this.common_area_show=true;
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

            show_hide_supporting_room(){
                if(this.supporting_room_show)
                {
                    this.supporting_room_show=false;
                }
                else{
                    this.supporting_room_show=true;
                }
                
            },

            

            

           
          


           


            ParkingLotDelete(id)
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
                    this.form.delete('/PropertyAttributions/'+id).then(()=>{
                        
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
	
            deletePropertyAttribution()
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
                    this.form.delete('/PropertyAttributions/'+this.form.id).then(()=>{
                        
                        if(result.value) {
                            Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.fetchPropertyAttribution();
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
            },
      

            updateParkingLot()
            { 
                

		        this.form.put('/PropertyAttributions/'+this.form.id).then(({ data })=>{
					var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        
                        this.editPropertyAttribution(response_data[1]);
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

                this.form.post('/PropertyAttributions') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });

                        if(type==1)
                        {
                            this.editPropertyAttribution(response_data[1]);
                            this.editmode=true;
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                            
                        }
                        else if(type==3)
                        {
                            this.form.reset();
                            this.fetchPropertyAttribution();
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