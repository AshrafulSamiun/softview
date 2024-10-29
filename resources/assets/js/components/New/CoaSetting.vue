<template>

    <section class="app-main__inner">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card">
                <form id="msform" @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">  
                    <fieldset>
                        <div id="content">
                            
                          
                             
                            <div class="form-card"> 
                                
                                <div class="form-folder">
                                    <h3><i class="fa fa-hand-point-right"></i>COA Setting</h3>
                                    <div class="form-holder">
                                        <div class="row align-self-stretch">
                                            
                                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                                <div class="form-box-outer">
                                                    <table class="table table_narrow" >
                                                        
                                                        <thead class="" style="background-color: #3f6ad8;border-color: #3f6ad8; text-align:center;vertical-align:middle">
                                                            <tr>
                                                                <th scope="col" colspan="2" style="color:#fff;" >Account Number</th>
                                                                <th scope="col" rowspan="3" style="color:#fff;" width="20%">Accounts Title</th>
                                                                <th scope="col" rowspan="3" style="color:#fff;" width="8%">Active</th>
                                                                <th scope="col" colspan="3" style="color:#fff;" align="center">Financial Statements</th>
                                                                <th scope="col" colspan="2" style="color:#fff;" align="center">Allowed Transaction</th>
                                                            </tr>
                                                            <tr>
                                                                
                                                                <th scope="col" rowspan="2" style="color:#fff;" width="8%">From</th>
                                                                <th scope="col" rowspan="2" style="color:#fff;" width="7%">To</th>
                                                                <th scope="col" rowspan="2" style="color:#fff;" width="10%">Balance Sheet</th>
                                                                <th scope="col" rowspan="2" style="color:#fff;" width="10%">Income Statement</th>
                                                                <th scope="col" rowspan="2" style="color:#fff;" width="10%">Retained Earning</th>
                                                                <th scope="col" rowspan="2" style="color:#fff;" width="10%">Transaction</th>
                                                                <th scope="col" rowspan="2" style="color:#fff;" width="">Balance</th>

                                                              
                                                            </tr>
                                                        </thead>
                                                        <tbody style="border:none;text-align:center;vertical-align:middle;border:none">
                                                            <tr style="background-color:rgb(215, 221, 230);color:#000" >

                                                                    <td ></td>
                                                                    <td colspan="9"> </td>
                                                                </tr>
                                                            <template v-for="(coa_setting_main_level,index) in form.coa_setting_arr" v-if="index>0">
                                                                
                                                                
                                                                <template v-for="(coa_setting_sub_level,index1) in coa_setting_main_level" >

                                                                    <tr  style="background-color:#3f6ad8;">
                                                                      
                                                                        <td colspan="2" > </td>
                                                                        <td> <h4 style="color:#fff">{{ accounts_sub_group[index1] }} </h4></td>
                                                                        <td colspan="6" > {{coa_setting_sub_level.length }}</td>
                                                                        
                                                                    </tr>
                                                                    <template v-for="(coa_setting_third_level,index2) in coa_setting_sub_level" >
                                                                        <template v-for="(coa_setting_forth_level,index3) in coa_setting_third_level" >
                                                                            <template v-for="(coa_setting,rid) in coa_setting_forth_level"  v-if="index2==0 && index3==0">
                                                                  
                                                                                <tr>
                                                                                   
                                                                                    <td width="8%">
                                                                                        <input 
                                                                                            type="text"
                                                                                            v-bind:id="'coa_setting_from_'+index2"
                                                                                            placeholder="Type From"
                                                                                            name="coa_setting_from[]" 
                                                                                            v-model="coa_setting.from"/>
                                                                                    </td>
                                                                                    <td width="7%">
                                                                                        <input 
                                                                                            type="text"
                                                                                            v-bind:id="'coa_setting_to_'+index2"
                                                                                            placeholder="Type To"
                                                                                            name="coa_setting_to[]" 
                                                                                            v-model="coa_setting.to"/>
                                                                                    </td>
                                                                                    <td  align="left" style="background-color:rgb(238, 229, 201); margin-bottom:2px"> <h6>{{ coa_setting.account_title }} </h6></td>
                                                                                  


                                                                                    <td width="8%">
                                                                                        <div class="form-check-inline">
                                                                                            <input 
                                                                                                type="checkbox" 
                                                                                                v-bind:id="'coa_setting_active_'+index2"
                                                                                                name="coa_setting_active[]"
                                                                                                @click="check_active($event,coa_setting)"
                                                                                                v-model="coa_setting.active" >
                                                                                        </div>
                                                                                    </td>
                                                                                    
                                                                                    <td width="10%">
                                                                                        <div class="form-check-inline">
                                                                                            <input 
                                                                                                type="checkbox" 
                                                                                                @change="check_statement_type($event,1,coa_setting)" 
                                                                                                name="coa_setting_balance_sheet[]" 
                                                                                                v-bind:id="'coa_setting_balance_sheet_'+index2"
                                                                                                v-model="coa_setting.balance_sheet" >
                                                                                        </div>
                                                                                    </td>
                                                                                    <td width="10%">
                                                                                        <div class="form-check-inline">
                                                                                            <input 
                                                                                                type="checkbox" 
                                                                                                @change="check_statement_type($event,2,coa_setting)" 
                                                                                                name="coa_setting_income_statement[]" 
                                                                                                v-bind:id="'coa_setting_income_statement_'+index2"
                                                                                                v-model="coa_setting.income_statement" >
                                                                                        </div>
                                                                                    </td>
                                                                                    <td width="10%">
                                                                                        <div class="form-check-inline">
                                                                                            <input 
                                                                                                type="checkbox" 
                                                                                                @change="check_statement_type($event,3,coa_setting)" 
                                                                                                name="coa_setting_retained_earning[]" 
                                                                                                v-bind:id="'coa_setting_retained_earning_'+index2"
                                                                                                v-model="coa_setting.retained_earning" >
                                                                                        </div>
                                                                                    </td>
                                                                                    <td width="10%">

                                                                                        <select v-model="coa_setting.transaction_type"
                                                                                            name="coa_setting_transaction_type[]"
                                                                                            v-bind:id="'coa_setting_transaction_type_'+index2"
                                                                                            class="custom-select" 
                                                                                            :class="{ 'is-invalid': form.errors.has('recuring_cycle') }">
                                                                                            <option disabled value="">--Select-- </option>
                                                                                            <option value="1" >Debit</option>
                                                                                            <option value="2" >Credit</option>
                                                                                            <option value="3" >Both</option>
                                                                                        </select>
                                                                                        
                                                                                    </td>
                                                                                    <td width="">
                                                                                        <select v-model="coa_setting.balance_type"
                                                                                            name="coa_setting_balance_type[]"
                                                                                            v-bind:id="'coa_setting_balance_type_'+index2"
                                                                                            class="custom-select" 
                                                                                            :class="{ 'is-invalid': form.errors.has('recuring_cycle') }">
                                                                                            <option disabled value="">--Select-- </option>
                                                                                            <option value="1" >Debit</option>
                                                                                            <option value="2" >Credit</option>
                                                                                            <option value="3" >Both</option>
                                                                                        </select>
                                                                                        
                                                                                    </td>
                                                                                    
                                                                                </tr>
                                                                                <template v-if="rid in coa_setting_sub_level"> 
                                                                                    <template v-for="(rid_forth_level,forth_index) in coa_setting_sub_level[rid]" >

                                                                                        <template v-for="(coa_setting_custom,trid) in rid_forth_level"  v-if="forth_index==0">

                                                                                            <tr>
                                                                                       
                                                                                                <td width="8%">
                                                                                                    <input 
                                                                                                        type="text"
                                                                                                        v-bind:id="'coa_setting_from_'+index2"
                                                                                                        placeholder="Type From"
                                                                                                        name="coa_setting_from[]" 
                                                                                                        v-model="coa_setting_custom.from"/>
                                                                                                </td>
                                                                                                <td width="7%">
                                                                                                    <input 
                                                                                                        type="text"
                                                                                                        v-bind:id="'coa_setting_to_'+index2"
                                                                                                        placeholder="Type To"
                                                                                                        name="coa_setting_to[]" 
                                                                                                        v-model="coa_setting_custom.to"/>
                                                                                                </td>
                                                                                                <td  align="left" style="background-color:rgb(196, 190, 171); margin-bottom:2px"> <h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{coa_setting_custom.account_title }} </h6></td>
                                                                                              


                                                                                                <td width="8%">
                                                                                                    <div class="form-check-inline">
                                                                                                        <input 
                                                                                                            type="checkbox" 
                                                                                                             @click="check_active($event,coa_setting_custom)"
                                                                                                            v-bind:id="'coa_setting_active_'+index2"
                                                                                                            name="coa_setting_active[]"
                                                                                                            v-model="coa_setting_custom.active" >
                                                                                                    </div>
                                                                                                </td>
                                                                                                
                                                                                                <td width="10%">
                                                                                                    <div class="form-check-inline">
                                                                                                        <input 
                                                                                                            type="checkbox" 
                                                                                                            @change="check_statement_type($event,1,coa_setting_custom)" 
                                                                                                            name="coa_setting_balance_sheet[]" 
                                                                                                            v-bind:id="'coa_setting_balance_sheet_'+index2"
                                                                                                            v-model="coa_setting_custom.balance_sheet" >
                                                                                                    </div>
                                                                                                </td>
                                                                                                <td width="10%">
                                                                                                    <div class="form-check-inline">
                                                                                                        <input 
                                                                                                            type="checkbox" 
                                                                                                            @change="check_statement_type($event,2,coa_setting_custom)" 
                                                                                                            name="coa_setting_income_statement[]" 
                                                                                                            v-bind:id="'coa_setting_income_statement_'+index2"
                                                                                                            v-model="coa_setting_custom.income_statement" >
                                                                                                    </div>
                                                                                                </td>
                                                                                                <td width="10%">
                                                                                                    <div class="form-check-inline">
                                                                                                        <input 
                                                                                                            type="checkbox" 
                                                                                                            @change="check_statement_type($event,3,coa_setting_custom)" 
                                                                                                            name="coa_setting_retained_earning[]" 
                                                                                                            v-bind:id="'coa_setting_retained_earning_'+index2"
                                                                                                            v-model="coa_setting_custom.retained_earning" >
                                                                                                    </div>
                                                                                                </td>
                                                                                                <td width="10%">

                                                                                                    <select v-model="coa_setting_custom.transaction_type"
                                                                                                        name="coa_setting_transaction_type[]"
                                                                                                        v-bind:id="'coa_setting_transaction_type_'+index2"
                                                                                                        class="custom-select" 
                                                                                                        :class="{ 'is-invalid': form.errors.has('recuring_cycle') }">
                                                                                                        <option disabled value="">--Select-- </option>
                                                                                                        <option value="1" >Debit</option>
                                                                                                        <option value="2" >Credit</option>
                                                                                                        <option value="3" >Both</option>
                                                                                                    </select>
                                                                                                    
                                                                                                </td>
                                                                                                <td width="">

                                                                                                    <select v-model="coa_setting_custom.balance_type"
                                                                                                        name="coa_setting_balance_type[]"
                                                                                                        v-bind:id="'coa_setting_balance_type_'+index2"
                                                                                                        class="custom-select" 
                                                                                                        :class="{ 'is-invalid': form.errors.has('recuring_cycle') }">
                                                                                                        <option disabled value="">--Select-- </option>
                                                                                                        <option value="1" >Debit</option>
                                                                                                        <option value="2" >Credit</option>
                                                                                                        <option value="3" >Both</option>
                                                                                                    </select>
                                                                                                    
                                                                                                </td>
                                                                                                
                                                                                            </tr>



                                                                                            <template v-if="trid in coa_setting_sub_level[rid]"> 
                                                                                                <template v-for="(trid_forth_level,frid) in coa_setting_sub_level[rid][trid]" >

                                                                                                        <tr>
                                                                                                   
                                                                                                            <td width="8%">
                                                                                                                <input 
                                                                                                                    type="text"
                                                                                                                    v-bind:id="'coa_setting_from_'+index2"
                                                                                                                    placeholder="Type From"
                                                                                                                    name="coa_setting_from[]" 
                                                                                                                    v-model="trid_forth_level.from"/>
                                                                                                            </td>
                                                                                                            <td width="7%">
                                                                                                                <input 
                                                                                                                    type="text"
                                                                                                                    v-bind:id="'coa_setting_to_'+index2"
                                                                                                                    placeholder="Type To"
                                                                                                                    name="coa_setting_to[]" 
                                                                                                                    v-model="trid_forth_level.to"/>
                                                                                                            </td>
                                                                                                           

                                                                                                            <td  align="left" style="background-color:rgb(223, 220, 210); margin-bottom:2px"> <h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ trid_forth_level.account_title }}</h6></td>
                                                                                                          
                                                                                                            <td width="8%">
                                                                                                                <div class="form-check-inline">
                                                                                                                    <input 
                                                                                                                        type="checkbox"
                                                                                                                        @click="check_active($event,trid_forth_level)" 
                                                                                                                        v-bind:id="'coa_setting_active_'+index2"
                                                                                                                        name="coa_setting_active[]"
                                                                                                                        v-model="trid_forth_level.active" >
                                                                                                                </div>
                                                                                                            </td>
                                                                                                            
                                                                                                            <td width="10%">
                                                                                                                <div class="form-check-inline">
                                                                                                                    <input 
                                                                                                                        type="checkbox" 
                                                                                                                        @change="check_statement_type($event,1,trid_forth_level)" 
                                                                                                                        name="coa_setting_balance_sheet[]" 
                                                                                                                        v-bind:id="'coa_setting_balance_sheet_'+index2"
                                                                                                                        v-model="trid_forth_level.balance_sheet" >
                                                                                                                </div>
                                                                                                            </td>
                                                                                                            <td width="10%">
                                                                                                                <div class="form-check-inline">
                                                                                                                    <input 
                                                                                                                        type="checkbox" 
                                                                                                                        @change="check_statement_type($event,2,trid_forth_level)" 
                                                                                                                        name="coa_setting_income_statement[]" 
                                                                                                                        v-bind:id="'coa_setting_income_statement_'+index2"
                                                                                                                        v-model="trid_forth_level.income_statement" >
                                                                                                                </div>
                                                                                                            </td>
                                                                                                            <td width="10%">
                                                                                                                <div class="form-check-inline">
                                                                                                                    <input 
                                                                                                                        type="checkbox" 
                                                                                                                        @change="check_statement_type($event,3,trid_forth_level)" 
                                                                                                                        name="coa_setting_retained_earning[]" 
                                                                                                                        v-bind:id="'coa_setting_retained_earning_'+index2"
                                                                                                                        v-model="trid_forth_level.retained_earning" >
                                                                                                                </div>
                                                                                                            </td>
                                                                                                            <td width="10%">

                                                                                                                <select v-model="trid_forth_level.transaction_type"
                                                                                                                    name="coa_setting_transaction_type[]"
                                                                                                                    v-bind:id="'coa_setting_transaction_type_'+index2"
                                                                                                                    class="custom-select" 
                                                                                                                    :class="{ 'is-invalid': form.errors.has('recuring_cycle') }">
                                                                                                                    <option disabled value="">--Select-- </option>
                                                                                                                    <option value="1" >Debit</option>
                                                                                                                    <option value="2" >Credit</option>
                                                                                                                    <option value="3" >Both</option>
                                                                                                                </select>
                                                                                                                
                                                                                                            </td>
                                                                                                            <td width="">

                                                                                                                <select v-model="trid_forth_level.balance_type"
                                                                                                                    name="coa_setting_balance_type[]"
                                                                                                                    v-bind:id="'coa_setting_balance_type_'+index2"
                                                                                                                    class="custom-select" 
                                                                                                                    :class="{ 'is-invalid': form.errors.has('recuring_cycle') }">
                                                                                                                    <option disabled value="">--Select-- </option>
                                                                                                                    <option value="1" >Debit</option>
                                                                                                                    <option value="2" >Credit</option>
                                                                                                                    <option value="3" >Both</option>
                                                                                                                </select>
                                                                                                                
                                                                                                            </td>
                                                                                                            
                                                                                                        </tr>
                                                                                                   
                                                                                                </template>

                                                                                            </template>

                                                                                        </template>
                                                                                    </template>

                                                                                </template>
                                                                            </template>
                                                                        </template>    
                                                                    </template>

                                                                    <tr>
                                                                      
                                                                        <td colspan="2" > </td>
                                                                        <td align="left" style="cursor:pointer"> <h4 @click="add_coa_setting_row(coa_setting_sub_level,index,index1)">Add </h4></td>
                                                                        <td colspan="6" > </td>
                                                                        
                                                                    </tr>
                                                                
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


                               
                            </div> 
                        </div>
                        <div class="text-center">
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Edit</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deleteCompany()">Delete</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode">Void</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(1)">Save-Stay</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(2)">Save-Out</button>
                            <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(3)">Save-New</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                            <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
                        </div>
                    </fieldset> 
                   
                   

                </form>

            </div>
            <!--  MOdel  -->
                <div class="modal fade model-middle" id="coaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
                    <div class="modal-dialog" role="document">

                        <div class="modal-content">
                            <form id="msform" @submit.prevent="editmodeCustom ? updateCustomCoa() : createCustomCoa()" @keydown="form1.onKeydown($event)">    
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel" >Add COA</h5>
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
                                                            <input v-model="form1.custom_field_name" 
                                                                type="text"
                                                                class="form-control"
                                                                name="custom_field_name" 
                                                                :class="{ 'is-invalid': form1.errors.has('custom_field_name') }"/>
                                                                  <has-error :form="form1" field="custom_field_name"></has-error>
                                                                 
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels">Third Level</label> 
                                                        </div>
                                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                                            <select v-model="form1.custom_level_three"
                                                                name="custom_level_three"
                                                                id="custom_level_three"
                                                                class="custom-select" 
                                                                :class="{ 'is-invalid': form1.errors.has('custom_level_three') }">
                                                                <option disabled value="0">--Select-- </option>
                                                                
                                                                <template v-for="(coa_setting_third_level,index2) in custom_coa_setting_sub_level" >
                                                                    <template v-for="(coa_setting_forth_level,index3) in coa_setting_third_level" >
                                                                        <template v-for="(coa_setting,rid) in coa_setting_forth_level"  v-if="index2==0 && index3==0">
                                                                            <option :value="rid" >{{coa_setting.account_title}}</option>
                                                                        </template>
                                                                    </template>
                                                                </template>
                                                            </select>
                                                            <has-error :form="form1" field="custom_level_three"></has-error>
                                                                 
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                                            <label class="fieldlabels">Forth Level</label> 
                                                        </div>
                                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                                            <select v-model="form1.custom_level_four"
                                                                name="custom_level_four"
                                                                id="custom_level_four"
                                                                class="custom-select" 
                                                                :class="{ 'is-invalid': form1.errors.has('custom_level_four') }">
                                                                <option disabled value="0">--Select-- </option>
                                                                
                                                                
                                                                <template v-for="(coa_setting_forth_level,index3) in custom_coa_setting_sub_level[form1.custom_level_three]" >
                                                                    <template v-for="(coa_setting,rid) in coa_setting_forth_level"  v-if="index3==0">
                                                                        <option :value="rid" >{{coa_setting.account_title}}</option>
                                                                    </template>
                                                                    
                                                                </template>
                                                            </select>
                                                            <has-error :form="form1" field="custom_level_four"></has-error>
                                                                 
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
                                    <button type="submit" class="btn btn-primary" >Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <!-- model end -->
        </div>

     
    </div>

   


</section>


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
                editmodeCustom:false,
                filter: '',
                form:new Form({
                    coa_setting_arr:[],                 
                }),

                form1:new Form({
                    custom_level_three:0,
                    custom_level_four:0,
                    custom_field_name:'',
                    custom_main_level:'', 
                    custom_sub_level:'', 
                    id:'',               
                }),
                coa_setting_lavel_arr:[],
                main_level_total:[],
                accounts_sub_group:[],
                sub_level_total:[],
                main_level_wise_sub_level_arr:[],
                coa_setting_third_level_arr:[],
                coa_setting_forth_level_arr:[],
                
                
                custom_coa_setting_sub_level:[],

      
            }
        },
        
        created: function()
        {
            
            this.user_menu_name = this.$route.name;
            this.fetchCoa();
           //this.fetchCompanyProfileUpdate(23);

           
        },
        
        methods: {

            check_active(e,coa_setting)
            {
                if(e.target.checked)
                {
                    coa_setting.active=1;
                }
                else
                {
                    coa_setting.active=0;
                }
            },



            fetchCoa()
            {
                let uri = '/CoaSettings';
                window.axios.get(uri).then((response) => {
                    
                    
                    //this.form.coa_setting_arr             =response.data.coa_setting_lavel_arr;
                    this.main_level_total                   =response.data.main_level_total;
                    this.accounts_sub_group                 =response.data.accounts_sub_group;
                    this.sub_level_total                    =response.data.sub_level_total;
                    this.main_level_wise_sub_level_arr      =response.data.main_level_wise_sub_level_arr;
                    this.editmode                           =response.data.update;

                    for(let i=0; i<response.data.coa_setting_lavel_arr.length; i++){

                       


                        var main_level_index=response.data.coa_setting_lavel_arr[i].main_level;
                        var sub_level_index=response.data.coa_setting_lavel_arr[i].sub_level;
                        var third_level_index=response.data.coa_setting_lavel_arr[i].third_level;
                        var forth_level_index=response.data.coa_setting_lavel_arr[i].forth_level;
                        var forth_level_reference_id=response.data.coa_setting_lavel_arr[i].reference_id;

                        if(main_level_index in this.form.coa_setting_arr == false)
                        this.form.coa_setting_arr[main_level_index] = {};
                      

                        if(sub_level_index in this.form.coa_setting_arr[main_level_index] == false)
                        this.form.coa_setting_arr[main_level_index][sub_level_index] = {};
                         


                        if(third_level_index in this.form.coa_setting_arr[main_level_index][sub_level_index] == false)
                        this.form.coa_setting_arr[main_level_index][sub_level_index][third_level_index] = {};
                        


                        if(forth_level_index in this.form.coa_setting_arr[main_level_index][sub_level_index][third_level_index] == false)
                        this.form.coa_setting_arr[main_level_index][sub_level_index][third_level_index][forth_level_index] = {};

                        if(forth_level_reference_id in this.form.coa_setting_arr[main_level_index][sub_level_index][third_level_index][forth_level_index] == false)
                        this.form.coa_setting_arr[main_level_index][sub_level_index][third_level_index][forth_level_index][forth_level_reference_id] = {};
                         

                        this.form.coa_setting_arr[main_level_index][sub_level_index][third_level_index][forth_level_index][forth_level_reference_id]={
                            'id':response.data.coa_setting_lavel_arr[i].id,
                            'from':response.data.coa_setting_lavel_arr[i].from,
                            'to':response.data.coa_setting_lavel_arr[i].to,
                            'main_level':response.data.coa_setting_lavel_arr[i].main_level,
                            'account_title':response.data.coa_setting_lavel_arr[i].account_title,
                            'sub_level':response.data.coa_setting_lavel_arr[i].sub_level,
                            'third_level':response.data.coa_setting_lavel_arr[i].third_level,
                            'forth_level':response.data.coa_setting_lavel_arr[i].forth_level,

                            'active':response.data.coa_setting_lavel_arr[i].active,
                            'statement_type':response.data.coa_setting_lavel_arr[i].statement_type,
                            'balance_type':response.data.coa_setting_lavel_arr[i].balance_type,
                            'transaction_type':response.data.coa_setting_lavel_arr[i].transaction_type,
                            'retained_earning':response.data.coa_setting_lavel_arr[i].retained_earning,
                            'income_statement':response.data.coa_setting_lavel_arr[i].income_statement,
                            'balance_sheet':response.data.coa_setting_lavel_arr[i].balance_sheet,
                            'reference_id':response.data.coa_setting_lavel_arr[i].reference_id,
                        };


                    }                        
                }); 
               // alert(this.form.coa_setting_arr[1][1][0][0][1].account_title);
                
            },

            add_coa_setting_row(coa_setting_sub_level,main_level,sub_level)
            {
                this.custom_coa_setting_sub_level=coa_setting_sub_level;
                this.form1.custom_main_level=main_level;
                this.form1.custom_sub_level=sub_level;
                $("#coaModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
            },

            add_coa_setting_row_old(main_level,sub_level)
            {

                this.form.coa_setting_arr.push({
                            'id':'',
                            'from':'',
                            'to':'',
                            'main_level':main_level,
                            'account_title':'',
                            'sub_level':sub_level,
                            'third_level':0,
                            'forth_level':0,

                            'active':0,
                            'statement_type':0,
                            'transaction_type':"",
                            'balance_type':"",
                            'reference_id':'',
                            'income_statement':0,
                            'balance_sheet':0,
                            'retained_earning':0,
                        });
                this.main_level_total[main_level]+=1;
            },

            reset_form()
            {

                this.form.reset ();
                this.editmode=false;
                
            },

            check_statement_type(e,type,row){
                if(e.target.checked)
                {

                    if(type==1)
                    {
                        row.balance_sheet=1;
                        row.income_statement=0;
                        row.retained_earning=0;
                        row.statement_type=1;
                        
                    }
                    else if(type==2)
                    {
                        row.balance_sheet=0;
                        row.income_statement=1;
                        row.retained_earning=0;
                        row.statement_type=2;
                    }
                    else if(type==3)
                    {
                        row.balance_sheet=0;
                        row.income_statement=0;
                        row.retained_earning=1;
                        row.statement_type=3;
                    }

                    //alert(row.retained_earning)
                }
                else{
                    row.balance_sheet=0;
                    row.income_statement=0;
                    row.retained_earning=0;
                    row.statement_type=0;
                }               
            },
            check_statement_type_old(e,type,row){
                if(e.target.checked)
                {
                    if(type==1)
                    {
                        this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].balance_sheet=1;
                        this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].income_statement=false;
                        this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].retained_earning=false;
                        this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].statement_type=1;
                        
                    }
                    else if(type==2)
                    {
                        this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].balance_sheet=false;
                        this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].income_statement=true;
                        this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].retained_earning=false;
                        this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].statement_type=2;
                    }
                    else if(type==3)
                    {
                        this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].balance_sheet=false;
                        this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].income_statement=false;
                        this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].retained_earning=true;
                        this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].statement_type=3;
                    }
                }
                else{
                    this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].balance_sheet=false;
                    this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].income_statement=false;
                    this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].retained_earning=false;
                    this.form.coa_setting_arr[row.main_level][row.sub_level][row.third_level][row.forth_level][row.reference_id].statement_type=0;
                }               
            },

            updateCompanyProfile()
            {
            
                
                this.form.put('/CoaSettings/'+1)
                    .then(({ data })=>{
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Update Successfully'
                            });

                            this.fetchCoa();
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
            
            createCustomCoa()
            {
                this.form1.post('/AddCustomCoa') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                        toast({
                        type: 'success',
                        title: 'Data Save successfully'
                    });



                    if(this.form1.custom_level_three in this.form.coa_setting_arr[this.form1.custom_main_level][this.form1.custom_sub_level] == false)
                        this.form.coa_setting_arr[this.form1.custom_main_level][this.form1.custom_sub_level][this.form1.custom_level_three] = {};
                        


                        if(this.form1.custom_level_four in this.form.coa_setting_arr[this.form1.custom_main_level][this.form1.custom_sub_level][this.form1.custom_level_three] == false)
                        this.form.coa_setting_arr[this.form1.custom_main_level][this.form1.custom_sub_level][this.form1.custom_level_three][this.form1.custom_level_four] = {};

                        if(response_data[1] in this.form.coa_setting_arr[this.form1.custom_main_level][this.form1.custom_sub_level][this.form1.custom_level_three][this.form1.custom_level_four] == false)
                        this.form.coa_setting_arr[this.form1.custom_main_level][this.form1.custom_sub_level][this.form1.custom_level_three][this.form1.custom_level_four][response_data[1]] = {};
                         

                        this.form.coa_setting_arr[this.form1.custom_main_level][this.form1.custom_sub_level][this.form1.custom_level_three][this.form1.custom_level_four][response_data[1]]={
                            'id':'',
                            'from':'',
                            'to':'',
                            'main_level':this.form1.custom_main_level,
                            'account_title':this.form1.custom_field_name,
                            'sub_level':this.form1.custom_sub_level,
                            'third_level':this.form1.custom_level_three,
                            'forth_level':this.form1.custom_level_four,
                            'active':0,
                            'statement_type':0,
                            'balance_type':'',
                            'transaction_type':'',
                            'retained_earning':0,
                            'income_statement':0,
                            'balance_sheet':0,
                            'reference_id':response_data[1],
                        };


                        this.form1.reset ();
                        $("#coaModal").modal("hide");
                        $('.modal.in').modal('hide');
                        $('.modal-backdrop').remove() ;


                    }
                    else{

                        toast({
                            type: 'danger',
                            title: 'Invalid Operation'
                        });
                    }
                    
                    
                })
            },


            save_stay(type){

              

                this.form.post('/CoaSettings') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save successfully'
                        });

                        if(type==1)
                        {
                             this.fetchCoaUpdate(response_data[1]);
                           // this.form.id=response_data[1];
                            this.editmode=true;
                            //this.form.account_no=response_data[2];
                            //alert(response_data[2])
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                            
                        }
                        else if(type==3)
                        {
                             this.form.reset();
                             this.fetchCoa();


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
            deleteCompany()
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

                      this.form.delete('/CompanyProfiles/'+this.form.id).then(()=>{
                        
                          if(result.value) {
                               Swal(
                                'Deleted!',
                                'Your Company has been deleted.',
                                'success'
                              );
                             this.form.reset();
                             this.fetchCoa();
                          }            

                      }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                  });
               
              })
            },
            fetchCoaUpdate(id)
            {
                this.form.reset ();

                let uri = '/CompanyProfiles/'+id+'/edit';
                window.axios.get(uri).then((response) => {
                    
                    this.main_company_arr                       =response.data.main_company_arr;
                    this.countries                              =response.data.country_arr;
                    this.account_status_arr                     =response.data.account_status_arr;
                    this.payment_term_arr                       =response.data.payment_term_arr;
                    this.currency_arr                           =response.data.currency_arr;
                    this.key_position_lavel                     =response.data.key_position_lavel_arr;
                    this.government_account_lavel               =response.data.government_account_lavel_arr;

                    this.form.id                                =response.data.company_data[0].id;
                    this.form.account_no                        =response.data.company_data[0].account_no;
                    this.form.scope_of_operation                =response.data.company_data[0].scope_of_operation;
                    this.form.legal_name                        =response.data.company_data[0].legal_name;
                    this.form.business_registration_number      =response.data.company_data[0].business_registration_number;
                    this.form.registration_date                 =response.data.company_data[0].registration_date;
                    this.form.business_registration_city        =response.data.company_data[0].business_registration_city;
                    this.form.business_registration_state       =response.data.company_data[0].business_registration_state;
                    this.form.registration_country              =response.data.company_data[0].registration_country;
                    this.form.business_license_no               =response.data.company_data[0].business_license_no;
                    this.form.issued_by                         =response.data.company_data[0].issued_by;
                    this.form.license_state                     =response.data.company_data[0].license_state;
                    this.form.license_country                   =response.data.company_data[0].license_country;
                    this.form.expirey_date                      =response.data.company_data[0].expirey_date;
                    this.form.headoffice_house_number           =response.data.company_data[0].headoffice_house_number;
                    this.form.headoffice_street_number          =response.data.company_data[0].headoffice_street_number;
                    this.form.headoffice_city                   =response.data.company_data[0].headoffice_city;
                    this.form.headoffice_state                  =response.data.company_data[0].headoffice_state;
                    this.form.headoffice_country                =response.data.company_data[0].headoffice_country;
                    this.form.headoffice_zip_code               =response.data.company_data[0].headoffice_zip_code;
                    this.form.contact_person_email              =response.data.company_data[0].contact_person_email;
                    this.form.contact_person_fax_no             =response.data.company_data[0].contact_person_fax_no;
                    this.form.contact_person_cell_phone         =response.data.company_data[0].contact_person_cell_phone;
                    this.form.contact_person_website            =response.data.company_data[0].contact_person_website;
                    this.form.strata_management                 =response.data.company_data[0].strata_management;
                    this.form.parking_management_industry       =response.data.company_data[0].parking_management_industry;
                    this.form.storage_management_company        =response.data.company_data[0].storage_management_company;
                    this.form.leasehold_management              =response.data.company_data[0].leasehold_management;
                    this.form.property_management               =response.data.company_data[0].property_management;
                    this.form.calender_property_manager         =response.data.company_data[0].calender_property_manager;
                    this.form.calender_general_manager          =response.data.company_data[0].calender_general_manager;
                    this.form.calender_building_manager         =response.data.company_data[0].calender_building_manager;



                    this.form.calender_accounts_payable         =response.data.company_data[0].calender_accounts_payable;
                    this.form.calender_accounting_manager       =response.data.company_data[0].calender_accounting_manager;
                    this.form.calender_director                 =response.data.company_data[0].calender_director;
                    this.form.calender_network_administrator    =response.data.company_data[0].calender_network_administrator;
                    this.form.customer_property_management      =response.data.company_data[0].customer_property_management;
                    this.form.customer_seller                   =response.data.company_data[0].customer_seller;
                    this.form.customer_service_provider         =response.data.company_data[0].customer_service_provider;
                    //this.form.government_account_data_arr       =response.data.government_account_data_arr;
                    this.form.fiscal_year_start_date            =response.data.company_data[0].fiscal_year_start_date;
                    this.form.fiscal_year_end_date              =response.data.company_data[0].fiscal_year_end_date;


                    this.form.fiscal_year_in_calender           =response.data.company_data[0].fiscal_year_in_calender;
                    this.form.recuring_cycle                    =response.data.company_data[0].recuring_cycle;


                    this.form.comment_in_calender               =response.data.company_data[0].comment_in_calender;
                    this.form.comments                          =response.data.company_data[0].comments;
                    this.form.comment_date                      =response.data.company_data[0].comment_date;
                    
                    this.editmode=true;
                    for(let i=0; i<response.data.government_account_data_arr.length; i++){

                        this.form.government_account_lavel_data.push({
                            'id':response.data.government_account_data_arr[i].id,
                            'reference_id':response.data.government_account_data_arr[i].reference_id,
                            'reference_value':response.data.government_account_data_arr[i].reference_value,
                            'account_number':response.data.government_account_data_arr[i].account_number,
                            'filling_date':response.data.government_account_data_arr[i].filling_date,
                            'filling_cycle':response.data.government_account_data_arr[i].filling_cycle,
                            'is_callender':response.data.government_account_data_arr[i].is_callender,
                            'master_id':response.data.government_account_data_arr[i].master_id,
                        
                        });
                    }

                    for(let i=0; i<response.data.key_position_data_arr.length; i++){

                        this.form.key_position_lavel_data.push({
                            'id':response.data.key_position_data_arr[i].id,
                            'reference_id':response.data.key_position_data_arr[i].reference_id,
                            'reference_value':response.data.key_position_data_arr[i].reference_value,
                            'office_phone':response.data.key_position_data_arr[i].office_phone,
                            'office_mobile':response.data.key_position_data_arr[i].office_mobile,
                            'fax':response.data.key_position_data_arr[i].fax,
                            'email':response.data.key_position_data_arr[i].email,
                            'key_position_name':response.data.key_position_data_arr[i].key_position_name,
                            'master_id':response.data.key_position_data_arr[i].master_id,
                        
                        });
                    }

                    
                }); 

                
            },


        }
    
    }  
    
</script>



