<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\PettyCash;

class BillEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
     {

        $user=\Auth::user();
        $project_id                 = $user->project_id;

        
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
                                        ->whereIn('posting_status',[2,4])
                                        ->where('company_id',$company_id)
                                        ->get();


        // $petty_cash_list=DB::table('petty_cashes as mst')
        //                     ->join('petty_cash_expense_details as dtls','mst.id','=','dtls.mst_id')
        //                     ->where('mst.company_id', '=', $company_id)
        //                     ->where('mst.status_active', '=', 1)
        //                     ->where('mst.entry_form',302)
        //                     ->whereIn('mst.posting_status',[2,4])
        //                     ->where('dtls.status_active', '=', 1)
        //                     ->select('dtls.paid_amount')
        //                     ->get();


        $total_pettycash_amount=0;$total_pettycash=0;
        foreach ($petty_cash_list as $key => $value) {

            $total_pettycash_amount+=$value->amount;
           
            $total_pettycash++;

        }

        $data['total_pettycash']            =$total_pettycash;
        $data['total_pettycash_amount']     =$total_pettycash_amount;
        
        return $data;

    }
    public function get_bill_pay(Request $request, $type)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;

        
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
            
        }
        else {

            return; 
        }

        //$project_arr=array(0=>"",1=>"Yes",2=>"No");
        $project_arr=array(1=>"Yes",2=>"No");

        $sl=0;
    

        $petty_cash_list=DB::table('petty_cashes as mst')
                            ->join('petty_cash_expense_details as dtls','mst.id','=','dtls.mst_id')
                            ->where('mst.company_id', '=', $company_id)
                            ->where('mst.status_active', '=', 1)
                            ->where('mst.entry_form',302)
                            ->whereIn('mst.posting_status',[2,4])
                            ->where('dtls.is_bill_paid', '!=', 1)
                            ->where('dtls.status_active', '=', 1)
                           // ->toSql();
                            ->get();

        $sl=0;
        $total_pettycash_amount=0;$total_pettycash=0; $bill_details_arr=array();
        foreach ($petty_cash_list as $key => $value) {
            $data['petty_cash_expense_list'][$sl]['sl']                       =$sl+1;;
            $data['petty_cash_expense_list'][$sl]['id']                       =$value->id;
            $data['petty_cash_expense_list'][$sl]['mst_id']                   =$value->mst_id;
            $data['petty_cash_expense_list'][$sl]['document_date']            =date("D M d, Y",strtotime($value->purchase_date));
            $data['petty_cash_expense_list'][$sl]['document_no']              =$value->purchase_no;
            $data['petty_cash_expense_list'][$sl]['document_type']            ="Petty Cash Report";
            $data['petty_cash_expense_list'][$sl]['payee']                    =$value->seller_name;
            $data['petty_cash_expense_list'][$sl]['item_description']         =$value->item_description;

            $data['petty_cash_expense_list'][$sl]['bill_amount']              =$value->paid_amount-$value->bill_amount;
            $data['petty_cash_expense_list'][$sl]['balance']                 =$value->paid_amount-$value->bill_amount;
            $data['petty_cash_expense_list'][$sl]['amount_to_pay']           ="";
            $data['petty_cash_expense_list'][$sl]['cost_center']             =$value->cost_center;
            $data['petty_cash_expense_list'][$sl]['project_name']            =$project_arr[$value->project];
            $data['petty_cash_expense_list'][$sl]['project']                 =$value->project;
            $data['petty_cash_expense_list'][$sl]['selected']                =false;
            $total_pettycash_amount+=$value->paid_amount-$value->bill_amount;
           
            $total_pettycash++;
            $sl++;

        }

       // $data['total_pettycash']            =$total_pettycash;
        $data['total_bill_amount']     =$total_pettycash_amount;
        
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
        //
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
        //
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
