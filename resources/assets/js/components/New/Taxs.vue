<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateTax() : createTex()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h1 class="page-head">Taxes</h1>
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
                                <td>{{ row.tin_no }}</td>
                                <td>{{ row.system_no }}</td>
                                <td>{{row.tax_type}}</td>
                                <td>{{ row.tax_office_name }}</td>
                                <td>{{ row.tax_rate }}</td>
                                <td>{{ row.period_name }}</td>
                                <td>{{ row.period_start_date }}</td>
                                <td>{{ row.period_end_date }}</td>

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
                        <h3><i class="fa fa-hand-point-right"></i> General Information:
                            
                        </h3>
                        <div class="form-holder" >
                            <div class="row align-self-stretch">
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                	<div class="form-box-outer">
    									
                                		<label class="fieldlabels">Tax Identification /Business No.</label>  
                                        <input v-model="form.tin_no" 
                                            type="text" 
                                            name="tin_no" 
                                            placeholder="Type Tax Identification /Business No" 
                                            :class="{ 'is-invalid': form.errors.has('tin_no') }"/>
                                        <has-error :form="form" field="tin_no"></has-error>

                                        <label class="fieldlabels">Tax Code:</label>  
                                        
                                        <input v-model="form.system_no" 
                                            type="text" 
                                            name="system_no" 
                                            placeholder="Auto Generated" 
                                            :class="{ 'is-invalid': form.errors.has('system_no') }" readonly/>
                                        <has-error :form="form" field="system_no"></has-error>


                                        <label class="fieldlabels">Tax Type:</label> 
                                        <select v-model="form.tax_type"
                                            name="tax_type"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('tax_type') }">
                                            <option disabled value="">--Select Tax Type-- </option>
                                             <option v-for="(taxType,index) in tax_type_arr" :value="index">{{taxType}}</option>
                                            <option  value="Add">--Add-- </option>
                                        </select>
                                        <has-error :form="form" field="tax_type"></has-error>

                                        <label class="fieldlabels">Tax Office Name:</label> 
                                        <input v-model="form.tax_office_name" 
                                            type="text" 
                                            name="tax_office_name" 
                                            placeholder="Type Tax Office Name" 
                                            :class="{ 'is-invalid': form.errors.has('tax_office_name') }"/>
                                        <has-error :form="form" field="tax_office_name"></has-error>
									
                                        <label class="fieldlabels">Tax Office Address:</label> 
                                        <input v-model="form.tax_office_address" 
                                            type="text" 
                                            name="tax_office_address" 
                                            placeholder="Type Tax Office Address" 
                                            :class="{ 'is-invalid': form.errors.has('tax_office_address') }"/>
                                        <has-error :form="form" field="tax_office_address"></has-error> 

                                        <label class="fieldlabels">Tax Office Contact:</label> 
                                        <input v-model="form.tax_office_contact" 
                                            type="text" 
                                            name="tax_office_contact" 
                                            placeholder="Type Tax Office Contact" 
                                            :class="{ 'is-invalid': form.errors.has('tax_office_contact') }"/>
                                        <has-error :form="form" field="tax_office_contact"></has-error>

                                        <label class="fieldlabels">Tax Rate:</label> 
                                        <input v-model="form.tax_rate" 
                                            type="text" 
                                            name="tax_rate" 
                                            placeholder="Type Tax Rate" 
                                            :class="{ 'is-invalid': form.errors.has('tax_rate') }"/>
                                        <has-error :form="form" field="tax_rate"></has-error> 
                                          
                                    </div>
                                   
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-box-outer">
                                        <h4>Assinged Reporting Period </h4>
                                        <label class="fieldlabels">Period Name:</label> 
                                    
                                        <select v-model="form.period_name"
                                            name="period_name"
                                            class="custom-select" 
                                            
                                            :class="{ 'is-invalid': form.errors.has('period_name') }">
                                            <option disabled value="">--Select Tax Type-- </option>
                                             <option v-for="(reporting_period,index) in reporting_period_arr" :value="index">{{reporting_period}}</option>
                                            
                                        </select>
                                        <has-error :form="form" field="period_name"></has-error> 


                                        <label class="fieldlabels">From:</label>
                                        <date-picker 
                                            style="width:100%"
                                            v-model="form.period_start_date"
                                            name="period_start_date"
                                            lang="en"
                                            type="period_start_date"
                                            format="ddd, MMM D, YYYY"
                                            :class="{ 'is-invalid': form.errors.has('period_start_date') }"></date-picker>
                                          <has-error :form="form" field="period_start_date"></has-error>
                                        
                                        <label class="fieldlabels">To:</label>
                                        <date-picker 
                                            style="width:100%"
                                            v-model="form.period_end_date"
                                            name="period_end_date"
                                            lang="en"
                                            type="period_end_date"
                                            format="ddd, MMM D, YYYY"
                                            :class="{ 'is-invalid': form.errors.has('period_end_date') }"></date-picker>
                                          <has-error :form="form" field="period_end_date"></has-error>
                                        
                                        <label class="fieldlabels">Due On:</label>
                                        <date-picker 
                                            style="width:100%"
                                            v-model="form.period_due_on"
                                            name="period_due_on"
                                            lang="en"
                                            type="period_due_on"
                                            format="ddd, MMM D, YYYY"
                                            :class="{ 'is-invalid': form.errors.has('period_due_on') }"></date-picker>
                                          <has-error :form="form" field="period_due_on"></has-error>

                                        
                                        <label class="fieldlabels">Add To Calendar:</label>
                                        <div class="form-check-inline">
                                            <input type="checkbox" 
                                                id="period_add_calendar" 
                                                name="period_add_calendar" 
                                                v-model="form.period_add_calendar" >
                                            <label for="period_add_calendar">Add To Calendar</label><br>
                                        </div>                                            
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
                                                <tr>
                                                     <td> <button type="button" class="btn btn-primary btn-sm" @click="add_account_type()">Add</button></td>
                                                     <td></td>
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
                    tin_no:'',
                    system_no:'',
                    tax_type:'',
            		tax_office_name:'',
                    tax_office_address:'',
                    tax_office_contact:'',
                    tax_rate:'',
                    period_name:'',
                    period_start_date:'',
                    period_end_date:'',
                    period_due_on:'',
                    period_add_calendar:1, 
                  	id:'',
                    account_type_arr:[],
            	}),

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Tax Identification /Business No', field: 'tin_no' },
                    { label: 'Tax Code', field: 'system_no' },
                    { label: 'Tax Type', field: 'tax_type' },
                    { label: 'Tax Office Name', field: 'tax_office_name' },
                    { label: 'Tax Rate', field: 'tax_rate' },
                    { label: 'Period Name', field: 'period_name' },
                    { label: 'Period Start Date', field: 'period_start_date' },
                    { label: 'Period End Date', field: 'period_end_date' },
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
            	tax_type_arr:[],
                reporting_period_arr:[],
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
                let uri = '/TaxTypes/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    

                    this.editmode=true;
                    this.tax_type_arr                           =response.data.tax_type_arr;
                    this.reporting_period_arr                   =response.data.reporting_period_arr;
                    this.form.account_type_arr                  =response.data.account_type_arr;

                    this.form.id                                =response.data.tax_data_arr.id;
                    this.form.tin_no                            =response.data.tax_data_arr.tin_no;
                    this.form.tax_type                          =response.data.tax_data_arr.tax_type;
                    this.form.system_no                         =response.data.tax_data_arr.system_no;
                    
                    this.form.tax_office_name                   =response.data.tax_data_arr.tax_office_name;
                    this.form.tax_office_address                =response.data.tax_data_arr.tax_office_address;
                    this.form.tax_office_contact                =response.data.tax_data_arr.tax_office_contact;
                    this.form.tax_rate                          =response.data.tax_data_arr.tax_rate;
                    this.form.period_name                       =response.data.tax_data_arr.period_name;
                    this.form.period_start_date                 =response.data.tax_data_arr.period_start_date;
                    this.form.period_end_date                   =response.data.tax_data_arr.period_end_date;
                    this.form.period_due_on                     =response.data.tax_data_arr.period_due_on;
                    this.form.period_add_calendar               =response.data.tax_data_arr.period_add_calendar;
                    this.form.period_add_calendar               =response.data.tax_type_data_arr;

                    
                    

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
                let uri = '/TaxTypesList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.tax_type_list;
                    this.tax_type_arr                            =response.data.tax_type_arr;
                    this.reporting_period_arr                    =response.data.reporting_period_arr;
                    this.form.account_type_arr                   =response.data.account_type_arr;
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
                let uri = '/TaxTypes';
                window.axios.get(uri).then((response) => {
                    
                    this.tax_type_arr                            =response.data.tax_type_arr;
                    this.reporting_period_arr                    =response.data.reporting_period_arr;
                    this.form.account_type_arr                   =response.data.account_type_arr;
                    this.coa_arr                                 =response.data.coa_arr;
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
                    this.form.delete('/TaxTypes/'+id).then(()=>{
                        
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
                    this.form.delete('/TaxTypes/'+this.form.id).then(()=>{
                        
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
                

		        this.form.put('/TaxTypes/'+this.form.id).then(({ data })=>{
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

                this.form.post('/TaxTypes') .then(({ data }) => { 
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