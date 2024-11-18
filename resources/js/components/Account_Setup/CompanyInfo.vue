<template>
	
		<div class="row" style="">
	      	<div class="col-md-12 col-sm-12" >
		      	<form @submit.prevent="editmode ? updateCompanyProfile() : creatCompanyProfile()" @keydown="form.onKeydown($event)">
			        <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">

						<div class="card-heading">
						</div>
						<div class="card-body">
							
						    
							<fieldset >
							 	<legend style="width:200px;">Company Information</legend>
								<table width="100%" class="">
								
									<tbody>
									
								    	<tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Legal Name:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
												    <has-error :form="form" field="legal_name"></has-error>
								                </div>
								    		</td>

								    		<td>
								            	<div class="form-lebel" align="right">
								                    Operational Name:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
												    <has-error :form="form" field="operational_name"></has-error>
								                </div>
								    		</td>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Strata Name:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<input v-model="form.strata_name" type="text" name="strata_name" class="form-control" :class="{ 'is-invalid': form.errors.has('strata_name') }">
												    <has-error :form="form" field="strata_name"></has-error>
								                </div>
								    		</td>
								    	</tr>
								        <tr>
								        	<td >
									   			<div class="form-lebel" >
									   				Company Logo
									   			</div>
									   		</td>
									   		<td>
								              
									   			<div class="form-group">
													<button 
													class="btn btn-info fullpwidth" 
													@click.prevent="addCompanylogo()">Browse</button>
								                </div>
								    		</td>
								        	<td>
								            	<div class="form-lebel" align="right">
								                    Website:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<input v-model="form.website" type="url" name="website" class="form-control" :class="{ 'is-invalid': form.errors.has('website') }" placeholder="https://www.example.com">
												    <has-error :form="form" field="website"></has-error>
								                </div>
								    		</td>
								 
								    	</tr>
							
			
									</tbody>
							   </table>
							</fieldset>
							<br/>
							<fieldset style="margin-top:30px;">
							 	<legend style="width:200px;">Address</legend>
								<table width="100%"  class="table" align="center">
									<thead>
										<tr>
											<th rowspan="2"  style="vertical-align:middle; text-align:center">Particular</th>
											<th  style="vertical-align:middle; text-align:center">Mailing</th>
											<th  style="vertical-align:middle; text-align:center">Billing</th>
										</tr>
										
									</thead>
									<tbody>
										<tr>
									   		<td  >
									   			<div class="form-lebel"  >
									   				Country
									   			</div>
									   		</td>

								    		<td>
								                <div class="form-group">
													<select v-model="form.mailing_country_id"
								                      	name="mailing_country_id" 
								                      	id="mailing_country_id"
								                      	@change="country_change"
								                      	class="form-control" :class="{ 'is-invalid': form.errors.has('mailing_country_id') }">
												        	<option  value="">--Select Country-- </option>
														  	<option v-for="(country,index) in country_arr" :value="index">{{country}}</option>
												  	</select>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<select v-model="form.billing_country_id"
								                      	name="billing_country_id" 
								                      	id="billing_country_id"

								                      	class="form-control" :class="{ 'is-invalid': form.errors.has('billing_country_id') }">
												        	<option  value="">--Select Country-- </option>
														  	<option v-for="(country,index) in country_arr" :value="index">{{country}}</option>
												  	</select>
								                </div>
								    		</td>
								    	
									   	</tr>
									   	<tr>
									   		<td  >
									   			<div class="form-lebel"  >
									   				State
									   			</div>
									   		</td>
									   		
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.mailing_state" 
														type="text" 
														name="mailing_state" 
														@keyup="state_change"
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('mailing_state') }">

											    	<has-error :form="form" field="mailing_state"></has-error>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.billing_state" 
														type="text" 
														name="billing_state" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('billing_state') }">

											    	<has-error :form="form" field="billing_state"></has-error>
								                </div>
								    		</td>
								    		
									   	</tr>
									   	<tr>
									   		<td>
									   			<div class="form-lebel"  >
									   				City
									   			</div>
									   		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.mailing_city" 
														type="text" 
														name="mailing_city"
														@keyup="city_change" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('mailing_city') }">

											    	<has-error :form="form" field="mailing_city"></has-error>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.billing_city" 
														type="text" 
														name="billing_city" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('billing_city') }">

											    	<has-error :form="form" field="billing_city"></has-error>
								                </div>
								    		</td>
								    		
									   	</tr>
									   	<tr>
									   		<td>
									   			<div class="form-lebel"  >
									   				Street No
									   			</div>
									   		</td>
									   	
									   		
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.mailing_street" 
														type="text" 
														name="mailing_street" 
														@keyup="street_change"
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('mailing_street') }">

											    	<has-error :form="form" field="mailing_street"></has-error>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.billing_street" 
														type="text" 
														name="billing_street" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('billing_street') }">

											    	<has-error :form="form" field="billing_street"></has-error>
								                </div>
								    		</td>
									   	</tr>
									   	<tr>
									   		<td  >
									   			<div class="form-lebel"  >
									   				Postal Code 
									   			</div>
									   		</td>
									   	
									   	
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.mailing_postal_code" 
														type="text" 
														name="mailing_postal_code" 
														@keyup="postal_code_change"
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('mailing_postal_code') }">

											    	<has-error :form="form" field="mailing_postal_code"></has-error>
								                </div>
								    		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.billing_postal_code" 
														type="text" 
														name="billing_postal_code" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('billing_postal_code') }">

											    	<has-error :form="form" field="billing_postal_code"></has-error>
								                </div>
								    		</td>
									   	</tr>
									   	<tr>
									   		<td>
									   			<!-- Default unchecked -->
												<div class="custom-control custom-checkbox">
												    <input type="checkbox" 
												    	   class="custom-control-input" 
												    	   id="defaultUnchecked"
												    	   v-model="form.address_checked" 
												    	   @change="address_check">
												    <label class="custom-control-label" for="defaultUnchecked">Mailing and Billing are same. </label>
												</div>
									   		</td>
									   	</tr>
									   
									</tbody>
									
							   </table>
							</fieldset>
							<br/>
							<fieldset >
							 	<legend style="width:200px;">Contact Persons</legend>
								<table width="100%" class="">
								
									<tbody>
									
								    	<tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Name:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.contact_person_name" type="text" name="contact_person_name" class="form-control" :class="{ 'is-invalid': form.errors.has('contact_person_name') }">
												    <has-error :form="form" field="contact_person_name"></has-error>
								                </div>
								    		</td>

								    		<td>
								            	<div class="form-lebel" align="right">
								                    Department:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.contact_person_departnemt" type="text" name="contact_person_departnemt" class="form-control" :class="{ 'is-invalid': form.errors.has('contact_person_departnemt') }">
												    <has-error :form="form" field="contact_person_departnemt"></has-error>
								                </div>
								    		</td>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Position:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<input v-model="form.contact_person_position" type="text" name="contact_person_position" class="form-control" :class="{ 'is-invalid': form.errors.has('contact_person_position') }" >
												    <has-error :form="form" field="contact_person_position"></has-error>
								                </div>
								    		</td>
								    	</tr>

								        <tr>	
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Billing Email:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<input v-model="form.contact_person_billing_email" type="text" name="contact_person_billing_email" class="form-control" :class="{ 'is-invalid': form.errors.has('contact_person_billing_email') }">
												    <has-error :form="form" field="contact_person_billing_email"></has-error>
								                </div>
								    		</td>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Support Email:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.contact_person_support_email" type="text" name="contact_person_support_email" class="form-control" :class="{ 'is-invalid': form.errors.has('contact_person_support_email') }">
												    <has-error :form="form" field="contact_person_support_email"></has-error>
								                </div>
								    		</td>

								    		<td>
								            	<div class="form-lebel" align="right">
								                    Office Phone:
								                </div>
								            </td>
								    		<td>
								                <div class="form-group">
													<input v-model="form.contact_person_office_phone" type="text" name="contact_person_office_phone" class="form-control" :class="{ 'is-invalid': form.errors.has('contact_person_office_phone') }">
												    <has-error :form="form" field="contact_person_office_phone"></has-error>
								                </div>
								    		</td>
								    	</tr>

								        <tr>
								    		<td>
								            	<div class="form-lebel" align="right">
								                    Cell Phone:
								                </div>
								            </td>
								            <td>
								                <div class="form-group">
													<input v-model="form.contact_person_cell_phone" type="text" name="contact_person_cell_phone" class="form-control" :class="{ 'is-invalid': form.errors.has('contact_person_cell_phone') }">
												    <has-error :form="form" field="contact_person_cell_phone"></has-error>
								                </div>
								    		</td>
								  
								    		<td>
								            	<div class="form-lebel" align="right">
								                   
								                </div>
								            </td>
								    		<td >
												<button 
													class="btn btn-info fullpwidth" v-show="!editContactPerson"
													@click.prevent="addContactPerson()">Add Contact Person  </button>
													<button 
													class="btn btn-info fullpwidth" v-show="editContactPerson"
													@click.prevent="changeContactPerson(updated_contact_person_row)">Change Contact Person  </button>	
											</td>
								    	</tr>
			
									</tbody>
							   </table>

							   <fieldset >
				              		<legend>Contact Persons List</legend>
				               		<table width="100%" class=" ">	               			
				               			<tbody class="text-left">
							              
							               	<tr>
								             
								        		<td>
								                    <div class="pull-right">
														<label for="filter" class="sr-only">Filter</label>
														<input type="text" class="form-control" v-model="filter_contact_person" placeholder="Filter" style="width:400px;">
													</div>
								        		</td>
								        	</tr>							
										</tbody>
				               		</table>

				               		<table class="table">
				               			<thead>
				               				<tr>
				               					<th>Sl</th>
				               					<th>Name</th>
				               					<th>Department</th>
				               					<th>Position </th>
				               					<th>Billing Email</th>
				               					<th>Office Phone</th>

				               				</tr>
				               			</thead>
				               			<tbody>
				               				<tr v-for="(row,index) in form.contact_person_arr">
							                    <td>{{ row.sl}}</td>
							                    <td>{{ row.contact_person_name}}</td>
							                    <td>{{ row.contact_person_departnemt }}</td>
							                    <td>{{ row.contact_person_position}}</td>
							                    <td>{{ row.contact_person_billing_email}}</td>
							                    <td>{{ row.contact_person_office_phone}}</td>
							                    <td>
							                    	<button class="btn btn-primary btn-sm" @click.prevent="edit_contact_persons(row,index)">Edit</button>
							                    	<button class="btn btn-danger btn-sm" @click.prevent="delete_contact_person(row,index)">Delete</button>
							                    </td>
							                </tr>
				               			</tbody>
				               		</table>
									
											
										
								</fieldset > 
								<br>
								<table  align="center">
    
						    	<tbody>
						           	
						        	
						        	<tr>
						        		<td align="center">
						        		

					                       	<div class="form-group">
						                        <button :disabled="form.busy" v-show="!editmode" type="submit" class="btn btn-primary">Save Company</button>
										      	<button :disabled="form.busy" v-show="editmode" type="submit" class="btn btn-primary">Update Company</button>
										      	
						                    </div>

						        		</td>
						        	</tr>
						        </tbody>
						    </table>

							</fieldset>
						</div>  
				    </div>

		        </form>	     
	      	</div><!-- /.col-md-12 -->
	    

	      	<!--  MOdel User Photo -->
        	<div class="modal fade" id="addNewCompanyLogo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"   >
			  <div class="modal-dialog" role="document">
			    <div class="modal-content" style="width:600px">
	            
			      	<div class="modal-header">
		                <h2 id="messagebox_main"></h2>
				        <h5 class="modal-title" v-show="!editmodephpto" id="">Add New Logo</h5>
						<h5 class="modal-title" v-show="editmodephpto" id="">Update Logo</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
		  			<div class="modal-body">
				         <form @submit.prevent="editmodephpto ? updateImage() : createImage()" @keydown="form.onKeydown($event)">
				         	<table width="550">
    
						    	<tbody>
						           	
						        	<tr>
						        		<td>
						        			<div class="form-group" v-if="company_logo">
					                           	<img :src="company_logo" class="img-responsive" height="150" width="200">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>
						        			<div class="form-group">
					                              <input type="file" v-on:change="onImageChange" class="form-control" style="max-width:500px;">
					                       </div>

						        		</td>
						        	</tr>
						        	<tr>
						        		<td>

					                       	<div class="form-group">
						                        <button :disabled="form.busy" v-show="!editmodephpto" type="submit" class="btn btn-primary">Save Logo</button>
										      	<button :disabled="form.busy" v-show="editmodephpto" type="submit" class="btn btn-primary">Update Logo</button>
										      	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						                    </div>

						        		</td>
						        	</tr>
						        </tbody>
						    </table>
				         	
					  	</form>
				      </div>
				      <div class="modal-footer">
				      </div>
				    </div>
				  </div>
			</div>

			<!-- model end -->



	    </div>
	
</template>
<style>
	

</style>

<script>
	import Vue from 'vue';
	import DatePicker from 'vue2-datepicker';
	import DatatableFactory from 'vuejs-datatable';	
	Vue.use(DatatableFactory);

	export default {
		components:{
			DatePicker
		},
		data(){
            return{
                filter: '',
                filter_contact_person:'',
                editmode:false,
                editmodephpto:false,
                editContactPerson:false,
                company_logo: '',
                updated_contact_person_row:'',
                form:new Form(
                {
                	address_checked:false,
                    legal_name:'',
                    operational_name:'',
                    strata_name:'',
                    last_name:'',
                    nick_name:'',
                    website:'',
                    company_logo_id:'',
                   
                    mailing_country_id:'',
                    billing_country_id:'',

					mailing_state:'',
					billing_state:'',

					mailing_city:'',
					billing_city:'',

					mailing_street:'',
					billing_street:'',

					mailing_postal_code:'',
					billing_postal_code:'',

					contact_person_name:'',
					contact_person_departnemt:'',
					contact_person_position:'',
					contact_person_billing_email:'',
					contact_person_support_email:'',
					contact_person_office_phone:'',
					contact_person_cell_phone:'',
					contact_person_id:'',
					id:'',
				
			
                  	contact_person_arr:[],
                 

              	}),
          

                contact_person_columns: [
                    
                    { label: 'SL', field: 'id', align: 'center' },
                    { label: 'Name', field: 'contact_person_name' },
                    { label: 'Department', field: 'contact_person_departnemt' },
                    { label: 'Position', field: 'contact_person_position' },
                    { label: 'Billing Email', field: 'contact_person_billing_email' },
                    { label: '', field: '', sortable: false },
                ],
             
                contact_person_arr:[],
                country_arr:[], 
                StatusArr:[],
                page: 1,
                per_page:10,
                page1: 1,
                per_page1:10,
          	}
        },// data finish


        created: function()
        {
            this.fetchCompanies();

        },
        methods: {
        	

        	address_check: function() {
		      if(this.form.address_checked)
		      {
                    
                    this.form.billing_country_id=this.form.mailing_country_id;
					this.form.billing_state=this.form.mailing_state;
					this.form.billing_city=this.form.mailing_city;
					this.form.billing_street=this.form.mailing_street;
					this.form.billing_postal_code=this.form.mailing_postal_code;	
		      }
		      else
		      {
		      	 	this.form.billing_country_id="";
					this.form.billing_state="";
					this.form.billing_city="";
					this.form.billing_street="";
					this.form.billing_postal_code="";
		      }
		    },

		    country_change() {

		      if(this.form.address_checked)
		      	this.form.billing_country_id=this.form.mailing_country_id;
		   
		    },

		    state_change() {
		    	
		      if(this.form.address_checked)
		      	this.form.billing_state=this.form.mailing_state;
		   
		    },

		    city_change() {
		    	
		      if(this.form.address_checked)
		      	this.form.billing_city=this.form.mailing_city;
		   
		    },
		    street_change() {
		    	
		      if(this.form.address_checked)
		      	this.form.billing_street=this.form.mailing_street;
		   
		    },
		    postal_code_change() {
		    	
		      if(this.form.address_checked)
		      	this.form.billing_postal_code=this.form.mailing_postal_code;
		   
		    },
        	/*=======================upload photo=======================================*/
        	addCompanylogo(){

                $("#addNewCompanyLogo").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },

            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createrowimage(files[0]);
            },
            createrowimage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.company_logo = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            createImage(){
            	
        		axios.post('/image/store',{image: this.company_logo,image_file_name: 'company_logo',image_folder_name: 'account_company_logo'}).then(({ data }) => {
                   	
                   	var response_arr=data.split('**');
                   	this.form.company_logo_id=response_arr[1];
                   	this.editmodephpto=true;
                   	toast({
					  type: 'success',
					  title: 'Data Save Successfully'
					});
                });
                
            },

            updateImage(){

        		axios.post('/image/update',{image: this.company_logo,img_id: this.form.company_logo_id,image_file_name: 'company_logo',image_folder_name: 'account_company_logo'}).then(({ data }) => {

                   var response_arr=data.split('**');
                   this.form.company_logo_id=response_arr[1];
                   this.editmodephpto=true;
                   toast({
					  type: 'success',
					  title: 'Data Update Successfully'
					});
                });
            },

        	//====================================== previous user================================================
        	user_id_popup(){
        		
    
        		$("#addInsertedUser").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
        	},
          

            fetchCompanies()
            {
                let uri = '/AccountSetups';
                window.axios.get(uri).then((response) => {
                
                  //this.form.fill(response.data.company_data);
                  this.country_arr      	= response.data.country_arr;
                  this.StatusArr      		= response.data.row_status;
                  this.contact_person_arr   = response.data.contact_person_arr;
                  if(response.data.company_data){

                  	this.form.legal_name=response.data.company_data.legal_name;
                    this.form.operational_name=response.data.company_data.operational_name;
                    this.form.strata_name=response.data.company_data.strata_name;
                    this.form.last_name=response.data.company_data.last_name;
                    this.form.nick_name=response.data.company_data.nick_name;
                    this.form.website=response.data.company_data.website;
                    this.form.company_logo_id=response.data.company_data.company_logo_id;
                   
                    this.form.mailing_country_id=response.data.company_data.mailing_country_id;
                    this.form.billing_country_id=response.data.company_data.billing_country_id;

					this.form.mailing_state=response.data.company_data.mailing_state;
					this.form.billing_state=response.data.company_data.billing_state;

					this.form.mailing_city=response.data.company_data.mailing_city;
					this.form.billing_city=response.data.company_data.billing_city;

					this.form.mailing_street=response.data.company_data.mailing_street;
					this.form.billing_street=response.data.company_data.billing_street;

					this.form.mailing_postal_code=response.data.company_data.mailing_postal_code;
					this.form.billing_postal_code=response.data.company_data.billing_postal_code;

					// this.form.contact_person_name=response.data.company_data.contact_person_name;
					// this.form.contact_person_departnemt=response.data.company_data.contact_person_departnemt;
					// this.form.contact_person_position=response.data.company_data.contact_person_position;
					// this.form.contact_person_billing_email=response.data.company_data.contact_person_billing_email;
					// this.form.contact_person_support_email=response.data.company_data.contact_person_support_email;
					// this.form.contact_person_office_phone=response.data.company_data.contact_person_office_phone;
					// this.form.contact_person_cell_phone=response.data.company_data.contact_person_cell_phone;
					this.form.id=response.data.company_data.id;
                  }

                  if(this.form.id) this.editmode=true;

                  /* ==============Filing Date addition============================*/

               		this.form.contact_person_arr.splice(0);
                	for( var i = 0; i < this.contact_person_arr.length; i++ ) 
					{
					
						this.form.contact_person_arr.push({

							id:this.contact_person_arr[i].id,
	                		contact_person_name:this.contact_person_arr[i].contact_person_name,
	                		contact_person_departnemt:this.contact_person_arr[i].contact_person_departnemt,
							contact_person_position:this.contact_person_arr[i].contact_person_position,
							contact_person_billing_email:this.contact_person_arr[i].contact_person_billing_email,
							contact_person_support_email:this.contact_person_arr[i].contact_person_support_email,
							contact_person_office_phone:this.contact_person_arr[i].contact_person_office_phone,
							contact_person_cell_phone:this.contact_person_arr[i].contact_person_cell_phone,
	            		});
					}
                });   
            },




            /* ==============vihicle addition function============================*/
			addContactPerson(){

        	 	if(this.form.contact_person_name=="")
        	 	{
        	 		toast({
						type: 'warning',
						title: 'Please write Name.'
					});
					return;
        	 	}

        	 	if(this.form.contact_person_departnemt=="")
        	 	{
        	 		toast({
						type: 'warning',
						title: 'Please write Department.'
					});
					return;
        	 	}
        	 	if(this.form.contact_person_position=="")
        	 	{
        	 		toast({
						type: 'warning',
						title: 'Please write Position.'
					});
					return;
        	 	}
        	 	if(this.form.contact_person_billing_email=="")
        	 	{
        	 		toast({
						type: 'warning',
						title: 'Please write Billing Email.'
					});
					return;
        	 	}
        	 	if(this.form.contact_person_office_phone=="")
        	 	{
        	 		toast({
						type: 'warning',
						title: 'Please write Office Phone.'
					});
					return;
        	 	}

                this.form.contact_person_arr.push({
                	id:this.form.contact_person_name.contact_person_id,
					contact_person_name:this.form.contact_person_name,
					contact_person_departnemt:this.form.contact_person_departnemt,
					contact_person_position:this.form.contact_person_position,
					contact_person_billing_email:this.form.contact_person_billing_email,
					contact_person_support_email:this.form.contact_person_support_email,
					contact_person_office_phone:this.form.contact_person_office_phone,
					contact_person_cell_phone:this.form.contact_person_cell_phone,

        		});

               this.form.contact_person_id="";
               this.form.contact_person_name='';
               this.form.contact_person_departnemt='';
               this.form.contact_person_position='';
               this.form.contact_person_support_email='';
               this.form.contact_person_billing_email='';
               this.form.contact_person_office_phone='';
               this.form.contact_person_cell_phone='';

            },

            changeContactPerson(row_id){
            	
            	this.form.contact_person_arr.splice(row_id,1,{

					contact_person_name:this.form.contact_person_name,
					contact_person_departnemt:this.form.contact_person_departnemt,
					contact_person_position:this.form.contact_person_position,
					contact_person_billing_email:this.form.contact_person_billing_email,
					contact_person_support_email:this.form.contact_person_support_email,
					contact_person_office_phone:this.form.contact_person_office_phone,
					contact_person_cell_phone:this.form.contact_person_cell_phone,

        		});

        	   this.form.contact_person_name='';
               this.form.contact_person_departnemt='';
               this.form.contact_person_position='';
               this.form.contact_person_support_email='';
               this.form.contact_person_billing_email='';
               this.form.contact_person_office_phone='';
               this.form.contact_person_cell_phone='';
               this.updated_contact_person_row='';
               this.editContactPerson=false;
            },

            edit_contact_persons(row,row_id){

               this.form.contact_person_id=row.id;
               this.form.contact_person_name=row.contact_person_name;
               this.form.contact_person_departnemt=row.contact_person_departnemt;
               this.form.contact_person_position=row.contact_person_position;
               this.form.contact_person_support_email=row.contact_person_support_email;
               this.form.contact_person_billing_email=row.contact_person_billing_email;
               this.form.contact_person_office_phone=row.contact_person_office_phone;
               this.form.contact_person_cell_phone=row.contact_person_cell_phone;
               this.updated_contact_person_row=row_id;
               this.editContactPerson=true;

            },
            delete_contact_person(row,index){
            	if(row.id)
            	{
            		
            	}
            	this.form.contact_person_arr.splice(index,1);
            	if(index==this.updated_contact_person_row)
            	{
            		this.form.contact_person_name='';
            		this.form.contact_person_id='';
	               	this.form.contact_person_departnemt='';
	               	this.form.contact_person_position='';
	               	this.form.contact_person_support_email='';
	               	this.form.contact_person_billing_email='';
	               	this.form.contact_person_office_phone='';
	               	this.form.contact_person_cell_phone='';
	               	this.updated_contact_person_row='';
	               	this.editContactPerson=false;
            	}

            },

            creatCompanyProfile()
            {

        	     this.form.post('/AccountSetups') .then(({ data }) => { 

        	    	if(data==1)
					{
						
						toast({
							type: 'success',
							title: 'Data Save successfully'
						});

						this.form.reset ();
					    this.fetchCompanies();
					}
					else if(data==10)
					{

						toast({
							type: 'question',
							title: 'Invalid Operation.'
						});
					}
					else
					{
						Swal("failed!","there was some wrong","warning");
					}
					
        	    })
            },

            updateCompanyProfile()
            {
            	
		        this.form.put('/AccountSetups/'+this.form.id)
				    .then(({data})=>{
					   
						if(data==1)
						{
							
							toast({
								type: 'success',
								title: 'Data Update successfully'
							});

							this.form.reset ();
						    this.fetchCompanies();
						    this.editmode=false;
						}
						else if(data==10)
						{

							toast({
								type: 'question',
								title: 'Invalid Operation.'
							});
						}
						else
						{
							alert(data)
							Swal("failed!","there was some wrong","warning");
						}
				    })
				 
            },

          
        }
	}


</script>

	

