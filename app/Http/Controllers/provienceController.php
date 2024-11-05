<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\Country as Country;
use App\Models\Provience as provience;
use Illuminate\Http\Request;


class provienceController extends Controller
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
        $provience              =Provience::all();
        $country                =Country::where('status_active',1)->get();
//dd($row_status);die;
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
        }

        $sl=0;
        foreach ($provience as $key => $value) {
            $provience[$sl]['sl']               =$sl+1;
            $provience[$sl]['id']               =$value->id;
            $provience[$sl]['provience_name']   =$value->provience_name;
            $provience[$sl]['country_id']       =$value->country_id;
            $provience[$sl]['status_active']    =$value->status_active;
            $provience[$sl]['country_name']     =$country_arr[$value->country_id];
            $provience[$sl]['status']           =$row_status[$value->status_active];
            $sl++;
        }

        $data['provience']=$provience;
        $data['country_arr']=$country_arr;
        return $data;
    }

    public function get_provience_by_country($country)
    {
        $provience=Provience::where('status_active',1)->where('country_id',$country)->get();

        $provience_option="<option value=''>Select Provience</option>";

        foreach ($provience as $key => $value) {
            $provience_option.="<option value='".$value->id."'>".$value->provience_name."</option>";
        }
       // $data['provience_option']        =$provience_option;
        return $provience_option;
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
            'provience_name' => 'required',
            'country_id' => 'required',
            'status_active' => 'required',
        ]);
         return Provience::create($request->all());
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
            'provience_name' => 'required',
            'country_id' => 'required',
            'status_active' => 'required',
        ]);
        Provience::find($id)->update($request->all());
        
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
        Provience::find($id)->delete();
        return ['message'=>'Module deleted'];
    }
}
                        