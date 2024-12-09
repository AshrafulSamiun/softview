<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\UserServicePlanDetails as UserServicePlanDetails;
use App\UserServicePlan as UserServicePlan;
use App\servicePlan as servicePlan;
use App\Project as Project;
use App\AccountCompany as AccountCompany;
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
        $user_info              = \Auth::user();
        $project_id             = $user_info->project_id;
        $user_id                = $user_info->id;
        $ArrayFunction          =new ArrayFunction();
        $currency               =$ArrayFunction->currency;
        $data['currency_arr']   =$currency;
        $master_service_plan    =UserServicePlan::where('status_active', '=', 1)
                                            ->where('project_id', '=', $project_id)
                                            ->first();
        $management_type_sql    =AccountCompany::where('status_active', '=', 1)
                                            ->where('project_id', '=', $project_id)
                                            ->first(['management_type']);

        $management_type        = $management_type_sql->management_type; 
        $data['management_type']=$management_type;


        $service_plan = servicePlan::where('status', '=', 1)
                                ->get();
        foreach ($service_plan as $key => $value) {
            if($value->rate_applicable==0)
            {
                $master_plan_arr[$value->type_of_service]=$value->plan_name;
            }
        }

        $service_plan_details_arr=array();
        foreach ($service_plan as $key => $value) {
            if($value->rate_applicable==1)
            {
                $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['plan_id']                =$value->id;
                $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['id']                     ="";
                $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['plan_name']              =$value->plan_name;
                $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['rate_applicable']        =$value->rate_applicable;
                $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['rate']                   =$value->rate;
                $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['amount']                 =$value->rate;
                $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['slno']                   =$value->slno;
                $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['checked']                =false;
                $service_plan_details_arr[$value->id]['type_of_service']=$value->type_of_service;
                $service_plan_details_arr[$value->id]['plan_name']=$value->plan_name;
                $service_plan_details_arr[$value->id]['management_type']=$value->management_type;
            }               
        }

        if(!empty($master_service_plan))
        {
            $data['update_master_data_arr'] =$master_service_plan;
            $data['master_plan_arr']        =array();
            $master_id="";  

            $service_plan_details = UserServicePlanDetails::where('status_active', '=', 1)
                                    ->where('project_id', '=', $project_id)
                                    ->where('master_id', '=', $master_service_plan->id)
                                    ->get();

          
            foreach($service_plan_details as $m=>$mvalue)
            {

                $servicePlan_arr[$service_plan_details_arr[$mvalue->plan_id]['type_of_service']][$service_plan_details_arr[$mvalue->plan_id]['plan_name']][$service_plan_details_arr[$mvalue->plan_id]['management_type']]['id']=$mvalue->id;

                 $servicePlan_arr[$service_plan_details_arr[$mvalue->plan_id]['type_of_service']][$service_plan_details_arr[$mvalue->plan_id]['plan_name']][$service_plan_details_arr[$mvalue->plan_id]['management_type']]['amount']=$mvalue->amount;
                 $servicePlan_arr[$service_plan_details_arr[$mvalue->plan_id]['type_of_service']][$service_plan_details_arr[$mvalue->plan_id]['plan_name']][$service_plan_details_arr[$mvalue->plan_id]['management_type']]['checked']=true;
                 
            }

        }
        else
        { 
            $data['update_master_data_arr'] =array();
        }
        
        $data['service_plan_arr']   =$servicePlan_arr;
        $data['master_plan_arr']    =$master_plan_arr;
           
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
        $rate_applicables=$request->rate_applicable;
        $service_enables=$request->service_enable;


        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['user_id'          =>$user_id]);

        DB::beginTransaction();

        $UserServicePlan= UserServicePlan::create($request->all());

        foreach($request->service_plan_arr as $key=>$service_details)
        {
            if($key>0)
            {
                foreach($service_details as $key1=>$plan_details)
                {
                    foreach($plan_details as $key2=>$details)
                    {
                        if($details['checked']){
                            $data[]= array(
                                'master_id'         =>$UserServicePlan->id,
                                'project_id'        =>$project_id,
                                'plan_id'           =>$details['plan_id'],
                                'rate_applicable'   =>$details['rate_applicable'],
                                'rate'              =>$details['rate'],
                                'amount'            =>$details['rate'],
                                'inserted_by'       =>$user_id,
                            );
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
        foreach($request->service_plan_arr as $key=>$service_details)
        {
            if($key>0)
            {
                foreach($service_details as $key1=>$plan_details)
                {
                    foreach($plan_details as $key2=>$details)
                    {
                        if($details['id'])
                        {
                            if($details['checked']){

                                $data_update= array(
                                    'master_id'         =>$id,
                                    'project_id'        =>$project_id,
                                    'plan_id'           =>$details['plan_id'],
                                    'rate_applicable'   =>$details['rate_applicable'],
                                    'rate'              =>$details['rate'],
                                    'amount'            =>$details['amount'],
                                    'inserted_by'       =>$user_id,
                                );

                                $UserServicePlanDetails=UserServicePlanDetails::where('id',"=",$details['id'])->update($data_update);
                            }
                            else
                            {
                                $DeleteUserServicePlanDetails=UserServicePlanDetails::where('id',"=",$details['id'])->update(['status_active'=>2]);
                            }

                        }
                        else {

                            if($details['checked']){

                                $inserted_data[]= array(
                                    'master_id'         =>$id,
                                    'project_id'        =>$project_id,
                                    'plan_id'           =>$details['plan_id'],
                                    'rate_applicable'   =>$details['rate_applicable'],
                                    'rate'              =>$details['rate'],
                                    'amount'            =>$details['rate'],
                                    'inserted_by'       =>$user_id,
                                );
                            }
                        }    
                     }
                } 
            }
        }

        if(!empty($inserted_data))
        {
            $InsertedPlanDetails=UserServicePlanDetails::insert($inserted_data);
        }


        if($UserServicePlan  && $UserServicePlanDetails && $InsertedPlanDetails && $DeleteUserServicePlanDetails)
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
