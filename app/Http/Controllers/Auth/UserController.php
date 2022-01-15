<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function redirectToProvider($provider)
    {
        return \Socialite::driver($provider)->redirect();
    }
    public function handleProviderCallback(\App\SocialAccountsService $accountService, $provider){
      try {
        $user = \Socialite::with($provider)->user();
    } catch (\Exception $e) {
        return redirect('/register');
    }
  $authUser = $accountService->findOrcreate(
    $user,
    $provider
  );
  auth()->register($authUser, true);
  
  return redirect('/');
}
}