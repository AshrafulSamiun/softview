<template>

    <fieldset>
        <form id="msform" @submit.prevent="editmode ? updateTax() : createTex()" @keydown="form.onKeydown($event)">
            <div class="form-card">
                <h1 class="page-head">Fixed Assets</h1>
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
                                <td>{{ row.asset_category_string }}</td>
                                <td>{{ row.asset_name}}</td>
                                <td>{{ row.serial_no }}</td>
                                <td>{{ row.uom_string }}</td>
                                <td>{{ row.barcode }}</td>
                                <td>{{ row.model }}</td>
                                <td>{{ row.color }}</td>

                                <td width="120">
                                    <button class="btn btn-primary btn-sm"  @click.prevent="editFixedAsset(row.id)">Edit</button>
                                    <button  class="btn btn-danger btn-sm" @click.prevent="TaxDelete(row.id)">Delete</button>
                                </td>
                            </tr>
                        </template>
                    </datatable>
                    <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
                </div>
                <div v-if="!list_showable">
                    <div class="form-folder">
                        <h3><i class="fa fa-hand-point-right"></i> Service Items:
                            
                        </h3>
                        <div class="form-holder" >
                            <div class="row align-self-stretch">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">

                                        <label class="fieldlabels">Asset Code:</label>  
                                        <input v-model="form.system_no" 
                                            type="text" 
                                            name="system_no" 
                                            placeholder="Auto Generated" 
                                            :class="{ 'is-invalid': form.errors.has('system_no') }" readonly/>
                                        <has-error :form="form" field="system_no"></has-error>                                     

                                        <label class="fieldlabels">Name:</label> 
                                        <input v-model="form.asset_name" 
                                            type="text" 
                                            name="asset_name" 
                                            placeholder="Type Name" 
                                            :class="{ 'is-invalid': form.errors.has('asset_name') }"/>
                                        <has-error :form="form" field="asset_name"></has-error>
                                                                           
                                        <label class="fieldlabels">Uom:</label> 
                                        <select v-model="form.uom"
                                            name="uom"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('uom') }">
                                            <option disabled value="">--Select UOM-- </option>
                                            <option v-for="(uom,index) in uom_arr" :value="index">{{uom}}</option>
                                        </select>
                                        <has-error :form="form" field="uom"></has-error>

                                        <label class="fieldlabels">Asset Category:</label> 
                                        <select v-model="form.asset_category"
                                            name="asset_category"
                                            class="custom-select"
                                            @click="change_asset_category" 
                                            :class="{ 'is-invalid': form.errors.has('asset_category') }">
                                            <option disabled value="">--Select Item Category-- </option>
                                             <option v-for="(m_category,ind) in main_category_arr" :value="ind">{{m_category}}</option>
                                             <option  value="Add" style="background-color:rgb(0, 112, 192) !important;color:#fff; ">--Add-- </option>
                                        </select>
                                        <has-error :form="form" field="asset_category"></has-error>

                                        <label class="fieldlabels">Sub Category:</label> 
                                        <select v-model="form.sub_category"
                                            name="sub_category"
                                            class="custom-select"
                                            :class="{ 'is-invalid': form.errors.has('sub_category') }">
                                            <option disabled value="">--Select Sub Category-- </option>
                                             <option v-for="(s_category,index1) in sub_category_arr[form.asset_category]" :value="index1">{{s_category}}</option>
                                             <option  value="Add" style="background-color:rgb(0, 112, 192) !important;color:#fff; ">--Add-- </option>
                                        </select>
                                        <has-error :form="form" field="sub_category"></has-error>

                                        <label class="fieldlabels">Active:</label> 
                                        <select v-model="form.status_active"
                                            name="status_active"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('status_active') }">
                                            <option disabled value="">--Select Status-- </option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                        <has-error :form="form" field="status_active"></has-error>

                                        <label class="fieldlabels">Comments:</label>

                                        <textarea 
                                            v-model="form.comments"
                                                style="height:70px;"
                                                id="comments" 
                                                name="comments" 
                                                rows="6" 
                                                cols="100"
                                                placeholder="Type comments" 
                                            :class="{ 'is-invalid': form.errors.has('comments') }">
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                        <h4>Specifications</h4>
                                        <label class="fieldlabels">Condition:</label>  
                                        <select v-model="form.condition"
                                            name="condition"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('condition') }">
                                            <option disabled value="">--Select Condition-- </option>
                                            <option  value="1">New</option>
                                            <option  value="2">Used</option>
                                        </select>
                                        <has-error :form="form" field="condition"></has-error>                                       
                                        <label class="fieldlabels">Barcode No:</label> 
                                        <input v-model="form.barcode" 
                                            type="text" 
                                            name="barcode" 
                                            placeholder="Type Name" 
                                            :class="{ 'is-invalid': form.errors.has('barcode') }"/>
                                        <has-error :form="form" field="barcode"></has-error>
                                    
                                        <label class="fieldlabels">Serial No:</label> 
                                        <input v-model="form.serial_no" 
                                            type="text" 
                                            name="serial_no" 
                                            placeholder="Type Serial No" 
                                            :class="{ 'is-invalid': form.errors.has('serial_no') }"/>
                                        <has-error :form="form" field="serial_no"></has-error>
                                       
                                        <label class="fieldlabels">Model:</label> 
                                        <input v-model="form.model" 
                                            type="text" 
                                            name="model" 
                                            placeholder="Type Model" 
                                            :class="{ 'is-invalid': form.errors.has('model') }"/>
                                        <has-error :form="form" field="model"></has-error>

                                        <label class="fieldlabels">Color:</label> 
                                        <input v-model="form.color" 
                                            type="text" 
                                            name="color" 
                                            placeholder="Type Color" 
                                            :class="{ 'is-invalid': form.errors.has('color') }"/>
                                        <has-error :form="form" field="color"></has-error>
                                        
                                    </div>
                                </div>
                               
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    
                                    <div class="form-box-outer">
                                        <h4>Dimention</h4>
                                        <table class="table table_narrow" >
                                            
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="15%">Dimension</th>
                                                    <th scope="col" width="45%">UOM</th>
                                                    <th scope="col" width="40%">Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td>Length</td>
                                                    <td>
                                                        <select v-model="form.length_uom"
                                                            name="length_uom"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('length_uom') }">
                                                            <option disabled value="">--Select UOM-- </option>
                                                            <option v-for="(uom,index) in uom_arr" :value="index">{{uom}}</option>
                                                           
                                                        </select>
                                                        <has-error :form="form" field="length_uom"></has-error>
                                                    </td>
                                                    <td>
                                                        <input v-model="form.item_length" 
                                                            type="text" 
                                                            name="item_length" 
                                                            placeholder="Type Item Length" 
                                                            :class="{ 'is-invalid': form.errors.has('item_length') }"/>
                                                        <has-error :form="form" field="item_length"></has-error>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Width</td>
                                                    <td>
                                                        <select v-model="form.width_uom"
                                                            name="width_uom"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('width_uom') }">
                                                            <option disabled value="">--Select UOM-- </option>
                                                            <option v-for="(uom,index) in uom_arr" :value="index">{{uom}}</option>
                                                           
                                                        </select>
                                                        <has-error :form="form" field="width_uom"></has-error>
                                                    </td>
                                                    <td>
                                                        <input v-model="form.item_width" 
                                                            type="text" 
                                                            name="item_width" 
                                                            placeholder="Type Item Width" 
                                                            :class="{ 'is-invalid': form.errors.has('item_width') }"/>
                                                        <has-error :form="form" field="item_width"></has-error>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Height</td>
                                                    <td>
                                                        <select v-model="form.height_uom"
                                                            name="height_uom"
                                                            class="custom-select" 
                                                            :class="{ 'is-invalid': form.errors.has('height_uom') }">
                                                            <option disabled value="">--Select UOM-- </option>
                                                            <option v-for="(uom,index) in uom_arr" :value="index">{{uom}}</option>
                                                           
                                                        </select>
                                                        <has-error :form="form" field="height_uom"></has-error>
                                                    </td>
                                                    <td>
                                                        <input v-model="form.item_height" 
                                                            type="text" 
                                                            name="item_height" 
                                                            placeholder="Type Item Height" 
                                                            :class="{ 'is-invalid': form.errors.has('item_height') }"/>
                                                        <has-error :form="form" field="item_height"></has-error>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <h4>Chart Of Account</h4>
                                        <table class="table table_narrow">
                                            <thead>
                                                <tr>
                                                    <th> Account Type</th>
                                                    <th> Account code-Name </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(accountType,index) in form.account_type_arr">
                                                    <td> {{accountType.name}}</td>
                                                    <td> 
                                                        <input v-model="accountType.chart_of_account" 
                                                            type="text" 
                                                            name="chart_of_account[]"
                                                            @dblclick="chart_of_account_popup(index)" 
                                                            placeholder="Browse Chart Of Account" 
                                                            :class="{ 'is-invalid': form.errors.has('chart_of_account[]') }" readonly/>
                                                        <has-error :form="form" field="chart_of_account[]"></has-error>
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

                    

                  

                    <div class="text-center" v-if="!list_showable">
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Edit</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deleteTax()">Delete</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode">Void</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(1)">Save-Stay</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(2)">Save-Out</button>
                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(3)">Save-New</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
                    </div>
                </div>
                
            </div>
            <!--  Model  -->
                <div class="modal fade model-middle" id="chartOfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
                  <div class="modal-dialog" role="document" >
                    <div class="modal-content" style="width:900px">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Custom field</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" >
                        <div class="form-holder">
                            <table id="tbl_journal_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Main-Group</th>
                                    <th>Sub-Group</th>
                                    <th>Account No</th>
                                    <th>Description</th>
                                    <th>Govt Tax Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="cursor:pointer" v-for="(coa_data,index) in coa_arr"  @click.prevent="account_popup_close(coa_data)"
                                    >
                                    <td>{{ index+1}}</td>
                                    <td>{{ coa_data.sub_group_name }}</td>
                                    <td>{{ coa_data.account_title }}</td>
                                    <td>{{ coa_data.account_no }}</td>
                                    <td>{{ coa_data.description }}</td>
                                    <td>{{ coa_data.govt_tax_code }}</td>
                                
                                </tr>
                            </tbody>
                           
                        </table>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="modelClose()">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

            <!-- Model end -->


            <!--  MOdel  -->
                <div class="modal fade model-middle" id="customAccountTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" >Add Service Category</h5>
                        
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
                                                <label class="fieldlabels">Service Category Name</label> 
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
                        <button type="button" class="btn btn-primary" @click.prevent="addNewCustomField(form.custom_tax_type)" >Add Service Category</button>
                        
                        
                        
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
                    system_no:'',
                    asset_category:'',
                    sub_category:'',
                    asset_name:'',
                    serial_no:'',
                    uom:'',
                    condition:'',
                    barcode:'',
                    model:'',
                    color:'',
                    comments:'',
                    status_active:'',
                    id:'',
                    length_uom:'',
                    item_length:'',
                    width_uom:'',
                    item_width:'',
                    height_uom:'',
                    item_height:'',
                    account_type_arr:[],
                    custom_field_name:'',
                }),

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Service Code', field: 'system_no' },
                    { label: 'Service Category', field: 'asset_category_string' },
                    { label: 'Service Title', field: 'asset_name' },
                    { label: 'Description', field: 'serial_no' },
                    { label: 'Service Type', field: 'uom_string' },
                    { label: 'Service Cost', field: 'barcode' },
                    { label: 'Purchase Tax', field: 'model' },
                    { label: 'Sales Tax', field: 'color' },
                    { label: 'Action', field: '', sortable: false },
                ],

                coa_columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Main-Group', field: 'sub_group_name' },
                    { label: 'Tax Code', field: 'account_title' },
                    { label: 'Tax Type', field: 'account_no' },
                    { label: 'Tax Office Name', field: 'description' },
                    { label: 'Tax Rate', field: 'govt_tax_code' },
                   
                    { label: 'Action', field: '', sortable: false },
                ],
                rows: [],
                temp_account_type:"",
                coa_arr:[],
                uom_arr:[],
                sales_tax_arr:[],
                purchase_tax_arr:[],
                asset_category_arr:[],
                main_category_arr:[],
                sub_category_arr:[],
                page: 1,
                per_page:15,
                expanded: null
            }
        },
        
        created: function()
        {
            this.user_menu_name = this.$route.name;
            this.fetchTaxProfile();
        },
        
        computed:{


            
        },
        methods: {


            change_asset_category()
            {
                this.form.sub_category="";
                if(this.form.asset_category=="Add")
                {
                    $("#customAccountTypeModal").modal('show');
                    $('.modal.fade').addClass('modal fade show');
                    $('modal-backdrop').addClass('modal-backdrop fade show') ;
                }
                else
                {
                    return;
                }
            },



            addNewCustomField()
            {   
                if(!this.form.custom_field_name)
                {
                    toast({
                        type: 'warning',
                        title: 'Please Select Service Categroy Name'
                    });
                    return;
                }

                
                this.form.post('/AddServiceCategory') .then(({ data }) => { 
               
                  var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Custom Field Added Successfully'
                        });
  

                        this.asset_category_arr[response_data[1]]=this.form.custom_field_name;
                        this.form.custom_field_name='';

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
            add_account_type(){
               // this.form.custom_contact_type=index;
                $("#customAccountTypeModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
               
            },
            editFixedAsset(id)
            {
                this.form.reset ();
                this.list_showable=false;
                let uri = '/FixedAssets/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    

                    this.editmode=true;

                    this.main_category_arr                       =response.data.main_category;
                    this.sub_category_arr                        =response.data.sub_category;
                    this.coa_arr                                 =response.data.coa_arr;
                    this.uom_arr                                 =response.data.unit_of_measurement;
                    this.form.account_type_arr                   =response.data.account_type_arr;

                    this.form.id                                 =response.data.fixedAsset_data.id;
                    this.form.asset_category                     =response.data.fixedAsset_data.asset_category;
                    this.form.system_no                          =response.data.fixedAsset_data.system_no;
                    this.form.asset_name                         =response.data.fixedAsset_data.asset_name;
                    this.form.serial_no                         =response.data.fixedAsset_data.serial_no;
                    this.form.uom                               =response.data.fixedAsset_data.uom;
                    this.form.sub_category                      =response.data.fixedAsset_data.sub_category;
                    this.form.condition                         =response.data.fixedAsset_data.condition;
                    this.form.model                             =response.data.fixedAsset_data.model;
                    this.form.color                             =response.data.fixedAsset_data.color;
                    this.form.barcode                           =response.data.fixedAsset_data.barcode;
                    this.form.comments                          =response.data.fixedAsset_data.comments;
                    this.form.length_uom                        =response.data.fixedAsset_data.length_uom;
                    this.form.status_active                     =response.data.fixedAsset_data.status_active;
                    this.form.length_uom                        =response.data.fixedAsset_data.length_uom;
                    this.form.item_length                       =response.data.fixedAsset_data.item_length;
                    this.form.width_uom                         =response.data.fixedAsset_data.width_uom;
                    this.form.item_width                        =response.data.fixedAsset_data.item_width;
                    this.form.height_uom                        =response.data.fixedAsset_data.height_uom;
                    this.form.item_height                       =response.data.fixedAsset_data.item_height;
                   
                }); 
            },
      
            reset_form()
            {
                this.form.reset();
                this.editmode=false;
                this.list_showable=false;
                this.fetchTaxProfile();
            },

            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/fixedAssetList';
                window.axios.get(uri).then((response) => {
                    this.rows                                       = response.data.fixed_asset_list;
                });
                this.list_showable=true;
            },

            chart_of_account_popup(accountTypeId)
            {
                this.temp_account_type=accountTypeId;
                $("#chartOfModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
            },

            account_popup_close(coa)
            {
                this.form.account_type_arr[this.temp_account_type].chart_of_account=coa.account_no;
                this.form.account_type_arr[this.temp_account_type].chart_of_account_id=coa.id;

                
                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove() ;
                this.temp_account_type="";

            },
          


            fetchTaxProfile()
            {
                let uri = '/FixedAssets';
                window.axios.get(uri).then((response) => {
                    this.main_category_arr                         =response.data.main_category;
                    this.sub_category_arr                          =response.data.sub_category;
                    this.coa_arr                                 =response.data.coa_arr;
                    this.uom_arr                                 =response.data.unit_of_measurement;
                    this.form.account_type_arr                   =response.data.account_type_arr;

                }); 
            },


            TaxDelete(id)
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
                    this.form.delete('/FixedAssets/'+id).then(()=>{
                        
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
    
            deleteTax()
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
                    this.form.delete('/FixedAssets/'+this.form.id).then(()=>{
                        
                        if(result.value) {
                            Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.fetchTaxProfile();
                        }            

                    }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                    });
               
                })
            },
      

            updateTax()
            { 
                

                this.form.put('/FixedAssets/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        this.editFixedAsset(response_data[1]);
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

                this.form.post('/FixedAssets') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });

                        if(type==1)
                        {
                            this.editTax(response_data[1]);
                            this.editmode=true;
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                            
                        }
                        else if(type==3)
                        {
                            this.form.reset();
                            this.fetchTaxProfile();
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