var pos = 0;
var selected_currency = 'USD';
var coin_symbol_data = [];
var socket;
var current_fiat_symbol = 'USD';
var current_fiat_rate = 1;
var live_rates = {};
var table;
$(document).ready(function(){


    doOnGetRate(function(rates){
        live_rates = rates;
        current_fiat_rate = live_rates[current_fiat_symbol];

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

        loadLiveChart();
        window.setTimeout(function(){
            window.setInterval(function(){
                doOnGetRate(function(rates) {
                    live_rates = rates;
                });
            }, 60000);
        }, 60000);
        //
        socket = io.connect('https://coincap.io');
    });
});
function doOnGetRate(callback) {
    $.getJSON('http://coincap.io/exchange_rates', function(resp){
        callback(resp.rates);
    });
}
function doOnLoadLiveChart() {
    $('#tbody_coin_live_data').html('<tr><td colspan="5" align="center" style="padding-top:50px;"><div class="loader"></div></td></tr>');
    loadLiveChart();
}
function loadLiveChart() {
    $('#tbody_coin_live_data').html('<tr><td colspan="5" align="center" style="padding-top:30px;"><div class="loader"></div></td></tr>');
    $.get('/coinpage', {currency : selected_currency }, function(coin_live_datas){
        doOnRenderTable(coin_live_datas);
    });
}
function doOnRenderTable(coin_live_datas) {
    tbodyHTML = '';
    for( i=0;i<coin_live_datas.length; i++ ) {
        coin_data = coin_live_datas[i];
        coinSymbol = coin_data.name.split(' ').join('');
        coin_symbol_data.push(coinSymbol);
        ( coin_data.percent_change_24h > 0) ? colorstyle = "color-green" : colorstyle = "color-red";
        ( coin_data.percent_change_24h > 0 ) ? img_tag = "coin_up" : img_tag = "coin_down";
        ( coin_data.current_price*1 > 100 ) ? dc = 2 : dc = 4;
        tbodyHTML += '<tr class="tr-live" style="border-bottom: 1px solid #555555;" id="tr_'+coin_data.symbol+'">\
                                    <td class="td-cell td-coin-icon td-grey padding0">'+(pos*100+i+1)+'</td>\
                                    <td class="td-cell td-grey padding0" coin-name="'+coin_data.name+'">\
                                        <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/'+coin_data.img_id+'.png" width="32px" height="32px" />\
                                        &nbsp;&nbsp;&nbsp;\
                                        <a class="a-white" href="'+window.origin+'/coinchart/'+coin_data.id+'" >'+coin_data.name+'</a>\
                                    </td>\
                                    <td class="td-cell td-cell-live td-grey padding0"><span class="live_data" id="price_'+coinSymbol+'">'+accounting.formatMoney(coin_data.current_price, '', dc, ",", ".")+'</span></td>\
                                    <td class="td-cell td-grey padding0"><span id="mktcap_'+coinSymbol+'">'+accounting.formatMoney(coin_data.market_cap_usd, '', 0, ",", ".")+'</span></td>\
                                    <td class="td-cell ' + colorstyle + ' td-grey padding0"><span id="h24_'+coinSymbol+'">' + accounting.formatMoney(coin_data.percent_change_24h, '', 2, ",", ".") +
            '</span><img src="./assets/images/icon/' + img_tag + '.png" width="24px" height="12px" />\
                                    </td>\
                              </tr>';
    }

    $('#tbody_coin_live_data').html(tbodyHTML);
    $('#tfoot').css('display', '');
    $('.py-4').css('height', '100%');

    table = $('#coin_table').DataTable({
        "lengthMenu": [[100], [100]]
    });

    $('#myInput').keyup( function() {
        table.draw();
    } );

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var filterStr = $('#myInput').val();
            if ( data[1].toUpperCase().indexOf(filterStr.toUpperCase()) > -1 ) {
                return true;
            }
            else {
                return false;
            }
        }
    );

    $('#coin_table_length').css('display', 'none');
    $('#coin_table_filter').css('display', 'none');

    socket.on('trades', function (tradeMsg) {
        socket_data = tradeMsg.message;
        coin_symbol = socket_data.msg.long.split(' ').join('').split(current_fiat_symbol).join('');
        if ( coin_symbol_data.indexOf(coin_symbol)!= -1 ) {
            var htmlObj = $('#price_'+coin_symbol).html();
            if ( htmlObj != undefined ) {
                var prevV = $('#price_'+coin_symbol).html().split(',').join('');
                ( socket_data.msg.price*1 > 100 ) ? dc = 2 : dc = 4;
                $('#price_'+coin_symbol).html(accounting.formatMoney(socket_data.msg.price*current_fiat_rate, '', dc, ",", "."));
                ( prevV*1 <= socket_data.msg.price*1 ) ? sString = "bg-green" : sString = "bg-red";
                $('#price_'+coin_symbol).attr('class', 'live_data');
                $('#price_'+coin_symbol).addClass(sString);
                $('#mktcap_'+coin_symbol).html(accounting.formatMoney(socket_data.msg.mktcap*current_fiat_rate, '', 0, ",", "."));
                $('h24_'+coin_symbol).html(accounting.formatMoney(socket_data.msg.cap24hrChange, '', 2, ",", "."));
            }

        }
    });
}
function doOnchangeCurrency(currency) {
    current_fiat_symbol = currency;
    current_fiat_rate = live_rates[current_fiat_symbol];

    selected_currency = currency;
    $('#tbody_coin_live_data').html('<tr><td colspan="5" align="center"><div class="loader"></div></td></tr>');
    loadLiveChart();
}

function myFilter(event) {
    var input, filter;
    filter = document.getElementById("myInput").value;
        $.get('/filter/'+filter, {currency : selected_currency }, function(filter_resp){
            doOnRenderTable(filter_resp);
        });
}
function myFunction() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("tbody_coin_live_data");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            if ($(td).attr('coin-name').toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

(function ( $ ) {
    var elActive = '';
    $.fn.selectCF = function( options ) {

        // option
        var settings = $.extend({
            color: "#FFF", // color
            backgroundColor: "#0297bf", // background
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

            html += "<ul class='selectCF'>";
            html += 	"<li style='margin-top: 12px;'>";
            html += 		"<span class='arrowCF fa fa-chevron-right a-gold' style='"+style+"'></span>";
            html += 		"<span class='titleCF a-gold' style='"+style+"; width:"+width+"px'>"+title+"</span>";
            html += 		"<span class='searchCF a-gold' style='"+style+"; width:"+width+"px'><input style='color:"+settings.color+"' /></span>";
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
            doOnchangeCurrency(value);

            event_change.html(value+' : '+text);


        }
    });
    $( ".test" ).selectCF({
        color: "#FFF",
        backgroundColor: "#663052",
    });
})