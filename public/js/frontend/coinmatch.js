var quantity = purchased_price = 0;
var remove_match_id = undefined;
var availableTags;
$(document).ready(function(){
    datepicker = $('#purchased_date').datepicker({format: 'yyyy-mm-dd'}).on('changeDate', function(ev) {
        datepicker.hide();
    }).data('datepicker');
    $('input[data-list]').each(function () {
        availableTags = $('#' + $(this).attr("data-list")).find('option').map(function () {
            return this.value;
        }).get();
        $(this).autocomplete({
            source: availableTags,
            select: function(e, ui) {
                doOnSelectCoinData( ui.item.value );
            }
        }).on('search', function () {
            if ($(this).val() === '') {
                $(this).autocomplete('search', ' ');
            }
        });
    });
    $('#quantity').on("keypress keyup blur",function (event) {
        var _V = $(this).val().replace(/[^0-9\.]/g,'');
        if ( _V.length >=2 && _V.substr(0,1) == '0' && _V.substr(1,1) != '.' ) {
            _V = _V.substr(1, _V.length-1);
        }
        $(this).val(_V);
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        quantity = parseFloat(_V||0);

        doOnCalcTotalCost();
    });
    $('#purchased_price').on('keypress keyup blur', function(event){
        var _V = $(this).val().replace(/[^0-9\.]/g,'');
        if ( _V.length >=2 && _V.substr(0,1) == '0' && _V.substr(1,1) != '.' ) {
            _V = _V.substr(1, _V.length-1);
        }
        $(this).val(_V);
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
        purchased_price = parseFloat(_V||0);
        doOnCalcTotalCost();

    });

    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });
    $('[data-toggle="popover"]').popover({
        trigger: 'hover',
        'placement': 'top'
    });

    $('.py-4').css('height', '');

    $('#select_coin_list').bind('click', function(){
    });
});
function doOnSelectCoinData(selected_coin_name) {
    for( i in coinData ) {
        coin_data = coinData[i];
        if ( coin_data.name == selected_coin_name ) {
            price = coin_data.price_usd;
            $('#current_price').html('Current Price: ~ $'+price);
        }
    }
}
function doOnClickSellSide() {
    quantity = parseFloat($('input[name="quantity"]').val());
    coin_name = $('input[name="coin_name"]').val();
    if ( coin_name == "" ) return;
    if ( quantity == 0 ) return;
    $.getJSON('/getinvestedcoinamount/'+coin_name, function(resp){
        var diff = Decimal.sub(resp.invested, resp.sold);
        if ( diff < quantity ) {
            var title = "You dont have enough balance in your portfolio for this cryptocurrency.";
            $('.modal-body').html(title);
            $('#myConfirm').modal('show');
            $('input[name="quantity"]').attr('max', resp.quantity);
            return;
        }
        else{
            $('#form_detail').submit();
        }
    });
}
function doOnChangeSideStatus(order_side) {
    (order_side == 'buy') ? side=0: side = 1;
    $('input[name="order_side"]').val(side);
}
function doOnClickSaveDetails() {
    if ( parseFloat($('#quantity').val()) == 0 ) {
        $('.modal-body').html("Sorry! Please enter quantity.");
        $('#myConfirm').modal('show');
        return;
    }
    if ( parseFloat($('#purchased_price').val()) == 0 ) {
        $('.modal-body').html("Sorry! Please enter purchased price.");
        $('#myConfirm').modal('show');
        return;
    }
    if ( $('input[name="order_side"]').val() == 1 ) {
        doOnClickSellSide();
    }
    else{
        $('#form_detail').submit();
    }

}
function doOnDelete(match_id) {
    $('#myModal').modal('show');
    remove_match_id = match_id;
}
function doOnRequestDelete() {
    $('#myModal').modal('hide');
    $.get('deletecoinmatch/'+remove_match_id, function(resp){
        $('#myConfirm').modal('show');
        window.location.reload();
    });
}
function doOnUpdate(jsonObj) {
    jsonObj = JSON.parse(jsonObj);
    $('input[name="coin_name"]').val(jsonObj.coin_name);
    $('input[name="quantity"]').val(jsonObj.quantity);
    $('input[name="purchased_price"]').val(jsonObj.purchased_price);
    $('input[name="purchased_date"]').val(jsonObj.purchased_date);

    $('label.btn-primary').removeClass('active');
    if ( jsonObj.order_side == 0 ) {
        $('#label_buy').addClass('active');
    }
    else{
        $('#label_sell').addClass('active');
    }
    $('input[name="match_id"]').val(jsonObj.match_id);
    $('input[name="order_side"]').val(jsonObj.order_side);

    doOnCalcTotalCost();
}
function doOnChangeInputValue( tagId, direction ) {
    var _inputVal = parseFloat($('#'+tagId).val());
    if ( direction == 'down' && _inputVal == 0 ) return;
    if ( direction == 'up' ) {
        $('#'+tagId).val(Decimal.add(_inputVal,1))
    }
    else{
        if ( Decimal.sub(_inputVal,1) < 0 ) return;
        $('#'+tagId).val(Decimal.sub(_inputVal,1));
    }

    doOnCalcTotalCost();
}
function doOnCalcTotalCost() {
    purchased_price = $('#purchased_price').val()*1;
    quantity = $('#quantity').val()*1;
    var _totalCost = Decimal.mul(quantity, purchased_price);
    $('#label_total_cost').html(_totalCost.toString());
}
