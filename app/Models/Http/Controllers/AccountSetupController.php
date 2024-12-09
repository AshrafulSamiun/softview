<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountCompany as AccountCompany;
use App\AccountContactPerson as AccountContactPerson;
use Illuminate\Support\Facades\DB;
use App\Classes\ArrayFunction as ArrayFunction;
use App\Country as Country;
use App\Project as Project;
use App\keyPositionLavel as keyPositionLavel;
use App\keyPosition as keyPosition;



class AccountSetupController extends Controller
{
    public function index()
    {
        $ArrayFunction                      =new ArrayFunction();
        $row_status                         =$ArrayFunction->row_status;
        $year_arr                           =$ArrayFunction->year_arr;
        $country                            =Country::where('status_active',1)->get();


        foreach ($country as $key => $value) {
            $country_arr[$value->id]        =$value->country_name;
            $country_code_arr[$value->id]   =$value->country_code;
        }


       

        $data['country_arr']                =$country_arr;
        $data['row_status']                 =$row_status;
      
        $data['year_arr']                   =$year_arr;
        $project_id                         = \Auth::user()->project_id;
        $user_id                            = \Auth::user()->id;


        $key_position_lavel=keyPositionLavel::where('status_active',1)
                                    ->whereIn('project_id',[0,$project_id])
                                    ->where('page_id',1)
                                    ->get();
        foreach ($key_position_lavel as $key => $value) {
            $key_position_lavel_arr[$value->id]['reference_id']        =$value->id;
            $key_position_lavel_arr[$value->id]['reference_value']     =$value->field_name;
            $key_position_lavel_arr[$value->id]['key_position_name']   ='';
            $key_position_lavel_arr[$value->id]['office_phone']        ='';
            $key_position_lavel_arr[$value->id]['email']               ='';
            $key_position_lavel_arr[$value->id]['id']                  ='';
        }



        $key_position_lavel=keyPosition::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('page_id',1)
                                    ->get();
        
        foreach ($key_position_lavel as $key => $value) {
            $key_position_lavel_arr[$value->reference_id]['reference_id']        =$value->reference_id;
            $key_position_lavel_arr[$value->reference_id]['reference_value']     =$value->reference_value;
            $key_position_lavel_arr[$value->reference_id]['key_position_name']   =$value->key_position_name;
            $key_position_lavel_arr[$value->reference_id]['office_phone']        =$value->office_phone;
            $key_position_lavel_arr[$value->reference_id]['email']               =$value->email;
            $key_position_lavel_arr[$value->reference_id]['id']                  =$value->id;
            
        }
      
        $sl=0;
        foreach ($key_position_lavel_arr as $key => $value) {
            $key_position_lavel_temp_arr[$sl]['reference_id']        =$value['reference_id'];
            $key_position_lavel_temp_arr[$sl]['reference_value']     =$value['reference_value'];
            $key_position_lavel_temp_arr[$sl]['key_position_name']   =$value['key_position_name'];
            $key_position_lavel_temp_arr[$sl]['office_phone']        =$value['office_phone'];
            $key_position_lavel_temp_arr[$sl]['email']               =$value['email'];
            $key_position_lavel_temp_arr[$sl]['id']                  =$value['id'];
            $sl++;
        }



        $data['key_position_lavel_arr']        =$key_position_lavel_temp_arr;

        $company_data                       =AccountCompany::where('project_id',$project_id)->where('status_active',1)->get();
        $data['company_data']               =array();
        $property_code_sql=Project::where('id',$project_id)->get(['property_code']);
        $account_no=$property_code_sql[0]->property_code;

        $data['account_no']                 =$account_no;
        foreach($company_data as $key=>$val)
        {
            $data['company_data']['id']                                         =$val->id;

            $data['company_data']['business_registration_number']               =$val->business_registration_number;
            $data['company_data']['business_registration_date']                 =$val->business_registration_date;
            $data['company_data']['business_registration_city']                 =$val->business_registration_city;
            $data['company_data']['business_registration_state']                =$val->business_registration_state;
            $data['company_data']['business_registration_country']              =$val->business_registration_country;
            $data['company_data']['business_registration_zip_code']             =$val->business_registration_zip_code;

            
            $data['company_data']['license_no']                                 =$val->license_no;
            $data['company_data']['license_date']                               =$val->license_date;
            $data['company_data']['license_issuer']                             =$val->license_issuer;
            $data['company_data']['license_country']                            =$val->license_country;
            $data['company_data']['license_expirey_date']                       =$val->license_expirey_date;
            $data['company_data']['id']                                         =$val->id;
            $data['company_data']['legal_name']                                 =$val->legal_name;
            $data['company_data']['zip_code']                                   =$val->zip_code;
            $data['company_data']['state']                                      =$val->state;
            $data['company_data']['country']                                    =$val->country;
            $data['company_data']['city']                                       =$val->city;
            $data['company_data']['website']                                    =$val->website;
            $data['company_data']['contact_person_email']                       =$val->contact_person_email;
            $data['company_data']['position_in_company']                        =$val->position_in_company;
            $data['company_data']['contact_person_cell_phone']                  =$val->contact_person_cell_phone;
            $data['company_data']['contact_person_name']                        =$val->contact_person_name;

        }
        return $data;
    }


    public function store(Request $request)
    {
        request()->validate([
            'legal_name'                        => 'required',
            'business_registration_number'      => 'required',
            'business_registration_zip_code'    => 'required',
            'business_registration_city'        => 'required',
            'business_registration_state'       => 'required',
            'business_registration_country'     => 'required',
            'license_no'                        => 'required',
            'license_issuer'                    => 'required',
            'license_date'                      => 'required',
            'license_expirey_date'              => 'required',
            'zip_code'                          => 'required',
            'city'                              => 'required',
            'state'                             => 'required',
            'country'                           => 'required',
            'website'                           =>'required',
            'contact_person_email'              => 'required',
            'contact_person_name'               => 'required',
            'contact_person_cell_phone'         => 'required',
            'position_in_company'               => 'required',
            
             
        ]);


        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
       
        $license_date                           =date("Y-m-d",strtotime($request->input('license_date')));
        $license_expirey_date                   =date("Y-m-d",strtotime($request->input('license_expirey_date')));
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);
        $request->merge(['license_date'         =>$license_date]);
        $request->merge(['license_expirey_date' =>$license_expirey_date]);

        //dd($request->all());
        DB::beginTransaction();

        $company_insert=AccountCompany::create($request->all());

        $user_project=Project::find($project_id)->update(array('project_status' => 103));

        foreach($request->key_management_list_arr as $key=>$details)
        {
            if($details['key_position_name']!="")
            {
                $data_key_position[]= array(
                    'project_id'                =>$project_id,
                    'page_id'                   =>1,
                    'master_id'                 =>$company_insert->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_value'           =>$details['reference_value'],
                    'office_phone'              =>$details['office_phone'],
                    'key_position_name'         =>$details['key_position_name'],
                    'email'                     =>$details['email'],
                    'inserted_by'               =>$user_id,
                );  
            }        
        }
        $RId2=true;
        if($data_key_position)
        {
            $RId2=keyPosition::insert($data_key_position);
        }

        if( $company_insert && $user_project && $RId2)
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



    public function update(Request $request, $id)
    {
        request()->validate([
            'legal_name'                        => 'required',
            'business_registration_number'      => 'required',
            'business_registration_zip_code'    => 'required',
            'business_registration_city'        => 'required',
            'business_registration_state'       => 'required',
            'business_registration_country'     => 'required',
            'license_no'                        => 'required',
            'license_issuer'                    => 'required',
            'license_date'                      => 'required',
            'license_expirey_date'              => 'required',
            'zip_code'                          => 'required',
            'city'                              => 'required',
            'state'                             => 'required',
            'country'                           => 'required',
            'website'                           =>'required',
            'contact_person_email'              => 'required',
            'contact_person_name'               => 'required',
            'contact_person_cell_phone'         => 'required',
            'position_in_company'               => 'required',
            
             
        ]);


        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['updated_by'               =>$user_id]);
        $license_date                           =date("Y-m-d",strtotime($request->input('license_date')));
        $license_expirey_date                   =date("Y-m-d",strtotime($request->input('license_expirey_date')));

        $request->merge(['license_date'         =>$license_date]);
        $request->merge(['license_expirey_date' =>$license_expirey_date]);
        DB::beginTransaction();

        $company_update                             =AccountCompany::find($id)->update($request->all());

        foreach($request->key_management_list_arr as $key=>$details)
        {
            if($details['key_position_name']!="")
            {
                if($details['id']!="")
                {
                    $key_position_data= array(
                        'project_id'                =>$project_id,
                        'page_id'                   =>1,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'reference_value'           =>$details['reference_value'],
                        'office_phone'              =>$details['office_phone'],
                        'key_position_name'         =>$details['key_position_name'],
                        'email'                     =>$details['email'],
                        'updated_by'                =>$user_id,
                    ); 

                    $RId4=keyPosition::where('id',"=",$details['id'])->update($key_position_data);

                }
                else{

                    $data_key_position[]= array(
                        'project_id'                =>$project_id,
                        'page_id'                   =>1,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'reference_value'           =>$details['reference_value'],
                        'office_phone'              =>$details['office_phone'],
                        'key_position_name'         =>$details['key_position_name'],
                        'email'                     =>$details['email'],
                        'inserted_by'               =>$user_id,
                    );

                }  
            }        
        }
        $RId2=true;
        if($data_key_position )
        {
            $RId2=keyPosition::insert($data_key_position);
        }
    

        if($company_update && $RId2)
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
}
