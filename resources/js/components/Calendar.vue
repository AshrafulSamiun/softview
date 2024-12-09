<template>
    <fieldset>
        <form id="msform" @submit.prevent="editmode ? updateCalenderEvent() : createCalendarEvent()" @keydown="form.onKeydown($event)">
            <h4 class="breadcumb"> Calendar</h4>
            <p class="breadcumb-p">Calendar</p>
            <div class="form-card" style="margin-bottom:30px">
                <div class="form-folder">
                    <div class="form-holder">
                        <div class="year-calendar">
                            <div class="year-header">
                                <button class="btn btn-primary" @click="prevYear">Previous Year</button>
                                <h2 >{{ form.current_year }}</h2>
                                <button class="btn btn-primary" @click="nextYear">Next Year</button>
                            </div>
                            <div class="months-container">
                                <div class="month" v-for="(month, index) in monthNames" :key="index">
                                    <h5 >{{ month }}</h5>
                                    <div class="days-header">
                                        <span v-for="day in dayNames" :key="day">{{ day }}</span>
                                    </div>
                                    <div class="days-grid">
                                        <div v-for="sinday in getDaysInMonth(index)"  class="day " @click="editCalendar(sinday.id)"
                                            :class="{ 'is-today': isToday(sinday.day,index), 'is-selected': isSelected(sinday.day,index),'is-selected': sinday.event}" :title="sinday.subject"> 
                                            {{ sinday.day}}
                                            <span v-if="sinday.event" class="tooltip">{{sinday.subject}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="months-container">
                                    <h5 >HolyDays</h5>
                            </div>
                        </div>
                    </div>
                </div>           
            </div>
            <div align="right" style="float:right">
                <button class="btn btn-primary" @click.prevent="addMenu()">Create New Event</button>
            </div> 
            <div class="form-card" style="margin-top:100px">
                <div class="form-folder">
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="fieldlabelText">Event No:</label> 
                                <input v-model="form.system_no" 
                                    type="text" 
                                    name="system_no" 
                                    placeholder="Auto Generated" 
                                    :class="{ 'is-invalid': form.errors.has('system_no') }" readonly/>

                                <label class="fieldlabelText">Time:</label> 
                                <div class="row">
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <vue-timepicker  v-model="form.start_time" format="hh:mm:ss" 
                                        :class="{ 'is-invalid': form.errors.has('start_time') }"
                                        :manual-input="true" :minute-interval="15" style="width:230px"/>
                                    </div>
                                    <div class="col-md-1 col-sm-6 col-xs-12" align="center">To</div>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <vue-timepicker  v-model="form.end_time" format="hh:mm:ss"
                                        :class="{ 'is-invalid': form.errors.has('end_time') }"
                                        :manual-input="true" :minute-interval="15" style="width:250px"/>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <label class="fieldlabelText">Date</label> 
                                <Vue3datepicker 
                                        v-model="form.event_date" 
                                        :format="dateformat" 
                                        :class="{ 'is-invalid': form.errors.has('end_date') }"/>
                                
                            </div>
                        </div>
                    </div>
                </div>           
            </div> 
            <div class="row align-self-stretch" style="margin-top:50px;">
                <div class="col-md-12 col-sm-6 col-xs-12" align="left">
                <label class="fieldlabelText">Priority(Select the priority):</label> 
                    <div class="btn-group" align="center">
                                            
                          <button class="btn risk-thred-level " 
                          @click="select_priority_level(1)"
                          type="button"
                          :class="{ 'btn-primary': form.priority_level==1,'normal': form.priority_level!=1 }">Normal</button>

                          <button class="btn risk-thred-level " 
                          @click="select_priority_level(2)"
                          type="button"
                          :class="{ 'btn-primary': form.priority_level==2 ,'normal': form.priority_level!=2}">Low</button>

                          <button class="btn risk-thred-level " 
                          @click="select_priority_level(3)"
                          type="button"
                          :class="{ 'btn-primary': form.priority_level==3,'normal': form.priority_level!=3 }">Medium</button>

                          <button class="btn risk-thred-level " 
                          @click="select_priority_level(4)"
                          type="button"
                          :class="{ 'btn-primary': form.priority_level==4,'normal': form.priority_level!=4 }">High</button>

                          <button class="btn risk-thred-level " 
                          @click="select_priority_level(5)"
                          type="button"
                          :class="{ 'btn-primary': form.priority_level==5 ,'normal': form.priority_level!=5}">Critical</button>
                    </div>
                </div>
            </div>
            <div class="form-card" style="margin-top:50px">
                <div class="form-folder">
                    <div class="form-holder">
                        <div class="row align-self-stretch">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="fieldlabelText">Site No:</label> 
                                <select v-model="form.job_site_id"
                                    name="job_site_id"
                                    @change="change_jobsite"
                                    class="custom-select"
                                    :class="{ 'is-invalid': form.errors.has('job_site_id') }">
                                    <option disabled value="">--Select Site-- </option>
                                     <option v-for="site in job_site_list" :value="site.id">{{site.site_name}}</option>
                                    
                                </select>
                                

                                <label class="fieldlabelText">Subject</label> 
                                <input v-model="form.subject" 
                                    type="text" 
                                    name="subject" 
                                    placeholder="Type Subject" 
                                    :class="{ 'is-invalid': form.errors.has('subject') }"/>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <label class="fieldlabelText">Created By</label> 
                                <input v-model="form.inserted_by" 
                                    type="text" 
                                    name="inserted_by" 
                                    placeholder="User Id-Name" 
                                    :class="{ 'is-invalid': form.errors.has('inserted_by') }" readonly/>
                                <label class="fieldlabelText">Deadline:</label> 
                                <div class="input-group">
                                   
                                    <Vue3datepicker v-model="form.deadline" :format="dateformat" />
                            
                                   
                                 </div>       
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <label class="fieldlabelText">Message:</label>
                                <textarea 
                                    v-model="form.message"
                                        style="height:80px;"
                                        id="message" 
                                        name="message" 
                                        rows="12" 
                                        cols="1000"
                                        placeholder="Type Message" 
                                    :class="{ 'is-invalid': form.errors.has('message') }">
                                </textarea>

                                <label class="fieldlabelText">Required Action:</label>
                                <textarea 
                                    v-model="form.required_action"
                                        style="height:80px;"
                                        id="required_action" 
                                        name="required_action" 
                                        rows="12" 
                                        cols="1000"
                                        placeholder="Type Required Action" 
                                    :class="{ 'is-invalid': form.errors.has('required_action') }">
                                </textarea>

                                <label class="fieldlabelText">Comments:</label>
                                <textarea 
                                    v-model="form.comments"
                                        style="height:80px;"
                                        id="comments" 
                                        name="comments" 
                                        rows="12" 
                                        cols="1000"
                                        placeholder="Type Comments" 
                                    :class="{ 'is-invalid': form.errors.has('comments') }">
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>           
            </div> 
            <div class="row align-self-stretch" style="margin:50px 0;">
                <div class="col-md-5 col-sm-6 col-xs-12">
                    <div class="form-card">
                        <h4>Recurring Cycle</h4>
                        <div class="row align-self-stretch">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                 <label class="fieldlabelText">Repeat:</label> 
                            </div>
                            <div class="col-md-9 col-sm-6 col-xs-12">
                                 <select v-model="form.recurring_cycle"
                                    name="recurring_cycle"
                                    class="custom-select"
                                    :class="{ 'is-invalid': form.errors.has('recurring_cycle') }">
                                    <option disabled value="">--Select -- </option>
                                    <option v-for="(cycle,ind) in recurring_cycle_arr" :value="ind">{{cycle}}</option>
                                    
                                </select> 
                            </div>
                        </div>
                        <div class="row align-self-stretch">
                            <div class="col-md-3 col-sm-6 col-xs-12" >
                                 <label class="fieldlabelText">Repeat Every:</label> 
                            </div>
                            <div class="col-md-9 col-sm-6 col-xs-12" align="left">
                                 
                                <input v-model="form.repeat_every" 
                                    type="number" 
                                    name="repeat_every" 
                                    style="width:100px; text-align:left"
                                    placeholder="" 
                                    :class="{ 'is-invalid': form.errors.has('repeat_every') }" />
                                {{recurring_cycle_arr[form.recurring_cycle]}}
                            </div>
                        </div>
                        <div class="row align-self-stretch">
                            <div class="col-md-3 col-sm-6 col-xs-12" >
                                 <label class="fieldlabelText">Repeat On:</label> 
                            </div>
                            <div class="col-md-9 col-sm-6 col-xs-12" align="left">
                                 
                                <div class="form-check-inline" style="">
                                               
                                    <input type="checkbox" 
                                        id="monday_repeat" 
                                        name="monday_repeat"
                                        @click="check_repeat_day($event,1)" 
                                        v-model="form.monday_repeat">
                                    <label class="repetation_day" for="monday_repeat">Mon</label>

                                    <input type="checkbox" 
                                        id="tuesday_repeat" 
                                        name="tuesday_repeat" 
                                        @click="check_repeat_day($event,2)"
                                        v-model="form.tuesday_repeat">
                                    <label class="repetation_day" for="tuesday_repeat">Tue</label>

                                    <input type="checkbox" 
                                        id="wednesday_repeat" 
                                        name="wednesday_repeat" 
                                        @click="check_repeat_day($event,3)"
                                        v-model="form.wednesday_repeat">
                                    <label class="repetation_day" for="wednesday_repeat">Wed</label>

                                    <input type="checkbox" 
                                        id="thrusday_repeat" 
                                        name="thrusday_repeat" 
                                        @click="check_repeat_day($event,4)"
                                        v-model="form.thrusday_repeat">
                                    <label class="repetation_day" for="thrusday_repeat">Thu</label>

                                    <input type="checkbox" 
                                        id="Friday_repeat" 
                                        name="Friday_repeat" 
                                        @click="check_repeat_day($event,5)"
                                        v-model="form.friday_repeat">
                                    <label class="repetation_day" for="Friday_repeat">Fri</label>

                                    <input type="checkbox" 
                                        id="saturday_repeat" 
                                        name="saturday_repeat" 
                                        @click="check_repeat_day($event,6)"
                                        v-model="form.saturday_repeat">
                                    <label class="repetation_day" for="saturday_repeat">Sat</label>

                                    <input type="checkbox" 
                                        id="sunday_repeat" 
                                        name="sunday_repeat" 
                                        @click="check_repeat_day($event,7)"
                                        v-model="form.sunday_repeat">
                                    <label class="repetation_day" for="sunday_repeat">Sun</label>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="row align-self-stretch">
                            <div class="col-md-3 col-sm-6 col-xs-12" >
                                 <label class="fieldlabelText">Start On:</label> 
                            </div>
                            <div class="col-md-9 col-sm-6 col-xs-12" align="left">
                                 
                                <Vue3datepicker v-model="form.start_date" :format="dateformat" />
                                
                            </div>
                        </div>
                        <div class="row align-self-stretch">
                            <div class="col-md-3 col-sm-6 col-xs-12" >
                                 <label class="fieldlabelText">Ends:</label> 
                            </div>
                            <div class="col-md-9 col-sm-6 col-xs-12" align="left">
                                 <div class="form-check-inline" style="display:flex">
                                    <input type="radio" 
                                        id="never_end" 
                                        name="never_end"
                                        v-model="form.never_end">
                                    <label class="repetation_day" for="never_end">Never</label> 
                                </div>
                            </div>
                        </div>
                        <div class="row align-self-stretch">
                            <div class="col-md-3 col-sm-6 col-xs-12" >
                                
                            </div>
                            <div class="col-md-9 col-sm-6 col-xs-12" align="left">
                                 <div class="form-check-inline" style="display:flex">
                                    <input type="radio" 
                                        id="repeat_end_after" 
                                        name="repeat_end_after"
                                        v-model="form.repeat_end_after">
                                    <label class="repetation_day" for="repeat_end_after">After</label> 

                                    <input v-model="form.occerance_number" 
                                    type="number" 
                                    style="width:100px"
                                    name="occerance_number" 
                                    :class="{ 'is-invalid': form.errors.has('occerance_number') }"/>
                                    <label  class="fieldlabelText">Occurences</label> 
                                </div>
                            </div>
                        </div>
                        <div class="row align-self-stretch">
                            <div class="col-md-3 col-sm-6 col-xs-12" >
                                
                            </div>
                            <div class="col-md-9 col-sm-6 col-xs-12" align="left">
                                 <div class="form-check-inline" style="display:flex">
                                    <input type="radio" 
                                        id="end_on" 
                                        name="end_on"
                                        v-model="form.end_on">
                                    <label class="repetation_day" for="end_on">On</label> 
                                    <Vue3datepicker 
                                        v-model="form.deadline" 
                                        :format="dateformat" 
                                        :class="{ 'is-invalid': form.errors.has('end_date') }"/>
                                </div>
                            </div>
                        </div>
                        <div class="row align-self-stretch">
                            <div class="col-md-3 col-sm-6 col-xs-12" >
                                 <label class="fieldlabelText">Summery:</label> 
                            </div>
                            <div class="col-md-9 col-sm-6 col-xs-12" align="left">
                                <label class="fieldlabelText">{{recurring_cycle_arr[form.recurring_cycle]}} </label> 
                                <label class="fieldlabelText" v-if="form.repeat_no_date">On  {{form.repeat_no_date}}</label> 
                                 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-sm-6 col-xs-12">
                    <div class="form-card">
                        <table class="table">
                            <thead>
                                <tr>
                                      <th scope="col">Reminder</th>
                                      <th scope="col">Date</th>
                                      <th scope="col">Time</th>
                                      <th scope="col">Email</th>
                                      <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="reminder in form.reminder_details_arr">
                                    <td scope="row">Reminder-{{reminder.reminder_no}}</td>
                                    <td>
                                        <select v-model="reminder.reminder_period"
                                            name="job_site_id"
                                            class="custom-select">
                                            <option disabled value="">--Select Site-- </option>
                                             <option v-for="(re_date,index) in reminder_arr" :value="index">{{re_date}}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <vue-timepicker  v-model="reminder.time" format="hh:mm:ss" :manual-input="true" :minute-interval="15" style="width:100px"/>
                                    </td>
                                    <td>
                                        <input v-model="reminder.email" 
                                            type="text" 
                                            name="subject" 
                                            placeholder="Type Email" 
                                            :class="{ 'is-invalid': form.errors.has('email') }"/>
                                    </td>
                                    <td>
                                        <input v-model="reminder.description" 
                                            type="text" 
                                            name="subject" 
                                            placeholder="Type Description" 
                                            :class="{ 'is-invalid': form.errors.has('description') }"/>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-center" v-if="!list_showable">
                <button :disabled="form.busy || editmode==false"  type="button" class="btn  btn-primary" style="min-width:110px" @click="reset_form()">New </button>
              
                <button :disabled="form.busy || editmode==true || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="save_stay(1)">Save</button>
               
                <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="submit" class="btn  btn-primary" style="min-width:110px" >Update</button>
                <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click.prevent="deleteTax()">Delete</button>
                <button :disabled="form.busy || editmode==false || form.posting_status==1"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()" v-if="user_type==9">Reject </button>
                <button :disabled="form.busy || editmode==false || form.posting_status>1"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()" v-if="user_type==9">Post </button>
                <button :disabled="form.busy || editmode==false || form.posting_status!=0"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="post()" v-else>Post</button>

                <button :disabled="form.busy || form.posting_status<2 || user_type!=9"  type="button" class="btn  btn-primary" style="min-width:110px"  @click="adjust()">Adjust</button>

                <button :disabled="form.busy || form.posting_status!=3 || user_type!=9"  type="button" class="btn  btn-primary" style="min-width:110px" @click="repost()">Repost</button>
                <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode" @click="show_pdf()">Preview</button>
                <button :disabled="form.busy"  type="button" class="btn  btn-primary" style="min-width:110px" v-show="editmode">Print</button>
            </div>
        </form>
    </fieldset>
</template>

<script>

    import VueTimepicker from 'vue3-timepicker';
    import 'vue3-timepicker/dist/VueTimepicker.css';
    import Vue3datepicker from "vue3-datepicker";
    import { ref } from 'vue';
   
    export default {
        components:{
            Vue3datepicker,
            VueTimepicker
        },
        data() {
            return {
                editmode:false,
                list_showable:false,
                filter: '',
                dateformat: "DD-MM-YYYY", // Ensure valid format
                form:new Form({                    
                    system_no:'',
                    system_prefix:'',
                    event_date:null,
                    start_time:'',
                    end_time:'',                  
                    priority_level:0,
                    job_site_id:'',
                    company_id:'',
                    company_type:'',
                    subject:'',
                    message:'',
                    required_action:'',
                    comments:'',
                    deadline:null,
                    deadline_time:'',
                    recurring_cycle:'',
                    repeat_every:'',
                    start_date:'',
                    repeat_no_date:'',
                    repeat_no_date_id:'',
                    monday_repeat:'',
                    tuesday_repeat:'',
                    wednesday_repeat:'',
                    thrusday_repeat:'',
                    friday_repeat:'',
                    saturday_repeat:'',
                    sunday_repeat:'',
                    never_end:'',
                    repeat_end_after:'',
                    occerance_number:'',
                    end_on:'',
                    end_date:'',
                    id:'',
                    posting_status:0,
                    page_id:20,
                    
                    reminder_details_arr:[],
                    current_year: new Date().getFullYear(),
                }),
              
              dayNames: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
              monthNames: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
              ],
              selectedDate: null,
              job_site_list:[],
              recurring_cycle_arr:[],
              reminder_arr:[],
              calendar_list:[],
              user_type:0,
              
            };
        },
        created: function()
        {
            this.user_menu_name = this.$route.name;
            this.fetchCalendar();
        },
        methods: {
            change_jobsite()
            {
                this.form.company_id=this.job_site_list[this.form.job_site_id].company_id;
                this.form.company_type=this.job_site_list[this.form.job_site_id].company_type;
            },
            fetchCalendar()
            {
                let uri = '/CalendarList/'+this.form.current_year;
                window.axios.get(uri).then((response) => {
                    this.user_type                  =response.data.user_type;
                    this.job_site_list              =response.data.job_site_list;
                    this.recurring_cycle_arr        =response.data.recurring_cycle_arr;
                    this.reminder_arr               =response.data.reminder_arr;
                    this.form.reminder_details_arr  =response.data.reminder_details_arr;
                    this.calendar_list              =response.data.calendar_list;
                });                 
            },
            select_priority_level(type)
            {
                this.form.priority_level=type;
            },
            check_repeat_day(e,type)
            {
                if(e.target.checked)
                {
                    this.form.repeat_no_date_id=type;
                    if(type==1)
                    {
                        this.form.repeat_no_date="Monday";
                        this.form.monday_repeat=true;
                        this.form.tuesday_repeat=false;
                        this.form.wednesday_repeat=false;
                        this.form.thrusday_repeat=false;
                        this.form.friday_repeat=false;
                        this.form.saturday_repeat=false;
                        this.form.sunday_repeat=false;

                    }
                    else if(type==2)
                    {
                       this.form.repeat_no_date="Tuesday";
                       this.form.monday_repeat=false;
                        this.form.tuesday_repeat=true;
                        this.form.wednesday_repeat=false;
                        this.form.thrusday_repeat=false;
                        this.form.friday_repeat=false;
                        this.form.saturday_repeat=false;
                        this.form.sunday_repeat=false;
                    }
                    else if(type==3)
                    {
                       this.form.repeat_no_date="Wednesday";
                       this.form.monday_repeat=false;
                        this.form.tuesday_repeat=false;
                        this.form.wednesday_repeat=true;
                        this.form.thrusday_repeat=false;
                        this.form.friday_repeat=false;
                        this.form.saturday_repeat=false;
                        this.form.sunday_repeat=false;
                    }
                    else if(type==4)
                    {
                       this.form.repeat_no_date="Thrusday";
                       this.form.monday_repeat=false;
                        this.form.tuesday_repeat=false;
                        this.form.wednesday_repeat=false;
                        this.form.thrusday_repeat=true;
                        this.form.friday_repeat=false;
                        this.form.saturday_repeat=false;
                        this.form.sunday_repeat=false;
                    }
                    else if(type==5)
                    {
                       this.form.repeat_no_date="Friday";
                       this.form.monday_repeat=false;
                        this.form.tuesday_repeat=false;
                        this.form.wednesday_repeat=false;
                        this.form.thrusday_repeat=false;
                        this.form.friday_repeat=true;
                        this.form.saturday_repeat=false;
                        this.form.sunday_repeat=false;
                    }
                    else if(type==6)
                    {
                       this.form.repeat_no_date="Saturday";
                       this.form.monday_repeat=false;
                        this.form.tuesday_repeat=false;
                        this.form.wednesday_repeat=false;
                        this.form.thrusday_repeat=false;
                        this.form.friday_repeat=false;
                        this.form.saturday_repeat=true;
                        this.form.sunday_repeat=false;
                    }
                    else if(type==7)
                    {
                       this.form.repeat_no_date="Sunday";
                       this.form.monday_repeat=false;
                        this.form.tuesday_repeat=false;
                        this.form.wednesday_repeat=false;
                        this.form.thrusday_repeat=false;
                        this.form.friday_repeat=false;
                        this.form.saturday_repeat=false;
                        this.form.sunday_repeat=true;
                    }
                }
                else{
                    this.form.repeat_no_date="";
                    this.form.repeat_no_date_id="";
                    this.form.monday_repeat=false;
                    this.form.tuesday_repeat=false;
                    this.form.wednesday_repeat=false;
                    this.form.thrusday_repeat=false;
                    this.form.friday_repeat=false;
                    this.form.saturday_repeat=false;
                    this.form.sunday_repeat=false;
                } 
            },
            getDaysInMonth(month) {
                const days = [];
                const date = new Date(this.form.current_year, month, 1);
                const firstDay = date.getDay(); // Get the first day of the month
                const lastDate = new Date(this.form.current_year, month + 1, 0).getDate(); // Get the last date of the month

                // Fill in the blank days for the first week
                for (let i = 0; i < firstDay; i++) {
                    
                    days.push({
                        'id':'',
                        'day':'',
                        'job_site_id':'',
                        'subject':'',
                        'calendar_date':'',
                        'event':false,
                    });
                }

                // Fill in the actual days of the month
                for (let day = 1; day <= lastDate; day++) {
                    //days.push(day);

                    if(month in this.calendar_list== true)
                    {
                        if(day in this.calendar_list[month]== true)
                        {
                            days.push({
                                'id':this.calendar_list[month][day].id,
                                'day':day,
                                'job_site_id':this.calendar_list[month][day].job_site_id,
                                'subject':this.calendar_list[month][day].subject,
                                'calendar_date':this.calendar_list[month][day].calendar_date,
                                'event':true,
                               
                            });
                        }
                        else
                        {
                            days.push({
                                'id':'',
                                'day':day,
                                'job_site_id':'',
                                'subject':'',
                                'calendar_date':'',
                                'event':false,
                            });
                        }
                    }
                    else
                    {
                        days.push({
                            'id':'',
                            'day':day,
                            'job_site_id':'',
                            'subject':'',
                            'calendar_date':'',
                            'event':false,
                        });
                    }
                }

                return days;
            },
            prevYear() {
                this.form.current_year--;
            },
            nextYear() {
                this.form.current_year++;
            },

            selectDate(day,currentMonth) {
                this.selectedDate = new Date(this.form.current_year, currentMonth, day);
            },
            isToday(day,currentMonth) {
                const today = new Date();
                return (
                    today.getDate() === day &&
                    today.getMonth() === currentMonth &&
                    today.getFullYear() === this.form.current_year
                );
            },
            isSelected(day,currentMonth) {
                return (
                    this.selectedDate &&
                    this.selectedDate.getDate() === day &&
                    this.selectedDate.getMonth() === currentMonth &&
                    this.selectedDate.getFullYear() === this.form.current_year
                );
            },

            reset_form()
            {
                this.form.reset();
                this.editmode=false;
                this.fetchCalendar();
            },
            reset_list()
            {
                this.form.reset();
                this.editmode=false;
                let uri = '/CalendarList';
                window.axios.get(uri).then((response) => {
                    this.rows = response.data.job_site_list;
                });
                this.list_showable=true;
            },

            editCalendar(id)
            {
               if(!id) return false;
                this.form.reset ();
                this.list_showable=false;
                let uri = '/Calendars/'+id+'/edit';
                window.axios.get(uri).then((response) => {

                    this.editmode=true;
                    this.user_type                             =response.data.user_type;
                    this.job_site_list                         =response.data.job_site_list;
                    this.recurring_cycle_arr                   =response.data.recurring_cycle_arr;
                    this.reminder_arr                          =response.data.reminder_arr;
                    this.form.reminder_details_arr             =response.data.reminder_details_arr;
                    this.calendar_list                         =response.data.calendar_list;               
                   
                    this.form.id                                =response.data.calender_data_arr.id;
                    this.form.posting_status                    =response.data.calender_data_arr.posting_status;
                    this.form.system_no                         =response.data.calender_data_arr.system_no;
                    this.form.system_prefix                     =response.data.calender_data_arr.system_prefix;
                    this.form.event_date                        =new Date(response.data.calender_data_arr.event_date);
                    
                    this.form.start_time                        =response.data.calender_data_arr.start_time;
                    this.form.end_time                          =response.data.calender_data_arr.end_time;
                    this.form.company_type                      =response.data.calender_data_arr.company_type;
                    this.form.company_id                        =response.data.calender_data_arr.company_id;
                    this.form.current_year                      =response.data.calender_data_arr.current_year;
                    this.form.priority_level                    =response.data.calender_data_arr.priority_level;
                    this.form.job_site_id                       =response.data.calender_data_arr.job_site_id;
                    this.form.subject                           =response.data.calender_data_arr.subject;
                    this.form.message                           =response.data.calender_data_arr.message;
                    this.form.required_action                   =response.data.calender_data_arr.required_action;
                    if(response.data.calender_data_arr.deadline)
                        this.form.deadline                      =new Date(response.data.calender_data_arr.deadline);
                    else
                        this.form.deadline                      =response.data.calender_data_arr.deadline;
                    this.form.deadline_time                     =response.data.calender_data_arr.deadline_time;
                    this.form.recurring_cycle                   =response.data.calender_data_arr.recurring_cycle;
                    this.form.repeat_every                      =response.data.calender_data_arr.repeat_every;
                    this.form.start_date                        =response.data.calender_data_arr.start_date;
                    this.form.repeat_no_date_id                 =response.data.calender_data_arr.repeat_no_date_id;
                    this.form.never_end                         =response.data.calender_data_arr.never_end;
                    this.form.comments                          =response.data.calender_data_arr.comments;
                    this.form.repeat_end_after                  =response.data.calender_data_arr.repeat_end_after;
                    this.form.occerance_number                  =response.data.calender_data_arr.occerance_number;
                    this.form.end_on                            =response.data.calender_data_arr.end_on;
                    if(response.data.calender_data_arr.end_date)
                        this.form.end_date                          =new Date(response.data.calender_data_arr.end_date);
                    else
                        this.form.end_date                          =response.data.calender_data_arr.end_date;
                   
                }); 
            },

            post()
            { 
                if(this.user_type==9) this.form.posting_status=2;
                else this.form.posting_status=1;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Post it!'
                }).then((result) => {

                    this.form.post('/CalendarPost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            showAlert(
                                'Posted!',
                                'Your Data has been Posted.',
                                'success'
                            );

                            this.editCalendar(response_data[1]);
                    
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
                    this.form.post('/CalendarRepost/'+this.form.id).then((response)=>{
                        
                        var response_data=response.data.split("**");
                        if(response_data[0]==1)
                        { 
                            showAlert(
                                'Posted!',
                                'Your Data has been Reposted.',
                                'success'
                            );
                            
                            this.editCalendar(response_data[1]);
                        }            

                    }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                    });
                    
                })
                
            },

            adjust()
            { 
                
                this.form.post('/adjustCalendar/'+this.form.id).then((response)=>{
                    var response_data=response.data.split("**");
                    if(response_data[0]==1)
                    {
                        showToast('Data Update Successfully', 'success');
                        
                        this.editCalendar(response_data[1]);
                        
                        this.editmode=true;
                    }
                    else{

                        showToast("there was some wrong","warning");
                    }
                }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                    });               
                
            },                        

            CalendarDelete(id)
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
                    this.form.delete('/Calendars/'+id).then(()=>{
                        
                        if(result.value) {
                            showAlert(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.reset_list();
                        }            

                    }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                    });
               
                })
            },

            deleteCalendar()
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
                    this.form.delete('/Calendars/'+this.form.id).then(()=>{
                        
                        if(result.value) {
                            showAlert(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            );
                            this.form.reset();
                            this.fetchCalendar();
                        }            

                    }).catch(()=>{
                        showAlert("failed!","there was some wrong","warning");
                    });
               
                })
            },
            updateCalenderEvent()
            { 
                
                this.form.put('/Calendars/'+this.form.id).then(({ data })=>{
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         showToast('Data Update Successfully', 'success');
                        
                        this.editCalendar(response_data[1]);
                        this.editmode=true;
                        
                    }
                    else{

                        showToast("there was some wrong","warning");
                    }
                });
            },
            save_stay(type){                

                this.form.post('/Calendars') .then(({ data }) => { 
                    var response_data=data.split("**");
                    if(response_data[0]==1)
                    {
                         showToast('Data Update Successfully', 'success');

                        if(type==1)
                        {
                            this.editCalendar(response_data[1]);
                            this.editmode=true;
                        }
                        else if(type==2)
                        {
                             window.location.href = '/Dashboard';
                        }
                        else if(type==3)
                        {
                            this.form.reset();
                            this.fetchCalendar();
                        }
                    }
                    else{

                        showToast("there was some wrong","warning");
                    }                    
                })
            }, 
            
        },

      
    };
</script>

<style>


    .tooltip {
      position: absulute;
      cursor: pointer;
       z-index: 10;
    }

.tooltipsss {
  content: attr(title);
  position: absolute;
  background-color: #333;
  color: #fff;
  padding: 5px;
  border-radius: 5px;
  white-space: nowrap;
  bottom: 125%; /* Position the tooltip above the element */
  left: 50%;
  transform: translateX(-50%);
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s;
 
}

.tooltip:hover{
  opacity: 1;
  visibility: visible;
  bottom: 125%; /* Position the tooltip above the element */
  left: 50%;
  background-color: #333;
}

    table thead tr th {
        background-color: rgba(8, 102, 255, 1);
        color:#fff !important;
        margin-bottom:30px;
        
    }
    .fieldlabelText{
        //font-family: Inter;
        font-size: 14px;
        font-weight: 600;
        line-height: 18px;
        text-align: left;
        color:rgba(0,0,0,.6)

    }
    .repetation_day{
        padding-right:15px !important;
        //font-family: Inter;
        font-size: 14px;
        font-weight: 600;
        line-height: 18px;
        text-align: left;
        color:rgba(0,0,0,.6)
    }
    .year-calendar {
        max-width: 1600px;
        margin: auto;
        text-align: center;
    }
    .year-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .year-header
    year-header h2 {
        
        font-family: Inter;
        font-size: 20px;
        font-weight: 900;
        line-height: 18px;
        text-align: center;

    }
    .months-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }
    .month {
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 8px;
     

    }
    .month h5 {
        //font-family: Oxygen;
        font-size: 18px;
        font-weight: 700;
        line-height: 22.73px;
        text-align: center;
    }
    .days-header {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        background-color: #f4f4f4;
        padding: 2px 0;
        //font-family: Inter;
        font-size: 14px;
        font-weight: 400;
        line-height: 28px;
        text-align: center;

    }
    .days-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 3px;
        padding: 5px 0;
    }
    .day {
        padding: 5px;
        background-color: #f9f9f9;
        border-radius: 4px;
        cursor: pointer;
        //font-family: inter;
        font-size: 13px;
        font-weight: 500;
        line-height: 12.73px;
        color: rgba(0, 0, 0, .8);

    }
    .day.is-today {
        background-color: #d4edda;
    }
    .day.is-selected {
        background-color: #80c690;
        font-weight: bold;
    }
</style>
