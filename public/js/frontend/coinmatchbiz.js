var sell_modal, buy_modal;
$(document).ready(function(){
    $('#other_sell_table').DataTable({});
    $('#other_buy_table').DataTable({});
    $('#star_table').DataTable({});
    $('input.score_radio').click(function(){
        $('#score_ranking').html($(this).val());
        $('input[name="review_score"]').val($(this).val());
    });
    $('.py-4').css('height', '100%');
    $('#other_sell_table thead th:last').css('width', '82px');
    $('#other_buy_table thead th:last').css('width', '82px');
    window.setInterval(function(){
        doOnGetLiveData();
    }, 10000);
});
function doOnGetLiveData() {
    $.getJSON('/getorderdata/'+AuthUser, function(resp){
        var other_buy_data = resp.other_buy_data;
        if ( other_buy_data ) {
            tbody_contents = '';
            for(i=0;i<other_buy_data.length;i++) {
                buy_item = other_buy_data[i];
                tbody_contents += '<tr class="tr-live" style="border-bottom: 1px solid #555555;">\
                                            <td class="td-cell text-center padding0">' + (i + 1) + '</td>\
                                            <td class="td-cell text-center padding0">\
                                                <img src="' + buy_item.user_avatar + '" style="border-radius: 50%;object-fit: cover;" width="32px" height="32px" />\
                                                <span>' + buy_item.user_full_name + '</span>\
                                            </td>\
                                            <td class="td-cell text-center padding0">\
                                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/' + buy_item.coin_id + '.png" width="32px" height="32px" />\
                                                <span>' + buy_item.coin_name + '</span>\
                                            </td>\
                                            <td class="td-cell color-green text-center padding0">$' + buy_item.purchased_price + '</td>\
                                            <td class="td-cell text-center padding0">' + buy_item.quantity + '</td>';

                if (AuthUser != 'undefined') {
                    if ( buy_item.enable_status == 1 ){
                        tbody_contents += '<td class="td-cell text-center padding0">\
                                              <button class="sell-button" onclick=\'doOnOtherBuyClick("' + buy_item.match_id + '", ' + JSON.stringify(buy_item) + ')\'>Sell</button>\
                                           </td>';
                    }
                    else {
                        tbody_contents += '<td class="td-cell text-center padding0">\
                                           </td>';
                    }
                }
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
                                            <td class="td-cell text-center padding0">\
                                                <img src="' + sell_item.user_avatar + '" style="border-radius: 50%;object-fit: cover;" width="32px" height="32px" />\
                                                <span>' + sell_item.user_full_name + '</span>\
                                            </td>\
                                            <td class="td-cell text-center padding0">\
                                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/' + sell_item.coin_id + '.png" width="32px" height="32px" />\
                                                <span>' + sell_item.coin_name + '</span>\
                                            </td>\
                                            <td class="td-cell color-red text-center padding0">$' + sell_item.purchased_price + '</td>\
                                            <td class="td-cell text-center padding0">' + sell_item.quantity + '</td>';

                if (AuthUser != 'undefined') {
                    //sell
                    tbody_contents += '<td class="td-cell text-center padding0">\
                                               <button class="buy-button" onclick=\'doOnOtherBuyClick("' + sell_item.match_id + '", ' + JSON.stringify(sell_item) + ')\'>Buy</button>\
                                           </td>';

                }
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
                                            <span class="span-comment">'+review_content+'</span>\
                                        </td>\
                                    </tr>';
            }
            $('#tbody_star_review_live_data').html(tbody_contents);
        }
        $('.py-4').css('height', '100%');
        $('#other_sell_table thead th:last').css('width', '82px');
        $('#other_buy_table thead th:last').css('width', '82px');
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
    document.getElementById('div_modal').style.display='block';
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
    $('#div_modal').fadeOut(500);
}
function doOnOtherSellClick(other_match_id, sellJsonObj) {
    if ( typeof sellJsonObj == 'string' ) sellJsonObj = JSON.parse(sellJsonObj);
    $('.score_radio').prop('checked', false);
    $('#score_ranking').html('');
    document.getElementById('div_modal').style.display='block';
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
        $('#form_review').submit();
    }
    //console.log(serialized);
}
function doOnMyBuyListClick(match_id) {

}
function doOnMySellListClick(match_id) {
}