<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateTax() : createTex()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Inventory Items</h1>
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
                                <td>{{ row.item_category_string }}</td>
                                <td>{{ row.item_name}}</td>
                                <td>{{ row.item_description }}</td>
                                <td>{{ row.uom_string }}</td>
                                <td>{{ row.model }}</td>
                                <td>{{ row.chart_of_account }}</td>

                                <td width="120">
                                    <button class="btn btn-primary btn-sm"  @click.prevent="editTax(row.id)">Edit</button>
                                    <button  class="btn btn-danger btn-sm" @click.prevent="TaxDelete(row.id)">Delete</button>
                                </td>
                            </tr>
                        </template>
                    </datatable>
                    <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
                </div>
                <div v-if="!list_showable">
                    <div class="form-folder">
                        <h3><i class="fa fa-hand-point-right"></i> Inventory Items:
                            
                        </h3>
                        <div class="form-holder" >
                            <div class="row align-self-stretch">
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                	<div class="form-box-outer">

                                        <label class="fieldlabels">Item Code:</label>  
                                        <input v-model="form.system_no" 
                                            type="text" 
                                            name="system_no" 
                                            placeholder="Auto Generated" 
                                            :class="{ 'is-invalid': form.errors.has('system_no') }" readonly/>
                                        <has-error :form="form" field="system_no"></has-error>


                                        <label class="fieldlabels">Item Category:</label> 
                                        <select v-model="form.item_category"
                                            name="item_category"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('item_category') }">
                                            <option disabled value="">--Select Item Category-- </option>
                                             <option v-for="(item_category,index) in item_category_arr" :value="index">{{item_category}}</option>
                                        </select>
                                        <has-error :form="form" field="item_category"></has-error>

                                        <label class="fieldlabels">Item Name:</label> 
                                        <input v-model="form.item_name" 
                                            type="text" 
                                            name="item_name" 
                                            placeholder="Type Name" 
                                            :class="{ 'is-invalid': form.errors.has('item_name') }"/>
                                        <has-error :form="form" field="item_name"></has-error>
									
                                        <label class="fieldlabels">Description:</label> 
                                        <input v-model="form.item_description" 
                                            type="text" 
                                            name="item_description" 
                                            placeholder="Type Description" 
                                            :class="{ 'is-invalid': form.errors.has('item_description') }"/>
                                        <has-error :form="form" field="item_description"></has-error> 

                                       

                                        <label class="fieldlabels">UOM:</label> 
                                        <select v-model="form.uom"
                                            name="uom"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('uom') }">
                                            <option disabled value="">--Select UOM-- </option>
                                            <option v-for="(uom,index) in uom_arr" :value="index">{{uom}}</option>
                                           
                                        </select>
                                        <has-error :form="form" field="uom"></has-error>
                                       
                                        <label class="fieldlabels">Condition:</label> 
                                        <select v-model="form.condition"
                                            name="condition"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('condition') }">
                                            <option disabled value="">--Select Condition-- </option>
                                            <option value="1">New</option>
                                            <option value="2">Used</option>
                                           
                                        </select>
                                        <has-error :form="form" field="condition"></has-error>

                                        <label class="fieldlabels">Model:</label> 
                                        <input v-model="form.model" 
                                            type="text" 
                                            name="model" 
                                            placeholder="Type Model" 
                                            :class="{ 'is-invalid': form.errors.has('model') }"/>
                                        <has-error :form="form" field="model"></has-error>
                                        
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">

                                       <label class="fieldlabels">Storage Requirements:</label>

                                       <textarea 
                                            v-model="form.storage_requirement"
                                                style="height:70px;"
                                                id="storage_requirement" 
                                                name="storage_requirement" 
                                                rows="6" 
                                                cols="100"
                                                placeholder="Type Storage Requirements" 
                                            :class="{ 'is-invalid': form.errors.has('storage_requirement') }">
                                        </textarea>

                                        <label class="fieldlabels">Allowed Negative Qty:</label> 
                                        <select v-model="form.negative_quantity"
                                            name="negative_quantity"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('negative_quantity') }">
                                            <option disabled value="">--Select-- </option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                           
                                        </select>
                                        <has-error :form="form" field="negative_quantity"></has-error>

                                        <label class="fieldlabels">Allowed Negative Amount:</label> 
                                        <select v-model="form.negative_amount"
                                            name="negative_amount"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('negative_amount') }">
                                            <option disabled value="">--Select-- </option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                        <has-error :form="form" field="negative_amount"></has-error>

                                        <label class="fieldlabels">Minimum Inventory:</label> 
                                        <input v-model="form.minimum_quantity" 
                                            type="text" 
                                            name="minimum_quantity" 
                                            placeholder="Type Minimum Inventory" 
                                            :class="{ 'is-invalid': form.errors.has('minimum_quantity') }"/>
                                        <has-error :form="form" field="minimum_quantity"></has-error>

                                        <label class="fieldlabels">Maximum Inventory:</label> 
                                        <input v-model="form.maxmum_quantity" 
                                            type="text" 
                                            name="maxmum_quantity" 
                                            placeholder="Type Maximum Inventory" 
                                            :class="{ 'is-invalid': form.errors.has('maxmum_quantity') }"/>
                                        <has-error :form="form" field="maxmum_quantity"></has-error>

                                        <label class="fieldlabels">Chart Of Account:</label> 
                                        <input v-model="form.chart_of_account" 
                                            type="text" 
                                            name="chart_of_account"
                                            @dblclick="chart_of_account_popup()" 
                                            placeholder="Browse Chart Of Account" 
                                            :class="{ 'is-invalid': form.errors.has('chart_of_account') }" readonly/>
                                        <has-error :form="form" field="chart_of_account"></has-error>                                       
                                    </div>
                                   
                                </div>
                               
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    
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
                                        <label class="fieldlabels">Purchase Taxes:</label> 
                                        <select v-model="form.purchase_tax"
                                            name="purchase_tax"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('purchase_tax') }">
                                            <option disabled value="">--Select-- </option>
                                            <option v-for="(purchase_tax,index) in purchase_tax_arr" :value="index">{{purchase_tax}}</option>
                                            
                                        </select>
                                        <has-error :form="form" field="purchase_tax"></has-error>

                                        <label class="fieldlabels">Sales Taxes:</label> 
                                        <select v-model="form.sales_tax"
                                            name="sales_tax"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('sales_tax') }">
                                            <option disabled value="">--Select-- </option>
                                            <option v-for="(sales_tax,index) in sales_tax_arr" :value="index">{{sales_tax}}</option>
                                        </select>
                                        <has-error :form="form" field="sales_tax"></has-error>

                                        <label class="fieldlabels">Active:</label> 
                                        <select v-model="form.status_active"
                                            name="status_active"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('status_active') }">
                                            <option disabled value="">--Select-- </option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                        <has-error :form="form" field="status_active"></has-error>
                                        
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
                        <h5 class="modal-title" id="exampleModalLabel" v-if="form.custom_tax_type==1">Add Tax Type</h5>

                        <h5 class="modal-title" id="exampleModalLabel" v-if="form.custom_tax_type==2">Add Account Type</h5>
                        
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
                        <button type="button" class="btn btn-primary" @click.prevent="addNewCustomField(form.custom_tax_type)" v-if="form.custom_tax_type==1">Add Staff and Departments</button>
                        <button type="button" class="btn btn-primary" @click.prevent="addNewCustomField(form.custom_tax_type)" v-if="form.custom_tax_type==2">Add Repair and Maintenance</button>
                        
                        
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
                    item_category:'',
            		item_name:'',
                    item_description:'',
                    uom:'',
                    condition:'',
                    model:'',
                    storage_requirement:'', 
                    negative_quantity:'',
                    negative_amount:'',
                    minimum_quantity:'',
                    maxmum_quantity:'',
                    height_uom:'',
                    item_height:'',
                    width_uom:'',
                    item_width:'',
                    length_uom:'',
                    item_length:'',
                    purchase_tax:'',
                    sales_tax:'',
                    status_active:'',
                  	id:'',
                    account_type_arr:[],
                    chart_of_account:'',
                    chart_of_account_id:'',
            	}),

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Code', field: 'system_no' },
                    { label: 'Item Category', field: 'item_category_string' },
                    { label: 'Item Name', field: 'item_name' },
                    { label: 'Item Description', field: 'item_description' },
                    { label: 'UOM', field: 'uom_string' },
                    { label: 'Model', field: 'model' },
                    { label: 'Chart of Account', field: 'chart_of_account' },
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
            	item_category_arr:[],
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
            add_account_type(){
               // this.form.custom_contact_type=index;
                $("#customAccountTypeModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
               
            },
            editTax(id)
            {
                this.form.reset ();
                this.list_showable=false;
                let uri = '/inventoryItems/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    

                    this.editmode=true;
                    this.item_category_arr                      =response.data.item_category;
                    this.form.coa_arr                           =response.data.coa_arr;
                    this.form.purchase_tax_arr                  =response.data.purchase_tax_arr;
                    this.form.sales_tax_arr                     =response.data.sales_tax_arr;
                    this.form.uom_arr                           =response.data.unit_of_measurement;

                    this.form.id                                =response.data.inventory_data_arr.id;
                    this.form.item_category                     =response.data.inventory_data_arr.item_category;
                    this.form.system_no                         =response.data.inventory_data_arr.system_no;
                    this.form.item_name                         =response.data.inventory_data_arr.item_name;
                    this.form.item_description                  =response.data.inventory_data_arr.item_description;
                    this.form.uom                               =response.data.inventory_data_arr.uom;
                    this.form.condition                         =response.data.inventory_data_arr.condition;
                    this.form.model                             =response.data.inventory_data_arr.model;
                    this.form.storage_requirement               =response.data.inventory_data_arr.storage_requirement;
                    this.form.negative_quantity                 =response.data.inventory_data_arr.negative_quantity;

                    this.form.negative_amount                   =response.data.inventory_data_arr.negative_amount;
                    this.form.minimum_quantity                  =response.data.inventory_data_arr.minimum_quantity;
                    this.form.maxmum_quantity                   =response.data.inventory_data_arr.maxmum_quantity;
                    this.form.length_uom                        =response.data.inventory_data_arr.length_uom;
                    this.form.item_length                       =response.data.inventory_data_arr.item_length;

                    this.form.width_uom                         =response.data.inventory_data_arr.width_uom;
                    this.form.item_width                        =response.data.inventory_data_arr.item_width;
                    this.form.height_uom                        =response.data.inventory_data_arr.height_uom;
                    this.form.item_height                       =response.data.inventory_data_arr.item_height;
                    this.form.sales_tax                         =response.data.inventory_data_arr.sales_tax;

                    
                    this.form.purchase_tax                      =response.data.inventory_data_arr.purchase_tax;
                    this.form.chart_of_account                  =response.data.inventory_data_arr.chart_of_account;
                    this.form.chart_of_account_id               =response.data.inventory_data_arr.chart_of_account_id;
                    this.form.status_active                     =response.data.inventory_data_arr.status_active;
                    

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
                let uri = '/inventoryItemList';
                window.axios.get(uri).then((response) => {
                    this.rows                                       = response.data.inventory_item_list;
                });
                this.list_showable=true;
            },

         
        
            chart_of_account_popup()
            {
                $("#chartOfModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
            },
            account_popup_close(coa)
            {
                this.form.chart_of_account=coa.account_no;
                this.form.chart_of_account_id=coa.id;

                
                $('.modal.in').modal('hide');
                $('.modal-backdrop').remove() ;

            },
          


            fetchTaxProfile()
            {
                let uri = '/inventoryItems';
                window.axios.get(uri).then((response) => {
                    
                    this.item_category_arr                       =response.data.item_category;
                    this.coa_arr                                 =response.data.coa_arr;
                    this.uom_arr                                 =response.data.unit_of_measurement;
                    this.sales_tax_arr                           =response.data.sales_tax_arr;
                    this.purchase_tax_arr                        =response.data.purchase_tax_arr;
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
                    this.form.delete('/inventoryItems/'+id).then(()=>{
                        
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
                    this.form.delete('/inventoryItems/'+this.form.id).then(()=>{
                        
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
                

		        this.form.put('/inventoryItems/'+this.form.id).then(({ data })=>{
					var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        
                        this.editTax(response_data[1]);
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

                this.form.post('/inventoryItems') .then(({ data }) => { 
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