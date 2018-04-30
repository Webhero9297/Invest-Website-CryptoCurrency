$(document).ready(function() {
    $('.py-4').css('height', '100%!important');
    window.setInterval(function(){
        $.getJSON('/getcoinlivechartdata/'+coin_id, function(resp){
            var trHTML = '';
            var pString = '';
            ( resp.percent_change_24h > 0) ? pString = "color-green" : pString = "color-red";
            ( resp.percent_change_1h > 0) ? qString = "color-green" : qString = "color-red";
            trHTML = '<tr>\
                                <td class="td-cell">$'+resp.price_usd+'</td>\
                                <td class="td-cell '+pString+'">\
                                '+resp.percent_change_24h+'%\
                                </td>\
                                <td class="td-cell '+qString+'">\
                                '+resp.percent_change_1h+'%\
                                </td>\
                                <td class="td-cell">'+resp.mkt_cap_usd+'</td>\
                            <td class="td-cell">'+resp.h24_vol_usd+'</td>\
                        </tr>';
            $('#tbody_content').html(trHTML);
        });
    }, 30000);
});
