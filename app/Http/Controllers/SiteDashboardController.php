<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlertCenterItem;
use App\Classes\ArrayFunction as ArrayFunction;
use Charts;

class SiteDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user                       =\Auth::user();
        $user_id                    = $user->id;
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        $ArrayFunction              =new ArrayFunction();
        $project_status             =$ArrayFunction->project_status;
        $site_id="";
        if($request->session()->has('site_avaibale'))
        {
            $site_id=$request->session()->get('site_id');
           
        }
        $data['site_id'] =$site_id;

        $allert_center_sql=AlertCenterItem::where('status_active', '=', 1)
                            ->orderBy('position','ASC')
                            ->orderBy('root_id','ASC')
                            ->orderBy('id', 'ASC')
                            ->get();

        $lavel_one_arr=array();
        foreach ($allert_center_sql as $key => $value) {

                $lavel_one_arr['header']    =23;
                $lavel_one_arr['normal']    =28;
                $lavel_one_arr['minimal']   =51;
                $lavel_one_arr['lowest']    =24;
                $lavel_one_arr['medium']    =75;
                $lavel_one_arr['high']      =21;
                $lavel_one_arr['urgent']    =28;
                              
        }

         $chart = Charts::multi('bar', 'highcharts')
                ->title('GENERAL CHARACTERIZATION 2018/2019')
                ->colors(['#ff6666', '#ffd699', '#4d94ff', '#669999'])
                ->labels(['Air', 'Port Maritime', 'Railway', 'Road'])
                ->dataset('Assets', [30000.00, 200000.00, 30000.00, 50000.00])
                ->dataset('Liabilities', [30000.00, 400000.00, 30000.00, 50000.00])
                ->dataset('Owner Capital',  [40000.00, 30000.00, 40000.00, 60000.00]);
                //->dataset('Net Income',  [40000.00, 20000.00, 500000.00, 10000.00]);
        $chart1 = Charts::create('line', 'highcharts')
                ->title('My nice chart')
                ->elementLabel('My nice label')
                ->labels(['First', 'Second', 'Third'])
                ->values([5,10,20])
                ->dimensions(1000,500)
                ->responsive(false);

        $data['user_type']          =$user_type;
        $data['chart']              =view('chart',compact('chart','chart1'));
        $data['lavel_one_arr']      =$lavel_one_arr;
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
        //
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
