@extends('layouts.app')
@section('content')
<div class="contents">
<h1 class="username"><img src="{{ Storage::url($user->icon)}}"  class="rounded-circle" width="40px" height="40px">{{$user->name}}</h1>
<p class="profile">{{$user->profile}}</p>
@auth
@if ($user->id === Auth::user()->id)
<form action="{{$user->id}}/form" class="user-setting">
  @csrf
  <button type=submit>設定</button>
 </form>
 @else
 @if(!$is_followed)
 <form action="{{ route('follow.user', $user->id) }}" method="post" class="user-setting">
   @csrf
   <button type=submit>フォロー</button>
</form>
@else
 <form action="{{ route('unfollow.user', $user->id) }}" method="post" class="user-setting">
   @csrf
   <button type=submit>フォロー中</button>
</form>
@endif
 @endif
 @endauth
 <div class="show-posts">
@foreach ($user->posts as $post)
<table class="userspost">
<tr><th><a href="/posts/{{$post->id}}">{{Str::limit($post->title, 60,'...')}}</a></th></tr>
@if($post->is_fee === 1)
<tr><td align="left"><p class="post-price">￥{{$post->price}}</p></td></tr>
@endif
@auth
  @if ($post->user_id === Auth::user()->id)
<tr>
<td>
<form action="/posts/del/{{$post->id}}" method="post">
 @method('delete')
 @csrf
  <input type="hidden" name="id">
  <button class="delete-post">削除する</button>
</form>
</td>
</tr>
<tr>
<td>
<form action="/posts/edit/{{$post->id}}" method="get">
 @csrf
  <input type="hidden" name="id">
  <button class="edit-button">編集する</button>
</form>
</td>
</tr>
@endif
@endauth
</table>
@endforeach
</div>
</div>
@endsection
