<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module as Module;
use App\Menu as Menu;
use Illuminate\Support\Facades\DB;
use App\Country as Country;
use App\Project as Project;
use App\FileUpload as FileUpload; 
use App\Classes\ArrayFunction as ArrayFunction;  
use App\MailStorage as MailStorage;
use App\User as User;



//use Browser;


class MessageAdminController extends Controller
{
      

    public function index()
    {
  
        $mailnboxType = 1; 
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
            
            
            if(empty($data['user_data'][$val->user_type]['total']))
            {

                $data['user_data'][$val->user_type]['total']=1; 

            }else{

                $data['user_data'][$val->user_type]['total']++; 
            }
            
            $sl++;

        }  

        $Mail_Storage_data=MailStorage::where('project_id',$project_id)->where('status_active',1)
        ->where('mail_sent',1)->get(); 
        $sl=0;
        foreach($Mail_Storage_data as $key=>$val)
        {  
            $data['mail_data'][$val->from_user_type][$sl]['user_type']=$val->from_user_type; 
            if(empty($data['mail_data'][$val->from_user_type]['total']))
            {

                $data['mail_data'][$val->from_user_type]['total']=1; 

            }else{

                $data['mail_data'][$val->from_user_type]['total']++; 
            } 
            $sl++; 
        }   

        $Mail_Storage_data =MailStorage::where('project_id',$project_id)->where('status_active',1)
        ->select('user_id',DB::raw('count(id) as total_mail'))->groupBy('user_id')->get(); //select id,job_category
        $data['posting_item_data']=array();
        // $t=0;
         foreach($Mail_Storage_data as $key=>$val)
         {
           
             $data['Mail_Storage_data'][$val->user_id]=$val->total_mail; 
        } 

       

        $mailStorageDatas = MailStorage::where('project_id', $project_id)
        ->where('status_active', 1)->where('mail_sent', 1)
        ->select('user_id', DB::raw('count(id) as total_mail'))
        ->groupBy('user_id')
        ->get();
        $totalMail = 0;
        foreach($mailStorageDatas as $val) 
        {

            $totalMail += $val->total_mail;
        }
        $data['mailStorageDatas'] =$mailStorageDatas;
        $data['totalMail'] =$totalMail;




       // return view('mail-storage.index', compact('data', 'totalMail'));
    //return view('message.messagesendingAdmin',compact('data', 'totalMail'));
    return view('message.messagesendingAdmin', $data);

        
        
        //return view('dashboard');
    }


    
}
 
 
     