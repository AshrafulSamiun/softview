<?php  

namespace App\Http\Controllers\AccountHolder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\industrySector;
use App\Models\Country as Country;
use App\Models\AccountHolderSuffix;
use App\Models\AccountHolderBoardOfDirector;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Mail;



class AccountHolderBoardOfDirectorController extends Controller
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
        $account_holder_arr         =$ArrayFunction->account_holder_arr;
        $payment_name               =$ArrayFunction->payment_name; 
        $payment_class              =$ArrayFunction->payment_class;
        

        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
            $country_code_arr[$value->id]=$value->country_code;
        }

        $data['country_arr']        =$country_arr;
        $data['account_holder_arr'] =$account_holder_arr;
        $data['payment_name'] =$payment_name; 
        $data['payment_class'] =$payment_class;

        return $data;
    }

    public function posting_status( Request $request)
    {

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else
        {
            return 100;
        }

        $user=\Auth::user();
        $project_id                 = $user->project_id;
       

        $sl=0;
        $account_holder_list=AccountHolderBoardOfDirector::where('is_deleted',0)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->select('posting_status','status_active')
                                        ->get();  

        $data['account_holder_list']['saved']       =0;
        $data['account_holder_list']['transmit_out']=0;
        $data['account_holder_list']['rejected']    =0;
        $data['account_holder_list']['voided']      =0;
        $data['account_holder_list']['posted']      =0;
        $data['account_holder_list']['adjusted']    =0;
        $data['account_holder_list']['reposted']    =0;
        foreach ($account_holder_list as $key => $value) {
            if($value->posting_status==0)
            {
                if ($value->status_active==1)
                    $data['account_holder_list']['saved']++;
                else if ($value->status_active==3)
                    $data['account_holder_list']['rejected']++;
            }
            if($value->posting_status==1)
            {
                if ($value->status_active==1)
                    $data['account_holder_list']['transmit_out']++;
                else if ($value->status_active==2)
                    $data['account_holder_list']['voided']++;
            }
            else if ($value->posting_status==2)
            {
                $data['account_holder_list']['posted']++;
            }
            else if ($value->posting_status==3)
            {
                $data['account_holder_list']['adjusted']++;
            }
            else if ($value->posting_status==4)
            {
                $data['account_holder_list']['reposted']++;
            }
        }
        
        return $data;

    }

    public function list_by_posting_type( Request $request, $type)
    {

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else
        {
            return 100;
        }

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $account_holder_arr         =$ArrayFunction->account_holder_arr;
       
        //===================Company==========================================
        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
        }
      

        $sl=0;
        $account_holder_sql=AccountHolderBoardOfDirector::where('is_deleted',0)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id);
                                        
        if($type==1)  
        {
            $account_holder_sql->where('posting_status',0)->where('status_active',1);
        }
        else if($type==2)  
        {
            $account_holder_sql->where('posting_status',0)->where('status_active',3);
        }
        else if($type==3)  
        {
            $account_holder_sql->where('posting_status',1)->where('status_active',1);
        }
        else if($type==4)  
        {
            $account_holder_sql->where('posting_status',1)->where('status_active',2);
        }
        else if($type==5)  
        {
            $account_holder_sql->where('posting_status',2)->where('status_active',1);
        }
        else if($type==6)  
        {
            $account_holder_sql->where('posting_status',3)->where('status_active',1);
        }
        else if($type==7)  
        {
            $account_holder_sql->where('posting_status',4)->where('status_active',1);
        }

        $account_holder_list=$account_holder_sql->get();

        foreach ($account_holder_list as $key => $value) {


            $data['account_holder_list'][$key]['sl']                    =$sl+1;
            $data['account_holder_list'][$key]['id']                    =$value->id;
            $data['account_holder_list'][$key]['system_no']             =$value->system_no;
            $data['account_holder_list'][$key]['email']                 =$value->email;
            $data['account_holder_list'][$key]['cell_phone']            =$value->cell_phone;  
            $data['account_holder_list'][$key]['board_of_director_name']=$value->board_of_director_name; 
            $data['account_holder_list'][$key]['board_of_director_position']=$value->board_of_director_position; 
            $data['account_holder_list'][$key]['chart_of_acocounts']    =$value->chart_of_acocounts;  
            $data['account_holder_list'][$key]['acount_status']         =$value->acount_status; 
            $data['account_holder_list'][$key]['education']             =$value->education; 
            $data['account_holder_list'][$key]['title']                 =$value->title; 
            $data['account_holder_list'][$key]['account_type_string']   =$account_holder_arr[$value->account_type]; 
            $data['account_holder_list'][$key]['country_name']          =$country_arr[$value->country];

            if($value->photo_id)
            {
                $data['account_holder_list'][$key]['photo_path']        =url('/storage/uploads/'.$value->directorphoto->image_name);
            }
            else
            {
                $data['account_holder_list'][$key]['photo_path']        ="";
            }
             
            $sl++;
        }
        
        return $data;
    }


    public function AccountHolderBoardOfDirectorLists()
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

        $sl=0;
        $account_holder_list=AccountHolderBoardOfDirector::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->get();   
                                        //dd($account_holder_list);die;
        foreach ($account_holder_list as $key => $value) { 

            $data['account_holder_list'][$key]['sl']                    =$sl+1;
            $data['account_holder_list'][$key]['id']                    =$value->id;
            $data['account_holder_list'][$key]['system_no']             =$value->system_no;
            $data['account_holder_list'][$key]['email']                 =$value->email;
            $data['account_holder_list'][$key]['cell_phone']            =$value->cell_phone;  
            $data['account_holder_list'][$key]['board_of_director_name']=$value->board_of_director_name; 
            $data['account_holder_list'][$key]['board_of_director_position']=$value->board_of_director_position; 
            $data['account_holder_list'][$key]['chart_of_acocounts']    =$value->chart_of_acocounts;  
            $data['account_holder_list'][$key]['acount_status']         =$value->acount_status; 
            $data['account_holder_list'][$key]['education']             =$value->education; 
            $data['account_holder_list'][$key]['title']                 =$value->title;

            if($value->photo_id)
            {
                $data['account_holder_list'][$key]['photo_path']        =url('/storage/uploads/'.$value->directorphoto->image_name);
            }
            else
            {
                $data['account_holder_list'][$key]['photo_path']        ="";
            }
            $data['account_holder_list'][$key]['account_type_string']   =$account_holder_arr[$value->account_type]; 
            $data['account_holder_list'][$key]['country_name']          =$country_arr[$value->country];

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
            return "100**22**21";
        }
        request()->validate([

            'account_type'                  =>"required",
            'board_of_director_name'        =>"required",
            'board_of_director_position'    =>"required", 
            'chart_of_acocounts'            =>"required", 
            //'account_creation_date'         =>"required",
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
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);
        $account_type=$request->input('account_type');

        $account_creation_date                          =date("Y-m-d",strtotime($request->input('account_creation_date')));
        $request->merge(['account_creation_date'        =>$account_creation_date]);

        $account_fuffix_details         =AccountHolderSuffix::where('status_active',1)
                                        ->where('id',$account_type)
                                        ->first();

        
        $account_suffix=$account_fuffix_details->suffix;
        $account_prifix=$account_fuffix_details->prifix;
        

        $max_system_data = AccountHolderBoardOfDirector::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from account_holder_board_of_directors 
            where account_type=".$account_type." and company_id=".$company_id."  and project_id=".$project_id." ) 
            and account_type=".$account_type." and company_id=".$company_id."  and project_id=".$project_id)->get(['system_prefix']);

               
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
        $account_holder_info= AccountHolderBoardOfDirector::create($request->all());

        $userRaw=User::create([
            'name'          => $request->input('board_of_director_name'),
            'email'         => $request->input('email'),
            'project_id'    => $project_id,
            'company_id'    => $company_id,
            'user_type'     => $request->input('account_type'),
            'account_holder_id'=>$account_holder_info->id,
            'project_type'  => 94,
            'status_active' => 0,
            'pin_code'      => rand(11111, 99999),
            //'password'      => Hash::make(str_random(8)),
        ]);
        
        $user=$userRaw->toArray();

        $RId1=true;
        if($account_holder_info  && $userRaw )
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
    public function show($id,Request $request)
    {
        $company_id     =$request->session()->get('company_id');
        $company_name   =$request->session()->get('company_name');
 
        if (is_null($company_id)) 
        { 
            return "100**22**21";
        }
        
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
        $data['company_name']       =$company_name;
        

        $account_holder_list=AccountHolderBoardOfDirector::where('is_deleted',0)
                                        ->where('id',$id)
                                        ->where('company_id',$company_id)
                                        ->first();

        $data['account_holder']=$account_holder_list;
        return view('account_holder.print_board_of_director',$data);
    }

    public function pdf_print_all( Request $request, $type,$style)
    {

        if($request->session()->has('company_avaibale'))
        {
            $company_id     =$request->session()->get('company_id');
            $company_name   =$request->session()->get('company_name');
        }
        else
        {
            return 100;
        }

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $account_holder_arr         =$ArrayFunction->account_holder_arr;
       
        //===================Company==========================================
        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
        }
        
        $data['company_name'] =$company_name;

        $sl=0;
        $account_holder_sql=AccountHolderBoardOfDirector::where('is_deleted',0)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id);
                                        
        if($type==1)  
        {
            $account_holder_sql->where('posting_status',0)->where('status_active',1);
        }
        else if($type==2)  
        {
            $account_holder_sql->where('posting_status',0)->where('status_active',3);
        }
        else if($type==3)  
        {
            $account_holder_sql->where('posting_status',1)->where('status_active',1);
        }
        else if($type==4)  
        {
            $account_holder_sql->where('posting_status',1)->where('status_active',2);
        }
        else if($type==5)  
        {
            $account_holder_sql->where('posting_status',2)->where('status_active',1);
        }
        else if($type==6)  
        {
            $account_holder_sql->where('posting_status',3)->where('status_active',1);
        }
        else if($type==7)  
        {
            $account_holder_sql->where('posting_status',4)->where('status_active',1);
        }

        $account_holder_list=$account_holder_sql->get();


        foreach ($account_holder_list as $key => $value) {


            $data['account_holder_list'][$key]['sl']                            =$sl+1;
            $data['account_holder_list'][$key]['id']                            =$value->id;
            $data['account_holder_list'][$key]['system_no']                     =$value->system_no;
            $data['account_holder_list'][$key]['board_of_director_name']        =$value->board_of_director_name; 
            $data['account_holder_list'][$key]['board_of_director_position']    =$value->board_of_director_position; 
            if($value->account_holder_portal==1)
                $data['account_holder_list'][$key]['account_holder_portal']     ="Yes"; 
            else
                $data['account_holder_list'][$key]['account_holder_portal']     ="No";
            if($value->account_holder_dedicated_file==1)
                $data['account_holder_list'][$key]['account_holder_dedicated_file']="Yes"; 
            else
                $data['account_holder_list'][$key]['account_holder_dedicated_file']="No";

            if($value->photo_id)
            {
                $data['account_holder_list'][$key]['photo_path']                =url('/storage/uploads/'.$value->directorphoto->image_name);
            }
            else
            {
                $data['account_holder_list'][$key]['photo_path']                ="";
            }
            $data['account_holder_list'][$key]['education']                     =$value->education;
            $data['account_holder_list'][$key]['title']                         =$value->title;
            $data['account_holder_list'][$key]['chart_of_acocounts']            =$value->chart_of_acocounts;  
            $data['account_holder_list'][$key]['acount_status']                 =$value->acount_status; 
            $data['account_holder_list'][$key]['country_name']                  =$country_arr[$value->country];
            $data['account_holder_list'][$key]['house_number']                  =$value->house_number;
            $data['account_holder_list'][$key]['street_number']                 =$value->street_number;
            $data['account_holder_list'][$key]['city']                          =$value->city;  
            $data['account_holder_list'][$key]['state']                         =$value->state; 
            $data['account_holder_list'][$key]['zip_code']                      =$value->zip_code; 
            $data['account_holder_list'][$key]['office_phone']                  =$value->office_phone; 
            $data['account_holder_list'][$key]['cell_phone']                    =$value->cell_phone;   
            $data['account_holder_list'][$key]['email']                         =$value->email; 
            $data['account_holder_list'][$key]['fax_no']                        =$value->fax_no;
            $data['account_holder_list'][$key]['website']                       =$value->website; 
             
            $sl++;
        }

        if($style==1)
            return view('account_holder.print_all_board_of_director_data',$data);
        else if($style==2)
        {
            ob_start();
            ?>

            <table width="1300" align="center">
                <tr><td align="center" style="font-size:28px;" colspan="8"><img class="media-object img-circle" src="{{asset('images/bmtf_logo.png')}}" width="38" height="38"></td></tr>
                <tr><td align="center" style="font-size:30px;" colspan="8"><b><?php echo $company_name; ?></b></td></tr>
                <tr><td align="center" style="font-size:30px;" colspan="8"><b>Bank Info</b></td></tr>
                
            </table>
            <table width="3700" align="center" class="table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>System No </th>
                        <th>Bank Account No</th>
                        <th>Bank Account Name</th>
                        <th>Branch Name</th>
                        <th>Chart of Accounts</th>
                        <th>House Number </th>
                        <th>Street Number</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Zip- Code</th>
                        <th>Office Phone </th>
                        <th>Mobile No </th>
                        <th>Email </th>
                        <th>Fax </th>
                        <th>Website</th>
                    </tr>
                </thead>
                
               <tbody>

                <?php 


               foreach (glob('download/bank_info/'.$company_id."_*.xls") as $filename) 
                {
                    
                   // if( @filemtime($filename) < (time()-$seconds_old) )
                       @unlink($filename);
                }
                $name=time();
                $filename=$company_id."_".$name.".xls";
                ?>

                <tr>
                    <td><a href="<?php echo url('/download/bank_info')."/".$filename; ?>" id="download_excel"></a>
                    </td>
                </tr>
                <?php

                    if(!empty($data['account_holder_list']))
                    {
                        foreach ($data['account_holder_list'] as $key => $value) 
                        {

                    ?>   
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $value['system_no']; ?> </td>
                            <td><?php echo $value['bank_acount_no']; ?> </td>
                            <td><?php echo $value['bank_account_name']; ?></td>
                            <td><?php echo $value['branch_name']; ?></td>
                            <td><?php echo $value['chart_of_acocounts']; ?></td>
                            <td><?php echo $value['house_number']; ?></td>
                            <td><?php echo $value['street_number']; ?></td>
                            <td><?php echo $value['city']; ?></td>
                            <td><?php echo $value['state']; ?></td>
                            <td><?php echo $value['zip_code']; ?> </td>
                            <td><?php echo $value['office_phone']; ?></td>
                            <td><?php echo $value['cell_phone']; ?></td>
                            <td><?php echo $value['email']; ?></td>
                            <td><?php echo $value['fax_no']; ?></td>
                            <td><?php echo $value['website']; ?></td>                          
                        </tr>
                    <?php 
                        }
                    }
                ?>
                </tbody>

            </table>

            <?php

                $create_new_doc = fopen("Download/bank_info/".$filename, 'w');
                $is_created = fwrite($create_new_doc,ob_get_contents());
                 
                ob_flush();
                ob_end_clean();
                //return $filename;
        }

    }


    public function pdf_print($id,Request $request)
    {
        $company_id     =$request->session()->get('company_id');
        $company_name   =$request->session()->get('company_name');
 
        if (is_null($company_id)) 
        { 
            return "100**22**21";
        }
        
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
        $data['company_name']       =$company_name;
        

        $account_holder_list=AccountHolderBoardOfDirector::where('is_deleted',0)
                                        ->where('id',$id)
                                        ->where('company_id',$company_id)
                                        ->first();

        $data['account_holder']=$account_holder_list;
        return view('account_holder.print_pdf_board_of_director',$data);
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

        $account_holder_list=AccountHolderBoardOfDirector::where('status_active',1)
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
            'board_of_director_name'        =>"required",
            'board_of_director_position'    =>"required", 
            'chart_of_acocounts'            =>"required", 
            'account_creation_date'         =>"required",
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
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
                

        DB::beginTransaction();
        $account_holder_info= AccountHolderBoardOfDirector::find($id)->update($request->all());

        $userRaw=User::where('account_holder_id', $id)->
        where('user_type', $request->input('account_type'))->update([
            'name'          => $request->input('board_of_director_name'),
            'email'         => $request->input('email'),
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

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        DB::beginTransaction();
        $calendar_info= AccountHolderBoardOfDirector::find($id)->update(['updated_by'=>$user_id,'status_active'=>0,'is_deleted'=>1]);       

        $userRaw=User::where('account_holder_id', $id)->
        where('user_type', 6)->update([
            'is_deleted'          => 0,
        ]);

        if($calendar_info && $userRaw)
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
      
        $buildingInfo=AccountHolderBoardOfDirector::where('id',"=",$id)->update($update_data);

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
      
        $buildingInfo=AccountHolderBoardOfDirector::where('id',"=",$id)->update($update_data);

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
      
        $buildingInfo=AccountHolderBoardOfDirector::where('id',"=",$id)->update($update_data);

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
            'board_of_director_name'        =>"required",
            'board_of_director_position'    =>"required", 
            'chart_of_acocounts'            =>"required", 
            'account_creation_date'         =>"required",
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
        $account_holder_info= AccountHolderBoardOfDirector::find($id)->update($request->all());

        $userRaw=User::where('account_holder_id', $id)->
        where('user_type', $request->input('account_type'))->update([
            'name'          => $request->input('board_of_director_name'),
            'email'         => $request->input('email'),
        ]);

        if($account_holder_info && $userRaw)
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
      
        $buildingInfo=AccountHolderBoardOfDirector::where('id',"=",$id)->update($update_data);

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

 

