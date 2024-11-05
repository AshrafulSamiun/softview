<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\AccountContactPerson as AccountContactPerson;
use App\Models\BuildingInfo as BuildingInfo;
use App\Models\Country as Country;
use App\Models\Menu as Menu;
use App\Models\Module as Module;
use App\Models\Project as Project;
use App\Models\PropertyManagementType as PropertyManagementType;
use App\Models\Provience as Provience;
use App\Models\ServicePlan as servicePlan;
use App\Models\UserCompany as userCompany;
use App\Models\UserServicePlan as UserServicePlan;
use App\Models\UserServicePlanDetails as UserServicePlanDetails;


//use Browser;


class DashboardController extends Controller
{
    public function __construct( Module $module,Menu $menu)
    {
        //$this->middleware('auth');
        $this->module=$module->orderBy('modSlNo')->get();
        $this->menu=$menu->all();
        $this->middleware('auth');
    }



    public function index()
    {


        $user=\Auth::user();
        
        $project_id   = $user->project_id;
        $project_info = Project::find($project_id);

        $project_type = $project_info->project_status;
        $property_code= $project_info->property_code;


        
        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
            $country_code_arr[$value->id]=$value->country_code;
        }


        $data['country_arr']        =$country_arr;
        $data['property_code']      =$property_code;
        //dd($data['property_code']);die;
        if($project_type==100)
        {

            $data['menu']=Menu::where('status', '=', 10)->orderBy('slno')->get();
            $main_menu_arr=array();
            foreach ($data['menu'] as $key => $value) {
                $main_menu_arr[$value->id]['menuName']=$value->menuName;
                $main_menu_arr[$value->id]['menuRoute']=$value->menuRoute;
            }
            $data['main_menu_arr']=$main_menu_arr;
            return view('temp_dashboard.account_no2',$data);
        }
        else if($project_type==1001)
        {
            $service_plan=ServicePlan::where('status', '=', 1)->get();

            $master_plan_arr=array();
            $lavel_one_plan_arr=array();
            $lavel_two_plan_arr=array();
            foreach($service_plan as $m=>$mvalue)
            {

                if($mvalue->position==1)
                {
                     $master_plan_arr[$mvalue->id]['amount_applicable']=$mvalue->amount_applicable;
                     $master_plan_arr[$mvalue->id]['plan_name']=$mvalue->plan_name;
                     $master_plan_arr[$mvalue->id]['plan_a']=$mvalue->plan_a;
                     $master_plan_arr[$mvalue->id]['plan_b']=$mvalue->plan_b;
                     $master_plan_arr[$mvalue->id]['plan_c']=$mvalue->plan_c;
                     $master_plan_arr[$mvalue->id]['plan_d']=$mvalue->plan_d;                     
                }
                else if( $mvalue->position==2)
                {
                    $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['amount_applicable']=$mvalue->amount_applicable;
                    $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_name']=$mvalue->plan_name;
                    $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_a']=$mvalue->plan_a;
                    $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_b']=$mvalue->plan_b;
                    $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_c']=$mvalue->plan_c;
                    $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_d']=$mvalue->plan_d;
                }
                else if( $mvalue->position==3)
                {
                    $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['amount_applicable']=$mvalue->amount_applicable;
                    $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_name']=$mvalue->plan_name;
                    $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_a']=$mvalue->plan_a;
                    $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_b']=$mvalue->plan_b;
                    $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_c']=$mvalue->plan_c;
                    $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_d']=$mvalue->plan_d;
                }
               
            }

            $data['master_plan_arr']        =$master_plan_arr;
            $data['lavel_one_plan_arr']     =$lavel_one_plan_arr;
            $data['lavel_two_plan_arr']     =$lavel_two_plan_arr;
            return view('user_dashboard',$data);
        }  
        else if($project_type==99)
        {
            $user_company= UserCompany::where('project_id',$project_id)->first();
            $company_provience      = Provience::where('status_active',1)
                                                ->where('country_id',$user_company->company_country_id)
                                                ->get();
            $head_office_provience  = Provience::where('status_active',1)
                                                ->where('country_id',$user_company->head_office_country_id)
                                                ->get();
            $property_provience     = Provience::where('status_active',1)
                                                ->where('country_id',$user_company->property_country_id)
                                                ->get();
            $company_provience_arr=array();
            foreach ($company_provience as $key => $value) {
                $company_provience_arr[$value->id]=$value->provience_name;

            }

            $head_office_provience_arr=array();
            foreach ($head_office_provience as $key => $value) {
                $head_office_provience_arr[$value->id]=$value->provience_name;

            }

            $property_provience_arr=array();
            foreach ($property_provience as $key => $value) {
                $property_provience_arr[$value->id]=$value->provience_name;

            }
        
            $data['property_provience_arr']         =$property_provience_arr;
            $data['head_office_provience_arr']      =$head_office_provience_arr;
            $data['company_provience_arr']          =$company_provience_arr;
           // dd($company_provience_arr);
            if($user_company->company_logo)
            {
                $data['company_logo_url']          =url('/image/account_company_logo/'.$user_company->companyLogo->image_name);
            }
            else

                $data['company_logo_url']          ='';

           $data['userCompany']=$user_company;
            return view('user_dashboard_property_management_type',$data);
        }
        else if($project_type==98)
        {
            $user_company           = UserCompany::where('project_id',$project_id)->first();
            $Buildinginfo           = BuildingInfo::where('project_id',$project_id)->first();
            $company_provience      = Provience::where('status_active',1)
                                                ->where('country_id',$user_company->company_country_id)
                                                ->get();

            $head_office_provience  = Provience::where('status_active',1)
                                                ->where('country_id',$user_company->head_office_country_id)
                                                ->get();

            $property_provience     = Provience::where('status_active',1)
                                                ->where('country_id',$user_company->property_country_id)
                                                ->get();
            $company_provience_arr  =array();
            foreach ($company_provience as $key => $value) {
                $company_provience_arr[$value->id]=$value->provience_name;

            }

            $head_office_provience_arr=array();
            foreach ($head_office_provience as $key => $value) {
                $head_office_provience_arr[$value->id]=$value->provience_name;

            }

            $property_provience_arr=array();
            foreach ($property_provience as $key => $value) {
                $property_provience_arr[$value->id]=$value->provience_name;

            }
        
          //  $data['PropertyManagementType']         =$PropertyManagementType;
            $data['property_provience_arr']         =$property_provience_arr;
            $data['head_office_provience_arr']      =$head_office_provience_arr;
            $data['company_provience_arr']          =$company_provience_arr;
          //  dd($user_company->company_logo);
            if($user_company->company_logo)
            {
                $data['company_logo_url']          =url('/image/account_company_logo/'.$user_company->companyLogo->image_name);
            }
            else

                $data['company_logo_url']          ='';



            if($Buildinginfo->building_photo)
            {
                $data['building_photo_url']          =url('/image/Building_logo/'.$Buildinginfo->BuildingPhoto->image_name);
            }
            else

                $data['building_photo_url']          ='';

            $data['userCompany']=$user_company;
            $data['BuildingInfo']=$Buildinginfo;
            return view('user_dashboard_contact',$data);
        } 
        else if($project_type==97)
        {
            $user_company           = UserCompany::where('project_id',$project_id)->first();
            $Buildinginfo           = BuildingInfo::where('project_id',$project_id)->first();
            $contactInfo            = AccountContactPerson::where('project_id',$project_id)->first();


            
            $head_office_provience          = Provience::where('status_active',1)
                                                ->where('country_id',$contactInfo->head_office_country)
                                                ->get();
            $authorize_person_provience     = Provience::where('status_active',1)
                                                ->where('country_id',$contactInfo->authorize_person_country)
                                                ->get();

          

            $account_payable_provience      = Provience::where('status_active',1)
                                                ->where('country_id',$contactInfo->account_payable_country)
                                                ->get();

          
            $contact_person_provience       = Provience::where('status_active',1)
                                                ->where('country_id',$contactInfo->contact_person_country)
                                                ->get();


            $system_admin_provience         = Provience::where('status_active',1)
                                                ->where('country_id',$contactInfo->system_admin_country)
                                                ->get();

            $authorize_person_provience_arr  =array();
            foreach ($authorize_person_provience as $key => $value) {
                $authorize_person_provience_arr[$value->id]=$value->provience_name;

            }

            $head_office_provience_arr=array();
            foreach ($head_office_provience as $key => $value) {
                $head_office_provience_arr[$value->id]=$value->provience_name;

            }

            $account_payable_provience_arr=array();
            foreach ($account_payable_provience as $key => $value) {
                $account_payable_provience_arr[$value->id]=$value->provience_name;

            }
            
            $contact_person_provience_arr=array();
            foreach ($contact_person_provience as $key => $value) {
                $contact_person_provience_arr[$value->id]=$value->provience_name;

            }
            
            $system_admin_provience_provience_arr=array();
            foreach ($system_admin_provience as $key => $value) {
                $system_admin_provience_arr[$value->id]=$value->provience_name;

            }
            

            $service_plan=ServicePlan::where('status', '=', 1)->orderBy('slno')->get();

            $master_plan_arr=array();
            $lavel_one_plan_arr=array();
            $lavel_two_plan_arr=array();
            foreach($service_plan as $m=>$mvalue)
            {
               // if($m<=4)
               // {
                 $master_plan_arr[$mvalue->id]['amount_applicable']=$mvalue->amount_applicable;
                 $master_plan_arr[$mvalue->id]['rate_applicable']=$mvalue->rate_applicable;
                 $master_plan_arr[$mvalue->id]['plan_name']=$mvalue->plan_name;
                 $master_plan_arr[$mvalue->id]['plan_a']=$mvalue->plan_a;
                 $master_plan_arr[$mvalue->id]['plan_b']=$mvalue->plan_b;
                 $master_plan_arr[$mvalue->id]['plan_c']=$mvalue->plan_c;
                 $master_plan_arr[$mvalue->id]['rate_a']=$mvalue->rate_a; 
                 $master_plan_arr[$mvalue->id]['rate_b']=$mvalue->rate_b;
                 $master_plan_arr[$mvalue->id]['rate_c']=$mvalue->rate_c; 
                 $master_plan_arr[$mvalue->id]['position']=$mvalue->position; 

                // if($mvalue->position==1)
                // {
                //      $master_plan_arr[$mvalue->id]['amount_applicable']=$mvalue->amount_applicable;
                //      $master_plan_arr[$mvalue->id]['rate_applicable']=$mvalue->rate_applicable;
                //      $master_plan_arr[$mvalue->id]['plan_name']=$mvalue->plan_name;
                //      $master_plan_arr[$mvalue->id]['plan_a']=$mvalue->plan_a;
                //      $master_plan_arr[$mvalue->id]['plan_b']=$mvalue->plan_b;
                //      $master_plan_arr[$mvalue->id]['plan_c']=$mvalue->plan_c;
                //      $master_plan_arr[$mvalue->id]['plan_d']=$mvalue->plan_d;                     
                // }
                // else if( $mvalue->position==2)
                // {
                //     $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['amount_applicable']=$mvalue->amount_applicable;
                //     $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['rate_applicable']=$mvalue->rate_applicable;
                //     $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_name']=$mvalue->plan_name;
                //     $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_a']=$mvalue->plan_a;
                //     $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_b']=$mvalue->plan_b;
                //     $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_c']=$mvalue->plan_c;
                //     $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_d']=$mvalue->plan_d;
                // }
                // else if( $mvalue->position==3)
                // {
                //     $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['amount_applicable']=$mvalue->amount_applicable;
                //     $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['rate_applicable']=$mvalue->rate_applicable;
                //     $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_name']=$mvalue->plan_name;
                //     $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_a']=$mvalue->plan_a;
                //     $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_b']=$mvalue->plan_b;
                //     $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_c']=$mvalue->plan_c;
                //     $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_d']=$mvalue->plan_d;
                // }
               // }
                 
               
            }

            $data['master_plan_arr']        =$master_plan_arr;
            $data['lavel_one_plan_arr']     =$lavel_one_plan_arr;
            $data['lavel_two_plan_arr']     =$lavel_two_plan_arr;


        
            $data['BuildingInfo']=$Buildinginfo;
            $data['contactInfo']=$contactInfo;
            

            $data['head_office_provience_arr']              =$head_office_provience_arr;
            $data['authorize_person_provience_arr']         =$authorize_person_provience_arr;

            $data['account_payable_provience_arr']          =$account_payable_provience_arr;
            $data['contact_person_provience_arr']           =$contact_person_provience_arr;
            $data['system_admin_provience_arr']             =$system_admin_provience_arr;
           // $data['company_provience_arr']          =$company_provience_arr;
          //  dd($user_company->company_logo);
            if($user_company->company_logo)
            {
                $data['company_logo_url']          =url('/image/account_company_logo/'.$user_company->companyLogo->image_name);
            }
            else

                $data['company_logo_url']          ='';
            if($Buildinginfo->building_photo)
            {
                $data['building_photo_url']          =url('/image/Building_logo/'.$Buildinginfo->BuildingPhoto->image_name);
            }
            else

                $data['building_photo_url']          ='';

            $data['userCompany']=$user_company;
            return view('user_dashboard_service_plan',$data);
        }

        else if($project_type==96)
        {
            $user_company           = UserCompany::where('project_id',$project_id)->first();
            $Buildinginfo           = BuildingInfo::where('project_id',$project_id)->first();
            $contactInfo            = AccountContactPerson::where('project_id',$project_id)->first();
            $ArrayFunction          =new ArrayFunction();
            $currency               =$ArrayFunction->currency;


            
            $head_office_provience          = Provience::where('status_active',1)
                                                ->where('country_id',$contactInfo->head_office_country)
                                                ->get();
            $authorize_person_provience     = Provience::where('status_active',1)
                                                ->where('country_id',$contactInfo->authorize_person_country)
                                                ->get();

          

            $account_payable_provience      = Provience::where('status_active',1)
                                                ->where('country_id',$contactInfo->account_payable_country)
                                                ->get();

          
            $contact_person_provience       = Provience::where('status_active',1)
                                                ->where('country_id',$contactInfo->contact_person_country)
                                                ->get();


            $system_admin_provience         = Provience::where('status_active',1)
                                                ->where('country_id',$contactInfo->system_admin_country)
                                                ->get();

            $authorize_person_provience_arr  =array();
            foreach ($authorize_person_provience as $key => $value) {
                $authorize_person_provience_arr[$value->id]=$value->provience_name;

            }

            $head_office_provience_arr=array();
            foreach ($head_office_provience as $key => $value) {
                $head_office_provience_arr[$value->id]=$value->provience_name;

            }

            $account_payable_provience_arr=array();
            foreach ($account_payable_provience as $key => $value) {
                $account_payable_provience_arr[$value->id]=$value->provience_name;

            }
            
            $contact_person_provience_arr=array();
            foreach ($contact_person_provience as $key => $value) {
                $contact_person_provience_arr[$value->id]=$value->provience_name;

            }
            
            $system_admin_provience_provience_arr=array();
            foreach ($system_admin_provience as $key => $value) {
                $system_admin_provience_arr[$value->id]=$value->provience_name;

            }
            

            $service_plan=ServicePlan::where('status', '=', 1)->orderBy('slno')->get();
            $user_service_plan_mst=UserServicePlan::where('project_id',$project_id)->first();
           // dd($user_service_plan_mst);die;
            $user_service_plan=UserServicePlanDetails::where('project_id',$project_id)->get();
            $user_service_plan_arr=array();
            foreach($user_service_plan as $u=>$uvalue)
            {
                $user_service_plan_arr[$uvalue->plan_id]['qty_a']=$uvalue->qty_a;
                $user_service_plan_arr[$uvalue->plan_id]['qty_b']=$uvalue->qty_b;
                $user_service_plan_arr[$uvalue->plan_id]['qty_c']=$uvalue->qty_c;
                $user_service_plan_arr[$uvalue->plan_id]['amount_a']=$uvalue->amount_a;
                $user_service_plan_arr[$uvalue->plan_id]['amount_b']=$uvalue->amount_b;
                $user_service_plan_arr[$uvalue->plan_id]['amount_c']=$uvalue->amount_c; 

                $user_service_plan_arr[$uvalue->plan_id]['is_check_a']=$uvalue->is_check_a;
                $user_service_plan_arr[$uvalue->plan_id]['is_check_b']=$uvalue->is_check_b;
                $user_service_plan_arr[$uvalue->plan_id]['is_check_c']=$uvalue->is_check_c;

                $user_service_plan_arr[$uvalue->plan_id]['rate_applicable']=$uvalue->rate_applicable;
                $user_service_plan_arr[$uvalue->plan_id]['id']=$uvalue->id;
               // $user_service_plan_arr[$uvalue->plan_id]['amount_c']=$uvalue->amount_c;
            }

            $master_plan_arr=array();
            $lavel_one_plan_arr=array();
            $lavel_two_plan_arr=array();
            foreach($service_plan as $m=>$mvalue)
            {

                 $master_plan_arr[$mvalue->id]['amount_applicable']=$mvalue->amount_applicable;
                 $master_plan_arr[$mvalue->id]['rate_applicable']=$mvalue->rate_applicable;
                 $master_plan_arr[$mvalue->id]['plan_name']=$mvalue->plan_name;
                 $master_plan_arr[$mvalue->id]['plan_a']=$mvalue->plan_a;
                 $master_plan_arr[$mvalue->id]['plan_b']=$mvalue->plan_b;
                 $master_plan_arr[$mvalue->id]['plan_c']=$mvalue->plan_c;
                 $master_plan_arr[$mvalue->id]['rate_a']=$mvalue->rate_a; 
                 $master_plan_arr[$mvalue->id]['rate_b']=$mvalue->rate_b;
                 $master_plan_arr[$mvalue->id]['rate_c']=$mvalue->rate_c; 
                 $master_plan_arr[$mvalue->id]['position']=$mvalue->position; 

                
            }
            $data['user_service_plan_mst']  =$user_service_plan_mst;
            $data['user_service_plan_arr']  =$user_service_plan_arr;
            $data['master_plan_arr']        =$master_plan_arr;
            $data['lavel_one_plan_arr']     =$lavel_one_plan_arr;
            $data['lavel_two_plan_arr']     =$lavel_two_plan_arr;


        
            $data['BuildingInfo']=$Buildinginfo;
            $data['contactInfo']=$contactInfo;
            

            $data['head_office_provience_arr']              =$head_office_provience_arr;
            $data['authorize_person_provience_arr']         =$authorize_person_provience_arr;

            $data['account_payable_provience_arr']          =$account_payable_provience_arr;
            $data['contact_person_provience_arr']           =$contact_person_provience_arr;
            $data['system_admin_provience_arr']             =$system_admin_provience_arr;
           // $data['company_provience_arr']          =$company_provience_arr;
          //  dd($user_company->company_logo);
            if($user_company->company_logo)
            {
                $data['company_logo_url']          =url('/image/account_company_logo/'.$user_company->companyLogo->image_name);
            }
            else

                $data['company_logo_url']          ='';
            if($Buildinginfo->building_photo)
            {
                $data['building_photo_url']          =url('/image/Building_logo/'.$Buildinginfo->BuildingPhoto->image_name);
            }
            else

                $data['building_photo_url']          ='';

            $data['userCompany']=$user_company;
            $data['currency']=$currency;
            return view('user_dashboard_service_contact',$data);
        }
        else if($project_type==9744555)
        {
            $user_company           = UserCompany::where('project_id',$project_id)->first();
            $PropertyManagementType = PropertyManagementType::where('project_id',$project_id)->first();

            $user_service_plan      = UserServicePlan::where('status_active',1)
                                                    ->where('project_id',$project_id)
                                                    ->first();
            $user_service_plan_dtls = UserServicePlanDetails::where('status_active',1)
                                                    ->where('project_id',$project_id)
                                                    ->get();


            $user_service_plan_dtls_arr  =array();
            foreach ($user_service_plan_dtls as $key => $value) {
                $user_service_plan_dtls_arr[$value->plan_id]['plan_value']      =$value->plan_value;
                $user_service_plan_dtls_arr[$value->plan_id]['discount_amount'] =$value->discount_amount;
                $user_service_plan_dtls_arr[$value->plan_id]['id']              =$value->id;
            }

            $data['user_service_plan']        =$user_service_plan;
            $data['user_service_plan_dtls_arr']     =$user_service_plan_dtls_arr;
            //dd($user_service_plan_dtls_arr);die;
            $company_provience      = Provience::where('status_active',1)
                                                ->where('country_id',$user_company->company_country_id)
                                                ->get();

            $head_office_provience  = Provience::where('status_active',1)
                                                ->where('country_id',$user_company->head_office_country_id)
                                                ->get();

            $property_provience     = Provience::where('status_active',1)
                                                ->where('country_id',$user_company->property_country_id)
                                                ->get();


            $company_provience_arr  =array();
            foreach ($company_provience as $key => $value) {
                $company_provience_arr[$value->id]=$value->provience_name;

            }

            $head_office_provience_arr=array();
            foreach ($head_office_provience as $key => $value) {
                $head_office_provience_arr[$value->id]=$value->provience_name;

            }

            $property_provience_arr=array();
            foreach ($property_provience as $key => $value) {
                $property_provience_arr[$value->id]=$value->provience_name;

            }


            $service_plan=ServicePlan::where('status', '=', 1)->get();

            $master_plan_arr=array();
            $lavel_one_plan_arr=array();
            $lavel_two_plan_arr=array();
            foreach($service_plan as $m=>$mvalue)
            {

                if($mvalue->position==1)
                {
                     $master_plan_arr[$mvalue->id]['amount_applicable']=$mvalue->amount_applicable;
                     $master_plan_arr[$mvalue->id]['plan_name']=$mvalue->plan_name;
                     $master_plan_arr[$mvalue->id]['plan_a']=$mvalue->plan_a;
                     $master_plan_arr[$mvalue->id]['plan_b']=$mvalue->plan_b;
                     $master_plan_arr[$mvalue->id]['plan_c']=$mvalue->plan_c;
                     $master_plan_arr[$mvalue->id]['plan_d']=$mvalue->plan_d;                     
                }
                else if( $mvalue->position==2)
                {
                    $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['amount_applicable']=$mvalue->amount_applicable;
                    $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_name']=$mvalue->plan_name;
                    $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_a']=$mvalue->plan_a;
                    $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_b']=$mvalue->plan_b;
                    $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_c']=$mvalue->plan_c;
                    $lavel_one_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_d']=$mvalue->plan_d;
                }
                else if( $mvalue->position==3)
                {
                    $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['amount_applicable']=$mvalue->amount_applicable;
                    $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_name']=$mvalue->plan_name;
                    $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_a']=$mvalue->plan_a;
                    $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_b']=$mvalue->plan_b;
                    $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_c']=$mvalue->plan_c;
                    $lavel_two_plan_arr[$mvalue->master_plan_id][$mvalue->id]['plan_d']=$mvalue->plan_d;
                }
               
            }

            $data['master_plan_arr']        =$master_plan_arr;
            $data['lavel_one_plan_arr']     =$lavel_one_plan_arr;
            $data['lavel_two_plan_arr']     =$lavel_two_plan_arr;


        
            $data['PropertyManagementType']         =$PropertyManagementType;
            $data['property_provience_arr']         =$property_provience_arr;
            $data['head_office_provience_arr']      =$head_office_provience_arr;
            $data['company_provience_arr']          =$company_provience_arr;
          //  dd($user_company->company_logo);
             if($user_company->company_logo)
            {
                $data['company_logo_url']          =url('/image/account_company_logo/'.$user_company->companyLogo->image_name);
            }
            else

                $data['company_logo_url']          ='';

           $data['userCompany']=$user_company;
            return view('user_dashboard_contact',$data);
        }
        else {
            $data['module']=Module::where('status', '=', 1)->orderBy('modSlNo')->get();
            $data['menu']=Menu::where('status', '=', 1)->orderBy('slno')->get();
            $main_menu_arr=array();
            $lavel_one_arr=array();
            $lavel_two_arr=array();
            foreach ($data['menu'] as $key => $value) {
                if($value->position==2)
                {
                   // $lavel_one_arr[$value->rootMenu][$value->id]['id']=$value->id;
                    $lavel_one_arr[$value->rootMenu][$value->id]['menuName']=$value->menuName;
                    $lavel_one_arr[$value->rootMenu][$value->id]['menuRoute']=$value->menuRoute;
                }
                else if($value->position==3)
                {
                   // $lavel_two_arr[$value->rootMenu]['id']=$value->id;
                    $lavel_two_arr[$value->rootMenu][$value->id]['menuName']=$value->menuName;
                    $lavel_two_arr[$value->rootMenu][$value->id]['menuRoute']=$value->menuRoute;
                }
                
               
            }
            $data['lavel_one_arr']=$lavel_one_arr;
            $data['lavel_two_arr']=$lavel_two_arr;
          //  dd($data['lavel_one_arr'][1]);
            return view('dashboard',$data);
        } 
        
        //return view('dashboard');
    }


    public function user_module($module_id)
    {
        $data['module']=Module::where('status', '=', 1)->get();
        $selected_module=Module::where('id', '=', $module_id)->get(['moduleName']);
        $data['title']=$selected_module[0]->moduleName;
       // dd($data['title']);
        $user_id = \Auth::user()->id;
        $menu_data=Menu::where('status', '=', 1)->where('moduleId', '=', $module_id)->get();

        $data['menu']=$menu_data;
        $root_menu_arr=array();
        $main_menu_arr=array();
        foreach($menu_data as $m=>$mvalue)
        {

        	if($mvalue->rootMenu>0 || $mvalue->position>1)
        	{
        		 $root_menu_arr[$mvalue->rootMenu][$mvalue->id]['id']=$mvalue->id;
           		 $root_menu_arr[$mvalue->rootMenu][$mvalue->id]['name']=$mvalue->menuName;
           		 $root_menu_arr[$mvalue->rootMenu][$mvalue->id]['menuRoute']=$mvalue->menuRoute;

           		 
        	}
        	else if($mvalue->rootMenu==0 || $mvalue->position==1)
        	{
        		 $main_menu_arr[$mvalue->id]['id']=$mvalue->id;
           		 $main_menu_arr[$mvalue->id]['name']=$mvalue->menuName;
                 $main_menu_arr[$mvalue->id]['menuRoute']=$mvalue->menuRoute;
        	}
           
        }

        $data['rootMenu']=$this->menu->where('moduleId', '=', $module_id)->where('rootMenu', '=', 0)->all();
        $data['root_menu_arr']=$root_menu_arr;
        $data['main_menu_arr']=$main_menu_arr;

//return $data;
        return view('dashboard_module',$data);
    }
}
