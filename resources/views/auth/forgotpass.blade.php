@extends('layouts.frontend')

@section('content')
<style>
    .show-alert {
        display: block;
        margin-bottom: 30px;
        text-align: center;
        font-size: 20px;
    }
</style>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <div class="container-fluid padding0">
        <div class="div-auth-login" id="home">
            <div class="container">
                <form method="GET" class="auth-login" action="{{ route('send.resetpasslink') }}">
                    @csrf
                    <div class="form-group-lg auth-title" >
                        {{--<label class="label-auth-top-title">One account is all you need</label>--}}
                        <label class="label-auth-sub-title">Please fill in your email address below.</label>
                    </div>
                    <div class="group">
                        <input type="email" class="auth-input" name="email"><span class="highlight"></span><span class="bar"></span>
                        <label class="auth-label">Email*</label>
                        @if (isset($token))
                            <span class="invalid-feedback show-alert" >
                            <strong style="color:green;">We have just sent you an email.&nbsp;&nbsp;Please check your inbox.</strong>
                        </span>
                        @endif
                    </div>
                    <div class="group text-center">
                        <button type="submit" class="button buttonBlue">SEND
                            <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('./js/frontend/passreset.js') }}" ></script>
@endsection
