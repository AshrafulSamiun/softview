<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClientProject;
use App\Models\CostCenter;
use App\Models\payrollItemInitial;
use App\Models\PayrollItemDetails;
use App\Models\PayrollItem;
use Illuminate\Support\Facades\DB;
use App\Classes\ArrayFunction as ArrayFunction;


class PayrollItemController extends Controller
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
        $ArrayFunction              =new ArrayFunction();
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        $account_type_list          =payrollItemInitial::where('status_active',1)
                                        ->whereIn('project_id',[$project_id,0])
                                        ->whereIn('company_id',[$company_id,0])
                                        //->where('id',21)
                                        ->get();

        $root_level_item=count($account_type_list);
        $account_type_arr=array(); $sl=0;
        foreach ($account_type_list as $key => $value) {
            $sl++;
            $account_type_arr[$value->root_level][$value->id]['item_name']              =$value->item_name;
            $account_type_arr[$value->root_level][$value->id]['chart_of_account']       ="";
            $account_type_arr[$value->root_level][$value->id]['chart_of_account_id']    ="";
            $account_type_arr[$value->root_level][$value->id]['custom_name']            ="";
            $account_type_arr[$value->root_level][$value->id]['cost_center_id']         ="";
            $account_type_arr[$value->root_level][$value->id]['client_project_id']      ="";
            $account_type_arr[$value->root_level][$value->id]['is_expand']              =$value->is_expand;
            $account_type_arr[$value->root_level][$value->id]['id']                     ="";
            $account_type_arr[$value->root_level][$value->id]['sl']                     =$sl;
            $account_type_arr[$value->root_level][$value->id]['item_id']                =$value->id;

            if($value->root_level==0 && $value->is_expand==1)
            {
                $root_level_item++;
                
                $account_type_arr[$value->id][$root_level_item]['item_name']              ="";
                $account_type_arr[$value->id][$root_level_item]['chart_of_account']       ="";
                $account_type_arr[$value->id][$root_level_item]['chart_of_account_id']    ="";
                $account_type_arr[$value->id][$root_level_item]['custom_name']            ="";
                $account_type_arr[$value->id][$root_level_item]['cost_center_id']         ="";
                $account_type_arr[$value->id][$root_level_item]['client_project_id']      ="";
                $account_type_arr[$value->id][$root_level_item]['is_expand']              =0;
                $account_type_arr[$value->id][$root_level_item]['id']                     ="";
                $account_type_arr[$value->id][$root_level_item]['sl']                     ="";
                $account_type_arr[$value->id][$root_level_item]['item_id']                ="";

            }

        }
        $account_type_update        =PayrollItemDetails::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->get();
        foreach ($account_type_update as $key => $value) {
            $sl++;
            $account_type_arr[$value->root_level][$value->item_id]['item_name']              =$value->item_name;
            $account_type_arr[$value->root_level][$value->item_id]['chart_of_account']       =$value->chart_of_account;
            $account_type_arr[$value->root_level][$value->item_id]['chart_of_account_id']    =$value->chart_of_account_id;
            $account_type_arr[$value->root_level][$value->item_id]['custom_name']            =$value->custom_name;
            $account_type_arr[$value->root_level][$value->item_id]['cost_center_id']         =$value->cost_center_id;
            $account_type_arr[$value->root_level][$value->item_id]['client_project_id']      =$value->client_project_id;
            $account_type_arr[$value->root_level][$value->item_id]['is_expand']              =$value->is_expand;
            $account_type_arr[$value->root_level][$value->item_id]['id']                     =$value->id;
           // $account_type_arr[$value->root_level][$value->id]['sl']                     =$sl;
            $account_type_arr[$value->root_level][$value->item_id]['item_id']                =$value->item_id;            

        }

//dd($account_type_arr);
        $account_type_update        =PayrollItem::where('status_active',1)
                                        ->whereIn('project_id',[$project_id,0])
                                        ->whereIn('company_id',[$company_id,0])
                                        ->first();
        if(!empty($account_type_update))
        {
            $data['master_id']=$account_type_update->id;
            $data['posting_status']=$account_type_update->posting_status;
        }
        else {

            $data['master_id']="";
            $data['posting_status']=0;   
        }

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

        $cost_center_sql            =CostCenter::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->get();

        $client_project_list        =ClientProject::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->get();

        $data['total_payroll_item']     =$root_level_item;                                
        $data['project_arr']            =$client_project_list;
        $data['cost_center_arr']        =$cost_center_sql;
        //$data['account_type_arr']       =$account_type_list;  
        $data['account_type_arr']       =$account_type_arr;    
        $data['coa_arr']                =$coa_arr;
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
        

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['inserted_by'      =>$user_id]);
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['company_id'       =>$company_id]); 
        $request->merge(['posting_status'   =>0]);      

        DB::beginTransaction();
        $payroll_info= PayrollItem::create($request->all());


        foreach($request->account_type_arr as $root_level=>$root_details)
        {   

            foreach($root_details as $key=>$details)
            {
                          
                if($details['custom_name']!="")
                {

                    if($details['item_id']=="")
                    {

                                $payrollInitail = new payrollItemInitial();
     
                                $payrollInitail->project_id = $project_id;
                                $payrollInitail->company_id = $company_id;
                                $payrollInitail->is_expand = 0;
                                $payrollInitail->root_level = $root_level;
                                $payrollInitail->item_name = $details['item_name'];
                                $payrollInitail->inserted_by = $user_id;
                         
                                $payrollInitail->save();
                                $payroll_item_id=$payrollInitail->id;

                    }
                    else  $payroll_item_id=$details['item_id'];


                    $data_account_type_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$payroll_info->id,
                        'company_id'                =>$company_id,
                        'root_level'                =>$root_level,
                        'item_name'                 =>$details['item_name'],
                        'custom_name'               =>$details['custom_name'],
                        'item_id'                   =>$payroll_item_id,
                        //'custom_name'               =>$details['custom_name'],
                        'chart_of_account'          =>$details['chart_of_account'],
                        'chart_of_account_id'       =>$details['chart_of_account_id'],
                        'cost_center_id'            =>$details['cost_center_id'],
                        'client_project_id'         =>$details['client_project_id'],
                        'is_expand'                 =>$details['is_expand'],                
                        'inserted_by'               =>$user_id,
                    );
                }
                       
            }
        }

        
        $RId1=true;

       
        if(!empty($data_account_type_details))
        {
            $RId1=PayrollItemDetails::insert($data_account_type_details);
        }

        if($payroll_info  && $RId1 )
        {
           DB::commit();
           return "1**$payroll_info->id";
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

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['updated_by '          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);
        $request->merge(['company_id'           =>$company_id]);
        $request->merge(['posting_status'       =>0]);

        DB::beginTransaction();
        $project_info= PayrollItem::find($id)->update($request->all());


        foreach($request->account_type_arr as $root_level=>$root_details)
        {   

            foreach($root_details as $key=>$details)
            {
                          
                if($details['custom_name']!="")
                {

                    if($details['id']!="")
                    {
                        $account_type_details_data= array(
                            'project_id'                =>$project_id,
                            'master_id'                 =>$id,
                            'company_id'                =>$company_id,
                            'root_level'                =>$root_level,
                            'item_name'                 =>$details['item_name'],
                            'custom_name'               =>$details['custom_name'],
                            'item_id'                   =>$details['item_id'],
                            //'custom_name'               =>$details['custom_name'],
                            'chart_of_account'          =>$details['chart_of_account'],
                            'chart_of_account_id'       =>$details['chart_of_account_id'],
                            'cost_center_id'            =>$details['cost_center_id'],
                            'client_project_id'         =>$details['client_project_id'],
                            'is_expand'                 =>$details['is_expand'],  
                            'updated_by'                =>$user_id
                        );

                        $AccountPaybleUpdate=PayrollItemDetails::where('id',"=",$details['id'])->update($account_type_details_data);
                        if( !$AccountPaybleUpdate)
                        {
                            DB::rollBack();
                            return 10;
                            die;
                        }
                    }
                    else
                    {

                        if($details['item_id']=="")
                        {

                                    $payrollInitail = new payrollItemInitial();
         
                                    $payrollInitail->project_id = $project_id;
                                    $payrollInitail->company_id = $company_id;
                                    $payrollInitail->is_expand = 0;
                                    $payrollInitail->root_level = $root_level;
                                    $payrollInitail->item_name = $details['item_name'];
                                    $payrollInitail->inserted_by = $user_id;
                             
                                    $payrollInitail->save();
                                    $payroll_item_id=$payrollInitail->id;

                        }
                        else  $payroll_item_id=$details['item_id'];


                        $data_account_type_details[]= array(
                            'project_id'                =>$project_id,
                            'master_id'                 =>$id,
                            'company_id'                =>$company_id,
                            'root_level'                =>$root_level,
                            'item_name'                 =>$details['item_name'],
                            'custom_name'               =>$details['custom_name'],
                            'item_id'                   =>$payroll_item_id,
                            //'custom_name'               =>$details['custom_name'],
                            'chart_of_account'          =>$details['chart_of_account'],
                            'chart_of_account_id'       =>$details['chart_of_account_id'],
                            'cost_center_id'            =>$details['cost_center_id'],
                            'client_project_id'         =>$details['client_project_id'],
                            'is_expand'                 =>$details['is_expand'],                
                            'inserted_by'               =>$user_id,
                        );
                    }   
                }
                       
            }
        }


        $RId1=true;

       
        if(!empty($data_account_type_details))
        {
            $RId1=PayrollItemDetails::insert($data_account_type_details);
        }

        if($project_info  && $RId1 )
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
      
        $buildingInfo=PayrollItem::where('id',"=",$id)->update($update_data);

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
        $payroll_info= PayrollItem::find($id)->update($request->all());


         foreach($request->account_type_arr as $root_level=>$root_details)
        {   

            foreach($root_details as $key=>$details)
            {
                          
                if($details['custom_name']!="")
                {

                    if($details['id']!="")
                    {
                        $account_type_details_data= array(
                            'project_id'                =>$project_id,
                            'master_id'                 =>$id,
                            'company_id'                =>$company_id,
                            'root_level'                =>$root_level,
                            'item_name'                 =>$details['item_name'],
                            'custom_name'               =>$details['custom_name'],
                            'item_id'                   =>$details['item_id'],
                            //'custom_name'               =>$details['custom_name'],
                            'chart_of_account'          =>$details['chart_of_account'],
                            'chart_of_account_id'       =>$details['chart_of_account_id'],
                            'cost_center_id'            =>$details['cost_center_id'],
                            'client_project_id'         =>$details['client_project_id'],
                            'is_expand'                 =>$details['is_expand'],  
                            'updated_by'                =>$user_id
                        );

                        $AccountPaybleUpdate=PayrollItemDetails::where('id',"=",$details['id'])->update($account_type_details_data);
                        if( !$AccountPaybleUpdate)
                        {
                            DB::rollBack();
                            return 10;
                            die;
                        }
                    }
                    else
                    {

                        if($details['item_id']=="")
                        {

                                    $payrollInitail = new payrollItemInitial();
         
                                    $payrollInitail->project_id = $project_id;
                                    $payrollInitail->company_id = $company_id;
                                    $payrollInitail->is_expand = 0;
                                    $payrollInitail->root_level = $root_level;
                                    $payrollInitail->item_name = $details['item_name'];
                                    $payrollInitail->inserted_by = $user_id;
                             
                                    $payrollInitail->save();
                                    $payroll_item_id=$payrollInitail->id;

                        }
                        else  $payroll_item_id=$details['item_id'];


                        $data_account_type_details[]= array(
                            'project_id'                =>$project_id,
                            'master_id'                 =>$id,
                            'company_id'                =>$company_id,
                            'root_level'                =>$root_level,
                            'item_name'                 =>$details['item_name'],
                            'custom_name'               =>$details['custom_name'],
                            'item_id'                   =>$payroll_item_id,
                            //'custom_name'               =>$details['custom_name'],
                            'chart_of_account'          =>$details['chart_of_account'],
                            'chart_of_account_id'       =>$details['chart_of_account_id'],
                            'cost_center_id'            =>$details['cost_center_id'],
                            'client_project_id'         =>$details['client_project_id'],
                            'is_expand'                 =>$details['is_expand'],                
                            'inserted_by'               =>$user_id,
                        );
                    }   
                }
                       
            }
        }


        $RId1=true;

       
        if(!empty($data_account_type_details))
        {
            $RId1=PayrollItemDetails::insert($data_account_type_details);
        }

        

        if($payroll_info  && $RId1)
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
      
        $buildingInfo=PayrollItem::where('id',"=",$id)->update($update_data);

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

        $RID_delete=true;
        $RID1_delete=true;
        $RID2_delete=true;
        $RID3_delete=true;
        $RID4_delete=true;
        $RID5_delete=true;

        $update_data= array(
                        
                            'status_active'             =>0,
                            'is_deleted'                =>1,
                            'updated_by'                =>$user_id,
                        );

        $RID_delete=PayrollItem::where('id',"=",$id)->update($update_data);
        $RID1_delete=PayrollItemDetails::where('master_id',"=",$id)->update($update_data);

        if($RID_delete  && $RID1_delete )
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
