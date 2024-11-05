<?php

namespace App\Http\Controllers;

use App\Classes\ArrayFunction as ArrayFunction;
use App\Models\ProcedureInstruction as ProcedureInstruction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcedureInstructionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=\Auth::user();
        
        $project_id                 = $user->project_id;
        $ArrayFunction              =new ArrayFunction();
        $rules_policy_arr           =$ArrayFunction->rules_policy_arr;

        $data['prepared_by']        =$user->name;

        $data['rules_policy_arr']=$rules_policy_arr;

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
            'issued_date'                       => 'required',
            'audience'                          => 'required',      
            'subject'                           => 'required',
            'procedure_instruction_description' => 'required',
            
        ]);

        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['inserted_by'              =>$user_id]);
        $request->merge(['page_id'                  =>4]);
        $request->merge(['project_id'               =>$project_id]);

        if($request->input('issued_date'))
        {
            $issued_date                               =date("Y-m-d",strtotime($request->input('issued_date')));
            $request->merge(['issued_date'             =>$issued_date]);
        }


        $current_year=date('Y');

        $max_system_data = ProcedureInstruction::whereRaw('system_prefix=(select max(system_prefix) as system_prefix from 
            procedure_instructions where project_id='.$project_id.' ) and project_id='.$project_id)->get(['system_prefix']);
        //dd($max_system_data);die;
        if(count($max_system_data)>0)
        {
            $max_system_prefix=$max_system_data[0]->system_prefix+1; 
        }
        else
        {
            $max_system_prefix=1; 
        }

        $system_no="Proc-".str_pad($max_system_prefix, 4, 0, STR_PAD_LEFT);
        $request->merge(['system_no'               =>$system_no]);
        $request->merge(['system_prefix'           =>$max_system_prefix]);

        DB::beginTransaction();
        
        $Procedure_insert=ProcedureInstruction::create($request->all());

        if( $Procedure_insert)
        {
           DB::commit();
           return "1**$Procedure_insert->id**$system_no";
        }
        else
        {
            DB::rollBack();
            return 10;
        }
        die;
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
        $ArrayFunction              =new ArrayFunction();
        $rules_policy_arr           =$ArrayFunction->rules_policy_arr;

        $data['rules_policy_arr']=$rules_policy_arr;


        $procedure_instruction_data=ProcedureInstruction::where('status_active',1)
                                    ->where('id',$id)
                                    ->get();

        $data['prepared_by']        =$procedure_instruction_data[0]->user->name;
        $data['updated_at']         =date("D M ,Y g:i a",strtotime($procedure_instruction_data[0]->updated_at));
        $data['created_at']         =date("D M ,Y g:i a",strtotime($procedure_instruction_data[0]->created_at));
        //dd( $data['prepared_by']);
        $data['procedure_instruction_data']  =$procedure_instruction_data;

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
            'issued_date'                       => 'required',
            'audience'                          => 'required',      
            'subject'                           => 'required',
            'procedure_instruction_description' => 'required',
            
        ]);

        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        $project_id                                 =$user_data->project_id;
        $request->merge(['updated_by'              =>$user_id]);
        $request->merge(['page_id'                  =>4]);
        $request->merge(['project_id'               =>$project_id]);

        if($request->input('issued_date'))
        {
            $issued_date                               =date("Y-m-d",strtotime($request->input('issued_date')));
            $request->merge(['issued_date'             =>$issued_date]);
        }

        

        DB::beginTransaction();
        
        $Procedure_update=true;
        $Procedure_update=ProcedureInstruction::find($id)->update($request->all());

        if( $Procedure_update)
        {
           DB::commit();
           return "1**$id**";
        }
        else
        {
            DB::rollBack();
            return 10;
        }
        die;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_data                                  = \Auth::user();
        $user_id                                    =$user_data->id;
        DB::beginTransaction();
       
        $Procedure_update=true;
        $Procedure_update=ProcedureInstruction::find($id)->update(['status_active'=>2,'updated_by'=>$user_id]);


        if( $Procedure_update)
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
}
