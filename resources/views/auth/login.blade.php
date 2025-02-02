@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                       <!-- Check for session error and display it -->
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ $redirect ?? '/' }}">

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4"> <!-- Add offset-md-4 to center the following elements -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" style="margin-top:0.7rem" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember" >
                                            {{ __('Remember Me') }}
                                        </label>
                                        <button type="submit" class="btn btn-primary" style="margin-left:10%" >{{ __('Login') }}</button>
                                    </div>
                                </div>
                            </div>


                            @if (Route::has('password.request'))
                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4"> <!-- Add offset-md-4 to center the following elements -->
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <hr>
                           
                           <hr>
                           <p class="text-center">Not a Member Yet? - <a target="_self" href="/register">Register</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://kit.fontawesome.com/8879801888.js" crossorigin="anonymous"></script>
