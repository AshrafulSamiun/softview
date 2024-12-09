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
                                                    ->join('job_sites as dtls','mst.id','=','dtls.company_id')
                                                    ->where('mst.project_id', '=', $project_id)
                                                    ->where('dtls.project_id', '=', $project_id)
                                                    ->whereIn('mst.posting_status', [2,4])
                                                    ->where('mst.status_active', '=', 1)
                                                    ->where('dtls.status_active', '=', 1)
                                                    ->where('dtls.company_type', '=', 1)
                                                    ->select('dtls.site_type','dtls.site_name','mst.legal_name','dtls.id as site_id','mst.id as company_id')
                                                     ->orderBy('mst.legal_name')
                                                     ->get();

                                                     
        $company_arr=array();
        $sl=0;$job_site_sl=0;
        $current_company_name="";

        foreach ($company_jobsite as $key => $value) {
            if($current_company_name!=$value->legal_name)
            {
               $current_company_name            =$value->legal_name;
               $job_site_sl                     =1;
            } 
            $company_arr[$sl]['sl']             =$sl+1;
            $company_arr[$sl]['company_id']     =$value->company_id;
            $company_arr[$sl]['company_name']   =$value->legal_name;
            $company_arr[$sl]['site_type']      =$value->site_type;
            $company_arr[$sl]['site_id']        =$value->site_id;
            $company_arr[$sl]['site_name']      =$value->site_name;
            $company_arr[$sl]['site_sl']        =$job_site_sl;
            $company_arr[$sl]['last_modified_date']='';
            $company_arr[$sl]['last_modified_by']='';
            $company_arr[$sl]['company_type']   =1;
            $sl++;
            $job_site_sl++;
        }

        $customer_jobsite                       =DB::table('account_holder_customers as mst')
                                                    ->join('job_sites as dtls','mst.id','=','dtls.company_id')
                                                    ->where('mst.project_id', '=', $project_id)
                                                    ->where('dtls.project_id', '=', $project_id)
                                                    ->whereIn('mst.posting_status',  [2,4])
                                                    ->where('mst.status_active', '=', 1)
                                                    ->where('dtls.status_active', '=', 1)
                                                    ->where('dtls.company_type', '=', 2)
                                                    ->select('dtls.site_type','dtls.site_name','mst.customer_name','dtls.id as site_id','mst.id as company_id')
                                                    ->orderBy('mst.customer_name')
                                                    ->get();
        //  dd($customer_jobsite) ;                                         
        $job_site_sl=0;
        $current_company_name="";
        foreach ($customer_jobsite as $key => $value) {
            if($current_company_name!=$value->customer_name)
            {
               $current_company_name            =$value->customer_name;
               $job_site_sl                     =1;
            } 
            $company_arr[$sl]['sl']             =$sl+1;
            $company_arr[$sl]['company_id']     =$value->company_id;
            $company_arr[$sl]['company_name']   =$value->customer_name;
            $company_arr[$sl]['site_type']      =$value->site_type;
            $company_arr[$sl]['site_id']        =$value->site_id;
            $company_arr[$sl]['site_name']      =$value->site_name;
            $company_arr[$sl]['site_sl']        =$job_site_sl;
            $company_arr[$sl]['last_modified_date']='';
            $company_arr[$sl]['last_modified_by']='';
            $company_arr[$sl]['company_type']   =2;
            $sl++;
            $job_site_sl++;
        }

        $serivce_provider_site                  =DB::table('account_holder_service_providers as mst')
                                                    ->join('job_sites as dtls','mst.id','=','dtls.company_id')
                                                    ->where('mst.project_id', '=', $project_id)
                                                    ->where('dtls.project_id', '=', $project_id)
                                                    ->whereIn('mst.posting_status', [2,4])
                                                    ->where('mst.status_active', '=', 1)
                                                    ->where('dtls.status_active', '=', 1)
                                                    ->where('dtls.company_type', '=', 3)
                                                    ->select('dtls.site_type','dtls.site_name','mst.service_provider_name','dtls.id as site_id','mst.id as company_id')
                                                    ->orderBy('mst.service_provider_name')
                                                    ->get();
       
        $job_site_sl=0;
        $current_company_name="";
        foreach ($serivce_provider_site as $key => $value) {
            if($current_company_name!=$value->service_provider_name)
            {
               $current_company_name            =$value->service_provider_name;
               $job_site_sl                     =1;
            } 
            $company_arr[$sl]['sl']             =$sl+1;
            $company_arr[$sl]['company_id']     =$value->company_id;
            $company_arr[$sl]['company_name']   =$value->service_provider_name;
            $company_arr[$sl]['site_id']        =$value->site_id;
            $company_arr[$sl]['site_name']      =$value->site_name;
            $company_arr[$sl]['site_type']      =$value->site_type;
            $company_arr[$sl]['site_sl']        =$job_site_sl;
         $company_arr[$sl]['last_modified_date']='';
           $company_arr[$sl]['last_modified_by']='';
            $company_arr[$sl]['company_type']   =3;
            $sl++;
            $job_site_sl++;
        }

        if(session()->has('site_avaibale'))
        {
            $data['site_avaibale']              =session()->get('site_avaibale');
            $data['company_id']                 =session()->get('company_id');
            $data['company_type']               =session()->get('company_type');
            $data['company_name']               =session()->get('company_name');
            $data['site_name']                  =session()->get('site_name');
            $data['site_type']                  =session()->get('site_type');
            $data['site_id']                    =session()->get('site_id');
        }
        else
        {
            $data['site_avaibale']              =false;
            $data['company_id']                 ='';
            $data['company_type']               ='';
            $data['company_name']               ='';
            $data['site_name']                  ='';
            $data['site_type']                  ='';
            $data['site_id']                    ='';
        }

        $data['company_arr']                    =$company_arr;

        return $data;
    }

    public function open_files(Request $request)
    {

        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        $request->session()->put('site_avaibale',true);
        $request->session()->put('company_id',$request->input('company_id'));
        $request->session()->put('company_type',$request->input('company_type'));
        $request->session()->put('company_name',$request->input('company_name'));
        $request->session()->put('site_name',$request->input('site_name'));
        $request->session()->put('site_type',$request->input('site_type'));
        $request->session()->put('site_id',$request->input('site_id'));

    }
}
