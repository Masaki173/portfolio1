@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                        <label for="name" class="col-sm-4 col-form-label text-md-right"></label>
                            <div class="col-md-6 button_wrapper">
                                <button type="submit" class="btn btn-primary register-e">
                                    {{ __('Register') }}
                                </button>
                            </div>
                           </div>
                           <div class="form-group row">
                             <label for="name" class="col-sm-4 col-form-label text-md-right"></label>
                          <div class="col-md-6 social-a">
                               <div class="button_wrapper"><button class="social-register register-f"><a href="{{ url('register/facebook')}}" class="btn facebook"><i class="fab fa-facebook"></i> Facebookで登録</a></button></div>
                              <div class="button_wrapper"><button class="social-register register-t"><a href="{{ url('register/twitter')}}" class="btn twitter"><i class="fab fa-twitter"></i> Twitterで登録</a></button></div>
                              <div class="button_wrapper"><button class="social-register register-g"><a href="{{ url('register/google')}}" class="btn google"><i class="fab fa-google"></i> Googleで登録</a></button></div>
                         </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
