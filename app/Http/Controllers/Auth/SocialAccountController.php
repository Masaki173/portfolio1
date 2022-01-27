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
            $user = \Socialite::with($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        $authUser = $accountService->findOrCreate(
            $user,
            $user->getEmail(),
            $provider
        );

        auth()->login($authUser, true);

        return redirect('/');
    }
}
