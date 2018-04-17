@extends('layouts.frontend')

@section('content')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<div class="container-fluid padding0">
    <div class="div-auth-register" id="home">
        <div class="container">
            <form method="POST" class="auth-login" action="{{ route('register') }}">
                @csrf
                <div class="form-group-lg auth-title" >
                    {{--<label class="label-auth-top-title">Please fill out the information below first</label>--}}
                    <label class="label-auth-sub-title">All you need to start is an account. Get one for free now!</label>
                </div>
                <div class="group">
                    <input type="text" class="auth-input" name="full_name"><span class="highlight"></span><span class="bar"></span>
                    <label class="auth-label">Username*</label>
                    @if ($errors->has('full_name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('full_name') }}</strong>
                        </span>
                    @endif
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
                    <button type="submit" class="button buttonBlue">REGISTER
                        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('./js/frontend/home.js') }}" ></script>
@endsection
<script>
    document.getElementsByName('full_name').focus;
</script>