<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Models\Country as Country;
use App\Models\Project as Project;  
use App\Classes\ArrayFunction as ArrayFunction;  
use Illuminate\Support\Facades\Cache; 
use App\Models\User as User;
use Carbon\Carbon;
use App\Models\MailStorage as MailStorage;

class MessageAdminMessageViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
 
        $user=\Auth::user(); 
        $mailnboxType = $request->query('mailnbox'); 
        $id = $request->query('id'); 
       // $mailnboxType = $request->query('mailnbox'); 
        // $mailnbox2 = $request->input('param2');
        // dd($mailnboxType); die;  
       
        $project_id                 = $user->project_id; 
        $project_info               = Project::find($project_id); 
        $data['project_name']       =$project_info->project_name;
        $ArrayFunction              =new ArrayFunction();
        $user_type_arr              =$ArrayFunction->user_type_arr;   

        $row_status             =$ArrayFunction->row_status;
        $user_type_arr          =$ArrayFunction->user_type_arr;
        $data['row_status']=$row_status;
        $data['user_type_arr']=$user_type_arr; 
         
        if($mailnboxType==4)
        {
            $Mail_Storage_details_data_floow =MailStorage::where('project_id',$project_id)->where('status_active',1)->where('mail_sending_point',1)->where('id',$id)->get(); 
        } 

        $data['Inbox_Mail_Storage_data']               =array();
        $sl=0;
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
