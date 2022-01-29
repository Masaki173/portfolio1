<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function show($id){
        $user = User::with('posts')->findorFail($id);
        $follows_query = $user->leftjoin('follower_user', 'follower_user.user_id', '=', 'users.id')->where('follower_id', Auth::id());
        $is_followed = $follows_query->first();
        return view('users.show', compact('user', 'is_followed'));
    }
    public function form($id){
         $user = User::findorFail($id);
        return view('users.setting', compact('user'));
    }
    public function update(Request $request, $id){
        $user = User::find($id);
         $icon = $request->file('icon');
        if(!$icon){
          if($request->has('profile'){
         $user->profile = $request->profile;
          }
             if($request->has('name'){
         $user->name = $request->name;
             }
        $user->save();
           return redirect('/');
        }else{
        if($icon->isValid()){
            $filePath = $icon->store('public');
            $user->icon = str_replace('public/', '', $filePath);
        }else{
            return;
        }
             if($request->has('profile'){
             $user->profile = $request->profile;
             }
               if($request->has('name'){
         $user->name = $request->name;
               }
        $user->save();
      return redirect('/');
        }
    }
    public function Follow($id){
        $user = User::with('posts')->findorFail($id);
        auth()->user()->follows()->attach( User::find($id) );
        $follows_query = $user->leftjoin('follower_user', 'follower_user.user_id', '=', 'users.id')->where('follower_id', Auth::id());
        $is_followed = $follows_query->first();
        return view('users.show', compact('user', 'is_followed'));
    }
    public function Unfollow($id){
        $user = User::with('posts')->findorFail($id);
        auth()->user()->follows()->detach( User::find($id) );
        $follows_query = $user->leftjoin('follower_user', 'follower_user.user_id', '=', 'users.id')->where('follower_id', Auth::id());
        $is_followed = $follows_query->first();
        return view('users.show', compact('user', 'is_followed'));
    }
    public function getFollowsList($id){
        $user = User::findorFail($id);
        $follows = auth()->user()->follows()->get();
        return view('users.follows', compact('follows'));
    }
}
