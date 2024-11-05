<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\MaintenanceRoom as MaintenanceRoom;
use Illuminate\Http\Request;

class MaintenanceRoomController extends Controller
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
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;

       // dd($yes_no);die;
        $maintainRoom=MaintenanceRoom::where('project_id',$project_id)->get();

        $sl=0;
        foreach($maintainRoom as $key=>$val)
        {
    
            $data['maintainRoom'][$sl]['id']                      =$val->id;
            $data['maintainRoom'][$sl]['sl']                      =$sl+1;
            $data['maintainRoom'][$sl]['maintainance_room']       =$val->maintainance_room;
            $data['maintainRoom'][$sl]['locaton']                 =$val->locaton;
            $data['maintainRoom'][$sl]['comment']                 =$val->comment;

            $data['maintainRoom'][$sl]['status_active']           =$val->status_active;
            $data['maintainRoom'][$sl]['status']                  =$row_status[$val->status_active];
            $sl++;

        }

        if(empty($data['maintainRoom'])) $data['maintainRoom']=array();
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
            'maintainance_room' => 'required',
            'locaton' => 'required',
            'status_active' => 'required',
            
        ]);
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        return MaintenanceRoom::create($request->all());
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
            'maintainance_room' => 'required',
            'locaton' => 'required',
            'status_active' => 'required',
            
        ]);
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        MaintenanceRoom::find($id)->update($request->all());
        
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
         MaintenanceRoom::find($id)->delete();
        return ['message'=>'Module deleted'];
    }
}
