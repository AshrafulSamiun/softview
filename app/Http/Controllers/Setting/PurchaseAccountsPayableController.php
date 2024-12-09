<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccountHolderSeller;
use App\Models\Product;
use App\Models\InvoiceTerm;
use App\Models\PurchaseAccountPayable;
use App\Models\PassDueInvoice;
use App\Models\PurchaseLimitPerSeller;
use App\Models\AllowTransactionPerSeller;
use App\Models\BannedPurchaseItemPerSeller;
use App\Models\SellerPaymentTerm;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Support\Facades\DB;

class PurchaseAccountsPayableController extends Controller
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

       
        

        $account_holder_list=AccountHolderSeller::where('status_active',1)
                                        ->where('project_id',$project_id)
                                       // ->where('project_id',$project_id)
                                        ->get();        

        $data['seller_list_arr'] =array();
        $data['seller_payment_term_arr'] =array();
        foreach ($account_holder_list as $key => $value) { 

            $data['seller_list_arr'][$value->id]['seller_name']           =$value->seller_name;
            $data['seller_list_arr'][$value->id]['id']                    =$value->id;
            $data['seller_list_arr'][$value->id]['status_active']         =$value->status_active;
            $data['seller_payment_term_arr'][$value->id]['seller_name']   =$value->seller_name;
            $data['seller_payment_term_arr'][$value->id]['seller_id']     =$value->id;
            foreach($payment_term_arr as $index=>$val)
            {
                $data['seller_payment_term_arr'][$value->id]['term'][$index]['value']="";
                $data['seller_payment_term_arr'][$value->id]['term'][$index]['id']="";
            }
        }

        $data['payment_term_arr'] =$payment_term_arr;

        
        $data['purchase_limit_per_seller'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['purchase_limit_per_seller'][$value->id]['seller_name']         =$value->seller_name;
            $data['purchase_limit_per_seller'][$value->id]['seller_id']           =$value->id; 
            $data['purchase_limit_per_seller'][$value->id]['amount']              ="";
            $data['purchase_limit_per_seller'][$value->id]['quantity']            ="";
            $data['purchase_limit_per_seller'][$value->id]['product_id']          ="";
            $data['purchase_limit_per_seller'][$value->id]['product_name']        ="";
            $data['purchase_limit_per_seller'][$value->id]['from']                ="";
            $data['purchase_limit_per_seller'][$value->id]['to']                  ="";
            $data['purchase_limit_per_seller'][$value->id]['id']                  ="";
        } 

        
        $data['past_due_invoices_arr'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['past_due_invoices_arr'][$value->id]['seller_name']             =$value->seller_name;
            $data['past_due_invoices_arr'][$value->id]['seller_id']               =$value->id; 
            $data['past_due_invoices_arr'][$value->id]['purchase_offer']          ="";
            $data['past_due_invoices_arr'][$value->id]['purchase_order']          ="";
            $data['past_due_invoices_arr'][$value->id]['packing_slip']            ="";
            $data['past_due_invoices_arr'][$value->id]['purchase_invoice']        ="";
            $data['past_due_invoices_arr'][$value->id]['purchase_return']         ="";
            $data['past_due_invoices_arr'][$value->id]['purchase_debit_note']     ="";
            $data['past_due_invoices_arr'][$value->id]['purchase_credit_note']    ="";
            $data['past_due_invoices_arr'][$value->id]['id']    ="";
        }

        

        $data['allow_transaction_seller_arr'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['allow_transaction_seller_arr'][$value->id]['seller_name']             =$value->seller_name;
            $data['allow_transaction_seller_arr'][$value->id]['seller_id']               =$value->id; 
            $data['allow_transaction_seller_arr'][$value->id]['id']                      =""; 
            $data['allow_transaction_seller_arr'][$value->id]['purchase_offer']          ="";
            $data['allow_transaction_seller_arr'][$value->id]['purchase_order']          ="";
            $data['allow_transaction_seller_arr'][$value->id]['packing_slip']            ="";
            $data['allow_transaction_seller_arr'][$value->id]['purchase_invoice']        ="";
            $data['allow_transaction_seller_arr'][$value->id]['purchase_return']         ="";
            $data['allow_transaction_seller_arr'][$value->id]['purchase_debit_note']     ="";
            $data['allow_transaction_seller_arr'][$value->id]['purchase_credit_note']    ="";
            $data['allow_transaction_seller_arr'][$value->id]['id']                      ="";
        }


        $data['banned_purchase_item_per_seller'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['banned_purchase_item_per_seller'][$value->id]['seller_name']         =$value->seller_name;
            $data['banned_purchase_item_per_seller'][$value->id]['seller_id']           =$value->id; 
            $data['banned_purchase_item_per_seller'][$value->id]['amount']              ="";
            $data['banned_purchase_item_per_seller'][$value->id]['quantity']            ="";
            $data['banned_purchase_item_per_seller'][$value->id]['product_id']          ="";
            $data['banned_purchase_item_per_seller'][$value->id]['product_name']        ="";
            $data['banned_purchase_item_per_seller'][$value->id]['id']                  ="";
        } 


        $PurchaseAccountPayable_list=PurchaseAccountPayable::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->first(); 
        if(!empty($PurchaseAccountPayable_list))
        {
            $data['PurchaseAccountPayableID']               =$PurchaseAccountPayable_list->id;
            $data['PurchaseAccountPayableCompanyID']        =$PurchaseAccountPayable_list->company_id;
            $data['PurchaseAccountPayablePostingStatus']    =$PurchaseAccountPayable_list->posting_status;
            $id                                             =$PurchaseAccountPayable_list->id;

            $seller_purchase_limit_list=PurchaseLimitPerSeller::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 
            foreach ($seller_purchase_limit_list as $key => $value) { 

                $data['purchase_limit_per_seller'][$value->seller_id]['seller_name']         =$value->seller_name;
                $data['purchase_limit_per_seller'][$value->seller_id]['seller_id']           =$value->seller_id; 
                $data['purchase_limit_per_seller'][$value->seller_id]['amount']              =$value->amount;
                $data['purchase_limit_per_seller'][$value->seller_id]['quantity']            =$value->quantity;
                $data['purchase_limit_per_seller'][$value->seller_id]['product_id']          =$value->product_id;
                $data['purchase_limit_per_seller'][$value->seller_id]['product_name']        =$value->product_name;
                $data['purchase_limit_per_seller'][$value->seller_id]['from']                =$value->from;
                $data['purchase_limit_per_seller'][$value->seller_id]['to']                  =$value->to;
                $data['purchase_limit_per_seller'][$value->seller_id]['id']                  =$value->id;
            }


            $seller_payment_term_list=SellerPaymentTerm::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 

            foreach ($seller_payment_term_list as $key => $value) { 

                $data['seller_payment_term_arr'][$value->seller_id]['seller_name']                      =$value->seller_name;
                $data['seller_payment_term_arr'][$value->seller_id]['seller_id']                        =$value->seller_id;
                $data['seller_payment_term_arr'][$value->seller_id]['term'][$value->term_id]['value']   =$value->value;
                $data['seller_payment_term_arr'][$value->seller_id]['term'][$value->term_id]['id']      =$value->id;
                
            }

            $pass_due_invoice_list=PassDueInvoice::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 
            foreach ($pass_due_invoice_list as $key => $value) { 

                $data['past_due_invoices_arr'][$value->seller_id]['seller_name']             =$value->seller_name;
                $data['past_due_invoices_arr'][$value->seller_id]['seller_id']               =$value->seller_id; 
                $data['past_due_invoices_arr'][$value->seller_id]['purchase_offer']          =$value->purchase_offer;
                $data['past_due_invoices_arr'][$value->seller_id]['purchase_order']          =$value->purchase_order;
                $data['past_due_invoices_arr'][$value->seller_id]['packing_slip']            =$value->packing_slip;
                $data['past_due_invoices_arr'][$value->seller_id]['purchase_invoice']        =$value->purchase_invoice;
                $data['past_due_invoices_arr'][$value->seller_id]['purchase_return']         =$value->purchase_return;
                $data['past_due_invoices_arr'][$value->seller_id]['purchase_debit_note']     =$value->purchase_debit_note;
                $data['past_due_invoices_arr'][$value->seller_id]['purchase_credit_note']    =$value->purchase_credit_note;
                $data['past_due_invoices_arr'][$value->seller_id]['id']                      =$value->id;
            }

            $seller_allow_transaction_list=AllowTransactionPerSeller::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 

            foreach ($seller_allow_transaction_list as $key => $value) { 

                $data['allow_transaction_seller_arr'][$value->seller_id]['seller_name']             =$value->seller_name;
                $data['allow_transaction_seller_arr'][$value->seller_id]['seller_id']               =$value->seller_id; 
                $data['allow_transaction_seller_arr'][$value->seller_id]['id']                      =$value->id; 
                $data['allow_transaction_seller_arr'][$value->seller_id]['purchase_offer']          =$value->purchase_offer;
                $data['allow_transaction_seller_arr'][$value->seller_id]['purchase_order']          =$value->purchase_order;
                $data['allow_transaction_seller_arr'][$value->seller_id]['packing_slip']            =$value->packing_slip;
                $data['allow_transaction_seller_arr'][$value->seller_id]['purchase_invoice']        =$value->purchase_invoice;
                $data['allow_transaction_seller_arr'][$value->seller_id]['purchase_return']         =$value->purchase_return;
                $data['allow_transaction_seller_arr'][$value->seller_id]['purchase_debit_note']     =$value->purchase_debit_note;
                $data['allow_transaction_seller_arr'][$value->seller_id]['purchase_credit_note']    =$value->purchase_credit_note;
            }

            $banned_purchase_item_seller_list=BannedPurchaseItemPerSeller::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get();

            foreach ($banned_purchase_item_seller_list as $key => $value) { 

                $data['banned_purchase_item_per_seller'][$value->seller_id]['seller_name']         =$value->seller_name;
                $data['banned_purchase_item_per_seller'][$value->seller_id]['seller_id']           =$value->seller_id; 
                $data['banned_purchase_item_per_seller'][$value->seller_id]['amount']              =$value->amount;
                $data['banned_purchase_item_per_seller'][$value->seller_id]['quantity']            =$value->quantity;
                $data['banned_purchase_item_per_seller'][$value->seller_id]['product_id']          =$value->product_id;
                $data['banned_purchase_item_per_seller'][$value->seller_id]['product_name']        =$value->product_name;
                $data['banned_purchase_item_per_seller'][$value->seller_id]['id']                  =$value->id;
            } 

        }
        else
        {
            $data['PurchaseAccountPayableID']               ="";
            $data['PurchaseAccountPayableCompanyID']        =$company_id;
            $data['PurchaseAccountPayablePostingStatus']    =0;
           
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
        $purchase_info= PurchaseAccountPayable::create($request->all());


       
        foreach($request->purchase_limit_per_seller as $key=>$details)
        {
                      
            if($details['product_id'])
            {
                
                $from                           =date("Y-m-d",strtotime($details['from']));
                $to                             =date("Y-m-d",strtotime($details['to']));
                $data_purchase_limit[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$purchase_info->id,
                    'company_id'                =>$company_id,
                    'seller_id'                 =>$details['seller_id'],
                    'seller_name'               =>$details['seller_name'],
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
                      
            if($details['purchase_offer'])
            {
                
                $data_past_due_invoice[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$purchase_info->id,
                    'company_id'                =>$company_id,
                    'seller_id'                 =>$details['seller_id'],
                    'seller_name'               =>$details['seller_name'],
                    'purchase_offer'            =>$details['purchase_offer'],
                    'purchase_order'            =>$details['purchase_order'],
                    'packing_slip'              =>$details['packing_slip'],
                    'purchase_invoice'          =>$details['purchase_invoice'],
                    'purchase_return'           =>$details['purchase_return'],
                    'purchase_debit_note'       =>$details['purchase_debit_note'],
                    'purchase_credit_note'      =>$details['purchase_credit_note'],
                    'inserted_by'               =>$user_id,
                );
                
            }
                   
        }
       

        foreach($request->allow_transaction_seller_arr as $key=>$details)
        {
                      
            if($details['purchase_offer'])
            {
                
                $data_allow_transaction[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$purchase_info->id,
                    'company_id'                =>$company_id,
                    'seller_id'                 =>$details['seller_id'],
                    'seller_name'               =>$details['seller_name'],
                    'purchase_offer'            =>$details['purchase_offer'],
                    'purchase_order'            =>$details['purchase_order'],
                    'packing_slip'              =>$details['packing_slip'],
                    'purchase_invoice'          =>$details['purchase_invoice'],
                    'purchase_return'           =>$details['purchase_return'],
                    'purchase_debit_note'       =>$details['purchase_debit_note'],
                    'purchase_credit_note'      =>$details['purchase_credit_note'],
                    'inserted_by'               =>$user_id,
                );
                
            }
                   
        }

        foreach($request->banned_purchase_item_per_seller as $key=>$details)
        {
                      
            if($details['product_id'])
            {

                $data_banned_purchase_item[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$purchase_info->id,
                    'company_id'                =>$company_id,
                    'seller_id'                 =>$details['seller_id'],
                    'seller_name'               =>$details['seller_name'],
                    'product_id'                =>$details['product_id'],
                    'product_name'              =>$details['product_name'],
                    'quantity'                  =>$details['quantity'],
                    'amount'                    =>$details['amount'],
                    'inserted_by'               =>$user_id,
                );
            }
        }

        

        foreach($request->seller_payment_term_arr as $key=>$seller_details)
        {

            foreach($seller_details['term'] as $key=>$details)
            {
                if($details['value'])
                {
                    $data_seller_payament_term[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$purchase_info->id,
                        'company_id'                =>$company_id,
                        'seller_id'                 =>$seller_details['seller_id'],
                        'seller_name'               =>$seller_details['seller_name'],
                        'term_id'                   =>$key,
                        'value'                     =>$details['value'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
        } 

        foreach($request->seller_list_arr as $key=>$details)
        {
            if($details['id']!="")
            {
                $seller_details_data= array(
                    'status_active'             =>$details['status_active'],
                    'updated_by'                =>$user_id,
                );

                $sellerData=AccountHolderSeller::where('id',"=",$details['id'])->update($seller_details_data);
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
            $RId1=SellerPaymentTerm::insert($data_seller_payament_term);
        }


        if(!empty($data_banned_purchase_item))
        {
            $RId2=BannedPurchaseItemPerSeller::insert($data_banned_purchase_item);
        }

        if(!empty($data_allow_transaction))
        {
            $RId3=AllowTransactionPerSeller::insert($data_allow_transaction);
        }

        if(!empty($data_purchase_limit))
        {
            $RId4=PurchaseLimitPerSeller::insert($data_purchase_limit);
        }
        if(!empty($data_past_due_invoice))
        {
            $RId5=PassDueInvoice::insert($data_past_due_invoice);
        }

        if($purchase_info  && $RId1 && $RId2 && $RId3 && $RId4 && $RId5)
        {
           DB::commit();
           return "1**$purchase_info->id";
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

        $PurchaseAccountPayable_list=PurchaseAccountPayable::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('id',$id)
                                        ->first(); 
        $data['PurchaseAccountPayable'] =$PurchaseAccountPayable_list;

        $account_holder_list=AccountHolderSeller::where('status_active',1)
                                        ->where('project_id',$project_id)
                                       // ->where('project_id',$project_id)
                                        ->get();        

        $data['seller_list_arr'] =array();
        $data['seller_payment_term_arr'] =array();
        foreach ($account_holder_list as $key => $value) { 

            $data['seller_list_arr'][$value->id]['seller_name']           =$value->seller_name;
            $data['seller_list_arr'][$value->id]['id']                    =$value->id;
            $data['seller_list_arr'][$value->id]['status_active']         =$value->status_active;
            $data['seller_payment_term_arr'][$value->id]['seller_name']   =$value->seller_name;
            $data['seller_payment_term_arr'][$value->id]['seller_id']     =$value->id;
            foreach($payment_term_arr as $index=>$val)
            {
                $data['seller_payment_term_arr'][$value->id]['term'][$index]['value']="";
                $data['seller_payment_term_arr'][$value->id]['term'][$index]['id']="";
            }
        }

        $data['payment_term_arr'] =$payment_term_arr;

        $seller_payment_term_list=SellerPaymentTerm::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 

        foreach ($seller_payment_term_list as $key => $value) { 

            $data['seller_payment_term_arr'][$value->seller_id]['seller_name']                      =$value->seller_name;
            $data['seller_payment_term_arr'][$value->seller_id]['seller_id']                        =$value->seller_id;
            $data['seller_payment_term_arr'][$value->seller_id]['term'][$value->term_id]['value']   =$value->value;
            $data['seller_payment_term_arr'][$value->seller_id]['term'][$value->term_id]['id']      =$value->id;
            
        }

        $data['purchase_limit_per_seller'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['purchase_limit_per_seller'][$value->id]['seller_name']         =$value->seller_name;
            $data['purchase_limit_per_seller'][$value->id]['seller_id']           =$value->id; 
            $data['purchase_limit_per_seller'][$value->id]['amount']              ="";
            $data['purchase_limit_per_seller'][$value->id]['quantity']            ="";
            $data['purchase_limit_per_seller'][$value->id]['product_id']          ="";
            $data['purchase_limit_per_seller'][$value->id]['product_name']        ="";
            $data['purchase_limit_per_seller'][$value->id]['from']                ="";
            $data['purchase_limit_per_seller'][$value->id]['to']                  ="";
            $data['purchase_limit_per_seller'][$value->id]['id']                  ="";
        } 

        $seller_purchase_limit_list=PurchaseLimitPerSeller::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 
        foreach ($seller_purchase_limit_list as $key => $value) { 

            $data['purchase_limit_per_seller'][$value->seller_id]['seller_name']         =$value->seller_name;
            $data['purchase_limit_per_seller'][$value->seller_id]['seller_id']           =$value->seller_id; 
            $data['purchase_limit_per_seller'][$value->seller_id]['amount']              =$value->amount;
            $data['purchase_limit_per_seller'][$value->seller_id]['quantity']            =$value->quantity;
            $data['purchase_limit_per_seller'][$value->seller_id]['product_id']          =$value->product_id;
            $data['purchase_limit_per_seller'][$value->seller_id]['product_name']        =$value->product_name;
            $data['purchase_limit_per_seller'][$value->seller_id]['from']                =$value->from;
            $data['purchase_limit_per_seller'][$value->seller_id]['to']                  =$value->to;
            $data['purchase_limit_per_seller'][$value->seller_id]['id']                  =$value->id;
        }

        $data['past_due_invoices_arr'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['past_due_invoices_arr'][$value->id]['seller_name']             =$value->seller_name;
            $data['past_due_invoices_arr'][$value->id]['seller_id']               =$value->id; 
            $data['past_due_invoices_arr'][$value->id]['purchase_offer']          ="";
            $data['past_due_invoices_arr'][$value->id]['purchase_order']          ="";
            $data['past_due_invoices_arr'][$value->id]['packing_slip']            ="";
            $data['past_due_invoices_arr'][$value->id]['purchase_invoice']        ="";
            $data['past_due_invoices_arr'][$value->id]['purchase_return']         ="";
            $data['past_due_invoices_arr'][$value->id]['purchase_debit_note']     ="";
            $data['past_due_invoices_arr'][$value->id]['purchase_credit_note']    ="";
            $data['past_due_invoices_arr'][$value->id]['id']                      ="";
        }

        $pass_due_invoice_list=PassDueInvoice::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 
        foreach ($pass_due_invoice_list as $key => $value) { 

            $data['past_due_invoices_arr'][$value->seller_id]['seller_name']             =$value->seller_name;
            $data['past_due_invoices_arr'][$value->seller_id]['seller_id']               =$value->seller_id; 
            $data['past_due_invoices_arr'][$value->seller_id]['purchase_offer']          =$value->purchase_offer;
            $data['past_due_invoices_arr'][$value->seller_id]['purchase_order']          =$value->purchase_order;
            $data['past_due_invoices_arr'][$value->seller_id]['packing_slip']            =$value->packing_slip;
            $data['past_due_invoices_arr'][$value->seller_id]['purchase_invoice']        =$value->purchase_invoice;
            $data['past_due_invoices_arr'][$value->seller_id]['purchase_return']         =$value->purchase_return;
            $data['past_due_invoices_arr'][$value->seller_id]['purchase_debit_note']     =$value->purchase_debit_note;
            $data['past_due_invoices_arr'][$value->seller_id]['purchase_credit_note']    =$value->purchase_credit_note;
            $data['past_due_invoices_arr'][$value->seller_id]['id']                      =$value->id;
        }

        $data['allow_transaction_seller_arr'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['allow_transaction_seller_arr'][$value->id]['seller_name']             =$value->seller_name;
            $data['allow_transaction_seller_arr'][$value->id]['seller_id']               =$value->id; 
            $data['allow_transaction_seller_arr'][$value->id]['id']                      =""; 
            $data['allow_transaction_seller_arr'][$value->id]['purchase_offer']          ="";
            $data['allow_transaction_seller_arr'][$value->id]['purchase_order']          ="";
            $data['allow_transaction_seller_arr'][$value->id]['packing_slip']            ="";
            $data['allow_transaction_seller_arr'][$value->id]['purchase_invoice']        ="";
            $data['allow_transaction_seller_arr'][$value->id]['purchase_return']         ="";
            $data['allow_transaction_seller_arr'][$value->id]['purchase_debit_note']     ="";
            $data['allow_transaction_seller_arr'][$value->id]['purchase_credit_note']    ="";
            $data['allow_transaction_seller_arr'][$value->id]['id']                      ="";
        }

        $seller_allow_transaction_list=AllowTransactionPerSeller::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get(); 

        foreach ($seller_allow_transaction_list as $key => $value) { 

            $data['allow_transaction_seller_arr'][$value->seller_id]['seller_name']             =$value->seller_name;
            $data['allow_transaction_seller_arr'][$value->seller_id]['seller_id']               =$value->seller_id; 
            $data['allow_transaction_seller_arr'][$value->seller_id]['id']                      =$value->id; 
            $data['allow_transaction_seller_arr'][$value->seller_id]['purchase_offer']          =$value->purchase_offer;
            $data['allow_transaction_seller_arr'][$value->seller_id]['purchase_order']          =$value->purchase_order;
            $data['allow_transaction_seller_arr'][$value->seller_id]['packing_slip']            =$value->packing_slip;
            $data['allow_transaction_seller_arr'][$value->seller_id]['purchase_invoice']        =$value->purchase_invoice;
            $data['allow_transaction_seller_arr'][$value->seller_id]['purchase_return']         =$value->purchase_return;
            $data['allow_transaction_seller_arr'][$value->seller_id]['purchase_debit_note']     =$value->purchase_debit_note;
            $data['allow_transaction_seller_arr'][$value->seller_id]['purchase_credit_note']    =$value->purchase_credit_note;
        }

        $data['banned_purchase_item_per_seller'] =array(); 
        foreach ($account_holder_list as $key => $value) { 

            $data['banned_purchase_item_per_seller'][$value->id]['seller_name']         =$value->seller_name;
            $data['banned_purchase_item_per_seller'][$value->id]['seller_id']           =$value->id; 
            $data['banned_purchase_item_per_seller'][$value->id]['amount']              ="";
            $data['banned_purchase_item_per_seller'][$value->id]['quantity']            ="";
            $data['banned_purchase_item_per_seller'][$value->id]['product_id']          ="";
            $data['banned_purchase_item_per_seller'][$value->id]['product_name']        ="";
            $data['banned_purchase_item_per_seller'][$value->id]['id']                  ="";
        } 


        $banned_purchase_item_seller_list=BannedPurchaseItemPerSeller::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_id',$company_id)
                                        ->where('master_id',$id)
                                        ->get();

        foreach ($banned_purchase_item_seller_list as $key => $value) { 

            $data['banned_purchase_item_per_seller'][$value->seller_id]['seller_name']         =$value->seller_name;
            $data['banned_purchase_item_per_seller'][$value->seller_id]['seller_id']           =$value->seller_id; 
            $data['banned_purchase_item_per_seller'][$value->seller_id]['amount']              =$value->amount;
            $data['banned_purchase_item_per_seller'][$value->seller_id]['quantity']            =$value->quantity;
            $data['banned_purchase_item_per_seller'][$value->seller_id]['product_id']          =$value->product_id;
            $data['banned_purchase_item_per_seller'][$value->seller_id]['product_name']        =$value->product_name;
            $data['banned_purchase_item_per_seller'][$value->seller_id]['id']                  =$value->id;
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
        $purchase_info= PurchaseAccountPayable::find($id)->update($request->all());


        foreach($request->purchase_limit_per_seller as $key=>$details)
        {
                      
            if($details['product_id'])
            {
                $from                           =date("Y-m-d",strtotime($details['from']));
                $to                             =date("Y-m-d",strtotime($details['to']));
                if($details['id']!="")
                {
                    $purchase_limit_details_data= array(
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
                        'product_id'                =>$details['product_id'],
                        'product_name'              =>$details['product_name'],
                        'quantity'                  =>$details['quantity'],
                        'amount'                    =>$details['amount'],
                        'from'                      =>$from,
                        'to'                        =>$to,
                        'updated_by'                =>$user_id,
                    );

                    $sellerPurchaseLimit=PurchaseLimitPerSeller::where('id',"=",$details['id'])->update($purchase_limit_details_data);
                    if( !$sellerPurchaseLimit)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                   
                    $data_purchase_limit[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'company_id'                =>$company_id,
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
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
                      
            if($details['purchase_offer'])
            {
                 if($details['id']!="")
                {
                    $past_due_invoice_data= array(
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
                        'purchase_offer'            =>$details['purchase_offer'],
                        'purchase_order'            =>$details['purchase_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'purchase_invoice'          =>$details['purchase_invoice'],
                        'purchase_return'           =>$details['purchase_return'],
                        'purchase_debit_note'       =>$details['purchase_debit_note'],
                        'purchase_credit_note'      =>$details['purchase_credit_note'],
                        'updated_by'                =>$user_id,
                    );

                    $sellerPassdueInvoice=PassDueInvoice::where('id',"=",$details['id'])->update($past_due_invoice_data);
                    if( !$sellerPassdueInvoice)
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
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
                        'purchase_offer'            =>$details['purchase_offer'],
                        'purchase_order'            =>$details['purchase_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'purchase_invoice'          =>$details['purchase_invoice'],
                        'purchase_return'           =>$details['purchase_return'],
                        'purchase_debit_note'       =>$details['purchase_debit_note'],
                        'purchase_credit_note'      =>$details['purchase_credit_note'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
                   
        }

        foreach($request->allow_transaction_seller_arr as $key=>$details)
        {
                      
            if($details['purchase_offer'])
            {
                if($details['id']!="")
                {
                    $allow_transaction_seller_data= array(
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
                        'purchase_offer'            =>$details['purchase_offer'],
                        'purchase_order'            =>$details['purchase_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'purchase_invoice'          =>$details['purchase_invoice'],
                        'purchase_return'           =>$details['purchase_return'],
                        'purchase_debit_note'       =>$details['purchase_debit_note'],
                        'purchase_credit_note'      =>$details['purchase_credit_note'],
                        'updated_by'                =>$user_id,
                    );

                    $sellerTransactionAllow=AllowTransactionPerSeller::where('id',"=",$details['id'])->update($allow_transaction_seller_data);
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
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
                        'purchase_offer'            =>$details['purchase_offer'],
                        'purchase_order'            =>$details['purchase_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'purchase_invoice'          =>$details['purchase_invoice'],
                        'purchase_return'           =>$details['purchase_return'],
                        'purchase_debit_note'       =>$details['purchase_debit_note'],
                        'purchase_credit_note'      =>$details['purchase_credit_note'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
        }

        foreach($request->banned_purchase_item_per_seller as $key=>$details)
        {
            if($details['product_id'])
            {
                if($details['id']!="")
                {

                    $banned_purchase_item_seller_data= array(
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
                        'product_id'                =>$details['product_id'],
                        'product_name'              =>$details['product_name'],
                        'quantity'                  =>$details['quantity'],
                        'amount'                    =>$details['amount'],
                        'updated_by'                =>$user_id,
                    );

                    $sellerBannedItem=BannedPurchaseItemPerSeller::where('id',"=",$details['id'])->update($banned_purchase_item_seller_data);
                    if( !$sellerBannedItem)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_banned_purchase_item[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$id,
                    'company_id'                =>$company_id,
                    'seller_id'                 =>$details['seller_id'],
                    'seller_name'               =>$details['seller_name'],
                    'product_id'                =>$details['product_id'],
                    'product_name'              =>$details['product_name'],
                    'quantity'                  =>$details['quantity'],
                    'amount'                    =>$details['amount'],
                    'inserted_by'               =>$user_id,
                );
                }
                
            }
        }

        foreach($request->seller_payment_term_arr as $key=>$seller_details)
        {
            
            foreach($seller_details['term'] as $term_id=>$details)
            {
                if($details['value'])
                {
                    if($details['id'])
                    {
                        $seller_payament_term_data= array(
                            
                            'seller_id'                 =>$seller_details['seller_id'],
                            'seller_name'               =>$seller_details['seller_name'],
                            'term_id'                   =>$term_id,
                            'value'                     =>$details['value'],
                            'updated_by'                =>$user_id,
                        );



                        $sellerPaymentTerm=SellerPaymentTerm::where('id',"=",$details['id'])->update($seller_payament_term_data);
                        if( !$sellerPaymentTerm)
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
                            'seller_id'                 =>$seller_details['seller_id'],
                            'seller_name'               =>$seller_details['seller_name'],
                            'term_id'                   =>$term_id,
                            'value'                     =>$details['value'],
                            'inserted_by'               =>$user_id,
                        );

                        //dd($data_seller_payament_term);
                    }
                }

            }
        } 

        foreach($request->seller_list_arr as $key=>$details)
        {
            if($details['id']!="")
            {
                $seller_details_data= array(
                    'status_active'             =>$details['status_active'],
                    'updated_by'                =>$user_id,
                );

                $sellerData=AccountHolderSeller::where('id',"=",$details['id'])->update($seller_details_data);
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
            $RId1=SellerPaymentTerm::insert($data_seller_payament_term);
        }


        if(!empty($data_banned_purchase_item))
        {
            $RId2=BannedPurchaseItemPerSeller::insert($data_banned_purchase_item);
        }

        if(!empty($data_allow_transaction))
        {
            $RId3=AllowTransactionPerSeller::insert($data_allow_transaction);
        }

        if(!empty($data_purchase_limit))
        {
            $RId4=PurchaseLimitPerSeller::insert($data_purchase_limit);
        }
        if(!empty($data_past_due_invoice))
        {
            $RId5=PassDueInvoice::insert($data_past_due_invoice);
        }

        if($purchase_info  && $RId1 && $RId2 && $RId3 && $RId4 && $RId5)
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
      
        $buildingInfo=PurchaseAccountPayable::where('id',"=",$id)->update($update_data);

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
        $purchase_info= PurchaseAccountPayable::find($id)->update($request->all());


        foreach($request->purchase_limit_per_seller as $key=>$details)
        {
                      
            if($details['product_id'])
            {
                $from                           =date("Y-m-d",strtotime($details['from']));
                $to                             =date("Y-m-d",strtotime($details['to']));
                if($details['id']!="")
                {
                    $purchase_limit_details_data= array(
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
                        'product_id'                =>$details['product_id'],
                        'product_name'              =>$details['product_name'],
                        'quantity'                  =>$details['quantity'],
                        'amount'                    =>$details['amount'],
                        'from'                      =>$from,
                        'to'                        =>$to,
                        'updated_by'                =>$user_id,
                    );

                    $sellerPurchaseLimit=PurchaseLimitPerSeller::where('id',"=",$details['id'])->update($purchase_limit_details_data);
                    if( !$sellerPurchaseLimit)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                   
                    $data_purchase_limit[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'company_id'                =>$company_id,
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
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
                      
            if($details['purchase_offer'])
            {
                 if($details['id']!="")
                {
                    $past_due_invoice_data= array(
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
                        'purchase_offer'            =>$details['purchase_offer'],
                        'purchase_order'            =>$details['purchase_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'purchase_invoice'          =>$details['purchase_invoice'],
                        'purchase_return'           =>$details['purchase_return'],
                        'purchase_debit_note'       =>$details['purchase_debit_note'],
                        'purchase_credit_note'      =>$details['purchase_credit_note'],
                        'updated_by'                =>$user_id,
                    );

                    $sellerPassdueInvoice=PassDueInvoice::where('id',"=",$details['id'])->update($past_due_invoice_data);
                    if( !$sellerPassdueInvoice)
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
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
                        'purchase_offer'            =>$details['purchase_offer'],
                        'purchase_order'            =>$details['purchase_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'purchase_invoice'          =>$details['purchase_invoice'],
                        'purchase_return'           =>$details['purchase_return'],
                        'purchase_debit_note'       =>$details['purchase_debit_note'],
                        'purchase_credit_note'      =>$details['purchase_credit_note'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
                   
        }

        foreach($request->allow_transaction_seller_arr as $key=>$details)
        {
                      
            if($details['purchase_offer'])
            {
                if($details['id']!="")
                {
                    $allow_transaction_seller_data= array(
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
                        'purchase_offer'            =>$details['purchase_offer'],
                        'purchase_order'            =>$details['purchase_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'purchase_invoice'          =>$details['purchase_invoice'],
                        'purchase_return'           =>$details['purchase_return'],
                        'purchase_debit_note'       =>$details['purchase_debit_note'],
                        'purchase_credit_note'      =>$details['purchase_credit_note'],
                        'updated_by'                =>$user_id,
                    );

                    $sellerTransactionAllow=AllowTransactionPerSeller::where('id',"=",$details['id'])->update($allow_transaction_seller_data);
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
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
                        'purchase_offer'            =>$details['purchase_offer'],
                        'purchase_order'            =>$details['purchase_order'],
                        'packing_slip'              =>$details['packing_slip'],
                        'purchase_invoice'          =>$details['purchase_invoice'],
                        'purchase_return'           =>$details['purchase_return'],
                        'purchase_debit_note'       =>$details['purchase_debit_note'],
                        'purchase_credit_note'      =>$details['purchase_credit_note'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
        }

        foreach($request->banned_purchase_item_per_seller as $key=>$details)
        {
            if($details['product_id'])
            {
                if($details['id']!="")
                {
                    $banned_purchase_item_seller_data= array(
                        'seller_id'                 =>$details['seller_id'],
                        'seller_name'               =>$details['seller_name'],
                        'product_id'                =>$details['product_id'],
                        'product_name'              =>$details['product_name'],
                        'quantity'                  =>$details['quantity'],
                        'amount'                    =>$details['amount'],
                        'updated_by'                =>$user_id,
                    );

                    $sellerBannedItem=BannedPurchaseItemPerSeller::where('id',"=",$details['id'])->update($banned_purchase_item_seller_data);
                    if( !$sellerBannedItem)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $data_banned_purchase_item[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$purchase_info->id,
                    'company_id'                =>$company_id,
                    'seller_id'                 =>$details['seller_id'],
                    'seller_name'               =>$details['seller_name'],
                    'product_id'                =>$details['product_id'],
                    'product_name'              =>$details['product_name'],
                    'quantity'                  =>$details['quantity'],
                    'amount'                    =>$details['amount'],
                    'inserted_by'               =>$user_id,
                );
                }
                
            }
        }

        foreach($request->seller_payment_term_arr as $key=>$seller_details)
        {
            
            foreach($seller_details['term'] as $term_id=>$details)
            {
                if($details['value'])
                {
                    if($details['id'])
                    {
                        $data_seller_payament_term= array(
                            
                            'seller_id'                 =>$seller_details['seller_id'],
                            'seller_name'               =>$seller_details['seller_name'],
                            'term_id'                   =>$term_id,
                            'value'                     =>$details['value'],
                            'updated_by'                =>$user_id,
                        );



                        $sellerPaymentTerm=SellerPaymentTerm::where('id',"=",$details['id'])->update($data_seller_payament_term);
                        if( !$sellerPaymentTerm)
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
                            'seller_id'                 =>$seller_details['seller_id'],
                            'seller_name'               =>$seller_details['seller_name'],
                            'term_id'                   =>$term_id,
                            'value'                     =>$details['value'],
                            'inserted_by'               =>$user_id,
                        );
                    }
                }

            }
        }

        foreach($request->seller_list_arr as $key=>$details)
        {
            if($details['id']!="")
            {
                $seller_details_data= array(
                    'status_active'             =>$details['status_active'],
                    'updated_by'                =>$user_id,
                );

                $sellerData=AccountHolderSeller::where('id',"=",$details['id'])->update($seller_details_data);
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
            $RId1=SellerPaymentTerm::insert($data_seller_payament_term);
        }


        if(!empty($data_banned_purchase_item))
        {
            $RId2=BannedPurchaseItemPerSeller::insert($data_banned_purchase_item);
        }

        if(!empty($data_allow_transaction))
        {
            $RId3=AllowTransactionPerSeller::insert($data_allow_transaction);
        }

        if(!empty($data_purchase_limit))
        {
            $RId4=PurchaseLimitPerSeller::insert($data_purchase_limit);
        }
        if(!empty($data_past_due_invoice))
        {
            $RId5=PassDueInvoice::insert($data_past_due_invoice);
        }

        if($purchase_info  && $RId1 && $RId2 && $RId3 && $RId4 && $RId5)
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
      
        $buildingInfo=PurchaseAccountPayable::where('id',"=",$id)->update($update_data);

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

        $RID_delete=PurchaseAccountPayable::where('id',"=",$id)->update($update_data);
        $RID1_delete=PurchaseLimitPerSeller::where('master_id',"=",$id)->update($update_data);
        $RID2_delete=PassDueInvoice::where('master_id',"=",$id)->update($update_data);
        $RID3_delete=AllowTransactionPerSeller::where('master_id',"=",$id)->update($update_data);
        $RID4_delete=BannedPurchaseItemPerSeller::where('master_id',"=",$id)->update($update_data);
        $RID5_delete=SellerPaymentTerm::where('master_id',"=",$id)->update($update_data);


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
