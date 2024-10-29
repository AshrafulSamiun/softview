<template>

    <section class="app-main__inner">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card">
                
                        <div id="content">
                            
                            <div class="form-card"> 
                                
                                <div class="form-folder">
                                    <h3><i class="fa fa-hand-point-right"></i>Chart of Accounts </h3>
                                    <div class="form-holder">
                                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px;border-radius:50rem " @click="addNewAccount(0,0,0,0)">Add New Account</button>
                                        <div class="row align-self-stretch">
                                            
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td v-for="(sub_group,index) in accounts_sub_group" style="padding:.1rem">
                                                            <a :class="{active:selected_sub_group==index}" href="JavaScript:void(0);" @click="load_sub_group_data(index)" style="font-size:11px;" v-if="sub_level_total[index]>0">{{sub_group}}({{sub_level_total[index]}}) </a>
                                                            <a :class="{active:selected_sub_group==index}" href="JavaScript:void(0);" @click="load_sub_group_data(index)" style="font-size:11px;" v-else>{{sub_group}}(0)
                                                                <span class="rounded-circle"></span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                           
                                            </table>
                                            <hr>
                                            <table class="table table_narrow" >
                                                <tbody style="border:none;text-align:center;vertical-align:middle;border:none">
                                                    <template v-for="(sub_group, index) in coa_setting_sub_lavel_arr[selected_sub_group]">
                                                        <tr  >
                                                            <td colspan="6" class="text-left" style="background-color:rgba(169, 190, 217, 0.52);color:#000">{{sub_group.account_title}}</td>
                                                            <td colspan="6" class="text-left" style="background-color:rgba(169, 190, 217, 0.52);color:#000"></td>
                                                        </tr>
                                                        <template v-if=" selected_sub_group in coa_arr">
                                                            <template  v-for="(temp_sub_group, sb_index) in coa_arr" v-if="sb_index==selected_sub_group">
                                                                <template v-if=" index in temp_sub_group">

                                                                    <template  v-for="(temp_second_level, sm_index) in temp_sub_group" v-if="sm_index==index">
                                                                        <template  v-for="(temp_third_level, tm_index) in temp_second_level" v-if="tm_index==0">
                                                                            <template  v-for="(temp_forth_level, fm_index) in temp_third_level" v-if="fm_index==0">

                                                                                <tr style="background-color:rgb(250,253,243)">
                                                                                    <td colspan="2" class="text-left" style="color:#000;"></td>
                                                                                    <td colspan="2" class="text-left" style="color:#000;">Account No</td>
                                                                                    <td colspan="2" class="text-left" style="color:#000;">Description</td>
                                                                                    <td colspan="2" class="text-left" style="color:#000;">Govt. Tax Code</td>
                                                                                    <td colspan="2" class="text-left" style="color:#000;" v-if="selected_sub_group==7 || selected_sub_group==10">Sales Tax</td>
                                                                                    <td colspan="2" class="text-left" style="color:#000;" v-else-if="selected_sub_group==9 || selected_sub_group==11">Purchase Tax</td>
                                                                                    <td colspan="2" class="text-left" style="color:#000;" v-else></td>
                                                                                    <td colspan="2" class="text-left" style="color:#000;" ></td>
                                                                                    
                                                                                </tr>
                                                                                <template  v-for="(temp_coa, c_index) in temp_forth_level" >
                                                                                    <tr>
                                                                                        <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"></td>
                                                                                        <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">{{temp_coa.account_no}}</td>
                                                                                        <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">{{temp_coa.description}}</td>
                                                                                        <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">{{temp_coa.govt_tax_code}}</td>
                                                                                        <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">{{temp_coa.tax_code}}</td>
                                                                                        <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)" @click="edit_chart_of_account(selected_sub_group,index,0,0,temp_coa)"><i class="fas fa-edit" ></i></td>
                                                                                        
                                                                                    </tr>
                                                                                 </template>
                                                                                 <tr>
                                                                                    <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"> </td>
                                                                                    <td colspan="10" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"> 
                                                                                        <a href="JavaScript:void(0);" style="color:blue;cursor:pointer;" @click="addNewAccount(selected_sub_group,index,0,0)">
                                                                                            <i class="fa fa-plus-circle" aria-hidden="false"></i> Add New Account No
                                                                                     </a>
                                                                                    </td>
                                                                                    
                                                                                </tr>
                                                                            </template>
                                                                        </template>
                                                                    </template>
                                                                </template>
                                                                <template v-else>
                                                                    <tr>
                                                                        <td  class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"> </td>
                                                                        <td colspan="5" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">No Item in {{sub_group.account_title}} 

                                                                            <a href="JavaScript:void(0);" style="color:blue;cursor:pointer;" @click="addNewAccount(selected_sub_group,index,0,0)">
                                                                                <i class="fa fa-plus-circle" aria-hidden="false"></i> Add New Account No
                                                                         </a>
                                                                        </td>
                                                                        <td colspan="6" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"></td>
                                                                    </tr>
                                                                </template>
                                                            </template>
                                                        </template>
                                                        <template v-else>
                                                            <tr>
                                                                <td colspan="1" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"> </td>
                                                                <td colspan="5" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">No Item in {{sub_group.account_title}}

                                                                    <a href="JavaScript:void(0);" style="color:blue;cursor:pointer;" @click="addNewAccount(selected_sub_group,index,0,0)">
                                                                        <i class="fa fa-plus-circle" aria-hidden="false"></i> Add New Account No
                                                                 </a>
                                                                </td>
                                                                
                                                                <td colspan="6" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"></td>
                                                            </tr>
                                                        </template>



                                                        <template v-for="(temp_sub_group, s_index) in coa_setting_second_lavel_arr[selected_sub_group]" v-if="index==s_index">
                                                            <template v-for="(second_level, index1) in temp_sub_group">
                                                                <tr  >
                                                                    <td style="background-color:rgba(218, 229, 243, 0.37);color:#000"></td>
                                                                    <td colspan="5" class="text-left" style="background-color:rgba(218, 229, 243, 0.37);color:#000">{{second_level.account_title}}  </td>
                                                                    <td colspan="6" class="text-left" style="background-color:rgba(218, 229, 243, 0.37);color:#000"></td>
                                                                </tr>
                                                                <!---------------------  second lavel coa-------------->

                                                                <template v-if=" selected_sub_group in coa_arr">

                                                                    <template  v-for="(temp_sub_group, sb_index) in coa_arr" v-if="sb_index==selected_sub_group">
                                                                        <template v-if=" index in temp_sub_group">
                                                                            <template  v-for="(temp_second_level, sm_index) in temp_sub_group" v-if="sm_index==index">
                                                                                <template v-if=" index1 in temp_second_level">
                                                                                    <template  v-for="(temp_third_level, tm_index) in temp_second_level" v-if="tm_index==index1">
                                                                                        <template  v-for="(temp_forth_level, fm_index) in temp_third_level" v-if="fm_index==0">


                                                                                            <tr style="background-color:rgb(250,253,243)">
                                                                                                <td colspan="2" width="10%" class="text-left" style="color:#000;"></td>
                                                                                                <td colspan="2" class="text-left" style="color:#000;">Account No</td>
                                                                                                <td colspan="2" class="text-left" style="color:#000;">Description</td>
                                                                                                <td colspan="2" class="text-left" style="color:#000;">Govt. Tax Code</td>
                                                                                                <td colspan="2" class="text-left" style="color:#000;" v-if="selected_sub_group==7 || selected_sub_group==10">Sales Tax</td>
                                                                                                <td colspan="2" class="text-left" style="color:#000;" v-else-if="selected_sub_group==9 || selected_sub_group==11">Purchase Tax</td>
                                                                                                <td colspan="2" class="text-left" style="color:#000;" v-else></td>
                                                                                                <td colspan="2" class="text-left" style="color:#000;" ></td>
                                                                                                
                                                                                            </tr>
                                                                                            <template  v-for="(temp_coa, c_index) in temp_forth_level" >
                                                                                                <tr>
                                                                                                    <td colspan="2" width="10%" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"></td>
                                                                                                    <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">{{temp_coa.account_no}}</td>
                                                                                                    <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">{{temp_coa.description}}</td>
                                                                                                    <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">{{temp_coa.govt_tax_code}}</td>
                                                                                                    <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">{{temp_coa.tax_code}}</td>
                                                                                                    <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)" @click="edit_chart_of_account(selected_sub_group,index,index1,0,temp_coa)"><i class="fas fa-edit" ></i></td>
                                                                                                    
                                                                                                </tr>
                                                                                             </template>
                                                                                             <tr>
                                                                                                <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"></td>
                                                                                                <td colspan="10" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"> 

                                                                                                    <a href="JavaScript:void(0);" style="color:blue; cursor:pointer;" @click="addNewAccount(selected_sub_group,index,index1,0)">
                                                                                                        <i class="fa fa-plus-circle" aria-hidden="false"></i> Add New Account No
                                                                                                    </a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </template>
                                                                                    </template>
                                                                                </template>
                                                                                <template v-else>
                                                                                    <tr>
                                                                                        <td colspan="2" width="10%" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"></td>
                                                                                        <td colspan="10" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">No Item in {{second_level.account_title}}

                                                                                            <a href="JavaScript:void(0);" style="color:blue; cursor:pointer;" @click="addNewAccount(selected_sub_group,index,index1,0)">
                                                                                                <i class="fa fa-plus-circle" aria-hidden="false"></i> Add New Account No
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </template>

                                                                            </template>
                                                                        </template>
                                                                        <template v-else>
                                                                            <tr>
                                                                                <td colspan="2" width="10%" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"></td>
                                                                                <td colspan="10" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">No Item in {{second_level.account_title}}

                                                                                    <a href="JavaScript:void(0);" style="color:blue; cursor:pointer;" @click="addNewAccount(selected_sub_group,index,index1,0)">
                                                                                        <i class="fa fa-plus-circle" aria-hidden="false"></i> Add New Account No
                                                                                    </a>
                                                                                </td>
                                                                                
                                                                                
                                                                            </tr>
                                                                        </template>
                                                                    </template>
                                                                </template>
                                                                <template v-else>
                                                                    <tr>
                                                                        <td colspan="2" width="10%" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"> </td>
                                                                        <td colspan="10" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)" align="left">No Item in {{second_level.account_title}}
                                                                            <a href="JavaScript:void(0);" style="color:blue; cursor:pointer;" @click="addNewAccount(selected_sub_group,index,index1,0)">
                                                                                <i class="fa fa-plus-circle" aria-hidden="false"></i> Add New Account No
                                                                         </a>
                                                                        </td>
                                                                       
                                                                    </tr>
                                                                </template>
                                                                <!---------------------  second lavel coa finish-------------->
                                                                <template v-for="(sub_group_data, t_index1) in coa_setting_third_lavel_arr[selected_sub_group]" >
                                                                    <template v-for="(second_level_data, t_index2) in sub_group_data" v-if="t_index2==index1">
                                                                        <template v-for="(third_level_data, t_index3) in second_level_data" >
                                                                            <tr>
                                                                                <td width="5%" style="background-color:rgba(211, 236, 243, 0.15);color:#000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                                 <td width="5%"  style="background-color:rgba(211, 236, 243, 0.15);color:#000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                                <td colspan="4" class="text-left" style="background-color:rgba(211, 236, 243, 0.15);color:#000">{{third_level_data.account_title}}</td>
                                                                                <td colspan="6" class="text-left" style="background-color:rgba(211, 236, 243, 0.15);color:#000"></td>
                                                                            </tr>
                                                                            <!---------------------  third lavel coa-------------->

                                                                            <template v-if=" selected_sub_group in coa_arr">

                                                                                <template  v-for="(temp_sub_group, sb_index) in coa_arr" v-if="sb_index==selected_sub_group">
                                                                                    <template v-if=" index in temp_sub_group">
                                                                                        <template  v-for="(temp_second_level, sm_index) in temp_sub_group" v-if="sm_index==index">
                                                                                            <template v-if=" index1 in temp_second_level">

                                                                                                <template  v-for="(temp_third_level, tm_index) in temp_second_level" v-if="tm_index==index1">
                                                                                                    <template  v-for="(temp_forth_level, fm_index) in temp_third_level" v-if="fm_index==t_index3">
                                                                                                        <tr style="background-color:rgb(250,253,243)">
                                                                                                            <td colspan="3" class="text-left" style="color:#000;"></td>
                                                                                                            <td colspan="2" class="text-left" style="color:#000;">Account No</td>
                                                                                                            <td colspan="2" class="text-left" style="color:#000;">Description</td>
                                                                                                            <td colspan="2" class="text-left" style="color:#000;">Govt. Tax Code</td>
                                                                                                            <td colspan="2" class="text-left" style="color:#000;" v-if="selected_sub_group==7 || selected_sub_group==10">Sales Tax</td>
                                                                                                            <td colspan="2" class="text-left" style="color:#000;" v-else-if="selected_sub_group==9 || selected_sub_group==11">Purchase Tax</td>
                                                                                                            <td colspan="2" class="text-left" style="color:#000;" v-else></td>
                                                                                                            <td colspan="1" class="text-left" style="color:#000;" ></td>
                                                                                                        </tr>
                                                                                                        <template  v-for="(temp_coa, c_index) in temp_forth_level" >
                                                                                                            <tr>
                                                                                                                <td colspan="3"  width="15%" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"></td>
                                                                                                                <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">{{temp_coa.account_no}}</td>
                                                                                                                <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">{{temp_coa.description}}</td>
                                                                                                                <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">{{temp_coa.govt_tax_code}}</td>
                                                                                                                <td colspan="2" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">{{temp_coa.tax_code}}</td>
                                                                                                                <td colspan="1" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)" @click="edit_chart_of_account(selected_sub_group,index,index1,t_index3,temp_coa)"><i class="fas fa-edit" ></i></td>
                                                                                                                
                                                                                                            </tr>
                                                                                                         </template>
                                                                                                         <tr>
                                                                                                            <td colspan="3" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"></td>
                                                                                                            <td colspan="9" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">

                                                                                                                <a href="JavaScript:void(0);" style="color:blue; cursor:pointer;" @click="addNewAccount(selected_sub_group,index,index1,t_index3)">
                                                                                                                    <i class="fa fa-plus-circle" aria-hidden="false"></i> Add New Account No
                                                                                                                </a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </template>
                                                                                                </template>
                                                                                            </template>
                                                                                            <template v-else>
                                                                                                <tr>
                                                                                                    <td colspan="3" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"></td>
                                                                                                    <td colspan="9" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">No Item in {{second_level.account_title}}

                                                                                                        <a href="JavaScript:void(0);" style="color:blue; cursor:pointer;" @click="addNewAccount(selected_sub_group,index,index1,t_index3)">
                                                                                                            <i class="fa fa-plus-circle" aria-hidden="false"></i> Add New Account No
                                                                                                        </a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </template>
                                                                                        </template>
                                                                                    </template>
                                                                                    <template v-else>
                                                                                        <tr>
                                                                                            <td colspan="3" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"></td>
                                                                                            <td colspan="9" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">No Item in {{second_level.account_title}}

                                                                                                <a href="JavaScript:void(0);" style="color:blue; cursor:pointer;" @click="addNewAccount(selected_sub_group,index,index1,t_index3)">
                                                                                                    <i class="fa fa-plus-circle" aria-hidden="false"></i> Add New Account No
                                                                                                </a>
                                                                                            </td>
                                                                                            
                                                                                            
                                                                                        </tr>
                                                                                    </template>
                                                                                </template>
                                                                            </template>
                                                                            <template v-else>
                                                                                <tr>
                                                                                    <td colspan="3" width="15%" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)"> </td>
                                                                                    <td colspan="9" class="text-left" style="color:#000; border-bottom:2px solid rgb(191, 191, 193)">No Item in {{third_level_data.account_title}}
                                                                                        <a href="JavaScript:void(0);" style="color:blue; cursor:pointer;" @click="addNewAccount(selected_sub_group,index,index1,t_index3)">
                                                                                            <i class="fa fa-plus-circle" aria-hidden="false"></i> Add New Account No
                                                                                     </a>
                                                                                    </td>
                                                                                   
                                                                                </tr>
                                                                            </template>
                                                                            <!---------------------  third lavel coa finish-------------->

                                                                        </template>
                                                                    </template>
                                                                </template>
                                                            </template>
                                                        </template>
                                                    </template>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
             

            </div>
            
        </div>
        <!--  MOdel  -->
                    <div class="modal fade model-middle" id="coaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" z-index="1000" aria-hidden="true">
                        <div class="modal-dialog" role="document" >

                            <div class="modal-content" style="width:700px">
                                <form id="msform" @submit.prevent="editmode ? updateCoa() : createCoa()" @keydown="form.onKeydown($event)">    
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel" >Add New Chart of Account</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="modelClose()">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    <div class="modal-body" style="height: 80vh;overflow-y: auto;">
                                        <div class="form-holder">
                                            
                                            <div class="row align-self-stretch">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-box-outer">
                                                        

                                                        <div class="row">
                                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                                <label class="fieldlabels">Sub Group</label> 
                                                            </div>
                                                            <div class="col-md-9 col-sm-6 col-xs-12">
                                                                <select v-model="form.sub_group"
                                                                    name="sub_group"
                                                                    id="sub_group"
                                                                    @change="change_sub_group"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('sub_group') }">
                                                                    <option disabled value="0">--Select-- </option>
                                                                    <option v-for="(sub_group, index) in accounts_sub_group" :value="index">{{sub_group}}</option>
                                                                    
                                                                </select>
                                                                <has-error :form="form" field="sub_group"></has-error>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                                <label class="fieldlabels">Second Level</label> 
                                                            </div>
                                                            <div class="col-md-9 col-sm-6 col-xs-12">
                                                                <select v-model="form.second_level"
                                                                    name="second_level"
                                                                    id="second_level"
                                                                    @change="change_second_level"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('second_level') }">
                                                                    <option disabled value="0">--Select-- </option>
                                                                    
                                                                    <option v-for="(sub_group, index) in coa_setting_sub_lavel_arr[form.sub_group]" :value="index">{{sub_group.account_title}}</option>
                                                                    
                                                                    
                                                                </select>
                                                                <has-error :form="form" field="second_level"></has-error>
                                                                     
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                                <label class="fieldlabels">Third Level</label> 
                                                            </div>
                                                            <div class="col-md-9 col-sm-6 col-xs-12">
                                                                <select v-model="form.third_level"
                                                                    name="third_level"
                                                                    id="third_level"
                                                                    @change="change_third_level"
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('third_level') }">
                                                                    <option disabled value="0">--Select-- </option>

                                                                    <template v-for="(temp_second_level,s_level) in coa_setting_second_lavel_arr[form.sub_group]">
                                                                        <option v-for="(third_level, index1) in temp_second_level" :value="index1" v-if="s_level==form.second_level">{{third_level.account_title}}</option>
                                                                    </template>
                                                                    
                                                                </select>
                                                                <has-error :form="form" field="third_level"></has-error>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                                <label class="fieldlabels">Forth Level</label> 
                                                            </div>
                                                            <div class="col-md-9 col-sm-6 col-xs-12">
                                                                <select v-model="form.forth_level"
                                                                    name="forth_level"
                                                                    id="forth_level"
                                                                    @change="change_forth_level"
                                                                    
                                                                    class="custom-select" 
                                                                    :class="{ 'is-invalid': form.errors.has('forth_level') }">
                                                                    <option disabled value="0">--Select-- </option>
                                                                    <template v-for="(temp_second_level,sec_level) in coa_setting_third_lavel_arr[form.sub_group]">
                                                                        <template v-for="(temp_third_level,t_level) in temp_second_level" v-if="sec_level==form.second_level">
                                                                            <option v-for="(forth_level, index2) in temp_third_level" :value="index2" v-if="t_level==form.third_level">{{forth_level.account_title}}</option>
                                                                         </template>
                                                                    </template>                                                                  
                                                                    
                                                                </select>
                                                                <has-error :form="form" field="forth_level"></has-error>
                                                                     
                                                            </div>
                                                        </div>
                                                        <div class="row" >
                                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                                <label class="fieldlabels">Account No</label> 
                                                            </div>
                                                            <div class="col-md-9 col-sm-6 col-xs-12">
                                                                <input v-model="form.account_no" 
                                                                    type="text"
                                                                    placeholder="Type Account No" 
                                                                    class="form-control"
                                                                    name="account_no" 
                                                                    :class="{ 'is-invalid': form.errors.has('account_no') }"/>
                                                                      <has-error :form="form" field="account_no"></has-error>
                                                                     
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                                <label class="fieldlabels">Description</label> 
                                                            </div>
                                                            <div class="col-md-9 col-sm-6 col-xs-12">
                                                                <textarea 
                                                                    v-model="form.description"
                                                                        style="height:70px;"
                                                                        id="description" 
                                                                        name="description" 
                                                                        rows="4" 
                                                                        cols="50"
                                                                        placeholder="Type Description" 
                                                                    :class="{ 'is-invalid': form.errors.has('description') }">
                                                                </textarea>
                                                                <has-error :form="form" field="description"></has-error>
                                                                     
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                                <label class="fieldlabels">Govt. Tax Code</label> 
                                                            </div>
                                                            <div class="col-md-9 col-sm-6 col-xs-12">
                                                                <input v-model="form.govt_tax_code" 
                                                                    type="text"
                                                                    placeholder="Type Govt. Tax Code" 
                                                                    class="form-control"
                                                                    name="govt_tax_code" 
                                                                    :class="{ 'is-invalid': form.errors.has('govt_tax_code') }"/>
                                                                    <has-error :form="form" field="govt_tax_code"></has-error>
                                                                     
                                                            </div>
                                                        </div>
                                                        <div class="row" v-if="form.sub_group==7 || form.sub_group==10">
                                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                                <label class="fieldlabels">Sales Tax Code</label> 
                                                            </div>
                                                            <div class="col-md-9 col-sm-6 col-xs-12">
                                                                <input v-model="form.tax_code" 
                                                                    type="text"
                                                                    placeholder="Type Sales Tax Code" 
                                                                    class="form-control"
                                                                    name="tax_code" 
                                                                    :class="{ 'is-invalid': form.errors.has('tax_code') }"/>
                                                                    <has-error :form="form" field="tax_code"></has-error>
                                                                     
                                                            </div>
                                                        </div>
                                                        <div class="row" v-else-if="form.sub_group==9 || form.sub_group==11">
                                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                                <label class="fieldlabels">Purchase Tax Code</label> 
                                                            </div>
                                                            <div class="col-md-9 col-sm-6 col-xs-12">
                                                                <input v-model="form.tax_code" 
                                                                    type="text"
                                                                    placeholder="Type Purchase Tax Code" 
                                                                    class="form-control"
                                                                    name="tax_code" 
                                                                    :class="{ 'is-invalid': form.errors.has('tax_code') }"/>
                                                                    <has-error :form="form" field="tax_code"></has-error>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="modelClose()">Close</button>
                                                        <button type="submit" class="btn btn-primary" v-show="!editmode">Save</button>
                                                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Update</button>
                                                    </div> 
                                                   
                                                </div>
                                               
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="padding-bottom:50px;">
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            <!-- model end -->
     
    </div>

   


</section>


</template>
<style>
    a.active {

     font-size:14px !important;
     color:#000;
     font-weight:bold;
     border-bottom:3px solid #0d6efd;
    }

</style>

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
                    id:'',
                    coa_group:0,
                    sub_group:0,
                    second_level:0,
                    third_level:0,
                    forth_level:0,
                    account_no:'',
                    description:'',
                    govt_tax_code:'',
                    tax_code:'',
                    income_tax_showable:false,                
                }),
                selected_sub_group:1,
                accounts_sub_group:[],
                coa_setting_sub_lavel_arr:[],
                coa_setting_second_lavel_arr:[],
                coa_setting_third_lavel_arr:[],
      
            }
        },
        
        created: function()
        {
            
            this.user_menu_name = this.$route.name;
            this.fetchCoa();
        },
        
        methods: {


            modelClose()
            {
                this.reset_form();

            },
            edit_chart_of_account(sub_group,second_level,third_level,forth_level,coa)
            {
                this.form.id=coa.id;
                this.form.coa_group=coa.coa_group;
                this.form.sub_group=sub_group;
                this.form.second_level=second_level;
                this.form.third_level=third_level;
                this.form.forth_level=forth_level;
                this.form.account_no=coa.account_no;
                this.form.description=coa.description;
                this.form.govt_tax_code=coa.govt_tax_code;
                this.form.tax_code=coa.tax_code;
                if(coa.statement_type==2) this.form.income_tax_showable=true;
                else this.form.income_tax_showable=false;
                this.editmode=true;

                $("#coaModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;

               // $("#coaModal").css('z-index','9999999999999999999');
            },

            load_sub_group_data(sub_group)
            {
                this.selected_sub_group=sub_group;
            },

            change_sub_group()
            {
                this.form.second_level=0;
                this.form.third_level=0;
                this.form.forth_level=0;
                this.form.income_tax_showable=false;
            },

            change_second_level()
            {
                this.form.third_level=0;
                this.form.forth_level=0;
                if(this.coa_setting_sub_lavel_arr[this.form.sub_group][this.form.second_level].statement_type==2)
                {
                    this.form.income_tax_showable=true;
                }
                else{
                    this.form.income_tax_showable=false;
                }
            },
            change_third_level()
            {
                this.form.forth_level=0;
                if(this.coa_setting_second_lavel_arr[this.form.sub_group][this.form.second_level][this.form.third_level].statement_type==2)
                {
                    this.form.income_tax_showable=true;
                }
                else{
                    this.form.income_tax_showable=false;
                }
                
            },

            change_forth_level()
            {
                
                if(this.coa_setting_third_lavel_arr[this.form.sub_group][this.form.second_level][this.form.third_level][this.form.forth_level].statement_type==2)
                {
                    this.form.income_tax_showable=true;
                }
                else{
                    this.form.income_tax_showable=false;
                }
                
            },

            fetchCoa()
            {
                let uri = '/ChartOfAccounts';
                window.axios.get(uri).then((response) => {
                    
                    this.accounts_sub_group                 =response.data.accounts_sub_group;
                    this.coa_setting_sub_lavel_arr          =response.data.coa_setting_sub_lavel_arr;
                    this.coa_setting_second_lavel_arr       =response.data.coa_setting_second_lavel_arr;
                    this.coa_setting_third_lavel_arr        =response.data.coa_setting_third_lavel_arr;
                    this.sub_level_total                    =response.data.sub_level_total;
                    this.coa_arr                            =response.data.coa_arr;
                    
                }); 
                
            },

            addNewAccount(sub_group,second_level,third_level,forth_level)
            {
                this.form.sub_group=sub_group;
                this.form.second_level=second_level;
                this.form.third_level=third_level;
                this.form.forth_level=forth_level;
                $("#coaModal").modal('show');
                $('.modal.fade').addClass('modal fade show');
                $('modal-backdrop').addClass('modal-backdrop fade show') ;
            },

           

            reset_form()
            {

                this.form.reset ();
                this.editmode=false;
                
            },

            
            
            updateCoa()
            {
            
                
                this.form.put('/ChartOfAccounts/'+this.form.id)
                    .then(({ data })=>{
                        var response_data=data.split("**");
                        if(response_data[0]==1)
                        {
                            toast({
                                type: 'success',
                                title: 'Data Update Successfully'
                            });

                            this.form.reset();
                            this.fetchCoa();
                            
                            $("#coaModal").modal("hide");
                            $('.modal.in').modal('hide');
                            $('.modal-backdrop').remove() ;
                            this.editmode=false;

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
            
            createCoa()
            {
                this.form.post('/ChartOfAccounts') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                        toast({
                            type: 'success',
                            title: 'Data Save successfully'
                        });
                    
                        this.form.reset();
                        this.form.reset();
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
           


        }
    
    }  
    
</script>



