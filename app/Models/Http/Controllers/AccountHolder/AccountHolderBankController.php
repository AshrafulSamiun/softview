<?php

namespace App\Http\Controllers\AccountHolder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\ArrayFunction as ArrayFunction;
use App\industrySector;
use App\Country as Country;
use App\AccountHolderSuffix;
use App\AccountHolderBank;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Mail;



class AccountHolderBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        $data['user_type']          =$user_type;

        $ArrayFunction              =new ArrayFunction();     
       

        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
            $country_code_arr[$value->id]=$value->country_code;
        }

        $data['country_arr']        =$country_arr;

        return $data;
    }




    public function AccountHolderBankLists()
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $account_holder_arr         =$ArrayFunction->account_holder_arr;
       
        //===================Company==========================================
        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
        }

      
         $industry_selctor_list      =industrySector::where('status_active',1)
                                    ->whereIn('project_id',[$project_id,0])
                                    ->get();
        $industry_sector_arr=array();
        foreach ($industry_selctor_list as $key => $value) {
            $industry_sector_arr[$value->id]=$value->sector_name;
        }

        $sl=0;
        $account_holder_list=AccountHolderBank::where('is_deleted',0)
                                        ->where('project_id',$project_id)
                                        ->get();   
                                        //dd($account_holder_list);die;
        foreach ($account_holder_list as $key => $value) {


            $data['account_holder_list'][$key]['sl']                    =$sl+1;
            $data['account_holder_list'][$key]['id']                    =$value->id;
            $data['account_holder_list'][$key]['system_no']             =$value->system_no;
            $data['account_holder_list'][$key]['email']                 =$value->email;
            $data['account_holder_list'][$key]['cell_phone']            =$value->cell_phone;  
            $data['account_holder_list'][$key]['bank_acount_no']        =$value->bank_acount_no; 
            $data['account_holder_list'][$key]['bank_account_name']     =$value->bank_account_name; 
            $data['account_holder_list'][$key]['branch_name']           =$value->branch_name; 
            $data['account_holder_list'][$key]['chart_of_acocounts']    =$value->chart_of_acocounts;  
            $data['account_holder_list'][$key]['acount_status']         =$value->acount_status; 
            $data['account_holder_list'][$key]['account_type_string']   =$account_holder_arr[$value->account_type]; 
            $data['account_holder_list'][$key]['country_name']          =$country_arr[$value->country];
             
            $sl++;

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

            'account_type'                  =>"required",
            'bank_acount_no'                =>"required",
            'bank_account_name'             =>"required",
            'branch_name'                   =>"required",
            'chart_of_acocounts'            =>"required", 
            'acount_status'                 =>"required", 
            'house_number'                  =>"required",
            'street_number'                 =>"required",
            'city'                          =>"required",
            'state'                         =>"required",
            'country'                       =>"required",
            'office_phone'                  =>"required",
            'zip_code'                      =>"required",
            'email'                         =>"required",
            'fax_no'                        =>"required",
            'cell_phone'                    =>"required",
            'website'                       =>"required",
            
        ]);

        $company_id=$request->session()->get('company_id');

        // dd($company_id);
 
        if (is_null($company_id)) 
        { 
         return "100**22**21";
        }

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);
        $request->merge(['posting_status'=>0]);

        $account_fuffix_details         =AccountHolderSuffix::where('status_active',1)
                                        ->where('id',13)
                                        ->first();

        
        $account_suffix=$account_fuffix_details->suffix;
        $account_prifix=$account_fuffix_details->prifix;
        

        $max_system_data = AccountHolderBank::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from account_holder_banks 
        where project_id=".$project_id." and company_id=".$company_id." ) and company_id=".$company_id."  and project_id=".$project_id)->get(['system_prefix']);

               
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no=$account_prifix."-".str_pad($max_system_prefix, $account_suffix, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $account_holder_info= AccountHolderBank::create($request->all());

        $RId1=true;
        if($account_holder_info  )
        {
            DB::commit();
            return "1**$account_holder_info->id**$system_no";
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
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        $data['user_type']          =$user_type;
        $ArrayFunction              =new ArrayFunction();
        $account_holder_arr         =$ArrayFunction->account_holder_arr;

        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
            $country_code_arr[$value->id]=$value->country_code;
        }

        $data['country_arr']        =$country_arr;
        $data['account_holder_arr'] =$account_holder_arr;

        $account_holder_list=AccountHolderBank::where('is_deleted',0)
                                        ->where('id',$id)
                                        ->first();

        $data['account_holder']=$account_holder_list;
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
        
        $company_id=$request->session()->get('company_id');

        // dd($company_id);
 
        if (is_null($company_id)) 
        { 
         return "100**22**21";
        }
        request()->validate([

            'account_type'                  =>"required",
            'bank_acount_no'                =>"required",
            'bank_account_name'             =>"required",
            'branch_name'                   =>"required",
            'chart_of_acocounts'            =>"required", 
            'acount_status'                 =>"required", 
            'house_number'                  =>"required",
            'street_number'                 =>"required",
            'city'                          =>"required",
            'state'                         =>"required",
            'country'                       =>"required",
            'office_phone'                  =>"required",
            'zip_code'                      =>"required",
            'email'                         =>"required",
            'fax_no'                        =>"required",
            'cell_phone'                    =>"required",
            'website'                       =>"required",
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id'      =>$user_id]);
        $request->merge(['updated_by'   =>$user_id]);
        $request->merge(['project_id'   =>$project_id]);
        $request->merge(['company_id'   =>$company_id]);
        $request->merge(['posting_status'=>0]);
        $request->merge(['status_active'=>1]);
        
                
        DB::beginTransaction();
        $account_holder_info= AccountHolderBank::find($id)->update($request->all());

        if($account_holder_info)
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
        $calendar_info= AccountHolderBank::find($id)->update(['updated_by'=>$user_id,'status_active'=>0,'is_deleted'=>1]);       

        
        if($calendar_info)
        {           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }


    public function reject(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        DB::beginTransaction();
        $update_data= array(
                            'status_active'             =>3,
                            'posting_status'            =>0,
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=AccountHolderBank::where('id',"=",$id)->update($update_data);

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

    public function post(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 


        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>$request->input("posting_status"),
                            'updated_by'                =>$user_id,
                            'status_active'             =>1
                        );
      
        $buildingInfo=AccountHolderBank::where('id',"=",$id)->update($update_data);

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
    public function void(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        DB::beginTransaction();
        $update_data= array(
                            'status_active'             =>2,
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=AccountHolderBank::where('id',"=",$id)->update($update_data);

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
        

        request()->validate([

            'account_type'                  =>"required",
            'bank_acount_no'                =>"required",
            'bank_account_name'             =>"required",
            'branch_name'                   =>"required",
            'chart_of_acocounts'            =>"required", 
            'acount_status'                 =>"required", 
            'house_number'                  =>"required",
            'street_number'                 =>"required",
            'city'                          =>"required",
            'state'                         =>"required",
            'country'                       =>"required",
            'office_phone'                  =>"required",
            'zip_code'                      =>"required",
            'email'                         =>"required",
            'fax_no'                        =>"required",
            'cell_phone'                    =>"required",
            'website'                       =>"required",
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id'      =>$user_id]);
        $request->merge(['updated_by'   =>$user_id]);
        $request->merge(['project_id'   =>$project_id]);
        $request->merge(['posting_status'=>3]);
        $request->merge(['status_active'=>1]);
     
        DB::beginTransaction();
        $account_holder_info= AccountHolderBank::find($id)->update($request->all());

        if($account_holder_info)
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


    public function repost(Request $request,$id)
    {

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;       

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>4,
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=AccountHolderBank::where('id',"=",$id)->update($update_data);

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

 