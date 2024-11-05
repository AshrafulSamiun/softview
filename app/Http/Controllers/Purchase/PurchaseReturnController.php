<?php

namespace App\Http\Controllers\Purchase;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Http\Controllers\Controller;
use App\Models\AccountHolder;
use App\Models\Country as Country;
use App\Models\Purchase;
use App\Models\PurchaseCharge;
use App\Models\PurchaseChargeBreakdown;
use App\Models\PurchaseDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function PurchaseReturnList( Request $request)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $inseurance_type_arr        =$ArrayFunction->inseurance_type;
        $additional_charge_arr      =$ArrayFunction->additional_charge_arr;
        $deduction_charge_arr       =$ArrayFunction->deduction_charge_arr;
       
        $sl=0;
        foreach ($additional_charge_arr as $key => $value) {
            $data['additional_charge_arr'][$sl]['id']=$key;
            $data['additional_charge_arr'][$sl]['value']=$value;
            $sl++;
        }

        $sl=0;
        foreach ($deduction_charge_arr as $key => $value) {
            $data['deduction_charge_arr'][$sl]['id']=$key;
            $data['deduction_charge_arr'][$sl]['value']=$value;
            $sl++;
        }


        //===================Company==========================================
        
        $service_provider           =AccountHolder::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            ->get();        

        //===================Building==========================================

        $account_holder_list=array();
        foreach ($service_provider as $key => $value) {
            $account_holder_list[$value->id]=$value->first_name." ".$value->middle_name." ".$value->last_name;
        }

        //===================Building==========================================

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
            $company_type=$request->session()->get('company_type');
        }
        else {

            return; 
        }

        $sl=0;
        $purchase_offer_list=Purchase::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('entry_form',5)
                                        ->where('company_id',$company_id)
                                        ->where('company_type',$company_type)
                                        ->get();

        $data['purchase_offer_list']=array();
        foreach ($purchase_offer_list as $key => $value) {

            $data['purchase_offer_list'][$key]['sl']                   =$sl+1;
            $data['purchase_offer_list'][$key]['id']                   =$value->id;
            $data['purchase_offer_list'][$key]['system_no']            =$value->unique_no;
            $data['purchase_offer_list'][$key]['transaction_no']       =$value->transaction_no;
            
            $data['purchase_offer_list'][$key]['purchase_type']        =$value->purchase_type;
            
            $data['purchase_offer_list'][$key]['schedule_delivery_date']       =$value->schedule_delivery_date;

         
            if($value->purchase_type==1)
            {
                $data['purchase_offer_list'][$key]['purchase_type_string']     ="Goods";
            }
            else
            {
                $data['purchase_offer_list'][$key]['purchase_type_string']      ="Services";

            }
            if($value->approval_status==1)
            {
                $data['purchase_offer_list'][$key]['approval_status']     ="Approved";

            }
            else
            {
                $data['purchase_offer_list'][$key]['approval_status']      ="Un-Approved";

            }

            if($value->seller_id>0)
            {
                $data['purchase_offer_list'][$key]['seller_name']     =$account_holder_list[$value->seller_id];

            }
            else
            {
                $data['purchase_offer_list'][$key]['seller_name']      ="";

            }

            if($value->service_provider_id>0)
            {
                $data['purchase_offer_list'][$key]['service_provider_name']     =$account_holder_list[$value->service_provider_id];

            }
            else
            {
                $data['purchase_offer_list'][$key]['service_provider_name']      ="";

            }

            if($value->customer_id>0)
            {
                $data['purchase_offer_list'][$key]['customer_name']     =$account_holder_list[$value->customer_id];

            }
            else
            {
                $data['purchase_offer_list'][$key]['customer_name']      ="";

            }

            if($value->shipping_company_id>0)
            {
                $data['purchase_offer_list'][$key]['shipping_company']  =$account_holder_list[$value->shipping_company_id];
            }
            else
            {
                $data['purchase_offer_list'][$key]['shipping_company']  ="";
            }

            if($value->driver_id>0)
            {
                $data['purchase_offer_list'][$key]['driver_name']       =$account_holder_list[$value->driver_id];
            }
            else
            {
                $data['purchase_offer_list'][$key]['driver_name']       ="";
            }

            
            $sl++;

        }

       // $data['commercial_unit_list']        =$commercial_unit_list;
        
        return $data;

    }
    public function store(Request $request)
    {
        request()->validate([
            'purchase_type'                 => 'required',
            'seller_name'                   => 'required',
            'seller_account_no'             => 'required',
            'service_provider_account_no'   => 'required',
            'customer_name'                 => 'required',
            'schedule_delivery_date'        => 'required',
            'schdule_delivery_time'         => 'required',
            'purchase_type'                 => 'required',
            'delivery_location'             => 'required',
            'delivery_instruction'          => 'required',
            'delivery_contact_person_name'  => 'required',
            'delivery_contact_person_email' => 'required',
            'delivery_contact_person_phone' => 'required',
            'delivery_receive_by'           => 'required',
            'payment_due_date'              => 'required',
            'days_left_to_pay'              => 'required',
            'early_payment_discount'        => 'required',
            'payment_method'                => 'required',
            'posted_check_available'        => 'required',
            'late_payment_pelanty'          => 'required',
            'hidden_cost'                   => 'required',
            'shipping_cost_pay_by'          => 'required',
            'payment_status'                => 'required',
            'shipping_company_name'         => 'required',
            'shipping_company_account_no'   => 'required',
            'notification_by'               => 'required',
            'backorder_allowed'             => 'required',
            'approval_status'               => 'required',
            'vehicle_identification_number' => 'required',
            'vehicle_make'                  => 'required',
            'vehicle_model'                 => 'required',
            'vehicle_year'                  => 'required',
            'vehicle_type'                  => 'required',
            'vehicle_license_plate'         => 'required',
            'vehicle_insurance_information' => 'required',
            'driver_address'                => 'required',
            'driver_name'                   => 'required',
            'driver_license_no'             => 'required',
            'driver_contact_no'             => 'required',
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $schedule_delivery_date              =date("Y-m-d h:i:s",(strtotime($request->input('schedule_delivery_date'))+strtotime($request->input('schdule_delivery_time'))));
        $payment_due_date                    =date("Y-m-d",strtotime($request->input('schedule_delivery_date')));


        $request->merge(['schedule_delivery_date'   =>$schedule_delivery_date]);
        $request->merge(['payment_due_date'         =>$payment_due_date]);
        $request->merge(['payment_due_date'         =>$payment_due_date]);
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);


        $company_id="";
        $company_type="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
            $company_type=$request->session()->get('company_type');
        }
        else {
            return; 
        }
        $request->merge(['company_id' =>$company_id]);
        $request->merge(['company_type' =>$company_type]);

        $max_system_data = Purchase::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from purchases 
            where project_id=".$project_id." and entry_form=5  and company_id=".$company_id." and  company_type=".$company_type.") 
            and company_type=".$company_type." and entry_form=5  and company_id=".$company_id." and project_id=".$project_id)->get(['system_prefix']);

       
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="PR-".str_pad($max_system_prefix, 5, 0, STR_PAD_LEFT);
       // $request->merge(['unique_no'               =>$system_no]);
        $request->merge(['transaction_no'          =>$system_no]);
        $request->merge(['entry_form'              =>5]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $purchase_offer_info= Purchase::create($request->all());

        foreach($request->product_details_arr as $key=>$details)
        {
                      
            if($details['qty']>0)
            {
                $details_data=PurchaseDetails:: create(
                    [
                        'project_id'                =>$project_id,
                        'master_id'                 =>$purchase_offer_info->id,
                        'item_name'                 =>$details['item_name'],
                        'product_id'                =>$details['product_id'],
                        'item_description'          =>$details['item_description'],
                        'qty'                       =>$details['qty'],
                        'rate'                      =>$details['rate'],
                        'addition'                  =>$details['addition'],
                        'addition_percent'          =>$details['addition_percent'],
                        'deduction'                 =>$details['deduction'],
                        'deduction_percent'         =>$details['deduction_percent'],
                        'sub_total'                 =>$details['sub_total'],
                        'tax_rate'                  =>$details['tax_rate'],
                        'tax'                       =>$details['tax'],
                        'total'                     =>$details['total'],
                        'inserted_by'               =>$user_id
                    ]
                );
                
                if( !$details_data)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }

                foreach ($details['addition_distribution'] as $key => $value) {

                    $data_charge_breakdown_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$purchase_offer_info->id,
                        'detail_id'                 =>$details_data->id,
                        'charge_id'                 =>$value['reference_id'],
                        'charge_type'               =>1,
                        'amount'                    =>$value['reference_value'],
                        'inserted_by'               =>$user_id,
                    );
                }

                foreach ($details['deduction_distribution'] as $key => $value) {

                    $data_charge_breakdown_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$purchase_offer_info->id,
                        'detail_id'                 =>$details_data->id,
                        'charge_id'                 =>$value['reference_id'],
                        'charge_type'               =>2,
                        'amount'                    =>$value['reference_value'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
                   
        } 

        foreach($request->additional_charge_arr as $key=>$details)
        {
                      
            if($details['amount']>0)
            {
                $data_charge_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$purchase_offer_info->id,
                    'charge_id'                 =>$details['reference_id'],
                    'charge_type'               =>1,
                    'amount'                    =>$details['amount'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

        foreach($request->deduction_charge_arr as $key=>$details)
        {
                      
            if($details['amount']>0)
            {
                   
                $data_charge_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$purchase_offer_info->id,
                    'charge_id'                 =>$details['reference_id'],
                    'charge_type'               =>2,
                    'amount'                    =>$details['amount'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

        $RID1=true;
        $RID2=true;

       if(!empty($data_charge_breakdown_details))
        {
            $RID1=PurchaseChargeBreakdown::insert($data_charge_breakdown_details);
        }

        if(!empty($data_charge_details))
        {
            $RID2=PurchaseCharge::insert($data_charge_details);
        }

        $update_details_data= array(
                                //'project_id'                =>$project_id,
                                'next_step_return'                 =>1,
                                'updated_by'                =>$user_id,
                            );

        $upd_pre=Purchase::where('unique_no',"=",$request->input('unique_no'))
                                        ->where('entry_form',"=",4)
                                        ->where('status_active',"=",1)
                                        ->update($update_details_data);

        if($purchase_offer_info  && $RID1 && $RID2 && $upd_pre)
        {
           DB::commit();
           return "1**$purchase_offer_info->id**$system_no";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    

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
        $additional_charge_arr      =$ArrayFunction->additional_charge_arr;
        $deduction_charge_arr       =$ArrayFunction->deduction_charge_arr;
        
       

        $sl=0;
        foreach ($additional_charge_arr as $key => $value) {
            $data['additional_charge_arr'][$sl]['id']=$key;
            $data['additional_charge_arr'][$sl]['value']=$value;
            $sl++;
        }

        $sl=0;
        foreach ($deduction_charge_arr as $key => $value) {
            $data['deduction_charge_arr'][$sl]['id']=$key;
            $data['deduction_charge_arr'][$sl]['value']=$value;
            $sl++;
        }


        //===================Company==========================================
        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
        }
        $service_provider           =AccountHolder::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            ->get();        

        //===================Building==========================================

        $account_holder_list=array();
        foreach ($service_provider as $key => $value) {
            //$account_holder_list[$value->id]=$value->first_name." ".$value->middle_name." ".$value->last_name;
            $account_holder_list[$value->id]=$value;
        }

      

        $sl=0;
        $purchase_acceptance_list=Purchase::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('entry_form',5)
                                        ->where('id',$id)
                                       // ->where('company_type',$company_type)
                                        ->get();

        $data['purchase_offer_list']=array();
        foreach ($purchase_acceptance_list as $key => $value) {

            $data['purchase_offer_list']['id']                              =$value->id;
            $data['purchase_offer_list']['unique_no']                       =$value->unique_no;
            $data['purchase_offer_list']['transaction_no']                  =$value->transaction_no;
            $data['purchase_offer_list']['purchase_type']                   =$value->purchase_type;
            $data['purchase_offer_list']['schedule_delivery_date']          =$value->schedule_delivery_date;            
            $data['purchase_offer_list']['approval_status']                 =$value->approval_status;
            $data['purchase_offer_list']['next_step']                      =$value->next_step;
            

            $data['purchase_offer_list']['schedule_delivery_date']          =date("Y-m-d",strtotime($value->schedule_delivery_date));
            $data['purchase_offer_list']['schdule_delivery_time']           =date("h:i:s",strtotime($value->schedule_delivery_date));
            $data['purchase_offer_list']['purchase_offer_no']               ="";
            $data['purchase_offer_list']['purchase_offer_date']             ="";
            $data['purchase_offer_list']['purchase_offer_acceptance_no']    ="";
            $data['purchase_offer_list']['purchase_offer_acceptance_date']  ="";
            $data['purchase_offer_list']['purchase_order_date']             ="";
            $data['purchase_offer_list']['purchase_order_no']               ="";
            $data['purchase_offer_list']['packing_slip_date']               ="";
            $data['purchase_offer_list']['packing_slip_no']                 ="";
            $data['purchase_offer_list']['purchase_return_date']            ="";
            $data['purchase_offer_list']['purchase_return_no']              ="";
            $data['purchase_offer_list']['purchase_credit_note_date']       ="";
            $data['purchase_offer_list']['purchase_credit_note_no']         ="";

            $data['purchase_offer_list']['purchase_invoice_date']           ="";
            $data['purchase_offer_list']['purchase_invoice_no']             ="";
            $data['purchase_offer_list']['purchase_debit_note_date']        ="";
            $data['purchase_offer_list']['purchase_debit_note_no']          ="";

            $purchase_list=Purchase::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('entry_form',"!=",5)
                                        ->where('unique_no',$value->unique_no)
                                        ->get();
                                        //dd($purchase_list);
            foreach($purchase_list as $val)
            {
                if($val->entry_form==1)
                {
                    $data['purchase_offer_list']['purchase_offer_date']             =date("D M d, Y",strtotime($val->created_at));
                    $data['purchase_offer_list']['purchase_offer_no']               =$val->transaction_no;
                }
                else if($val->entry_form==2)
                {
                    $data['purchase_offer_list']['purchase_offer_acceptance_date']  =date("D M d, Y",strtotime($val->created_at));
                    $data['purchase_offer_list']['purchase_offer_acceptance_no']    =$val->transaction_no;
                }
                else if($val->entry_form==3)
                {
                     $data['purchase_offer_list']['purchase_order_no']              =date("D M d, Y",strtotime($val->created_at));
                     $data['purchase_offer_list']['purchase_order_date']            =$val->transaction_no;
                }
                else if($val->entry_form==4)
                {
                    $data['purchase_offer_list']['packing_slip_date']               =date("D M d, Y",strtotime($val->created_at));
                    $data['purchase_offer_list']['packing_slip_no']                 =$val->transaction_no;
                }
                else if($val->entry_form==6)
                {
                    $data['purchase_offer_list']['purchase_debit_note_date']        =date("D M d, Y",strtotime($val->created_at));
                    $data['purchase_offer_list']['purchase_debit_note_no']          =$val->transaction_no;
                }
                else if($val->entry_form==7)
                {
                    $data['purchase_offer_list']['purchase_credit_note_date']        =date("D M d, Y",strtotime($val->created_at));
                    $data['purchase_offer_list']['purchase_credit_note_no']          =$val->transaction_no;
                }
                else if($val->entry_form==8)
                {
                    $data['purchase_offer_list']['purchase_invoice_date']             =date("D M d, Y",strtotime($val->created_at));
                    $data['purchase_offer_list']['purchase_invoice_no']               =$val->transaction_no;
                }
                // else if($val->entry_form==6)
                // {
                //     $data['purchase_offer_list']['purchase_return_no']             =date("D M d, Y",strtotime($purchase_offer_list->created_at));
                //     $data['purchase_offer_list']['purchase_return_date']               =$purchase_offer_list->transaction_no;
                // }
                // else if($val->entry_form==7)
                // {
                //     $data['purchase_offer_list']['purchase_offer_date']             =date("D M d, Y",strtotime($purchase_offer_list->created_at));
                //     $data['purchase_offer_list']['purchase_offer_no']               =$purchase_offer_list->transaction_no;
                // }
                // else if($val->entry_form==8)
                // {
                //     $data['purchase_offer_list']['purchase_offer_date']             =date("D M d, Y",strtotime($purchase_offer_list->created_at));
                //     $data['purchase_offer_list']['purchase_offer_no']               =$purchase_offer_list->transaction_no;
                // }
                // else if($val->entry_form==9)
                // {
                //     $data['purchase_offer_list']['purchase_offer_date']             =date("D M d, Y",strtotime($purchase_offer_list->created_at));
                //     $data['purchase_offer_list']['purchase_offer_no']               =$purchase_offer_list->transaction_no;
                // }

            }
            
            $data['purchase_offer_list']['purchase_return_date']               =date("D M d, Y",strtotime($value->created_at));
            $data['purchase_offer_list']['purchase_return_no']              =$value->transaction_no;
            $data['purchase_offer_list']['delivery_location']               =$value->delivery_location;
            $data['purchase_offer_list']['delivery_instruction']            =$value->delivery_instruction;
            $data['purchase_offer_list']['delivery_contact_person_name']    =$value->delivery_contact_person_name;            
            $data['purchase_offer_list']['delivery_contact_person_email']   =$value->delivery_contact_person_email;

            $data['purchase_offer_list']['delivery_contact_person_phone']   =$value->delivery_contact_person_phone;
            $data['purchase_offer_list']['delivery_receive_by']             =$value->delivery_receive_by;
            $data['purchase_offer_list']['payment_due_date']                =$value->payment_due_date;
            $data['purchase_offer_list']['payment_method']                  =$value->payment_method;
            $data['purchase_offer_list']['days_left_to_pay']                =$value->days_left_to_pay;
            $data['purchase_offer_list']['early_payment_discount']          =$value->early_payment_discount;            
            $data['purchase_offer_list']['posted_check_available']          =$value->posted_check_available;

            $data['purchase_offer_list']['late_payment_pelanty']            =$value->late_payment_pelanty;
            $data['purchase_offer_list']['hidden_cost']                     =$value->hidden_cost;
            $data['purchase_offer_list']['shipping_cost_pay_by']            =$value->shipping_cost_pay_by;
            $data['purchase_offer_list']['payment_status']                  =$value->payment_status;
            $data['purchase_offer_list']['posting_status']                  =$value->posting_status;


            $data['purchase_offer_list']['notification_by']                 =$value->notification_by;            
            $data['purchase_offer_list']['backorder_allowed']               =$value->backorder_allowed;

            $data['purchase_offer_list']['vehicle_identification_number']   =$value->vehicle_identification_number;
            $data['purchase_offer_list']['vehicle_make']                    =$value->vehicle_make;
            $data['purchase_offer_list']['vehicle_model']                   =$value->vehicle_model;
            $data['purchase_offer_list']['vehicle_year']                    =$value->vehicle_year;
            $data['purchase_offer_list']['vehicle_type']                    =$value->vehicle_type;            
            $data['purchase_offer_list']['vehicle_license_plate']           =$value->vehicle_license_plate;

            $data['purchase_offer_list']['vehicle_image']                   =$value->vehicle_image;
            $data['purchase_offer_list']['vehicle_make']                    =$value->vehicle_make;
            $data['purchase_offer_list']['vehicle_model']                   =$value->vehicle_model;
            $data['purchase_offer_list']['vehicle_year']                    =$value->vehicle_year;
            $data['purchase_offer_list']['vehicle_type']                    =$value->vehicle_type;            
            $data['purchase_offer_list']['vehicle_license_plate']           =$value->vehicle_license_plate;

            $data['purchase_offer_list']['vehicle_identification_number']   =$value->vehicle_identification_number;
            $data['purchase_offer_list']['vehicle_image_id']                =$value->vehicle_image_id;
            $data['purchase_offer_list']['vehicle_insurance_information']   =$value->vehicle_insurance_information;
            

            if($value->seller_id>0)
            {
                $data['purchase_offer_list']['seller_name']         =$account_holder_list[$value->seller_id]->register_corp_first_name." ".$account_holder_list[$value->seller_id]->register_corp_middle_name." ".$account_holder_list[$value->seller_id]->register_corp_last_name;
                $data['purchase_offer_list']['seller_id']           =$account_holder_list[$value->seller_id]->id;
                $data['purchase_offer_list']['seller_account_no']   =$account_holder_list[$value->seller_id]->system_no;
                $data['purchase_offer_list']['seller_photo']        =$account_holder_list[$value->seller_id]->id;
                $data['purchase_offer_list']['seller_photo_id']     ="";
                $data['purchase_offer_list']['seller_contact_no']   =$account_holder_list[$value->seller_id]->cell_phone;
                $data['purchase_offer_list']['seller_address']      ="H-".$account_holder_list[$value->seller_id]->house_number.", R-".$account_holder_list[$value->seller_id]->street_number.", City-".$account_holder_list[$value->seller_id]->city.", State-".$account_holder_list[$value->seller_id]->state.", Zip-Code-".$account_holder_list[$value->seller_id]->zip_code.", Country-".$country_arr[$account_holder_list[$value->seller_id]->country];
            }
            else
            {
                $data['purchase_offer_list']['seller_name']         ="";
                $data['purchase_offer_list']['seller_account_no']   ="";
                $data['purchase_offer_list']['seller_photo']        ="";
                $data['purchase_offer_list']['seller_photo_id']     ="";
                $data['purchase_offer_list']['seller_contact_no']   ="";
                $data['purchase_offer_list']['seller_address']      ="";

            }

            if($value->service_provider_id>0)
            {
                $data['purchase_offer_list']['service_provider_name']         =$account_holder_list[$value->service_provider_id]->register_corp_first_name." ".$account_holder_list[$value->service_provider_id]->register_corp_middle_name." ".$account_holder_list[$value->service_provider_id]->register_corp_last_name;
                $data['purchase_offer_list']['service_provider_id']           =$account_holder_list[$value->service_provider_id]->id;
                $data['purchase_offer_list']['service_provider_account_no']   =$account_holder_list[$value->service_provider_id]->system_no;
                $data['purchase_offer_list']['service_provider_photo']        =$account_holder_list[$value->service_provider_id]->id;
                $data['purchase_offer_list']['service_provider_photo_id']     ="";
                $data['purchase_offer_list']['service_provider_contact_no']   =$account_holder_list[$value->service_provider_id]->cell_phone;
                $data['purchase_offer_list']['service_provider_address']      ="H-".$account_holder_list[$value->service_provider_id]->house_number.", R-".$account_holder_list[$value->service_provider_id]->street_number.", City-".$account_holder_list[$value->service_provider_id]->city.", State-".$account_holder_list[$value->service_provider_id]->state.", Zip-Code-".$account_holder_list[$value->service_provider_id]->zip_code.", Country-".$country_arr[$account_holder_list[$value->service_provider_id]->country];
            }
            else
            {
                $data['purchase_offer_list']['service_provider_name']         ="";
                $data['purchase_offer_list']['service_provider_account_no']   ="";
                $data['purchase_offer_list']['service_provider_photo']        ="";
                $data['purchase_offer_list']['service_provider_photo_id']     ="";
                $data['purchase_offer_list']['service_provider_contact_no']   ="";
                $data['purchase_offer_list']['service_provider_address']      ="";

            }

            if($value->customer_id>0)
            {
                $data['purchase_offer_list']['customer_name']         =$account_holder_list[$value->customer_id]->register_corp_first_name." ".$account_holder_list[$value->customer_id]->register_corp_middle_name." ".$account_holder_list[$value->customer_id]->register_corp_last_name;
                $data['purchase_offer_list']['customer_id']           =$account_holder_list[$value->customer_id]->id;
                $data['purchase_offer_list']['customer_account_no']   =$account_holder_list[$value->customer_id]->system_no;
                $data['purchase_offer_list']['customer_photo']        =$account_holder_list[$value->customer_id]->id;
                $data['purchase_offer_list']['customer_photo_id']     ="";
                $data['purchase_offer_list']['customer_contact_no']   =$account_holder_list[$value->customer_id]->cell_phone;
                $data['purchase_offer_list']['customer_address']      ="H-".$account_holder_list[$value->customer_id]->house_number.", R-".$account_holder_list[$value->customer_id]->street_number.", City-".$account_holder_list[$value->customer_id]->city.", State-".$account_holder_list[$value->customer_id]->state.", Zip-Code-".$account_holder_list[$value->customer_id]->zip_code.", Country-".$country_arr[$account_holder_list[$value->customer_id]->country];
            }
            else
            {
                $data['purchase_offer_list']['customer_name']         ="";
                $data['purchase_offer_list']['customer_account_no']   ="";
                $data['purchase_offer_list']['customer_photo']        ="";
                $data['purchase_offer_list']['customer_photo_id']     ="";
                $data['purchase_offer_list']['customer_contact_no']   ="";
                $data['purchase_offer_list']['customer_address']      ="";

            }

            if($value->shipping_company_id>0)
            {
                $data['purchase_offer_list']['shipping_company_name']         =$account_holder_list[$value->shipping_company_id]->register_corp_first_name." ".$account_holder_list[$value->shipping_company_id]->register_corp_middle_name." ".$account_holder_list[$value->shipping_company_id]->register_corp_last_name;
                $data['purchase_offer_list']['shipping_company_id']           =$account_holder_list[$value->shipping_company_id]->id;
                $data['purchase_offer_list']['shipping_company_account_no']   =$account_holder_list[$value->shipping_company_id]->system_no;
                $data['purchase_offer_list']['shipping_company_photo']        =$account_holder_list[$value->shipping_company_id]->id;
                $data['purchase_offer_list']['shipping_company_photo_id']     ="";
                $data['purchase_offer_list']['shipping_company_contact_no']   =$account_holder_list[$value->shipping_company_id]->cell_phone;
                $data['purchase_offer_list']['shipping_company_address']      ="H-".$account_holder_list[$value->shipping_company_id]->house_number.", R-".$account_holder_list[$value->shipping_company_id]->street_number.", City-".$account_holder_list[$value->shipping_company_id]->city.", State-".$account_holder_list[$value->shipping_company_id]->state.", Zip-Code-".$account_holder_list[$value->shipping_company_id]->zip_code.", Country-".$country_arr[$account_holder_list[$value->shipping_company_id]->country];
            }
            else
            {
                $data['purchase_offer_list']['shipping_company_name']         ="";
                $data['purchase_offer_list']['shipping_company_account_no']   ="";
                $data['purchase_offer_list']['shipping_company_photo']        ="";
                $data['purchase_offer_list']['shipping_company_photo_id']     ="";
                $data['purchase_offer_list']['shipping_company_contact_no']   ="";
                $data['purchase_offer_list']['shipping_company_address']      ="";
            }

            if($value->driver_id>0)
            {
                $data['purchase_offer_list']['driver_name']         =$account_holder_list[$value->driver_id]->register_corp_first_name." ".$account_holder_list[$value->driver_id]->register_corp_middle_name." ".$account_holder_list[$value->driver_id]->register_corp_last_name;
                $data['purchase_offer_list']['driver_id']           =$account_holder_list[$value->driver_id]->id;
                $data['purchase_offer_list']['driver_account_no']   =$account_holder_list[$value->driver_id]->system_no;
                $data['purchase_offer_list']['driver_license_no']   =$account_holder_list[$value->driver_id]->system_no;
                $data['purchase_offer_list']['driver_photo']        =$account_holder_list[$value->driver_id]->id;
                $data['purchase_offer_list']['driver_photo_id']     ="";
                $data['purchase_offer_list']['driver_contact_no']   =$account_holder_list[$value->driver_id]->cell_phone;
                $data['purchase_offer_list']['driver_address']      ="H-".$account_holder_list[$value->driver_id]->house_number.", R-".$account_holder_list[$value->driver_id]->street_number.", City-".$account_holder_list[$value->driver_id]->city.", State-".$account_holder_list[$value->driver_id]->state.", Zip-Code-".$account_holder_list[$value->driver_id]->zip_code.", Country-".$country_arr[$account_holder_list[$value->driver_id]->country];
            }
            else
            {
                $data['purchase_offer_list']['driver_name']         ="";
                $data['purchase_offer_list']['driver_account_no']   ="";
                $data['purchase_offer_list']['driver_photo']        ="";
                $data['purchase_offer_list']['driver_photo_id']     ="";
                $data['purchase_offer_list']['driver_contact_no']   ="";
                $data['purchase_offer_list']['driver_address']      ="";
                $data['purchase_offer_list']['driver_license_no']   ="";

            }

            $sl++;

        }

        $purchase_charge_details_breakdown=PurchaseChargeBreakdown::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('master_id',$id)
                                        ->get();
        $charge_details_breakdown_arr=array();                               
        foreach($purchase_charge_details_breakdown as $val)
        {
            $charge_details_breakdown_arr[$val->detail_id][$val->charge_type][$val->charge_id]['id']=$val->id;
            $charge_details_breakdown_arr[$val->detail_id][$val->charge_type][$val->charge_id]['charge_type']=$val->charge_type;
            $charge_details_breakdown_arr[$val->detail_id][$val->charge_type][$val->charge_id]['amount']=$val->amount;
            $charge_details_breakdown_arr[$val->detail_id][$val->charge_type][$val->charge_id]['reference_id']=$val->charge_id;

        }

        //dd($charge_details_breakdown_arr);die;
        $purchase_details=PurchaseDetails::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('master_id',$id)
                                        ->get();

        $charge_details_arr=array(); 
        $sl=0;  $total_addition=0; $total_deduction=0;   $total_sub_total=0; $total_tax=0; $grand_total=0;                        
        foreach($purchase_details as $val)
        {
            $charge_details_arr[$sl]['item_name']  =$val->item_name;
            $charge_details_arr[$sl]['id']         =$val->id;
            $charge_details_arr[$sl]['product_id']=$val->product_id;
            $charge_details_arr[$sl]['item_description']=$val->item_description;
            $charge_details_arr[$sl]['qty']=$val->qty;
            $charge_details_arr[$sl]['rate']=$val->rate;
            $charge_details_arr[$sl]['addition']=$val->addition;
            $charge_details_arr[$sl]['deduction']=$val->deduction;
            $charge_details_arr[$sl]['addition_percent']=$val->addition_percent;
            $charge_details_arr[$sl]['deduction_percent']=$val->deduction_percent;
            $charge_details_arr[$sl]['sub_total']=$val->sub_total;
            $charge_details_arr[$sl]['tax_rate']=$val->tax_rate;
            $charge_details_arr[$sl]['tax']=$val->tax;
            $charge_details_arr[$sl]['total']=$val->total;
            $total_addition     +=$val->addition;
            $total_deduction    +=$val->deduction;
            $total_sub_total    +=$val->sub_total;
            $total_tax          +=$val->tax;
            $grand_total        +=$val->total;

            if(!empty($charge_details_breakdown_arr[$val->id]))
            {

                foreach($charge_details_breakdown_arr[$val->id] as $index=>$charge_value)
                {
                    $brsl=0;
                    foreach($charge_value as $value)
                    {
                       
                        if($index==1)
                        {
                            $charge_details_arr[$sl]['addition_distribution'][$brsl]['reference_id']=$value['reference_id'];
                            $charge_details_arr[$sl]['addition_distribution'][$brsl]['id']=$value['id'];
                            $charge_details_arr[$sl]['addition_distribution'][$brsl]['charge_type']=$value['charge_type'];
                            $charge_details_arr[$sl]['addition_distribution'][$brsl]['reference_value']=$value['amount'];
                        }
                        else
                        {
                            $charge_details_arr[$sl]['deduction_distribution'][$brsl]['reference_id']=$value['reference_id'];
                            $charge_details_arr[$sl]['deduction_distribution'][$brsl]['id']=$value['id'];
                            $charge_details_arr[$sl]['deduction_distribution'][$brsl]['charge_type']=$value['charge_type'];
                            $charge_details_arr[$sl]['deduction_distribution'][$brsl]['reference_value']=$value['amount'];

                        }
                        $brsl++;
                    }
                }
            }

           
            $sl++;
        }

        $purchase_charge_details=PurchaseCharge::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('master_id',$id)
                                        ->get();

        $purchase_charge_details_arr=array();
        $csl=0;
        foreach ($purchase_charge_details as $key => $row) 
        {
            $purchase_charge_details_arr[$csl]['id']            =$row->id;
            $purchase_charge_details_arr[$csl]['charge_id']     =$row->charge_id;

            if($row->charge_type==1)
                $purchase_charge_details_arr[$csl]['charge_name']   =$additional_charge_arr[$row->charge_id];
            else
                 $purchase_charge_details_arr[$csl]['charge_name']   =$deduction_charge_arr[$row->charge_id];
            $purchase_charge_details_arr[$csl]['charge_type']   =$row->charge_type;
            $purchase_charge_details_arr[$csl]['amount']        =$row->amount;
            $csl++;
        }
        $data['total_addition']                 =$total_addition;
        $data['total_deduction']                =$total_deduction;
        $data['sub_total']                      =$total_sub_total;
        $data['total_tax']                      =$total_tax;
        $data['grand_total']                    =$grand_total;

        $data['charge_details_arr']             =$charge_details_arr;
        $data['purchase_charge_details_arr']    =$purchase_charge_details_arr;
        
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
            'purchase_type'                 => 'required',
            'seller_name'                   => 'required',
            'seller_account_no'             => 'required',
            'service_provider_account_no'   => 'required',
            'customer_name'                 => 'required',
            'schedule_delivery_date'        => 'required',
            'schdule_delivery_time'         => 'required',
            'purchase_type'                 => 'required',
            'delivery_location'             => 'required',
            'delivery_instruction'          => 'required',
            'delivery_contact_person_name'  => 'required',
            'delivery_contact_person_email' => 'required',
            'delivery_contact_person_phone' => 'required',
            'delivery_receive_by'           => 'required',
            'payment_due_date'              => 'required',
            'days_left_to_pay'              => 'required',
            'early_payment_discount'        => 'required',
            'payment_method'                => 'required',
            'posted_check_available'        => 'required',
            'late_payment_pelanty'          => 'required',
            'hidden_cost'                   => 'required',
            'shipping_cost_pay_by'          => 'required',
            'payment_status'                => 'required',
            'shipping_company_name'         => 'required',
            'shipping_company_account_no'   => 'required',
            'notification_by'               => 'required',
            'backorder_allowed'             => 'required',
            'approval_status'               => 'required',
            'vehicle_identification_number' => 'required',
            'vehicle_make'                  => 'required',
            'vehicle_model'                 => 'required',
            'vehicle_year'                  => 'required',
            'vehicle_type'                  => 'required',
            'vehicle_license_plate'         => 'required',
            'vehicle_insurance_information' => 'required',
            'driver_address'                => 'required',
            'driver_name'                   => 'required',
            'driver_license_no'             => 'required',
            'driver_contact_no'             => 'required',
            
        ]);

        //echo "sdf dsf sdf ";die;
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $schedule_delivery_date                     =date("Y-m-d h:i:s",(strtotime($request->input('schedule_delivery_date'))+strtotime($request->input('schdule_delivery_time'))));
        $payment_due_date                           =date("Y-m-d",strtotime($request->input('payment_due_date')));


        $request->merge(['schedule_delivery_date'   =>$schedule_delivery_date]);
        $request->merge(['payment_due_date'         =>$payment_due_date]);
        $request->merge(['payment_due_date'         =>$payment_due_date]);
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);


        $company_id="";
        $company_type="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
            $company_type=$request->session()->get('company_type');
        }
        else {
            return; 
        }
        $request->merge(['company_id' =>$company_id]);
        $request->merge(['company_type' =>$company_type]);

        DB::beginTransaction();
        $purchase_offer_info= Purchase::find($id)->update($request->all());
        $update_data= array(
            'master_id'                 =>$id,
            'status_active'             =>0,
            'is_deleted'                =>1,
            'updated_by'                =>$user_id,
        );
        $delete_details=PurchaseDetails::where('master_id',"=",$id)->update($update_data);
        $delete_charge=PurchaseCharge::where('master_id',"=",$id)->update($update_data);
       

        $delete_breakdown=PurchaseChargeBreakdown::where('master_id',"=",$id)->update($update_data);

        foreach($request->product_details_arr as $key=>$details)
        {
                      
            if($details['qty']>0)
            {
                $details_data=PurchaseDetails:: create(
                    [
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_name'                 =>$details['item_name'],
                        'product_id'                =>$details['product_id'],
                        'item_description'          =>$details['item_description'],
                        'qty'                       =>$details['qty'],
                        'rate'                      =>$details['rate'],
                        'addition'                  =>$details['addition'],
                        'addition_percent'          =>$details['addition_percent'],
                        'deduction'                 =>$details['deduction'],
                        'deduction_percent'         =>$details['deduction_percent'],
                        'sub_total'                 =>$details['sub_total'],
                        'tax_rate'                  =>$details['tax_rate'],
                        'tax'                       =>$details['tax'],
                        'total'                     =>$details['total'],
                        'inserted_by'               =>$user_id
                    ]
                );
                
                if( !$details_data)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }


                foreach ($details['addition_distribution'] as $key => $value) {

                    $data_charge_breakdown_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'detail_id'                 =>$details_data->id,
                        'charge_id'                 =>$value['reference_id'],
                        'charge_type'               =>1,
                        'amount'                    =>$value['reference_value'],
                        'inserted_by'               =>$user_id,
                    );
                }

                foreach ($details['deduction_distribution'] as $key => $value) {

                    $data_charge_breakdown_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'detail_id'                 =>$details_data->id,
                        'charge_id'                 =>$value['reference_id'],
                        'charge_type'               =>2,
                        'amount'                    =>$value['reference_value'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
                   
        } 

        foreach($request->additional_charge_arr as $key=>$details)
        {
                      
            if($details['amount']>0)
            {
                
                $data_charge_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$id,
                    'charge_id'                 =>$details['reference_id'],
                    'charge_type'               =>1,
                    'amount'                    =>$details['amount'],
                    'inserted_by'               =>$user_id,
                );
                
                
            }
        }

        foreach($request->deduction_charge_arr as $key=>$details)
        {
                      
            if($details['amount']>0)
            {
                  
                $data_charge_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$id,
                    'charge_id'                 =>$details['reference_id'],
                    'charge_type'               =>2,
                    'amount'                    =>$details['amount'],
                    'inserted_by'               =>$user_id,
                );
                
            }
        }

        
        
       

        $RID1=true;
        $RID2=true;
        //echo "$purchase_offer_info  && $RID1 && $RID2";die;
        if(!empty($data_charge_breakdown_details))
        {
            $RID1=PurchaseChargeBreakdown::insert($data_charge_breakdown_details);
        }

        if(!empty($data_charge_details))
        {
            $RID2=PurchaseCharge::insert($data_charge_details);
        }

        if($purchase_offer_info && $delete_details && $delete_charge && $delete_breakdown && $RID1 && $RID2)
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
