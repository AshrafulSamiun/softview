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
                <li class="nav-item has-treeview " >
                  <a href="#" class="nav-link active" style="width:250px;" style="background:#0070C0">
                    
                    <i class="fas fa-building"></i>
                    <p>
                      Company Profile &nbsp; &nbsp;&nbsp;
                      <?php $company_logo=$userCompany->company_logo;  ?>
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" >
                    <div class="card" style="border: 2px solid #000" sytle="display:none;" align="center">
                      <div class="card-heading">
                      </div>
                        <div class="card-body">
                          
                          {!! Form::model($userCompany, ['enctype'=>'multipart/form-data','method' => 'PATCH','route' => ['UserCompanies.update', $userCompany->id]]) !!}

                            <div class="form-section">
                              

                              <table width="100%" style="font-size:13px; line-height:12px;"> 
                            
                              <tbody>
                              
                                <tr>
                                  <td>
                                    <div class="form-lebel" align="right">
                                          Legal Name:
                                    </div>
                                  </td>
                                  <td>
                                      <div class="form-group">
                                          <input  type="text" name="legal_name"  class="form-control"
                                          value="{{$userCompany->legal_name}}" required>
                                          @if ($errors->has('legal_name'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('legal_name') }}</strong>
                                              </span>
                                          @endif
                                      </div>
                                  </td>

                                  <td >
                                    <div class="form-lebel" >
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
                                  <td>
                                        
                                      <div class="form-group">
                                      
                                         <img src="{{$company_logo_url}}" class="img-responsive" height="80" width="100"  > 
                                        
                                      </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="5">

                                    <fieldset>
                                      <legend style="width:100%;">Addresses and Contacts </legend>
                             
                                      <table width="100%" class=" " style="font-size:13px; line-height:12px;">
                                        <thead>

                                          <tr align="center" style="line-height:18px;font-size:15px;">
                                              <th>Particular</th>
                                              <th>Company</th>
                                              <th>Head Office</th>
                                              <th>Property</th>
                                          </tr>

                                        </thead>
                                        <tbody>
                                        
                                            <tr>
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Country:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">

                                                  
                                                  {!! Form::select('company_country_id',[null=>"Select Country name"]+ $country_arr,null, array('required','id' =>'company_country_id','onchange' => 'change_country_dropdown(this.id,"company_provience_id")','class' => 'form-control')) !!}

                                                    @if ($errors->has('company_country_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('company_country_id') }}</strong>
                                                        </span>
                                                    @endif
                    
                                                </div>    
                                              </td>


                                              <td>
                                                <div class="form-group">
                                                  {!! Form::select('head_office_country_id',[null=>"Select Country name"]+ $country_arr,null, array('required','id' =>'head_office_country_id','onchange' => 'change_country_dropdown(this.id,"head_office_provience_id")','class' => 'form-control')) !!}

                                                    @if ($errors->has('head_office_country_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('head_office_country_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    {!! Form::select('property_country_id',[null=>"Select Country name"]+ $country_arr,null, array('required','id' =>'property_country_id','onchange' => 'change_country_dropdown(this.id,"property_provience_id")','class' => 'form-control')) !!}

                                                    @if ($errors->has('property_country_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('property_country_id') }}</strong>
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
                                                  {!! Form::select('company_provience_id',[null=>"Select Provience"]+$company_provience_arr,null, array('required','id' =>'company_provience_id','class' => 'form-control')) !!}

                                                  @if ($errors->has('company_provience_id'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_provience_id') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                               <td>
                                                <div class="form-group">
                                                  {!! Form::select('head_office_provience_id',[null=>"Select Provience"]+$head_office_provience_arr,null, array('required','id' =>'head_office_provience_id','class' => 'form-control')) !!}

                                                  @if ($errors->has('head_office_provience_id'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_provience_id') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    {!! Form::select('property_provience_id',[null=>"Select Provience"]+$property_provience_arr,null, array('required','id' =>'property_provience_id','class' => 'form-control')) !!}

                                                    @if ($errors->has('property_provience_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('property_provience_id') }}</strong>
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
                                                  <input  type="text" name="company_city" value="{{$userCompany->company_city}}" class="form-control" id="company_city" required>
                                                  @if ($errors->has('company_city'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_city') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_city" value="{{$userCompany->head_office_city}}" class="form-control" id="head_office_city" required>
                                                  @if ($errors->has('head_office_city'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_city') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_city" value="{{$userCompany->property_city}}" class="form-control" id="property_city" required>
                                                  @if ($errors->has('property_city'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('property_city') }}</strong>
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
                                                  <input  type="text" name="company_street_no" value="{{$userCompany->company_street_no}}" class="form-control" id="company_street_no" required>
                                                  @if ($errors->has('company_street_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_street_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_street_no" value="{{$userCompany->head_office_street_no}}" class="form-control" id="head_office_street_no" required>
                                                  @if ($errors->has('head_office_street_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_street_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_street_no" value="{{$userCompany->property_street_no}}" class="form-control" id="property_street_no" required>
                                                    @if ($errors->has('property_street_no'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('property_street_no') }}</strong>
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
                                                  <input  type="text" name="company_postal_code" value="{{$userCompany->company_postal_code}}" class="form-control" id="company_postal_code" required>
                                                  @if ($errors->has('company_postal_code'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_postal_code') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_postal_code" value="{{$userCompany->head_office_postal_code}}" class="form-control" id="head_office_postal_code" required>
                                                  @if ($errors->has('head_office_postal_code'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_postal_code') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_postal_code" value="{{$userCompany->property_postal_code}}" class="form-control" id="property_postal_code" required>
                                                    @if ($errors->has('property_postal_code'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('property_postal_code') }}</strong>
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
                                                  <input  type="text" name="company_po_box" value="{{$userCompany->company_po_box}}" class="form-control" id="company_po_box" required>
                                                  @if ($errors->has('company_po_box'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_po_box') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_po_box" value="{{$userCompany->head_office_po_box}}" class="form-control" id="head_office_po_box" required>
                                                  @if ($errors->has('head_office_po_box'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_po_box') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_po_box" value="{{$userCompany->property_po_box}}" class="form-control" id="property_po_box" required>
                                                    @if ($errors->has('property_po_box'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('property_po_box') }}</strong>
                                                        </span>
                                                    @endif
                                                  </div>
                                              </td>
                                            </tr>


                                            <tr>
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Business No.:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="company_business_no" value="{{$userCompany->company_business_no}}" class="form-control" id="company_business_no" required>
                                                  @if ($errors->has('company_business_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_business_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_business_no" value="{{$userCompany->head_office_business_no}}" class="form-control" id="head_office_business_no" required>
                                                  @if ($errors->has('head_office_business_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_business_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_business_no" value="{{$userCompany->property_business_no}}" class="form-control" id="property_business_no" required>
                                                    @if ($errors->has('property_business_no'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('property_business_no') }}</strong>
                                                        </span>
                                                    @endif
                                                  </div>
                                              </td>
                                            </tr>


                                            <tr>
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Ph. Office:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="company_phone" value="{{$userCompany->company_phone}}" class="form-control" id="company_phone" required>
                                                  @if ($errors->has('company_phone'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_phone') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_phone" value="{{$userCompany->head_office_phone}}" class="form-control" id="head_office_phone" required>
                                                  @if ($errors->has('head_office_phone'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_phone') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_phone" value="{{$userCompany->property_phone}}" class="form-control" id="property_phone" required>
                                                    @if ($errors->has('property_phone'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('property_phone') }}</strong>
                                                        </span>
                                                    @endif
                                                  </div>
                                              </td>
                                            </tr>


                                            <tr>
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Ph. Mobile:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="company_mobile_no" value="{{$userCompany->company_mobile_no}}" class="form-control" id="company_mobile_no" required>
                                                  @if ($errors->has('company_mobile_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_mobile_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_mobile_no" value="{{$userCompany->head_office_mobile_no}}" class="form-control" id="head_office_mobile_no" required>
                                                  @if ($errors->has('head_office_mobile_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_mobile_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_mobile_no" value="{{$userCompany->property_mobile_no}}" class="form-control" id="property_mobile_no" required>
                                                    @if ($errors->has('property_mobile_no'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('property_mobile_no') }}</strong>
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
                                                  <input  type="text" name="company_fax_no" value="{{$userCompany->company_fax_no}}" class="form-control" id="company_fax_no" required>
                                                  @if ($errors->has('company_fax_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_fax_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_fax_no" value="{{$userCompany->head_office_fax_no}}" class="form-control" id="head_office_fax_no" required>
                                                  @if ($errors->has('head_office_fax_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_fax_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_fax_no" value="{{$userCompany->property_fax_no}}" class="form-control" id="property_fax_no" required>
                                                    @if ($errors->has('property_fax_no'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('property_fax_no') }}</strong>
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
                                                  <input  type="text" name="company_website" value="{{$userCompany->company_website}}" class="form-control" id="company_website" required> 
                                                  @if ($errors->has('company_website'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_website') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_website" value="{{$userCompany->head_office_website}}" class="form-control" id="head_office_website" required>
                                                  @if ($errors->has('head_office_website'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_website') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_website" value="{{$userCompany->property_website}}" class="form-control" id="property_website" required>
                                                    @if ($errors->has('property_website'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('property_website') }}</strong>
                                                        </span>
                                                    @endif
                                                  </div>
                                              </td>
                                            </tr>


                                            <tr>
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Email address:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input  type="email" name="company_email" value="{{$userCompany->company_email}}" class="form-control" id="company_email" required>
                                                  @if ($errors->has('company_email'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_email') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="email" name="head_office_email" value="{{$userCompany->head_office_email}}" class="form-control" id="head_office_email" required>
                                                  @if ($errors->has('head_office_email'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_email') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="email" name="property_email" value="{{$userCompany->property_email}}" class="form-control" id="property_email" required>
                                                    @if ($errors->has('property_email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('property_email') }}</strong>
                                                        </span>
                                                    @endif
                                                  </div>
                                              </td>
                                            </tr>


                                           
                                              
                                    
                            
                                        </tbody>
                                       </table>
                                    </fieldset>

                                  </td>
                               </tr> 
                          
                                <tr>
                                  
                                  <td colspan="5" align="center">
                                        
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

                        <div class="modal fade" id="addNewCompanyLogo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"   >
                          <div class="modal-dialog" role="document">
                            <div class="modal-content" style="width:600px">
                                
                                <div class="modal-header">
                                  <h2 id="messagebox_main"></h2>
                                  <h5 class="modal-title" >
                                    @if($userCompany->company_logo)
                                      Update Photo
                                    @else
                                    Add New Photo
                                    @endif
                                  </h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                   <form @submit.prevent="editmodephoto1 ? updatePhoto1() : createPhoto1()" 
                                   >
                                      <table width="750">
                      
                                        <tbody>
                                            
                                          <tr>
                                            <td>
                                              <div class="form-group">
                                                  <img src="" class="img-responsive" height="150" width="200"  >
                                              </div>

                                            </td>
                                          </tr>
                                          <tr>
                                            <td>
                                              <div class="form-group">
                                                            <input type="file" onchange="onPhotoChange" class="form-control" 
                                                            style="width:300px;">
                                                     </div>

                                            </td>
                                          </tr>
                                          <tr>
                                            <td>
                                              

                                              <div class="form-group">

                                                <button :disabled="form.busy" v-show="!editmodephoto1" type="submit" class="btn btn-primary">
                                                  @if($userCompany->company_logo)
                                                    Update Photo
                                                  @else
                                                    Save Photo
                                                  @endif
                                                  </button>
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
                      </div>
                   
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link active" style="width:250px;">
                    
                    <i class="fas fa-venus-double"></i>
                    <p>
                      Property management type  &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    
                    <fieldset style="width:550px; margin-left:250px;">
                        {!! Form::model($PropertyManagementType, ['method' => 'PATCH','route' => ['PropertyManagementTypes.update', $PropertyManagementType->id]]) !!}

                          <table  class="table " style="font-size:13px; line-height:12px;">
                            <thead>

                              <tr align="center" style="line-height:30px;">
                                  <th>Landlord/s</th>
                                  <th>Strata </th>
                                 
                              </tr>

                            </thead>
                            <tbody style="line-height:30px;">
                            
                                <tr>
                                  <td>
                                      <div  class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" name="landlord_rantal" id="landlord_rantal"
                                         @if($PropertyManagementType->landlord_rantal)   value="1" checked
                                         @else  value="0" @endif>
                                        <label for="landlord_rantal">Rental</label>
                                      </div>
                                  </td>
                                  <td>
                                       <div  class="icheck-primary d-inline ml-2">
                                        <input type="checkbox"  name="strata_rental" id="strata_rental"
                                         @if($PropertyManagementType->strata_rental)   value="1" checked
                                         @else  value="0" @endif>
                                        <label for="strata_rental">Rental</label>
                                    </div>    
                                  </td>

                                 
                                </tr>

                                <tr>
                                  <td>
                                          
                                      <div  class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="0" name="landlord_leasehold" id="landlord_leasehold"
                                         @if($PropertyManagementType->landlord_rantal)   value="1" checked
                                         @else  value="0" @endif>
                                        <label for="landlord_leasehold">Leasehold</label>
                                      </div>
                                    
                                  </td>
                                  <td>
                                       <div  class="icheck-primary d-inline ml-2">
                                        <input type="checkbox"  name="strata_leasehold" id="strata_leasehold"
                                         @if($PropertyManagementType->strata_leasehold)   value="1" checked
                                         @else  value="0" @endif>
                                        <label for="strata_leasehold">Leasehold</label>
                                    </div>    
                                  </td>

                                 
                                </tr>
                                <tr>
                                  <td>
                                          
                                    <div  class="icheck-primary d-inline ml-2">
                                      <input type="checkbox"  name="landlord_both" id="landlord_both"
                                       @if($PropertyManagementType->landlord_both)   value="1" checked
                                         @else  value="0" @endif>
                                      <label for="landlord_both">Both</label>
                                    </div>
                                    
                                  </td>
                                  <td>
                                       <div  class="icheck-primary d-inline ml-2">
                                        <input type="checkbox"  name="strata_both" id="strata_both"
                                         @if($PropertyManagementType->strata_both)   value="1" checked
                                         @else  value="0" @endif>
                                        <label for="strata_both">Both</label>
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
                <li class="nav-item has-treeview menu-open">
                  <a href="#" class="nav-link active" style="width:250px;">
                    
                    <i class="fab fa-think-peaks"></i>
                    <p>
                      Service Plans  &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    
                     <fieldset style="width:1100px; margin-left:250px;">
                        {!! Form::open(array('class' => 'contact-form','route' => 'UserServicePlans.store','method'=>'POST')) !!}

                        <table  class="table table-bordered" style="font-size:16px; line-height:25px;"
                        id="service_plan_table">
                          <thead style="line-height:30px;">

                            <tr align="center" >
                                <th  width="350" rowspan="3" style="vertical-align:center">
                                  <div class="form-group">
                                      <label for="servicePlanMonthly" id="servicePlanMonthly" class="montly_enable">Monthly</label>
                                      <label class="switch">

                                        <input type="checkbox" id="servicePlanMonthlyYearly"
                                        onclick="enable_monthly_yearly()"
                                        name="servicePlanMonthlyYearly" value="1" checked>

                                        <span class="btnonof round"></span>
                                      </label>
                                      <label for="servicePlanYearly" id="servicePlanYearly" class="yearly_disable">Yearly</label>
                                        <input type="hidden" id="service_plan_type" name="service_plan_type" value="1" >
                                  </div>
                                 </th>
                               
                                <th colspan='2'>Single Property</th>
                                <th colspan='2'>Multiple Property </th>
                                
                            </tr>
                            <tr align="center" >
                                <th>Single Owner</th>
                                <th>Multiple Owners </th>
                                <th>Single Owner </th>
                                <th>Multiple Owners </th>
                               
                            </tr>
                            <tr align="center" >
                                <th>

                                   <div  class="icheck-primary d-inline ml-2">
                                      <input type="checkbox" value="0" name="plan_a" id="plan_a"
                                      onclick="plan_checked('plan_a')">
                                      <label for="plan_a"> Plan A</label>
                                      <input type="hidden" id="single_owner" name="single_owner" value="0" >
                                    </div>
                                 </th>
                                <th>
                                  <div  class="icheck-primary d-inline ml-2">
                                      <input type="checkbox" value="0" name="plan_b" id="plan_b"
                                      onclick="plan_checked('plan_b')">
                                      <label for="plan_b">Plan B</label>
                                      <input type="hidden" id="multiple_owner" name="multiple_owner" value="0" >
                                  </div>
                                </th>
                                <th>
                                  <div  class="icheck-primary d-inline ml-2">
                                      <input type="checkbox" value="0" name="plan_c" id="plan_c"
                                      onclick="plan_checked('plan_c')">
                                      <label for="plan_c">Plan C</label>
                                      <input type="hidden" id="single_owner_multiproperty" name="single_owner_multiproperty" value="0" >
                                  </div> 
                                </th>
                                <th>
                                  <div  class="icheck-primary d-inline ml-2">
                                      <input type="checkbox" value="0" name="plan_d" id="plan_d"
                                      onclick="plan_checked('plan_d')">
                                      <label for="plan_d">Plan D</label>
                                      <input type="hidden" id="multiple_owner_multiproperty" name="multiple_owner_multiproperty" value="0" >
                                  </div>
                                </th>
                               
                            </tr>
                            
                          

                          </thead>
                          <tbody>
                            <?php //print_r($master_plan_arr);  ?>
                          


                            @foreach($master_plan_arr as $mid=>$mvalue)

                            @if(!empty($lavel_one_plan_arr[$mid]))
                                <tr align="center" style="cursor:pointer" id="tr_{{$mid}}"
                                 onclick="display_child_row({{$mid}},{{count($lavel_one_plan_arr[$mid])}})">
                                      <td align="left">
                              @else

                              <tr align="center" id="tr_{{$mid}}">
                                <td align="left">
                              @endif
                             
                                  @if($mvalue['amount_applicable']==0)
                                    <i  class=" right fas fa-angle-down"></i>
                                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                  <strong>{{$mvalue['plan_name']}}</strong>
                                  <input type="hidden" id="plan_id_{{$mid}}" name="plan_id[]" value="{{$mid}}">
                                  <input type="hidden" id="plan_value_{{$mid}}" name="plan_value[]" value="0">
                                  @else
                                    <div class="form-check">
                                        <input class="form-check-input" name="plan_name_{{$mid}}" type="checkbox" 
                                        value="0" id="plan_name_{{$mid}}"
                                        onclick="check_master_row({{$mid}})"
                                         <?php if($mid==1) echo "checked disabled"; ?>>
                                         <input type="hidden" id="plan_id_{{$mid}}" name="plan_id[]" value="{{$mid}}">
                                         <input type="hidden" id="plan_value_{{$mid}}" name="plan_value[]" 
                                         value="<?php if($mid==1) echo "1"; else echo "0"; ?>">

                                        <label class="form-check-label" for="plan_name_{{$mid}}">
                                          <strong> &nbsp;&nbsp;&nbsp;{{$mvalue['plan_name']}}</strong>
                                        </label>
                                      </div>
                                  @endif
                                 
                                  
                                </td>
                                @if($mvalue['amount_applicable']==1)
                                  <td> {{$mvalue['plan_a']}}</td>
                                  <td>{{$mvalue['plan_b']}}</td>
                                  <td>{{$mvalue['plan_c']}}</td>
                                  <td> {{$mvalue['plan_d']}}</td>
                                @else
                                  <td></td>
                                  <td> </td>
                                  <td></td>
                                  <td></td>
                                @endif
                              </tr>


                              @if(!empty($lavel_one_plan_arr[$mid]))
                                <?php $sl=1; ?>
                                @foreach($lavel_one_plan_arr[$mid] as $loneid=>$lonevalue)
                                  <tr align="center" class="tr_disable" style="background-color:#efedf2;" 
                                  id="tr_{{$mid}}_{{$sl}}">
                                    <td align="left" style="margin-left:30px;">
                                      @if($lonevalue['amount_applicable']==0)
                                        <i  class=" right fas fa-angle-down"></i>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      <strong>{{$lonevalue['plan_name']}}</strong>
                                      <input type="hidden" id="plan_id_{{$loneid}}" name="plan_id[]" value="{{$loneid}}">
                                      <input type="hidden" id="plan_value_{{$loneid}}" name="plan_value[]" value="0">
                                      @else
                                         <div class="form-check">
                                          <input class="form-check-input" type="checkbox" name="plan_name_{{$loneid}}"
                                           value="0" id="plan_name_{{$loneid}}" 
                                           onclick="check_lone_row({{$mid}},{{$loneid}},{{$sl}},{{count($lavel_one_plan_arr[$mid])}})">
                                          <label class="form-check-label" for="plan_name_{{$loneid}}">

                                          <input type="hidden" id="plan_id_{{$loneid}}" name="plan_id[]" value="{{$loneid}}">
                                          <input type="hidden" id="plan_value_{{$loneid}}" name="plan_value[]" value="0">
                                            <strong> &nbsp;&nbsp;&nbsp;{{$lonevalue['plan_name']}}</strong>
                                          </label>
                                        </div>
                                       
                                      @endif
                                      
                                      
                                    </td>
                                    @if($lonevalue['amount_applicable']==1)
                                      <td>{{$lonevalue['plan_a']}}</td>
                                      <td>{{$lonevalue['plan_b']}}</td>
                                      <td>{{$lonevalue['plan_c']}}</td>
                                      <td>{{$lonevalue['plan_d']}}</td>
                                    @else
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                    @endif
                                  </tr>
                                  <?php $sl++; ?>
                                @endforeach
                              @endif
                            @endforeach
                              
                             
                              
                          </tbody>
                          <tfoot align="center">
                            <tr id="monthly_total">
                              <th > Monthly Total
                                <input type="hidden" id="monthly_total_single_owner" name="monthly_total_single_owner" value="0" />
                                <input type="hidden" id="monthly_total_multiple_owner" name="monthly_total_multiple_owner" value="0" />
                                <input type="hidden" id="monthly_total_multi_building_single_owner" name="monthly_total_multi_building_single_owner" value="0" />
                                <input type="hidden" id="monthly_total_multi_building_multi_owner" name="monthly_total_multi_building_multi_owner" value="0" />
                              
                              </th>
                              <th></th>
                              <th></th>
                              <th></th>
                               <th></th>
                            </tr>
                            <tr id="yearly_total_gess">
                              <th> <del>Yearly Total</del></th>
                              <th><del></del></th>
                              <th><del></del></th>
                              <th><del></del></th>
                              <th><del></del></th>
                            </tr>
                            <tr id="yearly_total">
                              <th>Yearly Total (20% off)
                                <input type="hidden" id="yearly_total_single_owner" name="yearly_total_single_owner" value="0" />
                                <input type="hidden" id="yearly_total_multiple_owner" name="yearly_total_multiple_owner" value="0" />
                                <input type="hidden" id="yearly_total_multi_building_single_owner" name="yearly_total_multi_building_single_owner" value="0" />
                                <input type="hidden" id="yearly_total_multi_building_multi_owner" name="yearly_total_multi_building_multi_owner" value="0" />
                              </th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                            </tr>
                          </tfoot>
                        </table>
                        <table  class="text-center " style="font-size:13px; line-height:12px;" align="center">
                              <tbody>

                                <tr align="center" style="line-height:30px;">
                                  <td colspan="4" align="center">
                                        
                                      <div class="form-group">
                                          <button type="submit" class=" btn btn-success">Save</button>
                                          <button type="submit" class=" btn btn-secondary" >Update</button>
                                      </div>
                                  </td>
                                   
                                </tr>

                              </tbody>

                        </table>

                    </fieldset> 
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="fas fa-address-book"></i>
                    <p>
                          Contact &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="far fa-file-word"></i>
                    <p>
                      Document's Submission &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  
                </li>
                <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="fas fa-file-signature"></i>
                    <p>
                      Service Contract &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  
                </li>
                <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="fas fa-file-invoice-dollar"></i>
                    <p>
                      Billing Info. &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  
                </li>
                <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="fas fa-camera"></i>
                    <p>
                      Video Conferencing &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  
                </li>
                <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="far fa-check-square"></i>
                    <p>
                       Activation&nbsp; &nbsp;&nbsp;

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
<script type="text/javascript">

  

  $(document).ready(function(){

      $("#landlord_rantal").click(function(){
        if($(this).prop("checked") == true){
                $("#landlord_leasehold").prop('checked', false);
                $("#landlord_both").prop('checked', false);
                $("#strata_rental").prop('checked', false);
                $("#strata_leasehold").prop('checked', false);
                $("#strata_both").prop('checked', false);

                $("#landlord_rantal").val("1");

                $("#landlord_leasehold").val("0");
                $("#landlord_both").val("0");
                $("#strata_rental").val("0");
                $("#strata_leasehold").val("0");
                $("#strata_both").val("0");
            }
      });

      $("#landlord_leasehold").click(function(){
        if($(this).prop("checked") == true){
                $("#landlord_rantal").prop('checked', false);
                $("#landlord_both").prop('checked', false);
                $("#strata_rental").prop('checked', false);
                $("#strata_leasehold").prop('checked', false);
                $("#strata_both").prop('checked', false);

                $("#landlord_leasehold").val("1");

                $("#landlord_rantal").val("0");
                $("#landlord_both").val("0");
                $("#strata_rental").val("0");
                $("#strata_leasehold").val("0");
                $("#strata_both").val("0");
            }
      });

       $("#landlord_both").click(function(){
        if($(this).prop("checked") == true){
                $("#landlord_rantal").prop('checked', false);
                $("#landlord_leasehold").prop('checked', false);
                $("#strata_rental").prop('checked', false);
                $("#strata_leasehold").prop('checked', false);
                $("#strata_both").prop('checked', false);


                $("#landlord_rantal").val("0");
                $("#landlord_leasehold").val("0");
                $("#strata_rental").val("0");
                $("#strata_leasehold").val("0");
                $("#strata_both").val("0");

                $("#landlord_both").val("1");
            }
      });




       $("#strata_rental").click(function(){
        if($(this).prop("checked") == true){
                $("#strata_leasehold").prop('checked', false);
                $("#strata_both").prop('checked', false);
                $("#landlord_rantal").prop('checked', false);
                $("#landlord_leasehold").prop('checked', false);
                $("#landlord_both").prop('checked', false);

                $("#strata_leasehold").val("0");
                $("#strata_both").val("0");
                $("#landlord_rantal").val("0");
                $("#landlord_leasehold").val("0");
                $("#landlord_both").val("0");

                $("#strata_rental").val("1");
            }
      });

      $("#strata_leasehold").click(function(){
        if($(this).prop("checked") == true){
                $("#strata_rental").prop('checked', false);
                $("#strata_both").prop('checked', false);
                $("#landlord_rantal").prop('checked', false);
                $("#landlord_leasehold").prop('checked', false);
                $("#landlord_both").prop('checked', false);

                $("#strata_leasehold").val("1");

                $("#strata_rental").val("0");
                $("#strata_both").val("0");
                $("#landlord_rantal").val("0");
                $("#landlord_leasehold").val("0");
                $("#landlord_both").val("0");
            }
      });

       $("#strata_both").click(function(){
        if($(this).prop("checked") == true){
                $("#strata_rental").prop('checked', false);
                $("#strata_leasehold").prop('checked', false);
                $("#landlord_rantal").prop('checked', false);
                $("#landlord_leasehold").prop('checked', false);
                $("#landlord_both").prop('checked', false);

                $("#strata_rental").val("0");
                $("#strata_leasehold").val("0");
                $("#landlord_rantal").val("0");
                $("#landlord_leasehold").val("0");
                $("#landlord_both").val("0");

                $("#strata_both").val("1");
            }
      });
  });
  

  function plan_checked(plan_name)
  {

    if($("#"+plan_name).prop("checked") == true){
           if(plan_name=="plan_a") {
              $("#plan_b").prop('checked', false);
              $("#plan_c").prop('checked', false);
              $("#plan_d").prop('checked', false);

              $("#single_owner").val('1');
              $("#multiple_owner").val('0');
              $("#single_owner_multiproperty").val('0');
              $("#multiple_owner_multiproperty").val('0');

              $("#"+plan_name).parent().parent().addClass('th_enable');
              $("#plan_b").parent().parent().removeClass('th_enable');
              $("#plan_c").parent().parent().removeClass('th_enable');
              $("#plan_d").parent().parent().removeClass('th_enable');
              $("#service_plan_table").find('tbody tr').each(function ()
              {
                if($(this).find('input[type=checkbox').prop("checked") == true)
                {

                  $(this).find("td:eq(1)").addClass('td_enable');
                  $(this).find("td:eq(2)").removeClass('td_enable');
                  $(this).find("td:eq(3)").removeClass('td_enable');
                  $(this).find("td:eq(4)").removeClass('td_enable');
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
              $("#plan_d").prop('checked', false);

              $("#single_owner").val('0');
              $("#multiple_owner").val('1');
              $("#single_owner_multiproperty").val('0');
              $("#multiple_owner_multiproperty").val('0');

              $("#"+plan_name).parent().parent().addClass('th_enable');
              $("#plan_a").parent().parent().removeClass('th_enable');
              $("#plan_c").parent().parent().removeClass('th_enable');
              $("#plan_d").parent().parent().removeClass('th_enable');

              $("#service_plan_table").find('tbody tr').each(function ()
              {
                if($(this).find('input[type=checkbox').prop("checked") == true)
                {
                  $(this).find("td:eq(2)").addClass('td_enable');
                  $(this).find("td:eq(1)").removeClass('td_enable');
                  $(this).find("td:eq(3)").removeClass('td_enable');
                  $(this).find("td:eq(4)").removeClass('td_enable');
                }
              });
              calculate_total_amount();
           } 
           else if(plan_name=="plan_c") {
              $("#plan_b").prop('checked', false);
              $("#plan_a").prop('checked', false);
              $("#plan_d").prop('checked', false);

              $("#single_owner").val('0');
              $("#multiple_owner").val('0');
              $("single_owner_multiproperty").val('1');
              $("#multiple_owner_multiproperty").val('0');

              $("#"+plan_name).parent().parent().addClass('th_enable');
              $("#plan_b").parent().parent().removeClass('th_enable');
              $("#plan_a").parent().parent().removeClass('th_enable');
              $("#plan_d").parent().parent().removeClass('th_enable');
              
              $("#service_plan_table").find('tbody tr').each(function ()
              {
                if($(this).find('input[type=checkbox').prop("checked") == true)
                {

                  $(this).find("td:eq(3)").addClass('td_enable');
                  $(this).find("td:eq(2)").removeClass('td_enable');
                  $(this).find("td:eq(1)").removeClass('td_enable');
                  $(this).find("td:eq(4)").removeClass('td_enable');
                }
              });
              calculate_total_amount();
           } 
           else if(plan_name=="plan_d") {
              $("#plan_b").prop('checked', false);
              $("#plan_c").prop('checked', false);
              $("#plan_a").prop('checked', false);

              $("#single_owner").val('0');
              $("#multiple_owner").val('0');
              $("#single_owner_multiproperty").val('0');
              $("#multiple_owner_multiproperty").val('1');

              $("#"+plan_name).parent().parent().addClass('th_enable');
              $("#plan_b").parent().parent().removeClass('th_enable');
              $("#plan_c").parent().parent().removeClass('th_enable');
              $("#plan_a").parent().parent().removeClass('th_enable');
             

              $("#service_plan_table").find('tbody tr').each(function ()
              {
                if($(this).find('input[type=checkbox').prop("checked") == true)
                {

                  $(this).find("td:eq(4)").addClass('td_enable');
                  $(this).find("td:eq(2)").removeClass('td_enable');
                  $(this).find("td:eq(3)").removeClass('td_enable');
                  $(this).find("td:eq(1)").removeClass('td_enable');
                }
              });

              calculate_total_amount();
           }    
      }
      else
      {
         $("#"+plan_name).parent().parent().removeClass('th_enable');
        
            if(plan_name=="plan_a") {
              $(this).find("td:eq(1)").removeClass('td_enable');
              $("#service_plan_table").find('tbody tr').each(function ()
              {
                  $(this).find("td:eq(1)").removeClass('td_enable');    
              });
            }
            else if(plan_name=="plan_b") {
              $(this).find("td:eq(2)").removeClass('td_enable');
              $("#service_plan_table").find('tbody tr').each(function ()
              {
                  $(this).find("td:eq(2)").removeClass('td_enable');    
              });
            }
            else if(plan_name=="plan_c") {
              $(this).find("td:eq(3)").removeClass('td_enable');
              $("#service_plan_table").find('tbody tr').each(function ()
              {
                  $(this).find("td:eq(3)").removeClass('td_enable');    
              });
            }
            else if(plan_name=="plan_d") {
              $(this).find("td:eq(4)").removeClass('td_enable');
              $("#service_plan_table").find('tbody tr').each(function ()
              {
                  $(this).find("td:eq(4)").removeClass('td_enable');    
              });
            }
          
            calculate_total_amount();
         
      }

  }

  function calculate_total_amount()
  {
    var total_monthly_amount=0;
    if($("#plan_a").prop("checked") == true){

      
       $("#service_plan_table").find('tbody tr').each(function ()
        {
          if($(this).find('input[type=checkbox').prop("checked") == true)
          {
            //alert($(this).find("td:eq(1)").text());
            total_monthly_amount+=$(this).find("td:eq(1)").text()*1;
          }
        });

      // alert($("#yearly_total_gess").find("th:eq(1)").children().text());
        $("#monthly_total").find("th:eq(1)").text(total_monthly_amount);
        $("#monthly_total").find("th:eq(2)").text('');
        $("#monthly_total").find("th:eq(3)").text('');
        $("#monthly_total").find("th:eq(4)").text('');

        $("#monthly_total_single_owner").val(total_monthly_amount);
        $("#monthly_total_multiple_owner").val('0');
        $("#monthly_total_multi_building_single_owner").val('0');
        $("#monthly_total_multi_building_multi_owner").val('0');

        var yearly_total=total_monthly_amount*12;
        var yearly_total_actual=total_monthly_amount*.8*12;
        $("#yearly_total_gess").find("th:eq(1)").children().text(yearly_total);
        $("#yearly_total_gess").find("th:eq(2)").children().text('');
        $("#yearly_total_gess").find("th:eq(3)").children().text('');
        $("#yearly_total_gess").find("th:eq(4)").children().text('');

        $("#yearly_total").find("th:eq(1)").text(yearly_total_actual);
        $("#yearly_total").find("th:eq(2)").text('');
        $("#yearly_total").find("th:eq(3)").text('');
        $("#yearly_total").find("th:eq(4)").text('');

        $("#yearly_total_single_owner").val(yearly_total_actual);
        $("#yearly_total_multiple_owner").val('0');
        $("#yearly_total_multi_building_single_owner").val('0');
        $("#yearly_total_multi_building_multi_owner").val('0');
    }
    else if($("#plan_b").prop("checked") == true){
      
       $("#service_plan_table").find('tbody tr').each(function ()
        {
          if($(this).find('input[type=checkbox').prop("checked") == true)
          {
            //alert($(this).find("td:eq(1)").text());
            total_monthly_amount+=$(this).find("td:eq(2)").text()*1;
          }
        });

        $("#monthly_total").find("th:eq(2)").text(total_monthly_amount);
        $("#monthly_total").find("th:eq(1)").text('');
        $("#monthly_total").find("th:eq(3)").text('');
        $("#monthly_total").find("th:eq(4)").text('');

        $("#monthly_total_single_owner").val('0');
        $("#monthly_total_multiple_owner").val(total_monthly_amount);
        $("#monthly_total_multi_building_single_owner").val('0');
        $("#monthly_total_multi_building_multi_owner").val('0');

        var yearly_total=total_monthly_amount*12;
        var yearly_total_actual=total_monthly_amount*.8*12;

        $("#yearly_total_gess").find("th:eq(2)").children().text(yearly_total);
        $("#yearly_total_gess").find("th:eq(1)").children().text('');
        $("#yearly_total_gess").find("th:eq(3)").children().text('');
        $("#yearly_total_gess").find("th:eq(4)").children().text('');

        $("#yearly_total").find("th:eq(2)").text(yearly_total_actual);
        $("#yearly_total").find("th:eq(1)").text('');
        $("#yearly_total").find("th:eq(3)").text('');
        $("#yearly_total").find("th:eq(4)").text('');

        $("#yearly_total_single_owner").val('0');
        $("#yearly_total_multiple_owner").val(yearly_total_actual);
        $("#yearly_total_multi_building_single_owner").val('0');
        $("#yearly_total_multi_building_multi_owner").val('0');

    }

    else if($("#plan_c").prop("checked") == true){
      
       $("#service_plan_table").find('tbody tr').each(function ()
        {
          if($(this).find('input[type=checkbox').prop("checked") == true)
          {
            //alert($(this).find("td:eq(1)").text());
            total_monthly_amount+=$(this).find("td:eq(3)").text()*1;
          }
        });
        $("#monthly_total").find("th:eq(3)").text(total_monthly_amount);
        $("#monthly_total").find("th:eq(2)").text('');
        $("#monthly_total").find("th:eq(1)").text('');
        $("#monthly_total").find("th:eq(4)").text('');

        $("#monthly_total_single_owner").val('0');
        $("#monthly_total_multiple_owner").val('0');
        $("#monthly_total_multi_building_single_owner").val(total_monthly_amount);
        $("#monthly_total_multi_building_multi_owner").val('0');

        var yearly_total=total_monthly_amount*12;
        var yearly_total_actual=total_monthly_amount*.8*12;

        $("#yearly_total_gess").find("th:eq(3)").children().text(yearly_total);
        $("#yearly_total_gess").find("th:eq(1)").children().text('');
        $("#yearly_total_gess").find("th:eq(2)").children().text('');
        $("#yearly_total_gess").find("th:eq(4)").children().text('');

        $("#yearly_total").find("th:eq(3)").text(yearly_total_actual);
        $("#yearly_total").find("th:eq(2)").text('');
        $("#yearly_total").find("th:eq(1)").text('');
        $("#yearly_total").find("th:eq(4)").text('');

        $("#yearly_total_single_owner").val('0');
        $("#yearly_total_multiple_owner").val('0');
        $("#yearly_total_multi_building_single_owner").val(yearly_total_actual);
        $("#yearly_total_multi_building_multi_owner").val('0');

    }
    else if($("#plan_d").prop("checked") == true){
      
       $("#service_plan_table").find('tbody tr').each(function ()
        {
          if($(this).find('input[type=checkbox').prop("checked") == true)
          {
            total_monthly_amount+=$(this).find("td:eq(4)").text()*1;
          }
        });

        $("#monthly_total").find("th:eq(4)").text(total_monthly_amount);
        $("#monthly_total").find("th:eq(2)").text('');
        $("#monthly_total").find("th:eq(3)").text('');
        $("#monthly_total").find("th:eq(1)").text('');

        $("#monthly_total_single_owner").val('0');
        $("#monthly_total_multiple_owner").val('0');
        $("#monthly_total_multi_building_single_owner").val('0');
        $("#monthly_total_multi_building_multi_owner").val(total_monthly_amount);

        var yearly_total=total_monthly_amount*12;
        var yearly_total_actual=total_monthly_amount*.8*12;

        $("#yearly_total_gess").find("th:eq(4)").children().text(yearly_total);
        $("#yearly_total_gess").find("th:eq(1)").children().text('');
        $("#yearly_total_gess").find("th:eq(3)").children().text('');
        $("#yearly_total_gess").find("th:eq(2)").children().text('');

        $("#yearly_total").find("th:eq(4)").text(yearly_total_actual);
        $("#yearly_total").find("th:eq(2)").text('');
        $("#yearly_total").find("th:eq(3)").text('');
        $("#yearly_total").find("th:eq(1)").text('');

        $("#yearly_total_single_owner").val('0');
        $("#yearly_total_multiple_owner").val('0');
        $("#yearly_total_multi_building_single_owner").val('0');
        $("#yearly_total_multi_building_multi_owner").val(yearly_total_actual);

    }
    else 
    {
        $("#monthly_total").find("th:eq(4)").text('');
        $("#monthly_total").find("th:eq(2)").text('');
        $("#monthly_total").find("th:eq(3)").text('');
        $("#monthly_total").find("th:eq(1)").text('');

        $("#monthly_total_single_owner").val('0');
        $("#monthly_total_multiple_owner").val('0');
        $("#monthly_total_multi_building_single_owner").val('0');
        $("#monthly_total_multi_building_multi_owner").val('0');

        $("#yearly_total_gess").find("th:eq(4)").children().text('');
        $("#yearly_total_gess").find("th:eq(1)").children().text('');
        $("#yearly_total_gess").find("th:eq(3)").children().text('');
        $("#yearly_total_gess").find("th:eq(2)").children().text('');

        $("#yearly_total").find("th:eq(4)").text('');
        $("#yearly_total").find("th:eq(2)").text('');
        $("#yearly_total").find("th:eq(3)").text('');
        $("#yearly_total").find("th:eq(1)").text('');

        $("#yearly_total_single_owner").val('0');
        $("#yearly_total_multiple_owner").val('0');
        $("#yearly_total_multi_building_single_owner").val('0');
        $("#yearly_total_multi_building_multi_owner").val('0');
    }
  }

  function check_lone_row(mid,lone_id,sl,total_row){

    if($("#plan_name_"+lone_id).prop("checked") == true)
    {
        $("#plan_value_"+lone_id).val("1");
        if($("#plan_a").prop("checked") == true){
           $("#tr_"+mid+"_"+sl).find("td:eq(1)").addClass('td_enable');
        }
        else if($("#plan_b").prop("checked") == true){
           $("#tr_"+mid+"_"+sl).find("td:eq(2)").addClass('td_enable');
        }
        else if($("#plan_c").prop("checked") == true){
           $("#tr_"+mid+"_"+sl).find("td:eq(3)").addClass('td_enable');
        }
        else if($("#plan_d").prop("checked") == true){
           $("#tr_"+mid+"_"+sl).find("td:eq(4)").addClass('td_enable');
        }
        else {
           swal("Plan Not Selected","Please select a Suitable Plan","warning");
           $("#plan_name_"+lone_id).prop("checked",false); 
           $("#plan_value_"+lone_id).val("0");
           return;
        }

        for(var i=1; i<=total_row; i++)
        {
          if(i!=sl){

            $("#tr_"+mid+"_"+i).find('input[name=plan_value[]').val("0");
            $("#tr_"+mid+"_"+i).find('input[type=checkbox').prop('checked', false);
            $("#tr_"+mid+"_"+i).find("td:eq(1)").removeClass('td_enable');
            $("#tr_"+mid+"_"+i).find("td:eq(2)").removeClass('td_enable');
            $("#tr_"+mid+"_"+i).find("td:eq(3)").removeClass('td_enable');
            $("#tr_"+mid+"_"+i).find("td:eq(4)").removeClass('td_enable');
          }
            
        }
    }
    else
    {
      $("#plan_value_"+lone_id).val("0");
      $("#tr_"+mid+"_"+sl).find("td:eq(1)").removeClass('td_enable');
      $("#tr_"+mid+"_"+sl).find("td:eq(2)").removeClass('td_enable');
      $("#tr_"+mid+"_"+sl).find("td:eq(3)").removeClass('td_enable');
      $("#tr_"+mid+"_"+sl).find("td:eq(4)").removeClass('td_enable');
    }
    calculate_total_amount();
  }


  function check_master_row(row_id)
  {
    if($("#plan_name_"+row_id).prop("checked") == true)
    {

        $("#plan_value_"+row_id).val("1");

        if($("#plan_a").prop("checked") == true){
           $("#tr_"+row_id).find("td:eq(1)").addClass('td_enable');
        }
        else if($("#plan_b").prop("checked") == true){
           $("#tr_"+row_id).find("td:eq(2)").addClass('td_enable');
        }
        else if($("#plan_c").prop("checked") == true){
           $("#tr_"+row_id).find("td:eq(3)").addClass('td_enable');
        }
        else if($("#plan_d").prop("checked") == true){
           $("#tr_"+row_id).find("td:eq(4)").addClass('td_enable');
        }
        else
        {
           swal("Plan Not Selected","Please select a Suitable Plan","warning");
           $("#plan_name_"+row_id).prop("checked",false); 
           $("#plan_value_"+row_id).val("0");
           return;
        }
    }
    else
    {
      $("#plan_value_"+row_id).val("0");
      $("#tr_"+row_id).find("td:eq(1)").removeClass('td_enable');
      $("#tr_"+row_id).find("td:eq(2)").removeClass('td_enable');
      $("#tr_"+row_id).find("td:eq(3)").removeClass('td_enable');
      $("#tr_"+row_id).find("td:eq(4)").removeClass('td_enable');
    }
    calculate_total_amount();
  }
  function display_child_row(mid,total_row)
  {
    if(total_row>0)
    {

      for(var i=1;i<=total_row; i++)
      {
        if($("#tr_"+mid+"_"+i).hasClass("tr_disable"))
        {
          $("#tr_"+mid+"_"+i).removeClass('tr_disable');
        }
        else
        {
          $("#tr_"+mid+"_"+i).addClass('tr_disable');
        }
        
      }
    }
  }

  //======================Enable Monthly or Yearly========================================
  function enable_monthly_yearly()
  {

    if($("#servicePlanMonthly").hasClass("montly_enable"))
    {
      $("#servicePlanMonthlyYearly").val('0');
      $("#service_plan_type").val('0');
      
      $("#servicePlanMonthly").removeClass("montly_enable");
      $("#servicePlanMonthly").addClass("yearly_disable");
    }
    else
    {
      $("#servicePlanMonthlyYearly").val('1');
      $("#service_plan_type").val('1');

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
            //$("#responsecontainer").html(response); 
            $('#'+provience_id).children().remove().end().append(response) ;
           // alert(response);
        }

    });
    
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
      color:#13F709;
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
      background-color: #0BB504;
    }

    input:focus + .btnonof {
      box-shadow: 0 0 1px #0BB504;
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