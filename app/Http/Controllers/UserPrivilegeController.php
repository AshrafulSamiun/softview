<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User as User;
use App\Models\UserPrivilege as UserPrivilege;
use App\Models\UserPrivilegeMaster;
use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\JobSite;
use App\Models\AccountHolderCustomer;
use App\Models\Services\CommonService;


class UserPrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }
    public function index(Request $request)
    {
        $user                       =\Auth::user();
        $user_id                    = $user->id;
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        $ArrayFunction              =new ArrayFunction();
        $project_status             =$ArrayFunction->project_status;
        $site_type_arr              =$ArrayFunction->site_type_arr;
        $user_type_arr              =$ArrayFunction->user_type_arr;
        $user_role_arr              =$ArrayFunction->user_role_arr;
        
        $site_id="";
        if($request->session()->has('site_avaibale'))
        {
            $site_id=$request->session()->get('site_id');
           
        }
        $data['site_id'] =$site_id;

        $job_site_data=JobSite::where('project_id',$project_id)
                                        ->where('id',$site_id)
                                        ->where('status_active',1)
                                        ->get();
        $sl=0;
        foreach ($job_site_data as $key => $value) {

            $data['job_site_list'][$value->id]['sl']                    =$sl+1;
            $data['job_site_list'][$value->id]['id']                    =$value->id;
            $data['job_site_list'][$value->id]['system_no']             =$value->system_no;
            $data['job_site_list'][$value->id]['site_name']             =$value->site_name;
            $data['job_site_list'][$value->id]['company_id']            =$value->company_id;
            $data['job_site_list'][$value->id]['company_type']          =$value->company_type;
           
            $data['job_site_list'][$value->id]['site_type_string']      =$site_type_arr[$value->current_status];
            $data['job_site_list'][$value->id]['current_status_string'] =$project_status[$value->current_status];
            $data['job_site_list'][$value->id]['customer_name']         =$value->customer->customer_name;
            //$data['job_site_list'][$key]['contractor_name']       =$value->contractor->service_provider_name;
            $sl++;
        }


        $user_menus=DB::table('menus as a')
                            ->where('a.status', '=', 1)
                            ->orderBy('position', 'ASC')
                            ->orderBy('slno','ASC')
                            ->get();
        $lavel_one_arr=array();
        $lavel_two_arr=array();
        $lavel_three_arr=array();


        foreach ($user_menus as $key => $value) {
            if($value->position==2)
            {
                $lavel_one_arr[$value->rootMenu][$value->id]['menuName']=$value->menuName;
                $lavel_one_arr[$value->rootMenu][$value->id]['menuRoute']=$value->menuRoute;
                if(!empty($lavel_one_arr[$value->rootMenu]['total']))
                    $lavel_one_arr[$value->rootMenu]['total']++;
                else $lavel_one_arr[$value->rootMenu]['total']=1;
            }
            else if($value->position==3)
            {
                $lavel_two_arr[$value->rootMenu][$value->id]['menuName']=$value->menuName;
                $lavel_two_arr[$value->rootMenu][$value->id]['menuRoute']=$value->menuRoute;
                 
                if(!empty($lavel_two_arr[$value->rootMenu]['total']))
                    $lavel_two_arr[$value->rootMenu]['total']++;
                else $lavel_two_arr[$value->rootMenu]['total']=1;
            }
            else if($value->position==4)
            {
                $lavel_three_arr[$value->rootMenu][$value->id]['menuName']=$value->menuName;
                $lavel_three_arr[$value->rootMenu][$value->id]['menuRoute']=$value->menuRoute;
                
                if(!empty($lavel_three_arr[$value->rootMenu]['total']))
                    $lavel_three_arr[$value->rootMenu]['total']++;
                else $lavel_three_arr[$value->rootMenu]['total']=1;
            }       
        }

        $data['user_type']          =$user_type;
        $data['lavel_one_arr']      =$lavel_one_arr;
        $data['lavel_two_arr']      =$lavel_two_arr;
        $data['lavel_three_arr']    =$lavel_three_arr;
        $data['user_role_arr']      =$user_role_arr;
        $data['user_type_arr']      =$user_type_arr;
        $data['menu_arr']           =$user_menus;
       return $data;
    }

    public function UserPermission($menu_name)
    {
        $user_id = \Auth::user()->id;

        $user_permission=DB::table('user_privileges as a')
                            ->join('menus as b','a.main_menu_id','=','b.id')
                            ->where('b.menuRoute', '=', $menu_name)
                            ->where('b.status', '=', 1)
                            ->where('a.status_active', '=', 1)
                            ->where('a.is_deleted', '=', 0)
                            ->where('a.user_id','=',$user_id)
                            ->select('b.id','a.show_priv','a.save_priv','a.approve_priv','a.update_priv','a.delete_priv','a.post_priv','a.adjust_priv')
                            ->get();
                         
       $data['user_permission']=$user_permission;
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

    public function UserPrivilegeList(Request $request)
    {
        $site_id="";
        if($request->session()->has('site_avaibale'))
        {
            $site_id=$request->session()->get('site_id');
           
        }
        $data['site_id'] =$site_id;

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $user_type_arr              =$ArrayFunction->user_type_arr;
        $user_role_arr              =$ArrayFunction->user_role_arr;
        //===================Company==========================================

        $customer_sql                               =AccountHolderCustomer::where('status_active',1)
                                                        ->where('project_id',$project_id)
                                                        ->get();

        $customer_arr=array();
        foreach($customer_sql as $val)
        {
            $customer_arr[$val->id]=$val->customer_name;
        }

        $ArrayFunction                          =new ArrayFunction();      
        $privilege_sql                          =UserPrivilegeMaster::where('project_id',$project_id)
                                                    ->where('is_deleted',0);
        if($site_id)
        {
            $privilege_sql->where('job_site_id',$site_id);
        }
                                                   
        $privilege_data=$privilege_sql->get();

        $sl=0;
        foreach ($privilege_data as $key => $value) {
 
            $data['privelige_master_list'][$key]['sl']                  =$sl+1;
            $data['privelige_master_list'][$key]['id']                  =$value->id;
            $data['privelige_master_list'][$key]['system_no']           =$value->system_no;
            $data['privelige_master_list'][$key]['file_name']           =$value->jobSite->system_no;
            $data['privelige_master_list'][$key]['job_site_name']       =$value->jobSite->site_name;
            $data['privelige_master_list'][$key]['user_type_string']    =$user_type_arr[$value->user_type];
            $data['privelige_master_list'][$key]['user_role_string']    =$user_role_arr[$value->user_role];
            $data['privelige_master_list'][$key]['company_id']          =$value->company_id;
            $data['privelige_master_list'][$key]['user_name']           =$value->User->name;

            $data['privelige_master_list'][$key]['company_type']        =$value->company_type;
           //dd($this->commonService->getCompanyName($value->company_id,$value->company_type)) ;
            $data['privelige_master_list'][$key]['company_name']        =$this->commonService->getCompanyName($value->company_id,$value->company_type);
            $sl++;
        }
        //dd($data['fixed_asset_list']);

        return $data;

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
            'job_site_id'   => 'required',
            'user_type'     => 'required',
            'user_role'     => 'required',
            'user_id'       => 'required',
            'expire_date'   => 'required',
            'expire_time'   => 'required',
        ]);

       
        $inserted_by    = \Auth::user()->id;
        $project_id     = \Auth::user()->project_id;
        $job_site_id    =$request->input('job_site_id');
        $request->merge(['inserted_by' =>$inserted_by]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['posting_status'=>0]);
        $request->merge(['status_active'=>1]);
        $request->merge(['is_deleted'=>0]);
        
        if($request->input('expire_date'))
        {
            $expire_date                           =date("Y-m-d",strtotime($request->input('expire_date')));
            $request->merge(['expire_date'         =>$expire_date]);
        }

        if($request->input('expire_time'))
        {
            $expire_time                          =date("H:i:s",strtotime($request->input('expire_time')));
            $request->merge(['expire_time'        =>$expire_time]);
        }

        $max_system_data = UserPrivilegeMaster::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from user_privilege_masters where  project_id=".$project_id." and job_site_id=".$job_site_id." ) and job_site_id=".$job_site_id." and project_id=".$project_id)->get(['system_prefix']);
                              
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }
        $system_no="UP-".str_pad($max_system_prefix, 5, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);
       
        DB::beginTransaction();
        $priv_info= UserPrivilegeMaster::create($request->all());

        foreach($request->details as $key=>$details)
        {

            if($details['access_day_from'])
            {
                $access_day_from                   =date("H:i:s",strtotime($details['access_day_from']));
                $details['access_day_from']        =$access_day_from;
            }

            if($details['access_time_end'])
            {
                $access_time_end                    =date("H:i:s",strtotime($details['access_time_end']));
                $details['access_time_end']         =$access_time_end;
            }

            if($details['expire_date'])
            {
                $expire_date                        =date("Y-m-d",strtotime($details['expire_date']));
                $details['expire_date']             =$expire_date;
            }

            
            $PrivData[]= array(
                'mst_id'            =>$priv_info->id,
                'main_menu_id'      =>$details['main_menu_id'],
                'user_id'           =>$request->input('user_id'),
                'project_id'        =>$project_id,
                'show_priv'         =>$details['show_priv'],
                'new_priv'          =>$details['new_priv'],
                'save_priv'         =>$details['save_priv'],
                'update_priv'       =>$details['update_priv'],
                'delete_priv'       =>$details['delete_priv'],
                'transmit_priv'     =>$details['transmit_priv'],
                'post_priv'         =>$details['post_priv'],
                'void_priv'         =>$details['void_priv'],
                'adjust_priv'       =>$details['adjust_priv'],
                'print_priv'        =>$details['print_priv'],
                'all_priv'          =>$details['all_priv'],
                'access_day_from'   =>$details['access_day_from'],
                'access_day_to'     =>$details['access_day_to'],
                'access_time_start' =>$details['access_time_start'],
                'access_time_end'   =>$details['access_time_end'],
                'expire_date'       =>$details['expire_date'],
                'inserted_by'       =>$inserted_by,
                'status_active'     =>$details['status_active'],
                'is_deleted'        =>$details['is_deleted'],
            ); 
        }
                       
        if(!empty($PrivData))
        {
            $RID=UserPrivilege::insert($PrivData);
        }

        if($priv_info && $RID)
        {
           DB::commit();
           return "1**$priv_info->id**$system_no";
        }
        else
        {
            DB::rollBack();
           return "10**";
        }

        return $RId;
        return "0**";
       
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
    
    public function edit($id, Request $request)
    {
        $user=\Auth::user();
        $project_id                     = $user->project_id;
        $user_type                      = $user->user_type;
        $data['user_type']              =$user_type;
        
        $ArrayFunction                  =new ArrayFunction();
        $user_type_arr              =$ArrayFunction->user_type_arr;
        $user_role_arr              =$ArrayFunction->user_role_arr;

        $privilege_sql                  =UserPrivilegeMaster::where('project_id',$project_id)
                                                    ->where('id',$id)
                                                    ->get();
      
        $sl=0;$user_type=0;$user_id=0;
        foreach ($privilege_sql as $key => $value) {
 
            $data['privelige_master_list']['sl']                  =$sl+1;
            $data['privelige_master_list']['id']                  =$value->id;
            $data['privelige_master_list']['system_no']           =$value->system_no;
            $data['privelige_master_list']['file_name']           =$value->jobSite->system_no;
            $data['privelige_master_list']['site_name']           =$value->jobSite->site_name;
            $data['privelige_master_list']['job_site_id']         =$value->jobSite->id;
            $data['privelige_master_list']['user_type']           =$value->user_type;
            $data['privelige_master_list']['user_role']           =$value->user_role;
            $data['privelige_master_list']['user_id']             =$value->user_id;
            $data['privelige_master_list']['company_id']          =$value->company_id;
            $data['privelige_master_list']['user_name']           =$value->User->name;
            $data['privelige_master_list']['user_type']           =$value->User->user_type;
            $data['privelige_master_list']['expire_date']         =$value->expire_date;
            $data['privelige_master_list']['expire_time']         =date("h:i A",strtotime($value->expire_time));
            $data['privelige_master_list']['posting_status']      =$value->posting_status;
            $data['privelige_master_list']['status_active']      =$value->status_active;
            $data['privelige_master_list']['company_type']        =$value->company_type;
            $data['privelige_master_list']['insert_at']           =$value->created_at->format('D, M d, Y');
            $data['privelige_master_list']['company_name']        =$this->commonService->getCompanyName($value->company_id,$value->company_type);
            $sl++;
            $user_type=$value->User->user_type;
            $user_id=$value->user_id;
        }

        $user_data=User::where('project_id','=',$project_id)
                         ->where('user_type','=',$user_type)
                         ->select('id','name')->get();

        $data['user_data']=$user_data;

        if(empty($data['user_data'])) $data['user_data']=array();

        $user_permission=DB::table('user_privileges as a')
                            ->join('menus as b','a.main_menu_id','=','b.id')
                            ->where('b.status', '=', 1)
                            ->where('a.status_active', '=', 1)
                            ->where('a.mst_id', '=', $id)
                            ->where('a.is_deleted', '=', 0)
                            ->where('a.user_id','=',$user_id)
                            ->select('b.id as main_menu_id','b.menuName','b.rootMenu','b.position','b.slno','a.*')
                            ->get();
                         
       $data['menu_arr']=$user_permission;

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
            'job_site_id'   => 'required',
            'user_type'     => 'required',
            'user_role'     => 'required',
            'user_id'       => 'required',
            'expire_date'   => 'required',
            'expire_time'   => 'required',
        ]);


        $inserted_by    = \Auth::user()->id;
        $project_id     = \Auth::user()->project_id;
        $job_site_id    =$request->input('job_site_id');
        $request->merge(['updated_by' =>$inserted_by]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['posting_status'=>0]);
        $request->merge(['status_active'=>1]);
        $request->merge(['is_deleted'=>0]);

        if($request->input('expire_date'))
        {
            $expire_date                           =date("Y-m-d",strtotime($request->input('expire_date')));
            $request->merge(['expire_date'         =>$expire_date]);
        }

        if($request->input('expire_time'))
        {
            $expire_time                          =date("H:i:s",strtotime($request->input('expire_time')));
            $request->merge(['expire_time'        =>$expire_time]);
        }

        DB::beginTransaction();
        $user_priv_info= UserPrivilegeMaster::find($id)->update($request->all());

        foreach($request->details as $key=>$details)
        {

            if($details['access_day_from'])
            {
                $access_day_from                   =date("H:i:s",strtotime($details['access_day_from']));
                $details['access_day_from']        =$access_day_from;
            }

            if($details['access_time_end'])
            {
                $access_time_end                    =date("H:i:s",strtotime($details['access_time_end']));
                $details['access_time_end']         =$access_time_end;
            }

            if($details['expire_date'])
            {
                $expire_date                        =date("Y-m-d",strtotime($details['expire_date']));
                $details['expire_date']             =$expire_date;
            }

            if($details['id']>0)
            {
                $details_data_update= array(
                    'mst_id'            =>$id,
                    'main_menu_id'      =>$details['main_menu_id'],
                    'user_id'           =>$request->input('user_id'),
                    'project_id'        =>$project_id,
                    'show_priv'         =>$details['show_priv'],
                    'new_priv'          =>$details['new_priv'],
                    'save_priv'         =>$details['save_priv'],
                    'update_priv'       =>$details['update_priv'],
                    'delete_priv'       =>$details['delete_priv'],
                    'transmit_priv'     =>$details['transmit_priv'],
                    'post_priv'         =>$details['post_priv'],
                    'void_priv'         =>$details['void_priv'],
                    'adjust_priv'       =>$details['adjust_priv'],
                    'print_priv'        =>$details['print_priv'],
                    'all_priv'          =>$details['all_priv'],
                    'access_day_from'   =>$details['access_day_from'],
                    'access_day_to'     =>$details['access_day_to'],
                    'access_time_start' =>$details['access_time_start'],
                    'access_time_end'   =>$details['access_time_end'],
                    'expire_date'       =>$details['expire_date'],
                    'updated_by'        =>$inserted_by,
                );

                $productData=UserPrivilege::where('id',"=",$details['id'])->update($details_data_update);
                if( !$productData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
                
            }
            else
            {

                $PrivData[]= array(
                    'mst_id'            =>$id,
                    'main_menu_id'      =>$details['main_menu_id'],
                    'user_id'           =>$request->input('user_id'),
                    'project_id'        =>$project_id,
                    'show_priv'         =>$details['show_priv'],
                    'new_priv'          =>$details['new_priv'],
                    'save_priv'         =>$details['save_priv'],
                    'update_priv'       =>$details['update_priv'],
                    'delete_priv'       =>$details['delete_priv'],
                    'transmit_priv'     =>$details['transmit_priv'],
                    'post_priv'         =>$details['post_priv'],
                    'void_priv'         =>$details['void_priv'],
                    'adjust_priv'       =>$details['adjust_priv'],
                    'print_priv'        =>$details['print_priv'],
                    'all_priv'          =>$details['all_priv'],
                    'access_day_from'   =>$details['access_day_from'],
                    'access_day_to'     =>$details['access_day_to'],
                    'access_time_start' =>$details['access_time_start'],
                    'access_time_end'   =>$details['access_time_end'],
                    'expire_date'       =>$details['expire_date'],
                    'inserted_by'       =>$inserted_by,
                    'status_active'     =>$details['status_active'],
                    'is_deleted'        =>$details['is_deleted'],
                ); 
            }
        }
        $RID=true;             
        if(!empty($PrivData))
        {
            $RID=UserPrivilege::insert($PrivData);
        }
        
        if($user_priv_info && $RID)
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
        $calendar_info= UserPrivilegeMaster::find($id)->update(['updated_by'=>$user_id,'status_active'=>0,'is_deleted'=>1]);       

        $update_data= array(
                        
                            'status_active'             =>0,
                            'is_deleted'                =>1,
                            'updated_by'                =>$user_id,
                        );

        $petty_cash_delete=UserPrivilege::where('mst_id',"=",$id)->update($update_data);
        if($calendar_info)
        {           DB::commit();
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
      
        $buildingInfo=UserPrivilegeMaster::where('id',"=",$id)->update($update_data);

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
                        );
      
        $buildingInfo=UserPrivilegeMaster::where('id',"=",$id)->update($update_data);

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
      
        $buildingInfo=UserPrivilegeMaster::where('id',"=",$id)->update($update_data);

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
            'job_site_id'   => 'required',
            'user_type'     => 'required',
            'user_role'     => 'required',
            'user_id'       => 'required',
            'expire_date'   => 'required',
            'expire_time'   => 'required',
        ]);

        if($request->input('expire_date'))
        {
            $expire_date                           =date("Y-m-d",strtotime($request->input('expire_date')));
            $request->merge(['expire_date'         =>$expire_date]);
        }

        if($request->input('expire_time'))
        {
            $expire_time                          =date("H:i:s",strtotime($request->input('expire_time')));
            $request->merge(['expire_time'        =>$expire_time]);
        }



        $inserted_by    = \Auth::user()->id;
        $project_id     = \Auth::user()->project_id;
        $job_site_id    =$request->input('job_site_id');
        $request->merge(['updated_by' =>$inserted_by]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['posting_status'=>3]);
        $request->merge(['status_active'=>1]);
        $request->merge(['is_deleted'=>0]);


        DB::beginTransaction();
        $user_priv_info= UserPrivilegeMaster::find($id)->update($request->all());

        foreach($request->details as $key=>$details)
        {

            if($details['access_day_from'])
            {
                $access_day_from                   =date("H:i:s",strtotime($details['access_day_from']));
                $details['access_day_from']        =$access_day_from;
            }

            if($details['access_time_end'])
            {
                $access_time_end                    =date("H:i:s",strtotime($details['access_time_end']));
                $details['access_time_end']         =$access_time_end;
            }

            if($details['expire_date'])
            {
                $expire_date                        =date("Y-m-d",strtotime($details['expire_date']));
                $details['expire_date']             =$expire_date;
            }

            if($details['id']>0)
            {
                $details_data_update= array(
                    'mst_id'            =>$id,
                    'main_menu_id'      =>$details['main_menu_id'],
                    'user_id'           =>$request->input('user_id'),
                    'project_id'        =>$project_id,
                    'show_priv'         =>$details['show_priv'],
                    'new_priv'          =>$details['new_priv'],
                    'save_priv'         =>$details['save_priv'],
                    'update_priv'       =>$details['update_priv'],
                    'delete_priv'       =>$details['delete_priv'],
                    'transmit_priv'     =>$details['transmit_priv'],
                    'post_priv'         =>$details['post_priv'],
                    'void_priv'         =>$details['void_priv'],
                    'adjust_priv'       =>$details['adjust_priv'],
                    'print_priv'        =>$details['print_priv'],
                    'all_priv'          =>$details['all_priv'],
                    'access_day_from'   =>$details['access_day_from'],
                    'access_day_to'     =>$details['access_day_to'],
                    'access_time_start' =>$details['access_time_start'],
                    'access_time_end'   =>$details['access_time_end'],
                    'expire_date'       =>$details['expire_date'],
                    'updated_by'        =>$inserted_by,
                );

                $productData=UserPrivilege::where('id',"=",$details['id'])->update($details_data_update);
                if( !$productData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
                
            }
            else
            {

                $PrivData[]= array(
                    'mst_id'            =>$id,
                    'main_menu_id'      =>$details['main_menu_id'],
                    'user_id'           =>$request->input('user_id'),
                    'project_id'        =>$project_id,
                    'show_priv'         =>$details['show_priv'],
                    'new_priv'          =>$details['new_priv'],
                    'save_priv'         =>$details['save_priv'],
                    'update_priv'       =>$details['update_priv'],
                    'delete_priv'       =>$details['delete_priv'],
                    'transmit_priv'     =>$details['transmit_priv'],
                    'post_priv'         =>$details['post_priv'],
                    'void_priv'         =>$details['void_priv'],
                    'adjust_priv'       =>$details['adjust_priv'],
                    'print_priv'        =>$details['print_priv'],
                    'all_priv'          =>$details['all_priv'],
                    'access_day_from'   =>$details['access_day_from'],
                    'access_day_to'     =>$details['access_day_to'],
                    'access_time_start' =>$details['access_time_start'],
                    'access_time_end'   =>$details['access_time_end'],
                    'expire_date'       =>$details['expire_date'],
                    'inserted_by'       =>$inserted_by,
                    'status_active'     =>$details['status_active'],
                    'is_deleted'        =>$details['is_deleted'],
                ); 
            }
        }
        $RID=true;             
        if(!empty($PrivData))
        {
            $RID=UserPrivilege::insert($PrivData);
        }
        
        if($user_priv_info && $RID)
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
      
        $buildingInfo=UserPrivilegeMaster::where('id',"=",$id)->update($update_data);

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
