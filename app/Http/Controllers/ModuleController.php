<?php

namespace App\Http\Controllers;

use App\Models\Menu as Menu;
use App\Models\Module as Module;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function __construct( Module $module,Menu $menu )
    {
        $this->middleware('auth');
        $this->module=$module->all();
        $this->menu=$menu->all();
    }


    public function index()
    {
        return response(Module::where('status','=',1)->get()->jsonSerialize(), Response::HTTP_OK);
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'moduleName' => 'required',
            'status' => 'required',
        ]);
        $project_id = \Auth::user()->project_id;
        $request->merge(['project_id'      =>$project_id]);
        return Module::create($request->all());
       // return redirect()->route('Modules.index')
                       // ->with('success','Module created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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
            'moduleName' => 'required',
            'status' => 'required',
        ]);

        $project_id = \Auth::user()->project_id;
        $request->merge(['project_id'      =>$project_id]);
        Module::find($id)->update($request->all());
 
        return ['message'=>'update successfully'];
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Module::find($id)->update(array('status'=>'0'));;
        return ['message'=>'Module deleted'];
    }
}
