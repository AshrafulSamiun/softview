<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateTax() : createTex()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Service Items</h1>
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
                                <td>{{ row.service_category_string }}</td>
                                <td>{{ row.service_title}}</td>
                                <td>{{ row.service_description }}</td>
                                <td>{{ row.service_type }}</td>
                                <td>{{ row.service_cost }}</td>
                                <td>{{ row.purchase_tax }}</td>
                                <td>{{ row.sales_tax }}</td>

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
                        <h3><i class="fa fa-hand-point-right"></i> Service Items:
                            
                        </h3>
                        <div class="form-holder" >
                            <div class="row align-self-stretch">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                	<div class="form-box-outer">

                                        <label class="fieldlabels">Service Code:</label>  
                                        <input v-model="form.system_no" 
                                            type="text" 
                                            name="system_no" 
                                            placeholder="Auto Generated" 
                                            :class="{ 'is-invalid': form.errors.has('system_no') }" readonly/>
                                        <has-error :form="form" field="system_no"></has-error>


                                        <label class="fieldlabels">Service Category:</label> 
                                        <select v-model="form.service_category"
                                            name="service_category"
                                            class="custom-select"
                                            @click="change_service_category" 
                                            :class="{ 'is-invalid': form.errors.has('service_category') }">
                                            <option disabled value="">--Select Item Category-- </option>
                                             <option v-for="service_category in service_category_arr" :value="service_category.id">{{service_category.service_name}}</option>
                                             <option  value="Add" style="background-color:rgb(0, 112, 192) !important;color:#fff; ">--Add-- </option>
                                        </select>
                                        <has-error :form="form" field="service_category"></has-error>

                                        <label class="fieldlabels">Service Title:</label> 
                                        <input v-model="form.service_title" 
                                            type="text" 
                                            name="service_title" 
                                            placeholder="Type Service Title" 
                                            :class="{ 'is-invalid': form.errors.has('service_title') }"/>
                                        <has-error :form="form" field="service_title"></has-error>
									
                                        <label class="fieldlabels">Description:</label> 
                                        <input v-model="form.service_description" 
                                            type="text" 
                                            name="service_description" 
                                            placeholder="Type Description" 
                                            :class="{ 'is-invalid': form.errors.has('service_description') }"/>
                                        <has-error :form="form" field="service_description"></has-error>
                                       
                                        <label class="fieldlabels">Service Type:</label> 
                                        <select v-model="form.service_type"
                                            name="service_type"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('service_type') }">
                                            <option disabled value="">--Select Service Type-- </option>
                                            <option value="1">Per Hour</option>
                                            <option value="2">Fixed</option>
                                           
                                        </select>
                                        <has-error :form="form" field="service_type"></has-error>

                                        <label class="fieldlabels">Service Cost:</label> 
                                        <input v-model="form.service_cost" 
                                            type="text" 
                                            name="service_cost" 
                                            placeholder="Type Service Cost" 
                                            :class="{ 'is-invalid': form.errors.has('service_cost') }"/>
                                        <has-error :form="form" field="service_cost"></has-error>
                                    </div>
                                </div>
                                
                               
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    
                                    <div class="form-box-outer">

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
                    service_category:'',
            		service_title:'',
                    service_description:'',
                    service_type:'',
                    service_cost:'',
                    purchase_tax:'',
                    sales_tax:'',
                    status_active:'',
                  	id:'',
                    account_type_arr:[],
                    custom_field_name:'',
            	}),

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Service Code', field: 'system_no' },
                    { label: 'Service Category', field: 'service_category_string' },
                    { label: 'Service Title', field: 'service_title' },
                    { label: 'Description', field: 'service_description' },
                    { label: 'Service Type', field: 'service_type' },
                    { label: 'Service Cost', field: 'service_cost' },
                    { label: 'Purchase Tax', field: 'purchase_tax' },
                    { label: 'Sales Tax', field: 'sales_tax' },
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
            	service_category_arr:[],
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


            change_service_category()
            {
                if(this.form.service_category=="Add")
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

                        
                       

                        this.service_category_arr[response_data[1]]=this.form.custom_field_name;
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
            editTax(id)
            {
                this.form.reset ();
                this.list_showable=false;
                let uri = '/ServiceItems/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    

                    this.editmode=true;

                    this.service_category_arr                    =response.data.service_type_list;
                    this.coa_arr                                 =response.data.coa_arr;
                    this.uom_arr                                 =response.data.unit_of_measurement;
                    this.sales_tax_arr                           =response.data.sales_tax_arr;
                    this.purchase_tax_arr                        =response.data.purchase_tax_arr;
                    this.form.account_type_arr                   =response.data.account_type_arr;

                    this.form.id                                =response.data.ServiceItem_data.id;
                    this.form.service_category                     =response.data.ServiceItem_data.service_category;
                    this.form.system_no                         =response.data.ServiceItem_data.system_no;
                    this.form.service_title                         =response.data.ServiceItem_data.service_title;
                    this.form.service_description                  =response.data.ServiceItem_data.service_description;
                    this.form.service_type                      =response.data.ServiceItem_data.service_type;
                    this.form.service_cost                   =response.data.ServiceItem_data.service_cost;
                    this.form.sales_tax                        =response.data.ServiceItem_data.sales_tax;
                    this.form.purchase_tax                       =response.data.ServiceItem_data.purchase_tax;
                    this.form.status_active                     =response.data.ServiceItem_data.status_active;
                    

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
                let uri = '/serviceItemList';
                window.axios.get(uri).then((response) => {
                    this.rows                                       = response.data.service_item_list;
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
                let uri = '/ServiceItems';
                window.axios.get(uri).then((response) => {
                    
                    this.service_category_arr                    =response.data.service_type_list;
                    this.coa_arr                                 =response.data.coa_arr;
                    this.uom_arr                                 =response.data.unit_of_measurement;
                    this.sales_tax_arr                           =response.data.sales_tax_arr;
                    this.purchase_tax_arr                        =response.data.purchase_tax_arr;
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
                    this.form.delete('/ServiceItems/'+id).then(()=>{
                        
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
                    this.form.delete('/ServiceItems/'+this.form.id).then(()=>{
                        
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
                

		        this.form.put('/ServiceItems/'+this.form.id).then(({ data })=>{
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

                this.form.post('/ServiceItems') .then(({ data }) => { 
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