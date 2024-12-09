<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Project as Project;
use App\keyPositionLavel as keyPositionLavel;
use App\keyPosition as keyPosition;


class AccountContactPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_info          = \Auth::user();
        $project_id         = $user_info->project_id;
        $key_position_lavel=keyPositionLavel::where('status_active',1)
                                    ->whereIn('project_id',[0,$project_id])
                                    ->where('page_id',2)
                                    ->get();
        foreach ($key_position_lavel as $key => $value) {
            $key_position_lavel_arr[$value->id]['reference_id']        =$value->id;
            $key_position_lavel_arr[$value->id]['reference_value']     =$value->field_name;
            $key_position_lavel_arr[$value->id]['key_position_name']   ='';
            $key_position_lavel_arr[$value->id]['office_phone']        ='';
            $key_position_lavel_arr[$value->id]['email']               ='';
            $key_position_lavel_arr[$value->id]['id']                  ='';
        }
 
        $key_position_lavel=keyPosition::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('page_id',2)
                                    ->get();
        $editmode=false;
        foreach ($key_position_lavel as $key => $value) {
            $key_position_lavel_arr[$value->reference_id]['reference_id']        =$value->reference_id;
            $key_position_lavel_arr[$value->reference_id]['reference_value']     =$value->reference_value;
            $key_position_lavel_arr[$value->reference_id]['key_position_name']   =$value->key_position_name;
            $key_position_lavel_arr[$value->reference_id]['office_phone']        =$value->office_phone;
            $key_position_lavel_arr[$value->reference_id]['email']               =$value->email;
            $key_position_lavel_arr[$value->reference_id]['id']                  =$value->id;
            $editmode=true;
        }
    
        $sl=0;
        foreach ($key_position_lavel_arr as $key => $value) {
            $key_position_lavel_temp_arr[$sl]['reference_id']        =$value['reference_id'];
            $key_position_lavel_temp_arr[$sl]['reference_value']     =$value['reference_value'];
            $key_position_lavel_temp_arr[$sl]['key_position_name']   =$value['key_position_name'];
            $key_position_lavel_temp_arr[$sl]['office_phone']        =$value['office_phone'];
            $key_position_lavel_temp_arr[$sl]['email']               =$value['email'];
            $key_position_lavel_temp_arr[$sl]['id']                  =$value['id'];
            $sl++;
        }


        $data['editmode']                      =$editmode;
        $data['key_position_lavel_arr']        =$key_position_lavel_temp_arr;
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

            
        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
       
        DB::beginTransaction();

        
        foreach($request->key_management_list_arr as $key=>$details)
        {
            if($details['key_position_name']!="")
            {
                $data_key_position[]= array(
                    'project_id'                =>$project_id,
                    'page_id'                   =>2,
                    'master_id'                 =>0,
                    'reference_id'              =>$details['reference_id'],
                    'reference_value'           =>$details['reference_value'],
                    'office_phone'              =>$details['office_phone'],
                    'key_position_name'         =>$details['key_position_name'],
                    'email'                     =>$details['email'],
                    'inserted_by'               =>$user_id,
                );  
            }        
        }

        $RId1=false;
        if(!empty($data_key_position))
        {
            $RId1=keyPosition::insert($data_key_position);
        }

        $user_project=Project::find($project_id)->update(array('project_status' => '99'));

        if($user_project  && $RId1)
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
        
        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        DB::beginTransaction();
        
        foreach($request->key_management_list_arr as $key=>$details)
        {
            if($details['key_position_name']!="")
            {
                if($details['id']!="")
                {
                    $key_position_data= array(
                        'project_id'                =>$project_id,
                        'page_id'                   =>2,
                        'master_id'                 =>0,
                        'reference_id'              =>$details['reference_id'],
                        'reference_value'           =>$details['reference_value'],
                        'office_phone'              =>$details['office_phone'],
                        'key_position_name'         =>$details['key_position_name'],
                        'email'                     =>$details['email'],
                        'updated_by'                =>$user_id,
                    ); 

                    $RId4=keyPosition::where('id',"=",$details['id'])->update($key_position_data);

                }
                else{

                    $data_key_position[]= array(
                        'project_id'                =>$project_id,
                        'page_id'                   =>2,
                        'master_id'                 =>0,
                        'reference_id'              =>$details['reference_id'],
                        'reference_value'           =>$details['reference_value'],
                        'office_phone'              =>$details['office_phone'],
                        'key_position_name'         =>$details['key_position_name'],
                        'email'                     =>$details['email'],
                        'inserted_by'               =>$user_id,
                    );
                }  
            }        
        }
        $RId1=true;
        if(!empty($data_key_position))
        {
            $RId1=keyPosition::insert($data_key_position);
        }

        if($RId1)
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
