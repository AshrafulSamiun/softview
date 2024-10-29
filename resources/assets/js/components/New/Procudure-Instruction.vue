<template>

    <fieldset>
        <form id="msform" @submit.prevent="editmode ? updateRulesPolicyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
            <div class="form-card">
                <h1 class="page-head">Procedures, Instruction & Training </h1>
                <div class="form-folder">
                    
                    <div class="form-holder">

                        <div class="row align-self-stretch">
                            <div class="col-md-4 col-sm-6 col-xs-12">

                                <div class="form-box-outer">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 active">
                                            <button  type="button" v-if="form.procedure_instruction==1" class="btn btn-primary">Procedures</button>
                                            <button type="button" @click="change_procudure(1)" class="btn btn-secondary" v-else>Procedures</button>
                                        
                                            <button type="button" v-if="form.procedure_instruction==2" class="btn btn-primary">Instruction</button>
                                            <button type="button" @click="change_procudure(2)" class="btn btn-secondary" v-else>Instruction</button>
                                        
                                            <button type="button" v-if="form.procedure_instruction==3" class="btn btn-primary">Training</button>
                                            <button type="button" @click="change_procudure(3)" class="btn btn-secondary" v-else>Training</button>
                                        
                                            
                                        </div>

                                    </div>
                                    <div class="row">                                     
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels" v-if="form.procedure_instruction==1">Procedures No:</label>
                                            <label class="fieldlabels" v-else-if="form.procedure_instruction==2">Instruction No:</label> 
                                            <label class="fieldlabels" v-else-if="form.procedure_instruction==3">Training:</label>
                                           
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
                                                name="issued_date"                                                         
                                                lang="en" 
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
                                    <div class="row">

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="fieldlabels">Apply Date and Time:</label> 
                                            <input v-model="form.created_at" 
                                                type="text" 
                                                name="created_at"
                                                 placeholder="Apply Date and Time"
                                                :class="{ 'is-invalid': form.errors.has('created_at') }" disabled/>
                                        </div>
                                    </div>
                                    
                                    

                                </div>
                               
                            </div>
                           
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="form-box-outer">
                                                
                                    <h4 v-if="form.procedure_instruction==1">Procedures:</h4>
                                    <h4 v-if="form.procedure_instruction==2">Instruction:</h4>
                                    <h4 v-if="form.procedure_instruction==3">Training:</h4>
                                    
                                    <textarea 
                                        v-model="form.procedure_instruction_description"
                                            style="height:170px;"
                                            id="procedure_instruction_description" 
                                            name="procedure_instruction_description" 
                                            rows="14" 
                                            cols="50"
                                            v-bind:placeholder="place_rules" 
                                        :class="{ 'is-invalid': form.errors.has('procedure_instruction_description') }">
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
                                    <has-error :form="form" field="procedure_instruction_description"></has-error>
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
                place_rules:'Type Procedures here',
                form:new Form({
                    procedure_instruction:1,
                    system_no:'',
                    issued_date:'',
                    audience:'',
                    subject:'',
                    procedure_instruction_description:'',
                    company_id:'',
                    id:'',
                    prepared_by:'',
                    approved_by:'',
                    updated_at:'',
                    created_at:'',
                }),
                rules_policy_arr:'',
            }
        },
        
        created: function()
        {
            
            this.user_menu_name = this.$route.name;
            this.fetchRulesPolicy();
            this.fetchRulesPolicyUpdate(3);
           
        },
        
        methods: {
            change_procudure(type)
            {
                this.form.procedure_instruction=type;
                if(type==1) this.place_rules="Type Procedures here";
                else if(type==2) this.place_rules="Type Instruction here";
                else if(type==3) this.place_rules="Type Training here";
                
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

                      this.form.delete('/ProcedureInstructions/'+this.form.id).then(()=>{
                        
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
                let uri = '/ProcedureInstructions';
                window.axios.get(uri).then((response) => {  

                    this.rules_policy_arr              =response.data.rules_policy_arr;
                    this.form.prepared_by              =response.data.prepared_by;
                    this.editmode=false;
                });                 
            },

            updateRulesPolicyProfile()
            {
            
                
                this.form.put('/ProcedureInstructions/'+this.form.id).then(({ data })=>{
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
                

                this.form.post('/ProcedureInstructions') .then(({ data }) => { 
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
                let uri = '/ProcedureInstructions/'+id+'/edit';
                window.axios.get(uri).then((response) => {  
                    this.rules_policy_arr                           =response.data.rules_policy_arr;
                    this.form.id                                    =response.data.procedure_instruction_data[0].id;
                    this.form.system_no                             =response.data.procedure_instruction_data[0].system_no;
                    this.form.procedure_instruction                 =response.data.procedure_instruction_data[0].procedure_instruction;
                    this.form.audience                              =response.data.procedure_instruction_data[0].audience;
                    this.form.subject                               =response.data.procedure_instruction_data[0].subject;
                    this.form.issued_date                           =response.data.procedure_instruction_data[0].issued_date;
                    this.form.procedure_instruction_description     =response.data.procedure_instruction_data[0].procedure_instruction_description;
                    this.form.company_id                            =response.data.procedure_instruction_data[0].company_id;
                    this.form.updated_at                            =response.data.updated_at;
                    this.form.created_at                            =response.data.created_at;
                    this.form.prepared_by                           =response.data.prepared_by;

                    if(this.form.id)                                this.editmode=true;
                    this.change_procudure(this.form.procedure_instruction);

                });

            },
        }
    
    }  
    
</script>