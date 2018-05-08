@extends('layouts.frontend')

@section('content')
<link href="{{ asset('css/coinmatch.css') }}" rel="stylesheet">

<script src="{{ asset('./assets/jsLib/datatable/jquery.datatable.js') }}" ></script>
<script src="{{ asset('./assets/jsLib/datatable/datatable.bootstrap.js') }}" ></script>

<script>
    var global_biz = 1;
</script>
<div class="container-fluid padding0">
    <div class="div-auth-register" id="home" style="padding-top:100px;">
        <div class="container">
            <div class="panel panel-default">
                <div class="div-panel-heading">
                    Coin Match
                </div>
                <div class="panel-body">
                    <div class="tab">
                        <button class="tablinks active" onclick="openCity(event, 'div_buy')">BUY</button>
                        <button class="tablinks" onclick="openCity(event, 'div_sell')">SELL</button>
                        <button class="tablinks" onclick="openCity(event, 'div_star')">STAR</button>
                    </div>
                    <div id="div_buy" class="tabcontent show">
                        @include('partial/buy')
                    </div>
                    <div id="div_sell" class="tabcontent">
                        @include('partial/sell')
                    </div>
                    <div id="div_star" class="tabcontent">
                        @include('partial/star')
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<div id="div_modal" class="modal">
    <form id="form_review" class="modal-content animate" action="{{ route('coinmatch.review') }}">
        <input type="hidden" name="match_id" value="">
        <input type="hidden" name="order_side" value="">
        <div class="modal-header">
            Moonfolio
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-4" style="padding:5px 5px 0 5px;">
                    <img id="review_icon" />
                </div>
                <div class="col-xs-4" style="padding:7px 5px 0 15px;">
                    <span id="review_price" class="span-review"></span>
                </div>
                <div class="col-xs-4" style="padding:7px 5px 0 15px;">
                    <span id="review_quantity" class="span-review" style="color:white;"></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-12 col-sm-6" style="padding-left: 5px;padding-right: 5px;">
                    <label for="review_amount" class="modal-title">Amount: </label>
                    <input type="number" id="review_amount" name="review_amount" class="" min="0" max="">
                </div>
                <div class="col-xs-12 col-sm-6">
                    <fieldset class="rating">
                        <input type="radio" class="score_radio" id="star5" name="review_score" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                        <input type="radio" class="score_radio" id="star4half" name="review_score" value="4.5" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                        <input type="radio" class="score_radio" id="star4" name="review_score" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                        <input type="radio" class="score_radio" id="star3half" name="review_score" value="3.5" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                        <input type="radio" class="score_radio" id="star3" name="review_score" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" class="score_radio" id="star2half" name="review_score" value="2.5" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                        <input type="radio" class="score_radio" id="star2" name="review_score" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                        <input type="radio" class="score_radio" id="star1half" name="review_score" value="1.5" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                        <input type="radio" class="score_radio" id="star1" name="review_score" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        <input type="radio" class="score_radio" id="starhalf" name="review_score" value="0.5" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                    </fieldset>
                    <label class="modal-title">&nbsp;&nbsp;&nbsp;Score: </label>
                    <label class="modal-title" id="score_ranking"></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="subject" class="modal-title">Subject</label>
            <textarea id="subject" name="review_content" placeholder="Write something.." style="height:200px"></textarea>
        </div>
        <div class="form-group text-right">
            <button type="button" class="button buttonBlue btn-save-details ui-corner-all" onclick="doOnReviewSubmit()">Submit</button>
            <button type="button" class="button buttonRed btn-save-details ui-corner-all" onclick="document.getElementById('div_modal').style.display='none'">Cancel</button>
        </div>
    </form>
</div>
<script src="{{ asset('./js/frontend/coinmatchbiz.js') }}"></script>
@endsection
