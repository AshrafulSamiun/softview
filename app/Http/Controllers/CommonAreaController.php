<?php

namespace App\Http\Controllers;

use App\Models\BuildingInfo as BuildingInfo;
use App\Models\CommonArea;
use App\Models\CommonAreaDetails;
use App\Models\Floor as Floor;
use App\Models\SubroomsList as SubroomsList;
use App\Models\SubroomsListDetails as SubroomsListDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonAreaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        $building_list              =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_name',$company_id)
                                    ->get(['id','building_no','building_name']);

        //===================Building==========================================

        $building_arr=array();
        foreach ($building_list as $key => $value) {
            $building_arr[$value->id]=$value->building_no."-".$value->building_name;
        }

        $data['building_arr']        =$building_arr;

        
        return $data;

    }


    public function CommonAreaList(Request $request)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }


        $building_list              =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_name',$company_id)
                                    ->get(['id','building_no','building_name']);

        //===================Building==========================================

        $building_arr=array();
        foreach ($building_list as $key => $value) {
            $building_arr[$value->id]=$value->building_no."-".$value->building_name;
        }

        $floor_list              =Floor::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_name',$company_id)
                                    ->get(['id','floor_name']);

        //===================Building==========================================

        $floor_arr=array();
        foreach ($floor_list as $key => $value) {
            $floor_arr[$value->id]=$value->floor_name;
        }

        //===================Building==========================================
       
        $uom_arr=array(1=>'Square Feet',2=>'Square Meter',3=>'Square Yard');

        $sl=0;
        $common_area_list=CommonArea::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->where('company_name',$company_id)
                                        ->get();

        foreach ($common_area_list as $key => $value) {

            $data['common_area_list'][$key]['sl']                   =$sl+1;
            $data['common_area_list'][$key]['id']                   =$value->id;
            $data['common_area_list'][$key]['system_no']            =$value->system_no;
            $data['common_area_list'][$key]['property_name']        =$value->property_name;
            
            $data['common_area_list'][$key]['uom_string']           =$uom_arr[$value->single_subroom_uom];
            $data['common_area_list'][$key]['total_size_qty']       =$value->total_size_qty;

        

            if($value->building_name>0)
            {
                $data['common_area_list'][$key]['building_name']     =$building_arr[$value->building_name];

            }
            else
            {
                $data['common_area_list'][$key]['building_name']      ="";

            }

            if($value->floor_no>0)
            {
                $data['common_area_list'][$key]['floor_no']     =$floor_arr[$value->floor_no];

            }
            else
            {
                $data['common_area_list'][$key]['floor_no']      ="";

            }

            
            $sl++;

        }
        
        return $data;

    }


    public function FloorDataByBuilding($building_id)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;

        $floor_list                 =DB::table('floors as mst')
                                        ->join('building_property_details as dtls','mst.floor_no','=','dtls.id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.master_id', '=', $building_id)
                                        ->where('dtls.total_common_area', '>', 0)
                                        ->get(['dtls.floor_no','dtls.floor_type','dtls.total_common_area','mst.id','mst.floor_name']);
       
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {

            $floor_arr[$value->id]['floor_name']                =$value->floor_name;
            $floor_arr[$value->id]['floor_no']                  =$value->floor_no;
            $floor_arr[$value->id]['floor_type']                =$value->floor_type;
            $floor_arr[$value->id]['total_common_area']                =$value->total_common_area;

        }

        $data['floor_arr']        =$floor_arr;

        $building_info            =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$building_id)
                                    ->get(['dependent_building','independent_building','residential','commercial','residential_commercial']);

        $data['building_info']    =$building_info;
        return $data;


    }
    public function loadCommonAreaByFloor($floor_id)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;

        $inserted_unit              =CommonArea::where('status_active',1)
                                        ->where('floor_no',$floor_id)
                                        ->first();
    
        if(empty($inserted_unit))
        {
            $subrooms_details               =SubroomsListDetails::where('status_active',1)
                                            ->where('item_type',11)
                                            ->where('master_id',$floor_id)
                                          ->get(['id','item_qty','item_name','item_id']);
            $subrooms_list_check=array();
            $subrooms_list_arr=array();
            $sl=0;
            foreach ($subrooms_details as $key => $value) {

                if($value->item_qty>1)
                {
                    for($i=1;$i<=$value->item_qty;$i++)
                    {
                        $subrooms_list_arr[$sl]['item_name']        =$value->item_name."-".str_pad($i,2,"0",STR_PAD_LEFT);
                        $subrooms_list_arr[$sl]['item_id']          =$value->item_id;
                        $subrooms_list_arr[$sl]['id']               ="";
                        $subrooms_list_arr[$sl]['details_id']       =$value->id;
                        $subrooms_list_arr[$sl]['item_size']        ="";
                        $subrooms_list_arr[$sl]['system_no']        ="";
                        $subrooms_list_arr[$sl]['property_name']    ="";
                        $subrooms_list_arr[$sl]['comments']         ="";
                        $subrooms_list_arr[$sl]['company']          =false;
                        $subrooms_list_arr[$sl]['landlord']         =false;
                        $subrooms_list_arr[$sl]['leasholder']       =false;
                        $subrooms_list_arr[$sl]['other_1']          =false;
                        $subrooms_list_arr[$sl]['other_2']          =false;
                        $subrooms_list_arr[$sl]['uom']              =1;
                        $subrooms_list_arr[$sl]['disable']          =false;

                        $sl++;
                    }
                   
                }
                else 
                {
                    $subrooms_list_arr[$sl]['item_name']        =$value->item_name;
                    $subrooms_list_arr[$sl]['item_id']          =$value->item_id;
                    $subrooms_list_arr[$sl]['id']               ="";
                    $subrooms_list_arr[$sl]['details_id']       =$value->id;
                    $subrooms_list_arr[$sl]['item_size']        ="";
                    $subrooms_list_arr[$sl]['system_no']        ="";
                    $subrooms_list_arr[$sl]['property_name']    ="";
                    $subrooms_list_arr[$sl]['comments']         ="";
                    $subrooms_list_arr[$sl]['company']          =false;
                    $subrooms_list_arr[$sl]['landlord']         =false;
                    $subrooms_list_arr[$sl]['leasholder']       =false;
                    $subrooms_list_arr[$sl]['other_1']          =false;
                    $subrooms_list_arr[$sl]['other_2']          =false;
                    $subrooms_list_arr[$sl]['uom']              =1;
                    $subrooms_list_arr[$sl]['disable']          =false;

                    $sl++;
                }

            }

            $data['subrooms_list_arr']        =$subrooms_list_arr;
            return $data;

        }   


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
            'building_name'     => 'required',
            'floor_no'          => 'required',
            'property_name'     => 'required',
            'single_subroom_uom'=> 'required',
            'total_size_qty'    => 'required',
            'strata_lot_no'     => 'required',
            
        ]);

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id'      =>$user_id]);
        $request->merge(['inserted_by'  =>$user_id]);
        $request->merge(['project_id'   =>$project_id]);
        $request->merge(['company_name' =>$company_id]);

        $subrooms_list              =SubroomsList::where('status_active',1)
                                    ->where('item_type',11)
                                    ->get(['id','suffix']);
        $subrooms_suffix_arr=array();
        foreach($subrooms_list as $value)
        {
            $subrooms_suffix_arr[$value->id]=$value->suffix;
        }


        $common_areas_prifix = DB::table('common_areas as mst')
                                    ->join('common_area_details as dtls','mst.id','=','dtls.master_id')
                                    ->where('mst.project_id', '=', $project_id)
                                    ->where('dtls.project_id', '=', $project_id)
                                    ->where('mst.building_name', '=', $request->input('building_name'))
                                    ->where('mst.status_active', '=', 1)
                                    ->where('dtls.status_active', '=', 1)
                                    ->select('dtls.item_id',DB::raw('max(dtls.system_prefix) as system_prefix'))
                                    ->groupBy('dtls.item_id')
                                    ->get();

        $common_area_prifix_arr=array();
        foreach ($common_areas_prifix as $key => $value) {
            $common_area_prifix_arr[$value->item_id]=$value->system_prefix;
        }       

        $max_system_data = CommonArea::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from common_areas 
            where building_name=".$request->input('building_name')."  and project_id=".$project_id." ) 
            and building_name=".$request->input('building_name')."  and project_id=".$project_id)->get(['system_prefix']);

               
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="COMA-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        $common_area_info= CommonArea::create($request->all());

        foreach($request->subrooms_list_arr as $key=>$details)
        {
                      
            if($details['disable']==false)
            {
                if(empty($common_area_prifix_arr[$details['item_id']]))
                {
                    $common_area_prifix_arr[$details['item_id']]=1;
                }
                else
                {
                    $common_area_prifix_arr[$details['item_id']]+=1;
                }

                $detials_system_no=$subrooms_suffix_arr[$details['item_id']]."-".str_pad($common_area_prifix_arr[$details['item_id']], 3, 0, STR_PAD_LEFT);
                $data_subrooms_list_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$common_area_info->id,
                    'item_id'                   =>$details['item_id'],
                    'details_id'                =>$details['details_id'],
                    'system_prefix'             =>$common_area_prifix_arr[$details['item_id']],
                    'system_no'                 =>$detials_system_no,
                    'property_name'             =>$details['property_name'],
                    'comments'                  =>$details['comments'],
                    'uom'                       =>$details['uom'],
                    'item_size'                 =>$details['item_size'],
                    'item_name'                 =>$details['item_name'],
                    'company'                   =>$details['company'],
                    'landlord'                  =>$details['landlord'],
                    'leasholder'                 =>$details['leasholder'],
                    'other_1'                   =>$details['other_1'],
                    'other_2'                   =>$details['other_2'],
                    'inserted_by'               =>$user_id,
                );
            }
                   
        } 

        $RId1=true;

        if($data_subrooms_list_details)
        {
            $RId1=CommonAreaDetails::insert($data_subrooms_list_details);
        }      

        if($common_area_info  && $RId1 )
        {
           DB::commit();
           return "1**$common_area_info->id**$system_no";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
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

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        $data['user_type']          =$user_type;

        $common_area=CommonArea::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$id)
                                    ->first();
        $data['common_area_arr']=$common_area;                            
        $company_id     =$common_area->company_name;
        $building_id    =$common_area->building_name;
        $floor_id       =$common_area->floor_no;

        $building_list        =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('company_name',$company_id)
                                    ->get(['id','building_no','building_name']);


        //===================Building==========================================

        $building_arr=array();
        foreach ($building_list as $key => $value) {
            $building_arr[$value->id]=$value->building_no."-".$value->building_name;
        }

        $data['building_arr']        =$building_arr;


        $floor_list                 =DB::table('floors as mst')
                                        ->join('building_property_details as dtls','mst.floor_no','=','dtls.id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.master_id', '=', $building_id)
                                        ->where('dtls.total_common_area', '>', 0)
                                        ->get(['dtls.floor_no','dtls.floor_type','dtls.total_common_area','mst.id','mst.floor_name']);
       
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {

            $floor_arr[$value->id]['floor_name']                =$value->floor_name;
            $floor_arr[$value->id]['floor_no']                  =$value->floor_no;
            $floor_arr[$value->id]['floor_type']                =$value->floor_type;
            $floor_arr[$value->id]['total_common_area']         =$value->total_common_area;

        }

        $data['floor_no_string']=$floor_arr[$floor_id]['floor_no'];
        $data['floor_type']=$floor_arr[$floor_id]['floor_type'];
        $data['total_common_area']=$floor_arr[$floor_id]['total_common_area'];

        $data['floor_arr']        =$floor_arr;

        $building_info            =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$building_id)
                                    ->get(['dependent_building','independent_building','residential','commercial','residential_commercial']);

        $data['building_info']    =$building_info;


        //===================================Subrooms Details=======================================================

        
        
    
        $subrooms_details               =CommonAreaDetails::where('status_active',1)
                                        ->where('master_id',$id)
                                        ->get();
        $subrooms_list_check=array();
        $subrooms_list_arr=array();
        $sl=0;
        foreach ($subrooms_details as $key => $value) {
            $item_name=$value->item_name;
            $subrooms_list_arr[$sl]['item_name']        =$item_name;
            $subrooms_list_arr[$sl]['item_id']          =$value->item_id;
            $subrooms_list_arr[$sl]['id']               =$value->id;
            $subrooms_list_arr[$sl]['details_id']       =$value->details_id;
            $subrooms_list_arr[$sl]['item_size']        =$value->item_size;
            $subrooms_list_arr[$sl]['system_prefix']    =$value->system_prefix;
            $subrooms_list_arr[$sl]['system_no']        =$value->system_no;
            $subrooms_list_arr[$sl]['property_name']    =$value->property_name;
            $subrooms_list_arr[$sl]['comments']         =$value->comments;
            $subrooms_list_arr[$sl]['company']          =$value->company;
            $subrooms_list_arr[$sl]['landlord']         =$value->landlord;
            $subrooms_list_arr[$sl]['leasholder']        =$value->leasholder;
            $subrooms_list_arr[$sl]['other_1']          =$value->other_1;
            $subrooms_list_arr[$sl]['other_2']          =$value->other_2;
            $subrooms_list_arr[$sl]['uom']              =$value->uom;
            $sl++;
            $subrooms_list_check[$item_name]=$item_name;

        }

        $subrooms_details               =SubroomsListDetails::where('status_active',1)
                                            ->where('item_type',11)
                                            ->where('master_id',$floor_id)
                                          ->get(['id','item_qty','item_name','item_id']);
      
        foreach ($subrooms_details as $key => $value) {

            if($value->item_qty>1)
            {
                for($i=1;$i<=$value->item_qty;$i++)
                {
                    $item_name=$value->item_name."-".str_pad($i,2,"0",STR_PAD_LEFT);
                    
                    if(!in_array($item_name,$subrooms_list_check))
                    {
                        $subrooms_list_arr[$sl]['item_name']        =$item_name;
                        $subrooms_list_arr[$sl]['item_id']          =$value->item_id;
                        $subrooms_list_arr[$sl]['id']               ="";
                        $subrooms_list_arr[$sl]['details_id']       =$value->id;
                        $subrooms_list_arr[$sl]['item_size']        ="";
                        $subrooms_list_arr[$sl]['system_no']        ="";
                        $subrooms_list_arr[$sl]['property_name']    ="";
                        $subrooms_list_arr[$sl]['comments']         ="";
                        $subrooms_list_arr[$sl]['company']          =false;
                        $subrooms_list_arr[$sl]['landlord']         =false;
                        $subrooms_list_arr[$sl]['leasholder']       =false;
                        $subrooms_list_arr[$sl]['other_1']          =false;
                        $subrooms_list_arr[$sl]['other_2']          =false;
                        $subrooms_list_arr[$sl]['uom']              =1;
                        $subrooms_list_arr[$sl]['disable']          =false;
                    }
                    $sl++;
                }
               
            }
            else 
            {
                if(!in_array($value->item_name,$subrooms_list_check))
                {
                    $subrooms_list_arr[$sl]['item_name']        =$value->item_name;
                    $subrooms_list_arr[$sl]['item_id']          =$value->item_id;
                    $subrooms_list_arr[$sl]['id']               ="";
                    $subrooms_list_arr[$sl]['details_id']       =$value->id;
                    $subrooms_list_arr[$sl]['item_size']        ="";
                    $subrooms_list_arr[$sl]['system_no']        ="";
                    $subrooms_list_arr[$sl]['property_name']    ="";
                    $subrooms_list_arr[$sl]['comments']         ="";
                    $subrooms_list_arr[$sl]['company']          =false;
                    $subrooms_list_arr[$sl]['landlord']         =false;
                    $subrooms_list_arr[$sl]['leasholder']       =false;
                    $subrooms_list_arr[$sl]['other_1']          =false;
                    $subrooms_list_arr[$sl]['other_2']          =false;
                    $subrooms_list_arr[$sl]['uom']              =1;
                    $subrooms_list_arr[$sl]['disable']          =false;
                }

                $sl++;
            }

          // $subrooms_list_check[$value->item_id]=$value->item_id;
        }

        $data['subrooms_list_arr']        =$subrooms_list_arr;

      


        return $data;

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
         request()->validate([
            'building_name'     => 'required',
            'floor_no'          => 'required',
            'property_name'     => 'required',
            'single_subroom_uom'=> 'required',
            'total_size_qty'    => 'required',
            'strata_lot_no'     => 'required',
            
        ]);

       

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);


        $subrooms_list              =SubroomsList::where('status_active',1)
                                    ->where('item_type',11)
                                    ->get(['id','suffix']);
        $subrooms_suffix_arr=array();
        foreach($subrooms_list as $value)
        {
            $subrooms_suffix_arr[$value->id]=$value->suffix;
        }


        $common_areas_prifix = DB::table('common_areas as mst')
                                    ->join('common_area_details as dtls','mst.id','=','dtls.master_id')
                                    ->where('mst.project_id', '=', $project_id)
                                    ->where('dtls.project_id', '=', $project_id)
                                    ->where('mst.building_name', '=', $request->input('building_name'))
                                    ->where('mst.status_active', '=', 1)
                                    ->where('dtls.status_active', '=', 1)
                                    ->select('dtls.item_id',DB::raw('max(dtls.system_prefix) as system_prefix'))
                                    ->groupBy('dtls.item_id')
                                    //->toSql();
                                    ->get();

        $common_area_prifix_arr=array();
        foreach ($common_areas_prifix as $key => $value) {
            $common_area_prifix_arr[$value->item_id]=$value->system_prefix;
        }

        DB::beginTransaction();
        $data_common_area= CommonArea::find($id)->update($request->all());

         foreach($request->subrooms_list_arr as $key=>$details)
        {
                      
            if($details['item_size']>0)
            {
                if($details['id']!="")
                {
                    $subrooms_list_details_update= array(
                        'property_name'             =>$details['property_name'],
                        'comments'                  =>$details['comments'],
                        'uom'                       =>$details['uom'],
                        'item_size'                 =>$details['item_size'],
                        'item_name'                 =>$details['item_name'],
                        'company'                   =>$details['company'],
                        'landlord'                  =>$details['landlord'],
                        'leasholder'                =>$details['leasholder'],
                        'other_1'                   =>$details['other_1'],
                        'other_2'                   =>$details['other_2'],
                        'updated_by'                =>$user_id,
                    );

                    $subroomData=CommonAreaDetails::where('id',"=",$details['id'])->update($subrooms_list_details_update);
                    if( !$subroomData)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }

                }
                else
                {
                    if(empty($common_area_prifix_arr[$details['item_id']]))
                    {
                        $common_area_prifix_arr[$details['item_id']]=1;
                    }
                    else
                    {
                        $common_area_prifix_arr[$details['item_id']]+=1;
                    }

                    $detials_system_no=$subrooms_suffix_arr[$details['item_id']]."-".str_pad($common_area_prifix_arr[$details['item_id']], 3, 0, STR_PAD_LEFT);
                    $data_subrooms_list_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'details_id'                =>$details['details_id'],
                        'system_prefix'             =>$common_area_prifix_arr[$details['item_id']],
                        'system_no'                 =>$detials_system_no,
                        'property_name'             =>$details['property_name'],
                        'comments'                  =>$details['comments'],
                        'uom'                       =>$details['uom'],
                        'item_size'                 =>$details['item_size'],
                        'item_name'                 =>$details['item_name'],
                        'company'                   =>$details['company'],
                        'landlord'                  =>$details['landlord'],
                        'leasholder'                 =>$details['leasholder'],
                        'other_1'                   =>$details['other_1'],
                        'other_2'                   =>$details['other_2'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
                   
        }


        $RId1=true;

        if(!empty($data_subrooms_list_details))
        {
            $RId1=CommonAreaDetails::insert($data_subrooms_list_details);
        }

        if($data_common_area  && $RId1)
        {
           DB::commit();
           return "1**$id";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        //$request->merge(['user_id' =>$user_id]);
        //$request->merge(['updated_by' =>$user_id]);
      //  $request->merge(['unit_type' =>$unit_type]);
       // $request->merge(['project_id' =>$project_id]);


        DB::beginTransaction();

        $commercial_unit_delete=CommonArea::find($id)->update(array('status_active' => 2,'updated_by' =>$user_id));
        $CommonAreaDetails_delete=CommonAreaDetails::where('master_id',$id)
                                    ->update(array('status_active' => 2,'updated_by' =>$user_id));

        
        $safety_device_delete=SafetyDeviceEquipment::where('master_id',$id)
                                    ->where('page_id',4)
                                    ->update(array('status_active' => 2,'updated_by' =>$user_id));

        $external_service_delete=ExternalServiceProvider::where('master_id',$id)
                                    ->where('page_id',4)
                                    ->update(array('status_active' => 2,'updated_by' =>$user_id));

        $building_contact_delete=BuildingContactDetails::where('master_id',$id)
                                    ->where('page_id',4)
                                    ->update(array('status_active' => 2,'updated_by' =>$user_id));


        if( $commercial_unit_delete && $CommonAreaDetails_delete && $safety_device_delete && $external_service_delete
         && $building_contact_delete)
        {
           DB::commit();
           return "1**$id";
        }
        else
        {
            DB::rollBack();
            return 10;
        }
        die;

        
    }


    public function post(Request $request,$id)
    {
        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>$request->input("posting_status"),
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=CommonArea::where('id',"=",$id)->update($update_data);

        if($buildingInfo)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }
    public function adjust(Request $request, $id)
    {
         request()->validate([
            'building_name'     => 'required',
            'floor_no'          => 'required',
            'property_name'     => 'required',
            'single_subroom_uom'=> 'required',
            'total_size_qty'    => 'required',
            'strata_lot_no'     => 'required',
            
        ]);

       

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id'          =>$user_id]);
        $request->merge(['updated_by'       =>$user_id]);
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['posting_status'   =>3]);


        $subrooms_list              =SubroomsList::where('status_active',1)
                                    ->where('item_type',11)
                                    ->get(['id','suffix']);
        $subrooms_suffix_arr=array();
        foreach($subrooms_list as $value)
        {
            $subrooms_suffix_arr[$value->id]=$value->suffix;
        }


        $common_areas_prifix = DB::table('common_areas as mst')
                                    ->join('common_area_details as dtls','mst.id','=','dtls.master_id')
                                    ->where('mst.project_id', '=', $project_id)
                                    ->where('dtls.project_id', '=', $project_id)
                                    ->where('mst.building_name', '=', $request->input('building_name'))
                                    ->where('mst.status_active', '=', 1)
                                    ->where('dtls.status_active', '=', 1)
                                    ->select('dtls.item_id',DB::raw('max(dtls.system_prefix) as system_prefix'))
                                    ->groupBy('dtls.item_id')
                                    //->toSql();
                                    ->get();

        $common_area_prifix_arr=array();
        foreach ($common_areas_prifix as $key => $value) {
            $common_area_prifix_arr[$value->item_id]=$value->system_prefix;
        }

        DB::beginTransaction();
        $data_common_area= CommonArea::find($id)->update($request->all());

        foreach($request->subrooms_list_arr as $key=>$details)
        {
                      
            if($details['item_size']>0)
            {
                if($details['id']!="")
                {
                    $subrooms_list_details_update= array(
                        'property_name'             =>$details['property_name'],
                        'comments'                  =>$details['comments'],
                        'uom'                       =>$details['uom'],
                        'item_size'                 =>$details['item_size'],
                        'item_name'                 =>$details['item_name'],
                        'company'                   =>$details['company'],
                        'landlord'                  =>$details['landlord'],
                        'leasholder'                =>$details['leasholder'],
                        'other_1'                   =>$details['other_1'],
                        'other_2'                   =>$details['other_2'],
                        'updated_by'               =>$user_id,
                    );

                    $subroomData=CommonAreaDetails::where('id',"=",$details['id'])->update($subrooms_list_details_update);
                    if( !$subroomData)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }

                }
                else
                {
                    if(empty($common_area_prifix_arr[$details['item_id']]))
                    {
                        $common_area_prifix_arr[$details['item_id']]=1;
                    }
                    else
                    {
                        $common_area_prifix_arr[$details['item_id']]+=1;
                    }

                    $detials_system_no=$subrooms_suffix_arr[$details['item_id']]."-".str_pad($common_area_prifix_arr[$details['item_id']], 3, 0, STR_PAD_LEFT);
                    $data_subrooms_list_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'details_id'                =>$details['details_id'],
                        'system_prefix'             =>$common_area_prifix_arr[$details['item_id']],
                        'system_no'                 =>$detials_system_no,
                        'property_name'             =>$details['property_name'],
                        'comments'                  =>$details['comments'],
                        'uom'                       =>$details['uom'],
                        'item_size'                 =>$details['item_size'],
                        'item_name'                 =>$details['item_name'],
                        'company'                   =>$details['company'],
                        'landlord'                  =>$details['landlord'],
                        'leasholder'                =>$details['leasholder'],
                        'other_1'                   =>$details['other_1'],
                        'other_2'                   =>$details['other_2'],
                        'inserted_by'               =>$user_id,
                    );
                }
                
            }
                   
        }


        $RId1=true;

        if(!empty($data_subrooms_list_details))
        {
            $RId1=CommonAreaDetails::insert($data_subrooms_list_details);
        }




        if($data_common_area  && $RId1)
        {
           DB::commit();
           return "1**$id";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }


    public function repost(Request $request,$id)
    {

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id; 

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return "10**200"; 
        }

        DB::beginTransaction();

        $update_data= array(
                            'posting_status'            =>4,
                            'updated_by'                =>$user_id,
                        );
      
        $buildingInfo=CommonArea::where('id',"=",$id)->update($update_data);

        if($buildingInfo)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }
}
