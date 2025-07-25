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
use App\Models\ExternalServiceProviderList;
use App\Models\SafetyDeviceEquipment;
use App\Models\BuildingContactDetails;
use App\Models\ExternalServiceProvider;
use App\Models\BuildingContactList;
use App\Models\CommercialUnit;
use App\Models\CommercialUnitDetails;

use Illuminate\Support\Facades\DB;

class CommercialUnitController extends Controller
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

        //===================Building==========================================

        $building_arr=array();
        foreach ($building_list as $key => $value) {
            $building_arr[$value->id]=$value->building_no."-".$value->building_name;
        }

        $data['building_arr']        =$building_arr;

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


        $external_service_provider_list=ExternalServiceProviderList::where('status_active',1)
                                    ->where('page_id',1)
                                    ->get();
        $sl=0;
        $external_service_provider_list_arr=array();
        foreach ($external_service_provider_list as $key => $value) {
            $external_service_provider_list_arr[$sl]['id']            =$value->id;
            $external_service_provider_list_arr[$sl]['item_name']     =$value->item_name;
            $sl++;
        }
        $data['external_service_provider_list_arr']        =$external_service_provider_list_arr;

        $building_contact_list=BuildingContactList::where('status_active',1)
                                    ->where('page_id',1)
                                    ->whereIn('project_id',[0,$project_id])
                                    ->get();
        $sl=0;
        $building_contact_list_arr=array();
        foreach ($building_contact_list as $key => $value) {
            $building_contact_list_arr[$sl]['id']            =$value->id;
            $building_contact_list_arr[$sl]['refernece_id']  =$value->refernece_id;
            $building_contact_list_arr[$sl]['item_name']     =$value->item_name;
            $building_contact_list_arr[$sl]['item_type']     =$value->item_type;
            $sl++;
        }
        $data['building_contact_list_arr']        =$building_contact_list_arr;
        return $data;

    }


    public function FloorDataByBuilding($building_id)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;

        $floor_list                 =DB::table('floors as mst')
                                        ->join('building_property_details as dtls','mst.floor_no','=','dtls.id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.master_id', '=', $building_id)
                                        ->where('dtls.total_unit', '>', 0)
                                        ->get(['dtls.floor_no','dtls.floor_type','dtls.total_unit','mst.id','mst.floor_name']);

        // BuildingPropertyDetails::where('status_active',1)
        //                             ->where('project_id',$project_id)
        //                             ->where('master_id',$building_id)
        //                             ->where('total_suite',">",0)
        //                             ->get();


       
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {

            $floor_arr[$value->id]['floor_name']                =$value->floor_name;
            $floor_arr[$value->id]['floor_no']                  =$value->floor_no;
            $floor_arr[$value->id]['floor_type']                =$value->floor_type;
            $floor_arr[$value->id]['total_unit']                =$value->total_unit;

        }

        $data['floor_arr']        =$floor_arr;

        $building_info            =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$building_id)
                                    ->get(['dependent_building','independent_building','residential','commercial','residential_commercial']);

        $data['building_info']    =$building_info;
        return $data;


    }
    public function loadUnitByFloor($floor_id,$unit_no)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;

        $inserted_unit              =CommercialUnit::where('status_active',1)
                                        ->where('floor_no',$floor_id)
                                        ->where('unit_no',$unit_no)
                                        ->first();
    
        if(empty($inserted_unit))
        {
            $subrooms_details               =SubroomsListDetails::where('status_active',1)
                                            ->where('item_type',2)
                                            ->where('master_id',$floor_id)
                                            ->where('property_no',$unit_no)
                                            //->toSql();
                                          ->get(['id','item_qty','item_name','item_id']);
            $subrooms_list_check=array();
            $subrooms_list_arr=array();
            $sl=0;
            foreach ($subrooms_details as $key => $value) {

                if($value->item_qty>1)
                {
                    for($i=1;$i<=$value->item_qty;$i++)
                    {
                        $subrooms_list_arr[$sl]['item_name']     =$value->item_name."-".str_pad($i,2,"0",STR_PAD_LEFT);
                        $subrooms_list_arr[$sl]['item_id']       =$value->item_id;
                        $subrooms_list_arr[$sl]['id']            ="";
                        $subrooms_list_arr[$sl]['details_id']    =$value->id;
                        $subrooms_list_arr[$sl]['item_size']     ="";
                        $subrooms_list_arr[$sl]['disable']       =false;
                        $subrooms_list_arr[$sl]['uom']           =1;
                        $sl++;
                    }
                   
                }
                else 
                {
                    $subrooms_list_arr[$sl]['item_name']     =$value->item_name;
                    $subrooms_list_arr[$sl]['item_id']       =$value->item_id;
                    $subrooms_list_arr[$sl]['id']            ="";
                    $subrooms_list_arr[$sl]['details_id']    =$value->id;
                    $subrooms_list_arr[$sl]['item_size']     ="";
                    $subrooms_list_arr[$sl]['disable']       =false;
                    $subrooms_list_arr[$sl]['uom']           =1;
                    $sl++;
                }

                $subrooms_list_check[$value->item_id]=$value->item_id;

            }

          


            $subrooms_list               =SubroomsList::where('status_active',1)
                                        ->where('item_type',2)
                                        ->get(['id','item_type','item_name','is_common']);

           
            
            foreach ($subrooms_list as $key => $value) {

                if(!in_array($value->id,$subrooms_list_check))
                {
                    $subrooms_list_arr[$sl]['item_name']     =$value->item_name;
                    $subrooms_list_arr[$sl]['item_id']       =$value->id;
                    $subrooms_list_arr[$sl]['id']            ="";
                    
                    $subrooms_list_arr[$sl]['details_id']    ="";
                    $subrooms_list_arr[$sl]['item_size']     ="";
                    if($value->is_common==1)
                    {
                        $subrooms_list_arr[$sl]['disable']   =false; 
                        $subrooms_list_arr[$sl]['uom']       =1;                   
                    }
                       
                    else
                    {
                        $subrooms_list_arr[$sl]['disable']   =true;
                        $subrooms_list_arr[$sl]['uom']       ="";
                    }
                        


                    $subrooms_list_check[$sl]=$value->id;
                    $sl++;
                }
                
            }


            $data['subrooms_list_arr']        =$subrooms_list_arr;
            return $data;

        }   


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
            'building_name' => 'required',
            'floor_no'      => 'required',
            'unit_no'      => 'required',
            'unit_name'    => 'required',
            
        ]);

        $unit_type=0;
        if($request->input('unit_store')==true) $unit_type=1;
        else if($request->input('unit_office')==true) $unit_type=2;


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['unit_type' =>$unit_type]);
        $request->merge(['project_id' =>$project_id]);

        

        $max_system_data = CommercialUnit::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from residential_suites 
            where building_name=".$request->input('building_name')."  and project_id=".$project_id." ) 
            and building_name=".$request->input('building_name')."  and project_id=".$project_id)->get(['system_prefix']);
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

        $system_no="CU-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        //dd($max_system_prefix);die;
        DB::beginTransaction();
        $suite_info= CommercialUnit::create($request->all());


       // dd($request->subrooms_list_details_arr);die;

        foreach($request->subrooms_list_arr as $key=>$details)
        {
                      
            if($details['disable']==false)
            {
                
                $data_subrooms_list_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$suite_info->id,
                    'item_id'                   =>$details['item_id'],
                    'details_id'                =>$details['details_id'],
                    'uom'                       =>$details['uom'],
                    'item_size'                 =>$details['item_size'],
                    'item_name'                 =>$details['item_name'],
                    'inserted_by'               =>$user_id,
                );
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
                    'master_id'                 =>$suite_info->id,
                    'item_id'                   =>$details['item_id'],
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>4,
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
                    'master_id'                 =>$suite_info->id,
                    'item_id'                   =>2,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>4,
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
                    'master_id'                 =>$suite_info->id,
                    'item_id'                   =>3,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>4,
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
                    'master_id'                 =>$suite_info->id,
                    'item_id'                   =>4,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>4,
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
                    'master_id'                 =>$suite_info->id,
                    'item_id'                   =>5,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>4,
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
                    'master_id'                 =>$suite_info->id,
                    'item_id'                   =>6,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>4,
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
                    'master_id'                 =>$suite_info->id,
                    'item_id'                   =>7,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>4,
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
                    'master_id'                 =>$suite_info->id,
                    'item_id'                   =>8,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>4,
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
                    'master_id'                 =>$suite_info->id,
                    'item_id'                   =>9,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>4,
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
                    'master_id'                 =>$suite_info->id,
                    'item_id'                   =>10,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>4,
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
                    'master_id'                 =>$suite_info->id,
                    'item_id'                   =>11,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>4,
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

        foreach($request->external_service_provider_details_arr as $key=>$details)
        {
            if($details['id_no']!="")
            {
                if($details['schedule_date'])
                {
                    $schedule_date                               =date("Y-m-d",strtotime($details['schedule_date']));
                }
                else $schedule_date="";

                if($details['schedule_date'])
                {
                    $schedule_date                               =date("Y-m-d",strtotime($details['schedule_date']));
                }
                else $schedule_date="";
                $data_external_service_provider[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$suite_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'item_name'                 =>$details['item_name'],
                    'page_id'                   =>4,
                    'id_no'                     =>$details['id_no'],
                    'account_no'                =>$details['account_no'],
                    'website'                   =>$details['website'],
                    'schedule_date'             =>$schedule_date,
                    'expected_due_date'         =>$schedule_date,
                    'billing_cycle'             =>$details['billing_cycle'],
                    'bill_delivery_method'      =>$details['bill_delivery_method'],
                    'payment_method'            =>$details['payment_method'],
                    'inserted_by'               =>$user_id,
                );
            }
        }


        foreach($request->building_contact_details_arr as $item_id=>$item_details)
        {
            if($item_id>0)
            {
               foreach($item_details as $key=>$details)
                {
                    if($details['contact_no']!="")
                    {
                        $data_building_contact[]= array(
                            'project_id'                =>$project_id,
                            'master_id'                 =>$suite_info->id,
                            'item_id'                   =>$item_id,
                            'page_id'                   =>4,
                            'reference_id'              =>$details['reference_id'],
                            'item_name'                 =>$details['item_name'],
                            'contact_no'                =>$details['contact_no'],
                            'phone'                     =>$details['phone'],
                            'website'                   =>$details['website'],
                            'mobile'                    =>$details['mobile'],
                            'email'                     =>$details['email'],
                            'hours_of_operation'        =>$details['hours_of_operation'],
                            'comment'                   =>$details['comments'],
                            'inserted_by'               =>$user_id,
                        );
                    }
                } 
            }
            
        }


        if($data_subrooms_list_details)
        {
            $RId1=CommercialUnitDetails::insert($data_subrooms_list_details);
        }


        if($data_safety_device_equipment)
        {
            $RId2=SafetyDeviceEquipment::insert($data_safety_device_equipment);
        }

        if($data_external_service_provider)
        {
            $RId3=ExternalServiceProvider::insert($data_external_service_provider);
        }

        if($data_building_contact)
        {
            $RId4=BuildingContactDetails::insert($data_building_contact);
        }

        if($suite_info  && $RId1 && $RId2 && $RId3 && $RId4 )
        {
           DB::commit();
           return "1**$suite_info->id**$system_no";
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

        $commercial_unit=CommercialUnit::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$id)
                                    ->first();

        $company_id     =$commercial_unit->company_name;
        $customer_id    =$commercial_unit->customer_name;
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

        $data['building_arr']        =$building_arr;


        //===================================Subrooms Details===========================================================

        
        
            $subrooms_details               =SubroomsListDetails::where('status_active',1)
                                            ->where('item_type',2)
                                            ->where('master_id',$floor_id)
                                            ->where('property_no',$unit_no)
                                            //->toSql();
                                          ->get(['id','item_qty','item_name','item_id']);
            $subrooms_list_check=array();
            $subrooms_list_arr=array();
            $sl=0;
            foreach ($subrooms_details as $key => $value) {

                if($value->item_qty>1)
                {
                    for($i=1;$i<=$value->item_qty;$i++)
                    {
                        $subrooms_list_arr[$sl]['item_name']     =$value->item_name."-".str_pad($i,2,"0",STR_PAD_LEFT);
                        $subrooms_list_arr[$sl]['item_id']       =$value->item_id;
                        $subrooms_list_arr[$sl]['id']            ="";
                        $subrooms_list_arr[$sl]['details_id']    =$value->id;
                        $subrooms_list_arr[$sl]['item_size']     ="";
                        $subrooms_list_arr[$sl]['disable']       =false;
                        $subrooms_list_arr[$sl]['uom']           =1;
                        $sl++;
                    }
                   
                }
                else 
                {
                    $subrooms_list_arr[$sl]['item_name']     =$value->item_name;
                    $subrooms_list_arr[$sl]['item_id']       =$value->item_id;
                    $subrooms_list_arr[$sl]['id']            ="";
                    $subrooms_list_arr[$sl]['details_id']    =$value->id;
                    $subrooms_list_arr[$sl]['item_size']     ="";
                    $subrooms_list_arr[$sl]['disable']       =false;
                    $subrooms_list_arr[$sl]['uom']           =1;
                    $sl++;
                }

                $subrooms_list_check[$value->item_id]=$value->item_id;

            }

          


            $subrooms_list               =SubroomsList::where('status_active',1)
                                        ->where('item_type',2)
                                        ->get(['id','item_type','item_name','is_common']);

           
            
            foreach ($subrooms_list as $key => $value) {

                if(!in_array($value->id,$subrooms_list_check))
                {
                    $subrooms_list_arr[$sl]['item_name']     =$value->item_name;
                    $subrooms_list_arr[$sl]['item_id']       =$value->id;
                    $subrooms_list_arr[$sl]['id']            ="";
                    
                    $subrooms_list_arr[$sl]['details_id']    ="";
                    $subrooms_list_arr[$sl]['item_size']     ="";
                    if($value->is_common==1)
                    {
                        $subrooms_list_arr[$sl]['disable']   =false; 
                        $subrooms_list_arr[$sl]['uom']       =1;                   
                    }
                       
                    else
                    {
                        $subrooms_list_arr[$sl]['disable']   =true;
                        $subrooms_list_arr[$sl]['uom']       ="";
                    }
                        


                    $subrooms_list_check[$sl]=$value->id;
                    $sl++;
                }
                
            }


            $data['subrooms_list_arr']        =$subrooms_list_arr;

        $safety_device_equipment=SafetyDeviceEquipment::where('status_active',1)
                                                    ->where('page_id',4)
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



        $external_service_provider=ExternalServiceProvider::where('status_active',1)
                                                        ->where('page_id',4)
                                                        ->where('master_id',$id)
                                                        ->where('project_id',$project_id)
                                                        ->get();


        $external_service_provider_arr=array();
        $external_service_provider_check_arr=array();
        foreach ($external_service_provider as $key => $value) {
            $external_service_provider_arr[$value->reference_id]['id']                  =$value->id;
            $external_service_provider_arr[$value->reference_id]['reference_id']        =$value->reference_id;
            $external_service_provider_arr[$value->reference_id]['item_name']           =$value->item_name;
            $external_service_provider_arr[$value->reference_id]['id_no']               =$value->id_no;
            $external_service_provider_arr[$value->reference_id]['account_no']          =$value->account_no;
            $external_service_provider_arr[$value->reference_id]['website']             =$value->website;
            $external_service_provider_arr[$value->reference_id]['schedule_date']       =$value->schedule_date;
            $external_service_provider_arr[$value->reference_id]['expected_due_date']   =$value->expected_due_date;
            $external_service_provider_arr[$value->reference_id]['billing_cycle']       =$value->billing_cycle;
            $external_service_provider_arr[$value->reference_id]['bill_delivery_method']=$value->bill_delivery_method;
            $external_service_provider_arr[$value->reference_id]['payment_method']      =$value->payment_method;
            $external_service_provider_arr[$value->reference_id]['master_id']           =$value->master_id;
            $external_service_provider_check_arr[$value->reference_id]=$value->reference_id;
        }

        $external_service_provider_list=ExternalServiceProviderList::where('status_active',1)
                                    ->where('page_id',1)
                                    ->get();



        $sl=0;
        $external_service_provider_list_arr=array();
        foreach ($external_service_provider_list as $key => $value) {

            if(in_array($value->id,$external_service_provider_check_arr))
            {
                $external_service_provider_list_arr[$sl]['id']                  =$external_service_provider_arr[$value->id]["id"];
                $external_service_provider_list_arr[$sl]['reference_id']        =$value->id;
                $external_service_provider_list_arr[$sl]['item_name']           =$value->item_name;
                $external_service_provider_list_arr[$sl]['id_no']               =$external_service_provider_arr[$value->id]["id_no"];
                $external_service_provider_list_arr[$sl]['account_no']          =$external_service_provider_arr[$value->id]["account_no"];
                $external_service_provider_list_arr[$sl]['website']             =$external_service_provider_arr[$value->id]["website"];
                $external_service_provider_list_arr[$sl]['schedule_date']       =$external_service_provider_arr[$value->id]["schedule_date"];
                $external_service_provider_list_arr[$sl]['expected_due_date']   =$external_service_provider_arr[$value->id]["expected_due_date"];
                $external_service_provider_list_arr[$sl]['billing_cycle']       =$external_service_provider_arr[$value->id]["billing_cycle"];

                $external_service_provider_list_arr[$sl]['bill_delivery_method']=$external_service_provider_arr[$value->id]["bill_delivery_method"];
                $external_service_provider_list_arr[$sl]['payment_method']      =$external_service_provider_arr[$value->id]["payment_method"];
                $external_service_provider_list_arr[$sl]['master_id']           =$external_service_provider_arr[$value->id]["master_id"];

               // dd($external_service_provider_list_arr);die;
            }
            else{

                $external_service_provider_list_arr[$sl]['id']                  ="";
                $external_service_provider_list_arr[$sl]['reference_id']        =$value->id;
                $external_service_provider_list_arr[$sl]['item_name']           =$value->item_name;
                $external_service_provider_list_arr[$sl]['id_no']               ="";
                $external_service_provider_list_arr[$sl]['account_no']          ="";
                $external_service_provider_list_arr[$sl]['website']             ="";
                $external_service_provider_list_arr[$sl]['schedule_date']       ="";
                $external_service_provider_list_arr[$sl]['expected_due_date']   ="";
                $external_service_provider_list_arr[$sl]['billing_cycle']       ="";

                $external_service_provider_list_arr[$sl]['bill_delivery_method']="";
                $external_service_provider_list_arr[$sl]['payment_method']      ="";
                $external_service_provider_list_arr[$sl]['master_id']           ="";

            }
           
            $sl++;
        }
        $data['external_service_provider_list_arr']        =$external_service_provider_list_arr;



        $building_contact_details=BuildingContactDetails::where('status_active',1)
                                                        ->where('page_id',4)
                                                        ->where('master_id',$id)
                                                        ->where('project_id',$project_id)
                                                        ->get();


        $building_contact_details_arr=array();
        $building_contact_details_check_arr=array();
        foreach ($building_contact_details as $key => $value) {
            
            $building_contact_details_arr[$value->reference_id]['id']                   =$value->id;
            $building_contact_details_arr[$value->reference_id]['reference_id']         =$value->reference_id;
            $building_contact_details_arr[$value->reference_id]['item_id']              =$value->item_id;
            $building_contact_details_arr[$value->reference_id]['item_name']            =$value->item_name;
            $building_contact_details_arr[$value->reference_id]['contact_no']           =$value->contact_no;
            $building_contact_details_arr[$value->reference_id]['comment']              =$value->comment;
            $building_contact_details_arr[$value->reference_id]['phone']                =$value->phone;
            $building_contact_details_arr[$value->reference_id]['website']              =$value->website;
            $building_contact_details_arr[$value->reference_id]['mobile']               =$value->mobile;
            $building_contact_details_arr[$value->reference_id]['email']                =$value->email;
            $building_contact_details_arr[$value->reference_id]['hours_of_operation']   =$value->hours_of_operation;
           
            $building_contact_details_check_arr[$value->reference_id]=$value->reference_id;
        }

//dd($building_contact_details_arr);
        $building_contact_list=BuildingContactList::where('status_active',1)
                                    ->where('page_id',1)
                                    ->whereIn('project_id',[0,$project_id])
                                    ->get();
        $sl=0;
        $building_contact_list_arr=array();
        foreach ($building_contact_list as $key => $value) {

            if(in_array($value->id,$building_contact_details_check_arr))
            {
                $building_contact_list_arr[$sl]['id']                   =$building_contact_details_arr[$value->id]["id"];
                $building_contact_list_arr[$sl]['reference_id']         =$value->id;
                $building_contact_list_arr[$sl]['item_type']            =$value->item_type;

                $building_contact_list_arr[$sl]['item_name']            =$value->item_name;
                $building_contact_list_arr[$sl]['contact_no']           =$building_contact_details_arr[$value->id]["contact_no"];
                $building_contact_list_arr[$sl]['comment']              =$building_contact_details_arr[$value->id]["comment"];
                $building_contact_list_arr[$sl]['phone']                =$building_contact_details_arr[$value->id]["phone"];
                $building_contact_list_arr[$sl]['website']              =$building_contact_details_arr[$value->id]["website"];
                $building_contact_list_arr[$sl]['mobile']               =$building_contact_details_arr[$value->id]["mobile"];
                $building_contact_list_arr[$sl]['email']                =$building_contact_details_arr[$value->id]["email"];
                $building_contact_list_arr[$sl]['hours_of_operation']   =$building_contact_details_arr[$value->id]["hours_of_operation"];

               
            }
            else{

                $building_contact_list_arr[$sl]['id']                   ="";
                $building_contact_list_arr[$sl]['reference_id']         =$value->id;
                $building_contact_list_arr[$sl]['item_name']            =$value->item_name;
                $building_contact_list_arr[$sl]['item_type']            =$value->item_type;
                $building_contact_list_arr[$sl]['contact_no']           ="";
                $building_contact_list_arr[$sl]['comment']              ="";
                $building_contact_list_arr[$sl]['website']              ="";
                $building_contact_list_arr[$sl]['phone']                ="";
                $building_contact_list_arr[$sl]['mobile']               ="";
                $building_contact_list_arr[$sl]['email']                ="";
                $building_contact_list_arr[$sl]['hours_of_operation']   ="";

            }

            $sl++;
        }
        $data['building_contact_list_arr']        =$building_contact_list_arr;


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
        //
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
