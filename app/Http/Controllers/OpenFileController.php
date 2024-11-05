<?php

namespace App\Http\Controllers;

use App\Models\Project as Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OpenFileController extends Controller
{
    public function index()
    {
    	$user=\Auth::user();

        $project_id                 = $user->project_id;
        $project_activation 		=Project::where('id',$project_id)->first();

    	//===================Company==========================================
        // $company_list               =company::where('status_active',1)
        //                             ->where('project_id',$project_id)
        //                             ->get();

        $company_list=DB::select("select mst.*, period.period_name, period.is_closed, period.is_current from companies as mst 
                                    left join ac_period_masters as period on (mst.id = period.company_id and period.status_active = 1 and period.posting_status in (2,4) )
                                    where mst.project_id = $project_id");
                                                      
        // dd($company_list) ;die;                          
        $company_arr=array();
        $sl=0;
       

        foreach ($company_list as $key => $value) {
            $company_arr[$sl]['sl']=$sl+1;
            $company_arr[$sl]['company_id'] =$value->id;
            $company_arr[$sl]['account_no'] =$value->account_no;
            $company_arr[$sl]['legal_name'] =$value->legal_name;
            $company_arr[$sl]['period_name']=$value->period_name;
            $company_arr[$sl]['currency_id']=$value->currency_id;
            if($value->is_closed==1 && $value->is_closed!==null)
                 $company_arr[$sl]['is_closed']="Closed";
            else if($value->is_closed==0 && $value->is_closed!==null)
                 $company_arr[$sl]['is_closed']="Open";
            else if($value->is_closed==null) $company_arr[$sl]['is_closed']="";
            else $company_arr[$sl]['is_closed']="";
           // $company_arr[$sl]['is_closed']=$value->is_closed==1;
            $company_arr[$sl]['last_modified_date']="";
            $company_arr[$sl]['last_modified_by']="";
            $sl++;
        }

        if(session()->has('company_avaibale'))
        {
            $data['company_avaibale']   =session()->get('company_avaibale');
            $data['company_id']         =session()->get('company_id');
            $data['account_no']         =session()->get('account_no');
            $data['legal_name']         =session()->get('legal_name');
            $data['currency_id']        =session()->get('currency_id');
        }
        else
        {
            $data['company_avaibale']=false;
            $data['company_id']     ='';
            $data['account_no']     ='';
            $data['legal_name']     ='';
            $data['currency_id']    ='';
        }

        $data['company_arr']        =$company_arr;
        return $data;
    }

    public function open_files(Request $request)
    {

        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->session()->put('company_avaibale',true);
        $request->session()->put('company_id',$request->input('company_id'));
        $request->session()->put('account_no',$request->input('account_no'));
        $request->session()->put('legal_name',$request->input('legal_name'));
        $request->session()->put('currency_id',$request->input('currency_id'));

    }
}
