<?php

namespace App\Http\Controllers\Information;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\ArrayFunction as ArrayFunction;

use App\Models\Announcement;

use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_id=$user->id;
        $ArrayFunction              =new ArrayFunction();
        $announcement_status_arr    =$ArrayFunction->announcement_status_arr;
        $data['announcement_status_arr']=$announcement_status_arr; 

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
           // $company_type=$request->session()->get('company_type');
        }
        else {

            return; 
        }

        $announcement_send_list=Announcement::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('inserted_by',"!=",$user_id)
                                        ->whereIn('posting_status', [2, 4])
                                        ->get();


        $data['announcement_send_list']=array(); $sl=0;
        $total_announcement=0;
        foreach ($announcement_send_list as $key => $value) {

            $data['announcement_send_list'][$key]['sl']                     =$sl+1;
            $data['announcement_send_list'][$key]['id']                     =$value->id;
            $data['announcement_send_list'][$key]['system_no']              =$value->system_no;
            $data['announcement_send_list'][$key]['issue_date']             =$value->issue_date;
            $data['announcement_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['announcement_send_list'][$key]['priority']               =$value->priority;
            $data['announcement_send_list'][$key]['status']                 =$value->status;
            $data['announcement_send_list'][$key]['status_string']          =$announcement_status_arr[$value->status];
            $data['announcement_send_list'][$key]['rejection_cause']        =$value->rejection_cause;
            $data['announcement_send_list'][$key]['expire_date']            =$value->expire_date;
            $data['announcement_send_list'][$key]['job_site']               =$value->job_site;            
            $data['announcement_send_list'][$key]['subject']                =$value->subject;
            $data['announcement_send_list'][$key]['details']                =$value->details;
            $data['announcement_send_list'][$key]['dedline_date']           =$value->dedline_date;
            $data['announcement_send_list'][$key]['required_action']        =$value->required_action;
            $data['announcement_send_list'][$key]['instruction']            =$value->instruction;
            $data['announcement_send_list'][$key]['posting_status']         =$value->posting_status;
            $sl++;

        }

        return $data;

    }

    public function AnnouncementList( Request $request,$type)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_id=$user->id;
        $ArrayFunction              =new ArrayFunction();
        $announcement_status_arr    =$ArrayFunction->announcement_status_arr;
        $data['announcement_status_arr']=$announcement_status_arr; 

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        if($type==1)
        {
            $announcement_send_list=Announcement::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('inserted_by',"!=",$user_id)
                                        ->whereIn('posting_status', [2, 4])
                                        ->get();
        }
        else if($type==2)
        {
           
            $announcement_send_list=Announcement::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('posting_status',"<",1)
                                        ->where('inserted_by',$user_id)
                                        ->get();
                                        //->toSql();
                                       // dd($announcement_send_list);
        }
        else if($type==3)
        {
            $announcement_send_list=Announcement::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('inserted_by',"=",$user_id)
                                        ->where('posting_status',">",1)
                                        ->get();
        }
        else if($type==4)
        {
            $announcement_send_list=Announcement::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('archived',"=",$user_id)
                                        ->get();
        }
        else if($type==5)
        {
            $announcement_send_list=Announcement::where('status_active',0)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('inserted_by',"=",$user_id)
                                        ->get();
        }
        else if($type==6)
        {
            $announcement_send_list=Announcement::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('posting_status',"<",1)
                                        ->where('inserted_by',$user_id)
                                        ->get();
        }
        else if($type==7)
        {
            $announcement_send_list=Announcement::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('inserted_by',"=",$user_id)
                                        ->where('posting_status',">",1)
                                        ->get();
        }
        else if($type==8)
        {
            $announcement_send_list=Announcement::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('archived',"=",$user_id)
                                        ->get();
        }
        else if($type==9)
        {
            $announcement_send_list=Announcement::where('status_active',0)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('inserted_by',"=",$user_id)
                                        ->get();
        }

        


        $data['announcement_send_list']=array(); $sl=0;
        foreach ($announcement_send_list as $key => $value) {

            $data['announcement_send_list'][$key]['sl']                     =$sl+1;
            $data['announcement_send_list'][$key]['id']                     =$value->id;
            $data['announcement_send_list'][$key]['system_no']              =$value->system_no;
            $data['announcement_send_list'][$key]['issue_date']             =$value->issue_date;
            $data['announcement_send_list'][$key]['issued_by']              =$value->issued_by;
            $data['announcement_send_list'][$key]['priority']               =$value->priority;
            $data['announcement_send_list'][$key]['status']                 =$value->status;
            $data['announcement_send_list'][$key]['status_string']          =$announcement_status_arr[$value->status];
            $data['announcement_send_list'][$key]['rejection_cause']        =$value->rejection_cause;
            $data['announcement_send_list'][$key]['expire_date']            =$value->expire_date;
            $data['announcement_send_list'][$key]['job_site']               =$value->job_site;            
            $data['announcement_send_list'][$key]['subject']                =$value->subject;
            $data['announcement_send_list'][$key]['details']                =$value->details;
            $data['announcement_send_list'][$key]['dedline_date']           =$value->dedline_date;
            $data['announcement_send_list'][$key]['required_action']        =$value->required_action;
            $data['announcement_send_list'][$key]['instruction']            =$value->instruction;
            $data['announcement_send_list'][$key]['posting_status']         =$value->posting_status;
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
            'issue_date'                => 'required',
            'issued_by'                 => 'required',
            'priority'                  => 'required',
            'status'                    => 'required',
            'expire_date'               => 'required',
            'job_site'                  => 'required',
            'subject'                   => 'required',
            'details'                   => 'required',
            'dedline_date'              => 'required',
            'required_action'           => 'required',
            'instruction'               => 'required',
            
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;

        if($request->input('dedline_date'))
        {
            $dedline_date                    =date("Y-m-d",strtotime($request->input('dedline_date')));
            $request->merge(['dedline_date'  =>$dedline_date]);
        }

        if($request->input('issue_date'))
        {

            if($request->input('issue_time'))
            {
                $issue_time                  =strtotime($request->input('issue_time'))-strtotime(date("Y-m-d"));
            }
            else $issue_time=0;
            $issue_date_time                 =date("Y-m-d H:i:s",(strtotime($request->input('issue_date'))+$issue_time));
        
            $request->merge(['issue_date'    =>$issue_date_time]);
        }


        if($request->input('expire_date'))
        {

            if($request->input('expire_time'))
            {
                $expire_time                  =strtotime($request->input('expire_time'))-strtotime(date("Y-m-d"));
            }
            else $expire_time=0;
            $expire_date                      =date("Y-m-d H:i:s",(strtotime($request->input('expire_date'))+$expire_time));
        
            $request->merge(['expire_date'    =>$expire_date]);
        }


       //dd($request->input('approval_date'));
        
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['posting_status' =>0]);


        $company_id="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }
        $request->merge(['company_id' =>$company_id]);
        
        $year= date("y",strtotime($request->input('issue_date')));
        $year_full= date("Y",strtotime($request->input('issue_date')));
        $max_system_data = Announcement::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from announcements 
            where project_id=".$project_id." and Year(issue_date)=".$year_full." and company_id=".$company_id.") 
             and company_id=".$company_id." and Year(issue_date)=".$year_full."  and project_id=".$project_id)->get(['system_prefix']);

               
       
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }
        
        $system_no="ANN-".$year."-".str_pad($max_system_prefix, 5, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $announcement_info= Announcement::create($request->all());

        if($announcement_info)
        {
           DB::commit();
           return "1**$announcement_info->id**$system_no";
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
    public function edit($id,Request $request)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_id=$user->id;
        $ArrayFunction              =new ArrayFunction();
        $announcement_status_arr    =$ArrayFunction->announcement_status_arr;
        $data['announcement_status_arr']=$announcement_status_arr; 

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
           // $company_type=$request->session()->get('company_type');
        }
        else {

            return; 
        }

        $announcement_send_list=Announcement::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('id',"!=",$id)
                                        ->where('posting_status', "<",1)
                                        ->get();


        $data['announcement_send_list']=array(); $sl=0;
        $total_announcement=0;
        foreach ($announcement_send_list as $key => $value) {

            $data['announcement_send_list']['sl']                     =$sl+1;
            $data['announcement_send_list']['id']                     =$value->id;
            $data['announcement_send_list']['system_no']              =$value->system_no;
            $data['announcement_send_list']['issue_date']             =date("Y-m-d",strtotime($value->issue_date));
            $data['announcement_send_list']['issue_time']             =date("h:i A",strtotime($value->issue_date));
            $data['announcement_send_list']['issued_by']              =$value->issued_by;
            $data['announcement_send_list']['priority']               =$value->priority;
            $data['announcement_send_list']['status']                 =$value->status;
            $data['announcement_send_list']['status_string']          =$announcement_status_arr[$value->status];
            $data['announcement_send_list']['rejection_cause']        =$value->rejection_cause;
            $data['announcement_send_list']['expire_date']            =date("Y-m-d",strtotime($value->expire_date));
            $data['announcement_send_list']['expire_time']            =date("h:i A",strtotime($value->expire_date));
            $data['announcement_send_list']['job_site']               =$value->job_site;            
            $data['announcement_send_list']['subject']                =$value->subject;
            $data['announcement_send_list']['details']                =$value->details;
            $data['announcement_send_list']['dedline_date']           =date("Y-m-d",strtotime($value->dedline_date));
            $data['announcement_send_list']['required_action']        =$value->required_action;
            $data['announcement_send_list']['instruction']            =$value->instruction;
            $data['announcement_send_list']['posting_status']         =$value->posting_status;
            $sl++;

        }

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
            'issue_date'                => 'required',
            'issued_by'                 => 'required',
            'priority'                  => 'required',
            'status'                    => 'required',
            'expire_date'               => 'required',
            'job_site'                  => 'required',
            'subject'                   => 'required',
            'details'                   => 'required',
            'dedline_date'              => 'required',
            'required_action'           => 'required',
            'instruction'               => 'required',
            
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        if($request->input('dedline_date'))
        {
            $dedline_date                    =date("Y-m-d",strtotime($request->input('dedline_date')));
            $request->merge(['dedline_date'  =>$dedline_date]);
        }

        if($request->input('issue_date'))
        {

            if($request->input('issue_time'))
            {
                $issue_time                  =strtotime($request->input('issue_time'))-strtotime(date("Y-m-d"));
            }
            else $issue_time=0;
            $issue_date_time                 =date("Y-m-d H:i:s",(strtotime($request->input('issue_date'))+$issue_time));
        
            $request->merge(['issue_date'    =>$issue_date_time]);
        }


        if($request->input('expire_date'))
        {

            if($request->input('expire_time'))
            {
                $expire_time                  =strtotime($request->input('expire_time'))-strtotime(date("Y-m-d"));
            }
            else $expire_time=0;
            $expire_date                      =date("Y-m-d H:i:s",(strtotime($request->input('expire_date'))+$expire_time));
        
            $request->merge(['expire_date'    =>$expire_date]);
        }

        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['updated_by'           =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);


        $company_id="";
        $company_type="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }


       // $request->merge(['company_id' =>$company_id]);

        DB::beginTransaction();
        $petty_cash_info= Announcement::find($id)->update($request->all());


        if($petty_cash_info)
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
