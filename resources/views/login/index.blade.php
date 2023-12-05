@extends('layouts.layouts')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card login-bg p-3" style="border-radius: 30px;"> <!-- Adjust the border-radius value as needed -->
                    <div class="pb-3">
                        <h3 class="text-center text-white">{{ __('Login') }}</h3>
                    </div>
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session()->has('loginError'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('loginError') }}
                            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <input id="username" type="text" class="form-control custom-rounded-input @error('username') is-invalid @enderror bold-placeholder" autofocus name="username" value="{{ old('username') }}" placeholder="{{ __('Username') }}">
                                @error('username')
                                    <span class="invalid-feedback text-black-50" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group pb-3">
                                <input id="password" type="password" class="form-control custom-rounded-input @error('password') is-invalid @enderror bold-placeholder" name="password" placeholder="{{ __('Password') }}">
                                @error('password')
                                    <span class="invalid-feedback text-black-50" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group text-center ">
                                <button type="submit" class="btn col-md-12 button-login-bg font-weight-bold">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    Don't have an account? <a href="{{ route('register') }}">Click here to register</a>
                </div>
            </div>
        </div>
    </div>
@endsection
