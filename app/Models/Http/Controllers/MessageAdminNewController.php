<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Classes\ArrayFunction as ArrayFunction;
use App\Country as Country;
use App\Project as Project;
use App\MailStorage as MailStorage;
use App\User as User;

class MessageAdminNewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 
        //$mailnboxType = $request->query('mailnbox'); 
        // $mailnbox2 = $request->input('param2');
        // dd($mailnbox); die;  
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
            $sl++;

        }  


        $sl=0;
        foreach($user_data as $key=>$val)
        {
    

           
            $data['user_arr'][$sl]['user_id']=$val->id; 
            $data['user_arr'][$sl]['id']='EM-000'.$sl;
            $data['user_arr'][$sl]['sl']=$sl+1;
            $data['user_arr'][$sl]['name']=$val->name;
            $data['user_arr'][$sl]['email']=$val->email;
            $data['user_arr'][$sl]['user_type']=$val->user_type;
            $data['user_arr'][$sl]['user_type_string']=$user_type_arr[$val->user_type];
            $data['user_arr'][$sl]['status_active']=$val->status_active;   
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
        $user_data                              =\Auth::user();
        $user_id                                =$user_data->id;
        //dd($id_number); die;
       
        request()->validate([ 
            'id_number'       => 'required',
            'to_id_number'    => 'required',  
            'message'    => 'required',  
        ]);

       
        $project_id                             =$user_data->project_id;
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]); 
        $new_posting_current_date                                      = date('Y-m-d H:i:s');
        $draft                                      =true;

        //dd($expiration_date); 
        $request->merge(['new_posting_date'                     =>$new_posting_current_date]);
        $request->merge(['draft'                     =>$draft]);

        $currentDate = date('Y-m-d');
        $newDate = date('Y-m-d', strtotime('+30 days', strtotime($currentDate))); 
        $request->merge(['expired_posting_date'                     =>$newDate]);
        $request->merge(['expired'                     =>$draft]);
        
       /*  
        $removing_posting_date                              =date("Y-m-d",strtotime($request->input('removing_posting_date')));
        $deactivated_posting_date                              =date("Y-m-d",strtotime($request->input('deactivated_posting_date')));*/

        //dd($expiration_date);

       /* $request->merge(['new_posting_date'                 =>$new_posting_date]);
        $request->merge(['renew_posting_date'               =>$renew_posting_date]); 
        $request->merge(['removing_posting_date'            =>$removing_posting_date]);
        $request->merge(['deactivated_posting_date'          =>$deactivated_posting_date]);*/


       // dd($request->input('genaral_posting_title')); die;
         

        


        //////////////// invoice data
       // protected $fillable = ['id', 'project_id', 'user_id', 'mst_id', 'page_id','transaction_type','payment_status','posting_status','invoice_number','invoice_date','posting_number', 'bill_to','id_number','rate','amount', 'payble_amount','sales_tax_rate','sales_tax_amount','posting_class','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
        
       
       

       
       $email                                  =$user_data->email;
       $user_type                              =$user_data->user_type;
       $project_type                           =$user_data->project_type; 
       $image_id                               =$user_data->image_id;
       $password                               =$user_data->password;
       $pin_code                               =$user_data->pin_code;
       $two_factor_code                        =$user_data->two_factor_code;
       $last_seen                              =$user_data->last_seen;


       $id_number=$request->id_number;
       $to_id_number=$request->to_id_number; 
       
       $from_user_id=$request->from_user_id;
       $to_user_id=$request->to_user_id; 

       $from_user_type=$request->from_user_type;
       $to_user_type=$request->to_user_type;

       //dd($user_data); die;
       $name=$request->name;
       $to_name=$request->to_name;


       $email_address=$request->email_address;
       $message =$request->message;
       $account_holder_type =$request->account_holder_type; 
       $to_account_holder_type =$request->to_account_holder_type; 

       //dd($to_account_holder_type); die;

       $MailDetailsFrom = MailStorage::create(['project_id'=> $project_id, 'user_id'=> $from_user_id , 'massage_body'=> $message, 'mail_subject'=> $message, 'mail_form'=>$from_user_id, 'mail_to'=>$to_user_id, 'mail_cc'=>$to_user_id, 'mail_date'=>$last_seen, 'id_number'=> $id_number, 'name'=> $name,'from_account_type_holder'=>$account_holder_type,'to_account_type_holder'=>$to_account_holder_type,'from_user_type'=>$from_user_type,'to_user_type'=> $to_user_type,'mail_sent'=>1,'mail_sending_point'=>1 ]);
       
       $MailDetailsadminTo = MailStorage::create(['project_id'=> $project_id, 'user_id'=>$to_user_id , 'massage_body'=> $message, 'mail_subject'=> $message, 'mail_form'=>$from_user_id, 'mail_to'=>$to_user_id,'mail_cc'=> $to_user_id,'mail_date'=>  $last_seen, 'id_number'=> $to_id_number, 'name'=>$to_name, 'from_account_type_holder'=>$account_holder_type,'to_account_type_holder'=>$to_account_holder_type,'from_user_type'=> $from_user_type,'to_user_type'=> $to_user_type,'mail_sent'=>2,'mail_sending_point'=>1]); 

       $MailDetailsadminCc = MailStorage::create(['project_id'=> $project_id, 'user_id'=>$to_user_id , 'massage_body'=> $message, 'mail_subject'=> $message, 'mail_form'=>$from_user_id, 'mail_to'=>$to_user_id, 'mail_cc'=>$to_user_id,'mail_date'=>  $last_seen, 'id_number'=> $to_id_number,'name'=>$to_name,'from_account_type_holder'=>$account_holder_type, 'to_account_type_holder'=>$to_account_holder_type,'from_user_type'=> $from_user_type,'to_user_type'=> $to_user_type,'mail_sent'=>3,'mail_sending_point'=>1]); 

       if($MailDetailsFrom &&  $MailDetailsadminTo && $MailDetailsadminCc)
       {
          DB::commit();
          return 1;
       }
       else
       {
           DB::rollBack();
          return 10;
       }
       die;

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
        //
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
