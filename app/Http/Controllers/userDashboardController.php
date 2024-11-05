<?php

namespace App\Http\Controllers;

use App\Models\Menu as Menu;
use App\Models\Module as Module;

class userDashboardController extends Controller
{
    public function __construct( Module $module,Menu $menu)
    {
        //$this->middleware('auth');
        $this->module=$module->orderBy('modSlNo')->get();
        $this->menu=$menu->all();
        $this->middleware('auth');
    }



    public function index()
    {
        $project_id = \Auth::user()->project_id;
        $data['module']=Module::where('status', '=', 1)->orderBy('modSlNo')->get();
        $data['menu']=Menu::where('status', '=', 1)->get();
        
    
        return view('dashboard',$data);
        //return view('dashboard');
    }


    public function user_module($module_id)
    {
        $data['module']=Module::where('status', '=', 1)->get();
        $selected_module=Module::where('id', '=', $module_id)->get(['moduleName']);
        $data['title']=$selected_module[0]->moduleName;
       // dd($data['title']);
        $user_id = \Auth::user()->id;
        $menu_data=Menu::where('status', '=', 1)->where('moduleId', '=', $module_id)->get();

        $data['menu']=$menu_data;
        $root_menu_arr=array();
        $main_menu_arr=array();
        foreach($menu_data as $m=>$mvalue)
        {

        	if($mvalue->rootMenu>0 || $mvalue->position>1)
        	{
        		 $root_menu_arr[$mvalue->rootMenu][$mvalue->id]['id']=$mvalue->id;
           		 $root_menu_arr[$mvalue->rootMenu][$mvalue->id]['name']=$mvalue->menuName;
           		 $root_menu_arr[$mvalue->rootMenu][$mvalue->id]['menuRoute']=$mvalue->menuRoute;

           		 
        	}
        	else if($mvalue->rootMenu==0 || $mvalue->position==1)
        	{
        		 $main_menu_arr[$mvalue->id]['id']=$mvalue->id;
           		 $main_menu_arr[$mvalue->id]['name']=$mvalue->menuName;
                 $main_menu_arr[$mvalue->id]['menuRoute']=$mvalue->menuRoute;
        	}
           
        }

        $data['rootMenu']=$this->menu->where('moduleId', '=', $module_id)->where('rootMenu', '=', 0)->all();
        $data['root_menu_arr']=$root_menu_arr;
        $data['main_menu_arr']=$main_menu_arr;

//return $data;
        return view('dashboard_module',$data);
    }
}
