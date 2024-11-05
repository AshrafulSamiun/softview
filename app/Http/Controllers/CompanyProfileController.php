<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\Company as Company;
use App\Models\CompanyGovernmentAccount as companyGovernmentAccount;
use App\Models\Country as Country;
use App\Models\GovernmentAccountLavel as GovernmentAccountLavel;
use App\Models\KeyPosition as keyPosition;
use App\Models\KeyPositionLavel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyProfileController extends Controller
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
        $account_arr                =$ArrayFunction->row_status;
        $payment_term_arr           =$ArrayFunction->payment_term;
        $currency_arr               =$ArrayFunction->currency;
        $data['account_status_arr'] =$account_arr;
        $data['currency_arr']       =$currency_arr;
        $data['payment_term_arr']   =$payment_term_arr;
        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
            $country_code_arr[$value->id]=$value->country_code;
        }
        $data['country_arr']        =$country_arr;


        $key_position_lavel=KeyPositionLavel::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('page_id',1)
                                    ->get();
        $sl=0;
        foreach ($key_position_lavel as $key => $value) {
            $key_position_lavel_arr[$sl]['id']          =$value->id;
            $key_position_lavel_arr[$sl]['field_name']  =$value->field_name;
            $sl++;
        }
        $data['key_position_lavel_arr']        =$key_position_lavel_arr;



        $government_account_lavel   =GovernmentAccountLavel::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('page_id',1)
                                    ->get();
        $sl=0;
        foreach ($government_account_lavel as $key => $value) {
            $government_account_lavel_arr[$sl]['id']          =$value->id;
            $government_account_lavel_arr[$sl]['field_name']  =$value->field_name;
            $sl++;
        }
        $data['government_account_lavel_arr']        =$government_account_lavel_arr;


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
            'legal_name'                        => 'required',
            'scope_of_operation'                => 'required',      
            'business_registration_number'      => 'required',
            'registration_date'                 => 'required',
            'business_registration_city'        => 'required',
            'business_registration_state'       => 'required',
            'registration_country'              => 'required',
            'business_license_no'               => 'required',
            'issued_by'                         => 'required',
            'license_state'                     => 'required',
            'license_country'                   => 'required',
            'expirey_date'                      => 'required',
            'headoffice_house_number'           => 'required',
            'headoffice_street_number'          => 'required',
            'headoffice_city'                   => 'required',
            'headoffice_state'                  => 'required',
            'headoffice_country'                => 'required',
            'headoffice_zip_code'               => 'required',

            'contact_person_email'              => 'required',
            'contact_person_fax_no'             => 'required',
            'contact_person_cell_phone'         => 'required',
            'contact_person_website'            => 'required',
            'fiscal_year_start_date'            => 'required',
            'fiscal_year_end_date'              => 'required',
            'recuring_cycle'                    => 'required',
            //'comment_date'                      => 'required',

        ]);



                  

                  

        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['inserted_by'              =>$user_id]);
        $request->merge(['project_id'               =>$project_id]);
        $registration_date                          =date("Y-m-d",strtotime($request->input('registration_date')));
        $expirey_date                               =date("Y-m-d",strtotime($request->input('expirey_date')));
        $fiscal_year_start_date                     =date("Y-m-d",strtotime($request->input('fiscal_year_start_date')));
        $fiscal_year_end_date                       =date("Y-m-d",strtotime($request->input('fiscal_year_end_date')));
        if($request->input('comment_date'))
        {
            $comment_date                               =date("Y-m-d",strtotime($request->input('comment_date')));
            $request->merge(['comment_date'             =>$comment_date]);

        }

        $request->merge(['registration_date'        =>$registration_date]);
        $request->merge(['expirey_date'             =>$expirey_date]);
        $request->merge(['fiscal_year_start_date'   =>$fiscal_year_start_date]);
        $request->merge(['fiscal_year_end_date'     =>$fiscal_year_end_date]);
       // $request->merge(['comment_date'             =>$comment_date]);
        //$request->merge(['account_no'               =>555555]);
       // $request->merge(['main_company_name'        =>0]);
        $current_year=date('Y');

        $max_account_data = Company::whereRaw('account_prefix=(select max(account_prefix) as account_prefix from companies where project_id='.$project_id.'
         and YEAR(created_at)='.date('Y').' ) and project_id='.$project_id.' and YEAR(created_at)='.date('Y'))->get(['account_prefix']);

        if(count($max_account_data)>0)
        {
            $max_account_prefix=$max_account_data[0]->account_prefix+1; 
        }
        else
        {
               $max_account_prefix=1; 
        }

        $account_no=$current_year."-".str_pad($max_account_prefix, 4, 0, STR_PAD_LEFT);
        $request->merge(['account_no'               =>$account_no]);
        $request->merge(['account_prefix'           =>$max_account_prefix]);




        DB::beginTransaction();
        $RId1=true;
        $RId2=true;
        $RId3=true;
        $company_insert=Company::create($request->all());

        foreach($request->government_account_lavel_data as $key=>$details)
        {
            if($details['account_number']!="")
            {
                if($details['reference_id'])
                {
                    $data_government[]= array(
                        'project_id'                =>$project_id,
                        'page_id'                   =>1,
                        'master_id'                 =>$company_insert->id,
                        'reference_id'              =>$details['reference_id'],
                        'reference_value'           =>$details['reference_value'],
                        'account_number'            =>$details['account_number'],
                        'filling_date'              =>date("Y-m-d",strtotime($details['filling_date'])),
                        'filling_cycle'             =>$details['filling_cycle'],
                        'is_callender'              =>$details['is_callender'],
                        'inserted_by'               =>$user_id,
                    );
                }
                else
                {
                    $data_government_level = new GovernmentAccountLavel;
 
                    $data_government_level->project_id      = $project_id;
                    $data_government_level->page_id         = 1;
                    $data_government_level->field_name      = $details['reference_value'];
                    $data_government_level->inserted_by     = $user_id;
             
                    $data_government_level->save();
                    

                  
                    $data_government[]= array(
                        'project_id'                =>$project_id,
                        'page_id'                   =>1,
                        'master_id'                 =>$company_insert->id,
                        'reference_id'              =>$data_government_level->id,
                        'reference_value'           =>$details['reference_value'],
                        'account_number'            =>$details['account_number'],
                        'filling_date'              =>date("Y-m-d",strtotime($details['filling_date'])),
                        'filling_cycle'             =>$details['filling_cycle'],
                        'is_callender'              =>$details['is_callender'],
                        'inserted_by'               =>$user_id,
                    );
                }
                

            }
                      
        }
       
        foreach($request->key_position_lavel_data as $key=>$details)
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
                    'office_mobile'             =>$details['office_mobile'],
                    'fax'                       =>$details['fax'],
                    'key_position_name'         =>$details['key_position_name'],
                    'email'                     =>$details['email'],
                    'inserted_by'               =>$user_id,
                );  
            }        
        }

        if($data_government)
        {
            $RId1=CompanyGovernmentAccount::insert($data_government);
        }

         if($data_key_position)
        {
            $RId2=KeyPosition::insert($data_key_position);
        }

        


        if( $company_insert && $RId1 && $RId2)
        {
           DB::commit();
           return "1**$company_insert->id**$account_no";
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
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $account_arr                =$ArrayFunction->row_status;
        $payment_term_arr           =$ArrayFunction->payment_term;
        $currency_arr               =$ArrayFunction->currency;
        $data['account_status_arr'] =$account_arr;
        $data['currency_arr']       =$currency_arr;
        $data['payment_term_arr']   =$payment_term_arr;
        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
            $country_code_arr[$value->id]=$value->country_code;
        }
        $data['country_arr']        =$country_arr;      

        $company_data               =Company::where('status_active',1)
                                    ->where('id',$id)
                                    ->get();
        $data['company_data']        =$company_data;


        

        $government_account_data   =CompanyGovernmentAccount::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('master_id',$id)
                                    ->where('page_id',1)
                                    ->get();

        $data["government_account_data_arr"]=array();
        $government_account_data_arr=array();
        $gsl=0;
        $gin_arr=array();
        foreach ($government_account_data as $key => $value) {

            $government_account_data_arr[$value->reference_id]['id']                =$value->id;
            $government_account_data_arr[$value->reference_id]['reference_id']      =$value->reference_id;
            $government_account_data_arr[$value->reference_id]['reference_value']   =$value->reference_value;
            $government_account_data_arr[$value->reference_id]['account_number']    =$value->account_number;
            $government_account_data_arr[$value->reference_id]['filling_date']      =$value->filling_date;
            $government_account_data_arr[$value->reference_id]['filling_cycle']     =$value->filling_cycle;
            $government_account_data_arr[$value->reference_id]['is_callender']      =$value->is_callender;
            $government_account_data_arr[$value->reference_id]['master_id']         =$value->master_id;
            $gin_arr[$value->reference_id]=$value->reference_id;
            
        }

        $government_account_lavel=GovernmentAccountLavel::where('status_active',1)
                                    ->where('page_id',1)
                                    ->whereNotIn('id',$gin_arr)
                                    ->get();
        
        foreach ($government_account_lavel as $key => $value) {
            //if(!in_array($value->id,$government_account_data_arr))
           // {
                $government_account_data_arr[$value->id]['id']                  ='';
                $government_account_data_arr[$value->id]['reference_id']        =$value->id;
                $government_account_data_arr[$value->id]['reference_value']     =$value->field_name;
                $government_account_data_arr[$value->id]['account_number']      ="";
                $government_account_data_arr[$value->id]['filling_date']        ="";
                $government_account_data_arr[$value->id]['filling_cycle']       ="";
                $government_account_data_arr[$value->id]['is_callender']        =0;
                $government_account_data_arr[$value->id]['master_id']           ="";

            //}
        }

        ksort($government_account_data_arr); 

        foreach ($government_account_data_arr as $key => $value) {
           

            $data["government_account_data_arr"][$gsl]['id']                =$value["id"];
            $data["government_account_data_arr"][$gsl]['reference_id']      =$value["reference_id"];
            $data["government_account_data_arr"][$gsl]['reference_value']   =$value["reference_value"];
            $data["government_account_data_arr"][$gsl]['account_number']    =$value["account_number"];
            $data["government_account_data_arr"][$gsl]['filling_date']      =$value["filling_date"];
            $data["government_account_data_arr"][$gsl]['filling_cycle']     =$value["filling_cycle"];
            $data["government_account_data_arr"][$gsl]['is_callender']      =$value["is_callender"];
            $data["government_account_data_arr"][$gsl]['master_id']         =$value["master_id"];
            $gsl++;
        }

        // =======================================key position data=================================================
        $key_position_lavel=KeyPositionLevel::where('status_active',1)
                                    ->where('page_id',1)
                                    ->get();
        $data["key_position_data_arr"]=array();
        $key_position_data_arr=array();
        foreach ($key_position_lavel as $key => $value) {
           
            $key_position_data_arr[$value->id]['id']                    ='';
            $key_position_data_arr[$value->id]['reference_id']          =$value->id;
            $key_position_data_arr[$value->id]['reference_value']       =$value->field_name;
            $key_position_data_arr[$value->id]['office_phone']          ="";
            $key_position_data_arr[$value->id]['office_mobile']         ="";
            $key_position_data_arr[$value->id]['fax']                   ="";
            $key_position_data_arr[$value->id]['email']                 ="";
            $key_position_data_arr[$value->id]['key_position_name']     ="";
            $key_position_data_arr[$value->id]['master_id']             ="";
               
        }

        $keyPosition_data   =KeyPosition::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('master_id',$id)
                                    ->where('page_id',1)
                                    ->get();
        
        foreach ($keyPosition_data as $key => $value) {

            $key_position_data_arr[$value->reference_id]['id']                    =$value->id;
            $key_position_data_arr[$value->reference_id]['reference_id']          =$value->reference_id;
            $key_position_data_arr[$value->reference_id]['reference_value']       =$value->reference_value;
            $key_position_data_arr[$value->reference_id]['office_phone']          =$value->office_phone;
            $key_position_data_arr[$value->reference_id]['office_mobile']         =$value->office_mobile;
            $key_position_data_arr[$value->reference_id]['fax']                   =$value->fax;
            $key_position_data_arr[$value->reference_id]['email']                 =$value->email;
            $key_position_data_arr[$value->reference_id]['key_position_name']     =$value->key_position_name;
            $key_position_data_arr[$value->reference_id]['master_id']             =$value->master_id;
            
        }

        
        
        

        ksort($key_position_data_arr); 
         $gsl=0;
        foreach ($key_position_data_arr as $key => $value) {
           

            $data["key_position_data_arr"][$gsl]['id']                  =$value["id"];
            $data["key_position_data_arr"][$gsl]['reference_id']        =$value["reference_id"];
            $data["key_position_data_arr"][$gsl]['reference_value']     =$value["reference_value"];
            $data["key_position_data_arr"][$gsl]['key_position_name']   =$value["key_position_name"];
            $data["key_position_data_arr"][$gsl]['office_phone']        =$value["office_phone"];
            $data["key_position_data_arr"][$gsl]['office_mobile']       =$value["office_mobile"];
            $data["key_position_data_arr"][$gsl]['fax']                 =$value["fax"];
            $data["key_position_data_arr"][$gsl]['email']               =$value["email"];
            $data["key_position_data_arr"][$gsl]['master_id']           =$value["master_id"];
            $gsl++;
        }

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
            'legal_name'                        => 'required',
            'scope_of_operation'                => 'required',      
            'business_registration_number'      => 'required',
            'registration_date'                 => 'required',
            'business_registration_city'        => 'required',
            'business_registration_state'       => 'required',
            'registration_country'              => 'required',
            'business_license_no'               => 'required',
            'issued_by'                         => 'required',
            'license_state'                     => 'required',
            'license_country'                   => 'required',
            'expirey_date'                      => 'required',
            'headoffice_house_number'           => 'required',
            'headoffice_street_number'          => 'required',
            'headoffice_city'                   => 'required',
            'headoffice_state'                  => 'required',
            'headoffice_country'                => 'required',
            'headoffice_zip_code'               => 'required',
            'contact_person_email'              => 'required',
            'contact_person_fax_no'             => 'required',
            'contact_person_cell_phone'         => 'required',
            'contact_person_website'            => 'required',
            'fiscal_year_start_date'            => 'required',
            'fiscal_year_end_date'              => 'required',
            'recuring_cycle'                    => 'required',
            //'comment_date'                      => 'required',

        ]);



                  

                  

        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;

        $request->merge(['updated_by'               =>$user_id]);
        $registration_date                          =date("Y-m-d",strtotime($request->input('registration_date')));
        $expirey_date                               =date("Y-m-d",strtotime($request->input('expirey_date')));
        $fiscal_year_start_date                     =date("Y-m-d",strtotime($request->input('fiscal_year_start_date')));
        $fiscal_year_end_date                       =date("Y-m-d",strtotime($request->input('fiscal_year_end_date')));
        

        $request->merge(['registration_date'        =>$registration_date]);
        $request->merge(['expirey_date'             =>$expirey_date]);
        $request->merge(['fiscal_year_start_date'   =>$fiscal_year_start_date]);
        $request->merge(['fiscal_year_end_date'     =>$fiscal_year_end_date]);
      
        

        DB::beginTransaction();
        $RId1=true;
        $RId2=true;
        $RId3=true;
        $RId4=true;
        $company_update=Company::find($id)->update($request->all());
        $data_government=array();
        foreach($request->government_account_lavel_data as $key=>$details)
        {
            if($details['account_number']!="")
            {
                if($details['id'])
                {
                    $data_government_account= array(
                        'account_number'            =>$details['account_number'],
                        'filling_date'              =>date("Y-m-d",strtotime($details['filling_date'])),
                        'filling_cycle'             =>$details['filling_cycle'],
                        'is_callender'              =>$details['is_callender'],
                        'updated_by'                =>$user_id,
                    );

                    $RId3=CompanyGovernmentAccount::where('id',"=",$details['id'])->update($data_government_account);

                }
                else if($details['reference_id'])
                {
                    $data_government[]= array(
                        'project_id'                =>$project_id,
                        'page_id'                   =>1,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'reference_value'           =>$details['reference_value'],
                        'account_number'            =>$details['account_number'],
                        'filling_date'              =>date("Y-m-d",strtotime($details['filling_date'])),
                        'filling_cycle'             =>$details['filling_cycle'],
                        'is_callender'              =>$details['is_callender'],
                        'inserted_by'               =>$user_id,
                    );
                }
                else
                {
                    $data_government_level = new GovernmentAccountLavel;
                    $data_government_level->project_id      = $project_id;
                    $data_government_level->page_id         = 1;
                    $data_government_level->field_name      = $details['reference_value'];
                    $data_government_level->inserted_by     = $user_id;
             
                    $data_government_level->save();
                    
                    $data_government[]= array(
                        'project_id'                =>$project_id,
                        'page_id'                   =>1,
                        'master_id'                 =>$id,
                        'reference_id'              =>$data_government_level->id,
                        'reference_value'           =>$details['reference_value'],
                        'account_number'            =>$details['account_number'],
                        'filling_date'              =>date("Y-m-d",strtotime($details['filling_date'])),
                        'filling_cycle'             =>$details['filling_cycle'],
                        'is_callender'              =>$details['is_callender'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
                      
        }
        $data_key_position=array();
        foreach($request->key_position_lavel_data as $key=>$details)
        {
            if($details['key_position_name']!="")
            {
                if($details['id'])
                {

                    $key_position_data= array(
                        'office_phone'              =>$details['office_phone'],
                        'office_mobile'             =>$details['office_mobile'],
                        'fax'                       =>$details['fax'],
                        'key_position_name'         =>$details['key_position_name'],
                        'email'                     =>$details['email'],
                        'updated_by'                =>$user_id,
                    ); 

                    $RId4=KeyPosition::where('id',"=",$details['id'])->update($key_position_data);

                }
                else
                {
                    $data_key_position[]= array(
                        'project_id'                =>$project_id,
                        'page_id'                   =>1,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'reference_value'           =>$details['reference_value'],
                        'office_phone'              =>$details['office_phone'],
                        'office_mobile'             =>$details['office_mobile'],
                        'fax'                       =>$details['fax'],
                        'key_position_name'         =>$details['key_position_name'],
                        'email'                     =>$details['email'],
                        'inserted_by'               =>$user_id,
                    ); 
                }
                 
            }        
        }

        if(!empty($data_government))
        {
            $RId1=CompanyGovernmentAccount::insert($data_government);
        }

        if(!empty($data_key_position))
        {
            $RId2=KeyPosition::insert($data_key_position);
        }

        


        if( $company_update && $RId1 && $RId2 && $RId3 && $RId4)
        {
           DB::commit();
           return "1**$id";
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
        DB::beginTransaction();

        $company_delete=Company::find($id)->update(array('status_active' => 2));
        $key_position_delete=KeyPosition::where('master_id',$id)
                                    ->where('page_id',1)
                                    ->update(array('status_active' => 2));
        $government_account_delete=CompanyGovernmentAccount::where('master_id',$id)
                                    ->where('page_id',1)
                                    ->update(array('status_active' => 2));
        if( $company_delete && $key_position_delete && $government_account_delete)
        {
           DB::commit();
           return "1**$id";
        }
        else
        {
            DB::rollBack();
            return 10;
        }
        die;

    }
}
