<?php

namespace App\Http\Controllers;

use App\AddsOnItemsDetails as AddsOnItemsDetails;
use App\Models\Country as Country;
use App\Models\FinancialInfoDetail as FinancialInfoDetail;
use App\Models\FinancialInfoType as FinancialInfoType;
use App\Models\HousingPropertyManage as HousingPropertyManage;
use App\Models\IncludedItemType as IncludedItemType;
use App\Models\NewPostingHousingRental as NewPostingHousingRental;
use App\Models\PropertyManage as PropertyManage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostingHousingRentalController extends Controller
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
        //$ArrayFunction                      =new ArrayFunction();
        //$property_manage_arr                =$ArrayFunction->property_manage;
        //$data['property_manage_arr']         =$property_manage_arr;

        $data['country_arr']                =$country_arr;
        $project_id                         = \Auth::user()->project_id;
        $user_id                            = \Auth::user()->id;
        //echo $project_id; die;

            $Property_Manage_type=PropertyManage::where('status_active',1)
                                                  ->where('project_id',$project_id)
                                                  ->get();
            $sl=0;
            foreach ($Property_Manage_type as $key => $value) {
                $property_manage_arr[$sl]['id']          =$value->id;
                $property_manage_arr[$sl]['property_manage_name']  =$value->property_manage_name;
                $sl++;
            }
            $data['property_manage_arr']        =$property_manage_arr;

            $FinancialInfoType=FinancialInfoType::where('status_active',1)
                        ->where('project_id',$project_id)
                        ->get();
                        $sl=0;
                        $financial_info_type_arr=array();
                        foreach ($FinancialInfoType as $key => $value) {
                        $financial_info_type_arr[$sl]['id']          =$value->id;
                        $financial_info_type_arr[$sl]['financial_info_name']  =$value->financial_info_name;
                        $sl++;
                        }

                        $data['financial_info_type_arr']        =$financial_info_type_arr;

            $add_on_item_type=IncludedItemType::where('status_active',1)
            ->where('project_id',$project_id)
            ->get();  
            $sl=0;

           
            foreach ($add_on_item_type as $key => $value) 
            {

              

                $add_on_item_arr[$sl]['id']          =$value->id;
                $add_on_item_arr[$sl]['rootMenu']    =$value->rootMenu;
                $add_on_item_arr[$sl]['position']    =$value->position;
                $add_on_item_arr[$sl]['adds_on_items_name']  =$value->adds_on_items_name;
                $sl++;
               

               // Full texts 	id	project_id	moduleId	rootMenu	position
               if($value->position==2)
               { 

                    $add_on_item_details_arr[$value->rootMenu][$value->id]['id']          =$value->id;
                    $add_on_item_details_arr[$value->rootMenu][$value->id]['adds_on_items_name']  =$value->adds_on_items_name;
                     
                }
                
            }
            $data['add_on_item_details_arr']        =$add_on_item_details_arr;
            $data['add_on_item_arr']                =$add_on_item_arr;




       /* $company_data                       =NewPostingHousingRental::where('project_id',$project_id)->where('status_active',1)->get();
       $data['posting_data']               =array();
        foreach($company_data as $key=>$val)
        {
 

            $data['posting_data']['id']                                         =$val->id;
            $data['posting_data']['account_no']                            =$val->account_no;
             
        }*/
        
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

        $availability_date                                   =date("Y-m-d",strtotime($request->input('availability_date')));
        $saturday_schedules_date                                   =date("Y-m-d",strtotime($request->input('saturday_schedules_date')));
        $sunday_schedules_date                                   =date("Y-m-d",strtotime($request->input('sunday_schedules_date')));
        $monday_schedules_date                                   =date("Y-m-d",strtotime($request->input('monday_schedules_date')));
        $tuesday_schedules_date                                   =date("Y-m-d",strtotime($request->input('tuesday_schedules_date')));
        $wednesday_schedules_date                                   =date("Y-m-d",strtotime($request->input('wednesday_schedules_date')));
        $thursday_schedules_date                                   =date("Y-m-d",strtotime($request->input('thursday_schedules_date')));

        

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
        $request->merge(['availability_date'         =>$availability_date]);
        $request->merge(['saturday_schedules_date'         =>$saturday_schedules_date]);
        $request->merge(['sunday_schedules_date'         =>$sunday_schedules_date]);
        $request->merge(['monday_schedules_date'         =>$monday_schedules_date]);
        $request->merge(['tuesday_schedules_date'         =>$tuesday_schedules_date]);
        $request->merge(['wednesday_schedules_date'         =>$wednesday_schedules_date]);
        $request->merge(['thursday_schedules_date'         =>$thursday_schedules_date]);


        $current_year=date('Y');

        $max_posting_data = NewPostingHousingRental::whereRaw('posting_prefix=(select max(posting_prefix) as posting_prefix from new_posting_housing_rentals where project_id='.$project_id.'
         and YEAR(created_at)='.date('Y').' ) and project_id='.$project_id.' and YEAR(created_at)='.date('Y'))->get(['posting_prefix']);
 
        if(count($max_posting_data)>0)
        {
            $max_posting_prefix=$max_posting_data[0]->posting_prefix+1; 
        }
        else
        {
               $max_posting_prefix=1; 
        }
 
 
        
        $posting_no=$current_year."-".str_pad($max_posting_prefix, 4, 0, STR_PAD_LEFT);
        $request->merge(['posting_no'               =>$posting_no]);
        $request->merge(['posting_prefix'           =>$max_posting_prefix]);


        DB::beginTransaction();
        $RId2=true;
        $RId3=true;
        $RId4=true;

        $posting_housing_insert=NewPostingHousingRental::create($request->all());

       // $user_project=Project::find($project_id)->update(array('project_status' => 99));

       foreach($request->property_manage_data as $key=>$details)
       {
           if($details['reference_value']!="")
           {
               $data_property_manage_name[]= array(
                   'project_id'                  =>$project_id,
                   'page_id'                     =>1,
                   'mst_id'                      =>$posting_housing_insert->id,
                   'reference_id'                =>$details['reference_id'],
                   'property_manage_by_name'     =>$details['reference_value'],
                   'id_no'                       =>$details['id_no'],
                   'cantact'                     =>$details['cantact'],
                   'yes_no'                      =>$details['yes_no'], 
                   'inserted_by'                 =>$user_id,
               );  
           }        
       }


       foreach($request->add_on_item_data as $key=>$details)
       {
           if($details['reference_value']!="")
           {
               $data_add_on_item_name[]= array(
                   'project_id'                =>$project_id,
                   'page_id'                   =>1,
                   'mst_id'                    =>$posting_housing_insert->id,
                   'reference_id'              =>$details['reference_id'],
                   'adds_on_item_name'         =>$details['reference_value'],
                   'size_sqft'                 =>$details['size_sqft'],
                   'amount'                    =>$details['amount'],
                   'yes_no'                    =>$details['yes_no'],
                   'Comments'                 =>$details['Comments'], 
                   'inserted_by'              =>$user_id,
               );  
           }        
       }


       foreach($request->financial_info_type_data as $key=>$details)
       {
           if($details['reference_value']!="")
           {
               $data_inancial_info_type[]= array(
                   'project_id'                =>$project_id,
                   'page_id'                   =>1,
                   'mst_id'                    =>$posting_housing_insert->id,
                   'reference_id'              =>$details['reference_id'],
                   'financial_info_name'       =>$details['reference_value'],
                   'currency'                  =>$details['currency'],
                   'amount'                    =>$details['amount'],
                   'payment_due_date'          =>date("Y-m-d",strtotime($details['payment_due_date'])),
                   'comment'                 =>$details['comment'], 
                   'inserted_by'              =>$user_id,
               );  
           }        
       }

      


       //echo $request->input('posting_no'); die;

       if($data_property_manage_name)
       {
           $RId2=HousingPropertyManage::insert($data_property_manage_name);
       }

       if($data_add_on_item_name)
       {
           $RId3=AddsOnItemsDetails::insert($data_add_on_item_name);
       }


       if($data_add_on_item_name)
       {
           $RId4=FinancialInfoDetail::insert($data_inancial_info_type);
       }


        //if( $posting_insert && $user_project)
        if( $posting_housing_insert && $RId2 && $RId3 && $RId4)
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
