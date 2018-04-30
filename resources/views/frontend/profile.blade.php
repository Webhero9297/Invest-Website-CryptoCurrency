@extends('layouts.frontend')

@section('content')
<style>
    input[type="radio"] {
        display: none;;
    }
    .edit-price-alert{
        position: absolute;
        right: 0;
        font-size: 20px;
        padding: 7px 25px;
    }
    .add-coin-match{
        position: absolute;
        right: 220px;
        font-size: 20px;
        padding: 7px 15px;
    }
    @media( min-width: 1024px ) {
        .xtd-cell {
            display: none;
        }
        .ov-cell {
            display: block;
        }
    }
    @media( max-width: 1024px ) {
        .xtd-cell {
            display: block;
        }
        .ov-cell {
            display: none;
        }
    }
</style>

<div id="coinchart_detail" class="container-fluid padding0">
    <div class="div-auth-register" id="home" style="margin-top:0; padding-top:100px;">
        <div class="container" style="padding-bottom: 44px;">
            <div class="panel panel-default">
                <div class="div-panel-heading">
                    PERSONAL INFORMATION
                    <a class="a-pencil" href="{{ route('editprofile') }}" data-toggle="popover" data-content="Edit your profile"></a>
                    <a class="a-close-account" data-toggle="popover" data-content="Delete your account">
                        <i class="fa fa-trash" ></i>
                    </a>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3 text-center">
                            <img class="div-avatar-img" src="{{ $user_avatar }}"/>
                            <a class="div-avatar-img-choise-btn"  data-toggle="modal" data-target="#selectAvatarModal">
                                <i class="fa fa-pencil-square img-edit"></i>
                            </a>
                        </div>
                        <div class="col-sm-9" style="margin-top: -15px;">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-primary {{ ($isPrivate==0) ? "active" : "" }}" onclick="doOnClick('public')" data-toggle="popover" data-content="Keep your portfolio public">
                                            <input type="radio" name="options" id="public" autocomplete="off"> Public
                                        </label>
                                        <label class="btn btn-primary {{ ($isPrivate==1) ? "active" : "" }}" onclick="doOnClick('private')" data-toggle="popover" data-content="Keep your portfolio private">
                                            <input type="radio" name="options" id="private" autocomplete="off"> Private
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7 div-flex">
                                    <div class="img-icon img-name" ></div>
                                    <div class="div-pt-7">
                                        <span class="div-label-first">Name:</span>
                                        <span class="div-label-value">{{ $full_name }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-5 div-flex">
                                    <div class="img-icon img-gender" ></div>
                                    <div class="div-pt-7">
                                        <span class="div-label-first">Gender:</span>
                                        <span class="div-label-value">{{ $gender }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7 div-flex">
                                    <div class="img-icon img-email" ></div>
                                    <div class="div-pt-7">
                                        <span class="div-label-first">Email:</span>
                                        <span class="div-label-value">{{ $email }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-5 div-flex">
                                    <div class="img-icon img-country"  ></div>
                                    <div class="div-pt-7">
                                        <span class="div-label-first">Country:</span>
                                        <span class="div-label-value">{{ $country }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 div-flex">
                                    <div class="img-icon img-age" ></div>
                                    <div class="div-pt-7">
                                        <span class="div-label-first">Age:</span>
                                        <span class="div-label-value">{{ $age }}</span>
                                    </div>
                                    <a href="{{ route('coin.match.view') }}" class="nav-link a-link sign text-center add-coin-match">Add Coin Match</a>
                                    <a href="{{ route('edit.price.alert') }}" class="nav-link a-link sign text-center edit-price-alert">Add Price Alert</a>
                                </div>
                                {{--<div class="col-sm-5 div-flex">--}}
                                    {{--<div class="div-pt-7">--}}

                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default" style="margin-top:50px;">
                <div class="div-panel-heading">
                    Your Currencies
                    <a class="a-plus" href="{{ route('add.crypto.currency') }}"></a>
                </div>
                <div class="panel-body panel-table">
                    <table class="table table-bordered">
                        <thead>
                        <tr id="thead_title">

                        </tr>
                        <tr>
                            <th class="td-cell">#</th>
                            <th class="td-cell">Coin</th>
                            <th class="td-cell">Current Price</th>
                            <th class="td-cell">Invested Capital</th>
                            <th class="td-cell">Profit/Loss (Each)</th>
                            <th class="td-cell">1H Change %</th>
                            <th class="td-cell">24H Change %</th>
                            <th class="td-cell">Action</th>
                        </tr>
                        </thead>
                        <tbody id="tbody_content">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="confirmCloseThisAccount" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you would like to delete your account?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="button buttonRed btn-save-details ui-corner-all" onclick="doOnRequestCloseThisAccount()">Yes</button>
                <button type="button" class="button buttonBlue btn-save-details ui-corner-all" data-dismiss="modal">No</button>
            </div>
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
                <p>Are you sure you would like to remove this currency data?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="button buttonRed btn-save-details ui-corner-all" onclick="doOnRequestDelete()">Remove</button>
                <button type="button" class="button buttonBlue btn-save-details ui-corner-all" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="myConfirm" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Just removed detail data.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="button buttonBlue btn-save-details ui-corner-all" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="selectAvatarModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <a class="button buttonBlue btn-save-details ui-corner-all" href="{{ route('select.default.avatar') }}">Choose avatar</a>
                <a class="button buttonBlue btn-save-details ui-corner-all" href="{{ route('select.custom.avatar') }}">Upload avatar</a>
                <button type="button" class="button buttonRed btn-save-details ui-corner-all" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('./js/frontend/editprofile.js') }}"></script>
@endsection
