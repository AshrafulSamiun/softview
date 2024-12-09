<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccountHolderSeller;
use App\Models\Product;
use App\Models\InvoiceTerm;
use App\Models\PassDueInvoice;
use App\Models\PurchaseLimitPerSeller;
use App\Models\AllowTransactionPerSeller;
use App\Models\BannedPurchaseItemPerSeller;
use App\Models\SellerPaymentTerm;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Support\Facades\DB;
use App\Models\IncomeCenter;
use App\Models\CostCenter;
use App\Models\ServiceItem;
use App\Models\inventoryItem;
use App\Models\AccountActivation;
use App\Models\AccountHolderActivationDetails;
use App\Models\GroupActivationDetails;

class ActivationSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ArrayFunction              =new ArrayFunction();
        $account_holder_arr         =$ArrayFunction->account_holder_arr;
        $accounts_main_group        =$ArrayFunction->accounts_main_group;
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        $data['user_type']          =$user_type;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $account_activation_arr=array();
        foreach($account_holder_arr as $ind=>$val){
            $account_activation_arr[$ind]['id']             ="";
            $account_activation_arr[$ind]['account_holder'] =$val;
            $account_activation_arr[$ind]['status_active']  =2;
        }

        $main_group_arr=array();
        foreach($accounts_main_group as $ind=>$val){
            $main_group_arr[$ind]['id']                     ="";
            $main_group_arr[$ind]['main_group']             =$val;
            $main_group_arr[$ind]['status_active']          =2;
        }

        $AccountActivation_list     =AccountActivation::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->first(); 

        if(!empty($AccountActivation_list))
        {
            $data['AccountActivationID']               =$AccountActivation_list->id;
            $data['AccountActivationCompanyID']        =$AccountActivation_list->company_id;
            $data['AccountActivationPostingStatus']    =$AccountActivation_list->posting_status;
            $mst_id                                    =$AccountActivation_list->id;


            $account_holder_sql                             =AccountHolderActivationDetails::where('is_deleted',0)
                                                                ->where('project_id',$project_id)
                                                                ->where('company_id',$company_id)
                                                                ->where('is_deleted',0)
                                                                ->get();

            foreach($account_holder_sql as $ind=>$val){
                $account_activation_arr[$val->account_holder_id]['id']           =$val->id;
                $account_activation_arr[$val->account_holder_id]['status_active']=$val->status_active;
            }

            $account_group_sql                              =GroupActivationDetails::where('is_deleted',0)
                                                                ->where('project_id',$project_id)
                                                                ->where('company_id',$company_id)
                                                                ->where('is_deleted',0)
                                                                ->get();

            foreach($account_group_sql as $ind=>$val){
                $main_group_arr[$val->group_id]['id']                 =$val->id;
                $main_group_arr[$val->group_id]['status_active']      =$val->status_active;
            }
        }

          

        $cost_center_sql                                    =CostCenter::where('is_deleted',0)
                                                                ->where('project_id',$project_id)
                                                                ->where('company_id',$company_id)
                                                                ->where('is_deleted',0)
                                                                ->get();
        $cost_certer_arr=array();
        $sl=0;
        foreach($cost_center_sql as $value)
        {
            $cost_certer_arr[$sl]['id']                     =$value->id;
            $cost_certer_arr[$sl]['cost_center']            =$value->cost_center_name;
            $cost_certer_arr[$sl]['status_active']          =$value->status_active;
            $sl++;
        }

        $income_center_sql                                  =IncomeCenter::where('is_deleted',0)
                                                                ->where('project_id',$project_id)
                                                                ->where('company_id',$company_id)
                                                                ->where('is_deleted',0)
                                                                ->get();
        
        $income_certer_arr=array();
        $sl=0;
        foreach($income_center_sql as $value)
        {
            $income_certer_arr[$sl]['id']                   =$value->id;
            $income_certer_arr[$sl]['income_center']        =$value->income_center_name;
            $income_certer_arr[$sl]['status_active']        =$value->status_active;
            $sl++;
        }


        $service_item_sql                                   =ServiceItem::where('is_deleted',0)
                                                                ->where('project_id',$project_id)
                                                                //->where('company_id',$company_id)
                                                                ->where('is_deleted',0)
                                                                ->get();
        
        $service_item_arr=array();
        $sl=0;
        foreach($service_item_sql as $value)
        {
            $service_item_arr[$sl]['id']                    =$value->id;
            $service_item_arr[$sl]['service_title']         =$value->service_title;
            $service_item_arr[$sl]['status_active']         =$value->status_active;
            $sl++;
        }

        $inventory_item_sql                                 =inventoryItem::where('is_deleted',0)
                                                                ->where('project_id',$project_id)
                                                                ->where('company_id',$company_id)
                                                                ->where('is_deleted',0)
                                                                ->get();
        
        $inventory_item_arr=array();
        $sl=0;
        foreach($inventory_item_sql as $value)
        {
            $inventory_item_arr[$sl]['id']                  =$value->id;
            $inventory_item_arr[$sl]['item_name']           =$value->item_name;
            $inventory_item_arr[$sl]['status_active']       =$value->status_active;
            $sl++;
        }
       
        //$data['service_item_arr']       =$service_item_arr;
        $data['account_activation_arr']     =$account_activation_arr;
        $data['main_group_arr']             =$main_group_arr;
        $data['cost_certer_arr']            =$cost_certer_arr;
        $data['income_certer_arr']          =$income_certer_arr;
        $data['service_item_arr']           =$service_item_arr;
        $data['inventory_item_arr']         =$inventory_item_arr;
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
        

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['inserted_by'      =>$user_id]);
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['company_id'     =>$company_id]);       

        DB::beginTransaction();
        $account_activation_info= AccountActivation::create($request->all());
      
        foreach($request->account_activation_arr as $key=>$details)
        {
            $data_account_activation[]= array(
                'project_id'                =>$project_id,
                'mst_id'                    =>$account_activation_info->id,
                'company_id'                =>$company_id,
                'account_holder_id'         =>$key,
                'status_active'             =>$details['status_active'],
                'inserted_by'               =>$user_id,
            );
        } 

        foreach($request->main_group_arr as $key=>$details)
        {
                      
            $data_main_group[]= array(
                'project_id'                =>$project_id,
                'mst_id'                    =>$account_activation_info->id,
                'company_id'                =>$company_id,
                'group_id'                  =>$key,
                'status_active'             =>$details['status_active'],
                'inserted_by'               =>$user_id,
            );
                   
        }
       
        foreach($request->cost_certer_arr as $key=>$details)
        {            
            $data_cost_center= array(
                'status_active'             =>$details['status_active'],
                'updated_by'                 =>$user_id,
            );

            $costCenterData=CostCenter::where('id',"=",$details['id'])->update($data_cost_center);
            if( !$costCenterData)
            {
                DB::rollBack();
                return 40;
                die;
            }
        }

        foreach($request->income_certer_arr as $key=>$details)
        {            
            $data_income_center= array(
                'status_active'             =>$details['status_active'],
                'updated_by'                 =>$user_id,
            );

            $incomeCenterData=IncomeCenter::where('id',"=",$details['id'])->update($data_income_center);
            if( !$incomeCenterData)
            {
                DB::rollBack();
                return 30;
                die;
            }
        }

        foreach($request->inventory_item_arr as $key=>$details)
        {            
            $data_inventory_itme= array(
                'status_active'             =>$details['status_active'],
                'updated_by'                 =>$user_id,
            );

            $inventoryItemData=inventoryItem::where('id',"=",$details['id'])->update($data_inventory_itme);
            if( !$inventoryItemData)
            {
                DB::rollBack();
                return 20;
                die;
            }
        }

        foreach($request->service_item_arr as $key=>$details)
        {            
            $data_service_itme= array(
                'status_active'             =>$details['status_active'],
                'updated_by'                 =>$user_id,
            );

            $serviceItemData=ServiceItem::where('id',"=",$details['id'])->update($data_service_itme);
            if( !$serviceItemData)
            {
                DB::rollBack();
                return 100;
                die;
            }
        }   
        
        $RId1=true;
        $RId2=true;
        if(!empty($data_account_activation))
        {
            $RId1=AccountHolderActivationDetails::insert($data_account_activation);
        }

        if(!empty($data_main_group))
        {
            $RId2=GroupActivationDetails::insert($data_main_group);
        }

        if($account_activation_info  && $RId1 && $RId2)
        {
           DB::commit();
           return "1**$account_activation_info->id";
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
    public function edit($id,Request $request)
    {

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
        

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);


        DB::beginTransaction();
        $account_activation_info= AccountActivation::find($id)->update($request->all());

        foreach($request->account_activation_arr as $key=>$details)
        {
            if($details['id']!="")
            {

                $account_activation_data= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$id,
                    'company_id'                =>$company_id,
                    'account_holder_id'         =>$key,
                    'status_active'             =>$details['status_active'],
                    'updated_by'                =>$user_id,
                );

                $accountHolderActivation=AccountHolderActivationDetails::where('id',"=",$details['id'])->update($account_activation_data);
                    if( !$accountHolderActivation)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
            }
            else
            {
                $data_account_activation[]= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$id,
                    'company_id'                =>$company_id,
                    'account_holder_id'         =>$key,
                    'status_active'             =>$details['status_active'],
                    'inserted_by'               =>$user_id,
                );

            }
        } 

        foreach($request->main_group_arr as $key=>$details)
        {   
            if($details['id']!="")
            {

                $group_activation_data= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$id,
                    'company_id'                =>$company_id,
                    'group_id'                  =>$key,
                    'status_active'             =>$details['status_active'],
                    'updated_by'                =>$user_id,
                );

                $groupActivation=GroupActivationDetails::where('id',"=",$details['id'])->update($group_activation_data);
                    if( !$groupActivation)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
            }
            else
            {
                      
                $data_main_group[]= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$id,
                    'company_id'                =>$company_id,
                    'group_id'                  =>$key,
                    'status_active'             =>$details['status_active'],
                    'inserted_by'               =>$user_id,
                );
            }
                   
        }
       
        foreach($request->cost_certer_arr as $key=>$details)
        {            
            $data_cost_center= array(
                'status_active'             =>$details['status_active'],
                'updated_by'                 =>$user_id,
            );

            $costCenterData=CostCenter::where('id',"=",$details['id'])->update($data_cost_center);
            if( !$costCenterData)
            {
                DB::rollBack();
                return 10;
                die;
            }
        }

        foreach($request->income_certer_arr as $key=>$details)
        {            
            $data_income_center= array(
                'status_active'             =>$details['status_active'],
                'updated_by'                 =>$user_id,
            );

            $incomeCenterData=IncomeCenter::where('id',"=",$details['id'])->update($data_income_center);
            if( !$incomeCenterData)
            {
                DB::rollBack();
                return 30;
                die;
            }
        }

        foreach($request->inventory_item_arr as $key=>$details)
        {            
            $data_inventory_itme= array(
                'status_active'             =>$details['status_active'],
                'updated_by'                 =>$user_id,
            );

            $inventoryItemData=inventoryItem::where('id',"=",$details['id'])->update($data_inventory_itme);
            if( !$inventoryItemData)
            {
                DB::rollBack();
                return 20;
                die;
            }
        }

        foreach($request->service_item_arr as $key=>$details)
        {            
            $data_service_itme= array(
                'status_active'             =>$details['status_active'],
                'updated_by'                 =>$user_id,
            );

            $serviceItemData=ServiceItem::where('id',"=",$details['id'])->update($data_service_itme);
            if( !$serviceItemData)
            {
                DB::rollBack();
                return 100;
                die;
            }
        }   
        
        $RId1=true;
        $RId2=true;
        if(!empty($data_account_activation))
        {
            $RId1=AccountHolderActivationDetails::insert($data_account_activation);
        }

        if(!empty($data_main_group))
        {
            $RId2=GroupActivationDetails::insert($data_main_group);
        }
        

        if($account_activation_info  && $RId1 && $RId2)
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

    public function post(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>$request->input("posting_status"),
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=AccountActivation::where('id',"=",$id)->update($update_data);

        if($buildingInfo)
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
    public function adjust(Request $request, $id)
    {
        
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);
        $request->merge(['posting_status'   =>3]);


        DB::beginTransaction();
        $account_activation_info= AccountActivation::find($id)->update($request->all());

        foreach($request->account_activation_arr as $key=>$details)
        {
            if($details['id']!="")
            {

                $account_activation_data= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$id,
                    'company_id'                =>$company_id,
                    'account_holder_id'         =>$key,
                    'status_active'             =>$details['status_active'],
                    'updated_by'                =>$user_id,
                );

                $accountHolderActivation=AccountHolderActivationDetails::where('id',"=",$details['id'])->update($account_activation_data);
                    if( !$accountHolderActivation)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
            }
            else
            {
                $data_account_activation[]= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$id,
                    'company_id'                =>$company_id,
                    'account_holder_id'         =>$key,
                    'status_active'             =>$details['status_active'],
                    'inserted_by'               =>$user_id,
                );

            }
        } 

        foreach($request->main_group_arr as $key=>$details)
        {   
            if($details['id']!="")
            {

                $group_activation_data= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$id,
                    'company_id'                =>$company_id,
                    'group_id'                  =>$key,
                    'status_active'             =>$details['status_active'],
                    'updated_by'                =>$user_id,
                );

                $groupActivation=GroupActivationDetails::where('id',"=",$details['id'])->update($group_activation_data);
                    if( !$groupActivation)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
            }
            else
            {
                      
                $data_main_group[]= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$id,
                    'company_id'                =>$company_id,
                    'group_id'                  =>$key,
                    'status_active'             =>$details['status_active'],
                    'inserted_by'               =>$user_id,
                );
            }
                   
        }
       
        foreach($request->cost_certer_arr as $key=>$details)
        {            
            $data_cost_center= array(
                'status_active'             =>$details['status_active'],
                'updated_by'                 =>$user_id,
            );

            $costCenterData=CostCenter::where('id',"=",$details['id'])->update($data_cost_center);
            if( !$costCenterData)
            {
                DB::rollBack();
                return 10;
                die;
            }
        }

        foreach($request->income_certer_arr as $key=>$details)
        {            
            $data_income_center= array(
                'status_active'             =>$details['status_active'],
                'updated_by'                 =>$user_id,
            );

            $incomeCenterData=IncomeCenter::where('id',"=",$details['id'])->update($data_income_center);
            if( !$incomeCenterData)
            {
                DB::rollBack();
                return 30;
                die;
            }
        }

        foreach($request->inventory_item_arr as $key=>$details)
        {            
            $data_inventory_itme= array(
                'status_active'             =>$details['status_active'],
                'updated_by'                 =>$user_id,
            );

            $inventoryItemData=inventoryItem::where('id',"=",$details['id'])->update($data_inventory_itme);
            if( !$inventoryItemData)
            {
                DB::rollBack();
                return 20;
                die;
            }
        }

        foreach($request->service_item_arr as $key=>$details)
        {            
            $data_service_itme= array(
                'status_active'             =>$details['status_active'],
                'updated_by'                 =>$user_id,
            );

            $serviceItemData=ServiceItem::where('id',"=",$details['id'])->update($data_service_itme);
            if( !$serviceItemData)
            {
                DB::rollBack();
                return 100;
                die;
            }
        }  
         $RId1=true;
        $RId2=true;
        if(!empty($data_account_activation))
        {
            $RId1=AccountHolderActivationDetails::insert($data_account_activation);
        }

        if(!empty($data_main_group))
        {
            $RId2=GroupActivationDetails::insert($data_main_group);
        }
        

        if($account_activation_info  && $RId1 && $RId2)
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


    public function repost(Request $request,$id)
    {

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>4,
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=AccountActivation::where('id',"=",$id)->update($update_data);

        if($buildingInfo)
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
        $project_id=$user_data->project_id; 

        $RID_delete=true;
        $RID1_delete=true;
        $RID2_delete=true;
        $RID3_delete=true;
        $RID4_delete=true;
        $RID5_delete=true;

        $update_data= array(
                        
                            'status_active'             =>0,
                            'is_deleted'                =>1,
                            'updated_by'                =>$user_id,
                        );

        $RID_delete=AccountActivation::where('id',"=",$id)->update($update_data);
        $RID1_delete=PurchaseLimitPerSeller::where('master_id',"=",$id)->update($update_data);
        $RID2_delete=PassDueInvoice::where('master_id',"=",$id)->update($update_data);
        $RID3_delete=AllowTransactionPerSeller::where('master_id',"=",$id)->update($update_data);
        $RID4_delete=BannedPurchaseItemPerSeller::where('master_id',"=",$id)->update($update_data);
        $RID5_delete=SellerPaymentTerm::where('master_id',"=",$id)->update($update_data);


        if($RID_delete  && $RID1_delete && $RID2_delete && $RID3_delete && $RID4_delete && $RID5_delete)
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
