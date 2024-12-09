<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccountHolderCustomer;
use App\Models\Product;
use App\Models\InvoiceTerm;
use App\Models\SalesAccountReceivable;
use App\Models\CustomerPassDueInvoice;
use App\Models\SaleslimitPerCustomer;
use App\Models\AllowTransactionPerCustomer;
use App\Models\BannedSaleItemPerCustomer;
use App\Models\CustomerPaymentTerm;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Support\Facades\DB;

class SalesAccountsReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ArrayFunction              =new ArrayFunction();
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        $data['user_type']          =$user_type;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $payment_term_query=InvoiceTerm::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get(['id','term_name','term_description']);


        $payment_term_arr=array();

        foreach($payment_term_query as $value)
        {
            $payment_term_arr[$value->id]=$value->term_name;
        }

        $product_list=Product::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get(['id','product_name','product_description']);

        $data['product_list']=array();
        foreach ($product_list as $key => $value) { 
            $data['product_list'][$value->id]=$value->product_name;
        }       

        $account_holder_list=AccountHolderCustomer::where('status_active',1)
                                        ->where('project_id',$project_id)
                                       // ->where('project_id',$project_id)
                                        ->get();        

        $data['customer_list_arr'] =array();
        $data['customer_payment_term_arr'] =array();
        foreach ($account_holder_list as $key => $value) { 

            $data['customer_list_arr'][$value->id]['customer_name']         =$value->customer_name;
            $data['customer_list_arr'][$value->id]['id']                    =$value->id;
            $data['customer_list_arr'][$value->id]['status_active']         =$value->status_active;
            $data['customer_payment_term_arr'][$value->id]['customer_name'] =$value->customer_name;
            $data['customer_payment_term_arr'][$value->id]['customer_id']     =$value->id;
            foreach($payment_term_arr as $index=>$val)
            {
                $data['customer_payment_term_arr'][$value->id]['term'][$index]['value']="";
                $data['customer_payment_term_arr'][$value->id]['term'][$index]['id']="";
            }
        }

        $data['payment_term_arr'] =$payment_term_arr;

        
        $data['sales_limit_per_customers'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['sales_limit_per_customers'][$value->id]['customer_name']         =$value->customer_name;
            $data['sales_limit_per_customers'][$value->id]['customer_id']           =$value->id; 
            $data['sales_limit_per_customers'][$value->id]['amount']              ="";
            $data['sales_limit_per_customers'][$value->id]['quantity']            ="";
            $data['sales_limit_per_customers'][$value->id]['product_id']          ="";
            $data['sales_limit_per_customers'][$value->id]['product_name']        ="";
            $data['sales_limit_per_customers'][$value->id]['from']                ="";
            $data['sales_limit_per_customers'][$value->id]['to']                  ="";
            $data['sales_limit_per_customers'][$value->id]['id']                  ="";
        } 

        
        $data['past_due_invoices_arr'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['past_due_invoices_arr'][$value->id]['customer_name']             =$value->customer_name;
            $data['past_due_invoices_arr'][$value->id]['customer_id']               =$value->id; 
            $data['past_due_invoices_arr'][$value->id]['sale_offer']          ="";
            $data['past_due_invoices_arr'][$value->id]['sale_order']          ="";
            $data['past_due_invoices_arr'][$value->id]['packing_slip']            ="";
            $data['past_due_invoices_arr'][$value->id]['sale_invoice']        ="";
            $data['past_due_invoices_arr'][$value->id]['sale_return']         ="";
            $data['past_due_invoices_arr'][$value->id]['sale_debit_note']     ="";
            $data['past_due_invoices_arr'][$value->id]['sale_credit_note']    ="";
            $data['past_due_invoices_arr'][$value->id]['id']                      ="";
        }

        

        $data['allow_transaction_customer_arr'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['allow_transaction_customer_arr'][$value->id]['customer_name']             =$value->customer_name;
            $data['allow_transaction_customer_arr'][$value->id]['customer_id']               =$value->id; 
            $data['allow_transaction_customer_arr'][$value->id]['id']                      =""; 
            $data['allow_transaction_customer_arr'][$value->id]['sale_offer']          ="";
            $data['allow_transaction_customer_arr'][$value->id]['sale_order']          ="";
            $data['allow_transaction_customer_arr'][$value->id]['packing_slip']            ="";
            $data['allow_transaction_customer_arr'][$value->id]['sale_invoice']        ="";
            $data['allow_transaction_customer_arr'][$value->id]['sale_return']         ="";
            $data['allow_transaction_customer_arr'][$value->id]['sale_debit_note']     ="";
            $data['allow_transaction_customer_arr'][$value->id]['sale_credit_note']    ="";
            $data['allow_transaction_customer_arr'][$value->id]['id']                      ="";
        }


        $data['banned_sale_item_per_customer'] =array(); 
        foreach ($account_holder_list as $key => $value) {  

            $data['banned_sale_item_per_customer'][$value->id]['customer_name']         =$value->customer_name;
            $data['banned_sale_item_per_customer'][$value->id]['customer_id']           =$value->id; 
            $data['banned_sale_item_per_customer'][$value->id]['amount']              ="";
            $data['banned_sale_item_per_customer'][$value->id]['quantity']            ="";
            $data['banned_sale_item_per_customer'][$value->id]['product_id']          ="";
            $data['banned_sale_item_per_customer'][$value->id]['product_name']        ="";
            $data['banned_sale_item_per_customer'][$value->id]['id']                  ="";
        } 


        $SalesAccountReceivable_list=SalesAccountReceivable::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->first(); 
        if(!empty($SalesAccountReceivable_list))
        {
            $data['SalesAccountReceivableID']               =$SalesAccountReceivable_list->id;
            $data['SalesAccountReceivableCompanyID']        =$SalesAccountReceivable_list->company_id;
            $data['SalesAccountReceivablePostingStatus']    =$SalesAccountReceivable_list->posting_status;
            $id                                             =$SalesAccountReceivable_list->id;

            $seller_sale_limit_list=SaleslimitPerCustomer::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 
            foreach ($seller_sale_limit_list as $key => $value) { 

                $data['sales_limit_per_customers'][$value->customer_id]['customer_name']         =$value->customer_name;
                $data['sales_limit_per_customers'][$value->customer_id]['customer_id']           =$value->customer_id; 
                $data['sales_limit_per_customers'][$value->customer_id]['amount']              =$value->amount;
                $data['sales_limit_per_customers'][$value->customer_id]['quantity']            =$value->quantity;
                $data['sales_limit_per_customers'][$value->customer_id]['product_id']          =$value->product_id;
                $data['sales_limit_per_customers'][$value->customer_id]['product_name']        =$value->product_name;
                $data['sales_limit_per_customers'][$value->customer_id]['from']                =$value->from;
                $data['sales_limit_per_customers'][$value->customer_id]['to']                  =$value->to;
                $data['sales_limit_per_customers'][$value->customer_id]['id']                  =$value->id;
            }


            $seller_payment_term_list=CustomerPaymentTerm::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 

            foreach ($seller_payment_term_list as $key => $value) { 

                $data['customer_payment_term_arr'][$value->customer_id]['customer_name']                      =$value->customer_name;
                $data['customer_payment_term_arr'][$value->customer_id]['customer_id']                        =$value->customer_id;
                $data['customer_payment_term_arr'][$value->customer_id]['term'][$value->term_id]['value']   =$value->value;
                $data['customer_payment_term_arr'][$value->customer_id]['term'][$value->term_id]['id']      =$value->id;
                
            }

            $pass_due_invoice_list=CustomerPassDueInvoice::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 
            foreach ($pass_due_invoice_list as $key => $value) { 

                $data['past_due_invoices_arr'][$value->customer_id]['customer_name']             =$value->customer_name;
                $data['past_due_invoices_arr'][$value->customer_id]['customer_id']               =$value->customer_id; 
                $data['past_due_invoices_arr'][$value->customer_id]['sale_offer']          =$value->sale_offer;
                $data['past_due_invoices_arr'][$value->customer_id]['sale_order']          =$value->sale_order;
                $data['past_due_invoices_arr'][$value->customer_id]['packing_slip']            =$value->packing_slip;
                $data['past_due_invoices_arr'][$value->customer_id]['sale_invoice']        =$value->sale_invoice;
                $data['past_due_invoices_arr'][$value->customer_id]['sale_return']         =$value->sale_return;
                $data['past_due_invoices_arr'][$value->customer_id]['sale_debit_note']     =$value->sale_debit_note;
                $data['past_due_invoices_arr'][$value->customer_id]['sale_credit_note']    =$value->sale_credit_note;
                $data['past_due_invoices_arr'][$value->customer_id]['id']                      =$value->id;
            }

            $seller_allow_transaction_list=AllowTransactionPerCustomer::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 

            foreach ($seller_allow_transaction_list as $key => $value) { 

                $data['allow_transaction_customer_arr'][$value->customer_id]['customer_name']             =$value->customer_name;
                $data['allow_transaction_customer_arr'][$value->customer_id]['customer_id']               =$value->customer_id; 
                $data['allow_transaction_customer_arr'][$value->customer_id]['id']                      =$value->id; 
                $data['allow_transaction_customer_arr'][$value->customer_id]['sale_offer']          =$value->sale_offer;
                $data['allow_transaction_customer_arr'][$value->customer_id]['sale_order']          =$value->sale_order;
                $data['allow_transaction_customer_arr'][$value->customer_id]['packing_slip']            =$value->packing_slip;
                $data['allow_transaction_customer_arr'][$value->customer_id]['sale_invoice']        =$value->sale_invoice;
                $data['allow_transaction_customer_arr'][$value->customer_id]['sale_return']         =$value->sale_return;
                $data['allow_transaction_customer_arr'][$value->customer_id]['sale_debit_note']     =$value->sale_debit_note;
                $data['allow_transaction_customer_arr'][$value->customer_id]['sale_credit_note']    =$value->sale_credit_note;
            }

            $banned_sale_item_seller_list=BannedSaleItemPerCustomer::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get();

            foreach ($banned_sale_item_seller_list as $key => $value) { 

                $data['banned_sale_item_per_customer'][$value->customer_id]['customer_name']         =$value->customer_name;
                $data['banned_sale_item_per_customer'][$value->customer_id]['customer_id']           =$value->customer_id; 
                $data['banned_sale_item_per_customer'][$value->customer_id]['amount']              =$value->amount;
                $data['banned_sale_item_per_customer'][$value->customer_id]['quantity']            =$value->quantity;
                $data['banned_sale_item_per_customer'][$value->customer_id]['product_id']          =$value->product_id;
                $data['banned_sale_item_per_customer'][$value->customer_id]['product_name']        =$value->product_name;
                $data['banned_sale_item_per_customer'][$value->customer_id]['id']                  =$value->id;
            } 

        }
        else
        {
            $data['SalesAccountReceivableID']               ="";
            $data['SalesAccountReceivableCompanyID']        =$company_id;
            $data['SalesAccountReceivablePostingStatus']    =0;
           
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
        

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['inserted_by'      =>$user_id]);
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['company_id'     =>$company_id]);       

        DB::beginTransaction();
        $sale_info= SalesAccountReceivable::create($request->all());


       
        foreach($request->sales_limit_per_customers as $key=>$details)
        {
                      
            if($details['product_id'])
            {
                
                $from                           =date("Y-m-d",strtotime($details['from']));
                $to                             =date("Y-m-d",strtotime($details['to']));
                $data_sale_limit[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$sale_info->id,
                    'company_id'                =>$company_id,
                    'customer_id'                 =>$details['customer_id'],
                    'customer_name'               =>$details['customer_name'],
                    'product_id'                =>$details['product_id'],
                    'product_name'              =>$details['product_name'],
                    'quantity'                  =>$details['quantity'],
                    'amount'                    =>$details['amount'],
                    'from'                      =>$from,
                    'to'                        =>$to,
                    'inserted_by'               =>$user_id,
                );
                
            }
                   
        } 

        foreach($request->past_due_invoices_arr as $key=>$details)
        {
                      
            if($details['sale_offer'])
            {
                
                $data_past_due_invoice[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$sale_info->id,
                    'company_id'                =>$company_id,
                    'customer_id'                 =>$details['customer_id'],
                    'customer_name'               =>$details['customer_name'],
                    'sale_offer'            =>$details['sale_offer'],
                    'sale_order'            =>$details['sale_order'],
                    'packing_slip'              =>$details['packing_slip'],
                    'sale_invoice'          =>$details['sale_invoice'],
                    'sale_return'           =>$details['sale_return'],
                    'sale_debit_note'       =>$details['sale_debit_note'],
                    'sale_credit_note'      =>$details['sale_credit_note'],
                    'inserted_by'               =>$user_id,
                );
                
            }
                   
        }
       

        foreach($request->allow_transaction_customer_arr as $key=>$details)
        {
                      
            if($details['sale_offer'])
            {
                
                $data_allow_transaction[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$sale_info->id,
                    'company_id'                =>$company_id,
                    'customer_id'                 =>$details['customer_id'],
                    'customer_name'               =>$details['customer_name'],
                    'sale_offer'            =>$details['sale_offer'],
                    'sale_order'            =>$details['sale_order'],
                    'packing_slip'              =>$details['packing_slip'],
                    'sale_invoice'          =>$details['sale_invoice'],
                    'sale_return'           =>$details['sale_return'],
                    'sale_debit_note'       =>$details['sale_debit_note'],
                    'sale_credit_note'      =>$details['sale_credit_note'],
                    'inserted_by'               =>$user_id,
                );
                
            }
                   
        }

        foreach($request->banned_sale_item_per_customer as $key=>$details)
        {
                      
            if($details['product_id'])
            {

                $data_banned_sale_item[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$sale_info->id,
                    'company_id'                =>$company_id,
                    'customer_id'                 =>$details['customer_id'],
                    'customer_name'               =>$details['customer_name'],
                    'product_id'                =>$details['product_id'],
                    'product_name'              =>$details['product_name'],
                    'quantity'                  =>$details['quantity'],
                    'amount'                    =>$details['amount'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

        

        foreach($request->customer_payment_term_arr as $key=>$seller_details)
        {

            foreach($seller_details['term'] as $key=>$details)
            {
                if($details['value'])
                {
                    $data_seller_payament_term[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$sale_info->id,
                        'company_id'                =>$company_id,
                        'customer_id'                 =>$seller_details['customer_id'],
                        'customer_name'               =>$seller_details['customer_name'],
                        'term_id'                   =>$key,
                        'value'                     =>$details['value'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
        } 

        foreach($request->customer_list_arr as $key=>$details)
        {
            if($details['id']!="")
            {
                $seller_details_data= array(
                    'status_active'             =>$details['status_active'],
                    'updated_by'                =>$user_id,
                );

                $sellerData=AccountHolderCustomer::where('id',"=",$details['id'])->update($seller_details_data);
                if( !$sellerData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
        }
        
        $RId1=true;
        $RId2=true;
        $RId3=true;
        $RId4=true;
        $RId5=true;
        $RId6=true;

        if(!empty($data_seller_payament_term))
        {
            $RId1=CustomerPaymentTerm::insert($data_seller_payament_term);
        }


        if(!empty($data_banned_sale_item))
        {
            $RId2=BannedSaleItemPerCustomer::insert($data_banned_sale_item);
        }

        if(!empty($data_allow_transaction))
        {
            $RId3=AllowTransactionPerCustomer::insert($data_allow_transaction);
        }

        if(!empty($data_sale_limit))
        {
            $RId4=SaleslimitPerCustomer::insert($data_sale_limit);
        }
        if(!empty($data_past_due_invoice))
        {
            $RId5=CustomerPassDueInvoice::insert($data_past_due_invoice);
        }

        if($sale_info  && $RId1 && $RId2 && $RId3 && $RId4 && $RId5)
        {
           DB::commit();
           return "1**$sale_info->id";
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
    public function edit($id,Request $request)
    {
        $ArrayFunction              =new ArrayFunction();
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        $data['user_type']          =$user_type;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $payment_term_query=InvoiceTerm::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get(['id','term_name','term_description']);


        $payment_term_arr=array();

        foreach($payment_term_query as $value)
        {
            $payment_term_arr[$value->id]=$value->term_name;
        }

        $product_list=Product::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get(['id','product_name','product_description']);

        $data['product_list']=array();
        foreach ($product_list as $key => $value) { 
            $data['product_list'][$value->id]=$value->product_name;
        }

        $SalesAccountReceivable_list=SalesAccountReceivable::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('id',$id)
                                        ->first(); 
        $data['SalesAccountReceivable'] =$SalesAccountReceivable_list;

        $account_holder_list=AccountHolderCustomer::where('status_active',1)
                                        ->where('project_id',$project_id)
                                       // ->where('project_id',$project_id)
                                        ->get();        

        $data['customer_list_arr'] =array();
        $data['customer_payment_term_arr'] =array();
        foreach ($account_holder_list as $key => $value) { 

            $data['customer_list_arr'][$value->id]['customer_name']           =$value->customer_name;
            $data['customer_list_arr'][$value->id]['id']                    =$value->id;
            $data['customer_list_arr'][$value->id]['status_active']         =$value->status_active;
            $data['customer_payment_term_arr'][$value->id]['customer_name']   =$value->customer_name;
            $data['customer_payment_term_arr'][$value->id]['customer_id']     =$value->id;
            foreach($payment_term_arr as $index=>$val)
            {
                $data['customer_payment_term_arr'][$value->id]['term'][$index]['value']="";
                $data['customer_payment_term_arr'][$value->id]['term'][$index]['id']="";
            }
        }

        $data['payment_term_arr'] =$payment_term_arr;

        $seller_payment_term_list=CustomerPaymentTerm::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 

        foreach ($seller_payment_term_list as $key => $value) { 

            $data['customer_payment_term_arr'][$value->customer_id]['customer_name']                      =$value->customer_name;
            $data['customer_payment_term_arr'][$value->customer_id]['customer_id']                        =$value->customer_id;
            $data['customer_payment_term_arr'][$value->customer_id]['term'][$value->term_id]['value']   =$value->value;
            $data['customer_payment_term_arr'][$value->customer_id]['term'][$value->term_id]['id']      =$value->id;
            
        }

        $data['sales_limit_per_customers'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['sales_limit_per_customers'][$value->id]['customer_name']         =$value->customer_name;
            $data['sales_limit_per_customers'][$value->id]['customer_id']           =$value->id; 
            $data['sales_limit_per_customers'][$value->id]['amount']              ="";
            $data['sales_limit_per_customers'][$value->id]['quantity']            ="";
            $data['sales_limit_per_customers'][$value->id]['product_id']          ="";
            $data['sales_limit_per_customers'][$value->id]['product_name']        ="";
            $data['sales_limit_per_customers'][$value->id]['from']                ="";
            $data['sales_limit_per_customers'][$value->id]['to']                  ="";
            $data['sales_limit_per_customers'][$value->id]['id']                  ="";
        } 

        $seller_sale_limit_list=SaleslimitPerCustomer::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 
        foreach ($seller_sale_limit_list as $key => $value) { 

            $data['sales_limit_per_customers'][$value->customer_id]['customer_name']         =$value->customer_name;
            $data['sales_limit_per_customers'][$value->customer_id]['customer_id']           =$value->customer_id; 
            $data['sales_limit_per_customers'][$value->customer_id]['amount']              =$value->amount;
            $data['sales_limit_per_customers'][$value->customer_id]['quantity']            =$value->quantity;
            $data['sales_limit_per_customers'][$value->customer_id]['product_id']          =$value->product_id;
            $data['sales_limit_per_customers'][$value->customer_id]['product_name']        =$value->product_name;
            $data['sales_limit_per_customers'][$value->customer_id]['from']                =$value->from;
            $data['sales_limit_per_customers'][$value->customer_id]['to']                  =$value->to;
            $data['sales_limit_per_customers'][$value->customer_id]['id']                  =$value->id;
        }

        $data['past_due_invoices_arr'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['past_due_invoices_arr'][$value->id]['customer_name']             =$value->customer_name;
            $data['past_due_invoices_arr'][$value->id]['customer_id']               =$value->id; 
            $data['past_due_invoices_arr'][$value->id]['sale_offer']          ="";
            $data['past_due_invoices_arr'][$value->id]['sale_order']          ="";
            $data['past_due_invoices_arr'][$value->id]['packing_slip']            ="";
            $data['past_due_invoices_arr'][$value->id]['sale_invoice']        ="";
            $data['past_due_invoices_arr'][$value->id]['sale_return']         ="";
            $data['past_due_invoices_arr'][$value->id]['sale_debit_note']     ="";
            $data['past_due_invoices_arr'][$value->id]['sale_credit_note']    ="";
            $data['past_due_invoices_arr'][$value->id]['id']                      ="";
        }

        $pass_due_invoice_list=CustomerPassDueInvoice::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 
        foreach ($pass_due_invoice_list as $key => $value) { 

            $data['past_due_invoices_arr'][$value->customer_id]['customer_name']             =$value->customer_name;
            $data['past_due_invoices_arr'][$value->customer_id]['customer_id']               =$value->customer_id; 
            $data['past_due_invoices_arr'][$value->customer_id]['sale_offer']          =$value->sale_offer;
            $data['past_due_invoices_arr'][$value->customer_id]['sale_order']          =$value->sale_order;
            $data['past_due_invoices_arr'][$value->customer_id]['packing_slip']            =$value->packing_slip;
            $data['past_due_invoices_arr'][$value->customer_id]['sale_invoice']        =$value->sale_invoice;
            $data['past_due_invoices_arr'][$value->customer_id]['sale_return']         =$value->sale_return;
            $data['past_due_invoices_arr'][$value->customer_id]['sale_debit_note']     =$value->sale_debit_note;
            $data['past_due_invoices_arr'][$value->customer_id]['sale_credit_note']    =$value->sale_credit_note;
            $data['past_due_invoices_arr'][$value->customer_id]['id']                      =$value->id;
        }

        $data['allow_transaction_customer_arr'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['allow_transaction_customer_arr'][$value->id]['customer_name']             =$value->customer_name;
            $data['allow_transaction_customer_arr'][$value->id]['customer_id']               =$value->id; 
            $data['allow_transaction_customer_arr'][$value->id]['id']                      =""; 
            $data['allow_transaction_customer_arr'][$value->id]['sale_offer']          ="";
            $data['allow_transaction_customer_arr'][$value->id]['sale_order']          ="";
            $data['allow_transaction_customer_arr'][$value->id]['packing_slip']            ="";
            $data['allow_transaction_customer_arr'][$value->id]['sale_invoice']        ="";
            $data['allow_transaction_customer_arr'][$value->id]['sale_return']         ="";
            $data['allow_transaction_customer_arr'][$value->id]['sale_debit_note']     ="";
            $data['allow_transaction_customer_arr'][$value->id]['sale_credit_note']    ="";
            $data['allow_transaction_customer_arr'][$value->id]['id']                      ="";
        }

        $seller_allow_transaction_list=AllowTransactionPerCustomer::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 

        foreach ($seller_allow_transaction_list as $key => $value) { 

            $data['allow_transaction_customer_arr'][$value->customer_id]['customer_name']             =$value->customer_name;
            $data['allow_transaction_customer_arr'][$value->customer_id]['customer_id']               =$value->customer_id; 
            $data['allow_transaction_customer_arr'][$value->customer_id]['id']                      =$value->id; 
            $data['allow_transaction_customer_arr'][$value->customer_id]['sale_offer']          =$value->sale_offer;
            $data['allow_transaction_customer_arr'][$value->customer_id]['sale_order']          =$value->sale_order;
            $data['allow_transaction_customer_arr'][$value->customer_id]['packing_slip']            =$value->packing_slip;
            $data['allow_transaction_customer_arr'][$value->customer_id]['sale_invoice']        =$value->sale_invoice;
            $data['allow_transaction_customer_arr'][$value->customer_id]['sale_return']         =$value->sale_return;
            $data['allow_transaction_customer_arr'][$value->customer_id]['sale_debit_note']     =$value->sale_debit_note;
            $data['allow_transaction_customer_arr'][$value->customer_id]['sale_credit_note']    =$value->sale_credit_note;
        }

        $data['banned_sale_item_per_customer'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['banned_sale_item_per_customer'][$value->id]['customer_name']         =$value->customer_name;
            $data['banned_sale_item_per_customer'][$value->id]['customer_id']           =$value->id; 
            $data['banned_sale_item_per_customer'][$value->id]['amount']              ="";
            $data['banned_sale_item_per_customer'][$value->id]['quantity']            ="";
            $data['banned_sale_item_per_customer'][$value->id]['product_id']          ="";
            $data['banned_sale_item_per_customer'][$value->id]['product_name']        ="";
            $data['banned_sale_item_per_customer'][$value->id]['id']                  ="";
        } 


        $banned_sale_item_seller_list=BannedSaleItemPerCustomer::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get();

        foreach ($banned_sale_item_seller_list as $key => $value) { 

            $data['banned_sale_item_per_customer'][$value->customer_id]['customer_name']         =$value->customer_name;
            $data['banned_sale_item_per_customer'][$value->customer_id]['customer_id']           =$value->customer_id; 
            $data['banned_sale_item_per_customer'][$value->customer_id]['amount']              =$value->amount;
            $data['banned_sale_item_per_customer'][$value->customer_id]['quantity']            =$value->quantity;
            $data['banned_sale_item_per_customer'][$value->customer_id]['product_id']          =$value->product_id;
            $data['banned_sale_item_per_customer'][$value->customer_id]['product_name']        =$value->product_name;
            $data['banned_sale_item_per_customer'][$value->customer_id]['id']                  =$value->id;
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
        

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);


        DB::beginTransaction();
        $sale_info= SalesAccountReceivable::find($id)->update($request->all());


        foreach($request->sales_limit_per_customers as $key=>$details)
        {
                      
            if($details['product_id'])
            {
                $from                           =date("Y-m-d",strtotime($details['from']));
                $to                             =date("Y-m-d",strtotime($details['to']));
                if($details['id']!="")
                {
                    $sale_limit_details_data= array(
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'product_id'                =>$details['product_id'],
                        'product_name'              =>$details['product_name'],
                        'quantity'                  =>$details['quantity'],
                        'amount'                    =>$details['amount'],
                        'from'                      =>$from,
                        'to'                        =>$to,
                        'updated_by'                =>$user_id,
                    );

                    $sellerPurchaseLimit=SaleslimitPerCustomer::where('id',"=",$details['id'])->update($sale_limit_details_data);
                    if( !$sellerPurchaseLimit)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                   
                    $data_sale_limit[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'company_id'                =>$company_id,
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'product_id'                =>$details['product_id'],
                        'product_name'              =>$details['product_name'],
                        'quantity'                  =>$details['quantity'],
                        'amount'                    =>$details['amount'],
                        'from'                      =>$from,
                        'to'                        =>$to,
                        'inserted_by'               =>$user_id,
                    );
                
                }
            }
                   
        } 

        // Safety Item====================================================

        foreach($request->past_due_invoices_arr as $key=>$details)
        {
                      
            if($details['sale_offer'])
            {
                 if($details['id']!="")
                {
                    $past_due_invoice_data= array(
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'sale_offer'            =>$details['sale_offer'],
                        'sale_order'            =>$details['sale_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'sale_invoice'          =>$details['sale_invoice'],
                        'sale_return'           =>$details['sale_return'],
                        'sale_debit_note'       =>$details['sale_debit_note'],
                        'sale_credit_note'      =>$details['sale_credit_note'],
                        'updated_by'                =>$user_id,
                    );

                    $sellerCustomerPassDueInvoice=CustomerPassDueInvoice::where('id',"=",$details['id'])->update($past_due_invoice_data);
                    if( !$sellerCustomerPassDueInvoice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_past_due_invoice[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'company_id'                =>$company_id,
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'sale_offer'            =>$details['sale_offer'],
                        'sale_order'            =>$details['sale_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'sale_invoice'          =>$details['sale_invoice'],
                        'sale_return'           =>$details['sale_return'],
                        'sale_debit_note'       =>$details['sale_debit_note'],
                        'sale_credit_note'      =>$details['sale_credit_note'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
                   
        }

        foreach($request->allow_transaction_customer_arr as $key=>$details)
        {
                      
            if($details['sale_offer'])
            {
                if($details['id']!="")
                {
                    $allow_transaction_seller_data= array(
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'sale_offer'            =>$details['sale_offer'],
                        'sale_order'            =>$details['sale_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'sale_invoice'          =>$details['sale_invoice'],
                        'sale_return'           =>$details['sale_return'],
                        'sale_debit_note'       =>$details['sale_debit_note'],
                        'sale_credit_note'      =>$details['sale_credit_note'],
                        'updated_by'                =>$user_id,
                    );

                    $sellerTransactionAllow=AllowTransactionPerCustomer::where('id',"=",$details['id'])->update($allow_transaction_seller_data);
                    if( !$sellerTransactionAllow)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_allow_transaction[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'company_id'                =>$company_id,
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'sale_offer'            =>$details['sale_offer'],
                        'sale_order'            =>$details['sale_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'sale_invoice'          =>$details['sale_invoice'],
                        'sale_return'           =>$details['sale_return'],
                        'sale_debit_note'       =>$details['sale_debit_note'],
                        'sale_credit_note'      =>$details['sale_credit_note'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
        }

        foreach($request->banned_sale_item_per_customer as $key=>$details)
        {
            if($details['product_id'])
            {
                if($details['id']!="")
                {

                    $banned_sale_item_seller_data= array(
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'product_id'                =>$details['product_id'],
                        'product_name'              =>$details['product_name'],
                        'quantity'                  =>$details['quantity'],
                        'amount'                    =>$details['amount'],
                        'updated_by'                =>$user_id,
                    );

                    $sellerBannedItem=BannedSaleItemPerCustomer::where('id',"=",$details['id'])->update($banned_sale_item_seller_data);
                    if( !$sellerBannedItem)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_banned_sale_item[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$id,
                    'company_id'                =>$company_id,
                    'customer_id'                 =>$details['customer_id'],
                    'customer_name'               =>$details['customer_name'],
                    'product_id'                =>$details['product_id'],
                    'product_name'              =>$details['product_name'],
                    'quantity'                  =>$details['quantity'],
                    'amount'                    =>$details['amount'],
                    'inserted_by'               =>$user_id,
                );
                }
                
            }
        }

        foreach($request->customer_payment_term_arr as $key=>$seller_details)
        {
            
            foreach($seller_details['term'] as $term_id=>$details)
            {
                if($details['value'])
                {
                    if($details['id'])
                    {
                        $seller_payament_term_data= array(
                            
                            'customer_id'                 =>$seller_details['customer_id'],
                            'customer_name'               =>$seller_details['customer_name'],
                            'term_id'                   =>$term_id,
                            'value'                     =>$details['value'],
                            'updated_by'                =>$user_id,
                        );



                        $CustomerPaymentTerm=CustomerPaymentTerm::where('id',"=",$details['id'])->update($seller_payament_term_data);
                        if( !$CustomerPaymentTerm)
                        {
                            // dd($data_seller_payament_term);
                            DB::rollBack();
                            return 10;
                            die;
                        }
                    }
                    else
                    {

                        $data_seller_payament_term[]= array(
                            'project_id'                =>$project_id,
                            'master_id'                 =>$id,
                            'company_id'                =>$company_id,
                            'customer_id'                 =>$seller_details['customer_id'],
                            'customer_name'               =>$seller_details['customer_name'],
                            'term_id'                   =>$term_id,
                            'value'                     =>$details['value'],
                            'inserted_by'               =>$user_id,
                        );

                        //dd($data_seller_payament_term);
                    }
                }

            }
        } 

        foreach($request->customer_list_arr as $key=>$details)
        {
            if($details['id']!="")
            {
                $seller_details_data= array(
                    'status_active'             =>$details['status_active'],
                    'updated_by'                =>$user_id,
                );

                $sellerData=AccountHolderCustomer::where('id',"=",$details['id'])->update($seller_details_data);
                if( !$sellerData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
        }

        $RId1=true;
        $RId2=true;
        $RId3=true;
        $RId4=true;
        $RId5=true;
        $RId6=true;

        if(!empty($data_seller_payament_term))
        {
            $RId1=CustomerPaymentTerm::insert($data_seller_payament_term);
        }


        if(!empty($data_banned_sale_item))
        {
            $RId2=BannedSaleItemPerCustomer::insert($data_banned_sale_item);
        }

        if(!empty($data_allow_transaction))
        {
            $RId3=AllowTransactionPerCustomer::insert($data_allow_transaction);
        }

        if(!empty($data_sale_limit))
        {
            $RId4=SaleslimitPerCustomer::insert($data_sale_limit);
        }
        if(!empty($data_past_due_invoice))
        {
            $RId5=CustomerPassDueInvoice::insert($data_past_due_invoice);
        }

        if($sale_info  && $RId1 && $RId2 && $RId3 && $RId4 && $RId5)
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
      
        $buildingInfo=SalesAccountReceivable::where('id',"=",$id)->update($update_data);

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
        

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);
        $request->merge(['posting_status'   =>3]);


        DB::beginTransaction();
        $sale_info= SalesAccountReceivable::find($id)->update($request->all());


        foreach($request->sales_limit_per_customers as $key=>$details)
        {
                      
            if($details['product_id'])
            {
                $from                           =date("Y-m-d",strtotime($details['from']));
                $to                             =date("Y-m-d",strtotime($details['to']));
                if($details['id']!="")
                {
                    $sale_limit_details_data= array(
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'product_id'                =>$details['product_id'],
                        'product_name'              =>$details['product_name'],
                        'quantity'                  =>$details['quantity'],
                        'amount'                    =>$details['amount'],
                        'from'                      =>$from,
                        'to'                        =>$to,
                        'updated_by'                =>$user_id,
                    );

                    $sellerPurchaseLimit=SaleslimitPerCustomer::where('id',"=",$details['id'])->update($sale_limit_details_data);
                    if( !$sellerPurchaseLimit)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                   
                    $data_sale_limit[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'company_id'                =>$company_id,
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'product_id'                =>$details['product_id'],
                        'product_name'              =>$details['product_name'],
                        'quantity'                  =>$details['quantity'],
                        'amount'                    =>$details['amount'],
                        'from'                      =>$from,
                        'to'                        =>$to,
                        'inserted_by'               =>$user_id,
                    );
                
                }
            }
                   
        } 

        // Safety Item====================================================

        foreach($request->past_due_invoices_arr as $key=>$details)
        {
                      
            if($details['sale_offer'])
            {
                 if($details['id']!="")
                {
                    $past_due_invoice_data= array(
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'sale_offer'            =>$details['sale_offer'],
                        'sale_order'            =>$details['sale_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'sale_invoice'          =>$details['sale_invoice'],
                        'sale_return'           =>$details['sale_return'],
                        'sale_debit_note'       =>$details['sale_debit_note'],
                        'sale_credit_note'      =>$details['sale_credit_note'],
                        'updated_by'                =>$user_id,
                    );

                    $sellerCustomerPassDueInvoice=CustomerPassDueInvoice::where('id',"=",$details['id'])->update($past_due_invoice_data);
                    if( !$sellerCustomerPassDueInvoice)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_past_due_invoice[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'company_id'                =>$company_id,
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'sale_offer'            =>$details['sale_offer'],
                        'sale_order'            =>$details['sale_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'sale_invoice'          =>$details['sale_invoice'],
                        'sale_return'           =>$details['sale_return'],
                        'sale_debit_note'       =>$details['sale_debit_note'],
                        'sale_credit_note'      =>$details['sale_credit_note'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
                   
        }

        foreach($request->allow_transaction_customer_arr as $key=>$details)
        {
                      
            if($details['sale_offer'])
            {
                if($details['id']!="")
                {
                    $allow_transaction_seller_data= array(
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'sale_offer'            =>$details['sale_offer'],
                        'sale_order'            =>$details['sale_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'sale_invoice'          =>$details['sale_invoice'],
                        'sale_return'           =>$details['sale_return'],
                        'sale_debit_note'       =>$details['sale_debit_note'],
                        'sale_credit_note'      =>$details['sale_credit_note'],
                        'updated_by'                =>$user_id,
                    );

                    $sellerTransactionAllow=AllowTransactionPerCustomer::where('id',"=",$details['id'])->update($allow_transaction_seller_data);
                    if( !$sellerTransactionAllow)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_allow_transaction[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'company_id'                =>$company_id,
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'sale_offer'            =>$details['sale_offer'],
                        'sale_order'            =>$details['sale_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'sale_invoice'          =>$details['sale_invoice'],
                        'sale_return'           =>$details['sale_return'],
                        'sale_debit_note'       =>$details['sale_debit_note'],
                        'sale_credit_note'      =>$details['sale_credit_note'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
        }

        foreach($request->banned_sale_item_per_customer as $key=>$details)
        {
            if($details['product_id'])
            {
                if($details['id']!="")
                {
                    $banned_sale_item_seller_data= array(
                        'customer_id'                 =>$details['customer_id'],
                        'customer_name'               =>$details['customer_name'],
                        'product_id'                =>$details['product_id'],
                        'product_name'              =>$details['product_name'],
                        'quantity'                  =>$details['quantity'],
                        'amount'                    =>$details['amount'],
                        'updated_by'                =>$user_id,
                    );

                    $sellerBannedItem=BannedSaleItemPerCustomer::where('id',"=",$details['id'])->update($banned_sale_item_seller_data);
                    if( !$sellerBannedItem)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_banned_sale_item[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$sale_info->id,
                    'company_id'                =>$company_id,
                    'customer_id'                 =>$details['customer_id'],
                    'customer_name'               =>$details['customer_name'],
                    'product_id'                =>$details['product_id'],
                    'product_name'              =>$details['product_name'],
                    'quantity'                  =>$details['quantity'],
                    'amount'                    =>$details['amount'],
                    'inserted_by'               =>$user_id,
                );
                }
                
            }
        }

        foreach($request->customer_payment_term_arr as $key=>$seller_details)
        {
            
            foreach($seller_details['term'] as $term_id=>$details)
            {
                if($details['value'])
                {
                    if($details['id'])
                    {
                        $data_seller_payament_term= array(
                            
                            'customer_id'                 =>$seller_details['customer_id'],
                            'customer_name'               =>$seller_details['customer_name'],
                            'term_id'                   =>$term_id,
                            'value'                     =>$details['value'],
                            'updated_by'                =>$user_id,
                        );



                        $CustomerPaymentTerm=CustomerPaymentTerm::where('id',"=",$details['id'])->update($data_seller_payament_term);
                        if( !$CustomerPaymentTerm)
                        {
                            // dd($data_seller_payament_term);
                            DB::rollBack();
                            return 10;
                            die;
                        }
                    }
                    else
                    {
                        $data_seller_payament_term[]= array(
                            'project_id'                =>$project_id,
                            'master_id'                 =>$id,
                            'company_id'                =>$company_id,
                            'customer_id'                 =>$seller_details['customer_id'],
                            'customer_name'               =>$seller_details['customer_name'],
                            'term_id'                   =>$term_id,
                            'value'                     =>$details['value'],
                            'inserted_by'               =>$user_id,
                        );
                    }
                }

            }
        }

        foreach($request->customer_list_arr as $key=>$details)
        {
            if($details['id']!="")
            {
                $seller_details_data= array(
                    'status_active'             =>$details['status_active'],
                    'updated_by'                =>$user_id,
                );

                $sellerData=AccountHolderCustomer::where('id',"=",$details['id'])->update($seller_details_data);
                if( !$sellerData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
            }
        } 

        $RId1=true;
        $RId2=true;
        $RId3=true;
        $RId4=true;
        $RId5=true;
        $RId6=true;

        if(!empty($data_seller_payament_term))
        {
            $RId1=CustomerPaymentTerm::insert($data_seller_payament_term);
        }


        if(!empty($data_banned_sale_item))
        {
            $RId2=BannedSaleItemPerCustomer::insert($data_banned_sale_item);
        }

        if(!empty($data_allow_transaction))
        {
            $RId3=AllowTransactionPerCustomer::insert($data_allow_transaction);
        }

        if(!empty($data_sale_limit))
        {
            $RId4=SaleslimitPerCustomer::insert($data_sale_limit);
        }
        if(!empty($data_past_due_invoice))
        {
            $RId5=CustomerPassDueInvoice::insert($data_past_due_invoice);
        }

        if($sale_info  && $RId1 && $RId2 && $RId3 && $RId4 && $RId5)
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
      
        $buildingInfo=SalesAccountReceivable::where('id',"=",$id)->update($update_data);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        $RID_delete=true;
        $RID1_delete=true;
        $RID2_delete=true;
        $RID3_delete=true;
        $RID4_delete=true;
        $RID5_delete=true;

        $update_data= array(
                        
                            'status_active'             =>0,
                            'is_deleted'                =>1,
                            'updated_by'                =>$user_id,
                        );

        $RID_delete=SalesAccountReceivable::where('id',"=",$id)->update($update_data);
        $RID1_delete=SaleslimitPerCustomer::where('master_id',"=",$id)->update($update_data);
        $RID2_delete=CustomerPassDueInvoice::where('master_id',"=",$id)->update($update_data);
        $RID3_delete=AllowTransactionPerCustomer::where('master_id',"=",$id)->update($update_data);
        $RID4_delete=BannedSaleItemPerCustomer::where('master_id',"=",$id)->update($update_data);
        $RID5_delete=CustomerPaymentTerm::where('master_id',"=",$id)->update($update_data);
       // $RID_delete=SalesAccountReceivable::where('id',"=",$id)->update($update_data);


        if($RID_delete  && $RID1_delete && $RID2_delete && $RID3_delete && $RID4_delete && $RID5_delete)
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
