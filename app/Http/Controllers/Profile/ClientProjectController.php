<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccountType as AccountType;
use App\Models\inseuranceType as inseuranceType;
use App\Models\InsuranceTypeList;
use App\Models\AccountHolderCustomer;
use App\Models\AccountHolderServiceProvider;
use App\Models\IncomeCenter;
use App\Models\CostCenter;
use App\Models\taxTypeInitial;
use App\Models\BuildingContactList;
use App\Models\BuildingContactDetails;
use App\Models\ServiceProviderInsPkg;
use App\Models\PropertyProjectDuration;
use App\Models\PropertyProjectTimeline;
use App\Models\PropertyProjectAmount;
use App\Models\PropPrjPaymentSchedule;
// use App\Models\ServiceProviderInsPkg;
// use App\Models\ServiceProviderInsPkg;
use App\Models\ClientProject;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Support\Facades\DB;

class ClientProjectController extends Controller
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
        $project_status             =$ArrayFunction->project_status;
        $project_type               =$ArrayFunction->project_type;
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        $payment_method             =$ArrayFunction->petty_cash_payment_method;
        $data['payment_method_arr'] =$payment_method;

        $account_type_list          =taxTypeInitial::where('status_active',1)
                                        ->where('type',20)
                                        ->whereIn('project_id',[$project_id,0])
                                        ->get();
        $account_type_arr=array();
        foreach ($account_type_list as $key => $value) {

            $account_type_arr[$value->id]['name']                   =$value->field_name;
            $account_type_arr[$value->id]['chart_of_account']       ="";
            $account_type_arr[$value->id]['chart_of_account_id']    ="";
            $account_type_arr[$value->id]['id']                     ="";
           
        }


        $insurance_type_list=InsuranceTypeList::where('status_active',1)
                                    ->whereIn('project_id',[0,$project_id])
                                    ->get();
        $sl=0;
        $insurance_type_list_arr=array();
        foreach ($insurance_type_list as $key => $value) {
            $insurance_type_list_arr[$sl]['reference_id']   =$value->id;
            $insurance_type_list_arr[$sl]['item_name']      =$value->item_name;
            $insurance_type_list_arr[$sl]['company_name']   ="";
            $insurance_type_list_arr[$sl]['address']        ="";
            $insurance_type_list_arr[$sl]['policy_no']      ="";
            $insurance_type_list_arr[$sl]['expire_date']    ="";
            $insurance_type_list_arr[$sl]['max_coverage']   ="";
            $insurance_type_list_arr[$sl]['id']             ="";
            $sl++;
        }

        $data['insurance_type_list_arr']        =$insurance_type_list_arr;

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


        $building_contact_list=BuildingContactList::where('status_active',1)
                                    ->where('page_id',20)
                                    ->whereIn('project_id',[0,$project_id])
                                    ->get();
        $sl=0;
        $building_contact_list_arr=array();
        foreach ($building_contact_list as $key => $value) {
            $building_contact_list_arr[$sl]['id']            =$value->id;
            $building_contact_list_arr[$sl]['refernece_id']  =$value->refernece_id;
            $building_contact_list_arr[$sl]['item_name']     =$value->item_name;
            $building_contact_list_arr[$sl]['item_type']     =$value->item_type;
            $sl++;
        }
        $data['building_contact_list_arr']          =$building_contact_list_arr;
         
        $data['account_type_arr']                   =$account_type_arr;    
        $data['coa_arr']                            =$coa_arr;
        $data['cost_center_arr']                    =$cost_center_sql;
        $data['income_center_arr']                  =$income_center_sql;
        $data['project_type_arr']                   =$project_type;
        $data['project_status_arr']                 =$project_status;
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

    public function ClientProjectList(Request $request)
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
        $project_status             =$ArrayFunction->project_status;
        $project_type               =$ArrayFunction->project_type;
       
        $client_project_data=ClientProject::where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('status_active',1)
                                        ->get();

        $sl=0;
        foreach ($client_project_data as $key => $value) {

            $data['client_project_list'][$key]['sl']                    =$sl+1;
            $data['client_project_list'][$key]['id']                    =$value->id;
            $data['client_project_list'][$key]['system_no']             =$value->system_no;
            $data['client_project_list'][$key]['project_name']          =$value->project_name;
            $data['client_project_list'][$key]['subject_title']         =$value->subject_title;
            $data['client_project_list'][$key]['location_name']         =$value->location_name;
            $data['client_project_list'][$key]['final_delivery_date']   =date("Y-m-d",strtotime($value->final_delivery_date));
            $data['client_project_list'][$key]['project_type_string']   =$project_type[$value->current_status];
            $data['client_project_list'][$key]['current_status_string'] =$project_status[$value->current_status];
            $data['client_project_list'][$key]['customer_name']         =$value->customer->customer_name;
            $data['client_project_list'][$key]['contractor_name']       =$value->contractor->service_provider_name;
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
            'project_name' => 'required',
            'subject_title' => 'required',
            'current_status' => 'required',
            'contractor_no' => 'required',
            'customer_no' => 'required',
            'project_type' => 'required',
            'location_name' => 'required',
            'final_delivery_date' => 'required',
            //'final_delivery_date' => 'required',
            

        ]);
     
        $final_delivery_date                    =date("Y-m-d",strtotime($request->input('final_delivery_date')));

        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);
        $request->merge(['company_id'           =>$company_id]);
        $request->merge(['posting_status'       =>0]);
        $request->merge(['final_delivery_date'  =>$final_delivery_date]);

        $max_system_data = ClientProject::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from client_projects 
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

        $system_no="CP-".date('Y')."-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $property_info= ClientProject::create($request->all());

       

        foreach($request->insurance_list_arr as $key=>$details)
        {
            if($details['company_name'] )
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['expire_date'])       
                    $details['expire_date']       =date("Y-m-d",strtotime($details['expire_date']));
                $data_inseurance_type_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'item_name'                 =>$details['item_name'],
                    'company_name'              =>$details['company_name'],
                    'address'                   =>$details['address'],
                    'policy_no'                 =>$details['policy_no'],
                    'expire_date'               =>$details['expire_date'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );              
            }
        }

        foreach($request->project_duration_arr as $key=>$details)
        {
            if($details['from_date'])
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['from_date'])       
                    $details['from_date']       =date("Y-m-d",strtotime($details['from_date']));

                if($details['to_date'])       
                    $details['to_date']         =date("Y-m-d",strtotime($details['to_date']));
                
                
                $data_project_duration_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'item_name'                 =>$details['item_name'],
                    'net_year'                  =>$details['net_year'],
                    'net_days'                  =>$details['net_days'],
                    'from_date'                 =>$details['from_date'],
                    'to_date'                   =>$details['to_date'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );                
            }
        } 

        foreach($request->project_timeline_arr as $key=>$details)
        {
            if($details['task_details'])
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                
                if($details['from_date'])       
                    $details['from_date']       =date("Y-m-d",strtotime($details['from_date']));

                if($details['to_date'])       
                    $details['to_date']         =date("Y-m-d",strtotime($details['to_date']));

                if($details['reschedule_to_date'])       
                    $details['reschedule_to_date']         =date("Y-m-d",strtotime($details['reschedule_to_date']));

                if($details['reschedule_from_date'])       
                    $details['reschedule_from_date']       =date("Y-m-d",strtotime($details['reschedule_from_date']));

                // if($details['reschedule_to_date2'])       
                //     $details['reschedule_to_date2']         =date("Y-m-d",strtotime($details['reschedule_to_date2']));

                // if($details['reschedule_from_date2'])       
                //     $details['reschedule_from_date2']       =date("Y-m-d",strtotime($details['reschedule_from_date2']));

                // if($details['reschedule_to_date3'])       
                //     $details['reschedule_to_date3']         =date("Y-m-d",strtotime($details['reschedule_to_date3']));

                // if($details['reschedule_from_date3'])       
                //     $details['reschedule_from_date3']       =date("Y-m-d",strtotime($details['reschedule_from_date3']));

                
                $data_timeline_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'net_hours'                 =>$details['net_hours'],
                    'task_details'              =>$details['task_details'],
                    'net_days'                  =>$details['net_days'],
                    'to_date'                   =>$details['to_date'],
                    'from_date'                 =>$details['from_date'],
                    'reschedule_from_date'      =>$details['reschedule_from_date'],
                    'reschedule_to_date'        =>$details['reschedule_to_date'],
                    'task_status'               =>$details['task_status'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );

               
            }
        }
        //dd($request->project_amount_arr);
        foreach($request->project_cost_arr as $key=>$details)
        {
            if($details['amount_before_tax'])
            {
                $insert_date                    =date("Y-m-d h:i:s");
                $data_amount_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'type'                      =>$details['type'],
                    'title'                     =>$details['title'],
                    'amount_before_tax'         =>$details['amount_before_tax'],
                    'taxes'                     =>$details['taxes'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );
            }
        }

        foreach($request->payment_schedule_arr as $key=>$details)
        {
            if($details['due_date']!="")
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['due_date'])       
                    $details['due_date']        =date("Y-m-d",strtotime($details['due_date']));


                $data_payment_schedule_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'payment_method'            =>$details['payment_method'],
                    'amount'                    =>$details['amount'],
                    'bank_account_no'           =>$details['bank_account_no'],
                    'due_date'                  =>$details['due_date'],
                    'is_calendar'               =>$details['is_calendar'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );
            }
        } 

        foreach($request->account_type_arr as $key=>$details)
        {
                      
            if($details['chart_of_account']!="")
            {
                $data_account_type_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'account_type'              =>$key,
                    'chart_of_account'          =>$details['chart_of_account'],
                    'page_id'                   =>20,
                    'chart_of_account_id'       =>$details['chart_of_account_id'],
                    'inserted_by'               =>$user_id,
                );
            }
                   
        }

        foreach($request->building_contact_details_arr as $item_id=>$item_details)
        {
            if($item_id>0)
            {
               foreach($item_details as $key=>$details)
                {
                    if($details['contact_no']!="")
                    {
                        $data_building_contact[]= array(
                            'project_id'                =>$project_id,
                            'master_id'                 =>$property_info->id,
                            'item_id'                   =>$item_id,
                            'page_id'                   =>20,
                            'reference_id'              =>$details['reference_id'],
                            'item_name'                 =>$details['item_name'],
                            'contact_no'                =>$details['contact_no'],
                            'phone'                     =>$details['phone'],
                            'website'                   =>$details['website'],
                            'mobile'                    =>$details['mobile'],
                            'email'                     =>$details['email'],
                            'hours_of_operation'        =>$details['hours_of_operation'],
                            'comment'                   =>$details['comment'],
                            'inserted_by'               =>$user_id,
                        );
                    }
                } 
            }
            
        } 
      
        $RId1=true;
        if(!empty($data_building_contact))
        {
            $RId1=BuildingContactDetails::insert($data_building_contact);
        }
        $RId2=true;
        if(!empty($data_inseurance_type_details))
        {
            $RId2=ServiceProviderInsPkg::insert($data_inseurance_type_details);
        }
        $RId3=true;
        if(!empty($data_project_duration_details))
        {
            $RId3=PropertyProjectDuration::insert($data_project_duration_details);
        }
        $RId4=true;
        if(!empty($data_timeline_details))
        {
            $RId4=PropertyProjectTimeline::insert($data_timeline_details);
        }
        $RId5=true;
        if(!empty($data_amount_details))
        {
            $RId5=PropertyProjectAmount::insert($data_amount_details);
        }
        $RId6=true;
        if(!empty($data_payment_schedule_details))
        {
            $RId6=PropPrjPaymentSchedule::insert($data_payment_schedule_details);
        }

         $RId7=true;
        if(!empty($data_account_type_details))
        {
            $RId7=AccountType::insert($data_account_type_details);
        } 

    

        if($property_info && $RId1 && $RId2 && $RId3 && $RId4 && $RId5 && $RId6 && $RId7)
        {
           DB::commit();
           return "1**$property_info->id**$system_no";
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
        $project_status             =$ArrayFunction->project_status;
        $project_type               =$ArrayFunction->project_type;
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        $payment_method             =$ArrayFunction->petty_cash_payment_method;
        $data['payment_method_arr'] =$payment_method;

        $account_type_list          =taxTypeInitial::where('status_active',1)
                                        ->where('type',20)
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
                                    ->where('page_id',20)   
                                    ->where('master_id',$id)
                                    ->get();


        foreach ($account_type_sql as $key => $value) {
            $account_type_arr[$value->account_type]['chart_of_account']       =$value->chart_of_account;
            $account_type_arr[$value->account_type]['chart_of_account_id']    =$value->chart_of_account_id;
            $account_type_arr[$value->account_type]['id']                     =$value->id;
        }


        $insurance_type_list=InsuranceTypeList::where('status_active',1)
                                    ->whereIn('project_id',[0,$project_id])
                                    ->get();
        $sl=0;
        $insurance_type_list_arr=array();
        foreach ($insurance_type_list as $key => $value) {
            $insurance_type_list_arr[$value->id]['reference_id']   =$value->id;
            $insurance_type_list_arr[$value->id]['item_name']      =$value->item_name;
            $insurance_type_list_arr[$value->id]['company_name']   ="";
            $insurance_type_list_arr[$value->id]['address']        ="";
            $insurance_type_list_arr[$value->id]['policy_no']      ="";
            $insurance_type_list_arr[$value->id]['expire_date']    ="";
            $insurance_type_list_arr[$value->id]['max_coverage']   ="";
            $insurance_type_list_arr[$value->id]['id']             ="";
        }

        $insurance_type_list=ServiceProviderInsPkg::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('master_id',$id)
                                    ->get();
       
        foreach ($insurance_type_list as $key => $value) {
            $insurance_type_list_arr[$value->id]['reference_id']   =$value->id;
            $insurance_type_list_arr[$value->id]['item_name']      =$value->item_name;
            $insurance_type_list_arr[$value->id]['company_name']   =$value->company_name;
            $insurance_type_list_arr[$value->id]['address']        =$value->address;
            $insurance_type_list_arr[$value->id]['policy_no']      =$value->policy_no;
            $insurance_type_list_arr[$value->id]['expire_date']    =$value->expire_date;
            $insurance_type_list_arr[$value->id]['max_coverage']   =$value->max_coverage;
            $insurance_type_list_arr[$value->id]['id']             =$value->id;
        }

        $data['insurance_type_list_arr']        =$insurance_type_list_arr;


        $client_project_list=ClientProject::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_id',$company_id)
                                    ->where('id',$id)
                                    ->first();


        $data['customer']               =$client_project_list->customer;
        $data['service_provider']       =$client_project_list->contractor;
        $data['client_project_arr']     =$client_project_list;

        $client_project_duration_list=PropertyProjectDuration::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('master_id',$id)
                                    ->get();
        $sl=0;
        if(!empty($client_project_duration_list))
        {
             foreach ($client_project_duration_list as $key => $value) {
                $project_duration_arr[$sl]['item_name']     =$value->item_name;
                $project_duration_arr[$sl]['from_date']     =$value->from_date;
                $project_duration_arr[$sl]['to_date']       =$value->to_date;
                $project_duration_arr[$sl]['net_year']      =$value->net_year;
                $project_duration_arr[$sl]['net_days']      =$value->net_days;
                $project_duration_arr[$sl]['id']            =$value->id;
                $sl++;
            }
        }
        else
        {
            $project_duration_arr[$sl]['item_name']     ="Initial Date";
            $project_duration_arr[$sl]['from_date']     ="";
            $project_duration_arr[$sl]['to_date']       ="";
            $project_duration_arr[$sl]['net_year']      ="";
            $project_duration_arr[$sl]['net_days']      ="";
            $project_duration_arr[$sl]['id']            ="";
            $sl++;
            $project_duration_arr[$sl]['item_name']     ="Extend Date 1";
            $project_duration_arr[$sl]['from_date']     ="";
            $project_duration_arr[$sl]['to_date']       ="";
            $project_duration_arr[$sl]['net_year']      ="";
            $project_duration_arr[$sl]['net_days']      ="";
            $project_duration_arr[$sl]['id']            ="";
        }

        $data['project_duration_arr']  =$project_duration_arr;




        $client_project_timeline_list=PropertyProjectTimeline::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('master_id',$id)
                                        ->get();
        $sl=0;
        if(!empty($client_project_timeline_list))
        {
             foreach ($client_project_timeline_list as $key => $value) {
                $project_timeline_arr[$sl]['task_details']          =$value->task_details;
                $project_timeline_arr[$sl]['from_date']             =$value->from_date;
                $project_timeline_arr[$sl]['to_date']               =$value->to_date;
                $project_timeline_arr[$sl]['net_hours']             =$value->net_hours;
                $project_timeline_arr[$sl]['net_days']              =$value->net_days;
                $project_timeline_arr[$sl]['task_status']           =$value->task_status;
                $project_timeline_arr[$sl]['reschedule_from_date']  =$value->reschedule_from_date;
                $project_timeline_arr[$sl]['reschedule_to_date']    =$value->reschedule_to_date;
                $project_timeline_arr[$sl]['id']                    =$value->id;
                $sl++;
            }
        }
        else
        {
            $project_timeline_arr[$sl]['task_details']          ="";
            $project_timeline_arr[$sl]['from_date']             ="";
            $project_timeline_arr[$sl]['to_date']               ="";
            $project_timeline_arr[$sl]['net_hours']             ="";
            $project_timeline_arr[$sl]['net_days']              ="";
            $project_timeline_arr[$sl]['task_status']           ="";
            $project_timeline_arr[$sl]['reschedule_from_date']  ="";
            $project_timeline_arr[$sl]['reschedule_to_date']    ="";
            $project_timeline_arr[$sl]['id']                    ="";
        }

        $data['project_timeline_arr']  =$project_timeline_arr;


        $client_payment_schedule_list=PropPrjPaymentSchedule::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('master_id',$id)
                                        ->get();
        $sl=0;
        if(!empty($client_payment_schedule_list))
        {
             foreach ($client_payment_schedule_list as $key => $value) {
                $payment_schedule_arr[$sl]['payment_method']            =$value->payment_method;
                $payment_schedule_arr[$sl]['amount']                    =$value->amount;
                $payment_schedule_arr[$sl]['bank_account_no']           =$value->bank_account_no;
                $payment_schedule_arr[$sl]['due_date']                  =$value->due_date;
                $payment_schedule_arr[$sl]['is_calendar']               =$value->is_calendar;
                $payment_schedule_arr[$sl]['id']                        =$value->id;
                $sl++;
            }
        }
        else
        {
            $payment_schedule_arr[$sl]['payment_method']        ="";
            $payment_schedule_arr[$sl]['amount']                ="";
            $payment_schedule_arr[$sl]['bank_account_no']       ="";
            $payment_schedule_arr[$sl]['due_date']              ="";
            $payment_schedule_arr[$sl]['is_calendar']           ="";
            $payment_schedule_arr[$sl]['id']                    ="";
        }

        $data['payment_schedule_arr']  =$payment_schedule_arr;


        $client_project_amount_list=PropertyProjectAmount::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('master_id',$id)
                                        ->get();
        $sl=0;
        if(!empty($client_project_amount_list))
        {
            foreach ($client_project_amount_list as $key => $value) {
                $project_cost_arr[$sl]['type']                  =$value->type;
                $project_cost_arr[$sl]['title']                 =$value->title;
                $project_cost_arr[$sl]['amount_before_tax']     =$value->amount_before_tax;
                $project_cost_arr[$sl]['taxes']                 =$value->taxes;
                $project_cost_arr[$sl]['id']                    =$value->id;
                $sl++;
            }
        }
        else
        {
            $project_cost_arr[$sl]['type']                      ="";
            $project_cost_arr[$sl]['title']                     ="";
            $project_cost_arr[$sl]['amount_before_tax']         ="";
            $project_cost_arr[$sl]['taxes']                     ="";
            $project_cost_arr[$sl]['id']                        ="";
        }

        $data['project_cost_arr']  =$project_cost_arr;




        $service_provider               =AccountHolderServiceProvider::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            ->where('company_id',$company_id)
                                            ->get();

        $customer_sql                   =AccountHolderCustomer::where('status_active',1)
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


        $building_contact_details=BuildingContactDetails::where('status_active',1)
                                                        ->where('page_id',20)
                                                        ->where('master_id',$id)
                                                        ->where('project_id',$project_id)
                                                        ->get();


        $building_contact_details_arr=array();
        $building_contact_details_check_arr=array();
        foreach ($building_contact_details as $key => $value) {
            
            $building_contact_details_arr[$value->reference_id]['id']                   =$value->id;
            $building_contact_details_arr[$value->reference_id]['reference_id']         =$value->reference_id;
            $building_contact_details_arr[$value->reference_id]['item_id']              =$value->item_id;
            $building_contact_details_arr[$value->reference_id]['item_name']            =$value->item_name;
            $building_contact_details_arr[$value->reference_id]['contact_no']           =$value->contact_no;
            $building_contact_details_arr[$value->reference_id]['comment']              =$value->comment;
            $building_contact_details_arr[$value->reference_id]['phone']                =$value->phone;
            $building_contact_details_arr[$value->reference_id]['website']              =$value->website;
            $building_contact_details_arr[$value->reference_id]['mobile']               =$value->mobile;
            $building_contact_details_arr[$value->reference_id]['email']                =$value->email;
            $building_contact_details_arr[$value->reference_id]['hours_of_operation']   =$value->hours_of_operation;
           
            $building_contact_details_check_arr[$value->reference_id]=$value->reference_id;
        }

        $building_contact_list=BuildingContactList::where('status_active',1)
                                    ->where('page_id',20)
                                    ->whereIn('project_id',[0,$project_id])
                                    ->get();
        $sl=0;
        $building_contact_list_arr=array();
        foreach ($building_contact_list as $key => $value) {

            if(in_array($value->id,$building_contact_details_check_arr))
            {
                $building_contact_list_arr[$sl]['id']                   =$building_contact_details_arr[$value->id]["id"];
                $building_contact_list_arr[$sl]['reference_id']         =$value->id;
                $building_contact_list_arr[$sl]['item_type']            =$value->item_type;

                $building_contact_list_arr[$sl]['item_name']            =$value->item_name;
                $building_contact_list_arr[$sl]['contact_no']           =$building_contact_details_arr[$value->id]["contact_no"];
                $building_contact_list_arr[$sl]['comment']              =$building_contact_details_arr[$value->id]["comment"];
                $building_contact_list_arr[$sl]['phone']                =$building_contact_details_arr[$value->id]["phone"];
                $building_contact_list_arr[$sl]['website']              =$building_contact_details_arr[$value->id]["website"];
                $building_contact_list_arr[$sl]['mobile']               =$building_contact_details_arr[$value->id]["mobile"];
                $building_contact_list_arr[$sl]['email']                =$building_contact_details_arr[$value->id]["email"];
                $building_contact_list_arr[$sl]['hours_of_operation']   =$building_contact_details_arr[$value->id]["hours_of_operation"];               
            }
            else{

                $building_contact_list_arr[$sl]['id']                   ="";
                $building_contact_list_arr[$sl]['reference_id']         =$value->id;
                $building_contact_list_arr[$sl]['item_name']            =$value->item_name;
                $building_contact_list_arr[$sl]['item_type']            =$value->item_type;
                $building_contact_list_arr[$sl]['contact_no']           ="";
                $building_contact_list_arr[$sl]['comment']              ="";
                $building_contact_list_arr[$sl]['website']              ="";
                $building_contact_list_arr[$sl]['phone']                ="";
                $building_contact_list_arr[$sl]['mobile']               ="";
                $building_contact_list_arr[$sl]['email']                ="";
                $building_contact_list_arr[$sl]['hours_of_operation']   ="";

            }

            $sl++;
        }

        $data['building_contact_list_arr']          =$building_contact_list_arr;
         
        $data['account_type_arr']                   =$account_type_arr;    
        $data['coa_arr']                            =$coa_arr;
        $data['cost_center_arr']                    =$cost_center_sql;
        $data['income_center_arr']                  =$income_center_sql;
        $data['project_type_arr']                   =$project_type;
        $data['project_status_arr']                 =$project_status;
        $data['service_provider_arr']               =$service_provider;
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
            'project_name' => 'required',
            'subject_title' => 'required',
            'current_status' => 'required',
            'contractor_no' => 'required',
            'customer_no' => 'required',
            'project_type' => 'required',
            'location_name' => 'required',
            'final_delivery_date' => 'required',
        ]);


       $final_delivery_date                    =date("Y-m-d",strtotime($request->input('final_delivery_date')));

        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['updated_by '          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);
        $request->merge(['company_id'           =>$company_id]);
        $request->merge(['posting_status'       =>0]);
        $request->merge(['final_delivery_date'  =>$final_delivery_date]);
      

        DB::beginTransaction();
        $project_info= ClientProject::find($id)->update($request->all());
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
                        'page_id'                   =>20,
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
                        'page_id'                   =>20,
                        'chart_of_account_id'       =>$details['chart_of_account_id'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
                                   
        } 
        foreach($request->insurance_list_arr as $key=>$details)
        {
            if($details['company_name'] )
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['expire_date'])       
                    $details['expire_date']       =date("Y-m-d",strtotime($details['expire_date']));

                if($details['id']!="")
                {
                    $inseurance_type_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'item_name'                 =>$details['item_name'],
                        'company_name'              =>$details['company_name'],
                        'address'                   =>$details['address'],
                        'policy_no'                 =>$details['policy_no'],
                        'expire_date'               =>$details['expire_date'],
                        'updated_by'                =>$user_id
                    );

                    $insurancePackageUpdate=ServiceProviderInsPkg::where('id',"=",$details['id'])->update($inseurance_type_details_data);
                    if( !$insurancePackageUpdate)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_inseurance_type_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'item_name'                 =>$details['item_name'],
                        'company_name'              =>$details['company_name'],
                        'address'                   =>$details['address'],
                        'policy_no'                 =>$details['policy_no'],
                        'expire_date'               =>$details['expire_date'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );
                }              
            }
        }

        foreach($request->project_duration_arr as $key=>$details)
        {
            if($details['from_date'])
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['from_date'])       
                    $details['from_date']       =date("Y-m-d",strtotime($details['from_date']));

                if($details['to_date'])       
                    $details['to_date']         =date("Y-m-d",strtotime($details['to_date']));
                
                if($details['id']!="")
                {
                    $project_duration_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_name'                 =>$details['item_name'],
                        'net_year'                  =>$details['net_year'],
                        'net_days'                  =>$details['net_days'],
                        'from_date'                 =>$details['from_date'],
                        'to_date'                   =>$details['to_date'],
                        'updated_by'                =>$user_id
                    );

                    $projectDurationUpdate=PropertyProjectDuration::where('id',"=",$details['id'])->update($project_duration_details_data);
                    if( !$projectDurationUpdate)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_project_duration_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_name'                 =>$details['item_name'],
                        'net_year'                  =>$details['net_year'],
                        'net_days'                  =>$details['net_days'],
                        'from_date'                 =>$details['from_date'],
                        'to_date'                   =>$details['to_date'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    ); 
                }               
            }
        } 

        foreach($request->project_timeline_arr as $key=>$details)
        {
            if($details['task_details'])
            {
                
                $insert_date                            =date("Y-m-d h:i:s");
                
                if($details['from_date'])       
                    $details['from_date']               =date("Y-m-d",strtotime($details['from_date']));

                if($details['to_date'])       
                    $details['to_date']                 =date("Y-m-d",strtotime($details['to_date']));

                if($details['reschedule_to_date'])       
                    $details['reschedule_to_date']      =date("Y-m-d",strtotime($details['reschedule_to_date']));

                if($details['reschedule_from_date'])       
                    $details['reschedule_from_date']    =date("Y-m-d",strtotime($details['reschedule_from_date']));

                if($details['id']!="")
                {
                    $project_timeline_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'task_details'              =>$details['task_details'],
                        'net_hours'                 =>$details['net_hours'],
                        'net_days'                  =>$details['net_days'],
                        'to_date'                   =>$details['to_date'],
                        'from_date'                 =>$details['from_date'],
                        'reschedule_from_date'      =>$details['reschedule_from_date'],
                        'reschedule_to_date'        =>$details['reschedule_to_date'],
                        'task_status'               =>$details['task_status'],
                        'updated_by'                =>$user_id
                    );

                    $projectTimelineUpdate=PropertyProjectTimeline::where('id',"=",$details['id'])->update($project_timeline_details_data);
                    if( !$projectTimelineUpdate)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                
                    $data_timeline_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'task_details'              =>$details['task_details'],
                        'net_hours'                 =>$details['net_hours'],
                        'net_days'                  =>$details['net_days'],
                        'to_date'                   =>$details['to_date'],
                        'from_date'                 =>$details['from_date'],
                        'reschedule_from_date'      =>$details['reschedule_from_date'],
                        'reschedule_to_date'        =>$details['reschedule_to_date'],
                        'task_status'               =>$details['task_status'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );
                }

            }
        }
        //dd($request->project_amount_arr);
        foreach($request->project_cost_arr as $key=>$details)
        {
            if($details['amount_before_tax'])
            {
                $insert_date                    =date("Y-m-d h:i:s");

                if($details['id']!="")
                {
                    $project_cost_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'type'                      =>$details['type'],
                        'title'                     =>$details['title'],
                        'amount_before_tax'         =>$details['amount_before_tax'],
                        'taxes'                     =>$details['taxes'],
                        'updated_by'                =>$user_id
                    );

                    $projectTimelineUpdate=PropertyProjectAmount::where('id',"=",$details['id'])->update($project_cost_details_data);
                    if( !$projectTimelineUpdate)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_amount_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'type'                      =>$details['type'],
                        'title'                     =>$details['title'],
                        'amount_before_tax'         =>$details['amount_before_tax'],
                        'taxes'                     =>$details['taxes'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );
                }
            }
        }

        foreach($request->payment_schedule_arr as $key=>$details)
        {
            if($details['due_date']!="")
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['due_date'])       
                    $details['due_date']        =date("Y-m-d",strtotime($details['due_date']));

                if($details['id']!="")
                {
                    $project_payment_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'payment_method'            =>$details['payment_method'],
                        'amount'                    =>$details['amount'],
                        'bank_account_no'           =>$details['bank_account_no'],
                        'due_date'                  =>$details['due_date'],
                        'is_calendar'               =>$details['is_calendar'],
                        'updated_by'                =>$user_id
                    );

                    $projectPaymentScheduleUpdate=PropPrjPaymentSchedule::where('id',"=",$details['id'])->update($project_payment_details_data);
                    if( !$projectPaymentScheduleUpdate)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_payment_schedule_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'payment_method'            =>$details['payment_method'],
                        'amount'                    =>$details['amount'],
                        'bank_account_no'           =>$details['bank_account_no'],
                        'due_date'                  =>$details['due_date'],
                        'is_calendar'               =>$details['is_calendar'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );

                }
            }
        } 

        

        foreach($request->building_contact_details_arr as $item_id=>$item_details)
        {
            if($item_id>0)
            {
               foreach($item_details as $key=>$details)
                {
                    if($details['contact_no']!="")
                    {

                        if($details['id']!="")
                        {
                            $building_contact_data= array(
                                'contact_no'                =>$details['contact_no'],
                                'phone'                     =>$details['phone'],
                                'website'                   =>$details['website'],
                                'mobile'                    =>$details['mobile'],
                                'email'                     =>$details['email'],
                                'hours_of_operation'        =>$details['hours_of_operation'],
                                'comment'                   =>$details['comment'],
                                'updated_by'                =>$user_id,
                            );

                            $buildingContact=BuildingContactDetails::where('id',"=",$details['id'])->update($building_contact_data);
                            if( !$buildingContact)
                            {
                                DB::rollBack();
                                return 10;
                                die;
                            }
                        }
                        else
                        {
                             $data_building_contact[]= array(
                                'project_id'                =>$project_id,
                                'master_id'                 =>$id,
                                'item_id'                   =>$item_id,
                                'page_id'                   =>20,
                                'reference_id'              =>$details['reference_id'],
                                'item_name'                 =>$details['item_name'],
                                'contact_no'                =>$details['contact_no'],
                                'phone'                     =>$details['phone'],
                                'website'                   =>$details['website'],
                                'mobile'                    =>$details['mobile'],
                                'email'                     =>$details['email'],
                                'hours_of_operation'        =>$details['hours_of_operation'],
                                'comment'                   =>$details['comment'],
                                'inserted_by'               =>$user_id,
                            );
                        }
                       
                    }
                } 
            }
            
        }
      
        $RId1=true;
        if(!empty($data_building_contact))
        {
            $RId1=BuildingContactDetails::insert($data_building_contact);
        }
        $RId2=true;
        if(!empty($data_inseurance_type_details))
        {
            $RId2=ServiceProviderInsPkg::insert($data_inseurance_type_details);
        }
        $RId3=true;
        if(!empty($data_project_duration_details))
        {
            $RId3=PropertyProjectDuration::insert($data_project_duration_details);
        }
        $RId4=true;
        if(!empty($data_timeline_details))
        {
            $RId4=PropertyProjectTimeline::insert($data_timeline_details);
        }
        $RId5=true;
        if(!empty($data_amount_details))
        {
            $RId5=PropertyProjectAmount::insert($data_amount_details);
        }
        $RId6=true;
        if(!empty($data_payment_schedule_details))
        {
            $RId6=PropPrjPaymentSchedule::insert($data_payment_schedule_details);
        }

         $RId7=true;
        if(!empty($data_account_type_details))
        {
            $RId7=AccountType::insert($data_account_type_details);
        } 

       

        if($project_info && $RId1 && $RId2 && $RId3 && $RId4 && $RId5 && $RId6 && $RId7)
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
        $client_info= ClientProject::find($id)->update(['updated_by'=>$user_id,'status_active'=>0,'is_deleted'=>1]);

        $update_data= array(
                        
                            'status_active'             =>0,
                            'is_deleted'                =>1,
                            'updated_by'                =>$user_id,
                        );

       

        $RID_delete=ServiceProviderInsPkg::where('id',"=",$id)->update($update_data);
        $RID1_delete=PropertyProjectDuration::where('master_id',"=",$id)->update($update_data);
        $RID2_delete=PropertyProjectTimeline::where('master_id',"=",$id)->update($update_data);
        $RID3_delete=PropertyProjectAmount::where('master_id',"=",$id)->update($update_data);
        $RID4_delete=PropPrjPaymentSchedule::where('master_id',"=",$id)->update($update_data);
        $RID5_delete=AccountType::where('master_id',"=",$id)->where('page_id',"=",20)->update($update_data);

        if($client_info && $RID_delete  && $RID1_delete && $RID2_delete && $RID3_delete && $RID4_delete && $RID5_delete)
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
      
        $buildingInfo=ClientProject::where('id',"=",$id)->update($update_data);

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
            'project_name' => 'required',
            'subject_title' => 'required',
            'current_status' => 'required',
            'contractor_no' => 'required',
            'customer_no' => 'required',
            'project_type' => 'required',
            'location_name' => 'required',
            'final_delivery_date' => 'required',
        ]);


       $final_delivery_date                    =date("Y-m-d",strtotime($request->input('final_delivery_date')));

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
       

        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);
        $request->merge(['posting_status'   =>3]);
        $request->merge(['final_delivery_date'  =>$final_delivery_date]);


        DB::beginTransaction();
        $project_info= ClientProject::find($id)->update($request->all());
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
                        'page_id'                   =>20,
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
                        'page_id'                   =>20,
                        'chart_of_account_id'       =>$details['chart_of_account_id'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
                                   
        } 
        foreach($request->insurance_list_arr as $key=>$details)
        {
            if($details['company_name'] )
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['expire_date'])       
                    $details['expire_date']       =date("Y-m-d",strtotime($details['expire_date']));

                if($details['id']!="")
                {
                    $inseurance_type_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'item_name'                 =>$details['item_name'],
                        'company_name'              =>$details['company_name'],
                        'address'                   =>$details['address'],
                        'policy_no'                 =>$details['policy_no'],
                        'expire_date'               =>$details['expire_date'],
                        'updated_by'                =>$user_id
                    );

                    $insurancePackageUpdate=ServiceProviderInsPkg::where('id',"=",$details['id'])->update($inseurance_type_details_data);
                    if( !$insurancePackageUpdate)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_inseurance_type_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'item_name'                 =>$details['item_name'],
                        'company_name'              =>$details['company_name'],
                        'address'                   =>$details['address'],
                        'policy_no'                 =>$details['policy_no'],
                        'expire_date'               =>$details['expire_date'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );
                }              
            }
        }

        foreach($request->project_duration_arr as $key=>$details)
        {
            if($details['from_date'])
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['from_date'])       
                    $details['from_date']       =date("Y-m-d",strtotime($details['from_date']));

                if($details['to_date'])       
                    $details['to_date']         =date("Y-m-d",strtotime($details['to_date']));
                
                if($details['id']!="")
                {
                    $project_duration_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_name'                 =>$details['item_name'],
                        'net_year'                  =>$details['net_year'],
                        'net_days'                  =>$details['net_days'],
                        'from_date'                 =>$details['from_date'],
                        'to_date'                   =>$details['to_date'],
                        'updated_by'                =>$user_id
                    );

                    $projectDurationUpdate=PropertyProjectDuration::where('id',"=",$details['id'])->update($project_duration_details_data);
                    if( !$projectDurationUpdate)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_project_duration_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_name'                 =>$details['item_name'],
                        'net_year'                  =>$details['net_year'],
                        'net_days'                  =>$details['net_days'],
                        'from_date'                 =>$details['from_date'],
                        'to_date'                   =>$details['to_date'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    ); 
                }               
            }
        } 

        foreach($request->project_timeline_arr as $key=>$details)
        {
            if($details['task_details'])
            {
                
                $insert_date                            =date("Y-m-d h:i:s");
                
                if($details['from_date'])       
                    $details['from_date']               =date("Y-m-d",strtotime($details['from_date']));

                if($details['to_date'])       
                    $details['to_date']                 =date("Y-m-d",strtotime($details['to_date']));

                if($details['reschedule_to_date'])       
                    $details['reschedule_to_date']      =date("Y-m-d",strtotime($details['reschedule_to_date']));

                if($details['reschedule_from_date'])       
                    $details['reschedule_from_date']    =date("Y-m-d",strtotime($details['reschedule_from_date']));

                if($details['id']!="")
                {
                    $project_timeline_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'task_details'              =>$details['task_details'],
                        'net_hours'                 =>$details['net_hours'],
                        'net_days'                  =>$details['net_days'],
                        'to_date'                   =>$details['to_date'],
                        'from_date'                 =>$details['from_date'],
                        'reschedule_from_date'      =>$details['reschedule_from_date'],
                        'reschedule_to_date'        =>$details['reschedule_to_date'],
                        'task_status'               =>$details['task_status'],
                        'updated_by'                =>$user_id
                    );

                    $projectTimelineUpdate=PropertyProjectTimeline::where('id',"=",$details['id'])->update($project_timeline_details_data);
                    if( !$projectTimelineUpdate)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                
                    $data_timeline_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'task_details'              =>$details['task_details'],
                        'net_hours'                 =>$details['net_hours'],
                        'net_days'                  =>$details['net_days'],
                        'to_date'                   =>$details['to_date'],
                        'from_date'                 =>$details['from_date'],
                        'reschedule_from_date'      =>$details['reschedule_from_date'],
                        'reschedule_to_date'        =>$details['reschedule_to_date'],
                        'task_status'               =>$details['task_status'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );
                }

            }
        }
        //dd($request->project_amount_arr);
        foreach($request->project_cost_arr as $key=>$details)
        {
            if($details['amount_before_tax'])
            {
                $insert_date                    =date("Y-m-d h:i:s");

                if($details['id']!="")
                {
                    $project_cost_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'type'                      =>$details['type'],
                        'title'                     =>$details['title'],
                        'amount_before_tax'         =>$details['amount_before_tax'],
                        'taxes'                     =>$details['taxes'],
                        'updated_by'                =>$user_id
                    );

                    $projectTimelineUpdate=PropertyProjectAmount::where('id',"=",$details['id'])->update($project_cost_details_data);
                    if( !$projectTimelineUpdate)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_amount_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'type'                      =>$details['type'],
                        'title'                     =>$details['title'],
                        'amount_before_tax'         =>$details['amount_before_tax'],
                        'taxes'                     =>$details['taxes'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );
                }
            }
        }

        foreach($request->payment_schedule_arr as $key=>$details)
        {
            if($details['due_date']!="")
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['due_date'])       
                    $details['due_date']        =date("Y-m-d",strtotime($details['due_date']));

                if($details['id']!="")
                {
                    $project_payment_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'payment_method'            =>$details['payment_method'],
                        'amount'                    =>$details['amount'],
                        'bank_account_no'           =>$details['bank_account_no'],
                        'due_date'                  =>$details['due_date'],
                        'is_calendar'               =>$details['is_calendar'],
                        'updated_by'                =>$user_id
                    );

                    $projectPaymentScheduleUpdate=PropPrjPaymentSchedule::where('id',"=",$details['id'])->update($project_payment_details_data);
                    if( !$projectPaymentScheduleUpdate)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_payment_schedule_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'payment_method'            =>$details['payment_method'],
                        'amount'                    =>$details['amount'],
                        'bank_account_no'           =>$details['bank_account_no'],
                        'due_date'                  =>$details['due_date'],
                        'is_calendar'               =>$details['is_calendar'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );

                }
            }
        } 

        

        foreach($request->building_contact_details_arr as $item_id=>$item_details)
        {
            if($item_id>0)
            {
               foreach($item_details as $key=>$details)
                {
                    if($details['contact_no']!="")
                    {

                        if($details['id']!="")
                        {
                            $building_contact_data= array(
                                'contact_no'                =>$details['contact_no'],
                                'phone'                     =>$details['phone'],
                                'website'                   =>$details['website'],
                                'mobile'                    =>$details['mobile'],
                                'email'                     =>$details['email'],
                                'hours_of_operation'        =>$details['hours_of_operation'],
                                'comment'                   =>$details['comment'],
                                'updated_by'                =>$user_id,
                            );

                            $buildingContact=BuildingContactDetails::where('id',"=",$details['id'])->update($building_contact_data);
                            if( !$buildingContact)
                            {
                                DB::rollBack();
                                return 10;
                                die;
                            }
                        }
                        else
                        {
                             $data_building_contact[]= array(
                                'project_id'                =>$project_id,
                                'master_id'                 =>$id,
                                'item_id'                   =>$item_id,
                                'page_id'                   =>20,
                                'reference_id'              =>$details['reference_id'],
                                'item_name'                 =>$details['item_name'],
                                'contact_no'                =>$details['contact_no'],
                                'phone'                     =>$details['phone'],
                                'website'                   =>$details['website'],
                                'mobile'                    =>$details['mobile'],
                                'email'                     =>$details['email'],
                                'hours_of_operation'        =>$details['hours_of_operation'],
                                'comment'                   =>$details['comment'],
                                'inserted_by'               =>$user_id,
                            );
                        }
                       
                    }
                } 
            }
            
        }
      
        $RId1=true;
        if(!empty($data_building_contact))
        {
            $RId1=BuildingContactDetails::insert($data_building_contact);
        }
        $RId2=true;
        if(!empty($data_inseurance_type_details))
        {
            $RId2=ServiceProviderInsPkg::insert($data_inseurance_type_details);
        }
        $RId3=true;
        if(!empty($data_project_duration_details))
        {
            $RId3=PropertyProjectDuration::insert($data_project_duration_details);
        }
        $RId4=true;
        if(!empty($data_timeline_details))
        {
            $RId4=PropertyProjectTimeline::insert($data_timeline_details);
        }
        $RId5=true;
        if(!empty($data_amount_details))
        {
            $RId5=PropertyProjectAmount::insert($data_amount_details);
        }
        $RId6=true;
        if(!empty($data_payment_schedule_details))
        {
            $RId6=PropPrjPaymentSchedule::insert($data_payment_schedule_details);
        }

         $RId7=true;
        if(!empty($data_account_type_details))
        {
            $RId7=AccountType::insert($data_account_type_details);
        } 

         

        if($project_info && $RId1 && $RId2 && $RId3 && $RId4 && $RId5 && $RId6 && $RId7)
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
      
        $buildingInfo=ClientProject::where('id',"=",$id)->update($update_data);

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
