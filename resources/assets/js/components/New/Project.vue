<template>

    <fieldset>
        <form id="msform" @submit.prevent="editmode ? updateProject() : createCompanyProfile()" @keydown="form.onKeydown($event)">
            <div class="form-card">
                <h1 class="page-head">Project</h1>
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
                                <td>{{ row.system_no }}</td>
                                <td>{{ row.project_name }}</td>
                                <td>{{ row.subject_title }}</td>
                                <td>{{ row.current_status }}</td>
                                <td>{{ row.building_type }}</td>
                                <td>{{ row.building_name }}</td>
                                <td>{{ row.contractor_id_no }}</td>
                                <td>{{ row.contractor_name }}</td>
                                <td width="120">
                                    <button class="btn btn-primary btn-sm"  @click.prevent="editPropertyProject(row.id)">Edit</button>
                                    
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
                                        <label class="fieldlabels">Project ID:</label> 
                                        <input v-model="form.system_no" 
                                            type="text" 
                                            name="system_no" 
                                            placeholder="Auto Generated" 
                                            :class="{ 'is-invalid': form.errors.has('system_no') }" readonly/>
                                        <has-error :form="form" field="system_no"></has-error>

                                        <label class="fieldlabels">Project Name:</label>  
                                        <input v-model="form.project_name" 
                                            type="text" 
                                            name="project_name" 
                                            placeholder="Project Name" 
                                            :class="{ 'is-invalid': form.errors.has('project_name') }" />
                                        <has-error :form="form" field="project_name"></has-error>

                                        <label class="fieldlabels">Subject/Title:</label>  
                                        <input v-model="form.subject_title" 
                                            type="text" 
                                            name="subject_title" 
                                            placeholder="Subject/Title" 
                                            :class="{ 'is-invalid': form.errors.has('subject_title') }" />
                                        <has-error :form="form" field="subject_title"></has-error>


                                        <label class="fieldlabels">Current Status:</label>  
                                        <select v-model="form.current_status"
                                            name="current_status"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('current_status') }">
                                            
                                            <option  value="">--Select Current Status-- </option>
                                            <option  value="1">Not Started</option>
                                            <option  value="2">In Progress</option>
                                            <option  value="3">Suspended</option>
                                            <option  value="4">Cancelled</option>
                                            <option  value="5">Under Investigation</option>
                                            <option  value="6">Completed</option>
                                        </select>
                                        <has-error :form="form" field="current_status"></has-error>
                                                                                    
                                    </div>
                                   
                                </div>
                               
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    
                                    <div class="form-box-outer">
                                        
                                        
                                        <h4>Contractor Profile:</h4>
                                        
                                        <label class="fieldlabels">ID- No:</label> 
                                        <input v-model="form.contractor_id_no" 
                                            type="text" 
                                            name="contractor_id_no" 
                                            @dblclick="service_provider_profile"
                                            placeholder="Browse" 
                                            :class="{ 'is-invalid': form.errors.has('contractor_id_no') }" />
                                        <has-error :form="form" field="contractor_id_no"></has-error>

                                        <label class="fieldlabels">Corporation Legal Name:</label>  
                                        <input v-model="form.corporation_legal_name" 
                                            type="text" 
                                            name="corporation_legal_name" 
                                            placeholder="Project Name" 
                                            :class="{ 'is-invalid': form.errors.has('corporation_legal_name') }" />
                                        <has-error :form="form" field="corporation_legal_name"></has-error>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <h4>Address</h4>
                                                <label class="fieldlabels">Number:</label> 
                                                <input v-model="form.house_number" 
                                                    type="phone" 
                                                    name="house_number" 
                                                    placeholder="Type House/Office Number" 
                                                    :class="{ 'is-invalid': form.errors.has('house_number') }"/>
                                                     <has-error :form="form" field="house_number"></has-error> 

                                                <label class="fieldlabels">Street Number:</label> 
                                                <input v-model="form.street_number" 
                                                    type="text" 
                                                    name="street_number" 
                                                    placeholder="Type Street Number" 
                                                    :class="{ 'is-invalid': form.errors.has('street_number') }"/>
                                                <has-error :form="form" field="street_number"></has-error>

                                                <label class="fieldlabels">City:</label> 
                                                <input v-model="form.city" 
                                                    type="text" 
                                                    name="city" 
                                                    placeholder="Type City" 
                                                    :class="{ 'is-invalid': form.errors.has('city') }"/>
                                                     <has-error :form="form" field="city"></has-error>  

                                                <label class="fieldlabels">State:</label> 
                                                <input v-model="form.state" 
                                                    type="text" 
                                                    name="state" 
                                                    placeholder="Type State" 
                                                    :class="{ 'is-invalid': form.errors.has('state') }"/>
                                                     <has-error :form="form" field="state"></has-error>

                                                <label class="fieldlabels">Country:</label> 
                                                <div class="position-relative form-group">
                                                     <select v-model="form.country"
                                                        name="country"
                                                        class="custom-select" 
                                                        :class="{ 'is-invalid': form.errors.has('country') }">
                                                        <option disabled value="">--Select-- </option>
                                                        <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                                    </select>
                                                </div>
                                                <label class="fieldlabels">Zip Code/ Postal Code:</label> 
                                                    <input v-model="form.zip_code" 
                                                        type="phone" 
                                                        name="zip_code" 
                                                        placeholder="Type Zip Code/ Postal Code" 
                                                        :class="{ 'is-invalid': form.errors.has('zip_code') }"/>
                                                    <has-error :form="form" field="zip_code"></has-error> 

                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <h4>Contact</h4>
                                                <label class="fieldlabels">Office Phone:</label> 
                                                    <input v-model="form.office_phone" 
                                                        type="text" 
                                                        name="office_phone" 
                                                        :class="{ 'is-invalid': form.errors.has('office_phone') }"/>
                                                        <has-error :form="form" field="office_phone"></has-error>
                                                <label class="fieldlabels">Moblile Number:</label> 
                                                <input v-model="form.cell_phone" 
                                                    type="text" 
                                                    name="cell_phone" 
                                                    :class="{ 'is-invalid': form.errors.has('cell_phone') }"/>
                                                     <has-error :form="form" field="cell_phone"></has-error>

                                                <label class="fieldlabels">Email:</label> 
                                                <input v-model="form.email" 
                                                    type="email" 
                                                    name="email" 
                                                    :class="{ 'is-invalid': form.errors.has('email') }"/>
                                                <has-error :form="form" field="email"></has-error>
                                                <label class="fieldlabels">Fax:</label> 
                                                <input v-model="form.fax_no" 
                                                    type="text" 
                                                    name="fax_no" 
                                                    :class="{ 'is-invalid': form.errors.has('fax_no') }"/>
                                                    <has-error :form="form" field="fax_no"></has-error> 

                                                <label class="fieldlabels">Website :</label> 
                                                <input v-model="form.website" 
                                                    type="url" 
                                                    name="website" 
                                                    :class="{ 'is-invalid': form.errors.has('website') }"/>
                                                     <has-error :form="form" field="website"></has-error>
                                            </div>
                                        </div>
                                            
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
                                
                                <div class="col-md-10 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="25%" >Building Type</th>
                                                    <th scope="col" width="30%" >Property ID</th>
                                                    <th scope="col" width="35%" >Property Name</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                
                                                <tr align="center">
                                                    <td >Residential Building </td>
                                                    <td >
                                                        <select v-model="form.residential_building_id"
                                                            name="residential_building_id"
                                                            class="custom-select" 
                                                            @change="change_building(1)"
                                                            :class="{ 'is-invalid': form.errors.has('residential_building_id') }">
                                                            <option  value="null" v-if="form.residential_building_id===null">--Select Property ID-- </option>
                                                            <option  value="" v-else>--Select Property ID-- </option>
                                                            <option v-for="(building,index) in building_arr" :value="index" v-if="building.residential==1">{{building.building_no}}</option>
                                                        </select>

                                                    </td>
                                                    <td>{{form.residential_building_name}}</td>
                                                </tr>
                                                <tr align="center">
                                                    <td >Commercial Building </td>
                                                    <td >
                                                        <select v-model="form.commercial_building_id"
                                                            name="commercial_building_id"
                                                            class="custom-select" 
                                                            @change="change_building(2)"
                                                            :class="{ 'is-invalid': form.errors.has('commercial_building_id') }">
                                                           
                                                            <option  value="" >--Select Property ID-- </option>
                                                            <option v-for="(building,index) in building_arr" :value="index" v-if="building.commercial==1">{{building.building_no}}</option>
                                                        </select>

                                                    </td>
                                                    <td>{{form.commercial_building_name}}</td>
                                                </tr>
                                                
                                                <tr align="center">
                                                    <td width="" scope="row" >
                                                        Residential- Commercial Building 
                                                    </td>
                                                    <td >
                                                        <select v-model="form.residential_commercial_building_id"
                                                            name="residential_commercial_building_id"
                                                            class="custom-select" 
                                                            @change="change_building(3)"
                                                            :class="{ 'is-invalid': form.errors.has('residential_commercial_building_id') }">
                                                            <option  value="" >--Select Property ID-- </option>
                                                            <option v-for="(building,index) in building_arr" :value="index" v-if="building.residential_commercial==1">{{building.building_no}}</option>
                                                        </select>

                                                    </td>
                                                    <td>{{form.residential_commercial_building_name}}</td>
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
                        <h3><i class="fa fa-hand-point-right"></i>Floor Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_floor_list()" v-show="!floor_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_floor_list()" v-show="floor_show">Hide</button></h3>
                        <div class="form-holder" v-show="floor_show">
                            

                            <div class="form-folder"  style="margin-left:50px;4">
                                
                                    <table class="table table_narrow">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="25%" >Floor No </th>
                                                <th scope="col" width="30%" >Property ID</th>
                                                <th scope="col" width="35%" >Property Name</th>
                                                <th scope="col" width="35%" >Action</th>
                                            </tr> 
                                        </thead>
                                        <tbody>
                                            <template v-for="(floor,index) in form.floor_arr" v-if="floor.data_exist">
                                                <tr>
                                                    <td align="center">Floor No-{{floor.floor_no}}</td>
                                                    <td align="center">{{floor.system_no}}</td>
                                                    <td align="center">{{floor.floor_name}}</td>
                                                    <td align="center">

                                                        <button type="button" class="btn btn-primary btn-sm" @click="show_hide_floor(floor)" v-show="!floor.toggle">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_floor(floor)" v-show="floor.toggle">Hide</button>
                                                        </td>
                                                </tr>
                                                <tr v-show="floor.toggle">
                                                    <td colspan="6">

                                                        <div class="form-folder" v-if="floor.suite">
                                                            <h3><i class="fa fa-hand-point-right"></i>Residential Suite Details </h3>
                                                            <div class="form-holder">
                                                                
                                                                <div class="row align-self-stretch">
                                                                    
                                                                    <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                                                        <div class="form-box-outer" style=" width:100%">
                                                                            
                                                                            <table class="table table_narrow">
                                                                                
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th scope="col" width="10%" >Action</th>
                                                                                        <th scope="col" width="30%" >Residential Suite Type</th>
                                                                                        <th scope="col" width="20%" >Property ID</th>
                                                                                        <th scope="col" width="20%" >Property Name</th>
                                                                                        <th scope="col" width="20%" >Suite No</th>
                                                                                        
                                                                                    </tr>
                                                                                    
                                                                                </thead>
                                                                                <tbody >
                                                                                    <template v-for="(s_suite,index) in form.suite_arr[floor.floor_id]">
                                                                                        <tr style=" background-color:#ababab;font-size:20; font-color:#ddd">
                                                                                            <td>
                                                                                                <button type="button" class="btn btn-primary btn-sm" @click="show_hide_suite(s_suite)" v-show="!s_suite.toggle">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_suite(s_suite)" v-show="s_suite.toggle">Hide</button>
                                                                                            </td>
                                                                                            <td v-if="s_suite.suite_type==1"> Studio</strong></td>
                                                                                            <td v-else-if="s_suite.suite_type==2"> <strong>1 Bedroom </strong></strong></td>
                                                                                            <td v-else-if="s_suite.suite_type==3"><strong> 2 Bedroom </strong></td>
                                                                                            <td v-else-if="s_suite.suite_type==4"><strong> 3 Bedroom </strong></td>
                                                                                            <td v-else-if="s_suite.suite_type==5"><strong> 4 Bedroom </strong></td>
                                                                                            <td v-else-if="s_suite.suite_type==6"> <strong>5 Bedroom </strong></td>
                                                                                            <td v-else-if="s_suite.suite_type==7"> <strong>6 Bedroom </strong></td>
                                                                                            <td v-else-if="s_suite.suite_type==8"> <strong>Penthouse</strong> </td>
                                                                                            
                                                                                            <td><strong>{{s_suite.system_no}}</strong></td>
                                                                                            <td><strong>{{s_suite.property_name}}</strong></td>
                                                                                            
                                                                                            <td><strong>Suite-{{s_suite.suite_no.toString().padStart(2,"0")}}</strong></td>
  
                                                                                        </tr>

                                                                                        <template v-for="(single_subroom,index) in form.subrooms_list_arr[s_suite.id]" >
                                                                                            <tr v-show="s_suite.toggle">
                                                                                                <td width="10%"  class="form-check-inline">

                                                                                                    <input type="checkbox" 
                                                                                                        @click="check_suite_sub_room($event,single_subroom)"
                                                                                                        v-model="single_subroom.allocated" >
                                                                                                
                                                                                                </td>

                                                                                                <td width="30%" style="padding-left:5% !important">
                                                                                                    <strong>{{single_subroom.item_name}}</strong>
                                                                                                </td>
                                                                                                <td width="">
                                                                                                    {{single_subroom.system_no}}
                                                                                                    
                                                                                                </td>
                                                                                                <td width="">
                                                                                                    {{single_subroom.system_no}}
                                                                                                    
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

                                                        <div class="form-folder" v-if="floor.unit">
                                                            <h3><i class="fa fa-hand-point-right"></i>Commercial Unit Details </h3>
                                                            <div class="form-holder" >
                                                                
                                                                <div class="row align-self-stretch">
                                                                    
                                                                    <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                                                        <div class="form-box-outer" style=" width:100%">
                                                                            
                                                                            <table class="table table_narrow">
                                                                                
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th scope="col" width="10%" >Action</th>
                                                                                        <th scope="col" width="30%" >Commercial Unit Type</th>
                                                                                        <th scope="col" width="20%" >Property ID</th>
                                                                                        <th scope="col" width="20%" >Property Name</th>
                                                                                        <th scope="col" width="20%" >Unit No</th>
                                                                                    </tr>
                                                                                    
                                                                                </thead>
                                                                                <tbody >
                                                                                    <template v-for="(unit,index) in form.unit_arr[floor.floor_id]">
                                                                                        <tr align="center" style=" background-color:#ababab;font-size:20; font-color:#ddd">
                                                                                            <td>
                                                                                                <button type="button" class="btn btn-primary btn-sm" @click="show_hide_unit(unit)" v-show="!unit.toggle">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_unit(unit)" v-show="unit.toggle">Hide</button>
                                                                                            </td>
                                                                                            <td width="" scope="row" v-if="unit.unit_type==1">Store</td>
                                                                                            <td width="" scope="row" v-else>Office</td>
                                                                                            <td>{{unit.system_no}}</td>
                                                                                            <td>{{unit.property_name}}</td>
                                                                                            <td>Unit-{{unit.unit_no.toString().padStart(2,"0")}}</td>
                                                                                            
                                                                                        </tr>

                                                                                        <template v-for="(single_subroom,index) in form.unit_subrooms_list_arr[unit.id]" >
                                                                                            <tr v-show="unit.toggle">
                                                                                                <td width="10%"  class="form-check-inline" >
                                                                                                    <input type="checkbox" 
                                                                                                        @click="check_unit_sub_room($event,single_subroom)"
                                                                                                        v-model="single_subroom.allocated">
                                                                                                </td>
                                                                                                <td width="30%" style="padding-left:5% !important">
                                                                                                    <strong>{{single_subroom.item_name}}</strong></td>
                                                                                                <td width="">{{single_subroom.system_no}}</td>
                                                                                                <td width="">{{single_subroom.property_name}}</td>
                                                                                                
                                                                                                
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


                                                        <div class="form-folder" v-if="floor.supporting">
                                                            <h3><i class="fa fa-hand-point-right"></i>Supporting & Service Room Details</h3>
                                                            <div class="form-holder" >
                                                                
                                                                <div class="row align-self-stretch">
                                                                    
                                                                    <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                                                        <div class="form-box-outer" style=" width:100%">
                                                                            
                                                                            <table class="table table_narrow" >
                                                                                
                                                                                <tbody>
                                                                                    
                                                                                    <template v-if="floor.machanical">
                                                                                        <tr style="background-color:rgb(0, 112, 192) !important;color:#fff">
                                                                                            <td width="10%">Action</td>
                                                                                            <td scope="col" width="25%">Mechanical Room</td>
                                                                                            <td scope="col" width="20%">Property ID</td>
                                                                                            <td scope="col" width="25%">Property Name</td>
                                                                                                                                    
                                                                                        </tr>
                                                                                        <template v-for="(single_subroom,index) in form.service_room_arr[floor.floor_id]" v-if="single_subroom.item_type==7">
                                                                                                                                              
                                                                                            <tr>
                                                                                                <td class="form-check-inline">
                                                                                                    <input type="checkbox" 
                                                                                                        id="allocated" 
                                                                                                        name="allocated[]" 
                                                                                                        @click="check_supporting_room($event,single_subroom)"
                                                                                                        v-model="single_subroom.allocated" >
                                                                                                    
                                                                                                </td>
                                                                                                <td width="25%" scope="row" style="padding-left:2% !important"><strong>{{single_subroom.item_name}}</strong></td>
                                                                                                <td width="20%">
                                                                                                    {{single_subroom.system_no}}
                                                                                                </td>
                                                                                                <td width="25%">
                                                                                                    {{single_subroom.property_name}}
                                                                                                </td>
                                                                                                                                                                        
                                                                                            </tr>

                                                                                        </template>                                                   
                                                                                       
                                                                                    </template>
                                                                                    <template v-if="floor.administritive">
                                                                                        <tr style="background-color:rgb(0, 112, 192) !important;color:#fff">
                                                                                            <td width="10%">Action</td>
                                                                                            <td scope="col" width="25%">Administrative Room</td>
                                                                                            <td scope="col" width="20%">Property ID</td>
                                                                                            <td scope="col" width="25%">Property Name</td>
                                                                                                                                    
                                                                                        </tr>
                                                                                        <template v-for="(single_subroom,index) in form.service_room_arr[floor.floor_id]" v-if="single_subroom.item_type==8">
                                                                                            <tr>
                                                                                                <td class="form-check-inline">
                                                                                                    <input type="checkbox" 
                                                                                                        id="allocated" 
                                                                                                        name="allocated[]" 
                                                                                                        @click="check_supporting_room($event,single_subroom)"
                                                                                                        v-model="single_subroom.allocated" >
                                                                                                </td>                               
                                                                                                <td width="25%" scope="row" style="padding-left:2% !important"><strong>{{single_subroom.item_name}}</strong></td>
                                                                                                <td width="20%">
                                                                                                    {{single_subroom.system_no}}
                                                                                                </td>
                                                                                                <td width="25%">
                                                                                                    {{single_subroom.property_name}}
                                                                                                </td>
                                                                                                
                                                                                            </tr>

                                                                                        </template>                                                   
                                                                                       
                                                                                    </template>

                                                                                    <template v-if="floor.aminity">
                                                                                        <tr style="background-color:rgb(0, 112, 192) !important;color:#fff">
                                                                                            <td width="10%">Action</td>
                                                                                            <td scope="col" width="25%">Aminity Room</td>
                                                                                            <td scope="col" width="20%">Property ID</td>
                                                                                            <td scope="col" width="25%">Property Name</td>
                                                                                                                                    
                                                                                        </tr>
                                                                                        <template v-for="(single_subroom,index) in form.service_room_arr[floor.floor_id]" v-if="single_subroom.item_type==9">
                                                                                            
                                                                                            <tr>
                                                                                                <td class="form-check-inline">
                                                                                                    <input type="checkbox" 
                                                                                                        id="allocated" 
                                                                                                        name="allocated[]" 
                                                                                                        @click="check_supporting_room($event,single_subroom)"
                                                                                                        v-model="single_subroom.allocated" >
                                                                                                    
                                                                                                </td>
                                                                                                <td width="25%" scope="row" style="padding-left:2% !important"><strong>{{single_subroom.item_name}}</strong></td>
                                                                                                <td width="20%">
                                                                                                    {{single_subroom.system_no}}
                                                                                                </td>
                                                                                                <td width="25%">
                                                                                                    {{single_subroom.property_name}}
                                                                                                </td>
                                                                                                
                                                                                                
                                                                                            </tr>

                                                                                        </template>                                                   
                                                                                       
                                                                                    </template>

                                                                                    <template v-if="floor.service">
                                                                                        <tr style="background-color:rgb(0, 112, 192) !important;color:#fff">
                                                                                            <td width="10%">Action</td>
                                                                                            <td scope="col" width="25%">Service Room</td>
                                                                                            <td scope="col" width="20%">Property ID</td>
                                                                                            <td scope="col" width="25%">Property Name</td>
                                                                                                                                    
                                                                                        </tr>
                                                                                        <template v-for="(single_subroom,index) in form.service_room_arr[floor.floor_id]" v-if="single_subroom.item_type==10">
                                                                                            
                                                                                            <tr>
                                                                                                <td class="form-check-inline">
                                                                                                    <input type="checkbox" 
                                                                                                        id="allocated" 
                                                                                                        name="allocated[]" 
                                                                                                        @click="check_supporting_room($event,single_subroom)"
                                                                                                        v-model="single_subroom.allocated" >
                                                                                                    
                                                                                                </td>
                                                                                                <td width="25%" scope="row" style="padding-left:2% !important"><strong>{{single_subroom.item_name}}</strong></td>
                                                                                                <td width="20%">
                                                                                                    {{single_subroom.system_no}}
                                                                                                </td>
                                                                                                <td width="25%">
                                                                                                    {{single_subroom.property_name}}
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
                                                        <div class="form-folder" v-if="floor.parking">
                                                            <h3><i class="fa fa-hand-point-right"></i>Parking Lot Details </h3>
                                                            <div class="form-holder" >
                                                                
                                                                <div class="row align-self-stretch">
                                                                    
                                                                    <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                                                        <div class="form-box-outer" style=" width:100%">
                                                                            
                                                                            <div class="pull-left" style="margin-top:10px;">
                                                                                <label for="filter" class="sr-only">Filter</label>
                                                                                <input type="text" class="form-control" v-model="filter_parking" placeholder="Filter" style="width:400px;">
                                                                            </div>
                                                                            
                                                                            <datatable :columns="parking_columns" :data="form.parking_stall_arr[floor.floor_id]" :filter-by="filter_parking" class="table_narrow">
                                                                                <template slot-scope="{row}">
                                                                                    <tr>
                                                                                        
                                                                                        <td class="form-check-inline">
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


                                                         <div class="form-folder" v-if="floor.bike_lot">
                                                            <h3><i class="fa fa-hand-point-right"></i>Bike Lot Details</h3>
                                                            <div class="form-holder" >
                                                                
                                                                <div class="row align-self-stretch">
                                                                    
                                                                    <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                                                        <div class="form-box-outer" style=" width:100%">
                                                                            
                                                                            <div class="pull-left" style="margin-top:10px;">
                                                                                <label for="filter" class="sr-only">Filter</label>
                                                                                <input type="text" class="form-control" v-model="filter_bike" placeholder="Filter" style="width:400px;">
                                                                            </div>
                                                                            
                                                                            <datatable :columns="bike_columns" :data="form.bike_stall_arr[floor.floor_id]" :filter-by="filter_bike" class="table_narrow">
                                                                                <template slot-scope="{row}">
                                                                                    <tr>
                                                                                        
                                                                                        <td class="form-check-inline">
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


                                                        <div class="form-folder" v-if="floor.storage">
                                                            <h3><i class="fa fa-hand-point-right"></i>Storage Lot Details</h3>
                                                            <div class="form-holder" >
                                                                
                                                                <div class="row align-self-stretch">
                                                                    
                                                                    <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                                                        <div class="form-box-outer" style=" width:100%">
                                                                            
                                                                            <div class="pull-left" style="margin-top:30px;">
                                                                                <label for="filter" class="sr-only">Filter</label>
                                                                                <input type="text" class="form-control" v-model="filter_storage" placeholder="Filter" style="width:400px;">
                                                                            </div>
                                                                            
                                                                            <datatable :columns="storage_columns" :data="form.storage_locker_arr[floor.floor_id]" :filter-by="filter_storage" class="table_narrow">
                                                                                <template slot-scope="{row}">
                                                                                    <tr>
                                                                                        
                                                                                        <td class="form-check-inline">
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


                                                        <div class="form-folder" v-if="floor.mail">
                                                            <h3><i class="fa fa-hand-point-right"></i>Mailbox Details </h3>
                                                            <div class="form-holder" >
                                                                
                                                                <div class="row align-self-stretch">
                                                                    
                                                                    <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                                                        <div class="form-box-outer" style=" width:100%">
                                                                            
                                                                            <div class="pull-left" style="margin-top:5px;">
                                                                                <label for="filter" class="sr-only">Filter</label>
                                                                                <input type="text" class="form-control" v-model="filter_mailbox" placeholder="Filter" style="width:400px;">
                                                                            </div>
                                                                            
                                                                            <datatable :columns="mail_columns" :data="form.mail_box_arr[floor.floor_id]" :filter-by="filter_mailbox" class="table_narrow">
                                                                                <template slot-scope="{row}">
                                                                                    <tr>
                                                                                        
                                                                                        <td class="form-check-inline">
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


                                                        <div class="form-folder" v-show="floor.common">
                                                            <h3><i class="fa fa-hand-point-right"></i>Common Area Details </h3>
                                                            <div class="form-holder" >
                                                                
                                                                <div class="row align-self-stretch">
                                                                    
                                                                    <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                                                        <div class="form-box-outer" style=" width:100%">
                                                                            
                                                                            <div class="pull-left" style="margin-top:5px;">
                                                                                <label for="filter" class="sr-only">Filter</label>
                                                                                <input type="text" class="form-control" v-model="filter_common_area" placeholder="Filter" style="width:400px;">
                                                                            </div>
                                                                            <datatable :columns="common_area_columns" :data="form.common_area_arr[floor.floor_id]" :filter-by="filter_common_area" class="table_narrow">
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

                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>

                            </div>
                            
                        </div>
                    </div>
                                       
                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Service Provider Insurance Package <button type="button" class="btn btn-primary btn-sm" @click="show_hide_insurance()" v-show="!insurance_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_insurance()" v-show="insurance_show">Hide</button></h3>
                        <div class="form-holder" v-show="insurance_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow">
                                            
                                           
                                            <thead>
                                                <tr class="header" >
                                                    <td scope="col" rowspan="2" >Insurance Type</td>
                                                    <td scope="col" colspan="2">Insurance Company</td>
                                                    <td scope="col" rowspan="2">Policy No</td>
                                                    <td scope="col" rowspan="2">Expiry Date</td>
                                                    <td scope="col" rowspan="2">Max Coverage</td>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                </tr>
                                            </thead>
                                            <tbody style="border:none">
                                                <template v-for="(inseurance_type,index) in form.inseurance_type_arr" >
                                                    <tr style="background-color: #e7e8e7">
                                                        <td scope="row" width="25%">{{inseurance_type.item_name}}</td>
                                                       
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Company Name"
                                                                v-bind:id="'inseurance_id_no_'+index"
                                                                name="inseurance_id_no[]" 
                                                                v-model="inseurance_type.company_name"/>
                                                        </td>
                                                        
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Address"
                                                                v-bind:id="'inseurance_address_'+index"
                                                                name="inseurance_website[]" 
                                                                v-model="inseurance_type.address"/>
                                                        </td>
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Policy No"
                                                                v-bind:id="'inseurance_policy_no_'+index"
                                                                name="inseurance_policy_no[]" 
                                                                v-model="inseurance_type.policy_no"/>
                                                        </td>
                                                        <td >
                                                            

                                                            <date-picker 
                                                                style="width:100%"
                                                                v-model="inseurance_type.expiry_date"
                                                                name="inseurance_expiry_date[]"
                                                                v-bind:id="'inseurance_expiry_date_'+index"
                                                                lang="en"
                                                                type="comment_date"
                                                                format="ddd, MMM D, YYYY"
                                                                :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                                                              
                                                        </td>
                                                        
                                                        <td>
                                                            <input 
                                                                type="max_coverage" 
                                                                placeholder="Type Max Coverage"
                                                                v-bind:id="'inseurance_max_coverage_'+index"
                                                                name="inseurance_max_coverage[]" 
                                                                v-model="inseurance_type.max_coverage"/>
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

                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Project Duration<button type="button" class="btn btn-primary btn-sm" @click="show_hide_project_duration()" v-show="!project_duration_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_project_duration()" v-show="project_duration_show">Hide</button></h3>

                        <div class="form-holder" v-show="project_duration_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr class="header" >
                                                    <td scope="col" >Description</td>
                                                    <td scope="col" >From</td>
                                                    <td scope="col" >To</td>
                                                    <td scope="col" >Net- Year</td>
                                                    <td scope="col" >Net Days</td>
                                                </tr>
                                            </thead>
                                            <tbody style="border:none">
                                                <template v-for="(project_duration,index) in form.project_duration_arr" >

                                                    <template v-if="index==0">
                                                        <tr style="background-color: #e7e8e7" >
                                                            <td scope="row" width="25%">{{project_duration.item_name}}</td>
                                                            <td >
                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="project_duration.from_date"
                                                                    name="inseurance_from_date[]"
                                                                    v-bind:id="'project_duration_from_date_'+index"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('from_date') }"></date-picker>
                                                            </td>
                                                            <td>
                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="project_duration.to_date"
                                                                    name="project_duration_to_date[]"
                                                                    v-bind:id="'project_duration_to_date_'+index"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('to_date') }"></date-picker>
                                                            </td>
                                                            <td>
                                                                <input 
                                                                    type="text" 
                                                                    placeholder="Type Net-Year"
                                                                    v-bind:id="'project_duration_net_year_'+index"
                                                                    name="project_duration_net_year[]" 
                                                                    v-model="project_duration.net_year"/>
                                                            </td>
                                                            <td>
                                                                <input 
                                                                    type="text" 
                                                                    placeholder="Type Net Days"
                                                                    v-bind:id="'project_duration_net_days_'+index"
                                                                    name="project_duration_net_days[]" 
                                                                    v-model="project_duration.net_days"/>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                    <template v-else-if="index==1">
                                                        <tr style="background-color: rgb(181, 184, 181)" >
                                                            <td scope="row" colspan="5" width="100%">Extended Date</td>
                                                                                                                           
                                                        </tr>
                                                        <tr style="background-color: #e7e8e7" >
                                                            <td scope="row" width="25%">

                                                                <button type="button" class="btn btn-success btn-sm" @click="add_new_project_duration(index)" v-if="index+1==form.project_duration_arr.length">Add</button>
                                                                {{project_duration.item_name}}

                                                            </td>
                                                            <td >
                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="project_duration.from_date"
                                                                    name="inseurance_from_date[]"
                                                                    v-bind:id="'project_duration_from_date_'+index"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('from_date') }"></date-picker>
                                                            </td>
                                                            <td>
                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="project_duration.to_date"
                                                                    name="project_duration_to_date[]"
                                                                    v-bind:id="'project_duration_to_date_'+index"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('to_date') }"></date-picker>
                                                            </td>
                                                            <td>
                                                                <input 
                                                                    type="text" 
                                                                    placeholder="Type Net-Year"
                                                                    v-bind:id="'project_duration_net_year_'+index"
                                                                    name="project_duration_net_year[]" 
                                                                    v-model="project_duration.net_year"/>
                                                            </td>
                                                            <td>
                                                                <input 
                                                                    type="text" 
                                                                    placeholder="Type Net Days"
                                                                    v-bind:id="'project_duration_net_days_'+index"
                                                                    name="project_duration_net_days[]" 
                                                                    v-model="project_duration.net_days"/>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                    <tr style="background-color: #e7e8e7" v-else>
                                                        <td scope="row" width="25%">

                                                            <button type="button" class="btn btn-success btn-sm" @click="add_new_project_duration(index)" v-if="index+1==form.project_duration_arr.length">Add</button>
                                                            {{project_duration.item_name}}

                                                        </td>
                                                        <td >
                                                            <date-picker 
                                                                style="width:100%"
                                                                v-model="project_duration.from_date"
                                                                name="inseurance_from_date[]"
                                                                v-bind:id="'project_duration_from_date_'+index"
                                                                lang="en"
                                                                format="ddd, MMM D, YYYY"
                                                                :class="{ 'is-invalid': form.errors.has('from_date') }"></date-picker>
                                                        </td>
                                                        <td>
                                                            <date-picker 
                                                                style="width:100%"
                                                                v-model="project_duration.to_date"
                                                                name="project_duration_to_date[]"
                                                                v-bind:id="'project_duration_to_date_'+index"
                                                                lang="en"
                                                                format="ddd, MMM D, YYYY"
                                                                :class="{ 'is-invalid': form.errors.has('to_date') }"></date-picker>
                                                        </td>
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Net-Year"
                                                                v-bind:id="'project_duration_net_year_'+index"
                                                                name="project_duration_net_year[]" 
                                                                v-model="project_duration.net_year"/>
                                                        </td>
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Net Days"
                                                                v-bind:id="'project_duration_net_days_'+index"
                                                                name="project_duration_net_days[]" 
                                                                v-model="project_duration.net_days"/>
                                                        </td>                                                  
                                                    </tr>
                                                                                                              
                                                </template>
                                                <tr style="background-color: rgb(0, 112, 192);color:#fff" >
                                                    <td scope="row"  >Final Delivery Date</td>
                                                    <td scope="row"  >
                                                        <date-picker 
                                                            style="width:100%"
                                                            v-model="form.final_delivery_date"
                                                            name="final_delivery_date[]"
                                                            lang="en"
                                                            format="ddd, MMM D, YYYY"
                                                            :class="{ 'is-invalid': form.errors.has('final_delivery_date') }"></date-picker>
                                                    </td>                                                              
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
                        <h3><i class="fa fa-hand-point-right"></i>Timeline<button type="button" class="btn btn-primary btn-sm" @click="show_hide_timeline()" v-show="!timeline_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_timeline()" v-show="timeline_show">Hide</button></h3>

                        <div class="form-holder" v-show="timeline_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr class="header" >
                                                    <td scope="col" rowspan="2">Task No</td>
                                                    <td scope="col" rowspan="2">Task Details</td>
                                                    <td scope="col" colspan="4">Task Duration</td>
                                                    <td scope="col" colspan="6">Task Rescheduled</td>
                                                    <td scope="col" rowspan="2">Task Status</td>
                                                </tr>
                                                <tr class="header" >
                                                    <td scope="col" >From</td>
                                                    <td scope="col" >To</td>
                                                    <td scope="col" >Days</td>
                                                    <td scope="col" >Hours</td>
                                                    <td scope="col" >From</td>
                                                    <td scope="col" >To</td>
                                                    <td scope="col" >From</td>
                                                    <td scope="col" >To</td>
                                                    <td scope="col" >From</td>
                                                    <td scope="col" >To</td>
                                                </tr>
                                            </thead>
                                            <tbody style="border:none">
                                                <template v-for="(timeline,index) in form.timeline_arr" >
                                                    
                                                    <template >
                                                        <tr style="background-color: #e7e8e7" >

                                                            <td scope="row" width="5%">
                                                                <button type="button" class="btn btn-success btn-sm" @click="add_new_timeline()" v-if="index+1==form.timeline_arr.length">+</button>
                                                                {{index+1}}
                                                            </td>
                                                            <td>
                                                                <input 
                                                                    type="text" 
                                                                    placeholder="Type Task Details"
                                                                    v-bind:id="'timeline_task_details_'+index"
                                                                    name="timeline_task_details[]" 
                                                                    v-model="timeline.task_details"/>
                                                            </td>
                                                            <td >
                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="timeline.from_date"
                                                                    name="inseurance_from_date[]"
                                                                    v-bind:id="'timeline_from_date_'+index"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('from_date') }"></date-picker>
                                                            </td>
                                                            <td>
                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="timeline.to_date"
                                                                    name="timeline_to_date[]"
                                                                    v-bind:id="'timeline_to_date_'+index"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('to_date') }"></date-picker>
                                                            </td>
                                                            <td>
                                                                <input 
                                                                    type="text" 
                                                                    placeholder="Type Days"
                                                                    v-bind:id="'timeline_days_'+index"
                                                                    name="timeline_days[]" 
                                                                    v-model="timeline.days"/>
                                                            </td>
                                                            <td>
                                                                <input 
                                                                    type="text" 
                                                                    placeholder="Type Hours"
                                                                    v-bind:id="'timeline_hours_'+index"
                                                                    name="timeline_hours[]" 
                                                                    v-model="timeline.hours"/>
                                                            </td>

                                                            <td >
                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="timeline.resedule_from_date1"
                                                                    name="inseurance_resedule_from_date1[]"
                                                                    v-bind:id="'timeline_resedule_from_date1_'+index"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('resedule_from_date1') }"></date-picker>
                                                            </td>
                                                            <td>
                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="timeline.resedule_to_date1"
                                                                    name="timeline_resedule_to_date1[]"
                                                                    v-bind:id="'timeline_resedule_to_date1_'+index"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('resedule_to_date1') }"></date-picker>
                                                            </td>
                                                            <td >
                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="timeline.resedule_from_date2"
                                                                    name="inseurance_resedule_from_date2[]"
                                                                    v-bind:id="'timeline_resedule_from_date2_'+index"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('resedule_from_date2') }"></date-picker>
                                                            </td>
                                                            <td>
                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="timeline.resedule_to_date2"
                                                                    name="timeline_resedule_to_date2[]"
                                                                    v-bind:id="'timeline_resedule_to_date2_'+index"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('resedule_to_date2') }"></date-picker>
                                                            </td>
                                                            <td >
                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="timeline.resedule_from_date3"
                                                                    name="inseurance_resedule_from_date3[]"
                                                                    v-bind:id="'timeline_resedule_from_date3_'+index"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('resedule_from_date3') }"></date-picker>
                                                            </td>
                                                            <td>
                                                                <date-picker 
                                                                    style="width:100%"
                                                                    v-model="timeline.resedule_to_date3"
                                                                    name="timeline_resedule_to_date3[]"
                                                                    v-bind:id="'timeline_resedule_to_date3_'+index"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('resedule_to_date3') }"></date-picker>
                                                            </td>
                                                            <td>
                                                                <select v-model="timeline.task_status"
                                                                    name="task_status[]"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('task_status') }">
                                                                    <option  value="">--Select Current Status-- </option>
                                                                    <option  value="1">Work in Process</option>
                                                                    <option  value="2">Completed</option>
                                                                    <option  value="3">Cancelled</option>
                                                                    <option  value="4">Under Inspection</option>
                                                                    <option  value="5">On Hold</option>
                                                                </select>
                                                                <has-error :form="form" field="timeline.task_status"></has-error>

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
                        <h3><i class="fa fa-hand-point-right"></i>Amount <button type="button" class="btn btn-primary btn-sm" @click="show_hide_amount()" v-show="!amount_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_amount()" v-show="amount_show">Hide</button></h3>

                        <div class="form-holder" v-show="amount_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-8 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr class="header" >
                                                    <td scope="col" >Amount </td>
                                                    <td scope="col" >Amount Before Tax</td>
                                                    <td scope="col" >Taxes</td>
                                                    <td scope="col" >Action</td>
                                                </tr>
                                                
                                            </thead>
                                            <tbody style="border:none">
                                                <template v-for="(project_amount,index) in form.project_amount_arr" v-if="project_amount.type==1">
                                                    
                                                    <tr>
                                                        <td scope="row" width="20%" >
                                                            <strong>{{project_amount.title}}</strong>
                                                        </td>
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                class="text-center"
                                                                placeholder="Type Before Tax"
                                                                v-bind:id="'project_amount_task_details_'+index"
                                                                name="project_amount_task_details[]" 
                                                                @keyup="calculate_amount()"
                                                                v-model="project_amount.amount_before_tax"/>
                                                        </td>
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                class="text-center"
                                                                placeholder="Type Taxes"
                                                                @keyup="calculate_amount()"
                                                                v-bind:id="'project_amount_task_details_'+index"
                                                                name="project_amount_task_details[]" 
                                                                v-model="project_amount.taxes"/>
                                                        </td>
                                                        <td scope="row" width="20%">
                                                        </td>
                                                    </tr>

                                                </template>
                                                <tr style="background-color:rgb(173, 208, 233) !important" >

                                                    <td scope="row" colspan="5" width="100%">
                                                        <strong>Additional</strong>
                                                    </td>
                                                </tr>
                                                <template v-for="(project_amount,index) in form.project_amount_arr" v-if="project_amount.type==2">
                                                    <tr  >

                                                        <td scope="row" width="20%">
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type title"
                                                                name="project_amount_title[]" 
                                                                v-model="project_amount.title"/>
                                                        </td>
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                class="text-center"
                                                                placeholder="Type Before Tax"
                                                                v-bind:id="'project_amount_task_details_'+index"
                                                                @keyup="calculate_amount()"
                                                                name="project_amount_task_details[]" 
                                                                v-model="project_amount.amount_before_tax"/>
                                                        </td>
                                                        <td >
                                                            <input 
                                                                type="text" 
                                                                class="text-center"
                                                                placeholder="Type Taxes"
                                                                v-bind:id="'project_amount_task_details_'+index"
                                                                name="project_amount_task_details[]" 
                                                                @keyup="calculate_amount()"
                                                                v-model="project_amount.taxes"/>
                                                        </td>
                                                        <td scope="row" width="20%">
                                                            <button type="button" class="btn btn-success btn-sm" @click="add_new_amount(1)" v-if="project_amount.sl==form.additional_amount_sl">Add</button>
                                                        </td>
                                                    </tr>
                                                </template>


                                                <tr style="background-color: #e7e8e7">
                                                    <td scope="row"  width="">
                                                       <strong> Total Addition</strong>
                                                    </td>
                                                    <td scope="row"  align="center">
                                                       <strong> {{form.total_aditional_amount}}</strong>
                                                    </td>
                                                    <td scope="row"  align="center">
                                                       <strong>  {{form.total_aditional_tax}}</strong>
                                                    </td>
                                                    <td scope="row"  width="">
                                                       <strong> </strong>
                                                    </td>
                                                </tr>
                                                <tr style="background-color: rgb(173, 208, 233) !important">

                                                    <td scope="row" colspan="5" width="100%">
                                                       <strong> Deductions</strong>
                                                    </td>
                                                </tr>
                                                <template v-for="(project_amount,index) in form.project_amount_arr" v-if="project_amount.type==3">
                                                    <tr style="background-color: " >

                                                        <td scope="row" width="20%">
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type title"
                                                                name="project_amount_title[]" 
                                                                v-model="project_amount.title"/>
                                                        </td>
                                                        <td align="center">
                                                            <input 
                                                                type="text"
                                                                class="text-center"
                                                                placeholder="Type Before Tax"
                                                                v-bind:id="'project_amount_task_details_'+index"
                                                                name="project_amount_task_details[]"
                                                                @keyup="calculate_amount(1)" 
                                                                v-model="project_amount.amount_before_tax"/>
                                                        </td>
                                                        <td align="center">
                                                            <input 
                                                                type="text" 
                                                                class="text-center"
                                                                placeholder="Type Taxes"
                                                                v-bind:id="'project_amount_task_details_'+index"
                                                                name="project_amount_task_details[]" 
                                                                @keyup="calculate_amount(2)"
                                                                v-model="project_amount.taxes"/>
                                                        </td>
                                                        <td scope="row" width="10%">
                                                            <button type="button" class="btn btn-success btn-sm" @click="add_new_amount(2)" v-if="project_amount.sl==form.deduction_amount_sl">Add</button> 
                                                        </td>
                                                    </tr>
                                                </template>
                                                <tr style="background-color: #e7e8e7">
                                                    <td scope="row"  width="">
                                                       <strong> Total Deduction</strong>
                                                    </td>
                                                    <td scope="row"  align="center">
                                                       <strong> {{form.total_deduction_amount}}</strong>
                                                    </td>
                                                    <td scope="row"   align="center">
                                                       <strong>  {{form.total_deduction_tax}}</strong>
                                                    </td>
                                                    <td scope="row"  width="">
                                                       <strong> </strong>
                                                    </td>
                                                </tr>

                                                <tr style="background-color: rgb(158, 200, 200)">
                                                    <td scope="row"  width="">
                                                       <strong> Total</strong>
                                                    </td>
                                                    <td scope="row"  align="center">
                                                       <strong> {{form.total_amount}}</strong>
                                                    </td>
                                                    <td scope="row"  align="center">
                                                       <strong>  {{form.total_tax}}</strong>
                                                    </td>
                                                    <td scope="row"  width="">
                                                       <strong> </strong>
                                                    </td>
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
                        <h3><i class="fa fa-hand-point-right"></i>Payments Schedule <button type="button" class="btn btn-primary btn-sm" @click="show_hide_payment_schedule()" v-show="!payment_schedule_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_payment_schedule()" v-show="payment_schedule_show">Hide</button></h3>

                        <div class="form-holder" v-show="payment_schedule_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-8 col-sm-12 col-xs-6"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        
                                        <table class="table table_narrow">
                                            
                                            <thead>
                                                <tr class="header" >
                                                    <td scope="col" >Payment No </td>
                                                    <td scope="col" >Due Date</td>
                                                    <td scope="col" >Calendar</td>
                                                    <td scope="col" >Action</td>
                                                </tr>
                                                
                                            </thead>
                                            <tbody style="border:none">
                                                
                                                <template v-for="(payment_schedule,index) in form.payment_schedule_arr" >
                                                    <tr  >

                                                        <td scope="row" width="20%">
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type title"
                                                                name="payment_schedule_title[]" 
                                                                v-model="payment_schedule.title"/>
                                                        </td>
                                                        <td>
                                                            <date-picker 
                                                                    style="width:100%"
                                                                    v-model="payment_schedule.due_date"
                                                                    name="payment_schedule_due_date[]"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('due_date') }"></date-picker>
                                                        </td>
                                                        <td>
                                                            

                                                            <button 
                                                                type="button" 
                                                                class="btn  btn-warning"
                                                                @click="payment_schedule_add_calender(2,payment_schedule)" 
                                                                v-if="payment_schedule.is_callender">Remove From Calender</button>

                                                            <button 
                                                                type="button" 
                                                                class="btn  btn-primary" 
                                                                @click="payment_schedule_add_calender(1,payment_schedule)" 
                                                                v-else>Add To Calender</button>
                                                        </td>
                                                        <td scope="row" width="20%">
                                                            <button type="button" class="btn btn-success btn-sm" @click="add_new_payment_schdule(1)" v-if="payment_schedule.sl==form.payment_schedule_sl">Add</button>
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


                    <div class="form-folder" >
                        <h3><i class="fa fa-hand-point-right"></i>Incident Reports<button type="button" class="btn btn-primary btn-sm" @click="show_hide_incident_reports()" v-show="!incident_reports_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_incident_reports()" v-show="incident_reports_show">Hide</button></h3>

                        <div class="form-holder" v-show="incident_reports_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-8 col-sm-12 col-xs-6"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer" style=" width:100%">
                                        <table class="table table_narrow">
                                            <thead>
                                                <tr class="header" >
                                                    <td scope="col" >Date</td>
                                                    <td scope="col" >Details</td>
                                                    <td scope="col" >Reported By</td>
                                                    <td> Action </td>
                                                </tr>
                                                
                                            </thead>
                                            <tbody style="border:none">
                                                
                                                <template v-for="(incident_report,index) in form.incident_reports_arr" >
                                                    <tr  >

                                                        <td>
                                                            <date-picker 
                                                                    style="width:100%"
                                                                    v-model="incident_report.incident_date"
                                                                    name="incident_report_incident_date[]"
                                                                    lang="en"
                                                                    format="ddd, MMM D, YYYY"
                                                                    :class="{ 'is-invalid': form.errors.has('incident_date') }"></date-picker>
                                                        </td>
                                                        <td scope="row" width="20%">
                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Details"
                                                                name="incident_report_details[]" 
                                                                v-model="incident_report.details"/>
                                                        </td>
                                                        <td>
                                                            

                                                            <input 
                                                                type="text" 
                                                                placeholder="Type Reported By"
                                                                name="incident_report_details[]" 
                                                                v-model="incident_report.reported_by"/>
                                                        </td>
                                                        <td scope="row" width="20%">
                                                            <button type="button" class="btn btn-success btn-sm" @click="add_new_incident_report()" v-if="incident_report.sl==form.incident_report_sl">Add</button>
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
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deletePropertyProject()">Delete</button>
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
                <div class="modal fade model-middle" id="ServiceProvider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content" style="width:800px;overflow-y: initial !important">
                      <div class="modal-header">
                            <h4 ><strong>Service Provider List</strong></h4>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>  
                      </div>
                      <div class="modal-body" style="height: 50vh; overflow-y: auto;">
                        <div class="form-holder">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>Name</td>
                                            <td>Phone</td>
                                            <td>Email</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="service_provider in service_provider_arr" style="cursor:pointer" @click="close_service_provider(service_provider)">
                                            <td>{{service_provider.first_name}} {{service_provider.middle_name}} {{service_provider.last_name}}</td>
                                            <td>{{service_provider.cell_phone}}</td>
                                            <td>{{service_provider.email}}</td>
                                        </tr>
                                    </tbody>
                                </table>
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
                    system_no:'',
                    system_prefix:'',
                    project_name:'',
                    page_id:6,
                    id:'',
                    subject_title:'',
                    current_status:'',
                    contractor_id_no:'',
                    contractor_id:'',
                    corporation_legal_name:'',
                    house_number:'',
                    street_number:'',
                    city:'',
                    state:'',
                    country:'',
                    zip_code:'',
                    office_phone:'',
                    cell_phone:'',
                    email:'',
                    fax_no:'',
                    website:'',
                    final_delivery_date:'',

                    main_company:'',
                    company_name:'',
                    customer_name:'',
                    residential_building_id:'',
                    residential_building_name:'',
                    commercial_building_id:'',
                    commercial_building_name:"",
                    residential_commercial_building_name:"",
                    residential_commercial_building_id:"",


                    floor_arr:[],
                    suite_arr:[],
                    subrooms_list_arr:[],
                    unit_arr:[],
                    parking_stall_arr:[],
                    unit_subrooms_list_arr:[],
                    parking_lot_arr:[],
                    bike_lot_arr:[],
                    storage_lot_arr:[],

                    bike_stall_arr:[],
                    storage_locker_arr:[],
                    mail_box_arr:[],
                    mail_room_arr:[],
                    common_area_arr:[],
                    service_room_arr:[],
                    inseurance_type_arr:[],
                    project_duration_arr:[],
                    payment_schedule_arr:[],
                    timeline_arr:[],
                    project_amount_arr:[],
                    total_aditional_amount:0,
                    total_aditional_tax:0,
                    total_deduction_amount:0,
                    total_deduction_tax:0,
                    total_amount:0,
                    total_tax:0,
                    incident_reports_arr:[],
                    additional_amount_sl:1,
                    deduction_amount_sl:1,
                    payment_schedule_sl:1,
                    incident_report_sl:1,
                    
                }),

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Project ID', field: 'system_no' },
                    { label: 'Project Name', field: 'project_name' },
                    { label: 'Subject Title', field: 'subject_title' },
                    { label: 'Current Status', field: 'current_status' },
                    { label: 'Building Type', field: 'building_type' },
                    { label: 'Building Name', field: 'building_name' },
                    { label: 'Contactor ID', field: 'contractor_id_no' },
                    { label: 'Contactor Name', field: 'contractor_name' },
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
                   
                ],

                bike_columns: [
                    { label: 'Action', field: '', sortable: false },
                    { label: 'Bike Lot No', field: 'mst_property_name' },
                    { label: 'Stall No', field: 'item_name' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'Level No', field: 'bike_level' },
                   
                ],

                storage_columns: [
                    { label: 'Action', field: '', sortable: false },
                    { label: 'Storage Lot No', field: 'mst_property_name' },
                    { label: 'Stall No', field: 'item_name' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'Level No', field: 'storage_level' },
                   
                ],

                mail_columns: [
                    { label: 'Action', field: '', sortable: false },
                    { label: 'Mailroom No', field: 'mst_property_name' },
                    { label: 'Mailbox No', field: 'item_name' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                   
                ],
                common_area_columns: [
                    { label: 'Action', field: '', sortable: false },
                    { label: 'Common Area', field: 'item_name' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                   
                   
                ],

                supporting_columns: [
                    { label: 'Action', field: '', sortable: false },
                    { label: 'Common Area', field: 'item_name' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                   
                ],

                test_collupsable:false,
                general_info_show:true,
                building_show:false,
                floor_show:false,
                suite_show:false,
                unit_show:false,
                bike_show:false,
                storage_show:false,
                mailroom_show:false,
                common_area_show:false,
                property_type_show:false,
                supporting_room_show:false,
                insurance_show:false,
                project_duration_show:false,
                timeline_show:false,
                amount_show:false,
                payment_schedule_show:false,
                incident_reports_show:false,
                stall_details_arr:[],
                details_level:"",
                details_stall:"",
                main_company_arr:[],
                countries:[],
                company_arr:[],
                customer_arr:[],
                building_arr:[],
                stall_type_arr:[],
                service_provider_arr:[],
                suite_expression:[],
                stall_type_arr_length:0,
                uom_arr:['','Square Feet','Square Meter','Square Yard'],
                page: 1,
                per_page:20,
                expanded: null,

            }
        },
        
        created: function()
        {
            this.user_menu_name = this.$route.name;
            this.fetchPropertyProject();
            //this.editPropertyProject(4);
           
        },
        
        computed:{


            
        },
        methods: {

            calculate_amount()
            {
                var total_amount=0;
                var total_tax=0;
                var total_aditional_amount=0;
                var total_aditional_tax=0;
                var total_deduction_amount=0;
                var total_deduction_tax=0;
                this.form.project_amount_arr.forEach(function(item,index){

                    if(item.amount_before_tax>0)
                    {

                        if(item.type==2)
                        {
                            total_aditional_amount+=(item.amount_before_tax)*1;
                            total_amount+=(item.amount_before_tax)*1;
                        }

                        else if(item.type==3)
                        {
                            total_deduction_amount+=(item.amount_before_tax)*1;
                            total_amount-=(item.amount_before_tax)*1;
                        }
                        else
                        {
                            total_amount+=(item.amount_before_tax)*1;
                        }
                    }

                    if(item.taxes>0)
                    {
                        if(item.type==2)
                        {
                            total_aditional_tax+=(item.taxes)*1;
                            total_tax+=(item.taxes)*1;
                        }
                        else if(item.type==3)
                        {
                            total_deduction_tax+=(item.taxes)*1;
                            total_tax-=(item.taxes)*1;
                        }
                        else
                        {
                            total_tax+=(item.taxes)*1;
                        }
                    }

                });


                this.form.total_amount=total_amount;
                this.form.total_tax=total_tax;
                this.form.total_aditional_amount=total_aditional_amount;
                this.form.total_aditional_tax=total_aditional_tax;
                this.form.total_deduction_amount=total_deduction_amount;
                this.form.total_deduction_tax=total_deduction_tax;


            },


            payment_schedule_add_calender(type,payment_schedule)
            {

                if(type==1)
                {
                    payment_schedule.is_callender=true;
                }
                else{

                     payment_schedule.is_callender=false;
                }

            },

            close_service_provider(service_provider)
            {
                $("#ServiceProvider").modal("hide");
                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove() ;

                this.form.corporation_legal_name    =service_provider.register_corp_first_name+" "+service_provider.register_corp_middle_name+" "+service_provider.register_corp_last_name;
                this.form.contractor_id             =service_provider.id;
                this.form.contractor_id_no          =service_provider.system_no;
                this.form.house_number              =service_provider.house_number;
                this.form.street_number             =service_provider.street_number;
                this.form.city                      =service_provider.city;
                this.form.state                     =service_provider.state;
                this.form.country                   =service_provider.country;
                this.form.zip_code                  =service_provider.zip_code;
                this.form.office_phone              =service_provider.register_corp_phone_no;
                this.form.cell_phone                =service_provider.cell_phone;
                this.form.email                     =service_provider.email;
                this.form.fax_no                    =service_provider.fax_no;
                this.form.website                   =service_provider.website;
            },

            service_provider_profile()
            {
                $("#ServiceProvider").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show');

                this.form.corporation_legal_name='';
                this.form.house_number="";
                this.form.street_number="";
                this.form.city="";
                this.form.state="";
                this.form.country="";
                this.form.zip_code="";
                this.form.office_phone="";
                this.form.cell_phone="";
                this.form.email="";
                this.form.fax_no="";
                this.form.website="";
            },




            fetchPropertyProject()
            {
                let uri = '/PropertyProjects';
                window.axios.get(uri).then((response) => {
                    
                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.countries                              =response.data.country_arr;
                    this.main_company_arr                       =response.data.main_company_arr;
                    this.form.main_company                      =response.data.main_company_id;
                    this.service_provider_arr                   =response.data.service_provider;
                    this.building_arr                           =response.data.building_arr;
                    for(let i=0; i<response.data.inseurance_type_arr.length; i++)
                    {
                        this.form.inseurance_type_arr.push({
                            'id':'',
                            'reference_id':response.data.inseurance_type_arr[i].id,
                            'item_name':response.data.inseurance_type_arr[i].val,
                            'company_name':'',
                            'address':'',
                            'policy_no':'',
                            'expire_date':'',
                            'max_coverage':'',
                        });
                    }
                    

                    this.form.project_duration_arr.push({
                            'id':'',
                            'item_name':'Initial Date',
                            'net_year':'',
                            'net_days':'',
                            'to_date':'',
                            'from_date':'',
                        });

                    this.form.project_duration_arr.push({
                            'id':'',
                            'item_name':'Extended Date 1',
                            'net_year':'',
                            'net_days':'',
                            'to_date':'',
                            'from_date':'',
                        });

                    this.form.timeline_arr.push({
                            'id':'',
                            'task_details':'',
                            'hours':'',
                            'days':'',
                            'from_date':'',
                            'to_date':'',
                            'resedule_from_date1':'',
                            'resedule_to_date1':'',
                            'resedule_from_date2':'',
                            'resedule_to_date2':'',
                            'resedule_from_date3':'',
                            'resedule_to_date3':'',
                            'task_status':'',
                        });

                    this.form.project_amount_arr.push({
                            'id':'',
                            'type':'1',
                            'title':'Initial',
                            'amount_before_tax':'',
                            'taxes':'',
                            'sl':'1',
                        });

                    this.form.project_amount_arr.push({
                            'id':'',
                            'type':'2',
                            'title':'Addition 1',
                            'amount_before_tax':'',
                            'taxes':'',
                            'sl':'1',
                        });
                    this.form.project_amount_arr.push({
                            'id':'',
                            'type':'3',
                            'title':'Deductions 1',
                            'amount_before_tax':'',
                            'taxes':'',
                            'sl':'1',
                        });

                    this.form.payment_schedule_arr.push({
                            'id':'',
                            'title':'Payment No 1',
                            'due_date':'',
                            'is_callender':'',
                            'sl':'1',
                        });

                    this.form.incident_reports_arr.push({
                            'id':'',
                            'details':'',
                            'incident_date':'',
                            'reported_by':'',
                            'sl':'1',
                        });


                });
                 
            },

            add_new_payment_schdule()
            {
                this.form.payment_schedule_sl++;
                this.form.payment_schedule_arr.push({
                    'id':'',
                    'title':'Payment No '+this.form.payment_schedule_sl,
                    'due_date':'',
                    'is_callender':'',
                    'sl':this.form.payment_schedule_sl,
                });
            },

            add_new_incident_report()
            {
                this.form.incident_report_sl++;
                this.form.incident_reports_arr.push({
                    'id':'',
                    'details':'',
                    'incident_date':'',
                    'reported_by':'',
                    'sl':this.form.incident_report_sl,
                });
            },

            add_new_amount(type){

                if(type==1)
                {
                    this.form.additional_amount_sl++;

                    this.form.project_amount_arr.push({
                        'id':'',
                        'type':'2',
                        'title':'Addition '+this.form.additional_amount_sl,
                        'amount_before_tax':'',
                        'taxes':'',
                        'sl':this.form.additional_amount_sl,
                    });
                }
                else if(type==2)
                {

                    this.form.deduction_amount_sl++;
                    this.form.project_amount_arr.push({
                        'id':'',
                        'type':'3',
                        'title':'Deductions '+this.form.deduction_amount_sl,
                        'amount_before_tax':'',
                        'taxes':'',
                        'sl':+this.form.deduction_amount_sl,
                    });
                }

                
            },


            add_new_timeline()
            {

                this.form.timeline_arr.push({
                            'id':'',
                            'task_details':'',
                            'hours':'',
                            'days':'',
                            'to_date':'',
                            'from_date':'',
                            'to_date':'',
                            'resedule_from_date1':'',
                            'resedule_to_date1':'',
                            'resedule_from_date2':'',
                            'resedule_to_date2':'',
                            'resedule_from_date3':'',
                            'resedule_to_date3':'',
                            'task_status':'',
                        });
            },

            add_new_project_duration(index)
            {
                let id=index+1;
                this.form.project_duration_arr.push({
                            'id':'',
                            'item_name':'Extended Date '+id,
                            'net_year':'',
                            'net_days':'',
                            'to_date':'',
                            'from_date':'',
                        });
            },

            
            editPropertyProject(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/PropertyProjects/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    

                    this.editmode=true;
                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.form.floor_arr                         =response.data.floor_arr;
                    this.building_arr                           =response.data.building_arr;
                    this.form.id                                =response.data.master_property_arr.id;
                    this.form.system_no                         =response.data.master_property_arr.system_no;
                    this.form.project_name                      =response.data.master_property_arr.project_name;
                    this.form.subject_title                     =response.data.master_property_arr.subject_title;
                    this.form.current_status                    =response.data.master_property_arr.current_status;
                    this.form.building_type                     =response.data.master_property_arr.building_type;
                    this.form.building_id                       =response.data.master_property_arr.building_id ;
                    this.form.contractor_id_no                  =response.data.master_property_arr.contractor_id_no;
                    this.form.contractor_id                     =response.data.master_property_arr.contractor_id;
                    this.form.house_number                      =response.data.service_provider_arr.house_number;
                    this.form.corporation_legal_name            =response.data.service_provider_arr.register_corp_first_name+" "+response.data.service_provider_arr.register_corp_middle_name+" "+response.data.service_provider_arr.register_corp_last_name;
                    this.form.street_number                     =response.data.service_provider_arr.street_number;
                    this.form.city                              =response.data.service_provider_arr.city;
                    this.form.state                             =response.data.service_provider_arr.state;
                    this.form.country                           =response.data.service_provider_arr.country;
                    this.form.zip_code                          =response.data.service_provider_arr.zip_code;
                    this.form.office_phone                      =response.data.service_provider_arr.office_phone;
                    this.form.cell_phone                        =response.data.service_provider_arr.cell_phone;
                    this.form.email                             =response.data.service_provider_arr.email;
                    this.form.fax_no                            =response.data.service_provider_arr.fax_no;
                    this.form.website                           =response.data.service_provider_arr.website;

                    if(this.form.building_type==1)
                    {
                        this.form.residential_building_id=this.form.building_id;
                        this.form.residential_building_name=this.building_arr[this.form.residential_building_id].building_name;
                        this.form.residential_commercial_building_name="";
                        this.form.residential_commercial_building_id="";
                        this.form.commercial_building_id='';
                        this.form.commercial_building_name="";
                    }
                    else if(this.form.building_type==2)
                    {
                        this.form.commercial_building_id=this.form.building_id;
                        this.form.commercial_building_name=this.building_arr[this.form.commercial_building_id].building_name;
                        this.form.residential_commercial_building_name="";
                        this.form.residential_commercial_building_id="";
                        this.form.residential_building_id='';
                        this.form.residential_building_name='';
                    }
                    else if(this.form.building_type==3)
                    {
                        this.form.residential_commercial_building_id=this.form.building_id;
                        this.form.residential_commercial_building_name=this.building_arr[this.form.residential_commercial_building_id].building_name;
                        this.form.commercial_building_id='';
                        this.form.commercial_building_name="";
                        this.form.residential_building_id='';
                        this.form.residential_building_name='';
                    }

                    this.form.floor_arr                                =response.data.floor_arr;
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
                    this.form.suite_arr                                =response.data.suite_arr;
                    this.form.subrooms_list_arr                        =response.data.subrooms_list_arr;
                    this.form.unit_arr                                 =response.data.unit_arr;
                    this.form.unit_subrooms_list_arr                   =response.data.unit_subrooms_list_arr;
            
                   // this.change_stall_size();

                  

                }); 

                this.tempeditmode=false;
                
            },

            
            reset_form()
            {

                this.form.reset();
                this.editmode=false;
                this.list_showable=false;
                this.fetchPropertyProject();
            },

            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/PropertyProjectsList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.property_project_list;
                });
                this.list_showable=true;
            },

            
            

           

            change_building(type)
            {

                var uri="";
                if(type==1)
                {
                    this.form.residential_building_name=this.building_arr[this.form.residential_building_id].building_name;
                    this.form.residential_commercial_building_name="";
                    this.form.residential_commercial_building_id="";
                    this.form.commercial_building_id='';
                    this.form.commercial_building_name="";
                    uri = '/ProjectByBuilding/'+this.form.residential_building_id;
                }
                else if(type==2)
                {
                    this.form.commercial_building_name=this.building_arr[this.form.commercial_building_id].building_name;
                    this.form.residential_commercial_building_name="";
                    this.form.residential_commercial_building_id="";
                    this.form.residential_building_id='';
                    this.form.residential_building_name='';
                    uri = '/ProjectByBuilding/'+this.form.commercial_building_id;
                }
                else if(type==3)
                {
                    this.form.residential_commercial_building_name=this.building_arr[this.form.residential_commercial_building_id].building_name;
                    this.form.commercial_building_id='';
                    this.form.commercial_building_name="";
                    this.form.residential_building_id='';
                    this.form.residential_building_name='';
                    uri = '/ProjectByBuilding/'+this.form.residential_commercial_building_id;
                }
                
               

                //let uri = '/ProjectByBuilding/'+this.form.building_id;
                window.axios.get(uri).then((response) => {
                    this.form.floor_arr                                =response.data.floor_arr;
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
                    this.form.suite_arr                                =response.data.suite_arr;
                    this.form.subrooms_list_arr                        =response.data.subrooms_list_arr;
                    this.form.unit_arr                                 =response.data.unit_arr;
                    this.form.unit_subrooms_list_arr                   =response.data.unit_subrooms_list_arr;
                   
                });
            },
            

            check_suite_sub_room(e,row)
            {
                if(e.target.checked)
                {
                    row.allocated=true;
                }
                else
                {
                    row.allocated=false;
                }
            },

            check_unit_sub_room(e,row)
            {
                if(e.target.checked)
                {
                    row.allocated=true;
                }
                else
                {
                    row.allocated=false;
                }
            },
            check_bike_stall(e,row)
            {
                if(e.target.checked)
                {
                    row.allocated=true;
                }
                else
                {
                    row.allocated=false;
                }
            },

            check_parking_stall(e,row)
            {
            
                if(e.target.checked)
                {
                    row.allocated=true;
                }
                else
                {
                    row.allocated=false;
                }
            },

            check_storage_locker(e,row)
            {
                if(e.target.checked)
                {
                    row.allocated=true;
                }
                else
                {
                    row.allocated=false;
                }
            },

            check_common_area(e,row)
            {
                if(e.target.checked)
                {
                    row.allocated=true;
                }
                else
                {
                    row.allocated=false;
                }

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
                }
            },
            
            check_mail_box(e,row)
            {
                if(e.target.checked)
                {
                    row.allocated=true;
                }
                else
                {
                    row.allocated=false;
                }
            },


            show_hide_project_duration()
            {
                if(this.project_duration_show)
                {
                    this.project_duration_show=false;
                }
                else{
                    this.project_duration_show=true;
                }
            },


            show_hide_incident_reports(){

                if(this.incident_reports_show)
                {
                    this.incident_reports_show=false;
                }
                else{
                    this.incident_reports_show=true;
                }
            }, 

            show_hide_timeline(){
                if(this.timeline_show)
                {
                    this.timeline_show=false;
                }
                else{
                    this.timeline_show=true;
                }
            }, 

            show_hide_amount(){

                if(this.amount_show)
                {
                    this.amount_show=false;
                }
                else{

                    this.amount_show=true;
                }
            }, 

            show_hide_payment_schedule()
            {
                if(this.payment_schedule_show)
                {
                    this.payment_schedule_show=false;
                }
                else{

                    this.payment_schedule_show=true;
                }
            },        
            
            show_hide_insurance(){
                if(this.insurance_show)
                {
                    this.insurance_show=false;
                }
                else{
                    this.insurance_show=true;
                }
            },

            show_hide_floor_list()
            {
                if(this.floor_show)
                {
                    this.floor_show=false;
                }
                else{
                    this.floor_show=true;
                }
            },
            show_hide_suite(suite)
            {
                if(suite.toggle)
                {
                    suite.toggle=false;
                }
                else{
                    suite.toggle=true;
                }
            },

            show_hide_unit(unit)
            {
                if(unit.toggle)
                {
                    unit.toggle=false;
                }
                else{
                    unit.toggle=true;
                }
            },

            show_hide_floor(floor)
            {
                if(floor.toggle)
                {
                    floor.toggle=false;
                }
                else{
                    floor.toggle=true;
                }
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


            show_hide_general_info(){
                if(this.general_info_show)
                {
                    this.general_info_show=false;
                }
                else{
                    this.general_info_show=true;
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
                    this.form.delete('/PropertyProjects/'+id).then(()=>{
                        
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
    
            deletePropertyProject()
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
                    this.form.delete('/PropertyProjects/'+this.form.id).then(()=>{
                        
                        if(result.value) {
                            Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.fetchPropertyProject();
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
            },
      

            updateProject()
            { 
                

                this.form.put('/PropertyProjects/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        
                        this.editPropertyProject(response_data[1]);
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

                this.form.post('/PropertyProjects') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });

                        if(type==1)
                        {
                            this.editPropertyProject(response_data[1]);
                            this.editmode=true;
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                        }
                        else if(type==3)
                        {
                            this.form.reset();
                            this.fetchPropertyProject();
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