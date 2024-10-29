<template>

    <fieldset>
        <form id="msform" @submit.prevent="editmode ? updateCommonArea() : createCompanyProfile()" @keydown="form.onKeydown($event)">
            <div class="form-card">
                <h1 class="page-head">Common Area</h1>
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
                                <td>{{ row.uom_string }}</td>
                                <td>{{ row.total_size_qty }}</td>
                                <td width="120">
                                    <button class="btn btn-primary btn-sm"  @click.prevent="editCommonArea(row.id)">Edit</button>
                                    <button  class="btn btn-danger btn-sm" @click.prevent="CommonAreaDelete(row.id)">Delete</button>
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
                                                    <option  value="">--Select Floor-- </option>
                                                     <option v-for="(floor,index) in floor_arr" :value="index">Floor-{{floor.floor_no}}</option>
                                                </select>
                                                <has-error :form="form" field="floor_no"></has-error> 
                                                <label class="fieldlabels">Property ID:</label> 
                                                <input v-model="form.system_no" 
                                                    type="text" 
                                                    name="system_no" 
                                                    placeholder="Auto Generated" 
                                                    :class="{ 'is-invalid': form.errors.has('system_no') }" disabled/>
                                                <has-error :form="form" field="system_no"></has-error> 
                                            
                                                <label class="fieldlabels">Property Name:</label> 
                                                <input v-model="form.property_name" 
                                                    type="text" 
                                                    name="property_name" 
                                                    placeholder="Type Property Name" 
                                                    :class="{ 'is-invalid': form.errors.has('property_name') }"/>
                                                <has-error :form="form" field="property_name"></has-error> 
                                            </div>
                                            
                                        </div>
                                    </div>
                                   
                                </div>
                               
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                        <label class="fieldlabels">UOM:</label>
                                        <select v-model="form.single_subroom_uom"
                                            name="single_subroom_uom"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('single_subroom_uom') }" >
                                            <option  value="">--Select Property Customer-- </option>
                                            <option value="1">Square Feet</option>
                                            <option value="2">Square Meter</option>
                                            <option value="3">Square Yard</option>
                                        </select>
                                        <has-error :form="form" field="single_subroom_uom"></has-error>

                                        <label class="fieldlabels">Total Size:</label> 
                                        <input v-model="form.total_size_qty" 
                                            type="number" 
                                            name="total_size_qty" 
                                           
                                            :class="{ 'is-invalid': form.errors.has('total_size_qty') }"/>
                                        <has-error :form="form" field="total_size_qty"></has-error> 

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
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                        
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
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder">
                        <h3><i class="fa fa-hand-point-right"></i>Property (Common Area) Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property()" v-show="!property_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property()" v-show="property_show">Hide</button></h3>
                        <div class="form-holder" v-show="property_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer">
                                        
                                        <table class="table table_narrow" >
                                            
                                            <thead>
                                                <tr >
                                                    <th scope="col" rowspan="2">Common Area</th>
                                                    <th scope="col" rowspan="2">Property ID</th>
                                                    <th scope="col" rowspan="2">Property Name</th>
                                                    <th scope="col" rowspan="2" width="200px">Size ( {{uom_arr[form.single_subroom_uom]}} )</th>
                                                    <th scope="col" colspan="7" width="50%">Asign To</th>
                                                </tr>
                                                <tr >
                                                    
                                                    <th scope="col"  >Main Company</th>
                                                    <th scope="col"  >Sub Company</th>
                                                    <th scope="col"  >Property Customer</th>
                                                    <th scope="col"  >Landlord</th>
                                                    <th scope="col"  >Leasholder</th>
                                                    <th scope="col"  >Other 1</th>
                                                    <th scope="col"  >Other 2</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                
                                                
                                                <template v-if="form.total_common_area>0">
                                                    
                                                    <template v-for="(single_subroom,index) in form.subrooms_list_arr" >
                                                                                                          
                                                        <tr>
                                                            <td width="12%" scope="row" style="padding-left:1% !important"><strong>{{single_subroom.item_name}}</strong></td>
                                                            <td width="12%">
                                                                <input v-model="single_subroom.system_no" 
                                                                    type="text" 
                                                                    name="system_no[]"
                                                                    placeholder="Auto Generated" disabled/>
                                                            </td>
                                                            <td width="10%">
                                                                <input v-model="single_subroom.property_name" 
                                                                    type="text" 
                                                                    name="property_name[]" 
                                                                    @keyup="change_room_size()"
                                                                    placeholder="Type Property Name"/>
                                                            </td>
                                                           
                                                            <td width="10%">

                                                                <input v-model="single_subroom.item_size" 
                                                                    type="number"
                                                                    @keyup="change_room_size()" 
                                                                    name="suite_qty[]" 
                                                                    placeholder="Type Qty"/>
                                                            </td>
                                                        
                                                            <td  scope="row" class="form-check-inline text-center">
                                                                <input type="checkbox" 
                                                                    name="assign_main_company[]"
                                                                    @click="check_assign_to($event,single_subroom,1)"
                                                                    v-model="single_subroom.main_company" >
                                                            </td>
                                                            <td  scope="row" class="form-check-inline text-center">
                                                                <input type="checkbox" 
                                                                    name="assign_sub_company[]"
                                                                    @click="check_assign_to($event,single_subroom,2)"
                                                                    v-model="single_subroom.sub_company" >
                                                            </td>
                                                            <td  scope="row" class="form-check-inline text-center">
                                                                <input type="checkbox" 
                                                                    name="assign_property_customer[]"
                                                                    @click="check_assign_to($event,single_subroom,3)"
                                                                    v-model="single_subroom.property_customer" >
                                                            </td>
                                                            <td  scope="row" class="form-check-inline text-center">
                                                                <input type="checkbox" 
                                                                    name="assign_landlord[]"
                                                                    @click="check_assign_to($event,single_subroom,4)"
                                                                    v-model="single_subroom.landlord" >
                                                            </td>
                                                            <td  scope="row" class="form-check-inline text-center">
                                                                <input type="checkbox" 
                                                                    name="assign_leasholder[]"
                                                                    @click="check_assign_to($event,single_subroom,5)"
                                                                    v-model="single_subroom.leasholder" >
                                                            </td>
                                                            <td  scope="row" class="form-check-inline text-center">
                                                                <input type="checkbox" 
                                                                    name="assign_other_1[]"
                                                                    @click="check_assign_to($event,single_subroom,6)"
                                                                    v-model="single_subroom.other_1" >
                                                            </td>
                                                            <td  scope="row" class="form-check-inline text-center">
                                                                <input type="checkbox" 
                                                                    name="assign_other_2[]"
                                                                    @click="check_assign_to($event,single_subroom,7)"
                                                                    v-model="single_subroom.other_2" >
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
                                                    <td class="text-center">{{form.total_size_qty}}</td>
                                                </tr>
                                            </tfoot>
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
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deleteCommonArea()">Delete</button>
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
                    property_name:'',
                    system_no:'',
                    system_prefix:'',
                    roof_top:false,
                    upper_floor:false,
                    under_ground:false,
                    ground_floor:false,
                    dependent_building:false,
                    independent_building:false,
                    residential:false,
                    commercial:false,
                    residential_commercial:false,
                   
                    single_subroom_uom:1,               
                    page_id:9,
                    id:'',

                    total_size_qty:'',
                    floor_name_string:'',
                    floor_type:'',
                    total_common_area:'',
                   
                    subrooms_list_arr:[],
                    subrooms_list_details_arr:[],
                    
                }),

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Sub- Company', field: 'company_name' },
                    { label: 'Property Customer', field: 'customer_name' },
                    { label: 'Building Name', field: 'building_name' },
                    { label: 'Floor No', field: 'floor_no' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'UOM', field: 'uom_string' },
                    { label: 'Total Area Size', field: 'total_size_qty' },
                    { label: 'Action', field: '', sortable: false },
                ],
                rows: [],
                test_collupsable:false,
                general_info_show:true,
                property_show:false,
               
                company_arr:[],
                customer_arr:[],
                building_arr:[],
                floor_arr:[],
                uom_arr:['','Square Feet','Square Meter','Square Yard'],
                page: 1,
                per_page:15,
                expanded: null
            }
        },
        
        created: function()
        {
            this.user_menu_name = this.$route.name;
            this.fetchCommonAreaProfile();
            //this.editCommonArea(4);
           
        },
        
        computed:{


            
        },
        methods: {

            check_assign_to(e,single_subroom,type){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        single_subroom.sub_company=false;
                        single_subroom.property_customer=false;
                        single_subroom.landlord=false;
                        single_subroom.leasholder=false;
                        single_subroom.other_1=false;
                        single_subroom.other_2=false;
                        single_subroom.main_company=true;
                        return;
                    }
                    else if(type==2)
                    {
                        single_subroom.main_company=false;
                        single_subroom.property_customer=false;
                        single_subroom.landlord=false;
                        single_subroom.leasholder=false;
                        single_subroom.other_1=false;
                        single_subroom.other_2=false;
                        single_subroom.sub_company=true;
                        return;
                    }
                    else if(type==3)
                    {
                        single_subroom.sub_company=false;
                        single_subroom.main_company=false;
                        single_subroom.landlord=false;
                        single_subroom.leasholder=false;
                        single_subroom.other_1=false;
                        single_subroom.other_2=false;
                        single_subroom.property_customer=true;
                        return;
                    }
                    
                    else if(type==4)
                    {
                        single_subroom.main_company=false;
                        single_subroom.sub_company=false;
                        single_subroom.property_customer=false;
                        single_subroom.leasholder=false;
                        single_subroom.other_1=false;
                        single_subroom.other_2=false;
                        single_subroom.landlord=true;
                        return;
                    }
                    else if(type==5)
                    {
                        single_subroom.main_company=false;
                        single_subroom.sub_company=false;
                        single_subroom.property_customer=false;
                        single_subroom.landlord=false;
                        single_subroom.other_1=false;
                        single_subroom.other_2=false;
                        single_subroom.leasholder=true;
                        return;
                    }
                    else if(type==6)
                    {
                        single_subroom.main_company=false;
                        single_subroom.sub_company=false;
                        single_subroom.property_customer=false;
                        single_subroom.landlord=false;
                        single_subroom.leasholder=false;
                        single_subroom.other_2=false;
                        single_subroom.other_1=true;
                        return;
                    }
                    else if(type==7)
                    {
                        single_subroom.main_company=false;
                        single_subroom.sub_company=false;
                        single_subroom.property_customer=false;
                        single_subroom.landlord=false;
                        single_subroom.leasholder=false;
                        single_subroom.other_1=false;
                        single_subroom.other_2=true;
                        return;
                    }
                }
                else{

                    single_subroom.main_company=false;
                    single_subroom.sub_company=false;
                    single_subroom.property_customer=false;
                    single_subroom.landlord=false;
                    single_subroom.leasholder=false;
                    single_subroom.other_1=false;
                    single_subroom.other_2=false;
                    return;
                } 
            },

            editCommonArea(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/CommonAreas/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    

                    this.editmode=true;
                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.building_arr                           =response.data.building_arr;
                    this.form.subrooms_list_arr                 =response.data.subrooms_list_arr;

                    this.form.id                                =response.data.common_area_arr.id;
                    this.form.company_name                      =response.data.common_area_arr.company_name;
                    this.form.customer_name                     =response.data.common_area_arr.customer_name;
                    this.form.building_name                     =response.data.common_area_arr.building_name;
                    
                    this.form.floor_no                          =response.data.common_area_arr.floor_no;
                    this.form.property_name                     =response.data.common_area_arr.property_name;
                    this.form.system_no                         =response.data.common_area_arr.system_no;
                    this.form.system_prefix                     =response.data.common_area_arr.system_prefix;
                    this.form.single_subroom_uom                =response.data.common_area_arr.single_subroom_uom;
                    this.form.total_size_qty                    =response.data.common_area_arr.total_size_qty;

                    this.floor_arr                              =response.data.floor_arr;
                    this.form.dependent_building                =response.data.building_info[0].dependent_building;
                    this.form.independent_building              =response.data.building_info[0].independent_building;
                    this.form.residential                       =response.data.building_info[0].residential;
                    this.form.commercial                        =response.data.building_info[0].commercial;
                    this.form.residential_commercial            =response.data.building_info[0].residential_commercial;
                  
                   

                    let floor_type=response.data.floor_type;
                    this.form.floor_type=floor_type;

                    this.form.total_common_area                 =response.data.total_common_area;
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
                    
                    
                   // this.change_room_size();

                   

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

                this.form.total_size_qty=total_subroom_size;
                                                                        
            },



            reset_form()
            {

                this.form.reset();
                this.editmode=false;
                this.list_showable=false;
            },

            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/CommonAreaList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.common_area_list;
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
                
                let uri = '/CommonAreaFloorDataByBuilding/'+this.form.building_name;
                window.axios.get(uri).then((response) => {
                    
                    this.floor_arr                              =response.data.floor_arr;
                    this.form.dependent_building                =response.data.building_info[0].dependent_building;
                    this.form.independent_building              =response.data.building_info[0].independent_building;
                    this.form.residential                       =response.data.building_info[0].residential;
                    this.form.commercial                        =response.data.building_info[0].commercial;
                    this.form.residential_commercial            =response.data.building_info[0].residential_commercial;
                });
            },


        
            change_floor()
            {
                if(!this.form.floor_no) return;
                let floor_type=this.floor_arr[this.form.floor_no].floor_type;
                this.form.floor_type=floor_type;

                this.form.total_common_area                 =this.floor_arr[this.form.floor_no].total_common_area;
                this.form.floor_name_string                 =this.floor_arr[this.form.floor_no].floor_no;          
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

                this.form.total_size_qty=0;
                let uri = '/loadCommonAreaByFloor/'+this.form.floor_no;
                window.axios.get(uri).then((response) => {
                    this.form.subrooms_list_arr                 =response.data.subrooms_list_arr;
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


            fetchCommonAreaProfile()
            {
                let uri = '/CommonAreas';
                window.axios.get(uri).then((response) => {
                    

                    this.company_arr                            =response.data.company_arr;
                    this.customer_arr                           =response.data.customer_arr;
                    this.building_arr                           =response.data.building_arr;          
                    
                }); 

                
            },
            CommonAreaDelete(id)
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
                    this.form.delete('/CommonAreas/'+id).then(()=>{
                        
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
    
            deleteCommonArea()
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
                    this.form.delete('/CommonAreas/'+this.form.id).then(()=>{
                        
                        if(result.value) {
                            Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.fetchCommonAreaProfile();
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
            },
      

            updateCommonArea()
            { 
                

                this.form.put('/CommonAreas/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        
                        this.editCommonArea(response_data[1]);
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
               
                this.form.post('/CommonAreas') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });

                        if(type==1)
                        {
                            this.editCommonArea(response_data[1]);
                            this.editmode=true;
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                            
                        }
                        else if(type==3)
                        {
                            this.form.reset();
                            this.fetchCommonAreaProfile();
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