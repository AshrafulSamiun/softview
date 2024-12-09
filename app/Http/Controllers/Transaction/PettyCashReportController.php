<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AcPeriodDetails;
use App\Models\PettyCash;
use App\Models\PettyCashExpenseDetails;
use App\Models\AcTransactionMaster;
use App\Models\AcTransactionDtls;
use App\Models\ChartOfAccount;
use App\Models\AccountHolder;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Support\Facades\DB;

class PettyCashReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=\Auth::user();
        $project_id                     = $user->project_id;
        $ArrayFunction                  =new ArrayFunction();
        $payment_method_arr             =$ArrayFunction->petty_cash_payment_method;
        $accounts_sub_group             =$ArrayFunction->accounts_sub_group;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return; 
        }

        $chart_of_account_list          =DB::table('chart_of_accounts as coa')
                                        ->join('coa_groups as group','coa.coa_group','=','group.reference_id')
                                        ->where('coa.project_id', '=', $project_id)
                                        ->where('group.project_id', '=', $project_id)
                                        ->get(['group.account_title','group.statement_type','coa.*']);
        $coa_arr=array();$sl=0;
        if(count($chart_of_account_list)>0)
        {

            foreach ($chart_of_account_list as $key => $value) {
                $coa_arr[$sl]['id']                   =$value->id;
                $coa_arr[$sl]['account_title']        =$value->account_title;
                $coa_arr[$sl]['account_no']           =$value->account_no;
                $coa_arr[$sl]['description']          =$value->description;
                $coa_arr[$sl]['govt_tax_code']        =$value->govt_tax_code;
                $coa_arr[$sl]['tax_code']             =$value->tax_code;
                $coa_arr[$sl]['sub_group']            =$value->sub_group;
                $coa_arr[$sl]['sub_group_name']       =$accounts_sub_group[$value->sub_group];
                
                $sl++;         
            }
        }

        $account_holder_data=AccountHolder::where('status_active','=',1)
                                            ->where('project_id','=',$project_id)
                                            ->where('company_id','=',$company_id)
                                           // ->where('account_type','=',)
                                            ->get(['id','system_no','first_name','middle_name','last_name']);

          
        $petty_cash_holder_arr=array();$sl=0;
        if(count($account_holder_data)>0)
        {

            foreach ($account_holder_data as $key => $value) {
                $petty_cash_holder_arr[$sl]['id']                   =$value->id;
                $petty_cash_holder_arr[$sl]['system_no']            =$value->system_no;
                $petty_cash_holder_arr[$sl]['account_holder_name']  ="";

                if($value->first_name)
                    $petty_cash_holder_arr[$sl]['account_holder_name'].=$value->first_name;

                if($value->middle_name)
                    $petty_cash_holder_arr[$sl]['account_holder_name'].=" ".$value->middle_name;

                if($value->last_name)
                    $petty_cash_holder_arr[$sl]['account_holder_name'].=" ".$value->last_name;
               
              
                
                $sl++;         
            }
        }

        $data['petty_cash_holder_arr']      =$petty_cash_holder_arr;
        $data['payment_method_arr']         =$payment_method_arr;
        $data['coa_arr']                    =$coa_arr;
        return $data;
    }

    public function PettyCashList( Request $request)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $payment_method_arr         =$ArrayFunction->petty_cash_payment_method;

        
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
            
        }
        else {

            return; 
        }

            //dd($currency);
        $chart_of_account_list          =ChartOfAccount::where('status_active',1)
                                        ->where('project_id', '=', $project_id)
                                        ->get(['description','account_no','id']);

        
        $coa_arr=array();$sl=0;
        if(count($chart_of_account_list)>0)
        {

            foreach ($chart_of_account_list as $key => $value) {

                $coa_arr[$value->id]['account_no']           =$value->account_no;
                $coa_arr[$value->id]['description']          =$value->description;
            }
        }

        $sl=0;
        $petty_cash_list=PettyCash::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('entry_form',302)
                                        ->where('company_id',$company_id)
                                        ->get();


        $data['petty_cash_list']=array();
        foreach ($petty_cash_list as $key => $value) {

            $data['petty_cash_list'][$key]['sl']                        =$sl+1;
            $data['petty_cash_list'][$key]['id']                        =$value->id;
            $data['petty_cash_list'][$key]['unique_no']                 =$value->unique_no;
            $data['petty_cash_list'][$key]['transaction_type']          =$value->transaction_type;
            $data['petty_cash_list'][$key]['transaction_no']            =$value->transaction_no;
            $data['petty_cash_list'][$key]['transaction_date']          =$value->transaction_date;
            $data['petty_cash_list'][$key]['payment_posting_status']    =$value->payment_posting_status;
            $data['petty_cash_list'][$key]['report_no']                 =$value->report_no;
            $data['petty_cash_list'][$key]['report_date']               =$value->report_date;
            $data['petty_cash_list'][$key]['posting_status']            =$value->posting_status;
            $data['petty_cash_list'][$key]['cost_center']               =$value->cost_center;
            $data['petty_cash_list'][$key]['posted_date']               =$value->posted_date;
            $data['petty_cash_list'][$key]['payment_approval']          =$value->payment_approval;
            $data['petty_cash_list'][$key]['report_amount']             =$value->amount;
            $data['petty_cash_list'][$key]['tracker']                   =$value->tracker;
            $data['petty_cash_list'][$key]['posted_by']                 =$value->posted_by;
            $data['petty_cash_list'][$key]['petty_cash_holder_name']    =$value->petty_cash_holder_name;
            $data['petty_cash_list'][$key]['account_holder_id']         =$value->account_holder_id;

            $data['petty_cash_list'][$key]['reference_no']              =$value->reference_no;
            $data['petty_cash_list'][$key]['reference_id']              =$value->reference_id;
            $data['petty_cash_list'][$key]['cheque_no']                 =$value->cheque_no;
            $data['petty_cash_list'][$key]['cheque_date']               =$value->cheque_date;
            $data['petty_cash_list'][$key]['pay_to']                    =$value->pay_to;
            $data['petty_cash_list'][$key]['cheque_amount']             =$value->cheque_amount;
            $data['petty_cash_list'][$key]['comments']                  =$value->comments;
            $data['petty_cash_list'][$key]['next_step']                 =$value->next_step;
            $data['petty_cash_list'][$key]['flag']                      =$value->flag;
           
            $sl++;

        }

        $data['payment_method_arr'] =$payment_method_arr;
        
        return $data;

    }

    public function UniqueNoWiseReportList( Request $request,$unique_no)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $payment_method_arr         =$ArrayFunction->petty_cash_payment_method;

        
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
            
        }
        else {

            return; 
        }



   
        $sl=0;
        $petty_cash_list=PettyCash::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('entry_form',302)
                                        ->where('company_id',$company_id)
                                        ->where('unique_no',$unique_no)
                                        //->toSql();
                                        ->get();


        $data['petty_cash_list']=array();
        foreach ($petty_cash_list as $key => $value) {

            $data['petty_cash_list'][$key]['sl']                        =$sl+1;
            $data['petty_cash_list'][$key]['id']                        =$value->id;
            $data['petty_cash_list'][$key]['unique_no']                 =$value->unique_no;
            $data['petty_cash_list'][$key]['transaction_type']          =$value->transaction_type;
            $data['petty_cash_list'][$key]['transaction_no']            =$value->transaction_no;
            $data['petty_cash_list'][$key]['transaction_date']          =$value->transaction_date;
          
            $data['petty_cash_list'][$key]['report_no']                 =$value->report_no;
            $data['petty_cash_list'][$key]['report_date']               =$value->report_date;
            $data['petty_cash_list'][$key]['report_amount']             =$value->amount;
         
            $sl++;

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

        request()->validate([
            'transaction_type'                  => 'required',
            'transaction_date'                  => 'required',
            'posted_date'                       => 'required',
            //'cost_center'                       => 'required',
            'payment_approval'                  => 'required',
            'report_date'                       => 'required',
            'report_amount'                     => 'required',
            'petty_cash_holder_name'            => 'required',
            
        ]);

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $transaction_date                    =date("Y-m-d",strtotime($request->input('transaction_date')));

        if($request->input('posted_date'))
        {

            $posted_date                      =date("Y-m-d",strtotime($request->input('posted_date')));
            $request->merge(['posted_date'    =>$posted_date]);
        }

        if($request->input('report_date'))
        {

            $report_date                      =date("Y-m-d",strtotime($request->input('report_date')));
            $request->merge(['report_date'    =>$report_date]);
        }

        if($request->input('cheque_date'))
        {

            $cheque_date                      =date("Y-m-d",strtotime($request->input('cheque_date')));
            $request->merge(['cheque_date'    =>$cheque_date]);
        }



        $request->merge(['transaction_date'         =>$transaction_date]);
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['posting_status' =>0]);
        $request->merge(['amount' =>$request->input('report_amount')]);


        $company_id="";
        $company_type="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }
        $request->merge(['company_id' =>$company_id]);
        

        $max_system_data = PettyCash::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from petty_cashes 
            where project_id=".$project_id." and entry_form=302   and company_id=".$company_id.")   and company_id=".$company_id." and entry_form=302 and project_id=".$project_id)->get(['system_prefix']);

               
       
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $year= date("y",strtotime($request->input('transaction_date')));
        $system_no="PCER-".$year."-".str_pad($max_system_prefix, 5, 0, STR_PAD_LEFT);
      //  $request->merge(['unique_no'               =>$system_no]);
        $request->merge(['transaction_no'          =>$system_no]);
        $request->merge(['entry_form'              =>302]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);
      

        
        //dd($request->all());
        DB::beginTransaction();
        $RID1= PettyCash::create($request->all());
        

        foreach($request->purchase_details_arr as $key=>$details)
        {
            //dd($details['purchase_date']);die;  
            $purchase_date="";
            if($details['purchase_date'])
            {

                $purchase_date                      =date("Y-m-d",strtotime($details['purchase_date']));
            }        
            $purchase_details[]= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$RID1->id,
                    'purchase_date'             =>$purchase_date,
                    'purchase_no'               =>$details["purchase_no"],
                    'seller_name'               =>$details["seller_name"],
                    'item_description'          =>$details["item_description"],
                    'amount'                    =>$details["amount"],
                    'amount_account'            =>$details["amount_account"],
                    'amount_account_id'         =>$details["amount_account_id"],
                    'coa_description'           =>$details["coa_description"],
                    'cost_center'               =>$details["cost_center"],
                    'project'                   =>$details["project"],
                    'tax_rate'                  =>$details["tax_rate"],
                    'tax_amount'                =>$details["tax_amount"],
                    'tax_account'               =>$details["tax_account"],
                    'tax_account_id'            =>$details["tax_account_id"],
                    'tax_coa_description'       =>$details["tax_coa_description"],
                    'paid_amount'               =>$details["paid_amount"],
                    'paid_account'              =>$details["paid_account"],
                    'paid_account_id'           =>$details["paid_account_id"],
                    'paid_coa_description'      =>$details["paid_coa_description"],
                    'inserted_by'               =>$user_id
                
            );
                   
        } 
       
        $RID2=true;
        if(!empty($purchase_details))
        {
            $RID2=PettyCashExpenseDetails::insert($purchase_details);
        }

        if($RID1 && $RID2)
        {
           DB::commit();
           return "1**$RID1->id**$system_no";
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
       
        $chart_of_account_list          =ChartOfAccount::where('status_active',1)
                                        ->where('project_id', '=', $project_id)
                                        ->get(['description','account_no','id']);
        
        $coa_arr=array();$sl=0;
        if(count($chart_of_account_list)>0)
        {

            foreach ($chart_of_account_list as $key => $value) {

                $coa_arr[$value->id]['account_no']           =$value->account_no;
                $coa_arr[$value->id]['description']          =$value->description;
            }
        }
        $sl=0;
        $petty_cash_list=PettyCash::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('entry_form',302)
                                        ->where('id',$id)
                                        ->get();

        $data['petty_cash_list']=array();
        $report_master_id=0;
        foreach ($petty_cash_list as $key => $value) {
            $report_master_id                                           =$value->id;
            $data['petty_cash_list']['id']                              =$value->id;
            $data['petty_cash_list']['unique_no']                       =$value->unique_no;
            $data['petty_cash_list']['transaction_no']                  =$value->transaction_no;
            $data['petty_cash_list']['report_no']                       =$value->report_no;

            $data['petty_cash_list']['payment_posting_status']          =$value->payment_posting_status;
            $data['petty_cash_list']['posting_status']                  =$value->posting_status;            
            $data['petty_cash_list']['report_amount']                   =$value->amount;
            $data['petty_cash_list']['cost_center']                     =$value->cost_center;
            $data['petty_cash_list']['project']                         =$value->project;

            $data['petty_cash_list']['multiple_cost_center']            =$value->multiple_cost_center;
            $data['petty_cash_list']['multiple_project']                =$value->multiple_project;

            $data['petty_cash_list']['posted_date']                     =date("Y-m-d",strtotime($value->posted_date));
            $data['petty_cash_list']['cheque_date']                     =date("Y-m-d",strtotime($value->cheque_date));
            $data['petty_cash_list']['transaction_date']                =date("Y-m-d",strtotime($value->transaction_date));
            $data['petty_cash_list']['report_date']                     =date("Y-m-d",strtotime($value->report_date));


            $data['petty_cash_list']['payment_status']                  =$value->payment_status;
            $data['petty_cash_list']['posted_by']                       =$value->posted_by;
            $data['petty_cash_list']['petty_cash_holder_name']          =$value->petty_cash_holder_name;
            $data['petty_cash_list']['account_holder_id']               =$value->account_holder_id; 
            $data['petty_cash_list']['reference_no']                    =$value->reference_no;
            $data['petty_cash_list']['reference_id']                    =$value->reference_id;           
            $data['petty_cash_list']['cheque_no']                       =$value->cheque_no;
            $data['petty_cash_list']['payment_approval']                =$value->payment_approval;

            $data['petty_cash_list']['pay_to']                          =$value->pay_to;
            $data['petty_cash_list']['cheque_amount']                    =$value->cheque_amount;
            $data['petty_cash_list']['comments']                        =$value->comments;
            $data['petty_cash_list']['next_step']                       =$value->next_step;
            $data['petty_cash_list']['flag']                            =$value->flag; 
     
          
        }


        $petty_cash_expense_list=PettyCashExpenseDetails::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('mst_id',$report_master_id)
                                        ->get();
        $sl=0; $total_amount=0; $total_tax=0; $total_paid=0;                              
        foreach ($petty_cash_expense_list as $key => $value) {

            $data['petty_cash_expense_list'][$sl]['id']                       =$value->id;
            $data['petty_cash_expense_list'][$sl]['mst_id']                   =$value->mst_id;
            $data['petty_cash_expense_list'][$sl]['purchase_date']            =$value->purchase_date;
            $data['petty_cash_expense_list'][$sl]['purchase_no']              =$value->purchase_no;
            $data['petty_cash_expense_list'][$sl]['seller_name']              =$value->seller_name;
            $data['petty_cash_expense_list'][$sl]['item_description']         =$value->item_description;
            $data['petty_cash_expense_list'][$sl]['amount']                   =$value->amount;

            $data['petty_cash_expense_list'][$sl]['amount_account']           =$value->amount_account;
            $data['petty_cash_expense_list'][$sl]['amount_account_id']        =$value->amount_account_id;
            $data['petty_cash_expense_list'][$sl]['coa_description']          =$value->coa_description;
            $data['petty_cash_expense_list'][$sl]['tax_rate']                 =$value->tax_rate;
            $data['petty_cash_expense_list'][$sl]['tax_amount']               =$value->tax_amount;
            $data['petty_cash_expense_list'][$sl]['tax_account']              =$value->tax_account;
            $data['petty_cash_expense_list'][$sl]['tax_account_id']           =$value->tax_account_id;
            $data['petty_cash_expense_list'][$sl]['tax_coa_description']      =$value->tax_coa_description;
            $data['petty_cash_expense_list'][$sl]['paid_amount']              =$value->paid_amount;

            $data['petty_cash_expense_list'][$sl]['paid_account']            =$value->paid_account;
            $data['petty_cash_expense_list'][$sl]['paid_account_id']         =$value->paid_account_id;
            $data['petty_cash_expense_list'][$sl]['paid_coa_description']    =$value->paid_coa_description;
            $data['petty_cash_expense_list'][$sl]['cost_center']             =$value->cost_center;
            $data['petty_cash_expense_list'][$sl]['project']                 =$value->project;

            $total_amount       +=$value->amount;
            $total_tax          +=$value->tax_amount;
            $total_paid         +=$value->paid_amount;
        

            $sl++;
        }

        $data['total_amount']             =$total_amount;
        $data['total_tax']                =$total_tax;
        $data['total_paid']               =$total_paid;
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
            'transaction_type'                  => 'required',
            'transaction_date'                  => 'required',
            'posted_date'                       => 'required',
           // 'cost_center'                       => 'required',
            'payment_approval'                  => 'required',
            'report_date'                       => 'required',
            'report_amount'                     => 'required',
            'petty_cash_holder_name'            => 'required',
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $transaction_date                    =date("Y-m-d",strtotime($request->input('transaction_date')));

        if($request->input('posted_date'))
        {

            $posted_date                      =date("Y-m-d",strtotime($request->input('posted_date')));
            $request->merge(['posted_date'    =>$posted_date]);
        }

        if($request->input('report_date'))
        {

            $report_date                      =date("Y-m-d",strtotime($request->input('report_date')));
            $request->merge(['report_date'    =>$report_date]);
        }

        if($request->input('cheque_date'))
        {

            $cheque_date                      =date("Y-m-d",strtotime($request->input('cheque_date')));
            $request->merge(['cheque_date'    =>$cheque_date]);
        }

        $request->merge(['transaction_date'     =>$transaction_date]);
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['updated_by'           =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);


        $company_id="";
        $company_type="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }

       

        $request->merge(['company_id' =>$company_id]);

        DB::beginTransaction();
        $petty_cash_info= PettyCash::find($id)->update($request->all());

        foreach($request->purchase_details_arr as $key=>$details)
        {
            //dd($details['purchase_date']);die;  
            $purchase_date="";
            if($details['purchase_date'])
            {

                $purchase_date                      =date("Y-m-d",strtotime($details['purchase_date']));
            }        
            

            if($details['id']>0)
            {
                $details_data_update= array(
                    'purchase_date'             =>$purchase_date,
                    'purchase_no'               =>$details["purchase_no"],
                    'seller_name'               =>$details["seller_name"],
                    'item_description'          =>$details["item_description"],
                    'amount'                    =>$details["amount"],
                    'amount_account'            =>$details["amount_account"],
                    'amount_account_id'         =>$details["amount_account_id"],
                    'coa_description'           =>$details["coa_description"],
                    'cost_center'               =>$details["cost_center"],
                    'project'                   =>$details["project"],
                    'tax_rate'                  =>$details["tax_rate"],
                    'tax_amount'                =>$details["tax_amount"],
                    'tax_account'               =>$details["tax_account"],
                    'tax_account_id'            =>$details["tax_account_id"],
                    'tax_coa_description'       =>$details["tax_coa_description"],
                    'paid_amount'               =>$details["paid_amount"],
                    'paid_account'              =>$details["paid_account"],
                    'paid_account_id'           =>$details["paid_account_id"],
                    'paid_coa_description'      =>$details["paid_coa_description"],
                    'updated_by'                =>$user_id,
                );

                $productData=PettyCashExpenseDetails::where('id',"=",$details['id'])->update($details_data_update);
                if( !$productData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }
                
            }
            else
            {
                $purchase_details[]= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$id,
                    'purchase_date'             =>$purchase_date,
                    'purchase_no'               =>$details["purchase_no"],
                    'seller_name'               =>$details["seller_name"],
                    'item_description'          =>$details["item_description"],
                    'amount'                    =>$details["amount"],
                    'amount_account'            =>$details["amount_account"],
                    'amount_account_id'         =>$details["amount_account_id"],
                    'coa_description'           =>$details["coa_description"],
                    'cost_center'               =>$details["cost_center"],
                    'project'                   =>$details["project"],
                    'tax_rate'                  =>$details["tax_rate"],
                    'tax_amount'                =>$details["tax_amount"],
                    'tax_account'               =>$details["tax_account"],
                    'tax_account_id'            =>$details["tax_account_id"],
                    'tax_coa_description'       =>$details["tax_coa_description"],
                    'paid_amount'               =>$details["paid_amount"],
                    'paid_account'              =>$details["paid_account"],
                    'paid_account_id'           =>$details["paid_account_id"],
                    'paid_coa_description'      =>$details["paid_coa_description"],
                    'inserted_by'               =>$user_id
                    
                );                    
            }
                   
        } 
       
        $RID2=true;
        if(!empty($purchase_details))
        {
            $RID2=PettyCashExpenseDetails::insert($purchase_details);
        }

        if($petty_cash_info && $RID2)
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

        $RID1=true;
        $RID2=true;

        $update_data= array(
                        
                            'status_active'             =>0,
                            'is_deleted'                =>1,
                            'updated_by'                =>$user_id,
                        );

        $petty_cash_delete=PettyCash::where('id',"=",$id)->update($request->all());


        if($petty_cash_delete)
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
        request()->validate([
            'transaction_type'                  => 'required',
            'transaction_date'                  => 'required',
            'posted_date'                       => 'required',
           //'cost_center'                       => 'required',
            'payment_approval'                  => 'required',
            'report_date'                       => 'required',
            'report_amount'                     => 'required',
            'petty_cash_holder_name'            => 'required',
            
        ]);


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $transaction_date                    =date("Y-m-d",strtotime($request->input('transaction_date')));

        if($request->input('posted_date'))
        {

            $posted_date                      =date("Y-m-d",strtotime($request->input('posted_date')));
            $request->merge(['posted_date'    =>$posted_date]);
        }

        if($request->input('report_date'))
        {

            $report_date                      =date("Y-m-d",strtotime($request->input('report_date')));
            $request->merge(['report_date'    =>$report_date]);
        }

        if($request->input('cheque_date'))
        {

            $cheque_date                      =date("Y-m-d",strtotime($request->input('cheque_date')));
            $request->merge(['cheque_date'    =>$cheque_date]);
        }

        $request->merge(['transaction_date'     =>$transaction_date]);
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['updated_by'           =>$user_id]);
        $request->merge(['project_id'           =>$project_id]);


        $company_id="";
        $company_type="";
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return; 
        }

       

        $request->merge(['company_id' =>$company_id]);

       

        $month_start_date=date("Y-m-01", strtotime($transaction_date));
        $month_end_date=date("Y-m-t", strtotime($transaction_date));

        
       
       

        $request->merge(['company_id' =>$company_id]);

        $period_dtls_sql=DB::table('ac_period_masters as mst')
                            ->join('ac_period_details as dtls','mst.id','=','dtls.mst_id')
                            ->where('mst.company_id', '=', $company_id)
                            ->where('mst.project_id','=',$project_id)
                            ->where('mst.status_active','=',1)
                            ->where('dtls.project_id','=',$project_id)
                            ->where('dtls.status_active','=',1)
                            ->where('dtls.period_ending_date','=',$month_end_date)
                            ->where('dtls.period_starting_date','=',$month_start_date)
                            //->toSql();
                            ->get(['dtls.mst_id','dtls.month_id','dtls.is_locked']);

        
        $period_locked=0; 
        if(!empty($period_dtls_sql)) 
        {
            $period_locked=$period_dtls_sql[0]->is_locked;
            $ac_period_id=$period_dtls_sql[0]->month_id;
            $ac_year_id=$period_dtls_sql[0]->mst_id;
        }                         
        
        if($period_locked==1)  { return "100"; die; }
        $request->merge(['form_mst_id'          =>$id]);
        $request->merge(['ac_year_id'           =>$ac_year_id]);
        $request->merge(['ac_period_id'         =>$ac_period_id]);
        $request->merge(['form_name'            =>302]);
        
       
        $petty_cash_info= PettyCash::find($id);

        if($request->posting_status!=3){       

            $max_system_data = AcTransactionMaster::whereRaw('journal_code = (select max(journal_code) from ac_transaction_masters where company_id='.$company_id.' and journal_type_id=13 and project_id='.$project_id.' and ac_year_id='.$ac_year_id.' and  status_active=1) and company_id='.$company_id.' and journal_type_id=13 and project_id='.$project_id.' and ac_year_id='.$ac_year_id.' and  status_active=1')->get(['journal_code']);

                   
           
            if(count($max_system_data)>0)
            {
                $max_system_prefix=$max_system_data[0]->journal_code+1; 
            }
            else
            {
                $max_system_prefix=1; 
            }


            $previous_transaction=AcTransactionMaster::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            ->where('form_name',302)
                                            ->where('form_mst_id',$id)
                                            ->where('id',$petty_cash_info->journal_id)
                                            ->where('transaction_no',$request->input('transaction_no'))
                                            ->first();
            $year= date("y",strtotime($request->input('transaction_date')));                              
            $journal_id="REVJ-".$year."-".str_pad($max_system_prefix, 5, 0, STR_PAD_LEFT);

           
            $previous_transaction_dtls=AcTransactionDtls::where('status_active',1)
                                            ->where('project_id',$project_id)
                                            ->where('transaction_mst_id',$petty_cash_info->journal_id)
                                            ->get();
            

           // dd($previous_transaction_dtls);                               
            DB::beginTransaction();

            if($previous_transaction)
            {
                $RID1=AcTransactionMaster:: create(
                    [
                        'project_id'                =>$project_id,
                        'company_id'                =>$company_id,
                        'form_mst_id'               =>$id,
                        'ac_year_id'                =>$ac_year_id,
                        'journal_type_id'           =>13,
                        'ac_period_id'              =>$ac_period_id,
                        'journal_code'              =>$max_system_prefix,
                        'transaction_no'            =>$journal_id,
                        'transaction_date'          =>$previous_transaction->transaction_date,
                        'amount'                    =>$previous_transaction->amount,
                        'cheque_no'                 =>$previous_transaction->cheque_no,
                        'recept_no'                 =>$previous_transaction->recept_no,
                        'mst_narration'             =>$previous_transaction->mst_narration,
                        'form_name'                 =>$previous_transaction->form_name,
                        'reverse_from'              =>$previous_transaction->id,
                        'inserted_by'               =>$user_id
                    ]
                );

                foreach($previous_transaction_dtls as $jour_dtls)
                {

                    if($jour_dtls->debit_amount>0)
                    {
                        
                        $transaction_details[]= array(
                                'project_id'                =>$project_id,
                                'transaction_mst_id'        =>$RID1->id,
                                'account_code'              =>$jour_dtls->account_code,
                                'ac_coa_mst_id'             =>$jour_dtls->ac_coa_mst_id,
                                'ac_description'            =>$jour_dtls->ac_description,
                                'debit_amount'              =>0,
                                'credit_amount'             =>$jour_dtls->debit_amount,
                                'currency_id'               =>$jour_dtls->currency_id,
                                'conversion_rate'           =>$jour_dtls->conversion_rate,
                                'narration'                 =>$jour_dtls->narration,
                                'seller_name'               =>$jour_dtls->seller_name,
                                'inserted_by'               =>$user_id
                        );
                    }
                    else 
                    {
                       
                        $transaction_details[]= array(
                                'project_id'                =>$project_id,
                                'transaction_mst_id'        =>$RID1->id,
                                'account_code'              =>$jour_dtls->account_code,
                                'ac_coa_mst_id'             =>$jour_dtls->ac_coa_mst_id,
                                'ac_description'            =>$jour_dtls->ac_description,
                                'debit_amount'              =>$jour_dtls->credit_amount,
                                'credit_amount'             =>0,
                                'currency_id'               =>$jour_dtls->currency_id,
                                'conversion_rate'           =>$jour_dtls->conversion_rate,
                                'narration'                 =>$jour_dtls->narration,
                                'seller_name'               =>$jour_dtls->seller_name,
                                'inserted_by'               =>$user_id
                        );
                    }
                }
            }


            

            if(!empty($transaction_details))
            {
                $RID2=AcTransactionDtls::insert($transaction_details);
            }

        }
        else
        {
            $RID1=true;
            $RID2=true;

            DB::beginTransaction();
        }


        foreach($request->purchase_details_arr as $key=>$details)
        {
            $purchase_date="";
            if($details['purchase_date'])
            {

                $purchase_date                      =date("Y-m-d",strtotime($details['purchase_date']));
            }        
            

            if($details['id']>0)
            {
                $details_data_update= array(
                    'purchase_date'             =>$purchase_date,
                    'purchase_no'               =>$details["purchase_no"],
                    'seller_name'               =>$details["seller_name"],
                    'item_description'          =>$details["item_description"],
                    'amount'                    =>$details["amount"],
                    'amount_account'            =>$details["amount_account"],
                    'amount_account_id'         =>$details["amount_account_id"],
                    'coa_description'           =>$details["coa_description"],
                    'cost_center'               =>$details["cost_center"],
                    'project'                   =>$details["project"],
                    'tax_rate'                  =>$details["tax_rate"],
                    'tax_amount'                =>$details["tax_amount"],
                    'tax_account'               =>$details["tax_account"],
                    'tax_account_id'            =>$details["tax_account_id"],
                    'tax_coa_description'       =>$details["tax_coa_description"],
                    'paid_amount'               =>$details["paid_amount"],
                    'paid_account'              =>$details["paid_account"],
                    'paid_account_id'           =>$details["paid_account_id"],
                    'paid_coa_description'      =>$details["paid_coa_description"],
                    'updated_by'                =>$user_id,
                );

                $productData=PettyCashExpenseDetails::where('id',"=",$details['id'])->update($details_data_update);
                if( !$productData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }

                
            }
            else
            {
                $purchase_details[]= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$id,
                    'purchase_date'             =>$purchase_date,
                    'purchase_no'               =>$details["purchase_no"],
                    'seller_name'               =>$details["seller_name"],
                    'item_description'          =>$details["item_description"],
                    'amount'                    =>$details["amount"],
                    'amount_account'            =>$details["amount_account"],
                    'amount_account_id'         =>$details["amount_account_id"],
                    'coa_description'           =>$details["coa_description"],
                    'cost_center'               =>$details["cost_center"],
                    'project'                   =>$details["project"],
                    'tax_rate'                  =>$details["tax_rate"],
                    'tax_amount'                =>$details["tax_amount"],
                    'tax_account'               =>$details["tax_account"],
                    'tax_account_id'            =>$details["tax_account_id"],
                    'tax_coa_description'       =>$details["tax_coa_description"],
                    'paid_amount'               =>$details["paid_amount"],
                    'paid_account'              =>$details["paid_account"],
                    'paid_account_id'           =>$details["paid_account_id"],
                    'paid_coa_description'      =>$details["paid_coa_description"],
                    'inserted_by'               =>$user_id
                    
                );                    
            }

                   
        } 


        $RID3=true;
        if(!empty($purchase_details))
        {
            $RID3=PettyCashExpenseDetails::insert($purchase_details);
        }

        $request->merge(['posting_status'       =>3]);
        $RID4=$petty_cash_info->update($request->all());


        if($RID1 && $RID2 && $RID3 && $RID4)
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
    public function post(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        $RID1=true;
        $RID2=true;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
            $currency_id=$request->session()->get('currency_id');
        }
        else {

            return; 
        }

       
        $conversion_rate=1;
        $transaction_date=date("Y-m-d",strtotime($request->input('transaction_date')));
        $request->merge(['transaction_date'     =>$transaction_date]);
        $month_start_date=date("Y-m-01", strtotime($transaction_date));
        $month_end_date=date("Y-m-t", strtotime($transaction_date));

        $period_dtls_sql=DB::table('ac_period_masters as mst')
                            ->join('ac_period_details as dtls','mst.id','=','dtls.mst_id')
                            ->where('mst.company_id', '=', $company_id)
                            ->where('mst.project_id','=',$project_id)
                            ->where('mst.status_active','=',1)
                            ->where('dtls.project_id','=',$project_id)
                            ->where('dtls.status_active','=',1)
                            ->where('dtls.period_ending_date','=',$month_end_date)
                            ->where('dtls.period_starting_date','=',$month_start_date)
                            ->get(['dtls.mst_id','dtls.month_id','dtls.is_locked']);

        
        $period_locked=0; 
        if(!empty($period_dtls_sql)) 
        {
            $period_locked=$period_dtls_sql[0]->is_locked;
            $ac_period_id=$period_dtls_sql[0]->month_id;
            $ac_year_id=$period_dtls_sql[0]->mst_id;
        }                         
        
        if($period_locked==1)  { return "100"; die; }

        $request->merge(['form_mst_id'          =>$id]);
        $request->merge(['ac_year_id'           =>$ac_year_id]);
        $request->merge(['ac_period_id'         =>$ac_period_id]);
        $request->merge(['project_id'           =>$project_id]);
        $request->merge(['company_id'           =>$company_id]);
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['updated_by'           =>$user_id]);
        $request->merge(['mst_narration'        =>$request->input('comments')]);
        $request->merge(['amount'               =>$request->input('total_paid')]);
        $request->merge(['form_name'            =>302]);

        DB::beginTransaction();
        $RID1= AcTransactionMaster::create($request->all());


        foreach($request->purchase_details_arr as $key=>$details)
        {
            //dd($details['purchase_date']);die;  
            $purchase_date="";
            if($details['purchase_date'])
            {

                $purchase_date                      =date("Y-m-d",strtotime($details['purchase_date']));
            }        
            

            if($details['id']>0)
            {
                $details_data_update= array(
                    'purchase_date'             =>$purchase_date,
                    'purchase_no'               =>$details["purchase_no"],
                    'seller_name'               =>$details["seller_name"],
                    'item_description'          =>$details["item_description"],
                    'amount'                    =>$details["amount"],
                    'amount_account'            =>$details["amount_account"],
                    'amount_account_id'         =>$details["amount_account_id"],
                    'coa_description'           =>$details["coa_description"],
                    'cost_center'               =>$details["cost_center"],
                    'project'                   =>$details["project"],
                    'tax_rate'                  =>$details["tax_rate"],
                    'tax_amount'                =>$details["tax_amount"],
                    'tax_account'               =>$details["tax_account"],
                    'tax_account_id'            =>$details["tax_account_id"],
                    'tax_coa_description'       =>$details["tax_coa_description"],
                    'paid_amount'               =>$details["paid_amount"],
                    'paid_account'              =>$details["paid_account"],
                    'paid_account_id'           =>$details["paid_account_id"],
                    'paid_coa_description'      =>$details["paid_coa_description"],
                    'updated_by'                =>$user_id,
                );

                $productData=PettyCashExpenseDetails::where('id',"=",$details['id'])->update($details_data_update);
                if( !$productData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }

                
            }
            else
            {
                $purchase_details[]= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$id,
                    'purchase_date'             =>$purchase_date,
                    'purchase_no'               =>$details["purchase_no"],
                    'seller_name'               =>$details["seller_name"],
                    'item_description'          =>$details["item_description"],
                    'amount'                    =>$details["amount"],
                    'amount_account'            =>$details["amount_account"],
                    'amount_account_id'         =>$details["amount_account_id"],
                    'coa_description'           =>$details["coa_description"],
                    'cost_center'               =>$details["cost_center"],
                    'project'                   =>$details["project"],
                    'tax_rate'                  =>$details["tax_rate"],
                    'tax_amount'                =>$details["tax_amount"],
                    'tax_account'               =>$details["tax_account"],
                    'tax_account_id'            =>$details["tax_account_id"],
                    'tax_coa_description'       =>$details["tax_coa_description"],
                    'paid_amount'               =>$details["paid_amount"],
                    'paid_account'              =>$details["paid_account"],
                    'paid_account_id'           =>$details["paid_account_id"],
                    'paid_coa_description'      =>$details["paid_coa_description"],
                    'inserted_by'               =>$user_id
                    
                );                    
            }

            $transaction_details[]= array(
                'project_id'                =>$project_id,
                'transaction_mst_id'        =>$RID1->id,
                'row_id'                    =>$details['id'],
                'account_code'              =>$details['amount_account'],
                'ac_coa_mst_id'             =>$details['amount_account_id'],
                'ac_description'            =>$details['coa_description'],
                'debit_amount'              =>$details["amount"],
                'credit_amount'             =>0,
                'currency_id'               =>$currency_id,
                'conversion_rate'           =>$conversion_rate,
                'narration'                 =>$details["item_description"],
                'seller_name'               =>$details["seller_name"],
                'inserted_by'               =>$user_id
                
            );

            $transaction_details[]= array(
                'project_id'                =>$project_id,
                'transaction_mst_id'        =>$RID1->id,
                'row_id'                    =>$details['id'],
                'account_code'              =>$details['tax_account'],
                'ac_coa_mst_id'             =>$details['tax_account_id'],
                'ac_description'            =>$details['tax_coa_description'],
                'debit_amount'              =>$details["tax_amount"],
                'credit_amount'             =>0,
                'currency_id'               =>$currency_id,
                'conversion_rate'           =>$conversion_rate,
                'narration'                 =>$details["item_description"],
                'seller_name'               =>$details["seller_name"],
                'inserted_by'               =>$user_id
                
            );

            $transaction_details[]= array(
                'project_id'                =>$project_id,
                'transaction_mst_id'        =>$RID1->id,
                'row_id'                    =>$details['id'],
                'account_code'              =>$details['paid_account'],
                'ac_coa_mst_id'             =>$details['paid_account_id'],
                'ac_description'            =>$details['paid_coa_description'],
                'debit_amount'              =>0,
                'credit_amount'             =>$details["paid_amount"],
                'currency_id'               =>$currency_id,
                'conversion_rate'           =>$conversion_rate,
                'narration'                 =>$details["item_description"],
                'seller_name'               =>$details["seller_name"],
                'inserted_by'               =>$user_id
                
            );
                   
        } 
       
        $RID2=true;
        if(!empty($purchase_details))
        {
            $RID2=PettyCashExpenseDetails::insert($purchase_details);
        }
        $request->merge(['journal_id'          =>$RID1->id]);
        $request->merge(['posting_status'      =>2]);
        // $update_data= array(
        //                     'posting_status'            =>2,
        //                     'updated_by'                =>$user_id,
        //                     'journal_id'                =>$RID1->id,
        //                 );
        $RID3=true;

        if(!empty($transaction_details))
        {
            $RID3=AcTransactionDtls::insert($transaction_details);
        }
        //$PettyCash=PettyCash::where('id',"=",$id)->update($request->all());
        $PettyCash= PettyCash::find($id)->update($request->all());
      
       // dd($PettyCash && $RID1 && $RID2 && $RID3);
        if($PettyCash && $RID1 && $RID2 && $RID3)
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

    public function repost(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        $RID1=true;
        $RID2=true;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
            $currency_id=$request->session()->get('currency_id');
        }
        else {

            return; 
        }

       
        $conversion_rate=1;
        $transaction_date=date("Y-m-d",strtotime($request->input('transaction_date')));
        $request->merge(['transaction_date'     =>$transaction_date]);
        $month_start_date=date("Y-m-01", strtotime($transaction_date));
        $month_end_date=date("Y-m-t", strtotime($transaction_date));

        $period_dtls_sql=DB::table('ac_period_masters as mst')
                            ->join('ac_period_details as dtls','mst.id','=','dtls.mst_id')
                            ->where('mst.company_id', '=', $company_id)
                            ->where('mst.project_id','=',$project_id)
                            ->where('mst.status_active','=',1)
                            ->where('dtls.project_id','=',$project_id)
                            ->where('dtls.status_active','=',1)
                            ->where('dtls.period_ending_date','=',$month_end_date)
                            ->where('dtls.period_starting_date','=',$month_start_date)
                            ->get(['dtls.mst_id','dtls.month_id','dtls.is_locked']);

        
        $period_locked=0; 
        if(!empty($period_dtls_sql)) 
        {
            $period_locked=$period_dtls_sql[0]->is_locked;
            $ac_period_id=$period_dtls_sql[0]->month_id;
            $ac_year_id=$period_dtls_sql[0]->mst_id;
        }                         
        
        if($period_locked==1)  { return "100"; die; }

        $request->merge(['form_mst_id'          =>$id]);
        $request->merge(['ac_year_id'           =>$ac_year_id]);
        $request->merge(['ac_period_id'         =>$ac_period_id]);
        $request->merge(['project_id'           =>$project_id]);
        $request->merge(['company_id'           =>$company_id]);
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['updated_by'           =>$user_id]);
        $request->merge(['mst_narration'        =>$request->input('comments')]);
        $request->merge(['amount'               =>$request->input('total_paid')]);
        $request->merge(['form_name'            =>302]);

        DB::beginTransaction();
        $RID1= AcTransactionMaster::create($request->all());


        foreach($request->purchase_details_arr as $key=>$details)
        {
            //dd($details['purchase_date']);die;  
            $purchase_date="";
            if($details['purchase_date'])
            {

                $purchase_date                      =date("Y-m-d",strtotime($details['purchase_date']));
            }        
            

            if($details['id']>0)
            {
                $details_data_update= array(
                    'purchase_date'             =>$purchase_date,
                    'purchase_no'               =>$details["purchase_no"],
                    'seller_name'               =>$details["seller_name"],
                    'item_description'          =>$details["item_description"],
                    'amount'                    =>$details["amount"],
                    'amount_account'            =>$details["amount_account"],
                    'amount_account_id'         =>$details["amount_account_id"],
                    'coa_description'           =>$details["coa_description"],
                    'cost_center'               =>$details["cost_center"],
                    'project'                   =>$details["project"],
                    'tax_rate'                  =>$details["tax_rate"],
                    'tax_amount'                =>$details["tax_amount"],
                    'tax_account'               =>$details["tax_account"],
                    'tax_account_id'            =>$details["tax_account_id"],
                    'tax_coa_description'       =>$details["tax_coa_description"],
                    'paid_amount'               =>$details["paid_amount"],
                    'paid_account'              =>$details["paid_account"],
                    'paid_account_id'           =>$details["paid_account_id"],
                    'paid_coa_description'      =>$details["paid_coa_description"],
                    'updated_by'                =>$user_id,
                );

                $productData=PettyCashExpenseDetails::where('id',"=",$details['id'])->update($details_data_update);
                if( !$productData)
                {
                    DB::rollBack();
                    return 10;
                    die;
                }

                
            }
            else
            {
                $purchase_details[]= array(
                    'project_id'                =>$project_id,
                    'mst_id'                    =>$id,
                    'purchase_date'             =>$purchase_date,
                    'purchase_no'               =>$details["purchase_no"],
                    'seller_name'               =>$details["seller_name"],
                    'item_description'          =>$details["item_description"],
                    'amount'                    =>$details["amount"],
                    'amount_account'            =>$details["amount_account"],
                    'amount_account_id'         =>$details["amount_account_id"],
                    'coa_description'           =>$details["coa_description"],
                    'cost_center'               =>$details["cost_center"],
                    'project'                   =>$details["project"],
                    'tax_rate'                  =>$details["tax_rate"],
                    'tax_amount'                =>$details["tax_amount"],
                    'tax_account'               =>$details["tax_account"],
                    'tax_account_id'            =>$details["tax_account_id"],
                    'tax_coa_description'       =>$details["tax_coa_description"],
                    'paid_amount'               =>$details["paid_amount"],
                    'paid_account'              =>$details["paid_account"],
                    'paid_account_id'           =>$details["paid_account_id"],
                    'paid_coa_description'      =>$details["paid_coa_description"],
                    'inserted_by'               =>$user_id
                    
                );                    
            }

            $transaction_details[]= array(
                'project_id'                =>$project_id,
                'transaction_mst_id'        =>$RID1->id,
                'row_id'                    =>$details['id'],
                'account_code'              =>$details['amount_account'],
                'ac_coa_mst_id'             =>$details['amount_account_id'],
                'ac_description'            =>$details['coa_description'],
                'debit_amount'              =>$details["amount"],
                'credit_amount'             =>0,
                'currency_id'               =>$currency_id,
                'conversion_rate'           =>$conversion_rate,
                'narration'                 =>$details["item_description"],
                'seller_name'               =>$details["seller_name"],
                'inserted_by'               =>$user_id
                
            );

            $transaction_details[]= array(
                'project_id'                =>$project_id,
                'transaction_mst_id'        =>$RID1->id,
                'row_id'                    =>$details['id'],
                'account_code'              =>$details['tax_account'],
                'ac_coa_mst_id'             =>$details['tax_account_id'],
                'ac_description'            =>$details['tax_coa_description'],
                'debit_amount'              =>$details["tax_amount"],
                'credit_amount'             =>0,
                'currency_id'               =>$currency_id,
                'conversion_rate'           =>$conversion_rate,
                'narration'                 =>$details["item_description"],
                'seller_name'               =>$details["seller_name"],
                'inserted_by'               =>$user_id
                
            );

            $transaction_details[]= array(
                'project_id'                =>$project_id,
                'transaction_mst_id'        =>$RID1->id,
                'row_id'                    =>$details['id'],
                'account_code'              =>$details['paid_account'],
                'ac_coa_mst_id'             =>$details['paid_account_id'],
                'ac_description'            =>$details['paid_coa_description'],
                'debit_amount'              =>0,
                'credit_amount'             =>$details["paid_amount"],
                'currency_id'               =>$currency_id,
                'conversion_rate'           =>$conversion_rate,
                'narration'                 =>$details["item_description"],
                'seller_name'               =>$details["seller_name"],
                'inserted_by'               =>$user_id
                
            );
                   
        } 
       
        $RID2=true;
        if(!empty($purchase_details))
        {
            $RID2=PettyCashExpenseDetails::insert($purchase_details);
        }
        $request->merge(['journal_id'          =>$RID1->id]);
        $request->merge(['posting_status'      =>4]);
        // $update_data= array(
        //                     'posting_status'            =>2,
        //                     'updated_by'                =>$user_id,
        //                     'journal_id'                =>$RID1->id,
        //                 );
        $RID3=true;

        if(!empty($transaction_details))
        {
            $RID3=AcTransactionDtls::insert($transaction_details);
        }
        //$PettyCash=PettyCash::where('id',"=",$id)->update($request->all());
        $PettyCash= PettyCash::find($id)->update($request->all());
      
       // dd($PettyCash && $RID1 && $RID2 && $RID3);
        if($PettyCash && $RID1 && $RID2 && $RID3)
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
