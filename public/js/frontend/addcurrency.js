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
});

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