<template>
	
		<div class="row" style="">
	      	<div class="col-md-12 col-sm-12" >
		      	<form @submit.prevent="editmode ? updateCompanyProfile() : creatCompanyProfile()" @keydown="form.onKeydown($event)" autocomplete="off">
			        <div class="card card-default widget wow fadeInDown animated " style=" animation-delay: 0.18s;">

						<div class="card-heading">
						</div>
						<div class="card-body">
							
						    
							<fieldset >
							 	<legend style="width:200px;">About Our Building</legend>
								<table width="100%" class="">
								
									<tbody>
									
								    	<tr>
								    		<td width="70%" rowspan="4">
								            
								                <div class="form-group">
													
													<textarea class="form-control"
							                  			name="building_history" 
							                  			rows="5" 
							                  			placeholder="Building History"
							                  			v-model="form.building_history"
							                  			:class="{ 'is-invalid': form.errors.has('building_history') }">
						                  			</textarea>
												    <has-error :form="form" field="building_history"></has-error>
								                </div>
								    		</td>

								    		<td align="center" width="30%">
								              
									   			<div class="form-group" style="margin-bottom:.1px">
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addBuildingPhoto(1)">Upload Photo</button>
								          
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addBuildingPhoto(2)">Upload Photo</button>
								                </div>
								    		</td>
								    	</tr>
								    	<tr>
								    		<td align="center" width="30%" >
								              
									   			<div class="form-group" style="margin-bottom:.1px">
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addBuildingPhoto(3)">Upload Photo</button>
								          
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addBuildingPhoto(4)">Upload Photo</button>
								                </div>
								    		</td>
								    	</tr>
								    	<tr>
								    		<td align="center" width="30%" >
								              
									   			<div class="form-group" style="margin-bottom:.1px">
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addBuildingPhoto(5)">Upload Photo</button>
								          
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addBuildingPhoto(6)">Upload Photo</button>
								                </div>
								    		</td>
								    	</tr>
								    	<tr>
								    		<td align="center" width="30%" style="margin-bottom:.1px">
								              
									   			<div class="form-group">
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addBuildingPhoto(7)">Upload Photo</button>
								          
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addBuildingPhoto(8)">Upload Photo</button>
								                </div>
								    		</td>
								    	</tr>
								        
							
			
									</tbody>
							   </table>

							   <br/>
							   <table width="100%"  class="" align="center">
									
									<tbody>
										<tr>
									   		<td  >
									   			<div class="form-lebel"  >
									   				Building Type
									   			</div>
									   		</td>

								    		<td>
								                <div class="form-group">
													
													<button 
														class="btn  fullpwidth"
														@click.prevent="changeClass(1)"
														 v-bind:class="{ 'btn-info': isRasidential, 'btn-secondary': hasRasidential }" 
														>Residential</button>
													<button 
														class="btn fullpwidth" 
														v-bind:class="{ 'btn-info': isCommercial, 'btn-secondary': hasCommercial }" 
														@click.prevent="changeClass(2)">Commercial</button>
													<button 
														class="btn fullpwidth"
														v-bind:class="{ 'btn-info': isEducational, 'btn-secondary': hasEducational }" 
														@click.prevent="changeClass(3)">Educational 
														</button>
													<button 
														class="btn fullpwidth"
														v-bind:class="{ 'btn-info': isIndustrial, 'btn-secondary': hasIndustrial }" 
														@click.prevent="changeClass(4)">Industrial Building</button>	
											
								                </div>
								    		</td>
								    		
								    	
									   	</tr>
								
									   
									</tbody>
									
							   </table>
							</fieldset>
							<br/>
					
							<br/>
							<fieldset style="margin-top:30px;">
							 	<legend style="width:200px;">Address</legend>
								<table width="100%"  class="" align="center">
								
									<tbody>
										<tr>
									   		<td   align="right">
									   			<div class="form-lebel"  >
									   				Country
									   			</div>
									   		</td>

								    		<td>
								                <div class="form-group">
													<select v-model="form.country_id"
								                      	name="country_id" 
								                      	id="country_id"
								                      	class="form-control" :class="{ 'is-invalid': form.errors.has('country_id') }">
												        	<option  value="">--Select Country-- </option>
														  	<option v-for="(country,index) in country_arr" :value="index">{{country}}</option>
												  	</select>
								                </div>
								    		</td>

									   		<td  align="right">
									   			<div class="form-lebel"  >
									   				State/ Provience
									   			</div>
									   		</td>
									   		
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.state" 
														type="text" 
														name="state" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('state') }">

											    	<has-error :form="form" field="state"></has-error>
								                </div>
								    		</td>
									   	</tr>
									   	<tr>
									   		<td align="right">
									   			<div class="form-lebel"  >
									   				City
									   			</div>
									   		</td>
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.city" 
														type="text" 
														name="city"
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('city') }">

											    	<has-error :form="form" field="city"></has-error>
								                </div>
								    		</td>
								    		
									   		<td align="right">
									   			<div class="form-lebel"  >
									   				Street No
									   			</div>
									   		</td>
									   	
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.street" 
														type="text" 
														name="street" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('street') }">

											    	<has-error :form="form" field="street"></has-error>
								                </div>
								    		</td>
								    		
									   	</tr>
									   	<tr>
									   		<td  align="right">
									   			<div class="form-lebel"  >
									   				Postal Code 
									   			</div>
									   		</td>
									   	
									   	
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.postal_code" 
														type="text" 
														name="postal_code" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('postal_code') }">

											    	<has-error :form="form" field="postal_code"></has-error>
								                </div>
								    		</td>
								    		<td  align="right">
									   			<div class="form-lebel"  >
									   				Website
									   			</div>
									   		</td>
									   	
									   	
								    		<td>
								                <div class="form-group">
													<input
														v-model="form.website" 
														type="text" 
														name="website" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('website') }">

											    	<has-error :form="form" field="website"></has-error>
								                </div>
								    		</td>
									   	</tr> 
									   	<tr>
									   		<td  align="right">
									   			<div class="form-lebel"  >
									   				Logo 
									   			</div>
									   		</td>
									   	
									   	
								    		<td>
								                <div class="form-group">
													<button 
													class="btn btn-info fullpwidth" 
													@click.prevent="addCompanylogo(1)">Upload Photo</button>
								                </div>
								    		</td>
								    		
									   	</tr> 
									</tbody>
									
							   </table>
							</fieldset>
							<br/>
							<fieldset >
							 	<legend>Social Link</legend>
				               		<table width="80%" class=" ">

				               			<thead class="text-center">
				               			
				               				<tr>

				               					<th align="center" >Social Link Name</th>
				               					<th align="center">Social Link</th>
				               					<th align="center">Action</th>
				               				</tr>
				               			</thead>
				               			<tbody class="text-center">
							               	<tr v-for="(social_link,index) in form.social_links">
							               		<td   >
										   			<div class="form-lebel"  >
										   				{{social_link.link_name}}
										   			</div>
										   		</td>
										   	
										   		<td>
									                <div class="form-group">
														<input
								                   				v-model="social_link.id" 
								                   				type="hidden" 
								                   				v-bind:name="'sociallink_id_'+index">
								                   			<input 
								                   				v-model="social_link.link_name" 
								                   				type="hidden" 
								                   				v-bind:name="'sociallink_link_name_'+index">
								                   			<input 
								                   				v-model="social_link.link" 
								                   				type="text"
								                   				class="form-control"  
								                   				v-bind:name="'sociallink_link_'+index">
									                </div>
									    		</td>
									    		<td>
									                <div class="form-group">
													
								                   		<button 
														class="btn btn-info btn-sm" 
														@click.prevent="RemoveSocialLink(index)">Remove</button>
									                </div>
									    		</td>

							               	</tr>
							               	<tr>
							               		<td >
													<button 
														class="btn btn-info btn-sm" 
														@click.prevent="addSocialLink()">Add New</button>	
												</td>
							               		<td>
							               			<div class="form-group">
														<input 
															v-model="new_social_link" 
															type="text"
															name="new_social_link"
															id="new_social_link"
															placeholder="Social Link Name" 
															class="form-control" 
															:class="{ 'is-invalid': form.errors.has('new_social_link') }">
													    <has-error :form="form" field="new_social_link"></has-error>
									                </div>
									            </td>
							               	</tr>
							              

										
										</tbody>
				               		</table>
									

							</fieldset>
							<br/>
							<br/>
							<fieldset >
							 	<legend style="width:200px;">Neighborhood</legend>
								<table width="90%" class="" align="center">
								
									<tbody>
									
								    	<tr>
								    		<td width="" colspan="4">
								            
								                <div class="form-group">
													
													<textarea class="form-control"
							                  			name="neighborhoodDescription" 
							                  			rows="5" 
							                  			placeholder="Neighborhood Description"
							                  			v-model="form.neighborhoodDescription"
							                  			:class="{ 'is-invalid': form.errors.has('neighborhoodDescription') }">
						                  			</textarea>
												    <has-error :form="form" field="neighborhoodDescription"></has-error>
								                </div>
								    		</td>

								    	</tr>
								    	<tr>

								    		<td align="center" >
									   			<div class="form-group" style="margin-bottom:.1px">
													<input
														v-model="form.neighborhoodOne" 
														type="text" 
														placeholder="Name"
														name="neighborhoodOne" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('neighborhoodOne') }">
								                </div>
								    		</td>
								    		<td align="center"  >
								              
									   			<div class="form-group" style="margin-bottom:.1px">
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addCompanylogo(2)">Upload Photo</button>
								                </div>
								    		</td>
								    		<td align="center" >
								              
									   			<div class="form-group" style="margin-bottom:.1px">
													<input
														v-model="form.neighborhoodTwo" 
														type="text"
														placeholder="Name" 
														name="neighborhoodTwo" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('neighborhoodTwo') }">
								                </div>
								    		</td>
								    		<td align="center"  >
								              
									   			<div class="form-group" style="margin-bottom:.1px">
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addCompanylogo(3)">Upload Photo</button>
								                </div>
								    		</td>
								    	</tr>
								    	<tr>

								    		<td align="center" >
									   			<div class="form-group" style="margin-bottom:.1px">
													<input
														v-model="form.neighborhoodThree" 
														type="text" 
														placeholder="Name"
														name="neighborhoodThree" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('neighborhoodThree') }">
								                </div>
								    		</td>
								    		<td align="center"  >
								              
									   			<div class="form-group" style="margin-bottom:.1px">
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addCompanylogo(4)">Upload Photo</button>
								                </div>
								    		</td>
								    		<td align="center" >
								              
									   			<div class="form-group" style="margin-bottom:.1px">
													<input
														v-model="form.neighborhoodFour" 
														type="text"
														placeholder="Name" 
														name="neighborhoodFour" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('neighborhoodFour') }">
								                </div>
								    		</td>
								    		<td align="center"  >
								              
									   			<div class="form-group" style="margin-bottom:.1px">
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addCompanylogo(5)">Upload Photo</button>
								                </div>
								    		</td>
								    	</tr>
								    	<tr>

								    		<td align="center" >
									   			<div class="form-group" style="margin-bottom:.1px">
													<input
														v-model="form.neighborhoodFive" 
														type="text" 
														placeholder="Name"
														name="neighborhoodFive" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('neighborhoodFive') }">
								                </div>
								    		</td>
								    		<td align="center"  >
								              
									   			<div class="form-group" style="margin-bottom:.1px">
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addCompanylogo(6)">Upload Photo</button>
								                </div>
								    		</td>
								    		<td align="center" >
								              
									   			<div class="form-group" style="margin-bottom:.1px">
													<input
														v-model="form.neighborhoodSix" 
														type="text"
														placeholder="Name" 
														name="neighborhoodSix" 
														class="form-control" 
														:class="{ 'is-invalid': form.errors.has('neighborhoodSix') }">
								                </div>
								    		</td>
								    		<td align="center"  >
								              
									   			<div class="form-group" style="margin-bottom:.1px">
													<button 
													class="btn btn-info btn-sm" 
													@click.prevent="addCompanylogo(7)">Upload Photo</button>
								                </div>
								    		</td>
								    	</tr>
								        
							
			
									</tbody>
							   </table>
							   <br/>
							   <table  align="center">
	    
								    	<tbody>
								           	
								        	
								        	<tr>
								        		<td align="center">
								        		

							                       	<div class="form-group">
							                       		<button :disabled="form.busy"  
							                       		 	type="button" 
							                       		 	class="btn btn-info">NEW </button>
							                       		 &nbsp;&nbsp;&nbsp;
								                        <button 
								                        	:disabled="form.busy" 
									                        v-show="!editmode" 
									                        type="submit" 
									                        value="1" 
									                        class="btn btn-info">Save & New </button>
									                    &nbsp;&nbsp;&nbsp;
								                        <button 
								                        	:disabled="form.busy"
									                         v-show="!editmode" 
									                         type="submit" 
									                         value="2" 
									                         class="btn btn-info">Save & Stay </button>
									                    &nbsp;&nbsp;&nbsp;
								                        <button 
								                        	:disabled="form.busy" 
								                        	v-show="!editmode"
								                        	value="3"  
								                        	type="submit" 
								                        	class="btn btn-info">VOID </button>
								                       &nbsp;&nbsp;&nbsp;
												      	<button :disabled="form.busy" v-show="editmode" type="submit" class="btn btn-info"> Company</button>
												      	
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
                isRasidential: true,
 				hasRasidential: false,
 				isCommercial:false,
 				hasCommercial:true,
 				isEducational:false,
 				hasEducational:true,
 				
 				isIndustrial:false,
 				hasIndustrial:true,
 				image_id:'',
                form:new Form(
                {
                	building_type:0,
                	building_history:'',
                	address_checked:false,
                    legal_name:'',
                    operational_name:'',
                    strata_name:'',
                    last_name:'',
                    nick_name:'',
                    website:'',
                    company_logo_id:'',
                   
                    country_id:'',
					state:'',
					city:'',
					

					street:'',
					billing_street:'',

					postal_code:'',
					website:'',

					neighborhoodDescription:'',
					neighborhoodOne:'',
					neighborhoodTwo:'',
					neighborhoodThree:'',
					neighborhoodFour:'',
					neighborhoodFive:'',
					neighborhoodSix:'',
					id:'',

                  	contact_person_arr:[],
                  	 social_links:[
	                	{
	                		id:'',
	                		link_name:'',
	                		link:'',
	                	}
	                ],
              	}),
          

                contact_person_columns: [
                    
                    { label: 'SL', field: 'id', align: 'center' },
                    { label: 'Name', field: 'contact_person_name' },
                    { label: 'Department', field: 'contact_person_departnemt' },
                    { label: 'Position', field: 'contact_person_position' },
                    { label: 'Billing Email', field: 'contact_person_billing_email' },
                    { label: '', field: '', sortable: false },
                ],
               
                social_link_arr:['Website ','LinkedIn','FaceBook','Twitter','Instagram'],
             	social_media_data:[],
                contact_person_arr:[],
                country_arr:[], 
                StatusArr:[],
                new_social_link:'',
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
        	RemoveSocialLink(id){
        		this.form.social_links.splice(id,1);
        		
        	},

        	 addSocialLink()
        	 {
        	 	if(this.new_social_link=="")
        	 	{
        	 		toast({
						type: 'warning',
						title: 'Please write social link name.'
					});
					$("#new_social_link").focus();
					return;
        	 	}

                this.form.social_links.push({

					id:'',
            		link_name:this.new_social_link,
            		link:'',
        		});
        		this.new_social_link='';
               
            },
        	changeClass:function(type)
        	{
        		if(type==1)
        		{
        			if(this.isRasidential) 
        			{
        				this.form.building_type=0;
 						this.isRasidential= false;
 						this.hasRasidential= true;
 					}
 					else
 					{
 						this.form.building_type=1;
 						this.isRasidential= true;
 						this.hasRasidential= false;
 						this.isCommercial= false;
 						this.hasCommercial= true;
 						this.isEducational= false;
 						this.hasEducational= true;
 						this.isIndustrial= false;
 						this.hasIndustrial= true;
 						
 					}
        		}

        		if(type==2)
        		{
        			if(this.isCommercial) 
        			{
        				this.form.building_type=0;
 						this.isCommercial= false;
 						this.hasCommercial= true;
 					}
 					else
 					{
 						this.form.building_type=2;
 						this.isCommercial= true;
 						this.hasCommercial= false;
 						this.isRasidential= false;
 						this.hasRasidential= true;
 						this.isEducational= false;
 						this.hasEducational= true;
 						this.isIndustrial= false;
 						this.hasIndustrial= true;
 					}
        		}

        		if(type==3)
        		{
        			if(this.isEducational) 
        			{
        				this.form.building_type=0;
 						this.isEducational= false;
 						this.hasEducational= true;
 					}
 					else
 					{
 						this.form.building_type=3;
 						this.isEducational= true;
 						this.hasEducational= false;
 						this.isRasidential= false;
 						this.hasRasidential= true;
 						this.isCommercial= false;
 						this.hasCommercial= true;
 						this.isIndustrial= false;
 						this.hasIndustrial= true;
 					} 					
        		}

        		if(type==4)
        		{
        			if(this.isIndustrial) 
        			{
        				this.form.building_type=0;
 						this.isIndustrial= false;
 						this.hasIndustrial= true;
 					}
 					else
 					{
 						this.form.building_type=4;
 						this.isIndustrial= true;
 						this.hasIndustrial= false;
 						this.isEducational= false;
 						this.hasEducational= true;
 						this.isRasidential= false;
 						this.hasRasidential= true;
 						this.isCommercial= false;
 						this.hasCommercial= true;
 					} 					
        		}
        	
        	},


		
        	/*=======================upload photo=======================================*/
        	addCompanylogo(logo_name){

                $("#addNewCompanyLogo").modal('show');
				$('.modal.fade').addClass('modal fade in show');
                $('modal-backdrop').addClass('modal-backdrop fade in show') ;
            },

            addBuildingPhoto(image_id){
            	if(image_id==1)
            	{
            		
            	}

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
                  this.social_media_data      	= response.data.social_media_data;
                  this.country_arr 				= response.data.country_arr;
                  
                });

               this.form.social_links.splice(0); 
               for( var i = 0; i < this.social_link_arr.length; i++ ) 
				{
					this.form.social_links.push({

						id:'',
                		link_name:this.social_link_arr[i],
                		link:'',
            		});
				}    
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

	

