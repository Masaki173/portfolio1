@extends('layouts.payments')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$post->user->name}}さんの投稿、「{{ $post->title }}」にチップを投げる</div>
                <div class="card-body">
                    <div class="form-group">
                        <ul class="list-group">
                            <li class="list-group-item">
                            <form action="{{route('tip.done', $post->id)}}" method="POST">
                                            @csrf
                                            <label>￥<input type="tel" minlength="3" name="price"></input> JPY</label>
                                             @error('price')
 　　　　　　　　　　　　                    <div class="comment-paragraph"><p>Error: {{$message}}</p></div>
 　　　　　　　　　　　　　　　　　　　　　　　@enderror
                                            <textarea name="comment" placeholder="チップにコメントを付けましょう" class="text-tip"></textarea>
                                            <button type="submit" id="" class="btn btn-primary">チップを投げる</button>
                                        </form>
                            </li>
                        </ul>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>
@endsection
