<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IncomeCenter;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Support\Facades\DB;

class IncomeCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ArrayFunction              =new ArrayFunction();
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        $statement_type             = $ArrayFunction->accounts_statement_type;
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;

        $data['user_type']          =$user_type;
        $data['statement_type_arr'] =$statement_type;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
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
                $coa_arr[$sl]['sub_group_name']       =$accounts_sub_group[$value->sub_group];
                $sl++;         
            }
        }

        $data['coa_arr']        =$coa_arr;         

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

    public function IncomeCenterList(Request $request)
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
        $user_type                  = $user->user_type;
        $statement_type             = $ArrayFunction->accounts_statement_type;
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        $row_status                 =$ArrayFunction->row_status;

        $data['user_type']          =$user_type;
        $data['statement_type_arr'] =$statement_type;

       
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
                $coa_arr[$sl]['sub_group_name']       =$accounts_sub_group[$value->sub_group];
                $sl++;         
            }
        }

        $data['coa_arr']        =$coa_arr;
       
        $IncomeCenter_data=IncomeCenter::where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->get();


        $sl=0;
        
        foreach ($IncomeCenter_data as $key => $value) {

            $data['income_center_list'][$key]['sl']                     =$sl+1;
            $data['income_center_list'][$key]['id']                     =$value->id;
            $data['income_center_list'][$key]['system_no']              =$value->system_no;
            $data['income_center_list'][$key]['income_center_name']     =$value->income_center_name;
            $data['income_center_list'][$key]['account_no']             =$value->account_no;
            $data['income_center_list'][$key]['account_id']             =$value->account_id;
            $data['income_center_list'][$key]['financial_statement']    =$value->financial_statement;
            $data['income_center_list'][$key]['posting_status']         =$value->posting_status;
            $data['income_center_list'][$key]['statement_type_string']  =$statement_type[$value->financial_statement];
            $data['income_center_list'][$key]['status_string']          =$row_status[$value->status_active];
            $data['income_center_list'][$key]['status_active']          =$value->status_active;

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
            'income_center_name'      => 'required',
            'account_no'            => 'required',
            'financial_statement'   => 'required',
            'status_active'         => 'required',
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['inserted_by'    =>$user_id]);
        $request->merge(['project_id'     =>$project_id]);
        $request->merge(['company_id'     =>$company_id]);
        $request->merge(['posting_status' =>0]); 

        $max_system_data = IncomeCenter::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from income_centers where company_id=".$company_id." and project_id=".$project_id." ) and company_id=".$company_id." and project_id=".$project_id)->get(['system_prefix']);
                              
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="IC-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);     

        DB::beginTransaction();
        $IncomeCenter_info= IncomeCenter::create($request->all());

        if($IncomeCenter_info)
        {
           DB::commit();
           return "1**$IncomeCenter_info->id";
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
    public function edit($id,Request $request)
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
        $user_type                  = $user->user_type;
        $statement_type             = $ArrayFunction->accounts_statement_type;
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        $row_status                 =$ArrayFunction->row_status;

        $data['user_type']          =$user_type;
        $data['statement_type_arr'] =$statement_type;

        
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
                $coa_arr[$sl]['sub_group_name']       =$accounts_sub_group[$value->sub_group];
                $sl++;         
            }
        }

        $data['coa_arr']        =$coa_arr;
       
        $IncomeCenter_data=IncomeCenter::where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('id',$id)
                                        ->get();


        $sl=0;
        
        foreach ($IncomeCenter_data as $key => $value) {

            $data['income_center_list']['id']                     =$value->id;
            $data['income_center_list']['system_no']              =$value->system_no;
            $data['income_center_list']['income_center_name']     =$value->income_center_name;
            $data['income_center_list']['account_no']             =$value->account_no;
            $data['income_center_list']['account_id']             =$value->account_id;
            $data['income_center_list']['financial_statement']    =$value->financial_statement;
            $data['income_center_list']['posting_status']         =$value->posting_status;
           
            $data['income_center_list']['statement_type_string']  =$statement_type[$value->financial_statement];
            $data['income_center_list']['status_string']          =$row_status[$value->status_active];
            $data['income_center_list']['status_active']          =$value->status_active;
            $sl++;
        }

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


        DB::beginTransaction();
        $cost_center_info= IncomeCenter::find($id)->update($request->all());  
            

        if($cost_center_info)
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
      
        $IncomeCenterInfo=IncomeCenter::where('id',"=",$id)->update($update_data);

        if($IncomeCenterInfo)
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
        $cost_center_info= IncomeCenter::find($id)->update($request->all());


        if($cost_center_info)
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
      
        $buildingInfo=IncomeCenter::where('id',"=",$id)->update($update_data);

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
        $project_id=$user_data->project_id; 

        

        $update_data= array(
                        
                            'status_active'             =>0,
                            'is_deleted'                =>1,
                            'updated_by'                =>$user_id,
                        );

        $RID_delete=IncomeCenter::where('id',"=",$id)->update($update_data);
      


        if($RID_delete)
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
