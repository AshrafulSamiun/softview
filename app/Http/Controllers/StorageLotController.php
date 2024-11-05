<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\BuildingContactDetails;
use App\Models\BuildingContactList;
use App\Models\BuildingInfo as BuildingInfo;
use App\Models\BuildingLicensePermit;
use App\Models\BuildingManagementType;
use App\Models\ExternalServiceProvider;
use App\Models\ExternalServiceProviderList;
use App\Models\Floor as Floor;
use App\Models\LicenseAndPermit;
use App\Models\SafetyDeviceEquipment;
use App\Models\SafetyItemList as SafetyItemList;
use App\Models\StorageLevel;
use App\Models\StorageLocker;
use App\Models\StorageLot;
use App\Models\StorageStallDetails;
use App\Models\SubroomsListDetails as SubroomsListDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StorageLotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;

        $ArrayFunction              =new ArrayFunction();
        $property_management_arr    =$ArrayFunction->property_management_type;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        $ksl=0;
        foreach($property_management_arr as $key=>$val)
        {
            $data['property_management_arr'][$ksl]['id']=$key;
            $data['property_management_arr'][$ksl]['val']=$val;
            $ksl++;
        }

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
            $license_and_permit_list_arr[$sl]['website']        ="";
            $license_and_permit_list_arr[$sl]['mobile']         ="";
            $license_and_permit_list_arr[$sl]['phone']          ="";
            $license_and_permit_list_arr[$sl]['email']          ="";
            $license_and_permit_list_arr[$sl]['comment']        ="";
            $license_and_permit_list_arr[$sl]['id']             ="";
            $sl++;
        }
        $data['license_and_permit_list_arr']        =$license_and_permit_list_arr;

        

        $building_list              =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_name',$company_id)
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


    public function StorageFloorDataByBuilding($building_id)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;


        $floor_list                 =DB::table('floors as mst')
                                        ->join('building_property_details as dtls','mst.floor_no','=','dtls.id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.master_id', '=', $building_id)
                                        ->where('dtls.total_storage_lot', '>', 0)
                                        ->get(['dtls.floor_no','dtls.floor_type','dtls.total_storage_lot','mst.id','mst.floor_name']);
       
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {

            $floor_arr[$value->id]['floor_name']                =$value->floor_name;
            $floor_arr[$value->id]['floor_no']                  =$value->floor_no;
            $floor_arr[$value->id]['floor_type']                =$value->floor_type;
            $floor_arr[$value->id]['total_storage_lot']         =$value->total_storage_lot;

        }

        $data['floor_arr']        =$floor_arr;

        $building_info            =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$building_id)
                                    ->get(['dependent_building','independent_building','residential','commercial','residential_commercial']);

        $data['building_info']    =$building_info;
        return $data;


    }


    public function loadStorageLotByFloor($floor_id)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $storage_type_arr           =$ArrayFunction->storage_type_arr;
        $stall_closest_item_arr     =$ArrayFunction->stall_closest_item_arr;

        $inserted_unit              =StorageLot::where('status_active',1)
                                        ->where('floor_no',$floor_id)
                                        ->first();
    
        if(empty($inserted_unit))
        {
            $subrooms_details               =SubroomsListDetails::where('status_active',1)
                                            ->where('item_type',5)
                                            ->where('master_id',$floor_id)
                                            ->get(['id','item_qty','item_name','item_id','property_no']);

            $subrooms_list_check=array();
            $subrooms_list_arr=array();
            $storage_type_total_arr=array();
            $storage_lot_total_arr=array();
            $sl=0;
            $storege_level=0;
            $storege_locker=0;
            foreach ($subrooms_details as $key => $value) {

                $storege_level++;
                $subrooms_list_arr[$value->property_no]['property_name'] ="";
                $subrooms_list_arr[$value->property_no]['item_size'] ="";
                $subrooms_list_arr[$value->property_no]['uom'] ="";
                $subrooms_list_arr[$value->property_no]['system_no'] ="";
                $subrooms_list_arr[$value->property_no]['details_id'] =$value->id;

                foreach ($storage_type_arr as $key => $val) {

                    $storage_type_total_arr[$value->property_no][$key]=0;
                }

                $storage_type_total_arr[$value->property_no]['total']=0;
                $storage_type_total_arr[$value->property_no]['total_size']=0;
                $storege_locker+=$value->item_qty;
                if($value->item_qty>1)
                {
                    for($i=1;$i<=$value->item_qty;$i++)
                    {
                        $subrooms_list_arr[$value->property_no][$sl]['item_name']     =$value->item_name."-".str_pad($i,4,"0",STR_PAD_LEFT);
                        $subrooms_list_arr[$value->property_no][$sl]['item_id']       =$value->item_id;
                        $subrooms_list_arr[$value->property_no][$sl]['id']            ="";
                        $subrooms_list_arr[$value->property_no][$sl]['details_id']    =$value->id;
                        $subrooms_list_arr[$value->property_no][$sl]['item_size']     ="";
                        $subrooms_list_arr[$value->property_no][$sl]['system_no']     ="";
                        $subrooms_list_arr[$value->property_no][$sl]['property_name'] ="";
                        $subrooms_list_arr[$value->property_no][$sl]['disable']       =false;
                        $subrooms_list_arr[$value->property_no][$sl]['uom']           =1;
                        foreach ($storage_type_arr as $key => $val) {

                            $storage_type_index="storage_type_".$key;
                            $subrooms_list_arr[$value->property_no][$sl][$storage_type_index]=false;
                            
                        }
                        foreach ($stall_closest_item_arr as $key => $val) {

                            $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['value']      =$val;
                            $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['status']     =false;
                            $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['comments']   ="";
                            $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['id']         ="";
                            
                        }
                        $sl++;
                    }
                   
                }
                else 
                {
                    $subrooms_list_arr[$value->property_no][$sl]['item_name']     =$value->item_name;
                    $subrooms_list_arr[$value->property_no][$sl]['item_id']       =$value->item_id;
                    $subrooms_list_arr[$value->property_no][$sl]['id']            ="";
                    $subrooms_list_arr[$value->property_no][$sl]['system_no']     ="";
                    $subrooms_list_arr[$value->property_no][$sl]['property_name'] ="";
                    $subrooms_list_arr[$value->property_no][$sl]['details_id']    =$value->id;
                    $subrooms_list_arr[$value->property_no][$sl]['item_size']     ="";
                    $subrooms_list_arr[$value->property_no][$sl]['disable']       =false;
                    $subrooms_list_arr[$value->property_no][$sl]['uom']           =1;
                    
                    foreach ($storage_type_arr as $key => $val) {

                        $storage_type_index="storage_type_".$key;
                        $subrooms_list_arr[$value->property_no][$sl][$storage_type_index]=false;

                    }

                    foreach ($stall_closest_item_arr as $key => $val) {

                        $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['value']      =$val;
                        $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['status']     =false;
                        $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['comments']   ="";
                        $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['id']         ="";
                        
                    }
                    
                    $sl++;
                }
            }
 
            foreach ($storage_type_arr as $key => $val) {
                $storage_lot_total_arr[$key]=0;
            }
            $storage_lot_total_arr["total"]=0;

            $data['subrooms_list_arr']          =$subrooms_list_arr;

            $data['storege_locker']              =$storege_locker;
            $data['storege_level']              =$storege_level;
            $data['storage_type_arr']             =$storage_type_arr;
            $data['storage_lot_total_arr']      =$storage_lot_total_arr;
            $data['storage_type_total_arr']       =$storage_type_total_arr;
            $data['storage_type_arr_length']      =count($storage_type_arr);
            $data['success']                    =1;
            return $data;

        }
        else{
            $data['success']                    =100;
            return $data;
        }   


    }



    public function StorageLotsList(Request $request)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }


        $building_list              =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_name',$company_id)
                                    ->get(['id','building_no','building_name']);

        //===================Building==========================================

        $building_arr=array();
        foreach ($building_list as $key => $value) {
            $building_arr[$value->id]=$value->building_no;
        }

        //===================Floor==========================================

        $floor_list              =Floor::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_name',$company_id)
                                    ->get(['id','system_no']);


        $floor_arr=array();
        foreach ($floor_list as $key => $value) {
            $floor_arr[$value->id]=$value->system_no;
        }



        $sl=0;
        $storage_lot_list=StorageLot::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_name',$company_id)
                                        ->get();
        foreach ($storage_lot_list as $key => $value) {

            $data['storage_lot_list'][$key]['sl']                  =$sl+1;
            $data['storage_lot_list'][$key]['id']                  =$value->id;
            $data['storage_lot_list'][$key]['system_no']           =$value->system_no;
            $data['storage_lot_list'][$key]['property_name']       =$value->property_name;
            
            $data['storage_lot_list'][$key]['lot_number']          =$value->lot_number;
            $data['storage_lot_list'][$key]['lot_uom']             =$value->lot_uom;

            $data['storage_lot_list'][$key]['storage_lot_size_qty']   =$value->storage_lot_size_qty;
         

            
            if($value->building_name>0)
            {
                $data['storage_lot_list'][$key]['building_name']     =$building_arr[$value->building_name];

            }
            else
            {
                $data['storage_lot_list'][$key]['building_name']      ="";

            }

            if($value->floor_no>0)
            {
                $data['storage_lot_list'][$key]['floor_no']     =$floor_arr[$value->floor_no];

            }
            else
            {
                $data['storage_lot_list'][$key]['floor_no']      ="";

            }
            
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
            'building_name'     => 'required',
            'floor_no'          => 'required',
            'lot_number'        => 'required',
            'property_name'     => 'required',
            'strata_lot_no'     => 'required',
            
        ]);

        
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id'      =>$user_id]);
        $request->merge(['inserted_by'  =>$user_id]);
        $request->merge(['project_id'   =>$project_id]);
        $request->merge(['company_name' =>$company_id]);

        

        $max_system_data = StorageLot::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from storage_lots 
            where building_name=".$request->input('building_name')."  and project_id=".$project_id." ) 
            and building_name=".$request->input('building_name')."  and project_id=".$project_id)->get(['system_prefix']);
               

        $max_system_level_data = StorageLevel::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from storage_levels 
            where building_name=".$request->input('building_name')."  and project_id=".$project_id." ) 
            and building_name=".$request->input('building_name')."  and project_id=".$project_id)->get(['system_prefix']);       

               

        if(count($max_system_level_data)>0)
        {
            $max_level_system_prefix=$max_system_level_data[0]->system_prefix+1; 
        }
        else
        {
            $max_level_system_prefix=1; 
        }


        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="STGL-".str_pad($max_system_prefix, 2, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $storege_info= StorageLot::create($request->all());


        foreach($request->subrooms_list_arr as $key=>$level)
        {

            $level_system_no="STGLV-".str_pad($max_level_system_prefix, 2, 0, STR_PAD_LEFT);

            $data_storege_lavel_details[]= array(
                'project_id'                    =>$project_id,
                'master_id'                     =>$storege_info->id,
                'details_id'                    =>$level['details_id'],
                'system_prefix'                 =>$max_level_system_prefix,
                'system_no'                     =>$level_system_no,
                'property_name'                 =>$level['property_name'],
                'uom'                           =>$request->single_subroom_uom,
                'item_size'                     =>$level['item_size'],
                'storage_type_1'                =>$request->storage_type_total_arr[$key][1],
                'storage_type_2'                =>$request->storage_type_total_arr[$key][2],
                'storage_type_3'                =>$request->storage_type_total_arr[$key][3],
                'storage_type_4'                =>$request->storage_type_total_arr[$key][4],
                'storage_type_5'                =>$request->storage_type_total_arr[$key][5],
                'storage_type_6'                =>$request->storage_type_total_arr[$key][6],
                'storage_type_7'                =>$request->storage_type_total_arr[$key][7],
                'storage_type_8'                =>$request->storage_type_total_arr[$key][8],
                'inserted_by'                   =>$user_id,
            );

            $system_prefix=0; 
            foreach($level as $key2=>$locker_details)
            {
                       
                if($key2>=0 && is_array($locker_details))
                {

                    $system_prefix++;
                    $system_no_locker="STL-".str_pad($max_system_prefix, 2, 0, STR_PAD_LEFT)."-".str_pad($max_level_system_prefix, 2, 0, STR_PAD_LEFT)."-".str_pad($system_prefix, 4, 0, STR_PAD_LEFT);
                   

                   // $item_name=$locker_details['item_name'];

                    $data_subrooms_list_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$storege_info->id,
                        'system_prefix'             =>$system_prefix,
                        'system_no'                 =>$system_no_locker,
                        'item_name'                 =>$locker_details['item_name'],
                        'property_name'             =>$locker_details['property_name'],
                        'item_id'                   =>$locker_details['item_id'],
                        'details_id'                =>$locker_details['details_id'],
                        'uom'                       =>$request->single_subroom_uom,
                        'item_size'                 =>$locker_details['item_size'],
                        'storage_type_1'            =>$locker_details['storage_type_1'],
                        'storage_type_2'            =>$locker_details['storage_type_2'],
                        'storage_type_3'            =>$locker_details['storage_type_3'],
                        'storage_type_4'            =>$locker_details['storage_type_4'],
                        'storage_type_5'            =>$locker_details['storage_type_5'],
                        'storage_type_6'            =>$locker_details['storage_type_6'],
                        'storage_type_7'            =>$locker_details['storage_type_7'],
                        'storage_type_8'            =>$locker_details['storage_type_8'],
                      //  'storage_type_9'            =>$locker_details['storage_type_9'],
                       // 'storage_type_10'           =>$locker_details['storage_type_10'],
                       // 'storage_type_11'           =>$locker_details['storage_type_11'],
                        'inserted_by'               =>$user_id,
                    );

               
                    foreach($locker_details['details'] as $key3=>$locker_extend)
                    {
                        if($locker_extend['status'])
                        {
                            $data_subrooms_locker_details[]= array(
                                'project_id'                =>$project_id,
                                'master_id'                 =>$storege_info->id,
                                'item_id'                   =>$key3,
                                'details_id'                =>$locker_details['details_id'],
                                'system_no'                 =>$system_no_locker,
                                'page_id'                   =>8,
                                'status'                    =>$locker_extend['status'],
                                'comments'                  =>$locker_extend['comments'],
                                'inserted_by'               =>$user_id,
                            );
                        }
                    }
                }

            }
            $max_level_system_prefix++;
                   
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'item_name'                 =>$details['item_name'],
                    'page_id'                   =>8,
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'page_id'                   =>8,
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>8,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'comments'                  =>$details['comments'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'comments'                  =>$details['comments'],
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>8,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'comments'                  =>$details['comments'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'comments'                  =>$details['comments'],
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>8,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'comments'                  =>$details['comments'],
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'comments'                  =>$details['comments'],
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>8,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'comments'                  =>$details['comments'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'comments'                  =>$details['comments'],
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>8,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'comments'                  =>$details['comments'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'comments'                  =>$details['comments'],
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>8,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'comments'                  =>$details['comments'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'comments'                  =>$details['comments'],
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>8,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'comments'                  =>$details['comments'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'comments'                  =>$details['comments'],
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>8,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'comments'                  =>$details['comments'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'comments'                  =>$details['comments'],
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>8,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'comments'                  =>$details['comments'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'comments'                  =>$details['comments'],
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>8,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'comments'                  =>$details['comments'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'comments'                  =>$details['comments'],
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_name'            =>$details['reference_name'],
                    'page_id'                   =>8,
                    'item_id'                   =>$details['item_id'],
                    'name'                      =>$details['name'],
                    'comments'                  =>$details['comments'],
                    'floor_no'                  =>$system_no,
                    'serial_no'                 =>$details['serial_no'],
                    'expiry_date'               =>$expiry_date,
                    'renew_date'                =>$renew_date,
                    'due_on'                    =>$due_on,
                    'cicle'                     =>$details['cicle'],
                    'comments'                  =>$details['comments'],
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
                    'master_id'                 =>$storege_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'item_name'                 =>$details['item_name'],
                    'page_id'                   =>8,
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
                            'master_id'                 =>$storege_info->id,
                            'item_id'                   =>$item_id,
                            'page_id'                   =>8,
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
        $RId7=true;
        $RId8=true;
        $RId9=true;
        $RId10=true;



        if(!empty($data_storege_lavel_details))
        {
            $RId1=StorageLevel::insert($data_storege_lavel_details);
        }
        if(!empty($data_subrooms_list_details))
        {
            $RId2=StorageLocker::insert($data_subrooms_list_details);
        }


        if(!empty($data_subrooms_locker_details))
        {
            $RId8=StorageStallDetails::insert($data_subrooms_locker_details);
        }
        if(!empty($data_licence_permit))
        {
            $RId3=BuildingLicensePermit::insert($data_licence_permit);
        }

        if(!empty($data_building_management_type))
        {
            $RId4=BuildingManagementType::insert($data_building_management_type);
        }
        if(!empty($data_safety_device_equipment))
        {
            $RId5=SafetyDeviceEquipment::insert($data_safety_device_equipment);
        }

        if(!empty($data_external_service_provider))
        {
            $RId6=ExternalServiceProvider::insert($data_external_service_provider);
        }

        if(!empty($data_building_contact))
        {
            $RId7=BuildingContactDetails::insert($data_building_contact);
        }

        if($storege_info  && $RId1 && $RId2 && $RId3 && $RId4 && $RId5 && $RId6 && $RId7 && $RId8)
        {
           DB::commit();
           return "1**$storege_info->id**$system_no";
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
        $data['user_type']          =$user->user_type;
        $ArrayFunction              =new ArrayFunction();
        $storage_type_arr           =$ArrayFunction->storage_type_arr;
        $stall_closest_item_arr     =$ArrayFunction->stall_closest_item_arr;
        //===================Company==========================================
       

        $storage_lot=StorageLot::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$id)
                                    ->first();
        $data['storage_lot_arr']=$storage_lot;                            
        $company_id     =$storage_lot->company_name;
        $building_id    =$storage_lot->building_name;
        $floor_id       =$storage_lot->floor_no;

        

        $building_list        =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_name',$company_id)
                                    ->get(['id','building_no','building_name']);

        

        //===================Building==========================================

        $building_arr=array();
        foreach ($building_list as $key => $value) {
            $building_arr[$value->id]=$value->building_no."-".$value->building_name;
        }

        $data['building_arr']        =$building_arr;


        $floor_list                 =DB::table('floors as mst')
                                        ->join('building_property_details as dtls','mst.floor_no','=','dtls.id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.master_id', '=', $building_id)
                                        ->where('dtls.total_storage_lot', '>', 0)
                                        ->get(['dtls.floor_no','dtls.floor_type','dtls.total_storage_lot','mst.id','mst.floor_name']);
       
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {

            $floor_arr[$value->id]['floor_name']                =$value->floor_name;
            $floor_arr[$value->id]['floor_no']                  =$value->floor_no;
            $floor_arr[$value->id]['floor_type']                =$value->floor_type;
            $floor_arr[$value->id]['total_storage_lot']            =$value->total_storage_lot;

        }


        $data['floor_no_string']    =$floor_arr[$floor_id]['floor_no'];
        $data['floor_type']         =$floor_arr[$floor_id]['floor_type'];
        $data['total_storage_lot']  =$floor_arr[$floor_id]['total_storage_lot'];
        $data['floor_arr']          =$floor_arr;


        $building_info            =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$building_id)
                                    ->get(['dependent_building','independent_building','residential','commercial','residential_commercial']);

        $data['building_info']    =$building_info;


        //================================================================================================================


        $BuildingManagementType=BuildingManagementType::where('status_active',1)
                                    ->where('master_id',$id)
                                    ->where('page_id',8)
                                    ->get();
     

         $ksl=0;
         $property_management_arr_check=array();
        foreach ($BuildingManagementType as  $value) {

            $data['property_management_arr'][$ksl]['id']                    =$value->id;
            $data['property_management_arr'][$ksl]['master_id']             =$value->master_id;
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
                $data['property_management_arr'][$ksl]['master_id']     ="";
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
        


        $licence_and_permit_update=BuildingLicensePermit::where('status_active',1)
                                                        ->where('page_id',8)
                                                        ->where('master_id',$id)
                                                        ->get();

        $license_and_permit_update_arr=array();
        foreach ($licence_and_permit_update as $key => $value) {
            $license_and_permit_update_arr[$value->reference_id]['id']   =$value->id;
            $license_and_permit_update_arr[$value->reference_id]['item_name']      =$value->item_name;
            $license_and_permit_update_arr[$value->reference_id]['issued_by']      =$value->issued_by;
            $license_and_permit_update_arr[$value->reference_id]['expiry_date']    =$value->expiry_date;
            $license_and_permit_update_arr[$value->reference_id]['website']        =$value->website;
            $license_and_permit_update_arr[$value->reference_id]['mobile']         =$value->mobile;
            $license_and_permit_update_arr[$value->reference_id]['phone']          =$value->phone;
            $license_and_permit_update_arr[$value->reference_id]['email']          =$value->email;
            $license_and_permit_update_arr[$value->reference_id]['comment']        =$value->comment;
            $license_and_permit_update_arr[$value->reference_id]['id']             =$value->id;

            $license_and_permit_check_arr[$value->reference_id]=$value->reference_id;
        }
                                                       
        $license_and_permit_list=LicenseAndPermit::where('status_active',1)
                                    ->where('page_id',1)
                                    ->whereIn('project_id',[0,$project_id])
                                    ->get();
        $sl=0;
        $license_and_permit_list_arr=array();
        foreach ($license_and_permit_list as $key => $value) {
            if(in_array($value->id,$license_and_permit_check_arr))
            {
                $license_and_permit_list_arr[$sl]['reference_id']   =$value->id;
                $license_and_permit_list_arr[$sl]['item_name']      =$value->item_name;
                $license_and_permit_list_arr[$sl]['issued_by']      =$license_and_permit_update_arr[$value->id]["issued_by"];
                $license_and_permit_list_arr[$sl]['expiry_date']    =$license_and_permit_update_arr[$value->id]["expiry_date"];
                $license_and_permit_list_arr[$sl]['website']        =$license_and_permit_update_arr[$value->id]["website"];
                $license_and_permit_list_arr[$sl]['mobile']         =$license_and_permit_update_arr[$value->id]["mobile"];
                $license_and_permit_list_arr[$sl]['phone']          =$license_and_permit_update_arr[$value->id]["phone"];
                $license_and_permit_list_arr[$sl]['email']          =$license_and_permit_update_arr[$value->id]["email"];
                $license_and_permit_list_arr[$sl]['comment']        =$license_and_permit_update_arr[$value->id]["comment"];
                $license_and_permit_list_arr[$sl]['id']             =$license_and_permit_update_arr[$value->id]["id"];
            }
            else
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
            }
            $sl++;
        }
        $data['license_and_permit_list_arr']        =$license_and_permit_list_arr;



        //===================================Subrooms Details=======================================================

        $storege_level_details               =StorageLevel::where('status_active',1)
                                            ->where('master_id',$id)
                                            ->get();
        $storege_level_update_arr=array();
        foreach ($storege_level_details as $key => $value) {
            $storege_level_update_arr[$value->details_id]['id']             =$value->id;
            $storege_level_update_arr[$value->details_id]['system_prefix']  =$value->system_prefix;
            $storege_level_update_arr[$value->details_id]['system_no']      =$value->system_no;
            $storege_level_update_arr[$value->details_id]['uom']            =$value->uom;
            $storege_level_update_arr[$value->details_id]['item_size']      =$value->item_size;

            $storege_level_update_arr[$value->details_id]['item_name']      =$value->item_name;
            $storege_level_update_arr[$value->details_id]['property_name']  =$value->property_name;
            $storege_level_update_arr[$value->details_id]['building_name']  =$value->building_name;
            $storege_level_update_arr[$value->details_id]['storage_type_1']   =$value->storage_type_1;
            $storege_level_update_arr[$value->details_id]['storage_type_2']   =$value->storage_type_2;
            $storege_level_update_arr[$value->details_id]['storage_type_3']   =$value->storage_type_3;
            $storege_level_update_arr[$value->details_id]['storage_type_4']   =$value->storage_type_4;
            $storege_level_update_arr[$value->details_id]['storage_type_5']   =$value->storage_type_5;
            $storege_level_update_arr[$value->details_id]['storage_type_6']   =$value->storage_type_6;
            $storege_level_update_arr[$value->details_id]['storage_type_7']   =$value->storage_type_7;
            $storege_level_update_arr[$value->details_id]['storage_type_8']   =$value->storage_type_8;
           // $storege_level_update_arr[$value->details_id]['storage_type_9']   =$value->storage_type_9;
           // $storege_level_update_arr[$value->details_id]['storage_type_10']  =$value->storage_type_10;
          //  $storege_level_update_arr[$value->details_id]['storage_type_11']  =$value->storage_type_11;
           // $storege_level_update_arr[$value->details_id]['storage_type_12']  =$value->storage_type_12;
            $storege_level_check_arr[$value->details_id]=$value->details_id;
        }

        $storege_locker_details               =StorageLocker::where('status_active',1)
                                                ->where('master_id',$id)
                                                ->get();
        $storege_locker_update_arr=array();
        $storege_locker_check_arr=array();
        foreach ($storege_locker_details as $key => $value) {
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['id']             =$value->id;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['system_prefix']  =$value->system_prefix;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['system_no']      =$value->system_no;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['uom']            =$value->uom;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['item_size']      =$value->item_size;

            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['item_name']      =$value->item_name;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['property_name']  =$value->property_name;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['storage_type_1'] =$value->storage_type_1;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['storage_type_2'] =$value->storage_type_2;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['storage_type_3'] =$value->storage_type_3;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['storage_type_4'] =$value->storage_type_4;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['storage_type_5'] =$value->storage_type_5;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['storage_type_6'] =$value->storage_type_6;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['storage_type_7'] =$value->storage_type_7;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['storage_type_8'] =$value->storage_type_8;
            $storege_locker_update_arr[$value->details_id][$value->system_prefix]['storage_type_9'] =$value->storage_type_9;
           
            $storege_locker_check_arr[$value->details_id][$value->system_prefix]=$value->system_prefix;
        }

        $storege_locker_extra_info          =StorageStallDetails::where('status_active',1)
                                            ->where('master_id',$id)
                                            ->where('page_id',8)
                                            ->get();

        $storege_locker_extra_update_arr=array();
        $storege_locker_extra_check_arr=array();
        foreach ($storege_locker_extra_info as $key => $value) {
            $storege_locker_extra_update_arr[$value->system_no][$value->item_id]['id']             =$value->id;
            $storege_locker_extra_update_arr[$value->system_no][$value->item_id]['item_id']        =$value->item_id;
            $storege_locker_extra_update_arr[$value->system_no][$value->item_id]['system_no']      =$value->system_no;
            $storege_locker_extra_update_arr[$value->system_no][$value->item_id]['comments']       =$value->comments;
            $storege_locker_extra_update_arr[$value->system_no][$value->item_id]['status']         =$value->status;
            $storege_locker_extra_check_arr[$value->system_no][$value->item_id]=$value->item_id;
        }
        
        
    
        $subrooms_details               =SubroomsListDetails::where('status_active',1)
                                            ->where('item_type',5)
                                            ->where('master_id',$floor_id)
                                            ->get(['id','item_qty','item_name','item_id','property_no']);


        $subrooms_list_check=array();
        $subrooms_list_arr=array();
        $storage_type_total_arr=array();
        $storage_lot_total_arr=array();
        $sl=0;
        $storege_level=0;
        $storege_locker=0;
        foreach ($storage_type_arr as $key => $val) {
            $storage_lot_total_arr[$key]=0;
        }
        $storage_lot_total_arr["total"]=0;
        foreach ($subrooms_details as $key => $value) {
            $storege_level++;
            if(in_array($value->id,$storege_level_check_arr))
            {
                $subrooms_list_arr[$value->property_no]['id']               =$storege_level_update_arr[$value->id]['id'];
                $subrooms_list_arr[$value->property_no]['property_name']    =$storege_level_update_arr[$value->id]['property_name'];
                $subrooms_list_arr[$value->property_no]['item_size']        =$storege_level_update_arr[$value->id]['item_size'];
                $subrooms_list_arr[$value->property_no]['uom']              =$storege_level_update_arr[$value->id]['uom'];
                $subrooms_list_arr[$value->property_no]['system_no']        =$storege_level_update_arr[$value->id]['system_no'];
                $subrooms_list_arr[$value->property_no]['details_id']       =$value->id;
                $storage_type_total_arr[$value->property_no]['total']=0;
                foreach ($storage_type_arr as $key => $val) {

                    $storage_type_total_arr[$value->property_no][$key]=$storege_level_update_arr[$value->id]["storage_type_".$key];
                    $storage_type_total_arr[$value->property_no]['total']+=$storege_level_update_arr[$value->id]["storage_type_".$key];
                }

                
                $storage_type_total_arr[$value->property_no]['total_size']=0;
                $storege_locker+=$value->item_qty;
                if($value->item_qty>=1)
                {
                    for($i=1;$i<=$value->item_qty;$i++)
                    {
                        if(in_array($i,$storege_locker_check_arr[$value->id]))
                        {
                            $locker_system_no=$storege_locker_update_arr[$value->id][$i]['system_no'];
                            $subrooms_list_arr[$value->property_no][$sl]['item_name']     =$value->item_name."-".str_pad($i,4,"0",STR_PAD_LEFT);
                            $subrooms_list_arr[$value->property_no][$sl]['item_id']       =$value->item_id;
                            $subrooms_list_arr[$value->property_no][$sl]['id']            =$storege_locker_update_arr[$value->id][$i]['id'];
                            $subrooms_list_arr[$value->property_no][$sl]['details_id']    =$value->id;
                            $subrooms_list_arr[$value->property_no][$sl]['item_size']     =$storege_locker_update_arr[$value->id][$i]['item_size'];
                            $subrooms_list_arr[$value->property_no][$sl]['system_no']     =$locker_system_no;
                            $subrooms_list_arr[$value->property_no][$sl]['property_name'] =$storege_locker_update_arr[$value->id][$i]['property_name'];
                            $subrooms_list_arr[$value->property_no][$sl]['disable']       =false;
                            $subrooms_list_arr[$value->property_no][$sl]['uom']           =$storege_locker_update_arr[$value->id][$i]['uom'];
                            foreach ($storage_type_arr as $key => $val) {

                                $storage_type_index="storage_type_".$key;
                                // dd($storege_locker_update_arr[$value->id][$i][$storage_type_index]);
                                if($storege_locker_update_arr[$value->id][$i][$storage_type_index]==1)
                                {
                                   
                                    $storage_lot_total_arr[$key]+=1;
                                    $storage_lot_total_arr["total"]+=1;
                                }
                                 $subrooms_list_arr[$value->property_no][$sl][$storage_type_index]=$storege_locker_update_arr[$value->id][$i][$storage_type_index];
                            }


                            foreach ($stall_closest_item_arr as $key => $val) {
                                if(!empty($storege_locker_extra_check_arr[$locker_system_no]))
                                {
                                    if(in_array($key,$storege_locker_extra_check_arr[$locker_system_no]))
                                    {
                                        $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['value']      =$val;
                                        $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['status']     =$storege_locker_extra_update_arr[$locker_system_no][$key]['status'] ;
                                        $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['comments']   =$storege_locker_extra_update_arr[$locker_system_no][$key]['comments'] ;
                                        $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['id']         =$storege_locker_extra_update_arr[$locker_system_no][$key]['id'] ;
                                    }
                                    else
                                    {
                                        $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['value']      =$val;
                                        $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['status']     =false;
                                        $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['comments']   ="";
                                        $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['id']         ="";
                                    }   
                                }
                                else
                                {
                                    $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['value']      =$val;
                                    $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['status']     =false;
                                    $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['comments']   ="";
                                    $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['id']         ="";
                                }
                                
                                
                            }
                        }
                        else
                        {
                            $subrooms_list_arr[$value->property_no][$sl]['item_name']     =$value->item_name."-".str_pad($i,4,"0",STR_PAD_LEFT);
                            $subrooms_list_arr[$value->property_no][$sl]['item_id']       =$value->item_id;
                            $subrooms_list_arr[$value->property_no][$sl]['id']            ="";
                            $subrooms_list_arr[$value->property_no][$sl]['details_id']    =$value->id;
                            $subrooms_list_arr[$value->property_no][$sl]['item_size']     ="";
                            $subrooms_list_arr[$value->property_no][$sl]['system_no']     ="";
                            $subrooms_list_arr[$value->property_no][$sl]['property_name'] ="";
                            $subrooms_list_arr[$value->property_no][$sl]['disable']       =false;
                            $subrooms_list_arr[$value->property_no][$sl]['uom']           =1;
                            foreach ($storage_type_arr as $key => $val) {

                                $storage_type_index="storage_type_".$key;
                                $subrooms_list_arr[$value->property_no][$sl][$storage_type_index]=false;
                                
                            }
                            foreach ($stall_closest_item_arr as $key => $val) {

                                $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['value']      =$val;
                                $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['status']     =false;
                                $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['comments']   ="";
                                $subrooms_list_arr[$value->property_no][$sl]['details'][$key]['id']         ="";
                                
                            }
                        }
                       
                        $sl++;
                    }
                   
                }
            }
            
           
           
        }

        
        

        $data['subrooms_list_arr']          =$subrooms_list_arr;

        $data['storege_locker']             =$storege_locker;
        $data['storege_level']              =$storege_level;
        $data['storage_type_arr']           =$storage_type_arr;
        $data['storage_lot_total_arr']      =$storage_lot_total_arr;
        $data['storage_type_total_arr']     =$storage_type_total_arr;
        $data['storage_type_arr_length']    =count($storage_type_arr);
        $data['success']                    =1;

        $safety_device_equipment=SafetyDeviceEquipment::where('status_active',1)
                                                    ->where('page_id',8)
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
                                                        ->where('page_id',8)
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
                                                        ->where('page_id',8)
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
            'building_name'     => 'required',
            'floor_no'          => 'required',
            'lot_number'        => 'required',
            'property_name'     => 'required',
            'strata_lot_no'     => 'required',
            
        ]);
        
        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['updated_by'       =>$user_id]);

        $max_system_level_data = StorageLevel::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from storage_levels 
            where building_name=".$request->input('building_name')."  and project_id=".$project_id." ) 
            and building_name=".$request->input('building_name')."  and project_id=".$project_id)->get(['system_prefix']);

        if(count($max_system_level_data)>0)
        {
            $max_level_system_prefix=$max_system_level_data[0]->system_prefix+1; 
        }
        else
        {
            $max_level_system_prefix=1; 
        }


        $storege_locker_max_prefix = StorageLocker::where('project_id', '=', $project_id)
                                    ->where('master_id', '=', $id)
                                    ->where('status_active', '=', 1)
                                    ->select('details_id',DB::raw('MAX(system_prefix) as system_prefix'))
                                    ->groupBy('details_id')
                                    //->toSql();
                                    ->get();
        //echo $storege_locker_max_prefix;die;
        $storege_locker_max_prefix_arr=array();
        foreach ($storege_locker_max_prefix as $key => $value) {
            $storege_locker_max_prefix_arr[$value->details_id]=$value->system_prefix;
        } 
       // dd($storege_locker_max_prefix_arr);die;
        DB::beginTransaction();      
       
        $storage_lot_update= StorageLot::find($id)->update($request->all());;
        $max_system_prefix=$request->input('system_prefix');
        foreach($request->subrooms_list_arr as $key=>$level)
        {

            if($level['id'])
            {
                $storege_lavel_details_data= array(
                    'property_name'                 =>$level['property_name'],
                    'uom'                           =>$request->single_subroom_uom,
                    'item_size'                     =>$level['item_size'],
                    'storage_type_1'                =>$request->storage_type_total_arr[$key][1],
                    'storage_type_2'                =>$request->storage_type_total_arr[$key][2],
                    'storage_type_3'                =>$request->storage_type_total_arr[$key][3],
                    'storage_type_4'                =>$request->storage_type_total_arr[$key][4],
                    'storage_type_5'                =>$request->storage_type_total_arr[$key][5],
                    'storage_type_6'                =>$request->storage_type_total_arr[$key][6],
                    'storage_type_7'                =>$request->storage_type_total_arr[$key][7],
                    'storage_type_8'                =>$request->storage_type_total_arr[$key][8],
                    'updated_by'                    =>$user_id,
                );
                
                $system_prefix=$storege_locker_max_prefix_arr[$level['details_id']]; 
                foreach($level as $key2=>$locker_details)
                {
                           
                    if($key2>=0 && is_array($locker_details))
                    {
                        if($locker_details['id'])
                        {
                            $subrooms_list_details_data= array(
                                'item_name'                 =>$locker_details['item_name'],
                                'property_name'             =>$locker_details['property_name'],
                                'item_id'                   =>$locker_details['item_id'],
                                'uom'                       =>$request->single_subroom_uom,
                                'item_size'                 =>$locker_details['item_size'],
                                'storage_type_1'              =>$locker_details['storage_type_1'],
                                'storage_type_2'              =>$locker_details['storage_type_2'],
                                'storage_type_3'              =>$locker_details['storage_type_3'],
                                'storage_type_4'              =>$locker_details['storage_type_4'],
                                'storage_type_5'              =>$locker_details['storage_type_5'],
                                'storage_type_6'              =>$locker_details['storage_type_6'],
                                'storage_type_7'              =>$locker_details['storage_type_7'],
                                'storage_type_8'              =>$locker_details['storage_type_8'],
                          
                                'updated_by'                =>$user_id,
                            );

                            $storege_locker_update=StorageLocker::where('id',"=",$locker_details['id'])->update($subrooms_list_details_data);
                            if( !$storege_locker_update)
                            {
                                DB::rollBack();
                                return 10;
                                die;
                            }
                            //==============================update=========================================
                            foreach($locker_details['details'] as $key3=>$locker_extend)
                            {
                                if($locker_extend['id'])
                                {
                                    $data_subrooms_locker_details_update= array(
                                                'project_id'                =>$project_id,
                                                'master_id'                 =>$id,
                                                'item_id'                   =>$key3,
                                                'details_id'                =>$locker_details['details_id'],
                                                'system_no'                 =>$locker_details['system_no'],
                                                'page_id'                   =>8,
                                                'status'                    =>$locker_extend['status'],
                                                'comments'                  =>$locker_extend['comments'],
                                                'inserted_by'               =>$user_id,
                                            );

                                    $storege_locker_details_update=StorageStallDetails::where('id',"=",$locker_extend['id'])->update($data_subrooms_locker_details_update);
                                    if( !$storege_locker_details_update)
                                    {
                                        DB::rollBack();
                                        return 10;
                                        die;
                                    }
                                }
                                else
                                {
                                    if($locker_extend['status'])
                                    {
                                        $data_subrooms_locker_details[]= array(
                                            'project_id'                =>$project_id,
                                            'master_id'                 =>$id,
                                            'item_id'                   =>$key3,
                                            'details_id'                =>$locker_details['details_id'],
                                            'system_no'                 =>$locker_details['system_no'],
                                            'page_id'                   =>8,
                                            'status'                    =>$locker_extend['status'],
                                            'comments'                  =>$locker_extend['comments'],
                                            'inserted_by'               =>$user_id,
                                        );
                                    }
                                }
                            }

                        }
                        else
                        {
                            $system_prefix++;
                            $system_no_locker="BKS-".str_pad($max_system_prefix, 2, 0, STR_PAD_LEFT)."-".str_pad($max_level_system_prefix, 2, 0, STR_PAD_LEFT)."-".str_pad($system_prefix, 4, 0, STR_PAD_LEFT);
                           
                            $data_subrooms_list_details[]= array(
                                'project_id'                =>$project_id,
                                'master_id'                 =>$id,
                                'system_prefix'             =>$system_prefix,
                                'system_no'                 =>$system_no_locker,
                                'item_name'                 =>$locker_details['item_name'],
                                'property_name'             =>$locker_details['property_name'],
                                'item_id'                   =>$locker_details['item_id'],
                                'details_id'                =>$locker_details['details_id'],
                                'uom'                       =>$request->single_subroom_uom,
                                'item_size'                 =>$locker_details['item_size'],
                                'storage_type_1'            =>$locker_details['storage_type_1'],
                                'storage_type_2'            =>$locker_details['storage_type_2'],
                                'storage_type_3'            =>$locker_details['storage_type_3'],
                                'storage_type_4'            =>$locker_details['storage_type_4'],
                                'storage_type_5'            =>$locker_details['storage_type_5'],
                                'storage_type_6'            =>$locker_details['storage_type_6'],
                                'storage_type_7'            =>$locker_details['storage_type_7'],
                                'storage_type_8'            =>$locker_details['storage_type_8'],
                              //  'storage_type_9'            =>$locker_details['storage_type_9'],
                               // 'storage_type_10'           =>$locker_details['storage_type_10'],
                              //  'storage_type_11'           =>$locker_details['storage_type_11'],
                                'inserted_by'               =>$user_id,
                            );

                            foreach($locker_details['details'] as $key3=>$locker_extend)
                            {
                                if($locker_extend['status'])
                                {
                                    $data_subrooms_locker_details[]= array(
                                        'project_id'                =>$project_id,
                                        'master_id'                 =>$id,
                                        'item_id'                   =>$key3,
                                        'details_id'                =>$locker_details['details_id'],
                                        'system_no'                 =>$system_no_locker,
                                        'page_id'                   =>8,
                                        'status'                    =>$locker_extend['status'],
                                        'comments'                  =>$locker_extend['comments'],
                                        'inserted_by'               =>$user_id,
                                    );
                                }
                            }

                        }
                        
                    }

                }
                

                $storege_lavel_update=StorageLevel::where('id',"=",$level['id'])->update($storege_lavel_details_data);
                if( !$storege_lavel_update)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
                
            }
            else
            {
                $level_system_no="BIKLV-".str_pad($max_level_system_prefix, 2, 0, STR_PAD_LEFT);

                $data_storege_lavel_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$id,
                    'details_id'                =>$level['details_id'],
                    'system_prefix'             =>$max_level_system_prefix,
                    'system_no'                 =>$level_system_no,
                    'property_name'             =>$level['property_name'],
                    'uom'                       =>$request->single_subroom_uom,
                    'item_size'                 =>$level['item_size'],
                    'storage_type_1'              =>$request->storage_type_total_arr[$key][1],
                    'storage_type_2'              =>$request->storage_type_total_arr[$key][2],
                    'storage_type_3'              =>$request->storage_type_total_arr[$key][3],
                    'storage_type_4'              =>$request->storage_type_total_arr[$key][4],
                    'storage_type_5'              =>$request->storage_type_total_arr[$key][5],
                    'storage_type_6'              =>$request->storage_type_total_arr[$key][6],
                    'storage_type_7'              =>$request->storage_type_total_arr[$key][7],
                    'storage_type_8'              =>$request->storage_type_total_arr[$key][8],
                   // 'storage_type_9'              =>$request->storage_type_total_arr[$key][9],
                   // 'storage_type_10'             =>$request->storage_type_total_arr[$key][10],
                   // 'storage_type_11'             =>$request->storage_type_total_arr[$key][11],
                    'inserted_by'               =>$user_id,
                );
                $system_prefix=0; 
                foreach($level as $key2=>$locker_details)
                {
                           
                    if($key2>=0 && is_array($locker_details))
                    {

                        $system_prefix++;
                        $system_no_locker="BKS-".str_pad($max_system_prefix, 2, 0, STR_PAD_LEFT)."-".str_pad($max_level_system_prefix, 2, 0, STR_PAD_LEFT)."-".str_pad($system_prefix, 4, 0, STR_PAD_LEFT);
                       

                       // $item_name=$locker_details['item_name'];

                        $data_subrooms_list_details[]= array(
                            'project_id'                =>$project_id,
                            'master_id'                 =>$id,
                            'system_prefix'             =>$system_prefix,
                            'system_no'                 =>$system_no_locker,
                            'item_name'                 =>$locker_details['item_name'],
                            'property_name'             =>$locker_details['property_name'],
                            'item_id'                   =>$locker_details['item_id'],
                            'details_id'                =>$locker_details['details_id'],
                            'uom'                       =>$request->single_subroom_uom,
                            'item_size'                 =>$locker_details['item_size'],
                            'storage_type_1'            =>$locker_details['storage_type_1'],
                            'storage_type_2'            =>$locker_details['storage_type_2'],
                            'storage_type_3'            =>$locker_details['storage_type_3'],
                            'storage_type_4'            =>$locker_details['storage_type_4'],
                            'storage_type_5'            =>$locker_details['storage_type_5'],
                            'storage_type_6'            =>$locker_details['storage_type_6'],
                            'storage_type_7'            =>$locker_details['storage_type_7'],
                            'storage_type_8'            =>$locker_details['storage_type_8'],
                          //  'storage_type_9'            =>$locker_details['storage_type_9'],
                          //  'storage_type_10'           =>$locker_details['storage_type_10'],
                          //  'storage_type_11'           =>$locker_details['storage_type_11'],
                            'inserted_by'               =>$user_id,
                        );

                        foreach($locker_details['details'] as $key3=>$locker_extend)
                        {
                            if($locker_extend['status'])
                            {
                                $data_subrooms_locker_details[]= array(
                                    'project_id'                =>$project_id,
                                    'master_id'                 =>$id,
                                    'item_id'                   =>$key3,
                                    'details_id'                =>$locker_details['details_id'],
                                    'system_no'                 =>$system_no_locker,
                                    'page_id'                   =>8,
                                    'status'                    =>$locker_extend['status'],
                                    'comments'                  =>$locker_extend['comments'],
                                    'inserted_by'               =>$user_id,
                                );
                            }
                        }
                    }

                }
                $max_level_system_prefix++;
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
                        'page_id'                   =>8,
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
                        'page_id'                   =>8,
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'page_id'                   =>8,
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
                            $building_contact=BuildingContactDetails::where('id',"=",$details['id'])->update($building_contact_data);
                            if( !$building_contact)
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
                                'page_id'                   =>8,
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
        $RId7=true;
        $RId8=true;

        if(!empty($data_storege_lavel_details))
        {
            $RId1=StorageLevel::insert($data_storege_lavel_details);
        }
        if(!empty($data_subrooms_list_details))
        {
            $RId2=StorageLocker::insert($data_subrooms_list_details);
        }
        if(!empty($data_subrooms_locker_details))
        {
            $RId8=StorageStallDetails::insert($data_subrooms_locker_details);
        }
        if(!empty($data_licence_permit))
        {
            $RId3=BuildingLicensePermit::insert($data_licence_permit);
        }

        if(!empty($data_building_management_type))
        {
            $RId4=BuildingManagementType::insert($data_building_management_type);
        }


        if(!empty($data_safety_device_equipment))
        {
            $RId5=SafetyDeviceEquipment::insert($data_safety_device_equipment);
        }

        if(!empty($data_external_service_provider))
        {
            $RId6=ExternalServiceProvider::insert($data_external_service_provider);
        }

        if(!empty($data_building_contact))
        {
            $RId7=BuildingContactDetails::insert($data_building_contact);
        }



        if($storage_lot_update  && $RId1 && $RId2 && $RId3 && $RId4 && $RId5 && $RId6 && $RId7 && $RId8)
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
        }
        else {

            return "10**200"; 
        }

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>$request->input("posting_status"),
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=StorageLot::where('id',"=",$id)->update($update_data);

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
            'building_name'     => 'required',
            'floor_no'          => 'required',
            'lot_number'        => 'required',
            'property_name'     => 'required',
            'strata_lot_no'     => 'required',
            
        ]);
        
        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->merge(['project_id'           =>$project_id]);
        $request->merge(['updated_by'           =>$user_id]);
        $request->merge(['posting_status'       =>3]);

        $max_system_level_data = StorageLevel::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from storage_levels 
            where building_name=".$request->input('building_name')."  and project_id=".$project_id." ) 
            and building_name=".$request->input('building_name')."  and project_id=".$project_id)->get(['system_prefix']);

        if(count($max_system_level_data)>0)
        {
            $max_level_system_prefix=$max_system_level_data[0]->system_prefix+1; 
        }
        else
        {
            $max_level_system_prefix=1; 
        }


        $storege_locker_max_prefix = StorageLocker::where('project_id', '=', $project_id)
                                    ->where('master_id', '=', $id)
                                    ->where('status_active', '=', 1)
                                    ->select('details_id',DB::raw('MAX(system_prefix) as system_prefix'))
                                    ->groupBy('details_id')
                                    //->toSql();
                                    ->get();

        $storege_locker_max_prefix_arr=array();
        foreach ($storege_locker_max_prefix as $key => $value) {
            $storege_locker_max_prefix_arr[$value->details_id]=$value->system_prefix;
        } 

        DB::beginTransaction();      
       
        $storage_lot_update= StorageLot::find($id)->update($request->all());;
        $max_system_prefix=$request->input('system_prefix');
        foreach($request->subrooms_list_arr as $key=>$level)
        {

            if($level['id'])
            {
                $storege_lavel_details_data= array(
                    'property_name'                 =>$level['property_name'],
                    'uom'                           =>$request->single_subroom_uom,
                    'item_size'                     =>$level['item_size'],
                    'storage_type_1'                =>$request->storage_type_total_arr[$key][1],
                    'storage_type_2'                =>$request->storage_type_total_arr[$key][2],
                    'storage_type_3'                =>$request->storage_type_total_arr[$key][3],
                    'storage_type_4'                =>$request->storage_type_total_arr[$key][4],
                    'storage_type_5'                =>$request->storage_type_total_arr[$key][5],
                    'storage_type_6'                =>$request->storage_type_total_arr[$key][6],
                    'storage_type_7'                =>$request->storage_type_total_arr[$key][7],
                    'storage_type_8'                =>$request->storage_type_total_arr[$key][8],
                    'updated_by'                    =>$user_id,
                );
                
                $system_prefix=$storege_locker_max_prefix_arr[$level['details_id']]; 
                foreach($level as $key2=>$locker_details)
                {
                           
                    if($key2>=0 && is_array($locker_details))
                    {
                        if($locker_details['id'])
                        {
                            $subrooms_list_details_data= array(
                                'item_name'                 =>$locker_details['item_name'],
                                'property_name'             =>$locker_details['property_name'],
                                'item_id'                   =>$locker_details['item_id'],
                                'uom'                       =>$request->single_subroom_uom,
                                'item_size'                 =>$locker_details['item_size'],
                                'storage_type_1'              =>$locker_details['storage_type_1'],
                                'storage_type_2'              =>$locker_details['storage_type_2'],
                                'storage_type_3'              =>$locker_details['storage_type_3'],
                                'storage_type_4'              =>$locker_details['storage_type_4'],
                                'storage_type_5'              =>$locker_details['storage_type_5'],
                                'storage_type_6'              =>$locker_details['storage_type_6'],
                                'storage_type_7'              =>$locker_details['storage_type_7'],
                                'storage_type_8'              =>$locker_details['storage_type_8'],
                          
                                'updated_by'                =>$user_id,
                            );

                            $storege_locker_update=StorageLocker::where('id',"=",$locker_details['id'])->update($subrooms_list_details_data);
                            if( !$storege_locker_update)
                            {
                                DB::rollBack();
                                return 10;
                                die;
                            }
                            //==============================update=========================================
                            foreach($locker_details['details'] as $key3=>$locker_extend)
                            {
                                if($locker_extend['id'])
                                {
                                    $data_subrooms_locker_details_update= array(
                                                'project_id'                =>$project_id,
                                                'master_id'                 =>$id,
                                                'item_id'                   =>$key3,
                                                'details_id'                =>$locker_details['details_id'],
                                                'system_no'                 =>$locker_details['system_no'],
                                                'page_id'                   =>8,
                                                'status'                    =>$locker_extend['status'],
                                                'comments'                  =>$locker_extend['comments'],
                                                'inserted_by'               =>$user_id,
                                            );

                                    $storege_locker_details_update=StorageStallDetails::where('id',"=",$locker_extend['id'])->update($data_subrooms_locker_details_update);
                                    if( !$storege_locker_details_update)
                                    {
                                        DB::rollBack();
                                        return 10;
                                        die;
                                    }
                                }
                                else
                                {
                                    if($locker_extend['status'])
                                    {
                                        $data_subrooms_locker_details[]= array(
                                            'project_id'                =>$project_id,
                                            'master_id'                 =>$id,
                                            'item_id'                   =>$key3,
                                            'details_id'                =>$locker_details['details_id'],
                                            'system_no'                 =>$locker_details['system_no'],
                                            'page_id'                   =>8,
                                            'status'                    =>$locker_extend['status'],
                                            'comments'                  =>$locker_extend['comments'],
                                            'inserted_by'               =>$user_id,
                                        );
                                    }
                                }
                            }

                        }
                        else
                        {
                            $system_prefix++;
                            $system_no_locker="BKS-".str_pad($max_system_prefix, 2, 0, STR_PAD_LEFT)."-".str_pad($max_level_system_prefix, 2, 0, STR_PAD_LEFT)."-".str_pad($system_prefix, 4, 0, STR_PAD_LEFT);
                           
                            $data_subrooms_list_details[]= array(
                                'project_id'                =>$project_id,
                                'master_id'                 =>$id,
                                'system_prefix'             =>$system_prefix,
                                'system_no'                 =>$system_no_locker,
                                'item_name'                 =>$locker_details['item_name'],
                                'property_name'             =>$locker_details['property_name'],
                                'item_id'                   =>$locker_details['item_id'],
                                'details_id'                =>$locker_details['details_id'],
                                'uom'                       =>$request->single_subroom_uom,
                                'item_size'                 =>$locker_details['item_size'],
                                'storage_type_1'            =>$locker_details['storage_type_1'],
                                'storage_type_2'            =>$locker_details['storage_type_2'],
                                'storage_type_3'            =>$locker_details['storage_type_3'],
                                'storage_type_4'            =>$locker_details['storage_type_4'],
                                'storage_type_5'            =>$locker_details['storage_type_5'],
                                'storage_type_6'            =>$locker_details['storage_type_6'],
                                'storage_type_7'            =>$locker_details['storage_type_7'],
                                'storage_type_8'            =>$locker_details['storage_type_8'],
                              //  'storage_type_9'            =>$locker_details['storage_type_9'],
                               // 'storage_type_10'           =>$locker_details['storage_type_10'],
                              //  'storage_type_11'           =>$locker_details['storage_type_11'],
                                'inserted_by'               =>$user_id,
                            );

                            foreach($locker_details['details'] as $key3=>$locker_extend)
                            {
                                if($locker_extend['status'])
                                {
                                    $data_subrooms_locker_details[]= array(
                                        'project_id'                =>$project_id,
                                        'master_id'                 =>$id,
                                        'item_id'                   =>$key3,
                                        'details_id'                =>$locker_details['details_id'],
                                        'system_no'                 =>$system_no_locker,
                                        'page_id'                   =>8,
                                        'status'                    =>$locker_extend['status'],
                                        'comments'                  =>$locker_extend['comments'],
                                        'inserted_by'               =>$user_id,
                                    );
                                }
                            }

                        }
                        
                    }

                }
                

                $storege_lavel_update=StorageLevel::where('id',"=",$level['id'])->update($storege_lavel_details_data);
                if( !$storege_lavel_update)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
                
            }
            else
            {
                $level_system_no="BIKLV-".str_pad($max_level_system_prefix, 2, 0, STR_PAD_LEFT);

                $data_storege_lavel_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$id,
                    'details_id'                =>$level['details_id'],
                    'system_prefix'             =>$max_level_system_prefix,
                    'system_no'                 =>$level_system_no,
                    'property_name'             =>$level['property_name'],
                    'uom'                       =>$request->single_subroom_uom,
                    'item_size'                 =>$level['item_size'],
                    'storage_type_1'              =>$request->storage_type_total_arr[$key][1],
                    'storage_type_2'              =>$request->storage_type_total_arr[$key][2],
                    'storage_type_3'              =>$request->storage_type_total_arr[$key][3],
                    'storage_type_4'              =>$request->storage_type_total_arr[$key][4],
                    'storage_type_5'              =>$request->storage_type_total_arr[$key][5],
                    'storage_type_6'              =>$request->storage_type_total_arr[$key][6],
                    'storage_type_7'              =>$request->storage_type_total_arr[$key][7],
                    'storage_type_8'              =>$request->storage_type_total_arr[$key][8],
                   // 'storage_type_9'              =>$request->storage_type_total_arr[$key][9],
                   // 'storage_type_10'             =>$request->storage_type_total_arr[$key][10],
                   // 'storage_type_11'             =>$request->storage_type_total_arr[$key][11],
                    'inserted_by'               =>$user_id,
                );
                $system_prefix=0; 
                foreach($level as $key2=>$locker_details)
                {
                           
                    if($key2>=0 && is_array($locker_details))
                    {

                        $system_prefix++;
                        $system_no_locker="BKS-".str_pad($max_system_prefix, 2, 0, STR_PAD_LEFT)."-".str_pad($max_level_system_prefix, 2, 0, STR_PAD_LEFT)."-".str_pad($system_prefix, 4, 0, STR_PAD_LEFT);
                       

                       // $item_name=$locker_details['item_name'];

                        $data_subrooms_list_details[]= array(
                            'project_id'                =>$project_id,
                            'master_id'                 =>$id,
                            'system_prefix'             =>$system_prefix,
                            'system_no'                 =>$system_no_locker,
                            'item_name'                 =>$locker_details['item_name'],
                            'property_name'             =>$locker_details['property_name'],
                            'item_id'                   =>$locker_details['item_id'],
                            'details_id'                =>$locker_details['details_id'],
                            'uom'                       =>$request->single_subroom_uom,
                            'item_size'                 =>$locker_details['item_size'],
                            'storage_type_1'            =>$locker_details['storage_type_1'],
                            'storage_type_2'            =>$locker_details['storage_type_2'],
                            'storage_type_3'            =>$locker_details['storage_type_3'],
                            'storage_type_4'            =>$locker_details['storage_type_4'],
                            'storage_type_5'            =>$locker_details['storage_type_5'],
                            'storage_type_6'            =>$locker_details['storage_type_6'],
                            'storage_type_7'            =>$locker_details['storage_type_7'],
                            'storage_type_8'            =>$locker_details['storage_type_8'],
                          //  'storage_type_9'            =>$locker_details['storage_type_9'],
                          //  'storage_type_10'           =>$locker_details['storage_type_10'],
                          //  'storage_type_11'           =>$locker_details['storage_type_11'],
                            'inserted_by'               =>$user_id,
                        );

                        foreach($locker_details['details'] as $key3=>$locker_extend)
                        {
                            if($locker_extend['status'])
                            {
                                $data_subrooms_locker_details[]= array(
                                    'project_id'                =>$project_id,
                                    'master_id'                 =>$id,
                                    'item_id'                   =>$key3,
                                    'details_id'                =>$locker_details['details_id'],
                                    'system_no'                 =>$system_no_locker,
                                    'page_id'                   =>8,
                                    'status'                    =>$locker_extend['status'],
                                    'comments'                  =>$locker_extend['comments'],
                                    'inserted_by'               =>$user_id,
                                );
                            }
                        }
                    }

                }
                $max_level_system_prefix++;
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
                        'page_id'                   =>8,
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
                        'page_id'                   =>8,
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'comments'                  =>$details['comments'],
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
                        'page_id'                   =>8,
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
                            $building_contact=BuildingContactDetails::where('id',"=",$details['id'])->update($building_contact_data);
                            if( !$building_contact)
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
                                'page_id'                   =>8,
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
        $RId7=true;
        $RId8=true;

        if(!empty($data_storege_lavel_details))
        {
            $RId1=StorageLevel::insert($data_storege_lavel_details);
        }
        if(!empty($data_subrooms_list_details))
        {
            $RId2=StorageLocker::insert($data_subrooms_list_details);
        }
        if(!empty($data_subrooms_locker_details))
        {
            $RId8=StorageStallDetails::insert($data_subrooms_locker_details);
        }
        if(!empty($data_licence_permit))
        {
            $RId3=BuildingLicensePermit::insert($data_licence_permit);
        }

        if(!empty($data_building_management_type))
        {
            $RId4=BuildingManagementType::insert($data_building_management_type);
        }


        if(!empty($data_safety_device_equipment))
        {
            $RId5=SafetyDeviceEquipment::insert($data_safety_device_equipment);
        }

        if(!empty($data_external_service_provider))
        {
            $RId6=ExternalServiceProvider::insert($data_external_service_provider);
        }

        if(!empty($data_building_contact))
        {
            $RId7=BuildingContactDetails::insert($data_building_contact);
        }



        if($storage_lot_update  && $RId1 && $RId2 && $RId3 && $RId4 && $RId5 && $RId6 && $RId7 && $RId8)
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
      
        $buildingInfo=StorageLot::where('id',"=",$id)->update($update_data);

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
