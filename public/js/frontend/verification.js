var coin_id = undefined;
var coin_name;
var wallet_address;

$(document).ready(function(){
    $('a[data-parent="#accordion"]').click(function(){
        if ( $(this).attr('aria-expanded') == undefined || $(this).attr('aria-expanded') == 'false' ){
            $('.collapse').collapse('hide');
            $(this).collapse("show");
        }

    });
    //$('#coin_list').css('display', 'block')
    $('#coin_list').collapse();
    $('#frm_wallet_verification').css('display', 'none');
    $('#btn-check-balance').click(doOnCheckWalletBalance);
    $('#btn-add-crypto-curtrency').click(doOnAddCryptoCurrency);
    $('#btn-add-crypto-curtrency').css('display', 'none');
});

function myFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";

        }
    }
}
function doOnSelectToken(obj) {
    $('.a-erc20-token').removeClass('a-active');
    $(obj).addClass('a-active');
    contract_address = $(obj).attr('addr');
    contract_decimals = parseInt($(obj).attr('decimals'));
    erc20_name = obj.innerHTML;
}
function myFunctionFilterCoin() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput_coin");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myCoinUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";

        }
    }
}
function doOnSelectCoin(obj) {
    $('.a-erc20-token').removeClass('a-active');
    $(obj).addClass('a-active');
    coin_id = $(obj).attr('coin-id');
    coin_name = obj.innerHTML;
    $('#frm_wallet_verification').css('display', 'none');
    $('input[name="wallet_address"]').val('');
    $('#wallet_balance').prop('balance', 0);
    $('#btn-add-crypto-curtrency').css('display', 'none');
}
function doOnCheckWalletBalance() {
    wallet_address = $('input[name="wallet_address"]').val();
    var usd_price = 0;
    var eth_balance = 0;
    var price_url = "https://api.coinmarketcap.com/v1/ticker/";
    switch ( coin_id ) {
        case 'bitcoin':
            var url = "https://chain.so/api/v2/get_address_balance/BTC/"+wallet_address;
            $.getJSON(url, function(resp){
                console.log(resp);
                if ( resp.status == 'success' ) {
                    eth_balance = resp.data.confirmed_balance;
                    $.getJSON(price_url+coin_id+"/", function(price_resp){
                        //console.log(price_resp);
                        usd_price = parseFloat(price_resp[0].price_usd);

                        $('label[for="wallet_balance"]').html("Bitcoin "+$('label[for="wallet_balance"]').html());
                        $('label[for="current_price"]').html("Bitcoin "+$('label[for="current_price"]').html());
                        $('label[for="wallet_value"]').html("Bitcoin "+$('label[for="wallet_value"]').html());

                        $('#h-title').html('Bitcoin Wallet Verification Information');
                        setValue(eth_balance, usd_price, 'BTC');


                        $('#frm_wallet_verification').css('display', 'block');
                    });
                }
            });
            break;
        case 'ethereum':
            var url = 'https://api.etherscan.io/api?module=account&action=balance&address='+wallet_address+'&tag=latest&apikey=WFZ7MNHJ64M5N1IWWR9FT84A5IZATEDGIN';
            $.getJSON(url, function(resp){
                //console.log(resp);
                if ( resp.message == 'OK' ) {
                    eth_balance = Decimal.div(resp.result, 1000000000000000000).toNumber();
                    $.getJSON(price_url+coin_id+"/", function(price_resp){
                        //console.log(price_resp);
                        usd_price = parseFloat(price_resp[0].price_usd);

                        $('label[for="wallet_balance"]').html("Ethereum "+$('label[for="wallet_balance"]').html());
                        $('label[for="current_price"]').html("Ethereum "+$('label[for="current_price"]').html());
                        $('label[for="wallet_value"]').html("Ethereum "+$('label[for="wallet_value"]').html());
                        $('#h-title').html('Ethereum Wallet Verification Information');
                        setValue(eth_balance, usd_price, 'ETH');

                        $('#frm_wallet_verification').css('display', 'block');
                    });
                }
            });
            break;
        default:
            $('#coin_alarm').modal('show');
            break;
    }
}
function setValue(_balance, _usd_price, unit) {
    $('#wallet_balance').val(_balance+unit);
    $('#current_price').val('$'+_usd_price);
    $('#wallet_value').val('$'+Decimal.mul(_usd_price, _balance).toNumber());
    $('#wallet_balance').prop('balance', _balance);
    $('#current_price').prop('usd_price', _usd_price);
    $('#wallet_value').prop('wallet_value', Decimal.mul(_usd_price, _balance).toNumber());
    $('#btn-add-crypto-curtrency').css('display', '');
}
function doOnAddCryptoCurrency() {

    balance = $('#wallet_balance').prop('balance');
    if ( balance == 0 ) return;
    usd_price = $('#current_price').prop('usd_price');
    wallet_value = $('#wallet_value').prop('wallet_value');

    $('input[name="currency_name"]').val(coin_name);
    $('input[name="quantity"]').val(balance);
    $('input[name="price"]').val(usd_price);
    $('input[name="wallet_address"]').val(wallet_address);
    $('input[name="wallet_value"]').val(wallet_value);
    //$('input[name="wallet_address"]').val(wallet_address);
    console.log(balance, usd_price, wallet_value, coin_id, coin_name, wallet_address);
    $('#frm_post').submit();
}