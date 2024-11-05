<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\ServicePlan as servicePlan;
use Illuminate\Http\Request;

class ServicePlanController extends Controller
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
        $servicePlan            =ServicePlan::all();
        $yes_no=array(1=>"Yes",0=>"No");

        $sl=0;
        $master_plan_arr=array();
        foreach ($servicePlan as $key => $value) {
            if($value->amount_applicable==0)
            {
                $master_plan_arr[$value->id]=$value->plan_name;
            }
            
        }
//dd($master_plan_arr);die;
        foreach ($servicePlan as $key => $value) {

            $servicePlan_arr[$sl]['sl']                     =$sl+1;
            $servicePlan_arr[$sl]['id']                     =$value->id;
            $servicePlan_arr[$sl]['plan_name']              =$value->plan_name;
            $servicePlan_arr[$sl]['plan_a']                 =$value->plan_a;
            $servicePlan_arr[$sl]['plan_b']                 =$value->plan_b;
            $servicePlan_arr[$sl]['plan_c']                 =$value->plan_c;
            $servicePlan_arr[$sl]['plan_d']                 =$value->plan_d;

            $servicePlan_arr[$sl]['amount_applicable']      =$value->amount_applicable;
            $servicePlan_arr[$sl]['position']               =$value->position;
            $servicePlan_arr[$sl]['slno']                   =$value->slno;
            $servicePlan_arr[$sl]['master_plan_id']         =$value->master_plan_id;
            $servicePlan_arr[$sl]['status']                 =$value->status;
            if($value->master_plan_id>0)
            {
                $servicePlan_arr[$sl]['master_plan_name']   =$master_plan_arr[$value->master_plan_id];
            }
            else
            {
                $servicePlan_arr[$sl]['master_plan_name']   ="";
            }
            $servicePlan_arr[$sl]['status_st']              =$row_status[$value->status];
            $servicePlan_arr[$sl]['amount_applicable_st']   =$yes_no[$value->amount_applicable];
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
     
        return ServicePlan::create($request->all());
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
        ServicePlan::find($id)->update($request->all());
        
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
        ServicePlan::find($id)->delete();
        return ['message'=>'Module deleted'];
    }
}
