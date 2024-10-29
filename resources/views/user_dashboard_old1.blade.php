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
                          <form class="contact-form">
                            
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
                                              <input v-model="form.legal_name" type="text" name="legal_name" required class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                              <has-error :form="form" field="legal_name"></has-error>
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
                                          class="btn btn-info fullpwidth" 
                                          @click.prevent="addCompanylogo()">Browse</button>
                                      </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="4">

                                    <fieldset >
                                      <legend style="width:100%;">Addresses and Contacts </legend>
                             
                                      <table width="100%" class=" " style="font-size:13px; line-height:12px;">
                                        <thead>

                                          <tr align="center">
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
                                                  <input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                                  <has-error :form="form" field="legal_name"></has-error>
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
                                                  <has-error :form="form" field="operational_name"></has-error>
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
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      State/ Province:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                                  <has-error :form="form" field="legal_name"></has-error>
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
                                                  <has-error :form="form" field="operational_name"></has-error>
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
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      City:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                                  <has-error :form="form" field="legal_name"></has-error>
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
                                                  <has-error :form="form" field="operational_name"></has-error>
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
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Street Number / Name:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                                  <has-error :form="form" field="legal_name"></has-error>
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
                                                  <has-error :form="form" field="operational_name"></has-error>
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
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Postal Code:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                                  <has-error :form="form" field="legal_name"></has-error>
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
                                                  <has-error :form="form" field="operational_name"></has-error>
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
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      P.O Box:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                                  <has-error :form="form" field="legal_name"></has-error>
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
                                                  <has-error :form="form" field="operational_name"></has-error>
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
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Business No.:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                                  <has-error :form="form" field="legal_name"></has-error>
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
                                                  <has-error :form="form" field="operational_name"></has-error>
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
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Ph. Office:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                                  <has-error :form="form" field="legal_name"></has-error>
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
                                                  <has-error :form="form" field="operational_name"></has-error>
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
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Ph. Mobile:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                                  <has-error :form="form" field="legal_name"></has-error>
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
                                                  <has-error :form="form" field="operational_name"></has-error>
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
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Fax:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                                  <has-error :form="form" field="legal_name"></has-error>
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
                                                  <has-error :form="form" field="operational_name"></has-error>
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
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Website:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                                  <has-error :form="form" field="legal_name"></has-error>
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
                                                  <has-error :form="form" field="operational_name"></has-error>
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
                                              <td>
                                                <div class="form-lebel" align="right">
                                                      Email address:
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.legal_name" type="text" name="legal_name" class="form-control" :class="{ 'is-invalid': form.errors.has('legal_name') }">
                                                  <has-error :form="form" field="legal_name"></has-error>
                                                </div>    
                                              </td>

                                              <td>
                                                <div class="form-group">
                                                  <input v-model="form.operational_name" type="text" name="operational_name" class="form-control" :class="{ 'is-invalid': form.errors.has('operational_name') }">
                                                  <has-error :form="form" field="operational_name"></has-error>
                                                </div>
                                              </td>
                                             
                                              <td>
                                                  <div class="form-group">
                                                    <input v-model="form.strata_name" type="text" name="strata_name" class="form-control" :class="{ 'is-invalid': form.errors.has('strata_name') }">
                                                    <has-error :form="form" field="strata_name"></has-error>
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
                              <button type="submit" class=" btn btn-success float-right">Submit</button>
                            </div>

                          </form>
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
                    
                     <fieldset style="width:850px; margin-left:250px;">
                      <table  class="table table-bordered" style="font-size:13px; line-height:20px;">
                        <thead style="line-height:30px;">

                          <tr align="center" >
                              <th > </th>
                             
                              <th colspan='2'>Single Property</th>
                              <th colspan='2'>Multiple Property </th>
                              
                          </tr>
                          <tr align="center" >
                              <th></th>
                              <th>Single Owner</th>
                              <th>Multiple Owners </th>
                              <th>Single Owner </th>
                              <th>Multiple Owners </th>
                             
                          </tr>
                          <tr align="center" >
                              <th></th>
                              <th>Plan A</th>
                              <th>Plan B</th>
                              <th>Plan C</th>
                              <th>Plan D</th>
                             
                          </tr>
                          
                          <tr align="center" >
                              <th></th>
                              <th>Amount</th>
                              <th>Amount </th>
                              <th>Amount </th>
                              <th>Amount </th>
                             
                          </tr>

                        </thead>
                        <tbody>
                          <?php print_r($master_plan_arr);  ?>
                            <tr align="center">
                              <td><strong> Select</strong></td>
                              <td>
                                      
                                  <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="plan_a" id="plan_a">
                                    <label for="plan_a"></label>
                                  </div>
                                
                              </td>
                              <td>
                                <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="plan_b" id="plan_b">
                                    <label for="plan_b"></label>
                                </div>    
                              </td>
                              <td>
                                      
                                <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="plan_c" id="plan_c">
                                    <label for="plan_c"></label>
                                </div>
                                
                              </td>
                              <td>
                                <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="plan_d" id="plan_d">
                                    <label for="plan_d"></label>
                                </div>    
                              </td>

                             
                            </tr>
                           
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>No. of Floors</strong>
                                
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Residential Class</strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Commercial Class</strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Number of Stores</strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Multiple Currency </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>No. of users</strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Rooms </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Mechanical Rooms </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Administrative Office </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Service Rooms</strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Storage Rooms</strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Amenity Rooms </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>

                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Workshop room </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 <strong>Mails & Parcells </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>




                            
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Inventory room</strong>
                                
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Shipping & Receiving </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Parking Management </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Virtual Meeting</strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Accounting </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>No. of users</strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Rooms </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Mechanical Rooms </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Administrative Office </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Service Rooms</strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Storage Rooms</strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Amenity Rooms </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>

                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Workshop room </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr align="center" >
                              <td align="left">
                                <i  class=" right fas fa-angle-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 <strong>Mails & Parcells </strong></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
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
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./index.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Graph & Chart v1</p>
                      </a>
                    </li>
                    
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


</script>

