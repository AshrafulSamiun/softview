<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\Country as Country;
use App\Models\Customer as Customer;
use App\Models\CustomerProperty as CustomerProperty;
use App\Models\CustomField as CustomField;
use App\Models\CustomFieldData as CustomFieldData;
use App\Models\KeyPosition as keyPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CustomerPropertyController extends Controller
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


        $key_position_lavel=KeyPositionLevel::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('page_id',4)
                                    ->get();
        $sl=0;
        foreach ($key_position_lavel as $key => $value) {
            $key_position_lavel_arr[$sl]['id']          =$value->id;
            $key_position_lavel_arr[$sl]['field_name']  =$value->field_name;
            $sl++;
        }
        $data['key_position_lavel_arr']        =$key_position_lavel_arr;

        $customfield=CustomField::where('page_id',4)
                            ->where('project_id',$project_id)
                            ->where('status_active',1)
                            ->get();
        $sl=0;
        $data['custom_fiend_level']=array();
        foreach ($customfield as $key => $value) {
            $data['custom_fiend_level'][$sl]['reference_id']          =$value->id;
            $data['custom_fiend_level'][$sl]['field_type']  =$value->field_type;
            $data['custom_fiend_level'][$sl]['field_name']  =$value->field_name;
            $data['custom_fiend_level'][$sl]['field_id']  ="custom_field_".$value->id;
            $sl++;
        }

        return $data;
    }


    public function loadCustomerByCompany($company_id)
    {
        $user=\Auth::user();
        
        $project_id                 = $user->project_id;
        if($company_id>0)
        {
            $customer_list          =Customer::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_id',$company_id)
                                    ->where('customer_type',1)
                                    ->get();
        }
        else{

            $customer_list          =Customer::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->whereNull('company_id')
                                    ->where('customer_type',1)
                                    ->get();
        }
        
        $customer_arr=array();
        foreach ($customer_list as $key => $value) {
            $customer_arr[$value->id]=$value->legal_name;
        }

        $data['customer_arr']        =$customer_arr;

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
            'account_status'                    => 'required',
            'customer_type'                     => 'required',
            'account_no'                        => 'required',
            'operational_name'                  => 'required',
           
            'headoffice_house_number'           => 'required',
            'headoffice_street_number'          => 'required',
            'headoffice_city'                   => 'required',
            'headoffice_state'                  => 'required',
            'headoffice_country'                => 'required',
            'headoffice_zip_code'               => 'required',

            'currency_domestic'                 => 'required',
            'invoice_term'                      => 'required',
            'sales_tax'                         => 'required',
            'credit_limit_daily'                => 'required',
            'credit_limit_weekly'               => 'required',
            'credit_limit_monthly'              => 'required',
            'credit_limit_semi_monthly'         => 'required',

            'credit_limit_yearly'               => 'required',
            'fiscal_year_start_date'            => 'required',
            'fiscal_year_end_date'              => 'required',
            'recuring_cycle'                    => 'required',

        ]);



                  

        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['inserted_by'              =>$user_id]);
        $request->merge(['page_id'                  =>4]);
        $request->merge(['project_id'               =>$project_id]);
        $fiscal_year_start_date                     =date("Y-m-d",strtotime($request->input('fiscal_year_start_date')));
        $fiscal_year_end_date                       =date("Y-m-d",strtotime($request->input('fiscal_year_end_date')));

        if($request->input('status_date'))
        {
            $status_date                               =date("Y-m-d",strtotime($request->input('status_date')));
            $request->merge(['status_date'             =>$status_date]);

        }

        if($request->input('comment_date'))
        {
            $comment_date                               =date("Y-m-d",strtotime($request->input('comment_date')));
            $request->merge(['comment_date'             =>$comment_date]);

        }

        $request->merge(['fiscal_year_start_date'   =>$fiscal_year_start_date]);
        $request->merge(['fiscal_year_end_date'     =>$fiscal_year_end_date]);
       
        $current_year=date('Y');

        $max_system_data = Customer::whereRaw('system_prefix=(select max(system_prefix) as system_prefix from customers where page_id=4 and 
            project_id='.$project_id.' ) and project_id='.$project_id.' and page_id=4')->get(['system_prefix']);
        //dd($max_system_data);die;
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="Prop-C-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);




        DB::beginTransaction();
        $RId1=true;
        $RId2=true;
        $RId3=true;
        $customer_insert=Customer::create($request->all());

        foreach($request->dadicated_property_data as $key=>$details)
        {
            if($details['property_code']!="")
            {
                $data_customer_property[]= array(
                    'project_id'                =>$project_id,
                    'page_id'                   =>4,
                    'master_id'                 =>$customer_insert->id,
                    'reference_id'              =>$details['reference_id'],
                    'reference_value'           =>$details['reference_value'],
                    'property_name'             =>$details['property_name'],
                    'country'                   =>$details['country'],
                    'state'                     =>$details['state'],
                    'city'                      =>$details['city'],
                    'property_code'             =>$details['property_code'],
                    'inserted_by'               =>$user_id,
                );
            }
        }
       
        foreach($request->key_position_lavel_data as $key=>$details)
        {
            if($details['key_position_name']!="")
            {
                $data_key_position[]= array(
                    'project_id'                =>$project_id,
                    'page_id'                   =>4,
                    'master_id'                 =>$customer_insert->id,
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
        $data_custom_field=array();
        foreach($request->custom_field as $key=>$details)
        {
            if($details['field_model']!="")
            {
                $text=NULL;
                $number=NULL;
                $date_time=NULL;
                if($details['field_type']==1 || $details['field_type']==2)
                {
                    $date_time=date("Y-m-d h:i:s",strtotime($details['field_model']));
                }

                if($details['field_type']==4 || $details['field_type']==6 || $details['field_type']==7)
                {
                    $number=$details['field_model'];
                }

                if($details['field_type']==3 || $details['field_type']==5 || $details['field_type']==8)
                {
                    $text=$details['field_model'];
                }
                $data_custom_field[]= array(
                    'project_id'                =>$project_id,
                    'page_id'                   =>4,
                    'master_id'                 =>$customer_insert->id,
                    'field_id'                  =>$details['reference_id'],
                    'field_type'                =>$details['field_type'],
                    'text'                      =>$text,
                    'number'                    =>$number,
                    'date_time'                 =>$date_time,
                    'inserted_by'               =>$user_id,
                );  
            }        
        }


        if($data_customer_property)
        {
            $RId1=CustomerProperty::insert($data_customer_property);
        }

        if($data_key_position)
        {
            $RId2=KeyPosition::insert($data_key_position);
        }

        if($data_custom_field)
        {
            $RId3=CustomFieldData::insert($data_custom_field);
        }


        if( $customer_insert && $RId1 && $RId2 && $RId3)
        {
           DB::commit();
           return "1**$customer_insert->id**$system_no";
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

        $customer_data               =Customer::where('status_active',1)
                                    ->where('id',$id)
                                    ->get();
        $data['customer_data']        =$customer_data;
       

        $customfield=CustomField::where('page_id',4)
                            ->where('project_id',$project_id)
                            ->where('status_active',1)
                            ->get();
        $sl=0;
        $data['custom_fiend_level']=array();
        $custom_fiend_level_arr=array();
        foreach ($customfield as $key => $value) {
            $custom_fiend_level_arr[$value->id]['id']                      ='';
            $custom_fiend_level_arr[$value->id]['reference_id']            =$value->id;
            $custom_fiend_level_arr[$value->id]['field_type']              =$value->field_type;
            $custom_fiend_level_arr[$value->id]['field_name']              =$value->field_name;
            $custom_fiend_level_arr[$value->id]['field_model']             ="";
            $custom_fiend_level_arr[$value->id]['field_id']                ="custom_field_".$value->id;
        }

        $customfieldData=CustomFieldData::where('page_id',4)
                            ->where('project_id',$project_id)
                            ->where('master_id',$id)
                            ->where('status_active',1)
                            ->get();
        
        foreach ($customfieldData as $key => $value) {
            $custom_fiend_level_arr[$value->field_id]['id']                      =$value->id;
            $custom_fiend_level_arr[$value->field_id]['reference_id']            =$value->field_id;
            $custom_fiend_level_arr[$value->field_id]['field_type']              =$value->field_type;
            $custom_fiend_level_arr[$value->field_id]['field_id']                ="custom_field_".$value->id;


             if($value->field_type==1 || $value->field_type==2)
                {
                    $custom_fiend_level_arr[$value->field_id]['field_model']        =$value->date_time;

                }

                if($value->field_type==4 || $value->field_type==6 || $value->field_type==7)
                {
                    $custom_fiend_level_arr[$value->field_id]['field_model']        =$value->number;

                }

                if($value->field_type==3 || $value->field_type==5 || $value->field_type==8)
                {
                    $custom_fiend_level_arr[$value->field_id]['field_model']        =$value->text;

                }
        }
            //dd($custom_fiend_level_arr);die;

        foreach ($custom_fiend_level_arr as $key => $value) {
            $data['custom_fiend_level'][$sl]['id']                      =$value["id"];
            $data['custom_fiend_level'][$sl]['reference_id']            =$value["reference_id"];
            $data['custom_fiend_level'][$sl]['field_type']              =$value["field_type"];
            $data['custom_fiend_level'][$sl]['field_name']              =$value["field_name"];
            $data['custom_fiend_level'][$sl]['field_id']                =$value["field_id"];
            $data['custom_fiend_level'][$sl]['field_model']                =$value["field_model"];
            $sl++;
        }

        // =======================================key position data=================================================
        $key_position_lavel=KeyPositionLevel::where('status_active',1)
                                    ->where('page_id',4)
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
                                    ->where('page_id',4)
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
           

            $data["key_position_data_arr"][$gsl]['id']                    =$value["id"];
            $data["key_position_data_arr"][$gsl]['reference_id']          =$value["reference_id"];
            $data["key_position_data_arr"][$gsl]['reference_value']       =$value["reference_value"];
            $data["key_position_data_arr"][$gsl]['office_phone']          =$value["office_phone"];
            $data["key_position_data_arr"][$gsl]['office_mobile']         =$value["office_mobile"];
            $data["key_position_data_arr"][$gsl]['fax']                   =$value["fax"];
            $data["key_position_data_arr"][$gsl]['email']                 =$value["email"];
            $data["key_position_data_arr"][$gsl]['key_position_name']     =$value["key_position_name"];
            $data["key_position_data_arr"][$gsl]['master_id']             =$value["master_id"];
            $gsl++;
        }

        // =======================================dedicated property data=================================================


       
        $data["dedicated_property_data_arr"]=array();
        $dedicated_property_data_arr=array();
        
           
        $dedicated_property_data_arr[1]['id']                    ='';
        $dedicated_property_data_arr[1]['reference_id']          =1;
        $dedicated_property_data_arr[1]['reference_value']       ="Building";
        $dedicated_property_data_arr[1]['property_name']          ="";
        $dedicated_property_data_arr[1]['country']         ="";
        $dedicated_property_data_arr[1]['state']                   ="";
        $dedicated_property_data_arr[1]['city']                 ="";
        $dedicated_property_data_arr[1]['property_code']     ="";
        $dedicated_property_data_arr[1]['master_id']             ="";

        $dedicated_property_data_arr[2]['id']                    ='';
        $dedicated_property_data_arr[2]['reference_id']          =2;
        $dedicated_property_data_arr[2]['reference_value']       ="Residential Suite";
        $dedicated_property_data_arr[2]['property_name']          ="";
        $dedicated_property_data_arr[2]['country']         ="";
        $dedicated_property_data_arr[2]['state']                   ="";
        $dedicated_property_data_arr[2]['city']                 ="";
        $dedicated_property_data_arr[2]['property_code']     ="";
        $dedicated_property_data_arr[2]['master_id']             ="";

        $dedicated_property_data_arr[3]['id']                    ='';
        $dedicated_property_data_arr[3]['reference_id']          =3;
        $dedicated_property_data_arr[3]['reference_value']       ="Commercial Unit";
        $dedicated_property_data_arr[3]['property_name']          ="";
        $dedicated_property_data_arr[3]['country']         ="";
        $dedicated_property_data_arr[3]['state']                   ="";
        $dedicated_property_data_arr[3]['city']                 ="";
        $dedicated_property_data_arr[3]['property_code']     ="";
        $dedicated_property_data_arr[3]['master_id']             ="";

        $dedicated_property_data_arr[4]['id']                    ='';
        $dedicated_property_data_arr[4]['reference_id']          =4;
        $dedicated_property_data_arr[4]['reference_value']       ="Parking Lot";
        $dedicated_property_data_arr[4]['property_name']          ="";
        $dedicated_property_data_arr[4]['country']         ="";
        $dedicated_property_data_arr[4]['state']                   ="";
        $dedicated_property_data_arr[4]['city']                 ="";
        $dedicated_property_data_arr[4]['property_code']     ="";
        $dedicated_property_data_arr[4]['master_id']             ="";

        $dedicated_property_data_arr[5]['id']                    ='';
        $dedicated_property_data_arr[5]['reference_id']          =5;
        $dedicated_property_data_arr[5]['reference_value']       ="Storage Lot";
        $dedicated_property_data_arr[5]['property_name']          ="";
        $dedicated_property_data_arr[5]['country']         ="";
        $dedicated_property_data_arr[5]['state']                   ="";
        $dedicated_property_data_arr[5]['city']                 ="";
        $dedicated_property_data_arr[5]['property_code']     ="";
        $dedicated_property_data_arr[5]['master_id']             ="";
      

        $CustomerPropertyData   =CustomerProperty::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('master_id',$id)
                                    ->where('page_id',4)
                                    ->get();
        
        foreach ($CustomerPropertyData as $key => $value) {           

            $dedicated_property_data_arr[$value->reference_id]['id']                    =$value->id;
            $dedicated_property_data_arr[$value->reference_id]['reference_id']          =$value->reference_id;
            $dedicated_property_data_arr[$value->reference_id]['reference_value']       =$value->reference_value;
            $dedicated_property_data_arr[$value->reference_id]['property_name']         =$value->property_name;
            $dedicated_property_data_arr[$value->reference_id]['country']               =$value->country;
            $dedicated_property_data_arr[$value->reference_id]['state']                 =$value->state;
            $dedicated_property_data_arr[$value->reference_id]['city']                  =$value->city;
            $dedicated_property_data_arr[$value->reference_id]['property_code']         =$value->property_code;
            $dedicated_property_data_arr[$value->reference_id]['master_id']             =$value->master_id;
        }

        
        

        ksort($dedicated_property_data_arr); 
        $gsl=0;
        foreach ($dedicated_property_data_arr as $key => $value) {
           

            $data["dedicated_property_data_arr"][$gsl]['id']                    =$value["id"];
            $data["dedicated_property_data_arr"][$gsl]['reference_id']          =$value["reference_id"];
            $data["dedicated_property_data_arr"][$gsl]['reference_value']       =$value["reference_value"];
            $data["dedicated_property_data_arr"][$gsl]['property_name']         =$value["property_name"];
            $data["dedicated_property_data_arr"][$gsl]['country']               =$value["country"];
            $data["dedicated_property_data_arr"][$gsl]['state']                 =$value["state"];
            $data["dedicated_property_data_arr"][$gsl]['city']                  =$value["city"];
            $data["dedicated_property_data_arr"][$gsl]['property_code']         =$value["property_code"];
            $data["dedicated_property_data_arr"][$gsl]['master_id']             =$value["master_id"];
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
            'account_status'                    => 'required',
            'customer_type'                     => 'required',
            'account_no'                        => 'required',
            'operational_name'                  => 'required',
           
            'headoffice_house_number'           => 'required',
            'headoffice_street_number'          => 'required',
            'headoffice_city'                   => 'required',
            'headoffice_state'                  => 'required',
            'headoffice_country'                => 'required',
            'headoffice_zip_code'               => 'required',

            'currency_domestic'                 => 'required',
            'invoice_term'                      => 'required',
            'sales_tax'                         => 'required',
            'credit_limit_daily'                => 'required',
            'credit_limit_weekly'               => 'required',
            'credit_limit_monthly'              => 'required',
            'credit_limit_semi_monthly'         => 'required',

            'credit_limit_yearly'               => 'required',
            'fiscal_year_start_date'            => 'required',
            'fiscal_year_end_date'              => 'required',
            'recuring_cycle'                    => 'required',

        ]);

                  
        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['inserted_by'              =>$user_id]);
        $request->merge(['page_id'                  =>4]);
        $request->merge(['project_id'               =>$project_id]);
        $fiscal_year_start_date                     =date("Y-m-d",strtotime($request->input('fiscal_year_start_date')));
        $fiscal_year_end_date                       =date("Y-m-d",strtotime($request->input('fiscal_year_end_date')));

        if($request->input('status_date'))
        {
            $status_date                               =date("Y-m-d",strtotime($request->input('status_date')));
            $request->merge(['status_date'             =>$status_date]);

        }

       

        if($request->input('comment_date'))
        {
            $comment_date                               =date("Y-m-d",strtotime($request->input('comment_date')));
            $request->merge(['comment_date'             =>$comment_date]);

        }

        $request->merge(['fiscal_year_start_date'   =>$fiscal_year_start_date]);
        $request->merge(['fiscal_year_end_date'     =>$fiscal_year_end_date]);        DB::beginTransaction();
        $RId1=true;
        $RId2=true;
        $RId3=true;
        $RId4=true;

        $customer_update=Customer::find($id)->update($request->all());
        foreach($request->dadicated_property_data as $key=>$details)
        {
            if($details['property_code']!="")
            {
                if($details['id'])
                {
                    $data_customer_property_update= array(
                        
                        'property_name'             =>$details['property_name'],
                        'country'                   =>$details['country'],
                        'state'                     =>$details['state'],
                        'city'                      =>$details['city'],
                        'property_code'             =>$details['property_code'],
                        'updated_by'                =>$user_id,
                    );

                    $RId3=CustomerProperty::where('id',"=",$details['id'])->update($data_customer_property_update);

                }
                else{

                    $data_customer_property[]= array(
                        'project_id'                =>$project_id,
                        'page_id'                   =>4,
                        'master_id'                 =>$id,
                        'reference_id'              =>$details['reference_id'],
                        'reference_value'           =>$details['reference_value'],
                        'property_name'             =>$details['property_name'],
                        'country'                   =>$details['country'],
                        'state'                     =>$details['state'],
                        'city'                      =>$details['city'],
                        'property_code'             =>$details['property_code'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
        }
        //dd($data_customer_property);die;

        $data_custom_field=array();
        foreach($request->custom_field as $key=>$details)
        {
            if($details['field_model']!="")
            {
                $text=NULL;
                $number=NULL;
                $date_time=NULL;
                if($details['field_type']==1 || $details['field_type']==2)
                {
                    $date_time=date("Y-m-d h:i:s",strtotime($details['field_model']));
                }

                if($details['field_type']==4 || $details['field_type']==6 || $details['field_type']==7)
                {
                    $number=$details['field_model'];
                }

                if($details['field_type']==3 || $details['field_type']==5 || $details['field_type']==8)
                {
                    $text=$details['field_model'];
                }

                if($details['id'])
                {
                    $custom_field_data= array(
                        
                        'text'                      =>$text,
                        'number'                    =>$number,
                        'date_time'                 =>$date_time,
                        'updated_by'               =>$user_id,
                    ); 
                    $RId4=CustomFieldData::where('id',"=",$details['id'])->update($custom_field_data);


                }
                else {
                    $data_custom_field[]= array(
                        'project_id'                =>$project_id,
                        'page_id'                   =>4,
                        'master_id'                 =>$id,
                        'field_id'                  =>$details['reference_id'],
                        'field_type'                =>$details['field_type'],
                        'text'                      =>$text,
                        'number'                    =>$number,
                        'date_time'                 =>$date_time,
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
                        'page_id'                   =>4,
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

        if(!empty($data_customer_property))
        {
            $RId1=CustomerProperty::insert($data_customer_property);
        }

        if(!empty($data_key_position))
        {
            $RId2=KeyPosition::insert($data_key_position);
        }

        if($data_custom_field)
        {
            $RId3=CustomFieldData::insert($data_custom_field);
        }


        if( $customer_update && $RId1 && $RId2 && $RId3 && $RId4)
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
    public function destroy(Request $request,$id)
    {
        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['updated_by'               =>$user_id]);
        $request->merge(['page_id'                  =>4]);
        $request->merge(['project_id'               =>$project_id]);
        

        $RId1=true;
        $RId2=true;
        $RId3=true;
        $RId4=true;

        $customer_update=Customer::find($id)->update(['status_active'=>2,'updated_by'=>$user_id]);

        foreach($request->dadicated_property_data as $key=>$details)
        {
            if($details['id'])
            {
                $data_customer_property_update= array(
                    'status_active'             =>2,
                    'updated_by'                =>$user_id,
                );

                $RId3=CustomerProperty::where('id',"=",$details['id'])->update($data_customer_property_update);

            }                
            
        }

        $data_custom_field=array();
        foreach($request->custom_field as $key=>$details)
        {
             
            if($details['id'])
            {
                $custom_field_data= array(
                    
                    'status_active'             =>2,
                    'updated_by'                =>$user_id,
                ); 
                $RId4=CustomFieldData::where('id',"=",$details['id'])->update($custom_field_data);
            }
               
                 
                 
        }
        $data_key_position=array();
        foreach($request->key_position_lavel_data as $key=>$details)
        {
            
            if($details['id'])
            {

                $key_position_data= array(
                    'status_active'             =>2,
                    'updated_by'                =>$user_id,
                ); 

                $RId4=KeyPosition::where('id',"=",$details['id'])->update($key_position_data);

            }
                
                 
                    
        }

        

        if( $RId1 && $RId2 && $RId3 && $RId4)
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
