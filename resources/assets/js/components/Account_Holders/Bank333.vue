<template>

   
            <div class="card"> 
                <form id="msform" @submit.prevent="editmode ? updateAccountHolder() : createAccountHolder()" @keydown="form.onKeydown($event)">  
                    <fieldset>
                        <div id="content">
                            <div class="form-card">
                                <h1 class="page-head">Bank Profile</h1> 
                                <div class="text-center"> 
                                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_list()">List</button>
                                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button> 
                                </div> 
                            </div>
                            <div v-if="list_showable" class="form-card">
                                <div class="pull-left" style="margin-top:50px;">
                                    <label for="filter" class="sr-only">Filter</label>
                                    <input type="text" class="form-control" v-model="filter" placeholder="Filter" style="width:400px;">
                                </div>
                                <datatable :columns="columns" :data="rows" :filter-by="filter">
                                    <template slot-scope="{row}">
                                        <tr>
                                            <td>{{ row.sl }}</td>
                                            <td>{{ row.system_no }}</td>
                                            <td>{{ row.account_type_string }}</td>
                                            <td>{{ row.entity_type }}</td>
                                            <td>{{ row.full_name }}</td>
                                            <td>{{ row.email }}</td>
                                            <td>{{ row.cell_phone }}</td>
                                            <td>{{ row.country_name }}</td>
                                            <td>{{ row.industry_sector }}</td>
                                            <td width="120">
                                                <button class="btn btn-primary btn-sm"  @click.prevent="editAccountHolder(row.id)">Edit</button>
                                                <button  class="btn btn-danger btn-sm" @click.prevent="deleteAccountHolder(row.id)">Delete</button>
                                            </td>
                                        </tr>
                                    </template>
                                </datatable>
                                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
                            </div>
                            <div class="form-card" v-if="!list_showable">
                                <div class="form-folder">
                                    <h3><i class="fa fa-hand-point-right"></i>Bank  Information:</h3> 
                                    <div class="form-holder">
                                        <div class="row align-self-stretch"> 
                                            <div class="col-md-4 col-sm-6 col-xs-12"> 
                                                <div class="form-box-outer"> 
                                                    <label class="fieldlabels">ID No:</label> 
                                                    <input type="text" 
                                                        id="system_no" 
                                                        name="system_no" 
                                                        v-model="form.system_no"  
                                                        placeholder="ID No" disabled/> 
                                                    <label class="fieldlabels">Bank Account No:</label>  
                                                        <input 
                                                        v-model="form.bank_acount_no" 
                                                        type="text" 
                                                        name="bank_acount_no" 
                                                        placeholder="Type Bank Account No" 
                                                        :class="{ 'is-invalid': form.errors.has('bank_acount_no') }"/>
                                                    <has-error :form="form" field="bank_acount_no"></has-error> 

                                                    <label class="fieldlabels">Bank Name:</label>
                                                    <input 
                                                        v-model="form.bank_account_name" 
                                                        type="text" 
                                                        name="bank_account_name" 
                                                        placeholder="Type Bank Name" 
                                                        :class="{ 'is-invalid': form.errors.has('bank_account_name') }"/>
                                                    <has-error :form="form" field="bank_account_name"></has-error> 

                                                    
                                                    <label class="fieldlabels" >Branch Name:</label>  
                                                    <input v-model="form.branch_name" 
                                                        type="text" 
                                                        placeholder="Type Branch Name"
                                                        name="branch_name" 
                                                        :class="{ 'is-invalid': form.errors.has('branch_name') }"/>
                                                      <has-error :form="form" field="branch_name"></has-error> 
                                                    
                                                            <label class="fieldlabels">Chart of Accounts:</label> 
                                                            <input v-model="form.chart_of_acocounts" 
                                                                type="text" 
                                                                name="chart_of_acocounts" 
                                                                placeholder="Type Chart of Accounts" 
                                                                :class="{ 'is-invalid': form.errors.has('chart_of_acocounts') }"/>
                                                                 <has-error :form="form" field="chart_of_acocounts"></has-error> 
                                                        
                                                            <label class="fieldlabels">Account Creation Date:</label>  
                                                            <date-picker 
                                                                style="width:100%"
                                                                v-model="form.account_creation_date"
                                                                name="account_creation_date"
                                                                lang="en"
                                                                type="account_creation_date"
                                                                format="DD MMM, YYYY"
                                                                :class="{ 'is-invalid': form.errors.has('account_creation_date') }">
                                                            </date-picker>
                                                            <has-error :form="form" field="account_creation_date"></has-error> 
                                                             
                                                            <label class="fieldlabels">Account Status:</label> 
                                                                <div class="position-relative form-group">
                                                                    <select v-model="form.acount_status"
                                                                        name="acount_status"
                                                                        class="custom-select" 
                                                                        :class="{ 'is-invalid': form.errors.has('acount_status') }">
                                                                        <option disabled value="">--Select-- </option>
                                                                        <option value="1">Active</option> 
                                                                        <option value="2">Inactive</option> 
                                                                    </select>
                                                                    <has-error :form="form" field="acount_status"></has-error> 
                                                                </div>   
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="form-box-outer">   
                                                    <h4>Address</h4>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Number:</label> 
                                                            <input v-model="form.house_number" 
                                                                type="phone" 
                                                                name="house_number" 
                                                                placeholder="Type House/Office Number" 
                                                                :class="{ 'is-invalid': form.errors.has('house_number') }"/>
                                                                 <has-error :form="form" field="house_number"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels">Street Number:</label> 
                                                            <input v-model="form.street_number" 
                                                                type="text" 
                                                                name="street_number" 
                                                                placeholder="Type Street Number" 
                                                                :class="{ 'is-invalid': form.errors.has('street_number') }"/>
                                                                 <has-error :form="form" field="street_number"></has-error> 
                                                        </div>
                                                        
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels">City:</label> 
                                                            <input v-model="form.city" 
                                                                type="text" 
                                                                name="city" 
                                                                placeholder="Type City" 
                                                                :class="{ 'is-invalid': form.errors.has('city') }"/>
                                                                 <has-error :form="form" field="city"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">State:</label> 
                                                            <input v-model="form.state" 
                                                                type="text" 
                                                                name="state" 
                                                                placeholder="Type State" 
                                                                :class="{ 'is-invalid': form.errors.has('state') }"/>
                                                                 <has-error :form="form" field="state"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
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
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Zip Code/ Postal Code:</label> 
                                                            <input v-model="form.zip_code" 
                                                                type="phone" 
                                                                name="zip_code" 
                                                                placeholder="Type Zip Code/ Postal Code" 
                                                                :class="{ 'is-invalid': form.errors.has('zip_code') }"/>
                                                                 <has-error :form="form" field="zip_code"></has-error> 
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="form-box-outer"> 
                                                    <h4>Contact</h4>  
                                                    <div class="row"> 
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Office Phone:</label> 
                                                           <input v-model="form.office_phone" 
                                                                type="text" 
                                                                name="office_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('office_phone') }"/>
                                                                 <has-error :form="form" field="office_phone"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Moblile Number:</label> 
                                                           <input v-model="form.cell_phone" 
                                                                type="text" 
                                                                name="cell_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('cell_phone') }"/>
                                                                 <has-error :form="form" field="cell_phone"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Email:</label> 
                                                            <input v-model="form.email" 
                                                                type="email" 
                                                                name="email" 
                                                                :class="{ 'is-invalid': form.errors.has('email') }"/>
                                                                 <has-error :form="form" field="email"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Fax:</label> 
                                                            <input v-model="form.fax_no" 
                                                                type="text" 
                                                                name="fax_no" 
                                                                :class="{ 'is-invalid': form.errors.has('fax_no') }"/>
                                                                 <has-error :form="form" field="fax_no"></has-error> 
                                                        </div>
                                                        
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Website :</label> 
                                                            <input v-model="form.website" 
                                                                type="url" 
                                                                name="website" 
                                                                :class="{ 'is-invalid': form.errors.has('website') }"/>
                                                                 <has-error :form="form" field="website"></has-error>
                                                        </div> 
                                                        
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Account Type:</label> 
                                                            <div class="position-relative form-group">
                                                                <select v-model="form.account_type"
                                                                    name="account_type" 
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('account_type') }">
                                                                    <option disabled value="">--Select-- </option>
                                                                    <option v-for="(account_holder, index) in account_holder_arr" :value="index">{{account_holder}}</option> 
                                                                </select>
                                                            </div> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Comment :</label> 
                                                            <input v-model="form.comments" 
                                                                type="text" 
                                                                name="comments" 
                                                                placeholder="Type Comment" 
                                                                :class="{ 'is-invalid': form.errors.has('comments') }"/>
                                                                 <has-error :form="form" field="comments"></has-error> 
                                                        </div>
                                                            
                                                    </div> 
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div> 
                                <div class="text-center">
                                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                                    <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Edit</button>
                                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deleteAccountHolder()">Delete</button>
                                    <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode">Void</button>
                                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(1)">Save-Stay</button>
                                    <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(2)">Save-Out</button>
                                    <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(3)">Save-New</button>
                                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                                    <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
                                </div>
                            </div> 
                        </div> 
                    </fieldset>  
                </form>
            </div> 
</template>

<script>
	import Vue from 'vue';
	import VueTimepicker from 'vue2-timepicker';
    import 'vue2-timepicker/dist/VueTimepicker.css';
    //import { jsPDF } from "jspdf";
	
    import jsPDF  from "jspdf";

    export default {
        name:'list-product-categories',
        components:{
            VueTimepicker 
        },
        data(){
            return{
            	editmode:false,
				filter: '',
                list_showable:false,
            	form:new Form({ 
            		system_no:'',
                    account_type:'', 
                    bank_acount_no:'',
                    bank_account_name:'',
                    branch_name:'',
                    chart_of_acocounts:'',
                    account_creation_date:'',
                    acount_status:'',
                    comments:'', 
                    house_number:'',
                    street_number:'',
                    city:'',
                    state:'',
                    country:'',
                    zip_code:'',
                    email:'',
                    fax_no:'',
                    cell_phone:'',
                    website:'',
                    id:'',  
            	}),
                main_company_arr:[],
                industry_sector_arr:[],
                industry_sector_display:false,
            	account_holder_arr:[],
            	countries:'',
                business_license_show:false,
                professional_license_show:false,
                liability_insurence_show:false,

                columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'System No', field: 'system_no' },
                    { label: 'Account Type', field: 'account_type_string' },
                    { label: 'Entity Type', field: 'entity_type' },
                    { label: 'Full Name', field: 'full_name' },
                    { label: 'Email', field: 'email' },
                    { label: 'Mobile No', field: 'cell_phone' },
                    { label: 'Country', field: 'country_name' },
                    { label: 'Industrial Sector', field: 'industry_sector' },                    
                    { label: 'Action', field: '', sortable: false },
                ],
                rows: [],
                page: 1,
                per_page:15,
                expanded: null
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchAccountHolder();
          // this.fetchAccountHolderUpdate(23);

           
        },
		
	    methods: {
            
               
             
            reset_form()
            {

                this.form.reset ();
                this.editmode=false;
                this.list_showable=false;
                this.fetchAccountHolder();
                
            },
            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/AccountHolderBankLists';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.account_holder_list;
                });
                this.list_showable=true;
            },

            check_comment_in_calender(e,type){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        this.form.comment_in_calender_yes=true;
                        this.form.comment_in_calender_no=false;
                        this.form.comment_in_calender=true;
                    }
                    else if(type==2)
                    {
                        this.form.comment_in_calender_yes=false;
                        this.form.comment_in_calender_no=true;
                        this.form.comment_in_calender=false;
                    }
                }
                else{
                    this.form.comment_in_calender_yes=false;
                    this.form.comment_in_calender_no=false;
                    this.form.comment_in_calender=false;
                }               
            },
            check_fiscal_year_in_calender(e,type){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        this.form.fiscal_year_in_calender_yes=true;
                        this.form.fiscal_year_in_calender_no=false;
                        this.form.fiscal_year_in_calender=true;
                    }
                    else if(type==2)
                    {
                        this.form.fiscal_year_in_calender_yes=false;
                        this.form.fiscal_year_in_calender_no=true;
                        this.form.fiscal_year_in_calender=false;
                    }
                }
                else{
                    this.form.fiscal_year_in_calender_yes=false;
                    this.form.fiscal_year_in_calender_no=false;
                    this.form.fiscal_year_in_calender=false;
                }               
            },
            add_govt_account()
            {

                this.form.government_account_lavel_data.push({
                    'id':'',
                    'reference_id':'',
                    'reference_value':'',
                    'account_number':'',
                    'filling_date':'',
                    'filling_cycle':'',
                    'is_callender':0,
                });
                return;

                $("#exampleModal").modal('show');
                $('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },


            fetchAccountHolder()
            {
                let uri = '/AccountHolders';
                window.axios.get(uri).then((response) => {
                    
                    this.industry_sector_arr                      =response.data.industry_sector_arr;
                    this.countries                                =response.data.country_arr;
                    this.account_holder_arr                       =response.data.account_holder_arr;
                    //this.payment_term_arr                       =response.data.payment_term_arr;
                   // this.currency_arr                           =response.data.currency_arr;
                   // this.key_position_lavel                     =response.data.key_position_lavel_arr;
                   // this.government_account_lavel               =response.data.government_account_lavel_arr;

                    this.editmode=false;
                    

                    
                }); 

                
            },
         
       

            updateAccountHolder()
            {
            
				
		        this.form.put('/AccountHolders/'+this.form.id).then(({ data })=>{
                        var response_data=data.split("**");
                        alert(response_data[0])
						if(response_data[0]*1==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Update Successfully'
                            });

                            this.editAccountHolder(response_data[1]);
                            this.editmode=true;

                        }
                        else{

                            toast({
                                type: 'danger',
                                title: 'Invalid Operation'
                            });
                        }
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },


            
            createAccountHolder()
            {

        	    this.form.post('/AccountHolders') .then(({ data }) => { 
               
					
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					this.fetchAccountHolder();
        	    })
            },


            save_stay(type){

              

                this.form.post('/AccountHolders') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save successfully'
                        });

                        if(type==1)
                        {
                            this.fetchAccountHolderUpdate(response_data[1]);
                            this.editmode=true;
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                            
                        }
                        else if(type==3)
                        {
                             this.form.reset();
                             this.fetchAccountHolder();
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
            deleteAccountHolder()
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

                      this.form.delete('/AccountHolders/'+this.form.id).then(()=>{
                        
                          if(result.value) {
                               Swal(
                                'Deleted!',
                                'Your Company has been deleted.',
                                'success'
                              );
                             this.form.reset();
                             this.fetchAccountHolder();
                          }            

                      }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                  });
               
              })
            },
            editAccountHolder(id)
            {
                this.form.reset();
                this.list_showable=false;
                let uri = '/AccountHolders/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.form.id=response.data.account_holder.id;
                    this.form.system_no=response.data.account_holder.system_no;
                    this.form.account_type=response.data.account_holder.account_type;
                    this.form.entity_type=response.data.account_holder.entity_type;
                    this.form.first_name=response.data.account_holder.first_name;
                    this.form.middle_name=response.data.account_holder.middle_name;
                    this.form.last_name=response.data.account_holder.last_name;
                    this.form.industry_sector=response.data.account_holder.industry_sector;
                    this.form.reg_cor_dir_info=response.data.account_holder.reg_cor_dir_info;
                    this.form.register_corp_first_name=response.data.account_holder.register_corp_first_name;
                    this.form.register_corp_middle_name=response.data.account_holder.register_corp_middle_name;
                    this.form.register_corp_last_name=response.data.account_holder.register_corp_last_name;
                    this.form.register_corp_phone_no=response.data.account_holder.register_corp_phone_no;
                    this.form.register_corp_email=response.data.account_holder.register_corp_email;
                    this.form.register_emergency_contact=response.data.account_holder.register_emergency_contact;
                    this.form.house_number=response.data.account_holder.house_number;
                    this.form.street_number=response.data.account_holder.street_number;
                    this.form.city=response.data.account_holder.city;
                    this.form.state=response.data.account_holder.state;
                    this.form.country=response.data.account_holder.country;
                    this.form.zip_code=response.data.account_holder.zip_code;
                    this.form.email=response.data.account_holder.email;
                    this.form.fax_no=response.data.account_holder.fax_no;
                    this.form.cell_phone=response.data.account_holder.cell_phone;
                    this.form.website=response.data.account_holder.website;
                    this.form.business_license_issued_by=response.data.account_holder.business_license_issued_by;
                    this.form.business_license_house_number=response.data.account_holder.business_license_house_number;
                    this.form.business_license_street_number=response.data.account_holder.business_license_street_number;
                    this.form.business_license_city=response.data.account_holder.business_license_city;
                    this.form.business_license_state=response.data.account_holder.business_license_state;
                    this.form.business_license_country=response.data.account_holder.business_license_country;
                    this.form.business_license_zip_code=response.data.account_holder.business_license_zip_code;
                    this.form.business_license_email=response.data.account_holder.business_license_email;
                    this.form.business_license_fax_no=response.data.account_holder.business_license_fax_no;
                    this.form.business_license_cell_phone=response.data.account_holder.business_license_cell_phone;
                    this.form.business_license_website=response.data.account_holder.business_license_website;
                    this.form.business_license_no=response.data.account_holder.business_license_no;
                    this.form.business_license_issue_date=response.data.account_holder.business_license_issue_date;
                    this.form.business_license_expire_date=response.data.account_holder.business_license_expire_date;
                    this.form.business_license_is_callender=response.data.account_holder.business_license_is_callender;
                    this.form.business_license_validation_status=response.data.account_holder.business_license_validation_status;

                    this.form.professional_license_associate_name=response.data.account_holder.professional_license_associate_name;
                    this.form.professional_license_house_number=response.data.account_holder.professional_license_house_number;
                    this.form.professional_license_street_number=response.data.account_holder.professional_license_street_number;
                    this.form.professional_license_city=response.data.account_holder.professional_license_city;
                    this.form.professional_license_state=response.data.account_holder.professional_license_state;
                    this.form.professional_license_country=response.data.account_holder.professional_license_country;
                    this.form.professional_license_zip_code=response.data.account_holder.professional_license_zip_code;
                    this.form.professional_license_email=response.data.account_holder.professional_license_email;
                    this.form.professional_license_fax_no=response.data.account_holder.professional_license_fax_no;
                    this.form.professional_license_cell_phone=response.data.account_holder.professional_license_cell_phone;
                    this.form.professional_license_website=response.data.account_holder.professional_license_website;
                    this.form.professional_license_no=response.data.account_holder.professional_license_no;
                    this.form.professional_license_issue_date=response.data.account_holder.professional_license_issue_date;
                    this.form.professional_license_expire_date=response.data.account_holder.professional_license_expire_date;
                    this.form.professional_license_is_callender=response.data.account_holder.professional_license_is_callender;
                    this.form.professional_license_validation_status=response.data.account_holder.professional_license_validation_status;


                    this.form.liabilities_insurence_issued_by=response.data.account_holder.liabilities_insurence_issued_by;
                    this.form.liabilities_insurence_house_number=response.data.account_holder.liabilities_insurence_house_number;
                    this.form.liabilities_insurence_street_number=response.data.account_holder.liabilities_insurence_street_number;
                    this.form.liabilities_insurence_city=response.data.account_holder.liabilities_insurence_city;
                    this.form.liabilities_insurence_state=response.data.account_holder.liabilities_insurence_state;
                    this.form.liabilities_insurence_country=response.data.account_holder.liabilities_insurence_country;
                    this.form.liabilities_insurence_zip_code=response.data.account_holder.liabilities_insurence_zip_code;
                    this.form.liabilities_insurence_email=response.data.account_holder.liabilities_insurence_email;
                    this.form.liabilities_insurence_fax_no=response.data.account_holder.liabilities_insurence_fax_no;
                    this.form.liabilities_insurence_cell_phone=response.data.account_holder.liabilities_insurence_cell_phone;
                    this.form.liabilities_insurence_website=response.data.account_holder.liabilities_insurence_website;
                    this.form.liabilities_insurence_no=response.data.account_holder.liabilities_insurence_no;
                    this.form.liabilities_insurence_issue_date=response.data.account_holder.liabilities_insurence_issue_date;
                    this.form.liabilities_insurence_expire_date=response.data.account_holder.liabilities_insurence_expire_date;
                    this.form.liabilities_insurence_is_callender=response.data.account_holder.liabilities_insurence_is_callender;
                    this.form.liabilities_insurence_validation_status=response.data.account_holder.liabilities_insurence_validation_status;

                    this.industry_sector_arr                      =response.data.industry_sector_arr;
                    this.countries                                =response.data.country_arr;
                    this.account_holder_arr                       =response.data.account_holder_arr;

                    this.editmode=true;
                    


                    
                }); 

                
            },


	    }
    
    }  
	
</script>



