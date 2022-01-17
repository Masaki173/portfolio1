@extends('layouts.payments')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$post->user->name}}さんの投稿、「{{ $post->title }}」の購読</div>
                <div class="card-body">
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

                    @if (session('errors'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('errors') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <ul class="list-group">
                            <li class="list-group-item">
                            <p>{{$post->price}}円お支払いいただくことで、購読できます。</p>
                            <form action="{{route('payment.done', $post->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$post->price}}" name="price">
                                            <button id="" class="btn btn-primary">購読する</button>
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