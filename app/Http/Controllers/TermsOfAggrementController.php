<?php

namespace App\Http\Controllers;

use App\Models\Project as Project;
use App\Models\TermsOfAggrement as TermsOfAggrement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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

        $TermsOfAggrement_data              =TermsOfAggrement::where('project_id',$project_id)->where('status_active',1)->get();
        $data['terms_of_aggrement_data']    =array();

        $project_info = Project::find($project_id);
        $project_type = $project_info->project_status;
        $data['project_status']=$project_type;
        foreach($TermsOfAggrement_data as $key=>$val)
        {
            $data['terms_of_aggrement_data']['id']                          =$val->id;
            $data['terms_of_aggrement_data']['diclaration']                 =$val->diclaration;
            $data['terms_of_aggrement_data']['full_name']                   =$val->full_name;
            $data['terms_of_aggrement_data']['position']                    =$val->position;
            $data['terms_of_aggrement_data']['office_phone']                =$val->office_phone;
            $data['terms_of_aggrement_data']['mobile']                      =$val->mobile;
            $data['terms_of_aggrement_data']['email']                       =$val->email;
            $data['terms_of_aggrement_data']['location']                    =$val->location;
        }

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
            'diclaration'                   => 'required',
            'full_name'                     => 'required',
            'position'                      => 'required',
            'office_phone'                  => 'required',
            'mobile'                        => 'required',
            'email'                         => 'required',
            'location'                      => 'required',            
        ]);



        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);

        DB::beginTransaction();

        $terms_of_condition_insert=TermsOfAggrement::create($request->all());

        $user_project=Project::find($project_id)->update(array('project_status' => '95'));



        if( $terms_of_condition_insert)
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
        request()->validate([
            'diclaration'                   => 'required',
            'full_name'                     => 'required',
            'position'                      => 'required',
            'office_phone'                  => 'required',
            'mobile'                        => 'required',
            'email'                         => 'required',
            'location'                      => 'required',            
        ]);

        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['updated_by'          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);



        DB::beginTransaction();

        $service_contact_update=TermsOfAggrement::find($id)->update($request->all());

       


        if( $service_contact_update)
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
