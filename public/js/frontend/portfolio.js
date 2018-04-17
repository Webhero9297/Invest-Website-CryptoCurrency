var sort_direct = {"invest": 1, "capital": 1, "profit": 1};
var sort_cols = {"invest": 2, "capital": 3, "profit": 4};
$(document).ready(function(){
    loadLivePortfolioData();

    //window.setTimeout(function(){
        window.setInterval(function(){
            loadLivePortfolioData();
        }, 50000);
    //}, 5000);

    $('.span-sort').click(function(){
        event = $(this);
        doOnSortTable(event);
    });
});

function loadLivePortfolioData() {
    $.get('/getliveportfolios', function(live_portfolios) {
        var trHTML = '';
        for( i in live_portfolios ) {
            live_data = live_portfolios[i];
            coinIconHtml = '';
            if (live_data.coin_ids.length>0) {
                for( j in live_data.coin_ids ) {
                    coinIconHtml += '<img src="https://files.coinmarketcap.com/static/widget/coins_legacy/32x32/'+live_data.coin_ids[j]+'.png" width="32px" height="32px" />';
                }
            }
            if ( parseFloat(live_data.total_profit_loss) < 0 ) style=" color-red "; else style=" color-green";
            trHTML += '<tr style="border-bottom: 1px solid #555555;">\
                                    <td class="td-cell td-coin-icon">\
                                        <img src="'+ live_data.avatar+'" width="32px" height="32px" />\
                                    </td>\
                                    <td class="td-cell">\
                                    <a class="a-white" href="/detailportfolio/'+live_data.user_id+'" >'+live_data.full_name+'</a>\
                                </td>\
                                <td class="td-cell">$' + live_data.invested_capital+'</td>\
                                <td class="td-cell">$' + live_data.current_value+'</td>\
                                <td class="td-cell '+style+'">$' + live_data.total_profit_loss+'</td>\
                                <td class="td-cell ">'+coinIconHtml+'</td>\
                       </tr>';

        }
        $('#tbody_content').html(trHTML);
        //$($('#example_wrapper')[0].childNodes[0]).css('display', 'none')
        //$($('#example_wrapper')[0].childNodes[1]).css('width', '100%')
        //$($('#example_wrapper')[0].childNodes[2]).css('display', 'none')

        //sortTable();
    });
}
function doOnSortTable($tag) {
    var _direct = $tag.attr('data-sort');
    sort_direct[_direct] = 1 - sort_direct[_direct];
    if (sort_direct[_direct] == 0) {
        $tag.html( '<i class="fa fa-sort-amount-asc"></i>' );
        sortTable(sort_cols[_direct], 'asc');
    }
    else{
        $tag.html('<i class="fa fa-sort-amount-desc"></i>');
        sortTable(sort_cols[_direct], 'desc');
    }
}
function sortTable(_col, _direction) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("tbody_content");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.getElementsByTagName("TR");
        for (i = 0; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[_col];
            y = rows[i + 1].getElementsByTagName("TD")[_col];
            if (_direction == 'asc'){
                if (MoneyToNumber(x.innerHTML) > MoneyToNumber(y.innerHTML)) {
                    shouldSwitch= true;
                    break;
                }
            }
            else{
                if (MoneyToNumber(x.innerHTML) < MoneyToNumber(y.innerHTML)) {
                    shouldSwitch= true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}
function MoneyToNumber(moneyString) {
    return parseFloat(moneyString.split('$').join('').split(',').join(''));
}