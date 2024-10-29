<style>

  table th, table td {
    padding:0 .25rem !important;
  }

  table tr {
    margin:0 !important;
    padding:0 !important;
  }
  .form-control {
    height: 28px !important;
}
</style>


@extends('layouts.userDashboard')
@section('title', 'Strata Optimizer | Dashboard')
@section('content')
 
    <div class="container-fluid">
        <div class="row">     
          <div class="col-md-12">
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
               role="menu" data-accordion="false" >
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library   3cb306-->
                <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link active" style="width:250px;background-color:#0070C0">
                    
                    <i class="fas fa-building"></i>
                    <p>
                      Company Profile &nbsp; &nbsp;&nbsp;
                        <?php $company_logo=$userCompany->company_logo;  ?>

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" >
                    <fieldset style="width:750px; margin-left:250px;">
                          
                          {!! Form::model($userCompany, ['enctype'=>'multipart/form-data','method' => 'PATCH','route' => ['UserCompanies.update', $userCompany->id]]) !!}


                          <table width="100%" style="font-size:13px; line-height:12px;"> 
                          
                            <tbody>
                            
                              <tr>
                                <td>
                                  <div class="form-lebel" align="right">
                                        Legal Name:
                                  </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input  type="text" name="legal_name" value="{{$userCompany->legal_name}}"  class="form-control" required>
                                        @if ($errors->has('legal_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('legal_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="form-lebel" align="right">
                                        Operational Name:
                                  </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input  type="text" name="operational_name" value="{{$userCompany->operational_name}}" class="form-control" required>
                                        @if ($errors->has('operational_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('operational_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="form-lebel" align="right">
                                        Jurisdiction of incorporation:
                                  </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input  type="text" name="jurisdiction_of_incorporation" value="{{$userCompany->jurisdiction_of_incorporation}}" class="form-control" required>
                                        @if ($errors->has('jurisdiction_of_incorporation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('jurisdiction_of_incorporation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="form-lebel" align="right">
                                        Incorporation Number:
                                  </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input  type="text" name="incorporation_number" value="{{$userCompany->incorporation_number}}" class="form-control" required>
                                        @if ($errors->has('incorporation_number'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('incorporation_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                <td >
                                  <div class="form-lebel" align="right" >
                                    Company Logo
                                  </div>
                                </td>
                                <td>
                                      
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">Upload</span>
                                        </div>
                                        <div class="custom-file">
                                          <input type="hidden" id="company_logo" name="company_logo" value="{{$company_logo}}" > 
                                          <input type="file" class="custom-file-input" value="{{$company_logo}}" name="company_logo_url" id="company_logo_url">
                                          <label class="custom-file-label" for="company_logo_url">Choose file</label>
                                        </div>
                                      </div>
                                </td>
                                <td width="150">
                                      
                                    <div class="form-group">
                                    
                                        <img src="{{$company_logo_url}}" class="img-responsive" height="80" width="100"  > 

                                      
                                    </div>
                                </td>
                              </tr>
                           
                              <tr>
                                <td>
                                  <div class="form-lebel" align="right">
                                        Website:
                                  </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input  type="text" name="website" value="{{$userCompany->website}}" class="form-control" required>
                                        @if ($errors->has('website'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('website') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                              </tr>
                
                            </tbody>
                          </table>
                          <table  class="text-center " style="font-size:13px; line-height:12px;" align="center">
                            <tbody>

                              <tr align="center" style="line-height:30px;">
                                <td colspan="4" align="center">
                                      
                                    <div class="form-group">
                                        <button type="submit" class=" btn btn-secondary" disabled>Save</button>
                                        <button type="submit" class=" btn btn-success " >Update</button>
                                    </div>
                                </td>
                                 
                              </tr>

                            </tbody>

                          </table> 
                           
                           

                          {!! Form::close() !!}
                        
                   </fieldset>
                  </ul>
                </li>
                <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link active" style="width:250px;background-color:#0070C0">
                    
                    <i class="fas fa-venus-double"></i>
                    <p>
                      About Building  &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    
                    <fieldset style="width:750px; margin-left:250px;">

                        {!! Form::model($BuildingInfo, ['enctype'=>'multipart/form-data','method' => 'PATCH','route' => ['BuildingInfos.update', $BuildingInfo->id]]) !!}


                          <table  class="" style="font-size:13px; line-height:12px;">
                            
                            <tbody style="line-height:30px;">
                            
                                <tr>
                                  <td>
                                    <div class="form-level">
                                      Property management type
                                    </div>
                                  </td>
                                  <td>
                                      <div  class="icheck-primary d-inline ml-2">
                                        <input type="checkbox"  name="residential" id="residential" 
                                        @if($BuildingInfo->residential)   value="1" checked
                                         @else  value="0" @endif>
                                        <label for="residential">Residential</label>
                                      </div>
                                  </td>
                                  <td>
                                       <div  class="icheck-primary d-inline ml-2">
                                        <input type="checkbox"  name="commercial" id="commercial" @if($BuildingInfo->commercial)   value="1" checked
                                         @else  value="0" @endif>
                                        <label for="commercial">Commercial</label>
                                    </div>    
                                  </td>
                                  <td>
                                      <div  class="icheck-primary d-inline ml-2">
                                        <input type="checkbox"   name="industrial" id="industrial" @if($BuildingInfo->industrial)   value="1" checked
                                         @else  value="0" @endif>
                                        <label for="industrial">Industrial</label>
                                      </div>
                                  </td>
                                 
                                </tr>
                                <tr>
                                  <td>
                                    <div class="form-level" align="right">
                                      Building Name
                                    </div>
                                  </td>
                                  <td colspan="3">
                                    <div class="form-group">
                                        <input  type="text" name="building_name" value="{{$BuildingInfo->building_name}}"  class="form-control" required>
                                        @if ($errors->has('building_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('building_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td >
                                    <div class="form-lebel" align="right" >
                                      Building Photo
                                    </div>
                                  </td>
                                  <td colspan="2">
                                        
                                      <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text">Upload</span>
                                          </div>
                                          <div class="custom-file">
                                            <input type="hidden" id="building_photo" name="building_photo" value="{{$BuildingInfo->building_photo}}" > 
                                            <input type="file" class="custom-file-input" value="{{$BuildingInfo->building_photo_url}}" name="building_photo_url" id="building_photo_url">
                                            <label class="custom-file-label" for="building_photo_url">Choose file</label>
                                          </div>
                                        </div>
                                  </td>
                                  <td >
                                        
                                      <div class="form-group">
                                      
                                          <img src="{{$building_photo_url}}" class="img-responsive" height="80" width="100"  > 
                                        
                                      </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <div class="form-level" align="right">
                                      Number of Floor
                                    </div>
                                  </td>
                                  <td colspan="3">
                                    <div class="form-group">
                                        <input  type="text" name="number_of_floor" value="{{$BuildingInfo->number_of_floor}}"  class="form-control" required>
                                        @if ($errors->has('number_of_floor'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('number_of_floor') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <div class="form-level" align="right">
                                      Number of Residential Suits
                                    </div>
                                  </td>
                                  <td colspan="3">
                                    <div class="form-group">
                                        <input  type="text" name="number_of_suits" value="{{$BuildingInfo->number_of_suits}}"  class="form-control" required>
                                        @if ($errors->has('number_of_suits'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('number_of_suits') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <div class="form-level" align="right">
                                      Number of Rental Office
                                    </div>
                                  </td>
                                  <td colspan="3">
                                    <div class="form-group">
                                        <input  type="text" name="number_of_rental_office" value="{{$BuildingInfo->number_of_rental_office}}"  class="form-control" required>
                                        @if ($errors->has('number_of_rental_office'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('number_of_rental_office') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <div class="form-level" align="right">
                                      Number of Rental Store
                                    </div>
                                  </td>
                                  <td colspan="3">
                                    <div class="form-group">
                                        <input  type="text" name="number_of_rental_store" value="{{$BuildingInfo->number_of_rental_store}}"  class="form-control" required>
                                        @if ($errors->has('number_of_rental_store'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('number_of_rental_store') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <div class="form-level" align="right">
                                      Number of Parking Stall
                                    </div>
                                  </td>
                                  <td colspan="3">
                                    <div class="form-group">
                                        <input  type="text" name="number_of_parking_stall" value="{{$BuildingInfo->number_of_parking_stall}}"  class="form-control" required>
                                        @if ($errors->has('number_of_parking_stall'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('number_of_parking_stall') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <div class="form-level" align="right">
                                      Number of Storage Locker
                                    </div>
                                  </td>
                                  <td colspan="3">
                                    <div class="form-group">
                                        <input  type="text" name="number_of_storage_locker" value="{{$BuildingInfo->number_of_storage_locker}}"  class="form-control" required>
                                        @if ($errors->has('number_of_storage_locker'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('number_of_storage_locker') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                  </td>
                                </tr>

                            </tbody>
                          </table>
                          <table  class="text-center " style="font-size:13px; line-height:12px;" align="center">
                            <tbody>

                              <tr align="center" style="line-height:30px;">
                                <td colspan="4" align="center">
                                      
                                    <div class="form-group">
                                        <button type="submit" class=" btn btn-secondary " disabled>Save</button>
                                        <button type="submit" class=" btn btn-success" >Update</button>

                                    </div>
                                </td>
                                 
                              </tr>

                            </tbody>

                          </table>
                        {!! Form::close() !!}
                    </fieldset>               
                  </ul>
                </li>
                 <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link active" style="width:250px;background-color:#0070C0">
                    
                    <i class="fas fa-address-book"></i>
                    <p>
                          Contact &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                   <ul class="nav nav-treeview">
                    
                    <fieldset style="width:1150px; margin-left:250px;">
                        <legend style="width:100%;">Addresses and Contacts </legend>

                         <div class="card-body">
                          {!! Form::model($contactInfo, ['method' => 'PATCH','route' => ['AccountContactPersons.update', $contactInfo->id]]) !!}

                            <div class="form-section">
                              
                              
                              <table width="100%" class=" " style="font-size:13px; line-height:12px;">
                                  <thead>

                                    <tr align="center" style="line-height:18px;font-size:15px;">
                                        <th>Particular</th>
                                        <th>Head Office</th>
                                        <th>Authorized Person</th>
                                        <th>Account Payble </th>
                                        <th>Contact Person</th>
                                        <th>System Administrator</th>
                                    </tr>

                                  </thead>
                                  <tbody>
                                      <tr>
                                        <td>
                                          <div class="form-lebel" align="right">
                                              Legal Name:
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="head_office_legal_name" value="{{$contactInfo->head_office_legal_name}}" class="form-control" id="head_office_legal_name" required>
                                            @if ($errors->has('head_office_legal_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('head_office_legal_name') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="authorize_person_legal_name" value="{{$contactInfo->authorize_person_legal_name}}" class="form-control" id="authorize_person_legal_name" required>
                                            @if ($errors->has('authorize_person_legal_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('authorize_person_legal_name') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              <input  type="text" name="account_payable_legal_name" value="{{$contactInfo->account_payable_legal_name}}" class="form-control" id="account_payable_legal_name" required>
                                            @if ($errors->has('account_payable_legal_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_payable_legal_name') }}</strong>
                                                </span>
                                            @endif
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group">
                                              <input  type="text" name="contact_person_legal_name" value="{{$contactInfo->contact_person_legal_name}}" class="form-control" id="contact_person_legal_name" required>
                                            @if ($errors->has('contact_person_legal_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('contact_person_legal_name') }}</strong>
                                                </span>
                                            @endif
                                            </div>
                                        </td>

                                         <td>
                                          <div class="form-group">
                                            <input  type="text" name="system_admin_legal_name" value="{{$contactInfo->system_admin_legal_name}}" class="form-control" id="system_admin_legal_name" required>
                                            @if ($errors->has('system_admin_legal_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('system_admin_legal_name') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        
                                       
                                        
                                      </tr>


                                      <tr>
                                        <td>
                                          <div class="form-lebel" align="right">
                                                Country:
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group">

                                            
                                            {!! Form::select('head_office_country',[null=>"Select Country name"]+ $country_arr,$contactInfo->head_office_country, array('required','id' =>'head_office_country','onchange' => 'change_country_dropdown(this.id,"head_office_provience")','class' => 'form-control')) !!}

                                              @if ($errors->has('head_office_country'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('head_office_country') }}</strong>
                                                  </span>
                                              @endif
              
                                          </div>    
                                        </td>


                                        
                                       
                                        <td>
                                            <div class="form-group">
                                              {!! Form::select('authorize_person_country',[null=>"Select Country name"]+ $country_arr,$contactInfo->authorize_person_country, array('required','id' =>'authorize_person_country','onchange' => 'change_country_dropdown(this.id,"authorize_person_provience")','class' => 'form-control')) !!}

                                              @if ($errors->has('authorize_person_country'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('authorize_person_country') }}</strong>
                                                  </span>
                                              @endif
                                            </div>
                                        </td>
                                        
                                       
                                        
                                        <td>
                                          <div class="form-group">
                                            {!! Form::select('account_payable_country',[null=>"Select Country name"]+ $country_arr,$contactInfo->account_payable_country, array('required','id' =>'account_payable_country','onchange' => 'change_country_dropdown(this.id,"account_payable_provience")','class' => 'form-control')) !!}

                                              @if ($errors->has('account_payable_country'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('account_payable_country') }}</strong>
                                                  </span>
                                              @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              {!! Form::select('contact_person_country',[null=>"Select Country name"]+ $country_arr,$contactInfo->contact_person_country, array('required','id' =>'contact_person_country','onchange' => 'change_country_dropdown(this.id,"contact_person_provience")','class' => 'form-control')) !!}

                                              @if ($errors->has('contact_person_country'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('contact_person_country') }}</strong>
                                                  </span>
                                              @endif
                                            </div>
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            {!! Form::select('system_admin_country',[null=>"Select Country name"]+ $country_arr,$contactInfo->system_admin_country, array('required','id' =>'system_admin_country','onchange' => 'change_country_dropdown(this.id,"system_admin_provience")','class' => 'form-control')) !!}

                                              @if ($errors->has('system_admin_country'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('system_admin_country') }}</strong>
                                                  </span>
                                              @endif
                                          </div>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>
                                          <div class="form-lebel" align="right">
                                                State/ Province:
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            {!! Form::select('head_office_provience',[null=>"Select Provience"]+$head_office_provience_arr,$contactInfo->head_office_provience, array('required','id' =>'head_office_provience','class' => 'form-control')) !!}

                                            @if ($errors->has('head_office_provience'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('head_office_provience') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            {!! Form::select('authorize_person_provience',[null=>"Select Provience"]+$authorize_person_provience_arr,$contactInfo->authorize_person_provience, array('required','id' =>'authorize_person_provience','class' => 'form-control')) !!}

                                            @if ($errors->has('authorize_person_provience'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('authorize_person_provience') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       

                                        
                                       
                                        

                                        <td>
                                          <div class="form-group">
                                            {!! Form::select('account_payable_provience',[null=>"Select Provience"]+$account_payable_provience_arr,$contactInfo->account_payable_provience, array('required','id' =>'account_payable_provience','class' => 'form-control')) !!}

                                            @if ($errors->has('account_payable_provience'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_payable_provience') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              {!! Form::select('contact_person_provience',[null=>"Select Provience"]+$contact_person_provience_arr,$contactInfo->contact_person_provience, array('required','id' =>'contact_person_provience','class' => 'form-control')) !!}

                                              @if ($errors->has('contact_person_provience'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('contact_person_provience') }}</strong>
                                                  </span>
                                              @endif
                                            </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            {!! Form::select('system_admin_provience',[null=>"Select Provience"]+$system_admin_provience_arr,$contactInfo->system_admin_provience, array('required','id' =>'system_admin_provience','class' => 'form-control')) !!}

                                            @if ($errors->has('system_admin_provience'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('system_admin_provience') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>
                                          <div class="form-lebel" align="right">
                                                City:
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="head_office_city" value="{{$contactInfo->head_office_city}}" class="form-control" id="head_office_city" required>
                                            @if ($errors->has('head_office_city'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('head_office_city') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="authorize_person_city" value="{{$contactInfo->authorize_person_city}}" class="form-control" id="authorize_person_city" required>
                                            @if ($errors->has('authorize_person_city'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('authorize_person_city') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="account_payable_city" value="{{$contactInfo->account_payable_city}}" class="form-control" id="account_payable_city" required>
                                            @if ($errors->has('account_payable_city'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_payable_city') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              <input  type="text" name="contact_person_city" value="{{$contactInfo->contact_person_city}}" class="form-control" id="contact_person_city" required>
                                            @if ($errors->has('contact_person_city'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('contact_person_city') }}</strong>
                                                </span>
                                            @endif
                                            </div>
                                        </td>

                                         <td>
                                          <div class="form-group">
                                            <input  type="text" name="system_admin_city" value="{{$contactInfo->system_admin_city}}" class="form-control" id="system_admin_city" required>
                                            @if ($errors->has('system_admin_city'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('system_admin_city') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                      </tr>


                                      <tr>
                                        <td>
                                          <div class="form-lebel" align="right">
                                                Street Number / Name:
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="head_office_street_no" value="{{$contactInfo->head_office_street_no}}" class="form-control" id="head_office_street_no" required>
                                            @if ($errors->has('head_office_street_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('head_office_street_no') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="authorize_person_street_no" value="{{$contactInfo->authorize_person_street_no}}" class="form-control" id="authorize_person_street_no" required>
                                            @if ($errors->has('authorize_person_street_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('authorize_person_street_no') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>


                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="account_payable_street_no" value="{{$contactInfo->account_payable_street_no}}" class="form-control" id="account_payable_street_no" required>
                                            @if ($errors->has('account_payable_street_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_payable_street_no') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              <input  type="text" name="contact_person_street_no" value="{{$contactInfo->contact_person_street_no}}" class="form-control" id="contact_person_street_no" required>
                                              @if ($errors->has('contact_person_street_no'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('contact_person_street_no') }}</strong>
                                                  </span>
                                              @endif
                                            </div>
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="system_admin_street_no" value="{{$contactInfo->system_admin_street_no}}" class="form-control" id="system_admin_street_no" required>
                                            @if ($errors->has('system_admin_street_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('system_admin_street_no') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>
                                          <div class="form-lebel" align="right">
                                                Postal Code:
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="head_office_postal_code" value="{{$contactInfo->head_office_postal_code}}" class="form-control" id="head_office_postal_code" required>
                                            @if ($errors->has('head_office_postal_code'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('head_office_postal_code') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="authorize_person_postal_code" value="{{$contactInfo->authorize_person_postal_code}}" class="form-control" id="authorize_person_postal_code" required>
                                            @if ($errors->has('authorize_person_postal_code'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('authorize_person_postal_code') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="account_payable_postal_code" value="{{$contactInfo->account_payable_postal_code}}" class="form-control" id="account_payable_postal_code" required>
                                            @if ($errors->has('account_payable_postal_code'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_payable_postal_code') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              <input  type="text" name="contact_person_postal_code" value="{{$contactInfo->contact_person_postal_code}}" class="form-control" id="contact_person_postal_code" required>
                                              @if ($errors->has('contact_person_postal_code'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('contact_person_postal_code') }}</strong>
                                                  </span>
                                              @endif
                                            </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="system_admin_postal_code" value="{{$contactInfo->system_admin_postal_code}}" class="form-control" id="system_admin_postal_code" required>
                                            @if ($errors->has('system_admin_postal_code'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('system_admin_postal_code') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <div class="form-lebel" align="right">
                                                P.O Box:
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="head_office_po_box" value="{{$contactInfo->head_office_po_box}}" class="form-control" id="head_office_po_box" required>
                                            @if ($errors->has('head_office_po_box'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('head_office_po_box') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="authorize_person_po_box" value="{{$contactInfo->authorize_person_po_box}}" class="form-control" id="authorize_person_po_box" required>
                                            @if ($errors->has('authorize_person_po_box'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('authorize_person_po_box') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="account_payable_po_box" value="{{$contactInfo->account_payable_po_box}}" class="form-control" id="account_payable_po_box" required>
                                            @if ($errors->has('account_payable_po_box'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_payable_po_box') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              <input  type="text" name="contact_person_po_box" value="{{$contactInfo->contact_person_po_box}}" class="form-control" id="contact_person_po_box" required>
                                              @if ($errors->has('contact_person_po_box'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('contact_person_po_box') }}</strong>
                                                  </span>
                                              @endif
                                            </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="system_admin_po_box" value="{{$contactInfo->system_admin_po_box}}" class="form-control" id="system_admin_po_box" required>
                                            @if ($errors->has('system_admin_po_box'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('system_admin_po_box') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <div class="form-lebel" align="right">
                                              Business No:
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="head_office_bussiness_no" value="{{$contactInfo->head_office_bussiness_no}}" class="form-control" id="head_office_bussiness_no" required>
                                            @if ($errors->has('head_office_bussiness_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('head_office_bussiness_no') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="authorize_person_bussiness_no" value="{{$contactInfo->authorize_person_bussiness_no}}" class="form-control" id="authorize_person_bussiness_no" required>
                                            @if ($errors->has('authorize_person_bussiness_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('authorize_person_bussiness_no') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="account_payable_bussiness_no" value="{{$contactInfo->account_payable_bussiness_no}}" class="form-control" id="account_payable_bussiness_no" required>
                                            @if ($errors->has('account_payable_bussiness_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_payable_bussiness_no') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              <input  type="text" name="contact_person_bussiness_no" value="{{$contactInfo->contact_person_bussiness_no}}" class="form-control" id="contact_person_bussiness_no" required>
                                              @if ($errors->has('contact_person_bussiness_no'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('contact_person_bussiness_no') }}</strong>
                                                  </span>
                                              @endif
                                            </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="system_admin_bussiness_no" value="{{$contactInfo->system_admin_bussiness_no}}" class="form-control" id="system_admin_bussiness_no" required>
                                            @if ($errors->has('system_admin_bussiness_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('system_admin_bussiness_no') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <div class="form-lebel" align="right">
                                              Office Phone:
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="head_office_office_phone" value="{{$contactInfo->head_office_office_phone}}" class="form-control" id="head_office_office_phone" required>
                                            @if ($errors->has('head_office_office_phone'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('head_office_office_phone') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="authorize_person_office_phone" value="{{$contactInfo->authorize_person_office_phone}}" class="form-control" id="authorize_person_office_phone" required>
                                            @if ($errors->has('authorize_person_office_phone'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('authorize_person_office_phone') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        
                                        <td>
                                       
                                       
                                          <div class="form-group">
                                            <input  type="text" name="account_payable_office_phone" value="{{$contactInfo->account_payable_office_phone}}" class="form-control" id="account_payable_office_phone" required>
                                            @if ($errors->has('account_payable_office_phone'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_payable_office_phone') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              <input  type="text" name="contact_person_office_phone" value="{{$contactInfo->contact_person_office_phone}}" class="form-control" id="contact_person_office_phone" required>
                                              @if ($errors->has('contact_person_office_phone'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('contact_person_office_phone') }}</strong>
                                                  </span>
                                              @endif
                                            </div>
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="system_admin_office_phone"value="{{$contactInfo->system_admin_office_phone}}" class="form-control" id="system_admin_office_phone" required>
                                            @if ($errors->has('system_admin_office_phone'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('system_admin_office_phone') }}</strong>
                                                </span>
                                            @endif
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
                                            <input  type="text" name="head_office_cell_phone" value="{{$contactInfo->head_office_cell_phone}}" class="form-control" id="head_office_cell_phone" required>
                                            @if ($errors->has('head_office_cell_phone'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('head_office_cell_phone') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="authorize_person_cell_phone" value="{{$contactInfo->authorize_person_cell_phone}}" class="form-control" id="authorize_person_cell_phone" required>
                                            @if ($errors->has('authorize_person_cell_phone'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('authorize_person_cell_phone') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        
                                        
                                       
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="account_payable_cell_phone" value="{{$contactInfo->account_payable_cell_phone}}" class="form-control" id="account_payable_cell_phone" required>
                                            @if ($errors->has('account_payable_cell_phone'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_payable_cell_phone') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              <input  ty value="{{$contactInfo->contact_person_cell_phone}}" class="form-control" id="contact_person_cell_phone" required>
                                              @if ($errors->has('contact_person_cell_phone'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('contact_person_cell_phone') }}</strong>
                                                  </span>
                                              @endif
                                            </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="system_admin_cell_phone" value="{{$contactInfo->system_admin_cell_phone}}" class="form-control" id="system_admin_cell_phone" required>
                                            @if ($errors->has('system_admin_cell_phone'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('system_admin_cell_phone') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>

                                      </tr>

                                      <tr>
                                        <td>
                                          <div class="form-lebel" align="right">
                                              Fax:
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="head_office_fax_no" value="{{$contactInfo->head_office_fax_no}}" class="form-control" id="head_office_fax_no" required>
                                            @if ($errors->has('head_office_fax_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('head_office_fax_no') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="authorize_person_fax_no" value="{{$contactInfo->authorize_person_fax_no}}" class="form-control" id="authorize_person_fax_no" required>
                                            @if ($errors->has('authorize_person_fax_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('authorize_person_fax_no') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        
                                       
                                        
                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="account_payable_fax_no" value="{{$contactInfo->account_payable_fax_no}}" class="form-control" id="account_payable_fax_no" required>
                                            @if ($errors->has('account_payable_fax_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_payable_fax_no') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              <input  type="text" name="contact_person_fax_no" value="{{$contactInfo->contact_person_fax_no}}" class="form-control" id="contact_person_fax_no" required>
                                              @if ($errors->has('contact_person_fax_no'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('contact_person_fax_no') }}</strong>
                                                  </span>
                                              @endif
                                            </div>
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="text" name="system_admin_fax_no" value="{{$contactInfo->system_admin_fax_no}}" class="form-control" id="system_admin_fax_no" required>
                                            @if ($errors->has('system_admin_fax_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('system_admin_fax_no') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <div class="form-lebel" align="right">
                                              Website:
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="url" name="head_office_website" value="{{$contactInfo->head_office_website}}" class="form-control" id="head_office_website" required>
                                            @if ($errors->has('head_office_website'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('head_office_website') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="url" name="authorize_person_website" value="{{$contactInfo->authorize_person_website}}" class="form-control" id="authorize_person_website" required>
                                            @if ($errors->has('authorize_person_website'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('authorize_person_website') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        
                                        <td>
                                          <div class="form-group">
                                            <input  type="url" name="account_payable_website" value="{{$contactInfo->account_payable_website}}" class="form-control" id="account_payable_website" required>
                                            @if ($errors->has('account_payable_website'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_payable_website') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              <input  type="url" name="contact_person_website" value="{{$contactInfo->contact_person_website}}" class="form-control" id="contact_person_website" required>
                                              @if ($errors->has('contact_person_website'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('contact_person_website') }}</strong>
                                                  </span>
                                              @endif
                                            </div>
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="url" name="system_admin_website" value="{{$contactInfo->system_admin_website}}" class="form-control" id="system_admin_website" required>
                                            @if ($errors->has('system_admin_website'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('system_admin_website') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                      </tr>
                                       <tr>
                                        <td>
                                          <div class="form-lebel" align="right">
                                              Email:
                                          </div>
                                        </td>
                                        <td>
                                          <div class="form-group">
                                            <input  type="email" name="head_office_email" value="{{$contactInfo->head_office_email}}" class="form-control" id="head_office_email" required>
                                            @if ($errors->has('head_office_email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('head_office_email') }}</strong>
                                                </span>
                                            @endif
                                          </div>    
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="email" name="authorize_person_email" value="{{$contactInfo->authorize_person_email}}" class="form-control" id="authorize_person_email" required>
                                            @if ($errors->has('authorize_person_email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('authorize_person_email') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        
                                        <td>
                                          <div class="form-group">
                                            <input  type="email" name="account_payable_email" value="{{$contactInfo->account_payable_email}}" class="form-control" id="account_payable_email" required>
                                            @if ($errors->has('account_payable_email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_payable_email') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                       
                                        <td>
                                            <div class="form-group">
                                              <input  type="email" name="contact_person_email" value="{{$contactInfo->contact_person_email}}" class="form-control" id="contact_person_email" required>
                                              @if ($errors->has('contact_person_email'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('contact_person_email') }}</strong>
                                                  </span>
                                              @endif
                                            </div>
                                        </td>

                                        <td>
                                          <div class="form-group">
                                            <input  type="email" name="system_admin_email" value="{{$contactInfo->system_admin_email}}" class="form-control" id="system_admin_email" required>
                                            @if ($errors->has('system_admin_email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('system_admin_email') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                        </td>
                                      </tr>
                                  </tbody>
                                 </table>
                                <table  class="text-center " style="font-size:13px; line-height:12px;" align="center">
                                  <tbody>

                                    <tr align="center" style="line-height:30px;">
                                      <td colspan="4" align="center">
                                            
                                          <div class="form-group">
                                              <button type="submit" class=" btn btn-secondary" disabled>Save</button>
                                              <button type="submit" class=" btn btn-success" >Update</button>
                                          </div>
                                      </td>
                                       
                                    </tr>

                                  </tbody>

                                </table> 
                                
                            </div>
                           
                          {!! Form::close() !!}
                        </div>
                    </fieldset>               
                  </ul>
                </li>
                <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link active" style="width:250px;background-color:#0070C0">
                    
                    <i class="fab fa-think-peaks"></i>
                    <p>
                      Service Plans  &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                   <ul class="nav nav-treeview">
                      
                       <fieldset style="width:1200px; margin-left:250px;">
                         
                          {!! Form::model($user_service_plan_mst, ['enctype'=>'multipart/form-data','method' => 'PATCH','route' => ['UserServicePlans.update', $user_service_plan_mst->id]]) !!}


                          <table  class="table table-bordered" style="font-size:16px; line-height:25px;"
                          id="service_plan_table">
                            <thead style="line-height:30px;">

                              
                              <tr align="center" >
                                  <th  width="250" rowspan="3" style="vertical-align:center">
                                    <div class="form-group">
                                        <label for="servicePlanMonthly" id="servicePlanMonthly" class="montly_enable">Monthly</label>
                                        <label class="switch">

                                          <input type="checkbox" id="servicePlanMonthlyYearly"
                                          onclick="enable_monthly_yearly()"
                                          name="servicePlanMonthlyYearly" value="{{$user_service_plan_mst->service_plan_type}}" <?php if($user_service_plan_mst->service_plan_type==1) echo "checked"; ?> >

                                          <span class="btnonof round"></span>
                                        </label>
                                        <label for="servicePlanYearly" id="servicePlanYearly" class="yearly_disable">Yearly</label>
                                          <input type="hidden" id="service_plan_type" name="service_plan_type" value="{{$user_service_plan_mst->service_plan_type}}" >
                                    </div>
                                   </th>
                                 
                                  <th colspan="3" bgcolor="#2F75B5" style="vertical-align:middle;color:#fff">Strata Management</th>
                                  <th colspan="3" bgcolor="#2F7512" style="vertical-align:middle;color:#fff">Leaseholding <br/> Property Management </th>
                                  <th colspan="3" bgcolor="#2F75B5" style="vertical-align:middle;color:#fff">Owner Operator</th>
                              </tr>
                              <tr align="center" >
                                  <th colspan="3" bgcolor="#2F75B5" style="color:#fff">

                                     <div  class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="{{$user_service_plan_mst->strata_management}}" name="plan_a" id="plan_a"
                                        onclick="plan_checked('plan_a')" <?php if($user_service_plan_mst->strata_management==1) echo "checked"; ?>>
                                        <label for="plan_a"> Plan A</label>
                                        <input type="hidden" id="strata_management" name="strata_management" value="{{$user_service_plan_mst->strata_management}}" >
                                      </div>
                                   </th>
                                  <th colspan="3" bgcolor="#2F7512" style="color:#fff">
                                    <div  class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="{{$user_service_plan_mst->leaseholding_management}}" name="plan_b" id="plan_b"
                                        onclick="plan_checked('plan_b')" <?php if($user_service_plan_mst->leaseholding_management==1) echo "checked"; ?>>
                                        <label for="plan_b">Plan B</label>
                                        <input type="hidden" id="leaseholding_management" name="leaseholding_management" value="{{$user_service_plan_mst->leaseholding_management}}" >
                                    </div>
                                  </th>
                                  <th colspan="3" bgcolor="#2F75B5" style="color:#fff">
                                    <div  class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="{{$user_service_plan_mst->owner_operator}}" name="plan_c" id="plan_c"
                                        onclick="plan_checked('plan_c')" <?php if($user_service_plan_mst->owner_operator==1) echo "checked"; ?>>
                                        <label for="plan_c">Plan C</label>
                                        <input type="hidden" id="owner_operator" name="owner_operator" value="{{$user_service_plan_mst->owner_operator}}" >
                                    </div> 
                                  </th>
                               
                                 
                              </tr>
                              <tr >
                                  <th bgcolor="#aaa" style="color:#fff;text-align:center">Qty</th>
                                  <th bgcolor="#aaa" style="color:#fff;text-align:center">Rate</th>
                                  <th bgcolor="#aaa" style="color:#fff;text-align:center">Amount</th>
                                  <th bgcolor="#7F933F" style="color:#fff;text-align:center" >Qty</th>
                                  <th bgcolor="#7F933F" style="color:#fff;text-align:center" >Rate</th>
                                  <th bgcolor="#7F933F" style="color:#fff;text-align:center" >Amount</th>
                                  <th bgcolor="#aaa" style="color:#fff;text-align:center">Qty</th>
                                  <th bgcolor="#aaa" style="color:#fff;text-align:center">Rate</th>
                                  <th bgcolor="#aaa" style="color:#fff;text-align:center">Amount</th>
                              </tr>
                            

                            </thead>
                            <tbody>
                            
                              <?php $ASL=0;  ?>

                              @foreach($master_plan_arr as $mid=>$mvalue)

                              @if(!empty($lavel_one_plan_arr[$mid]))
                                  <tr align="center" style="cursor:pointer" id="tr_{{$mid}}"
                                   onclick="display_child_row({{$mid}},{{count($lavel_one_plan_arr[$mid])}})" >
                                    <td align="left">
                                @else

                                <tr align="center" id="tr_{{$mid}}" >
                                  @if($mvalue['position']==1)
                                    <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                  @else
                                    <td align="left" bgcolor="#808000" style="color:#000;vertical-align:middle;"> 
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!-- B4C6E7 E1D966 -->
                                  @endif
                                @endif
                               
                                   
                                    <strong>{{$mvalue['plan_name']}}</strong>
                                    <input type="hidden" id="plan_id_{{$mid}}" name="plan_id_{{$mid}}" value="{{$mid}}">
                                    <input type="hidden" id="amount_applicable_{{$mid}}" name="amount_applicable_{{$mid}}" value="{{$mvalue['amount_applicable']}}">
                                    <input type="hidden" id="rate_applicable_{{$mid}}" name="rate_applicable_{{$mid}}" value="{{$mvalue['rate_applicable']}}">
                                   
                                    @if($mvalue['amount_applicable']==0)
                                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      <i  class=" right fas fa-angle-down"></i>
                                      
                                    @endif
                                    
                                  </td>

                                 
                                  @if($mvalue['amount_applicable']==1)
                                       <?php $ASL++;  ?>
                                     <input type="hidden" id="active_plan_id_{{$ASL}}" name="active_plan_id[]" value="{{$mid}}">
                                     <input type="hidden" id="plan_update_id_{{$mid}}" name="plan_update_id_{{$mid}}" value="{{$user_service_plan_arr[$mid]['id']}}">
                                     @if($mvalue['rate_applicable']==1)
                                       
                                       <td width="100" bgcolor="#aaa"> 
                                          <div class="form-group">
                                              <input  type="text" name="qty_a_{{$mid}}" value="{{$user_service_plan_arr[$mid]['qty_a']}}" style="text-align:right" onkeyup="amount_calculate('plan_a',{{$mid}})" 
                                              class="form-control" id="qty_a_{{$mid}}"  placeholder="Quantity" <?php if($user_service_plan_mst->strata_management!=1) echo "readonly"; ?>>
                                          </div>

                                      </td>
                                      <td width="100" bgcolor="#aaa" > 
                                          <div class="form-group">
                                              <input  type="text" name="rate_a_{{$mid}}" style="text-align:right"  value="{{$mvalue['rate_a']}}" class="form-control"
                                               id="rate_a_{{$mid}}" placeholder="Rate" readonly>
                                             
                                            </div>
                                       </td>
                                      <td width="100" bgcolor="#aaa">
                                          <div class="form-group">
                                              <input  type="text" name="plan_a_{{$mid}}" style="text-align:right"  value="{{$user_service_plan_arr[$mid]['amount_a']}}" class="form-control"
                                               id="plan_a_{{$mid}}" placeholder="Amount" readonly>
                                             
                                          </div>
                                      </td>
                                      
                                       <td width="100" bgcolor="#7F933F"> 
                                          <div class="form-group">
                                              <input  type="text" name="qty_b_{{$mid}}"style="text-align:right" style="text-align:right"
                                               onkeyup="amount_calculate('plan_b',{{$mid}})" value="{{$user_service_plan_arr[$mid]['qty_b']}}" class="form-control"
                                                id="qty_b_{{$mid}}" placeholder="Quantity" <?php if($user_service_plan_mst->leaseholding_management!=1) echo "readonly"; ?>>
                                             
                                          </div>

                                      </td>
                                      <td width="100" bgcolor="#7F933F"> 
                                          <div class="form-group">
                                              <input  type="text" name="rate_b_{{$mid}}" style="text-align:right" value="{{$mvalue['rate_b']}}" 
                                              class="form-control" id="rate_b_{{$mid}}" placeholder="Rate" readonly>
                                            </div>
                                       </td>
                                      <td width="100" bgcolor="#7F933F">
                                          <div class="form-group">
                                              <input  type="text" name="plan_b_{{$mid}}" style="text-align:right" value="{{$user_service_plan_arr[$mid]['amount_b']}}" style="text-align:right" class="form-control" id="plan_b_{{$mid}}" placeholder="Amount" readonly>
                                             
                                          </div>
                                      </td>
                                      <td width="100" bgcolor="#aaa"> 
                                          <div class="form-group">
                                              <input  type="text" name="qty_c_{{$mid}}" style="text-align:right" onkeyup="amount_calculate('plan_c',{{$mid}})" 
                                              value="{{$user_service_plan_arr[$mid]['qty_c']}}" class="form-control" id="qty_c_{{$mid}}" placeholder="Quantity" 
                                              <?php if($user_service_plan_mst->owner_operator!=1) echo "readonly"; ?>>
                                             
                                            </div>

                                      </td>
                                      <td width="100" bgcolor="#aaa"> 
                                          <div class="form-group">
                                              <input  type="text" name="rate_c_{{$mid}}" style="text-align:right" value="{{$mvalue['rate_c']}}" class="form-control" id="rate_c_{{$mid}}" placeholder="Rate" readonly>
                                             
                                            </div>
                                       </td>
                                       
                                      <td width="100" bgcolor="#aaa">
                                          <div class="form-group">
                                              <input  type="text" name="plan_c_{{$mid}}" style="text-align:right" value="{{$user_service_plan_arr[$mid]['amount_c']}}" class="form-control" id="plan_c_{{$mid}}" placeholder="Amount" readonly>
                                          </div>
                                      </td>
                                     @else
                                     
                                      <td colspan="2" align="right" bgcolor="#aaa">
                                        <div class="icheck-primary d-inline ml-2">
                                          <input  name="check_a_{{$mid}}" type="checkbox"  value="{{$user_service_plan_arr[$mid]['is_check_a']}}" id="check_a_{{$mid}}"
                                            onclick="check_amount_row('plan_a',{{$mid}})" <?php if($user_service_plan_arr[$mid]['is_check_a']==1) echo "checked"; ?>
                                            <?php if($user_service_plan_mst->strata_management!=1) echo "disabled"; ?>>
                                           <label class="form-check-label" for="check_a_{{$mid}}">
                                            <strong> </strong>
                                          </label>
                                          <input  name="is_check_a_{{$mid}}" type="hidden"  value="{{$user_service_plan_arr[$mid]['is_check_a']}}" id="is_check_a_{{$mid}}">
                                        </div>
                                        
                                      </td>
                                      <td width="100" bgcolor="#aaa">
                                          <div class="form-group">
                                              <input  type="text" name="plan_a_{{$mid}}" style="text-align:right" value="{{$mvalue['plan_a']}}" class="form-control" id="plan_a_{{$mid}}" placeholder="Amount" readonly>
                                          </div>
                                      </td>


                                      <td colspan="2" align="right" bgcolor="#7F933F">
                                        <div class="icheck-primary d-inline ml-2">
                                          <input  name="check_b_{{$mid}}" type="checkbox" 
                                          value="{{$user_service_plan_arr[$mid]['is_check_b']}}" id="check_b_{{$mid}}"
                                          onclick="check_amount_row('plan_b',{{$mid}})" 
                                          <?php if($user_service_plan_arr[$mid]['is_check_b']==1) echo "checked"; ?>
                                          <?php if($user_service_plan_mst->leaseholding_management!=1) echo "disabled"; ?>>
                                           <label class="form-check-label" for="check_b_{{$mid}}">
                                            <strong> </strong>
                                          </label>
                                          <input  name="is_check_b_{{$mid}}" type="hidden"  value="{{$user_service_plan_arr[$mid]['is_check_b']}}" id="is_check_b_{{$mid}}">
                                        </div>
                                        
                                      </td>
                                      <td width="100" bgcolor="#7F933F">
                                          <div class="form-group">
                                              <input  type="text" name="plan_b_{{$mid}}" style="text-align:right" value="{{$mvalue['plan_b']}}" class="form-control" id="plan_b_{{$mid}}" placeholder="Amount" readonly>
                                          </div>
                                      </td>


                                      <td colspan="2" align="right" bgcolor="#aaa">
                                        <div class="icheck-primary d-inline ml-2">
                                          <input  name="check_c_{{$mid}}" type="checkbox" value="{{$user_service_plan_arr[$mid]['is_check_c']}}" id="check_c_{{$mid}}"
                                             onclick="check_amount_row('plan_c',{{$mid}})" 
                                             <?php if($user_service_plan_arr[$mid]['is_check_c']==1) echo "checked"; ?>
                                             <?php if($user_service_plan_mst->owner_operator!=1) echo "disabled"; ?>>
                                           <label class="form-check-label" for="check_c_{{$mid}}">
                                            <strong> </strong>
                                          </label>
                                          <input  name="is_check_c_{{$mid}}" type="hidden"  value="{{$user_service_plan_arr[$mid]['is_check_c']}}" id="is_check_c_{{$mid}}">
                                        </div>
                                        
                                      </td>
                                      <td width="100" bgcolor="#aaa">
                                          <div class="form-group">
                                              <input  type="text" name="plan_c_{{$mid}}" style="text-align:right" value="{{$mvalue['plan_c']}}" class="form-control" id="plan_c_{{$mid}}" placeholder="Amount" readonly>
                                          </div>
                                      </td>
                                    @endif  
                                  @else
                                    <td colspan="3"></td>
                                    <td colspan="3"> </td>
                                    <td colspan="3"></td>
                                  @endif
                                </tr>


                               
                              @endforeach
                                
                               
                                
                            </tbody>
                            <tfoot align="center">
                              <tr id="monthly_total">
                                <th  width="250"> Monthly Total
                                </th>
                                <th width="200" colspan="2" > 
                                          

                                </th>
                                <th width="100">
                                    <div class="form-group">
                                        <input  type="text" name="monthly_total_strata_management"  value="{{$user_service_plan_mst->monthly_total_strata_management}}" class="form-control" 
                                        id="monthly_total_strata_management" style="text-align:right" placeholder="Total Amount" readonly>
                                    </div>
                                </th>
                                <th width="200" colspan="2"></th>
                               
                                <th width="100" >
                                  <div class="form-group">
                                    <input type="text" id="monthly_total_leaseholding_management"   style="text-align:right" class="form-control" name="monthly_total_leaseholding_management"
                                     value="{{$user_service_plan_mst->monthly_total_leaseholding_management}}" placeholder="Total Amount" readonly/>
                                  </div>
                                </th>
                                <th width="200" colspan="2"></th>
                               
                                <th width="100">
                                  <div class="form-group">
                                    <input type="text" id="monthly_total_owner_operator" style="text-align:right" class="form-control"
                                     name="monthly_total_owner_operator" value="{{$user_service_plan_mst->monthly_total_owner_operator}}" 
                                    placeholder="Total Amount" readonly/>
                                  </div>
                                </th>
                              </tr>
                              <tr id="yearly_total_gess">
                                <th> <del>Yearly Total</del></th>
                                <th colspan="2"><del></del></th>
                                <th align="right"><del>{{$user_service_plan_mst->yearly_total_strata_management*100/80}}</del></th>
                                <th colspan="2"><del></del></th>
                                <th align="right"><del>{{$user_service_plan_mst->yearly_total_leaseholding_management*100/80}}</del></th>
                                <th colspan="2"><del></del></th>
                                <th align="right"><del>{{$user_service_plan_mst->yearly_total_owner_operator*100/80}}</del></th>
                                
                              </tr>
                              <tr id="monthly_total">
                                <th  width="250"> Yearly Total (20% off)
                                </th>
                                <th width="200" colspan="2" > 
                                          

                                </th>
                                <th width="100">
                                    <div class="form-group">
                                        <input  type="text" name="yearly_total_strata_management" style="text-align:right" value="{{$user_service_plan_mst->yearly_total_strata_management}}" class="form-control" 
                                        id="yearly_total_strata_management" placeholder="Total Amount" readonly>
                                       
                                    </div>
                                </th>
                                <th width="200" colspan="2"></th>
                               
                                <th width="100" >
                                  <div class="form-group">
                                    <input type="text" id="yearly_total_leaseholding_management" style="text-align:right" class="form-control" name="yearly_total_leaseholding_management"
                                     value="{{$user_service_plan_mst->yearly_total_leaseholding_management}}" placeholder="Total Amount" readonly/>
                                  </div>
                                </th>
                                <th width="200" colspan="2"></th>
                               
                                <th width="100">
                                  <div class="form-group">
                                    <input type="text" id="yearly_total_owner_operator" style="text-align:right" class="form-control" 
                                    name="yearly_total_owner_operator" value="{{$user_service_plan_mst->yearly_total_owner_operator}}" 
                                    placeholder="Total Amount" readonly/>
                                  </div>
                                </th>
                              </tr>
                              
                            </tfoot>
                          </table>
                          <table  class="text-center " style="font-size:13px; line-height:12px;" align="center">
                              <tbody>

                                <tr align="center" style="line-height:30px;">
                                  <td colspan="4" align="center">
                                        
                                      <div class="form-group">
                                          <button type="submit" class=" btn btn-secondary" disabled>Save</button>
                                          <button type="submit" class=" btn btn-success"  >Update</button>
                                      </div>
                                  </td>
                                   
                                </tr>

                              </tbody>

                          </table>

                      </fieldset> 
                    </ul>
                </li>
               
               
                <li class="nav-item has-treeview menu-open">
             
                  <a href="#" class="nav-link active" style="width:250px;;background-color:#0070C0">
                    
                    <i class="fas fa-file-signature"></i>
                    <p>
                      Service Contract &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                      
                       <fieldset style="width:1200px; margin-left:250px;">
                         <legend>Service Contract is Signed Between</legend>
                          {!! Form::open(array('class' => 'contact-form','route' => 'userServiceContacts.store','method'=>'POST')) !!}



                          <table  class="table table-bordered" style="font-size:16px; line-height:25px;"
                          id="service_plan_table">
                            <thead style="line-height:30px;">
                             
                              <tr align="center" >
                                 <th colspan="2" bgcolor="#2F75B5" style="color:#fff; width:50%;font-size:24px">
                                    <strong>Service Provider Info</strong>
                                  </th>
                                  
                                  <th colspan="2" bgcolor="#2F7512" style="color:#fff;font-size:24px">
                                    <strong>Customer Info</strong>
                                  </th> 
                                 
                              </tr>
                            </thead>
                            <tbody>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Person Name:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <input 
                                            type="text" 
                                            name="sp_person_name"
                                            id="sp_person_name" 
                                            placeholder="Person Name" 
                                            class="form-control">
                                    
                                        </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Person Name:</strong>
                              
                                  </td>
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                          <input 
                                            type="text" 
                                            name="customer_person_name"
                                            id="customer_person_name" 
                                            placeholder="Person Name" 
                                            class="form-control">
                                    
                                        </div>
                                </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Position:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <div class="form-group">
                                            <input 
                                              type="text" 
                                              name="sp_position"
                                              id="sp_position" 
                                              placeholder="Position" 
                                              class="form-control" 
                                              >
                                          </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Position:</strong>
                              
                                  </td>
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="customer_position"
                                          id="customer_position" 
                                          placeholder="Position" 
                                          class="form-control" 
                                          >
                                      </div>
                                </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Company Legal Name:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <input 
                                                type="text" 
                                                name="sp_legal_name" 
                                                placeholder="Company Legal Name"
                                        
                                                class="form-control">
                                        </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Company Legal Name:</strong>
                              
                                  </td>
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                       <div class="form-group">
                                          <input 
                                            type="text" 
                                            name="customer_legal_name" 
                                            placeholder="Company Legal Name"
                                    
                                            class="form-control">
                                        </div>
                                </td>

                              </tr>

                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Company register Country:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <select 
                                              name="sp_reg_country_id" 
                                              id="sp_reg_country_id"
                                              value=""
                                              onchange="load_country_corresponding_data()"
                                              class="form-control" >
                                              <option disabled value="">--Select Country-- </option>
                                      
                                            </select>
                                        </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Company register Country:</strong>
                              
                                  </td>
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <select 
                                            name="customer_reg_country_id" 
                                            id="customer_reg_country_id"
                                            value=""
                                            onchange="load_country_corresponding_data()"
                                            class="form-control" >
                                            <option disabled value="">--Select Country-- </option>
                                    
                                          </select>
                                      </div>
                                </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Company Register Province:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <select 
                                            name="sp_reg_province_id" 
                                            id="sp_reg_province_id"
                                            value=""
                                            class="form-control" >
                                            <option disabled value="">--Select Province-- </option>
                                    
                                          </select>
                                        </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Company Register Province:</strong>
                              
                                  </td>
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                          <select 
                                            name="customer_reg_province_id" 
                                            id="customer_reg_province_id"
                                            value=""
                                            class="form-control" >
                                            <option disabled value="">--Select Province-- </option>
                                    
                                          </select>
                                        </div>
                                </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Company Register City:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <input
                                            type="text" 
                                            name="sp_reg_city"
                                            id="sp_reg_city"
                                            Placeholder="Company Register City" class="form-control">
                                        </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Company Register City:</strong>
                              
                                  
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                          <input
                                            type="text" 
                                            name="customer_reg_city"
                                            id="customer_reg_city"
                                            Placeholder="Company Register City" class="form-control">
                                        </div>
                                </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Government Business No.:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <input
                                            type="text" 
                                            name="sp_govt_business_no" 
                                            id="sp_govt_business_no"
                                            Placeholder="Government Business No."
                                            class="form-control" >
                                      </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Government Business No.:</strong>
                              
                                
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <input
                                          type="text" 
                                          name="customer_govt_business_no" 
                                          id="customer_govt_business_no"
                                          Placeholder="Government Business No."
                                          class="form-control" >
                                        </div>
                                </td>

                              </tr>
                              <tr>
                                       
                                <td colspan="2"  bgcolor="#0070C0" style="color:white; font-size: 24px; ">
                                  <div class="form-lebel" align="center">
                                       <strong> Head Office</strong>
                                    </div>
                                </td>
                                <td colspan="2"  bgcolor="#2F7512" style="color:white; font-size: 24px; ">
                                  <div class="form-lebel" align="center">
                                       <strong> Head Office</strong>
                                    </div>
                                </td>  
                                                                   
                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Country:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa" style="vertical-align:middle">
                                      <div class="form-group">
                                          <div class="form-group">
                                           
                                              {!! Form::select('sp_country_id',[null=>"Select Country name"]+ $country_arr,null, array('id' =>'sp_country_id','onchange' => 'change_country_dropdown(this.id,"sp_province_id")','class' => 'form-control')) !!}

                                              @if ($errors->has('sp_country_id'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('sp_country_id') }}</strong>
                                                  </span>
                                              @endif
                                          </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Country:</strong>
                              
                                  </td>
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        
                                        {!! Form::select('customer_country_id',[null=>"Select Country name"]+ $country_arr,null, array('id' =>'customer_country_id','onchange' => 'change_country_dropdown(this.id,"customer_province_id")','class' => 'form-control')) !!}

                                        @if ($errors->has('customer_country_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('customer_country_id') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> State/Province:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <select 
                                                name="sp_province_id" 
                                                id="sp_province_id"
                                                value=""
                                                class="form-control" >
                                                <option disabled value="">--Select Province-- </option>
                                        
                                            </select>
                                        </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>State/Province:</strong>
                              
                                  </td>
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                          <select 
                                              name="customer_province_id" 
                                              id="customer_province_id"
                                              value=""
                                              class="form-control" >
                                              <option disabled value="">--Select Province-- </option>
                                          </select>
                                      </div>
                                </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> City:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          
                                          <input 
                                            type="text" 
                                            name="sp_city"
                                            id="sp_city" 
                                            placeholder="City" 
                                            class="form-control" 
                                            >
                                        </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>City:</strong>
                              
                                  </td>
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="customer_city"
                                          id="customer_city" 
                                          placeholder="City" 
                                          class="form-control" 
                                          >
                                      </div>
                                </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Street Number/ Name:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="sp_street_number"
                                          id="sp_street_number" 
                                          placeholder="Street Number/ Name" 
                                          class="form-control" 
                                          >
                                      </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Street Number/ Name:</strong>
                              
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="customer_street_number"
                                          id="customer_street_number" 
                                          placeholder="Street Number/ Name" 
                                          class="form-control" 
                                          >
                                      </div>
                                  </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong>Postal Code:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="sp_postal_code"
                                          id="sp_postal_code" 
                                          placeholder="Postal Code" 
                                          class="form-control" 
                                          >
                                      </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Postal Code:</strong>
                              
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="customer_postal_code"
                                          id="customer_postal_code" 
                                          placeholder="Postal Code" 
                                          class="form-control" 
                                          >
                                      </div>
                                  </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> P.O Box:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="sp_po_box"
                                          id="sp_po_box" 
                                          placeholder="P.O Box" 
                                          class="form-control" 
                                          >
                                      </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>P.O Box:</strong>
                              
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="customer_po_box"
                                          id="customer_po_box" 
                                          placeholder="P.O Box" 
                                          class="form-control" 
                                          >
                                      </div>
                                  </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong>Ph. Office :</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <div class="form-group">
                                            <input 
                                              type="text" 
                                              name="sp_office_phone"
                                              id="sp_office_phone" 
                                              placeholder="Office Phone" 
                                              class="form-control" 
                                              >
                                          </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Ph. Office:</strong>
                              
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="customer_office_phone"
                                          id="customer_office_phone" 
                                          placeholder="Office Phone" 
                                          class="form-control" 
                                          >
                                      </div>
                                  </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Ph. Mobile :</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <div class="form-group">
                                            <input 
                                              type="text" 
                                              name="sp_mobile_phone"
                                              id="sp_mobile_phone" 
                                              placeholder=" Ph. Mobile " 
                                              class="form-control" 
                                              >
                                          </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong> Ph. Mobile :</strong>
                              
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="customer_mobile_phone"
                                          id="customer_mobile_phone" 
                                          placeholder=" Ph. Mobile " 
                                          class="form-control" 
                                          >
                                      </div>
                                  </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Ph. Emergency:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <div class="form-group">
                                            <input 
                                              type="text" 
                                              name="sp_emergency_phone"
                                              id="sp_emergency_phone" 
                                              placeholder="Ph. Emergency" 
                                              class="form-control" 
                                              >
                                          </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Ph. Emergency:</strong>
                              
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="customer_emergency_phone"
                                          id="customer_emergency_phone" 
                                          placeholder="Ph. Emergency" 
                                          class="form-control" 
                                          >
                                      </div>
                                  </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Fax:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <div class="form-group">
                                            <input 
                                              type="text" 
                                              name="sp_fax"
                                              id="sp_fax" 
                                              placeholder="Fax" 
                                              class="form-control" 
                                              >
                                          </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Fax:</strong>
                              
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="customer_fax"
                                          id="customer_fax" 
                                          placeholder="Fax" 
                                          class="form-control" 
                                          >
                                      </div>
                                  </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong>Website:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <div class="form-group">
                                            <input 
                                              type="text" 
                                              name="sp_website"
                                              id="sp_website" 
                                              placeholder="Website" 
                                              class="form-control" 
                                              >
                                          </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Website:</strong>
                              
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="customer_website"
                                          id="customer_website" 
                                          placeholder="Website" 
                                          class="form-control" 
                                          >
                                      </div>
                                  </td>

                              </tr>
                              <tr align="center"  >
                                 
                                 <td align="left" bgcolor="#2F75B5" style="color:#fff;vertical-align:middle">
                                    <strong> Email Address:</strong>
                                  </td>
                                  <td width="" bgcolor="#aaa">
                                      <div class="form-group">
                                          <input 
                                            type="text" 
                                            name="sp_street_number"
                                            id="sp_street_number" 
                                            placeholder="Email Address" 
                                            class="form-control" 
                                            >
                                        </div>
                                  </td>
                                  
                                  <td align="left" bgcolor="#7F933F" style="color:#000;vertical-align:middle;"> 
                                      <strong>Email Address:</strong>
                                  </td>
                                  <td width="" bgcolor="#DDD9C4">
                                      <div class="form-group">
                                        <input 
                                          type="text" 
                                          name="customer_email"
                                          id="customer_email" 
                                          placeholder="Email Address" 
                                          class="form-control">
                                      </div>
                                  </td>

                              </tr>
                                
                            </tbody>
                            
                          </table>
                          
                          <table class="table" width="600">
                            <tbody style="color:#fff;text-align: center">
                              <tr bgcolor="#0070C0" >
                                <th colspan="3" style=" font-size: 24px; text-align: center" >Service Period</th>
                              </tr>
                              <tr bgcolor="#0070C0" >

                                <th >Form</th>
                                <th >To</th>
                                <th >Duration</th>
                              </tr>
                            </tbody>
                            
                            <tbody>
                              <tr >
                                <td ><input type="text" id="service_period_form" name="service_period_form" onchange="change_billing_cercle()"></td>
                                <td ></td>
                                <td ><input type="text" id="service_period_to" name="service_period_to" onchange="change_billing_cercle()"></td>
                              </tr>
                              <tr>
                                <td style="font-size:20px; font-weight: bold">Duration</td>
                                <td colspan="2" style="color:red;">* Minimum 1 Years</td>
                              </tr>
                              <tr>
                                <td style="font-size:20px; font-weight: bold">Cancellation Notice</td>
                                <td colspan="2">One Month in Advance</td>
                              </tr>
                              
                              <tr>
                                <td style="font-size:20px; font-weight: bold">Payment Method</td>
                                <td colspan="2">Credit Card/ Pre Authorized Payment</td>
                              </tr>
                            
                            </tbody>
                           
                          </table>


                          <table width="1000" class="table">
                            <thead bgcolor="#0070C0" style="color:#fff; ">
                              <tr >
                                <th colspan="7" style="color:#fff; font-size: 20px; text-align: center;" align="center">Billing Info </th>
                              </tr>
                              <tr>
                                <th rowspan="2" >Period Number </th>
                                <th colspan="2" style="text-align:center">Billing Cycle Period</th>
                                <th rowspan="2">Charging Date </th>
                                <th rowspan="2">Amount </th>
                                <th colspan="2" style="text-align:center">Reminders to</th>
                              </tr>
                              <tr>
                                <th >From</th>
                                <th >To</th>
                                <th>President </th>
                                <th>Accounting Manager</th>
                              </tr>
                            </thead>
                            <tbody id="billing_info_tbody">
                              

                            </tbody>
                          </table>
                          <fieldset style="width:950px;">
                              <legend>Service Charge Summery</legend>

                              <table class="table" width="600">
                                
                                <tbody>
                                  <tr >
                                    <td>Service Charge Currency </td>
                                    <td   align="center">
                                        <div class="form-group">

                                            {!! Form::select('service_charge_currency',[null=>"Select Currency"]+ $currency,null, array('id' =>'service_charge_currency','onchange' => 'change_country_dropdown(this.id,"head_office_provience")','class' => 'form-control')) !!}

                                              @if ($errors->has('service_charge_currency'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('service_charge_currency') }}</strong>
                                                  </span>
                                              @endif
              
                                          </div> 
                                    </td>
                                    <td>
                                    </td>
                                  </tr>
                                  <tr bgcolor="#0070C0" style="color:#fff" >

                                    <td >Payment Cycle </td>
                                    <td >Monthly </td>
                                    <td >Annualy </td>
                                  </tr>
                                  <tr>
                                    <td >Amount</td>
                                    <td ><input class="form-control" type="<?php if($user_service_plan_mst->service_plan_type==1) echo "text"; else echo "hidden"; ?>"
                                    value="<?php if($user_service_plan_mst->service_plan_type==1) echo 50; else echo ""; ?>" id="monthly_service_charge" name="monthly_service_charge"/></td>
                                    <td ><input class="form-control" type="<?php if($user_service_plan_mst->service_plan_type==1) echo "hidden"; else echo "text"; ?>" 
                                      value="<?php if($user_service_plan_mst->service_plan_type==1) echo ""; else echo "100"; ?>" id="yearly_service_charge" name="yearly_service_charge"/></td>
                                  </tr>
                                  <tr>
                                    <td >Tax 1</td>
                                    <td ><input class="form-control" type="<?php if($user_service_plan_mst->service_plan_type==1) echo "text"; else echo "hidden"; ?>" 
                                      value="<?php if($user_service_plan_mst->service_plan_type==1) echo 50; else echo ""; ?>" id="monthly_tax1" name="monthly_tax1"/></td>
                                    <td ><input class="form-control" type="<?php if($user_service_plan_mst->service_plan_type==1) echo "hidden"; else echo "text"; ?>" 
                                       value="<?php if($user_service_plan_mst->service_plan_type==1) echo ""; else echo "100"; ?>"  id="yearly_tax1" name="yearly_tax1"/></td>
                                  </tr>
                                  <tr>
                                    <td >Tax 2</td>
                                    <td ><input class="form-control" type="<?php if($user_service_plan_mst->service_plan_type==1) echo "text"; else echo "hidden"; ?>" 
                                      value="<?php if($user_service_plan_mst->service_plan_type==1) echo 50; else echo ""; ?>" id="monthly_tax2" name="monthly_tax2"/></td>
                                    <td ><input class="form-control" type="<?php if($user_service_plan_mst->service_plan_type==1) echo "hidden"; else echo "text"; ?>" 
                                       value="<?php if($user_service_plan_mst->service_plan_type==1) echo ""; else echo "100"; ?>"  id="yearly_tax2" name="yearly_tax2"/></td>
                                  </tr>
                                  <tr>
                                    <td >Tax 3</td>
                                    <td ><input class="form-control" type="<?php if($user_service_plan_mst->service_plan_type==1) echo "text"; else echo "hidden"; ?>" 
                                      value="<?php if($user_service_plan_mst->service_plan_type==1) echo 50; else echo ""; ?>" id="monthly_tax3" name="monthly_tax3"/></td>
                                    <td ><input class="form-control" type="<?php if($user_service_plan_mst->service_plan_type==1) echo "hidden"; else echo "text"; ?>" 
                                       value="<?php if($user_service_plan_mst->service_plan_type==1) echo ""; else echo "100"; ?>"  id="yearly_tax3" name="yearly_tax3"/></td>
                                  </tr>
                                  <tr>
                                    <td >Total <?php if($user_service_plan_mst->service_plan_type==1) echo "Monthly"; else echo "Annualy"; ?> Payable</td>
                                    <td ><input class="form-control" type="<?php if($user_service_plan_mst->service_plan_type==1) echo "text"; else echo "hidden"; ?>"
                                    value="<?php if($user_service_plan_mst->service_plan_type==1)
                                    {
                                        if($user_service_plan_mst->owner_operator==1) echo $user_service_plan_mst->monthly_total_owner_operator;
                                        else if($user_service_plan_mst->leaseholding_management==1) echo $user_service_plan_mst->monthly_total_leaseholding_management;
                                        else if($user_service_plan_mst->strata_management==1) echo $user_service_plan_mst->monthly_total_strata_management; 
                                    }
                                     ?>" id="monthly_total_payable" name="monthly_total_payable"/></td>
                                    <td ><input class="form-control" type="<?php if($user_service_plan_mst->service_plan_type==1) echo "hidden"; else echo "text"; ?>" 
                                      value="<?php if($user_service_plan_mst->service_plan_type==0)
                                    {
                                        if($user_service_plan_mst->owner_operator==1) echo $user_service_plan_mst->yearly_total_owner_operator;
                                        else if($user_service_plan_mst->leaseholding_management==1) echo $user_service_plan_mst->yearly_total_leaseholding_management;
                                        else if($user_service_plan_mst->strata_management==1) echo $user_service_plan_mst->yearly_total_strata_management; 
                                    }
                                     ?>"id="yearly_total_payable" name="yearly_total_payable"/></td>
                                  </tr>

                                  <tr >
                                    <td>Late Payment Monthly rate</td>
                                    <td   align="center">2%
                                           <input  type="hidden" value="2" id="late_payment_rate" name="late_payment_rate"/>
                                    </td>
                                    <td>
                                    </td>
                                  </tr>
                                  <tr >
                                    <td>NSF Fees </td>
                                    <td   align="center">$50
                                           <input  type="hidden" value="50" id="late_payment_rate" name="late_payment_rate"/>
                                    </td>
                                    <td>
                                    </td>
                                  </tr>
                                  
                                </tbody>
                               
                              </table>
                          </fieldset>

                          <fieldset style="width:950px;">
                              <legend>Payment Method</legend>

                              <table class="table" width="600">
                                
                                <tbody>
                                  
                                  <tr bgcolor="#0070C0" style="color:#fff" >

                                    <td >Payment Cycle </td>
                                    <td >Bank Withdraw </td>
                                    <td >Credit Card </td>
                                  </tr>
                                  <tr>
                                    <td >Financial Institution</td>
                                    <td >Bank of USA</td>
                                  
                                    <td >VISA</td>
                                  </tr>
                                  <tr>
                                    <td >Comment</td>
                                    <td >VOID Check Requited</td>
                                  
                                    <td >Authorization Letter Required</td>
                                  </tr>
                                  <tr>
                                    <td >Authorization form </td>
                                    <td >     
                                      <a id="download_form_100" target="_blank" href="{{asset('download/Book 004.xlsx')}}"><input type="button" id="reprt_excl" class="btn btn-info" value="Download form No 100"></a>
                                    </td>
                                  
                                    <td >
                                       <a id="download_form_100" target="_blank" href="{{asset('download/Book 004.xlsx')}}"><input type="button" id="reprt_excl" class="btn btn-info" value="Download form No 100"></a>

                                    </td>
                                  </tr>

                                  <tr>
                                    <td  colspan="3">Please note :<br/>Please download form 100 and fax it directly to fax number (604) 888- 8888</td>
                                    
                                  </tr>
                                  <tr style="line-height: 44px;">
                                    <td bgcolor="#0070C0" style="color:#fff"> </td>
                                    <td></td>
                                    <td></td>
                                    
                                  </tr>
                                  <tr style="margin-top:400px !important;">
                                    <td bgcolor="#0070C0" style="color:#fff">Declined account </td>
                                    <td></td>
                                    <td></td>
                                    
                                  </tr>
                                  <tr>
                                    <td  colspan="3">
                                        We will charge your account 7 days before starting on each billing cycle. If your account get NSF or declined ,
                                       we will charge $50 for each time plus 2% late fee payment. Please be advised ,
                                       if there is not payment before starting new cycle our system will not allow you to use it.
                                    </td>
                                    
                                  </tr>
                                  

                                  
                                  
                                </tbody>
                               
                              </table>
                          </fieldset>
                          <table class="table" width="600">
                            <tr bgcolor="#0070C0" >
                              <td colspan="3" style="color:#fff; font-size: 24px;" align="center"><strong>Terms of Aggrement<strong></td>
                            </tr>
                            <tbody>
                              <tr>
                                <td >1</td>
                                <td >User will be locked on unauthorized device</td>
                              </tr>
                              <tr>
                                <td >2</td>
                                <td >User will be locked on unauthorized device</td>
                              </tr>
                              <tr>
                                <td >3</td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td >4</td>
                                <td >User will be locked on unauthorized device</td>
                              </tr>
                              <tr>
                                <td >5</td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td >6</td>
                                <td >User will be locked on unauthorized device</td>
                              </tr>
                            </tbody>
                           
                          </table>
                          <table  class="text-center " style="font-size:13px; line-height:12px;" align="center">
                              <tbody>

                                <tr align="center" style="line-height:30px;">
                                  <td colspan="4" align="center">
                                        
                                      <div class="form-group">
                                          <button type="submit" class=" btn btn-success"  >Save</button>
                                          <button type="submit" class=" btn btn-secondary" disabled>Update</button>
                                      </div>
                                  </td>
                                   
                                </tr>

                              </tbody>

                          </table>

                      </fieldset> 
                    </ul>
                  
                </li>
               
                
                <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="far fa-check-square"></i>
                    <p>
                       Account Activation Status &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  
                </li>
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
       
      </div>
      <!-- /.container-fluid -->


  
@endsection
<script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script type="text/javascript">


 $( function() {
      $( "#service_period_form" ).datepicker();
      $( "#service_period_to" ).datepicker();
    } );
  $(document).ready(function(){

      $("#residential").click(function(){
        if($(this).prop("checked") == true){
               // $("#industrial").prop('checked', false);
               // $("#commercial").prop('checked', false);

                $("#residential").val("1");

               // $("#industrial").val("0");
               // $("#commercial").val("0");
            }
            else
            {
               $("#residential").val("0");
            }
      });

      $("#industrial").click(function(){
        if($(this).prop("checked") == true){
               // $("#residential").prop('checked', false);
               // $("#commercial").prop('checked', false);

                $("#industrial").val("1");

              //  $("#residential").val("0");
              //  $("#commercial").val("0");
            }
            else 
            {
               $("#industrial").val("0");
            }
      });

       $("#commercial").click(function(){
        if($(this).prop("checked") == true){
               // $("#residential").prop('checked', false);
               // $("#industrial").prop('checked', false);

               // $("#residential").val("0");
               // $("#industrial").val("0");

                $("#commercial").val("1");
            }
            else
            {
                $("#commercial").val("0");

            }
      });

      
  });
  
// ==================================================service plan========================================
  function amount_calculate(plan_name,id)
  {
    if(plan_name=="plan_a")
    {
      if($("#plan_a").prop("checked") == true)
      {
          var rate=$("#rate_a_"+id).val();
          var quantity=$("#qty_a_"+id).val();
          var amount=rate*quantity;
          $("#plan_a_"+id).val(amount);
          calculate_total_amount();
      }
      else{
        $("#qty_a_"+id).val('');
        alert("Please select Plan A.");
      }
    
    }
    else if(plan_name=="plan_b")
    {
      if($("#plan_b").prop("checked") == true)
      {
        var rate=$("#rate_b_"+id).val();
        var quantity=$("#qty_b_"+id).val();
        var amount=rate*quantity;
        $("#plan_b_"+id).val(amount);
        calculate_total_amount();
      }
      else{
        $("#qty_b_"+id).val('');
        alert("Please select Plan B.");
      }
    }
    else if(plan_name=="plan_c")
    {
      if($("#plan_c").prop("checked") == true)
      {
        var rate=$("#rate_c_"+id).val();
        var quantity=$("#qty_c_"+id).val();
        var amount=rate*quantity;
        $("#plan_c_"+id).val(amount);
        calculate_total_amount();
      }
      else{
        $("#qty_c_"+id).val('');
        alert("Please select Plan C.");
      }
    }

  }

  function plan_checked(plan_name)
  {


    if($("#"+plan_name).prop("checked") == true){
           if(plan_name=="plan_a") {

              $("#plan_b").prop('checked', false);
              $("#plan_c").prop('checked', false);
              $("#plan_a").val('1');
              $("#plan_b").val('0');
              $("#plan_c").val('0');
              $("#strata_management").val('1');
              $("#leaseholding_management").val('0');
              $("#owner_operator").val('0');

              
              $("#"+plan_name).parent().parent().addClass('th_enable');
              $("#plan_b").parent().parent().removeClass('th_enable');
              $("#plan_c").parent().parent().removeClass('th_enable');
              $("#service_plan_table").find('tbody tr').each(function ( index,tr)
              {
                
                var id=($(this).attr("id")).split("_")[1];
                if($("#rate_applicable_"+id).val()==1)
                {
                  if($("#qty_a_"+id).val()!="")
                  {
                    var qty=$("#qty_a_"+id).val();
                    var rate=$("#rate_a_"+id).val();
                    var amount=qty*rate;
                      $("#plan_a_"+id).val(amount);
                  }
                 

                  $("#qty_a_"+id).attr('readonly',false);
                  $("#qty_b_"+id).val('');
                  $("#qty_b_"+id).attr('readonly',true);
                  $("#plan_b_"+id).val('');
                  $("#qty_c_"+id).val('');
                  $("#qty_c_"+id).attr('readonly',true);
                  $("#plan_c_"+id).val('');

                }
                else if($("#rate_applicable_"+id).val()==0 && $("#amount_applicable_"+id).val()==1)
                {

                      $("#check_a_"+id).attr("readonly",false);
                      $("#check_b_"+id).prop("checked",false);
                      $("#check_b_"+id).attr("readonly",true);
                      $("#is_check_b_"+id).val('0');
                  
                      $("#check_c_"+id).prop("checked",false);
                      $("#check_c_"+id).attr("readonly",true);
                      $("#is_check_c_"+id).val('0');
                  
                }



               
              });
              calculate_total_amount();
              // $("#tr_1").find("td:eq(1)").addClass('td_enable');
              // $("#tr_1").find("td:eq(2)").removeClass('td_enable');
              // $("#tr_1").find("td:eq(3)").removeClass('td_enable');
              // $("#tr_1").find("td:eq(4)").removeClass('td_enable');
           } 
           else if(plan_name=="plan_b") {
              $("#plan_a").prop('checked', false);
              $("#plan_c").prop('checked', false);
              $("#plan_a").val('0');
              $("#plan_b").val('1');
              $("#plan_c").val('0');
              $("#strata_management").val('0');
              $("#leaseholding_management").val('1');
              $("#owner_operator").val('0');
              $("#"+plan_name).parent().parent().addClass('th_enable');
              $("#plan_a").parent().parent().removeClass('th_enable');
              $("#plan_c").parent().parent().removeClass('th_enable');

              $("#service_plan_table").find('tbody tr').each(function ()
              {
                var id=($(this).attr("id")).split("_")[1];
                if($("#rate_applicable_"+id).val()==1)
                {
                  if($("#qty_b_"+id).val()!="")
                  {
                    var qty=$("#qty_b_"+id).val();
                    var rate=$("#rate_b_"+id).val();
                    var amount=qty*rate;
                      $("#plan_b_"+id).val(amount);
                  }

                  $("#qty_b_"+id).attr('readonly',false);
                  $("#qty_a_"+id).val('');
                  $("#qty_a_"+id).attr('readonly',true);
                  $("#plan_a_"+id).val('');
                  $("#qty_c_"+id).val('');
                  $("#qty_c_"+id).attr('readonly',true);
                  $("#plan_c_"+id).val('');

                }
                else if($("#rate_applicable_"+id).val()==0 && $("#amount_applicable_"+id).val()==1)
                {

                      $("#check_b_"+id).attr("readonly",false);
                      $("#check_a_"+id).prop("checked",false);
                      $("#check_a_"+id).attr("readonly",true);
                      $("#is_check_a_"+id).val('0');
                  
                      $("#check_c_"+id).prop("checked",false);
                      $("#check_c_"+id).attr("readonly",true);
                      $("#is_check_c_"+id).val('0');
                  
                }
              });
              calculate_total_amount();
           } 
           else if(plan_name=="plan_c") {
              $("#plan_b").prop('checked', false);
              $("#plan_a").prop('checked', false);
              $("#plan_a").val('0');
              $("#plan_b").val('0');
              $("#plan_c").val('1');
              $("#strata_management").val('0');
              $("#leaseholding_management").val('0');
              $("#owner_operator").val('1');
              $("#"+plan_name).parent().parent().addClass('th_enable');
              $("#plan_b").parent().parent().removeClass('th_enable');
              $("#plan_a").parent().parent().removeClass('th_enable');
              
              $("#service_plan_table").find('tbody tr').each(function ()
              {
                 var id=($(this).attr("id")).split("_")[1]; 
                if($("#rate_applicable_"+id).val()==1)
                {
                  $("#qty_c_"+id).attr('readonly',false);
                  if($("#qty_c_"+id).val()!="")
                  {
                    var qty=$("#qty_c_"+id).val();
                    var rate=$("#rate_c_"+id).val();
                    var amount=qty*rate;
                      $("#plan_c_"+id).val(amount);
                  }

                  $("#qty_b_"+id).val('');
                  $("#qty_b_"+id).attr('readonly',true);
                  $("#plan_b_"+id).val('');
                  $("#qty_a_"+id).val('');
                  $("#qty_a_"+id).attr('readonly',true);
                  $("#plan_a_"+id).val('');

                }
                else if($("#rate_applicable_"+id).val()==0 && $("#amount_applicable_"+id).val()==1)
                {

                      $("#check_c_"+id).attr("readonly",false);
                      $("#check_b_"+id).prop("checked",false);
                      $("#check_b_"+id).attr("readonly",true);
                      $("#is_check_b_"+id).val('0');
                  
                      $("#check_a_"+id).prop("checked",false);
                      $("#check_a_"+id).attr("readonly",true);
                      $("#is_check_a_"+id).val('0');
                  
                }
              });
              calculate_total_amount();
           } 
             
      }
      else
      {
          $("#strata_management").val('0');
          $("#leaseholding_management").val('0');
          $("#owner_operator").val('0');

          $("#plan_a").val('0');
          $("#plan_b").val('0');
          $("#plan_c").val('0');
         $("#"+plan_name).parent().parent().removeClass('th_enable');
        
            if(plan_name=="plan_a") {
              $(this).find("td:eq(1)").removeClass('td_enable');
              
            }
            else if(plan_name=="plan_b") {
              $(this).find("td:eq(2)").removeClass('td_enable');
             
            }
            else if(plan_name=="plan_c") {
              $(this).find("td:eq(3)").removeClass('td_enable');
              
            }

            calculate_total_amount();
         
      }

  }


  function check_amount_row(plan_name,row_id)
  {

      if($("#"+plan_name).prop("checked") == true)
      {
        if(plan_name=="plan_a"){
          if($("#check_a_"+row_id).prop("checked") == true)
          {
            $("#is_check_a_"+row_id).val('1');
          } 
          else $("#is_check_a_"+row_id).val('0');

        }
        else if(plan_name=="plan_b"){
          if($("#check_b_"+row_id).prop("checked") == true)
          {
              $("#is_check_b_"+row_id).val('1');
          } 
          else $("#is_check_b_"+row_id).val('0');
        }
        else if(plan_name=="plan_c"){
          if($("#check_c_"+row_id).prop("checked") == true)
          {
              $("#is_check_c_"+row_id).val('1');
          } 
          else $("#is_check_c_"+row_id).val('0');
        }
        
        calculate_total_amount();

      }
      else
      {
        if(plan_name=="plan_a"){
          alert("Please Select Plan A");
          $("#check_a_"+row_id).prop("checked",false);
          $("#is_check_a_"+row_id).val('0');
        }
        else if(plan_name=="plan_b"){
          alert("Please Select Plan B");
          $("#check_b_"+row_id).prop("checked",false);
          $("#is_check_b_"+row_id).val('0');
        }
        else if(plan_name=="plan_c"){
          alert("Please Select Plan C");
          $("#check_c_"+row_id).prop("checked",false);
          $("#is_check_c_"+row_id).val('0');
        }
      }

  }
  function calculate_total_amount()
  {
    var total_monthly_amount=0;
    if($("#plan_a").prop("checked") == true){

      
       $("#service_plan_table").find('tbody tr').each(function ()
        {

          var id=($(this).attr("id")).split("_")[1];
          if($("#rate_applicable_"+id).val()==1)
          {
            if($("#qty_a_"+id).val()!="")
            {
              
              var amount=$("#plan_a_"+id).val()*1;
              total_monthly_amount+=amount;
                
            }
          

          }
          else if($("#rate_applicable_"+id).val()==0 && $("#amount_applicable_"+id).val()==1)
          {

               if($("#check_a_"+id).prop("checked") == true)
                {
                    var amount=$("#plan_a_"+id).val()*1;
                    total_monthly_amount+=amount;
                      
                  }
            
          }
          
        });

      // alert($("#yearly_total_gess").find("th:eq(1)").children().text());
        $("#monthly_total_strata_management").val(total_monthly_amount);
        $("#monthly_total_leaseholding_management").val('');
        $("#monthly_total_owner_operator").val('');
       

        var yearly_total=total_monthly_amount*12;
        var yearly_total_actual=total_monthly_amount*.8*12;
        $("#yearly_total_gess").find("th:eq(2)").children().text(yearly_total);
        $("#yearly_total_gess").find("th:eq(4)").children().text('');
        $("#yearly_total_gess").find("th:eq(6)").children().text('');

        $("#yearly_total_strata_management").val(yearly_total_actual);
        $("#yearly_total_leaseholding_management").val('');
        $("#yearly_total_owner_operator").val('');
    }
    else if($("#plan_b").prop("checked") == true){
      
       $("#service_plan_table").find('tbody tr').each(function ()
        {

          var id=($(this).attr("id")).split("_")[1];

          if($("#rate_applicable_"+id).val()==1)
          {
            if($("#qty_b_"+id).val()!="")
            {
              
              var amount=$("#plan_b_"+id).val()*1;
              total_monthly_amount+=amount;
                
            }
          

          }
          else if($("#rate_applicable_"+id).val()==0 && $("#amount_applicable_"+id).val()==1)
          {

               if($("#check_b_"+id).find('input[name="check_b[]"').prop("checked") == true)
                {
                  
                    
                    var amount=$("#plan_b_"+id).val()*1;
                    total_monthly_amount+=amount;
                      
                  }
            
          }
          
        });

        $("#monthly_total_strata_management").val('');
        $("#monthly_total_leaseholding_management").val(total_monthly_amount);
        $("#monthly_total_owner_operator").val('');
       

        var yearly_total=total_monthly_amount*12;
        var yearly_total_actual=total_monthly_amount*.8*12;
        $("#yearly_total_gess").find("th:eq(2)").children().text('');
        $("#yearly_total_gess").find("th:eq(4)").children().text(yearly_total);
        $("#yearly_total_gess").find("th:eq(6)").children().text('');

        $("#yearly_total_strata_management").val('');
        $("#yearly_total_leaseholding_management").val(yearly_total_actual);
        $("#yearly_total_owner_operator").val('');

    }
    else if($("#plan_c").prop("checked") == true){
      
      $("#service_plan_table").find('tbody tr').each(function ()
        {

          var id=($(this).attr("id")).split("_")[1];
          if($("#rate_applicable_"+id).val()==1)
          {
            if($("#qty_c_"+id).find('input[name="qty_c[]"]').val()!="")
            {
              
              var amount=$("#plan_c_"+id).find('input[name="plan_c[]"]').val()*1;
              total_monthly_amount+=amount;
                
            }
          

          }
          else if($("#rate_applicable_"+id).val()==0 && $("#amount_applicable_"+id).val()==1)
          {

               if($("#check_c_"+id).find('input[name="check_c[]"').prop("checked") == true)
                {
                    var amount=$("#plan_c_"+id).find('input[name="plan_c[]"]').val()*1;
                    total_monthly_amount+=amount;
                  }
          }
          
        });

        $("#monthly_total_strata_management").val('');
        $("#monthly_total_leaseholding_management").val('');
        $("#monthly_total_owner_operator").val(total_monthly_amount);
       

        var yearly_total=total_monthly_amount*12;
        var yearly_total_actual=total_monthly_amount*.8*12;
        $("#yearly_total_gess").find("th:eq(2)").children().text('');
        $("#yearly_total_gess").find("th:eq(4)").children().text('');
        $("#yearly_total_gess").find("th:eq(6)").children().text(yearly_total);

        $("#yearly_total_strata_management").val('');
        $("#yearly_total_leaseholding_management").val('');
        $("#yearly_total_owner_operator").val(yearly_total_actual);
    }
    
    else 
    {
        $("#monthly_total_strata_management").val('');
        $("#monthly_total_leaseholding_management").val('');
        $("#monthly_total_owner_operator").val('');
       

        var yearly_total=total_monthly_amount*12;
        var yearly_total_actual=total_monthly_amount*.8*12;
        $("#yearly_total_gess").find("th:eq(2)").children().text('');
        $("#yearly_total_gess").find("th:eq(4)").children().text('');
        $("#yearly_total_gess").find("th:eq(6)").children().text('');

        $("#yearly_total_strata_management").val('');
        $("#yearly_total_leaseholding_management").val('');
        $("#yearly_total_owner_operator").val('');
    }
  }



  

  //======================Enable Monthly or Yearly========================================
  function enable_monthly_yearly()
  {

    if($("#servicePlanMonthly").hasClass("montly_enable"))
    {
      //alert(4);
      $("#servicePlanMonthly").removeClass("montly_enable");
      $("#servicePlanMonthly").addClass("yearly_disable");
    }
    else
    {
      //alert(3);
      $("#servicePlanMonthly").removeClass("yearly_disable");
      $("#servicePlanMonthly").addClass("montly_enable");
    }
    //return;
    if($("#servicePlanYearly").hasClass("montly_enable"))
    {
      //alert(2);
      $("#servicePlanYearly").removeClass("montly_enable");
      $("#servicePlanYearly").addClass("yearly_disable");
    }
    else
    {
      //alert(1);
      $("#servicePlanYearly").removeClass("yearly_disable");
      $("#servicePlanYearly").addClass("montly_enable");
    }

    if($("#service_plan_type").val()==1)
    {
      $("#service_plan_type").val('0');
    }
    else
    {
      $("#service_plan_type").val('1');
    }




    // if($("#servicePlanMonthlyYearly").prop("checked") == true)
    // {
    //   $("#servicePlanMonthly").removeClass("yearly_disable");
    //   $("#servicePlanMonthly").addClass("montly_enable");
    // }
    // else
    // {
    //   $("#servicePlanYearly").removeClass("yearly_disable");
    //   $("#servicePlanMonthly").addClass("montly_enable");
    // }
  }



  function change_country_dropdown(id,provience_id)
  {
    var country=$("#"+id).val();

    // $.ajax({
    //   url: 'country_by_provience',
    //   data: {country_id:country},
    //   success: function(){
    //     alert();
    //   },
    //   //dataType: dataType
    // });


    $.ajax({    //create an ajax request to display.php
        type: "GET",
        url: "provience_by_country/"+country,             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $('#'+provience_id).children().remove().end().append(response) ;
        }

    });
    
  }

  function change_billing_cercle()
  {

    var form_date=new Date($("#service_period_form").val());
    var to_date  =new Date($("#service_period_to").val());
    var Difference_In_Time=to_date.getTime() - form_date.getTime();
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

    if($("#service_period_form").val()=="" || $("#service_period_to").val()=="") return;
   

    if(Difference_In_Days<365)
    {

        Swal.fire("Service Period Must be Minimun 1 Year");
        $("#billing_info_tbody").html('');
        return;
    }
    else
    {
        if($("#service_plan_type").val()==1)
        {

          $("#billing_info_tbody").html('');
          var monthly_payment=0;
          if($("#plan_a").val()==1)
          {

             monthly_payment=$("#monthly_total_strata_management").val();
          }
          else if($("#plan_b").val()==1)
          {

             monthly_payment=$("#monthly_total_leaseholding_management").val();
          }
          else if($("#plan_c").val()==1)
          {

             monthly_payment=$("#monthly_total_owner_operator").val();
          }
          else
          {
            Swal.fire("Please Complete Your Service Plan");return;
          }
          var html='';
          

         
          var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
         // html+='<tr><td>1</td><td>'+form_date.toLocaleDateString("en-US", options)+'</td>';
          var last_date = new Date(form_date.getFullYear(),form_date.getMonth()+ 1, 0);

          var charge_date=new Date(form_date.getFullYear(),form_date.getMonth()+ 1, 0);
                  
          charge_date=new Date(charge_date.setDate(charge_date.getDate()- 7));
          html+='<tr><td>'+1+'</td><td>'+form_date.toLocaleDateString("en-US", options)+'</td><td>'+last_date.toLocaleDateString("en-US", options)+'</td><td>'+charge_date.toLocaleDateString("en-US", options)+'</td><td>'+monthly_payment+'</td><td></td><td></td></tr>';

          for(var i=2;i<=100;i++)
          {
              if(last_date.getTime()<=to_date.getTime())
              {
                  form_date=new Date(form_date.setMonth(form_date.getMonth()+1));
                  last_date = new Date(form_date.getFullYear(),form_date.getMonth()+1, 0);
                  charge_date = new Date(last_date.getFullYear(),last_date.getMonth(), last_date.getDate()- 7);
                  html+='<tr><td>'+i+'</td><td>'+form_date.toLocaleDateString("en-US", options)+'</td><td>'+last_date.toLocaleDateString("en-US", options)+'</td><td>'+charge_date.toLocaleDateString("en-US", options)+'</td><td>'+monthly_payment+'</td><td></td><td></td></tr>';
              }
             
          }
         
        } 
        else
        {


          $("#billing_info_tbody").html('');
          var yearly_payment=0;
          if($("#plan_a").val()==1)
          {
             yearly_payment=$("#yearly_total_strata_management").val();
          }
          else if($("#plan_b").val()==1)
          {

             yearly_payment=$("#yearly_total_leaseholding_management").val();
          }
          else if($("#plan_c").val()==1)
          {

             yearly_payment=$("#yearly_total_owner_operator").val();
          }
          else
          {
            Swal.fire("Please Complete Your Service Plan");return;
          }



          var html='';
          
          var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
         // html+='<tr><td>1</td><td>'+form_date.toLocaleDateString("en-US", options)+'</td>';
          var last_date = new Date(form_date.getFullYear(),form_date.getMonth()+ 12, 0);

          var charge_date=new Date(form_date.getFullYear(),form_date.getMonth()+ 12, 0);
                  
          charge_date=new Date(charge_date.setDate(charge_date.getDate()- 7));
          html+='<tr><td>'+1+'</td><td>'+form_date.toLocaleDateString("en-US", options)+'</td><td>'+last_date.toLocaleDateString("en-US", options)+'</td><td>'+charge_date.toLocaleDateString("en-US", options)+'</td><td>'+yearly_payment+'</td><td></td><td></td></tr>';

          for(var i=2;i<=100;i++)
          {
              if(last_date.getTime()<=to_date.getTime())
              {
                  form_date=new Date(form_date.setMonth(form_date.getMonth()+12));
                  last_date = new Date(form_date.getFullYear(),form_date.getMonth()+12, 0);
                  charge_date = new Date(last_date.getFullYear(),last_date.getMonth(), last_date.getDate()- 7);
                  html+='<tr><td>'+i+'</td><td>'+form_date.toLocaleDateString("en-US", options)+'</td><td>'+last_date.toLocaleDateString("en-US", options)+'</td><td>'+charge_date.toLocaleDateString("en-US", options)+'</td><td>'+yearly_payment+'</td><td></td><td></td></tr>';
              }
             
          }
        }
    }
    
    
    $("#billing_info_tbody").append(html);
    return;
    
   
  }
</script>

<style>


  .tr_anable{
    display:block;
  }

  .tr_disable{
    display:none;
  }

  .th_enable{
    background-color:#007bff;
    color:#fff;
    /*29d169;*/

  }


  .td_enable{
    background-color:#29d169;
    color:#fff;
    /*29d169;*/

  }
  /* ===============================button switch================================================= */
    .montly_enable{
      font-size:30px;
      color:#236EB2;
    }
    .yearly_disable{
       font-size:30px;
        color:#C3CDC3;
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 70px;
      height: 34px;
    }

    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }

    .btnonof {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .btnonof:before {
      position: absolute;
      content: "";
      height: 28px;
      width: 28px;
      left: 7px;
      bottom: 3px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .btnonof {
      background-color: #236EB2;
    }

    input:focus + .btnonof {
      box-shadow: 0 0 1px #236EB2;
    }

    input:checked + .btnonof:before {
      -webkit-transform: translateX(28px);
      -ms-transform: translateX(28px);
      transform: translateX(28px);
    }

    /* Rounded btnonofs */
    .btnonof.round {
      border-radius: 34px;
    }

    .btnonof.round:before {
      border-radius: 50%;
    }

</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="{!! asset('css/glyphicon.css') !!}" media="all" rel="stylesheet" type="text/css" />