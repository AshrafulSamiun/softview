<?php

namespace App\Http\Controllers\profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\taxTypeInitial;
use App\Models\Branch;
use App\Models\Country;
use App\Models\AccountHolderCustomer;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
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
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        $payment_term_arr           =$ArrayFunction->payment_term;
        $currency_arr               =$ArrayFunction->currency;
        $branch_type_arr            =$ArrayFunction->branch_type_arr;

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

        $customer_sql                       =AccountHolderCustomer::where('status_active',1)
                                                ->where('project_id',$project_id)
                                                ->where('company_id',$company_id)
                                                ->get();

        $country=Country::where('status_active',1)->get();

        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
        }
        $data['country_arr']        =$country_arr;

        $data['coa_arr']                        =$coa_arr;
        $data['currency_arr']                   =$currency_arr;
        $data['branch_type_arr']                =$branch_type_arr;
        $data['customer_arr']                   =$customer_sql;
        $data['payment_term_arr']               =$payment_term_arr;
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

    public function BranchList(Request $request)
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
        $payment_term_arr           =$ArrayFunction->payment_term;
        $currency_arr               =$ArrayFunction->currency;
        $branch_type_arr            =$ArrayFunction->branch_type_arr;
       
        $branch_data                =Branch::where('project_id',$project_id)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->get();

        $sl=0;
        foreach ($branch_data as $key => $value) {

            $data['Branch_list'][$key]['sl']                      =$sl+1;
            $data['Branch_list'][$key]['id']                      =$value->id;
            $data['Branch_list'][$key]['system_no']               =$value->system_no;
            $data['Branch_list'][$key]['branch_name']             =$value->branch_name;
            $data['Branch_list'][$key]['branch_manager_name']     =$value->branch_manager_name;
            $data['Branch_list'][$key]['chart_of_account']        =$value->chart_of_account;
            $data['Branch_list'][$key]['currency_string']         =$currency_arr[$value->currency];
            $data['Branch_list'][$key]['branch_type_string']      =$branch_type_arr[$value->branch_type];
            $data['Branch_list'][$key]['pay_term_string']         =$payment_term_arr[$value->pay_term];
            $data['Branch_list'][$key]['customer_name']           =$value->customer->customer_name;
            
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
        request()->validate([
            'branch_name'               => 'required',
            'branch_type'               => 'required',
            'pay_term'                  => 'required',
            'sales_tax_rate'            => 'required',
            'branch_manager_name'       => 'required',
            'currency'                  => 'required',
            'opening_date'              => 'required',
            'opening_balance'           => 'required',
            'chart_of_account'          => 'required',
            'customer_details'          => 'required',
            
        ]);      

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id'      =>$user_id]);
        $request->merge(['inserted_by'  =>$user_id]);
        $request->merge(['project_id'   =>$project_id]);
        $request->merge(['company_id'   =>$company_id]);
        $request->merge(['posting_status'=>0]);      

        $opening_date                    =date("Y-m-d",strtotime($request->input('opening_date')));

        $request->merge(['opening_date'  =>$opening_date]);

        $max_system_data = Branch::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from branches where company_id=".$company_id." and  project_id=".$project_id." ) and company_id=".$company_id."  and project_id=".$project_id)->get(['system_prefix']);
                              
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="BR-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $branch_info= Branch::create($request->all());       

        if($branch_info)
        {
           DB::commit();
           return "1**$branch_info->id**$system_no";
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
        $project_id                            = $user->project_id;
        $user_type                             = $user->user_type;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }
       
        //dd($tax_type_list);die;
        $ArrayFunction              =new ArrayFunction();
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        $payment_term_arr           =$ArrayFunction->payment_term;
        $currency_arr               =$ArrayFunction->currency;
        $branch_type_arr            =$ArrayFunction->branch_type_arr;
        
        
        $country=Country::where('status_active',1)->get();
        $customer_sql                       =AccountHolderCustomer::where('status_active',1)
                                                ->where('project_id',$project_id)
                                                ->where('company_id',$company_id)
                                                ->get();

        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
        }
        $data['country_arr']        =$country_arr;

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
                $coa_arr[$sl]['sub_group_name']     =$accounts_sub_group[$value->sub_group];
                $sl++;         
            }
        }

        $branch_data                          =Branch::where('project_id',$project_id)
                                                    ->where('company_id',$company_id)
                                                    ->where('id',$id)
                                                    ->first();

        $data['customer']                       =$branch_data->customer;

        $data['branch_data_arr']                =$branch_data;
        $data['coa_arr']                        =$coa_arr;
        $data['user_type']                      =$user_type;
        $data['currency_arr']                   =$currency_arr;
        $data['branch_type_arr']                =$branch_type_arr;
        $data['customer_arr']                   =$customer_sql;
        $data['payment_term_arr']               =$payment_term_arr;
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
            'branch_name'               => 'required',
            'branch_type'               => 'required',
            'pay_term'                  => 'required',
            'sales_tax_rate'            => 'required',
            'branch_manager_name'       => 'required',
            'currency'                  => 'required',
            'opening_date'              => 'required',
            'opening_balance'           => 'required',
            'chart_of_account'          => 'required',
            'customer_details'          => 'required',
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);
      

        DB::beginTransaction();
        $branch_info= Branch::find($id)->update($request->all());

        
        if($branch_info)
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
        $branch_info= Branch::find($id)->update(['updated_by'=>$user_id,'status_active'=>0,'is_deleted'=>1]);

        if($branch_info)
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
      
        $buildingInfo=Branch::where('id',"=",$id)->update($update_data);

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
            'branch_name'               => 'required',
            'branch_type'               => 'required',
            'pay_term'                  => 'required',
            'sales_tax_rate'            => 'required',
            'branch_manager_name'       => 'required',
            'currency'                  => 'required',
            'opening_date'              => 'required',
            'opening_balance'           => 'required',
            'chart_of_account'          => 'required',
            'customer_details'          => 'required',
            
        ]);

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);
        $request->merge(['posting_status'   =>3]);


        DB::beginTransaction();
        $purchase_info= Branch::find($id)->update($request->all());
        
        if($purchase_info)
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
      
        $buildingInfo=Branch::where('id',"=",$id)->update($update_data);

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
