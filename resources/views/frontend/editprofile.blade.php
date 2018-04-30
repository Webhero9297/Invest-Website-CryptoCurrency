@extends('layouts.frontend')

@section('content')
<style>
    .control-label {
        font-family: Montserrat-light;
    }
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
</style>
<div class="container-fluid padding0">
    <div class="div-auth-register" id="home" style="padding-top:100px;">
        <div class="container" style="padding-bottom: 278px;">
            <div class="panel panel-default">
                <div class="div-panel-heading">
                    PERSONAL INFORMATION
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('save.details') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="full_name">Full Name</label>
                                <input type="text" class="form-control input-form-control grey-border grey-color" style="text-transform: capitalize;" tabindex="1" id="full_name" name="full_name" value="{{ $full_name }}" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="email">Email</label>
                                <input type="email" class="form-control input-form-control grey-border grey-color" tabindex="2" id="email" name="email" value="{{ $email }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label class="control-label" for="gender">Gender</label>
                                <select name="gender" class="form-control our" tabindex="3">
                                    @if ( $gender == 0 )
                                        <option value="0" selected>Male</option>
                                        <option value="1">Female</option>
                                    @else
                                        <option value="0">Male</option>
                                        <option value="1" selected>Female</option>
                                    @endif

                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label class="control-label" for="age">Age</label>
                                <div class="input-group spinner">
                                    <input type="text" class="form-control input-form-control grey-border grey-color" tabindex="4" id="age" name="age" style="font-size:24px;" value="{{ $age }}">
                                    <div class="input-group-btn-vertical">
                                        <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
                                        <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="email">Country</label>
                                <input type="text" class="form-control input-form-control grey-border grey-color" tabindex="5" id="country" name="country" value="{{ $country }}">
                            </div>
                        </div>
                        <div class="group text-right">
                            <button type="submit" class="button buttonBlue btn-save-details">SAVE DETAILS
                                <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
                            </button>
                            <a href="{{ route('profile') }}" class="button buttonRed btn-save-details ui-corner-all">CANCEL</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
<script src="{{ asset('./js/frontend/editprofile.js') }}"></script>
@endsection
