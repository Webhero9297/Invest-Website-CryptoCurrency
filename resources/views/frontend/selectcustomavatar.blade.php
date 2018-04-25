@extends('layouts.frontend')

@section('content')
<style>
    .control-label {
        font-family: Montserrat-light;
    }

</style>

<div class="container-fluid padding0">
    <div class="div-auth-register" id="home">
        <div class="container" style="padding-bottom: 100px;">
            <div class="panel panel-default" style="margin-top:100px;">
                <div class="div-panel-heading">
                    SELECT AVATARS
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('change.with.custom.avatar') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="button buttonBlue btn-save-details file">
                                    Upload your image
                                    <input type="file" id="custom_avatar" name="custom_avatar" class="user_avatar"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <img src="{{ $default_avatar }}" id="img_user_avatar" width="400px" height="400px"/>
                            </div>
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
