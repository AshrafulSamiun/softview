<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateMailRoom() : createMailRoom()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Mail Room</h1>
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
                                <td>{{ row.building_name }}</td>
                                <td>{{ row.floor_no }}</td>
                                <td>{{ row.system_no }}</td>
                                <td>{{ row.property_name }}</td>
                                <td>{{ row.room_no }}</td>

                                <td>{{ row.room_name }}</td>
                                <td>{{ row.room_uom_string}}</td>
                                <td>{{ row.mailroom_size_qty }}</td>
                                <td width="120">
                                    <button class="btn btn-primary btn-sm"  @click.prevent="editMailRoom(row.id)">Edit</button>
                                    <button  class="btn btn-danger btn-sm" @click.prevent="MailRoomDelete(row.id)">Delete</button>
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
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                	<div class="form-box-outer">
    								

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

                                        <label class="fieldlabels">Room No:</label> 
                                        <select v-model="form.room_no"
                                            name="room_no"
                                            class="custom-select" 
                                            @change="change_room_no"
                                            :class="{ 'is-invalid': form.errors.has('room_no') }">
                                            <option disabled value="">--Select Room No-- </option>
                                             <option v-for="room in form.total_mailroom" :value="room">Room No {{form.floor_name_string}}-{{room.toString().padStart(2,"0")}}</option>
                                        </select>
                                        <has-error :form="form" field="room_no"></has-error>
									
                                        <label class="fieldlabels">Room Name:</label> 
                                        <input v-model="form.room_name" 
                                            type="text" 
                                            name="room_name" 
                                            placeholder="Type Room Name" 
                                            :class="{ 'is-invalid': form.errors.has('room_name') }"/>
                                        <has-error :form="form" field="room_name"></has-error> 

                                        <label class="fieldlabels">Strata lot No:</label> 
                                        <input v-model="form.strata_lot_no" 
                                            type="text" 
                                            name="strata_lot_no" 
                                            placeholder="Type Strata lot No" 
                                            :class="{ 'is-invalid': form.errors.has('strata_lot_no') }"/>
                                             <has-error :form="form" field="strata_lot_no"></has-error> 
                                             <div v-if="form.errors.has('strata_lot_no')" v-html="form.errors.get('strata_lot_no')" />
                                          
                                    </div>
                                   
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">

                                        <label class="fieldlabels">Property ID:</label> 
                                        <input v-model="form.system_no" 
                                            type="text" 
                                            name="system_no" 
                                            placeholder="Auto Generated" 
                                            :class="{ 'is-invalid': form.errors.has('system_no') }" disabled/>
                                        <has-error :form="form" field="unit_no"></has-error> 
                                    
                                        <label class="fieldlabels">Property Name:</label> 
                                        <input v-model="form.property_name" 
                                            type="text" 
                                            name="property_name" 
                                            placeholder="Type Property Name" 
                                            :class="{ 'is-invalid': form.errors.has('property_name') }"/>
                                        <has-error :form="form" field="property_name"></has-error> 


                                        <label class="fieldlabels">UOM:</label>
                                        <select v-model="form.room_uom"
                                            name="room_uom"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('room_uom') }" >
                                            <option  value="">--Select Property Customer-- </option>
                                            <option value="1">Square Feet</option>
                                            <option value="2">Square Meter</option>
                                            <option value="3">Square Yard</option>
                                        </select>
                                        <has-error :form="form" field="room_uom"></has-error>

                                        <label class="fieldlabels">Room Size:</label> 
                                        <input v-model="form.mailroom_size_qty" 
                                            type="number" 
                                            name="mailroom_size_qty" 
                                            placeholder="Type Room Size" 
                                            :class="{ 'is-invalid': form.errors.has('mailroom_size_qty') }"/>
                                        <has-error :form="form" field="mailroom_size_qty"></has-error> 

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
                               
                                <div class="col-md-5 col-sm-6 col-xs-12">
                                    
                                    <div class="form-box-outer">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
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


                                                
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
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
                                            <div class="col-md-12 col-sm-6 col-xs-12">
                                                <h4>Summery:</h4>
                                                <div class="form-holder">
                                                    <div class="form-check-inline">
                                                       
                                                        <input type="radio" 
                                                            id="total_mail_box" 
                                                            name="total_mail_box"  disabled >
                                                        <label for="total_mail_box">Total Mail Box: {{form.total_mail_box}}</label><br>

                                                        <input type="radio" 
                                                            id="total_mailroom_size" 
                                                            name="total_mailroom_size" disabled>
                                                        <label for="total_mailroom_size">Mail Room Size: {{form.mailroom_size_qty}}  {{uom_arr[form.room_uom]}}</label><br>

                                                        <input type="radio" 
                                                            id="total_mailbox_size" 
                                                            name="total_mailbox_size" disabled>
                                                        <label for="total_mailbox_size">Total Mail Box Size: {{form.total_mailbox_size}} {{uom_arr[form.room_uom]}} </label><br>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="form-folder">
                        <h3><i class="fa fa-hand-point-right"></i>Mail Room Details <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property()" v-show="!property_show">Show</button> <button type="button" class="btn btn-primary btn-sm" @click="show_hide_property()" v-show="property_show">Hide</button></h3>
                        <div class="form-holder" v-show="property_show">
                            
                            <div class="row align-self-stretch">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-bottom:20px"> 
                                    <div class="form-box-outer">
                                        
                                        <table class="table table_narrow" >
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width=""  >Mail Box No</th>
                                                    <th scope="col" width="" >Property ID</th>
                                                    <th scope="col" width="" >Property Name</th>
                                                    <th scope="col" width="" >UOM</th>
                                                    <th scope="col" width="" >Size</th> 
                                                    <th scope="col" align="cente" width="25%">Comments
                                                    </th>
                                                </tr>
                                                
                                            </thead>
                                            <tbody >
                                                <template v-if="form.total_mailroom>0">
                                                    

                                                    <template v-for="(single_stall,stl) in form.subrooms_list_arr">
                                                        <tr>
                                                            <td width="10%" scope="row" style="padding-left:1% !important"><strong>{{single_stall.item_name}}</strong></td>
                                                            <td width="">

                                                                <input v-model="single_stall.system_no" 
                                                                    type="text"
                                                                    name="stall_system_no[]" 
                                                                    placeholder="Auto Generated"  disabled/>
                                                            </td>
                                                            <td width="">

                                                                <input v-model="single_stall.property_name" 
                                                                    type="text"
                                                                    name="stall_property_name[]" 
                                                                    placeholder="Type Property Name" />
                                                            </td>
                                                            <td width="">
                                                                 {{uom_arr[form.room_uom]}}
                                                            </td>
                                                            <td width="">
                                                                <input v-model="single_stall.item_size" 
                                                                    type="number"
                                                                    class="text-center"
                                                                    @keyup="change_mailbox_size()" 
                                                                    name="stall_size_qty[]" 
                                                                    placeholder="Type Size Qty" /> 
                                                            </td>
                                                             
                                                            <td>
                                                                <input v-model="single_stall.comments" 
                                                                    type="text"
                                                                    name="comments[]" 
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
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td class="text-center">{{form.total_mailbox_size}}</td>
                                                    <td></td>
                                                    

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
                        <button :disabled="form.busy || editmode==false"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                      
                        <button :disabled="form.busy || editmode==true || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="save_stay(1)">Save-Stay</button>
                        <button :disabled="form.busy || editmode==true || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px"  @click="save_stay(2)">Save-Out</button>
                        <button :disabled="form.busy || editmode==true || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px"  @click="save_stay(3)">Save-New</button>
                        <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px" >Update</button>
                        <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click.prevent="deleteMailRoom()">Delete</button>


                         <button :disabled="form.busy || editmode==false || form.posting_status>1"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()" v-if="user_type==9">Post</button>
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
                    room_no:'',
                    room_name:'',
                    property_name:'',
                    mailroom_size_qty:0,
                    total_mail_box:0,
                    room_uom:1, 
                    roof_top:false,
            		upper_floor:false,
            		under_ground:false,
            		ground_floor:false,
                    dependent_building:false,
                    independent_building:false,
                    residential:false,
                    commercial:false,
                    residential_commercial:false,
                    strata_lot_no:'',
                    posting_status:0,
            		         		
                    page_id:10,
                  	id:'',

                    floor_name_string:'',
                    floor_type:'',
                    total_mailroom:'',
                    total_mailbox_size:0,
                    subrooms_list_arr:[],
                    subrooms_list_details_arr:[],

            	}),

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Building Name', field: 'building_name' },
                    { label: 'Floor No', field: 'floor_no' },
                    { label: 'Property ID', field: 'system_no' },
                    { label: 'Property Name', field: 'property_name' },
                    { label: 'Room No', field: 'room_no' },
                    { label: 'Room Name', field: 'room_name' },
                    { label: 'UOM', field: 'room_uom_string' },
                    { label: 'Room Size', field: 'mailroom_size_qty' },
                    { label: 'Action', field: '', sortable: false },
                ],
                rows: [],
                test_collupsable:false,
                general_info_show:true,
                property_show:false,
            	account_disable:true,
            	account_no:'',
                
                building_arr:[],
                floor_arr:[],
                user_type:'',
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
            this.fetchMailRoomProfile();
           // this.editMailRoom(2);
           
        },
		
        computed:{


            
        },
	    methods: {


            editMailRoom(id)
            {
                this.form.reset ();
                this.tempeditmode=true;
                this.list_showable=false;
                let uri = '/MailRooms/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    

                    this.editmode=true;
                    this.user_type                              =response.data.user_type;
                    this.building_arr                           =response.data.building_arr;
                    this.form.subrooms_list_arr                 =response.data.subrooms_list_arr;

                    this.form.id                                =response.data.mail_room_arr.id;
                    this.form.company_name                      =response.data.mail_room_arr.company_name;
                    this.form.strata_lot_no                     =response.data.mail_room_arr.strata_lot_no;
                    this.form.building_name                     =response.data.mail_room_arr.building_name;
                    this.form.posting_status                     =response.data.mail_room_arr.posting_status;
                    this.form.floor_no                          =response.data.mail_room_arr.floor_no;
                    this.form.room_no                           =response.data.mail_room_arr.room_no;
                    this.form.system_no                         =response.data.mail_room_arr.system_no;
                    this.form.system_prefix                     =response.data.mail_room_arr.system_prefix;
                    this.form.property_name                     =response.data.mail_room_arr.property_name;
                    this.form.room_name                         =response.data.mail_room_arr.room_name;
                    this.form.room_uom                          =response.data.mail_room_arr.room_uom;
                    this.form.mailroom_size_qty                 =response.data.mail_room_arr.mailroom_size_qty;
                    this.form.total_mailbox_size                =response.data.mail_room_arr.total_mailbox_size;
                    this.form.total_mail_box                    =response.data.total_mail_box;
                    this.floor_arr                              =response.data.floor_arr;
                    this.form.dependent_building                =response.data.building_info[0].dependent_building;
                    this.form.independent_building              =response.data.building_info[0].independent_building;
                    this.form.residential                       =response.data.building_info[0].residential;
                    this.form.commercial                        =response.data.building_info[0].commercial;
                    this.form.residential_commercial            =response.data.building_info[0].residential_commercial;
                  
                    

                    let floor_type=response.data.floor_type;
                    this.form.floor_type=floor_type;

                    this.form.total_mailroom                    =response.data.total_mailroom;
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
                    
                    this.change_mailbox_size();

                }); 

                this.tempeditmode=false;
                
            },
            change_mailbox_size()
            {
                let total_subroom_size=0;
                this.form.subrooms_list_arr.forEach(function(item,index){

                    if(!item.disable)
                    {
                        total_subroom_size+=(item.item_size)*1;
                    }
                });

                this.form.total_mailbox_size=total_subroom_size;
                                                                        
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
                let uri = '/MailRoomLits';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.mail_room_list;
                });
                this.list_showable=true;
            },

            

            

            change_building()
            {     
                this.floor_arr=[];
                
                let uri = '/MailRoomFloorByBuilding/'+this.form.building_name;
                window.axios.get(uri).then((response) => {
                    
                    this.floor_arr                              =response.data.floor_arr;
                    this.form.dependent_building                =response.data.building_info[0].dependent_building;
                    this.form.independent_building              =response.data.building_info[0].independent_building;
                    this.form.residential                       =response.data.building_info[0].residential;
                    this.form.commercial                        =response.data.building_info[0].commercial;
                    this.form.residential_commercial            =response.data.building_info[0].residential_commercial;
                });
            },


            check_stall_type_total(e,m_name,index,stall,lavel){
                             
            },

            

            change_floor()
            {
                let floor_type=this.floor_arr[this.form.floor_no].floor_type;
                this.form.floor_type=floor_type;

                this.form.total_mailroom         =this.floor_arr[this.form.floor_no].total_mailroom;
                this.form.floor_name_string      =this.floor_arr[this.form.floor_no].floor_no; 
                         
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


            change_room_no(){

                this.form.total_mailbox_size=0;
                let uri = '/loadMailBoxByFloor/'+this.form.floor_no+'/'+this.form.room_no;
                window.axios.get(uri).then((response) => {
                    this.form.subrooms_list_arr                 =response.data.subrooms_list_arr;
                    this.form.total_mail_box                    =response.data.total_mail_box;

                });
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

                    this.form.post('/MailRoomPost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            Swal(
                                'Posted!',
                                'Your Data has been Posted.',
                                'success'
                            );

                            this.editMailRoom(response_data[1]);
                    
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
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


                    this.form.post('/MailRoomRepost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            Swal(
                                'Posted!',
                                'Your Data has been Reposted.',
                                'success'
                            );
                            
                            this.editMailRoom(response_data[1]);
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
                    
                })
                
            },

            adjust()
            { 
                
                this.form.post('/adjustMailRoom/'+this.form.id).then((response)=>{
                    var response_data=response.data.split("**");
                    if(response_data[0]==1)
                    {
                        toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });
                        
                        this.editMailRoom(response_data[1]);
                        
                        this.editmode=true;
                    }
                    else{

                        toast({
                            type: 'danger',
                            title: 'Invalid Operation'
                        });
                    }
                }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
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

        


            fetchMailRoomProfile()
            {
                let uri = '/MailRooms';
                window.axios.get(uri).then((response) => {
                    
                    this.building_arr                           =response.data.building_arr;
                    
                }); 
            },


            MailRoomDelete(id)
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
                    this.form.delete('/MailRooms/'+id).then(()=>{
                        
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
	
            deleteMailRoom()
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
                    this.form.delete('/MailRooms/'+this.form.id).then(()=>{
                        
                        if(result.value) {
                            Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.fetchMailRoomProfile();
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
            },
      

            updateMailRoom()
            { 
                

		        this.form.put('/MailRooms/'+this.form.id).then(({ data })=>{
					var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        
                        this.editMailRoom(response_data[1]);
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

                this.form.post('/MailRooms') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });

                        if(type==1)
                        {
                            this.editMailRoom(response_data[1]);
                            this.editmode=true;
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                            
                        }
                        else if(type==3)
                        {
                            this.form.reset();
                            this.fetchMailRoomProfile();
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