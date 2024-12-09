<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccountType as AccountType;
use App\Models\taxTypeInitial;
use App\Models\UtilityAccount;
use App\Models\AccountHolderCustomer;
use App\Models\AccountHolderServiceProvider;
use App\Models\IncomeCenter;
use App\Models\CostCenter;
use App\Models\ClientProject;
use App\Models\Country;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Support\Facades\DB;

class UtilityAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        $data['user_type']          =$user_type;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }
        //===================Company==========================================
        
        $ArrayFunction              =new ArrayFunction();
        $utility_type               =$ArrayFunction->utility_type;
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        $payment_method             =$ArrayFunction->petty_cash_payment_method;
        $reporting_period_arr       =$ArrayFunction->reporting_period_arr;
        $data['payment_method_arr'] =$payment_method;
        $data['billing_cycle_arr']  =$reporting_period_arr;

        

        $account_type_list          =taxTypeInitial::where('status_active',1)
                                        ->where('type',7)
                                        ->whereIn('project_id',[$project_id,0])
                                        ->get();
        $account_type_arr=array();
        foreach ($account_type_list as $key => $value) {

            $account_type_arr[$value->id]['name']                   =$value->field_name;
            $account_type_arr[$value->id]['chart_of_account']       ="";
            $account_type_arr[$value->id]['chart_of_account_id']    ="";
            $account_type_arr[$value->id]['id']                     ="";
           
        }    

        $service_provider           =AccountHolderServiceProvider::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            ->where('company_id',$company_id)
                                            ->get();
        $customer_sql               =AccountHolderCustomer::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            ->where('company_id',$company_id)
                                            ->get();

        $cost_center_sql            =CostCenter::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->get();

        $income_center_sql          =IncomeCenter::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->get();

        $client_project_data        =ClientProject::where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('status_active',1)
                                        ->select('id','project_name')
                                        ->get();


        $country=Country::where('status_active',1)->get();

        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
        }
        $data['country_arr']        =$country_arr;

        $chart_of_account_list      =DB::table('chart_of_accounts as coa')
                                        ->join('coa_groups as group','coa.coa_group','=','group.reference_id')
                                        ->where('coa.project_id', '=', $project_id)
                                        ->where('coa.company_id', '=', $company_id)
                                        ->where('group.project_id', '=', $project_id)
                                        ->get(['group.account_title','group.statement_type','coa.*']);
        $coa_arr=array();$sl=0;
        if(count($chart_of_account_list)>0)
        {

            foreach ($chart_of_account_list as $key => $value) {
                $coa_arr[$sl]['id']                   =$value->id;
                $coa_arr[$sl]['account_title']        =$value->account_title;
                $coa_arr[$sl]['account_no']           =$value->account_no;
                $coa_arr[$sl]['description']          =$value->description;
                $coa_arr[$sl]['govt_tax_code']        =$value->govt_tax_code;
                $coa_arr[$sl]['tax_code']             =$value->tax_code;
                $coa_arr[$sl]['sub_group']            =$value->sub_group;
                $coa_arr[$sl]['sub_group_name']       =$accounts_sub_group[$value->sub_group];
                $sl++;         
            }
        }
      
         
        $data['account_type_arr']                   =$account_type_arr;    
        $data['coa_arr']                            =$coa_arr;
        $data['cost_center_arr']                    =$cost_center_sql;
        $data['income_center_arr']                  =$income_center_sql;
        $data['client_project_arr']                 =$client_project_data;
        $data['utility_type_arr']                   =$utility_type;
        $data['service_provider_arr']               =$service_provider;
        
        $data['customer_arr']                       =$customer_sql;
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

    public function UtilityAccountList(Request $request)
    {
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }
        $user=\Auth::user();
        $project_id                             = $user->project_id;
        //===================Company==========================================

        $ArrayFunction              =new ArrayFunction();
        $utility_type               =$ArrayFunction->utility_type;
        $reporting_period_arr       =$ArrayFunction->reporting_period_arr;
        $data['billing_cycle_arr']  =$reporting_period_arr;
       
        $client_project_data=UtilityAccount::where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('status_active',1)
                                        ->get();

        $sl=0;
        foreach ($client_project_data as $key => $value) {

            $data['client_project_list'][$key]['sl']                    =$sl+1;
            $data['client_project_list'][$key]['id']                    =$value->id;
            $data['client_project_list'][$key]['system_no']             =$value->system_no;
            $data['client_project_list'][$key]['account_name']          =$value->account_name;
            $data['client_project_list'][$key]['billing_cycle_string']  =$reporting_period_arr[$value->billing_cycle];
            $data['client_project_list'][$key]['service_schedule_date'] =date("D M j Y",strtotime($value->service_schedule_date));
            $data['client_project_list'][$key]['service_start_date']    =date("D M j Y",strtotime($value->service_start_date));
            $data['client_project_list'][$key]['utility_type_string']   =$utility_type[$value->utility_type];
            $data['client_project_list'][$key]['customer_name']         =$value->customer->customer_name;
            $data['client_project_list'][$key]['service_provider_name'] =$value->service_provider->service_provider_name;
            $sl++;
        }


        return $data;

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        request()->validate([
            'account_name'              => 'required',
            'utility_type'              => 'required',
            'billing_cycle'             => 'required',
            'service_schedule_date'     => 'required',
            'service_start_date'        => 'required',
            'service_end_date'          => 'required',
            'payment_due_date'          => 'required',
            'bill_receive_date'         => 'required',
            'payment_method'            => 'required',
            'cost_center'               => 'required',
            'income_center'             => 'required',
            'billing_cycle'             => 'required',
            'project'                   => 'required',
            'customer_no'               => 'required',
            'service_provider_no'       => 'required',
            'location_house_number'     => 'required',
            'location_street_number'    => 'required',
            'location_city'             => 'required',
            'location_state'            => 'required',
            'location_zip_code'         => 'required',
            'location_country'          => 'required',
            'location_email'            => 'required',
            'location_fax_no'           => 'required',
            'location_office_phone'     => 'required',
            'location_cell_phone'       => 'required',
            'location_website'          => 'required',
        ]);

        // protected $fillable = ['id', 'project_id', 'company_id', 'posting_status','system_no', 'system_prefix','account_name','utility_type','billing_cycle', 'service_start_date', 'service_end_date', 'payment_due_date', 'bill_receive_date','payment_method','cost_center', 'income_center', 'project', 'comments','customer_id', 'service_provider_id','posting_status','location_house_number','location_street_number', 'location_city', 'location_state', 'location_zip_code', 'location_country','location_email','location_fax_no','location_office_phone','location_cell_phone','location_website',  'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
     
        $service_start_date                  =date("Y-m-d",strtotime($request->input('service_start_date')));
        $service_end_date                    =date("Y-m-d",strtotime($request->input('service_end_date')));
        $payment_due_date                    =date("Y-m-d",strtotime($request->input('payment_due_date')));
        $bill_receive_date                   =date("Y-m-d",strtotime($request->input('bill_receive_date')));
        $service_schedule_date               =date("Y-m-d",strtotime($request->input('service_schedule_date')));
        

        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);
        $request->merge(['company_id'           =>$company_id]);
        $request->merge(['posting_status'       =>0]);
        $request->merge(['service_start_date'   =>$service_start_date]);
        $request->merge(['service_end_date'     =>$service_end_date]);
        $request->merge(['payment_due_date'     =>$payment_due_date]);
        $request->merge(['bill_receive_date'    =>$bill_receive_date]);
        $request->merge(['service_schedule_date'=>$service_schedule_date]);

        $max_system_data = UtilityAccount::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from utility_accounts 
            where company_id=".$company_id."  and project_id=".$project_id." and YEAR(created_at)=".date('Y')." ) 
            and company_id=".$company_id." and YEAR(created_at)=".date('Y')."  and project_id=".$project_id)->get(['system_prefix']);
               // ->toSql(); and floor_no=".$request->input('floor_no')."

               
       // dd($max_system_data);die;
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="UA-".date('Y')."-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $utility_info= UtilityAccount::create($request->all());


        foreach($request->account_type_arr as $key=>$details)
        {
                      
            if($details['chart_of_account']!="")
            {
                $data_account_type_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$utility_info->id,
                    'account_type'              =>$key,
                    'chart_of_account'          =>$details['chart_of_account'],
                    'page_id'                   =>7,
                    'chart_of_account_id'       =>$details['chart_of_account_id'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

       
      
        $RId1=true;
       
        if(!empty($data_account_type_details))
        {
            $RId1=AccountType::insert($data_account_type_details);
        } 

        if($utility_info && $RId1)
        {
           DB::commit();
           return "1**$utility_info->id**$system_no";
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
    public function edit($id, Request $request)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        $data['user_type']          =$user_type;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }
        //===================Company==========================================
        
        $ArrayFunction              =new ArrayFunction();
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        $payment_method             =$ArrayFunction->petty_cash_payment_method;
        $reporting_period_arr       =$ArrayFunction->reporting_period_arr;
        $utility_type               =$ArrayFunction->utility_type;
        $data['payment_method_arr'] =$payment_method;
        $data['billing_cycle_arr']  =$reporting_period_arr;

        $account_type_list          =taxTypeInitial::where('status_active',1)
                                        ->where('type',7)
                                        ->whereIn('project_id',[$project_id,0])
                                        ->get();
        $account_type_arr=array();
        foreach ($account_type_list as $key => $value) {

            $account_type_arr[$value->id]['name']                   =$value->field_name;
            $account_type_arr[$value->id]['chart_of_account']       ="";
            $account_type_arr[$value->id]['chart_of_account_id']    ="";
            $account_type_arr[$value->id]['id']                     ="";
           
        }

        $account_type_sql          =AccountType::where('status_active',1)
                                    ->where('page_id',7)   
                                    ->where('master_id',$id)
                                    ->get();


        foreach ($account_type_sql as $key => $value) {
            $account_type_arr[$value->account_type]['chart_of_account']       =$value->chart_of_account;
            $account_type_arr[$value->account_type]['chart_of_account_id']    =$value->chart_of_account_id;
            $account_type_arr[$value->account_type]['id']                     =$value->id;
        }


        $country=Country::where('status_active',1)->get();

        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
        }
        $data['country_arr']        =$country_arr;


        $utility_account_list=UtilityAccount::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_id',$company_id)
                                    ->where('id',$id)
                                    ->first();


        $data['customer']               =$utility_account_list->customer;
        $data['service_provider']       =$utility_account_list->service_provider;
        $data['utility_account_arr']     =$utility_account_list;

        $client_project_data        =ClientProject::where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('status_active',1)
                                        ->select('id','project_name')
                                        ->get();


        $service_provider               =AccountHolderServiceProvider::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            ->where('company_id',$company_id)
                                            ->get();
        $customer_sql                   =AccountHolderCustomer::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            ->where('company_id',$company_id)
                                            ->get();
        // $cost_center_sql                =CostCenter::where('status_active',1)
        //                                 ->where('project_id',$project_id)
        //                                 ->where('company_id',$company_id)
        //                                 ->get();


        $cost_center_sql                =CostCenter::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->get();

        $income_center_sql              =IncomeCenter::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->get();

        $chart_of_account_list          =DB::table('chart_of_accounts as coa')
                                        ->join('coa_groups as group','coa.coa_group','=','group.reference_id')
                                        ->where('coa.project_id', '=', $project_id)
                                        ->where('coa.company_id', '=', $company_id)
                                        ->where('group.project_id', '=', $project_id)
                                        ->get(['group.account_title','group.statement_type','coa.*']);
        $coa_arr=array();$sl=0;
        if(count($chart_of_account_list)>0)
        {

            foreach ($chart_of_account_list as $key => $value) {
                $coa_arr[$sl]['id']                   =$value->id;
                $coa_arr[$sl]['account_title']        =$value->account_title;
                $coa_arr[$sl]['account_no']           =$value->account_no;
                $coa_arr[$sl]['description']          =$value->description;
                $coa_arr[$sl]['govt_tax_code']        =$value->govt_tax_code;
                $coa_arr[$sl]['tax_code']             =$value->tax_code;
                $coa_arr[$sl]['sub_group']            =$value->sub_group;
                $coa_arr[$sl]['sub_group_name']       =$accounts_sub_group[$value->sub_group];
                $sl++;         
            }
        }

         
        $data['account_type_arr']                   =$account_type_arr;    
        $data['coa_arr']                            =$coa_arr;
        $data['cost_center_arr']                    =$cost_center_sql;
        $data['income_center_arr']                  =$income_center_sql;
        $data['utility_type_arr']                   =$utility_type;
        $data['service_provider_arr']               =$service_provider;
        $data['client_project_arr']                 =$client_project_data;

        $data['customer_arr']                       =$customer_sql;

        return $data;
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
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        request()->validate([
            'account_name'              => 'required',
            'utility_type'              => 'required',
            'billing_cycle'             => 'required',
            'service_schedule_date'     => 'required',
            'service_start_date'        => 'required',
            'service_end_date'          => 'required',
            'payment_due_date'          => 'required',
            'bill_receive_date'         => 'required',
            'payment_method'            => 'required',
            'cost_center'               => 'required',
            'income_center'             => 'required',
            'billing_cycle'             => 'required',
            'project'                   => 'required',
            'customer_no'               => 'required',
            'service_provider_no'       => 'required',
            'location_house_number'     => 'required',
            'location_street_number'    => 'required',
            'location_city'             => 'required',
            'location_state'            => 'required',
            'location_zip_code'         => 'required',
            'location_country'          => 'required',
            'location_email'            => 'required',
            'location_fax_no'           => 'required',
            'location_office_phone'     => 'required',
            'location_cell_phone'       => 'required',
            'location_website'          => 'required',
        ]);


        $service_start_date                  =date("Y-m-d",strtotime($request->input('service_start_date')));
        $service_end_date                    =date("Y-m-d",strtotime($request->input('service_end_date')));
        $payment_due_date                    =date("Y-m-d",strtotime($request->input('payment_due_date')));
        $bill_receive_date                   =date("Y-m-d",strtotime($request->input('bill_receive_date')));
        $service_schedule_date               =date("Y-m-d",strtotime($request->input('service_schedule_date')));

        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['updated_by '          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);
        $request->merge(['company_id'           =>$company_id]);
        $request->merge(['posting_status'       =>0]);
        $request->merge(['service_start_date'   =>$service_start_date]);
        $request->merge(['service_end_date'     =>$service_end_date]);
        $request->merge(['payment_due_date'     =>$payment_due_date]);
        $request->merge(['bill_receive_date'    =>$bill_receive_date]);
        $request->merge(['service_schedule_date'=>$service_schedule_date]);

        DB::beginTransaction();
        $project_info= UtilityAccount::find($id)->update($request->all());
        foreach($request->account_type_arr as $key=>$details)
        {

              
            if($details['chart_of_account']!="")
            {
                if($details['id']!="")
                {
                    $account_type_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'account_type'              =>$key,
                        'chart_of_account'          =>$details['chart_of_account'],
                        'page_id'                   =>7,
                        'chart_of_account_id'       =>$details['chart_of_account_id'],
                        'updated_by'                =>$user_id
                    );

                    $AccountPaybleUpdate=AccountType::where('id',"=",$details['id'])->update($account_type_details_data);
                    if( !$AccountPaybleUpdate)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_account_type_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'account_type'              =>$key,
                        'chart_of_account'          =>$details['chart_of_account'],
                        'page_id'                   =>7,
                        'chart_of_account_id'       =>$details['chart_of_account_id'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
                                   
        } 
           
        

        $RId1=true;
        if(!empty($data_account_type_details))
        {
            $RId1=AccountType::insert($data_account_type_details);
        } 

        if($project_info && $RId1)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
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

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        DB::beginTransaction();
        $client_info= UtilityAccount::find($id)->update(['updated_by'=>$user_id,'status_active'=>0,'is_deleted'=>1]);

        $update_data= array(
                        
                            'status_active'             =>0,
                            'is_deleted'                =>1,
                            'updated_by'                =>$user_id,
                        );
       

        $RID5_delete=AccountType::where('master_id',"=",$id)->where('page_id',"=",7)->update($update_data);

        if($client_info && $RID_delete)
        {           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }

    public function post(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>$request->input("posting_status"),
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=UtilityAccount::where('id',"=",$id)->update($update_data);

        if($buildingInfo)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }
    public function adjust(Request $request, $id)
    {
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        request()->validate([
            'account_name'              => 'required',
            'utility_type'              => 'required',
            'billing_cycle'             => 'required',
            'service_schedule_date'     => 'required',
            'service_start_date'        => 'required',
            'service_end_date'          => 'required',
            'payment_due_date'          => 'required',
            'bill_receive_date'         => 'required',
            'payment_method'            => 'required',
            'cost_center'               => 'required',
            'income_center'             => 'required',
            'billing_cycle'             => 'required',
            'project'                   => 'required',
            'customer_no'               => 'required',
            'service_provider_no'       => 'required',
            'location_house_number'     => 'required',
            'location_street_number'    => 'required',
            'location_city'             => 'required',
            'location_state'            => 'required',
            'location_zip_code'         => 'required',
            'location_country'          => 'required',
            'location_email'            => 'required',
            'location_fax_no'           => 'required',
            'location_office_phone'     => 'required',
            'location_cell_phone'       => 'required',
            'location_website'          => 'required',
        ]);


        $service_start_date                  =date("Y-m-d",strtotime($request->input('service_start_date')));
        $service_end_date                    =date("Y-m-d",strtotime($request->input('service_end_date')));
        $payment_due_date                    =date("Y-m-d",strtotime($request->input('payment_due_date')));
        $bill_receive_date                   =date("Y-m-d",strtotime($request->input('bill_receive_date')));
        $service_schedule_date               =date("Y-m-d",strtotime($request->input('service_schedule_date')));

        

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
       

        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['updated_by'           =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);
        $request->merge(['company_id'           =>$company_id]);
        $request->merge(['posting_status'       =>3]);
        $request->merge(['service_start_date'   =>$service_start_date]);
        $request->merge(['service_end_date'     =>$service_end_date]);
        $request->merge(['payment_due_date'     =>$payment_due_date]);
        $request->merge(['bill_receive_date'    =>$bill_receive_date]);
        $request->merge(['service_schedule_date'=>$service_schedule_date]);


        DB::beginTransaction();
        $project_info= UtilityAccount::find($id)->update($request->all());
        foreach($request->account_type_arr as $key=>$details)
        {
            if($details['chart_of_account']!="")
            {
                if($details['id']!="")
                {
                    $account_type_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'account_type'              =>$key,
                        'chart_of_account'          =>$details['chart_of_account'],
                        'page_id'                   =>7,
                        'chart_of_account_id'       =>$details['chart_of_account_id'],
                        'updated_by'                =>$user_id
                    );

                    $AccountPaybleUpdate=AccountType::where('id',"=",$details['id'])->update($account_type_details_data);
                    if( !$AccountPaybleUpdate)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_account_type_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'account_type'              =>$key,
                        'chart_of_account'          =>$details['chart_of_account'],
                        'page_id'                   =>7,
                        'chart_of_account_id'       =>$details['chart_of_account_id'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
                                   
        } 
        


        $RId1=true;
        if(!empty($data_account_type_details))
        {
            $RId1=AccountType::insert($data_account_type_details);
        } 

        if($project_info && $RId1)
        {
           DB::commit();
           return "1**$id";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }


    public function repost(Request $request,$id)
    {

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>4,
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=UtilityAccount::where('id',"=",$id)->update($update_data);

        if($buildingInfo)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }
}
