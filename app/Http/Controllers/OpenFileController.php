<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class OpenFileController extends Controller
{
    public function index()
    {
        $user=\Auth::user();

        $project_id                             = $user->project_id;
        $company_jobsite                        =DB::table('companies as mst')
                                                    ->where('mst.project_id', '=', $project_id)
                                                    ->whereIn('mst.posting_status', [2,4])
                                                    ->where('mst.status_active', '=', 1)
                                                    ->select('mst.legal_name','mst.id as company_id')
                                                     ->orderBy('mst.legal_name')
                                                     ->get();

                                                     
        $company_arr=array();
        $sl=0;$job_site_sl=0;

        foreach ($company_jobsite as $key => $value) {
            
            $company_arr[$sl]['sl']             =$sl+1;
            $company_arr[$sl]['company_id']     =$value->company_id;
            $company_arr[$sl]['company_name']   =$value->legal_name;
            $company_arr[$sl]['last_modified_date']='';
            $company_arr[$sl]['last_modified_by']='';
            $sl++;
        }

       

        if(session()->has('company_avaibale'))
        {
            $data['company_avaibale']           =session()->get('company_avaibale');
            $data['company_id']                 =session()->get('company_id');
            $data['company_name']               =session()->get('company_name');
        }
        else
        {
            $data['company_avaibale']           =false;
            $data['company_id']                 ='';
            $data['company_name']               ='';
          
        }

        $data['company_arr']                    =$company_arr;

        return $data;
    }

    public function open_files(Request $request)
    {

        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->session()->put('company_avaibale',true);
        $request->session()->put('company_id',$request->input('company_id'));
        $request->session()->put('company_name',$request->input('company_name'));

    }
}
