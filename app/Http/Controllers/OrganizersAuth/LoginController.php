<?php

namespace App\Http\Controllers\OrganizersAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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
    protected $redirectTo = '/organizers';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:organizers')->except('logout');

    }
    public function showLoginForm()
    {
        return view('organizersauth.login');
    }
    // public function login()
    // {
    //     return redirect('/organizers');
    // }
    public function organizersLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        if (Auth::guard('organizers')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/organizers');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
}
