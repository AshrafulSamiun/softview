<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\Country as Country;
use App\Models\FileUpload as FileUpload;
use App\Models\Menu as Menu;
use App\Models\Module as Module;
use App\Models\Project as Project;


//use Browser;


class DashboardController extends Controller
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
        $data['property_code']      =$property_code;
        

         
            $city     = "Canada";

            
            $data['module']=Module::where('status', '=', 1)->orderBy('modSlNo')->get();
            $data['menu']=Menu::where('status', '=', 1)->where('moduleId',4)->orderBy('slno')->get();
            $main_menu_arr=array();
            $lavel_one_arr=array();
            $lavel_two_arr=array();
            foreach ($data['menu'] as $key => $value) {
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

             
            return view('market_place_dashboard',$data);
        
        
        //return view('dashboard');
    }


    
}
