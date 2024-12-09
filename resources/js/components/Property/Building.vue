<template>

  <fieldset>
    <form id="msform" @submit.prevent="editmode ? updateBuildingInfo() : createCompanyProfile()" @keydown="form.onKeydown($event)">
      <div class="form-card">
        <h1 class="page-head">Building Information</h1>
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
          <vue3-datatable :rows="rows" :columns="columns" :sortable="true" class="advanced-table whitespace-nowrap">
            <template #sl="data">
              <strong class="text-info">{{ data.value.sl }}</strong>
            </template>
            <template #building_no="data">
              <span class="font-semibold">{{ data.value.building_no }}</span>
            </template>
            <template #building_name="data">
              <span class="font-semibold">{{ data.value.building_name }}</span>
            </template>
            <template #number_of_floor="data">
              <span class="font-semibold">{{ data.value.number_of_floor }}</span>
            </template>
            <template #dependency_class="data">
              <span class="font-semibold">{{ data.value.dependency_class }}</span>
            </template>
            <template #property_type="data">
              <span class="font-semibold">{{ data.value.property_type }}</span>
            </template>
            <template #buttons="data">
              <button class="btn btn-primary btn-sm" @click.prevent="editBuildingInfo(data.value.id)">Edit</button>
              <button class="btn btn-danger btn-sm" @click.prevent="BuildingDelete(data.value.id)">Delete</button>
            </template>
          </vue3-datatable>
        </div>
        <div v-if="!list_showable">
          <div class="form-folder">
            <h3><i class="fa fa-hand-point-right"></i> General Information:
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="!general_info_show">Show</button>
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_general_info()" v-show="general_info_show">Hide</button>
            </h3>
            <div class="form-holder" v-show="general_info_show">
              <div class="row align-self-stretch">
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="form-box-outer">
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="fieldlabels">Building No:</label>
                        <input v-model="form.building_no" type="text" name="building_no" placeholder="Auto Generated"
                        :class="{ 'is-invalid': form.errors.has('building_no') }" disabled/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="fieldlabels">Building Name:</label>
                        <input v-model="form.building_name" type="text" name="building_name" placeholder="Type Building Name" :class="{ 'is-invalid': form.errors.has('building_name') }"/>
                        <div v-if="form.errors.has('building_name')" v-html="form.errors.get('building_name')" />

                        <label class="fieldlabels">Strata lot No:</label>
                        <input v-model="form.strata_lot_no" type="text" name="strata_lot_no" placeholder="Type Building Name" :class="{ 'is-invalid': form.errors.has('strata_lot_no') }"/>
                        <div v-if="form.errors.has('strata_lot_no')" v-html="form.errors.get('strata_lot_no')" />

                        <label class="fieldlabels">UOM:</label>
                        <select v-model="form.building_uom" name="building_uom" class="custom-select" :class="{ 'is-invalid': form.errors.has('building_uom') }" >
                          <option  value="">--Select UOM-- </option>
                          <option value="1">Square Feet</option>
                          <option value="2">Square Meter</option>
                          <option value="3">Square Yard</option>
                        </select>

                        <label class="fieldlabels">Building Size:</label>
                        <input v-model="form.total_building_size" type="number" name="total_building_size" placeholder="Type Building Size" :class="{ 'is-invalid': form.errors.has('total_building_size') }"/>
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
                        <input v-model="form.number_of_floor" type="number" name="number_of_floor" placeholder="Type Floors Number" :class="{ 'is-invalid': form.errors.has('number_of_floor') }"/>
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="fieldlabels">Roof Top:</label>
                        <input v-model="form.number_of_roof_top" type="number" name="number_of_roof_top" @change="generate_floor(1)" placeholder="Type Upper" :class="{ 'is-invalid': form.errors.has('number_of_roof_top') }"/>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="fieldlabels">Upper:</label>
                        <input v-model="form.number_of_upper_floor" type="number" name="number_of_upper_floor" @change="generate_floor(2)" placeholder="Type Upper" :class="{ 'is-invalid': form.errors.has('number_of_upper_floor') }"/>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="fieldlabels">Ground:</label>
                        <input v-model="form.number_of_ground_floor" type="number" name="number_of_ground_floor" @change="generate_floor(3)" placeholder="Type Ground" :class="{ 'is-invalid': form.errors.has('number_of_ground_floor') }"/>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="fieldlabels">Under Ground:</label>
                        <input v-model="form.number_of_under_ground" type="number" name="number_of_under_ground" @change="generate_floor(4)" placeholder="Type Under Ground" :class="{ 'is-invalid': form.errors.has('number_of_under_ground') }"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="form-box-outer">
                    <h4>Dependency Class:</h4>
                    <div class="form-holder">
                      <div class="form-check-inline">
                        <input type="checkbox" id="dependent_building" name="dependent_building" @click="check_building_dependency($event,1)" v-model="form.dependent_building">
                        <label for="dependent_building">Dependent</label><br>
                        <input type="checkbox"  id="independent_building" name="independent_building" @click="check_building_dependency($event,2)" v-model="form.independent_building">
                        <label for="independent_building">Independent</label><br>
                      </div>
                    </div>

                    <h4>Property Type:</h4>
                    <div class="form-holder">
                      <div class="form-check-inline">
                        <input type="checkbox" id="residential" name="residential" @click="check_property_type($event,1)" v-model="form.residential">
                        <label for="residential">Residential</label><br>

                        <input type="checkbox" id="commercial" name="commercial" @click="check_property_type($event,2)" v-model="form.commercial" >
                        <label for="commercial">Commercial</label><br>

                        <input type="checkbox" id="residential_commercial" name="residential_commercial" @click="check_property_type($event,3)" v-model="form.residential_commercial">
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
            <h3><i class="fa fa-hand-point-right"></i>Property Details
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property()" v-show="!property_show">Show</button>
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property()" v-show="property_show">Hide</button>
            </h3>
            <div class="form-holder" v-show="property_show">
              <h4>Roof Top</h4>
              <div class="row align-self-stretch">
                <div class="col-md-4 col-sm-6 col-xs-12" v-for="(roof_top,index) in form.roof_top_arr" style="margin-bottom:20px">
                  <div class="form-box-outer">
                    <table class="table table_narrow"  >
                      <thead>
                        <tr>
                          <th scope="col" width="60%">Roof Top Floor No {{roof_top.floor_no}} </th>
                          <th scope="col">Qty</th>
                        </tr>
                      </thead>
                      <tbody style="border:none">
                        <tr>
                          <td scope="row">Residential Suites</td>
                          <td>
                            <input style=" margin:0" type="number" v-bind:id="'roof_top_suite'+index" placeholder="Type Qty" name="roof_top_suite[]" v-model="roof_top.suites"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Commercial Units</td>
                          <td>
                            <input type="number" v-bind:id="'roof_top_units'+index" placeholder="Type Qty" name="roof_top_units[]" v-model="roof_top.units"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Mechanical Rooms</td>
                          <td>
                            <input type="number" v-bind:id="'roof_top_mechanical_rooms'+index" placeholder="Type Qty" name="roof_top_mechanical_rooms[]" v-model="roof_top.mechanical_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Administrative Room</td>
                          <td>
                            <input type="number" v-bind:id="'roof_top_administrative_rooms'+index" placeholder="Type Qty" name="roof_top_administrative_rooms[]" v-model="roof_top.administrative_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Amenity Rooms</td>
                          <td>
                            <input type="number" v-bind:id="'roof_top_amenity_rooms'+index" placeholder="Type Qty" name="roof_top_amenity_rooms[]" v-model="roof_top.amenity_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Service Rooms</td>
                          <td>
                            <input type="number" v-bind:id="'roof_top_service_rooms'+index" placeholder="Type Qty" name="roof_top_service_rooms[]" v-model="roof_top.service_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Parking Level</td>
                          <td>
                            <input type="number" v-bind:id="'roof_top_parking_lot'+index" placeholder="Type Qty" name="roof_top_parking_lot[]" v-model="roof_top.parking_lot"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Bike Lot</td>
                          <td>
                            <input type="number" v-bind:id="'roof_top_bike_lot'+index" placeholder="Type Qty" name="roof_top_bike_lot[]" v-model="roof_top.bike_lot"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Storage Lot</td>
                          <td>
                            <input type="number" v-bind:id="'roof_top_storage_lot'+index" placeholder="Type Qty" name="roof_top_storage_lot[]" v-model="roof_top.storage_lot"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Mail Room</td>
                          <td>
                            <input type="number" v-bind:id="'roof_top_mailroom'+index" placeholder="Type Qty" name="roof_top_mailroom[]" v-model="roof_top.mailroom"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Common Area</td>
                          <td>
                            <input type="number" v-bind:id="'roof_top_common_area'+index" placeholder="Type Qty" name="roof_top_common_area[]" v-model="roof_top.common_area"/>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <hr>
              </div>

              <h4>Upper Floors</h4>
              <div class="row align-self-stretch">
                <div class="col-md-4 col-sm-6 col-xs-12" v-for="(upper_floor,index) in form.upper_building_arr" style="margin-bottom:20px">
                  <div class="form-box-outer">
                    <table class="table table_narrow">
                      <thead>
                        <tr>
                          <th scope="col" width="60%">Upper Floor No {{upper_floor.floor_no}} </th>
                          <th scope="col">Qty</th>
                        </tr>
                      </thead>
                      <tbody style="border:none">
                        <tr>
                          <td scope="row">Residential Suites</td>
                          <td>
                            <input style=" margin:0" type="number" v-bind:id="'upper_floor_suites'+index" placeholder="Type Qty" name="upper_floor_suites[]" v-model="upper_floor.suites"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Commercial Units</td>
                          <td>
                            <input type="number" v-bind:id="'upper_floor_units'+index" placeholder="Type Qty" name="upper_floor_units[]" v-model="upper_floor.units"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Mechanical Rooms</td>
                          <td>
                            <input type="number" v-bind:id="'upper_floor_mechanical_rooms'+index" placeholder="Type Qty" name="upper_floor_mechanical_rooms[]" v-model="upper_floor.mechanical_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Administrative Room</td>
                          <td>
                            <input type="number" v-bind:id="'upper_floor_administrative_rooms'+index" placeholder="Type Qty" name="upper_floor_administrative_rooms[]" v-model="upper_floor.administrative_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Amenity Rooms</td>
                          <td>
                            <input type="number" v-bind:id="'upper_floor_amenity_rooms'+index" placeholder="Type Qty" name="upper_floor_amenity_rooms[]" v-model="upper_floor.amenity_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Service Rooms</td>
                          <td>
                            <input type="number" v-bind:id="'upper_floor_service_rooms'+index" placeholder="Type Qty" name="upper_floor_service_rooms[]" v-model="upper_floor.service_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Parking Level</td>
                          <td>
                            <input type="number" v-bind:id="'upper_floor_parking_lot'+index" placeholder="Type Qty" name="upper_floor_parking_lot[]" v-model="upper_floor.parking_lot"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Bike Lot</td>
                          <td>
                            <input type="number" v-bind:id="'upper_floor_bike_lot'+index" placeholder="Type Qty" name="upper_floor_bike_lot[]" v-model="upper_floor.bike_lot"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Storage Lot</td>
                          <td>
                            <input type="number" v-bind:id="'upper_floor_storage_lot'+index" placeholder="Type Qty" name="upper_floor_storage_lot[]" v-model="upper_floor.storage_lot"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Mail Room</td>
                          <td>
                            <input type="number" v-bind:id="'upper_floor_mailroom'+index" placeholder="Type Qty" name="upper_floor_mailroom[]" v-model="upper_floor.mailroom"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Common Area</td>
                          <td>
                            <input type="number" v-bind:id="'upper_floor_common_area'+index" placeholder="Type Qty" name="upper_floor_common_area[]" v-model="upper_floor.common_area"/>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <hr>
              </div>

              <h4>Ground Floors</h4>
              <div class="row align-self-stretch">
                <div class="col-md-4 col-sm-6 col-xs-12" v-for="(ground_floor,index) in form.ground_building_arr" style="margin-bottom:20px">
                  <div class="form-box-outer">
                    <table class="table table_narrow">
                      <thead>
                        <tr>
                          <th scope="col" width="60%">Ground Floor No {{ground_floor.floor_no}} </th>
                          <th scope="col">Qty</th>
                        </tr>
                      </thead>
                      <tbody style="border:none">
                        <tr>
                          <td scope="row">Residential Suites</td>
                          <td>
                            <input style=" margin:0" type="number" v-bind:id="'ground_floor_suites'+index" placeholder="Type Qty" name="ground_floor_suites[]" v-model="ground_floor.suites"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Commercial  Units</td>
                          <td>
                            <input type="number" v-bind:id="'ground_floor_units'+index" placeholder="Type Qty" name="ground_floor_units[]" v-model="ground_floor.units"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Mechanical Rooms</td>
                          <td>
                            <input type="number" v-bind:id="'ground_floor_mechanical_rooms'+index" placeholder="Type Qty" name="ground_floor_mechanical_rooms[]" v-model="ground_floor.mechanical_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Administrative Room</td>
                          <td>
                            <input type="number" v-bind:id="'ground_floor_administrative_rooms'+index" placeholder="Type Qty" name="ground_floor_administrative_rooms[]" v-model="ground_floor.administrative_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Amenity Rooms</td>
                          <td>
                            <input type="number" v-bind:id="'ground_floor_amenity_rooms'+index" placeholder="Type Qty" name="ground_floor_amenity_rooms[]" v-model="ground_floor.amenity_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Service Rooms</td>
                          <td>
                            <input type="number" v-bind:id="'ground_floor_service_rooms'+index" placeholder="Type Qty" name="ground_floor_service_rooms[]" v-model="ground_floor.service_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Parking Lot</td>
                          <td>
                            <input type="number" v-bind:id="'ground_floor_parking_lot'+index" placeholder="Type Qty" name="ground_floor_parking_lot[]" v-model="ground_floor.parking_lot"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Bike Lot</td>
                          <td>
                            <input type="number" v-bind:id="'ground_floor_bike_lot'+index" placeholder="Type Qty" name="ground_floor_bike_lot[]" v-model="ground_floor.bike_lot"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Storage Lot</td>
                          <td>
                            <input type="number" v-bind:id="'ground_floor_storage_lot'+index" placeholder="Type Qty" name="ground_floor_storage_lot[]" v-model="ground_floor.storage_lot"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Mail Room</td>
                          <td>
                            <input type="number" v-bind:id="'ground_floor_mailroom'+index" placeholder="Type Qty" name="ground_floor_mailroom[]" v-model="ground_floor.mailroom"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Common Area</td>
                          <td>
                            <input type="number" v-bind:id="'ground_floor_common_area'+index" placeholder="Type Qty" name="ground_floor_common_area[]" v-model="ground_floor.common_area"/>
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
                          <td scope="row">Commercial Suites</td>
                          <td>
                            <input style=" margin:0" type="number" v-bind:id="'under_ground_suites'+index" placeholder="Type Qty" name="under_ground_suites[]" v-model="under_ground_floor.suites"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Commercial Units</td>
                          <td>
                            <input type="number" v-bind:id="'under_ground_units'+index" placeholder="Type Qty" name="under_ground_units[]" v-model="under_ground_floor.units"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Mechanical Rooms</td>
                          <td>
                            <input type="number" v-bind:id="'under_ground_mechanical_rooms'+index" placeholder="Type Qty" name="under_ground_mechanical_rooms[]" v-model="under_ground_floor.mechanical_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Administrative Room</td>
                          <td>
                            <input type="number" v-bind:id="'under_ground_administrative_rooms'+index" placeholder="Type Qty" name="under_ground_administrative_rooms[]" v-model="under_ground_floor.administrative_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Amenity Rooms</td>
                          <td>
                            <input type="number" v-bind:id="'under_ground_amenity_rooms'+index" placeholder="Type Qty" name="under_ground_amenity_rooms[]" v-model="under_ground_floor.amenity_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Service Rooms</td>
                          <td>
                            <input type="number" v-bind:id="'under_ground_service_rooms'+index" placeholder="Type Qty" name="under_ground_service_rooms[]" v-model="under_ground_floor.service_rooms"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Parking Lot</td>
                          <td>
                            <input type="number" v-bind:id="'under_ground_parking_lot'+index" placeholder="Type Qty" name="under_ground_parking_lot[]" v-model="under_ground_floor.parking_lot"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Bike Lot</td>
                          <td>
                            <input type="number" v-bind:id="'under_ground_bike_lot'+index" placeholder="Type Qty" name="under_ground_bike_lot[]" v-model="under_ground_floor.bike_lot"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Storage Lot</td>
                          <td>
                            <input type="number" v-bind:id="'under_ground_storage_lot'+index" placeholder="Type Qty" name="under_ground_storage_lot[]" v-model="under_ground_floor.storage_lot"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Mail Room</td>
                          <td>
                            <input type="number" v-bind:id="'under_ground_mailroom'+index" placeholder="Type Qty" name="under_ground_mailroom[]" v-model="under_ground_floor.mailroom"/>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row">Common Area</td>
                          <td>
                            <input type="number" v-bind:id="'under_ground_common_area'+index" placeholder="Type Qty" name="under_ground_common_area[]" v-model="under_ground_floor.common_area"/>
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

          <div class="form-folder">
            <h3><i class="fa fa-hand-point-right"></i> Property Management Type
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property_management()" v-show="!property_management_show">Show</button>
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property_management()" v-show="property_management_show">Hide</button>
            </h3>
            <div class="form-holder" v-show="property_management_show">
              <div class="row align-self-stretch">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-box-outer">
                    <table class="table table_narrow">
                      <thead>
                        <tr class="header">
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
                          <td>
                            <input type="text" placeholder="Type ID-No" v-bind:id="'management_id_no_'+index" name="management_id_no[]" v-model="property_management_type.id_no"/>
                          </td>
                          <td>
                            <input type="text" placeholder="Type Name" v-bind:id="'management_name_'+index"name="management_name[]" v-model="property_management_type.name"/>
                          </td>
                          <td>
                            <input type="url" placeholder="Type Website" v-bind:id="'management_website_'+index" name="management_website[]" v-model="property_management_type.website"/>
                          </td>
                          <td>
                            <input type="text" placeholder="Type Mobile" v-bind:id="'management_mobile_'+index" name="management_mobile[]" v-model="property_management_type.mobile"/>
                          </td>
                          <td>
                            <input type="text" placeholder="Type Phone" v-bind:id="'management_phone_'+index" name="management_phone[]" v-model="property_management_type.phone"/>
                          </td>
                          <td>
                            <input type="email" placeholder="Type Email" v-bind:id="'management_email_'+index" name="management_email[]" v-model="property_management_type.email"/>
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
            <h3><i class="fa fa-hand-point-right"></i> License and Permits
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_licence()" v-show="!licence_show">Show</button>
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_licence()" v-show="licence_show">Hide</button>
            </h3>
            <div class="form-holder" v-show="licence_show">
              <div class="row align-self-stretch">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-box-outer">
                    <table class="table table_narrow">
                      <thead>
                        <tr class="header">
                          <td scope="col" >Particular</td>
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
                            <input type="text" placeholder="Type Item Name" v-bind:id="'license_and_permit_item_name_'+index" name="item_name[]" v-model="license_and_permit.item_name"/>
                          </td>
                          <td>
                            <input type="text" placeholder="Type Issued By" v-bind:id="'license_and_permit_issued_by_'+index" name="license_and_permit_issued_by[]" v-model="license_and_permit.issued_by"/>
                          </td>
                          <td>
                            <date-picker
                                style="width:100%"
                                v-model="license_and_permit.expiry_date"
                                name="expiry_date"
                                lang="en"
                                type="expiry_date"
                                format="ddd, MMM D, YYYY"
                                :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
                          </td>
                          <td>
                            <input type="url" placeholder="Type Website" v-bind:id="'license_website_'+index" name="license_website[]" v-model="license_and_permit.website"/>
                          </td>
                          <td>
                            <input type="text" placeholder="Type Mobile" v-bind:id="'license_mobile_'+index" name="license_mobile[]" v-model="license_and_permit.mobile"/>
                          </td>
                          <td>
                            <input type="text" placeholder="Type Phone" v-bind:id="'license_phone_'+index" name="license_phone[]" v-model="license_and_permit.phone"/>
                          </td>
                          <td>
                            <input type="email" placeholder="Type Email" v-bind:id="'license_email_'+index" name="license_email[]" v-model="license_and_permit.email"/>
                          </td>
                          <td>
                            <input type="text" placeholder="Type Comments" v-bind:id="'license_comments_'+index" name="license_comments[]" v-model="license_and_permit.comment"/>
                          </td>
                        </tr>
                      </template>
                      <tr>
                        <td><button type="button" class="btn btn-primary btn-sm" @click="add_license_permit()">Add</button></td>
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
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_safety_equipment()" v-show="!safety_equipment_show">Show</button>
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_safety_equipment()" v-show="safety_equipment_show">Hide</button>
            </h3>
            <div class="form-holder" v-show="safety_equipment_show">
              <div class="row align-self-stretch">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-box-outer">
                    <table class="table table_narrow">
                      <thead>
                        <tr>
                          <th scope="col" rowspan="2">Safety Item</th>
                          <th scope="col" rowspan="2">Qty</th>
                          <th scope="col" rowspan="2">Serial No</th>
                          <th scope="col" rowspan="2">Floor No</th>
                          <th scope="col" rowspan="2">Expiry Date</th>
                          <th scope="col" rowspan="2">Renew Date</th>
                          <th scope="col" colspan="2">Inspection</th>
                        </tr>
                        <tr>
                          <th scope="col">Cycle</th>
                          <th scope="col">Due On</th>
                        </tr>
                      </thead>
                      <tbody style="border:none">
                      <template v-for="(safety_item_list,index) in form.safety_item_list_arr">
                        <tr style="background-color: #e7e8e7">
                          <td scope="row" width="13%">{{safety_item_list.item_name}}</td>
                          <td width="10%">
                            <input type="number" placeholder="Type Qty" v-bind:id="'item_qty_'+index" name="item_qty[]" v-model="safety_item_list.item_qty"/>
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
                            <tr>
                              <td scope="row" width="13%">{{safety_item.reference_name}}</td>
                              <td>
                                <input type="text" placeholder="Type Remarks" v-bind:id="'comment_'+index" name="comments[]" v-model="safety_item.comments"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Serial No" v-bind:id="'serial_no_'+index" name="item_qty[]" v-model="safety_item.serial_no"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Floor No" v-bind:id="'floor_no_'+index" name="item_qty[]" v-model="safety_item.floor_no"/>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.expiry_date"
                                    name="comment_date"
                                    lang="en"
                                    type="comment_date"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
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
                              </td>
                              <td>
                                <select v-model="safety_item.cicle" name="cicle[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('cicle') }">
                                  <option disabled value="">--Select-- </option>
                                  <option value="1">Daily</option>
                                  <option value="2">Weekly</option>
                                  <option value="3">Semi Monthly</option>
                                  <option value="4">Monthly</option>
                                  <option value="5">Quarterly</option>
                                  <option value="6">Yearly</option>
                                </select>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.due_on"
                                    name="due_on[]"
                                    lang="en"
                                    type="due_on"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                              </td>
                            </tr>
                          </template>
                        </template>

                        <template v-if="safety_item_list.refernece_id==2">
                          <template v-for="(safety_item,index) in form.smoke_detecter_details_arr" >
                            <tr>
                              <td scope="row" width="13%">{{safety_item.reference_name}}</td>
                              <td>
                                <input type="text" placeholder="Type Remarks" v-bind:id="'comment_'+index" v-model="safety_item.comments"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Serial No" v-bind:id="'serial_no_'+index" name="item_qty[]" v-model="safety_item.serial_no"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Floor No" v-bind:id="'floor_no_'+index" name="item_qty[]" v-model="safety_item.floor_no"/>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.expiry_date"
                                    name="comment_date"
                                    lang="en"
                                    type="comment_date"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
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
                              </td>
                              <td>
                                <select v-model="safety_item.cicle" name="cicle[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('cicle') }">
                                  <option disabled value="">--Select-- </option>
                                  <option value="1">Daily</option>
                                  <option value="2">Weekly</option>
                                  <option value="3">Semi Monthly</option>
                                  <option value="4">Monthly</option>
                                  <option value="5">Quarterly</option>
                                  <option value="6">Yearly</option>
                                </select>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.due_on"
                                    name="due_on[]"
                                    lang="en"
                                    type="due_on"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                              </td>
                            </tr>
                          </template>
                        </template>
                        <template v-if="safety_item_list.refernece_id==3">
                          <template v-for="(safety_item,index) in form.sprinkler_details_arr" >
                            <tr>
                              <td scope="row"  width="13%" >{{safety_item.reference_name}}</td>
                              <td>
                                <input type="text" placeholder="Type Remarks" v-bind:id="'comment_'+index" name="comments[]" v-model="safety_item.comments"/>
                              </td>
                              <td>
                                <input  typ="number" placeholder="Type Serial No" v-bind:id="'serial_no_'+index" name="item_qty[]" v-model="safety_item.serial_no"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Floor No" v-bind:id="'floor_no_'+index" name="item_qty[]" v-model="safety_item.floor_no"/>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.expiry_date"
                                    name="comment_date"
                                    lang="en"
                                    type="comment_date"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
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
                              </td>
                              <td>
                                <select v-model="safety_item.cicle" name="cicle[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('cicle') }">
                                  <option disabled value="">--Select-- </option>
                                  <option value="1">Daily</option>
                                  <option value="2">Weekly</option>
                                  <option value="3">Semi Monthly</option>
                                  <option value="4">Monthly</option>
                                  <option value="5">Quarterly</option>
                                  <option value="6">Yearly</option>
                                </select>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.due_on"
                                    name="due_on[]"
                                    lang="en"
                                    type="due_on"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                              </td>
                            </tr>
                          </template>
                        </template>
                        <template v-if="safety_item_list.refernece_id==4">
                          <template v-for="(safety_item,index) in form.water_valve_details_arr" >
                            <tr>
                              <td scope="row"  width="13%">{{safety_item.reference_name}}</td>
                              <td>
                                <input type="text" placeholder="Type Remarks" v-bind:id="'comment_'+index" name="comments[]" v-model="safety_item.comments"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Serial No" v-bind:id="'serial_no_'+index" name="item_qty[]" v-model="safety_item.serial_no"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Floor No" v-bind:id="'floor_no_'+index" name="item_qty[]" v-model="safety_item.floor_no"/>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.expiry_date"
                                    name="comment_date"
                                    lang="en"
                                    type="comment_date"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
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
                              </td>
                              <td>
                                <select v-model="safety_item.cicle" name="cicle[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('cicle') }">
                                  <option disabled value="">--Select-- </option>
                                  <option value="1">Daily</option>
                                  <option value="2">Weekly</option>
                                  <option value="3">Semi Monthly</option>
                                  <option value="4">Monthly</option>
                                  <option value="5">Quarterly</option>
                                  <option value="6">Yearly</option>
                                </select>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.due_on"
                                    name="due_on[]"
                                    lang="en"
                                    type="due_on"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                              </td>
                            </tr>
                          </template>
                        </template>
                        <template v-if="safety_item_list.refernece_id==5">
                          <template v-for="(safety_item,index) in form.gfci_breaker_details_arr" >
                            <tr>
                              <td scope="row"  width="13%">{{safety_item.reference_name}}</td>
                              <td>
                                <input type="text" placeholder="Type Remarks" v-bind:id="'comment_'+index" name="comments[]" v-model="safety_item.comments"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Serial No" v-bind:id="'serial_no_'+index" name="item_qty[]" v-model="safety_item.serial_no"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Floor No" v-bind:id="'floor_no_'+index" name="item_qty[]" v-model="safety_item.floor_no"/>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.expiry_date"
                                    name="comment_date"
                                    lang="en"
                                    type="comment_date"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
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
                              </td>
                              <td>
                                <select v-model="safety_item.cicle" name="cicle[]" class="custom-select":class="{ 'is-invalid': form.errors.has('cicle') }">
                                  <option disabled value="">--Select-- </option>
                                  <option value="1">Daily</option>
                                  <option value="2">Weekly</option>
                                  <option value="3">Semi Monthly</option>
                                  <option value="4">Monthly</option>
                                  <option value="5">Quarterly</option>
                                  <option value="6">Yearly</option>
                                </select>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.due_on"
                                    name="due_on[]"
                                    lang="en"
                                    type="due_on"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                              </td>
                            </tr>
                          </template>
                        </template>

                        <template v-if="safety_item_list.refernece_id==6">
                          <template v-for="(safety_item,index) in form.sump_pump_details_arr" >
                            <tr>
                              <td scope="row"  width="13%" >{{safety_item.reference_name}}</td>
                              <td>
                                <input type="text" placeholder="Type Remarks" v-bind:id="'comment_'+index" name="comments[]" v-model="safety_item.comments"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Serial No" v-bind:id="'serial_no_'+index" name="item_qty[]" v-model="safety_item.serial_no"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Floor No" v-bind:id="'floor_no_'+index" name="item_qty[]" v-model="safety_item.floor_no"/>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.expiry_date"
                                    name="comment_date"
                                    lang="en"
                                    type="comment_date"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
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
                              </td>
                              <td>
                                <select v-model="safety_item.cicle"  name="cicle[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('cicle') }">
                                  <option disabled value="">--Select-- </option>
                                  <option value="1">Daily</option>
                                  <option value="2">Weekly</option>
                                  <option value="3">Semi Monthly</option>
                                  <option value="4">Monthly</option>
                                  <option value="5">Quarterly</option>
                                  <option value="6">Yearly</option>
                                </select>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.due_on"
                                    name="due_on[]"
                                    lang="en"
                                    type="due_on"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                              </td>
                            </tr>
                          </template>
                        </template>
                        <template v-if="safety_item_list.refernece_id==7">
                          <template v-for="(safety_item,index) in form.emergency_bell_details_arr" >
                            <tr>
                              <td scope="row"  width="13%">{{safety_item.reference_name}}</td>
                              <td>
                                <input
                                    type="text" placeholder="Type Remarks" v-bind:id="'comment_'+index" name="comments[]" v-model="safety_item.comments"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Serial No" v-bind:id="'serial_no_'+index" name="item_qty[]" v-model="safety_item.serial_no"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Floor No" v-bind:id="'floor_no_'+index" name="item_qty[]" v-model="safety_item.floor_no"/>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.expiry_date"
                                    name="comment_date"
                                    lang="en"
                                    type="comment_date"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
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
                              </td>
                              <td>
                                <select v-model="safety_item.cicle" name="cicle[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('cicle') }">
                                  <option disabled value="">--Select-- </option>
                                  <option value="1">Daily</option>
                                  <option value="2">Weekly</option>
                                  <option value="3">Semi Monthly</option>
                                  <option value="4">Monthly</option>
                                  <option value="5">Quarterly</option>
                                  <option value="6">Yearly</option>
                                </select>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.due_on"
                                    name="due_on[]"
                                    lang="en"
                                    type="due_on"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                              </td>
                            </tr>
                          </template>
                        </template>
                        <template v-if="safety_item_list.refernece_id==8">
                          <template v-for="(safety_item,index) in form.emergency_light_arr" >
                            <tr>
                              <td scope="row"  width="13%" >{{safety_item.reference_name}}</td>
                              <td>
                                <input type="text" placeholder="Type Remarks" v-bind:id="'comment_'+index" name="comments[]" v-model="safety_item.comments"/>
                              </td>
                              <td>
                                <input
                                    type="number"
                                    placeholder="Type Serial No"
                                    v-bind:id="'serial_no_'+index"
                                    name="item_qty[]"
                                    v-model="safety_item.serial_no"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Floor No" v-bind:id="'floor_no_'+index" name="item_qty[]" v-model="safety_item.floor_no"/>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.expiry_date"
                                    name="comment_date"
                                    lang="en"
                                    type="comment_date"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
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
                              </td>
                              <td>
                                <select v-model="safety_item.cicle" name="cicle[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('cicle') }">
                                  <option disabled value="">--Select-- </option>
                                  <option value="1">Daily</option>
                                  <option value="2">Weekly</option>
                                  <option value="3">Semi Monthly</option>
                                  <option value="4">Monthly</option>
                                  <option value="5">Quarterly</option>
                                  <option value="6">Yearly</option>
                                </select>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.due_on"
                                    name="due_on[]"
                                    lang="en"
                                    type="due_on"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                              </td>
                            </tr>
                          </template>
                        </template>
                        <template v-if="safety_item_list.refernece_id==9">
                          <template v-for="(safety_item,index) in form.first_aid_station_arr" >
                            <tr>
                              <td scope="row"  width="13%">{{safety_item.reference_name}}</td>
                              <td>
                                <input type="text" placeholder="Type Remarks" v-bind:id="'comment_'+index" name="comments[]" v-model="safety_item.comments"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Serial No" v-bind:id="'serial_no_'+index" name="item_qty[]" v-model="safety_item.serial_no"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Floor No" v-bind:id="'floor_no_'+index" name="item_qty[]" v-model="safety_item.floor_no"/>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.expiry_date"
                                    name="comment_date"
                                    lang="en"
                                    type="comment_date"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
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
                              </td>
                              <td>
                                <select v-model="safety_item.cicle" name="cicle[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('cicle') }">
                                  <option disabled value="">--Select-- </option>
                                  <option value="1">Daily</option>
                                  <option value="2">Weekly</option>
                                  <option value="3">Semi Monthly</option>
                                  <option value="4">Monthly</option>
                                  <option value="5">Quarterly</option>
                                  <option value="6">Yearly</option>
                                </select>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.due_on"
                                    name="due_on[]"
                                    lang="en"
                                    type="due_on"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
                              </td>
                            </tr>
                          </template>
                        </template>
                        <template v-if="safety_item_list.refernece_id==10">
                          <template v-for="(safety_item,index) in form.first_aid_box_arr" >
                            <tr>
                              <td scope="row"  width="13%" >{{safety_item.reference_name}}</td>
                              <td>
                                <input type="text" placeholder="Type Remarks" v-bind:id="'comment_'+index" name="comments[]" v-model="safety_item.comments"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Serial No" v-bind:id="'serial_no_'+index" name="item_qty[]" v-model="safety_item.serial_no"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Floor No" v-bind:id="'floor_no_'+index" name="item_qty[]" v-model="safety_item.floor_no"/>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.expiry_date"
                                    name="comment_date"
                                    lang="en"
                                    type="comment_date"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
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
                              </td>
                              <td>
                                <select v-model="safety_item.cicle" name="cicle[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('cicle') }">
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
                              </td>
                            </tr>
                          </template>
                        </template>
                        <template v-if="safety_item_list.refernece_id==11">
                          <template v-for="(safety_item,index) in form.aed_arr" >
                            <tr>
                              <td scope="row"  width="13%" >{{safety_item.reference_name}}</td>
                              <td>
                                <input type="text" placeholder="Type Remarks" v-bind:id="'comment_'+index" name="comments[]" v-model="safety_item.comments"/>
                              </td>
                              <td>
                                <input type="number" placeholder="Type Serial No" v-bind:id="'serial_no_'+index" name="item_qty[]" v-model="safety_item.serial_no"/>
                              </td>
                              <td>
                                <input
                                    type="number" placeholder="Type Floor No" v-bind:id="'floor_no_'+index" name="item_qty[]" v-model="safety_item.floor_no"/>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.expiry_date"
                                    name="comment_date"
                                    lang="en"
                                    type="comment_date"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('expiry_date') }"></date-picker>
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
                              </td>
                              <td>
                                <select v-model="safety_item.cicle" name="cicle[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('cicle') }">
                                  <option disabled value="">--Select-- </option>
                                  <option value="1">Daily</option>
                                  <option value="2">Weekly</option>
                                  <option value="3">Semi Monthly</option>
                                  <option value="4">Monthly</option>
                                  <option value="5">Quarterly</option>
                                  <option value="6">Yearly</option>
                                </select>
                              </td>
                              <td>
                                <date-picker
                                    style="width:100%"
                                    v-model="safety_item.due_on"
                                    name="due_on[]"
                                    lang="en"
                                    type="due_on"
                                    format="ddd, MMM D, YYYY"
                                    :class="{ 'is-invalid': form.errors.has('due_on') }"></date-picker>
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
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_service_provider()" v-show="!external_service_show">Show</button>
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_service_provider()" v-show="external_service_show">Hide</button>
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
                          <td>
                            <input
                                type="text"
                                placeholder="Type ID No"
                                v-bind:id="'id_no_'+index"
                                name="id_no[]"
                                v-model="external_service_provider.id_no"/>
                          </td>
                          <td>
                            <input
                                type="text"
                                placeholder="Type Account No"
                                v-bind:id="'account_no_'+index"
                                name="account_no[]"
                                v-model="external_service_provider.account_no"/>
                          </td>
                          <td>
                            <input
                                type="text"
                                placeholder="Type Website"
                                v-bind:id="'website_'+index"
                                name="website[]"
                                v-model="external_service_provider.website"/>
                          </td>
                          <td>
                            <date-picker
                                style="width:100%"
                                v-model="external_service_provider.schedule_date"
                                name="schedule_date[]"
                                lang="en"
                                type="schedule_date"
                                format="ddd, MMM D, YYYY"
                                :class="{ 'is-invalid': form.errors.has('schedule_date') }"></date-picker>
                          </td>
                          <td>
                            <select v-model="external_service_provider.billing_cycle" name="billing_cycle[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('billing_cycle') }">
                              <option disabled value="">--Select-- </option>
                              <option value="1">Daily</option>
                              <option value="2">Weekly</option>
                              <option value="3">Semi Monthly</option>
                              <option value="4">Monthly</option>
                              <option value="5">Quarterly</option>
                              <option value="6">Yearly</option>
                            </select>
                          </td>
                          <td>
                            <date-picker
                                style="width:100%"
                                v-model="external_service_provider.expected_due_date"
                                name="expected_due_date[]"
                                lang="en"
                                type="expected_due_date"
                                format="ddd, MMM D, YYYY"
                                :class="{ 'is-invalid': form.errors.has('expected_due_date') }"></date-picker>
                          </td>
                          <td>
                            <select v-model="external_service_provider.bill_delivery_method" name="bill_delivery_method[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('bill_delivery_method') }">
                              <option disabled value="">--Select-- </option>
                              <option value="1">Mail</option>
                              <option value="2">Email</option>
                              <option value="3">Online</option>
                            </select>
                          </td>
                          <td>
                            <select v-model="external_service_provider.payment_method" name="payment_method[]" class="custom-select" :class="{ 'is-invalid': form.errors.has('payment_method') }">
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
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_contact_details()" v-show="!contact_details_show">Show</button>
              <button type="button" class="btn btn-primary btn-sm" @click="show_hide_contact_details()" v-show="contact_details_show">Hide</button>
            </h3>
            <div class="form-holder" v-show="contact_details_show">
              <div class="row align-self-stretch" >
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
                            <td>
                              <input
                                  type="text"
                                  placeholder="Type ID-Name"
                                  v-bind:id="'contact_no_'+index"
                                  name="contact_no[]"
                                  v-model="contact_details.contact_no"/>
                            </td>
                            <td>
                              <input
                                  type="text"
                                  placeholder="Type Phone"
                                  v-bind:id="'phone_'+index"
                                  name="phone[]"
                                  v-model="contact_details.phone"/>
                            </td>
                            <td>
                              <input
                                  type="text"
                                  placeholder="Type Mobile"
                                  v-bind:id="'mobile_'+index"
                                  name="mobile[]"
                                  v-model="contact_details.mobile"/>
                            </td>
                            <td>
                              <input
                                  type="email"
                                  placeholder="Type Email"
                                  v-bind:id="'email_'+index"
                                  name="email[]"
                                  v-model="contact_details.email"/>
                            </td>
                            <td>
                              <input
                                  type="url"
                                  placeholder="Type Website"
                                  v-bind:id="'website_'+index"
                                  name="website[]"
                                  v-model="contact_details.website"/>
                            </td>
                            <td>
                              <input
                                  type="text"
                                  placeholder="Type Hours of Operation"
                                  v-bind:id="'hours_of_operation_'+index"
                                  name="hours_of_operation[]"
                                  v-model="contact_details.hours_of_operation"/>
                            </td>
                            <td>
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
            <button :disabled="form.busy || editmode==false"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>

            <button :disabled="form.busy || editmode==true || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="save_stay(1)">Save-Stay</button>
            <button :disabled="form.busy || editmode==true || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px"  @click="save_stay(2)">Save-Out</button>
            <button :disabled="form.busy || editmode==true || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px"  @click="save_stay(3)">Save-New</button>
            <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px" >Update</button>
            <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click.prevent="deleteCustomer()">Delete</button>

            <button :disabled="form.busy || editmode==false || form.posting_status>1"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()" v-if="user_type==9">Post {{form.posting_status}}</button>
            <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()" v-else>Post</button>

            <button :disabled="form.busy || form.posting_status<2 || user_type!=9"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="adjust()">Adjust</button>

            <button :disabled="form.busy || form.posting_status!=3 || user_type!=9"  type="button" class="btn  btn-primary" style="min-width:110px" @click="repost()">RePost</button>
            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
          </div>
        </div>
      </div>

      <!--  Model  -->
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
                          <input v-model="form.custom_field_name" type="text" name="custom_field_name" :class="{ 'is-invalid': form.errors.has('custom_field_name') }"/>
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

.table_narrow td {
  padding: .1rem .5rem !important;
}

.table_narrow th, .table_narrow .header td {
  font-size: 13px !important;
  vertical-align: middle !important;
  color: rgb(255, 255, 255) !important;
  text-align: center !important;
  border: 1px solid #fff !important;
}

.table_narrow tbody td {
  font-size: 13px !important;
}

.table_narrow thead tr, .table_narrow .header {


  background-color: rgb(0, 112, 192) !important;

}

.table_narrow input {

  font-size: 12px !important;
  height: 30px !important;
  margin: 5px 0 !important;
}

</style>

<script>
import DatePicker from 'vue3-datepicker';
import VueTimepicker from 'vue3-timepicker';
import 'vue3-timepicker/dist/VueTimepicker.css';

import { ref } from "vue";
import Vue3Datatable from "@bhplugin/vue3-datatable";
import "@bhplugin/vue3-datatable/dist/style.css";

export default {
  name: 'list-product-categories',
  components: {
    Vue3Datatable,
    DatePicker,
    VueTimepicker
  },
  data() {
    return {
      editmode: false,
      show_company: true,
      list_showable: false,
      filter: '',
      form: new Form({
        company_name: '',
        building_no: '',
        building_name: '',
        strata_lot_no: '',
        posting_status: 0,
        number_of_floor: '',
        number_of_upper_floor: '',
        number_of_roof_top: '',
        number_of_ground_floor: '',
        number_of_under_ground: '',
        dependent_building: false,
        independent_building: false,
        residential: false,
        commercial: false,
        residential_commercial: false,
        total_building_size: '',
        building_uom: 1,
        page_id: 1,
        id: '',
        roof_top_arr: [],
        upper_building_arr: [],
        ground_building_arr: [],
        under_ground_building_arr: [],
        safety_item_list_arr: [],
        external_service_provider_details_arr: [],
        fire_extinguisher_details_arr: [],
        smoke_detecter_details_arr: [],
        sprinkler_details_arr: [],
        water_valve_details_arr: [],
        gfci_breaker_details_arr: [],
        sump_pump_details_arr: [],
        emergency_bell_details_arr: [],
        emergency_light_arr: [],
        first_aid_station_arr: [],
        first_aid_box_arr: [],
        aed_arr: [],
        building_contact_details_arr: [],
        property_management_type_arr: [],
        license_and_permit_list_arr: [],
        custom_contact_type: '',
        custom_field_name: '',

      }),
      columns: ref([
        {title: 'SL', field: 'sl', align: 'center'},
        {title: 'Building No', field: 'building_no'},
        {title: 'Building Name', field: 'building_name'},
        {title: 'Number Of Floor', field: 'number_of_floor'},
        {title: 'Dependency Class', field: 'dependency_class'},
        {title: 'Property Type', field: 'property_type'},
        {title: 'Action', field: 'buttons', sort: false},
      ]),
      rows: [],
      general_info_show: true,
      property_show: false,
      property_management_show: false,
      licence_show: false,
      safety_equipment_show: false,
      external_service_show: false,
      contact_details_show: false,
      external_service_provider_list_arr: [],
      building_contact_list_arr: [],
      account_disable: true,
      account_no: '',
      user_type: '',
      page: 1,
      per_page: 15,
      expanded: null
    }
  },

  created: function () {
    this.user_menu_name = this.$route.name;
    this.fetchBuildingProfile();
  },

  computed: {},
  methods: {
    editBuildingInfo(id) {
      this.form.reset();
      this.tempeditmode = true;
      this.list_showable = false;
      let uri = '/BuildingInfos/' + id + '/edit';
      window.axios.get(uri).then((response) => {


        this.editmode = true;
        this.user_type = response.data.user_type;
        this.form.strata_lot_no = response.data.building_list_arr.strata_lot_no;
        this.form.safety_item_list_arr = response.data.safety_item_list_arr;
        this.form.license_and_permit_list_arr = response.data.license_and_permit_list_arr;
        this.external_service_provider_list_arr = response.data.external_service_provider_list_arr;
        this.building_contact_list_arr = response.data.building_contact_list_arr;
        let safety_device_equipment_arr = response.data.safety_device_equipment_arr;

        this.form.id = response.data.building_list_arr.id;
        this.form.posting_status = response.data.building_list_arr.posting_status;
        this.form.strata_lot_no = response.data.building_list_arr.strata_lot_no;
        this.form.company_name = response.data.building_list_arr.company_name;
        this.form.building_name = response.data.building_list_arr.building_name;
        this.form.total_building_size = response.data.building_list_arr.total_building_size;
        this.form.building_uom = response.data.building_list_arr.building_uom;
        this.form.number_of_floor = response.data.building_list_arr.number_of_floor;
        this.form.number_of_roof_top = response.data.building_list_arr.number_of_roof_top;
        this.form.number_of_ground_floor = response.data.building_list_arr.number_of_ground_floor;
        this.form.number_of_upper_floor = response.data.building_list_arr.number_of_upper_floor;
        this.form.number_of_under_ground = response.data.building_list_arr.number_of_under_ground;
        this.form.building_no = response.data.building_list_arr.building_no;
        this.form.dependent_building = response.data.building_list_arr.dependent_building;
        this.form.independent_building = response.data.building_list_arr.independent_building;
        this.form.residential = response.data.building_list_arr.residential;
        this.form.commercial = response.data.building_list_arr.commercial;
        this.form.residential_commercial = response.data.building_list_arr.residential_commercial;

        this.form.roof_top_arr = [];
        this.form.upper_building_arr = [];
        this.form.ground_building_arr = [];
        this.form.under_ground_building_arr = [];
        for (let i = 0; i < response.data.building_property_details_arr.length; i++) {
          if (response.data.building_property_details_arr[i].floor_type == 1) {

            this.form.roof_top_arr.push({
              'id': response.data.building_property_details_arr[i].id,
              'floor_no': response.data.building_property_details_arr[i].floor_type,
              'suites': response.data.building_property_details_arr[i].total_suite,
              'units': response.data.building_property_details_arr[i].total_unit,
              'mechanical_rooms': response.data.building_property_details_arr[i].total_mechanical_room,
              'administrative_rooms': response.data.building_property_details_arr[i].total_administrative_room,
              'amenity_rooms': response.data.building_property_details_arr[i].total_amenity_room,
              'service_rooms': response.data.building_property_details_arr[i].total_service_room,
              'parking_lot': response.data.building_property_details_arr[i].total_parking_lot,
              'bike_lot': response.data.building_property_details_arr[i].total_bike_lot,
              'storage_lot': response.data.building_property_details_arr[i].total_storage_lot,
              'mailroom': response.data.building_property_details_arr[i].total_mailroom,
              'common_area': response.data.building_property_details_arr[i].total_common_area,

            });

          } else if (response.data.building_property_details_arr[i].floor_type == 2) {

            this.form.upper_building_arr.push({
              'id': response.data.building_property_details_arr[i].id,
              'floor_no': response.data.building_property_details_arr[i].floor_type,
              'suites': response.data.building_property_details_arr[i].total_suite,
              'units': response.data.building_property_details_arr[i].total_unit,
              'mechanical_rooms': response.data.building_property_details_arr[i].total_mechanical_room,
              'administrative_rooms': response.data.building_property_details_arr[i].total_administrative_room,
              'amenity_rooms': response.data.building_property_details_arr[i].total_amenity_room,
              'service_rooms': response.data.building_property_details_arr[i].total_service_room,
              'parking_lot': response.data.building_property_details_arr[i].total_parking_lot,
              'bike_lot': response.data.building_property_details_arr[i].total_bike_lot,
              'storage_lot': response.data.building_property_details_arr[i].total_storage_lot,
              'mailroom': response.data.building_property_details_arr[i].total_mailroom,
              'common_area': response.data.building_property_details_arr[i].total_common_area,

            });

          } else if (response.data.building_property_details_arr[i].floor_type == 3) {

            this.form.ground_building_arr.push({
              'id': response.data.building_property_details_arr[i].id,
              'floor_no': response.data.building_property_details_arr[i].floor_type,
              'suites': response.data.building_property_details_arr[i].total_suite,
              'units': response.data.building_property_details_arr[i].total_unit,
              'mechanical_rooms': response.data.building_property_details_arr[i].total_mechanical_room,
              'administrative_rooms': response.data.building_property_details_arr[i].total_administrative_room,
              'amenity_rooms': response.data.building_property_details_arr[i].total_amenity_room,
              'service_rooms': response.data.building_property_details_arr[i].total_service_room,
              'parking_lot': response.data.building_property_details_arr[i].total_parking_lot,
              'bike_lot': response.data.building_property_details_arr[i].total_bike_lot,
              'storage_lot': response.data.building_property_details_arr[i].total_storage_lot,
              'mailroom': response.data.building_property_details_arr[i].total_mailroom,
              'common_area': response.data.building_property_details_arr[i].total_common_area,

            });

          } else if (response.data.building_property_details_arr[i].floor_type == 4) {

            this.form.under_ground_building_arr.push({
              'id': response.data.building_property_details_arr[i].id,
              'floor_no': response.data.building_property_details_arr[i].floor_type,
              'suites': response.data.building_property_details_arr[i].total_suite,
              'units': response.data.building_property_details_arr[i].total_unit,
              'mechanical_rooms': response.data.building_property_details_arr[i].total_mechanical_room,
              'administrative_rooms': response.data.building_property_details_arr[i].total_administrative_room,
              'amenity_rooms': response.data.building_property_details_arr[i].total_amenity_room,
              'service_rooms': response.data.building_property_details_arr[i].total_service_room,
              'parking_lot': response.data.building_property_details_arr[i].total_parking_lot,
              'bike_lot': response.data.building_property_details_arr[i].total_bike_lot,
              'storage_lot': response.data.building_property_details_arr[i].total_storage_lot,
              'mailroom': response.data.building_property_details_arr[i].total_mailroom,
              'common_area': response.data.building_property_details_arr[i].total_common_area,

            });

          }

        }

        for (let i = 0; i < response.data.property_management_arr.length; i++) {


          this.form.property_management_type_arr.push({
            'id': response.data.property_management_arr[i].id,
            'reference_id': response.data.property_management_arr[i].reference_id,
            'item_name': response.data.property_management_arr[i].item_name,
            'id_no': response.data.property_management_arr[i].id_no,
            'name': response.data.property_management_arr[i].name,
            'phone': response.data.property_management_arr[i].phone,
            'website': response.data.property_management_arr[i].website,
            'mobile': response.data.property_management_arr[i].mobile,
            'email': response.data.property_management_arr[i].email,
            // 'master_id':response.data.property_management_arr[i].master_id,
          });

        }


        for (let i = 0; i < safety_device_equipment_arr.length; i++) {

          if (safety_device_equipment_arr[i].item_id == 1) {

            this.form.fire_extinguisher_details_arr.push({
              'id': safety_device_equipment_arr[i].id,
              'reference_id': safety_device_equipment_arr[i].reference_id,
              'item_id': safety_device_equipment_arr[i].item_id,
              'reference_name': safety_device_equipment_arr[i].reference_name,
              'name': safety_device_equipment_arr[i].name,
              'comments': safety_device_equipment_arr[i].comments,
              'floor_no': safety_device_equipment_arr[i].floor_no,
              'serial_no': safety_device_equipment_arr[i].serial_no,
              'expiry_date': safety_device_equipment_arr[i].expiry_date,
              'renew_date': safety_device_equipment_arr[i].renew_date,
              'cicle': safety_device_equipment_arr[i].cicle,
              'due_on': safety_device_equipment_arr[i].due_on,
            });

          } else if (safety_device_equipment_arr[i].item_id == 2) {

            this.form.smoke_detecter_details_arr.push({
              'id': safety_device_equipment_arr[i].id,
              'reference_id': safety_device_equipment_arr[i].reference_id,
              'item_id': safety_device_equipment_arr[i].item_id,
              'reference_name': safety_device_equipment_arr[i].reference_name,
              'name': safety_device_equipment_arr[i].name,
              'comments': safety_device_equipment_arr[i].comments,
              'floor_no': safety_device_equipment_arr[i].floor_no,
              'serial_no': safety_device_equipment_arr[i].serial_no,
              'expiry_date': safety_device_equipment_arr[i].expiry_date,
              'renew_date': safety_device_equipment_arr[i].renew_date,
              'cicle': safety_device_equipment_arr[i].cicle,
              'due_on': safety_device_equipment_arr[i].due_on,
            });

          } else if (safety_device_equipment_arr[i].item_id == 3) {

            this.form.sprinkler_details_arr.push({
              'id': safety_device_equipment_arr[i].id,
              'reference_id': safety_device_equipment_arr[i].reference_id,
              'item_id': safety_device_equipment_arr[i].item_id,
              'reference_name': safety_device_equipment_arr[i].reference_name,
              'name': safety_device_equipment_arr[i].name,
              'comments': safety_device_equipment_arr[i].comments,
              'floor_no': safety_device_equipment_arr[i].floor_no,
              'serial_no': safety_device_equipment_arr[i].serial_no,
              'expiry_date': safety_device_equipment_arr[i].expiry_date,
              'renew_date': safety_device_equipment_arr[i].renew_date,
              'cicle': safety_device_equipment_arr[i].cicle,
              'due_on': safety_device_equipment_arr[i].due_on,
            });

          } else if (safety_device_equipment_arr[i].item_id == 4) {

            this.form.water_valve_details_arr.push({
              'id': safety_device_equipment_arr[i].id,
              'reference_id': safety_device_equipment_arr[i].reference_id,
              'item_id': safety_device_equipment_arr[i].item_id,
              'reference_name': safety_device_equipment_arr[i].reference_name,
              'name': safety_device_equipment_arr[i].name,
              'comments': safety_device_equipment_arr[i].comments,
              'floor_no': safety_device_equipment_arr[i].floor_no,
              'serial_no': safety_device_equipment_arr[i].serial_no,
              'expiry_date': safety_device_equipment_arr[i].expiry_date,
              'renew_date': safety_device_equipment_arr[i].renew_date,
              'cicle': safety_device_equipment_arr[i].cicle,
              'due_on': safety_device_equipment_arr[i].due_on,
            });

          } else if (safety_device_equipment_arr[i].item_id == 5) {

            this.form.gfci_breaker_details_arr.push({
              'id': safety_device_equipment_arr[i].id,
              'reference_id': safety_device_equipment_arr[i].reference_id,
              'item_id': safety_device_equipment_arr[i].item_id,
              'reference_name': safety_device_equipment_arr[i].reference_name,
              'name': safety_device_equipment_arr[i].name,
              'comments': safety_device_equipment_arr[i].comments,
              'floor_no': safety_device_equipment_arr[i].floor_no,
              'serial_no': safety_device_equipment_arr[i].serial_no,
              'expiry_date': safety_device_equipment_arr[i].expiry_date,
              'renew_date': safety_device_equipment_arr[i].renew_date,
              'cicle': safety_device_equipment_arr[i].cicle,
              'due_on': safety_device_equipment_arr[i].due_on,
            });

          } else if (safety_device_equipment_arr[i].item_id == 6) {

            this.form.sump_pump_details_arr.push({
              'id': safety_device_equipment_arr[i].id,
              'reference_id': safety_device_equipment_arr[i].reference_id,
              'item_id': safety_device_equipment_arr[i].item_id,
              'reference_name': safety_device_equipment_arr[i].reference_name,
              'name': safety_device_equipment_arr[i].name,
              'comments': safety_device_equipment_arr[i].comments,
              'floor_no': safety_device_equipment_arr[i].floor_no,
              'serial_no': safety_device_equipment_arr[i].serial_no,
              'expiry_date': safety_device_equipment_arr[i].expiry_date,
              'renew_date': safety_device_equipment_arr[i].renew_date,
              'cicle': safety_device_equipment_arr[i].cicle,
              'due_on': safety_device_equipment_arr[i].due_on,
            });

          } else if (safety_device_equipment_arr[i].item_id == 7) {

            this.form.emergency_bell_details_arr.push({
              'id': safety_device_equipment_arr[i].id,
              'reference_id': safety_device_equipment_arr[i].reference_id,
              'item_id': safety_device_equipment_arr[i].item_id,
              'reference_name': safety_device_equipment_arr[i].reference_name,
              'name': safety_device_equipment_arr[i].name,
              'comments': safety_device_equipment_arr[i].comments,
              'floor_no': safety_device_equipment_arr[i].floor_no,
              'serial_no': safety_device_equipment_arr[i].serial_no,
              'expiry_date': safety_device_equipment_arr[i].expiry_date,
              'renew_date': safety_device_equipment_arr[i].renew_date,
              'cicle': safety_device_equipment_arr[i].cicle,
              'due_on': safety_device_equipment_arr[i].due_on,
            });

          } else if (safety_device_equipment_arr[i].item_id == 8) {

            this.form.emergency_light_arr.push({
              'id': safety_device_equipment_arr[i].id,
              'reference_id': safety_device_equipment_arr[i].reference_id,
              'item_id': safety_device_equipment_arr[i].item_id,
              'reference_name': safety_device_equipment_arr[i].reference_name,
              'name': safety_device_equipment_arr[i].name,
              'comments': safety_device_equipment_arr[i].comments,
              'floor_no': safety_device_equipment_arr[i].floor_no,
              'serial_no': safety_device_equipment_arr[i].serial_no,
              'expiry_date': safety_device_equipment_arr[i].expiry_date,
              'renew_date': safety_device_equipment_arr[i].renew_date,
              'cicle': safety_device_equipment_arr[i].cicle,
              'due_on': safety_device_equipment_arr[i].due_on,
            });

          } else if (safety_device_equipment_arr[i].item_id == 9) {

            this.form.first_aid_station_arr.push({
              'id': safety_device_equipment_arr[i].id,
              'reference_id': safety_device_equipment_arr[i].reference_id,
              'item_id': safety_device_equipment_arr[i].item_id,
              'reference_name': safety_device_equipment_arr[i].reference_name,
              'name': safety_device_equipment_arr[i].name,
              'comments': safety_device_equipment_arr[i].comments,
              'floor_no': safety_device_equipment_arr[i].floor_no,
              'serial_no': safety_device_equipment_arr[i].serial_no,
              'expiry_date': safety_device_equipment_arr[i].expiry_date,
              'renew_date': safety_device_equipment_arr[i].renew_date,
              'cicle': safety_device_equipment_arr[i].cicle,
              'due_on': safety_device_equipment_arr[i].due_on,
            });

          } else if (safety_device_equipment_arr[i].item_id == 10) {

            this.form.first_aid_box_arr.push({
              'id': safety_device_equipment_arr[i].id,
              'reference_id': safety_device_equipment_arr[i].reference_id,
              'item_id': safety_device_equipment_arr[i].item_id,
              'reference_name': safety_device_equipment_arr[i].reference_name,
              'name': safety_device_equipment_arr[i].name,
              'comments': safety_device_equipment_arr[i].comments,
              'floor_no': safety_device_equipment_arr[i].floor_no,
              'serial_no': safety_device_equipment_arr[i].serial_no,
              'expiry_date': safety_device_equipment_arr[i].expiry_date,
              'renew_date': safety_device_equipment_arr[i].renew_date,
              'cicle': safety_device_equipment_arr[i].cicle,
              'due_on': safety_device_equipment_arr[i].due_on,
            });

          } else if (safety_device_equipment_arr[i].item_id == 11) {

            this.form.aed_arr.push({
              'id': safety_device_equipment_arr[i].id,
              'reference_id': safety_device_equipment_arr[i].reference_id,
              'item_id': safety_device_equipment_arr[i].item_id,
              'reference_name': safety_device_equipment_arr[i].reference_name,
              'name': safety_device_equipment_arr[i].name,
              'comments': safety_device_equipment_arr[i].comments,
              'floor_no': safety_device_equipment_arr[i].floor_no,
              'serial_no': safety_device_equipment_arr[i].serial_no,
              'expiry_date': safety_device_equipment_arr[i].expiry_date,
              'renew_date': safety_device_equipment_arr[i].renew_date,
              'cicle': safety_device_equipment_arr[i].cicle,
              'due_on': safety_device_equipment_arr[i].due_on,
            });

          }


        }

        for (let i = 0; i < this.external_service_provider_list_arr.length; i++) {

          this.form.external_service_provider_details_arr.push({
            'id': this.external_service_provider_list_arr[i].id,
            'reference_id': this.external_service_provider_list_arr[i].reference_id,
            'item_name': this.external_service_provider_list_arr[i].item_name,
            'id_no': this.external_service_provider_list_arr[i].id_no,
            'account_no': this.external_service_provider_list_arr[i].account_no,
            'website': this.external_service_provider_list_arr[i].website,
            'schedule_date': this.external_service_provider_list_arr[i].schedule_date,
            'expected_due_date': this.external_service_provider_list_arr[i].expected_due_date,
            'billing_cycle': this.external_service_provider_list_arr[i].billing_cycle,
            'bill_delivery_method': this.external_service_provider_list_arr[i].bill_delivery_method,
            'payment_method': this.external_service_provider_list_arr[i].payment_method,
            'master_id': this.external_service_provider_list_arr[i].master_id,

          });
        }


        for (let i = 0; i < this.building_contact_list_arr.length; i++) {

          if (this.building_contact_list_arr[i].item_type in this.form.building_contact_details_arr == false)
            this.form.building_contact_details_arr[this.building_contact_list_arr[i].item_type] = {};

          this.form.building_contact_details_arr[this.building_contact_list_arr[i].item_type][this.building_contact_list_arr[i].reference_id] = {
            'id': this.building_contact_list_arr[i].id,
            'reference_id': this.building_contact_list_arr[i].reference_id,
            'item_name': this.building_contact_list_arr[i].item_name,
            'contact_no': this.building_contact_list_arr[i].contact_no,
            'phone': this.building_contact_list_arr[i].phone,
            'website': this.building_contact_list_arr[i].website,
            'mobile': this.building_contact_list_arr[i].mobile,
            'email': this.building_contact_list_arr[i].email,
            'hours_of_operation': this.building_contact_list_arr[i].hours_of_operation,
            'comment': this.building_contact_list_arr[i].comment,
            'master_id': this.building_contact_list_arr[i].master_id,

          }
        }

      });

      this.tempeditmode = false;

    },

    post() {
      if (this.user_type == 9) this.form.posting_status = 2;
      else this.form.posting_status = 1;
      alert(this.user_type + "==" + this.form.posting_status);
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Post it!'
      }).then((result) => {

        this.form.post('/BuildingInfoPost/' + this.form.id).then((response) => {

          var response_data = response.data.split("**");
          if (response_data[0] == 1) {
            showAlert(
                'Posted!',
                'Your Data has been Posted.',
                'success'
            );

            this.editBuildingInfo(response_data[1]);

          }

        }).catch(() => {
          showAlert("failed!", "there was some wrong", "warning");
        });

      })

    },

    repost() {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Repost it!'
      }).then((result) => {


        this.form.post('/BuildingInfoRepost/' + this.form.id).then((response) => {

          var response_data = response.data.split("**");
          if (response_data[0] == 1) {
            showAlert(
                'Posted!',
                'Your Data has been Reposted.',
                'success'
            );

            this.editBuildingInfo(response_data[1]);
          }

        }).catch(() => {
          showAlert("failed!", "there was some wrong", "warning");
        });

      })

    },

    adjust() {

      this.form.post('/adjustBuildingInfo/' + this.form.id).then((response) => {
        var response_data = response.data.split("**");
        if (response_data[0] == 1) {
          toast({
            type: 'success',
            title: 'Data Update Successfully'
          });

          this.editBuildingInfo(response_data[1]);

          this.editmode = true;
        } else {

          toast({
            type: 'danger',
            title: 'Invalid Operation'
          });
        }
      }).catch(() => {
        showAlert("failed!", "there was some wrong", "warning");
      });

    },

    reset_list() {
      this.form.reset();
      this.editmode = false;
      let uri = '/BuildingInfoLits';
      window.axios.get(uri).then((response) => {
        this.rows = ref(response.data.building_list);
      });
      this.list_showable = true;
    },

    reset_form() {

      this.form.reset();
      this.editmode = false;
      this.list_showable = false;
    },

    show_hide_property_management() {
      if (this.property_management_show) {
        this.property_management_show = false;
      } else {
        this.property_management_show = true;
      }

    },

    show_hide_property() {
      if (this.property_show) {
        this.property_show = false;
      } else {
        this.property_show = true;
      }

    },
    show_hide_licence() {
      if (this.licence_show) {
        this.licence_show = false;
      } else {
        this.licence_show = true;
      }
    },

    show_hide_general_info() {
      if (this.general_info_show) {
        this.general_info_show = false;
      } else {
        this.general_info_show = true;
      }

    },

    show_hide_safety_equipment() {
      if (this.safety_equipment_show) {
        this.safety_equipment_show = false;
      } else {
        this.safety_equipment_show = true;
      }

    },

    show_hide_service_provider() {
      if (this.external_service_show) {
        this.external_service_show = false;
      } else {
        this.external_service_show = true;
      }

    },

    show_hide_contact_details() {
      if (this.contact_details_show) {
        this.contact_details_show = false;
      } else {
        this.contact_details_show = true;
      }
    },

    add_license_permit() {
      this.form.license_and_permit_list_arr.push({
        'id': '',
        'reference_id': '',
        'item_name': '',
        'issued_by': '',
        'expiry_date': '',
        'webiste': '',
        'mobile': '',
        'phone': '',
        'email': '',
        'comment': '',

      });
    },

    change_fire_extinguisher_back(item) {
      if (item.id in this.form.safety_item_details_arr == false)
        this.form.safety_item_details_arr[item.id] = {};

      for (var i = 1; i <= item.item_qty; i++) {

        this.form.safety_item_details_arr[item.id][i] = {
          'id': '',
          'reference_id': item.id,
          'reference_name': item.item_name + ' ' + i,
          'name': '',
          'floor_no': '',
          'serial_no': '',
          'expiry_date': '',
          'renew_date': '',
          'cicle': '',
          'due_on': '',
        }

      }
      // alert(this.form.safety_item_details_arr[item.id][1].reference_name)
      return this.form.safety_item_details_arr;

    },

    change_fire_extinguisher(item) {

      if (item.refernece_id == 1) {

        let array_length = this.form.fire_extinguisher_details_arr.length;

        if (array_length > item.item_qty) {

          this.form.fire_extinguisher_details_arr.splice(item.item_qty);
          return;
        }


        for (var i = 1; i <= item.item_qty; i++) {
          if (array_length < i) {
            this.form.fire_extinguisher_details_arr.push({
              'id': '',
              'reference_id': item.id,
              'item_id': item.refernece_id,
              'reference_name': item.item_name + ' ' + i,
              'name': '',
              'comments': '',
              'floor_no': '',
              'serial_no': '',
              'expiry_date': '',
              'renew_date': '',
              'cicle': '',
              'due_on': '',

            });

          }
        }
      } else if (item.refernece_id == 2) {

        let array_length = this.form.smoke_detecter_details_arr.length;

        if (array_length > item.item_qty) {

          this.form.smoke_detecter_details_arr.splice(item.item_qty);

          return;
        }

        for (var i = 1; i <= item.item_qty; i++) {
          if (array_length < i) {
            this.form.smoke_detecter_details_arr.push({
              'id': '',
              'reference_id': item.id,
              'item_id': item.refernece_id,
              'reference_name': item.item_name + ' ' + i,
              'name': '',
              'comments': '',
              'floor_no': '',
              'serial_no': '',
              'expiry_date': '',
              'renew_date': '',
              'cicle': '',
              'due_on': '',

            });
          }
        }
      } else if (item.refernece_id == 3) {

        let array_length = this.form.sprinkler_details_arr.length;


        if (array_length > item.item_qty) {

          this.form.sprinkler_details_arr.splice(item.item_qty);
          return;
        }


        for (var i = 1; i <= item.item_qty; i++) {
          if (array_length < i) {
            this.form.sprinkler_details_arr.push({
              'id': '',
              'reference_id': item.id,
              'item_id': item.refernece_id,
              'reference_name': item.item_name + ' ' + i,
              'name': '',
              'comments': '',
              'floor_no': '',
              'serial_no': '',
              'expiry_date': '',
              'renew_date': '',
              'cicle': '',
              'due_on': '',

            });
          }
        }
      } else if (item.refernece_id == 4) {

        let array_length = this.form.water_valve_details_arr.length;

        if (array_length > item.item_qty) {

          this.form.water_valve_details_arr.splice(item.item_qty);
          return;
        }


        for (var i = 1; i <= item.item_qty; i++) {
          if (array_length < i) {
            this.form.water_valve_details_arr.push({
              'id': '',
              'reference_id': item.id,
              'item_id': item.refernece_id,
              'reference_name': item.item_name + ' ' + i,
              'name': '',
              'comments': '',
              'floor_no': '',
              'serial_no': '',
              'expiry_date': '',
              'renew_date': '',
              'cicle': '',
              'due_on': '',

            });
          }
        }
      } else if (item.refernece_id == 5) {

        let array_length = this.form.gfci_breaker_details_arr.length;

        if (array_length > item.item_qty) {

          this.form.gfci_breaker_details_arr.splice(item.item_qty);
          return;
        }


        for (var i = 1; i <= item.item_qty; i++) {
          if (array_length < i) {
            this.form.gfci_breaker_details_arr.push({
              'id': '',
              'reference_id': item.id,
              'item_id': item.refernece_id,
              'reference_name': item.item_name + ' ' + i,
              'name': '',
              'comments': '',
              'floor_no': '',
              'serial_no': '',
              'expiry_date': '',
              'renew_date': '',
              'cicle': '',
              'due_on': '',

            });
          }
        }
      } else if (item.refernece_id == 6) {

        let array_length = this.form.sump_pump_details_arr.length;

        if (array_length > item.item_qty) {

          this.form.sump_pump_details_arr.splice(item.item_qty);
          return;
        }


        for (var i = 1; i <= item.item_qty; i++) {

          if (array_length < i) {
            this.form.sump_pump_details_arr.push({
              'id': '',
              'reference_id': item.id,
              'item_id': item.refernece_id,
              'reference_name': item.item_name + ' ' + i,
              'name': '',
              'comments': '',
              'floor_no': '',
              'serial_no': '',
              'expiry_date': '',
              'renew_date': '',
              'cicle': '',
              'due_on': '',

            });
          }
        }
      } else if (item.refernece_id == 7) {

        let array_length = this.form.emergency_bell_details_arr.length;

        if (array_length > item.item_qty) {

          this.form.emergency_bell_details_arr.splice(item.item_qty);
          return;
        }

        for (var i = 1; i <= item.item_qty; i++) {
          if (array_length < i) {
            this.form.emergency_bell_details_arr.push({
              'id': '',
              'reference_id': item.id,
              'item_id': item.refernece_id,
              'reference_name': item.item_name + ' ' + i,
              'name': '',
              'comments': '',
              'floor_no': '',
              'serial_no': '',
              'expiry_date': '',
              'renew_date': '',
              'cicle': '',
              'due_on': '',

            });
          }
        }
      } else if (item.refernece_id == 8) {

        let array_length = this.form.emergency_light_arr.length;

        if (array_length > item.item_qty) {

          this.form.emergency_light_arr.splice(item.item_qty);
          return;
        }

        for (var i = 1; i <= item.item_qty; i++) {
          if (array_length < i) {
            this.form.emergency_light_arr.push({
              'id': '',
              'reference_id': item.id,
              'item_id': item.refernece_id,
              'reference_name': item.item_name + ' ' + i,
              'name': '',
              'comments': '',
              'floor_no': '',
              'serial_no': '',
              'expiry_date': '',
              'renew_date': '',
              'cicle': '',
              'due_on': '',

            });
          }
        }
      } else if (item.refernece_id == 9) {

        let array_length = this.form.first_aid_station_arr.length;

        if (array_length > item.item_qty) {

          this.form.first_aid_station_arr.splice(item.item_qty);
          return;
        }

        for (var i = 1; i <= item.item_qty; i++) {
          if (array_length < i) {
            this.form.first_aid_station_arr.push({
              'id': '',
              'reference_id': item.id,
              'item_id': item.refernece_id,
              'reference_name': item.item_name + ' ' + i,
              'name': '',
              'comments': '',
              'floor_no': '',
              'serial_no': '',
              'expiry_date': '',
              'renew_date': '',
              'cicle': '',
              'due_on': '',

            });
          }
        }
      } else if (item.refernece_id == 10) {

        let array_length = this.form.first_aid_box_arr.length;

        if (array_length > item.item_qty) {

          this.form.first_aid_box_arr.splice(item.item_qty);
          return;
        }

        for (var i = 1; i <= item.item_qty; i++) {
          if (array_length < i) {
            this.form.first_aid_box_arr.push({
              'id': '',
              'reference_id': item.id,
              'item_id': item.refernece_id,
              'reference_name': item.item_name + ' ' + i,
              'name': '',
              'comments': '',
              'floor_no': '',
              'serial_no': '',
              'expiry_date': '',
              'renew_date': '',
              'cicle': '',
              'due_on': '',

            });
          }
        }
      } else if (item.refernece_id == 11) {

        let array_length = this.form.aed_arr.length;

        if (array_length > item.item_qty) {

          this.form.aed_arr.splice(item.item_qty);
          return;
        }

        for (var i = 1; i <= item.item_qty; i++) {
          if (array_length < i) {
            this.form.aed_arr.push({
              'id': '',
              'reference_id': item.id,
              'item_id': item.refernece_id,
              'reference_name': item.item_name + ' ' + i,
              'name': '',
              'comments': '',
              'floor_no': '',
              'serial_no': '',
              'expiry_date': '',
              'renew_date': '',
              'cicle': '',
              'due_on': '',

            });
          }
        }
      }

    },

    generate_floor(type) {


      if (!this.form.number_of_floor) {
        toast({
          type: 'warning',
          title: 'Please Select Number of Floors First'
        });
        this.form.number_of_upper_floor = "";
        return;
      }


      let total_floor = this.form.number_of_floor * 1;
      let total_roof = this.form.number_of_roof_top * 1;
      let total_upper_floor = this.form.number_of_upper_floor * 1;
      let total_ground = this.form.number_of_ground_floor * 1;
      let total_under_ground = this.form.number_of_under_ground * 1;
      let total_floor2 = total_roof + total_upper_floor + total_ground + total_under_ground;

      if (total_floor2 > total_floor) {
        toast({
          type: 'warning',
          title: 'Total Number of Rof Top, Upper Floors,Ground Floor and Under Ground Can not be more than Total Number of Floors.'
        });

        if (type == 1) this.form.number_of_roof_top = "";
        if (type == 2) this.form.number_of_upper_floor = "";
        if (type == 3) this.form.number_of_ground_floor = "";
        if (type == 4) this.form.number_of_under_ground = "";
        return;

      }


      if (type == 1) {
        //this.form.roof_top_arr=[];


        let array_length = this.form.roof_top_arr.length;

        if (array_length > this.form.number_of_roof_top) {

          this.form.roof_top_arr.splice(this.form.number_of_roof_top);
          return;
        }

        for (let i = 0; i < this.form.number_of_roof_top; i++) {

          if (array_length <= i) {
            let floor_no = total_floor - i;
            this.form.roof_top_arr.push({
              'id': '',
              'floor_no': floor_no,
              'suites': '',
              'units': '',
              'mechanical_rooms': '',
              'administrative_rooms': '',
              'amenity_rooms': '',
              'service_rooms': '',
              'parking_lot': '',
              'bike_lot': '',
              'storage_lot': '',
              'mailroom': '',
              'common_area': '',

            });
          }

        }
      }

      if (type == 2) {

        if (!this.form.number_of_roof_top) {
          toast({
            type: 'warning',
            title: 'Please Select Number of Roof Top First'
          });
          this.form.number_of_upper_floor = "";
          return;
        }
        //this.form.upper_building_arr=[];

        let array_length = this.form.upper_building_arr.length;

        if (array_length > this.form.number_of_roof_top) {

          this.form.upper_building_arr.splice(this.form.number_of_roof_top);
          return;
        }

        for (let i = 0; i < this.form.number_of_upper_floor; i++) {
          if (array_length <= i) {
            let floor_no = total_floor - total_roof - i;
            this.form.upper_building_arr.push({
              'id': '',
              'floor_no': floor_no,
              'suites': '',
              'units': '',
              'mechanical_rooms': '',
              'administrative_rooms': '',
              'amenity_rooms': '',
              'service_rooms': '',
              'parking_lot': '',
              'bike_lot': '',
              'storage_lot': '',
              'mailroom': '',
              'common_area': '',

            });
          }
        }

      }

      if (type == 3) {
        if (!this.form.number_of_roof_top) {
          toast({
            type: 'warning',
            title: 'Please Select Number of Roof Top First'
          });
          this.form.number_of_ground_floor = "";
          return;
        }

        if (!this.form.number_of_upper_floor) {
          toast({
            type: 'warning',
            title: 'Please Select Number of Upper Floors First'
          });
          this.form.number_of_ground_floor = "";
          return;
        }
        //this.form.ground_building_arr=[];

        let array_length = this.form.ground_building_arr.length;

        if (array_length > this.form.number_of_ground_floor) {

          this.form.ground_building_arr.splice(this.form.number_of_ground_floor);
          return;
        }

        for (let i = 0; i < this.form.number_of_ground_floor; i++) {
          if (array_length <= i) {
            let floor_no = total_floor - total_roof - total_upper_floor - i;
            this.form.ground_building_arr.push({
              'id': '',
              'floor_no': floor_no,
              'suites': '',
              'units': '',
              'mechanical_rooms': '',
              'administrative_rooms': '',
              'amenity_rooms': '',
              'service_rooms': '',
              'parking_lot': '',
              'bike_lot': '',
              'storage_lot': '',
              'mailroom': '',
              'common_area': '',

            });
          }

        }

      }
      if (type == 4) {

        if (!this.form.number_of_roof_top) {
          toast({
            type: 'warning',
            title: 'Please Select Number of Roof Top First'
          });
          this.form.number_of_under_ground = "";
          return;
        }

        if (!this.form.number_of_upper_floor) {
          toast({
            type: 'warning',
            title: 'Please Select Number of Upper Floors First'
          });
          this.form.number_of_under_ground = "";
          return;
        }

        if (!this.form.number_of_ground_floor) {
          toast({
            type: 'warning',
            title: 'Please Select Number of Ground Floors First'
          });
          this.form.number_of_under_ground = "";
          return;
        }


        //this.form.under_ground_building_arr=[];

        let array_length = this.form.under_ground_building_arr.length;

        if (array_length > this.form.number_of_under_ground) {

          this.form.under_ground_building_arr.splice(this.form.number_of_under_ground);
          return;
        }


        for (let i = 0; i < this.form.number_of_under_ground; i++) {
          if (array_length <= i) {


            let floor_no = total_floor - total_roof - total_upper_floor - total_ground - i;
            this.form.under_ground_building_arr.push({

              'id': '',
              'floor_no': floor_no,
              'suites': '',
              'units': '',
              'mechanical_rooms': '',
              'administrative_rooms': '',
              'amenity_rooms': '',
              'service_rooms': '',
              'parking_lot': '',
              'bike_lot': '',
              'storage_lot': '',
              'mailroom': '',
              'common_area': '',

            });
          }
        }

      }
    },

    check_building_dependency(e, type) {
      if (e.target.checked) {
        if (type == 1) {
          this.form.dependent_building = true;
          this.form.independent_building = false;

        } else if (type == 2) {
          this.form.dependent_building = false;
          this.form.independent_building = true;
        }
      } else {
        this.form.dependent_building = false;
        this.form.independent_building = false;
      }
    },
    check_property_type(e, type) {
      if (e.target.checked) {
        if (type == 1) {
          this.form.residential = true;
          this.form.commercial = false;
          this.form.residential_commercial = false;

        } else if (type == 2) {
          this.form.residential = false;
          this.form.commercial = true;
          this.form.residential_commercial = false;
        } else if (type == 3) {
          this.form.residential = false;
          this.form.commercial = false;
          this.form.residential_commercial = true;
        }
      } else {
        this.form.residential = false;
        this.form.commercial = false;
        this.form.residential_commercial = false;
      }
    },

    fetchBuildingProfile() {
      let uri = '/BuildingInfos';
      window.axios.get(uri).then((response) => {

        this.user_type = response.data.user_type;
        this.form.safety_item_list_arr = response.data.safety_item_list_arr;
        this.external_service_provider_list_arr = response.data.external_service_provider_list_arr;
        this.building_contact_list_arr = response.data.building_contact_list_arr;
        this.form.license_and_permit_list_arr = response.data.license_and_permit_list_arr;

        for (let i = 0; i < this.external_service_provider_list_arr.length; i++) {

          this.form.external_service_provider_details_arr.push({
            'id': '',
            'reference_id': this.external_service_provider_list_arr[i].id,
            'item_name': this.external_service_provider_list_arr[i].item_name,
            'id_no': '',
            'account_no': '',
            'website': '',
            'schedule_date': '',
            'expected_due_date': '',
            'billing_cycle': '',
            'bill_delivery_method': '',
            'payment_method': '',
            'master_id': '',

          });
        }

        for (let i = 0; i < this.building_contact_list_arr.length; i++) {

          if (this.building_contact_list_arr[i].item_type in this.form.building_contact_details_arr == false)
            this.form.building_contact_details_arr[this.building_contact_list_arr[i].item_type] = {};

          this.form.building_contact_details_arr[this.building_contact_list_arr[i].item_type][this.building_contact_list_arr[i].id] = {
            'id': '',
            'reference_id': this.building_contact_list_arr[i].id,
            'item_name': this.building_contact_list_arr[i].item_name,
            'contact_no': '',
            'phone': '',
            'website': '',
            'mobile': '',
            'email': '',
            'hours_of_operation': '',
            'comment': '',
            'master_id': '',

          }
        }

        for (let i = 0; i < response.data.property_management_arr.length; i++) {
          this.form.property_management_type_arr.push({
            'id': '',
            'reference_id': response.data.property_management_arr[i].id,
            'item_name': response.data.property_management_arr[i].val,
            'id_no': '',
            'name': '',
            'phone': '',
            'website': '',
            'mobile': '',
            'email': '',
            'master_id': '',
          });

        }
      });
    },

    add_contact_details(index) {
      this.form.custom_contact_type = index;
      $("#customContactModal").modal('show');
      $('.modal.fade').addClass('modal fade show');
      $('modal-backdrop').addClass('modal-backdrop fade show');

    },

    add_contact_details_back(index) {

      if (index in this.form.building_contact_details_arr == false)
        this.form.building_contact_details_arr[index] = {};

      this.form.building_contact_details_arr[index][this.building_contact_list_arr[i].id] = {
        'id': '',
        'reference_id': this.building_contact_list_arr[i].id,
        'item_name': this.building_contact_list_arr[i].item_name,
        'contact_no': '',
        'phone': '',
        'website': '',
        'mobile': '',
        'email': '',
        'hours_of_operation': '',
        'comments': '',
        'master_id': '',

      }
    },

    addNewCustomField() {
      if (!this.form.custom_field_name) {
        toast({
          type: 'warning',
          title: 'Please select Custom Field Name'
        });
        return;
      }


      this.form.post('/AddCustomContacts').then(({data}) => {

        var response_data = data.split("**");
        if (response_data[0] == 1) {
          toast({
            type: 'success',
            title: 'Custom Field Added Successfully'
          });


          var custom_field_id = response_data[1];
          if (this.form.custom_contact_type in this.form.building_contact_details_arr == false)
            this.form.building_contact_details_arr[this.form.custom_contact_type] = {};

          this.form.building_contact_details_arr[this.form.custom_contact_type][custom_field_id] = {
            'id': '',
            'reference_id': custom_field_id,
            'item_name': this.form.custom_field_name,
            'contact_no': '',
            'phone': '',
            'website': '',
            'mobile': '',
            'email': '',
            'hours_of_operation': '',
            'comments': '',
            'master_id': '',

          }
          this.form.custom_field_name = '';
          this.form.custom_contact_type = '';

          $("#exampleModal").modal("hide");
          $('.modal.in').modal('hide');
          $('.modal-backdrop').remove();

        } else {

          toast({
            type: 'danger',
            title: 'Invalid Operation'
          });
          return;
        }
      });

    },

    deleteCustomer() {

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {

        this.form.delete('/BuildingInfos/' + this.form.id).then(() => {

          if (result.value) {
            showAlert(
                'Deleted!',
                'Your Data has been deleted.',
                'success'
            );
            this.form.reset();
            this.fetchBuildingProfile();
          }

        }).catch(() => {
          showAlert("failed!", "there was some wrong", "warning");
        });

      })
    },

    updateBuildingInfo() {


      this.form.put('/BuildingInfos/' + this.form.id).then(({data}) => {
        var response_data = data.split("**");
        if (response_data[0] == 1) {
          toast({
            type: 'success',
            title: 'Data Update Successfully'
          });


          this.editBuildingInfo(response_data[1]);
          this.editmode = true;

        } else {

          toast({
            type: 'danger',
            title: 'Invalid Operation'
          });
        }
      });
    },

    save_stay(type) {


      if (this.form.dependent_building == false && this.form.independent_building == false) {

        showAlert("Warning!", "Please Select Dependency Class", "warning");
        return;

      }
      if (this.form.residential == false && this.form.commercial == false && this.form.residential_commercial == false) {

        showAlert("Warning!", "Please Select Property Type", "warning");
        return;

      }

      this.form.post('/BuildingInfos').then(({data}) => {
        var response_data = data.split("**");
        if (response_data[0] == 1) {
          toast({
            type: 'success',
            title: 'Data Save Successfully'
          });

          if (type == 1) {
            this.editBuildingInfo(response_data[1]);
            this.editmode = true;
          } else if (type == 2) {
            window.location.href = '/Dashboard';

          } else if (type == 3) {
            this.form.reset();
            this.fetchBuildingProfile();
          }
        } else {

          toast({
            type: 'danger',
            title: 'Invalid Operation'
          });
        }
      })
    },

    fetchBuildingUpdate(id) {
      this.form.reset();

      let uri = '/BuildingInfos/' + id + '/edit';
      window.axios.get(uri).then((response) => {

        this.form.safety_item_list_arr = response.data.safety_item_list_arr;
        this.external_service_provider_list_arr = response.data.external_service_provider_list_arr;
        this.building_contact_list_arr = response.data.building_contact_list_arr;
        this.form.license_and_permit_list_arr = response.data.license_and_permit_list_arr;

        this.form.id = response.data.building_data[0].id;
        this.form.company_name = response.data.building_data[0].company_name;
        this.form.building_no = response.data.building_data[0].building_no;
        this.form.building_name = response.data.building_data[0].building_name;
        this.form.total_building_size = response.data.building_data[0].total_building_size;
        this.form.building_uom = response.data.building_data[0].building_uom;
        this.form.number_of_floor = response.data.building_data[0].number_of_floor;
        this.form.number_of_upper_floor = response.data.building_data[0].number_of_upper_floor;
        this.form.number_of_roof_top = response.data.building_data[0].number_of_roof_top;
        this.form.number_of_ground_floor = response.data.building_data[0].number_of_ground_floor;
        this.form.number_of_under_ground = response.data.building_data[0].number_of_under_ground;
        this.form.dependent_building = response.data.building_data[0].dependent_building;
        this.form.independent_building = response.data.building_data[0].independent_building;
        this.form.residential = response.data.building_data[0].residential;
        this.form.commercial = response.data.building_data[0].commercial;
        this.form.residential_commercial = response.data.building_data[0].residential_commercial;

        this.form.roof_top_arr = [];
        for (let i = 0; i < response.data.building_property_details_arr.length; i++) {
          if (response.data.building_property_details_arr[i].floor_type == 1) {

            this.form.roof_top_arr.push({
              'id': response.data.building_property_details_arr[i].id,
              'floor_no': response.data.building_property_details_arr[i].floor_type,
              'suites': response.data.building_property_details_arr[i].total_suite,
              'units': response.data.building_property_details_arr[i].total_unit,
              'mechanical_rooms': response.data.building_property_details_arr[i].total_mechanical_room,
              'administrative_rooms': response.data.building_property_details_arr[i].total_administrative_room,
              'amenity_rooms': response.data.building_property_details_arr[i].total_amenity_room,
              'service_rooms': response.data.building_property_details_arr[i].total_service_room,
              'parking_lot': response.data.building_property_details_arr[i].total_parking_lot,
              'bike_lot': response.data.building_property_details_arr[i].total_bike_lot,
              'storage_lot': response.data.building_property_details_arr[i].total_storage_lot,
              'mailroom': response.data.building_property_details_arr[i].total_mailroom,
              'common_area': response.data.building_property_details_arr[i].total_common_area,

            });

          } else if (response.data.building_property_details_arr[i].floor_type == 2) {

            this.form.upper_building_arr.push({
              'id': response.data.building_property_details_arr[i].id,
              'floor_no': response.data.building_property_details_arr[i].floor_type,
              'suites': response.data.building_property_details_arr[i].total_suite,
              'units': response.data.building_property_details_arr[i].total_unit,
              'mechanical_rooms': response.data.building_property_details_arr[i].total_mechanical_room,
              'administrative_rooms': response.data.building_property_details_arr[i].total_administrative_room,
              'amenity_rooms': response.data.building_property_details_arr[i].total_amenity_room,
              'service_rooms': response.data.building_property_details_arr[i].total_service_room,
              'parking_lot': response.data.building_property_details_arr[i].total_parking_lot,
              'bike_lot': response.data.building_property_details_arr[i].total_bike_lot,
              'storage_lot': response.data.building_property_details_arr[i].total_storage_lot,
              'mailroom': response.data.building_property_details_arr[i].total_mailroom,
              'common_area': response.data.building_property_details_arr[i].total_common_area,

            });

          } else if (response.data.building_property_details_arr[i].floor_type == 3) {

            this.form.ground_building_arr.push({
              'id': response.data.building_property_details_arr[i].id,
              'floor_no': response.data.building_property_details_arr[i].floor_type,
              'suites': response.data.building_property_details_arr[i].total_suite,
              'units': response.data.building_property_details_arr[i].total_unit,
              'mechanical_rooms': response.data.building_property_details_arr[i].total_mechanical_room,
              'administrative_rooms': response.data.building_property_details_arr[i].total_administrative_room,
              'amenity_rooms': response.data.building_property_details_arr[i].total_amenity_room,
              'service_rooms': response.data.building_property_details_arr[i].total_service_room,
              'parking_lot': response.data.building_property_details_arr[i].total_parking_lot,
              'bike_lot': response.data.building_property_details_arr[i].total_bike_lot,
              'storage_lot': response.data.building_property_details_arr[i].total_storage_lot,
              'mailroom': response.data.building_property_details_arr[i].total_mailroom,
              'common_area': response.data.building_property_details_arr[i].total_common_area,

            });

          } else if (response.data.building_property_details_arr[i].floor_type == 4) {

            this.form.under_ground_building_arr.push({
              'id': response.data.building_property_details_arr[i].id,
              'floor_no': response.data.building_property_details_arr[i].floor_type,
              'suites': response.data.building_property_details_arr[i].total_suite,
              'units': response.data.building_property_details_arr[i].total_unit,
              'mechanical_rooms': response.data.building_property_details_arr[i].total_mechanical_room,
              'administrative_rooms': response.data.building_property_details_arr[i].total_administrative_room,
              'amenity_rooms': response.data.building_property_details_arr[i].total_amenity_room,
              'service_rooms': response.data.building_property_details_arr[i].total_service_room,
              'parking_lot': response.data.building_property_details_arr[i].total_parking_lot,
              'bike_lot': response.data.building_property_details_arr[i].total_bike_lot,
              'storage_lot': response.data.building_property_details_arr[i].total_storage_lot,
              'mailroom': response.data.building_property_details_arr[i].total_mailroom,
              'common_area': response.data.building_property_details_arr[i].total_common_area,

            });

          }

        }


        for (let i = 0; i < response.data.property_management_arr.length; i++) {


          this.form.property_management_type_arr.push({
            'id': response.data.property_management_arr[i].id,
            'reference_id': response.data.property_management_arr[i].reference_id,
            'item_name': response.data.property_management_arr[i].item_name,
            'id_no': response.data.property_management_arr[i].id_no,
            'name': response.data.property_management_arr[i].name,
            'phone': response.data.property_management_arr[i].phone,
            'website': response.data.property_management_arr[i].website,
            'mobile': response.data.property_management_arr[i].mobile,
            'email': response.data.property_management_arr[i].email,
            // 'master_id':response.data.property_management_arr[i].master_id,
          });

        }


        for (let i = 0; i < response.data.safety_device_equipment_arr.length; i++) {


          if (response.data.safety_device_equipment_arr[i].item_id == 1) {
            this.form.fire_extinguisher_details_arr.push({
              'id': response.data.safety_device_equipment_arr[i].id,
              'reference_id': response.data.safety_device_equipment_arr[i].reference_id,
              'item_id': response.data.safety_device_equipment_arr[i].item_id,
              'reference_name': response.data.safety_device_equipment_arr[i].reference_name,
              'name': response.data.safety_device_equipment_arr[i].name,
              'comments': response.data.safety_device_equipment_arr[i].comments,
              'floor_no': response.data.safety_device_equipment_arr[i].floor_no,
              'serial_no': response.data.safety_device_equipment_arr[i].serial_no,
              'expiry_date': response.data.safety_device_equipment_arr[i].expiry_date,
              'renew_date': response.data.safety_device_equipment_arr[i].renew_date,
              'cicle': response.data.safety_device_equipment_arr[i].cicle,
              'due_on': response.data.safety_device_equipment_arr[i].due_on,

            });
          } else if (response.data.safety_device_equipment_arr[i].item_id == 2) {
            this.form.smoke_detecter_details_arr.push({
              'id': response.data.safety_device_equipment_arr[i].id,
              'reference_id': response.data.safety_device_equipment_arr[i].reference_id,
              'item_id': response.data.safety_device_equipment_arr[i].item_id,
              'reference_name': response.data.safety_device_equipment_arr[i].reference_name,
              'name': response.data.safety_device_equipment_arr[i].name,
              'comments': response.data.safety_device_equipment_arr[i].comments,
              'floor_no': response.data.safety_device_equipment_arr[i].floor_no,
              'serial_no': response.data.safety_device_equipment_arr[i].serial_no,
              'expiry_date': response.data.safety_device_equipment_arr[i].expiry_date,
              'renew_date': response.data.safety_device_equipment_arr[i].renew_date,
              'cicle': response.data.safety_device_equipment_arr[i].cicle,
              'due_on': response.data.safety_device_equipment_arr[i].due_on,

            });
          } else if (response.data.safety_device_equipment_arr[i].item_id == 3) {
            this.form.sprinkler_details_arr.push({
              'id': response.data.safety_device_equipment_arr[i].id,
              'reference_id': response.data.safety_device_equipment_arr[i].reference_id,
              'item_id': response.data.safety_device_equipment_arr[i].item_id,
              'reference_name': response.data.safety_device_equipment_arr[i].reference_name,
              'name': response.data.safety_device_equipment_arr[i].name,
              'comments': response.data.safety_device_equipment_arr[i].comments,
              'floor_no': response.data.safety_device_equipment_arr[i].floor_no,
              'serial_no': response.data.safety_device_equipment_arr[i].serial_no,
              'expiry_date': response.data.safety_device_equipment_arr[i].expiry_date,
              'renew_date': response.data.safety_device_equipment_arr[i].renew_date,
              'cicle': response.data.safety_device_equipment_arr[i].cicle,
              'due_on': response.data.safety_device_equipment_arr[i].due_on,

            });
          } else if (response.data.safety_device_equipment_arr[i].item_id == 4) {
            this.form.water_valve_details_arr.push({
              'id': response.data.safety_device_equipment_arr[i].id,
              'reference_id': response.data.safety_device_equipment_arr[i].reference_id,
              'item_id': response.data.safety_device_equipment_arr[i].item_id,
              'reference_name': response.data.safety_device_equipment_arr[i].reference_name,
              'name': response.data.safety_device_equipment_arr[i].name,
              'comments': response.data.safety_device_equipment_arr[i].comments,
              'floor_no': response.data.safety_device_equipment_arr[i].floor_no,
              'serial_no': response.data.safety_device_equipment_arr[i].serial_no,
              'expiry_date': response.data.safety_device_equipment_arr[i].expiry_date,
              'renew_date': response.data.safety_device_equipment_arr[i].renew_date,
              'cicle': response.data.safety_device_equipment_arr[i].cicle,
              'due_on': response.data.safety_device_equipment_arr[i].due_on,

            });
          } else if (response.data.safety_device_equipment_arr[i].item_id == 5) {
            this.form.gfci_breaker_details_arr.push({
              'id': response.data.safety_device_equipment_arr[i].id,
              'reference_id': response.data.safety_device_equipment_arr[i].reference_id,
              'item_id': response.data.safety_device_equipment_arr[i].item_id,
              'reference_name': response.data.safety_device_equipment_arr[i].reference_name,
              'name': response.data.safety_device_equipment_arr[i].name,
              'comments': response.data.safety_device_equipment_arr[i].comments,
              'floor_no': response.data.safety_device_equipment_arr[i].floor_no,
              'serial_no': response.data.safety_device_equipment_arr[i].serial_no,
              'expiry_date': response.data.safety_device_equipment_arr[i].expiry_date,
              'renew_date': response.data.safety_device_equipment_arr[i].renew_date,
              'cicle': response.data.safety_device_equipment_arr[i].cicle,
              'due_on': response.data.safety_device_equipment_arr[i].due_on,

            });
          } else if (response.data.safety_device_equipment_arr[i].item_id == 6) {
            this.form.sump_pump_details_arr.push({
              'id': response.data.safety_device_equipment_arr[i].id,
              'reference_id': response.data.safety_device_equipment_arr[i].reference_id,
              'item_id': response.data.safety_device_equipment_arr[i].item_id,
              'reference_name': response.data.safety_device_equipment_arr[i].reference_name,
              'name': response.data.safety_device_equipment_arr[i].name,
              'comments': response.data.safety_device_equipment_arr[i].comments,
              'floor_no': response.data.safety_device_equipment_arr[i].floor_no,
              'serial_no': response.data.safety_device_equipment_arr[i].serial_no,
              'expiry_date': response.data.safety_device_equipment_arr[i].expiry_date,
              'renew_date': response.data.safety_device_equipment_arr[i].renew_date,
              'cicle': response.data.safety_device_equipment_arr[i].cicle,
              'due_on': response.data.safety_device_equipment_arr[i].due_on,

            });
          } else if (response.data.safety_device_equipment_arr[i].item_id == 7) {
            this.form.emergency_bell_details_arr.push({
              'id': response.data.safety_device_equipment_arr[i].id,
              'reference_id': response.data.safety_device_equipment_arr[i].reference_id,
              'item_id': response.data.safety_device_equipment_arr[i].item_id,
              'reference_name': response.data.safety_device_equipment_arr[i].reference_name,
              'name': response.data.safety_device_equipment_arr[i].name,
              'comments': response.data.safety_device_equipment_arr[i].comments,
              'floor_no': response.data.safety_device_equipment_arr[i].floor_no,
              'serial_no': response.data.safety_device_equipment_arr[i].serial_no,
              'expiry_date': response.data.safety_device_equipment_arr[i].expiry_date,
              'renew_date': response.data.safety_device_equipment_arr[i].renew_date,
              'cicle': response.data.safety_device_equipment_arr[i].cicle,
              'due_on': response.data.safety_device_equipment_arr[i].due_on,

            });
          } else if (response.data.safety_device_equipment_arr[i].item_id == 8) {
            this.form.emergency_light_arr.push({
              'id': response.data.safety_device_equipment_arr[i].id,
              'reference_id': response.data.safety_device_equipment_arr[i].reference_id,
              'item_id': response.data.safety_device_equipment_arr[i].item_id,
              'reference_name': response.data.safety_device_equipment_arr[i].reference_name,
              'name': response.data.safety_device_equipment_arr[i].name,
              'comments': response.data.safety_device_equipment_arr[i].comments,
              'floor_no': response.data.safety_device_equipment_arr[i].floor_no,
              'serial_no': response.data.safety_device_equipment_arr[i].serial_no,
              'expiry_date': response.data.safety_device_equipment_arr[i].expiry_date,
              'renew_date': response.data.safety_device_equipment_arr[i].renew_date,
              'cicle': response.data.safety_device_equipment_arr[i].cicle,
              'due_on': response.data.safety_device_equipment_arr[i].due_on,

            });
          } else if (response.data.safety_device_equipment_arr[i].item_id == 9) {
            this.form.first_aid_station_arr.push({
              'id': response.data.safety_device_equipment_arr[i].id,
              'reference_id': response.data.safety_device_equipment_arr[i].reference_id,
              'item_id': response.data.safety_device_equipment_arr[i].item_id,
              'reference_name': response.data.safety_device_equipment_arr[i].reference_name,
              'name': response.data.safety_device_equipment_arr[i].name,
              'comments': response.data.safety_device_equipment_arr[i].comments,
              'floor_no': response.data.safety_device_equipment_arr[i].floor_no,
              'serial_no': response.data.safety_device_equipment_arr[i].serial_no,
              'expiry_date': response.data.safety_device_equipment_arr[i].expiry_date,
              'renew_date': response.data.safety_device_equipment_arr[i].renew_date,
              'cicle': response.data.safety_device_equipment_arr[i].cicle,
              'due_on': response.data.safety_device_equipment_arr[i].due_on,

            });
          } else if (response.data.safety_device_equipment_arr[i].item_id == 10) {
            this.form.first_aid_box_arr.push({
              'id': response.data.safety_device_equipment_arr[i].id,
              'reference_id': response.data.safety_device_equipment_arr[i].reference_id,
              'item_id': response.data.safety_device_equipment_arr[i].item_id,
              'reference_name': response.data.safety_device_equipment_arr[i].reference_name,
              'name': response.data.safety_device_equipment_arr[i].name,
              'comments': response.data.safety_device_equipment_arr[i].comments,
              'floor_no': response.data.safety_device_equipment_arr[i].floor_no,
              'serial_no': response.data.safety_device_equipment_arr[i].serial_no,
              'expiry_date': response.data.safety_device_equipment_arr[i].expiry_date,
              'renew_date': response.data.safety_device_equipment_arr[i].renew_date,
              'cicle': response.data.safety_device_equipment_arr[i].cicle,
              'due_on': response.data.safety_device_equipment_arr[i].due_on,

            });
          } else if (response.data.safety_device_equipment_arr[i].item_id == 11) {
            this.form.aed_arr.push({
              'id': response.data.safety_device_equipment_arr[i].id,
              'reference_id': response.data.safety_device_equipment_arr[i].reference_id,
              'item_id': response.data.safety_device_equipment_arr[i].item_id,
              'reference_name': response.data.safety_device_equipment_arr[i].reference_name,
              'name': response.data.safety_device_equipment_arr[i].name,
              'comments': response.data.safety_device_equipment_arr[i].comments,
              'floor_no': response.data.safety_device_equipment_arr[i].floor_no,
              'serial_no': response.data.safety_device_equipment_arr[i].serial_no,
              'expiry_date': response.data.safety_device_equipment_arr[i].expiry_date,
              'renew_date': response.data.safety_device_equipment_arr[i].renew_date,
              'cicle': response.data.safety_device_equipment_arr[i].cicle,
              'due_on': response.data.safety_device_equipment_arr[i].due_on,

            });
          }

        }


        for (let i = 0; i < this.external_service_provider_list_arr.length; i++) {

          this.form.external_service_provider_details_arr.push({
            'id': this.external_service_provider_list_arr[i].id,
            'reference_id': this.external_service_provider_list_arr[i].reference_id,
            'item_name': this.external_service_provider_list_arr[i].item_name,
            'id_no': this.external_service_provider_list_arr[i].id_no,
            'account_no': this.external_service_provider_list_arr[i].account_no,
            'website': this.external_service_provider_list_arr[i].id,
            'schedule_date': this.external_service_provider_list_arr[i].schedule_date,
            'expected_due_date': this.external_service_provider_list_arr[i].expected_due_date,
            'billing_cycle': this.external_service_provider_list_arr[i].billing_cycle,
            'bill_delivery_method': this.external_service_provider_list_arr[i].bill_delivery_method,
            'payment_method': this.external_service_provider_list_arr[i].payment_method,
            'master_id': this.external_service_provider_list_arr[i].master_id,

          });
        }


        for (let i = 0; i < this.building_contact_list_arr.length; i++) {
          if (this.building_contact_list_arr[i].item_type in this.form.building_contact_details_arr == false)
            this.form.building_contact_details_arr[this.building_contact_list_arr[i].item_type] = {};

          this.form.building_contact_details_arr[this.building_contact_list_arr[i].item_type][this.building_contact_list_arr[i].reference_id] = {
            'id': this.building_contact_list_arr[i].id,
            'reference_id': this.building_contact_list_arr[i].reference_id,
            'item_name': this.building_contact_list_arr[i].item_name,
            'contact_no': this.building_contact_list_arr[i].contact_no,
            'phone': this.building_contact_list_arr[i].phone,
            'website': this.building_contact_list_arr[i].website,
            'mobile': this.building_contact_list_arr[i].mobile,
            'email': this.building_contact_list_arr[i].email,
            'hours_of_operation': this.building_contact_list_arr[i].hours_of_operation,
            'comment': this.building_contact_list_arr[i].comment,
            'master_id': this.building_contact_list_arr[i].master_id,

          }
        }


        this.editmode = true;


      });


    },
  }

}

</script>