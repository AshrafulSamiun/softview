<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\AccountHolder;
use App\Models\AccountHolderSuffix;
use App\Models\Country as Country;
use App\Models\industrySector;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;


class AccountHolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $company_id=$request->session()->get('company_id');
        $user=\Auth::user();
        $project_id                 = $user->project_id;

        $ArrayFunction              =new ArrayFunction();
        $account_holder_arr         =$ArrayFunction->account_holder_arr;
        $payment_name         =$ArrayFunction->payment_name; 
        $payment_class         =$ArrayFunction->payment_class;
        $industry_selctor_list      =industrySector::where('status_active',1)
                                    ->whereIn('project_id',[$project_id,0])
                                    ->get();
        $industry_sector_arr=array();
        foreach ($industry_selctor_list as $key => $value) {
            $industry_sector_arr[$value->id]=$value->sector_name;
        }

        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
            $country_code_arr[$value->id]=$value->country_code;
        }

        $data['country_arr']        =$country_arr;
        $data['account_holder_arr'] =$account_holder_arr;
        $data['payment_name'] =$payment_name; 
        $data['payment_class'] =$payment_class;

        $data['industry_sector_arr']        =$industry_sector_arr;
        return $data;
    }




    public function AccountHolderLists()
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
        $account_holder_list=AccountHolder::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->get();
                                        //dd($account_holder_list);die;
        foreach ($account_holder_list as $key => $value) {

            $data['account_holder_list'][$key]['sl']                    =$sl+1;
            $data['account_holder_list'][$key]['id']                    =$value->id;
            $data['account_holder_list'][$key]['system_no']             =$value->system_no;
            $data['account_holder_list'][$key]['account_type_string']   =$account_holder_arr[$value->account_type];
           
           // $data['account_holder_list'][$key]['entity_type']           =$value->entity_type;
            $data['account_holder_list'][$key]['full_name']             =$value->first_name." ".$value->middle_name." ".$value->last_name;
            $data['account_holder_list'][$key]['email']                 =$value->email;
            $data['account_holder_list'][$key]['cell_phone']            =$value->cell_phone;
            
            $data['account_holder_list'][$key]['country_name']          =$country_arr[$value->country];
            $data['account_holder_list'][$key]['industry_sector']       =$industry_sector_arr[$value->industry_sector];


            if($value->entity_type==1)
            {
                $data['account_holder_list'][$key]['entity_type']           ="Individual";

            }
            else if($value->entity_type==2)
            {
                $data['account_holder_list'][$key]['entity_type']           ="Domestic Corporation";

            }
            else if($value->entity_type==3)
            {
                $data['account_holder_list'][$key]['entity_type']           ="Foreign Corporation";
            }

            $sl++;

        }

       // $data['account_holder_list']        =$account_holder_list;
        
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

        $company_id=$request->session()->get('company_id');
 

       if (is_null($company_id)) 
       { 
        return "10**22**21";
       }
        request()->validate([

            'account_type'                  =>"required",
            'first_name'                    =>"required",
            'middle_name'                   =>"required",
            'last_name'                     =>"required",
            'industry_sector'               =>"required",
            //'industry_sector_text'          =>"required",
            'reg_cor_dir_info'              =>"required",
            'register_corp_first_name'      =>"required",
            'register_corp_middle_name'     =>"required",
            'register_corp_last_name'       =>"required",
            'register_corp_phone_no'        =>"required",
            'register_corp_email'           =>"required",
            'register_emergency_contact'    =>"required",
            'house_number'                  =>"required",
            'street_number'                 =>"required",
            'city'                          =>"required",
            'state'                         =>"required",
            'country'                       =>"required",
            'zip_code'                      =>"required",
            'email'                         =>"required",
            'fax_no'                        =>"required",
            'cell_phone'                    =>"required",
            'website'                       =>"required",
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $account_type=$request->input('account_type');

        $account_fuffix_details         =AccountHolderSuffix::where('status_active',1)
                                        ->where('id',$account_type)
                                        ->first();

        
        $account_suffix=$account_fuffix_details->suffix;
        $account_prifix=$account_fuffix_details->prifix;
        

        $max_system_data = AccountHolder::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from account_holders 
            where account_type=".$account_type."  and project_id=".$project_id." ) 
            and account_type=".$account_type."  and project_id=".$project_id)->get(['system_prefix']);

               
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

        //dd($max_system_prefix);die;
        DB::beginTransaction();
        $account_holder_info= AccountHolder::create($request->all());

        $userRaw=User::create([
            'name'          => $request->input('first_name')." ".$request->input('middle_name')." ".$request->input('last_name'),
            'email'         => $request->input('email'),
            'project_id'    => $project_id,
            'user_type'     => $request->input('account_type'),
            'account_holder_id'=>$account_holder_info->id,
            'project_type'  => 94,
            'status_active' => 1,
            'pin_code'      => rand(11111, 99999),
            'password'      => Hash::make(str_random(8)),
        ]);
        
        $user=$userRaw->toArray();

        $RId1=true;
        if($account_holder_info  && $userRaw )
        {
            DB::commit();
            Mail::send('emails.activation',$user, function ($message) use ($user){
                $message->to('a.i.bhouiyan@gmail.com');
                $message->subject('Activation Code');
            });
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
        $ArrayFunction              =new ArrayFunction();
        $account_holder_arr         =$ArrayFunction->account_holder_arr;
        $industry_selctor_list      =industrySector::where('status_active',1)
                                    ->whereIn('project_id',[$project_id,0])
                                    ->get();
        $industry_sector_arr=array();
        foreach ($industry_selctor_list as $key => $value) {
            $industry_sector_arr[$value->id]=$value->sector_name;
        }

        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
            $country_code_arr[$value->id]=$value->country_code;
        }

        $data['country_arr']        =$country_arr;
        $data['account_holder_arr'] =$account_holder_arr;

        $data['industry_sector_arr']        =$industry_sector_arr;
        $account_holder_list=AccountHolder::where('status_active',1)
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
        
        request()->validate([

            'account_type'                  =>"required",
            'first_name'                    =>"required",
            'middle_name'                   =>"required",
            'last_name'                     =>"required",
            'industry_sector'               =>"required",
            //'industry_sector_text'          =>"required",
            'reg_cor_dir_info'              =>"required",
            'register_corp_first_name'      =>"required",
            'register_corp_middle_name'     =>"required",
            'register_corp_last_name'       =>"required",
            'register_corp_phone_no'        =>"required",
            'register_corp_email'           =>"required",
            'register_emergency_contact'    =>"required",
            'house_number'                  =>"required",
            'street_number'                 =>"required",
            'city'                          =>"required",
            'state'                         =>"required",
            'country'                       =>"required",
            'zip_code'                      =>"required",
            'email'                         =>"required",
            'fax_no'                        =>"required",
            'cell_phone'                    =>"required",
            'website'                       =>"required",
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
                

        //dd($max_system_prefix);die;
        DB::beginTransaction();
        $account_holder_info= AccountHolder::find($id)->update($request->all());

        $userRaw=User::where('account_holder_id', $id)->where('user_type', $request->input('account_type'))->update([
            'name'          => $request->input('first_name')." ".$request->input('middle_name')." ".$request->input('last_name'),
            'email'         => $request->input('email'),
            'user_type'     => $request->input('account_type'),
        ]);
        

        if($account_holder_info  && $userRaw )
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
        $AccountHolder_delete=AccountHolder::find($id)->update(array('is_deleted' => 1,'status_active' => 0));
        $User_delete=User::where('account_holder_id',$id)->update(array('status_active' => 0));

        if($AccountHolder_delete  && $User_delete)
        {
           DB::commit();
           return "1**$id";
        }
        else
        {
            DB::rollBack();
            return 10;
        }
        die;
    }
}
