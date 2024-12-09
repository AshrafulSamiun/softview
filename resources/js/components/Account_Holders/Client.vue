<template>
    <fieldset>
        <h4 class="breadcumb"> Client</h4>
        <p class="breadcumb-p">Profile/Standard/Account-Holder/Client</p>

        <div class="text-center" style=" margin-top:20px">
            <button 
                v-show="data_entry" 
                type="button" 
                class=" btn-action-bar"  
                @click="reset_form()">Create New</button>
            <button 
                type="button" 
                class=" btn-action-bar" 
                :class="{ 'btn-action-bar-dissable': !data_entry, 'btn-action-bar': data_entry}"
                @click="data_enty_show()">Data Entry </button>
          
            <button 
                v-show="!editmode"
                type="button" 
                class=" btn-action-bar" 
                :class="{ 'btn-action-bar-dissable': !save_btn, 'btn-action-bar': save_btn}"
                @click="save_show()">Save
            </button>
            <button 
                v-show="editmode"
                type="button" 
                class=" btn-action-bar" 
                :class="{ 'btn-action-bar-dissable': !print_btn, 'btn-action-bar': print_btn}" 
                @click.prevent="btn_print()">Print
            </button>
            <button 
                type="button" 
                class=" btn-action-bar" 
                :class="{ 'btn-action-bar-dissable': !approval_btn, 'btn-action-bar': approval_btn}"
                @click="approval_show()" >Approval
            </button>

            <button 
                :class="{ 'btn-action-bar-dissable': !posting_status_btn, 'btn-action-bar': posting_status_btn}"  
                type="button" 
                class=" btn-action-bar" 
                @click="posting_status_show()" >Posting Status
            </button>

            <button 
               :class="{ 'btn-action-bar-dissable': !list_btn, 'btn-action-bar': list_btn}"   
                type="button" 
                class=" btn-action-bar" 
                @click="reset_list()">List</button>
            
        </div>
        <div class="text-center" v-if="!list_showable" style=" margin-top:10px">

            <!-- ==============================Save Show =================== -->
            
            <button 
                v-if="save_btn" 
                class=" btn-action-bar"
                type="button"   
                @click="voided()">Auto Save
            </button>
            <button 
                v-if="save_btn" 
                class=" btn-action-bar"
                type="button"   
                @click="save_stay(3)">Save & New
            </button>

            <button 
                v-if="save_btn" 
                class=" btn-action-bar"
                type="button"   
                @click="save_stay(2)" >Save & Out 
            </button>

            <button 
                v-if="save_btn" 
                class=" btn-action-bar"   
                type="button"  
                @click="save_as_pdf()">Save as PDF
            </button>
            <!-- ==============================Print Show =================== -->

            <button
                v-if="print_btn" 
                type="button" 
                class=" btn-action-bar" 
                @click="print_priview()">Preview </button>
          
            <button 
                v-if="print_btn"
                type="button" 
                class="btn-action-bar" 
                @click="print_pdf()">Print
            </button>

           

            <!-- ==============================Posting Status =================== -->
            
            <button 
                v-if="posting_status_btn" 
                class=" btn-action-bar"
                type="button"   
                @click="posting_status_details(1)">Saved ({{this.posting_status_data.saved}})
            </button>

            <button 
                v-if="posting_status_btn" 
                class=" btn-action-bar"
                type="button"   
                @click="posting_status_details(2)" >Rejected({{this.posting_status_data.rejected}})
            </button>
            <button 
                v-if="posting_status_btn" 
                class=" btn-action-bar"
                type="button"   
                @click="posting_status_details(3)">Transmited out ({{this.posting_status_data.transmit_out}})
            </button>

            <button 
                v-if="posting_status_btn" 
                class=" btn-action-bar"   
                type="button"  
                @click="posting_status_details(4)">Voided({{this.posting_status_data.voided}})
            </button>

            <button    
                v-if="posting_status_btn" 
                class=" btn-action-bar"   
                type="button" 
                @click="posting_status_details(5)">Posted({{this.posting_status_data.posted}})
            </button>
            <button 
                v-if="posting_status_btn" 
                class=" btn-action-bar"   
                type="button" 
                @click="posting_status_details(6)">Adjusted({{this.posting_status_data.adjusted}})
            </button>
            <button 
                v-if="posting_status_btn" 
                class=" btn-action-bar"   
                type="button" 
                @click="posting_status_details(7)">Reposted({{this.posting_status_data.reposted}})
            </button>
          
        </div>
        <div v-if="list_showable" class="form-card">
            
            <div class="pull-right" style="margin:10px 0;">
                <a  id="excel_view" href="" style="text-decoration:none">
                    <button 
                        :disabled="form.busy"  
                        type="button" 
                        class="btn btn-light btn-print" 
                        style="min-width:90px" >
                        <span class="glyphicon glyphicon-export"></span>
                        Export
                    </button> 
                </a> 
                <button 
                    :disabled="form.busy"  
                    type="button" 
                    class="btn btn-light btn-print" 
                    @click="print_data()"
                    style="min-width:90px" >
                    <span class="glyphicon glyphicon-print"></span>
                    Print
                </button> 
            </div>
            <div class="mb-2">
                <input type="text" v-model="filter" class="form-control table-filter" placeholder="Search..." style="width:400px;"/>
            </div>
            <vue3-datatable :rows="rows" :columns="columns" :sortable="true" :search="filter" 
            class="advanced-table whitespace-nowrap">
                <template #sl="data">
                    <strong class="text-info">{{ data.value.sl }}</strong>
                  </template>
                  <template #system_no="data">
                    <span class="font-semibold">{{ data.value.system_no }}</span>
                  </template>
                  <template #account_type_string="data">
                    <span class="font-semibold">{{ data.value.account_type_string }}</span>
                  </template>
                  <template #client_name="data">
                    <span class="font-semibold">{{ data.value.client_name }}</span>
                  </template>
                  
                  <template #email="data">
                    <span class="font-semibold">{{ data.value.email }}</span>
                  </template>
                  <template #cell_phone="data">
                    <span class="font-semibold">{{ data.value.cell_phone }}</span>
                  </template>
                  <template #country_name="data">
                    <span class="font-semibold">{{ data.value.country_name }}</span>
                  </template>
                  
                <template #buttons="data">
                    <button 
                        class="btn " 
                        style="padding:.17rem .25rem" 
                        @click.prevent="editAccountHolder(data.value.id)">
                        <span class="glyphicon glyphicon-edit"></span>
                    </button>
                    <button  
                        class="btn "
                        style="padding:.17rem .25rem"
                        @click.prevent="deleteAccountHolder(data.value.id)">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                    <button  
                        class="btn "
                        style="padding:.17rem .15rem"
                        @click.prevent="deleteAccountHolder(data.value.id)">
                        <span class="glyphicon glyphicon-print"></span>
                    </button>
                </template>
            </vue3-datatable>
        </div>
   
        <div class="card"> 
            <form id="msform" @submit.prevent="editmode ? updateAccountHolder() : createAccountHolder()" @keydown="form.onKeydown($event)">  
                
                <div id="content">
                    
                    <div class="form-card" v-if="!list_showable">
                        <div class="form-folder">
                            <h3>Client Information:</h3> 
                            <div class="form-holder" style="width:90%; padding-left:10%">
                                <div class="row align-self-stretch"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                                        <div class="form-box-outer"> 
                                            <label class="fieldlabels">ID No:</label> 
                                            <input type="text" 
                                                id="system_no" 
                                                name="system_no" 
                                                v-model="form.system_no"  
                                                placeholder="ID No" disabled/> 
                                               

                                            <label class="fieldlabels">Client Type:</label> 
                                            <div class="position-relative form-group">
                                                <select v-model="form.client_type"
                                                    name="client_type"
                                                    class="custom-select" 
                                                    :class="{ 'is-invalid': form.errors.has('client_type') }"> 
                                                    <option disabled value="">--Select-- </option>
                                                    <option value="1">Regular</option> 
                                                    <option value="2">Preferred</option> 
                                                    <option value="3">VIP</option> 
                                                </select>
                                                 
                                            </div> 

                                            <label class="fieldlabels" >Account Manager Name:</label>  
                                            <input v-model="form.account_manager_name" 
                                                type="text" 
                                                placeholder="Type Account Manager Name"
                                                name="account_manager_name" 
                                                :class="{ 'is-invalid': form.errors.has('account_manager_name') }"/>
                                            <has-error :form="form" field="account_manager_name"></has-error>
                                    
                                            <label class="fieldlabels">Chart of Accounts:</label> 
                                            <input v-model="form.chart_of_acocounts" 
                                                type="text" 
                                                name="chart_of_acocounts" 
                                                placeholder="Type Chart of Accounts" 
                                                :class="{ 'is-invalid': form.errors.has('chart_of_acocounts') }"/>
                                                                                    
                                             
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-box-outer"> 
                                            
                                            <label class="fieldlabels">Is this Account Holder has a portal ?:</label> 
                                            <div class="position-relative form-group">
                                                <select v-model="form.account_holder_portal"
                                                        name="account_holder_portal"
                                                        class="custom-select" 
                                                        :class="{ 'is-invalid': form.errors.has('account_holder_portal') }">
                                                        <option disabled value="">--Select-- </option>
                                                        <option value="1">Yes</option> 
                                                        <option value="2">No</option> 
                                                    </select>
                                                    <has-error :form="form" field="account_holder_portal"></has-error> 
                                            </div> 
                                        
                                            <label class="fieldlabels">Is this Account Holder has a dedicated File ?:</label> 
                                            <div class="position-relative form-group">
                                                <select v-model="form.account_holder_dedicated_file"
                                                        name="account_holder_dedicated_file"
                                                        class="custom-select" 
                                                        :class="{ 'is-invalid': form.errors.has('account_holder_dedicated_file') }">
                                                        <option disabled value="">--Select-- </option>
                                                        <option value="1">Yes</option> 
                                                        <option value="2">No</option> 
                                                    </select>
                                                    <has-error :form="form" field="account_holder_dedicated_file"></has-error> 
                                            </div> 

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
                                            </div>  
                                               
                                        </div>
                                    </div>
                                    
                                   
                                </div>
                                
                            </div>


                            <h3>Client Information:</h3> 
                            <div class="form-holder" style="width:90%; padding-left:10%">
                                <div class="row align-self-stretch"> 
                                        
                                            <div class="col-md-6  col-sm-6 col-xs-12">
                                                <div class="form-box-outer" style="padding:0">  

                                                    <h3 style="margin-top:0 !important">Address</h3>

                                                    <div class="row" style="padding: 20px 20px 10px;">

                                                        <div class="col-md-12 col-sm-12 col-xs-12">

                                                            <label class="fieldlabels ">Number<span class="mandatory-field"> *</span>:</label> 
                                                            <input v-model="form.house_number" 
                                                                type="phone" 
                                                                name="house_number" 
                                                                placeholder="Type House/Office Number" 
                                                                :class="{ 'is-invalid': form.errors.has('house_number') }"/>
                                                            <has-error :form="form" field="house_number"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Street Number<span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input v-model="form.street_number" 
                                                                type="text" 
                                                                name="street_number" 
                                                                placeholder="Type Street Number" 
                                                                :class="{ 'is-invalid': form.errors.has('street_number') }"/>
                                                            <has-error :form="form" field="street_number"></has-error> 
                                                        </div>
                                                        
                                                        <div class="col-md-12 col-sm-6 col-xs-12">

                                                            <label class="fieldlabels ">
                                                                City<span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input v-model="form.city" 
                                                                type="text" 
                                                                name="city" 
                                                                placeholder="Type City" 
                                                                :class="{ 'is-invalid': form.errors.has('city') }"/>
                                                            <has-error :form="form" field="city"></has-error> 
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">

                                                            <label class="fieldlabels ">
                                                                State<span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input v-model="form.state" 
                                                                type="text" 
                                                                name="state" 
                                                                placeholder="Type State" 
                                                                :class="{ 'is-invalid': form.errors.has('state') }"/>
                                                            <has-error :form="form" field="state"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Country<span class="mandatory-field"> *</span>:
                                                            </label> 
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
                                                            <label class="fieldlabels ">
                                                                Zip Code/ Postal Code<span class="mandatory-field"> *</span>:
                                                            </label> 
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
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-box-outer" style="padding:0"> 
                                                    <h3 style="margin-top:0 !important">Contact</h3>  
                                                    <div class="row" style="padding: 20px 20px 10px;"> 
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Office Phone<span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input 
                                                                v-model="form.office_phone" 
                                                                type="text" 
                                                                name="office_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('office_phone') }"/>
                                                            <has-error :form="form" field="office_phone"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Moblile Number
                                                                <span class="mandatory-field"> *</span>:
                                                            </label> 
                                                           <input 
                                                                v-model="form.cell_phone" 
                                                                type="text" 
                                                                name="cell_phone" 
                                                                :class="{ 'is-invalid': form.errors.has('cell_phone') }"/>
                                                            <has-error :form="form" field="cell_phone"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Email<span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input v-model="form.email" 
                                                                type="email" 
                                                                name="email" 
                                                                :class="{ 'is-invalid': form.errors.has('email') }"/>
                                                            <has-error :form="form" field="email"></has-error>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Fax
                                                                <span class="mandatory-field"> *</span>:

                                                            </label> 
                                                            <input 
                                                                v-model="form.fax_no" 
                                                                type="text" 
                                                                name="fax_no" 
                                                                :class="{ 'is-invalid': form.errors.has('fax_no') }"/>
                                                            <has-error :form="form" field="fax_no"></has-error> 
                                                        </div>
                                                        
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels ">
                                                                Website 
                                                                <span class="mandatory-field"> *</span>:
                                                            </label> 
                                                            <input v-model="form.website" 
                                                                type="url" 
                                                                name="website" 
                                                                :class="{ 'is-invalid': form.errors.has('website') }"/>
                                                            <has-error :form="form" field="website"></has-error>
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

            </form>
        </div>

     </fieldset> 


</template>
<style scoped>
    .upload-container {
      border: 2px dashed #ccc;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      position: relative;
    }

    .upload-placeholder {
      color: #999;
    }

    .upload-placeholder.dragging {
      background-color: #f0f8ff;
    }

    .file-input {
      display: none;
    }

    .preview img {
      max-width: 50%;
      height: auto;
      display: block;
      margin: 0 auto 10px;
    }
</style>

<script>
    import {ref} from "vue";
    import Vue3Datatable from "@bhplugin/vue3-datatable";
    import "@bhplugin/vue3-datatable/dist/style.css";
    import html2pdf from "html2pdf.js";
    import { jsPDF } from "jspdf";
    import "jspdf-autotable";
    export default {
    name:'list-product-categories',
    components:{
        Vue3Datatable 
    },
    data(){
        return{
            editmode:false,
            filter: '',
            list_showable:false,
            form:new Form({
                account_type:8, 
                client_name:'',
                client_type:'', 
                account_manager_name:'',
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
                account_holder_portal:'',
                account_holder_dedicated_file:'',
                account_holder_title_name:'', 
                posting_status:0, 
                photo_id: null,
            }),
            dragging: false,
            photo: null,
            photoUrl: null, 
            main_company_arr:[],
            industry_sector_arr:[],
            industry_sector_display:false,
            account_holder_arr:[],
            countries:'',
            business_license_show:false,
            professional_license_show:false,
            liability_insurence_show:false,

            columns: ref([
                {title: 'SL', field: 'sl', align: 'center'},
                {title: 'System No', field: 'system_no'},
                {title: 'Account Type', field: 'account_type_string'},
                {title: 'Client Name', field: 'client_name'},
                {title: 'Email', field: 'email'},
                {title: 'Mobile No', field: 'cell_phone'},
                {title: 'Country', field: 'country_name'},
                {title: 'Action', field: 'buttons', sort: false},
            ]),
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
    
        print_data()
        {
            let uri = '/AccountHoldersClientPrintAll/'+this.report_type+'/1';
            window.axios.get(uri).then((response) => {

                var w = window.open("Surprise", "#");
                var d = w.document.open();
                d.write(response.data);                 
                d.close();
            });
        },

        print_priview()
        {
            let uri = '/AccountHoldersClient/'+this.form.id;
            window.axios.get(uri).then((response) => {

                var w = window.open("Surprise", "#");
                var d = w.document.open();
                d.write(response.data);                 
                d.close();
            });
        },
        print_pdf()
        {
            let uri = '/AccountHoldersClientPrintPdf/'+this.form.id;
            window.axios.get(uri).then((response) => {

                this.pdf_show_moment=true;
                const doc = new jsPDF({
                    orientation: "landscape", // Adjust orientation if needed
                    unit: "pt", // Set unit to points for precise control
                    format: "a4", // Standard page size
                });
                doc.setFontSize(8);
                doc.html(response.data, {
                    callback: function (pdf) {
                        pdf.save("board_of_director_info.pdf");
                    },
                    x: 0,
                    y: 0,
                });
            });
            this.pdf_show_moment=false;
        },

        
        approval_show()
        {
            if(this.approval_btn) this.approval_btn=false;
            else 
            {
                this.data_entry         =false;
                this.approval_btn       =true;
                this.save_btn           =false;
                this.print_btn          =false;
                this.posting_status_btn =false;
                this.list_btn           =false;
            }
        },
        btn_print()
        {
            if(this.print_btn) this.print_btn=false;
            else 
            {
                this.save_btn           =false;
                this.print_btn          =true;
                this.posting_status_btn =false;
                this.list_btn           =false;
               
            }
        },

        data_enty_show()
        {
            if(this.data_entry) this.data_entry=false;
            else 
            {
                this.data_entry         =true;
                this.approval_btn       =false;
                this.save_btn           =false;
                this.print_btn          =false;
                this.posting_status_btn =false;
                this.list_btn           =false;
                this.reset_form();

            }
        },


        save_show()
        {
            if(this.save_btn) this.save_btn=false;
            else 
            {
                this.save_btn           =true;
                this.print_btn          =false;
                this.posting_status_btn =false;
                this.approval_btn       =false;
                this.list_btn           =false;
            }
        },
                 
        posting_status_show()
        {
            if(this.posting_status_btn) this.posting_status_btn=false;
            else 
            {
                let uri = '/AccountHoldersClientPostingStatus';
                window.axios.get(uri).then((response) => {
                    this.posting_status_data = response.data.account_holder_list;
                });
                this.save_btn           =false;
                this.print_btn          =false;
                this.posting_status_btn =true;
                this.data_entry         =false;
                this.approval_btn       =false;
                this.list_btn           =false;
                this.list_showable      =false;
            }
        },

        posting_status_details(type)
        {
            this.save_btn           =false;
            this.print_btn          =false;
            this.posting_status_btn =false;
            this.approval_btn       =false;
            this.data_entry         =false;
            this.list_btn           =true;
            this.form.reset();
            this.editmode=false;
            let uri = '/AccountHoldersClientPostingType/'+type;
            window.axios.get(uri).then((response) => {
                this.rows = response.data.account_holder_list;
            });
            this.list_showable=true;
            this.report_type=type;

            let uri1 = '/AccountHoldersClientPrintAll/'+this.report_type+'/2';
            window.axios.get(uri1).then((response) => {

                document.getElementById("hidden_exceldata").innerHTML = response.data;
                $('#excel_view').attr("href", $('#download_excel').attr('href'));
            });
        },
         
        async uploadFile(file) {
            const formData = new FormData();
            formData.append("photo", file);

            try {
                const response = await axios.post("/upload-photo", formData, {
                headers: { "Content-Type": "multipart/form-data" },
                });
                this.photoUrl = response.data.path;
                this.photo = file;
                this.form.photo_id=response.data.image_id;
            } catch (error) {
                showToast('Upload failed.', 'error');
                console.error(error);
          }
        },
        handleDrop(event) {
            this.dragging = false;
            const file = event.dataTransfer.files[0];
            if (file) this.uploadFile(file);
        },


        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) this.uploadFile(file);
        },

        browseFile() {
            this.$refs.fileInput.click();
        },
        removePhoto() {
            this.photo = null;
            this.photoUrl = null;
        },


        //======================File Upload finish===============================================

        
        reset_list()
        {
            this.form.reset();
            this.editmode=false;
            let uri = '/AccountHolderClientLists';
            window.axios.get(uri).then((response) => {
                this.rows = response.data.account_holder_list;
            });
            this.list_showable=true;
            this.report_type=0;

            let uri1 = '/AccountHoldersClientPrintAll/'+this.report_type+'/2';
            window.axios.get(uri1).then((response) => {

                document.getElementById("hidden_exceldata").innerHTML = response.data;
                $('#excel_view').attr("href", $('#download_excel').attr('href'));
            });
        },
        reset_form()
        {

            this.form.reset ();
            this.editmode=false;
            this.list_showable=false;
            this.fetchAccountHolder();
            
        },
           

        fetchAccountHolder()
        {
            let uri = '/AccountHoldersClient';
            window.axios.get(uri).then((response) => {
                
                this.industry_sector_arr                      =response.data.industry_sector_arr;
                this.countries                                =response.data.country_arr;
                this.account_holder_arr                       =response.data.account_holder_arr; 

                this.editmode=false;
                
            }); 

            
        },
     


        updateAccountHolder()
        {
               
            this.form.put('/AccountHoldersClient/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                   // alert(response_data[0])
                    if(response_data[0]*1==1)
                    {
                        toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        this.editAccountHolder(response_data[1]);
                        this.editmode=true;

                    }
                    else if(response_data[0]*1==10)
                    {
                        toast({
                                type: 'error',
                                title: "Please open the 'Open File' page and select a company before proceeding to create an account holder User."
                        }); 
                    }
                    else{

                        showToast('Invalid Operation', 'error');
                    }
                })
                .catch(()=>{
                   showAlert("failed!","there was some wrong","warning");
            
                });
        },


        
        createAccountHolder()
        {

            this.form.post('/AccountHoldersClient') .then(({ data }) => { 
           
                
                toast({
                    type: 'success',
                    title: 'Data Save successfully'
                });

                this.form.reset ();
                this.fetchAccountHolder();
            })
        },


        save_stay(type){
            this.form.post('/AccountHoldersClient') .then(({ data }) => { 
                var response_data=data.split("**");
                if(response_data[0]==1)
                {
                     showToast('Data Save Successfully', 'success');

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
                else if(response_data[0]*1==10)
                {
                    toast({
                            type: 'error',
                            title: "Please open the 'Open File' page and select a company before proceeding to create an account holder User."
                    }); 
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

                  this.form.delete('/AccountHoldersClient/'+this.form.id).then(()=>{
                    
                      if(result.value) {
                           showAlert(
                            'Deleted!',
                            'Your Company has been deleted.',
                            'success'
                          );
                         this.form.reset();
                         this.fetchAccountHolder();
                      }            

                  }).catch(()=>{
                    showAlert("failed!","there was some wrong","warning");
              });
           
          })
        },
        editAccountHolder(id)
        {
            this.form.reset();
            this.list_showable=false;
            let uri = '/AccountHoldersClient/'+id+'/edit';
            window.axios.get(uri).then((response) => {
                
                       this.form.id=response.data.account_holder.id;
                        this.form.system_no=response.data.account_holder.system_no;
                        this.form.account_type=response.data.account_holder.account_type; 

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
                        this.form.office_phone=response.data.account_holder.office_phone;


                        this.form.client_name=response.data.account_holder.client_name;
                        this.form.client_type=response.data.account_holder.client_type;
                        this.form.account_manager_name=response.data.account_holder.account_manager_name;
                        this.form.chart_of_acocounts=response.data.account_holder.chart_of_acocounts;
                        this.form.account_creation_date=response.data.account_holder.account_creation_date;
                        this.form.acount_status=response.data.account_holder.acount_status; 
                        this.form.comments=response.data.account_holder.comments; 

                        this.form.account_holder_portal=response.data.account_holder.account_holder_portal;  
                        this.form.account_holder_dedicated_file=response.data.account_holder.account_holder_dedicated_file;  
                        this.form.account_holder_title_name=response.data.account_holder.account_holder_title_name;                        

                        this.industry_sector_arr                      =response.data.industry_sector_arr;
                        this.countries                                =response.data.country_arr;
                        this.account_holder_arr                       =response.data.account_holder_arr;

                        this.editmode=true;
                
            }); 

            
        },
        transmit()
        { 
            this.form.posting_status=1;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Transmit it!'
            }).then((result) => {

                this.form.post('/AccountHoldersClientPost/'+this.form.id).then((response)=>{
                    
                    var response_data=response.data.split("**");
                    if(response_data[0]==1)
                    { 
                        showAlert(
                            'Transmited!',
                            'Your Data has been Transmited.',
                            'success'
                        );

                        this.editAccountHolder(response_data[1]);
                
                    }            

                }).catch(()=>{
                    showAlert("failed!","there was some wrong","warning");
                });
                
            })
            
        },
        rejected()
        { 
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Reject it!'
            }).then((result) => {

                this.form.post('/AccountHoldersClientReject/'+this.form.id).then((response)=>{
                    
                    var response_data=response.data.split("**");
                    if(response_data[0]==1)
                    { 
                        showAlert(
                            'Rejected!',
                            'Your Data has been Rejected.',
                            'success'
                        );
                        this.editUserPrivilege(response_data[1]);
                    }            

                }).catch(()=>{
                    showAlert("failed!","there was some wrong","warning");
                });
                
            })
            
        },

        voided()
        {

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Void it!'
            }).then((result) => {

                this.form.post('/AccountHoldersClientVoid/'+this.form.id).then((response)=>{
                    
                    var response_data=response.data.split("**");
                    if(response_data[0]==1)
                    { 
                        showAlert(
                            'Void!',
                            'Your Data has been Voided.',
                            'success'
                        );

                        this.editAccountHolder(response_data[1]);
                
                    }            

                }).catch(()=>{
                    showAlert("failed!","there was some wrong","warning");
                });
                
            })
        },
        post()
        { 
            this.form.posting_status=2;
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Post it!'
            }).then((result) => {

                this.form.post('/AccountHoldersClientPost/'+this.form.id).then((response)=>{
                    
                    var response_data=response.data.split("**");
                    if(response_data[0]==1)
                    { 
                        showAlert(
                            'Posted!',
                            'Your Data has been Posted.',
                            'success'
                        );

                        this.editAccountHolder(response_data[1]);
                
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


                this.form.post('/AccountHoldersClientRepost/'+this.form.id).then((response)=>{
                    
                    var response_data=response.data.split("**");
                    if(response_data[0]==1)
                    { 
                        showAlert(
                            'Posted!',
                            'Your Data has been Reposted.',
                            'success'
                        );
                        
                        this.editAccountHolder(response_data[1]);
                    }            

                }).catch(()=>{
                    showAlert("failed!","there was some wrong","warning");
                });
                
            })
            
        },

        adjust()
        { 
            
            this.form.post('/adjustAccountHoldersClient/'+this.form.id).then((response)=>{
                var response_data=response.data.split("**");
                if(response_data[0]==1)
                {
                    showToast('Data Update Successfully', 'success');
                    
                    this.editAccountHolder(response_data[1]);
                    
                    this.editmode=true;
                }
                else{

                    showToast('Invalid Operation', 'error');
                }
            }).catch(()=>{
                    showAlert("failed!","there was some wrong","warning");
                });             
            
        },
    


    }   

}  

</script>



