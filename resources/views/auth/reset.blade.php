@extends('layouts.frontend')

@section('content')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<div class="container-fluid padding0">
    <div class="div-auth-register" id="home">
        <div class="container">
            <form method="POST" class="auth-login" action="{{ route('reset.password') }}">
                @csrf
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
                </div>
                <div class="group">
                    <input type="password" class="auth-input" name="confirm_password"><span class="highlight"></span><span class="bar"></span>
                    <label class="auth-label">Confirm Password*</label>
                </div>
                <div class="group text-center">
                    <button type="button" class="button buttonBlue" onclick="doOnSubmit()">Change
                        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h3>Password does not match</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="button buttonRed btn-save-details ui-corner-all" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    <script src="{{ asset('./js/frontend/resetpassform.js') }}" ></script>
@endsection
