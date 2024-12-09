<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccountType as AccountType;
use App\Models\taxTypeInitial;
use App\Models\Software;
use App\Models\Country;
use App\Models\AccountHolderSeller;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Support\Facades\DB;

class SoftwareController extends Controller
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
        $item_category              =$ArrayFunction->item_category;
        $unit_of_measurement        =$ArrayFunction->unit_of_measurement;
        $account_type_arr=array();
        $account_type_list          =taxTypeInitial::where('status_active',1)
                                        ->where('type',8)
                                        ->whereIn('project_id',[$project_id,0])
                                        ->get();
        $account_type_arr=array();
        foreach ($account_type_list as $key => $value) {

            $account_type_arr[$value->id]['name']                      =$value->field_name;
            $account_type_arr[$value->id]['chart_of_account']       ="";
            $account_type_arr[$value->id]['chart_of_account_id']    ="";
            $account_type_arr[$value->id]['id']                     ="";
           

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

        $seller_sql                             =AccountHolderSeller::where('status_active',1)
                                                    ->where('project_id',$project_id)
                                                    ->where('company_id',$company_id)
                                                    ->get();
        $country=Country::where('status_active',1)->get();

        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
        }
        $data['country_arr']        =$country_arr;

        $data['coa_arr']                        =$coa_arr;
        $data['account_type_arr']               =$account_type_arr;
        $data['seller_arr']                     =$seller_sql;
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

    public function SoftwareList(Request $request)
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
        $item_category              =$ArrayFunction->item_category;
        $unit_of_measurement        =$ArrayFunction->unit_of_measurement;
       
        $software_data=Software::where('project_id',$project_id)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('status_active',1)
                                        ->get();

        $sl=0;
        foreach ($software_data as $key => $value) {

            $data['software_list'][$key]['sl']                      =$sl+1;
            $data['software_list'][$key]['id']                      =$value->id;
            $data['software_list'][$key]['system_no']               =$value->system_no;
            $data['software_list'][$key]['software_name']           =$value->software_name;
            $data['software_list'][$key]['software_version']        =$value->software_version;
            $data['software_list'][$key]['purpose']                 =$value->purpose;
            $data['software_list'][$key]['seller_id']               =$value->seller_id;
            $data['software_list'][$key]['saller_name']             =$value->seller->seller_name;
            
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
            'software_name'             => 'required',
            'software_version'          => 'required',
            'purpose'                   => 'required',
            'seller_no'                 => 'required',
            
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

        
        $produced_date                    =date("Y-m-d",strtotime($request->input('produced_date')));

        $expire_date                    =date("Y-m-d",strtotime($request->input('expire_date')));

        $request->merge(['produced_date'  =>$produced_date]);
        $request->merge(['expire_date'  =>$expire_date]);
        $max_system_data = Software::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from software where company_id=".$company_id." and  project_id=".$project_id." ) and company_id=".$company_id."  and project_id=".$project_id)->get(['system_prefix']);
                              
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="SOFT-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $softwate_info= Software::create($request->all());

        foreach($request->account_type_arr as $key=>$details)
        {
                      
            if($details['chart_of_account']!="")
            {
                $data_account_type_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$softwate_info->id,
                    'account_type'              =>$key,
                    'chart_of_account'          =>$details['chart_of_account'],
                    'page_id'                   =>8,
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

        if($softwate_info)
        {
           DB::commit();
           return "1**$softwate_info->id**$system_no";
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
        $item_category              =$ArrayFunction->item_category;
        $unit_of_measurement        =$ArrayFunction->unit_of_measurement;
        $account_type_arr=array();

        $account_type_list          =taxTypeInitial::where('status_active',1)
                                        ->where('type',8)
                                        ->whereIn('project_id',[$project_id,0])
                                        ->get();
        foreach ($account_type_list as $key => $value) {

            $account_type_arr[$value->id]['name']                   =$value->field_name;
            $account_type_arr[$value->id]['chart_of_account']       ="";
            $account_type_arr[$value->id]['chart_of_account_id']    ="";
            $account_type_arr[$value->id]['id']                     ="";
           

        }

        $account_type_sql           =AccountType::where('status_active',1)
                                    ->where('page_id',8)
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

        $software_data                          =Software::where('status_active',1)
                                                    ->where('project_id',$project_id)
                                                    ->where('company_id',$company_id)
                                                    ->where('id',$id)
                                                    ->first();
        $data['seller']                       =$software_data->seller;

        $data['software_data_arr']              =$software_data;
        $data['account_type_arr']               =$account_type_arr;
        $data['coa_arr']                        =$coa_arr;
        $data['user_type']                      =$user_type;
        $data['unit_of_measurement']            =$unit_of_measurement;
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
            'software_name'             => 'required',
            'software_version'          => 'required',
            'purpose'                   => 'required',
            'seller_no'                 => 'required',
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);
      

        DB::beginTransaction();
        $softwate_info= Software::find($id)->update($request->all());

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
                        'page_id'                   =>8,
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
                        'page_id'                   =>8,
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

        if($softwate_info && $RId1)
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
        $softwate_info= Software::find($id)->update(['updated_by'=>$user_id,'status_active'=>0,'is_deleted'=>1]);

        $update_data= array(
                        
                            'status_active'             =>0,
                            'is_deleted'                =>1,
                            'updated_by'                =>$user_id,
                        );
        $RID1_delete=AccountType::where('master_id',"=",$id)->where('page_id',"=",5)->update($update_data);

        if($softwate_info && $RID1_delete)
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
      
        $buildingInfo=Software::where('id',"=",$id)->update($update_data);

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
            'software_name'             => 'required',
            'software_version'          => 'required',
            'purpose'                   => 'required',
            'seller_no'                 => 'required',
            
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
        $purchase_info= Software::find($id)->update($request->all());
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
                        'page_id'                   =>8,
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
                        'page_id'                   =>8,
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
        if($purchase_info  && $RId1)
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
      
        $buildingInfo=Software::where('id',"=",$id)->update($update_data);

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
