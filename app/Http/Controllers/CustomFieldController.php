<?php

namespace App\Http\Controllers;

use App\Models\BuildingContactList as BuildingContactList;
use App\Models\CustomField as CustomField;
use App\Models\ServiceType as ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        
        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['inserted_by'              =>$user_id]);
        $request->merge(['page_id'                  =>$request->input('page_id')]);
        $request->merge(['project_id'               =>$project_id]);

        $max_serial_data=CustomField::where('page_id',$request->input('page_id'))
                            ->where('project_id',$project_id)
                            ->where('status_active',1)
                            ->get(['serial_id']);
                           // dd($request->all());die;
        if(count($max_serial_data)>0)
        {
            $max_serial_id=$max_serial_data[0]->serial_id+1; 
        }
        else
        {
            $max_serial_id=1; 
        }
       // dd($request->all());die;
        $request->merge(['field_type'                =>$request->input('custom_field_type')]);
        $request->merge(['serial_id'                 =>$max_serial_id]);
        $request->merge(['field_name'                =>$request->input('custom_field_name')]);
        //dd($request->all());die;
        DB::beginTransaction();
        $custom_field_insert=CustomField::create($request->all());

        if( $custom_field_insert)
        {
           DB::commit();
           return "1**$custom_field_insert->id";
        }
        else
        {
            DB::rollBack();
            return 10;
        }
        die;
    }



    public function customContactStor(Request $request)
    {
        
        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['inserted_by'              =>$user_id]);
        $request->merge(['page_id'                  =>$request->input('page_id')]);
        $request->merge(['project_id'               =>$project_id]);

        
        $request->merge(['item_type'                =>$request->input('custom_contact_type')]);
        $request->merge(['item_name'                =>$request->input('custom_field_name')]);
        DB::beginTransaction();
        $custom_field_insert=BuildingContactList::create($request->all());

        if( $custom_field_insert)
        {
           DB::commit();
           return "1**$custom_field_insert->id";
        }
        else
        {
            DB::rollBack();
            return 10;
        }
        die;
    }



    public function AddServiceCategory(Request $request)
    {
        
        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['inserted_by'              =>$user_id]);
        $request->merge(['project_id'               =>$project_id]);
        $request->merge(['status_active'            =>1]);
        $request->merge(['is_deleted'               =>0]);

        $request->merge(['service_name'                =>$request->input('custom_field_name')]);
        DB::beginTransaction();
        $custom_field_insert=ServiceType::create($request->all());

        if( $custom_field_insert)
        {
           DB::commit();
           return "1**$custom_field_insert->id";
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
        //
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
