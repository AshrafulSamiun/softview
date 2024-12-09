<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AccountCompany as AccountCompany;
use App\Models\AccountContactPerson as AccountContactPerson;
use Illuminate\Support\Facades\DB;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Support\Facades\Cache;
use App\Models\Country as Country;
use App\Models\Project as Project;
use App\Models\NewPostingJob as NewPostingJob;
use App\Models\User as User;
use Carbon\Carbon;
use App\Models\MailStorage as MailStorage;
//use Illuminate\Filesystem\Cache;


class ManageUsersController extends Controller
{
    public function index()
    { 

        $ArrayFunction          =new ArrayFunction();
        $row_status             =$ArrayFunction->row_status;
        $user_type_arr          =$ArrayFunction->user_type_arr;
        $project_id                         = \Auth::user()->project_id; 
        $user_id                            = \Auth::user()->id; 
        $data['row_status']=$row_status;
        $data['user_type_arr']=$user_type_arr;
        $user_data=User::all(); 
        $sl=0;
        foreach($user_data as $key=>$val)
        {
    

            $data['user_data_sammary'][$val->user_type]['user_type_name']=$user_type_arr[$val->user_type];
            $data['user_data'][$val->user_type][$sl]['user_id']=$val->id;

            $data['user_data'][$val->user_type][$sl]['id']='EM-000'.$sl;
            $data['user_data'][$val->user_type][$sl]['sl']=$sl+1;
            $data['user_data'][$val->user_type][$sl]['name']=$val->name;
            $data['user_data'][$val->user_type][$sl]['email']=$val->email;
            $data['user_data'][$val->user_type][$sl]['user_type']=$val->user_type;
            $data['user_data'][$val->user_type][$sl]['user_type_string']=$user_type_arr[$val->user_type];
            $data['user_data'][$val->user_type][$sl]['status_active']=$val->status_active;


            if($val->status_active==1)
            {
                if(empty($data['user_data_sammary'][$val->user_type]['active']))
                { 
                    $data['user_data_sammary'][$val->user_type]['active']=1;
                }
                else
                {
                    $data['user_data_sammary'][$val->user_type]['active']++;
                } 
                $data['user_data'][$val->user_type][$sl]['active']="1"; 

            }
            elseif($val->status_active==0)
            {

                if(empty($data['user_data_sammary'][$val->user_type]['deactivate']))
                { 
                    $data['user_data_sammary'][$val->user_type]['deactivate']=1;
                }
                else
                {
                    $data['user_data_sammary'][$val->user_type]['deactivate']++;
                } 
                $data['user_data'][$val->user_type][$sl]['deactivate']="2"; 
            }


            if(Cache::has('user-is-online-'.$val->id))
            { 
                if(empty($data['user_data_sammary'][$val->user_type]['online']))
                { 
                    $data['user_data_sammary'][$val->user_type]['online']=1;
                }
                else
                {
                    $data['user_data_sammary'][$val->user_type]['online']++;
                } 
                 
                $data['user_data'][$val->user_type][$sl]['online']="1";
                $data['user_data'][$val->user_type][$sl]['last_seen']=Carbon::parse($val->last_seen)->diffForHumans(); 
            }
            else
            { 
                if(empty($data['user_data_sammary'][$val->user_type]['Offline']))
                { 
                    $data['user_data_sammary'][$val->user_type]['Offline']=1;
                }
                else
                {
                    $data['user_data_sammary'][$val->user_type]['Offline']++;
                }

                $data['user_data'][$val->user_type][$sl]['Offline']="2";
                if($val->last_seen)
                { $data['user_data'][$val->user_type][$sl]['last_seen']=Carbon::parse($val->last_seen)->diffForHumans(); 
                
                } 
               
            } 

           
            $sl++;

        }

       
 		     return $data;
    }
    public function manageuserloadBuildingByCustomer($customer)
    {
       
        $country                            =Country::where('status_active',1)->get();

       // dd($customer); die;
        foreach ($country as $key => $value) 
		{
            $country_arr[$value->id]        =$value->country_name;
            $country_code_arr[$value->id]   =$value->country_code;
        }
      

        $data['country_arr']                =$country_arr;
       

        $user=\Auth::user(); 
        $project_id                 = $user->project_id; 
        $project_info               = Project::find($project_id); 
        $data['project_name']       =$project_info->project_name;
        $ArrayFunction              =new ArrayFunction();
        $user_type_arr              =$ArrayFunction->user_type_arr;  
        $row_status             =$ArrayFunction->row_status;
        $user_type_arr          =$ArrayFunction->user_type_arr;
        $data['row_status']=$row_status;
        $data['user_type_arr']=$user_type_arr;
        
        
        
        $building_arr_list              =User::where('status_active',1)
        ->where('entry_form',1)
        ->where('customer_id',$customer)
        ->get();
        $data['building_arr']               =array(); 
        foreach($building_arr_list as $key=>$val)
        {
        $data['building_arr'][$val->bulding_id]   =$val->building_id_name;

        }  

       
        return $data;

    }
    

    public function manageuserloadUserByBuilding($building_id)
    {
       
        $country                            =Country::where('status_active',1)->get();

         //dd($building_id); die;
        foreach ($country as $key => $value) 
		{
            $country_arr[$value->id]        =$value->country_name;
            $country_code_arr[$value->id]   =$value->country_code;
        }
      

        $data['country_arr']                =$country_arr;
       

        $user=\Auth::user(); 
        $project_id                 = $user->project_id; 
        $project_info               = Project::find($project_id); 
        $data['project_name']       =$project_info->project_name;
        $ArrayFunction              =new ArrayFunction();
        $user_type_arr              =$ArrayFunction->user_type_arr;  
        $row_status             =$ArrayFunction->row_status;
        $user_type_arr          =$ArrayFunction->user_type_arr;
        $data['row_status']=$row_status;
        $data['user_type_arr']=$user_type_arr; 
       
      // $ArrayFunction          =new ArrayFunction();
       //$row_status             =$ArrayFunction->row_status;
       $user_type_arr          =$ArrayFunction->user_type_arr;
       //$project_id                         = \Auth::user()->project_id; 
       $user_id                            = \Auth::user()->id; 
      // $data['row_status']=$row_status;
       //$data['user_type_arr']=$user_type_arr;
       $user_data=User::all(); 
       $sl=0;
       foreach($user_data as $key=>$val)
       {
   

           $data['user_data_sammary'][$val->user_type]['user_type_name']=$user_type_arr[$val->user_type];
           $data['user_data'][$val->user_type][$sl]['user_id']=$val->id;

           $data['user_data'][$val->user_type][$sl]['id']='EM-000'.$sl;
           $data['user_data'][$val->user_type][$sl]['sl']=$sl+1;
           $data['user_data'][$val->user_type][$sl]['name']=$val->name;
           $data['user_data'][$val->user_type][$sl]['email']=$val->email;
           $data['user_data'][$val->user_type][$sl]['user_type']=$val->user_type;
           $data['user_data'][$val->user_type][$sl]['user_type_string']=$user_type_arr[$val->user_type];
           $data['user_data'][$val->user_type][$sl]['status_active']=$val->status_active;


           if($val->status_active==1)
           {
               if(empty($data['user_data_sammary'][$val->user_type]['active']))
               { 
                   $data['user_data_sammary'][$val->user_type]['active']=1;
               }
               else
               {
                   $data['user_data_sammary'][$val->user_type]['active']++;
               } 
               $data['user_data'][$val->user_type][$sl]['active']="1"; 

           }
           elseif($val->status_active==0)
           {

               if(empty($data['user_data_sammary'][$val->user_type]['deactivate']))
               { 
                   $data['user_data_sammary'][$val->user_type]['deactivate']=1;
               }
               else
               {
                   $data['user_data_sammary'][$val->user_type]['deactivate']++;
               } 
               $data['user_data'][$val->user_type][$sl]['deactivate']="2"; 
           }


           if(Cache::has('user-is-online-'.$val->id))
           { 
               if(empty($data['user_data_sammary'][$val->user_type]['online']))
               { 
                   $data['user_data_sammary'][$val->user_type]['online']=1;
               }
               else
               {
                   $data['user_data_sammary'][$val->user_type]['online']++;
               } 
                
               $data['user_data'][$val->user_type][$sl]['online']="1";
               $data['user_data'][$val->user_type][$sl]['last_seen']=Carbon::parse($val->last_seen)->diffForHumans(); 
           }
           else
           { 
               if(empty($data['user_data_sammary'][$val->user_type]['Offline']))
               { 
                   $data['user_data_sammary'][$val->user_type]['Offline']=1;
               }
               else
               {
                   $data['user_data_sammary'][$val->user_type]['Offline']++;
               }

               $data['user_data'][$val->user_type][$sl]['Offline']="2";
               if($val->last_seen)
               { $data['user_data'][$val->user_type][$sl]['last_seen']=Carbon::parse($val->last_seen)->diffForHumans(); 
               
               } 
              
           } 

          
           $sl++;

       }
        
        
            //echo $project_id; die;  
            // dd($company_list); die;  
        return $data;

    }
    public function store(Request $request)
    {


        $user_data                              =\Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $email                                  =$user_data->email;
        $user_type                              =$user_data->user_type;
        $project_type                            =$user_data->project_type;

        $image_id                              =$user_data->image_id;
        $password                              =$user_data->password;
        $pin_code                              =$user_data->pin_code;
        $two_factor_code                        =$user_data->two_factor_code;
        $last_seen                              =$user_data->last_seen;

 
         //dd($last_seen);

    	/*$user=User::where('two_factor_code',$request->code)->first();
    	if($user){
    		$user->status_active=1;
    		$user->two_factor_code=null;
    		$user->save();
    		return redirect()->route('login')->withMessage('Your Account is Active.')
    	}

    	return back()->withMessage('Verify Code is not correct.Please Try Again.')*/ 

        $id_number=$request->id_number;
        $name=$request->name;
        $email_address=$request->email_address;
        $message =$request->message;
        $account_holder_type =$request->account_holder_type;

        // dd($id_number);

       // dd($id_number);
 
        // $send_mail="a.i.bhouiyan@gmail.com";
         //Mail::to($send_mail)->send(new PostingSendMail($id_number,$name,$email_address,$message));
        //return redirect('/');  
        
        $MailDetailsFrom = MailStorage::create(['project_id'=> $project_id, 'user_id'=> $user_id , 'massage_body'=> $message, 'mail_subject'=> $message, 'mail_form'=> $email_address, 'mail_to'=> $email_address, 'mail_cc'=> $email_address, 'mail_date'=>  $last_seen, 'id_number'=> $id_number, 'name'=> $name, 'account_type_holder'=> $account_holder_type]);
        
        $MailDetailsadminTo = MailStorage::create(['project_id'=> $project_id, 'user_id'=> $user_id , 'massage_body'=> $message, 'mail_subject'=> $message, 'mail_form'=> $email_address, 'mail_to'=> 'to', 'mail_cc'=> $email_address, 'mail_date'=>  $last_seen, 'id_number'=> $id_number, 'name'=> $name, 'account_type_holder'=> $account_holder_type]); 

        $MailDetailsadminCc = MailStorage::create(['project_id'=> $project_id, 'user_id'=> $user_id , 'massage_body'=> $message, 'mail_subject'=> $message, 'mail_form'=> $email_address, 'mail_to'=> $email_address, 'mail_cc'=>'Admin', 'mail_date'=>  $last_seen, 'id_number'=> $id_number, 'name'=> $name, 'account_type_holder'=> $account_holder_type]); 

        if($MailDetailsFrom &&  $MailDetailsadminTo && $MailDetailsadminCc)
        {
           DB::commit();
           return 1;
          // return ['message'=>'Data Save  successfully'];
         // return view('landing_page_details.send');
        }
        else
        {
            DB::rollBack();
           return 10;
        }
        die;

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

public function usersDeactive(Request $request, $id)
{

   // dd($id); die;
    DB::beginTransaction();

    $posting_delete=User::find($id)->update(array('status_active' =>0));


   
    if($posting_delete)
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

 public function usersReactive(Request $request, $id)
{
    DB::beginTransaction();

    $posting_delete=User::find($id)->update(array('status_active' =>1));


   
    if($posting_delete)
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

 
