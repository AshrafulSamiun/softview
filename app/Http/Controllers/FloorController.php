<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floor as Floor;
use App\Models\company;
use App\Models\customer;
use App\Models\buildingInfo as BuildingInfo;
use App\Models\BuildingPropertyDetails as BuildingPropertyDetails;
use App\Models\SubroomsList as SubroomsList;
use App\Models\SubroomsListDetails as SubroomsListDetails;
use App\Models\SafetyItemList as SafetyItemList;
use App\Models\SafetyDeviceEquipment;
use Illuminate\Support\Facades\DB;




use App\Classes\ArrayFunction as ArrayFunction;

class FloorController extends Controller
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
        $property_management_arr    =$ArrayFunction->property_management_type;

        $ksl=0;
        foreach($property_management_arr as $key=>$val)
        {
            $data['property_management_arr'][$ksl]['id']=$key;
            $data['property_management_arr'][$ksl]['val']=$val;
            $ksl++;
        }

        //===================Company==========================================
        $company_list               =company::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get();
        $company_arr=array();
        foreach ($company_list as $key => $value) {
            $company_arr[$value->id]=$value->legal_name;
        }
        $data['company_arr']        =$company_arr;


        //===================Customer==========================================
        $customer_list              =customer::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('customer_type',1)
                                    ->whereNull('company_id')
                                    ->get();
        $customer_arr=array();
        foreach ($customer_list as $key => $value) {
            $customer_arr[$value->id]=$value->legal_name;
        }

        $data['customer_arr']        =$customer_arr;


        $building_list              =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->whereNull('company_name')
                                    ->whereNull('customer_name')
                                    ->get(['id','building_no','building_name']);

        $building_arr=array();
        foreach ($building_list as $key => $value) {
            $building_arr[$value->id]=$value->building_no."-".$value->building_name;
        }

        $data['building_arr']        =$building_arr;


        $subrooms_list              =SubroomsList::where('status_active',1)
                                    ->get(['id','item_type','item_name']);

        $subrooms_list_arr=array();
        $sl=0;
        foreach ($subrooms_list as $key => $value) {
            $subrooms_list_arr[$sl]['item_name']     =$value->item_name;
            $subrooms_list_arr[$sl]['item_type']     =$value->item_type;
            $subrooms_list_arr[$sl]['id']            =$value->id;
            $sl++;
        }

        $data['subrooms_list_arr']        =$subrooms_list_arr;

        $safety_item_list=SafetyItemList::where('status_active',1)
                                    ->where('page_id',1)
                                    ->get();
        $sl=0;
        $safety_item_list_arr=array();
        foreach ($safety_item_list as $key => $value) {
            $safety_item_list_arr[$sl]['id']            =$value->id;
            $safety_item_list_arr[$sl]['refernece_id']  =$value->refernece_id;
            $safety_item_list_arr[$sl]['item_name']     =$value->item_name;
            $safety_item_list_arr[$sl]['item_qty']      ="";
            $sl++;
        }
        $data['safety_item_list_arr']        =$safety_item_list_arr;

        return $data;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function FloorLists()
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        //===================Company==========================================
        $company_list               =company::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get();
        $company_arr=array();
        foreach ($company_list as $key => $value) {
            $company_arr[$value->id]=$value->legal_name;
        }


        //===================Customer==========================================
        $customer_list              =customer::where('status_active',1)
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
            $building_arr[$value->id]=$value->building_no."-".$value->building_name;
        }

      

        //===================Building==========================================

       


        $sl=0;
        $Floor_list=Floor::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->get();
         foreach ($Floor_list as $key => $value) {

            $data['Floor_list'][$key]['sl']                  =$sl+1;
            $data['Floor_list'][$key]['id']                  =$value->id;
            $data['Floor_list'][$key]['system_no']           =$value->system_no;
            $data['Floor_list'][$key]['floor_name']           =$value->floor_name;
            $data['Floor_list'][$key]['floor_no']            =$value->floor_no;
            $data['Floor_list'][$key]['system_no']             =$value->system_no;
         
          


            if($value->company_name>0)
            {
                $data['Floor_list'][$key]['company_name']     =$company_arr[$value->company_name];

            }
            else
            {
                $data['Floor_list'][$key]['company_name']      ="";

            }

            if($value->customer_name>0)
            {
                $data['Floor_list'][$key]['customer_name']     =$customer_arr[$value->customer_name];

            }
            else
            {
                $data['Floor_list'][$key]['customer_name']      ="";

            }

            if($value->building_name>0)
            {
                $data['Floor_list'][$key]['building_name']     =$building_arr[$value->building_name];

            }
            else
            {
                $data['Floor_list'][$key]['building_name']      ="";

            }
            $sl++;

        }

       // $data['Floor_list']        =$Floor_list;
        
        return $data;

    }

    public function loadFloorByBuilding($building_id)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $floor_list                 =BuildingPropertyDetails::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('master_id',$building_id)
                                    ->get();


       
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {

            $floor_arr[$value->id]['floor_no']                  =$value->floor_no;
            $floor_arr[$value->id]['floor_type']                =$value->floor_type;
            $floor_arr[$value->id]['total_suite']               =$value->total_suite;
            $floor_arr[$value->id]['total_unit']                =$value->total_unit;
            $floor_arr[$value->id]['total_mechanical_room']     =$value->total_mechanical_room;
            $floor_arr[$value->id]['total_administrative_room'] =$value->total_administrative_room;
            $floor_arr[$value->id]['total_amenity_room']        =$value->total_amenity_room;
            $floor_arr[$value->id]['total_service_room']        =$value->total_service_room;
            $floor_arr[$value->id]['total_parking_lot']         =$value->total_parking_lot;
            $floor_arr[$value->id]['total_bike_lot']            =$value->total_bike_lot;
            $floor_arr[$value->id]['total_storage_lot']         =$value->total_storage_lot;
            $floor_arr[$value->id]['total_mailroom']            =$value->total_mailroom;
            $floor_arr[$value->id]['total_common_area']         =$value->total_common_area;

        }

        $data['floor_arr']        =$floor_arr;

        $building_info           =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$building_id)
                                    ->get(['dependent_building','independent_building','residential','commercial','residential_commercial']);

        $data['building_info']    =$building_info;

        return $data;


    }
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
            'building_name' => 'required',
            'floor_no' => 'required',
            'floor_name' => 'required',
            
        ]);

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        

        $max_system_data = Floor::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from floors 
            where building_name=".$request->input('building_name')." and project_id=".$project_id." ) and building_name=".$request->input('building_name')."
             and project_id=".$project_id)
               // ->toSql();
               ->get(['system_prefix']);
       // dd($max_system_data);die;
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="FL-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        //dd($max_system_prefix);die;
        DB::beginTransaction();
        $floor_info= Floor::create($request->all());


       // dd($request->subrooms_list_details_arr);die;

        foreach($request->subrooms_list_details_arr as $key=>$Subroom_type)
        {
            if($key>0 && $key<=6 && $Subroom_type!=null)
            {

                foreach($Subroom_type as $key1=>$subroom_qty)
                {

                    foreach($subroom_qty as $key2=>$details)
                    {

                        
                        if($details['item_qty']>0)
                        {
                            
                            $data_subrooms_list_details[]= array(
                                'project_id'                =>$project_id,
                                'master_id'                 =>$floor_info->id,
                                'item_type'                 =>$key,
                                'item_id'                   =>$details['item_id'],
                                'property_no'               =>$key1,
                                'item_name'                 =>$details['item_name'],
                                'item_qty'                  =>$details['item_qty'],
                                'inserted_by'               =>$user_id,
                            );
                        }
                    }
                }
            }
            else if($key>6 && $Subroom_type!=null)
            {

                foreach($Subroom_type as $key1=>$details)
                {
                        
                    if($details['item_qty']>0)
                    {
                        
                        $data_subrooms_list_details[]= array(
                            'project_id'                =>$project_id,
                            'master_id'                 =>$floor_info->id,
                            'item_type'                 =>$key,
                            'item_id'                   =>$details['item_id'],
                            'property_no'               =>NULL,
                            'item_name'                 =>$details['item_name'],
                            'item_qty'                  =>$details['item_qty'],
                            'inserted_by'               =>$user_id,
                        );
                    }
                    
                }
            }
        } 
       // dd($data_subrooms_list_details);

        foreach($request->fire_extinguisher_details_arr as $key=>$details)
        {
            if($details['serial_no']!="")
            {
                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";

                if($details['renew_date'])
                {
                    $renew_date                               =date("Y-m-d",strtotime($details['renew_date']));
                }
                else $renew_date="";

                if($details['due_on'])
                {
                    $due_on                               =date("Y-m-d",strtotime($details['due_on']));
                }
                else $due_on="";

                $data_safety_device_equipment[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$floor_info->id,
                    'item_id'                   =>$details['item_id'],
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>2,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'inserted_by'               =>$user_id,
                );
            }
        } 

        foreach($request->smoke_detecter_details_arr as $key=>$details)
        {
            if($details['serial_no']!="")
            {
                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";

                if($details['renew_date'])
                {
                    $renew_date                               =date("Y-m-d",strtotime($details['renew_date']));
                }
                else $renew_date="";

                if($details['due_on'])
                {
                    $due_on                               =date("Y-m-d",strtotime($details['due_on']));
                }
                else $due_on="";
                $data_safety_device_equipment[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$floor_info->id,
                    'item_id'                   =>2,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>2,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'inserted_by'               =>$user_id,
                );
            }
        }
        foreach($request->sprinkler_details_arr as $key=>$details)
        {
            if($details['serial_no']!="")
            {
                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";

                if($details['renew_date'])
                {
                    $renew_date                               =date("Y-m-d",strtotime($details['renew_date']));
                }
                else $renew_date="";

                if($details['due_on'])
                {
                    $due_on                               =date("Y-m-d",strtotime($details['due_on']));
                }
                else $due_on="";
                $data_safety_device_equipment[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$floor_info->id,
                    'item_id'                   =>3,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>2,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'inserted_by'               =>$user_id,
                );
            }
        }
        foreach($request->water_valve_details_arr as $key=>$details)
        {
            if($details['serial_no']!="")
            {
                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";

                if($details['renew_date'])
                {
                    $renew_date                               =date("Y-m-d",strtotime($details['renew_date']));
                }
                else $renew_date="";

                if($details['due_on'])
                {
                    $due_on                               =date("Y-m-d",strtotime($details['due_on']));
                }
                else $due_on="";
                $data_safety_device_equipment[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$floor_info->id,
                    'item_id'                   =>4,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>2,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

        foreach($request->gfci_breaker_details_arr as $key=>$details)
        {
            if($details['serial_no']!="")
            {
                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";

                if($details['renew_date'])
                {
                    $renew_date                               =date("Y-m-d",strtotime($details['renew_date']));
                }
                else $renew_date="";

                if($details['due_on'])
                {
                    $due_on                               =date("Y-m-d",strtotime($details['due_on']));
                }
                else $due_on="";
                $data_safety_device_equipment[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$floor_info->id,
                    'item_id'                   =>5,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>2,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

        foreach($request->sump_pump_details_arr as $key=>$details)
        {
            if($details['serial_no']!="")
            {
                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";

                if($details['renew_date'])
                {
                    $renew_date                               =date("Y-m-d",strtotime($details['renew_date']));
                }
                else $renew_date="";

                if($details['due_on'])
                {
                    $due_on                               =date("Y-m-d",strtotime($details['due_on']));
                }
                else $due_on="";
                $data_safety_device_equipment[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$floor_info->id,
                    'item_id'                   =>6,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>2,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

        foreach($request->emergency_bell_details_arr as $key=>$details)
        {
            if($details['serial_no']!="")
            {
                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";

                if($details['renew_date'])
                {
                    $renew_date                               =date("Y-m-d",strtotime($details['renew_date']));
                }
                else $renew_date="";

                if($details['due_on'])
                {
                    $due_on                               =date("Y-m-d",strtotime($details['due_on']));
                }
                else $due_on="";
                $data_safety_device_equipment[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$floor_info->id,
                    'item_id'                   =>7,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>2,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

        foreach($request->emergency_light_arr as $key=>$details)
        {
            if($details['serial_no']!="")
            {
                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";

                if($details['renew_date'])
                {
                    $renew_date                               =date("Y-m-d",strtotime($details['renew_date']));
                }
                else $renew_date="";

                if($details['due_on'])
                {
                    $due_on                               =date("Y-m-d",strtotime($details['due_on']));
                }
                else $due_on="";
                $data_safety_device_equipment[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$floor_info->id,
                    'item_id'                   =>8,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>2,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

        foreach($request->first_aid_station_arr as $key=>$details)
        {
            if($details['serial_no']!="")
            {
                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";

                if($details['renew_date'])
                {
                    $renew_date                               =date("Y-m-d",strtotime($details['renew_date']));
                }
                else $renew_date="";

                if($details['due_on'])
                {
                    $due_on                               =date("Y-m-d",strtotime($details['due_on']));
                }
                else $due_on="";
                $data_safety_device_equipment[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$floor_info->id,
                    'item_id'                   =>9,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>2,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

        foreach($request->first_aid_box_arr as $key=>$details)
        {
            if($details['serial_no']!="")
            {
                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";

                if($details['renew_date'])
                {
                    $renew_date                               =date("Y-m-d",strtotime($details['renew_date']));
                }
                else $renew_date="";

                if($details['due_on'])
                {
                    $due_on                               =date("Y-m-d",strtotime($details['due_on']));
                }
                else $due_on="";
                $data_safety_device_equipment[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$floor_info->id,
                    'item_id'                   =>10,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>2,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

        foreach($request->aed_arr as $key=>$details)
        {
            if($details['serial_no']!="")
            {
                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";

                if($details['renew_date'])
                {
                    $renew_date                               =date("Y-m-d",strtotime($details['renew_date']));
                }
                else $renew_date="";

                if($details['due_on'])
                {
                    $due_on                               =date("Y-m-d",strtotime($details['due_on']));
                }
                else $due_on="";
                $data_safety_device_equipment[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$floor_info->id,
                    'item_id'                   =>11,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>2,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'inserted_by'               =>$user_id,
                );
            }
        }




        if($data_subrooms_list_details)
        {
            $RId1=SubroomsListDetails::insert($data_subrooms_list_details);
        }
        if($data_safety_device_equipment)
        {
            $RId2=SafetyDeviceEquipment::insert($data_safety_device_equipment);
        }

        if($floor_info  && $RId1 && $RId2)
        {
           DB::commit();
           return "1**$floor_info->id**$system_no";
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
        //===================Company==========================================
        $company_list               =company::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get();
        $company_arr=array();
        foreach ($company_list as $key => $value) {
            $company_arr[$value->id]=$value->legal_name;
        }
        $data['company_arr']        =$company_arr;

        $floor_list_query=Floor::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$id)
                                    ->first();
        $data['floor_list_arr']=$floor_list_query;                            
        $company_id     =$floor_list_query->company_name;
        $customer_id    =$floor_list_query->customer_name;
        $building_id    =$floor_list_query->building_name;
        $floor_no       =$floor_list_query->floor_no;
        $floor_id       =$floor_list_query->id;
        //dd($company_id);die;

        //===================Customer==========================================
        $customer_list_query        =customer::where('status_active',1)
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




        $building_list_query        =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id);
        if($company_id)
        {
            $building_list_query->where('company_name',$company_id);
        }
        else{
            $building_list_query ->whereNull('company_name');
        }

        if($customer_id)
        {
            $building_list_query->where('customer_name',$customer_id);
        }
        else{
            $building_list_query ->whereNull('customer_name');
        }

        $building_list=$building_list_query->get(['id','building_no','building_name']);

        //===================Building==========================================

        $building_arr=array();
        foreach ($building_list as $key => $value) {
            $building_arr[$value->id]=$value->building_no."-".$value->building_name;
        }

        $data['building_arr']       =$building_arr;

        $floor_list                 =BuildingPropertyDetails::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('master_id',$building_id)
                                    ->get();
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {

            $floor_arr[$value->id]['floor_no']                  =$value->floor_no;
            $floor_arr[$value->id]['floor_type']                =$value->floor_type;
            $floor_arr[$value->id]['total_suite']               =$value->total_suite;
            $floor_arr[$value->id]['total_unit']                =$value->total_unit;
            $floor_arr[$value->id]['total_mechanical_room']     =$value->total_mechanical_room;
            $floor_arr[$value->id]['total_administrative_room'] =$value->total_administrative_room;
            $floor_arr[$value->id]['total_amenity_room']        =$value->total_amenity_room;
            $floor_arr[$value->id]['total_service_room']        =$value->total_service_room;
            $floor_arr[$value->id]['total_parking_lot']         =$value->total_parking_lot;
            $floor_arr[$value->id]['total_bike_lot']            =$value->total_bike_lot;
            $floor_arr[$value->id]['total_storage_lot']         =$value->total_storage_lot;
            $floor_arr[$value->id]['total_mailroom']            =$value->total_mailroom;
            $floor_arr[$value->id]['total_common_area']         =$value->total_common_area;

        }
        $data['floor_arr']        =$floor_arr;

        $data['floor_no_string']=$floor_arr[$floor_no]['floor_no'];
        $data['floor_type']=$floor_arr[$floor_no]['floor_type'];


        $data['floor_arr']        =$floor_arr;

        $building_info            =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$building_id)
                                    ->get(['dependent_building','independent_building','residential','commercial','residential_commercial']);

        $data['building_info']    =$building_info;


        //===================================Subrooms Details=======================================================
        $subrooms_list              =SubroomsList::where('status_active',1)
                                    ->get(['id','item_type','item_name']);
        $subrooms_list_arr=array();
        $sl=0;
        foreach ($subrooms_list as $key => $value) {
            $subrooms_list_arr[$sl]['item_name']     =$value->item_name;
            $subrooms_list_arr[$sl]['item_type']     =$value->item_type;
            $subrooms_list_arr[$sl]['id']            =$value->id;
            $sl++;
        }

        $data['subrooms_list_arr']        =$subrooms_list_arr;

        $subrooms_update_list              =SubroomsListDetails::where('status_active',1)
                                                        ->where('master_id',$id)
                                                        ->where('project_id',$project_id)
                                                        ->orderby('item_type')
                                                        ->get();
        $subrooms_list_details_arr=array();
        $sl1=0; $sl2=0;$sl3=0;$sl4=0;$sl5=0;$sl6=0;$sl7=0;$sl8=0;$sl9=0;$sl10=0;$sl11=0;
        foreach($subrooms_update_list as $value)
        {
            if($value->item_type==1)
            {
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl1]['id']           =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl1]['master_id']    =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl1]['item_type']    =$value->item_type;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl1]['item_id']      =$value->item_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl1]['item_name']    =$value->item_name;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl1]['item_qty']     =$value->item_qty;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl1]['property_no']  =$value->property_no;
                $sl1++;
            }
            else if($value->item_type==2)
            {
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl2]['id']           =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl2]['master_id']    =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl2]['item_type']    =$value->item_type;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl2]['item_id']      =$value->item_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl2]['item_name']    =$value->item_name;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl2]['item_qty']     =$value->item_qty;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl2]['property_no']  =$value->property_no;
                $sl2++;
            }
             else if($value->item_type==3)
            {
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl3]['id']           =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl3]['master_id']    =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl3]['item_type']    =$value->item_type;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl3]['item_id']      =$value->item_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl3]['item_name']    =$value->item_name;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl3]['item_qty']     =$value->item_qty;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl3]['property_no']  =$value->property_no;
                $sl3++;
            }
             else if($value->item_type==4)
            {
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl4]['id']           =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl4]['master_id']    =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl4]['item_type']    =$value->item_type;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl4]['item_id']      =$value->item_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl4]['item_name']    =$value->item_name;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl4]['item_qty']     =$value->item_qty;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl4]['property_no']  =$value->property_no;
                $sl4++;
            }
             else if($value->item_type==5)
            {
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl5]['id']           =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl5]['master_id']    =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl5]['item_type']    =$value->item_type;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl5]['item_id']      =$value->item_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl5]['item_name']    =$value->item_name;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl5]['item_qty']     =$value->item_qty;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl5]['property_no']  =$value->property_no;
                $sl5++;
            }
             else if($value->item_type==6)
            {
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl6]['id']           =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl6]['master_id']    =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl6]['item_type']    =$value->item_type;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl6]['item_id']      =$value->item_id;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl6]['item_name']    =$value->item_name;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl6]['item_qty']     =$value->item_qty;
                $subrooms_list_details_arr[$value->item_type][$value->property_no][$sl6]['property_no']  =$value->property_no;
                $sl6++;
            }
             else if($value->item_type==7)
            {
                $subrooms_list_details_arr[$value->item_type][$sl7]['id']           =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$sl7]['master_id']    =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$sl7]['item_type']    =$value->item_type;
                $subrooms_list_details_arr[$value->item_type][$sl7]['item_id']      =$value->item_id;
                $subrooms_list_details_arr[$value->item_type][$sl7]['item_name']    =$value->item_name;
                $subrooms_list_details_arr[$value->item_type][$sl7]['item_qty']     =$value->item_qty;
                $subrooms_list_details_arr[$value->item_type][$sl7]['property_no']  =null;
                $sl7++;
            }
            else if($value->item_type==8)
            {
                $subrooms_list_details_arr[$value->item_type][$sl8]['id']           =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$sl8]['master_id']    =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$sl8]['item_type']    =$value->item_type;
                $subrooms_list_details_arr[$value->item_type][$sl8]['item_id']      =$value->item_id;
                $subrooms_list_details_arr[$value->item_type][$sl8]['item_name']    =$value->item_name;
                $subrooms_list_details_arr[$value->item_type][$sl8]['item_qty']     =$value->item_qty;
                $subrooms_list_details_arr[$value->item_type][$sl8]['property_no']  =null;
                $sl8++;
            }
             else if($value->item_type==9)
            {
                $subrooms_list_details_arr[$value->item_type][$sl9]['id']           =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$sl9]['master_id']    =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$sl9]['item_type']    =$value->item_type;
                $subrooms_list_details_arr[$value->item_type][$sl9]['item_id']      =$value->item_id;
                $subrooms_list_details_arr[$value->item_type][$sl9]['item_name']    =$value->item_name;
                $subrooms_list_details_arr[$value->item_type][$sl9]['item_qty']     =$value->item_qty;
                $subrooms_list_details_arr[$value->item_type][$sl9]['property_no']  =null;
                $sl9++;
            }
            else if($value->item_type==10)
            {
                $subrooms_list_details_arr[$value->item_type][$sl10]['id']           =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$sl10]['master_id']    =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$sl10]['item_type']    =$value->item_type;
                $subrooms_list_details_arr[$value->item_type][$sl10]['item_id']      =$value->item_id;
                $subrooms_list_details_arr[$value->item_type][$sl10]['item_name']    =$value->item_name;
                $subrooms_list_details_arr[$value->item_type][$sl10]['item_qty']     =$value->item_qty;
                $subrooms_list_details_arr[$value->item_type][$sl10]['property_no']  =null;
                $sl10++;
            }
             else if($value->item_type==11)
            {
                $subrooms_list_details_arr[$value->item_type][$sl11]['id']           =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$sl11]['master_id']    =$value->master_id;
                $subrooms_list_details_arr[$value->item_type][$sl11]['item_type']    =$value->item_type;
                $subrooms_list_details_arr[$value->item_type][$sl11]['item_id']      =$value->item_id;
                $subrooms_list_details_arr[$value->item_type][$sl11]['item_name']    =$value->item_name;
                $subrooms_list_details_arr[$value->item_type][$sl11]['item_qty']     =$value->item_qty;
                $subrooms_list_details_arr[$value->item_type][$sl11]['property_no']  =null;
                $sl11++;
            }
            

        }
      
        $data['subrooms_list_details_arr']        =$subrooms_list_details_arr;
        
        $safety_device_equipment=SafetyDeviceEquipment::where('status_active',1)
                                                    ->where('page_id',2)
                                                    ->where('master_id',$id)
                                                    ->where('project_id',$project_id)
                                                    ->get();
        $sl=0;
        $safety_device_equipment_qty_arr=array();
        foreach ($safety_device_equipment as $key => $value) {
            $data['safety_device_equipment_arr'][$sl]['id']                 =$value->id;
            $data['safety_device_equipment_arr'][$sl]['reference_id']       =$value->reference_id;
            $data['safety_device_equipment_arr'][$sl]['item_id']            =$value->item_id;
            $data['safety_device_equipment_arr'][$sl]['reference_name']     =$value->reference_name;
            $data['safety_device_equipment_arr'][$sl]['name']               =$value->name;
            $data['safety_device_equipment_arr'][$sl]['comments']           =$value->comments;
            $data['safety_device_equipment_arr'][$sl]['floor_no']           =$value->floor_no;
            $data['safety_device_equipment_arr'][$sl]['serial_no']          =$value->serial_no;
            $data['safety_device_equipment_arr'][$sl]['expiry_date']        =$value->expiry_date;

            $data['safety_device_equipment_arr'][$sl]['renew_date']         =$value->renew_date;
            $data['safety_device_equipment_arr'][$sl]['due_on']             =$value->due_on;
            $data['safety_device_equipment_arr'][$sl]['cicle']              =$value->cicle;

            if(empty($safety_device_equipment_qty_arr[$value->item_id])) $safety_device_equipment_qty_arr[$value->item_id]=1;
            else $safety_device_equipment_qty_arr[$value->item_id]+=1;
            $sl++;
        }


        $safety_item_list=SafetyItemList::where('status_active',1)
                                    ->where('page_id',1)
                                    ->get();

        $sl=0;
        $safety_item_list_arr=array();
        foreach ($safety_item_list as $key => $value) {
            if(!empty($safety_device_equipment_qty_arr[$value->refernece_id]))
            {
                $safety_item_list_arr[$sl]['item_qty']      =$safety_device_equipment_qty_arr[$value->refernece_id];
            }
            else
            {
                $safety_item_list_arr[$sl]['item_qty']      ="";
            }
            $safety_item_list_arr[$sl]['id']            =$value->id;
            $safety_item_list_arr[$sl]['refernece_id']  =$value->refernece_id;
            $safety_item_list_arr[$sl]['item_name']     =$value->item_name;
            
            $sl++;
        }
        $data['safety_item_list_arr']        =$safety_item_list_arr;




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
            'floor_name' => 'required',
            'status_active' => 'required',
            
        ]);
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        Floor::find($id)->update($request->all());
        
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
         Floor::find($id)->delete();
        return ['message'=>'Module deleted'];
    }
}
