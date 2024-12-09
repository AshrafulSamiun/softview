<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendMessageController extends Controller
{
    public function getVerify()
    {
    	return view('message.verify');
    }


    public function postVerity(Request $request)
    {
    	$user=User::where('two_factor_code',$request->code)->first();
    	if($user){
    		$user->status_active=1;
    		$user->two_factor_code=null;
    		$user->save();
    		return redirect()->route('login')->withMessage('Your Account is Active.')
    	}

    	return back()->withMessage('Verify Code is not correct.Please Try Again.')

    }
}
