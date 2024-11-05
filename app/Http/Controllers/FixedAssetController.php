<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\AccountType;
use App\Models\AssetCategory;
use App\Models\FixedAsset;
use App\Models\TaxTypeInitial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FixedAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=\Auth::user();
        $project_id                             = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $unit_of_measurement        =$ArrayFunction->unit_of_measurement;
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;

        //===================Company==========================================
        $asset_category_list                        =AssetCategory::where('status_active',1)
                                                    ->whereIn('project_id',[0,$project_id])
                                                    ->get();

        $main_category=array();
        $sub_category=array();
        foreach($asset_category_list as $val)
        {
            if($val->root_item==0)
                $main_category[$val->id]=$val->item_name;
            else
                $sub_category[$val->root_item][$val->id]=$val->item_name;
        }

        $account_type_list                          =TaxTypeInitial::where('status_active',1)
                                                        ->where('type',4)
                                                        ->whereIn('project_id',[$project_id,0])
                                                        ->get();
        $account_type_arr=array();
        foreach ($account_type_list as $key => $value) {
            $account_type_arr[$value->id]['name']                   =$value->field_name;
            $account_type_arr[$value->id]['chart_of_account']       ="";
            $account_type_arr[$value->id]['chart_of_account_id']    ="";
            $account_type_arr[$value->id]['id']                     ="";
        }

        $chart_of_account_list          =DB::table('chart_of_accounts as coa')
                                        ->join('coa_groups as group','coa.coa_group','=','group.reference_id')
                                        ->where('coa.project_id', '=', $project_id)
                                        ->where('group.project_id', '=', $project_id)
                                        ->get(['group.account_title','group.statement_type','coa.*']);
        $coa_arr=array();$sl=0;
        if(count($chart_of_account_list)>0)
        {
            foreach ($chart_of_account_list as $key => $value) {
                $coa_arr[$sl]['id']                   =$value->id;
                $coa_arr[$sl]['account_title']        =$value->account_title;
                $coa_arr[$sl]['account_no']           =$value->account_no;
                $coa_arr[$sl]['description']          =$value->description;
                $coa_arr[$sl]['govt_tax_code']        =$value->govt_tax_code;
                $coa_arr[$sl]['tax_code']             =$value->tax_code;
                $coa_arr[$sl]['sub_group']            =$value->sub_group;
                $coa_arr[$sl]['sub_group_name']       =$accounts_sub_group[$value->sub_group];
                $sl++;         
            }
        }

        $data['coa_arr']                        =$coa_arr;
        $data['main_category']                  =$main_category;
        $data['sub_category']                   =$sub_category;
        $data['unit_of_measurement']            =$unit_of_measurement;
        $data['account_type_arr']               =$account_type_arr;


        return $data;
    }


    public function fixed_asset_List()
    {

        $user=\Auth::user();
        $project_id                             = $user->project_id;
        //===================Company==========================================

        $ArrayFunction              =new ArrayFunction();
        $item_category              =$ArrayFunction->item_category;
        $unit_of_measurement        =$ArrayFunction->unit_of_measurement;

        $asset_category_list                        =AssetCategory::where('status_active',1)
                                                    ->whereIn('project_id',[0,$project_id])
                                                    ->get();

        $main_category=array();
        $sub_category=array();
        foreach($asset_category_list as $val)
        {
            if($val->root_item==0)
                $main_category[$val->id]=$val->item_name;
            else
                $sub_category[$val->id]=$val->item_name;
        }
       
        $fixed_asset_data=FixedAsset::where('project_id',$project_id)
                                        ->get();

        $sl=0;
        
        foreach ($fixed_asset_data as $key => $value) {

            $data['fixed_asset_list'][$key]['sl']                   =$sl+1;
            $data['fixed_asset_list'][$key]['id']                   =$value->id;
            $data['fixed_asset_list'][$key]['system_no']            =$value->system_no;
            $data['fixed_asset_list'][$key]['serial_no']            =$value->serial_no;
            $data['fixed_asset_list'][$key]['asset_category_string']=$main_category[$value->asset_category];
            $data['fixed_asset_list'][$key]['sub_category_string']  =$sub_category[$value->sub_category];
            $data['fixed_asset_list'][$key]['asset_name']           =$value->asset_name;
            $data['fixed_asset_list'][$key]['barcode']              =$value->barcode;
            $data['fixed_asset_list'][$key]['uom_string']           =$unit_of_measurement[$value->uom];
            $data['fixed_asset_list'][$key]['uom']                  =$value->uom;
            $data['fixed_asset_list'][$key]['model']                =$value->model;
            $data['fixed_asset_list'][$key]['color']                =$value->color;
            $sl++;
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
            'asset_category'            => 'required',
            'asset_name'                => 'required',
            'sub_category'              => 'required',
            'uom'                       => 'required',
            'condition'                 => 'required',
            'model'                     => 'required',
            'serial_no'                 => 'required',
            'barcode'                   => 'required',
            'color'                     => 'required',
            'length_uom'                => 'required',
            'item_length'               => 'required',
            'width_uom'                 => 'required',
            'item_width'                => 'required',
            'height_uom'                => 'required',
            'item_height'               => 'required',
            'status_active'             => 'required',
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        

        $max_system_data = FixedAsset::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from fixed_assets where  project_id=".$project_id." ) and project_id=".$project_id)->get(['system_prefix']);
                              
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="FA-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $fixed_asset_info= FixedAsset::create($request->all());

        foreach($request->account_type_arr as $key=>$details)
        {
                      
            if($details['chart_of_account']!="")
            {
                $data_account_type_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$fixed_asset_info->id,
                    'account_type'              =>$key,
                    'chart_of_account'          =>$details['chart_of_account'],
                    'page_id'                   =>4,
                    'chart_of_account_id'       =>$details['chart_of_account_id'],
                    'inserted_by'               =>$user_id,
                );
            }
                   
        } 

        $RId1=true;
        if(!empty($data_account_type_details))
        {
            $RId1=AccountType::insert($data_account_type_details);
        } 

        if($fixed_asset_info  && $RId1 )
        {
           DB::commit();
           return "1**$fixed_asset_info->id**$system_no";
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
        $user=\Auth::user();
        $project_id                             = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $unit_of_measurement        =$ArrayFunction->unit_of_measurement;
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;

        //===================Company==========================================
        $asset_category_list                        =AssetCategory::where('status_active',1)
                                                    ->whereIn('project_id',[0,$project_id])
                                                    ->get();

        $main_category=array();
        $sub_category=array();
        foreach($asset_category_list as $val)
        {
            if($val->root_item==0)
                $main_category[$val->id]=$val->item_name;
            else
                $sub_category[$val->root_item][$val->id]=$val->item_name;
        }

        $account_type_list                          =TaxTypeInitial::where('status_active',1)
                                                        ->where('type',4)
                                                        ->whereIn('project_id',[$project_id,0])
                                                        ->get();
        $account_type_arr=array();
        foreach ($account_type_list as $key => $value) {
            $account_type_arr[$value->id]['name']                   =$value->field_name;
            $account_type_arr[$value->id]['chart_of_account']       ="";
            $account_type_arr[$value->id]['chart_of_account_id']    ="";
            $account_type_arr[$value->id]['id']                     ="";
        }


        $account_type_sql =AccountType::where('status_active',1)->where('page_id',4)->where('master_id',$id)->get();
        foreach ($account_type_sql as $key => $value) {
            $account_type_arr[$value->account_type]['chart_of_account']       =$value->chart_of_account;
            $account_type_arr[$value->account_type]['chart_of_account_id']    =$value->chart_of_account_id;
            $account_type_arr[$value->account_type]['id']                     =$value->id;
        }

        $chart_of_account_list          =DB::table('chart_of_accounts as coa')
                                        ->join('coa_groups as group','coa.coa_group','=','group.reference_id')
                                        ->where('coa.project_id', '=', $project_id)
                                        ->where('group.project_id', '=', $project_id)
                                        ->get(['group.account_title','group.statement_type','coa.*']);
        $coa_arr=array();$sl=0;
        if(count($chart_of_account_list)>0)
        {
            foreach ($chart_of_account_list as $key => $value) {
                $coa_arr[$sl]['id']                   =$value->id;
                $coa_arr[$sl]['account_title']        =$value->account_title;
                $coa_arr[$sl]['account_no']           =$value->account_no;
                $coa_arr[$sl]['description']          =$value->description;
                $coa_arr[$sl]['govt_tax_code']        =$value->govt_tax_code;
                $coa_arr[$sl]['tax_code']             =$value->tax_code;
                $coa_arr[$sl]['sub_group']            =$value->sub_group;
                $coa_arr[$sl]['sub_group_name']       =$accounts_sub_group[$value->sub_group];
                $sl++;         
            }
        }


        $fixedAsset_data=FixedAsset::where('project_id',$project_id)
                                        ->where('id',$id)
                                        ->first();

        $data['coa_arr']                        =$coa_arr;
        $data['main_category']                  =$main_category;
        $data['sub_category']                   =$sub_category;
        $data['unit_of_measurement']            =$unit_of_measurement;
        $data['account_type_arr']               =$account_type_arr;
        $data['fixedAsset_data']                =$fixedAsset_data;
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
            'asset_category'            => 'required',
            'asset_name'                => 'required',
            'sub_category'              => 'required',
            'uom'                       => 'required',
            'condition'                 => 'required',
            'model'                     => 'required',
            'serial_no'                 => 'required',
            'barcode'                   => 'required',
            'color'                     => 'required',
            'length_uom'                => 'required',
            'item_length'               => 'required',
            'width_uom'                 => 'required',
            'item_width'                => 'required',
            'height_uom'                => 'required',
            'item_height'               => 'required',
            'status_active'             => 'required',
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        

        DB::beginTransaction();
        $fixed_asset_info= FixedAsset::find($id)->update($request->all());

        foreach($request->account_type_arr as $key=>$details)
        {
                      
            if($details['chart_of_account']!="")
            {
                if($details['id']!="")
                {
                    $account_type_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'account_type'              =>$key,
                        'chart_of_account'          =>$details['chart_of_account'],
                        'page_id'                   =>4,
                        'chart_of_account_id'       =>$details['chart_of_account_id'],
                        'updated_by'                =>$user_id,
                    );

                    $accountTypeData=AccountType::where('id',"=",$details['id'])->update($account_type_details_data);
                    if( !$accountTypeData)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_account_type_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'account_type'              =>$key,
                        'chart_of_account'          =>$details['chart_of_account'],
                        'page_id'                   =>4,
                        'chart_of_account_id'       =>$details['chart_of_account_id'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
        }


        $RId1=true;
        if(!empty($data_account_type_details))
        {
            $RId1=AccountType::insert($data_account_type_details);
        }
        if($fixed_asset_info  && $RId1)
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
