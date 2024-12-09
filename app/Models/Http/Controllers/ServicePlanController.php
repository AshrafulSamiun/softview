<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\provience as provience;
use App\servicePlan as servicePlan;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Support\Facades\DB;

class ServicePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        // $servicePlan            =servicePlan::where('id','<',61)->get();
        // $servicePlan_arr=array();
        // $sl=151;
        // foreach ($servicePlan as $key => $details) {
        //     $servicePlan_arr[]= array(
        //             'id'                        =>$sl,
        //             'plan_name'                 =>$details['plan_name'],
        //             'management_type'           =>4,
        //             'type_of_service'           =>$details['type_of_service'],
        //             'rate'                      =>$details['rate'],
        //             'amount'                    =>$details['amount'],
        //             'rate_applicable'           =>$details['rate_applicable'],
        //             'status'                    =>$details['status'],
        //             'slno'                      =>$details['slno'],
        //         );
        //     $sl++;
            
        // }

        //  DB::beginTransaction();
        // if(!empty($servicePlan_arr))
        // {
        //     $RId1=servicePlan::insert($servicePlan_arr);
        // }

        // if($RId1)
        // {
        //    DB::commit();
        //    return "1**$id";
        // }

        // die;
        
        $ArrayFunction          =new ArrayFunction();
        $row_status             =$ArrayFunction->row_status;
        $servicePlan            =servicePlan::all();
        $yes_no=array(1=>"Yes",0=>"No");

        $sl=0;
        $master_plan_arr=array();
        foreach ($servicePlan as $key => $value) {
            if($value->rate_applicable==0)
            {
                $master_plan_arr[$value->type_of_service]=$value->plan_name;
            }
        }

        foreach ($servicePlan as $key => $value) {

            $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['id']                     =$value->id;
            $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['plan_name']              =$value->plan_name;
            $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['rate_applicable']      =$value->rate_applicable;
            $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['rate']                   =$value->rate;
            $servicePlan_arr[$value->type_of_service][$value->plan_name][$value->management_type]['slno']                   =$value->slno;
           
            $sl++;
        }

        $data['service_plan_arr']=$servicePlan_arr;
        $data['master_plan_arr']=$master_plan_arr;
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
            'plan_name' => 'required',
            'amount_applicable' => 'required',
            'position' => 'required',
            'status' => 'required',
            'slno' => 'required',
        ]);
     
        return servicePlan::create($request->all());
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
            'plan_name' => 'required',
            'amount_applicable' => 'required',
            'position' => 'required',
            'status' => 'required',
            'slno' => 'required',
        ]);
        servicePlan::find($id)->update($request->all());
        
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
        servicePlan::find($id)->delete();
        return ['message'=>'Module deleted'];
    }
}
