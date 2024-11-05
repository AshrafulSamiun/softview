<?php

namespace App\Http\Controllers;
use App\Models\FileUpload;
use App\Models\Project as Project;
use App\Models\UserCompany as userCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class UserCompanyController extends Controller
{
    public function store(Request $request)
    {


    	request()->validate([
            'legal_name' => 'required',
            'operational_name' => 'required',
            'jurisdiction_of_incorporation' => 'required',
            'incorporation_number' => 'required',
            //'company_logo' => 'required',
            'website' => 'required',
        ]);
//echo "sdfsdfsdf";die;
    	$user_info 	= \Auth::user();
    	$project_id = $user_info->project_id;
    	$user_id 	= $user_info->id;
        $request->merge(['project_id'      	=>$project_id]);
        $request->merge(['user_id'      	=>$user_id]);
        $legal_name 	=$request->input('legal_name');

        DB::beginTransaction();

        if($request->file('company_logo_url'))
        {
            // insert    
            $image =$request->file('company_logo_url');
            $extention=$image->extension();
            //dd($image->extension());die;
            $name = "company_logo_".$project_id."_".time().".".$extention;
            Image::make($request->file('company_logo_url'))->save(public_path('image/account_company_logo/').$name);
            $image_arr= new FileUpload();
            $image_arr->image_name = $name;
            // print_r($image_arr);die;
            $image_arr->save();
           // $company_logo=$image_arr->id; 
            $request->merge(['company_logo'     =>$image_arr->id]);  
        }

        $user_company_info= UserCompany::create($request->all());


        $user_project=Project::find($project_id)->update(array('project_name' => $legal_name,'project_status' => '99'));

        if($user_company_info  && $user_project)
        {
           DB::commit();
           return redirect()->route('dashboard');
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'legal_name' => 'required',
            'operational_name' => 'required',
            'jurisdiction_of_incorporation' => 'required',
            'incorporation_number' => 'required',
            //'company_logo' => 'required',
            'website' => 'required',
        ]);

        $user_info  = \Auth::user();
        $project_id = $user_info->project_id;
        $user_id    = $user_info->id;
        
    	//dd($request->company_logo_url['originalName']);die;

    	

        DB::beginTransaction();


        $request->merge(['project_id'       =>$project_id]);
        $request->merge(['updated_by'       =>$user_id]);
        $legal_name     =$request->input('legal_name');
        $company_logo="";
      //  dd($request->input('company_logo_url'));die;
        if($request->file('company_logo_url') &&  $request->input('company_logo'))
        {
            // for update    
            $image =$request->file('company_logo_url');
            $extention=$image->extension();
            //dd($image->extension());die;
            $name = "company_logo_".$project_id."_".time().".".$extention;
            Image::make($request->file('company_logo_url'))->save(public_path('image/account_company_logo/').$name);

            $image_upload=FileUpload::where('id',$request->input('company_logo'))->update(['image_name'=>$name]);
          
            //$request->merge(['company_logo'     =>$company_logo]);  
        }
        else if($request->file('company_logo_url') &&  !$request->input('company_logo'))
        {
            // insert    
            $image =$request->file('company_logo_url');
            $extention=$image->extension();
            //dd($image->extension());die;
            $name = "company_logo_".$project_id."_".time().".".$extention;
            Image::make($request->file('company_logo_url'))->save(public_path('image/account_company_logo/').$name);
            $image_arr= new FileUpload();
            $image_arr->image_name = $name;
            // print_r($image_arr);die;
            $image_arr->save();
           // $company_logo=$image_arr->id; 
            $request->merge(['company_logo'     =>$image_arr->id]);  
        }
        

       

        $user_company_info= UserCompany::find($id)->update($request->all());

        $user_project=Project::find($project_id)->update(array('project_name' => $legal_name));

        if($user_company_info  && $user_project)
        {
           DB::commit();
           return redirect()->route('dashboard');
        }
        else
        {
            DB::rollBack();
            return back()->withInput();
        }
        

    }
}
