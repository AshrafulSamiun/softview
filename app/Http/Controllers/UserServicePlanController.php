<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\UserServicePlanDetails as UserServicePlanDetails;
use App\Models\UserServicePlan as UserServicePlan;
use App\Models\servicePlan as servicePlan;
use App\Models\ServicePlanGroup as ServicePlanGroup;
use App\Models\ServicePlanSubgroup as ServicePlanSubgroup;
use App\Models\Project as Project;
use App\Models\PropertyManagementType as PropertyManagementType;
use App\Classes\ArrayFunction as ArrayFunction;

class UserServicePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_info                      = \Auth::user();
        $project_id                     = $user_info->project_id;
        $user_id                        = $user_info->id;
        $ArrayFunction                  =new ArrayFunction();
        $currency                       =$ArrayFunction->currency;
        $data['currency_arr']           =$currency;
        $data['sales_tax_rate']         =9/100;
        $data['conversion_rate_arr']   =array(
                                            1=>"1",
                                            2=>".7",
                                            3=>".67"
                                        );


        $service_group_sql=ServicePlanGroup::where('status_active', '=', 1)           
                                            ->get();

        $service_group_arr=array();
        foreach($service_group_sql as $key=>$value)
        {
            $service_group_arr[$value->id]['name']              =$value->name;
            $service_group_arr[$value->id]['subgroup_available']=$value->subgroup_available;
        }


        $service_subgroup_sql=ServicePlanSubgroup::where('status_active', '=', 1)           
                                            ->get();

        $service_subgroup_arr=array();
        $subgroup_group=array();
        foreach($service_subgroup_sql as $key=>$value)
        {
            $service_subgroup_arr[$value->service_group_id][$value->id]['name']=$value->name;
            $service_subgroup_arr[$value->service_group_id][$value->id]['quantity_applicable']  =$value->quantity_applicable;
            $service_subgroup_arr[$value->service_group_id][$value->id]['default_quantity']     =$value->default_quantity;
            if($value->default_quantity>0)
                $service_subgroup_arr[$value->service_group_id][$value->id]['checked']          =true;
            else 
                $service_subgroup_arr[$value->service_group_id][$value->id]['checked']          =false;

            $subgroup_group[$value->id]=$value->service_group_id;

        }


        $master_service_plan    =UserServicePlan::where('status_active', '=', 1)
                                            ->where('project_id', '=', $project_id)
                                            ->first();
       


        $service_plan_details_arr=array();
        


        $servicePlan_arr=array();
        if(!empty($master_service_plan))
        {
            $data['update_master_data_arr'] =$master_service_plan;
            $data['master_plan_arr']        =array();
            $master_id="";  

            $service_plan_details = UserServicePlanDetails::where('status_active', '=', 1)
                                    ->where('project_id', '=', $project_id)
                                    ->where('master_id', '=', $master_service_plan->id)
                                    ->get();

            $check_plan_update=array();
            $check_subgroup_update=array();
            foreach($service_plan_details as $m=>$mvalue)
            {

                $master_plan_arr[$mvalue->subgroup_id][$master_service_plan->service_type]['plan_id']       =$mvalue->plan_id;
                $master_plan_arr[$mvalue->subgroup_id][$master_service_plan->service_type]['id']            =$mvalue->id;
                $master_plan_arr[$mvalue->subgroup_id][$master_service_plan->service_type]['amount']        =$mvalue->amount;
                $master_plan_arr[$mvalue->subgroup_id][$master_service_plan->service_type]['rate']          =$mvalue->rate;
                $master_plan_arr[$mvalue->subgroup_id][$master_service_plan->service_type]['rate_applicable']=$mvalue->rate_applicable;
                $master_plan_arr[$mvalue->subgroup_id][$master_service_plan->service_type]['quantity']      =$mvalue->quantity;


                $service_subgroup_arr[$subgroup_group[$mvalue->subgroup_id]][$mvalue->subgroup_id]['default_quantity']     =$mvalue->quantity;

                $check_plan_update[$mvalue->plan_id]=$mvalue->plan_id;
                $check_subgroup_update[$mvalue->subgroup_id]=$mvalue->subgroup_id;
                 
            }

        }
        else
        { 
            $data['update_master_data_arr'] =array();
        }



        $service_plan = servicePlan::where('status_active', '=', 1)//->where('subgroup_id', '=', 9)
                                ->get();
        foreach ($service_plan as $key => $value) {

            if(!in_array($value->id,$check_plan_update))
            {

                if(in_array($value->subgroup_id,$check_subgroup_update))
                {

                    $quantity=$service_subgroup_arr[$subgroup_group[$value->subgroup_id]][$value->subgroup_id]['default_quantity'];
                    $master_plan_arr[$value->subgroup_id][$value->plan_type]['plan_id']         =$value->id;
                    $master_plan_arr[$value->subgroup_id][$value->plan_type]['id']              ="";
                    $master_plan_arr[$value->subgroup_id][$value->plan_type]['amount']          =$value->amount*$quantity;
                    $master_plan_arr[$value->subgroup_id][$value->plan_type]['rate']            =$value->amount;
                    $master_plan_arr[$value->subgroup_id][$value->plan_type]['rate_applicable'] =$value->rate_applicable;
                    $master_plan_arr[$value->subgroup_id][$value->plan_type]['quantity']        =$quantity;
                }
                else
                {
                    $master_plan_arr[$value->subgroup_id][$value->plan_type]['plan_id']         =$value->id;
                    $master_plan_arr[$value->subgroup_id][$value->plan_type]['id']              ="";
                    $master_plan_arr[$value->subgroup_id][$value->plan_type]['amount']          =$value->amount;
                    $master_plan_arr[$value->subgroup_id][$value->plan_type]['rate']            =$value->amount;
                    $master_plan_arr[$value->subgroup_id][$value->plan_type]['rate_applicable'] =$value->rate_applicable;
                    $master_plan_arr[$value->subgroup_id][$value->plan_type]['quantity']        =1;
                }

            }
            
        }
        
        $data['service_plan_arr']       =$servicePlan_arr;
        $data['master_plan_arr']        =$master_plan_arr;
        $data['service_subgroup_arr']   =$service_subgroup_arr;
        $data['service_group_arr']      =$service_group_arr;
           
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $quantitys=$request->quantity;
        $rates=$request->rate;
        $amounts=$request->amount;
       


        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['user_id'          =>$user_id]);

        DB::beginTransaction();

        $UserServicePlan= UserServicePlan::create($request->all());

        foreach($request->service_subgroup_arr as $key=>$service_group)
        {
            foreach($service_group as $subgroup_id=>$service_subgroup_details)
            {
                if($key>0 && $service_subgroup_details['checked'])
                {
                   
                    if(!empty($request->master_plan_arr[$subgroup_id]))
                    {
                        foreach($request->master_plan_arr[$subgroup_id] as $service_plan=>$plan_details)
                        {
                            if($request->service_type==$service_plan && $plan_details['rate_applicable']==1)
                            {
                                //dd($plan_details);
                            
                                $data[]= array(
                                    'master_id'         =>$UserServicePlan->id,
                                    'project_id'        =>$project_id,
                                    'subgroup_id'       =>$subgroup_id,
                                    'plan_id'           =>$plan_details['plan_id'],
                                    'rate_applicable'   =>$plan_details['rate_applicable'],
                                    'rate'              =>$plan_details['rate'],
                                    'quantity'          =>$service_subgroup_details['default_quantity'],
                                    'amount'            =>$plan_details['amount'],
                                    'inserted_by'       =>$user_id,
                                );
                            }                        
                        } 
                    }
                }
            }
        }
 
       
        $UserServicePlanDetails=UserServicePlanDetails::insert($data);
        $user_project=Project::find($project_id)->update(array('project_status' => '101'));


        if($UserServicePlan  && $UserServicePlanDetails && $user_project)
        {
           DB::commit();
           return redirect()->route('dashboard');
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['user_id'          =>$user_id]);

        DB::beginTransaction();

        $UserServicePlan=UserServicePlan::find($id)->update($request->all());
        $InsertedPlanDetails=true;
        $UserServicePlanDetails=true;
        $DeleteUserServicePlanDetails=true;

        $inserted_data=array();
        $UserServicePlanDetailsUpdate=true;
        foreach($request->service_subgroup_arr as $key=>$service_group)
        {
            foreach($service_group as $subgroup_id=>$service_subgroup_details)
            {
                if($key>0 && $service_subgroup_details['checked'])
                {
                   
                    if(!empty($request->master_plan_arr[$subgroup_id]))
                    {
                        foreach($request->master_plan_arr[$subgroup_id] as $service_plan=>$plan_details)
                        {
                            if($plan_details['id'])
                            {
                                if($request->service_type==$service_plan && $plan_details['rate_applicable']==1)
                                {
                                
                                    $data_update= array(
                                        'master_id'         =>$id,
                                        'project_id'        =>$project_id,
                                        'subgroup_id'       =>$subgroup_id,
                                        'plan_id'           =>$plan_details['plan_id'],
                                        'rate_applicable'   =>$plan_details['rate_applicable'],
                                        'rate'              =>$plan_details['rate'],
                                        'quantity'          =>$service_subgroup_details['default_quantity'],
                                        'amount'            =>$plan_details['amount'],
                                        'updated_by'        =>$user_id,
                                    );
                                    $UserServicePlanDetailsUpdate=UserServicePlanDetails::where('id',"=",$plan_details['id'])->update($data_update);


                                } 
                                else{

                                    $DeleteUserServicePlanDetails=UserServicePlanDetails::where('id',"=",$plan_details['id'])->update(['status_active'=>0,'is_deleted'=>1]);
                                    if( !$DeleteUserServicePlanDetails)
                                    {
                                        DB::rollBack();
                                        return 10;
                                        die;
                                    }
                                }
                            }
                            else
                            {
                                if($request->service_type==$service_plan && $plan_details['rate_applicable']==1)
                                {
                                    //dd($plan_details);
                                
                                    $inserted_data[]= array(
                                        'master_id'         =>$id,
                                        'project_id'        =>$project_id,
                                        'subgroup_id'       =>$subgroup_id,
                                        'plan_id'           =>$plan_details['plan_id'],
                                        'rate_applicable'   =>$plan_details['rate_applicable'],
                                        'rate'              =>$plan_details['rate'],
                                        'quantity'          =>$service_subgroup_details['default_quantity'],
                                        'amount'            =>$plan_details['amount'],
                                        'inserted_by'       =>$user_id,
                                    );
                                }
                            }
                                                    
                        } 
                    }
                }
            }
        }

        $InsertedPlanDetails=true;
        
        if(!empty($inserted_data))
        {
            $InsertedPlanDetails=UserServicePlanDetails::insert($inserted_data);
        }


        if($UserServicePlan  && $UserServicePlanDetailsUpdate && $InsertedPlanDetails && $DeleteUserServicePlanDetails)
        {
           DB::commit();
           //return redirect()->route('dashboard');
           return 1;
        }
        else
        {
            DB::rollBack();
            //return back()->withInput();
            return 10;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
