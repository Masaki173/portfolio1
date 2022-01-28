<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();

    }
    public function handleProviderCallback($social)
    {
        $userSocial = Socialite::driver($social)->stateless()->user();

        $user = User::where(['email' => $userSocial->getEmail()])->first();

        if($user){

            Auth::login($user);
            return redirect('/home');

        }else{

            $newuser = User::create([
            'name' = $userSocial->getName(),
            'email' = $userSocial->getEmail(),
        ]);


            Auth::login($newuser);
            return redirect('/home');

        }
    }
}
