<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\OwnerOthorizePerson as ownerOthorizePerson;
use App\Models\UserCompany as userCompany;
use App\Models\UserLicenseInsurence as userLicenseInsurence;
use App\Models\UserProfile as userProfile;
use App\Models\UserVehicle as userVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ArrayFunction          =new ArrayFunction();
        $row_status             =$ArrayFunction->row_status;
        $user_type_arr          =$ArrayFunction->user_type_arr;
        $year_arr               =$ArrayFunction->year_arr;
        $country_arr               =$ArrayFunction->country_arr;

        $data['row_status']=$row_status;
        $data['country_arr']=$country_arr;
        $data['user_type_arr']=$user_type_arr;
        $data['year_arr']=$year_arr;
        $project_id = \Auth::user()->project_id;
        $user_id = \Auth::user()->id;
        $user_data=UserProfile::where('project_id',$project_id)
                                ->where('user_id',$user_id)
                                ->where('status_active',1)->get();

        $sl=0;
        foreach($user_data as $key=>$val)
        {
    
            $data['user_data']['id']=$val->id;
            $data['user_data']['first_name']            =$val->first_name;
            $data['user_data']['middle_name']           =$val->middle_name;
            $data['user_data']['last_name']             =$val->last_name;
            $data['user_data']['status_active']         =$val->status_active;
            $data['user_data']['nick_name']             =$val->nick_name;
            $data['user_data']['website']               =$val->website;
            $data['user_data']['office_phone']          =$val->office_phone;
            $data['user_data']['cell_phone']            =$val->cell_phone;
            $data['user_data']['home_phone']            =$val->home_phone;
            $data['user_data']['official_email']        =$val->official_email;
            $data['user_data']['office_phone']          =$val->office_phone;
            $data['user_data']['recovery_email']        =$val->recovery_email;
            $data['user_data']['user_type']             =$val->user_type;

            $data['user_data']['user_photo_id']         =$val->user_photo_id;


            $data['user_data']['country_id']            =$val->country_id;
            $data['user_data']['billing_country_id']    =$val->billing_country_id;
            $data['user_data']['mailing_country_id']    =$val->mailing_country_id;

            $data['user_data']['state']                 =$val->state;
            $data['user_data']['mailing_state']         =$val->mailing_state;
            $data['user_data']['billing_state']         =$val->billing_state;

            $data['user_data']['city']                  =$val->city;
            $data['user_data']['mailing_city']          =$val->mailing_city;
            $data['user_data']['billing_city']          =$val->billing_city;

            $data['user_data']['street']                =$val->street;
            $data['user_data']['mailing_street']        =$val->mailing_street;
            $data['user_data']['billing_street']        =$val->billing_street;

            $data['user_data']['postal_code']           =$val->postal_code;
            $data['user_data']['mailing_postal_code']   =$val->mailing_postal_code;
            $data['user_data']['billing_postal_code']   =$val->billing_postal_code;
        }

        $user_company_data=UserCompany::where('project_id',$project_id)
                                ->where('user_id',$user_id)->get();

        $sl=0;
        foreach($user_company_data as $key=>$val)
        {
    
            $data['user_data']['user_company_id']       =$val->id;
            $data['user_data']['legal_name']            =$val->legal_name;
            $data['user_data']['operational_name']      =$val->operational_name;
            $data['user_data']['buisness_type']         =$val->buisness_type;
            $data['user_data']['service_type']          =$val->service_type;
            $data['user_data']['company_address']       =$val->company_address;
            $data['user_data']['woner_name']            =$val->woner_name;
            $data['user_data']['company_office_phone']  =$val->company_office_phone;
            $data['user_data']['company_cell_phone']    =$val->company_cell_phone;
            $data['user_data']['company_email']         =$val->company_email;
            $data['user_data']['company_website']       =$val->company_website;
            $data['user_data']['bn_no']                 =$val->bn_no;
            $data['user_data']['related_association']   =$val->related_association;
            $data['user_data']['user_type']             =$val->user_type;
            $data['user_data']['status_active']         =$val->status_active;
        }

        $ownerOthorize_data=OwnerOthorizePerson::where('project_id',$project_id)
                                ->where('user_id',$user_id)->get();

        $sl=0;
        foreach($ownerOthorize_data as $key=>$val)
        {
            $data['user_data']['othorize_person_id']        =$val->id;
            $data['user_data']['fm_legal_name']             =$val->fm_legal_name;
            $data['user_data']['fm_address']                =$val->fm_address;
            $data['user_data']['fm_photo_id']               =$val->fm_photo_id;
            $data['user_data']['fm_gove_id_fontpart']       =$val->fm_gove_id_fontpart;
            $data['user_data']['fm_gove_id_backpart']       =$val->fm_gove_id_backpart;
            $data['user_data']['relation_with_landlord']    =$val->relation_with_landlord;
            $data['user_data']['fm_office_phone']           =$val->fm_office_phone;
            $data['user_data']['fm_cell_phone']             =$val->fm_cell_phone;
            $data['user_data']['fm_email']                  =$val->fm_email;
            $data['user_data']['fm_company_name']           =$val->fm_company_name;
            $data['user_data']['fm_company_phone']          =$val->fm_company_phone;
            $data['user_data']['business_address']          =$val->business_address;
            $data['user_data']['fm_company_bn_no']          =$val->fm_company_bn_no;
            $data['user_data']['fm_company_website']        =$val->fm_company_website;

        }

        $user_vehicle_data=UserVehicle::where('project_id',$project_id)
                                ->where('user_id',$user_id)->get();

        $sl=0;
        foreach($user_vehicle_data as $key=>$val)
        {
    
            $data['vihicle_info_arr'][$sl]['id']                       =$val->id;
            $data['vihicle_info_arr'][$sl]['vihicle_model_no']         =$val->vihicle_model_no;
            $data['vihicle_info_arr'][$sl]['vihicle_model_year']       =$val->vihicle_model_year;
            $data['vihicle_info_arr'][$sl]['vihicle_color']            =$val->vihicle_color;
            $data['vihicle_info_arr'][$sl]['vihicle_plate_no']         =$val->vihicle_plate_no;
            $data['vihicle_info_arr'][$sl]['vihicle_ins_exp_date']     =$val->vihicle_ins_exp_date;
        }


        $userLicenseInsurence_data=UserLicenseInsurence::where('project_id',$project_id)
                                                ->where('user_id',$user_id)->get();

        $sl=0;
        foreach($userLicenseInsurence_data as $key=>$val)
        {
            $data['user_data']['permit_licence_id']         =$val->id;
            $data['user_data']['permit_start']              =$val->permit_start;
            $data['user_data']['permit_end']                =$val->permit_end;
            $data['user_data']['permit_expire_date']        =$val->permit_expire_date;
            $data['user_data']['permit_image_id']           =$val->permit_image_id;
            $data['user_data']['license_start']       =$val->license_start;
            $data['user_data']['license_end']    =$val->license_end;
            $data['user_data']['license_expire_date']           =$val->license_expire_date;
            $data['user_data']['license_image_id']             =$val->license_image_id;
            $data['user_data']['liability_start']                  =$val->liability_start;
            $data['user_data']['liability_end']           =$val->liability_end;
            $data['user_data']['liability_expire_date']          =$val->liability_expire_date;
            $data['user_data']['liability_image_id']          =$val->liability_image_id;
            $data['user_data']['home_insurence_start']          =$val->home_insurence_start;
            $data['user_data']['home_insurence_end']        =$val->home_insurence_end;
            $data['user_data']['home_insurence_expire_date']              =$val->home_insurence_expire_date;
            $data['user_data']['home_insurence_image_id']                =$val->home_insurence_image_id;
            $data['user_data']['car_insurence_start']        =$val->car_insurence_start;
            $data['user_data']['car_insurence_end']           =$val->car_insurence_end;
            $data['user_data']['car_insurence_expire_date']       =$val->car_insurence_expire_date;
            $data['user_data']['car_insurence_image_id']    =$val->car_insurence_image_id;
            
        }

        if(empty($data['vihicle_info_arr'])) $data['vihicle_info_arr']=array();
        if(empty($data['user_data'])) $data['user_data']=array();
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
            'first_name' => 'required',
            'last_name' => 'required',
            'website' => 'required',
            'cell_phone' => 'required',
            'user_type' => 'required',
            'country_id' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
      
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        //print_r($request->input('project_id'));die;
        DB::beginTransaction();

        $user_insert=UserProfile::create($request->all());

        if($request->input('legal_name'))
        {
            $company_insert=UserCompany::create($request->all());
        }
        else
        {
            $company_insert=true;
        }

        if($request->input('fm_legal_name'))
        {
            $ownerOthorizePerson_insert=OwnerOthorizePerson::create($request->all());
        }
        else
        {
            $ownerOthorizePerson_insert=true;
        }

        $data_vehicle=array();
        foreach($request->vihicle_info_arr as $key=>$vihicle_info)
        {
            if(!empty($vihicle_info['link']))
            {

                $data_vehicle[]= array(
                    'project_id'            =>$project_id,
                    'user_id'               =>$user_id,
                    'vihicle_model_no'      =>$vihicle_info['vihicle_model_no'],
                    'vihicle_model_year'    =>$vihicle_info['vihicle_model_year'],
                    'vihicle_color'         =>$vihicle_info['vihicle_color'],
                    'vihicle_plate_no'      =>$vihicle_info['vihicle_plate_no'],
                    'vihicle_ins_exp_date'  =>$vihicle_info['vihicle_ins_exp_date'],

                    'inserted_by'           =>$user_id,
                    'created_at'            => date('Y-m-d H:i:s'),
                    'updated_at'            => date('Y-m-d H:i:s')              
                ); 

            }
        }

        $vehicle_insert=true;
        if(!empty($data_vehicle))
        {
            $vehicle_insert=UserVehicle::insert($data_vehicle);
        }


        if($request->input('permit_start') || $request->input('license_start') || $request->input('liability_start') || $request->input('permit_start') || $request->input('permit_start'))
        {
            if($request->input('permit_start'))  
                $request->merge(['permit_start'                 =>date("Y-m-d",strtotime($request->input('permit_start')))]);
            if($request->input('permit_end')) 
                $request->merge(['permit_end'                   =>date("Y-m-d",strtotime($request->input('permit_end')))]);
            if($request->input('permit_expire_date')) 
                $request->merge(['permit_expire_date'           =>date("Y-m-d",strtotime($request->input('permit_expire_date')))]);

            if($request->input('license_start')) 
                $request->merge(['license_start'                =>date("Y-m-d",strtotime($request->input('license_start')))]);
            if($request->input('license_end')) 
                $request->merge(['license_end'                  =>date("Y-m-d",strtotime($request->input('license_end')))]);
            if($request->input('license_expire_date')) 
                $request->merge(['license_expire_date'          =>date("Y-m-d",strtotime($request->input('license_expire_date')))]);

            if($request->input('liability_start'))  
                $request->merge(['liability_start'              =>date("Y-m-d",strtotime($request->input('liability_start')))]);
            if($request->input('liability_end')) 
                $request->merge(['liability_end'                =>date("Y-m-d",strtotime($request->input('liability_end')))]);
            if($request->input('liability_expire_date')) 
                $request->merge(['liability_expire_date'        =>date("Y-m-d",strtotime($request->input('liability_expire_date')))]);

            if($request->input('home_insurence_start')) 
                $request->merge(['home_insurence_start'         =>date("Y-m-d",strtotime($request->input('home_insurence_start')))]);
            if($request->input('home_insurence_end')) 
                $request->merge(['home_insurence_end'           =>date("Y-m-d",strtotime($request->input('home_insurence_end')))]);
            if($request->input('home_insurence_expire_date')) 
                $request->merge(['home_insurence_expire_date'   =>date("Y-m-d",strtotime($request->input('home_insurence_expire_date')))]);

            if($request->input('car_insurence_start')) 
                $request->merge(['car_insurence_start'          =>date("Y-m-d",strtotime($request->input('car_insurence_start')))]);
            if($request->input('car_insurence_end')) 
                $request->merge(['car_insurence_end'            =>date("Y-m-d",strtotime($request->input('car_insurence_end')))]);
            if($request->input('car_insurence_expire_date')) 
                $request->merge(['car_insurence_expire_date'    =>date("Y-m-d",strtotime($request->input('car_insurence_expire_date')))]);
            //date("Y-m-d",strtotime($request->input('permit_start'))
            $licenseInsurence_insert=UserLicenseInsurence::create($request->all());
        }
        else
        {
            $licenseInsurence_insert=true;
        }


        if($user_insert && $company_insert && $ownerOthorizePerson_insert && $vehicle_insert && $licenseInsurence_insert)
        {
           DB::commit();
           return 1;
        }
        else
        {
            DB::rollBack();
           return 10;
        }
        die;
        
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
        //
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
            'first_name' => 'required',
            'last_name' => 'required',
            'website' => 'required',
            'cell_phone' => 'required',
            'user_type' => 'required',
            'country_id' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
      
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        //print_r($request->input('project_id'));die;
        DB::beginTransaction();

        $user_insert=UserProfile::create($request->all());

        if($request->input('legal_name'))
        {
            $company_insert=UserCompany::create($request->all());
        }
        else
        {
            $company_insert=true;
        }

        if($request->input('fm_legal_name'))
        {
            $ownerOthorizePerson_insert=OwnerOthorizePerson::create($request->all());
        }
        else
        {
            $ownerOthorizePerson_insert=true;
        }

        $data_vehicle=array();
        foreach($request->vihicle_info_arr as $key=>$vihicle_info)
        {
            if(!empty($vihicle_info['link']))
            {

                $data_vehicle[]= array(
                    'project_id'            =>$project_id,
                    'user_id'               =>$user_id,
                    'vihicle_model_no'      =>$vihicle_info['vihicle_model_no'],
                    'vihicle_model_year'    =>$vihicle_info['vihicle_model_year'],
                    'vihicle_color'         =>$vihicle_info['vihicle_color'],
                    'vihicle_plate_no'      =>$vihicle_info['vihicle_plate_no'],
                    'vihicle_ins_exp_date'  =>$vihicle_info['vihicle_ins_exp_date'],

                    'inserted_by'           =>$user_id,
                    'created_at'            => date('Y-m-d H:i:s'),
                    'updated_at'            => date('Y-m-d H:i:s')              
                ); 

            }
        }

        $vehicle_insert=true;
        if(!empty($data_vehicle))
        {
            $vehicle_insert=UserVehicle::insert($data_vehicle);
        }


        if($request->input('permit_start') || $request->input('license_start') || $request->input('liability_start') || $request->input('permit_start') || $request->input('permit_start'))
        {
            if($request->input('permit_start'))  
                $request->merge(['permit_start'                 =>date("Y-m-d",strtotime($request->input('permit_start')))]);
            if($request->input('permit_end')) 
                $request->merge(['permit_end'                   =>date("Y-m-d",strtotime($request->input('permit_end')))]);
            if($request->input('permit_expire_date')) 
                $request->merge(['permit_expire_date'           =>date("Y-m-d",strtotime($request->input('permit_expire_date')))]);

            if($request->input('license_start')) 
                $request->merge(['license_start'                =>date("Y-m-d",strtotime($request->input('license_start')))]);
            if($request->input('license_end')) 
                $request->merge(['license_end'                  =>date("Y-m-d",strtotime($request->input('license_end')))]);
            if($request->input('license_expire_date')) 
                $request->merge(['license_expire_date'          =>date("Y-m-d",strtotime($request->input('license_expire_date')))]);

            if($request->input('liability_start'))  
                $request->merge(['liability_start'              =>date("Y-m-d",strtotime($request->input('liability_start')))]);
            if($request->input('liability_end')) 
                $request->merge(['liability_end'                =>date("Y-m-d",strtotime($request->input('liability_end')))]);
            if($request->input('liability_expire_date')) 
                $request->merge(['liability_expire_date'        =>date("Y-m-d",strtotime($request->input('liability_expire_date')))]);

            if($request->input('home_insurence_start')) 
                $request->merge(['home_insurence_start'         =>date("Y-m-d",strtotime($request->input('home_insurence_start')))]);
            if($request->input('home_insurence_end')) 
                $request->merge(['home_insurence_end'           =>date("Y-m-d",strtotime($request->input('home_insurence_end')))]);
            if($request->input('home_insurence_expire_date')) 
                $request->merge(['home_insurence_expire_date'   =>date("Y-m-d",strtotime($request->input('home_insurence_expire_date')))]);

            if($request->input('car_insurence_start')) 
                $request->merge(['car_insurence_start'          =>date("Y-m-d",strtotime($request->input('car_insurence_start')))]);
            if($request->input('car_insurence_end')) 
                $request->merge(['car_insurence_end'            =>date("Y-m-d",strtotime($request->input('car_insurence_end')))]);
            if($request->input('car_insurence_expire_date')) 
                $request->merge(['car_insurence_expire_date'    =>date("Y-m-d",strtotime($request->input('car_insurence_expire_date')))]);
            //date("Y-m-d",strtotime($request->input('permit_start'))
            $licenseInsurence_insert=UserLicenseInsurence::create($request->all());
        }
        else
        {
            $licenseInsurence_insert=true;
        }


        if($user_insert && $company_insert && $ownerOthorizePerson_insert && $vehicle_insert && $licenseInsurence_insert)
        {
           DB::commit();
           return 1;
        }
        else
        {
            DB::rollBack();
           return 10;
        }
        die;
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
