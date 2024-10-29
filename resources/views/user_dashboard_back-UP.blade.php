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
                <li class="nav-item has-treeview menu-open">
                  <a href="#" class="nav-link active" style="width:250px;">
                    
                    <i class="fas fa-building"></i>
                    <p>
                      Company Profile &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" >
                    <div class="card" style="border: 2px solid #000" sytle="display:none;" align="center">
                      <div class="card-heading">
                      </div>
                        <div class="card-body">
                          {!! Form::open(array('class' => 'contact-form','route' => 'user_company.store','method'=>'POST')) !!}
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
                                          <input  type="text" name="legal_name"  class="form-control" required>
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
                                        
                                      <div class="form-group">
                                          <button 
                                          type="button"
                                          class="btn btn-info fullpwidth" 
                                          onclick="addCompanylogo()">Browse</button>
                                      </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="4">

                                    <fieldset >
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
                                                  {!! Form::select('company_provience_id',[null=>"Select Provience"],null, array('required','id' =>'company_provience_id','class' => 'form-control')) !!}

                                                  @if ($errors->has('company_provience_id'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_provience_id') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  {!! Form::select('head_office_provience_id',[null=>"Select Provience"],null, array('required','id' =>'head_office_provience_id','class' => 'form-control')) !!}

                                                  @if ($errors->has('head_office_provience_id'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_provience_id') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    {!! Form::select('property_provience_id',[null=>"Select Provience"],null, array('required','id' =>'property_provience_id','class' => 'form-control')) !!}

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
                                                  <input  type="text" name="company_city" class="form-control" id="company_city" required>
                                                  @if ($errors->has('company_city'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_city') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_city" class="form-control" id="head_office_city" required>
                                                  @if ($errors->has('head_office_city'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_city') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_city" class="form-control" id="property_city" required>
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
                                                  <input  type="text" name="company_street_no" class="form-control" id="company_street_no" required>
                                                  @if ($errors->has('company_street_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_street_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_street_no" class="form-control" id="head_office_street_no" required>
                                                  @if ($errors->has('head_office_street_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_street_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_street_no" class="form-control" id="property_street_no" required>
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
                                                  <input  type="text" name="company_postal_code" class="form-control" id="company_postal_code" required>
                                                  @if ($errors->has('company_postal_code'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_postal_code') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_postal_code" class="form-control" id="head_office_postal_code" required>
                                                  @if ($errors->has('head_office_postal_code'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_postal_code') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_postal_code" class="form-control" id="property_postal_code" required>
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
                                                  <input  type="text" name="company_po_box" class="form-control" id="company_po_box" required>
                                                  @if ($errors->has('company_po_box'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_po_box') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_po_box" class="form-control" id="head_office_po_box" required>
                                                  @if ($errors->has('head_office_po_box'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_po_box') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_po_box" class="form-control" id="property_po_box" required>
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
                                                  <input  type="text" name="company_business_no" class="form-control" id="company_business_no" required>
                                                  @if ($errors->has('company_business_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_business_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_business_no" class="form-control" id="head_office_business_no" required>
                                                  @if ($errors->has('head_office_business_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_business_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_business_no" class="form-control" id="property_business_no" required>
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
                                                  <input  type="text" name="company_phone" class="form-control" id="company_phone" required>
                                                  @if ($errors->has('company_phone'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_phone') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_phone" class="form-control" id="head_office_phone" required>
                                                  @if ($errors->has('head_office_phone'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_phone') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_phone" class="form-control" id="property_phone" required>
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
                                                  <input  type="text" name="company_mobile_no" class="form-control" id="company_mobile_no" required>
                                                  @if ($errors->has('company_mobile_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_mobile_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_mobile_no" class="form-control" id="head_office_mobile_no" required>
                                                  @if ($errors->has('head_office_mobile_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_mobile_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_mobile_no" class="form-control" id="property_mobile_no" required>
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
                                                  <input  type="text" name="company_fax_no" class="form-control" id="company_fax_no" required>
                                                  @if ($errors->has('company_fax_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_fax_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_fax_no" class="form-control" id="head_office_fax_no" required>
                                                  @if ($errors->has('head_office_fax_no'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_fax_no') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_fax_no" class="form-control" id="property_fax_no" required>
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
                                                  <input  type="text" name="company_website" class="form-control" id="company_website" required> 
                                                  @if ($errors->has('company_website'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_website') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="text" name="head_office_website" class="form-control" id="head_office_website" required>
                                                  @if ($errors->has('head_office_website'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_website') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="text" name="property_website" class="form-control" id="property_website" required>
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
                                                  <input  type="email" name="company_email" class="form-control" id="company_email" required>
                                                  @if ($errors->has('company_email'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('company_email') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input  type="email" name="head_office_email" class="form-control" id="head_office_email" required>
                                                  @if ($errors->has('head_office_email'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('head_office_email') }}</strong>
                                                      </span>
                                                  @endif
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input  type="email" name="property_email" class="form-control" id="property_email" required>
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
                          
                  
                              </tbody>
                             </table>
                            </div>
                           
                            <div class="form-navigation">
                              <button type="submit" class=" btn btn-success float-right">Save</button>
                              <button type="submit" class=" btn btn-success float-right" disabled>Update</button>
                            </div>

                          {!! Form::close() !!}
                        </div>
                      </div>
                   
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="fas fa-venus-double"></i>
                    <p>
                      Property management type  &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    
                    <fieldset style="width:550px; margin-left:250px;">
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
                                          <input type="checkbox" value="" name="landlord_rantal" id="landlord_rantal">
                                          <label for="landlord_rantal">Rental</label>
                                        </div>
                              </td>
                              <td>
                                   <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="strata_rental" id="strata_rental">
                                    <label for="strata_rental">Rental</label>
                                </div>    
                              </td>

                             
                            </tr>

                            <tr>
                              <td>
                                      
                                  <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="todo3" id="landlord_leasehold">
                                    <label for="landlord_leasehold">Leasehold</label>
                                  </div>
                                
                              </td>
                              <td>
                                   <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="strata_leasehold" id="strata_leasehold">
                                    <label for="strata_leasehold">Leasehold</label>
                                </div>    
                              </td>

                             
                            </tr>
                            <tr>
                              <td>
                                      
                                <div  class="icheck-primary d-inline ml-2">
                                  <input type="checkbox" value="" name="landlord_both" id="landlord_both">
                                  <label for="landlord_both">Both</label>
                                </div>
                                
                              </td>
                              <td>
                                   <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="todo3" id="strata_both">
                                    <label for="strata_both">Both</label>
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
                    
                    <i class="fab fa-think-peaks"></i>
                    <p>
                      Service Plans  &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    
                     <fieldset style="width:1100px; margin-left:250px;">
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
                                      name="servicePlanMonthlyYearly" checked>
                                      <span class="btnonof round"></span>
                                    </label>
                                    <label for="servicePlanYearly" id="servicePlanYearly" class="yearly_disable">Yearly</label>

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
                                    <input type="checkbox" value="" name="plan_a" id="plan_a"
                                    onclick="plan_checked('plan_a')">
                                    <label for="plan_a"> Plan A</label>
                                  </div>
                               </th>
                              <th>
                                <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="plan_b" id="plan_b"
                                    onclick="plan_checked('plan_b')">
                                    <label for="plan_b">Plan B</label>
                                </div>
                              </th>
                              <th>
                                <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="plan_c" id="plan_c"
                                    onclick="plan_checked('plan_c')">
                                    <label for="plan_c">Plan C</label>
                                </div> 
                              </th>
                              <th>
                                <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="plan_d" id="plan_d"
                                    onclick="plan_checked('plan_d')">
                                    <label for="plan_d">Plan D</label>
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
                                @else
                                  <div class="form-check">
                                      <input class="form-check-input" name="plan_name_{{$mid}}" type="checkbox" 
                                      value="" id="plan_name_{{$mid}}"
                                      onclick="check_master_row({{$mid}})"
                                       <?php if($mid==1) echo "checked disabled"; ?>>
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
                                    @else
                                       <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="plan_name_{{$loneid}}"
                                         value="" id="plan_name_{{$loneid}}" 
                                         onclick="check_lone_row({{$mid}},{{$loneid}},{{$sl}},{{count($lavel_one_plan_arr[$mid])}})">
                                        <label class="form-check-label" for="plan_name_{{$loneid}}">
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
                            <th > Monthly Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                             <th></th>
                          </tr>
                          <tr id="yearly_total_gess">
                            <th rowspan="2"> <del>Yearly Total</del></th>
                            <th><del>4000</del></th>
                            <th><del></del></th>
                            <th><del></del></th>
                            <th><del></del></th>
                          </tr>
                          <tr id="yearly_total">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </tfoot>
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
                  <ul class="nav nav-treeview">
                    <div class="card" style="border: 2px solid #000" sytle="display:none;" align="center">
                      <div class="card-heading">
                      </div>
                      <div class="card-body">
                        <fieldset >
                          <legend>Contact Information</legend>
                          <table width="100%" class=" ">
                            <thead>

                              <tr>
                                <th align="center"><strong> Particular</strong></th>
                                <th align="center"><strong> Director</strong></th>
                                <th align="center"> <strong>Property Manager</strong></th>
                                <th align="center"> <strong>System Administrator</strong></th>

                                <th align="center"><strong> Accounting Manager</strong></th>
                                <th align="center"><strong> Accounts Payable</strong></th>
                                <th align="center"> <strong>Authorized Person</strong></th>
                              </tr>
                            </thead>                      
                            <tbody class="text-left">
                                   
                              <tr>
                                <td  >
                                  <div class="form-lebel"  >
                                    Ligal Name
                                  </div>
                                </td>
                              
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="ligal_name_1"
                                      id="ligal_name_1"
                                      placeholder="First-Middle-Last Name" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="ligal_name_1"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="ligal_name_2"
                                      id="ligal_name_2"
                                      placeholder="First-Middle-Last Name" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="ligal_name_2"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="ligal_name_3"
                                      id="ligal_name_3"
                                      placeholder="First-Middle-Last Name" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="ligal_name_3"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="ligal_name_4"
                                      id="ligal_name_4"
                                      placeholder="First-Middle-Last Name" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="ligal_name_4"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="ligal_name_5"
                                      id="ligal_name_5"
                                      placeholder="First-Middle-Last Name" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="ligal_name_5"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="ligal_name_6"
                                      id="ligal_name_6"
                                      placeholder="First-Middle-Last Name" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="ligal_name_6"></has-error>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td >
                                  <div class="form-lebel" >
                                    Country 
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    {!! Form::select('country_id_1',[null=>"Select Country name"]+ $country_arr,null, array('id' =>'country_id_1','onchange' => 'change_country_dropdown(this.id,"provience_id_1")','class' => 'form-control','required')) !!}

                                      @if ($errors->has('country_id_1'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('country_id_1') }}</strong>
                                          </span>
                                      @endif
                                    </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    {!! Form::select('country_id_2',[null=>"Select Country name"]+ $country_arr,null, array('id' =>'country_id_2','onchange' => 'change_country_dropdown(this.id,"provience_id_2")','class' => 'form-control','required')) !!}

                                      @if ($errors->has('country_id_2'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('country_id_2') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    {!! Form::select('country_id_3',[null=>"Select Country name"]+ $country_arr,null, array('id' =>'country_id_3','onchange' => 'change_country_dropdown(this.id,"provience_id_3")','class' => 'form-control','required')) !!}

                                      @if ($errors->has('country_id_3'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('country_id_3') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    {!! Form::select('country_id_4',[null=>"Select Country name"]+ $country_arr,null, array('id' =>'country_id_4','onchange' => 'change_country_dropdown(this.id,"provience_id_4")','class' => 'form-control','required')) !!}

                                      @if ($errors->has('country_id_4'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('country_id_4') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    {!! Form::select('country_id_5',[null=>"Select Country name"]+ $country_arr,null, array('id' =>'country_id_5','onchange' => 'change_country_dropdown(this.id,"provience_id_5")','class' => 'form-control','required')) !!}

                                      @if ($errors->has('country_id_5'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('country_id_5') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    {!! Form::select('country_id_6',[null=>"Select Country name"]+ $country_arr,null, array('id' =>'country_id_6','onchange' => 'change_country_dropdown(this.id,"provience_id_6")','class' => 'form-control','required')) !!}

                                    @if ($errors->has('country_id_6'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('country_id_6') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                </td>  
                                
                              </tr>
                              <tr>
                                <td >
                                  <div class="form-lebel" >
                                    Provience 
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    {!! Form::select('provience_id_1',[null=>"Select Provience"],null, array('id' =>'provience_id_1','class' => 'form-control','required')) !!}

                                      @if ($errors->has('provience_id_1'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('provience_id_1') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    {!! Form::select('provience_id_2',[null=>"Select Provience"],null, array('id' =>'provience_id_2','class' => 'form-control','required')) !!}

                                      @if ($errors->has('provience_id_2'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('provience_id_2') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    {!! Form::select('provience_id_3',[null=>"Select Provience"],null, array('id' =>'provience_id_3','class' => 'form-control','required')) !!}

                                      @if ($errors->has('provience_id_3'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('provience_id_3') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    {!! Form::select('provience_id_4',[null=>"Select Provience"],null, array('id' =>'provience_id_4','class' => 'form-control','required')) !!}

                                      @if ($errors->has('provience_id_4'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('provience_id_4') }}</strong>
                                          </span>
                                      @endif
                                  </div>    
                                </td>
                                <td>
                                  <div class="form-group">
                                    {!! Form::select('provience_id_5',[null=>"Select Provience"],null, array('id' =>'provience_id_5','class' => 'form-control','required')) !!}

                                      @if ($errors->has('provience_id_5'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('provience_id_5') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    {!! Form::select('provience_id_6',[null=>"Select Provience"],null, array('id' =>'provience_id_6','class' => 'form-control','required')) !!}

                                    @if ($errors->has('provience_id_6'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('provience_id_6') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                </td>  
                                
                              </tr>
                              
                              <tr>
                                <td  >
                                  <div class="form-lebel"  >
                                    City
                                  </div>
                                </td>
                              
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="city_1"
                                      id="city_1"
                                      placeholder="City" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="city_1"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="city_2"
                                      id="city_2"
                                      placeholder="City" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="city_2"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="city_3"
                                      id="city_3"
                                      placeholder="City" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="city_3"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="city_4"
                                      id="city_4"
                                      placeholder="City" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="city_4"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="city_5"
                                      id="city_5"
                                      placeholder="City" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="city_5"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="city_6"
                                      id="city_6"
                                      placeholder="City" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="city_6"></has-error>
                                  </div>
                                </td>
                              </tr>


                              

                              <tr>
                                <td  >
                                  <div class="form-lebel"  >
                                    Street Number / Name
                                  </div>
                                </td>
                              
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="street_number_1"
                                      id="street_number_1"
                                      placeholder="street Number" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="street_number_1"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="street_number_2"
                                      id="street_number_2"
                                      placeholder="street Number" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="street_number_2"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="street_number_3"
                                      id="street_number_3"
                                      placeholder="street Number" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="street_number_3"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="street_number_4"
                                      id="street_number_4"
                                      placeholder="street Number" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="street_number_4"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="street_number_5"
                                      id="street_number_5"
                                      placeholder="street Number" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="street_number_5"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="street_number_6"
                                      id="street_number_6"
                                      placeholder="street Number" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="street_number_6"></has-error>
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
                                      type="number"
                                      name="cpostal_code1"
                                      id="postal_code_1"
                                      placeholder="Postal Code" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="postal_code_1"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="number"
                                      name="postal_code_2"
                                      id="postal_code_2"
                                      placeholder="Postal Code" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="postal_code_2"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="number"
                                      name="postal_code_3"
                                      id="postal_code_3"
                                      placeholder="Postal Code" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="postal_code_3"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="number"
                                      name="postal_code_4"
                                      id="postal_code_4"
                                      placeholder="Postal Code" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="postal_code_4"></has-error>
                                  
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      tPpe="number"
                                      name="postal_code_5"
                                      id="postal_code_5"
                                      placeholder="Postal Code" 
                                      class="form-control" 
                                     >
                                      <has-error :form="form" field="postal_code_5"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="number"
                                      name="postal_code_6"
                                      id="postal_code_6"
                                      placeholder="Postal Code" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="postal_code_6"></has-error>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td  >
                                  <div class="form-lebel"  >
                                    Office Phone
                                  </div>
                                </td>
                              
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="tel"
                                      name="telephone_1"
                                      id="telephone_1"
                                      placeholder="Telephone" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="telephone_1"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="tel"
                                      name="telephone_2"
                                      id="telephone_2"
                                      placeholder="Telephone" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="telephone_2"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="tel"
                                      name="telephone_3"
                                      id="telephone_3"
                                      placeholder="Telephone" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="telephone_3"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="tel"
                                      name="telephone_4"
                                      id="telephone_4"
                                      placeholder="Telephone" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="telephone_4"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="tel"
                                      name="telephone_5"
                                      id="telephone_5"
                                      placeholder="Telephone" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="telephone_5"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="tel"
                                      name="telephone_6"
                                      id="telephone_6"
                                      placeholder="Telephone" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="telephone_6"></has-error>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td  >
                                  <div class="form-lebel"  >
                                    Cell Phone
                                  </div>
                                </td>
                              
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="cell_phone_1"
                                      id="cell_phone_1"
                                      placeholder="Cell Phone" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="cell_phone_1"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="cell_phone_2"
                                      id="cell_phone_2"
                                      placeholder="Cell Phone" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="cell_phone_2"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="cell_phone_3"
                                      id="cell_phone_3"
                                      placeholder="Cell Phone" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="cell_phone_3"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="cell_phone_4"
                                      id="cell_phone_4"
                                      placeholder="Cell Phone" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="cell_phone_4"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="cell_phone_5"
                                      id="cell_phone_5"
                                      placeholder="Cell Phone" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="cell_phone_5"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="cell_phone_6"
                                      id="cell_phone_6"
                                      placeholder="Cell Phone" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="cell_phone_6"></has-error>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td  >
                                  <div class="form-lebel"  >
                                    Email
                                  </div>
                                </td>
                              
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="email"
                                      name="email_1"
                                      id="email_1"
                                      placeholder="Email" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="email_1"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="email"
                                      name="email_2"
                                      id="email_2"
                                      placeholder="Email" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="email_2"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="email"
                                      name="email_3"
                                      id="email_3"
                                      placeholder="Email" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="email_3"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="email"
                                      name="email_4"
                                      id="email_4"
                                      placeholder="Email" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="email_4"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="email"
                                      name="email_5"
                                      id="email_5"
                                      placeholder="Email" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="email_5"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="email"
                                      name="email_6"
                                      id="email_6"
                                      placeholder="Email" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="email_6"></has-error>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td  >
                                  <div class="form-lebel"  >
                                    Fax No
                                  </div>
                                </td>
                              
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="fax_no_1"
                                      id="fax_no_1"
                                      placeholder="Fax No" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="fax_no_1"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="fax_no_2"
                                      id="fax_no_2"
                                      placeholder="Fax No" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="fax_no_2"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="fax_no_3"
                                      id="fax_no_3"
                                      placeholder="Fax No" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="fax_no_3"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="fax_no_4"
                                      id="fax_no_4"
                                      placeholder="Fax No" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="fax_no_4"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="fax_no_5"
                                      id="fax_no_5"
                                      placeholder="Fax No" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="fax_no_5"></has-error>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input 
                                      type="text"
                                      name="fax_no_6"
                                      id="fax_no_6"
                                      placeholder="Fax No" 
                                      class="form-control" 
                                      >
                                      <has-error :form="form" field="fax_no_6"></has-error>
                                  </div>
                                </td>
                              </tr>                        
                            </tbody>
                          </table>
                        </fieldset >
                      </div>
                    </div>
                  </ul>
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="far fa-file-word"></i>
                    <p>
                      Document's Submission &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./index.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Graph & Chart v1</p>
                      </a>
                    </li>
                    
                  </ul>
                </li>
                <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="fas fa-file-signature"></i>
                    <p>
                      Service Contract &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./index.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Graph & Chart v1</p>
                      </a>
                    </li>
                    
                  </ul>
                </li>
                <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="fas fa-file-invoice-dollar"></i>
                    <p>
                      Billing Info. &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./index.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Graph & Chart v1</p>
                      </a>
                    </li>
                    
                  </ul>
                </li>
                <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="fas fa-camera"></i>
                    <p>
                      Video Conferencing &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./index.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Graph & Chart v1</p>
                      </a>
                    </li>
                    
                  </ul>
                </li>
                <li class="nav-item has-treeview ">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="far fa-check-square"></i>
                    <p>
                       Activation&nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./index.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Graph & Chart v1</p>
                      </a>
                    </li>
                    
                  </ul>
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
            }
      });

      $("#landlord_leasehold").click(function(){
        if($(this).prop("checked") == true){
                $("#landlord_rantal").prop('checked', false);
                $("#landlord_both").prop('checked', false);
            }
      });

       $("#landlord_both").click(function(){
        if($(this).prop("checked") == true){
                $("#landlord_rantal").prop('checked', false);
                $("#landlord_leasehold").prop('checked', false);
            }
      });




       $("#strata_rental").click(function(){
        if($(this).prop("checked") == true){
                $("#strata_leasehold").prop('checked', false);
                $("#strata_both").prop('checked', false);
            }
      });

      $("#strata_leasehold").click(function(){
        if($(this).prop("checked") == true){
                $("#strata_rental").prop('checked', false);
                $("#strata_both").prop('checked', false);
            }
      });

       $("#strata_both").click(function(){
        if($(this).prop("checked") == true){
                $("#strata_rental").prop('checked', false);
                $("#strata_leasehold").prop('checked', false);
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

        var yearly_total=total_monthly_amount*12;
        var yearly_total_actual=total_monthly_amount*.8*12;
        $("#yearly_total_gess").find("th:eq(1)").children().text(yearly_total);
        $("#yearly_total_gess").find("th:eq(2)").children().text('');
        $("#yearly_total_gess").find("th:eq(3)").children().text('');
        $("#yearly_total_gess").find("th:eq(4)").children().text('');

        $("#yearly_total").find("th:eq(0)").text(yearly_total_actual);
        $("#yearly_total").find("th:eq(2)").text('');
        $("#yearly_total").find("th:eq(3)").text('');
        $("#yearly_total").find("th:eq(1)").text('');
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
        var yearly_total=total_monthly_amount*12;
        var yearly_total_actual=total_monthly_amount*.8*12;

        $("#yearly_total_gess").find("th:eq(2)").children().text(yearly_total);
        $("#yearly_total_gess").find("th:eq(1)").children().text('');
        $("#yearly_total_gess").find("th:eq(3)").children().text('');
        $("#yearly_total_gess").find("th:eq(4)").children().text('');

        $("#yearly_total").find("th:eq(1)").text(yearly_total_actual);
        $("#yearly_total").find("th:eq(0)").text('');
        $("#yearly_total").find("th:eq(3)").text('');
        $("#yearly_total").find("th:eq(2)").text('');

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

        var yearly_total=total_monthly_amount*12;
        var yearly_total_actual=total_monthly_amount*.8*12;

        $("#yearly_total_gess").find("th:eq(3)").children().text(yearly_total);
        $("#yearly_total_gess").find("th:eq(1)").children().text('');
        $("#yearly_total_gess").find("th:eq(2)").children().text('');
        $("#yearly_total_gess").find("th:eq(4)").children().text('');

        $("#yearly_total").find("th:eq(2)").text(yearly_total_actual);
        $("#yearly_total").find("th:eq(0)").text('');
        $("#yearly_total").find("th:eq(1)").text('');
        $("#yearly_total").find("th:eq(3)").text('');

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
        var yearly_total=total_monthly_amount*12;
        var yearly_total_actual=total_monthly_amount*.8*12;

        $("#yearly_total_gess").find("th:eq(4)").children().text(yearly_total);
        $("#yearly_total_gess").find("th:eq(1)").children().text('');
        $("#yearly_total_gess").find("th:eq(3)").children().text('');
        $("#yearly_total_gess").find("th:eq(2)").children().text('');

        $("#yearly_total").find("th:eq(3)").text(yearly_total_actual);
        $("#yearly_total").find("th:eq(2)").text('');
        $("#yearly_total").find("th:eq(0)").text('');
        $("#yearly_total").find("th:eq(1)").text('');

    }
    else 
    {
        $("#monthly_total").find("th:eq(4)").text('');
        $("#monthly_total").find("th:eq(2)").text('');
        $("#monthly_total").find("th:eq(3)").text('');
        $("#monthly_total").find("th:eq(1)").text('');

        $("#yearly_total_gess").find("th:eq(4)").children().text('');
        $("#yearly_total_gess").find("th:eq(1)").children().text('');
        $("#yearly_total_gess").find("th:eq(3)").children().text('');
        $("#yearly_total_gess").find("th:eq(2)").children().text('');

        $("#yearly_total").find("th:eq(0)").text('');
        $("#yearly_total").find("th:eq(2)").text('');
        $("#yearly_total").find("th:eq(3)").text('');
        $("#yearly_total").find("th:eq(1)").text('');
    }
  }

  function check_lone_row(mid,lone_id,sl,total_row){

    if($("#plan_name_"+lone_id).prop("checked") == true)
    {
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
           return;
        }

        for(var i=1; i<=total_row; i++)
        {
          if(i!=sl){
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
           return;
        }
    }
    else
    {

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