var pos = 0;
var selected_currency = 'USD';
$(document).ready(function(){
    $('.btn-page').click(function(){
        pos = $(this).attr('page-pos');
        $('.btn-page').removeClass('btn-page-active');
        $(this).addClass('btn-page-active');
        loadLiveChart( pos );
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

    loadLiveChart();

    $('#tfoot').css('display', 'none');
});
function doOnLoadLiveChart() {
    $('#tfoot').css('display', 'none');
    $('#tbody_coin_live_data').html('<tr><td colspan="5" align="center"><div class="loader"></div></td></tr>');
    loadLiveChart();
}
function loadLiveChart() {
    $.get('/coinpage/'+pos, {currency : selected_currency }, function(coin_live_datas){
        tbodyHTML = '';
        for( i=0;i<coin_live_datas.length; i++ ) {
            coin_data = coin_live_datas[i];
            ( coin_data.percent_change_24h > 0) ? colorstyle = "color-green" : colorstyle = "color-red";
            ( coin_data.percent_change_24h > 0 ) ? img_tag = "coin_up" : img_tag = "coin_down";
            tbodyHTML += '<tr style="border-bottom: 1px solid #555555;">\
                                    <td class="td-cell td-coin-icon td-grey padding0">'+(pos*100+i+1)+'</td>\
                                    <td class="td-cell td-grey padding0" coin-name="'+coin_data.name+'">\
                                        <img src="https://files.coinmarketcap.com/static/widget/coins_legacy/32x32/'+coin_data.id+'.png" width="32px" height="32px" />\
                                        &nbsp;&nbsp;&nbsp;\
                                        <a class="a-white" href="'+window.origin+'/coinchart/'+coin_data.id+'" >'+coin_data.name+'</a>\
                                    </td>\
                                    <td class="td-cell td-grey padding0">'+coin_data.current_price+'</td>\
                                    <td class="td-cell td-grey padding0">'+coin_data.market_cap_usd+'</td>\
                                    <td class="td-cell ' + colorstyle + ' td-grey padding0">' + coin_data.percent_change_24h +
                '<img src="./assets/images/icon/' + img_tag + '.png" width="24px" height="12px" />\
                                    </td>\
                              </tr>';
        }
        $('#tbody_coin_live_data').html(tbodyHTML);
        $('#tfoot').css('display', '');
        $('.py-4').css('height', '100%');
    });
}
function doOnchangeCurrency(currency) {
    //currency = $(this).val();
    selected_currency = currency;
    $('#tbody_coin_live_data').html('<tr><td colspan="5" align="center"><div class="loader"></div></td></tr>');
    loadLiveChart();
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