<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\BuildingContactDetails;
use App\Models\BuildingContactList;
use App\Models\BuildingInfo as BuildingInfo;
use App\Models\BuildingLicensePermit;
use App\Models\BuildingManagementType;
use App\Models\BuildingPropertyDetails;
use App\Models\ExternalServiceProvider;
use App\Models\ExternalServiceProviderList;
use App\Models\LicenseAndPermit;
use App\Models\SafetyDeviceEquipment;
use App\Models\SafetyItemList as SafetyItemList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BuildingInfoController extends Controller
{
    public function index()
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;

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
       
        $data['user_type']        =$user_type;       

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

        $license_and_permit_list=LicenseAndPermit::where('status_active',1)
                                    ->where('page_id',1)
                                    ->whereIn('project_id',[0,$project_id])
                                    ->get();
        $sl=0;
        $license_and_permit_list_arr=array();
        foreach ($license_and_permit_list as $key => $value) {
            $license_and_permit_list_arr[$sl]['reference_id']   =$value->id;
            $license_and_permit_list_arr[$sl]['item_name']      =$value->item_name;
            $license_and_permit_list_arr[$sl]['issued_by']      ="";
            $license_and_permit_list_arr[$sl]['expiry_date']    ="";
            $license_and_permit_list_arr[$sl]['webiste']        ="";
            $license_and_permit_list_arr[$sl]['mobile']         ="";
            $license_and_permit_list_arr[$sl]['phone']          ="";
            $license_and_permit_list_arr[$sl]['email']          ="";
            $license_and_permit_list_arr[$sl]['comment']        ="";
            $license_and_permit_list_arr[$sl]['id']             ="";
            $sl++;
        }
        $data['license_and_permit_list_arr']        =$license_and_permit_list_arr;

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


   

    public function BuildingInfoLits(Request $request)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        //===================Company==========================================
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }


        $building_list              =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_name',$company_id)
                                    ->get();    


        $sl=0;
    
         foreach ($building_list as $key => $value) {

            $data['building_list'][$key]['sl']                  =$sl+1;
            $data['building_list'][$key]['id']                  =$value->id;
            $data['building_list'][$key]['building_no']         =$value->building_no;
            $data['building_list'][$key]['building_name']       =$value->building_name;
            $data['building_list'][$key]['number_of_floor']     =$value->system_no;
         


            

            if($value->dependent_building==1)
            {
                $data['building_list'][$key]['dependency_class']           ="Dependent";

            }
            else if($value->independent_building==1)
            {
                $data['building_list'][$key]['dependency_class']           ="Independent";

            }

           

            if($value->residential==1)
            {
                $data['building_list'][$key]['property_type']     ="Residential";

            }
            else if($value->commercial==1)
            {
                $data['building_list'][$key]['property_type']     ="Commercial";

            }
            else
            {
                $data['building_list'][$key]['building_name']      ="Residential-Commercial";

            }

            $sl++;

        }

        
        return $data;

    }
    public function store(Request $request)
    {
       // dd($request->all());die;
        request()->validate([
            'building_name'             => 'required',
            'number_of_floor'           => 'required',
            'number_of_upper_floor'     => 'required',
            'number_of_ground_floor'    => 'required',
            'number_of_under_ground'    => 'required',
            'strata_lot_no'             => 'required',
        ]);
        //dd($request->building_contact_details_arr);    
        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return  20;
        }
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['user_id'          =>$user_id]);
        $request->merge(['company_name'     =>$company_id]);
        //dd($request->file('building_photo_url'));die;
        DB::beginTransaction();
        if($request->input('residential')==1)
        {
            $max_system_data = BuildingInfo::whereRaw('system_prefix=(select max(system_prefix) as system_prefix from building_infos 
            where residential=1 and project_id='.$project_id.' and company_name='.$company_id.' ) and residential=1 and company_name='.$company_id.' and project_id='.$project_id)->get(['system_prefix']);
            //dd($max_system_data);die;
            if(count($max_system_data)>0)
            {
                $max_system_prefix=$max_system_data[0]->system_prefix+1; 
            }
            else
            {
                $max_system_prefix=1; 
            }

            $system_no="RESB-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
            $request->merge(['building_no'               =>$system_no]);
            $request->merge(['system_prefix'           =>$max_system_prefix]);

        }
        else if($request->input('commercial')==1)
        {
            $max_system_data = BuildingInfo::whereRaw('system_prefix=(select max(system_prefix) as system_prefix from building_infos 
            where residential_commercial=1 and company_name='.$company_id.' and project_id='.$project_id.' ) and commercial=1 and company_name='.$company_id.' and project_id='.$project_id)->get(['system_prefix']);
            //dd($max_system_data);die;
            if(count($max_system_data)>0)
            {
                $max_system_prefix=$max_system_data[0]->system_prefix+1; 
            }
            else
            {
                $max_system_prefix=1; 
            }

            $system_no="COMB-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
            $request->merge(['building_no'               =>$system_no]);
            $request->merge(['system_prefix'           =>$max_system_prefix]);

        }
        else if($request->input('residential_commercial')==1)
        {
            $max_system_data = BuildingInfo::whereRaw('system_prefix=(select max(system_prefix) as system_prefix from building_infos 
            where residential_commercial=1 and company_name='.$company_id.' and project_id='.$project_id.' ) and residential_commercial=1 and company_name='.$company_id.' and project_id='.$project_id)->get(['system_prefix']);
            //dd($max_system_data);die;
            if(count($max_system_data)>0)
            {
                $max_system_prefix=$max_system_data[0]->system_prefix+1; 
            }
            else
            {
                $max_system_prefix=1; 
            }

            $system_no="RECB-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
            $request->merge(['building_no'               =>$system_no]);
            $request->merge(['system_prefix'           =>$max_system_prefix]);

        }
        

        $building_info= BuildingInfo::create($request->all());

        foreach($request->roof_top_arr as $key=>$details)
        {
            
            $data_building_property[]= array(
                'project_id'                    =>$project_id,
                'master_id'                     =>$building_info->id,
                'floor_type'                    =>1,
                'floor_no'                      =>$details['floor_no'],
                'total_suite'                   =>$details['suites'],
                'total_unit'                    =>$details['units'],
                'total_mechanical_room'         =>$details['mechanical_rooms'],
                'total_administrative_room'     =>$details['administrative_rooms'],
                'total_amenity_room'            =>$details['amenity_rooms'],
                'total_service_room'            =>$details['service_rooms'],
                'total_parking_lot'             =>$details['parking_lot'],
                'total_bike_lot'                =>$details['bike_lot'],
                'total_storage_lot'             =>$details['storage_lot'],
                'total_mailroom'                =>$details['mailroom'],
                'total_common_area'             =>$details['common_area'],
                'inserted_by'                   =>$user_id,
            );
            
        }


        foreach($request->upper_building_arr as $key=>$details)
        {
            
            $data_building_property[]= array(
                'project_id'                    =>$project_id,
                'master_id'                     =>$building_info->id,
                'floor_type'                    =>2,
                'floor_no'                      =>$details['floor_no'],
                'total_suite'                   =>$details['suites'],
                'total_unit'                    =>$details['units'],
                'total_mechanical_room'         =>$details['mechanical_rooms'],
                'total_administrative_room'     =>$details['administrative_rooms'],
                'total_amenity_room'            =>$details['amenity_rooms'],
                'total_service_room'            =>$details['service_rooms'],
                'total_parking_lot'             =>$details['parking_lot'],
                'total_bike_lot'                =>$details['bike_lot'],
                'total_storage_lot'             =>$details['storage_lot'],
                'total_mailroom'                 =>$details['mailroom'],
                'total_common_area'             =>$details['common_area'],
                'inserted_by'                   =>$user_id,
            );
            
        }


        foreach($request->ground_building_arr as $key=>$details)
        {
            
            $data_building_property[]= array(
                'project_id'                    =>$project_id,
                'master_id'                     =>$building_info->id,
                'floor_type'                    =>3,
                'floor_no'                      =>$details['floor_no'],
                'total_suite'                   =>$details['suites'],
                'total_unit'                    =>$details['units'],
                'total_mechanical_room'         =>$details['mechanical_rooms'],
                'total_administrative_room'     =>$details['administrative_rooms'],
                'total_amenity_room'            =>$details['amenity_rooms'],
                'total_service_room'            =>$details['service_rooms'],
                'total_parking_lot'             =>$details['parking_lot'],
                'total_bike_lot'                =>$details['bike_lot'],
                'total_storage_lot'             =>$details['storage_lot'],
                'total_mailroom'                 =>$details['mailroom'],
                'total_common_area'             =>$details['common_area'],
                'inserted_by'                   =>$user_id,
            );
            
        }

        foreach($request->under_ground_building_arr as $key=>$details)
        {
            
            $data_building_property[]= array(
                'project_id'                    =>$project_id,
                'master_id'                     =>$building_info->id,
                'floor_type'                    =>4,
                'floor_no'                      =>$details['floor_no'],
                'total_suite'                   =>$details['suites'],
                'total_unit'                    =>$details['units'],
                'total_mechanical_room'         =>$details['mechanical_rooms'],
                'total_administrative_room'     =>$details['administrative_rooms'],
                'total_amenity_room'            =>$details['amenity_rooms'],
                'total_service_room'            =>$details['service_rooms'],
                'total_parking_lot'             =>$details['parking_lot'],
                'total_bike_lot'                =>$details['bike_lot'],
                'total_storage_lot'             =>$details['storage_lot'],
                'total_mailroom'                =>$details['mailroom'],
                'total_common_area'             =>$details['common_area'],
                'inserted_by'                   =>$user_id,
            );
            
        }

        foreach($request->license_and_permit_list_arr as $key=>$details)
        {
            if($details['issued_by']!="")
            {

                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";

                $data_licence_permit[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$building_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'item_name'                 =>$details['item_name'],
                    'issued_by'                 =>$details['issued_by'],
                    'expiry_date'               =>$expiry_date,
                    'phone'                     =>$details['phone'],
                    'website'                   =>$details['website'],
                    'mobile'                    =>$details['mobile'],
                    'email'                     =>$details['email'],
                    'comment'                   =>$details['comment'],
                    'inserted_by'               =>$user_id,
                );
            }
        }


        foreach($request->property_management_type_arr as $key=>$details)
        {
            if($details['id_no']!="")
            {
                $data_building_management_type[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$building_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'item_name'                 =>$details['item_name'],
                    'id_no'                     =>$details['id_no'],
                    'name'                      =>$details['name'],
                    'phone'                     =>$details['phone'],
                    'website'                   =>$details['website'],
                    'mobile'                    =>$details['mobile'],
                    'email'                     =>$details['email'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

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
                    'master_id'                 =>$building_info->id,
                    'item_id'                   =>$details['item_id'],
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>1,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$details['floor_no'],
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
                    'master_id'                 =>$building_info->id,
                    'item_id'                   =>2,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>1,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$details['floor_no'],
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
                    'master_id'                 =>$building_info->id,
                    'item_id'                   =>3,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>1,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$details['floor_no'],
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
                    'master_id'                 =>$building_info->id,
                    'item_id'                   =>4,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>1,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$details['floor_no'],
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
                    'master_id'                 =>$building_info->id,
                    'item_id'                   =>5,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>1,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$details['floor_no'],
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
                    'master_id'                 =>$building_info->id,
                    'item_id'                   =>6,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>1,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$details['floor_no'],
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
                    'master_id'                 =>$building_info->id,
                    'item_id'                   =>7,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>1,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$details['floor_no'],
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
                    'master_id'                 =>$building_info->id,
                    'item_id'                   =>8,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>1,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$details['floor_no'],
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
                    'master_id'                 =>$building_info->id,
                    'item_id'                   =>9,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>1,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$details['floor_no'],
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
                    'master_id'                 =>$building_info->id,
                    'item_id'                   =>10,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>1,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$details['floor_no'],
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
                    'master_id'                 =>$building_info->id,
                    'item_id'                   =>11,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>1,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'floor_no'                  =>$details['floor_no'],
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
                    'master_id'                 =>$building_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'item_name'                 =>$details['item_name'],
                    'page_id'                   =>1,
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
                            'master_id'                 =>$building_info->id,
                            'item_id'                   =>$item_id,
                            'page_id'                   =>1,
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


        $RId1=true;
        $RId2=true;
        $RId3=true;
        $RId4=true;
        $RId5=true;
        $RId6=true;

        if($data_building_property)
        {
            $RId1=BuildingPropertyDetails::insert($data_building_property);
        }
        if($data_licence_permit)
        {
            $RId2=BuildingLicensePermit::insert($data_licence_permit);
        }

        if($data_building_management_type)
        {
            $RId3=BuildingManagementType::insert($data_building_management_type);
        }


        if($data_safety_device_equipment)
        {
            $RId4=SafetyDeviceEquipment::insert($data_safety_device_equipment);
        }

        if($data_external_service_provider)
        {
            $RId5=ExternalServiceProvider::insert($data_external_service_provider);
        }

        if($data_building_contact)
        {
            $RId6=BuildingContactDetails::insert($data_building_contact);
        }

        if($building_info  && $RId1 && $RId2 && $RId3 && $RId4 && $RId5 && $RId6)
        {
           DB::commit();
           return "1**$building_info->id**$system_no";
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
        $user_type                  = $user->user_type;

       

        $building_list=BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$id)
                                    ->first();
        $data['building_list_arr']=$building_list;                            
        $company_id     =$building_list->company_name;
       
        $data['user_type']              =$user_type;

        //===================================Subrooms Details=======================================================

        $building_property_details=BuildingPropertyDetails::where('status_active',1)
                                    ->where('master_id',$id)
                                    ->get();
        $data['building_property_details_arr']        =$building_property_details;
        
    

        $BuildingManagementType=BuildingManagementType::where('status_active',1)
                                    ->where('master_id',$id)
                                    ->where('page_id',1)
                                    ->get();
     

         $ksl=0;
         $property_management_arr_check=array();
        foreach ($BuildingManagementType as  $value) {

            $data['property_management_arr'][$ksl]['id']                    =$value->id;
            $data['property_management_arr'][$ksl]['reference_id']          =$value->reference_id;
            $data['property_management_arr'][$ksl]['item_name']             =$value->item_name;
            $data['property_management_arr'][$ksl]['id_no']                 =$value->id_no;
            $data['property_management_arr'][$ksl]['name']                  =$value->name;
            $data['property_management_arr'][$ksl]['phone']                 =$value->phone;
            $data['property_management_arr'][$ksl]['website']               =$value->website;
            $data['property_management_arr'][$ksl]['mobile']                =$value->mobile;
            $data['property_management_arr'][$ksl]['email']                 =$value->email;
            $property_management_arr_check[$value->reference_id]            =$value->reference_id;

            $ksl++;
        }


        $ArrayFunction              =new ArrayFunction();
        $property_management_arr    =$ArrayFunction->property_management_type;
        foreach($property_management_arr as $key=>$val)
        {
            if(!in_array($key,$property_management_arr_check))
            {

                $data['property_management_arr'][$ksl]['id']            ="";
                $data['property_management_arr'][$ksl]['reference_id']  =$key;
                $data['property_management_arr'][$ksl]['item_name']     =$val;
                $data['property_management_arr'][$ksl]['id_no']         ="";
                $data['property_management_arr'][$ksl]['name']          ="";
                $data['property_management_arr'][$ksl]['phone']         ="";
                $data['property_management_arr'][$ksl]['website']       ="";
                $data['property_management_arr'][$ksl]['mobile']        ="";
                $data['property_management_arr'][$ksl]['email']         ="";
                $ksl++;
            }
            
        }


        

        $license_and_permit_update=BuildingLicensePermit::where('status_active',1)
                                    ->where('master_id',$id)
                                    ->where('page_id',1)
                                    ->get();
     

        $sl=0;
        $license_and_permit_list_arr=array();
        $license_and_permit_check=array();
        foreach ($license_and_permit_update as  $value) {

            $license_and_permit_list_arr[$sl]['reference_id']   =$value->reference_id;
            $license_and_permit_list_arr[$sl]['item_name']      =$value->item_name;
            $license_and_permit_list_arr[$sl]['issued_by']      =$value->issued_by;
            $license_and_permit_list_arr[$sl]['expiry_date']    =$value->expiry_date;
            $license_and_permit_list_arr[$sl]['website']        =$value->website;
            $license_and_permit_list_arr[$sl]['mobile']         =$value->mobile;
            $license_and_permit_list_arr[$sl]['phone']          =$value->phone;
            $license_and_permit_list_arr[$sl]['email']          =$value->email;
            $license_and_permit_list_arr[$sl]['comment']        =$value->comment;
            $license_and_permit_list_arr[$sl]['id']             =$value->id;
            $license_and_permit_check[$value->reference_id]     =$value->reference_id;

            $sl++;
        }
       
        $license_and_permit_list=LicenseAndPermit::where('status_active',1)
                                    ->where('page_id',1)
                                    ->whereIn('project_id',[0,$project_id])
                                    ->get();
        
       
        foreach ($license_and_permit_list as $key => $value) {
            if(!in_array($value->id,$license_and_permit_check))
            {
                $license_and_permit_list_arr[$sl]['reference_id']   =$value->id;
                $license_and_permit_list_arr[$sl]['item_name']      =$value->item_name;
                $license_and_permit_list_arr[$sl]['issued_by']      ="";
                $license_and_permit_list_arr[$sl]['expiry_date']    ="";
                $license_and_permit_list_arr[$sl]['website']        ="";
                $license_and_permit_list_arr[$sl]['mobile']         ="";
                $license_and_permit_list_arr[$sl]['phone']          ="";
                $license_and_permit_list_arr[$sl]['email']          ="";
                $license_and_permit_list_arr[$sl]['comment']        ="";
                $license_and_permit_list_arr[$sl]['id']             ="";
                $sl++;
            }
        }
        $data['license_and_permit_list_arr']        =$license_and_permit_list_arr;


        $safety_device_equipment=SafetyDeviceEquipment::where('status_active',1)
                                                    ->where('page_id',1)
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
                                                        ->where('page_id',1)
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
                                                        ->where('page_id',1)
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
         request()->validate([
            'building_name' => 'required',
            'number_of_floor' => 'required',
            'number_of_upper_floor' => 'required',
            'number_of_ground_floor' => 'required',
            'number_of_under_ground' => 'required',
           // 'number_of_rental_store' => 'required',
        ]);
        
        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['updated_by'       =>$user_id]);
        DB::beginTransaction();
        
       
        $data_building_info= BuildingInfo::find($id)->update($request->all());

        foreach($request->roof_top_arr as $key=>$details)
        {
            
            if($details['id'])
            {
                $building_property_data= array(
                    
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'updated_by'                    =>$user_id,
                );

                $PropertyUpdate=BuildingPropertyDetails::where('id',"=",$details['id'])->update($building_property_data);
                if( !$PropertyUpdate)
                
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else{

                $data_building_property[]= array(
                    'project_id'                    =>$project_id,
                    'master_id'                     =>$id,
                    'floor_type'                    =>1,
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'inserted_by'                   =>$user_id,
                );
            }
            
            
        }

        foreach($request->upper_building_arr as $key=>$details)
        {
            
            if($details['id'])
            {
                $building_property_data= array(
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'updated_by'                    =>$user_id,
                );

                $PropertyUpdate=BuildingPropertyDetails::where('id',"=",$details['id'])->update($building_property_data);
                if( !$PropertyUpdate)
                
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else{

                $data_building_property[]= array(
                    'project_id'                    =>$project_id,
                    'master_id'                     =>$id,
                    'floor_type'                    =>2,
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'inserted_by'                   =>$user_id,
                );
            }
            
            
        }

        foreach($request->ground_building_arr as $key=>$details)
        {
            
            if($details['id'])
            {
                $building_property_data= array(
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'updated_by'                    =>$user_id,
                );

                $PropertyUpdate=BuildingPropertyDetails::where('id',"=",$details['id'])->update($building_property_data);
                if( !$PropertyUpdate)
                
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else{

                $data_building_property[]= array(
                    'project_id'                    =>$project_id,
                    'master_id'                     =>$id,
                    'floor_type'                    =>3,
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'inserted_by'                   =>$user_id,
                );
            }
            
            
        }

        foreach($request->under_ground_building_arr as $key=>$details)
        {
            
            if($details['id'])
            {
                $building_property_data= array(
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'updated_by'                    =>$user_id,
                );

                $PropertyUpdate=BuildingPropertyDetails::where('id',"=",$details['id'])->update($building_property_data);
                if( !$PropertyUpdate)
                
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else{

                $data_building_property[]= array(
                    'project_id'                    =>$project_id,
                    'master_id'                     =>$id,
                    'floor_type'                    =>3,
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'inserted_by'                   =>$user_id,
                );
            }
        }

        foreach($request->license_and_permit_list_arr as $key=>$details)
        {
            if($details['issued_by']!="")
            {

                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";
                if($details['id'])
                {
                    $licence_permit_data= array(
                        'issued_by'                 =>$details['issued_by'],
                        'expiry_date'               =>$expiry_date,
                        'phone'                     =>$details['phone'],
                        'website'                   =>$details['website'],
                        'mobile'                    =>$details['mobile'],
                        'email'                     =>$details['email'],
                        'comment'                   =>$details['comment'],
                        'updated_by'               =>$user_id,
                    );

                    $licence_permit=BuildingLicensePermit::where('id',"=",$details['id'])->update($licence_permit_data);
                    if( !$licence_permit)
                    
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_licence_permit[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'item_name'                 =>$details['item_name'],
                        'issued_by'                 =>$details['issued_by'],
                        'expiry_date'               =>$expiry_date,
                        'phone'                     =>$details['phone'],
                        'website'                   =>$details['website'],
                        'mobile'                    =>$details['mobile'],
                        'email'                     =>$details['email'],
                        'comment'                   =>$details['comment'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
        }

        foreach($request->property_management_type_arr as $key=>$details)
        {
            if($details['id_no']!="")
            {
                if($details['id']!="")
                {

                    $building_management_type_data= array(
                        
                        'id_no'                     =>$details['id_no'],
                        'name'                      =>$details['name'],
                        'phone'                     =>$details['phone'],
                        'website'                   =>$details['website'],
                        'mobile'                    =>$details['mobile'],
                        'email'                     =>$details['email'],
                        'updated_by'                =>$user_id,
                    );

                    $PropertyManagementType=BuildingManagementType::where('id',"=",$details['id'])->update($building_management_type_data);
                    if( !$PropertyManagementType)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else 
                {
                    $data_building_management_type[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'item_name'                 =>$details['item_name'],
                        'id_no'                     =>$details['id_no'],
                        'name'                      =>$details['name'],
                        'phone'                     =>$details['phone'],
                        'website'                   =>$details['website'],
                        'mobile'                    =>$details['mobile'],
                        'email'                     =>$details['email'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
        }


        // Safety Item====================================================

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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>1,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>2,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>3,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>4,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>5,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>6,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>7,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>8,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>9,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>10,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>11,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id'])
                {
                    $external_service_provider_data= array(
                        
                        'id_no'                     =>$details['id_no'],
                        'account_no'                =>$details['account_no'],
                        'website'                   =>$details['website'],
                        'schedule_date'             =>$schedule_date,
                        'expected_due_date'         =>$schedule_date,
                        'billing_cycle'             =>$details['billing_cycle'],
                        'bill_delivery_method'      =>$details['bill_delivery_method'],
                        'payment_method'            =>$details['payment_method'],
                        'updated_by'                =>$user_id,
                    );

                    $ExternalService=ExternalServiceProvider::where('id',"=",$details['id'])->update($external_service_provider_data);
                    if( !$ExternalService)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_external_service_provider[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'item_name'                 =>$details['item_name'],
                        'page_id'                   =>1,
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
        }


        foreach($request->building_contact_details_arr as $item_id=>$item_details)
        {
            if($item_id>0)
            {
               foreach($item_details as $key=>$details)
                {
                    if($details['contact_no']!="")
                    {

                        if($details['id']!="")
                        {
                            $building_contact_data= array(
                                'contact_no'                =>$details['contact_no'],
                                'phone'                     =>$details['phone'],
                                'website'                   =>$details['website'],
                                'mobile'                    =>$details['mobile'],
                                'email'                     =>$details['email'],
                                'hours_of_operation'        =>$details['hours_of_operation'],
                                'comment'                   =>$details['comment'],
                                'updated_by'                =>$user_id,
                            );

                            $buildingContact=BuildingContactDetails::where('id',"=",$details['id'])->update($building_contact_data);
                            if( !$buildingContact)
                            {
                                DB::rollBack();
                                return 10;
                                die;
                            }
                        }
                        else
                        {
                             $data_building_contact[]= array(
                                'project_id'                =>$project_id,
                                'master_id'                 =>$id,
                                'item_id'                   =>$item_id,
                                'page_id'                   =>1,
                                'reference_id'              =>$details['reference_id'],
                                'item_name'                 =>$details['item_name'],
                                'contact_no'                =>$details['contact_no'],
                                'phone'                     =>$details['phone'],
                                'website'                   =>$details['website'],
                                'mobile'                    =>$details['mobile'],
                                'email'                     =>$details['email'],
                                'hours_of_operation'        =>$details['hours_of_operation'],
                                'comment'                   =>$details['comment'],
                                'inserted_by'               =>$user_id,
                            );
                        }
                       
                    }
                } 
            }
            
        }

        
        $RId1=true;
        $RId2=true;
        $RId3=true;
        $RId4=true;
        $RId5=true;
        $RId6=true;

        if(!empty($data_building_property))
        {
            $RId1=BuildingPropertyDetails::insert($data_building_property);
        }
        if(!empty($data_licence_permit))
        {
            $RId2=BuildingLicensePermit::insert($data_licence_permit);
        }

        if(!empty($data_building_management_type))
        {
            $RId3=BuildingManagementType::insert($data_building_management_type);
        }


        if(!empty($data_safety_device_equipment))
        {
            $RId4=SafetyDeviceEquipment::insert($data_safety_device_equipment);
        }

        if(!empty($data_external_service_provider))
        {
            $RId5=ExternalServiceProvider::insert($data_external_service_provider);
        }

        if(!empty($data_building_contact))
        {
            $RId6=BuildingContactDetails::insert($data_building_contact);
        }



        if($data_building_info  && $RId1 && $RId2 && $RId3 && $RId4 && $RId5 && $RId6)
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


    public function post(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
            $currency_id=$request->session()->get('currency_id');
        }
        else {

            return "10**200"; 
        }

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>$request->input("posting_status"),
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=BuildingInfo::where('id',"=",$id)->update($update_data);

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
         request()->validate([
            'building_name'             => 'required',
            'number_of_floor'           => 'required',
            'number_of_upper_floor'     => 'required',
            'number_of_ground_floor'    => 'required',
            'number_of_under_ground'    => 'required',
            'strata_lot_no'             => 'required',
        ]);
        
        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['updated_by'       =>$user_id]);
        $request->merge(['posting_status'   =>3]);
        DB::beginTransaction();

       
        $data_building_info= BuildingInfo::find($id)->update($request->all());

        foreach($request->roof_top_arr as $key=>$details)
        {
            
            if($details['id'])
            {
                $building_property_data= array(
                    
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'updated_by'                    =>$user_id,
                );

                $PropertyUpdate=BuildingPropertyDetails::where('id',"=",$details['id'])->update($building_property_data);
                if( !$PropertyUpdate)
                
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else{

                $data_building_property[]= array(
                    'project_id'                    =>$project_id,
                    'master_id'                     =>$id,
                    'floor_type'                    =>1,
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'inserted_by'                   =>$user_id,
                );
            }
            
        }

        foreach($request->upper_building_arr as $key=>$details)
        {
            
            if($details['id'])
            {
                $building_property_data= array(
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'updated_by'                    =>$user_id,
                );

                $PropertyUpdate=BuildingPropertyDetails::where('id',"=",$details['id'])->update($building_property_data);
                if( !$PropertyUpdate)
                
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else{

                $data_building_property[]= array(
                    'project_id'                    =>$project_id,
                    'master_id'                     =>$id,
                    'floor_type'                    =>2,
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'inserted_by'                   =>$user_id,
                );
            }
            
            
        }

        foreach($request->ground_building_arr as $key=>$details)
        {
            
            if($details['id'])
            {
                $building_property_data= array(
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'updated_by'                    =>$user_id,
                );

                $PropertyUpdate=BuildingPropertyDetails::where('id',"=",$details['id'])->update($building_property_data);
                if( !$PropertyUpdate)
                
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else{

                $data_building_property[]= array(
                    'project_id'                    =>$project_id,
                    'master_id'                     =>$id,
                    'floor_type'                    =>3,
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'inserted_by'                   =>$user_id,
                );
            }
            
            
        }

        foreach($request->under_ground_building_arr as $key=>$details)
        {
            
            if($details['id'])
            {
                $building_property_data= array(
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'updated_by'                    =>$user_id,
                );

                $PropertyUpdate=BuildingPropertyDetails::where('id',"=",$details['id'])->update($building_property_data);
                if( !$PropertyUpdate)
                
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
            else{

                $data_building_property[]= array(
                    'project_id'                    =>$project_id,
                    'master_id'                     =>$id,
                    'floor_type'                    =>3,
                    'floor_no'                      =>$details['floor_no'],
                    'total_suite'                   =>$details['suites'],
                    'total_unit'                    =>$details['units'],
                    'total_mechanical_room'         =>$details['mechanical_rooms'],
                    'total_administrative_room'     =>$details['administrative_rooms'],
                    'total_amenity_room'            =>$details['amenity_rooms'],
                    'total_service_room'            =>$details['service_rooms'],
                    'total_parking_lot'             =>$details['parking_lot'],
                    'total_bike_lot'                =>$details['bike_lot'],
                    'total_storage_lot'             =>$details['storage_lot'],
                    'total_mailroom'                 =>$details['mailroom'],
                    'total_common_area'             =>$details['common_area'],
                    'inserted_by'                   =>$user_id,
                );
            }
        }

        foreach($request->license_and_permit_list_arr as $key=>$details)
        {
            if($details['issued_by']!="")
            {

                if($details['expiry_date'])
                {
                    $expiry_date                               =date("Y-m-d",strtotime($details['expiry_date']));
                }
                else $expiry_date="";
                if($details['id'])
                {
                    $licence_permit_data= array(
                        'issued_by'                 =>$details['issued_by'],
                        'expiry_date'               =>$expiry_date,
                        'phone'                     =>$details['phone'],
                        'website'                   =>$details['website'],
                        'mobile'                    =>$details['mobile'],
                        'email'                     =>$details['email'],
                        'comment'                   =>$details['comment'],
                        'updated_by'               =>$user_id,
                    );

                    $licence_permit=BuildingLicensePermit::where('id',"=",$details['id'])->update($licence_permit_data);
                    if( !$licence_permit)
                    
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_licence_permit[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'item_name'                 =>$details['item_name'],
                        'issued_by'                 =>$details['issued_by'],
                        'expiry_date'               =>$expiry_date,
                        'phone'                     =>$details['phone'],
                        'website'                   =>$details['website'],
                        'mobile'                    =>$details['mobile'],
                        'email'                     =>$details['email'],
                        'comment'                   =>$details['comment'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
        }

        foreach($request->property_management_type_arr as $key=>$details)
        {
            if($details['id_no']!="")
            {
                if($details['id']!="")
                {

                    $building_management_type_data= array(
                        
                        'id_no'                     =>$details['id_no'],
                        'name'                      =>$details['name'],
                        'phone'                     =>$details['phone'],
                        'website'                   =>$details['website'],
                        'mobile'                    =>$details['mobile'],
                        'email'                     =>$details['email'],
                        'updated_by'                =>$user_id,
                    );

                    $PropertyManagementType=BuildingManagementType::where('id',"=",$details['id'])->update($building_management_type_data);
                    if( !$PropertyManagementType)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else 
                {
                    $data_building_management_type[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'item_name'                 =>$details['item_name'],
                        'id_no'                     =>$details['id_no'],
                        'name'                      =>$details['name'],
                        'phone'                     =>$details['phone'],
                        'website'                   =>$details['website'],
                        'mobile'                    =>$details['mobile'],
                        'email'                     =>$details['email'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
        }


        // Safety Item====================================================

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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>1,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>2,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>3,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>4,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>5,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>6,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>7,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>8,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>9,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>10,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id']!="")
                {
                    $safety_device_equipment_data= array(
                        
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'updated_by'                =>$user_id,
                    );

                    $SafetyDevice=SafetyDeviceEquipment::where('id',"=",$details['id'])->update($safety_device_equipment_data);
                    if( !$SafetyDevice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else{

                    $data_safety_device_equipment[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'reference_id'              =>$details['reference_id'],
                        'reference_name'            =>$details['reference_name'],
                        'page_id'                   =>11,
                        'item_id'                   =>$details['item_id'],
                        'name'                      =>$details['name'],
                        'floor_no'                  =>$details['floor_no'],
                        'serial_no'                 =>$details['serial_no'],
                        'expiry_date'               =>$expiry_date,
                        'renew_date'                =>$renew_date,
                        'due_on'                    =>$due_on,
                        'cicle'                     =>$details['cicle'],
                        'inserted_by'               =>$user_id,
                    );

                }
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

                if($details['id'])
                {
                    $external_service_provider_data= array(
                        
                        'id_no'                     =>$details['id_no'],
                        'account_no'                =>$details['account_no'],
                        'website'                   =>$details['website'],
                        'schedule_date'             =>$schedule_date,
                        'expected_due_date'         =>$schedule_date,
                        'billing_cycle'             =>$details['billing_cycle'],
                        'bill_delivery_method'      =>$details['bill_delivery_method'],
                        'payment_method'            =>$details['payment_method'],
                        'updated_by'                =>$user_id,
                    );

                    $ExternalService=ExternalServiceProvider::where('id',"=",$details['id'])->update($external_service_provider_data);
                    if( !$ExternalService)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_external_service_provider[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'item_name'                 =>$details['item_name'],
                        'page_id'                   =>1,
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
        }


        foreach($request->building_contact_details_arr as $item_id=>$item_details)
        {
            if($item_id>0)
            {
               foreach($item_details as $key=>$details)
                {
                    if($details['contact_no']!="")
                    {

                        if($details['id']!="")
                        {
                            $building_contact_data= array(
                                'contact_no'                =>$details['contact_no'],
                                'phone'                     =>$details['phone'],
                                'website'                   =>$details['website'],
                                'mobile'                    =>$details['mobile'],
                                'email'                     =>$details['email'],
                                'hours_of_operation'        =>$details['hours_of_operation'],
                                'comment'                   =>$details['comment'],
                                'updated_by'                =>$user_id,
                            );

                            $buildingContact=BuildingContactDetails::where('id',"=",$details['id'])->update($building_contact_data);
                            if( !$buildingContact)
                            {
                                DB::rollBack();
                                return 10;
                                die;
                            }
                        }
                        else
                        {
                             $data_building_contact[]= array(
                                'project_id'                =>$project_id,
                                'master_id'                 =>$id,
                                'item_id'                   =>$item_id,
                                'page_id'                   =>1,
                                'reference_id'              =>$details['reference_id'],
                                'item_name'                 =>$details['item_name'],
                                'contact_no'                =>$details['contact_no'],
                                'phone'                     =>$details['phone'],
                                'website'                   =>$details['website'],
                                'mobile'                    =>$details['mobile'],
                                'email'                     =>$details['email'],
                                'hours_of_operation'        =>$details['hours_of_operation'],
                                'comment'                   =>$details['comment'],
                                'inserted_by'               =>$user_id,
                            );
                        }
                       
                    }
                } 
            }
            
        }

        
        $RId1=true;
        $RId2=true;
        $RId3=true;
        $RId4=true;
        $RId5=true;
        $RId6=true;

        if(!empty($data_building_property))
        {
            $RId1=BuildingPropertyDetails::insert($data_building_property);
        }
        if(!empty($data_licence_permit))
        {
            $RId2=BuildingLicensePermit::insert($data_licence_permit);
        }

        if(!empty($data_building_management_type))
        {
            $RId3=BuildingManagementType::insert($data_building_management_type);
        }


        if(!empty($data_safety_device_equipment))
        {
            $RId4=SafetyDeviceEquipment::insert($data_safety_device_equipment);
        }

        if(!empty($data_external_service_provider))
        {
            $RId5=ExternalServiceProvider::insert($data_external_service_provider);
        }

        if(!empty($data_building_contact))
        {
            $RId6=BuildingContactDetails::insert($data_building_contact);
        }



        if($data_building_info  && $RId1 && $RId2 && $RId3 && $RId4 && $RId5 && $RId6)
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
            $currency_id=$request->session()->get('currency_id');
        }
        else {

            return "10**200"; 
        }

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>4,
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=BuildingInfo::where('id',"=",$id)->update($update_data);

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
}
