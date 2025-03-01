<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\PropertyManagementType as PropertyManagementType;
use App\Models\Project as Project;
use App\Classes\ArrayFunction as ArrayFunction;


class PropertyManagementTypeController extends Controller
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
        $business_type_arr          =$ArrayFunction->business_type_arr;
        $data['business_type_arr']  =$business_type_arr;
        $ManagementType             =PropertyManagementType::where('project_id',$project_id)
                                            ->where('status_active',1)
                                            ->get();
                                            
        $sl=0;
        foreach($ManagementType as $key=>$val)
        {
    
            $data['ManagementType']['id']               =$val->id;
            $data['ManagementType']['business_type']    =$val->business_type;
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

        $property_management_type_info= PropertyManagementType::create($request->all());

        $user_project=Project::find($project_id)->update(array('project_status' => '104'));

        if($property_management_type_info  && $user_project)
        {
           DB::commit();
           return redirect()->route('dashboard');
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
        $request->merge(['updated_by'          =>$user_id]);
        
        DB::beginTransaction();

        //$user_company_info= PropertyManagementType::create($request->all());
        $property_management_type_info=PropertyManagementType::find($id)->update($request->all());



        if($property_management_type_info)
        {
           DB::commit();
           return ['message'=>'Update Successfully'];
        }
        else
        {
            DB::rollBack();
            return ['message'=>'Invalid Operation'];
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
