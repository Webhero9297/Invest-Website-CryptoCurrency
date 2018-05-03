@extends('layouts.frontend')

@section('content')
<style>
    .control-label {
        font-family: Montserrat-light;
    }
</style>
<div class="container-fluid padding0">
    <div class="div-auth-register" id="home" >
        <div class="container" style="padding-bottom: 27px;">
            <div class="panel panel-default" style="margin-top: 100px;">
                <div class="div-panel-heading">
                    SELECT AVATARS
                </div>
                <div class="panel-body">
                    <form method="GET" action="{{ route('change.with.default.avatar') }}">
                        @csrf
                        <input type="hidden" name="default_avatar" />
                        <div class="row" style="height: 500px; overflow-y: scroll;">
                            @if ($default_avatars)
                                @foreach($default_avatars as $avatar)
                                    <div class="form-group col-sm-2">
                                        <img src="{{ $avatar }}" class="img-avatar" />
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 text-right">
                                <button type="submit" class="button buttonBlue btn-save-details">SAVE DETAILS
                                    <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
                                </button>
                                <a href="{{ route('profile') }}" class="button buttonRed btn-save-details ui-corner-all">CANCEL</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('./js/frontend/editprofile.js') }}"></script>
@endsection
