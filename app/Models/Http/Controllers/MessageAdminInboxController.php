<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Country as Country;
use App\Project as Project;  
use App\Classes\ArrayFunction as ArrayFunction;  
use Illuminate\Support\Facades\Cache; 
use App\User as User;
use Carbon\Carbon;
use App\MailStorage as MailStorage;

class MessageAdminInboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
 
        $mailnboxType = $request->query('mailnbox'); 
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
          
        $Mail_Storage_data =MailStorage::where('project_id',$project_id)->where('status_active',1)
        ->select('user_id',DB::raw('count(id) as total_mail'))->groupBy('user_id')->get(); //select id,job_category
        $data['posting_item_data']               =array();
        // $t=0;
         foreach($Mail_Storage_data as $key=>$val)
         {
            // $data['postinghousing_data'][$t] =$val; 
             $data['Mail_Storage_data'][$val->user_id]=$val->total_mail; 
        } 
        //dd($data['Posting_Job_data']); 
        $n=0;
        $data['Mail_Storage_data_details']               =array();
        foreach($Mail_Storage_data as $key=>$val)
        {
            $data['Mail_Storage_data_details'][$n] =$val; 
            $n++;
        }  
        if($mailnboxType==1)
        {
            $Mail_Storage_details_data_floow =MailStorage::where('project_id',$project_id)->where('status_active',1)->where('mail_sending_point',1)->where('mail_sent',2)->get(); 
        }
        if($mailnboxType==2)
        {
            $Mail_Storage_details_data_floow =MailStorage::where('project_id',$project_id)->where('status_active',1)->where('mail_sending_point',1)->where('mail_sent',1)->get(); 
        }
        if($mailnboxType==3)
        {
            $Mail_Storage_details_data_floow =MailStorage::where('project_id',$project_id)->where('status_active',1)->where('mail_sending_point',3)->get(); 
        }
        if($mailnboxType==4)
        {
            $Mail_Storage_details_data_floow =MailStorage::where('project_id',$project_id)->where('status_active',1)->where('mail_sending_point',4)->get(); 
        }
       


        $data['Inbox_Mail_Storage_data']               =array();
        $sl=0;
        $total_mail=0;
        foreach($Mail_Storage_details_data_floow as $key=>$val)
        {
            $data['Inbox_Mail_Storage_data'][$sl] =$val; 
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
        //
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

    public function adminDelete(Request $request, $id)
    {

      //  dd($id); die;
        DB::beginTransaction();

        $mail_delete=MailStorage::find($id)->update(array('status_active' =>0));


    
        if($mail_delete)
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
