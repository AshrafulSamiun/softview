<template>
    <fieldset>
        
        
        <div class="row align-self-stretch">
            <div class="col-md-9 col-sm-6 col-xs-9">
                <div class="form-card">

                    <div class="d-flex gap-3 p-3 ">
                    
                        <div class="text-center custom-btn">
                            <button class="btn btn-primary " >Gross Profit (Loss)</button>
                            <div class="details">+200</div>
                        </div>
                        <div class="text-center custom-btn">
                            <button class="btn btn-primary" >Net Profit (Loss)</button>
                    
                            <div class="details">+100</div>
                        </div>


                        <div class="text-center custom-btn">
                            <button class="btn btn-primary" >Net Cash In/ Out    
                            </button>
                    
                            <div class="details">Details</div>
                        </div>

                        <div class="text-center custom-btn">
                             <button class="btn btn-primary" >Invoice Term</button>  
                    
                            <div class="details">500</div>
                        </div>
                        

                        <div class="text-center custom-btn">
                            <button class="btn btn-primary" >AP Vs AR</button>
                    
                            <div class="details">Details</div>
                        </div>
                        <div class="text-center custom-btn">
                            <button class="btn btn-primary" >Pass Due AP </button>
                    
                            <div class="details">30</div>
                        </div>

                        <div class="text-center custom-btn">
                            <button class="btn btn-primary fs-6" >Pass Due AR</button>
                    
                            <div class="details">45</div>
                        </div>
                    </div>
                </div>


                <div class="form-card mt-3">
                    <div class="form-folder" >
                        <h3 class="bg-dark text-warning"><i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;Alerts</h3>

                        <div class="d-flex gap-3 p-3 ">
                    
                            <div class="text-center custom-btn" style="width:16%">
                                <button class="btn btn-success "  style="background-color: #64813D;width:100%">Normal</button>
                                <div class="details">+200</div>
                            </div>
                            <div class="text-center custom-btn" style="width:16%">
                                <button class="btn bg-secondary text-white"  style="width:100%">Low</button>
                        
                                <div class="details">+100</div>
                            </div>


                            <div class="text-center custom-btn" style="width:16%">
                                <button class="btn btn-warning" style="width:100%">Midium   
                                </button>
                        
                                <div class="details">Details</div>
                            </div>

                            <div class="text-center custom-btn" style="width:16%">
                                 <button class="btn btn-danger"  style="width:100%">High</button>  
                        
                                <div class="details">500</div>
                            </div>
                            

                            <div class="text-center custom-btn" style="width:16%">
                                <button class="btn btn-danger"  style="background-color:#63339C; border:1px solid #63339C; width:100%">Urgent</button>
                                <div class="details">Details</div>
                            </div>
                            <div class="text-center custom-btn" style="width:16%">
                                <button class="btn btn-dark" style="width:100%" >Immediate Action</button>
                        
                                <div class="details">30</div>
                            </div>

                            
                        </div>
                    </div>
                </div> 



            </div>
            <div class="col-md-3 col-sm-6 col-xs-3">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 clo-sm-12 col-xs-12">
                <div class="form-card">

                    <div>
                        <Chart
                            :size="{ width: 500, height: 400 }"
                            :data="data"
                            :margin="margin"
                            :direction="direction">

                            <template #layers>
                              <Grid strokeDasharray="2,2" />
                              <Line :dataKeys="['name', 'pl']" />
                            </template>

                          </Chart>
                    </div>
                </div>
            </div>
        </div>
    
        
    </fieldset>
   
   
</template>
<script>
    import { defineComponent,ref } from "vue";
    import Vue3Datatable from "@bhplugin/vue3-datatable";
    import "@bhplugin/vue3-datatable/dist/style.css";
    import DatePicker from 'vue3-datepicker';
    import { Chart, Grid, Line } from 'vue3-charts';
    import { plByMonth } from '@/data';

   

    export default {
        name: 'list-product-categories',
        components: {
            DatePicker,
            Vue3Datatable,
            Chart,
            Grid,
            Line 
        },
        data() {
            return {
                editmode: false,
                show_company: true,
                filter: '',
                form: new Form({
                    company_avaibale: true,
                    company_id: "",
                    company_type: '',
                    account_no: '',
                    legal_name: '',
                    currency_id: '',
                    company_arr: [],
                }),
                columns: ref([
                    {title: 'SL', field: 'sl', align: 'center'},
                    {title: 'Company', field: 'company_name'},
                    {title: 'Last Modified Date and Time', field: 'last_modified_date'},
                    {title: 'Last Modification By', field: 'last_modified_by'},
                ]),
                page: 1,
                per_page: 15,
                expanded: null,

                data = ref(plByMonth),
                direction = ref('horizontal'),
                margin = ref({
                  left: 0,
                  top: 20,
                  right: 20,
                  bottom: 0
                }),
            }
        },
        created: function () {
            this.user_menu_name = this.$route.name;
            this.fetchDashboard();
        },
        methods: {
            change_company(row) {
                this.form.company_avaibale  =true,
                this.form.company_id    =row.company_id,
                this.form.company_name    =row.company_name,
                this.form.last_modified_by  =row.last_modified_by,
                this.form.last_modified_date=row.last_modified_date,
                this.form.post('/OpenFiles').then(({data}) => {
                    window.open('/Dashboard', '_self');
                })
            },
            fetchDashboard() {
                /*let uri = '/userDashboards';
                window.axios.get(uri).then((response) => {
                    
                });*/
            },
        }
    }
</script>