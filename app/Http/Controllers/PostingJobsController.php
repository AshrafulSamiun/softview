<?php

namespace App\Http\Controllers;
use App\Models\Country as Country;
use App\Models\NewPostingJob as NewPostingJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PostingJobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $country                            =Country::where('status_active',1)->get();


        foreach ($country as $key => $value) 
		{
            $country_arr[$value->id]        =$value->country_name;
            $country_code_arr[$value->id]   =$value->country_code;
        }
       // $ArrayFunction              =new ArrayFunction();
       // $transaaction_arr                =$ArrayFunction->transaaction_types;
        //$data['transaaction_arr']        =$transaaction_arr;
        $data['country_arr']                =$country_arr;
        $project_id                         = \Auth::user()->project_id;
        $user_id                            = \Auth::user()->id;
        $company_data                       =NewPostingJob::where('project_id',$project_id)->where('status_active',1)->get();
        $data['posting_data']               =array();
        foreach($company_data as $key=>$val)
        {

            /*'account_no','posting_class','post_name','post_user_id',
            'posting_user_type', 'posting_status','creating_date','approved_date','validation_period_date','expiration_date',
            'employer_number','employer_companay_name','full_legal_name','company_address','company_website','company_contacts',
            'company_about_us','posting_title','job_title',' Employment_self_employed','full_part_time','hourly_rate','monthly_salary',
            'posting_benefits','job_description','posting_responsibilities','education_lavel','posting_skills',' job_experience',
            'permit_license','work_location','days_hours','overtime_allowed','probation_period','posting_bondable','contract_requited',
            'medical_test','drug','criminal_check','personal','work','school','living_area','online','phone','in_person','posting_note',
            'posting_accept','inserted_by','updated_by','status_active','is_deleted', */ 


            $data['posting_data']['id']                                         =$val->id;
            $data['posting_data']['account_no']                            =$val->account_no;
             
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
            'post_name'                        => 'required', 
             
        ]);

        $user_data                              = \Auth::user();
        $user_id                                =$user_data->id;
        $project_id                             =$user_data->project_id;
        $request->merge(['user_id'              =>$user_id]);
        $request->merge(['inserted_by'          =>$user_id]);
        $request->merge(['project_id'           =>$project_id]); 
        
        $new_posting_date                                   =date("Y-m-d",strtotime($request->input('new_posting_date')));
        $renew_posting_date                                 =date("Y-m-d",strtotime($request->input('renew_posting_date')));
        $reported_posting_date                              =date("Y-m-d",strtotime($request->input('reported_posting_date')));
        $Paid_posting_date                                  =date("Y-m-d",strtotime($request->input('Paid_posting_date')));
        $edited_posting_date                                =date("Y-m-d",strtotime($request->input('edited_posting_date')));
        $validation_period_posting_date                     =date("Y-m-d",strtotime($request->input('validation_period_posting_date')));
        $posted_posting_date                                =date("Y-m-d",strtotime($request->input('posted_posting_date')));
        $expired_posting_date                               =date("Y-m-d",strtotime($request->input('expired_posting_date')));
        $re_posting_date                                    =date("Y-m-d",strtotime($request->input('re_posting_date')));
        $publised_posting_date                              =date("Y-m-d",strtotime($request->input('publised_posting_date')));
        $removing_posting_date                              =date("Y-m-d",strtotime($request->input('removing_posting_date')));

        //dd($expiration_date);

        $request->merge(['new_posting_date'             =>$new_posting_date]);
        $request->merge(['renew_posting_date'           =>$renew_posting_date]);
        $request->merge(['reported_posting_date'        =>$reported_posting_date]);
        $request->merge(['Paid_posting_date'            =>$Paid_posting_date]);
        $request->merge(['edited_posting_date'          =>$edited_posting_date]);
        $request->merge(['validation_period_posting_date'         =>$validation_period_posting_date]);
        $request->merge(['posted_posting_date'           =>$posted_posting_date]);
        $request->merge(['expired_posting_date'          =>$expired_posting_date]);
        $request->merge(['re_posting_date'               =>$re_posting_date]);
        $request->merge(['publised_posting_date'         =>$publised_posting_date]);
        $request->merge(['removing_posting_date'         =>$removing_posting_date]);
         

        /*$current_year=date('Y');

        $max_account_data = Company::whereRaw('account_prefix=(select max(account_prefix) as account_prefix from companies where project_id='.$project_id.'
         and YEAR(created_at)='.date('Y').' ) and project_id='.$project_id.' and YEAR(created_at)='.date('Y'))->get(['account_prefix']);

        if(count($max_account_data)>0)
        {
            $max_account_prefix=$max_account_data[0]->account_prefix+1; 
        }
        else
        {
               $max_account_prefix=1; 
        }

        $account_no=$current_year."-".str_pad($max_account_prefix, 4, 0, STR_PAD_LEFT);
        $request->merge(['account_no'               =>$account_no]);
        $request->merge(['account_prefix'           =>$max_account_prefix]);*/


        DB::beginTransaction();

        $posting_insert=NewPostingJob::create($request->all());

       // $user_project=Project::find($project_id)->update(array('project_status' => 99));


        //if( $posting_insert && $user_project)
        if( $posting_insert)
        {
           DB::commit();
           return 1;
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
