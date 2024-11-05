<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\AccountType;
use App\Models\ServiceItem;
use App\Models\ServiceType as ServiceType;
use App\Models\TaxType as TaxType;
use App\Models\TaxTypeInitial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceItemController extends Controller
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
        //===================Company==========================================
        $tax_type_list                          =TaxType::where('status_active',1)
                                                    ->where('project_id',$project_id)
                                                    ->whereIn('tax_type',[2,3])
                                                    ->get();

        $service_type_list                          =ServiceType::where('status_active',1)
                                                    ->whereIn('project_id',[0,$project_id])
                                                    ->get(['id','service_name']);

        $account_type_list                          =TaxTypeInitial::where('status_active',1)
                                                    ->where('type',3)
                                                    ->whereIn('project_id',[$project_id,0])
                                                    ->get();
        $account_type_arr=array();
        foreach ($account_type_list as $key => $value) {
            $account_type_arr[$value->id]['name']                   =$value->field_name;
            $account_type_arr[$value->id]['chart_of_account']       ="";
            $account_type_arr[$value->id]['chart_of_account_id']    ="";
            $account_type_arr[$value->id]['id']                     ="";
        }


        $ArrayFunction              =new ArrayFunction();
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        
        $sales_tax_arr=array();
        $purchase_tax_arr=array();
        foreach ($tax_type_list as $key => $value) {
            if($value->tax_type==3)
                $sales_tax_arr[$value->id]       =$value->tax_office_name;
            if($value->tax_type==2)
            {
                $purchase_tax_arr[$value->id]       =$value->tax_office_name;
            }
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
        $data['purchase_tax_arr']               =$purchase_tax_arr;
        $data['sales_tax_arr']                  =$sales_tax_arr;
        $data['account_type_arr']               =$account_type_arr;
        $data['item_category']                  =$item_category;
        $data['unit_of_measurement']            =$unit_of_measurement;
        $data['service_type_list']              =$service_type_list;

        return $data;
    }


    public function serviceItemList()
    {

        $user=\Auth::user();
        $project_id                             = $user->project_id;
        //===================Company==========================================

        $ArrayFunction              =new ArrayFunction();
        $item_category              =$ArrayFunction->item_category;
        $unit_of_measurement        =$ArrayFunction->unit_of_measurement;
       
        $ServiceItem_data=ServiceItem::where('project_id',$project_id)
                                        ->get();

        $tax_type_list                          =TaxType::where('status_active',1)
                                                    ->where('project_id',$project_id)
                                                    ->whereIn('tax_type',[2,3])
                                                    ->get();

        $sales_tax_arr=array();
        $purchase_tax_arr=array();
        foreach ($tax_type_list as $key => $value) {
            if($value->tax_type==3)
                $sales_tax_arr[$value->id]       =$value->tax_office_name;
            if($value->tax_type==2)
            {
                $purchase_tax_arr[$value->id]       =$value->tax_office_name;
            }
        }

        $service_type_list                          =ServiceType::where('status_active',1)
                                                    ->whereIn('project_id',[0,$project_id])
                                                    ->get(['id','service_name']);
        $service_category=array();

        foreach ($service_type_list as $key => $value) {
            $service_category[$value->id]=$value->service_name;
        }

        $sl=0;
        
        foreach ($ServiceItem_data as $key => $value) {

            $data['service_item_list'][$key]['sl']                      =$sl+1;
            $data['service_item_list'][$key]['id']                      =$value->id;
            $data['service_item_list'][$key]['system_no']               =$value->system_no;
            $data['service_item_list'][$key]['service_title']           =$value->service_title;
            $data['service_item_list'][$key]['service_category_string'] =$service_category[$value->service_category];
            $data['service_item_list'][$key]['service_description']     =$value->service_description;
            $data['service_item_list'][$key]['service_type']            =($value->service_type==1)? "Per Hour" : "Fixed";
            $data['service_item_list'][$key]['purchase_tax']            =$purchase_tax_arr[$value->purchase_tax];
            $data['service_item_list'][$key]['sales_tax']               =$sales_tax_arr[$value->sales_tax];
            $data['service_item_list'][$key]['service_cost']            =$value->service_cost;

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
            'service_category'          => 'required',
            'service_title'             => 'required',
            'service_description'       => 'required',
            'service_type'              => 'required',
            'service_cost'              => 'required',
            'purchase_tax'              => 'required',
            'sales_tax'                 => 'required',
            'status_active'             => 'required',
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        

        $max_system_data = ServiceItem::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from service_items where  project_id=".$project_id." ) and project_id=".$project_id)->get(['system_prefix']);
                              
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="SI-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $service_item_info= ServiceItem::create($request->all());


        foreach($request->account_type_arr as $key=>$details)
        {
                      
            if($details['chart_of_account']!="")
            {
                $data_account_type_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$service_item_info->id,
                    'account_type'              =>$key,
                    'chart_of_account'          =>$details['chart_of_account'],
                    'page_id'                   =>3,
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

        if($service_item_info  && $RId1 )
        {
           DB::commit();
           return "1**$service_item_info->id**$system_no";
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
        //===================Company================
        $tax_type_list                          =TaxType::where('status_active',1)
                                                    ->where('project_id',$project_id)
                                                    ->whereIn('tax_type',[2,3])
                                                    ->get();

        $service_type_list                      =ServiceType::where('status_active',1)
                                                    ->whereIn('project_id',[0,$project_id])
                                                    ->get(['id','service_name']);

        $account_type_list                      =TaxTypeInitial::where('status_active',1)
                                                    ->where('type',3)
                                                    ->whereIn('project_id',[$project_id,0])
                                                    ->get();
        $account_type_arr=array();
        foreach ($account_type_list as $key => $value) {
            $account_type_arr[$value->id]['name']                   =$value->field_name;
            $account_type_arr[$value->id]['chart_of_account']       ="";
            $account_type_arr[$value->id]['chart_of_account_id']    ="";
            $account_type_arr[$value->id]['id']                     ="";
        }

        $account_type_sql =AccountType::where('status_active',1)->where('page_id',3)->where('master_id',$id)->get();
        foreach ($account_type_sql as $key => $value) {
           // $account_type_arr[$value->account_type]['name']                   =$value->field_name;
            $account_type_arr[$value->account_type]['chart_of_account']       =$value->chart_of_account;
            $account_type_arr[$value->account_type]['chart_of_account_id']    =$value->chart_of_account_id;
            $account_type_arr[$value->account_type]['id']                     =$value->id;
        }

        //dd($account_type_arr);die;
        $ArrayFunction              =new ArrayFunction();
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        
        $sales_tax_arr=array();
        $purchase_tax_arr=array();
        foreach ($tax_type_list as $key => $value) {
            if($value->tax_type==3)
                $sales_tax_arr[$value->id]       =$value->tax_office_name;
            if($value->tax_type==2)
            {
                $purchase_tax_arr[$value->id]       =$value->tax_office_name;
            }
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


        $ServiceItem_data=ServiceItem::where('project_id',$project_id)
                                        ->where('id',$id)
                                        ->first();

        $data['coa_arr']                        =$coa_arr;
        $data['purchase_tax_arr']               =$purchase_tax_arr;
        $data['sales_tax_arr']                  =$sales_tax_arr;
        $data['account_type_arr']               =$account_type_arr;
        $data['ServiceItem_data']               =$ServiceItem_data;
        $data['service_type_list']              =$service_type_list;

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
            'service_category'          => 'required',
            'service_title'             => 'required',
            'service_description'       => 'required',
            'service_type'              => 'required',
            'service_cost'              => 'required',
            'purchase_tax'              => 'required',
            'sales_tax'                 => 'required',
            'status_active'             => 'required',
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        

        DB::beginTransaction();
        $tax_type_info= ServiceItem::find($id)->update($request->all());

        $data_subrooms_list_details="";
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
                        'page_id'                   =>3,
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
                        'page_id'                   =>3,
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
        if($tax_type_info  && $RId1)
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
