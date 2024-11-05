<?php

namespace App\Http\Controllers;

use App\Models\BuildingInfo as BuildingInfo;
use App\Models\Floor as Floor;
use App\Models\MailBox;
use App\Models\MailRoom;
use App\Models\SubroomsListDetails as SubroomsListDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MailRoomController extends Controller
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
        //===================Company==========================================
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return  20;
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


    public function MailRoomLits( request $request)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return  20;
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

      

        //===================Building==========================================
        $floor_list              =Floor::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->get(['id','floor_name']);

        //===================Building==========================================

        $floor_arr=array();
        foreach ($floor_list as $key => $value) {
            $floor_arr[$value->id]=$value->floor_name;
        }
       
        $uom_arr=array(1=>'Square Feet',2=>'Square Meter',3=>'Square Yard');

        $sl=0;
        $mail_room_list=MailRoom::where('status_active',1)
                                        ->where('project_id',$project_id)
                                        ->get();



        foreach ($mail_room_list as $key => $value) {

            $data['mail_room_list'][$key]['sl']                  =$sl+1;
            $data['mail_room_list'][$key]['id']                  =$value->id;
            $data['mail_room_list'][$key]['system_no']           =$value->system_no;
            $data['mail_room_list'][$key]['property_name']       =$value->property_name;
            
            $data['mail_room_list'][$key]['room_uom_string']     =$uom_arr[$value->room_uom];
            $data['mail_room_list'][$key]['room_uom']            =$value->room_uom;

            $data['mail_room_list'][$key]['mailroom_size_qty']   =$value->mailroom_size_qty;
            $data['mail_room_list'][$key]['room_no']             =$value->room_no;
            $data['mail_room_list'][$key]['room_name']           =$value->room_name;
           

            if($value->building_name>0)
            {
                $data['mail_room_list'][$key]['building_name']     =$building_arr[$value->building_name];

            }
            else
            {
                $data['mail_room_list'][$key]['building_name']      ="";

            }

            if($value->floor_no>0)
            {
                $data['mail_room_list'][$key]['floor_no']     =$floor_arr[$value->floor_no];

            }
            else
            {
                $data['mail_room_list'][$key]['floor_no']      ="";

            }

            
            $sl++;

        }

        if(empty($mail_room_list)) $data['mail_room_list']=array();
        
        return $data;

    }


    public function MailRoomFloorByBuilding($building_id)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;

        $floor_list                 =DB::table('floors as mst')
                                        ->join('building_property_details as dtls','mst.floor_no','=','dtls.id')
                                        ->where('mst.project_id', '=', $project_id)
                                        ->where('dtls.project_id', '=', $project_id)
                                        ->where('mst.building_name', '=', $building_id)
                                        ->where('dtls.master_id', '=', $building_id)
                                        ->where('dtls.total_mailroom', '>', 0)
                                        ->get(['dtls.floor_no','dtls.floor_type','dtls.total_mailroom','mst.id','mst.floor_name']);
       
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {

            $floor_arr[$value->id]['floor_name']                =$value->floor_name;
            $floor_arr[$value->id]['floor_no']                  =$value->floor_no;
            $floor_arr[$value->id]['floor_type']                =$value->floor_type;
            $floor_arr[$value->id]['total_mailroom']            =$value->total_mailroom;

        }

        $data['floor_arr']        =$floor_arr;

        $building_info            =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$building_id)
                                    ->get(['dependent_building','independent_building','residential','commercial','residential_commercial']);

        $data['building_info']    =$building_info;
        return $data;


    }
    public function loadMailBoxByFloor($floor_id,$room_no)
    {
        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $inserted_mail_room         ="";

        $inserted_mail_room         =MailRoom::where('status_active',1)
                                        ->where('floor_no',$floor_id)
                                        ->get();
                                       // dd($inserted_mail_room);die;
    
        $subrooms_list_check=array();
        $subrooms_list_arr=array();
        $total_mail_box=0;
        $sl=0;
 
        $subrooms_details               =SubroomsListDetails::where('status_active',1)
                                        ->where('item_type',6)
                                        ->where('master_id',$floor_id)
                                        ->where('property_no',$room_no)
                                        ->get(['id','item_qty','item_name','item_id']);

        foreach ($subrooms_details as $key => $value) {
            $total_mail_box=$value->item_qty;
            if($value->item_qty>1)
            {
                for($i=1;$i<=$value->item_qty;$i++)
                {
                    $subrooms_list_arr[$sl]['item_name']     =$value->item_name."-".str_pad($i,2,"0",STR_PAD_LEFT);
                    $subrooms_list_arr[$sl]['item_id']       =$value->item_id;
                    $subrooms_list_arr[$sl]['comments']      =$value->comments;
                    $subrooms_list_arr[$sl]['id']            ="";
                    $subrooms_list_arr[$sl]['property_name'] ="";
                    $subrooms_list_arr[$sl]['details_id']    =$value->id;
                    $subrooms_list_arr[$sl]['item_size']     ="";
                    $subrooms_list_arr[$sl]['disable']       =false;
                    $subrooms_list_arr[$sl]['uom']           =1;
                    $sl++;
                }
            }
            else 
            {
                $subrooms_list_arr[$sl]['item_name']     =$value->item_name;
                $subrooms_list_arr[$sl]['comments']      =$value->comments;
                $subrooms_list_arr[$sl]['item_id']       =$value->item_id;
                $subrooms_list_arr[$sl]['id']            ="";
                $subrooms_list_arr[$sl]['property_name'] ="";
                $subrooms_list_arr[$sl]['details_id']    =$value->id;
                $subrooms_list_arr[$sl]['item_size']     ="";
                $subrooms_list_arr[$sl]['disable']       =false;
                $subrooms_list_arr[$sl]['uom']           =1;
                $sl++;
            }

            $subrooms_list_check[$value->item_id]=$value->item_id;
        }
          

        $data['total_mail_box']        =$total_mail_box;
        $data['subrooms_list_arr']     =$subrooms_list_arr;
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
        request()->validate([
            'building_name'         => 'required',
            'floor_no'              => 'required',
            'property_name'         => 'required',
            'room_no'               => 'required',
            'room_name'             => 'required',
            'room_uom'              => 'required',
            'mailroom_size_qty'     => 'required',
            'strata_lot_no'         => 'required',
        ]);

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return  20;
        }

        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id'          =>$user_id]);
        $request->merge(['inserted_by'      =>$user_id]);
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['company_name'     =>$company_id]);

        $max_system_data = MailRoom::whereRaw("system_prefix=(select max(system_prefix) as system_prefix from mail_rooms 
            where building_name=".$request->input('building_name')."  and project_id=".$project_id." ) 
            and building_name=".$request->input('building_name')."  and project_id=".$project_id)->get(['system_prefix']);
               // ->toSql(); and floor_no=".$request->input('floor_no')."

               
       // dd($max_system_data);die;
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="MLR-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        //dd($max_system_prefix);die;
        DB::beginTransaction();
        $mailroom_info= MailRoom::create($request->all());


       // dd($mailroom_info);die;
        $max_mailbox_prefix=1;
        foreach($request->subrooms_list_arr as $key=>$details)
        {
                      
            if($details['disable']==false)
            {
                $mailbox_system_no="MLB-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT).str_pad($max_mailbox_prefix, 4, 0, STR_PAD_LEFT);
                $data_subrooms_list_details[]= array(
                    'project_id'                =>$project_id,
                    'master_id'                 =>$mailroom_info->id,
                    'system_prefix'             =>$max_mailbox_prefix,
                    'system_no'                 =>$mailbox_system_no,
                    'item_id'                   =>$details['item_id'],
                    'details_id'                =>$details['details_id'],
                    'uom'                       =>$details['uom'],
                    'item_size'                 =>$details['item_size'],
                    'item_name'                 =>$details['item_name'],
                    'property_name'             =>$details['property_name'],
                    'comments'                  =>$details['comments'],
                    'inserted_by'               =>$user_id,
                );
                $max_mailbox_prefix++;
            }
                   
        } 
       // dd($data_subrooms_list_details);

       


        if($data_subrooms_list_details)
        {
            $RId1=MailBox::insert($data_subrooms_list_details);
        }


       

        if($mailroom_info  && $RId1 )
        {
           DB::commit();
           return "1**$mailroom_info->id**$system_no";
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
    public function edit($id, Request $request)
    {

        $user=\Auth::user();
        $project_id                 = $user->project_id;
        $user_type                  = $user->user_type;
        $data['user_type']          =$user_type;

        if($request->session()->has('company_avaibale'))
        {
            $company_id=$request->session()->get('company_id');
        }
        else {

            return  20;
        }
        

        $mail_room=MailRoom::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$id)
                                    ->first();
        $data['mail_room_arr']=$mail_room;                            
        $company_id     =$mail_room->company_name;
        $customer_id    =$mail_room->customer_name;
        $building_id    =$mail_room->building_name;
        $floor_id       =$mail_room->floor_no;
        $mail_room_id   =$mail_room->id;

        

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
                                        ->where('dtls.total_mailroom', '>', 0)
                                        ->get(['dtls.floor_no','dtls.floor_type','dtls.total_mailroom','mst.id','mst.floor_name']);
       
        $floor_arr=array();
        foreach ($floor_list as $key => $value) {

            $floor_arr[$value->id]['floor_name']                =$value->floor_name;
            $floor_arr[$value->id]['floor_no']                  =$value->floor_no;
            $floor_arr[$value->id]['floor_type']                =$value->floor_type;
            $floor_arr[$value->id]['total_mailroom']                =$value->total_mailroom;

        }

        $data['floor_no_string']=$floor_arr[$floor_id]['floor_no'];
        $data['floor_type']=$floor_arr[$floor_id]['floor_type'];
        $data['total_mailroom']=$floor_arr[$floor_id]['total_mailroom'];

        //dd($floor_arr[8]['floor_type']);

        $data['floor_arr']        =$floor_arr;

        $building_info            =BuildingInfo::where('status_active',1)
                                    ->where('project_id',$project_id)
                                    ->where('id',$building_id)
                                    ->get(['dependent_building','independent_building','residential','commercial','residential_commercial']);

        $data['building_info']    =$building_info;


        //===================================Subrooms Details=======================================================

        
        
    
        $subrooms_details               =MailBox::where('status_active',1)
                                        ->where('master_id',$id)
                                        ->get();
        $subrooms_list_check=array();
        $subrooms_list_arr=array();
        $sl=0;$total_mail_box=0;
        foreach ($subrooms_details as $key => $value) {

            
            $subrooms_list_arr[$sl]['item_name']     =$value->item_name;
            $subrooms_list_arr[$sl]['item_id']       =$value->item_id;
            $subrooms_list_arr[$sl]['id']            =$value->id;
            $subrooms_list_arr[$sl]['details_id']    =$value->details_id;
            $subrooms_list_arr[$sl]['item_size']     =$value->item_size;
            $subrooms_list_arr[$sl]['disable']       =false;
            $subrooms_list_arr[$sl]['property_name'] =$value->property_name;
            $subrooms_list_arr[$sl]['uom']           =$value->uom;
            $subrooms_list_arr[$sl]['comments']      =$value->comments;
            $sl++;
            $total_mail_box++;
        }
        
        $data['total_mail_box']             =$total_mail_box;
        $data['subrooms_list_arr']          =$subrooms_list_arr;

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
            'building_name'         => 'required',
            'floor_no'              => 'required',
            'property_name'         => 'required',
            'room_no'               => 'required',
            'room_name'             => 'required',
            'room_uom'              => 'required',
            'mailroom_size_qty'     => 'required',
            'strata_lot_no'     => 'required',
        ]);

        


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id' =>$user_id]);
        $request->merge(['updated_by' =>$user_id]);
        $request->merge(['project_id' =>$project_id]);

        $max_mailbox_prefix_sql     =MailBox::where('status_active',1)
                                        ->where('master_id',$id)
                                        ->select(DB::raw('Max(system_prefix) as max_system_prefix'))
                                        ->get();

        $max_system_prefix=$request->input('system_prefix');
        $max_mailbox_prefix=$max_mailbox_prefix_sql[0]->max_system_prefix;

        DB::beginTransaction();
        $data_mail_room= MailRoom::find($id)->update($request->all());
        $data_subrooms_list_details="";
        foreach($request->subrooms_list_arr as $key=>$details)
        {
                      
            if($details['disable']==false)
            {
                if($details['id']!="")
                {
                    $subrooms_list_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'details_id'                =>$details['details_id'],
                        'uom'                       =>$details['uom'],
                        'item_size'                 =>$details['item_size'],
                        'item_name'                 =>$details['item_name'],
                        'property_name'             =>$details['property_name'],
                        'comments'                  =>$details['comments'],
                        'updated_by'                =>$user_id,
                    );

                    $subroomData=MailBox::where('id',"=",$details['id'])->update($subrooms_list_details_data);
                    if( !$subroomData)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $max_mailbox_prefix++;
                    $mailbox_system_no="MLB-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT).str_pad($max_mailbox_prefix, 4, 0, STR_PAD_LEFT);
                    $data_subrooms_list_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$mailroom_info->id,
                        'system_prefix'             =>$max_mailbox_prefix,
                        'system_no'                 =>$mailbox_system_no,
                        'item_id'                   =>$details['item_id'],
                        'details_id'                =>$details['details_id'],
                        'uom'                       =>$details['uom'],
                        'item_size'                 =>$details['item_size'],
                        'item_name'                 =>$details['item_name'],
                        'property_name'             =>$details['property_name'],
                        'comments'                  =>$details['comments'],
                        'inserted_by'               =>$user_id,
                    );
                   // $max_mailbox_prefix++;
                }
            }
                   
        } 


        $RId1=true;
        $RId2=true;
        if(!empty($data_subrooms_list_details))
        {
            $RId1=MailBox::insert($data_subrooms_list_details);
        }
        if($data_mail_room  && $RId1)
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
        


        DB::beginTransaction();

        $mail_room_delete=MailRoom::find($id)->update(array('status_active' => 2,'is_deleted' => 1,'updated_by' =>$user_id));
        $mail_box_delete=MailBox::where('master_id',$id)
                                    ->update(array('status_active' => 2,'is_deleted' => 1,'updated_by' =>$user_id));


        if( $mail_room_delete && $mail_box_delete )
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
      
        $buildingInfo=MailRoom::where('id',"=",$id)->update($update_data);

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
            'building_name'         => 'required',
            'floor_no'              => 'required',
            'property_name'         => 'required',
            'room_no'               => 'required',
            'room_name'             => 'required',
            'room_uom'              => 'required',
            'mailroom_size_qty'     => 'required',
            'strata_lot_no'     => 'required',
        ]);

        


        $user_data = \Auth::user();
        $user_id=$user_data->id;
        $project_id=$user_data->project_id;
        $request->merge(['user_id'          =>$user_id]);
        $request->merge(['updated_by'       =>$user_id]);
        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['posting_status'   =>3]);

        $max_mailbox_prefix_sql     =MailBox::where('status_active',1)
                                        ->where('master_id',$id)
                                        ->select(DB::raw('Max(system_prefix) as max_system_prefix'))
                                        ->get();

        $max_system_prefix=$request->input('system_prefix');
        $max_mailbox_prefix=$max_mailbox_prefix_sql[0]->max_system_prefix;

        DB::beginTransaction();
        $data_mail_room= MailRoom::find($id)->update($request->all());
        $data_subrooms_list_details="";
        foreach($request->subrooms_list_arr as $key=>$details)
        {
                      
            if($details['disable']==false)
            {
                if($details['id']!="")
                {
                    $subrooms_list_details_data= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$id,
                        'item_id'                   =>$details['item_id'],
                        'details_id'                =>$details['details_id'],
                        'uom'                       =>$details['uom'],
                        'item_size'                 =>$details['item_size'],
                        'item_name'                 =>$details['item_name'],
                        'property_name'             =>$details['property_name'],
                        'comments'                  =>$details['comments'],
                        'updated_by'                =>$user_id,
                    );

                    $subroomData=MailBox::where('id',"=",$details['id'])->update($subrooms_list_details_data);
                    if( !$subroomData)
                    {
                        DB::rollBack();
                        return 10;
                        die;
                    }
                }
                else
                {
                    $max_mailbox_prefix++;
                    $mailbox_system_no="MLB-".str_pad($max_system_prefix, 3, 0, STR_PAD_LEFT).str_pad($max_mailbox_prefix, 4, 0, STR_PAD_LEFT);
                    $data_subrooms_list_details[]= array(
                        'project_id'                =>$project_id,
                        'master_id'                 =>$mailroom_info->id,
                        'system_prefix'             =>$max_mailbox_prefix,
                        'system_no'                 =>$mailbox_system_no,
                        'item_id'                   =>$details['item_id'],
                        'details_id'                =>$details['details_id'],
                        'uom'                       =>$details['uom'],
                        'item_size'                 =>$details['item_size'],
                        'item_name'                 =>$details['item_name'],
                        'property_name'             =>$details['property_name'],
                        'comments'                  =>$details['comments'],
                        'inserted_by'               =>$user_id,
                    );
                }
            }
                   
        } 


        $RId1=true;
        $RId2=true;
        if(!empty($data_subrooms_list_details))
        {
            $RId1=MailBox::insert($data_subrooms_list_details);
        }
        if($data_mail_room  && $RId1)
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
      
        $buildingInfo=MailRoom::where('id',"=",$id)->update($update_data);

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
