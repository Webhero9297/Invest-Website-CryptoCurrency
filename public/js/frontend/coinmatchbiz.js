var sell_modal, buy_modal;
var send_user_id=undefined;
var g_side;
var selectedTdInfo = undefined;
var sellTable, buyTable, starTable;
var filter_value_arr = ['','',''];
var filter_column_arr = [1,4,5];
$(document).ready(function(){
    $('#init_alert_modal').modal('show');


    //starTable = $('#star_table').dataTable().api();

    $('input.score_radio').click(function(){
        $('#score_ranking').html($(this).val());
        $('input[name="review_score"]').val($(this).val());
    });
    $('.py-4').css('height', '100%');
    //$('#other_sell_table thead th:last').css('width', '82px');
    //$('#other_buy_table thead th:last').css('width', '82px');
    doOnGetLiveData();
    window.setInterval(function(){
        doOnGetLiveData();
    }, 10000);

    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });
    $('[data-toggle="popover"]').popover({
        trigger: 'hover',
        'placement': 'top'
    });

    pHTML = "<p class='p-sub-footer'>The information on Coin Match is of a general nature only and does not take into account your personal circumstances, " +
        "financial situation or needs. Coin Match is only a matching service and does not facilitate any on-site transactions and strictly bears no legal responsibility. " +
        "Coin Match does have a rating system, however, these ratings are not to be relied upon. " +
        "Please conduct thorough due diligence with any counter-party that you transact or interact with.</p>";
    $('.div-footer').css('height', '100%');
    $('.div-footer .container').append(pHTML);

    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });
    $('[data-toggle="popover"]').popover({
        trigger: 'hover',
        'placement': 'top'
    });

    $('#filter_coin').on('keyup', function(event){
        filter_str = $(this).val();
        filter_column_arr[0] = 1;
        filter_value_arr[0] = filter_str;
        filterColumn();
    });
    $('#filter_seller').on('keyup', function(event){
        filter_str = $(this).val();
        filter_column_arr[1] = 4;
        filter_value_arr[1] = filter_str;
        filterColumn();
    });
    $('#filter_buyer').on('keyup', function(event){
        filter_str = $(this).val();
        filter_column_arr[2] = 5;
        filter_value_arr[2] = filter_str;
        filterColumn();
    });

    $('#sell_filter_coin').attr('placeholder', 'Find a specific coin');
    $('#buy_filter_coin').attr('placeholder', 'Find a specific coin');

    $('#sell_filter_coin').each(function () {
        var availableTags = $('#sell-brands-list').find('option').map(function () {
            return this.value;
        }).get();
        $(this).autocomplete({
            source: availableTags,
            select: function(e, ui) {
                doOnFilterBuyData( 2, ui.item.value );
            }
        }).on('search', function () {
            if ($(this).val() === '') {
                $(this).autocomplete('search', ' ');
            }
        });
    });
    $('#sell_filter_coin').on('keyup', function () {
        doOnFilterSellData( 2, $(this).val() );
    });
    $('#buy_filter_coin').each(function () {
        var availableTags = $('#buy-brands-list').find('option').map(function () {
            return this.value;
        }).get();
        $(this).autocomplete({
            source: availableTags,
            select: function(e, ui) {
                doOnFilterBuyData( 2, ui.item.value );
            }
        }).on('search', function () {
            if ($(this).val() === '') {
                $(this).autocomplete('search', ' ');
            }
        });
    });
    $('#buy_filter_coin').bind('keyup', function () {
        doOnFilterBuyData( 2, $(this).val() );
    });

    $('#filter_coin').each(function () {
        var availableTags = $('#filter-coin-list').find('option').map(function () {
            return this.value;
        }).get();
        $(this).autocomplete({
            source: availableTags,
            select: function(e, ui) {
                filter_value_arr[0] = ui.item.value;
                filter_column_arr[0] = 1;
                filterColumn();
            }
        }).on('search', function () {
            if ($(this).val() === '') {
                $(this).autocomplete('search', ' ');
            }
        });
    });
    $('#filter_seller').each(function () {
        var availableTags = $('#filter-seller-list').find('option').map(function () {
            return this.value;
        }).get();
        $(this).autocomplete({
            source: availableTags,
            select: function(e, ui) {
                filter_value_arr[1] = ui.item.value;
                filter_column_arr[1] = 4;
                filterColumn();
            }
        }).on('search', function () {
            if ($(this).val() === '') {
                $(this).autocomplete('search', ' ');
            }
        });
    });
    $('#filter_buyer').each(function () {
        var availableTags = $('#filter-buyer-list').find('option').map(function () {
            return this.value;
        }).get();
        $(this).autocomplete({
            source: availableTags,
            select: function(e, ui) {
                filter_column_arr[2] = 5;
                filter_value_arr[2] = ui.item.value;
                filterColumn();
            }
        }).on('search', function () {
            if ($(this).val() === '') {
                $(this).autocomplete('search', ' ');
            }
        });
    });


});

function filterColumn() {
    starTable.columns().every( function () {
        var that = this;
        if ( existsIndex(that.index()) != -1 ) {
            _filterV = filter_value_arr[existsIndex(that.index())];
            if ( that.search() !== _filterV ) {
                that.search( _filterV ).draw();
            }
        }
    } );
    //starTable.columns.adjust().draw();
    starTable.draw();
}
function existsIndex( _idx ) {
    for( j = 0; j < filter_column_arr.length; j++ ) {
        if ( filter_column_arr[j] == _idx ) {
            return j;
        }
    }
    return -1;
}
function doOnFilterSellData( i, filter_value ) {
    if (filter_value!=''){
        sellTable.columns(i)
            .search(filter_value, false, true)
            .draw();
    }
    else{
        sellTable.columns()
            .search('')
            .draw();
    }
}
function doOnFilterBuyData( i, filter_value ) {
    if (filter_value!=''){
        buyTable.columns(i)
            .search(filter_value, false, true)
            .draw();
    }
    else{
        buyTable.columns()
            .search('')
            .draw();
    }
}

function doOnGetLiveData() {
    $.getJSON('/getorderdata/'+AuthUser, function(resp){
        var other_buy_data = resp.other_buy_data;
        if ( other_buy_data ) {
            tbody_contents = '';
            for(i=0;i<other_buy_data.length;i++) {
                buy_item = other_buy_data[i];
                tbody_contents += '<tr class="tr-live" style="border-bottom: 1px solid #555555;">\
                                            <td class="td-cell text-center padding0">' + (i + 1) + '</td>\
                                            <td class="td-cell text-center padding0 span-buy-nametitle" buyer_id="' + buy_item.user_id + '"\
                                            td-info=\''+JSON.stringify(buy_item)+'\' onclick="doOnClickBuyerForSell(\'buy\', this)">\
                                                <img src="' + buy_item.user_avatar + '" style="border-radius: 50%;object-fit: cover;" width="32px" height="32px" />\
                                                <span>' + buy_item.user_full_name + '</span>\
                                            </td>\
                                            <td class="td-cell text-center padding0">\
                                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/' + buy_item.coin_id + '.png" width="32px" height="32px" />\
                                                <span>' + buy_item.coin_name + '</span>\
                                            </td>\
                                            <td class="td-cell text-center padding0">' + buy_item.quantity + '</td>\
                                            <td class="td-cell color-green text-center padding0">$' + buy_item.purchased_price + '</td>';

                tbody_contents +=           '<td class="td-cell text-center padding0">$' + buy_item.current_price + '</td>';
                tbody_contents += '</tr>';
            }
            $('#tbody_buy_coin_live_data').html(tbody_contents);
        }
        var other_sell_data = resp.other_sell_data;
        if ( other_sell_data ) {
            tbody_contents = '';
            for (i=0;i<other_sell_data.length;i++) {
                sell_item = other_sell_data[i];
                tbody_contents += '<tr class="tr-live" style="border-bottom: 1px solid #555555;">\
                                            <td class="td-cell text-center padding0">' + (i + 1) + '</td>\
                                            <td class="td-cell text-center padding0 span-buy-nametitle" buyer_id="' + sell_item.user_id + '"\
                                            td-info=\''+JSON.stringify(sell_item)+'\' onclick="doOnClickBuyerForSell(\'sell\', this)">\
                                                <img src="' + sell_item.user_avatar + '" style="border-radius: 50%;object-fit: cover;" width="32px" height="32px" />\
                                                <span>' + sell_item.user_full_name + '</span>\
                                            </td>\
                                            <td class="td-cell text-center padding0">\
                                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/' + sell_item.coin_id + '.png" width="32px" height="32px" />\
                                                <span>' + sell_item.coin_name + '</span>\
                                            </td>\
                                            <td class="td-cell text-center padding0">' + sell_item.quantity + '</td>\
                                            <td class="td-cell color-red text-center padding0">$' + sell_item.purchased_price + '</td>';

                tbody_contents +=          '<td class="td-cell text-center padding0">$' + sell_item.current_price + '</td>';
                tbody_contents += '</tr>';
            }
            $('#tbody_sell_coin_live_data').html(tbody_contents);
        }
        var review_data = resp.star_review_data;
        if ( review_data ) {
            tbody_contents = '';
            for (i=0;i<review_data.length;i++) {
                review_item = review_data[i];

                ( review_item.order_side == 0 ) ? color_str = "color-green" : color_str = "color-red";
                ( review_item.order_side == 0 ) ? span_str = "Buy" : span_str = "Sell";
                if ( review_item.review_content == null ) review_content = '';
                else review_content = review_item.review_content;
                tbody_contents += '<tr>\
                                        <td class="td-cell text-center padding0">'+(i+1) +'</td>\
                                        <td class="td-cell text-center padding0">\
                                            <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/'+review_item.coin_id+'.png" width="32px" height="32px" />\
                                            &nbsp;<span>'+review_item.coin_name+'</span>\
                                        </td>\
                                        <td class="td-cell color-green text-center padding0">$'+review_item.purchased_price+'</td>\
                                        <td class="td-cell text-center padding0">'+review_item.review_amount+'&nbsp;'+review_item.coin_symbol+'</td>\
                                        <td class="td-cell text-center padding0">\
                                            <img src="'+review_item.maker_avatar+'" class="img-icon" />\
                                            &nbsp;<span>'+review_item.maker_username+'</span>\
                                        </td>\
                                        <td class="td-cell text-center padding0">\
                                            <img src="'+review_item.taker_avatar+'" class="img-icon" />\
                                            &nbsp;<span>'+review_item.taker_username+'</span>\
                                        </td>\
                                        <td class="td-cell text-center padding0">\
                                            <span class="'+color_str+'" >'+span_str+'</span>\
                                        </td>\
                                        <td class="td-cell text-center padding0">'+review_item.review_score+'</td>\
                                        <td class="td-cell text-center padding0">\
                                            <span class="span-comment"  onclick="doOnClickContentView(this)">'+review_content+'</span>\
                                        </td>\
                                    </tr>';
            }

            $('#tbody_star_review_live_data').html(tbody_contents);
        }

        if ( typeof buyTable == 'undefined' ){
            buyTable  = $('#other_buy_table').DataTable();
        }
        else {
            buyTable.fnClearTable( 0 );
            buyTable.fnDraw();
        }
        if ( typeof sellTable == 'undefined' ){
            sellTable  = $('#other_sell_table').DataTable();
        }
        else {
            sellTable.fnClearTable( 0 );
            sellTable.fnDraw();
        }
        if ( typeof starTable == 'undefined' ){
            starTable  = $('#star_table').DataTable();
        }
        else {
            starTable.fnClearTable( 0 );
            starTable.fnDraw();
        }

        $($('#star_table_wrapper .row')[0]).css('display', 'none');
        $($('#other_sell_table_wrapper .row')[0]).css('display', 'none');
        $($('#other_buy_table_wrapper .row')[0]).css('display', 'none');

        doOnFilterBuyData(2, $('#buy_filter_coin').val());
        doOnFilterSellData(2, $('#sell_filter_coin').val());

        filterColumn();
    });
}
function openCity(evt, tabName) {
    var i, tabcontent, tablinks;
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    $('.tabcontent').removeClass('show');
    $('#'+tabName).addClass('show');
    evt.currentTarget.className += " active";
}
function myBuyFunction() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("myBuyInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myBuyTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = $(tr[i]).attr('coin-symbol');
        if (td) {
            if (td.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
function mySellFunction() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("mySellInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("mySellTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = $(tr[i]).attr('coin-symbol');
        if (td) {
            if (td.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
function doOnOtherBuyClick(other_match_id, buyJsonObj) {
    if ( typeof buyJsonObj == 'string' ) buyJsonObj = JSON.parse(buyJsonObj);
    $('.score_radio').prop('checked', false);
    $('#score_ranking').html('');
    //document.getElementById('div_modal').style.display='block';
    $('#div_modal').modal('show');
    $('input[name="match_id"]').val(other_match_id);

    $('#review_icon').attr('src', 'https://s2.coinmarketcap.com/static/img/coins/64x64/'+buyJsonObj.coin_id+".png");
    $('#review_icon').attr('width', "32px");
    $('#review_icon').attr('height', "32px");

    $('#review_price').html('$'+buyJsonObj.purchased_price);
    $('#review_price').addClass('color-red');

    $('#review_quantity').html(buyJsonObj.quantity+" "+buyJsonObj.coin_symbol);
    $('#review_amount').attr('max', buyJsonObj.quantity);
    $('#review_amount').val( buyJsonObj.quantity );

    $('input[name="order_side"]').val("buy");
    $('input[name="review_score"]').val(0);

    $('#img_user_avatar').attr('src', buyJsonObj.user_avatar)
    $('#span_user_full_name').html(buyJsonObj.user_full_name)
    //console.log(buyJsonObj);
}
function doOnCloseModal() {
    $('#div_modal').modal('hide');
    //$('#div_modal').fadeOut(500);
}
function doOnOtherSellClick(other_match_id, sellJsonObj) {
    if ( typeof sellJsonObj == 'string' ) sellJsonObj = JSON.parse(sellJsonObj);
    $('.score_radio').prop('checked', false);
    $('#score_ranking').html('');

    //document.getElementById('div_modal').style.display='block';
    $('#div_modal').modal('show');
    $('input[name="match_id"]').val(other_match_id);

    $('#review_icon').attr('src', 'https://s2.coinmarketcap.com/static/img/coins/64x64/'+sellJsonObj.coin_id+".png");
    $('#review_icon').attr('width', "32px");
    $('#review_icon').attr('height', "32px");

    $('#review_price').html('$'+sellJsonObj.purchased_price);
    $('#review_price').addClass('color-green');

    $('#review_quantity').html(sellJsonObj.quantity+" "+sellJsonObj.coin_symbol);
    $('#review_amount').attr('max', sellJsonObj.quantity);
    $('#review_amount').val( sellJsonObj.quantity );
    $('input[name="review_score"]').val(0);
    $('input[name="order_side"]').val("sell");
}
function doOnReviewSubmit() {
    serialized = $('#form_review').serialize();

    //$('input[name="review_score"]').val($('input[name="ranking"]').val());
    if ($('input[name="review_score"]').val() == '0') {
        alert("Please select review score.")
        return;
    }
    else{
        $('#subject').html('');
        subject.value='';
        $('#div_modal').modal('hide');
        $.post('/coinmatchreview?'+serialized, function(resp){
            if ( resp.result == 'ok' ) {
                $('#submit_modal').modal('show');
                doOnGetLiveData();
            }
        });
        console.log(serialized);
        //$('#form_review').submit();
    }
    //console.log(serialized);
}
function doOnMyBuyListClick(match_id) {

}
function doOnMySellListClick(match_id) {
}

function doOnClickBuyerForSell(side, obj) {
    if ( global_biz == undefined ){
        send_user_id = $(obj).attr('buyer_id');
        g_side = side;
        $('#div_buy_modal').modal('show');
        if ($(obj).attr('td-info') == undefined) return;
        if ( typeof $(obj).attr('td-info') == 'undefined' ){
            selectedTdInfo = $(obj).attr('td-info');
        }
        else{
            selectedTdInfo = JSON.parse($(obj).attr('td-info'));
        }

    }
    else {
        $('#alarm_modal').modal('show');
    }
}
function doOnSendSellInterestedSubmit(side) {
    if ( global_biz == undefined ) {
        if ( send_user_id!= undefined ) {
            $('#div_buy_modal').modal('hide');
            $.getJSON('/sendinterestmsg/'+send_user_id, {side: g_side}, function(resp){
                if ( resp.result == 'ok') {
                    //$('#confirm_modal').modal('show');
                    $('#popup_modal').modal('show');
                }
            });
        }
    }

}
function doOnShowAddReview() {
    if ( selectedTdInfo != undefined ) {
        buyJsonObj = selectedTdInfo;
        if ( typeof buyJsonObj == 'string' ) buyJsonObj = JSON.parse(buyJsonObj);
        $('.score_radio').prop('checked', false);
        $('#score_ranking').html('');
        //document.getElementById('div_modal').style.display='block';
        $('#div_buy_modal').modal('hide');
        $('#div_modal').modal('show');
        $('input[name="match_id"]').val(buyJsonObj.match_id);

        $('#review_icon').attr('src', 'https://s2.coinmarketcap.com/static/img/coins/64x64/'+buyJsonObj.coin_id+".png");
        $('#review_icon').attr('width', "32px");
        $('#review_icon').attr('height', "32px");

        $('#review_price').html('$'+buyJsonObj.purchased_price);
        $('#review_price').addClass('color-red');

        $('#review_quantity').html(buyJsonObj.quantity+" "+buyJsonObj.coin_symbol);
        $('#review_amount').attr('max', buyJsonObj.quantity);
        $('#review_amount').val( buyJsonObj.quantity );

        $('input[name="order_side"]').val(g_side);
        $('input[name="review_score"]').val(0);

        $('#img_user_avatar').attr('src', buyJsonObj.user_avatar)
        $('#span_user_full_name').html(buyJsonObj.user_full_name)
    }
}
function doOnShowSellReviewComment() {
    $('#div_buy_modal').modal('hide');
    $('#div_buy_message_modal').modal('show');
}

function doOnSendMessage() {
    var _comment = comment.value;
    $.getJSON('/sendmsg/'+send_user_id, {side: g_side, message: _comment}, function(resp){
        if ( resp.result == 'ok' ) {
            $('#div_buy_message_modal').modal('hide');
            $('#comment').val('');
        }
    });
}
function doOnCloseThisModal() {

    $('#div_buy_message_modal').modal('hide');
    //$('#div_buy_message_modal').show().on('hidden.bs.modal', hideCompleted);
    //function hideCompleted() {
    //    hideInProgress = false;
    //    if (showModalId) {
    //        showModal(showModalId);
    //    }
    //    showModalId = '';
    //    $("#div_buy_message_modal").off('hidden.bs.modal');
    //}
}

function doOnClickContentView(dom) {
    $('#content-modal-p').html($(dom).html());
    $('#content_modal').modal('show');
}
