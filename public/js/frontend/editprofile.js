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
                        $'+total_data.total_profit_loss+'</span>&nbsp;&nbsp;\
                        <span class="'+style+'" style="font-size:16px;">(\
                        '+total_data.total_profit_loss_percentage+'%)</span>\
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

        //$('.py-4').css('height', '100%');
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


/*********************************************   Custom Select Start  *******************************************************/
(function ( $ ) {
    var elActive = '';
    $.fn.selectCF = function( options ) {

        // option
        var settings = $.extend({
            color: "#FFF", // color
            backgroundColor: "#0297bf00", // background
            change: function( ){ }, // event change
        }, options );

        return this.each(function(){

            var selectParent = $(this);
            list = [],
                html = '';

            //parameter CSS
            var width = $(selectParent).width();

            $(selectParent).hide();
            if( $(selectParent).children('option').length == 0 ){ return; }
            $(selectParent).children('option').each(function(){
                if( $(this).is(':selected') ){ s = 1; title = $(this).text(); }else{ s = 0; }
                list.push({
                    value: $(this).attr('value'),
                    text: $(this).text(),
                    selected: s,
                })
            })

            // style
            var style = " background: "+settings.backgroundColor+"; color: "+settings.color+" ";

            var title_style = "background: #0297bf00; color: #FFF; width: calc(100% - 45px); border: 1px solid #808080; border-bottom-left-radius: 3px; border-top-left-radius: 3px;";
            var arrow_style = "background: "+settings.backgroundColor+"; color: "+settings.color+"; border: none;";
            var search_style = "background: #0297bf00; color: #FFF; width: 46px; border: 1px solid #808080; border-bottom-right-radius: 3px; border-top-right-radius: 3px;";
            html += "<ul class='selectCF'>";
            html += 	"<li style='margin-top: 12px;'>";
            html += 		"<span class='titleCF a-gold' style='"+title_style+"'>"+title+"</span>";
            html += 		"<span class='arrowCF fa fa-chevron-right a-gold' style='"+arrow_style+"'></span>";
            html += 		"<span class='searchCF a-gold' style='"+search_style+"'></span>";
            html += 		"<ul>";
            $.each(list, function(k, v){ s = (v.selected == 1)? "selected":"";
                html += 			"<li value="+v.value+" class='"+s+"'>"+v.text+"</li>";})
            html += 		"</ul>";
            html += 	"</li>";
            html += "</ul>";
            $(selectParent).after(html);
            var customSelect = $(this).next('ul.selectCF'); // add Html
            var seachEl = $(this).next('ul.selectCF').children('li').children('.searchCF');
            var seachElOption = $(this).next('ul.selectCF').children('li').children('ul').children('li');
            var seachElInput = $(this).next('ul.selectCF').children('li').children('.searchCF').children('input');

            // handle active select
            $(customSelect).unbind('click').bind('click',function(e){
                e.stopPropagation();
                if($(this).hasClass('onCF')){
                    elActive = '';
                    $(this).removeClass('onCF');
                    $(this).removeClass('searchActive'); $(seachElInput).val('');
                    $(seachElOption).show();
                }else{
                    if(elActive != ''){
                        $(elActive).removeClass('onCF');
                        $(elActive).removeClass('searchActive'); $(seachElInput).val('');
                        $(seachElOption).show();
                    }
                    elActive = $(this);
                    $(this).addClass('onCF');
                    $(seachEl).children('input').focus();
                }
            })

            // handle choose option
            var optionSelect = $(customSelect).children('li').children('ul').children('li');
            $(optionSelect).bind('click', function(e){
                var value = $(this).attr('value');
                if( $(this).hasClass('selected') ){
                    //
                }else{
                    $(optionSelect).removeClass('selected');
                    $(this).addClass('selected');
                    $(customSelect).children('li').children('.titleCF').html($(this).html());
                    $(selectParent).val(value);
                    settings.change.call(selectParent); // call event change
                }
            })

            // handle search
            $(seachEl).children('input').bind('keyup', function(e){
                var value = $(this).val();
                if( value ){
                    $(customSelect).addClass('searchActive');
                    $(seachElOption).each(function(){
                        if( $(this).text().search(new RegExp(value, "i")) < 0 ) {
                            // not item
                            $(this).fadeOut();
                        }else{
                            // have item
                            $(this).fadeIn();
                        }
                    })
                }else{
                    $(customSelect).removeClass('searchActive');
                    $(seachElOption).fadeIn();
                }
            })

        });
    };
    $(document).click(function(){
        if(elActive != ''){
            $(elActive).removeClass('onCF');
            $(elActive).removeClass('searchActive');
        }
    })
}( jQuery ));

$(function(){
    var event_change = $('#event-change');
    $( ".select" ).selectCF({
        change: function(){
            var value = $(this).val();
            var text = $(this).children('option:selected').html();
            console.log(value+' : '+text);
            $('#tfoot').css('display', 'none');
            //doOnchangeCurrency(value);

            event_change.html(value+' : '+text);


        }
    });
    $( ".test" ).selectCF({
        color: "#FFF",
        backgroundColor: "#663052",
    });
})
/*********************************************   Custom Select  END   *******************************************************/