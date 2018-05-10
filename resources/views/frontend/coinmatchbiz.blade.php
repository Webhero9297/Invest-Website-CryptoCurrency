@extends('layouts.frontend')

@section('content')
<link href="{{ asset('css/coinmatch.css') }}" rel="stylesheet">
<script src="{{ asset('./assets/jsLib/datatable/jquery.datatable.js') }}" ></script>
<script src="{{ asset('./assets/jsLib/datatable/datatable.bootstrap.js') }}" ></script>
<style>
    .p-sub-footer{
        color: #a2a2a2;
        margin-top: 30px;
    }
    .btn-select-method {
        width: 260px;
        margin: 1em auto;
        display: block;
    }
    .modal-dialog-method {
        width: 300px;
    }
</style>
<script>
    var global_biz = <?php echo $global_biz; ?>;

</script>
<div class="container-fluid padding0">
    <div class="div-auth-register" id="home" style="padding-top:100px;">
        <div class="container">
            <div class="panel panel-default">
                <div class="div-panel-heading">
                    Coin Match
                    <a class="a-plus" href="{{ route('coin.match.view') }}" data-toggle="popover" data-content="Create an offer"></a>
                </div>
                <div class="panel-body">
                    <div class="tab">
                        <button class="tablinks active" onclick="openCity(event, 'div_buy')" data-toggle="popover" data-content="People who would like to buy coins">BUY</button>
                        <button class="tablinks" onclick="openCity(event, 'div_sell')" data-toggle="popover" data-content="People who would like to sell coins">SELL</button>
                        <button class="tablinks" onclick="openCity(event, 'div_star')" data-toggle="popover" data-content="Find review's about the people">REVIEW'S</button>
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
<div id="div_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_review" class="form-modal-content" action="{{ route('coinmatch.review') }}">
                    <input type="hidden" name="match_id" value="">
                    <input type="hidden" name="order_side" value="">
                    <input type="hidden" name="review_score" value="0">
                    <div class="form-group form-modal-top-label" >
                        <div class="row">
                            <div class="col-xs-6" style="padding:5px 5px 0 15px;">
                                <img id="img_user_avatar" style="border-radius: 50%;" width="32px" height="32px" />&nbsp;&nbsp;&nbsp;
                                <span id="span_user_full_name" class="span-review" style="color:white;"></span>&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="col-xs-2" style="padding:5px 5px 0 5px;">
                                <img id="review_icon" />
                            </div>
                            <div class="col-xs-2" style="padding:7px 5px 0 15px;">
                                <span id="review_price" class="span-review"></span>
                            </div>
                            <div class="col-xs-2" style="padding:7px 5px 0 15px;">
                                <span id="review_quantity" class="span-review" style="color:white;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6" style="padding-left: 5px;padding-right: 5px;display: none;">
                                <label for="review_amount" class="modal-title">Amount: </label>
                                <input type="number" id="review_amount" name="review_amount" class="" min="0" max="">
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <fieldset class="rating">
                                    <input type="radio" class="score_radio" id="star5" name="ranking" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                    <input type="radio" class="score_radio" id="star4half" name="ranking" value="4.5" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                    <input type="radio" class="score_radio" id="star4" name="ranking" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                    <input type="radio" class="score_radio" id="star3half" name="ranking" value="3.5" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                    <input type="radio" class="score_radio" id="star3" name="ranking" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                    <input type="radio" class="score_radio" id="star2half" name="ranking" value="2.5" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                    <input type="radio" class="score_radio" id="star2" name="ranking" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                    <input type="radio" class="score_radio" id="star1half" name="ranking" value="1.5" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                    <input type="radio" class="score_radio" id="star1" name="ranking" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                    <input type="radio" class="score_radio" id="starhalf" name="ranking" value="0.5" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                </fieldset>
                                <label class="modal-title" style="display:none;">&nbsp;&nbsp;&nbsp;Score: </label>
                                &nbsp;:&nbsp;<label class="modal-title" id="score_ranking"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="modal-title">Comment</label>
                        <textarea id="subject" name="review_content" placeholder="Write something.."></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="button buttonBlue btn-save-details" onclick="doOnReviewSubmit()">Submit</button>
                        <button type="button" class="button buttonRed btn-save-details" onclick="doOnCloseModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<div id="div_buy_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-method">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <button type="button" class="button buttonBlue btn-select-method" onclick="doOnSendSellInterestedSubmit()" data-toggle="popover" data-content="User will be notified by email.">
                    Interested
                </button>
                <button type="button" class="button buttonBlue btn-select-method" onclick="doOnShowSellReviewComment()" data-toggle="popover" data-content="User will receive a message at Moonfolio.">
                    Leave a message
                </button>
                <button type="button" class="button buttonBlue btn-select-method" onclick="doOnShowAddReview()" data-toggle="popover" data-content="You can give the user some stars and a comment.">
                    Add review
                </button>
            </div>
        </div>
    </div>
</div>
<div id="div_buy_message_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_review" class="form-modal-content">
                    <div class="form-group">
                        <label for="comment" class="modal-title">Comment</label>
                        <textarea id="comment" name="review_content" placeholder="Write something.."></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="button buttonBlue" onclick="doOnSendMessage()">Send Message</button>
                        <button type="button" class="button buttonRed" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="confirm_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>An email have been sent to the user. Please wait for his response.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="button buttonBlue" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<div id="init_alert_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>List the coins here you wish to buy or sell and our Coinmatch engine will automatically match you with other interested buyers and sellers!</p>
            </div>
            <div class="modal-footer" style="padding:0;">
                <button type="button" class="button buttonRed" data-dismiss="modal">&nbsp;&nbsp;Close&nbsp;&nbsp;</button>
            </div>
        </div>
    </div>
</div>
<div id="alarm_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>You have to become Moonfolio account.</p>
            </div>
            <div class="modal-footer" style="padding:0;">
                <button type="button" class="button buttonRed" data-dismiss="modal">&nbsp;&nbsp;Close&nbsp;&nbsp;</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('./js/frontend/coinmatchbiz.js') }}"></script>
@endsection
