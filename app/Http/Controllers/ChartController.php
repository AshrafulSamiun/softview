<?php

namespace App\Http\Controllers;

use App\ChartDetails;
use App\ChartMaster;
use App\Models\User;
use Charts;
use DB;
use Illuminate\Http\Request;

class ChartController extends Controller
{
   
    public function index()
    {
        $users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
                    ->get();
        $chart = Charts::database($users, 'bar', 'highcharts')
                  ->title("Monthly new Register Users")
                  ->elementLabel("Total Users")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupByMonth(date('Y'), true);
        return view('chart',compact('chart'));
    }

    public function donut()
    {
        
        $chart = Charts::create('donut', 'highcharts')
                ->title('My nice chart')

                ->colors(['#ff0000', '#ff00ff', '#408000'])
                ->labels(['First', 'Second', 'Third'])
                ->values([5,10,20])
                ->dimensions(500,200)
                ->responsive(false);
        return view('chart',compact('chart'));
    }

    public function line()
    {
        
        $chart = Charts::create('line', 'highcharts')
                ->title('My nice chart')
                ->elementLabel('My nice label')
                ->labels(['First', 'Second', 'Third'])
                ->values([5,10,20])
                ->dimensions(1000,500)
                ->responsive(false);
        return view('chart',compact('chart'));
    }

    public function area()
    {
        
        $chart =Charts::create('area', 'highcharts')
                ->title('My nice chart')
                ->elementLabel('Population groth')
                ->labels(['First', 'Second', 'Third'])
                ->values([5,10,20])
                ->dimensions(1000,500)
                ->responsive(false);
        return view('chart',compact('chart'));
    }

    public function Areaspline ()
    {
        
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
        return view('chart',compact('chart','chart1'));
    }

    public function geo()
    {
        
        $chart = Charts::create('geo', 'highcharts')
                ->title('Population')
                ->elementLabel('My nice label')
                ->labels(['IN', 'CA', 'RU'])
                ->colors(['#b3b300', '#009900'])
                ->values([5,10,20])
                ->dimensions(1000,500)
                ->responsive(false);
        return view('chart',compact('chart'));
    }

    public function Percentage()
    {
        
        $chart = Charts::create('percentage', 'justgage')
                ->title('My nice chart')
                ->elementLabel('My nice label')
                ->values([65,0,100])
                ->responsive(true)
                ->height(300)
                ->width(0);
        return view('chart',compact('chart'));
    }


    public function all_chart()
    {
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

        return view('all_chart',$data);
    }

    public function UserPieChart()
    {

        $data['yes_no_arr']=array(1=>"Yes",2=>"No");
        $data['pi_chart_mst_data']=ChartMaster::where('status_active',1)
                                    ->where('chart_type',1)->get();

        $data['menu_title']="Pie Chart";   
        return view('user_pie_chart',$data);
    }


    public function UserPieChartEdit($mst_id)
    {
        $data['yes_no_arr']=array(1=>"Yes",2=>"No");
        $data['pi_chart_data']=ChartMaster::where('status_active',1)->get();
        $data['pi_chart_mst_data']=ChartMaster::where('status_active',1)
                                  ->where('id',$mst_id)
                                  ->get();
       /// dd($data['pi_chart_mst_data'][0]->chart_text);die;
        $data['pi_chart_dtls_data']=ChartDetails::where('status_active',1)
                                  ->where('mst_id',$mst_id)
                                  ->get();

        $data['menu_title']="Pie Chart";   
        return view('user_pie_chart_eidt',$data);
    }


    public function insert_pi_chart(Request $request)
    {

        $lavelName=$request->input('lavelName');
        $lavelValue=$request->input('lavelValue');
        $LavelColor=$request->input('LavelColor');
        

        $this->validate($request,[
            'title' =>'required',
            'is_responsive' =>'required',

        ]);
        $request->merge(['chart_type'    =>1]);
        $user_data = \Auth::user();
        DB::beginTransaction();
        $RID=ChartMaster::create($request->all());


        foreach($request->lavelName as $key=>$details)
        {

            $data[]= array(
                'mst_id'            =>$RID->id,
                'lavelName'         =>$details,
                'laveValue'         =>$lavelValue[$key],
                'lavelColor'        =>$LavelColor[$key],
                'status_active'     =>1,
                'inserted_by'       =>$user_data->id,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s')
             );  
                   
          }
          $RId1=ChartDetails::insert($data);
      
          if($RID  && $RId1)
          {
             DB::commit();
              return back()->with('success','Data Saved Successfully');
          }
          else
          {
              DB::rollBack();
             return Redirect::back()->withErrors(['msg', 'Data Not Save']);
          }

         return back()->with('success','Excel Data Imported Successfully');

     }


    public function update_pi_chart(Request $request,$mst_id)
    {

        $lavelName=$request->input('lavelName');
        $lavelValue=$request->input('lavelValue');
        $LavelColor=$request->input('LavelColor');
        $LavelId=$request->input('lavelId');
        $request->merge(['chart_type'    =>1]);

        $this->validate($request,[
          'title' =>'required',
          'is_responsive' =>'required',

        ]);

        $user_data = \Auth::user();
        DB::beginTransaction();
        $RID=ChartMaster::find($mst_id)->update($request->all());

        $chart_details_update=true;
        $inserted_data=array();
        foreach($request->lavelName as $key=>$details)
        {
            if($LavelId[$key])
            {
                $details_update= array(
                    'id'                =>$LavelId[$key],
                    'mst_id'            =>$mst_id,
                    'lavelName'         =>$details,
                    'laveValue'         =>$lavelValue[$key],
                    'lavelColor'        =>$LavelColor[$key],
                    'status_active'     =>1,
                    'inserted_by'       =>$user_data->id,
                    'updated_at'        => date('Y-m-d H:i:s')
                ); 

               $chart_details_update=ChartDetails::where('id',"=",$LavelId[$key])->update($details_update);
            }
            else
            {
                $inserted_data[]= array(
                    'mst_id'            =>$mst_id,
                    'lavelName'         =>$details,
                    'laveValue'         =>$lavelValue[$key],
                    'lavelColor'        =>$LavelColor[$key],
                    'status_active'     =>1,
                    'inserted_by'       =>$user_data->id,
                    'created_at'        => date('Y-m-d H:i:s'),
                    'updated_at'        => date('Y-m-d H:i:s')
                 ); 

            }
        }

        $details_data_insert=true;
        if(!empty($inserted_data))
        {
            $details_data_insert=ChartDetails::insert($inserted_data); 
        }
      
          if($RID  && $chart_details_update && $details_data_insert)
          {
             DB::commit();
              return back()->with('success','Data Updated Successfully');
          }
          else
          {
              DB::rollBack();
             return Redirect::back()->withErrors(['msg', 'Data Not Save']);
          }

         return back()->with('success','Excel Data Imported Successfully');

     }






    //=======================bar chart==================================================

    public function UserBarChart()
    {
        $data['yes_no_arr']=array(1=>"Yes",2=>"No");
        $data['pi_chart_mst_data']=ChartMaster::where('status_active',1)
                                    ->where('chart_type',2)->get();

        $data['menu_title']="Bar Chart";   
        return view('user_bar_chart',$data);
     }


    public function UserBarChartEdit($mst_id)
     {
        $data['yes_no_arr']=array(1=>"Yes",2=>"No");
        $data['pi_chart_data']=ChartMaster::where('status_active',1)
                                ->where('chart_type',2)->get();
        $data['pi_chart_mst_data']=ChartMaster::where('status_active',1)
                                  ->where('id',$mst_id)
                                  ->get();
        $data['pi_chart_dtls_data']=ChartDetails::where('status_active',1)
                                  ->where('mst_id',$mst_id)
                                  ->get();


        $data['menu_title']="Pie Chart";   
        return view('user_bar_chart_eidt',$data);
     }

     public function insert_bar_chart(Request $request)
     {

        $lavelName=$request->input('lavelName');
        $lavelValue=$request->input('lavelValue');
        $LavelColor=$request->input('LavelColor');
        

        $request->merge(['chart_type'    =>2]);

        $this->validate($request,[
          'title' =>'required',
          'is_responsive' =>'required',

        ]);
         $user_data = \Auth::user();
         DB::beginTransaction();
         $RID=ChartMaster::create($request->all());


        foreach($request->lavelName as $key=>$details)
        {

              $data[]= array(
                  'mst_id'          =>$RID->id,
                  'lavelName'         =>$details,
                  'laveValue'         =>$lavelValue[$key],
                  'lavelColor'        =>$LavelColor[$key],
                  'status_active'     =>1,
                  'inserted_by'       =>$user_data->id,
                  'created_at'        => date('Y-m-d H:i:s'),
                  'updated_at'        => date('Y-m-d H:i:s')
             );  
                   
          }
          $RId1=ChartDetails::insert($data);
      
          if($RID  && $RId1)
          {
             DB::commit();
              return back()->with('success','Data Saved Successfully');
          }
          else
          {
              DB::rollBack();
             return Redirect::back()->withErrors(['msg', 'Data Not Save']);
          }

         return back()->with('success','Excel Data Imported Successfully');

     }

     
    public function update_bar_chart(Request $request,$mst_id)
    {

        $lavelName=$request->input('lavelName');
        $lavelValue=$request->input('lavelValue');
        $LavelColor=$request->input('LavelColor');
        $LavelId=$request->input('lavelId');

        $request->merge(['chart_type'    =>2]);

        $this->validate($request,[
          'title' =>'required',
          'is_responsive' =>'required',

        ]);

        $user_data = \Auth::user();
        DB::beginTransaction();
        $RID=ChartMaster::find($mst_id)->update($request->all());

        $chart_details_update=true;
        $inserted_data=array();
        foreach($request->lavelName as $key=>$details)
        {
            if($LavelId[$key])
            {
                $details_update= array(
                    'id'                =>$LavelId[$key],
                    'mst_id'            =>$mst_id,
                    'lavelName'         =>$details,
                    'laveValue'         =>$lavelValue[$key],
                    'lavelColor'        =>$LavelColor[$key],
                    'status_active'     =>1,
                    'inserted_by'       =>$user_data->id,
                    'updated_at'        => date('Y-m-d H:i:s')
                ); 

               $chart_details_update=ChartDetails::where('id',"=",$LavelId[$key])->update($details_update);
            }
            else
            {
                $inserted_data[]= array(
                    'mst_id'            =>$mst_id,
                    'lavelName'         =>$details,
                    'laveValue'         =>$lavelValue[$key],
                    'lavelColor'        =>$LavelColor[$key],
                    'status_active'     =>1,
                    'inserted_by'       =>$user_data->id,
                    'created_at'        => date('Y-m-d H:i:s'),
                    'updated_at'        => date('Y-m-d H:i:s')
                 ); 

            }
        }

        $details_data_insert=true;
        if(!empty($inserted_data))
        {
            $details_data_insert=ChartDetails::insert($inserted_data); 
        }
      
          if($RID  && $chart_details_update && $details_data_insert)
          {
             DB::commit();
              return back()->with('success','Data Updated Successfully');
          }
          else
          {
              DB::rollBack();
             return Redirect::back()->withErrors(['msg', 'Data Not Save']);
          }

         return back()->with('success','Excel Data Imported Successfully');

     }






    //=======================line chart==================================================

    public function UserLineChart()
    {
        $data['yes_no_arr']=array(1=>"Yes",2=>"No");
        $data['pi_chart_mst_data']=ChartMaster::where('status_active',1)
                                    ->where('chart_type',3)->get();

        $data['menu_title']="Line Chart";   
        return view('user_line_chart',$data);
     }


    public function UserLineChartEdit($mst_id)
     {
        $data['yes_no_arr']=array(1=>"Yes",2=>"No");
        $data['pi_chart_data']=ChartMaster::where('status_active',1)
                                ->where('chart_type',3)->get();
        $data['pi_chart_mst_data']=ChartMaster::where('status_active',1)
                                  ->where('id',$mst_id)
                                  ->get();
        $data['pi_chart_dtls_data']=ChartDetails::where('status_active',1)
                                  ->where('mst_id',$mst_id)
                                  ->get();


        $data['menu_title']="Line Chart";   
        return view('user_line_chart_eidt',$data);
     }

     public function insert_line_chart(Request $request)
     {

        $lavelName=$request->input('lavelName');
        $lavelValue=$request->input('lavelValue');
        $LavelColor=$request->input('LavelColor');
        

        $request->merge(['chart_type'    =>3]);

        $this->validate($request,[
          'title' =>'required',
          'is_responsive' =>'required',

        ]);
         $user_data = \Auth::user();
         DB::beginTransaction();
         $RID=ChartMaster::create($request->all());


        foreach($request->lavelName as $key=>$details)
        {

              $data[]= array(
                  'mst_id'          =>$RID->id,
                  'lavelName'         =>$details,
                  'laveValue'         =>$lavelValue[$key],
                  'lavelColor'        =>$LavelColor[$key],
                  'status_active'     =>1,
                  'inserted_by'       =>$user_data->id,
                  'created_at'        => date('Y-m-d H:i:s'),
                  'updated_at'        => date('Y-m-d H:i:s')
             );  
                   
          }
          $RId1=ChartDetails::insert($data);
      
          if($RID  && $RId1)
          {
             DB::commit();
              return back()->with('success','Data Saved Successfully');
          }
          else
          {
              DB::rollBack();
             return Redirect::back()->withErrors(['msg', 'Data Not Save']);
          }

         return back()->with('success','Excel Data Imported Successfully');

     }

     
    public function update_line_chart(Request $request,$mst_id)
    {

        $lavelName=$request->input('lavelName');
        $lavelValue=$request->input('lavelValue');
        $LavelColor=$request->input('LavelColor');
        $LavelId=$request->input('lavelId');

        $request->merge(['chart_type'    =>3]);

        $this->validate($request,[
          'title' =>'required',
          'is_responsive' =>'required',

        ]);

        $user_data = \Auth::user();
        DB::beginTransaction();
        $RID=ChartMaster::find($mst_id)->update($request->all());

        $chart_details_update=true;
        $inserted_data=array();
        foreach($request->lavelName as $key=>$details)
        {
            if($LavelId[$key])
            {
                $details_update= array(
                    'id'                =>$LavelId[$key],
                    'mst_id'            =>$mst_id,
                    'lavelName'         =>$details,
                    'laveValue'         =>$lavelValue[$key],
                    'lavelColor'        =>$LavelColor[$key],
                    'status_active'     =>1,
                    'inserted_by'       =>$user_data->id,
                    'updated_at'        => date('Y-m-d H:i:s')
                ); 

               $chart_details_update=ChartDetails::where('id',"=",$LavelId[$key])->update($details_update);
            }
            else
            {
                $inserted_data[]= array(
                    'mst_id'            =>$mst_id,
                    'lavelName'         =>$details,
                    'laveValue'         =>$lavelValue[$key],
                    'lavelColor'        =>$LavelColor[$key],
                    'status_active'     =>1,
                    'inserted_by'       =>$user_data->id,
                    'created_at'        => date('Y-m-d H:i:s'),
                    'updated_at'        => date('Y-m-d H:i:s')
                 ); 

            }
        }

        $details_data_insert=true;
        if(!empty($inserted_data))
        {
            $details_data_insert=ChartDetails::insert($inserted_data); 
        }
      
          if($RID  && $chart_details_update && $details_data_insert)
          {
             DB::commit();
              return back()->with('success','Data Updated Successfully');
          }
          else
          {
              DB::rollBack();
             return Redirect::back()->withErrors(['msg', 'Data Not Save']);
          }

         return back()->with('success','Excel Data Imported Successfully');

     }



    //=======================Area chart==================================================

    public function UserAreaChart()
    {
        $data['yes_no_arr']=array(1=>"Yes",2=>"No");
        $data['pi_chart_mst_data']=ChartMaster::where('status_active',1)
                                    ->where('chart_type',4)->get();

        $data['menu_title']="Area Chart";   
        return view('user_area_chart',$data);
     }


    public function UserAreaChartEdit($mst_id)
     {
        $data['yes_no_arr']=array(1=>"Yes",2=>"No");
        $data['pi_chart_data']=ChartMaster::where('status_active',1)
                                ->where('chart_type',4)->get();
        $data['pi_chart_mst_data']=ChartMaster::where('status_active',1)
                                  ->where('id',$mst_id)
                                  ->get();
        $data['pi_chart_dtls_data']=ChartDetails::where('status_active',1)
                                  ->where('mst_id',$mst_id)
                                  ->get();


        $data['menu_title']="Area Chart";   
        return view('user_area_chart_eidt',$data);
     }

     public function insert_area_chart(Request $request)
     {

        $lavelName=$request->input('lavelName');
        $lavelValue=$request->input('lavelValue');
        $LavelColor=$request->input('LavelColor');
        

        $request->merge(['chart_type'    =>4]);

        $this->validate($request,[
          'title' =>'required',
          'is_responsive' =>'required',

        ]);
         $user_data = \Auth::user();
         DB::beginTransaction();
         $RID=ChartMaster::create($request->all());


        foreach($request->lavelName as $key=>$details)
        {

              $data[]= array(
                  'mst_id'          =>$RID->id,
                  'lavelName'         =>$details,
                  'laveValue'         =>$lavelValue[$key],
                  'lavelColor'        =>$LavelColor[$key],
                  'status_active'     =>1,
                  'inserted_by'       =>$user_data->id,
                  'created_at'        => date('Y-m-d H:i:s'),
                  'updated_at'        => date('Y-m-d H:i:s')
             );  
                   
          }
          $RId1=ChartDetails::insert($data);
      
          if($RID  && $RId1)
          {
             DB::commit();
              return back()->with('success','Data Saved Successfully');
          }
          else
          {
              DB::rollBack();
             return Redirect::back()->withErrors(['msg', 'Data Not Save']);
          }

         return back()->with('success','Excel Data Imported Successfully');

     }

     
    public function update_area_chart(Request $request,$mst_id)
    {

        $lavelName=$request->input('lavelName');
        $lavelValue=$request->input('lavelValue');
        $LavelColor=$request->input('LavelColor');
        $LavelId=$request->input('lavelId');

        $request->merge(['chart_type'    =>4]);

        $this->validate($request,[
          'title' =>'required',
          'is_responsive' =>'required',

        ]);

        $user_data = \Auth::user();
        DB::beginTransaction();
        $RID=ChartMaster::find($mst_id)->update($request->all());

        $chart_details_update=true;
        $inserted_data=array();
        foreach($request->lavelName as $key=>$details)
        {
            if($LavelId[$key])
            {
                $details_update= array(
                    'id'                =>$LavelId[$key],
                    'mst_id'            =>$mst_id,
                    'lavelName'         =>$details,
                    'laveValue'         =>$lavelValue[$key],
                    'lavelColor'        =>$LavelColor[$key],
                    'status_active'     =>1,
                    'inserted_by'       =>$user_data->id,
                    'updated_at'        => date('Y-m-d H:i:s')
                ); 

               $chart_details_update=ChartDetails::where('id',"=",$LavelId[$key])->update($details_update);
            }
            else
            {
                $inserted_data[]= array(
                    'mst_id'            =>$mst_id,
                    'lavelName'         =>$details,
                    'laveValue'         =>$lavelValue[$key],
                    'lavelColor'        =>$LavelColor[$key],
                    'status_active'     =>1,
                    'inserted_by'       =>$user_data->id,
                    'created_at'        => date('Y-m-d H:i:s'),
                    'updated_at'        => date('Y-m-d H:i:s')
                 ); 

            }
        }

        $details_data_insert=true;
        if(!empty($inserted_data))
        {
            $details_data_insert=ChartDetails::insert($inserted_data); 
        }
      
          if($RID  && $chart_details_update && $details_data_insert)
          {
             DB::commit();
              return back()->with('success','Data Updated Successfully');
          }
          else
          {
              DB::rollBack();
             return Redirect::back()->withErrors(['msg', 'Data Not Save']);
          }

         return back()->with('success','Excel Data Imported Successfully');

     }






    //=======================Geo chart==================================================

    public function UserGeoChart()
    {
        $data['yes_no_arr']=array(1=>"Yes",2=>"No");
        $data['pi_chart_mst_data']=ChartMaster::where('status_active',1)
                                    ->where('chart_type',6)->get();

        $data['menu_title']="Geo Chart";   
        return view('user_geo_chart',$data);
     }


    public function UserGeoChartEdit($mst_id)
     {
        $data['yes_no_arr']=array(1=>"Yes",2=>"No");
        $data['pi_chart_data']=ChartMaster::where('status_active',1)
                                ->where('chart_type',6)->get();
        $data['pi_chart_mst_data']=ChartMaster::where('status_active',1)
                                  ->where('id',$mst_id)
                                  ->get();
        $data['pi_chart_dtls_data']=ChartDetails::where('status_active',1)
                                  ->where('mst_id',$mst_id)
                                  ->get();


        $data['menu_title']="Geo Chart";   
        return view('user_geo_chart_eidt',$data);
     }

     public function insert_geo_chart(Request $request)
     {

        $lavelName=$request->input('lavelName');
        $lavelValue=$request->input('lavelValue');
        $LavelColor=$request->input('LavelColor');
        

        $request->merge(['chart_type'    =>6]);

        $this->validate($request,[
          'title' =>'required',
          'is_responsive' =>'required',

        ]);
         $user_data = \Auth::user();
         DB::beginTransaction();
         $RID=ChartMaster::create($request->all());


        foreach($request->lavelName as $key=>$details)
        {

              $data[]= array(
                  'mst_id'          =>$RID->id,
                  'lavelName'         =>$details,
                  'laveValue'         =>$lavelValue[$key],
                  'lavelColor'        =>$LavelColor[$key],
                  'status_active'     =>1,
                  'inserted_by'       =>$user_data->id,
                  'created_at'        => date('Y-m-d H:i:s'),
                  'updated_at'        => date('Y-m-d H:i:s')
             );  
                   
          }
          $RId1=ChartDetails::insert($data);
      
          if($RID  && $RId1)
          {
             DB::commit();
              return back()->with('success','Data Saved Successfully');
          }
          else
          {
              DB::rollBack();
             return Redirect::back()->withErrors(['msg', 'Data Not Save']);
          }

         return back()->with('success','Excel Data Imported Successfully');

     }

     
    public function update_geo_chart(Request $request,$mst_id)
    {

        $lavelName=$request->input('lavelName');
        $lavelValue=$request->input('lavelValue');
        $LavelColor=$request->input('LavelColor');
        $LavelId=$request->input('lavelId');

        $request->merge(['chart_type'    =>6]);

        $this->validate($request,[
          'title' =>'required',
          'is_responsive' =>'required',

        ]);

        $user_data = \Auth::user();
        DB::beginTransaction();
        $RID=ChartMaster::find($mst_id)->update($request->all());

        $chart_details_update=true;
        $inserted_data=array();
        foreach($request->lavelName as $key=>$details)
        {
            if($LavelId[$key])
            {
                $details_update= array(
                    'id'                =>$LavelId[$key],
                    'mst_id'            =>$mst_id,
                    'lavelName'         =>$details,
                    'laveValue'         =>$lavelValue[$key],
                    'lavelColor'        =>$LavelColor[$key],
                    'status_active'     =>1,
                    'inserted_by'       =>$user_data->id,
                    'updated_at'        => date('Y-m-d H:i:s')
                ); 

               $chart_details_update=ChartDetails::where('id',"=",$LavelId[$key])->update($details_update);
            }
            else
            {
                $inserted_data[]= array(
                    'mst_id'            =>$mst_id,
                    'lavelName'         =>$details,
                    'laveValue'         =>$lavelValue[$key],
                    'lavelColor'        =>$LavelColor[$key],
                    'status_active'     =>1,
                    'inserted_by'       =>$user_data->id,
                    'created_at'        => date('Y-m-d H:i:s'),
                    'updated_at'        => date('Y-m-d H:i:s')
                 ); 

            }
        }

        $details_data_insert=true;
        if(!empty($inserted_data))
        {
            $details_data_insert=ChartDetails::insert($inserted_data); 
        }
      
          if($RID  && $chart_details_update && $details_data_insert)
          {
             DB::commit();
              return back()->with('success','Data Updated Successfully');
          }
          else
          {
              DB::rollBack();
             return Redirect::back()->withErrors(['msg', 'Data Not Save']);
          }

         return back()->with('success','Excel Data Imported Successfully');

     }





    //=======================UserDountChart chart==================================================

    public function UserDonutChart()
    {
        $data['yes_no_arr']=array(1=>"Yes",2=>"No");
        $data['pi_chart_mst_data']=ChartMaster::where('status_active',1)
                                    ->where('chart_type',5)->get();

        $data['menu_title']="Donut Chart";   
        return view('user_donut_chart',$data);
     }


    public function UserDonutChartEdit($mst_id)
     {
        $data['yes_no_arr']=array(1=>"Yes",2=>"No");
        $data['pi_chart_data']=ChartMaster::where('status_active',1)
                                ->where('chart_type',5)->get();
        $data['pi_chart_mst_data']=ChartMaster::where('status_active',1)
                                  ->where('id',$mst_id)
                                  ->get();
        $data['pi_chart_dtls_data']=ChartDetails::where('status_active',1)
                                  ->where('mst_id',$mst_id)
                                  ->get();


        $data['menu_title']="Donut Chart";   
        return view('user_donut_chart_eidt',$data);
     }

     public function insert_donut_chart(Request $request)
     {

        $lavelName=$request->input('lavelName');
        $lavelValue=$request->input('lavelValue');
        $LavelColor=$request->input('LavelColor');
        

        $request->merge(['chart_type'    =>5]);

        $this->validate($request,[
          'title' =>'required',
          'is_responsive' =>'required',

        ]);
         $user_data = \Auth::user();
         DB::beginTransaction();
         $RID=ChartMaster::create($request->all());


        foreach($request->lavelName as $key=>$details)
        {

              $data[]= array(
                  'mst_id'          =>$RID->id,
                  'lavelName'         =>$details,
                  'laveValue'         =>$lavelValue[$key],
                  'lavelColor'        =>$LavelColor[$key],
                  'status_active'     =>1,
                  'inserted_by'       =>$user_data->id,
                  'created_at'        => date('Y-m-d H:i:s'),
                  'updated_at'        => date('Y-m-d H:i:s')
             );  
                   
          }
          $RId1=ChartDetails::insert($data);
      
          if($RID  && $RId1)
          {
             DB::commit();
              return back()->with('success','Data Saved Successfully');
          }
          else
          {
              DB::rollBack();
             return Redirect::back()->withErrors(['msg', 'Data Not Save']);
          }

         return back()->with('success','Excel Data Imported Successfully');

     }

     
    public function update_donut_chart(Request $request,$mst_id)
    {

        $lavelName=$request->input('lavelName');
        $lavelValue=$request->input('lavelValue');
        $LavelColor=$request->input('LavelColor');
        $LavelId=$request->input('lavelId');

        $request->merge(['chart_type'    =>5]);

        $this->validate($request,[
          'title' =>'required',
          'is_responsive' =>'required',

        ]);

        $user_data = \Auth::user();
        DB::beginTransaction();
        $RID=ChartMaster::find($mst_id)->update($request->all());

        $chart_details_update=true;
        $inserted_data=array();
        foreach($request->lavelName as $key=>$details)
        {
            if($LavelId[$key])
            {
                $details_update= array(
                    'id'                =>$LavelId[$key],
                    'mst_id'            =>$mst_id,
                    'lavelName'         =>$details,
                    'laveValue'         =>$lavelValue[$key],
                    'lavelColor'        =>$LavelColor[$key],
                    'status_active'     =>1,
                    'inserted_by'       =>$user_data->id,
                    'updated_at'        => date('Y-m-d H:i:s')
                ); 

               $chart_details_update=ChartDetails::where('id',"=",$LavelId[$key])->update($details_update);
            }
            else
            {
                $inserted_data[]= array(
                    'mst_id'            =>$mst_id,
                    'lavelName'         =>$details,
                    'laveValue'         =>$lavelValue[$key],
                    'lavelColor'        =>$LavelColor[$key],
                    'status_active'     =>1,
                    'inserted_by'       =>$user_data->id,
                    'created_at'        => date('Y-m-d H:i:s'),
                    'updated_at'        => date('Y-m-d H:i:s')
                 ); 

            }
        }

        $details_data_insert=true;
        if(!empty($inserted_data))
        {
            $details_data_insert=ChartDetails::insert($inserted_data); 
        }
      
          if($RID  && $chart_details_update && $details_data_insert)
          {
             DB::commit();
              return back()->with('success','Data Updated Successfully');
          }
          else
          {
              DB::rollBack();
             return Redirect::back()->withErrors(['msg', 'Data Not Save']);
          }

         return back()->with('success','Excel Data Imported Successfully');

     }


}
