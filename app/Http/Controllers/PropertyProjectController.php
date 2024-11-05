<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\AccountCompany as AccountCompany;
use App\Models\AccountHolder;
use App\Models\BikeStall;
use App\Models\BuildingInfo as BuildingInfo;
use App\Models\CommercialUnit;
use App\Models\CommonAreaDetails;
use App\Models\Company;
use App\Models\Country as Country;
use App\Models\Customer;
use App\Models\MailBox;
use App\Models\ParkingStall;
use App\Models\PropertyAttribution;
use App\Models\PropertyAttributionDetails;
use App\Models\PropertyProject;
use App\Models\PropertyProjectAmount;
use App\Models\PropertyProjectDuration;
use App\Models\PropertyProjectLocation;
use App\Models\PropertyProjectTimeline;
use App\Models\PropPrjIncidentReport;
use App\Models\PropPrjPaymentSchedule;
use App\Models\ResidentialSuite;
use App\Models\ServiceProviderInsPkg;
use App\Models\StorageLocker;
use App\Models\SupportingRoomDetails;
use App\Models\UomSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyProjectController extends Controller
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
        $inseurance_type_arr    =$ArrayFunction->inseurance_type;

        $ksl=0;
        foreach($inseurance_type_arr as $key=>$val)
        {
            $data['inseurance_type_arr'][$ksl]['id']=$key;
            $data['inseurance_type_arr'][$ksl]['val']=$val;
            $ksl++;
        }
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

        $service_provider                =AccountHolder::where('status_active',1)
                                            ->where('account_type',2)
                                            ->where('project_id',$project_id)
                                            ->get();

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
                                    ->first();

        $building_sql               =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get();
        $building_arr=array();
        foreach ($building_sql as $key => $value) {

            $building_arr[$value->id]['building_no']            =$value->building_no;
            $building_arr[$value->id]['building_name']          =$value->building_name;
            $building_arr[$value->id]['residential']            =$value->residential;
            $building_arr[$value->id]['commercial']             =$value->commercial;
            $building_arr[$value->id]['residential_commercial'] =$value->residential_commercial;
        }

        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
        }

        $data['country_arr']        =$country_arr;
        $data['uom_setting']        =$uom_setting->uom;
        $data['service_provider']   =$service_provider;
        $data['building_arr']       =$building_arr;
        return $data;

    }
    public function PropertyProjectsList()
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $project_status_arr         =$ArrayFunction->project_status;
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
        

        $service_provider                =AccountHolder::where('status_active',1)
                                            ->where('account_type',2)
                                            ->where('project_id',$project_id)
                                            ->get();

        $service_provider_arr=array();
        foreach ($service_provider as $key => $value) {
            $service_provider_arr[$value->id]['system_no']=$value->system_no;
            $service_provider_arr[$value->id]['corporation_legal_name']=$value->register_corp_first_name." ".$value->register_corp_middle_name." ".$value->register_corp_last_name;
        }

        $building_list              =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get(['id','building_no','building_name']);

        //===================Building==========================================

        $building_arr=array();
        foreach ($building_list as $key => $value) {
            $building_arr[$value->id]=$value->building_no;
        } 



        $sl=0;
        $property_project_list=PropertyProject::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->get();
         foreach ($property_project_list as $key => $value) {

            $data['property_project_list'][$key]['sl']                      =$sl+1;
            $data['property_project_list'][$key]['id']                      =$value->id;
            $data['property_project_list'][$key]['system_no']               =$value->system_no;
            $data['property_project_list'][$key]['project_name']            =$value->project_name;
            $data['property_project_list'][$key]['subject_title']           =$value->subject_title;
            

            if($value->building_type==1)
            {
                $data['property_project_list'][$key]['building_type']    ="Residential Building";

            }
            else if($value->building_type==2)
            {
                $data['property_project_list'][$key]['building_type']    ="Commercial Building";
            }
            else if($value->building_type==3)
            {
                $data['property_project_list'][$key]['building_type']    ="Residential- Commercial Building";
            }


            if($value->current_status>0)
            {
                $data['property_project_list'][$key]['current_status']     =$project_status_arr[$value->current_status];

            }
            else
            {
                $data['property_project_list'][$key]['current_status']      ="";

            }

            if($value->contractor_id>0)
            {
                $data['property_project_list'][$key]['contractor_id_no']    =$service_provider_arr[$value->contractor_id]['system_no'];
                $data['property_project_list'][$key]['contractor_name']     =$service_provider_arr[$value->contractor_id]['corporation_legal_name'];

            }
            else
            {
                $data['property_project_list'][$key]['contractor_id_no']      ="";
                $data['property_project_list'][$key]['contractor_name']      ="";

            }

            if($value->building_id>0)
            {
                $data['property_project_list'][$key]['building_name']     =$building_arr[$value->building_id];

            }
            else
            {
                $data['property_project_list'][$key]['building_name']      ="";

            }
            
            $sl++;

        }

       // $data['commercial_unit_list']        =$commercial_unit_list;
        
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
                                        ->join('building_property_details as dtls','mst.floor_no','=','dtls.id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.master_id', '=', $building_id)
                                        ->select('mst.system_no', 'mst.floor_name', 'dtls.floor_no', 'dtls.floor_type','mst.id')
                                        ->get();
       
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {

            $floor_arr[$value->id]['system_no']     =$value->system_no;
            $floor_arr[$value->id]['floor_name']    =$value->floor_name;
            $floor_arr[$value->id]['floor_no']      =$value->floor_no;
            $floor_arr[$value->id]['floor_id']      =$value->id;
            $floor_arr[$value->id]['floor_type']    =$value->floor_type;
            $floor_arr[$value->id]['data_exist']    =false;
            $floor_arr[$value->id]['toggle']        =false;
            $floor_arr[$value->id]['parking']       =false;
            $floor_arr[$value->id]['bike_lot']      =false;
            $floor_arr[$value->id]['suite']         =false;
            $floor_arr[$value->id]['unit']          =false;
            $floor_arr[$value->id]['supporting']    =false;
            $floor_arr[$value->id]['storage']       =false;
            $floor_arr[$value->id]['common']        =false;
            $floor_arr[$value->id]['mail']          =false;

            $floor_arr[$value->id]['machanical']    =false;
            $floor_arr[$value->id]['administritive']=false;
            $floor_arr[$value->id]['aminity']       =false;
            $floor_arr[$value->id]['service']       =false;
        }


        $suite_sql                  =ResidentialSuite::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('building_name',$building_id)
                                    ->get();
            

        $suite_arr=array();
        $sl=0;
        foreach ($suite_sql as $key => $value) {

            $suite_arr[$value->floor_no][$sl]['property_name']     =$value->property_name;
            $suite_arr[$value->floor_no][$sl]['system_no']         =$value->system_no;
            $suite_arr[$value->floor_no][$sl]['suite_no']          =$value->suite_no;
            $suite_arr[$value->floor_no][$sl]['suite_type']        =$value->suite_type;
            $suite_arr[$value->floor_no][$sl]['id']                =$value->id;
            $suite_arr[$value->floor_no][$sl]['toggle']            =false;
            $floor_arr[$value->floor_no]['data_exist']             =true;

            $floor_arr[$value->floor_no]['suite']                  =true;
            $sl++;
        }

        $data['suite_arr']        =$suite_arr;

       // dd($data['suite_arr']);
        $subrooms_details           =DB::table('residential_suites as mst')
                                    ->join('residential_suite_details as dtls','mst.id','=','dtls.master_id')
                                    ->where('mst.project_id',$project_id)
                                    ->where('mst.status_active',1)
                                    ->where('dtls.project_id',$project_id)
                                    ->where('dtls.status_active',1)
                                    ->select([
                                        'dtls.property_name','dtls.master_id','dtls.item_name','dtls.item_id','dtls.id as dtls_id'
                                        ,'dtls.details_id','dtls.system_no','dtls.comments','dtls.item_size'])
                                    ->get();

        $subrooms_list_arr=array();
        $sl=0;
        foreach ($subrooms_details as $key => $value) {

            $subrooms_list_arr[$value->master_id][$sl]['item_name']     =$value->item_name;
            $subrooms_list_arr[$value->master_id][$sl]['item_id']       =$value->item_id;
            $subrooms_list_arr[$value->master_id][$sl]['id']            =$value->dtls_id;
            $subrooms_list_arr[$value->master_id][$sl]['details_id']    =$value->details_id;
            $subrooms_list_arr[$value->master_id][$sl]['system_no']     =$value->system_no;
            $subrooms_list_arr[$value->master_id][$sl]['property_name'] =$value->property_name;
            $subrooms_list_arr[$value->master_id][$sl]['comments']      =$value->comments;
            $subrooms_list_arr[$value->master_id][$sl]['item_size']     =$value->item_size;
            $subrooms_list_arr[$value->master_id][$sl]['allocated']     =false;
            $sl++;

        }

        $data['subrooms_list_arr']        =$subrooms_list_arr;



        $unit_sql                  =CommercialUnit::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('building_name',$building_id)
                                    ->get();

       

        $unit_arr=array();
        $sl=0;
        foreach ($unit_sql as $key => $value) {

            $unit_arr[$value->floor_no][$sl]['property_name']    =$value->property_name;
            $unit_arr[$value->floor_no][$sl]['system_no']        =$value->system_no;
            $unit_arr[$value->floor_no][$sl]['unit_no']          =$value->unit_no;
            $unit_arr[$value->floor_no][$sl]['id']               =$value->id;
            $unit_arr[$value->floor_no][$sl]['unit_type']        =$value->unit_type;
            $unit_arr[$value->floor_no][$sl]['toggle']           =false;
            $floor_arr[$value->floor_no]['unit']                 =true;
            $floor_arr[$value->floor_no]['data_exist']           =true;

            $sl++;
        }
        $data['unit_arr']        =$unit_arr;


        $unit_subrooms_details        =DB::table('commercial_units as mst')
                                        ->join('commercial_unit_details as dtls','mst.id','=','dtls.master_id')
                                        ->where('mst.project_id',$project_id)
                                        ->where('mst.building_name',$building_id)
                                        ->where('mst.status_active',1)
                                        ->where('dtls.project_id',$project_id)
                                        ->where('dtls.status_active',1)
                                        ->select([
                                            'dtls.property_name','dtls.master_id','dtls.item_name','dtls.item_id','dtls.id as dtls_id'
                                            ,'dtls.details_id','dtls.system_no','dtls.comments','dtls.item_size'])
                                        ->get();
        $unit_subrooms_list_arr=array();
        $sl=0;
        foreach ($unit_subrooms_details as $key => $value) {

            $unit_subrooms_list_arr[$value->master_id][$sl]['item_name']     =$value->item_name;
            $unit_subrooms_list_arr[$value->master_id][$sl]['item_id']       =$value->item_id;
            $unit_subrooms_list_arr[$value->master_id][$sl]['id']            =$value->master_id;
            $unit_subrooms_list_arr[$value->master_id][$sl]['details_id']    =$value->details_id;
            $unit_subrooms_list_arr[$value->master_id][$sl]['system_no']     =$value->system_no;
            $unit_subrooms_list_arr[$value->master_id][$sl]['property_name'] =$value->property_name;
            $unit_subrooms_list_arr[$value->master_id][$sl]['comments']      =$value->comments;
            $unit_subrooms_list_arr[$value->master_id][$sl]['allocated']     =false;
            $sl++;
            
        }

        $data['unit_subrooms_list_arr']          =$unit_subrooms_list_arr;



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
            
            $parking_stall_arr[$value->floor_no][$sl]['mst_property_name']    =$value->mst_property_name;
            $parking_stall_arr[$value->floor_no][$sl]['parking_level']        =$value->dtls_property_name;
            $parking_stall_arr[$value->floor_no][$sl]['floor_no']             =$value->floor_no;
            $parking_stall_arr[$value->floor_no][$sl]['update_id']            ="";
            $parking_stall_arr[$value->floor_no][$sl]['id']                   =$value->id;
            $parking_stall_arr[$value->floor_no][$sl]['mst_id']               =$value->mst_id;
            $parking_stall_arr[$value->floor_no][$sl]['level_no']             =$value->details_id;
            $parking_stall_arr[$value->floor_no][$sl]['item_name']            =$value->item_name;
            $parking_stall_arr[$value->floor_no][$sl]['system_no']            =$value->system_no;
            $parking_stall_arr[$value->floor_no][$sl]['lot_uom']              =$value->lot_uom;
            $parking_stall_arr[$value->floor_no][$sl]['item_size']            =$value->item_size;
            $parking_stall_arr[$value->floor_no][$sl]['property_name']        =$value->property_name;
            $parking_stall_arr[$value->floor_no][$sl]['allocated']            =false;
           // $parking_lot_arr[$value->mst_id]['property_name']=$value->mst_property_name;
            $floor_arr[$value->floor_no]['parking']                          =true;
            $floor_arr[$value->floor_no]['data_exist']                       =true;
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
            
            $bike_stall_arr[$value->floor_no][$sl]['mst_property_name']    =$value->mst_property_name;
            $bike_stall_arr[$value->floor_no][$sl]['bike_level']           =$value->dtls_property_name;
            $bike_stall_arr[$value->floor_no][$sl]['floor_no']             =$value->floor_no;
            $bike_stall_arr[$value->floor_no][$sl]['update_id']            ="";
            $bike_stall_arr[$value->floor_no][$sl]['id']                   =$value->id;
            $bike_stall_arr[$value->floor_no][$sl]['mst_id']               =$value->mst_id;
            $bike_stall_arr[$value->floor_no][$sl]['level_no']             =$value->details_id;
            $bike_stall_arr[$value->floor_no][$sl]['item_name']            =$value->item_name;
            $bike_stall_arr[$value->floor_no][$sl]['system_no']            =$value->system_no;
            $bike_stall_arr[$value->floor_no][$sl]['lot_uom']              =$value->lot_uom;
            $bike_stall_arr[$value->floor_no][$sl]['item_size']            =$value->item_size;
            $bike_stall_arr[$value->floor_no][$sl]['property_name']        =$value->property_name;
            $bike_stall_arr[$value->floor_no][$sl]['allocated']            =false;
            $floor_arr[$value->floor_no]['bike_lot']                       =true;
            $floor_arr[$value->floor_no]['data_exist']                     =true;
           // $bike_lot_arr[$value->mst_id]['property_name']=$value->mst_property_name;

            $sl++;
            
        }


        $storage_locker_details         =DB::table('storage_lots as mst')
                                        ->join('storage_levels as dtls','mst.id','=','dtls.master_id')
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
            
            $storage_locker_arr[$value->floor_no][$sl]['mst_property_name']       =$value->mst_property_name;
            $storage_locker_arr[$value->floor_no][$sl]['storage_level']           =$value->dtls_property_name;
            $storage_locker_arr[$value->floor_no][$sl]['floor_no']                =$value->floor_no;
            $storage_locker_arr[$value->floor_no][$sl]['update_id']               ="";
            $storage_locker_arr[$value->floor_no][$sl]['id']                      =$value->id;
            $storage_locker_arr[$value->floor_no][$sl]['mst_id']                  =$value->mst_id;
            $storage_locker_arr[$value->floor_no][$sl]['level_no']                =$value->details_id;
            $storage_locker_arr[$value->floor_no][$sl]['item_name']               =$value->item_name;
            $storage_locker_arr[$value->floor_no][$sl]['system_no']               =$value->system_no;
            $storage_locker_arr[$value->floor_no][$sl]['lot_uom']                 =$value->lot_uom;
            $storage_locker_arr[$value->floor_no][$sl]['item_size']               =$value->item_size;
            $storage_locker_arr[$value->floor_no][$sl]['property_name']           =$value->property_name;
            $storage_locker_arr[$value->floor_no][$sl]['allocated']               =false;
            $storage_lot_arr[$value->mst_id]['property_name']                     =$value->mst_property_name;
            $floor_arr[$value->floor_no]['storage']                               =true;
            $floor_arr[$value->floor_no]['data_exist']                            =true;
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
            
            $mail_box_arr[$value->floor_no][$sl]['mst_property_name']         =$value->mst_property_name;
            $mail_box_arr[$value->floor_no][$sl]['floor_no']                  =$value->floor_no;
            $mail_box_arr[$value->floor_no][$sl]['update_id']                 ="";
            $mail_box_arr[$value->floor_no][$sl]['id']                        =$value->id;
            $mail_box_arr[$value->floor_no][$sl]['mst_id']                    =$value->mst_id;
            $mail_box_arr[$value->floor_no][$sl]['item_name']                 =$value->item_name;
            $mail_box_arr[$value->floor_no][$sl]['system_no']                 =$value->system_no;
            $mail_box_arr[$value->floor_no][$sl]['room_uom']                  =$value->room_uom;
            $mail_box_arr[$value->floor_no][$sl]['item_size']                 =$value->item_size;
            $mail_box_arr[$value->floor_no][$sl]['property_name']             =$value->property_name;
            $mail_box_arr[$value->floor_no][$sl]['allocated']                 =false;
            $mail_room_arr[$value->mst_id]['property_name']                   =$value->mst_property_name;

            $floor_arr[$value->floor_no]['mail']                              =true;
            $floor_arr[$value->floor_no]['data_exist']                        =true;
           
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
            
            $common_area_arr[$value->floor_no][$sl]['mst_property_name']  =$value->mst_property_name;
            $common_area_arr[$value->floor_no][$sl]['floor_no']           =$value->floor_no;
            $common_area_arr[$value->floor_no][$sl]['update_id']          ="";
            $common_area_arr[$value->floor_no][$sl]['id']                 =$value->id;
            $common_area_arr[$value->floor_no][$sl]['mst_id']             =$value->mst_id;
            $common_area_arr[$value->floor_no][$sl]['item_name']          =$value->item_name;
            $common_area_arr[$value->floor_no][$sl]['system_no']          =$value->system_no;
            $common_area_arr[$value->floor_no][$sl]['uom']                =$value->uom;
            $common_area_arr[$value->floor_no][$sl]['item_size']          =$value->item_size;
            $common_area_arr[$value->floor_no][$sl]['property_name']      =$value->property_name;
            $common_area_arr[$value->floor_no][$sl]['allocated']          =false;
            
            $floor_arr[$value->floor_no]['common']                       =true;
            $floor_arr[$value->floor_no]['data_exist']                   =true;
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
            
            $service_room_arr[$value->floor_no][$sl]['mst_property_name']               =$value->mst_property_name;
            $service_room_arr[$value->floor_no][$sl]['floor_no']                        =$value->floor_no;
            $service_room_arr[$value->floor_no][$sl]['update_id']                       ="";
            $service_room_arr[$value->floor_no][$sl]['id']                              =$value->id;
            $service_room_arr[$value->floor_no][$sl]['mst_id']                          =$value->mst_id;
            $service_room_arr[$value->floor_no][$sl]['item_name']                       =$value->item_name;
            $service_room_arr[$value->floor_no][$sl]['item_type']                       =$value->item_type;
            $service_room_arr[$value->floor_no][$sl]['system_no']                       =$value->system_no;
            $service_room_arr[$value->floor_no][$sl]['uom']                             =$value->uom;
            $service_room_arr[$value->floor_no][$sl]['item_size']                       =$value->item_size;
            $service_room_arr[$value->floor_no][$sl]['property_name']                   =$value->property_name;
            $service_room_arr[$value->floor_no][$sl]['allocated']                       =false;
            
            $floor_arr[$value->floor_no]['supporting']                                  =true;
            if($value->item_type==7)  $floor_arr[$value->floor_no]['machanical']        =true;
            if($value->item_type==8)  $floor_arr[$value->floor_no]['administritive']    =true;
            if($value->item_type==9)  $floor_arr[$value->floor_no]['aminity']           =true;
            if($value->item_type==10) $floor_arr[$value->floor_no]['service']           =true;
            $floor_arr[$value->floor_no]['data_exist']                                  =true;
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
        $data['floor_arr']                  =$floor_arr;
       // dd($data['parking_stall_arr']);


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
            'project_name' => 'required',
            'subject_title' => 'required',
            'current_status' => 'required',
            'contractor_id_no' => 'required',
            'corporation_legal_name' => 'required',
            'final_delivery_date' => 'required',
            // 'project_name' => 'required',
            // 'project_name' => 'required',
            // 'project_name' => 'required',
            // 'project_name' => 'required',
            // 'project_name' => 'required',
            // 'project_name' => 'required',
            // 'project_name' => 'required',
            // 'project_name' => 'required',
            // 'project_name' => 'required',
            // 'project_name' => 'required',
            // 'project_name' => 'required',

        ]);
        
        if($request->input('residential_building_id')) 
        {
            $request->merge(['building_id' =>$request->input('residential_building_id')]);
            $request->merge(['building_type' =>1]);
        } 
        else if($request->input('commercial_building_id')) 
        {
            $request->merge(['building_id' =>$request->input('commercial_building_id')]);
            $request->merge(['building_type' =>2]);
        }
        else if($request->input('residential_commercial_building_id')) 
        {
            $request->merge(['building_id' =>$request->input('residential_commercial_building_id')]);
            $request->merge(['building_type' =>3]);
        }

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        $max_system_data = PropertyProject::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from property_projects 
            where building_id=".$request->input('building_id')."  and project_id=".$project_id." and YEAR(created_at)=".date('Y')." ) 
            and building_id=".$request->input('building_id')." and YEAR(created_at)=".date('Y')."  and project_id=".$project_id)->get(['system_prefix']);
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

        $system_no="MP-".date('Y')."-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $property_info= PropertyProject::create($request->all());
        $data_property_details=array();

        foreach($request->floor_arr as $floor_id=>$floor_details)
        {

            if($floor_details["suite"])
            {
                foreach($request->suite_arr[$floor_id] as $suite_details)
                {

                    foreach($request->subrooms_list_arr[$suite_details["id"]] as $key=>$details)
                    {
                        if($details['allocated']!="")
                        {
                            
                            $insert_date                    =date("Y-m-d h:i:s");
                            $data_property_details[]= array(
                                'project_id'                =>$project_id,
                                'building_id'               =>$request->input('building_id'),
                                'floor_id'                  =>$floor_id,
                                'prop_master_id'            =>$suite_details['id'],
                                'prop_details_id'           =>$details['details_id'],
                                'master_id'                 =>$property_info->id,
                                'floor_type'                =>1,
                                'inserted_by'               =>$user_id,
                                'created_at'                =>$insert_date
                            );

                        }
                    }
                    
                }

            }
            if($floor_details["unit"])
            {
                foreach($request->unit_arr[$floor_id] as $unit_details)
                {

                    foreach($request->unit_subrooms_list_arr[$unit_details["id"]] as $key=>$details)
                    {
                        if($details['allocated']!="")
                        {
                            
                            $insert_date                    =date("Y-m-d h:i:s");
                            $data_property_details[]= array(
                                'project_id'                =>$project_id,
                                'building_id'               =>$request->input('building_id'),
                                'floor_id'                  =>$floor_id,
                                'prop_master_id'            =>$unit_details['id'],
                                'prop_details_id'           =>$details['details_id'],
                                'master_id'                 =>$property_info->id,
                                'floor_type'                =>2,
                                'inserted_by'               =>$user_id,
                                'created_at'                =>$insert_date
                            );
                        }
                    }
                    
                }

            }
            if($floor_details["parking"])
            {
                foreach($request->parking_stall_arr[$floor_id] as $parking_stall)
                {
                    if($parking_stall['allocated']!="")
                    {
                        $insert_date                    =date("Y-m-d h:i:s");
                        $data_property_details[]= array(
                            'project_id'                =>$project_id,
                            'building_id'               =>$request->input('building_id'),
                            'floor_id'                  =>$floor_id,
                            'prop_master_id'            =>$parking_stall['mst_id'],
                            'prop_details_id'           =>$parking_stall['id'],
                            'master_id'                 =>$property_info->id,
                            'floor_type'                =>3,
                            'inserted_by'               =>$user_id,
                            'created_at'                =>$insert_date
                        );
                    }
                }

            }
            if($floor_details["bike_lot"])
            {
                foreach($request->bike_stall_arr[$floor_id] as $bike_stall)
                {
                    if($bike_stall['allocated']!="")
                    {
                        $insert_date                    =date("Y-m-d h:i:s");
                        $data_property_details[]= array(
                            'project_id'                =>$project_id,
                            'building_id'               =>$request->input('building_id'),
                            'floor_id'                  =>$floor_id,
                            'prop_master_id'            =>$bike_stall['mst_id'],
                            'prop_details_id'           =>$bike_stall['id'],
                            'master_id'                 =>$property_info->id,
                            'floor_type'                =>4,
                            'inserted_by'               =>$user_id,
                            'created_at'                =>$insert_date
                        );
                    }
                }

            }
            if($floor_details["storage"])
            {
                foreach($request->storage_locker_arr[$floor_id] as $storage_locker)
                {
                    if($storage_locker['allocated']!="")
                    {
                        $insert_date                    =date("Y-m-d h:i:s");
                        $data_property_details[]= array(
                            'project_id'                =>$project_id,
                            'building_id'               =>$request->input('building_id'),
                            'floor_id'                  =>$floor_id,
                            'prop_master_id'            =>$storage_locker['mst_id'],
                            'prop_details_id'           =>$storage_locker['id'],
                            'master_id'                 =>$property_info->id,
                            'floor_type'                =>5,
                            'inserted_by'               =>$user_id,
                            'created_at'                =>$insert_date
                        );
                    }
                }

            }
            if($floor_details["mail"])
            {
                foreach($request->mail_box_arr[$floor_id] as $mail_box)
                {
                    if($mail_box['allocated']!="")
                    {
                        $insert_date                    =date("Y-m-d h:i:s");
                        $data_property_details[]= array(
                            'project_id'                =>$project_id,
                            'building_id'               =>$request->input('building_id'),
                            'floor_id'                  =>$floor_id,
                            'prop_master_id'            =>$mail_box['mst_id'],
                            'prop_details_id'           =>$mail_box['id'],
                            'master_id'                 =>$property_info->id,
                            'floor_type'                =>6,
                            'inserted_by'               =>$user_id,
                            'created_at'                =>$insert_date
                        );
                    }
                }

            }
            if($floor_details["common"])
            {
                foreach($request->common_area_arr[$floor_id] as $common_area)
                {
                    if($common_area['allocated']!="")
                    {
                        $insert_date                    =date("Y-m-d h:i:s");
                        $data_property_details[]= array(
                            'project_id'                =>$project_id,
                            'building_id'               =>$request->input('building_id'),
                            'floor_id'                  =>$floor_id,
                            'prop_master_id'            =>$common_area['mst_id'],
                            'prop_details_id'           =>$common_area['id'],
                            'master_id'                 =>$property_info->id,
                            'floor_type'                =>7,
                            'inserted_by'               =>$user_id,
                            'created_at'                =>$insert_date
                        );
                    }
                }

            }
            if($floor_details["supporting"])
            {
                foreach($request->service_room_arr[$floor_id] as $service_room)
                {
                    if($service_room['allocated']!="")
                    {
                        $insert_date                    =date("Y-m-d h:i:s");
                        $data_property_details[]= array(
                            'project_id'                =>$project_id,
                            'building_id'               =>$request->input('building_id'),
                            'floor_id'                  =>$floor_id,
                            'prop_master_id'            =>$service_room['mst_id'],
                            'prop_details_id'           =>$service_room['id'],
                            'master_id'                 =>$property_info->id,
                            'floor_type'                =>7,
                            'inserted_by'               =>$user_id,
                            'created_at'                =>$insert_date
                        );
                    }
                }

            }
        }

        foreach($request->inseurance_type_arr as $key=>$details)
        {
            if($details['company_name'] )
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['expire_date'])       
                    $details['expire_date']       =date("Y-m-d",strtotime($details['expire_date']));
                $data_inseurance_type_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'reference_id'              =>$details['reference_id'],
                    'item_name'                 =>$details['item_name'],
                    'company_name'              =>$details['company_name'],
                    'address'                   =>$details['address'],
                    'policy_no'                 =>$details['policy_no'],
                    'expire_date'               =>$details['expire_date'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );              
            }
        }

        foreach($request->project_duration_arr as $key=>$details)
        {
            if($details['from_date'])
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['from_date'])       
                    $details['from_date']       =date("Y-m-d",strtotime($details['from_date']));

                if($details['to_date'])       
                    $details['to_date']         =date("Y-m-d",strtotime($details['to_date']));
                
                
                $data_project_duration_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'item_name'                 =>$details['item_name'],
                    'net_year'                  =>$details['net_year'],
                    'net_days'                  =>$details['net_days'],
                    'from_date'                 =>$details['from_date'],
                    'to_date'                   =>$details['to_date'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );                
            }
        } 

        foreach($request->timeline_arr as $key=>$details)
        {
            if($details['task_details'])
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                
                if($details['from_date'])       
                    $details['from_date']       =date("Y-m-d",strtotime($details['from_date']));

                if($details['to_date'])       
                    $details['to_date']         =date("Y-m-d",strtotime($details['to_date']));

                if($details['resedule_to_date1'])       
                    $details['resedule_to_date1']         =date("Y-m-d",strtotime($details['resedule_to_date1']));

                if($details['resedule_from_date1'])       
                    $details['resedule_from_date1']       =date("Y-m-d",strtotime($details['resedule_from_date1']));

                if($details['resedule_to_date2'])       
                    $details['resedule_to_date2']         =date("Y-m-d",strtotime($details['resedule_to_date2']));

                if($details['resedule_from_date2'])       
                    $details['resedule_from_date2']       =date("Y-m-d",strtotime($details['resedule_from_date2']));

                if($details['resedule_to_date3'])       
                    $details['resedule_to_date3']         =date("Y-m-d",strtotime($details['resedule_to_date3']));

                if($details['resedule_from_date3'])       
                    $details['resedule_from_date3']       =date("Y-m-d",strtotime($details['resedule_from_date3']));

                
                $data_timeline_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'hours'                     =>$details['hours'],
                    'days'                      =>$details['days'],
                    'to_date'                   =>$details['to_date'],
                    'from_date'                 =>$details['from_date'],
                    'resedule_from_date1'       =>$details['resedule_from_date1'],
                    'resedule_to_date1'         =>$details['resedule_to_date1'],
                    'resedule_from_date2'       =>$details['resedule_from_date2'],
                    'resedule_to_date2'         =>$details['resedule_to_date2'],
                    'resedule_from_date3'       =>$details['resedule_from_date3'],
                    'resedule_to_date3'         =>$details['resedule_to_date3'],
                    'task_status'               =>$details['task_status'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );

               
            }
        }
        //dd($request->project_amount_arr);
        foreach($request->project_amount_arr as $key=>$details)
        {
            if($details['amount_before_tax'])
            {
                $insert_date                    =date("Y-m-d h:i:s");
                $data_amount_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'type'                      =>$details['type'],
                    'title'                     =>$details['title'],
                    'amount_before_tax'         =>$details['amount_before_tax'],
                    'taxes'                     =>$details['taxes'],
                    'sl'                        =>$details['sl'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );
            }
        }

        foreach($request->payment_schedule_arr as $key=>$details)
        {
            if($details['due_date']!="")
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['due_date'])       
                    $details['due_date']        =date("Y-m-d",strtotime($details['due_date']));


                $data_payment_schedule_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'due_date'                  =>$details['due_date'],
                    'is_callender'              =>$details['is_callender'],
                    'sl'                        =>$details['sl'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );
            }
        } 

        foreach($request->incident_reports_arr as $key=>$details)
        {
            if($details['incident_date']!="")
            {
                
                $insert_date                    =date("Y-m-d h:i:s");
                if($details['incident_date'])       
                    $details['incident_date']        =date("Y-m-d",strtotime($details['incident_date']));

                $data_incedent_report_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$property_info->id,
                    'incident_date'             =>$details['incident_date'],
                    'details'                   =>$details['details'],
                    'reported_by'               =>$details['reported_by'],
                    'sl'                        =>$details['sl'],
                    'inserted_by'               =>$user_id,
                    'created_at'                =>$insert_date
                );              
            }
        } 
        //dd($data_property_details);die;
        $RId1=true;
        if(!empty($data_property_details))
        {
            $RId1=PropertyProjectLocation::insert($data_property_details);
        }
        $RId2=true;
        if(!empty($data_inseurance_type_details))
        {
            $RId2=ServiceProviderInsPkg::insert($data_inseurance_type_details);
        }
        $RId3=true;
        if(!empty($data_project_duration_details))
        {
            $RId3=PropertyProjectDuration::insert($data_project_duration_details);
        }
        $RId4=true;
        if(!empty($data_timeline_details))
        {
            $RId4=PropertyProjectTimeline::insert($data_timeline_details);
        }
        $RId5=true;
        if(!empty($data_amount_details))
        {
            $RId5=PropertyProjectAmount::insert($data_amount_details);
        }
        $RId6=true;
        if(!empty($data_payment_schedule_details))
        {
            $RId6=PropPrjPaymentSchedule::insert($data_payment_schedule_details);
        }

        $RId7=true;
        if(!empty($data_incedent_report_details))
        {
            $RId7=PropPrjIncidentReport::insert($data_incedent_report_details);
        }


        if($property_info && $RId1 && $RId2 && $RId3 && $RId4 && $RId5 && $RId6 && $RId7)
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

        $master_property_sql        =PropertyProject::where('project_id', '=', $project_id)
                                        ->where('id', '=', $id)
                                        ->where('status_active', '=', 1)
                                        ->first();

        $building_id=$master_property_sql->building_id;
        $master_id=$master_property_sql->id;
        $building_type=$master_property_sql->building_type;
        $contractor_id=$master_property_sql->contractor_id;

        $service_provider                =AccountHolder::where('status_active',1)
                                            ->where('account_type',2)
                                            ->where('id', '=', $contractor_id)
                                            ->where('project_id',$project_id)
                                            ->first();
       
        $data['service_provider_arr']=$service_provider;
        $data['master_property_arr']=$master_property_sql;

        $building_sql               =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get();
        $building_arr=array();
        foreach ($building_sql as $key => $value) {

            $building_arr[$value->id]['building_no']            =$value->building_no;
            $building_arr[$value->id]['building_name']          =$value->building_name;
            $building_arr[$value->id]['residential']            =$value->residential;
            $building_arr[$value->id]['commercial']             =$value->commercial;
            $building_arr[$value->id]['residential_commercial'] =$value->residential_commercial;
        }

        $data['building_arr']       =$building_arr;
        
        

        $floor_list                 =DB::table('floors as mst')
                                        ->join('building_property_details as dtls','mst.floor_no','=','dtls.id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.master_id', '=', $building_id)
                                        ->select('mst.system_no', 'mst.floor_name', 'dtls.floor_no', 'dtls.floor_type','mst.id')
                                        ->get();
       
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {

            $floor_arr[$value->id]['system_no']     =$value->system_no;
            $floor_arr[$value->id]['floor_name']    =$value->floor_name;
            $floor_arr[$value->id]['floor_no']      =$value->floor_no;
            $floor_arr[$value->id]['floor_id']      =$value->id;
            $floor_arr[$value->id]['floor_type']    =$value->floor_type;
            $floor_arr[$value->id]['data_exist']    =false;
            $floor_arr[$value->id]['toggle']        =false;
            $floor_arr[$value->id]['parking']       =false;
            $floor_arr[$value->id]['bike_lot']      =false;
            $floor_arr[$value->id]['suite']         =false;
            $floor_arr[$value->id]['unit']          =false;
            $floor_arr[$value->id]['supporting']    =false;
            $floor_arr[$value->id]['storage']       =false;
            $floor_arr[$value->id]['common']        =false;
            $floor_arr[$value->id]['mail']          =false;

            $floor_arr[$value->id]['machanical']    =false;
            $floor_arr[$value->id]['administritive']=false;
            $floor_arr[$value->id]['aminity']       =false;
            $floor_arr[$value->id]['service']       =false;
        }
        $property_location=PropertyProjectLocation::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('master_id',$master_id)
                                    ->where('building_id',$building_id)
                                    ->get();
        $property_location_arr=array();
        foreach($property_location as $val)
        {
            $property_location_arr[$val->floor_id][$val->floor_type][$val->prop_master_id][$val->prop_details_id]['id']=$val->id;
        }


        $suite_sql                  =ResidentialSuite::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('building_name',$building_id)
                                    ->get();
            

        $suite_arr=array();
        $sl=0;
        foreach ($suite_sql as $key => $value) {

            $suite_arr[$value->floor_no][$sl]['property_name']     =$value->property_name;
            $suite_arr[$value->floor_no][$sl]['system_no']         =$value->system_no;
            $suite_arr[$value->floor_no][$sl]['suite_no']          =$value->suite_no;
            $suite_arr[$value->floor_no][$sl]['suite_type']        =$value->suite_type;
            $suite_arr[$value->floor_no][$sl]['id']                =$value->id;
            $suite_arr[$value->floor_no][$sl]['toggle']            =false;
            $floor_arr[$value->floor_no]['data_exist']             =true;

            $floor_arr[$value->floor_no]['suite']                  =true;
            $sl++;
        }

        $data['suite_arr']        =$suite_arr;

       // dd($data['suite_arr']);
        $subrooms_details           =DB::table('residential_suites as mst')
                                    ->join('residential_suite_details as dtls','mst.id','=','dtls.master_id')
                                    ->where('mst.project_id',$project_id)
                                    ->where('mst.status_active',1)
                                    ->where('dtls.project_id',$project_id)
                                    ->where('dtls.status_active',1)
                                    ->select([
                                        'dtls.property_name','dtls.master_id','dtls.item_name','dtls.item_id','dtls.id as dtls_id'
                                        ,'dtls.details_id','dtls.system_no','dtls.comments','dtls.item_size','mst.floor_no'])
                                    ->get();

        $subrooms_list_arr=array();
        $sl=0;
        foreach ($subrooms_details as $key => $value) {

            $subrooms_list_arr[$value->master_id][$sl]['item_name']     =$value->item_name;
            $subrooms_list_arr[$value->master_id][$sl]['item_id']       =$value->item_id;
            $subrooms_list_arr[$value->master_id][$sl]['id']            =$value->dtls_id;
            $subrooms_list_arr[$value->master_id][$sl]['details_id']    =$value->details_id;
            $subrooms_list_arr[$value->master_id][$sl]['system_no']     =$value->system_no;
            $subrooms_list_arr[$value->master_id][$sl]['property_name'] =$value->property_name;
            $subrooms_list_arr[$value->master_id][$sl]['comments']      =$value->comments;
            $subrooms_list_arr[$value->master_id][$sl]['item_size']     =$value->item_size;
            if(!empty($property_location_arr[$value->floor_no][1][$value->master_id][$value->dtls_id]['id']))
            {
                $subrooms_list_arr[$value->master_id][$sl]['allocated']     =true;
                $subrooms_list_arr[$value->master_id][$sl]['update_id']     =$property_location_arr[$value->floor_no][1][$value->master_id][$value->dtls_id]['id'];
            }
            else
            {
                $subrooms_list_arr[$value->master_id][$sl]['update_id']     ="";
                $subrooms_list_arr[$value->master_id][$sl]['allocated']     =false;
            }
            
            $sl++;

        }

        $data['subrooms_list_arr']        =$subrooms_list_arr;



        $unit_sql                  =CommercialUnit::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('building_name',$building_id)
                                    ->get();

        

        $unit_arr=array();
        $sl=0;
        foreach ($unit_sql as $key => $value) {

            $unit_arr[$value->floor_no][$sl]['property_name']    =$value->property_name;
            $unit_arr[$value->floor_no][$sl]['system_no']        =$value->system_no;
            $unit_arr[$value->floor_no][$sl]['unit_no']          =$value->unit_no;
            $unit_arr[$value->floor_no][$sl]['id']               =$value->id;
            $unit_arr[$value->floor_no][$sl]['unit_type']        =$value->unit_type;
            $unit_arr[$value->floor_no][$sl]['toggle']           =false;
            $floor_arr[$value->floor_no]['unit']                 =true;
            $floor_arr[$value->floor_no]['data_exist']           =true;

            $sl++;
        }

        $data['unit_arr']        =$unit_arr;


        $unit_subrooms_details        =DB::table('commercial_units as mst')
                                        ->join('commercial_unit_details as dtls','mst.id','=','dtls.master_id')
                                        ->where('mst.project_id',$project_id)
                                        ->where('mst.building_name',$building_id)
                                        ->where('mst.status_active',1)
                                        ->where('dtls.project_id',$project_id)
                                        ->where('dtls.status_active',1)
                                        ->select([
                                            'dtls.property_name','dtls.master_id','dtls.item_name','dtls.item_id','dtls.id as dtls_id'
                                            ,'dtls.details_id','dtls.system_no','dtls.comments','dtls.item_size','mst.floor_no'])
                                        ->get();
        $unit_subrooms_list_arr=array();
        $sl=0;

        foreach ($unit_subrooms_details as $key => $value) {

            $unit_subrooms_list_arr[$value->master_id][$sl]['item_name']     =$value->item_name;
            $unit_subrooms_list_arr[$value->master_id][$sl]['item_id']       =$value->item_id;
            $unit_subrooms_list_arr[$value->master_id][$sl]['id']            =$value->master_id;
            $unit_subrooms_list_arr[$value->master_id][$sl]['details_id']    =$value->details_id;
            $unit_subrooms_list_arr[$value->master_id][$sl]['system_no']     =$value->system_no;
            $unit_subrooms_list_arr[$value->master_id][$sl]['property_name'] =$value->property_name;
            $unit_subrooms_list_arr[$value->master_id][$sl]['comments']      =$value->comments;
            if(!empty($property_location_arr[$value->floor_no][2][$value->master_id][$value->details_id]['id']))
            {
                $unit_subrooms_list_arr[$value->master_id][$sl]['allocated'] =true;
                $unit_subrooms_list_arr[$value->master_id][$sl]['update_id'] =$property_location_arr[$value->floor_no][2][$value->master_id][$value->details_id]['id'];
            }
            else
            {
                $unit_subrooms_list_arr[$value->master_id][$sl]['allocated'] =false;
                $unit_subrooms_list_arr[$value->master_id][$sl]['update_id'] ="";
            }
            $sl++;
            
        }
        dd($unit_subrooms_list_arr);die;

        $data['unit_subrooms_list_arr']          =$unit_subrooms_list_arr;



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
            
            $parking_stall_arr[$value->floor_no][$sl]['mst_property_name']    =$value->mst_property_name;
            $parking_stall_arr[$value->floor_no][$sl]['parking_level']        =$value->dtls_property_name;
            $parking_stall_arr[$value->floor_no][$sl]['floor_no']             =$value->floor_no;
            $parking_stall_arr[$value->floor_no][$sl]['update_id']            ="";
            $parking_stall_arr[$value->floor_no][$sl]['id']                   =$value->id;
            $parking_stall_arr[$value->floor_no][$sl]['mst_id']               =$value->mst_id;
            $parking_stall_arr[$value->floor_no][$sl]['level_no']             =$value->details_id;
            $parking_stall_arr[$value->floor_no][$sl]['item_name']            =$value->item_name;
            $parking_stall_arr[$value->floor_no][$sl]['system_no']            =$value->system_no;
            $parking_stall_arr[$value->floor_no][$sl]['lot_uom']              =$value->lot_uom;
            $parking_stall_arr[$value->floor_no][$sl]['item_size']            =$value->item_size;
            $parking_stall_arr[$value->floor_no][$sl]['property_name']        =$value->property_name;
            $parking_stall_arr[$value->floor_no][$sl]['allocated']            =false;
           // $parking_lot_arr[$value->mst_id]['property_name']=$value->mst_property_name;
            $floor_arr[$value->floor_no]['parking']                          =true;
            $floor_arr[$value->floor_no]['data_exist']                       =true;
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
            
            $bike_stall_arr[$value->floor_no][$sl]['mst_property_name']    =$value->mst_property_name;
            $bike_stall_arr[$value->floor_no][$sl]['bike_level']           =$value->dtls_property_name;
            $bike_stall_arr[$value->floor_no][$sl]['floor_no']             =$value->floor_no;
            $bike_stall_arr[$value->floor_no][$sl]['update_id']            ="";
            $bike_stall_arr[$value->floor_no][$sl]['id']                   =$value->id;
            $bike_stall_arr[$value->floor_no][$sl]['mst_id']               =$value->mst_id;
            $bike_stall_arr[$value->floor_no][$sl]['level_no']             =$value->details_id;
            $bike_stall_arr[$value->floor_no][$sl]['item_name']            =$value->item_name;
            $bike_stall_arr[$value->floor_no][$sl]['system_no']            =$value->system_no;
            $bike_stall_arr[$value->floor_no][$sl]['lot_uom']              =$value->lot_uom;
            $bike_stall_arr[$value->floor_no][$sl]['item_size']            =$value->item_size;
            $bike_stall_arr[$value->floor_no][$sl]['property_name']        =$value->property_name;
            $bike_stall_arr[$value->floor_no][$sl]['allocated']            =false;
            $floor_arr[$value->floor_no]['bike_lot']                       =true;
            $floor_arr[$value->floor_no]['data_exist']                     =true;
           // $bike_lot_arr[$value->mst_id]['property_name']=$value->mst_property_name;

            $sl++;
            
        }


        $storage_locker_details         =DB::table('storage_lots as mst')
                                        ->join('storage_levels as dtls','mst.id','=','dtls.master_id')
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
            
            $storage_locker_arr[$value->floor_no][$sl]['mst_property_name']       =$value->mst_property_name;
            $storage_locker_arr[$value->floor_no][$sl]['storage_level']           =$value->dtls_property_name;
            $storage_locker_arr[$value->floor_no][$sl]['floor_no']                =$value->floor_no;
            $storage_locker_arr[$value->floor_no][$sl]['update_id']               ="";
            $storage_locker_arr[$value->floor_no][$sl]['id']                      =$value->id;
            $storage_locker_arr[$value->floor_no][$sl]['mst_id']                  =$value->mst_id;
            $storage_locker_arr[$value->floor_no][$sl]['level_no']                =$value->details_id;
            $storage_locker_arr[$value->floor_no][$sl]['item_name']               =$value->item_name;
            $storage_locker_arr[$value->floor_no][$sl]['system_no']               =$value->system_no;
            $storage_locker_arr[$value->floor_no][$sl]['lot_uom']                 =$value->lot_uom;
            $storage_locker_arr[$value->floor_no][$sl]['item_size']               =$value->item_size;
            $storage_locker_arr[$value->floor_no][$sl]['property_name']           =$value->property_name;
            $storage_locker_arr[$value->floor_no][$sl]['allocated']               =false;
            $storage_lot_arr[$value->mst_id]['property_name']                     =$value->mst_property_name;
            $floor_arr[$value->floor_no]['storage']                               =true;
            $floor_arr[$value->floor_no]['data_exist']                            =true;
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
            
            $mail_box_arr[$value->floor_no][$sl]['mst_property_name']         =$value->mst_property_name;
            $mail_box_arr[$value->floor_no][$sl]['floor_no']                  =$value->floor_no;
            $mail_box_arr[$value->floor_no][$sl]['update_id']                 ="";
            $mail_box_arr[$value->floor_no][$sl]['id']                        =$value->id;
            $mail_box_arr[$value->floor_no][$sl]['mst_id']                    =$value->mst_id;
            $mail_box_arr[$value->floor_no][$sl]['item_name']                 =$value->item_name;
            $mail_box_arr[$value->floor_no][$sl]['system_no']                 =$value->system_no;
            $mail_box_arr[$value->floor_no][$sl]['room_uom']                  =$value->room_uom;
            $mail_box_arr[$value->floor_no][$sl]['item_size']                 =$value->item_size;
            $mail_box_arr[$value->floor_no][$sl]['property_name']             =$value->property_name;
            $mail_box_arr[$value->floor_no][$sl]['allocated']                 =false;
            $mail_room_arr[$value->mst_id]['property_name']                   =$value->mst_property_name;

            $floor_arr[$value->floor_no]['mail']                              =true;
            $floor_arr[$value->floor_no]['data_exist']                        =true;
           
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
            
            $common_area_arr[$value->floor_no][$sl]['mst_property_name']  =$value->mst_property_name;
            $common_area_arr[$value->floor_no][$sl]['floor_no']           =$value->floor_no;
            $common_area_arr[$value->floor_no][$sl]['update_id']          ="";
            $common_area_arr[$value->floor_no][$sl]['id']                 =$value->id;
            $common_area_arr[$value->floor_no][$sl]['mst_id']             =$value->mst_id;
            $common_area_arr[$value->floor_no][$sl]['item_name']          =$value->item_name;
            $common_area_arr[$value->floor_no][$sl]['system_no']          =$value->system_no;
            $common_area_arr[$value->floor_no][$sl]['uom']                =$value->uom;
            $common_area_arr[$value->floor_no][$sl]['item_size']          =$value->item_size;
            $common_area_arr[$value->floor_no][$sl]['property_name']      =$value->property_name;
            $common_area_arr[$value->floor_no][$sl]['allocated']          =false;
            
            $floor_arr[$value->floor_no]['common']                       =true;
            $floor_arr[$value->floor_no]['data_exist']                   =true;
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
            
            $service_room_arr[$value->floor_no][$sl]['mst_property_name']               =$value->mst_property_name;
            $service_room_arr[$value->floor_no][$sl]['floor_no']                        =$value->floor_no;
            $service_room_arr[$value->floor_no][$sl]['update_id']                       ="";
            $service_room_arr[$value->floor_no][$sl]['id']                              =$value->id;
            $service_room_arr[$value->floor_no][$sl]['mst_id']                          =$value->mst_id;
            $service_room_arr[$value->floor_no][$sl]['item_name']                       =$value->item_name;
            $service_room_arr[$value->floor_no][$sl]['item_type']                       =$value->item_type;
            $service_room_arr[$value->floor_no][$sl]['system_no']                       =$value->system_no;
            $service_room_arr[$value->floor_no][$sl]['uom']                             =$value->uom;
            $service_room_arr[$value->floor_no][$sl]['item_size']                       =$value->item_size;
            $service_room_arr[$value->floor_no][$sl]['property_name']                   =$value->property_name;
            $service_room_arr[$value->floor_no][$sl]['allocated']                       =false;
            
            $floor_arr[$value->floor_no]['supporting']                                  =true;
            if($value->item_type==7)  $floor_arr[$value->floor_no]['machanical']        =true;
            if($value->item_type==8)  $floor_arr[$value->floor_no]['administritive']    =true;
            if($value->item_type==9)  $floor_arr[$value->floor_no]['aminity']           =true;
            if($value->item_type==10) $floor_arr[$value->floor_no]['service']           =true;
            $floor_arr[$value->floor_no]['data_exist']                                  =true;
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
        $data['floor_arr']                  =$floor_arr;
       // dd($data['parking_stall_arr']);


      //  return $data;

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
