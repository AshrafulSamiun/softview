<?php

namespace App\Http\Controllers;

use App\Models\ApplicationForm as ApplicationForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApplicationFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=\Auth::user();
        
        $application_form=ApplicationForm::where('status_active',1)->get();
        
        $data['application_form']        =$application_form;


       


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
            'full_name'                 => 'required',
            'ba_number'                 => 'required',      
            'rank'                      => 'required',
            'unit'                      => 'required',
            'mobile_no'                 => 'required',
            'service_length'            => 'required',
            'plot'                      => 'required',
            'road'                      => 'required',
            'current_address'           => 'required',
            'permanent_address'         => 'required',
            'nok_name'                  => 'required',
            'sector'                    => 'required',
            'soil_test'                 => 'required',
            'structural_design'         => 'required',
            'required_number_of_piles'  => 'required',
            'depth_of_each_piles'       => 'required',
            'ex_piling_date'            => 'required',

            'tin_no'                    => 'required',
            'national_id_no'            => 'required',
            'bank_account_no'           => 'required',           

        ]);



                  

                  

        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $request->merge(['inserted_by'              =>$user_id]);
       
        if($request->input('soil_test_date'))
        {
            $soil_test_date                               =date("Y-m-d",strtotime($request->input('soil_test_date')));
            $request->merge(['soil_test_date'             =>$soil_test_date]);

        }

        if($request->input('ex_piling_date'))
        {
            $ex_piling_date                               =date("Y-m-d",strtotime($request->input('ex_piling_date')));
            $request->merge(['ex_piling_date'             =>$ex_piling_date]);

        }

       
        $current_year=date('Y');

        $max_system_data = ApplicationForm::whereRaw('system_prefix=(select max(system_prefix) as system_prefix from companies where 
         YEAR(created_at)='.date('Y').' )  and YEAR(created_at)='.date('Y'))->get(['system_prefix']);

        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
               $max_system_prefix=1; 
        }

        $system_no=$current_year."-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
       
        $application_insert=true;
        $application_insert=ApplicationForm::create($request->all());


        if( $application_insert)
        {
           DB::commit();
           return "1**$application_insert->id**$system_no";
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
        $user=\Auth::user();

        $ApplicationForm_data      =ApplicationForm::where('status_active',1)
                                    ->where('id',$id)
                                    ->get();
        $data['application_data']    =$ApplicationForm_data;
        return $data;
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
            'full_name'                 => 'required',
            'ba_number'                 => 'required',      
            'rank'                      => 'required',
            'unit'                      => 'required',
            'mobile_no'                 => 'required',
            'service_length'            => 'required',
            'plot'                      => 'required',
            'road'                      => 'required',
            'current_address'           => 'required',
            'permanent_address'         => 'required',
            'nok_name'                  => 'required',
            'sector'                    => 'required',
            'soil_test'                 => 'required',
            'structural_design'         => 'required',
            'required_number_of_piles'  => 'required',
            'depth_of_each_piles'       => 'required',
            'ex_piling_date'            => 'required',

            'tin_no'                    => 'required',
            'national_id_no'            => 'required',
            'bank_account_no'           => 'required',           

        ]);

      

        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $request->merge(['updated_by'              =>$user_id]);
       
        if($request->input('soil_test_date'))
        {
            $soil_test_date                               =date("Y-m-d",strtotime($request->input('soil_test_date')));
            $request->merge(['soil_test_date'             =>$soil_test_date]);

        }

        if($request->input('ex_piling_date'))
        {
            $ex_piling_date                               =date("Y-m-d",strtotime($request->input('ex_piling_date')));
            $request->merge(['ex_piling_date'             =>$ex_piling_date]);

        }

       
        
        DB::beginTransaction();
       
        $application_update=true;
        $application_update=ApplicationForm::find($id)->update($request->all());


        if( $application_update)
        {
           DB::commit();
           return "1**$id";
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
        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        DB::beginTransaction();
       
        $application_update=true;
        $application_update=ApplicationForm::find($id)->update(['status_active'=>2,'updated_by'=>$user_id]);


        if( $application_update)
        {
           DB::commit();
           return "1**$id";
        }
        else
        {
            DB::rollBack();
            return 10;
        }
        die;
    }
}
