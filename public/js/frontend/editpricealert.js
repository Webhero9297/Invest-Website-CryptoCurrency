var quantity = purchased_price = 0;
var remove_detail_id;
$(document).ready(function(){
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
    $('#limit_price').on('keyup', function(ev){
        quantity = parseFloat($(this).val()||0);
        if ( ev.keyCode != 190 && ev.keyCode != 110 ) {
            if ($(this).val().search('.')!=-1)
                $(this).val(parseFloat($(this).val())||0);
        }
    });

    $('.alert-method').click(function(){
        var chk_id = $(this).attr('for');
        var _status = !$('#'+chk_id).is(':checked');
        if ( _status == true ){
            $('input[name="'+$('#'+chk_id).attr('field')+'"]').val(1);
        }
        else{
            $('input[name="'+$('#'+chk_id).attr('field')+'"]').val(0);
        }
    });

    var element = document.getElementById('coinchart_detail');
    new ResizeSensor(element, function() {
        $('.py-4').css('height', '100%');
    });

});

function doOnChangeInputValue( tagId, direction ) {
    var _inputVal = parseFloat($('#'+tagId).val());
    if ( direction == 'down' && _inputVal == 0 ) return;
    ( direction == 'up' ) ? $('#'+tagId).val(Decimal.add(_inputVal,1)) : $('#'+tagId).val(Decimal.sub(_inputVal,1));
}
function doOnClickSave() {
    coinName = $('#currency_name').val();
    coin_id = coin_arr[coinName];
    $('input[name="coin_id"]').val(coin_id);

    $('#frm_price_alert').submit();
}
function doOnClickEdit(jsonObj) {
    $('input[name="coin_id"]').val(jsonObj.coin_id);
    $('input[name="detail_id"]').val(jsonObj.id);
    $('input[name="limit_price"]').val(jsonObj.limit_price);
    $('input[name="coin_name"]').val(jsonObj.coin_name);
    $('input[name="audio_alert"]').val(jsonObj.audio_alert);
    $('input[name="email_alert"]').val(jsonObj.email_alert);

    if ( jsonObj.email_alert == 1 ) {
        $('#box-2').attr('checked', true);
    }
    else{
        $('#box-2').attr('checked', false);
    }
    if ( jsonObj.audio_alert == 1 ) {
        $('#box-1').attr('checked', true);
    }
    else{
        $('#box-1').attr('checked', false);
    }
}
function doOnDelete(detail_id) {
    remove_detail_id = detail_id;
}
function doOnRequestDelete() {
    $('#myModal').modal('hide');
    $.get('deletepricealert/'+remove_detail_id, function(resp){
        $('#myConfirm').modal('show');
        window.location.reload();
    });
}