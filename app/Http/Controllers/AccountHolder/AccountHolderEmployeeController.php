<?php   

namespace App\Http\Controllers\AccountHolder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\industrySector;
use App\Models\Country as Country;
use App\Models\AccountHolderSuffix;
use App\Models\AccountHolderEmployee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Mail;



class AccountHolderEmployeeController extends Controller
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




    public function AccountHolderEmployeeLists()
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
        $account_holder_list=AccountHolderEmployee::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->get();   
                                         //dd($account_holder_list);die;
        foreach ($account_holder_list as $key => $value) { 

            $data['account_holder_list'][$key]['sl']                         =$sl+1;
            $data['account_holder_list'][$key]['id']                          =$value->id;
            $data['account_holder_list'][$key]['system_no']                    =$value->system_no;
            $data['account_holder_list'][$key]['account_type_string']           =$account_holder_arr[$value->account_type]; 
            $data['account_holder_list'][$key]['employee_name']                 =$value->employee_name;  
            $data['account_holder_list'][$key]['company_name']                 =$value->company_name; 
            $data['account_holder_list'][$key]['company_logo']                 =$value->company_logo;  
            $data['account_holder_list'][$key]['employee_photo']                 =$value->employee_photo; 
            $data['account_holder_list'][$key]['employee_office_phone']             =$value->employee_office_phone; 
            $data['account_holder_list'][$key]['employee_cell_phone']                 =$value->employee_cell_phone; 
            $data['account_holder_list'][$key]['employee_email']                 =$value->employee_email; 
            $data['account_holder_list'][$key]['employee_fax_no']                 =$value->employee_fax_no; 
            $data['account_holder_list'][$key]['employee_website']                 =$value->employee_website; 
            $data['account_holder_list'][$key]['employee_house_number']                 =$value->employee_house_number; 
            $data['account_holder_list'][$key]['employee_street_number']                 =$value->employee_street_number; 
            $data['account_holder_list'][$key]['employee_city']                 =$value->employee_city; 
            $data['account_holder_list'][$key]['employee_state']                 =$value->employee_state;  
            $data['account_holder_list'][$key]['employee_country']                  =$country_arr[$value->employee_country];
            $data['account_holder_list'][$key]['employee_zip_code']                 =$value->employee_zip_code;  
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
        request()->validate([

            'account_type'=>"required",
            'employee_name'=>"required",
            'employee_photo'=>"required",
            'employee_office_phone'=>"required",
            'employee_cell_phone'=>"required",
            'employee_email'=>"required",
            'employee_fax_no'=>"required",
            'employee_website'=>"required",
            'employee_house_number'=>"required",
            'employee_street_number'=>"required",
            'employee_city'=>"required", 
            'employee_state'=>"required",
            'employee_country'=>"required",
            'employee_zip_code'=>"required",
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
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $account_type=$request->input('account_type');

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
        

        $max_system_data = AccountHolderEmployee::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from account_holder_employees 
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
        $account_holder_info= AccountHolderEmployee::create($request->all());

        $userRaw=User::create([
            'name'          => $request->input('employee_name'),
            'email'         => $request->input('employee_email'),
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
        $user_type                  = $user->user_type;
        $data['user_type']          =$user_type;
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
        $account_holder_list=AccountHolderEmployee::where('status_active',1)
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
                'employee_name'=>"required",
                'employee_photo'=>"required",
                'employee_office_phone'=>"required",
                'employee_cell_phone'=>"required",
                'employee_email'=>"required",
                'employee_fax_no'=>"required",
                'employee_website'=>"required",
                'employee_house_number'=>"required",
                'employee_street_number'=>"required",
                'employee_city'=>"required", 
                'employee_state'=>"required",
                'employee_country'=>"required",
                'employee_zip_code'=>"required",
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
            
            
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
                

        //dd($max_system_prefix);die;
        DB::beginTransaction();
        $account_holder_info= AccountHolderEmployee::find($id)->update($request->all());

        $userRaw=User::where('account_holder_id', $id)->update([
            'name'          => $request->input('employee_name'),
            'email'         => $request->input('employee_email'),
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
        //
    }
}
 