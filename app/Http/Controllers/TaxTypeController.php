<?php

namespace App\Http\Controllers;


use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\AccountType as AccountType;
use App\Models\TaxType as TaxType;
use App\Models\TaxTypeInitial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TaxTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=\Auth::user();
        $project_id                             = $user->project_id;
        //===================Company==========================================
        $tax_type_list                          =TaxTypeInitial::where('status_active',1)
                                                    ->whereIn('project_id',[$project_id,0])
                                                    ->get();
        $ArrayFunction              =new ArrayFunction();
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        $tax_type_arr=array();
        $account_type_arr=array();
        foreach ($tax_type_list as $key => $value) {
            if($value->type==1)
                $tax_type_arr[$value->id]       =$value->field_name;
            if($value->type==2)
            {
                $account_type_arr[$value->id]['name']                   =$value->field_name;
                $account_type_arr[$value->id]['chart_of_account']       ="";
                $account_type_arr[$value->id]['chart_of_account_id']    ="";
                $account_type_arr[$value->id]['id']                     ="";
            }
        }


        $chart_of_account_list          =DB::table('chart_of_accounts as coa')
                                        ->join('coa_groups as group','coa.coa_group','=','group.reference_id')
                                        ->where('coa.project_id', '=', $project_id)
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
                $coa_arr[$sl]['sub_group_name']     =$accounts_sub_group[$value->sub_group];
                
                $sl++;         
            }
        }

        $data['coa_arr']                        =$coa_arr;
        $data['tax_type_arr']                   =$tax_type_arr;
        $data['account_type_arr']               =$account_type_arr;

        $ArrayFunction                          =new ArrayFunction();
        $data['reporting_period_arr']           =$ArrayFunction->reporting_period_arr;

        return $data;
    }

    public function TaxTypesList()
    {

        $user=\Auth::user();
        $project_id                             = $user->project_id;
        //===================Company==========================================
        $tax_type_list                          =TaxTypeInitial::where('status_active',1)
                                                    ->whereIn('project_id',[$project_id,0])
                                                    ->get();
        $tax_type_arr=array();
        $account_type_arr=array();
        foreach ($tax_type_list as $key => $value) {
            if($value->type==1)
                $tax_type_arr[$value->id]       =$value->field_name;
            if($value->type==2)
            {
                $account_type_arr[$value->id]['name']                   =$value->field_name;
                $account_type_arr[$value->id]['chart_of_account']       ="";
                $account_type_arr[$value->id]['chart_of_account_id']    ="";
                $account_type_arr[$value->id]['id']                     ="";
            }
                
        }
        //dd($tax_type_arr);
        $data['tax_type_arr']                   =$tax_type_arr;
        $data['account_type_arr']               =$account_type_arr;

        $ArrayFunction                          =new ArrayFunction();
        $reporting_period_arr                   =$ArrayFunction->reporting_period_arr;

       
       $tax_type_data=TaxType::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->get();

        $sl=0;
        
        foreach ($tax_type_data as $key => $value) {

            $data['tax_type_list'][$key]['sl']                  =$sl+1;
            $data['tax_type_list'][$key]['id']                  =$value->id;
            $data['tax_type_list'][$key]['system_no']           =$value->system_no;
            $data['tax_type_list'][$key]['tin_no']              =$value->tin_no;
            $data['tax_type_list'][$key]['tax_type']            =$tax_type_arr[$value->tax_type];
            $data['tax_type_list'][$key]['tax_office_name']     =$value->tax_office_name;
            $data['tax_type_list'][$key]['tax_office_address']  =$value->tax_office_address;
            $data['tax_type_list'][$key]['tax_office_contact']  =$value->tax_office_contact;
            $data['tax_type_list'][$key]['tax_rate']            =$value->tax_rate;
            $data['tax_type_list'][$key]['period_name']         =$reporting_period_arr[$value->period_name];
            $data['tax_type_list'][$key]['period_start_date']   =$value->period_start_date;
            $data['tax_type_list'][$key]['period_end_date']     =$value->period_end_date;
            $data['tax_type_list'][$key]['period_due_on']       =$value->period_due_on;

            
            $sl++;

        }

        $data['tax_type_arr']                   =$tax_type_arr;
        $data['account_type_arr']               =$account_type_arr;

        $data['reporting_period_arr']           =$reporting_period_arr;
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
            'tin_no'                => 'required',
            'tax_type'              => 'required',
            'tax_office_name'       => 'required',
            'tax_office_address'    => 'required',
            'tax_office_contact'    => 'required',
            'tax_rate'              => 'required',
            'period_name'           => 'required',
            'period_start_date'     => 'required',
            'period_end_date'       => 'required',
            'period_due_on'         => 'required',
            'period_add_calendar'   => 'required',
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        if($request->input('period_start_date'))
        {
            $period_start_date                               =date("Y-m-d",strtotime($request->input('period_start_date')));
            $request->merge(['period_start_date'             =>$period_start_date]);
        }

        if($request->input('period_end_date'))
        {
            $period_end_date                               =date("Y-m-d",strtotime($request->input('period_end_date')));
            $request->merge(['period_end_date'             =>$period_end_date]);
        }

        if($request->input('period_due_on'))
        {
            $period_due_on                               =date("Y-m-d",strtotime($request->input('period_due_on')));
            $request->merge(['period_due_on'             =>$period_due_on]);
        }

        $max_system_data = TaxType::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from account_types where  project_id=".$project_id." ) and project_id=".$project_id)->get(['system_prefix']);
                              
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="TC-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $tax_type_info= TaxType::create($request->all());


        foreach($request->account_type_arr as $key=>$details)
        {
                      
            if($details['chart_of_account']!="")
            {
                $data_account_type_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$tax_type_info->id,
                    'account_type'              =>$key,
                    'chart_of_account'          =>$details['chart_of_account'],
                    'page_id'                   =>1,
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

        if($tax_type_info  && $RId1 )
        {
           DB::commit();
           return "1**$tax_type_info->id**$system_no";
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
        $user=\Auth::user();
        $project_id                             = $user->project_id;
        //===================Company==========================================
        $tax_type_list                          =TaxTypeInitial::where('status_active',1)
                                                    ->whereIn('project_id',[$project_id,0])
                                                    ->get();
        $tax_type_arr=array();
        $account_type_arr=array();
        foreach ($tax_type_list as $key => $value) {
            if($value->type==1)
                $tax_type_arr[$value->id]       =$value->field_name;
            if($value->type==2)
            {
                $account_type_arr[$value->id]['name']                   =$value->field_name;
                $account_type_arr[$value->id]['chart_of_account']       ="";
                $account_type_arr[$value->id]['chart_of_account_id']    ="";
                $account_type_arr[$value->id]['id']                     ="";
            }
                
        }

       

        $ArrayFunction                          =new ArrayFunction();
        $data['reporting_period_arr']           =$ArrayFunction->reporting_period_arr;

        $tax_data=TaxType::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$id)
                                    ->first();

        $account_type_list=AccountType::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('master_id',$id)
                                        ->where('page_id',1)
                                        ->get();
        foreach($account_type_list as $index=>$value)
        {
            $account_type_arr[$value->account_type]['chart_of_account']     =$value->chart_of_account;
            $account_type_arr[$value->account_type]['chart_of_account_id']  =$value->chart_of_account_id;
            $account_type_arr[$value->account_type]['id']                   =$value->id;
        }

        $data['tax_type_arr']                   =$tax_type_arr;
        $data['account_type_arr']               =$account_type_arr;

        $data['tax_data_arr']=$tax_data; 
       // $data['tax_type_data_arr']=$tax_type_list;
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
        request()->validate([
            'tin_no'                => 'required',
            'tax_type'              => 'required',
            'tax_office_name'       => 'required',
            'tax_office_address'    => 'required',
            'tax_office_contact'    => 'required',
            'tax_rate'              => 'required',
            'period_name'           => 'required',
            'period_start_date'     => 'required',
            'period_end_date'       => 'required',
            'period_due_on'         => 'required',
            //'period_add_calendar'   => 'required',
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        if($request->input('period_start_date'))
        {
            $period_start_date                               =date("Y-m-d",strtotime($request->input('period_start_date')));
            $request->merge(['period_start_date'             =>$period_start_date]);
        }

        if($request->input('period_end_date'))
        {
            $period_end_date                               =date("Y-m-d",strtotime($request->input('period_end_date')));
            $request->merge(['period_end_date'             =>$period_end_date]);
        }

        if($request->input('period_due_on'))
        {
            $period_due_on                               =date("Y-m-d",strtotime($request->input('period_due_on')));
            $request->merge(['period_due_on'             =>$period_due_on]);
        }

        DB::beginTransaction();
        $tax_type_info= TaxType::find($id)->update($request->all());

        $data_subrooms_list_details="";
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
                        'page_id'                   =>1,
                        'chart_of_account_id'       =>$details['chart_of_account_id'],
                        'updated_by'                =>$user_id,
                    );

                    $accountTypeData=AccountType::where('id',"=",$details['id'])->update($account_type_details_data);
                    if( !$accountTypeData)
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
                        'page_id'                   =>1,
                        'chart_of_account_id'       =>$details['chart_of_account_id'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
        }


        $RId1=true;
        $RId2=true;
        if(!empty($data_account_type_details))
        {
            $RId1=AccountType::insert($data_account_type_details);
        }
        if($tax_type_info  && $RId1)
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
