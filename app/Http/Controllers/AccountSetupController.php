<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\AccountCompany as AccountCompany;
use App\Models\Country as Country;
use App\Models\Project as Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AccountSetupController extends Controller
{
    public function index()
    {
        $ArrayFunction                      =new ArrayFunction();
        $row_status                         =$ArrayFunction->row_status;
        $user_type_arr                      =$ArrayFunction->user_type_arr;
        $year_arr                           =$ArrayFunction->year_arr;
        $country                            =Country::where('status_active',1)->get();


        foreach ($country as $key => $value) {
            $country_arr[$value->id]        =$value->country_name;
            $country_code_arr[$value->id]   =$value->country_code;
        }


        $data['country_arr']                =$country_arr;
        $data['row_status']                 =$row_status;
        $data['user_type_arr']              =$user_type_arr;
        $data['year_arr']                   =$year_arr;
        $project_id                         = \Auth::user()->project_id;
        $user_id                            = \Auth::user()->id;
        $company_data                       =AccountCompany::where('project_id',$project_id)->where('status_active',1)->get();
        $data['company_data']               =array();
        $property_code_sql=Project::where('id',$project_id)->get(['property_code']);
        $account_no=$property_code_sql[0]->property_code;

         $data['account_no']                 =$account_no;
        foreach($company_data as $key=>$val)
        {
            $data['company_data']['id']                                         =$val->id;
            $data['company_data']['company_logo_id']                            =$val->company_logo_id;
            $data['company_data']['strata_management']                          =$val->strata_management;
            $data['company_data']['coop_property']                              =$val->coop_property;
            $data['company_data']['free_hold_management']                       =$val->free_hold_management;
            $data['company_data']['leasehold_management']                       =$val->leasehold_management;
            $data['company_data']['property_management']                        =$val->property_management;
            $data['company_data']['business_registration_number']               =$val->business_registration_number;
            $data['company_data']['registration_date']                          =$val->registration_date;
            $data['company_data']['business_registration_city']                 =$val->business_registration_city;
            $data['company_data']['business_registration_state']                =$val->business_registration_state;
            $data['company_data']['registration_country']                       =$val->registration_country;
            $data['company_data']['business_license_no']                        =$val->business_license_no;
            $data['company_data']['issued_by']                                  =$val->issued_by;
            $data['company_data']['license_country']                            =$val->license_country;
            $data['company_data']['expirey_date']                               =$val->expirey_date;
            $data['company_data']['id']                                         =$val->id;
            $data['company_data']['legal_name']                                 =$val->legal_name;
            $data['company_data']['head_office_email']                          =$val->head_office_email;
            $data['company_data']['head_office_fax_no']                         =$val->head_office_fax_no;
            $data['company_data']['head_office_cell_phone']                     =$val->head_office_cell_phone;
            $data['company_data']['head_office_website']                        =$val->head_office_website;
            $data['company_data']['contact_person_email']                       =$val->contact_person_email;
            $data['company_data']['contact_person_fax_no']                      =$val->contact_person_fax_no;
            $data['company_data']['contact_person_cell_phone']                  =$val->contact_person_cell_phone;
            $data['company_data']['contact_person_website']                     =$val->contact_person_website;
            $data['company_data']['business_number']                            =$val->business_number;
            $data['company_data']['emp_identification_number']                  =$val->emp_identification_number;
            $data['company_data']['payroll']                                    =$val->payroll;
            $data['company_data']['sales_tax']                                  =$val->sales_tax;
            $data['company_data']['income_tax']                                 =$val->income_tax;
            $data['company_data']['import_and_export']                          =$val->import_and_export;
            $data['company_data']['dependent_residential_suite']                =$val->dependent_residential_suite;
            $data['company_data']['dependent_residental_parking_lot']           =$val->dependent_residental_parking_lot;
            $data['company_data']['dependent_residental_storage_lot']           =$val->dependent_residental_storage_lot;
            $data['company_data']['dependent_commercial_unit']                  =$val->dependent_commercial_unit;
            $data['company_data']['dependent_commercial_parking_lot']           =$val->dependent_commercial_parking_lot;
            $data['company_data']['dependent_commercial_storage_lot']           =$val->dependent_commercial_storage_lot;
            $data['company_data']['independent_residential_suite']              =$val->independent_residential_suite;
            $data['company_data']['independent_residental_parking_lot']         =$val->independent_residental_parking_lot;
            $data['company_data']['independent_residental_storage_lot']         =$val->independent_residental_storage_lot;
            $data['company_data']['independent_commercial_unit']                =$val->independent_commercial_unit;
            $data['company_data']['independent_commercial_parking_lot']         =$val->independent_commercial_parking_lot;
            $data['company_data']['independent_commercial_storage_lot']         =$val->independent_commercial_storage_lot;
            $data['company_data']['rantal_suite_unit']                          =$val->rantal_suite_unit;
            $data['company_data']['buy_and_sell_suite_unit']                    =$val->buy_and_sell_suite_unit;
            $data['company_data']['rental_parking']                             =$val->rental_parking;
            $data['company_data']['rental_storage']                             =$val->rental_storage;
            $data['company_data']['landholders_residency']                      =$val->landholders_residency;
        }
        return $data;
    }


    public function store(Request $request)
    {
        request()->validate([
            'legal_name'                        => 'required',
            'business_registration_number'      => 'required',
            'registration_date'                 => 'required',
            'business_registration_city'        => 'required',
            'business_registration_state'       => 'required',
            'registration_country'              => 'required',
            'business_license_no'               => 'required',
            'issued_by'                         => 'required',
            'license_country'                   => 'required',
            'expirey_date'                      => 'required',
            'headoffice_street_number'          => 'required',
            'headoffice_city'                   => 'required',
            'headoffice_state'                  => 'required',
            'headoffice_country'                => 'required',
            'contact_person_email'              => 'required',
            'contact_person_fax_no'             => 'required',
            'contact_person_cell_phone'         => 'required',
            'contact_person_website'            => 'required',
            'business_number'                   => 'required',
            'emp_identification_number'         => 'required',
            'payroll'                           => 'required',
            'sales_tax'                         => 'required',
            'income_tax'                        => 'required',
            'import_and_export'                 => 'required',
             
        ]);



        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);
        $registration_date                      =date("Y-m-d",strtotime($request->input('registration_date')));
        $expirey_date                           =date("Y-m-d",strtotime($request->input('expirey_date')));

        $request->merge(['registration_date'    =>$registration_date]);
        $request->merge(['expirey_date'         =>$expirey_date]);



        DB::beginTransaction();

        $company_insert=AccountCompany::create($request->all());

        $user_project=Project::find($project_id)->update(array('project_status' => 99));



        if( $company_insert && $user_project)
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
            'legal_name'                            => 'required',
            'business_registration_number'          => 'required',
            'registration_date'                     => 'required',
            'business_registration_city'            => 'required',
            'business_registration_state'           => 'required',
            'registration_country'                  => 'required',
            'business_license_no'                   => 'required',
            'issued_by'                             => 'required',
            'license_country'                       => 'required',
            'expirey_date'                          => 'required',
            'head_office_email'                     => 'required',
            'head_office_fax_no'                    => 'required',
            'head_office_cell_phone'                => 'required',
            'head_office_website'                   => 'required',
            'contact_person_email'                  => 'required',
            'contact_person_fax_no'                 => 'required',
            'contact_person_cell_phone'             => 'required',
            'contact_person_website'                => 'required',
            'business_number'                       => 'required',
            'emp_identification_number'             => 'required',
            'payroll'                               => 'required',
            'sales_tax'                             => 'required',
            'income_tax'                            => 'required',
            'import_and_export'                     => 'required',
             
        ]);


        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['updated_by'               =>$user_id]);
        $registration_date                          =date("Y-m-d",strtotime($request->input('registration_date')));
        $expirey_date                               =date("Y-m-d",strtotime($request->input('expirey_date')));

        $request->merge(['registration_date'        =>$registration_date]);
        $request->merge(['expirey_date'             =>$expirey_date]);
        DB::beginTransaction();

        $company_update                             =AccountCompany::find($id)->update($request->all());


        



        if($company_update)
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
