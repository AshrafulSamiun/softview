<template>

	<section class="app-main__inner">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card">
                <form id="msform">  
                    <fieldset>
                        <div class="form-card">
                            <h1 class="page-head">New Posting Job</h1> 
                            <div class="form-folder">
                                <h3><i class="fa fa-hand-point-right"></i> Posting General Info:</h3>
                                <div class="form-holder">
                                    <div class="row align-self-stretch"> 
                                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-6 col-xs-12"> 
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <h4>Account No</h4>
                                                            <input type="text" id="account_no" name="account_no"  v-model="form.account_no" placeholder="Account No" disabled/> 
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <h4>Class</h4> 
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="posting_class" name="posting_class" v-model="form.posting_class" class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="New">New</option>
                                                                        <option value="">Renew </option>
                                                                        <option value="">last Edited </option>
                                                                        <option value="">Reactivation</option> 
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-12"> 
                                                                <h4>Post By</h4>
                                                                <label class="fieldlabels">Name:</label> 
                                                                <input type="text" id="post_name" name="post_name" v-model="form.post_name"  placeholder="Type  Name" disabled/> 
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-12"> 
                                                                <h4>&nbsp;</h4>
                                                                <label class="fieldlabels">User ID No:</label> 
                                                                <input type="text"  id="post_user_id" name="post_user_id" v-model="form.post_user_id"  placeholder="Type User ID No" disabled/>
                                                            </div> 
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-12">   
                                                                <label class="fieldlabels">User Type:</label> 
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="posting_user_type" name="posting_user_type" v-model="form.posting_user_type" class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="">Customer</option>
                                                                        <option value="">Employees</option>
                                                                        <option value="">Board Of Directors</option>
                                                                        <option value="">Investors</option> 
                                                                        <option value="">Landlord</option> 
                                                                        <option value="">Seller</option> 
                                                                        <option value="">Service Provider</option> 
                                                                        <option value="">Shareholder</option> 
                                                                        <option value="">Tenant</option> 
                                                                        <option value="">Visitor</option> 
                                                                    </select>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">  
                                                                <label class="fieldlabels">Status:</label> 
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="posting_status" name="posting_status" name="posting_user_type" v-model="form.posting_status" class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="">Pending</option>
                                                                        <option value="">Published</option>
                                                                        <option value="">Removed</option>
                                                                        <option value="">Expired</option> 
                                                                        <option value="">Reported</option> 
                                                                        <option value="">Deactivated</option>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <h4>Date and Time</h4> 
                                                                <label class="fieldlabels">Creating :</label> 
                                                                <input type="date" id="creating_date" name="creating_date" v-model="form.creating_date" placeholder="Enter Date"/> 
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <h4>&nbsp;</h4> 
                                                                <label class="fieldlabels">Approved:</label> 
                                                                <input type="date" id="approved_date" name="approved_date" v-model="form.approved_date" placeholder="Enter Date"/> 
                                                            </div> 
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-12"> 
                                                                <label class="fieldlabels">Validation Period:</label> 
                                                                <input type="date" id="validation_period_date" name="validation_period_date" v-model="form.validation_period_date" placeholder="Enter Date"/> 
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-12"> 
                                                                <label class="fieldlabels">Expiration:</label> 
                                                                <input type="date" id="expiration_date" name="expiration_date" v-model="form.expiration_date" placeholder="Enter Date"/> 
                                                            </div> 
                                                        </div>
                                                          
                                                    </div> 
                                                </div> 
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer">
                                                <h4>About Employer</h4>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                                            <label class="fieldlabels">Employer No :</label> 
                                                            <input type="text" id="employer_number" name="employer_number" v-model="form.employer_number" placeholder="Type Employer No"/> 
                                                            <label class="fieldlabels">Company Name :</label> 
                                                            <input type="text" id="employer_companay_name" name="employer_companay_name" v-model="form.employer_companay_name" placeholder="Type Company Name"/> 
                                                         
                                                            <label class="fieldlabels">Full Legal Name :</label> 
                                                            <input type="text" id="full_legal_name" name="full_legal_name" v-model="form.full_legal_name" placeholder="Type Full Legal Name"/>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 col-xs-12"> 
                                                            <label class="fieldlabels">Address :</label> 
                                                            <input type="text" id="company_address" name="company_address" v-model="form.company_address" placeholder="Type Address"/> 
                                                        
                                                            <label class="fieldlabels">Website :</label> 
                                                            <input type="text" id="company_website" name="company_website" v-model="form.company_website" placeholder="Type Website"/> 
                                                         
                                                            <label class="fieldlabels">Contacts :</label> 
                                                            <input type="text" id="company_contacts" name="company_contacts" v-model="form.company_contacts" placeholder="Type Contacts"/> 
                                                        </div> 
                                                        <div class="col-md-12 col-sm-12 col-xs-12"> 
                                                            <label class="fieldlabels">About us  :</label> 
                                                            <input type="text" id="company_about_us" name="company_about_us" v-model="form.company_about_us" placeholder="Type About us"/>  
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="form-card"> 
                            <div class="form-folder">
                                <h3><i class="fa fa-hand-point-right"></i> Posting Details :</h3>
                                <div class="form-holder">
                                    <div class="row align-self-stretch"> 
                                        <div class="col-md-12 col-sm-6 col-xs-12"> 
                                            <div class="form-box-outer">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12"> 
                                                        <h4>Posting Title </h4>
                                                        <input type="text" id="posting_title" name="posting_title" v-model="form.posting_title" placeholder="Posting Title"/>  
                                                        <h4>Job Details</h4>
                                                        <label class="fieldlabels">Job Title :</label> 
                                                        <input type="text" id="job_title" name="job_title" v-model="form.job_title"  placeholder="Type Job Title"/>
                                                        <div class="row">  
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Employment/ Self Employed:</label> 
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="Employment_self_employed" name="Employment_self_employed" v-model="form.Employment_self_employed" class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="">yes</option>
                                                                        <option value="">No</option> 
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Full/ Part time :</label>  
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="full_part_time" name="full_part_time" v-model="form.full_part_time" class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="">Full time</option>
                                                                        <option value="">Part time</option> 
                                                                    </select>
                                                                </div>
                                                            </div>  
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Hourly rate:</label> 
                                                                <input type="text" id="hourly_rate" name="hourly_rate" v-model="form.hourly_rate"  placeholder="Enter Hourly rate"/> 
                                                            </div>  
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Monthly Salary:</label> 
                                                                <input type="text" id="monthly_salary" name="monthly_salary" v-model="form.monthly_salary" placeholder="Enter Monthly Salary"/>  
                                                            </div> 
                                                        </div> 

                                                        <div class="row">  
                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Benefits  :</label> 
                                                                <input type="text" id="posting_benefits" name="posting_benefits"  v-model="form.posting_benefits" placeholder="Type Benefits"/> 
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Job Description :</label> 
                                                                <input type="text" id="job_description" name="job_description"  v-model="form.job_description" placeholder="Type Job Description"/> 
                                                            </div> 
                                                        </div> 
                                                        <div class="row">   
                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Responsibilities:</label> 
                                                                <input type="text" id="posting_responsibilities" name="posting_responsibilities" v-model="form.posting_responsibilities" placeholder="Type Responsibilities"/> 
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Education Level :</label> 
                                                                <input type="text" id="education_lavel" name="education_lavel" v-model="form.education_lavel" placeholder="Type Education Level"/> 
                                                            </div>  
                                                        </div> 
                                                        <div class="row"> 
                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Skills :</label> 
                                                                <input type="text" id="posting_skills" name="posting_skills" v-model="form.posting_skills" placeholder="Type Skills"/> 
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Job Experience :</label>  
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="job_experience" name="job_experience" v-model="form.job_experience" class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="">One Year</option>
                                                                        <option value="">Two Year</option>
                                                                        <option value="">Three Year</option>
                                                                        <option value="">Four Year</option> 
                                                                        <option value="">Five Year</option> 
                                                                        <option value="">Six Year</option>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            
                                                        </div>  
                                                        <div class="row">  
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Permit/ License :</label> 
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="permit_license" name="permit_license" v-model="form.permit_license" class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="">YES</option>
                                                                        <option value="">No</option> 
                                                                    </select>
                                                                </div> 
                                                            </div> 
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Work Location :</label> 
                                                                <input type="text" id="work_location" name="work_location" v-model="form.work_location" placeholder="Type Work Location"/> 
                                                            </div> 
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Days/ Hours :</label>  
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="days_hours" name="days_hours" v-model="form.days_hours" class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="">30 Days</option>
                                                                        <option value="">60 Days</option> 
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Overtime Allowed  :</label> 
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="overtime_allowed" name="overtime_allowed" v-model="form.overtime_allowed" class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="">YES</option>
                                                                        <option value="">No</option> 
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                        </div> 
                                                        <div class="row">  
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Probation Period :</label>  
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="probation_period" name="probation_period" v-model="form.probation_period" class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="">One month</option>
                                                                        <option value="">Two month</option>
                                                                        <option value="">Three month</option>
                                                                        <option value="">Four month</option>
                                                                        <option value="">Five month</option>
                                                                        <option value="">Six month</option>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Bondable :</label> 
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="posting_bondable" name="posting_bondable" v-model="form.posting_bondable"  class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="">YES</option>
                                                                        <option value="">No </option> 
                                                                    </select>
                                                                </div>  
                                                            </div> 
                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Contract requited :</label> 
                                                                <div class="position-relative form-group">
                                                                    <select type="select" id="contract_requited" name="contract_requited" v-model="form.contract_requited" class="custom-select">
                                                                        <option value="">Select</option>
                                                                        <option value="">YES</option>
                                                                        <option value="">No </option> 
                                                                    </select>
                                                                </div> 
                                                            </div>  
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                <div class="form-box-outer">
                                                                    <h4>Mandatory Screening:</h4>
                                                                    <div class="form-holder">
                                                                        <div class="form-check-inline">
                                                                            <input type="checkbox" id="medical_test" name="medical_test" v-model="form.medical_test" >
                                                                            <label for="mandatory_screening1">Medical Test</label><br>
                                                                            <input type="checkbox" id="drug" name="drug" v-model="form.drug">
                                                                            <label for="mandatory_screening2">Drug</label><br>
                                                                            <input type="checkbox" id="criminal_check" name="criminal_check" v-model="form.criminal_check">
                                                                            <label for="mandatory_screening3">Criminal Check</label><br> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                <div class="form-box-outer">
                                                                    <h4>References:</h4>
                                                                    <div class="form-holder">
                                                                        <div class="form-check-inline">
                                                                            <input type="checkbox" id="personal" name="personal" v-model="form.personal">
                                                                            <label for="references1">Personal</label><br>
                                                                            <input type="checkbox" id="work" name="work" v-model="form.work">
                                                                            <label for="references2">Work</label><br>
                                                                            <input type="checkbox" id="school" name="school" v-model="form.school">
                                                                            <label for="references3">School</label><br>
                                                                            <input type="checkbox" id="living_area" name="living_area" v-model="form.living_area">
                                                                            <label for="references4">Living Area</label><br> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                                <div class="form-box-outer">
                                                                    <h4>Interview Method:</h4>
                                                                    <div class="form-holder">
                                                                        <div class="form-check-inline">
                                                                            <input type="checkbox" id="online" name="online" v-model="form.online">
                                                                            <label for="interview_method1">Online</label><br>
                                                                            <input type="checkbox" id="phone" name="phone" v-model="form.phone">
                                                                            <label for="interview_method2">Phone</label><br>
                                                                            <input type="checkbox" id="in_person" name="in_person" v-model="form.in_person">
                                                                            <label for="interview_method3">In Person</label><br> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>  
                                                             
                                                        </div>
                                                        <div class="row"> 
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <label class="fieldlabels">Note :</label> 
                                                                <input type="text" id="posting_note" name="posting_note" v-model="form.posting_note" placeholder="Type Note"/>  
                                                             </div> 
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <div class="form-box-outer">
                                                                    <h4>Terms of agreement</h4>
                                                                    <p>The Terms of Service Agreement is mainly used for legal purposes by companies which provide software or services, such as web browsers, e-commerce, web search engines, social media, and transport services.<br><br>
                    
                                                                    A legitimate terms-of-service agreement is legally binding and may be subject to change.[2] Companies can enforce the terms by refusing service. Customers can enforce by filing a lawsuit or arbitration case if they can show they were actually harmed by a breach of the terms. There is a heightened risk of data going astray during corporate changes, including mergers, divestitures, buyouts, downsizing, etc., when data can be transferred improperly.[3] <br><br>
                    
                    
                                                                    The Terms of Service Agreement is mainly used for legal purposes by companies which provide software or services, such as web browsers, e-commerce, web search engines, social media, and transport services.<br><br>
                    
                                                                    A legitimate terms-of-service agreement is legally binding and may be subject to change.[2] Companies can enforce the terms by refusing service. Customers can enforce by filing a lawsuit or arbitration case if they can show they were actually harmed by a breach of the terms. There is a heightened risk of data going astray during corporate changes, including mergers, divestitures, buyouts, downsizing, etc., when data can be transferred improperly.[3] </p>
                    
                                                                    <h4>Accept</h4>
                                                                    <div class="position-relative form-group">
                                                                        <select type="select" id="posting_accept" name="posting_accept" v-model="form.posting_accept"  class="custom-select">
                                                                            <option value="">Select</option>
                                                                            <option value="">Yes</option>
                                                                            <option value="">No</option>  
                                                                        </select>
                                                                    </div>
                                                                </div>  
                                                             </div> 
                                                        </div>
                                                    </div> 
                                                </div>
                                                 
                                            </div>
                                        </div> 
                                         
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </fieldset> 
                </form>
            </div>
        </div>
    </div>
</section>

</template>

<script>
	import Vue from 'vue';
	

	


    export default {
        name:'list-product-categories',
       
        data(){
            return{
            	editmode:false,
				filter: '',
            	form:new Form({
            		 
                   account_no: '',
                   posting_class:0,
                   post_name: '',
                   post_user_id: '',
                   posting_user_type:0, 
                   posting_status:0,
                   creating_date: '',
                   approved_date: '',
                   validation_period_date: '',
                   expiration_date: '',
                   employer_number: '',
                   employer_companay_name: '',
                   full_legal_name: '',
                   company_address: '',
                   company_website: '',
                   company_contacts: '',
                   company_about_us: '',
                   posting_title: '',
                   job_title: '',
                   Employment_self_employed:0,
                   full_part_time:0,
                   hourly_rate: '',
                   monthly_salary: '',
                   posting_benefits: '',
                   job_description: '',
                   posting_responsibilities: '',
                   education_lavel: '',
                   posting_skills: '',
                   job_experience:0,
                   permit_license:0,
                   work_location: '',
                   days_hours:0,
                   overtime_allowed:0,
                   probation_period:0, 
                   posting_bondable:0,
                   contract_requited:0,
                   medical_test:false,
                   drug:false,
                   criminal_check:false,
                   personal:false,
                   work:false,
                   school:false,
                   living_area:false,
                   online:false,
                   phone:false,
                   in_person:false,
                   posting_note: '', 
                   posting_accept:0,
                   
            	}), 
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchCompanyProfile();
           
        },
		
	    methods: {

	    	check_management_type(e,type){
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.coop_property=false;
		    			this.form.free_hold_management=false;
		    			this.form.leasehold_management=false;
		    			this.form.property_management=false;
		    			this.form.management_type=1;
		    		}
		    		else if(type==2)
		    		{
		    			this.form.strata_management=false;
		    			this.form.free_hold_management=false;
		    			this.form.leasehold_management=false;
		    			this.form.property_management=false;
		    			this.form.management_type=2;
		    		}
		    		else if(type==3)
		    		{
		    			this.form.strata_management=false;
		    			this.form.coop_property=false;
		    			this.form.leasehold_management=false;
		    			this.form.property_management=false;
		    			this.form.management_type=3;
		    		}
		    		else if(type==4)
		    		{
		    			this.form.strata_management=false;
		    			this.form.coop_property=false;
		    			this.form.free_hold_management=false;
		    			this.form.property_management=false;
		    			this.form.management_type=4;
		    		}
		    		else if(type==5)
		    		{
		    			this.form.strata_management=false;
		    			this.form.coop_property=false;
		    			this.form.free_hold_management=false;
		    			this.form.leasehold_management=false;
		    			this.form.management_type=5;
		    		}
	    		}
	    		
	    		
	    		
	    	},

	    	check_operation_type(e,type)
            {
	    		if(e.target.checked)
	    		{
	    			if(type==1)
		    		{
		    			this.form.buy_and_sell_suite_unit=false;
		    			this.form.rental_parking=false;
		    			this.form.rental_storage=false;
		    			this.form.landholders_residency=false;
		    			this.form.type_of_operation=1;
		    		}
		    		else if(type==2)
		    		{
		    			this.form.rantal_suite_unit=false;
		    			this.form.rental_parking=false;
		    			this.form.rental_storage=false;
		    			this.form.landholders_residency=false;
		    			this.form.type_of_operation=2;
		    		}
		    		else if(type==3)
		    		{
		    			this.form.rantal_suite_unit=false;
		    			this.form.buy_and_sell_suite_unit=false;
		    			this.form.rental_storage=false;
		    			this.form.landholders_residency=false;
		    			this.form.type_of_operation=3;
		    		}
		    		else if(type==4)
		    		{
		    			this.form.rantal_suite_unit=false;
		    			this.form.buy_and_sell_suite_unit=false;
		    			this.form.rental_parking=false;
		    			this.form.landholders_residency=false;
		    			this.form.type_of_operation=4;
		    		}
		    		else if(type==5)
		    		{
		    			this.form.rantal_suite_unit=false;
		    			this.form.buy_and_sell_suite_unit=false;
		    			this.form.rental_parking=false;
		    			this.form.rental_storage=false;
		    			this.form.type_of_operation=5;
		    		}
	    		}	    		
	    	},
            
	        fetchCompanyProfile()
            {
                let uri = '/AccountSetups';
                window.axios.get(uri).then((response) => 
                { 
                   this.account_no=response.data.account_no;
                   this.posting_class=response.data.posting_class;
                   this.post_name=response.data.post_name;
                   this.post_user_id=response.data.post_user_id;
                   this.posting_user_type=response.data.posting_user_type; 
                   this.posting_status=response.data.posting_status;
                   this.creating_date=response.data.creating_date;
                   this.approved_date=response.data.approved_date;
                   this.validation_period_date=response.data.validation_period_date;
                   this.expiration_date=response.data.expiration_date;
                   this.employer_number=response.data.employer_number;
                   this.employer_companay_name=response.data.employer_companay_name;
                   this.full_legal_name=response.data.full_legal_name;
                   this.company_address=response.data.company_address;
                   this.company_website=response.data.company_website;
                   this.company_contacts=response.data.company_contacts;
                   this.company_about_us=response.data.company_about_us;
                   this.posting_title=response.data.posting_title;
                   this.job_title=response.data.job_title;
                   this.Employment_self_employed=response.data.Employment_self_employed;
                   this.full_part_time=response.data.full_part_time;
                   this.hourly_rate=response.data.hourly_rate;
                   this.monthly_salary=response.data.monthly_salary;
                   this.posting_benefits=response.data.posting_benefits;
                   this.job_description=response.data.job_description;
                   this.posting_responsibilities=response.data.posting_responsibilities;
                   this.education_lavel=response.data.education_lavel;
                   this.posting_skills=response.data.posting_skills;
                   this.job_experience=response.data.job_experience;
                   this.permit_license=response.data.permit_license;
                   this.work_location=response.data.work_location;
                   this.days_hours=response.data.days_hours;
                   this.overtime_allowed=response.data.overtime_allowed;
                   this.probation_period=response.data.probation_period; 
                   this.posting_bondable=response.data.posting_bondable;
                   this.contract_requited=response.data.contract_requited;
                   this.medical_test=response.data.medical_test;
                   this.drug=response.data.drug;
                   this.criminal_check=response.data.criminal_check;
                   this.personal=response.data.personal;
                   this.work=response.data.work;
                   this.school=response.data.school;
                   this.living_area=response.data.living_area;
                   this.online=response.data.online;
                   this.phone=response.data.phone;
                   this.in_person=response.data.in_person;
                   this.posting_note=response.data.posting_note;
                   this.posting_accept=response.data.posting_accept;

                    
                	
                	if(this.form.id){
                		this.editmode=true;
                	}

                	this.countries 								=response.data.country_arr;
                	
                });   
            },

          
         
       

            updateCompanyProfile()
            {
            
				let route = this.$router.resolve({ path: "/Temp-ContactsPersons" });
      			window.open(route.href,'_self');
      			return;
		        this.form.put('/AccountSetups/'+this.form.id)
				    .then(()=>{
					       //success
					     
					
							toast({
							  type: 'success',
							  title: 'Data Update Successfully'
							});
					
					     this.form.reset ();
					     this.fetchCompanyProfile();
				    })
				    .catch(()=>{
					   Swal("failed!","there was some wrong","warning");
				
				    });
            },
            
            createCompanyProfile()
            {

            	
            	
        	    this.form.post('/AccountSetups') .then(({ data }) => { 
               
					
					toast({
						type: 'success',
						title: 'Data Save successfully'
					});

					this.form.reset ();
					//this.fetchCompanyProfile();
        	    })
            }
	    }
    
    }  
	
</script>