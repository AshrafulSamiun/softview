<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\TowerInspectionList as TowerInspectionList;
use Illuminate\Http\Request;

class TowserInspectionChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ArrayFunction          =new ArrayFunction();
        $row_status             =$ArrayFunction->row_status;
        $yes_no                 =$ArrayFunction->yes_no;
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $Tower_data=TowerInspectionList::where('status_active',1)->where('project_id',$project_id)->get();

        $sl=0;
        foreach($Tower_data as $key=>$val)
        {
    
            $data['tower_inspection_data'][$sl]['id']                      =$val->id;
            $data['tower_inspection_data'][$sl]['sl']                      =$sl+1;
            $data['tower_inspection_data'][$sl]['room_name']               =$val->room_name;
            $data['tower_inspection_data'][$sl]['inspection_task']        =$val->inspection_task;
            $data['tower_inspection_data'][$sl]['frequench_check']         =$val->frequench_check;
            $data['tower_inspection_data'][$sl]['inspection_by']           =$val->inspection_by;
            $data['tower_inspection_data'][$sl]['send_report_to']          =$val->send_report_to;
            $data['tower_inspection_data'][$sl]['status_active']           =$val->status_active;
            $data['tower_inspection_data'][$sl]['status']                  =$row_status[$val->status_active];
            $sl++;

        }

        if(empty($data['tower_inspection_data'])) $data['tower_inspection_data']=array();
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
            'room_name'         => 'required',
            'inspection_task'   => 'required',
            'frequench_check'   => 'required',
            'inspection_by'     => 'required',
            'status_active'     => 'required',
            
        ]);
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        return TowerInspectionList::create($request->all());
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
        request()->validate([
            'room_name'         => 'required',
            'inspection_task'   => 'required',
            'frequench_check'   => 'required',
            'inspection_by'     => 'required',
            'status_active'     => 'required',
            
        ]);

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        TowerInspectionList::find($id)->update($request->all());
        
        return ['message'=>'update successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TowerInspectionList::find($id)->delete();
        return ['message'=>'Module deleted'];
    }
}
