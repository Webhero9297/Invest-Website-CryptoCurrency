var sell_modal, buy_modal;
$(document).ready(function(){
    $('#other_sell_table').DataTable({
    });
    $('#other_buy_table').DataTable({
    });
    $('input.score_radio').click(function(){
        $('#score_ranking').html($(this).val());
    });
});
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
    //console.log(buyJsonObj);
}
function doOnOtherSellClick(other_match_id, sellJsonObj) {
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
    $('input[name="order_side"]').val("sell");
}
function doOnReviewSubmit() {
    serialized = $('#form_review').serialize();
    $('#form_review').submit();
    //console.log(serialized);
}
function doOnMyBuyListClick(match_id) {

}
function doOnMySellListClick(match_id) {
}