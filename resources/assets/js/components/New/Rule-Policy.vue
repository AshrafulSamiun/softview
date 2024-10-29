<template>

    <fieldset>
        <form id="msform" @submit.prevent="editmode ? updateRulesPolicyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
            <div class="form-card">
                <h1 class="page-head">Rules, Bylaw & Policies </h1>
                <div class="form-folder">
                    
                    <div class="form-holder">

                        <div class="row align-self-stretch">
                            <div class="col-md-4 col-sm-6 col-xs-12">

                                <div class="form-box-outer">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 active">
                                            <button  type="button" v-if="form.rules_policy==1" class="btn btn-primary">Rules</button>
                                            <button type="button" @click="change_roles(1)" class="btn btn-secondary" v-else>Rules</button>
                                        
                                            <button type="button" v-if="form.rules_policy==2" class="btn btn-primary">Policy</button>
                                            <button type="button" @click="change_roles(2)" class="btn btn-secondary" v-else>Policy</button>
                                        
                                            <button type="button" v-if="form.rules_policy==3" class="btn btn-primary">Bylaw</button>
                                            <button type="button" @click="change_roles(3)" class="btn btn-secondary" v-else>Bylaw</button>
                                        
                                            <button type="button" v-if="form.rules_policy==4" class="btn btn-primary">Law</button>
                                            <button type="button" @click="change_roles(4)" class="btn btn-secondary" v-else>Law</button>
                                        
                                            <button type="button" v-if="form.rules_policy==5" class="btn btn-primary">Act</button>
                                            <button type="button" @click="change_roles(5)" class="btn btn-secondary" v-else>Act</button>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels" v-if="form.rules_policy==1">Rules No:</label>
                                            <label class="fieldlabels" v-else-if="form.rules_policy==2">Policy No:</label> 
                                            <label class="fieldlabels" v-else-if="form.rules_policy==3">Bylaw No:</label>
                                            <label class="fieldlabels" v-else-if="form.rules_policy==4">Law No:</label>
                                            <label class="fieldlabels" v-else>Act No:</label>
                                            <input v-model="form.system_no" 
                                                type="text" 
                                                name="system_no"
                                                 placeholder="Auto Generated"
                                                :class="{ 'is-invalid': form.errors.has('system_no') }" disabled/>
                                            <has-error :form="form" field="system_no"></has-error>
                                                 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Issued Date:</label> 
                                            <date-picker 
                                                style="width:100%"
                                                v-model="form.issued_date"
                                                name="issued_date"                                                         lang="en" 
                                                placeholder="Issued Date" 
                                                format="DD MMM, YYYY"
                                                :class="{ 'is-invalid': form.errors.has('issued_date') }">
                                            </date-picker>
                                          <has-error :form="form" field="issued_date"></has-error> 
                                                 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Audience:</label>  
                                            
                                            <select v-model="form.audience"
                                                name="audience"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('audience') }">
                                                <option disabled value="">--Select Audience-- </option>
                                                <option  value="1">Property Management</option>
                                            </select>
                                            <has-error :form="form" field="audience"></has-error>
                                        </div>
                                    </div>                                    

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Subject:</label>  
                                            
                                            <select v-model="form.subject"
                                                name="subject"
                                                class="custom-select" 
                                                :class="{ 'is-invalid': form.errors.has('subject') }">
                                                <option disabled value="">--Select Subject-- </option>
                                               
                                                <option v-for="(rules_policy_law,index) in rules_policy_arr" :value="index">{{rules_policy_law}}</option>
                                            </select>
                                            <has-error :form="form" field="subject"></has-error>
                                        </div>
                                    </div> 
                                    
                                    
                                    

                                </div>
                               
                            </div>
                           
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="form-box-outer">
                                                
                                    <h4 v-if="form.rules_policy==1">Rules:</h4>
                                    <h4 v-if="form.rules_policy==2">Policy:</h4>
                                    <h4 v-if="form.rules_policy==3">Bylaw:</h4>
                                    <h4 v-if="form.rules_policy==4">Law:</h4>
                                    <h4 v-if="form.rules_policy==5">Act:</h4>
                                    <textarea 
                                        v-model="form.rules_policy_law"
                                            style="height:170px;"
                                            id="rules_policy_law" 
                                            name="rules_policy_law" 
                                            rows="14" 
                                            cols="50"
                                            v-bind:placeholder="place_rules" 
                                        :class="{ 'is-invalid': form.errors.has('rules_policy_law') }">
                                    </textarea>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Prepared By:</label> 
                                            <input v-model="form.prepared_by" 
                                                type="text" 
                                                name="prepared_by"
                                                 placeholder="Prepared By"
                                                :class="{ 'is-invalid': form.errors.has('prepared_by') }" disabled/>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Approved By:</label> 
                                            <input v-model="form.approved_by" 
                                                type="text" 
                                                name="approved_by"
                                                 placeholder="Approved By"
                                                :class="{ 'is-invalid': form.errors.has('approved_by') }" disabled/>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Last update Date and Time:</label> 
                                            <input v-model="form.updated_at" 
                                                type="text" 
                                                name="updated_at"
                                                 placeholder="Last update Date and Time"
                                                :class="{ 'is-invalid': form.errors.has('updated_at') }" disabled/>
                                        </div>
                                    </div>
                                    <has-error :form="form" field="rules_policy_law"></has-error>
                                    <div class="text-center">
                                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New</button>
                                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Edit</button>
                                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click.prevent="deleteRulesPolicy()">Delete</button>
                                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode">Void</button>
                                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(1)">Save-Stay</button>
                                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(2)">Save-Out</button>
                                        <button :disabled="form.busy"  type="submit" class="btn  btn-primary" style="min-width:110px" v-show="!editmode" @click="save_stay(3)">Save-New</button>
                                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                                        <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
                                    </div>
                                </div>

                            </div>
                            
                            <hr>
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
                show_company:true,
                filter: '',
                place_rules:'Type Rules here',
                form:new Form({
                    rules_policy:1,
                    system_no:'',
                    issued_date:'',
                    audience:'',
                    subject:'',
                    rules_policy_law:'',
                    company_id:'',
                    id:'',
                    prepared_by:'',
                    approved_by:'',
                    updated_at:'',
                }),
                rules_policy_arr:'',
            }
        },
        
        created: function()
        {
            
            this.user_menu_name = this.$route.name;
            this.fetchRulesPolicy();
            //this.fetchRulesPolicyUpdate(3);
           
        },
        
        methods: {
            change_roles(type)
            {
                this.form.rules_policy=type;
                if(type==1) this.place_rules="Type Rules here";
                else if(type==2) this.place_rules="Type Policy here";
                else if(type==3) this.place_rules="Type Bylow here";
                else if(type==4) this.place_rules="Type Law here";
                else if(type==5) this.place_rules="Type Act here";
                else this.place_rules="";
            },
            reset_form()
            {

                this.form.reset();
                this.editmode=false;
            },
           

            deleteRulesPolicy()
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

                      this.form.delete('/RulesPolicys/'+this.form.id).then(()=>{
                        
                          if(result.value) {
                               Swal(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                              );
                            this.form.reset();
                            this.fetchRulesPolicy();
                          }            

                      }).catch(()=>{
                        Swal("failed!","there was some wrong","warning");
                  });
               
              })
            },

            fetchRulesPolicy()
            {
                let uri = '/RulesPolicys';
                window.axios.get(uri).then((response) => {  

                    this.rules_policy_arr              =response.data.rules_policy_arr;
                    this.form.prepared_by              =response.data.prepared_by;
                    this.editmode=false;
                });                 
            },

            updateRulesPolicyProfile()
            {
            
                
                this.form.put('/RulesPolicys/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Update Successfully'
                        });

                        
                        this.fetchRulesPolicyUpdate(response_data[1]);
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
                

                this.form.post('/RulesPolicys') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         toast({
                            type: 'success',
                            title: 'Data Save Successfully'
                        });

                        if(type==1)
                        {
                            this.fetchRulesPolicyUpdate(response_data[1]);
                            this.editmode=true;
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                            
                        }
                        else if(type==3)
                        {
                            this.form.reset();
                            this.fetchRulesPolicy();
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

            fetchRulesPolicyUpdate(id)
            {
                this.form.reset ();
                let uri = '/RulesPolicys/'+id+'/edit';
                window.axios.get(uri).then((response) => {  
                    this.rules_policy_arr                   =response.data.rules_policy_arr;
                    this.form.id                            =response.data.rules_policy_data[0].id;
                    this.form.system_no                     =response.data.rules_policy_data[0].system_no;
                    this.form.rules_policy                  =response.data.rules_policy_data[0].rules_policy;
                    this.form.audience                      =response.data.rules_policy_data[0].audience;
                    this.form.subject                       =response.data.rules_policy_data[0].subject;
                    this.form.issued_date                   =response.data.rules_policy_data[0].issued_date;
                    this.form.rules_policy_law              =response.data.rules_policy_data[0].rules_policy_law;
                    this.form.company_id                    =response.data.rules_policy_data[0].company_id;
                    this.form.updated_at                    =response.data.rules_policy_data[0].updated_at;
                    this.form.prepared_by                   =response.data.prepared_by;

                    if(this.form.id)                        this.editmode=true;
                });

            },
        }
    
    }  
    
</script>