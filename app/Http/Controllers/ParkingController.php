<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\Floor as Floor;
use App\Parking as Parking;
use Illuminate\Http\Request;

class ParkingController extends Controller
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
        $floor_data=Floor::where('status_active',1)->where('project_id',$project_id)->get();

      
        foreach($floor_data as $key=>$val)
        {
       
            $data['floor_data'][$val->id]     =$val->floor_name;
        }

        if(empty($data['floor_data'])) $data['floor_data']=array();

       // dd($yes_no);die;
        $parking=Parking::where('project_id',$project_id)->get();

        $sl=0;
        foreach($parking as $key=>$val)
        {
    
            $data['parking'][$sl]['id']                      =$val->id;
            $data['parking'][$sl]['sl']                      =$sl+1;
            $data['parking'][$sl]['parking_name']            =$val->parking_name;
            $data['parking'][$sl]['floor_name']              =$val->floor_name;
            $data['parking'][$sl]['floor_name_string']       =$val->floor->floor_name;

            $data['parking'][$sl]['status_active']           =$val->status_active;
            $data['parking'][$sl]['status']                  =$row_status[$val->status_active];
            $sl++;
        }

        if(empty($data['parking'])) $data['parking']=array();
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
            'parking_name' => 'required',
            'floor_name' => 'required',
            'status_active' => 'required',
            
        ]);
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        return Parking::create($request->all());
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
            'parking_name' => 'required',
            'floor_name' => 'required',
            'status_active' => 'required',
            
        ]);

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        Parking::find($id)->update($request->all());
        
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
         Parking::find($id)->delete();
        return ['message'=>'Module deleted'];
    }
}
