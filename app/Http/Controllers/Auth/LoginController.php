<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/Dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     public function logout(Request $request) {
      Auth::logout();
      $request->session()->invalidate();
      return redirect('/login');
    }


    protected function authenticated(Request $request,$user)
    {
        if($request->pin_code==$user->pin_code)
        {
            $user->generateTwoFactorCode();
            $user->notify(new twoFactorCode());
            return redirect("/verify"); 
        }
        else
        {
            Auth::logout();
            $request->session()->invalidate();
            return redirect('/login')->withErrors(['pin_code' => 'Pin Code which you enter does not match']);
        }
    }
}
