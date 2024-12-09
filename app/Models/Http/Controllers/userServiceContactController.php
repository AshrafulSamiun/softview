<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Classes\ArrayFunction as ArrayFunction;
use App\service_contact as ServiceContact;
use App\Project as Project;
use App\UserServicePlan;

class userServiceContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ArrayFunction                      =new ArrayFunction();
        $currency                           =$ArrayFunction->currency;
        $data['currency']                   =$currency;
        $project_id                         = \Auth::user()->project_id;
        $project_info                       = Project::find($project_id);
        $project_type                       = $project_info->project_status;
        $data['project_status']             =$project_type;

        $master_service_plan                =UserServicePlan::where('status_active', '=', 1)
                                                ->where('project_id', '=', $project_id)
                                                ->first();
        $data['service_contact_data']       =array();

       //dd($master_service_plan);

        if($master_service_plan->is_monthly==1) $amount_before_tax=$master_service_plan->total_monthly_amount;
        else                                    $amount_before_tax=$master_service_plan->total_yearly_amount;

        $data['currency_id']                =$master_service_plan->currency_id;
        $data['charging_peroid']            =$master_service_plan->is_monthly;
        $data['amount_before_tax']          =$amount_before_tax;
        $service_contact_data               =ServiceContact::where('project_id',$project_id)->where('status_active',1)->get();


        foreach($service_contact_data as $key=>$val)
        {
            $data['service_contact_data']['id']                             =$val->id;
            $data['service_contact_data']['contact_phone']                  =$val->contact_phone;
            $data['service_contact_data']['service_contact_date']           =$val->service_contact_date;
            $data['service_contact_data']['service_start_date']             =$val->service_start_date;
            $data['service_contact_data']['service_end_date']               =$val->service_end_date;
            $data['service_contact_data']['reconnection_period']            =$val->reconnection_period;
            $data['service_contact_data']['duration']                       =$val->duration;
            $data['service_contact_data']['charging_peroid']                =$val->charging_peroid;
            $data['service_contact_data']['amount_before_tax']              =$val->amount_before_tax;
            $data['service_contact_data']['currency']                       =$val->currency;
            $data['service_contact_data']['business_term']                  =$val->business_term;
            $data['service_contact_data']['charging_date']                  =$val->charging_date;
            $data['service_contact_data']['late_payment']                   =$val->late_payment;
            $data['service_contact_data']['reconnection_service_fee']       =$val->reconnection_service_fee;
            $data['service_contact_data']['reconnection_date']              =$val->reconnection_date;
            $data['service_contact_data']['nsf_fee']                        =$val->nsf_fee;
            $data['service_contact_data']['payment_method']                 =$val->payment_method;
           
        }

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
        request()->validate([
            'contact_phone'                         => 'required',
            'service_contact_date'                  => 'required',
            'service_start_date'                    => 'required',
            'duration'                              => 'required',
            'charging_peroid'                       => 'required',
            'amount_before_tax'                     => 'required',
            'currency'                              => 'required',
            'charging_date'                         => 'required',
            'late_payment'                          => 'required',
            'service_end_date'                      => 'required',
            'reconnection_period'                   => 'required',
            'payment_method'                        => 'required',
             
        ]);



        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);
        $service_contact_date                   =date("Y-m-d",strtotime($request->input('service_contact_date')));
        $service_start_date                     =date("Y-m-d",strtotime($request->input('service_start_date')));
        $service_end_date                       =date("Y-m-d",strtotime($request->input('service_end_date')));
        $duration                               =date("Y-m-d",strtotime($request->input('duration')));
        $charging_date                          =date("Y-m-d",strtotime($request->input('charging_date')));
        $reconnection_date                      =date("Y-m-d",strtotime($request->input('reconnection_date')));

        $request->merge(['service_contact_date' =>$service_contact_date]);
        $request->merge(['service_start_date'   =>$service_start_date]);
        $request->merge(['service_end_date'     =>$service_end_date]);
        $request->merge(['duration'             =>$duration]);
        $request->merge(['charging_date'        =>$charging_date]);
        $request->merge(['reconnection_date'    =>$reconnection_date]);

        DB::beginTransaction();

        $service_contact_insert=ServiceContact::create($request->all());

        $user_project=Project::find($project_id)->update(array('project_status' => '100'));



        if( $service_contact_insert && $user_project)
        {
           DB::commit();
           return 1;
        }
        else
        {
            DB::rollBack();
           return 10;
        }
        die;
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
        request()->validate([
            'contact_phone'                         => 'required',
            'service_contact_date'                  => 'required',
            'service_start_date'                    => 'required',
            'service_end_date'                      => 'required',
            'duration'                              => 'required',
            'charging_peroid'                       => 'required',
            'amount_before_tax'                     => 'required',
            'currency'                              => 'required',
            'charging_date'                         => 'required',
            'late_payment'                          => 'required',
            'reconnection_service_fee'              => 'required',
            'reconnection_period'                   => 'required',
            'nsf_fee'                               => 'required',
            'payment_method'                        => 'required',
             
        ]);

        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
       // $request->merge(['user_id'              =>$user_id]);
        $request->merge(['updated_by'          =>$user_id]);
       // $request->merge(['project_id'           =>$project_id]);
        $service_contact_date                   =date("Y-m-d",strtotime($request->input('service_contact_date')));
        $service_start_date                     =date("Y-m-d",strtotime($request->input('service_start_date')));
        $service_end_date                       =date("Y-m-d",strtotime($request->input('service_end_date')));
        $duration                               =date("Y-m-d",strtotime($request->input('duration')));
        $charging_date                          =date("Y-m-d",strtotime($request->input('charging_date')));
        $reconnection_date                      =date("Y-m-d",strtotime($request->input('reconnection_date')));

        $request->merge(['service_contact_date' =>$service_contact_date]);
        $request->merge(['service_start_date'   =>$service_start_date]);
        $request->merge(['service_end_date'     =>$service_end_date]);
        $request->merge(['duration'             =>$duration]);
        $request->merge(['charging_date'        =>$charging_date]);
        $request->merge(['reconnection_date'    =>$reconnection_date]);

        DB::beginTransaction();

        $service_contact_update=ServiceContact::find($id)->update($request->all());

        if( $service_contact_update)
        {
           DB::commit();
           return 1;
        }
        else
        {
            DB::rollBack();
           return 10;
        }
        die;
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
