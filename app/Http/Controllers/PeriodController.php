<?php

namespace App\Http\Controllers;

use App\Models\AcPeriodDetails as AcPeriodDetails;
use App\Models\AcPeriodMaster;
use App\Models\Company as Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PeriodController extends Controller
{



    public function __construct(Company $company)
    {
        $this->middleware('auth');
        $this->company=$company->all();
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return 20; 
        }


        $period_data=AcPeriodMaster::where('project_id',$project_id)->where('company_id',$company_id)->get();
        $sl=0;
        $data=array();
        foreach($period_data as $key=>$val)
        {
    
            $data[$sl]['id']=$val->id;
            $data[$sl]['sl']=$sl+1;
            $data[$sl]['year_start']=$val->year_start;
            $data[$sl]['company_id']=$val->company_id;
            //$data[$sl]['company_name']=$val->company->legal_name;
            //$data[$sl]['company_name']="";
            $data[$sl]['year_start_month']=date("n",strtotime($val->year_start_date));
            $data[$sl]['year_end_month']=date("n",strtotime($val->year_end_date));
            $data[$sl]['year_start_date']=$val->year_start_date;
            $data[$sl]['year_end_date']=$val->year_end_date;
            $data[$sl]['period_name']=$val->period_name;
            $data[$sl]['is_current']=$val->is_current;
            $data[$sl]['is_closed']=$val->is_closed;
            $data[$sl]['status_active']=$val->status_active;
            $data[$sl]['posting_status']=$val->posting_status;
            $dsl=1;
            foreach ($val->periodDetails as $dtls_key => $dtls_value) {
                if($dtls_value->status_active==1)
                {
                    $data[$sl]['details'][$dsl]['id']=$dtls_value->id;
                    $data[$sl]['details'][$dsl]['mst_id']=$dtls_value->mst_id;
                    $data[$sl]['details'][$dsl]['month_id']=$dtls_value->month_id;
                    $data[$sl]['details'][$dsl]['period_starting_date']=date("F j",strtotime($dtls_value->period_starting_date)); 
                    $data[$sl]['details'][$dsl]['period_ending_date']=date("F j",strtotime($dtls_value->period_ending_date));
                    if($dtls_value->is_locked==1)
                    {
                        $data[$sl]['details'][$dsl]['is_locked']=true;
                    }
                    else
                    {
                        $data[$sl]['details'][$dsl]['is_locked']=false; 
                    }
                   
                    $data[$sl]['details'][$dsl]['financial_period']=$dtls_value->financial_period;
                    $data[$sl]['details'][$dsl]['acc_date']=$dtls_value->period_starting_date."__".$dtls_value->period_ending_date;
                }
                $dsl++;
            }
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
            'year_start'        => 'required|max:5',
            'year_start_month'  => 'required',
            'year_end_month'    => 'required',
            'period_name'       => 'required',
            'status_active'     => 'required'
      
        ]);


        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {
            return 20; 
        }

        

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['inserted_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);
        $request->merge(['posting_status' =>0]);
        $coa_group=0;

        DB::beginTransaction();
        $mst_id=AcPeriodMaster::create($request->all())->id;
        
        foreach($request->details as $key=>$details)
        {
            $acc_date=explode("__",$details['acc_date']);
            $financial_period=$details['financial_period'];
  
            $data[]= array(
                'mst_id'=>$mst_id, 
                'project_id'=>$project_id,
                'month_id'=>$details['month_id'],
                'period_starting_date'=>$acc_date[0], 
                'period_ending_date'=>$acc_date[1],
                'financial_period'=>$financial_period, 
            );          

        }
        $RId_acc=true;
        
        $RId=AcPeriodDetails::insert($data);

        if($mst_id  && $RId)
        {
           DB::commit();
           return "1**";
        }
        else
        {
            DB::rollBack();
           return "10**";
        }
      
        //else return 0;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id acPeriodDtls
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $period_data=AcPeriodMaster::where('project_id',$project_id)->where('id',$id)->get();
        $data=array();
        foreach($period_data as $key=>$val)
        {
    
            $data['id']=$val->id;
            $data['sl']=$sl+1;
            $data['year_start']=$val->year_start;
            $data['company_id']=$val->company_id;
            $data['company_name']=$val->company->legal_name;
            $data['year_start_month']=date("n",strtotime($val->year_start_date));
            $data['year_end_month']=date("n",strtotime($val->year_end_date));
            $data['year_start_date']=$val->year_start_date;
            $data['year_end_date']=$val->year_end_date;
            $data['period_name']=$val->period_name;
            $data['is_current']=$val->is_current;
            $data['is_closed']=$val->is_closed;
            $data['status_active']=$val->status_active;
            $data['posting_status']=$val->posting_status;
            $dsl=1;
            foreach ($val->periodDetails as $dtls_key => $dtls_value) {
                if($dtls_value->status_active==1)
                {
                    $data['details'][$dsl]['id']=$dtls_value->id;
                    $data['details'][$dsl]['mst_id']=$dtls_value->mst_id;
                    $data['details'][$dsl]['month_id']=$dtls_value->month_id;
                    $data['details'][$dsl]['period_starting_date']=date("F j",strtotime($dtls_value->period_starting_date)); 
                    $data['details'][$dsl]['period_ending_date']=date("F j",strtotime($dtls_value->period_ending_date));
                    if($dtls_value->is_locked==1)
                    {
                        $data['details'][$dsl]['is_locked']=true;
                    }
                    else
                    {
                        $data['details'][$dsl]['is_locked']=false; 
                    }
                   
                    $data['details'][$dsl]['financial_period']=$dtls_value->financial_period;
                    $data['details'][$dsl]['acc_date']=$dtls_value->period_starting_date."__".$dtls_value->period_ending_date;
                }
                $dsl++;
            }
        
        }

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $period_data=AcPeriodMaster::where('project_id',$project_id)->where('id',$id)->get();
        $data=array();
        foreach($period_data as $key=>$val)
        {
    
            $data['id']=$val->id;
            //$data['sl']=$sl+1;
            $data['year_start']=$val->year_start;
            $data['company_id']=$val->company_id;
            $data['company_name']=$val->company->legal_name;
            $data['year_start_month']=date("n",strtotime($val->year_start_date));
            $data['year_end_month']=date("n",strtotime($val->year_end_date));
            $data['year_start_date']=$val->year_start_date;
            $data['year_end_date']=$val->year_end_date;
            $data['period_name']=$val->period_name;
            $data['is_current']=$val->is_current;
            $data['is_closed']=$val->is_closed;
            $data['status_active']=$val->status_active;
            $data['posting_status']=$val->posting_status;
            $dsl=1;
            foreach ($val->periodDetails as $dtls_key => $dtls_value) {
                if($dtls_value->status_active==1)
                {
                    $data['details'][$dsl]['id']=$dtls_value->id;
                    $data['details'][$dsl]['mst_id']=$dtls_value->mst_id;
                    $data['details'][$dsl]['month_id']=$dtls_value->month_id;
                    $data['details'][$dsl]['period_starting_date']=date("F j",strtotime($dtls_value->period_starting_date)); 
                    $data['details'][$dsl]['period_ending_date']=date("F j",strtotime($dtls_value->period_ending_date));
                    if($dtls_value->is_locked==1)
                    {
                        $data['details'][$dsl]['is_locked']=true;
                    }
                    else
                    {
                        $data['details'][$dsl]['is_locked']=false; 
                    }
                   
                    $data['details'][$dsl]['financial_period']=$dtls_value->financial_period;
                    $data['details'][$dsl]['acc_date']=$dtls_value->period_starting_date."__".$dtls_value->period_ending_date;
                }
                $dsl++;
            }
        
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
            //'company_id' => 'required',
            'year_start' => 'required|max:5',
            'year_start_month' => 'required',
            'year_end_month' => 'required',
            'period_name' => 'required'
      
        ]);
        
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
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);
        DB::beginTransaction();
        $RID=AcPeriodMaster::find($id)->update($request->all());
      
        foreach($request->details as $key=>$details)
        {
            $acc_date=explode("__",$details['acc_date']);
            $financial_period=$details['financial_period'];
  
            $data[]= array(
                'mst_id'=>$id, 
                'project_id'=>$project_id,
                'month_id'=>$details['month_id'],
                'period_starting_date'=>$acc_date[0], 
                'period_ending_date'=>$acc_date[1],
                'financial_period'=>$financial_period, 
            ); 

        }

        $update = AcPeriodDetails::where('mst_id', '=', $id)->update(['status_active'=>0,'is_deleted'=>1]);

        $RID2=AcPeriodDetails::insert($data); 

        if($RID  && $RID2  && $update)
        {
           DB::commit();
           return "1**";
        }
        else
        {
            DB::rollBack();
           return "10**";
        }
        return ['message'=>'update successfully']; 
    }

    public function post(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        $update_data= array(
                            'posting_status'             =>2,
                            'updated_by'                =>$user_id,
                        );

        $period=AcPeriodMaster::where('id',"=",$id)->update($update_data);
       

        if($period)
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
            //'company_id' => 'required',
            'year_start' => 'required|max:5',
            'year_start_month' => 'required',
            'year_end_month' => 'required',
            'period_name' => 'required'
      
        ]);
        
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
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);
        $request->merge(['company_id' =>$company_id]);
        $request->merge(['posting_status' =>3]);
        DB::beginTransaction();
        $RID=AcPeriodMaster::find($id)->update($request->all());
      
        foreach($request->details as $key=>$details)
        {
            $acc_date=explode("__",$details['acc_date']);
            $financial_period=$details['financial_period'];
  
            $data[]= array(
                'mst_id'=>$id, 
                'project_id'=>$project_id,
                'month_id'=>$details['month_id'],
                'period_starting_date'=>$acc_date[0], 
                'period_ending_date'=>$acc_date[1],
                'financial_period'=>$financial_period, 
            ); 

        }

        $update = AcPeriodDetails::where('mst_id', '=', $id)->update(['status_active'=>0,'is_deleted'=>1]);

        $RID2=AcPeriodDetails::insert($data); 

        if($RID  && $RID2  && $update)
        {
           DB::commit();
           return "1**";
        }
        else
        {
            DB::rollBack();
           return "10**";
        }        
          
    }

    public function repost($id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 


       // dd("i am here");die;
        $update_data= array(
                            'posting_status'            =>4,
                            'updated_by'                =>$user_id,
                        );

        $period=AcPeriodMaster::where('id',"=",$id)->update($update_data);
       

        if($period)
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
        AcPeriodMaster::find($id)->delete();
        AcPeriodDetails::where('mst_id', '=', $id)->delete();
        return ['message'=>'Module deleted'];
    }
}
