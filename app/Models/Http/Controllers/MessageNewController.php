<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module as Module;
use App\Menu as Menu;
use Illuminate\Support\Facades\DB;
use App\Country as Country;
use App\Project as Project;
use App\FileUpload as FileUpload;
use App\AccountContactPerson as AccountContactPerson;
use App\Classes\ArrayFunction as ArrayFunction; 
use App\NewPostingJob as NewPostingJob;
use App\LandingPageCategory as LandingPageCategory;
use App\NewPostingHousingRental as NewPostingHousingRental;
use App\NewPostingLease as NewPostingLease;
use App\NewPostingSale as NewPostingSale;
use App\PostingServices as PostingServices;
use App\PostingItemForSales as PostingItemForSales;



//use Browser;


class MessageNewController extends Controller
{
    public function __construct( Module $module,Menu $menu)
    {
        //$this->middleware('auth');
        $this->module=$module->orderBy('modSlNo')->get();
        $this->menu=$menu->where('moduleId',4)->where('status',1)->get();
        $this->middleware('auth');
    }



    public function index()
    {


        

        $user=\Auth::user();
        
        $project_id                 = $user->project_id;

       // dd($project_id); die;
        $project_info               = Project::find($project_id);

        $data['project_name']       =$project_info->project_name;
        $ArrayFunction              =new ArrayFunction();
        $user_type_arr              =$ArrayFunction->user_type_arr;
        $user_image_info=FileUpload::where('id',$user->image_id)->get();
       // dd($user_image_info);die;
        $user_image=$user_image_info[0]->image_name;
        
        $country=Country::where('status_active',1)->get();
        foreach ($country as $key => $value) {
            $country_arr[$value->id]=$value->country_name;
            $country_code_arr[$value->id]=$value->country_code;
        }


        $data['country_arr']        =$country_arr;
        $data['user']               =$user;
        $data['user_image']         =$user_image;
        $data['user_type_arr']      =$user_type_arr;
      //  $data['property_code']      =$property_code;
        

         
            $city     = "Canada";

            
            $data['module']=Module::where('status', '=', 1)->orderBy('modSlNo')->get();
            $data['menu']=Menu::where('status', '=', 1)->where('moduleId',4)->orderBy('slno')->get();
            $main_menu_arr=array();
            $lavel_one_arr=array();
            $lavel_two_arr=array();
            foreach ($data['menu'] as $key => $value) 
            {
                if($value->position==2)
                {
                   // $lavel_one_arr[$value->rootMenu][$value->id]['id']=$value->id;
                    $lavel_one_arr[$value->rootMenu][$value->id]['menuName']=$value->menuName;
                    $lavel_one_arr[$value->rootMenu][$value->id]['menuRoute']=$value->menuRoute;
                }
                else if($value->position==3)
                {
                   // $lavel_two_arr[$value->rootMenu]['id']=$value->id;
                    $lavel_two_arr[$value->rootMenu][$value->id]['menuName']=$value->menuName;
                    $lavel_two_arr[$value->rootMenu][$value->id]['menuRoute']=$value->menuRoute;
                }
                
               
            }
            $data['lavel_one_arr']=$lavel_one_arr;
            $data['lavel_two_arr']=$lavel_two_arr;


           // $data['landing_page'] =LandingPageCategory::where('project_id',$project_id)->where('landing_page_category_id',1)->where('status_active',1)->get();

            $data['landing_page'] =LandingPageCategory::where('project_id',$project_id)->where('status_active',1)->orderBy('id', 'ASC')->get();

            
 
            $data['landing_page_data']               =array();
            $z=0;
            foreach($data['landing_page'] as $key=>$val)
            {
                $data['landing_page_data'][$z]['id']                                           =$val->id;
                $data['landing_page_data'][$z]['landing_page_category_name']                   =$val->landing_page_category_name;
                $data['landing_page_data'][$z]['landing_page_category_id']                     =$val->landing_page_category_id;
                $z++;
            }




            $posting_job_data =NewPostingJob::where('project_id',$project_id)->where('status_active',1)
            ->select('job_category',DB::raw('count(id) as total_job'))->groupBy('job_category')->get(); //select id,job_category

            $data['posting_job_data']               =array();
            //$sl=0;
            foreach($posting_job_data as $key=>$val)
            {
                $data['Posting_Job_data'][$val->job_category]=$val->total_job; 
               // $sl++;
            } 


            $posting_housing_data =NewPostingHousingRental::where('project_id',$project_id)->where('status_active',1)
            ->select('job_category',DB::raw('count(id) as total_job'))->groupBy('job_category')->get(); //select id,job_category


       $data['posting_housing_data']               =array();
       // $t=0;
        foreach($posting_housing_data as $key=>$val)
        {
           // $data['postinghousing_data'][$t] =$val; 
            $data['posting_housing_data'][$val->job_category]=$val->total_job; 
           // $t++;
        }


            $posting_lease_data =NewPostingLease::where('project_id',$project_id)->where('status_active',1)
            ->select('job_category',DB::raw('count(id) as total_job'))->groupBy('job_category')->get(); //select id,job_category


            $data['posting_lease_data']               =array();
            // $t=0;
             foreach($posting_lease_data as $key=>$val)
             {
                // $data['postinghousing_data'][$t] =$val; 
                 $data['posting_lease_data'][$val->job_category]=$val->total_job; 
                // $t++;
             }

            $posting_sale_data =NewPostingSale::where('project_id',$project_id)->where('status_active',1)
            ->select('job_category',DB::raw('count(id) as total_job'))->groupBy('job_category')->get(); //select id,job_category


            $data['posting_sale_data']               =array();
            // $t=0;
             foreach($posting_sale_data as $key=>$val)
             {
                // $data['postinghousing_data'][$t] =$val; 
                 $data['posting_sale_data'][$val->job_category]=$val->total_job; 
                // $t++;
             }

             //dd($posting_job_data);

           // $reserves = DB::table('reserves')->select(DB::raw('*, count(*)'))->groupBy('day')->get();



        //$posting_housing_data =NewPostingHousingRental::where('project_id',$project_id)->where('status_active',1)->get();  
        //$posting_lease_data =NewPostingLease::where('project_id',$project_id)->where('status_active',1)->get();  
       // $posting_sale_data =NewPostingSale::where('project_id',$project_id)->where('status_active',1)->get();  
       // $posting_services_data =PostingServices::where('project_id',$project_id)->where('status_active',1)->get();  
        $posting_services_data =PostingServices::where('project_id',$project_id)->where('status_active',1)
        ->select('service_name_id',DB::raw('count(id) as total_job'))->groupBy('service_name_id')->get(); //select id,job_category
        $data['posting_services_data']               =array();
            // $t=0;
             foreach($posting_services_data as $key=>$val)
             {
                // $data['postinghousing_data'][$t] =$val; 
                 $data['posting_services_data'][$val->service_name_id]=$val->total_job; 
                // $t++;
             }
      //  $posting_item_data =PostingItemForSales::where('project_id',$project_id)->where('status_active',1)->get(); 

        $posting_item_data =PostingItemForSales::where('project_id',$project_id)->where('status_active',1)
        ->select('sales_name_id',DB::raw('count(id) as total_job'))->groupBy('sales_name_id')->get(); //select id,job_category
        $data['posting_item_data']               =array();
        // $t=0;
         foreach($posting_item_data as $key=>$val)
         {
            // $data['postinghousing_data'][$t] =$val; 
             $data['posting_item_data'][$val->sales_name_id]=$val->total_job; 
            }

       

//dd($data['Posting_Job_data']);

                                         
        
        $l=0;
        $data['postinglease_data']               =array();
        foreach($posting_lease_data as $key=>$val)
        {
            $data['postinglease_data'][$l] =$val; 
            $l++;
        }
        $data['postingsale_data']               =array();
        $j=0;
        foreach($posting_sale_data as $key=>$val)
        {
            $data['postingsale_data'][$j] =$val; 
            $j++;
        }
        $m=0;
        $data['postingservices_data']               =array();
        foreach($posting_services_data as $key=>$val)
        {
            $data['postingservices_data'][$m] =$val; 
            $m++;
        }
        $n=0;
        $data['postingitem_data']               =array();
        foreach($posting_item_data as $key=>$val)
        {
            $data['postingitem_data'][$n] =$val; 
            $n++;
        }
          // return $data;

    // echo "here";die;
    return view('message.messagesending',$data);
        
        
        //return view('dashboard');
    }


    
}
 