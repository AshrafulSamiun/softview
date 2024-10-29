<html>
<head>
  <title>Multi form</title>

  <link href="{!! asset('assets/vendor/bootstrap/css/bootstrap.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('css/style.css') !!}" media="all" rel="stylesheet" type="text/css" />



<script type="text/javascript" src="{{ asset('plugins/jquery/jquery.slim.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js') }}"></script>

<!-- 
    <script src="plugins/jquery/jquery.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="assets/vendor/jquery/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 -->


  <style>

    section{
      padding-top:100px;
    }

    .form-section{
      padding-left: 15px;
      display: none;
    }

    .form-section.current{
      display: inherit;

    }

    .btn-info, .btn-success{
      margin-top:10px;
    }

    .parsley-errors-list{
      margin:2px 0 3px;
      padding:0;
      list-style-type: none;
      color:red;
    }

  </style>
</head>
<body style="background:#e5e3e3">
  <section align="center"  >
    <div class="container" >
      <div class="row" >
        <div class="col-md-8 col-md-offset-2" >

          <div class="card" style="border: 2px solid #000">
            <div class="card-heading"></div>
            <div class="card-body">
              <form class="contact-form">
                
                <div class="form-section">
                  <h2>Company Profile</h2>

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
                              <table width="100%" class="table table-borderless ">
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
                                      
                            
                    
                                </tbody>
                               </table>
                            </fieldset>

                          </td>
                       </tr> 
              
      
                  </tbody>
                 </table>
                  <lavel for="first-name"> Legal Name</lavel>
                  <input class="form-control" name="first_name" type="text" required></input>
                
                  <lavel for="last-name">Last Name</lavel>
                  <input class="form-control" name="last_name" type="text" required></input>
                </div>
                 <div class="form-section">
                  <lavel for="email">Email</lavel>
                  <input class="form-control" name="email" type="email" required></input>
                
                  <lavel class="phone">phone</lavel>
                  <input class="form-control" name="phone" type="phone" required></input>
                </div>

                <div class="form-section">
                  <lavel for="first-name">Seceond</lavel>
                  <input class="form-control" name="first_name" type="text" required></input>
                
                  <lavel for="last-name">sdsadasd</lavel>
                  <input class="form-control" name="last_name" type="text" required></input>
                </div>
                 <div class="form-section">
                  <lavel for="email">jjjjjjjjjjj</lavel>
                  <input class="form-control" name="email" type="email" required></input>
                
                  <lavel class="phone">eeeeee</lavel>
                  <input class="form-control" name="phone" type="phone" required></input>
                </div>
                <div class="form-navigation">
                  <button type="button" class="previous btn btn-info float-left">Previous</button>
                  <button type="button" class="next btn btn-info float-right">Next</button>
                  <button type="submit" class=" btn btn-success float-right">Submit</button>
                </div>

              </form>
            </div>
          </div>
        </div>  
      </div>
    </div>
  </section>

  <script>
    $( document ).ready(function() {
        //alert();
    });


    $(function(){

      var $sections=$(".form-section");

      function navigateTo(index)
      {
        $sections.removeClass('current').eq(index).addClass('current');
        $('.form-navigation .previous').toggle(index>0);
        var atTheEnd=index>=$sections.length-1;
        $('.form-navigation .next').toggle(!atTheEnd);
        $('.form-navigation [type=submit]').toggle(atTheEnd);
      }

      function curIndex()
      {
        return $sections.index($sections.filter('.current'));
      }


      $('.form-navigation .previous').click(function(){
        navigateTo(curIndex()-1);
      });


      $('.form-navigation .next').click(function(){
        $('.contact-form').parsley().whenValidate({
          group:'block-'+curIndex()
        }).done(function(){
          navigateTo(curIndex()+1);
        });
      });



      $sections.each(function(index,section){

        $(section).find(':input').attr('data-parsley-group','block-'+index)
      })

      navigateTo(0);
    });
  </script
</body>
</html>