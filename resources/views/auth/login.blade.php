@extends('layouts.frontend')

@section('content')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<div class="container-fluid padding0">
    <div class="div-auth-login" id="home">
        <div class="container">
            <form method="POST" class="auth-login" action="{{ route('login') }}">
                @csrf
                <div class="form-group-lg auth-title" >
                    {{--<label class="label-auth-top-title">One account is all you need</label>--}}
                    <label class="label-auth-sub-title">Please enter your details below.</label>
                </div>
                <div class="group">
                    <input type="email" class="auth-input" name="email"><span class="highlight"></span><span class="bar"></span>
                    <label class="auth-label">Email*</label>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="group">
                    <input type="password" class="auth-input" name="password"><span class="highlight"></span><span class="bar"></span>
                    <label class="auth-label">Password*</label>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="group text-center">
                    <button type="submit" class="button buttonBlue">LOGIN
                        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
                    </button>
                    <div class="div-auth-button-wrap">
                        <label class="label-auth-bottom-title">New to Moonfolio?</label>
                        <a href="{{ route('register') }}" class="nav-link a-join-here">JOIN HERE</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('./js/frontend/login.js') }}" ></script>
@endsection
