<template>

	<fieldset>
		<form @submit.prevent="editmode ? updateCompanyProfile() : createCompanyProfile()" @keydown="form.onKeydown($event)">
	        <div class="form-card">
                <h3><i class="fa fa-hand-point-right"></i> Company Profile:</h3>
                <div class="form-folder">
                    
                    <div class="form-holder" style="width:90%; padding-left:10%">
                        <div class="row align-self-stretch">
                            <div class="col-md-6 col-sm-6 col-xs-12"> 
                                <div class="form-box-outer">
                                    <h4> Legal Name</h4>
                                    <input v-model="form.legal_name" 
                                        type="text" 
                                        placeholder="Type Company Name"
                                        name="legal_name" 
                                        :class="{ 'is-invalid': form.errors.has('legal_name') }"/>
                                          
                                    <h4>Company logo</h4>
                                    <div
                                        class="upload-container"
                                        @dragover.prevent="dragging = true"
                                        @dragleave.prevent="dragging = false"
                                        @drop.prevent="handleDrop"
                                      >
                                        <div v-if="!photo" class="upload-placeholder" :class="{ dragging }">
                                            <p>Drag and drop a photo or</p>
                                            <input
                                                type="file"
                                                ref="fileInput"
                                                @change="handleFileChange"
                                                class="file-input"
                                              />
                                            <button @click="browseFile" type="button">Browse</button>
                                        </div>
                                      </div>  
                                </div>

                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    <div v-if="photo" class="preview">
                                        <img :src="photoUrl" alt="Uploaded Photo" />
                                        <button @click="removePhoto" type="button">Remove</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row align-self-stretch">                         
                            
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-box-outer">
                                    <h3 style="margin-top:0 !important">Address</h3>
                                    
                                    <label class="fieldlabels">House Number</label> 
                                    <input v-model="form.headoffice_house_number" 
                                        type="text" 
                                        name="headoffice_house_number" 
                                        placeholder="Type Street Number" 
                                        :class="{ 'is-invalid': form.errors.has('headoffice_house_number') }"/>
                                        
                                    <label class="fieldlabels">Street Number</label> 
                                    <input v-model="form.headoffice_street_number" 
                                        type="text" 
                                        name="headoffice_street_number" 
                                        placeholder="Type Street Number" 
                                        :class="{ 'is-invalid': form.errors.has('headoffice_street_number') }"/>
                                        
                                       
                                    <label class="fieldlabels">City:</label> 
                                    <input v-model="form.headoffice_city" 
                                        type="text" 
                                        name="headoffice_city" 
                                        placeholder="Type City" 
                                        :class="{ 'is-invalid': form.errors.has('headoffice_city') }"/>
                                        
                                    
                                    <label class="fieldlabels">State:</label> 
                                    <input v-model="form.headoffice_state" 
                                        type="text" 
                                        name="headoffice_state" 
                                        placeholder="Type State" 
                                        :class="{ 'is-invalid': form.errors.has('headoffice_state') }"/>
                                    
                                    <label class="fieldlabels">Country:</label> 
                                    <div class="position-relative form-group">
                                        <select v-model="form.headoffice_country"
                                            name="headoffice_country"
                                            class="custom-select" 
                                            :class="{ 'is-invalid': form.errors.has('headoffice_country') }">
                                            <option disabled value="">--Select-- </option>
                                            <option v-for="(country,index) in countries" :value="index">{{country}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12"> 
                                <div class="form-box-outer">
                                    
                                    <h3 style="margin-top:0 !important">Contact</h3>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Email</label> 
                                            <input v-model="form.contact_person_email" 
                                                type="email" 
                                                name="contact_person_email" 
                                                :class="{ 'is-invalid': form.errors.has('contact_person_email') }"/>
                                                 
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Fax:</label> 
                                            <input v-model="form.contact_person_fax_no" 
                                                type="text" 
                                                name="contact_person_fax_no" 
                                                :class="{ 'is-invalid': form.errors.has('contact_person_fax_no') }"/>
                                                
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Phone:</label> 
                                            <input v-model="form.contact_person_cell_phone" 
                                                type="text" 
                                                name="contact_person_cell_phone" 
                                                :class="{ 'is-invalid': form.errors.has('contact_person_cell_phone') }"/>
                                                
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                            <label class="fieldlabels">Website:</label> 
                                            <input v-model="form.contact_person_website" 
                                                type="url" 
                                                name="contact_person_website" 
                                                :class="{ 'is-invalid': form.errors.has('contact_person_website') }"/>
                                                
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr>
                        </div>

                    </div>
                        <div align="center">
                            <button type="submit" 
                                class="btn btn-primary">Next 
                                <i class="fa fa-angle-right"></i></button>
                        </div>
                </div>    
            </div> 			
	    </form>
    </fieldset>

</template>

<style scoped>
    .upload-container {
      border: 2px dashed #ccc;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      position: relative;
    }

    .upload-placeholder {
      color: #999;
    }

    .upload-placeholder.dragging {
      background-color: #f0f8ff;
    }

    .file-input {
      display: none;
    }

    .preview img {
      max-width: 50%;
      height: auto;
      display: block;
      margin: 0 auto 10px;
    }
</style>

<script>
	import {ref} from "vue";
	

	


    export default {
        name:'list-product-categories',
       
        data(){
            return{
            	editmode:false,
				filter: '',
            	form:new Form({
            		
                  	id:'',
                  	legal_name:'',
                  	company_logo_id:null,
                  	headoffice_house_number:'',
                  	headoffice_street_number:'',
                  	headoffice_city:'',
                  	headoffice_state:'',
                  	headoffice_country:'',
                  	contact_person_email:'',
                  	contact_person_fax_no:'',
                  	contact_person_cell_phone:'',
                  	contact_person_website:'',
            	}),
            	account_no:'',
            	countries:'',
                dragging: false,
                photo: null,
                photoUrl: null, 
      
			}
        },
		
		created: function()
        {
        	
            this.user_menu_name = this.$route.name;
            this.fetchCompanyProfile();
           
        },
		
	    methods: {	
            async uploadFile(file) {
                const formData = new FormData();
                formData.append("photo", file);

                try {
                    const response = await axios.post("/upload-photo", formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                    });
                    this.photoUrl = response.data.path;
                    this.photo = file;
                    this.form.company_logo_id=response.data.image_id;
                } catch (error) {
                    showToast('Upload failed.', 'error');
                    console.error(error);
                }
            },
            handleDrop(event) {
                this.dragging = false;
                const file = event.dataTransfer.files[0];
                if (file) this.uploadFile(file);
            },


            handleFileChange(event) {
                const file = event.target.files[0];
                if (file) this.uploadFile(file);
            },

            browseFile() {
                this.$refs.fileInput.click();
            },
            removePhoto() {
                this.photo = null;
                this.photoUrl = null;
            },
            
	        fetchCompanyProfile()
            {
                let uri = '/AccountSetups';
                window.axios.get(uri).then((response) => {
                	this.account_no								=response.data.account_no;
                	this.form.icompany_logo_idd 				= response.data.company_data.company_logo_id;
                    this.form.id                                = response.data.company_data.id;
                    this.photoUrl                               = response.data.company_data.photo_path;

                	this.form.legal_name 						= response.data.company_data.legal_name;

                	this.form.headoffice_house_number 			= response.data.company_data.headoffice_house_number;
                	this.form.headoffice_street_number 			= response.data.company_data.headoffice_street_number;
                	this.form.headoffice_city 					= response.data.company_data.headoffice_city;
                	this.form.headoffice_state 					= response.data.company_data.headoffice_state;
                	this.form.headoffice_state 					= response.data.company_data.headoffice_state;
                	this.form.headoffice_country 				= response.data.company_data.headoffice_country;


                	this.form.contact_person_email 				= response.data.company_data.contact_person_email;
                	this.form.contact_person_fax_no 			= response.data.company_data.contact_person_fax_no;
                	this.form.contact_person_cell_phone 		= response.data.company_data.contact_person_cell_phone;
                	this.form.contact_person_website 			= response.data.company_data.contact_person_website;

                	
                	
                	if(this.form.id){
                		this.editmode=true;
                	}

                	this.countries 								=response.data.country_arr;
                	
                });   
            },

          

            updateCompanyProfile()
            {
            
				
		        this.form.put('/AccountSetups/'+this.form.id)
				    .then(()=>{
					       //success
					     
					   let route = this.$router.resolve({ path: "/Temp-BusinessType" });
                        window.open(route.href,'_self');
                        return;
					
					   
				    })
				    .catch(()=>{
					   
                       showToast('there was some wrong', 'warning');
				
				    });
            },
            
            createCompanyProfile()
            {
            	
        	    this.form.post('/AccountSetups') .then(({ data }) => { 
               
					let route = this.$router.resolve({ path: "/Temp-BusinessType" });
	      			window.open(route.href,'_self');
	      			return;
					
        	    })
            }
	    }
    
    }  
	
</script>