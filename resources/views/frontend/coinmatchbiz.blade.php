@extends('layouts.frontend')

@section('content')
<link href="{{ asset('css/coinmatch.css') }}" rel="stylesheet">
{{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">--}}
<script src="{{ asset('./assets/jsLib/datatable/jquery.datatable.js') }}" ></script>
{{--<script src="{{ asset('./assets/jsLib/datatable/dataTables.fixedHeader.min.js') }}" ></script>--}}
<script src="{{ asset('./assets/jsLib/datatable/datatable.bootstrap.js') }}" ></script>
<script src="{{ asset('./assets/jsLib/accounting.min.js') }}" ></script>
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

    input[type="search"]::-webkit-input-placeholder { /* Chrome/Opera/Safari */
        color: #a2a2a2;
    }
    input[type="search"]::-moz-placeholder { /* Firefox 19+ */
        color: #a2a2a2;
    }
    input[type="search"]:-ms-input-placeholder { /* IE 10+ */
        color: #a2a2a2;
    }
    input[type="search"]:-moz-placeholder { /* Firefox 18- */
        color: #a2a2a2;
    }

    input[type="search"]::placeholder {
        color: #a2a2a2;
        opacity: 1; /* Firefox */
    }

    input[type="search"]:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #a2a2a2;
    }

    input[type="search"]::-ms-input-placeholder { /* Microsoft Edge */
        color: #a2a2a2;
    }

    #star_table_wrapper {
        margin-top: 5px;
    }

    #content-modal-p {
        font-size: 16px;
        word-wrap: break-word;
        max-height: 300px;
        overflow-y: auto;
        display: block;
        /*height: 240px;*/
    }
    .FixedHeader_Cloned {
        background-color: #0297bf;
    }
    #star_table_fix_header, #buy_table_fix_header, #sell_table_fix_header {
        margin-bottom: 0!important;
        z-index: 1031;
        position: relative;
        background-color: #0297bf;
        border: 1px solid white;
    }
    .div-td-cell {
        height:36px;
        display: inline-block;
        font-size: 16px;
        font-family: Montserrat-Light;
        color: white;
        /*font-weight: bold;;*/
        padding: 4px;
        text-align: center;
    }
    .dataTables_wrapper {
        width: 100%;
    }
    .dataTables_wrapper .row:nth-child(3) {
        display: none;
    }

    /* width */
    div ::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    div ::-webkit-scrollbar-track {
        background: rgba(0,0,0,0.1);
    }

    /* Handle */
    div ::-webkit-scrollbar-thumb {
        border-radius: 0!important;
        background: #0297bf!important;;
    }

    /* Handle on hover */
    div ::-webkit-scrollbar-thumb:hover {
        background: #0297bf!important;
    }

</style>
<script>
    var global_biz = <?php echo $global_biz; ?>;
    var order_data = <?php echo $order_data; ?>;
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
                        <button class="tablinks active" onclick="openCity(event, 'div_buy')" data-toggle="popover" data-content="People who would like to buy coins">Buy</button>
                        <button class="tablinks" onclick="openCity(event, 'div_sell')" data-toggle="popover" data-content="People who would like to sell coins">Sell</button>
                        <button class="tablinks" onclick="openCity(event, 'div_star')" data-toggle="popover" data-content="Find reviews about the people">Reviews</button>
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
                <form id="form_review" class="form-modal-content" >
                    @csrf
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
                {{--<p></p>--}}
            {{--</div>--}}
            {{--<div class="modal-footer">--}}
                <button type="button" class="button buttonBlue btn-select-method" onclick="doOnSendSellInterestedSubmit()" data-toggle="popover" data-content="User will be notified by email and will receive an alert on Moonfolio.">
                    Interested
                </button>
                {{--<button type="button" class="button buttonBlue btn-select-method" onclick="doOnShowSellReviewComment()" data-toggle="popover" data-content="User will receive a message at Moonfolio.">--}}
                    {{--Leave a message--}}
                {{--</button>--}}
                <button type="button" class="button buttonBlue btn-select-method" onclick="doOnShowAddReview()" data-toggle="popover" data-content="Rate the user.">
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
                        <label for="comment" class="modal-title">Your message have been sent.</label>
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
                <p>An email have been sent to the user. Please wait for their response.</p>
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
                <p>You must be a Moonfolio user, please signup now or login.</p>
            </div>
            <div class="modal-footer" style="padding:0;">
                <button type="button" class="button buttonRed" data-dismiss="modal">&nbsp;&nbsp;Close&nbsp;&nbsp;</button>
            </div>
        </div>
    </div>
</div>
<div id="popup_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>An email has been sent to the user. Please wait for their response.</p>
            </div>
            <div class="modal-footer" style="padding:0;">
                <button type="button" class="button buttonBlue" style="margin:0.3em auto;" data-dismiss="modal">&nbsp;&nbsp;Ok&nbsp;&nbsp;</button>
            </div>
        </div>
    </div>
</div>
<div id="submit_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Your review has been added at the reviews section.</p>
            </div>
            <div class="modal-footer" style="padding:0;">
                <button type="button" class="button buttonBlue" style="margin:0.3em auto;" data-dismiss="modal">&nbsp;&nbsp;Ok&nbsp;&nbsp;</button>
            </div>
        </div>
    </div>
</div>
<div id="review_cancel_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Moonfolio</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Sorry, this is already reviewed by an user.</p>
            </div>
            <div class="modal-footer" style="padding:0;">
                <button type="button" class="button buttonBlue" style="margin:0.3em auto;" data-dismiss="modal">&nbsp;&nbsp;Ok&nbsp;&nbsp;</button>
            </div>
        </div>
    </div>
</div>
<div id="content_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Comment</h4>
                <button type="button" class="close" style="color:white;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="content-modal-p"></div>
            </div>
            <div class="modal-footer" style="padding:0;">
                <button type="button" class="button buttonBlue" style="margin:0.3em auto;" data-dismiss="modal">&nbsp;&nbsp;Ok&nbsp;&nbsp;</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('./js/frontend/coinmatchbiz.js') }}"></script>
@endsection
