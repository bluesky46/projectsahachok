<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function indexLogin()
    {
        return view('auth.login');
    }


    // public function login(Request $request)
    // {
    //     $input = $request->all();

    //     $this->validate($request, [
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
    //         if (auth()->user()->is_admin == 1) {
    //             return redirect()->route('admin.index');
    //         } else {
    //             return redirect()->route('home');
    //         }
    //     } else {
    //         // ส่ง error ไปยัง session
    //         return redirect()->route('login')->with('error', 'Email-address and Password are wrong.');
    //     }
    // }
    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']])) {

            $user = auth()->user();

            if ($user->is_admin == 1) {
                return redirect()->route('admin.index');
            }

            if ($user->role == 'rider') {
                return redirect()->route('rider.dashboard');
            }

            return redirect()->route('home');
        }
    }


    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index.login');
    }

//     protected function authenticated(Request $request, $user)
// {
//     if ($user->is_admin == 1) {
//         return redirect('/admin');
//     }

//     if ($user->role == 'rider') {
//         return redirect('/rider');
//     }

//     return redirect('/home');
// }


}
