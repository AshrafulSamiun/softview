<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\InventoryItem;
use App\Models\TaxType as TaxType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class inventoryItemController extends Controller
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
        //dd($tax_type_list);die;
        $ArrayFunction              =new ArrayFunction();
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        $item_category              =$ArrayFunction->item_category;
        $unit_of_measurement        =$ArrayFunction->unit_of_measurement;
        $sales_tax_arr=array();
        $purchase_tax_arr=array();
        $account_type_arr=array();
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
                $coa_arr[$sl]['sub_group_name']     =$accounts_sub_group[$value->sub_group];
                $sl++;         
            }
        }

        $data['coa_arr']                        =$coa_arr;
        $data['purchase_tax_arr']               =$purchase_tax_arr;
        $data['sales_tax_arr']                  =$sales_tax_arr;
        $data['account_type_arr']               =$account_type_arr;
        $data['item_category']                  =$item_category;
        $data['unit_of_measurement']            =$unit_of_measurement;

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

    public function inventoryItemList()
    {

        $user=\Auth::user();
        $project_id                             = $user->project_id;
        //===================Company==========================================

        $ArrayFunction              =new ArrayFunction();
        $item_category              =$ArrayFunction->item_category;
        $unit_of_measurement        =$ArrayFunction->unit_of_measurement;
       
        $inventory_item_data=InventoryItem::where('project_id',$project_id)
                                        ->get();

        $sl=0;
        
        foreach ($inventory_item_data as $key => $value) {

            $data['inventory_item_list'][$key]['sl']                  =$sl+1;
            $data['inventory_item_list'][$key]['id']                  =$value->id;
            $data['inventory_item_list'][$key]['system_no']           =$value->system_no;
            $data['inventory_item_list'][$key]['tin_no']              =$value->tin_no;
            $data['inventory_item_list'][$key]['item_category_string']=$item_category[$value->item_category];
            $data['inventory_item_list'][$key]['item_name']           =$value->item_name;
            $data['inventory_item_list'][$key]['item_description']    =$value->item_description;
            $data['inventory_item_list'][$key]['uom_string']          =$unit_of_measurement[$value->uom];
            $data['inventory_item_list'][$key]['uom']                 =$value->uom;
            $data['inventory_item_list'][$key]['model']               =$value->model;
            $data['inventory_item_list'][$key]['chart_of_account']    =$value->chart_of_account;
            $sl++;
        }


        return $data;

    }

    public function inventoryItemData()
    {

        $user=\Auth::user();
        $project_id                             = $user->project_id;
        //===================Company==========================================

        $ArrayFunction              =new ArrayFunction();
        $item_category              =$ArrayFunction->item_category;
        $unit_of_measurement        =$ArrayFunction->unit_of_measurement;

        $inventory_item_data        =DB::table('inventory_items as mst')
                                        ->join('tax_types as dtls','mst.purchase_tax','=','dtls.id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                       // ->where('mst.building_name', '=', $building_id)
                                        //->where('dtls.master_id', '=', $building_id)
                                        ->get(['dtls.tax_rate','mst.*']);
        

        $sl=0;
        
        foreach ($inventory_item_data as $key => $value) {

            $data['inventory_item_list'][$key]['sl']                  =$sl+1;
            $data['inventory_item_list'][$key]['id']                  =$value->id;
            $data['inventory_item_list'][$key]['system_no']           =$value->system_no;
            $data['inventory_item_list'][$key]['item_category_string']=$item_category[$value->item_category];
            $data['inventory_item_list'][$key]['item_name']           =$value->item_name;
            $data['inventory_item_list'][$key]['item_description']    =$value->item_description;
            $data['inventory_item_list'][$key]['uom_string']          =$unit_of_measurement[$value->uom];
            $data['inventory_item_list'][$key]['uom']                 =$value->uom;
            $data['inventory_item_list'][$key]['model']               =$value->model;
            $data['inventory_item_list'][$key]['chart_of_account']    =$value->chart_of_account;
            $data['inventory_item_list'][$key]['tax']                 =$value->tax_rate;
            $sl++;
        }

        return $data;

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
            'item_category'             => 'required',
            'item_name'                 => 'required',
            'item_description'          => 'required',
            'uom'                       => 'required',
            'condition'                 => 'required',
            'model'                     => 'required',
            'storage_requirement'       => 'required',
            'negative_quantity'         => 'required',
            'negative_amount'           => 'required',
            'minimum_quantity'          => 'required',
            'maxmum_quantity'           => 'required',

            'length_uom'                => 'required',
            'item_length'               => 'required',
            'width_uom'                 => 'required',
            'item_width'                => 'required',
            'height_uom'                => 'required',
            'item_height'               => 'required',
            'sales_tax'                 => 'required',
            'purchase_tax'              => 'required',
            'status_active'             => 'required',
            'chart_of_account'          => 'required',
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        

        $max_system_data = InventoryItem::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from account_types where  project_id=".$project_id." ) and project_id=".$project_id)->get(['system_prefix']);
                              
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="II-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $inventory_item_info= InventoryItem::create($request->all());



        if($inventory_item_info)
        {
           DB::commit();
           return "1**$inventory_item_info->id**$system_no";
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
        //===================Company==========================================
        $tax_type_list                          =TaxType::where('status_active',1)
                                                    ->where('project_id',$project_id)
                                                    ->whereIn('tax_type',[2,3])
                                                    ->get();
        //dd($tax_type_list);die;
        $ArrayFunction              =new ArrayFunction();
        $accounts_sub_group         =$ArrayFunction->accounts_sub_group;
        $item_category              =$ArrayFunction->item_category;
        $unit_of_measurement        =$ArrayFunction->unit_of_measurement;
        $sales_tax_arr=array();
        $purchase_tax_arr=array();
        $account_type_arr=array();
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
                $coa_arr[$sl]['sub_group_name']     =$accounts_sub_group[$value->sub_group];
                $sl++;         
            }
        }

        $inventory_data=InventoryItem::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$id)
                                    ->first();

        $data['inventory_data_arr']             =$inventory_data;
        $data['coa_arr']                        =$coa_arr;
        $data['purchase_tax_arr']               =$purchase_tax_arr;
        $data['sales_tax_arr']                  =$sales_tax_arr;
        $data['item_category']                  =$item_category;
        $data['unit_of_measurement']            =$unit_of_measurement;
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
            'item_category'             => 'required',
            'item_name'                 => 'required',
            'item_description'          => 'required',
            'uom'                       => 'required',
            'condition'                 => 'required',
            'model'                     => 'required',
            'storage_requirement'       => 'required',
            'negative_quantity'         => 'required',
            'negative_amount'           => 'required',
            'minimum_quantity'          => 'required',
            'maxmum_quantity'           => 'required',
            'length_uom'                => 'required',
            'item_length'               => 'required',
            'width_uom'                 => 'required',
            'item_width'                => 'required',
            'height_uom'                => 'required',
            'item_height'               => 'required',
            'sales_tax'                 => 'required',
            'purchase_tax'              => 'required',
            'status_active'             => 'required',
            'chart_of_account'          => 'required',
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        

       

        DB::beginTransaction();
        $inventory_item_info= InventoryItem::find($id)->update($request->all());



        if($inventory_item_info)
        {
           DB::commit();
           return "1**$id**";
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

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        DB::beginTransaction();
        $inventory_item_info= InventoryItem::find($id)->update(['updated_by'=>$user_id,'status_active'=>0,'is_deleted'=>1]);



        if($inventory_item_info)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }
}
