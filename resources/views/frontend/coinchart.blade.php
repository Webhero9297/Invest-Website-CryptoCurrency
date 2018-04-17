@extends('layouts.frontend')

@section('content')
    <style>
        .control-label {
            font-family: Montserrat-light;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" />
    <script src="{{ asset('./assets/jsLib/datatable/jquery.datatable.js') }}" ></script>
    <script src="{{ asset('./assets/jsLib/datatable/datatable.bootstrap.js') }}" ></script>
    <div class="container-fluid padding0">
        <div class="div-auth-register" id="home" style="padding-top:100px;">
            <div class="container" style="padding-bottom: 50px;">
                <div id="coinchart_detail" class="panel panel-default" style="border:none;background: transparent;" >
                    <div class="div-panel-heading">
                        <img src="https://files.coinmarketcap.com/static/widget/coins_legacy/32x32/{{ $coinData['id'] }}.png" width="32px" height="32px" />
                        {{ $coinData['name'] }}
                        <a class="a-add-to-portfolio" href="/addcryptocurrencyex/{{ $coinData['name'] }}" ></a>
                    </div>
                    <div class="panel-body panel-table">
                        <table id="coin_chart" class="table table-striped table-bordered" style="width:100%;">
                            <thead>
                            <tr>
                                <th class="td-cell td-grey">Current Price</th>
                                <th class="td-cell td-grey" width="22%">24H change %</th>
                                <th class="td-cell td-grey" width="22%">1H Change %</th>
                                <th class="td-cell td-grey" width="22%">Mkt Cap</th>
                                <th class="td-cell td-grey">Vol.24H</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="td-cell">${{ number_format($coinData['price_usd'], 2, '.', ',') }}</td>
                                    <td class="td-cell {{ ( $coinData['percent_change_24h'] > 0) ? "color-green" : "color-red" }}">
                                        {{ $coinData['percent_change_24h'] }}%
                                    </td>
                                    <td class="td-cell {{ ( $coinData['percent_change_1h'] > 0) ? "color-green" : "color-red" }}">
                                        {{ $coinData['percent_change_1h'] }}%
                                    </td>
                                    <td class="td-cell">${{ number_format($coinData['market_cap_usd'], 2, '.', ',') }}</td>
                                    <td class="td-cell">${{ number_format($coinData['24h_volume_usd'], 2, '.', ',') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12">
                                <script type="text/javascript">
                                    baseUrl = "https://widgets.cryptocompare.com/";
                                    var scripts = document.getElementsByTagName("script");
                                    var embedder = scripts[ scripts.length - 1 ];
                                    (function (){
                                        var appName = encodeURIComponent(window.location.hostname);
                                        if(appName==""){appName="local";}
                                        var s = document.createElement("script");
                                        s.type = "text/javascript";
                                        s.async = true;
                                        var theUrl = baseUrl+'serve/v3/coin/chart?fsym=<?php echo $coinData['symbol'];?>&tsyms=USD,CAD,AUD,GBP,EUR';
                                        s.src = theUrl + ( theUrl.indexOf("?") >= 0 ? "&" : "?") + "app=" + appName;
                                        embedder.parentNode.appendChild(s);
                                    })();
                                </script>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script src="{{ asset('./js/frontend/editprofile.js') }}"></script>
@endsection
