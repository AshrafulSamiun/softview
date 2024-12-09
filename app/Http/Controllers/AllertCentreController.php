<?php

namespace App\Http\Controllers;
use App\Classes\ArrayFunction as ArrayFunction;
use Illuminate\Http\Request;
use App\Models\AlertCenterItem;

class AllertCentreController extends Controller
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
        else
        {
            return "100**";
        }

       
        $allert_center_sql=AlertCenterItem::where('status_active', '=', 1)
                            ->orderBy('position','ASC')
                            ->orderBy('root_id','ASC')
                            ->orderBy('id', 'ASC')
                            ->get();

        $lavel_one_arr=array();
        $lavel_two_arr=array();
        $lavel_three_arr=array();


        foreach ($allert_center_sql as $key => $value) {
            if($value->position==1)
            {
                $lavel_one_arr[$value->id]['item_name'] =$value->item_name;
                $lavel_one_arr[$value->id]['header']    =$value->header;
                $lavel_one_arr[$value->id]['normal']    =$value->header;
                $lavel_one_arr[$value->id]['minimal']   =$value->header;
                $lavel_one_arr[$value->id]['lowest']    =$value->header;
                $lavel_one_arr[$value->id]['medium']    =$value->header;
                $lavel_one_arr[$value->id]['high']      =$value->header;
                $lavel_one_arr[$value->id]['urgent']    =$value->header;
            }
            else if($value->position==2)
            {
                $lavel_two_arr[$value->root_id][$value->id]['item_name'] =$value->item_name;
                $lavel_two_arr[$value->root_id][$value->id]['header']    =$value->header;
                $lavel_two_arr[$value->root_id][$value->id]['normal']    =$value->header;
                $lavel_two_arr[$value->root_id][$value->id]['minimal']   =$value->header;
                $lavel_two_arr[$value->root_id][$value->id]['lowest']    =$value->header;
                $lavel_two_arr[$value->root_id][$value->id]['medium']    =$value->header;
                $lavel_two_arr[$value->root_id][$value->id]['high']      =$value->header;
                $lavel_two_arr[$value->root_id][$value->id]['urgent']    =$value->header;
                $lavel_one_arr[$value->root_id]['item_available']        =true;
                 
                if(!empty($lavel_one_arr[$value->root_id]['total']))
                    $lavel_one_arr[$value->root_id]['total']++;
                else $lavel_one_arr[$value->root_id]['total']=1;
            }
            else if($value->position==3)
            {
                $lavel_three_arr[$value->root_id][$value->id]['item_name'] =$value->item_name;
                $lavel_three_arr[$value->root_id][$value->id]['header']    =$value->header;
                $lavel_three_arr[$value->root_id][$value->id]['normal']    =$value->header;
                $lavel_three_arr[$value->root_id][$value->id]['minimal']   =$value->header;
                $lavel_three_arr[$value->root_id][$value->id]['lowest']    =$value->header;
                $lavel_three_arr[$value->root_id][$value->id]['medium']    =$value->header;
                $lavel_three_arr[$value->root_id][$value->id]['high']      =$value->header;
                $lavel_three_arr[$value->root_id][$value->id]['urgent']    =$value->header;
                $lavel_three_arr[$value->root_id]['item_available']        =true;
                 
                if(!empty($lavel_two_arr[$value->root_id]['total']))
                    $lavel_two_arr[$value->root_id]['total']++;
                else $lavel_two_arr[$value->root_id]['total']=1;
            }
                  
        }

        $data['user_type']          =$user_type;
        $data['lavel_one_arr']      =$lavel_one_arr;
        $data['lavel_two_arr']      =$lavel_two_arr;
        $data['lavel_three_arr']    =$lavel_three_arr;
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
