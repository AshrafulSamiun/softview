<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project as Project;
use Illuminate\Support\Facades\DB;


class AccountCrospondentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_info                  = \Auth::user();
        $data['master_company_id']  =$user_info->master_company_id;
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['user_id'          =>$user_id]);
        DB::beginTransaction();
        $user_project=Project::find($project_id)->update(array('project_status' => '106'));

        if($user_project)
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
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
