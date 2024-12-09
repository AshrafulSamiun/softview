<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HomeRouteController extends Controller
{

    public function contact_us()
    {
        $data['active_menu']=4;
        return view('contact_us',$data); 
    }
    public function plan()
    {
        $data['active_menu']=3;
        return view('plan',$data); 
    }
    public function about_us()
    {
        $data['active_menu']=2;
        return view('about_us',$data); 
    }
    public function home_menu()
    {
        $data['active_menu']=1;
        return view('web_index',$data); 
    }
}
