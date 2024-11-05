<?php

namespace App\Http\Controllers;

use App\Models\AccountContactPerson as AccountContactPerson;
use App\Models\Country as Country;
use App\Models\Project as Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AccountContactPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $country                            =Country::where('status_active',1)->get();


        foreach ($country as $key => $value) {
            $country_arr[$value->id]        =$value->country_name;
            $country_code_arr[$value->id]   =$value->country_code;
        }

        $project_id                         = \Auth::user()->project_id;
        $user_id                            = \Auth::user()->id; 
        $data['country_arr']                =$country_arr;

        $contact_person_data                =AccountContactPerson::where('project_id',$project_id)->where('status_active',1)->get();
        $data['contact_person_data']        =array();


        foreach($contact_person_data as $key=>$val)
        {
            $data['contact_person_data'][$val->contact_person_id]['id']                          =$val->id;
            $data['contact_person_data'][$val->contact_person_id]['full_name']                   =$val->full_name;
            $data['contact_person_data'][$val->contact_person_id]['job_title']                   =$val->job_title;
            $data['contact_person_data'][$val->contact_person_id]['street_number']               =$val->street_number;
            $data['contact_person_data'][$val->contact_person_id]['city']                        =$val->city;
            $data['contact_person_data'][$val->contact_person_id]['state']                       =$val->state;
            $data['contact_person_data'][$val->contact_person_id]['country']                     =$val->country;
            $data['contact_person_data'][$val->contact_person_id]['post_code']                   =$val->post_code;
            $data['contact_person_data'][$val->contact_person_id]['po_box']                      =$val->po_box;
            $data['contact_person_data'][$val->contact_person_id]['office_phone']                =$val->office_phone;
            $data['contact_person_data'][$val->contact_person_id]['mobile']                      =$val->mobile;
            $data['contact_person_data'][$val->contact_person_id]['email']                       =$val->email;
            $data['contact_person_data'][$val->contact_person_id]['fax_no']                      =$val->fax_no;
            //$data['contact_person_data'][$val->contact_person_id]['contact_person_id']           =$val->contact_person_id;
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
            

            'full_name'=>'required',
            'job_title'=>'required',
            'street_number'=>'required',
            'city'=>'required',
            'state'=>'required',
            'country'=>'required',
            'post_code'=>'required',
            'po_box'=>'required',
            'office_phone'=>'required',
            'mobile'=>'required',
            'email'=>'required',
            'fax_no'=>'required',
            'contact_person_id'=>'required',
            
           
        ]);




        
        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['inserted_by'      =>$user_id]);
        //dd($request->file('building_photo_url'));die;
        DB::beginTransaction();

        
        $account_contact_person= AccountContactPerson::create($request->all());


        $user_project=Project::find($project_id)->update(array('project_status' => '98'));

        if($account_contact_person  && $user_project)
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
            

            'full_name'=>'required',
            'job_title'=>'required',
            'street_number'=>'required',
            'city'=>'required',
            'state'=>'required',
            'country'=>'required',
            'post_code'=>'required',
            'po_box'=>'required',
            'office_phone'=>'required',
            'mobile'=>'required',
            'email'=>'required',
            'fax_no'=>'required',
            'contact_person_id'=>'required',
        ]);




        
        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['updated_by'       =>$user_id]);
        //dd($request->file('building_photo_url'));die;
        DB::beginTransaction();

        
        $account_contact_person= AccountContactPerson::find($id)->update($request->all());



        if($account_contact_person)
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
