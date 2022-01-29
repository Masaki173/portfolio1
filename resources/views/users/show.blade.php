@extends('layouts.app')
@section('content')
<h1 class="username"><img src="{{ Storage::url($user->icon)}}" width="40px" height="40px">{{$user->name}}</h1>
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
 <table class="users-post">
<tr><th><a href="/posts/{{$post->id}}">{{$post->title}}</a></th></tr>
<tr><td><p>{{Str::limit($post->content, 60,'...')}}</p></td></tr>
<tr>
<td>
@auth
  @if ($post->user_id === Auth::user()->id)
<form action="/posts/del/{{$post->id}}" method="post">
 @method('delete')
 @csrf
  <input type="hidden" name="id">
  <button class="delete-post">削除する</button>
</form>
@endif
@endauth
</td>
</tr>
</table>
@endforeach
</div>
@endsection
