<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountCompany as AccountCompany;
use App\Models\AccountContactPerson as AccountContactPerson;
use Illuminate\Support\Facades\DB;
use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\Country as Country;
use App\Models\Project as Project;



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
        $data['year_arr']                   =$year_arr;
        $project_id                         = \Auth::user()->project_id;
        $user_id                            = \Auth::user()->id;
        $company_data                       =AccountCompany::where('project_id',$project_id)->where('status_active',1)->get();
        $data['company_data']               =array();
        $property_code_sql=Project::where('id',$project_id)->get();
        $account_no=date("Y",strtotime($property_code_sql[0]->created_at))."-".str_pad($property_code_sql[0]->property_code, 5, 0, STR_PAD_LEFT);

        $data['account_no']                 =$account_no;
        foreach($company_data as $key=>$val)
        {
            $data['company_data']['id']                             =$val->id;
            $data['company_data']['company_logo_id']                =$val->company_logo_id;
            $data['company_data']['id']                             =$val->id;
            $data['company_data']['legal_name']                     =$val->legal_name;
            $data['company_data']['headoffice_house_number']        =$val->headoffice_house_number;
            $data['company_data']['headoffice_street_number']       =$val->headoffice_street_number;
            $data['company_data']['headoffice_city']                =$val->headoffice_city;
            $data['company_data']['headoffice_state']               =$val->headoffice_state;
            $data['company_data']['headoffice_country']             =$val->headoffice_country;
            $data['company_data']['contact_person_fax_no']          =$val->contact_person_fax_no;
            $data['company_data']['contact_person_cell_phone']      =$val->contact_person_cell_phone;
            $data['company_data']['contact_person_website']         =$val->contact_person_website;
            $data['company_data']['contact_person_email']           =$val->contact_person_email;

            if($value->company_logo_id)
            {
                $data['company_data']['photo_path']                 =url('/storage/uploads/'.$value->companylogo->image_name);
            }
            else
            {
                $data['company_data']['photo_path']                 ="";
            }

        }
        return $data;
    }


    public function store(Request $request)
    {
        request()->validate([
            'legal_name'                        => 'required',
            'headoffice_house_number'           => 'required',
            'headoffice_street_number'          => 'required',
            'headoffice_city'                   => 'required',
            'headoffice_state'                  => 'required',
            'headoffice_country'                => 'required',
            'contact_person_email'              => 'required',
            'contact_person_fax_no'             => 'required',
            'contact_person_cell_phone'         => 'required',
            'contact_person_website'            => 'required',
             
        ]);



        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);


        DB::beginTransaction();

        $company_insert=AccountCompany::create($request->all());

        $user_project=Project::find($project_id)->update(array('project_status' => 105));

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
            'legal_name'                        => 'required',
            'headoffice_house_number'           => 'required',
            'headoffice_street_number'          => 'required',
            'headoffice_city'                   => 'required',
            'headoffice_state'                  => 'required',
            'headoffice_country'                => 'required',
            'contact_person_email'              => 'required',
            'contact_person_fax_no'             => 'required',
            'contact_person_cell_phone'         => 'required',
            'contact_person_website'            => 'required',
             
        ]);


        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['updated_by'               =>$user_id]);

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
