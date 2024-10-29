<template>

	<fieldset>
		<form id="msform" @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <div class="form-folder">
                    <h3><i class="fa fa-hand-point-right"></i> Open File:</h3>
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            	<div class="form-box-outer">
                            		 <div class="pull-left" style="margin-top:50px;">
                                        <label for="filter" class="sr-only">Filter</label>
                                        <input type="text" class="form-control" v-model="filter" placeholder="Filter" style="width:400px;">
                                    </div>
                                    <datatable :columns="columns" :data="form.company_arr" :filter-by="filter">
                                        <template slot-scope="{row}" >
                                            <tr @click="change_company(row)" style="cursor:pointer;background-color:green;color:#fff" v-if="form.company_avaibale &&  form.company_id==row.company_id" >
                                                <td>{{ row.sl }}</td>
                                                <td>{{ row.account_no }}</td>
                                                <td>{{ row.legal_name }}</td>
                                                <td>{{ row.period_name }}</td>
                                                <td>{{ row.is_closed }}</td>
                                                <td>{{ row.last_modified_date }}</td>
                                                <td>{{ row.last_modified_by }}</td>
                                            </tr>
                                            <tr @click="change_company(row)" style="cursor:pointer;" v-else >
                                                <td>{{ row.sl }}</td>
                                                <td>{{ row.account_no }}</td>
                                                <td>{{ row.legal_name }}</td>
                                                <td>{{ row.period_name }}</td>
                                                <td>{{ row.is_closed }}</td>
                                                <td>{{ row.last_modified_date }}</td>
                                                <td>{{ row.last_modified_by }}</td>
                                            </tr>
                                        </template>
                                    </datatable>
                                    <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
                                    

                                </div> 
                               
                            </div>
                            
                        </div>
                    </div>
                </div>           
                
            </div> 
	       
	    </form>
	   

    </fieldset>

</template>

<script>
	import Vue from 'vue';
	import DatePicker from 'vue2-datepicker';

    export default {
        name:'list-product-categories',
       	components:{
			DatePicker
		},
        data(){
            return{
            	editmode:false,
            	show_company:true,
				filter: '',
            	form:new Form({
            		
            		company_avaibale:true,
            		company_id:"",
                  	company_type:'',
                  	account_no:'',
                  	legal_name:'',
                  	currency_id:'',
                  	company_arr:[],
            	}),

            	columns: [
                    { label: 'SL', field: 'sl', align: 'center' },
                    { label: 'Account Code', field: 'account_no' },
                    { label: 'Company', field: 'legal_name' },
                    { label: 'Fiscal Year', field: 'period_name' },
                    { label: 'Status', field: 'is_closed' },
                    { label: 'Last Modified Date and Time', field: 'last_modified_date' },
                    { label: 'Last Modification By', field: 'last_modified_by' },
                ],

                page: 1,
                per_page:15,
                expanded: null
            	      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchOpenFile();
           
        },
		
	    methods: {

	    	change_company(row){
	    			this.form.company_avaibale=true,
            		this.form.company_id=row.company_id,
                  	this.form.company_type=row.type,
                  	this.form.account_no=row.account_no,
                  	this.form.legal_name=row.legal_name,
                  	this.form.currency_id=row.currency_id,
	    		 	this.form.post('/OpenFiles') .then(({ data }) => { 
                       window.open('/Dashboard','_self');               
                })
	    	},
	    	

           

            
	        fetchOpenFile()
            {
                let uri = '/OpenFiles';
                window.axios.get(uri).then((response) => {

                	this.form.company_avaibale		=response.data.company_avaibale,
            		this.form.company_id			=response.data.company_id,
                  	this.form.company_type			=response.data.company_type,
                  	this.form.account_no			=response.data.account_no,
                  	this.form.legal_name			=response.data.legal_name,
                  	this.form.currency_id			=response.data.currency_id,
                	
                	this.form.company_arr 			=response.data.company_arr;
                	
                });                 
            },
            
	    }
    
    }  
	
</script>