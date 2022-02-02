@extends('layouts.app')
@section('content')
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
<h1 class="title">{!! nl2br(e($post->title))!!}</h1>
@if($post->category_code === 1)
<a href="/categories/{{$post->category_code}}" class="category-url">生活</a>
@elseif($post->category_code === 2)
<a href="/categories/{{$post->category_code}}" class="category-url">社会</a>
@elseif($post->category_code === 3)
<a href="/categories/{{$post->category_code}}" class="category-url">カルチャー</a>
@elseif($post->category_code === 4)
<a href="/categories/{{$post->category_code}}" class="category-url">テクノロジー</a>
@elseif($post->category_code === 5)
<a href="/categories/{{$post->category_code}}" class="category-url">エンタメ</a>
@endif
<div class="icon-wrapper"><a href="/users/{{$post->user->id}}"><img src="{{ Storage::url($post->user->icon)}}"  width="35px" height="35px">{{$post->user->name}}</a></div>
@auth
@if(Auth::user()->id !== $post->user->id && $post->is_fee === 1 && !$post->is_subscribed_by_auth_user())
@if(is_null(Auth::user()->stripe_code))
<h2 class="restricted-content">{{Str::limit($post->content, 60,'...')}}</h2>
<p class="limit-line">--------この投稿をお読みいただくには購読が必要です--------</p>
<form action="{{ route('payment.form') }}" method="get" class="text-center mt-5">
  <button>お支払い</button>
</form> 
@else
<h2 class="restricted-content">{{Str::limit($post->content, 60,'...')}}</h2>
<p class="limit-line">--------この投稿をお読みいただくには購読が必要です--------</p>
<form action="{{ route('payment.page', $post->id) }}" method="get" class="text-center mt-5">
  <button>お支払い</button>
</form>
@endif
@else
<h2>{!! nl2br(e($post->content))!!}</h2>
@endif
@else
@if($post->is_fee === 1)
<h2 class="restricted-content">{{Str::limit($post->content, 60,'...')}}</h2>
<p class="limit-line">--------この投稿をお読みいただくには無料登録と購読が必要です--------</p>
<form action="{{ route('register') }}" method="get" class="text-center mt-5">
  <button>お支払い</button>
</form>
@else
<h2>{!! nl2br(e($post->content))!!}</h2>
@endif
@endauth


<p class = "like-paragraph">投稿にいいねを押しましょう</p>
@auth
  @if($post->is_liked_by_auth_user())
  <form action="{{ route('unlike_post', $post->id) }}" method="post" class = "like-button">
  @csrf
  <input type="submit" value="&#xf004;" class="fas fa-heart">
  <span class="badge">{{$post->likes->count()}}</span>
</form>
  @else
  <form action="{{ route('like_post', $post->id) }}" method="post" class = "like-button">
  @csrf
  <input type="submit" value="&#xf004;" class="far fa-heart">
  <span class="badge">{{$post->likes->count()}}</span>
</form>
  @endif
  @else
  <form action="{{ route('register') }}" method="get" class="like-button"> 
    @csrf
    <input type="submit" value="&#xf004;" class="far fa-heart">
  <span class="badge">{{$post->likes->count()}}</span>
  </form>
  @endauth
<p class="comment-paragraph">コメントを書く</p>
<form action="{{ route('post.comment', $post->id) }}" method ="post" autocomplete="off">
@csrf
<textarea name="content" placeholder="感想コメントを書きましょう" class="comment-box"></textarea>
<button type="submit" class="comment-button">追加</button>
@error('content')
<table class="comment-errorbox">
 <tr><th class="comment-error"><p>Error</p></th>
 <td class="comment-message"><p>{{$message}}</p></td></tr>
 </table>
 @enderror
</form>
<div class="tip-button">
@auth
@if($post->user->id !== Auth::user()->id && !$post->is_tipped_by_auth_user())
@if(is_null(Auth::user()->stripe_code))
<p class="tip-paragraph">チップを投げる</p>
<form action="{{ route('payment.form') }}" method="get" class="tip-button">
<input type="submit" value="&#xf004;" class="fas fa-yen-sign">
</form>
@else
<p class="tip-paragraph">チップを投げる</p>
<form action="{{ route('payment.tip', $post->id) }}" method="get" class="tip-button">
<input type="submit" value="&#xf157;" class="fas fa-yen-sign">
</form>
@endif
@else
@endif
@else
<p class="tip-paragraph">チップを投げる</p>
<form action="{{ route('register') }}" method="get" class="tip-button">
<input type="submit" value="&#xf157;" class="fas fa-yen-sign">
</form>
@endauth
</div>
<div class="tips-row">
@foreach ($tips as $tip)
<table class="tips-box">
<tr><th class="tips-price"><label>￥{{$tip->price}}</label></td></tr>
<tr><th class="comment-user"><p>{{$tip->user->name}}</p></td></tr>
<tr><td class="comment-content"><p>{{$tip->comment}}</p></th></tr>
</table>
@endforeach
</div>
<div class="comments-row">
@foreach ($comments as $comment)
<table>
<tr><th class="comment-user"><p>{{$comment->user->name}}</p></td></tr>
<tr><td class="comment-content"><p>{{$comment->content}}</p></th></tr>
</table>
</div>
@endforeach
@endsection
