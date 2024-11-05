<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\AccountCompany as AccountCompany;
use App\Models\BikeStall;
use App\Models\BuildingInfo as BuildingInfo;
use App\Models\CommercialUnit;
use App\Models\CommonAreaDetails;
use App\Models\Company;
use App\Models\Customer;
use App\Models\MailBox;
use App\Models\ParkingStall;
use App\Models\PropertyAttribution;
use App\Models\PropertyAttributionDetails;
use App\Models\ResidentialSuite;
use App\Models\StorageLocker;
use App\Models\SupportingRoomDetails;
use App\Models\UomSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyAttributionController extends Controller
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
        
        //===================Company==========================================
        $main_company_list          =AccountCompany::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get();
        $main_company_arr=array();
        foreach ($main_company_list as $key => $value) {
            $main_company_arr[$value->id]   =$value->legal_name;
            $data['main_company_id']        =$value->id;

        }
        $data['main_company_arr']        =$main_company_arr;

        //===================Company==========================================
        $company_list               =Company::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get();
        $company_arr=array();
        foreach ($company_list as $key => $value) {
            $company_arr[$value->id]=$value->legal_name;
        }
        $data['company_arr']        =$company_arr;


        //===================Customer==========================================
        $customer_list              =Customer::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('customer_type',1)
                                    ->whereNull('company_id')
                                    ->get();
        $customer_arr=array();
        foreach ($customer_list as $key => $value) {
            $customer_arr[$value->id]=$value->legal_name;
        }

        $data['customer_arr']        =$customer_arr;

        $uom_setting              =UomSetting::where('status_active',1)
                                    ->where('project_id',$project_id)
                                  //  ->where('customer_type',1)
                                   // ->whereNull('company_id')
                                    ->first();

        $data['uom_setting']    =$uom_setting->uom;
        //dd($building_arr);
        return $data;

    }
    public function PropertyAttributionsList()
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        //===================Company==========================================
        $main_company_list          =AccountCompany::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->first();
        
        
        $main_company_name=$main_company_list->legal_name;
        

        //===================Company==========================================
        $company_list               =Company::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get();
        $company_arr=array();
        foreach ($company_list as $key => $value) {
            $company_arr[$value->id]=$value->legal_name;
        }
        //===================Customer==========================================
        $customer_list              =Customer::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('customer_type',1)
                                    ->get();
        $customer_arr=array();
        foreach ($customer_list as $key => $value) {
            $customer_arr[$value->id]=$value->legal_name;
        }


        $building_list              =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get(['id','building_no','building_name']);

        //===================Building==========================================

        $building_arr=array();
        foreach ($building_list as $key => $value) {
            $building_arr[$value->id]=$value->building_no;
        }

      

        //===================Commercial Unit==========================================
        $commercial_unit              =CommercialUnit::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get();
        $commercial_unit_arr=array();
        foreach ($commercial_unit as $key => $value) {
            $commercial_unit_arr[$value->id]=$value->system_no;
        }

        //===================Commercial Unit==========================================
        $residential_suite              =ResidentialSuite::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get();
        $residential_suite_arr=array();
        foreach ($residential_suite as $key => $value) {
            $residential_suite_arr[$value->id]=$value->system_no;
        }



        $sl=0;
        $property_attribution_list=PropertyAttribution::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->get();
                                        //dd($property_attribution_list);die;
         foreach ($property_attribution_list as $key => $value) {

            $data['property_attribution_list'][$key]['sl']                      =$sl+1;
            $data['property_attribution_list'][$key]['id']                      =$value->id;
            $data['property_attribution_list'][$key]['system_no']               =$value->system_no;
            $data['property_attribution_list'][$key]['main_company_name']       =$main_company_name;
            $data['property_attribution_list'][$key]['total_property_size_qty'] =$value->total_property_size_qty;
            

            if($value->suite_id>0)
            {
                $data['property_attribution_list'][$key]['property_type']    ="Residential Suite";
                $data['property_attribution_list'][$key]['property_name']    =$residential_suite_arr[$value->suite_id];

            }
            else
            {
                $data['property_attribution_list'][$key]['property_type']    ="Commercial Unit";
                $data['property_attribution_list'][$key]['property_name']    =$commercial_unit_arr[$value->unit_id];
            }


            if($value->company_name>0)
            {
                $data['property_attribution_list'][$key]['sub_company_name']     =$company_arr[$value->company_name];

            }
            else
            {
                $data['property_attribution_list'][$key]['sub_company_name']      ="";

            }

            if($value->customer_name>0)
            {
                $data['property_attribution_list'][$key]['customer_name']     =$customer_arr[$value->customer_name];

            }
            else
            {
                $data['property_attribution_list'][$key]['customer_name']      ="";

            }

            if($value->building_id>0)
            {
                $data['property_attribution_list'][$key]['building_name']     =$building_arr[$value->building_id];

            }
            else
            {
                $data['property_attribution_list'][$key]['building_name']      ="";

            }

            

            
            $sl++;

        }

       // $data['commercial_unit_list']        =$commercial_unit_list;
        
        return $data;

    }
    public function property_building($company,$customer,$building_type)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        

        $building_sql               =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id);

        if($company>0)              $building_sql->where('company_name',$company);
        else                        $building_sql->whereNull('company_name');

        if($customer>0)             $building_sql->where('customer_name',$customer);
        else                        $building_sql->whereNull('customer_name');

        if($building_type==1)       $building_sql->where('residential',1);
        else  if($building_type==2) $building_sql->where('commercial',1);
        else  if($building_type==3) $building_sql->where('residential_commercial',1);
        
        $building_list              =$building_sql->get();

       // dd($building_list);
        $building_arr=array();
        foreach ($building_list as $key => $value) {
           
            
            $building_arr[$value->id]['building_no']=$value->building_no;
            $building_arr[$value->id]['building_name']=$value->building_name;
            $building_arr[$value->id]['building_uom']=$value->building_uom;
            $building_arr[$value->id]['total_building_size']=$value->total_building_size;
            $building_arr[$value->id]['number_of_floor']=$value->number_of_floor;
            
        }

        $data['building_arr']        =$building_arr;


        
        return $data;
        
    }
    public function suite_by_building($building_id,$suite_type)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;

        $suite_sql                  =ResidentialSuite::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('building_name',$building_id)
                                    ->where('suite_type',$suite_type)
                                    ->get();

        
        $floor_list                 =DB::table('floors as mst')
                                        ->join('building_property_details as dtls','mst.floor_no','=','dtls.id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.master_id', '=', $building_id)
                                        ->where('dtls.total_suite', '>', 0)
                                        ->get(['dtls.floor_no','dtls.floor_type','dtls.total_suite','mst.id','mst.floor_name']);
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {
            $floor_arr[$value->id]=$value->floor_no;
        }
        

        $suite_arr=array();
        foreach ($suite_sql as $key => $value) {

            $suite_arr[$value->id]['property_name']     =$value->property_name;
            $suite_arr[$value->id]['system_no']         =$value->system_no;
            $suite_arr[$value->id]['suite_no']          =$value->suite_no;
            $suite_arr[$value->id]['total_suite_size']  =$value->total_suite_size;
            $suite_arr[$value->id]['suite_uom']         =$value->suite_uom;
            $suite_arr[$value->id]['suite_floor_id']    =$value->floor_no;
            $suite_arr[$value->id]['suite_floor_name']  =$value->floor->floor_name;
            $suite_arr[$value->id]['suite_floor_no']    =$floor_arr[$value->floor_no];
            
        }

        $data['suite_arr']        =$suite_arr;
        return $data; 
    }

    public function property_by_building($building_id)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $stall_type_arr             =$ArrayFunction->stall_type_arr;
        $storage_type_arr           =$ArrayFunction->storage_type_arr;



        $floor_list                 =DB::table('floors as mst')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->get(['mst.id','mst.floor_name']);
       
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {

            $floor_arr[$value->id]               =$value->floor_name;

        }

        $parking_stall_details          =DB::table('parking_lots as mst')
                                        ->join('parking_levels as dtls','mst.id','=','dtls.master_id')
                                       // ->join('parking_stalls as stall','dtls.master_id','=','stall.master_id')
                                        ->join('parking_stalls as stall', function($join)
                                         {
                                             $join->on('dtls.master_id', '=', 'stall.master_id');
                                             $join->on('dtls.details_id', '=', 'stall.details_id');
                                             
                                         })
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('stall.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.status_active', '=', 1)
                                        ->where('mst.status_active', '=', 1)
                                        ->where('stall.status_active', '=', 1)
                                        ->select(['mst.id as mst_id','mst.floor_no','mst.property_name as mst_property_name','dtls.property_name as dtls_property_name','mst.lot_uom','stall.*'])
                                        ->get();
       // echo $parking_stall_details;die;
       
        $parking_stall_arr=array();
        $parking_lot_arr=array();

        $sl=0;
        foreach ($parking_stall_details as $key => $value) {
            
            $parking_stall_arr[$sl]['mst_property_name']    =$value->mst_property_name;
            $parking_stall_arr[$sl]['parking_level']        =$value->dtls_property_name;
            $parking_stall_arr[$sl]['floor_no']             =$floor_arr[$value->floor_no];
            $parking_stall_arr[$sl]['update_id']            ="";
            $parking_stall_arr[$sl]['id']                   =$value->id;
            $parking_stall_arr[$sl]['mst_id']               =$value->mst_id;
            $parking_stall_arr[$sl]['level_no']             =$value->details_id;
            $parking_stall_arr[$sl]['item_name']            =$value->item_name;
            $parking_stall_arr[$sl]['system_no']            =$value->system_no;
            $parking_stall_arr[$sl]['lot_uom']              =$value->lot_uom;
            $parking_stall_arr[$sl]['item_size']            =$value->item_size;
            $parking_stall_arr[$sl]['property_name']        =$value->property_name;
            $parking_stall_arr[$sl]['allocated']            =$value->allocated;
            $parking_stall_arr[$sl]['previous_allocated']   =$value->allocated;
            $parking_stall_arr[$sl]['update_id']        ="";
            $parking_stall_arr[$sl]['current_allocated']=0;
            $parking_lot_arr[$value->mst_id]['property_name']=$value->mst_property_name;
            if($value->allocated)
            {
                $parking_stall_arr[$sl]['allocated_string']="Allocated";
                if(empty($parking_lot_arr[$value->mst_id]['allocated']))
                    $parking_lot_arr[$value->mst_id]['allocated']=$value->item_size*1;
                else
                   $parking_lot_arr[$value->mst_id]['allocated']+=$value->item_size*1; 
            }
            else
            {
                $parking_stall_arr[$sl]['allocated_string']="Un Allocated"; 
                if(empty($parking_lot_arr[$value->mst_id]['unallocated']))
                    $parking_lot_arr[$value->mst_id]['unallocated']=$value->item_size*1;
                else
                    $parking_lot_arr[$value->mst_id]['unallocated']+=$value->item_size*1;
            }

            $stall_type="";


            if($value->stall_type_1==true) $stall_type=$stall_type_arr[1];
            else if($value->stall_type_2==true) $stall_type=$stall_type_arr[2];
            else if($value->stall_type_3==true) $stall_type=$stall_type_arr[3];
            else if($value->stall_type_4==true) $stall_type=$stall_type_arr[4];
            else if($value->stall_type_5==true) $stall_type=$stall_type_arr[5];
            else if($value->stall_type_6==true) $stall_type=$stall_type_arr[6];
            else if($value->stall_type_7==true) $stall_type=$stall_type_arr[7];
            else if($value->stall_type_8==true) $stall_type=$stall_type_arr[8];
            else if($value->stall_type_9==true) $stall_type=$stall_type_arr[9];
            else if($value->stall_type_10==true) $stall_type=$stall_type_arr[10];
            else if($value->stall_type_11==true) $stall_type=$stall_type_arr[11];
            $parking_stall_arr[$sl]['stall_type']  =$stall_type;

            $sl++;
        }


        $bike_stall_details         =DB::table('bike_lots as mst')
                                        ->join('bike_levels as dtls','mst.id','=','dtls.master_id')
                                        ->join('bike_stalls as stall', function($join)
                                         {
                                             $join->on('dtls.master_id', '=', 'stall.master_id');
                                             $join->on('dtls.details_id', '=', 'stall.details_id');
                                             
                                         })
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('stall.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.status_active', '=', 1)
                                        ->where('mst.status_active', '=', 1)
                                        ->where('stall.status_active', '=', 1)
                                        ->select(['mst.id as mst_id','mst.floor_no','mst.property_name as mst_property_name','dtls.property_name as dtls_property_name','mst.lot_uom','stall.*'])
                                        ->get();
       
        $bike_stall_arr=array();
        $bike_lot_arr=array();
        $sl=0;
        foreach ($bike_stall_details as $key => $value) {
            
            $bike_stall_arr[$sl]['mst_property_name']    =$value->mst_property_name;
            $bike_stall_arr[$sl]['bike_level']           =$value->dtls_property_name;
            $bike_stall_arr[$sl]['floor_no']             =$floor_arr[$value->floor_no];
            $bike_stall_arr[$sl]['update_id']            ="";
            $bike_stall_arr[$sl]['id']                   =$value->id;
            $bike_stall_arr[$sl]['mst_id']               =$value->mst_id;
            $bike_stall_arr[$sl]['level_no']             =$value->details_id;
            $bike_stall_arr[$sl]['item_name']            =$value->item_name;
            $bike_stall_arr[$sl]['system_no']            =$value->system_no;
            $bike_stall_arr[$sl]['lot_uom']              =$value->lot_uom;
            $bike_stall_arr[$sl]['item_size']            =$value->item_size;
            $bike_stall_arr[$sl]['property_name']        =$value->property_name;
            $bike_stall_arr[$sl]['allocated']            =$value->allocated;
            $bike_stall_arr[$sl]['previous_allocated']   =$value->allocated;
            $bike_stall_arr[$sl]['update_id']           ="";
            $bike_stall_arr[$sl]['current_allocated']   =0;

            $bike_lot_arr[$value->mst_id]['property_name']=$value->mst_property_name;
            if($value->allocated)
            {
                $bike_stall_arr[$sl]['allocated_string']="Allocated";
                if(empty($bike_lot_arr[$value->mst_id]['allocated']))
                    $bike_lot_arr[$value->mst_id]['allocated']=$value->item_size*1;
                else
                   $bike_lot_arr[$value->mst_id]['allocated']+=$value->item_size*1; 
            }
            else
            {
                $bike_stall_arr[$sl]['allocated_string']="Un Allocated"; 
                if(empty($bike_lot_arr[$value->mst_id]['unallocated']))
                    $bike_lot_arr[$value->mst_id]['unallocated']=$value->item_size*1;
                else
                    $bike_lot_arr[$value->mst_id]['unallocated']+=$value->item_size*1;
            }

            
            if(empty($bike_lot_arr[$value->mst_id]['unallocated']))
                $bike_lot_arr[$value->mst_id]['unallocated']=0;

            if(empty($bike_lot_arr[$value->mst_id]['allocated']))
                $bike_lot_arr[$value->mst_id]['allocated']=0;

            $stall_type="";
            if($value->stall_type_1==true) $stall_type=$stall_type_arr[1];
            else if($value->stall_type_2==true) $stall_type=$stall_type_arr[2];
            else if($value->stall_type_3==true) $stall_type=$stall_type_arr[3];
            else if($value->stall_type_4==true) $stall_type=$stall_type_arr[4];
            else if($value->stall_type_5==true) $stall_type=$stall_type_arr[5];
            else if($value->stall_type_6==true) $stall_type=$stall_type_arr[6];
            else if($value->stall_type_7==true) $stall_type=$stall_type_arr[7];
            else if($value->stall_type_8==true) $stall_type=$stall_type_arr[8];
            else if($value->stall_type_9==true) $stall_type=$stall_type_arr[9];
            else if($value->stall_type_10==true) $stall_type=$stall_type_arr[10];
            else if($value->stall_type_11==true) $stall_type=$stall_type_arr[11];
            $bike_stall_arr[$sl]['stall_type']  =$stall_type;

            $sl++;
            
        }


        $storage_locker_details         =DB::table('storage_lots as mst')
                                        ->join('storage_levels as dtls','mst.id','=','dtls.master_id')
                                        //->join('storage_lockers as locker','dtls.master_id','=','locker.master_id')
                                        ->join('storage_lockers as locker', function($join)
                                         {
                                             $join->on('dtls.master_id', '=', 'locker.master_id');
                                             $join->on('dtls.details_id', '=', 'locker.details_id');
                                             
                                         })
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.status_active', '=', 1)
                                        ->where('mst.status_active', '=', 1)
                                        ->where('locker.status_active', '=', 1)
                                        ->select(['mst.id as mst_id','mst.floor_no','mst.property_name as mst_property_name','dtls.property_name as dtls_property_name','mst.lot_uom','locker.*'])
                                        ->get();
       
        $storage_locker_arr=array();
        $storage_lot_arr=array();
        $sl=0;
        foreach ($storage_locker_details as $key => $value) {
            
            $storage_locker_arr[$sl]['mst_property_name']        =$value->mst_property_name;
            $storage_locker_arr[$sl]['storage_level']            =$value->dtls_property_name;
            $storage_locker_arr[$sl]['floor_no']                 =$floor_arr[$value->floor_no];
            $storage_locker_arr[$sl]['update_id']      ="";
            $storage_locker_arr[$sl]['id']             =$value->id;
            $storage_locker_arr[$sl]['mst_id']         =$value->mst_id;
            $storage_locker_arr[$sl]['level_no']       =$value->details_id;
            $storage_locker_arr[$sl]['item_name']      =$value->item_name;
            $storage_locker_arr[$sl]['system_no']      =$value->system_no;
            $storage_locker_arr[$sl]['lot_uom']        =$value->lot_uom;
            $storage_locker_arr[$sl]['item_size']      =$value->item_size;
            $storage_locker_arr[$sl]['property_name']  =$value->property_name;
            //$storage_locker_arr[$sl]['allocated']       =false;
            $storage_locker_arr[$sl]['update_id']           ="";
            $storage_locker_arr[$sl]['current_allocated']   =0;

            $storage_locker_arr[$sl]['allocated']            =$value->allocated;
            $storage_locker_arr[$sl]['previous_allocated']   =$value->allocated;

            $storage_lot_arr[$value->mst_id]['property_name']=$value->mst_property_name;
            if($value->allocated)
            {
                $storage_locker_arr[$sl]['allocated_string']="Allocated";
                if(empty($storage_lot_arr[$value->mst_id]['allocated']))
                    $storage_lot_arr[$value->mst_id]['allocated']=$value->item_size*1;
                else
                   $storage_lot_arr[$value->mst_id]['allocated']+=$value->item_size*1; 
            }
            else
            {
                $storage_locker_arr[$sl]['allocated_string']="Un Allocated"; 
                if(empty($storage_lot_arr[$value->mst_id]['unallocated']))
                    $storage_lot_arr[$value->mst_id]['unallocated']=$value->item_size*1;
                else
                    $storage_lot_arr[$value->mst_id]['unallocated']+=$value->item_size*1;
            }

            
            if(empty($storage_lot_arr[$value->mst_id]['unallocated']))
                $storage_lot_arr[$value->mst_id]['unallocated']=0;

            if(empty($storage_lot_arr[$value->mst_id]['allocated']))
                $storage_lot_arr[$value->mst_id]['allocated']=0;

            $stall_type="";


            if($value->storage_type_1==true) $stall_type=$storage_type_arr[1];
            else if($value->storage_type_2==true) $stall_type=$storage_type_arr[2];
            else if($value->storage_type_3==true) $stall_type=$storage_type_arr[3];
            else if($value->storage_type_4==true) $stall_type=$storage_type_arr[4];
            else if($value->storage_type_5==true) $stall_type=$storage_type_arr[5];
            else if($value->storage_type_6==true) $stall_type=$storage_type_arr[6];
            else if($value->storage_type_7==true) $stall_type=$storage_type_arr[7];
            else if($value->storage_type_8==true) $stall_type=$storage_type_arr[8];

            $storage_locker_arr[$sl]['stall_type']  =$stall_type;

            $sl++;
            
        }


        $mail_box_details         =DB::table('mail_rooms as mst')
                                        ->join('mail_boxes as box','mst.id','=','box.master_id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('box.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('mst.status_active', '=', 1)
                                        ->where('box.status_active', '=', 1)
                                        ->select(['mst.id as mst_id','mst.floor_no','mst.property_name as mst_property_name','mst.room_uom','box.*'])
                                        ->get();
       
        $mail_box_arr=array();
        $mail_room_arr=array();
        $sl=0;
        foreach ($mail_box_details as $key => $value) {
            
            $mail_box_arr[$sl]['mst_property_name']        =$value->mst_property_name;
            $mail_box_arr[$sl]['floor_no']                 =$floor_arr[$value->floor_no];
            $mail_box_arr[$sl]['update_id']      ="";
            $mail_box_arr[$sl]['id']             =$value->id;
            $mail_box_arr[$sl]['mst_id']         =$value->mst_id;
            $mail_box_arr[$sl]['item_name']      =$value->item_name;
            $mail_box_arr[$sl]['system_no']      =$value->system_no;
            $mail_box_arr[$sl]['room_uom']       =$value->room_uom;
            $mail_box_arr[$sl]['item_size']      =$value->item_size;
            $mail_box_arr[$sl]['property_name']  =$value->property_name;
            $mail_box_arr[$sl]['allocated']            =$value->allocated;
            $mail_box_arr[$sl]['previous_allocated']   =$value->allocated;
            $mail_room_arr[$value->mst_id]['property_name']=$value->mst_property_name;
            $mail_box_arr[$sl]['current_allocated']         =0;
            $mail_box_arr[$sl]['update_id']                 ="";
            if($value->allocated)
            {
                $mail_box_arr[$sl]['allocated_string']="Allocated";
                if(empty($mail_room_arr[$value->mst_id]['allocated']))
                    $mail_room_arr[$value->mst_id]['allocated']=$value->item_size*1;
                else
                   $mail_room_arr[$value->mst_id]['allocated']+=$value->item_size*1; 
            }
            else
            {
                $mail_box_arr[$sl]['allocated_string']="Un Allocated"; 
                if(empty($mail_room_arr[$value->mst_id]['unallocated']))
                    $mail_room_arr[$value->mst_id]['unallocated']=$value->item_size*1;
                else
                    $mail_room_arr[$value->mst_id]['unallocated']+=$value->item_size*1;
            }

            
            if(empty($mail_room_arr[$value->mst_id]['unallocated']))
                $mail_room_arr[$value->mst_id]['unallocated']=0;

            if(empty($mail_room_arr[$value->mst_id]['allocated']))
                $mail_room_arr[$value->mst_id]['allocated']=0;
            $sl++;
            
        }


        $common_area_details         =DB::table('common_areas as mst')
                                        ->join('common_area_details as dtls','mst.id','=','dtls.master_id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('mst.status_active', '=', 1)
                                        ->where('dtls.status_active', '=', 1)
                                        ->select(['mst.id as mst_id','mst.floor_no','mst.property_name as mst_property_name','mst.single_subroom_uom','dtls.*'])
                                        ->get();
       
        $common_area_arr=array();
        $sl=0;
        foreach ($common_area_details as $key => $value) {
            
            $common_area_arr[$sl]['mst_property_name']        =$value->mst_property_name;
            $common_area_arr[$sl]['floor_no']                 =$floor_arr[$value->floor_no];
            $common_area_arr[$sl]['update_id']          ="";
            $common_area_arr[$sl]['id']                 =$value->id;
            $common_area_arr[$sl]['mst_id']             =$value->mst_id;
            $common_area_arr[$sl]['item_name']          =$value->item_name;
            $common_area_arr[$sl]['system_no']          =$value->system_no;
            $common_area_arr[$sl]['uom']                =$value->uom;
            $common_area_arr[$sl]['item_size']          =$value->item_size;

            $common_area_arr[$sl]['allocated_size']     ='';
            $common_area_arr[$sl]['property_name']      =$value->property_name;
            $common_area_arr[$sl]['allocated']          =false;
            $common_area_arr[$sl]['update_id']          ="";
            $common_area_arr[$sl]['allocated_size']     ="";
            $common_area_arr[$sl]['previous_allocated'] =$value->allocated_size;
            $common_area_arr[$sl]['actual_allocated']   =$value->allocated_size;
            $common_area_arr[$sl]['available']          =$value->item_size-$value->allocated_size;
            $common_area_arr[$sl]['available_actual']   =$value->item_size-$value->allocated_size;
            $sl++;
            
        }


        $service_room_details         =DB::table('supporting_rooms as mst')
                                        ->join('supporting_room_details as dtls','mst.id','=','dtls.master_id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('mst.status_active', '=', 1)
                                        ->where('dtls.status_active', '=', 1)
                                        ->select(['mst.id as mst_id','mst.floor_no','mst.system_no as mst_property_name','dtls.*'])
                                        ->get();
       
        $service_room_arr=array();
        $sl=0;
        $total_service_room=0;
        $total_aminity_room=0;
        $total_administrition_room=0;
        $total_machanical_room=0;

        foreach ($service_room_details as $key => $value) {
            
            $service_room_arr[$sl]['mst_property_name']         =$value->mst_property_name;
            $service_room_arr[$sl]['floor_no']                  =$floor_arr[$value->floor_no];
            $service_room_arr[$sl]['update_id']                 ="";
            $service_room_arr[$sl]['id']                        =$value->id;
            $service_room_arr[$sl]['mst_id']                    =$value->mst_id;
            $service_room_arr[$sl]['item_name']                 =$value->item_name;
            $service_room_arr[$sl]['item_type']                 =$value->item_type;
            $service_room_arr[$sl]['system_no']                 =$value->system_no;
            $service_room_arr[$sl]['uom']                       =$value->uom;
            $service_room_arr[$sl]['item_size']                 =$value->item_size;
            $service_room_arr[$sl]['property_name']             =$value->property_name;
            $service_room_arr[$sl]['allocated']                 =false;
            $service_room_arr[$sl]['allocated_size']            ="";
            $service_room_arr[$sl]['previous_allocated']        =$value->allocated_size;
            $service_room_arr[$sl]['actual_allocated']          =$value->allocated_size;
            $service_room_arr[$sl]['available']                 =$value->item_size-$value->allocated_size;
            $service_room_arr[$sl]['available_actual']          =$value->item_size-$value->allocated_size;
            $service_room_arr[$sl]['update_id']                 ="";

            if($value->item_type==7) $total_machanical_room++;
            if($value->item_type==8) $total_administrition_room++;
            if($value->item_type==9) $total_aminity_room++;
            if($value->item_type==10) $total_service_room++;
            $sl++;
            
        }


        $data['parking_stall_arr']          =$parking_stall_arr;
        $data['bike_stall_arr']             =$bike_stall_arr;
        $data['storage_locker_arr']         =$storage_locker_arr;
        $data['mail_box_arr']               =$mail_box_arr;
        $data['common_area_arr']            =$common_area_arr;
        $data['service_room_arr']           =$service_room_arr;
        $data['total_machanical_room']      =$total_machanical_room;
        $data['total_administrition_room']  =$total_administrition_room;
        $data['total_aminity_room']         =$total_aminity_room;
        $data['total_service_room']         =$total_service_room;
        $data['parking_lot_arr']            =$parking_lot_arr;
        $data['bike_lot_arr']               =$bike_lot_arr;
        $data['storage_lot_arr']            =$storage_lot_arr;
        $data['mail_room_arr']              =$mail_room_arr;

        


        return $data;
    }


    public function unit_by_building($building_id,$unit_type)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;

        $unit_sql                  =CommercialUnit::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('building_name',$building_id)
                                    ->where('unit_type',$unit_type)
                                    ->get();

        
        $floor_list                 =DB::table('floors as mst')
                                        ->join('building_property_details as dtls','mst.floor_no','=','dtls.id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.master_id', '=', $building_id)
                                        ->where('dtls.total_unit', '>', 0)
                                        ->get(['dtls.floor_no','dtls.floor_type','dtls.total_unit','mst.id','mst.floor_name']);
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {
            $floor_arr[$value->id]['floor_no']=$value->floor_no;
            $floor_arr[$value->id]['floor_name']=$value->floor_name;
        }
        

        $unit_arr=array();
        foreach ($unit_sql as $key => $value) {

            $unit_arr[$value->id]['property_name']    =$value->property_name;
            $unit_arr[$value->id]['system_no']        =$value->system_no;
            $unit_arr[$value->id]['unit_no']          =$value->unit_no;
            $unit_arr[$value->id]['unit_size_qty']  =$value->total_unit_size;
            $unit_arr[$value->id]['unit_uom']         =$value->unit_uom;
            $unit_arr[$value->id]['unit_floor_id']    =$value->floor_no;
            $unit_arr[$value->id]['unit_floor_name']  =$floor_arr[$value->floor_no]['floor_name'];
            $unit_arr[$value->id]['unit_floor_no']    =$floor_arr[$value->floor_no]['floor_no'];
            
        }

        $data['unit_arr']        =$unit_arr;
        return $data; 
    }
    public function loadCustomerByCompany($company_id)
    {
        $user=\Auth::user();
        
        $project_id                 = $user->project_id;
        if($company_id>0)
        {
            $customer_list          =Customer::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_id',$company_id)
                                    ->where('customer_type',1)
                                    ->get();
        }
        else{

            $customer_list          =Customer::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->whereNull('company_id')
                                    ->where('customer_type',1)
                                    ->get();
        }
        
        $customer_arr=array();
        foreach ($customer_list as $key => $value) {
            $customer_arr[$value->id]=$value->legal_name;
        }

        $data['customer_arr']        =$customer_arr;

        if($company_id>0)
        {

            $building_list      =BuildingInfo::where('status_active',1)
                                ->where('project_id',$project_id)
                                ->where('company_name',$company_id)
                                ->whereNull('customer_name')
                                ->get();
            
            
        }
        else{

            $building_list      =BuildingInfo::where('status_active',1)
                                ->where('project_id',$project_id)
                                ->whereNull('company_name')
                                ->whereNull('customer_name')
                                ->get();
            
        }
        
       

        $data['building_arr']        =$building_list;

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
            'building_id' => 'required',
            //'suite_id'      => 'required',
        ]);

        if(!$request->input('unit_id'))
        {
            request()->validate([
                'suite_id' => 'required',
            ]);
        }

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        $max_system_data = PropertyAttribution::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from property_attributions 
            where building_id=".$request->input('building_id')."  and project_id=".$project_id." ) 
            and building_id=".$request->input('building_id')."  and project_id=".$project_id)->get(['system_prefix']);
               // ->toSql(); and floor_no=".$request->input('floor_no')."

               
       // dd($max_system_data);die;
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="MP-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $property_info= PropertyAttribution::create($request->all());
        $data_property_details=array();
        foreach($request->service_room_arr as $key=>$details)
        {
            if($details['allocated']!="")
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                $data_property_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'property_type'             =>$details['item_type'],
                    'property_id'               =>$details['id'],
                    'allocated_size'            =>$details['allocated_size'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );

                $subroomData=SupportingRoomDetails::where('id',"=",$details['id'])->update([
                                                                'allocated_size'=>$details['previous_allocated'],
                                                                'updated_by'=>$user_id,
                                                                'updated_at'=>$insert_date,
                                                                ]);
                if( !$subroomData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
        } 


        foreach($request->parking_stall_arr as $key=>$details)
        {
            if($details['allocated'] && !$details['previous_allocated'])
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                
                $data_property_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'property_type'             =>3,
                    'property_id'               =>$details['id'],
                    'allocated_size'            =>$details['item_size'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );

                $ParkingStall=ParkingStall::where('id',"=",$details['id'])->update([
                                                                'allocated'=>1,
                                                                'updated_by'=>$user_id,
                                                                'updated_at'=>$insert_date,
                                                                ]);
                if( !$ParkingStall)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
        }

        foreach($request->bike_stall_arr as $key=>$details)
        {
            if($details['allocated'] && !$details['previous_allocated'])
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                
                $data_property_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'property_type'             =>4,
                    'property_id'               =>$details['id'],
                    'allocated_size'            =>$details['item_size'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );

                $BikeStall=BikeStall::where('id',"=",$details['id'])->update([
                                                                'allocated'=>1,
                                                                'updated_by'=>$user_id,
                                                                'updated_at'=>$insert_date,
                                                                ]);
                if( !$BikeStall)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
        } 

        foreach($request->storage_locker_arr as $key=>$details)
        {
            if($details['allocated'] && !$details['previous_allocated'])
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                
                $data_property_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'property_type'             =>5,
                    'property_id'               =>$details['id'],
                    'allocated_size'            =>$details['item_size'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );

                $BikeStall=StorageLocker::where('id',"=",$details['id'])->update([
                                                                'allocated'=>1,
                                                                'updated_by'=>$user_id,
                                                                'updated_at'=>$insert_date,
                                                                ]);
                if( !$BikeStall)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
        }

        foreach($request->mail_box_arr as $key=>$details)
        {
            if($details['allocated'] && !$details['previous_allocated'])
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                
                $data_property_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'property_type'             =>6,
                    'property_id'               =>$details['id'],
                    'allocated_size'            =>$details['item_size'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );

                $BikeStall=MailBox::where('id',"=",$details['id'])->update([
                                                                'allocated'=>1,
                                                                'updated_by'=>$user_id,
                                                                'updated_at'=>$insert_date,
                                                                ]);
                if( !$BikeStall)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
        }

        foreach($request->common_area_arr as $key=>$details)
        {
            if($details['allocated']!="")
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                
                $data_property_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'property_type'             =>11,
                    'property_id'               =>$details['id'],
                    'allocated_size'            =>$details['allocated_size'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );

                $CommonAreaDetails=CommonAreaDetails::where('id',"=",$details['id'])->update([
                                                                'allocated_size'=>$details['previous_allocated'],
                                                                'updated_by'=>$user_id,
                                                                'updated_at'=>$insert_date,
                                                                ]);
                if( !$CommonAreaDetails)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
        } 
        $RId1=true;
        if(!empty($data_property_details))
        {
            $RId1=PropertyAttributionDetails::insert($data_property_details);
        }

        if($property_info && $RId1)
        {
           DB::commit();
           return "1**$property_info->id**$system_no";
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
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $stall_type_arr             =$ArrayFunction->stall_type_arr;
        $storage_type_arr           =$ArrayFunction->storage_type_arr;

        $master_property_sql        =PropertyAttribution::where('project_id', '=', $project_id)
                                        ->where('id', '=', $id)
                                        ->where('status_active', '=', 1)
                                        ->first();

        $building_id=$master_property_sql->building_id;
        $company_id=$master_property_sql->company_name;
        $customer_id=$master_property_sql->customer_name;
        $suite_id=$master_property_sql->suite_id;
        $unit_id=$master_property_sql->unit_id;
        $data['master_property_arr']=$master_property_sql;


        //===================Company==========================================
        $main_company_list          =AccountCompany::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get();
        $main_company_arr=array();
        foreach ($main_company_list as $key => $value) {
            $main_company_arr[$value->id]   =$value->legal_name;
            $data['main_company_id']        =$value->id;

        }
        $data['main_company_arr']        =$main_company_arr;

        //===================Company==========================================
        $company_list               =Company::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get();
        $company_arr=array();
        foreach ($company_list as $key => $value) {
            $company_arr[$value->id]=$value->legal_name;
        }
        $data['company_arr']        =$company_arr;


        //===================Customer==========================================
        $customer_list_query        =Customer::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('customer_type',1);

        if($company_id)
        {
            $customer_list_query->where('company_id',$company_id);
        }
        else{

            $customer_list_query ->whereNull('company_id');
        }

        $customer_list=$customer_list_query->get();
        $customer_arr=array();
        foreach ($customer_list as $key => $value) {
            $customer_arr[$value->id]=$value->legal_name;
        }

        $data['customer_arr']        =$customer_arr;

        $uom_setting              =UomSetting::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->first();

        $data['uom_setting']    =$uom_setting->uom;

        $building_details           =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$building_id)
                                    ->first();
        $data['building_details']   =$building_details;
        //===================Building==========================================
        $building_type=0;
        if($building_details->residential==1) $building_type=1;
        else if($building_details->commercial==1) $building_type=2;
        else if($building_details->residential_commercial==1) $building_type=3;
        $data['building_type']      =$building_type;

        $building_sql               =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id);

        if($company_id>0)           $building_sql->where('company_name',$company);
        else                        $building_sql->whereNull('company_name');

        if($customer_id>0)          $building_sql->where('customer_name',$customer);
        else                        $building_sql->whereNull('customer_name');

        if($building_type==1)       $building_sql->where('residential',1);
        else  if($building_type==2) $building_sql->where('commercial',1);
        else  if($building_type==3) $building_sql->where('residential_commercial',1);
        
        $building_list              =$building_sql->get();

       // dd($building_list);
        $building_arr=array();
        foreach ($building_list as $key => $value) {
           
            
            $building_arr[$value->id]['building_no']=$value->building_no;
            $building_arr[$value->id]['building_name']=$value->building_name;
            $building_arr[$value->id]['building_uom']=$value->building_uom;
            $building_arr[$value->id]['total_building_size']=$value->total_building_size;
            $building_arr[$value->id]['number_of_floor']=$value->number_of_floor;
            
        }

        $data['building_arr']      =$building_arr;


        $suite_arr=array();
        if($suite_id>0)
        {
            $suite_sql              =ResidentialSuite::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('building_name',$building_id)
                                    ->where('id',$suite_id)
                                    ->first();
            $data['suite_type']=$suite_sql->suite_type;


            $suite_sql              =ResidentialSuite::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('building_name',$building_id)
                                    ->where('suite_type',$suite_sql->suite_type)
                                    ->get();

            
            $floor_list                 =DB::table('floors as mst')
                                            ->join('building_property_details as dtls','mst.floor_no','=','dtls.id')
                                            ->where('mst.project_id', '=', $project_id)
                                            ->where('dtls.project_id', '=', $project_id)
                                            ->where('mst.building_name', '=', $building_id)
                                            ->where('dtls.master_id', '=', $building_id)
                                            ->where('dtls.total_suite', '>', 0)
                                            ->get(['dtls.floor_no','dtls.floor_type','dtls.total_suite','mst.id','mst.floor_name']);
            $floor_arr=array();
            foreach ($floor_list as $key => $value) {
                $floor_arr[$value->id]=$value->floor_no;
            }
            

           
            foreach ($suite_sql as $key => $value) {

                $suite_arr[$value->id]['property_name']     =$value->property_name;
                $suite_arr[$value->id]['system_no']         =$value->system_no;
                $suite_arr[$value->id]['suite_no']          =$value->suite_no;
                $suite_arr[$value->id]['total_suite_size']  =$value->total_suite_size;
                $suite_arr[$value->id]['suite_uom']         =$value->suite_uom;
                $suite_arr[$value->id]['suite_floor_id']    =$value->floor_no;
                $suite_arr[$value->id]['suite_floor_name']  =$value->floor->floor_name;
                $suite_arr[$value->id]['suite_floor_no']    =$floor_arr[$value->floor_no];
                
            }

        }

        $unit_arr=array();
        $unit_details_arr=array();
        if($unit_id>0)
        {


            $unit_sql               =CommercialUnit::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('building_name',$building_id)
                                    ->where('id',$unit_id)
                                    ->first();
            $data['unit_type']=$unit_sql->unit_type;

            $unit_sql               =CommercialUnit::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('building_name',$building_id)
                                    ->where('unit_type',$unit_sql->unit_type)
                                    ->get();

             
            $floor_list                 =DB::table('floors as mst')
                                            ->join('building_property_details as dtls','mst.floor_no','=','dtls.id')
                                            ->where('mst.project_id', '=', $project_id)
                                            ->where('dtls.project_id', '=', $project_id)
                                            ->where('mst.building_name', '=', $building_id)
                                            ->where('dtls.master_id', '=', $building_id)
                                            ->where('dtls.total_unit', '>', 0)
                                            ->get(['dtls.floor_no','dtls.floor_type','dtls.total_unit','mst.id','mst.floor_name']);
            $floor_arr=array();
            foreach ($floor_list as $key => $value) {
                $floor_arr[$value->id]['floor_no']=$value->floor_no;
                $floor_arr[$value->id]['floor_name']=$value->floor_name;
            }
            

            
            foreach ($unit_sql as $key => $value) {

                $unit_arr[$value->id]['property_name']    =$value->property_name;
                $unit_arr[$value->id]['system_no']        =$value->system_no;
                $unit_arr[$value->id]['unit_no']          =$value->unit_no;
                $unit_arr[$value->id]['unit_size_qty']  =$value->total_unit_size;
                $unit_arr[$value->id]['unit_uom']         =$value->unit_uom;
                $unit_arr[$value->id]['unit_floor_id']    =$value->floor_no;
                $unit_arr[$value->id]['unit_floor_name']  =$floor_arr[$value->floor_no]['floor_name'];
                $unit_arr[$value->id]['unit_floor_no']    =$floor_arr[$value->floor_no]['floor_no'];
                
            }

        }

        $data['suite_arr']           =$suite_arr; 
        $data['unit_arr']           =$unit_arr; 


        $floor_list                 =DB::table('floors as mst')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->get(['mst.id','mst.floor_name']);
       
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {
            $floor_arr[$value->id]               =$value->floor_name;
        }


        $details_property_sql        =PropertyAttributionDetails::where('project_id', '=', $project_id)
                                        ->where('master_id', '=', $id)
                                        ->where('status_active', '=', 1)
                                        ->get();
        $details_property_arr=array();

        foreach($details_property_sql as $value)
        {
            $details_property_arr[$value->property_type][$value->property_id]['id']=$value->id;
            $details_property_arr[$value->property_type][$value->property_id]['allocated_size']=$value->allocated_size;
           // $details_property_arr[$value->property_type][$value->property_id]['id']=$value->id;
        }


        $parking_stall_details          =DB::table('parking_lots as mst')
                                        ->join('parking_levels as dtls','mst.id','=','dtls.master_id')
                                       // ->join('parking_stalls as stall','dtls.master_id','=','stall.master_id')
                                        ->join('parking_stalls as stall', function($join)
                                         {
                                             $join->on('dtls.master_id', '=', 'stall.master_id');
                                             $join->on('dtls.details_id', '=', 'stall.details_id');
                                             
                                         })
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('stall.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.status_active', '=', 1)
                                        ->where('mst.status_active', '=', 1)
                                        ->where('stall.status_active', '=', 1)
                                        ->select(['mst.id as mst_id','mst.floor_no','mst.property_name as mst_property_name','dtls.property_name as dtls_property_name','mst.lot_uom','stall.*'])
                                        ->get();
       // echo $parking_stall_details;die;
       
        $parking_stall_arr=array();
        $parking_lot_arr=array();

        $sl=0;
        foreach ($parking_stall_details as $key => $value) {
            
            $parking_stall_arr[$sl]['mst_property_name']        =$value->mst_property_name;
            $parking_stall_arr[$sl]['parking_level']            =$value->dtls_property_name;
            $parking_stall_arr[$sl]['floor_no']                 =$floor_arr[$value->floor_no];
            
            $parking_stall_arr[$sl]['id']                   =$value->id;
            $parking_stall_arr[$sl]['mst_id']               =$value->mst_id;
            $parking_stall_arr[$sl]['level_no']             =$value->details_id;
            $parking_stall_arr[$sl]['item_name']            =$value->item_name;
            $parking_stall_arr[$sl]['system_no']            =$value->system_no;
            $parking_stall_arr[$sl]['lot_uom']              =$value->lot_uom;
            $parking_stall_arr[$sl]['item_size']            =$value->item_size;
            $parking_stall_arr[$sl]['property_name']        =$value->property_name;
            $parking_stall_arr[$sl]['allocated']            =$value->allocated;
            $parking_stall_arr[$sl]['previous_allocated']   =$value->allocated;
            //dd($details_property_arr[3]);die;
            if(!empty($details_property_arr[3][$value->id]))
            {
                $parking_stall_arr[$sl]['current_allocated']=1;
                $parking_stall_arr[$sl]['update_id']        =$details_property_arr[3][$value->id]['id'];
            }
            else
            {
                $parking_stall_arr[$sl]['update_id']        ="";
                $parking_stall_arr[$sl]['current_allocated']=0;
            } 

            $parking_lot_arr[$value->mst_id]['property_name']=$value->mst_property_name;
            if($value->allocated)
            {
                $parking_stall_arr[$sl]['allocated_string']="Allocated";
                if(empty($parking_lot_arr[$value->mst_id]['allocated']))
                    $parking_lot_arr[$value->mst_id]['allocated']=$value->item_size*1;
                else
                   $parking_lot_arr[$value->mst_id]['allocated']+=$value->item_size*1; 
            }
            else
            {
                $parking_stall_arr[$sl]['allocated_string']="Un Allocated"; 
                if(empty($parking_lot_arr[$value->mst_id]['unallocated']))
                    $parking_lot_arr[$value->mst_id]['unallocated']=$value->item_size*1;
                else
                    $parking_lot_arr[$value->mst_id]['unallocated']+=$value->item_size*1;
            }

            $stall_type="";


            if($value->stall_type_1==true) $stall_type=$stall_type_arr[1];
            else if($value->stall_type_2==true) $stall_type=$stall_type_arr[2];
            else if($value->stall_type_3==true) $stall_type=$stall_type_arr[3];
            else if($value->stall_type_4==true) $stall_type=$stall_type_arr[4];
            else if($value->stall_type_5==true) $stall_type=$stall_type_arr[5];
            else if($value->stall_type_6==true) $stall_type=$stall_type_arr[6];
            else if($value->stall_type_7==true) $stall_type=$stall_type_arr[7];
            else if($value->stall_type_8==true) $stall_type=$stall_type_arr[8];
            else if($value->stall_type_9==true) $stall_type=$stall_type_arr[9];
            else if($value->stall_type_10==true) $stall_type=$stall_type_arr[10];
            else if($value->stall_type_11==true) $stall_type=$stall_type_arr[11];
            $parking_stall_arr[$sl]['stall_type']  =$stall_type;

            $sl++;
        }


        $bike_stall_details         =DB::table('bike_lots as mst')
                                        ->join('bike_levels as dtls','mst.id','=','dtls.master_id')
                                        ->join('bike_stalls as stall', function($join)
                                         {
                                             $join->on('dtls.master_id', '=', 'stall.master_id');
                                             $join->on('dtls.details_id', '=', 'stall.details_id');
                                             
                                         })
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('stall.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.status_active', '=', 1)
                                        ->where('mst.status_active', '=', 1)
                                        ->where('stall.status_active', '=', 1)
                                        ->select(['mst.id as mst_id','mst.floor_no','mst.property_name as mst_property_name','dtls.property_name as dtls_property_name','mst.lot_uom','stall.*'])
                                        ->get();
       
        $bike_stall_arr=array();
        $bike_lot_arr=array();
        $sl=0;
        foreach ($bike_stall_details as $key => $value) {
            
            $bike_stall_arr[$sl]['mst_property_name']    =$value->mst_property_name;
            $bike_stall_arr[$sl]['bike_level']           =$value->dtls_property_name;
            $bike_stall_arr[$sl]['floor_no']             =$floor_arr[$value->floor_no];
            
            $bike_stall_arr[$sl]['id']                   =$value->id;
            $bike_stall_arr[$sl]['mst_id']               =$value->mst_id;
            $bike_stall_arr[$sl]['level_no']             =$value->details_id;
            $bike_stall_arr[$sl]['item_name']            =$value->item_name;
            $bike_stall_arr[$sl]['system_no']            =$value->system_no;
            $bike_stall_arr[$sl]['lot_uom']              =$value->lot_uom;
            $bike_stall_arr[$sl]['item_size']            =$value->item_size;
            $bike_stall_arr[$sl]['property_name']        =$value->property_name;
            $bike_stall_arr[$sl]['allocated']            =$value->allocated;
            $bike_stall_arr[$sl]['previous_allocated']   =$value->allocated;

            if(!empty($details_property_arr[4][$value->id]))
            {
                $bike_stall_arr[$sl]['current_allocated']   =1;
                $bike_stall_arr[$sl]['update_id']           =$details_property_arr[4][$value->id]['id'];
            }
            else
            {
                $bike_stall_arr[$sl]['update_id']           ="";
                $bike_stall_arr[$sl]['current_allocated']   =0;
            } 

            $bike_lot_arr[$value->mst_id]['property_name']=$value->mst_property_name;
            if($value->allocated)
            {
                $bike_stall_arr[$sl]['allocated_string']="Allocated";
                if(empty($bike_lot_arr[$value->mst_id]['allocated']))
                    $bike_lot_arr[$value->mst_id]['allocated']=$value->item_size*1;
                else
                   $bike_lot_arr[$value->mst_id]['allocated']+=$value->item_size*1; 
            }
            else
            {
                $bike_stall_arr[$sl]['allocated_string']="Un Allocated"; 
                if(empty($bike_lot_arr[$value->mst_id]['unallocated']))
                    $bike_lot_arr[$value->mst_id]['unallocated']=$value->item_size*1;
                else
                    $bike_lot_arr[$value->mst_id]['unallocated']+=$value->item_size*1;
            }

            
            if(empty($bike_lot_arr[$value->mst_id]['unallocated']))
                $bike_lot_arr[$value->mst_id]['unallocated']=0;

            if(empty($bike_lot_arr[$value->mst_id]['allocated']))
                $bike_lot_arr[$value->mst_id]['allocated']=0;

            $stall_type="";
            if($value->stall_type_1==true) $stall_type=$stall_type_arr[1];
            else if($value->stall_type_2==true) $stall_type=$stall_type_arr[2];
            else if($value->stall_type_3==true) $stall_type=$stall_type_arr[3];
            else if($value->stall_type_4==true) $stall_type=$stall_type_arr[4];
            else if($value->stall_type_5==true) $stall_type=$stall_type_arr[5];
            else if($value->stall_type_6==true) $stall_type=$stall_type_arr[6];
            else if($value->stall_type_7==true) $stall_type=$stall_type_arr[7];
            else if($value->stall_type_8==true) $stall_type=$stall_type_arr[8];
            else if($value->stall_type_9==true) $stall_type=$stall_type_arr[9];
            else if($value->stall_type_10==true) $stall_type=$stall_type_arr[10];
            else if($value->stall_type_11==true) $stall_type=$stall_type_arr[11];
            $bike_stall_arr[$sl]['stall_type']  =$stall_type;

            $sl++;
            
        }


        $storage_locker_details         =DB::table('storage_lots as mst')
                                        ->join('storage_levels as dtls','mst.id','=','dtls.master_id')
                                        //->join('storage_lockers as locker','dtls.master_id','=','locker.master_id')
                                        ->join('storage_lockers as locker', function($join)
                                         {
                                             $join->on('dtls.master_id', '=', 'locker.master_id');
                                             $join->on('dtls.details_id', '=', 'locker.details_id');
                                             
                                         })
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.status_active', '=', 1)
                                        ->where('mst.status_active', '=', 1)
                                        ->where('locker.status_active', '=', 1)
                                        ->select(['mst.id as mst_id','mst.floor_no','mst.property_name as mst_property_name','dtls.property_name as dtls_property_name','mst.lot_uom','locker.*'])
                                        ->get();
       
        $storage_locker_arr=array();
        $storage_lot_arr=array();
        $sl=0;
        foreach ($storage_locker_details as $key => $value) {
            
            $storage_locker_arr[$sl]['mst_property_name']        =$value->mst_property_name;
            $storage_locker_arr[$sl]['storage_level']            =$value->dtls_property_name;
            $storage_locker_arr[$sl]['floor_no']                 =$floor_arr[$value->floor_no];
            
            $storage_locker_arr[$sl]['id']             =$value->id;
            $storage_locker_arr[$sl]['mst_id']         =$value->mst_id;
            $storage_locker_arr[$sl]['level_no']       =$value->details_id;
            $storage_locker_arr[$sl]['item_name']      =$value->item_name;
            $storage_locker_arr[$sl]['system_no']      =$value->system_no;
            $storage_locker_arr[$sl]['lot_uom']        =$value->lot_uom;
            $storage_locker_arr[$sl]['item_size']      =$value->item_size;
            $storage_locker_arr[$sl]['property_name']  =$value->property_name;
            //$storage_locker_arr[$sl]['allocated']       =false;

            $storage_locker_arr[$sl]['allocated']            =$value->allocated;
            $storage_locker_arr[$sl]['previous_allocated']   =$value->allocated;

            if(!empty($details_property_arr[5][$value->id]))
            {
                $storage_locker_arr[$sl]['current_allocated']   =1;
                $storage_locker_arr[$sl]['update_id']           =$details_property_arr[5][$value->id]['id'];
            }
            else 
            {
                $storage_locker_arr[$sl]['update_id']           ="";
                $storage_locker_arr[$sl]['current_allocated']   =0;
            }

            $storage_lot_arr[$value->mst_id]['property_name']=$value->mst_property_name;
            if($value->allocated)
            {
                $storage_locker_arr[$sl]['allocated_string']="Allocated";
                if(empty($storage_lot_arr[$value->mst_id]['allocated']))
                    $storage_lot_arr[$value->mst_id]['allocated']=$value->item_size*1;
                else
                   $storage_lot_arr[$value->mst_id]['allocated']+=$value->item_size*1; 
            }
            else
            {
                $storage_locker_arr[$sl]['allocated_string']="Un Allocated"; 
                if(empty($storage_lot_arr[$value->mst_id]['unallocated']))
                    $storage_lot_arr[$value->mst_id]['unallocated']=$value->item_size*1;
                else
                    $storage_lot_arr[$value->mst_id]['unallocated']+=$value->item_size*1;
            }

            
            if(empty($storage_lot_arr[$value->mst_id]['unallocated']))
                $storage_lot_arr[$value->mst_id]['unallocated']=0;

            if(empty($storage_lot_arr[$value->mst_id]['allocated']))
                $storage_lot_arr[$value->mst_id]['allocated']=0;

            $stall_type="";


            if($value->storage_type_1==true) $stall_type=$storage_type_arr[1];
            else if($value->storage_type_2==true) $stall_type=$storage_type_arr[2];
            else if($value->storage_type_3==true) $stall_type=$storage_type_arr[3];
            else if($value->storage_type_4==true) $stall_type=$storage_type_arr[4];
            else if($value->storage_type_5==true) $stall_type=$storage_type_arr[5];
            else if($value->storage_type_6==true) $stall_type=$storage_type_arr[6];
            else if($value->storage_type_7==true) $stall_type=$storage_type_arr[7];
            else if($value->storage_type_8==true) $stall_type=$storage_type_arr[8];

            $storage_locker_arr[$sl]['stall_type']  =$stall_type;

            $sl++;
            
        }


        $mail_box_details         =DB::table('mail_rooms as mst')
                                        ->join('mail_boxes as box','mst.id','=','box.master_id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('box.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('mst.status_active', '=', 1)
                                        ->where('box.status_active', '=', 1)
                                        ->select(['mst.id as mst_id','mst.floor_no','mst.property_name as mst_property_name','mst.room_uom','box.*'])
                                        ->get();
       
        $mail_box_arr=array();
        $mail_room_arr=array();
        $sl=0;
       // dd($details_property_arr[6][3]);
        foreach ($mail_box_details as $key => $value) {
            
            $mail_box_arr[$sl]['mst_property_name']         =$value->mst_property_name;
            $mail_box_arr[$sl]['floor_no']                  =$floor_arr[$value->floor_no];
            
            $mail_box_arr[$sl]['id']                        =$value->id;
            $mail_box_arr[$sl]['mst_id']                    =$value->mst_id;
            $mail_box_arr[$sl]['item_name']                 =$value->item_name;
            $mail_box_arr[$sl]['system_no']                 =$value->system_no;
            $mail_box_arr[$sl]['room_uom']                  =$value->room_uom;
            $mail_box_arr[$sl]['item_size']                 =$value->item_size;
            $mail_box_arr[$sl]['property_name']             =$value->property_name;
            $mail_box_arr[$sl]['allocated']                 =$value->allocated;
            $mail_box_arr[$sl]['previous_allocated']        =$value->allocated;
            $mail_room_arr[$value->mst_id]['property_name'] =$value->mst_property_name;
            $mail_box_arr[$sl]['current_allocated']         =0;
            $mail_box_arr[$sl]['update_id']                 ="";
            $mail_box_arr[$sl]['update_id']           ="";
            $mail_box_arr[$sl]['current_allocated']   =0;
            if(!empty($details_property_arr[6][$value->id]))
            {
                $mail_box_arr[$sl]['update_id']             =$details_property_arr[6][$value->id]['id'];
                $mail_box_arr[$sl]['current_allocated']     =1;

            }
            
            if($value->allocated)
            {
                $mail_box_arr[$sl]['allocated_string']="Allocated";
                if(empty($mail_room_arr[$value->mst_id]['allocated']))
                    $mail_room_arr[$value->mst_id]['allocated']=$value->item_size*1;
                else
                   $mail_room_arr[$value->mst_id]['allocated']+=$value->item_size*1; 
            }
            else
            {
                $mail_box_arr[$sl]['allocated_string']="Un Allocated"; 
                if(empty($mail_room_arr[$value->mst_id]['unallocated']))
                    $mail_room_arr[$value->mst_id]['unallocated']=$value->item_size*1;
                else
                    $mail_room_arr[$value->mst_id]['unallocated']+=$value->item_size*1;
            }

            
            if(empty($mail_room_arr[$value->mst_id]['unallocated']))
                $mail_room_arr[$value->mst_id]['unallocated']=0;

            if(empty($mail_room_arr[$value->mst_id]['allocated']))
                $mail_room_arr[$value->mst_id]['allocated']=0;
            $sl++;
            
        }

       // dd($mail_box_arr);
        $common_area_details         =DB::table('common_areas as mst')
                                        ->join('common_area_details as dtls','mst.id','=','dtls.master_id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('mst.status_active', '=', 1)
                                        ->where('dtls.status_active', '=', 1)
                                        ->select(['mst.id as mst_id','mst.floor_no','mst.property_name as mst_property_name','mst.single_subroom_uom','dtls.*'])
                                        ->get();
       
        $common_area_arr=array();
        $sl=0;
        foreach ($common_area_details as $key => $value) {
            
            $common_area_arr[$sl]['mst_property_name']        =$value->mst_property_name;
            $common_area_arr[$sl]['floor_no']                 =$floor_arr[$value->floor_no];
            
            $common_area_arr[$sl]['id']                 =$value->id;
            $common_area_arr[$sl]['mst_id']             =$value->mst_id;
            $common_area_arr[$sl]['item_name']          =$value->item_name;
            $common_area_arr[$sl]['system_no']          =$value->system_no;
            $common_area_arr[$sl]['uom']                =$value->uom;
            $common_area_arr[$sl]['item_size']          =$value->item_size;

            $common_area_arr[$sl]['allocated_size']     ='';
            $common_area_arr[$sl]['property_name']      =$value->property_name;
            $common_area_arr[$sl]['allocated']          =false;

            if(!empty($details_property_arr[11][$value->id]))
            {
                $common_area_arr[$sl]['update_id']          =$details_property_arr[11][$value->id]['id'];
                $common_area_arr[$sl]['allocated']          =true;
                $common_area_arr[$sl]['allocated_size']     =$details_property_arr[11][$value->id]['allocated_size'];
                $common_area_arr[$sl]['available_actual']   =$value->item_size-$value->allocated_size+$common_area_arr[$sl]['allocated_size'];
                $common_area_arr[$sl]['actual_allocated']   =$value->allocated_size-$common_area_arr[$sl]['allocated_size'];
            }
            else{
                $common_area_arr[$sl]['update_id']          ="";
                $common_area_arr[$sl]['available_actual']   =$value->item_size-$value->allocated_size;
                $common_area_arr[$sl]['actual_allocated']   =$value->allocated_size; 
            }
            
            $common_area_arr[$sl]['previous_allocated'] =$value->allocated_size;
            
            $common_area_arr[$sl]['available']          =$value->item_size-$value->allocated_size;
           
            $sl++;
        }


        $service_room_details         =DB::table('supporting_rooms as mst')
                                        ->join('supporting_room_details as dtls','mst.id','=','dtls.master_id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('mst.status_active', '=', 1)
                                        ->where('dtls.status_active', '=', 1)
                                        ->select(['mst.id as mst_id','mst.floor_no','mst.system_no as mst_property_name','dtls.*'])
                                        ->get();
       
        $service_room_arr=array();
        $sl=0;
        $total_service_room=0;
        $total_aminity_room=0;
        $total_administrition_room=0;
        $total_machanical_room=0;

        foreach ($service_room_details as $key => $value) {
            
            $service_room_arr[$sl]['mst_property_name']         =$value->mst_property_name;
            $service_room_arr[$sl]['floor_no']                  =$floor_arr[$value->floor_no];
            
            $service_room_arr[$sl]['id']                        =$value->id;
            $service_room_arr[$sl]['mst_id']                    =$value->mst_id;
            $service_room_arr[$sl]['item_name']                 =$value->item_name;
            $service_room_arr[$sl]['item_type']                 =$value->item_type;
            $service_room_arr[$sl]['system_no']                 =$value->system_no;
            $service_room_arr[$sl]['uom']                       =$value->uom;
            $service_room_arr[$sl]['item_size']                 =$value->item_size;
            $service_room_arr[$sl]['property_name']             =$value->property_name;


            if(!empty($details_property_arr[$value->item_type][$value->id]))
            {
                $service_room_arr[$sl]['update_id']                 =$details_property_arr[$value->item_type][$value->id]['id'];
                $service_room_arr[$sl]['allocated']                 =true;
                $service_room_arr[$sl]['allocated_size']            =$details_property_arr[$value->item_type][$value->id]['allocated_size'];
                $service_room_arr[$sl]['actual_allocated']          =$value->allocated_size-$service_room_arr[$sl]['allocated_size'];
                $service_room_arr[$sl]['available_actual']          =$value->item_size-$value->allocated_size+$service_room_arr[$sl]['allocated_size'];

            }
            else
            {
                $service_room_arr[$sl]['update_id']                 ="";
                $service_room_arr[$sl]['allocated']                 =false;
                $service_room_arr[$sl]['allocated_size']            ="";
                $service_room_arr[$sl]['actual_allocated']          =$value->allocated_size;
                $service_room_arr[$sl]['available_actual']          =$value->item_size-$value->allocated_size;
            }

            
            $service_room_arr[$sl]['previous_allocated']        =$value->allocated_size;
            
            $service_room_arr[$sl]['available']                 =$value->item_size-$value->allocated_size;
            


            if($value->item_type==7) $total_machanical_room++;
            if($value->item_type==8) $total_administrition_room++;
            if($value->item_type==9) $total_aminity_room++;
            if($value->item_type==10) $total_service_room++;
            $sl++;
            
        }


        $data['parking_stall_arr']          =$parking_stall_arr;
        $data['bike_stall_arr']             =$bike_stall_arr;
        $data['storage_locker_arr']         =$storage_locker_arr;
        $data['mail_box_arr']               =$mail_box_arr;
        $data['common_area_arr']            =$common_area_arr;
        $data['service_room_arr']           =$service_room_arr;
        $data['total_machanical_room']      =$total_machanical_room;
        $data['total_administrition_room']  =$total_administrition_room;
        $data['total_aminity_room']         =$total_aminity_room;
        $data['total_service_room']         =$total_service_room;
        $data['parking_lot_arr']            =$parking_lot_arr;
        $data['bike_lot_arr']               =$bike_lot_arr;
        $data['storage_lot_arr']            =$storage_lot_arr;
        $data['mail_room_arr']              =$mail_room_arr;

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
            'building_id' => 'required',
            //'suite_id'      => 'required',
        ]);

        if(!$request->input('unit_id'))
        {
            request()->validate([
                'suite_id' => 'required',
            ]);
        }

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        

       

        DB::beginTransaction();
        $property_info= PropertyAttribution::find($id)->update($request->all());
        $data_property_details=array();
        foreach($request->service_room_arr as $key=>$details)
        {
            $insert_date                    =date("Y-m-d h:i:s");
            if($details['update_id']!="")
            {
                if($details['allocated']!="")
                {
                    $property_details_data= array(
                        
                        'allocated_size'            =>$details['allocated_size'],
                        'updated_by'                =>$user_id,
                        'updated_at'                =>$insert_date,
                    );
                }
                else
                {
                    $property_details_data= array(
                        'status_active'             =>0,
                        'is_deleted'                =>1,
                        'updated_by'                =>$user_id,
                        'updated_at'                =>$insert_date,
                    );
                }

                $attributeData=PropertyAttributionDetails::where('id',"=",$details['update_id'])->update($property_details_data);

                $subroomData=SupportingRoomDetails::where('id',"=",$details['id'])->update([
                                                                'allocated_size'=>$details['previous_allocated'],
                                                                'updated_by'=>$user_id,
                                                                'updated_at'=>$insert_date,
                                                                ]);
               // echo "$subroomData && $attributeData";die;
                if( !$subroomData || !$attributeData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else
            {
                if($details['allocated']!="")
                {
                    
                    $data_property_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'property_type'             =>$details['item_type'],
                        'property_id'               =>$details['id'],
                        'allocated_size'            =>$details['allocated_size'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );

                    $subroomData=SupportingRoomDetails::where('id',"=",$details['id'])->update([
                                                                    'allocated_size'=>$details['previous_allocated'],
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);
                    if( !$subroomData)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
            }
            
        }

        foreach($request->parking_stall_arr as $key=>$details)
        {
            $insert_date                    =date("Y-m-d h:i:s");
            if($details['update_id'])
            {
                if($details['allocated'])
                {
                    $property_details_data= array(
                        
                        'allocated_size'            =>$details['item_size'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );

                    $ParkingStall=ParkingStall::where('id',"=",$details['id'])->update([
                                                                    'allocated'=>1,
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);
                }
                else
                {
                    $property_details_data= array(
                        'status_active'             =>0,
                        'is_deleted'                =>1,
                        'updated_by'                =>$user_id,
                        'updated_at'                =>$insert_date,
                    );

                    $ParkingStall=ParkingStall::where('id',"=",$details['id'])->update([
                                                                    'allocated'=>0,
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);
                }


                $attributeData=PropertyAttributionDetails::where('id',"=",$details['update_id'])->update($property_details_data);

               
                if( !$ParkingStall || !$attributeData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else
            {
                if($details['allocated'] && !$details['previous_allocated'])
                {
                                        
                    $data_property_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'property_type'             =>3,
                        'property_id'               =>$details['id'],
                        'allocated_size'            =>$details['item_size'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );

                    $ParkingStall=ParkingStall::where('id',"=",$details['id'])->update([
                                                                    'allocated'=>1,
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);
                    if( !$ParkingStall)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
            }
            
        } 

        foreach($request->bike_stall_arr as $key=>$details)
        {
            if($details['update_id'])
            {
                if($details['allocated'])
                {
                    $property_details_data= array(
                        
                        'allocated_size'            =>$details['item_size'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );

                    $BikeStall=BikeStall::where('id',"=",$details['id'])->update([
                                                                    'allocated'=>1,
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);

                }
                else
                {
                    $property_details_data= array(
                        'status_active'             =>0,
                        'is_deleted'                =>1,
                        'updated_by'                =>$user_id,
                        'updated_at'                =>$insert_date,
                    );

                    $BikeStall=BikeStall::where('id',"=",$details['id'])->update([
                                                                    'allocated'=>0,
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);
                }


                $attributeData=PropertyAttributionDetails::where('id',"=",$details['update_id'])->update($property_details_data);

               
                if( !$BikeStall || !$attributeData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else
            {
                if($details['allocated'] && !$details['previous_allocated'])
                {
                    
                    $insert_date                    =date("Y-m-d h:i:s");
                    
                    $data_property_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'property_type'             =>4,
                        'property_id'               =>$details['id'],
                        'allocated_size'            =>$details['item_size'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );

                    $BikeStall=BikeStall::where('id',"=",$details['id'])->update([
                                                                    'allocated'=>1,
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);
                    if( !$BikeStall)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
            }
            
        } 

        foreach($request->storage_locker_arr as $key=>$details)
        {
            if($details['update_id'])
            {
                if($details['allocated'])
                {
                    $property_details_data= array(
                        
                        'allocated_size'            =>$details['item_size'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );

                    $StorageLocker=StorageLocker::where('id',"=",$details['id'])->update([
                                                                    'allocated'=>1,
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);

                }
                else
                {
                    $property_details_data= array(
                        'status_active'             =>0,
                        'is_deleted'                =>1,
                        'updated_by'                =>$user_id,
                        'updated_at'                =>$insert_date,
                    );

                    $StorageLocker=StorageLocker::where('id',"=",$details['id'])->update([
                                                                    'allocated'=>0,
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);
                }


                $attributeData=PropertyAttributionDetails::where('id',"=",$details['update_id'])->update($property_details_data);

               
                if( !$StorageLocker || !$attributeData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else
            {
                if($details['allocated'] && !$details['previous_allocated'])
                {
                    
                    $insert_date                    =date("Y-m-d h:i:s");
                    
                    $data_property_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'property_type'             =>5,
                        'property_id'               =>$details['id'],
                        'allocated_size'            =>$details['item_size'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );

                    $BikeStall=StorageLocker::where('id',"=",$details['id'])->update([
                                                                    'allocated'=>1,
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);
                    if( !$BikeStall)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
            }
        }

        foreach($request->mail_box_arr as $key=>$details)
        {
            if($details['update_id'])
            {
                if($details['allocated'])
                {
                    $property_details_data= array(
                        
                        'allocated_size'            =>$details['item_size'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );

                    $MailBox=MailBox::where('id',"=",$details['id'])->update([
                                                                    'allocated'=>1,
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);

                }
                else
                {
                    $property_details_data= array(
                        'status_active'             =>0,
                        'is_deleted'                =>1,
                        'updated_by'                =>$user_id,
                        'updated_at'                =>$insert_date,
                    );

                    $MailBox=MailBox::where('id',"=",$details['id'])->update([
                                                                    'allocated'=>0,
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);
                }


                $attributeData=PropertyAttributionDetails::where('id',"=",$details['update_id'])->update($property_details_data);

               
                if( !$MailBox || !$attributeData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else
            {
                if($details['allocated'] && !$details['previous_allocated'])
                {
                    
                    $insert_date                    =date("Y-m-d h:i:s");
                    
                    $data_property_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'property_type'             =>6,
                        'property_id'               =>$details['id'],
                        'allocated_size'            =>$details['item_size'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );

                    $MailBox=MailBox::where('id',"=",$details['id'])->update([
                                                                    'allocated'=>1,
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);
                    if( !$MailBox)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
            }
        }


        foreach($request->common_area_arr as $key=>$details)
        {
            if($details['update_id']!="")
            {
                if($details['allocated']!="")
                {
                    $property_details_data= array(
                        
                        'allocated_size'            =>$details['allocated_size'],
                        'updated_by'                =>$user_id,
                        'updated_at'                =>$insert_date,
                    );
                }
                else
                {
                    $property_details_data= array(
                        'status_active'             =>0,
                        'is_deleted'                =>1,
                        'updated_by'                =>$user_id,
                        'updated_at'                =>$insert_date,
                    );
                }

                $attributeData=PropertyAttributionDetails::where('id',"=",$details['update_id'])->update($property_details_data);

                $common_area=CommonAreaDetails::where('id',"=",$details['id'])->update([
                                                                'allocated_size'=>$details['previous_allocated'],
                                                                'updated_by'=>$user_id,
                                                                'updated_at'=>$insert_date,
                                                                ]);
                if( !$common_area || !$attributeData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else
            {

                if($details['allocated']!="")
                {
                    
                    $insert_date                    =date("Y-m-d h:i:s");
                    
                    $data_property_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'property_type'             =>11,
                        'property_id'               =>$details['id'],
                        'allocated_size'            =>$details['allocated_size'],
                        'inserted_by'               =>$user_id,
                        'created_at'                =>$insert_date
                    );

                    $CommonAreaDetails=CommonAreaDetails::where('id',"=",$details['id'])->update([
                                                                    'allocated_size'=>$details['previous_allocated'],
                                                                    'updated_by'=>$user_id,
                                                                    'updated_at'=>$insert_date,
                                                                    ]);
                    if( !$CommonAreaDetails)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
            }
        } 


        
        $RId1=true;
        if(!empty($data_property_details))
        {
            $RId1=PropertyAttributionDetails::insert($data_property_details);
        }

        if($property_info && $RId1)
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
