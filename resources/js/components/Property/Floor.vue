<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateFloorInfo() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Floor Information</h1>
                <div class="text-center">

                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_list()">List</button>

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
                                <td>{{ row.building_name }}</td>
                                <td>{{ row.system_no }}</td>
                                <td>{{ row.floor_name }}</td>
                                <td width="120">
                                    <button class="btn btn-primary btn-sm"  @click.prevent="editFloor(row.id)">Edit</button>
                                    <button  class="btn btn-danger btn-sm" @click.prevent="FloorDelete(row.id)">Delete</button>
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
                                                <label class="fieldlabels">Strata lot No:</label> 
                                                <input v-model="form.strata_lot_no" 
                                                    type="text" 
                                                    name="strata_lot_no" 
                                                    placeholder="Type Building Name" 
                                                    :class="{ 'is-invalid': form.errors.has('strata_lot_no') }"/>
                                                     <has-error :form="form" field="strata_lot_no"></has-error> 
                                                     <div v-if="form.errors.has('strata_lot_no')" v-html="form.errors.get('strata_lot_no')" />
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
                                                <label class="fieldlabels">Property ID:</label> 
                                                <input v-model="form.system_no" 
                                                    type="text" 
                                                    name="system_no" 
                                                    placeholder="Type Floor Name" 
                                                    :class="{ 'is-invalid': form.errors.has('system_no') }" disabled/>
                                                <has-error :form="form" field="system_no"></has-error> 
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="fieldlabels">Property Name:</label> 
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

                                                            <button type="button" class="btn btn-primary btn-sm" v-show="!property_expression[1].collupseble" @click="collupsable_property(1)" >Show </button>

                                                            <button type="button" class="btn btn-primary btn-sm" v-show="property_expression[1].collupseble"  @click="collupsable_property(1)" >Hide</button> 
                                                        </td>
                                                        <td width="" align="right"><h4>{{form.total_suite}}</h4></td>
                                                    </tr>
                                                    <template v-for="(single_suite,index) in form.subrooms_list_details_arr[1]" >
                                                        <tr v-show="property_expression[1].collupseble" style="background-color: rgba(121, 137, 175, 0.15)">
                                                            <td width="" scope="row" style="padding-left:10% !important;"><h5><strong>Residential Suite No {{form.floor_name_string}}-{{index.padStart(2,"0")}}</strong></h5></td>
                                                            <td class="form-check-inline">
                                                                 <input type="checkbox" 
                                                                    :id="'suite_no_'+index" 
                                                                    name="suite_no[]"
                                                                     @click="populate_data_all_suite(1,index)" 
                                                                    v-model="suite_expression[index-1].copy">
                                                                <label :for="'suite_no_'+index" >Copy All</label>
                                                            </td>
                                                            <td width="">
                                                                <button type="button" class="btn btn-primary btn-sm" v-show="!suite_expression[index-1].collupseble" @click="collupsable_suite(1,index)" >Show </button>

                                                                <button type="button" class="btn btn-primary btn-sm" v-show="suite_expression[index-1].collupseble"  @click="collupsable_suite(1,index)" >Hide</button>
                                                            </td>
                                                        </tr>
                                                        <tr v-show="suite_expression[index-1].collupseble && property_expression[1].collupseble" style="background-color: rgba(135, 165, 235, 0.15);">
                                                            <td width="" scope="row" style="padding-left:20% !important;"><h6><strong>Subrooms</strong></h6></td>
                                                            <td width=""></td>
                                                            <td width=""></td>
                                                        </tr>
                                                        
                                                        <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[1][index]" >
                                                            <tr v-show="suite_expression[index-1].collupseble && property_expression[1].collupseble">
                                                                <td width="60%" scope="row" style="padding-left:30% !important"><strong>{{subroom.item_name}}</strong></td>
                                                                <td width="20%">
                                                                    <input v-model="subroom.item_qty" 
                                                                        type="number" 
                                                                        name="suite_qty[]" 
                                                                        @keyup="change_property_qty(1,index,subroom_id)" 
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
                                                             <button type="button" class="btn btn-primary btn-sm" v-show="!property_expression[2].collupseble" @click="collupsable_property(2)" >Show </button>

                                                            <button type="button" class="btn btn-primary btn-sm" v-show="property_expression[2].collupseble"  @click="collupsable_property(2)" >Hide</button> 
                                                        </td>
                                                        <td align="right"><h4>{{form.total_unit}}</h4></td>
                                                    </tr>
                                                    <template v-for="(single_suite,index) in form.subrooms_list_details_arr[2]">
                                                        <tr v-show="property_expression[2].collupseble" style="background-color: rgba(121, 137, 175, 0.15)">
                                                            <td width="" scope="row" style="padding-left:10% !important;"><h5><strong>Commercial Unit No {{form.floor_name_string}}-{{index.padStart(2,"0")}}</strong></h5></td>
                                                            
                                                            <td class="form-check-inline">
                                                                 <input type="checkbox" 
                                                                    :id="'unit_no_'+index" 
                                                                    name="unit_no[]"
                                                                     @click="populate_data_all_suite(2,index)" 
                                                                    v-model="unit_expression[index-1].copy">
                                                                <label :for="'unit_no_'+index" >Copy All</label>
                                                            </td>
                                                            
                                                            <td width="">
                                                                <button type="button" class="btn btn-primary btn-sm" v-show="!unit_expression[index-1].collupseble" @click="collupsable_unit(1,index)" >Show </button>

                                                                <button type="button" class="btn btn-primary btn-sm" v-show="unit_expression[index-1].collupseble"  @click="collupsable_unit(1,index)" >Hide</button>
                                                            </td>
                                                        </tr>
                                                        <tr v-show="unit_expression[index-1].collupseble && property_expression[2].collupseble" style="background-color: rgba(135, 165, 235, 0.15);">
                                                            <td width="" scope="row" style="padding-left:20% !important;"><h6><strong>Subrooms</strong></h6></td>
                                                            <td width=""></td>
                                                            <td width=""></td>
                                                        </tr>
                                                        
                                                        <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[2][index]" >
                                                            <tr v-show="unit_expression[index-1].collupseble && property_expression[2].collupseble">
                                                                <td width="60%" scope="row" style="padding-left:30% !important"><strong>{{subroom.item_name}}</strong></td>
                                                                <td width="20%">
                                                                    <input v-model="subroom.item_qty" 
                                                                        type="number" 
                                                                        name="suite_qty[]" 
                                                                        @keyup="change_property_qty(2,index,subroom_id)" 
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
                                                            <button type="button" class="btn btn-primary btn-sm" v-show="!property_expression[7].collupseble" @click="collupsable_property(7)" >Show </button>

                                                            <button type="button" class="btn btn-primary btn-sm" v-show="property_expression[7].collupseble"  @click="collupsable_property(7)" >Hide</button>
                                                        </td>
                                                        <td align="right"><h4>{{form.total_mechanical_room}}</h4></td>
                                                    </tr>
                                                    
                                                        <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[7]" >
                                                            <tr v-show="property_expression[7].collupseble">
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
                                                            <button type="button" class="btn btn-primary btn-sm" v-show="!property_expression[8].collupseble" @click="collupsable_property(8)" >Show </button>

                                                            <button type="button" class="btn btn-primary btn-sm" v-show="property_expression[8].collupseble"  @click="collupsable_property(8)" >Hide</button> 
                                                        </td>
                                                        <td align="right"><h4>{{form.total_administrative_room}}</h4></td>
                                                    </tr>
                                                    
                                                        <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[8]" >
                                                            <tr v-show="property_expression[8].collupseble">
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
                                                         <button type="button" class="btn btn-primary btn-sm" v-show="!property_expression[9].collupseble" @click="collupsable_property(9)" >Show </button>

                                                            <button type="button" class="btn btn-primary btn-sm" v-show="property_expression[9].collupseble"  @click="collupsable_property(9)" >Hide</button> 
                                                        </td>
                                                        <td align="right"><h4>{{form.total_amenity_room}}</h4></td>
                                                    </tr>
                                                    
                                                    <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[9]">
                                                        <tr v-show="property_expression[9].collupseble">
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
                                                            <button type="button" class="btn btn-primary btn-sm" v-show="!property_expression[10].collupseble" @click="collupsable_property(10)" >Show </button>

                                                            <button type="button" class="btn btn-primary btn-sm" v-show="property_expression[10].collupseble"  @click="collupsable_property(10)" >Hide</button> 
                                                        </td>
                                                        <td align="right"><h4>{{form.total_service_room}}</h4></td>
                                                    </tr>
                                                    
                                                    <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[10]" >
                                                        <tr v-show="property_expression[10].collupseble">
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
                                                            <button type="button" class="btn btn-primary btn-sm" v-show="!property_expression[3].collupseble" @click="collupsable_property(3)" >Show </button>

                                                            <button type="button" class="btn btn-primary btn-sm" v-show="property_expression[3].collupseble"  @click="collupsable_property(3)" >Hide</button> 
                                                        </td>
                                                        <td align="right"><h4>{{form.total_parking_lot}}</h4></td>
                                                    </tr>
                                                    <template v-for="(single_parking_lot,parking_index) in form.subrooms_list_details_arr[3]">

                                                        <tr v-show="property_expression[3].collupseble" style="background-color: rgba(121, 137, 175, 0.15)">
                                                            <td width="" scope="row" style="padding-left:10% !important;"><h5><strong>Parking Level {{form.floor_name_string}}-{{parking_index.padStart(2,"0")}}</strong></h5></td>
                                                            <td width=""></td>
                                                            <td width=""></td>
                                                        </tr>
                                                        
                                                        
                                                        <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[3][parking_index]">
                                                            <tr v-show="property_expression[3].collupseble">
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
                                                            <button type="button" class="btn btn-primary btn-sm" v-show="!property_expression[4].collupseble" @click="collupsable_property(4)" >Show </button>

                                                            <button type="button" class="btn btn-primary btn-sm" v-show="property_expression[4].collupseble"  @click="collupsable_property(4)" >Hide</button> 
                                                        </td>
                                                        <td align="right"><h4>{{form.total_bike_lot}}</h4></td>
                                                    </tr>
                                                    <template v-for="(single_bike_lot,bike_index) in form.subrooms_list_details_arr[4]">

                                                        <tr v-show="property_expression[4].collupseble" style="background-color: rgba(121, 137, 175, 0.15)">
                                                            <td width="" scope="row" style="padding-left:10% !important;"><h5><strong>Bike Level {{form.floor_name_string}}-{{bike_index.padStart(2,"0")}}</strong></h5></td>
                                                            <td width=""></td>
                                                            <td width=""></td>
                                                        </tr>
                                                        
                                                        <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[4][bike_index]" >
                                                            <tr v-show="property_expression[4].collupseble">
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
                                                            <button type="button" class="btn btn-primary btn-sm" v-show="!property_expression[5].collupseble" @click="collupsable_property(5)" >Show </button>

                                                            <button type="button" class="btn btn-primary btn-sm" v-show="property_expression[5].collupseble"  @click="collupsable_property(5)" >Hide</button> 
                                                        </td>
                                                        <td width="" align="right"><h4>{{form.total_storage_lot}}</h4></td>
                                                    </tr>
                                                    <template v-for="(single_storage_lot,storage_index) in form.subrooms_list_details_arr[5]">

                                                        <tr v-show="property_expression[5].collupseble" style="background-color: rgba(121, 137, 175, 0.15)">
                                                            <td width="" scope="row" style="padding-left:10% !important;"><h5><strong>Storage Lot {{form.floor_name_string}}-{{storage_index.padStart(2,"0")}}</strong></h5></td>
                                                            <td width=""></td>
                                                            <td width=""></td>
                                                        </tr>
                                                        
                                                        <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[5][storage_index]" >
                                                            <tr v-show="property_expression[5].collupseble">
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
                                                        <td width="">
                                                            <button type="button" class="btn btn-primary btn-sm" v-show="!property_expression[6].collupseble" @click="collupsable_property(6)" >Show </button>

                                                            <button type="button" class="btn btn-primary btn-sm" v-show="property_expression[6].collupseble"  @click="collupsable_property(6)" >Hide</button>
                                                        </td>
                                                        <td width="" align="right"><h4>{{form.total_mailroom}}</h4></td>
                                                    </tr>
                                                    <template v-for="(single_mailroom,mailroom_index) in form.subrooms_list_details_arr[6]">

                                                        <tr v-show="property_expression[6].collupseble" style="background-color: rgba(121, 137, 175, 0.15)">
                                                            <td width="" scope="row" style="padding-left:10% !important;"><h5><strong>Mail Room {{form.floor_name_string}}-{{mailroom_index.padStart(2,"0")}}</strong></h5></td>
                                                            <td width=""></td>
                                                            <td width=""></td>
                                                        </tr>
                                                        
                                                        <template v-for="(subroom,subroom_id) in single_mailroom" >
                                                            <tr v-show="property_expression[6].collupseble">
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
                                                            <button type="button" class="btn btn-primary btn-sm" v-show="!property_expression[11].collupseble" @click="collupsable_property(11)" >Show </button>

                                                            <button type="button" class="btn btn-primary btn-sm" v-show="property_expression[11].collupseble"  @click="collupsable_property(11)" >Hide</button> 
                                                        </td>
                                                        <td width="" align="right"><h4>{{form.total_common_area}}</h4></td>
                                                    </tr>
                                                    
                                                    <template v-for="(subroom,subroom_id) in form.subrooms_list_details_arr[11]" >
                                                        <tr v-show="property_expression[11].collupseble">
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
                    

                    <div class="text-center" v-if="!list_showable">
                        <button :disabled="form.busy || editmode==false"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                      
                        <button :disabled="form.busy || editmode==true || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="save_stay(1)">Save-Stay</button>
                        <button :disabled="form.busy || editmode==true || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px"  @click="save_stay(2)">Save-Out</button>
                        <button :disabled="form.busy || editmode==true || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px"  @click="save_stay(3)">Save-New</button>
                        <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px" >Update</button>
                        <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click.prevent="deleteFloor()">Delete</button>


                         <button :disabled="form.busy || editmode==false || form.posting_status>1"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()" v-if="user_type==9">Post {{form.posting_status}}</button>
                        <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()" v-else>Post</button>

                        <button :disabled="form.busy || form.posting_status<2 || user_type!=9"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="adjust()">Adjust</button>

                        <button :disabled="form.busy || form.posting_status!=3 || user_type!=9"  type="button" class="btn  btn-primary" style="min-width:110px" @click="repost()">RePost</button>
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

</style>

<script>
	import {ref} from "vue";
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
                list_showable:false,
				filter: '',
            	form:new Form({
                    company_name:'',
                    customer_name:'',
                    building_name:'',
            		floor_no:'',
                    floor_name:'',
                    system_no:'',
                    roof_top:false,
            		upper_floor:false,
            		under_ground:false,
            		ground_floor:false,
            		           		
                    page_id:2,
                  	id:'',
                    strata_lot_no:'',
                    posting_status:0,

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

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Building Name', field: 'building_name' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'floor_name' },
                    { label: 'Action', field: '', sortable: false },
                ],
                rows: [],
                test_collupsable:false,
                property_show:false,
                general_info_show:true,
                safety_equipment_show:false,
            	account_disable:true,
            	account_no:'',
                user_type:'',
                customer_arr:[],
                building_arr:[],
                floor_arr:[],
                suite_expression:[],
                unit_expression:[],
                property_expression:[],
                page: 1,
                per_page:15,
                expanded: null

      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchFloorProfile();
            //this.editFloor(11);
           
        },
		
        computed:{


            
        },
	    methods: {


            editFloor(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/Floors/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    

                    this.editmode=true;
                    this.user_type                              =response.data.user_type;
                    this.form.strata_lot_no                     =response.data.floor_list_arr.strata_lot_no;
                    this.form.posting_status                    =response.data.floor_list_arr.posting_status;
                    this.building_arr                           =response.data.building_arr;
                    this.form.safety_item_list_arr              =response.data.safety_item_list_arr;
                    this.form.subrooms_list_arr                 =response.data.subrooms_list_arr;
                    this.form.subrooms_list_details_arr         =response.data.subrooms_list_details_arr;
                    let safety_device_equipment_arr             =response.data.safety_device_equipment_arr;

                    this.form.id                                =response.data.floor_list_arr.id;
                    this.form.company_name                      =response.data.floor_list_arr.company_name;
                    this.form.customer_name                     =response.data.floor_list_arr.customer_name;
                    this.form.building_name                     =response.data.floor_list_arr.building_name;
                    
                    this.form.floor_no                          =response.data.floor_list_arr.floor_no;
                    this.form.floor_name                        =response.data.floor_list_arr.floor_name;
                    this.form.system_no                         =response.data.floor_list_arr.system_no;
                    this.floor_arr                              =response.data.floor_arr;

                  
                 

                    let floor_type=response.data.floor_type;
                    this.form.floor_type=floor_type;

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

                    for(let ksk=0;ksk<12;ksk++)
                    {
                        this.property_expression.push({
                            'collupseble':false,
                            'copy':false,
                        });

                    }
                    if(this.form.total_suite>0)
                    {
                        for(let i=1;i<=this.form.total_suite;i++){
                            this.suite_expression.push({
                                'collupseble':false,
                                'copy':false,
                            });

                        }
                    }

                    if(this.form.total_unit>0)
                    {
                        for(let i=1;i<=this.form.total_unit;i++){

                            this.unit_expression.push({
                                'collupseble':false,
                                'copy':false,
                            });
                        }
                    }

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
                    
                    

                }); 

                this.tempeditmode=false;
                
            },


            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/FloorLists';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.Floor_list;
                });
                this.list_showable=true;
            },

            reset_form()
            {

                this.form.reset();
                this.editmode=false;
                this.list_showable=false;
            },
           

            change_building()
            {
                this.floor_arr=[];
                
                let uri = '/loadFloorByBuilding/'+this.form.building_name;
                window.axios.get(uri).then((response) => {
                    
                    this.floor_arr                           =response.data.floor_arr;
                });
                
            },

            populate_data_all_suite(type,index)
            {

                if(type==1)
                {
                    if(this.suite_expression[index-1].copy==false) this.suite_expression[index-1].copy=true;
                    else
                    {
                        this.suite_expression[index-1].copy=false;
                         return;
                    }
                       
                }

                if(type==2)
                {
                    if(this.unit_expression[index-1].copy==false) this.unit_expression[index-1].copy=true;
                    else
                    {
                        this.unit_expression[index-1].copy=false;
                         return;
                    }
                }

                for(let j=0;j<this.form.subrooms_list_arr.length;j++)
                {

                    if(this.form.subrooms_list_arr[j].item_type==type)
                    {
                        let item_qty=this.form.subrooms_list_details_arr[type][index][j].item_qty;
                        if(type==1)
                        {
                            for(let i=1;i<=this.form.total_suite;i++){

                                if(i!=index) this.form.subrooms_list_details_arr[type][i][j].item_qty=item_qty;

                            }

                        }
                        else if(type==2){

                            for(let i=1;i<=this.form.total_unit;i++){

                                if(i!=index) this.form.subrooms_list_details_arr[type][i][j].item_qty=item_qty;

                            }
                        }
                        
                    }
                }

            },

            change_property_qty(type,index,subroom_id)
            {

                let item_qty=this.form.subrooms_list_details_arr[type][index][subroom_id].item_qty;
                if(type==1)
                {
                    if(this.suite_expression[index-1].copy==false)  return;  
                    else
                    {
                        for(let i=1;i<=this.form.total_suite;i++){
                            if(i!=index) this.form.subrooms_list_details_arr[type][i][subroom_id].item_qty=item_qty;

                        }
                    }                                       
                }

                if(type==2)
                {
                    if(this.unit_expression[index-1].copy==false)   return; 
                    else{

                        for(let i=1;i<=this.form.total_unit;i++){

                            if(i!=index) this.form.subrooms_list_details_arr[type][i][subroom_id].item_qty=item_qty;

                        }
                    }                   
                }

                

                

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

                for(let ksk=0;ksk<12;ksk++)
                        {
                    this.property_expression.push({
                        'collupseble':false,
                        'copy':false,
                    });

                }

                if(this.form.total_suite>0)
                {
                    
                    if(1 in this.form.subrooms_list_details_arr == false)
                        this.form.subrooms_list_details_arr[1] = {};

                    for(let i=1;i<=this.form.total_suite;i++){

                        if(i in this.form.subrooms_list_details_arr[1] == false)
                            this.form.subrooms_list_details_arr[1][i] = {
                            };


                            this.suite_expression.push({
                                'collupseble':false,
                                'copy':false,
                               
                                
                            });


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

                        this.unit_expression.push({
                                'collupseble':false,
                                'copy':false,
                               
                                
                            });

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

            collupsable_property(type)
            {


                if(this.property_expression[type].collupseble==true)
                {
                    this.property_expression[type].collupseble=false;
                     return;
                }


                if(this.property_expression[type].collupseble==false)
                {
                    this.property_expression[type].collupseble=true;
                      return;
                }

            },

            collupsable_suite(type,index)
            {


                if(this.suite_expression[index-1].collupseble==true)
                {
                    this.suite_expression[index-1].collupseble=false;
                     //alert(this.suite_expression[index-1].collupseble+"**");
                     return;
                }


                if(this.suite_expression[index-1].collupseble==false)
                {
                    this.suite_expression[index-1].collupseble=true;
                   //  alert(this.suite_expression[index-1].collupseble+"##");
                      return;
                }
            },

            collupsable_unit(type,index)
            {


                if(this.unit_expression[index-1].collupseble==true)
                {
                    this.unit_expression[index-1].collupseble=false;
                     //alert(this.unit_expression[index-1].collupseble+"**");
                     return;
                }


                if(this.unit_expression[index-1].collupseble==false)
                {
                    this.unit_expression[index-1].collupseble=true;
                   //  alert(this.unit_expression[index-1].collupseble+"##");
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

                    this.building_arr                           =response.data.building_arr;
                    this.form.subrooms_list_arr                 =response.data.subrooms_list_arr;
                    this.form.safety_item_list_arr              =response.data.safety_item_list_arr;
                }); 

            },

	
            deleteFloor()
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

                      this.form.delete('/FloorPosts/'+this.form.id).then(()=>{
                        
                          if(result.value) {
                               showAlert(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                              );
                            this.form.reset();
                            this.fetchFloorProfile();
                          }            

                      }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                  });
               
              })
            },
            

            post()
            { 
                if(this.user_type==9) this.form.posting_status=2;
                else this.form.posting_status=1;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Post it!'
                }).then((result) => {

                    this.form.post('/FloorPost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            showAlert(
                                'Posted!',
                                'Your Data has been Posted.',
                                'success'
                            );

                            this.editFloor(response_data[1]);
                    
                        }            

                    }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                    });
                    
                })
                
            },

            repost()
            {            
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Repost it!'
                }).then((result) => {


                    this.form.post('/FloorRepost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            showAlert(
                                'Posted!',
                                'Your Data has been Reposted.',
                                'success'
                            );
                            
                            this.editFloor(response_data[1]);
                        }            

                    }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                    });
                    
                })
                
            },

            adjust()
            { 
                
                this.form.post('/adjustFloor/'+this.form.id).then((response)=>{
                    var response_data=response.data.split("**");
                    if(response_data[0]==1)
                    {
                        showToast('Data Update Successfully', 'success');
                        
                        this.editFloor(response_data[1]);
                        
                        this.editmode=true;
                    }
                    else{

                        showToast("there was some wrong","warning");
                    }
                }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                    });               
                
            },

            updateFloorInfo()
            { 
                

		        this.form.put('/Floors/'+this.form.id).then(({ data })=>{
					var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         showToast('Data Update Successfully', 'success');

                        
                        this.editFloor(response_data[1]);
                        this.editmode=true;
                        
                    }
                    else{

                        showToast("there was some wrong","warning");
                    }
                });
            },
            
            save_stay(type){


                

                this.form.post('/Floors') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         showToast('Data Update Successfully', 'success');

                        if(type==1)
                        {
                            this.editFloor(response_data[1]);
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

                        showToast("there was some wrong","warning");
                    }                    
                })
            },

            
	    }
    
    }  
	
</script>