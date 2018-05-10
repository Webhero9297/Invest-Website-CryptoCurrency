var remove_detail_id = undefined;
var default_avatar = undefined;
var pos = 0;
$(document).ready(function(){
    (function ($) {
        $('.spinner .btn:first-of-type').on('click', function() {
            $('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
        });
        $('.spinner .btn:last-of-type').on('click', function() {
            $('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
        });
    })(jQuery);

    $("#custom_avatar").change(function(){
        readURL(this);
    });


    $('.img-avatar').click(function(){
        $('.img-avatar').removeClass('selected');
        $(this).addClass('selected');
        $('input[name="default_avatar"]').val($(this).attr('src'));
    });
    $('.img-avatar').on('dblclick', function() {
        $('.img-avatar').removeClass('selected');
        $(this).addClass('selected');
        $('input[name="default_avatar"]').val($(this).attr('src'));
        $('form').submit();
    });

    doOnLoadLiveProfileCurrencyData();

    window.setInterval(function(){
        doOnLoadLiveProfileCurrencyData();
    }, 10000);


    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });
    $('[data-toggle="popover"]').popover({
        trigger: 'hover',
        'placement': 'top'
    });

    $('.a-close-account').click(function(){
        $('#confirmCloseThisAccount').modal('show');
    });
});
function doOnLoadLiveProfileCurrencyData() {
    $.ajax('/getliveprofilecurrencydata').done(function(resp){
        total_data = resp.total;
        currency_data = resp.currency_data;

        ( total_data.total_profit_loss_percentage>0 ) ? style= "color-green": style="color-red";
        ( total_data.sign*1==1 ) ? p_style= "color-green": p_style="color-red";

        theadHTML = '<th class="td-cell" colspan="2">Total Coins: '+total_data.coins+ '</th>\
                     <th class="td-cell" colspan="3">Invested Capital: $'+total_data.invested_capital+'</th>\
                     <th class="td-cell text-left" colspan="3">\
                     Total Profit/Loss: \
                        <span class="'+p_style+'" style="font-size:16px;">\
                        $'+total_data.total_profit_loss+'</span>&nbsp;&nbsp;(\
                        <span class="'+style+'" style="font-size:16px;">\
                        '+total_data.total_profit_loss_percentage+'%</span>\
                        )\
                     </th>';

        trHTML = '';
        for( i in currency_data ) {
            currency = currency_data[i];
            (parseFloat(currency.profit_loss)>0) ? profitStyle = "color-green": profitStyle = "color-red";
            (parseFloat(currency.percent_change_1h)>0) ? h1Style = "color-green": h1Style = "color-red";
            (parseFloat(currency.percent_change_24h)>0) ? h24Style = "color-green": h24Style = "color-red";
            trHTML += '<tr style="border-bottom: 1px solid #555555;">\
                            <td class="td-cell td-coin-icon">\
                            <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/' + currency.slug+'.png" width="32px" height="32px" />\
                            </td>\
                            <td class="td-cell">'+currency.name+"(" + currency.symbol + ')</td>\
                            <td class="td-cell">'+ currency.price_usd+'</td>\
                            <td class="td-cell">'+ currency.total_cost+ '<br/>'+currency.quantity+" "+currency.symbol+" @ "+currency.purchased_price+'</td>\
                            <td class="td-cell '+profitStyle+'">$'+currency.profit_loss+'</td>\
                            <td class="td-cell '+h1Style +'">'+currency.percent_change_1h+'%</td>\
                            <td class="td-cell '+h24Style +'">'+currency.percent_change_24h+'%</td>\
                            <td class="td-cell td-action">\
                                <a href="/editcryptocurrency/'+currency.detail_id+'" class="a-currency-edit"  data-toggle="popover" data-content="Edit"/>\
                                <a onclick="doOnDelete(\''+currency.detail_id+'\')" class="a-currency-delete"  data-toggle="popover" data-content="Remove"></a>\
                            </td>\
                        </tr>';
        }
        $('#thead_title').html(theadHTML);
        $('#tbody_content').html(trHTML);

        $('.py-4').css('height', '');

        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });
        $('[data-toggle="popover"]').popover({
            trigger: 'hover',
            'placement': 'top'
        });
    })
    .fail(function(fail_resp){
        $('.py-4').css('height', '100%');
    });
}
function doOnClick( status_type ) {
    ( status_type=='public' ) ? $type = 0 : $type = 1;
    $.get('/changeprofilestatus/'+$type, function(resp){

    });
}
function doOnDelete(detail_id) {
    $('#myModal').modal('show');
    remove_detail_id = detail_id;
}
function doOnRequestDelete() {
    $('#myModal').modal('hide');
    $.get('deletecryptocurrency/'+remove_detail_id, function(resp){
        $('#myConfirm').modal('show');
        window.location.reload();
    });
}
function doOnRequestCloseThisAccount() {
    $('#confirmCloseThisAccount').modal('hide');
    $.get('closethisaccount', function(resp){
        if ( resp == 'ok') {
            window.location.href=window.origin+"/home";
        }

    });
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img_user_avatar').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

