@extends('layouts.layouts')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card login-bg p-3">
                    <div class="pb-3">
                        <h3 class="text-center text-white">{{ __('Register') }}</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <input id="fullname" type="text" class="form-control custom-rounded-input @error('fullname') is-invalid @enderror bold-placeholder" name="fullname" value="{{ old('fullname') }}"  autofocus placeholder="{{ __('Full Name') }}">
                                @error('fullname')
                                    <span class="invalid-feedback text-black-50" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input id="username" type="text" class="form-control custom-rounded-input @error('username') is-invalid @enderror bold-placeholder" name="username" value="{{ old('username') }}" placeholder="{{ __('Username') }}">
                                @error('username')
                                    <span class="invalid-feedback text-black-50" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input id="password" type="password" class="form-control custom-rounded-input @error('password') is-invalid @enderror bold-placeholder"
                                   name="password" placeholder="{{ __('Password') }}">
                                @error('password')
                                    <span class="invalid-feedback text-black-50" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn col-md-12 button-login-bg font-weight-bold">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    Already have an account? <a href="{{ route('login') }}">Login here</a>
                </div>
            </div>
        </div>
    </div>
@endsection
