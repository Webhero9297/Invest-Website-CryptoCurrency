@extends('layouts.frontend')

@section('content')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<style>
    .show-alert {
        display: block;
        margin-bottom: 30px;
        text-align: center;
        font-size: 20px;
        margin-top: -33px;
    }
</style>
<div class="container-fluid padding0">
    <div class="div-auth-login" id="home">
        <div class="container">
            <form method="POST" class="auth-login" action="{{ route('login') }}">
                @csrf
                <div class="form-group-lg auth-title" >
                    {{--<label class="label-auth-top-title">One account is all you need</label>--}}
                    <label class="label-auth-sub-title">Please enter your details below.</label>
                </div>
                @if ($errors->has('email'))
                    <span class="invalid-feedback show-alert" >
                        <strong>Please enter a valid username and password.</strong>
                    </span>
                @endif
                <div class="group">
                    <input type="email" class="auth-input" name="email"><span class="highlight"></span><span class="bar"></span>
                    <label class="auth-label">Email*</label>
                </div>
                <div class="group">
                    <input type="password" class="auth-input" name="password"><span class="highlight"></span><span class="bar"></span>
                    <label class="auth-label">Password*</label>
                </div>
                <div class="group text-center">
                    <button type="submit" class="button buttonBlue">LOGIN
                        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
                    </button>
                    <div class="div-auth-button-wrap">
                        {{--<label class="label-auth-bottom-title">Forgot password?</label>--}}
                        <a href="{{ route('reset.pass') }}" class="nav-link a-join-here">Forgot password</a>
                    </div>
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
