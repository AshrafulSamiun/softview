<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\ChartOfAccount as ChartOfAccount;
use App\Models\CoaGroup as coaGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartOfAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;

        $ArrayFunction              =new ArrayFunction();
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;

        $coa_inserted_lavel=ChartOfAccount::where('project_id',$project_id)->get();

        $chart_of_account_list          =DB::table('chart_of_accounts as coa')
                                        ->join('coa_groups as group','coa.coa_group','=','group.reference_id')
                                        ->where('coa.project_id', '=', $project_id)
                                        ->where('group.project_id', '=', $project_id)
                                        ->get(['group.account_title','group.statement_type','coa.*']);
                                           



        $sl=0;
        $sub_level_total=array();
        
        $coa_arr=array();
        if(count($chart_of_account_list)>0)
        {

            foreach ($chart_of_account_list as $key => $value) {
                $coa_arr[$value->sub_group][$value->second_level][$value->third_level][$value->forth_level][$sl]['id']                   =$value->id;
                $coa_arr[$value->sub_group][$value->second_level][$value->third_level][$value->forth_level][$sl]['account_title']        =$value->account_title;
                $coa_arr[$value->sub_group][$value->second_level][$value->third_level][$value->forth_level][$sl]['account_no']           =$value->account_no;
                $coa_arr[$value->sub_group][$value->second_level][$value->third_level][$value->forth_level][$sl]['description']          =$value->description;
                $coa_arr[$value->sub_group][$value->second_level][$value->third_level][$value->forth_level][$sl]['govt_tax_code']        =$value->govt_tax_code;
                $coa_arr[$value->sub_group][$value->second_level][$value->third_level][$value->forth_level][$sl]['tax_code']             =$value->tax_code;
                $coa_arr[$value->sub_group][$value->second_level][$value->third_level][$value->forth_level][$sl]['coa_group']            =$value->coa_group;
                $coa_arr[$value->sub_group][$value->second_level][$value->third_level][$value->forth_level][$sl]['statement_type']       =$value->statement_type;

               

                if(empty($sub_level_total[$value->sub_group]))     $sub_level_total[$value->sub_group]=1;
                    else                                           $sub_level_total[$value->sub_group]=$sub_level_total[$value->sub_group]+1;   
                 $sl++;         
            }
        }

        $coa_setting_inserted_lavel=CoaGroup::where('project_id',$project_id)
                                            ->orderBy('main_level')
                                            ->orderBy('reference_id')->get();

        if(count($coa_setting_inserted_lavel)>0)
        {

            foreach ($coa_setting_inserted_lavel as $key => $value) {

                if($value->third_level==0 && $value->forth_level==0)
                {
                    $coa_setting_sub_lavel_arr[$value->sub_level][$value->reference_id]['account_title']       =$value->account_title;
                    $coa_setting_sub_lavel_arr[$value->sub_level][$value->reference_id]['from']                =$value->from;
                    $coa_setting_sub_lavel_arr[$value->sub_level][$value->reference_id]['to']                  =$value->to;
                    $coa_setting_sub_lavel_arr[$value->sub_level][$value->reference_id]['id']                  =$value->id;
                    $coa_setting_sub_lavel_arr[$value->sub_level][$value->reference_id]['statement_type']      =$value->statement_type;
                }

                if($value->third_level!=0 && $value->forth_level==0)
                {
                    $coa_setting_second_lavel_arr[$value->sub_level][$value->third_level][$value->reference_id]['account_title']       =$value->account_title;
                    $coa_setting_second_lavel_arr[$value->sub_level][$value->third_level][$value->reference_id]['from']                =$value->from;
                    $coa_setting_second_lavel_arr[$value->sub_level][$value->third_level][$value->reference_id]['to']                  =$value->to;
                    $coa_setting_second_lavel_arr[$value->sub_level][$value->third_level][$value->reference_id]['id']                  =$value->id;
                    $coa_setting_second_lavel_arr[$value->sub_level][$value->third_level][$value->reference_id]['statement_type']      =$value->statement_type;
                }

                if($value->third_level!=0 && $value->forth_level!=0)
                {
                    $coa_setting_third_lavel_arr[$value->sub_level][$value->third_level][$value->forth_level][$value->reference_id]['account_title']       =$value->account_title;
                    $coa_setting_third_lavel_arr[$value->sub_level][$value->third_level][$value->forth_level][$value->reference_id]['from']                =$value->from;
                    $coa_setting_third_lavel_arr[$value->sub_level][$value->third_level][$value->forth_level][$value->reference_id]['to']                  =$value->to;
                    $coa_setting_third_lavel_arr[$value->sub_level][$value->third_level][$value->forth_level][$value->reference_id]['id']                  =$value->id;
                    $coa_setting_third_lavel_arr[$value->sub_level][$value->third_level][$value->forth_level][$value->reference_id]['statement_type']      =$value->statement_type;
                }
                
               
            }
        }
       
        //dd($coa_setting_second_lavel_arr);
 
        $data['coa_setting_third_lavel_arr']    =$coa_setting_third_lavel_arr;
        $data['coa_setting_second_lavel_arr']   =$coa_setting_second_lavel_arr;
        $data['coa_setting_sub_lavel_arr']      =$coa_setting_sub_lavel_arr;
        $data['accounts_sub_group']             =$accounts_sub_group;
        $data['sub_level_total']                =$sub_level_total;
        $data['coa_arr']                        =$coa_arr;

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
            'sub_group'         => 'required|numeric|min:0|not_in:0',
            'second_level'      => 'required|numeric|min:0|not_in:0',
            'account_no'        => 'required',
            'description'       => 'required',
        ]);

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $coa_group=0;
        if($request->input('second_level')>0)
        {
            if($request->input('third_level')>0)
            {
                if($request->input('forth_level')>0)
                {
                    $coa_group=$request->input('forth_level');
                }
                else{
                    $coa_group=$request->input('third_level');
                }
            }
            else{
                $coa_group=$request->input('second_level');
            } 
        }

        $request->merge(['coa_group' =>$coa_group]);

        DB::beginTransaction();
        $coa_info= ChartOfAccount::create($request->all());
        if($coa_info)
        {
           DB::commit();
           return "1**$coa_info->id";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
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
            'sub_group'         => 'required|numeric|min:0|not_in:0',
            'second_level'      => 'required|numeric|min:0|not_in:0',
            'account_no'        => 'required',
            'description'       => 'required',
        ]);

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $coa_group=0;
        if($request->input('second_level')>0)
        {
            if($request->input('third_level')>0)
            {
                if($request->input('forth_level')>0)
                {
                    $coa_group=$request->input('forth_level');
                }
                else{
                    $coa_group=$request->input('third_level');
                }
            }
            else{
                $coa_group=$request->input('second_level');
            } 
        }

        $request->merge(['coa_group' =>$coa_group]);

        DB::beginTransaction();
        $coa_info= ChartOfAccount::find($id)->update($request->all());
        if($coa_info)
        {
           DB::commit();
           return "1**$id";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
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
