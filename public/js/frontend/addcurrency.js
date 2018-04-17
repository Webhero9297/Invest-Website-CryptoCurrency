var quantity = purchased_price = 0;
$(document).ready(function(){
    datepicker = $('#purchased_date').datepicker({format: 'yyyy-mm-dd'}).on('changeDate', function(ev) {
        datepicker.hide();
    }).data('datepicker');
    $('input[data-list]').each(function () {
        var availableTags = $('#' + $(this).attr("data-list")).find('option').map(function () {
            return this.value;
        }).get();
        $(this).autocomplete({
            source: availableTags
        }).on('search', function () {
            if ($(this).val() === '') {
                $(this).autocomplete('search', ' ');
            }
        });
    });
    $('#quantity').on('keyup', function(ev){
        quantity = parseFloat($(this).val()||0);
        if ( ev.keyCode != 190 && ev.keyCode != 110 ) {
            if ($(this).val().search('.')!=-1)
                $(this).val(parseFloat($(this).val())||0);
        }
        doOnCalcTotalCost();
    });
    $('#purchased_price').on('keyup', function(ev){
        purchased_price = parseFloat($(this).val()||0);
        if ( ev.keyCode != 190 && ev.keyCode != 110 ) {
            if ($(this).val().search('.')!=-1)
                $(this).val(parseFloat($(this).val())||0);
        }
        doOnCalcTotalCost();

    });
});

function doOnChangeInputValue( tagId, direction ) {
    var _inputVal = parseFloat($('#'+tagId).val());
    if ( direction == 'down' && _inputVal == 0 ) return;
    ( direction == 'up' ) ? $('#'+tagId).val(Decimal.add(_inputVal,1)) : $('#'+tagId).val(Decimal.sub(_inputVal,1));

    doOnCalcTotalCost();
}
function doOnCalcTotalCost() {
    purchased_price = $('#purchased_price').val()*1;
    quantity = $('#quantity').val()*1;
    var _totalCost = Decimal.mul(quantity, purchased_price);
    $('#label_total_cost').html(_totalCost.toString());
}