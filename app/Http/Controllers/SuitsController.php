<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\Floor as Floor;
use App\Models\Suits as Suits;
use Illuminate\Http\Request;

class SuitsController extends Controller
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
        $floor_data=Floor::where('status_active',1)->where('project_id',$project_id)->get();

      
        foreach($floor_data as $key=>$val)
        {
       
            $data['floor_data'][$val->id]     =$val->floor_name;
        }

        if(empty($data['floor_data'])) $data['floor_data']=array();


        $Suit_data=Suits::where('project_id',$project_id)->get();

        $sl=0;
        foreach($Suit_data as $key=>$val)
        {
    
            $data['Suit_data'][$sl]['id']                      =$val->id;
            $data['Suit_data'][$sl]['sl']                      =$sl+1;
            $data['Suit_data'][$sl]['suit_name']               =$val->suit_name;
            $data['Suit_data'][$sl]['floor_name']              =$val->floor_name;
            $data['Suit_data'][$sl]['floor_name_string']       =$val->floor->floor_name;
            $data['Suit_data'][$sl]['total_rooms']             =$val->total_rooms;
            $data['Suit_data'][$sl]['one_room']                =$val->one_room;
            $data['Suit_data'][$sl]['two_room']                =$val->two_room;
            $data['Suit_data'][$sl]['three_room']              =$val->three_room;
            $data['Suit_data'][$sl]['town_house']              =$val->town_house;
            $data['Suit_data'][$sl]['town_house_string']       =$yes_no[$val->town_house];
        

            $data['Suit_data'][$sl]['status_active']           =$val->status_active;
            $data['Suit_data'][$sl]['status']                  =$row_status[$val->status_active];
            $sl++;

        }

        if(empty($data['Suit_data'])) $data['Suit_data']=array();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'suit_name' => 'required',
            'floor_name' => 'required',
            'total_rooms' => 'required|min:1',
            'status_active' => 'required',
            
        ]);
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        return Suits::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
            'suit_name' => 'required',
            'floor_name' => 'required',
            'total_rooms' => 'required|min:1',
            'status_active' => 'required',
            
        ]);

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        Suits::find($id)->update($request->all());
        
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
        Suits::find($id)->delete();
        return ['message'=>'Module deleted'];
    }
}
