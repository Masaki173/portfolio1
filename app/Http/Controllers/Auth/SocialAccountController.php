<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialAccountController extends Controller
{
    public function redirectToProvider($provider)
    {
        return \Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(\App\SocialAccountService $accountService, $provider)
    {

        try {
            $userSocial = \Socialite::with($provider)->user();
            $user = User::where(['email' => $userSocial->getEmail()])->first();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        $authUser = $accountService->findOrCreate(
            $user,
            $provider
        );

        auth()->login($authUser, true);

        return redirect('/');
    }
}
