<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\AccountHolderGuest;
use App\Models\AccountHolderSuffix;
use App\Models\Country as Country;
use App\Models\industrySector;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;


class AccountHolderGuestController extends Controller
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
       // dd($project_id); die;
        $ArrayFunction              =new ArrayFunction();
        $account_holder_arr         =$ArrayFunction->account_holder_arr;
        $payment_name               =$ArrayFunction->payment_name; 
        $payment_class              =$ArrayFunction->payment_class;
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




    public function AccountHolderGuestLists()
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
        $account_holder_list=AccountHolderGuest::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->get();   
                                         //dd($account_holder_list);die;
        foreach ($account_holder_list as $key => $value) { 

            $data['account_holder_list'][$key]['sl']                         =$sl+1;
            $data['account_holder_list'][$key]['id']                          =$value->id;
            $data['account_holder_list'][$key]['system_no']                    =$value->system_no;
            $data['account_holder_list'][$key]['account_type_string']           =$account_holder_arr[$value->account_type]; 
            $data['account_holder_list'][$key]['guest_name']                 =$value->guest_name;  
            $data['account_holder_list'][$key]['company_name']                 =$value->company_name; 
            $data['account_holder_list'][$key]['company_logo']                 =$value->company_logo;  
            $data['account_holder_list'][$key]['guest_photo']                 =$value->guest_photo; 
            $data['account_holder_list'][$key]['guest_office_phone']             =$value->guest_office_phone; 
            $data['account_holder_list'][$key]['guest_cell_phone']                 =$value->guest_cell_phone; 
            $data['account_holder_list'][$key]['guest_email']                 =$value->guest_email; 
            $data['account_holder_list'][$key]['guest_fax_no']                 =$value->guest_fax_no; 
            $data['account_holder_list'][$key]['guest_website']                 =$value->guest_website; 
            $data['account_holder_list'][$key]['guest_house_number']                 =$value->guest_house_number; 
            $data['account_holder_list'][$key]['guest_street_number']                 =$value->guest_street_number; 
            $data['account_holder_list'][$key]['guest_city']                 =$value->guest_city; 
            $data['account_holder_list'][$key]['guest_state']                 =$value->guest_state;  
            $data['account_holder_list'][$key]['guest_country']                  =$country_arr[$value->guest_country];
            $data['account_holder_list'][$key]['guest_zip_code']                 =$value->guest_zip_code;  
            $data['account_holder_list'][$key]['company_office_phone']                 =$value->company_office_phone; 
            $data['account_holder_list'][$key]['company_cell_phone']                 =$value->company_cell_phone; 
            $data['account_holder_list'][$key]['company_email']                 =$value->company_email; 
            $data['account_holder_list'][$key]['company_fax_no']                 =$value->company_fax_no; 
            $data['account_holder_list'][$key]['company_website']                 =$value->company_website; 
            $data['account_holder_list'][$key]['company_house_number']                 =$value->company_house_number; 
            $data['account_holder_list'][$key]['company_street_number']                 =$value->company_street_number; 
            $data['account_holder_list'][$key]['company_city']                 =$value->company_city; 
            $data['account_holder_list'][$key]['company_state']                 =$value->company_state;  
            $data['account_holder_list'][$key]['company_country']                  =$country_arr[$value->company_country];
            $data['account_holder_list'][$key]['company_zip_code']                 =$value->company_zip_code;  
            $data['account_holder_list'][$key]['industry_sector']                        =$value->industry_sector;
            $data['account_holder_list'][$key]['payment_method']                    =$value->payment_method; 
            $data['account_holder_list'][$key]['invoice_term']                   =$value->invoice_term;  
            $data['account_holder_list'][$key]['credit_limit']                =$value->credit_limit; 
            $data['account_holder_list'][$key]['chart_of_acocounts']             =$value->chart_of_acocounts;  
            $data['account_holder_list'][$key]['acount_status']                 =$value->acount_status; 
           
          

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

            'account_type'=>"required",
            'guest_name'=>"required",
            'guest_photo'=>"required",
            'guest_office_phone'=>"required",
            'guest_cell_phone'=>"required",
            'guest_email'=>"required",
            'guest_fax_no'=>"required",
            'guest_website'=>"required",
            'guest_house_number'=>"required",
            'guest_street_number'=>"required",
            'guest_city'=>"required", 
            'guest_state'=>"required",
            'guest_country'=>"required",
            'guest_zip_code'=>"required",
            'company_name'=>"required",
            'company_logo'=>"required" ,
            'industry_sector'=>"required",
            'company_house_number'=>"required",
            'company_street_number'=>"required",
            'company_city'=>"required",
            'company_state'=>"required",
            'company_country'=>"required",
            'company_zip_code'=>"required",
            'company_office_phone'=>"required",
            'company_cell_phone'=>"required",
            'company_email'=>"required",
            'company_fax_no'=>"required",
            'company_website'=>"required",
            'payment_method'=>"required",
            'invoice_term'=>"required",
            'credit_limit'=>"required",
            'chart_of_acocounts'=>"required",
            'account_creation_date'=>"required",
            'acount_status'=>"required",
            'comments'=>"required",
            'account_holder_portal'                        =>"required",
            'account_holder_dedicated_file'                =>"required",
            'account_holder_title_name'                 =>"required",
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $account_type=$request->input('account_type');
        $request->merge(['company_id' =>$company_id]);

        $account_creation_date                          =date("Y-m-d",strtotime($request->input('account_creation_date')));
        $request->merge(['account_creation_date'             =>$account_creation_date]);

       // $professional_license_expire_date                          =date("Y-m-d",strtotime($request->input('professional_license_expire_date')));
       // $request->merge(['professional_license_expire_date'             =>$professional_license_expire_date]);


        //$professional_license_renewal_date                          =date("Y-m-d",strtotime($request->input('professional_license_renewal_date')));
       // $request->merge(['professional_license_renewal_date'             =>$professional_license_renewal_date]);

        $account_fuffix_details         =AccountHolderSuffix::where('status_active',1)
                                        ->where('id',$account_type)
                                        ->first();

        
        $account_suffix=$account_fuffix_details->suffix;
        $account_prifix=$account_fuffix_details->prifix;
        

        $max_system_data = AccountHolderGuest::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from account_holder_guests 
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
        $account_holder_info= AccountHolderGuest::create($request->all());

        $userRaw=User::create([
            'name'          => $request->input('guest_name'),
            'email'         => $request->input('guest_email'),
            'project_id'    => $project_id,
            'company_id'    => $company_id,
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
        $account_holder_list=AccountHolderGuest::where('status_active',1)
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

                'account_type'=>"required",
                'guest_name'=>"required",
                'guest_photo'=>"required",
                'guest_office_phone'=>"required",
                'guest_cell_phone'=>"required",
                'guest_email'=>"required",
                'guest_fax_no'=>"required",
                'guest_website'=>"required",
                'guest_house_number'=>"required",
                'guest_street_number'=>"required",
                'guest_city'=>"required", 
                'guest_state'=>"required",
                'guest_country'=>"required",
                'guest_zip_code'=>"required",
                'company_name'=>"required",
                'company_logo'=>"required" ,
                'industry_sector'=>"required",
                'company_house_number'=>"required",
                'company_street_number'=>"required",
                'company_city'=>"required",
                'company_state'=>"required",
                'company_country'=>"required",
                'company_zip_code'=>"required",
                'company_office_phone'=>"required",
                'company_cell_phone'=>"required",
                'company_email'=>"required",
                'company_fax_no'=>"required",
                'company_website'=>"required",
                'payment_method'=>"required",
                'invoice_term'=>"required",
                'credit_limit'=>"required",
                'chart_of_acocounts'=>"required",
                'account_creation_date'=>"required",
                'acount_status'=>"required",
                'comments'=>"required",
                'account_holder_portal'                        =>"required",
                'account_holder_dedicated_file'                =>"required",
                'account_holder_title_name'                 =>"required",
            
            
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
                

        //dd($max_system_prefix);die;
        DB::beginTransaction();
        $account_holder_info= AccountHolderGuest::find($id)->update($request->all());

        $userRaw=User::where('account_holder_id', $id)->where('user_type', $request->input('account_type'))->update([
            'name'          => $request->input('guest_name'),
            'email'         => $request->input('guest_email'),
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
        $AccountHolder_delete=AccountHolderGuest::find($id)->update(array('is_deleted' => 1,'status_active' => 0));
        $User_delete=User::where('account_holder_id',$id)->where('user_type',9)->update(array('status_active' => 0));

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
 
