<?php

namespace App\Http\Controllers;

use App\Models\User as User;
use App\Models\UserPrivilege as UserPrivilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserPrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function UserPermission($menu_name)
    {
        $user_id = \Auth::user()->id;

        $user_permission=DB::table('user_privileges as a')
                            ->join('menus as b','a.main_menu_id','=','b.id')
                            ->where('b.menuRoute', '=', $menu_name)
                            ->where('b.status', '=', 1)
                            ->where('a.status_active', '=', 1)
                            ->where('a.is_deleted', '=', 0)
                            ->where('a.user_id','=',$user_id)
                            ->select('b.id','a.show_priv','a.save_priv','a.approve_priv','a.update_priv','a.delete_priv','a.post_priv','a.adjust_priv')
                            ->get();
                         
       $data['user_permission']=$user_permission;
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
            'user_id' => 'required',
            'module_id' => 'required',
        ]);

        if(empty($request->details))  { return "100**"; die; }
        $user_id = \Auth::user()->id;
        $project_id= User::find($request->input('user_id'))->project_id;
        foreach($request->details as $key=>$details)
        {
            if($details['status_active']==1 || $details['status_active']==true)
            {
                $details['status_active']=1;
                $details['is_deleted']=0;
            }
            else{

                $details['status_active']=0;
                $details['is_deleted']=1;
            }
            $data[]= array(
                'module_id'         =>$details['module_id'],
                'main_menu_id'      =>$details['main_menu_id'],
                'user_id'           =>$details['user_id'],
                'project_id'        =>$project_id,

                    
                'show_priv'         =>$details['show_priv'],
                'save_priv'         =>$details['save_priv'],
                'update_priv'       =>$details['update_priv'],
                'delete_priv'       =>$details['delete_priv'],
                'approve_priv'      =>$details['approve_priv'],
                'post_priv'         =>$details['post_priv'],
                'adjust_priv'       =>$details['adjust_priv'],
                'inserted_by'       =>$user_id,
                'status_active'     =>$details['status_active'],
                'is_deleted'        =>$details['is_deleted'],
                
            );          

        }
       
        DB::beginTransaction();
        $RID1=UserPrivilege::where('user_id', $request->user_id)
                        ->where('module_id', $request->module_id)
                        ->update(array('status_active' => 0,'is_deleted' => 1,'updated_by' => $user_id));
        $RID=UserPrivilege::insert($data);

        if($RID)
        {
           DB::commit();
           return "0**";
        }
        else
        {
            DB::rollBack();
           return "10**";
        }

        return $RId;
        return "0**";
       
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
        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'status_active' => 'required',
            'user_type' => 'required',
        ]);
        $request->merge(['password'       =>bcrypt($request->input('password'))]);

        User::find($id)->update($request->all());
        
        return ['message'=>'Update Successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return ['message'=>'User deleted'];
    }
}
