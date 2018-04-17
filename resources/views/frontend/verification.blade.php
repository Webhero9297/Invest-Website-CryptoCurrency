@extends('layouts.frontend')

@section('content')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<div class="container-fluid padding0">
    <div class="div-auth-login" id="home" style="padding-bottom: 290px;">
        <div class="container">
            <form method="POST" class="auth-login" action="{{ route('sendverification') }}">
                @csrf
                <input type="hidden" name="code" value="{{ $code }}" />
                <div class="form-group-lg auth-title" >
                    <label class="label-auth-sub-title">We have just sent a verification link to your email.</label>
                </div>
                <div class="group text-center">
                    <button type="submit" class="button buttonBlue">Resend
                        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
