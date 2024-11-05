<?php

namespace App\Http\Controllers;
use App\Models\AccountCompany as AccountCompany;
use App\Models\Project as Project;
use App\Models\ServicePlan as servicePlan;
use App\Models\UserServicePlan as UserServicePlan;
use App\Models\UserServicePlanDetails as UserServicePlanDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserServicePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $master_service_plan=UserServicePlan::where('status_active', '=', 1)
                                            ->where('project_id', '=', $project_id)
                                            ->get();
        $managemnet_type_sql=AccountCompany::where('status_active', '=', 1)
                                            ->where('project_id', '=', $project_id)
                                            ->get(['management_type']);
        $managemnet_type= $managemnet_type_sql[0]->management_type; 

        if(empty($master_service_plan[0]))
        {
            $data['master_plan_arr']        =array();
            $master_id="";  


            $service_plan = ServicePlan::where('status', '=', 1)
                               // ->where('management_type',$managemnet_type)
                               // ->toSql();
                                ->get();

            $service_plan_arr=array();
          
            foreach($service_plan as $m=>$mvalue)
            {
               
                $service_plan_arr[$mvalue->type_of_service][$mvalue->id]['rate_applicable']=$mvalue->rate_applicable;
                $service_plan_arr[$mvalue->type_of_service][$mvalue->id]['plan_name']=$mvalue->plan_name;
                $service_plan_arr[$mvalue->type_of_service][$mvalue->id]['management_type']=$mvalue->management_type;
                $service_plan_arr[$mvalue->type_of_service][$mvalue->id]['type_of_service']=$mvalue->type_of_service;
                $service_plan_arr[$mvalue->type_of_service][$mvalue->id]['rate']=$mvalue->rate;
                $service_plan_arr[$mvalue->type_of_service][$mvalue->id]['amount']=$mvalue->amount;
                $service_plan_arr[$mvalue->type_of_service][$mvalue->id]['plan_id']=$mvalue->id; 
                $service_plan_arr[$mvalue->type_of_service][$mvalue->id]['quantity']='';
                $service_plan_arr[$mvalue->type_of_service][$mvalue->id]['id']='';
                $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['service_enable']=0;
                 
               
            }
        }
        else
        {

            
           
           /* $service_plan_data=DB::raw('select 
                                            `service_plans`.`id` as `plan_id`,
                                             `service_plans`.`plan_name`,
                                             `service_plans`.`management_type`,
                                             `service_plans`.`type_of_service`,
                                             `service_plans`.`rate_applicable`,
                                             `service_plans`.`rate`, 
                                             `service_plans`.`amount`, 
                                             `user_service_plan_details`.`quantity`, 
                                             `user_service_plan_details`.`amount` as `total_amount`, 
                                             `user_service_plan_details`.`id`                                                                                                                                            
                                         from `service_plans` 
                                         left join (select * from `user_service_plan_details` where `project_id` =33) user_service_plan_details 
                                                    on `service_plans`.`id` = `user_service_plan_details`.`plan_id` 
                                                    where `service_plans`.`status` = 1');*/
            //dd($service_plan_data);die;


           /* $service_plan_data = DB::table('service_plans')
                ->leftJoin(DB::raw('select * from user_service_plan_details where project_id =33 user_service_plan_details 
                                                    on service_plans.id = user_service_plan_details.plan_id'))
                ->where('service_plans.status', '=', 1)
                ->get([
                        'service_plans.id as plan_id',
                        'service_plans.plan_name',
                        'service_plans.management_type',
                        'service_plans.type_of_service',
                        'service_plans.rate_applicable',
                        'service_plans.rate',
                        'service_plans.amount',
                        'user_service_plan_details.quantity',
                        'user_service_plan_details.amount as total_amount',
                        'user_service_plan_details.id',
                    ]);
             dd($service_plan_data);die;*/
            $data['master_plan_arr']        =$master_service_plan;
            $master_id=$master_service_plan[0]->id;
            $service_plan_data = DB::table('service_plans')
                ->leftJoin('user_service_plan_details', function($join) use ($master_id, $project_id){
                    $join->on('service_plans.id', '=', 'user_service_plan_details.plan_id')
                    ->where('user_service_plan_details.master_id', '=', $master_id)
                    ->where('user_service_plan_details.project_id', '=', $project_id);
                })
                ->where('service_plans.status', '=', 1)
                ->where('service_plans.management_type',$managemnet_type)
                ->orderBy('slno')
                ->get([
                        'service_plans.id as plan_id',
                        'service_plans.plan_name',
                        'service_plans.management_type',
                        'service_plans.type_of_service',
                        'service_plans.rate_applicable',
                        'service_plans.rate',
                        'service_plans.amount',
                        'user_service_plan_details.quantity',
                        'user_service_plan_details.service_enable',
                        'user_service_plan_details.amount as total_amount',
                        'user_service_plan_details.id',
                    ]);
          
            $service_plan_arr=array();
          
            foreach($service_plan_data as $m=>$mvalue)
            {
               
                $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['rate_applicable']=$mvalue->rate_applicable;
                $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['plan_name']=$mvalue->plan_name;
                $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['management_type']=$mvalue->management_type;
                $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['type_of_service']=$mvalue->type_of_service;
                $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['rate']=$mvalue->rate;

                if($mvalue->total_amount>0)
                {
                    $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['amount']=$mvalue->total_amount;
                    $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['quantity']=$mvalue->quantity;
                    $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['id']=$mvalue->id;
                    $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['service_enable']=$mvalue->service_enable;
                }
                else
                {
                    $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['amount']=$mvalue->amount;
                    $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['quantity']='';
                    $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['id']='';
                    $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['service_enable']=0;
                }
                    

                $service_plan_arr[$mvalue->type_of_service][$mvalue->plan_id]['plan_id']=$mvalue->plan_id; 
                 
               
            }
           // dd($service_plan_arr); die; 
        }
        
//dd($service_plan_arr);die;
            $data['service_plan_arr']        =$service_plan_arr;
           // $data['lavel_one_plan_arr']     =$lavel_one_plan_arr;
            //$data['lavel_two_plan_arr']     =$lavel_two_plan_arr;
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

        foreach($request->plan_id as $key=>$details)
        {
            if($details){
                
               if($amounts[$key]>0)
               {

                    $rate_applicable    =$rate_applicables[$key];
                    if($rate_applicable==1)
                        $quantity           =$quantitys[$key];
                    else
                        $quantity           =1;
                    $rate               =$rates[$key];
                    $amount             =$amounts[$key];
                    $service_enable     =$service_enables[$key];

                    
                  
                    $data[]= array(
                        'master_id'         =>$UserServicePlan->id,
                        'project_id'        =>$project_id,
                        'plan_id'           =>$details,
                        'rate_applicable'   =>$rate_applicable,
                        'quantity'          =>$quantity,
                        'rate'              =>$rate,
                        'amount'            =>$amount,
                        'service_enable'    =>$service_enable,
                        'inserted_by'       =>$user_id,
                    );
               }
                 
            }         
             
        }
 
       // dd($data);die;
        $UserServicePlanDetails=UserServicePlanDetails::insert($data);
        $user_project=Project::find($project_id)->update(array('project_status' => '97'));



        // $user_project=Project::find($project_id)->update(array('project_name' => $legal_name,'project_status' => '99'));

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
        $quantitys=$request->quantity;
        $rates=$request->rate;
        $amounts=$request->amount;
        $rate_applicables=$request->rate_applicable;
        $service_enables=$request->service_enable;


        //dd($service_enables);die;
        $details_ids=$request->id;
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
        foreach($request->plan_id as $key=>$details)
        {
            
            if($details){
                $plan_details_id=$details_ids[$key];
                if($plan_details_id>0)
                {
                    if($amounts[$key]>0)
                    {
                        $rate_applicable    =$rate_applicables[$key];
                        if($rate_applicable==1)
                            $quantity           =$quantitys[$key];
                        else
                            $quantity           =1;
                        $rate               =$rates[$key];
                        $amount             =$amounts[$key];
                        $service_enable     =$service_enables[$key];


                        $data= array(
                            'master_id'         =>$id,
                            'project_id'        =>$project_id,
                            'plan_id'           =>$details,
                            'rate_applicable'   =>$rate_applicable,
                            'quantity'          =>$quantity,
                            'rate'              =>$rate,
                            'amount'            =>$amount,
                            'service_enable'    =>$service_enable,
                            'updated_by'       =>$user_id,
                        );


                        $UserServicePlanDetails=UserServicePlanDetails::where('id',"=",$plan_details_id)->update($data);

                    }
                    else{

                        $DeleteUserServicePlanDetails=UserServicePlanDetails::where('id',"=",$plan_details_id)->update(['status_active'=>2]);
                   } 
                }
                else
                {

                    if($amounts[$key]>0)
                    {

                        $rate_applicable    =$rate_applicables[$key];
                        if($rate_applicable==1)
                            $quantity           =$quantitys[$key];
                        else
                            $quantity           =1;
                        $rate               =$rates[$key];
                        $amount             =$amounts[$key];
                        $service_enable     =$service_enables[$key];

                        
                      
                        $inserted_data[]= array(
                            'master_id'         =>$id,
                            'project_id'        =>$project_id,
                            'plan_id'           =>$details,
                            'rate_applicable'   =>$rate_applicable,
                            'quantity'          =>$quantity,
                            'rate'              =>$rate,
                            'amount'            =>$amount,
                            'service_enable'    =>$service_enable,
                            'inserted_by'       =>$user_id,
                        );
                    }
                }
                
           }
                        
        }

        if(!empty($inserted_data))
        {
            $InsertedPlanDetails=UserServicePlanDetails::insert($inserted_data);
        }



        // $user_project=Project::find($project_id)->update(array('project_name' => $legal_name,'project_status' => '99'));

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
