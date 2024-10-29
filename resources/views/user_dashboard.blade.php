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
                  <a href="#" class="nav-link active" style="width:250px; background-color:#0070C0">
                    
                    <i class="fas fa-building"></i>
                    <p>
                      Company Profile &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" >
                      
                       <fieldset style="width:750px; margin-left:250px;">
                        {!! Form::open(array('enctype'=>'multipart/form-data','class' => 'contact-form','route' => 'UserCompanies.store','method'=>'POST')) !!}
                            

                          <table width="100%" style="font-size:13px; line-height:12px;"> 
                          
                            <tbody>
                              
                              <tr>
                                <td>
                                  <div class="form-lebel" align="right">
                                      Management Type:
                                  </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input  type="text" name="account_no"  class="form-control" required>
                                        @if ($errors->has('account_no'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('account_no') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="form-lebel" align="right">
                                      Account No:
                                  </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input  type="text" name="account_no"  class="form-control" required>
                                        @if ($errors->has('account_no'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('account_no') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="form-lebel" align="right">
                                        Legal Name:
                                  </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input  type="text" name="legal_name"  class="form-control" required>
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
                                        <input  type="text" name="operational_name"  class="form-control" required>
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
                                        <input  type="text" name="jurisdiction_of_incorporation"  class="form-control" required>
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
                                        <input  type="text" name="incorporation_number"  class="form-control" required>
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
                                        <input type="hidden" id="company_logo" name="company_logo" > 
                                        <input type="file" class="custom-file-input"  name="company_logo_url" id="company_logo_url">
                                        <label class="custom-file-label" for="company_logo_url">Choose file</label>
                                      </div>
                                    </div>
                                </td>
                                <td width="150">
                                      
                                    <div class="form-group">
                                    
                                       <img src="" class="img-responsive" height="80" width="100"  > 
                                      
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
                                        <input  type="text" name="website"  class="form-control" required>
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
                                        <button type="submit" class=" btn btn-success" >Save</button>
                                        <button type="submit" class=" btn btn-secondary " disabled>Update</button>
                                    </div>
                                </td>
                                 
                              </tr>

                            </tbody>

                          </table>

                        {!! Form::close() !!}
                    </fieldset>  
                     
                   
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
                  
                </li>
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link disable" style="width:250px;">
                    
                    <i class="fab fa-think-peaks"></i>
                    <p>
                      Service Plans  &nbsp; &nbsp;&nbsp;

                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                 
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
                      Account Activation Status  &nbsp; &nbsp;&nbsp;

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




  }



  function change_country_dropdown(id,provience_id)
  {
    	var country=$("#"+id).val();

   


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