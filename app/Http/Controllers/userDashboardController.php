<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module as Module;
use App\Models\Menu as Menu;
use Illuminate\Support\Facades\DB;
use Charts;


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
        $users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
                    ->get();

        $data['areaspline'] = Charts::multi('line', 'highcharts')
                ->title('My Areas Pline chart')
                ->colors(['#ff0000', '#ffffff', '#408000'])
                ->labels(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday', 'Sunday'])
                ->dataset('John', [3, 4, 3, 5, 4, 10, 12])
                ->dataset('Jane',  [1, 3, 4, 3, 3, 5, 4])
                ->dataset('Jane',  [4, 2, 5, 1, 2, 15, 8]);

        $data['line'] = Charts::create('line', 'highcharts')
                ->title('My nice chart')
                ->elementLabel('My nice label')
                ->labels(['First', 'Second', 'Third'])
                ->values([5,10,20])
                ->dimensions(1000,500)
                ->responsive(false);



         $data['donut'] = Charts::create('donut', 'highcharts')
                ->title('My nice chart')
                ->labels(['First', 'Second', 'Third'])
                ->values([5,10,20])
                ->dimensions(500,500)
                ->responsive(false);

        $data['bar'] = Charts::database($users, 'bar', 'highcharts')
                  ->title("Monthly new Register Users")
                  ->elementLabel("Total Users")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupByMonth(date('Y'), true);

         $data['area']  =Charts::create('area', 'highcharts')
                        ->title('My nice chart')
                        ->elementLabel('My nice label')
                        ->labels(['First', 'Second', 'Third'])
                        ->values([5,10,20])
                        ->dimensions(1000,500)
                        ->responsive(false);

         $data['chart1'] =Charts::create('geo', 'highcharts')
                                ->title('My nice chart')
                                ->elementLabel('My nice label')
                                ->labels(['IN', 'CA', 'RU'])
                                ->colors(['#b3b300', '#009900'])
                                ->values([5,10,20])
                                ->dimensions(1000,500)
                                ->responsive(false);


        $data['percentage']= Charts::create('percentage', 'justgage')
                                ->title('My nice chart')
                                ->elementLabel('My nice label')
                                ->values([65,0,100])
                                ->responsive(true)
                                ->height(300)
                                ->width(0);


        $data['real_bar_chart'] = Charts::create( 'bar', 'highcharts')
                  ->title("SITUAÇÃO DA EMPRESA 2018/2019")
                  ->elementLabel("Total Users")
                  ->labels(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday', 'Sunday'])
                  ->values([5,10,20,10,15,12,18])
                  ->dimensions(1000, 500)
                  ->responsive(false);

        
    
        return $data;
        //return view('dashboard');
    }


    
}
