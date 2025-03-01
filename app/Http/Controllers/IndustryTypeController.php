<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyManagementType as PropertyManagementType;
use App\Models\Project as Project;
use Illuminate\Support\Facades\DB;
use App\Classes\ArrayFunction as ArrayFunction;

class IndustryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_info                  = \Auth::user();
        $project_id                 = $user_info->project_id;
        $user_id                    = $user_info->id;
        $ArrayFunction              =new ArrayFunction();
        $industry_type_arr          =$ArrayFunction->industry_type_arr;
        $data['industry_type_arr']  =$industry_type_arr;
        $ManagementType             =PropertyManagementType::where('project_id',$project_id)
                                            ->where('status_active',1)
                                            ->get();
                                            
        $sl=0;
        foreach($ManagementType as $key=>$val)
        {
    
            $data['ManagementType']['id']               =$val->id;
            $data['ManagementType']['industry_type']    =$val->industry_type;

            $sl++;
        }

        if(empty($data['ManagementType'])) 
            $data['ManagementType']=array();
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
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['user_id'          =>$user_id]);

        
        DB::beginTransaction();
        $update_arr=array(
            'industry_type' => $request->input('industry_type'),
            'updated_by'    => $user_id,
        );

        $property_management_type_info= PropertyManagementType::find($project_id)->update($update_arr);

        $user_project=Project::find($project_id)->update(array('project_status' => '103'));

        if($property_management_type_info  && $user_project)
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
        $user_id    = $user_info->id;
        $project_id = $user_info->project_id;
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['user_id'          =>$user_id]);
        $request->merge(['updated_by'       =>$user_id]);
        
        DB::beginTransaction();


        $property_management_type_info=PropertyManagementType::find($id)->update($request->all());

       
        if($property_management_type_info)
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
