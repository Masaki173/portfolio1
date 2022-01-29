@extends('layouts.app')

@section('content')
<div class="userpost">
  <div class="category">
  <a href="/">すべて</a>
  <a href="/category/trend">人気</a>
  <a href="/categories/1">生活</a>
  <a href="/categories/2">社会</a>
  <a href="/categories/3">カルチャー</a>
  <a href="/categories/4">テクノロジー</a>
  <a href="/categories/5">エンタメ</a>
</div>
@if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
@endif
@foreach ($items as $item)
<table>
<tr><th><a href="/posts/{{$item->id}}">{{$item->title}}</a></th></tr>
@auth
@if(Auth::user()->id !== $item->user->id && $item->is_fee === 1 && !$item->is_subscribed_by_auth_user())
<tr><td><p class="restricted-content">{{Str::limit($item->content, 60,'...')}}</p></td></tr>
<p>この記事は有料記事です</p>
@else
<tr><td><p>{{Str::limit($item->content, 60,'...')}}</p></td></tr>
@endif
@else
@if($item->is_fee === 1)
<tr><td><p class="restricted-content">{{Str::limit($item->content, 60,'...')}}</p></td></tr>
<p>この記事は有料記事です</p>
@else
<tr><td><p>{{Str::limit($item->content, 60,'...')}}</p></td></tr>
@endif
@endauth
<tr>
<td>
 @if($item->category_code === 1)
 <a href="/{{$item->category_code}}">生活</a>
 @elseif($item->category_code === 2)
 <a href="/{{$item->category_code}}">社会</a>
 @elseif($item->category_code === 3)
 <a href="/{{$item->category_code}}">カルチャー</a>
 @elseif($item->category_code === 4)
 <a href="/{{$item->category_code}}">テクノロジー</a>
 @elseif($item->category_code === 5)
 <a href="/{{$item->category_code}}">エンタメ</a>
 @endif
 </td>
</tr>
<tr>
<td>
  <a href="users/{{$item->user->id}}"><img src="{{ Storage::url($item->user->icon)}}"  width="35px" height="35px">{{$item->user->name}}</a>
</td>
</tr>
</table>
@endforeach
</div>
@endsection


