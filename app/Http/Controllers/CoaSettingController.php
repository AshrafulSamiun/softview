<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\CoaGroup as coaGroup;
use App\Models\CoaGroupInitiall as CoaGroupInitiall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoaSettingController extends Controller
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

        $coa_setting_inserted_lavel=CoaGroup::where('project_id',$project_id)
                                           // ->where("sub_level",5)
                                            ->orderBy('main_level')
                                            ->orderBy('reference_id')->get();


       // $data['update']=false;
        $sl=0;
        $main_level_total=array();
        $sub_level_total=array();
        $sublevel_arr=array();
        $main_level_arr=array();
        $main_level_wise_sub_level_arr=array();
        
        $inserted_item_check=array();
        if(count($coa_setting_inserted_lavel)>0)
        {

          // dd($coa_setting_inserted_lavel);die;
            foreach ($coa_setting_inserted_lavel as $key => $value) {
                $inserted_item_check[$value->reference_id]=$value->reference_id;
                $coa_setting_lavel_arr[$sl]['id']                  =$value->id;
                $coa_setting_lavel_arr[$sl]['reference_id']        =$value->reference_id;
                $coa_setting_lavel_arr[$sl]['account_title']       =$value->account_title;
                $coa_setting_lavel_arr[$sl]['active']              =$value->active;
                $coa_setting_lavel_arr[$sl]['statement_type']      =$value->statement_type;
                $coa_setting_lavel_arr[$sl]['income_statement']    =$value->income_statement;
                $coa_setting_lavel_arr[$sl]['balance_sheet']       =$value->balance_sheet;
                $coa_setting_lavel_arr[$sl]['retained_earning']    =$value->retained_earning;
                $coa_setting_lavel_arr[$sl]['transaction_type']    =$value->transaction_type;

                $coa_setting_lavel_arr[$sl]['from']                =$value->from;
                $coa_setting_lavel_arr[$sl]['to']                  =$value->to;
                $coa_setting_lavel_arr[$sl]['balance_type']        =$value->balance_type;
                $coa_setting_lavel_arr[$sl]['third_level']         =$value->third_level;
                $coa_setting_lavel_arr[$sl]['forth_level']         =$value->forth_level;
                $coa_setting_lavel_arr[$sl]['main_level']           =$value->main_level;
                $coa_setting_lavel_arr[$sl]['sub_level']            =$value->sub_level;
                $main_level_wise_sub_level_arr[$value->main_level][$value->sub_level]=$value->sub_level;
                if(empty($main_level_total[$value->main_level]))    $main_level_total[$value->main_level]=1;
                else                                                $main_level_total[$value->main_level]=$main_level_total[$value->main_level]+1;

                 if(empty($sub_level_total[$value->sub_level]))     $sub_level_total[$value->sub_level]=1;
                    else                                            $sub_level_total[$value->sub_level]=$sub_level_total[$value->sub_level]+1;

                if(!in_array($value->sub_level,$sublevel_arr))
                {
                    $sublevel_arr[$value->sub_level]=$value->sub_level;
                    $main_level_total[$value->main_level]+=2;
  
                }

                if(!in_array($value->main_level,$main_level_arr))
                {
                    $main_level_arr[$value->main_level]    =$value->main_level;
                    $main_level_total[$value->main_level]+=1;
                }

                $sl++;
            }
            $data['update']=true;
        }
       
        $coa_setting_lavel=CoaGroupInitiall::where("status_active",1)
                                                //->where("main_level",2)
                                                ->orderBy('main_level')
                                                ->orderBy('id')->get();
        foreach ($coa_setting_lavel as $key => $value) {

            if(!in_array($value->id,$inserted_item_check))
            {
                $coa_setting_lavel_arr[$sl]['id']                  ="";
                $coa_setting_lavel_arr[$sl]['reference_id']        =$value->id;
                $coa_setting_lavel_arr[$sl]['account_title']       =$value->level_name;
                $coa_setting_lavel_arr[$sl]['active']              =0;
                $coa_setting_lavel_arr[$sl]['statement_type']      =0;
                $coa_setting_lavel_arr[$sl]['income_statement']    =0;
                $coa_setting_lavel_arr[$sl]['balance_sheet']       =0;
                $coa_setting_lavel_arr[$sl]['retained_earning']    =0;
                $coa_setting_lavel_arr[$sl]['transaction_type']    ="";

                $coa_setting_lavel_arr[$sl]['from']                =$value->from;
                $coa_setting_lavel_arr[$sl]['to']                  =$value->to;
                $coa_setting_lavel_arr[$sl]['balance_type']        ="";
                $coa_setting_lavel_arr[$sl]['third_level']         =$value->third_level;
                $coa_setting_lavel_arr[$sl]['forth_level']         =$value->forth_level;
                $coa_setting_lavel_arr[$sl]['main_level']           =$value->main_level;
                $coa_setting_lavel_arr[$sl]['sub_level']            =$value->sub_level;
                $main_level_wise_sub_level_arr[$value->main_level][$value->sub_level]=$value->sub_level;

                if(empty($main_level_total[$value->main_level]))    $main_level_total[$value->main_level]=1;
                else                                                $main_level_total[$value->main_level]=$main_level_total[$value->main_level]+1;


                 if(empty($sub_level_total[$value->sub_level]))    $sub_level_total[$value->sub_level]=1;
                    else                                           $sub_level_total[$value->sub_level]=$sub_level_total[$value->sub_level]+1;

                if(!in_array($value->sub_level,$sublevel_arr))
                {
                    $sublevel_arr[$value->sub_level]=$value->sub_level;
                    $main_level_total[$value->main_level]+=2;

                }

                if(!in_array($value->main_level,$main_level_arr))
                {
                    $main_level_arr[$value->main_level]    =$value->main_level;
                    //$main_level_total[$value->main_level]+=1;
                }

                $sl++; 
            }
           
        }
       
 
        $data['main_level_wise_sub_level_arr']  =$main_level_wise_sub_level_arr;
        $data['coa_setting_lavel_arr']          =$coa_setting_lavel_arr;
        $data['main_level_total']               =$main_level_total;
        $data['accounts_sub_group']             =$accounts_sub_group;
        $data['sub_level_total']                =$sub_level_total;

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

    public function customCoaStore(Request $request)
    {

        request()->validate([

            'custom_field_name'                  =>"required",
            
        ]);
        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['inserted_by'              =>$user_id]);
        $request->merge(['project_id'               =>$project_id]);
        $request->merge(['main_level'               =>$request->input('custom_main_level')]);
        $request->merge(['sub_level'                =>$request->input('custom_sub_level')]);
        $request->merge(['third_level'              =>$request->input('custom_level_three')]);
        $request->merge(['forth_level'              =>$request->input('custom_level_four')]);
        $request->merge(['level_name'               =>$request->input('custom_field_name')]);

        

        DB::beginTransaction();

        $coa_info= CoaGroupInitiall::create($request->all());

        if( $coa_info)
        {
           DB::commit();
           return "1**".$coa_info->id;
        }
        else
        {
            DB::rollBack();
            return 10;
        }
        die;
    }
    public function store(Request $request)
    {
        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['inserted_by'              =>$user_id]);
        $request->merge(['project_id'               =>$project_id]);
       // dd($request->coa_setting_arr);die;
        foreach($request->coa_setting_arr as $main_level=>$main_level_data)
        {

            if($main_level>0)
            {
                foreach($main_level_data as $sub_level=>$sub_level_data)
                {
                    foreach($sub_level_data as $third_level=>$third_level_data)
                    {
                        foreach($third_level_data as $forth_level=>$forth_level_data)
                        {
                            foreach($forth_level_data as $reference_id=>$details)
                            {
                               // dd($details);
                                if($details['active']==1)
                                {
                                        $data_coa_setting[]= array(
                                            'project_id'                =>$project_id,
                                            'from'                      =>$details['from'],
                                            'to'                        =>$details['to'],
                                            'reference_id'              =>$details['reference_id'],
                                            'account_title'             =>$details['account_title'],
                                            'main_level'                =>$main_level,
                                            'sub_level'                 =>$sub_level,
                                            'third_level'               =>$details['third_level'],
                                            'forth_level'               =>$details['forth_level'],
                                            'active'                    =>$details['active'],
                                            'statement_type'            =>$details['statement_type'],
                                            'transaction_type'          =>$details['transaction_type'],
                                            'balance_type'              =>$details['balance_type'],
                                            'income_statement'          =>$details['income_statement'],
                                            'balance_sheet'             =>$details['balance_sheet'],
                                            'retained_earning'          =>$details['retained_earning'],
                                            'inserted_by'               =>$user_id,
                                        );
                                                                           
                                }
                            }
                        }
                    }                            
                }
            }
                      
                      
        }
        DB::beginTransaction();
        $RId1=true;
        if($data_coa_setting)
        {
            $RId1=CoaGroup::insert($data_coa_setting);
        }


        if( $RId1)
        {
           DB::commit();
           return "1**";
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
        {
        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['inserted_by'              =>$user_id]);
        $request->merge(['project_id'               =>$project_id]);
       // dd($request->coa_setting_arr);die;

        DB::beginTransaction();
        foreach($request->coa_setting_arr as $main_level=>$main_level_data)
        {

            if($main_level>0)
            {
                foreach($main_level_data as $sub_level=>$sub_level_data)
                {
                    foreach($sub_level_data as $third_level=>$third_level_data)
                    {
                        foreach($third_level_data as $forth_level=>$forth_level_data)
                        {
                            foreach($forth_level_data as $reference_id=>$details)
                            {
                               // dd($details);
                                if($details['id']!="")
                                {
                                        $coa_setting_data= array(
                                            'project_id'                =>$project_id,
                                            'from'                      =>$details['from'],
                                            'to'                        =>$details['to'],
                                            'reference_id'              =>$details['reference_id'],
                                            'account_title'             =>$details['account_title'],
                                            'main_level'                =>$main_level,
                                            'sub_level'                 =>$sub_level,
                                            'third_level'               =>$details['third_level'],
                                            'forth_level'               =>$details['forth_level'],
                                            'active'                    =>$details['active'],
                                            'statement_type'            =>$details['statement_type'],
                                            'transaction_type'          =>$details['transaction_type'],
                                            'balance_type'              =>$details['balance_type'],
                                            'income_statement'          =>$details['income_statement'],
                                            'balance_sheet'             =>$details['balance_sheet'],
                                            'retained_earning'          =>$details['retained_earning'],
                                            'updated_by'                =>$user_id,
                                        );

                                    $coaSettingData=CoaGroup::where('id',"=",$details['id'])->update($coa_setting_data);
                                    if( !$coaSettingData)
                                    {
                                        DB::rollBack();
                                        return 10;
                                        die;
                                    }
                                                                           
                                }
                                else if($details['active']==1)
                                {
                                        $data_coa_setting[]= array(
                                            'project_id'                =>$project_id,
                                            'from'                      =>$details['from'],
                                            'to'                        =>$details['to'],
                                            'reference_id'              =>$details['reference_id'],
                                            'account_title'             =>$details['account_title'],
                                            'main_level'                =>$main_level,
                                            'sub_level'                 =>$sub_level,
                                            'third_level'               =>$details['third_level'],
                                            'forth_level'               =>$details['forth_level'],
                                            'active'                    =>$details['active'],
                                            'statement_type'            =>$details['statement_type'],
                                            'transaction_type'          =>$details['transaction_type'],
                                            'balance_type'              =>$details['balance_type'],
                                            'income_statement'          =>$details['income_statement'],
                                            'balance_sheet'             =>$details['balance_sheet'],
                                            'retained_earning'          =>$details['retained_earning'],
                                            'inserted_by'               =>$user_id,
                                        );
                                }
                            }
                        }
                    }                            
                }
            }
                      
                      
        }
        
        $RId1=true;
        if(!empty($data_coa_setting))
        {
            $RId1=CoaGroup::insert($data_coa_setting);
        }


        if( $RId1)
        {
           DB::commit();
           return "1**";
        }
        else
        {
            DB::rollBack();
            return 10;
        }
        die;
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
