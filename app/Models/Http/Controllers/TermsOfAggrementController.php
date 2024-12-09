<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Classes\ArrayFunction as ArrayFunction;
use App\TermsOfAggrement as TermsOfAggrement;
use App\Project as Project;


class TermsOfAggrementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $project_id                         = \Auth::user()->project_id;


        $project_info = Project::find($project_id);
        $project_type = $project_info->project_status;
        $data['project_status']=$project_type;
        

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
        



        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);

        DB::beginTransaction();

        $user_project=Project::find($project_id)->update(array('project_status' => '98'));



        if( $user_project)
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
       

        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
       

        DB::beginTransaction();
        $user_project=Project::find($project_id)->update(array('project_status' => '99'));

       


        if( $user_project)
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
