<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\AccountHolderCustomer;
use App\Models\JobSite;
use Illuminate\Support\Facades\DB;

class JobSiteController extends Controller
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
        $user_type                  = $user->user_type;
        $data['user_type']          =$user_type;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        
        //===================Company==========================================
        
        $ArrayFunction              =new ArrayFunction();
        $project_status             =$ArrayFunction->project_status;
        $site_type_arr               =$ArrayFunction->site_type_arr;

        $customer_sql               =AccountHolderCustomer::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            // ->where('company_id',$company_id)
                                            ->get();
                 
        $data['site_type_arr']                   =$site_type_arr;
        $data['site_status_arr']                 =$project_status;
        $data['customer_arr']                    =$customer_sql;
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

    public function JobSiteLists(Request $request)
    {
       
        $user=\Auth::user();
        $project_id                             = $user->project_id;
        //===================Company==========================================

        $ArrayFunction              =new ArrayFunction();
        $project_status             =$ArrayFunction->project_status;
        $site_type_arr              =$ArrayFunction->site_type_arr;
       
        $job_site_data=JobSite::where('project_id',$project_id)
                                        // ->where('company_id',$company_id)
                                        ->where('status_active',1)
                                        ->get();

        $sl=0;
        foreach ($job_site_data as $key => $value) {

            $data['job_site_list'][$key]['sl']                    =$sl+1;
            $data['job_site_list'][$key]['id']                    =$value->id;
            $data['job_site_list'][$key]['system_no']             =$value->system_no;
            $data['job_site_list'][$key]['site_name']             =$value->site_name;
            $data['job_site_list'][$key]['company_id']            =$value->company_id;
            $data['job_site_list'][$key]['company_type']          =$value->company_type;
           
            $data['job_site_list'][$key]['site_type_string']      =$site_type_arr[$value->current_status];
            $data['job_site_list'][$key]['current_status_string'] =$project_status[$value->current_status];
            $data['job_site_list'][$key]['customer_name']         =$value->customer->customer_name;
            //$data['job_site_list'][$key]['contractor_name']       =$value->contractor->service_provider_name;
            $sl++;
        }


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
            'site_name' => 'required',
            'current_status' => 'required',
            'customer_no' => 'required',
            'site_type' => 'required',
            
        ]);
     
        $final_delivery_date                    =date("Y-m-d",strtotime($request->input('final_delivery_date')));

        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);
       // $request->merge(['company_id'           =>$company_id]);
        $request->merge(['posting_status'       =>0]);
        $request->merge(['final_delivery_date'  =>$final_delivery_date]);

        $max_system_data = JobSite::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from job_sites 
            where  project_id=".$project_id." and YEAR(created_at)=".date('Y')." ) 
            and  YEAR(created_at)=".date('Y')."  and project_id=".$project_id)->get(['system_prefix']);
               // ->toSql(); and floor_no=".$request->input('floor_no')."

               
       // dd($max_system_data);die;
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="JS-".date('Y')."-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);
       // dd( $request->all());
        DB::beginTransaction();
        $job_info= JobSite::create($request->all());        
    
        if($job_info)
        {
           DB::commit();
           return "1**$job_info->id**$system_no";
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
    public function edit($id, Request $request)
    {
        $user=\Auth::user();
        $project_id                     = $user->project_id;
        $user_type                      = $user->user_type;
        $data['user_type']              =$user_type;
        
        $ArrayFunction                  =new ArrayFunction();
        $project_status                 =$ArrayFunction->project_status;
        $site_type_arr                  =$ArrayFunction->site_type_arr;      

        $job_site_list                  =JobSite::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            // ->where('company_id',$company_id)
                                            ->where('id',$id)
                                            ->first();


        $data['customer']               =$job_site_list->customer;
        $data['job_site_arr']           =$job_site_list;

    
        $customer_sql                   =AccountHolderCustomer::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            // ->where('company_id',$company_id)
                                            ->get();

           
        $data['site_type_arr']          =$site_type_arr;
        $data['site_status_arr']        =$project_status;
        $data['customer_arr']           =$customer_sql;
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
        // if($request->session()->has('company_avaibale'))
        // {
        //     $company_id=$request->session()->get('company_id');
        // }
        // else {

        //     return "10**200"; 
        // }

         request()->validate([
            'site_name' => 'required',
            'current_status' => 'required',
            'customer_no' => 'required',
            'site_type' => 'required',
            
        ]);



        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['updated_by '          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);
       // $request->merge(['company_id'           =>$company_id]);
        $request->merge(['posting_status'       =>0]);
      

        DB::beginTransaction();
        $job_info= JobSite::find($id)->update($request->all());
        
        if($job_info)
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
        $job_info= JobSite::find($id)->update(['updated_by'=>$user_id,'status_active'=>0,'is_deleted'=>1]);       

        if($job_info)
        {           DB::commit();
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

        // if($request->session()->has('company_avaibale'))
        // {
        //     $company_id=$request->session()->get('company_id');
        // }
        // else {

        //     return "10**200"; 
        // }

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>$request->input("posting_status"),
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=JobSite::where('id',"=",$id)->update($update_data);

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
        // if($request->session()->has('company_avaibale'))
        // {
        //     $company_id=$request->session()->get('company_id');
        // }
        // else {

        //     return "10**200"; 
        // }

         request()->validate([
            'site_name' => 'required',
            'current_status' => 'required',
            'customer_no' => 'required',
            'site_type' => 'required',
            
        ]);



        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
       

        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        //$request->merge(['company_id' =>$company_id]);
        $request->merge(['posting_status'   =>3]);


        DB::beginTransaction();
        $job_info= JobSite::find($id)->update($request->all());
           

        if($job_info)
        {
           DB::commit();
           return "1**$id";
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
      
        $buildingInfo=JobSite::where('id',"=",$id)->update($update_data);

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
