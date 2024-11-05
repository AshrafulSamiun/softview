<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\Locker as Locker;
use App\Models\Suits as Suits;
use Illuminate\Http\Request;

class LockersController extends Controller
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

      
       


        $Suit_data=Suits::where('project_id',$project_id)->get();
        foreach($Suit_data as $key=>$val)
        {
       
            $data['Suit_data'][$val->id]     =$val->suit_name;
        }

        if(empty($data['Suit_data'])) $data['Suit_data']=array();


        $locker_data=Locker::where('project_id',$project_id)->get();
        $sl=0;
        foreach($locker_data as $key=>$val)
        {
    
            $data['locker_data'][$sl]['id']                      =$val->id;
            $data['locker_data'][$sl]['sl']                      =$sl+1;
            $data['locker_data'][$sl]['locker_name']             =$val->locker_name;
            $data['locker_data'][$sl]['locker_holder_name']      =$val->locker_holder_name;
            $data['locker_data'][$sl]['suite_name_string']       =$val->suite->suit_name;
            $data['locker_data'][$sl]['suite_name']              =$val->suite_name;
           
        

            $data['locker_data'][$sl]['status_active']           =$val->status_active;
            $data['locker_data'][$sl]['status']                  =$row_status[$val->status_active];
            $sl++;

        }

        if(empty($data['locker_data'])) $data['locker_data']=array();
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
            'locker_name' => 'required',
            'suite_name' => 'required',
            'locker_holder_name' => 'required|min:1',
            'status_active' => 'required',
            
        ]);
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        return Locker::create($request->all());
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
            'locker_name' => 'required',
            'suite_name' => 'required',
            'locker_holder_name' => 'required|min:1',
            'status_active' => 'required',
            
        ]);

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        Locker::find($id)->update($request->all());
        
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
        Locker::find($id)->delete();
        return ['message'=>'Locker deleted'];
    }
}
